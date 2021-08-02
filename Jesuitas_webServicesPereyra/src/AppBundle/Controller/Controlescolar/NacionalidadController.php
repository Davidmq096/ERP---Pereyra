<?php

namespace AppBundle\Controller\Controlescolar;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Nacionalidad;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\View\View;

/**
 * Auto: David
 */
class NacionalidadController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Nacionalidad/{reload}", name="indexNacionalidad")
     */
    public function indexNacionalidad($reload) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $pais = $reload == "true" ? null : $dbm->getRepositoriosById('Pais', 'activo', 1);
            $nacionalidad = $dbm->getRepositorios('Nacionalidad');
            return new View(array("Pais" => $pais, "Nacionalidad" => $nacionalidad), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Nacionalidad/{id}", name="EliminarNacionalidad")
     */
    public function deleteNacionalidad($id) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $nacionalidad = $dbm->getRepositorioById('Nacionalidad', 'nacionalidadid', $id);

            $dbm->removeRepositorio($nacionalidad);
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
     * @Rest\Post("/api/Nacionalidad" , name="GuardarNacionalidad")
     */
    public function SaveNacionalidad() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($dbm->getRepositorioById('Nacionalidad', 'nombre', $data['nombre'])) {
                return new View("Ya existe una nacionalidad con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            if ($dbm->getRepositorioById('Nacionalidad', 'paisid', $data['paisid'])) {
            	return new View("Ya existe una nacionalidad asignada al país seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }

            $nacionalidad = new Nacionalidad();
            $nacionalidad->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $nacionalidad->setActivo($data['activo'] == "true" ? true : false);
            $nacionalidad->setPaisid(empty($data['paisid']) ? null : $dbm->getRepositorioById('Pais', 'paisid', $data['paisid']));

            $dbm->saveRepositorio($nacionalidad);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Nacionalidad/{id}" , name="ActualizarNacionalidad")
     */
    public function updateNacionalidad($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getRepositorioById('Nacionalidad', 'nombre', $data['nombre']);
            if ($validar && $validar->getNacionalidadid() != $id) {
                return new View("Ya existe una nacionalidad con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            $validar = $dbm->getRepositorioById('Nacionalidad', 'paisid', $data['paisid']);
            if ($validar && $validar->getNacionalidadid() != $id) {
            	return new View("Ya existe una nacionalidad asignada al país seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $nacionalidad = $dbm->getRepositorioById('Nacionalidad', 'nacionalidadid', $id);
            $nacionalidad->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $nacionalidad->setActivo($data['activo'] == "true" ? true : false);
            $nacionalidad->setPaisid(empty($data['paisid']) ?
                            null : $dbm->getRepositorioById('Pais', 'paisid', $data['paisid']));
            $dbm->saveRepositorio($nacionalidad);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
