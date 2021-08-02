<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBancoreactivo;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\BrCalendarioexamen;
use AppBundle\Entity\BrExamenporcalendario;
use AppBundle\Entity\BrUsuarioexterno;
use AppBundle\Entity\BrUsuarioporexamen;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class CalendarizacionExamenController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Bancoreactivos/Calendarizacionexamen", name="indexCalendarizacionexamen")
     */
    public function indexCalendarizacionexamen()
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $tipoexamen = $dbm->getRepositoriosById('BrTipoexamen', 'activo', 1, 'nombre');
            $examen = $dbm->getRepositoriosById('BrExamen', 'activo', 1, 'nombre');
            $tipoaplicacion = $dbm->getRepositoriosById('BrTipoaplicacion', 'activo', 1, 'nombre');
            $medioaplicacion = $dbm->getRepositoriosById('BrMedioaplicacion', 'activo', 1, 'nombre');
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $colegio = $dbm->getRepositoriosById('BrColegio', 'activo', 1, 'nombre');
            $planestudio = $dbm->getRepositoriosById('CePlanestudios', 'vigente', 1);
            $materia = array();
            foreach ($planestudio as $p) {
                $materia = array_merge(
                    $materia,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid()]
                    )
                );
            }

            return new View(array(
                "tipoexamen" => $tipoexamen,
                "examen" => $examen,
                "planestudio" => $planestudio,
                "materias" => $materia,
                "tipoaplicacion" => $tipoaplicacion,
                "medioaplicacion" => $medioaplicacion,
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                "colegio" => $colegio
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de temas en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Calendarizacionexamen/", name="BuscarCalendarizacionexamen")
     */
    public function getCalendarizacionexamen()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarCalendarizacionexamen($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Bancoreactivos/Calendarizacionexamen/{id}", name="EliminarCalendarizacionexamen")
     */
    public function deleteCalendarizacionexamen($id)
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $calendarioexamen = $dbm->getRepositorioById('BrCalendarioexamen', 'calendarioexamenid', $id);
            $dbm->removeRepositorio($calendarioexamen);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede modificar el evento debido a que los examenes ya han sido iniciados.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Retorna arreglo de temas en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Calendarizacionexamen/Examen", name="BuscarCalendarizacionexamenExamen")
     */
    public function getCalendarizacionexamenExamen()
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            if($datos['materiaid']) {
                $entidad = $dbm->getByParametersRepositorios('BrExamen', array('tipoexamenid' => $datos["tipoexamenid"], 'activo' => 1, 'materiaid' => $datos['materiaid']));
            } else {
                $entidad = $dbm->getByParametersRepositorios('BrExamen', array('tipoexamenid' => $datos["tipoexamenid"], 'activo' => 1));
            }
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach($entidad as $key => $e){
                if(!$e->getExamenpresentacionid()->getMostrarreactivoid() || 
                !$dbm->getRepositorioById('BrReactivoporexamen', 'examenid', $e->getExamenid())){
                    unset($entidad[$key]);
                }
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Verifica si ya existen alumnos que hayan presentado un examen en ese aspecto
     * @Rest\Post("/api/Bancoreactivos/Calendarizacionexamen/VerificarAlumno", name="getAlumnosexamenaplicado")
     */
    public function getAlumnosexamenaplicado()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $alumnos = $dbm->BuscarExamenesAplicadosByAlumno($data);
            return new View($alumnos, Response::HTTP_OK);

        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna arreglo de temas en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Calendarizacionexamen/Asignacion/{id}", name="BuscarCalendarizacionAsignacion")
     */
    public function getCalendarizacionexamenAsignacion($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());

            $calendarioexamen = $dbm->getRepositorioById('BrCalendarioexamen', 'calendarioexamenid', $id);

            $examenes = $dbm->getByParametersRepositorios('BrExamen', array('tipoexamenid' => $calendarioexamen->getTipoexamenid(), 'activo' => 1));
            $examenasignado = $dbm->getRepositoriosById('BrExamenporcalendario', 'calendarioexamenid', $id, "orden");
            $usuarioasignado = $dbm->getRepositoriosById('BrUsuarioporexamen', 'examenporcalendarioid', $examenasignado[0]->getExamenporcalendarioid());
            
            if (!$calendarioexamen) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View(array("examenes"=> $examenes, "examenesasignado"=> $examenasignado, "usuarioasignado" => $usuarioasignado), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

/**
 * Actualiza la informacion de configuracion de un examen
 * @Rest\Post("/api/Bancoreactivos/Calendarizacionexamen/Grupos" , name="getGruposCalendarizacion")
 */
    public function getGruposCalendarizacion()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $filtros = json_decode($content, true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $grupos = $dbm->BuscarGruposPorMateria($filtros);
            $aspectos = $dbm->BuscarAspectospormateria($filtros);
			$periodoeval = $dbm->getRepositoriosModelo("CePeriodoevaluacion", ["d.periodoevaluacionid, d.descripcion, IDENTITY(c.cicloid) as cicloid, IDENTITY(g.gradoid) as gradoid"],
				[["periodoevaluacionid is not null and c.cicloid = " . $filtros['cicloid'] . " and g.gradoid = " . $filtros['gradoid'] ]], false, true, [
				["entidad" => "CeConjuntoperiodoevaluacion", "alias" => "c", "left" => false, "on" => "c.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
				["entidad" => "CeGradoporconjuntoperiodoescolar", "alias" => "g", "left" => false, "on" => "g.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
            ], 'd.periodoevaluacionid');
            
            return new View(['grupos' => $grupos, 'aspectos' => $aspectos, "periodosevaluacion" => $periodoeval], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

/**
 * Actualiza la informacion de configuracion de un examen
 * @Rest\Get("/api/Bancoreactivos/Calendarizacionexamen/Usuario/{tipoaplicacion}" , name="BuscarCalendarizacionexamenUsuario")
 */
    public function getCalendarizacionexamenUsuario($tipoaplicacion)
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());

            $entidad = array();
            switch ($tipoaplicacion) {
                case "1":
                    break;
                case "2":
                    $entidad = $dbm->BuscarUsuaroexterno($filtros);
                    break;
                case "3":
                    $entidad = $dbm->getSolicitudByFilter($filtros);
                    break;
            }

            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
  

    /**
     * @Rest\Post("/api/Bancoreactivos/Calendarizacionexamen" , name="GuardarCalendarizacionexamen")
     */
    public function SaveCalendarizacionexamen()
    {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $data["fechaaplicacion"] = new \DateTime($data["fechaaplicacion"]["date"]["year"] . "-" . $data["fechaaplicacion"]["date"]["month"] . "-" . $data["fechaaplicacion"]["date"]["day"]);
            $data['horainicio'] .= ':00';
            $data['horafin'] .= ':00';

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $calendario = $hydrator->hydrate(new BrCalendarioexamen(), $data);
            $dbm->saveRepositorio($calendario);

            foreach ($data["examen"] as $e) {
                $e["tiempo"] = $e["tiempo"] ? $e["tiempo"].":00" : null;
                $examenporcalendario = $hydrator->hydrate(new BrExamenporcalendario(), $e);
                $examenporcalendario->setCalendarioexamenid($calendario);
                $examenporcalendario->setCriterioevaluaciongrupoid($data['criterioevaluaciongrupoid'] ?
                    $dbm->getRepositorioById('CeCriterioevaluaciongrupo', 'criterioevaluaciongrupoid', $data['criterioevaluaciongrupoid']) : null);
                $examenporcalendario->setNumerocaptura($data['numerocaptura'] ? $data['numerocaptura'] : null);

                $dbm->saveRepositorio($examenporcalendario);
                foreach ($data["usuario"] as $u) {
                    $usuario;
                    switch ($data["tipoaplicacionid"]) {
                        case 1:
                            $usuario = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $u);
                            break;
                        case 2:
                        $usuario = $dbm->getRepositorioById('BrUsuarioexterno', 'usuarioexternoid', $u);
                            break;
                        case 3:
                        $usuario = $dbm->getRepositorioById('BrUsuarioexterno', 'solicitudadmisionid', $u);
                        if (!$usuario) {
                            $Solicitudadmision = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $u);
                            $usuario = new BrUsuarioexterno();
                            $usuario->setUsuario($Solicitudadmision->getFolio());
                            $usuario->setContrasena(mt_rand(100000, 999999));
                            $usuario->setSolicitudadmisionid($Solicitudadmision);
                            $usuario->setGrupo(utf8_decode("Admision"));
                            $usuario->setColegioid($dbm->getRepositorioById('BrColegio', 'colegioid', 1));
                            $usuario->setTipousuarioexternoid($dbm->getRepositorioById('BrTipousuarioexterno', 'tipousuarioexternoid', 1));
                            $dbm->saveRepositorio($usuario);
                        }
                            break;
                    }
                    $Examenporusuario = new BrUsuarioporexamen();
                    $Examenporusuario->setExamenporcalendarioid($examenporcalendario);
                    if($data["tipoaplicacionid"] == 1) {
                        $Examenporusuario->setAlumnoid($usuario);
                    } else {
                        $Examenporusuario->setUsuarioexternoid($usuario);
                    }
                    $Examenporusuario->setIntentosrestantes($examenporcalendario->getIntentosPermitidos());
                    $dbm->saveRepositorio($Examenporusuario);
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Bancoreactivos/Calendarizacionexamen/{id}" , name="ActualizarCalendarizacionexamen")
     */
    public function updateCalendarizacionexamen($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $data["fechaaplicacion"] = new \DateTime($data["fechaaplicacion"]["date"]["year"] . "-" . $data["fechaaplicacion"]["date"]["month"] . "-" . $data["fechaaplicacion"]["date"]["day"]);
            $data['horainicio'] .= ':00';
            $data['horafin'] .= ':00';
            
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $calendario = $hydrator->hydrate($dbm->getRepositorioById('BrCalendarioexamen', 'calendarioexamenid', $id), $data);
            $dbm->saveRepositorio($calendario);

            foreach($data["exameneliminado"] as $e){
                $examenporcalendario  = $dbm->getRepositorioById('BrExamenporcalendario', 'examenporcalendarioid', $e);
                $dbm->removeRepositorio($examenporcalendario );
            }

            foreach ($data["examen"] as $e) {
                $e["tiempo"] = $e["tiempo"] ? $e["tiempo"].":00" : null;
                if($e["examenporcalendarioid"]){
                    $examenporcalendario = $hydrator->hydrate($dbm->getRepositorioById('BrExamenporcalendario', 'examenporcalendarioid', $e["examenporcalendarioid"]), $e);
                    $examenporcalendario->setCriterioevaluaciongrupoid($data['criterioevaluaciongrupoid'] ?
                    $dbm->getRepositorioById('CeCriterioevaluaciongrupo', 'criterioevaluaciongrupoid', $data['criterioevaluaciongrupoid']) : null);
                    $examenporcalendario->setNumerocaptura($data['numerocaptura'] ? $data['numerocaptura'] : null);
                    $dbm->removeManyRepositorio("BrUsuarioporexamen", 'examenporcalendarioid', $e["examenporcalendarioid"]);
                }else{
                    $examenporcalendario = $hydrator->hydrate(new BrExamenporcalendario(), $e);
                    $examenporcalendario->setCalendarioexamenid($calendario);
                }                
                $dbm->saveRepositorio($examenporcalendario);
                foreach ($data["usuario"] as $u) {
                    $usuario;
                    switch ($data["tipoaplicacionid"]) {
                        case 1:
                            $usuario = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $u);
                            break;
                        case 2:
                        $usuario = $dbm->getRepositorioById('BrUsuarioexterno', 'usuarioexternoid', $u);
                            break;
                        case 3:
                        $usuario = $dbm->getRepositorioById('BrUsuarioexterno', 'solicitudadmisionid', $u);
                        if (!$usuario) {
                            $Solicitudadmision = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $u);
                            $usuario = new BrUsuarioexterno();
                            $usuario->setUsuario($Solicitudadmision->getFolio());
                            $usuario->setContrasena(mt_rand(100000, 999999));
                            $usuario->setSolicitudadmisionid($Solicitudadmision);
                            $usuario->setGrupo(utf8_decode("Admision"));
                            $usuario->setColegioid($dbm->getRepositorioById('BrColegio', 'colegioid', 1));
                            $usuario->setTipousuarioexternoid($dbm->getRepositorioById('BrTipousuarioexterno', 'tipousuarioexternoid', 1));
                            $dbm->saveRepositorio($usuario);
                        }
                            break;
                    }
                    $Examenporusuario = new BrUsuarioporexamen();
                    $Examenporusuario->setExamenporcalendarioid($examenporcalendario);
                    if($data["tipoaplicacionid"] == 1) {
                        $Examenporusuario->setAlumnoid($usuario);
                    } else {
                        $Examenporusuario->setUsuarioexternoid($usuario);
                    }
                    $Examenporusuario->setIntentosrestantes($examenporcalendario->getIntentosPermitidos());
                    $dbm->saveRepositorio($Examenporusuario);
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede modificar el evento debido a que los examenes ya han sido iniciados. <br>
                Como alternativa puede copiar el evento", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    

}
