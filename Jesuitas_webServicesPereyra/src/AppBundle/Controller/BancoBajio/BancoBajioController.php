<?php

namespace AppBundle\Controller\BancoBajio;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

use AppBundle\Entity\CjPago;
use AppBundle\Entity\CjPagodetalle;
use AppBundle\Entity\CjPagoformapago;
use AppBundle\Entity\CjBitacorapagoconbanco;
use AppBundle\DB\DbmPagoLinea;
use AppBundle\DB\DbmPagos;
use AppBundle\DB\DbmControlescolar;
use AppBundle\DB\DbmCobranza;

/**
 * @author Inceptio
 */
class BancoBajioController extends FOSRestController
{

    protected $bloqueo;
    /**
     * Pago en ventanilla para el lux y ciencias
     * Obtiene la lista de los documentos por pagar relacionados al alumno
     * @Rest\Post("/api/pagoinstitutolux", name="BBPagoInstitutoLux")
     */
    public function BBPagoInstitutoLux()
    {
        //accion       (consulta, pago, reverso)
        //referencia   (referencia del pago)
        //Banco emisor (valor fijo)
        //servicio_bb  (valor fijo)
        //monto        (importe  que se pago)
        //forma_pago   (efectivo, cargo, tc, "")
        //firma        (firma encriptada)
        try {
            $data = $_REQUEST;


            if (!$this->VerifyData($data)) {
                $salida = array(
                    'estatus' => "007",
                    'mensaje' => "Datos no validos"
                );

                return new View($salida, Response::HTTP_OK);
            }

            //-- Guardar Datos en recibidos en la base de datos
            $this->GuardarDatos($data);

            //-- Realizar operación
            if ($data["accion"] == 'consulta') {
                return $this->ConsultarDocumentoPorPagar($data["referencia"]);
            } else if ($data["accion"] == 'pago') {
                return $this->RealizarPago($data);
            } else if ($data["accion"] == 'reverso') {
                return $this->CancelarPago($data);
            } else {
                return new View('Accion no valida', Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    //------------------ Guardar datos recibidos ------
    public function GuardarDatos($data)
    {
        $dbm = $this->get("db_manager");

        $bitacora = new CjBitacorapagoconbanco();

        $bitacora->setJson(json_encode($data));
        $bitacora->setBancoEmisor($data["banco_emisor"]);
        $bitacora->setServicioBb($data["servicio_bb"]);
        $bitacora->setMonto(floatval($data["monto"]));
        $bitacora->setFormaPago($data["forma_pago"]);
        $bitacora->setFirma($data["firma"]);
        $bitacora->setAccion($data["accion"]);

        $bitacora->setHora(new \DateTime());
        $bitacora->setFecha(new \DateTime());

        $dbm->saveRepositorio($bitacora);
    }

    //------------------------------------  Validar datos ---------------------
    public function VerifyData($data)
    {
        $dbm = $this->get("db_manager");
        $llave = $dbm->getRepositorioById('Parametros', 'nombre', 'Llave Banco')->getValor();
        $servicio = $dbm->getRepositorioById('Parametros', 'nombre', 'Servicio_bb Banco')->getValor();

        $firma = $data["accion"] . "|" . $data["referencia"] . "|" . $data["banco_emisor"] . "|" . $servicio . "|" . $data["monto"] . "|" . $data["forma_pago"] . "|" . $llave;

        $firma = sha1($firma);

        if ($firma == $data["firma"]) {
            return true;
        } else {
            return false;
        }
    }

    //----------------------------------- Consulta ---------------------------------
    public function ConsultarDocumentoPorPagar($referencia)
    {
        try {
            $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());
            $sql = "";
            $tipoPago = 0;

            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());
            $tipoPago =  $dbmPL->GetTipoDocumento($referencia);
            //inscripciones y colegiaturas
            if ($tipoPago == 1) {
                $documentosColegiaturas = $dbm->BuscarDocumentosPorPagarColegiatura(["referenciabanco" => $referencia]);
                $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["referenciabanco" => $referencia]);
                $ColegiaturaseInscripciones = array_merge($documentosColegiaturas, $documentosInscripciones);
                $documentosPorPagar = $ColegiaturaseInscripciones[0];
            }
            //Pagos diversos
            else if ($tipoPago == 2) {
                $documentosOtros = $dbm->BuscarDcocumentosOtros(["referenciabanco" => $referencia]);
                $documentosPorPagar = $documentosOtros[0];
            }
            //No se encontro el pago
            else {
                return $this->GetRespuesta("005", "consulta", $referencia, "00.00", "00.00", "00.00", "00.00", "");
            }

            if ($documentosPorPagar) {
                $pago = $documentosPorPagar;
                //Validar pago
                $estatus = $this->ValidarPago($pago, $tipoPago);
                if ($estatus != "000") {
                    return $this->GetRespuesta($estatus, "consulta", $referencia, "00.00", "00.00", "00.00", "00.00", "");
                } else {
                    if ($tipoPago == 1) {
                        //cambiar concepto
                        $pago['Concepto'] = "Pago de Inscripción";

                        //calcular recargo
                        $parametrorecargo = $dbm->getRepositorioById('Parametros', 'nombre', "RecargoVentanillaBancaria");
                        $parametrorecargo = $parametrorecargo ? $parametrorecargo->getValor() : 1;
                        if ($pago['Recargo'] && $pago['RecargoPorVencimiento'] && $parametrorecargo == 1) {
                            $pago['InteresTotal'] =  round(floatval($pago['SaldoTotal']) * floatval($pago['RecargoPorVencimiento']) / 100.0, 2);
                        }

                        //Validar si hay un acuerdo en la inscripcion
                        if ($pago['IsInscripcion']) {
                            //Asignamos el id del documento principal cuando estan agrupadas las inscripciones
                            $subconceptoinscripcion = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $pago["subconceptoinscripcionid"]);
                            $documentoporpagar = $dbm->getOneByParametersRepositorio(
                                'CjDocumentoporpagar',
                                array(
                                    'documento' => $pago["Documento"],
                                    'alumnoid' => $pago["AlumnoId"],
                                    'referenciabanco' => $referencia,
                                    'subconceptoid' => $subconceptoinscripcion ? $pago["subconceptoinscripcionid"] : 0
                                )
                            );
                            $pago["DocumentoPorPagarId"] = $documentoporpagar ? $documentoporpagar->getDocumentoporpagarid() : $pago["DocumentoPorPagarId"];

                            $documento = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $pago["DocumentoPorPagarId"]);
                            $acuerdo = $documento->getAcuerdoid();
                            if ($acuerdo) {
                                //Validar que el acuerdo sea vigente
                                $hoy = new \DateTime("midnight");
                                if (
                                    ($hoy >= $acuerdo->getVigenciainicio()) &&
                                    ($hoy <=  $acuerdo->getVigenciafin()) &&
                                    ($hoy <= $documento->getVigenciaacuerdo())
                                ) {
                                    switch ($documento->getTipoacuerdoid()->getTipoacuerdoid()) {
                                        case 1:
                                            $pago['InteresTotal'] = 0;
                                            break;
                                        case 2:
                                            break;
                                        case 3:
                                            $descuentoacuerdo = round(floatval($pago['InteresTotal']) * floatval($documento->getPorcentaje()) / 100.0, 2);
                                            $pago['InteresTotal'] = $pago['InteresTotal'] - $descuentoacuerdo;
                                            break;
                                    }
                                }
                            }
                        }


                        //calculo descuento
                        $descuento = 0;
                        $saldoTotal = floatval($pago["SaldoTotal"]) + floatval($pago["InteresTotal"]);
                        $parametrodescuento = $dbm->getRepositorioById('Parametros', 'nombre', "DescuentoVentanillaBancaria");
                        $parametrodescuento = $parametrodescuento ? $parametrodescuento->getValor() : 1;
                        if ($pago["Descuento"] == "1" && $parametrodescuento == 1) {
                            $descuento = strval(round((($saldoTotal) * floatval($pago["DescuentoProntoPago"]) / 100.0), 2));
                        }

                        $saldoTotal = strval(number_format(round($saldoTotal - $descuento, 2), 2, '.', ''));

                        return $this->GetRespuesta("000", "consulta", $referencia, strval(number_format($pago['SaldoTotal'], 2, '.', '')), strval(number_format($pago['InteresTotal'], 2, '.', '')), strval(number_format($descuento, 2, '.', '')), $saldoTotal, $pago['Alumno']);
                    } else if ($tipoPago == 2) {
                        $saldoTotal = strval(number_format(round(floatval($pago["Saldo"]) + floatval($pago["Interes"]), 2), 2, '.', ''));

                        return $this->GetRespuesta("000", "consulta", $referencia, strval(number_format($pago['Saldo'], 2, '.', '')), strval(number_format($pago['Interes'], 2, '.', '')), "00.00", $saldoTotal, $pago['Alumno']);
                    }
                }
            } else {
                return $this->GetRespuesta("005", "consulta", $referencia, "00.00", "00.00", "00.00", "00.00", "");
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function GetRespuesta($estatus, $accion, $referencia, $monto, $recargo, $descuento, $pago, $nombre)
    {
        $salida = array(
            'estatus' => $estatus,
            'mensaje' => $this->GetMensajeEstatusConsulta($estatus),
            'accion' => $accion,
            'referencia' => $referencia,
            'monto_original' => $monto,
            'recargo_aplicado' => $recargo,
            'descuento_aplicado' => $descuento,
            'monto_a_pagar' => $pago,
            'nombre' => $this->OnlyLettersAndDigits($nombre),
        );

        return new View($salida, Response::HTTP_OK);
    }


    public function GetMensajeEstatusConsulta($estatus)
    {
        switch ($estatus) {
            case "000":
                return "Recibo vigente";
            case "001":
                return "Recibo pagado previamente";
            case "002":
                return "Hay recibo(s) anteriores pendiente(s) de pago";
            case "003":
                return "Recibo cancelado";
            case "004":
                return "Recibo vencido";
            case "005":
                return "Referencia no encontrada";
            case "006":
                $observaciones = array();
                foreach ($this->bloqueo as $key => $value) {
                    if (preg_match('/^observaciones/', $key) && $value) {
                        $observaciones[] = $value;
                    }
                }
                $mensaje = implode(", ", $observaciones);                                
                return "Bloqueo;" . $mensaje;
            default:
                return "";
        }
    }

    public function ValidarPago($pago, $tipoPago)
    {
        $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());
        $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $dbmc = new DbmCobranza($this->get("db_manager")->getEntityManager());

        if ($pago["PagoEstatusId"] == "2" || $pago["PagoEstatusId"] == "4" || $pago["PagoEstatusId"] == "5") //pagado, en proceso de pago, aprovado
        {
            return "001";
        } else if ($pago["PagoEstatusId"] == "3") // cancelado
        {
            return "003";
        } else //pagos anteriores o pendientes
        {
            if ($pago["AlumnoId"]) {
                //inscripciones y colegiaturas
                if ($tipoPago == 1) {
                    if ($pago["TipoDocumento"] == "1" && $pago["Prorroga"] == "1") {
                        return "004";
                    }

                    switch ($pago['TipoDocumento']) {
                        case 1: //Inscripcion
                            //Buscamos bloqueos que tenga el alumno
                            $alumno = $dbmce->BuscarAlumnosA(['alumnoid' => $pago['AlumnoId'], 'cicloid' => $pago['CicloId']])[0];
                            $bloqueo = \AppBundle\Dominio\Bloqueos::BloqueoAlumno($dbmc, array(
                                "alumnoporcicloid" => $alumno["alumnoporcicloid"],
                                "tipo" => 3
                            ));
                            if ($bloqueo['datosactualizados'] || $bloqueo['documentosentregados'] || $bloqueo['bloqueoimpresion'] || $bloqueo["bloqueoadeudo"]) {
                                //print_r($bloqueo);
                                $this->bloqueo = $bloqueo;
                                return "006";
                            }
                            $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["alumnoid" => $pago["AlumnoId"], "pagoestatusid" => 1, "fechalimite" => $pago["FechaLimite"]]);

                            $documentosColegiaturas = $dbm->BuscarDocumentosPorPagarColegiatura([
                                "alumnoid" => $pago["AlumnoId"],
                                "pagoestatusid" => 1,
                                "fechalimite" => (new \DateTime())->format("Y-m-d")
                            ]);
                            break;
                        case 2: //Colegiatura
                            $documentosInscripciones = array();

                            $documentosColegiaturas = $dbm->BuscarDocumentosPorPagarColegiatura(["alumnoid" => $pago["AlumnoId"], "pagoestatusid" => 1, "fechalimite" => $pago["FechaLimite"]]);
                            break;
                    }

                    $documentos = array_merge($documentosColegiaturas, $documentosInscripciones);
                }
                //Pagos diversos
                else if ($tipoPago == 2) {
                    //Buscamos bloqueos que tenga el alumno
                    $alumno = $dbmce->BuscarAlumnosA(['alumnoid' => $pago['AlumnoId']])[0];
                    $bloqueo = \AppBundle\Dominio\Bloqueos::BloqueoAlumno($dbmc, array(
                        "alumnoporcicloid" => $alumno["alumnoporcicloid"],
                        "tipo" => 1,
                        "cicloid" => $alumno["cicloid"]
                    ));
                    if ($bloqueo["bloqueopago"] || $bloqueo["bloqueoadeudo"]) {
                        //print_r($bloqueo["No se puede realizar el pago de este concepto por los siguientes motivos"]);
                        //print_r("Adeudos: Comunicarse con Administración.");
                        //print_r($bloqueo["observacionespago"]);
                        $this->bloqueo = $bloqueo;
                        return "006";
                    }

                    $documentos = []; //$dbm->BuscarDcocumentosOtros(["alumnoid" => $pago["AlumnoId"], "pagoestatusid" => 1, "fechalimite" => $pago["FechaLimite"]]);
                }
            }

            $num = count($documentos);
            return $num > 0 ? "002" : "000";
        }
    }



