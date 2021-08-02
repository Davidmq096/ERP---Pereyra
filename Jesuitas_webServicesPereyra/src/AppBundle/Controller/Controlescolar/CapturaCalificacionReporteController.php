<?php
namespace AppBundle\Controller\Controlescolar;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;

/**
 * Autor: Emmanuel Martinez
 */
class CapturaCalificacionReporteController extends FOSRestController{
	private static $CALEVAL=5;
	private $DBM=false;

	/**
	 * @Annotations\Get("/api/Controlescolar/CapturaCalificacionReporte/Calificaciones/{isgrupo}/{kgruporaw}/{kppmpe}", name="getReporteDGBCalificacionesByGrupo")
	 */
	public function getReporteDGBCalificacionesByGrupo($isgrupo, $kgruporaw,$kppmpe){
		$kgrupo=(int)$kgruporaw;
		$isgrupo = $isgrupo == "true" ? true : false;
		if($kgrupo && $kgrupo>0){
			$dbm=$this->getDM();
			$ppmperaw=$dbm->getBIMateriasDataRawByAOG($kgrupo,["isgrupo"=>true,"ppmpeid"=>$kppmpe])[0];
			if($isgrupo) {
				$igrupo=$this->getGrupoById($dbm,$kgrupo);
			} else {
				$igrupo=$this->getTallerById($dbm,$kgrupo);
			}
			$kgrado=$igrupo['gradoid'];
			$igrado=$this->getGradoById($dbm, $kgrado);
			$kciclo=$igrupo['cicloid'];
			$knivel=$igrado['nivelid'];
			$kmateria=$ppmperaw['materiaid'];
			$iciclo=$this->getCicloById($dbm, $kciclo);
			$inivel=$this->getNivelById($dbm, $knivel);
			$materia=$this->getMateriaById($dbm,$kmateria);
			$criterioscount=0;
			$criterioscountr=[];
			$criterioslist=[];
			$calificaciones=[];
			if($isgrupo) {
				$alumnoscicloraw=$this->getAlumnocicloByGrupo($dbm,$kgrupo);

			} else {
				$alumnoscicloraw = $dbm->AlumnoCicloGrupo($kciclo, $kgrupo, $alumnoidr, true, true);

			}
			list($promediable,$periodosraw)=$dbm->getBIPeriodoEvaluacionByCicloGrado($kciclo,$kgrado);
			foreach($alumnoscicloraw AS $ialumnociclo){
				$kalumnociclo=$ialumnociclo['alumnoporcicloid'];
				$iacnolista=$ialumnociclo['numerolista'];
				$dataraw=self::getCCRCalificacionesProcessByAlumnociclo($dbm,$kalumnociclo,["profesorpormateriaplanestudioid"=>$kppmpe]);
				$materias=$dataraw["materias"];
				$calificacionesRaw=$dataraw["scores"];
				foreach($periodosraw AS $iperiodo){
					$kperiodo=$iperiodo['id'];
					$kperiodomid="pm_$kperiodo";
					$ipcalificaciones=($calificacionesRaw[$kperiodo] ? $calificacionesRaw[$kperiodo] : []);
					$ipmccal="";
					$ipmccalf="";
					$icritseval=[];
					$ipmccalsum=0;
					if(isset($materias[0])){
						$iord=0;
						$ipmcal=($ipcalificaciones[$kmateria] ? $ipcalificaciones[$kmateria] : []);
						$ipmccrit=$ipmcal['criterios'];
						$ipmccal=trim($ipmcal['calificacion']);
						$ipmccalf=trim($ipmcal['finalcalificacion']);
						foreach($ipmccrit AS &$iipmccrit){
							$kipmccrit=$iipmccrit['criterioevaluaciongrupoid'];
							$ipmcname=$iipmccrit['aspecto'];
							$ipmccperce=$iipmccrit['porcentajecalificacion'];
							$ipmccmax=$iipmccrit['puntajemaximo'];
							if(!isset($criterioscountr[$kipmccrit])){
								$tid=++$criterioscount;
								$criterioscountr[$kipmccrit]=$tid;
								$criterioslist[]=[
									"alias"=>$tid,
									"nombre"=>$ipmcname,
									"porcentaje"=>$ipmccperce,
									"finperiodo"=>false
								];
							}
							$iipmccritid=$criterioscountr[$kipmccrit];
							$iipmcccapturas=$iipmccrit['capturas'];
							$iipmcccalsum=0;
							$iccal=$iipmccrit['calificacion'];
							foreach($iccal AS &$iiccal){
								$iipmcccalsum+=((double)$iiccal['calificacion']);
								unset($iiccal);
							}
							$iipmcccal=$iipmcccalsum/$iipmcccapturas;
							$iipmcccalfraw=$iipmcccal*$ipmccperce/$ipmccmax/10;
							$iipmcccalf=$this->fn1DecNumber($iipmcccalfraw);
							$ipmccalsum+=$iipmcccalf;
							$icritseval[]=[$iord, $ipmccperce/10, $iipmcccalf, $iipmccritid];
							//$calificaciones[]=$this->fnJDataDGBCalificacionesMain($iipmccritid, $iacnolista, $ialumnociclo, $iipmccritid, $iipmcccalf);
							$iord++;
							unset($iipmccrit);
						}
					}
					$ipmccaldif=$ipmccal-$ipmccalsum;
					usort($icritseval, "AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController::fnOrdDGBCalificacionesAjusteA");
					foreach($icritseval AS &$iicritseval){
						list($iord, $ipmccperce, $iipmcccalf)=$iicritseval;
						if($ipmccaldif!=0){
							$inval=$iipmcccalf+$ipmccaldif;
							if($inval<0){
								$ipmccaldif=$inval;
								$inval=0;
							}else if($inval>$ipmccperce){
								$ipmccaldif=$inval-$ipmccperce;
								$inval=$ipmccperce;
							}else{
								$ipmccaldif=0;
							}
							$iicritseval[2]="$inval";
						}
						unset($iicritseval);
					}
					usort($icritseval, "AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController::fnOrdDGBCalificacionesAjusteB");
					foreach($icritseval AS $iicritseval){
						list($iord, $ipmccperce, $iipmcccalf, $iipmccritid)=$iicritseval;
						$calificaciones[]=$this->fnJDataDGBCalificacionesMain($iipmccritid, $iacnolista, $ialumnociclo, $iipmccritid, $iipmcccalf);
					}
					if(!isset($criterioscountr[$kperiodomid])){
						$tid=++$criterioscount;
						$criterioscountr[$kperiodomid]=$tid;
						$criterioslist[]=[
							"alias"=>$tid,
							"nombre"=>"Final",
							"porcentaje"=>"100",
							"finperiodo"=>true
						];
					}
					$iperiodomid=$criterioscountr[$kperiodomid];
					$calificaciones[]=$this->fnJDataDGBCalificacionesMain($iperiodomid, $iacnolista, $ialumnociclo, $iperiodomid, $ipmccal, null, true);
					unset($iperiodo);
				}
				$calificaciones[]=$this->fnJDataDGBCalificacionesMain(999999, $iacnolista, $ialumnociclo, "", $ipmccalf,"CALIF. SEM. FINAL");
			}
			$head=[
					"ciclo"=>$iciclo['nombre'],
					"nivel"=>$inivel['nombre'],
					"semestre"=>$igrado['semestre'],
					"grado"=>$igrado['nombre'],
					"grupo"=>$igrupo['nombre'],
					"materia"=>$materia['nombre'],
					"profesor"=>$ppmperaw['profesor']
			];
			usort($calificaciones, "AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController::fnOrdDGBCalificacionesMain");
			$done=false;
			$name="R".rand();
			$report="DGBCalificaciones";
			$input=$output="{$report}_$name";

			$pdf=new LDPDF($this->container, $report, $output, array('driver'=>'jsonql', 'jsonql_query'=>'""', 'data_file'=>$input), [], ['xlsx']);
			$inputPath=$pdf->fdb_r;
			$outputPath=$pdf->output_r;

			$resultenc=json_encode(["head"=>$head,"criterios"=>$criterioslist,"data"=>$calificaciones]);
			$file=LDPDF::fileRead($inputPath);
			LDPDF::fileWrite($file, $resultenc);
			LDPDF::fileClose($file);
			unset($file);
			$toremove=[$inputPath];
			if(!$pdf->execute()){
				$toremove[]=$outputPath;
				$done=true;
			}

			$reporteSize=filesize($outputPath);
			$reporte=file_get_contents($outputPath);
			foreach($toremove AS $i){
				LDPDF::fileDelete($i);
			}

			return ($done
					? new Response($reporte, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
            'Content-Length' => $reporteSize
					])
					: Api::Error(Response::HTTP_PARTIAL_CONTENT, "La impresion no esta disponible.")
			);
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, "Petición incorrecta.");
	}
	public static function fnOrdDGBCalificacionesAjusteA($a,$b){ return $b[1]<=>$a[1]; }
	public static function fnOrdDGBCalificacionesAjusteB($a,$b){ return $a[0]<=>$b[0]; }
	public static function fnOrdDGBCalificacionesMain($a,$b){
		$result=$a['ordx']<=>$b['ordx'];
		if($result==0){
			$result=$a['ordy']<=>$b['ordy'];
		}
		return $result;
	}
	private function fnJDataDGBCalificacionesMain($x,$y,$alumno,$alias,$data,$title=null,$finperiodo=false){
		return [
				"ordx"=>$x,
				"ordy"=>$y,
				"nolista"=>$alumno['numerolista'],
				"alumno"=>$alumno['nombre'],
				"alias"=>"$alias",
				"data"=>$data,
				"titulo"=>$title,
				"finperiodo"=>$finperiodo
		];
	}
	private function fn1DecNumber($valueraw){
		$result="$valueraw";
		$dot=strpos($result, ".");
		if($dot){
			$result=substr($result,0,$dot+2);
		}
		return $result;
	}


	/**
	 * @Annotations\Get("/api/Controlescolar/CapturaCalificacionReporte/Faltas/{isgrupo}/{kgruporaw}/{kppmpe}", name="getReporteUltimasFaltasByGrupo")
	 */
	public function getReporteUltimasFaltasByGrupo($isgrupo, $kgruporaw,$kppmpe){
		$kgrupo=(int)$kgruporaw;
		$isgrupo = $isgrupo == "true" ? true : false;
		if($kgrupo && $kgrupo>0){
			$dbm=$this->getDM();
			$data=[];
			$ppmperaw=$dbm->getBIMateriasDataRawByAOG($kgrupo,["isgrupo"=>true,"ppmpeid"=>$kppmpe])[0];
			if($isgrupo) {
				$igrupo=$this->getGrupoById($dbm,$kgrupo);
			} else {
				$igrupo=$this->getTallerById($dbm,$kgrupo);
			}
			$kgrado=$igrupo['gradoid'];
			$igrado=$this->getGradoById($dbm, $kgrado);
			$kciclo=$igrupo['cicloid'];
			$knivel=$igrado['nivelid'];
			$kmateria=$ppmperaw['materiaid'];
			$iciclo=$this->getCicloById($dbm, $kciclo);
			$inivel=$this->getNivelById($dbm, $knivel);
			$imateria=$this->getMateriaById($dbm,$kmateria);
			$head=[
					"ciclo"=>$iciclo['nombre'],
					"nivel"=>$inivel['nombre'],
					"semestre"=>$igrado['semestre'],
					"grado"=>$igrado['nombre'],
					"grupo"=>$igrupo['nombre'],
					"materia"=>$imateria['nombre'],
					"profesor"=>$ppmperaw['profesor']
			];
			list($promediable,$periodoraw)=$dbm->getBIPeriodoEvaluacionByCicloGrado($kciclo,$kgrado);
			$tsmin=null;
			$tsmax=null;
			foreach($periodoraw AS $iperiodo){
				$itsmin=$iperiodo['fechainicio']->getTimestamp();
				$itsmax=$iperiodo['fechafin']->getTimestamp();
				if(!$tsmin || $tsmin>$itsmin){ $tsmin=$itsmin; }
				if(!$tsmax || $tsmax<$itsmax){ $tsmax=$itsmax; }
			}
			$clasedatesraw=$this->getDiasClaseByGrupoProfesorpormateriaplanestudios($dbm,$kgrupo,$kppmpe,$tsmin,$tsmax);
			$clasesdatefirst=$clasedatesraw[0][1];
			foreach($clasedatesraw AS $iclasedate){
				list($its,$idate)=$iclasedate;
				$data[]=$this->fnJDataUltimasFaltas($its, 999999, ["matricula"=>"","nombre"=>"","numerolista"=>""], $idate, false);
			}
			$kalumnosciclo=[];
			$ralumnosciclo=[];
			if($isgrupo) {
				$alumnoscicloraw=$this->getAlumnocicloByGrupo($dbm,$kgrupo);

			} else {
				$alumnoscicloraw = $dbm->AlumnoCicloGrupo($kciclo, $kgrupo, $alumnoidr, true, true);

			}
			foreach($alumnoscicloraw AS &$ialumnociclo){
				$kalumnociclo=$ialumnociclo['alumnoporcicloid'];
				$ralumnosciclo[$kalumnociclo]=&$ialumnociclo;
				$kalumnosciclo[]=$kalumnociclo;
				$iacnolista=(int)$ialumnociclo['numerolista'];
				$data[]=$this->fnJDataUltimasFaltas(9999999999, $iacnolista, $ialumnociclo, $clasesdatefirst, false);
				unset($ialumnociclo);
			}
			$utcdate=new \DateTime("now",new \DateTimeZone("UTC"));
			$faltasraw=$this->getFaltasByAlumnocicloProfesorpormateriaplanestudios($dbm,$kalumnosciclo,$kppmpe);
			foreach($faltasraw AS $ifalta){
				$kfalumnociclo=$ifalta['alumnoporcicloid'];
				$ifalumnociclo=$ralumnosciclo[$kfalumnociclo];
				$ifacnolista=(int)$ifalumnociclo['numerolista'];
				$ifdateraw=$ifalta["fecha"];
				$iftimeraw=$ifalta["hora"];
				$iftz=$iftimeraw->getTimezone();
				$ifdts=$ifdateraw->getTimestamp();
				$iftts=$iftimeraw->getTimestamp();
				$ifoffset=$iftz->getOffset($utcdate);
				$ifts=$ifdts+$iftts;
				$ifdate=$this->fnFormatDateUltimasFaltas($ifts+$ifoffset);//date("d-M-Y H:i",$ifts+$ifoffset);
				$data[]=$this->fnJDataUltimasFaltas($ifts, $ifacnolista, $ifalumnociclo, $ifdate);
			}
			usort($data, "AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController::fnOrdUltimasFaltas");
			$done=false;
			$name="R".rand();
			$report="DGBAsistencia";
			$input=$output="{$report}_$name";

			$pdf=new LDPDF($this->container, $report, $output, array('driver'=>'jsonql', 'jsonql_query'=>'""', 'data_file'=>$input), [], ['xlsx']);
			$inputPath=$pdf->fdb_r;
			$outputPath=$pdf->output_r;

			$resultenc=json_encode(["head"=>$head,"data"=>$data]);
			$file=LDPDF::fileRead($inputPath);
			LDPDF::fileWrite($file, $resultenc);
			LDPDF::fileClose($file);
			unset($file);
			$toremove=[$inputPath];
			if(!$pdf->execute()){
				$toremove[]=$outputPath;
				$done=true;
			}

			$reporteSize=filesize($outputPath);
			$reporte=file_get_contents($outputPath);
			foreach($toremove AS $i){
				LDPDF::fileDelete($i);
			}

			return ($done
					? new Response($reporte, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
            'Content-Length' => $reporteSize
					])
					: Api::Error(Response::HTTP_PARTIAL_CONTENT, "La impresion no esta disponible.")
			);
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, "Petición incorrecta.");
	}
	private function fnFormatDateUltimasFaltas($utime){
		$months=["","ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"];
		$month=(int)date("n",$utime);
		$monthname=$months[$month];
		return str_replace("---", "-$monthname-", date("d---Y H:i",$utime));
	}
	private function fnJDataUltimasFaltas($x,$y,$alumno,$date,$data=true){
		return [
				"ordx"=>$x,
				"ordy"=>$y,
				"matricula"=>$alumno['matricula'],
				"nolista"=>$alumno['numerolista'],
				"alumno"=>$alumno['nombre'],
				"fecha"=>$date,
				"data"=>$data
		];
	}
	public static function fnOrdUltimasFaltas($a,$b){
		$result=$a['data']<=>$b['data'];
		if($result==0){
			$result=$a['ordy']<=>$b['ordy'];
			if($result==0){
				$result=$a['ordx']<=>$b['ordx'];
			}
		}
		return $result;
	}
	private function getCicloById($dbm,$kciclo){
		return $dbm->getRepositoriosModelo("Ciclo", ["d.nombre"], ["cicloid"=>$kciclo])[0];
	}
	private function getNivelById($dbm,$knivel){
		return $dbm->getRepositoriosModelo("Nivel", ["d.nombre"], ["nivelid"=>$knivel])[0];
	}
	private function getMateriaById($dbm,$kmateria){
		return $dbm->getRepositoriosModelo("Materia", ["d.nombre"], ["materiaid"=>$kmateria])[0];
	}
	private function getGradoById($dbm,$kgrado){
		return $dbm->getRepositoriosModelo("Grado", ["IDENTITY(d.nivelid) AS nivelid","d.grado AS nombre","cs.nombre AS semestre"], ["gradoid"=>$kgrado], false, false, [[
				"entidad"=>"CeSemestre",
				"alias"=>"cs",
				"left"=>true,
				"on"=>"cs.semestreid=d.semestreid"
			]])[0];
	}
	private function getGrupoById($dbm,$kgrupo){
		return $dbm->getRepositoriosModelo("CeGrupo",["IDENTITY(d.cicloid) AS cicloid","IDENTITY(d.gradoid) AS gradoid","d.nombre"],["grupoid"=>$kgrupo])[0];
	}
	private function getTallerById($dbm,$ktaller){
		return $dbm->getRepositoriosModelo("CeTallercurricular", ["IDENTITY(d.cicloid) AS cicloid","IDENTITY(cs.gradoid) AS gradoid","d.nombre"], ["tallercurricularid"=>$ktaller], false, false, [
			[
				"entidad"=>"CeGradoportallercurricular",
				"alias"=>"cs",
				"left"=>true,
				"on"=>"cs.tallercurricularid=d.tallercurricularid"
			]
			])[0];
	}
	private function getAlumnocicloByGrupo($dbm,$kgrupo){
		return $dbm->getRepositoriosModelo("CeAlumnocicloporgrupo",[
				"IDENTITY(d.alumnoporcicloid) AS alumnoporcicloid",
				"d.numerolista",
				"a.matricula",
				"CONCAT_WS(' ',a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) AS nombre"
			],["grupoid"=>$kgrupo],false,false,[[
				"entidad"=>"CeAlumnoporciclo",
				"alias"=>"cac",
				"on"=>"cac.alumnoporcicloid=d.alumnoporcicloid"
			],[
				"entidad"=>"CeAlumno",
				"alias"=>"a",
				"on"=>"a.alumnoid=cac.alumnoid and a.alumnoestatusid = 1"
			]]);
	}
	private function getHorariosByGrupo($dbm,$kgrupo,$kppmpe){
		$grupos=$dbm->getBISubgruposByGrupo($kgrupo);
		$kgrupos=[$kgrupo];
		foreach($grupos AS $igrupo){
			$kgrupos[]=$igrupo["grupoid"];
		}
		return $dbm->getRepositoriosModelo("CeHorario",[
				"d.horarioid",
				"IDENTITY(d.profesorpormateriaplanestudiosid) AS profesorpormateriaplanestudioid",
				"d.dia",
				"d.horainicio",
				"d.horafin",
				"d.salon"
			],["profesorpormateriaplanestudiosid"=>$kppmpe]);
	}
	private function getFaltasByAlumnocicloProfesorpormateriaplanestudios($dbm,$kalumnosciclo,$kppmpe){
		return $dbm->getRepositoriosModelo("CeAsistencia",
			[
				"IDENTITY(d.alumnoporcicloid) AS alumnoporcicloid",
				"d.fecha",
				"d.hora"
			],[
				"alumnoporcicloid"=>$kalumnosciclo,
				"profesorpormateriaplanestudioid"=>$kppmpe,
				"tipoasistenciaid"=>2,
				"estatusinasistenciaid"=>1
			]);
	}
	private function getDiasClaseByGrupoProfesorpormateriaplanestudios($dbm,$kgrupo,$kppmpe,$tsmin,$tsmax){
		$tzlocal=null;
		$tzoffset=0;
		$onehour=3600;
		$oneday=86400;
		$oneweek=604800;
		$horariosraw=$this->getHorariosByGrupo($dbm,$kgrupo,$kppmpe);
		$horarios=[];
		$clasesdatets=[];
		for($i=0;$i<7;$i++){ $horarios[$i]=[[],0]; }
		foreach($horariosraw AS $ihorarioraw){
			$ihinicio=$ihorarioraw['horainicio'];
			if(!$tzlocal){
				$tzlocal=$ihinicio->getTimezone();
				$tzoffset=$tzlocal->getOffset($ihinicio);
			}
			$horarios[$ihorarioraw['dia']][0][]=$ihinicio->getTimestamp()+$tzoffset;
		}
		$its=$tsmin;
		$itsday=(int)date("w",$its);
		for($i=0;$i<7;$i++,$its+=$oneday,$itsday++){
			$jtsday=$itsday%7;
			$horarios[$jtsday][1]=$its;
		}
		foreach($horarios AS $ihorario){
			list($ihoras,$its)=$ihorario;
			if($ihoras){
				while($its<$tsmax){
					$mindst=(int)date("I",$its);
					$dstadjust=($mindst ? 0 : $onehour);
					$itsready=$its+$dstadjust;
					foreach($ihoras AS $ihora){
						$jts=$itsready+$ihora;
						//echo date("d-m-Y H:i",$jts).PHP_EOL;
						$clasesdatets[]=$jts;
					}
					$its+=$oneweek;
				}
			}
		}
		//usort($clasesdate, "AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController::fnDiasClaseOrd");
		sort($clasesdatets);
		$clasesdate=[];
		foreach($clasesdatets AS $its){
			$clasesdate[]=[$its,$this->fnFormatDateUltimasFaltas($its)];
		}
		return $clasesdate;
	}
	
	
	
	
	public static function getPromedioFinalByAlumnociclo($dbm, $kalumnoporciclo){
		$dataRaw=$dbm->BuscarAlumnosA(['alumnoporcicloid'=>$kalumnoporciclo]);
		$data=$dataRaw[0];
		if($dataRaw && $data && $data['grupoid'] && $data['alumnoid'] && $data['alumnoporcicloid']){
			$now=new \DateTime();
			$fechacheckid="fechapublicacionprevia";
			$periodosRel=[];
			$periodosVis=[];
			$profesormppe=[];
			$cicloid=$data['cicloid'];
			$gradoid=$data['gradoid'];
			$isLux=ENTORNO==1;
			$summat = 0;
			$promsummat = 0;
			$resumenmat = [];
			$resumenmatcurricular = [];
			
			$periodoData=$dbm->getBIPeriodoEvaluacionByCicloGrado($cicloid, $gradoid);
			if(!$periodoData){
				return false;
			}
			list($promediable, $periodosRaw)=$periodoData;
			foreach($periodosRaw AS &$irperiodo){
				$irperiodo['id']=(int) $irperiodo['id'];
				$periodosRel[$irperiodo['id']]=$irperiodo;
				$irperiodo['visible']=[true, false, false];
				if($now>= $irperiodo[$fechacheckid]){
					$periodosVis[]=$irperiodo;
				}
				if($now>= $irperiodo["fechapublicacionprevia"]){
					$irperiodo['visible'][1]=true;
				}
				if($now>= $irperiodo["fechapublicaciondefinitiva"]){
					$irperiodo['visible'][2]=true;
				}
				unset($irperiodo);
			}

			$materiapeRaw=$dbm->getBIMateriasDataRawByAOG($kalumnoporciclo);
			foreach($materiapeRaw AS $i){
				$idmppe=$i['materiaporplanestudioid'];
				$idppmppe=$i['profesorpormateriaplanestudiosid'];
				$profesormppe[$idmppe]=$idppmppe;
				
			}

			$calRaw=self::getCCRCalificacionesProcessByAlumnociclo($dbm,$kalumnoporciclo);
			$planestudio=$calRaw["planestudio"];
			$periodos=$calRaw["periodos"];
			$materias=$calRaw["materias"];
			$calificacionesRaw=$calRaw["scores"];
			$puntopase=$planestudio["puntopase"];
			$calminima=$planestudio["calificacionminima"];
			self::$CALEVAL=(ENTORNO==1 ? $puntopase : $calminima+0.001);
			$totalPeriodo=[];
			$totalTotal=[[[], false], [[], false], [[], false]];
			$periodosclean=[];

			foreach($periodos AS $iperiodo){
				$kperiodo=(int) $iperiodo['periodoevaluacionid'];
				if(isset($periodosRel[$kperiodo])){
					$periodosclean[]=$iperiodo;
				}
			}
			
			foreach($materias AS &$imateriape){
				$imateriape['escurricularx']=$imateriape['materiape']['escurricular'];
				$imateriape['escurricular']=(ENTORNO==2 ? true : $imateriape['escurricular']);
				unset($imateriape);
			}
			unset($periodos);
			$indexperiodo=0;
			$nperiodos=count($periodosclean);
			foreach($periodosclean AS $iperiodo){
				$ultimoperiodo=($nperiodos==++$indexperiodo);
				$kperiodo=(int) $iperiodo['periodoevaluacionid'];
				$irperiodo=$periodosRel[$kperiodo];
				$icalificacionperc=$irperiodo["porcentajecalificacionfinal"];
				$ipcalificaciones=($calificacionesRaw[$kperiodo] ? $calificacionesRaw[$kperiodo] : []);
				$isValidGeneral=($iperiodo['fechageneral'] && $iperiodo['fechageneral']<=$now);
				$isValidAlumno=($iperiodo['fechaalumno'] && $iperiodo['fechaalumno']<=$now);
				$isValidFamilia=($iperiodo['fechafamilia'] && $iperiodo['fechafamilia']<=$now);
				$arValid=[$isValidGeneral, $isValidAlumno, $isValidFamilia];
				foreach($materias AS $imateria){
					$kmateria=$imateria['materiaid'];
					$imateriape=$imateria['materiape'];					
					$icalificacion=($ipcalificaciones[$kmateria] ? $ipcalificaciones[$kmateria] : []);
					$curricular=$imateriape['escurricular'];
					$cualitativa=($imateriape['tipocalificacionid']==1);
					$solofinal=($imateriape['materiafrecuenciacapturaid']==2);
					$irecs=$icalificacion['recuperaciones'];
					$ical=trim($icalificacion['calificacion']);
					$icalfx=trim($icalificacion['finalcalificacion']);
					if(!isset($totalPeriodo[$kperiodo])){
						$totalPeriodo[$kperiodo]=[$icalificacionperc, [0, 0], [0, 0], [0, 0]];
					}
					$icalrec=($irecs ? $irecs[0]["calificacion"] : null);
					$dical=(float) ($icalrec ? $icalrec : $ical);
					$karval=0;
					foreach($arValid AS $iarval){
						$karval++;
						if($iarval && !$cualitativa && (!$solofinal || $ultimoperiodo) && ($curricular || !$isLux)){
							$klastmateriape=$imateriape['materiaporplanestudioid'];
							$totalPeriodo[$kperiodo][$karval][0]++;
							$totalPeriodo[$kperiodo][$karval][1]+=$dical;
						}
					}
					unset($imateria);
				}
				unset($iperiodo);
			}

			if(!$klastmateriape){
				return [0, 0, 0];
			}

			$roundFunctions=$dbm->getRoundFunctionNameByMateriaplanestudio($klastmateriape);
			foreach($totalPeriodo AS $icals){
				list($percentage, $icalgeneral, $icalalumnos, $icalfamiliar)=$icals;
				$rdfnPeriodo=$roundFunctions['final'];
				$promGeneral=self::getRoundedAverageProcess($dbm, $rdfnPeriodo, $icalgeneral);
				$promAlumno=self::getRoundedAverageProcess($dbm, $rdfnPeriodo, $icalalumnos);
				$promFamiliar=self::getRoundedAverageProcess($dbm, $rdfnPeriodo, $icalfamiliar);
				if($promGeneral>0){ $totalTotal[0][0][]=[$promGeneral, false, $percentage]; }
				if($promAlumno>0){ $totalTotal[1][0][]=[$promAlumno, false, $percentage]; }
				if($promFamiliar>0){ $totalTotal[2][0][]=[$promFamiliar, false, $percentage]; }
			}

			$isLux=ENTORNO==1;
			foreach($materias as $keyx=> $mat) {
				$icalificacionx=($ipcalificaciones[$mat['materiaid']] ? $ipcalificaciones[$mat['materiaid']] : []);
				if($mat['escurricularx'] || !$isLux) {
					$summat += floatval($icalificacionx['finalcalificacion']);
					$promsummat ++;
				}
			}

			$rdfnTotal=$roundFunctions["final"];
			$promsumfinal = $summat / $promsummat;
			$finalprom = $dbm->getRoundedValueByFunctionName($rdfnPeriodo, $promsumfinal);
			//$promTGeneral=self::getPromedioRedondeado($dbm, $rdfnTotal, $promediable, $totalTotal[0]);
			//$promTAlumno=self::getPromedioRedondeado($dbm, $rdfnTotal, $promediable, $totalTotal[1]);
			//$promTFamiliar=self::getPromedioRedondeado($dbm, $rdfnTotal, $promediable, $totalTotal[2]);
			return [$finalprom, $finalprom, $finalprom];
		}
		return false;
	}

	public static function getUltimasCalificacionesByAlumno($dbm, $alumnoid, $datoalumno){
		$dataRaw=$dbm->BuscarAlumnosA(['alumnoid'=>$alumnoid, 'cicloid'=> $datoalumno['cicloid'], 'alumnoporcicloid' => $datoalumno['alumnoporcicloid']]);
		$data=$dataRaw[0];
		$sumpromedio = 0;
		$summaterias = 0;
		if($dataRaw && $data && $data['grupoid'] && $data['alumnoid'] && $data['alumnoporcicloid']){
			$alumnoid=$data["alumnoid"];
			$now=new \DateTime();
			$fechacheckid="fechapublicacionprevia";
			$periodosRel=[];
			$periodosVis=[];
			$profesormppe=[];
			$hasNivel=false;
			$faltasid="_falt_";
			$periodopid="_prop_";
			$niveldesid="_prnv_";
			$materiapromid="_prma_";
			$nivelid=$data["nivelid"];
			$cicloid=$datoalumno['cicloid'] ? $datoalumno['cicloid'] : $data['cicloid'];
			$gradoid=$datoalumno['gradoid'] ? $datoalumno['gradoid'] : $data['gradoid'];
			$kalumnoporciclo=$datoalumno['alumnoporcicloid'] ? $datoalumno['alumnoporcicloid'] : $data['alumnoporcicloid'];
			$isLux=ENTORNO==1;
			$isBachillerato=($nivelid==4);
			$luxBachillerato=($isBachillerato && $isLux);
			$evalTrigger=$isBachillerato;
			
			$periodoData=$dbm->getBIPeriodoEvaluacionByCicloGrado($cicloid, $gradoid);
			if(!$periodoData){
				return false;
			}
			list($promediable, $periodosRaw)=$periodoData;
			foreach($periodosRaw AS &$irperiodo){
				$irperiodo['id']=(int) $irperiodo['id'];
				$periodosRel[$irperiodo['id']]=$irperiodo;
				$irperiodo['visible']=[true, false, false];
				if($now>= $irperiodo[$fechacheckid]){
					$periodosVis[]=$irperiodo;
				}
				if($now>= $irperiodo["fechapublicacionprevia"]){
					$irperiodo['visible'][1]=true;
				}
				if($now>= $irperiodo["fechapublicaciondefinitiva"]){
					$irperiodo['visible'][2]=true;
				}
				unset($irperiodo);
			}

			$materiapeRaw=$dbm->getBIMateriasDataRawByAOG($kalumnoporciclo);
			foreach($materiapeRaw AS $i){
				$idmppe=$i['materiaporplanestudioid'];
				$idppmppe=$i['profesorpormateriaplanestudiosid'];
				$profesormppe[$idmppe]=$idppmppe;
				
			}

			$dataraw=self::getCCRCalificacionesProcessByAlumnociclo($dbm,$kalumnoporciclo);
			$planestudio=$dataraw["planestudio"];
			$periodos=$dbm->getRepositoriosModelo("CePeriodoevaluacion",
				["d.periodoevaluacionid","d.descripcion AS nombre","d.descripcioncorta AS corto",
					"d.fechainicio","d.fechapublicacionprevia AS fechageneral","d.fechapublicacionprevia AS fechaalumno","d.fechapublicaciondefinitiva AS fechafamilia"],

					[["periodoevaluacionid is not null and cpe.cicloid = " . $cicloid . "and gpe.gradoid =" . $gradoid]], false, true, [
						["entidad" => "CeConjuntoperiodoevaluacion", "alias" => "cpe", "left" => false, "on" => "cpe.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
						["entidad" => "CeGradoporconjuntoperiodoescolar", "alias" => "gpe", "left" => false, "on" => "gpe.conjuntoperiodoevaluacionid = cpe.conjuntoperiodoevaluacionid"]

					]);
			$materias=$dataraw["materias"];
			$calificacionesRaw=$dataraw["scores"];
			$puntopase=$planestudio["puntopase"];
			$calminima=$planestudio["calificacionminima"];
			self::$CALEVAL=(ENTORNO==1 ? $puntopase : $calminima+0.001);
			$filas=[];
			$columnas=[];
			$calificaciones=[];
			$resumenMateria=[];
			$resumenCalfid=[];
			$arrayponOpcionesMateria=[];
			$arrayopcvista= [];
			$totalPeriodo=[];
			$totalMateria=[];
			$totalTotal=[[[], false], [[], false], [[], false]];

			$lastRoundFunctions=null;
			$periodosrec=[];
			$periodosclean=[];

			foreach($periodos AS $iperiodo){
				$kperiodo=(int) $iperiodo['periodoevaluacionid'];
				if(isset($periodosRel[$kperiodo])){
					$periodosclean[]=$iperiodo;
				}
			}
			
			foreach($materias AS &$imateriape){
				$imateriape['escurricular']=(ENTORNO==2 ? true : $imateriape['escurricular']);
				unset($imateriape);
			}
			unset($periodos);
			$indexperiodo=0;
			$nperiodos=count($periodosclean);
			//Calificaciones por periodo
			foreach($periodosclean AS $iperiodo){
				$ultimoperiodo=($nperiodos==++$indexperiodo);
				$kperiodo=(int) $iperiodo['periodoevaluacionid'];
				$irperiodo=$periodosRel[$kperiodo];
				$icalificacionperc=$irperiodo["porcentajecalificacionfinal"];
				$ipcalificaciones=($calificacionesRaw[$kperiodo] ? $calificacionesRaw[$kperiodo] : []);
				$isValidGeneral=($iperiodo['fechageneral'] && $iperiodo['fechageneral']<=$now);
				$isValidAlumno=($iperiodo['fechaalumno'] && $iperiodo['fechaalumno']<=$now);
				$isValidFamilia=($iperiodo['fechafamilia'] && $iperiodo['fechafamilia']<=$now);
				$arValid=[$isValidGeneral,$isValidAlumno,$isValidFamilia];
				foreach($materias AS $imateria){
					$kmateria=$imateria['materiaid'];
					$imateriape=$imateria['materiape'];					
					$icalificacion=($ipcalificaciones[$kmateria] ? $ipcalificaciones[$kmateria] : []);
					$curricular=$imateriape['escurricular'];
					$cualitativa=($imateriape['tipocalificacionid']==1);
					$solofinal=($imateriape['materiafrecuenciacapturaid']==2);
					$irecs=$icalificacion['recuperaciones'];
					$icrit=$icalificacion['criterios'];
					$ical=trim($icalificacion['calificacion']);
					$icalid=trim($icalificacion['calificacionperiodoporalumnoid']);
					$icalf=trim($icalificacion['finalcalificacion']);
					$icalfid=trim($icalificacion['calificacionfinalperiodoporalumnoid']);
					$iextra=trim(empty($icalificacion['extracalificacion']) ? "" : $icalificacion['extracalificacion']);
					$ipon=trim($icalificacion['ponderacion']);
					$iponid=$icalificacion['ponderacionopcionid'];
					$hco =$icalificacion['habilitarcapturaopciones'];
					$pco=$icalificacion['ponderacionparacapturaopciones'];
					$tcalif = intval($icalificacion['tipocalificacionid']);
					$iponf=trim($icalificacion['finalponderacion']);
					if($icalificacion['ponderacionid']) {
						$opciones = $dbm->getRepositoriosModelo("CePonderacionopcion", 
						["d.ponderacionopcionid, d.opcion"], 
							[["ponderacionid = " . $icalificacion['ponderacionid']]], false, true, [
						]);
					}
					if($icrit){
						foreach($icrit AS &$iicrit){
							$iipuntajesum=0;
							$iicapturas=$iicrit['capturas'];
							$iiccals=$iicrit['calificacion'];
							$iipuntajemax=$iicrit['puntajemaximo'];
							$iiporcentaje=$iicrit['porcentajecalificacion'];
							foreach($iiccals AS &$iiccal){
								$iicritcal=$iiccal['calificacion'];
								$iipuntajesum+=$iicritcal;
								$iiccpaid = $iiccal['capturacalificacionporalumnoid'];
								$iiccal['captura']=$iiccal['numerocaptura'];
								//$iiccal['calificacion']=$iicritcal;
								unset($iiccal['criterioevaluaciongrupoid'],$iiccal['numerocaptura'],$iiccal);
							}
							$iipuntaje=(float)number_format($iipuntajesum/$iicapturas,1);
							$iicalificacion=(float)number_format($iipuntaje*$iiporcentaje/$iipuntajemax/10,1);
							$iicrit['nombre']=$iicrit['aspecto'];
							$iicrit['puntaje']=$iipuntaje;
							$iicrit['capturacalificacionporalumnoid'] = $iiccpaid;
							$iicrit['calificacionperiodoporalumnoid'] = $icalid;
							$iicrit['puntajemax']=$iipuntajemax;
							$iicrit['porcentaje']=$iiporcentaje;
							$iicrit['calificacion']=$iicalificacion;
							$iicrit['calificaciones']=&$iiccals;
							//$iicrit['capturas']=$iicapturas;
							unset($iicrit['aspecto'],$iicrit['descripcion'],$iicrit['puntajemaximo'],$iicrit['porcentajecalificacion'],
								$iicrit,$iipuntajesum,$iicapturas,$iiccals,$iipuntajemax,$iiporcentaje,$iipuntaje,$iicalificacion);
						}
					}
					$icalrec=null;
					$idata=[
						"row"=>"".$kmateria,
						"col"=>"".$kperiodo,
						"det"=>$icrit,
						"data"=>$ical,
						"id"=>$icalid,
						"capturaopciones"=> $hco,
						"ponderacionparacapturaopciones" => $pco,
						"ponopciones" => $opciones,
						"ponderacionopcionid" => $iponid,
						"tipocalificacionid" => $tcalif
					];
					if($irecs){
						$periodosrec[$kperiodo]=true;
						$icalrec=$irecs[0]["calificacion"];
						$idata["rec"]=$icalrec;
						/*$idatarec=[
							"rec"=>true,
							"row"=>"".$kmateria,
							"col"=>"R$kperiodo",
							"det"=>[],
							"data"=>$reccal
						];*/
					}
					if(!empty($ipon)){
						$idata["data2"]=$ipon;
					}

					if(!isset($totalPeriodo[$kperiodo])){
						$totalPeriodo[$kperiodo]=[&$iperiodo, [0, 0], [0, 0], [0, 0], $icalificacionperc];
					}
					if(!isset($totalMateria[$kmateria])){
						$totalMateria[$kmateria]=[&$imateria, [[], false], [[], false], [[], false], null];
					}
					//Promedio general
					$karval=0;
					$dical=(float) ($icalrec ? $icalrec : $ical);
					foreach($arValid AS $iarval){
						$karval++;
						if($iarval){
							if(!$solofinal || $ultimoperiodo){
								if($ultimoperiodo){
									$totalMateria[$kmateria][$karval][1]=true;
								}
								if($cualitativa){
									$totalMateria[$kmateria][$karval][0]=[false, $iponf];
								}else{
									if($curricular || !$isLux){
										$totalPeriodo[$kperiodo][$karval][0]++;
										$totalPeriodo[$kperiodo][$karval][1]+=$dical;
									}
									$totalMateria[$kmateria][$karval][0][]=[$dical, $ultimoperiodo, $icalificacionperc];
								}
							}
						}
					}
					$resumenMateria[$kmateria]=$icalf;
					$resumenCurricular[$kmateria]=$curricular;
					$resumenCalfid[$kmateria]=$icalfid;
					$arrayponOpcionesMateria[$kmateria]=$opciones;
					$arrayopcvista[$kmateria]= ["hco" => $hco, "pco" => $pco, "tcalif" => $tcalif];
					if(!empty($iextra)){
						$totalMateria[$kmateria][4]=$iextra;
					}
					$calificaciones[]=$idata;
					unset($imateria);
				}
				unset($iperiodo);
			}

			//Promedio final materia
			foreach($totalMateria AS $kmateria=>$itotal){
				
				$promediofcalcmat = 0;
				list($imateria, $icalgeneral, $icalalumnos, $icalfamiliar, $extra)=$itotal;
				$imateriape=$imateria['materiape'];
				$kmateriape=$imateriape['materiaporplanestudioid'];
				$lastRoundFunctions=$dbm->getRoundFunctionNameByMateriaplanestudio($kmateriape);
				$rdfnMateria=$lastRoundFunctions['materia'];
				$calSaved=$resumenMateria[$kmateria];
				$calfidSaved=$resumenCalfid[$kmateria];
				$opcs=$arrayponOpcionesMateria[$kmateria];
				$vista=$arrayopcvista[$kmateria];
				$promGeneral=self::getPromedioRedondeado($dbm, $rdfnMateria, $promediable, $icalgeneral, $evalTrigger);
				$promAlumno=self::getPromedioRedondeado($dbm, $rdfnMateria, $promediable, $icalalumnos, $evalTrigger);
				$promFamiliar=self::getPromedioRedondeado($dbm, $rdfnMateria, $promediable, $icalfamiliar, $evalTrigger);
				$curricularmat = $resumenCurricular[$kmateria];




				if($icalgeneral[1]){ $promGeneral=$calSaved; }
				if($icalalumnos[1]){ $promAlumno=$calSaved; }
				if($icalfamiliar[1]){ $promFamiliar=$calSaved; }

				if($extra!=null){
					$promGeneral=$extra;
					$promAlumno=$extra;
					$promFamiliar=$extra;
				}

				if($curricularmat || !$isLux) {
						$summaterias++;
						$sumpromedio += floatval($promGeneral);
				}
				$calificaciones[]=[
						"row"=>"".$kmateria,
						"col"=>"".$materiapromid,
						"data"=>$promGeneral,
						"data3"=>$promAlumno,
						"data4"=>$promFamiliar,
						"extra"=>$extra,
						"calificacionfinalperiodoporalumnoid"=>$calfidSaved,
						"ponopciones" => $opcs,
						"capturaopciones" =>$vista['hco'],
						"ponderacionparacapturaopciones" => $vista['pco'],
						"tipocalificacionid" => $vista['tcalif']
				];
			}

			//Promedio por periodo
			foreach($totalPeriodo AS $kperiodoevaluacion=> $icals){
				list($iperiodo, $icalgeneral, $icalalumnos, $icalfamiliar, $percentage)=$icals;
				$rdfnPeriodo=$lastRoundFunctions['final'];
				$promGeneral=self::getRoundedAverageProcess($dbm, $rdfnPeriodo, $icalgeneral);
				$promAlumno=self::getRoundedAverageProcess($dbm, $rdfnPeriodo, $icalalumnos);
				$promFamiliar=self::getRoundedAverageProcess($dbm, $rdfnPeriodo, $icalfamiliar);
				$calificaciones[]=[
						"row"=>"".$periodopid,
						"col"=>"".$kperiodoevaluacion,
						"data"=>$promGeneral,
						"data3"=>$promAlumno,
						"data4"=>$promFamiliar
				];
				if($promGeneral>0){ $totalTotal[0][0][]=[$promGeneral, false, $percentage]; }
				if($promAlumno>0){ $totalTotal[1][0][]=[$promAlumno, false, $percentage]; }
				if($promFamiliar>0){ $totalTotal[2][0][]=[$promFamiliar, false, $percentage]; }
			}

			//Promedio final total
			$rdfnTotal=$lastRoundFunctions["final"];
			$promfinal = $sumpromedio / $summaterias;
			$promediofinal = $dbm->getRoundedValueByFunctionName($rdfnPeriodo, $promfinal);
			//$promTGeneral=self::getPromedioRedondeado($dbm, $rdfnTotal, $promediable, $totalTotal[0]);
			//$promTAlumno=self::getPromedioRedondeado($dbm, $rdfnTotal, $promediable, $totalTotal[1]);
			//$promTFamiliar=self::getPromedioRedondeado($dbm, $rdfnTotal, $promediable, $totalTotal[2]);
			$calificaciones[]=[
					"row"=>"".$periodopid,
					"col"=>"".$materiapromid,
					"data"=>$promediofinal,
					"data3"=>$promediofinal,
					"data4"=>$promediofinal
			];
			$promedioTotal=[
					"portal"=>["cal"=>$promediofinal, "niv"=>null],
					"alumno"=>["cal"=>$promediofinal, "niv"=>null],
					"padre"=>["cal"=>$promediofinal, "niv"=>null]
			];

			$showpromcalif = true;
			foreach($periodosRaw AS $i){
				$k=$i['id'];
				$showcalif = false;
				$prf = $i['fechaperiodorevisionfin'];
				if($prf <= new \DateTime()) {
					$showcalif = true;
				}
				if(!$showcalif) {
					$showpromcalif = false;
				}
				$columnas[]=[
						"id"=>"$k",
						"nombre"=>$i['descripcion'],
						"corto"=>$i['descripcioncorta'],
						"fechaprevia"=>$i['fechapublicacionprevia'],
						"fechadefinitiva"=>$i['fechapublicaciondefinitiva'],
						"visible"=>$i['visible'],
						"showcalificaciones"=> $showcalif
				];
				/*if($periodosrec[$k]){
					$columnas[]=[
							"id"=>"R$k",
							"nombre"=>"Recuperacion ".$i['descripcion'],
							"corto"=>$i['descripcioncorta']." (R)",
							"fechaprevia"=>$i['fechapublicacionprevia'],
							"fechadefinitiva"=>$i['fechapublicaciondefinitiva']
					];
				}*/
			}
			$totalFaltas=0;
			foreach($materias AS $imateria){
				$imateriape=$imateria['materiape'];
				$kmateria=$imateria['materiaid'];
				$kmateriape=$imateriape['materiaporplanestudioid'];
				$curricular=$imateriape['escurricular'];

				$imaterianombre=$imateria['alias'];
				$imaterianombref=$imateria['nombre'];
				$imateriaclave=$imateria['clave'];
				$imateriaorden=($imateriape ? $imateriape['ordeninterno'] : -1);
				$iprofesormppe=$profesormppe[$kmateriape];
				$filtrosbitacora = ["profesorpormateriaplanestudiosid" => $iprofesormppe, "nombrealumno" => $data['matricula'] . " - " . $data['nombrecompleto']];
				$bitacora = $dbm->getBitacoracalificacionesbyProfesor($filtrosbitacora);
				if($iprofesormppe){
					$ifaltas=sizeof($dbm->getFaltasAlumnoLD($kalumnoporciclo, $iprofesormppe));
					$totalFaltas+=$ifaltas;
				}
				$calificaciones[]=[
						"row"=>"".$kmateria,
						"col"=>$faltasid,
						"data"=>$ifaltas
				];
				$filas[]=[
						"id"=>"".$kmateria,
						"clave"=>$imateriaclave,
						"orden"=>$imateriaorden,
						"nombre"=>$imaterianombref,
						"corto"=>$imaterianombre,
						"curricular"=>$curricular,
						"bitacora" =>$bitacora
				];
			}
			usort($filas, "AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController::fnOrdMateriasByOrden");
			
			$calificaciones[]=[
					"row"=>$periodopid,
					"col"=>$faltasid,
					"data"=>$totalFaltas
			];
			$filas[]=[
					"id"=>$periodopid,
					"nombre"=>"TOTALES PERIODO/FALTAS",
					"corto"=>"PROMEDIO",
					
			];
			$columnas[]=[
					"id"=>$materiapromid,
					"nombre"=>"Promedio",
					"corto"=>"PROM",
					"visible"=>[true, true, true],
					"showcalificaciones"=> $showpromcalif
				];
			if($hasNivel){
				$columnas[]=[
						"id"=>$niveldesid,
						"nombre"=>"Promedio nivel",
						"corto"=>"PRNIV",
						"visible"=>[true, true, true]
					];
			}
			$columnas[]=[
					"id"=>$faltasid,
					"nombre"=>"Faltas",
					"corto"=>"FF",
					"visible"=>[true, true, true]
				];
			$ialumno=[
					"ciclo"=>$data["ciclo"],
					"nivel"=>$data["nivel"],
					"grado"=>$data["grado"],
					"grupo"=>$data["grupo"],
					"matricula"=>$data["matricula"],
					"nombre"=>$data["nombrecompleto"]
			];
			return [
					"alumno"=>$ialumno,
					"alumnoid"=>$alumnoid,
					"promedio"=>$promedioTotal,
					"row"=>$filas,
					"col"=>$columnas,
					"inte"=>$calificaciones
				];
		}
		return false;
	}
	
	public static function fnOrdMateriasByOrden($a,$b){
		$result=$a['orden']<=>$b['orden'];
		if($result==0){
			$result=$a['nombre']<=>$b['nombre'];
		}
		return $result;
	}
	
	public static function getCCRCalificacionesProcessByAlumnociclo($dbm,$kalumnociclo,$opts=[]){
		$result=[];
		$periodosraw=[];
		$recuperacionesr=[];

		$materiasraw=[];
		$materiasrawrel=[];
		$materiasperaw=[];
		$criteriosrel=[];

		$cpmrel=[];
		$alumno=self::getAlumnoDataByAlumnociclo($dbm,$kalumnociclo);
		$kalumno=(int)$alumno['alumnoid'];
		$calificacionesperiodoraw=self::getCalificacionesProcessByAlumnocicloData($dbm,$kalumnociclo,$opts);
		foreach($calificacionesperiodoraw AS $idata){
			$parent=null;
			$kdata=(int)$idata["calificacionperiodoporalumnoid"];
			$kparent=(int)$idata["parentid"];
			$kmateria=(int)$idata["materiaid"];
			$kmateriape=(int)$idata["materiaporplanestudioid"];
			$kperiodoevaluacion=(int)$idata["periodoevaluacionid"];
			$kprofesorpormateriaplanestudio=(int)$idata["profesorpormateriaplanestudioid"];
			$kcriteriounique="$kperiodoevaluacion:$kprofesorpormateriaplanestudio";
			$materiasraw[]=$kmateria;
			$materiasperaw[]=$kmateriape;
			if(!isset($result[$kperiodoevaluacion])){
				$result[$kperiodoevaluacion]=[];
				$periodosraw[]=$kperiodoevaluacion;
			}
			if(!isset($criteriosrel[$kcriteriounique])){
				$kcriteriosraw=[];
				$criteriosraw=self::getCCCriteriosByPeriodoevaluacionProfesormpe($dbm,$kperiodoevaluacion,$kprofesorpormateriaplanestudio);
				foreach($criteriosraw AS $icriteriosraw){
					$kcriteriosraw[]=$icriteriosraw['criterioevaluaciongrupoid'];
				}
				$criteriosrel[$kcriteriounique]=[$kcriteriosraw,$criteriosraw];
			}
			list($kcriterios,$icriterios)=$criteriosrel[$kcriteriounique];
			$idata['criterios']=&$icriterios;
			$criteriocalificacionrel=[];
			$criteriocalificacion=self::getCCCriteriosCalificacionByCriterioevaluaciongrupo($dbm,$kdata,$kcriterios);
			foreach($criteriocalificacion AS $icriteriocal){
				$kcccriterio=$icriteriocal['criterioevaluaciongrupoid'];
				if(!isset($criteriocalificacionrel[$kcccriterio])){
					$criteriocalificacionrel[$kcccriterio]=[];
				}
				$criteriocalificacionrel[$kcccriterio][]=$icriteriocal;
			}
			foreach($icriterios AS &$icriterio){
				$kcriterio=$icriterio['criterioevaluaciongrupoid'];
				$icriterio['calificacion']=(isset($criteriocalificacionrel[$kcriterio]) ? $criteriocalificacionrel[$kcriterio] : []);
				unset($icriterio);
			}
			if($kparent){
				$parent=$cpmrel[$kparent];
			}else{
				$cpmrel[$kdata]=$kmateria;
				$idata["recuperaciones"]=$dbm->getRepositoriosModelo("CeRecuperacionperiodo",
				[
					"d.recuperacionperiodoid",
					"d.intento",
					"d.calificacion"
				],[
					"profesorpormateriaplanestudioid"=>$kprofesorpormateriaplanestudio,
					"periodoevaluacionid"=>$kperiodoevaluacion,
					"alumnoporcicloid"=>$kalumnociclo
				],[
						"intento"=>"DESC"
				]);
				$extras=$dbm->getRepositoriosModelo("CeExtraordinario",
						["ceae.calificacionfinal AS calificacion"],
						["alumnoid"=>$kalumno,"profesorpormateriaplanestudiosid"=>$kprofesorpormateriaplanestudio],
						false,
						false,
						[[
								"entidad"=>"CeAcuerdoextraordinario",
								"alias"=>"ceae",
								"on"=>"ceae.extraordinarioid=d.extraordinarioid AND ceae.estatusextraordinarioid IN(4,5)"
						]]
					);
				if(!empty($extras)){					
					$extrascore=end($extras)['calificacion'];
					$idata['extracalificacion']=$extrascore;
					$idata['finalcalificacion']= ENTORNO == 2 ? $extrascore : $idata['finalcalificacion'];
				}
			}
			$result[$kperiodoevaluacion][$kmateria]=&$idata;
			$materiasrawrel[$kmateria]=[$kmateriape,$parent,$kprofesorpormateriaplanestudio];
			unset($idata["parentid"],$idata["materiaid"],$idata["periodoevaluacionid"],$idata["materiaporplanestudioid"],$idata["profesorpormateriaplanestudioid"],$idata,$icriterios);
		}
		$kplanestudio=0;
		$materiasraw=array_unique($materiasraw);
		$materiasperaw=array_unique($materiasperaw);
		$materiasrel=[];
		$materiasperel=[];
		$materias=$dbm->getRepositoriosModelo("Materia",["d.materiaid","d.clave","d.nombre","d.alias"],["materiaid"=>$materiasraw]);
		$periodos=$dbm->getRepositoriosModelo("CePeriodoevaluacion",["d.periodoevaluacionid","d.descripcion AS nombre","d.descripcioncorta AS corto","d.fechainicio","d.fechapublicacionprevia AS fechageneral","d.fechapublicacionprevia AS fechaalumno","d.fechapublicaciondefinitiva AS fechafamilia"],["periodoevaluacionid"=>$periodosraw]);
		$materiaspe=$dbm->getRepositoriosModelo("CeMateriaporplanestudios",[
				"d.materiaporplanestudioid",
				"IDENTITY(d.materiaid) AS materiaid",
				"IDENTITY(d.planestudioid) AS planestudioid",
				"IDENTITY(cecc.tipocalificacionid) AS tipocalificacionid",
				"d.ordenoficial",
				"d.ordeninterno",
				"d.escurricular",
				"d.seimprimeenboleta",
				"d.imprimirsubmateriaymateria",
				"fc.materiafrecuenciacapturaid"
			],
			["materiaporplanestudioid"=>$materiasperaw],false,false,
			[
				[
					"alias"=>"cecc",
					"entidad"=>"CeComponentecurricular",
					"on"=>"cecc.componentecurricularid=d.componentecurricularid"
				],[
					"alias"=>"fc",
					"entidad"=>"CeMateriafrecuenciacaptura",
					"on"=>"fc.materiafrecuenciacapturaid=d.materiafrecuenciacapturaid"
				]
			]
		);
		foreach($materiaspe AS $imateriape){
			$kplanestudio=$imateriape['planestudioid'];
			$materiasperel[$imateriape['materiaporplanestudioid']]=&$imateriape;
			unset($imateriape);
		}
		foreach($materias AS $imateria){
			$materiasrel[$imateria['materiaid']]=&$imateria;
			unset($imateria);
		}
		foreach($materias AS &$imateria){
			$kmateria=$imateria['materiaid'];
			list($kmateriape,$kmateriap,$kppmpe)=$materiasrawrel[$kmateria];
			$imateriap=null;
			if($kmateriap){
				$imateriap=$materiasrel[$kmateriap];
				$imateria['parent']=&$imateriap;
				$imateria['nombre']=$imateriap['nombre'].": ".$imateria['nombre'];
			}
			$imateria["submateria"]=($imateriap ? true : false);
			$imateria["materiape"]=&$materiasperel[$kmateriape];
			unset($imateria);
		}
		$planestudio=$dbm->getRepositoriosModelo("CePlanestudios",["d.planestudioid","d.nombre","d.puntopase","d.calificacionminima"],["planestudioid"=>$kplanestudio]);
		return [
				"planestudio"=>$planestudio[0],
				"periodos"=>$periodos,
				"materias"=>$materias,
				"materiaspe"=>$materiaspe,
				"periodosraw"=>$periodosraw,
				"materiasraw"=>$materiasraw,
				"scores"=>&$result
			];
	}
	private static function getCCCriteriosByPeriodoevaluacionProfesormpe($dbm,$kperiodoevaluacion,$kprofesormpe){
		if(!$kprofesormpe){ return []; }
		return $result=$dbm->getRepositoriosModelo("CeCriterioevaluaciongrupo",
				[
					"d.criterioevaluaciongrupoid",
					"d.aspecto",
					"d.descripcion",
					"d.configurartarea",
					"d.capturas",
					"d.puntajemaximo",
					"d.porcentajecalificacion"
				],[
					"periodoevaluacionid"=>$kperiodoevaluacion,
					"profesorpormateriaplanestudiosid"=>$kprofesormpe
				]);
	}
	private static function getCCCriteriosCalificacionByCriterioevaluaciongrupo($dbm,$kcalificacionperiodoporalumno,$kcriterioevaluaciongrupo){
		if(!$kcriterioevaluaciongrupo){ return []; }
		return $result=$dbm->getRepositoriosModelo("CeCapturacalificacionporalumno",
				[
					"d.capturacalificacionporalumnoid",
					"IDENTITY(d.criterioevaluaciongrupoid) AS criterioevaluaciongrupoid",
					"d.calificacion",
					"d.numerocaptura"
				],[
					"criterioevaluaciongrupoid"=>$kcriterioevaluaciongrupo,
					"calificacionperiodoporalumnoid"=>$kcalificacionperiodoporalumno
				]);
	}
	private static function getAlumnoDataByAlumnociclo($dbm,$kalumnociclo){
		return $dbm->getRepositoriosModelo("CeAlumnoporciclo",
				["IDENTITY(d.alumnoid) AS alumnoid"],
				["alumnoporcicloid"=>$kalumnociclo]
			)[0];
	}
	private static function getCalificacionesProcessByAlumnocicloData($dbm,$kalumnociclo,$opts){
		$where=["alumnoporcicloid"=>$kalumnociclo];
		if(isset($opts['periodoevaluacionid']) && !empty($opts['periodoevaluacionid'])){
			$where["periodoevaluacionid"]=$opts['periodoevaluacionid'];
		}
		if(isset($opts['profesorpormateriaplanestudioid']) && !empty($opts['profesorpormateriaplanestudioid'])){
			$where["profesorpormateriaplanestudioid"]=$opts['profesorpormateriaplanestudioid'];
		}
		return $result=$dbm->getRepositoriosModelo("CeCalificacionperiodoporalumno",
				[
					"d.calificacionperiodoporalumnoid",
					"IDENTITY(d.materiapadrecalificacionperiodoporalumnoid) AS parentid",
					"IDENTITY(d.profesorpormateriaplanestudioid) AS profesorpormateriaplanestudioid",
					"IDENTITY(d.periodoevaluacionid) AS periodoevaluacionid",
					"IDENTITY(d.materiaporplanestudioid) AS materiaporplanestudioid",
					"IDENTITY(d.materiaid) AS materiaid",
					"d.calificacion",
					"p.ponderacionopcionid",
					"p.opcion AS ponderacion",
					"d.observacion",
					"cf.calificacion AS finalcalificacion",
					"cf.calificacionfinalperiodoporalumnoid",
					"pf.opcion AS finalponderacion",
					"cf.observacion AS finalobservacion",
					"cc.habilitarcapturaopciones",
					"cc.ponderacionparacapturaopciones",
					"cc.componentecurricularid",
					"IDENTITY(cc.ponderacionid) AS ponderacionid",
					"IDENTITY(cc.tipocalificacionid) AS tipocalificacionid",
					"pf.ponderacionopcionid as ponderacionopcionfinalid"
				],$where , false, false, [
					[
						"left"=>true,
						"alias"=>"cf",
						"entidad"=>"CeCalificacionfinalperiodoporalumno",
						"on"=>"cf.calificacionfinalperiodoporalumnoid=d.calificacionfinalporperiodoalumno"
					],
					[
						"left"=>true,
						"alias"=>"p",
						"entidad"=>"CePonderacionopcion",
						"on"=>"p.ponderacionopcionid=d.ponderacionopcionid"
					],
					[
						"left"=>true,
						"alias"=>"mpe",
						"entidad"=>"CeMateriaporplanestudios",
						"on"=>"mpe.materiaporplanestudioid = d.materiaporplanestudioid"
					],
					[
						"left"=>true,
						"alias"=>"cc",
						"entidad"=>"CeComponentecurricular",
						"on"=>"cc.componentecurricularid = mpe.componentecurricularid"
					],
					[
						"left"=>true,
						"alias"=>"pf",
						"entidad"=>"CePonderacionopcion",
						"on"=>"pf.ponderacionopcionid=cf.ponderacionopcionid"
					]
				]
		);
	}
	public static function getPromedioRedondeado($dbm, $fnName, $promediable, $dataRaw, $eval=false){
		list($data)=$dataRaw;
		if(empty($data)){ return ""; }
		if($data[0]===false){ return $data[1]; }
		$promedio=0;
		$evalTrigger=false;
		if($promediable){
			$n=0;
			$sum=0;
			foreach($data AS $i){
				list($calificacion, $ultimo)=$i;
				$n++;
				$sum+=$calificacion;
				$evalTrigger=($eval && $ultimo && $calificacion<self::$CALEVAL ? true : $evalTrigger);
			}
			$promedio=($n>0 ? $sum/$n : 0);
		}else{
			foreach($data AS $i){
				list($calificacion, $ultimo, $porcentaje)=$i;
				$promedio+=($calificacion*$porcentaje/100);
				$evalTrigger=($eval && $ultimo && $calificacion<self::$CALEVAL ? true : $evalTrigger);
			}
		}
		if($evalTrigger){
			$promedio=5;
		}
		return $dbm->getRoundedValueByFunctionName($fnName, $promedio);
	}
	private static function getRoundedAverageProcess($dbm, $fnName, $data){
		list($periodos, $calAcumulada)=$data;
		if($periodos===false){ return $calAcumulada; }
		return $dbm->getRoundedValueByFunctionName($fnName, ($periodos<=0 ? 0 : ($calAcumulada/$periodos)));
	}
	private static function calcPonderacion($ponderacion, $calificacion){
		foreach($ponderacion as $i){
			if($i['calificacionminima']<= $calificacion && $calificacion<= $i['calificacionmaxima']){
				return $i['opcion'];
			}
		}
		return "";
	}
	private function getDM(){
		if($this->DBM){
			return $this->DBM;
		}
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}