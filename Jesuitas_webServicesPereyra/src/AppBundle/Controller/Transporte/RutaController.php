<?php

namespace AppBundle\Controller\Transporte;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmTransporte;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\TpRuta;
use AppBundle\Entity\TpRutapreciofijo;
use AppBundle\Entity\TpRutaprecioparada;
use FOS\RestBundle\View\View;
use AppBundle\Entity\TpRutaexcepcion;

/**
 * Auto: Javier
 */
class RutaController extends FOSRestController
{

    /**
     * Retorna arreglo de paises en base a los parametros enviados
     * @Rest\Get("/api/Transporte/Ruta/", name="BuscarRuta")
     */
    public function indexRuta()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $subconcepto = $dbm->getRepositoriosById('CjSubconcepto', 'activo', 1);
            $ruta = $dbm->BuscarRuta($filtros);
            return new View(array("subconcepto" => $subconcepto, "ruta" => $ruta), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de rutas en base a los parametros enviados
     * @Rest\Get("/api/Transporte/Ruta/detalle/{id}", name="RutaDetalle")
     */
    public function detalleRuta($id)
    {
        try {
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $ruta = $dbm->getRepositorioById('TpRuta', 'rutaid', $id);
            $rutapreciofijo = $dbm->getRepositoriosById('TpRutapreciofijo', 'rutaid', $id);
            $rutaprecioprecioparada = $dbm->getRepositoriosById('TpRutaprecioparada', 'rutaid', $id, 'orden');
            return new View(array("ruta" => $ruta, "rutapreciofijo" => $rutapreciofijo, "rutaprecioparada" => $rutaprecioprecioparada), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Transporte/Ruta/{id}", name="EliminarRuta")
     */
    public function deleteRuta($id)
    {
        try {
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $dbm->removeManyRepositorio("TpRutapreciofijo", "rutaid", $id);
            $dbm->removeManyRepositorio("TpRutaprecioparada", "rutaid", $id);
            $ruta = $dbm->getRepositorioById('TpRuta', 'rutaid', $id);
            $dbm->removeRepositorio($ruta);
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
     * @Rest\Post("/api/Transporte/Ruta" , name="GuardarRuta")
     */
    public function SaveRuta()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $data["horainicio"] = new \DateTime($data['horainicio']);
            $data["horafin"] = new \DateTime($data['horafin']);

            $Ruta = $hydrator->hydrate($data["rutaid"] ? $dbm->getRepositorioById('TpRuta', 'rutaid', $data["rutaid"]) : new TpRuta(), $data);
            $dbm->saveRepositorio($Ruta);

            foreach ($data["fijoeliminado"] as $id) {
                $dbm->removeManyRepositorio("TpRutapreciofijo", "rutapreciofijoid", $id);
            }
            foreach ($data["fijo"] as $f) {
                $Rutapreciofijo = $hydrator->hydrate($f["rutapreciofijoid"] ? $dbm->getRepositorioById('TpRutapreciofijo', 'rutapreciofijoid', $f["rutapreciofijoid"]) : new TpRutapreciofijo(), $f);
                $Rutapreciofijo->setRutaid($Ruta);
                $dbm->saveRepositorio($Rutapreciofijo);
            }

            foreach ($data["paradaeliminado"] as $id) {
                $dbm->removeManyRepositorio("TpRutaprecioparada", "rutaprecioparadaid", $id);
            }
            foreach ($data["parada"] as $p) {
                $Rutaprecioparada = $hydrator->hydrate($p["rutaprecioparadaid"] ? $dbm->getRepositorioById('TpRutaprecioparada', 'rutaprecioparadaid', $p["rutaprecioparadaid"]) : new TpRutaprecioparada(), $p);
                $Rutaprecioparada->setRutaid($Ruta);
                $dbm->saveRepositorio($Rutaprecioparada);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de paises en base a los parametros enviados
     * @Rest\Get("/api/Transporte/Ruta/Excepcion/{id}", name="RutaExcepcion")
     */
    public function excepcionRuta($id)
    {
        try {
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $excepciones = $dbm->getRepositoriosById('TpRutaexcepcion', 'rutaid', $id);
            return new View($excepciones, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de paises en base a los parametros enviados
     * @Rest\Post("/api/Transporte/Ruta/Excepcion/", name="GuardarRutaExcepcion")
     */
    public function SaveexcepcionRuta()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            foreach ($data["excepcioneseliminado"] as $id) {
                $dbm->removeManyRepositorio("TpRutaexcepcion", "rutaexcepcionid", $id);
            }
            foreach ($data["excepciones"] as $e) {
                $e["horainicio"] = $e["horainicio"]  ? new \DateTime($e['horainicio']) : null;
                $e["horafin"] = $e["horafin"] ? new \DateTime($e['horafin']) : null;

                $Excepcion = $hydrator->hydrate($e["rutaexcepcionid"] ? $dbm->getRepositorioById('TpRutaexcepcion', 'rutaexcepcionid', $e["rutaexcepcionid"]) : new TpRutaexcepcion(), $e);
                $Excepcion->setRutaid($dbm->getRepositorioById('TpRuta', 'rutaid', $data["rutaid"]));
                $dbm->saveRepositorio($Excepcion);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
