<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\DB\DbmReportes;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Rest\Api;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
use AppBundle\Entity\CeAsistenciaporpadreotutor;
use AppBundle\Entity\CeJuntapadretutor;


/**
 * @author David
 */

class JuntasPadresController extends FOSRestController
{
    /**
     * Obtiene los catalogos para buscar alumnos en la modal
     * @Rest\Get("/api/ControlEscolar/JuntasPadres", name="indexJuntasPadres")
     */
    public function indexJuntasPadres()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById("Ciclo", "activo", 1);
            $nivel = $dbm->getRepositoriosById("Nivel", "activo", 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
			$periodoeval = $dbm->getRepositoriosModelo("CePeriodoevaluacion", ["d.periodoevaluacionid, d.descripcion, IDENTITY(c.cicloid) as cicloid, GROUPCONCAT(DISTINCT IDENTITY(g.gradoid)) as gradoid"],
				[], false, false, [
				["entidad" => "CeConjuntoperiodoevaluacion", "alias" => "c", "left" => false, "on" => "c.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
				["entidad" => "CeGradoporconjuntoperiodoescolar", "alias" => "g", "left" => false, "on" => "g.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
            ], 'd.periodoevaluacionid');
            $param = $dbm->getRepositorioById('Parametros', 'parametrosid', 156);

            $usuarios= $dbm->getRepositoriosModelo("Usuario", ["d.usuarioid, CASE WHEN p.personaid is not null THEN concat_ws(' ', p.apellidopaterno, p.apellidomaterno, p.nombre) ELSE concat_ws(' ', pr.apellidopaterno, pr.apellidomaterno, pr.nombre) end as nombre"],
            [["tipousuarioid IN (1,2 ) and d.activo = 1 and (d.personaid is not null or d.profesorid is not null)"]], false, true, [
            ["entidad" => "Persona", "alias" => "p", "left" => true, "on" => "d.personaid = p.personaid"],
            ["entidad" => "CeProfesor", "alias" => "pr", "left" => true, "on" => "d.profesorid = pr.profesorid"],
        ], 'd.usuarioid');


            $array = array("ciclo" => $ciclo, 
                "nivel" => $nivel, 
                "grado" => $grado, 
                "semestre" => $semestre,
                "grupo" => $grupo,
                "periodos" => $periodoeval,
                "param" => $param && $param->getValor() ? intval($param->getValor()) : null,
                "usuarios" => $usuarios
            );
            return new View($array, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * Obtiene los catalogos para buscar alumnos en la modal
     * @Rest\Get("/api/ControlEscolar/JuntasPadres/Consultar", name="ConsultarJuntaPadre")
     */
    public function ConsultarJuntaPadre()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $url = $dbm->getRepositorioById('Parametros', 'nombre', 'URLServicios');

            $id = $dbm->BuscarIProfesorTitular($filtros['grupoid']);
            $periodo = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $filtros['periodoevaluacionid']);
            $dbm->getConnection()->beginTransaction();

            $juntapadre = $dbm->getRepositoriosModelo("CeJuntapadretutor", ["d.juntapadreotutorid, IDENTITY(d.grupoid) as grupoid, 
            IDENTITY(d.usuarioid) as usuarioid, IDENTITY(d.periodoevaluacionid) as periodoevaluacionid, d.bloqueocalificacion, DATE_FORMAT(d.fecha, '%d/%m/%Y') as fechaformatted,
                DATE_FORMAT(d.hora , '%H:%i') as hora, d.fecha"],
                [["grupoid =" . $filtros['grupoid'] . " and d.periodoevaluacionid =" . $filtros['periodoevaluacionid']]], false, true, [])[0];
            
            if(!$juntapadre) {
                $juntas = new CeJuntapadretutor();
                $juntas->setGrupoid($dbm->getRepositorioById('CeGrupo', 'grupoid', $filtros['grupoid']));
                $juntas->setPeriodoevaluacionid($dbm->getRepositorioById('CePeriodoevaluacion', 'periodoevaluacionid', $filtros['periodoevaluacionid']));
                $juntas->setUsuarioid($id[0] ? 
                    $dbm->getRepositorioById('Usuario', 'usuarioid', $id[0]['usuarioid']) : null);
                $juntas->setFecha(new \DateTime());
                $juntas->setHora(new \DateTime());
                $juntas->setBloqueocalificacion(1);
                $dbm->saveRepositorio($juntas);

                $juntapadre = $dbm->getRepositoriosModelo("CeJuntapadretutor", ["d.juntapadreotutorid, IDENTITY(d.grupoid) as grupoid, 
                IDENTITY(d.usuarioid) as usuarioid, IDENTITY(d.periodoevaluacionid) as periodoevaluacionid, d.bloqueocalificacion, DATE_FORMAT(d.fecha, '%d/%m/%Y') as fechaformatted,
                    DATE_FORMAT(d.hora , '%H:%i') as hora, d.fecha"],
                    [["grupoid =" . $filtros['grupoid'] . " and d.periodoevaluacionid =" . $filtros['periodoevaluacionid']]], false, true, [])[0];
            }

            if(isset($filtros["gradoid"])){
                $conn=$dbm->getConnection();
                $stmt=$conn->prepare(
                    "select ac.alumnoporcicloid, a.matricula, acg.numerolista, a.alumnoid,
                    concat_ws(' ',a.matricula, ' - ', a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,
                    gru.nombre as grupo,
                    GROUP_CONCAT(DISTINCT CONCAT_WS(' ', pt.apellidopaterno, pt.apellidomaterno, pt.nombre) separator '<br>') as padres,
                    apt.tipoasistenciaid as tipoasistenciaid,
                    apt.estatusinasistenciaid as estatusinasistenciaid,
                    apt.asistenciaporpadreotutorid

                    from ce_alumno a
                    inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
                    inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
                    inner join ce_grupo gru on gru.grupoid=acg.grupoid
                    left join ce_alumnoporclavefamiliar acf on acf.alumnoid=a.alumnoid
                    left join ce_asistenciaporpadreotutor apt on apt.alumnoporcicloid = ac.alumnoporcicloid
                    left join ce_padresotutoresclavefamiliar ppcf on ppcf.clavefamiliarid = acf.clavefamiliarid
                    left join ce_padresotutores pt on pt.padresotutoresid = ppcf.padresotutoresid
                    where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"]." and ac.gradoid=".$filtros["gradoid"]." and acg.grupoid=".$filtros["grupoid"] .
                    " group by a.alumnoid order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre"
                );
                $stmt->execute();
                $alumnosgrupo=$stmt->fetchAll();
            }
            
            if(!$alumnosgrupo) {
                return array("mensaje" => "No se han encontrado alumnos en el grupo asignado.", "error" => true);
            }
            
            foreach($alumnosgrupo as $key=>$alumno) {
                $alumnosgrupo[$key]['foto'] = $url->getValor() . '/api/Alumno/foto?alumnoid=' . $alumno['alumnoid'];
                $asis = $dbm->getRepositoriosModelo("CeAsistenciaporpadreotutor", ["d"],
                [["asistenciaporpadreotutorid is not null and d.alumnoporcicloid =" . $alumno['alumnoporcicloid'] . ' and c.grupoid =' . $filtros['grupoid']. ' and c.periodoevaluacionid =' . $filtros['periodoevaluacionid'] ]], false, true, [
                ["entidad" => "CeJuntapadretutor", "alias" => "c", "left" => false, "on" => "c.juntapadreotutorid = d.juntapadreotutorid"],
                    ], 'd.alumnoporcicloid')[0];
    
                if(!$asis) {
                    $tipo = $dbm->getRepositorioById('CeTipoasistencia', 'tipoasistenciaid', 1);
                    $estatus = $dbm->getRepositorioById('CeEstatusinasistencia', 'estatusinasistenciaid', 1);
    
                    $asistencia = new CeAsistenciaporpadreotutor();
                    $asistencia->setAlumnoporcicloid($alumno['alumnoporcicloid'] ? 
                        $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno['alumnoporcicloid']) : null);
                    $asistencia->setJuntapadreotutorid($juntas);
                    $asistencia->setTipoasistenciaid($tipo);
                    $asistencia->setEstatusinasistenciaid($estatus);
                    $dbm->saveRepositorio($asistencia);
                    $alumnosgrupo[$key]['tipoasistenciaid'] = $asistencia->getTipoasistenciaid()->getTipoasistenciaid();
                    $alumnosgrupo[$key]['estatusinasistenciaid'] = $asistencia->getEstatusinasistenciaid()->getEstatusinasistenciaid();
                }
                    
            }

            $conn=$dbm->getConnection();
            $stmt=$conn->prepare(
                "select ac.alumnoporcicloid, a.matricula, acg.numerolista, a.alumnoid,
                concat_ws(' ',a.matricula, ' - ', a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,
                gru.nombre as grupo,
                GROUP_CONCAT(DISTINCT CONCAT_WS(' ', pt.apellidopaterno, pt.apellidomaterno, pt.nombre) separator '<br>') as padres,
                apt.tipoasistenciaid as tipoasistenciaid,
                apt.estatusinasistenciaid as estatusinasistenciaid,
                apt.asistenciaporpadreotutorid

                from ce_alumno a
                inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
                inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
                inner join ce_grupo gru on gru.grupoid=acg.grupoid
                left join ce_alumnoporclavefamiliar acf on acf.alumnoid=a.alumnoid
                left join ce_asistenciaporpadreotutor apt on apt.alumnoporcicloid = ac.alumnoporcicloid
                left join ce_padresotutoresclavefamiliar ppcf on ppcf.clavefamiliarid = acf.clavefamiliarid
                left join ce_padresotutores pt on pt.padresotutoresid = ppcf.padresotutoresid
                where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"]." and ac.gradoid=".$filtros["gradoid"]." and acg.grupoid=".$filtros["grupoid"] .
                " group by a.alumnoid order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre"
            );
            $stmt->execute();
            $alumnosgrupo=$stmt->fetchAll();
            
            $dbm->getConnection()->commit();
            return new View(array("alumnos" => $alumnosgrupo,"junta" => $juntapadre), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function parseDia($fechats) {
        switch (intval(date('w', $fechats))){
            case 0: $valor =  "Domingo"; break;
            case 1: $valor = "Lunes"; break;
            case 2: $valor = "Martes"; break;
            case 3: $valor = "Miercoles"; break;
            case 4: $valor = "Jueves"; break;
            case 5: $valor = "Viernes"; break;
            case 6: $valor = "Sabado"; break;
        } 
        return $valor;
    }

    /**
     * @Rest\Put("/api/ControlEscolar/JuntasPadres/saveJunta" , name="saveJunta")
     */
    public function saveJunta()
    {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());


            //Actualizamos  los datos
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $junta = $dbm->getRepositorioById('CeJuntapadretutor', 'juntapadreotutorid', $data['juntapadreotutorid']);
            $hora = new \DateTime($data['hora']);
            $data['hora'] = $hora->format('H:i:s');
            $area = $hydrator->hydrate($junta, $data);
            $dbm->saveRepositorio($area);

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }


    /**
     * @Rest\Put("/api/ControlEscolar/JuntasPadres/setRetardoJuntaAlumnos" , name="setRetardoJuntaAlumnos")
     */
    public function setRetardoJuntaAlumnos()
    {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            //Actualizamos el estatus
            $dbm->getConnection()->beginTransaction();

            $tipo = $dbm->getRepositorioById('CeTipoasistencia', 'tipoasistenciaid', 2);
            $estatus = $dbm->getRepositorioById('CeEstatusinasistencia', 'estatusinasistenciaid', 3);

            foreach($data as $alumno) {
                $filtros = array (
                    'asistenciaporpadreotutorid' => $alumno['asistenciaporpadreotutorid']
                );
                $asis = $dbm->getOneByParametersRepositorio('CeAsistenciaporpadreotutor', $filtros);
                $asis->setTipoasistenciaid($tipo);
                $asis->setEstatusinasistenciaid($estatus);
                $dbm->saveRepositorio($asis);
            }



            $dbm->getConnection()->commit();
            return new View("Se han actualizado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

        /**
	 * @Rest\Get("/api/ControlEscolar/JuntasPadres/ReporteJuntasPadres/" , name="ReporteJuntasPadres")
	 */
    public function ReporteJuntasPadres() {
        $datos=$_REQUEST;
        $filtros=array_filter($datos);

        $encabezado = $filtros['encabezado'];
        $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $arraytotals = [];
        $ciclo = $dbm->getRepositorioById("Ciclo", "cicloid", $filtros['cicloid']);
        $nivel = $dbm->getRepositorioById("Nivel", "nivelid", $filtros['nivelid']);
        $grado = $dbm->getRepositorioById("Grado", "gradoid", $filtros['gradoid']);
        $grupo = $dbm->getRepositorioById("CeGrupo", "grupoid", $filtros['grupoid']);
        $prof = $dbm->getOneByParametersRepositorio('CeJuntapadretutor', array("grupoid" => $filtros['grupoid'], "periodoevaluacionid" => $filtros['periodoevaluacionid']));

        $us = $dbm->getRepositoriosModelo("Usuario", ["d.usuarioid, CASE WHEN p.personaid is not null THEN concat_ws(' ', p.apellidopaterno, p.apellidomaterno, p.nombre) ELSE concat_ws(' ', pr.apellidopaterno, pr.apellidomaterno, pr.nombre) end as nombre"],
            [["usuarioid = " . $prof->getUsuarioid()->getUsuarioid()]], false, true, [
            ["entidad" => "Persona", "alias" => "p", "left" => true, "on" => "d.personaid = p.personaid"],
            ["entidad" => "CeProfesor", "alias" => "pr", "left" => true, "on" => "d.profesorid = pr.profesorid"],
        ], 'd.usuarioid')[0];

        if(isset($filtros["gradoid"])){
            $conn=$dbm->getConnection();
            $stmt=$conn->prepare(
                "select ac.alumnoporcicloid, a.matricula, acg.numerolista, a.alumnoid,
                concat_ws(' ',a.matricula, ' - ', a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as 'Alumno',
                gru.nombre as grupo,
                GROUP_CONCAT(DISTINCT CONCAT_WS(' ', pt.apellidopaterno, pt.apellidomaterno, pt.nombre) separator '\n') as 'Padres',
                apt.tipoasistenciaid as tipoasistenciaid,
                apt.estatusinasistenciaid as estatusinasistenciaid,
                apt.asistenciaporpadreotutorid

                from ce_alumno a
                inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
                inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
                inner join ce_grupo gru on gru.grupoid=acg.grupoid
                left join ce_alumnoporclavefamiliar acf on acf.alumnoid=a.alumnoid
                inner join ce_asistenciaporpadreotutor apt on apt.alumnoporcicloid = ac.alumnoporcicloid
                inner join ce_juntapadretutor jp on jp.juntapadreotutorid = apt.juntapadreotutorid
                left join ce_padresotutoresclavefamiliar ppcf on ppcf.clavefamiliarid = acf.clavefamiliarid
                left join ce_padresotutores pt on pt.padresotutoresid = ppcf.padresotutoresid
                where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"].
                    " and ac.gradoid=".$filtros["gradoid"]." and acg.grupoid=".$filtros["grupoid"] . " and jp.periodoevaluacionid = " . $filtros["periodoevaluacionid"] .
                " group by a.alumnoid order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre"
            );
            $stmt->execute();
            $alumnosgrupo=$stmt->fetchAll();
        }


        $path = str_replace('app', '', $this->get('kernel')->getRootDir());
        $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";


        foreach($alumnosgrupo as $f) {

            foreach($f as $key=>$info) {
                if($key === "Alumno" || $key === "Padres") {
                    $arraytotals[] = [
                        "x" => $f['numerolista'],
                        "y" => $key,
                        "val" => $info
                    ];
                }

                if($key === "tipoasistenciaid") {
                    $obj = array(
                        "x" => $f['numerolista'],
                        "y" => "Asistió",
                        "val" => $path . $this->imagen($f['tipoasistenciaid'], $f['estatusinasistenciaid'])
                    );
                    $arraydatos[] = $obj;
                }

            }
        }
        $report="ReporteAsistenciasJunta";
        $filebase="$report-".(rand()%10000);
        $pdf=new LDPDF($this->container, $report, $filebase, ['driver'=>'json', 'data_file'=>$filebase, 'json_query'=>'""'], [], ['xlsx']);
        $data = array("prof" => $arraydatos, "nivel" => $nivel->getNombre(), "grado" => $grado->getGrado(), "estatus" => $arraytotals,
            "grupo" => $grupo->getNombre(), "ciclo" => $ciclo->getNombre(), "maestro" => $us['nombre']);
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
    }

    private function fileWrite($path, $data){
		$file=LDPDF::fileRead($path);
		LDPDF::fileWrite($file, $data);
		LDPDF::fileRelease($file);
		return true;
    }

    public function imagen ($val, $estatus) {
        if ($estatus == 2 || $estatus == 3) {
            switch (intval($estatus)) {
                case 2:    
                    $img = "cancelada.png";
                break;
                case 3:
                    $img = "justificada.png";
                break;
            }
        } else {
            switch (intval($val)) {
                case 1:
                    $img = "success.png";
                    break;
                case 2:    
                    $img = "fail.png";
                break;
                case 3:
                    $img = "clock.png";
                break;
                case 4:
                    $img = "suspension.png";
                break;
            }
        }
        return $img;
    }

        /**
     * @Rest\Put("/api/ControlEscolar/JuntasPadres/Estatus" , name="updateJuntasPadresEstatus")
     */
    public function updateJuntasPadresEstatus()
    {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());


            //Actualizamos el estatus
            $dbm->getConnection()->beginTransaction();
            $Asistencia = $dbm->getRepositorioById('CeAsistenciaporpadreotutor', 'asistenciaporpadreotutorid', $data['objeto']["asistenciaporpadreotutorid"]);
            $nivelid = $Asistencia->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNivelid();
            $tiposasistencias =  [1,2];

            $tiposasistenciaactual = $Asistencia->getTipoasistenciaid();
            $tiposasistencia = $Asistencia->getTipoasistenciaid();


            foreach($tiposasistencias as $key => $tp){
                if($tiposasistenciaactual->getTipoasistenciaid() == $tp){
                    $next = $key+1;
                    $total = count($tiposasistencias) - 1;
                    if($next > $total || $next > 2){
                        $next = 0;
                    }
                    $tiposasistencia = $tiposasistencias[$next];
                }
            }
            $Asistencia->setTipoasistenciaid($dbm->getRepositorioById("CeTipoasistencia","tipoasistenciaid",$tiposasistencia));
            $Asistencia->setEstatusinasistenciaid($dbm->getRepositorioById("CeEstatusinasistencia","estatusinasistenciaid",1));
            $dbm->saveRepositorio($Asistencia);
            $dbm->getConnection()->commit();

            return new View(['tipoasistencia' =>  $tiposasistencia], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }
}
