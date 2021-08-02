<?php

namespace AppBundle\Controller\Admisiones;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Documento;
use AppBundle\DB\DbmAdmisiones;

/**
 * Auto: Javier
 */
class DocumentoController extends FOSRestController {

    /**
     * Retorna arreglo que los datos de documento y nivel para cargar de innicio la pagina 
     * @Rest\Get("/api/Documento", name="InicioDocumento")
     */
    public function indexDocumento() {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $tipodocumento = $dbm->getRepositoriosById('Tipodocumento', 'activo', 1, 'nombre');
            $formato = $dbm->getByParametersRepositorios('Formato', array('activo' => 1, 'tipoformatoid' => 6), 'nombre');
       
            return new View(array("tipodocumento" => $tipodocumento, "formato" => $formato), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo que los datos de documento 
     * @Rest\Get("/api/Documento/", name="BuscarDocumento")
     */
    public function getDocumento() {
    	try {
    		$datos = $_REQUEST;
            $filtros = array_filter($datos);
    		$dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
    		$entidad = $dbm->BuscarDocumento($filtros);
    		if (!$entidad) {
    			return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
    		}
    		return new View($entidad, Response::HTTP_OK);
    	} catch (\Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }

    /**
     * Guarda los Documentos 
     * @Rest\Post("/api/Documento" , name="GuardarDocumento")
     */
    public function saveDocumento() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $doc =  $dbm->getRepositorioById('Documento', 'nombre', $data['nombre']);
            if ($doc) {
                return new View("Ya existe un documento con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
  
            $Documento = new Documento();
            $Documento->setNombre($data['nombre']);
            $Documento->setTipodocumentoid($dbm->getRepositorioById('Tipodocumento', 'tipodocumentoid', $data['tipodocumentoid']));
            $Documento->setFormatoid($dbm->getRepositorioById('Formato', 'formatoid', $data['formatoid']));
            $Documento->setActivo($data['activo']);
            $dbm->saveRepositorio($Documento);
            
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Documento/{id}", name="EliminarDocumento")
     */
    public function deleteDocumento($id) {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio('Documento', 'documentoid', $id);            
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
     * @Rest\Put("/api/Documento/{id}" , name="ActualizarDocumento")
     */
    public function UpdateDocumento($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $doc =  $dbm->getRepositorioById('Documento', 'nombre', $data['nombre']);
            if ($doc && $doc->getDocumentoid() != $id) {
            	return new View("Ya existe un documento con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $Documento = $dbm->getRepositorioById('Documento', 'documentoid', $id);
            $Documento->setNombre($data['nombre']);
            $Documento->setTipodocumentoid($dbm->getRepositorioById('Tipodocumento', 'tipodocumentoid', $data['tipodocumentoid']));
            $Documento->setFormatoid($dbm->getRepositorioById('Formato', 'formatoid', $data['formatoid']));
            $Documento->setActivo($data['activo']);
            $dbm->saveRepositorio($Documento);
                        
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
