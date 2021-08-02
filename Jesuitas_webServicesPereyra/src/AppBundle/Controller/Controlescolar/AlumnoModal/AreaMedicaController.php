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

class AreaMedicaController extends FOSRestController
{
    /**
     *  Recupera los datos medicos
     * @Rest\Get("/api/Controlescolar/Alumno/DatosMedicos/{alumnoid}", name="BuscarDatosMedicos")
     */
    public function BuscarDatosMedicos($alumnoid)
    {
        try
        {

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $datosmedicos = $dbm->getRepositorioById("CeAlumnodatomedico", "alumnoid", $alumnoid);
            if (!$datosmedicos) {
                return new View("No existen datos médicos del alumno.", Response::HTTP_PARTIAL_CONTENT);
            }
            $alergias = $dbm->getRepositoriosById("CeAlergiapordatomedico", "alumnodatomedicoid", $datosmedicos->getAlumnodatomedicoid());
            $antecedentes = $dbm->getRepositoriosById("CeAntecedentefamiliarpordatomedico", "alumnodatomedicoid", $datosmedicos->getAlumnodatomedicoid());
            $otrocontacto = $dbm->getRepositoriosById('CeContactoemergencia', 'alumnoid', $datosmedicos->getAlumnoId()->getAlumnoId());
            if (strlen($datosmedicos->getTelefonopersonaatiende()) == 8) {
                $lada = substr($datosmedicos->getTelefonopersonaatiende(), 0, 2);
                $telefono = substr($datosmedicos->getTelefonopersonaatiende(), 2, 6);
            } else {
                $lada = substr($datosmedicos->getTelefonopersonaatiende(), 0, 3);
                $telefono = substr($datosmedicos->getTelefonopersonaatiende(), 3, 7);
            }
            if (strlen($datosmedicos->getContactoemergenciatelefono()) == 8) {
                $ladacontacto = substr($datosmedicos->getContactoemergenciatelefono(), 0, 2);
                $telefonocontacto = substr($datosmedicos->getContactoemergenciatelefono(), 2, 6);
            } else {
                $ladacontacto = substr($datosmedicos->getContactoemergenciatelefono(), 0, 3);
                $telefonocontacto = substr($datosmedicos->getContactoemergenciatelefono(), 3, 7);
            }
            $telefonos = array("lada" => $lada, "telefono" => $telefono, "ladacontacto" => $ladacontacto, "telefonocontacto" => $telefonocontacto);

            return new View(array("datosmedicos" => $datosmedicos, "alergias" => $alergias, "antecedentes" => $antecedentes, "telefonos" => $telefonos, 'otrocontacto' => $otrocontacto), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Guarda los datos medicos
     * @Rest\Post("/api/Controlescolar/Alumno/DatosMedicos/{alumnoid}", name="GuardaDatosMedicos")
     */
    public function GuardaDatosMedicos($alumnoid)
    {
        try
        {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $no = array("(", ")", "-");
            //$decoded["telefonopersonaatiende"]=str_replace($no,"",$decoded['lada']).str_replace($no,"",$decoded['telefono']);
            //$decoded["contactoemergenciatelefono"]=str_replace($no,"",$decoded['ladacontacto']).str_replace($no,"",$decoded['telefonocontacto']);
            $decoded["contactoemergenciatelefono"] = $decoded['telefonocontacto'];
            $datosmedicos = $hydrator->hydrate($dbm->getRepositorioById("CeAlumnodatomedico", "alumnoid", $alumnoid) ? $dbm->getRepositorioById("CeAlumnodatomedico", "alumnoid", $alumnoid) : new CeAlumnodatomedico(), $decoded);
            if (!$decoded['padece']) {
                $datosmedicos->setPadece(null);
            }
            if(!$decoded['antecedentefamiliar']) {
                $datosmedicos->setAntecedentefamiliar(null);
            }
            $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $alumnoid);
            $dbm->saveRepositorio($datosmedicos);
            //if ($decoded['version'] == 1) {
                foreach ($decoded['otrocontacto'] as $contacto) {
                    if (empty($contacto['contactoemergenciaid'])) {
                        $contactoDatomedico = new \AppBundle\Entity\CeContactoemergencia();
                        $contactoDatomedico->setNombre(empty($contacto['nombre']) ? null : $contacto['nombre']);
                        $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $contacto['parentescoid']);
                        if($parentesco){
                            $contactoDatomedico->setParentescoid($parentesco);
                        }
                        $contactoDatomedico->setAlumnoid($alumno);
                        $lada = str_replace(')', '', str_replace('(', '', $contacto['lada']));
                        $tel = str_replace('-', '', $contacto['telefono']);
                        $contactoDatomedico->setTelefono(empty($contacto['lada']) ? null : $lada . '-' . $tel);
                        $dbm->saveRepositorio($contactoDatomedico);
                    } else {
                        $contactoDatomedico = $dbm->getRepositorioById("CeContactoemergencia", "contactoemergenciaid", $contacto['contactoemergenciaid']);
                        $contactoDatomedico->setNombre(empty($contacto['nombre']) ? null : $contacto['nombre']);
                        $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $contacto['parentescoid']);
                        if($parentesco){
                            $contactoDatomedico->setParentescoid($parentesco);
                        }
                        $contactoDatomedico->setAlumnoid($alumno);
                        $lada = str_replace(')', '', str_replace('(', '', $contacto['lada']));
                        $tel = str_replace('-', '', $contacto['telefono']);
                        $contactoDatomedico->setTelefono(empty($contacto['lada']) ? null : $lada . '-' . $tel);
                        $dbm->saveRepositorio($contactoDatomedico);
                    }
                }
            //}
            foreach ($decoded['eliminados'] as $eliminado) {
                $contactoDatomedico = $dbm->getRepositorioById('CeContactoemergencia', 'contactoemergenciaid', $eliminado);
                if ($contactoDatomedico) {
                    $dbm->removeRepositorio($contactoDatomedico);
                }
            }
            $dbm->removeManyRepositorio('CeAlergiapordatomedico', 'alumnodatomedicoid', $datosmedicos->getAlumnodatomedicoid());
            foreach ($decoded["alergiaid"] as $alergiaid) {
                $alergiadatomedico = new CeAlergiapordatomedico();
                $alergiadatomedico->setAlumnodatomedicoid($datosmedicos);
                $alergiadatomedico->setAlergiaid($dbm->getRepositorioById("Alergia", "alergiaid", $alergiaid));
                $dbm->saveRepositorio($alergiadatomedico);
            }
            $dbm->removeManyRepositorio('CeAntecedentefamiliarpordatomedico', 'alumnodatomedicoid', $datosmedicos->getAlumnodatomedicoid());
            foreach ($decoded["antecedentefamiliarimportanteid"] as $antecedentefamiliarimportanteid) {
                $antecedentefamiliar = new CeAntecedentefamiliarpordatomedico();
                $antecedentefamiliar->setAlumnodatomedicoid($datosmedicos);
                $antecedentefamiliar->setAntecedentefamiliarimportanteid($dbm->getRepositorioById("Antecedentefamiliarimportante", "antecedentefamiliarimportanteid", $antecedentefamiliarimportanteid));
                $dbm->saveRepositorio($antecedentefamiliar);
            }
            return new View("Se han guardado los datos médicos.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
