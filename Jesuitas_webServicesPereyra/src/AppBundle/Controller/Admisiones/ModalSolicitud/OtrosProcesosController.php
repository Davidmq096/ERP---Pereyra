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
class OtrosProcesosController extends FOSRestController
{

    /**
     * valores iniciales para dinamica familiar
     * @Rest\Get("/api/Solicitud/otrosProceso/", name="OtrosProcesos")
     */
    public function OtrosProcesosAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);
            if (empty($Solicitud)) {
                $return = array("mensaje" => "Error no se encontro la solicitud admision " . $data['solicitudid']);
                return new View($return, Response::HTTP_PARTIAL_CONTENT);
            }

            $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $data['solicitudid']))->getCicloid();
            $Solicitudes = $dbm->getSolicitudesTodosCiclos($Solicitud->getDatoaspiranteid()->getCurp(), $ciclo->getCicloid());
            $return = array('solicitudes' => $Solicitudes);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
