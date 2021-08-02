<?php

namespace AppBundle\Controller\Pagos;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\DB\DbmPagos;
use AppBundle\DB\DbmControlescolar;
use AppBundle\DB\DbmPagoLinea;
use AppBundle\DB\DbmCobranza;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier
 */
class PagosController extends FOSRestController
{
    /**
     * Obtiene la lista de los documentos pagados en el portal y app de padres 
     * @Rest\Get("/api/portalfamiliar/pagoenlinea/pagados/bypadreotutor/{empresaid}/{padretutorid}", name="PPgetDocumentosPagadosByPadreOTutorId")
     */
    public function getDocumentosPagadosByPadreOTutorId($empresaid, $padretutorid)
    {
        try {
            $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());
            $documentos = $dbm->BuscarDcocumentosPagados(["empresaid" => $empresaid, "padresotutoresid" => $padretutorid]);
            return new View($documentos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene la lista de los documentos por pagar en el portal y app de padres
     * @Rest\Get("/api/portalfamiliar/pagoenlinea/bypadreotutor/{IsInsCol}/{id}", name="PPgetAlumnosDocumentosPorPagarByPadreOTutorId")
     */
    public function getAlumnosDocumentosPorPagarByPadreOTutorId($IsInsCol, $id)
    {
        try {
            $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());
            $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());
            $dbmc = new DbmCobranza($this->get("db_manager")->getEntityManager());

            //Obtener adeudos
            //Inscripciones y colegiaturas
            if ($IsInsCol == "1") {
                $documentosColegiaturas = $dbm->BuscarDocumentosPorPagarColegiatura(["saldo" => true, "padresotutoresid" => $id]);
                $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["saldo" => true, "padresotutoresid" => $id]);
                $documentosPorPagar = array_merge($documentosColegiaturas, $documentosInscripciones);
            }
            //Otros (Pagos diversos)
            else if ($IsInsCol == "0" || $IsInsCol == "2") {
                //En los pagos diversos el ciencias los tiene en PROSA(Empresa 2)
                $empresa = ENTORNO == 1 ? 1 : 2;
                $documentosPorPagar  = $dbm->BuscarDcocumentosOtros(["padresotutoresid" => $id, "pagoestatusid" => 1, "empresaid" => $empresa]);
            }

            //Inscripciones y colegiaturas
            if ($IsInsCol == "1") {
                foreach ($documentosPorPagar as &$dp) {

                    //Solo inscripciones (las colegiaturas ya tienen calculados los recargos y acuerdos con la funcion 'CalculaInteres')
                    if ($dp['TipoDocumento'] == "1") {
                        //cambiar concepto
                        $dp['Concepto'] = "Pago de Inscripción";

                        if ($dp['IsInscripcion']) {
                            //Validaciones de bloqueos                            
                            $alumno = $dbmce->BuscarAlumnosA([
                                'alumnoid' => $dp["AlumnoId"],
                                'cicloid' => $dp["CicloId"]
                            ])[0];
                            $bloqueo = \AppBundle\Dominio\Bloqueos::BloqueoAlumno($dbmc, array(
                                "alumnoporcicloid" => $alumno['alumnoporcicloid'],
                                "tipo" => 3,
                                "cicloid" => $alumno['cicloid']
                            ));

                            $dp['bloqueodocumentos'] = $bloqueo['documentosentregados'];
                            $dp['bloqueodatos'] = $bloqueo['datosactualizados'];
                            $dp['bloqueoadeudo'] = $bloqueo['bloqueoadeudo'];
                            $dp['bloqueoimpresion'] = $bloqueo['bloqueoimpresion'];
                            $dp['observacionesimpresion'] = $bloqueo['observacionesimpresion'];
                            $dp['observacionesdocumentos'] = $bloqueo['observacionesdocumentos'];
                            $dp['observacionesdatos'] = $bloqueo['observacionesdatos'];
                            $dp['observacionesadeudo'] = $bloqueo['observacionesadeudo'];
                            $dp['mensajeprincipal'] = $bloqueo['mensajeprincipal'];

                            //Asignamos el id del documento principal cuando estan agrupadas las inscripciones
                            $subconceptoinscripcion = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $dp["subconceptoinscripcionid"]);
                            $documentoporpagar = $dbm->getOneByParametersRepositorio(
                                'CjDocumentoporpagar',
                                array(
                                    'documento' => $dp["Documento"],
                                    'alumnoid' => $dp["AlumnoId"],
                                    'subconceptoid' => $subconceptoinscripcion ? $dp["subconceptoinscripcionid"] : 0
                                )
                            );
                            $dp["DocumentoPorPagarId"] = $documentoporpagar ? $documentoporpagar->getDocumentoporpagarid() : $dp["DocumentoPorPagarId"];
                        }

                        //calcular recargo
                        $parametrorecargo = $dbm->getRepositorioById('Parametros', 'nombre', "RecargoPortalWeb");
                        $parametrorecargo = $parametrorecargo ? $parametrorecargo->getValor() : 1;
                        if ($dp['Recargo'] && $dp['RecargoPorVencimiento']  && $parametrorecargo == 1) {
                            $dp['InteresTotal'] =  round(floatval($dp['SaldoTotal']) * floatval($dp['RecargoPorVencimiento']) / 100.0, 2);
                        }

                        //Validar si hay un acuerdo
                        $documentoporpagar = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $dp["DocumentoPorPagarId"]);
                        $acuerdo = $documentoporpagar->getAcuerdoid();
                        if ($acuerdo) {
                            //Validar que el acuerdo sea vigente
                            $hoy = new \DateTime("midnight");
                            if (
                                ($hoy >= $acuerdo->getVigenciainicio()) &&
                                ($hoy <=  $acuerdo->getVigenciafin()) &&
                                ($hoy <= $documentoporpagar->getVigenciaacuerdo())
                            ) {
                                switch ($documentoporpagar->getTipoacuerdoid()->getTipoacuerdoid()) {
                                    case 1:
                                        $dp['InteresTotal'] = 0;
                                        break;
                                    case 2:
                                        break;
                                    case 3:
                                        $descuentoacuerdo = round(floatval($dp['InteresTotal']) * floatval($documentoporpagar->getPorcentaje()) / 100.0, 2);
                                        $dp['InteresTotal'] = $dp['InteresTotal'] - $descuentoacuerdo;
                                        break;
                                }
                            }
                        }

                        //Calcular el descuento
                        $parametrodescuento = $dbm->getRepositorioById('Parametros', 'nombre', "DescuentoPortalWeb");
                        $parametrodescuento = $parametrodescuento ? $parametrodescuento->getValor() : 1;
                        if ($dp["Descuento"] == "1") {
                            //Prendemos o apagamos el descuento dependiendo del parametro
                            $dp["Descuento"] = $parametrodescuento;
                            $saldoTotal = floatval($dp["SaldoTotal"]) + floatval($dp["InteresTotal"]);
                            $dp["descuentodoc"] = strval(round((($saldoTotal) * floatval($dp["DescuentoProntoPago"]) / 100.0), 2));
                        }
                    }
                }

