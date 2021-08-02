<?php

namespace AppBundle\Controller\Controlescolar;

use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\CePonderacionopcion;
use AppBundle\Entity\CePonderacion;
use AppBundle\DB\DbmControlescolar;

/**
 * Auto: Javier
 */
class PonderacionController extends FOSRestController {

    /**
     * Retorna arreglo de ponderaciones
     * @Rest\Get("/api/Controlescolar/Ponderacion/Filtrar", name="BuscarPonderacion")
     */
    public function getPonderacion() {
    	try {
    		$datos = $_REQUEST;
    		$filtros = array_filter($datos, function($datos) {
                return ($datos !== null && $datos !== false && $datos !== ''); 
            });
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
    		$entidad = $dbm->BuscarPonderaciones($filtros);
    		if (!$entidad) {
    			return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
    		}else{
                foreach ($entidad as $ponderacion){
                    $p=array("nombre"=>$ponderacion->getNombre(),"activo"=>$ponderacion->getActivo(),"ponderacionid"=>$ponderacion->getPonderacionid());
                    $p["opciones"]=$dbm->getRepositoriosById("CePonderacionopcion","ponderacionid",$ponderacion->getPonderacionid());
                    $respuesta[]=$p;
                }
            }
    		return new View($respuesta, Response::HTTP_OK);
    	} catch (Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }

        /**
     * @Rest\Post("/api/Controlescolar/Ponderacion" , name="GuardarPonderacion")
     */
    public function SavePonderacion() {
        try {
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true); 
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $ponderacion=$dbm->getRepositorioById("CePonderacion","ponderacionid",$decoded["ponderacionid"]);
            if (!$ponderacion){
                $ponderacion = $hydrator->hydrate(new CePonderacion(), $decoded);
            }else{
                $ponderacion = $hydrator->hydrate($ponderacion, $decoded);
            }
            $dbm->saveRepositorio($ponderacion);
            foreach ($decoded["opciones"] as $opcion){
                $ponderacionopcion=$dbm->getRepositorioById("CePonderacionopcion","ponderacionopcionid",$opcion["ponderacionopcionid"]);
                if (!$ponderacionopcion){
                    $ponderacionopcion = $hydrator->hydrate(new CePonderacionopcion(), $opcion);
                    $ponderacionopcion->setPonderacionid($ponderacion);
                }else{
                    $ponderacionopcion = $hydrator->hydrate($ponderacionopcion, $opcion);
                }
                $dbm->saveRepositorio($ponderacionopcion);
            }
            foreach ($decoded["eliminadas"] as $ponderacionopcionid){
                $po=$dbm->getRepositorioById("CePonderacionopcion","ponderacionopcionid",$ponderacionopcionid);
                $dbm->removeRepositorio($po);
            }
            $dbm->getConnection()->commit();
            $ponderaciones=$dbm->getRepositorios("CePonderacion");
            foreach ($ponderaciones as $ponderacion){
                $p=array("nombre"=>$ponderacion->getNombre(),"activo"=>$ponderacion->getActivo(),"ponderacionid"=>$ponderacion->getPonderacionid());
                $p["opciones"]=$dbm->getRepositoriosById("CePonderacionopcion","ponderacionid",$ponderacion->getPonderacionid());
                $respuesta[]=$p;
            }
            //return new View(array("ponderaciones"=>$ponderaciones,"ponderacionid"=>$ponderacion->getPonderacionid()), Response::HTTP_OK);
            return new View($respuesta, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Ponderacion/{id}", name="EliminarPonderacion")
     */
    public function deletePonderacion($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio('CePonderacionopcion', "ponderacionid", $id);
            $ponderacion = $dbm->getRepositorioById('CePonderacion', 'ponderacionid', $id);
            $dbm->removeRepositorio($ponderacion);
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


}
