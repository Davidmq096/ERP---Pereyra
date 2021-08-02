<?php

namespace AppBundle\Controller\Admisiones;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Lugar;
use AppBundle\Entity\Lugarportipoevaluacion;
use FOS\RestBundle\View\View;

use AppBundle\DB\DbmAdmisiones;

/**
 * @author Alejandro Torres
 */
class LugaresController extends FOSRestController {

    /**
     * Reotorna arreglo iniciales     
     * @Rest\Get("/api/Lugar", name="indexLugar")
     */
    public function indexAction() {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $edificio = $dbm->getRepositoriosById('Edificio', 'activo', 1);
            $tipoevaluacion = $dbm->getRepositoriosById('Tipoevaluacion', 'activo', 1);
            return new View(array("edificio" => $edificio, "tipoevaluacion" => $tipoevaluacion), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/Lugar/", name="BuscarLugar")
     */
    public function getLugar() {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);

            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarLugar($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Elimina un registro
     * @Rest\Delete("/api/Lugar/{id}", name="EliminarLugar")
     */
    public function deleteCupoAdmision($id) {
    	try {
    		$dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
    		$dbm->getConnection()->beginTransaction();
    		
    		$dbm->removeManyRepositorio('Lugarportipoevaluacion', 'lugarid', $id);
    		
    		$lugar = $dbm->getRepositorioById('Lugar', 'lugarid', $id);
    		$dbm->removeRepositorio($lugar);
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
     * Funcion para gurdar un nuevo regitro
     * @Rest\Post("/api/Lugar", name="GuardarLugar")
     */
    public function saveLugar() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            
            if ($dbm->getRepositorioById('Lugar', 'nombre', $data['lugar'])) {
            	return new View("Ya existe un lugar con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $Lugar = new Lugar();
            $Lugar->setEdificioid($dbm->getRepositorioById('Edificio', 'edificioid', $data['edificioid']));
            $Lugar->setNombre($data['lugar']);
            $Lugar->setCupo($data['capacidad']);
            $Lugar->setProyector($data['proyector'] == 'true' ? true : false);
            $Lugar->setInternet($data['internet'] == 'true' ? true : false);
            $Lugar->setEquipocomputo($data['equipocomputo'] == 'true' ? true : false);
            $Lugar->setEquipocantidad($data['equipocantidad'] == "" ? null : $data['equipocantidad']);
            $Lugar->setActivo($data['activo'] == 'true' ? true : false);
            $dbm->saveRepositorio($Lugar);

            foreach ($data['tipoevaluacionid'] as $te) {
                $lugarportipoevaluacion = new Lugarportipoevaluacion();
                $lugarportipoevaluacion->setLugarid($Lugar);
                $lugarportipoevaluacion->setTipoevaluacionid($dbm->getRepositorioById('Tipoevaluacion', 'tipoevaluacionid', $te));
                $dbm->saveRepositorio($lugarportipoevaluacion);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para editar Lugar
     * @Rest\Put("/api/Lugar/{id}", name="ActualizarLugar")
     */
    public function updateLugar($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            
            $validar = $dbm->getRepositorioById('Lugar', 'nombre', $data['lugar']);
            if ($validar && $validar->getLugarid() != $id) {
            	return new View("Ya existe un lugar con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $Lugar = $dbm->getRepositorioById('Lugar', 'lugarid', $id);
            $Lugar->setEdificioid($dbm->getRepositorioById('Edificio', 'edificioid', $data['edificioid']));
            $Lugar->setNombre($data['lugar']);
            $Lugar->setCupo($data['capacidad']);
            $Lugar->setProyector($data['proyector'] == 'true' ? true : false);
            $Lugar->setInternet($data['internet'] == 'true' ? true : false);
            $Lugar->setEquipocomputo($data['equipocomputo'] == 'true' ? true : false);
            $Lugar->setEquipocantidad($data['equipocantidad'] == '' ? null : $data['equipocantidad']);
            $Lugar->setActivo($data['activo'] == 'true' ? true : false);
            $dbm->saveRepositorio($Lugar);

            $dbm->removeManyRepositorio('Lugarportipoevaluacion', 'lugarid', $id);
            foreach ($data['tipoevaluacionid']as $te) {
                $lugarportipoevaluacion = new Lugarportipoevaluacion();
                $lugarportipoevaluacion->setLugarid($Lugar);
                $lugarportipoevaluacion->setTipoevaluacionid($dbm->getRepositorioById('Tipoevaluacion', 'tipoevaluacionid', $te));
                $dbm->saveRepositorio($lugarportipoevaluacion);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
