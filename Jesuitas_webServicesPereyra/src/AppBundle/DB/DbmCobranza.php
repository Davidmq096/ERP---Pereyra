<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use Doctrine\Common\Persistence\ObjectManager;
use DBDatabaseManager;
use AppBundle\DB\Mysql\Cobranza\AcuerdosDB;
use AppBundle\DB\Mysql\Cobranza\AgendaCitasDB;
use AppBundle\DB\Mysql\Cobranza\BloqueoManualDB;
use AppBundle\DB\Mysql\Cobranza\SeguimientoDB;
use AppBundle\DB\Mysql\Cobranza\ReporteCobranzaDB;
use AppBundle\DB\Mysql\Cobranza\PagoInscripcionDB;
use AppBundle\DB\Mysql\Cobranza\PagosDiversosDB;
use AppBundle\DB\Mysql\Cobranza\PagosAdmisionDB;
use AppBundle\DB\Mysql\Cobranza\AdeudovencidoDB;
use AppBundle\DB\Mysql\Cobranza\BloqueosDB;
use AppBundle\DB\Mysql\Cobranza\AlumnoAcuerdoDB;

class DbmCobranza extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'agendacitas' => new AgendaCitasDB($em),
            'acuerdo' => new AcuerdosDB($em),
            'bloqueomanual' => new BloqueoManualDB($em),
            'seguimiento' => new SeguimientoDB($em),
            'reportecobranza' => new ReporteCobranzaDB($em),
            'pagoinscripcion' => new PagoInscripcionDB($em),
            "pagosdiversos" => new PagosDiversosDB($em),
            "pagosadmision" => new PagosAdmisionDB($em),
            "adeudovencido" => new AdeudovencidoDB($em),
            "bloqueos" => new BloqueosDB($em),
            "alumnoconvenio" => new AlumnoAcuerdoDB($em),
        ));
    }

    
    public function getUsuarioporsubconcepto(){
        return $this->dbManagers['pagosdiversos']->getUsuarioporsubconcepto();
    }
    
    public function getAlumnosPorSubconcepto($filtros){
        return $this->dbManagers['pagosdiversos']->getAlumnosPorSubconcepto($filtros);
    }
    
    public function getSubconceptoPorNivel($subconceptoid){
        return $this->dbManagers['pagosdiversos']->getSubconceptoPorNivel($subconceptoid);
    }
    
    public function getDocumentosPorPagar($filtros){
        return $this->dbManagers['pagosdiversos']->getDocumentosPorPagar($filtros);
    }

    //Funcion filtros de Agenda de citas
    public function getAgendaCitasFilters($filtros)
    {
        return $this->dbManagers['agendacitas']->getAgendaCitasFilters($filtros);
    }

    //Funcion filtros de Acuerdo
    public function BuscarAcuerdos($filtros)
    {
        return $this->dbManagers['acuerdo']->BuscarAcuerdos($filtros);
    }

    //Funcion filtros de Seguimiento Acuerdo
    public function BuscarSeguimiento($filtros)
    {
        return $this->dbManagers['seguimiento']->BuscarSeguimiento($filtros);
    }

    //Funcion filtros de Bloqueo manual
    public function BuscarBloqueoManual($filtros)
    {
        return $this->dbManagers['bloqueomanual']->BuscarBloqueoManual($filtros);
    }

    //Funcion filtros de Reporte cobranza
    public function BuscarReportecobranza($filtros)
    {
        return $this->dbManagers['reportecobranza']->BuscarReportecobranza($filtros);
    }

    //Funcion filtros de Pago de inscripcion 
    public function BuscarPagoinscripcion($filtros)
    {
        return $this->dbManagers['pagoinscripcion']->BuscarPagoinscripcion($filtros);
    }
    //Funcion filtros de Pago de inscripcion con detalle
    public function BuscarPagoinscripciondetalle($filtros)
    {
        return $this->dbManagers['pagoinscripcion']->BuscarPagoinscripciondetalle($filtros);
    }
    //Funcion filtros de Pago de admisión
    public function BuscarPagosAdmision($filtros)
    {
        return $this->dbManagers['pagosadmision']->BuscarPagosAdmision($filtros);
    }

    //Funcion filtros de Pago de adeudos
    public function BuscarAdeudosvencidos($filtros)
    {
        return $this->dbManagers['adeudovencido']->BuscarAdeudosvencidos($filtros);
    }
    public function BuscarAdeudosVencidosDetalle($filtros)
    {
        return $this->dbManagers['adeudovencido']->BuscarAdeudosVencidosDetalle($filtros);
    }
    public function BuscarColegiaturasVencida($filtros)
    {
        return $this->dbManagers['bloqueos']->BuscarColegiaturasVencida($filtros);
    }
    public function BuscarConveniosAlumno($filtros)
    {
        return $this->dbManagers['alumnoconvenio']->BuscarConveniosAlumno($filtros);
    }
}
