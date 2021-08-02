<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DatabaseManager;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeCertificacion;
use AppBundle\Entity\CeCriterioporcertificacion;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;

/**
 * @author Mariano
 */
class CertificacionController extends FOSRestController{

    /**
     * Retorna arreglo de datos iniciales de certificaciones
     * @Rest\Get("/api/Controlescolar/Certificacion", name="indexCertificacion")
     */
    public function indexCertificacion()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $idioma = $dbm->getRepositoriosById('CeIdioma', 'activo', 1);
            $tipovigencia = [["id"=>1,"nombre"=>"Permanente"],["id"=>2,"nombre"=>"Años"]];
            return new View(["idioma"=>$idioma,"tipovigencia"=>$tipovigencia], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de certificaciones
     * @Rest\Get("/api/Controlescolar/Certificacion/", name="getCertificacion")
     */
    public function getCertificacion()
    {
        try {
            $content = trim(file_get_contents("php://input")); 
            $filtros = json_decode($content, true); 
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $certificaciones = $dbm->BuscarCertificaciones($filtros);
            return new View($certificaciones, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una certificacion
     * @Rest\Post("/api/Controlescolar/Certificacion", name="saveCertificacion")
     */
    public function saveCertificacion()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $certificacion = $hydrator->hydrate(new CeCertificacion(), $data);
            $dbm->saveRepositorio($certificacion);
            $dbm->removeManyRepositorio('CeCriterioporcertificacion', 'certificacionid', $certificacion->getCertificacionid());
            foreach ($data["criterios"] as $c){
                $criterio=new CeCriterioporcertificacion();
                $criterio->setNombre($c["criterio"]);
                $criterio->setCertificacionid($certificacion);
                $dbm->saveRepositorio($criterio);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Edita una certificacion
     * @Rest\Put("/api/Controlescolar/Certificacion/{certificacionid}", name="updateCertificacion")
     */
    public function updateCertificacion($certificacionid)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $certificacion = $hydrator->hydrate($dbm->getRepositorioById("CeCertificacion","certificacionid",$certificacionid), $data);
            $dbm->saveRepositorio($certificacion);
            $dbm->removeManyRepositorio('CeCriterioporcertificacion', 'certificacionid', $certificacionid);
            foreach ($data["criterios"] as $c){
                $criterio=new CeCriterioporcertificacion();
                $criterio->setNombre($c["criterio"]);
                $criterio->setCertificacionid($certificacion);
                $dbm->saveRepositorio($criterio);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina una certificacion
     * @Rest\Delete("/api/Controlescolar/Certificacion/{certificacionid}", name="deleteCertificacion")
     */
    public function deleteCertificacion($certificacionid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio('CeCriterioporcertificacion', 'certificacionid', $certificacionid);
            $certificacion = $dbm->getRepositorioById("CeCertificacion","certificacionid",$certificacionid);
            $dbm->removeRepositorio($certificacion);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    
}   