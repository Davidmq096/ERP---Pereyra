<?php

namespace AppBundle\Controller\Becas;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Autor: David
 */
class TrabajadoraSocialController extends FOSRestController
{

    /**
     * Retorna filtros becas
     * @Rest\Get("/api/Becas/TrabajadoraSocial/Filtrar", name="getTrabajadoraSocial")
     */
    public function IndexTrabajadoraSocial()
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $usuario = $dbm->getRepositoriosModelo("Usuario", ["d.usuarioid, CONCAT_WS(' ', c.apellidopaterno, c.apellidomaterno, c.nombre) as nombre"],
            [['tipousuarioid = 1 and d.activo = 1']], false, true, [
                ["entidad" => "Persona", "alias" => "c", "left" => false, "on" => "c.personaid = d.personaid"],
            ], 'd.usuarioid');


            $return = array(
                "ciclo" => $ciclo, 
                'usuario' => $usuario
            );
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de solicitudes de becas
     * @Rest\Post("/api/Becas/TrabajadoraSocial/Consultar", name="ConsultaSolicitudBecasTrabajadoraSocialfiltro")
     */
    public function ConsultaSolicitudBecasTrabajadoraSocialfiltro()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $decoded =  array_filter($decoded);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $repositorio = $dbm->BuscarSolicitudesTrabjadoraSocialBecas($decoded);

            if (empty($repositorio)) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($repositorio, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    
    /**
     * 
     * @Rest\Post("/api/Becas/TrabajadoraSocial/Usuario", name="GuardarUsuarioTrabajadorSocial")
     */
    public function GuardarUsuarioTrabajadorSocial()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $decoded =  array_filter($decoded);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            foreach($decoded['alumnos'] as $s) {
                $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $s);
                $solicitud->setUsuarioid($decoded['datos']['usuarioid'] ?
                    $dbm->getRepositorioById("Usuario", "usuarioid", $decoded['datos']['usuarioid']) : null);
                $dbm->saveRepositorio($solicitud);
            }
            $dbm->getConnection()->commit();
            return new View("Se han actualizado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Post("/api/Becas/TrabajadoraSocial/RetirarUsuario", name="RetirarUsuarioTrabajadorSocial")
     */
    public function RetirarUsuarioTrabajadorSocial()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $decoded =  array_filter($decoded);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            foreach($decoded as $s) {
                $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $s);
                $solicitud->setUsuarioid(null);
                $dbm->saveRepositorio($solicitud);
            }
            $dbm->getConnection()->commit();
            return new View("Se han actualizado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}