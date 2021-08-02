<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeConjuntoperiodoevaluacion;
use AppBundle\Entity\CeGradoporconjuntoperiodoescolar;
use AppBundle\Entity\CePeriodoevaluacion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class PeriodoEvaluacionController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/PeriodoEvaluacion", name="indexPeriodoEvaluacion")
     */
    public function indexPeriodoEvaluacion()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclos = $dbm->BuscarCiclo(array("activo" => 1));
            $grados = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $niveles = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            return new View(array("ciclo" => $ciclos, "grado" => $grados, "nivel" => $niveles, "semestre" => $semestre), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Periodos de evaluacion en base a los parametros enviados
     * @Rest\Get("/api/Controlescolar/PeriodoEvaluacion/", name="BuscarPeriodoEvaluacion")
     */
    public function getPeriodoEvaluacion()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarPeriodoEvaluacion($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }

            foreach ($entidad as $i => $ent) {
                $editable = true;
                $periodos = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $ent["conjuntoperiodoevaluacionid"], "fechainicio");
                $periodosarray = null;
                $periodoarray = null;
                foreach ($periodos as $periodo) {
                    $criterioasociado = $dbm->getRepositorioById("CeCriterioevaluacion", "periodoevaluacionid", $periodo->getPeriodoevaluacionid());
                    if ($criterioasociado) {
                        $editable = false;
                    }
                    $periodoarray = (array) $periodo;
                    $periodoarray = array_values($array);

                    $periodoarray["periodoevaluacionid"] = $periodo->getPeriodoevaluacionid();
                    $periodoarray["descripcion"] = $periodo->getDescripcion();
                    $periodoarray["descripcioncorta"] = $periodo->getDescripcioncorta();
                    $periodoarray["fechafin"] = ($periodo->getFechafin()) ? $periodo->getFechafin()->format('d/m/Y') : null;
                    $periodoarray["fechainicio"] = ($periodo->getFechainicio()) ? $periodo->getFechainicio()->format('d/m/Y') : null;
                    $periodoarray["fechalimedicionplantilla"] = ($periodo->getFechalimedicionplantilla()) ? $periodo->getFechalimedicionplantilla()->format('d/m/Y') : null;
                    $periodoarray["fechalimedicionprofesor"] = ($periodo->getFechalimedicionprofesor()) ? $periodo->getFechalimedicionprofesor()->format('d/m/Y') : null;
                    $periodoarray["fechacapturacalinicio"] = ($periodo->getFechacapturacalinicio()) ? $periodo->getFechacapturacalinicio()->format('d/m/Y') : null;
                    $periodoarray["fechacapturacalfin"] = ($periodo->getFechacapturacalfin()) ? $periodo->getFechacapturacalfin()->format('d/m/Y') : null;
                    $periodoarray["fechapublicacionprevia"] = ($periodo->getFechapublicacionprevia()) ? $periodo->getFechapublicacionprevia()->format('d/m/Y') : null;
                    $periodoarray["fechaperiodorevisioninicio"] = ($periodo->getFechaperiodorevisioninicio()) ? $periodo->getFechaperiodorevisioninicio()->format('d/m/Y') : null;
                    $periodoarray["fechaperiodorevisionfin"] = ($periodo->getFechaperiodorevisionfin()) ? $periodo->getFechaperiodorevisionfin()->format('d/m/Y') : null;
                    $periodoarray["fechapublicaciondefinitiva"] = ($periodo->getFechapublicaciondefinitiva()) ? $periodo->getFechapublicaciondefinitiva()->format('d/m/Y') : null;
                    $periodoarray["porcentajecalificacionfinal"] = $periodo->getPorcentajecalificacionfinal();
                    $periodosarray[] = $periodoarray;
                }

                $entidad[$i]["periodo"] = $periodosarray;
                $entidad[$i]["editable"] = $editable;
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/PeriodoEvaluacion" , name="GuardarPeriodoEvaluacion")
     */
    public function SavePeriodoEvaluacion()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $conjunto = $dbm->BuscarPeriodoEvaluacion(array('cicloid' => $data['cicloid'], "gradoid" => $data['gradoid']));
            if ($conjunto) {
                return new View("Ya existe un registro en el mismo ciclo y grado", Response::HTTP_PARTIAL_CONTENT);
            }

            $Conjunto = new CeConjuntoperiodoevaluacion();
            $Conjunto->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $data["cicloid"]));
            $Conjunto->setPromediable($data["promediable"]);
            $dbm->saveRepositorio($Conjunto);

            foreach ($data["gradoid"] as $grado) {
                $Grado = new CeGradoporconjuntoperiodoescolar();
                $Grado->setConjuntoperiodoevaluacionid($Conjunto);
                $Grado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                $dbm->saveRepositorio($Grado);
            }

            $ciclopornivel = $dbm->getByParametersRepositorios('CeCiclopornivel', array("cicloid" => $data['cicloid'], "nivelid" => $data['nivelid']))[0];
            foreach ($data["periodoevaluacion"] as $key => $periodo) {
                $dateinicio = new \DateTime($periodo["fecha"]["beginDate"]["year"] . "-" . $periodo["fecha"]["beginDate"]["month"] . "-" . $periodo["fecha"]["beginDate"]["day"]);
                $datefin = new \DateTime($periodo["fecha"]["endDate"]["year"] . "-" . $periodo["fecha"]["endDate"]["month"] . "-" . $periodo["fecha"]["endDate"]["day"]);
                $datelimedicionplantilla = new \DateTime($periodo["fechalimedicionplantilla"]["date"]["year"] . "-" . $periodo["fechalimedicionplantilla"]["date"]["month"] . "-" . $periodo["fechalimedicionplantilla"]["date"]["day"]);
                $datelimedicionprofesor = new \DateTime($periodo["fechalimedicionprofesor"]["date"]["year"] . "-" . $periodo["fechalimedicionprofesor"]["date"]["month"] . "-" . $periodo["fechalimedicionprofesor"]["date"]["day"]);
                $datecapturacalinicio = new \DateTime($periodo["fechacapturacal"]["beginDate"]["year"] . "-" . $periodo["fechacapturacal"]["beginDate"]["month"] . "-" . $periodo["fechacapturacal"]["beginDate"]["day"]);
                $datecapturacalfin = new \DateTime($periodo["fechacapturacal"]["endDate"]["year"] . "-" . $periodo["fechacapturacal"]["endDate"]["month"] . "-" . $periodo["fechacapturacal"]["endDate"]["day"]);
                $datepublicacionprevia = new \DateTime($periodo["fechapublicacionprevia"]["date"]["year"] . "-" . $periodo["fechapublicacionprevia"]["date"]["month"] . "-" . $periodo["fechapublicacionprevia"]["date"]["day"]);
                $dateperiodorevisioninicio = new \DateTime($periodo["fechaperiodorevision"]["beginDate"]["year"] . "-" . $periodo["fechaperiodorevision"]["beginDate"]["month"] . "-" . $periodo["fechaperiodorevision"]["beginDate"]["day"]);
                $dateperiodorevisionfin = new \DateTime($periodo["fechaperiodorevision"]["endDate"]["year"] . "-" . $periodo["fechaperiodorevision"]["endDate"]["month"] . "-" . $periodo["fechaperiodorevision"]["endDate"]["day"]);
                $datepublicaciondefinitiva = new \DateTime($periodo["fechapublicaciondefinitiva"]["date"]["year"] . "-" . $periodo["fechapublicaciondefinitiva"]["date"]["month"] . "-" . $periodo["fechapublicaciondefinitiva"]["date"]["day"]);

                $msj = " del periodo " . $periodo["descripcioncorta"];


                $Periodo = new CePeriodoevaluacion();
                $Periodo->setDescripcion($periodo["descripcion"]);
                $Periodo->setDescripcioncorta($periodo["descripcioncorta"]);
                $Periodo->setPorcentajecalificacionfinal($periodo["porcentajecalificacionfinal"]);
                $Periodo->setConjuntoperiodoevaluacionid($Conjunto);
                $Periodo->setFechaInicio($dateinicio);
                $Periodo->setFechafin($datefin);
                $Periodo->setFechalimedicionplantilla($datelimedicionplantilla);
                $Periodo->setFechalimedicionprofesor($datelimedicionprofesor);
                $Periodo->setFechacapturacalinicio($datecapturacalinicio);
                $Periodo->setFechacapturacalfin($datecapturacalfin);
                $Periodo->setFechapublicacionprevia($datepublicacionprevia);
                $Periodo->setFechaperiodorevisioninicio($dateperiodorevisioninicio);
                $Periodo->setFechaperiodorevisionfin($dateperiodorevisionfin);
                $Periodo->setFechapublicaciondefinitiva($datepublicaciondefinitiva);

                $dbm->saveRepositorio($Periodo);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * @Rest\Put("/api/Controlescolar/PeriodoEvaluacion/{id}" , name="ActualizaPeriodoEvaluacion")
     */
    public function updatePeriodoEvaluacion($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $conjunto = $dbm->BuscarPeriodoEvaluacion(array('cicloid' => $data['cicloid'], "gradoid" => $data['gradoid']));
            if ($conjunto) {
                foreach ($conjunto as $c) {
                    if ($c["conjuntoperiodoevaluacionid"] != $id) {
                        return new View("Ya existe un registro en el mismo ciclo y grado.", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Conjunto = $dbm->getRepositorioById('CeConjuntoperiodoevaluacion', 'conjuntoperiodoevaluacionid', $id);
            $Conjunto->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $data["cicloid"]));
            $Conjunto->setPromediable($data["promediable"]);
            $dbm->saveRepositorio($Conjunto);
            $dbm->removeManyRepositorio("CeGradoporconjuntoperiodoescolar", 'conjuntoperiodoevaluacionid', $id);
            foreach ($data["gradoid"] as $grado) {
                $Grado = new CeGradoporconjuntoperiodoescolar();
                $Grado->setConjuntoperiodoevaluacionid($Conjunto);
                $Grado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                $dbm->saveRepositorio($Grado);
            }

            $ciclopornivel = $dbm->getByParametersRepositorios('CeCiclopornivel', array("cicloid" => $data['cicloid'], "nivelid" => $data['nivelid']))[0];
            foreach ($data["periodoevaluacion"] as $key => $periodo) {
                $dateinicio = new \DateTime($periodo["fecha"]["beginDate"]["year"] . "-" . $periodo["fecha"]["beginDate"]["month"] . "-" . $periodo["fecha"]["beginDate"]["day"]);
                $datefin = new \DateTime($periodo["fecha"]["endDate"]["year"] . "-" . $periodo["fecha"]["endDate"]["month"] . "-" . $periodo["fecha"]["endDate"]["day"]);
                $datelimedicionplantilla = new \DateTime($periodo["fechalimedicionplantilla"]["date"]["year"] . "-" . $periodo["fechalimedicionplantilla"]["date"]["month"] . "-" . $periodo["fechalimedicionplantilla"]["date"]["day"]);
                $datelimedicionprofesor = new \DateTime($periodo["fechalimedicionprofesor"]["date"]["year"] . "-" . $periodo["fechalimedicionprofesor"]["date"]["month"] . "-" . $periodo["fechalimedicionprofesor"]["date"]["day"]);
                $datecapturacalinicio = new \DateTime($periodo["fechacapturacal"]["beginDate"]["year"] . "-" . $periodo["fechacapturacal"]["beginDate"]["month"] . "-" . $periodo["fechacapturacal"]["beginDate"]["day"]);
                $datecapturacalfin = new \DateTime($periodo["fechacapturacal"]["endDate"]["year"] . "-" . $periodo["fechacapturacal"]["endDate"]["month"] . "-" . $periodo["fechacapturacal"]["endDate"]["day"]);
                $datepublicacionprevia = new \DateTime($periodo["fechapublicacionprevia"]["date"]["year"] . "-" . $periodo["fechapublicacionprevia"]["date"]["month"] . "-" . $periodo["fechapublicacionprevia"]["date"]["day"]);
                $dateperiodorevisioninicio = new \DateTime($periodo["fechaperiodorevision"]["beginDate"]["year"] . "-" . $periodo["fechaperiodorevision"]["beginDate"]["month"] . "-" . $periodo["fechaperiodorevision"]["beginDate"]["day"]);
                $dateperiodorevisionfin = new \DateTime($periodo["fechaperiodorevision"]["endDate"]["year"] . "-" . $periodo["fechaperiodorevision"]["endDate"]["month"] . "-" . $periodo["fechaperiodorevision"]["endDate"]["day"]);
                $datepublicaciondefinitiva = new \DateTime($periodo["fechapublicaciondefinitiva"]["date"]["year"] . "-" . $periodo["fechapublicaciondefinitiva"]["date"]["month"] . "-" . $periodo["fechapublicaciondefinitiva"]["date"]["day"]);

                $msj = " del periodo " . $periodo["descripcioncorta"];


                if (isset($periodo["periodoevaluacionid"])) {
                    $Periodo = $dbm->getRepositorioById('CePeriodoevaluacion', 'periodoevaluacionid', $periodo["periodoevaluacionid"]);
                } else {
                    $Periodo = new CePeriodoevaluacion();
                }

                $Periodo->setDescripcion($periodo["descripcion"]);
                $Periodo->setDescripcioncorta($periodo["descripcioncorta"]);
                $Periodo->setPorcentajecalificacionfinal($periodo["porcentajecalificacionfinal"]);
                $Periodo->setConjuntoperiodoevaluacionid($Conjunto);
                $Periodo->setFechaInicio($dateinicio);
                $Periodo->setFechafin($datefin);
                $Periodo->setFechalimedicionplantilla($datelimedicionplantilla);
                $Periodo->setFechalimedicionprofesor($datelimedicionprofesor);
                $Periodo->setFechacapturacalinicio($datecapturacalinicio);
                $Periodo->setFechacapturacalfin($datecapturacalfin);
                $Periodo->setFechapublicacionprevia($datepublicacionprevia);
                $Periodo->setFechaperiodorevisioninicio($dateperiodorevisioninicio);
                $Periodo->setFechaperiodorevisionfin($dateperiodorevisionfin);
                $Periodo->setFechapublicaciondefinitiva($datepublicaciondefinitiva);
                $dbm->saveRepositorio($Periodo);
            }

            foreach ($data["periodoevaluacioneliminado"] as $periodo) {
                $Periodo = $dbm->getRepositorioById('CePeriodoevaluacion', 'periodoevaluacionid', $periodo);
                $dbm->removeRepositorio($Periodo);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede actualizar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }



    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/PeriodoEvaluacion/{id}", name="EliminarPeriodoEvaluacion")
     */
    public function deletePeriodoEvaluacion($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $conjunto = $dbm->getRepositorioById('CeConjuntoperiodoevaluacion', 'conjuntoperiodoevaluacionid', $id);
            $dbm->removeManyRepositorio("CeGradoporconjuntoperiodoescolar", 'conjuntoperiodoevaluacionid', $id);
            $dbm->removeManyRepositorio("CePeriodoevaluacion", 'conjuntoperiodoevaluacionid', $id);
            $dbm->removeRepositorio($conjunto);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se han creado platillas de criterios para los semestres.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
