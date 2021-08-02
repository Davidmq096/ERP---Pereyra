<?php

namespace AppBundle\Controller\Admisiones\ModalSolicitud;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmAdmisiones;
use AppBundle\Entity\AdFactoresapoyoporsolicitudadmision;
use AppBundle\Entity\Cartaporsolicitud;
use AppBundle\Entity\Dictamen;
use AppBundle\Entity\Evaluacion;
use AppBundle\Entity\Evaluacionporsolicitudadmision;
use AppBundle\Entity\Eventoevaluacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class DictamenController extends FOSRestController
{

    /**
     * datos iniciales para el dictamen
     * @Rest\Get("/api/Solicitud/Dictaminacion/{id}", name="SolicitudDictaminacion")
     */
    public function indexDictaminacion($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);

            $cartas = $dbm->getCartasDictamen($Solicitud->getGradoid()->getGradoid());
            $estatus = $dbm->getRepositoriosById('Estatussolicitud', 'dictaminacion', 1);
            $niveles = $dbm->getRepositorios('Nivel');
            $grados = $dbm->getRepositorios('Grado');
            $evaluador = $dbm->getRepositoriosById('Usuarioevaluadorporgrado', 'gradoid', $Solicitud->getGradoid()->getGradoid());
            $factorapoyo = $dbm->BuscarFactoresapoyo(array("gradoid" => $Solicitud->getGradoid()->getGradoid(), "activo" => true));

            $dictaminacion = $dbm->getRepositoriosById('Dictamen', 'solicitudadmisionid', $id);
            $cartassolicitud = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $id);
            $entregaresultados = $dbm->getCitaEntregaResultados($id, 5);
            $solicitudfactores = $dbm->getRepositoriosById('AdFactoresapoyoporsolicitudadmision', 'solicitudadmisionid', $id);

            return new View(array(
                "niveles" => $niveles,
                "grados" => $grados,
                "cartas" => $cartas,
                "estatus" => $estatus,
                "factorapoyo" => $factorapoyo,
                "dictaminacion" => $dictaminacion,
                "cartassolicitud" => $cartassolicitud,
                "evaluador" => $evaluador,
                "entregaresultados" => $entregaresultados,
                "solicitudfactores" => $solicitudfactores), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para guardar la dictamiancion
     * @Rest\Post("/api/Solicitud/Dictaminacion/{id}", name="SolicitudDictaminacionSave")
     */
    public function saveSolicitudDictaminacion($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);
            $Estatus = $dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', $data['estatusid']);
            $solicitudextemporanea = $Solicitud->getSolicitudextemporanea();

            if ($Solicitud->getEstatussolicitudid()->getAceptado() || !$Estatus->getAceptado()) {
                return $this->dictamen($data, $Estatus, $Solicitud, $data["cartaid"]);
            } else {
                if ($Estatus->getAceptado()) {
                    $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $id))->getCicloid();
                    $cupo = $dbm->getByParametersRepositorios('Cupoadmision', array("cicloid" => $ciclo->getCicloid(), "gradoid" => $Solicitud->getGradoid()->getGradoid()));
                    if (empty($cupo) && !$solicitudextemporanea) {
                        return new View("El cupo no se ha configurado.", Response::HTTP_PARTIAL_CONTENT);
                    }
                    $Soloicitudesaceptadas = $dbm->getAceptadosByCicloGrado($ciclo->getCicloid(), $Solicitud->getGradoid()->getGradoid());
                    if ((sizeof($Soloicitudesaceptadas) >= $cupo[0]->getCupo()) && !$solicitudextemporanea ) {
                        return new View("El cupo para " . $Solicitud->getGradoid()->getGrado() . "° de " .
                            $Solicitud->getGradoid()->getNivelid()->getNombre() . " ya se ha cubierto.
                        Se han admitido " . sizeof($Soloicitudesaceptadas) . " solicitudes.", Response::HTTP_PARTIAL_CONTENT);
                    } else {
                        return $this->dictamen($data, $Estatus, $Solicitud, $data["cartaid"]);
                    }
                }
            }

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }
    public function dictamen($data, $Estatus, $Solicitud, $cartaid = null)
    {
        $dbm = $this->get("db_manager");
        $dbmAdmision = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

        $dbm->getConnection()->beginTransaction();
        //Borramos las cartas asignadas
        $dbm->removeManyRepositorio('Cartaporsolicitud', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid());

        $mensaje = "Se ha guardado el registro";
        if ($cartaid) {
            $Cartaporsolicitud = new Cartaporsolicitud();
            $Cartaporsolicitud->setCartaid($dbm->getRepositorioById('Formato', 'formatoid', $cartaid));
            $Cartaporsolicitud->setSolicitudadmisionid($Solicitud);
            $dbm->saveRepositorio($Cartaporsolicitud);
            $cartasSolicitud = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid());
        } else {
            $cartasVal = $dbmAdmision->getCartasDictamenTipo($Solicitud->getGradoid()->getGradoid(), $Estatus->getAceptado() == 1 ? 7 : 8);
            if ($cartasVal) {
                $Cartaporsolicitud = new Cartaporsolicitud();
                $Cartaporsolicitud->setCartaid($dbm->getRepositorioById('Formato', 'formatoid', $cartasVal[0]->getFormatoid()));
                $Cartaporsolicitud->setSolicitudadmisionid($dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid()));
                $dbm->saveRepositorio($Cartaporsolicitud);
                $cartasSolicitud = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid());
            } else {
                $mensaje = 'No se ha configurado carta de '. ($Estatus->getAceptado() == 1 ? 'aceptación' : 'rechazo');
            }
        }

        $dictamen = new Dictamen();
        $dictamen->setDictamen($Estatus->getEstatus());
        $dictamen->setMotivo($data['motivo']);
        $dictamen->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']));
        $dictamen->setSolicitudadmisionid($Solicitud);
        $dictamen->setFecharegistro(new \DateTime());
        $dbm->saveRepositorio($dictamen);

        $Solicitud->setEstatussolicitudid($Estatus);
        $dbm->saveRepositorio($Solicitud);

        $dbm->getConnection()->commit();
        $dictaminacion = $dbm->getRepositoriosById('Dictamen', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid());

        return new View(array(
            "Valor" => $cartasVal,
            "cartas" => $cartasSolicitud,
            "dictaminacion" => $dictaminacion,
            'estatus' => $Estatus,
            "msj" => $mensaje), Response::HTTP_OK);

    }

    /**
     * Funcion para guardar cartas a solicitud
     * @Rest\Post("/api/Solicitud/Dictaminacion/Cartas/{id}", name="SolicitudDictaminacionCartasSave")
     */
    public function saveCartasbySolicitudction($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;

            $dbm->getConnection()->beginTransaction();

            $Cartaporsolicitud = new Cartaporsolicitud();
            $Cartaporsolicitud->setCartaid($dbm->getRepositorioById('Formato', 'formatoid', $datos['cartaid']));
            $Cartaporsolicitud->setSolicitudadmisionid($dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id));
            $dbm->saveRepositorio($Cartaporsolicitud);

            $dbm->getConnection()->commit();
            $cartassolicitud = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $id);
            return new View(array("msj" => "Se ha guardado el registro", "cartassolicitud" => $cartassolicitud), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para eliminar carta a solicitud
     * @Rest\Delete("/api/Solicitud/Dictaminacion/Cartas/{id}", name="SolicitudDictaminacionCartasRemove")
     */
    public function deleteCartasbySolicitudction($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $dbm->getConnection()->beginTransaction();

            $cartas = $dbm->getRepositorioById('Cartaporsolicitud', 'cartaporsolicitudid', $id);
            $id = $cartas->getSolicitudadmisionid()->getSolicitudadmisionid();
            $dbm->removeRepositorio($cartas);

            $dbm->getConnection()->commit();
            $cartassolicitud = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $id);
            return new View(array("msj" => "Se ha eliminado el registro", "cartassolicitud" => $cartassolicitud), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Agregar cita entrega de evaluacion (Tipo de evaluacio - evaluacion - evento - eventoSolicitud)
     * @Rest\Post("/api/Solicitud/Entregaresultados/{id}", name="saveEntregaResultados")
     */
    public function saveEntregaResultados($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);

            $dbm->getConnection()->beginTransaction();
            //Agregamos un evaluacion de Tipo -Cita entrega de resultados
            $Evaluacion = new Evaluacion();
            $Evaluacion->setTipoevaluacionid($dbm->getRepositorioById('Tipoevaluacion', 'tipoevaluacionid', 5));
            $Evaluacion->setCicloid($dbm->getRepositorioById('Ciclo', 'siguiente', 1));
            $Evaluacion->setNombre('Cita entrega de resultados');
            $Evaluacion->setActivo(0);
            $dbm->saveRepositorio($Evaluacion);
            //Agregamos un evento
            $Eventoevaluacion = new Eventoevaluacion();
            $Eventoevaluacion->setEvaluacionid($Evaluacion);
            $Eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'personaid', $data['evaluadorid']));
            $fecha = $data['fecha']['date'];
            $Eventoevaluacion->setFechainicio(new \DateTime($fecha['day'] . '-' . $fecha['month'] . '-' . $fecha['year']));
            $Eventoevaluacion->setHorainicio(new \DateTime($data['hora']));
            $Eventoevaluacion->setCupo(1);
            $dbm->saveRepositorio($Eventoevaluacion);
            //Ligamo al evento creado con la solicitud
            $Evaluacionporsolicitudadmision = new Evaluacionporsolicitudadmision();
            $Evaluacionporsolicitudadmision->setEventoevaluacionid($Eventoevaluacion);
            $Evaluacionporsolicitudadmision->setEstatusevaluacionid($dbm->getRepositorioById('Estatusevaluacion', 'estatusevaluacionid', 1));
            $Evaluacionporsolicitudadmision->setSolicitudadmisionid($Solicitud);
            $Evaluacionporsolicitudadmision->setEvaluacionid($Evaluacion);
            $dbm->saveRepositorio($Evaluacionporsolicitudadmision);
            //Agregamo Carta de entrega de Resultados
            $Cartas = $dbm->getCartasDictamen($Solicitud->getGradoid()->getGradoid());
            foreach ($Cartas as $c) {
                if ($c->getTipoformatoid()->getTipoformatoid() == 9) {
                    $Cartaporsolicitud = new Cartaporsolicitud();
                    $Cartaporsolicitud->setCartaid($c);
                    $Cartaporsolicitud->setSolicitudadmisionid($Solicitud);
                    $dbm->saveRepositorio($Cartaporsolicitud);
                }
            }
            $dbm->getConnection()->commit();

            $cartassolicitud = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $id);
            $entregaresultados = $dbm->getCitaEntregaResultados($id, 5);

            return new View(array(
                "msj" => 'Se ha guardado el registro.',
                "cartassolicitud" => $cartassolicitud,
                "entregaresultados" => $entregaresultados), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Eliminae cita entrega de evaluacion (Tipo de evaluacio - evaluacion - evento - eventoSolicitud)
     * @Rest\Delete("/api/Solicitud/Entregaresultados/{id}", name="deleteEntregaResultados")
     */
    public function deleteEntregaResultados($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $Evaluacionsolicitud = $dbm->getRepositorioById('Evaluacionporsolicitudadmision', 'evaluacionporsolicitudadmisionid', $id);
            $Solicitudid = $Evaluacionsolicitud->getSolicitudadmisionid()->getSolicitudadmisionid();
            $Cartas = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $Evaluacionsolicitud->getSolicitudadmisionid()->getSolicitudadmisionid());
            foreach ($Cartas as $c) {
                if ($c->getCartaid()->getTipoformatoid()->getTipoformatoid() == 9) {
                    $dbm->removeRepositorio($c);
                }
            }
            $Eventoevaluacion = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $Evaluacionsolicitud->getEventoevaluacionid()->getEventoevaluacionid());
            $Evaluacion = $dbm->getRepositorioById('Evaluacion', 'evaluacionid', $Evaluacionsolicitud->getEvaluacionid()->getEvaluacionid());

            $dbm->getConnection()->beginTransaction();
            $dbm->removeRepositorio($Evaluacionsolicitud);
            $dbm->removeRepositorio($Eventoevaluacion);
            $dbm->removeRepositorio($Evaluacion);
            $dbm->getConnection()->commit();

            $entregaresultados = $dbm->getCitaEntregaResultados($Solicitudid, 5);
            return new View(array("msj" => "Se ha eliminado el registro", "entregaresultados" => $entregaresultados), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Asigna areas a fortalecer a una solicitud
     * @Rest\Post("/api/Solicitud/Areafortalecer/{id}", name="saveAreaFortalecerSolicitud")
     */
    public function saveAreaFortalecer($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;

            $dbm->getConnection()->beginTransaction();
            foreach ($datos["factoresid"] as $f) {
                $entidad = array("factoresapoyoid" => $f, "solicitudadmisionid" => $id);
                $hydrator = new ArrayHydrator($dbm->getEntityManager());
                $Factoressolicitud = $hydrator->hydrate(new AdFactoresapoyoporsolicitudadmision(), $entidad);
                $dbm->saveRepositorio($Factoressolicitud);
            }
            $dbm->getConnection()->commit();

            $solicitudfactores = $dbm->getRepositoriosById('AdFactoresapoyoporsolicitudadmision', 'solicitudadmisionid', $id);
            return new View(array("msj" => "Se ha guardado el registro", "solicitudfactores" => $solicitudfactores), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remueve areas a fortalecer de una solicitud
     * @Rest\Put("/api/Solicitud/Areafortalecer/{id}", name="removeAreaFortalecerSolicitud")
     */
    public function removeAreaFortalecer($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            parse_str(file_get_contents("php://input"), $datos);

            $dbm->getConnection()->beginTransaction();
            foreach ($datos["factoresid"] as $f) {
                $Factoresapoyosolicitud = $dbm->getByParametersRepositorios("AdFactoresapoyoporsolicitudadmision", array("factoresapoyoid" => $f, "solicitudadmisionid" => $id));
                foreach ($Factoresapoyosolicitud as $fs) {
                    $dbm->removeRepositorio($fs);
                }
            }
            $dbm->getConnection()->commit();

            $solicitudfactores = $dbm->getRepositoriosById('AdFactoresapoyoporsolicitudadmision', 'solicitudadmisionid', $id);
            return new View(array("msj" => "Se ha eliminado el registro", "solicitudfactores" => $solicitudfactores), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambio de grado
     * @Rest\Post("/api/Solicitud/CambioGrado/Dictamen", name="CambioGradoDictament")
     */
    public function cambioGradoBySolicitudActionDictmen()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);
            if (empty($Solicitud)) {
                $return = array("mensaje" => "Error no se encontro ninguna solicitud " . $data['solicitudid']);
                return new View($return, Response::HTTP_NOT_FOUND);
            }

            $Solicitud->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']));
            $dbm->saveRepositorio($Solicitud);

            return new View('Se ha guardado el registro', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View("No se pudo actualizar el registro " . $e, Response::HTTP_NOT_FOUND);
        }
    }
}
