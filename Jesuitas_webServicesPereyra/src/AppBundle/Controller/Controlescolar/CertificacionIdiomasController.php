<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DatabaseManager;
use AppBundle\DB\DbmTalleresExtracurriculares;
use AppBundle\Entity\CeIdiomacertificacion;
use AppBundle\Entity\CeCriterioporidiomacertificacion;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;

/**
 * @author Mariano
 */
class CertificacionIdiomasController extends FOSRestController{

    /**
     * Retorna arreglo de datos iniciales de certificaciones de idiomas
     * @Rest\Get("/api/Controlescolar/CertificacionIdiomas", name="indexCertificacionIdiomas")
     */
    public function indexCertificacionIdiomas()
    {
        try {
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $idioma = $dbm->getRepositoriosById('CeIdioma', 'activo', 1);
            $tipovigencia = [["id"=>1,"nombre"=>"Permanente"],["id"=>2,"nombre"=>"Años"]];
            return new View(["idioma"=>$idioma,"tipovigencia"=>$tipovigencia], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de certificaciones de idioma
     * @Rest\Get("/api/Controlescolar/CertificacionIdiomas/", name="getCertificacionIdiomas")
     */
    public function getCertificacionIdiomas()
    {
        try {
            $content = trim(file_get_contents("php://input")); 
            $filtros = json_decode($content, true); 
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $certificaciones = $dbm->BuscarCertificacionesIdiomas($filtros);
            return new View($certificaciones, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una certificacion de idioma
     * @Rest\Post("/api/Controlescolar/CertificacionIdiomas", name="saveCertificacionIdiomas")
     */
    public function saveCertificacionIdiomas()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $certificacion = $hydrator->hydrate(new CeIdiomacertificacion(), $data);
            $dbm->saveRepositorio($certificacion);
            $dbm->removeManyRepositorio('CeCriterioporidiomacertificacion', 'idiomacertificacionid', $certificacion->getIdiomacertificacionid());
            foreach ($data["criterios"] as $c){
                $criterio=new CeCriterioporidiomacertificacion();
                $criterio->setNombre($c["criterio"]);
                $criterio->setIdiomacertificacionid($certificacion);
                $dbm->saveRepositorio($criterio);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Edita una certificacion de idioma
     * @Rest\Put("/api/Controlescolar/CertificacionIdiomas/{idiomacertificacionid}", name="updateCertificacionIdiomas")
     */
    public function updateCertificacionIdiomas($idiomacertificacionid)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $certificacion = $hydrator->hydrate($dbm->getRepositorioById("CeIdiomacertificacion","idiomacertificacionid",$idiomacertificacionid), $data);
            $dbm->saveRepositorio($certificacion);
            $dbm->removeManyRepositorio('CeCriterioporidiomacertificacion', 'idiomacertificacionid', $idiomacertificacionid);
            foreach ($data["criterios"] as $c){
                $criterio=new CeCriterioporidiomacertificacion();
                $criterio->setNombre($c["criterio"]);
                $criterio->setIdiomacertificacionid($certificacion);
                $dbm->saveRepositorio($criterio);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina una certificacion de idioma
     * @Rest\Delete("/api/Controlescolar/CertificacionIdiomas/{idiomacertificacionid}", name="deleteCertificacionIdiomas")
     */
    public function deleteCertificacionIdiomas($idiomacertificacionid)
    {
        try {
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio('CeCriterioporidiomacertificacion', 'idiomacertificacionid', $idiomacertificacionid);
            $certificacion = $dbm->getRepositorioById("CeIdiomacertificacion","idiomacertificacionid",$idiomacertificacionid);
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