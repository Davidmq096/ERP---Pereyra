<?php

namespace AppBundle\Controller\Ludoteca;

use AppBundle\DB\DbmLudoteca;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\LuCaptura;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CjDocumentoporpagar;

/**
 * Auto: David
 */
class CapturaLudotecaController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Ludoteca/capturaludoteca", name="indexCaptura")
     */
    public function indexCaptura()
    {
        try {
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $tipo = $dbm->getRepositoriosById('LuTipo', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('LuEstatuscaptura', 'estatuscapturaid', [2,3]);
            $usuarios = $dbm->BuscarUsuarios();
            $persona = $dbm->BuscarPersonarecoge();
            return new View(array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                "semestre" => $semestre,
                "grupos" => $grupo,
                "tipo" => $tipo,
                "estatus" => $estatus,
                "persona" => $persona,
                "usuarios" => $usuarios
        ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de estados en base a los parametros enviados
     * @Rest\Get("/api/Ludoteca/capturaludoteca/alumnoinfo", name="getAlumnoInfo")
     */
    public function getAlumnoInfo()
    {
        try {
            $fechaHoy=new \DateTime();
            $mes1Text=$fechaHoy->format('Y-m-01');
            $mes1=new \DateTime($mes1Text);
            $mes1->setTime(0,0,0);

            $hoy = date('Y/m/d');
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $contratos = $dbm->BuscarLudoteca($filtros);
            $contratomesactual = $dbm->BuscarContratos(array('fecha' => $mes1, 'contratoestatusid' => 1, 'matricula' => $datos['matricula']));
            $listacontratos = count($contratos);
            $listcontratoactual = count($contratomesactual);
            $contrato = [];

            if ($listcontratoactual > 0) {
                $contrato['tienecontrato'] = 1;
            } else {
                $contrato['tienecontrato'] = 0;
            }

            for ($i=0; $i < $listacontratos; $i++) { 
                if ($contratos[0]['fechalimitepago'] < new \DateTime($hoy)) {
                    $dias = $diff = (new \DateTime($hoy))->diff($contratos[0]['fechalimitepago'])->format("%a");
                }
                if ($contratos[$i]['fechalimitepago'] < new \DateTime($hoy)) {
                    $contrato['importe'] = $contrato['importe'] +  $contratos[$i]['importe'];
                }

                $contrato['diasadeudo'] = $dias;
            }


            return new View($contrato, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de personas que pueden recoger a un alumno
     * @Rest\Get("/api/Ludoteca/capturaludoteca/personarecoge/{id}", name="getPersonarecoge")
     */
    public function getPersonarecogeporalumno($id)
    {
        try {
            $hoy = date('Y/m/d');
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $personarecoge = $dbm->BuscarPersonarecogeporalumno($id);
            $padretutor = $dbm->BuscarPadretutorporalumno($id);

            return new View(array("padretutor" => $padretutor, "personarecoge" => $personarecoge), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Busca las capturas de ludotecas a los filtros enviados
     * @Rest\Post("/api/Ludoteca/capturaludoteca/Filtrar", name="BuscarCapturas")
     */
    public function BuscarCapturas()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            array_filter($filtros);
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $capturas = $dbm->FiltrarLudoteca($filtros);

            if (!$capturas) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }


            return new View($capturas, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
	/**
	 * @Rest\Post("/api/Ludoteca/capturaludoteca" , name="SaveCaptura")
	 */
	public function SaveCaptura(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);
			$dbm=new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $instituto = ENTORNO;
            $fechaHoy=new \DateTime();
            $fechaHoyText=$fechaHoy->format("d-m-Y");
            $fechaHoyDia=(int)$fechaHoy->format("d");

            $mes1Text=$fechaHoy->format('Y-m-01');
            $mes1=new \DateTime($mes1Text);
            $mes1->setTime(0,0,0);

            $hoy=new \DateTime();
            $hoy->setTime(0,0,0);



            if ($data["tipoid"]==1){
                $parametro="LudotecaDiarioSubconceptoMatutino";
            }
            if ($data["tipoid"]==2){
                $parametro="LudotecaDiarioSubconceptoVespertino";
            }
            if ($data["tipoid"]==3){
                $parametro="LudotecaDiarioSubconceptoDeportes";
            }
            $porcentaje = $dbm->getRepositorioById("Parametros","nombre","LudotecaDiarioPorcentaje")->getValor();

            $subconcepto=$dbm->getRepositorioById("CjSubconcepto","subconceptoid",
                $dbm->getRepositorioById("Parametros","nombre",$parametro)->getValor());

			foreach($data['arrayalumno'] as $c){
                $fechaalu = new \DateTime($c['fecha']);
                $fechaalu->setTime(0,0,0);
                $alucaptura = null;
                $dpp = false;
                $alucaptura = $dbm->BuscarCapturaAlumno(array('alumnopocicloid' => $c['alumnoporcicloid'],
                'tipoid' => $c['tipoludotecaid'], 'fecha' => $fechaalu));

                $listcaptura = count($alucaptura);

                if ($listcaptura > 0) {
                    foreach($alucaptura as $ca){
                        $captura = $dbm->getRepositorioById('LuCaptura', 'capturaid', $ca['capturaid']);
                        $captura->setEstatuscapturaid($dbm->getRepositorioById('LuEstatuscaptura', 'estatuscapturaid', 2)?
                        $dbm->getRepositorioById('LuEstatuscaptura', 'estatuscapturaid', 2) : null);
                        $dbm->saveRepositorio($captura);
                        $dpp = true;   
                    }
                } else {
                    $captura=new LuCaptura();
                    $captura->setAlumnoporcicloid($dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $c['alumnoporcicloid']));
                    if($data['fecha'] && $data['hora']) {
                        $captura->setFecha(new \DateTime($c['fecha']));
                        $captura->setHora(new \DateTime($c['hora']));
                        //$fechaHoy = new \DateTime($data['fecha']);
                        //$fechaHoy->setTime($captura->getHora()->format("H"), $captura->getHora()->format("i"), $captura->getHora()->format("s"));
                    } else {
                        $captura->setFecha(new \DateTime());
                        $captura->setHora(new \DateTime());
                    }
                    $captura->setTienecontrato($c['tienecontrato'] ? $c['tienecontrato'] : 0);
                    $captura->setDiasvencidos($c['diasadeudo'] ? $c['diasadeudo'] : 0);
                    $captura->setAdeudo($c['importe'] ? $c['importe'] : 0);
                    $captura->setTipoid($dbm->getRepositorioById('LuTipo', 'tipoid', $c['tipoludotecaid']));
                    $captura->setPersonarecoge($c['personarecoge'] ? $c['personarecoge'] : null);
                    $captura->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $c['usuarioid']));
                    $captura->setEstatuscapturaid($dbm->getRepositorioById('LuEstatuscaptura', 'estatuscapturaid', 2)?
                        $dbm->getRepositorioById('LuEstatuscaptura', 'estatuscapturaid', 2) : null);
                    $dbm->saveRepositorio($captura);
                }


                if ($instituto == 1) {
                    $alumnocontratos = $dbm->BuscarContratos(array('tipoid' => $c['tipoludotecaid'], 'fecha' => $mes1, 'contratoestatusid' => 1, 'matricula' => $c['matricula']));
                    
                    $listalucontrato  = count($alumnocontratos);  
                    if ($listalucontrato == 0 && !$dpp) {
                        $descuento = 0;
                        $subconceptonivel = $dbm->getOneByParametersRepositorio('CjSubconceptopornivel',
                            array('nivelid' => $c['nivelid'], 'subconceptoid' => $subconcepto->getSubconceptoid()));
                        if ($subconceptonivel && !$subconceptonivel->getActivo()) {
                            return new View("El subconcepto por nivel de uno de los alumnos no se encuentra activo.",Response::HTTP_PARTIAL_CONTENT);
                        }   
                        $hijopersonal = $dbm->getRepositorioById('CeAlumnoporpersonal', 'alumnoid', $c['alumnoid']);
                        if(!$hijopersonal){
                            $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $c['alumnoid']);
                            $nombre = $alumno->getPrimernombre() . ' ' . $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno();
                        if ($alumno->getHijopersonal()) {
                                $hijopersonal = true;
                            }
                        }
                        $subconceptoentity=$subconcepto;
                        if($subconceptonivel){
                            $subconceptoentity=$subconceptonivel->getSubconceptoid();
                            $fechalimite=$subconceptonivel->getFechalimitepago();
                            $total=$subconceptonivel->getImporte();
                        } else {
                            $fechalimite=$subconcepto->getFincobro(); 
                            $total=$subconcepto->getImporte();
                        }
                        $descuento=$hijopersonal ? ($porcentaje*$total/100) : 0;
                        $importe=$total-$descuento;
                        if(!$subconceptoentity){
                            return new View("No se ha configurado el subconcepto.",Response::HTTP_PARTIAL_CONTENT);
                        }
                        /*
                        if(!$fechalimite){
                            return new View("El subconcepto no tiene fecha de fin de cobro.",Response::HTTP_PARTIAL_CONTENT);
                            $yearmonth = (new \DateTime())->format('Y-m');
                            $fechalimitepago = (new \DateTime($yearmonth . '-30'))->modify('+1 month');
                            $fechaprontopago = (new \DateTime($yearmonth . '-30'))->modify('+1 month');
                        }
                        $fechalimitedia=10;
                        */
                        $fechaLimiteFinal=$fechaHoy;//new \DateTime($fechaHoy->format("Y-m-{$fechalimitedia}"));
                        //if($fechaHoyDia>=$fechalimitedia){
                        //    $fechaLimiteFinal->modify("+1 month");
                        //}
                        $documentoNombre=$fechaLimiteFinal->format("Ymd")."G";
                        $fechalimitepago = $fechaLimiteFinal;
                        $fechaprontopago = $fechaLimiteFinal;
                        $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                        $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
                        $documentoporpagar = new CjDocumentoporpagar();
                        $documentoporpagar->setDocumentoid($documento);
                        $documentoporpagar->setSubconceptoid($subconceptoentity);
                        $documentoporpagar->setPagoestatusid($dbm->getRepositorioById("CjPagoestatus","pagoestatusid",1));
                        $documentoporpagar->setAlumnoid($c['alumnoid'] ? $dbm->getRepositorioById("Cealumno","alumnoid",$c['alumnoid']) : null);
                        $documentoporpagar->setCicloid($c['cicloid']  ? $dbm->getRepositorioById("Ciclo","cicloid",$c['cicloid']) : null);
                        $documentoporpagar->setGradoid($dbm->getRepositorioById("Grado","gradoid",$c['gradoid']));
                        $documentoporpagar->setImporte($importe);
                        $documentoporpagar->setSaldo($importe);
                        $documentoporpagar->setConcepto($subconceptoentity->getNombre() . "/" . $fechaHoyText);
                        $documentoporpagar->setFechalimitepago($fechalimitepago);
                        $documentoporpagar->setFechacreacion($fechaHoy);
                        $documentoporpagar->setFechaprontopago($fechaprontopago);
                        $documentoporpagar->setDocumento($documentoNombre);
                        $dbm->saveRepositorio($documentoporpagar);
                        $captura->setDocumentoporpagarid($documentoporpagar);
                        $dbm->saveRepositorio($captura);
                    }
                }
			}
			$dbm->getConnection()->commit();
			return new View("Se han guardado los registros", Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
    }
    /**
	 * @Rest\Post("/api/Ludoteca/capturaludoteca/Reservar" , name="SaveReserva")
	 */
	public function SaveReserva(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);
			$dbm=new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $instituto = ENTORNO;
            $fechaHoy=new \DateTime();
            $fechaHoyText=$fechaHoy->format("d-m-Y");
            $fechaHoyDia=(int)$fechaHoy->format("d");

            $mes1Text=$fechaHoy->format('Y-m-01');
            $mes1=new \DateTime($mes1Text);
            $mes1->setTime(0,0,0);

            $fechainicio = strtotime($data["fechainicio"]);
            $fechafin = strtotime($data["fechafin"]);
            
            if ($data["tipoludotecaid"]==1){
                $parametro="LudotecaDiarioSubconceptoMatutino";
            }
            if ($data["tipoludotecaid"]==2){
                $parametro="LudotecaDiarioSubconceptoVespertino";
            }
            if ($data["tipoludotecaid"]==3){
                $parametro="LudotecaDiarioSubconceptoDeportes";
            }
            $porcentaje = $dbm->getRepositorioById("Parametros","nombre","LudotecaDiarioPorcentaje")->getValor();

            $subconcepto=$dbm->getRepositorioById("CjSubconcepto","subconceptoid",
                $dbm->getRepositorioById("Parametros","nombre",$parametro)->getValor());

            for ($i = $fechainicio; $i <= $fechafin; $i += 86400) {
                $sabado = date('w', strtotime(date("Y-m-d", $i))) == 6 ? true : false;
                $domingo = date('w', strtotime(date("Y-m-d", $i))) == 0 ? true : false;

                $mes = date("m", $i);
                $fechacaptura = date("Y-m-d", $i);

                $capturas = $dbm->BuscarCapturaAlumno(array('alumnopocicloid' => $data['alumnoporcicloid'],
                     'tipoid' => $data['tipoludotecaid'], 'fecha' => $fechacaptura));

                $listcaptura = count($capturas);
                
                if ($listcaptura > 0) {
                    return new View("Ya existen capturas para ese alumno en ese rango de fechas", Response::HTTP_PARTIAL_CONTENT);
                }

                $mesactual=$fechaHoy->format('Y-'.$mes.'-01');
                $mesac=new \DateTime($mesactual);
                $mesac->setTime(0,0,0);
                


                if (!$sabado && !$domingo) {
                    $captura=new LuCaptura();
                    $captura->setAlumnoporcicloid($dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $data['alumnoporcicloid']));
                    $captura->setFecha(new \DateTime($fechacaptura));
                    $captura->setHora(new \DateTime());
                    $captura->setTienecontrato($data['tienecontrato'] ? $data['tienecontrato'] : 0);
                    $captura->setDiasvencidos($data['diasadeudo'] ? $data['diasadeudo'] : 0);
                    $captura->setAdeudo($data['importe'] ? $data['importe'] : 0);
                    $captura->setTipoid($dbm->getRepositorioById('LuTipo', 'tipoid', $data['tipoludotecaid']));
                    $captura->setPersonarecoge(null);
                    $captura->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']));
                    $captura->setEstatuscapturaid($dbm->getRepositorioById('LuEstatuscaptura', 'estatuscapturaid', 1)?
                        $dbm->getRepositorioById('LuEstatuscaptura', 'estatuscapturaid', 1) : null);
                    $dbm->saveRepositorio($captura);
    
                    if ($instituto == 1) {
                        $alumnocontratos = $dbm->BuscarContratos(array('tipoid' => $data['tipoludotecaid'], 'fecha' => $mesac, 'contratoestatusid' => 1, 'matricula' => $data['matricula']));
                        
                        $listalucontrato  = count($alumnocontratos);  
                        if ($listalucontrato == 0) {
                            $descuento = 0;
                            $subconceptonivel = $dbm->getOneByParametersRepositorio('CjSubconceptopornivel',
                                array('nivelid' => $data['nivelid'], 'subconceptoid' => $subconcepto->getSubconceptoid()));
                            if ($subconceptonivel && !$subconceptonivel->getActivo()) {
                                return new View("El subconcepto por nivel de uno de los alumnos no se encuentra activo.",Response::HTTP_PARTIAL_CONTENT);
                            }   
                            $hijopersonal = $dbm->getRepositorioById('CeAlumnoporpersonal', 'alumnoid', $data['alumnoid']);
                            if(!$hijopersonal){
                                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid']);
                                $nombre = $alumno->getPrimernombre() . ' ' . $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno();
                            if ($alumno->getHijopersonal()) {
                                    $hijopersonal = true;
                                }
                            }
                            $subconceptoentity=$subconcepto;
                            if($subconceptonivel){
                                $subconceptoentity=$subconceptonivel->getSubconceptoid();
                                $fechalimite=$subconceptonivel->getFechalimitepago();
                                $total=$subconceptonivel->getImporte();
                            } else {
                                $fechalimite=$subconcepto->getFincobro(); 
                                $total=$subconcepto->getImporte();
                            }
                            $descuento=$hijopersonal ? ($porcentaje*$total/100) : 0;
                            $importe=$total-$descuento;
                            if(!$subconceptoentity){
                                return new View("No se ha configurado el subconcepto.",Response::HTTP_PARTIAL_CONTENT);
                            }
                            /*
                            if(!$fechalimite){
                                return new View("El subconcepto no tiene fecha de fin de cobro.",Response::HTTP_PARTIAL_CONTENT);
                                $yearmonth = (new \DateTime())->format('Y-m');
                                $fechalimitepago = (new \DateTime($yearmonth . '-30'))->modify('+1 month');
                                $fechaprontopago = (new \DateTime($yearmonth . '-30'))->modify('+1 month');
                            }
                            $fechalimitedia=10;
                            */
                            $fechaLimiteFinal= new \DateTime($fechacaptura);//new \DateTime($fechaHoy->format("Y-m-{$fechalimitedia}"));
                            //if($fechaHoyDia>=$fechalimitedia){
                            //    $fechaLimiteFinal->modify("+1 month");
                            //}
                            $documentoNombre=$fechaLimiteFinal->format("Ymd")."G";
                            $fechalimitepago = $fechaLimiteFinal;
                            $fechaprontopago = $fechaLimiteFinal;
                            $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                            $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
                            $documentoporpagar = new CjDocumentoporpagar();
                            $documentoporpagar->setDocumentoid($documento);
                            $documentoporpagar->setSubconceptoid($subconceptoentity);
                            $documentoporpagar->setPagoestatusid($dbm->getRepositorioById("CjPagoestatus","pagoestatusid",1));
                            $documentoporpagar->setAlumnoid($data['alumnoid'] ? $dbm->getRepositorioById("Cealumno","alumnoid",$data['alumnoid']) : null);
                            $documentoporpagar->setCicloid($data['cicloid']  ? $dbm->getRepositorioById("Ciclo","cicloid",$data['cicloid']) : null);
                            $documentoporpagar->setGradoid($dbm->getRepositorioById("Grado","gradoid",$data['gradoid']));
                            $documentoporpagar->setImporte($importe);
                            $documentoporpagar->setSaldo($importe);
                            $documentoporpagar->setConcepto($subconceptoentity->getNombre() . "/" . $fechaHoyText);
                            $documentoporpagar->setFechalimitepago($fechalimitepago);
                            $documentoporpagar->setFechacreacion($fechaLimiteFinal);
                            $documentoporpagar->setFechaprontopago($fechaprontopago);
                            $documentoporpagar->setDocumento($documentoNombre);
                            $dbm->saveRepositorio($documentoporpagar);
                            $captura->setDocumentoporpagarid($documentoporpagar);
                            $dbm->saveRepositorio($captura);
                        } else {
                            return new View("El alumno seleccionado cuenta con contrato en las fechas seleccionadas", Response::HTTP_PARTIAL_CONTENT);
                        }
                    }
                }
			}
			$dbm->getConnection()->commit();
			return new View("Se han guardado los registros", Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
    }
    
        /**
     *  Busca las capturas de ludotecas a los filtros enviados
     * @Rest\Post("/api/Ludoteca/capturaludoteca/CambioFecha", name="CambioFecha")
     */
    public function CambioFecha()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            $data = array_filter($filtros);
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $ludoteca = $dbm->getRepositorioById("LuCaptura","capturaid", $data['capturaid']);
            $ludoteca->setFecha(new \DateTime($data['fechanueva']));
            $ludoteca->setHora(new \DateTime($data['horacambio']));
            $dbm->saveRepositorio($ludoteca);

            $dbm->getConnection()->commit();
            return new View("Se ha cambiado la fecha", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Cancela las ludotecas seleccionadas
     * @Rest\Post("/api/Ludoteca/capturaludoteca/Cancelar", name="CancelarCapturaLudoteca")
     */
    public function CancelarCapturaLudoteca()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            $data = array_filter($filtros);
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $date = new \DateTime();
            $instituto = ENTORNO;
            $hoy = $date->format('Y-m-d');
            foreach($data['listaludotecas'] as $lu) {
                $lucaptura = $dbm->getRepositorioById("LuCaptura","capturaid", $lu);
                if($lucaptura->getDocumentoporpagarid()) {
                    if($lucaptura->getDocumentoporpagarid()->getPagoestatusid()->getPagoestatusid() == 2) {
                        return new View("No se puede(n) cancelar los registros de ludoteca seleccionado(s) por que ya se ha realizado el pago
                         correspondiente. Es necesario hacer una devolución en CAJA para poder cancelar el registro en este módulo.", Response::HTTP_PARTIAL_CONTENT);
                    }   
                }  
                $hoy = $date->format('d/m/Y H:i:s');
                $lucaptura->setEstatuscapturaid($dbm->getRepositorioById("LuEstatuscaptura","estatuscapturaid", 3));
                $lucaptura->setMotivocancelacion($hoy . ' - ' . $data['motivocancelacion']);
                $lucaptura->setUsuarioidcancelacion($dbm->getRepositorioById("Usuario","usuarioid", $data['usuarioid']));
                $dbm->saveRepositorio($lucaptura);

                if($lucaptura->getDocumentoporpagarid() && $instituto == 2) {
                    $hoy = $lucaptura->getFecha()->format('Y-m-d');
                    $datos = $dbm->ObtenerDatosLudotecaAlumno($lucaptura->getAlumnoporcicloid()->getAlumnoid()->getAlumnoid()
                    , $hoy, $lucaptura->getTipoid()->getTipoid());

                    $pagos = $dbm->getRepositoriosById("CjPagodetalle","documentoporpagarid", 
                        $lucaptura->getDocumentoporpagarid()->getDocumentoporpagarid());
                    
                    $importe = 0; 
                    foreach($pagos as $p) {
                        $importe += floatval($p->getImporte());
                    }
                    
                    $saldo = floatval($datos[0]['importe']) - floatval($importe);
                    
                    if($saldo < 0) {
                        return new View("No se puede cancelar la ludoteca debido a que ya tiene un pago parcial", 
                            Response::HTTP_PARTIAL_CONTENT);
                    }

                    $dias = intval($datos[0]['dias']);

                    if(intval($datos[0]['dias']) == 0) {
                        $dp = $dbm->getRepositorioById("CjDocumentoporpagar","documentoporpagarid", 
                        $lucaptura->getDocumentoporpagarid()->getDocumentoporpagarid());

                        $lucaptura->setDocumentoporpagarid(null);
                        $dbm->saveRepositorio($lucaptura);
                        $dbm->removeManyRepositorio("CjDocumentoporpagar","documentoporpagarid", $dp->getDocumentoporpagarid());
                    } else {
                        $dp = $lucaptura->getDocumentoporpagarid();
                        $dp->setImporte(floatval($datos[0]['importe']));
                        $dp->setSaldo($saldo);
                        $dp->setConcepto($datos[0]['concepto']);
                        $dbm->saveRepositorio($dp);
                        $lucaptura->setDocumentoporpagarid(null);
                        $dbm->saveRepositorio($lucaptura);
                    }

                }

                if($lucaptura->getDocumentoporpagarid() && $instituto == 1) {
                    $dp = $dbm->getRepositorioById("CjDocumentoporpagar","documentoporpagarid", 
                    $lucaptura->getDocumentoporpagarid()->getDocumentoporpagarid());

                    $pagos = $dbm->getRepositoriosById("CjPagodetalle","documentoporpagarid", 
                    $lucaptura->getDocumentoporpagarid()->getDocumentoporpagarid());

                    if(count($pagos) == 0) {
                        $lucaptura->setDocumentoporpagarid(null);
                        $dbm->saveRepositorio($lucaptura);
                        $dbm->removeManyRepositorio("CjDocumentoporpagar","documentoporpagarid", $dp->getDocumentoporpagarid());
                    } else {
                        return new View("No se puede cancelar la ludoteca debido a que ya tiene un pago parcial", 
                        Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha(n) cancelado la(s) ludoteca(s)", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }
}