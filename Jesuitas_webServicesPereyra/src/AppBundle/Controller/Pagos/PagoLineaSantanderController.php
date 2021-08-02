<?php

namespace AppBundle\Controller\Pagos;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\Entity\CjPago;
use AppBundle\Entity\CjPagodetalle;
use AppBundle\Entity\CjPagoformapago;
use AppBundle\Entity\CjBitacorapagoconbanco;
use AppBundle\Entity\CjDatoadicionalporbitacorapagoconbanco;
use AppBundle\DB\DbmPagos;
use AppBundle\DB\DbmPagoLinea;
use AppBundle\Controller\lib\MIT\MIT;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier
 */
class PagoLineaSantanderController extends FOSRestController
{

    /*----------------- Pago santander --------------------------*/
    /**
     * Verifica llama al servicio para 
     * @Rest\Post("/api/portalfamiliar/Pago/SolicitudCobro" , name="PPSolicitudCobro")
     */
    public function SolicitudCobro()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            if (!$data) {
                $data = $_REQUEST;
            }

            $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());
            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());

            //Validar documentos pagados
            $documentos = explode("/", $data["documentoPorPagarId"]);

            if ($data["tipopago"] == "1") {
                $documentosColegiaturas = $dbm->BuscarDocumentosPorPagarColegiatura(["documentoporpagarid" => $documentos, "pagoestatusid" => 2]);
                $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["documentoporpagarid" => $documentos, "pagoestatusid" => 2]);
                $documentosPagados = array_merge($documentosColegiaturas, $documentosInscripciones);
            } else if ($data["tipopago"] == "3") {
                $documentosPagados = $dbm->BuscarDcocumentosOtros(["documentoporpagarid" => $documentos, "pagoestatusid" => 2]);
            }

            if (count($documentosPagados) > 0) {
                $return = array(
                    'error' => "Uno de los cargos seleccionados ya se encuentra pagado. Vuelva a actualizar la página y a seleccionar los cargos a realizar.",
                );

                return new View($return, Response::HTTP_PARTIAL_CONTENT);
            }

            $fecha = new \DateTime();
            $tipoUsuario = $data["padreotutorid"] ? 'padre' : 'alumno';

            if ($tipoUsuario == 'padre') {
                $padre = $dbm->getRepositorioById('CePadresotutores', 'padresotutoresid', $data["padreotutorid"]);
                $usuario = $dbm->getRepositorioById('Usuario', 'padreotutorid', $data["padreotutorid"]);
                $referencia = $data["tipopago"] . $data["padreotutorid"] . "-" . $fecha->getTimestamp();
            } else {
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data["alumnoid"]);
                $usuario = $dbm->getRepositorioById('Usuario', 'alumnoid', $data["alumnoid"]);
                $referencia = $data["tipopago"] . $data["alumnoid"] . "-" . $fecha->getTimestamp();
            }

            $matricula = $dbm->getRepositorioById("CjDocumentoporpagar", "documentoporpagarid", $documentos[0])->getAlumnoid();
            if ($matricula) {
                $matricula = $matricula->getMatricula();
                $referencia = $referencia . '-' . $matricula;
            }

            //--- Actualizar referencia en los documentos
            foreach ($documentos as $documentoporpagarid) {
                $doc = $dbm->getRepositorioById("CjDocumentoporpagar", "documentoporpagarid", $documentoporpagarid);

                if ($data["tipopago"] == "1") {
                    $documentosDesgloce = $dbmPL->getDocumentosPorPagarPorDocumento($doc->getDocumento(), $doc->getAlumnoid()->getAlumnoid(), $doc->getCicloid()->getCicloid());

                    foreach ($documentosDesgloce as $docref) {
                        if ($docref->getFechareferencia()) {
                            $fechadiff = $docref->getFechareferencia()->diff(new \DateTime());
                            if ($fechadiff->y == 0 && $fechadiff->m == 0 && $fechadiff->d == 0 && $fechadiff->h == 0) {
                                $diffminutos = $fechadiff->i;
                                if ($diffminutos < 5) {
                                    $return = array(
                                        'error' => "Uno de los cargos seleccionados se encuentra en proceso de pago, favor de esperar 5 minutos.",
                                    );
                                    return new View($return, Response::HTTP_PARTIAL_CONTENT);
                                }
                            }
                        }
                        $docref->setReferencia($referencia);
                        $docref->setFechareferencia(new \DateTime());
                        $dbm->saveRepositorio($doc);
                    }
                } else if ($data["tipopago"] == "3") {
                    if ($doc->getFechareferencia()) {
                        $fechadiff = $doc->getFechareferencia()->diff(new \DateTime());
                        if ($fechadiff->y == 0 && $fechadiff->m == 0 && $fechadiff->d == 0 && $fechadiff->h == 0) {
                            $diffminutos = $fechadiff->i;
                            if ($diffminutos < 5) {
                                $return = array(
                                    'error' => "Uno de los cargos seleccionados se encuentra en proceso de pago, favor de esperar 5 minutos.",
                                );
                                return new View($return, Response::HTTP_PARTIAL_CONTENT);
                            }
                        }
                    }
                    $doc->setReferencia($referencia);
                    $doc->setFechareferencia(new \DateTime());
                    $dbm->saveRepositorio($doc);
                }
            }

            $xml = "";
            $mit = new MIT($data["empresaid"]);

            if ($data["tipopago"] == "1" || $data["tipopago"] == "3") //documentos por pagar: 1 = Inscripción y Colegiatura, 3 = Pagos Diversos
            {
                $xml =
                    "<?xml version='1.0' encoding='UTF-8' standalone='yes'?> 
                    <P>
                        <business> 
                            <id_company>" . $mit->getIdCompany() . "</id_company>
                            <id_branch>" . $mit->getIdbranch() . "</id_branch>
                            <user>" . $mit->getUser() . "</user>
                            <pwd>" . $mit->getPassword() . "</pwd>
                        </business> 
                        <url>
                            <reference>" . $referencia . "</reference>
                            <amount>" . $data["importe"] . "</amount>
                            <moneda>MXN</moneda>
                            <canal>W</canal> 
                            <omitir_notif_default>0</omitir_notif_default>
                            <st_correo>1</st_correo> 
                            <mail_cliente>" . ($tipoUsuario == 'padre' ? $padre->getCorreo() : $alumno->getCorreoinstitucional()) . "</mail_cliente> 
                            <datos_adicionales>
                                <data id='1' display='true'>
                                    <label>Alumno</label> 
                                    <value>" . $data["alumno"] . "</value>
                                </data>
                                <data id='2' display='true'>
                                    <label>Concepto</label> 
                                    <value>" . $data["concepto"] . "</value>
                                </data> 
                                <data id='3' display='false'>
                                    <label>UsuarioId</label> 
                                    <value>" . $usuario->getUsuarioid() . "</value>
                                </data> 
                                <data id='4' display='false'>
                                    <label>TipoPago</label> 
                                    <value>" . $data["tipopago"] . "</value>
                                </data>
                            </datos_adicionales>
                        </url>
                    </P>";
            } else if ($data["tipopago"] == "2") {
                $xml =
                    "<?xml version='1.0' encoding='UTF-8' standalone='yes'?> 
                    <P>
                        <business> 
                            <id_company>3I7A</id_company>
                            <id_branch>0001</id_branch>
                            <user>3I7AISUS0</user>
                            <pwd>XQSH6OSW19</pwd>
                        </business> 
                        <url>
                            <reference>" . $data["referencia"] . "</reference>
                            <amount>" . $data["importe"] . "</amount>
                            <moneda>MXN</moneda>
                            <canal>W</canal> 
                            <omitir_notif_default>0</omitir_notif_default>
                            <st_correo>1</st_correo> 
                            <mail_cliente>" . ($tipoUsuario == 'padre' ? $padre->getCorreo() : $alumno->getCorreoinstitucional()) . "</mail_cliente> 
                            <datos_adicionales>
                                <data id='1' display='true'>
                                    <label>Nº Acuerdo</label> 
                                    <value>" . $data["nconvenio"] . "</value>
                                </data>
                                <data id='2' display='true'>
                                    <label>Concepto</label> 
                                    <value>" . $data["concepto"] . "</value>
                                </data> 
                                <data id='3' display='false'>
                                    <label>UsuarioId</label> 
                                    <value>" . $usuario->getUsuarioid() . "</value>
                                </data> 
                                <data id='4' display='false'>
                                    <label>TipoPago</label> 
                                    <value>" . $data["tipopago"] . "</value>
                                </data>
                            </datos_adicionales>
                        </url>
                    </P>";
            }

            file_put_contents('C:\EnvioBanco.xml', $xml);
            $result = \AppBundle\Dominio\PagoLinea::SolicitudPago($xml, $data["empresaid"]);

            $succes = strpos($result, "Error");

            if ($succes === false) {
                $return = array(
                    'url' => $result,
                );

                return new View($return, Response::HTTP_OK);
            } else {
                $return = array(
                    'error' => $result,
                );

                return new View($return, Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /*----------------- Pago santander --------------------------*/
    /**
     * Verifica llama al servicio para 
     * @Rest\Post("/api/portalfamiliar/Pago/GenerarRespuestaPagoBanco" , name="PPGenerarRespuestaBanco")
     */
    public function GenerarRespuestaBanco()
    {
        $data = $_REQUEST;
        $xml = $data['xml'];
        $result = \AppBundle\Dominio\PagoLinea::GetRespuesta($data['xml'], "1");

        return new View($result, Response::HTTP_OK);
    }


    /**
     * Recibe la informacion que manda el servicio de santander respecto al pago 
     * @Rest\Post("/api/portalfamiliar/Pago" , name="PPPago")
     */
    public function Pago()
    {
        $dataPost = $_POST{
            'strResponse'};

        $xml = $_POST{
            'strResponse'};

        return $this->RegistrarPago($dataPost, "1");
    }


    /**
     * Recibe la informacion que manda el servicio de santander respecto al pago desde prosa
     * @Rest\Post("/api/prosa/Pago" , name="PPPagoProsa")
     */
    public function PagoProsa()
    {
        $dataPost = $_POST{
            'strResponse'};

        $xml = $_POST{
            'strResponse'};

        return $this->RegistrarPago($dataPost, "2");
    }
    /**
     * Registra un pago
     */
    public function RegistrarPago($dataPost, $empesaid)
    {
        try {
            
            $xml = \AppBundle\Dominio\PagoLinea::RecibirPago($dataPost, $empesaid);
            $data = \AppBundle\Dominio\PagoLinea::XML2JSON($xml);

            //-- conexión
            $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());
            $cajaid = $dbm->getRepositorioById('Parametros', 'nombre', $nombreCaja);
            $caja = $dbm->getRepositorioById('CjCaja', 'cajaid', intval($cajaid->getValor()));
            $folio = $this->verifyFolio($caja);
            $dbm->getConnection()->beginTransaction();

            //-- bitacora banco --
            $bitacora = new CjBitacorapagoconbanco();

            if ($data["response"] == "approved") {
                $bitacora->setReferencia($data["reference"]);
                $bitacora->setRespuesta($data["response"]);
                $bitacora->setFoliocpago($data["foliocpagos"]);
                $bitacora->setAuth($data["auth"]);
                $bitacora->setCdrespuesta($data["cd_response"]);
                $bitacora->setEmpresa($data["nb_company"]);
                $bitacora->setComerciante($data["nb_merchant"]);
                $bitacora->setBanco($data["cc_type"]);
                $bitacora->setOperacion($data["tp_operation"]);
                $bitacora->setImporte($data["amount"]);
                $bitacora->setIdurl($data["id_url"]);
                $bitacora->setCorreo($data["email"]);
                $bitacora->setXml($xml);


                $bitacora->setHora(new \DateTime($data["time"]));
                $fecha = \AppBundle\Dominio\PagoLinea::FechaEsp2Gen($data["date"]);
                $bitacora->setFecha(new \DateTime($fecha));
            } else {
                $bitacora->setRespuesta($data["response"]);
                $bitacora->setCdrespuesta($data["cd_response"]);
                $bitacora->setIdurl($data["id_url"]);
                $bitacora->setCorreo($data["email"]);
                $bitacora->setXml($xml);

                $bitacora->setHora(new \DateTime());
                $bitacora->setFecha(new \DateTime());
            }

            if ($data["cd_error"]) {
                $bitacora->setCdError($data["cd_error"]);
            }
            if ($data["nb_error"]) {
                $bitacora->setNberror($data["nb_error"]);
            }
            if ($data["cc_name"]) {
                $bitacora->setCcNombre($data["cc_name"]);
            }
            if ($data["cc_number"]) {
                $bitacora->setCcNumero($data["cc_number"]);
            }

            $dbm->saveRepositorio($bitacora);

            $dbm->getConnection()->commit();


            //-------- datos adicionales recibidos por el banco ---------------
            $referencia = "";
            $nconvenio = "";
            $tipoPago = "";

            $dbm->getConnection()->beginTransaction();

            $adicionalCount = count($data["datos_adicionales"]["data"]);

            for ($k = 0; $k < $adicionalCount; $k++) {
                $adicional = new CjDatoadicionalporbitacorapagoconbanco();

                $adicional->setDato($data["datos_adicionales"]["data"][$k]["label"]);
                $adicional->setValor($data["datos_adicionales"]["data"][$k]["value"]);
                $adicional->setBitacorapagoconbancoid($bitacora);

                $dbm->saveRepositorio($adicional);

                //---- Obtener datos adicioanles  ocultos ---                
                if ($data["datos_adicionales"]["data"][$k]["label"] == "TipoPago") {
                    $tipoPago = $data["datos_adicionales"]["data"][$k]["value"];
                }

                if ($data["datos_adicionales"]["data"][$k]["label"] == "Nº Acuerdo") {
                    $nconvenio = $data["datos_adicionales"]["data"][$k]["value"];
                }
            }

            if ($data["response"] != "approved") {
                return new View("Pago denegado", Response::HTTP_OK);
            }

            //--- Procedimiento para pagar ---
            if ($tipoPago == "1" || $tipoPago == "3") //1 = Colegiaturas e inscripciones, 3 = Pagos Diversos
            {
                $nombreCaja = $empesaid == "1" ? 'Caja Id Portal Web' : 'Caja Id Portal Web PROSA';
                $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());
                //$folio = $dbmPL->GetFolioPago($caja->getCajaid());
                $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data["datos_adicionales"]["data"][2]["value"]);
                $pagoEstatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 4); //Aprobado
                $estatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 2); //Pagado

                $documentos = $dbm->getRepositoriosById('CjDocumentoporpagar', 'referencia', $data["reference"]);

                //---- Obtener los documentos con los saldos
                if ($tipoPago == "1") {
                    $documentosColegiaturas = $dbm->BuscarDocumentosPorPagarColegiatura(["referencia" => $data["reference"]]);
                    $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["referencia" => $data["reference"]]);
                    $saldos = array_merge($documentosColegiaturas, $documentosInscripciones);
                } else if ($tipoPago == "3") {
                    $saldos = $dbm->BuscarDcocumentosOtros(["referencia" => $data["reference"]]);
                }

                //------- Obtener a los alumnos -----------
                $sql2 = 'SELECT DISTINCT AlumnoId FROM cj_documentoporpagar  WHERE referencia = :referencia';
                $conn = $this->get("db_manager")->getConnection();
                $stmt = $conn->prepare($sql2);
                $stmt->execute(array('referencia' => $data["reference"]));
                $alumnos = $stmt->fetchAll();

                //$parametrorecargo = $dbm->getRepositorioById('Parametros', 'nombre', "RecargoPortalWeb");
                //$parametrorecargo = $parametrorecargo ? $parametrorecargo->getValor() : 1;
                //$parametrodescuento = $dbm->getRepositorioById('Parametros', 'nombre', "DescuentoPortalWeb");
                //$parametrodescuento = $parametrodescuento ? $parametrodescuento->getValor() : 1;

                //-- Calcular pago por alumno --
                foreach ($alumnos as &$alumno) {
                    $alumno["Intereses"] = [];
                    $alumno["Descuentos"] = [];
                    $alumno["SaldoTotal"] = 0;
                    $alumno["CicloId"] = "";
                    $alumno["Conceptos"] = [];
                    $alumno["DocumentoPorPagarId"] = "";
                    $primero = true;

                    foreach ($saldos as $saldo) {
                        if ($saldo["AlumnoId"] == $alumno["AlumnoId"]) {
                            $saldo["DocumentoPorPagarId"] = $dbm->getOneByParametersRepositorio(
                                'CjDocumentoporpagar',
                                array(
                                    'documento' => $saldo["Documento"],
                                    'referencia' => $saldo["Referencia"],
                                    'alumnoid' => $saldo["AlumnoId"]
                                ),
                                array('importe' => 'DESC')
                            );
                            if ($saldo['IsInscripcion']) {
                                //Asignamos el id del documento principal cuando estan agrupadas las inscripciones
                                $subconceptoinscripcion = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $saldo["subconceptoinscripcionid"]);
                                $documentoporpagar = $dbm->getOneByParametersRepositorio(
                                    'CjDocumentoporpagar',
                                    array(
                                        'documento' => $saldo["Documento"],
                                        'alumnoid' => $saldo["AlumnoId"],
                                        'referencia' => $referencia,
                                        'subconceptoid' => $subconceptoinscripcion ? $saldo["subconceptoinscripcionid"] : 0
                                    )
                                );
                                $saldo["DocumentoPorPagarId"] = $documentoporpagar ? $documentoporpagar : $saldo["DocumentoPorPagarId"];
                            }

                            if ($tipoPago == "1") {
                                $alumno["Intereses"][] = array("Interes" => floatval($saldo["InteresTotal"]), "DocumentoPorPagarId" => $saldo["DocumentoPorPagarId"]);

                                $saldoTotal = floatval($saldo["SaldoTotal"]) + floatval($saldo["InteresTotal"]);
                                $descuento = 0;

                                if ($saldo["Descuento"] == "1") {
                                    $descuento = strval(round((($saldoTotal) * floatval($saldo["DescuentoProntoPago"]) / 100.0), 2));
                                    $alumno["Descuentos"][] = array('Descuento' => $descuento, 'DocumentoPorPagarId' => $saldo["DocumentoPorPagarId"]);
                                }

                                if($saldo["descuentodoc"] > 0){
                                    $alumno["Descuentos"][] = array('Descuento' => $saldo["descuentodoc"], 'DocumentoPorPagarId' => $saldo["DocumentoPorPagarId"], 'Colegiatura' => true);
                                }

                                $alumno["SaldoTotal"] += ($saldoTotal - $descuento);
                                $alumno["Conceptos"][] = array("Concepto" => $saldo["Concepto"], "Documento" => $saldo["Documento"], "CicloId" => $saldo["CicloId"], "AlumnoId" => $saldo["AlumnoId"]);
                            } else if ($tipoPago == "3") {
                                $alumno["SaldoTotal"] += floatval($saldo["Saldo"]);
                            }

                            if ($primero) {
                                $primero = false;

                                $alumno["CicloId"] = $saldo["CicloId"];
                                $alumno["DocumentoPorPagarId"] = $saldo["DocumentoPorPagarId"];
                            }
                        }
                    }
                }



                //-------- Aplicar pagos por alumno
                foreach ($alumnos as &$alumno) {
                    //--- Pagar documento
                    $pago = new CjPago();

                    $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $alumno["CicloId"]);
                    $alumnoId = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $alumno["AlumnoId"]);
                    $estatuspago = $dbm->getRepositorioById('CjPagoEstatus', 'pagoestatusid', 2); //Pagado

                    $pago->setUsuarioid($usuario);
                    $pago->setCajaid($caja);
                    $pago->setEmpresaid($dbm->getRepositorioById('CjEmpresa', 'empresaid', $empesaid));
                    $pago->setCicloid($ciclo);
                    $pago->setAlumnoid($alumnoId);
                    $pago->setImporte($alumno["SaldoTotal"]);
                    $pago->setFecha(new \DateTime());
                    $pago->setPagoestatusid($estatuspago);
                    $pago->setFolio($folio);

                    $dbm->saveRepositorio($pago);

                    //--- pago forma pago
                    $formaPago = new CjPagoformapago();

                    $tipo = substr($data["cc_type"], 0, strpos($data["cc_type"], '/'));
                    if ($tipo == "CREDITO") {
                        $tipo = 2;
                    } else if ($tipo == "DEBITO") {
                        $tipo = 3;
                    } else {
                        $tipo = 6;
                    }

                    $forma = $dbm->getRepositorioById('CjFormapago', 'formapagoid', $tipo);
                    $formaPago->setPagoid($pago);
                    $formaPago->setPagoestatusid($pagoEstatus);
                    $formaPago->setImporte($alumno["SaldoTotal"]);
                    $formaPago->setReferencia($data["foliocpagos"] . ' - ' . $data["reference"]);
                    $formaPago->setTarjeta($data["cc_number"]);
                    $formaPago->setFormaPagoid($forma);
                    $dbm->saveRepositorio($formaPago);

                    //Pago de interes
                    $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'Subconcepto de pago de intereses');
                    $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));
                    foreach ($alumno["Intereses"] as $interes) {
                        //$documentoidinteres = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $interes['DocumentoPorPagarId']);

                        if ($interes['Interes'] > 0) {
                            $detalle = new CjPagodetalle();

                            $detalle->setPagoid($pago);
                            $detalle->setSubconceptoid($subconceptodocumento);
                            $detalle->setImporte($interes["Interes"]);
                            $detalle->setDocumentoporpagarid($interes['DocumentoPorPagarId']);
                            $detalle->setPagoformapagoid($formaPago);
                            $detalle->setLeyenda("Recargo");
                            $dbm->saveRepositorio($detalle);
                        }
                    }


                    //--- Pagar documentos                
                    foreach ($documentos as $documento) {
                        if (intval($alumno["AlumnoId"]) == $documento->getAlumnoId()->getAlumnoId() && floatval($documento->getSaldo() > 0)) {
                            $saldoPrevio = $documento->getSaldo();
                            if($saldoPrevio == 0){
                                continue;
                            }
                            $ivaPrevio = $documento->getIva();

                            $documento->setSaldo(0.00);
                            $documento->setPagoestatusid($estatus);

                            $dbm->saveRepositorio($documento);

                            //calcular IVA
                            $ivapago = 0;
                            if ($ivaPrevio > 0) {
                                $iva = floatval($dbm->getRepositorioById('Parametros', 'nombre', 'IVA')->getValor());
                                $ivapago = ($saldoPrevio * $iva / 100.0);
                                $ivapago = round($ivapago, 2);
                            }

                            //pago detalle
                            $detalle = new CjPagodetalle();
                            $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $documento->getSubconceptoid());

                            $detalle->setPagoid($pago);
                            $detalle->setDocumentoporpagarid($documento);
                            $detalle->setSubconceptoid($subconceptodocumento);
                            $detalle->setImporte($saldoPrevio);
                            $detalle->setIva($ivapago);

                            /*if ($tipoPago == "1") {
                                $countConcepto = count($alumno["Conceptos"]);
                                for ($k = 0; $k < $countConcepto; $k++) {
                                    if ($alumno["Conceptos"][$k]["Documento"] == $documento->getDocumento() && $alumno["Conceptos"][$k]["AlumnoId"] == $documento->getAlumnoId()->getAlumnoId() && $alumno["Conceptos"][$k]["CicloId"] == $documento->getCicloId()->getCicloId()) {
                                        $detalle->setLeyenda($alumno["Conceptos"][$k]["Concepto"]);
                                        break;
                                    }
                                }
                            }*/

                            $detalle->setLeyenda($documento->getConcepto());
                            $detalle->setPagoformapagoid($formaPago);

                            $dbm->saveRepositorio($detalle);
                        }
                    }

                    //Pago de descuento
                    $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'SubConceptoDescuentoInscripcion');
                    $subconceptodocumento = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                    $suconceptoid = $dbm->getRepositorioById('Parametros', 'nombre', 'SubConceptoDescuentoColegiatura');
                    $subconceptocolegiatura = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', intval($suconceptoid->getValor()));

                    foreach ($alumno["Descuentos"] as $descuento) {
                        //$documentoiddecuento = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $descuento['DocumentoPorPagarId']);

                        if ($descuento['Descuento'] > 0) {
                            $detalle = new CjPagodetalle();

                            $detalle->setPagoid($pago);
                            $detalle->setSubconceptoid($descuento['Colegiatura'] ? $subconceptocolegiatura : $subconceptodocumento);
                            $detalle->setImporte($descuento["Descuento"] * -1);
                            $detalle->setDocumentoporpagarid($descuento['DocumentoPorPagarId']);
                            $detalle->setPagoformapagoid($formaPago);
                            $detalle->setLeyenda("Descuento");
                            $dbm->saveRepositorio($detalle);
                        }
                    }
                }

                // Generación de inscripcion a taller extracurriculares
                if ($tipoPago == "3") {
                    foreach ($documentos as $documento) {
                        $talleres = $dbm->getRepositoriosById('CeAlumnocicloportallerextra', 'documentoporpagarid', $documento->getDocumentoporpagarid());
                        if ($talleres) {
                            if ($documento->getPagoestatusid()->getPagoestatusid() == 2) {
                                $tallerestatus = $dbm->getRepositorioById('CeTallerextraestatusinscripcion', 'tallerextraestatusinscripcionid', 3);
                                foreach ($talleres as $taller) {
                                    $taller->setTallerextraestatusinscripcionid($tallerestatus);
                                    $dbm->saveRepositorio($taller);
                                }
                            }
                        }
                    }
                }
                $dbm->getConnection()->commit();

                //Actualizar el estutus del alumnoporciclo al ser una inscripcion
                if ($tipoPago == "1") {
                    $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());
                    $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["referencia" => $data["reference"]]);
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
            }

            return new View("Respuesta recibida y procesada", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function verifyFolio($caja) {
        try {
            $db= $this->get("db_manager");
            $db->getConnection()->beginTransaction();
            //reseteamos el entity manager para que en caso de que ya exista un id poder reestablecer la conexion para volver a intentar
            $this->get('doctrine')->resetEntityManager();

            $dbm = new DbmPagoLinea($this->get('doctrine')->getEntityManager());
            $folio = $dbm->GetFolioPago($caja->getCajaid());
            $foliopago = new CjPagofolio();
            $foliopago->setFolio($folio);
            $dbm->saveRepositorio($foliopago);

            $db->getConnection()->commit();
            return $folio;

        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                $this->verifyFolio();
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
