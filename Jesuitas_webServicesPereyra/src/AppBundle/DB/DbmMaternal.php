<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use Doctrine\Common\Persistence\ObjectManager;
use DBDatabaseManager;

use AppBundle\DB\Mysql\Maternal\PlatilloDB;
use AppBundle\DB\Mysql\Maternal\ActividadDB;
use AppBundle\DB\Mysql\Maternal\InventarioDB;
use AppBundle\DB\Mysql\Maternal\HigieneDB;
use AppBundle\DB\Mysql\Maternal\MenuDB;
use AppBundle\DB\Mysql\Maternal\InformeDB;

use AppBundle\DB\Mysql\Controlescolar\CalendaroEscolarDB;

class DbmMaternal extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'platillo' => new PlatilloDB($em),
            'actividad' => new ActividadDB($em),
            'inventario' => new InventarioDB($em),
            'higiene' => new HigieneDB($em),
            'menu' => new MenuDB($em),
            'informe' => new InformeDB($em),
            'calendario' => new CalendaroEscolarDB($em)
        ));
    }

    /*
     * Metodo para obtener diafestivo con filtros
     */

    public function BuscarDiaFestivo($filtros)
    {
        return $this->dbManagers['calendario']->BuscarCalendarioescolar($filtros);
    }


    /*
     * Metodo para obtener los datos de un alumno en el informe
     */
    public function DatosAlumnoInforme($filtros)
    {
        return $this->dbManagers['informe']->DatosAlumnoInforme($filtros);
    }


    /*
     * Metodo para obtener el padre al que se enviara el informe diario
     */
    public function BuscarPadreInforme($filtros)
    {
        return $this->dbManagers['informe']->BuscarPadreInforme($filtros);
    }

    /*
     * Metodo para obtener los alumnos de maternal
     */
    public function BuscarAlumnosInforme($filtros)
    {
        return $this->dbManagers['informe']->BuscarAlumnosInforme($filtros);
    }

    /*
     * Metodo para obtener platillo con filtros
     */
    public function BuscarPlatillo($filtros)
    {
        return $this->dbManagers['platillo']->BuscarPlatillo($filtros);
    }

    /*
     * Metodo para obtener actividad con filtros
     */
    public function BuscarActividad($filtros)
    {
        return $this->dbManagers['actividad']->BuscarActividad($filtros);
    }
    /*
     * Metodo para obtener inventario con filtros
     */
    public function BuscarInventario($filtros)
    {
        return $this->dbManagers['inventario']->BuscarInventario($filtros);
    }
    /*
     * Metodo para obtener higiene con filtros
     */
    public function BuscarHigiene($filtros)
    {
        return $this->dbManagers['higiene']->BuscarHigiene($filtros);
    }


    /*
     * Metodo para obtener menu con filtros
     */
    public function BuscarAsignaciones($filtros)
    {
        return $this->dbManagers['menu']->BuscarAsignaciones($filtros);
    }

    /*
     * Metodo para obtener menu con filtros
     */
    public function BuscarMenu($filtros)
    {
        return $this->dbManagers['menu']->BuscarMenu($filtros);
    }

    /*
     * Metodo para obtener menu con filtros
     */
    public function BuscarAlumnosMaternal()
    {
        return $this->dbManagers['menu']->BuscarAlumnosMaternal();
    }

    /*
     * Metodo para obtener asignaciones de menu
     */
    public function BuscarAsignacion($filtros)
    {
        return $this->dbManagers['menu']->BuscarAsignacion($filtros);
    }

    /*
     * Metodo para obtener asignaciones de menu
     */
    public function BuscarAsignacionPadre($filtros)
    {
        return $this->dbManagers['menu']->BuscarAsignacionPadre($filtros);
    }

    /*
     * Metodo para obtener la relacion del padre o tutor con el alumno
     */
    public function BuscarPadre($filtros)
    {
        return $this->dbManagers['menu']->BuscarPadre($filtros);
    }

    /*
     * Metodo para obtener el usuario de la relacion del padre o tutor con el alumno
     */
    public function BuscarPadreUsuario($filtros)
    {
        return $this->dbManagers['menu']->BuscarPadreUsuario($filtros);
    }

    /*
     * Metodo para obtener el ultimo menu asignado al alumno
     */
    public function BuscarMenuanterior($alumnoid)
    {
        return $this->dbManagers['menu']->BuscarMenuanterior($alumnoid);
    }

    /*
     * Metodo para obtener informes con filtros
     */
    public function BuscarInformeApp($filtros)
    {
        return $this->dbManagers['informe']->BuscarInformeApp($filtros);
    }

    /*
     * Metodo para obtener informes con filtros
     */
    public function BuscarInforme($filtros)
    {
        return $this->dbManagers['informe']->BuscarInforme($filtros);
    }

    /*
     * Metodo para obtener las notificaciones que se muestren al hijo
     */
    public function BuscarHijo($filtros)
    {
        return $this->dbManagers['inventario']->BuscarHijo($filtros);
    }
}
