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
use AppBundle\Entity\CeAsistenciapordia;

/**
 * @author David
 */

class AsistenciaDiariaController extends FOSRestController
{
    /**
     * Obtiene los catalogos para buscar alumnos en la modal
     * @Rest\Get("/api/ControlEscolar/AsistenciaDiaria", name="indexAsistenciaDiaria")
     */
    public function indexAsistenciaDiaria()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById("Ciclo", "activo", 1);
            $nivel = $dbm->getRepositoriosModelo("Nivel", 
            ["d.nivelid, d.nombre"], 
                [["nivelid is not null and cn.asistenciapordia = 1 and d.activo = 1 "]], false, true, [
                ["entidad" => "CeConfiguracionnivel", "alias" => "cn", "left" => false, "on" => "cn.configuracionnivelid = d.configuracionnivelid"]
            ]);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
			$periodoeval = $dbm->getRepositoriosModelo("CePeriodoevaluacion", ["d.periodoevaluacionid, d.descripcion, IDENTITY(c.cicloid) as cicloid, GROUPCONCAT(DISTINCT IDENTITY(g.gradoid)) as gradoid"],
				[], false, false, [
				["entidad" => "CeConjuntoperiodoevaluacion", "alias" => "c", "left" => false, "on" => "c.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
				["entidad" => "CeGradoporconjuntoperiodoescolar", "alias" => "g", "left" => false, "on" => "g.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
            ], 'd.periodoevaluacionid');
            $param = $dbm->getRepositorioById('Parametros', 'parametrosid', 156);


            $array = array("ciclo" => $ciclo, 
                "nivel" => $nivel, 
                "grado" => $grado, 
                "semestre" => $semestre,
                "grupo" => $grupo,
                "periodos" => $periodoeval,
                "param" => $param && $param->getValor() ? intval($param->getValor()) : null
            );
            return new View($array, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * Obtiene los catalogos para buscar alumnos en la modal
     * @Rest\Get("/api/ControlEscolar/AsistenciaDiaria/Consultar", name="ConsultarAsistenciaDiarias")
     */
    public function ConsultarAsistenciaDiarias()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if($filtros['permiso'] != 1) {
                $id = $dbm->BuscarIProfesorTitular($filtros['grupoid']);
                if(!$id) {
                    return new View("No se han encontrado profesores en el grupo consultado", Response::HTTP_PARTIAL_CONTENT);
                }

                $usuario = $dbm->getRepositorioById('Usuario', 'profesorid', $id[0]["profesorid"]);
                if(!$usuario) {
                    return new View("Se requiere tener un permiso especial o ser el profesor titular para poder consultar", Response::HTTP_PARTIAL_CONTENT);
    
                }
                if($usuario->getUsuarioid() != $filtros['usuarioid']) {
                    return new View("Se requiere tener un permiso especial o ser el profesor titular para poder consultar", Response::HTTP_PARTIAL_CONTENT);
                }
            } 
            $respuesta = $this->asistenciasDiarias($filtros, $dbm);
            if($respuesta['error']) {
                return new View($respuesta['mensaje'], Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($respuesta, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public static function asistenciasDiarias($filtros, $dbm) {
        $periodo = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $filtros['periodoevaluacionid']);
        $fechaperiodoinicio = $periodo->getFechainicio();
        $fechaperiodofin = $periodo->getFechafin();
        $url = $dbm->getRepositorioById('Parametros', 'nombre', 'URLServicios');
        $dbm->getConnection()->beginTransaction();

        $startDate =  $filtros["rangofechas"]["beginDate"]["year"] . "-" . $filtros["rangofechas"]["beginDate"]["month"] . "-" . $filtros["rangofechas"]["beginDate"]["day"];
        $endDate = $filtros["rangofechas"]["endDate"]["year"] . "-" . $filtros["rangofechas"]["endDate"]["month"] . "-" . $filtros["rangofechas"]["endDate"]["day"];

        if ($filtros["rangofechas"]){
            $filtros["fechainicio"] = new \DateTime($startDate);
            $filtros["fechafin"] = new \DateTime($endDate);
        }

        if($filtros['fechainicio'] < $fechaperiodoinicio || $filtros['fechafin'] > $fechaperiodofin) {
            return array("mensaje" => "El rango de fechas debe ser mayor a la fecha inicio del periodo y menor a la fecha fin del periodo", "error" => true);
        }

        $dias=date_diff($filtros["fechainicio"],$filtros["fechafin"])->d+1;
        if ($dias>60) {
            return array("mensaje" => "Seleccione un rango de fechas menor a 60 días.", "error" => true);
        }

        if(isset($filtros["gradoid"])){
            $conn=$dbm->getConnection();
            $stmt=$conn->prepare(
                            "select ac.alumnoporcicloid, a.matricula, acg.numerolista, a.alumnoid,concat_ws(' ',a.matricula, ' - ', a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,gru.nombre as grupo
                from ce_alumno a
                inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
                inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
                inner join ce_grupo gru on gru.grupoid=acg.grupoid
                where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"]." and ac.gradoid=".$filtros["gradoid"]." and acg.grupoid=".$filtros["grupoid"] .
                " order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre"
            );
            $stmt->execute();
            $alumnosgrupo=$stmt->fetchAll();
        }
        
        if(!$alumnosgrupo) {
            return array("mensaje" => "No se han encontrado alumnos en el grupo asignado.", "error" => true);
        }

        $intervalo = \DateInterval::createFromDateString('1 day');
        $final = $filtros["fechafin"];
        $final = $final->modify('+1 day');
        $periodo = new \DatePeriod($filtros["fechainicio"], $intervalo, $filtros["fechafin"]);
        
        foreach($alumnosgrupo as $key=>$alumno) {
            $fechasalumno = [];
            foreach($periodo as $i) {
                $weekend = false;
                $fechaformat = $i->format("Y-m-d");
                $dia = AsistenciaDiariaController::parseDia(strtotime($fechaformat));
                $fechaasign = new \Datetime($fechaformat);
                $fechaformat = $i->format("d/m/Y");

                if(date('l', strtotime($i->format("d-m-Y"))) == 'Sunday' || date('l', strtotime($i->format("d-m-Y"))) == 'Saturday'){
                    $weekend = true;
                }
                $diasfestivos = $dbm->getByParametersRepositorios('CeEvento', [
                    'tipoeventoid' => 2,
                    'fechainicio' => $fechaasign
                ]);
                $diafestivo = false;
                foreach($diasfestivos as $d){
                    $nivel = $dbm->getOneByParametersRepositorio('CeEventopornivel', [
                        'nivelid' => $al['nivelid'],
                        'eventoid' => $d->getEventoid()
                    ]);
                    if($nivel){
                        $diafestivo = true;
                    }
                }
                if(!$diafestivo && !$weekend){
                    if (!in_array($dia . ' ' .$fechaformat, $arrayfechas)) {
                        $arrayfechas[] = $dia . ' ' .$fechaformat;
                    }
                    $filtrosa = array (
                        'grupoid' => $filtros['grupoid'],
                        'alumnoporcicloid' => $alumno['alumnoporcicloid'],
                        'fecha' => $fechaasign,
                        'periodoevaluacionid' => $filtros['periodoevaluacionid']
                    );
                    $asis = $dbm->getOneByParametersRepositorio('CeAsistenciapordia', $filtrosa);
                    if(!$asis) {
                        $tipo = $dbm->getRepositorioById('CeTipoasistencia', 'tipoasistenciaid', 1);
                        $estatus = $dbm->getRepositorioById('CeEstatusinasistencia', 'estatusinasistenciaid', 1);

                        $asistencia = new CeAsistenciapordia();
                        $asistencia->setAlumnoporcicloid($alumno['alumnoporcicloid'] ? 
                            $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno['alumnoporcicloid']) : null);
                        $asistencia->setGrupoid($filtros['grupoid'] ? 
                            $dbm->getRepositorioById('CeGrupo', 'grupoid', $filtros['grupoid']) : null);
                        $asistencia->setPeriodoevaluacionid($filtros['periodoevaluacionid'] ? 
                            $dbm->getRepositorioById('CePeriodoevaluacion', 'periodoevaluacionid', $filtros['periodoevaluacionid']) : null);
                        
                        $asistencia->setUsuarioid($filtros['usuarioid'] ? 
                            $dbm->getRepositorioById('Usuario', 'usuarioid', $filtros['usuarioid']) : null);    
                        
                        $asistencia->setFecha($i);
                        $asistencia->setHora(new \Datetime());
                        $asistencia->setTipoasistenciaid($tipo);
                        $asistencia->setEstatusinasistenciaid($estatus);
                        $dbm->saveRepositorio($asistencia);
                    }
                }
            }
            
            $asistencias =  $dbm->getRepositoriosModelo("CeAsistenciapordia", 
            ["d.asistenciapordiaid","d.fecha","d.hora","IDENTITY(d.tipoasistenciaid) AS tipoasistenciaid","IDENTITY(d.usuarioid) as usuarioid","IDENTITY(d.estatusinasistenciaid) as estatusinasistenciaid","IDENTITY(d.grupoid) as grupoid","IDENTITY(d.alumnoporcicloid) as alumnoporcicloid", "IDENTITY(d.periodoevaluacionid) as periodoevaluacionid"], 
            [["alumnoporcicloid = " . $alumno['alumnoporcicloid'] . "and d.periodoevaluacionid = " . $filtros['periodoevaluacionid'] . " and d.grupoid = " .  $filtros['grupoid'] . " and d.fecha between '" . $startDate . "' and '" . $endDate . "'"]], false, true, [
                ["entidad" => "CeAlumnoporciclo", "alias" => "ac", "left" => false, "on" => "ac.alumnoporcicloid = d.alumnoporcicloid"],
            ]);   
            
            $alumnosgrupo[$key]['asistencias'] = $asistencias;
            $alumnosgrupo[$key]['foto'] = $url->getValor() . '/api/Alumno/foto?alumnoid=' . $alumno['alumnoid'];

            $retardos =  $dbm->getRepositoriosModelo("CeAsistenciapordia", 
            ["d.asistenciapordiaid","d.fecha","d.hora","IDENTITY(d.tipoasistenciaid) AS tipoasistenciaid","IDENTITY(d.usuarioid) as usuarioid","IDENTITY(d.estatusinasistenciaid) as estatusinasistenciaid","IDENTITY(d.grupoid) as grupoid","IDENTITY(d.alumnoporcicloid) as alumnoporcicloid", "IDENTITY(d.periodoevaluacionid) as periodoevaluacionid"], 
            [["alumnoporcicloid = " . $alumno['alumnoporcicloid'] . "and d.ignorar is null and d.periodoevaluacionid = " . $filtros['periodoevaluacionid'] . " and d.grupoid = " .  $filtros['grupoid'] . " and d.estatusinasistenciaid = 1 and d.tipoasistenciaid = 3 and d.fecha between '" . $startDate . "' and '" . $endDate . "'"]], false, true, [
                ["entidad" => "CeAlumnoporciclo", "alias" => "ac", "left" => false, "on" => "ac.alumnoporcicloid = d.alumnoporcicloid"],
            ]);   

            foreach($retardos as $r) {
                $fechaformat = $r['fecha']->format("Y-m-d");
                $dia = AsistenciaDiariaController::parseDia(strtotime($fechaformat));
                $fechaformat = $r['fecha']->format("d/m/Y");
                $fechasalumno[] = $dia . ' ' .$fechaformat;
            }
            $alumnosgrupo[$key]['fechas'] = $fechasalumno;

        }
        $dbm->getConnection()->commit();
        return array("alumnos" => $alumnosgrupo, "fechas" => $arrayfechas);
    }


    /**
     * @Rest\Put("/api/ControlEscolar/AsistenciaDiaria/Estatus" , name="updateAsistenciaDiaria")
     */
    public function updateAsistenciaDiaria()
    {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $startDate =  $data['datos']["rangofechas"]["beginDate"]["year"] . "-" . $data['datos']["rangofechas"]["beginDate"]["month"] . "-" . $data['datos']["rangofechas"]["beginDate"]["day"];
            $endDate = $data['datos']["rangofechas"]["endDate"]["year"] . "-" . $data['datos']["rangofechas"]["endDate"]["month"] . "-" . $data['datos']["rangofechas"]["endDate"]["day"];
    

            //Actualizamos el estatus
            $dbm->getConnection()->beginTransaction();
            $Asistencia = $dbm->getRepositorioById('CeAsistenciapordia', 'asistenciapordiaid', $data["asistenciapordiaid"]);
            $nivelid = $Asistencia->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNivelid();
            $tiposasistencias =  $dbm->getRepositoriosById('CeTipoasistenciapornivel', 'nivelid', $nivelid);

            $tiposasistenciaactual = $Asistencia->getTipoasistenciaid();
            $tiposasistencia = $Asistencia->getTipoasistenciaid();


            foreach($tiposasistencias as $key => $tp){
                if($tiposasistenciaactual->getTipoasistenciaid() == $tp->getTipoasistenciaid()){
                    $next = $key+1;
                    $total = count($tiposasistencias) - 1;
                    if($next > $total || $next > 3){
                        $next = 0;
                    }
                    $tiposasistencia = $tiposasistencias[$next];
                }
            }


            $Asistencia->setTipoasistenciaid($dbm->getRepositorioById("CeTipoasistencia","tipoasistenciaid",$tiposasistencia->getTipoasistenciaid()));
            $Asistencia->setIgnorar(null);
            $dbm->saveRepositorio($Asistencia);
            $dbm->getConnection()->commit();

            $retardos =  $dbm->getRepositoriosModelo("CeAsistenciapordia", 
            ["d.asistenciapordiaid, d.fecha"], 
            [["alumnoporcicloid = " . $data['objeto']['alumnoporcicloid'] . "and d.ignorar is null and d.periodoevaluacionid = " . $data['datos']['periodoevaluacionid'] . " and d.grupoid = " . $data['datos']['grupoid'] . " and d.estatusinasistenciaid = 1 and d.tipoasistenciaid = 3"]], false, true, [
                ["entidad" => "CeAlumnoporciclo", "alias" => "ac", "left" => false, "on" => "ac.alumnoporcicloid = d.alumnoporcicloid"],
            ]);  
            foreach($retardos as $r) {
                $fechaformat = $r['fecha']->format("Y-m-d");
                $dia = $this->parseDia(strtotime($fechaformat));
                $fechaformat = $r['fecha']->format("d/m/Y");
                $fechasalumno[] = $dia . ' ' .$fechaformat;
            }
            $fechas = $fechasalumno;

            return new View(['tipoasistencia' =>  $tiposasistencia->getTipoasistenciaid(), "retardos" => $retardos, "fechas" => $fechas], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
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
     * @Rest\Put("/api/ControlEscolar/AsistenciaDiaria/ignorarSuspension" , name="ignorarSuspension")
     */
    public function ignorarSuspension()
    {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            //Actualizamos el estatus
            $dbm->getConnection()->beginTransaction();
            foreach($data['retardos'] as $r) {
                $retardo = $dbm->getRepositorioById("CeAsistenciapordia","asistenciapordiaid",$r);
                $retardo->setIgnorar(1);
                $dbm->saveRepositorio($retardo);
            }

            $dbm->getConnection()->commit();
            return new View("Se han actualizado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

        /**
     * @Rest\Put("/api/ControlEscolar/AsistenciaDiaria/setSuspension" , name="setSuspension")
     */
    public function setSuspension()
    {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            //Actualizamos el estatus
            $dbm->getConnection()->beginTransaction();

            $tipo = $dbm->getRepositorioById('CeTipoasistencia', 'tipoasistenciaid', 4);
            $estatus = $dbm->getRepositorioById('CeEstatusinasistencia', 'estatusinasistenciaid', 1);

            $filtros = array (
                'grupoid' => $data['form']['grupoid'],
                'alumnoporcicloid' => $data['datos']['alumnoporcicloid'],
                'fecha' => new \DateTime($data['fecha']),
                'periodoevaluacionid' => $data['form']['periodoevaluacionid']
            );
            $asis = $dbm->getOneByParametersRepositorio('CeAsistenciapordia', $filtros);
            if($asis) {
                $asis->setTipoasistenciaid($tipo);
                $asis->setEstatusinasistenciaid($estatus);
                $asis->setFecha(new \DateTime($data['fecha']));
                $asis->setHora(new \DateTime());
                $dbm->saveRepositorio($asis);
            } else {
                $asistencia = new CeAsistenciapordia();
                $asistencia->setAlumnoporcicloid($data['datos']['alumnoporcicloid'] ? 
                    $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $data['datos']['alumnoporcicloid']) : null);
                $asistencia->setGrupoid($data['form']['grupoid'] ? 
                    $dbm->getRepositorioById('CeGrupo', 'grupoid', $data['form']['grupoid']) : null);
                $asistencia->setPeriodoevaluacionid($data['form']['periodoevaluacionid'] ? 
                    $dbm->getRepositorioById('CePeriodoevaluacion', 'periodoevaluacionid', $data['form']['periodoevaluacionid']) : null);
                
                $asistencia->setFecha(new \Datetime($data['fecha']));
                $asistencia->setHora(new \Datetime());
                $asistencia->setTipoasistenciaid($tipo);
                $asistencia->setEstatusinasistenciaid($estatus);
                $dbm->saveRepositorio($asistencia);
            }

            foreach($data['datos']['retardos'] as $r) {
                $retardo = $dbm->getRepositorioById("CeAsistenciapordia","asistenciapordiaid",$r);
                $retardo->setIgnorar(1);
                $dbm->saveRepositorio($retardo);
            }

            $dbm->getConnection()->commit();
            return new View("Se han actualizado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * @Rest\Put("/api/ControlEscolar/AsistenciaDiaria/setSuspensionAlumnos" , name="setSuspensionAlumnos")
     */
    public function setSuspensionAlumnos()
    {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            //Actualizamos el estatus
            $dbm->getConnection()->beginTransaction();

            $tipo = $dbm->getRepositorioById('CeTipoasistencia', 'tipoasistenciaid', 4);
            $estatus = $dbm->getRepositorioById('CeEstatusinasistencia', 'estatusinasistenciaid', 1);

            foreach($data['alumnos'] as $alumno) {
                $filtros = array (
                    'grupoid' => $data['form']['grupoid'],
                    'alumnoporcicloid' => $alumno,
                    'fecha' => new \DateTime($data['fecha']),
                    'periodoevaluacionid' => $data['form']['periodoevaluacionid']
                );
                $asis = $dbm->getOneByParametersRepositorio('CeAsistenciapordia', $filtros);
                if($asis) {
                    $asis->setTipoasistenciaid($tipo);
                    $asis->setEstatusinasistenciaid($estatus);
                    $asis->setFecha(new \DateTime($data['fecha']));
                    $asis->setHora(new \DateTime());
                    $dbm->saveRepositorio($asis);
                } else {
                    $asistencia = new CeAsistenciapordia();
                    $asistencia->setAlumnoporcicloid($alumno ? 
                        $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno) : null);
                    $asistencia->setGrupoid($data['form']['grupoid'] ? 
                        $dbm->getRepositorioById('CeGrupo', 'grupoid', $data['form']['grupoid']) : null);
                    $asistencia->setPeriodoevaluacionid($data['form']['periodoevaluacionid'] ? 
                        $dbm->getRepositorioById('CePeriodoevaluacion', 'periodoevaluacionid', $data['form']['periodoevaluacionid']) : null);
                    
                    $asistencia->setFecha(new \Datetime($data['fecha']));
                    $asistencia->setHora(new \Datetime());
                    $asistencia->setTipoasistenciaid($tipo);
                    $asistencia->setEstatusinasistenciaid($estatus);
                    $dbm->saveRepositorio($asistencia);
                }
            }



            $dbm->getConnection()->commit();
            return new View("Se han actualizado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

        /**
	 * @Rest\Get("/api/ControlEscolar/AsistenciaDiaria/ReporteAsistenciaDiaria/" , name="ReporteAsistenciaDiaria")
	 */
    public function ReporteAsistenciaDiaria() {
        $datos=$_REQUEST;
        $filtros=array_filter($datos);

        $encabezado = $filtros['encabezado'];
        $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $arraytotals = [];
        $ciclo = $dbm->getRepositorioById("Ciclo", "cicloid", $filtros['cicloid']);
        $nivel = $dbm->getRepositorioById("Nivel", "nivelid", $filtros['nivelid']);
        $grado = $dbm->getRepositorioById("Grado", "gradoid", $filtros['gradoid']);
        $grupo = $dbm->getRepositorioById("CeGrupo", "grupoid", $filtros['grupoid']);

        

        $respuesta = $this->asistenciasDiarias($filtros, $dbm);
        $path = str_replace('app', '', $this->get('kernel')->getRootDir());
        $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";

        $arrestatus = [['title'=>'Total de asistencias','key'=> 'tas'],
        ['title'=>'Total de inasistencias','key'=> 'tis'],
        ['title'=>'Total de retardos','key'=> 'trs'],
        ['title'=>'Total de suspensiones','key'=> 'ts']];

        if($respuesta['error']) {
            return new View($respuesta['mensaje'], Response::HTTP_PARTIAL_CONTENT);
        }

        foreach($respuesta['alumnos'] as $f) {
            $asistenciaids=array_values(array_unique(array_column($f['asistencias'], 'asistenciapordiaid')));
            $asistencias = $dbm->GetAsistenciasDiariaDetail($asistenciaids)[0];

            foreach($arrestatus as $e) {
                $valor = $asistencias[$e['key']];
                $arraytotals[] = [
                    "x" => $f['alumno'],
                    "y" => $e['title'],
                    "val" => $valor
                ];
            }

            foreach($f['asistencias'] as $key=>$a) {
                $obj = array(
                    "x" => $f['alumno'],
                    "y" => $respuesta['fechas'][$key],
                    "val" => $path . $this->imagen($a['tipoasistenciaid'], $a['estatusinasistenciaid'])
                );
                $arraydatos[] = $obj;
            }
        }
        $report="ReporteAsistenciasDiaria";
        $filebase="$report-".(rand()%10000);
        $pdf=new LDPDF($this->container, $report, $filebase, ['driver'=>'json', 'data_file'=>$filebase, 'json_query'=>'""'], [], ['xlsx']);
        $data = array("prof" => $arraydatos, "nivel" => $nivel->getNombre(), "grado" => $grado->getGrado(), "estatus" => $arraytotals,
            "grupo" => $grupo->getNombre(), "ciclo" => $ciclo->getNombre());
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
}
