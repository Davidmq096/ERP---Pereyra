<?php

namespace AppBundle\Controller\Reportes;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmReportes;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Rest\Api;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;

/**
 * @author David
 */

class CalificacionesCualitativasController extends FOSRestController
{
    /**
     * 
     * @Rest\Get("/api/Reportes/Calificacionescualitativas/", name="getFiltrosCalCualitativas")
     */
    public function FiltrosCalificacionesCualitativas()
    {
        try {
            $dbm = new DbmReportes($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById("Ciclo", "activo", 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $planestudio = $dbm->getRepositorios('CePlanestudios');
            $materia = array();
            foreach ($planestudio as $p) {
                $materia = array_merge(
                    $materia,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid()]
                    )
                );
            }

            $periodoeval = $dbm->getRepositoriosModelo("CePeriodoevaluacion", ["d.periodoevaluacionid, d.descripcion, IDENTITY(c.cicloid) as cicloid, GROUPCONCAT(DISTINCT IDENTITY(g.gradoid)) as gradoid"],
            [], false, false, [
                ["entidad" => "CeConjuntoperiodoevaluacion", "alias" => "c", "left" => false, "on" => "c.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
                ["entidad" => "CeGradoporconjuntoperiodoescolar", "alias" => "g", "left" => false, "on" => "g.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
            ], 'd.periodoevaluacionid');



            $array = array("ciclo" => $ciclo, 
            "nivel" => $nivel, 
            "grado" => $grado, 
            "grupo" => $grupo, 
            "semestre" => $semestre,
            "periodoevaluacion" => $periodoeval,
            "planestudios" => $planestudio,
            "materias" => $materia
            );
            return new View($array, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

        /**
     * 
     * @Rest\Get("/api/Reportes/Calificacionescualitativas/BuscarCalCualitativas", name="BuscarCalCualitativas")
     */
    public function BuscarCalCualitativas()
    {
        $datos=$_REQUEST;
        $filtros=array_filter($datos);
        $periodo = '';
        $arraydatos = [];
        try {
            $dbm = new DbmReportes($this->get("db_manager")->getEntityManager());
            $alumnosperiodo = $dbm->buscarMetasInscripciosnGrado($filtros);

            if(!$alumnosperiodo) {
                return new View("No se encontró ningun registro", Response::HTTP_PARTIAL_CONTENT);
            }

            foreach ($alumnosperiodo as $key => $a) {
            $periodo = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $a['periodoevaluacionid']);
            $fechai = $periodo->getFechainicio()->format("Y-m-d");
            $fechaf = $periodo->getFechafin()->format("Y-m-d");

            $totalf = $dbm->getRepositoriosModelo("CeAsistenciapordia", 
            ["d.asistenciapordiaid "], 
            [["tipoasistenciaid = 2 and d.estatusinasistenciaid = 1 and ac.alumnoporcicloid = " . $a['alumnoporcicloid'] . " AND d.fecha between '" . $fechai ."' AND '" . $fechaf . "'"]], false, true, [
                ["entidad" => "CeAlumnoporciclo", "alias" => "ac", "left" => false, "on" => "ac.alumnoporcicloid = d.alumnoporcicloid"],

            ]);

            $totalfdiaria = $dbm->getRepositoriosModelo("CeCapturaalumnoporperiodo", 
            ["SUM(d.asistencia) as totalasis"], 
            [["capturaalumnoporperiodoid is not null and d.alumnoporcicloid = " . $a['alumnoporcicloid']. " and d.periodoevaluacionid = " . $a['periodoevaluacionid']]], false, true, [

            ])[0];

            $faltass = intval($totalfdiaria['totalasis']) + count($totalf);
            $alumnosperiodo[$key]['faltas'] = $faltass;

            }

            return new View($alumnosperiodo, Response::HTTP_OK);
        }  catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}