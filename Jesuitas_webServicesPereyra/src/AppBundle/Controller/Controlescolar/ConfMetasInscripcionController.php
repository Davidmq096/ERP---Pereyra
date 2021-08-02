<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\Ciclo;
use AppBundle\Entity\CeConfiguracionmetasinscripcion;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author David
 */
class ConfMetasInscripcionController extends FOSRestController
{
    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/ConfMetasInscripcion", name="ConfMetasInscripcion")
     */
    public function ConfMetasInscripcion()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);

            return new View(array("ciclo" => $ciclo), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Ciclos en base a los parametros enviados
     * @Rest\Get("/api/Controlescolar/ConfMetasInscripcion/getMetas", name="getMetas")
     */
    public function getMetas()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if(!$filtros['cicloid']) {
                return new View("No se ha encontrado ningun ciclo", Response::HTTP_PARTIAL_CONTENT);
            }
            $metas = $dbm->getRepositoriosById("CeConfiguracionmetasinscripcion", "cicloid", $filtros['cicloid']);
            $grados = $dbm->getRepositorios("Grado");
            if(!$metas) {
                $dbm->getConnection()->beginTransaction();
                foreach($grados as $g) {
                    $meta = new CeConfiguracionmetasinscripcion();
                    $meta->setCicloid($dbm->getRepositorioById("Ciclo", "cicloid", $filtros['cicloid']));
                    $meta->setGradoid($g);
                    $dbm->saveRepositorio($meta);
                }   
                $dbm->getConnection()->commit();
            }

            $entidad = $dbm->getRepositoriosModelo("CeConfiguracionmetasinscripcion", 
            ["d.configuracionmetainscripcionid","IDENTITY(d.cicloid) as cicloid", "g.gradoid", "g.grado", "n.nombre as nivel", "d.meta"], 
            [["cicloid = " . $filtros['cicloid']]], false, true, [
                ["entidad" => "Grado", "alias" => "g", "left" => false, "on" => "g.gradoid = d.gradoid"],
                ["entidad" => "Nivel", "alias" => "n", "left" => false, "on" => "n.nivelid = g.nivelid"]
            ]);
            if (!$entidad) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

   
    /**
     * @Rest\Post("/api/Controlescolar/ConfMetasInscripcion/Guardar" , name="GuardarMetas")
     */
    public function GuardarMetas()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            foreach ($data['metasinscripcion'] as $metas){
                $pcal = $dbm->getRepositorioById('CeConfiguracionmetasinscripcion', 'configuracionmetainscripcionid', $metas['configuracionmetainscripcionid']);
                $meta = $hydrator->hydrate($pcal, $metas);
                $dbm->saveRepositorio($meta);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


}
