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

class SubgruposController extends FOSRestController
{
/**
     * Obtiene los padres y tutotes del alumno y el domicilio actual del alumno
     * @Rest\Get("/api/Controlescolar/Alumno/Subgrupos/Datoalumno", name="getDatoalumnobyciclo")
     */
    public function getDatoalumnobyciclo()
    {
        try
        {
            $datos = $_REQUEST;
            $filtros = array_filter($datos); //alumnoid
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if ($filtros["alumnoid"]) {
                $array = $dbm->BuscarDatosalumnociclo($filtros['alumnoid']);
                foreach($array as $key=>$a) {
                    if($a['nivelid'] == 1 || $a['nivelid'] == 2) {
                        $profesor = $dbm->BuscarIProfesorTitular($a['grupoid'])[0];
                        $array[$key]['profesor'] = $profesor['nombre'];
                    }
                }
                
                return new View($array, Response::HTTP_OK);
            } else {
                return new View("Falta el id del alumno.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

/**
     * Obtiene los padres y tutotes del alumno y el domicilio actual del alumno
     * @Rest\Get("/api/Controlescolar/Alumno/Subgrupos/Grupotalleralumno", name="GetSubgrupoTallerAlumno")
     */
    public function GetSubgrupoTallerAlumno()
    {
        try
        {
            $datos = $_REQUEST;
            $filtros = array_filter($datos); //alumnoid
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if ($filtros["alumnoporcicloid"]) {
                $talleres = $dbm->GetTalleresByAlumno($filtros['alumnoporcicloid']);
                $subgrupos = $dbm->GetSubgruposByAlumno($filtros['alumnoporcicloid']);
                foreach($subgrupos as $s){ array_push($talleres, $s); }
                if(!$talleres){
                    return new View("No se encontró ningun registro", Response::HTTP_PARTIAL_CONTENT);     
                }
                return new View($talleres, Response::HTTP_OK);
            } else {
                return new View("Falta el id del alumno.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }    
}
