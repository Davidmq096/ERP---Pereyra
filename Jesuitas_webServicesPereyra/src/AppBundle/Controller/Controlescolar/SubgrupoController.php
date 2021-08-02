<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeGrupo;
use AppBundle\Entity\CeSubgrupopormateria;
use AppBundle\Entity\CeGrupoorigenporsubgrupo;

/**
 * @author Mariano
 */

class SubgrupoController extends FOSRestController
{

    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Get("/api/Controlescolar/Subgrupos", name="indexSubgrupos")
     */
    public function indexSubgrupos()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $grupos = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1, "nombre");

            $planestudio = $dbm->getRepositoriosById('CePlanestudios', 'vigente', 1);
            $materias = array();
            foreach ($planestudio as $p) {
                $materias = array_merge(
                    $materias,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid(), 'configurarsubgrupos' => 1]
                    )
                );
            }
            $clasificador = $dbm->getRepositoriosById('CeClasificadorparaescolares', 'activo', 1);
            $nivelparaescolares = $dbm->getRepositoriosById('CeNivelparaescolares', 'activo', 1);

            return new View(
                array(
                    "ciclo" => $ciclo,
                    "nivel" => $nivel,
                    "grado" => $grado,
                    "semestre" => $semestre,
                    "planestudio" => $planestudio,
                    "materias" => $materias,
                    "grupos" => $grupos,
                    "clasificador" => $clasificador,
                    "nivelparaescolares" => $nivelparaescolares
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Busca los grupos de acuerdo a los filtros enviados
     * @Rest\Post("/api/Controlescolar/Subgrupos/Filtrar", name="BuscarSubgrupos")
     */
    public function BuscarSubgrupos()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            array_filter($filtros);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $grupos = $dbm->BuscarSubgruposDivisor($filtros);

            foreach ($grupos as $key => $grupo) {
                $subgrupos = explode(',', $grupo["subgrupos"]);
                $grupos[$key]["subgrupos"] = $dbm->getRepositoriosById("CeGrupo", "grupoid", $subgrupos);
                $editable = true;
                $alumnosrelacionados = $dbm->getRepositoriosById("CeAlumnocicloporgrupo", "grupoid", $subgrupos);
                $profesoresrelacionados = $dbm->getRepositoriosById("CeProfesorpormateriaplanestudios", "grupoid", $subgrupos);
                if ($alumnosrelacionados || $profesoresrelacionados) {
                    $editable = false;
                }
                $grupos[$key]["editable"] = $editable;
            }

            if (!$grupos) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($grupos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Guarda los subgrupos
     * @Rest\Post("/api/Controlescolar/Subgrupos", name="GuardarSubgrupo")
     */
    public function GuardarSubgrupo()
    {
        try {
            $datos = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $existe = $dbm->BuscarSubgruposDivisor(["cicloid" => $datos["cicloid"], "materiaid" => $datos["materiaid"], "grupoorigenid" => $datos["grupoorigenid"]]);
            if ($existe) {
                return new View("Ya existe un subgrupo con la misma materia en el mismo ciclo.", Response::HTTP_PARTIAL_CONTENT);
            }

            foreach ($datos["subgrupos"] as $s) {
                $grupo = [
                    "tipogrupoid" => 2,
                    "cicloid" => $datos["cicloid"],
                    "cupo" => $datos["cupo"],
                    "nombre" => $s["nombre"],
                    "gradoid" => $datos["gradoid"],
                    "nivelparaescolaresid" => $s["nivelparaescolaresid"]
                ];
                $subgrupo = $hydrator->hydrate(new CeGrupo(), $grupo);
                $dbm->saveRepositorio($subgrupo);

                // $subgrupomateria = new CeSubgrupopormateria();
                // $subgrupomateria->setGrupoid($subgrupo);
                // $dbm->saveRepositorio($subgrupomateria);
                
                $grupoorigen = new CeGrupoorigenporsubgrupo();
                $grupoorigen->setGrupoid($subgrupo);
                $grupoorigen->setMateriaporplanestudioid($dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $datos["materiaid"]));
                $grupoorigen->setGrupoorigenid($dbm->getRepositorioById("CeGrupo", "grupoid", $datos["grupoorigenid"]));
                $dbm->saveRepositorio($grupoorigen);
            }
            $dbm->getConnection()->commit();
            return new View("Se han guardado los registros.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Guarda los subgrupos
     * @Rest\Put("/api/Controlescolar/Subgrupos", name="EditarSubgrupo")
     */
    public function EditarSubgrupo()
    {
        try {
            $datos = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            //Si aun no se han asignado profesores o alumnos a los grupos, se vuelven a crear desde cero
            if ($datos["editable"]) {
                //Eliminamos los subgrupos seleccionados por el usuario
                foreach ($datos["subgruposeliminados"] as $s) {
                    $dbm->removeManyRepositorio('CeGrupoorigenporsubgrupo', 'grupoid', $s);
                    $dbm->removeManyRepositorio('CeGrupo', 'grupoid', $s);
                }
                foreach ($datos["subgrupos"] as $s) {
                    if ($s["grupoid"]) {
                        $dbm->removeManyRepositorio('CeGrupoorigenporsubgrupo', 'grupoid', $s["grupoid"]);
                        //$dbm->removeManyRepositorio('CeGrupo', 'grupoid', $s["grupoid"]);
                    }
                }
                $existe = $dbm->BuscarSubgruposDivisor(["cicloid" => $datos["cicloid"], "materiaid" => $datos["materiaid"], "grupoorigenid" => $datos["grupoorigenid"]]);
                if ($existe) {
                    return new View("Ya existe un subgrupo con la misma materia en el mismo ciclo.", Response::HTTP_PARTIAL_CONTENT);
                }

                

                foreach ($datos["subgrupos"] as $s) {
                    $grupo = [
                        "tipogrupoid" => 2,
                        "cicloid" => $datos["cicloid"],
                        "cupo" => $datos["cupo"],
                        "nombre" => $s["nombre"],
                        "gradoid" => $datos["gradoid"],
                        "nivelparaescolaresid" => $s["nivelparaescolaresid"]
                    ];
                    $subgrupo = $hydrator->hydrate($s["grupoid"] ? $dbm->getRepositorioById("CeGrupo", "grupoid", $s["grupoid"]) : new CeGrupo(), $grupo);
                    if(!$s["nivelparaescolaresid"]) {
                        $subgrupo->setNivelparaescolaresid(null);
                    }
                    $dbm->saveRepositorio($subgrupo);

                    // $subgrupomateria = new CeSubgrupopormateria();
                    // $subgrupomateria->setGrupoid($subgrupo);
                    // $subgrupomateria->setMateriaid($dbm->getRepositorioById("Materia", "materiaid", $datos["materiaid"]));
                    // $dbm->saveRepositorio($subgrupomateria);

                    $grupoorigen = new CeGrupoorigenporsubgrupo();
                    $grupoorigen->setGrupoid($subgrupo);
                    $grupoorigen->setMateriaporplanestudioid($dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $datos["materiaid"]));
                    $grupoorigen->setGrupoorigenid($dbm->getRepositorioById("CeGrupo", "grupoid", $datos["grupoorigenid"]));
                    $dbm->saveRepositorio($grupoorigen);
                }
            } else { //Solo se editaran nombres, cupo y nivel paraescolares
                foreach ($datos["subgrupos"] as $s) {
                    $grupo = [
                        "cupo" => $datos["cupo"],
                        "nombre" => $s["nombre"],
                        "nivelparaescolaresid" => $s["nivelparaescolaresid"]
                    ];
                    $subgrupo = $hydrator->hydrate($dbm->getRepositorioById("CeGrupo", "grupoid", $s["grupoid"]) , $grupo);
                    $dbm->saveRepositorio($subgrupo);
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se han guardado los registros.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina los subgrupos
     * @Rest\Post("/api/Controlescolar/Subgrupos/Borrar", name="EliminarSubgrupos")
     */
    public function deleteSubgrupos()
    {
        try {
            $datos = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($datos as $GrupoId) {
                $alumnosrelacionados = $dbm->getRepositoriosById("CeAlumnocicloporgrupo", "grupoid", $GrupoId);
                if ($alumnosrelacionados) {
                    return new View("No se puede eliminar un grupo si ya tiene alumnos asignados.", Response::HTTP_PARTIAL_CONTENT);
                }
                $profesoresrelacionados = $dbm->getRepositoriosById("CeProfesorpormateriaplanestudios", "grupoid", $GrupoId);
                if ($profesoresrelacionados) {
                    return new View("No se puede eliminar un grupo si ya tiene profesores asignados.", Response::HTTP_PARTIAL_CONTENT);
                }
                $dbm->removeManyRepositorio('CeGrupoorigenporsubgrupo', 'grupoid', $GrupoId);
                $Grupo = $dbm->getRepositorioById('CeGrupo', 'grupoid', $GrupoId);
                $dbm->removeRepositorio($Grupo);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro.", Response::HTTP_OK);
        } catch (Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     *  Copia los grupos del ciclo actual al siguiente
     * @Rest\Post("/api/Controlescolar/Subgrupos/CopiarCiclo", name="CopiarSubgruposCiclo")
     */
    public function CopiarSubgruposCiclo()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $ciclosiguiente = $dbm->getRepositorioById("Ciclo", "siguiente", 1);
            $existengrupos = $dbm->getRepositorioById("CeGrupo", "cicloid", $ciclosiguiente->getCicloid());
            if ($existengrupos) {
                return new View("Ya existen grupos creados en el ciclo siguiente.", Response::HTTP_PARTIAL_CONTENT);
            }
            $cicloactual = $dbm->getRepositorioById("Ciclo", "actual", 1);
            $grupos = $dbm->getRepositoriosById("CeGrupo", "cicloid", $cicloactual->getCicloid());
            foreach ($grupos as $grupo) {
                $Grupo = clone $grupo;
                $Grupo->setCicloid($ciclosiguiente);
                $dbm->saveRepositorio($Grupo);
            }
            $dbm->getConnection()->commit();
            return new View("Se han guardado los registros.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
