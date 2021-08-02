<?php
namespace AppBundle\Controller\Controlescolar;

use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\DB\DbmReinscripcion;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\Correo;
use AppBundle\Entity\RiReinscripciondocumento;
use AppBundle\Entity\RiReinscripcion;
use AppBundle\Entity\RiDocumentoresponsable;


class ReinscripcionController extends FOSRestController{
	private $DBM=false;
	//--------------- David -------------------
	/**
	 * Retorna catalogo tipos de baja
	 * @Annotations\Get("/api/Controlescolar/Reinscripcion/Alumnosbypadretutor/{id}", name="Alumnosbypadretutor")
	 */
	public function Alumnosbypadretutor($id){
		try{
			$datos=$_REQUEST;
            $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositorioById('Ciclo', 'siguiente', 1);
			$ciclo_actual = $dbm->getRepositorioById('Ciclo', 'actual', 1);
			$alumnos = $dbm->BuscarAlumnosReinscripcion($id);


			$clavefamiliar = $dbm->getRepositorioById('CePadresotutoresclavefamiliar', 'padresotutoresid', $id);			
			$padresotutores  = $dbm->getRepositoriosById('CePadresotutoresclavefamiliar', 'clavefamiliarid', $clavefamiliar->getClavefamiliarid());
			$tutores = $dbm->getRepositorios('Tutor');				

			$dbm->getConnection()->beginTransaction();	
			$estado = $dbm->getRepositoriosById('Estado', 'paisid', 484, 'nombre');	
			
            foreach($alumnos as $key=>$a) {
				$alumnos[$key]['domicilio'] = $dbm->getRepositorioById('CeAlumnodomicilio', 'alumnoid', $a['alumnoid']);
				if(ENTORNO == 2){
					$reinscripcion = $dbm->getRepositorioById('RiReinscripcion', 'reinscripcionid', $a['reinscripcionid']);
					$alumnos[$key]['documentoresponsable'] = $dbm->getRepositoriosById('RiDocumentoresponsable', 'reinscripcionid', $reinscripcion);
					$alumnos[$key]['ciclo_actual'] = $ciclo_actual;
				}

                if($a['estatusreinscripcion'] == "1") {					
                    $reinscripcionalumno = new RiReinscripcion();
                    $reinscripcionalumno->setCicloid($ciclo);
                    $reinscripcionalumno->setAlumnoid($dbm->getRepositorioById('CeAlumno', 'alumnoid', $a['alumnoid']));
                    $reinscripcionalumno->setReinscripcionestatusid($dbm->getRepositorioById('RiReinscripcionestatus', 'reinscripcionestatusid', 1));
					$dbm->saveRepositorio($reinscripcionalumno);
					$alumnos[$key]['ciclo'] = $reinscripcionalumno->getCicloid()->getNombre();					
                    $alumnos[$key]['reinscripcionestatusid'] = $reinscripcionalumno->getReinscripcionestatusid()->getReinscripcionestatusid();
					$alumnos[$key]['reinscripcionestatus'] = $reinscripcionalumno->getReinscripcionestatusid()->getNombre();
					$alumnos[$key]['reinscripcionid'] = $reinscripcionalumno->getReinscripcionid();
				}
				$alumnos[$key]['documentossubidos'] = $dbm->BuscarDocumentosAlumnoReinscripcion($alumnos[$key]['reinscripcionid']);
            }
            $dbm->getConnection()->commit();
			
			if (ENTORNO == 2){
				$response = array(
					'alumnos' => $alumnos,
					'tutores' => $tutores,
					'padresotutores' => $padresotutores,
					'estados' => $estado
				);
			}else{
				$response = $alumnos;
			}

			return new View($response, Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
	/**
	 * Retorna el archivo del formato
	 * @Annotations\Get("/api/Controlescolar/Reinscripcion/Documentoalumno/descargar/{id}", name="DescargarFormatoReinscripcion")
	 */
	public function DescargarFormatoReinscripcion($id){
		try{
			$dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$Formato=$dbm->getRepositorioById('RiDocumento', 'documentoid', $id);

            $temp = tmpfile();
            fwrite($temp, stream_get_contents($Formato->getDocumento()));
            $path = stream_get_meta_data($temp)['uri'];

			$data = $_REQUEST;
			$dbmr = new DbmReinscripcion($this->get("db_manager")->getEntityManager());	
			$vista_reinscripcion = '';

			if (ENTORNO == 2){				
				$vista_reinscripcion = $dbmr->BuscarVistaReinscripcion($data["reinscripcionid"]);
			}
			else{
				$vista_reinscripcion = array("dummy" => 1);
			}

            $parametros = $dbm->getRepositorioById("Parametros", "nombre", "UrlTokens");
            $urltokens = $parametros->getValor();
            //$urltokens="http://192.168.0.13:8015/api/archivotokens";
            $documento = \AppBundle\Dominio\Formato::remplazarToken($vista_reinscripcion, $path, $urltokens);
            fclose($temp);

            if (empty($documento["formato"])) {
                return new View("Hay un error con el archivo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
				$response = new \Symfony\Component\HttpFoundation\Response(
					$documento["formato"],
					200,
					array(
						'Content-Type' => 'application/pdf',
						'Content-Length' => $documento["tamano"]
					)
				);
                return $response;
            }
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

	/**
	 * 
	 * @Annotations\Get("/api/Controlescolar/Reinscripcion/Documentossubidos/descargar/{id}", name="DescargarDocumentoSubido")
	 */
	public function DescargarDocumentoSubido($id){
		try{
			$dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$Formato=$dbm->getRepositorioById('RiReinscripciondocumento', 'reinscripciondocumentoid', $id);
			$response=new \Symfony\Component\HttpFoundation\Response(
					stream_get_contents($Formato->getDocumento()), 200, array(
						'Content-Type'=>$Formato->getExtension(),
						'Content-Length'=>$Formato->getTamano()
					)
			);
			return $response;
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
	/**
	 *
	 * @Annotations\Post("/api/Controlescolar/Reinscripcion/AlumnoPago/", name="Formapagobyalumno")
	 */
	public function Formapagobyalumno(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);		
            $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());

			/* 
		       Autor: David Medina davidmq.skip@gmail.com
			   Fecha: 12/04/2021			
			   Tipo: Modificación
			   Descripción: Se modifica para la funcionalidad de guardar responsables de contrato.
			                No se pone variable de entorno pq nunca la mandaria en un entorno diferente a Ciencias
			*/

			if(!$data['soloResponsables']){
					$dbm->getConnection()->beginTransaction();
					$reinscripcion = $dbm->getRepositorioById('RiReinscripcion', 'reinscripcionid', $data['reinscripcionid']);
					if(!$reinscripcion) {
						return new View("No se ha encontrado una reinscripción relacionada al alumno", Response::HTTP_PARTIAL_CONTENT);
					}
					$reinscripcion->setCorreo($data['correo']);
					$reinscripcion->setTramitobeca($data['tramitobeca']);
					$reinscripcion->setTelefono($data['telefono']);
					$reinscripcion->setPagocolegiaturas($data['pagocolegiaturas']);
		
					$reinscripcion->setTipopagocolegiaturaid($data['tipopagocolegiaturas'] ? 
					$dbm->getRepositorioById('RiTipopagocolegiatura', 'tipopagocolegiaturaid', $data['tipopagocolegiaturas']) : null);
		
					$reinscripcion->setFormapagocolegiaturaid($dbm->getRepositorioById('RiFormapagocolegiatura', 
						'formapagocolegiaturaid', $data['formapagocolegiaturaid']));
					
					if($data['formapagocolegiaturaid'] != 3) {
						$reinscripcion->setFormapagocolegiaturaanticipadaid(null);
					} else {
		
						$reinscripcion->setFormapagocolegiaturaanticipadaid($data['formapagocolegiaturaanticipadaid'] ?
						$dbm->getRepositorioById('RiFormapagocolegiaturaanticipada', 
						'formapagocolegiaturaanticipadaid', $data['formapagocolegiaturaanticipadaid']) : null);
					}
		
					$reinscripcion->setFormapagoinscripcionyfoid($dbm->getRepositorioById('RiFormapagoinscripcionyfo', 
						'formapagoinscripcionyfoid', $data['formapagoinscripcion']));
		
					$dbm->saveRepositorio($reinscripcion);
					$dbm->getConnection()->commit();
				}		
				

				/* 
				Autor: David Medina davidmq.skip@gmail.com
				Fecha: 13/04/2021			
				Tipo: Nuevo código
				Descripción: Se modifica para la funcionalidad de guardar responsables de contrato para Ciencias.
				*/

				if (ENTORNO == 2){
					$reinscripcion = $dbm->getRepositorioById('RiReinscripcion', 'reinscripcionid', $data['reinscripcionid']);
					foreach($data['info'] AS &$responsables){
						$responsablecontrato = $dbm->getRepositorioById('RiDocumentoresponsable', 'responsablecontratoid', $responsables['responsableid']);
						if (empty($responsablecontrato)){
							$responsablecontrato = new RiDocumentoresponsable();
						}
						$responsablecontrato->setNombre($responsables['nombre']);
						$responsablecontrato->setApellidopaterno($responsables['ap']);
						$responsablecontrato->setApellidomaterno($responsables['am']);
						$Tutor = $dbm->getRepositorioById('Tutor', 'tutorid', $responsables['parentesco']);
						$responsablecontrato->setTutorid($Tutor);
						$Documento = $dbm->getRepositorioById('RiDocumento', 'documentoid', $responsables['documentoid']);
						$responsablecontrato->setReinscripcionid($reinscripcion);
						$responsablecontrato->setDocumentoid($Documento);
						if ($responsables['documentoid'] == 2){
							$responsablecontrato->setCp($responsables['cp']);
							$Estado = $dbm->getRepositorioById('Estado', 'estadoid', $responsables['estadoid']);
							$responsablecontrato->setEstadoid($Estado);
							$Municipio = $dbm->getRepositorioById('Municipio', 'municipioid', $responsables['municipioid']);
							$responsablecontrato->setMunicipioid($Municipio);
							$responsablecontrato->setColonia($responsables['colonia']);
							$responsablecontrato->setCalle($responsables['calle']);
							$responsablecontrato->setNumeroext($responsables['numex']);
							$responsablecontrato->setNumeroint($responsables['numint']);
							$responsablecontrato->setTelefono($responsables['telefono']);						
							$responsablecontrato->setCelular($responsables['celular']);
							$responsablecontrato->setOcupacion($responsables['ocupacion']);		
							$Tutor = $dbm->getRepositorioById('Tutor', 'tutorid', $responsables['parentesco']);
							$responsablecontrato->setTutorid($Tutor);
							$responsablecontrato->setEdad($responsables['edad']);
							$Documento = $dbm->getRepositorioById('RiDocumento', 'documentoid', $responsables['documentoid']);
							$responsablecontrato->setDocumentoid($Documento);
						}
						$dbm->saveRepositorio($responsablecontrato);
					}
				}

			return new View("Se ha guardado el registro", Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

	/**
     * Elimina un registro
     * @Annotations\Delete("/api/Controlescolar/Reinscripcion/Documentossubidos/eliminar/{id}", name="deleteDocumentoAlumno")
     */
    public function deleteDocumentoAlumno($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
			$doc = $dbm->getRepositorioById('RiReinscripciondocumento', 'reinscripciondocumentoid', $id);
			$dbm->removeRepositorio($doc);			
			$dbm->getConnection()->commit();
			$documentos = $dbm->BuscarDocumentosAlumnoReinscripcion($doc->getReinscripcionid()->getReinscripcionid());
            return new View(array("documentos"=>$documentos,"mensaje"=>"Se ha eliminado el registro"), Response::HTTP_OK);
        } catch (\Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


		/**
	 *
	 * @Annotations\Post("/api/Controlescolar/Reinscripcion/GuardarDocumentos/", name="GuardarDocumentosReinscripcion")
	 */
	public function GuardarDocumentosReinscripcion(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);
            $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$dbm->getConnection()->beginTransaction();
			$size = $dbm->getRepositorioById('Parametros', 'nombre', 'Tamano archivo maximo');


			if($data['finalizado'] == "true") {
				$reinscripcion = $dbm->getRepositorioById('RiReinscripcion', 'reinscripcionid', $data['reinscripcionid']);
				$reinscripcion->setReinscripcionestatusid($dbm->getRepositorioById('RiReinscripcionestatus', 
					'reinscripcionestatusid', 2));
				$reinscripcion->setFecha(new \DateTime());
				setlocale(LC_ALL, 'es_MX');
				$fecha = strftime("%d-%h-%Y %H:%M",strtotime(date("d-m-Y H:i")));
				$oldObs=$reinscripcion->getObservaciones();
				$observacion=$fecha. " : " .  "Documentación entregada ".(!empty($oldObs) ? "\n$oldObs" : "");
				$reinscripcion->setObservaciones($observacion);
				$dbm->saveRepositorio($reinscripcion);	
				

			}
			$documentos = $dbm->BuscarDocumentosAlumnoReinscripcion($data['reinscripcionid']);
            $dbm->getConnection()->commit();
			return new View(array("mensaje"=>"Se ha guardado el registro", "documentos"=> $documentos), Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

	/**
	 *
	 * @Annotations\Post("/api/Controlescolar/Reinscripcion/GuardarDocumentoReinscripcion/", name="GuardarDocumentoReinscripcion")
	 */
	public function GuardarDocumentoReinscripcion(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);
            $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$dbm->getConnection()->beginTransaction();
			$ruta=$dbm->getRepositorioById("Parametros", "nombre", 'NombreCarpetaArchivosReinscripcion')->getValor();

			if($data) {

				if($data['size'] > 50000000) {
					return new View("El archivo " . $data['filename'] . " excede el tamaño máximo permitido de " . $size->getValor(), Response::HTTP_PARTIAL_CONTENT);
				}
				$reinscripciondoc = new RiReinscripciondocumento();
				$reinscripciondoc->setReinscripcionid($dbm->getRepositorioById('RiReinscripcion', 'reinscripcionid', $data['reinscripcionid']));
				$reinscripciondoc->setDocumentoid($dbm->getRepositorioById('RiDocumento', 'documentoid', $data['documentoid']));
				$reinscripciondoc->setUrl($ruta . $data['ciclo'] .'/');
				$reinscripciondoc->setNombre($data['nombrearchivo']);
				$reinscripciondoc->setExtension($data['filetype']);
				$dbm->saveRepositorio($reinscripciondoc);
			}

            $dbm->getConnection()->commit();
			return new View('Se ha guardado el registro', Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

	//--------------- David -------------------
	/**
     * Elimina un registro
     * @Annotations\Get("/api/Controlescolar/Reinscripcion/profesor/{id}", name="buscarProfesorreinscripcion")
     */
    public function buscarProfesorreinscripcion($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$profesor = $dbm->BuscarNominaByUsuario($id);
			if(!$profesor) {
				return new View("No se ha encontrado un profesor con ese número de nomina", Response::HTTP_PARTIAL_CONTENT);
			}
            return new View($profesor[0], Response::HTTP_OK);
        } catch (\Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


	//--------------- Emmanuel -------------------

	/**
	 * @Annotations\Get("/api/Controlescolar/Reinscripcion/filter", name="getReinscripcionFiltros")
	 */
	public function getReinscripcionFiltros(){
		$dbm=$this->getDM();
		$nivel=$dbm->getBasicNivel();
		$semestre=$dbm->getBasicSemestre();
		$grado=$dbm->getBasicGrado();
		$ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);

		//Parametros de configuracion del S3
		$ruta=$dbm->getRepositorioById("Parametros", "nombre", 'NombreCarpetaArchivosReinscripcion')->getValor();
		$bucket=$dbm->getRepositorioById("Parametros", "nombre", 'S3Bucket')->getValor();
		$secretaccesskey=$dbm->getRepositorioById("Parametros", "nombre", 'S3secretAccessKey')->getValor();
		$accesskeyid=$dbm->getRepositorioById("Parametros", "nombre", 'S3accessKeyId')->getValor();
		$region=$dbm->getRepositorioById("Parametros", "nombre", 'S3region')->getValor();

		$S3 = ['bucket' => $bucket, "ruta" => $ruta, "sacceskey" => $secretaccesskey, "accessid" => $accesskeyid, "region" => $region];

		if($nivel!==false && $grado!==false && $semestre!==false){
			$data=$this->getReinscripcionOpcionesProcess();
			$data["nivel"]=$nivel;
			$data["grado"]=$grado;
			$data["semestre"]=$semestre;
			$data["ciclo"]=$ciclo;
			$data["s3"]=$S3;
			return Api::Ok(Response::HTTP_OK, $data);
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	
	/**
	 * @Annotations\Get("/api/Controlescolar/Reinscripcion/Lista", name="getReinscripcionLista")
	 */
	public function getReinscripcionLista(){
		$data=$this->getDM()->GetReinscripcionLista($_REQUEST);
		foreach($data AS $key=>&$idata){			
			$idata["observacioneshtml"]=str_replace("\n", "<br>", $idata["observaciones"]);
			unset($idata);
		}

		return Api::Ok(Response::HTTP_OK, $data);
	}
	
	/** 
	 * @Annotations\Get("/api/Controlescolar/Reinscripcion/Detalle/{kreinscripcion}", name="getReinscripcionDetalle")
	 */
	public function getReinscripcionDetalle($kreinscripcion){
		$previewable=[
				"application/pdf"=>true,
				"image/bmp"=>true,
				"image/gif"=>true,
				"image/png"=>true,
				"image/jpeg"=>true
		];
		$documentos=$this->getDM()->getRepositoriosModelo("RiReinscripciondocumento",[
			"d.reinscripciondocumentoid AS id",
			"d.reinscripciondocumentoid",
			"rd.documentoid",
			"d.nombre",
			"d.extension",
			"concat(d.url, c.nombre,'_',a.matricula,'_',d.nombre) as urldocumento"
		],
		["reinscripcionid"=>$kreinscripcion],
		false,
		false,
		[
			[
				"entidad"=>"RiDocumento",
				"alias"=>"rd",
				"on"=>"rd.documentoid=d.documentoid"
			],
			[
				"entidad"=>"RiReinscripcion",
				"alias"=>"res",
				"on"=>"res.reinscripcionid = d.reinscripcionid"
			],
			[
				"entidad"=>"Ciclo",
				"alias"=>"c",
				"on"=>"res.cicloid = c.cicloid"
			],
			[
				"entidad"=>"CeAlumno",
				"alias"=>"a",
				"on"=>"res.alumnoid = a.alumnoid"
			]
		]);
		foreach($documentos AS &$idocumento){
			$idocumento["previewable"]=isset($previewable[$idocumento['extension']]);
			unset($idocumento);
		}
		return Api::Ok(Response::HTTP_OK, [
				"documentos"=>$documentos
		]);
	}
	
	/**
	 * @Annotations\Put("/api/Controlescolar/Reinscripcion/Detalle/{kreinscripcion}", name="updateReinscripcionDetalle")
	 */
	public function updateReinscripcionDetalle($kreinscripcion){
		$dbm=$this->getDM();
		$reinscripcion=$dbm->getRepositorioById('RiReinscripcion', 'reinscripcionid', $kreinscripcion);
		if($reinscripcion){
			$textoCorreo="";
			$data=json_decode(trim(file_get_contents("php://input")), true);
			$kestatus=$data['estatusid'];
			$kcolegiatura=$data['colegiaturaid'];
			$correo=$data["correo"];
			$telefono=$data["telefono"];
			$tramitobeca=$data["tramitobeca"];
			$observacion=$data["observacion"];
			$renunciafo=$data["renunciafo"];
			$pagocolegiaturas=$data["pagocolegiaturas"];
			$hijopersonal=$data["hijopersonal"];
			$nonomina=$data["nonomina"];
			$tipopagocolegiaturaid=$data["tipopagocolegiaturas"];
			$documentacionoriginal=$data["documentacionoriginal"];
			$estatus=$dbm->getRepositorioById('RiReinscripcionestatus','reinscripcionestatusid',$kestatus);
			$colegiatura=$dbm->getRepositorioById('RiFormapagocolegiatura','formapagocolegiaturaid',$kcolegiatura);
			$inscripcion=$dbm->getRepositorioById('RiFormapagoinscripcionyfo','formapagoinscripcionyfoid',$data['inscripcionid']);
			$anticipada=$dbm->getRepositorioById('RiFormapagocolegiaturaanticipada','formapagocolegiaturaanticipadaid',$data['anticipadaid']);
			if($estatus && $colegiatura && $inscripcion && ($kcolegiatura!=3 || $anticipada)){
				if($kestatus==4){
					$observacion="Completado.";
					$leyenda=$dbm->getRepositorioById("Parametros", "parametrosid", 148);
					$textoCorreo=$leyenda->getValor();
				}else{
					$alumnonombre = $reinscripcion->getAlumnoid()->getApellidopaterno() . ' ' .$reinscripcion->getAlumnoid()->getApellidomaterno() . 
					' ' .	$reinscripcion->getAlumnoid()->getPrimernombre();
					
					$matricula = $reinscripcion->getAlumnoid()->getMatricula();
					$textoCorreo="Se detectaron errores en la documentación proporcionada para el proceso de reinscipción del alumno $matricula - $alumnonombre : <br><br>
					$observacion <br><br> 
					Por favor ingrese al Portal Familiar para atender a estos comentarios.";
				}
				setlocale(LC_ALL, 'es_MX');
				$fecha = strftime("%d-%h-%Y %H:%M",strtotime(date("d-m-Y H:i")));
				$usuario = $dbm->getRepositorioById('Usuario','usuarioid',$data['usuarioid']);
				$nombreus = $usuario ? $usuario->getPersonaid()->getNombre() . " " . $usuario->getPersonaid()->getApellidopaterno() : "";
				$oldObs=$reinscripcion->getObservaciones();
				$observacion=$fecha. " - " . $nombreus . " : " .  " $observacion".(!empty($oldObs) ? "\n$oldObs" : "");
				$reinscripcion->setCorreo($correo);
				$reinscripcion->setTramitobeca($tramitobeca==1);
				$reinscripcion->setObservaciones($observacion);
				$reinscripcion->setTelefono($telefono);
				$reinscripcion->setReinscripcionestatusid($estatus);
				$reinscripcion->setFormapagocolegiaturaid($colegiatura);
				$reinscripcion->setFormapagoinscripcionyfoid($inscripcion);
				$reinscripcion->setFormapagocolegiaturaanticipadaid($anticipada);
				$reinscripcion->setRenunciafo($renunciafo==1);
				$reinscripcion->setPagocolegiaturas($pagocolegiaturas==1);
				$reinscripcion->setTipopagocolegiaturaid($tipopagocolegiaturaid ? 
					$dbm->getRepositorioById('RiTipopagocolegiatura', 'tipopagocolegiaturaid', $tipopagocolegiaturaid) : null);
				$reinscripcion->setHijopersonal($hijopersonal);
				$alumno = $reinscripcion->getAlumnoid();
				$alumno->setHijopersonal($hijopersonal);
				$alumno->setUsuarioid($data['profusuarioid'] ? 
					$dbm->getRepositorioById('Usuario','usuarioid',$data['profusuarioid']) : null);
				$reinscripcion->setNonomina($nonomina);
				$reinscripcion->setDocumentacionoriginal($documentacionoriginal);
				$dbm->saveRepositorio($reinscripcion);
				$dbm->saveRepositorio($alumno);
				$correoTemplate=$dbm->getRepositorioById('Correo', 'correoid', 19);
				$correoTemplate->setMotivo("Reinscripción del alumno " . $reinscripcion->getAlumnoid()->getMatricula());
				Correo::ServicioCorreo([$correo], [$textoCorreo], $correoTemplate, $this->get('mailer'));
				return Api::Ok(Response::HTTP_OK, true);
			}
			return Api::Ok(Response::HTTP_PARTIAL_CONTENT, "Llene todos los campos.");
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, "No se encontro la reinscripcion solicitada.");
	}

	/**
	 * @Annotations\Get("/api/Controlescolar/Reinscripcion/Opciones", name="getReinscripcionOpciones")
	 */
	public function getReinscripcionOpciones(){
		return Api::Ok(Response::HTTP_OK, $this->getReinscripcionOpcionesProcess());
	}
	private function getReinscripcionOpcionesProcess(){
		$dbm=$this->getDM();
		$estatus=$dbm->getRepositoriosModelo("RiReinscripcionestatus",[
				"d.reinscripcionestatusid AS id",
				"d.reinscripcionestatusid",
				"d.nombre"
			],["activo"=>1]);
		$colegiatura=$dbm->getRepositoriosModelo("RiFormapagocolegiatura",[
				"d.formapagocolegiaturaid AS id",
				"d.formapagocolegiaturaid",
				"d.nombre",
				"d.descripcion"
			],["activo"=>1]);
		$anticipada=$dbm->getRepositoriosModelo("RiFormapagocolegiaturaanticipada",[
				"d.formapagocolegiaturaanticipadaid AS id",
				"d.formapagocolegiaturaanticipadaid",
				"d.nombre",
				"d.descripcion"
			],["activo"=>1]);
		$inscripcion=$dbm->getRepositoriosModelo("RiFormapagoinscripcionyfo",[
				"d.formapagoinscripcionyfoid AS id",
				"d.formapagoinscripcionyfoid",
				"d.nombre",
				"d.descripcion"
			],["activo"=>1]);
		$documento=$dbm->getRepositoriosModelo("RiDocumento",[
				"d.documentoid AS id",
				"d.documentoid",
				"d.nombre",
				"d.extension",
				"d.orden"
			],["activo"=>1]);
		foreach($documento AS &$idocumento){
			$grados=[];
			$gradosraw=$dbm->getRepositoriosModelo("RiGradopordocumento",["IDENTITY(d.gradoid) AS gradoid"],["documentoid"=>$idocumento["documentoid"]]);
			foreach($gradosraw AS $igrado){ $grados[]=(int) $igrado["gradoid"];}
			$idocumento["grados"]=$grados;
			unset($idocumento);
		}
		$maxsize=$dbm->getRepositorioById("Parametros", "parametrosid", 61)->getValor();
		$tipopagocolegiatura=$dbm->getRepositoriosById("RiTipopagocolegiatura", "activo", 1);

		//Parametros de configuracion del S3
		$ruta=$dbm->getRepositorioById("Parametros", "nombre", 'NombreCarpetaArchivosReinscripcion')->getValor();
		$bucket=$dbm->getRepositorioById("Parametros", "nombre", 'S3Bucket')->getValor();
		$secretaccesskey=$dbm->getRepositorioById("Parametros", "nombre", 'S3secretAccessKey')->getValor();
		$accesskeyid=$dbm->getRepositorioById("Parametros", "nombre", 'S3accessKeyId')->getValor();
		$region=$dbm->getRepositorioById("Parametros", "nombre", 'S3region')->getValor();

		$S3 = ['bucket' => $bucket, "ruta" => $ruta, "sacceskey" => $secretaccesskey, "accessid" => $accesskeyid, "region" => $region];

		return [
				"estatus"=>$estatus,
				"colegiatura"=>$colegiatura,
				"anticipada"=>$anticipada,
				"inscripcion"=>$inscripcion,
				"documento"=>$documento,
				"maxsize"=>$maxsize,
				"tipopagocolegiatura"=>$tipopagocolegiatura,
				"s3" => $S3
			];
	}

	private function getDM(){
		if($this->DBM){ return $this->DBM; }
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}	

	//--------------- Emmanuel -------------------


	/**
	 * David Medina davidmq.skip@gmail.com
	 * Fecha 21/04/2021
	 * Función Modificar estatus de reinscripción
	 * @Annotations\Put("/api/Controlescolar/Reinscripcion/Estatus/", name="Estatusreinscripcion")
	 */
	public function Estatusreinscripcion(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);			
			$dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$reinscripcion = $dbm->getRepositorioById('RiReinscripcion', 'reinscripcionid', $data['reinscripcionid']);			
			$reinscripcion->setReinscripcionestatusid($dbm->getRepositorioById('Rireinscripcionestatus', 'reinscripcionestatusid', $data['status']));
			$dbm->saveRepositorio($reinscripcion);
			return new View("Se ha guardado el registro", Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
}