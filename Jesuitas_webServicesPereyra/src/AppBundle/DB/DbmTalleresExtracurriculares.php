<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use Doctrine\Common\Persistence\ObjectManager;
use DBDatabaseManager;

use AppBundle\DB\Mysql\TalleresExtracurriculares\TallerExtracurricularDB;
use AppBundle\DB\Mysql\TalleresExtracurriculares\IdiomasDB;

class DbmTalleresExtracurriculares extends DatabaseManager
{
    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers,array(
            'consulta' => new TallerExtracurricularDB($em),
            'idiomas' => new IdiomasDB($em)
        ));

    }

    /*
    * Metodo para buscar talleres extracurriculares
    */
    public function BuscarTalleresExtracurriculares($filtros)
    {
        return $this->dbManagers['consulta']->BuscarTalleresExtracurriculares($filtros);
    }

    /*
    * Metodo para obtener los lugares disponibles de un taller extracurricular
    */
    public function LugaresDisponibles($tallerextracurricularid)
    {
        return $this->dbManagers['consulta']->LugaresDisponibles($tallerextracurricularid);
    }

    /*
    * Metodo para obtener los alumnos elegibles para un taller extracurricular
    */
    public function ObtenerAlumnos($filtros)
    {
        return $this->dbManagers['consulta']->ObtenerAlumnos($filtros);
    }

    
}
