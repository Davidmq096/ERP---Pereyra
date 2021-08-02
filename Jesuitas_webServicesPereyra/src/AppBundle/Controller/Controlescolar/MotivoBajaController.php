<?php

namespace AppBundle\Controller\Controlescolar;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CeMotivobaja;
use FOS\RestBundle\View\View;

/**
 * Auto: David
 */
class MotivoBajaController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Motivobaja", name="indexMotivobaja")
     */
    public function indexMotivobaja() {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $motivobaja = $dbm->getRepositorios('CeMotivobaja');
            return new View($motivobaja, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

/**
     * Retorna filtros Motivo de baja
     * @Rest\Post("/api/Motivobaja/Filtrar", name="Motivobajafiltro")
     */
    public function Motivobajafiltro()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarMotivobaja($decoded);
            if (!$entidad) {
                return new View("No se encontró ningún registro. ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * Elimina un registro
     * @Rest\Delete("/api/Motivobaja/{id}", name="EliminarMotivobaja")
     */
    public function deleteMotivobaja($id) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $cupoadmision = $dbm->getRepositorioById('CeMotivobaja', 'motivobajaid', $id);
            $dbm->removeRepositorio($cupoadmision);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
        	if($e->getPrevious()->getCode() == "23000"){
        		return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
        	}else{
        		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        	}
        }
    }

    /**
     * @Rest\Post("/api/Motivobaja" , name="GuardarMotivobaja")
     */
    public function SaveMotivobaja() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            if ($dbm->getRepositorioById('CeMotivobaja', 'nombre', $data['nombre'])) {
                return new View("Ya existe un motivo de baja con el mismo nombre.", Response::HTTP_PARTIAL_CONTENT);
            }
            $Motivobaja = new CeMotivobaja();
            $Motivobaja->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $Motivobaja->setActivo($data['activo'] == "true" ? true : false);
            $Motivobaja->setClavesegdgb(empty($data['clave']) ? null : $data['clave']);
            $conjunto=$dbm->getRepositorioById("CeTipobaja","tipobajaid",$data["tipobajaid"]);
            $Motivobaja->setTipobajaid($conjunto);
            $Motivobaja->setPermitereingreso(empty($data['permitereingreso']) ? false : true);
            $dbm->saveRepositorio($Motivobaja);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Motivobaja/{id}" , name="ActualizarMotivobaja")
     */
    public function updateMotivobaja($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
           
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getRepositorioById('CeMotivobaja', 'nombre', $data['nombre']);
            if ($validar && $validar->getMotivobajaid() != $id) {
                return new View("Ya existe un motivo de baja con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $Motivobaja = $dbm->getRepositorioById('CeMotivobaja', 'motivobajaid', $id);
            $Motivobaja->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $Motivobaja->setActivo($data['activo'] == "true" ? true : false);
            $Motivobaja->setClavesegdgb(empty($data['clave']) ? null : $data['clave']);
            $Motivobaja->setTipobajaid($dbm->getRepositorioById("CeTipobaja","tipobajaid",$data["tipobajaid"]));
            $Motivobaja->setPermitereingreso(empty($data['permitereingreso']) ?  false : true);
            $dbm->saveRepositorio($Motivobaja);
            $dbm->getConnection()->commit();

            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
