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

class HorarioController extends FOSRestController
{
    /**
     * Obtiene los padres y tutotes del alumno y el domicilio actual del alumno
     * @Rest\Get("/api/Controlescolar/Alumno/Horario/{alumnoid}", name="HorarioAlumno")
     */
    public function getHorario($alumnoid)
    {
        try
        {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            return new View("Falta el id del alumno.", Response::HTTP_PARTIAL_CONTENT);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }
}
