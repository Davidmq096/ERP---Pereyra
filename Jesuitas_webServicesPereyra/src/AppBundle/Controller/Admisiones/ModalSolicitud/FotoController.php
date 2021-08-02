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
class FotoController extends FOSRestController
{
    /**
     * Guarda la foto tomada
     * @Rest\Post("/api/Solicitud/GuardarFoto", name="SolicitudGuardarFoto")
     */
    public function solicitudGuardarFoto()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;

            $dbm->getConnection()->beginTransaction();

            $entidad = $dbm->getRepositorioById('Datoaspirante', 'datoaspiranteid', $data["id"]);
            if ($data["persona"] == 0) {
                $entidad->setFoto($data['foto']);
            }
            if ($data["persona"] == 1) {
                $entidad->setFotofamiliar($data['foto']);
            }
            $dbm->saveRepositorio($entidad);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado la foto", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
