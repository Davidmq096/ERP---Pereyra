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
class DocumentacionController extends FOSRestController
{
    /**
     * Se obtienen la relacion de la solicitud y los documentos.
     * Se obtiene la informacion de si la familia va a realizar otras solicitudes
     * @Rest\Get("/api/Solicitud/documentacion/validacion/", name="documentacionValidacion")
     */
    public function documentacionValidacionAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $documentacion = $dbm->getRepositoriosById('Documentoporsolicitudadmision', 'solicitudadmision', $data['solicitudId']);
            $gradosConsiderado = $dbm->getRepositoriosById('Solicitudgradoconsiderado', 'solicitudadmisionid', $data['solicitudId']);

            $return = array("documentacion" => $documentacion, 'gradoconsiderado' => $gradosConsiderado);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para guardar el recibimiento de un documento en la validacion
     * @Rest\Put("/api/Solicitud/documentacion/validacion/", name="documentacionValidacionEdit")
     */
    public function saveDocumentacionValidacionAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudId']);

            if (empty($SolicitudEntity)) {
                $return = array("mensaje" => "Error no se encontro ninguna solicitud con el Id " . $data['solicitudId']);
                return new View("No se ha encontrado la entidad", Response::HTTP_PARTIAL_CONTENT);
            }
            $documentacion = $dbm->getRepositorioById('Documentoporsolicitudadmision', 'documentoporsolicitudadmisionid', $data['documentoId']);
            $documentacion->setValidado($data['validacion']);
            $dbm->saveRepositorio($documentacion);
            $documentacion = $dbm->getRepositoriosById("Documentoporsolicitudadmision", "solicitudadmision", $SolicitudEntity->getSolicitudadmisionid());
            $return = array("documentacion" => $documentacion);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para guardar si una familia va a realizar mas solicitudes
     * @Rest\Post("/api/Solicitud/documentacion/", name="documentacionSave")
     */
    public function saveDocumentacionAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
            if (empty($SolicitudEntity)) {
                $return = array("mensaje" => "Error no se encontro ninguna solicitud con el id " . $data['solicitudadmisionid']);
                return new View($return, Response::HTTP_NOT_FOUND);
            }

            $dbm->getConnection()->beginTransaction();
            //Entra si la peticion se realizo desde el portal de admision
            if ($data['version']) {
                //Lux
                if ($data['version'] == '1') {
                    if ($SolicitudEntity->getPendiente() == 5) {
                        $SolicitudEntity->setPendiente(6);
                        if ($SolicitudEntity->getEstatussolicitudid()->getEstatussolicitudid() < 3) {
                            $SolicitudEntity->setEstatussolicitudid($dbm->getRepositorioById("Estatussolicitud", "estatussolicitudid", 2));
                        }
                    }
                }
                //Ciencias
                if ($data['version'] == '2') {
                    if ($SolicitudEntity->getPendiente() == 6) {
                        $SolicitudEntity->setPendiente(7);
                    }
                    //Cambiamos el estatus de la solicitud ya que es la ultmia pestaña para el ciencias
                    if ($SolicitudEntity->getEstatussolicitudid()->getEstatussolicitudid() < 3) {
                        $SolicitudEntity->setEstatussolicitudid($dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', 2));
                    }
                }
                $dbm->saveRepositorio($SolicitudEntity);
            }

            $dbm->removeManyRepositorio('Solicitudgradoconsiderado', 'solicitudadmisionid', $data['solicitudadmisionid']);
            if ($data['preescolar']['activo'] == "true") {
                $AspiranteSimultaneo = new \AppBundle\Entity\Solicitudgradoconsiderado();
                $NivelEntity = $dbm->getRepositorioById('Nivel', 'nivelid', 1);
                $AspiranteSimultaneo->setNivelid($NivelEntity);
                $AspiranteSimultaneo->setNumero($data['preescolar']['cuantos']);
                $AspiranteSimultaneo->setSolicitudadmisionid($SolicitudEntity);
                $dbm->saveRepositorio($AspiranteSimultaneo);
            }
            if ($data['primaria']['activo'] == "true") {
                $AspiranteSimultaneo2 = new \AppBundle\Entity\Solicitudgradoconsiderado();
                $NivelEntity = $dbm->getRepositorioById('Nivel', 'nivelid', 2);
                $AspiranteSimultaneo2->setNivelid($NivelEntity);
                $AspiranteSimultaneo2->setNumero($data['primaria']['cuantos']);
                $AspiranteSimultaneo2->setSolicitudadmisionid($SolicitudEntity);
                $dbm->saveRepositorio($AspiranteSimultaneo2);
            }
            if ($data['secundaria']['activo'] == "true") {
                $AspiranteSimultaneo3 = new \AppBundle\Entity\Solicitudgradoconsiderado();
                $NivelEntity = $dbm->getRepositorioById('Nivel', 'nivelid', 3);
                $AspiranteSimultaneo3->setNivelid($NivelEntity);
                $AspiranteSimultaneo3->setNumero($data['secundaria']['cuantos']);
                $AspiranteSimultaneo3->setSolicitudadmisionid($SolicitudEntity);
                $dbm->saveRepositorio($AspiranteSimultaneo3);
            }
            if ($data['bachillerato']['activo'] == "true") {
                $AspiranteSimultaneo4 = new \AppBundle\Entity\Solicitudgradoconsiderado();
                $NivelEntity = $dbm->getRepositorioById('Nivel', 'nivelid', 4);
                $AspiranteSimultaneo4->setNivelid($NivelEntity);
                $AspiranteSimultaneo4->setNumero($data['bachillerato']['cuantos']);
                $AspiranteSimultaneo4->setSolicitudadmisionid($SolicitudEntity);
                $dbm->saveRepositorio($AspiranteSimultaneo4);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
