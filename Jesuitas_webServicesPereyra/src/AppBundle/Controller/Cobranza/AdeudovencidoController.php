<?php

namespace AppBundle\Controller\Cobranza;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmCobranza;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;

/**
 * Auto: David
 */
class AdeudovencidoController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cobranza/Adeudosvencido/filtros", name="indexAdeudo")
     */
    public function indexAdeudo()
    {
        try {

            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $cicloactual = $dbm->getRepositorioById("Ciclo", "actual", 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $grupo = $dbm->getRepositoriosModelo("CeGrupo", ["d.grupoid AS id", "d.grupoid", "IDENTITY(d.cicloid) AS cicloid", "IDENTITY(d.gradoid) AS gradoid", "d.nombre"], ["tipogrupoid" => 1, "cicloid" => $cicloactual->getCicloid()]);
            $estatus = $dbm->getRepositoriosById('CeAlumnoestatus', 'activo', 1);
            $tipodocumento = $dbm->getRepositorios('CjTipodocumento');
            $concepto = $dbm->getRepositoriosById('CjConcepto', 'activo', 1);
            $subconcepto = $dbm->getRepositoriosById('CjSubconcepto', 'activo', 1);

            $array = array("nivel" => $nivel, 
            "grado" => $grado, 
            "grupo" => $grupo, 
            "tipodocumento" => $tipodocumento,
            "concepto" => $concepto,
            "subconcepto" => $subconcepto,
            "estatus" => $estatus);
            return new View($array, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Cobranza/Adeudosvencido/", name="BuscarAdeudoVencido")
     */
    public function BuscarAdeudoVencido()
    {
        try {

            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $adeudos = $dbm->BuscarAdeudosvencidos($filtros);
            if(!$adeudos) {
                return new View("No se encontro ningun registro", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($adeudos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
	/**
	 * 
	 * @Rest\Post("/api/Cobranza/Adeudosvencido/reporte/", name="BuscarAdeudosVencidosDetalle")
	 */
	public function BuscarAdeudosVencidosDetalle(){
		try{
			$filtros=array_filter(json_decode(trim(file_get_contents("php://input")),true));
			$dbm=new DbmCobranza($this->get("db_manager")->getEntityManager());
			$adeudos=$dbm->BuscarAdeudosVencidosDetalle($filtros);
			if(!$adeudos){
				return new View("No se encontro ningun registro", Response::HTTP_PARTIAL_CONTENT);
			}
			$dataraw=[];
			foreach($adeudos AS $iadeudo){
				$inivel=$iadeudo['nivel'];
				$igrado=$iadeudo['grado'];
				$igrupo=$iadeudo['grupo'];
				$ialumnoid=$iadeudo['alumnoid'];
				$imatricula=$iadeudo['matricula'];
				$ialumno=$iadeudo['nombrecompleto'];
				$iconcepto=$iadeudo['concepto'];
				$iimporte=(double)$iadeudo['importe'];
				$irecargos=(double)$iadeudo['recargos'];
				$ipagos=(double)$iadeudo['pagos'];
				$isaldo=(double)$iadeudo['saldo'];
				if($isaldo<0){
					$isaldo=0.0;
				}
				$keygrupo="$igrado-$igrupo";
				if(!isset($dataraw[$inivel])){ $dataraw[$inivel]=[]; }
				if(!isset($dataraw[$inivel][$keygrupo])){ $dataraw[$inivel][$keygrupo]=[]; }
				if(!isset($dataraw[$inivel][$keygrupo][$ialumnoid])){
					$dataraw[$inivel][$keygrupo][$ialumnoid]=[
							"matricula"=>$imatricula,
							"alumno"=>$ialumno,
							"conceptos"=>[]
					];
				}
				$dataraw[$inivel][$keygrupo][$ialumnoid]["conceptos"][]=[
						"nombre"=>$iconcepto,
						"importe"=>$iimporte,
						"recargo"=>$irecargos,
						"pago"=>$ipagos,
						"saldo"=>$isaldo
				];
			}
			$data=[];
			foreach($dataraw AS $knivel=>$igrupos){
				$iniveldata=["nivel"=>$knivel,"grupos"=>[]];
				foreach($igrupos AS $keygrupo=>$ialumnosraw){
					$ialumnos=[];
					foreach($ialumnosraw AS $ialumno){
						$ialumnos[]=$ialumno;
					}
					$iniveldata["grupos"][]=["grupo"=>$keygrupo,"alumnos"=>$ialumnos];
				}
				$data[]=$iniveldata;
			}

			$report="AdeudosVencidosDetalle";
			$filebase="$report-".(rand()%10000);
			$pdf=new LDPDF($this->container, $report, $filebase, ['driver'=>'json', 'data_file'=>$filebase, 'json_query'=>'""']);
			$this->fileWrite($pdf->fdb_r, json_encode($data));
			$result=$pdf->execute();
			LDPDF::fileDelete($pdf->fdb_r);
			if(!$result){
				$content=file_get_contents($pdf->output_r);
				$size=filesize($pdf->output_r);
				LDPDF::fileDelete($pdf->output_r);
				return new Response($content, 200, array(
					'Content-Type'=>'application/pdf',
					'Content-Length'=>$size
				));
			}
			return Api::Error(Response::HTTP_BAD_REQUEST, false);
		}catch(\Exception $e){
			return Api::Error(Response::HTTP_INTERNAL_ERROR, $e->getMessage());
		}
	}
	
	private function fileWrite($path, $data){
		$file=LDPDF::fileRead($path);
		LDPDF::fileWrite($file, $data);
		LDPDF::fileRelease($file);
		return true;
	}
}