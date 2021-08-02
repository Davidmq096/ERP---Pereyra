<?php

namespace AppBundle\Controller\Becas\Modal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use AppBundle\Entity\BcBecas;
use AppBundle\Entity\BcBecasporsolicitud;
use AppBundle\Entity\BcRecibirdocumentos;
use AppBundle\Entity\BcSolicitudbecadictamen;
use AppBundle\Entity\Pais;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Icicle\Coroutine\Coroutine;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Auto: Judith
 */
class SolicitudController extends FOSRestController
{

    /**
     * obtener domicilio por solicitud
     * @Rest\Post("/api/SolicitudBeca/getdomicilio", name="SolicitudBecaDomicilioBuscar")
     */
    public function getSolicitudBecaDomicilio()
    {
        try {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $entidad = $dbm->getdomicilio($decoded);
            if (!$entidad) {
                $entidad2 = $dbm->getdomicilio2($decoded);
                return new View($entidad2, Response::HTTP_OK);
            } else {
                return new View($entidad, Response::HTTP_OK);
            }

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * obtiene el domicilio de acuerdo al alumnoid
     * @Rest\Post("/api/SolicitudBeca/getdomicilioalumno", name="SolicitudBecaDomicilioAlumnoBuscar")
     */
    public function getSolicitudBecaDomicilioAlumno()
    {
        try {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $entidad = $dbm->Buscardomicilioestudiosocioeconomicoalumno($decoded);

            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda la direccion para la solicitud
     * @Rest\Post("/api/SolicitudBeca/domicilio" , name="SolicitudBecaDomicilioGuardar")
     */
    public function saveSolicitudBecaDomicilio()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $entity = $hydrator->hydrate('AppBundle\Entity\BcDomicilioestudiosocioeconomico', $decoded);

            $dbm->getConnection()->beginTransaction();
            $id = $dbm->getRepositorioById('BcDomicilioestudiosocioeconomico', 'solicitudid', $decoded['solicitudid']);
            if (empty($id)) {
                $dbm->saveRepositorio($entity);
            } else {
                $domicilioid = $id->getDomicilioestudiosocioeconomicoid();
                $sol = $dbm->getRepositorioById('BcDomicilioestudiosocioeconomico', 'domicilioestudiosocioeconomicoid', $domicilioid);
                $sol->setCodigopostal($entity->getCodigopostal());
                $sol->setCalle($entity->getCalle());
                $sol->setNumeroexterior($entity->getNumeroexterior());
                $sol->setNumerointerior($entity->getNumerointerior());
                $sol->setOtracolonia($entity->getOtracolonia());
                $sol->setEntrecalles($entity->getEntrecalles());
                $sol->setTelefonocasa($entity->getTelefonocasa());
                $sol->setEstadoid($entity->getEstadoid());
                $sol->setMunicipioid($entity->getMunicipioid());
                $sol->setSolicitudid($entity->getSolicitudid());
                $sol->setColoniaid($entity->getColoniaid());
                $sol->setPaisid($entity->getPaisid());
                $dbm->saveRepositorio($sol);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado domicilio", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
