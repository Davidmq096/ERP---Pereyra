<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBancoreactivo;
use AppBundle\Entity\BrSubtema;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class SubtemaController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Bancoreactivos/Subtema", name="indexSubtema")
     */
    public function indexSubtema()
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $area = $dbm->getRepositoriosById('CeAreaacademica', 'activo', 1, 'nombre');
            $tema = $dbm->getRepositoriosById('BrTema', 'activo', 1, 'nombre');
            $materia = $dbm->getRepositoriosById('Materia', 'activo', 1, 'nombre');
            return new View(array("nivel" => $nivel, "area" => $area, "tema" => $tema, "materia" => $materia), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de subtemas en base a los parametros enviados
     * @Rest\Get("/api/Bancoreactivos/Subtema/", name="BuscarSubtema")
     */
    public function getTema()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarSubtemas($filtros);
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
     * @Rest\Delete("/api/Bancoreactivos/Subtema/{id}", name="EliminarSubtema")
     */
    public function deleteTema($id)
    {
        try {
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $subtema = $dbm->getRepositorioById('BrSubtema', 'subtemaid', $id);
            $dbm->removeRepositorio($subtema);
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
     * @Rest\Post("/api/Bancoreactivos/Subtema" , name="GuardarSubtema")
     */
    public function SaveTema()
    {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($dbm->getRepositorioById('BrSubtema', 'nombre', $data['subtema'])) {
                return new View("Ya existe un sub tema con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $subtema = $hydrator->hydrate(new BrSubtema(), $data);
            $dbm->saveRepositorio($subtema);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Bancoreactivos/Subtema/{id}" , name="ActualizarSubtema")
     */
    public function updateSubtema($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getRepositorioById('BrSubtema', 'nombre', $data['subtema']);
            if ($validar && $validar->getSubtemaid() != $id) {
                return new View("Ya existe un sub tema con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $subtema = $hydrator->hydrate($dbm->getRepositorioById('BrSubtema', 'subtemaid', $id), $data);
            $dbm->saveRepositorio($subtema);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

}
