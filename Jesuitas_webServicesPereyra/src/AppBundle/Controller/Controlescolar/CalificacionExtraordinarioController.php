<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Entity\CePeriodoregularizacion;
use AppBundle\Entity\CeAcuerdoextraordinario;

/**
 * Autor: Emmanuel Martinez
 */
class CalificacionExtraordinarioController extends FOSRestController{
	private static $MAX_SCORE=10;
	private static $MAX_ATTEMPT=3;
	private static $STATUSID_PE=1;
	private static $STATUSID_AP=4;
	private static $STATUSID_RP=5;
	private static $INVALID_RQ="Peticion invalida.";
	private static $NOT_FOUND="Acuerdo(s) extraordinario no encontrado(s).";
	private static $EDIT_SUCCESS="Calificacion modificada correctamente.";
	private static $EDIT_IDATES="No se puede editar debido a que el periodo de captura termino.";
	private static $EDIT_IPAY="No se puede editar debido a que no se ha pagado el acuerdo.";
	private static $EDIT_IEDITABLE="No se puede editar debido a que no ha sido agendado.";
	private static $EDIT_ISCORE="Calificacion invalida.";
	/**
	 * @Annotations\Get("/api/Controlescolar/CalificacionExtraordinario/filter", name="getFilterCalificacionExtraordinario")
	 */
	public function getFilterCalificacionExtraordinario(){
		try{
			$dbm=$this->getDM();
			$ciclo=$dbm->getBasicCiclo();
			$nivel=$dbm->getBasicNivel();
			$semestre=$dbm->getBasicSemestre();
			$grado=$dbm->getBasicGrado();
			$pregularizacion=$dbm->getBasicPeriodoRegularizacion();
			$pestudios=$dbm->getBasicPlanEstudio();
			$materia=$dbm->getBasicMateria();
			$materiar=$dbm->getBasicMateriaPlanEstudioRel();
			$agenda=$dbm->getBasicAgendaExtraordinario();
			return Api::Ok("", array(
				"ciclo"=>$ciclo,
				"nivel"=>$nivel,
				"grado"=>$grado,
				"semestre"=>$semestre,
				"pregularizacion"=>$pregularizacion,
				"pestudios"=>$pestudios,
				"materia"=>$materia,
				"materiar"=>$materiar,
				"agenda"=>$agenda,
			));
		}catch(\Exception $e){
			return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
		}
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/CalificacionExtraordinario", name="getCalificacionExtraordinario")
	 */
	public function getCalificacionExtraordinario(){
		$requestRaw=$_REQUEST;
		if(!empty($requestRaw['agendaextraordinarioid'])){
			$idAgExtraordinario=(int) $requestRaw['agendaextraordinarioid'];
			try{
				$dbm=$this->getDM();
				$r=$dbm->getCEAcuerdoextraordinarioByAgendaextraordinario($idAgExtraordinario);
				if(sizeof($r) < 1 || !$r){
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, self::$NOT_FOUND);
				}
				$fr=$r[0];
				$idMateria=(int) $fr['materiaid'];
				$idProfesor=(int) $fr['profesorid'];
				$idPlanEstudio=(int) $fr['planestudioid'];
				$idPeriodo=(int) $fr['periodoregularizacionid'];
				list($status1, $materia)=$this->getMateriaById($idMateria);
				list($status2, $profesor)=$this->getProfesorById($idProfesor);
				list($status3, $planestudio)=$this->getPlanEstudioById($idPlanEstudio);
				list($status4, $periodo)=$this->getPeriodoRegularizacionById($idPeriodo);

				if($status1 && $status2 && $status3 && $status4){
					$acuerdos=array();
					foreach($r AS $i){
						$pagado = $i['pagoestatusid'];
						$acuerdos[]=array(
								"acuerdoextraordinarioid"=>$i['acuerdoextraordinarioid'],
								"pagado"=>$i['pagoestatusid'] && $i['pagoestatusid'] == 2 ? 1 : 0,
								"calificacion"=>$i['calificacion'],
								"calificacionfinal"=>$i['calificacionfinal'],
								"alumno"=>array(
									"matricula"=>$i['matricula'],
									"nombre"=>$this->buildFullName($i)
								)
						);
					}
					return Api::Ok("", array(
						"agendaextraordinarioid"=>$fr['agendaextraordinarioid'],
						"profesor"=>array(
							"id"=>$profesor->getProfesorid(),
							"nombre"=>$this->buildFullName($profesor, true),
						), //$profesor,
						"materia"=>array(
							"id"=>$materia->getMateriaid(),
							"nombre"=>$materia->getNombre(),
							"calificacionminima"=>$planestudio->getCalificacionminima(),
							"calificacionmaxima"=>10,
							"calificacionaprobatoria"=>$planestudio->getPuntopase()
						), //$materia,
						"periodoregularizacion"=>array(
							"id"=>$periodo->getPeriodoregularizacionid(),
							"nombre"=>$periodo->getNombre(),
							"editable"=>$this->isValidDate($periodo)
						), //$periodo,
						"acuerdos"=>$acuerdos
					));
				}
			}catch(\Exception $e){
				return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
			}
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, self::$INVALID_RQ);
	}
	/**
	 * @Annotations\Put("/api/Controlescolar/CalificacionExtraordinario/{id}", name="updateCalificacionExtraordinario")
	 */
	public function updateCalificacionExtraordinario($id){
		$instituto = ENTORNO;
		$acuerdoextraordinarioid=(int) $id;
		$requestRaw=trim(file_get_contents("php://input"));
		$request=json_decode($requestRaw, true);
		list($status, $acuerdo)=$this->getAcuerdoExtraordinarioById($acuerdoextraordinarioid);
		if($status){
			if($acuerdo){
				$isFinalScore=($request['isfinal']);
				$property='calificacion'.($isFinalScore ? 'final' : '');
				$score= is_string($request['value']) ?  $request['value'] : (double) $request['value'];
				$data=array($property=>$score);
				try{
					$dbm=$this->getDM();
					(new ArrayHydrator($dbm->getEntityManager()))->hydrate($acuerdo, $data);
					$pestudio=$this->getPlanEstudioByAcuerdo($acuerdo);
					if($score !== "NP") {
						if(self::$MAX_SCORE < $score || $score < $pestudio->getCalificacionminima()){
							return Api::Error(Response::HTTP_PARTIAL_CONTENT, self::$EDIT_ISCORE);
						}
					}

					if(!$this->isEditable($acuerdo)){
						return Api::Error(Response::HTTP_PARTIAL_CONTENT, self::$EDIT_IEDITABLE);
					}
					if(!$this->isPaid($acuerdo)){
						return Api::Error(Response::HTTP_PARTIAL_CONTENT, self::$EDIT_IPAY);
					}
					if(!$this->isValidDate($acuerdo->getPeriodoregularizacionid())){
						return Api::Error(Response::HTTP_PARTIAL_CONTENT, self::$EDIT_IDATES);
					}
					if($isFinalScore){
						$aprobado= $score == "NP" ? false : ($pestudio->getPuntopase()<= $score);
						$extraordinario=$acuerdo->getExtraordinarioid();
						$newStatus=$this->getEstatusExtraordinarioById(($aprobado ? self::$STATUSID_AP : self::$STATUSID_RP));
						$acuerdo->setEstatusextraordinarioid($newStatus);
						$extraordinario->setEstatusextraordinarioid(($aprobado || ($instituto == 1 &&  $acuerdo->getIntento()>= self::$MAX_ATTEMPT)) ? $newStatus : $this->getEstatusExtraordinarioById(self::$STATUSID_PE));
					}
					$dbm->getConnection()->beginTransaction();
					$dbm->saveRepositorio($acuerdo);
					if($isFinalScore){
						$dbm->saveRepositorio($extraordinario);
					}
					$dbm->getConnection()->commit();
					return Api::Ok(true, self::$EDIT_SUCCESS);
				}catch(\Exception $e){
					return Api::Error(Response::HTTP_BAD_REQUEST, self::$e->getMessage());
				}
			}
			return Api::Error(Response::HTTP_PARTIAL_CONTENT, self::$NOT_FOUND);
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, self::$INVALID_RQ);
	}
	private function getMateriaById(int $id){
		try{
			$data=$this->getDM()->getRepositorioById('Materia', 'materiaid', $id);
			return array(true, $data);
		}catch(\Exception $e){
			return array(false, $e->getMessage());
		}
	}
	private function getProfesorById(int $id){
		try{
			$data=$this->getDM()->getRepositorioById('CeProfesor', 'profesorid', $id);
			return array(true, $data);
		}catch(\Exception $e){
			return array(false, $e->getMessage());
		}
	}
	private function getPeriodoRegularizacionById(int $id){
		try{
			$data=$this->getDM()->getRepositorioById("CePeriodoregularizacion", "periodoregularizacionid", $id);
			return array(true, $data);
		}catch(\Exception $e){
			return array(false, $e->getMessage());
		}
	}
	private function getPlanEstudioById(int $id){
		try{
			$data=$this->getDM()->getRepositorioById("CePlanestudios", "planestudioid", $id);
			return array(true, $data);
		}catch(\Exception $e){
			return array(false, $e->getMessage());
		}
	}
	private function getPlanEstudioByAcuerdo(CeAcuerdoextraordinario $acuerdo){
		$pPEstudio=$acuerdo->getAgendaextraordinarioid()->getMateriaporplanestudioid()->getPlanestudioid();
		$pPEstudio->__load();
		return $pPEstudio;
	}
	private function getEstatusExtraordinarioById(int $id){
		try{
			$data=$this->getDM()->getRepositorioById("CeEstatusextraordinario", "estatusextraordinarioid", $id);
			return $data;
		}catch(\Exception $e){
			return false;
		}
	}
	private function getAcuerdoExtraordinarioById(int $id){
		try{
			$data=$this->getDM()->getRepositorioById("CeAcuerdoextraordinario", "acuerdoextraordinarioid", $id);
			return array(true, $data);
		}catch(\Exception $e){
			return array(false, $e->getMessage());
		}
	}
	private function buildFullName($x, $profesor=false){
		$r=array();
		if($profesor){
			$r[]=trim($x->getNombre());
			$r[]=trim($x->getApellidopaterno());
			$r[]=trim($x->getApellidomaterno());
		}else{
			if(!empty($x['primernombre'])){
				$r[]=trim($x['primernombre']);
			}
			if(!empty($x['segundonombre'])){
				$r[]=trim($x['segundonombre']);
			}
			if(!empty($x['apellidopaterno'])){
				$r[]=trim($x['apellidopaterno']);
			}
			if(!empty($x['apellidomaterno'])){
				$r[]=trim($x['apellidomaterno']);
			}
		}
		return implode(" ", $r);
	}
	private function isEditable(CeAcuerdoextraordinario $acuerdo){
		$sStatus=array(3, 4, 5);
		$status=$acuerdo->getEstatusextraordinarioid()->getEstatusextraordinarioid();
		foreach($sStatus AS $i){
			if($status== $i){
				return true;
			}
		}
		return false;
	}
	private function isPaid(CeAcuerdoextraordinario $acuerdo){
		$dp=$acuerdo->getDocumentoporpagarid();
		if($dp->getPagoestatusid()->getPagoestatusid() == 2) {
			$pagado = 1;
		}
		return ($pagado== 1);
	}
	private function isValidDate(CePeriodoregularizacion $periodo){
		if($periodo){//Has periodo regularizacion
			if($periodo->__load){
				$periodo->__load();
			}
			$Fn=new \DateTime();
			$Fi=$periodo->getFechainicio();
			$Ff=$periodo->getFechafin();
			$Ff->setTime(23, 59, 59);
			//var_dump($Fi,$Ff,$Fn);
			return ($Fi<= $Fn && $Fn<= $Ff);
		}
		return false;
	}
	private function getDM(){
		if($this->DBM){
			return $this->DBM;
		}
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}