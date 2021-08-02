<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\DB\DbmAdmisiones;
use AppBundle\Entity\Eventoevaluacion;
use AppBundle\Entity\Gradoporeventoevaluacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of CalendarioEvaluacionTestController
 *
 * @author inceptio
 */
class CalendarioEvaluacionController extends FOSRestController
{

    /**
     * Retorna una materia por id enviado
     * @Rest\Get("/api/Calendarioevaluacion", name="InicioCalendario")
     */
    public function indexCalendario()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $ciclos = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $niveles = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grados = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $lugar = $dbm->getRepositoriosById('Lugar', 'activo', 1, "nombre");
            $colores = $dbm->getRepositorios('Colorpornivel');
            $evaluador = $dbm->BuscarEvaluador(array());
            $evaluaciones = $dbm->BuscarEvaluacion(array());

            $return = array("evaluaciones" => $evaluaciones,
                'ciclos' => $ciclos,
                "niveles" => $niveles,
                "grados" => $grados,
                'lugar' => $lugar,
                "colores" => $colores,
                'evaluador' => $evaluador);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna un evento de evaluacion por filtros
     * @Rest\Get("/api/Calendarioevaluacion/", name="BuscarEventoEvaluacion")
     */
    public function busarEvaluador()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarCalendario($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Calendarioevaluacion/{id}", name="EliminarEventoEvaluacion")
     */
    public function deleteEventoevaluacion($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $agendado = $dbm->getRepositoriosById('Evaluacionporsolicitudadmision', 'eventoevaluacionid', $id);
            if ($agendado) {
                return new View("Ya se han asignado solicitudes a este evento", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->removeManyRepositorio('Gradoporeventoevaluacion', 'eventoevaluacionid', $id);
            $Eventoevaluacion = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $id);
            $dbm->removeRepositorio($Eventoevaluacion);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Rest\Post("/api/Calendarioevaluacion" , name="GuardarEventoCalendario")
     */
    public function saveEventoEvaluacion()
    {
        try {
            $data = $_REQUEST;
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $filtros = ['fechainicio' => $data['paso1']['fechainicio'], 'fechafin' => $data['paso1']['fechafin'], 'horainicio' => $data['paso1']['horainicio'], 'horafin' => $data['paso1']['horafin'], 'evaluadorid' => $data['paso4']['evaluadorid'], 'nivelid' => $data['paso2']['nivelid'], "tipoeventoid" => 2];

            $diasfestivos = $dbm->BuscarDiaFestivo($filtros);
            if ($diasfestivos) {
                return new View("No se puede crear una evaluación en las fechas seleccionadas ya que coincide con uno o más días festivos del nivel y grado seleccionados", Response::HTTP_PARTIAL_CONTENT);
            }
            $repetidos = $dbm->BuscarCalendario($filtros);
            if ($repetidos) {
                return new View("El evaluador ya tiene un evento registrado en el rango de fecha y hora seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();

            $Eventoevaluacion = new Eventoevaluacion();
            $Eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $data['paso3']['evaluacionid']));
            $Eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $data['paso4']['lugarid']));
            $Eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'personaid', $data['paso4']['evaluadorid']));
            $Eventoevaluacion->setFechainicio(new \DateTime($data['paso1']['fechainicio']));
            $Eventoevaluacion->setFechafin(new \DateTime($data['paso1']['fechafin']));
            $Eventoevaluacion->setHorainicio(new \DateTime($data['paso1']['horainicio']));
            $Eventoevaluacion->setHorafin(new \DateTime($data['paso1']['horafin']));
            $Eventoevaluacion->setCupo($data['paso4']['cupo']);
            $dbm->saveRepositorio($Eventoevaluacion);

            foreach ($data['paso2']['gradoid'] as $grado) {
                $Gradoporevento = new Gradoporeventoevaluacion();
                $Gradoporevento->setEventoevaluacionid($Eventoevaluacion);
                $Gradoporevento->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                $dbm->saveRepositorio($Gradoporevento);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo word del archivo adjunto
     * @Rest\Get("/api/Calendarioevaluacion/Validaciondatos/", name="EventoCalendarioValidacion")
     */
    public function solicitudComentarioAction()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);
        if (empty($Solicitud)) {
            $return = array("mensaje" => "Error no se encontro ninguna solicitud con la clave " . $data['solicitudid']);
            return new View($return, Response::HTTP_NOT_FOUND);
        } else {
            $lugares = $dbm->getRepositoriosById('Lugar', 'activo', 1, "nombre");
            $evaluadores = $dbm->BuscarEvaluador(array("gradoid" => $data['gradoid']));
            $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $data['solicitudid']))->getCicloid();
            $return = array('lugares' => $lugares, 'evaluadores' => $evaluadores, 'ciclo' => $ciclo ? $ciclo->getNombre() : "");
            return new View($return, Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Post("/api/Calendarioevaluacion/Validaciondatos" , name="GuardarEventoCalendarioValidacion")
     */
    public function saveEventoEvaluacionValidadcion()
    {
        try {
            $data = $_REQUEST;
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
            if (empty($Solicitud)) {
                return new View("Error no se encontro ninguna solicitud  " . $data['solicitudadmisionid'], Response::HTTP_OK);
            }
            $dbm->getConnection()->beginTransaction();

            $Eventoevaluacion = new Eventoevaluacion();
            $Eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $data['evaluacionid']));
            $Eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $data['lugarid']));
            $Eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'personaid', $data['evaluadorid']));
            $Eventoevaluacion->setFechainicio(new \DateTime($data['fechainicio']));
            $Eventoevaluacion->setFechafin(new \DateTime($data['fechafin']));
            $Eventoevaluacion->setHorainicio(new \DateTime($data['horainicio']));
            $Eventoevaluacion->setHorafin(new \DateTime($data['horafin']));
            $Eventoevaluacion->setCupo($data['cupo']);
            $dbm->saveRepositorio($Eventoevaluacion);

            $Gradoporevento = new Gradoporeventoevaluacion();
            $Gradoporevento->setEventoevaluacionid($Eventoevaluacion);
            $Gradoporevento->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']));
            $dbm->saveRepositorio($Gradoporevento);

            $Evaluacionporsolicitudadmision = $dbm->getRepositorioById('Evaluacionporsolicitudadmision', 'evaluacionporsolicitudadmisionid', $data['evaluacionporsolicitudadmisionid']);
            if ($Evaluacionporsolicitudadmision) {
                $Evaluacionporsolicitudadmision->setEventoevaluacionid($Eventoevaluacion);
            } else {
                $Evaluacionporsolicitudadmision = new \AppBundle\Entity\Evaluacionporsolicitudadmision();
                $Evaluacionporsolicitudadmision->setEventoevaluacionid($Eventoevaluacion);
                $Evaluacionporsolicitudadmision->setEstatusevaluacionid($dbm->getRepositorioById('Estatusevaluacion', 'estatusevaluacionid', 1));
                $Evaluacionporsolicitudadmision->setSolicitudadmisionid($Solicitud);
                $Evaluacionporsolicitudadmision->setEvaluacionid($Eventoevaluacion->getEvaluacionid());
            }
            $dbm->saveRepositorio($Evaluacionporsolicitudadmision);

            //Ciencias
            $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $data['solicitudadmisionid']))->getCicloid();
            $Bloque = $dbm->getConfiguracionBloquesConsulta(array('gradoid' => $Solicitud->getGradoid()->getGradoid(), 'cicloid' => $ciclo->getCicloid()));
            $evaluacion = $dbm->getRepositorioById('Evaluacion', 'evaluacionid', $data['evaluacionid']);
            if ($Bloque && $evaluacion->getTipoevaluacionid()->getTipoevaluacionid() != 4) {
                $bloquesgrados = $dbm->getRepositoriosById('AdBloquegradoevaluacion', 'bloquegradoid', $Bloque[0]["bloquegradoid"]);
                $bloquegrado = $dbm->getOneByParametersRepositorio('AdBloquegradoevaluacionevaluacion', array('bloquegradoevaluacionid' => $bloquesgrados, 'evaluacionid' => $data['evaluacionid']));

                $evaluaciones = $dbm->getRepositoriosById('AdBloquegradoevaluacionevaluacion', 'bloquegradoevaluacionid', $bloquegrado ? $bloquegrado->getBloquegradoevaluacionid() : null);
                foreach ($evaluaciones as $e) {
                    if ($e->getEvaluacionid() != $data['evaluacionid']) {
                        $Eventoevaluacion = clone ($Eventoevaluacion);
                        $Eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $e->getEvaluacionid()));
                        $dbm->saveRepositorio($Eventoevaluacion);
                        $Gradoporevento = clone ($Gradoporevento);
                        $Gradoporevento->setEventoevaluacionid($Eventoevaluacion);
                        $dbm->saveRepositorio($Gradoporevento);

                        $evaluacionporsolicitud = $dbm->getOneByParametersRepositorio("Evaluacionporsolicitudadmision",
                            array("evaluacionid" => $Eventoevaluacion->getEvaluacionid(), "solicitudadmisionid" => $Solicitud));
                        if ($evaluacionporsolicitud) {
                            $evaluacionporsolicitud->setEventoevaluacionid($Eventoevaluacion);
                        } else {
                            $evaluacionporsolicitud = new \AppBundle\Entity\Evaluacionporsolicitudadmision();
                            $evaluacionporsolicitud->setEventoevaluacionid($Eventoevaluacion);
                            $evaluacionporsolicitud->setEstatusevaluacionid($dbm->getRepositorioById('Estatusevaluacion', 'estatusevaluacionid', 1));
                            $evaluacionporsolicitud->setSolicitudadmisionid($Solicitud);
                            $evaluacionporsolicitud->setEvaluacionid($Eventoevaluacion->getEvaluacionid());
                        }
                        $dbm->saveRepositorio($evaluacionporsolicitud);
                    }
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Calendarioevaluacion/{id}" , name="ActualizarEventoCalendario")
     */
    public function updateEventoEvaluacion($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $filtros = ['fechainicio' => $data['paso1']['fechainicio'], 'fechafin' => $data['paso1']['fechafin'], 'horainicio' => $data['paso1']['horainicio'], 'horafin' => $data['paso1']['horafin'], 'evaluadorid' => $data['paso4']['evaluadorid'], "tipoeventoid" => 2];
            $diasfestivos = $dbm->BuscarDiaFestivo($filtros);
            if ($diasfestivos) {
                return new View("No se puede crear una evaluación en las fechas seleccionadas ya que coincide con uno o más días festivos del nivel y grado seleccionados", Response::HTTP_PARTIAL_CONTENT);
            }
            $repetidos = $dbm->BuscarCalendario($filtros);
            if ($repetidos) {
                foreach($repetidos as $r){
                    if($id != $r['eventoevaluacionid']){
                        return new View("El evaluador ya tiene un evento registrado en el rango de fecha y hora seleccionado", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }

            $agendado = $dbm->getRepositoriosById('Evaluacionporsolicitudadmision', 'eventoevaluacionid', $id);
            if ($agendado) {
                return new View("Ya se han asignado solicitudes a este evento", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio('Gradoporeventoevaluacion', 'eventoevaluacionid', $id);

            $Eventoevaluacion = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $id);
            $Eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $data['paso3']['evaluacionid']));
            $Eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $data['paso4']['lugarid']));
            $Eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'personaid', $data['paso4']['evaluadorid']));
            $Eventoevaluacion->setFechainicio(new \DateTime($data['paso1']['fechainicio']));
            $Eventoevaluacion->setFechafin(new \DateTime($data['paso1']['fechafin']));
            $Eventoevaluacion->setHorainicio(new \DateTime($data['paso1']['horainicio']));
            $Eventoevaluacion->setHorafin(new \DateTime($data['paso1']['horafin']));
            $Eventoevaluacion->setCupo($data['paso4']['cupo']);
            $dbm->saveRepositorio($Eventoevaluacion);

            foreach ($data['paso2']['gradoid'] as $grado) {
                $Gradoporevento = new Gradoporeventoevaluacion();
                $Gradoporevento->setEventoevaluacionid($Eventoevaluacion);
                $Gradoporevento->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                $dbm->saveRepositorio($Gradoporevento);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
