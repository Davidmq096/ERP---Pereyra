<?php

namespace AppBundle\Controller\Becas;

use AppBundle\DB\DbmBecas;
use AppBundle\Entity\BcPorcentajebeca;
use AppBundle\Entity\BcPorcentajebecapornivel;
use AppBundle\Entity\BcTipobecapornivel;
use AppBundle\Entity\Nivel;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: rubén
 */
class TipoBecasController extends FOSRestController
{

    /**
     * Retorna arreglo de tipo de becas filtradas
     * @Rest\Get("/api/Becas/TiposBecas/Filtrar", name="tipobecasfiltro")
     */
    public function tipobecasfiltro()
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;

            $entidad = $dbm->BuscarTiposBecas($decoded);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna detalle de un tipo de beca
     * @Rest\Get("/api/Becas/TipoBeca/{id}", name="BuscarTiposBecasNiveles")
     */
    public function BuscarTiposBecasNiveles($id)
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());

            $entidad = $dbm->BuscarPorcentajesPorNivel($id);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);

            return new View(array("tablaniveles" => $entidad, "nivel" => $nivel), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Becas por Nivel
     * @Rest\Post("/api/Becas/TipoBeca", name="GuardarTipoBecasNiveles")
     */
    public function GuardarTipoBecasNiveles()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());

            $tipobeca = $dbm->getRepositorioById('BcTipobeca', 'tipobecaid', $decoded['tipobecaid']);
            if (empty($tipobeca)) {
                return new View("No se encontró el tipo de beca", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            $nivel = $dbm->getRepositorioById('Nivel', 'nivelid', $decoded['nivelid']);
            $tipobeca = $dbm->getRepositorioById('bcTipoBeca', 'tipobecaid', $decoded['tipobecaid']);

            $existe = $dbm->getByParametersRepositorios('BcTipobecapornivel', array("tipobecaid" => $decoded['tipobecaid'], "nivelid" => $decoded['nivelid']));

            if (empty($existe)) {
                if (!isset($decoded['afectainscripcion'])) {
                    $decoded['afectainscripcion'] = 0;
                }

                if (!isset($decoded['activo'])) {
                    $decoded['activo'] = 1;
                }
                $tipobecanivel = new BcTipobecapornivel();
                $tipobecanivel->setNivelid($nivel);
                $tipobecanivel->setTipobecaid($tipobeca);
                $tipobecanivel->setActivo(1);
                $tipobecanivel->setAfectainscripcion($decoded['afectainscripcion']);
                $dbm->saveRepositorio($tipobecanivel);
            } else {
                $porcentajenivel = $dbm->getOneByParametersRepositorio("BcTipobecapornivel",
                    array(
                        "tipobecaid" => $decoded['tipobecaid'],
                        "nivelid" => $decoded['nivelid'],
                    ));
                $porcentajenivel->setAfectainscripcion($decoded['afectainscripcion']);
                $dbm->saveRepositorio($porcentajenivel);
            }

            $porcentaje = $dbm->getRepositorioById('BcPorcentajebeca', 'descripcion', $decoded['porcentaje']);

            if (empty($porcentaje)) {
                $porcentaje = new BcPorcentajebeca();
                $porcentaje->setDescripcion($decoded['porcentaje']);
                $porcentaje->setActivo(1);
                $dbm->saveRepositorio($porcentaje);

                $porcentajenivel = new BcPorcentajebecapornivel();
                $porcentajenivel->setNivelid($nivel);
                $porcentajenivel->setPorcentajebecaid($porcentaje);
                $porcentajenivel->setActivo(1);
                $porcentajenivel->setTipobecaid($tipobeca);
                $dbm->saveRepositorio($porcentajenivel);

            } else {
                $existe = $dbm->getByParametersRepositorios('BcPorcentajebecapornivel',
                    array(
                        "porcentajebecaid" => $porcentaje->getPorcentajebecaid(),
                        "nivelid" => $nivel->getNivelid(),
                        "tipobecaid" => $decoded['tipobecaid'],
                    ));
                if (empty($existe)) {
                    $porcentajenivel = new BcPorcentajebecapornivel();
                    $porcentajenivel->setNivelid($nivel);
                    $porcentajenivel->setPorcentajebecaid($porcentaje);
                    $porcentajenivel->setActivo(1);
                    $porcentajenivel->setTipobecaid($tipobeca);
                    $dbm->saveRepositorio($porcentajenivel);
                } else {
                    return new View("Ya existe un registro con ese mismo nivel y procentaje de beca", Response::HTTP_PARTIAL_CONTENT);
                }
            }

            $dbm->getConnection()->commit();

            return new View("Guardados de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Delete("/api/Becas/Niveles/{porcentajebecaid}/{nivelid}/{tipobecaid}" , name="EliminarTipoBecasNiveles")
     */
    public function EliminarTipoBecasNiveles($porcentajebecaid, $nivelid, $tipobecaid)
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());

            $parametros = array(
                "porcentajebecaid" => $porcentajebecaid,
                "nivelid" => $nivelid,
                "tipobecaid" => $tipobecaid,
            );

            if (empty($parametros['porcentajebecaid']) || empty($parametros['nivelid']) || empty($parametros['tipobecaid'])) {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            } else {
                $dbm->EliminarTipoBecaPorNivel($parametros);
            }
            return new View("Se ha eliminado el registro correctamente", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
