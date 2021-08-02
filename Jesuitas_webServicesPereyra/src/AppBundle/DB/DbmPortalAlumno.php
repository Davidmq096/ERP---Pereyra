<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use AppBundle\DB\Mysql\PortalAlumnoDB;


class DbmPortalAlumno extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'portalalumno' => new PortalAlumnoDB($em),
        ));
    }

    /*
     * Método para obtener los periodos de evaluacion de un grado en un ciclo
     */
    public function FaltasDetalle($filtros) 
    {
        return $this->dbManagers['portalalumno']->FaltasDetalle($filtros);
    }

    /*
     * Método para obtener los periodos de evaluacion de un grado en un ciclo
     */
    public function BuscarCapturasAlumno($filtros) 
    {
        return $this->dbManagers['portalalumno']->BuscarCapturasAlumno($filtros);
    }

    /*
     * Método para obtener los periodos de evaluacion de un grado en un ciclo
     */
    public function BuscarPeriodosGradoCiclo($filtros) 
    {
        return $this->dbManagers['portalalumno']->BuscarPeriodosGradoCiclo($filtros);
    }

    /*
     * Método para obtener las calificaciones de un alumno
     */
    public function BuscarCalificacionesAlumno($filtros) 
    {
        return $this->dbManagers['portalalumno']->BuscarCalificacionesAlumno($filtros);
    }

}
