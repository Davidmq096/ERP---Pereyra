<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\DB\DbmPagoLinea;
use AppBundle\Entity\Municipio;
use AppBundle\Entity\CjPagofolio;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class CiudadController extends FOSRestController
{


    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Ciudad", name="indexCiudad")
     */
    public function indexCiudad()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());
            //test de funcionamiento de caja
            $this->verifyFolio();

            $pais = $dbm->BuscarPaises(array("activo" => true));
            $estado = $dbm->BuscarEstados(array("activo" => true));
            return new View(array("Pais" => $pais, "Estado" => $estado), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de ciudades en base a los parametros enviados
     * @Rest\Get("/api/Ciudad/", name="BuscarCiudad")
     */
    public function getEstado()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarCiudades($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Retorna arreglo de ciudades en base a los parametros enviados
     * @Rest\Get("/api/Ciudad/{idestado}", name="BuscarCiudadById")
     */
    public function getCiudadBy($idestado)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->getRepositoriosById('Municipio', 'estadoid', $idestado, 'nombre');
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
     * @Rest\Delete("/api/Ciudad/{id}", name="EliminarCiudad")
     */
    public function deleteCiudad($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $ciudad = $dbm->getRepositorioById('Municipio', 'municipioid', $id);
            $dbm->removeRepositorio($ciudad);
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
     * @Rest\Post("/api/Ciudad" , name="GuardarCiudad")
     */
    public function SaveCiudad()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $ciudad = $dbm->getOneByParametersRepositorio("Municipio", [
                "estadoid" => $data['estadoid'],
                "nombre" => $data['nombre']
            ]);
            if ($ciudad) {
                return new View("Ya existe una ciudad con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $ciudad = new Municipio();
            $ciudad->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $ciudad->setActivo(empty($data['activo']) ? null : ($data['activo'] == 'true' ? true : false));
            $ciudad->setEstadoid(empty($data['estadoid']) ? null : $dbm->getRepositorioById('Estado', 'estadoid', $data['estadoid']));

            $dbm->saveRepositorio($ciudad);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Ciudad/{id}" , name="ActualizarCiudad")
     */
    public function updateCiudad($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getOneByParametersRepositorio("Municipio", [
                "estadoid" => $data['estadoid'],
                "nombre" => $data['nombre']
            ]);
            if ($validar && $validar->getMunicipioid() != $id) {
                return new View("Ya existe una ciudad con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $ciudad = $dbm->getRepositorioById('Municipio', 'municipioid', $id);
            $ciudad->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $ciudad->setActivo(empty($data['activo']) ? null : ($data['activo'] == 'true' ? true : false));
            $ciudad->setEstadoid(empty($data['estadoid']) ?
                null : $dbm->getRepositorioById('Estado', 'estadoid', $data['estadoid']));
            $dbm->saveRepositorio($ciudad);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    public function verifyFolio() {
        try {
            $db= $this->get("db_manager");
            $db->getConnection()->beginTransaction();
            $cajaid = $db->getRepositorioById('Parametros', 'nombre', 'Caja Id del cajero del banco');
            $caja = $db->getRepositorioById('CjCaja', 'cajaid', intval($cajaid->getValor()));
            //reseteamos el entity manager para que en caso de que ya exista un id poder reestablecer la conexion para volver a intentar
            $this->get('doctrine')->resetEntityManager();

            $dbm = new DbmPagoLinea($this->get('doctrine')->getEntityManager());
            $folio = $dbm->GetFolioPago($caja->getCajaid());
            $foliopago = new CjPagofolio();
            $foliopago->setFolio($folio);
            $dbm->saveRepositorio($foliopago);

            $db->getConnection()->commit();
            return $folio;

        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                $this->verifyFolio();
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }



}
