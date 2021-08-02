<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DatabaseManager;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\Materia;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Rubén
 */

class MateriaController extends FOSRestController
{
     /**
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/Materia/Consultar/{id}", name="consultarmateria")
     */
    public function consultarmateria($id)
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            $materia = $dbm->getRepositorioById('Materia', 'materiaid', $id);

            if (empty($materia)) {
                return new View("No existe la materia.", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($materia, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/Materia/Test", name="materiatest")
     */
    public function materiatest()
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            $dbm = new DatabaseManager($dbm->getEntityManager());
            $entidades = $dbm->getRepositorios('Materia');

            return new View($entidades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/Materia/Combos", name="combosMaterias")
     */
    public function combosMaterias()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $areaacademica = $dbm->getRepositoriosById('CeAreaacademica', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $materia = $dbm->getRepositoriosById('Materia', 'activo', 1);
            $clasificador = $dbm->getRepositoriosById('CeClasificadorparaescolares', 'activo', 1);

            return new View(array(
                "nivel" => $nivel,
                "areaacademica" => $areaacademica,
                "materia" => $materia,
                "clasificador" => $clasificador),
                Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/Materia/Reporte/{id}", name="materiareporte")
     */
    public function materiareporte($id)
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            $dbm = new DbmControlescolar($dbm->getEntityManager());
            $entidades = $dbm->obtenerReporteMaterias($id);

            return new View($entidades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/Materia/Filtrar", name="filtrarmaterias")
     */
    public function filtrarmaterias()
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            $dbm = new DbmControlescolar($dbm->getEntityManager());
            $entidades = $dbm->FiltrarMaterias($decoded);

            return new View($entidades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/Materia/Nivel/Filtrar", name="filtrarmateriasnivel")
     */
    public function filtrarmateriasnivel()
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            $dbm = new DbmControlescolar($dbm->getEntityManager());
            $entidades = $dbm->FiltrarMateriasPorNivel($decoded);

            return new View($entidades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una nuva materia
     * @Rest\Post("/api/Materia/AgregarNueva", name="agregarnuevamateria")
     */
    public function agregarnuevamateria()
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $materiasbusqueda = $dbm->getByParametersRepositorios('Materia', array(
                "nivelid" => $decoded['nivelid'],
                "nombre" => $decoded['nombre'],
            ));

            if (!empty($materiasbusqueda)) {
                return new View("La materia con el nivel ya existe.", Response::HTTP_PARTIAL_CONTENT);
            }

            $materia = $hydrator->hydrate('AppBundle\Entity\Materia', $decoded);
            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($materia);
            $dbm->getConnection()->commit();

            return new View("Registro agregado de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * Guarda una nuva materia
     * @Rest\Post("/api/Materia/Editar", name="editarmateria")
     */
    public function editarmateria()
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            if (!isset($decoded['materiaid'])) {
                return new View("No existe la materia", Response::HTTP_PARTIAL_CONTENT);
            }

            $materia = $dbm->getRepositorioById('Materia', 'materiaid', $decoded['materiaid']);
            $materiapadre = $dbm->getRepositorioById('Materia', 'materiaid', $decoded['materiapadreid']);
            $areaacademica = $dbm->getRepositorioById('CeAreaacademica', 'areaacademicaid', $decoded['areaacademicaid']);

            if (empty($materia)) {
                return new View("No existe la materia", Response::HTTP_PARTIAL_CONTENT);
            }

            if (empty($areaacademica)) {
                return new View("No existe la Área académica", Response::HTTP_PARTIAL_CONTENT);
            }

            $materia->setClave($decoded['clave']);
            $materia->setNombre($decoded['nombre']);
            $materia->setAlias($decoded['alias']);
            $materia->setNombreingles($decoded['nombreingles']);
            $materia->setNombrecortoingles($decoded['nombrecortoingles']);
            $materia->setNombreexterno($decoded['nombreexterno']);
            $materia->setEssubmateria($decoded['essubmateria']);
            $materia->setColorsubmaterias($decoded['colorsubmaterias']);
            $materia->setMateriapadreid($materiapadre);
            $materia->setAreaacademicaid($areaacademica);
            $materia->setActivo($decoded['activo']);
            $materia->setClasificadorparaescolaresid($dbm->getRepositorioById("CeClasificadorparaescolares","clasificadorparaescolaresid",$decoded['clasificadorparaescolaresid']));
            $materia->setMateriapredecesoraid($dbm->getRepositorioById("Materia","materiaid",$decoded['materiapredecesoraid']));

            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($materia);
            $dbm->getConnection()->commit();

            return new View("Registro modificado de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una nuva materia
     * @Rest\Delete("/api/Materia/Eliminar/{id}", name="eliminarmateria")
     */
    public function eliminarmateria($id)
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            $materia = $dbm->getRepositorioById('Materia', 'materiaid', $id);

            $dbm->getConnection()->beginTransaction();
            if (!empty($materia)) {
                $dbm->removeRepositorio($materia);
            } else {
                return new View("No se encontró la materia", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->commit();
            return new View("Registro eliminado de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro, ya que se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            }
        }
    }

}
