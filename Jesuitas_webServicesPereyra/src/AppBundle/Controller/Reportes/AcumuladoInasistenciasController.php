<?php

namespace AppBundle\Controller\Reportes;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Rest\Api;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;

/**
 * @author David
 */

class AcumuladoInasistenciasController extends FOSRestController
{
    /**
     * Obtiene los catalogos para buscar alumnos en la modal
     * @Rest\Get("/api/Reportes/AcumuladoInasistencias", name="AcumuladoInasistencias")
     */
    public function AcumuladoInasistencias()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById("Ciclo", "activo", 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);

            $array = array("ciclo" => $ciclo, "nivel" => $nivel, "grado" => $grado, "grupo" => $grupo, "semestre" => $semestre);
            return new View($array, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Reportes/AcumuladoInasistencias/Consultar", name="GetInasistencias")
     */
    public function GetInasistencias()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $filtros['alumnoestatusid'] = 1;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $respuesta = $this->GetFaltasByAlumnos($filtros, $dbm);

            return new View($respuesta, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public static function GetFaltasByAlumnos($filtros, $dbm) {
        $filtros['ingrupo'] = true;
        $conn=$dbm->getConnection();
        if(isset($filtros["grupoid"])){
            $grupo=" and acg.grupoid=".$filtros["grupoid"];
        }
        if(isset($filtros["gradoid"])){
            $alumnos=$dbm->buscarAlumnosA($filtros);
        }
        $arraydatos = [];
        $arraytotalxmateria = [];
        $arrmaterias = [];
        /*$materias = $dbm->getRepositoriosModelo("CeMateriaporplanestudios", 
            ["d.materiaporplanestudioid, m.nombre as nombre "], 
            [["materiaporplanestudioid is not null and p.gradoid = " . $filtros['gradoid'] . " and p.vigente = 1"]], false, true, [
            ["entidad" => "CePlanestudios", "alias" => "p", "left" => false, "on" => "p.planestudioid = d.planestudioid"],
            ["entidad" => "Materia", "alias" => "m", "left" => false, "on" => "m.materiaid = d.materiaid"]
            ],["m.nombre"]);*/
        foreach($alumnos as $key=>$a) {
            $totalfaltas = 0;
            $arraydatos[$key] = [
                "matricula" => $a['matricula'], 
                "alumno" => $a['nombrecompleto']
            ];
            if($filtros['nivelsimple'] !== "true") {
                $materias = $dbm->getMateriasAlumno($a);

                foreach ($materias as $m) {
                    if (!in_array($m['materia'], $arrmaterias)) {
                        array_push($arrmaterias, $m['materia']);
                    }
                    $warning = null;
                    $danger = null;
                    $mat = $dbm->getRepositorioById('CeMateriaporplanestudios', 'materiaporplanestudioid', $m['materiaporplanestudioid']);
                    $faltas = $dbm->getRepositoriosModelo("CeAsistencia", 
                        ["CASE WHEN d.asistenciaid is not null THEN  SUM(CASE WHEN d.estatusinasistenciaid = 1 OR d.estatusinasistenciaid = 3 THEN 1 ELSE 0 end) ELSE SUM(CASE WHEN ad.estatusinasistenciaid = 1 OR ad.estatusinasistenciaid = 3 THEN 1 ELSE 0 end) end as faltas "], 
                        [["tipoasistenciaid = 2 and mpe.materiaporplanestudioid = " . $m['materiaporplanestudioid'] . " and ac.alumnoporcicloid = " . $a['alumnoporcicloid']]], false, true, [
                        ["entidad" => "CeProfesorpormateriaplanestudios", "alias" => "pmpe", "left" => false, "on" => "pmpe.profesorpormateriaplanestudiosid = d.profesorpormateriaplanestudioid"],
                        ["entidad" => "CeAlumnoporciclo", "alias" => "ac", "left" => false, "on" => "ac.alumnoporcicloid = d.alumnoporcicloid"],
                        ["entidad" => "CeAsistenciapordia", "alias" => "ad", "left" => true, "on" => "ad.alumnoporcicloid = d.alumnoporcicloid"],
                        ["entidad" => "CeGradoportallercurricular", "alias" => "acg", "left" => true, "on" => "acg.tallercurricularid = pmpe.tallerid and acg.gradoid = ac.gradoid"],
                        ["entidad" => "CeMateriaporplanestudios", "alias" => "mpe", "left" => true, "on" => "(mpe.materiaporplanestudioid = acg.materiaporplanestudioid OR mpe.materiaporplanestudioid = pmpe.materiaporplanestudioid)"],
                    ])[0];
                    $faltasalumno = intval($faltas['faltas'] ? $faltas['faltas'] : 0);
                    $faltaspermitidas=$mat->getHorasporsemana()*2;
                    $x = $mat->getHorasporsemana();
                    $paramformula = $dbm->getRepositorioById('Parametros', 'nombre', 'FormulaFaltasPermitidas');
                    $formula = $paramformula ? $paramformula->getValor() : null;
                    if(!$formula) {
                        return new view('No se ha encontrado la formula de faltas permitidas', Response::HTTP_PARTIAL_CONTENT);
                    }
                    eval('$total= '.$formula.';');
                    $faltaspermitidas = $total;
                    if ($faltasalumno == $faltaspermitidas && $filtros['detalle']) {
                        $warning = true;
                    }
                    if ($faltasalumno > $faltaspermitidas && $filtros['detalle']){
                        $danger = true;
                    }
                    if ($filtros['detalle']) {
                        $arraydatos[$key]['materias'][] = [
                            'FALTAS' => $faltasalumno, 
                            'LIMITE' => $faltaspermitidas, 
                            "warning"=> $warning, 
                            "danger"=> $danger,
                            "materiaporplanestudioid" => $m['materiaporplanestudioid'],
                            "materia" => $m['materia']
                        ];
                    } else {
                        $arraydatos[$key]['materias'][] = [
                            'FALTAS' => $faltasalumno, 
                            "LIMITE"=> $warning, 
                            "danger"=> $danger,
                            "materiaporplanestudioid" => $m['materiaporplanestudioid'],
                            "materia" => $m['materia']
                        ];
                    }
                    $totalfaltas += $faltasalumno;
                    if(!$arraytotalxmateria[$m['materia']] ) {
                        if($filtros['detalle']) {
                            $arraytotalxmateria[$m['materia']] = array("FALTAS" => 0, "materia"=> $m['nombre'], "LIMITE" => $faltaspermitidas);
                        } else {
                            $arraytotalxmateria[$m['materia']] = array("FALTAS" => 0, "materia"=> $m['nombre']);
    
                        }
                    }
                    $arraytotalxmateria[$m['materia']]['FALTAS'] += $faltasalumno;
            
                }
                $arraydatos[$key]['totalfaltas']= $totalfaltas;
                $arraytotalxmateria[0] = $arraytotalxmateria[0] + $totalfaltas;
                
            } else {
                $totalf = $dbm->getRepositoriosModelo("CeAsistenciapordia", 
                ["d.asistenciapordiaid "], 
                [["tipoasistenciaid = 2 and ac.alumnoporcicloid = " . $a['alumnoporcicloid']]], false, true, [
                    ["entidad" => "CeAlumnoporciclo", "alias" => "ac", "left" => false, "on" => "ac.alumnoporcicloid = d.alumnoporcicloid"],

                ]);

                $totalfdiaria = $dbm->getRepositoriosModelo("CeCapturaalumnoporperiodo", 
                ["SUM(d.asistencia) as totalasis"], 
                [["capturaalumnoporperiodoid is not null and d.alumnoporcicloid = " . $a['alumnoporcicloid']]], false, true, [

                ])[0];

                $arraydatos[$key]['totalfaltas'] = count($totalf);
                $arraydatos[$key]['TOTAL FALTAS'] = count($totalf);

                $arraydatos[$key]['totalfaltas'] = $arraydatos[$key]['totalfaltas'] + ($totalfdiaria['totalasis'] ? intval($totalfdiaria['totalasis']) : 0);
                $arraydatos[$key]['TOTAL FALTAS'] = $arraydatos[$key]['TOTAL FALTAS'] +  ($totalfdiaria['totalasis'] ? intval($totalfdiaria['totalasis']) : 0);
            }
        }
        return array("alumnos"=>$arraydatos, "materias"=> $arrmaterias, "totalxmateria" => $arraytotalxmateria);
    }

    /**
     * 
     * @Rest\Get("/api/Reportes/AcumuladoInasistencias/ReporteInasistencias/{id}", name="ReporteInasistencias")
     */
    public function ReporteInasistencias($id)
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $filtros['alumnoestatusid'] = 1;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $filtros['cicloid']);
            if($filtros['nivelid']){
                $nivel = $dbm->getRepositorioById('Nivel', 'nivelid', $filtros['nivelid']);
            }
            if($filtros['gradoid']){
                $grado = $dbm->getRepositorioById('Grado', 'gradoid', $filtros['gradoid']);
            }
            if($filtros['grupoid']){
                $grupo = $dbm->getRepositorioById('CeGrupo', 'grupoid', $filtros['grupoid']);
            }
            $respuesta = $this->GetFaltasByAlumnos($filtros, $dbm);
            $arrayalumnosi = [];
            foreach($respuesta['alumnos'] as $r) {
                if($filtros['nivelsimple'] !== "true") {
                    foreach($respuesta['totalxmateria'] as $keyr=>$mat) {
                        $keyzx = $this->searchForId($keyr, $r['materias']);
                        if($keyzx) {
                            foreach($keyzx as $key=>$k) {
                                if($key === 'FALTAS' || $key === 'LIMITE') {
                                    $arrayalumnosi[] = array(
                                        "x" => $r['matricula'] . ' - ' . $r['alumno'],
                                        "y" => $keyzx['materia'],
                                        "y1" => $key,
                                        "val" => $k
                                    );
                                }
                            }
                        } else {
                            $arrayalumnosi[] = array(
                                "x" => $r['matricula'] . ' - ' . $r['alumno'],
                                "y" => $keyr,
                                "y1" => "FALTAS",
                                "val" => null
                            );
                            if($filtros['detalle']) {
                                $arrayalumnosi[] = array(
                                    "x" => $r['matricula'] . ' - ' . $r['alumno'],
                                    "y" => $keyr,
                                    "y1" => "LIMITE",
                                    "val" => null
                                );
                            }
                        }
                    }
                    $arrayalumnosi[] = array(
                        "x" => $r['matricula'] . ' - ' . $r['alumno'],
                        "y" => "TOTAL",
                        "y1" => "",
                        "val" => $r['totalfaltas']
                    );
                } else {
                    foreach($r as $kyz=>$data) {
                        if($kyz === 'TOTAL FALTAS') {
                            $arrayalumnosi[] = array(
                                "x" => $r['matricula'] . ' - ' . $r['alumno'],
                                "y" => $kyz,
                                "val" => $data
                            );
                        }
                    }
                }
            }


            /*foreach($respuesta['alumnos'] as $r) {
                foreach($r['materias'] as $mat) {
                    foreach($mat as $key=>$info) {
                        if($key === 'faltas' || $key === 'limite') {
                            $arrayalumnosi[] = array(
                                "x" => $r['matricula'] . ' - ' . $r['alumno'],
                                "y" => $mat['materia'],
                                "y1" => $key,
                                "val" => $info
                            );
                        }
                    }
                }
            } */
            if($filtros['nivelsimple'] !== "true") {
                foreach($respuesta['totalxmateria'] as $kyz=>$tm) {
                    if($kyz !== 0) {
                        foreach($tm as $key=> $info) {
                            if($key === 'FALTAS') {
                                $arrayalumnosi[] = array(
                                    "x" => "TOTAL",
                                    "y" => $kyz,
                                    "y1" => $key,
                                    "val" => $info
                                );
                            }
                        }
                    } else if ($kyz == 0)  {
                        $arrayalumnosi[] = array(
                            "x" => "TOTAL",
                            "y" => "TOTAL",
                            "y1" => "",
                            "val" => $tm 
                        );
                    }
                }
            }

            
            if($filtros['nivelsimple'] !== "true") {
			    $report="InasistenciasAcumuladas";
            } else {
			    $report="InasistenciasAcumuladasDiaria";
            }
			$filebase="$report-".(rand()%10000);
            $pdf=new LDPDF($this->container, $report, $filebase, ['driver'=>'json', 'data_file'=>$filebase, 'json_query'=>'""'], [], ['xlsx']);
            $data = array("prof" => $arrayalumnosi, "ciclo" => $ciclo->getNombre(), "nivel"=> $nivel ? $nivel->getNombre() : '', 
                "grado" => $grado ? $grado->getGrado() : '', "grupo" => $grupo ? $grupo->getNombre() : '');
			$this->fileWrite($pdf->fdb_r, json_encode($data));
            $result=$pdf->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/$filebase.xlsx";
            if (!$reporte) {
                return new View("No se ha podido procesar el reporte", Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte),
                200,
                array(
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
                    'Content-Length' => filesize($reporte)
                )
            );
			LDPDF::fileDelete($pdf->fdb_r);
			if(!$result){
				LDPDF::fileDelete($pdf->output_r);
            }
            return $response;
            return new View($respuesta, Response::HTTP_OK);
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
}
