<?php

namespace AppBundle\DB;

use AppBundle\DB\Mysql\Admisiones\SolicitudAdmisionDB;
use AppBundle\DB\Mysql\Bancoreactivo\AplicacionExamenDB;
use AppBundle\DB\Mysql\Bancoreactivo\AreasDB;
use AppBundle\DB\Mysql\Bancoreactivo\CalendarizacionExamenDB;
use AppBundle\DB\Mysql\Bancoreactivo\CalificacionExamenDB;
use AppBundle\DB\Mysql\Bancoreactivo\ColegiosDB;
use AppBundle\DB\Mysql\Bancoreactivo\ExamenesDB;
use AppBundle\DB\Mysql\Bancoreactivo\ReactivosDB;
use AppBundle\DB\Mysql\Bancoreactivo\ReactivosResultadosGeneralDB;
use AppBundle\DB\Mysql\Bancoreactivo\SubtemasDB;
use AppBundle\DB\Mysql\Bancoreactivo\TemasDB;
use AppBundle\DB\Mysql\Bancoreactivo\UsuarioExternoDB;
use Doctrine\ORM\EntityManager as EM;

class DbmBancoreactivo extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'colegios' => new ColegiosDB($em),
            'usuarioexterno' => new UsuarioExternoDB($em),
            'areas' => new AreasDB($em),
            'temas' => new TemasDB($em),
            'subtemas' => new SubtemasDB($em),
            'reactivos' => new ReactivosDB($em),
            'examenes' => new ExamenesDB($em),
            'calendarizacionexamen' => new CalendarizacionExamenDB($em),
            'calificacionexamen' => new CalificacionExamenDB($em),
            'aplicacionexamen' => new AplicacionExamenDB($em),
            'resultadoreactivos' => new ReactivosResultadosGeneralDB($em),
            'admisiones' => new SolicitudAdmisionDB($em),
        ));

    }

    /*
     * Metodo para obtener colegios con filtros
     */

    public function BuscarColegios($filtros)
    {
        return $this->dbManagers['colegios']->BuscarColegios($filtros);
    }

    /*
     * Metodo para obtener usuario externo con filtros
     */

    public function BuscarUsuaroexterno($filtros)
    {
        return $this->dbManagers['usuarioexterno']->BuscarUsuarioexterno($filtros);
    }

    /*
     * Metodo para obtener areas con filtros
     */

    public function BuscarAreas($filtros)
    {
        return $this->dbManagers['areas']->BuscarAreas($filtros);
    }

    /*
     * Metodo para obtener temas con filtros
     */

    public function BuscarTemas($filtros)
    {
        return $this->dbManagers['temas']->BuscarTemas($filtros);
    }

    /*
     * Metodo para obtener subtemas con filtros
     */

    public function BuscarSubtemas($filtros)
    {
        return $this->dbManagers['subtemas']->BuscarSubtemas($filtros);
    }

    /*
     * Metodo para obtener reactivos con filtros
     */

    public function BuscarReactivos($filtros)
    {
        return $this->dbManagers['reactivos']->BuscarReactivos($filtros);
    }

    /*
     * Metodo para obtener bitacora de reactivos
     */

    public function BitacoraReactivos($id)
    {
        return $this->dbManagers['reactivos']->BitacoraReactivos($id);
    }

    /*
     * Metodo para obtener examenes con filtros
     */

    public function BuscarExamenes($filtros)
    {
        return $this->dbManagers['examenes']->BuscarExamenes($filtros);
    }

    /*
     * Metodo para obtener las especificaciones de un examen
     */

    public function BuscarExamenesEspecificaciones($id)
    {
        return $this->dbManagers['examenes']->BuscarExamenesEspecificaciones($id);
    }

    /*
     * Metodo para obtener examenes con filtros
     */

    public function BuscarCalendarizacionexamen($filtros)
    {
        return $this->dbManagers['calendarizacionexamen']->BuscarCalendarizacionexamen($filtros);
    }

    /*
     * Metodo para obtener examenes con filtros
     */

    public function BuscarAplicacionexamenExterno($filtros)
    {
        return $this->dbManagers['aplicacionexamen']->BuscarAplicacionexamenExterno($filtros);
    }

    /*
     * Metodo para obtener califiacion de examenes
     */
    public function BuscarCalificacionexamen($filtros)
    {
        return $this->dbManagers['calificacionexamen']->BuscarCalificacionexamen($filtros);
    }

    /*
     * Metodo para obtener los resultados de las evaluaciones de reactivos
     */

    public function BuscarReactivosResultados($filtros)
    {
        return $this->dbManagers['resultadoreactivos']->BuscarReactivosResultados($filtros);
    }

    /*
     * Metodo para obtene el detalle de una evaluacion de reactivos
     */

    public function BuscarReactivosResultadosDetalle($id)
    {
        return $this->dbManagers['resultadoreactivos']->BuscarReactivosResultadosDetalle($id);
    }

    public function getSolicitudByFilter($filters)
    {
        return $this->dbManagers['admisiones']->getSolicitudByFilter($filters);
    }

    public function BuscarExamenesAplicadosByAlumno($filters)
    {
        return $this->dbManagers['calendarizacionexamen']->BuscarExamenesAplicadosByAlumno($filters);
    }

    public function BuscarGruposPorMateria($filters)
    {
        return $this->dbManagers['calendarizacionexamen']->BuscarGruposPorMateria($filters);
    }

    public function BuscarAspectospormateria($filters)
    {
        return $this->dbManagers['calendarizacionexamen']->BuscarAspectospormateria($filters);
    }

}
