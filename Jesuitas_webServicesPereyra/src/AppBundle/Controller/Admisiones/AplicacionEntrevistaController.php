<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\DB\DbmAdmisiones;
use AppBundle\Entity\Respuestaporaspirante;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier Manrique
 */
class AplicacionEntrevistaController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Aplicacionentrevista", name="indexAplicacionEntrevista")
     */
    public function indexAplicacionEntrevista()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $lugar = $dbm->getRepositoriosById('Lugar', 'activo', 1, "nombre");
            $evaluador = $dbm->BuscarEvaluador(array());
            $estatusevaluacion = $dbm->getRepositoriosById('Estatusevaluacion', 'activo', 1, 'nombre');
            $tipoevaluacion = $dbm->getRepositoriosById('Tipoevaluacion', 'activo', 1, "nombre");

            return new View(
                array("ciclo" => $ciclo,
                    "nivel" => $nivel,
                    "grado" => $grado,
                    "evaluador" => $evaluador,
                    "lugar" => $lugar,
                    "estatusevaluacion" => $estatusevaluacion,
                    "tipoevaluacion" => $tipoevaluacion,
                ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna resultados en base a los parametros enviados
     * @Rest\Get("/api/Aplicacionentrevista/", name="buscarentrevistas")
     */
    public function buscarAplicacionEntrevista()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);

            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarAplicacionEntrevista($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna una evaluacion por id enviado
     * @Rest\Get("/api/Aplicacionentrevista/{id}", name="buscarentrevistasporid")
     */
    public function buscarAplicacionEntrevistaId($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $evaluacionporsolicitud = $dbm->getRepositorioById('Evaluacionporsolicitudadmision', 'evaluacionporsolicitudadmisionid', $id);
            $evaluacionporsolicitud->getSolicitudadmisionid()->getDatoaspiranteid()->setFoto($evaluacionporsolicitud->getSolicitudadmisionid()->getDatoaspiranteid()->getFoto() == null ? null : stream_get_contents($evaluacionporsolicitud->getSolicitudadmisionid()->getDatoaspiranteid()->getFoto()));
            $evaluacionporsolicitud->getSolicitudadmisionid()->getDatoaspiranteid()->setFotofamiliar($evaluacionporsolicitud->getSolicitudadmisionid()->getDatoaspiranteid()->getFotofamiliar() == null ? null : stream_get_contents($evaluacionporsolicitud->getSolicitudadmisionid()->getDatoaspiranteid()->getFotofamiliar()));

            $Respuestasporaspirante = $dbm->getRepositoriosById('Respuestaporaspirante', 'evaluacionporsolicitudadmisionid', $id);
            $Comentarios = $dbm->getRepositoriosById('Comentarioporsolicitud', 'solicitudadmisionid', $evaluacionporsolicitud->getSolicitudadmisionid()->getSolicitudadmisionid());
            $Comentarios = $Comentarios ? $Comentarios[count($Comentarios)-1] : null;
            $Preguntasporevaluacion = $dbm->getRepositoriosById('Preguntaporevaluacion', 'evaluacionid', $evaluacionporsolicitud->getEvaluacionid()->getEvaluacionid());

            $Preguntas = array();
            $PreguntasAnidadas = array();
            foreach ($Preguntasporevaluacion as $p) {
                $Pregunta = $p->getPreguntaid();
                $Respuestas = $dbm->getRepositoriosById('Respuesta', 'preguntaid', $Pregunta->getPreguntaid());
                foreach ($Respuestas as $r) {
                    $imagen = $r->getComplementoid();
                    if ($imagen) {
                        $r->getComplementoid()->setComplemento(stream_get_contents($imagen->getComplemento()));
                    }
                }

                $Complementos = array();
                $Complementosporpregunta = $dbm->getRepositoriosById('Complementoporpregunta', 'preguntaid', $Pregunta->getPreguntaid());
                if (sizeof($Complementosporpregunta) != 0) {
                    $TipoComplemento = $Complementosporpregunta[0]->getComplementoid()->getTipocomplementoid()->getTipocomplementoid();
                    $Complementos = array('Tipocomplementoid' => $TipoComplemento, 'Complementos' => array());
                    foreach ($Complementosporpregunta as $c) {
                        $Complemento = $c->getComplementoid();
                        $Complemento->setComplemento(stream_get_contents($Complemento->getComplemento()));
                        array_push($Complementos['Complementos'], array('Complemento' => $Complemento));
                    }
                }
                if ($Pregunta->getAnidada()) {
                    $respuestapadreid = $Pregunta->getPadreid()->getRespuestaid();
                    $respuesta = $dbm->getRepositorioById('Respuesta', 'respuestaid', $respuestapadreid);
                    array_push($PreguntasAnidadas, (object) ['preguntapadreid' => $respuesta->getPreguntaid()->getPreguntaid(), 'respuestapadreid' => $respuestapadreid, 'preguntahijoid' => $Pregunta->getPreguntaid()]);
                }
                array_push($Preguntas, array('Pregunta' => $Pregunta, 'Respuestas' => $Respuestas, 'Complementos' => $Complementos, "Orden" => $p->getOrden(), "Relacion" => array()));
            }

            foreach ($PreguntasAnidadas as $a) {
                foreach ($Preguntas as $key => $p) {
                    if ($p['Pregunta']->getPreguntaid() == $a->preguntapadreid) {
                       array_push($Preguntas[$key]['Relacion'], array('RespuestaPadre' => $a->respuestapadreid, 'PreguntaHijo' => $a->preguntahijoid));
                    }
                }
            }
            return new View(array("datosentrevista" => $evaluacionporsolicitud,
                "preguntas" => $Preguntas,
                "respuestasporaspirante" => $Respuestasporaspirante,
                'comentario' => $Comentarios), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna resultados en base a los parametros enviados
     * @Rest\Post("/api/Aplicacionentrevista", name="guardarRespuestas")
     */
    public function guardarAplicacionEntrevista()
    {
        try {
            $content = trim(file_get_contents("php://input")); 
            $data = json_decode($content, true); 
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $evaluacionporsolicitud = $dbm->getRepositorioById('Evaluacionporsolicitudadmision', 'evaluacionporsolicitudadmisionid', $data['evaluacionporsolicitudid']);
            $evaluacionporsolicitud->setEstatusevaluacionid($dbm->getRepositorioById("Estatusevaluacion", "estatusevaluacionid", $data["estatusid"]));
            $evaluacionporsolicitud->setAsistio(true);
            $dbm->saveRepositorio($evaluacionporsolicitud);
            foreach ($data['preguntas'] as $p) {
                $Pregunta = $dbm->getRepositorioById('Pregunta', 'preguntaid', $p['preguntaid']);
                $contestada = $dbm->getByParametersRepositorios('Respuestaporaspirante', array('evaluacionporsolicitudadmisionid' => $data['evaluacionporsolicitudid'], 'preguntaid' => $p['preguntaid']));
                switch ($p['tipopregunta']) {
                    case 1:
                    case 2:
                    case 5:
                        $Respuestaporaspirante = $contestada ? $contestada[0] : new Respuestaporaspirante();
                        $Respuestaporaspirante->setEvaluacionporsolicitudadmisionid($evaluacionporsolicitud);
                        $Respuestaporaspirante->setPreguntaid($Pregunta);
                        $Respuestaporaspirante->setRespuestaabierta($p['respuestaabierta']);
                        $dbm->saveRepositorio($Respuestaporaspirante);
                        break;
                    case 3:
                    case 4:
                        if (isset($p['respuestamultiple'])) {
                            foreach ($contestada as $c) {
                                $dbm->removeRepositorio($c);
                            }
                            foreach ($p['respuestamultiple'] as $r) {
                                $Respuestaporaspirante = new Respuestaporaspirante();
                                $Respuestaporaspirante->setEvaluacionporsolicitudadmisionid($evaluacionporsolicitud);
                                $Respuestaporaspirante->setPreguntaid($Pregunta);
                                if ($r['respuestaabiertas']) {
                                    $Respuestaporaspirante->setRespuestaabierta($r['respuestaabierta']);
                                } else {
                                    $Respuestaporaspirante->setRespuestaid($dbm->getRepositorioById("Respuesta", "respuestaid", $r['respuestaid']));
                                }
                                $dbm->saveRepositorio($Respuestaporaspirante);
                            }
                        }
                        break;
                }
            }

            //Verificamos si el alumno ya ha aplicado todas sus evaluaciones para cambiarle el estatus
            $solicitudadmision = $evaluacionporsolicitud->getSolicitudadmisionid();
            $evaluaciones = $dbm->getRepositoriosById('Evaluacionporsolicitudadmision', 'solicitudadmisionid', $solicitudadmision->getSolicitudadmisionid());
            $completos = array_filter(
                $evaluaciones, function ($e) {
                    return $e->getEstatusEvaluacionid()->getEstatusEvaluacionid() == 2;
                });
            if (sizeof($evaluaciones) == sizeof($completos) && $solicitudadmision->getEstatussolicitudid()->getEstatussolicitudid() < 4) {
                $solicitudadmision->setEstatussolicitudid($dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', 4));
                $dbm->saveRepositorio($solicitudadmision);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
