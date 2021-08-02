<?php

namespace AppBundle\Controller\Becas\Modal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use AppBundle\Entity\BcRecibirdocumentos;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Mariano
 */
class RecibirDocumentosController extends FOSRestController
{
    /**
     * obtener domicilio por solicitud
     * @Rest\Post("/api/SolicitudBeca/getdomicilio", name="getaddres")
     */
    public function getaddres()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $entidad = $dbm->getdomicilio($decoded);
            if (!$entidad) {
                $entidad2 = $dbm->getdomicilio2($decoded);
                return new View($entidad2, Response::HTTP_OK);
            } else {
                return new View($entidad, Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Retorna documentos a checar
     * @Rest\Get("/api/Becas/SolicitudBeca/Documentos", name="ConsultaSolicitudBecasDocumentos")
     */
    public function ConsultaSolicitudBecasDocumentos()
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $documentos = $dbm->getRepositoriosById('BcDocumentos', 'activo', 1);
            $parametro = $dbm->getRepositorioById('Parametros', 'nombre', 'ModoPagoBecas');
            return new View(['documentos' => $documentos, 'parametro' => $parametro], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * obtener informacion de pestaña recibir documentos
     * @Rest\Post("/api/SolicitudBeca/getdoc", name="obtenerdocs")
     */
    public function obtenerdocs()
    {
        try {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $entidad = $dbm->buscardocs($decoded);
            $solicitud = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $decoded['solicitudid']);
            if (!$entidad && !$solicitud) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View(["documentos" => $entidad, "solicitud" => $solicitud], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Inserta o remueve un documento
     * @Rest\Post("/api/Becas/SolicitudBeca/Documentos/Guardar", name="SolicitudBecasDocumentosGuardar")
     */
    public function SolicitudBecasDocumentosGuardar()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $documento = $dbm->getByParametersRepositorios('BcRecibirdocumentos', array("documentoid" => $decoded["documentoid"], "solicitudid" => $decoded["solicitudid"]));
            if (!$documento[0]) {
                $Documento = new BcRecibirdocumentos();
                $Documento = $hydrator->hydrate($Documento, $decoded);
                $dbm->saveRepositorio($Documento);
            } else {
                if ($decoded["validacion"]) {
                    $Documento = $hydrator->hydrate($documento[0], $decoded);
                } else {
                    $dbm->RemoveRepositorio($documento[0]);
                }
            }
            $dbm->getConnection()->commit();
            $documentos = $dbm->getRepositoriosById("BcRecibirdocumentos", "solicitudid", $decoded["solicitudid"]);
            return new View($documentos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda la seccion de recepcion de documentos
     * @Rest\Post("/api/SolicitudBeca/documentosrecibido", name="BecasRecepcionDocumentosGuardar")
     */
    public function saveBecasRecepcionDocumentos()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $parambecas = $dbm->getRepositorioById("Parametros", "nombre", "ModoPagoBecas");

            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $entity = $hydrator->hydrate($dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']), $decoded);
            $dbm->saveRepositorio($entity);

            if (intval($parambecas->getValor()) == 1) {
                $solicitudesporalumno = $dbm->getRepositoriosById('BcSolicitudporalumno', 'solicitudid', $decoded['solicitudid']);
                foreach ($solicitudesporalumno as $spa) {
                    if ($spa->getEstatusid()->getEstatusid() != 7) {
                        $spa->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 4));
                        $dbm->saveRepositorio($spa);
                    }
                }
                $dbm->getConnection()->commit();
                return new View("Se ha editado observación", Response::HTTP_OK);
            } else {
                $unactivo = false;
                foreach ($decoded['hijos'] as $hijo) {
                    if ($hijo["activo"]) {
                        $unactivo = true;
                    }
                }
                $s = sizeof($decoded['hijos']);
                for ($i = 0; $i < $s; $i++) {
                    $valor = $decoded['hijos'][$i];
                    $spa = $dbm->getByParametersRepositorios("BcSolicitudporalumno", array("solicitudid" => $decoded['solicitudid'], "alumnoid" => $valor["AlumnoId"]));
                    if (!$spa) {
                        $spa = $hydrator->hydrate('AppBundle\Entity\BcSolicitudporalumno', $valor);
                        $spa->setSolicitudid($dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']));
                        $spa->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $valor["AlumnoId"]));

                        $infoalumno = $dbm->BuscarAlumnosA(array("alumnoid" => $valor["AlumnoId"], "cicloactual" => true));
                        $gradoidactual = $infoalumno[0]["gradoid"];
                        if ($gradoidactual) {
                            $gradodestino = 0;
                            switch ($gradoidactual) {
                                case 13:
                                case 15:
                                    $gradodestino = $gradoidactual + 2;
                                    break;
                                case 19:
                                    $gradodestino = 1;
                                    break;
                                default:
                                    $gradodestino = $gradoidactual + 1;
                            }
                        } else {
                            $infoalumno = $dbm->BuscarAlumnosA(array("alumnoid" => $valor["AlumnoId"]));
                            $gradodestino = $infoalumno[0]["gradoid"];
                        }
                        $spa->setGradoidorigen($dbm->getRepositorioById("Grado", "gradoid", $gradoidactual));
                        $spa->setGradoiddestino($dbm->getRepositorioById("Grado", "gradoid", $gradodestino));
                    } else {
                        $spa = $hydrator->hydrate($spa[0], $valor);
                    }

                    if ($unactivo && $decoded['estudiosocvalidado'] && $decoded['ingresosvalidado'] && $decoded['egresosvalidado']) {
                        $spa->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 4));
                        $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']);
                        $solicitud->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 4));
                        $dbm->saveRepositorio($solicitud);
                    } else {
                        $spa->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 4));
                    }
                    if ($valor["activo"]) {
                        $dbm->saveRepositorio($spa);
                    } else {
                        $dbm->removeRepositorio($spa);
                    }
                }
                $dbm->getConnection()->commit();
                return new View("Se han guardado los documentos y solicitudes", Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View(($e->getMessage()), Response::HTTP_OK);
        }
    }

    /**
     * Retorna el recibo de pago de documentos
     * @Rest\Get("/api/Becas/SolicitudBeca/Reporte/{solicitudid}" , name="ReporteSolicitudBeca")
     */
    public function ReporteSolicitudBeca($solicitudid)
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $solicitudid);
            $familia = $solicitud->getClavefamiliarid()->getApellidoPaterno() . " " . $solicitud->getClavefamiliarid()->getApellidoMaterno();
            $documentosRec = $dbm->getRepositoriosById("BcRecibirdocumentos", "solicitudid", $solicitudid);
            $documentos = $dbm->getRepositoriosById("BcDocumentos", "activo", true);
            $docstatus = true;
            $docmissj = "";
            $parametro = $dbm->getRepositorioById('Parametros', 'nombre', 'ModoPagoBecas');
            $modopagobecas = $parametro && $parametro->getValor() == "2"  ? true : false;


            if (sizeof($documentosRec) != sizeof($documentos)) {
                $docstatus = false;
                $docmiss = [];
                foreach ($documentos as $d) {
                    $recibido = array_filter($documentosRec, function ($e) use ($d) {
                        return $e->getDocumentoid()->getDocumentoid() == $d->getDocumentoid();
                    });
                    if (!$recibido) {
                        $docmiss[] = $d->getNombre();
                    }
                }
                $docmissj = implode(", ", $docmiss);
            }

            if ($modopagobecas) {
                $data = [
                    "NoSolicitud" => $solicitud->getSolicitudid(),
                    "NoPago" => $solicitud->getSolicitudid(),
                    "Familia" => $familia,
                    "FechaImpresion" => date("d/m/Y"),
                    "Fecha" => $solicitud->getFechacreacion()->format('d/m/Y'),
                ];

                $periodo = $dbm->getRepositorioById("BcPeriodobeca", "cicloid", $solicitud->getCicloid()->getCicloid());
                if (!$periodo) {
                    return new View("No se ha configurado un periodo de beca para el ciclo de la solicitud", Response::HTTP_PARTIAL_CONTENT);
                }
                $periodoporformato = $dbm->getRepositoriosById("BcPeriodobecaporformato", "periodobecaid", $periodo->getPeriodobecaid());
                foreach ($periodoporformato as $pf) {
                    if ($pf->getFormatobecaid()->getTipodocumentoid()->getTipodocumentoid() == 4) {
                        $formatoid = $pf->getFormatobecaid();
                    }
                }

                $Formato = $formatoid;

                if (!$Formato) {
                    return new View("No se ha configurado un formato de recibo de pago.", Response::HTTP_PARTIAL_CONTENT);
                }

                $extension = $Formato->getArchivotipo() == 'application/msword' ? '.doc' : '.docx';
                $temp = tmpfile();
                fwrite($temp, stream_get_contents($Formato->getArchivo()));
                $path = stream_get_meta_data($temp)['uri'];

                $parametros = $dbm->getRepositorioById("Parametros", "nombre", "UrlTokens");
                $urltokens = $parametros->getValor();
                $documento = \AppBundle\Dominio\Formato::remplazarToken($data, $path, $urltokens);
                fclose($temp);

                if (empty($documento["formato"])) {
                    return new View("No hay un formato disponible.", Response::HTTP_PARTIAL_CONTENT);
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
            } else {
                $data = [
                    "clave" => $solicitud->getSolicitudid(),
                    "familia" => $familia,
                    "solicitud_num" => $solicitud->getSolicitudid(),
                    "hora_impresion" => date("H:i:s"),
                    "fecha_impresion" => date("d/m/Y"),
                    "fecha_recibo" => $solicitud->getFechacreacion()->format('d/m/Y'),
                    "documentacion_status" => $docstatus,
                    "documentacion_missing" => $docmissj
                ];
                $done = false;
                $name = "R" . rand();
                $report = "BecasRecibo";
                $input = $output = "{$report}_$name";

                $pdf = new LDPDF($this->container, $report, $output, array('driver' => 'jsonql', 'jsonql_query' => '""', 'data_file' => $input));
                $inputPath = $pdf->fdb_r;
                $outputPath = $pdf->output_r;

                $resultenc = json_encode($data);
                $file = LDPDF::fileRead($inputPath);
                LDPDF::fileWrite($file, $resultenc);
                LDPDF::fileClose($file);
                unset($file);
                $toremove = [$inputPath];

                if (!$pdf->execute()) {
                    $toremove[] = $outputPath;
                    $done = true;
                }

                $reporteSize = filesize($outputPath);
                $reporte = file_get_contents($outputPath);
                foreach ($toremove as $i) {
                    LDPDF::fileDelete($i);
                }

                return ($done
                    ? new Response($reporte, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Length' => $reporteSize
                    ])
                    : Api::Error(Response::HTTP_PARTIAL_CONTENT, "La impresion no esta disponible."));
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
