<?php
namespace AppBundle\Controller\Controlescolar;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeRecuperacionperiodo;
use AppBundle\Controller\Controlescolar\CapturaCalificacionesController;

/**
 * Autor: Emmanuel Martinez
 */
class RecuperacionPeriodoController extends FOSRestController{
	private $DBM=false;
	/**
	 * @Annotations\Get("/api/Controlescolar/Recuperacionperiodo", name="getRPAlumnosReprobados")
	 */
	public function getRPAlumnosReprobados(){
		$req=$_REQUEST;
		$kciclo=$req['cicloid'];
		//$knivel=$req['nivelid'];
		$kgrado=$req['gradoid'];
		$kpevaluacion=(int)$req['pevaluacionid'];
		$mreprobada=(int)$req['mreprobada'];
		if(!$mreprobada){
			$mreprobada=null;
		}
		if($kciclo && $kgrado && $kpevaluacion){
			$dbm=$this->getDM();
			$pevaluacion=$dbm->getRepositoriosModelo("CePeriodoevaluacion",["IDENTITY(d.conjuntoperiodoevaluacionid) AS conjuntoperiodoevaluacionid","d.descripcion AS nombre"],["periodoevaluacionid"=>$kpevaluacion])[0];
			$kconjuntope=$pevaluacion["conjuntoperiodoevaluacionid"];
			$pevaluaciones=$dbm->getRepositoriosModelo("CePeriodoevaluacion",["d.periodoevaluacionid AS id","d.descripcion AS nombre"],["conjuntoperiodoevaluacionid"=>$kconjuntope],["periodoevaluacionid"=>"DESC"]);
			$lastpevaluacion=$pevaluaciones[0];
			$isLastPEvaluacion=($kpevaluacion==$lastpevaluacion['id']);
			if($pevaluacion){
				$kgrupos=[];
				$pevaluacionname=$pevaluacion["nombre"];
				$gruposraw=$dbm->getRepositoriosModelo("CeGrupo", ["d.grupoid"], ["cicloid"=>$kciclo,"gradoid"=>$kgrado,"tipogrupoid"=>1]);
				foreach($gruposraw AS $igruporaw){
					$kgrupos[]=$igruporaw["grupoid"];
				}
				$kmateriasperaw=[];
				$subgrupos=$dbm->getBISubgruposByGrupo($kgrupos);
				foreach($subgrupos AS $isubgrupo){
					$kgrupos[]=$isubgrupo['grupoid'];
				}
				$materiaspe=$dbm->getBIMateriasDataRawByAOG($kgrupos,["isgrupo"=>true]);
				foreach($materiaspe AS $imateriape){
					$kmateriasperaw[]=$imateriape["materiaporplanestudioid"];
				}
				$kmateriaspe=array_unique($kmateriasperaw);
				$reprobados=[];
				$reprobadosr=[];
				$reprobadosraw=$dbm->getReprobadosporPeriodoMateria($kpevaluacion,$kmateriaspe,["cicloid"=>$kciclo,"letfinal"=>false,"letfaltas"=>false]);
				foreach($reprobadosraw AS $ireprobado){
					$kreprobado=$ireprobado['alumnoporcicloid'];
					if(!isset($reprobadosr[$kreprobado])){
						$reprobadosr[$kreprobado]=[
								"ciclo"=>$ireprobado["ciclo"],
								"nivel"=>$ireprobado["nivel"],
								"grado"=>$ireprobado["grado"],
								"grupo"=>$ireprobado["grupo"],
								"matricula"=>$ireprobado["matricula"],
								"alumnoporcicloid"=>$kreprobado,
								"nombrecompleto"=>$ireprobado["nombrecompleto"],
								"kperiodo"=>$kpevaluacion,
								"periodo"=>$pevaluacionname,
								"reprobadas"=>[]
						];
					}
					if($ireprobado["tipogrupoid"]==1){
						$reprobadosr[$kreprobado]["grupo"]=$ireprobado["grupo"];
					}
					$ireprobador=&$reprobadosr[$kreprobado];
					$ireprobador["reprobadas"][]=[
						"profesorpormateriaplanestudiosid"=>$ireprobado['profesorpormateriaplanestudiosid'],
						"materia"=>$ireprobado['materia']
					];
					unset($ireprobador);
				}
				foreach($reprobadosr AS $kreprobado=>$ireprobado){
					$ireprobadasname=[];
					foreach($ireprobado['reprobadas'] AS $ireprobada){
						$ireprobadasname[]=$ireprobada['materia'];
					}
					$nreprobadas=sizeof($ireprobado['reprobadas']);
					$ireprobado["nreprobadas"]=$nreprobadas;
					$ireprobado["reprobadasname"]=implode(", ",$ireprobadasname);
					if(!$mreprobada || $nreprobadas==$mreprobada){
						$reprobados[]=$ireprobado;
					}
					unset($ireprobado);
				}
				return Api::Ok("", $reprobados);
			}
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/Recuperacionperiodo/filter", name="getRPFilter")
	 */
	public function getRPFilter(){
		$dbm=$this->getDM();
		$ciclo=$dbm->getBasicCiclo();
		$nivel=$dbm->getBasicNivel();
		$semestre=$dbm->getBasicSemestre();
		$grado=$dbm->getBasicGrado();
		$pevaluacion=$dbm->getBasicPeriodoEvaluacion();
		if($ciclo!==false && $nivel!==false && $semestre!==false && $grado!==false && $pevaluacion!==false){
			return Api::Ok("", array(
					"ciclo"=>$ciclo,
					"nivel"=>$nivel,
					"grado"=>$grado,
					"semestre"=>$semestre,
					"pevaluacion"=>$pevaluacion
				));
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	
	/**
	 * @Annotations\Get("/api/Controlescolar/Recuperacionperiodo/materiasreprobadas/{kalumnociclo}", name="getRPMateriasReprobadasByAlumno")
	 */
	public function getRPMateriasReprobadasByAlumno($kalumnociclo){
		return Api::Ok("",$kalumnociclo);
		/*
		if($kalumnociclo){
			$dbm=$this->getDM();
			return Api::Ok("", $dbm->getBIMateriasDataRawByAOG($kalumnociclo,["showname"=>true]));
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
		 */
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/Recuperacionperiodo/recuperaciones/{kalumnociclo}/{kppmateriape}/{kperiodoevaluacion}", name="getRPRecuperacionesByAlumnoMateriape")
	 */
	public function getRPRecuperacionesByAlumnoMateriape($kalumnociclo,$kppmateriape,$kperiodoevaluacion){
		if(!empty($kalumnociclo) && !empty($kppmateriape) && !empty($kperiodoevaluacion)){
			$dbm=$this->getDM();
			$data=$dbm->getRepositoriosModelo("CeRecuperacionperiodo", ["d.recuperacionperiodoid",
					"IDENTITY(d.profesorpormateriaplanestudioid) AS profesorpormateriaplanestudioid",
					"d.intento",
					"d.calificacion"
				], [
					"alumnoporcicloid"=>$kalumnociclo,
					"profesorpormateriaplanestudioid"=>$kppmateriape,
					"periodoevaluacionid"=>$kperiodoevaluacion
				]);
			return Api::Ok("", $data);
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	/**
	 * @Annotations\Put("/api/Controlescolar/Recuperacionperiodo/recuperaciones/{kalumnociclo}/{kppmateriape}/{kperiodoevaluacion}", name="putRPRecuperacionesByAlumnoMateriapePeriodo")
	 */
	public function putRPRecuperacionesByAlumnoMateriapePeriodo($kalumnociclo,$kppmateriape,$kperiodoevaluacion){
		if(!empty($kalumnociclo) && !empty($kppmateriape) && !empty($kperiodoevaluacion)){
			$dbm=$this->getDM();
			try{
				$requestRaw=json_decode(trim(file_get_contents("php://input")),true);
				$krecuperacionperiodo=$requestRaw['recuperacionperiodoid'];
				$calificacion=(double)$requestRaw['calificacion'];
				if($calificacion>10){$calificacion=10;}
				else if($calificacion<0){$calificacion=0;}
				if($krecuperacionperiodo){ $entity=$dbm->getRepositorioById("CeRecuperacionperiodo", "recuperacionperiodoid", $krecuperacionperiodo); }
				else{
					$entity=new CeRecuperacionperiodo();
					$entity->setAlumnoporcicloid($dbm->getRepositorioById("CeAlumnoporciclo", "alumnoporcicloid", $kalumnociclo));
					$entity->setProfesorpormateriaplanestudioid($dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $kppmateriape));
					$entity->setPeriodoevaluacionid($dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $kperiodoevaluacion));
					$intentos=$dbm->getRepositoriosModelo("CeRecuperacionperiodo", ["d.intento"], [
						"alumnoporcicloid"=>$kalumnociclo,
						"profesorpormateriaplanestudioid"=>$kppmateriape,
						"periodoevaluacionid"=>$kperiodoevaluacion
					], ["intento"=>"DESC"]);
					$intentoMax=0;
					if(!empty($intentos)){
						$intentoMax=(int)$intentos[0]["intento"];
					}
					$entity->setIntento($intentoMax+1);
				}
				$entity->setCalificacion($calificacion);

				$dbm->getConnection()->beginTransaction();
				$dbm->saveRepositorio($entity);
				$dbm->getConnection()->commit();
				CapturaCalificacionesController::processCalificacionFinalAlumno($dbm,$dbm->getOneByParametersRepositorio("CeCalificacionperiodoporalumno",[
						"profesorpormateriaplanestudioid"=>$kppmateriape,
						"alumnoporcicloid"=>$kalumnociclo,
						"periodoevaluacionid"=>$kperiodoevaluacion,
						"materiapadrecalificacionperiodoporalumnoid"=>null
					]));
				return Api::Ok("", [
						"recuperacionperiodoid"=>$entity->getRecuperacionperiodoid(),
						"intento"=>$entity->getIntento(),
						"calificacion"=>$entity->getCalificacion(),
				]);
			}catch(Exception $e){
					$dbm->getConnection()->rollBack();
			}
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	/**
	 * @Annotations\Delete("/api/Controlescolar/Recuperacionperiodo/{krecuperacionperiodo}", name="deleteRPRecuperacionesById")
	 */
	public function deleteRPRecuperacionesById($krecuperacionperiodo){
		$dbm=$this->getDM();
		$recuperacion=$dbm->getRepositorioById("CeRecuperacionperiodo", "recuperacionperiodoid", $krecuperacionperiodo);
		if($recuperacion){
			try{
				$dbm->getConnection()->beginTransaction();
				$dbm->removeRepositorio($recuperacion);
				$dbm->getConnection()->commit();
				return Api::Ok("", true);
			}catch(Exception $e){
				$dbm->getConnection()->rollBack();
			}
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}

	private function getDM(){
		if($this->DBM){
			return $this->DBM;
		}
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}