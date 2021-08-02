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
class DinamicaFamiliarController extends FOSRestController
{
        /**
     * valores iniciales para dinamica familiar
     * @Rest\Get("/api/Solicitud/dinamicaFamiliar/", name="DinamicaFamiliar")
     */
    public function dinamicaFamiliarAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        if (empty($Solicitud)) {
            $return = array("mensaje" => "Error no se encontro la solicitud" . $data['solicitudadmisionid']);
            return new View($return, Response::HTTP_NOT_FOUND);
        } else {
            $parentesco = $dbm->getRepositorios('Parentesco');
            $return = array('solicitud' => $Solicitud, 'parentesco' => $parentesco);
            return new View($return, Response::HTTP_OK);
        }
    }

    /**
     * Funcion para guardar una nueva solicitud
     * @Rest\Post("/api/Solicitud/dinamicaFamiliar/", name="DinamicaFamiliarSave")
     */
    public function saveDinamicaFamiliarAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (!empty($Solicitud)) {
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setNinguna((empty($data['ninguna'])) ? null : $data['ninguna']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setDivorcio((empty($data['divorcio'])) ? null : $data['divorcio']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setSeparacion((empty($data['separacion'])) ? null : $data['separacion']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setCustodia((empty($data['custodia'])) ? null : $data['custodia']);

            if (!empty($data['parentesco'])) {
                $Parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $data['parentesco']);
                $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setParentescoid($Parentesco);
            }

            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setEnfermedadgrave((empty($data['enfermedad'])) ? null : $data['enfermedad']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setMiembroenfermedadgrave((empty($data['miembro'])) ? null : $data['miembro']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setMuerteperdida((empty($data['muerte'])) ? null : $data['muerte']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setMiembromuerteperdidad((empty($data['quien'])) ? null : $data['quien']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setCambioresidencia((empty($data['residencia'])) ? null : $data['residencia']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setMedioshermano((empty($data['mediosH'])) ? null : $data['mediosH']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setSegundosmatrimonios((empty($data['segundosM'])) ? null : $data['segundosM']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setMadrepadresoltero((empty($data['madrePadre'])) ? null : $data['madrePadre']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setOtros((empty($data['otro'])) ? null : $data['otro']);
            $Solicitud->getDatoaspiranteid()->getDinamicafamiliarid()->setDescripcionotros((empty($data['deQuien'])) ? null : $data['deQuien']);

            if ($Solicitud->getPendiente() <= 7) {
                $Solicitud->setPendiente(8);
            }
            $dbm->saveRepositorio($Solicitud);

            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } else {
            return new View("Error", Response::HTTP_NOT_FOUND);
        }
    }

}
