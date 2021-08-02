<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\Colonia;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class ColoniaController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Colonia", name="indexColonia")
     */
    public function indexColonia()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $pais = $dbm->BuscarPaises(array("activo" => true));
            $estado = $dbm->BuscarEstados(array("activo" => true));
            $ciudad = $dbm->BuscarCiudades(array("activo" => true));
            return new View(array("Pais" => $pais, "Estado" => $estado,
                "Ciudad" => $ciudad), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de colonias por los parametros enviados
     * @Rest\Get("/api/Colonia/", name="BuscarColonias")
     */
    public function getColonias()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarColonias($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Retorna arreglo de colonias por los parametros enviados
     * @Rest\Get("/api/Colonia/{idciudad}", name="BuscarColoniaByIdCiudad")
     */
    public function getColoniasBy($idciudad)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->getRepositoriosById('Colonia', 'municipioid', $idciudad, 'nombre');
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Retorna arreglo de colonias por los parametros enviados
     * @Rest\Get("/api/Colonia/GetByCP/{cp}", name="BuscarColoniasByCP")
     */
    public function getColoniasByCP($cp)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $colonia = $dbm->getRepositoriosById('Colonia', 'cp', $cp, 'nombre');
            if (!$colonia) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($colonia, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Colonia/{id}", name="EliminarColonia")
     */
    public function deleteCiudad($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $colonia = $dbm->getRepositorioById('Colonia', 'coloniaid', $id);
            $dbm->removeRepositorio($colonia);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Rest\Post("/api/Colonia" , name="GuardarColonia")
     */
    public function SaveColonia()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $colonia = $dbm->getOneByParametersRepositorio("Colonia", [
                "municipioid" => $data['municipioid'],
                "nombre" => $data['nombre']
            ]);
            if ($colonia) {
                return new View("Ya existe una colonia con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            $colonia = new Colonia();
            $colonia->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $colonia->setCp(empty($data['cp']) ? null : $data['cp']);
            $colonia->setMunicipioid(empty($data['municipioid']) ? null : $dbm->getRepositorioById('Municipio', 'municipioid', $data['municipioid']));

            $dbm->saveRepositorio($colonia);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Colonia/{id}" , name="ActualizarColonia")
     */
    public function updateColonia($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getOneByParametersRepositorio("Colonia", [
                "municipioid" => $data['municipioid'],
                "nombre" => $data['nombre']
            ]);
            if ($validar && $validar->getColoniaid() != $id) {
                return new View("Ya existe una colonia con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            $colonia = $dbm->getRepositorioById('Colonia', 'coloniaid', $id);
            $colonia->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $colonia->setCp(empty($data['cp']) ? null : $data['cp']);
            $colonia->setMunicipioid(empty($data['municipioid']) ? null : $dbm->getRepositorioById('Municipio', 'municipioid', $data['municipioid']));

            $dbm->saveRepositorio($colonia);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
