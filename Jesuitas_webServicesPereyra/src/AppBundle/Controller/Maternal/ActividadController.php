<?php

namespace AppBundle\Controller\Maternal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmMaternal;
use AppBundle\Entity\MaActividad;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class ActividadController extends FOSRestController
{


    /**
     * Retorna arreglo de Actividad en base a los parametros enviados
     * @Rest\Get("/api/Maternal/Actividad/", name="BuscarActividad")
     */
    public function getActividad()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarActividad($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Maternal/Actividad" , name="GuardarActividad")
     */
    public function SaveActividad()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $actividad = $dbm->getRepositorioById('MaActividad', 'descripcion', $data['descripcion']);
            if ($actividad) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Actividad = $hydrator->hydrate(new MaActividad(), $data);
            $dbm->saveRepositorio($Actividad);

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Maternal/Actividad/{id}" , name="ActualizarActividad")
     */
    public function updateActividad($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $actividad = $dbm->getRepositorioById('MaActividad', 'descripcion', $data['descripcion']);
            if ($actividad && $actividad->getActividadid() != $id) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Actividad = $hydrator->hydrate($dbm->getRepositorioById('MaActividad', 'actividadid', $id), $data);
            $dbm->saveRepositorio($Actividad);
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Maternal/Actividad/{id}", name="EliminarActividad")
     */
    public function deleteActividad($id)
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $actividad = $dbm->getRepositorioById('MaActividad', 'actividadid', $id);
            $dbm->removeRepositorio($actividad);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
