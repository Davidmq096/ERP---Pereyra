<?php

namespace AppBundle\DB;
use Doctrine\ORM\EntityManager as EM;
use AppBundle\DB\Mysql\ReinscripcionDB;
use AppBundle\DB\Mysql\PortalFamiliarDB;

class DbmReinscripcion extends DatabaseManager {

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em){
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'reinscripcion'=> new ReinscripcionDB($em),
        ));  
    }

    /*
       Autor: David Medina davidmq.skip@gmail.com
       Fecha: 19/04/2021
       Función: Se agrega para poder extraer el sp reinscripciontokens 
       Tipo: Nuevo código
    */
    public function BuscarVistaReinscripcion($id){        
        return $this->dbManagers['reinscripcion']->BuscarVistaReinscripcion($id);
    }
}