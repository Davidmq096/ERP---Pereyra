<?php

namespace AppBundle\Controller\Admisiones\ModalSolicitud;

use AppBundle\DB\DbmAdmisiones;
use AppBundle\Entity\Padresotutores;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Mariano hernandez
 */
class DatosFamiliaresController extends FOSRestController
{

    /**
     * Retorna valores iniciales de datos de aspirante
     * @Rest\Get("/api/Solicitud/datoFamiliar/{id}", name="SolicitudDatosFamiliares")
     */
    public function SolicitudDatosFamiliares($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);

            $parentesco = $dbm->getRepositorios('Tutor');
            $nacionalidades = $dbm->getRepositorios('Nacionalidad');
            $padresotutores = $dbm->getRepositoriosById('Padresotutores', 'solicitudadmisionid', $id);

            //Ciencias
            if ($SolicitudEntity->getClavefamiliar()) {
                $clavefamiliar = $dbm->getRepositorioById('CeClavefamiliar', 'clave', $SolicitudEntity->getClavefamiliar());
            }

            $personaautoriza = $dbm->getRepositoriosById('Personaautorizadarecoger', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());

            $municipios = $dbm->getRepositoriosById("Municipio", "municipioid", $SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid());
            $estados = $dbm->getRepositoriosById("Estado", "estadoid", $municipios[0] ? $municipios[0]->getEstadoid() : null);
            $colonias = $dbm->getRepositoriosById("Colonia", "coloniaid", $SolicitudEntity->getDatoaspiranteid()->getColoniaid());
            array_push($colonias,array("coloniaid" => -1, "nombre" => "Otra"));
            $generacion = $dbm->getRepositorios("Generacion");
            $padres = array();
            foreach ($padresotutores as $p) {
                if ($p->getSituacionconyugal() && !in_array($p->getSituacionconyugal(), $SituacionConyugal)) {
                    $SituacionConyugal[] = $p->getSituacionconyugal();
                }
                if ($p->getNivelestudioid() && !in_array($p->getNivelestudioid(), $escolaridad)) {
                    $escolaridad[] = $p->getNivelestudioid();
                }
                array_push($padres, array(
                    "padre" =>$p, "nacionalidad" => $dbm->getRepositoriosById('Nacionalidadporpadresotutores', 'padresotutoresid', $p->getPadresotutoresid())
                ));
            }

            $return = array(
                "parentesco" => $parentesco,
                "padres" => $padres,
                "clavefamiliar" => $clavefamiliar,
                'personaautoriza' => $personaautoriza,
                "datoaspirante" => $SolicitudEntity->getDatoaspiranteid(),

                'estados' => $estados,
                'municipios' => $municipios,
                "colonias" => $colonias,
                "situacionconyugal" => $SituacionConyugal,
                "escolaridad" => $escolaridad,
                'generacion' => $generacion,                
                "nacionalidades" => $nacionalidades);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para guardar datos familiares
     * @Rest\Post("/api/Solicitud/datosFamiliares/padres", name="datosFamiliaresPadresModal")
     */
    public function savePadresAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

            if (empty($SolicitudEntity)) {
                return new View("Error no se encontro ninguna solicitud" . $data['solicitudadmisionid'], Response::HTTP_NOT_FOUND);
            }

            $Familiar = $data['idtutor'] ? $dbm->getRepositorioById('Padresotutores', 'padresotutoresid', $data['idtutor']) : new Padresotutores();
            $Familiar->setSolicitudadmisionid($SolicitudEntity);
            $Familiar->setNombre($data['nombre']);
            $Familiar->setApellidopaterno($data['apellidopaterno']);
            $Familiar->setApellidomaterno($data['apellidomaterno']);
            $Familiar->setCelular($data['celular']);
            $Familiar->setCorreo($data['correo']);
            $Familiar->setTutorid($dbm->getRepositorioById('Tutor', 'tutorid', $data['parentesco']));
            $Familiar->setAlumnoinstituto($data['alumnoInstituto']);
            $Familiar->setExlux($data['exalumno'] ? $data['exalumno'] : 0);
            $Familiar->setGeneracionid($data['generacion'] ?  $dbm->getRepositorioById('Generacion', 'generacionid', $data['generacion']) : null);
            $Familiar->setEspecificaralumno($data['especificarAlumnoInstituto']);
            $dbm->saveRepositorio($Familiar);

            $padresotutores = $dbm->getRepositoriosById('Padresotutores', 'solicitudadmisionid', $data['solicitudadmisionid']);
            $padres = array();
            foreach ($padresotutores as $p) {
                array_push($padres, array(
                    "padre" =>$p, "nacionalidad" => $dbm->getRepositoriosById('Nacionalidadporpadresotutores', 'padresotutoresid', $p->getPadresotutoresid())
                ));
            }
            return new View(array("solicitud" => $SolicitudEntity, "padres" => $padres), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para eliminar datos familiares
     * @Rest\Delete("/api/Solicitud/datosFamiliares/padres/", name="datosFamiliaresPadresRemove")
     */
    public function removePadresAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

            if (empty($SolicitudEntity)) {
                return new View("Error no se encontro ninguna solicitud " . $data['solicitudadmisionid'], Response::HTTP_NOT_FOUND);
            }
            

            $dbm->getConnection()->beginTransaction();
            $nacionalidades = $dbm->removeManyRepositorio('Nacionalidadporpadresotutores', 'padresotutoresid', $data['tutorid']);
            $tutor = $dbm->getRepositorioById('Padresotutores', 'padresotutoresid', $data['tutorid']);
            $dbm->removeRepositorio($tutor);
            $dbm->getConnection()->commit();

            $padresotutores = $dbm->getRepositoriosById('Padresotutores', 'solicitudadmisionid', $data['solicitudadmisionid']);
            $padres = array();
            foreach ($padresotutores as $p) {
                array_push($padres, array(
                    "padre" =>$p, "nacionalidad" => $dbm->getRepositoriosById('Nacionalidadporpadresotutores', 'padresotutoresid', $p->getPadresotutoresid())
                ));
            }
            return new View(array("mensaje" => 'Se ha eliminado un tutor correctamente', "padres" => $padres), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Fltros
     * @Rest\Get("/api/Solicitud/claveFamiliar/filtros/", name="SolicitudClaveFamiliarFilters")
     */
    public function claveFamiliarFiltrosAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $filters = array_filter($datos);
            $familiares = $dbm->getClavePersonasByFilter($filters);
            $return = array('clavefamiliar' => $familiares);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guardar comentario
     * @Rest\Post("/api/Solicitud/claveFamiliar/", name="saveClaveFamiliarbySolicitud")
     */
    public function addClaveFamiliarbySolicitudAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
            if (empty($Solicitud)) {
                return new View("Error no se encontro ninguna solicitud " . $data['solicitudadmisionid'], Response::HTTP_NOT_FOUND);
            }

            $Solicitud->setClavefamiliar($data['clave']);
            $dbm->saveRepositorio($Solicitud);

            return new View("Se ha guardado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
