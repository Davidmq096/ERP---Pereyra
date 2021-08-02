<?php

namespace AppBundle\Controller\Cobranza;

use AppBundle\Controller\lib\PDFMerger\PDFMerger;
use AppBundle\DB\DbmCobranza;
use AppBundle\Dominio\Correo;
use AppBundle\Entity\CbRegistroenviocorreo;
use Dompdf\Dompdf;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier
 */
class PagoInscripcionController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cobranza/Pagoinscripcion", name="indexPagoinscripcion")
     */
    public function indexPagoinscripcion()
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);

            return new View(array(
                "ciclo" => $ciclo, "nivel" => $nivel, "grado" => $grado
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Cobranza/Pagoinscripcion/", name="BuscarPagoinscripcion")
     */
    public function getPagoinscripcion()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $filtros = json_decode($content, true);

            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarPagoinscripcion($filtros);

            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Cobranza/Pagoinscripciondetalle/", name="BuscarPagoinscripciondetalle")
     */
    public function getPagoinscripciondetalle()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $filtros = json_decode($content, true);

            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarPagoinscripciondetalle($filtros);

            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
