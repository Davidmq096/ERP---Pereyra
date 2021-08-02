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

class ContactoEmergenciaController extends FOSRestController
{
    /**
     *  Muestra los datos iniciales del contacto de emergecia
     * @Rest\Get("/api/Controlescolar/Alumno/ContactoEmergencia", name="indexContactoEmergencia")
     */
    public function indexContactoEmergencia()
    {
        try
        {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $parentesco = $dbm->getRepositorios("Parentesco");
            $tiposangre = $dbm->getRepositorios("Tiposanguineo");
            $alergias = $dbm->getRepositorios("Alergia");
            $antecedentes = $dbm->getRepositorios("Antecedentefamiliarimportante");
            return new View(array("parentesco" => $parentesco, "tiposangre" => $tiposangre, "alergias" => $alergias, "antecedentes" => $antecedentes), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
