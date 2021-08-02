<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Entity\CePeriodoregularizacion;
use FOS\RestBundle\View\View;

/**
 * Autor: Emmanuel Martinez
 */
class PeriodoRegularizacionController extends FOSRestController {
    private static $REPOSITORIO="CePeriodoregularizacion";
    private static $REPOSITORIO_FID="periodoregularizacionid";
    private static $INVALID_RQ="Peticion invalida.";
    private static $NOT_FOUND="Periodo(s) regularizacion no encontrado(s).";
    private static $CREATE_SUCCESS="Periodo de regularizacion guardado correctamente.";
    private static $CREATE_INAME="No se puede crear debido a que el nombre no se puede repetir en el mismo ciclo.";
    private static $CREATE_IDATES="No se puede crear debido a que las fechas no se pueden superponer.";
    private static $EDIT_SUCCESS="Periodo de regularizacion editado correctamente.";
    private static $EDIT_INAME="No se puede editar debido a que el nombre no se puede repetir en el mismo ciclo.";
    private static $EDIT_IDATES="No se puede editar debido a que las fechas no se pueden superponer.";
    private static $EDIT_IRELATIONS="No se puede editar debido a que tiene agendas asignadas.";
    private static $DELETE_SUCCESS="Periodo de regularizacion eliminado correctamente.";
    private static $DELETE_RELATIONS="No se puede eliminar debido a que tiene agendas asignadas.";
    /**
     * @Annotations\Get("/api/Controlescolar/PeriodoRegularizacion/filter", name="getFilterPeriodoRegularizacion")
     */
    public function getFilterPeriodoRegularizacion() {
        try{
            $ciclo=$this->getDM()->getBasicCiclo();
            return Api::Ok("", array("ciclo" => $ciclo));
        }catch(\Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage()); }
    }
    /**
     * @Annotations\Get("/api/Controlescolar/PeriodoRegularizacion", name="getPeriodoRegularizacion")
     */
    public function getPeriodoRegularizacion(){
        $request=array();
        $requestRaw=$_REQUEST;
        if(!empty($requestRaw['activo'])){ $request['activo']=(int)$requestRaw['activo']; }
        if(!empty($requestRaw['cicloid'])){ $request['cicloid']=(int)$requestRaw['cicloid']; }
        if(isset($requestRaw['permitecursos']) && strlen($requestRaw['permitecursos'])>0){ $request['permitecursos']=(int)$requestRaw['permitecursos']; }
        list($status,$result)=$this->getPeriodoRegularizacionByParams($request);
        return ($status
            ? Api::Ok("", $result)
            : Api::Error(Response::HTTP_BAD_REQUEST, $result));
    }
    /**
     * @Annotations\Get("/api/Controlescolar/PeriodoRegularizacion/{id}", name="getPeriodoRegularizacionByID")
     */
    public function getPeriodoRegularizacionByID($id){
        list($status,$result)=$this->getPeriodoRegularizacionByParams(array(self::$REPOSITORIO_FID=>$id));
        if($status){
            return ($result
                ? Api::Ok("", $result)
                : Api::Error(Response::HTTP_PARTIAL_CONTENT, self::$NOT_FOUND));
        }else{ return Api::Error(Response::HTTP_BAD_REQUEST, $result); }
    }
    /**
     * @Annotations\Post("/api/Controlescolar/PeriodoRegularizacion", name="createPeriodoRegularizacion")
     */
    public function createPeriodoRegularizacion(){
        try{
            $requestRaw=trim(file_get_contents("php://input"));
            $request=json_decode($requestRaw,true);
            if(empty($request['cicloid'])){ return Api::Error(Api::HTTP_BAD_REQUEST,self::$INVALID_RQ); }
            $dbm=$this->getDM();
            $periodo=new CePeriodoregularizacion();
            (new ArrayHydrator($dbm->getEntityManager()))->hydrate($periodo, $request);
            if(!$this->isValidName($periodo)){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,self::$CREATE_INAME); }
            if(!$this->isValidDate($periodo)){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,self::$CREATE_IDATES); }
            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($periodo);
            $dbm->getConnection()->commit();
            return Api::Ok(self::$CREATE_SUCCESS, $periodo);
        }catch(\Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage()); }
    }
    /**
     * @Annotations\Put("/api/Controlescolar/PeriodoRegularizacion/{id}", name="updatePeriodoRegularizacion")
     */
    public function updatePeriodoRegularizacion($id){
        $dbm=$this->getDM();
        $periodoregularizacionid=(int)$id;
        $requestRaw=trim(file_get_contents("php://input"));
        $request=json_decode($requestRaw,true);
        $instituto = ENTORNO;
        list($status,$periodo)=$this->getPeriodoRegularizacionByParams(array(self::$REPOSITORIO_FID=>$periodoregularizacionid));
        if(!$status){ return Api::Error(Response::HTTP_BAD_REQUEST,$periodo); }
        if(!$periodo){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,self::$NOT_FOUND); }
        if(isset($request[self::$REPOSITORIO_FID])){ unset($request[self::$REPOSITORIO_FID]); }
        if($request['validar']) {
            $agendas = $dbm->getRepositoriosById('CeAgendaextraordinario', 'periodoregularizacionid', $periodoregularizacionid);
            if(count($agendas) > 0) {
                return new View(["validar" => true], Response::HTTP_PARTIAL_CONTENT);
            }
            $acuerdos = $dbm->getRepositoriosById('CeAcuerdoextraordinario', 'periodoregularizacionid', $periodoregularizacionid);
            if(count($acuerdos) > 0) {
                return new View(["validaracuerdo" => true], Response::HTTP_PARTIAL_CONTENT);
            }
        }
        try{
            (new ArrayHydrator($dbm->getEntityManager()))->hydrate($periodo, $request);
            if(!$this->isValidName($periodo)){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,self::$EDIT_INAME); }
            if(!$this->isValidDate($periodo)){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,self::$EDIT_IDATES); }
            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($periodo);
            $dbm->getConnection()->commit();
            return Api::Ok(self::$EDIT_SUCCESS, $periodo);
        }catch(\Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST,$e->getMessage()); }
    }
    /**
     * @Annotations\Delete("/api/Controlescolar/PeriodoRegularizacion/{id}", name="deletePeriodoRegularizacion")
     */
    public function deletePeriodoRegularizacion($id){
        $id=(int)$id;
        list($status,$periodo)=$this->getPeriodoRegularizacionByParams(array(self::$REPOSITORIO_FID=>$id));
        if(!$status){ return Api::Error(Response::HTTP_BAD_REQUEST,$periodo); }
        if(!$periodo){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,self::$NOT_FOUND); }
        if(!$this->isEditable($periodo)){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,self::$DELETE_RELATIONS); }
        try{
            $dbm=$this->getDM();
            $dbm->getConnection()->beginTransaction();
            $dbm->removeRepositorio($periodo);
            $dbm->getConnection()->commit();
            return Api::Ok(self::$DELETE_SUCCESS, true);
        }catch(\Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST,$e->getMessage()); }
    }
    
    private function getPeriodoRegularizacionByParams($params){
        try{
            $dbm=$this->getDM();
            if(!empty($params[self::$REPOSITORIO_FID])){
                return array(true,$dbm->getRepositorioById(self::$REPOSITORIO, self::$REPOSITORIO_FID, $params[self::$REPOSITORIO_FID]));
            }
            return array(true,$dbm->getByParametersRepositorios(self::$REPOSITORIO,$params));
        }catch(\Exception $e){ return array(false,$e->getMessage()); }
    }
    private function getAgendaRegularizacionByPeriodoregularizacionID($id){
        //return array(true,array());
        try{
            $dbm=$this->getDM();
            return array(true,$dbm->getByParametersRepositorios("CeAgendaextraordinario", array(self::$REPOSITORIO_FID=>$id)));
        }catch(\Exception $e){ return array(false,$e->getMessage()); }
    }

    private function isEditable(CePeriodoregularizacion $periodo){
        $id=$periodo->getPeriodoregularizacionid();
        list($status,$result)=$this->getAgendaRegularizacionByPeriodoregularizacionID($id);
        if($status){ return (sizeof($result)<1); }
        return false;
    }
	private function isValidName(CePeriodoregularizacion $periodo){
		return $this->getDM()->getPRNombreValido($periodo->getCicloid()->getCicloid(),$periodo->getNombre(),$periodo->getPeriodoregularizacionid());
	}
	private function isValidDate(CePeriodoregularizacion $periodo){
		$fini=$periodo->getFechaInicio();
		$ffin=$periodo->getFechaFin();
		if($fini>$ffin){ return false; }
		return $this->getDM()->getPRFechasValidas($periodo->getCicloid()->getCicloid(),$fini,$ffin,$periodo->getPeriodoregularizacionid());
	}

	private function getDM(){
		if($this->DBM){ return $this->DBM; }
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}
