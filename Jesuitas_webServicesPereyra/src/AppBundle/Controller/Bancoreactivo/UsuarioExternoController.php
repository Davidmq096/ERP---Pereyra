<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBancoreactivo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use AppBundle\Entity\BrUsuarioexterno;

/**
 * Auto: Javier
 */
class UsuarioExternoController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Bancoreactivos/Usuarioexterno", name="inicioUsuarioexterno")
     */
    public function indexUsuarioexterno() {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $colegio = $dbm->getRepositoriosById('BrColegio', 'activo', 1);
            return new View($colegio, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo de usuarios externo en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Usuarioexterno/", name="BuscarUsuarioexterno")
     */
    public function getUsuarioexterno() {
    	try {
    		$datos = $_REQUEST;
    		$filtros = array_filter($datos);
    		$dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
    		$entidad = $dbm->BuscarUsuaroexterno($filtros);
    		if (!$entidad) {
    			return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
    		}
    		return new View($entidad, Response::HTTP_OK);
    	} catch (Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Bancoreactivos/Usuarioexterno/{id}", name="EliminarUsuarioexterno")
     */
    public function deleteUsuarioexterno($id) {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $usuarioexterno = $dbm->getRepositorioById('BrUsuarioexterno', 'usuarioexternoid', $id);
            $dbm->removeRepositorio($usuarioexterno);
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

    /**
     * @Rest\Post("/api/Bancoreactivos/Usuarioexterno" , name="GuardarUsuarioexterno")
     */
    public function SaveUsuarioexterno() {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            
            $existe = $dbm->getRepositorioById('BrUsuarioexterno','usuario', $data['usuario']);            
            if($existe){
            	return new View("Ya existe un registro con el nombre de usuario", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $usuarioexterno = $hydrator->hydrate(new BrUsuarioexterno(), $data);
            $usuarioexterno->setTipousuarioexternoid($dbm->getRepositorioById('BrTipousuarioexterno', 'tipousuarioexternoid', 2));            
            $usuarioexterno->setContrasena(mt_rand(100000, 999999));
            $dbm->saveRepositorio($usuarioexterno);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Bancoreactivos/Usuarioexterno/{id}" , name="ActualizarUsuarioexterno")
     */
    public function updateUsuarioexterno($id) {
        try {
			parse_str(file_get_contents("php://input"), $data);
			$data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            
            $existe = $dbm->getRepositorioById('BrUsuarioexterno','usuario', $data['usuario']);             
            if($existe){
            	if($existe->getUsuarioexternoid() != $id)
            	return new View("Ya existe un usuario con el mismo colegio, grupo y nombre de usuario", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $usuarioexterno = $hydrator->hydrate($dbm->getRepositorioById('BrUsuarioexterno', 'usuarioexternoid', $data['usuarioexternoid']), $data);
            $dbm->saveRepositorio($usuarioexterno);
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
        	return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna el archivo layout
     * @Rest\Get("/api/Bancoreactivos/Usuarioexterno/Descargar", name="downloadLayoutUsuarios")
     */
    public function downloadLayoutUsuarios() {
    	try {    		
    		$Excel = $this->get('phpexcel')->createPHPExcelObject();
    		$layout = \AppBundle\Dominio\UsuarioExterno::layout($Excel);
    		
    		$writer = $this->get('phpexcel')->createWriter($layout, 'Excel5');
    		$response = $this->get('phpexcel')->createStreamedResponse($writer);
    		
    		$dispositionHeader = $response->headers->makeDisposition(
    				ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'stream-file.xlsx');
    		$response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
    		$response->headers->set('Pragma', 'public');
    		$response->headers->set('Cache-Control', 'maxage=1');
    		$response->headers->set('Content-Disposition', $dispositionHeader);
    		
    		return $response;
    	} catch (\Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }
    
    /**
     * iMPORTA el archivo layout
     * @Rest\Post("/api/Bancoreactivos/Usuarioexterno/Importar", name="importarLayoutUsuarios")
     */
    public function importarLayoutUsuarios() {
    	try {
    		if ($_FILES['layout']['error'] == 1) {
    			return new View("El archivo excede el peso permitido "
    					, Response::HTTP_PARTIAL_CONTENT);
    		}
    		$data = $_REQUEST;
    		$dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
    		$iniPrecision = ini_get('precision');
    		$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($_FILES['archivo']['tmp_name']);
    		ini_set('precision', $iniPrecision);
    		$sheet = $phpExcelObject->getActiveSheet();
    		$datos = $sheet->toArray();
    		
    		if(!in_array('Clave',$datos[0]) || !in_array('Grupo externo',$datos[0]) || !in_array('Nombre',$datos[0]) || !in_array('Apellido paterno',$datos[0]) || !in_array('Apellido materno',$datos[0])){
    			return new View("El archivo no contiene los encabezado necesarios ", Response::HTTP_PARTIAL_CONTENT);
    		}
    		if(sizeof($datos) < 2){
    			return new View("El archivo no contiene datos ", Response::HTTP_PARTIAL_CONTENT);
    		}
    		
    		$usuindex = array_search("Clave", $datos[0]);
    		$gruindex = array_search("Grupo externo", $datos[0]);
    		$nomindex = array_search("Nombre", $datos[0]);
    		$appindex = array_search("Apellido paterno", $datos[0]);
    		$apmindex = array_search("Apellido materno", $datos[0]);    		
    		
    		$dbm->getConnection()->beginTransaction();
    		for($i =1; $i< sizeof($datos); $i++){
    			$usuario = $datos[$i][$usuindex];
    			$grupo = $datos[$i][$gruindex];
    			$nombre = $datos[$i][$nomindex];
    			$appaterno = $datos[$i][$appindex];
    			$apmaterno = $datos[$i][$apmindex];    
    			
    			if($usuario == "" || $grupo == "" || $nombre == "" || $appaterno == "" || $apmaterno == ""){
    				return new View("Faltan campos en la fila ".($i+1), Response::HTTP_PARTIAL_CONTENT);
    			}
    			$existe =$dbm->getRepositorioById('BrUsuarioexterno','usuario', $usuario);
    			if($existe){
    				return new View("Ya existe un usuario con el mismo colegio, grupo y nombre de usuario en la fila ".($i+1), Response::HTTP_PARTIAL_CONTENT);
    			}
    			
    			$usuarioexterno = new BrUsuarioexterno();
    			$usuarioexterno->setTipousuarioexternoid($dbm->getRepositorioById('BrTipousuarioexterno', 'tipousuarioexternoid', 2));
    			$usuarioexterno->setColegioid($dbm->getRepositorioById('BrColegio', 'colegioid', $data['colegioid']));
    			
    			$usuarioexterno->setUsuario($usuario);
    			$usuarioexterno->setGrupo($grupo);
    			$usuarioexterno->setNombre($nombre);
    			$usuarioexterno->setApellidopaterno($appaterno);
    			$usuarioexterno->setApellidomaterno($apmaterno);
    			$usuarioexterno->setContrasena(mt_rand(100000, 999999));
    			
    			$usuarioexterno->setActivo(true);
    			$dbm->saveRepositorio($usuarioexterno);
    		}
    		$dbm->getConnection()->commit();
    		    		
    		return new View("Se proceso correctamente el archivo.", Response::HTTP_OK);
    	} catch (\Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }

}
