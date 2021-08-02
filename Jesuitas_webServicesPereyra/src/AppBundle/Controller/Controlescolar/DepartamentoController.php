<?php

namespace AppBundle\Controller\Controlescolar;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Departamento;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\View\View;

/**
 * Auto: David
 */
class DepartamentoController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Departamento", name="indexDepartamento")
     */
    public function indexDepartamento() {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $departamento = $dbm->getRepositorios('Departamento');
            return new View($departamento, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Departamento/{id}", name="EliminarDepartamento")
     */
    public function deleteDepartamento($id) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $departamento = $dbm->getRepositorioById('Departamento', 'departamentoid', $id);
            $dbm->removeRepositorio($departamento);
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
     * @Rest\Post("/api/Departamento" , name="GuardarDepartamento")
     */
    public function SaveDepartamento() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($dbm->getRepositorioById('Departamento', 'nombre', $data['nombre'])) {
                return new View("Ya existe un departamento con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $departamento = new Departamento();
            $departamento->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $departamento->setActivo($data['activo'] == "true" ? true : false);

            $dbm->saveRepositorio($departamento);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Departamento/{id}" , name="ActualizarDepartamento")
     */
    public function updateDepartamento($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getRepositorioById('Departamento', 'nombre', $data['nombre']);
            if ($validar && $validar->getDepartamentoid() != $id) {
                return new View("Ya existe un departamento con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $departamento = $dbm->getRepositorioById('Departamento', 'departamentoid', $id);
            $departamento->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $departamento->setActivo($data['activo'] == "true" ? true : false);
            $dbm->saveRepositorio($departamento);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
