<?php

namespace AppBundle\Controller\Becas\Modal;

use AppBundle\Controller\lib\Enums\EstatusPropiedad;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use AppBundle\Entity\BcArchivosituacioneconomica;
use AppBundle\Entity\BcDeudascreditos;
use AppBundle\Entity\BcIngresosfamiliares;
use AppBundle\Entity\BcPropiedadesfamiliares;
use AppBundle\Entity\BcSituacionfamiliar;
use AppBundle\Entity\BcVehiculos;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Icicle\Awaitable;
use Icicle\Coroutine\Coroutine;
use Icicle\Loop;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: rubén
 */
class EstudioSocioeconomicoController extends FOSRestController
{

    /**
     * regresa hijos que se seleccionaron en la solciitud para tramitarles becas
     * @Rest\Post("/api/SolicitudBeca/solicitudbecahijos", name="solicitudhijos")
     */
    public function solicitudhijos()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded["solicitudid"]);
            $parambecas = $dbm->getRepositorioById("Parametros", "nombre", "ModoPagoBecas");

            $entidad = $dbm->Buscaralumnoporfamlia(["clavefamiliarid" => $solicitud->getClavefamiliarid()->getClavefamiliarid()], intval($parambecas->getValor()));
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            $hijos = array();
            foreach ($entidad as &$alumno) {
                $solicitudbecaporalumno = $dbm->getOneByParametersRepositorio("BcSolicitudporalumno",["alumnoid" => $alumno["alumnoid"],"solicitudid" => $decoded["solicitudid"] ]);
                if(!$solicitudbecaporalumno){
                    continue;
                }
                $alumno["alumnosolicitudid"] = $solicitudbecaporalumno->getAlumnosolicitudid();
                $becarecomendada = $dbm->getRepositorioById("BcBecarecomendadaporalumno", "alumnosolicitudid", $solicitudbecaporalumno);
                $alumno["becarecomendada"] = $becarecomendada ? $becarecomendada->getBecarecomendada() : null;

                $alumno["historial"]= $dbm->Buscarhistorialhijos(array("alumnoid" => $alumno["alumnoid"]));
                $alumno["nuevasbecas"] = $dbm->Buscarnuevasbecas(array("alumnoid" => $alumno["alumnoid"], "solicitudid" => $decoded["solicitudid"]));
                $alumno["observaciones"] = $dbm->getRepositorioById("BcSolicitudbecadictamen", "solicitudid", $decoded["solicitudid"]);   
                array_push($hijos,$alumno);             
            }

            return new View($hijos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el resultado que coincida con el ID enviado de Vehículos
     * @Rest\Get("/api/Becas/SolicitudBeca/SituacionEconomica/ObtenerInformacionFamiliar/{id}", name="ObtenerInformacionFamiliar")
     */
    public function ObtenerInformacionFamiliar($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $datosfamilia = $dbm->getRepositoriosById('BcSolicitudfamilia', 'solicitudid', $id);
            $ingresosegresos = $dbm->getRepositoriosById('BcSolicitudingresos', 'solicitudid', $id);
            $observaciones = $dbm->getRepositoriosById('BcObservacionesestudiose', 'solicitudid', $id);

            $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $id);
            $cf = $dbm->getRepositoriosById("CeAlumnoporclavefamiliar", "clavefamiliarid", $solicitud->getClavefamiliarid());
            $alumnosidec = count($cf);

            $resultadodatosfamilia = [];
            foreach ($datosfamilia as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudid(null);
                    if (!$valor->getAlumnosidec()) {
                        $valor->setAlumnosidec($alumnosidec);
                    }
                }
                array_push($resultadodatosfamilia, $valor);
            }

            if (!$resultadodatosfamilia) {
                $resultadodatosfamilia = array("alumnosidec" => $alumnosidec);
            }

            $resultadoingresosegresos = [];
            foreach ($ingresosegresos as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudid(null);
                }

                array_push($resultadoingresosegresos, $valor);
            }

            $resultadoobservaciones = [];
            foreach ($observaciones as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudid(null);
                }

                array_push($resultadoobservaciones, $valor);
            }

            $informacionfamiliar = array(
                "datosfamilia" => $resultadodatosfamilia,
                "ingresosegresos" => $resultadoingresosegresos,
                "obervaciones" => $resultadoobservaciones,
            );

            return new View(array("informacionfamiliar" => $informacionfamiliar), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Adjunta el archivo de estudio socioeconomico
     * @Rest\Post("/api/Becas/SolicitudBeca/ArchivoSE" , name="GuardarArchivoSE")
     */
    public function GuardarArchivoSE()
    {
        try {
            if ($_REQUEST['archivo']['error'] == 1) {
                return new View(
                    "El archivo excede el peso permitido ",
                    Response::HTTP_PARTIAL_CONTENT
                );
            }
            $fs = $_REQUEST['archivo'];
            $data = $_REQUEST;
            $encoded = json_encode($data);
            //$content = trim(file_get_contents("php://input"));
            $decoded = json_decode($encoded, true);
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $archivo = $dbm->getRepositorioById("BcArchivosituacioneconomica", "solicitudid", $decoded['solicitudid']);
            if (!$archivo) {
                $archivo = new BcArchivosituacioneconomica();
                $archivo->setSolicitudid($dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']));
            }

            $archivo->setNombrearchivo($fs['filename']);
            $archivo->setArchivo($fs['value']);
            $archivo->setArchivotipo($fs['filetype']);
            $archivo->setArchivosize($fs['size']);
            $archivo->setActivo(1);
            $dbm->saveRepositorio($archivo);

            $dbm->getConnection()->commit();

            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo de estudio socieconomico
     * @Rest\Get("/api/Becas/SolicitudBeca/ArchivoSE/{solicitudid}", name="DescargarArchivoSE")
     */
    public function DescargarArchivoSE($solicitudid)
    {
        try {
            $dbm = $this->get("db_manager");
            $archivo = $dbm->getRepositorioById('BcArchivosituacioneconomica', 'solicitudid', $solicitudid);
            if (!$archivo) {
                return new View("No se ha guardado un archivo de situación económica.", Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                base64_decode(stream_get_contents($archivo->getArchivo())), 200, array(
                    'Content-Type' => $archivo->getArchivotipo(),
                    'Content-Length' => $archivo->getArchivosize())
            );
            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * beca recomenda para cada alumno que solicita
     * @Rest\Post("/api/SolicitudBeca/GuardarBecaRecomendada", name="becarecomendada")
     */
    public function becarecomendada()
    {

        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $dbm->getConnection()->beginTransaction();

            $brecomendadaporalumno = $dbm->getRepositorioById('BcBecarecomendadaporalumno', 'alumnosolicitudid', $decoded['alumnosolicitudid']);
            if (empty($brecomendadaporalumno)) {
                $entity = $hydrator->hydrate('AppBundle\Entity\BcBecarecomendadaporalumno', $decoded);
                $dbm->saveRepositorio($entity);
                $dbm->getConnection()->commit();

            } else {
                $brecomendadaporalumno->setBecarecomendada($decoded["becarecomendada"]);
                $dbm->saveRepositorio($brecomendadaporalumno);
                $dbm->getConnection()->commit();

            }

            return new View("Se han guardado tutores", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Método para guardar la solicitud familiar, los ingresos y el estudio socieconomico de una solicitud
     * @Rest\Post("/api/Becas/SolicitudBeca/Estudiose", name="GuardarEstudiose")
     */
    public function GuardarEstudiose()
    {
        try {
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            // SOLICITUD FAMILIA
            $datosfamiliaentidad = $hydrator->hydrate('AppBundle\Entity\BcSolicitudfamilia', $decoded["Formsocioeconomico"]);

            $datosfamilia = $dbm->getRepositorioById('BcSolicitudfamilia', 'solicitudid', $decoded['solicitudid']);

            if (empty($datosfamilia)) {
                if (is_a($datosfamiliaentidad, 'AppBundle\Entity\BcSolicitudfamilia')) {
                    $datosfamiliaentidad->setSolicitudid($dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']));
                    $dbm->saveRepositorio($datosfamiliaentidad);
                } else {
                    return new View("Parámetros de entrada no coinciden con la entidad", Response::HTTP_BAD_REQUEST);
                }
            } else {
                $estatuspropiedad = $dbm->getRepositorioById('BcEstatuspropiedad', 'estatusid', $decoded["Formsocioeconomico"]["estatuspropiedadid"]);
                if (empty($estatuspropiedad)) {
                    return new View("Parámetros de entrada no coinciden con la entidad", Response::HTTP_BAD_REQUEST);
                } else {
                    $datosfamilia->setAlumnosidec($decoded["Formsocioeconomico"]['alumnosidec']);
                    $datosfamilia->setEstudiantestotales($decoded["Formsocioeconomico"]['estudiantestotales']);
                    $datosfamilia->setMiembrosfamilia($decoded["Formsocioeconomico"]['miembrosfamilia']);
                    $datosfamilia->setVivefamilia($dbm->getRepositorioById("BcEstatusfamilia", "estatusfamiliaid", $decoded["Formsocioeconomico"]['vivefamilia']));
                    $datosfamilia->setEstatuspropiedadid($estatuspropiedad);
                    $dbm->saveRepositorio($datosfamilia);
                }
            }

            // INGRESOS
            $ingresosegresosentidad = $hydrator->hydrate('AppBundle\Entity\BcSolicitudingresos', $decoded["Formingresos"]);

            $ingresosegresos = $dbm->getRepositorioById('BcSolicitudingresos', 'solicitudingresosid', $decoded["Formingresos"]['solicitudingresosid']);

            if (empty($ingresosegresos)) {
                if (is_a($ingresosegresosentidad, 'AppBundle\Entity\BcSolicitudingresos')) {
                    $ingresosegresosentidad->setSolicitudid($dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']));
                    $dbm->saveRepositorio($ingresosegresosentidad);
                } else {
                    return new View("Parámetros de entrada no coinciden con la entidad", Response::HTTP_BAD_REQUEST);
                }
            } else {
                $ingresosegresos->setIngresos($decoded["Formingresos"]['ingresos']);
                $ingresosegresos->setEgresos($decoded["Formingresos"]['egresos']);
                $dbm->saveRepositorio($ingresosegresos);
            }

            // ESTUDIO SOCIOECONOMICO
            $entity = $hydrator->hydrate('AppBundle\Entity\BcObservacionesestudiose', $decoded["formobservacion"]);
            $obs = $dbm->getRepositorioById('BcObservacionesestudiose', 'observaionesestudioseid', $decoded["formobservacion"]["observaionesestudioseid"]);
            if (empty($obs)) {
                $entity->setSolicitudid($dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']));
                $dbm->saveRepositorio($entity);
            } else {
                $obs->setObservaciones($decoded["formobservacion"]["observaciones"]);
                $dbm->saveRepositorio($obs);
            }

            $dbm->getConnection()->commit();
            return new View("Registro procesado de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * CAMBIO DE ESTATUS DE LA SOLICITUD
     * @Rest\Post("/api/SolicitudBeca/estatus/cambiar", name="cambiarstatussolicitud")
     */
    public function cambiarstatussolicitud()
    {
        try {
            // $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = $this->get("db_manager");
            $solicitudporalumno = $dbm->getRepositoriosById('BcSolicitudporalumno', 'solicitudid', $decoded['solicitudid']);
            // $solicitud = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $decoded['solicitudid']);
            $estatus = $dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', $decoded['estatusid']);

            if (empty($solicitudporalumno) || empty($estatus)) {
                return new View("Registros no encontrados", Response::HTTP_BAD_REQUEST);
            } else {
                $dbm->getConnection()->beginTransaction();
                foreach ($solicitudporalumno as $sa) {
                    if ($sa->getEstatusid()->getEstatusid() != 7 && $sa->getEstatusid()->getEstatusid() != 6 && $sa->getEstatusid()->getEstatusid() != 5) {
                        $sa->setEstatusid($estatus);
                        $dbm->saveRepositorio($sa);
                    }
                }
                $dbm->getConnection()->commit();
                return new View($solicitudporalumno, Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo layout
     *  @Rest\POST("/api/Becas/SolicitudBeca/SituacionEconomica/importarlayaoutestudiose" , name="importarlayaoutestudiose")
     */
    public function importarlayaoutestudiose()
    {
        try {
            if ($_FILES['layout']['error'] == 1) {
                return new View(
                    "El archivo excede el peso permitido ",
                    Response::HTTP_PARTIAL_CONTENT
                );
            }
            $dbm = $this->get("db_manager");
            $iniPrecision = ini_get('precision');
            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($_FILES['layout']['tmp_name']);
            ini_set('precision', $iniPrecision);

            $phpExcelObject->setActiveSheetIndex(0);
            $sheetsituacion = $phpExcelObject->getActiveSheet();
            $phpExcelObject->getProperties();
            //$pagemax = $sheetsituacion->getHighestDataRow();
            $situacioneconomica = $sheetsituacion->rangeToArray('A2:' . $sheetsituacion->getHighestDataColumn() . $sheetsituacion->getHighestDataRow(), null, true, true, true);
            $Preguntassituacioneconomica = $sheetsituacion->rangeToArray('A1:' . $sheetsituacion->getHighestDataColumn() . '1', null, true, true, true);

            $phpExcelObject->setActiveSheetIndex(1);
            $sheetvehiculos = $phpExcelObject->getActiveSheet();
            $phpExcelObject->getProperties();
            //$pagemax = $sheetpropiedades->getHighestDataRow();
            $vehiculos = $sheetvehiculos->rangeToArray('A2:' . $sheetvehiculos->getHighestDataColumn() . $sheetvehiculos->getHighestDataRow(), null, true, true, true);
            $Preguntasvehiculos = $sheetvehiculos->rangeToArray('A1:' . $sheetvehiculos->getHighestDataColumn() . '1', null, true, true, true);

            $phpExcelObject->setActiveSheetIndex(2);
            $sheetdeudas = $phpExcelObject->getActiveSheet();
            $phpExcelObject->getProperties();
            //$pagemax = $sheetpropiedades->getHighestDataRow();
            $deudas = $sheetdeudas->rangeToArray('A2:' . $sheetdeudas->getHighestDataColumn() . $sheetdeudas->getHighestDataRow(), null, true, true, true);
            $Preguntasdeudas = $sheetdeudas->rangeToArray('A1:' . $sheetdeudas->getHighestDataColumn() . '1', null, true, true, true);

            $phpExcelObject->setActiveSheetIndex(3);
            $sheetpropiedades = $phpExcelObject->getActiveSheet();
            $phpExcelObject->getProperties();
            //$pagemax = $sheetpropiedades->getHighestDataRow();
            $propiedades = $sheetpropiedades->rangeToArray('A2:' . $sheetpropiedades->getHighestDataColumn() . $sheetpropiedades->getHighestDataRow(), null, true, true, true);
            $Preguntaspropiedades = $sheetpropiedades->rangeToArray('A1:' . $sheetpropiedades->getHighestDataColumn() . '1', null, true, true, true);

            $valor = "";
            $guardar = function () use (
                $situacioneconomica,
                $Preguntassituacioneconomica,
                $propiedades,
                $Preguntaspropiedades,
                $vehiculos,
                $Preguntasvehiculos,
                $deudas,
                $Preguntasdeudas
            ) {
                try {
                    $dbm = $this->get("db_manager");
                    $dbm->getConnection()->beginTransaction();
                    yield Awaitable\resolve(self::insertarLayoutSituacionEconomica($situacioneconomica, $Preguntassituacioneconomica));
                    yield Awaitable\resolve(self::insertarLayoutPorpiedades($propiedades, $Preguntaspropiedades));
                    yield Awaitable\resolve(self::insertarLayoutVehiculos($vehiculos, $Preguntasvehiculos));
                    yield Awaitable\resolve(self::insertarLayoutDeudas($deudas, $Preguntasdeudas));
                    $dbm->getConnection()->commit();
                } catch (\Exception $e) {
                    $dbm->getConnection()->rollBack();
                }
            };

            $routine = new Coroutine($guardar());
            Loop\Run();

            $totalregistros = sizeof($situacioneconomica) + sizeof($propiedades) + sizeof($vehiculos) + sizeof($deudas);

            return new View("Se proceso correctamente el archivo. " . $totalregistros . " registros fueron importados.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function insertarLayoutDeudas($deudas, $Preguntasdeudas)
    {
        $dbm = $this->get("db_manager");
        foreach ($deudas as $row => $s) {
            if (empty($s['A'])) {
                throw new \Exception("El contenido del archivo no es el correcto");
            } else {
                $solicitudbeca = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $s['A']);
                if (empty($solicitudbeca)) {
                    throw new \Exception("El contenido del archivo no es el correcto, falta el folio de la solicitud");
                } else {
                    $dc = $dbm->getByParametersRepositorios("BcDeudascreditos", array(
                        "solicitudid" => $s['A'],
                        "bancoinstitucion" => $s['C'],
                        "importetotal" => $s['B'],
                        "pagomensual" => $s['D'],
                        "tipocreditoid" => $s['E'],
                        "limitecredito" => $s['F'],
                    ));
                    if ($dc) {
                        $deudascreditos = $dc[0];
                    } else {
                        $deudascreditos = new BcDeudascreditos();
                    }
                    $deudascreditos->setSolicitudid($solicitudbeca);
                    $deudascreditos->setBancoinstitucion($s['C']);
                    $deudascreditos->setImportetotal($s['B']);
                    $deudascreditos->setPagomensual($s['D']);
                    $t = $dbm->getRepositorioById('BcTipocredito', 'tipocreditoid', $s['E']);
                    $deudascreditos->setTipocreditoid($t);
                    $deudascreditos->setLimitecredito($s['F']);
                    $dbm->saveRepositorio($deudascreditos);
                }
            }
        }
    }

    public function insertarLayoutVehiculos($vehiculos, $Preguntasvehiculos)
    {
        $dbm = $this->get("db_manager");
        foreach ($vehiculos as $row => $s) {
            if (empty($s['A'])) {
                throw new \Exception("El contenido del archivo no es el correcto");
            } else {
                $solicitudbeca = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $s['A']);
                if (empty($solicitudbeca)) {
                    throw new \Exception("El contenido del archivo no es el correcto, falta el folio de la solicitud");
                } else {
                    $v = $dbm->getByParametersRepositorios("BcVehiculos", array(
                        "solicitudid" => $s['A'],
                        "marcamodelo" => $s['B'],
                        "anio" => $s['C'],
                        "tarjetacirculacion" => $s['D'],
                        "estatus" => $s['E'],
                    ));
                    if ($v) {
                        $vehiculo = $v[0];
                    } else {
                        $vehiculo = new BcVehiculos();
                    }
                    $vehiculo->setSolicitudid($solicitudbeca);
                    $vehiculo->setMarcamodelo($s['B']);
                    $vehiculo->setAnio($s['C']);
                    $vehiculo->setTarjetacirculacion($s['D']);
                    $v = $dbm->getRepositorioById('BcEstatusvehiculos', 'idestatusvehiculo', $s['E']);
                    $vehiculo->setEstatus($v);
                    $dbm->saveRepositorio($vehiculo);
                }
            }
        }
    }

    public function insertarLayoutSituacionEconomica($situacioneconomica, $Preguntassituacioneconomica)
    {
        $dbm = $this->get("db_manager");
        //$val2=$situacioneconomica[2]['A'];
        foreach ($situacioneconomica as $row => $s) {
            $v1 = $s['A'];

            if (empty($s['A'])) {
                throw new \Exception("El contenido del archivo no es el correcto");
            } else {
                //$val2=$situacioneconomica[2]['G'];
                $solicitudbeca = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $v1);
                if (empty($solicitudbeca)) {
                    throw new \Exception("El contenido del archivo no es el correcto, falta el folio de la solicitud");
                } else {
                    $sf = $dbm->getByParametersRepositorios("BcSituacionfamiliar", array(
                        "solicitudid" => $s['A'],
                        "descripcionsituacionfamiliar" => $s['G'],
                    ));
                    if ($sf) {
                        $situacionfamiliar = $sf[0];
                    } else {
                        $situacionfamiliar = new BcSituacionfamiliar();
                    }
                    $situacionfamiliar->setSolicitudid($solicitudbeca);
                    $situacionfamiliar->setDescripcionsituacionfamiliar($s['G']);
                    $dbm->saveRepositorio($situacionfamiliar);

                    $if = $dbm->getByParametersRepositorios("BcIngresosfamiliares", array(
                        "solicitudid" => $s['A'],
                        "ingresospadre" => $s['B'],
                        "ingresosmadre" => $s['C'],
                        "otrosfamiliares" => $s['D'],
                        "otrosingresos" => $s['E'],
                        "egresosfamiliares" => $s['F'],
                    ));
                    if ($if) {
                        $ingresofamiliar = $if[0];
                    } else {
                        $ingresofamiliar = new BcIngresosfamiliares();
                    }
                    $ingresofamiliar->setSolicitudid($solicitudbeca);
                    $ingresofamiliar->setIngresospadre($s['B']);
                    $ingresofamiliar->setIngresosmadre($s['C']);
                    $ingresofamiliar->setOtrosfamiliares($s['D']);
                    $ingresofamiliar->setOtrosingresos($s['E']);
                    $ingresofamiliar->setEgresosfamiliares($s['F']);
                    $dbm->saveRepositorio($ingresofamiliar);
                }
            }
        }
    }

    public function insertarLayoutPorpiedades($propiedades, $Preguntaspropiedades)
    {
        $dbm = $this->get("db_manager");
        foreach ($propiedades as $row => $s) {
            if (empty($s['A'])) {
                throw new \Exception("El contenido del archivo no es el correcto");
            } else {
                $solicitudbeca = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $s['A']);
                switch ($s['C']) {
                    case EstatusPropiedad::Propio:
                        break;
                    case EstatusPropiedad::Rentado:
                        break;
                    case EstatusPropiedad::Prestado:
                        break;
                    case EstatusPropiedad::Hipotecado:
                        break;
                    default:
                        throw new \Exception("El contenido del archivo no es el correcto, indique con (1, 2, 3 ó 4) el campo 'Estatus' en la sección de Propiedades");
                }
                $estatuspropiedad = $dbm->getRepositorioById('BcEstatuspropiedad', 'estatusid', $s['C']);
                if (empty($solicitudbeca) || empty($estatuspropiedad)) {
                    throw new \Exception("El contenido del archivo no es el correcto, falta el folio de la solicitud");
                } else {
                    $pf = $dbm->getByParametersRepositorios("BcPropiedadesfamiliares", array(
                        "solicitudid" => $s['A'],
                        "tipopropiedad" => $s['B'],
                        "estatusid" => $s['C'],
                        "valoraproximado" => $s['D'],
                        "creditoanombrede" => $s['E'],
                        "propiedadanombrede" => $s['J'],
                        "domicilioactual" => $s['F'],
                        "mtsterreno" => $s['G'],
                        "mtsconstruccion" => $s['H'],
                        "ubicacion" => $s['I'],
                    ));
                    if ($pf) {
                        $propiedadesfamiliares = $pf[0];
                    } else {
                        $propiedadesfamiliares = new BcPropiedadesfamiliares();
                    }
                    $propiedadesfamiliares->setSolicitudid($solicitudbeca);
                    $propiedadesfamiliares->setTipopropiedad($s['B']);
                    $propiedadesfamiliares->setEstatusid($estatuspropiedad);
                    $propiedadesfamiliares->setValoraproximado($s['D']);
                    $propiedadesfamiliares->setCreditoanombrede($s['E']);
                    $propiedadesfamiliares->setPropiedadanombrede($s['J']);
                    $propiedadesfamiliares->setDomicilioactual($s['F']);
                    $propiedadesfamiliares->setMtsterreno($s['G']);
                    $propiedadesfamiliares->setMtsconstruccion($s['H']);
                    $propiedadesfamiliares->setUbicacion($s['I']);
                    if ($s['C'] == EstatusPropiedad::Hipotecado) {
                        $propiedadesfamiliares->setCreditoanombrede($s['E']);
                    }

                    $propiedadesfamiliares->setPropiedadanombrede($s['J']);
                    if ($s['F'] == "si" || $s['F'] == "sí" || $s['F'] == "SI" || $s['F'] == "SÍ" || $s['F'] == "Sí") {
                        $propiedadesfamiliares->setDomicilioactual(1);
                    } else
                    if ($s['F'] == "no" || $s['F'] == "No" || $s['F'] == "NO") {
                        $propiedadesfamiliares->setDomicilioactual(0);
                    } else {
                        throw new \Exception("El contenido del archivo no es el correcto, indique con (si/no) el campo 'Es el domicilio actual'");
                    }

                    $dbm->saveRepositorio($propiedadesfamiliares);
                }
            }
        }
    }

}
