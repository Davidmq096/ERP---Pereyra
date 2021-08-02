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
class AlumnoIdiomaNivelImportarController extends FOSRestController{
	private $DBM=false;
	/**
	 * @Annotations\Get("/api/Controlescolar/Alumnoidiomanivelimportar/filter", name="getAINIFilter")
	 */
	public function getAINIFilter(){
		try{
			$ciclo=$this->getDM()->getBasicCiclo();
			return Api::Ok("", [
				"ciclo"=>$ciclo
			]);
		}catch(\Exception $e){
			return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
		}
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/Alumnoidiomanivelimportar/", name="getAINIFile")
	 */
	public function getAINIFile(){
		$path="../src/AppBundle/Dominio/Layout/Alumnoidiomanivelimportar.layout.xlsx";
		return new Response(
			file_get_contents($path), 200, [
				'Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
				'Pragma'=>'public',
				'Cache-Control'=>'maxage=1',
				'Content-Length'=>filesize($path)
		]);
	}
	/**
	 * @Annotations\Post("/api/Controlescolar/Alumnoidiomanivelimportar/{cicloid}", name="setAINIFileByExcel")
	 */
	public function setAINIFileByExcel($cicloid){
		$cicloid=(int) $cicloid;
		if($cicloid < 1){
			return Api::Error(Response::HTTP_BAD_REQUEST, "Ciclo incorrecto.");
		}
		if($_FILES['file']['error']== 1){
			return Api::Error(Response::HTTP_BAD_REQUEST, "Excede el peso permitido para el layout.");
		}
		try{
			$excel=$this->get('phpexcel')->createPHPExcelObject($_FILES['file']['tmp_name']);
			$sheet=$excel->getActiveSheet();
			$rowMax=$sheet->getHighestDataRow();
			if($rowMax > 1){
				$override=false;
				$complete=true;
				$languagekey=array();
				$studentmat=array();
				$studentmatk=array();
				$dataRaw=$sheet->rangeToArray("A2:B$rowMax", null, true, true, true);
				foreach($dataRaw AS $i){
					$mat=$i["A"];
					$lang=$i["B"];
					if(empty($mat) || empty($lang)){
						$complete=false;
						break;
					}
					if(isset($studentmatk[$mat])){
						$override=true;
						break;
					}
					$studentmat[]=$mat;
					$studentmatk[$mat]=$lang;
					$languagekey[]=$lang;
				}
				if(!$complete){
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Renglones incompletos en el layout.");
				}
				if($override){
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Matricula duplicada.");
				}

				//Check language level keys
				$dbm=$this->getDM();
				$languagekeyu=array_unique($languagekey);
				$languagesRaw=$dbm->getAINIIdiomanivelByClave($languagekeyu);
				if(sizeof($languagesRaw)!= sizeof($languagekeyu)){
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Una o más claves de nivel de idioma no existen.");
				}

				//Check student keys
				$studentsRaw=$dbm->BuscarAlumnosA([
					"cicloid"=>$cicloid,
					"matricula"=>$studentmat,
					"precision"=>true
				]);
				if(sizeof($studentsRaw)!= sizeof($studentmat)){
					$isok=$studentmatk;
					foreach($studentsRaw AS $i){
						$imatricula=$i['matricula'];
						$isok[$imatricula]=true;
					}
					$matriculas="";
					foreach($isok AS $k=>$i){ if($i!==true){$matriculas.=", $k";} }
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Una o más matriculas no existen. [".substr($matriculas, 2)."]");
				}
				$languageid=array();
				$studentcicloid=array();
				$studentciclorel=array();
				foreach($languagesRaw AS $i){
					$languageid[]=$i['idiomanivelid'];
				}
				foreach($studentsRaw AS $i){
					$id=$i['alumnoporcicloid'];
					$mat=$i['matricula'];
					$lank=$studentmatk[$mat];
					$studentcicloid[]=$id;
					$studentciclorel[$id]=array($lank, null);
				}

				$languagek=array();
				$studentciclok=array();
				$language=$dbm->getRepositoriosById("CeIdiomanivel", "idiomanivelid", $languageid);
				$studentciclo=$dbm->getRepositoriosById("CeAlumnoporciclo", "alumnoporcicloid", $studentcicloid);
				$studentciclolevel=$dbm->getRepositoriosById("CeAlumnocicloporidiomanivel", "alumnoporcicloid", $studentcicloid);
				foreach($language AS $i){
					$languagek[$i->getClave()]=$i;
				}
				foreach($studentciclo AS $i){
					$studentciclok[$i->getAlumnoporcicloid()]=$i;
				}
				foreach($studentciclolevel AS $i){
					$studentciclorel[$i->getAlumnoporcicloid()->getAlumnoporcicloid()][1]=$i;
				}
				foreach($studentciclorel AS $id=> $i){
					list($langk, $level)=$i;
					$lang=$languagek[$langk];
					if(!$level){
						$level=new CeAlumnocicloporidiomanivel();
						$level->setAlumnoporcicloid($studentciclok[$id]);
					}
					$level->setIdiomanivelid($lang);
					$studentciclorel[$id][1]=$level;
				}
				$dbm->getConnection()->beginTransaction();
				foreach($studentciclorel AS $i){
					$dbm->saveRepositorio($i[1]);
				}
				$dbm->getConnection()->commit();
				$result=$dbm->getAINIImportadosByAlumnociclo($studentcicloid);
				return Api::Ok(true, $result);
			}else{
				return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Necesita importar al menos 1 alumno.");
			}
		}catch(\Exception $e){
			return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
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