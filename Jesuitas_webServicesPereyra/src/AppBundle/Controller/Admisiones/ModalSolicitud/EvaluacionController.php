<?php

namespace AppBundle\Controller\Admisiones\ModalSolicitud;

use AppBundle\DB\DbmAdmisiones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class EvaluacionController extends FOSRestController
{
    /**
     * datos iniciales para el dictamen
     * @Rest\Post("/api/Solicitud/ValidacionDatos/Evaluaciones/", name="ValidacionDatosEvaluaciones")
     */
    public function validacionDatosEvaluacionesAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);
            if (empty($Solicitud)) {
                return new View("Error no se encontro la solicitud admision" . $data['solicitudid'], Response::HTTP_NOT_FOUND);
            }
            $dbm->getConnection()->beginTransaction();

            $Evaluacion = $dbm->getEvaluacionesAsignadas($Solicitud->getSolicitudadmisionid());
            $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $data['solicitudid']))->getCicloid();

            if (empty($Evaluacion) && $data["edicion"]) {
                //Modo Lux
                if ($data['version'] == 1) {
                    $this->agregarEvaluaciones($Solicitud, $ciclo->getCicloid(), $dbm);
                    $this->agregarEntrevistas($Solicitud, $ciclo->getCicloid(), $dbm);
                }
                //Modo Ciencias
                if ($data['version'] == 2) {
                    $Bloque = $dbm->getConfiguracionBloquesConsulta(array('gradoid' => $Solicitud->getGradoid()->getGradoid(), 'cicloid' => $ciclo->getCicloid()));
                    foreach ($Bloque as $b) {
                        $entrevista = $dbm->getEntrevistaBloque($b, $Solicitud->getGradoid()->getGradoid());
                        $bloque = $b;
                        if ($entrevista) {
                            break;
                        }
                    }
                    $evaluaciones = array();
                    if ($entrevista) {
                        $evaluaciones = $dbm->getEvaluacionBloque($bloque["bloquegradoid"], $entrevista["usuarioid"], $Solicitud->getGradoid()->getGradoid(), null);

                        $eventos = array_merge(array($entrevista), $evaluaciones);
                        foreach ($eventos as $e) {
                            $evaluacioSolicitudEntity = new \AppBundle\Entity\Evaluacionporsolicitudadmision();
                            $evaluacioSolicitudEntity->setSolicitudadmisionid($Solicitud);
                            $evaluacioSolicitudEntity->setEventoevaluacionid($dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $e["eventoevaluacionid"]));
                            $evaluacioSolicitudEntity->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $e["evaluacionid"]));
                            $evaluacioSolicitudEntity->setEstatusevaluacionid($dbm->getRepositorioById('Estatusevaluacion', 'estatusevaluacionid', 1));
                            $dbm->saveRepositorio($evaluacioSolicitudEntity);
                        }
                    }
                }
            }
            $dbm->getConnection()->commit();
            $Evaluacion = $Evaluacion ? $Evaluacion : $dbm->getEvaluacionesAsignadas($Solicitud->getSolicitudadmisionid());
            //Evaluaciones falantes
            $EvaluacionesFaltantes = $dbm->getEvaluacionesFaltante($Solicitud->getSolicitudadmisionid(), $Solicitud->getGradoid()->getGradoid(), $ciclo->getCicloid());
            if (!$Evaluacion) {
                return new View(
                    array(
                        'mensaje' => "No se han encontrado citas disponibles",
                        'evaluacionesFaltantes' => $EvaluacionesFaltantes
                    ),
                    Response::HTTP_OK
                );
            }
            return new View(
                array(
                    'evaluaciones' => $Evaluacion,
                    'evaluacionesFaltantes' => $EvaluacionesFaltantes
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    //LUX
    public function agregarEvaluaciones($solicitudEntity, $ciclo, $dbm)
    {
        //Se obtiene todos los proximos eventos de evaluaciones que no sean entrevistas
        $evaluacionesGrado = $dbm->getEvaluacionesByGradoandCiclo($solicitudEntity->getGradoid()->getGradoid(), $ciclo);
        foreach ($evaluacionesGrado as $a) {
            //Verificamos si el examen del evento ya fue asignado a la evaluacion
            $EventoSolicitud = $dbm->getByParametersRepositorios(
                'Evaluacionporsolicitudadmision',
                array(
                    'solicitudadmisionid' => $solicitudEntity->getSolicitudadmisionid(),
                    'evaluacionid' => $a["EvaluacionId"],
                )
            );
            if (!$EventoSolicitud) {
                //Obtenemos el total de solicitudes que han sido asignadas al evento
                $totalSolicitudesEvento = sizeof($dbm->getRepositoriosById('Evaluacionporsolicitudadmision', 'eventoevaluacionid', $a["EventoEvaluacionId"]));
                $eventoEvaluacionEntity = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $a["EventoEvaluacionId"]);
                if ($eventoEvaluacionEntity->getCupo() > $totalSolicitudesEvento) {
                    $evaluacioSolicitudEntity = new \AppBundle\Entity\Evaluacionporsolicitudadmision();
                    $evaluacioSolicitudEntity->setSolicitudadmisionid($solicitudEntity);
                    $evaluacioSolicitudEntity->setEventoevaluacionid($eventoEvaluacionEntity);
                    $evaluacioSolicitudEntity->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $a["EvaluacionId"]));
                    $evaluacioSolicitudEntity->setEstatusevaluacionid($dbm->getRepositorioById('Estatusevaluacion', 'estatusevaluacionid', 1));
                    $dbm->saveRepositorio($evaluacioSolicitudEntity);
                }
            }
        }
    }

    //LUX
    public function agregarEntrevistas($solicitudEntity, $cicloId, $dbm)
    {
        $EvaluadoresOrdenAlta = array();
        $EvaluadoresOrdenAltaTemp = array();
        $usuarios = $dbm->getEntrevistaSolicitud($cicloId, $solicitudEntity->getGradoid()->getGradoid());

        $i = 0;
        while (!$valido && $i < sizeof($usuarios)) {
            $eventoAlta = $dbm->getAltaEntrevistaByEvaluador($cicloId, $solicitudEntity->getGradoid()->getGradoid(), $usuarios[$i]["UsuarioId"]);
            $i++;
            if ($eventoAlta) {
                $evaluacioSolicitudEntity = new \AppBundle\Entity\Evaluacionporsolicitudadmision();
                $evaluacioSolicitudEntity->setSolicitudadmisionid($solicitudEntity);
                $evaluacioSolicitudEntity->setEventoevaluacionid($dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $eventoAlta['EventoEvaluacionId']));
                $evaluacioSolicitudEntity->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $eventoAlta['EvaluacionId']));
                $evaluacioSolicitudEntity->setEstatusevaluacionid($dbm->getRepositorioById('Estatusevaluacion', 'estatusevaluacionid', 1));
                $dbm->saveRepositorio($evaluacioSolicitudEntity);
                $valido = true;
            }
        }
    }

    /**
     * Obtenemos eventos del mismo examen con cupo disponible para cambiar la cita
     * @Rest\Get("/api/Solicitud/evaluaciones/update/", name="evaluacionesCupoUpdateValidacion")
     */
    public function solicitudUpdateCupoAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);
            $evaluacionesaArray = $dbm->getEvaluacionesCupoValidacionDatos($data);
            return new View(array('evaluaciones' => $evaluacionesaArray), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e, Response::HTTP_OK);
        }
    }

    /**
     * Actualiza las evaluaciones asignadas a la solicitud
     * @Rest\Post("/api/Solicitud/Evaluaciones/update/" , name="evaluacionesCupoSaveValidacion")
     */
    public function UpdateEvaluacionPorsolicitud()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
            if (empty($Solicitud)) {
                return new View("Error no se encontro la solicitud", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            $eventoEvaluacionid = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $data['eventoevaluacionid']);

            if (!empty($data['evaluacionporsolicitudadmisionid'])) {
                $evaluacioPorSolicitud = $dbm->getRepositorioById('Evaluacionporsolicitudadmision', 'evaluacionporsolicitudadmisionid', $data['evaluacionporsolicitudadmisionid']);
                $evaluacioPorSolicitud->setEventoevaluacionid($eventoEvaluacionid);
            } else {
                $evaluacioPorSolicitud = new \AppBundle\Entity\Evaluacionporsolicitudadmision();
                $evaluacioPorSolicitud->setEventoevaluacionid($eventoEvaluacionid);
                $evaluacioPorSolicitud->setEstatusevaluacionid($dbm->getRepositorioById('Estatusevaluacion', 'estatusevaluacionid', 1));
                $evaluacioPorSolicitud->setSolicitudadmisionid($Solicitud);
                $evaluacioPorSolicitud->setEvaluacionid($eventoEvaluacionid->getEvaluacionid());
            }
            $dbm->saveRepositorio($evaluacioPorSolicitud);

            if ($data['tipo'] == 2) {
                $evaluacioPorSolicitud = $dbm->getRepositoriosById('Evaluacionporsolicitudadmision', 'eventoevaluacionid', $data['eventoevaluacionid']);
                $eventoEvaluacionid->setCupo(sizeof($evaluacioPorSolicitud));
                $dbm->saveRepositorio($eventoEvaluacionid);
            }

            //Ciencias
            if ($eventoEvaluacionid->getBloquegradoevaluacionid()) {
                $eventos = $dbm->getByParametersRepositorios(
                    'Eventoevaluacion',
                    array('bloquegradoevaluacionid' => $eventoEvaluacionid->getBloquegradoevaluacionid(), 'usuarioid' => $eventoEvaluacionid->getUsuarioid())
                );
                foreach ($eventos as $e) {
                    if ($e->getEventoevaluacionid() != $eventoEvaluacionid->getEventoevaluacionid()) {
                        $evaluacionporsolicitud = $dbm->getOneByParametersRepositorio(
                            "Evaluacionporsolicitudadmision",
                            array("evaluacionid" => $e->getEvaluacionid(), "solicitudadmisionid" => $Solicitud)
                        );
                        if ($evaluacionporsolicitud) {
                            $evaluacionporsolicitud->setEventoevaluacionid($e);
                        } else {
                            $evaluacionporsolicitud = new \AppBundle\Entity\Evaluacionporsolicitudadmision();
                            $evaluacionporsolicitud->setEventoevaluacionid($e);
                            $evaluacionporsolicitud->setEstatusevaluacionid($dbm->getRepositorioById('Estatusevaluacion', 'estatusevaluacionid', 1));
                            $evaluacionporsolicitud->setSolicitudadmisionid($Solicitud);
                            $evaluacionporsolicitud->setEvaluacionid($e->getEvaluacionid());
                        }
                        $dbm->saveRepositorio($evaluacionporsolicitud);
                    }
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View("No se pudo guardar el registro ", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Funcion para obtener los eventos por folio de admision (Lux)
     * @Rest\Get("/api/Solicitud/Eventos/Folio", name="ValidacionDatosEventosFolio")
     */
    public function getValidacioEventosByFolio()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'folio', $data['folio']);
        if (empty($Solicitud)) {
            return new View("Error no se encontro ninguna solicitud con el folio " . $data['folio'], Response::HTTP_NOT_FOUND);
        }
        $ciclo = $dbm->getRepositorioById('Ciclo', 'siguiente', 1);
        $Eventos = $dbm->getEventosbyFolio($data['folio'], $ciclo->getCicloid(), $Solicitud->getGradoid()->getGradoid());
        return new View(array("eventos" => $Eventos), Response::HTTP_OK);
    }

    /**
     * Funcion para eliminar evento de la solicitud
     * @Rest\Delete("/api/Solicitud/Evaluaciones/{id}", name="removeEventoEvaluacion")
     */
    public function remoEventoEvaluacionAction($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);
            if (empty($Solicitud)) {
                $return = array("mensaje" => "Error no se encontro ninguna solicitud " . $id);
                return new View($return, Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->removeManyRepositorio('Evaluacionporsolicitudadmision', 'solicitudadmisionid', $id);

            $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $id))->getCicloid();
            $EvaluacionesFaltantes = $dbm->getEvaluacionesFaltante($Solicitud->getSolicitudadmisionid(), $Solicitud->getGradoid()->getGradoid(), $ciclo->getCicloid());
            $dbm->getConnection()->commit();
            return new View(
                array(
                    'msj' => 'Se ha eliminado las evaluaciones asignadas',
                    'evaluacionesFaltantes' => $EvaluacionesFaltantes
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("Una o varias de la evaluaciones ya han sido aplicadas y no es posible eliminarlas", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
