<?php

namespace AppBundle\Controller\Comunicacion;

use AppBundle\DB\DbmComunicacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class TableroController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Comunicacion/Tablero", name="indexTablero")
     */
    public function indexTablero()
    {
        try {
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $tiponotificacion = $dbm->getRepositoriosById('CmTiponotificacion', 'activo', 1);

            return new View(array("tiponotificacion" => $tiponotificacion, "niveles" => $nivel), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo con los totales
     * @Rest\Post("/api/Comunicacion/Tablero", name="BuscarTablero")
     */
    public function getTablero()
    {
        try {
            $datos = trim(file_get_contents("php://input"));
            $data = json_decode($datos, true);
            $filtros = array_filter($data);
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->TotalesNotificaciones($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Actividad en base a los parametros enviados
     * @Rest\Post("/api/Comunicacion/Tablero/tiponotificacion/notificacion", name="BuscarDetalle")
     */
    public function getTableroDetalle()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->Detalle($filtros["tiponotificacion"], $filtros["notificacion"]);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
