<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeGrupo;

/**
 * @author Mariano
 */

class GrupoController extends FOSRestController
{

    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Get("/api/Controlescolar/Grupos", name="indexGrupos")
     */
    public function indexGrupos()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $areaespecializacion = $dbm->getRepositoriosById('CeAreaespecializacion', 'activo', 1);

            return new View(
                array(
                    "ciclo" => $ciclo,
                    "nivel" => $nivel,
                    "grado" => $grado,
                    "semestre" => $semestre,
                    "areaespecializacion" => $areaespecializacion
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Busca los grupos de acuerdo a los filtros enviados
     * @Rest\Post("/api/Controlescolar/Grupos/Filtrar", name="BuscarGrupos")
     */
    public function BuscarGrupos()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            array_filter($filtros);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $grupos = $dbm->BuscarGrupos($filtros);
            foreach ($grupos as &$grupo) {
                $grado = $dbm->getRepositorioById("Grado", "gradoid", $grupo["gradoid"]);
                $grupo['grado'] = $grado;
                $editable = true;
                $subgruposrelacionados = $dbm->getRepositoriosById("CeGrupoorigenporsubgrupo", "grupoorigenid", $grupo["grupoid"]);
                $alumnosrelacionados = $dbm->getRepositoriosById("CeAlumnocicloporgrupo", "grupoid", $grupo["grupoid"]);
                $profesoresrelacionados = $dbm->getRepositoriosById("CeProfesorpormateriaplanestudios", "grupoid", $grupo["grupoid"]);
                if ($subgruposrelacionados || $alumnosrelacionados || $profesoresrelacionados) {
                    $editable = false;
                }
                $grupo["editable"] = $editable;
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
     *  Responde con los arreglos iniciales para las listas de los filtrod
     * @Rest\Post("/api/Controlescolar/Grupos", name="GuardarGrupo")
     */
    public function SaveGrupos()
    {
        try {
            $datos = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            foreach ($datos as $grupo) {
                $existe = $dbm->BuscarGrupos(["cicloid" => $grupo["cicloid"], "nivelid" => $grupo["nivelid"], "gradoid" => $grupo["gradoid"], "nombre" => $grupo["nombre"]]);
                if ($existe) {
                    return new View("Ya existe un grupo con el mismo nombre en el mismo grado y ciclo.", Response::HTTP_PARTIAL_CONTENT);
                }
                $grupo["tipogrupoid"] = 1;
                $Grupo = $hydrator->hydrate(new CeGrupo(), $grupo);

                $dbm->saveRepositorio($Grupo);
            }
            $dbm->getConnection()->commit();
            return new View("Se han guardado los registros.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Responde con los arreglos iniciales para las listas de los filtrod
     * @Rest\Put("/api/Controlescolar/Grupos/{id}", name="EditarGrupo")
     */
    public function EditGrupos($id)
    {
        try {
            $datos = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $existe = $dbm->BuscarGrupos(["cicloid" => $datos["cicloid"], "nivelid" => $datos["nivelid"], "gradoid" => $datos["gradoid"], "nombre" => $datos["nombre"]]);
            if ($existe && $existe[0]["grupoid"] != $id) {
                return new View("Ya existe un grupo con el mismo nombre en el mismo grado y ciclo.", Response::HTTP_PARTIAL_CONTENT);
            }

            $g = $dbm->getRepositorioById("CeGrupo", "grupoid", $id);
            if ($datos["editable"]) {
                $Grupo = $hydrator->hydrate($g, $datos);
            } else {
                if ($datos["cupo"] < $g->getCupo()) {
                    return new View("No se puede editar un grupo si ya tiene profesores asignados.", Response::HTTP_PARTIAL_CONTENT);
                } else {
                    $Grupo = $hydrator->hydrate($g, $datos);
                }
            }
            $dbm->saveRepositorio($Grupo);

            $dbm->getConnection()->commit();
            return new View("Se han guardado los registros.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Grupos/{GrupoId}", name="EliminarGrupo")
     */
    public function deleteGrupo($GrupoId)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $subgruposrelacionados = $dbm->getRepositoriosById("CeGrupoorigenporsubgrupo", "grupoorigenid", $GrupoId);
            if ($subgruposrelacionados) {
                return new View("No se puede eliminar un grupo si ya tiene subgrupos relacionados.", Response::HTTP_PARTIAL_CONTENT);
            }
            $alumnosrelacionados = $dbm->getRepositoriosById("CeAlumnocicloporgrupo", "grupoid", $GrupoId);
            if ($alumnosrelacionados) {
                return new View("No se puede eliminar un grupo si ya tiene alumnos asignados.", Response::HTTP_PARTIAL_CONTENT);
            }
            $profesoresrelacionados = $dbm->getRepositoriosById("CeProfesorpormateriaplanestudios", "grupoid", $GrupoId);
            if ($profesoresrelacionados) {
                return new View("No se puede eliminar un grupo si ya tiene profesores asignados.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->removeManyRepositorio('CeBitacoraarmadogrupo', 'grupoorigenid', $GrupoId);
            $dbm->removeManyRepositorio('CeBitacoraarmadogrupo', 'grupodestinoid', $GrupoId);

            $Grupo = $dbm->getRepositorioById('CeGrupo', 'grupoid', $GrupoId);
            $dbm->removeRepositorio($Grupo);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Copia los grupos del ciclo actual al siguiente
     * @Rest\Post("/api/Controlescolar/Grupos/CopiarCiclo", name="CopiarGruposCiclo")
     */
    public function CopiarGruposCiclo()
    {
        try {
            $datos = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $ciclosiguiente = $dbm->getRepositorioById("Ciclo", "siguiente", 1);

            $existengrupos = $dbm->BuscarGrupos(["cicloid" => $ciclosiguiente->getCicloid(), "tipogrupoid" => 1, "nivelid" => $datos['nivelid']]);
            if ($existengrupos) {
                return new View("Ya existen grupos creados en el ciclo siguiente.", Response::HTTP_PARTIAL_CONTENT);
            }
            $cicloactual = $dbm->getRepositorioById("Ciclo", "actual", 1);
            $grupos = $dbm->BuscarGrupos(["cicloid" => $cicloactual->getCicloid(), "nivelid" => $datos['nivelid']]);
            foreach ($grupos as $grupo) {
                $grupo = $dbm->getRepositorioById("CeGrupo", "grupoid", $grupo['grupoid']);
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
