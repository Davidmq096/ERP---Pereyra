<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Pais;
use FOS\RestBundle\View\View;

/**
 * Auto: David
 */
class PaisesController extends FOSRestController {

    /**
     * Retorna arreglo de paises en base a los parametros enviados
     * @Rest\Get("/api/Pais/", name="BuscarPais")
     */
    public function indexPais() {
        try {
        	$datos = $_REQUEST;
        	$filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarPaises($filtros);
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
     * @Rest\Delete("/api/Pais/{id}", name="EliminarPais")
     */
    public function deletePais($id) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            
            $pais = $dbm->getRepositorioById('Pais', 'paisid', $id);
            $dbm->removeRepositorio($pais);
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
     * @Rest\Post("/api/Pais" , name="GuardarPais")
     */
    public function SavePais() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            if ($dbm->getRepositorioById('Pais', 'nombre', $data['nombre'])) {
                return new View("Ya existe un país con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Pais = $hydrator->hydrate(new Pais(), $data);
            $dbm->saveRepositorio($Pais);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Pais/{id}" , name="ActualizarPais")
     */
    public function updatePais($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $validar = $dbm->getRepositorioById('Pais', 'nombre', $data['nombre']);
            if ($validar && $validar->getPaisid() != $id) {
                return new View("Ya existe un país con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Pais = $hydrator->hydrate($dbm->getRepositorioById('Pais', 'paisid', $id), $data);
            $dbm->saveRepositorio($Pais);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
