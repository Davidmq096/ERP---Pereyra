<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;

/**
 * @author Emmanuel Martinez
 */
class AvanceCalificacionesController extends FOSRestController{
	private $DBM=false;
	/**
	 * @Annotations\Get("/api/Controlescolar/AvanceCalificaciones/filter", name="getAvancecalificacionesFilter")
	 */
	public function getAvancecalificacionesFilter(){
		$dbm=$this->getDM();
		$ciclo=$dbm->getBasicCiclo();
		$nivel=$dbm->getBasicNivel();
		$semestre=$dbm->getBasicSemestre();
		$grado=$dbm->getBasicGrado();
		$grupo=$dbm->getBasicGrupoCurricular();
		if($ciclo!== false && $nivel!== false && $grado!== false && $semestre!== false && $grupo!== false){
			$profesor=$dbm->getBasicProfesor();
			$pestudios=$dbm->getBasicPlanEstudio();
			$materia=$dbm->getBasicMateria();
			$materiar=$dbm->getBasicMateriaPlanEstudioRel();
			$pevaluacion=$dbm->getBasicPeriodoEvaluacion();
			return Api::Ok("", array(
				"ciclo"=>$ciclo,
				"nivel"=>$nivel,
				"semestre"=>$semestre,
				"grado"=>$grado,
				"grupo"=>$grupo,
				"pestudios"=>$pestudios,
				"materia"=>$materia,
				"materiar"=>$materiar,
				"pevaluacion"=>$pevaluacion,
				"profesor"=>$profesor
			));
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}

	/**
	 * @Annotations\Get("/api/Controlescolar/AvanceCalificaciones", name="getAvanceCalificacionesConsulta")
	 */
	public function getAvanceCalificacionesConsulta(){
		$dbm=$this->getDM();
		if(!empty($_REQUEST["cicloid"]) && !empty($_REQUEST["nivelid"])){
			$data=$dbm->getACCalificaciones($_REQUEST);
			if($data!==false){
				return Api::Ok("", $data);
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