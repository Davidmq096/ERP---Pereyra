<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\DB\DbmAdmisiones;
use AppBundle\Entity\Complemento;
use AppBundle\Entity\Complementoporpregunta;
use AppBundle\Entity\Evaluacion;
use AppBundle\Entity\Evaluacionporgrado;
use AppBundle\Entity\Pregunta;
use AppBundle\Entity\Preguntaporevaluacion;
use AppBundle\Entity\Respuesta;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier Manrique
 */
class EvaluacionController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Evaluacion", name="indexEvaluacion")
     */
    public function indexEvaluacion()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $tipoevaluacion = $dbm->getRepositoriosById('Tipoevaluacion', 'activo', 1, 'nombre');
            $tipopregunta = $dbm->getRepositoriosById('Tipopregunta', 'activo', 1);
            $tipocomplemento = $dbm->getRepositoriosById('Tipocomplemento', 'activo', 1);
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            return new View(
                array(
                    "tipoevaluacion" => $tipoevaluacion,
                    "tipopregunta" => $tipopregunta,
                    "tipocomplemento" => $tipocomplemento,
                    "ciclo" => $ciclo,
                    "nivel" => $nivel,
                    "grado" => $grado,
                ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Evaluaciones por los parametros enviados
     * @Rest\Get("/api/Evaluacion/", name="BuscarEvaluacion")
     */
    public function buscarEvaluacion()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);

            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarEvaluacion($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach ($entidad as $e) {
                $Contestada = false;
                $Preguntas = $dbm->getRepositoriosById('Preguntaporevaluacion', 'evaluacionid', $e["evaluacionid"]);
                foreach ($Preguntas as $p) {
                    $contestadas = $dbm->getRepositoriosById('Respuestaporaspirante', 'preguntaid', $p->getPreguntaid()->getPreguntaid());
                    if ($contestadas) {
                        $Contestada = true;
                    }

                }
                array_push($entidad[array_search($e, $entidad)], $Contestada);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una Evaluacion
     * @Rest\Post("/api/Evaluacion", name="saveEvaluacion")
     */
    public function saveEvaluacion()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;

            if ($data["activo"] == "true") {
                $validacion = $dbm->ValidarRelacionEvaluacion($data["tipoevaluacionid"], implode(",", $data["gradoid"]), $data['cicloid']);
                if ($validacion[0]['grados'] != null) {
                    $msj = "El tipo de evaluacion '" . $validacion[0]['nombre'] . "' ya esta asignado a " . $validacion[0]['grados'] . " y se encuentra activo para el "
                    . $validacion[0]['relaciones']->getEvaluacionId()->getCicloid()->getNombre();
                    return new View($msj, Response::HTTP_PARTIAL_CONTENT);
                }
            }
            $dbm->getConnection()->beginTransaction();

            $Evaluacion = new Evaluacion();
            $Evaluacion->setNombre($data['nombre']);
            $Evaluacion->setTipoevaluacionid(
                $dbm->getRepositorioById('Tipoevaluacion', 'tipoevaluacionid', $data['tipoevaluacionid']));
            /*
            $Evaluacion->setPonderacionid(
            $dbm->getRepositorioById('Ponderacion', 'ponderacionid', $data['ponderacionid']));
             */
            $Evaluacion->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']));
            $Evaluacion->setActivo($data["activo"] == "true" ? true : false);
            $dbm->saveRepositorio($Evaluacion);
            foreach ($data['gradoid'] as $gradoid) {
                $Evaluacionporgrado = new Evaluacionporgrado();
                $Evaluacionporgrado->setGradoid(($dbm->getRepositorioById('Grado', 'gradoid', $gradoid)));
                $Evaluacionporgrado->setEvaluacionid($Evaluacion);
                $dbm->saveRepositorio($Evaluacionporgrado);
            }
            $dbm->getConnection()->commit();
            $evaluacioninsertada = $dbm->BuscarEvaluacion(array("evaluacionid" => $Evaluacion->getEvaluacionid()));

            return new View(array("Mensaje" => "Se ha guardado el registro", "Evaluacion" => $evaluacioninsertada[0]), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza una Evaluacion
     * @Rest\Put("/api/Evaluacion/{id}", name="updateEvaluacion")
     */
    public function updateEvaluacion($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            parse_str(file_get_contents("php://input"), $data);
            $dbm->getConnection()->beginTransaction();

            $dbm->removeManyRepositorio('Evaluacionporgrado', 'evaluacionid', $id);
            if ($data["activo"] == "true") {
                $eventos = $dbm->getRepositorioById('Eventoevaluacion', 'evaluacionid', $id);
                if ($eventos) {
                    return new View("El registro ya ha sido asignada a un evento", Response::HTTP_PARTIAL_CONTENT);
                }
                $validacion = $dbm->ValidarRelacionEvaluacion($data["tipoevaluacionid"], implode(",", $data["gradoid"]), $data['cicloid']);
                if ($validacion[0]['grados'] != null) {
                    return new View("El tipo de evaluación '" . $validacion[0]['nombre'] . "' ya esta asignado a " . $validacion[0]['grados'] . " y se ecncuentra activo para el "
                        . $validacion[0]['relaciones']->getEvaluacionId()->getCicloid()->getNombre()
                        , Response::HTTP_PARTIAL_CONTENT);
                }
            }
            $Evaluacion = $dbm->getRepositorioById('Evaluacion', 'evaluacionid', $id);
            $Evaluacion->setNombre($data['nombre']);
            $Evaluacion->setTipoevaluacionid(
                $dbm->getRepositorioById('Tipoevaluacion', 'tipoevaluacionid', $data['tipoevaluacionid']));
            /*
            $Evaluacion->setPonderacionid(
            $dbm->getRepositorioById('Ponderacion', 'ponderacionid', $data['ponderacionid']));
             */
            $Evaluacion->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']));
            $Evaluacion->setActivo($data["activo"] == "true" ? true : false);
            $dbm->saveRepositorio($Evaluacion);
            foreach ($data['gradoid'] as $gradoid) {
                $Evaluacionporgrado = new Evaluacionporgrado();
                $Evaluacionporgrado->setGradoid(($dbm->getRepositorioById('Grado', 'gradoid', $gradoid)));
                $Evaluacionporgrado->setEvaluacionid($Evaluacion);
                $dbm->saveRepositorio($Evaluacionporgrado);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * copia evaluaciones cambiando el ciclo
     * @Rest\Post("/api/Evaluacion/otrociclo", name="otrocicloEvaluacion")
     */
    public function otrocicloEvaluacion()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;
            $primero = true;
            $dbm->getConnection()->beginTransaction();
            foreach ($data["evaluacionesid"] as $evaluacionid) {
                
                $evaluacion = clone $dbm->getRepositorioById('Evaluacion', 'evaluacionid', $evaluacionid);
                $evaluacion->setActivo(true);
                $evaluacion->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $data["cicloid"]));
                $dbm->saveRepositorio($evaluacion);

                $evaluacionporgrado = $dbm->BuscarEvaluacion(array("evaluacionid" => $evaluacionid));
                $validacion = $dbm->ValidarRelacionEvaluacion($evaluacion->getTipoevaluacionid()->getTipoevaluacionid(), $evaluacionporgrado[0]["gradoid"], $data['cicloid']);
                if ($validacion[0]['grados'] != null) {
                    return new View("El tipo de evaluacion '" . $validacion[0]['nombre'] . "' ya esta asignado a " . $validacion[0]['grados'] . " y se ecncuentra activo para el "
                        . $validacion[0]['relaciones']->getEvaluacionId()->getCicloid()->getNombre()
                        , Response::HTTP_PARTIAL_CONTENT);
                }
                
                if($primero){
                    $ids .= $evaluacionid;
                    $primero = false;
                }else{                    
                    $ids .= ','. $evaluacionid;
                }
            }

            $result = $dbm->CopiarEvaluacionCicloEvaluaciones( $ids, $data["cicloid"]);
            /*
            foreach ($data["evaluacionesid"] as $evaluacionid) {
                //$evaluacionFull = self::buscarEvaluacionId($evaluacionid);

                $evaluacion = clone $dbm->getRepositorioById('Evaluacion', 'evaluacionid', $evaluacionid);
                $evaluacion->setActivo(true);
                $evaluacion->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $data["cicloid"]));
                $dbm->saveRepositorio($evaluacion);

                $evaluacionporgrado = $dbm->BuscarEvaluacion(array("evaluacionid" => $evaluacionid));
                $validacion = $dbm->ValidarRelacionEvaluacion($evaluacion->getTipoevaluacionid()->getTipoevaluacionid(), $evaluacionporgrado[0]["gradoid"], $data['cicloid']);
                if ($validacion[0]['grados'] != null) {
                    return new View("El tipo de evaluacion '" . $validacion[0]['nombre'] . "' ya esta asignado a " . $validacion[0]['grados'] . " y se ecncuentra activo para el "
                        . $validacion[0]['relaciones']->getEvaluacionId()->getCicloid()->getNombre()
                        , Response::HTTP_PARTIAL_CONTENT);
                }

                foreach (explode(',', $evaluacionporgrado[0]["gradoid"]) as $grado) {
                    $Evaluacionporgrado = new Evaluacionporgrado();
                    $Evaluacionporgrado->setEvaluacionid($evaluacion);
                    $Evaluacionporgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                    $dbm->saveRepositorio($Evaluacionporgrado);
                }

                $PadreHijo = array("Hijo" => array(), "Padre" => array());
                foreach ($this->buscarEvaluacionId($evaluacionid)->getData()["preguntas"] as $pregunta) {
                    $Pregunta = clone $pregunta["Pregunta"];
                    if ($Pregunta->getAnidada()) {
                        array_push($PadreHijo["Hijo"], array("HijoOld" => $pregunta["Pregunta"], "HijoNew" => $Pregunta));
                    }

                    $dbm->saveRepositorio($Pregunta);

                    $Preguntaporevaluacion = new Preguntaporevaluacion();
                    $Preguntaporevaluacion->setEvaluacionid($evaluacion);
                    $Preguntaporevaluacion->setPreguntaid($Pregunta);
                    $Preguntaporevaluacion->setOrden($pregunta["Orden"]);
                    $dbm->saveRepositorio($Preguntaporevaluacion);

                    if (array_key_exists("Complementos", $pregunta["Complementos"])) {
                        foreach ($pregunta["Complementos"]["Complementos"] as $complemento) {
                            $Complemento = clone $complemento["Complemento"];
                            $dbm->saveRepositorio($Complemento);
                            $Complementoporpregunta = new Complementoporpregunta();
                            $Complementoporpregunta->setPreguntaid($Pregunta);
                            $Complementoporpregunta->setComplementoid($Complemento);
                            $dbm->saveRepositorio($Complementoporpregunta);
                        }
                    }

                    foreach ($pregunta["Respuestas"] as $respuesta) {
                        $Complemento = null;
                        if ($respuesta->getComplementoid() != null) {
                            $Complemento = clone $respuesta->getComplementoid();
                            $dbm->saveRepositorio($Complemento);
                        }
                        $Respuesta = clone $respuesta;
                        $Respuesta->setPreguntaid($Pregunta);
                        $Respuesta->setComplementoid($Complemento);
                        $dbm->saveRepositorio($Respuesta);
                        array_push($PadreHijo["Padre"], array("PadreOld" => $respuesta, "PadreNew" => $Respuesta));
                    }
                }

                for ($i = 0; $i < sizeof($PadreHijo["Hijo"]); $i++) {
                    $Pregunta = $PadreHijo["Hijo"][$i]["HijoNew"];
                    $PreguntaOld = $PadreHijo["Hijo"][$i]["HijoOld"]->getPadreid();
                    $Padre = $PadreHijo["Padre"][array_search($PreguntaOld, array_column($PadreHijo['Padre'], 'PadreOld'))];
                    $Pregunta->setPadreid($Padre["PadreNew"]);
                    $dbm->saveRepositorio($Pregunta);
                }
            }
            
            */
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * copia evaluaciones cambiando el ciclo
     * @Rest\Post("/api/Evaluacion/Copia", name="copiaEvaluacion")
     */
    public function Copia()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;
            $dbm->getConnection()->beginTransaction();

            $evaluacion = $dbm->getRepositorioById('Evaluacion', 'evaluacionid', $data["evaluacionid"]);
            $PadreHijo = array("Hijo" => array(), "Padre" => array());
            foreach ($this->buscarEvaluacionId($data["evaluacionidOld"])->getData()["preguntas"] as $pregunta) {
                $Pregunta = clone $pregunta["Pregunta"];
                if ($Pregunta->getAnidada()) {
                    array_push($PadreHijo["Hijo"], array("HijoOld" => $pregunta["Pregunta"], "HijoNew" => $Pregunta));
                }

                $dbm->saveRepositorio($Pregunta);

                $Preguntaporevaluacion = new Preguntaporevaluacion();
                $Preguntaporevaluacion->setEvaluacionid($evaluacion);
                $Preguntaporevaluacion->setPreguntaid($Pregunta);
                $Preguntaporevaluacion->setOrden($pregunta["Orden"]);
                $dbm->saveRepositorio($Preguntaporevaluacion);

                if (array_key_exists("Complementos", $pregunta["Complementos"])) {
                    foreach ($pregunta["Complementos"]["Complementos"] as $complemento) {
                        $Complemento = clone $complemento["Complemento"];
                        $dbm->saveRepositorio($Complemento);
                        $Complementoporpregunta = new Complementoporpregunta();
                        $Complementoporpregunta->setPreguntaid($Pregunta);
                        $Complementoporpregunta->setComplementoid($Complemento);
                        $dbm->saveRepositorio($Complementoporpregunta);
                    }
                }

                foreach ($pregunta["Respuestas"] as $respuesta) {
                    $Complemento = null;
                    if ($respuesta->getComplementoid() != null) {
                        $Complemento = clone $respuesta->getComplementoid();
                        $dbm->saveRepositorio($Complemento);
                    }
                    $Respuesta = clone $respuesta;
                    $Respuesta->setPreguntaid($Pregunta);
                    $Respuesta->setComplementoid($Complemento);
                    $dbm->saveRepositorio($Respuesta);
                    array_push($PadreHijo["Padre"], array("PadreOld" => $respuesta, "PadreNew" => $Respuesta));
                }
            }

            for ($i = 0; $i < sizeof($PadreHijo["Hijo"]); $i++) {
                $Pregunta = $PadreHijo["Hijo"][$i]["HijoNew"];
                $PreguntaOld = $PadreHijo["Hijo"][$i]["HijoOld"]->getPadreid();
                $Padre = $PadreHijo["Padre"][array_search($PreguntaOld, array_column($PadreHijo['Padre'], 'PadreOld'))];
                $Pregunta->setPadreid($Padre["PadreNew"]);
                $dbm->saveRepositorio($Pregunta);
            }

            $dbm->getConnection()->commit();

            $evaluacionporgrado = $dbm->BuscarEvaluacion(array("evaluacionid" => $data["evaluacionid"]));
            return new View($evaluacionporgrado[0], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Retorna las preguntas de la Evaluacion dado el id
     * @Rest\Get("/api/Evaluacion/{id}", name="BuscarEvaluacionId")
     */
    public function buscarEvaluacionId($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $Preguntasporevaluacion = $dbm->getRepositoriosById('Preguntaporevaluacion', 'evaluacionid', $id);
            $Preguntas = array();
            $Contestada = false;
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
                array_push($Preguntas, array('Pregunta' => $Pregunta, 'Respuestas' => $Respuestas, 'Complementos' => $Complementos, "Orden" => $p->getOrden()));

                $contestadas = $dbm->getRepositoriosById('Respuestaporaspirante', 'preguntaid', $Pregunta->getPreguntaid());
                if ($contestadas) {
                    $Contestada = true;
                }

            }
            $tipopregunta = $dbm->getRepositoriosById('Tipopregunta', 'activo', 1);
            $tipocomplemento = $dbm->getRepositoriosById('Tipocomplemento', 'activo', 1);

            usort($Preguntas, function ($first, $second) {
                return $first["Orden"] > $second["Orden"];
            });
            return new View(
                array(
                    "tipopregunta" => $tipopregunta,
                    "tipocomplemento" => $tipocomplemento,
                    "preguntas" => $Preguntas,
                    "contestada" => $Contestada,
                ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Agrega una pregunta a la evaluacion
     * @Rest\Post("/api/Evaluacion/Pregunta", name="NuevaPreguntaEvaluacion")
     */
    public function nuevaPreguntaEvaluacionId()
    {
        try {
            $data = $_REQUEST;
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Evaluacion = $dbm->getRepositorioById('Evaluacion', 'evaluacionid', $data['id']);
            $Pregunta = new Pregunta();
            $dbm->saveRepositorio($Pregunta);
            $PreguntaPorEvaluacion = new Preguntaporevaluacion();
            $PreguntaPorEvaluacion->setEvaluacionid($Evaluacion);
            $PreguntaPorEvaluacion->setPreguntaid($Pregunta);
            $PreguntaPorEvaluacion->setOrden($data['orden']);
            $dbm->saveRepositorio($PreguntaPorEvaluacion);

            $dbm->getConnection()->commit();
            return new View($Pregunta, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina una pregunta de la evaluacion
     * @Rest\Delete("/api/Evaluacion/Pregunta/{id}", name="EliminarPreguntaEvaluacion")
     */
    public function eliminarPreguntaEvaluacionId($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $pregunta = $dbm->getRepositorioById('Preguntaporevaluacion', 'preguntaid', $id);
            $idpregunta = $pregunta->getPreguntaid()->getPreguntaid();
            $Respuestas = $dbm->getRepositoriosById('Respuesta', 'preguntaid', $idpregunta);
            foreach ($Respuestas as $respuesta) {
                $complemento = $respuesta->getComplementoid();
                if ($complemento) {
                    $respuesta->setComplementoid(null);
                    $dbm->saveRepositorio($respuesta);
                    $dbm->removeRepositorio($complemento);
                }
            }
            $dbm->removeManyRepositorio('Respuesta', 'preguntaid', $idpregunta);

            $complementos = $dbm->getRepositoriosById('Complementoporpregunta', 'preguntaid', $idpregunta);
            $dbm->removeManyRepositorio('Complementoporpregunta', 'preguntaid', $idpregunta);
            foreach ($complementos as $complemento) {
                $dbm->removeRepositorio($complemento->getComplementoid());
            }
            $dbm->removeRepositorio($pregunta);
            $dbm->removeRepositorio($pregunta->getPreguntaid());

            $dbm->getConnection()->commit();
            return new View('', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Evaluacion/{id}", name="EliminarEvaluacion")
     */
    public function EliminarEvaluacion($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $Eventos = $dbm->getRepositoriosById('Eventoevaluacion', 'evaluacionid', $id);
            if ($Eventos) {
                return new View("La evaluacion ha sido asignada a un evento ", Response::HTTP_PARTIAL_CONTENT);
            }
            $PreguntasEliminar = $dbm->getRepositoriosById('Preguntaporevaluacion', 'evaluacionid', $id);
            foreach ($PreguntasEliminar as $pregunta) {
                $idpregunta = $pregunta->getPreguntaid()->getPreguntaid();
                $Respuestas = $dbm->getRepositoriosById('Respuesta', 'preguntaid', $idpregunta);
                foreach ($Respuestas as $respuesta) {
                    $complemento = $respuesta->getComplementoid();
                    if ($complemento) {
                        $respuesta->setComplementoid(null);
                        $dbm->saveRepositorio($respuesta);
                        $dbm->removeRepositorio($complemento);
                    }
                }
                $dbm->removeManyRepositorio('Respuesta', 'preguntaid', $idpregunta);

                $complementos = $dbm->getRepositoriosById('Complementoporpregunta', 'preguntaid', $idpregunta);
                $dbm->removeManyRepositorio('Complementoporpregunta', 'preguntaid', $idpregunta);
                foreach ($complementos as $complemento) {
                    $dbm->removeRepositorio($complemento->getComplementoid());
                }
                $dbm->removeRepositorio($pregunta);
                $dbm->removeRepositorio($pregunta->getPreguntaid());
            }
            $dbm->removeManyRepositorio('Evaluacionporgrado', 'evaluacionid', $id);
            $dbm->removeRepositorio($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $id));
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
     * Guarda las preguntas de la Evaluacion
     * @Rest\Post("/api/Evaluacion/{id}", name="updateEvaluacionFormulario")
     */
    public function updateEvaluacionFormulario($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Preguntasporevaluacion = $dbm->getRepositoriosById('Preguntaporevaluacion', 'evaluacionid', $id);
            foreach ($data['preguntas'] as $pregunta) {
                self::EditarPregunta($pregunta);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function EditarPregunta($data)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

        $Pregunta = $dbm->getRepositorioById('Pregunta', 'preguntaid', $data['preguntaid']);
        $Pregunta->setPregunta($data['pregunta']);
        $Pregunta->setValorporcentaje($data['valor']);
        $Pregunta->setTipopreguntaid($dbm->getRepositorioById('Tipopregunta', 'tipopreguntaid', $data['tipopreguntaid']));
        $Pregunta->setTipoordenamiento($data["ordenamiento"] != 1);

        $Pregunta->setResaltar($data['resaltar']);
        $Pregunta->setColor($data['color']);
        $Pregunta->setValidar($data['validar']);

        $Pregunta->setAnidada(false);
        $Pregunta->setPadreid(null);

        if ($data["dependiente"]) {
            $respuestaspapa = $dbm->getRepositoriosById('Respuesta', 'preguntaid', $data['relacion']['preguntapapaid']);
            foreach ($respuestaspapa as $rp) {
                if ($rp->getRespuesta() == $data['relacion']['mensajerespuesta']) {
                    $Pregunta->setAnidada(true);
                    $Pregunta->setPadreid($rp);
                }
            }
        }

        $dbm->saveRepositorio($Pregunta);

        $PreguntaPorEvaluacion = $dbm->getRepositorioById('Preguntaporevaluacion', 'preguntaid', $data['preguntaid']);
        $PreguntaPorEvaluacion->setOrden($data['orden']);
        $dbm->saveRepositorio($PreguntaPorEvaluacion);

        switch ($data["tipocomplementoid"]) {
            case 1:
            case 2:
            case 3:
                if ($data['complementoid'] == '') {
                    self::EliminarMultimedia($data['preguntaid']);
                    foreach ($data['complemento'] as $complemento) {
                        $Complemento = new Complemento();
                        $Complemento->setTipocomplementoid($dbm->getRepositorioById("Tipocomplemento", "tipocomplementoid", $data["tipocomplementoid"]));
                        $Complemento->setComplementosize($complemento["size"]);
                        $Complemento->setComplementotipo($complemento["filetype"]);
                        $Complemento->setComplemento($complemento["value"]);
                        $dbm->saveRepositorio($Complemento);

                        $ComplementoporPregunta = new Complementoporpregunta();
                        $ComplementoporPregunta->setPreguntaid($Pregunta);
                        $ComplementoporPregunta->setComplementoid($Complemento);
                        $dbm->saveRepositorio($ComplementoporPregunta);
                    }
                }
                break;
            case 4:
                self::EliminarMultimedia($dbm, $data['preguntaid']);
                $Complemento = new Complemento();
                $Complemento->setTipocomplementoid($dbm->getRepositorioById("Tipocomplemento", "tipocomplementoid", $data["tipocomplementoid"]));
                $Complemento->setComplemento($data["complemento"]);
                $dbm->saveRepositorio($Complemento);

                $ComplementoporPregunta = new Complementoporpregunta();
                $ComplementoporPregunta->setPreguntaid($Pregunta);
                $ComplementoporPregunta->setComplementoid($Complemento);
                $dbm->saveRepositorio($ComplementoporPregunta);
                break;
            default:
                self::EliminarMultimedia($data['preguntaid']);
                break;
        }
        switch ($data['tipopreguntaid']) {
            case 3:
            case 4:
                $respuestaseditas = array();
                $respuestaporpregunta = $dbm->getRepositoriosById("Respuesta", "preguntaid", $data["preguntaid"]);
                foreach ($data['multiples']['respuestas'] as $respuesta) {
                    $Respuesta = $respuesta["respuestaid"] ? $dbm->getRepositorioById("Respuesta", "respuestaid", $respuesta["respuestaid"]) : new Respuesta();
                    if ($Respuesta->getRespuestaid() != '') {
                        array_push($respuestaseditas, $Respuesta->getRespuestaid());
                    }
                    if (!$respuesta["imgid"]) {
                        $complementoeliminar = $Respuesta->getComplementoid();
                        $Respuesta->setComplementoid(null);
                        if ($complementoeliminar) {
                            $dbm->removeRepositorio($complementoeliminar);
                        }
                    }
                    foreach ($respuesta['complemento'] as $img) {
                        $Complemento = new Complemento();
                        $Complemento->setTipocomplementoid($dbm->getRepositorioById("Tipocomplemento", "tipocomplementoid", 1));
                        $Complemento->setComplementosize($img["size"]);
                        $Complemento->setComplementotipo($img["filetype"]);
                        $Complemento->setComplemento($img["value"]);
                        $dbm->saveRepositorio($Complemento);
                        $Respuesta->setComplementoid($Complemento);
                    }
                    $Respuesta->setPreguntaid($Pregunta);
                    $Respuesta->setRespuesta($respuesta['texto']);
                    $Respuesta->setValorporcentaje($respuesta['valor']);
                    $dbm->saveRepositorio($Respuesta);
                }
                foreach ($respuestaporpregunta as $p) {
                    if (!in_array($p->getRespuestaid(), $respuestaseditas)) {
                        $dbm->removeRepositorio($p);
                        if ($p->getComplementoid()) {
                            $dbm->removeRepositorio($p->getComplementoid());
                        }
                    }
                }
                break;
            default:
                $dbm->removeManyRepositorio('Respuesta', 'preguntaid', $data["preguntaid"]);
                break;
        }
    }

    public function EliminarMultimedia($preguntaid)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $ComplementoporPregunta = $dbm->getRepositoriosById("Complementoporpregunta", "preguntaid", $preguntaid);
        $dbm->removeManyRepositorio('Complementoporpregunta', 'preguntaid', $preguntaid);
        foreach ($ComplementoporPregunta as $c) {
            $dbm->removeRepositorio($c->getComplementoid());
        }
    }

}
