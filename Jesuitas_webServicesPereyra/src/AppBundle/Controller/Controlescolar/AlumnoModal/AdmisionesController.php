<?php

namespace AppBundle\Controller\Controlescolar\AlumnoModal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAlergiapordatomedico;
use AppBundle\Entity\CeAlumno;
use AppBundle\Entity\CeAlumnocorreo;
use AppBundle\Entity\CeAlumnodatomedico;
use AppBundle\Entity\CeAlumnolugarnacimiento;
use AppBundle\Entity\CeAlumnotelefono;
use AppBundle\Entity\CeAntecedentefamiliarpordatomedico;
use AppBundle\Entity\CeNacionalidadporalumno;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Gabriel
 */

class AdmisionesController extends FOSRestController
{
    /**
     * Fltros
     * @Rest\Get("/api/Controlescolar/Alumno/Solicitud", name="AlumnoSolicitudFilters")
     */
    public function solicitudFilterAction()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $filters = array_filter($datos, function ($value) {
                return $value !== '';
            });

            $Solicitud = $dbm->getAlumnoSolicitudByFilter($filters);
            if (!$Solicitud) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            $return = array('solicitud' => $Solicitud);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
