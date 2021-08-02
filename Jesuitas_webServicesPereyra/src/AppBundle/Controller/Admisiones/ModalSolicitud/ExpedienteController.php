<?php

namespace AppBundle\Controller\Admisiones\ModalSolicitud;

use AppBundle\DB\DbmAdmisiones;
use AppBundle\Entity\Escuelaprocedencia;
use AppBundle\Entity\Gradorepetido;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class ExpedienteController extends FOSRestController
{
    /**
     * Reotorna valores iniciales de datos de aspirante
     * @Rest\Get("/api/Solicitud/expediente/{id}", name="expedienteModal")
     */
    public function expedienteAction($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);
            if (empty($SolicitudEntity)) {
                $return = array("mensaje" => "Error no se encontro ninguna solicitud  " . $id);
                return new View($return, Response::HTTP_NOT_FOUND);
            }
            $escuelaJesuitas = $dbm->getRepositorios('Escuelajesuita');
            $inforadicional = $SolicitudEntity->getInfoadicionalid();
            $escuelaprocedencia = $dbm->getRepositorioById('Escuelaprocedencia', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());
            $gradosrepetidos = $dbm->getRepositoriosById('Gradorepetido', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());

            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);

            $return = array("infoadicional" => $inforadicional,
                "escuelajesuitas" => $escuelaJesuitas,
                "escuelaprocedencia" => $escuelaprocedencia,
                "gradosrepetidos" => $gradosrepetidos,
                "nivel" => $nivel,
                "grado" => $grado);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para guardar datos del expediente del aspirante
     * @Rest\Post("/api/Solicitud/expediente/", name="expedienteModalSave")
     */
    public function saveExpedienteAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $dbm->getConnection()->beginTransaction();

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
            if (empty($SolicitudEntity)) {
                $return = array("mensaje" => "Error no se encontro ninguna solicitud " . $data['solicitudadmisionid']);
                return new View($return, Response::HTTP_NOT_FOUND);
            }

            $Info = $SolicitudEntity->getInfoadicionalid();
            $Info->setEstadosalud($data['estadosalud']);
            $Info->setNecesidadespecial($data['necesidadespecial']);
            $Info->setDescripcionnecesidad($data['necesidadespecialtexto']);
            $Info->setAlumnoinstituto($data['exalumno']);
            $Info->setHijopersonal($data['hijopersonal']);
            $dbm->saveRepositorio($Info);

            $EscuelaProcedencia = $dbm->getRepositorioById('Escuelaprocedencia', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());
            $EscuelaProcedencia = $EscuelaProcedencia ? $EscuelaProcedencia : new Escuelaprocedencia();
            $EscuelaProcedencia->setDatoaspiranteid($SolicitudEntity->getDatoaspiranteid());
            $EscuelaProcedencia->setNombre($data['nombreescuela']);
            $EscuelaProcedencia->setMunicipio($data['ciudadescuela']);
            $EscuelaProcedencia->setCausaseparacion($data['motivocambio']);
            $EscuelaProcedencia->setEscuelajesuitaid($dbm->getRepositorioById('Escuelajesuita', 'escuelajesuitaid', $data['escuelajesuitaid']));
            $dbm->saveRepositorio($EscuelaProcedencia);

            $dbm->getConnection()->commit();
            
            return new View("Se a actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para guardar los grados repetidos del aspirante
     * @Rest\Post("/api/Solicitud/expediente/gradorepetido", name="expedienteModalgradorepetidoSave")
     */
    public function saveGradoAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
            if (empty($SolicitudEntity)) {
                $return = array("mensaje" => "Error no se encontro ninguna solicitud " . $data['solicitudadmisionid']);
                return new View($return, Response::HTTP_NOT_FOUND);
            }

            $gradorepetido = $data['gradorepetidoid'] ? $dbm->getRepositorioById('Gradorepetido', 'gradorepetidoid', $data['gradorepetidoid']) : new Gradorepetido();
            $gradorepetido->setDatoaspiranteid($SolicitudEntity->getDatoaspiranteid());
            $gradorepetido->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']));
            $gradorepetido->setCausa($data['causa']);
            $dbm->saveRepositorio($gradorepetido);

            $gradosrepetidos = $dbm->getRepositoriosById("Gradorepetido", "datoaspiranteid", $SolicitudEntity->getDatoaspiranteid()->getDatoaspiranteid());
            return new View(array("gradosrepetidos" => $gradosrepetidos), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para eliminar grados repetidos del expediente
     * @Rest\Delete("/api/Solicitud/expediente/gradorepetido/{id}", name="expedienteModalGradosRemove")
     */
    public function removeGradorepetido($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            //Se agregar relacion con nivel
            $grado = $dbm->getRepositorioById('Gradorepetido', 'gradorepetidoid', $id);
            $datoaspirante = $grado->getDatoaspiranteid();
            $dbm->removeRepositorio($grado);

            $gradosrepetidos = $dbm->getRepositoriosById("Gradorepetido", "datoaspiranteid", $datoaspirante->getDatoaspiranteid());
            return new View(array("mensaje" => "Se ha eliminado el registro.", "gradosrepetidos" => $gradosrepetidos), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
