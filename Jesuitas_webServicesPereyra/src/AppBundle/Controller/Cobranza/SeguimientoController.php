<?php

namespace AppBundle\Controller\Cobranza;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmCobranza;
use AppBundle\Entity\CbSeguimiento;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier
 */
class SeguimientoController extends FOSRestController
{

    /**
     * Retorna arreglo de bloqueos en base a los parametros enviados
     * @Rest\Get("/api/Cobranza/Seguimiento/", name="BuscarSeguimiento")
     */
    public function getSeguimiento()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarSeguimiento($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna
     * @Rest\Get("/api/Cobranza/Seguimiento/Bitacora/{id}", name="indexSeguimiento")
     */
    public function indexSeguimiento($id)
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $bitacora = $dbm->getRepositoriosById('CbSeguimiento', 'clavefamiliarid', $id);
            $mediocontacto = $dbm->getRepositoriosById('CbMediocontacto', 'activo', 1);
            return new View(array("bitacora" => $bitacora, "mediocontacto" => $mediocontacto), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Cobranza/Seguimiento/{id}" , name="GuardarSeguimiento")
     */
    public function SaveSeguimiento($id)
    {
        try {$datos = $_REQUEST;
            $datos = json_decode($datos["datos"], true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($datos["bitacoraeliminadosid"] as $d) {
                $bitacora = $dbm->getRepositorioById('CbSeguimiento', 'seguimientoid', $d);
                $dbm->removeRepositorio($bitacora);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            foreach ($datos["bitacoras"] as $d) {
                if ($d["editado"]) {
                    $d["clavefamiliarid"] = $id; 
                    $d["fecha"] = new \DateTime();
                    $d["hora"] = new \DateTime();                   
                    $bitacora = $hydrator->hydrate($d["seguimientoid"] ? $dbm->getRepositorioById('CbSeguimiento', 'seguimientoid', $d["seguimientoid"]) : new CbSeguimiento(), $d);
                    $dbm->saveRepositorio($bitacora);                    
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
