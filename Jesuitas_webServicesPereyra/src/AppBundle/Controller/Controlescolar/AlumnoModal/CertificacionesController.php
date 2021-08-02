<?php

namespace AppBundle\Controller\Controlescolar\AlumnoModal;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeCertificacionporalumno;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;

/**
 * Auto: David
 */
class CertificacionesController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/Alumno/Certificacion/{id}", name="getCertificaciones")
     */
    public function getCertificaciones($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $certificacion = $dbm->getRepositoriosById('CeCertificacionporalumno', 'alumnoid', $id);
            return new View($certificacion, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Alumno/Certificacion/eliminarcert/{id}", name="EliminarCert")
     */
    public function EliminarCert($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $certalu = $dbm->getRepositorioById('CeCertificacionporalumno', 'certificacionporalumnoid', $id);
            $dbm->removeRepositorio($certalu);

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
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Alumno/Certificacion/eliminar/{id}", name="deleteCertificaciones")
     */
    public function deleteCertificaciones($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $certalu = $dbm->getRepositorioById('CeCertificacionporalumno', 'certificacionporalumnoid', $id);
            $dbm->removeRepositorio($certalu);

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
     * @Rest\Post("/api/Controlescolar/Alumno/Certificacion" , name="SaveCertificacion")
     */
    public function SaveCertificacion()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $certalu = new CeCertificacionporalumno();
            $certalu->setCalificacion(empty($data['calificacion']) ? null : $data['calificacion']);
            $certalu->setFechacertificado(empty($data['fechacertificacion']) ? null :new \DateTime($data['fechacertificacion']));
            $certalu->setAlumnoid(empty($data['alumnoid']) ?
            null : $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid']));
            $certalu->setCertificacionid(empty($data['certificacionid']) ?
            null : $dbm->getRepositorioById('CeCertificacion', 'certificacionid', $data['certificacionid']));
            $certalu->setVigencia(empty($data['vigencia']) ? null : $data['vigencia']);
            $dbm->saveRepositorio($certalu);

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Controlescolar/Alumno/Certificacion/{id}" , name="updateCertficacion")
     */
    public function updateCertficacion($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            
            $certalu = $dbm->getRepositorioById('CeCertificacionporalumno', 'certificacionporalumnoid', $id);
            $certalu->setCalificacion(empty($data['calificacion']) ? null : $data['calificacion']);
            $certalu->setFechacertificado(empty($data['fechacertificacion']) ? null :new \DateTime($data['fechacertificacion']));
            $certalu->setAlumnoid(empty($data['alumnoid']) ?
            null : $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid']));
            $certalu->setCertificacionid(empty($data['certificacionid']) ?
            null : $dbm->getRepositorioById('CeCertificacion', 'certificacionid', $data['certificacionid']));
            $certalu->setVigencia(empty($data['vigencia']) ? null : $data['vigencia']);
            $dbm->saveRepositorio($certalu);         

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}