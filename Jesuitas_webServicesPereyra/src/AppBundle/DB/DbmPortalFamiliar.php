<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use AppBundle\DB\Mysql\PortalFamiliarDB;


class DbmPortalFamiliar extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'portalfamililar' => new PortalFamiliarDB($em),
        ));
    }

    /*
     * Método para obtener vigencia de actualización de datos de los alumnos en el portal familiar
     */
    public function GetVigenciaPeriodoActualizacion() 
    {
        return $this->dbManagers['portalfamililar']->GetVigenciaPeriodoActualizacion();
    }


}
