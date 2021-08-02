<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\DB\DbmBancoreactivo;
use AppBundle\Entity\BrRespuestaporusuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier
 */
class CalificacionExamenController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Bancoreactivos/Calificacionexamen", name="indexCalificacionExamen")
     */
    public function indexCalificacionExamen()
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $tipoaplicacion = $dbm->getRepositoriosById('BrTipoaplicacion', 'activo', 1, 'nombre');

            return new View(array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                "tipoaplicacion" => $tipoaplicacion,
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/Bancoreactivos/Calificacionexamen/", name="BuscarCalificacionExamen")
     */
    public function getCalificacionExamen()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarCalificacionexamen($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/Bancoreactivos/Calificacionexamen/Alumnos/{id}", name="BuscarCalificacionExamenalumnos")
     */
    public function getCalificacionExamenAlumnos($id)
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarReactivosResultados(array("examenporcalendarioid" => $id));
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/Bancoreactivos/Calificacionexamen/Detalle/{id}", name="BuscarCalificacionexamendetalle")
     */
    public function getCalificacionexamenDetalle($id)
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarReactivosResultadosDetalle($id);
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            $opcional = array();
            $abierta = array();
            foreach ($entidad as $e) {
                switch ($e["tiporeactivoid"]) {
                    case "1":
                    case "4":
                        array_push($opcional, $e);
                        break;
                    case "2":
                    case "3":
                        array_push($abierta, $e);
                        break;
                }
            }
            return new View(array("opcional" => $opcional, "abierta" => $abierta), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Bancoreactivos/Calificacionexamen/{id}" , name="GuardarCalificacionexamen")
     */
    public function SaveCalificacionexamen($id)
    {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($data as $d) {
                $respuestaporusuario = $dbm->getRepositorioById('BrRespuestaporusuario', 'respuestaporusuarioid', $d['respuestaporusuarioid']);
                $respuestaporusuario->setPuntaje($d['puntaje']);
                $dbm->saveRepositorio($respuestaporusuario);
            }

            $Usuarioporexamen = $dbm->getRepositorioById('BrUsuarioporexamen', 'usuarioporexamenid', $id);

            $entidad = $dbm->BuscarReactivosResultadosDetalle($id);

            $puntajemaximo = 0;
            $puntaje = 0;
            foreach ($entidad as $e) {
                $puntajemaximo += $e["valor"];
                switch ($e["tiporeactivoid"]) {
                    case "1":
                    case "4":
                        $puntaje += $e['cal'] == "1" ? $e["valor"] : 0;
                        break;
                    case "2":
                    case "3":
                        $puntaje += $e['puntaje'] ? $e['puntaje'] : 0;
                        break;
                }
            }
            $calificacion = ($puntaje * $Usuarioporexamen->getExamenporcalendarioid()->getExamenid()->getSistemacalificacionid()->getFin()) / $puntajemaximo;

            $Usuarioporexamen->setPuntaje($puntaje);
            $Usuarioporexamen->setCalificacion(number_format($calificacion, 1));
            $dbm->saveRepositorio($Usuarioporexamen);

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de contenido de un examen
     * @Rest\Post("/api/Bancoreactivos/Calificacionexamen/Gradecam/{id}" , name="ReadCalificacionexamenGradecamArchvio")
     */
    public function readExamenesGradecamArchivo($id)
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());

            $iniPrecision = ini_get('precision');
            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($_FILES['archivo']['tmp_name']);
            ini_set('precision', $iniPrecision);
            $sheet = $phpExcelObject->getActiveSheet();
            $phpExcelObject->getProperties();

            $datos = $sheet->toArray();

            if (!in_array('School', $datos[0]) || !in_array('Class', $datos[0]) ||
                !in_array('Teacher First Name', $datos[0]) || !in_array('Teacher Last Name', $datos[0]) ||
                !in_array('First Name', $datos[0]) || !in_array('Last Name', $datos[0]) ||
                !in_array('Student ID', $datos[0]) || !in_array('Version', $datos[0]) || !in_array('Score', $datos[0])) {
                return new View("El archivo no contiene los encabezado necesarios ", Response::HTTP_PARTIAL_CONTENT);
            }
            if (sizeof($datos) < 3) {
                return new View("El archivo no contiene datos ", Response::HTTP_PARTIAL_CONTENT);
            }

            $examenporcalendario = $dbm->getRepositorioById('BrExamenporcalendario', 'examenporcalendarioid', $id);
            $reactivoporexamen = $dbm->getRepositoriosById('BrReactivoporexamen', 'examenid', $examenporcalendario->getExamenid()->getExamenid(), 'reactivoporexamenid');
            $preguntas = sizeof($datos[0]) - 9;
            if (sizeof($reactivoporexamen) != $preguntas) {
                return new View("El numero de preguntas del archivo no coincide con las del examen. <br>
								Asegurate de estar importando el archivo correcto para este examen.", Response::HTTP_PARTIAL_CONTENT);
            }

            $Puntajemaximo = 0;
            $Respuestascorrectas = array();
            foreach ($reactivoporexamen as $r) {
                $letra = "";
                $respuestas = $dbm->getRepositoriosById("BrRespuestaporreactivo", "reactivoid", $r->getReactivoid()->getReactivoid());
                for ($i = 65; $i < sizeof($respuestas) + 65; $i++) {
                    if ($respuestas[$i - 65]->getCorrecta()) {
                        $letra = chr($i);
                    }
                }
                $correcta = array(
                    "puntaje" => $r->getReactivoid()->getValor(),
                    "reactivoid" => $r->getReactivoid()->getReactivoid(),
                    "respuesta" => $letra,
                );
                array_push($Respuestascorrectas, $correcta);
                $Puntajemaximo += $r->getReactivoid()->getValor();
            }

            $username = array_search("Student ID", $datos[0]);
            $nombre = array_search("First Name", $datos[0]);
            $apellido = array_search("Last Name", $datos[0]);
            $respuesta = array();
            $usuariosnoencontrados = array();
            for ($i = 2; $i < sizeof($datos); $i++) {
                $usuario = $dbm->getRepositorioById('BrUsuarioexterno', 'usuario', $datos[$i][$username]);
                $usuarioporexamen = $usuario ? $dbm->getByParametersRepositorios('BrUsuarioporexamen', array('examenporcalendarioid' => $id, "usuarioexternoid" => $usuario->getUsuarioexternoid())) : null;
                if ($usuarioporexamen) {
                    $respuestasusuario = array();
                    $puntaje = 0;
                    for ($x = 9; $x < sizeof($Respuestascorrectas) + 9; $x++) {
                        $puntaje += $Respuestascorrectas[$x - 9]["respuesta"] == $datos[$i][$x] ? $Respuestascorrectas[$x - 9]["puntaje"] : 0;
                        array_push($respuestasusuario, array(
                            "reactivoid" => $Respuestascorrectas[$x - 9]["reactivoid"],
                            "respuesta" => $datos[$i][$x],
                            "correcta" => $Respuestascorrectas[$x - 9]["respuesta"] == $datos[$i][$x]));
                    }
                    $calificacion = ($puntaje * $reactivoporexamen[0]->getExamenid()->getSistemacalificacionid()->getFin()) / $Puntajemaximo;
                    $obj = array(
                        "usuarioexternoid" => $usuario->getUsuarioexternoid(),
                        "username" => $datos[$i][$username],
                        "nombre" => $datos[$i][$nombre],
                        "apellido" => $datos[$i][$apellido],
                        "puntaje" => $puntaje,
                        "calificacion" => number_format($calificacion,1),
                        "respuestas" => $respuestasusuario,
                    );
                    array_push($respuesta, $obj);
                } else {
                    array_push($usuariosnoencontrados, array(
                        "username" => $datos[$i][$username],
                        "nombre" => $datos[$i][$nombre],
                        "apellido" => $datos[$i][$apellido],
                    ));
                }
            }

            return new View(array("respuesta" => $respuesta, "noencontrados" => $usuariosnoencontrados), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de contenido de un examen
     * @Rest\Put("/api/Bancoreactivos/Calificacionexamen/Gradecam/{id}" , name="updateCalificacionexamenGradecamArchvio")
     */
    public function updateExamenesGradecamArchivo($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($data["datos"] as $e) {
                $usuarioexamen = $dbm->getByParametersRepositorios('BrUsuarioporexamen', array('usuarioexternoid' => $e["usuarioexternoid"], 'examenporcalendarioid' => $id))[0];
                $usuarioexamen->setIntentosrestantes(0);
                $usuarioexamen->setAplicado(true);
                $usuarioexamen->setPuntaje($e["puntaje"]);
                $usuarioexamen->setCalificacion($e["calificacion"]);
                $dbm->saveRepositorio($usuarioexamen);

                foreach ($e["respuestas"] as $r) {
                    $respuestasvieja = $dbm->getByParametersRepositorios('BrRespuestaporusuario', array('usuarioexamenid' => $usuarioexamen, 'reactivoid' => $r["reactivoid"]));
                    $Respuestaporusuario = $respuestasvieja ? $respuestasvieja[0] : new BrRespuestaporusuario();
                    $Respuestaporusuario->setUsuarioexamenid($usuarioexamen);
                    $Respuestaporusuario->setReactivoid($dbm->getRepositorioById("BrReactivo", "reactivoid", $r["reactivoid"]));

                    $respuestas = $dbm->getRepositoriosById("BrRespuestaporreactivo", "reactivoid", $r["reactivoid"]);
                    $index = ord($r["respuesta"]) - 65;
                    $Respuestaporusuario->setRespuestaid($respuestas[$index]);

                    $dbm->saveRepositorio($Respuestaporusuario);
                }
            }
            $dbm->getConnection()->commit();
            return new View("Los datos se han importado correctamente", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
