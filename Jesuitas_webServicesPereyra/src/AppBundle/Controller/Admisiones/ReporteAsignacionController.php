<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\DB\DbmAdmisiones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class ReporteAsignacionController extends FOSRestController
{

    /**
     * Reotorna valores iniciales para reportes de asignacion
     * @Rest\Get("/api/admision/reporteadmision", name="reporteadmision")
     */
    public function getReporteAsignacionAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $filters = array_filter($datos);
            $resultados = $dbm->getReporteAsignacionByFilter($filters);
            if (!$resultados) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($resultados, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
