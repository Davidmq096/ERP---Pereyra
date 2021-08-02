<?php

namespace AppBundle\Controller\Reportes;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmReportes;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
use AppBundle\Rest\Api;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController;

/**
 * @author Mariano
 */
class CalificacionesController extends FOSRestController
{
	public static $AlumnosRel;

    /**
     * Retorna arreglo de filtros inicialesss
     * @Rest\Get("/api/Reportes/jasper", name="Jasper")
     */
    public function jasper()
    {
        try {
            $path = str_replace('app','',$this->get('kernel')->getRootDir());
            $jasper = new JasperPHP($this);

            $jasper->process(
                '"'.$path . 'src\\AppBundle\\Dominio\\Reporteador\\Plantillas\\hello_world.jrxml"',
                '"'.$path . 'src\\AppBundle\\Dominio\\Reporteador\\Plantillas\\hello_world"',
                array("pdf"),
                array("php_version" => "xxx")
            )->execute();

            $reporte =  "..\\src\\AppBundle\\Dominio\\Reporteador\\Plantillas\\hello_world.pdf";
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte) , 
                200, array(
                    'Content-Type' => 'application/pdf',
                    'Content-Length' => filesize($reporte))
            );
            return $response;
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de filtros iniciales
     * @Rest\Get("/api/Reportes/Calificaciones", name="indexReporteCalificaciones")
     */
    public function indexReporteCalificaciones()
    {
        try {
            $dbm = new DbmReportes($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
			$semestre = $dbm->getRepositoriosById('CeSemestre','activo',1);
			$tipoasistencia = $dbm->getRepositoriosById('CeTipoasistencia','activo',1);
			$estatusinasistencia = $dbm->getRepositoriosById('CeEstatusinasistencia','activo',1);
			$periodoeval = $dbm->getRepositoriosModelo("CePeriodoevaluacion", ["d.periodoevaluacionid, d.descripcion, IDENTITY(c.cicloid) as cicloid, GROUPCONCAT(DISTINCT IDENTITY(g.gradoid)) as gradoid"],
				[], false, false, [
				["entidad" => "CeConjuntoperiodoevaluacion", "alias" => "c", "left" => false, "on" => "c.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
				["entidad" => "CeGradoporconjuntoperiodoescolar", "alias" => "g", "left" => false, "on" => "g.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
			], 'd.periodoevaluacionid');

			return new View(array("ciclo" => $ciclo,
			"nivel" => $nivel,
			"grado"=>$grado,
			"grupo"=>$grupo, 
			"semestre"=>$semestre,
			"tipoasistencia" => $tipoasistencia,
			"estatusinasistencia" => $estatusinasistencia,
			"periodoevaluacion" => $periodoeval
		), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
	 * Retorna arreglo de calificaciomes de Alumno
	 * @Rest\Get("/api/Reportes/Calificaciones/", name="ReporteCalificaciones")
	 */
	public function ReporteCalificaciones(){
		//return new View(json_decode('',true),Response::HTTP_OK);
		try{
			$datos=$_REQUEST;
			$filtros=array_filter($datos);
			$filtros['gradooldid']=$filtros['gradoid'];
			$instituto = ENTORNO;
			$arrayalumnocalfinal = [];
			$em=$this->get("db_manager")->getEntityManager();
			$dbm=new DbmReportes($em);
			$dbmce=new DbmControlescolar($em);
			if($filtros['matricula']){
				$alumno = $dbmce->BuscarAlumnosA(['matricula' => trim($filtros['matricula']), 'cicloid' => $filtros['cicloid']])[0];
				if($alumno){
					$filtros['nivelid'] = $alumno['nivelid'];
					if(!$filtros['gradoid']) {
						$filtros['gradoid'] = $alumno['gradoid'];
					}
				}else {
					return new View("No se encontró ningun registro", Response::HTTP_PARTIAL_CONTENT);
				}
			}
			$calificaciones=$dbm->ConsultaCalificaciones($filtros);
			$reprobadosporgrupo=[];
			$inferioresporgrupo=[];
			$superioresporgrupo=[];
			$arrayAlu = [];
			$promedioxmateria = [];

			if(!$calificaciones){
				return new View("No se encontró ningun registro", Response::HTTP_PARTIAL_CONTENT);
			}

			$pme=$dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'profesorpormateriaplanestudiosid', $calificaciones[0]['profesorpormateriaplanestudiosid']);


			$materiasa=$dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $calificaciones[0]['materiaporplanestudioid']);

			$mats=[];

			$url=$dbm->getRepositorioById('Parametros', 'nombre', 'URLServicios');

			foreach($calificaciones as &$c){
				$c['foto']=$alumno['foto']=$url->getValor().'/api/Alumno/foto?alumnoid='.$c['alumnoid'];
				$find=false;
				foreach($mats as $m){
					if($m== $c['materiaporplanestudioid']){
						$find=true;
					}
				}
				if(!$find){
					$mats[]=$c['materiaporplanestudioid'];
				}
			}

			$roundFinal="";
			$roundMateria="";
			$roundCriterio="";
			$roundFunctions=null;
			$materiasused=[];
			$materias=[];
			foreach($mats as $m){
				$mm=$dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $m);
				if(!$roundFunctions){
					$roundFunctions=$dbmce->getRoundFunctionNameByMateriaplanestudio($m);
					$roundFinal=$roundFunctions['final'];
					$roundMateria=$roundFunctions['materia'];
					$roundCriterio=$roundFunctions['criterio'];
				}
				if($mm){
					$kmateria=$mm->getMateriaid()->getMateriaid();
					if(!isset($materiasused[$kmateria])){
						$materiasused[$kmateria]=true;
						$materias[]=$mm;
					}
				}
			}
			usort($materias, "AppBundle\Controller\Reportes\CalificacionesController::fnMateriaOrden");

			$mata=$materiasa;

			$planestudio=$dbm->getOneByParametersRepositorio("CePlanestudios", ["planestudioid"=>$mata->getPlanestudioid()]);
			if(!$planestudio){
				return new View("No existe un plan de estudios ", Response::HTTP_PARTIAL_CONTENT);
			}
			if(isset($filtros["gradoid"])){

				$puntopase=$planestudio->getPuntopase();
				$calminima=$planestudio->getCalificacionminima();
				$configuracion=["puntopase"=>$puntopase];
			}
			$periodos=[];
			$periodosr=[];
			foreach($calificaciones AS $icalificacion){
				$kperiodoe=$icalificacion['periodoevaluacionid'];
				if($kperiodoe && !isset($periodosr[$kperiodoe])){
					$periodoename=$icalificacion['descripcioncorta'];
					$periodosr[$kperiodoe]=true;
					$periodos[]=[$kperiodoe,$periodoename];
				}
			}
			$periodosids=array_values(array_unique(array_column($calificaciones, 'periodoevaluacionid')));
			$alumnos=array_values(array_unique(array_column($calificaciones, 'alumnoid')));
			$gradosdeivid=array_values(array_unique(array_column($calificaciones, 'gradoid')));
			$reprobados=array_values(array_unique(array_column($calificaciones, 'reprobados')));
			$reprobados = array_filter($reprobados, function ($value) {
                return $value !== '';
			});


			$conn=$dbm->getConnection();
			if(isset($filtros["grupoid"])){
				$grupo="and acg.grupoid=".$filtros["grupoid"];
			}
			if(isset($filtros["matricula"])){
				$matricula="and a.matricula=".$filtros["matricula"];
			}
			if($filtros["soloreprobados"] == "1"){
				$students = implode(',',$reprobados);
				$reprobadostotal="and a.alumnoid IN (".$students .")";
			}
			if(isset($filtros["gradoid"])){
				$stmt=$conn->prepare(
								"select a.alumnoid,concat_ws(' ',a.matricula, ' - ', a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,gru.nombre as grupo
                    from ce_alumno a
                    inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
                    inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
                    inner join ce_grupo gru on gru.grupoid=acg.grupoid
                    where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"]." and ac.gradoid=".$filtros["gradoid"]." $grupo $matricula $reprobadostotal
                    order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre"
				);
				$stmt->execute();
				$alumnosgrupo=$stmt->fetchAll();
			}

			$materiassep=0;
			$encabezadorel=[];
			foreach($materias as $imateria){
				$kmateria=$imateria->getMateriaid()->getMateriaid();
				$omateria=$imateria->getMateriaid();
				$esCurricular=$imateria->getEscurricular();
				$imateriadata=array(
						"materiaid"=>$kmateria,
						"materia"=>$omateria->getNombre(),
						"sep"=>$esCurricular,
						"periodos"=>$periodos,
						"recuperaciones"=>[],
						"recrel"=>[]
					);
				$encabezado[]=&$imateriadata;
				$encabezadorel[$kmateria]=&$imateriadata;
				if($esCurricular){ $materiassep++; }
				unset($imateriadata);
			}

			$respuesta=[];
			$repmat = [];
			foreach($calificaciones as $calificacion){
				$kalumno=$calificacion["alumnoid"];
				$kalumnociclo=$calificacion["alumnoporcicloid"];
				$kgrupo=$calificacion["grupoid"];
				$kmateria=$calificacion["materiaid"];
				$kperiodoevaluacion=$calificacion["periodoevaluacionid"];
				$kcalfinal=$calificacion['calificacionfinal'];
				$kprofesormpe=$calificacion["profesorpormateriaplanestudiosid"];
				$alumnosgrado[$calificacion["gradoid"]]=$alumnosgrado[$calificacion["gradoid"]] + 1;
				$gruponombre=$calificacion["gruponombre"];
				$icalificacionpinput=false;
				$icalificacionperiodo=null;
				$icalificacionp=null;
				$arraycalis = [];
				$promGeneral = null;
				$porcentajeperiodo = null;
				if(isset($calificacion["calificacionperiodo"])){
					$icalificacionpinput=true;
					$icalificacionp=$calificacion["calificacionperiodo"];
				}
				$recuperaciones=$dbm->getRepositoriosModelo("CeRecuperacionperiodo",[
						"d.recuperacionperiodoid",
						"d.intento",
						"d.calificacion"
					],[
						"profesorpormateriaplanestudioid"=>$kprofesormpe,
						"periodoevaluacionid"=>$kperiodoevaluacion,
						"alumnoporcicloid"=>$kalumnociclo
					],["intento"=>"DESC"]);
				if(!empty($recuperaciones)){
					$icalificacionp=$recuperaciones[0]["calificacion"];
				}

				$promediomateria[$kmateria]=array("materia"=>$calificacion["materianombre"], "promedio"=>$promediomateria[$kmateria]["promedio"] + $icalificacionp);
				$promediogrupo[$kgrupo]=array(
						"grupo"=>$gruponombre,
						"promediosep"=>$promediogrupo[$kgrupo]["promediosep"] + ($calificacion["escurricular"] ? $icalificacionp : 0),
						"promedioidec"=>$promediogrupo[$kgrupo]["promedioidec"] + $icalificacionp, "alumnos"=>$promediogrupo[$kgrupo]["alumnos"] + 1
				);


				$grupomateria="$kgrupo-$kmateria";
				$gradomateria=$calificacion["gradoid"]."-$kmateria";
				$periodomateria="$kperiodoevaluacion-$kmateria";
				$periodogrupo="$kperiodoevaluacion-$kgrupo";
				$periodogrado="$kperiodoevaluacion-".$calificacion["gradoid"];
				$reprobadosgrupo=$promediomateriagrupo[$grupomateria]["reprobados"];
				$reprobadosxmat = $promediomateriagrado[$gradomateria]['reprobadospormateria'];
				if($icalificacionpinput && $icalificacionp < (ENTORNO == 1 ? $puntopase : $calminima)){
					$reprobadosgrupo=$reprobadosgrupo + 1;
					$reprobadosxmat=$reprobadosxmat + 1;
					$reprobadosporperiodomateria[$periodomateria]=$reprobadosporperiodomateria[$periodomateria] + 1;
				}
				$inferiores=null;
				$inferioresgrupo=$promediomateriagrupo[$grupomateria]["inferiores"];
				if($icalificacionpinput && $icalificacionp < 8){
					$inferioresgrupo=$inferioresgrupo + 1;
					$inferioresporperiodomateria[$periodomateria]=$inferioresporperiodomateria[$periodomateria] + 1;
				}
				$superiores=null;
				$superioresgrupo=$promediomateriagrupo[$grupomateria]["superiores"];
				if($icalificacionpinput && $icalificacionp > 9){
					$superioresgrupo=$superioresgrupo + 1;
					$superioresporperiodomateria[$periodomateria]=$superioresporperiodomateria[$periodomateria] + 1;
				}

				$menora5=null;
				$m5=false;
				if($icalificacionpinput && $icalificacionp<= 5){
					$menora5=$menora5 + 1;
					$m5=true;
					$promedio5periodomateria[$periodomateria]=$promedio5periodomateria[$periodomateria] + 1;
				}
				$entre6=null;
				$m6=false;
				if($icalificacionpinput && $icalificacionp>= 6 && $icalificacionp<= 6.9){
					$entre6=$entre6 + 1;
					$m6=true;
					$promedio6periodomateria[$periodomateria]=$promedio6periodomateria[$periodomateria] + 1;
				}
				$entre7=null;
				$m7=false;
				if($icalificacionpinput && $icalificacionp>= 7 && $icalificacionp<= 7.9){
					$entre7=$entre7 + 1;
					$m7=true;
					$promedio7periodomateria[$periodomateria]=$promedio7periodomateria[$periodomateria] + 1;
				}
				$entre8=null;
				$m8=false;
				if($icalificacionpinput && $icalificacionp>= 8 && $icalificacionp<= 8.9){
					$entre8=$entre8 + 1;
					$m8=true;
					$promedio8periodomateria[$periodomateria]=$promedio8periodomateria[$periodomateria] + 1;
				}
				$entre9=null;
				$m9=false;
				if($icalificacionpinput && $icalificacionp>= 9 && $icalificacionp<= 10){
					$entre9=$entre9 + 1;
					$m9=true;
					$promedio9periodomateria[$periodomateria]=$promedio9periodomateria[$periodomateria] + 1;
				}

				$promedioperiodogrado[$periodogrado]=array(
						"periodo"=>$calificacion["descripcion"],
						"promedio"=>$promedioperiodo[$kperiodoevaluacion]["promedio"] + $icalificacionp,
						"alumnos"=>$promedioperiodo[$kperiodoevaluacion]["alumnos"] + 1,
						"promedio5"=>$m5 ? $promedioperiodogrado[$periodogrado]["promedio5"] + 1 : $promedioperiodogrado[$periodogrado]["promedio5"],
						"promedio6"=>$m6 ? $promedioperiodogrado[$periodogrado]["promedio6"] + 1 : $promedioperiodogrado[$periodogrado]["promedio6"],
						"promedio7"=>$m7 ? $promedioperiodogrado[$periodogrado]["promedio7"] + 1 : $promedioperiodogrado[$periodogrado]["promedio7"],
						"promedio8"=>$m8 ? $promedioperiodogrado[$periodogrado]["promedio8"] + 1 : $promedioperiodogrado[$periodogrado]["promedio8"],
						"promedio9"=>$m9 ? $promedioperiodogrado[$periodogrado]["promedio9"] + 1 : $promedioperiodogrado[$periodogrado]["promedio9"]
				);


				$promedioperiodo[$kperiodoevaluacion]=array(
						"periodo"=>$calificacion["descripcion"],
						"promedio"=>$promedioperiodo[$kperiodoevaluacion]["promedio"] + $icalificacionp,
						"alumnos"=>$promedioperiodo[$kperiodoevaluacion]["alumnos"] + 1,
						"promedio5"=>$m5 ? $promedioperiodo[$kperiodoevaluacion]["promedio5"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio5"],
						"promedio6"=>$m6 ? $promedioperiodo[$kperiodoevaluacion]["promedio6"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio6"],
						"promedio7"=>$m7 ? $promedioperiodo[$kperiodoevaluacion]["promedio7"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio7"],
						"promedio8"=>$m8 ? $promedioperiodo[$kperiodoevaluacion]["promedio8"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio8"],
						"promedio9"=>$m9 ? $promedioperiodo[$kperiodoevaluacion]["promedio9"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio9"]
				);

				if(!$arrayAlu[$calificacion["gradoid"]]) {
						if(isset($filtros["grupoid"])){
							$grupo="and acg.grupoid=".$filtros["grupoid"];
						}
						if($filtros["soloreprobados"] == "1"){
							$students = implode(',',$reprobados);
							$reprobadostotal="and a.alumnoid IN (".$students .")";
						}
						$stmt=$conn->prepare(
							"select a.alumnoid,concat_ws(' ',a.matricula, ' - ', a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,gru.nombre as grupo
								from ce_alumno a
								inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
								inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
								inner join ce_grupo gru on gru.grupoid=acg.grupoid
								where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"]." and ac.gradoid=".$calificacion["gradoid"]."  $grupo $reprobadostotal
							order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre"
						);
						$stmt->execute();
						$totalgrado=$stmt->fetchAll();
						$arrayAlu[$calificacion["gradoid"]] = count($totalgrado);
				}

				$promediogrado[$calificacion["gradoid"]]=array(
						"grado"=>$calificacion["gradonombre"],
						"gradoid"=>$calificacion["gradoid"],
						"promedio"=>$promediogrado[$calificacion["gradoid"]]["promedio"] + $icalificacionp,
						"alumnosxgrado"=>$arrayAlu[$calificacion["gradoid"]],
						"alumnos"=>$promediogrado[$calificacion["gradoid"]]["alumnos"] + 1, 
						"promedio5"=>$m5 ? $promediogrado[$kperiodoevaluacion]["promedio5"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio5"],
						"promedio6"=>$m6 ? $promediogrado[$kperiodoevaluacion]["promedio6"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio6"],
						"promedio7"=>$m7 ? $promediogrado[$kperiodoevaluacion]["promedio7"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio7"],
						"promedio8"=>$m8 ? $promediogrado[$kperiodoevaluacion]["promedio8"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio8"],
						"promedio9"=>$m9 ? $promediogrado[$kperiodoevaluacion]["promedio9"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio9"]
				);

				$periodomateriagrupo="$kperiodoevaluacion-$kmateria-$kgrupo";

				$promediopmg[$periodomateriagrupo]=array(
						"promedio"=>$promediopmg[$periodomateriagrupo]["promedio"] + $icalificacionp,
						"alumnos"=>$promediopmg[$periodomateriagrupo]["alumnos"] + 1,
						"promedio5"=>$m5 ? $promediopmg[$periodomateriagrupo]["promedio5"] + 1 : $promediopmg[$periodomateriagrupo]["promedio5"],
						"promedio6"=>$m6 ? $promediopmg[$periodomateriagrupo]["promedio6"] + 1 : $promediopmg[$periodomateriagrupo]["promedio6"],
						"promedio7"=>$m7 ? $promediopmg[$periodomateriagrupo]["promedio7"] + 1 : $promediopmg[$periodomateriagrupo]["promedio7"],
						"promedio8"=>$m8 ? $promediopmg[$periodomateriagrupo]["promedio8"] + 1 : $promediopmg[$periodomateriagrupo]["promedio8"],
						"promedio9"=>$m9 ? $promediopmg[$periodomateriagrupo]["promedio9"] + 1 : $promediopmg[$periodomateriagrupo]["promedio9"]
				);

				$periodomateriagrado="$kperiodoevaluacion-$kmateria-".$calificacion["gradoid"];

				$promediopmgrado[$periodomateriagrado]=array(
						"promedio"=>$promediopmgrado[$periodomateriagrado]["promedio"] + $icalificacionp,
						"alumnos"=>$promediopmgrado[$periodomateriagrado]["alumnos"] + 1,
						"promedio5"=>$m5 ? $promediopmgrado[$periodomateriagrado]["promedio5"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio5"],
						"promedio6"=>$m6 ? $promediopmgrado[$periodomateriagrado]["promedio6"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio6"],
						"promedio7"=>$m7 ? $promediopmgrado[$periodomateriagrado]["promedio7"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio7"],
						"promedio8"=>$m8 ? $promediopmgrado[$periodomateriagrado]["promedio8"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio8"],
						"promedio9"=>$m9 ? $promediopmgrado[$periodomateriagrado]["promedio9"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio9"]
				);

				$keyalumno=array_search($kalumno, array_column($respuesta, 'alumnoid'));
				if($keyalumno===false || $keyalumno===null){
					$filtrosalumno=$filtros;
					$filtrosalumno["alumnoid"]=$kalumno;
					$calificacionesalumno=$dbm->ConsultaCalificaciones($filtrosalumno);
					$sumaSEP=null;
					$sumaInsFinal=null;
					$sumaSEPFinal=null;
					$sumaInstituto=null;
					$reprobadas=null;
					$inferiores=null;
					$superiores=null;
					$promedios=[];//null;
					$promediosperiodo=null;
					$promediosmateria=null;
					$isLux=(ENTORNO==1);
					$arraycalfinalAlumno=[];
					
					$calsSEP=0;
					$calsSEPFinal=0;
					$calsInsFinal=0;
					$calsInstituto=0;
					foreach($calificacionesalumno AS $calificacionalumno){
						$ikgrupo=$calificacionalumno['grupoid'];
						$iknivelid=$calificacionalumno['nivelid'];
						$ikmateria=$calificacionalumno['materiaid'];
						$ikperiodo=$calificacionalumno['periodoevaluacionid'];
						$ikcalificacionalumno=$calificacionalumno['materiaporplanestudioid'];
						$iporcentajecf=$calificacionalumno['porcentajecf'];
						$icurricular=$calificacionalumno["escurricular"];
						$icalificacionperiodo=$calificacionalumno["calificacionperiodo"];
						$iperiodoname=$calificacionalumno["descripcioncorta"];
						$imaterianame=$calificacionalumno["materianombre"];
						$iponderacionid=$calificacionalumno["ponderacionid"];
						$itipocalificacion=$calificacionalumno['tipocalificacionid'];
						$igruponame=$calificacionalumno["gruponombre"];

						if($calificacionalumno['calificacionfinalperiodoporalumnoid']) {
							if(!in_array($calificacionalumno['calificacionfinalperiodoporalumnoid'], $arraycalfinalAlumno)) {
								$arraycalfinalAlumno[] = $calificacionalumno['calificacionfinalperiodoporalumnoid'];

								if($icurricular){
									if(!empty($calificacionalumno['calificacionfinal'])) {
										$sumaSEPFinal++;
										$calsSEPFinal+= floatval($calificacionalumno['calificacionfinal']);
									}
								}

								if($icurricular || !$isLux){
									if(!empty($calificacionalumno['calificacionfinal'])) {
										$sumaInsFinal++;
										$calsInsFinal+= floatval($calificacionalumno['calificacionfinal']);
									}

								}
							}
						}

						if($itipocalificacion!=1){
							if($icurricular){
								$calsSEP++;
								$sumaSEP+=$icalificacionperiodo;
								$promediosperiodo[$iperiodoname]["promediosep"]+=$icalificacionperiodo;
								$promediosperiodo[$iperiodoname]["numeromateriasep"] += 1;	
							}
							//if($icurricular || !$isLux){
							if($icurricular || !$isLux){
								$calsInstituto++;
								$sumaInstituto+=$icalificacionperiodo;
								$promediosperiodo[$iperiodoname]["promedio"]+=$icalificacionperiodo;
								$promediosperiodo[$iperiodoname]["numeromateria"] += 1;	
							}else if(!$icurricular){
								$calsInstituto++;
								$sumaInstituto+=$icalificacionperiodo;
								$promediosperiodo[$iperiodoname]["promedio"]+=$icalificacionperiodo;
								$promediosperiodo[$iperiodoname]["numeromateria"] += 1;	
							}
							$promediosperiodo[$iperiodoname]["periodoid"]=$ikperiodo;
							$promediosperiodo[$iperiodoname]["porcentaje"]=(int)$iporcentajecf;
						}



						if(!isset($filtros["gradoid"])){
							//$planestudio=$dbm->getOneByParametersRepositorio("CePlanestudios",["cicloinicialid"=>$filtros["cicloid"],"gradoid"=>$calificacionalumno["gradoid"],"vigente"=>1]);
							$puntopase=$planestudio->getPuntopase();
						}
						if(isset($calificacionalumno["calificacionperiodo"])){
							if($icalificacionperiodo < $puntopase){
								$reprobadas++;
								if(!$repmat[$imaterianame]){
									$repmat[$imaterianame] = [];
								}

								if(!$repmat[$imaterianame][$iperiodoname]){
									$repmat[$imaterianame][$iperiodoname] = ["total" => 0];
								}

								$repmat[$imaterianame][$iperiodoname]["total"] = $repmat[$imaterianame][$iperiodoname]["total"] + 1;
								$promediosperiodo[$iperiodoname]["reprobadas"] += 1;
								if(!isset($reprobadosporgrupo[$ikgrupo])){
									$reprobadosporgrupo[$ikgrupo]=["grupo"=>$igruponame, "total"=>0];
									$reprobadospormateria[$ikmateria]=["materia"=>$imaterianame, "total"=>0,"periodo" => $ikperiodo];
									
								}
								$reprobadosporgrupo[$ikgrupo]["total"] ++;
								$reprobadospormateria[$ikmateria]["total"] ++;
							}
							if($icalificacionperiodo < 8){
								$inferiores++;
								if(!isset($inferioresporgrupo[$ikgrupo])){
									$inferioresporgrupo[$ikgrupo]=["grupo"=>$igruponame, "total"=>0];
									$inferiorespormateria[$ikmateria]=["materia"=>$imaterianame, "total"=>0];
								}
								$inferioresporgrupo[$ikgrupo]["total"] ++;
								$inferiorespormateria[$ikmateria]["total"] ++;
							}
							if($icalificacionperiodo > 9){
								$superiores++;
								if(!isset($superioresporgrupo[$ikgrupo])){
									$superioresporgrupo[$ikgrupo]=["grupo"=>$igruponame, "total"=>0];
									$superiorespormateria[$ikmateria]=["materia"=>$imaterianame, "total"=>0];
								}
								$superioresporgrupo[$ikgrupo]["total"] ++;
								$superiorespormateria[$ikmateria]["total"] ++;
							}
						}
					}
					$promediable=true;
					$promedioGeneralRaw=0;
					foreach($promediosperiodo as $promediokey=> $promedio){
						$iporcentaje=$promedio["porcentaje"];
						$promediop=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promedio"] / $promedio["numeromateria"]));
						$promedioseps=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promediosep"] / $promedio["numeromateriasep"]));
						$promedioGeneralRaw+=$promediop;
						if($promediop==0){
							$promediop=null;
						}
						if($iporcentaje>0){
							$promediable=false;
						}
						$promedios[]=array("periodo"=>$promediokey, "promedio"=>$promediop, "porcentaje"=>$iporcentaje, "promediosep" => $promedioseps, "reprobadas" => $promedio["reprobadas"]);
					}
					if($promediable){
						$promedioGeneral=($promedioGeneralRaw / count($promediosperiodo));
					}else{
						$promedioGeneral=0;
						foreach($promedios AS $ipromedioraw){
							$ipromedio=$ipromedioraw['promedio'];
							$iporcentaje=$ipromedioraw['porcentaje'];
							if(!$ipromedio){ $ipromedio=0; }
							$promedioGeneral+=($ipromedio*$iporcentaje/100);
						}
					}
					$promFinstituto = $calsInsFinal / $sumaInsFinal;
					$promFSEP = $calsSEPFinal / $sumaSEPFinal;
					$promedioSEP=$dbmce->getRoundedValueByFunctionName($roundFinal, $promFSEP);
					$promedioGeneral=$dbmce->getRoundedValueByFunctionName($roundFinal, $promFinstituto);
					$promedioInstituto=$promedioGeneral;
					//$promedioInstituto=$dbmce->getRoundedValueByFunctionName($roundFinal, ($sumaInstituto / $calsInstituto));
					if($promedioSEP==0){
						$promedioSEP=null;
					}
					if($promedioGeneral==0){
						$promedioGeneral=null;
					}
					if($promedioInstituto==0){
						$promedioInstituto=null;
					}
					if($reprobadas>0){
						$reprobadasacumuladasporgrado[$calificacion["gradoid"]][$reprobadas." materias"]=array("grado"=>$calificacion["gradonombre"], "total"=>$reprobadasacumuladasporgrado[$calificacion["gradoid"]][$reprobadas." materias"]["total"] + 1);
					}
					$respuesta[]=[
							"alumnoid"=>$kalumno,
							"foto"=>$url->getValor() . "/api/Alumno/foto?alumnoid=$kalumno",
							"nombre"=>$calificacion["nombre"],
							"nombrecompleto"=>$calificacion["nombrecompleto"],
							"grupoid"=>$kgrupo,
							"gruponombre"=>$gruponombre,
							"numerolista"=>$calificacion["numerolista"],
							"matricula"=>$calificacion["matricula"],
							"periodos"=>[],
							"IDEC"=>$promedioInstituto,
							"SEP"=>$promedioSEP,
							"TEST"=>$calsInsFinal,
							"reprobadas"=>$reprobadas,
							"promedios"=>$promedios,
							"promediogeneral"=>$promedioGeneral,
							"promprorrateado"=>"",
							"promensigblo"=>""
					];
					$keyalumno=sizeof($respuesta)-1;
				}

				$periodokey=array_search($kperiodoevaluacion, array_column($respuesta[$keyalumno]["periodos"], 'periodoevaluacionid'));
				if($periodokey===null || $periodokey===false){
					$respuesta[$keyalumno]["periodos"][]=[
							"periodoevaluacionid"=>$kperiodoevaluacion,
							"descripcion"=>$calificacion["descripcion"],
							"descripcioncorta"=>$calificacion["descripcioncorta"],
							"fechainicio"=>$calificacion["fechainicio"],
							"fechafin"=>$calificacion["fechafin"],
							"captura"=>$this->getCapturaAlumnoPeriodo($dbmce, $kalumnociclo, $kperiodoevaluacion),
							"calificaciones"=>[]
						];
					$periodokey=sizeof($respuesta[$keyalumno]["periodos"])-1;
				}

				$materiakey=array_search($kmateria, array_column($respuesta[$keyalumno]["periodos"][$periodokey]["calificaciones"], 'materiaid'));
				if($materiakey===null || $materiakey===false){
					if($calificacion['profesorpormateriaplanestudiosid'] == 3000) {
						$rt = 9;
					}
					$desglose=$dbm->getCalificacionDesgloseByCalificacionperiodoalumno($calificacion["id"]);
					if(!$desglose){
						$desglose=$dbm->getCalificacionDesgloseByPeriodoevaluacionProfesormpe($kperiodoevaluacion,$kprofesormpe);
					}
					if($recuperaciones && !$encabezadorel[$kmateria]["recrel"][$kperiodoevaluacion]){
						$encabezadorel[$kmateria]["recrel"][$kperiodoevaluacion]=true;
						$encabezadorel[$kmateria]["recuperaciones"][]=[$kperiodoevaluacion,$calificacion["descripcioncorta"]." (R)"];
					}

					list($promediable,$periodosa)=$dbmce->getBIPeriodoEvaluacionByCicloGrado($filtros['cicloid'], $filtros['gradoid']);
					$lastp = end($periodosa);
					$islast = $this->inarray($periodosa, "periodoevaluacionid", $lastp['id']);

					//$evalTrigger=($iknivelid=='4');
					$lastRoundFunctions=$dbmce->getRoundFunctionNameByMateriaplanestudio($ikcalificacionalumno);
					$rdfnMateria=$lastRoundFunctions['materia'];

					if($filtros['periodoevaluacionid']) {
						$arrayperiodos = $filtros['periodoevaluacionid'];
						$islast = false;
					} else {
						$arrayperiodos = $periodosids;

					}

					if((count($arrayperiodos) !== count($periodosa)) && !$islast) {
						foreach($arrayperiodos as $p) {
							$filtrosalucali = array("materiaid" => $kmateria, "periodoevaluacionid" => $p, "alumnoid" => $kalumno);
							if(!$promediable) {
								$per = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $p);
								$porcentajeperiodo = $per->getPorcentajecalificacionfinal();
							}

							$keys = $dbm->ConsultaCalificaciones($filtrosalucali)[0];
							$arraycalis[] = [floatval($keys['calificacionperiodo']), false, $porcentajeperiodo];
						}
						$cal = [$arraycalis, false];
						$promGeneral=CapturaCalificacionReporteController::getPromedioRedondeado($dbmce, $rdfnMateria, $promediable, $cal, $evalTrigger);
					}

					
					$promGeneral = $promGeneral <= $calminima ? $calificacion["calificacionfinal"] : $promGeneral;
					$calificacion['calificacionfinal'] = $promGeneral ? $promGeneral : $calificacion["calificacionfinal"];

					$respuesta[$keyalumno]["periodos"][$periodokey]["calificaciones"][]=[
							"id"=>$calificacion["id"],
							"materiaid"=>$kmateria,
							"materianombre"=>$calificacion["materianombre"],
							"materiaclave"=>$calificacion["materiaclave"],
							"nombrecorto"=>$calificacion["nombrecorto"],
							"ponderacionopcion"=>$calificacion["opcion"],
							"observacion"=>$calificacion["observacion"],
							"desglose"=>$desglose,
							"recuperaciones"=>$recuperaciones,
							"ponderacionparacapturaopciones" => $calificacion['ponderacionparacapturaopciones'],
							"calificacionperiodo"=>$calificacion['ponderacionparacapturaopciones'] ? $calificacion["calificacionperiodo"] : '',
							"calificacionfinal"=> $calificacion['ponderacionparacapturaopciones'] ? $calificacion["calificacionfinal"] : ''
					];
				}

				$conteocalfinal = 0;
				if(!in_array($calificacion['alumnoid'] . '-' . $calificacion['gradoid']. '-'.$kmateria, $arrayalumnocalfinal)) {
					$conteocalfinal = $calificacion['calificacionfinal'];
					array_push($arrayalumnocalfinal, $calificacion['alumnoid'] . '-' . $calificacion['gradoid']. '-'.$kmateria);
				}

				$promediomateriagrupo[$grupomateria]=array("grupo"=>$gruponombre, "materia"=>$calificacion["materianombre"], "promedio"=>$promediomateriagrupo[$grupomateria]["promedio"] + $icalificacionp, "alumnos"=>$promediomateriagrupo[$grupomateria]["alumnos"] + 1, "reprobados"=>$reprobadosgrupo, "inferiores"=>$inferioresgrupo, "superiores"=>$superioresgrupo, "promedio5"=>$menora5, "promedio6"=>$entre6, "promedio7"=>$entre7, "promedio8"=>$entre8, "promedio9"=>$entre9);
				$promediomateriagrado[$gradomateria]=array("gradoid"=>$calificacion["gradoid"], "grado"=>$calificacion["gradonombre"], "materia"=>$calificacion["materianombre"], "promedio"=>$promediomateriagrado[$gradomateria]["promedio"] + $icalificacionp, "promediofinal"=>$promediomateriagrado[$gradomateria]["promediofinal"] + $conteocalfinal, "alumnos"=>$promediomateriagrado[$gradomateria]["alumnos"] + 1, "reprobados"=>$reprobadosgrupo, "reprobadospormateria"=>$reprobadosxmat, "inferiores"=>$inferioresgrupo, "superiores"=>$superioresgrupo);
				$promediomateriaperiodo[$periodomateria]=array("periodoevaluacionid"=>$kperiodoevaluacion, "periodo"=>$calificacion["descripcion"], "materia"=>$calificacion["materianombre"], "promedio"=>$promediomateriaperiodo[$periodomateria]["promedio"] + $icalificacionp, "promediofinal"=>$promediomateriaperiodo[$periodomateria]["promediofinal"] + $calificacion["calificacionfinal"], "alumnos"=>$promediomateriaperiodo[$periodomateria]["alumnos"] + 1);
				$promediogrupoperiodo[$periodogrupo]=array("periodoevaluacionid"=>$kperiodoevaluacion, "periodo"=>$calificacion["descripcion"], "grupo"=>$gruponombre, "promedio"=>$promediogrupoperiodo[$periodogrupo]["promedio"] + $icalificacionp, "promediofinal"=>$promediogrupoperiodo[$periodogrupo]["promediofinal"] + $calificacion["calificacionfinal"], "alumnos"=>$promediogrupoperiodo[$periodogrupo]["alumnos"] + 1);
				//$promediogradoperiodo[$periodogrado]=array("periodoevaluacionid"=>$kperiodoevaluacion,"periodo"=>$calificacion["descripcion"],"grado"=>$calificacion["gradonombre"],"promedio"=>$promediogradoperiodo[$periodogrado]["promedio"]+$icalificacionp,"promediofinal"=>$promediogradoperiodo[$periodogrado]["promediofinal"]+$calificacion["calificacionfinal"],"alumnos"=>$promediogradoperiodo[$periodogrado]["alumnos"]+1);

			}
			$alumnokey=null;
			foreach($alumnosgrupo as &$alumno){
				$alumnokey=array_search($alumno["alumnoid"], array_column($respuesta, 'alumnoid'));
				if($alumnokey=== false){
					
				}else{
					$alumno["foto"]=$url->getValor() . '/api/Alumno/foto?alumnoid=' . $alumno['alumnoid'];
					$alumno["calificaciones"]=$respuesta[$alumnokey];
				}
			}
			$grupos=$dbm->getByParametersRepositorios("CeGrupo", ["cicloid"=>$filtros["cicloid"], "gradoid"=>$filtros["gradoid"], "tipogrupoid"=>1]);
			$grados=$dbm->getByParametersRepositorios("Grado", ["nivelid"=>$filtros["nivelid"]]);
			foreach($promediomateria as $key=> $promedio){
				$promediom=number_format(($promedio["promedio"] / count($alumnos) / count($periodos)), 2);
				if($promediom== 0){
					$promediom=null;
				}
				$promediomateria[$key]=array("materia"=>$promedio["materia"], "promedio"=>$promediom);
				$grupomaterias=null;
				foreach($grupos as $grupo){
					$promediomg=number_format($promediomateriagrupo[$grupo->getGrupoid()."-".$key]["promedio"] / $promediomateriagrupo[$grupo->getGrupoid()."-".$key]["alumnos"], 2);
					if($promediomg== 0){
						$promediomg=null;
					}
					$grupomaterias[]=array("grupo"=>$grupo->getNombre(), "promedio"=>$promediomg);
				}
				$promediomateria[$key]=array("materia"=>$promedio["materia"], "promedio"=>$promediom, "grupos"=>$grupomaterias);
			}
			$promediomateria=array_values($promediomateria);
			foreach($promediogrupo as $key=> $promedio){
				$materiasgrupo=null;
				foreach($materias as $materia){
					$promediomg=number_format($promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio"] / $promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["alumnos"], 2);
					if($promediomg== 0){
						$promediomg=null;
					}
					$materiasgrupo[]=array(
							"materia"=>$materia->getMateriaid()->getNombre(),
							"promedio"=>$promediomg,
							"reprobados"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["reprobados"],
							"inferiores"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["inferiores"],
							"superiores"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["superiores"],
							"promedio5"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio5"],
							"promedio6"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio6"],
							"promedio7"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio7"],
							"promedio8"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio8"],
							"promedio9"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio9"],
					);
				}

				$promediogsep=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promediosep"] / $promedio["alumnos"]));
				$promediogidec=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promedioidec"] / $promedio["alumnos"]));
				if($promediogsep== 0){
					$promediogsep=null;
				}
				if($promediogidec== 0){
					$promediogidec=null;
				}
				$promediogrupo[$key]=array("grupo"=>$promedio["grupo"], "alumnos"=>$promedio["alumnos"], "promediosep"=>$promediogsep, "promedioidec"=>$promediogidec, "materias"=>$materiasgrupo);
			}
			$promediogrupo=array_values($promediogrupo);

			foreach($promediogrado as $key=> $promedio){
				$promediog=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promedio"] / $promedio["alumnosxgrado"]));
				if($promediog== 0){
					$promediog=null;
				}
				$pe=$dbmce->getOneByParametersRepositorio("CePlanestudios", ["gradoid"=> $promedio['gradoid'], "vigente"=> 1]);
				//$pe=$dbm->getOneByParametersRepositorio("CePlanestudios",["cicloinicialid"=>$filtros["cicloid"],"gradoid"=>$key,"vigente"=>1]);
				$mat=$dbm->getRepositoriosById("CeMateriaporplanestudios", "planestudioid", $pe->getPlanestudioid());
				$gradomaterias=null;
				foreach($mat as $m){
					$promediogm=number_format($promediomateriagrado[$key."-".$m->getMateriaid()->getMateriaid()]["promedio"] /  $promedio["alumnosxgrado"], 2);
					if($promediogm== 0){
						$promediogm=null;
					}
					$gradomaterias[]=array("materia"=>$m->getMateriaid()->getNombre(), "promedio"=>$promediogm, "reprobados"=>$promediomateriagrado[$key."-".$m->getMateriaid()->getMateriaid()]["reprobadospormateria"]);
				}

				$promediogrado[$key]=array("grado"=>$promedio["grado"], "promedio"=>$promediog, "materias"=>$gradomaterias, "alumnos"=>$promedio["alumnosxgrado"], "promedio5"=>$promedio["promedio5"], "promedio6"=>$promedio["promedio6"], "promedio7"=>$promedio["promedio7"], "promedio8"=>$promedio["promedio8"], "promedio9"=>$promedio["promedio9"]);
			}
			$promediogrado=array_values($promediogrado);

			foreach($promedioperiodo as $key=> $promedio){
				$promediop=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promedio"] / count($alumnosgrupo)));
				if($promediop== 0){
					$promediop=null;
				}
				$periodomaterias=null;
				foreach($materias as $materia){
					$promediopm=number_format($promediomateriaperiodo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio"] / count($alumnosgrupo), 2);
					$final=number_format($promediomateriaperiodo[$key."-".$materia->getMateriaid()->getMateriaid()]["promediofinal"] / count($alumnosgrupo), 2);
					if($promediopm== 0){
						$promediopm=null;
					}
					$gru=null;
					$promediopromedio=null;
					foreach($grupos as $grupo){
						$promediopmgcalculo=number_format($promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio"] / $promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["alumnos"], 2);
						$promediopromedio=$promediopromedio + $promediopmgcalculo;
						if($promediopmgcalculo== 0){
							$promediopmgcalculo=null;
						}
						$gru[]=["grupo"=>$grupo->getNombre(), "alumnos"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["alumnos"], "promedio"=>$promediopmgcalculo,
								"promedio5"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio5"],
								"promedio6"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio6"],
								"promedio7"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio7"],
								"promedio8"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio8"],
								"promedio9"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio9"]
						];
					}
					$periodomaterias[]=array(
							"materiaid"=>$materia->getMateriaid()->getMateriaid(),
							"materia"=>$materia->getMateriaid()->getNombre(),
							"promedio"=>$promediopm,
							"promediofinal"=>$final,
							"promediogrupos"=>number_format($promediopromedio / count($gru), 2),
							"reprobados"=>$reprobadosporperiodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"inferiores"=>$inferioresporperiodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"superiores"=>$superioresporperiodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio5"=>$promedio5periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio6"=>$promedio6periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio7"=>$promedio7periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio8"=>$promedio8periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio9"=>$promedio9periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"grupos"=>$gru);
				}
				$periodogrupos=null;
				foreach($grupos as $grupo){
					$conn=$dbm->getConnection();
					$stmt=$conn->prepare(
									"select a.alumnoid,concat_ws(' ',a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,gru.nombre as grupo
                        from ce_alumno a
                        inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
                        inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
                        inner join ce_grupo gru on gru.grupoid=acg.grupoid
                        where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"]." and ac.gradoid=".$filtros["gradoid"]." and acg.grupoid=".$grupo->getGrupoid()."
                        order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre"
					);
					$stmt->execute();
					$ag=$stmt->fetchAll();

					$promediopg=number_format($promediogrupoperiodo[$key."-".$grupo->getGrupoid()]["promedio"] / count($ag), 2);
					//$final=number_format($promediogrupoperiodo[$key."-".$materia->getMateriaid()->getMateriaid()]["promediofinal"]/count($alumnosgrupo),2);
					if($promediopg== 0){
						$promediopg=null;
					}

					$periodogrupos[]=array("grupo"=>$grupo->getNombre(), "alumnos"=>count($ag), "promedio"=>$promediopg);
				}
				$promedioperiodo[$key]=array("periodo"=>$promedio["periodo"], "materias"=>$periodomaterias, "grupos"=>$periodogrupos, "promedio"=>$promediop, "promedio5"=>$promedio["promedio5"], "promedio6"=>$promedio["promedio6"], "promedio7"=>$promedio["promedio7"], "promedio8"=>$promedio["promedio8"], "promedio9"=>$promedio["promedio9"]);
				$promedio5total=$promedio5total + $promedio["promedio5"];
				$promedio6total=$promedio6total + $promedio["promedio6"];
				$promedio7total=$promedio7total + $promedio["promedio7"];
				$promedio8total=$promedio8total + $promedio["promedio8"];
				$promedio9total=$promedio9total + $promedio["promedio9"];
			}
			$promedioperiodo=array_values($promedioperiodo);
			foreach($promedioperiodo as $key=> $promedio){
				$promedioperiodo[$key]["totales"]=[
						"promedio5"=>$promedio5total,
						"promedio6"=>$promedio6total,
						"promedio7"=>$promedio7total,
						"promedio8"=>$promedio8total,
						"promedio9"=>$promedio9total,
				];
			}

			$promediomateria=array_values($promediomateria);
			foreach($materias as $materia){
				if(!isset($reprobadospormateria[$materia->getMateriaid()->getMateriaid()])){
					$reprobadospormateria[$materia->getMateriaid()->getMateriaid()]=array("materia"=>$materia->getMateriaid()->getNombre(), "total"=>0,"periodo" => $ikperiodo);
				}
				if(!isset($inferiorespormateria[$materia->getMateriaid()->getMateriaid()])){
					$inferiorespormateria[$materia->getMateriaid()->getMateriaid()]=array("materia"=>$materia->getMateriaid()->getNombre(), "total"=>0);
				}
				if(!isset($superiorespormateria[$materia->getMateriaid()->getMateriaid()])){
					$superiorespormateria[$materia->getMateriaid()->getMateriaid()]=array("materia"=>$materia->getMateriaid()->getNombre(), "total"=>0);
				}
			}
			$reprobadospormateria=array_values($reprobadospormateria);
			$inferiorespormateria=array_values($inferiorespormateria);
			$superiorespormateria=array_values($superiorespormateria);

			foreach($grupos as $grupo){
				if(!isset($reprobadosporgrupo[$grupo->getGrupoid()])){
					$reprobadosporgrupo[$grupo->getGrupoid()]=array("grupo"=>$grupo->getNombre(), "total"=>0);
				}
				if(!isset($inferioresporgrupo[$grupo->getGrupoid()])){
					$inferioresporgrupo[$grupo->getGrupoid()]=array("grupo"=>$grupo->getNombre(), "total"=>0);
				}
				if(!isset($superioresporgrupo[$grupo->getGrupoid()])){
					$superioresporgrupo[$grupo->getGrupoid()]=array("grupo"=>$grupo->getNombre(), "total"=>0);
				}
			}
			$reprobadosporgrupo=array_values($reprobadosporgrupo);
			$inferioresporgrupo=array_values($inferioresporgrupo);
			$superioresporgrupo=array_values($superioresporgrupo);
			foreach($grados as $gg){
				if((!isset($filtros["gradoid"])) || (isset($filtros["gradoid"]) && $filtros["gradoid"]== $gg->getGradoid())){
					$acumulado=null;
					foreach($reprobadasacumuladasporgrado[$gg->getGradoid()] as $key=> $acum){
						$acumulado[]=["nombre"=>$key, "total"=>$acum["total"]];
						$grado=$gg->getGrado();
						$nombre[$key]=$key;
					}
					array_multisort($nombre, SORT_ASC, $acumulado);

					$alumnosgrado[$gg->getGradoid()]=count($dbmce->BuscarAlumnosA([
						"gradoid"=> $gg->getGradoid(),
						"alumnoestatusid"=> 1
					]));
					
					$acumuladas[]=["grado"=>$gg->getGrado(), "alumnos"=>$alumnosgrado[$gg->getGradoid()], "acumulado"=>$acumulado];
				}
			}
			foreach($periodosids as $periodo){
				$gradospromedio=null;
				foreach($grados as $grado){
					$promediopg=number_format($promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio"] / $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["alumnos"], 2);
					if($promediopg== 0){
						$promediopg=null;
					}
					//$planestudio=$dbm->getOneByParametersRepositorio("CePlanestudios",["cicloinicialid"=>$filtros["cicloid"],"gradoid"=>$grado->getGradoid(),"vigente"=>1]);
					if($planestudio){
						//$materias=$dbm->getRepositoriosById("CeMateriaporplanestudios","planestudioid",$planestudio->getPlanestudioid());
						$mat=null;
						foreach($materias as $materia){
							$prmediopmgrado=number_format($promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio"] / $promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["alumnos"], 2);
							if($prmediopmgrado== 0){
								$prmediopmgrado=null;
							}
							$mat[]=[
									"materia"=>$materia->getMateriaid()->getNombre(),
									"promedio5"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio5"],
									"promedio6"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio6"],
									"promedio7"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio7"],
									"promedio8"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio8"],
									"promedio9"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio9"],
									"promedio"=>$prmediopmgrado
							];
						}
					}
					$gradospromedio[]=[
							"grado"=>$grado->getGrado(),
							"promedio5"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio5"],
							"promedio6"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio6"],
							"promedio7"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio7"],
							"promedio8"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio8"],
							"promedio9"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio9"],
							"promedio"=>$promediopg,
							"materias"=>$mat
					];
					${"promedio5total".$periodo}=${"promedio5total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio5"];
					${"promedio6total".$periodo}=${"promedio6total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio6"];
					${"promedio7total".$periodo}=${"promedio7total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio7"];
					${"promedio8total".$periodo}=${"promedio8total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio8"];
					${"promedio9total".$periodo}=${"promedio9total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio9"];
					if($promedioperiodogrado[$periodo."-".$grado->getGradoid()]["periodo"]){
						$pnombre=$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["periodo"];
					}
				}
				$promediosperiodogrado[]=["periodoid"=>$periodo, "periodo"=>$pnombre, "grados"=>$gradospromedio];
			}

			foreach($promediosperiodogrado as &$periodo){
				$periodo["promedio5"]=${"promedio5total".$periodo["periodoid"]};
				$periodo["promedio6"]=${"promedio6total".$periodo["periodoid"]};
				$periodo["promedio7"]=${"promedio7total".$periodo["periodoid"]};
				$periodo["promedio8"]=${"promedio8total".$periodo["periodoid"]};
				$periodo["promedio9"]=${"promedio9total".$periodo["periodoid"]};
			}

			$reprobadasacumuladasporgrado=array_values($reprobadasacumuladasporgrado);

			$reprobadosxmateriafinal = [];
			$inferioresxmateriafinal = [];
			$superioresxmateriafinal = [];

			if(!$respuesta){
				return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
			}
			return new View([
					"configuracion"=>$configuracion,
					"encabezado"=>$encabezado,
					"calificaciones"=>$respuesta,
					"reprobadospormateria"=>$reprobadospormateria,
					"repmat" => $repmat,
					"inferiorespormateria"=>$inferiorespormateria,
					"superiorespormateria"=>$superiorespormateria,
					"reprobadosporgrupo"=>$reprobadosporgrupo,
					"inferioresporgrupo"=>$inferioresporgrupo,
					"superioresporgrupo"=>$superioresporgrupo,
					"promediomateria"=>$promediomateria,
					"promediogrupo"=>$promediogrupo,
					"promediogrado"=>$promediogrado,
					"promedioperiodo"=>$promedioperiodo,
					"grupos"=>$grupos,
					"grados"=>$grados,
					"alumnosgrupo"=>$alumnosgrupo,
					"reprobadasacumuladasporgrado"=>$acumuladas,
					"promediosperiodogrado"=>$promediosperiodogrado,
					"puntopase" => $puntopase,
					"filtros" => $filtros
				],Response::HTTP_OK);
			//return new View(["promediosperiodogrado"=>$promediosperiodogrado], Response::HTTP_OK);
		}catch(Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

	/**
	 * Retorna arreglo de calificaciomes de Alumno
	 * @Rest\Get("/api/Reportes/Calificaciones/indice", name="ReporteCalificacionesIndice")
	 */
	public function ReporteCalificacionesIndice(){
		//return new View(json_decode('',true),Response::HTTP_OK);
		try{
			$datos=$_REQUEST;
			$filtros=array_filter($datos);
			$instituto = ENTORNO;
			$arrayalumnocalfinal = [];
			$em=$this->get("db_manager")->getEntityManager();
			$dbm=new DbmReportes($em);
			$dbmce=new DbmControlescolar($em);
			$calificaciones=$dbm->ConsultaCalificaciones($filtros);
			$reprobadosporgrupo=[];
			$inferioresporgrupo=[];
			$superioresporgrupo=[];
			$arrayAlu = [];
			$promedioxmateria = [];
			$acumuladas = [];
			if(!$calificaciones){
				return new View("No se encontró ningun registro", Response::HTTP_PARTIAL_CONTENT);
			}

			$pme=$dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'profesorpormateriaplanestudiosid', $calificaciones[0]['profesorpormateriaplanestudiosid']);


			$materiasa=$dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $calificaciones[0]['materiaporplanestudioid']);

			$mats=[];

			$url=$dbm->getRepositorioById('Parametros', 'nombre', 'URLServicios');

			foreach($calificaciones as &$c){
				$c['foto']=$alumno['foto']=$url->getValor().'/api/Alumno/foto?alumnoid='.$c['alumnoid'];
				$find=false;
				foreach($mats as $m){
					if($m== $c['materiaporplanestudioid']){
						$find=true;
					}
				}
				if(!$find){
					$mats[]=$c['materiaporplanestudioid'];
				}
			}

			$roundFinal="";
			$roundMateria="";
			$roundCriterio="";
			$roundFunctions=null;
			$materiasused=[];
			$materias=[];
			foreach($mats as $m){
				$mm=$dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $m);
				if(!$roundFunctions){
					$roundFunctions=$dbmce->getRoundFunctionNameByMateriaplanestudio($m);
					$roundFinal=$roundFunctions['final'];
					$roundMateria=$roundFunctions['materia'];
					$roundCriterio=$roundFunctions['criterio'];
				}
				if($mm){
					$kmateria=$mm->getMateriaid()->getMateriaid();
					if(!isset($materiasused[$kmateria])){
						$materiasused[$kmateria]=true;
						$materias[]=$mm;
					}
				}
			}
			usort($materias, "AppBundle\Controller\Reportes\CalificacionesController::fnMateriaOrden");

			$mata=$materiasa;

			$planestudio=$dbm->getOneByParametersRepositorio("CePlanestudios", ["planestudioid"=>$mata->getPlanestudioid()]);
			if(!$planestudio){
				return new View("No existe un plan de estudios ", Response::HTTP_PARTIAL_CONTENT);
			}
			if(isset($filtros["gradoid"])){

				$puntopase=$planestudio->getPuntopase();
				$calminima=$planestudio->getCalificacionminima();
				$configuracion=["puntopase"=>$puntopase];
			}
			$periodos=[];
			$periodosr=[];
			foreach($calificaciones AS $icalificacion){
				$kperiodoe=$icalificacion['periodoevaluacionid'];
				if($kperiodoe && !isset($periodosr[$kperiodoe])){
					$periodoename=$icalificacion['descripcioncorta'];
					$periodosr[$kperiodoe]=true;
					$periodos[]=[$kperiodoe,$periodoename];
				}
			}
			$periodosids=array_values(array_unique(array_column($calificaciones, 'periodoevaluacionid')));
			$alumnos=array_values(array_unique(array_column($calificaciones, 'alumnoid')));
			$gradosdeivid=array_values(array_unique(array_column($calificaciones, 'gradoid')));
			$reprobados=array_values(array_unique(array_column($calificaciones, 'reprobados')));
			$reprobados = array_filter($reprobados, function ($value) {
                return $value !== '';
			});

			$conn=$dbm->getConnection();
			if(isset($filtros["grupoid"])){
				$grupo="and acg.grupoid=".$filtros["grupoid"];
			}
			if(isset($filtros["matricula"])){
				$matricula="and a.matricula=".$filtros["matricula"];
			}
			if($filtros["soloreprobados"] == "1"){
				$students = implode(',',$reprobados);
				$reprobadostotal="and a.alumnoid IN (".$students .")";
			}
			if(isset($filtros["gradoid"])){
				$stmt=$conn->prepare(
								"select a.alumnoid,concat_ws(' ',a.matricula, ' - ', a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,gru.nombre as grupo
                    from ce_alumno a
                    inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
                    inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
                    inner join ce_grupo gru on gru.grupoid=acg.grupoid
                    where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"]." and ac.gradoid in(". join(",",$filtros["gradoid"]) .") $grupo $matricula $reprobadostotal
                    order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre"
				);
				$stmt->execute();
				$alumnosgrupo=$stmt->fetchAll();
			}

			$materiassep=0;
			$encabezadorel=[];
			foreach($materias as $imateria){
				$kmateria=$imateria->getMateriaid()->getMateriaid();
				$omateria=$imateria->getMateriaid();
				$esCurricular=$imateria->getEscurricular();
				$imateriadata=array(
						"materiaid"=>$kmateria,
						"materia"=>$omateria->getNombre(),
						"sep"=>$esCurricular,
						"periodos"=>$periodos,
						"recuperaciones"=>[],
						"recrel"=>[]
					);
				$encabezado[]=&$imateriadata;
				$encabezadorel[$kmateria]=&$imateriadata;
				if($esCurricular){ $materiassep++; }
				unset($imateriadata);
			}

			$respuesta=[];
			foreach($calificaciones as $calificacion){
				$kalumno=$calificacion["alumnoid"];
				$kalumnociclo=$calificacion["alumnoporcicloid"];
				$kgrupo=$calificacion["grupoid"];
				$kmateria=$calificacion["materiaid"];
				$kperiodoevaluacion=$calificacion["periodoevaluacionid"];
				$kprofesormpe=$calificacion["profesorpormateriaplanestudiosid"];
				$alumnosgrado[$calificacion["gradoid"]]=$alumnosgrado[$calificacion["gradoid"]] + 1;
				$gruponombre=$calificacion["gruponombre"];
				$icalificacionpinput=false;
				$icalificacionperiodo=null;
				$icalificacionp=null;
				if(isset($calificacion["calificacionperiodo"])){
					$icalificacionpinput=true;
					$icalificacionp=$calificacion["calificacionperiodo"];
				}
				$recuperaciones=$dbm->getRepositoriosModelo("CeRecuperacionperiodo",[
						"d.recuperacionperiodoid",
						"d.intento",
						"d.calificacion"
					],[
						"profesorpormateriaplanestudioid"=>$kprofesormpe,
						"periodoevaluacionid"=>$kperiodoevaluacion,
						"alumnoporcicloid"=>$kalumnociclo
					],["intento"=>"DESC"]);
				if(!empty($recuperaciones)){
					$icalificacionp=$recuperaciones[0]["calificacion"];
				}

				$promediomateria[$kmateria]=array("materia"=>$calificacion["materianombre"], "promedio"=>$promediomateria[$kmateria]["promedio"] + $icalificacionp);
				$promediogrupo[$kgrupo]=array(
						"grupo"=>$gruponombre,
						"promediosep"=>$promediogrupo[$kgrupo]["promediosep"] + ($calificacion["escurricular"] ? $icalificacionp : 0),
						"promedioidec"=>$promediogrupo[$kgrupo]["promedioidec"] + $icalificacionp, "alumnos"=>$promediogrupo[$kgrupo]["alumnos"] + 1
				);


				$grupomateria="$kgrupo-$kmateria";
				$gradomateria=$calificacion["gradoid"]."-$kmateria";
				$periodomateria="$kperiodoevaluacion-$kmateria";
				$periodogrupo="$kperiodoevaluacion-$kgrupo";
				$periodogrado="$kperiodoevaluacion-".$calificacion["gradoid"];
				$reprobadosgrupo=$promediomateriagrupo[$grupomateria]["reprobados"];
				$reprobadosxmat = $promediomateriagrado[$gradomateria]['reprobadospormateria'];
				if($icalificacionpinput && $icalificacionp <= (ENTORNO == 1 ? $puntopase : $calminima)){
					$reprobadosgrupo=$reprobadosgrupo + 1;
					$reprobadosxmat=$reprobadosxmat + 1;
					$reprobadosporperiodomateria[$periodomateria]=$reprobadosporperiodomateria[$periodomateria] + 1;
				}

				$inferiores=null;
				$inferioresgrupo=$promediomateriagrupo[$grupomateria]["inferiores"];
				if($icalificacionpinput && $icalificacionp < 8){
					$inferioresgrupo=$inferioresgrupo + 1;
					$inferioresporperiodomateria[$periodomateria]=$inferioresporperiodomateria[$periodomateria] + 1;
				}
				$superiores=null;
				$superioresgrupo=$promediomateriagrupo[$grupomateria]["superiores"];
				if($icalificacionpinput && $icalificacionp > 9){
					$superioresgrupo=$superioresgrupo + 1;
					$superioresporperiodomateria[$periodomateria]=$superioresporperiodomateria[$periodomateria] + 1;
				}

				$menora5=null;
				$m5=false;
				if($icalificacionpinput && $icalificacionp<= 5){
					$menora5=$menora5 + 1;
					$m5=true;
					$promedio5periodomateria[$periodomateria]=$promedio5periodomateria[$periodomateria] + 1;
				}
				$entre6=null;
				$m6=false;
				if($icalificacionpinput && $icalificacionp>= 6 && $icalificacionp<= 6.9){
					$entre6=$entre6 + 1;
					$m6=true;
					$promedio6periodomateria[$periodomateria]=$promedio6periodomateria[$periodomateria] + 1;
				}
				$entre7=null;
				$m7=false;
				if($icalificacionpinput && $icalificacionp>= 7 && $icalificacionp<= 7.9){
					$entre7=$entre7 + 1;
					$m7=true;
					$promedio7periodomateria[$periodomateria]=$promedio7periodomateria[$periodomateria] + 1;
				}
				$entre8=null;
				$m8=false;
				if($icalificacionpinput && $icalificacionp>= 8 && $icalificacionp<= 8.9){
					$entre8=$entre8 + 1;
					$m8=true;
					$promedio8periodomateria[$periodomateria]=$promedio8periodomateria[$periodomateria] + 1;
				}
				$entre9=null;
				$m9=false;
				if($icalificacionpinput && $icalificacionp>= 9 && $icalificacionp<= 10){
					$entre9=$entre9 + 1;
					$m9=true;
					$promedio9periodomateria[$periodomateria]=$promedio9periodomateria[$periodomateria] + 1;
				}

				$promedioperiodogrado[$periodogrado]=array(
						"periodo"=>$calificacion["descripcion"],
						"promedio"=>$promedioperiodo[$kperiodoevaluacion]["promedio"] + $icalificacionp,
						"alumnos"=>$promedioperiodo[$kperiodoevaluacion]["alumnos"] + 1,
						"promedio5"=>$m5 ? $promedioperiodogrado[$periodogrado]["promedio5"] + 1 : $promedioperiodogrado[$periodogrado]["promedio5"],
						"promedio6"=>$m6 ? $promedioperiodogrado[$periodogrado]["promedio6"] + 1 : $promedioperiodogrado[$periodogrado]["promedio6"],
						"promedio7"=>$m7 ? $promedioperiodogrado[$periodogrado]["promedio7"] + 1 : $promedioperiodogrado[$periodogrado]["promedio7"],
						"promedio8"=>$m8 ? $promedioperiodogrado[$periodogrado]["promedio8"] + 1 : $promedioperiodogrado[$periodogrado]["promedio8"],
						"promedio9"=>$m9 ? $promedioperiodogrado[$periodogrado]["promedio9"] + 1 : $promedioperiodogrado[$periodogrado]["promedio9"]
				);


				$promedioperiodo[$kperiodoevaluacion]=array(
						"periodo"=>$calificacion["descripcion"],
						"promedio"=>$promedioperiodo[$kperiodoevaluacion]["promedio"] + $icalificacionp,
						"alumnos"=>$promedioperiodo[$kperiodoevaluacion]["alumnos"] + 1,
						"promedio5"=>$m5 ? $promedioperiodo[$kperiodoevaluacion]["promedio5"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio5"],
						"promedio6"=>$m6 ? $promedioperiodo[$kperiodoevaluacion]["promedio6"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio6"],
						"promedio7"=>$m7 ? $promedioperiodo[$kperiodoevaluacion]["promedio7"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio7"],
						"promedio8"=>$m8 ? $promedioperiodo[$kperiodoevaluacion]["promedio8"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio8"],
						"promedio9"=>$m9 ? $promedioperiodo[$kperiodoevaluacion]["promedio9"] + 1
							: $promedioperiodo[$kperiodoevaluacion]["promedio9"]
				);

				if(!$arrayAlu[$calificacion["gradoid"]]) {
						if(isset($filtros["grupoid"])){
							$grupo="and acg.grupoid=".$filtros["grupoid"];
						}
						if($filtros["soloreprobados"] == "1"){
							$students = implode(',',$reprobados);
							$reprobadostotal="and a.alumnoid IN (".$students .")";
						}
						$stmt=$conn->prepare(
							"select a.alumnoid,concat_ws(' ',a.matricula, ' - ', a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,gru.nombre as grupo
								from ce_alumno a
								inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
								inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
								inner join ce_grupo gru on gru.grupoid=acg.grupoid
								where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"]." and ac.gradoid=".$calificacion["gradoid"]."  $grupo $reprobadostotal
							order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre"
						);
						$stmt->execute();
						$totalgrado=$stmt->fetchAll();
						$arrayAlu[$calificacion["gradoid"]] = count($totalgrado);
				}

				$promediogrado[$calificacion["gradoid"]]=array(
						"grado"=>$calificacion["gradonombre"],
						"gradoid"=>$calificacion["gradoid"],
						"promedio"=>$promediogrado[$calificacion["gradoid"]]["promedio"] + $icalificacionp,
						"alumnosxgrado"=>$arrayAlu[$calificacion["gradoid"]],
						"alumnos"=>$promediogrado[$calificacion["gradoid"]]["alumnos"] + 1, 
						"promedio5"=>$m5 ? $promediogrado[$kperiodoevaluacion]["promedio5"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio5"],
						"promedio6"=>$m6 ? $promediogrado[$kperiodoevaluacion]["promedio6"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio6"],
						"promedio7"=>$m7 ? $promediogrado[$kperiodoevaluacion]["promedio7"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio7"],
						"promedio8"=>$m8 ? $promediogrado[$kperiodoevaluacion]["promedio8"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio8"],
						"promedio9"=>$m9 ? $promediogrado[$kperiodoevaluacion]["promedio9"] + 1
							: $promediogrado[$kperiodoevaluacion]["promedio9"]
				);


				$periodomateriagrupo="$kperiodoevaluacion-$kmateria-$kgrupo";

				$promediopmg[$periodomateriagrupo]=array(
						"promedio"=>$promediopmg[$periodomateriagrupo]["promedio"] + $icalificacionp,
						"alumnos"=>$promediopmg[$periodomateriagrupo]["alumnos"] + 1,
						"promedio5"=>$m5 ? $promediopmg[$periodomateriagrupo]["promedio5"] + 1 : $promediopmg[$periodomateriagrupo]["promedio5"],
						"promedio6"=>$m6 ? $promediopmg[$periodomateriagrupo]["promedio6"] + 1 : $promediopmg[$periodomateriagrupo]["promedio6"],
						"promedio7"=>$m7 ? $promediopmg[$periodomateriagrupo]["promedio7"] + 1 : $promediopmg[$periodomateriagrupo]["promedio7"],
						"promedio8"=>$m8 ? $promediopmg[$periodomateriagrupo]["promedio8"] + 1 : $promediopmg[$periodomateriagrupo]["promedio8"],
						"promedio9"=>$m9 ? $promediopmg[$periodomateriagrupo]["promedio9"] + 1 : $promediopmg[$periodomateriagrupo]["promedio9"]
				);

				$periodomateriagrado="$kperiodoevaluacion-$kmateria-".$calificacion["gradoid"];

				$promediopmgrado[$periodomateriagrado]=array(
						"promedio"=>$promediopmgrado[$periodomateriagrado]["promedio"] + $icalificacionp,
						"alumnos"=>$promediopmgrado[$periodomateriagrado]["alumnos"] + 1,
						"promedio5"=>$m5 ? $promediopmgrado[$periodomateriagrado]["promedio5"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio5"],
						"promedio6"=>$m6 ? $promediopmgrado[$periodomateriagrado]["promedio6"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio6"],
						"promedio7"=>$m7 ? $promediopmgrado[$periodomateriagrado]["promedio7"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio7"],
						"promedio8"=>$m8 ? $promediopmgrado[$periodomateriagrado]["promedio8"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio8"],
						"promedio9"=>$m9 ? $promediopmgrado[$periodomateriagrado]["promedio9"] + 1
							: $promediopmgrado[$periodomateriagrado]["promedio9"]
				);

				$conteocalfinal = 0;
				if(!in_array($calificacion['alumnoid'] . '-' . $calificacion['gradoid']. '-'.$kmateria, $arrayalumnocalfinal)) {
					$conteocalfinal = $calificacion['calificacionfinal'];
					array_push($arrayalumnocalfinal, $calificacion['alumnoid'] . '-' . $calificacion['gradoid']. '-'.$kmateria);
				}

				$promediomateriagrupo[$grupomateria]=array("grupo"=>$gruponombre, "materia"=>$calificacion["materianombre"], "promedio"=>$promediomateriagrupo[$grupomateria]["promedio"] + $icalificacionp, "alumnos"=>$promediomateriagrupo[$grupomateria]["alumnos"] + 1, "reprobados"=>$reprobadosgrupo, "inferiores"=>$inferioresgrupo, "superiores"=>$superioresgrupo, "promedio5"=>$menora5, "promedio6"=>$entre6, "promedio7"=>$entre7, "promedio8"=>$entre8, "promedio9"=>$entre9);
				$promediomateriagrado[$gradomateria]=array("gradoid"=>$calificacion["gradoid"], "grado"=>$calificacion["gradonombre"], "materia"=>$calificacion["materianombre"], "promedio"=>$promediomateriagrado[$gradomateria]["promedio"] + $icalificacionp, "promediofinal"=>$promediomateriagrado[$gradomateria]["promediofinal"] + $conteocalfinal, "alumnos"=>$promediomateriagrado[$gradomateria]["alumnos"] + 1, "reprobados"=>$reprobadosgrupo, "reprobadospormateria"=>$reprobadosxmat, "inferiores"=>$inferioresgrupo, "superiores"=>$superioresgrupo);
				$promediomateriaperiodo[$periodomateria]=array("periodoevaluacionid"=>$kperiodoevaluacion, "periodo"=>$calificacion["descripcion"], "materia"=>$calificacion["materianombre"], "promedio"=>$promediomateriaperiodo[$periodomateria]["promedio"] + $icalificacionp, "promediofinal"=>$promediomateriaperiodo[$periodomateria]["promediofinal"] + $calificacion["calificacionfinal"], "alumnos"=>$promediomateriaperiodo[$periodomateria]["alumnos"] + 1);
				$promediogrupoperiodo[$periodogrupo]=array("periodoevaluacionid"=>$kperiodoevaluacion, "periodo"=>$calificacion["descripcion"], "grupo"=>$gruponombre, "promedio"=>$promediogrupoperiodo[$periodogrupo]["promedio"] + $icalificacionp, "promediofinal"=>$promediogrupoperiodo[$periodogrupo]["promediofinal"] + $calificacion["calificacionfinal"], "alumnos"=>$promediogrupoperiodo[$periodogrupo]["alumnos"] + 1);
				//$promediogradoperiodo[$periodogrado]=array("periodoevaluacionid"=>$kperiodoevaluacion,"periodo"=>$calificacion["descripcion"],"grado"=>$calificacion["gradonombre"],"promedio"=>$promediogradoperiodo[$periodogrado]["promedio"]+$icalificacionp,"promediofinal"=>$promediogradoperiodo[$periodogrado]["promediofinal"]+$calificacion["calificacionfinal"],"alumnos"=>$promediogradoperiodo[$periodogrado]["alumnos"]+1);
				$keyalumno=array_search($kalumno, array_column($respuesta, 'alumnoid'));
				if($keyalumno===false || $keyalumno===null){
					$filtrosalumno=$filtros;
					$filtrosalumno["alumnoid"]=$kalumno;
					$calificacionesalumno=$dbm->ConsultaCalificaciones($filtrosalumno);
					$sumaSEP=null;
					$sumaInstituto=null;
					$reprobadas=null;
					$inferiores=null;
					$superiores=null;
					$promedios=[];//null;
					$promediosperiodo=null;
					$promediosmateria=null;
					$isLux=(ENTORNO==1);
					$matrep = [];
					
					$calsSEP=0;
					$calsInstituto=0;
					foreach($calificacionesalumno AS $calificacionalumno){
						$ikgrupo=$calificacionalumno['grupoid'];
						$ikmateria=$calificacionalumno['materiaid'];
						$ikperiodo=$calificacionalumno['periodoevaluacionid'];
						$ikcalificacionalumno=$calificacionalumno['materiaporplanestudioid'];
						$iporcentajecf=$calificacionalumno['porcentajecf'];
						$icurricular=$calificacionalumno["escurricular"];
						$icalificacionperiodo=$calificacionalumno["calificacionperiodo"];
						$iperiodoname=$calificacionalumno["descripcioncorta"];
						$imaterianame=$calificacionalumno["materianombre"];
						$iponderacionid=$calificacionalumno["ponderacionid"];
						$itipocalificacion=$calificacionalumno['tipocalificacionid'];
						$igruponame=$calificacionalumno["gruponombre"];

						if($itipocalificacion!=1){
							if($icurricular){
								$calsSEP++;
								$sumaSEP+=$icalificacionperiodo;
							}
							if($icurricular || !$isLux){
								$calsInstituto++;
								$sumaInstituto+=$icalificacionperiodo;
								$promediosperiodo[$iperiodoname]["promedio"]+=$icalificacionperiodo;
								$promediosperiodo[$iperiodoname]["numeromateria"] += 1;	
							}
							$promediosperiodo[$iperiodoname]["periodoid"]=$ikperiodo;
							$promediosperiodo[$iperiodoname]["porcentaje"]=(int)$iporcentajecf;
						}



						if(!isset($filtros["gradoid"])){
							//$planestudio=$dbm->getOneByParametersRepositorio("CePlanestudios",["cicloinicialid"=>$filtros["cicloid"],"gradoid"=>$calificacionalumno["gradoid"],"vigente"=>1]);
							$puntopase=$planestudio->getPuntopase();
						}
						if(isset($calificacionalumno["calificacionperiodo"])){
							if($icalificacionperiodo < $puntopase){
								$reprobadas++;
								if(!isset($reprobadosporgrupo[$ikgrupo])){
									$reprobadosporgrupo[$ikgrupo]=["grupo"=>$igruponame, "total"=>0];
									$reprobadospormateria[$ikmateria]=["materia"=>$imaterianame, "total"=>0, "periodo" => $ikperiodo];
								}
								$reprobadosporgrupo[$ikgrupo]["total"] ++;
								$reprobadospormateria[$ikmateria]["total"] ++;
							}
							if($icalificacionperiodo < 8){
								$inferiores++;
								if(!isset($inferioresporgrupo[$ikgrupo])){
									$inferioresporgrupo[$ikgrupo]=["grupo"=>$igruponame, "total"=>0];
									$inferiorespormateria[$ikmateria]=["materia"=>$imaterianame, "total"=>0];
								}
								$inferioresporgrupo[$ikgrupo]["total"] ++;
								$inferiorespormateria[$ikmateria]["total"] ++;
							}
							if($icalificacionperiodo > 9){
								$superiores++;
								if(!isset($superioresporgrupo[$ikgrupo])){
									$superioresporgrupo[$ikgrupo]=["grupo"=>$igruponame, "total"=>0];
									$superiorespormateria[$ikmateria]=["materia"=>$imaterianame, "total"=>0];
								}
								$superioresporgrupo[$ikgrupo]["total"] ++;
								$superiorespormateria[$ikmateria]["total"] ++;
							}
						}
					}
					$promediable=true;
					$promedioGeneralRaw=0;
					foreach($promediosperiodo as $promediokey=> $promedio){
						$iporcentaje=$promedio["porcentaje"];
						$promediop=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promedio"] / $promedio["numeromateria"]));
						$promedioGeneralRaw+=$promediop;
						if($promediop==0){
							$promediop=null;
						}
						if($iporcentaje>0){
							$promediable=false;
						}
						$promedios[]=array("periodo"=>$promediokey, "promedio"=>$promediop, "porcentaje"=>$iporcentaje);
					}
					if($promediable){
						$promedioGeneral=($promedioGeneralRaw / count($promediosperiodo));
					}else{
						$promedioGeneral=0;
						foreach($promedios AS $ipromedioraw){
							$ipromedio=$ipromedioraw['promedio'];
							$iporcentaje=$ipromedioraw['porcentaje'];
							if(!$ipromedio){ $ipromedio=0; }
							$promedioGeneral+=($ipromedio*$iporcentaje/100);
						}
					}

					$promedioSEP=$dbmce->getRoundedValueByFunctionName($roundFinal, ($sumaSEP / $calsSEP));
					$promedioGeneral=$dbmce->getRoundedValueByFunctionName($roundFinal, $promedioGeneral);
					$promedioInstituto=$promedioGeneral;
					//$promedioInstituto=$dbmce->getRoundedValueByFunctionName($roundFinal, ($sumaInstituto / $calsInstituto));
					if($promedioSEP==0){
						$promedioSEP=null;
					}
					if($promedioGeneral==0){
						$promedioGeneral=null;
					}
					if($promedioInstituto==0){
						$promedioInstituto=null;
					}
					if($reprobadas>0){
						$reprobadasacumuladasporgrado[$calificacion["gradoid"]][$reprobadas." materias"]=array("grado"=>$calificacion["gradonombre"], "total"=>$reprobadasacumuladasporgrado[$calificacion["gradoid"]][$reprobadas." materias"]["total"] + 1);
					}
					$respuesta[]=[
							"alumnoid"=>$kalumno,
							"foto"=>$url->getValor() . "/api/Alumno/foto?alumnoid=$kalumno",
							"nombre"=>$calificacion["nombre"],
							"nombrecompleto"=>$calificacion["nombrecompleto"],
							"grupoid"=>$kgrupo,
							"gruponombre"=>$gruponombre,
							"numerolista"=>$calificacion["numerolista"],
							"matricula"=>$calificacion["matricula"],
							"periodos"=>[],
							"IDEC"=>$promedioInstituto,
							"SEP"=>$promedioSEP,
							"reprobadas"=>$reprobadas,
							"promedios"=>$promedios,
							"promediogeneral"=>$promedioGeneral,
							"promprorrateado"=>"",
							"promensigblo"=>""
					];
					$keyalumno=sizeof($respuesta)-1;
				}

				$periodokey=array_search($kperiodoevaluacion, array_column($respuesta[$keyalumno]["periodos"], 'periodoevaluacionid'));
				if($periodokey===null || $periodokey===false){
					$respuesta[$keyalumno]["periodos"][]=[
							"periodoevaluacionid"=>$kperiodoevaluacion,
							"descripcion"=>$calificacion["descripcion"],
							"descripcioncorta"=>$calificacion["descripcioncorta"],
							"fechainicio"=>$calificacion["fechainicio"],
							"fechafin"=>$calificacion["fechafin"],
							"captura"=>$this->getCapturaAlumnoPeriodo($dbmce, $kalumnociclo, $kperiodoevaluacion),
							"calificaciones"=>[]
						];
					$periodokey=sizeof($respuesta[$keyalumno]["periodos"])-1;
				}

				$materiakey=array_search($kmateria, array_column($respuesta[$keyalumno]["periodos"][$periodokey]["calificaciones"], 'materiaid'));
				if($materiakey===null || $materiakey===false){
					$desglose=$dbm->getCalificacionDesgloseByCalificacionperiodoalumno($calificacion["id"]);
					if(!$desglose){
						$desglose=$dbm->getCalificacionDesgloseByPeriodoevaluacionProfesormpe($kperiodoevaluacion,$kprofesormpe);
					}
					if($recuperaciones && !$encabezadorel[$kmateria]["recrel"][$kperiodoevaluacion]){
						$encabezadorel[$kmateria]["recrel"][$kperiodoevaluacion]=true;
						$encabezadorel[$kmateria]["recuperaciones"][]=[$kperiodoevaluacion,$calificacion["descripcioncorta"]." (R)"];
					}
					$respuesta[$keyalumno]["periodos"][$periodokey]["calificaciones"][]=[
							"id"=>$calificacion["id"],
							"materiaid"=>$kmateria,
							"materianombre"=>$calificacion["materianombre"],
							"materiaclave"=>$calificacion["materiaclave"],
							"nombrecorto"=>$calificacion["nombrecorto"],
							"ponderacionopcion"=>$calificacion["opcion"],
							"observacion"=>$calificacion["observacion"],
							"desglose"=>$desglose,
							"recuperaciones"=>$recuperaciones,
							"calificacionperiodo"=>$calificacion["calificacionperiodo"],
							"calificacionfinal"=>$calificacion["calificacionfinal"]
					];
				}
			}
			$alumnokey=null;
			foreach($alumnosgrupo as &$alumno){
				$alumnokey=array_search($alumno["alumnoid"], array_column($respuesta, 'alumnoid'));
				if($alumnokey=== false){
					
				}else{
					$alumno["foto"]=$url->getValor() . '/api/Alumno/foto?alumnoid=' . $alumno['alumnoid'];
					$alumno["calificaciones"]=$respuesta[$alumnokey];
				}
			}
			$grupos=$dbm->getByParametersRepositorios("CeGrupo", ["cicloid"=>$filtros["cicloid"], "gradoid"=>$filtros["gradoid"], "tipogrupoid"=>1]);
			$grados=$dbm->getByParametersRepositorios("Grado", ["nivelid"=>$filtros["nivelid"]]);
			foreach($promediomateria as $key=> $promedio){
				$promediom=number_format(($promedio["promedio"] / count($alumnos) / count($periodos)), 2);
				if($promediom== 0){
					$promediom=null;
				}
				$promediomateria[$key]=array("materia"=>$promedio["materia"], "promedio"=>$promediom);
				$grupomaterias=null;
				foreach($grupos as $grupo){
					$promediomg=number_format($promediomateriagrupo[$grupo->getGrupoid()."-".$key]["promedio"] / $promediomateriagrupo[$grupo->getGrupoid()."-".$key]["alumnos"], 2);
					if($promediomg== 0){
						$promediomg=null;
					}
					$grupomaterias[]=array("grupo"=>$grupo->getNombre(), "promedio"=>$promediomg);
				}
				$promediomateria[$key]=array("materia"=>$promedio["materia"], "promedio"=>$promediom, "grupos"=>$grupomaterias);
			}
			$promediomateria=array_values($promediomateria);
			foreach($promediogrupo as $key=> $promedio){
				$materiasgrupo=null;
				foreach($materias as $materia){
					$promediomg=number_format($promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio"] / $promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["alumnos"], 2);
					if($promediomg== 0){
						$promediomg=null;
					}
					$materiasgrupo[]=array(
							"materia"=>$materia->getMateriaid()->getNombre(),
							"promedio"=>$promediomg,
							"reprobados"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["reprobados"],
							"inferiores"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["inferiores"],
							"superiores"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["superiores"],
							"promedio5"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio5"],
							"promedio6"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio6"],
							"promedio7"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio7"],
							"promedio8"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio8"],
							"promedio9"=>$promediomateriagrupo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio9"],
					);
				}

				$promediogsep=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promediosep"] / $promedio["alumnos"]));
				$promediogidec=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promedioidec"] / $promedio["alumnos"]));
				if($promediogsep== 0){
					$promediogsep=null;
				}
				if($promediogidec== 0){
					$promediogidec=null;
				}
				$promediogrupo[$key]=array("grupo"=>$promedio["grupo"], "alumnos"=>$promedio["alumnos"], "promediosep"=>$promediogsep, "promedioidec"=>$promediogidec, "materias"=>$materiasgrupo);
			}
			$promediogrupo=array_values($promediogrupo);
			foreach($promediogrado as $key=> $promedio){
				$promediog=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promedio"] / $promedio["alumnosxgrado"]));
				if($promediog== 0){
					$promediog=null;
				}
				$pe=$dbmce->getOneByParametersRepositorio("CePlanestudios", ["gradoid"=> $promedio['gradoid'], "vigente"=> 1]);
				//$pe=$dbm->getOneByParametersRepositorio("CePlanestudios",["cicloinicialid"=>$filtros["cicloid"],"gradoid"=>$key,"vigente"=>1]);
				$mat=$dbm->getRepositoriosById("CeMateriaporplanestudios", "planestudioid", $pe->getPlanestudioid());
				$gradomaterias=null;
				foreach($mat as $m){
					$promediogm=number_format($promediomateriagrado[$key."-".$m->getMateriaid()->getMateriaid()]["promedio"] /  $promedio["alumnosxgrado"], 2);
					if($promediogm== 0){
						$promediogm=null;
					}
					$gradomaterias[]=array("materia"=>$m->getMateriaid()->getNombre(), "promedio"=>$promediogm, "reprobados"=>$promediomateriagrado[$key."-".$m->getMateriaid()->getMateriaid()]["reprobadospormateria"]);
				}

				$promediogrado[$key]=array("grado"=>$promedio["grado"], "promedio"=>$promediog, "materias"=>$gradomaterias, "alumnos"=>$promedio["alumnosxgrado"], "promedio5"=>$promedio["promedio5"], "promedio6"=>$promedio["promedio6"], "promedio7"=>$promedio["promedio7"], "promedio8"=>$promedio["promedio8"], "promedio9"=>$promedio["promedio9"]);
			}
			$promediogrado=array_values($promediogrado);

			foreach($promedioperiodo as $key=> $promedio){
				$promediop=$dbmce->getRoundedValueByFunctionName($roundFinal, ($promedio["promedio"] / count($alumnosgrupo)));
				if($promediop== 0){
					$promediop=null;
				}
				$periodomaterias=null;
				foreach($materias as $materia){
					$promediopm=number_format($promediomateriaperiodo[$key."-".$materia->getMateriaid()->getMateriaid()]["promedio"] / count($alumnosgrupo), 2);
					$final=number_format($promediomateriaperiodo[$key."-".$materia->getMateriaid()->getMateriaid()]["promediofinal"] / count($alumnosgrupo), 2);
					if($promediopm== 0){
						$promediopm=null;
					}
					$gru=null;
					$promediopromedio=null;
					foreach($grupos as $grupo){
						$promediopmgcalculo=number_format($promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio"] / $promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["alumnos"], 2);
						$promediopromedio=$promediopromedio + $promediopmgcalculo;
						if($promediopmgcalculo== 0){
							$promediopmgcalculo=null;
						}
						$gru[]=["grupo"=>$grupo->getNombre(), "alumnos"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["alumnos"], "promedio"=>$promediopmgcalculo,
								"promedio5"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio5"],
								"promedio6"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio6"],
								"promedio7"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio7"],
								"promedio8"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio8"],
								"promedio9"=>$promediopmg[$key."-".$materia->getMateriaid()->getMateriaid()."-".$grupo->getGrupoid()]["promedio9"]
						];
					}
					$periodomaterias[]=array(
							"materiaid"=>$materia->getMateriaid()->getMateriaid(),
							"materia"=>$materia->getMateriaid()->getNombre(),
							"promedio"=>$promediopm,
							"promediofinal"=>$final,
							"promediogrupos"=>number_format($promediopromedio / count($gru), 2),
							"reprobados"=>$reprobadosporperiodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"inferiores"=>$inferioresporperiodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"superiores"=>$superioresporperiodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio5"=>$promedio5periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio6"=>$promedio6periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio7"=>$promedio7periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio8"=>$promedio8periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"promedio9"=>$promedio9periodomateria[$key."-".$materia->getMateriaid()->getMateriaid()],
							"grupos"=>$gru);
				}
				$periodogrupos=null;
				foreach($grupos as $grupo){
					$conn=$dbm->getConnection();
					$stmt=$conn->prepare(
									"select a.alumnoid,concat_ws(' ',a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,gru.nombre as grupo
                        from ce_alumno a
                        inner join ce_alumnoporciclo ac on ac.alumnoid=a.alumnoid
                        inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid=ac.alumnoporcicloid
                        inner join ce_grupo gru on gru.grupoid=acg.grupoid
                        where a.alumnoestatusid=1 and tipogrupoid=1 and ac.cicloid=".$filtros["cicloid"]." and ac.gradoid in(".join(",",$filtros["gradoid"]).") and acg.grupoid=".$grupo->getGrupoid()."
                        order by grupo,a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre"
					);
					$stmt->execute();
					$ag=$stmt->fetchAll();

					$promediopg=number_format($promediogrupoperiodo[$key."-".$grupo->getGrupoid()]["promedio"] / count($ag), 2);
					//$final=number_format($promediogrupoperiodo[$key."-".$materia->getMateriaid()->getMateriaid()]["promediofinal"]/count($alumnosgrupo),2);
					if($promediopg== 0){
						$promediopg=null;
					}

					$periodogrupos[]=array("grupo"=>$grupo->getNombre(), "alumnos"=>count($ag), "promedio"=>$promediopg);
				}
				$promedioperiodo[$key]=array("periodo"=>$promedio["periodo"], "materias"=>$periodomaterias, "grupos"=>$periodogrupos, "promedio"=>$promediop, "promedio5"=>$promedio["promedio5"], "promedio6"=>$promedio["promedio6"], "promedio7"=>$promedio["promedio7"], "promedio8"=>$promedio["promedio8"], "promedio9"=>$promedio["promedio9"]);
				$promedio5total=$promedio5total + $promedio["promedio5"];
				$promedio6total=$promedio6total + $promedio["promedio6"];
				$promedio7total=$promedio7total + $promedio["promedio7"];
				$promedio8total=$promedio8total + $promedio["promedio8"];
				$promedio9total=$promedio9total + $promedio["promedio9"];
			}
			$promedioperiodo=array_values($promedioperiodo);
			foreach($promedioperiodo as $key=> $promedio){
				$promedioperiodo[$key]["totales"]=[
						"promedio5"=>$promedio5total,
						"promedio6"=>$promedio6total,
						"promedio7"=>$promedio7total,
						"promedio8"=>$promedio8total,
						"promedio9"=>$promedio9total,
				];
			}

			$promediomateria=array_values($promediomateria);
			foreach($materias as $materia){
				if(!isset($reprobadospormateria[$materia->getMateriaid()->getMateriaid()])){
					$reprobadospormateria[$materia->getMateriaid()->getMateriaid()]=array("materia"=>$materia->getMateriaid()->getNombre(), "total"=>0, "periodo" => $ikperiodo);
				}
				if(!isset($inferiorespormateria[$materia->getMateriaid()->getMateriaid()])){
					$inferiorespormateria[$materia->getMateriaid()->getMateriaid()]=array("materia"=>$materia->getMateriaid()->getNombre(), "total"=>0);
				}
				if(!isset($superiorespormateria[$materia->getMateriaid()->getMateriaid()])){
					$superiorespormateria[$materia->getMateriaid()->getMateriaid()]=array("materia"=>$materia->getMateriaid()->getNombre(), "total"=>0);
				}
			}
			$reprobadospormateria=array_values($reprobadospormateria);
			$inferiorespormateria=array_values($inferiorespormateria);
			$superiorespormateria=array_values($superiorespormateria);

			foreach($grupos as $grupo){
				if(!isset($reprobadosporgrupo[$grupo->getGrupoid()])){
					$reprobadosporgrupo[$grupo->getGrupoid()]=array("grupo"=>$grupo->getNombre(), "total"=>0);
				}
				if(!isset($inferioresporgrupo[$grupo->getGrupoid()])){
					$inferioresporgrupo[$grupo->getGrupoid()]=array("grupo"=>$grupo->getNombre(), "total"=>0);
				}
				if(!isset($superioresporgrupo[$grupo->getGrupoid()])){
					$superioresporgrupo[$grupo->getGrupoid()]=array("grupo"=>$grupo->getNombre(), "total"=>0);
				}
			}
			$reprobadosporgrupo=array_values($reprobadosporgrupo);
			$inferioresporgrupo=array_values($inferioresporgrupo);
			$superioresporgrupo=array_values($superioresporgrupo);
			foreach($grados as $gg){
				if((!isset($filtros["gradoid"])) || (isset($filtros["gradoid"]) && in_array($gg->getGradoid(), $filtros["gradoid"]))){
					$acumulado=null;
					$numbers = [];
					$acms = [];
					foreach($reprobadasacumuladasporgrado[$gg->getGradoid()] as $key=> $acum){
						$numbers[] = str_replace(" materias","", $key);
					}
					$max = max($numbers);

					for ($i=1; $i < $max+1; $i++) { 
						if($reprobadasacumuladasporgrado[$gg->getGradoid()][$i . " materias"]){
							$acms[$i . " materias"] = $reprobadasacumuladasporgrado[$gg->getGradoid()][$i . " materias"];
						}else{
							$acms[$i . " materias"] = ["nombre" => $i . " materias", "total" => 0];
						}
					}

					ksort($acms);

					foreach($acms as $key=> $acum){
						$acumulado[]=["nombre"=>$key, "total"=>$acum["total"]];
						$grado=$gg->getGrado();
						$nombre[$key]=$key;
					}
					array_multisort($nombre, SORT_ASC, $acumulado);

					$alumnosgrado[$gg->getGradoid()]=count($dbmce->BuscarAlumnosA([
						"gradoid"=> $gg->getGradoid(),
						"alumnoestatusid"=> 1
					]));
					
					$acumuladas[]=["grado"=>$gg->getGrado(), "alumnos"=>$alumnosgrado[$gg->getGradoid()], "acumulado"=>$acumulado];
				}
			}
			foreach($periodosids as $periodo){
				$gradospromedio=null;
				foreach($grados as $grado){
					$promediopg=number_format($promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio"] / $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["alumnos"], 2);
					if($promediopg== 0){
						$promediopg=null;
					}
					//$planestudio=$dbm->getOneByParametersRepositorio("CePlanestudios",["cicloinicialid"=>$filtros["cicloid"],"gradoid"=>$grado->getGradoid(),"vigente"=>1]);
					if($planestudio){
						//$materias=$dbm->getRepositoriosById("CeMateriaporplanestudios","planestudioid",$planestudio->getPlanestudioid());
						$mat=null;
						foreach($materias as $materia){
							$prmediopmgrado=number_format($promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio"] / $promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["alumnos"], 2);
							if($prmediopmgrado== 0){
								$prmediopmgrado=null;
							}
							$mat[]=[
									"materia"=>$materia->getMateriaid()->getNombre(),
									"promedio5"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio5"],
									"promedio6"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio6"],
									"promedio7"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio7"],
									"promedio8"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio8"],
									"promedio9"=>$promediopmgrado[$periodo."-".$materia->getMateriaid()->getMateriaid()."-".$grado->getGradoid()]["promedio9"],
									"promedio"=>$prmediopmgrado
							];
						}
					}
					$gradospromedio[]=[
							"grado"=>$grado->getGrado(),
							"promedio5"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio5"],
							"promedio6"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio6"],
							"promedio7"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio7"],
							"promedio8"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio8"],
							"promedio9"=>$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio9"],
							"promedio"=>$promediopg,
							"materias"=>$mat
					];
					${"promedio5total".$periodo}=${"promedio5total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio5"];
					${"promedio6total".$periodo}=${"promedio6total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio6"];
					${"promedio7total".$periodo}=${"promedio7total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio7"];
					${"promedio8total".$periodo}=${"promedio8total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio8"];
					${"promedio9total".$periodo}=${"promedio9total".$periodo} + $promedioperiodogrado[$periodo."-".$grado->getGradoid()]["promedio9"];
					if($promedioperiodogrado[$periodo."-".$grado->getGradoid()]["periodo"]){
						$pnombre=$promedioperiodogrado[$periodo."-".$grado->getGradoid()]["periodo"];
					}
				}
				$promediosperiodogrado[]=["periodoid"=>$periodo, "periodo"=>$pnombre, "grados"=>$gradospromedio];
			}

			foreach($promediosperiodogrado as &$periodo){
				$periodo["promedio5"]=${"promedio5total".$periodo["periodoid"]};
				$periodo["promedio6"]=${"promedio6total".$periodo["periodoid"]};
				$periodo["promedio7"]=${"promedio7total".$periodo["periodoid"]};
				$periodo["promedio8"]=${"promedio8total".$periodo["periodoid"]};
				$periodo["promedio9"]=${"promedio9total".$periodo["periodoid"]};
			}

			$reprobadasacumuladasporgrado=array_values($reprobadasacumuladasporgrado);

			$reprobadosxmateriafinal = [];
			$inferioresxmateriafinal = [];
			$superioresxmateriafinal = [];

			if(!$respuesta){
				return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
			}
			return new View([
					"configuracion"=>$configuracion,
					"encabezado"=>$encabezado,
					"calificaciones"=>$respuesta,
					"reprobadospormateria"=>$reprobadospormateria,
					"inferiorespormateria"=>$inferiorespormateria,
					"superiorespormateria"=>$superiorespormateria,
					"reprobadosporgrupo"=>$reprobadosporgrupo,
					"inferioresporgrupo"=>$inferioresporgrupo,
					"superioresporgrupo"=>$superioresporgrupo,
					"promediomateria"=>$promediomateria,
					"promediogrupo"=>$promediogrupo,
					"promediogrado"=>$promediogrado,
					"promedioperiodo"=>$promedioperiodo,
					"grupos"=>$grupos,
					"grados"=>$grados,
					"alumnosgrupo"=>$alumnosgrupo,
					"reprobadasacumuladasporgrado"=>$acumuladas,
					"promediosperiodogrado"=>$promediosperiodogrado,
					"puntopase" => $puntopase
				],Response::HTTP_OK);
			//return new View(["promediosperiodogrado"=>$promediosperiodogrado], Response::HTTP_OK);
		}catch(Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

	private function getCapturaAlumnoPeriodo($dbm,$kalumnociclo,$kperiodo){
		$icapturaalumno=$dbm->getCapturaAlumnoPeriodo($kalumnociclo,$kperiodo);
		$icatsolicitada=0;
		$icatentregada=0;
		$icatfaltantes=0;
		if($icapturaalumno){
			if($icapturaalumno['tareasolicitada'] && !empty($icapturaalumno['tareasolicitada'])){
				$icatsolicitada=(int)$icapturaalumno['tareasolicitada'];
			}
			if($icapturaalumno['tareaentregada'] && !empty($icapturaalumno['tareaentregada'])){
				$icatentregada=(int)$icapturaalumno['tareaentregada'];
			}
			$icatfaltantes=$icatsolicitada-$icatentregada;
		}
		return [
			"tareasolicitada"=>$icatsolicitada,
			"tareaentregada"=>$icatentregada,
			"tareafaltante"=>$icatfaltantes
		];
	}
	/**
	 * Obtiene los datos del criteria de evaluacion del grupo y los datos generales del alumno y las calificaciones de este (Carga inicial de captura de calificaciones)"
	 * @Rest\Get("/api/Reportes/Calificaciones/Descargar", name="CalificacionesDescargar")
	 */
	public function CalificacionesDescargar(){
		//*
		$resultRaw=$this->ReporteCalificaciones();
		$resultStatus=$resultRaw->getStatusCode();
		$dataRaw=$resultRaw->getData();
		//echo json_encode($dataRaw);exit;
		//*/
		/*
		$resultStatus=200;
		$dataRaw=json_decode('', true);
		//*/
		if($resultStatus==200){
			$normalTable=!($_REQUEST['tabla'] && $_REQUEST['tabla']==2);//True: Normal, False: Only Totals
			$institutoShort=(ENTORNO==2?"IDEC":"LUX");
			$ordMateriaSpan=10;
			$materias=$dataRaw['encabezado'];
			$alumnos=$dataRaw['calificaciones'];
			$this->CalificacionesDescargar_prepareAlumnos($alumnos);
			$botRel=[];
			$botfRel=[];
			$promRaw=$dataRaw['promedioperiodo'];
			foreach($alumnos AS $ialumno){
				$iaperiodos=$ialumno['periodos'];
				$kalumno=$ialumno['alumnoid'];
				$ialumnoname=$ialumno['nombrecompleto'];
				$ialumnomatricula=$ialumno['matricula'];
				$ialumnolista=$ialumno['numerolista'];
				$ialumnogroup=$ialumno['gruponombre'];
				$ordRec=0;
				$ordPeriodo=0;
				$ordMP=sizeof($iaperiodos)+1;
				$scoreMatRel=[];
				$irowname=$ialumnomatricula;
				$jtable[]=$this->buildJTableCell($kalumno, 0, 'Nombre', $irowname, $ialumnoname);
				$jtable[]=$this->buildJTableCell($kalumno, 1, 'Grupo', $irowname, $ialumnogroup);
				if($normalTable){
					$jtable[]=$this->buildJTableCell($kalumno, 2, 'No. Lista', $irowname, $ialumnolista);
				}
				foreach($iaperiodos AS $kiaperiodo=>$iaperiodo){
					$ordMateria=3;
					$iaperiodok=$iaperiodo["periodoevaluacionid"];
					$kaperiodo=$iaperiodo['descripcioncorta'];
					$iaperiodoname=$iaperiodo['descripcioncorta'];
					$iapmaterias=$iaperiodo['calificaciones'];
					foreach($materias AS $imateria){
						$kmateria=$imateria['materiaid'];
						$imaterianame=$imateria['materia'];
						$score="-";
						if(!isset($botRel[$kaperiodo])){
							$botRel[$kaperiodo]=[];
						}
						if(!isset($botRel[$kaperiodo][$kmateria])){
							$botRel[$kaperiodo][$kmateria]=true;
							$prommats=$promRaw[$kiaperiodo]['materias'];
							$kprommat=array_search($kmateria,array_column($prommats,'materiaid'));
							if($kprommat!==false){
								$iprommat=$prommats[$kprommat];
								$ipmprf=$iprommat['promediofinal'];
								$ipmpro=$iprommat['promedio'];
								$ipmrep=$iprommat['reprobados'];
								$ipminf=$iprommat['inferiores'];
								$ipmsup=$iprommat['superiores'];
								if(!isset($botfRel[$kmateria])){
									$botfRel[$kmateria]=[[$ordMateria,$imaterianame],$ipmprf,0,0,0];
								}
								$botfRel[$kmateria][2]+=$ipmrep;
								$botfRel[$kmateria][3]+=$ipminf;
								$botfRel[$kmateria][4]+=$ipmsup;
								if($normalTable) {
									$jtable[]=$this->buildJTableCell(200001, $ordMateria+$ordPeriodo, $imaterianame, "Promedios", ($ipmpro ? $ipmpro : '0'), $iaperiodoname, 1);
									$ipmrep = $dataRaw['repmat'][$imaterianame][$iaperiodoname]['total'];
									$jtable[]=$this->buildJTableCell(200002, $ordMateria+$ordPeriodo, $imaterianame, "Reprobadas", ($ipmrep ? $ipmrep : '0'), $iaperiodoname, 2);
									$jtable[]=$this->buildJTableCell(200003, $ordMateria+$ordPeriodo, $imaterianame, "Promedio < 8", ($ipminf ? $ipminf : '0'), $iaperiodoname, 3);
									$jtable[]=$this->buildJTableCell(200004, $ordMateria+$ordPeriodo, $imaterianame, "Promedio > 9", ($ipmsup ? $ipmsup : '0'), $iaperiodoname, 4);
								}
							}
						}
						if(isset($iapmaterias[$kmateria])){
							$scoreperiodo=$iapmaterias[$kmateria];
							$scoresrec=$scoreperiodo["recuperaciones"];
							$scoreRaw=($scoreperiodo['calificacionperiodo'] ? $scoreperiodo['calificacionperiodo'] : $scoreperiodo['ponderacionopcion']);
							$scoreFinalRaw=$scoreperiodo['calificacionfinal'];
							$score=($scoreRaw ? $scoreRaw : '0');
							if($normalTable){
								$jtable[]=$this->buildJTableCell($kalumno, $ordMateria+$ordPeriodo, $imaterianame, $irowname, $score, $iaperiodoname);
								if($scoresrec){
									$iscorerec=$scoresrec[0];
									$jtable[]=$this->buildJTableCell($kalumno, $ordMateria+$ordPeriodo+$ordMP+1, $imaterianame, $irowname, $iscorerec["calificacion"], "$iaperiodoname(R)");
								}
							}
							if(!isset($scoreMatRel[$kmateria])){
								$scoreMatRel[$kmateria]=true;
								$scoreFinal=($scoreFinalRaw ? $scoreFinalRaw : '');
								$jtable[]=$this->buildJTableCell($kalumno, $ordMateria+$ordMateriaSpan-1, $imaterianame, $irowname, $scoreFinal, "PROM");
							}
						}
						$ordMateria+=$ordMateriaSpan;
					}
					$ordPeriodo++;
				}
				
				if(isset($ialumno['IDEC'])){
					//$jtable[]=$this->buildJTableCell($kalumno, 100000, $institutoShort, $irowname, $ialumno['IDEC']);
					if($normalTable && !empty($ialumno['promedios'])){
						$ordPromedio2s=120000;
						foreach($ialumno['promedios'] AS $iappromedio){
							$jtable[]=$this->buildJTableCell($kalumno, $ordPromedio2s, $institutoShort, $irowname, $iappromedio['promedio'], $iappromedio['periodo']);
							$ordPromedio2s++;
						}
						$jtable[]=$this->buildJTableCell($kalumno, $ordPromedio2s, $institutoShort, $irowname, $ialumno['IDEC'], "PROM");
					}
				}
				if(isset($ialumno['SEP'])){
					//$jtable[]=$this->buildJTableCell($kalumno, 100001, "SEP", $irowname, $ialumno['SEP']);
					if($normalTable && !empty($ialumno['promedios'])){
						$ordPromedio3s=130000;
						foreach($ialumno['promedios'] AS $iappromedio){
							$jtable[]=$this->buildJTableCell($kalumno, $ordPromedio3s, "SEP", $irowname, $iappromedio['promediosep'], $iappromedio['periodo']);
							$ordPromedio3s++;
						}
						$jtable[]=$this->buildJTableCell($kalumno, $ordPromedio3s, "SEP", $irowname, $ialumno['SEP'], "PROM");
					}
				}
				//$jtable[]=$this->buildJTableCell($kalumno, 100002, "Reprobadas", $irowname, (isset($ialumno['reprobadas']) ? $ialumno['reprobadas'] : '0'));
				if($normalTable && !empty($ialumno['promedios'])){
					$ordPromedio4s=140000;
					foreach($ialumno['promedios'] AS $iappromedio){
						$jtable[]=$this->buildJTableCell($kalumno, $ordPromedio4s, "Reprobadas", $irowname, $iappromedio['reprobadas'], $iappromedio['periodo']);
						$ordPromedio4s++;
					}
					$jtable[]=$this->buildJTableCell($kalumno, $ordPromedio4s, "Reprobadas", $irowname, (isset($ialumno['reprobadas']) ? $ialumno['reprobadas'] : '0'), "Total");
				}
				/*if($normalTable && !empty($ialumno['promedios'])){
					$ordPromedios=110000;
					foreach($ialumno['promedios'] AS $iappromedio){
						$jtable[]=$this->buildJTableCell($kalumno, $ordPromedios, "Promedios", $irowname, $iappromedio['promedio'], $iappromedio['periodo']);
						$ordPromedios++;
					}
				}*/
				//$jtable[]=$this->buildJTableCell($kalumno, 119999, "Promedios", $irowname, $ialumno['promediogeneral'], "Promedio gral");
			}
			foreach($botfRel AS $ibotraw){
				list($ibotdata,$improm,$imrep,$iminf,$imsup)=$ibotraw;
				list($imord,$imname)=$ibotdata;
				$iord=$imord+$ordMateriaSpan-1;
				$jtable[]=$this->buildJTableCell(200001, $iord, $imname, "Promedios", ($improm ? $improm : '0'), "PROM", 1);
				$jtable[]=$this->buildJTableCell(200001, $iord, $imname, "Reprobadas", ($imrep ? $imrep : '0'), "PROM", 2);
				$jtable[]=$this->buildJTableCell(200001, $iord, $imname, "Promedio < 8", ($iminf ? $iminf : '0'), "PROM", 3);
				$jtable[]=$this->buildJTableCell(200001, $iord, $imname, "Promedio > 9", ($imsup ? $imsup : '0'), "PROM", 4);
			}

			$promsF =[
				'sep' => [],
				'int' => [],
				'rep' => [],
				'periodo' => []
			];

			foreach($alumnos as $ialumno){
				if(isset($ialumno['IDEC'])){
					//$jtable[]=$this->buildJTableCell($kalumno, 100000, $institutoShort, $irowname, $ialumno['IDEC']);
					if($normalTable && !empty($ialumno['promedios'])){
						$ip = 0;
						foreach($ialumno['promedios'] AS $iappromedio){
							$promsF['int'][$ip] += $iappromedio['promedio'];
							$promsF['sep'][$ip] += $iappromedio['promediosep'];
							$promsF['rep'][$ip] += $iappromedio['reprobadas'];
							$promsF['periodo'][] = $iappromedio['periodo'];
							$ip++;
						}
						$promsF['int'][$ip] += $ialumno['IDEC'];
						$promsF['sep'][$ip] += $ialumno['SEP'];
						$promsF['rep'][$ip] += (isset($ialumno['reprobadas']) ? $ialumno['reprobadas'] : '0');
						$promsF['periodo'][] = 'PROM';
					}
				}
			}

			$ordPromedio5s=1 ;
			foreach($promsF['int'] AS $iappromedio){
				$jtable[]=$this->buildJTableCell(200002, $ordPromedio5s, $institutoShort, "Promedios", number_format($iappromedio/count($alumnos),1), $promsF['periodo'][$ordPromedio5s-1], 1);
				$ordPromedio5s++;
			}
			
			$ordPromedio7s=1 ;
			foreach($promsF['sep'] AS $iappromedio){
				$jtable[]=$this->buildJTableCell(200002, $ordPromedio7s, "SEP", "Promedios", number_format($iappromedio/count($alumnos),1), $promsF['periodo'][$ordPromedio7s-1], 1);
				$ordPromedio7s++;
			}

			$ordPromedio6s=1 ;
			foreach($promsF['rep'] AS $iappromedio){
				if($promsF['periodo'][$ordPromedio6s-1] == 'PROM'){
					$jtable[]=$this->buildJTableCell(200002, $ordPromedio6s, "Reprobadas", "Reprobadas", $iappromedio, 'Total', 1);
				}else{

					$jtable[]=$this->buildJTableCell(200002, $ordPromedio6s, "Reprobadas", "Reprobadas", $iappromedio, $promsF['periodo'][$ordPromedio6s-1], 1);
				}
				$ordPromedio6s++;
			}

			$this->fnDescargarJTablePrepare($jtable);
			usort($jtable, "AppBundle\Controller\Reportes\CalificacionesController::fnDescargarJTable");
			$this->fnDescargarJTableFinish($jtable);

			$result=[
					"header"=>[
						"ciclo"=>"",
						"nivel"=>""
					],
					"score"=>$jtable
			];

			$done=false;
			$name="R".rand();
			$report="ReporteCalificaciones";
			$input=$output="ReporteCalificaciones_$name";

			$pdf=new LDPDF($this->container, $report, $output, array('driver'=>'json', 'json_query'=>'""', 'data_file'=>$input), [], ['xlsx']);
			$inputPath=$pdf->fdb_r;
			$outputPath=$pdf->output_r;

			$resultenc=json_encode($result);
			$file=LDPDF::fileRead($inputPath);
			LDPDF::fileWrite($file, $resultenc);
			LDPDF::fileRelease($file);
			$toremove=[$inputPath];

			if(!$pdf->execute()){
				$toremove[]=$outputPath;
				$done=true;
			}

			$reporteSize=filesize($outputPath);
			$reporte=file_get_contents($outputPath);
			foreach($toremove as $i){
				LDPDF::fileDelete($i);
			}
			return ($done ? new Response($reporte, 200, [
					'Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
					'Content-Length'=>$reporteSize
				]) : Api::Error(Response::HTTP_PARTIAL_CONTENT, "La impresion no esta disponible."));
		}
		return new View($dataRaw, $resultStatus);
	}

	private function CalificacionesDescargar_prepareAlumnos(&$alumnos){
		self::$AlumnosRel=[];
		foreach($alumnos AS &$ialumno){
			$kalumno=$ialumno['alumnoid'];
			$iaperiodos=&$ialumno['periodos'];
			foreach($iaperiodos AS &$iaperiodo){
				$iapmaterias=[];
				foreach($iaperiodo['calificaciones'] AS $imateria){
					$iapmaterias[$imateria['materiaid']]=$imateria;
				}
				$iaperiodo['calificaciones']=$iapmaterias;
			}
			self::$AlumnosRel[$kalumno]=$ialumno;
		}
	}
	private function buildJTableCell($kalumno ,$ord, $col, $row, $val, $col1="", $ordy=0){
		return [
			"key"=>$kalumno,
			"ord"=>(int)$ord,
			"ordy"=>(int)$ordy,
			"row"=>$row,
			"col"=>$col,
			"col1"=>$col1,
			"val"=>$val
		];
	}
	private function fnDescargarJTablePrepare(&$alumnos){
		foreach($alumnos AS &$ialumno){
			$ialumno['rel']=self::$AlumnosRel[$ialumno['key']];
		}
	}
	private function fnDescargarJTableFinish(&$alumnos){
		foreach($alumnos AS &$ialumno){
			unset($ialumno['rel']);
		}
	}
	private function inarray($array, $name, $val) {
		foreach ($array as $key => $value) {
			if($value[$name] == $val) {
				return $value;
			}
		}
		return false;
	}
	public static function fnDescargarJTable($a,$b){
		$result=$a['ordy']<=>$b['ordy'];
		if($result==0){
			$result=$a['ord']<=>$b['ord'];
			if($result==0){
				$ar=$a['rel'];
				$br=$b['rel'];
				$result=$ar['gruponombre']<=>$br['gruponombre'];
				if($result==0){
					$result=$ar['numerolista']<=>$br['numerolista'];
					if($result==0){
						$result=$ar['matricula']<=>$br['matricula'];
					}
				}
			}
		}
		return $result;
	}
	public static function fnMateriaOrden($a,$b){
		$aa=(int)$a->getOrdeninterno();
		$bb=(int)$b->getOrdeninterno();
		return ($aa<$bb ? -1 : 1);
	}
}
