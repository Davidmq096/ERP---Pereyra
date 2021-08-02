<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBancoreactivo;
use AppBundle\Entity\BrComplementoporexamen;
use AppBundle\Entity\BrExamen;
use AppBundle\Entity\BrExamenpresentacion;
use AppBundle\Entity\BrReactivoporexamen;
use AppBundle\Entity\Complemento;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class ExamenController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Bancoreactivos/Examenes", name="indexExamenes")
     */
    public function indexExamenes()
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $area = $dbm->getRepositoriosById('CeAreaacademica', 'activo', 1, 'nombre');
            $materia = $dbm->getRepositoriosById('Materia', 'activo', 1, 'nombre');
            $tipoexamen = $dbm->getRepositoriosById('BrTipoexamen', 'activo', 1, 'nombre');
            $sistemacalificacion = $dbm->getRepositoriosById('BrSistemacalificacion', 'activo', 1, 'nombre');
            $tipocomplemento = $dbm->getByParametersRepositorios('Tipocomplemento', array('activo' => 1, 'tipocomplementoid' => array(2, 3)));
            $mostrarreactivos = $dbm->getRepositoriosById('BrMostrarreactivos', 'activo', 1);
            $tema = $dbm->getRepositoriosById('BrTema', 'activo', 1, 'nombre');
            $subtema = $dbm->getRepositoriosById('BrSubtema', 'activo', 1, 'nombre');
            $tiporeactivo = $dbm->getRepositoriosById('BrTiporeactivo', 'activo', 1, 'nombre');
            $campoformacion = $dbm->getRepositoriosById('BrCampoformacion', 'activo', 1);

            return new View(array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                "area" => $area,
                "tema" => $tema,
                "subtema" => $subtema,
                "materia" => $materia,
                "tiporeactivo" => $tiporeactivo,
                "sistemacalificacion" => $sistemacalificacion,
                "tipoexamen" => $tipoexamen,
                "tipocomplemento" => $tipocomplemento,
                "mostrarreactivos" => $mostrarreactivos,
                "examen" => $examen,
                "campoformacion" => $campoformacion,
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de examenes en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Examenes/", name="BuscarExamenes")
     */
    public function getExamenes()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarExamenes($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Inserta un nuevo examen
     * @Rest\Post("/api/Bancoreactivos/Examenes/Configuracion" , name="GuardarExamenesConfiguracion")
     */
    public function saveExamenesConfiguracion()
    {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Examenpresentacion = new BrExamenpresentacion();
            $dbm->saveRepositorio($Examenpresentacion);
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Examen = $hydrator->hydrate(new BrExamen(), $data);
            $Examen->setExamenpresentacionid($Examenpresentacion);
            $dbm->saveRepositorio($Examen);

            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha guardado el registro", "examen" => $Examen), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de configuracion de un examen
     * @Rest\Put("/api/Bancoreactivos/Examenes/Configuracion/{id}" , name="ActualizarExamenesConfiguracion")
     */
    public function updateExamenesConfiguracion($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Examen = $hydrator->hydrate($dbm->getRepositorioById('BrExamen', 'examenid', $id), $data);
            $dbm->saveRepositorio($Examen);
            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha actualizado el registro", "examen" => $Examen), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna los archivos multimedia del contenido de un examen
     * @Rest\Get("/api/Bancoreactivos/Examenes/Multimedia/{id}", name="BuscarMultimediaExamenesContenido")
     */
    public function getMultimediaContenido($id)
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $Complementos = $dbm->getRepositoriosById('BrComplementoporexamen', 'examenid', $id);
            foreach ($Complementos as $c) {
                $c->getComplementoid()->setComplemento(stream_get_contents($c->getComplementoid()->getComplemento()));
            }
            return new View($Complementos, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de contenido de un examen
     * @Rest\Put("/api/Bancoreactivos/Examenes/Contenido/{id}" , name="ActualizarExamenesContenido")
     */
    public function updateExamenesContenido($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Examen = $dbm->getRepositorioById('BrExamen', 'examenid', $id);
            $ExamenPresentacion = $Examen->getExamenpresentacionid();
            $ExamenPresentacion->setInstrucciones($data["instrucciones"]);
            

            switch ($data['tipomultimediaid']) {
                case null:
                    $Complementoporexamen = $dbm->getRepositoriosById('BrComplementoporexamen', 'examenid', $id);
                    foreach ($Complementoporexamen as $c) {
                        $complemento = $c->getComplementoId();
                        $dbm->removeRepositorio($c);
                        $dbm->removeRepositorio($complemento);
                    }
                case 2:
                case 3:
                    if ($data["multimedia"] != false) {
                        $Complementoporexamen = $dbm->getRepositoriosById('BrComplementoporexamen', 'examenid', $id);
                        foreach ($Complementoporexamen as $c) {
                            $complemento = $c->getComplementoId();
                            $dbm->removeRepositorio($c);
                            $dbm->removeRepositorio($complemento);
                        }
                        foreach ($data["multimedia"] as $m) {
                            $Complemento = new Complemento();
                            $Complemento->setTipocomplementoid($dbm->getRepositorioById("Tipocomplemento", "tipocomplementoid", $data['tipomultimediaid']));
                            $Complemento->setComplementosize($m["size"]);
                            $Complemento->setComplementotipo($m["filetype"]);
                            $Complemento->setComplemento($m["value"]);
                            $dbm->saveRepositorio($Complemento);

                            $Complementoporexamen = new BrComplementoporexamen();
                            $Complementoporexamen->setComplementoid($Complemento);
                            $Complementoporexamen->setExamenid($Examen);
                            $dbm->saveRepositorio($Complementoporexamen);
                        }
                    }
                    break;
            }
            $dbm->getConnection()->commit();
            $dbm->saveRepositorio($ExamenPresentacion);
            $dbm->saveRepositorio($Examen);

            return new View(array("msj" => "Se ha actualizado el registro", "examen" => $Examen), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna los reactivos asignados al examen
     * @Rest\Get("/api/Bancoreactivos/Examenes/Reactivos/{id}", name="BuscarExamenesReactivos")
     */
    public function getReactivos($id)
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $Reactivos = $dbm->getRepositoriosById('BrReactivoporexamen', 'examenid', $id, 'reactivoporexamenid');
            return new View($Reactivos, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de configuracion de un examen
     * @Rest\Put("/api/Bancoreactivos/Examenes/Reactivosasignados/{id}" , name="ActualizarExamenesReactivosasignados")
     */
    public function updateExamenesReactivosasignados($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Examen = $dbm->getRepositorioById('BrExamen', 'examenid', $id);

            $ExamenPresentacion = $Examen->getExamenpresentacionid();
            $ExamenPresentacion->setMostrarreactivoid($dbm->getRepositorioById('BrMostrarreactivos', 'mostrarreactivosid', $data["mostrarreactivoid"]));
            $ExamenPresentacion->setOrdenaleatorioreactivo($data['ordenaleatorioreactivos']);
            $ExamenPresentacion->setOrdenaleatoriorespuesta($data['ordenaleatoriorespuestas']);
            $ExamenPresentacion->setSeleccionaleatorioreactivos($data['seleccionaleatoriareactivos']);
            $ExamenPresentacion->setCantidadreactivos($data['seleccionaleatoriareactivos'] ? $data['cantidadreactivos'] : null);
            
            if ($data["reactivos"]) {
                //eliminamos todas los reactivos relacionados al examne y le asignamos los del array
                $dbm->removeManyRepositorio('BrReactivoporexamen', 'examenid', $id);
                foreach ($data["reactivos"] as $reactivoid) {
                    $Reactivoporexamen = new BrReactivoporexamen();
                    $Reactivoporexamen->setExamenid($Examen);
                    $Reactivoporexamen->setReactivoid($dbm->getRepositorioById('BrReactivo', 'reactivoid', $reactivoid));
                    $dbm->saveRepositorio($Reactivoporexamen);
                }

                $ExamenPresentacion->setCalificacionautomatica(true);
                $reactivos = $dbm->getRepositoriosById('BrReactivoporexamen', 'examenid', $id);
                foreach ($reactivos as $r) {
                    if ($r->getReactivoid()->getTiporeactivoid()->getTiporeactivoid() == 2 || $r->getReactivoid()->getTiporeactivoid()->getTiporeactivoid() == 3) {
                        $ExamenPresentacion->setCalificacionautomatica(false);
                    }
                }

            }

            $dbm->saveRepositorio($ExamenPresentacion);
            $dbm->getConnection()->commit();

            $Reactivosasignados = $dbm->getRepositoriosById('BrReactivoporexamen', 'examenid', $id, 'reactivoporexamenid');
            return new View(array("msj" => "Se ha actualizado el registro", "examen" => $Examen, "reactivosasignados" => $Reactivosasignados), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de configuracion de un examen
     * @Rest\Put("/api/Bancoreactivos/Examenes/Reactivosdisponibles/{id}" , name="ActualizarExamenesReactivosdisponibles")
     */
    public function updateExamenesReactivosdisponibles($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Examen = $dbm->getRepositorioById('BrExamen', 'examenid', $id);
            foreach ($data["reactivosid"] as $reactivoid) {
                $Reactivoporexamen = new BrReactivoporexamen();
                $Reactivoporexamen->setExamenid($Examen);
                $Reactivoporexamen->setReactivoid($dbm->getRepositorioById('BrReactivo', 'reactivoid', $reactivoid));
                $dbm->saveRepositorio($Reactivoporexamen);
            }

            $Reactivosasignados = $dbm->getRepositoriosById('BrReactivoporexamen', 'examenid', $id);
            $ExamenPresentacion = $Examen->getExamenpresentacionid();
            $Calificacionautomatica = true;            
            foreach ($Reactivosasignados as $r) {
                if ($r->getReactivoid()->getTiporeactivoid()->getTiporeactivoid() == 2 || $r->getReactivoid()->getTiporeactivoid()->getTiporeactivoid() == 3) {
                    $Calificacionautomatica = false;  
                }
            }
            $ExamenPresentacion->setCalificacionautomatica($Calificacionautomatica);
            $dbm->saveRepositorio($ExamenPresentacion);
            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha actualizado el registro", "examen" => $Examen, "reactivosasignados" => $Reactivosasignados), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de la especificaciones del examen
     * @Rest\Get("/api/Bancoreactivos/Examenes/Especificaciones/{id}", name="BuscarExamenesEspecificaciones")
     */
    public function getExamenesEspecificaciones($id)
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarExamenesEspecificaciones($id);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de contenido de un examen
     * @Rest\Post("/api/Bancoreactivos/Examenes/Copia/{id}" , name="CopiaExamenes")
     */
    public function copiaExamenes($id)
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $ExamenO = $dbm->getRepositorioById('BrExamen', 'examenid', $id);
            $ExamenPresentacionO = $ExamenO->getExamenpresentacionid();

            $ExamenPresentacion = clone $ExamenPresentacionO;
            $dbm->saveRepositorio($ExamenPresentacion);

            $Examen = clone $ExamenO;
            $Examen->setExamenpresentacionid($ExamenPresentacion);
            $Examen->setActivo(true);
            $Examen->setClave(null);
            $Examen->setNombre(null);
            $Examen->setDescripcion(null);
            $dbm->saveRepositorio($Examen);

            $ComplementoporexamenO = $dbm->getRepositoriosById('BrComplementoporexamen', 'examenid', $id);
            foreach ($ComplementoporexamenO as $c) {
                $Complemento = clone $c->getComplementoid();
                $Complementoporexamen = new BrComplementoporexamen();
                $Complementoporexamen->setComplementoid($Complemento);
                $Complementoporexamen->setExamenid($Examen);
                $dbm->saveRepositorio($Complementoporexamen);
            }

            $ReactivosO = $dbm->getRepositoriosById('BrReactivoporexamen', 'examenid', $id, 'reactivoporexamenid');
            foreach ($ReactivosO as $r) {
                $Reactivoporexamen = new BrReactivoporexamen();
                $Reactivoporexamen->setExamenid($Examen);
                $Reactivoporexamen->setReactivoid($r->getReactivoid());
                $dbm->saveRepositorio($Reactivoporexamen);
            }

            $dbm->getConnection()->commit();

            return new View(array("msj" => "La copia se realizo de forma exitosa",
                "entidad" => $Examen), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Bancoreactivos/Examenes/{id}", name="EliminarExamenes")
     */
    public function deletePais($id) {
        try {
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
            
            $examen = $dbm->getRepositorioById('BrExamen', 'examenid', $id);

            $complementoporexamen = $dbm->getRepositoriosById('BrComplementoporexamen', 'examenid', $id);
            foreach($complementoporexamen as $c){
                $dbm->removeRepositorio($c->getComplementoid());
            }
            $dbm->removeRepositorio($examen->getExamenpresentacionid());
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
        	if($e->getPrevious()->getCode() == "23000"){
        		return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
        	}else{
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        	}
        }
    }

}
