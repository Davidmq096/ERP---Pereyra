<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmAdmisiones;
use AppBundle\Entity\AdCategoriaapoyo;
use AppBundle\Entity\AdCategoriaapoyoporgrado;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author javier
 */
class CategoriaApoyoController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Categoriaapoyo", name="indexCategoriaapoyo")
     */
    public function indexCategoriaapoyo()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            return new View(array("nivel" => $nivel, "grado" => $grado), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Categoriaapoyo en base a los parametros enviados
     * @Rest\Get("/api/Categoriaapoyo/", name="BuscarCategoriaapoyo")
     */
    public function getCategoriaapoyo()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarCategoriaapoyo($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Categoriaapoyo/{id}", name="EliminarCategoriaapoyo")
     */
    public function deleteCategoriaapoyo($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio("AdCategoriaapoyoporgrado", 'categoriaapoyoid', $id);
            $categoriaapoyo = $dbm->getRepositorioById('AdCategoriaapoyo', 'categoriaapoyoid', $id);
            $dbm->removeRepositorio($categoriaapoyo);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Rest\Post("/api/Categoriaapoyo" , name="GuardarCategoriaapoyo")
     */
    public function SaveCategoriaapoyo()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $categorias = $dbm->getRepositoriosById('AdCategoriaapoyo', 'nombre', $data['nombre']);
            foreach ($categorias as $c) {
                if ($dbm->getByParametersRepositorios('AdCategoriaapoyoporgrado', array('categoriaapoyoid' => $c->getCategoriaapoyoid(), 'gradoid' => $data["gradoid"]))) {
                    return new View("Ya existe una categoria de apoyo con el mismo nombre en el grado seleccionado", Response::HTTP_PARTIAL_CONTENT);
                }
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Categoriaapoyo = $hydrator->hydrate(new AdCategoriaapoyo(), $data);
            $dbm->saveRepositorio($Categoriaapoyo);
            foreach ($data["gradoid"] as $g) {
                $categoriaporgrado = new AdCategoriaapoyoporgrado();
                $categoriaporgrado->setCategoriaapoyoid($Categoriaapoyo);
                $categoriaporgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $g));
                $dbm->saveRepositorio($categoriaporgrado);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Categoriaapoyo/{id}", name="ActualizarCategoriaapoyo")
     */
    public function updateCategoriaapoyo($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $categorias = $dbm->getRepositoriosById('AdCategoriaapoyo', 'nombre', $data['nombre']);
            foreach ($categorias as $c) {
                if ($dbm->getByParametersRepositorios('AdCategoriaapoyoporgrado', array('categoriaapoyoid' => $c->getCategoriaapoyoid(), 'gradoid' => $data["gradoid"]))
                && $c->getCategoriaapoyoid() != $id) {
                    return new View("Ya existe una categoria de apoyo con el mismo nombre en el grado seleccionado", Response::HTTP_PARTIAL_CONTENT);
                }
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Categoriaapoyo = $hydrator->hydrate($dbm->getRepositorioById('AdCategoriaapoyo', 'categoriaapoyoid', $id), $data);
            $dbm->saveRepositorio($Categoriaapoyo);
            $dbm->removeManyRepositorio("AdCategoriaapoyoporgrado", 'categoriaapoyoid', $id);
            foreach ($data["gradoid"] as $g) {
                $categoriaporgrado = new AdCategoriaapoyoporgrado();
                $categoriaporgrado->setCategoriaapoyoid($Categoriaapoyo);
                $categoriaporgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $g));
                $dbm->saveRepositorio($categoriaporgrado);
            }
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

}
