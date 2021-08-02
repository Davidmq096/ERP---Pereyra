<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeTipobaja;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class TipoBajaController extends FOSRestController
{

    /**
     * Retorna catalogo tipos de baja
     * @Rest\Get("/api/TipoBaja/tiposdebaja", name="tbajas")
     */
    public function tbajas()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $bajas = $dbm->getRepositoriosById('CeTipobaja', 'activo', 1);
            return new View(array('tiposbaja' => $bajas), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna filtros tipo de baja
     * @Rest\Post("/api/TipoBaja/Filtrar", name="TipoBajafiltro")
     */
    public function TipoBajafiltro()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm = new DbmControlescolar($dbm->getEntityManager());
            $entidad = $dbm->Buscartiposbaja($decoded);
            if (!$entidad) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Delete("/api/TipoBaja/eliminar/{id}" , name="deletetipobaja")
     */
    public function deletetipobaja($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $filtros = array(
                "tipobajaid" => $id,
            );
            $dbm->eliminartipodebaja($filtros);

            return new View("Se ha eliminado el registro correctamente.", Response::HTTP_OK);
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
     * pestaña referencias
     * @Rest\Post("/api/TipoBaja/Guardar", name="guardartipobaja")
     */
    public function guardartipobaja()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if ($dbm->getRepositorioById('CeTipobaja', 'nombre', $data['nombre'])) {
                return new View("Ya existe un tipo de baja con el mismo nombre.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $tipobaja = $hydrator->hydrate(new CeTipobaja(), $data);
            $dbm->saveRepositorio($tipobaja);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

/**
 * @Rest\Post("/api/TipoBaja/Actualizar/{tipobajaid}" , name="Editartipobaja")
 */
    public function Editartipobaja($tipobajaid)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $tipobaja = $hydrator->hydrate($dbm->getRepositorioById('CeTipobaja', 'tipobajaid', $tipobajaid), $data);
            $dbm->saveRepositorio($tipobaja);
            $dbm->getConnection()->commit();

            return new View("Se ha editado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
