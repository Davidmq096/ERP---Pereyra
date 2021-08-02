<?php

namespace AppBundle\DB;

use AppBundle\DB\Mysql\Becas\BecaDB;
use AppBundle\DB\Mysql\Becas\PeriodosBecasDB;
use AppBundle\DB\Mysql\Becas\TiposBecasDB;
use AppBundle\DB\Mysql\FondoOrfandad\FondoOrfandadDB;
use AppBundle\DB\Mysql\Becas\SolicitudBecaDB;
use AppBundle\DB\Mysql\Becas\TrabajadoraSocialDB;
use AppBundle\DB\Mysql\Becas\AltaAlumnosDB;
use Doctrine\ORM\EntityManager as EM;

class DbmBecas extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'periodobecas' => new PeriodosBecasDB($this->em),
            'tiposbecas' => new TiposBecasDB($this->em),
            'altaalumnos' => new AltaAlumnosDB($em),
            'fondoorfandad' => new FondoOrfandadDB($em),
            'consultabecas' => new BecaDB($em),
            'solicitudbecas' => new SolicitudBecaDB($em),
            'trabajadorasocial' => new TrabajadoraSocialDB($em)
        ));
    }

    //metodo para buscar historial de todos los hijos
    public function BuscarSolicitudesAlumno($filtros)
    {
        return $this->dbManagers['solicitudbecas']->BuscarSolicitudesAlumno($filtros);
    }

    //metodo para BuscarPeriodos
    public function BuscarPeriodos($filtros)
    {
        return $this->dbManagers['periodobecas']->BuscarPeriodos($filtros);
    }

    //Metodo para obtener Tipos de Becas con filtros
    public function BuscarTiposbecas($filtros)
    {
        return $this->dbManagers['tiposbecas']->BuscarTiposBecas($filtros);
    }

    //Metodo para obtener el detalle de Tipos de Becas
    public function BuscarPorcentajesPorNivel($id)
    {
        return $this->dbManagers['tiposbecas']->BuscarPorcentajesPorNivel($id);
    }

    //metodo para Eliminar detalles del tipo de beca
    public function EliminarTipoBecaPorNivel($filtros)
    {
        return $this->dbManagers['tiposbecas']->EliminarTipoBecaPorNivel($filtros);
    }




    //Metodo para buscar la vista de solicitud becas para reemplazar tokens
    public function VistaSolicitudBeca($id)
    {
        return $this->dbManagers['solicitudbecas']->VistaSolicitudBeca($id);
    }

    //Metodo para obtener el parentesco por clave familiar
    public function buscarPadresBecas($ClaveFamiliarId)
    {
        return $this->dbManagers['solicitudbecas']->buscarPadresBecas($ClaveFamiliarId);
    }

    //Metodo para obtener el parentesco por clave familiar
    public function buscarPadresBecasCe($ClaveFamiliarId)
    {
        return $this->dbManagers['solicitudbecas']->buscarPadresBecasCe($ClaveFamiliarId);
    }


    //Metodo para obtener las solicitudes de becas para el layout de descarga
    public function SolicitudBecasLayout($filtros)
    {
        return $this->dbManagers['solicitudbecas']->SolicitudBecasLayout($filtros);
    }

    //Metodo para obtener fondos de orfandad con filtros
    public function BuscarFondoOrfandad($filtros)
    {
        return $this->dbManagers['fondoorfandad']->BuscarFondoOrfandad($filtros);
    }

    //Metodo para obtener consulta de becas con filtros
    public function BuscarBecas($filtros)
    {
        return $this->dbManagers['consultabecas']->BuscarBecas($filtros);
    }

    //metodo para obtener clavefamiliar de solicitud de beca
    public function BuscarSolicitudClaveFamiliar($filtros)
    {
        return $this->dbManagers['solicitudbecas']->BuscarSolicitudClaveFamiliar($filtros);
    }


    //metodo para obtener alumnos por familia
    public function Buscaralumnoporfamlia($filtros, $param)
    {
        return $this->dbManagers['solicitudbecas']->Buscaralumnoporfamlia($filtros, $param);
    }

    //metodo para obtener padre o tutores
    public function Buscarpadrestutores($filtros)
    {
        return $this->dbManagers['solicitudbecas']->Buscarpadrestutores($filtros);
    }

    //metodo para buscar domicilio deacuerdo al alumno seleccionado
    public function Buscardomicilioestudiosocioeconomicoalumno($filtros)
    {
        return $this->dbManagers['solicitudbecas']->Buscardomicilioestudiosocioeconomicoalumno($filtros);
    }

    //metodo para buscar historial de todos los hijos
    public function Buscarhistorialhijos($filtros)
    {
        return $this->dbManagers['solicitudbecas']->Buscarhistorialhijos($filtros);
    }

    //regresa referencias por solicitud
    public function BuscarReferencias($filtros)
    {
        return $this->dbManagers['solicitudbecas']->BuscarReferencias($filtros);
    }


    //eliminar referencia
    public function eliminarRefencia($filtros)
    {
        return $this->dbManagers['solicitudbecas']->eliminarRefencia($filtros);
    }

    //nuevas becas
    public function Buscarnuevasbecas($filtros)
    {
        return $this->dbManagers['solicitudbecas']->Buscarnuevasbecas($filtros);
    }

    //consultar beca provisional para editar
    public function BuscarBecaprovicional($filtros)
    {
        return $this->dbManagers['solicitudbecas']->BuscarBecaprovicional($filtros);
    }

    //obtener domicilio solicitud
    public function getdomicilio($filtros)
    {
        return $this->dbManagers['solicitudbecas']->getdomicilio($filtros);
    }

    //obtener domicilio solicitud sin coloniaid
    public function getdomicilio2($filtros)
    {
        return $this->dbManagers['solicitudbecas']->getdomicilio2($filtros);
    }

    //obtener padres solicitud
    public function buscarvisita($filtros)
    {
        return $this->dbManagers['solicitudbecas']->buscarvisita($filtros);
    }

    //obtener informacion pestaña recibir documentos
    public function buscardocs($filtros)
    {
        return $this->dbManagers['solicitudbecas']->buscardocs($filtros);
    }


    //metodo para buscar Solicitudes de becas
    public function BuscarSolicitudesBecas($filtros)
    {
        return $this->dbManagers['solicitudbecas']->BuscarSolicitudesBecas($filtros);
    }




    //metodo para buscarlinks archivos
    public function SolicitudesPorPadreoTutor($filtros, $val)
    {
        return $this->dbManagers['solicitudbecas']->SolicitudesPorPadreoTutor($filtros, $val);
    }

    //Obtiene las claves familiares de un pader o tutor
    public function GetClaveFamiliarPadreOTutorSolicitudBeca($PadreOTutorId)
    {
        return $this->dbManagers['solicitudbecas']->GetClaveFamiliarPadreOTutorSolicitudBeca($PadreOTutorId);
    }

    //Obtiene los alumnos de una clave familiar
    public function GetAlumnoPorClaveFamiliar($ClaveFamiliarId)
    {
        return $this->dbManagers['solicitudbecas']->GetAlumnoPorClaveFamiliar($ClaveFamiliarId);
    }

    //metodo para buscarlinks archivos
    public function SolicitudesPorPadreoTutorAlumnos($filtros, $param)
    {
        return $this->dbManagers['solicitudbecas']->SolicitudesPorPadreoTutorAlumnos($filtros, $param);
    }

    public function BuscarSolicitudes($filtros)
    {
        return $this->dbManagers['altaalumnos']->BuscarSolicitudes($filtros);
    }

    public function agregarAlumnos($filtros)
    {
        return $this->dbManagers['altaalumnos']->agregarAlumnos($filtros);
    }

    public function BuscarSolicitudesTrabjadoraSocialBecas($filtros)
    {
        return $this->dbManagers['trabajadorasocial']->BuscarSolicitudesTrabjadoraSocialBecas($filtros);
    }
}
