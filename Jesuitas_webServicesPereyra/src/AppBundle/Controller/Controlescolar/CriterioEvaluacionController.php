<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeConjuntocriterioevaluacion;
use AppBundle\Entity\CeCriterioevaluacion;
use AppBundle\Entity\CeCriterioevaluaciongrupo;
use AppBundle\Entity\CeMateriaporplanestudios;
use AppBundle\Entity\CePlanestudios;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Proxies\__CG__\AppBundle\Entity\CeConjuntocriteriosportaller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class CriterioEvaluacionController extends FOSRestController
{

    private function checaPorcentaje($conjuntocriterioevaluacionid)
    {

        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $conjunto = $dbm->getRepositorioById("CeConjuntocriterioevaluacion", "conjuntocriterioevaluacionid", $conjuntocriterioevaluacionid);
        if (!$conjunto->getMateriaporplanestudioid()) {
            $conjuntosportaller = $dbm->getRepositorioById("CeConjuntocriteriosportaller", "conjuntocriterioevaluacionid", $conjunto->getConjuntocriterioevaluacionid());
            $materiasplanestudio = $conjuntosportaller->getMateriaporplanestudioid();
        } else {
            $materiasplanestudio = $dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $conjunto->getMateriaporplanestudioid()->getMateriaporplanestudioid());
        }
        $conjuntoperiodo = $dbm->BuscarPeriodoEvaluacion(array("cicloid" => $conjunto->getCicloid(), "gradoid" => $materiasplanestudio->getPlanestudioid()->getGradoid()->getGradoid()));
        $periodos = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $conjuntoperiodo[0]["conjuntoperiodoevaluacionid"]);

        foreach ($periodos as $periodo) {
            $criterioscheck = $dbm->getByParametersRepositorios("CeCriterioevaluacion", array("periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "conjuntocriterioevaluacionid" => $conjuntocriterioevaluacionid));
            $sumas[$periodo->getPeriodoevaluacionid()] = 0;
            foreach ($criterioscheck as $criterio) {
                $sumas[$periodo->getPeriodoevaluacionid()] = $sumas[$periodo->getPeriodoevaluacionid()] + $criterio->getPorcentajecalificacion();
            }
        }
        $checksum = array_sum($sumas) / count($sumas);
        if ($checksum == 100) {
            return 2;
        } else {
            return 1;
        }
    }


    /**
     * Verifica los porcentaje d euna plantilla para cambiar el estatus a completo o incompleta
     */
    private static function checaPorcentajeGrupo($dbm, $profesorpormateriaplanestudiosid)
    {

        $profesorpormateriaplanestudios = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $profesorpormateriaplanestudiosid);
        //$materiaporplanestudio = $dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $materiaporplanestudioid);
        if ($profesorpormateriaplanestudios->getTallerid()) {
            $gradosportaller = $dbm->getRepositorioById("CeGradoportallercurricular", "tallercurricularid", $profesorpormateriaplanestudios->getTallerid()->getTallercurricularid());
            $materiaporplanestudio = $gradosportaller->getMateriaporplanestudioid();
            $conjuntoperiodo = $dbm->BuscarPeriodoEvaluacion(array("cicloid" => $profesorpormateriaplanestudios->getTallerid()->getCicloid()->getCicloid(), "gradoid" => $gradosportaller->getGradoid()->getGradoid()));
            $periodos = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $conjuntoperiodo[0]["conjuntoperiodoevaluacionid"]);

            foreach ($periodos as $periodo) {
                $criterioscheck = $dbm->getByParametersRepositorios("CeCriterioevaluaciongrupo", array("periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "profesorpormateriaplanestudiosid" => $profesorpormateriaplanestudiosid));
                $sumas[$periodo->getPeriodoevaluacionid()] = 0;
                foreach ($criterioscheck as $criterio) {
                    $sumas[$periodo->getPeriodoevaluacionid()] = $sumas[$periodo->getPeriodoevaluacionid()] + $criterio->getPorcentajecalificacion();
                }
            }
            $checksum = array_sum($sumas) / count($sumas);
            if ($checksum == 100) {
                return 2;
            } else {
                return 1;
            }
        } else {
            $materiaporplanestudio = $profesorpormateriaplanestudios->getMateriaporplanestudioid();
            $conjuntoperiodo = $dbm->BuscarPeriodoEvaluacion(array("cicloid" => $profesorpormateriaplanestudios->getPlantillaprofesorid()->getCicloid()->getCicloid(), "gradoid" => $materiaporplanestudio->getPlanestudioid()->getGradoid()->getGradoid()));
            $periodos = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $conjuntoperiodo[0]["conjuntoperiodoevaluacionid"]);

            foreach ($periodos as $periodo) {
                $criterioscheck = $dbm->getByParametersRepositorios("CeCriterioevaluaciongrupo", array("periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "profesorpormateriaplanestudiosid" => $profesorpormateriaplanestudiosid));
                $sumas[$periodo->getPeriodoevaluacionid()] = 0;
                foreach ($criterioscheck as $criterio) {
                    $sumas[$periodo->getPeriodoevaluacionid()] = $sumas[$periodo->getPeriodoevaluacionid()] + $criterio->getPorcentajecalificacion();
                }
            }
            $checksum = array_sum($sumas) / count($sumas);
            if ($checksum == 100) {
                return 2;
            } else {
                return 1;
            }
        }
    }


    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/Criterioevaluacion", name="indexCriterioEvaluacion")
     */
    public function indexCriterioEvaluacion()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclos = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $niveles = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grados = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('CeEstatuscriterioevaluacion', 'activo', 1);
            $planestudios = $dbm->getRepositorios('CePlanestudios');
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $materias = array();
            foreach ($planestudios as $p) {
                $materias = array_merge(
                    $materias,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid()]
                    )
                );
            }

            return new View(array("ciclo" => $ciclos, "nivel" => $niveles, "grado" => $grados, "materia" => $materias, "estatuscriterioevaluacion" => $estatus, "planestudios" => $planestudios, "semestre" => $semestre), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    private function getMateriasTalleres($materias, $talleres, $clasificador, $conjunto, $cicloid)
    {
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        foreach ($talleres as $taller) {
            if ($taller->getClasificadorparaescolaresid()->getClasificadorparaescolaresid() == $clasificador) {
                if ($taller->getCicloid()->getCicloid() == $cicloid) {
                    $gradoportaller = $dbm->getRepositoriosById('CeGradoportallercurricular', 'tallercurricularid', $taller->getTallercurricularid());
                    foreach ($gradoportaller as $gr) {
                        $gradporconjunto = $dbm->getOneByParametersRepositorio('CeGradoporconjuntoperiodoescolar', [
                            'gradoid' => $gr->getGradoid()->getGradoid(),
                            'conjuntoperiodoevaluacionid' => $conjunto
                        ]);
                        if ($gradporconjunto->getConjuntoperiodoevaluacionid()->getConjuntoperiodoevaluacionid() == $conjunto) {
                            $find = false;
                            foreach ($materias as $materia) {
                                if ($materia->getMateriaporplanestudioid() == $gr->getMateriaporplanestudioid()->getMateriaporplanestudioid()) {
                                    $find = true;
                                }
                            }
                            if (!$find) {
                                $materias[] = $gr->getMateriaporplanestudioid();
                            }
                        }
                    }
                }
            }
        }
        foreach ($materias as $materia) {
            $gradoportaller = $dbm->getRepositoriosById('CeGradoportallercurricular', 'materiaporplanestudioid', $materia->getMateriaporplanestudioid());
            foreach ($gradoportaller as $gr) {
                $gradporconjunto = $dbm->getOneByParametersRepositorio('CeGradoporconjuntoperiodoescolar', [
                    'gradoid' => $gr->getGradoid()->getGradoid(),
                    'conjuntoperiodoevaluacionid' => $conjunto
                ]);
                if ($gradporconjunto->getConjuntoperiodoevaluacionid()->getConjuntoperiodoevaluacionid() == $conjunto) {
                    $find = false;
                    foreach ($talleres as $taller) {
                        if ($taller->getTallercurricularid() == $gr->getTallercurricularid()->getTallercurricularid()) {
                            $find = true;
                        }
                    }
                    if (!$find) {
                        if ($gr->getTallercurricularid()->getCicloid()->getCicloid() == $cicloid) {
                            if ($gr->getTallercurricularid()->getClasificadorparaescolaresid()->getClasificadorparaescolaresid() == $clasificador) {
                                $talleres[] = $gr->getTallercurricularid();
                            }
                        }
                    }
                }
            }
        }
        return [count($talleres), $materias, $talleres];
    }

    /**
     * Retorna arreglo de Citerios de evaluacion en base a los parametros enviados
     * @Rest\Get("/api/Controlescolar/Criterioevaluacion/", name="BuscarCriterioEvaluacion")
     */
    public function getCriterioEvaluacion($datoscopia = null)
    {
        try {
            $datos = $datoscopia ? $datoscopia : $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $planestudio = $dbm->getRepositorioById("CePlanestudios", "planestudioid", $filtros["planestudioid"]);
            if (!$planestudio) {
                return new View("No se encontro el plan de estudio.", Response::HTTP_PARTIAL_CONTENT);
            }

            $materiasplanestudio = $dbm->getOneByParametersRepositorio("CeMateriaporplanestudios", array("planestudioid" => $filtros["planestudioid"], "materiaid" => $filtros["materiaid"]));
            if (!$materiasplanestudio) {
                return new View("No se configuró la materia para el plan de estudio vigente.", Response::HTTP_PARTIAL_CONTENT);
            }



            if ($materiasplanestudio->getComponentecurricularid()) {
                if ($materiasplanestudio->getComponentecurricularid()->getTipocalificacionid()->getTipocalificacionid() == 1) {
                    return new View("No se requiere crear criterios ya que el tipo de ponderación está configurado como cualitativa", Response::HTTP_PARTIAL_CONTENT);
                }
            }

            $gradoportaller = $dbm->getRepositoriosById('CeGradoportallercurricular', 'materiaporplanestudioid', $materiasplanestudio->getMateriaporplanestudioid());

            $gradporconjunto = $dbm->getRepositoriosModelo(
                "CeGradoporconjuntoperiodoescolar",
                ["d"],
                ["gradoid" => $filtros['gradoid']],
                false,
                false,
                [
                    ["entidad" => "CeConjuntoperiodoevaluacion", "alias" => "c", "on" => "c.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid and c.cicloid = " . $filtros['cicloid']]
                ]
            )[0];

            $talleres = [];
            $materias = [];

            $conjuntocriterios = $dbm->getByParametersRepositorios("CeConjuntocriterioevaluacion", array("cicloid" => $filtros["cicloid"], "materiaporplanestudioid" => $materiasplanestudio->getMateriaporplanestudioid()));
            if (count($gradoportaller) > 0) {
                foreach ($gradoportaller as $gr) {
                    $find = false;
                    foreach ($talleres as $taller) {
                        if ($taller->getTallercurricularid() == $gr->getTallercurricularid()->getTallercurricularid()) {
                            $find = true;
                        }
                    }
                    if (!$find) {
                        $talleres[] = $gr->getTallercurricularid();
                        $find = false;
                        foreach ($materias as $materia) {
                            if ($materia->getMateriaporplanestudioid() == $gr->getMateriaporplanestudioid()->getMateriaporplanestudioid()) {
                                $find = true;
                            }
                        }
                        if (!$find) {
                            $materias[] = $gr->getMateriaporplanestudioid();
                        }
                    }
                }

                $lastCount = count($talleres);
                $pass = true;
                while ($pass) {
                    if ($gradporconjunto) {
                        $respuesta = $this->getMateriasTalleres($materias, $talleres, $materiasplanestudio->getMateriaid()->getClasificadorparaescolaresid()->getClasificadorparaescolaresid(), $gradporconjunto->getConjuntoperiodoevaluacionid()->getConjuntoperiodoevaluacionid(), $filtros['cicloid']);
                    } else {
                        return new View("No se han encontrado talleres para el ciclo seleccionado.", Response::HTTP_PARTIAL_CONTENT);
                    }
                    $lastCount = $respuesta[0];
                    if (count($talleres) == $lastCount) {
                        $pass = false;
                    }
                    $materias = $respuesta[1];
                    $talleres = $respuesta[2];
                }

                //$conjuntocriteriosportaller = $dbm->getRepositorioById("CeConjuntocriteriosportaller", "materiaporplanestudioid", $materiasplanestudio[0]->getMateriaporplanestudioid());
                $conjuntocriteriosportaller = $dbm->getRepositoriosModelo(
                    "CeConjuntocriteriosportaller",
                    ["d"],
                    ["materiaporplanestudioid" => $materiasplanestudio->getMateriaporplanestudioid()],
                    false,
                    false,
                    [
                        ["entidad" => "CeConjuntocriterioevaluacion", "alias" => "c", "on" => "c.conjuntocriterioevaluacionid = d.conjuntocriterioevaluacionid and c.cicloid = " . $filtros['cicloid']]
                    ]
                )[0];

                $dbm->getConnection()->beginTransaction();
                if ($conjuntocriteriosportaller) {
                    $conjuntocriterios = $conjuntocriteriosportaller->getConjuntocriterioevaluacionid();
                    $conjuntocriteriosportallerall = $dbm->getRepositoriosById("CeConjuntocriteriosportaller", "conjuntocriterioevaluacionid",  $conjuntocriteriosportaller->getConjuntocriterioevaluacionid()->getConjuntocriterioevaluacionid());

                    foreach ($conjuntocriteriosportallerall as $cf) {
                        $find = false;
                        foreach ($materias as $m) {
                            if ($m->getMateriaporplanestudioid() == $cf->getMateriaporplanestudioid()->getMateriaporplanestudioid()) {
                                $find = true;
                            }
                        }
                        if (!$find) {
                            $dbm->removeRepositorio($cf);
                        }
                    }
                }
                $dbm->getConnection()->commit();
            }

            $mats = [];


            if (!$conjuntocriterios) {
                if (count($talleres) > 0) {
                    $dbm->getConnection()->beginTransaction();
                    $conjuntocriterioevaluacion = new CeConjuntocriterioevaluacion();
                    $conjuntocriterioevaluacion->setCicloid($dbm->getRepositorioById("Ciclo", "cicloid", $filtros["cicloid"]));
                    $conjuntocriterioevaluacion->setEstatuscriterioevaluacionid($dbm->getRepositorioById("CeEstatuscriterioevaluacion", "nombre", "Incompleto"));
                    $dbm->saveRepositorio($conjuntocriterioevaluacion);
                    foreach ($materias as $materia) {
                        //$conjuntoportaller = $dbm->getRepositorioById('CeConjuntocriteriosportaller', 'materiaporplanestudioid', $materia->getMateriaporplanestudioid());
                        $conjuntoportaller = $dbm->getRepositoriosModelo(
                            "CeConjuntocriteriosportaller",
                            ["d"],
                            ["materiaporplanestudioid" => $materia->getMateriaporplanestudioid()],
                            false,
                            false,
                            [
                                ["entidad" => "CeConjuntocriterioevaluacion", "alias" => "c", "on" => "c.conjuntocriterioevaluacionid = d.conjuntocriterioevaluacionid and c.cicloid = " . $filtros['cicloid']]
                            ]
                        )[0];
                        if (!$conjuntoportaller) {
                            $conjuntoportaller  = new CeConjuntocriteriosportaller();
                            $conjuntoportaller->setConjuntocriterioevaluacionid($conjuntocriterioevaluacion);
                            $conjuntoportaller->setMateriaporplanestudioid($materia);
                            $dbm->saveRepositorio($conjuntoportaller);
                        }
                    }
                    $dbm->getConnection()->commit();
                } else {
                    $dbm->getConnection()->beginTransaction();
                    $conjuntocriterioevaluacion = new CeConjuntocriterioevaluacion();
                    $conjuntocriterioevaluacion->setCicloid($dbm->getRepositorioById("Ciclo", "cicloid", $filtros["cicloid"]));
                    $conjuntocriterioevaluacion->setMateriaporplanestudioid($dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $materiasplanestudio->getMateriaporplanestudioid()));
                    $conjuntocriterioevaluacion->setEstatuscriterioevaluacionid($dbm->getRepositorioById("CeEstatuscriterioevaluacion", "nombre", "Incompleto"));
                    $dbm->saveRepositorio($conjuntocriterioevaluacion);
                    $dbm->getConnection()->commit();
                }
            } else {
                if (count($talleres) > 0) {
                    if (is_object($conjuntocriterios)) {
                        $conjuntocriterioevaluacion = $conjuntocriterios;
                    } else {
                        $conjuntocriterioevaluacion = $conjuntocriterios[0];
                    }
                    foreach ($materias as $materia) {
                        //$conjuntoportaller = $dbm->getRepositorioById('CeConjuntocriteriosportaller', 'materiaporplanestudioid', $materia->getMateriaporplanestudioid());
                        $conjuntoportaller = $dbm->getRepositoriosModelo(
                            "CeConjuntocriteriosportaller",
                            ["d"],
                            ["materiaporplanestudioid" => $materia->getMateriaporplanestudioid()],
                            false,
                            false,
                            [
                                ["entidad" => "CeConjuntocriterioevaluacion", "alias" => "c", "on" => "c.conjuntocriterioevaluacionid = d.conjuntocriterioevaluacionid and c.cicloid = " . $filtros['cicloid']]
                            ]
                        )[0];
                        if (!$conjuntoportaller) {
                            $conjuntoportaller  = new CeConjuntocriteriosportaller();
                            $conjuntoportaller->setConjuntocriterioevaluacionid($conjuntocriterioevaluacion);
                            $conjuntoportaller->setMateriaporplanestudioid($materia);
                            $dbm->saveRepositorio($conjuntoportaller);
                        }
                    }
                } else {
                    $conjuntocriterioevaluacion = $conjuntocriterios[0];
                }
            }

            $conjuntoperiodo = $dbm->BuscarPeriodoEvaluacion($filtros);
            if (!$conjuntoperiodo) {
                return new View("No existen periodos definidos en el grado y ciclo.", Response::HTTP_PARTIAL_CONTENT);
            }
            $periodos = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $conjuntoperiodo[0]["conjuntoperiodoevaluacionid"]);
            foreach ($periodos as $periodo) {
                $periodoarray = (array) $periodo;
                $periodoarray = array_values($array);
                $periodoarray["periodoevaluacionid"] = $periodo->getPeriodoevaluacionid();
                $periodoarray["descripcion"] = $periodo->getDescripcion();
                $periodoarray["descripcioncorta"] = $periodo->getDescripcioncorta();
                $periodoarray["fechafin"] = $periodo->getFechafin()->format('d/m/Y');
                $periodoarray["fechainicio"] = $periodo->getFechainicio()->format('d/m/Y');
                $periodoarray["porcentajecalificacionfinal"] = $periodo->getPorcentajecalificacionfinal();
                $periodoarray["criterioevaluacion"] = $dbm->getByParametersRepositorios("CeCriterioevaluacion", array("periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "conjuntocriterioevaluacionid" => $conjuntocriterioevaluacion->getConjuntocriterioevaluacionid()));
                $periodosarray[] = $periodoarray;
            }
            $mat = $conjuntocriterioevaluacion->getMateriaporplanestudioid();

            if (count($materias) > 0) {
                foreach ($materias as $mates) {
                    $mats[] = $mates->getMateriaid()->getNombre();
                    $mat = $mates;
                }
            } else {
                $mats[] = $mat->getMateriaid()->getNombre();
            }

            $mats = implode(', ', $mats);

            return new View(array("conjuntocriterioevaluacion" => $conjuntocriterioevaluacion, "periodoevaluacion" => $periodosarray, 'meteriaporplanestudios' => $mat, 'materias' => $mats), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Criterioevaluacion" , name="GuardarCriterioEvaluacion")
     */
    public function SaveCriterioEvaluacion()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $pe = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $data["periodoevaluacionid"]);
            $hoy = (new \DateTime())->setTime(0, 0, 0);
            if ($pe->getFechalimedicionplantilla() <= $hoy) {
                return new View("La fecha límite de edición de plantillas ha expirado", Response::HTTP_PARTIAL_CONTENT);
            }
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $criterioevaluacion = $hydrator->hydrate(new CeCriterioevaluacion(), $data);
            $dbm->saveRepositorio($criterioevaluacion);
            $conjunto = $dbm->getRepositorioById("CeConjuntocriterioevaluacion", "conjuntocriterioevaluacionid", $data["conjuntocriterioevaluacionid"]);
            $estatus = $dbm->getRepositorioById("CeEstatuscriterioevaluacion", "estatuscriterioevaluacionid", self::checaPorcentaje($data["conjuntocriterioevaluacionid"]));
            $conjunto->setEstatuscriterioevaluacionid($estatus);
            $dbm->saveRepositorio($conjunto);

            //Validamos si es un taller, verificando si tiene multiples relaciones a una materia
            $conjuntosportaller = $dbm->getRepositorioById("CeConjuntocriteriosportaller", "conjuntocriterioevaluacionid", $conjunto->getConjuntocriterioevaluacionid());

            if ($conjuntosportaller) {
                $materiaplanestudio = $conjuntosportaller->getMateriaporplanestudioid();
            } else {
                //Obtenemos la configuracion de la materia
                $materiaplanestudio = $dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $conjunto->getMateriaporplanestudioid()->getMateriaporplanestudioid());
            }

            //Cuando es taller
            if ($conjuntosportaller) {
                $talleres = $dbm->getByParametersRepositorios(
                    "CeConjuntocriteriosportaller",
                    array("conjuntocriterioevaluacionid" => $conjunto->getConjuntocriterioevaluacionid())
                );

                foreach ($talleres as $taller) {

                    $talleress = $dbm->getByParametersRepositorios(
                        "CeGradoportallercurricular",
                        array("materiaporplanestudioid" => $taller->getMateriaporplanestudioid())
                    );


                    foreach ($talleress as $t) {
                        $clases = $dbm->getByParametersRepositorios(
                            "CeProfesorpormateriaplanestudios",
                            array("tallerid" => $t->getTallercurricularid()->getTallercurricularid())
                        );
                        //Validamos si se encuentra la relación al grupo y materia con el profesor
                        if (!$clases) {
                            continue;
                        }



                        foreach ($clases as $profesorpormateriaplanestudios) {
                            //Validamos si la plantilla del profesor ya fue autorizada
                            if (!$profesorpormateriaplanestudios->getTallerid()) {
                                if ($profesorpormateriaplanestudios->getPlantillaprofesorid()->getEstatusplantillaprofesorid()->getEstatusplantillaprofesorid() != 3) {
                                    continue;
                                }
                            }

                            //Realizamos la copia
                            $criterioevaluaciongrupo = new CeCriterioevaluaciongrupo();
                            $criterioevaluaciongrupo->setAspecto($criterioevaluacion->getAspecto());
                            $criterioevaluaciongrupo->setDescripcion($criterioevaluacion->getDescripcion());
                            $criterioevaluaciongrupo->setPorcentajecalificacion($criterioevaluacion->getPorcentajecalificacion());
                            $criterioevaluaciongrupo->setCapturas($criterioevaluacion->getCapturas());
                            $criterioevaluaciongrupo->setPuntajemaximo($criterioevaluacion->getPuntajemaximo());
                            $criterioevaluaciongrupo->setEliminaraspecto($criterioevaluacion->getEliminaraspecto());
                            $criterioevaluaciongrupo->setEditarporcentajecalificacion($criterioevaluacion->getEditarporcentajecalificacion());
                            $criterioevaluaciongrupo->setEditarcapturas($criterioevaluacion->getEditarcapturas());
                            $criterioevaluaciongrupo->setEditarpuntajemaximo($criterioevaluacion->getEditarpuntajemaximo());
                            $criterioevaluaciongrupo->setMinimo($criterioevaluacion->getMinimo());
                            $criterioevaluaciongrupo->setMaximo($criterioevaluacion->getMaximo());
                            $criterioevaluaciongrupo->setConfigurartarea($criterioevaluacion->getConfigurartarea());
                            $criterioevaluaciongrupo->setProfesorpormateriaplanestudiosid($profesorpormateriaplanestudios);
                            $criterioevaluaciongrupo->setPeriodoevaluacionid($criterioevaluacion->getPeriodoevaluacionid());
                            $criterioevaluaciongrupo->setCriterioevaluacionid($criterioevaluacion);
                            $criterioevaluaciongrupo->setConfigurarexamen($criterioevaluacion->getConfigurarexamen());
                            $dbm->saveRepositorio($criterioevaluaciongrupo);

                            //Se Actualiza el estatus de la plantilla del profesor
                            $profesorpormateriaplanestudios->setEstatuscriterioevaluacionid($conjunto->getEstatuscriterioevaluacionid());
                            $dbm->saveRepositorio($profesorpormateriaplanestudios);

                            \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::re_calcularCalificacionesGrupo(
                                $dbm,
                                $profesorpormateriaplanestudios->getProfesorpormateriaplanestudiosid(),
                                $criterioevaluacion->getPeriodoevaluacionid()->getPeriodoevaluacionid()
                            );
                        }
                    }
                }
            }
            //Cuando es grupo
            else {
                /*
                Obtenemos llos grupos a los cuales se va a realizar la copia por el grado y ciclo: 
                Si la materia tiene configurado 'Configurar subgrupos', buscarmos grupos de tipo subgrupo divisor, de lo contrario grupos de tipo academico.
                Para 5 y 6 de bachillerato se filtra tambien por area de especializacion
                */
                $areaespecializacion = $materiaplanestudio->getPlanestudioid()->getAreaespecializacionid();
                if ($materiaplanestudio->getConfigurarsubgrupos()) {
                    $subgrupos = $dbm->BuscarSubgruposDivisor(array(
                        "gradoid" => $materiaplanestudio->getPlanestudioid()->getGradoid()->getGradoid(),
                        "cicloid" => $conjunto->getCicloid()->getCicloid(),
                        "areaespecializacionid" => $areaespecializacion,
                        "materiaid" => $materiaplanestudio->getMateriaporplanestudioid(),
                        'group' => true
                    ));
                    $grupos = array();
                    foreach ($subgrupos as $s) {
                        foreach (explode(",", $s["subgrupos"]) as $g) {
                            $grupos[] = ["grupoid" => $g];
                        }
                    }
                } else {
                    $grupos = $dbm->BuscarGrupos(array(
                        "gradoid" => $materiaplanestudio->getPlanestudioid()->getGradoid()->getGradoid(),
                        "cicloid" => $conjunto->getCicloid(),
                        "areaespecializacionid" => $areaespecializacion
                    ));
                }

                //Por cada grupo obtenido
                foreach ($grupos as $grupo) {
                    //Obtenemos los profesores que han sido asignados a la materia y al grupo o materias en caso de subgrupo
                    $clases = $dbm->getByParametersRepositorios(
                        "CeProfesorpormateriaplanestudios",
                        array("materiaporplanestudioid" => $materiaplanestudio->getMateriaporplanestudioid(), "grupoid" => $grupo["grupoid"])
                    );
                    //Validamos si se encuentra la relación al grupo y materia con el profesor
                    if (!$clases) {
                        continue;
                    }

                    foreach ($clases as $profesorpormateriaplanestudios) {
                        //Validamos si la plantilla del profesor ya fue autorizada
                        if (!$profesorpormateriaplanestudios->getTallerid()) {
                            if ($profesorpormateriaplanestudios->getPlantillaprofesorid()->getEstatusplantillaprofesorid()->getEstatusplantillaprofesorid() != 3) {
                                continue;
                            }
                        }


                        //Realizamos la copia
                        $criterioevaluaciongrupo = new CeCriterioevaluaciongrupo();
                        $criterioevaluaciongrupo->setAspecto($criterioevaluacion->getAspecto());
                        $criterioevaluaciongrupo->setDescripcion($criterioevaluacion->getDescripcion());
                        $criterioevaluaciongrupo->setPorcentajecalificacion($criterioevaluacion->getPorcentajecalificacion());
                        $criterioevaluaciongrupo->setCapturas($criterioevaluacion->getCapturas());
                        $criterioevaluaciongrupo->setPuntajemaximo($criterioevaluacion->getPuntajemaximo());
                        $criterioevaluaciongrupo->setEliminaraspecto($criterioevaluacion->getEliminaraspecto());
                        $criterioevaluaciongrupo->setEditarporcentajecalificacion($criterioevaluacion->getEditarporcentajecalificacion());
                        $criterioevaluaciongrupo->setEditarcapturas($criterioevaluacion->getEditarcapturas());
                        $criterioevaluaciongrupo->setEditarpuntajemaximo($criterioevaluacion->getEditarpuntajemaximo());
                        $criterioevaluaciongrupo->setMinimo($criterioevaluacion->getMinimo());
                        $criterioevaluaciongrupo->setMaximo($criterioevaluacion->getMaximo());
                        $criterioevaluaciongrupo->setConfigurartarea($criterioevaluacion->getConfigurartarea());
                        $criterioevaluaciongrupo->setProfesorpormateriaplanestudiosid($profesorpormateriaplanestudios);
                        $criterioevaluaciongrupo->setPeriodoevaluacionid($criterioevaluacion->getPeriodoevaluacionid());
                        $criterioevaluaciongrupo->setCriterioevaluacionid($criterioevaluacion);
                        $criterioevaluaciongrupo->setConfigurarexamen($criterioevaluacion->getConfigurarexamen());
                        $dbm->saveRepositorio($criterioevaluaciongrupo);

                        //Se Actualiza el estatus de la plantilla del profesor
                        $profesorpormateriaplanestudios->setEstatuscriterioevaluacionid($conjunto->getEstatuscriterioevaluacionid());
                        $dbm->saveRepositorio($profesorpormateriaplanestudios);

                        \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::re_calcularCalificacionesGrupo(
                            $dbm,
                            $profesorpormateriaplanestudios->getProfesorpormateriaplanestudiosid(),
                            $criterioevaluacion->getPeriodoevaluacionid()->getPeriodoevaluacionid()
                        );
                    }
                }
            }

            $dbm->getConnection()->commit();
            return new View(array("mensaje" => "Se ha guardado el registro", "criterioevaluacion" => $criterioevaluacion, "estatuscriterioevaluacion" => $estatus), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Controlescolar/Criterioevaluacion/{id}" , name="ActualizarCriterioEvaluacion")
     */
    public function updateCriterioEvaluacion($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $data['validar'];
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $criterioevaluacion = $hydrator->hydrate($dbm->getRepositorioById('CeCriterioevaluacion', 'criterioevaluacionid', $id), $data);
            $pe = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $criterioevaluacion->getPeriodoevaluacionid());
            $hoy = (new \DateTime())->setTime(0, 0, 0);
            if ($pe->getFechalimedicionplantilla() <= $hoy) {
                return new View("La fecha límite de edición de plantillas ha expirado.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->saveRepositorio($criterioevaluacion);
            $conjunto = $dbm->getRepositorioById("CeConjuntocriterioevaluacion", "conjuntocriterioevaluacionid", $criterioevaluacion->getConjuntocriterioevaluacionid());
            $estatus = $dbm->getRepositorioById("CeEstatuscriterioevaluacion", "estatuscriterioevaluacionid", self::checaPorcentaje($criterioevaluacion->getConjuntocriterioevaluacionid()->getConjuntocriterioevaluacionid()));
            $conjunto->setEstatuscriterioevaluacionid($estatus);
            $dbm->saveRepositorio($conjunto);

            $criteriosgrupo = $dbm->getRepositoriosById("CeCriterioevaluaciongrupo", "criterioevaluacionid", $criterioevaluacion);
            foreach ($criteriosgrupo as $cg) {
                if((intval($data['capturas']) < $cg->getCapturas()) && $validar ) {
                    for ($i=$data['capturas']+1; $i <= $cg->getCapturas() ; $i++) { 
                        $valor = $dbm->getRepositoriosModelo("CeCapturacalificacionporalumno", ["d"], 
                        [["calificacion is not null and d.numerocaptura =" . $i . " and d.criterioevaluaciongrupoid =" . $cg->getCriterioevaluaciongrupoid()]], false, true, [
                        ])[0];
                        
                        if($valor) {
                            $encontrado = true;
                            break;
                        }
                    }
                }

                if($encontrado) {
                    return new View(["calificaciones" => true], Response::HTTP_PARTIAL_CONTENT);
                }
    
                for ($i=$data['capturas']+1; $i <= $cg->getCapturas() ; $i++) { 
                    $registros = $dbm->getRepositoriosModelo("CeCapturacalificacionporalumno", ["d"], 
                    [["numerocaptura =" . $i . " and d.criterioevaluaciongrupoid =" . $cg->getCriterioevaluaciongrupoid()]], false, true, [
                    ]);
                    $dbm->removeBulkRepositorio($registros);
                }

                $criterioevaluaciongrupo = $hydrator->hydrate($cg, $data);
                $dbm->saveRepositorio($criterioevaluaciongrupo);

                \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::re_calcularCalificacionesGrupo(
                    $dbm,
                    $criterioevaluaciongrupo->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                    $criterioevaluaciongrupo->getPeriodoevaluacionid()->getPeriodoevaluacionid()
                );
            }

            $dbm->getConnection()->commit();
            return new View(array("mensaje" => "Se ha actualizado el registro", "criterioevaluacion" => $criterioevaluacion, "estatuscriterioevaluacion" => $estatus), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Criterioevaluacion/{id}", name="EliminarCriterioEvaluacion")
     */
    public function deleteCriterioEvaluacion($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $criterioevaluacion = $dbm->getRepositorioById('CeCriterioevaluacion', 'criterioevaluacionid', $id);
            $validar = strtolower($datos['validar']) == 'true' ? true : false;
            $pe = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $criterioevaluacion->getPeriodoevaluacionid());
            $hoy = (new \DateTime())->setTime(0, 0, 0);
            if ($pe->getFechalimedicionplantilla() <= $hoy) {
                return new View("La fecha límite de edición de plantillas ha expirado.", Response::HTTP_PARTIAL_CONTENT);
            }
            $criteriosgrupo = $dbm->getRepositoriosById("CeCriterioevaluaciongrupo", "criterioevaluacionid", $id);
            $resp = $this->EliminarCriterioevalgrupos($criteriosgrupo, $dbm, $validar);
            if ($resp['calificaciones']) {
                return new View(["calificaciones" => true], Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->removeManyRepositorio("CeCriterioevaluacion", 'criterioevaluacionid', $id);
            $conjunto = $dbm->getRepositorioById("CeConjuntocriterioevaluacion", "conjuntocriterioevaluacionid", $criterioevaluacion->getConjuntocriterioevaluacionid());
            $estatus = $dbm->getRepositorioById("CeEstatuscriterioevaluacion", "estatuscriterioevaluacionid", self::checaPorcentaje($conjunto->getConjuntocriterioevaluacionid()));
            $conjunto->setEstatuscriterioevaluacionid($estatus);
            $dbm->saveRepositorio($conjunto);
            $dbm->getConnection()->commit();
            return new View(array("mensaje" => "Se ha eliminado el registro", "conjuntocriterioevaluacion" => $conjunto, "estatuscriterioevaluacion" => $estatus), Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se ha asignado a grupos.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Criterioevaluacion/Copiaperiodo" , name="ClonarCriterioEvaluacionPeriodo")
     */
    public function cloneCriterioEvaluacionPeriodo()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $criterios = $dbm->getByParametersRepositorios("CeCriterioevaluacion", array("periodoevaluacionid" => $data["periodoevaluacionid"], "conjuntocriterioevaluacionid" => $data["conjuntocriterioevaluacionid"]));
            foreach ($criterios as $criterio) {
                $Criterio = new CeCriterioevaluacion();
                $Criterio = clone $criterio;
                $Criterio->setPeriodoevaluacionid($dbm->getRepositorioById('CePeriodoevaluacion', 'periodoevaluacionid', $data["nuevoperiodoevaluacionid"]));
                $dbm->saveRepositorio($Criterio);
            }
            $conjunto = $dbm->getRepositorioById("CeConjuntocriterioevaluacion", "conjuntocriterioevaluacionid", $data["conjuntocriterioevaluacionid"]);
            $estatus = $dbm->getRepositorioById("CeEstatuscriterioevaluacion", "estatuscriterioevaluacionid", self::checaPorcentaje($data["conjuntocriterioevaluacionid"]));
            $conjunto->setEstatuscriterioevaluacionid($estatus);
            $dbm->saveRepositorio($conjunto);
            $dbm->getConnection()->commit();
            $criterios = $dbm->getByParametersRepositorios("CeCriterioevaluacion", array("periodoevaluacionid" => $data["nuevoperiodoevaluacionid"], "conjuntocriterioevaluacionid" => $data["conjuntocriterioevaluacionid"]));
            return new View(array("mensaje" => "Se han copiado los registros", "criterioevaluacion" => $criterios, "estatuscriterioevaluacion" => $estatus), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Criterioevaluacion/Copia" , name="ClonarCriterioEvaluacionCiclo")
     */
    public function cloneCriterioEvaluacionCiclo()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $nuevosconjuntos = array();

            $conjunto = $dbm->getRepositorioById("CeConjuntocriterioevaluacion", "conjuntocriterioevaluacionid", $data["conjuntocriterioevaluacionid"]);

            $planestudioCopia = $dbm->getRepositorioById("CePlanestudios", "planestudioid", $data["planestudioidcopia"]);
            $materiaplanestudiocopia = $dbm->getOneByParametersRepositorio(
                "CeMateriaporplanestudios",
                array("materiaid" => $data["materiaidcopia"], "planestudioid" => $data['planestudioidcopia'])
            );

            foreach ($data["materiaid"] as $materiaid) {
                $materiasplanestudio = $dbm->getOneByParametersRepositorio(
                    "CeMateriaporplanestudios",
                    array("materiaid" => $materiaid, "planestudioid" => $data['planestudioid'])
                );

                //Validamos que la materia haya sido configurada en el plan de estudio destino
                if (!$materiasplanestudio) {
                    return new View("No se configuró la materia para el plan de estudio seleccionado.", Response::HTTP_PARTIAL_CONTENT);
                }
                //Validamos que las materia haya sido configurada de la misma forma como taller o grupo en plan de estudio origen y destino
                if ($materiaplanestudiocopia->getConfigurartaller() != $materiasplanestudio->getConfigurartaller()) {
                    return new View("Se encontro una diferencia en la configuracion de taller con la materia: " . $materiasplanestudio->getMateriaid()->getNombre(), Response::HTTP_PARTIAL_CONTENT);
                }

                //Busca en conjunto para ver si ya existe
                if ($materiasplanestudio->getConfigurartaller()) {
                    $conjuntostaller = $dbm->getRepositoriosModelo(
                        "CeConjuntocriteriosportaller",
                        ["d"],
                        ["materiaporplanestudioid" => $materiasplanestudio->getMateriaporplanestudioid()],
                        false,
                        false,
                        [
                            ["entidad" => "CeConjuntocriterioevaluacion", "alias" => "c", "on" => "c.conjuntocriterioevaluacionid = d.conjuntocriterioevaluacionid and c.cicloid = " . $data["cicloid"]]
                        ]
                    );
                    $conjuntocheck = $conjuntostaller ? $conjuntostaller[0]->getConjuntocriterioevaluacionid() : null;
                } else {
                    $conjuntocheck = $dbm->getOneByParametersRepositorio("CeConjuntocriterioevaluacion", array("cicloid" => $data["cicloid"], "materiaporplanestudioid" => $materiasplanestudio->getMateriaporplanestudioid()));
                }

                //Validamos si ya exite la plantilla
                if ($conjuntocheck) {
                    //Validamos si ya esta completada la plantilla
                    if ($conjuntocheck->getEstatuscriterioevaluacionid()->getEstatuscriterioevaluacionid() == 2) {
                        return new View("Ya se ha completado una plantilla para la materia y ciclo seleccionado", Response::HTTP_PARTIAL_CONTENT);
                    }
                    //Validamos si los criterios no se han copiado a los grupos
                    $criterios = $dbm->getRepositoriosById("CeCriterioevaluacion", "conjuntocriterioevaluacionid", $conjuntocheck->getConjuntocriterioevaluacionid());
                    foreach ($criterios as $c) {
                        if ($dbm->getRepositorioById("CeCriterioevaluaciongrupo", "criterioevaluacionid", $c->getCriterioevaluacionid())) {
                            return new View("La plantilla destino ya ha sido asignada a los grupos", Response::HTTP_PARTIAL_CONTENT);
                        }
                    }
                    $dbm->removeManyRepositorio("CeCriterioevaluacion", "conjuntocriterioevaluacionid", $conjuntocheck->getConjuntocriterioevaluacionid());
                    $dbm->removeManyRepositorio("CeConjuntocriteriosportaller", "conjuntocriterioevaluacionid", $conjuntocheck->getConjuntocriterioevaluacionid());
                    $dbm->removeManyRepositorio("CeConjuntocriterioevaluacion", "conjuntocriterioevaluacionid", $conjuntocheck->getConjuntocriterioevaluacionid());
                    //$dbm->removeRepositorio($conjuntocheck);
                }

                $creacion = $this->getCriterioEvaluacion([
                    'planestudioid' => $data['planestudioid'],
                    'materiaid' => $materiaid,
                    'cicloid' => $data["cicloid"],
                    'gradoid' => $materiasplanestudio->getPlanestudioid()->getGradoid()->getGradoid()
                ]);

                if ($creacion->getStatusCode() != 200) {
                    return new View($creacion->getData(), Response::HTTP_PARTIAL_CONTENT);
                }

                $Conjunto = $creacion->getData()["conjuntocriterioevaluacion"];
                $Conjunto->setEstatuscriterioevaluacionid($dbm->getRepositorioById("CeEstatuscriterioevaluacion", "estatuscriterioevaluacionid", 2));
                $dbm->saveRepositorio($Conjunto);

                $cporiginal = $dbm->BuscarPeriodoEvaluacion(array("cicloid" => $conjunto->getCicloid()->getCicloid(), "gradoid" => $planestudioCopia->getGradoid()));
                $cpdestino = $dbm->BuscarPeriodoEvaluacion(array("cicloid" => $data["cicloid"], "gradoid" => $planestudioCopia->getGradoid()));

                if (!$cpdestino) {
                    return new View("No existen periodos de evaluación configurados para este ciclo.", Response::HTTP_PARTIAL_CONTENT);
                }

                foreach ($cporiginal as $cconjuntooriginal) {
                    $periodosoriginal[] = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $cconjuntooriginal["conjuntoperiodoevaluacionid"]);
                }
                foreach ($cpdestino as $cconjuntodestino) {
                    $periodosdestino[] = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $cconjuntodestino["conjuntoperiodoevaluacionid"]);
                }

                if (count($periodosoriginal[0]) != count($periodosdestino[0])) {
                    return new View("El número de periodos de evaluación no es igual.", Response::HTTP_PARTIAL_CONTENT);
                }

                foreach ($periodosoriginal[0] as $llave => $periodo) {
                    $criterios = $dbm->getByParametersRepositorios(
                        "CeCriterioevaluacion",
                        array("periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "conjuntocriterioevaluacionid" => $data["conjuntocriterioevaluacionid"])
                    );
                    foreach ($criterios as $criterio) {
                        $Criterio = new CeCriterioevaluacion();
                        $Criterio = clone $criterio;
                        $Criterio->setConjuntocriterioevaluacionid($Conjunto);
                        $Criterio->setPeriodoevaluacionid($periodosdestino[0][$llave]);
                        $dbm->saveRepositorio($Criterio);
                    }
                }
                //Asignar a los grupos
                array_push($nuevosconjuntos, $Conjunto->getConjuntocriterioevaluacionid());
            }
            $dbm->getConnection()->commit();

            if ($data["asignar"]) {
                foreach ($nuevosconjuntos as $conjuntonuevo) {
                    $respuesta = $this->planestudiotest($conjuntonuevo);
                    if($respuesta->getStatuscode() != 200){
                        return new View("Se copiaron los criterios, pero no fue posible asignarlos a los grupos. <br>". $respuesta->getData(), Response::HTTP_OK);
                    }
                }
            }


            return new View("Se han copiado los registros.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/Controlescolar/Criterioevaluacion/Asignar/{id}", name="AsignarCriterioEvaluacionCiclo")
     */
    public function planestudiotest($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            //CeConjuntocriterioevaluacion
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = strtolower($data['validar']) == 'true' ? true : false;
            $fechaactual = new \DateTime();
            $fechaactual = $fechaactual->format('Y-m-d');

            //Obtenemos el conjunto de criterios a copiar
            $conjuntocriterioevaluacion = $dbm->getRepositorioById('CeConjuntocriterioevaluacion', 'conjuntocriterioevaluacionid', $id);
            //Validamos que la plantilla este en estatus Completo
            if (($conjuntocriterioevaluacion->getEstatuscriterioevaluacionid()->getEstatuscriterioevaluacionid()) != 2) {
                return new View("El estatus de la plantilla debe ser Completo", Response::HTTP_PARTIAL_CONTENT);
            }

            //Obtenemos los periodos para validar cual es el actual.
            $conjuntoperiodo = $dbm->BuscarPeriodoEvaluacion($data);
            if (!$conjuntoperiodo) {
                return new View("No existen periodos definidos en el grado y ciclo.", Response::HTTP_PARTIAL_CONTENT);
            }
            $periodos = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $conjuntoperiodo[0]["conjuntoperiodoevaluacionid"]);
            foreach ($periodos as $periodo) {
                $periodoarray = (array) $periodo;
                $periodoarray = array_values($array);
                $periodoarray["periodoevaluacionid"] = $periodo->getPeriodoevaluacionid();
                $periodoarray["descripcion"] = $periodo->getDescripcion();
                $periodosarray[] = $periodoarray;
            }
            $periodosids=array_values(array_unique(array_column($periodosarray, 'periodoevaluacionid')));
            //Validamos si es un taller, verificando si tiene multiples relaciones a una materia
            $conjuntosportaller = $dbm->getRepositorioById("CeConjuntocriteriosportaller", "conjuntocriterioevaluacionid", $id);

            if ($conjuntosportaller) {
                $materiaplanestudio = $conjuntosportaller->getMateriaporplanestudioid();
            } else {
                //Obtenemos la configuracion de la materia
                $materiaplanestudio = $dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $conjuntocriterioevaluacion->getMateriaporplanestudioid()->getMateriaporplanestudioid());
            }

            //Cuando es taller
            if ($conjuntosportaller) {
                $talleres = $dbm->getByParametersRepositorios(
                    "CeConjuntocriteriosportaller",
                    array("conjuntocriterioevaluacionid" => $conjuntocriterioevaluacion->getConjuntocriterioevaluacionid())
                );
                $criteriosevaluacion = $dbm->getRepositoriosById('CeCriterioevaluacion', 'conjuntocriterioevaluacionid', $id);

                if (!$talleres || count($talleres) == 0) {
                    return new View("No se encontraron talleres para asignar", Response::HTTP_PARTIAL_CONTENT);
                }
                foreach ($talleres as $taller) {
                    $talleress = $dbm->getRepositoriosModelo(
                        "CeGradoportallercurricular",
                        ["d"],
                        ["materiaporplanestudioid" => $taller->getMateriaporplanestudioid()],
                        false,
                        false,
                        [
                            ["entidad" => "CeTallercurricular", "alias" => "t", "on" => "t.tallercurricularid = d.tallercurricularid and t.cicloid = " . $taller->getConjuntocriterioevaluacionid()->getCicloid()->getCicloid()]
                        ]
                    );

                    foreach ($talleress as $t) {
                        $clases = $dbm->getByParametersRepositorios(
                            "CeProfesorpormateriaplanestudios",
                            array("tallerid" => $t->getTallercurricularid()->getTallercurricularid())
                        );


                        //Validamos si se encuentra la relación al grupo y materia con el profesor
                        if (!$clases) {
                            return new View("No se configuró la relación de profesores con la materia y talleres.", Response::HTTP_PARTIAL_CONTENT);
                        }



                        foreach ($clases as $profesorpormateriaplanestudios) {
                            //Validamos si la plantilla del profesor ya fue autorizada
                            if (!$profesorpormateriaplanestudios->getTallerid()) {
                                if ($profesorpormateriaplanestudios->getPlantillaprofesorid()->getEstatusplantillaprofesorid()->getEstatusplantillaprofesorid() != 3) {
                                    return new View("La plantilla de profesores no ha sido autorizada.", Response::HTTP_PARTIAL_CONTENT);
                                }
                            }
                            $criteriosgrupo = $dbm->getRepositoriosById("CeCriterioevaluaciongrupo", "profesorpormateriaplanestudiosid", $profesorpormateriaplanestudios->getProfesorpormateriaplanestudiosid());
                            $ids = implode($periodosids, ',');
                            $periodoactual = $dbm->getRepositoriosModelo(
                                "CePeriodoevaluacion",
                                ["d.periodoevaluacionid, d.descripcion"],
                                [["fechainicio <= '" . $fechaactual . "' and d.fechafin >= '" . $fechaactual ."' and d.periodoevaluacionid IN ($ids)" ]],
                                false,
                                true,
                                []
                            )[0];
                            $resp = $this->EliminarCriterioevalgrupos($criteriosgrupo, $dbm, $validar, true,$periodoactual);
                            if ($resp['calificaciones']) {
                                return new View(["calificaciones" => true], Response::HTTP_PARTIAL_CONTENT);
                            }

                            
                            //Realizamos la copia
                            foreach ($criteriosevaluacion as $criterio) {
                                $criterioevaluaciongrupo = new CeCriterioevaluaciongrupo();
                                $criterioevaluaciongrupo->setAspecto($criterio->getAspecto());
                                $criterioevaluaciongrupo->setDescripcion($criterio->getDescripcion());
                                $criterioevaluaciongrupo->setPorcentajecalificacion($criterio->getPorcentajecalificacion());
                                $criterioevaluaciongrupo->setCapturas($criterio->getCapturas());
                                $criterioevaluaciongrupo->setPuntajemaximo($criterio->getPuntajemaximo());
                                $criterioevaluaciongrupo->setEliminaraspecto($criterio->getEliminaraspecto());
                                $criterioevaluaciongrupo->setEditarporcentajecalificacion($criterio->getEditarporcentajecalificacion());
                                $criterioevaluaciongrupo->setEditarcapturas($criterio->getEditarcapturas());
                                $criterioevaluaciongrupo->setEditarpuntajemaximo($criterio->getEditarpuntajemaximo());
                                $criterioevaluaciongrupo->setMinimo($criterio->getMinimo());
                                $criterioevaluaciongrupo->setMaximo($criterio->getMaximo());
                                $criterioevaluaciongrupo->setConfigurartarea($criterio->getConfigurartarea());
                                $criterioevaluaciongrupo->setProfesorpormateriaplanestudiosid($profesorpormateriaplanestudios);
                                $criterioevaluaciongrupo->setPeriodoevaluacionid($criterio->getPeriodoevaluacionid());
                                $criterioevaluaciongrupo->setCriterioevaluacionid($criterio);
                                $criterioevaluaciongrupo->setConfigurarexamen($criterio->getConfigurarexamen());
                                $dbm->saveRepositorio($criterioevaluaciongrupo);
                            }
                            //Se Actualiza el estatus de la plantilla del profesor
                            $profesorpormateriaplanestudios->setEstatuscriterioevaluacionid($conjuntocriterioevaluacion->getEstatuscriterioevaluacionid());
                            $dbm->saveRepositorio($profesorpormateriaplanestudios);
                        }
                    }
                }
            }
            //Cuando es grupo
            else {
                /*
                Obtenemos llos grupos a los cuales se va a realizar la copia por el grado y ciclo: 
                Si la materia tiene configurado 'Configurar subgrupos', buscarmos grupos de tipo subgrupo divisor, de lo contrario grupos de tipo academico.
                Para 5 y 6 de bachillerato se filtra tambien por area de especializacion 
                */
                $areaespecializacion = $materiaplanestudio->getPlanestudioid()->getAreaespecializacionid();
                if ($materiaplanestudio->getConfigurarsubgrupos()) {
                    $subgrupos = $dbm->BuscarSubgruposDivisor(array(
                        "gradoid" => $materiaplanestudio->getPlanestudioid()->getGradoid()->getGradoid(),
                        "cicloid" => $conjuntocriterioevaluacion->getCicloid()->getCicloid(),
                        "areaespecializacionid" => $areaespecializacion,
                        "materiaid" => $materiaplanestudio->getMateriaporplanestudioid(),
                        'group' => true
                    ));
                    $grupos = array();
                    foreach ($subgrupos as $s) {
                        foreach (explode(",", $s["subgrupos"]) as $g) {
                            $grupos[] = ["grupoid" => $g];
                        }
                    }
                } else {
                    $grupos = $dbm->BuscarGrupos(array(
                        "gradoid" => $materiaplanestudio->getPlanestudioid()->getGradoid()->getGradoid(),
                        "cicloid" => $conjuntocriterioevaluacion->getCicloid(),
                        "areaespecializacionid" => $areaespecializacion
                    ));
                }

                //Obtenemos todos loas criterios a copiar
                $criteriosevaluacion = $dbm->getRepositoriosById('CeCriterioevaluacion', 'conjuntocriterioevaluacionid', $id);

                if (!$grupos || count($grupos) == 0) {
                    return new View("No se encontraron grupos para asignar", Response::HTTP_PARTIAL_CONTENT);
                }

                //Por cada grupo obtenido
                foreach ($grupos as $grupo) {
                    //Obtenemos los profesores que han sido asignados a la materia y al grupo o materias en caso de subgrupo
                    $clases = $dbm->getByParametersRepositorios(
                        "CeProfesorpormateriaplanestudios",
                        array("materiaporplanestudioid" => $materiaplanestudio->getMateriaporplanestudioid(), "grupoid" => $grupo["grupoid"])
                    );
                    //Validamos si se encuentra la relación al grupo y materia con el profesor
                    if (!$clases) {
                        return new View("No se configuró la relación de profesores con la materia y grupos.", Response::HTTP_PARTIAL_CONTENT);
                    }

                    foreach ($clases as $profesorpormateriaplanestudios) {
                        //Validamos si la plantilla del profesor ya fue autorizada
                        if (!$profesorpormateriaplanestudios->getTallerid()) {
                            if ($profesorpormateriaplanestudios->getPlantillaprofesorid()->getEstatusplantillaprofesorid()->getEstatusplantillaprofesorid() != 3) {
                                return new View("La plantilla de profesores no ha sido autorizada.", Response::HTTP_PARTIAL_CONTENT);
                            }
                        }

                        $criteriosgrupo = $dbm->getRepositoriosById("CeCriterioevaluaciongrupo", "profesorpormateriaplanestudiosid", $profesorpormateriaplanestudios->getProfesorpormateriaplanestudiosid());
                        $ids = implode($periodosids, ',');
                        $periodoactual = $dbm->getRepositoriosModelo(
                            "CePeriodoevaluacion",
                            ["d.periodoevaluacionid, d.descripcion"],
                            [["fechainicio <= '" . $fechaactual . "' and d.fechafin >= '" . $fechaactual ."' and d.periodoevaluacionid IN ($ids)" ]],
                            false,
                            true,
                            []
                        )[0];
                        $resp = $this->EliminarCriterioevalgrupos($criteriosgrupo, $dbm, $validar, true,$periodoactual);
                        if ($resp['calificaciones']) {
                            return new View(["calificaciones" => true], Response::HTTP_PARTIAL_CONTENT);
                        }

                        //Realizamos la copia
                        foreach ($criteriosevaluacion as $criterio) {
                            $criterioevaluaciongrupo = new CeCriterioevaluaciongrupo();
                            $criterioevaluaciongrupo->setAspecto($criterio->getAspecto());
                            $criterioevaluaciongrupo->setDescripcion($criterio->getDescripcion());
                            $criterioevaluaciongrupo->setPorcentajecalificacion($criterio->getPorcentajecalificacion());
                            $criterioevaluaciongrupo->setCapturas($criterio->getCapturas());
                            $criterioevaluaciongrupo->setPuntajemaximo($criterio->getPuntajemaximo());
                            $criterioevaluaciongrupo->setEliminaraspecto($criterio->getEliminaraspecto());
                            $criterioevaluaciongrupo->setEditarporcentajecalificacion($criterio->getEditarporcentajecalificacion());
                            $criterioevaluaciongrupo->setEditarcapturas($criterio->getEditarcapturas());
                            $criterioevaluaciongrupo->setEditarpuntajemaximo($criterio->getEditarpuntajemaximo());
                            $criterioevaluaciongrupo->setMinimo($criterio->getMinimo());
                            $criterioevaluaciongrupo->setMaximo($criterio->getMaximo());
                            $criterioevaluaciongrupo->setConfigurartarea($criterio->getConfigurartarea());
                            $criterioevaluaciongrupo->setProfesorpormateriaplanestudiosid($profesorpormateriaplanestudios);
                            $criterioevaluaciongrupo->setPeriodoevaluacionid($criterio->getPeriodoevaluacionid());
                            $criterioevaluaciongrupo->setCriterioevaluacionid($criterio);
                            $criterioevaluaciongrupo->setConfigurarexamen($criterio->getConfigurarexamen());
                            $dbm->saveRepositorio($criterioevaluaciongrupo);
                        }
                        //Se Actualiza el estatus de la plantilla del profesor
                        $profesorpormateriaplanestudios->setEstatuscriterioevaluacionid($conjuntocriterioevaluacion->getEstatuscriterioevaluacionid());
                        $dbm->saveRepositorio($profesorpormateriaplanestudios);
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se han asignado los registros a todos los grupos.", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    public static function EliminarCriterioevalgrupos($criteriosgrupo, $dbm, $validar, $validarperiodo = false, $periodoactual = null)
    {
        foreach ($criteriosgrupo as $cg) {
            if($validarperiodo) {
                $calificaciones = $dbm->getRepositoriosModelo(
                    "CeCapturacalificacionporalumno",
                    ["d.capturacalificacionporalumnoid, d.calificacion, a.alumnoid"],
                    [["criterioevaluaciongrupoid = " . $cg->getCriterioevaluaciongrupoid() . " AND LENGTH(TRIM(d.calificacion)) > 0" . 'and IDENTITY(a.alumnoestatusid) != 2 and cpa.periodoevaluacionid = ' . $periodoactual['periodoevaluacionid']]],
                    false,
                    true,
                    [
                        ["entidad" => "CeCalificacionperiodoporalumno", "alias" => "cpa", "on" => "cpa.calificacionperiodoporalumnoid = d.calificacionperiodoporalumnoid", "left" => false],
                        ["entidad" => "CeAlumno", "alias" => "a", "on" => "a.alumnoid = cpa.alumnoid", "left" => false],
    
                    ]
                );
            } else {
                $calificaciones = $dbm->getRepositoriosModelo(
                    "CeCapturacalificacionporalumno",
                    ["d.capturacalificacionporalumnoid, d.calificacion, a.alumnoid"],
                    [["criterioevaluaciongrupoid = " . $cg->getCriterioevaluaciongrupoid() . " AND LENGTH(TRIM(d.calificacion)) > 0" . 'and IDENTITY(a.alumnoestatusid) != 2']],
                    false,
                    true,
                    [
                        ["entidad" => "CeCalificacionperiodoporalumno", "alias" => "cpa", "on" => "cpa.calificacionperiodoporalumnoid = d.calificacionperiodoporalumnoid", "left" => false],
                        ["entidad" => "CeAlumno", "alias" => "a", "on" => "a.alumnoid = cpa.alumnoid", "left" => false],
    
                    ]
                );
            }

            if ($calificaciones && $validar) {
                return ["calificaciones" => true];
            }

            $examencalendario = $dbm->getRepositoriosById("BrExamenporcalendario", "criterioevaluaciongrupoid", $cg->getCriterioevaluaciongrupoid());
            foreach ($examencalendario as $ec) {
                $usuariosporexamen = $dbm->getRepositoriosById("BrUsuarioporexamen", "examenporcalendarioid", $ec->getExamenporcalendarioid());

                foreach ($usuariosporexamen as $ue) {
                    $dbm->removeManyRepositorio("BrRespuestaporusuario", "usuarioexamenid", $ue->getUsuarioporexamenid());
                    $dbm->removeRepositorio($ue);
                }

                $dbm->removeManyRepositorio("BrCalendarioexamen", "calendarioexamenid", $ec->getCalendarioexamenid()->getCalendarioexamenid());

                $dbm->removeRepositorio($ec);
            }
            $dbm->removeManyRepositorio("CeCapturacalificacionporalumno", "criterioevaluaciongrupoid", $cg->getCriterioevaluaciongrupoid());


            \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::re_calcularCalificacionesGrupo(
                $dbm,
                $cg->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                $cg->getPeriodoevaluacionid()->getPeriodoevaluacionid()
            );

            $tareas = $dbm->getRepositoriosById("CeTarea", "criterioevaluaciongrupoid", $cg->getCriterioevaluaciongrupoid());
            foreach ($tareas as $t) {
                $tareaalumno = $dbm->getRepositoriosById("CeTareaalumno", "tareaid", $t->getTareaid());
                foreach ($tareaalumno as $ta) {
                    $dbm->removeManyRepositorio("CeTareaalumnoarchivo", "tareaalumnoid", $ta->getTareaalumnoid());
                    $dbm->removeManyRepositorio("CeTareaalumnovinculo", "tareaalumnoid", $ta->getTareaalumnoid());
                    $dbm->removeRepositorio($ta);
                }
                $dbm->removeManyRepositorio("CeTareaarchivo", "tareaid", $t->getTareaid());
                $dbm->removeManyRepositorio("CeTareacomentario", "tareaid", $t->getTareaid());
                $dbm->removeRepositorio($t);
            };
            $dbm->removeManyRepositorio("CeCriterioevaluaciongrupo", 'criterioevaluaciongrupoid', $cg->getCriterioevaluaciongrupoid());
            $conjuntog = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $cg->getProfesorpormateriaplanestudiosid());
            $estatusg = $dbm->getRepositorioById("CeEstatuscriterioevaluacion", "estatuscriterioevaluacionid", self::checaPorcentajeGrupo($dbm, $conjuntog->getProfesorpormateriaplanestudiosid()));
            $conjuntog->setEstatuscriterioevaluacionid($estatusg);
            $dbm->saveRepositorio($conjuntog);
        }
        return ["exito" => true];
    }
}
