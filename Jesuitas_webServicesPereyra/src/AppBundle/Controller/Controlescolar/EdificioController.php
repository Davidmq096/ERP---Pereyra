<?php

namespace AppBundle\Controller\Controlescolar;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Edificio;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\View\View;

/**
 * Auto: David
 */
class EdificioController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Edificio", name="indexEdificio")
     */
    public function indexEdificio() {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $edificio = $dbm->getRepositorios('Edificio');
            return new View($edificio, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Edificio/{id}", name="EliminarEdificio")
     */
    public function deleteEdificio($id) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $edificio = $dbm->getRepositorioById('Edificio', 'edificioid', $id);
            $dbm->removeRepositorio($edificio);
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
     * @Rest\Post("/api/Edificio" , name="GuardarEdificio")
     */
    public function SaveEdificio() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($dbm->getRepositorioById('Edificio', 'nombre', $data['nombre'])) {
                return new View("Ya existe un edificio con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $edificio = new Edificio();
            $edificio->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $edificio->setActivo(empty($data['activo']) ? null : $data['activo'] == "true" ? true : false);
            $dbm->saveRepositorio($edificio);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Edificio/{id}" , name="ActualizarEdificio")
     */
    public function updateEdificio($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getRepositorioById('Edificio', 'nombre', $data['nombre']);
            if ($validar && $validar->getEdificioid() != $id) {
                return new View("Ya existe un edificio con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $edificio = $dbm->getRepositorioById('Edificio', 'edificioid', $id);
            $edificio->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $edificio->setActivo(empty($data['activo']) ? null : $data['activo'] == "true" ? true : false);
            $dbm->saveRepositorio($edificio);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
