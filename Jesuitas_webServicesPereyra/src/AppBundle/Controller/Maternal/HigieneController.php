<?php

namespace AppBundle\Controller\Maternal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmMaternal;
use AppBundle\Entity\MaHigiene;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class HigieneController extends FOSRestController
{

    /**
     * Retorna arreglo de Higiene en base a los parametros enviados
     * @Rest\Get("/api/Maternal/Higiene/", name="BuscarHigiene")
     */
    public function getHigiene()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarHigiene($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Maternal/Higiene" , name="GuardarHigiene")
     */
    public function SaveHigiene()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $higiene = $dbm->getRepositorioById('MaHigiene', 'descripcion', $data['descripcion']);
            if ($higiene) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Higiene = $hydrator->hydrate(new MaHigiene(), $data);
            $dbm->saveRepositorio($Higiene);

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Maternal/Higiene/{id}" , name="ActualizarHigiene")
     */
    public function updateHigiene($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $higiene = $dbm->getRepositorioById('MaHigiene', 'descripcion', $data['descripcion']);
            if ($higiene && $higiene->getHigieneid() != $id) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Higiene = $hydrator->hydrate($dbm->getRepositorioById('MaHigiene', 'higieneid', $id), $data);
            $dbm->saveRepositorio($Higiene);
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Maternal/Higiene/{id}", name="EliminarHigiene")
     */
    public function deleteHigiene($id)
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $higiene = $dbm->getRepositorioById('MaHigiene', 'higieneid', $id);
            $dbm->removeRepositorio($higiene);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