    //------------------------- Pagar ---------------------------------
    public function RealizarPago($data)
    {
        try {
            $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();

            $referencia =  $data["referencia"];

            $fechahora = new \DateTime();
            $hora = $fechahora->format('H:i:s');
            $fecha = $fechahora->format('Y-m-d');
            $descuento = 0;

            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());
            $tipoPago =  $dbmPL->GetTipoDocumento($referencia);


            //Validar pago
            //inscripciones y colegiaturas
            if ($tipoPago == 1) {
                $documentosColegiaturas = $dbm->BuscarDocumentosPorPagarColegiatura(["referenciabanco" => $referencia]);
                $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["referenciabanco" => $referencia]);
                $ColegiaturaseInscripciones = array_merge($documentosColegiaturas, $documentosInscripciones);
                $documentosPorPagar = $ColegiaturaseInscripciones[0];
            }
            //Pagos diversos
            else if ($tipoPago == 2) {
                $documentosOtros = $dbm->BuscarDcocumentosOtros(["referenciabanco" => $referencia]);
                $documentosPorPagar = $documentosOtros[0];
            }
            /*else if($catalago == "CN")
            {
                $tipoPago = 3;
            }*/ else {
                return $this->GetRespuestaPago("006", "pago", $referencia, "", $fecha, $hora, "");
            }

