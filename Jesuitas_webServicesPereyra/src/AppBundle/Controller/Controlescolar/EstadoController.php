<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\Estado;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class EstadoController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Estado", name="indexEstado")
     */
    public function indexEstado()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $Pais = $dbm->BuscarPaises(array("activo" => true));
            return new View(array("Pais" => $Pais), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de estados en base a los parametros enviados
     * @Rest\Get("/api/Estado/", name="BuscarEstado")
     */
    public function getEstado()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarEstados($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Retorna arreglo de estados en base a los parametros enviados
     * @Rest\Get("/api/Estado/{idpais}", name="BuscarEstadoById")
     */
    public function getEstadoBy($idpais)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->getRepositoriosById('Estado', 'paisid', $idpais, 'nombre');
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Estado/{id}", name="EliminarEstado")
     */
    public function deleteEstado($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $estado = $dbm->getRepositorioById('Estado', 'estadoid', $id);
            $dbm->removeRepositorio($estado);
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
     * @Rest\Post("/api/Estado" , name="GuardarEstado")
     */
    public function SaveEstado()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $estado = $dbm->getOneByParametersRepositorio("Estado", [
                "paisid" => $data['paisid'],
                "nombre" => $data['nombre']
            ]);
            $abreviatura = $dbm->getOneByParametersRepositorio("Estado", [
                "paisid" => $data['paisid'],
                "abreviatura" => $data['abreviatura']
            ]);
            if ($estado) {
                return new View("Ya existe un estado con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            if ($abreviatura) {
                return new View("Ya existe un estado con la misma abreviatura", Response::HTTP_PARTIAL_CONTENT);
            }

            $estado = new Estado();
            $estado->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $estado->setAbreviatura(empty($data['abreviatura']) ? null : $data['abreviatura']);
            $estado->setActivo($data['activo'] == "true" ? true : false);
            $estado->setPaisid(empty($data['paisid']) ? null : $dbm->getRepositorioById('Pais', 'paisid', $data['paisid']));
            $dbm->saveRepositorio($estado);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Estado/{id}" , name="ActualizarEstado")
     */
    public function updateEstado($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $validar = $dbm->getOneByParametersRepositorio("Estado", [
                "paisid" => $data['paisid'],
                "nombre" => $data['nombre']
            ]);
            if ($validar && $validar->getEstadoid() != $id) {
                return new View("Ya existe un estado con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            $validar = $dbm->getOneByParametersRepositorio("Estado", [
                "paisid" => $data['paisid'],
                "abreviatura" => $data['abreviatura']
            ]);
            if ($validar && $validar->getEstadoid() != $id) {
                return new View("Ya existe un estado con la misma abreviatura", Response::HTTP_PARTIAL_CONTENT);
            }

            $estado = $dbm->getRepositorioById('Estado', 'estadoid', $id);
            $estado->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $estado->setAbreviatura(empty($data['abreviatura']) ? null : $data['abreviatura']);
            $estado->setActivo($data['activo'] == "true" ? true : false);
            $estado->setPaisid(empty($data['paisid']) ? null : $dbm->getRepositorioById('Pais', 'paisid', $data['paisid']));
            $dbm->saveRepositorio($estado);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
