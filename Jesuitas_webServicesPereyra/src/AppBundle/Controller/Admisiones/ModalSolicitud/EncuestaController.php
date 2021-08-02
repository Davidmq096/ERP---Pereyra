<?php

namespace AppBundle\Controller\Admisiones\ModalSolicitud;

use AppBundle\DB\DbmAdmisiones;
use AppBundle\Entity\Mediosporencuesta;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class EncuestaController extends FOSRestController
{
    /**
     * Reotorna valores iniciales de Encuesta
     * @Rest\Get("/api/Solicitud/encuesta/{id}", name="encuestaModal")
     */
    public function EncuestaAction($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);

            $solicitudMedios = $dbm->getRepositoriosById('Mediosporencuesta', 'encuestaid', $SolicitudEntity->getEncuestaid());
            $parentesco = $dbm->getRepositorios('Tutor');
            $medio = $dbm->getRepositoriosById('Medios', 'activo', 1);

            $return = array(
                'contacto' => $SolicitudEntity->getContactoid(),
                'encuesta' => $SolicitudEntity->getEncuestaid(),
                'parentesco' => $parentesco,
                "medio" => $medio,

                "solicitudMedios" => $solicitudMedios);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para guardar Encuesta
     * @Rest\Post("/api/Solicitud/encuesta/", name="encuestaSave")
     */
    public function saveEncuestasAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $dbm->getConnection()->beginTransaction();

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
            if (empty($SolicitudEntity)) {
                return new View("Error no se encontro ninguna solicitud " . $data['solicitudadmisionid'], Response::HTTP_NOT_FOUND);
            }

            if ($data['version'] == '1') {
                if ($SolicitudEntity->getPendiente() <= 4) {
                    $SolicitudEntity->setPendiente(5);
                }
            } else if ($data['version'] == '2') {
                if ($SolicitudEntity->getEstatussolicitudid()->getEstatussolicitudid() < 3) {
                    $SolicitudEntity->setEstatussolicitudid($dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', 2));
                }
                if ($SolicitudEntity->getPendiente() <= 5) {
                    $SolicitudEntity->setPendiente(6);
                }
            }
            $dbm->saveRepositorio($SolicitudEntity);

            $encuesta = $SolicitudEntity->getEncuestaid();
            //$encuesta->setNombre((empty($data['nombre'])) ? null : $data['nombre']);
            //$encuesta->setCorreo((empty($data['correo'])) ? null : $data['correo']);
            $encuesta->setParentesco((empty($data['parentesco'])) ? null : $data['parentesco']);
            $encuesta->setEleccion((empty($data['motivo'])) ? null : $data['motivo']);
            $encuesta->setSexo((empty($data['sexo'])) ? null : $data['sexo']);
            $encuesta->setEdad((empty($data['edad'])) ? null : $data['edad']);
            $encuesta->setColonia((empty($data['colonia'])) ? null : $data['colonia']);
            $encuesta->setOtromedio((empty($data['otromedio'])) ? null : $data['otromedio']);
            $dbm->saveRepositorio($encuesta);

            //eliminamos los medios seleccionados anteriormente
            $encuestaMedio = $dbm->removeManyRepositorio('Mediosporencuesta', 'encuestaid', $SolicitudEntity->getEncuestaid());
            if (!empty($data['medio1'])) {
                $encuestaPorMedio = new Mediosporencuesta();
                $encuestaPorMedio->setEncuestaid($SolicitudEntity->getEncuestaid());
                $encuestaPorMedio->setMediosid($dbm->getRepositorioById('Medios', 'mediosid', $data['medio1']));
                $dbm->saveRepositorio($encuestaPorMedio);
            }

            if (!empty($data['medio2'])) {
                $encuestaPorMedio = new \AppBundle\Entity\Mediosporencuesta();
                $encuestaPorMedio->setEncuestaid($SolicitudEntity->getEncuestaid());
                $Medio = $dbm->getRepositorioById('Medios', 'mediosid', $data['medio2']);
                $encuestaPorMedio->setMediosid($Medio);
                $dbm->saveRepositorio($encuestaPorMedio);
            }

            if (!empty($data['medio3'])) {
                $encuestaPorMedio = new \AppBundle\Entity\Mediosporencuesta();
                $encuestaPorMedio->setEncuestaid($SolicitudEntity->getEncuestaid());
                $Medio = $dbm->getRepositorioById('Medios', 'mediosid', $data['medio3']);
                $encuestaPorMedio->setMediosid($Medio);
                $dbm->saveRepositorio($encuestaPorMedio);
            }
            $dbm->getConnection()->commit();
            return new View(array("pendiente" => $SolicitudEntity->getPendiente(), "msj" => "Se a actualizado el registro"), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
