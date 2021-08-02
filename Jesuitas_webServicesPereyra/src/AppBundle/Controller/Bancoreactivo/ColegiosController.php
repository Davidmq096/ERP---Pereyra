<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBancoreactivo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\BrColegio;
use FOS\RestBundle\View\View;

class ColegiosController extends FOSRestController {

    /**
     * Retorna arreglo de paises en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Colegio/", name="BuscarColegio")
     */
    public function indexPColegio() {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarColegios($filtros);
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
     * @Rest\Delete("/api/Bancoreactivos/Colegio/{id}", name="EliminarColegio")
     */
    public function deleteColegio($id) {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $colegio = $dbm->getRepositorioById('BrColegio', 'colegioid', $id);
            $dbm->removeRepositorio($colegio);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Rest\Post("/api/Bancoreactivos/Colegio" , name="GuardarColegio")
     */
    public function SaveColegio() {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            if ($dbm->getRepositorioById('BrColegio', 'nombre', $data['nombre'])) {
                return new View("Ya existe un colegio con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            if ($dbm->getRepositorioById('BrColegio', 'clave', $data['clave'])) {
            	return new View("Ya existe un colegio con la misma clave", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Colegio = $hydrator->hydrate(new BrColegio(), $data);
            $dbm->saveRepositorio($Colegio);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Bancoreactivos/Colegio/{id}" , name="ActualizarColegio")
     */
    public function updateColegio($id) {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $validar = $dbm->getRepositorioById('BrColegio', 'nombre', $data['nombre']);
            if ($validar && $validar->getColegioid() != $id) {
                return new View("Ya existe un colegio con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            $validar = $dbm->getRepositorioById('BrColegio', 'clave', $data['clave']);
            if ($validar && $validar->getColegioid() != $id) {
            	return new View("Ya existe un colegio con la misma clave", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Colegio = $hydrator->hydrate($dbm->getRepositorioById('BrColegio', 'colegioid', $id), $data);
            $dbm->saveRepositorio($Colegio);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
