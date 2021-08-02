<?php

namespace AppBundle\Controller\Admisiones;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Documentoporgrado;
use AppBundle\Entity\Documento;

use AppBundle\DB\DbmAdmisiones;

/**
 * Auto: David
 */
class DocumentoPorGradoController extends FOSRestController {

    /**
     * Retorna arreglo que los datos de documento y nivel para cargar de innicio la pagina 
     * @Rest\Get("/api/Documentoporgrado", name="InicioDocumentoporgrado")
     */
    public function indexDocumento() {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $documento = $dbm->getRepositoriosById('Documento', 'activo', 1,'nombre');
            $tipoDocumento = $dbm->getRepositoriosById('Tipodocumento', 'activo', 1, 'nombre');
       
            return new View(array("nivel" => $nivel, "grado" => $grado, "documento" => $documento, "tipodocumento" => $tipoDocumento), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo que los datos de documento y nivel para cargar de innicio la pagina
     * @Rest\Get("/api/Documentoporgrado/", name="BuscarDocumentoporgrado")
     */
    public function getDocumento() {
    	try {
    		$datos = $_REQUEST;
    		$filtros = array_filter($datos);
    		$dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
    		$entidad = $dbm->BuscarDocumentoGrado($filtros);
    		if (!$entidad) {
    			return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
    		}
    		return new View($entidad, Response::HTTP_OK);
    	} catch (\Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }

    /**
     * Guarda los Documentos por grado y sus relaciones con documento
     * @Rest\Post("/api/Documentoporgrado" , name="GuardarDocumentoporgrado")
     */
    public function saveDocumento() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $dporg =  $dbm->getByParametersRepositorios('Documentoporgrado', array('gradoid' => $data['gradoid'], 'documentoid' => $data['documentoid']));
            if ($dporg) {
                return new View("El documento ya ha sido asignado al grado", Response::HTTP_PARTIAL_CONTENT);
            }
  
            $DPG = new Documentoporgrado();
            $DPG->setCopia($data['copia']);
            $DPG->setOriginal($data['original']);
            $DPG->setActivo($data['activo']);
            $DPG->setGradoid(empty($data['gradoid']) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']));
            $DPG->setDocumentoid($dbm->getRepositorioById('Documento', 'documentoid', $data['documentoid']));
            $dbm->saveRepositorio($DPG);
            
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Documentoporgrado/{id}", name="EliminarDocumentoporgrado")
     */
    public function deleteDocumento($id) {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio('Documentoporgrado', 'documentoporgradoid', $id);            
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
     * @Rest\Put("/api/Documentoporgrado/{id}" , name="ActualizarDocumentoporgrado")
     */
    public function UpdateDocumento($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());$dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $dporg =  $dbm->getByParametersRepositorios('Documentoporgrado', array('gradoid' => $data['gradoid'], 'documentoid' => $data['documentoid']));
            if ($dporg && $dporg[0]->getDocumentoporgradoid() != $id) {
            	return new View("El documento ya ha sido asignado al grado", Response::HTTP_PARTIAL_CONTENT);
            }

            $DPG = $dbm->getRepositorioById('Documentoporgrado', 'documentoporgradoid', $id);
            $DPG->setCopia($data['copia']);
            $DPG->setOriginal($data['original']);
            $DPG->setActivo($data['activo']);
            $DPG->setGradoid(empty($data['gradoid']) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']));
            $DPG->setDocumentoid($dbm->getRepositorioById('Documento', 'documentoid', $data['documentoid']));
            $dbm->saveRepositorio($DPG);
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
