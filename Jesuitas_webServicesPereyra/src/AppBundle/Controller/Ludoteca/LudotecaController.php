<?php

namespace AppBundle\Controller\Ludoteca;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmLudoteca;
use AppBundle\Entity\LuContrato;
use AppBundle\Entity\LuContratopormes;
use AppBundle\Entity\CjDocumentoporpagar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmControlescolar;

/**
 * @author Mariano
 */
class LudotecaController extends FOSRestController
{
    private $DBM = false;
    private $DBMC = false;
    private static $MONTHS = [1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"];

    /**
     * Retorna arreglo de filtros iniciales
     * @Rest\Get("/api/Ludoteca/Inscripcion", name="indexLudotecaInscripcion")
     */
    public function indexLudotecaInscripcion()
    {
        try {
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('LuContratoestatus', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $tipo = $dbm->getRepositoriosById('LuTipo', 'activo', 1);

            return new View(["semestre" => $semestre, "ciclo" => $ciclo, "nivel" => $nivel, "grado" => $grado, "estatus" => $estatus, "grupo" => $grupo, "tipo" => $tipo], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de meses de ludoteca
     * @Rest\Get("/api/Ludoteca/Meses", name="getLudotecaMeses")
     */
    public function getLudotecaMeses()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $mesesespanol = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $mesesingles = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            if ($filtros["contratoid"]) {
                $cm = $dbm->getRepositoriosById("LuContratopormes", "contratoid", $filtros["contratoid"]);
                foreach ($cm as $c) {
                    $fechascontrato[] = $c->getFecha()->format('Y-m-d');
                }
            }
            $configuracion = $dbm->getOneByParametersRepositorio('LuConfiguracion', ['nivelid' => $filtros["nivelid"], 'tipoid' => 4]);
            if (!$configuracion) {
                return new View("No se ha realizada la configuración de fechas para los contratos", Response::HTTP_PARTIAL_CONTENT);
            }
            $inicio = $configuracion->getFechainicio();
            $fin = $configuracion->getFechafin();

            $mes = $inicio;
            while ($mes <= $fin) {
                if (array_search($mes->format('Y-m-01'), $fechascontrato) === false) {
                    $checked = false;
                } else {
                    $checked = true;
                }
                $cm = $dbm->getOneByParametersRepositorio("LuContratopormes", ["contratoid" => $filtros["contratoid"], "fecha" => new \DateTime($mes->format('Y-m-01'))]);
                if ($cm) {
                    $dp = $cm->getDocumentoporpagarid();
                    $hoy = new \DateTime();
                    if ($dp->getPagoestatusid()->getPagoestatusid() == 1) {
                        if ($dp->getFechalimitepago() < $hoy) {
                            $estatus = "Vencido";
                            $disabled = true;
                        } else {
                            $estatus = "Pendiente";
                            $disabled = false;
                        }
                    }else {
                        $estatus = $dp->getPagoestatusid()->getNombre();
                        $disabled = true;
                    }
                } else {
                    $estatus = "";
                    $disabled = false;
                }

                $meses[] = ["fecha" => $mes->format('Y-m-01'), "mes" => str_replace($mesesingles, $mesesespanol, $mes->format("F")) . " " . $mes->format("Y"), "checked" => $checked, "estatus" => $estatus, "disabled" => $disabled];
                $mes = date_add($mes, date_interval_create_from_date_string('1 month'));
            }
            return new View($meses, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de contratos de ludoteca
     * @Rest\Post("/api/Ludoteca/Inscripcion/Filtrar", name="getLudotecaInscripcion")
     */
    public function getLudotecaInscripcion()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $filtros = json_decode($content, true);
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $contratos = $dbm->BuscarContratos($filtros);
            if (!$contratos) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            $mesesespanol = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $mesesingles = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            foreach ($contratos as $key => $contrato) {
                $contratos[$key]["alumno"] = [
                    "apellidopaterno" => $contrato["apellidopaterno"],
                    "apellidomaterno" => $contrato["apellidomaterno"],
                    "primernombre" => $contrato["primernombre"],
                    "segundonombre" => $contrato["segundonombre"],
                    "nivel" => $contrato["nivel"],
                    "grado" => $contrato["grado"]
                ];
                $mes = null;
                if (isset($contrato["fecha"])) {
                    $mes = str_replace($mesesingles, $mesesespanol, $contrato["fecha"]->format("F"));
                    $numeromes = $contrato["fecha"]->format("n");
                    $fecha = $contrato["fecha"]->format("Y-m-d");
                }
                foreach ($contratos as $name => $info) {
                    $contratokey = false;
                    if ($info["contratoid"] == $contrato["id"]) {
                        $contratokey = $name;
                        break;
                    }
                }
                if ($contratokey === false) {
                    unset($contratos[$key]["id"]);
                    $contratos[$key]["contratoid"] = $contrato["id"];
                    $contratos[$key]["meses"] = [];
                    $contratos[$key]["fechas"] = [];
                    $llave = $key;
                } else {
                    $llave = $contratokey;
                    unset($contratos[$key]);
                }
                $contratos[$llave]["meses"][$numeromes] = $mes;
                array_push($contratos[$llave]["fechas"], $fecha);
            }

            foreach ($contratos as $key => $contrato) {
                ksort($contratos[$key]["meses"]);
                $contratos[$key]["meses"] = array_values($contratos[$key]["meses"]);
                $contratos[$key]["adeudo"] = "$" . number_format($contratos[$key]["adeudo"], 2);
            }
            $contratos = array_values($contratos);

            return new View($contratos, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Guarda un contrato de ludoteca
     * @Rest\Post("/api/Ludoteca/Inscripcion", name="saveLudotecaInscripcion")
     */
    public function saveLudotecaInscripcion()
    {
        try {
            $instituto = ENTORNO;
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $dbmC = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $tipoid = $data['tipoid'];
            $diaLimitePago = "t";
            if ($instituto == 1) {
                $diaLimitePago = "10";
            }

            $contratos = $dbm->BuscarContratos(["matricula" => $data["matricula"], "tipoid" => $data["tipoid"]]);
            if ($contratos) {
                return new View("Ya existe un contrato de ludoteca del mismo tipo para este alumno.", Response::HTTP_PARTIAL_CONTENT);
            }

            $cicloactual = $dbm->getRepositorioById("Ciclo", "actual", 1);
            $alumno = $dbm->getRepositorioById("CeAlumno", "matricula", $data["matricula"]);
            $al = $dbmC->BuscarAlumnosA([
                'alumnoid' => $alumno->getAlumnoid()
            ])[0];

            $parametro = $this->getParametroByTipoId($tipoid);
            if ($parametro === false) {
                return new View("Tipo de ludoteca/guarderia invalido.", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $contrato = new LuContrato();
            $contrato->setAlumnoid($alumno);
            $contrato->setContratoestatusid($dbm->getRepositorioById("LuContratoestatus", "contratoestatusid", 1));
            $contrato->setTipoid($dbm->getRepositorioById("LuTipo", "tipoid", $tipoid));
            $fecha = new \DateTime();
            $contrato->setFechaalta($fecha);
            $dbm->saveRepositorio($contrato);
            foreach ($data["meses"] as $mes) {
                $mesdate = new \DateTime($mes);
                $mesNombre = $this->getMonthNameByDate($mesdate);
                $saldomes = $this->getSaldoByTipoDate($tipoid, $mesdate);
                $fechalimite = new \DateTime(date("Y-m-{$diaLimitePago}", strtotime($mes)));
                $documentoNombre = "";
                if ($instituto == 1) {
                    $documentoNombre = $fechalimite->format("Ym") . "G";
                }
                if ($saldomes === false) {
                    $dbm->getConnection()->rollBack();
                    return new View("No es posible generar el contrato debido a que el importe es 0 para alguno de los meses seleccionados.", Response::HTTP_PARTIAL_CONTENT);
                }
                $subconcepto = $dbm->getRepositorioById("CjSubconcepto", "subconceptoid", $dbm->getRepositorioById("Parametros", "nombre", $parametro)->getValor());
                $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                $documento = $dbm->getRepositorioById('CjDocumento', 'tipodocumento', $tipodocumento->getValor());
                $documentoporpagar = new CjDocumentoporpagar();
                $documentoporpagar->setDocumentoid($documento);
                $documentoporpagar->setSubconceptoid($subconcepto);
                $documentoporpagar->setPagoestatusid($dbm->getRepositorioById("CjPagoestatus", "pagoestatusid", 1));
                $documentoporpagar->setAlumnoid($contrato->getAlumnoid());
                $documentoporpagar->setCicloid($cicloactual);
                $documentoporpagar->setGradoid($dbm->getRepositorioById("Grado", "gradoid", $al['gradoid']));
                $documentoporpagar->setImporte($saldomes); //$subconcepto->getImporte());
                $documentoporpagar->setSaldo($saldomes); //$subconcepto->getImporte());
                $documentoporpagar->setConcepto($subconcepto->getNombre() . " $mesNombre");
                $documentoporpagar->setFechalimitepago($fechalimite);
                $documentoporpagar->setFechacreacion($fecha);
                $documentoporpagar->setFechaprontopago($fecha);
                $documentoporpagar->setDocumento($documentoNombre);
                $dbm->saveRepositorio($documentoporpagar);

                $contratopormes = new LuContratopormes();
                $contratopormes->setContratoid($contrato);
                $contratopormes->setFecha($mesdate);
                $contratopormes->setContratoestatuspagoid($dbm->getRepositorioById("LuContratoestatuspago", "contratoestatuspagoid", 1));
                $contratopormes->setDocumentoporpagarid($documentoporpagar);
                $dbm->saveRepositorio($contratopormes);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro.", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un contrato de ludoteca
     * @Rest\Put("/api/Ludoteca/Inscripcion/{contratoid}", name="updateLudotecaInscripcion")
     */
    public function updateLudotecaInscripcion($contratoid)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmLudoteca($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $tipoid = $data['tipoid'];

            $contrato = $dbm->getRepositorioById("LuContrato", "contratoid", $contratoid);
            $cicloactual = $dbm->getRepositorioById("Ciclo", "actual", 1);
            $grado = $dbm->getOneByParametersRepositorio("CeAlumnoporciclo", ["alumnoid" => $contrato->getAlumnoid()->getAlumnoid(), "cicloid" => $cicloactual->getCicloid()]);
            $mesesespanol = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $mesesingles = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");


            if ($data["contratoestatusid"] == 2) {
                $contratosmes = $dbm->getRepositoriosById("LuContratopormes", "contratoid", $contratoid);
                foreach ($contratosmes as $cm) {
                    $dp = $cm->getDocumentoporpagarid();
                    $hoy = new \DateTime();
                    if ($dp->getPagoestatusid()->getPagoestatusid() == 1) {
                        if ($dp->getFechalimitepago() < $hoy) {
                            return new View("No se puede dar de baja el contrato debido a que tiene documentos por pagar pagados y/o vencidos.", Response::HTTP_PARTIAL_CONTENT);
                        }
                    }
                    if ($dp->getPagoestatusid()->getPagoestatusid() == 2) {
                        return new View("No se puede dar de baja el contrato debido a que tiene documentos por pagar pagados y/o vencidos.", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }


            $dbm->getConnection()->beginTransaction();

            $contrato->setContratoestatusid($dbm->getRepositorioById("LuContratoestatus", "contratoestatusid", $data["contratoestatusid"]));
            $contrato->setMotivocancelacion($data["motivocancelacion"]);
            if ($data["contratoestatusid"] == 2) {
                $contrato->setFechabaja(new \DateTime());
            }
            $dbm->saveRepositorio($contrato);
            $fecha = new \DateTime();

            if ($data["contratoestatusid"] == 1) {
                $contratos = $dbm->BuscarContratos(["cicloid" => $cicloactual->getCicloid(), "contratoid" => $contratoid]);
                foreach ($contratos as $cm) {
                    foreach ($data["meses"] as $name => $info) {
                        $fechakey = false;
                        if ($cm["fecha"]->format('Y-m-d') == $info) {
                            $fechakey = $name;
                            break;
                        }
                    }
                    if ($fechakey === false) {
                        $dbm->removeRepositorio($dbm->getOneByParametersRepositorio("LuContratopormes", ["contratoid" => $contratoid, "fecha" => $cm["fecha"]]));
                    } elseif (empty($data["meses"])) {
                        $dbm->removeRepositorio($cm);
                    }
                }

                $contratospormes = $dbm->getRepositoriosById("LuContratopormes", "contratoid", $contratoid);
                foreach ($contratospormes as $cm) {
                    $mes = $cm->getFecha()->format('Y-m-d');
                    if (!in_array($mes, $data["meses"])) {
                        if ($cm->getDocumentoporpagarid()->getPagoestatusid()->getPagoestatusid() == 1 && $cm->getDocumentoporpagarid()->getFechalimitepago() > $fecha) {
                            $dbm->removeRepositorio($cm);
                            $dbm->removeRepositorio($cm->getDocumentoporpagarid());
                        }
                    }
                }

                $parametro = $this->getParametroByTipoId($tipoid);
                if ($parametro === false) {
                    return new View("Tipo de ludoteca/guarderia invalido.", Response::HTTP_PARTIAL_CONTENT);
                }
                foreach ($data["meses"] as $mes) {
                    $mesdate = new \DateTime($mes);
                    $cm = $dbm->getOneByParametersRepositorio("LuContratopormes", ["contratoid" => $contratoid, "fecha" => $mesdate]);
                    if (!$cm) {
                        $mesNombre = $this->getMonthNameByDate($mesdate);
                        $fechalimite = new \DateTime(date("Y-m-t", strtotime($mes)));
                        $saldomes = $this->getSaldoByTipoDate($tipoid, $mesdate);
                        if ($saldomes === false) {
                            $dbm->getConnection()->rollBack();
                            return new View("No es posible generar el contrato debido a que el importe es 0 para alguno de los meses seleccionados.", Response::HTTP_PARTIAL_CONTENT);
                        }
                        $subconcepto = $dbm->getRepositorioById("CjSubconcepto", "subconceptoid", $dbm->getRepositorioById("Parametros", "nombre", $parametro)->getValor());
                        $documentoporpagar = new CjDocumentoporpagar();
                        $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                        $documento = $dbm->getRepositorioById('CjDocumento', 'tipodocumento', $tipodocumento->getValor());
                        $documentoporpagar->setDocumentoid($documento);
                        $documentoporpagar->setSubconceptoid($subconcepto);
                        $documentoporpagar->setPagoestatusid($dbm->getRepositorioById("CjPagoestatus", "pagoestatusid", 1));
                        $documentoporpagar->setAlumnoid($contrato->getAlumnoid());
                        $documentoporpagar->setCicloid($cicloactual);
                        $documentoporpagar->setGradoid($grado->getGradoid());
                        $documentoporpagar->setImporte($saldomes); //$subconcepto->getImporte());
                        $documentoporpagar->setSaldo($saldomes); //$subconcepto->getImporte());
                        $documentoporpagar->setConcepto($subconcepto->getNombre() . " $mesNombre");
                        $documentoporpagar->setFechalimitepago($fechalimite);
                        $documentoporpagar->setFechacreacion($fecha);
                        $documentoporpagar->setFechaprontopago($fecha);
                        $dbm->saveRepositorio($documentoporpagar);

                        $contratopormes = new LuContratopormes();
                        $contratopormes->setContratoid($contrato);
                        $contratopormes->setFecha($mesdate);
                        $contratopormes->setContratoestatuspagoid($dbm->getRepositorioById("LuContratoestatuspago", "contratoestatuspagoid", 1));
                        $contratopormes->setDocumentoporpagarid($documentoporpagar);
                        $dbm->saveRepositorio($contratopormes);
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro.", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    private function getSaldoByTipoDate($tipoid, $date)
    {
        $mesid = $this->getMonthNumberByDate($date);
        $dbm = $this->getDM();
        $data = $dbm->getRepositoriosModelo("LuImportepormesportipo", ["d.importe"], ["tipoid" => $tipoid, "mes" => $mesid]);
        if ($data && sizeof($data) > 0) {
            $importe = $data[0]['importe'];
            if ($importe > 0) {
                return $importe;
            }
        }
        return false;
    }
    private function getMonthNameByDate($date)
    {
        return LudotecaController::$MONTHS[$this->getMonthNumberByDate($date)];
    }
    private function getMonthNumberByDate($date)
    {
        return ((int) $date->format("m"));
    }
    private function getParametroByTipoId($tipoid)
    {
        switch ($tipoid) {
            case 1:
                return "LudotecaContratoSubconceptoMatutino";
            case 2:
                return "LudotecaContratoSubconceptoVespertino";
            case 3:
                return "LudotecaContratoSubconceptoDeportes";
        }
        return false;
    }
    private function getDM()
    {
        if ($this->DBM) {
            return $this->DBM;
        }
        $this->DBM = new DbmLudoteca($this->get("db_manager")->getEntityManager());
        return $this->DBM;
    }
    private function getDMC()
    {
        if ($this->DBMC) {
            return $this->DBMC;
        }
        $this->DBMC = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        return $this->DBMC;
    }
}
