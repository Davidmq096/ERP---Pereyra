<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\DB\DbmBancoreactivo;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\BrRespuestaporusuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier
 */
class AplicacionExamenController extends FOSRestController
{

    /**
     * Retorna arreglo de examen asignado a un usuario
     * @Rest\Get("/api/Aplicacionexamen/Lista/{id}", name="BuscarAplicacionexamenLista")
     */
    public function indexAplicacionexamen($id)
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarAplicacionexamenExterno($id);
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el tiempo que durara el examen
     * @Rest\Get("/api/Aplicacionexamen/Tiempo/{id}", name="BuscarAplicacionexamenTiempo")
     */
    public function tiempoAplicacionexamen($id)
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $ex = $dbm->getRepositorioById('BrExamenporcalendario', 'examenporcalendarioid', $id);

            $hr = $ex->getTiempo()->format('H');
            $mn = $ex->getTiempo()->format('i');

            $fechafin = new \DateTime(
                $ex->getCalendarioexamenid()->getFechaaplicacion()->format('Y-m-d') . ' ' .
                $ex->getCalendarioexamenid()->getHorafin()->format('H:i:s')
            );
            $ms = $fechafin->diff(new \DateTime());

            $entidad;
            if ($ms->h < $hr) {
                $entidad = $ms->format('%H:%i:%s');
            } else if ($ms->h == $hr) {
                if ($ms->i < $mn) {
                    $entidad = $ms->format('%H:%i:%s');
                } else {
                    $entidad = $ex->getTiempo()->format('H:i:s');
                }
            } else {
                $entidad = $ex->getTiempo()->format('H:i:s');
            }

            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna los archivos multimedia del contenido de un reactivo
     * @Rest\Get("/api/Aplicacionexamen/Reactivos", name="BuscarAplicacionexamenReactivos")
     */
    public function getBuscarAplicacionexamenReactivos()
    {
        try {
            $data = $_REQUEST;
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if($data['alumnoid']) {
                $Usuarioporexamen = $dbm->getByParametersRepositorios('BrUsuarioporexamen', array('examenporcalendarioid' => $data['examenporcalendarioid'], 'alumnoid' => $data["alumnoid"]))[0];
            } else {
                $Usuarioporexamen = $dbm->getByParametersRepositorios('BrUsuarioporexamen', array('examenporcalendarioid' => $data['examenporcalendarioid'], 'usuarioexternoid' => $data["usuarioid"]))[0];
            }

            $Reactivos = $dbm->getRepositoriosById('BrReactivoporexamen', 'examenid', $Usuarioporexamen->getExamenporcalendarioid()->getExamenid()->getExamenid());
            $Respuestas = array();
            foreach ($Reactivos as $r) {
                //Validar si ya hay respuestas del mismo examen y del mismo alumno
                $respuestasvieja = $dbm->getByParametersRepositorios('BrRespuestaporusuario',
                    array('usuarioexamenid' => $Usuarioporexamen, 'reactivoid' => $r->getReactivoid()));

                $Respuestaporusuario = $respuestasvieja ? $respuestasvieja[0] : new BrRespuestaporusuario();
                $Respuestaporusuario->setUsuarioexamenid($Usuarioporexamen);
                $Respuestaporusuario->setReactivoid($r->getReactivoid());
                $Respuestaporusuario->setRespuestaid(null);
                $Respuestaporusuario->setRespuestatext(null);
                $dbm->saveRepositorio($Respuestaporusuario);
                array_push($Respuestas, $Respuestaporusuario);
            }
            $dbm->getConnection()->commit();

            $Examen = array();
            foreach ($Respuestas as $r) {
                $reactivo = $r->getReactivoid();
                $complementos = self::getMultimediaContenido($reactivo->getReactivoid());
                $respuestas = self::getReactivoRespuesta($reactivo->getReactivoid());
                array_push($Examen, array("respuestaporusuarioid" => $r->getRespuestaporusuarioid(),
                    "reactivo" => $reactivo, "complementos" => $complementos, "respuestas" => $respuestas));
            }

            $Usuarioporexamen->setFecha(new \DateTime());
            $dbm->saveRepositorio($Usuarioporexamen);

            return new View($Examen, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function getMultimediaContenido($id)
    {
        $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
        $Complementos = $dbm->getRepositoriosById('BrComplementoporreactivo', 'reactivoid', $id);
        foreach ($Complementos as $c) {
            $c->getComplementoid()->setComplemento(stream_get_contents($c->getComplementoid()->getComplemento()));
        }
        return $Complementos;
    }
    public function getReactivoRespuesta($id)
    {
        $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
        $Respuesta = array();
        $Respuestas = $dbm->getRepositoriosById('BrRespuestaporreactivo', 'reactivoid', $id);
        return $Respuestas;
    }

    /**
     * @Rest\Put("/api/Aplicacionexamen/Examen" , name="ActualizarAplicacioneexamen")
     */
    public function updateAplicacionExamen()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if($data['alumnoid']) {
                \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::CCCapturaCalificacionAlumnoProcess([
                    'permiso' => true,
                    'periodoevaluacionid' => $data['periodoevaluacionid'],
                    'profesorpormateriaplanestudiosid' => $data['profesorpormateriaplanestudiosid'],
                    'alumnoid' => $data['alumnoid'],
                    'permiso' => true
                ], $dbmce);
            }
            $dbm->getConnection()->beginTransaction();

            $respuestastexto = false;
            //Guardar respuestas
            foreach ($data["respuestas"] as $r) {
                $respuesta = $dbm->getRepositorioById('BrRespuestaporusuario', 'respuestaporusuarioid', $r["respuestaid"]);
                $tiporespuesta = $respuesta->getReactivoid()->getTipoReactivoid()->getTipoReactivoid();
                if ($tiporespuesta == 1 || $tiporespuesta == 4) {
                    //Se guarda el id
                    $respuesta->setRespuestaid($dbm->getRepositorioById('BrRespuestaporreactivo', 'respuestaporreactivoid', $r["respuesta"]));
                } else {
                    //se guarda en texto
                    $respuesta->setRespuestatext($r["respuesta"]);
                    $respuestastexto = true;
                }
                $dbm->saveRepositorio($respuesta);
            }

            $Examen = $respuesta->getUsuarioexamenid();
            $Examen->setIntentosrestantes($Examen->getIntentosrestantes() - 1);
            $Examen->setAplicado(true);

            $tiempotranscurrido = (new \DateTime())->diff($Examen->getFecha())->format('%H:%i:%s');
            $Examen->setTiempo($tiempotranscurrido);
            if (!$respuestastexto) {
                $Examen->setPuntaje($data['resultado']["puntaje"]);
                $Examen->setCalificacion($data['resultado']["calificacion"]);
            }
            $dbm->saveRepositorio($Examen);
            $examencalendario = $Examen->getExamenporcalendarioid()->getExamenid();
            $sistemacalificacion = $examencalendario->getSistemacalificacionid();
            $dbm->getConnection()->commit();

            //Se actualiza la calificación del criterio en captura de calificaciones
            if($data['alumnoid']) {
                $alumno = $dbmce->BuscarAlumnosA(['alumnoid' => $data['alumnoid']])[0];
                $calperiodo = $dbm->getOneByParametersRepositorio('CeCalificacionperiodoporalumno', array(
                    'alumnoporcicloid' => $alumno['alumnoporcicloid'], 
                    'profesorpormateriaplanestudioid' => $data["profesorpormateriaplanestudiosid"],
                    'periodoevaluacionid' => $data["periodoevaluacionid"]));

                if ($calperiodo) {
                    $capturaperiodo = $dbm->getOneByParametersRepositorio('CeCapturacalificacionporalumno', array(
                        'criterioevaluaciongrupoid' => $data['criterioevaluaciongrupoid'], 
                        'numerocaptura' => $data["numerocaptura"],
                        'calificacionperiodoporalumnoid' => $calperiodo->getCalificacionperiodoporalumnoid()));

                    $examencalendario = $Examen->getExamenporcalendarioid()->getExamenid();
                    $sistemacalificacion = $examencalendario->getSistemacalificacionid();

                    $criterioevalgrupo = $data['criterioevaluaciongrupoid'] ? 
                    $dbm->getRepositorioById('CeCriterioevaluaciongrupo', 'criterioevaluaciongrupoid', $data['criterioevaluaciongrupoid']) : null;
                    
                    $criterioevalgrupo->setPuntajemaximo($sistemacalificacion->getFin());
                    if($criterioevalgrupo->getEditarpuntajemaximo() == 1) {
                        $criterioevalgrupo->setMinimo($sistemacalificacion->getFin());
                        $criterioevalgrupo->setMaximo($sistemacalificacion->getFin());
                    } 
                    $dbm->saveRepositorio($criterioevalgrupo);

                    if($capturaperiodo) {
                        $datoscalificacion = [
                            'capturacalificacionporalumnoid' => $capturaperiodo->getCapturacalificacionporalumnoid(),
                            'calificacionperiodoporalumnoid' => $calperiodo->getCalificacionperiodoporalumnoid(),
                            'calificacioncaptura' => $data['resultado']["calificacion"],
                            'usuarioid' => $data['usuarioid']
                        ];
                        \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::Calificar($datoscalificacion, $dbmce);
                    }
                }    
            }
            $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $date = $Examen->getFecha();
            $entidad = array(
                "intentosrestantes" => $Examen->getIntentosrestantes,
                "tiempo" => $tiempotranscurrido,
                "fecha" => $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'). " a las ". $date->format('H:i:s')
            );
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
