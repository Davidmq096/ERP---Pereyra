<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DatabaseManager;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;

/**
 * @author Mariano
 */
class NotificacionController extends FOSRestController{

    /**
     * Retorna arreglo de datos iniciales de notificaciones
     * @Rest\Get("/api/Controlescolar/Notificacion", name="indexNotificacionActividad")
     */
    public function indexNotificacionActividad()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $tipoactividad = $dbm->getRepositoriosById('CeTipoactividad', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $grupo = $dbm->getRepositorios('CeGrupo');
            $materia = $dbm->getRepositorios('CeMateriaporplanestudios');
            return new View(["tipoactividad"=>$tipoactividad,"nivel"=>$nivel,"grado"=>$grado,"materia"=>$materia,"grupo"=>$grupo], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de notificaciones
     * @Rest\Post("/api/Controlescolar/Notificacion/Filtrar", name="getNotificacion")
     */
    public function getNotificacion()
    {
        try {
            $content = trim(file_get_contents("php://input")); 
            $filtros = json_decode($content, true); 
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $ciclo = $dbm->getRepositorioById('Ciclo', 'actual', 1);
            $filtros['cicloid'] = $ciclo->getCicloid();
            if(!$filtros['fecha']){
                $filtros['fechaactual'] = $dbm->getRepositorioById('CeCiclopornivel', 'cicloid', $filtros['cicloid']);
            }
            
            $notificaciones = $dbm->BuscarNotificaciones($filtros);
            foreach ($notificaciones as &$notificacion){
                if ($notificacion["uorigen"]){
                    $notificacion["origen"]=$notificacion["uorigen"];
                }else{
                    if ($notificacion["profeo"]){
                        $notificacion["origen"]=$notificacion["profeo"];
                    }else{
                        if ($notificacion["ao"]){
                            $notificacion["origen"]=$notificacion["ao"];
                        }
                    }
                }

                if ($notificacion["udestino"]){
                    $notificacion["destino"]=$notificacion["udestino"];
                }else{
                    if ($notificacion["ppdestino"]){
                        $notificacion["destino"]=$notificacion["ppdestino"];
                    }else{
                        if ($notificacion["ad"]){
                            $notificacion["destino"]=$notificacion["ad"];
                        }
                    }
                }
            }

            if (!$notificaciones) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($notificaciones, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}   