<?php

namespace AppBundle\Controller\Transporte;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmTransporte;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\TpContrato;
use AppBundle\Entity\TpAlumnoruta;
use AppBundle\Entity\TpAlumnomes;
use AppBundle\Entity\TpAlumnomesrutaprecio;
use AppBundle\Entity\CjDocumentoporpagar;
use AppBundle\Entity\TpAlumnoporcontrato;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
use AppBundle\Rest\Api;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier
 */
class ContratoController extends FOSRestController
{
	//private static $MONTHS=["","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
	private static $MONTHS=["","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC"];

    /**
     * Retorna arreglo de paises en base a los parametros enviados
     * @Rest\Get("/api/Transporte/Contrato", name="indexContrato")
     */
    public function indexContrato()
    {
        try {
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $ruta = $dbm->getRepositoriosById('TpRuta', 'activo', 1);
            $contratoestatus = $dbm->getRepositoriosById('TpContratoestatus', 'activo', 1);

            return new View(array("ciclo" => $ciclo, "nivel" => $nivel, "ruta" => $ruta, "contratoestatus" => $contratoestatus), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de paises en base a los parametros enviados
     * @Rest\Get("/api/Transporte/Contrato/", name="buscarContrato")
     */
    public function getContrato()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarContrato($filtros);
 
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

		
		public static function getContratodetalleSortAlumnos($a, $b){
			$aa=(int)$a["matricula"];
			$bb=(int)$b["matricula"];
			if($aa==$bb) return 0;
			return ($aa<$bb ? -1 : 1);
		}
	/**
	 * Retorna arreglo de familias en base a los parametros enviados
	 * @Rest\Get("/api/Transporte/Contrato/detalle", name="ContratoDetalle")
	 */
	public function getContratodetalle(){
		try{
			$datos=$_REQUEST;
			$padres=[];
			$alumnos=[];
			$kfamilia=$datos["familiaid"];
			$kcontrato=$datos["contratoid"];
			$dbm=new DbmTransporte($this->get("db_manager")->getEntityManager());
			$dbmce=new DbmControlescolar($this->get("db_manager")->getEntityManager());

			$rutas=$dbm->BuscarRuta(array("activo"=>true));
			$adeudo=$dbm->BuscarDeudaTransporte($kfamilia);
			$contrato=$dbm->getRepositorioById("TpContrato", "contratoid", $kcontrato);
			$clavefamiliar=$dbm->getRepositorioById("CeClavefamiliar", "clavefamiliarid", $kfamilia);
			$alumnoscf=$dbm->getRepositoriosById("CeAlumnoporclavefamiliar", "clavefamiliarid", $kfamilia);
			$padrescf=$dbm->getRepositoriosById("CePadresotutoresclavefamiliar", "clavefamiliarid", $kfamilia);
			$descuento=$dbm->getRepositoriosById("Parametros", "nombre", ["TransporteDescuento2Hijo", "TransporteDescuento3Hijo"]);
			$alumnoMes=$dbm->getRepositoriosModelo("TpAlumnomes", [
					"IDENTITY(d.contratoid) AS contratoid",
					"IDENTITY(d.alumnoid) AS alumnoid",
					"d.year",
					"d.month"
				], ["contratoid"=>$kcontrato]);
			$alumnoRuta=$dbm->getRepositoriosModelo("TpAlumnoruta", [
					"IDENTITY(d.contratoid) AS contratoid",
					"IDENTITY(d.alumnoid) AS alumnoid",
					"IDENTITY(d.rutaid) AS rutaid"
				], ["contratoid"=>$kcontrato]);
			$alumnoMRP=$dbm->getRepositoriosModelo("TpAlumnomesrutaprecio", [
					"IDENTITY(tpar.alumnoid) AS alumnoid",
					"IDENTITY(tpar.rutaid) AS rutaid",
					"IDENTITY(cjdp.gradoid) AS gradoid",
					"tpam.year",
					"tpam.month",
					"d.importe",
					"(cjdp.saldo - cjdp.descuento) as saldo",
					"cjdp.documentoporpagarid",
					"d.precioespecial"
					,"CASE WHEN cjdp.saldo!=cjdp.importe THEN 1 ELSE 0 AS locked"
				], ["contratoid"=>$kcontrato], false, false, [
					[
						"entidad"=>"TpAlumnomes",
						"alias"=>"tpam",
						"on"=>"tpam.alumnomesid=d.alumnomesid"
					],
					[
						"entidad"=>"TpAlumnoruta",
						"alias"=>"tpar",
						"on"=>"tpar.alumnorutaid=d.alumnorutaid"
					],
					[
						"entidad"=>"CjDocumentoporpagar",
						"alias"=>"cjdp",
						"on"=>"cjdp.documentoporpagarid=d.documentoporpagarid"
					]
				]);
			$familia=$clavefamiliar->getClave()." - ".$clavefamiliar->getApellidopaterno()." ".$clavefamiliar->getApellidomaterno();
			foreach($padrescf AS $ipadrecf){
				$itutor=$ipadrecf->getPadresotutoresid();
				$ktutor=$itutor->getPadresotutoresid();
				$padres[]=[
						"id"=>$ktutor,
						"padreotutorid"=>$ktutor,
						"nombre"=>$itutor->getApellidopaterno()." ".$itutor->getApellidoMaterno()." ".$itutor->getNombre()
					];
			}
			foreach($alumnoscf AS $ialumnocf){
				$ialumno=$ialumnocf->getAlumnoid();
				$iestatus=$ialumno->getAlumnoestatusid()->getAlumnoestatusid();
				if($iestatus==1){
					$alumnos[]=$dbmce->BuscarAlumnosA(["alumnoid"=>$ialumno->getAlumnoid()])[0];
				}
			}
			usort($alumnos, "AppBundle\Controller\Transporte\ContratoController::getContratodetalleSortAlumnos");
			foreach($alumnoMRP AS &$ialumnomrp){
				$ialumnomrp["alumnoid"]=(int)$ialumnomrp["alumnoid"];
				$ialumnomrp["gradoid"]=(int)$ialumnomrp["gradoid"];
				$ialumnomrp["rutaid"]=(int)$ialumnomrp["rutaid"];
				$ialumnomrp["locked"]=(int)$ialumnomrp["locked"];
				$ialumnomrp["saldo"]=(double)$ialumnomrp["saldo"];
				$ialumnomrp["importe"]=(double)$ialumnomrp["importe"];
				unset($ialumnomrp);
			}
			return Api::Ok("", [
					"familia"=>$familia,
					"padres"=>$padres,
					"alumnos"=>$alumnos,
					"rutas"=>$rutas,
					"descuento"=>$descuento,
					"contrato"=>$contrato,
					"alumnomrp"=>$alumnoMRP,
					"alumnomes"=>$alumnoMes,
					"alumnoruta"=>$alumnoRuta,
					"adeudo"=>$adeudo
				]);
		}catch(\Exception $e){
			return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
		}
	}
	/**
	 * @Rest\Post("/api/Transporte/Contrato" , name="GuardarContrato")
	 */
	public function SaveContrato(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);
			$dbm=new DbmTransporte($this->get("db_manager")->getEntityManager());
			$dbm->getConnection()->beginTransaction();
			$kciclo=(int)$data["cicloid"];
			$kclavefamiliar=$data["clavefamiliarid"];
			$contrato=$dbm->getOneByParametersRepositorio("TpContrato", ["clavefamiliarid"=>$kclavefamiliar, "cicloid"=>$kciclo]);
			if($data["contratoid"]) {
				if($contrato && $contrato->getContratoid()!=$data["contratoid"]){
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, "La familia seleccionada ya cuenta con un contrato en el ciclo seleccionado.");
				}
				$contrato = $dbm->getRepositorioById("TpContrato", "contratoid", $data["contratoid"]);
			} else {
				if($contrato){
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, "La familia seleccionada ya cuenta con un contrato en el ciclo seleccionado.");
				}
				$contrato=new TpContrato();
			}
			$hydrator=new ArrayHydrator($dbm->getEntityManager());
			$alumnoMRP=$data["alumno_mrp"];
			$alumnoMes=$data["alumno_mes"];
			$alumnoRuta=$data["alumno_ruta"];
			$alumnos=$data["alumnos"];
			$dbm->saveRepositorio($hydrator->hydrate($contrato, $data));
			$kcontrato=$contrato->getContratoid();

			$alumnosRutas=[];
			foreach($alumnoRuta AS $ialumnoruta){
				$ikruta=$ialumnoruta["rutaid"];
				$ikalumno=$ialumnoruta["alumnoid"];
				$ialumnorutar=$dbm->getOneByParametersRepositorio("TpAlumnoruta", [
						"contratoid"=>$kcontrato,
						"rutaid"=>$ikruta,
						"alumnoid"=>$ikalumno
					]);
				if(!$ialumnorutar){
					$ialumnorutar=new TpAlumnoruta();
					$ialumnorutar->setContratoid($contrato);
					$ialumnorutar->setRutaid($dbm->getRepositorioById("TpRuta", "rutaid", $ikruta));
					$ialumnorutar->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $ikalumno));
					$dbm->saveRepositorio($ialumnorutar);
				}
				$alumnosRutas[]=$ialumnorutar->getAlumnorutaid();
			}
			$alumnosRutaAll=$dbm->getRepositoriosById("TpAlumnoruta", "contratoid", $kcontrato);
			foreach($alumnosRutaAll AS $ialumnoruta){
				$inarray=array_search($ialumnoruta->getAlumnorutaid(), $alumnosRutas);
				if($inarray===false){
					$alumnomrp=$dbm->getRepositoriosById("TpAlumnomesrutaprecio", "alumnorutaid", $ialumnoruta);
					foreach($alumnomrp AS $ialumnomrp){
						$idocumentoxp=$ialumnomrp->getDocumentoporpagarid();
						if($idocumentoxp->getSaldo()!=$idocumentoxp->getImporte()){
							return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No puedes eliminar el alumno de la ruta porque ya tiene pagos parciales o totales.");
						}
						$dbm->removeRepositorio($ialumnomrp);
						$dbm->removeRepositorio($idocumentoxp);
					}
					$dbm->removeRepositorio($ialumnoruta);
				}
			}

			$alumnosMeses=[];
			foreach($alumnoMes AS $ialumnomes){
				$iyear=$ialumnomes["year"];
				$imonth=$ialumnomes["month"];
				$ikalumno=$ialumnomes["alumnoid"];
				$ialumnomesr=$dbm->getOneByParametersRepositorio("TpAlumnomes", [
						"contratoid"=>$kcontrato,
						"alumnoid"=>$ikalumno,
						"year"=>$iyear,
						"month"=>$imonth
					]);
				if(!$ialumnomesr){
					$ialumnomesr=new TpAlumnomes();
					$ialumnomesr->setContratoid($contrato);
					$ialumnomesr->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $ikalumno));
					$ialumnomesr->setYear($iyear);
					$ialumnomesr->setMonth($imonth);
					$dbm->saveRepositorio($ialumnomesr);
				}
				$alumnosMeses[]=$ialumnomesr->getAlumnomesid();
			}
			$alumnosMesAll=$dbm->getRepositoriosById("TpAlumnomes", "contratoid", $kcontrato);
			foreach($alumnosMesAll AS $ialumnomes){
				$inarray=array_search($ialumnomes->getAlumnomesid(), $alumnosMeses);
				if($inarray===false){
					$alumnomrp=$dbm->getRepositoriosById("TpAlumnomesrutaprecio", "alumnomesid", $ialumnomes);
					foreach($alumnomrp AS $ialumnomrp){
						$idocumentoxp=$ialumnomrp->getDocumentoporpagarid();
						if($idocumentoxp->getSaldo()!=$idocumentoxp->getImporte()){
							return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No puedes eliminar el alumno del mes porque ya tiene pagos parciales o totales.");
						}
						$dbm->removeRepositorio($ialumnomrp);
						$dbm->removeRepositorio($idocumentoxp);
					}
					$dbm->removeRepositorio($ialumnomes);
				}
			}


			$alumnosMRP=[];
			foreach($alumnoMRP AS $ialumnomrp){
				$ikalumno=$ialumnomrp["alumnoid"];
				$ikgrado=$ialumnomrp["gradoid"];
				$ikruta=$ialumnomrp["rutaid"];
				$iyear=$ialumnomrp["year"];
				$imonth=$ialumnomrp["month"];
				$iimporte=$ialumnomrp["importe"];
				$iprecioespecial=$ialumnomrp["precioespecial"];
				$ialumnomrpr=$dbm->GetCAlumnoMRPEntity($kcontrato, $ikalumno, $ikruta, $iyear, $imonth);
				if(!$ialumnomrpr){
					$ialumnomrpr=new TpAlumnomesrutaprecio();
					$ialumnomrpr->setContratoid($contrato);
					$ialumnoruta=$dbm->getOneByParametersRepositorio("TpAlumnoruta", [
							"contratoid"=>$kcontrato,
							"alumnoid"=>$ikalumno,
							"rutaid"=>$ikruta
						]);
					$ialumnomes=$dbm->getOneByParametersRepositorio("TpAlumnomes", [
							"contratoid"=>$kcontrato,
							"alumnoid"=>$ikalumno,
							"year"=>$iyear,
							"month"=>$imonth
						]);

					$ialumnomrpr->setAlumnomesid($ialumnomes);
					$ialumnomrpr->setAlumnorutaid($ialumnoruta);
					$iruta=$dbm->getRepositorioById("TpRuta", "rutaid", $ikruta);
					$subconcepto=$iruta->getSubconceptoid();
					$monthDateTime=new \DateTime("$iyear-$imonth-01");
					$monthTimestamp=$monthDateTime->getTimestamp();
					$documento=[
							"documentoid"=>17,
							"pagoestatusid"=>1,
							"alumnoid"=>$ikalumno,
							"gradoid"=>$ikgrado,
							"cicloid"=>$kciclo,
							"subconceptoid"=>$subconcepto->getSubconceptoid(),
							"saldo"=>$iimporte,
							"importe"=>$iimporte,
							"concepto"=>"TRANSPORTE ".self::$MONTHS[$imonth]."-$iyear ".$subconcepto->getNombre(),
							"fechacreacion"=>new \DateTime(),
							"fechalimitepago"=>new \DateTime(date("Y-m-t",$monthTimestamp)),
							"fechaprontopago"=>new \DateTime(date("Y-m-10",$monthTimestamp))
						];
					$idocumentoxp=$hydrator->hydrate(new CjDocumentoporpagar(), $documento);
					$dbm->saveRepositorio($idocumentoxp);
					$ialumnomrpr->setDocumentoporpagarid($idocumentoxp);
				}
				$idocumentoxp=$ialumnomrpr->getDocumentoporpagarid();
				$iimporteold=$idocumentoxp->getImporte();
				if($iimporteold!=$iimporte){
					if($iimporteold!=$idocumentoxp->getSaldo()){
						return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No puedes modificar el importe porque ya tiene pagos parciales o totales.");
					}
					$idocumentoxp->setImporte($iimporte);
					$idocumentoxp->setSaldo($iimporte);
					$dbm->saveRepositorio($idocumentoxp);
				}
				$ialumnomrpr->setImporte($iimporte);
				$ialumnomrpr->setPrecioespecial($iprecioespecial);
				$dbm->saveRepositorio($ialumnomrpr);

				$alumnosMRP[]=$ialumnomrpr->getAlumnomesrutaprecioid();
			}
			$alumnosMRPAll=$dbm->GetCAlumnoMRPSEntityByContrato($kcontrato);
			foreach($alumnosMRPAll AS $ialumnomrp){
				$inarray=array_search($ialumnomrp->getAlumnomesrutaprecioid(), $alumnosMRP);
				if($inarray===false){
					$idocumentoxp=$ialumnomrp->getDocumentoporpagarid();
					if($idocumentoxp->getSaldo()!=$idocumentoxp->getImporte()){
						return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No puedes eliminar el alumno del mes y ruta porque ya tiene pagos parciales o totales.");
					}
					$dbm->removeRepositorio($ialumnomrp);
					$dbm->removeRepositorio($idocumentoxp);
				}
			}

			$arrayalumnocontratos = [];
			foreach($alumnos AS $alumno){
				$alumnocontrato=$dbm->getOneByParametersRepositorio("TpAlumnoporcontrato", [
					"contratoid"=>$kcontrato,
					"alumnoid"=>$alumno
				]);
				if(!$alumnocontrato) {
					$alumnocontrato = new TpAlumnoporcontrato();
					$alumnocontrato->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $alumno));
					$alumnocontrato->setContratoid($contrato);
					$alumnocontrato->setContratoestatusid($dbm->getRepositorioById("TpContratoestatus", "contratoestatusid", 1));
					$dbm->saveRepositorio($alumnocontrato);
				}
				$arrayalumnocontratos[]=$alumnocontrato->getAlumnoporcontratoid();
			}

			$alumnosContratoAll=$dbm->getRepositoriosById("TpAlumnoporcontrato", "contratoid", $kcontrato);
			foreach($alumnosContratoAll AS $ialumnocontrato){
				$inarray=array_search($ialumnocontrato->getAlumnoporcontratoid(), $arrayalumnocontratos);
				if($inarray===false){
					$dbm->removeRepositorio($ialumnocontrato);
				}
			}

			$dbm->getConnection()->commit();
			return new View(array("msj"=>"Se ha guardado el registro", "contratoid"=>$contrato->getContratoid()), Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
	
	
		/**
     * @Rest\Put("/api/Transporte/Contrato/Estatus/" , name="ActualizarContrato")
     */
    public function updateContrato()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            foreach ($data["alumnos"] as $c) {
                $contrato = $dbm->getRepositorioById('TpAlumnoporcontrato', 'alumnoporcontratoid', $c);
                $contrato = $hydrator->hydrate($contrato, $data);
                $dbm->saveRepositorio($contrato);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
	 * Retorna el archivo word del formato
	 * @Rest\Post("/api/Transporte/Contrato/Credencial", name="DescargarCredencial")
	 */
	public function downloadCredencial(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);
			$dbm=new DbmTransporte($this->get("db_manager")->getEntityManager());

			$tpalumnorutas=[];
			foreach($data as $c){
				$kialumno=$c["alumnoid"];
				$kicontrato=$c["contratoid"];
				$ialumnoruta=$dbm->getOneByParametersRepositorio("TpAlumnoruta", ["alumnoid"=>$kialumno, "contratoid"=>$kicontrato]);
				$usuario=$dbm->getRepositorioById('Usuario', 'alumnoid', $c["alumnoid"]);
				if(!$usuario){
					return new View("Falta la relacion al usuario", Response::HTTP_PARTIAL_CONTENT);
				}
				$tpalumnorutas[]=$ialumnoruta->getAlumnorutaid();
			}

			$path=str_replace('app', '', $this->get('kernel')->getRootDir());
			$path=$path."src/AppBundle/Dominio/Reporteador/Plantillas/";

			switch(ENTORNO){
				case 1:
					$logo=$path."Lux/transportecredencial.png";
					$plantilla="'".$path."Lux/Transporte_Credencial_Lux.jrxml'";
					break;
				case 2:
					$logo=$path."Ciencias/transportecredencial.png";
					$plantilla="'".$path."Ciencias/Transporte_Credencial_Ciencias.jrxml'";
					break;
			}

			$jasper=new JasperPHP($this->container);
			$respuesta=$jasper->process(
					$plantilla,
					"'{$path}Credenciales'",
					["pdf"],
					["alumnorutaids"=>implode(",", $tpalumnorutas), "logo"=>$logo],
					true
				)->execute();

			$reporte="../src/AppBundle/Dominio/Reporteador/Plantillas/Credenciales.pdf";
			if($respuesta){
				return new View($respuesta, Response::HTTP_PARTIAL_CONTENT);
			}

			$response=new \Symfony\Component\HttpFoundation\Response(
				file_get_contents($reporte), 200, array(
					'Content-Type'=>'application/pdf',
					'Content-Length'=>filesize($reporte)
				)
			);
			return $response;
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
	
	
	
	/**
	 * @Rest\Get("/api/Transporte/Contrato/Migrar/{execute}" , name="MigrarContratos")
	 */
	public function MigrarContratos($execute){
		$forReal=$execute==253;
		$dbm=new DbmTransporte($this->get("db_manager")->getEntityManager());
		$contratos=$dbm->getRepositoriosModelo("TpContrato",["d"]);
		foreach($contratos AS $icontrato){
			$iciclo=$icontrato->getCicloid();
			$kcontrato=$icontrato->getContratoid();
			$rutasc=$dbm->getRepositoriosById("TpRutaporcontrato","contratoid",$icontrato);
			$alumnosc=$dbm->getRepositoriosById("TpAlumnoporcontrato","contratoid",$icontrato);
			foreach($alumnosc AS $ialumnoc){
				if($ialumnoc->getContratoestatusid()->getContratoestatusid()==1){
					$atLeastOne=false;
					$ialumno=$ialumnoc->getAlumnoid();
					$kalumno=$ialumno->getAlumnoid();
					if($forReal){ $dbm->getConnection()->beginTransaction(); }
					else{ echo PHP_EOL.PHP_EOL.PHP_EOL."Alumno: ".$ialumno->getAlumnoid().PHP_EOL; }
					foreach($rutasc AS $irutac){
						$iruta=$irutac->getRutaid();
						$kruta=$iruta->getRutaid();

						$ialumnoruta=new TpAlumnoruta();
						$ialumnoruta->setContratoid($icontrato);
						$ialumnoruta->setAlumnoid($ialumno);
						$ialumnoruta->setRutaid($iruta);
						if($forReal){ $dbm->saveRepositorio($ialumnoruta); }
						//else{ echo "AlumnoRuta: $kruta".PHP_EOL; }

						$documentosxp=$dbm->getByParametersRepositorios("CjDocumentoporpagar", [
								//"cicloid"=>$iciclo,
								"alumnoid"=>$ialumno,
								"subconceptoid"=>$iruta->getSubconceptoid()
							]);
						if(!$forReal){ echo "DocumentosXP: C(".$iciclo->getCicloid().") A(".$ialumno->getAlumnoid().") S(".$iruta->getSubconceptoid()->getSubconceptoid().")".PHP_EOL; }
						foreach($documentosxp AS $idocumentoxp){
							$iimporte=$idocumentoxp->getImporte();
							$ifechalimite=$idocumentoxp->getFechalimitepago();
							$iyear=$ifechalimite->format("Y");
							$imonth=$ifechalimite->format("m");

							$ialumnomes=new TpAlumnomes();
							$ialumnomes->setContratoid($icontrato);
							$ialumnomes->setAlumnoid($ialumno);
							$ialumnomes->setYear($iyear);
							$ialumnomes->setMonth($imonth);
							if($forReal){ $dbm->saveRepositorio($ialumnomes); }
							//else{ echo "AlumnoMes: Y($iyear) M($imonth)".PHP_EOL; }

							$ialumnomrp=new TpAlumnomesrutaprecio();
							$ialumnomrp->setContratoid($icontrato);
							$ialumnomrp->setAlumnomesid($ialumnomes);
							$ialumnomrp->setAlumnorutaid($ialumnoruta);
							$ialumnomrp->setDocumentoporpagarid($idocumentoxp);
							$ialumnomrp->setImporte($iimporte);
							$ialumnomrp->setPrecioespecial(false);
							$atLeastOne=true;
							if($forReal){ $dbm->saveRepositorio($ialumnomrp); }
							else{ echo "AlumnoMesRutaPrecio: A($kalumno) C($kcontrato) R($kruta) Y($iyear) M($imonth)".PHP_EOL; }
						}
					}
					if($forReal){
						if($atLeastOne){
							$dbm->removeRepositorio($ialumnoc);
							$dbm->getConnection()->commit();
						}else{
							$dbm->getConnection()->rollBack();
						}
					}else if(!$atLeastOne){
						echo "<<ERROR>>: A($kalumno) C($kcontrato)".PHP_EOL;
					}
				}
			}
		}
		return Api::Ok("---- END ----");
	}
}