                if (ENTORNO == 2) {
                    $documentosPorPagarOtros  = $dbm->BuscarDcocumentosOtros(["padresotutoresid" => $id, "pagoestatusid" => 1, "empresaid" => 1]);
                    foreach ($documentosPorPagarOtros as &$dp) {
                        $dp['TipoPago'] = "Otros";
                        $alumno = $dbmce->BuscarAlumnosA([
                            'alumnoid' => $dp["AlumnoId"],
                            'cicloid' => $dp["CicloId"]
                        ])[0];
                        if (!$dp['escurricular']) {
                            $bloqueo = \AppBundle\Dominio\Bloqueos::BloqueoAlumno($dbmc, array(
                                "alumnoporcicloid" => $alumno['alumnoporcicloid'],
                                "tipo" => 1,
                                "cicloid" => $alumno['cicloid']
                            ));
                            $dp['bloc'] = $bloqueo;
                            $dp['colegiaturasvencidas'] = $bloqueo['numcolegiaturas'];
                            $dp['bloqueopago'] = $bloqueo['bloqueopago'];
                            $dp['bloqueoadeudo'] = $bloqueo['bloqueoadeudo'];
                            $dp['observacionespago'] = $bloqueo['observacionespago'];
                            $dp['observacionesadeudo'] = $bloqueo['observacionesadeudo'];
                            $dp['mensajeprincipal'] = $bloqueo['mensajeprincipal'];
                        }

                    }
                    $documentosPorPagar = array_merge($documentosPorPagar, $documentosPorPagarOtros);
                }
            }

            //Otros
            if ($IsInsCol == "0" || $IsInsCol == "2") {
                foreach ($documentosPorPagar as &$dp) {
                    $alumno = $dbmce->BuscarAlumnosA(['alumnoid' => $dp["AlumnoId"], 'cicloid' => $dp["CicloId"]])[0];
                    if (!$dp['escurricular']) {
                        $bloqueo = \AppBundle\Dominio\Bloqueos::BloqueoAlumno($dbmc, array(
                            "alumnoporcicloid" => $alumno['alumnoporcicloid'],
                            "tipo" => 1,
                            "cicloid" => $alumno['cicloid']
                        ));

                        $dp['bloqueopago'] = $bloqueo['bloqueopago'];
                        $dp['bloqueoadeudo'] = $bloqueo['bloqueoadeudo'];
                        $dp['numcolegiaturas'] = $bloqueo['numcolegiaturas'];
                        $dp['observacionespago'] = $bloqueo['observacionespago'];
                        $dp['observacionesadeudo'] = $bloqueo['observacionesadeudo'];
                        $dp['mensajeprincipal'] = $bloqueo['mensajeprincipal'];
                        
                    }
                }
                if (ENTORNO == 2) {
                    $dp['TipoPago'] = "Otros";
                }
            }

            $documentosPorPagar = $dbmPL->OrdenarArreglo($documentosPorPagar, 'FechaLimite', SORT_ASC);
            return new View($documentosPorPagar, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Obtiene la lista de los documentos por pagar relacionados al alumno
     * @Rest\Get("/api/portalfamiliar/pagoenlinea/byalumno/{IsInsCol}/{id}", name="PPgetAlumnosDocumentosPorPagarByAlumnoId")
     */
    public function getAlumnosDocumentosPorPagarByAlumnoId($id, $IsInsCol)
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $DatosAlumno = $dbm->getAlumnosDocumentosPorPagarByAlumnoId($id, $IsInsCol);
            return new View($DatosAlumno, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene la lista de los documentos por pagar relacionados al alumno
     * @Rest\Get("/api/portalfamiliar/pagoenlinea/convenio/{id}", name="PPGetConvenioPagoLinea")
     */
    public function PPGetConvenioPagoLinea($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");

            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('CALL saldoacuerdo(:id)');
            $stmt->execute(array('id' => $id));
            $convenio = $stmt->fetchAll();


            return new View($convenio, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /** -- **/
    /** DOCUMENTOS PAGADOS **/
    /**
     * Obtiene la lista de los documentos por pagar relacionados al alumno
     * @Rest\Get("/api/portalfamiliar/pagoenlinea/pagados/byalumno/{id}", name="PPgetDocumentosPagadosByAlumnoId")
     */
    public function getDocumentosPagadosByAlumnoId($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $DatosAlumno = $dbm->getDocumentosPagadosByAlumnoId($id);
            return new View($DatosAlumno, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
