<?php

namespace AppBundle\Controller\Maternal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmMaternal;
use AppBundle\Entity\MaPlatillo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class PlatilloController extends FOSRestController
{


    /**
     * Retorna arreglo de Platillo en base a los parametros enviados
     * @Rest\Get("/api/Maternal/Platillo/", name="BuscarPlatillo")
     */
    public function getPlatillo()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarPlatillo($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Maternal/Platillo" , name="GuardarPlatillo")
     */
    public function SavePlatillo()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            
            $platillo = $dbm->getRepositorioById('MaPlatillo', 'descripcion', $data['descripcion']);
            if ($platillo && $platillo->getPlatilloid() != $id) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }            

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Platillo = $hydrator->hydrate(new MaPlatillo(), $data);
            $dbm->saveRepositorio($Platillo);

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Maternal/Platillo/{id}" , name="ActualizarPlatillo")
     */
    public function updatePlatillo($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $platillo = $dbm->getRepositorioById('MaPlatillo', 'descripcion', $data['descripcion']);
            if ($platillo && $platillo->getPlatilloid() != $id) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Platillo = $hydrator->hydrate($dbm->getRepositorioById('MaPlatillo', 'platilloid', $id), $data);
            $dbm->saveRepositorio($Platillo);
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Maternal/Platillo/{id}", name="EliminarPlatillo")
     */
    public function deletePlatillo($id)
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $platillo = $dbm->getRepositorioById('MaPlatillo', 'platilloid', $id);
            $dbm->removeRepositorio($platillo);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
