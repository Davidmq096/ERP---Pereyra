<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
use AppBundle\Entity\CeMaterialporalumnocicloportallerextracurricular;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
use AppBundle\Controller\lib\PDFMerger\PDFMerger;
/**
 * Autor: Emmanuel Martinez
 */
class TallerExtracurricularArmadoController extends FOSRestController{
	private $DBM=false;
	private static $TESTATUSID_INSCRITO=3;
	private static $TESTATUSID_PREREGISTRO=1;
	private $tallerExtra=null;
	private $estatusinscrito=null;

	/**
		* @Annotations\Get("/api/Controlescolar/Tallerextracurriculararmado/filter", name="getTEAFilter")
		*/
	public function getTEAFilter(){
		try{
			$dbm=$this->getDM();
			$ciclo=$dbm->getBasicCiclo();
			$nivel=$dbm->getBasicNivel();
			$tallerextrac=$dbm->getBasicTallerExtracurricular();
			$data=array(
					"ciclo"=>$ciclo,
					"nivel"=>$nivel,
					"taller"=>$tallerextrac
			);
			return Api::Ok("", $data);
		}catch(\Exception $e){
			return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
		}
	}

	/**
    * @Annotations\Get("/api/Controlescolar/Tallerextracurriculararmado/imprimir/{tallerextraid}", name="getTEAPDF")
    */
	public function getTEAPDF($tallerextraid){
		$report="ListaAlumnos";
		$output="TallerextracurricularArmado";
		$json="TallerextracurricularArmado";
		$dbJSON=array(
			'driver'=>'json',
			'data_file'=>$json,
			'json_query'=>'""'
		);
		$pdf=new LDPDF($this->container, $report, $output, $dbJSON);
		if($this->loadTEAPDFData($pdf->fdb_r, $tallerextraid)){
			$result=$pdf->execute();
			if(!$result){
				return new Response(file_get_contents($pdf->output_r), 200, array(
					'Content-Type'=>'application/pdf',
					'Content-Length'=>filesize($pdf->output_r)
				));
			}
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}

	public function loadTEAPDFData($filePath, $tallerextraid){
		$nivelid=(int) $_REQUEST['nivelid'];
		if(!$nivelid || $nivelid<1){ $nivelid=null; }
		$dbm=$this->getDM();
		$header=$dbm->getTEAPDFHeaderByTallerextracurricular($tallerextraid);
		$alumnos=$dbm->getTEAPDFAlumnoByTallerextracurricular($tallerextraid, $nivelid);
		if($header && $alumnos){
			$data=array(
				"header"=>$header,
				"student"=>$alumnos
			);
			$file=LDPDF::fileRead($filePath);
			LDPDF::fileWrite($file, json_encode($data));
			LDPDF::fileRelease($file);
			return true;
		}
		return false;
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/Tallerextracurriculararmado/asignado", name="getTEAAsignadoByTaller")
	 */
	public function getTEAAsignadoByTaller(){
        try{
		$cicloid=(int) $_REQUEST['cicloid'];
		$nivelid=(int) $_REQUEST['nivelid'];
		$tallerid=(int) $_REQUEST['tallerid'];
		$matricula=$_REQUEST['matricula'];
		if(empty($matricula)){ $matricula=null; }
		if(!$nivelid || $nivelid<1){ $nivelid=null; }
		if(!$tallerid || $tallerid<1){ $tallerid=null; }
		if(!$cicloid || $cicloid<1){ return Api::Error(Response::HTTP_BAD_REQUEST, "Peticion invalida"); }
		$data=$this->getDM()->getTEAAlumnocicloportallerextraByTaller($cicloid, [
			'nivelid'=>$nivelid,
			'tallerid'=>$tallerid,
			'matricula'=>$matricula
		]);
		if(!$data){ return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No se encontraron datos"); }
        return Api::Ok("",$data);
        }catch(\Exception $e){
			return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
		}
	}

    /**
     * @Annotations\Put("/api/Controlescolar/Tallerextracurriculararmado/asignado/{tallerid}", name="updateTEAAsignadoByTaller")
     */
    public function updateTEAAsignadoByTaller($tallerid){
        $this->tallerExtra=$this->getDM()->getRepositorioById("CeTallerextracurricular", "tallerextracurricularid", (int)$tallerid);
        return $this->setTEAByAsignacionIdFN("updateTEAAsignadoByTallerFN");
    }
    private function updateTEAAsignadoByTallerFN($i){
        $doc=$i->getDocumentoporpagarid();
        $status=$i->getTallerextraestatusinscripcionid();
        $statusid=($status ? $status->getTallerextraestatusinscripcionid() : 0);
        if($doc && ($statusid==self::$TESTATUSID_INSCRITO || $statusid==self::$TESTATUSID_PREREGISTRO)){//If is paid and is editable
            if(!$this->estatusinscrito){
                $this->estatusinscrito=$this->getDM()->getRepositorioById("CeTallerextraestatusinscripcion", "tallerextraestatusinscripcionid", self::$TESTATUSID_INSCRITO);
            }
            $i->setTallerextraid($this->tallerExtra);
            $i->setTallerextraestatusinscripcionid($this->estatusinscrito);
            return true;
        }
        return false;
    }

    /**
     * @Annotations\Delete("/api/Controlescolar/Tallerextracurriculararmado/asignado/{alumnoid}", name="deleteTEAAsignadoByAlumno")
     */
    public function deleteTEAAsignadoByAlumno($alumnoid){
        $alumnocicloportallerextraid=(int)$alumnoid;
        if($alumnocicloportallerextraid>0){
            $dbm=$this->getDM();
            try{
                $taller=$dbm->getRepositorioById("CeAlumnocicloportallerextra", "alumnocicloportallerextraid", $alumnocicloportallerextraid);
                if($taller){

                    if(ENTORNO == 1){
                        $dbm->getConnection()->beginTransaction();
                        $dbm->removeRepositorio($taller);
                        $dbm->getConnection()->commit();
                        return Api::Ok("",true);
                    }else{
                        $dbm->getConnection()->beginTransaction();
                        if($taller->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNivelid() == 3 || $taller->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNivelid() == 4){
                            if($taller->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 2){
                                if($taller->getDocumentoporpagarid()){
                                    $pordocumento = $dbm->getRepositoriosById('CeAlumnocicloportallerextra','documentoporpagarid', $taller->getDocumentoporpagarid()->getDocumentoporpagarid());
                                    if(count($pordocumento) == 1){
                                        //se elimina el documento por pagar
                                        $documentoporpagar = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $taller->getDocumentoporpagarid()->getDocumentoporpagarid());
                                        $dbm->removeRepositorio($taller);
                                        $dbm->removeRepositorio($documentoporpagar);
                                    }else{
                                        $dbm->removeRepositorio($taller);
                                    }
                                }else{
                                    // eliminamos el registro
                                    $dbm->removeRepositorio($taller);
                                }
                            }else{
                                return new View("No se puede eliminar la inscripción del taller", Response::HTTP_PARTIAL_CONTENT);
                            }
                        }else{
                            if($taller->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 2){
                                // eliminamos el registro
                                $dbm->removeRepositorio($taller);
                            }else{
                                return new View("No se puede eliminar la inscripción del taller", Response::HTTP_PARTIAL_CONTENT);
                            }
                        }
                        $dbm->getConnection()->commit();
                        return Api::Ok("",true);
                    }
                }
                return Api::Error(Response::HTTP_PARTIAL_CONTENT,"Alumno incorrecto.");
            }catch(\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No se puede eliminar debido a que ya ha sido entregado el material, o esta asociado en otro modulo.");
            }catch(\Exception $e){ $dbm->getConnection()->rollBack(); }
            return Api::Error(Response::HTTP_PARTIAL_CONTENT,"Error interno. Intentelo más tarde.");
        }
        return Api::Error(Response::HTTP_BAD_REQUEST,false);
    }

    /**
     * @Annotations\Get("/api/Controlescolar/Tallerextracurriculararmado/material/{tallerid}", name="getTEAMaterialByTallerId")
     */
    public function getTEAMaterialByTallerId($tallerid){
			$data=$this->getDM()->getTEAMaterialByTaller($tallerid);
			if($data===false){ return Api::Error(Response::HTTP_BAD_REQUEST, false); }
      return Api::Ok("",$data);
    }
    /**
     * @Annotations\Post("/api/Controlescolar/Tallerextracurriculararmado/material", name="setTEAMaterialByAlumnoId")
     */
    public function setTEAMaterialByAlumnoId(){
        $requestRaw=trim(file_get_contents("php://input"));
        $request=json_decode($requestRaw,true);
        if(isset($request['alumno']) && isset($request['talla'])){
            $materialk=array();
            $materialid=array();
            $materialRaw=$request['talla'];
            $alumnoid=$request['alumno'];
            $alumnoidSZ=sizeof($alumnoid);
            foreach($materialRaw AS $i){
                list($id,$talla)=$i;
                $materialid[]=$id;
                $materialk[$id]=$talla;
            }
            if($alumnoidSZ>0){
                $dbm=$this->getDM();
                $alumnotaller=$dbm->getRepositoriosById("CeAlumnocicloportallerextra", "alumnocicloportallerextraid", $alumnoid);
                if(sizeof($alumnotaller)==$alumnoidSZ){
                    $material=array();
                    $materialSZ=sizeof($materialid);
                    if($materialSZ>0){
                        $materialData=$dbm->getRepositoriosById("CeMaterialportallerextracurricular", "materialportallerextracurricularid", $materialid);
                        if(sizeof($materialData)!=$materialSZ){ return Api::Error(Response::HTTP_BAD_REQUEST, false); }
                        foreach($materialData AS $i){
                            $material[]=array($i,$materialk[$i->getMaterialportallerextracurricularid()]);
                        }
                    }
                    try{
                        $dbm->getConnection()->beginTransaction();
                        foreach($alumnotaller AS $i){
                            if(!$i->getMaterialentregado()){
                                $i->setMaterialentregado(true);
                                foreach($material AS $j){
                                    list($jmaterial,$talla)=$j;
                                    $di=new CeMaterialporalumnocicloportallerextracurricular();
                                    $di->setAlumnocicloportallerextraid($i);
                                    $di->setMaterialportallerextracurricularid($jmaterial);
                                    $di->setTalla($talla);
                                    $di->setFechaentrega(new \DateTime());
                                    $dbm->saveRepositorio($di);
                                }
                                $dbm->saveRepositorio($i);
                            }
                        }
                        $dbm->getConnection()->commit();
                        return Api::Ok("",true);
                    }catch(\Exception $e){
                        $dbm->getConnection()->rollBack();
                        return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
                    }
                }
            }
        }
        return Api::Error(Response::HTTP_BAD_REQUEST, false);
    }
	/**
	* @Annotations\Get("/api/Controlescolar/Tallerextracurriculararmado/material/imprimir/{alumnociclotallerextraid}", name="getTEAMaterialPDF")
	*/
 public function getTEAMaterialPDF($alumnociclotallerextraid){
		$report="TallerextracurricularArmadoMaterial";
		$output="TallerextracurricularArmadoMaterial";
		$json="TallerextracurricularArmadoMaterial";
		$dbJSON=array(
			'driver'=>'json',
			'data_file'=>$json,
			'json_query'=>'""'
		);
		$pdf=new LDPDF($this->container, $report, $output, $dbJSON);
		if($this->loadTEAMaterialPDFData($pdf->fdb_r, $alumnociclotallerextraid)){
			$result=$pdf->execute();
			if(!$result){
				return new Response(file_get_contents($pdf->output_r), 200, [
					'Content-Type'=>'application/pdf',
					'Content-Length'=>filesize($pdf->output_r)
				]);
			}
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	public function loadTEAMaterialPDFData($filePath,$alumnociclotallerextraid){
		$dbm=$this->getDM();
		$header=$dbm->getTEAPDFMaterialHeaderByAlumnociclotallerextra($alumnociclotallerextraid);
		$material=$dbm->getTEAPDFMaterialByAlumnociclotallerextra($alumnociclotallerextraid);
		if($header && $material){
			foreach($material AS $i){
				if($i['pedirtalla'] && !$i['talla']){
					return false;
				}
			}
			$data=[
				"header"=>$header,
				"material"=>$material
			];
			$file=LDPDF::fileRead($filePath);
			LDPDF::fileWrite($file,json_encode($data));
			LDPDF::fileRelease($file);
			return true;
		}
		return false;
	}

    /**
     * @Annotations\Post("/api/Controlescolar/Tallerextracurriculararmado/reglamento", name="setTEAReglamento")
     */
    public function setTEAReglamento(){
        return $this->setTEAByAsignacionIdFN("setTEAReglamentoFN");
    }

    private function setTEAReglamentoFN($i){
        $i->setReglamento(true);
        return true;
    }

    private function setTEAByAsignacionIdFN($doFn){
        $requestRaw=trim(file_get_contents("php://input"));
        $request=json_decode($requestRaw,true);
        if(sizeof($request)>0){
            foreach($request AS $k=>$i){ $request[$k]=(int)$i; }
            try{
                $dbm=$this->getDM();
                $asignacion=$dbm->getRepositoriosById("CeAlumnocicloportallerextra", "alumnocicloportallerextraid", $request);
                if(sizeof($asignacion)>0){
                    $dbm->getConnection()->beginTransaction();
                    foreach($asignacion AS $i){
                        $r=$this->$doFn($i);
                        if($r){ $dbm->saveRepositorio($i); }
                        else{
                            return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Es necesario que primero realice el pago de talleres en caja.");
                        }
                    }
                    $dbm->getConnection()->commit();
                    return Api::Ok("",true);
                }
            }catch(\Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage()); }
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
    
    /**
     * @Annotations\Post("/api/Controlescolar/Tallerextracurriculararmado/credencial", name="setCredencialAlumno")
     */
    public function setCredencialAlumno(){
        $requestRaw=trim(file_get_contents("php://input"));
        $alumnos=json_decode($requestRaw,true);
        $dbm=$this->getDM();
        $dbm->getConnection()->beginTransaction();

        foreach($alumnos AS $alu) {
            $alumnotallerextra = $dbm->getRepositorioById("CeAlumnocicloportallerextra", "alumnocicloportallerextraid", $alu);
            $alumnotallerextra->setCredencialentregada(1);
            $dbm->saveRepositorio($alumnotallerextra);
        }
        $dbm->getConnection()->commit();
        return Api::Ok("Se ha guardado el registro",true);
    }

    /**
    * @Annotations\Get("/api/Controlescolar/Tallerextracurriculararmado/descargarCredencial/", name="descargarCredencial")
    */
    public function descargarCredencial() {
        $datos = $_REQUEST;
        $filtros = array_filter($datos);
        $env=[1=>"Lux/",2=>"Ciencias/"];
        $arrayalumnos = array();
        $arraytalleres = array();
        $dbm=$this->getDM();
        try{
            foreach ($filtros['alumnos'] as $a) {
                $arrayalumnos[$a['tallerid']][] = $a['alumnoid'];
                $arraytalleres[]= $a['tallerid'];
            }
            $tallerids=array_values(array_unique(array_column($filtros['alumnos'], 'tallerid')));
            foreach($tallerids as $id) {
                $report="../tmp_credential_{$id}";
                $baseJSON="Credential_";
                $baseOutput="Credential_";
                $outputFile="{$baseOutput}G{$id}";
                $pdf=new LDPDF($this->container, $report, $outputFile);
                $hasCredential=$this->loadReportCredential($pdf->report_r, $id);
                $outputPath=$pdf->output_r;
                $reportPath=$pdf->report_r;
                $toremove[]=$reportPath;
                if(!$hasCredential){
                   return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No han subido un formato para uno o mas talleres.");
                }
                $json="$baseJSON$id";
                $output="$baseOutput$id";
                $arralumnos = implode(",",$arrayalumnos[$id]);
                $pdf=new LDPDF($this->container, $report, $output, false, ["alumnotallerid"=>$arralumnos]);
                $toremove[]=$pdf->fdb_r;
                if(!$pdf->execute()){
                    $atLeastOne=true;
                    $tomerge[]=$pdf->output_r;
                    $toremove[]=$pdf->output_r;
                    continue;
                }else{ var_dump("Error generando boleta alumno [$id]."); }
            }
			if(!$atLeastOne){
				return Api::Error(207, "No se ha definido el formato de credencial.");
			}
			$merger=new PDFMerger();
			foreach($tomerge AS $i){ $merger->addPDF($i); }
			$merger->merge("file",$outputPath);
			$toremove[]=$outputPath;
			$credentialSize=filesize($outputPath);
			$credential=file_get_contents($outputPath);
			//return false;
			$this->getBIPDFCleanFiles(array_unique($toremove));
			return new Response($credential, 200, array(
				'Content-Type'=>'application/pdf',
				'Content-Length'=>$credentialSize
			));
        }catch(Exception $e){ return new View($e->getMessage(), Response::HTTP_BAD_REQUEST); }
    }
    private function getCMDPath($x){
        return "\"$x\"";
    }

    public function loadReportCredential($filePath,$tallerid){
		$rs=$this->getDM()->getRepositorioById("CeTallerextracurricular", "tallerextracurricularid", $tallerid);
		if($rs && sizeof($rs)>0){
			$data=$rs;
			if(!$data || !$data->getFormato()){ return false; }
			$fdata=json_decode(stream_get_contents($data->getFormato()),true);
			$jasper=base64_decode($fdata['value']);
			$file=LDPDF::fileRead($filePath);
			LDPDF::fileWrite($file, $jasper);
			LDPDF::fileRelease($file);
			return true;
		}
		return false;
    }
    
    private function getBIPDFCleanFiles($files){
		foreach($files AS $i){
			LDPDF::fileDelete($i);
		}
    }
    
        /**
    * @Annotations\Get("/api/Controlescolar/Tallerextracurriculararmado/descargarReporteMaterial/", name="descargarReporteMaterial")
    */
    public function descargarReporteMaterial() {
        $datos = $_REQUEST;
        $filtros = array_filter($datos);
        $env=[1=>"Lux/",2=>"Ciencias/"];
        $arrdatos = [];
        try{
            $dbm = $this->getDM();
            $datos = $dbm->loadMaterialReport($filtros);
            $materiales = $dbm->loadTalleresMateriales($filtros);
            $ciclo = $dbm->getRepositorioById("Ciclo", "cicloid", $filtros['cicloid']);
            foreach($datos as $kyz=>$d) {
                $posicion = 12;
                foreach($materiales as $m) {
                    $posicion++;
                    $materialalumno =  $dbm->getRepositoriosModelo("CeMaterialporalumnocicloportallerextracurricular", 
                            ["t.nombre as material, d.talla"], 
                            [["alumnocicloportallerextraid = " . $d['alumnocicloportallerextraid'] . " and t.tallermaterialid = " . $m['TallerMaterialId']]], false, true, [

                                ["entidad" => "CeMaterialportallerextracurricular", "alias" => "mt", "left" => false, "on" => "mt.materialportallerextracurricularid = d.materialportallerextracurricularid"],
                                ["entidad" => "CeTallermaterial", "alias" => "t", "left" => false, "on" => "t.tallermaterialid = mt.tallermaterialid"]
                        ])[0];

                    $material = $m['material'];
                    $entregado = $materialalumno['material'] ? "SI" : "NO";
                    $pushmat = [$material => $entregado];
                    $d = $this->InsertarPosicion($d, $pushmat, $posicion);
                    $posicion++;
                    $material = $m['material'] . " talla";
                    $talla = $materialalumno['talla'] ?  $materialalumno['talla']  : "-";
                    $pushmat = [$material => $talla];
                    $d = $this->InsertarPosicion($d, $pushmat, $posicion);
                }
                foreach ($d as $key=>$z) {
                    $f = strcmp($key, "alumnocicloportallerextraid") !== 0;
                    if(strcmp($key, "alumnocicloportallerextraid") !== 0) {
                        $arrdatos[]= ["x" => $kyz, "y"=> $key, "val"=> $z];
                    }
                }
            }
            $mati = $dbm->loadMaterialesEntregados($filtros);
            $arraymaterials = [];
            foreach ($mati as $key => $c) {
               $arraymaterials[] = ["x"=> $c['material'], "y"=> 'Entregadas', "val"=>$c['entregadas']];
            }

			$report="TallerextracurricularMateriales";
			$filebase="$report-".(rand()%10000);
            $pdf=new LDPDF($this->container, $report, $filebase, ['driver'=>'json', 'data_file'=>$filebase, 'json_query'=>'""'], [], ['xlsx']);
            $data = array("prof" => $arrdatos, "ciclo" => $ciclo->getNombre(), "materials" => $arraymaterials);
			$this->fileWrite($pdf->fdb_r, json_encode($data));
            $result=$pdf->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/$filebase.xlsx";
            if (!$reporte) {
                return new View("No se ha podido procesar el reporte", Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte),
                200,
                array(
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
                    'Content-Length' => filesize($reporte)
                )
            );
			LDPDF::fileDelete($pdf->fdb_r);
			if(!$result){
				LDPDF::fileDelete($pdf->output_r);
            }
            return $response;
        }catch(Exception $e){ return new View($e->getMessage(), Response::HTTP_BAD_REQUEST); }
    }

    private function fileWrite($path, $data){
		$file=LDPDF::fileRead($path);
		LDPDF::fileWrite($file, $data);
		LDPDF::fileRelease($file);
		return true;
    }
    
    function InsertarPosicion($arr, $insertedArray, $position) {
        $i = 0;
        $new_array=[];
        foreach ($arr as $key => $value) {
            if ($i == $position) {
                foreach ($insertedArray as $ikey => $ivalue) {
                    $new_array[$ikey] = $ivalue;
                }
            }
            $new_array[$key] = $value;
            $i++;
        }
        return $new_array;
    }
}   