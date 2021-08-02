<?php

namespace AppBundle\Controller\Cobranza;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmCobranza;
use AppBundle\Entity\CbAcuerdo;
use AppBundle\Entity\CbAlumnoporacuerdo;
use AppBundle\Entity\CbSeguimiento;
use AppBundle\Entity\CbDocumentogarantia;
use AppBundle\Entity\CbPlanpagos;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmControlescolar;

/**
 * Auto: Javier
 */
class AcuerdoController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cobranza/Acuerdo", name="indexAcuerdo")
     */
    public function indexAcuerdo()
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $tipoacuerdo = $dbm->getRepositoriosById('CbTipoacuerdo', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('CbEstatusacuerdo', 'activo', 1);

            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);

            return new View(array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                "grupo" => $grupo,
                "tipoacuerdo" => $tipoacuerdo,
                "estatus" => $estatus,
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de acuerdos en base a los parametros enviados
     * @Rest\Get("/api/Cobranza/Acuerdo/", name="BuscarAcuerdo")
     */
    public function getAcuerdo()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarAcuerdos($filtros);
            $acuerdo = array();
            foreach ($entidad as $a) {
                $filtro =  array("alumnoid" => explode(",", $a["alumnoid"]));
                $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
                $alumnos = $dbma->BuscarAlumnosA($filtro);
                if ($alumnos) {
                    array_push($acuerdo, array("acuerdo" => $a, "alumnos" => $alumnos));
                }
            }

            if (!$acuerdo) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($acuerdo, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cancela un acuerdo
     * @Rest\Put("/api/Cobranza/Acuerdo/Cancelar", name="CancelarAcuerdo")
     */
    public function cancelAcuerdo()
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($data["acuerdosid"] as $a) {
                $acuerdo = $dbm->getRepositorioById('CbAcuerdo', 'acuerdoid', $a);
                $acuerdo->setEstatusacuerdoid($dbm->getRepositorioById('CbEstatusacuerdo', 'estatusacuerdoid', 3));
                $dbm->saveRepositorio($acuerdo);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha cancelado el acuerdo", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de acuerdos en base a los parametros enviados
     * @Rest\Get("/api/Cobranza/Acuerdo/Precarga/{id}", name="getAcuerdoPrecarga")
     */
    public function getAcuerdoPrecarga($id)
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());

            $acuerdo = $dbm->getRepositorioById('CbAcuerdo', 'acuerdoid', $id);
            $alumnos = $dbm->getRepositoriosById('CbAlumnoporacuerdo', 'acuerdoid', $id);
            $alumnosid = array();
            foreach ($alumnos as $a) {
                array_push($alumnosid, $a->getAlumnoid()->getAlumnoid());
            }

            $planpagos = $dbm->getRepositoriosById('CbPlanpagos', 'acuerdoid', $id);

            return new View(array(
                "acuerdo" => $acuerdo,
                "alumnosid" => $alumnosid,
                "planpagos" => $planpagos
            ), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de familias en base a los parametros enviados
     * @Rest\Get("/api/Cobranza/Acuerdo/Modalgeneral/{id}", name="AcuerdoModalGeneral")
     */
    public function getAcuerdoModalGeneral($id)
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());

            $padres = $dbm->getRepositoriosById('CePadresotutoresclavefamiliar', 'clavefamiliarid', $id);
            $alumnosporcalve = $dbm->getRepositoriosById('CeAlumnoporclavefamiliar', 'clavefamiliarid', $id);

            $alumnos = array();
            foreach ($alumnosporcalve as $a) {
                $alumnoid = $a->getAlumnoid()->getAlumnoid();
                $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
                $alumno = $dbma->BuscarAlumnosA(array("alumnoid" => $alumnoid));
                $deuda = $dbma->BuscarAdeudoTotalAlumno($alumnoid);
                array_push($alumnos, array("alumno" => $alumno ? $alumno[0] : $a->getAlumnoid(), "deuda" => $deuda));
            }

            return new View(array("padres" => $padres, "alumnos" => $alumnos), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de familias en base a los parametros enviados
     * @Rest\Get("/api/Cobranza/Acuerdo/Modalacuerdo/", name="AcuerdoModalAcuerdo")
     */
    public function getAcuerdoModalAcuerdo()
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $tipoacuerdo = $dbm->getRepositoriosById('CbTipoacuerdo', 'activo', 1);
            $descripcion = $dbm->getRepositorioById('Parametros', 'nombre', "ComentarioAcuerdo");
            $fecha = (new \DateTime())->format("d/m/Y");
            $tipointeres = $dbm->getRepositorioById('Parametros', 'nombre', "TipoInteres");

            $documentos = array();
            foreach ($datos["alumnosid"] as $a) {
                $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
                $documentosalumno = $dbma->BuscarAdeudoAlumno($a);
                foreach ($documentosalumno as $d) {
                    array_push($documentos, $d);
                }
            }
            return new View(array(
                "documentos" => $documentos,
                "ciclo" => $ciclo,
                "tipoacuerdo" => $tipoacuerdo,
                "descripcion" => $descripcion->getValor(),
                "tipointeres" => $tipointeres->getValor(),
                "fecha" => $fecha
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Cobranza/Acuerdo" , name="GuardarAcuerdo")
     */
    public function SaveAcuerdo()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $data['estatusacuerdoid'] = 1;
            $data['padresotutoresid'] = $data["padreid"][0];
            $data['fechaultimamodificacion'] = new \DateTime();
            $data['fechacreacion'] = new \DateTime();
            $data['vigenciainicio'] = new \DateTime($data["vigencia"]["beginDate"]["day"] . "-" . $data["vigencia"]["beginDate"]["month"] . "-" . $data["vigencia"]["beginDate"]["year"]);
            $data['vigenciafin'] = new \DateTime($data["vigencia"]["endDate"]["day"] . "-" . $data["vigencia"]["endDate"]["month"] . "-" . $data["vigencia"]["endDate"]["year"]);

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $acuerdo = $hydrator->hydrate(new CbAcuerdo(), $data);
            $dbm->saveRepositorio($acuerdo);

            foreach ($data["alumnosid"] as $a) {
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $a);
                $acuerdoporalumno = new CbAlumnoporacuerdo();
                $acuerdoporalumno->setAlumnoid($alumno);
                $acuerdoporalumno->setAcuerdoid($acuerdo);
                $acuerdoporalumno->setImporte(0); // Pendiente modificar
                $dbm->saveRepositorio($acuerdoporalumno);
            }

            foreach ($data["documentoporpagar"] as $d) {
                if ($d["tipoacuerdoid"]) {
                    $documento = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $d["documentoporpagarid"]);
                    $documento->setAcuerdoid($acuerdo);
                    $documento->setTipoacuerdoid($dbm->getRepositorioById('CbTipoacuerdo', 'tipoacuerdoid', $d["tipoacuerdoid"]));
                    $documento->setPorcentaje($d["porcentaje"]);
                    $d['vigencia'] = new \DateTime($d["vigencia"]["date"]["day"] . "-" . $d["vigencia"]["date"]["month"] . "-" . $d["vigencia"]["date"]["year"]);
                    $documento->setVigenciaacuerdo($d['vigencia']);
                    $dbm->saveRepositorio($documento);
                }
            }

            foreach ($data["planpagos"] as $p) {
                $p["fechacompromiso"] = new \DateTime($p["fechacompromiso"]["date"]["day"] . "-" . $p["fechacompromiso"]["date"]["month"] . "-" . $p["fechacompromiso"]["date"]["year"]);
                $plan = $hydrator->hydrate(new CbPlanpagos(), $p);
                $plan->setAcuerdoid($acuerdo);
                $dbm->saveRepositorio($plan);
            }

             //Guardamos la bitacora
             $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
             $alumnos = $dbma->BuscarAlumnosA(["alumnoid" => $data["alumnosid"]])[0];
             $data["acuerdoid"] = $acuerdo->getAcuerdoid();
             $data["clavefamiliarid"] = $alumnos["clavefamiliarid"];
             $data["fecha"] = new \DateTime();
             $data["hora"] = new \DateTime();
             $data["mediocontactoid"] = 5;
             $bitacora = $hydrator->hydrate(new CbSeguimiento(), $data);
             $dbm->saveRepositorio($bitacora);

            $dbm->getConnection()->commit();

            $planpagos = $dbm->getRepositoriosById('CbPlanpagos', 'acuerdoid', $acuerdo->getAcuerdoid());

            return new View(array("msj" => "Se ha guardado el registro", "acuerdoid" => $acuerdo->getAcuerdoid(), "planpagos" => $planpagos), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Cobranza/Acuerdo/{id}" , name="ActualizarAcuerdo")
     */
    public function updateAcuerdo($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            //Modifico el acuerdo
            $data['padresotutoresid'] = $data["padreid"][0];
            $data['fechaultimamodificacion'] = new \DateTime();
            $data['fechacreacion'] = null;
            $data['vigenciainicio'] = new \DateTime($data["vigencia"]["beginDate"]["day"] . "-" . $data["vigencia"]["beginDate"]["month"] . "-" . $data["vigencia"]["beginDate"]["year"]);
            $data['vigenciafin'] = new \DateTime($data["vigencia"]["endDate"]["day"] . "-" . $data["vigencia"]["endDate"]["month"] . "-" . $data["vigencia"]["endDate"]["year"]);

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $acuerdo = $hydrator->hydrate($dbm->getRepositorioById('CbAcuerdo', 'acuerdoid', $id), $data);
            $dbm->saveRepositorio($acuerdo);

            //Eliminamod los registros relacionales de los alumnos y el acuerdo
            $dbm->removeManyRepositorio('CbAlumnoporacuerdo', 'acuerdoid', $id);
            //Re-asignamos los alumnos al acuerdo
            foreach ($data["alumnosid"] as $a) {
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $a);
                $acuerdoporalumno = new CbAlumnoporacuerdo();
                $acuerdoporalumno->setAlumnoid($alumno);
                $acuerdoporalumno->setAcuerdoid($acuerdo);
                $acuerdoporalumno->setImporte(0); // Pendiente modificar
                $dbm->saveRepositorio($acuerdoporalumno);
            }

            //Se quitan las relaciones previas de los documentos al acuerdo
            $documentos = $dbm->getRepositoriosById('CjDocumentoporpagar', 'acuerdoid', $id);
            foreach ($documentos as $d) {
                $d->setAcuerdoid(null);
                $d->setTipoacuerdoid(null);
                $d->setPorcentaje(null);
                $d->setVigenciaacuerdo(null);
                $dbm->saveRepositorio($d);
            }
            //Se agergan las relaciones nuevas de los documentos al acuerdo
            foreach ($data["documentoporpagar"] as $d) {
                if ($d["tipoacuerdoid"]) {
                    $documento = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $d["documentoporpagarid"]);
                    $documento->setAcuerdoid($acuerdo);
                    $documento->setTipoacuerdoid($dbm->getRepositorioById('CbTipoacuerdo', 'tipoacuerdoid', $d["tipoacuerdoid"]));
                    $documento->setPorcentaje($d["porcentaje"]);
                    $d['vigencia'] = new \DateTime($d["vigencia"]["date"]["day"] . "-" . $d["vigencia"]["date"]["month"] . "-" . $d["vigencia"]["date"]["year"]);
                    $documento->setVigenciaacuerdo($d['vigencia']);
                    $dbm->saveRepositorio($documento);
                }
            }

            //Si se quitaron planes de pagos, los eliminamos
            foreach ($data["planpagoseliminadosid"] as $p) {
                $plan = $dbm->getRepositorioById('CbPlanpagos', 'planpagosid', $p);
                $dbm->removeRepositorio($plan);
            }
            //Insertamos o actualizamos los planes de pago
            foreach ($data["planpagos"] as $p) {
                if ($p["editado"]) {
                    $p["fechacompromiso"] = new \DateTime($p["fechacompromiso"]["date"]["day"] . "-" . $p["fechacompromiso"]["date"]["month"] . "-" . $p["fechacompromiso"]["date"]["year"]);
                    $plan = $hydrator->hydrate($p["planpagosid"] ? $dbm->getRepositorioById('CbPlanpagos', 'planpagosid', $p["planpagosid"]) : new CbPlanpagos(), $p);
                    $plan->setAcuerdoid($acuerdo);
                    $dbm->saveRepositorio($plan);
                }
            }

            //Guardamos la bitacora
            $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumnos = $dbma->BuscarAlumnosA(["alumnoid" => $data["alumnosid"]])[0];
            $data["clavefamiliarid"] = $alumnos["clavefamiliarid"];
            $data["fecha"] = new \DateTime();
            $data["hora"] = new \DateTime();
            $data["mediocontactoid"] = 5;
            $bitacora = $hydrator->hydrate(new CbSeguimiento(), $data);
            $dbm->saveRepositorio($bitacora);

            $dbm->getConnection()->commit();

            $planpagos = $dbm->getRepositoriosById('CbPlanpagos', 'acuerdoid', $id);

            return new View(array("msj" => "Se ha guardado el registro", "acuerdoid" => $id, "planpagos" => $planpagos), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna
     * @Rest\Get("/api/Cobranza/Acuerdo/Modaldocumentos/{id}", name="AcuerdoModalDocumento")
     */
    public function getAcuerdoModalDocumento($id)
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $documentos = $dbm->getRepositoriosById('CbDocumentogarantia', 'acuerdoid', $id);
            $tipogarantia = $dbm->getRepositoriosById('CbTipogarantia', 'activo', 1);
            return new View(array("documentos" => $documentos, "tipogarantia" => $tipogarantia), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna
     * @Rest\Post("/api/Cobranza/Acuerdo/Modaldocumentos/{id}", name="GuardarAcuerdoModalDocumento")
     */
    public function saveAcuerdoModalDocumento($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($datos["documentoseliminadosid"] as $d) {
                $documento = $dbm->getRepositorioById('CbDocumentogarantia', 'documentogarantiaid', $d);
                $dbm->removeRepositorio($documento);
            }

            foreach ($datos["documentos"] as $d) {
                $documento = $d["documentogarantiaid"] ? $dbm->getRepositorioById('CbDocumentogarantia', 'documentogarantiaid', $d["documentogarantiaid"]) : new CbDocumentogarantia();
                $documento->setTipogarantiaid($dbm->getRepositorioById('CbTipogarantia', 'tipogarantiaid', $d["tipogarantiaid"]));
                $documento->setAcuerdoid($dbm->getRepositorioById('CbAcuerdo', 'acuerdoid', $id));
                $documento->setImporte($d["importe"]);
                $documento->setDescripcion($d["descripcion"]);
                if ($d["formato"] || !$d["documentogarantiaid"]) {
                    $documento->setArchivotipo($d["formato"]["filetype"]);
                    $documento->setArchivosize($d["formato"]["size"]);
                    $documento->setArchivo($d["formato"]["value"]);
                }
                $dbm->saveRepositorio($documento);
            }

            $dbm->getConnection()->commit();

            $documentos = $dbm->getRepositoriosById('CbDocumentogarantia', 'acuerdoid', $id);
            return new View(array("msj" => "Se ha guardado el registro", "documentos" => $documentos), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo
     * @Rest\Get("/api/Cobranza/Acuerdo/Modaldocumentos/Descargar/{id}", name="DescargarAcuerdoModalDocumento")
     */
    public function downloadAcuerdoModalDocumento($id)
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $Formato = $dbm->getRepositorioById('CbDocumentogarantia', 'documentogarantiaid', $id);
            $response = new \Symfony\Component\HttpFoundation\Response(
                base64_decode(stream_get_contents($Formato->getArchivo())),
                200,
                array(
                    'Content-Type' => $Formato->getArchivotipo(),
                    'Content-Length' => $Formato->getArchivosize()
                )
            );
            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna
     * @Rest\Get("/api/Cobranza/Acuerdo/Modalbitacora/{id}", name="AcuerdoModalBitacora")
     */
    public function getAcuerdoModalBitacora($id)
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $bitacora = $dbm->getRepositoriosById('CbSeguimiento', 'acuerdoid', $id);
            $mediocontacto = $dbm->getRepositoriosById('CbMediocontacto', 'activo', 1);
            return new View(array("bitacora" => $bitacora, "mediocontacto" => $mediocontacto), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna
     * @Rest\Post("/api/Cobranza/Acuerdo/Modalbitacora/{id}", name="GuardarAcuerdoModalBitacora")
     */
    public function saveAcuerdoModalBitacora($id)
    {
        try {
            $datos = $_REQUEST;
            $datos = json_decode($datos["datos"], true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($datos["bitacoraeliminadosid"] as $d) {
                $bitacora = $dbm->getRepositorioById('CbSeguimiento', 'seguimientoid', $d);
                $dbm->removeRepositorio($bitacora);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            foreach ($datos["bitacoras"] as $d) {
                if ($d["editado"]) {
                    $d["acuerdoid"] = $id;
                    $d["clavefamiliarid"] = $datos["clavefamiliarid"];
                    $d["fecha"] = new \DateTime();
                    $d["hora"] = new \DateTime();
                    $bitacora = $hydrator->hydrate($d["seguimientoid"] ? $dbm->getRepositorioById('CbSeguimiento', 'seguimientoid', $d["seguimientoid"]) : new CbSeguimiento(), $d);
                    $dbm->saveRepositorio($bitacora);
                }
            }

            $dbm->getConnection()->commit();

            $bitacoras = $dbm->getRepositoriosById('CbSeguimiento', 'acuerdoid', $id);
            return new View(array("msj" => "Se ha guardado el registro", "bitacoras" => $bitacoras), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
