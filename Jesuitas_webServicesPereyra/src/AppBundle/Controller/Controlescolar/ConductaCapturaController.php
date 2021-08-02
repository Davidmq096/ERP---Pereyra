<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeConductacalificacion;
use AppBundle\Entity\CeMateriaporconductacalificacion;
use Exception;

/**
 * Autor: Emmanuel Martinez
 */
class ConductaCapturaController extends FOSRestController{
	private $DBM=false;
	/**
	 * @Annotations\Get("/api/Controlescolar/Conductacaptura/filter", name="getCCFilter")
	 */
	public function getCCFilter(){
		$dbm=$this->getDM();
		$ciclo=$dbm->getBasicCiclo();
		$nivel=$dbm->getBasicNivel();
		$semestre=$dbm->getBasicSemestre();
		$grado=$dbm->getBasicGrado();
		$grupo=$dbm->getBasicGrupoCurricular();
		$periodoevaluacion=$dbm->getBasicPeriodoEvaluacion();
		if($ciclo!== false && $nivel!== false && $grado!== false && $semestre!== false && $grupo!== false && $periodoevaluacion!== false){
			return Api::Ok("", array(
				"ciclo"=>$ciclo,
				"nivel"=>$nivel,
				"semestre"=>$semestre,
				"grado"=>$grado,
				"grupo"=>$grupo,
				"periodoevaluacion"=>$periodoevaluacion
			));
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/Conductacaptura/{grupoid}", name="getCCAlumnos")
	 */
	public function getCCAlumnos($grupoid){
		$dbm=$this->getDM();
		$alumnos=$dbm->getCCAlumncicloporgrupoByGrupo($grupoid);
		$materias=$this->getMateriaDataByGrupo($grupoid,(int)$_REQUEST['go']);
		return ($alumnos
			? Api::Ok("", ['alumno'=>$alumnos,'materia'=>$materias])
			: ($alumnos===false
				? Api::Error(Response::HTTP_BAD_REQUEST, false)
				: Api::Error(Response::HTTP_PARTIAL_CONTENT, "No se encontraron alumnos en el grupo indicado.")
			)
		);
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/Conductacaptura/{periodoevaluacionid}/{alumnocicloporgrupoid}", name="getCCDatos")
	 */
	public function getCCDatos($periodoevaluacionid,$alumnocicloporgrupoid){
		$dbm=$this->getDM();
		$talleres=[];
		$alumno=$dbm->getCCAlumnoByAlumnocicloporgrupo($alumnocicloporgrupoid);

		$stmt=$dbm->getConnection()->prepare('SELECT foto FROM ce_alumnofotocicloactualvista WHERE alumnoid = :alumnoid');
		$stmt->execute(array('alumnoid'=>$alumno['alumnoid']));
		$alumno['photo']=$stmt->fetch()['foto'];
		$kalumnociclo=$alumno['alumnoporcicloid'];

		$titular=false;
		$calificaciones=[];
		$calificacionesRaw=$dbm->getCCCalificacionconductaByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid);
		$promedio=$dbm->getCCPromedioByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid);
		$fechasPeriodo=$dbm->getRepositoriosModelo("CePeriodoevaluacion",
		["d.fechacapturacalinicio","d.fechacapturacalfin","d.fechaperiodorevisioninicio", "d.fechaperiodorevisionfin"],
		["periodoevaluacionid"=>$periodoevaluacionid])[0];
		
		$talleresraw=$dbm->getRepositoriosModelo("CeAlumnocicloportaller",["IDENTITY(d.tallercurricularid) AS tallercurricularid"],["alumnoporcicloid"=>$kalumnociclo]);
		foreach($talleresraw AS $i){
			$talleres[$i['tallercurricularid']]=true;
		}
		$actualTime=new \DateTime();
		$actualTime->setTime(0, 0, 0);
		$minTime=$fechasPeriodo['fechacapturacalinicio'];
		$maxTime=$fechasPeriodo['fechacapturacalfin'];
		$FRminTime=$fechasPeriodo['fechaperiodorevisioninicio']; 
		$FRmaxTime=$fechasPeriodo['fechaperiodorevisionfin']; 
		$validDate=(($minTime<=$actualTime && $actualTime<=$maxTime) || ($FRminTime<=$actualTime && $actualTime<=$FRmaxTime));
		foreach($calificacionesRaw AS $i){
			$ititular=$i['titular'];
			if(!$ititular || !$titular){
				if($ititular){
					$titular=true;
					$i['materiaid']=-1;
				}
				$calificaciones[]=$i;
			}
		}
		if($calificaciones!==false && $alumno!==false){
			return Api::Ok("", array(
					"alumno"=>$alumno,
					"talleres"=>$talleres,
					"calificacion"=>$calificaciones,
					"promedio"=>$promedio,
					"date"=>$validDate
			));
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/Conductacaptura/{periodoevaluacionid}/grupo/{grupoid}", name="getCCDatosGrupo")
	 */
	public function getCCDatosGrupo($periodoevaluacionid, $grupoid){
		$dbm=$this->getDM();
		try{
			$alumnos=$dbm->getCCAlumnosByGrupo($grupoid);
			$data = [];
			if($alumnos !== false){
				foreach($alumnos as $alumno){
					$talleres=[];
					$stmt=$dbm->getConnection()->prepare('SELECT foto FROM ce_alumnofotocicloactualvista WHERE alumnoid = :alumnoid');
					$stmt->execute(array('alumnoid'=>$alumno['alumnoid']));
					$alumno['photo']=$stmt->fetch()['foto'];
					$kalumnociclo=$alumno['alumnoporcicloid'];
		
					$titular=false;
					$calificaciones=[];
					$calificacionesRaw=$dbm->getCCCalificacionconductaByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumno['alumnocicloporgrupo']);
					$promedio=$dbm->getCCPromedioByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumno['alumnocicloporgrupo']);
					$fechasPeriodo=$dbm->getRepositoriosModelo("CePeriodoevaluacion",
					["d.fechacapturacalinicio","d.fechacapturacalfin","d.fechaperiodorevisioninicio", "d.fechaperiodorevisionfin"],
					["periodoevaluacionid"=>$periodoevaluacionid])[0];
					
					$talleresraw=$dbm->getRepositoriosModelo("CeAlumnocicloportaller",["IDENTITY(d.tallercurricularid) AS tallercurricularid"],["alumnoporcicloid"=>$kalumnociclo]);
					foreach($talleresraw AS $i){
						$talleres[$i['tallercurricularid']]=true;
					}
					$actualTime=new \DateTime();
					$actualTime->setTime(0, 0, 0);
					$minTime=$fechasPeriodo['fechacapturacalinicio'];
					$maxTime=$fechasPeriodo['fechacapturacalfin'];
					$FRminTime=$fechasPeriodo['fechaperiodorevisioninicio']; 
					$FRmaxTime=$fechasPeriodo['fechaperiodorevisionfin']; 
					$validDate=(($minTime<=$actualTime && $actualTime<=$maxTime) || ($FRminTime<=$actualTime && $actualTime<=$FRmaxTime));
					$tit = [];
					foreach($calificacionesRaw AS $i){
						if($i['titular']){
							$tit[] = $i['materiaid'];
						}
					}
					foreach($calificacionesRaw AS $i){
						$ititular=$i['titular'];
						if(!$ititular || !$titular){
							if($ititular){
								$titular=true;
								$i['materiaoid'] = $tit;
								$i['materiaid']=-1;
							}else{
								$i['materiaoid'] = [$i['materiaid']];
							}
							$calificaciones[]=$i;
						}
					}
					
					if($calificaciones!==false && $alumno!==false){
						$data[] = array(
								"alumno"=>$alumno,
								"talleres"=>$talleres,
								"calificacion"=>$calificaciones,
								"promedio"=>$promedio,
								"date"=>$validDate
						);
					}
				}
			}
			if(count($data) > 0){
				return Api::Ok("", $data);
			}else{
				return Api::Error(Response::HTTP_BAD_REQUEST, false);
			}
		}catch(Exception $e){
			return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
		}
		
	}
	/**
	 * @Annotations\Put("/api/Controlescolar/Conductacaptura/{periodoevaluacionid}/{alumnocicloporgrupoid}", name="setCCCalificacionByPeriodoevaluacionAlumnocicloporgrupo")
	 */
	public function setCCCalificacionByPeriodoevaluacionAlumnocicloporgrupo($periodoevaluacionid,$alumnocicloporgrupoid){
		$requestRaw=trim(file_get_contents("php://input"));
		$data=json_decode($requestRaw,true);
		$dbm=$this->getDM();
		$materias=$data['materia'];
		$titular=($data['titular']?true:false);
		$calificaciones=$dbm->getCCCalificacionconductaByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid);
		if($calificaciones!==false && $materias && ($titular || sizeof($materias)==1)){
			$header=false;
			$materiasToAdd=[];
			$calificacion=(double)$data['cal'];
			if($calificaciones){//has at least one
				$headerid=false;
				$materiaAdded=[];
				foreach($calificaciones AS $i){
					$imateriaid=$i['materiaid'];
					if(array_search($imateriaid,$materias)!==false){//materia requested
						$nid=$i['conductacalificacionid'];
						if($headerid && $headerid!=$nid){//tryin' to update multiple scores from different headers
							return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Petición incorrecta.");
						}
						$headerid=$nid;
						$materiaAdded[$imateriaid]=true;
					}
				}
				if($headerid){
					$header=$dbm->getRepositorioById("CeConductacalificacion", "conductacalificacionid", $headerid);
					foreach($materias AS $i){
						if(!isset($materiaAdded[$i])){
							$materiasToAdd[]=$i;
						}
					}
				}
			}
			if(!$header){//create record
				$materiasToAdd=$materias;
				$header=new CeConductacalificacion();
				$header->setPeriodoevaluacionid($dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $periodoevaluacionid));
				$header->setAlumnocicloporgrupoid($dbm->getRepositorioById("CeAlumnocicloporgrupo", "alumnocicloporgrupo", $alumnocicloporgrupoid));
				$header->setTitular($titular);
			}
			$header->setCalificacion($calificacion);
			$toAdd=array_unique($materiasToAdd);
			try{
				$dbm->getConnection()->beginTransaction();
				$dbm->saveRepositorio($header);
				foreach($toAdd AS $i){
					$xi=new CeMateriaporconductacalificacion();
					$xi->setConductacalificacionid($header);
					$xi->setMateriaid($dbm->getRepositorioById("Materia", "materiaid", $i));
					$dbm->saveRepositorio($xi);
				}
				$dbm->getConnection()->commit();
				$promedio=$dbm->getCCPromedioByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid);
				return Api::Ok("", $promedio);
			}catch(\Exception $e){
				$dbm->getConnection()->rollBack();
			}
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}

	private function getMateriaDataByGrupo($grupoid,$usuarioid=-1){
		$dbm=$this->getDM();
		$data=[];
		$profesorid=false;
		$materiask=[];
		$materiaspek=[];
		$materiasdid=[];
		$materiasdpeid=[];
		$materiasd=$dbm->getBIMateriasDataRawByAOG($grupoid,["isgrupo"=>true]);
		if($usuarioid!=-1){
			$pusuario=$dbm->getRepositorioById("Usuario", "usuarioid", $usuarioid);
			$profesorid=(int)($pusuario && $pusuario->getProfesorid() ? $pusuario->getProfesorid()->getProfesorid() : 0);
		}
		//var_dump($materiasd);
		foreach($materiasd AS $i){
			$materiasdid[]=$i['materiaid'];
			$materiasdpeid[]=$i['materiaporplanestudioid'];
		}
		//var_dump($materiasdid,$materiasdpeid);exit;
		$umateriasdid=array_unique($materiasdid);
		$umateriasdpeid=array_unique($materiasdpeid);
		foreach($dbm->getCCMateriasById($umateriasdid) AS $i){
			$materiask[$i['materiaid']]=$i;
		}
		foreach($dbm->getCCMateriasplanestudioById($umateriasdpeid) AS $i){
			$materiaspek[$i['materiaporplanestudioid']]=$i;
		}
		foreach($materiasd AS $i){
			$imateriaplanestudioid=$i['materiaporplanestudioid'];
			$imateriaid=$i['materiaid'];
			$issub=false;
			$profesor=$i['profesor'];
			$iprofesorid=$i['profesorid'];
			$itallercurricularid=$i['tallercurricularid'];
			//list($imateriaplanestudioid,$imateriaid,$issub,$profesor,$iprofesorid)=$i;
			if($profesorid!==false && $iprofesorid!=$profesorid){
				continue;
			}
			$di=[
				//'materiaid'=>$imateriaid,
				//'materiaporplanestudioid'=>$imateriaplanestudioid,
				'materia'=>$materiask[$imateriaid],
				'materiaporplanestudio'=>$materiaspek[$imateriaplanestudioid],
				'profesor'=>$profesor,
				'submateria'=>$issub,
				'profesorid'=>$iprofesorid,
				'tallercurricularid'=>$itallercurricularid
			];
			$data[]=$di;
		}
		return $data;
	}
	
	private function getDM(){
		if($this->DBM){
			return $this->DBM;
		}
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}