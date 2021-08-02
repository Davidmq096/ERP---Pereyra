<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use Doctrine\Common\Persistence\ObjectManager;
use DBDatabaseManager;

use AppBundle\DB\Mysql\Transporte\RutaDB;
use AppBundle\DB\Mysql\Transporte\PlantillaContratoDB;
use AppBundle\DB\Mysql\Transporte\ContratoDB;
use AppBundle\DB\Mysql\Transporte\BoletoDB;
use AppBundle\DB\Mysql\Transporte\OfflineDB;

class DbmTransporte extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'ruta' => new RutaDB($em),
            'plantillacontrato' => new PlantillaContratoDB($em),
            'contrato' => new ContratoDB($em),
            'boleto' => new BoletoDB($em),
            'offline' => new OfflineDB($em),
        ));
    }

    /*
    * Metodo para buscar rutas
    */
    public function BuscarRuta($filtros)
    {
        return $this->dbManagers['ruta']->BuscarRuta($filtros);
    }

    /*
    * Metodo para buscar plantillas de contratos
    */
    public function BuscarPlantilla($filtros)
    {
        return $this->dbManagers['plantillacontrato']->BuscarPlantilla($filtros);
    }

    public function GetCAlumnoMRPEntity($kcontrato, $kalumno, $kruta, $year, $month){
			return $this->dbManagers['contrato']->getAlumnoMRPEntity($kcontrato, $kalumno, $kruta, $year, $month);
    }

		public function GetCAlumnoMRPSEntityByContrato($kcontrato){
			return $this->dbManagers['contrato']->getAlumnoMRPSEntityByContrato($kcontrato);
		}

    /*
    * Metodo para buscar  contratos
    */
    public function BuscarContrato($filtros)
    {
        return $this->dbManagers['contrato']->BuscarContrato($filtros);
    }

    /*
    * Metodo para obtener la deuda familiar del transporte
    */
    public function BuscarDeudaTransporte($familiaid)
    {
        return $this->dbManagers['contrato']->BuscarDeudaTransporte($familiaid);
    }

    /*
    * Metodo para buscar rutas con disponibilidad
    */
    public function BuscarDisponibilidad($filtros)
    {
        return $this->dbManagers['boleto']->BuscarDisponibilidad($filtros);
    }

    /*
    * Metodo para buscar rutas con disponibilidad con detalle de alumnos
    */
    public function BuscarDisponibilidadAlumnos($filtros)
    {
        return $this->dbManagers['boleto']->BuscarDisponibilidadAlumnos($filtros);
    }

    /*
    * Metodo para buscar boletos de una familia o alumno
    */
    public function BuscarMisboletos($filtros)
    {
        return $this->dbManagers['boleto']->BuscarMisboletos($filtros);
    }

    /*
    * Metodo para buscar boletos de una familia o alumno
    */
    public function BuscarBoletoBitacora($filtros)
    {
        return $this->dbManagers['boleto']->BuscarBoletoBitacora($filtros);
    }

        /*
    * Descarga informacion para trabajar de forma offline
    */
    public function OfflineDescargar($filtros)
    {
        return $this->dbManagers['offline']->OfflineDescargar($filtros);
    }
}
