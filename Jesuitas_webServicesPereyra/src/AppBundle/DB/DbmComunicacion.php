<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use Doctrine\Common\Persistence\ObjectManager;
use DBDatabaseManager;
use AppBundle\DB\Mysql\Comunicacion\NotificacionDB;
use AppBundle\DB\Mysql\Comunicacion\TableroDB;

class DbmComunicacion extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'notificacion' => new NotificacionDB($em),
            'tablero' => new TableroDB($em)
        ));
    }

    /*
     * Metodo para obtener notificaciones con filtros
     */
    public function BuscarNotificacion($filtros)
    {
        return $this->dbManagers['notificacion']->BuscarNotificacion($filtros);
    }


    /*
     * Metodo para obtener las notificaciones pendientes de envio
     */
    public function BuscarNotificacionesPendientes()
    {
        return $this->dbManagers['notificacion']->BuscarNotificacionesPendientes();
    }

    /*
     * Metodo para obtener las notificaciones para las apps
     */
    public function BuscarNotificacionesAPP($filtros)
    {
        return $this->dbManagers['notificacion']->BuscarNotificacionesAPP($filtros);
    }


    /*
     * Metodo para obtener las notificaciones de noticias, informe y menu
     */
    public function TotalesNotificaciones($filtros)
    {
        return $this->dbManagers['tablero']->TotalesNotificaciones($filtros);
    }

    /*
     * Metodo para obtener el detalle de las notificaciones de noticias, informe y menu
     */
    public function Detalle($idtiponotificacion, $titulo)
    {
        return $this->dbManagers['tablero']->Detalle($idtiponotificacion, $titulo);
    }
}
