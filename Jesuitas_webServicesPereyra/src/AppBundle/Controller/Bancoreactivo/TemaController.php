<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBancoreactivo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\BrTema;

/**
 * Auto: javier
 */
class TemaController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Bancoreactivos/Tema", name="indexTema")
     */
    public function indexTema() {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $area = $dbm->getRepositoriosById('CeAreaacademica', 'activo', 1, 'nombre');
            $materia = $dbm->getRepositoriosById('Materia', 'activo', 1, 'nombre');
            return new View(array("nivel" => $nivel, "area" => $area, "materia" => $materia), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo de temas en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Tema/", name="BuscarTema")
     */
    public function getTema() {
    	try {
    		$datos = $_REQUEST;
    		$filtros = array_filter($datos);
    		$dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
    		$entidad = $dbm->BuscarTemas($filtros);
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
     * @Rest\Delete("/api/Bancoreactivos/Tema/{id}", name="EliminarTema")
     */
    public function deleteTema($id) {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $tema = $dbm->getRepositorioById('BrTema', 'temaid', $id);
            $dbm->removeRepositorio($tema);
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
     * @Rest\Post("/api/Bancoreactivos/Tema" , name="GuardarTema")
     */
    public function SaveTema() {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($dbm->getByParametersRepositorios('BrTema', array('nombre' => $data['tema'], 'materiaid' => $data['materiaid']))) {
                return new View("Ya existe un tema con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $tema = $hydrator->hydrate(new BrTema(), $data);
            $dbm->saveRepositorio($tema);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Bancoreactivos/Tema/{id}" , name="ActualizarTema")
     */
    public function updateTema($id) {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getByParametersRepositorios('BrTema', array('nombre' => $data['tema'], 'materiaid' => $data['materiaid']));
            if ($validar && $validar[0]->getTemaid() != $id) {
                return new View("Ya existe un tema con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $tema = $hydrator->hydrate($dbm->getRepositorioById('BrTema', 'temaid', $id), $data);
            $dbm->saveRepositorio($tema);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

}
