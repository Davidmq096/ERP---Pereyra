<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeBoletas;
use AppBundle\Entity\CeBoletaporciclo;
use AppBundle\Entity\CeBoletaporgrado;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Author: Emmanuel
 * Author: David
 */
class BoletasController extends FOSRestController{
	private $DBM=false;
	/**
	 * Retorna arreglo iniciales
	 * @Rest\Get("/api/Controlescolar/Boletas/filter", name="getBFilter")
	 */
	public function getBFilter(){
		$dbm=$this->getDM();
		$ciclo=$dbm->getBasicCiclo();
		$nivel=$dbm->getBasicNivel();
		$semestre=$dbm->getBasicSemestre();
		$grado=$dbm->getBasicGrado();
		return Api::Ok("", [
			"ciclo"=>$ciclo,
			"nivel"=>$nivel,
			"grado"=>$grado,
			"semestre"=>$semestre
		]);
	}
	/**
	 * Retorna arreglo de estados en base a los parametros enviados
	 * @Rest\Get("/api/Controlescolar/Boletas", name="getBoletas")
	 */
	public function getBoletas(){
		try{
			$datos=$_REQUEST;
			$filtros=array_filter($datos);
			$dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$boletas=$dbm->BuscarBoletas($filtros);
			if (!$boletas) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
			}
			foreach($boletas AS $k=> $i){
				$iciclos=$dbm->getRepositoriosById('CeBoletaporciclo', 'boletaid', $i['boletaid']);
				$igrados=$dbm->getRepositoriosById('CeBoletaporgrado', 'boletaid', $i['boletaid']);
				$icicloids=[];
				$igradoids=[];
				$igradosn=[];
				$iciclosn=[];
				foreach($iciclos AS $j){
					$jc=$j->getCicloid();
					$icicloids[]="".$jc->getCicloid();
					$iciclosn[]=$jc->getNombre();
				}
				foreach($igrados AS $j){
					$jg=$j->getGradoid();
					$igradoids[]="".$jg->getGradoid();
					$igradosn[]=$jg->getNivelid()->getNombre()." ".$jg->getGrado();
				}
				$boletas[$k]['ciclos']=implode(", ", $iciclosn);
				$boletas[$k]['grados']=implode(", ", $igradosn);
				$boletas[$k]['cicloids']=$icicloids;
				$boletas[$k]['gradoids']=$igradoids;
			}
			
			return new View($boletas, Response::HTTP_OK);
		}catch(Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
	/**
	 * Elimina un registro
	 * @Rest\Delete("/api/Controlescolar/Boletas/{id}", name="deleteBoletas")
	 */
	public function deleteBoletas($id){
		try{
			$dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$dbm->getConnection()->beginTransaction();
			$boletasids = explode(",", $id);
			foreach($boletasids as $bolid) {
				$dbm->removeManyRepositorio('CeBoletaporciclo', 'boletaid', $bolid);
				$dbm->removeManyRepositorio('CeBoletaporgrado', 'boletaid', $bolid);
				$boleta=$dbm->getRepositorioById('CeBoletas', 'boletaid', $bolid);
				$dbm->removeRepositorio($boleta);
			}
			$dbm->getConnection()->commit();
			return new View("Se ha eliminado el registro", Response::HTTP_OK);
		}catch(\Exception $e){
			if($e->getPrevious()->getCode()== "23000"){
				return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
			}else{
				return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
			}
		}
	}
	/**
	 * @Rest\Post("/api/Controlescolar/Boletas" , name="SaveBoletas")
	 */
	public function SaveBoletas(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);
			$dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$formato=$data['formato'];
			if(!$formato){
				return new View("Es necesario agregar un formato.", Response::HTTP_PARTIAL_CONTENT);
			}
			$dbm->getConnection()->beginTransaction();
			$boletas=new CeBoletas();
			$boletas->setNombre(empty($data['nombre']) ? null : $data['nombre']);
			$boletas->setFormato(json_encode($formato));
			$dbm->saveRepositorio($boletas);

			//Guardamos los datos de la boleta oficial
			$oficial=$data['oficial'];
			if(!$oficial){
				return new View("Es necesario agregar un formato oficial.", Response::HTTP_PARTIAL_CONTENT);
			}
			$boletao=new CeBoletas();
			$boletao->setNombre(empty($data['nombre']) ? null : $data['nombre']);
			$boletao->setFormato(json_encode($oficial));
			$dbm->saveRepositorio($boletao);

			foreach($data['cicloid'] as $c){
				$boletasciclos=new CeBoletaporciclo();
				$boletasciclos->setCicloid(empty($c) ? null : $dbm->getRepositorioById('Ciclo', 'cicloid', $c));
				$boletasciclos->setBoletaid($boletas);
				$dbm->saveRepositorio($boletasciclos);

				$boletaociclos=new CeBoletaporciclo();
				$boletaociclos->setCicloid(empty($c) ? null : $dbm->getRepositorioById('Ciclo', 'cicloid', $c));
				$boletaociclos->setBoletaid($boletao);
				$dbm->saveRepositorio($boletaociclos);
			}
			foreach($data['gradoid'] as $g){
				$boletasgrados=new CeBoletaporgrado();
				$boletasgrados->setGradoid(empty($g) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $g));
				$boletasgrados->setOficial(0);
				$boletasgrados->setBoletaid($boletas);
				$dbm->saveRepositorio($boletasgrados);

				$boletaogrados=new CeBoletaporgrado();
				$boletaogrados->setGradoid(empty($g) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $g));
				$boletaogrados->setOficial(1);
				$boletaogrados->setBoletaid($boletao);
				$dbm->saveRepositorio($boletaogrados);
			}


			$dbm->getConnection()->commit();
			return new View("Se ha guardado el registro", Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
	/**
	 * @Rest\Put("/api/Controlescolar/Boletas/{id}" , name="updateBoleta")
	 */
	public function updateBoleta($id){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);
			$dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$formato=$data['formato'];
			$oficial=$data['oficial'];
			$oficialid=$data['boletaoficialid'];
			$dbm->getConnection()->beginTransaction();
			$boletas=$dbm->getRepositorioById('CeBoletas', 'boletaid', $id);
			$boletas->setNombre(empty($data['nombre']) ? null : $data['nombre']);
			if($formato){
				$boletas->setFormato(json_encode($formato));
			}
			$dbm->saveRepositorio($boletas);

			if($oficial) {
				$boletao=$oficialid ? $dbm->getRepositorioById('CeBoletas', 'boletaid', $oficialid) : new CeBoletas();
				$boletao->setNombre(empty($data['nombre']) ? null : $data['nombre']);
				$boletao->setFormato(json_encode($oficial));
				$dbm->saveRepositorio($boletao);
			}

			$bolids = explode(",",$data['boletasids']);
			foreach($bolids as $bolid) {
				$dbm->removeManyRepositorio('CeBoletaporciclo', 'boletaid', $bolid);
				$dbm->removeManyRepositorio('CeBoletaporgrado', 'boletaid', $bolid);
			}

			foreach($data['cicloid'] as $c){
				$boletasciclos=new CeBoletaporciclo();
				$boletasciclos->setCicloid(empty($c) ? null : $dbm->getRepositorioById('Ciclo', 'cicloid', $c));
				$boletasciclos->setBoletaid($boletas);
				$dbm->saveRepositorio($boletasciclos);

				if($boletao) {
					$boletaociclos=new CeBoletaporciclo();
					$boletaociclos->setCicloid(empty($c) ? null : $dbm->getRepositorioById('Ciclo', 'cicloid', $c));
					$boletaociclos->setBoletaid($boletao);
					$dbm->saveRepositorio($boletaociclos);
				}
			}

			foreach($data['gradoid'] as $g){
				$boletasgrados=new CeBoletaporgrado();
				$boletasgrados->setGradoid(empty($g) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $g));
				$boletasgrados->setOficial(0);
				$boletasgrados->setBoletaid($boletas);
				$dbm->saveRepositorio($boletasgrados);

				if($boletao) {
					$boletaogrados=new CeBoletaporgrado();
					$boletaogrados->setGradoid(empty($g) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $g));
					$boletaogrados->setOficial(1);
					$boletaogrados->setBoletaid($boletao);
					$dbm->saveRepositorio($boletaogrados);
				}
			}

			$dbm->getConnection()->commit();
			return new View("Se ha actualizado el registro", Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
	/**
	 * @Rest\Get("/api/Controlescolar/Boletas/{id}", name="getBoletaJasper")
	 */
	public function getBoletaJasper($id){
		$rs=$this->getDM()->getBBoletaById($id);
		if($rs=== false){
			return Api::Error(Response::HTTP_BAD_REQUEST, false);
		}
		$data=$rs[0];
		if(!$data || !$data['formato']){
			return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No existe formato.");
		}
		$fdata=json_decode(stream_get_contents($data['formato']), true);
		$size=$fdata['size'];
		$jasper=base64_decode($fdata['value']);
		return new Response($jasper, 200, [
				'Content-Disposition'=>'attachment; filename="Boleta.jrxml"',
				'Content-Length'=>$size
		]);
	}
	private function getDM(){
		if($this->DBM){
			return $this->DBM;
		}
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}