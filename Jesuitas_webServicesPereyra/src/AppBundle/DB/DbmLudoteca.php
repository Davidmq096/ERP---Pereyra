<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use Doctrine\Common\Persistence\ObjectManager;
use DBDatabaseManager;

use AppBundle\DB\Mysql\Ludoteca\InscripcionDB;
use AppBundle\DB\Mysql\Ludoteca\CapturaLudotecaDB;

class DbmLudoteca extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers,array(
            'inscripcion' => new InscripcionDB($em),
            'capturaludoteca' => new CapturaLudotecaDB($em)
        ));

    }

    /*
    * Metodo para buscar capturas de un alumno
    */
    public function BuscarCapturaAlumno($filtros)
    {
        return $this->dbManagers['capturaludoteca']->BuscarCapturaAlumno($filtros);
    }

    /*
    * Metodo para buscar usuarios de captura de ludoteca
    */
    public function BuscarUsuarios()
    {
        return $this->dbManagers['capturaludoteca']->BuscarUsuarios();
    }

    /*
    * Metodo contratos de ludoteca por alumno
    */
    public function BuscarPersonarecoge()
    {
        return $this->dbManagers['capturaludoteca']->BuscarPersonarecoge();
    }

    /*
    * Metodo para encontrar las personas que recogen por alumno
    */
    public function BuscarPersonarecogeporalumno($id)
    {
        return $this->dbManagers['capturaludoteca']->BuscarPersonarecogeporalumno($id);
    }

        /*
    * Metodo para encontrar los padres o tutores por alumno
    */
    public function BuscarPadretutorporalumno($id)
    {
        return $this->dbManagers['capturaludoteca']->BuscarPadretutorporalumno($id);
    }



    /*
    * Metodo contratos de ludoteca por alumno
    */
    public function FiltrarLudoteca($filtros)
    {
        return $this->dbManagers['capturaludoteca']->FiltrarLudoteca($filtros);
    }

    /*
    * Metodo contratos de ludoteca por alumno
    */
    public function BuscarLudoteca($filtros)
    {
        return $this->dbManagers['capturaludoteca']->BuscarLudoteca($filtros);
    }

    /*
    * Metodo para obtener diafestivo con filtros
    */
    public function BuscarContratos($filtros)
    {
        return $this->dbManagers['inscripcion']->BuscarContratos($filtros);
    }

    /*
    * Metodo para obtener los datos de ludotecas de alumno por mes
    */
    public function ObtenerDatosLudotecaAlumno($alumnoid, $fecha, $tipo)
    {
        return $this->dbManagers['capturaludoteca']->ObtenerDatosLudotecaAlumno($alumnoid, $fecha, $tipo);
    }
}