            $documento = end($dbm->getRepositoriosById('CjDocumentoporpagar', 'referenciabanco', $referencia, 'importe'));
            $docPagar = null;
            if ($documentosPorPagar) {
                $pago = $documentosPorPagar;

                //Validar pago
                $estatus = $this->ValidarPago($documentosPorPagar, $tipoPago);

                if ($estatus != "000") {
                    return $this->GetRespuesta($estatus, "consulta", $referencia, "00.00", "00.00", "00.00", "00.00", "");
                }
                //Validar monto a pagar
                else {
                    $saldoTotal = 0;
                    if ($tipoPago == 1) {
                        //calcular recargo
                        $parametrorecargo = $dbm->getRepositorioById('Parametros', 'nombre', "RecargoVentanillaBancaria");
                        $parametrorecargo = $parametrorecargo ? $parametrorecargo->getValor() : 1;
                        if ($pago['Recargo'] && $pago['RecargoPorVencimiento'] && $parametrorecargo == 1) {
                            $pago['InteresTotal'] =  round(floatval($pago['SaldoTotal']) * floatval($pago['RecargoPorVencimiento']) / 100.0, 2);
                        }

                        //Validar si hay un acuerdo en la inscripcion
                        if ($pago['IsInscripcion']) {
                            //Asignamos el id del documento principal cuando estan agrupadas las inscripciones
                            $subconceptoinscripcion = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $pago["subconceptoinscripcionid"]);
                            $documentoporpagar = $dbm->getOneByParametersRepositorio(
                                'CjDocumentoporpagar',
                                array(
                                    'documento' => $pago["Documento"],
                                    'alumnoid' => $pago["AlumnoId"],
                                    'referenciabanco' => $referencia,
                                    'subconceptoid' => $subconceptoinscripcion ? $pago["subconceptoinscripcionid"] : 0
                                )
                            );

                            $documento = $documentoporpagar ? $documentoporpagar : $documento;
                            $acuerdo = $documento->getAcuerdoid();
                            if ($acuerdo) {
                                //Validar que el acuerdo sea vigente
                                $hoy = new \DateTime("midnight");
                                if (
                                    ($hoy >= $acuerdo->getVigenciainicio()) &&
                                    ($hoy <=  $acuerdo->getVigenciafin()) &&
                                    ($hoy <= $documento->getVigenciaacuerdo())
                                ) {
                                    switch ($documento->getTipoacuerdoid()->getTipoacuerdoid()) {
                                        case 1:
                                            $pago['InteresTotal'] = 0;
                                            break;
                                        case 2:
                                            break;
                                        case 3:
                                            $descuentoacuerdo = round(floatval($pago['InteresTotal']) * floatval($documento->getPorcentaje()) / 100.0, 2);
                                            $pago['InteresTotal'] = $pago['InteresTotal'] - $descuentoacuerdo;
                                            break;
                                    }
                                }
                            }
                        }



                        //calculo descuento
                        $descuento = 0;
                        $saldoTotal = floatval($pago["SaldoTotal"]) + floatval($pago["InteresTotal"]);
                        $parametrodescuento = $dbm->getRepositorioById('Parametros', 'nombre', "DescuentoVentanillaBancaria");
                        $parametrodescuento = $parametrodescuento ? $parametrodescuento->getValor() : 1;
                        if ($pago["Descuento"] == "1" && $parametrodescuento == 1) {
                            $descuento = strval(round((($saldoTotal) * floatval($pago["DescuentoProntoPago"]) / 100.0), 2));
                        }

                        $saldoTotal = strval(number_format(round($saldoTotal - $descuento, 2), 2, '.', ''));
                    } else if ($tipoPago == 2) {
                        $saldoTotal = strval(number_format(round(floatval($pago["Saldo"]) + floatval($pago["InteresTotal"]), 2), 2, '.', ''));
                    }

                    if ($saldoTotal != $data["monto"]) {
                        return $this->GetRespuestaPago("006", "pago", $referencia, "", $fecha, $hora, "");
                    }
                }

