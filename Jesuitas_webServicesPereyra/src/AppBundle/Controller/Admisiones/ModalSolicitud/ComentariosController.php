<?php

namespace AppBundle\Controller\Admisiones\ModalSolicitud;

use AppBundle\DB\DbmAdmisiones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class ComentariosController extends FOSRestController
{
    /**
     * Retorna el archivo word del archivo adjunto
     * @Rest\Get("/api/Solicitud/comentario/", name="solicitudComentario")
     */
    public function solicitudComentarioAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);
            if (empty($Solicitud)) {
                $return = array("mensaje" => "Error no se encontro la solicitud admision " . $data['solicitudid']);
                return new View($return, Response::HTTP_NOT_FOUND);
            }

            $Comentarios = $dbm->getRepositoriosById('Comentarioporsolicitud', 'solicitudadmisionid', $data['solicitudid']);
            $return = array('comentarios' => $Comentarios);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guardar comentario
     * @Rest\Post("/api/Solicitud/comentario/", name="saveSolicitudComentario")
     */
    public function saveSolicitudComentarioAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);
            if (empty($Solicitud)) {
                $return = array("mensaje" => "Error no se encontro ninguna solicitud con la clave " . $data['solicitudid']);
                return new View($return, Response::HTTP_NOT_FOUND);
            }

            $Comentario = new \AppBundle\Entity\Comentarioporsolicitud();
            $Comentario->setComentario($data['comentario']);
            $Comentario->setSolicitudadmisionid($Solicitud);
            $dbm->saveRepositorio($Comentario);

            return new View('Se ha guardado el registro', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para eliminar una personarecoje
     * @Rest\Delete("/api/Solicitud/comentario/{id}", name="DeleteSolicitudCOmentario")
     */
    public function deleteSolicitudComentarioAction($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $comentario = $dbm->getRepositorioById('Comentarioporsolicitud', 'comentarioporsolicitudid', $id);
            $dbm->removeRepositorio($comentario);
            return new View("Se ha eliminado un registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
