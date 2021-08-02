<?php

namespace AppBundle\Controller\Reportes;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\DB\DbmReportes;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Rest\Api;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;

/**
 * @author David
 */

class MetasInscripcionController extends FOSRestController
{
    /**
     * Obtiene los catalogos para buscar alumnos en la modal
     * @Rest\Get("/api/Reportes/MetasInscripcion", name="indexMetasinscripcion")
     */
    public function indexMetasinscripcion()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById("Ciclo", "activo", 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);

            $array = array("ciclo" => $ciclo, "nivel" => $nivel, "grado" => $grado, "semestre" => $semestre);
            return new View($array, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Reportes/MetasInscripcion/Consultar", name="GetMetas")
     */
    public function GetMetas()
    {
        try {
            $array = [];
            $arraygraficas = [];
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $filtros['alumnoestatusid'] = 1;
            $dbm = new DbmReportes($this->get("db_manager")->getEntityManager());
            if($filtros['nivelid'] || $filtros['gradoid']) {
                $respuesta = $dbm->buscarMetasInscripcionGrado($filtros);
            } else {
                $arrdata = [];
                $resp = $dbm->buscarMetasInscripcionNivel($filtros);
                foreach($resp as $key=>$re) {
                    $resp[$key]['totalinscrito'] = $re['nuevoingreso'] + $re['reinscripciones'];
                    $resp[$key]['alumnosrestantes'] = $re['meta'] - $resp[$key]['totalinscrito'];
                }
                $respuesta = $resp;
            }
            if(!$respuesta) {
                return new View("No se encontró ningun registro", Response::HTTP_OK);
            }

            foreach($respuesta as $key=>$r) {
                $arraygraficas[$key]['nivelgrado'] = $r['nivelgrado'];
                $arraygraficas[$key]['graficas'][0] = ["label" => "Alumnos restantes", "data" => $r['meta'] - (intval($r['reinscripciones'] + intval($r['nuevoingreso'])))];
                $arraygraficas[$key]['graficas'][1] = ["label" => "Nuevo ingreso", "data" => $r['nuevoingreso']];
                $arraygraficas[$key]['graficas'][2] = ["label" => "Reinscritos", "data" => $r['reinscripciones']];

            }

            $array = $respuesta;
            $arraylength = count($array);
            foreach($respuesta as $r) {
                $array[$arraylength]['nivelgrado'] = "TOTAL";
                $array[$arraylength]['meta'] += $r['meta'];
                $array[$arraylength]['alumnosactuales'] += $r['alumnosactuales'];
                $array[$arraylength]['lugaresfaltantes'] += $r['lugaresfaltantes'];
                $array[$arraylength]['inscritosexamen'] += $r['inscritosexamen'];
                $array[$arraylength]['aceptados'] += $r['aceptados'];
                $array[$arraylength]['completadas'] += $r['completadas'];
                $array[$arraylength]['nuevoingreso'] += $r['nuevoingreso'];
                $array[$arraylength]['intencionreinscribirse'] += $r['intencionreinscribirse'];
                $array[$arraylength]['colegiaturasvencidas'] += $r['colegiaturasvencidas'];
                $array[$arraylength]['reinscripciones'] += $r['reinscripciones'];
                $array[$arraylength]['totalinscrito'] += $r['totalinscrito'];
                $array[$arraylength]['alumnosrestantes'] += $r['alumnosrestantes'];
                $array[$arraylength]['last'] = true;
            }

            return new View(array("datos" => $array, "graficas" => $arraygraficas), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    private function fileWrite($path, $data){
		$file=LDPDF::fileRead($path);
		LDPDF::fileWrite($file, $data);
		LDPDF::fileRelease($file);
		return true;
    }

    function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['materia'] == $id) {
                return $val;
            }
        }
        return null;
     }

    /**
    * @Rest\Get("/api/Reportes/MetasInscripcion/ReporteMetasInscripcion/", name="getReporteMetasInscripcion")
    */
    public function getReporteMetasInscripcion() {
        $datos = $_REQUEST;
        $filtros = array_filter($datos);
        $dbm = new DbmReportes($this->get("db_manager")->getEntityManager());
        $cicloactual = $dbm->getRepositorioById('Ciclo','cicloid', $filtros['cicloactualid']);
        $ciclodestino = $dbm->getRepositorioById('Ciclo','cicloid', $filtros['ciclodestinoid']);
        $nivel = $dbm->getRepositorioById('Nivel','nivelid', $filtros['nivelid']);
        $grado = $dbm->getRepositorioById('Grado','gradoid', $filtros['gradoid']);


        $env=[1=>"Lux/",2=>"Ciencias/"];
        try{
            $path = str_replace('app', '', $this->get('kernel')->getRootDir());
            $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";

            switch (ENTORNO) {
                case 1:
                    $logo = $path . "Lux/logo.png";
                    $plantilla = "\"" . $path . "Lux/";
                    break;
                case 2:
                    $logo = $path . "Ciencias/logo.png";
                    $plantilla = "\"" . $path . "Ciencias/";
                    break;
            }
            $params=[
                "cicloactualidp"=>$filtros['cicloactualid'],
                "cicloactual"=> $cicloactual ? $cicloactual->getNombre() : '',
                "ciclodestinoidp" => $filtros['ciclodestinoid'],
                "ciclodestino" => $ciclodestino ? $ciclodestino->getNombre() : '',
                "nivelidp" => $filtros['nivelid'] ? $filtros['nivelid'] : '',
                "gradoidp" => $filtros['gradoid'] ? $filtros['gradoid'] : '',
                "nivel" => $nivel ? $nivel->getNombre() : '',
                "grado" => $grado ? $grado->getGrado() : '',
                "logo"=>$logo
            ];

            if($filtros['nivelid'] || $filtros['gradoid']) {
                $plantilla = $plantilla . "Metas_Inscripcion.jrxml\"";
            } else {
                $plantilla = $plantilla . "Metas_Inscripcion_nivels.jrxml\"";

            }


            $jasper = new JasperPHP($this->container);
            $respuesta = $jasper->process(
                $plantilla,
                "\"" . $path . "Metas_Inscripcion\"",
                array('xlsx'),
                $params,
                true
            )->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/Metas_Inscripcion.xlsx";
            if ($respuesta) {
                return new View($respuesta, Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte),
                200,
                array(
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
                    'Content-Length' => filesize($reporte)
                )
            );
            unlink($reporte);
            return $response;
        }catch(Exception $e){ return new View($e->getMessage(), Response::HTTP_BAD_REQUEST); }
    }
}
