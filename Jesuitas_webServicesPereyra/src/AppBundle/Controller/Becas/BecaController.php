<?php

namespace AppBundle\Controller\Becas;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Judith
 */
class BecaController extends FOSRestController
{

    /**
     * Retorna filtros becas
     * @Rest\Get("/api/ConsultaBecas", name="ConsultaBecasIndex")
     */
    public function Index()
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());

            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('BcEstatus', 'activo', 1);
            $tipoBeca = $dbm->getRepositoriosById('BcTipobeca', 'activo', 1);
            $porcentajeBeca = $dbm->getRepositoriosById('BcPorcentajebecapornivel', 'activo', 1);

            $return = array(
                "ciclo" => $ciclo, 'nivel' => $nivel,
                "grado" => $grado, "estatus" => $estatus,
                'tipoBeca' => $tipoBeca, "porcentajeBeca" => $porcentajeBeca
            );
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna filtros becas
     * @Rest\Post("/api/ConsultaBecas/Filtrar", name="becasfiltro")
     */
    public function becasfiltro()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarBecas($decoded);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/ConsultaBecas/Beca" , name="Guardarbecas")
     */
    public function Guardarbecas()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());

            $ciclo = $dbm->getRepositorioById("Ciclo", "cicloid", $decoded["cicloid"]);
            if (!$ciclo->getActual() && !$ciclo->getSiguiente()) {
                return new View("No se permite asignar becas en ciclos que no sean el actual o siguiente", Response::HTTP_PARTIAL_CONTENT);
            }

            $beca = $dbm->getOneByParametersRepositorio(
                'BcBecas',
                array('alumnoid' => $decoded['alumnoid'], 'tipobecaid' => $decoded['tipobecaid'], 'cicloid' => $decoded['cicloid'])
            );
            if ($beca) {
                return new View("Ya existe una beca asignada con el mismo tipo de beca en el mismo ciclo.", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $decoded["gradoidorigen"] = $decoded["gradoid"];
            if ($ciclo->getSiguiente()) {
                switch ($decoded["gradoid"]) {
                    case 13:
                    case 15:
                        $decoded["gradoid"] = $decoded["gradoid"] + 2;
                        break;
                    case 19:
                        $decoded["gradoid"] = 1;
                        break;
                    default:
                        $decoded["gradoid"] = $decoded["gradoid"] + 1;
                };
            }
            $entity = $hydrator->hydrate('AppBundle\Entity\BcBecas', $decoded);

            $dbm->getConnection()->beginTransaction();

            $dbm->saveRepositorio($entity);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/ConsultaBecas/Cancelar" , name="cancelarbeca")
     */
    public function Cancelarbeca()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $sistema = ENTORNO;
            $dbm->getConnection()->beginTransaction();
            foreach ($decoded['listabecas'] as $b) {
                $beca = $dbm->getRepositorioById('BcBecas', 'becaid', $b);
                $beca->setEstatusid($dbm->getRepositorioById('BcEstatus', 'estatusid', 4));
                if ($sistema == 2) {
                    $beca->setPorcentajebecaid($dbm->getRepositorioById('BcPorcentajebeca', 'descripcion', '0'));
                    $solicitud = $dbm->getRepositorioById('BcBecasporsolicitud', 'becaid', $b);
                    if ($solicitud) {
                        $solicitudalumno = $dbm->getOneByParametersRepositorio(
                            'BcSolicitudporalumno',
                            [
                                'alumnoid' => $beca->getAlumnoid(),
                                'solicitudid' => $solicitud->getSolicitudid() ? $solicitud->getSolicitudid()->getSolicitudid() : null
                            ]
                        );
                        if ($solicitudalumno) {
                            $solicitudalumno->setEstatusid($dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', 7));
                            $dbm->saveRepositorio($solicitudalumno);
                        }

                        $solicitudprovisional = $dbm->getOneByParametersRepositorio(
                            'BcProvisionalbecas',
                            [
                                'alumnoid' => $beca->getAlumnoid(),
                                'solicitudid' => $solicitud->getSolicitudid() ? $solicitud->getSolicitudid()->getSolicitudid() : null
                            ]
                        );
                        if ($solicitudprovisional) {
                            $solicitudprovisional->setPorcentajebecaid($dbm->getRepositorioById('BcPorcentajebeca', 'descripcion', '0'));
                            $solicitudprovisional->setEstatusid($dbm->getRepositorioById('BcEstatus', 'estatusid', 4));
                            $dbm->saveRepositorio($solicitudprovisional);
                        }
                    }
                }
                $dbm->saveRepositorio($beca);
            }
            $dbm->getConnection()->commit();
            return new View("Cancelacion realizada", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/ConsultaBecas/Beca/{id}" , name="ActualizarBecas")
     */
    public function ActualizarBecas($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $sistema = ENTORNO;
            $beca = $dbm->getRepositorioById('BcBecas', 'becaid', $id);
            if ($decoded['estatusid'] == 3) {
                $tienebeca = $dbm->getOneByParametersRepositorio(
                    'BcBecas',
                    array(
                        'alumnoid' => $beca->getAlumnoid() ? $beca->getAlumnoid()->getAlumnoid() : null,
                        'tipobecaid' => $decoded['tipobecaid'],
                        'cicloid' => $decoded['cicloid']
                    )
                );
                if ($tienebeca) {
                    if ($tienebeca->getBecaid() != $id) {
                        return new View("Ya existe una beca asignada con el mismo tipo de beca en el mismo ciclo.", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }
            $beca->setPorcentajebecaid($dbm->getRepositorioById('BcPorcentajebeca', 'porcentajebecaid', $decoded["porcentajebecaid"]));
            if ($sistema == 2) {
                $beca->setTipobecaid($dbm->getRepositorioById('BcTipobeca', 'tipobecaid', $decoded["tipobecaid"]));
                $solicitud = $dbm->getRepositorioById('BcBecasporsolicitud', 'becaid', $id);
                if ($decoded['estatusid'] == 4 || $decoded['estatusid'] == 2) {
                    $beca->setPorcentajebecaid($dbm->getRepositorioById('BcPorcentajebeca', 'descripcion', '0'));
                    if ($solicitud) {
                        $solicitudalumno = $dbm->getOneByParametersRepositorio(
                            'BcSolicitudporalumno',
                            [
                                'alumnoid' => $beca->getAlumnoid()->getAlumnoid(),
                                'solicitudid' => $solicitud->getSolicitudid() ? $solicitud->getSolicitudid()->getSolicitudid() : null
                            ]
                        );
                        if ($solicitudalumno) {
                            if ($decoded['estatusid'] == 2) {
                                $solicitudalumno->setEstatusid($dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', 5));
                            } else if ($decoded['estatusid'] == 4) {
                                $solicitudalumno->setEstatusid($dbm->getRepositorioById('BcEstatussolicitudbeca', 'estatusid', 7));
                            }
                            $dbm->saveRepositorio($solicitudalumno);
                        }

                        $solicitudprovisional = $dbm->getOneByParametersRepositorio(
                            'BcProvisionalbecas',
                            [
                                'alumnoid' => $beca->getAlumnoid()->getAlumnoid(),
                                'solicitudid' => $solicitud->getSolicitudid() ? $solicitud->getSolicitudid()->getSolicitudid() : null
                            ]
                        );
                        if ($solicitudprovisional) {
                            $solicitudprovisional->setPorcentajebecaid($dbm->getRepositorioById('BcPorcentajebeca', 'descripcion', '0'));
                            $solicitudprovisional->setEstatusid($dbm->getRepositorioById('BcEstatus', 'estatusid', $decoded['estatusid']));
                            $dbm->saveRepositorio($solicitudprovisional);
                        }
                    }
                }
            }

            $beca->setEstatusid($dbm->getRepositorioById('BcEstatus', 'estatusid', $decoded["estatusid"]));
            $dbm->saveRepositorio($beca);

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $reconsideracion = $hydrator->hydrate('AppBundle\Entity\BcReconsideracionbeca', $decoded);
            $dbm->saveRepositorio($reconsideracion);

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
