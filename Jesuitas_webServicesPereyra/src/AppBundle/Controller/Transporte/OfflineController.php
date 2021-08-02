<?php

namespace AppBundle\Controller\Transporte;

use AppBundle\DB\DbmTransporte;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/**
 * Auto: Javier
 */
class OfflineController extends FOSRestController
{

    /**
     * Retorna los filtros para la busqueda de boletos
     * @Rest\Get("/api/Transporte/Descargar", name="indexOffline")
     */
    public function indexBoleto()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $info = $dbm->OfflineDescargar($filtros);

            return new View($info, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
