<?php

namespace AppBundle\Controller\BancoBajio;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

use AppBundle\DB\DbmPagoLinea;
use AppBundle\DB\DbmPagos;
use AppBundle\Entity\CjPago;
use AppBundle\Entity\CjPagodetalle;
use AppBundle\Entity\CjPagoformapago;
use AppBundle\Entity\CjBitacorapagoconbanco;

/**
 * @author Inceptio
 */
class PagoLineaController extends FOSRestController
{
    /**
     *Genera y actualiza la referencia de los documentos por pagar
     *@Rest\Put("/api/pagolinea/ImprimirRecibo", name="BBImprimirRecibo")
     */
    public function BBImprimirRecibo()
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());
            if ($data['TipoPago'] == '1') {
                $documentos = $dbmPL->getDocumentosPorPagarPorDocumento($data['Documento'], $data['AlumnoId'], $data['CicloId']);
            } else if ($data['TipoPago'] == '3') {
                $documentos = $dbm->getRepositoriosById("CjDocumentoporpagar", "documentoporpagarid", $data['DocumentoPorPagarId']);
            }

            $cicloinicio = $dbm->getRepositorioById('CeCiclopornivel', 'cicloid', $documentos[0]->getCicloid());
            $referencia = \AppBundle\Dominio\PagoLinea::GenerarReferencia(
                $documentos[0]->getAlumnoid()->getMatricula(),
                0,
                $cicloinicio->getFechainicio(),
                $documentos[0]->getGradoid()->getNivelid()->getNivelid(),
                $documentos[0]->getGradoid()->getGrado(),
                $documentos[0]->getDocumento(),
                $documentos[0]->getSubconceptoid()->getSubconceptoid()
            );

            foreach ($documentos as $d) {
                $d->setReferenciaBanco($referencia);
                $dbm->saveRepositorio($d);
            }

            $dbm->getConnection()->commit();

            $parametrosservicio = $dbm->getRepositorioById('Parametros', 'nombre', 'ServicioReferenciaBancaria');
            $referencia = $referencia . ' ' . $parametrosservicio->getValor();
            return new View(array('Referencia' => $referencia), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *Genera un folio aleatorio para realizar un pago
     *@Rest\Get("/api/pagolinea/getnextfolio", name="BBGetNextFolio")
     */
    public function GetNextFolio()
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $NextFolio = rand();
            return new View($NextFolio, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene el hash para realizar el pago en linea del banco del bajio
     * @Rest\Post("/api/pagolinea/hash", name="BBGetHashBancoBajio")
     */
    public function GetHashBancoBajio()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            if (!$data) {
                $data = $_REQUEST;
            }
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());

            $documentos = [];


            foreach ($data['Documento'] as $d) {
                if ($data["TipoPago"] == '1') {
                    $aux = $dbmPL->getDocumentosPorPagarPorDocumento($d['Documento'], $d['AlumnoId'], $d['CicloId']);
                } else if ($data["TipoPago"] == '3') {
                    $aux = $dbm->getRepositoriosById("CjDocumentoporpagar", "documentoporpagarid", $d['DocumentoPorPagarId']);
                }


                //---- Verificar si un documento ya esta pagado 
                $numDocumento = count($aux);
                $pagado = true;
                for ($k = 0; $k < $numDocumento; $k++) {
                    if ($aux[$k]->getPagoestatusid()->getPagoestatusid() != 2) {
                        $pagado = false;
                        array_push($documentos, $aux[$k]);
                    }
                }

                if ($pagado) {
                    $return = array(
                        'error' => "Uno de los cargos seleccionados ya se encuentra pagado. Vuelva a actualizar la página y a seleccionar los cargos a realizar.",
                    );

                    return new View($return, Response::HTTP_PARTIAL_CONTENT);
                }
            }

            //---- Verificar si hay un documento a pagar 
            $numDocumento = count($documentos);

            if ($numDocumento == 0) {
                $return = array(
                    'error' => "No se encontraron documentos a pagar.",
                );

                return new View($return, Response::HTTP_PARTIAL_CONTENT);
            }


            //--- Generar referencia y actualizarla a los documentos a pagar
            $alumno = $dbm->getRepositorioById("CeAlumno", "alumnoid", $data["Documento"][0]["AlumnoId"]);
            $fecha = new \DateTime();
            $referencia = $data["TipoPago"] . $data["UsuarioId"] . "-" . $fecha->getTimestamp() . "-" . $alumno->getMatricula();

            foreach ($documentos as $d) {
                if($d->getFechareferencia()) {
                    $fechadiff = $d->getFechareferencia()->diff(new \DateTime());
                    if($fechadiff->y == 0 && $fechadiff->m == 0 && $fechadiff->d == 0 && $fechadiff->h == 0) {
                        $diffminutos = $fechadiff->i;
                        if($diffminutos < 10) {
                            $return = array(
                                'error' => "Uno de los cargos seleccionados se encuentra en proceso de pago",
                            );
                            return new View($return, Response::HTTP_PARTIAL_CONTENT);
                        }
                    }
                }
                $d->setReferencia($referencia);
                $d->setFechareferencia(new \DateTime());
                $dbm->saveRepositorio($d);
            }

            //------ Generar folio 
            $ultimoFolio = $dbm->getRepositorioById("Parametros", "nombre", 'Folio Banco del Bajio');
            $folio =  intval($ultimoFolio->getValor()) + 1;
            $ultimoFolio->setValor($folio);
            $dbm->saveRepositorio($ultimoFolio);

            //----- Generar Hash
            $servicio = $dbm->getRepositorioById('Parametros', 'nombre', 'Servicio Banco del Bajio')->getValor();

            $cadenaEncriptada = $folio . "|" . $referencia . "|" . $data['dl_monto'] . "|" . $data['cl_concepto'] . "|" . $servicio . "|";

            $dbm->getConnection()->commit();

            $hash = $this->SignData($cadenaEncriptada, "/Llave/private_key.pem");

            return new View(array('hash' => $hash, 'Referencia' => $referencia, 'Servicio' => $servicio, 'Folio' => $folio), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para recibir la Petición de banco del bajío
     * @Rest\Post("/api/pagolinea/RecibirPago", name="BBRecibirPagoBancoBajio")
     */
    public function RecibirPagoBancoBajio()
    {
        try {
            $data = $_REQUEST;

            $this->GuardarDatos($data);

            $cl_folio = $data['cl_folio'];
            $cl_referencia = $data['cl_referencia'];
            $dl_monto = $data['dl_monto'];
            $dt_fechaPago = $data['dt_fechaPago'];
            $nl_tipoPago = $data['nl_tipoPago'];
            $nl_status = $data['nl_status'];
            $hash = $data['hash'];

            $cadenaEncriptada = $data['cl_folio'] . "|" . $data['cl_referencia'] . "|" . $data['dl_monto'] . "|" . $data['dt_fechaPago'] . "|" . $data['nl_tipoPago'] . "|" . $data['nl_status'] . "|";

            if ($this->VerifyData($data['hash'], $cadenaEncriptada, "/Llave/public_key.pem")) {
                //Hacer proceso para registrar pago
                if ($nl_status == "01" || $nl_status == "03") {

                    //Realizar Pago LUX
                    //$pagoRealizado = $this->RealizarPagoLUX($cl_referencia, $cl_folio, $dl_monto, $nl_tipoPago, $dt_fechaPago);

                    //Realizar Pago  Inceptio
                    $pagoRealizado = $this->RealizarPago($cl_referencia, $cl_folio, $dl_monto, $nl_tipoPago, $dt_fechaPago);

                    if ($pagoRealizado) {
                        return new View("Pago registrado", Response::HTTP_OK);
                    } else {
                        return new View("No se pudo realizar el pago", Response::HTTP_PARTIAL_CONTENT);
                    }
                } else {
                    return new View("El pago fue rechazado por el banco", Response::HTTP_PARTIAL_CONTENT);
                }
            } else {
                return new View('Datos inválidos', Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /** -- **/
    function SignData($text, $privateKeyFile)
    {
        $private_cert = $privateKeyFile;
        $dir = __DIR__;
        $f = fopen(__DIR__ . $private_cert, 'r+');

        if ($f) {
            $private_key = fread($f, filesize(__DIR__ . $private_cert));
        } else {
            return "No se pudo abrir la llave primaria";
        }

        fclose($f);
        $private_key = openssl_get_privatekey($private_key);
        if (openssl_private_encrypt(md5($text), $crypt_text, $private_key)) {
            return $this->base64_url_encode($crypt_text) . "\n";
        }
        return "";
    }

    function VerifyData($crypt_text, $plaintext, $publicKeyFile)
    {
        $public_cert = $publicKeyFile;

        $s = fopen(__DIR__ . $public_cert, 'r+');

        if ($s)
            $public_key = fread($s, filesize(__DIR__ . $publicKeyFile));
        else
            return false;

        fclose($s);

        $res = openssl_get_publickey($public_key);


        if (openssl_public_decrypt($this->base64_url_decode($crypt_text), $decrypt, $res)) {
            if ($decrypt == md5($plaintext))
                return true;
            else
                return false;
        }

        return false;
    }

    function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_,', '+/='));
    }

    public function RealizarPago($referencia, $folioBanco, $monto, $formaPagoBanco, $fecha)
    {
        try {
            $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $fechahora = new \DateTime();
            $fecha = substr($fecha, 0, 4) . "-" . substr($fecha, 4, 2) . "-" . substr($fecha, 6);
            $fecha = new \DateTime($fecha);
            $descuento = 0;

            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());
            $tipoPago =  $dbmPL->GetTipoDocumento($referencia);


            //Validar pago
            //inscripciones y colegiaturas
            if ($tipoPago == 1) {
                $documentosColegiaturas = $dbm->BuscarDocumentosPorPagarColegiatura(["referencia" => $referencia]);
                $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["referencia" => $referencia]);
                $documentosPorPagar = array_merge($documentosColegiaturas, $documentosInscripciones);
            }
            //Pagos diversos
            else if ($tipoPago == 2) {
                $documentosPorPagar = $dbm->BuscarDcocumentosOtros(["referencia" => $referencia]);
            }
            /*else if($catalago == "CN")
            {
                $tipoPago = 3;
            }*/ else {
                return false;
            }

            if (!$documentosPorPagar[0]) {
                return false;
            }
            $documento = $dbm->getRepositorioById('CjDocumentoporpagar', 'referencia', $referencia);

            //pago
            $ciclo = $documento->getCicloid();
            $alumno = $documento->getAlumnoid();
            $solicitudadmision = $documento->getSolicitudadmisionid();
            $cajaid = $dbm->getRepositorioById('Parametros', 'nombre', 'Caja Id Portal Web');
            $caja = $dbm->getRepositorioById('CjCaja', 'cajaid', intval($cajaid->getValor()));
            $estatuspago = $dbm->getRepositorioById('CjPagoEstatus', 'pagoestatusid', 2);
            $posid = strpos($referencia, '-');
            $padreotutorusarioid = substr($referencia, 1, $posid);
            $usuarioid = $dbm->getRepositorioById('Usuario', 'usuarioid', intval($padreotutorusarioid));
            $folio = $dbmPL->GetFolioPago($caja->getCajaid());

            $pago = new CjPago();
            $pago->setEmpresaid($dbm->getRepositorioById('CjEmpresa', 'empresaid', 1));
            $pago->setCajaid($caja);
            $pago->setCicloid($ciclo);
            $pago->setAlumnoid($alumno);
            $pago->setSolicitudadmisionid($solicitudadmision);
            $pago->setImporte($monto);
            $pago->setFecha($fechahora);
            $pago->setPagoestatusid($estatuspago);
            $pago->setUsuarioid($usuarioid);
            $pago->setFolio($folio);

            $dbm->saveRepositorio($pago);


            $pagoEstatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 4); //Aprobado
            $tipo = 2;
            switch ($formaPagoBanco) {
                case "01":
                    $tipo = 2;
                    break;
                case "02":
                    $tipo = 6;
                    break;
                case "03":
                    $tipo = 6;
                    break;
                case "04":
                    $tipo = 3;
                    break;
                case "05":
                    $tipo = 3;
                    break;
                case "06":
                    $tipo = 3;
                    break;
            }
            $forma = $dbm->getRepositorioById('CjFormapago', 'formapagoid', $tipo);

            $formaPago = new CjPagoformapago();
            $formaPago->setPagoid($pago);
            $formaPago->setPagoestatusid($pagoEstatus);
            $formaPago->setImporte($monto);
            $formaPago->setReferencia($referencia);
            $formaPago->setTarjeta("");
            $formaPago->setFormaPagoid($forma);

            $dbm->saveRepositorio($formaPago);


            //Pagar Intereses
            $parametrorecargo = $dbm->getRepositorioById('Parametros', 'nombre', "RecargoPortalWeb");
            $parametrorecargo = $parametrorecargo ? $parametrorecargo->getValor() : 1;
            if ($parametrorecargo == 1) {
                foreach ($documentosPorPagar as $docPagar) {
                    //pago detalle intereses
                    if ($docPagar['Recargo'] && $docPagar['RecargoPorVencimiento']) {
                        $docPagar['InteresTotal'] =  round(floatval($docPagar['SaldoTotal']) * floatval($docPagar['RecargoPorVencimiento']) / 100.0, 2);
                    }                   
                    //pagarintereses
                    $docporpagarid = $dbm->getOneByParametersRepositorio(
                        'CjDocumentoporpagar',
                        array(
                            'documento' => $docPagar["Documento"],
                            'referencia' => $docPagar["Referencia"],
                            'alumnoid' => $docPagar["AlumnoId"]
                        ),
                        array('importe' => 'DESC')
                    );

                    
                    if ($docPagar['IsInscripcion']) {
                        //Asignamos el id del documento principal cuando estan agrupadas las inscripciones
                        $subconceptoinscripcion = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $docPagar["subconceptoinscripcionid"]);
                        $documentoporpagar = $dbm->getOneByParametersRepositorio(
                            'CjDocumentoporpagar',
                            array(
                                'documento' => $docPagar["Documento"],
                                'alumnoid' => $docPagar["AlumnoId"],
                                'referencia' => $referencia,
                                'subconceptoid' => $subconceptoinscripcion ? $docPagar["subconceptoinscripcionid"] : 0
                            )
                        );
                        $docporpagarid = $documentoporpagar ? $documentoporpagar : $docporpagarid;

                        //Validar si hay un acuerdo en la inscripcion
                        $acuerdo = $docporpagarid->getAcuerdoid();
                        if ($acuerdo) {
                            //Validar que el acuerdo sea vigente
                            $hoy = new \DateTime("midnight");
                            if (
                                ($hoy >= $acuerdo->getVigenciainicio()) &&
                                ($hoy <=  $acuerdo->getVigenciafin()) &&
                                ($hoy <= $docporpagarid->getVigenciaacuerdo())
                            ) {
                                switch ($docporpagarid->getTipoacuerdoid()->getTipoacuerdoid()) {
                                    case 1:
                                        $docPagar['InteresTotal'] = 0;
                                        break;
                                    case 2:
                                        break;
                                    case 3:
                                        $descuentoacuerdo = round(floatval($docPagar['InteresTotal']) * floatval($docporpagarid->getPorcentaje()) / 100.0, 2);
                                        $docPagar['InteresTotal'] = $docPagar['InteresTotal'] - $descuentoacuerdo;
                                        break;
                                }
                            }
                        }
                    }

                    $interes = floatval($docPagar["InteresTotal"]);
                    if ($interes > 0) {
                        $detalle = new CjPagodetalle();
                        $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'Subconcepto de pago de intereses');
                        $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                        $detalle->setPagoid($pago);
                        $detalle->setSubconceptoid($subconceptodocumento);
                        $detalle->setImporte($interes);
                        $detalle->setDocumentoporpagarid($docporpagarid);
                        $detalle->setLeyenda("Recargo");
                        $detalle->setPagoformapagoid($formaPago);

                        $dbm->saveRepositorio($detalle);
                    }
                }
            }


            //-- obtener los documentos que se pagaron --
            $documentosPagados = $dbm->getByParametersRepositorios("CjDocumentoporpagar", array("referencia" => $referencia));
            $numdocpagado = count($documentosPagados);

            //documento por pagar
            for ($i = 0; $i < $numdocpagado; $i++) {
                $estatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 2); //Pagado
                $saldoPrevio = $documentosPagados[$i]->getSaldo();
                if($saldoPrevio == 0){
                    continue;
                }
                $ivaPrevio = $documentosPagados[$i]->getIva();

                $documentosPagados[$i]->setSaldo(0.00);
                $documentosPagados[$i]->setPagoestatusid($estatus);

                $dbm->saveRepositorio($documentosPagados[$i]);


                //calculariva
                $ivapago = 0;
                if ($ivaPrevio > 0) {
                    $iva = floatval($dbm->getRepositorioById('Parametros', 'nombre', 'IVA')->getValor());
                    $ivapago = ($saldoPrevio * $iva / 100.0);
                    $ivapago = round($ivapago, 2);
                }

                //pago detalle
                $detalle = new CjPagodetalle();
                $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $documentosPagados[$i]->getSubconceptoid());

                $detalle->setPagoid($pago);
                $detalle->setDocumentoporpagarid($documentosPagados[$i]);
                $detalle->setSubconceptoid($subconceptodocumento);
                $detalle->setImporte($saldoPrevio);
                $detalle->setIva($ivapago);
                $detalle->setLeyenda($documentosPagados[$i]->getConcepto());
                $detalle->setPagoformapagoid($formaPago);

                $dbm->saveRepositorio($detalle);
            }

            //Aplicar descuento
            foreach ($documentosPorPagar as $docPagar) {
                $docporpagarid = $dbm->getOneByParametersRepositorio(
                    'CjDocumentoporpagar',
                    array(
                        'documento' => $docPagar["Documento"],
                        'referencia' => $docPagar["Referencia"],
                        'alumnoid' => $docPagar["AlumnoId"]
                    ),
                    array('importe' => 'DESC')
                );
                
                if ($docPagar['IsInscripcion']) {
                    //Asignamos el id del documento principal cuando estan agrupadas las inscripciones
                    $subconceptoinscripcion = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $docPagar["subconceptoinscripcionid"]);
                    $documentoporpagar = $dbm->getOneByParametersRepositorio(
                        'CjDocumentoporpagar',
                        array(
                            'documento' => $docPagar["Documento"],
                            'alumnoid' => $docPagar["AlumnoId"],
                            'referencia' => $referencia,
                            'subconceptoid' => $subconceptoinscripcion ? $docPagar["subconceptoinscripcionid"] : 0
                        )
                    );
                    $docporpagarid = $documentoporpagar ? $documentoporpagar : $docporpagarid;
                }
                $saldoTotal = floatval($docPagar["SaldoTotal"]);

                //pago detalle descuento
                $descuento = 0;
                $parametrodescuento = $dbm->getRepositorioById('Parametros', 'nombre', "DescuentoPortalWeb");
                $parametrodescuento = $parametrodescuento ? $parametrodescuento->getValor() : 1;
                if ($parametrodescuento == 1) {
                    if ($docPagar["Descuento"] == "1") {
                        $descuento = strval(round((($saldoTotal) * floatval($docPagar["DescuentoProntoPago"]) / 100.0), 2));
                    }
                }
                //pago de descuento inscripcion
                if ($descuento > 0) {
                    $detalle = new CjPagodetalle();
                    $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'SubConceptoDescuentoInscripcion');
                    $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                    $detalle->setPagoid($pago);
                    $detalle->setSubconceptoid($subconceptodocumento);
                    $detalle->setImporte($descuento * -1);
                    $detalle->setDocumentoporpagarid($docporpagarid);
                    $detalle->setLeyenda("Descuento");
                    $detalle->setPagoformapagoid($formaPago);

                    $dbm->saveRepositorio($detalle);
                }

                //Pago de descuento directo colegiatura
                if ($docporpagarid->getDescuento() > 0) {
                    $detalle = new CjPagodetalle();
                    $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'SubConceptoDescuentoColegiatura');
                    $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                    $detalle->setPagoid($pago);
                    $detalle->setSubconceptoid($subconceptodocumento);
                    $detalle->setImporte($docporpagarid->getDescuento() * -1);
                    $detalle->setDocumentoporpagarid($docporpagarid);
                    $detalle->setLeyenda("Descuento");
                    $detalle->setPagoformapagoid($formaPago);

                    $dbm->saveRepositorio($detalle);
                }
            }


            $dbm->getConnection()->commit();

            //Actualizar el estutus del alumnoporciclo al ser una inscripcion
            if ($tipoPago == "1") {
                $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["referencia" => $referencia]);
                foreach ($documentosInscripciones as $docin) {
                    $alumnociclo = $dbm->getByParametersRepositorios("CeAlumnoporciclo", array("alumnoid" => $docin["AlumnoId"], "cicloid" => $docin["CicloId"]));
                    foreach ($alumnociclo as $ac) {
                        $intencion = $ac->getIntencionreinscribirseid();
                        $estatus = $ac->getEstatusalumnocicloid();
                        if (!$estatus) {
                            if ($intencion) {
                                switch ($intencion->getIntencionreinscribirseid()) {
                                    case 1:
                                        $ac->setEstatusalumnocicloid($dbm->getRepositorioById('CeEstatusalumnoporciclo', 'estatusalumnoporcicloid', 2));
                                        break;
                                    case 3:
                                        $ac->setEstatusalumnocicloid($dbm->getRepositorioById('CeEstatusalumnoporciclo', 'estatusalumnoporcicloid', 1));
                                        break;
                                }
                            }
                            $dbm->saveRepositorio($ac);
                        }
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            $dbm->getConnection()->rollBack();
            return false;
        }
    }

    public function GuardarDatos($data)
    {
        $dbm = $this->get("db_manager");

        $bitacora = new CjBitacorapagoconbanco();

        $bitacora->setJson(json_encode($data));
        $bitacora->setClFolio($data["cl_folio"]);
        $bitacora->setClReferencia($data["cl_referencia"]);
        $bitacora->setDlMonto(floatval($data["dl_monto"]));
        $bitacora->setDtFechapago($data["dt_fechaPago"]);
        $bitacora->setNlTipoPago($data["nl_tipoPago"]);
        $bitacora->setNlStatus($data["nl_status"]);
        $bitacora->setHash($data["hash"]);

        $bitacora->setHora(new \DateTime());
        $bitacora->setFecha(new \DateTime());

        $dbm->saveRepositorio($bitacora);
    }

    /**
     * Funcion para recibir la Petición de banco del bajío
     * @Rest\Post("/api/pagolinea/hashBanco", name="BBHashBanco")
     */
    public function HashBanco()
    {
        try {
            $data = $_REQUEST;

            $cl_folio = $data['cl_folio'];
            $cl_referencia = $data['cl_referencia'];
            $dl_monto = $data['dl_monto'];
            $dt_fechaPago = $data['dt_fechaPago'];
            $nl_tipoPago = $data['nl_tipoPago'];
            $nl_status = $data['nl_status'];
            $hash = $data['hash'];

            $cadenaEncriptada = $data['cl_folio'] . "|" . $data['cl_referencia'] . "|" . $data['dl_monto'] . "|" . $data['dt_fechaPago'] . "|" . $data['nl_tipoPago'] . "|" . $data['nl_status'] . "|";

            return  $this->SignData($cadenaEncriptada, "/Llave/private_key.pem");
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function RealizarPagoLUX($referencia, $folioBanco, $monto, $formaPagoBanco, $fecha)
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            //Validar pago que no se haya realizado con anterioridad
            $bitacora = $dbm->getByParametersRepositorios("CjBitacorapagoconbanco", array("clFolio" => $folioBanco));

            $numBitacora = count($bitacora);

            if ($numBitacora > 1) {
                return false;
            }

            $fechahora = new \DateTime();
            $fecha = substr($fecha, 0, 4) . "-" . substr($fecha, 4, 2) . "-" . substr($fecha, 6);
            $fecha = new \DateTime($fecha);
            $hora = $fechahora->format('H:i:s');
            $descuento = 0;

            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());

            //--------- Matricula del alumno --------------
            $matricula;

            if ($folioBanco[0] == "0") {
                $matricula = substr($folioBanco, 1, 4);
            } else {
                $matricula = substr($folioBanco, 0, 5);
            }

            //--- referencia ---
            $terminaciones = ["AC", "AI", "CEA", "CED", "CUI", "EE3", "EE4", "GRA2", "GRA3", "GRA4", "GRG2", "GRG3", "GW", "LG4", "OA2", "OA3", "OA4", "OAC2", "OAC4"];
            $countTerminaciones = count($terminaciones);

            for ($i = 0; $i < $countTerminaciones; $i++) {
                $length = strlen($terminaciones[$i]);

                if (substr($referencia, -$length) === $terminaciones[$i]) {
                    $referencia = substr($referencia, 0, -$length);

                    break;
                }
            }

            //--------- Tipo Documento --------
            $tipoPago =  $dbmPL->GetTipoDocumentoLUX($referencia, $matricula);

            //inscripciones y colegiaturas
            if ($tipoPago == 1) {
                $sql = 'SELECT * FROM cj_documentoporpagarcolegiaturainscripcionvista WHERE Matricula = :matricula and Documento = :documento Group By DocumentoPorPagarId';
            }
            //Pagos diversos
            else if ($tipoPago == 2) {
                $sql = 'SELECT * FROM cj_ppdocumentoporpagarotrospagosvista  WHERE Matricula = :matricula and Documento = :documento Group By DocumentoPorPagarId';
            } else {
                return false;
            }

            $dbm = $this->get("db_manager");
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->execute(array('matricula' => $matricula, 'documento' => $referencia));
            $documentosPorPagar = $stmt->fetchAll();

            if (!$documentosPorPagar[0]) {
                return false;
            }

            //pago
            $alumno = $dbm->getRepositorioById('CeAlumno', 'matricula', $matricula);
            $documeto = $dbm->getByParametersRepositorios("CjDocumentoporpagar", array("alumnoid" => $alumno->getAlumnoid(), "documento" => $referencia))[0];

            $usuarioid = $dbm->getRepositorioById('Usuario', 'usuarioid', 2);

            $pago = new CjPago();
            $cajaid = $dbm->getRepositorioById('Parametros', 'nombre', 'Caja Id Portal Web');

            $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $documeto->getCicloid());
            $subconcepto = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $documeto->getSubconceptoid());
            $caja = $dbm->getRepositorioById('CjCaja', 'cajaid', intval($cajaid->getValor()));
            $estatuspago = $dbm->getRepositorioById('CjPagoEstatus', 'pagoestatusid', 2);

            $pago->setEmpresaid($dbm->getRepositorioById('CjEmpresa', 'empresaid', 1));
            $pago->setCajaid($caja);
            $pago->setCicloid($ciclo);
            $pago->setAlumnoid($alumno);
            $pago->setImporte($monto);
            $pago->setFecha($fechahora);
            $pago->setPagoestatusid($estatuspago);
            $pago->setUsuarioid($usuarioid);

            //Folio
            $folio = $dbmPL->GetFolioPago($caja->getCajaid());
            $pago->setFolio($folio);

            $dbm->saveRepositorio($pago);

            //pago forma pago
            $formaPago = new CjPagoformapago();
            $pagoEstatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 4); //Aprobado

            $tipo = $formaPagoBanco;

            if ($tipo == "01") {
                $tipo = 2;
            } else if ($tipo == "04") {
                $tipo = 3;
            } else {
                $tipo = 6;
            }
            /*else if($tipo == "cargo")
            {
                $tipo = 3;
            }*/

            $forma = $dbm->getRepositorioById('CjFormapago', 'formapagoid', $tipo);

            $formaPago->setPagoid($pago);
            $formaPago->setPagoestatusid($pagoEstatus);
            $formaPago->setImporte($monto);
            $formaPago->setReferencia($referencia);
            $formaPago->setTarjeta("");
            $formaPago->setFormaPagoid($forma);

            $dbm->saveRepositorio($formaPago);



            //-- obtener los documentos que se pagaron --
            $documentosPagados = $dbm->getByParametersRepositorios("CjDocumentoporpagar", array("alumnoid" => $alumno->getAlumnoid(), "documento" => $referencia));
            $numdocpagado = count($documentosPagados);

            //documento por pagar
            for ($i = 0; $i < $numdocpagado; $i++) {
                $estatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 2); //Pagado
                $saldoPrevio = $documentosPagados[$i]->getSaldo();
                $ivaPrevio = $documentosPagados[$i]->getIva();

                $documentosPagados[$i]->setSaldo(0.00);
                $documentosPagados[$i]->setPagoestatusid($estatus);

                $dbm->saveRepositorio($documentosPagados[$i]);


                //calculariva
                $ivapago = 0;
                if ($ivaPrevio > 0) {
                    $iva = floatval($dbm->getRepositorioById('Parametros', 'nombre', 'IVA')->getValor());
                    $ivapago = ($saldoPrevio * $iva / 100.0);
                    $ivapago = round($ivapago, 2);
                }

                //pago detalle
                $detalle = new CjPagodetalle();
                $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $documentosPagados[$i]->getSubconceptoid());

                $detalle->setPagoid($pago);
                $detalle->setDocumentoporpagarid($documentosPagados[$i]);
                $detalle->setSubconceptoid($subconceptodocumento);
                $detalle->setImporte($saldoPrevio);
                $detalle->setIva($ivapago);

                $detalle->setPagoformapagoid($formaPago);

                $dbm->saveRepositorio($detalle);
            }

            foreach ($documentosPorPagar as $docPagar) {
                //pago detalle intereses
                $interes = 0;
                $descuento = 0;

                if ($tipoPago == 1) {
                    $interes = floatval($docPagar["InteresTotal"]);
                    $descuento = 0;
                    $saldoTotal = floatval($docPagar["SaldoTotal"]) + floatval($docPagar["InteresTotal"]);

                    if ($docPagar["Descuento"] == "1") {
                        $descuento = strval(round((($saldoTotal) * floatval($docPagar["DescuentoProntoPago"]) / 100.0), 2));
                    }
                } else if ($tipoPago == 2) {
                    $interes = floatval($docPagar["Interes"]);
                }

                //$docporpagarid = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $docPagar["DocumentoPorPagarId"]);

                if ($interes > 0) {
                    $detalle = new CjPagodetalle();
                    $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'Subconcepto de pago de intereses');
                    $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'Subconcepto de pago de intereses');
                    $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                    $detalle->setPagoid($pago);
                    $detalle->setSubconceptoid($subconceptodocumento);
                    $detalle->setImporte($interes);
                    //$detalle->setDocumentoporpagarid($docporpagarid);

                    $detalle->setPagoformapagoid($formaPago);




                    $dbm->saveRepositorio($detalle);
                }

                //pago de descuento
                if ($descuento > 0) {
                    $detalle = new CjPagodetalle();
                    $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'SubConceptoDescuentoInscripcion');
                    $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                    $detalle->setPagoid($pago);
                    $detalle->setSubconceptoid($subconceptodocumento);
                    $detalle->setImporte($descuento * -1);
                    //$detalle->setDocumentoporpagarid($docporpagarid);

                    $detalle->setPagoformapagoid($formaPago);

                    $dbm->saveRepositorio($detalle);
                }
            }

            $dbm->getConnection()->commit();

            return true;
        } catch (Exception $e) {
            $dbm->getConnection()->rollBack();
            return false;
        }
    }
}
