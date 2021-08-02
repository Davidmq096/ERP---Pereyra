<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeComponenteCurricular;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/**
 * Auto: Mariano
 */
class ComponenteCurricularController extends FOSRestController {    
    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/ComponenteCurricular/{id}", name="EliminarComponenteCurricular")
     */
    public function deleteComponenteCurricular($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $componente = $dbm->getRepositorioById('CeComponentecurricular', 'componentecurricularid', $id);
            $dbm->removeRepositorio($componente);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }
  
    /**
     * Retorna arreglo de componentes curriculares
     * @Rest\Get("/api/Controlescolar/ComponenteCurricular/Filtrar", name="BuscarComponenteCurricular")
     */
    public function getComponenteCurricular() {
    	try {
    		$datos = $_REQUEST;
    		$filtros = array_filter($datos, function($datos) {
                return ($datos !== null && $datos !== false && $datos !== ''); 
            });
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
    		$entidad = $dbm->BuscarComponentesCurriculares($filtros);
    		if (!$entidad) {
    			return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
    		}
    		return new View($entidad, Response::HTTP_OK);
    	} catch (Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }

    /**
     * @Rest\Post("/api/Controlescolar/ComponenteCurricular" , name="GuardarComponenteCurricular")
     */
    public function SaveComponenteCurricular() {
        try {
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true); 
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $componente=$dbm->getRepositorioById("CeComponentecurricular","componentecurricularid",$decoded["componentecurricularid"]);
            if (!$componente){
                $componente = $hydrator->hydrate(new CeComponenteCurricular(), $decoded);
            }else{
                $componente = $hydrator->hydrate($componente, $decoded);
            }
            $componente->setPonderacionid($dbm->getRepositorioById("CePonderacion","ponderacionid",$decoded["ponderacionid"]));
            $dbm->saveRepositorio($componente);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/ComponenteCurricular/", name="indexComponenteCurricular")
     */
    public function indexComponenteCurricular() {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $componente = $dbm->getRepositoriosById('CeComponentecurricular', 'activo', 1);
            $tipo = $dbm->getRepositoriosById('CeTipoCalificacion', 'activo', 1);
            $ponderacion = $dbm->getRepositoriosById('CePonderacion', 'activo', 1);
            return new View(array("componentecurricular" => $componente,"tipocalificacion"=>$tipo,"ponderacion"=>$ponderacion), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
}
