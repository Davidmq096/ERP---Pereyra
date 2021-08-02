<?php

namespace AppBundle\Controller\Ludoteca;


use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DatabaseManager;
use AppBundle\Entity\LuImportepormesportipo;

/**
 * Autor: Emmanuel Martinez
 */
class LudotecaConfiguracionController extends FOSRestController{
    private $edbm=false;
    /**
     * Retorna arreglo ludotecas con configuracion
     * @Annotations\Get("/api/Ludoteca/Configuracion", name="getLudotecaConfiguracion")
     */
    public function getLudotecaConfiguracion(){
        $dbm=$this->getDM();
        try{
            $configuracion=$dbm->getRepositorios('LuConfiguracion');
						$ludotecatipo=$dbm->getRepositoriosModelo("LuTipo",["d.tipoid","d.nombre"],["activo"=>1]);
						$ludotecapormes=$dbm->getRepositoriosModelo("LuImportepormesportipo",["d.importepormesportipoid","d.mes","IDENTITY(d.tipoid) AS tipoid","d.importe"]);
						$subconceptosconfig=$this->getSubconceptosConfig();
            $subconceptos=$this->getSubconceptos();//$dbm->getRepositoriosById('CjSubconcepto','activo',1);
            return Api::Ok(Response::HTTP_OK,[
								"ludotecatipo"=>$ludotecatipo,
								"ludotecapormes"=>$ludotecapormes,
                "ludotecaconfig"=>$configuracion,
								"subconceptosconfig"=>$subconceptosconfig,
                "subconceptos"=>$subconceptos
            ]);
        }catch(Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST,$e->getMessage()); }
    }
    /**
     * Actualiza configuracion de ludotecas
     * @Annotations\Put("/api/Ludoteca/Configuracion", name="updateLudotecaConfiguracion")
     */
    public function updateLudotecaConfiguracion(){
        $requestRaw=trim(file_get_contents("php://input"));
        $request=json_decode($requestRaw,true);
        if(sizeof($request['ludotecas'])<1){ return Api::Error(Response::HTTP_BAD_REQUEST,""); }
        $ids=[];
        $ref=[];
        foreach($request['ludotecas'] AS $i){
					$id=(int)$i['id'];
					$ids[]=$id;
					$ref[$id]=$i;
					unset($i['id']);
        }
        $ludotecas=$this->getLudotecasByIds($ids);
        try{
            $dbm=$this->getDM();
            $dbm->getConnection()->beginTransaction();
						//$subc=$this->getSubconceptosConfigArray();
						//foreach($subc AS $k=>$i){
						//	if(!isset($request[$i])){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"Petición incompleta."); }
						//	$repo=$dbm->getRepositorioById('Parametros', 'nombre', $k);
						//	if(!$repo){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"Parametros no coinciden."); }
						//	$repo->setValor($request[$i]);
						//	$dbm->saveRepositorio($repo);
						//}
            foreach($ludotecas AS $i){
							$nf=$ref[$i->getConfiguracionid()];
							if($nf){
								$i->setFechainicio(new \DateTime($nf['fechainicio']));
								$i->setFechafin(new \DateTime($nf['fechafin']));
								$dbm->saveRepositorio($i);
							}
            }

            //foreach($request['ludotecaspormes'] AS $l){
            //   $ludoteca =  $dbm->getRepositorioById('LuImportepormesportipo', 'importepormesportipoid', $l['importepormesportipoid']);
            //   if (!$ludoteca) {
            //        $ludoteca = new LuImportepormesportipo(); 
            //        $ludoteca->setMes($l['mesid']);
            //        $ludoteca->setTipoid(!$l['tipoid'] ? null : $dbm->getRepositorioById('LuTipo', 'tipoid', $l['tipoid']));
            //   }
            //   $ludoteca->setImporte($l['importe']);
            //   $dbm->saveRepositorio($ludoteca);
            //}

            $dbm->getConnection()->commit();
            return Api::Ok(Response::HTTP_OK,true);
        }catch(Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST,$e->getMessage()); }
    }
    private function getLudotecasByIds($ids){
        $dbm=$this->getDM();
        $r=$dbm->getByParametersRepositorios("LuConfiguracion", ["configuracionid"=>$ids]);
        return $r;
    }
    private function getSubconceptosConfig(){
        $dbm=$this->getDM();
				$data=[];
				$nombres=[];
				$subc=$this->getSubconceptosConfigArray();
				foreach($subc AS $k=>$i){ $nombres[]=$k; }
				foreach($dbm->getRepositoriosModelo("Parametros", ["d.parametrosid AS id", "d.parametrosid", "d.nombre", "d.valor"], ["nombre"=>$nombres]) AS $i){
					$k=$i['nombre'];
					$data[$subc[$k]]=(int) $i['valor'];
				}
        return $data;
    }
		private function getSubconceptosConfigArray(){
			return [
				"LudotecaContratoPorcentaje"=>"porcentaje",
				"LudotecaContratoSubconceptoMatutino"=>"matutinoid",
				"LudotecaContratoSubconceptoVespertino"=>"vespertinoid",
				"LudotecaContratoSubconceptoDeportes"=>"deportesid",
				"LudotecaDiarioPorcentaje"=>"diarioporcentaje",
				"LudotecaDiarioSubconceptoMatutino"=>"diariomatutinoid",
				"LudotecaDiarioSubconceptoVespertino"=>"diariovespertinoid",
				"LudotecaDiarioSubconceptoDeportes"=>"diariodeportesid"
			];
		}
    private function getSubconceptos(){
				$data=$this->getDM()->getRepositoriosModelo("CjSubconcepto", ["d.subconceptoid AS id", "d.nombre"], ["activo"=>1]);
        return $data;
    }
    private function getDM(){
        if($this->edbm){ return $this->edbm; }
        try{
            $this->edbm=new DatabaseManager($this->get("db_manager")->getEntityManager());
            return $this->edbm;
        }catch(\Exception $e){ return false; }
    }
}
