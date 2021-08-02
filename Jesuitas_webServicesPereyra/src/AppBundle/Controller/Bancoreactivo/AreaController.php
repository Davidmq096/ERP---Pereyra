<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBancoreactivo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\BrArea;

/**
 * Auto: javier
 */
class AreaController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Bancoreactivos/Area", name="indexArea")
     */
    public function indexArea() {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            return new View(array("nivel" => $nivel), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo de ciudades en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Area/", name="BuscarArea")
     */
    public function getArea() {
    	try {
    		$datos = $_REQUEST;
    		$filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
    		$entidad = $dbm->BuscarAreas($filtros);
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
     * @Rest\Delete("/api/Bancoreactivos/Area/{id}", name="EliminarArea")
     */
    public function deleteArea($id) {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $area = $dbm->getRepositorioById('BrArea', 'areaid', $id);
            $dbm->removeRepositorio($area);
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
     * @Rest\Post("/api/Bancoreactivos/Area" , name="GuardarArea")
     */
    public function SaveArea() {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->getByParametersRepositorios('BrArea', array('nombre' => $data['area'], 'nivelid' => $data['nivelid']));
            if ($dbm->getByParametersRepositorios('BrArea', array('nombre' => $data['area'], 'nivelid' => $data['nivelid']))) {
                return new View("Ya existe un área con el mismo nombre en el nivel seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $area = $hydrator->hydrate(new BrArea(), $data);
            $dbm->saveRepositorio($area);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Bancoreactivos/Area/{id}" , name="ActualizarArea")
     */
    public function updateCiudad($id) {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getByParametersRepositorios('BrArea', array('nombre' => $data['area'], 'nivelid' => $data['nivelid']));
            if ($validar && $validar[0]->getAreaid() != $id) {
                return new View("Ya existe un área con el mismo nombre en el nivel seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $area = $hydrator->hydrate($dbm->getRepositorioById('BrArea', 'areaid', $id), $data);
            $dbm->saveRepositorio($area);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

}
