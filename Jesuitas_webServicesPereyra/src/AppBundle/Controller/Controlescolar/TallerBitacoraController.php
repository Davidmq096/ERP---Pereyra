<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;

/**
 * Autor: Emmanuel Martinez
 */
class TallerBitacoraController extends FOSRestController{
	private $DBM=false;

	/**
	 * @Annotations\Get("/api/Controlescolar/Tallerbitacora/filter", name="getTallerBitacoraFilter")
	 */
	public function getTallerBitacoraFilter(){
		$dbm=$this->getDM();
		$ciclo=$dbm->getBasicCiclo();
		$nivel=$dbm->getBasicNivel();
		$semestre=$dbm->getBasicSemestre();
		$grado=$dbm->getBasicGrado();
		$tallerc=$dbm->getBasicTallerCurricularBitacora();
		$tallere=$dbm->getBasicTallerExtracurricularBitacora();
		$tallertipo=$this->getDTallerTipo();
		$talleraccion=$this->getDTallerAccion();
		foreach($tallere AS $i){ $tallerc[]=$i; }
		$data=array("ciclo"=>$ciclo,
			"nivel"=>$nivel,
			"grado"=>$grado,
			"semestre"=>$semestre,
			"tallertipo"=>$tallertipo,
			"talleraccion"=>$talleraccion,
			"taller"=>$tallerc
		);
		return Api::Ok("",$data);
	}

	/**
		* @Annotations\Get("/api/Controlescolar/Tallerbitacora/", name="getTallerBitacora")
		*/
	public function getTallerBitacora(){
		$cicloid=(int)$_REQUEST['cicloid'];
		$nivelid=(int)$_REQUEST['nivelid'];
		if($cicloid<1 || $nivelid<1){ return Api::Error(Response::HTTP_BAD_REQUEST, false); }
		$data=$this->getDM()->getTBTallerBitacoraByCicloNivel($cicloid,$nivelid,$_REQUEST);
		if($data===false){ return Api::Error(Response::HTTP_PARTIAL_CONTENT, false); }
		return Api::Ok("",$data);
	}

	private function getDTallerTipo(){
		return $this->getDM()->getRepositoriosModelo("CeTipotaller", ["d.tipotallerid","d.nombre"], ["activo"=>1]);
	}
	private function getDTallerAccion(){
		return $this->getDM()->getRepositoriosModelo("CeTalleraccion", ["d.talleraccionid","d.nombre"], ["activo"=>1]);
	}

	private function getDM(){
		if($this->DBM){
			return $this->DBM;
		}
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}