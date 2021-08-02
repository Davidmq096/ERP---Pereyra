<?php

namespace AppBundle\Controller\Maternal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmMaternal;
use AppBundle\Entity\MaInventario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class InventarioController extends FOSRestController
{


    /**
     * Retorna arreglo de Inventario en base a los parametros enviados
     * @Rest\Get("/api/Maternal/Inventario/", name="BuscarInventario")
     */
    public function getInventario()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarInventario($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Maternal/Inventario" , name="GuardarInventario")
     */
    public function SaveInventario()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $inventario = $dbm->getRepositorioById('MaInventario', 'descripcion', $data['descripcion']);
            if ($inventario) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Inventario = $hydrator->hydrate(new MaInventario(), $data);
            $dbm->saveRepositorio($Inventario);

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Maternal/Inventario/{id}" , name="ActualizarInventario")
     */
    public function updateInventario($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $inventario = $dbm->getRepositorioById('MaInventario', 'descripcion', $data['descripcion']);
            if ($inventario && $inventario->getInventarioid() != $id) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Inventario = $hydrator->hydrate($dbm->getRepositorioById('MaInventario', 'inventarioid', $id), $data);
            $dbm->saveRepositorio($Inventario);
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Maternal/Inventario/{id}", name="EliminarInventario")
     */
    public function deleteInventario($id)
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $inventario = $dbm->getRepositorioById('MaInventario', 'inventarioid', $id);
            $dbm->removeRepositorio($inventario);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
