<?php

namespace AppBundle\Controller\Bancoreactivo;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBancoreactivo;
use AppBundle\Entity\BrReactivo;
use AppBundle\Entity\BrComplementoporreactivo;
use AppBundle\Entity\Complemento;
use AppBundle\Entity\BrRespuestaporreactivo;
use AppBundle\Entity\BrComplementoporrespuesta;
use AppBundle\Entity\BrBitacorareactivo;

/**
 * Auto: javier
 */
class ReactivosController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Bancoreactivos/Reactivos", name="indexReactivos")
     */
    public function indexReactivo() {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);

            $area = $dbm->getRepositoriosById('CeAreaacademica', 'activo', 1, 'nombre');
            $tema = $dbm->getRepositoriosById('BrTema', 'activo', 1, 'nombre');
            $subtema = $dbm->getRepositoriosById('BrSubtema', 'activo', 1, 'nombre');
            $materia = $dbm->getRepositoriosById('Materia', 'activo', 1, 'nombre');

            $tipoexamen = $dbm->getRepositoriosById('BrTipoexamen', 'activo', 1, 'nombre');
            $tiporeactivo = $dbm->getRepositoriosById('BrTiporeactivo', 'activo', 1, 'nombre');
            $gradodificultad = $dbm->getRepositoriosById('BrGradodificultad', 'activo', 1);
            $estatusreactivo = $dbm->getRepositoriosById('BrEstatusreactivo', 'activo', 1);
            $niveltaxonomico = $dbm->getRepositoriosById('BrNiveltaxonomico', 'activo', 1, 'nombre');
            $bloqueunidad = $dbm->getRepositoriosById('BrBloqueunidad', 'activo', 1);
            $tipocomplemento =$dbm->getByParametersRepositorios('Tipocomplemento', array('activo' => 1, 'tipocomplementoid' => array(2,3)));
            $motivorechazo = $dbm->getRepositoriosById('BrMotivorechazo', 'activo', 1, 'descripcion');
            $campoformacion = $dbm->getRepositoriosById('BrCampoformacion', 'activo', 1);

            return new View(array(
                "nivel" => $nivel,
                "grado" => $grado,
                "area" => $area,
                "tema" => $tema,
                "subtema" => $subtema,
                "materia" => $materia,
                "tipoexamen" => $tipoexamen,
                "tiporeactivo" => $tiporeactivo,
                "gradodificultad" => $gradodificultad,
                "estatusreactivo" => $estatusreactivo,
                "niveltaxonomico" => $niveltaxonomico,
                "bloqueunidad" => $bloqueunidad,
                "tipocomplemento" => $tipocomplemento,
                "motivorechazo" => $motivorechazo,
                "campoformacion" => $campoformacion
                    ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de reactivos en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Reactivos/", name="BuscarReactivos")
     */
    public function getReactivos() {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarReactivos($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Inserta un nuevo reactivo
     * @Rest\Post("/api/Bancoreactivos/Reactivos/Configuracion" , name="GuardarReactivoConfiguracion")
     */
    public function saveReactivoConfiguracion() {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Reactivo = $hydrator->hydrate(new BrReactivo(), $data);
            $Reactivo->setEstatusreactivoid($dbm->getRepositorioById('BrEstatusreactivo', 'estatusreactivoid', 1));
            $dbm->saveRepositorio($Reactivo);
            self::saveBitacora($Reactivo, $data["usuarioid"], 1, null, null);
            
            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha guardado el registro", "reactivo" => $Reactivo), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de configuracion de un reactivo
     * @Rest\Put("/api/Bancoreactivos/Reactivos/Configuracion/{id}" , name="ActualizarReactivoConfiguracion")
     */
    public function updateReactivoConfiguracion($id) {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Reactivo = $hydrator->hydrate($dbm->getRepositorioById('BrReactivo', 'reactivoid', $id), $data);
            $dbm->saveRepositorio($Reactivo);
            
            self::saveBitacora($Reactivo, $data["usuarioid"], 2, null, null);
            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha actualizado el registro", "reactivo" => $Reactivo), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna los archivos multimedia del contenido de un reactivo
     * @Rest\Get("/api/Bancoreactivos/Reactivos/Multimedia/{id}", name="BuscarMultimediaReactivosContenido")
     */
    public function getMultimediaContenido($id) {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $Complementos = $dbm->getRepositoriosById('BrComplementoporreactivo', 'reactivoid', $id);
            foreach ($Complementos as $c) {
            	$c->getComplementoid()->setComplemento(stream_get_contents($c->getComplementoid()->getComplemento()));                
            }
            return new View($Complementos, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de contenido de un reactivo
     * @Rest\Put("/api/Bancoreactivos/Reactivos/Contenido/{id}" , name="ActualizarReactivoContenido")
     */
    public function updateReactivoContenido($id) {
        try {
        	parse_str(file_get_contents("php://input"), $data);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Reactivo = $dbm->getRepositorioById('BrReactivo', 'reactivoid', $id);
            $Reactivo->setDescripcion($data["descripcion"]);
            $Reactivo->setBibliografia($data["bibliografia"]);
            //$Reactivo->setEstatusreactivoid($dbm->getRepositorioById('BrEstatusreactivo', 'estatusreactivoid', 1));

            switch ($data['tipomultimediaid']) {
                case null:
                    $Complementoporreactivo = $dbm->getRepositoriosById('BrComplementoporreactivo', 'reactivoid', $id);
                    foreach ($Complementoporreactivo as $c) {
                        $complemento = $c->getComplementoId();
                        $dbm->removeRepositorio($c);
                        $dbm->removeRepositorio($complemento);
                    }
                    break;
                case 2:
                case 3:
                    if ($data["multimedia"] != "false") {
                        $Complementoporreactivo = $dbm->getRepositoriosById('BrComplementoporreactivo', 'reactivoid', $id);
                        foreach ($Complementoporreactivo as $c) {
                            $complemento = $c->getComplementoId();
                            $dbm->removeRepositorio($c);
                            $dbm->removeRepositorio($complemento);
                        }
                        foreach ($data["multimedia"] as $key=>$m) {
                            $Complemento = new Complemento();
                            $Complemento->setTipocomplementoid($dbm->getRepositorioById("Tipocomplemento", "tipocomplementoid", $data['tipomultimediaid']));
                            $Complemento->setComplementosize($m["size"]);
                            $Complemento->setComplementotipo($m["filetype"]);
                            $Complemento->setComplemento($m["value"]);
                            $dbm->saveRepositorio($Complemento);

                            $Complementoporreactivo = new BrComplementoporreactivo();
                            $Complementoporreactivo->setComplementoid($Complemento);
                            $Complementoporreactivo->setReactivoid($Reactivo);
                            $Complementoporreactivo->setOrden($key+ 1);
                            $dbm->saveRepositorio($Complementoporreactivo);
                        }
                    }
                    break;
            }

            $dbm->saveRepositorio($Reactivo);
            self::saveBitacora($Reactivo, $data["usuarioid"], 2, null, null);
            $dbm->getConnection()->commit();

            return new View(array("msj" => "Se ha actualizado el registro", "reactivo" => $Reactivo), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna los archivos multimedia de las respuestas de un reactivo
     * @Rest\Get("/api/Bancoreactivos/Reactivos/Respuesta/{id}", name="BuscarRespuesta")
     */
    public function getReactivoRespuesta($id) {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $Respuestas = $dbm->getRepositoriosById('BrRespuestaporreactivo', 'reactivoid', $id);
            return new View($Respuestas, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de las respuestas de un reactivo
     * @Rest\Put("/api/Bancoreactivos/Reactivos/Respuesta/{id}" , name="ActualizarReactivoRespuestas")
     */
    public function updateReactivoRespuestas($id) {
        try {
        	parse_str(file_get_contents("php://input"), $data);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Reactivo = $dbm->getRepositorioById('BrReactivo', 'reactivoid', $id);
            $Reactivo->setTiporeactivoid($dbm->getRepositorioById('BrTiporeactivo', 'tiporeactivoid', $data["tiporeactivoid"]));
            //$Reactivo->setEstatusreactivoid($dbm->getRepositorioById('BrEstatusreactivo', 'estatusreactivoid', 1));
            $dbm->saveRepositorio($Reactivo);

            if (isset($data["respuestaseliminadas"]))
                foreach ($data["respuestaseliminadas"] as $eliminada) {
                    $r = $dbm->getRepositorioById('BrRespuestaporreactivo', 'respuestaporreactivoid', $eliminada);
                    $dbm->removeRepositorio($r);
                }
            
            foreach ($data["respuestas"] as $r){
                $Respuesta = $r["respuestaid"] == "" ? new BrRespuestaporreactivo() : $dbm->getRepositorioById('BrRespuestaporreactivo', 'respuestaporreactivoid', $r["respuestaid"]);
                $Respuesta->setReactivoid($Reactivo);
                $Respuesta->setComentario($r["comentario"]);
                if ($data["tiporeactivoid"] == "1" || $data["tiporeactivoid"] == "4") {
                    $Respuesta->setDescripcion($r["descripcion"]);
                    $Respuesta->setCorrecta($r["correcta"] == "true" ? true : false);
                }
                $dbm->saveRepositorio($Respuesta);            }
            
            self::saveBitacora($Reactivo, $data["usuarioid"], 2, null, null);
            $dbm->getConnection()->commit();

            return new View(array("msj" => "Se ha actualizado el registro", "reactivo" => $Reactivo), Response::HTTP_OK);
        } catch (\Exception $e) {
            if($e->getPrevious()->getCode() == "23000"){
        		return new View("No se puede eliminar el registro, el reactivo ya ha sido utilizado.", Response::HTTP_PARTIAL_CONTENT);
        	}else{
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        	}
        }
    }

    /**
     * Actualiza la informacion de estandarizacion de un reactivo
     * @Rest\Put("/api/Bancoreactivos/Reactivos/Estandarizacion/{id}" , name="ActualizarReactivoEstandarizacion")
     */
    public function updateReactivoEstandarizacion($id) {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Reactivo = $hydrator->hydrate($dbm->getRepositorioById('BrReactivo', 'reactivoid', $id), $data);
            $dbm->saveRepositorio($Reactivo);
            self::saveBitacora($Reactivo, $data["usuarioid"], 2, null, null);
            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha actualizado el registro", "reactivo" => $Reactivo), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    public function saveBitacora($Reactivo, $Usuarioid, $Accionid, $Motivorechazoid, $Comentario){
    	$dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
    	$Bitacora = new BrBitacorareactivo();
    	$Bitacora->setFecha(new \DateTime());
    	$Bitacora->setHora(new \DateTime());
    	$Bitacora->setReactivoid($Reactivo);
    	$Bitacora->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $Usuarioid));
    	$Bitacora->setTipoaccionbitacorareactivoid($dbm->getRepositorioById('BrTipoaccionbitacorareactivo', 'tipoaccionbitacorareactivoid', $Accionid));
        $Bitacora->setMotivorechazoid($dbm->getRepositorioById('BrMotivorechazo', 'motivorechazoid', $Motivorechazoid));
        $Bitacora->setComentariorechazo($Comentario);
    	$dbm->saveRepositorio($Bitacora);
    }

    /**
     * Retorna la bitacora de un reactivo
     * @Rest\Get("/api/Bancoreactivos/Reactivos/Bitacora/{id}", name="BuscarReactivosBitacora")
     */
    public function getBitacora($id) {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $Bitacora = $dbm->BitacoraReactivos($id);
            return new View($Bitacora, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza el estatus de reactivos
     * @Rest\Put("/api/Bancoreactivos/Reactivos/Estatus" , name="ActualizarReactivoEstatus")
     */
    public function updateReactivoEstatus() {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            
            $tipoaccion = null;
            $motivorechazoid = null;
            foreach ($data["reactivoid"] as $reactivoid) {
            	$Reactivo = $dbm->getRepositorioById('BrReactivo', 'reactivoid', $reactivoid);
                switch ($data["estatusreactivoid"]) {
                    case "2":
                    	if(empty($Reactivo->getDescripcion())){
                    		return new View("Faltan campos por completar en la pestaña de contenido del reactivo N°".$Reactivo->getReactivoid(), Response::HTTP_PARTIAL_CONTENT);                    		
                    	}
                    	if(empty($Reactivo->getTiporeactivoid())){
                    		return new View("Faltan campos por completar en la pestaña de respuestas del reactivo N°".$Reactivo->getReactivoid(), Response::HTTP_PARTIAL_CONTENT);
                    	}
                    	if(empty($Reactivo->getGradodificultadid())){
                    		return new View("Faltan campos por completar en la pestaña de estandarizacion del reactivo N°".$Reactivo->getReactivoid(), Response::HTTP_PARTIAL_CONTENT);
                    	}
                    	$tipoaccion = 3;
                        break;
                    case "3":
                    	//$Reactivo->setComentariorechazo($data["comentario"]);
                    	//$Reactivo->setMotivorechazoid($dbm->getRepositorioById('BrMotivorechazo', 'motivorechazoid', $data["motivorechazoid"]));
                        $cometario = $data["comentario"];
                        $motivorechazoid = $data["motivorechazoid"];
                    	$tipoaccion = 4;
                    	break;
                    case "4":
                    	$tipoaccion = 5;
                    	break;
                    case "5":
                    	$tipoaccion = 6;
                    	break;
                    case "6":
                    	$tipoaccion = 7;
                    	break;
                }
                $Reactivo->setEstatusreactivoid($dbm->getRepositorioById('BrEstatusreactivo', 'estatusreactivoid', $data["estatusreactivoid"]));
                $dbm->saveRepositorio($Reactivo);
                self::saveBitacora($Reactivo, $data["usuarioid"], $tipoaccion, $motivorechazoid, $cometario);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Bancoreactivos/Reactivo/{id}", name="EliminarReactivo")
     */
    public function deleteReactivo($id) {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Reactivo = $dbm->getRepositorioById('BrReactivo', 'reactivoid', $id);

            //Elimino el contenido multimedia del reactivo
            $Complementoporreactivo = $dbm->getRepositoriosById('BrComplementoporreactivo', 'reactivoid', $Reactivo->getReactivoid());
            foreach ($Complementoporreactivo as $c) {
                $complemento = $c->getComplementoId();
                $dbm->removeRepositorio($complemento);
            }
            $dbm->removeRepositorio($Reactivo);
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
     * Retorna los examenes que contienen el reactivo
     * @Rest\Get("/api/Bancoreactivos/Reactivos/Examen/{id}", name="BuscarExamenReactivosConfiguracion")
     */
    public function getExamenReactivo($id) {
    	try {
    		$datos = $_REQUEST;
    		$dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
    		$Examen = $dbm->getRepositoriosById('BrReactivoporexamen', 'reactivoid', $id);
    		return new View($Examen, Response::HTTP_OK);
    	} catch (Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }
    
    /**
     * Retorna los archivos multimedia del contenido de un reactivo
     * @Rest\Get("/api/Bancoreactivos/Reactivos/Preview/", name="BuscarReactivoPreview")
     */
    public function getPreview() {
        try {
        	$datos = $_REQUEST;
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $Examen = array();
            foreach ($datos["reactivosid"] as $r){
            	$Reactivo = $dbm->getRepositorioById('BrReactivo', 'reactivoid', $r);
            	$Complementos = self::getMultimediaContenido($Reactivo->getReactivoid())->getData();
            	$Respuestas = self::getReactivoRespuesta($Reactivo->getReactivoid())->getData();
            	array_push($Examen, array("reactivo" => $Reactivo, "complementos" =>$Complementos, "respuestas"=> $Respuestas));
            }
            return new View($Examen, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
