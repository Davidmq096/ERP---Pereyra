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

class FamiliarController extends FOSRestController
{
    /**
     * Obtiene los padres y tutotes del alumno y el domicilio actual del alumno
     * @Rest\Get("/api/Controlescolar/Alumno/Familia/", name="CEAAlumnoFamilia")
     */
    public function GetAlumnoFamilia()
    {
        try
        {
            $datos = $_REQUEST;
            $filtros = array_filter($datos); //alumnoid
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if ($filtros["alumnoid"]) {
                //padres o tutores
                $clavefamiliarAlumno = $dbm->getRepositoriosById("CeAlumnoporclavefamiliar", 'alumnoid', $filtros["alumnoid"]);
                if(count($clavefamiliarAlumno) > 0){
                    $hermanosPorClave = $dbm->getRepositoriosById("CeAlumnoporclavefamiliar", 'clavefamiliarid', $clavefamiliarAlumno[0]->getClavefamiliarid()->getClavefamiliarid());
                    $personasAutorizadas = $dbm->getRepositoriosById("CePersonaautorizadarecogerporalumno", 'alumnoid', $filtros["alumnoid"]);
                    $hermanos = [];
    
                    foreach($hermanosPorClave as $hermano){
                        if($hermano->getAlumnoid()->getAlumnoid() == $filtros['alumnoid']){
                        }else{
                            $alumnoporciclo = $dbm->BuscarAlumnosA(["alumnoid" =>$hermano->getAlumnoid()->getAlumnoid()]);
                            $hermanos[] = $alumnoporciclo? $alumnoporciclo[0] : null;
                        }
                    }
    
                    $padretutor = array();
    
                    foreach ($clavefamiliarAlumno as &$clave) {
                        $padre = $dbm->GetPadreTutorAlumno($clave->getClavefamiliarid()->getClavefamiliarid());
    
                        foreach ($padre as &$tutor) {
                            //nacionalidad
                            $tutor["nacionalidad"] = $dbm->GetNacionalidadPadreoTutor($tutor["padresotutoresid"]);
    
                            array_push($padretutor, $tutor);
                        }
                    }
    
                    //domicilio
                    $domicilio = $dbm->GetDomicilioAlumno($filtros["alumnoid"]);
    
                    $familia = array
                        (
                        'padresotutores' => $padretutor,
                        'domicilio' => $domicilio,
                        'hermanos' => $hermanos,
                        'personasautorizadas' => $personasAutorizadas,
                        'clavefamiliar' => $clavefamiliarAlumno[0]->getClavefamiliarid()
                    );
                    return new View($familia, Response::HTTP_OK);
                }
                
                return new View('El alumno no tiene familia registrada', Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View("Falta el id del alumno.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @Rest\Get("/api/Controlescolar/Alumno/PadreOTutor", name="CEGetPadresOTutoresDatos")
     */
    public function CEGetPadresOTutoresDatos()
    {
        try
        {
            $datos = $_REQUEST;
            $filtros = array_filter($datos); //padresotutoresid

            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT * FROM ce_pppadretutoralumnovista WHERE PadresOTutoresId = :id GROUP BY PadresOTutoresId');
            $stmt->execute(array('id' => $filtros["padresotutoresid"]));
            $result = $stmt->fetchAll();

            foreach ($result as &$tutor) {
                $tutor['TutorId'] = intval($tutor['TutorId']);
                $tutor['SituacionConyugalId'] = intval($tutor['SituacionConyugalId']);
                $tutor['NivelEstudioId'] = intval($tutor['NivelEstudioId']);

                $stmt = $conn->prepare('SELECT PadresOTutoresId, NacionalidadId FROM ce_padresotutoresnacionalidad WHERE PadresOTutoresId = :id');
                $stmt->execute(array('id' => $tutor['PadresOTutoresId']));
                $tutor['Nacionalidad'] = $stmt->fetchAll();

                foreach ($tutor['Nacionalidad'] as &$nac) {
                    $nac = intval($nac['NacionalidadId']);
                }
            }

            return new View($result, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene los catalogos de la pantalla de padres y tutotes
     * @Rest\Get("/api/Controlescolar/Alumno/PadresOTutores", name="CEAAlumnoCatalogosPadresOTutores")
     */
    public function CEAAlumnoCatalogosPadresOTutores()
    {
        try
        {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $nacionalidad = $dbm->getRepositoriosById('Nacionalidad', 'activo', 1);
            $tutor = $dbm->getRepositorios('Tutor');
            $situacionConyugal = $dbm->getRepositorios('Situacionconyugal');
            $escolaridad = $dbm->getRepositorios('Escolaridad');
            $generacion = $dbm->getRepositorios('Generacion');

            $filtro = array
                (
                'tutor' => $tutor,
                'nacionalidad' => $nacionalidad,
                'generacion' => $generacion,
                'situacionconyugal' => $situacionConyugal,
                'escolaridad' => $escolaridad,
            );

            return new View($filtro, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna filtros becas
     * @Rest\Post("/api/Controlescolar/Alumno/Familia/GuardarDomicilio", name="guardardomicilioalumno")
     */
    public function GuardarDomicilioAlumno()
    {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        try {
            $dbm->getConnection()->beginTransaction();

            $entidad = $data['alumnodomicilioid'] ? 
            $dbm->getRepositorioById('CeAlumnodomicilio', 'alumnodomicilioid', $data['alumnodomicilioid']) : new CeAlumnodomicilio();
            
            $entidad->setAlumnoid($dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid']));
            $entidad->setEsfiscal(0);
            $entidad->setCalle($data['calle']);
            $entidad->setCiudad($dbm->getRepositorioById('Municipio', 'municipioid', $data['ciudadid']));
            $entidad->setNumerointerior($data['nointerior']);
            $entidad->setNumeroexterior($data['noexterior']);
            $entidad->setColonia($data['colonias']);
            $entidad->setCodigopostal($data['cp']);

            $dbm->saveRepositorio($entidad);
            $dbm->getConnection()->commit();

            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        }catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
