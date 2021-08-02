<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeCriterioevaluaciongrupo;
use AppBundle\Entity\CeTarea;
use AppBundle\Entity\CeTareaalumno;
use AppBundle\Entity\CeAvisosporcaratula;
use AppBundle\Entity\CeTareaarchivo;
use AppBundle\Entity\CeCaratula;
use AppBundle\Entity\CeAvisosporcaratulaarchivo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Gabriel
 */

class MisClasesController extends FOSRestController
{

    /**
     * Regresa los catalos de los filtros disponibles en la pantalla "Mis clases" 
     * Si se cuenta con el permiso especial podra ver todas las clases, de lo contrario, solo las que le corresponden"
     * @Rest\Get("/api/Controlescolar/Misclases", name="AMFiltrosMisclasesProfesor")
     */
    public function FiltrosMisclasesProfesor()
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $areasacademicas = $dbm->getByParametersRepositorios('CeAreaacademica', 
            array("activo" => 1, 
                "usuarioid" => $datos['usuarioid']
            ));
            if ($datos["permiso"] == 1) {
                $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
                $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
                $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
                $profesor = $dbm->BuscarProfesorPorUsuarioId(null);
                $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
                $planestudios = $dbm->getRepositorios('CePlanestudios');
                $profesorid = null;
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
                return new View([
                    'ciclo' => $ciclo,
                    'nivel' => $nivel,
                    'grupo' => $grupo,
                    'semestre' => $semestre,
                    'materia' => $materias,
                    'grado' => $grado,
                    'profesor' => $profesor,
                    'planestudios' => $planestudios,
                    'areasacademicas' => $areasacademicas
                ], Response::HTTP_OK);
            } else {
                $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $datos['usuarioid']);
                if ($usuario) {
                    $profe = $usuario->getProfesorid();
                    $profesorid = ($profe ? $profe->getProfesorid() : -1);
                }
                return new View([
                    'ciclo' => $ciclo,
                    'profesorid' =>  $profesorid,
                    'areasacademicas' => $areasacademicas
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna la lista de asistencia de un alumno
     * @Rest\Get("/api/Controlescolar/Misclases/Listadeasistencia/{profesorpormateriaplanestudioid}", name="BuscarAlumnoListadeasistencia")
     */
    public function getAlumnoListadeasistencia($profesorpormateriaplanestudioid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $path = str_replace('app', '', $this->get('kernel')->getRootDir());
            $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";

            switch (ENTORNO) {
                case 1:
                    $logo = $path . "Lux/logonombre.png";
                    $plantilla = "\"" . $path . "Lux/";
                    break;
                case 2:
                    $logo = $path . "Ciencias/logonombre.png";
                    $plantilla = "\"" . $path . "Ciencias/";
                    break;
            }

            $profesorpormateriaplanestudios = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $profesorpormateriaplanestudioid);

            if ($profesorpormateriaplanestudios->getTallerid()) {
                $plantilla = $plantilla . "Lista_Asistencia_" . (ENTORNO == 1 ? "Lux" : "Ciencias") . "_taller.jrxml\"";
            } else {
                $plantilla = $plantilla . "Lista_Asistencia_" . (ENTORNO == 1 ? "Lux" : "Ciencias") . ".jrxml\"";
            }


            $jasper = new JasperPHP($this->container);
            $respuesta = $jasper->process(
                $plantilla,
                "\"" . $path . "Lista_Asistencia\"",
                array('xlsx'),
                array("profesorpormateriaplanestudioid" => $profesorpormateriaplanestudioid, 'logo' => $logo),
                true
            )->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/Lista_Asistencia.xlsx";
            if ($respuesta) {
                return new View($respuesta, Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte),
                200,
                array(
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
                    'Content-Length' => filesize($reporte)
                )
            );
            unlink($reporte);
            return $response;
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Verifica los porcentaje d euna plantilla para cambiar el estatus a completo o incompleta
     */
    private function checaPorcentaje($profesorpormateriaplanestudiosid)
    {

        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
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
     * Retorna arreglo de Asignacion de materias en base a los parametros enviados
     * @Rest\Post("/api/Controlescolar/Misclases/", name="BuscarMisclases")
     */
    public function getCriterioEvaluacion()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            $filtros = array_filter($filtros);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $asignacionmaterias = $dbm->BuscarAsignacionmateria($filtros);
            if (!$asignacionmaterias) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($asignacionmaterias, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Citerios de evaluacion por grupo en base a los parametros enviados
     * @Rest\Get("/api/Controlescolar/Misclases/Criteriosclase/", name="BuscarCriterioEvaluacionClase")
     */
    public function getCriterioEvaluacionClase()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $tamanoMaximo = $dbm->getRepositorioById("Parametros", "nombre", 'Tamano archivo maximo');
            $profesorpormateriaplanestudios = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $datos["profesorpormateriaplanestudiosid"]);
            $materias = [];
            $nivel = [];
            $grupos = [];
            //$materiaporplanestudio = $dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $datos["materiaporplanestudioid"]);
            if ($profesorpormateriaplanestudios->getTallerid()) {
                $gradostaller = $dbm->getRepositorioById("CeGradoportallercurricular", "tallercurricularid", $profesorpormateriaplanestudios->getTallerid()->getTallercurricularid());
                $materiaporplanestudio = $gradostaller->getMateriaporplanestudioid();
                $conjuntoperiodo = $dbm->BuscarPeriodoEvaluacion(array("cicloid" => $gradostaller->getTallercurricularid()->getCicloid()->getCicloid(), "gradoid" => $materiaporplanestudio->getPlanestudioid()->getGradoid()->getGradoid()));
                if (!$conjuntoperiodo) {
                    return new View("No existen periodos definidos en el grado y ciclo.", Response::HTTP_PARTIAL_CONTENT);
                }
                $cp = $dbm->getOneByParametersRepositorio("CeConjuntocriteriosportaller", array('materiaporplanestudioid' => $materiaporplanestudio->getMateriaporplanestudioid()));
                if (!$cp) {
                    return new View("No existen criterios para este taller", Response::HTTP_PARTIAL_CONTENT);
                }
                $conjuntocriterios = $dbm->getByParametersRepositorios("CeConjuntocriterioevaluacion", array('conjuntocriterioevaluacionid' => $cp->getConjuntocriterioevaluacionid()));
                $conjuntocriterioevaluacion = $conjuntocriterios[0];
                $cps = $dbm->getByParametersRepositorios("CeConjuntocriteriosportaller", array('conjuntocriterioevaluacionid' => $cp->getConjuntocriterioevaluacionid()));
                foreach ($cps  as $cpp) {
                    $find  = false;
                    foreach ($materias as $mm) {
                        if ($mm == $cpp->getMateriaporplanestudioid()->getMateriaid()->getNombre()) {
                            $find = true;
                        }
                    }

                    if (!$find) {
                        $materias[] = $cpp->getMateriaporplanestudioid()->getMateriaid()->getNombre();
                    }

                    $gradostaller = $dbm->getRepositoriosById("CeGradoportallercurricular", "materiaporplanestudioid", $materiaporplanestudio->getMateriaporplanestudioid());
                    foreach ($gradostaller as $gr) {
                        $find = false;
                        foreach ($grupos as $g) {
                            if ($g == $gr->getTallercurricularid()->getNombre()) {
                                $find  = true;
                            }
                        }

                        if (!$find) {
                            $grupos[] = $gr->getTallercurricularid()->getNombre();
                        }
                        $find = false;
                        foreach ($nivel as $n) {
                            if ($n == $gr->getGradoid()->getNivelid()->getNombre()) {
                                $find = true;
                            }
                        }
                        if (!$find) {
                            $nivel[] = $gr->getGradoid()->getNivelid()->getNombre();
                        }
                    }
                }
                if (empty($conjuntocriterioevaluacion)) {
                    return new View("No se han creado los criterios a evaluar, para la materia seleccionada.", Response::HTTP_PARTIAL_CONTENT);
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
                    $periodoarray["criterioevaluacionoriginal"] = $dbm->getByParametersRepositorios("CeCriterioevaluacion", array("periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "conjuntocriterioevaluacionid" => $conjuntocriterioevaluacion->getConjuntocriterioevaluacionid()));
                    $periodoarray["criterioevaluacion"] = $dbm->getByParametersRepositorios("CeCriterioevaluaciongrupo", array("periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "profesorpormateriaplanestudiosid" => $datos["profesorpormateriaplanestudiosid"]));
                    $periodosarray[] = $periodoarray;
                }
            } else {
                $materiaporplanestudio = $profesorpormateriaplanestudios->getMateriaporplanestudioid();
                $conjuntoperiodo = $dbm->BuscarPeriodoEvaluacion(array("cicloid" => $profesorpormateriaplanestudios->getPlantillaprofesorid()->getCicloid()->getCicloid(), "gradoid" => $materiaporplanestudio->getPlanestudioid()->getGradoid()->getGradoid()));
                if (!$conjuntoperiodo) {
                    return new View("No existen periodos definidos en el grado y ciclo.", Response::HTTP_PARTIAL_CONTENT);
                }
                $materias[] = $materiaporplanestudio->getMateriaid()->getNombre();
                $grupos[] = $profesorpormateriaplanestudios->getGrupoid()->getNombre();
                $nivel[] = $profesorpormateriaplanestudios->getGrupoid()->getGradoid()->getNivelid()->getNombre();
                $conjuntocriterios = $dbm->getByParametersRepositorios("CeConjuntocriterioevaluacion", array("cicloid" => $profesorpormateriaplanestudios->getPlantillaprofesorid()->getCicloid()->getCicloid(), "materiaporplanestudioid" => $materiaporplanestudio->getMateriaporplanestudioid()));
                $conjuntocriterioevaluacion = $conjuntocriterios[0];
                if (empty($conjuntocriterioevaluacion)) {
                    return new View("No se han creado los criterios a evaluar, para la materia seleccionada.", Response::HTTP_PARTIAL_CONTENT);
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
                    $periodoarray["criterioevaluacionoriginal"] = $dbm->getByParametersRepositorios("CeCriterioevaluacion", array("periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "conjuntocriterioevaluacionid" => $conjuntocriterioevaluacion->getConjuntocriterioevaluacionid()));
                    $periodoarray["criterioevaluacion"] = $dbm->getByParametersRepositorios("CeCriterioevaluaciongrupo", array("periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "profesorpormateriaplanestudiosid" => $datos["profesorpormateriaplanestudiosid"]));
                    $periodosarray[] = $periodoarray;
                }
            }

            return new View(array("profesorpormateriaplanestudio" => $profesorpormateriaplanestudios, "periodoevaluacion" => $periodosarray, "tamanoMaximo" => $tamanoMaximo, 'materiaporplanestudio' => $materiaporplanestudio, 'materias' => $materias, 'nivel' => $nivel, 'grupos' => $grupos), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda los criterios de una clase
     * @Rest\Post("/api/Controlescolar/Misclases/Criteriosclase" , name="GuardarMisclases")
     */
    public function saveMisclases()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $criterio = $dbm->getRepositorioById("CeCriterioevaluacion", "criterioevaluacionid", $data["criterioevaluacionid"]);
            $pe = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $criterio->getPeriodoevaluacionid()->getPeriodoevaluacionid());
            $hoy = new \DateTime();
            if ($pe->getFechalimedicionprofesor()->format('Y-m-d') < $hoy->format('Y-m-d')) {
                return new View("La fecha límite de edición para profesores ha expirado.", Response::HTTP_PARTIAL_CONTENT);
            }
             $Criterio = new CeCriterioevaluaciongrupo();
            $Criterio->setAspecto($criterio->getAspecto());
            $Criterio->setDescripcion($criterio->getDescripcion());
            $Criterio->setPorcentajecalificacion($criterio->getPorcentajecalificacion());
            $Criterio->setCapturas($criterio->getCapturas());
            $Criterio->setPuntajemaximo($criterio->getPuntajemaximo());
            $Criterio->setEliminaraspecto($criterio->getEliminaraspecto());
            $Criterio->setEditarporcentajecalificacion($criterio->getEditarporcentajecalificacion());
            $Criterio->setEditarcapturas($criterio->getEditarcapturas());
            $Criterio->setEditarpuntajemaximo($criterio->getEditarpuntajemaximo());
            $Criterio->setMinimo($criterio->getMinimo());
            $Criterio->setMaximo($criterio->getMaximo());
            $Criterio->setConfigurarexamen($criterio->getConfigurarexamen());
            $Criterio->setConfigurartarea($criterio->getConfigurartarea());
            $Criterio->setPeriodoevaluacionid($criterio->getPeriodoevaluacionid());
            $Criterio->setProfesorpormateriaplanestudiosid($dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $data["profesorpormateriaplanestudiosid"]));
            $Criterio->setCriterioevaluacionid($criterio);
            $dbm->saveRepositorio($Criterio);
            $conjunto = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $data["profesorpormateriaplanestudiosid"]);
            $estatus = $dbm->getRepositorioById("CeEstatuscriterioevaluacion", "estatuscriterioevaluacionid", self::checaPorcentaje($data["profesorpormateriaplanestudiosid"]));
            $conjunto->setEstatuscriterioevaluacionid($estatus);
            $dbm->saveRepositorio($conjunto);

            \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::re_calcularCalificacionesGrupo(
                $dbm,
                $Criterio->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(), 
                $Criterio->getPeriodoevaluacionid()->getPeriodoevaluacionid()
            );

            $dbm->getConnection()->commit();
            return new View(array("mensaje" => "Se ha guardado el registro", "criterioevaluaciongrupo" => $Criterio, "estatuscriterioevaluacion" => $estatus), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza los criterios de una clase
     * @Rest\Put("/api/Controlescolar/Misclases/Criteriosclase/{id}" , name="ActualizarMisclases")
     */
    public function updateMisclases($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $data['validar'];
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $ceg = $dbm->getRepositorioById("CeCriterioevaluaciongrupo","criterioevaluaciongrupoid", $id);
            if((intval($data['capturas']) < $ceg->getCapturas()) && $validar ) {
                for ($i=$data['capturas']+1; $i <= $ceg->getCapturas() ; $i++) { 
                    $valor = $dbm->getRepositoriosModelo("CeCapturacalificacionporalumno", ["d"], 
                    [["calificacion is not null and d.numerocaptura =" . $i . " and d.criterioevaluaciongrupoid =" . $ceg->getCriterioevaluaciongrupoid()]], false, true, [
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

            for ($i=$data['capturas']+1; $i <= $ceg->getCapturas() ; $i++) { 
                $registros = $dbm->getRepositoriosModelo("CeCapturacalificacionporalumno", ["d"], 
                [["numerocaptura =" . $i . " and d.criterioevaluaciongrupoid =" . $ceg->getCriterioevaluaciongrupoid()]], false, true, [
                ]);
                $dbm->removeBulkRepositorio($registros);
            }

            $criterioevaluacion = $hydrator->hydrate($dbm->getRepositorioById('CeCriterioevaluaciongrupo', 'criterioevaluaciongrupoid', $id), $data);
            $pe = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $criterioevaluacion->getPeriodoevaluacionid()->getPeriodoevaluacionid());
            $hoy = new \DateTime();
            if ($pe->getFechalimedicionprofesor()->format('Y-m-d') < $hoy->format('Y-m-d')) {
                return new View("La fecha límite de edición para profesores ha expirado.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->saveRepositorio($criterioevaluacion);
            $conjunto = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $criterioevaluacion->getProfesorpormateriaplanestudiosid());
            $estatus = $dbm->getRepositorioById("CeEstatuscriterioevaluacion", "estatuscriterioevaluacionid", self::checaPorcentaje($criterioevaluacion->getProfesorpormateriaplanestudiosid()));
            $conjunto->setEstatuscriterioevaluacionid($estatus);
            $dbm->saveRepositorio($conjunto);

            \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::re_calcularCalificacionesGrupo(
                $dbm,
                $criterioevaluacion->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(), 
                $criterioevaluacion->getPeriodoevaluacionid()->getPeriodoevaluacionid()
                );

            $dbm->getConnection()->commit();
            return new View(array("mensaje" => "Se ha actualizado el registro", "criterioevaluaciongrupo" => $criterioevaluacion, "estatuscriterioevaluacion" => $estatus), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina criterios de una clase
     * @Rest\Delete("/api/Controlescolar/Misclases/Criteriosclase/{id}", name="EliminarMisclases")
     */
    public function deleteMisclases($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $criterioevaluacion = $dbm->getRepositorioById('CeCriterioevaluaciongrupo', 'criterioevaluaciongrupoid', $id);
            $pe = $criterioevaluacion->getPeriodoevaluacionid();
            $hoy = new \DateTime();
            $validar = strtolower($datos['validar']) == 'true' ? true : false;
            if ($pe->getFechalimedicionprofesor()->format('Y-m-d') < $hoy->format('Y-m-d')) {
                return new View("La fecha límite de edición para profesores ha expirado.", Response::HTTP_PARTIAL_CONTENT);
            }

            //$tarea = $dbm->getRepositorioById("CeTarea", "criterioevaluaciongrupoid", $id);
            //if ($tarea) {
            //    return new View("Existen tareas asociadas al criterio." . $tarea->getNombre() . ".", Response::HTTP_OK);
            //}

            $calificaciones = $dbm->getRepositoriosModelo("CeCapturacalificacionporalumno",["d.capturacalificacionporalumnoid, d.calificacion, a.alumnoid"],
            [["criterioevaluaciongrupoid = ". $id ." AND LENGTH(TRIM(d.calificacion)) > 0" . 'and IDENTITY(a.alumnoestatusid) != 2']],false,true,
            [
                ["entidad" => "CeCalificacionperiodoporalumno", "alias" => "cpa", "on" => "cpa.calificacionperiodoporalumnoid = d.calificacionperiodoporalumnoid", "left" => false],
                ["entidad" => "CeAlumno", "alias" => "a", "on" => "a.alumnoid = cpa.alumnoid", "left" => false],

            ]
            );

            if($calificaciones && $validar){
                return new View(["calificaciones" => true], Response::HTTP_PARTIAL_CONTENT);
            }

            $examencalendario = $dbm->getRepositoriosById("BrExamenporcalendario", "criterioevaluaciongrupoid", $id);
            foreach($examencalendario as $ec) {
                $usuariosporexamen = $dbm->getRepositoriosById("BrUsuarioporexamen", "examenporcalendarioid", $ec->getExamenporcalendarioid());

                foreach($usuariosporexamen as $ue) {
                    $dbm->removeManyRepositorio("BrRespuestaporusuario", "usuarioexamenid", $ue->getUsuarioporexamenid());
                    $dbm->removeRepositorio($ue);
                }

                $dbm->removeManyRepositorio("BrCalendarioexamen", "calendarioexamenid", $ec->getCalendarioexamenid()->getCalendarioexamenid());

                $dbm->removeRepositorio($ec);

            }

            $ppme = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", 
                $criterioevaluacion->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid());
            
            $pe =  $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", 
            $criterioevaluacion->getPeriodoevaluacionid()->getPeriodoevaluacionid());   
            
            $profesorid = $ppme->getProfesorpormateriaplanestudiosid();
            $criterioid = $pe->getPeriodoevaluacionid();
            $dbm->removeManyRepositorio("CeCapturacalificacionporalumno", "criterioevaluaciongrupoid", $id);


            $tareas = $dbm->getRepositoriosById("CeTarea", "criterioevaluaciongrupoid", $criterioevaluacion->getCriterioevaluaciongrupoid());
            foreach($tareas as $t) { 
                $tareaalumno = $dbm->getRepositoriosById("CeTareaalumno", "tareaid", $t->getTareaid());
                foreach($tareaalumno as $ta) {
                    $dbm->removeManyRepositorio("CeTareaalumnoarchivo", "tareaalumnoid", $ta->getTareaalumnoid());
                    $dbm->removeManyRepositorio("CeTareaalumnovinculo", "tareaalumnoid", $ta->getTareaalumnoid());
                    $dbm->removeRepositorio($ta);

                }
                $dbm->removeManyRepositorio("CeTareaarchivo", "tareaid", $t->getTareaid());
                $dbm->removeManyRepositorio("CeTareacomentario", "tareaid", $t->getTareaid());
                $dbm->removeRepositorio($t);
            };

            $dbm->removeRepositorio($criterioevaluacion);
            $conjunto = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $criterioevaluacion->getProfesorpormateriaplanestudiosid());
            $estatus = $dbm->getRepositorioById("CeEstatuscriterioevaluacion", "estatuscriterioevaluacionid", self::checaPorcentaje($conjunto->getProfesorpormateriaplanestudiosid()));
            $conjunto->setEstatuscriterioevaluacionid($estatus);
            $dbm->saveRepositorio($conjunto);

            \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::re_calcularCalificacionesGrupo(
                $dbm,
                $profesorid, 
                $criterioid
            );

            $dbm->getConnection()->commit();
            return new View(array("mensaje" => "Se ha eliminado el registro", "materiaporplanestudios" => $conjunto, "estatuscriterioevaluacion" => $estatus), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de grupos asignados a materias del profesor para copiar los criterios
     * @Rest\Get("/api/Controlescolar/Misclases/Grupo", name="BuscarGruposProfesor")
     */
    public function getGruposProfesor()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $profesorpormateriaplanestudios = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $datos["profesorpormateriaplanestudiosid"]);
            if ($profesorpormateriaplanestudios->getGrupoid()) {
                $grupos = $dbm->BuscarAsignacionmateria(array(
                    "cicloid" => $profesorpormateriaplanestudios->getGrupoid()->getCicloid()->getCicloid(),
                    "gradoid" =>  $profesorpormateriaplanestudios->getGrupoid()->getGradoid()->getGradoid(),
                    "profesorid" => $profesorpormateriaplanestudios->getProfesorid()->getProfesorid(),
                    "materiaid" => $profesorpormateriaplanestudios->getMateriaporplanestudioid()->getMateriaid()->getMateriaid(),
                ));
                foreach ($grupos as $key => $grupo) {
                    if ($grupo["grupoid"] == $profesorpormateriaplanestudios->getGrupoid()->getGrupoid()) {
                        unset($grupos[$key]);
                    }
                }
            } else {
                $grupos = [];
                $gruposs = [];
                $grados = $dbm->getRepositoriosById("CeGradoportallercurricular", "tallercurricularid", $profesorpormateriaplanestudios->getTallerid()->getTallercurricularid());

                foreach ($grados as $g) {
                    $gruposs[] = $dbm->BuscarAsignacionmateria(array(
                        "cicloid" => $profesorpormateriaplanestudios->getTallerid()->getCicloid()->getCicloid(),
                        "gradoid" =>  $g->getGradoid()->getGradoid(),
                        "profesorid" => $profesorpormateriaplanestudios->getProfesorid()->getProfesorid()
                    ));
                }
                foreach ($gruposs as $key => $grupo) {
                    foreach ($grupo as $g) {
                        if ($grupo["grupoid"] == $profesorpormateriaplanestudios->getTallerid()->getTallercurricularid()) {
                            unset($grupos[$key]);
                        }
                        $grupos[] = $g;
                    }
                }
            }

            foreach ($grupos as $grupo) {
                $gruposresponse[] = $grupo;
            }
            if (!$gruposresponse) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($gruposresponse, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de grupos asignados a materias del profesor para copiar las taeras
     * @Rest\Get("/api/Controlescolar/Misclases/GrupoTareaCopiar", name="GrupoTareaCopiar")
     */
    public function GrupoTareaCopiar()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $profesorpormateriaplanestudios = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $datos["profesorpormateriaplanestudiosid"]);
            if ($profesorpormateriaplanestudios->getGrupoid()) {
                $grupos = $dbm->BuscarAsignacionmateria(array(
                    "cicloid" => $profesorpormateriaplanestudios->getGrupoid()->getCicloid()->getCicloid(),
                    "gradoid" =>  $profesorpormateriaplanestudios->getGrupoid()->getGradoid()->getGradoid(),
                    "profesorid" => $profesorpormateriaplanestudios->getProfesorid()->getProfesorid(),
                    "materiaid" => $profesorpormateriaplanestudios->getMateriaporplanestudioid()->getMateriaid()->getMateriaid(),
                ));
                foreach ($grupos as $key => $grupo) {
                    if ($grupo["grupoid"] == $profesorpormateriaplanestudios->getGrupoid()->getGrupoid()) {
                        unset($grupos[$key]);
                    }
                }
            } else {
                $grupos = [];
                $gruposs = [];
                $grados = $dbm->getRepositoriosById("CeGradoportallercurricular", "tallercurricularid", $profesorpormateriaplanestudios->getTallerid()->getTallercurricularid());

                foreach ($grados as $g) {
                    $gruposs[] = $dbm->BuscarAsignacionmateria(array(
                        "cicloid" => $profesorpormateriaplanestudios->getTallerid()->getCicloid()->getCicloid(),
                        "gradoid" =>  $g->getGradoid()->getGradoid(),
                        "profesorid" => $profesorpormateriaplanestudios->getProfesorid()->getProfesorid()
                    ));
                }
                foreach ($gruposs as $key => $grupo) {
                    foreach ($grupo as $g) {
                        if ($grupo["grupoid"] == $profesorpormateriaplanestudios->getTallerid()->getTallercurricularid()) {
                            unset($grupos[$key]);
                        }
                        $grupos[] = $g;
                    }
                }
            }

            foreach ($grupos as $grupo) {
                foreach ($grupo['periodosevaluacion'] as &$periodo) {
                    $criterios = $dbm->getByParametersRepositorios('CeCriterioevaluaciongrupo', [
                        'profesorpormateriaplanestudiosid' => $grupo['profesorpormateriaplanestudiosid'],
                        'periodoevaluacionid' => $periodo['periodoevaluacionid'],
                        'configurartarea' => 1
                    ]);
                    $periodo['criterios'] = $criterios;
                    $periodo['capturasdisponibles'] = [];

                    foreach ($criterios as $criterio) {
                        $free = [];
                        for ($i = 1; $i < $criterio->getCapturas() + 1; $i++) {
                            $tarf = $dbm->getOneByParametersRepositorio('CeTarea', [
                                'criterioevaluaciongrupoid' => $criterio->getCriterioevaluaciongrupoid(),
                                'captura' => $i
                            ]);
                            if (!$tarf) {
                                $free[] = $i;
                            }
                        }
                        $periodo['capturasdisponibles'][] = [
                            'criterioevaluaciongrupoid' => $criterio->getCriterioevaluaciongrupoid(),
                            'capturas' => $free
                        ];
                    }
                }
                $gruposresponse[] = $grupo;
            }
            if (!$gruposresponse) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View(['grupos' => $gruposresponse], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Copia los criterios de un agrupo a otros grupos del mismo profesor
     * @Rest\Post("/api/Controlescolar/Misclases/Grupo" , name="ClonarMisclases")
     */
    public function cloneMisclases()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $criteriosevaluacion = $dbm->getRepositoriosById("CeCriterioevaluaciongrupo", "profesorpormateriaplanestudiosid", $data["profesorpormateriaplanestudiosid"]);
            foreach ($data["copiaprofesorpormateriaplanestudiosid"] as $profesorpormateriaplanestudiosid) {
                $cr = $dbm->getRepositoriosById("CeCriterioevaluaciongrupo", "profesorpormateriaplanestudiosid", $profesorpormateriaplanestudiosid);

                foreach ($cr as $c) {
                    $tareas = $dbm->getRepositoriosById("CeTarea", "criterioevaluaciongrupoid", $c->getCriterioevaluaciongrupoid());
                    foreach ($tareas as $tarea) {
                        $dbm->removeRepositorio($tarea);
                    }
                    $dbm->removeRepositorio($c);
                }
                foreach ($criteriosevaluacion as $criterio) {
                    $Criterio = new CeCriterioevaluaciongrupo();
                    $Criterio = clone $criterio;
                    $pmpeoriginal = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $data["profesorpormateriaplanestudiosid"]);
                    $pmpcopia = $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $profesorpormateriaplanestudiosid);
                    $pmpcopia->setEstatuscriterioevaluacionid($pmpeoriginal->getEstatuscriterioevaluacionid());
                    $dbm->saveRepositorio($pmpcopia);
                    $Criterio->setProfesorpormateriaplanestudiosid($dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $profesorpormateriaplanestudiosid));
                    $dbm->saveRepositorio($Criterio);
                    $dbm->removeManyRepositorio("CeTarea", "criterioevaluaciongrupoid", $Criterio->getCriterioevaluaciongrupoid());
                    $tareas = $dbm->getRepositoriosById("CeTarea", "criterioevaluaciongrupoid", $criterio->getCriterioevaluaciongrupoid());
                    foreach ($tareas as $tarea) {
                        $Tarea = clone $tarea;
                        $Tarea->setCriterioevaluaciongrupoid($Criterio);
                        $dbm->saveRepositorio($Tarea);
                        $dbm->removeManyRepositorio("CeTareaarchivo", "tareaid", $Tarea->getTareaid());
                        $archivos = $dbm->getRepositoriosById("CeTareaarchivo", "tareaid", $tarea->getTareaid());
                        foreach ($archivos as $archivo) {
                            $Archivo = clone $archivo;
                            $Archivo->setTareaid($Tarea);
                            $dbm->saveRepositorio($Archivo);
                        }
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View(array("Se han guardado los registros"), Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == '23000') {
                return new View(array("El grupo seleccionado ya tiene tareas o calificaciones asignadas a alumnos"), Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Copia las tareas de un agrupo a otros grupos del mismo profesor
     * @Rest\Post("/api/Controlescolar/Misclases/CopiarTarea" , name="CopiarTarea")
     */
    public function CopiarTarea()
    {
        try {
            $content = file_get_contents("php://input");
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $tarea = $dbm->getRepositorioById('CeTarea', 'tareaid', $data['tareaid']);
            $archivos = $dbm->getByParametersRepositorios("CeTareaarchivo", ['tareaid' => $data['tareaid']]);
            foreach ($data['criterios'] as $criterio) {
                if ($criterio['selected']) {
                    $crit = $dbm->getRepositorioById('CeCriterioevaluaciongrupo', 'criterioevaluaciongrupoid', $criterio['criterioevaluaciongrupoid']);
                    $tareas = $dbm->getRepositoriosById('CeTarea', 'criterioevaluaciongrupoid', $criterio['criterioevaluaciongrupoid']);

                    if ($crit->getProfesorpormateriaplanestudiosid()->getTallerid()) {
                        $gradoportaller = $dbm->getRepositoriosById("CeGradoportallercurricular", "tallercurricularid", $crit->getProfesorpormateriaplanestudiosid()->getTallerid()->getTallercurricularid());
                        foreach ($gradoportaller as $gra) {
                            $conjunto = $dbm->getRepositorioById("CeConjuntocriteriosportaller", "materiaporplanestudioid", $gra->getMateriaporplanestudioid()->getMateriaporplanestudioid());
                            $conjuntos = $dbm->getRepositoriosById("CeConjuntocriteriosportaller", "conjuntocriterioevaluacionid", $conjunto->getConjuntocriterioevaluacionid()->getConjuntocriterioevaluacionid());
                            foreach ($conjuntos as $c) {
                                $free = [];
                                for ($i = 1; $i < $crit->getCapturas(); $i++) {
                                    $tarf = $dbm->getOneByParametersRepositorio('CeTarea', [
                                        'criterioevaluaciongrupoid' => $criterio['criterioevaluaciongrupoid'],
                                        'captura' => $i
                                    ]);
                                    if (!$tarf) {
                                        $free[] = $i;
                                    }
                                }
                                foreach ($tareas as $tar) {
                                    if ($tar->getCaptura() == $criterio['captura']) {
                                        if (count($free) == 0) {
                                            $tar->setCaptura($crit->getCapturas() + 1);
                                        } else {
                                            $tar->setCaptura($free[0]);
                                        }
                                        $dbm->saveRepositorio($tar);
                                    }
                                }



                                $tars = new CeTarea();
                                $tars->setNombre($tarea->getNombre());
                                $tars->setDescripcion($tarea->getDescripcion());
                                $tars->setCaptura($criterio['captura']);
                                $tars->setTipoentregaid($tarea->getTipoentregaid());
                                $tars->setFechainicio($tarea->getFechainicio());
                                $tars->setFechafin($tarea->getFechafin());
                                $tars->setHoralimite($tarea->getHoralimite());
                                $tars->setCriterioevaluaciongrupoid($crit);
                                $tars->setEntregaextemporanea($tarea->getEntregaextemporanea());
                                $tars->setMateriaid($c->getMateriaporplanestudioid()->getMateriaid());
                                $dbm->saveRepositorio($tars);



                                if (count($free) == 0) {
                                    $crit->setCapturas($crit->getCapturas() + 1);
                                    $dbm->saveRepositorio($crit);
                                }
                            }
                        }
                    } else {
                        $free = [];
                        for ($i = 1; $i < $crit->getCapturas(); $i++) {
                            $tarf = $dbm->getOneByParametersRepositorio('CeTarea', [
                                'criterioevaluaciongrupoid' => $criterio['criterioevaluaciongrupoid'],
                                'captura' => $i
                            ]);
                            if (!$tarf) {
                                $free[] = $i;
                            }
                        }
                        foreach ($tareas as $tar) {
                            if ($tar->getCaptura() == $criterio['captura']) {
                                if (count($free) == 0) {
                                    $tar->setCaptura($crit->getCapturas() + 1);
                                } else {
                                    $tar->setCaptura($free[0]);
                                }
                                $dbm->saveRepositorio($tar);
                            }
                        }

                        $tars = new CeTarea();
                        $tars->setNombre($tarea->getNombre());
                        $tars->setDescripcion($tarea->getDescripcion());
                        $tars->setCaptura($criterio['captura']);
                        $tars->setTipoentregaid($tarea->getTipoentregaid());
                        $tars->setFechainicio($tarea->getFechainicio());
                        $tars->setFechafin($tarea->getFechafin());
                        $tars->setHoralimite($tarea->getHoralimite());
                        $tars->setCriterioevaluaciongrupoid($crit);
                        $tars->setEntregaextemporanea($tarea->getEntregaextemporanea());
                        if ($crit->getProfesorpormateriaplanestudiosid()->getMateriaid()) {
                            $tars->setMateriaid($crit->getProfesorpormateriaplanestudiosid()->getMateriaid());
                        } else {
                            $tars->setMateriaid($crit->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getMateriaid());
                        }
                        $dbm->saveRepositorio($tars);
                    }

                    if ($crit->getProfesorpormateriaplanestudiosid()->getTallerid()) {
                        $grupoid = $crit->getProfesorpormateriaplanestudiosid()->getTallerid()->getTallercurricularid();
                        $taller =  $dbm->getRepositorioById("CeTallercurricular", "tallercurricularid", $grupoid);
                        $alumnos = $dbm->AlumnoCicloGrupo($taller->getCicloid()->getCicloid(), $grupoid, null, true);
                    } else {
                        $grupoid = $crit->getProfesorpormateriaplanestudiosid()->getGrupoid()->getGrupoid();
                        $grupo =  $dbm->getRepositorioById("CeGrupo", "grupoid", $grupoid);
                        $alumnos = $dbm->AlumnoCicloGrupo($grupo->getCicloid()->getCicloid(), $grupoid, null, false);
                    }

                    foreach ($archivos as $a) {
                        $tareaarchivo = clone $a;
                        rewind($a->getContenido());
                        $tareaarchivo->setContenido(stream_get_contents($a->getContenido()));
                        $tareaarchivo->setTareaid($tars);
                        $dbm->saveRepositorio($tareaarchivo);
                    }


                    if ($alumnos) {
                        foreach ($alumnos as $key => $alumno) {
                            $tareaalumno = $dbm->getByParametersRepositorios("CeTareaalumno", array("tareaid" => $tars->getTareaid(), "alumnoid" => $alumno["IDAlumno"]));
                            if (!$tareaalumno) {
                                $tareaalumno = new CeTareaalumno();
                                $tareaalumno->setTareaid($dbm->getRepositorioById("CeTarea", "tareaid", $tars->getTareaid()));
                                $tareaalumno->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $alumno["alumnoid"]));
                                $dbm->saveRepositorio($tareaalumno);
                                $tipoactividadid = 13;
                            } else {
                                $tareaalumno = $tareaalumno[0];
                                $tipoactividadid = 12;
                            }

                            $entityd = $tareaalumno;
                            $usuariodestino = $dbm->getRepositorioById("Usuario", "alumnoid", $entityd->getAlumnoid()->getAlumnoid());

                            if ($tareaarchivo) {
                                $entidad = $tareaarchivo;
                                $proftmp = $entidad->getTareaid()->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getProfesorid();
                                $params = [
                                    "Materia" => $entidad->getTareaid()->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()
                                        ->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                                    "Profesor" => $proftmp->getApellidopaterno() . ' ' . $proftmp->getApellidomaterno() . ' ' .
                                        $proftmp->getNombre(),
                                    "TareaNombre" => $entidad->getTareaid()->getNombre(),
                                    "TareaNumero" => $entidad->getTareaid()->getCaptura()
                                ];
                            }
                            if ($usuariodestino) {
                                $actividad = [
                                    "tipoactividadid" => $tipoactividadid,
                                    "usuariodestinoid" => $usuariodestino->getUsuarioid()
                                ];
                                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad, $entityd, $dbm, $this->get('mailer'), $params);
                            }
                        }
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View(array("Se han guardado los registros"), Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == '23000') {
                return new View(array("El grupo seleccionado ya tiene tareas asignadas a alumnos"), Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de tareas asignados a materias del profesor
     * @Rest\Get("/api/Controlescolar/Misclases/Criteriosclase/Tarea", name="IndexTarea")
     */
    public function getTarea()
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $tipoentrega = $dbm->getRepositoriosById("CeTipoentrega", "activo", 1);
            $tarea = $dbm->getRepositoriosById("CeTarea", "criterioevaluaciongrupoid", $datos["criterioevaluaciongrupoid"]);

            $tareas = array();
            $editable = false;
            foreach ($tarea as $t) {
                $tareasalumno = $dbm->getRepositorioById("CeTareaalumno", "tareaid", $t->getTareaid());
                $fecha = $t->getFechainicio();
                $time1 = strtotime($fecha->format('d-m-Y'));
                $date_now = strtotime(date('d-m-Y'));
                if ($date_now >= $time1) {
                    $editable = false;
                } else {
                    $editable = true;
                }
                $archivos = array();
                $archivos = $dbm->getRepositoriosById("CeTareaarchivo", "tareaid", $t->getTareaid());
                foreach ($archivos as $a) {
                    $a->setContenido(stream_get_contents($a->getContenido()));
                    $a->setTareaid(null);
                }
                array_push($tareas, array("tarea" => $t, "archivos" => $archivos, "editable" => $editable));
            }
            return new View(array("tipoentrega" => $tipoentrega, "tareas" => $tareas), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una tarea
     * @Rest\Post("/api/Controlescolar/Misclases/Criteriosclase/Tarea", name="GuardarTarea")
     */
    public function saveTarea()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $criterio = $dbm->getRepositorioById("CeCriterioevaluaciongrupo", "criterioevaluaciongrupoid", $data["criterioevaluaciongrupoid"]);
            $tareasCount = $dbm->getRepositoriosById("CeTarea", "criterioevaluaciongrupoid", $data["criterioevaluaciongrupoid"]);
    
            if (count($data['tareas']) > $criterio->getCapturas()) {
                $criterio->setCapturas(count($data['tareas']));
                $dbm->saveRepositorio($criterio);
                \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::re_calcularCalificacionesGrupo(
                    $dbm,
                    $criterio->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(), 
                    $criterio->getPeriodoevaluacionid()->getPeriodoevaluacionid() 
                );
            } else {
                $dbm->saveRepositorio($criterio);
            }

            foreach ($data["tareaseliminada"] as $t) {
                $tarea = $dbm->getRepositorioById("CeTarea", "tareaid", $t);
                $dbm->removeRepositorio($tarea);
            }
            if ($criterio->getProfesorpormateriaplanestudiosid()->getTallerid()) {
                $gradoportaller = $dbm->getRepositoriosById("CeGradoportallercurricular", "tallercurricularid", $criterio->getProfesorpormateriaplanestudiosid()->getTallerid()->getTallercurricularid());
                foreach ($gradoportaller as $gra) {
                    $conjunto = $dbm->getRepositorioById("CeConjuntocriteriosportaller", "materiaporplanestudioid", $gra->getMateriaporplanestudioid()->getMateriaporplanestudioid());
                    $conjuntos = $dbm->getRepositoriosById("CeConjuntocriteriosportaller", "conjuntocriterioevaluacionid", $conjunto->getConjuntocriterioevaluacionid()->getConjuntocriterioevaluacionid());
                    foreach ($conjuntos as $c) {
                        foreach ($data["tareas"] as $t) {
                            /*if ($t["editado"] && $dbm->getRepositorioById("CeTareaalumno", "tareaid", $t["tareaid"])){
                                return new View("Existen tareas de alumno asociados a la tarea ".$t["nombre"].".", Response::HTTP_OK);
                            }*/
                            $tarea = $hydrator->hydrate($t["tareaid"] ? $dbm->getRepositorioById("CeTarea", "tareaid", $t["tareaid"]) : new CeTarea(), $t);
                            $crit = $dbm->getRepositorioById("CeCriterioevaluaciongrupo", "criterioevaluaciongrupoid", $data["criterioevaluaciongrupoid"]);
                            $tarea->setCriterioevaluaciongrupoid($crit);

                            $fechainicio = new \DateTime($t["periodoentrega"]["beginDate"]["year"] . "-" . $t["periodoentrega"]["beginDate"]["month"] . "-" . $t["periodoentrega"]["beginDate"]["day"]);
                            $fechafin = new \DateTime($t["periodoentrega"]["endDate"]["year"] . "-" . $t["periodoentrega"]["endDate"]["month"] . "-" . $t["periodoentrega"]["endDate"]["day"]);
                            $tarea->setFechainicio($fechainicio);
                            $tarea->setFechafin($fechafin);
                            $tarea->setHoralimite(new \DateTime($t["horalimite"]));
                            $tarea->setEntregaextemporanea($t["entregaextemporanea"]);

                            $tarea->setMateriaid($c->getMateriaporplanestudioid()->getMateriaid());
                            $dbm->saveRepositorio($tarea);
                            // if ($t["tareaid"]){
                            //     $entidad=$tarea;
                            //     $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                            //     if ($usuariodestino){
                            //         $actividad=[
                            //             "tipoactividadid"=>12,
                            //             "usuariodestinoid"=>$usuariodestino
                            //         ];
                            //         \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
                            //     }
                            // }else{
                            //     $entidad=$tarea;
                            //     if($entidad){
                            //         $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                            //         if ($usuariodestino){
                            //             $actividad=[
                            //                 "tipoactividadid"=>13,
                            //                 "usuariodestinoid"=>$usuariodestino
                            //             ];
                            //             \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
                            //         }
                            //     }
                            // }
                            $tareaarray[] = $tarea;

                            $grupoid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getTallerid()->getTallercurricularid();

                            $taller =  $dbm->getRepositorioById("CeTallercurricular", "tallercurricularid", $grupoid);
                            $alumnos = $dbm->AlumnoCicloGrupo($taller->getCicloid()->getCicloid(), $grupoid, null, true);
                            if ($alumnos) {
                                foreach ($alumnos as $key => $alumno) {
                                    $tareaalumno = $dbm->getByParametersRepositorios("CeTareaalumno", array("tareaid" => $tarea->getTareaid(), "alumnoid" => $alumno["alumnoid"]));
                                    if (!$tareaalumno) {
                                        $tareaalumno = new CeTareaalumno();
                                        $tareaalumno->setTareaid($dbm->getRepositorioById("CeTarea", "tareaid", $tarea->getTareaid()));
                                        $tareaalumno->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $alumno["alumnoid"]));
                                        $dbm->saveRepositorio($tareaalumno);
                                    } else {
                                        $tareaalumno = $tareaalumno[0];
                                    }

                                    $archivos = $dbm->getRepositoriosById("CeTareaalumnoarchivo", "tareaalumnoid", $tareaalumno->getTareaalumnoid());
                                    $archivosarray = [];
                                    foreach ($archivos as $archivo) {
                                        $archivosarray[] = array("tareaalumnoarchivoid" => $archivo->getTareaalumnoarchivoid(), "size" => $archivo->getSize(), "nombre" => $archivo->getNombre(), "tipo" => $archivo->getTipo(), "contenido" => stream_get_contents($archivo->getContenido()));
                                    }
                                    $tareas[$key] = $alumno;
                                    $tareas[$key]["ArchivosAdjuntos"] = $archivosarray;
                                    $tareas[$key]["Comentarios"] = $dbm->BuscarComentarios($tarea->getTareaid(), $alumno["alumnoid"]);
                                    $tareas[$key]["Calificacion"] = $tareaalumno->getCalificacion();
                                    $tareas[$key]["tareaalumnoid"] = $tareaalumno->getTareaalumnoid();
                                }
                            }

                            foreach ($t["archivoeliminado"] as $e) {
                                $tareaarchivo = $dbm->getRepositorioById("CeTareaarchivo", "tareaarchivoid", $e);
                                $dbm->removeRepositorio($tareaarchivo);
                            }
                            foreach ($t["archivo"] as $a) {
                                $tareaarchivo = $hydrator->hydrate($a["tareaarchivoid"] ? $dbm->getRepositorioById("CeTareaarchivo", "tareaarchivoid", $a["tareaarchivoid"]) : new CeTareaArchivo(), $a);
                                $tareaarchivo->setTareaid($tarea);
                                $dbm->saveRepositorio($tareaarchivo);
                            }
                        }
                    }
                }
            } else {
                foreach ($data["tareas"] as $t) {
                    /*if ($t["editado"] && $dbm->getRepositorioById("CeTareaalumno", "tareaid", $t["tareaid"])){
                        return new View("Existen tareas de alumno asociados a la tarea ".$t["nombre"].".", Response::HTTP_OK);
                    }*/
                    $tarea = $hydrator->hydrate($t["tareaid"] ? $dbm->getRepositorioById("CeTarea", "tareaid", $t["tareaid"]) : new CeTarea(), $t);
                    $crit = $dbm->getRepositorioById("CeCriterioevaluaciongrupo", "criterioevaluaciongrupoid", $data["criterioevaluaciongrupoid"]);
                    $tarea->setCriterioevaluaciongrupoid($crit);

                    $fechainicio = new \DateTime($t["periodoentrega"]["beginDate"]["year"] . "-" . $t["periodoentrega"]["beginDate"]["month"] . "-" . $t["periodoentrega"]["beginDate"]["day"]);
                    $fechafin = new \DateTime($t["periodoentrega"]["endDate"]["year"] . "-" . $t["periodoentrega"]["endDate"]["month"] . "-" . $t["periodoentrega"]["endDate"]["day"]);
                    $tarea->setFechainicio($fechainicio);
                    $tarea->setFechafin($fechafin);
                    $tarea->setHoralimite(new \DateTime($t["horalimite"]));
                    $tarea->setEntregaextemporanea($t["entregaextemporanea"]);

                    if ($crit->getProfesorpormateriaplanestudiosid()->getMateriaid()) {
                        $tarea->setMateriaid($crit->getProfesorpormateriaplanestudiosid()->getMateriaid());
                    } else {
                        $tarea->setMateriaid($crit->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getMateriaid());
                    }
                    $dbm->saveRepositorio($tarea);
                    // if ($t["tareaid"]){
                    //     $entidad=$tarea;
                    //     $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                    //     if ($usuariodestino){
                    //         $actividad=[
                    //             "tipoactividadid"=>12,
                    //             "usuariodestinoid"=>$usuariodestino
                    //         ];
                    //         \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
                    //     }
                    // }else{
                    //     $entidad=$tarea;
                    //     $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                    //     if ($usuariodestino){
                    //         $actividad=[
                    //             "tipoactividadid"=>13,
                    //             "usuariodestinoid"=>$usuariodestino
                    //         ];
                    //         \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
                    //     }
                    // }
                    $tareaarray[] = $tarea;

                    $grupoid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getGrupoid()->getGrupoid();
                    $grupo =  $dbm->getRepositorioById("CeGrupo", "grupoid", $grupoid);
                    $alumnos = $dbm->AlumnoCicloGrupo($grupo->getCicloid()->getCicloid(), $grupoid, null, false);
                    if ($alumnos) {
                        foreach ($alumnos as $key => $alumno) {
                            $tareaalumno = $dbm->getByParametersRepositorios("CeTareaalumno", array("tareaid" => $tarea->getTareaid(), "alumnoid" => $alumno["IDAlumno"]));
                            if (!$tareaalumno) {
                                $tareaalumno = new CeTareaalumno();
                                $tareaalumno->setTareaid($dbm->getRepositorioById("CeTarea", "tareaid", $tarea->getTareaid()));
                                $tareaalumno->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $alumno["alumnoid"]));
                                $dbm->saveRepositorio($tareaalumno);
                            } else {
                                $tareaalumno = $tareaalumno[0];
                            }

                            $archivos = $dbm->getRepositoriosById("CeTareaalumnoarchivo", "tareaalumnoid", $tareaalumno->getTareaalumnoid());
                            $archivosarray = [];
                            foreach ($archivos as $archivo) {
                                $archivosarray[] = array("tareaalumnoarchivoid" => $archivo->getTareaalumnoarchivoid(), "size" => $archivo->getSize(), "nombre" => $archivo->getNombre(), "tipo" => $archivo->getTipo(), "contenido" => stream_get_contents($archivo->getContenido()));
                            }
                            $tareas[$key] = $alumno;
                            $tareas[$key]["ArchivosAdjuntos"] = $archivosarray;
                            $tareas[$key]["Comentarios"] = $dbm->BuscarComentarios($tarea->getTareaid(), $alumno["alumnoid"]);
                            $tareas[$key]["Calificacion"] = $tareaalumno->getCalificacion();
                            $tareas[$key]["tareaalumnoid"] = $tareaalumno->getTareaalumnoid();
                        }
                    }

                    foreach ($t["archivoeliminado"] as $e) {
                        $tareaarchivo = $dbm->getRepositorioById("CeTareaarchivo", "tareaarchivoid", $e);
                        $dbm->removeRepositorio($tareaarchivo);
                    }
                    foreach ($t["archivo"] as $a) {
                        $tareaarchivo = $hydrator->hydrate($a["tareaarchivoid"] ? $dbm->getRepositorioById("CeTareaarchivo", "tareaarchivoid", $a["tareaarchivoid"]) : new CeTareaArchivo(), $a);
                        $tareaarchivo->setTareaid($tarea);
                        $dbm->saveRepositorio($tareaarchivo);
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro.", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de tareas asignados a materias del profesor
     * @Rest\Get("/api/Controlescolar/Misclases/Criteriosclase/Caratula", name="getCaratula")
     */
    public function getCaratula()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $profesor = $filtros['profesorpormateriaplanestudioid']['data'];
            $now=(new \DateTime())->format('Y-m-d H:i:s');;
            $estatus = $dbm->getRepositoriosById("CeAvisosporcaratulaestatus", "activo", 1);
            $caratula = $dbm->getRepositoriosModelo("CeCaratula", 
            ["d.activo, d.criterioevaluacion, d.caratulaid, d.descripcion"], 
            [["activo = 1 and d.profesorpormateriaplanestudiosid = " . $profesor]], false, true, [])[0];
            if($caratula) {
                if($filtros['checkalumno']) {
                    $filtro = " and CAST('" . $now . "' as datetime)  >= CAST(CONCAT(d.fecha, ' ' , d.hora) AS datetime) and m.avisocaratulaestatusid IN (2,3)";
                }
                $caratula['avisos'] = $dbm->getRepositoriosModelo("CeAvisosporcaratula", 
                ["d.avisocaratulaid, d.descripcion, DATE_FORMAT(d.fecha , '%d/%m/%Y') as fecha, d.fecha as fechaparsed, DATE_FORMAT(d.hora , '%H:%i') as hora, m.nombre as estatus, m.avisocaratulaestatusid"], 
                [["caratulaid = " . $caratula['caratulaid'] . $filtro]], ["fecha"=>"DESC", "hora"=>"DESC"], true, [
                    ["entidad" => "CeAvisosporcaratulaestatus", "alias" => "m", "left" => false, "on" => "m.avisocaratulaestatusid = d.avisocaratulaestatusid"]
                ]);

                foreach($caratula['avisos'] as $key=>$av) {
                   
                    $caratula['avisos'][$key]['archivos'] = $dbm->getRepositoriosModelo("CeAvisosporcaratulaarchivo", 
                    ["d.avisocaratulaarchivoid, d.nombre, d.size, d.tipo"], 
                    [["avisocaratulaid = " . $av['avisocaratulaid']]], false, true, []);

                }

            } else if(!$caratula && $filtros['isnew'] == "true") {
                $caratula = $dbm->getRepositoriosModelo("CeCaratula", 
                    ["d.activo, d.criterioevaluacion, d.caratulaid, d.descripcion"], 
                [["profesorpormateriaplanestudiosid = " . $profesor]], false, true, [])[0];

                if($caratula) {
                    $caratula['avisos'] = $dbm->getRepositoriosModelo("CeAvisosporcaratula", 
                    ["d.avisocaratulaid, d.descripcion, DATE_FORMAT(d.fecha , '%d/%m/%Y') as fecha, d.fecha as fechaparsed, DATE_FORMAT(d.hora , '%H:%i') as hora, m.nombre as estatus, m.avisocaratulaestatusid"], 
                    [["caratulaid = " . $caratula['caratulaid']]], ["fecha"=>"DESC"], true, [
                        ["entidad" => "CeAvisosporcaratulaestatus", "alias" => "m", "left" => false, "on" => "m.avisocaratulaestatusid = d.avisocaratulaestatusid"]
                    ]);
    
                    foreach($caratula['avisos'] as $key=>$av) {
                       
                        $caratula['avisos'][$key]['archivos'] = $dbm->getRepositoriosModelo("CeAvisosporcaratulaarchivo", 
                        ["d.avisocaratulaarchivoid, d.nombre, d.size, d.tipo"], 
                        [["avisocaratulaid = " . $av['avisocaratulaid']]], false, true, []);
    
                    }
                $caratula['activo'] = 1;
                $carac = $dbm->getRepositorioById("CeCaratula", "caratulaid", $caratula['caratulaid']);
                $carac->setActivo(1);
                $dbm->saveRepositorio($carac);

                } else {
                    $caratula =  new CeCaratula();
                    $caratula->setActivo(1);
                    $caratula->setCriterioevaluacion(1);
                    $caratula->setProfesorpormateriaplanestudiosid($dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $filtros['profesorpormateriaplanestudioid']['data']));
                    $dbm->saveRepositorio($caratula);
                }

            }
            return new View(array("caratula" =>$caratula, "estatus" => $estatus), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Copia las tareas de un agrupo a otros grupos del mismo profesor
     * @Rest\Post("/api/Controlescolar/Misclases/Criteriosclase/SaveCaratula" , name="SaveCaratula")
     */
    public function SaveCaratula()
    {
        try {
            $content = file_get_contents("php://input");
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $caratula = $dbm->getRepositorioById("CeCaratula", "caratulaid", $data['caratulaid']);
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $objeto = $hydrator->hydrate($caratula, $data);
            $dbm->saveRepositorio($caratula);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Copia las tareas de un agrupo a otros grupos del mismo profesor
     * @Rest\Post("/api/Controlescolar/Misclases/Criteriosclase/SaveAvisoCaratula" , name="SaveAvisosCaratula")
     */
    public function SaveAvisosCaratula()
    {
        try {
            $content = file_get_contents("php://input");
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $avisos = $dbm->getRepositoriosById("CeAvisosporcaratula", "caratulaid", $data['caratulaid']);
            foreach($data['avisos'] as $a) {
                $avisosc = $dbm->getRepositorioById("CeAvisosporcaratula", "avisocaratulaid", $a['avisocaratulaid']);
                $avisocaratula = $avisosc ? $avisosc : new CeAvisosporcaratula() ;
                $avisocaratula->setCaratulaid($dbm->getRepositorioById("CeCaratula", "caratulaid", $data['caratulaid']));
                $avisocaratula->setDescripcion($a['descripcion'] ? $a['descripcion'] : null);
                $avisocaratula->setAvisocaratulaestatusid($a['estatusid'] ? 
                    $dbm->getRepositorioById("CeAvisosporcaratulaestatus", "avisocaratulaestatusid", $a['estatusid']) : null);
                $avisocaratula->setFecha($a['fechaformatted'] ?  new \DateTime($a['fechaformatted']) : new \DateTime());
                $avisocaratula->setHora($a['hora'] ? new \DateTime($a['hora']) : new \DateTime());    
                $dbm->saveRepositorio($avisocaratula);

                foreach($a['archivos'] as $ar) {
                    $archivo = $dbm->getRepositorioById("CeAvisosporcaratulaarchivo", "avisocaratulaarchivoid", $ar['avisocaratulaarchivoid']);
                    $avisosarchivo = $archivo ? $archivo : new CeAvisosporcaratulaarchivo();
                    $avisosarchivo->setAvisocaratulaid($avisocaratula);
                    if($ar['contenido']) {
                        $avisosarchivo->setContenido($ar['contenido']);
                    }
                    if($ar['tipo']) {
                        $avisosarchivo->setTipo($ar['tipo']);
                    }
                    $avisosarchivo->setSize($ar['size']);
                    $avisosarchivo->setNombre($ar['nombre']);
                    $dbm->saveRepositorio($avisosarchivo);
                }

            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        }catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
	 * 
	 * @Rest\Get("/api/Controlescolar/Misclases/Criteriosclase/DescargarArchivoCaratula/{id}", name="DescargarArchivoCaratula")
	 */
	public function DescargarArchivoCaratula($id){
		try{
			$dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $archivo=$dbm->getRepositorioById('CeAvisosporcaratulaarchivo', 'avisocaratulaarchivoid', $id);
            $tmp = $archivo->getContenido();
            $r = stream_get_contents($archivo->getContenido());
			$response=new \Symfony\Component\HttpFoundation\Response(
					base64_decode( $r), 200, array(
						'Content-Type'=>$archivo->getTipo(),
						'Content-Length'=>$archivo->getSize()
					)
			);
			return $response;
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
    }
    
    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Misclases/Criteriosclase/EliminarAviso/{id}", name="deleteAvisoCaratula")
     */
    public function deleteAvisoCaratula($id) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $aviso = $dbm->getRepositorioById('CeAvisosporcaratula', 'avisocaratulaid', $id);
            $dbm->removeManyRepositorio('CeAvisosporcaratulaarchivo', 'avisocaratulaid', $id);
            $dbm->removeRepositorio($aviso);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
        	if($e->getPrevious()->getCode() == "23000"){
        		return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
        	}else{
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        	}
        }
    }

    /**
	 * 
	 * @Rest\Get("/api/Controlescolar/Alumno/Misclases/Alumnos", name="obtenerMateriasAlumno")
	 */
	public function obtenerMateriasAlumno(){
		try{
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $arrayalumnos = [];
            foreach ($_REQUEST['alumnoid'] as $i) {
                $alumno = $dbm->BuscarAlumnosA(['alumnoid' => $i])[0];
                $alumno['materias']=$dbm->getMateriasAlumno($alumno);
                $arrayalumnos[] = $alumno;
            }
            return new View($arrayalumnos, Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
    }

}
