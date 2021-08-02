<?php

namespace AppBundle\Controller\Becas;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use AppBundle\Entity\BcSolicitudbeca;
use AppBundle\Entity\BcSolicitudbecadictamen;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Icicle\Coroutine\Coroutine;
use Icicle\Awaitable;
use Icicle\Loop;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\BcProvisionalbecas;
use AppBundle\Entity\BcBecas;
use AppBundle\Entity\BcBecasporsolicitud;
use AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController;
/**
 * Auto: Judith
 */
class SolicitudBecaController extends FOSRestController
{

    /**
     * Verifica si est vigente el periodo de becas desde el portal de padres
     * @Rest\Get("/api/Becas/SolicitudBeca/PeriodoCaptura" , name="obtenerPeriodoCaptura")
     */
    public function obtenerPeriodoCaptura()
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $ciclosiguiente = $dbm->getRepositorioById("Ciclo", "siguiente", 1);
            $periodo = $dbm->getRepositorioById("BcPeriodobeca", "cicloid", $ciclosiguiente->getCicloid());
            if ($periodo) {
                $hoy = new \DateTime();
                if ($periodo->getFechainicapturas()->format("Y-m-d") <= $hoy->format("Y-m-d") && $periodo->getFechafincapturas()->format("Y-m-d") >= $hoy->format("Y-m-d")) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return new View("No hay periodos de becas.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Busca las solicitudes de becas desde el portal de padres
     * @Rest\Get("/api/Becas/SolicitudBeca/padresotutores/{id}" , name="obtenerSolicitudesPadreoTutor")
     */
    public function obtenerSolicitudesPadreoTutor($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $parambecas = $dbm->getRepositorioById("Parametros", "nombre", "ModoPagoBecas");
            $solicitudes = $dbm->SolicitudesPorPadreoTutor($id, intval($parambecas->getValor()));
            foreach ($solicitudes as &$i) {
                $alumnos = $dbm->SolicitudesPorPadreoTutorAlumnos($i["solicitudid"], intval($parambecas->getValor()));
                foreach ($alumnos as &$a) {
                    if (!$a["gradosiguiente"]) {
                        $a["gradosiguiente"] = $dbm->getRepositoriosModelo("CeAlumnoporciclo", ["CONCAT_WS(' de ', g.grado, n.nombre) AS grado"], ["alumnoid" => $a["alumnoid"]], false, false, [
                            ["entidad" => "Ciclo", "alias" => "c", "left" => false, "on" => "c.cicloid = d.cicloid and c.siguiente = 1"],
                            ["entidad" => "Grado", "alias" => "g", "left" => false, "on" => "d.gradoid = g.gradoid"],
                            ["entidad" => "Nivel", "alias" => "n", "left" => false, "on" => "g.nivelid = n.nivelid"]
                        ])[0]["grado"];
                    }
                    if($a["gradosiguiente"]){
                        $i["alumno"][] = $a;
                    }
                }                
            }
            return new View(array("solicitudes" => $solicitudes, "parambecas" => $parambecas->getValor()), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crea la solicitud de beca desde el portal de padres
     * @Rest\Post("/api/SolicitudBeca/GuardarSb" , name="GuardarSolicitud")
     */
    public function GuardarSolicitud()
    {
        try {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $dbmC = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            
            $entidad = $dbm->BuscarSolicitudClaveFamiliar($decoded);

            if (sizeof($entidad) == 0) {
                return new View("No existe matricula", Response::HTTP_PARTIAL_CONTENT);
            }
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            $clave = $entidad[0]['clavefamiliarid'];
            
            //Validar si los alumnos de la familia no esta en 5 o 6 de bachillerato
            $alumnos = $dbmC->BuscarAlumnosA(['clavefamiliarid' => $clave, 'alumnoestatusid' => 1]);
            if(!$alumnos){
                return new View("La familia no tiene alumnos activos relacionados", Response::HTTP_PARTIAL_CONTENT);
            }
            $valido = false;
            foreach($alumnos as $a){
                if($a["gradoid"] != 17 && $a["gradoid"] != 18){
                    $valido = true;
                }
            }
            if(!$valido){
                return new View("Los alumnos de ultimo grado de bachillerato no pueden aplicar una solicitud de beca", Response::HTTP_PARTIAL_CONTENT);
            }

            $fechacreacion = new \DateTime();
            $fechamodificacion = null;
            $activo = 1;
            $ciclo = $dbm->getOneByParametersRepositorio('Ciclo', array("activo" => true, "siguiente" => true));
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $nuevaentidad = array("estatusid" => 2, "activo" => $activo, "fechacreacion" => $fechacreacion, "fechamodificacion" => $fechamodificacion, "clavefamiliarid" => $clave, "cicloid" => $ciclo->getCicloid());
            $entity = $hydrator->hydrate('AppBundle\Entity\BcSolicitudbeca', $nuevaentidad);

            if ($dbm->getByParametersRepositorios('BcSolicitudbeca', $nuevaentidad)) {
                return new View("Ya existe una solicitud de beca", Response::HTTP_PARTIAL_CONTENT);
            } else {
                $dbm->saveRepositorio($entity);
                return new View($entity->getSolicitudid(), Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna filtros para las pantallas de solicitudes de becas
     * @Rest\Get("/api/ConsultaSolicitudBecas", name="ConsultaSolicitudBecasIndex")
     */
    public function Index()
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());

            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('BcEstatussolicitudbeca', 'activo', 1);
            $tipoBeca = $dbm->getRepositoriosById('BcTipobeca', 'activo', 1);
            $porcentajeBeca = $dbm->getRepositoriosById('BcPorcentajebecapornivel', 'activo', 1);
            $motivocancelacion = $dbm->getRepositoriosById('BcMotivocancelacion', 'activo', 1);
            $parametro = $dbm->getRepositorioById('Parametros', 'nombre', 'ModoPagoBecas');
            $return = array(
                "ciclo" => $ciclo,
                'nivel' => $nivel,
                "grado" => $grado,
                "estatus" => $estatus,
                'tipoBeca' => $tipoBeca,
                "porcentajeBeca" => $porcentajeBeca,
                "motivocancelacion" => $motivocancelacion,
                "parametro" => $parametro
            );
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de solicitudes de becas
     * @Rest\Post("/api/ConsultaSolicitudBecas/Filtrar", name="ConsultaSolicitudBecasfiltro")
     */
    public function ConsultaSolicitudBecasfiltro()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $decoded =  array_filter($decoded);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $parambecas = $dbm->getRepositorioById("Parametros", "nombre", "ModoPagoBecas");
            $decoded['sistema'] = intval($parambecas->getValor());
            $repositorio = $dbm->BuscarSolicitudesBecas($decoded);

            if (empty($repositorio)) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($repositorio, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de solicitudes de becas
     * @Rest\Post("/api/ConsultaSolicitudBecas/DictaminacionFiltrar", name="ConsultaSolicitudBecasDictaminacionfiltro")
     */
    public function ConsultaSolicitudBecasDictaminacionfiltro()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            foreach ($decoded as $key => $item) {
                if (is_null($item) || $item == "") {
                    unset($decoded[$key]);
                }
            }

            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $repositorio = $dbm->BuscarSolicitudesBecas($decoded);

            if (empty($repositorio)) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($repositorio, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna arreglo de solicitudes de becas
     * @Rest\Post("/api/SolicitudBeca/Pago", name="SolicitudBecaPago")
     */
    public function SolicitudBecaPago()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");

            foreach ($decoded as $id) {

                $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $id);
                if ($solicitud) {
                    $solicitud->setPagado(1);
                    $dbm->saveRepositorio($solicitud);
                }
            }
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna informacion de cada alumno de la familia con su beca actual y con su historial de becas
     * 
     * Al crear una solicitud en modo lux
     *  Envia: -clavefamiliarid, solicitudalumno(boolean)
     * Al abrir solicitud, primera pestaña, informacion de los alumno
     *  Envia: -clavefamiliarid, solicitudbecaid(ID)
     * En recepcion de documentos
     *  Envia: -clavefamiliarid, solicitudbecaid(ID)
     * 
     * @Rest\Post("/api/ConsultaSolicitudBecas/InfoFamiliaBeca", name="InforFamiliaBeca")
     */
    public function InforFamiliaBeca()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $parambecas = $dbm->getRepositorioById("Parametros", "nombre", "ModoPagoBecas");
            
            $entidad = $dbm->Buscaralumnoporfamlia($decoded, intval($parambecas->getValor()));
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach ($entidad as &$alumno) {
                $alumno["historial"]  = $dbm->Buscarhistorialhijos(array("alumnoid" => $alumno["alumnoid"]));
                $alumno["clavefamiliar"] = $dbm->getRepositorioById("CeClavefamiliar", "clavefamiliarid", $decoded["clavefamiliarid"]);
                $alumno["solicitudbecas"] = $dbm->BuscarSolicitudesAlumno(array("alumnoid" => $alumno["alumnoid"], "solicitudbecaid" => $decoded["solicitudbecaid"]));
                $promedio = CapturaCalificacionReporteController::getPromedioFinalByAlumnociclo($dbmce, $alumno['alumnoporcicloid']);
                $alumno["promedio"] = $promedio ? $promedio[1] : null;
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *guardar solicitud por alumno en modo lux
     * @Rest\Post("/api/SolicitudBeca/GuardarSporalumno", name="SolicitudporalumnoGuardar")
     */
    public function SolicitudporalumnoGuardar()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $s = sizeof($decoded['lista']);
            for ($i = 0; $i < $s; $i++) {
                $valor = $decoded['lista'][$i];
                $spa = $dbm->getByParametersRepositorios("BcSolicitudporalumno", array("solicitudid" => $valor["solicitudid"], "alumnoid" => $valor["AlumnoId"]));
                if (!$spa) {
                    if ($decoded['lista'][$i]["activo"]) {
                        $spa = $hydrator->hydrate('AppBundle\Entity\BcSolicitudporalumno', $valor);
                        $spa->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $valor["AlumnoId"]));
                        $infoalumno = $dbm->BuscarAlumnosA(array("alumnoid" => $valor["AlumnoId"]));
                        $gradoidactual = $infoalumno[0]["gradoid"];
                        $gradodestino = 0;
                        switch ($gradoidactual) {
                            case 13:
                            case 15:
                                $gradodestino = $gradoidactual + 2;
                                break;
                            default:
                                $gradodestino = $gradoidactual + 1;
                        }
                        $spa->setGradoidorigen($dbm->getRepositorioById("Grado", "gradoid", $gradoidactual));
                        $spa->setGradoiddestino($dbm->getRepositorioById("Grado", "gradoid", $gradodestino));


                        $cicloactual = $dbm->getRepositorioById("Ciclo", "siguiente", 1);
                        $solicitudes = $dbm->getByParametersRepositorios("BcSolicitudbeca", array("clavefamiliarid" => $decoded["clavefamiliarid"], "cicloid" => $cicloactual->getCicloid()));
                        $solicitud = $solicitudes[0];
                        if (!$solicitud) {
                            $solicitud = new BcSolicitudbeca();
                            $solicitud->setActivo(1);
                            $solicitud->setFechacreacion(new \DateTime());
                            $solicitud->setClavefamiliarid($dbm->getRepositorioById("CeClavefamiliar", "clavefamiliarid", $decoded["clavefamiliarid"]));
                            $solicitud->setCicloid($dbm->getRepositorioById("Ciclo", "cicloid", $cicloactual->getCicloid()));
                            $solicitud->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 2));
                            $dbm->saveRepositorio($solicitud);
                        }

                        $spa->setSolicitudid($solicitud);
                        $otrassolicitudes = $dbm->getRepositoriosById("BcSolicitudporalumno", "solicitudid", $solicitud->getSolicitudid());
                        if ($otrassolicitudes) {
                            foreach ($otrassolicitudes as $os) {
                                if ($os->getEstatusid()->getEstatusid() < 5) {
                                    $spa->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", $os->getEstatusid()->getEstatusid()));
                                    $bandera = true;
                                }
                                if ($os->getEstatusid()->getEstatusid() > 5 && !$bandera) {
                                    $spa->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 1));
                                }
                            }
                        } else {
                            $spa->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 2));
                        }

                        $dbm->saveRepositorio($spa);
                    }
                } else {
                    if ($decoded['lista'][$i]["activo"]) {
                        $spa = $hydrator->hydrate($spa[0], $valor);
                        $dbm->saveRepositorio($spa);
                    } else {
                        $dbm->RemoveRepositorio($spa[0]);
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo layout
     * @Rest\Get("/api/Becas/SolicitudBeca/Dictaminacion/DescargaLayoutDictaminacionBeca/", name="DescargaLayoutDictaminacionBeca")
     */
    public function DescargaLayoutDictaminacionBeca()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $Excel = $this->get('phpexcel')->createPHPExcelObject();

            $registros = $dbm->SolicitudBecasLayout($filtros);
            $layout = \AppBundle\Dominio\ImportacionDictaminacionBecas::layout($Excel, $registros);
            $writer = $this->get('phpexcel')->createWriter($layout, 'Excel5');
            $response = $this->get('phpexcel')->createStreamedResponse($writer);

            $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                'stream-file.xls'
            );
            $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Cache-Control', 'maxage=1');
            $response->headers->set('Content-Disposition', $dispositionHeader);

            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo layout
     *  @Rest\POST("/api/Becas/SolicitudBeca/Dictaminacion/importarlayaoutdictaminacionbeca" , name="importarlayaoutdictaminacionbeca")
     */
    public function importarlayaoutdictaminacionbeca()
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
            $sheet = $phpExcelObject->getActiveSheet();
            $phpExcelObject->getProperties();
            //$pagemax = $sheetsituacion->getHighestDataRow();
            $dictaminacion = $sheet->rangeToArray('A2:' . $sheet->getHighestDataColumn() . $sheet->getHighestDataRow(), null, true, true, true);
            $Preguntasdictaminacion = $sheet->rangeToArray('A1:' . $sheet->getHighestDataColumn() . '1', null, true, true, true);

            $valor = "";
            $guardar = function () use (
                $dictaminacion,
                $Preguntasdictaminacion
            ) {
                try {
                    $dbm = $this->get("db_manager");
                    $dbm->getConnection()->beginTransaction();
                    yield Awaitable\resolve(self::actualizarLayoutDictaminacion($dictaminacion, $Preguntasdictaminacion));
                    $dbm->getConnection()->commit();
                } catch (\Exception $e) {
                    $dbm->getConnection()->rollBack();
                    if ($e->getCode() == 1) {
                        die($e->getMessage());
                    }
                }
            };

            $routine = new Coroutine($guardar());
            Loop\Run();

            $totalregistros = sizeof($dictaminacion);

            return new View("Se proceso correctamente el archivo. " . $totalregistros . " registros fueron actualizados.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarLayoutDictaminacion($dictaminacion, $Preguntasdeudas)
    {
        try {
            $dbm = $this->get("db_manager");
            foreach ($dictaminacion as $row => $s) {
                if (empty($s['A'])) {
                    return new View("El contenido del archivo no es el correcto", Response::HTTP_OK);
                } else {
                    $solicitudbeca = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $s['A']);
                    if (empty($solicitudbeca)) {
                        return new View("El contenido del archivo no es el correcto, falta el folio de la solicitud " . $s['A'], Response::HTTP_OK);
                    } else {
                        $alumno = $dbm->getRepositorioById("CeAlumno", "matricula", $s['G']);
                        if (!$alumno) {
                            return new View("No existe un registro de alumno " . $s['G'], Response::HTTP_OK);
                        }
                        if (intval($s['AA']) > 0) {
                            $porcentaje = intval($s['AA']);
                            $tipobecaid = 3;
                            $bd = $dbm->getByParametersRepositorios(
                                'BcSolicitudbecadictamen',
                                array(
                                    "alumnoid" => $alumno->getAlumnoid(),
                                    "tipobecaid" => $tipobecaid,
                                    "solicitudid" => $s['A'],
                                )
                            );
                            if ($bd) {
                                $bd = $bd[0];
                                $bd->setObservaciones($bd->getObservaciones() . chr(10) . $s['Y'] . chr(10) . $s['Z']);
                                $bd->setPorcentajebecaid($dbm->getRepositorioById("BcPorcentajebeca", "descripcion", $porcentaje));
                                $dbm->saveRepositorio($bd);
                            } else {
                                $bd = new BcSolicitudbecadictamen();
                                $bd->setSolicitudid($solicitudbeca);
                                $bd->setAlumnoid($alumno);
                                $bd->setEstatusid($dbm->getRepositorioById("BcEstatus", "estatusid", 3));
                                $bd->setTipobecaid($dbm->getRepositorioById("BcTipobeca", "tipobecaid", $tipobecaid));
                                $bd->setObservaciones($bd->getObservaciones() . chr(10) . $s['Y'] . chr(10) . $s['Z']);
                                $bd->setPorcentajebecaid($dbm->getRepositorioById("BcPorcentajebeca", "descripcion", $porcentaje));
                                $dbm->saveRepositorio($bd);
                            }

                            $sa = $dbm->getOneByParametersRepositorio(
                                'BcSolicitudporalumno',
                                array(
                                    "alumnoid" => $alumno->getAlumnoid(),
                                    "solicitudid" => $s['A'],
                                )
                            );
                            if ($sa) {
                                $beca = new BcBecas();
                                $becaporsolicitud = new BcBecasporsolicitud();
                                $provisional = new BcProvisionalbecas();
                                $provisional->setAlumnoid($alumno);
                                $provisional->setNivelid($sa->getGradoiddestino()->getNivelid());
                                $provisional->setTipobecaid($bd->getTipobecaid());
                                $provisional->setPorcentajebecaid($bd->getPorcentajebecaid());
                                $provisional->setGradoid($sa->getGradoiddestino());
                                $provisional->setCicloid($solicitudbeca->getCicloid());
                                $provisional->setEstatusid($dbm->getRepositorioById("BcEstatus", "estatusid", 3));
                                $provisional->setSolicitudid($solicitudbeca);
                                $dbm->saveRepositorio($provisional);

                                $bp = $dbm->getRepositorioById('BcProvisionalbecas', 'provisionalbecaid', $provisional->getProvisionalbecaid());

                                if (!isset($bp)) {
                                    throw new \Exception("ID No encontrado");
                                }

                                $dictamen = $dbm->getOneByParametersRepositorio(
                                    'BcSolicitudbecadictamen',
                                    array(
                                        "alumnoid" => $bp->getAlumnoid()->getAlumnoid(),
                                        "tipobecaid" => $bp->getTipobecaid()->getTipobecaid(),
                                        "solicitudid" => $s['A'],
                                    )
                                );

                                if (empty($dictamen)) {
                                    $dictamen = new BcSolicitudbecadictamen();
                                }

                                $dictamen->setAlumnoid($bp->getAlumnoid());
                                $dictamen->setEstatusid($bp->getEstatusid());
                                $dictamen->setTipobecaid($bp->getTipobecaid());
                                $dictamen->setPorcentajebecaid($bp->getPorcentajebecaid());
                                $dictamen->setSolicitudid($bp->getSolicitudid());
                                $dbm->saveRepositorio($dictamen);

                                $beca->setAlumnoid($bp->getAlumnoid());
                                $beca->setTipobecaid($bp->getTipobecaid());
                                $beca->setPorcentajebecaid($bp->getPorcentajebecaid());
                                $beca->setGradoidorigen($sa->getGradoidorigen());
                                $beca->setGradoid($sa->getGradoiddestino());
                                $beca->setCicloid($bp->getCicloid());
                                $beca->setEstatusid($bp->getEstatusid());

                                $becabusqueda = $dbm->getByParametersRepositorios(
                                    'BcBecas',
                                    array(
                                        "alumnoid" => $bp->getAlumnoid(),
                                        "tipobecaid" => $bp->getTipobecaid(),
                                        "cicloid" => $bp->getCicloid(),
                                        "gradoid" => $bp->getGradoid(),
                                    )
                                );

                                if (empty($becabusqueda)) {
                                    $dbm->saveRepositorio($beca);
                                }

                                $estatusaprobado = $dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', 6); //EL 5 ES RECHAZADA
                                if ($sa->getEstatusid()->getEstatusid() != 7) {
                                    $sa->setEstatusid($estatusaprobado);
                                    $dbm->saveRepositorio($sa);
                                }

                                if (empty($becabusqueda)) {
                                    //GUARDAR EN LA TABLA RELACION BECAPORSOLCIITUD
                                    $becaporsolicitud->setBecaid($beca);
                                    $becaporsolicitud->setProvisionalbecaid($bp);
                                    $becaporsolicitud->setSolicitudid($sa->getSolicitudid());
                                    $dbm->saveRepositorio($becaporsolicitud);
                                }
                            } else {
                                return new View("No existe un registro de alumno " . $s['G'], Response::HTTP_OK);
                            }
                        }
                        if (intval($s['AB']) > 0) {
                            $porcentaje = intval($s['AB']);
                            $tipobecaid = 1;
                            $bd = $dbm->getByParametersRepositorios(
                                'BcSolicitudbecadictamen',
                                array(
                                    "alumnoid" => $alumno->getAlumnoid(),
                                    "tipobecaid" => $tipobecaid,
                                    "solicitudid" => $s['A'],
                                )
                            );
                            if ($bd) {
                                $bd = $bd[0];
                                $bd->setObservaciones($bd->getObservaciones() . chr(10) . $s['Y'] . chr(10) . $s['Z']);
                                $bd->setPorcentajebecaid($dbm->getRepositorioById("BcPorcentajebeca", "descripcion", $porcentaje));
                                $dbm->saveRepositorio($bd);
                            } else {
                                $bd = new BcSolicitudbecadictamen();
                                $bd->setSolicitudid($solicitudbeca);
                                $bd->setAlumnoid($alumno);
                                $bd->setEstatusid($dbm->getRepositorioById("BcEstatus", "estatusid", 3));
                                $bd->setTipobecaid($dbm->getRepositorioById("BcTipobeca", "tipobecaid", $tipobecaid));
                                $bd->setObservaciones($bd->getObservaciones() . chr(10) . $s['Y'] . chr(10) . $s['Z']);
                                $bd->setPorcentajebecaid($dbm->getRepositorioById("BcPorcentajebeca", "descripcion", $porcentaje));
                                $dbm->saveRepositorio($bd);
                            }

                            $sa = $dbm->getOneByParametersRepositorio(
                                'BcSolicitudporalumno',
                                array(
                                    "alumnoid" => $alumno->getAlumnoid(),
                                    "solicitudid" => $s['A'],
                                )
                            );
                            if ($sa) {
                                $beca = new BcBecas();
                                $becaporsolicitud = new BcBecasporsolicitud();
                                $provisional = new BcProvisionalbecas();
                                $provisional->setAlumnoid($alumno);
                                $provisional->setNivelid($sa->getGradoiddestino()->getNivelid());
                                $provisional->setTipobecaid($bd->getTipobecaid());
                                $provisional->setPorcentajebecaid($bd->getPorcentajebecaid());
                                $provisional->setGradoid($sa->getGradoiddestino());
                                $provisional->setCicloid($solicitudbeca->getCicloid());
                                $provisional->setEstatusid($dbm->getRepositorioById("BcEstatus", "estatusid", 3));
                                $provisional->setSolicitudid($solicitudbeca);
                                $dbm->saveRepositorio($provisional);

                                $bp = $dbm->getRepositorioById('BcProvisionalbecas', 'provisionalbecaid', $provisional->getProvisionalbecaid());

                                if (!isset($bp)) {
                                    throw new \Exception("ID No encontrado");
                                } else {
                                    $dictamen = $dbm->getOneByParametersRepositorio(
                                        'BcSolicitudbecadictamen',
                                        array(
                                            "alumnoid" => $bp->getAlumnoid()->getAlumnoid(),
                                            "tipobecaid" => $bp->getTipobecaid()->getTipobecaid(),
                                            "solicitudid" => $s['A'],
                                        )
                                    );

                                    if (empty($dictamen)) {
                                        $dictamen = new BcSolicitudbecadictamen();
                                    }

                                    $dictamen->setAlumnoid($bp->getAlumnoid());
                                    $dictamen->setEstatusid($bp->getEstatusid());
                                    $dictamen->setTipobecaid($bp->getTipobecaid());
                                    $dictamen->setPorcentajebecaid($bp->getPorcentajebecaid());
                                    $dictamen->setSolicitudid($bp->getSolicitudid());
                                    $dbm->saveRepositorio($dictamen);


                                    $beca->setAlumnoid($bp->getAlumnoid());
                                    $beca->setTipobecaid($bp->getTipobecaid());
                                    $beca->setPorcentajebecaid($bp->getPorcentajebecaid());
                                    $beca->setGradoidorigen($sa->getGradoidorigen());
                                    $beca->setGradoid($sa->getGradoiddestino());
                                    $beca->setCicloid($bp->getCicloid());
                                    $beca->setEstatusid($bp->getEstatusid());

                                    $becabusqueda = $dbm->getByParametersRepositorios(
                                        'BcBecas',
                                        array(
                                            "alumnoid" => $bp->getAlumnoid(),
                                            "tipobecaid" => $bp->getTipobecaid(),
                                            "cicloid" => $bp->getCicloid(),
                                            "gradoid" => $bp->getGradoid(),
                                        )
                                    );

                                    if (empty($becabusqueda)) {
                                        $dbm->saveRepositorio($beca);
                                    }

                                    $estatusaprobado = $dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', 6); //EL 5 ES RECHAZADA
                                    if ($sa->getEstatusid()->getEstatusid() != 7) {
                                        $sa->setEstatusid($estatusaprobado);
                                        $dbm->saveRepositorio($sa);
                                    }

                                    if (empty($becabusqueda)) {
                                        //GUARDAR EN LA TABLA RELACION BECAPORSOLCIITUD
                                        $becaporsolicitud->setBecaid($beca);
                                        $becaporsolicitud->setProvisionalbecaid($bp);
                                        $becaporsolicitud->setSolicitudid($sa->getSolicitudid());
                                        $dbm->saveRepositorio($becaporsolicitud);
                                    }
                                }
                            } else {
                                return new View("No existe un registro de alumno " . $s['G'], Response::HTTP_OK);
                            }
                        }
                    }
                }
            }
            return new View("Se proceso correctamente el archivo. " . count($dictaminacion) . " registros fueron actualizados.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza el motivo de cancelacion de una solicitud de beca
     * @Rest\Post("/api/ConsultaBecas/CancelaSolicitud", name="CancelaSolicitudBeca")
     */
    public function CancelaSolicitudBeca()
    {
        try {
            $dbm = $this->get("db_manager");
            $datos = $_REQUEST;
            $data = array_filter($datos);
            foreach ($data["solicitudid"] as $solicitudid) {
                if ($solicitudid["alumnoid"] == null || $solicitudid["alumnoid"] == "") {
                    $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $solicitudid["solicitudid"]);
                    $solicitud->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 7));
                    $dbm->saveRepositorio($solicitud);
                } else {
                    $solicitud = $dbm->getByParametersRepositorios('BcSolicitudporalumno', array('solicitudid' => $solicitudid["solicitudid"], 'alumnoid' => $solicitudid["alumnoid"]));
                    $solicitud = $solicitud[0];
                    $solicitud->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 7));
                    $solicitud->setMotivocancelacionid($dbm->getRepositorioById("BcMotivocancelacion", "motivocancelacionid", $data["motivocancelacionid"]));
                    $dbm->saveRepositorio($solicitud);
                }
            }
            return new View("Se guardo la información.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
