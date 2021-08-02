<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Controller\lib\PDFMerger\PDFMerger;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
use AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController;

/**
 * Autor: Emmanuel Martinez
 */
class BoletaImpresionController extends FOSRestController{
	private $DBM=false;
	/**
	 * @Annotations\Get("/api/Controlescolar/Boletaimpresion/filter", name="getBIFilter")
	 */
	public function getBIFilter(){
		$dbm=$this->getDM();
		$ciclo=$dbm->getBasicCiclo();
		$nivel=$dbm->getBasicNivel();
		$semestre=$dbm->getBasicSemestre();
		$grado=$dbm->getBasicGrado();
		$grupo=$dbm->getBasicGrupoCurricular();
		if($ciclo!== false && $nivel!== false && $grado!== false && $semestre!== false && $grupo!== false){
			return Api::Ok("", array(
				"ciclo"=>$ciclo,
				"nivel"=>$nivel,
				"semestre"=>$semestre,
				"grado"=>$grado,
				"grupo"=>$grupo
			));
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}

	/**
	 * @Annotations\Get("/api/Controlescolar/Boletaimpresion/alumno/{alumnoid}", name="getBIPDFByAlumno")
	 */
	public function getBIPDFByAlumno($alumnoid){
		$dbm=$this->getDM();
		$dataRaw=$dbm->BuscarAlumnosA(['alumnoid'=>$alumnoid]);
		$data=$dataRaw[0];
		if($dataRaw && $data && $data['grupoid'] && $data['alumnoid'] && $data['alumnoporcicloid']){
			$grupoid=$data['grupoid'];
			$_REQUEST['cicloid']=$data['cicloid'];
			$_REQUEST['nivelid']=$data['nivelid'];
			$_REQUEST['gradoid']=$data['gradoid'];
			$_REQUEST['grupoid']=$grupoid;
			$_REQUEST['alumnoid']=(int)$data['alumnoid'];
			$_REQUEST['alumnoporcicloid']=(int)$data['alumnoporcicloid'];
			return $this->getBIPDF();
		}
		return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No se han registrado calificaciones para el alumno en el ciclo inscrito.");
	}

	/**
	 * @Annotations\Get("/api/Controlescolar/Boletaimpresion/", name="getBIPDF")
	 */
	public function getBIPDF(){
		$publicacionRaw=(isset($_REQUEST['publicacion']) ? $_REQUEST['publicacion'] : (isset($_REQUEST['/publicacion']) ? $_REQUEST['/publicacion'] : null));
		$publicacion=($publicacionRaw=="true" || $publicacionRaw=="1");
		if(isset($_REQUEST['mig']) && $_REQUEST['mig']=-3){ $publicacion=-1; }
		$cicloid=(int)$_REQUEST['cicloid'];
		$nivelid=(int)$_REQUEST['nivelid'];
		$gradoid=(int)$_REQUEST['gradoid'];
		$matricula=trim($_REQUEST['matricula']);
		$oficial=intval($_REQUEST['oficial']);
		if($matricula){
			$dmatricula=$this->getDM()->getBIAlumnoByCicloGradoMatricula($cicloid,$gradoid,$matricula);
			if($dmatricula){
				$_REQUEST['grupoid']=$dmatricula[0]['grupoid'];
				$_REQUEST['alumnoid']=$dmatricula[0]['alumnoid'];
				$_REQUEST['alumnoporcicloid']=$dmatricula[0]['alumnoporcicloid'];
			}else{ return Api::Error(209, "No se encontro la matricula en el ciclo y grado especificados."); }
		}
		$grupoid=(int)$_REQUEST['grupoid'];
		$ldalumnoid=(isset($_REQUEST['alumnoid']) ? (int)$_REQUEST['alumnoid'] : 0);
		$ldalumnoporcicloid=(isset($_REQUEST['alumnoporcicloid']) ? (int)$_REQUEST['alumnoporcicloid'] : 0);
		if($ldalumnoid<1){
			$ldalumnoid=null;
			$ldalumnoporcicloid=null;
		}
		$report="../tmp_boleta_G{$grupoid}";
		$baseJSON="Boleta_";
		$baseOutput="Boleta_";
		$outputFile="{$baseOutput}G{$grupoid}";
		$tomerge=[];
		$toremove=[];
		$pdf=new LDPDF($this->container, $report, $outputFile);
		$outputPath=$pdf->output_r;
		$reportPath=$pdf->report_r;
		$hasReport=$this->loadBIPDFReport($pdf->report_r, $grupoid,$oficial);
		$toremove[]=$reportPath;
		if(!$hasReport){
			return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No han subido plantilla de boleta para este grado y ciclo.");
		}
		if($cicloid>0 && $nivelid>0 && $gradoid>0 && $grupoid>0){
			$dbm=$this->getDM();
			$config=$dbm->getBIPDFConfigByGrupo($grupoid);
			$at=time();
			$calificacion=$this->getBIPDFCalificaciones($publicacion,$cicloid,$nivelid,$gradoid,$grupoid,$ldalumnoid);
			$nt=time()-$at;
			$continue=true;
			$atLeastOne=false;
			if($calificacion && sizeof($calificacion)>0){
				foreach($calificacion AS $alumnocicloid=>$icalificacion){
					if($continue){
						$json="$baseJSON$alumnocicloid";
						$output="$baseOutput$alumnocicloid";
						$pdf=new LDPDF($this->container, $report, $output, array('driver'=>'jsonql', 'jsonql_query'=>'""', 'data_file'=>$json));
						$data=$this->loadBIPDFData($config, $icalificacion, $grupoid, $alumnocicloid, $pdf->fdb_r);
						if($data){
							$toremove[]=$pdf->fdb_r;
							$data['config']=$config;
							//echo($pdf->output());exit;
							if(!$pdf->execute()){
								$atLeastOne=true;
								$tomerge[]=$pdf->output_r;
								$toremove[]=$pdf->output_r;
								continue;
							}else{ var_dump("Error generando boleta alumno [$alumnocicloid]."); }
						}
						$continue=false;
					}
				}
			}
			if(!$atLeastOne){
				return Api::Error(207, "Aun no es el periodo de publicación.");
			}
			if(!$continue){
				return Api::Error(208, "Error obteniendo los datos de alumno.");
			}
			$merger=new PDFMerger();
			foreach($tomerge AS $i){ $merger->addPDF($i); }
			$merger->merge("file",$outputPath);
			$toremove[]=$outputPath;
			$boletaSize=filesize($outputPath);
			$boleta=file_get_contents($outputPath);
			//return false;
			$this->getBIPDFCleanFiles(array_unique($toremove));
			return new Response($boleta, 200, array(
				'Content-Type'=>'application/pdf',
				'Content-Length'=>$boletaSize
			));
		}
		return Api::Error(Response::HTTP_BAD_REQUEST,false);
	}

	private function getBIPDFCalificaciones($publicacion,$cicloid,$nivelid,$gradoid,$grupoid,$ldalumnoid=null){
		$dbm=$this->getDM();
		$now=new \DateTime();
		$isdatecheckactive=($publicacion!==-1);
		$fechacheckid=($isdatecheckactive ? ($publicacion ? "fechapublicaciondefinitiva" : "fechapublicacionprevia") : "fechafin");
		$isLux=ENTORNO==1;
		$isBachillerato=($nivelid==4);
		$luxbachillerato=($isBachillerato && $isLux);
		$ordcalis=0;
		$ordfaltas=3;
		$ftotal="PROM./FALT.";
		$ftotalf="TOTALES PROMEDIO/FALTAS";
		if($luxbachillerato){
			$ordcalis=1;
			$ordfaltas=0;
			$ftotal="FALT./PROM.";
			$ftotalf="TOTALES FALTAS/PROMEDIO";
		}
		$data=[];
		$periodosRel=[];
		$periodosVis=[];
		$atLeastOne=false;
		$hasPonderacion=false;
		$kfinal=-1;
		$nfinal="FINAL";
		$ffinal="PROMEDIO FINAL";
		$profesorFirst=null;
		//$ktotal="-2";
		//$ntotal="TOTALES";
		$periodoData=$dbm->getBIPeriodoEvaluacionByCicloGrado($cicloid, $gradoid);
		if(!$periodoData){ return false; }
		list($promediable,$periodosRaw)=$periodoData;
		foreach($periodosRaw AS $kperiodo=>$iperiodo){
			$irperiodo=&$periodosRaw[$kperiodo];
			$periodosRel[$irperiodo['id']]=$irperiodo;
			$irperiodo['visible']=false;
			if(!$isdatecheckactive || ($now>=$irperiodo[$fechacheckid])){
				$periodosVis[]=$irperiodo;
				$irperiodo['visible']=true;
				$atLeastOne=true;
			}
		}
		if(!$atLeastOne){ return false; }
		$alumnocicloingrupo=$dbm->getBIAlumnoCicloByGrupo($grupoid,$ldalumnoid);
		foreach($alumnocicloingrupo AS $ialumno){
			$ialumnoid=$ialumno['alumnoid'];
			$ialumnocicloid=$ialumno['alumnoporcicloid'];
			$kalumnociclogrupo=$ialumno['alumnocicloporgrupoid'];
			$periodoLatest=null;
			$periodoLast=true;
			$ialumnodata=[];
			$kalumnoobservaciones=[];
			$ialumnotareas=[];
			$ialumnocapturas=[];
			$ialumnocriterios=[];
			$ialumnoconducta=[];
			$profesormppe=[];
			$materiapeRel=[];
			$materiapeRaw=$dbm->getBIMateriasDataRawByAOG($ialumnocicloid);

			$ccurriculares=[];
			$ccurricularesRel=[];
			foreach($materiapeRaw AS &$i){
				$idmppe=$i['materiaporplanestudioid'];
				$idppmppe=$i['profesorpormateriaplanestudiosid'];
				$kccurricular=$i["componentecurricularid"];
				$i['ponderaciones']=$dbm->getOpcionesByMateriaporplanestudio($idmppe);
				$profesormppe[$idmppe]=$idppmppe;
				$materiapeRel[$idmppe]=$i;
				if(!isset($ccurricularesRel[$kccurricular])){
					$ccurricularesRel[$kccurricular]=true;
					$ccurriculares[]=[
						"id"=>$kccurricular,
						"name"=>$i["componentecurricular"],
						"tipocalificacion"=>$i["tipocalificacionid"],
						"calificacion"=>$i["ponderacionparacapturaopciones"],
						"ponderacion"=>$i["mostrarcapturaopciones"]
					];
				}
			}
			//$dataRaw=json_decode('',true);
			$dataRaw=BoletaImpresionController::getBIPDFCalificacionesRaw($this->get("db_manager"),$cicloid,$nivelid,$gradoid,$periodosVis,$materiapeRaw,$ialumnoid,$ialumnocicloid);
			//echo json_encode($dataRaw);exit;
			list($alumnos,$materias,$periodos,$calificacionesRaw)=$dataRaw;
			$calificacionRaw=$calificacionesRaw[$ialumnoid];
			$resumenFinal=$calificacionRaw["r"];
			$criterioPeriodos=$calificacionRaw["c"];
			$calificacionPeriodos=$calificacionRaw["d"];
			$sumFcal = 0;
			$conteoFcal = 0;

			foreach($resumenFinal as $rf) {
				if($rf[3] || !$isLux) {
					if(!empty($rf[0])) {
						$conteoFcal++;
						$sumFcal += floatval($rf[0]);
					}
				}
			}

			$ordenRel=[];
			$ordyMateria=[];
			$totalFaltas=[];
			$promPeriodos=[];
			$calsMaterias=[];
			$ord=0;
			$ordy2=0;
			$indexperiodo=0;
			$ultimoperiodo=false;
			$promFcal = $sumFcal / $conteoFcal;
			foreach($periodosRaw AS $iperiodo){
				//$iperiodo=$periodosRel[$kperiodo];
				$indexperiodo++;
				$ultimoperiodo=(count($periodosRaw)==$indexperiodo);
				$calsPeriodo=[];
				$totalPFaltas=0;
				$isCIIAdded=false;
				$kperiodo=$iperiodo['id'];
				$visible=$iperiodo['visible'];
				$iperiodofname=$iperiodo['descripcion'];
				$iperiodoname=$iperiodo['descripcioncorta'];
				$icalificacionperc=$iperiodo["porcentajecalificacionfinal"];
				$ifechacheck=$iperiodo[$fechacheckid];
				$imateriacriterios=(isset($criterioPeriodos[$kperiodo]) ? $criterioPeriodos[$kperiodo] : []);
				$imateriascores=(isset($calificacionPeriodos[$kperiodo]) ? $calificacionPeriodos[$kperiodo] : []);
				if(!$periodoLatest){ $periodoLatest=$iperiodo; }
				else if($imateriascores){
					if($ifechacheck>=$periodoLatest[$fechacheckid]){
						$periodoLatest=$iperiodo;
					}
				}else{ $periodoLast=false; }
				//$isValidPrevia=($iperiodo['fechapublicacionprevia'] && $iperiodo['fechapublicacionprevia']<= $now);
				//$isValidDefinitiva=($iperiodo['fechapublicaciondefinitiva'] && $iperiodo['fechapublicaciondefinitiva']<= $now);
				$icapturaalumno=$dbm->getCapturaAlumnoPeriodo($ialumnocicloid,$kperiodo);
				$icaobservacion="-";
				$icaasistencia="-";
				$icatsolicitada="-";
				$icatentregada="-";
				$icatfaltantes="-";
				$icatasistenciadet=null;
				$kalumnoobservaciones[$kperiodo]=[
					"ordy"=>$ordy2,
					"idp"=>$kperiodo,
					"row"=>$iperiodoname,
					"rowf"=>$iperiodofname,
					"cap"=>$icaobservacion,
					"can"=>[],
					"cal"=>[]
				];
				if($icapturaalumno){
					if($icapturaalumno['observaciones'] && !empty(trim($icapturaalumno['observaciones']))){
						$icaobservacion=trim($icapturaalumno['observaciones']);
					}
					if($icapturaalumno['asistencia'] && !empty(trim($icapturaalumno['asistencia']))){
						$icaasistencia=(int)$icapturaalumno['asistencia'];
					}
					if($icapturaalumno['tareasolicitada'] && !empty(trim($icapturaalumno['tareasolicitada']))){
						$icatsolicitada=(int)$icapturaalumno['tareasolicitada'];
					}
					if($icapturaalumno['tareaentregada'] && !empty(trim($icapturaalumno['tareaentregada']))){
						$icatentregada=(int)$icapturaalumno['tareaentregada'];
					}
					if($icatsolicitada!="-" && $icatentregada!="-"){
						$icatfaltantes=$icatsolicitada-$icatentregada;
					}
					if($icapturaalumno['detalle'] && !empty($icapturaalumno['detalle'])){
						$icatasistenciadet=$icapturaalumno['detalle'];
					}
				}
				$ialumnocapturas[]=[
					"ordy"=>$ordy2,
					"ord"=>1,
					"idp"=>$kperiodo,
					"kind"=>"T",
					"row"=>$iperiodoname,
					"rowf"=>$iperiodofname,
					"col"=>"T",
					"colf"=>"Tareas Solicitadas",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"val"=>$icatsolicitada
				];
				$ialumnocapturas[]=[
					"ordy"=>$ordy2,
					"ord"=>2,
					"idp"=>$kperiodo,
					"kind"=>"TE",
					"row"=>$iperiodoname,
					"rowf"=>$iperiodofname,
					"col"=>"TE",
					"colf"=>"Tareas Entregadas",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"val"=>$icatentregada
				];
				$ialumnocapturas[]=[
					"ordy"=>$ordy2,
					"ord"=>3,
					"idp"=>$kperiodo,
					"kind"=>"TF",
					"row"=>$iperiodoname,
					"rowf"=>$iperiodofname,
					"col"=>"TF",
					"colf"=>"Tareas Faltantes",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"val"=>$icatfaltantes
				];
				$ialumnocapturas[]=[
					"ordy"=>$ordy2,
					"ord"=>4,
					"idp"=>$kperiodo,
					"kind"=>"F",
					"row"=>$iperiodoname,
					"rowf"=>$iperiodofname,
					"col"=>"F",
					"colf"=>"Inasistencias",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"val"=>$icaasistencia
				];
				$ialumnocapturas[]=[
					"ordy"=>$ordy2,
					"ord"=>5,
					"idp"=>$kperiodo,
					"kind"=>"O",
					"row"=>$iperiodoname,
					"rowf"=>$iperiodofname,
					"col"=>"O",
					"colf"=>"Observaciones",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"val"=>$icaobservacion
				];
				if($icatasistenciadet){
					$iasistenciaindex=0;
					foreach($icatasistenciadet AS $iicatasistenciadet){
						$iasistenciaindex++;
						$ialumnocapturas[]=[
							"ordy"=>$ordy2,
							"ord"=>1000+$iasistenciaindex,
							"idp"=>$kperiodo,
							"kind"=>"FD",
							"row"=>$iperiodoname,
							"rowf"=>$iperiodofname,
							"col"=>"M$iasistenciaindex",
							"colf"=>"Mes $iasistenciaindex",
							"pcol"=>$iperiodoname,
							"pcolf"=>$iperiodofname,
							"val"=>$iicatasistenciadet['asistencia']
						];
					}
				}
				//$conductas=$dbm->getCCCalificacionconductaByPeriodoevaluacionAlumnociclogrupo($kperiodo,$kalumnociclogrupo);
				$ipconducta=$dbm->getCCPromedioByPeriodoevaluacionAlumnociclogrupo($kperiodo,$kalumnociclogrupo);
				$ipconductaes=$ipconducta['escala'];
				$ialumnoconducta[]=[
					"ordy"=>1,
					"ord"=>$ord,
					"idp"=>$kperiodo,
					"kind"=>"CO",
					"kindv"=>2,//$itcalificacion,
					"row"=>$ftotal,
					"rowf"=>$ftotalf,
					"col"=>"CO",
					"colf"=>"Conducta",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"val"=>(!$visible || empty($ipconductaes) ? "-" : $ipconductaes)
				];
				/*
				$conductasmrel=[];
				foreach($conductas AS &$iconducta){
					$conductasmrel[$iconducta['materiaid']]=$iconducta;
					unset($iconducta);
				}*/
				$solofinal=false;
				foreach($materias AS $kmateria=>$imateria){
					list($imaterianame, $imaterianamef, $ia, $ikmateria, $kmateriape, $isSub,$imateriapraw)=$imateria;
					list($kmateriap,$imateriapname,$imateriapnamef)=$imateriapraw;
					$imateriape=$materiapeRel[$kmateriape];
					$iprofesormppe=$profesormppe[$kmateriape];
					$solofinal=$imateriape['materiafrecuenciacapturaid']==2;
					$curricular=$imateriape['escurricular'];
					$kplanestudio=$imateriape['planestudioid'];
					$kccurricular=$imateriape['componentecurricularid'];
					$iccurricular=trim($imateriape['componentecurricular']);
					//$iconducta=$conductasmrel[$kmateria];
					if($isSub){
						$valid=$dbm->validBISubmateriaConfig($cicloid, $gradoid, $kplanestudio, $kperiodo, $kmateriape, $ikmateria);
						if(!$valid){
							continue;
						}
					}
					if(!$profesorFirst){
						$profesorFirst=$dbm->getProfesorPorMateriaPlanEstudiosById($iprofesormppe);
					}
					if(!isset($ordyMateria[$kmateria])){
						$iorden=$imateriape['ordeninterno'];
						if(!isset($ordenRel[$iorden])){ $ordenRel[$iorden]=0; }
						$ordenAdd=$ordenRel[$iorden]++;
						$ordyMateria[$kmateria]=($iorden*100)+$ordenAdd;
					}
					$ordy=$ordyMateria[$kmateria];
					$icriterios=(isset($imateriacriterios[$kmateria]) ? $imateriacriterios[$kmateria] : []);
					$imateriascore=(isset($imateriascores[$kmateria]) ? $imateriascores[$kmateria] : false);
					$itcalificacion=$imateriape['tipocalificacionid'];
					$inivel=false;
					$ifaltas=0;
					$icalificacion=0;
					$iobservacion=null;
					if($imateriascore){
						list($icalificacion,$inivel,$iobservacion,$irecuperacion)=$imateriascore;
						if($irecuperacion!==null){
							$icalificacionold=$icalificacion;
							$icalificacion=$irecuperacion;
							$irecuperacion=$icalificacionold;
						}
						if($luxbachillerato){
							if(!$isCIIAdded){
								$isCIIAdded=true;
								$ialumnodata[]=[
									"ordy"=>$ordy,
									"ord"=>900000,
									"idp"=>$kperiodo,
									"kind"=>"EEC",
									"kindv"=>$itcalificacion,
									"row"=>$imaterianame,
									"rowf"=>$imaterianamef,
									"col"=>"C",
									"colf"=>"Cal.",
									"pcol"=>"C.I.",
									"pcolf"=>"C.I.",
									"pmat"=>$imateriapname,
									"pmatf"=>$imateriapnamef,
									"com"=>$iccurricular,
									"kcom"=>$kccurricular,
									"curr"=>$curricular,
									"val"=>null
								];
							}
							$extra=null;
							$iresumen=$resumenFinal[$kmateria];							
							if($iresumen[2]){
								$inkindex=$indexperiodo-1;
								$extras=$dbm->getBIExtraordinarios($ialumnoid, $iprofesormppe);
								if(isset($extras[$inkindex])){
									$extra=$extras[$inkindex]["cali"];
								}
							}
							$ialumnodata[]=[
								"ordy"=>$ordy,
								"ord"=>900000+$indexperiodo,
								"idp"=>$kperiodo,
								"kind"=>"EEC",
								"kindv"=>$itcalificacion,
								"row"=>$imaterianame,
								"rowf"=>$imaterianamef,
								"col"=>"C",
								"colf"=>"Cal.",
								"pmat"=>$imateriapname,
								"pmatf"=>$imateriapnamef,
								"pcol"=>"EER($indexperiodo)",
								"pcolf"=>"EER($indexperiodo)",
								"com"=>$iccurricular,
								"kcom"=>$kccurricular,
								"curr"=>$curricular,
								"val"=>$extra
							];
						}
					}

					//Columna faltas
					if(!isset($totalFaltas[$kmateria])){ $totalFaltas[$kmateria]=0; }
					if(!empty($imateriape['ponderaciones'])/* || $itcalificacion==1*/){ $hasPonderacion=true; }
					if($imateriascore){
						$ifaltas=sizeof($dbm->getFaltasAlumnoLD($ialumnocicloid,$iprofesormppe,$kperiodo));
						$totalPFaltas+=$ifaltas;
					}
					$totalFaltas[$kmateria]+=$ifaltas;
					$ialumnodata[]=[//Faltas
						"ordy"=>$ordy,
						"ord"=>$ord+$ordfaltas,
						"idp"=>$kperiodo,
						"kind"=>"F",
						"kindv"=>$itcalificacion,
						"row"=>$imaterianame,
						"rowf"=>$imaterianamef,
						"col"=>"F",
						"colf"=>"Faltas",
						"pcol"=>$iperiodoname,
						"pcolf"=>$iperiodofname,
						"pmat"=>$imateriapname,
						"pmatf"=>$imateriapnamef,
						"com"=>$iccurricular,
						"kcom"=>$kccurricular,
						"curr"=>$curricular,
						"val"=>(!$imateriascore ? "-" : $ifaltas)
					];

					//Columna periodo
					$ialumnodata[]=[//Calificacion
						"ordy"=>$ordy,
						"ord"=>$ord+$ordcalis,
						"idp"=>$kperiodo,
						"kind"=>"C",
						"kindv"=>$itcalificacion,
						"row"=>$imaterianame,
						"rowf"=>$imaterianamef,
						"col"=>"C",
						"colf"=>"Cal.",
						"pcol"=>$iperiodoname,
						"pcolf"=>$iperiodofname,
						"pmat"=>$imateriapname,
						"pmatf"=>$imateriapnamef,
						"com"=>$iccurricular,
						"kcom"=>$kccurricular,
						"curr"=>$curricular,
						"val"=>(!$imateriascore || $itcalificacion==1 ? "-" : (empty($icalificacion) ? 0 : $icalificacion)),
						"valo"=>$irecuperacion
					];
					$ialumnodata[]=[//Nivel desempeño
						"ordy"=>$ordy,
						"ord"=>$ord+$ordcalis+1,
						"idp"=>$kperiodo,
						"kind"=>"N",
						"kindv"=>$itcalificacion,
						"row"=>$imaterianame,
						"rowf"=>$imaterianamef,
						"col"=>"N",
						"colf"=>"Nivel",
						"pcol"=>$iperiodoname,
						"pcolf"=>$iperiodofname,
						"pmat"=>$imateriapname,
						"pmatf"=>$imateriapnamef,
						"com"=>$iccurricular,
						"kcom"=>$kccurricular,
						"curr"=>$curricular,
						"val"=>(!$imateriascore || empty($imateriape['ponderaciones']) || empty($inivel) ? "-" : $inivel)
					];
					$iobservacionf=(empty($iobservacion) ? "-" : $iobservacion);
					$ialumnodata[]=[//Observaciones
						"ordy"=>$ordy,
						"ord"=>$ord+$ordcalis+2,
						"idp"=>$kperiodo,
						"kind"=>"O",
						"kindv"=>$itcalificacion,
						"row"=>$imaterianame,
						"rowf"=>$imaterianamef,
						"col"=>"O",
						"colf"=>"Observacion",
						"pcol"=>$iperiodoname,
						"pcolf"=>$iperiodofname,
						"pmat"=>$imateriapname,
						"pmatf"=>$imateriapnamef,
						"com"=>$iccurricular,
						"kcom"=>$kccurricular,
						"curr"=>$curricular,
						"val"=>$iobservacionf
					];
					if($iobservacionf!="-"){
						$kalumnoobservaciones[$kperiodo][($itcalificacion==2 ? "can" : "cal")][]="$imaterianame.-$iobservacionf";
					}
					

					$tareascal=0;
					$tareastotal=0;
					foreach($icriterios AS $icriterio){
						$icriterioname=$icriterio['nombre'];
						$isTarea=$icriterio['tarea'];
						$icapcount=$icriterio['capturas'];
						$icaptotal=0;
						if($isTarea){
							$tareastotal+=$icapcount;
						}
						foreach($icriterio['calificaciones'] AS $icaptura){
							$icriteriocal=(isset($icaptura['calificacion']) ? $icaptura['calificacion'] : null);
							if($isTarea && !empty($icriteriocal) && is_numeric($icriteriocal) && $icriteriocal!=0){
								$tareascal++;
							}
							if($icriteriocal!==null){
								$icaptotal+=$icriteriocal;
							}
						}
						if($icapcount && $icapcount>0){
							$ialumnocriterios[]=[
									"ordy"=>$ordy,
									"ord"=>$ord,
									"idp"=>$kperiodo,
									"kind"=>"CI",
									"row"=>$imaterianame,
									"rowf"=>$imaterianamef,
									"col"=>$icriterioname,
									"colf"=>$icriterioname,
									"pcol"=>$iperiodoname,
									"pcolf"=>$iperiodofname,
									"pmat"=>$imateriapname,
									"pmatf"=>$imateriapnamef,
									"com"=>$iccurricular,
									"kcom"=>$kccurricular,
									"curr"=>$curricular,
									"val"=>$icaptotal/$icapcount
								];
						}
					}
					$tareasdiff=$tareastotal-$tareascal;
					$ialumnotareas[]=[
						"ordy"=>$ordy,
						"ord"=>$ord,
						"idp"=>$kperiodo,
						"kind"=>"T",
						"row"=>$imaterianame,
						"rowf"=>$imaterianamef,
						"col"=>"T",
						"colf"=>"Tareas",
						"pcol"=>$iperiodoname,
						"pcolf"=>$iperiodofname,
						"pmat"=>$imateriapname,
						"pmatf"=>$imateriapnamef,
						"com"=>$iccurricular,
						"kcom"=>$kccurricular,
						"curr"=>$curricular,
						"val"=>$tareastotal
					];
					$ialumnotareas[]=[
						"ordy"=>$ordy,
						"ord"=>$ord+1,
						"idp"=>$kperiodo,
						"kind"=>"TE",
						"row"=>$imaterianame,
						"rowf"=>$imaterianamef,
						"col"=>"E",
						"colf"=>"Entregadas",
						"pcol"=>$iperiodoname,
						"pcolf"=>$iperiodofname,
						"pmat"=>$imateriapname,
						"pmatf"=>$imateriapnamef,
						"com"=>$iccurricular,
						"kcom"=>$kccurricular,
						"curr"=>$curricular,
						"val"=>$tareascal
					];
					$ialumnotareas[]=[
						"ordy"=>$ordy,
						"ord"=>$ord+2,
						"idp"=>$kperiodo,
						"kind"=>"TF",
						"row"=>$imaterianame,
						"rowf"=>$imaterianamef,
						"col"=>"F",
						"colf"=>"Faltantes",
						"pcol"=>$iperiodoname,
						"pcolf"=>$iperiodofname,
						"pmat"=>$imateriapname,
						"pmatf"=>$imateriapnamef,
						"com"=>$iccurricular,
						"kcom"=>$kccurricular,
						"curr"=>$curricular,
						"val"=>$tareasdiff
					];

					if(!isset($calsMaterias[$kmateria])){ $calsMaterias[$kmateria]=[]; }
					//Promedio materia
					if($itcalificacion!=1 && ($curricular || !$isLux)){
						//Se valida si se toma la materia para todos los periodos
						//Si solo se captura en la final, validamos que estamos en el ultimo periodo para tomarla en cuenta
						if(!$solofinal || $ultimoperiodo){
							$dical=(float) $icalificacion;
							$calsMaterias[$kmateria][]=[$dical,$icalificacionperc];
							$calsPeriodo[]=[$dical,$icalificacionperc];
						}
					}else{//Obtener promedio desde servicio
						
					}
				}

				//Promedio periodo
				$roundFunctions=$dbm->getRoundFunctionNameByMateriaplanestudio($kmateriape);
				$rdfnPeriodo=$roundFunctions['final'];
				$promPeriodo=$this->calcPromedioFinalMateria(true,$calsPeriodo);
				$promPeriodoRnd=$dbm->getRoundedValueByFunctionName($rdfnPeriodo,$promPeriodo);

				$ialumnodata[]=[//Faltas periodo
					"ordy"=>999999,
					"ord"=>$ord+$ordfaltas,
					"idp"=>$kperiodo,
					"kind"=>"F",
					"kindv"=>2,//$itcalificacion,
					"row"=>$ftotal,
					"rowf"=>$ftotalf,
					"col"=>"F",
					"colf"=>"Faltas",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"com"=>"",
					"val"=>($visible ? $totalPFaltas : "-")
				];
				$ialumnodata[]=[//Calificacion periodo
					"ordy"=>999999,
					"ord"=>$ord+$ordcalis,
					"idp"=>$kperiodo,
					"kind"=>"C",
					"kindv"=>2,//$itcalificacion,
					"row"=>$ftotal,
					"rowf"=>$ftotalf,
					"col"=>"C",
					"colf"=>"Cal.",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"com"=>"",
					"val"=>($visible ? $promPeriodoRnd : "-"),
				];
				$ialumnodata[]=[//Nivel desempeño
					"ordy"=>999999,
					"ord"=>$ord+$ordcalis+1,
					"idp"=>$kperiodo,
					"kind"=>"N",
					"kindv"=>2,//$itcalificacion,
					"row"=>$ftotal,
					"rowf"=>$ftotalf,
					"col"=>"N",
					"colf"=>"Nivel",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"com"=>"",
					"val"=>"-"
				];
				$ialumnodata[]=[//Observaciones
					"ordy"=>999999,
					"ord"=>$ord+$ordcalis+2,
					"idp"=>$kperiodo,
					"kind"=>"O",
					"kindv"=>2,//$itcalificacion,
					"row"=>$ftotal,
					"rowf"=>$ftotalf,
					"col"=>"O",
					"colf"=>"Observacion",
					"pcol"=>$iperiodoname,
					"pcolf"=>$iperiodofname,
					"com"=>"",
					"val"=>"-"
				];
				$ord+=4;
				$ordy2++;
				$promPeriodos[]=[$promPeriodoRnd,$icalificacionperc];
			}

			$totalPFaltas=0;
			foreach($totalFaltas AS $kmateria=>$ifaltas){
				list($imaterianame, $imaterianamef, $ia, $ia1, $materiapeid, $isSub,$imateriapraw)=$materias[$kmateria];
				list($kmateriap,$imateriapname,$imateriapnamef)=$imateriapraw;
				$imateriape=$materiapeRel[$materiapeid];
				$curricular=$imateriape['escurricular'];
				$kccurricular=$imateriape['componentecurricularid'];
				$iccurricular=trim($imateriape["componentecurricular"]);
				$itcalificacion=$imateriape['tipocalificacionid'];
				$ialumnodata[]=[//Faltas total
					"ordy"=>$ordyMateria[$kmateria],
					"ord"=>$ord+$ordfaltas,
					"idp"=>$kfinal,
					"kind"=>"F",
					"kindv"=>$itcalificacion,
					"row"=>$imaterianame,
					"rowf"=>$imaterianamef,
					"col"=>"F",
					"colf"=>"Faltas",
					"pcol"=>$nfinal,
					"pcolf"=>$ffinal,
					"pmat"=>$imateriapname,
					"pmatf"=>$imateriapnamef,
					"com"=>$iccurricular,
					"kcom"=>$kccurricular,
					"curr"=>$curricular,
					"val"=>$ifaltas
				];
				$totalPFaltas+=$ifaltas;
			}
			foreach($calsMaterias AS $kmateria=>$icalsMateria){
				list($imaterianame, $imaterianamef, $ia, $ia1, $materiapeid, $isSub,$imateriapraw)=$materias[$kmateria];
				list($kmateriap,$imateriapname,$imateriapnamef)=$imateriapraw;
				$imateriape=$materiapeRel[$materiapeid];
				$curricular=$imateriape['escurricular'];
				$kccurricular=$imateriape['componentecurricularid'];
				$iccurricular=trim($imateriape["componentecurricular"]);
				$itcalificacion=$imateriape['tipocalificacionid'];
				$imateriapeops=$dbm->getOpcionesByMateriaporplanestudio($materiapeid);
				$roundFunctions=$dbm->getRoundFunctionNameByMateriaplanestudio($materiapeid);
 				$rdfnMateria=$roundFunctions['materia'];
				
				$promExtra=false;
				$promMateria=$this->calcPromedioFinalMateria($promediable,$icalsMateria);
				$promMateriaRnd=$dbm->getRoundedValueByFunctionName($rdfnMateria,$promMateria);
				if($periodoLast){
					list($promMateria,$promPond, $promExtra)=$resumenFinal[$kmateria];
					$promMateriaRnd=$promMateria;
				}

				$ialumnodata[]=[//Calificacion total
					"ordy"=>$ordyMateria[$kmateria],
					"ord"=>$ord+$ordcalis,
					"idp"=>$kfinal,
					"kind"=>"C",
					"kindv"=>$itcalificacion,
					"row"=>$imaterianame,
					"rowf"=>$imaterianamef,
					"col"=>"C",
					"colf"=>"Cal.",
					"pcol"=>$nfinal,
					"pcolf"=>$ffinal,
					"pmat"=>$imateriapname,
					"pmatf"=>$imateriapnamef,
					"com"=>$iccurricular,
					"kcom"=>$kccurricular,
					"curr"=>$curricular,
					"val"=>($periodoLast ? $promMateriaRnd : "-"),
					"ext"=>$promExtra
				];
				$ialumnodata[]=[//Nivel desempeño total
					"ordy"=>$ordyMateria[$kmateria],
					"ord"=>$ord+$ordcalis+1,
					"idp"=>$kfinal,
					"kind"=>"N",
					"kindv"=>$itcalificacion,
					"row"=>$imaterianame,
					"rowf"=>$imaterianamef,
					"col"=>"N",
					"colf"=>"Nivel",
					"pcol"=>$nfinal,
					"pcolf"=>$ffinal,
					"pmat"=>$imateriapname,
					"pmatf"=>$imateriapnamef,
					"com"=>$iccurricular,
					"kcom"=>$kccurricular,
					"curr"=>$curricular,
					"val"=>($imateriapeops && $periodoLast ? $this->calcPonderacion($imateriapeops,$promMateriaRnd) : "-")
				];
				$ialumnodata[]=[//Observacion total
					"ordy"=>$ordyMateria[$kmateria],
					"ord"=>$ord+$ordcalis+2,
					"idp"=>$kfinal,
					"kind"=>"O",
					"kindv"=>$itcalificacion,
					"row"=>$imaterianame,
					"rowf"=>$imaterianamef,
					"col"=>"O",
					"colf"=>"Observacion",
					"pcol"=>$nfinal,
					"pcolf"=>$ffinal,
					"pmat"=>$imateriapname,
					"pmatf"=>$imateriapnamef,
					"com"=>$iccurricular,
					"kcom"=>$kccurricular,
					"curr"=>$curricular,
					"val"=>'-'
				];
			}
			//Promedio final
			$rdfnPeriodo=$roundFunctions['final'];
			$promFinal=$this->calcPromedioFinalMateria($promediable,$promPeriodos);
			$promFinalRnd=$dbm->getRoundedValueByFunctionName($rdfnPeriodo,$promFcal);
			$ialumnodata[]=[//Faltas periodo
				"ordy"=>999999,
				"ord"=>$ord+$ordfaltas,
				"idp"=>$kfinal,
				"kind"=>"F",
				"kindv"=>2,//$itcalificacion,
				"row"=>$ftotal,
				"rowf"=>$ftotalf,
				"col"=>"F",
				"colf"=>"Faltas",
				"pcol"=>$nfinal,
				"pcolf"=>$ffinal,
				"com"=>"",
				"val"=>$totalPFaltas
			];
			$ialumnodata[]=[//Calificacion periodo
				"ordy"=>999999,
				"ord"=>$ord+$ordcalis,
				"idp"=>$kfinal,
				"kind"=>"C",
				"kindv"=>2,//$itcalificacion,
				"row"=>$ftotal,
				"rowf"=>$ftotalf,
				"col"=>"C",
				"colf"=>"Cal.",
				"pcol"=>$nfinal,
				"pcolf"=>$ffinal,
				"com"=>"",
				"val"=>($periodoLast ? $promFinalRnd : "-")
			];
			$ialumnodata[]=[//Nivel desempeño
				"ordy"=>999999,
				"ord"=>$ord+$ordcalis+1,
				"idp"=>$kfinal,
				"kind"=>"N",
				"kindv"=>2,//$itcalificacion,
				"row"=>$ftotal,
				"rowf"=>$ftotalf,
				"col"=>"N",
				"colf"=>"Nivel",
				"pcol"=>$nfinal,
				"pcolf"=>$ffinal,
				"com"=>"",
				"val"=>"-"
			];
			$ialumnodata[]=[//Observacion
				"ordy"=>999999,
				"ord"=>$ord+$ordcalis+2,
				"idp"=>$kfinal,
				"kind"=>"O",
				"kindv"=>2,
				"row"=>$ftotal,
				"rowf"=>$ftotalf,
				"col"=>"O",
				"colf"=>"Observacion",
				"pcol"=>$nfinal,
				"pcolf"=>$ffinal,
				"com"=>"",
				"val"=>"-"
			];
			$ord+=4;

			if($luxbachillerato){
				$ialumnodata[]=[
					"ordy"=>999999,
					"ord"=>900000,
					"idp"=>"LUXBAC",
					"kind"=>"EEC",
					"kindv"=>$itcalificacion,
					"row"=>$ftotal,
					"rowf"=>$ftotalf,
					"col"=>"C",
					"colf"=>"Cal.",
					"pcol"=>"C.I.",
					"pcolf"=>"C.I.",
					"com"=>"",
					"val"=>"-"
				];
				$ord++;
				for($i=1;$i<=$indexperiodo;$i++,$ord++){
					$ialumnodata[]=[
						"ordy"=>999999,
						"ord"=>900000+$indexperiodo,
						"idp"=>"LUXBAC",
						"kind"=>"EEC",
						"kindv"=>$itcalificacion,
						"row"=>$ftotal,
						"rowf"=>$ftotalf,
						"col"=>"C",
						"colf"=>"Cal.",
						"pmat"=>null,//"",
						"pmatf"=>null,//"",
						"pcol"=>"EER($i)",
						"pcolf"=>"EER($i)",
						"com"=>null,//$iccurricular,
						"kcom"=>null,//$kccurricular,
						"curr"=>null,//$curricular,
						"val"=>"-"
					];
				}
			}
			$ialumnoobservaciones=[];
			foreach($kalumnoobservaciones AS $iaobs){
				$iaobs["can"]=implode("; ", $iaobs["can"]);
				$iaobs["cal"]=implode("; ", $iaobs["cal"]);
				$ialumnoobservaciones[]=$iaobs;
			}

			usort($ialumnodata, "AppBundle\Controller\Controlescolar\BoletaImpresionController::fnPDFOrden");
			usort($ialumnotareas, "AppBundle\Controller\Controlescolar\BoletaImpresionController::fnPDFOrden");
			usort($ialumnoconducta, "AppBundle\Controller\Controlescolar\BoletaImpresionController::fnPDFOrden");
			usort($ialumnocriterios, "AppBundle\Controller\Controlescolar\BoletaImpresionController::fnPDFOrden");
			$promFinalGeneral=(!$periodoLast ? "-" : $promFinalRnd);
			$data[$ialumnocicloid]=[
					"u"=>$ccurriculares,
					"d"=>$ialumnodata,
					"c"=>$ialumnocapturas,
					"ci"=>$ialumnocriterios,
					"co"=>$ialumnoconducta,
					"t"=>$ialumnotareas,
					"o"=>$ialumnoobservaciones,
					"r"=>[
						"pfinal"=>$promFinalGeneral,
						"nfinal"=>""
					],
					"_r_"=>[
						"profesor"=>($profesorFirst ? $profesorFirst["nombre"] : ""),
						"ponderacion"=>$hasPonderacion,
						"periodolast"=>$periodoLast,
						"periodotarget"=>$periodoLatest,
						"periodolatest"=>($periodoLatest ? (!$periodoLast ? $periodoLatest : [
								"id"=>$kfinal,
								"descripcion"=>$ffinal,
								"descripcioncorta"=>$nfinal
							]) : "")
					]
			];
		}
		return $data;
	}
	public static function fnPDFOrden($a,$b){
		$result=$a['ordy']<=>$b['ordy'];
		if($result==0){
			$result=$a['ord']<=>$b['ord'];
		}
		return $result;
	}
	private function calcPromedioFinalMateria($promediable,$data){
		$sum=0;
		if($promediable){
			$count=0;
			foreach($data AS $i){
				list($calificacion)=$i;
				$count++;
				$sum+=$calificacion;
			}
			return ($count>0 ? $sum/$count : 0);
		}
		foreach($data AS $i){
			list($calificacion,$porcentaje)=$i;
			$sum+=($calificacion*$porcentaje/100);
		}
		return $sum;
	}
	private function getRoundedAverageProcess($dbm,$fnName,$data){
		list($periodos,$calAcumulada)=$data;
		return $dbm->getRoundedValueByFunctionName($fnName,($periodos<=0 ? 0 : $calAcumulada/$periodos));
	}
	private function calcPonderacion($ponderacion,$calificacion){
		foreach($ponderacion AS $i){
			if($i['calificacionminima']<=$calificacion
				&& $calificacion<=$i['calificacionmaxima'])
				return $i['descripcioncorta'];
		}
		return "";
	}

	public static function getBIPDFCalificacionesRaw($dbManager,$kciclo,$knivel,$kgrado,$periodosRaw,$materiape,$kalumno,$kalumnociclo,$usuarioid="nada"){
		$dbm=new DbmControlescolar($dbManager->getEntityManager());
		$alumnos=array();
		$periodos=array();
		$materias=array();
		$calificacion=array();
		$calls=0;
		$totaltime=0;
		$highertime=0;
		foreach($periodosRaw AS $periodoi){
			$materiasupdated=[];
			$kperiodo=$periodoi['id'];
			$periodos[]=$kperiodo;
			$at=time();
			$dataRaw=CapturaCalificacionReporteController::getCCRCalificacionesProcessByAlumnociclo($dbm,$kalumnociclo,[
					"periodoevaluacionid"=>$kperiodo
				]);
			$nt=time()-$at;
			$totaltime+=$nt;
			if($highertime<$nt){ $highertime=$nt; }
			//echo ">>> Execution time (getCCRCalificacionesProcessByAlumnociclo [$kalumnociclo, $kperiodo]): $nt seconds.\n";
			if($dataRaw && $dataRaw["planestudio"]){
				//foreach($materiape AS $imateriape){
					//$materiapeid=$imateriape['materiaporplanestudioid'];
					//$kprofesormpe=$imateriape['profesorpormateriaplanestudiosid'];
				$calls++;
				$at=time();
				$planestudio=$dataRaw["planestudio"];
				$scores=$dataRaw["scores"][$kperiodo];				
				$materiasRaw=$dataRaw["materias"];
				$kplanestudio=$planestudio["planestudioid"];
				foreach($materiasRaw AS $imateriaRaw){
					$ikmateria=$imateriaRaw["materiaid"];
					$isubmateria=$imateriaRaw["submateria"];
					$imateriaName=$imateriaRaw["nombre"];
					$imateriape=$imateriaRaw["materiape"];
					$kmateriape=$imateriape["materiaporplanestudioid"];
					$iscore=$scores[$ikmateria];
					$iextra=$iscore["extracalificacion"];
					$irecs=$iscore["recuperaciones"];
					$icriterios=$iscore["criterios"];
					$alumnos[$kalumno]=$kalumno;

					$hasExtra=false;
					$scorerec=null;
					$scoreextra=null;
					$asignidprefix="";
					$kmateriap="";
					$imateriapalias="";
					$imateriapname="";
					if($isubmateria){
						$valid=$dbm->validBISubmateriaConfig($kciclo, $kgrado, $kplanestudio, $kperiodo, $kmateriape, $ikmateria);
						if($valid){
							$iparent=$imateriaRaw["parent"];
							$asignidprefix='s_';
							$kmateriap=$iparent["materiaid"];
							$imateriapalias=$iparent["alias"];
							$imateriapname=$iparent["nombre"];
						}else{
							continue;
						}
					}
					
					if($iextra){
						$scoreextra=$iextra;
						$hasExtra=true;
					}
					if($irecs){ $scorerec=$irecs[0]["calificacion"]; }

					if(!isset($calificacion[$kalumno])){
						$calificacion[$kalumno]=['r'=>[],'d'=>[],'c'=>[]];
					}
					if(!isset($calificacion[$kalumno]['d'][$kperiodo])){
						$calificacion[$kalumno]['d'][$kperiodo]=array();
					}
					if(!isset($calificacion[$kalumno]['c'][$kperiodo])){
						$calificacion[$kalumno]['c'][$kperiodo]=array();
					}

					$iasignid=$asignidprefix.$ikmateria;
					$icalificacionraw=$iscore['calificacion'];//Calificacion periodo
					$icalificacionfraw=$iscore['finalcalificacion'];//Calificacion final
					$iponderacionraw=$iscore['ponderacion'];//Ponderacion periodo
					$iponderacionfraw=$iscore['finalponderacion'];//Ponderacion final

					//Calificacion periodo
					$icalificacion=(empty($icalificacionraw) && $icalificacionraw!=="0" && $icalificacionraw!==0)
						? null : $icalificacionraw;

					//Calificacion final
					$icalificacionf=(empty($icalificacionfraw) && $icalificacionfraw!=="0" && $icalificacionfraw!==0)
						? null : $icalificacionfraw;

					//Ponderacion periodo
					$iaponderacion=empty($iponderacionraw)
						? null : $iponderacionraw;

					//Ponderacion final
					$iaponderacionf=empty($iponderacionfraw)
						? null : $iponderacionfraw;

					//Observaciones
					$iobservacion=(!isset($iscore['observacion']) || empty(trim($iscore['observacion']))
						? null : trim($iscore['observacion']));

					if($scoreextra!==null){
						if(ENTORNO == 2) {
							$icalificacionf=$scoreextra;
						}
					}

					if($icriterios){
						$icriteriosdata=[];
						foreach($icriterios AS $icriterio){
							$icriteriocals=[];
							foreach($icriterio['calificacion'] AS $icriteriocaptura){
								$icriteriocals[]=[
										"captura"=>$icriteriocaptura['numerocaptura'],
										"calificacion"=>$icriteriocaptura['calificacion']
								];
							}
							$icriteriosdata[]=[
									"tarea"=>$icriterio['configurartarea']==1,
									"nombre"=>$icriterio['aspecto'],
									"capturas"=>$icriterio['capturas'],
									"calificaciones"=>$icriteriocals
							];
						}
						$calificacion[$kalumno]['c'][$kperiodo][$iasignid]=$icriteriosdata;
					}

					if(!isset($materiasupdated[$iasignid])){
						$smcpmpeid=$kmateriape;
						$smcpid=$ikmateria;
						$smcpperiodos=0;
						$smcpnamef=$imateriaName;
						if(isset($materias[$iasignid])){
							list($smcpname,$smcpnamef,$smcpperiodos,$smcpid,$smcpmpeid)=$materias[$iasignid];
						}else{
							$imateriadata=$dbm->getBIMateriaById($smcpid);
							$smcpname=$imateriadata['alias'];
						}
						$smcpperiodos++;
						$materias[$iasignid]=[$smcpname,$smcpnamef,$smcpperiodos,$smcpid,$smcpmpeid,$isubmateria,[$kmateriap,$imateriapalias,$imateriapname]];
						$materiasupdated[$iasignid]=true;
					}
					$rfr = $imateriape['escurricular'];
					$calificacion[$kalumno]['r'][$iasignid]=[$icalificacionf, ($iaponderacionf ? $iaponderacionf : false), $hasExtra, $rfr];
					$calificacion[$kalumno]['d'][$kperiodo][$iasignid]=[$icalificacion,($iaponderacion ? $iaponderacion : false),$iobservacion,$scorerec];
				}
				$nt=time()-$at;
				//echo ">>> Execution time (Parsing): $nt seconds.\n";
			}//else{ echo ">Failed to execute [$kperiodo,$materiapeid]."; }
		}
		/*/
		echo "\n\n\n";
		echo ">>> Total Execution time (CCCapturaCalificacionGrupoProcess): $totaltime seconds.\n";
		echo ">>> Average Execution time (CCCapturaCalificacionGrupoProcess): ".($totaltime/$calls)." seconds.\n";
		echo ">>> Higher Execution time (CCCapturaCalificacionGrupoProcess): $highertime seconds.\n";
		echo ">>> $calls fuckin' calls; this is slow as shit nigga\n\n\n";
		//echo json_encode($subs)."\n\n\n";
		//*/
		return [$alumnos,$materias,array_unique($periodos),$calificacion];
	}

	public function loadBIPDFReport($filePath,$grupoid, $oficial){
		$rs=$this->getDM()->getBIPDFReportByGrupo($grupoid, $oficial);
		if($rs && sizeof($rs)>0){
			$data=$rs[0];
			if(!$data || !$data['formato']){ return false; }
			$fdata=json_decode(stream_get_contents($data['formato']),true);
			$jasper=base64_decode($fdata['value']);
			$file=LDPDF::fileRead($filePath);
			LDPDF::fileWrite($file, $jasper);
			LDPDF::fileRelease($file);
			return true;
		}
		return false;
	}

	public function loadBIPDFData($config, $calificaciones, $grupoid, $alumnocicloid, $filePath){
		$resumeParams=$calificaciones["_r_"];
		unset($calificaciones["_r_"]);
		$data=array(
			"config"=>$config,
			"calis"=>$calificaciones,
			"observaciones"=>[],
			"student"=>$this->getBIPDFStudent($grupoid, $alumnocicloid)
		);
		if($data['student']){
			$data["student"]["profesor"]=$resumeParams["profesor"];
			$data["student"]["ponderacion"]=$resumeParams["ponderacion"];
			$data["student"]["periodolast"]=$resumeParams["periodolast"];
			$data["student"]["periodotarget"]=$resumeParams["periodotarget"];
			$data["student"]["periodolatest"]=$resumeParams["periodolatest"];

			$dataj=json_encode($data);
			//echo($dataj);exit;
			$file=LDPDF::fileRead($filePath);
			LDPDF::fileWrite($file, $dataj);
			LDPDF::fileRelease($file, $data);
			return true;
		}
		return false;
	}

	private function getBIPDFStudent($grupoid, $alumnocicloid){
		$rs=$this->getDM()->getBIPDFStudentByGrupoAlumnociclo($grupoid, $alumnocicloid);
		if($rs && $rs[0]){
			$student=$rs[0];
			$namef=$student['primernombre'];
			$names=$student['segundonombre'];
			$student['nombre']=trim("".($namef ? $namef : '')." ".($names ? $names : ''));
			$student['fechahoy']=date("d/m/y");
			return $student;
		}
		return false;
	}

	private function getBIPDFCleanFiles($files){
		foreach($files AS $i){
			LDPDF::fileDelete($i);
		}
	}

	private function getDM(){
		if($this->DBM){
			return $this->DBM;
		}
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}