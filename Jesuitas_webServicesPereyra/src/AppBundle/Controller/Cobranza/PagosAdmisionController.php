<?php

namespace AppBundle\Controller\Cobranza;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmCobranza;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmControlescolar;

/**
 * Auto: David
 */
class PagosAdmisionController extends FOSRestController
{
        /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cobranza/PagosAdmision", name="indexPagosAdmision")
     */
    public function indexPagosAdmision()
    {
        try {

            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('CjPagoestatus', 'activo', 1);
            

            return new View(array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "semestre" => $semestre,
                "grado" => $grado,
                "estatus" => $estatus
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cobranza/PagosAdmision/Filtrar", name="BuscarPagosAdmision")
     */
    public function BuscarPagosAdmision()
    {
        try {

            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $pagos = $dbm->BuscarPagosAdmision($filtros);
            if(!$pagos) {
                return new View("No se encontraron registros", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($pagos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}