                $docPagar = $pago;
            } else {
                return $this->GetRespuestaPago("005", "pago", $referencia, "", $fecha, $hora, "");
            }

            $ciclo = $documento->getCicloid();
            $alumno = $documento->getAlumnoid();
            $solicitudadmision = $documento->getSolicitudadmisionid();
            $cajaid = $dbm->getRepositorioById('Parametros', 'nombre', 'Caja Id del cajero del banco');
            $caja = $dbm->getRepositorioById('CjCaja', 'cajaid', intval($cajaid->getValor()));
            $estatuspago = $dbm->getRepositorioById('CjPagoEstatus', 'pagoestatusid', 2);
            $usuarioid = $dbm->getRepositorioById('Usuario', 'usuarioid', 2);
            $folio = $dbmPL->GetFolioPago($caja->getCajaid());

            //pago 
            $pago = new CjPago();
            $pago->setCajaid($caja);
            $pago->setEmpresaid($dbm->getRepositorioById('CjEmpresa', 'empresaid', 1));
            $pago->setCicloid($ciclo);
            $pago->setAlumnoid($alumno);
            $pago->setSolicitudadmisionid($solicitudadmision);
            $pago->setImporte($data["monto"]);
            $pago->setFecha($fechahora);
            $pago->setPagoestatusid($estatuspago);
            $pago->setUsuarioid($usuarioid);
            $pago->setFolio($folio);

            $dbm->saveRepositorio($pago);

            $pagoEstatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 4); //Aprobado
            $tipo = 6;
            switch ($data["forma_pago"]) {
                case "efectivo":
                    $tipo = 1;
                    break;
                case "cargo":
                    $tipo = 3;
                    break;
                case "tc":
                    $tipo = 2;
                    break;
            }
            $forma = $dbm->getRepositorioById('CjFormapago', 'formapagoid', $tipo);

            //pago forma pago
            $formaPago = new CjPagoformapago();
            $formaPago->setPagoid($pago);
            $formaPago->setPagoestatusid($pagoEstatus);
            $formaPago->setImporte($data["monto"]);
            $formaPago->setReferencia($referencia);
            $formaPago->setTarjeta("");
            $formaPago->setFormaPagoid($forma);

            $dbm->saveRepositorio($formaPago);

            //pago detalle intereses
            $interes = floatval($docPagar["InteresTotal"]);
            if ($interes > 0) {
                $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'Subconcepto de pago de intereses');
                $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                $detalle = new CjPagodetalle();
                $detalle->setPagoid($pago);
                $detalle->setSubconceptoid($subconceptodocumento);
                $detalle->setImporte($interes);
                $detalle->setDocumentoporpagarid($documento);
                $detalle->setPagoformapagoid($formaPago);
                $detalle->setLeyenda("Recargo");
                $dbm->saveRepositorio($detalle);
            }

            //-- obtener todos los documentos que se pagaron (cuando una inscripcion o colegiaura tienen varios documentos)
            $documentosPagados = $dbm->getByParametersRepositorios("CjDocumentoporpagar", array("referenciabanco" => $referencia));
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
                $detalle->setLeyenda($documentosPagados[$i]->getConcepto());
                $detalle->setPagoformapagoid($formaPago);

                $dbm->saveRepositorio($detalle);
            }

            //pago de descuento inscripcion
            if ($descuento > 0) {
                $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'SubConceptoDescuentoInscripcion');
                $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                $detalle = new CjPagodetalle();
                $detalle->setPagoid($pago);
                $detalle->setSubconceptoid($subconceptodocumento);
                $detalle->setImporte($descuento * -1);
                $detalle->setDocumentoporpagarid($documento);
                $detalle->setPagoformapagoid($formaPago);
                $detalle->setLeyenda("Descuento");
                $dbm->saveRepositorio($detalle);
            }


            //Pago de descuento directo colegiatura
            if ($documento->getDescuento() > 0) {
                $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'SubConceptoDescuentoColegiatura');
                $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                $detalle = new CjPagodetalle();
                $detalle->setPagoid($pago);
                $detalle->setSubconceptoid($subconceptodocumento);
                $detalle->setImporte($documento->getDescuento() * -1);
                $detalle->setDocumentoporpagarid($documento);
                $detalle->setPagoformapagoid($formaPago);
                $detalle->setLeyenda("Descuento");
                $dbm->saveRepositorio($detalle);
            }

            $dbm->getConnection()->commit();

            //Actualizar el estutus del alumnoporciclo al ser una inscripcion
            if ($tipoPago == "1") {
                $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["referenciabanco" => $referencia]);
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

            return $this->GetRespuestaPago("000", "pago", $referencia, $folio, $fecha, $hora, $docPagar["Alumno"]);
        } catch (\Exception $e) {
            $dbm->getConnection()->rollBack();
            return new View('Ocurrion un error. Intentalo más tarde.', Response::HTTP_BAD_REQUEST);
        }
    }


    public function GetMensajeEstatusPago($estatus)
    {
        switch ($estatus) {
            case "000":
                return "Pago realizado correctamente";
            case "001":
                return "Recibo pagado previamente";
            case "002":
                return "Hay recibo(s) anteriores pendiente(s) de pago";
            case "003":
                return "Recibo cancelado";
            case "004":
                return "Recibo vencido";
            case "005":
                return "Referencia no encontrada";
            case "006":
                return "El monto de pago no coincide";
            case "007":
                return "Descripcion del posible error al reversar";
            default:
                return "";
        }
    }


    public function GetRespuestaPago($estatus, $accion, $referencia, $folio, $fecha, $hora, $nombre)
    {
        $salida = array(
            'estatus' => $estatus,
            'mensaje' => $this->GetMensajeEstatusPago($estatus),
            'accion' => $accion,
            'referencia' => $referencia,
            'folio_pago' => $folio,
            'fecha_pago' => $fecha,
            'hora_pago' => $hora,
            'nombre' => $this->OnlyLettersAndDigits($nombre),
        );

        return new View($salida, Response::HTTP_OK);
    }

    //---------------------------- Cancelar Pago -----------------------------
    public function CancelarPago($data)
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $referencia = $data["referencia"];
            $fechahora = new \DateTime();
            $hora = $fechahora->format('H:i:s');
            $fecha = $fechahora->format('Y-m-d');

            //pago detalle 
            $formaPago = $dbm->getByParametersRepositorios("CjPagoformapago", array("referencia" => $referencia, "pagoestatusid" => 4));
            $numformapago = count($formaPago);
            $alumno = "";
            $folio = "";

            if ($numformapago > 0) {
                $pagoEstatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 3); //Cancelado
                $estatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 1); //Pendiente
                $cajaid = $dbm->getRepositorioById('Parametros', 'nombre', 'Caja Id del cajero del banco'); // caja del banco

                $numCancelado = 0;
                $pagobanco = false;

                foreach ($formaPago as $fp) {
                    //Obtener los pagos
                    $pago =  $dbm->getByParametersRepositorios("CjPago", array("pagoid" => $fp->getPagoId()->getPagoId(), "cajaid" => $cajaid->getValor()));

                    $numPago = count($pago);

                    $pagoCancelar = null;



                    if ($numPago > 0) {
                        $pagobanco = true;

                        foreach ($pago as $p) {
                            $fechapago = $p->getFecha()->format('Y-m-d');
                            if ($fechapago == $fecha) {
                                $pagoCancelar = $p;
                                break;
                            }
                        }



                        if ($pagoCancelar) {
                            $pagoCancelar->setPagoestatusid($pagoEstatus);
                            $dbm->saveRepositorio($pagoCancelar);

                            //cambiar los estatus de la forma de pago
                            $fp->setPagoestatusid($pagoEstatus);
                            $dbm->saveRepositorio($fp);

                            //Obtener el detalle del pago
                            $folio = $pagoCancelar->getFolio();

                            //--- Nombre del alumno
                            $alumno = $pagoCancelar->getAlumnoid()->getPrimernombre();

                            if ($pagoCancelar->getAlumnoid()->getSegundonombre()) {
                                $alumno .= " " . $pagoCancelar->getAlumnoid()->getSegundonombre();
                            }

                            $alumno .=  " " . $pagoCancelar->getAlumnoid()->getApellidopaterno() . " " . $pagoCancelar->getAlumnoid()->getApellidomaterno();

                            //-- Detalle del pago     
                            $detalle =  $dbm->getByParametersRepositorios("CjPagodetalle", array("pagoid" => $fp->getPagoId()));

                            foreach ($detalle as $dt) {
                                if ($dt->getDocumentoporpagarid()) {
                                    //Regresar documento por pagar al estatus pendiente y al saldo que se cancelo
                                    $documento = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $dt->getDocumentoporpagarid());

                                    $documento->setPagoestatusid($estatus);
                                    $documento->setSaldo(($documento->getSaldo() + $dt->getImporte()));
                                    $dbm->saveRepositorio($documento);
                                }
                            }

                            $numCancelado++;
                        }
                    }
                }


                if (!$pagobanco) {
                    return $this->GetRespuestaCancelar("001", "reverso", $referencia, "", $fecha, $hora, "");
                } else if ($numCancelado == 0) {
                    return $this->GetRespuestaCancelar("007", "reverso", $referencia, "", $fecha, $hora, "");
                } else {
                    $dbm->getConnection()->commit();
                    return $this->GetRespuestaCancelar("000", "reverso", $referencia, $folio, $fecha, $hora, $alumno);
                }
            } else {
                $pagoPendiente = $dbm->getByParametersRepositorios("CjDocumentoporpagar", array("referencia" => $referencia, "pagoestatusid" => 1));
                $countPendiente = count($pagoPendiente);

                if ($countPendiente) {
                    return $this->GetRespuestaCancelar("001", "reverso", $referencia, "", $fecha, $hora, "");
                } else {
                    return $this->GetRespuestaCancelar("005", "reverso", $referencia, "", $fecha, $hora, "");
                }
            }
        } catch (\Exception $e) {
            $dbm->getConnection()->rollBack();
            return new View('Ocurrion un error. Intentalo más tarde.', Response::HTTP_BAD_REQUEST);
        }
    }

    public function GetMensajeEstatusCancelar($estatus)
    {
        switch ($estatus) {
            case "000":
                return "Pago reversado correctamente";
            case "001":
                return "Recibo no esta pagado";
            case "003":
                return "El monto no coincide";
            case "005":
                return "Referencia no encontrada";
            case "007":
                return "La feha para cancelar el pago ha expirado";
            default:
                return "";
        }
    }


    public function GetRespuestaCancelar($estatus, $accion, $referencia, $folio, $fecha, $hora, $nombre)
    {
        $salida = array(
            'estatus' => $estatus,
            'mensaje' => $this->GetMensajeEstatusCancelar($estatus),
            'accion' => $accion,
            'referencia' => $referencia,
            'folio_reverso' => $folio,
            'fecha_reverso' => $fecha,
            'hora_reverso' => $hora,
            'nombre' => $this->OnlyLettersAndDigits($nombre),
        );

        return new View($salida, Response::HTTP_OK);
    }

    public function OnlyLettersAndDigits($cadena)
    {
        $cadena = str_replace("*", "", $cadena);
        $cadena = str_replace("á", "a", $cadena);
        $cadena = str_replace("é", "e", $cadena);
        $cadena = str_replace("í", "i", $cadena);
        $cadena = str_replace("ó", "o", $cadena);
        $cadena = str_replace("ú", "u", $cadena);
        $cadena = str_replace("Ñ", "N", $cadena);
        $cadena = str_replace("ñ", "n", $cadena);
        $cadena = str_replace("Á", "A", $cadena);
        $cadena = str_replace("É", "E", $cadena);
        $cadena = str_replace("Í", "I", $cadena);
        $cadena = str_replace("Ó", "O", $cadena);
        $cadena = str_replace("Ú", "U", $cadena);
        $cadena = str_replace("ä", "a", $cadena);
        $cadena = str_replace("ë", "e", $cadena);
        $cadena = str_replace("ï", "i", $cadena);
        $cadena = str_replace("ö", "o", $cadena);
        $cadena = str_replace("ü", "u", $cadena);
        $cadena = str_replace("à", "a", $cadena);
        $cadena = str_replace("è", "e", $cadena);
        $cadena = str_replace("ì", "i", $cadena);
        $cadena = str_replace("ò", "o", $cadena);
        $cadena = str_replace("ù", "u", $cadena);
        $cadena = str_replace("À", "A", $cadena);
        $cadena = str_replace("È", "E", $cadena);
        $cadena = str_replace("Ì", "I", $cadena);
        $cadena = str_replace("Ò", "O", $cadena);
        $cadena = str_replace("Ù", "U", $cadena);
        $cadena = str_replace("'", "", $cadena);
        $cadena = str_replace("`", "", $cadena);

        $count = strlen($cadena);

        $sb = "";

        for ($k = 0; $k < $count; $k++) {
            if (($cadena[$k] >= '0' && $cadena[$k] <= '9') || ($cadena[$k] >= 'A' && $cadena[$k] <= 'Z') || ($cadena[$k] >= 'a' && $cadena[$k] <= 'z') || $cadena[$k] == ' ') {
                $sb .= $cadena[$k];
            }
        }
        return $sb;
    }
}
