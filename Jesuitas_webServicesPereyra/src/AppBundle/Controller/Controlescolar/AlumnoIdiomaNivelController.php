<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAlumnocicloporidiomanivel;

/**
 * Autor: Emmanuel Martinez
 */
class AlumnoIdiomaNivelController extends FOSRestController{
	private $DBM=false;
	/**
	 * @Annotations\Get("/api/Controlescolar/Alumnoidiomanivel/filter", name="getAINFilter")
	 */
	public function getAINFilter(){
		$dbm=$this->getDM();
		$ciclo=$dbm->getBasicCiclo();
		$nivel=$dbm->getBasicNivel();
		$semestre=$dbm->getBasicSemestre();
		$grado=$dbm->getBasicGrado();
		$idioma=$dbm->getBasicIdioma();
		$idiomanivel=$dbm->getBasicIdiomaNivel();
		$status=$this->getDStatus();
		$data=array(
				"ciclo"=>$ciclo,
				"nivel"=>$nivel,
				"grado"=>$grado,
				"semestre"=>$semestre,
				"idioma"=>$idioma,
				"idiomanivel"=>$idiomanivel,
				"estatus"=>$status
		);
		return Api::Ok("", $data);
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/Alumnoidiomanivel", name="getAINAlumnos")
	 */
	public function getAINAlumnos(){
		$filter=$_REQUEST;
		$cicloid=(int) $filter['cicloid'];
		$nivelid=(int) $filter['nivelid'];
		$gradoid=(int) $filter['gradoid'];
		if($cicloid < 1 || $nivelid < 1 || $gradoid < 1){
			return Api::Error(Response::HTTP_BAD_REQUEST, false);
		}
		$data=$this->getDM()->getAINAlumnoByCicloNivelGrado($cicloid,$nivelid,$gradoid,$filter);
		return Api::Ok("", $data);
	}
	/**
	 * @Annotations\Put("/api/Controlescolar/Alumnoidiomanivel/{idiomanivelid}", name="setAINAlumnoIdiomaNivel")
	 */
	public function setAINAlumnoIdiomaNivel($idiomanivelid){
		$requestRaw=trim(file_get_contents("php://input"));
		$alumnoid=json_decode($requestRaw, true);
		$alumnoidsz=sizeof($alumnoid);
		$idiomanivelid=(int) $idiomanivelid;
		if($idiomanivelid < 1 || $alumnoidsz < 1){
			return Api::Error(Response::HTTP_BAD_REQUEST, false);
		}
		foreach($alumnoid AS $k=> $i){
			$alumnoid[$k]=(int) $i;
		}

		$dbm=$this->getDM();
		//Check language level
		$idiomanivel=$dbm->getRepositorioById("CeIdiomanivel", "idiomanivelid", $idiomanivelid);
		if(!$idiomanivel){
			return Api::Error(Response::HTTP_BAD_REQUEST, false);
		}

		//Check students
		$alumnok=array();
		$alumno=$dbm->getRepositoriosById("CeAlumnoporciclo", "alumnoporcicloid", $alumnoid);
		if(sizeof($alumno)!= $alumnoidsz){
			return Api::Error(Response::HTTP_BAD_REQUEST, false);
		}
		foreach($alumno AS $i){
			$alumnok[$i->getAlumnoporcicloid()]=array($i, null);
		}

		//Get actual assignments
		$alumnoidiomanivel=$dbm->getRepositoriosById("CeAlumnocicloporidiomanivel", "alumnoporcicloid", $alumnoid);
		foreach($alumnoidiomanivel AS $i){
			$alumnok[$i->getAlumnoporcicloid()->getAlumnoporcicloid()][1]=$i;
		}
		try{
			$dbm->getConnection()->beginTransaction();
			foreach($alumnok AS $i){
				list($student, $level)=$i;
				if(!$level){
					$level=new CeAlumnocicloporidiomanivel();
					$level->setAlumnoporcicloid($student);
				}
				$level->setIdiomanivelid($idiomanivel);
				$dbm->saveRepositorio($level);
			}
			$dbm->getConnection()->commit();
			return Api::Ok("", true);
		}catch(\Exception $e){}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	private function getDStatus(){
		return array(
				array("id"=>1, "nombre"=>"Asignado"),
				array("id"=>2, "nombre"=>"No asignado")
		);
	}
	private function getDM(){
		if($this->DBM){
			return $this->DBM;
		}
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}