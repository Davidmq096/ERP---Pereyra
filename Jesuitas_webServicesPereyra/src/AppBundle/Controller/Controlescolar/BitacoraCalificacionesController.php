<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeBoletas;
use AppBundle\Entity\CeBoletaporciclo;
use AppBundle\Entity\CeBoletaporgrado;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;

/**
 * Auto: David
 */
class BitacoraCalificacionesController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/Bitacoracalificaciones", name="indexBitacora")
     */
    public function indexBitacora()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $grupos = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $planestudios = $dbm->getRepositoriosById('CePlanestudios', 'vigente', 1);
            $materias = array();
            foreach ($planestudios as $p) {
                $materias = array_merge(
                    $materias,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid()]
                    )
                );
            }

            return new View(array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                "semestre" => $semestre,
                "planestudios" => $planestudios,
                "grupos" => $grupos,
                "materias" => $materias

        ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna materias mediante un materiaporplanestudioid
     * @Rest\Get("/api/Controlescolar/Bitacoracalificaciones/Periodo", name="loadPeriodobitacora")
     */
    public function loadPeriodobitacora()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $periodos = $dbm->BuscarPeriodoPorCicloGrado($filtros['cicloid'], $filtros['gradoid']);
            return new View($periodos, Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna materias mediante un materiaporplanestudioid
     * @Rest\Get("/api/Controlescolar/Bitacoracalificaciones/Aspectos/", name="loadAspectoTarea")
     */
    public function loadAspectoTarea()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $aspectos = $dbm->BuscarAspectos($filtros);
            return new View($aspectos, Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


}