<?php

namespace AppBundle\Controller\Becas\Modal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use AppBundle\Entity\BcBecas;
use AppBundle\Entity\BcBecasporsolicitud;
use AppBundle\Entity\BcSolicitudbecadictamen;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Mariano
 */
class DictaminarController extends FOSRestController
{
    /**
     * guarda si se han entregado documentos
     * @Rest\Post("/api/SolicitudBeca/becaprovisional", name="newbecas")
     */
    public function newbecas()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $sbeca = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $decoded['solicitudid']);
            if ($sbeca) {
                $decoded['cicloid'] = $sbeca->getCicloid()->getCicloid();
            } else {
                return new View("No se ha encontrado una solicitud ", Response::HTTP_PARTIAL_CONTENT);
            }
            $tienebeca = $dbm->getOneByParametersRepositorio("BcProvisionalbecas", [
                "cicloid" => $decoded['cicloid'],
                "alumnoid" => $decoded['alumnoid'],
                "tipobecaid" => $decoded['tipobecaid'],
            ]);
            if ($tienebeca) {
                return new View("Ya se ha asignado el mismo tipo de beca en el mismo ciclo al alumno ", Response::HTTP_PARTIAL_CONTENT);
            }

            $solicitudporalumno = $dbm->getOneByParametersRepositorio("BcSolicitudporalumno", [
                "solicitudid" => $decoded['solicitudid'],
                "alumnoid" => $decoded['alumnoid']
            ]);

            $entity = $hydrator->hydrate('AppBundle\Entity\BcProvisionalbecas', $decoded);
            $entity->setGradoid($solicitudporalumno->getGradoiddestino());
            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($entity);
            $dbm->getConnection()->commit();

            return new View("Se ha guardado beca provisional", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * regresa beca provisional
     * @Rest\Get("/api/SolicitudBeca/edicionbecapro/{provicionalid}", name="edicionbecap")
     */
    public function edicionbecap($provicionalid)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $entidad = $dbm->BuscarBecaprovicional($provicionalid);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/SolicitudBeca/Actualizarbecaprovisional/{idbecaprovisional}" , name="Actualizarbecaprovisional")
     */
    public function Actualizarbecaprovisional($idbecaprovisional)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $ciclo;
            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $entity = $hydrator->hydrate('AppBundle\Entity\BcProvisionalbecas', $decoded);
            $sbeca = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $decoded['solicitudid']);
            if ($sbeca) {
                $ciclo = $sbeca->getCicloid();
            } else {
                return new View("No se ha encontrado una solicitud ", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            $pbecas = $dbm->getRepositorioById('BcProvisionalbecas', 'provisionalbecaid', $idbecaprovisional);
            $pbecas->setAlumnoid($entity->getAlumnoid(alumnoid));
            $pbecas->setNivelid($entity->getNivelid(nivelid));
            $pbecas->setTipobecaid($entity->getTipobecaid(tipobecaid));
            $pbecas->setPorcentajebecaid($entity->getPorcentajebecaid(porcentajebecaid));
            $pbecas->setGradoid($entity->getGradoid(gradoid));
            $pbecas->setCicloid($ciclo);
            $pbecas->setEstatusid($entity->getEstatusid(estatusid));
            $pbecas->setSolicitudid($entity->getSolicitudid(solicitudid));

            $dbm->saveRepositorio($pbecas);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/SolicitudBeca/actualizarEstatus/" , name="actualizarEstatusBeca")
     */
    public function actualizarEstatusBeca()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");

            if (count($decoded['becas']) == 0) {
                $alumnosolicitud = $dbm->getRepositorioById('BcSolicitudporalumno', 'alumnosolicitudid', $decoded['alumnosolicitudid']);
                if (!$alumnosolicitud) {
                    return new View("No se ha encontrado una solicitud del alumno ", Response::HTTP_PARTIAL_CONTENT);
                }

                $alumnosolicitud->setEstatusid($dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', $decoded['estatusbeca']));
                $dbm->saveRepositorio($alumnosolicitud);
            }

            foreach ($decoded['becas'] as $provisionales) {

                $solbecaporprovisional = $dbm->getRepositorioById('BcBecasporsolicitud', 'provisionalbecaid', $provisionales['b_provisionalbecaid']);
                if ($solbecaporprovisional) {
                    $beca = $solbecaporprovisional->getBecaid();
                    $solicitudalumno = $dbm->getOneByParametersRepositorio("BcSolicitudporalumno", [
                        "solicitudid" => $solbecaporprovisional->getSolicitudid()->getSolicitudid(),
                        "alumnoid" => $beca->getAlumnoid()->getAlumnoid()
                    ]);

                    $dictamen = $dbm->getOneByParametersRepositorio(
                        'BcSolicitudbecadictamen',
                        array(
                            "alumnoid" => $beca->getAlumnoid()->getAlumnoid(),
                            "tipobecaid" => $provisionales['tipobecaid'],
                            "solicitudid" => $solbecaporprovisional->getSolicitudid()->getSolicitudid(),
                        )
                    );

                    switch ((int) $decoded['estatusbeca']) {
                        case 5:
                            $estatusbeca = 2;
                            break;
                        case 6:
                            $estatusbeca = 3;
                            break;
                        case 7:
                            $estatusbeca = 4;
                            break;
                    }

                    if ($estatusbeca) {
                        $provisional = $solbecaporprovisional->getProvisionalbecaid();
                        $provisional->setEstatusid($dbm->getRepositorioById('BcEstatus', 'estatusid', $estatusbeca));
                        $beca->setEstatusid($dbm->getRepositorioById('BcEstatus', 'estatusid', $estatusbeca));
                        $dictamen->setEstatusid($dbm->getRepositorioById('BcEstatus', 'estatusid', $estatusbeca));
                    }
                    $solicitudalumno->setEstatusid($dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', $decoded['estatusbeca']));

                    $dbm->saveRepositorio($beca);
                    $dbm->saveRepositorio($solicitudalumno);
                    $dbm->saveRepositorio($dictamen);
                    $dbm->saveRepositorio($provisional);
                } else {
                    $alumnosolicitud = $dbm->getRepositorioById('BcSolicitudporalumno', 'alumnosolicitudid', $decoded['alumnosolicitudid']);
                    $alumnosolicitud->setEstatusid($dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', $decoded['estatusbeca']));
                    switch ((int) $decoded['estatusbeca']) {
                        case 5:
                            $estatusbeca = 2;
                            break;
                        case 6:
                            $estatusbeca = 3;
                            break;
                        case 7:
                            $estatusbeca = 4;
                            break;
                    }
                    $provisionalbeca = $dbm->getRepositorioById('BcProvisionalbecas', 'provisionalbecaid', $provisionales['b_provisionalbecaid']);
                    if ($provisionalbeca) {
                        $provisionalbeca->setEstatusid($dbm->getRepositorioById('BcEstatus', 'estatusid', $estatusbeca));
                        $dbm->saveRepositorio($provisionalbeca);
                    } else {
                        return new View("No se ha configurado una solicitud provisional ", Response::HTTP_OK);
                    }
                }
            }

            return new View("Se ha actualizado el estatus ", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Rest\Delete("/api/SolicitudBeca/eliminarbeca/{id}" , name="deletebeca")
     */
    public function deletebeca($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $encoded = json_encode($data);
            $decoded = json_decode($encoded, true);
            $dbm = $this->get("db_manager");
            $object = new DbmBecas($dbm->getEntityManager());

            $provisional = $dbm->getRepositorioById('BcProvisionalbecas', 'provisionalbecaid', $id);
            if ($provisional) {
                $dbm->removeRepositorio($provisional);
            }

            return new View("Se ha eliminado la beca ", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * guarda si se han entregado documentos
     * @Rest\Post("/api/SolicitudBeca/dictaminar", name="dictaminarsolicitud")
     */
    public function dictaminarsolicitud()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");

            $dbm->getConnection()->beginTransaction();
            foreach ($decoded['ids'] as $valor) {

                $bp = $dbm->getRepositorioById('BcProvisionalbecas', 'provisionalbecaid', $valor);
                $solicitudalumno = $dbm->getOneByParametersRepositorio('BcSolicitudporalumno', array("solicitudid" => $decoded['solicitudid'], "alumnoid" => $bp->getAlumnoid()));

                if (!isset($bp) || !$solicitudalumno) {
                    throw new \Exception("ID No encontrado");
                } else {
                    $dictamen = $dbm->getOneByParametersRepositorio(
                        'BcSolicitudbecadictamen',
                        array(
                            "alumnoid" => $bp->getAlumnoid()->getAlumnoid(),
                            "tipobecaid" => $bp->getTipobecaid()->getTipobecaid(),
                            "solicitudid" => $decoded['solicitudid'],
                        )
                    );
                    if (empty($dictamen)) {
                        $dictamen = new BcSolicitudbecadictamen();
                    }

                    $dictamen->setAlumnoid($bp->getAlumnoid());
                    $dictamen->setEstatusid($bp->getEstatusid());
                    $dictamen->setTipobecaid($bp->getTipobecaid());
                    $dictamen->setPorcentajebecaid($bp->getPorcentajebecaid());
                    $dictamen->setSolicitudid($bp->getSolicitudid());
                    $dictamen->setObservaciones($decoded['observacion']);
                    $dbm->saveRepositorio($dictamen);

                    $becabusqueda = $dbm->getOneByParametersRepositorio('BcBecas',
                        array(
                            "alumnoid" => $bp->getAlumnoid(),
                            "tipobecaid" => $bp->getTipobecaid(),
                            "cicloid" => $bp->getCicloid(),
                            "gradoid" => $bp->getGradoid(),
                        )
                    );
                    $beca = $becabusqueda ? $becabusqueda : new BcBecas();
                    $beca->setAlumnoid($bp->getAlumnoid());
                    $beca->setTipobecaid($bp->getTipobecaid());
                    $beca->setPorcentajebecaid($bp->getPorcentajebecaid());
                    $beca->setGradoidOrigen($solicitudalumno->getGradoidOrigen());
                    $beca->setGradoid($solicitudalumno->getGradoidDestino());
                    $beca->setCicloid($bp->getCicloid());
                    $beca->setEstatusid($bp->getEstatusid());
                    $dbm->saveRepositorio($beca);

                    switch ((int) $bp->getEstatusid()->getEstatusid()) {
                        case 2:
                            $estatusbeca = 5;
                            break;
                        case 3:
                            $estatusbeca = 6;
                            break;
                        case 4:
                            $estatusbeca = 7;
                            break;
                        default:
                            $estatusbeca = 6;
                            break;
                    }

                    $estatusaprobado = $dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', $estatusbeca); //EL 5 ES RECHAZADA
                    $solicitudalumno->setEstatusid($estatusaprobado);
                    $dbm->saveRepositorio($solicitudalumno);

                    if (empty($becabusqueda)) {
                        //GUARDAR EN LA TABLA RELACION BECAPORSOLCIITUD
                        $becaporsolicitud = new BcBecasporsolicitud();
                        $becaporsolicitud->setBecaid($beca);
                        $becaporsolicitud->setProvisionalbecaid($bp);
                        $becaporsolicitud->setSolicitudid($solicitudalumno->getSolicitudid());
                        $dbm->saveRepositorio($becaporsolicitud);
                    }
                }
            }

            if (!empty($decoded['solicitudid'])) {
                $estatusdenegada = $dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', 5); //EL 5 ES RECHAZADA
                $solicitudes = $dbm->getRepositoriosById('BcSolicitudporalumno', 'solicitudid', $decoded['solicitudid']);

                if (empty($estatusdenegada) || empty($solicitudes)) {
                    throw new \Exception("No se pueden rechazar las solicitudes");
                } else {
                    foreach ($solicitudes as $solicitud) {
                        $estatussolicitud = $solicitud->getEstatusid()->getEstatusid();
                        if ($estatussolicitud != 6 && $estatussolicitud != 7) {
                            $solicitud->setEstatusid($estatusdenegada);
                            $dbm->saveRepositorio($solicitud);
                        }
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado beca provisional", Response::HTTP_OK);
        } catch (\Exception $e) {
            $dbm->getConnection()->rollBack();
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * consultar nuevas becas por alumno en dictamen
     * @Rest\Post("/api/SolicitudBeca/nuevasbecas", name="bnuevas")
     */
    public function bnuevas()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $entidad = $dbm->Buscarnuevasbecas($decoded);

            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
