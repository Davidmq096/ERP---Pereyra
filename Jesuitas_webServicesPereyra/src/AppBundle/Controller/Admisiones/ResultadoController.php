<?php

namespace AppBundle\Controller\Admisiones;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmAdmisiones;
use FOS\RestBundle\View\View;

/**
 * Auto: Javier Manrique
 */
class ResultadoController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Resultado", name="indexResultado")
     */
    public function indexResultado(Request $request) {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('Estatussolicitud', 'activo', 1, 'estatus');

            return new View(
                    array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                 "estatus" =>$estatus
                    ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna resultados en base a los parametros enviados
     * @Rest\Get("/api/Resultado/", name="buscarResultado")
     */
    public function buscarResultado(Request $request) {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);

            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarResultado($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
