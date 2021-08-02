<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Entity\AdFactoresapoyo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\DB\DbmAdmisiones;

/**
 * Auto: javier
 */
class FactoresApoyoController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Factoresapoyo", name="indexFactoresapoyo")
     */
    public function indexFactoresapoyo()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $categoriaapoyo = $dbm->BuscarCategoriaapoyo(array("activo"=>"1"));
            return new View(array("nivel" => $nivel, "grado" => $grado, "categoriaapoyo" => $categoriaapoyo), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Factoresapoyo en base a los parametros enviados
     * @Rest\Get("/api/Factoresapoyo/", name="BuscarFactoresapoyo")
     */
    public function getFactoresapoyo()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarFactoresapoyo($filtros);
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
     * @Rest\Delete("/api/Factoresapoyo/{id}", name="EliminarFactoresapoyo")
     */
    public function deleteFactoresapoyo($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $factoresapoyo = $dbm->getRepositorioById('AdFactoresapoyo', 'factoresapoyoid', $id);
            $dbm->removeRepositorio($factoresapoyo);
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
     * @Rest\Post("/api/Factoresapoyo" , name="GuardarFactoresapoyo")
     */
    public function SaveFactoresapoyo()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Factoresapoyo = $hydrator->hydrate(new AdFactoresapoyo(), $data);
            $dbm->saveRepositorio($Factoresapoyo);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Factoresapoyo/{id}" , name="ActualizarFactoresapoyo")
     */
    public function updateFactoresapoyo($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Factoresapoyo = $hydrator->hydrate($dbm->getRepositorioById('AdFactoresapoyo', 'factoresapoyoid', $id), $data);
            $dbm->saveRepositorio($Factoresapoyo);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

}
