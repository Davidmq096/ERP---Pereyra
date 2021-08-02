<?php

namespace AppBundle\DB;

use AppBundle\DB\Mysql\Admisiones\AplicacionEntrevistaDB;
use AppBundle\DB\Mysql\Admisiones\CalendarioEvaluadorDB;
use AppBundle\DB\Mysql\Admisiones\CategoriaApoyoDB;
use AppBundle\DB\Mysql\Admisiones\ConfiguracionBloqueDB;
use AppBundle\DB\Mysql\Admisiones\CupoAdmisionDB;
use AppBundle\DB\Mysql\Admisiones\DocumentoDB;
use AppBundle\DB\Mysql\Admisiones\DocumentoGradoDB;
use AppBundle\DB\Mysql\Admisiones\EvaluacionDB;
use AppBundle\DB\Mysql\Admisiones\EvaluadorDB;
use AppBundle\DB\Mysql\Admisiones\FactoresApoyoDB;
use AppBundle\DB\Mysql\Admisiones\FormatoDB;
use AppBundle\DB\Mysql\Admisiones\ListaAsistenciaDB;
use AppBundle\DB\Mysql\Admisiones\LugarDB;
use AppBundle\DB\Mysql\Admisiones\ModalSolicitud\DatoAspiranteDB;
use AppBundle\DB\Mysql\Admisiones\ModalSolicitud\DictamenDB;
use AppBundle\DB\Mysql\Admisiones\ModalSolicitud\OtrosProcesosDB;
use AppBundle\DB\Mysql\Admisiones\ModalSolicitud\SolicitudEvaluacionDB;
use AppBundle\DB\Mysql\Admisiones\ReporteAsignacionDB;
use AppBundle\DB\Mysql\Admisiones\ResultadoDB;
use AppBundle\DB\Mysql\Admisiones\SolicitudAdmisionDB;
use AppBundle\DB\Mysql\Admisiones\TableroDB;
use AppBundle\DB\Mysql\Controlescolar\CalendaroEscolarDB;
use Doctrine\ORM\EntityManager as EM;

class DbmAdmisiones extends DatabaseManager
{

    protected $em;
    protected $dbManagers;
    protected $objectManager;

    public function __construct(EM $em)
    {
        parent::__construct($em);
        $this->em = $em;
        $this->dbManagers = array_merge($this->dbManagers, array(
            'formato' => new FormatoDB($this->em),
            'documento' => new DocumentoDB($this->em),
            'documentoporgrado' => new DocumentoGradoDB($this->em),
            'cupoadmision' => new CupoAdmisionDB($this->em),
            'lugar' => new LugarDB($this->em),
            'evaluador' => new EvaluadorDB($this->em),
            'evaluacion' => new EvaluacionDB($this->em),
            'calendarioevaluador' => new CalendarioEvaluadorDB($this->em),
            'categoriaapoyo' => new CategoriaApoyoDB($em),
            'factoresapoyo' => new FactoresApoyoDB($em),
            'solicitud' => new SolicitudAdmisionDB($em),
            'datoaspirante' => new DatoAspiranteDB($em),
            'evaluacionsolicitud' => new SolicitudEvaluacionDB($em),
            'otrosprocesos' => new OtrosProcesosDB($em),
            'aplicacionentrevista' => new AplicacionEntrevistaDB($em),
            'listaasistencia' => new ListaAsistenciaDB($this->em),
            'dictamen' => new DictamenDB($em),
            'reporteasignacion' => new ReporteAsignacionDB($em),
            'configuracionbloque' => new ConfiguracionBloqueDB($em),
            'resultado' => new ResultadoDB($em),
            'tablero' => new TableroDB($em),
            'diafestivo' => new CalendaroEscolarDB($em)
        ));
    }

    //Funcion para obtener las cartas por nivel seleccionado
    public function getCartasPorNivel($nivelid)
    {
        return $this->dbManagers['dictamen']->getCartasPorNivel($nivelid);
    }

    public function BuscarDiaFestivo($filtros)
    {
        return $this->dbManagers['diafestivo']->BuscarCalendarioescolar($filtros);
    }

    /*
     * Metodo para obtener formatos con filtros
     */

    public function BuscarFormato($filtros)
    {
        return $this->dbManagers['formato']->BuscarFormato($filtros);
    }

    /*
     * Metodo para verificar relaciones formato-grados repetidos
     */

    public function ValidarRelacionFormato($tipoformatoid, $listgradosid)
    {
        return $this->dbManagers['formato']->ValidarRelacionFormato($tipoformatoid, $listgradosid);
    }

    /*
     * Metodo para obtener doucmentoporgrado con filtros
     */

    public function BuscarDocumento($filtros)
    {
        return $this->dbManagers['documento']->BuscarDocumento($filtros);
    }

    /*
     * Metodo para obtener doucmentoporgrado con filtros
     */

    public function BuscarDocumentoGrado($filtros)
    {
        return $this->dbManagers['documentoporgrado']->BuscarDocumentoGrado($filtros);
    }

    /*
     * Metodo para obtener cupos de admision con filtros
     */

    public function BuscarCupoAdmision($filtros)
    {
        return $this->dbManagers['cupoadmision']->BuscarCupoAdmision($filtros);
    }

    /*
     * Metodo para obtener Lugares por filtros de busqueda
     */

    public function BuscarLugar($filtros)
    {
        return $this->dbManagers['lugar']->BuscarLugar($filtros);
    }

    /*
     * Metodo para obtener el usuiario de un evaluador por filtros
     */

    public function BuscarEvaluador($filters)
    {
        return $this->dbManagers['evaluador']->BuscarEvaluador($filters);
    }

    /*
     * Metodo para obtener Evaluacion con filtros
     */

    public function BuscarEvaluacion($filtros)
    {
        return $this->dbManagers['evaluacion']->BuscarEvaluacion($filtros);
    }

    /*
     * Metodo para verificar relaciones evaluacion-grados repetidos
     */

    public function ValidarRelacionEvaluacion($tipoevaluacionoid, $Gradosid, $Ciclo)
    {
        return $this->dbManagers['evaluacion']->ValidarRelacionEvaluacion($tipoevaluacionoid, $Gradosid, $Ciclo);
    }

    //Funcion para obtener Eventos por filtros
    public function BuscarCalendario($filters)
    {
        return $this->dbManagers['calendarioevaluador']->BuscarCalendario($filters);
    }

    /*
     * Metodo para obtener categoriasapoyo con filtros
     */
    public function BuscarCategoriaapoyo($filtros)
    {
        return $this->dbManagers['categoriaapoyo']->BuscarCategoriaapoyo($filtros);
    }

    /*
     * Metodo para obtener factoresapoyo con filtros
     */
    public function BuscarFactoresapoyo($filtros)
    {
        return $this->dbManagers['factoresapoyo']->BuscarFactoresapoyo($filtros);
    }

    //Funcion para obtener las solicitudes de admision por filtros
    public function getSolicitudByFilter($filters)
    {
        return $this->dbManagers['solicitud']->getSolicitudByFilter($filters);
    }

    public function getNumeroDeSolicitudesValidades($gradoid, $cicloid)
    {
        return $this->dbManagers['solicitud']->getNumeroDeSolicitudesValidades($gradoid, $cicloid);
    }

    //Funcion para imprimir el recibo de inscripcion (Lux)
    public function reciboInscripcion($id)
    {
        return $this->dbManagers['solicitud']->reciboInscripcion($id);
    }

    public function BuscarVistasolicitud($id)
    {
        return $this->dbManagers['solicitud']->BuscarVistasolicitud($id);
    }

    public function getFotoBySolicitud($filtros)
    {
        return $this->dbManagers['solicitud']->getFotoBySolicitud($filtros);
    }


    //Funcion para obtener solicitudes con el mismo curp por ciclo
    public function getSolicitudExistByCURP($CURP, $cicloId, $grado, $solicitudid)
    {
        return $this->dbManagers['datoaspirante']->getSolicitudExistByCURP($CURP, $cicloId, $grado, $solicitudid);
    }

    /*
     * Metodo para obtener los eventos asignados
     */
    public function getEvaluacionesAsignadas($solicitudid)
    {
        return $this->dbManagers['evaluacionsolicitud']->getEvaluacionesAsignadas($solicitudid);
    }

    /*
     * Metodo para obtener las posibles evaluaciones ha asignar (LUX)
     */
    public function getEvaluacionesByGradoandCiclo($gradoid, $cicloId)
    {
        return $this->dbManagers['evaluacionsolicitud']->getEvaluacionesByGradoandCiclo($gradoid, $cicloId);
    }

    /*
     * Metodo para obtener la entrevista ha asignar (CIENCIAS)
     */
    public function getEntrevistaBloque($bloque, $gradoid)
    {
        return $this->dbManagers['evaluacionsolicitud']->getEntrevistaBloque($bloque, $gradoid);
    }

    /*
     * Metodo para obtener las posibles evaluaciones ha asignar (CIENCIAS)
     */
    public function getEvaluacionBloque($bloqueid, $evaluadorid, $gradoid)
    {
        return $this->dbManagers['evaluacionsolicitud']->getEvaluacionBloque($bloqueid, $evaluadorid, $gradoid);
    }

    //Funcion para obtener al evento tomando en cuenta un evaluador con menos entrevistas y tomando en cuenta el orden del apellido y nombre
    public function getEntrevistaSolicitud($cicloid, $gradoid)
    {
        return $this->dbManagers['evaluacionsolicitud']->getEntrevistaSolicitud($cicloid, $gradoid);
    }

    //Funcion para obtener al evento de entevista ha asignar a la solicitud
    public function getAltaEntrevistaByEvaluador($cicloid, $gradoid, $usiarioid)
    {
        return $this->dbManagers['evaluacionsolicitud']->getAltaEntrevistaByEvaluador($cicloid, $gradoid, $usiarioid);
    }

    /*
     * Metodo para obtener las evaluaciones que no se han asignado a una solicitud
     */
    public function getEvaluacionesFaltante($solicitudid, $gradoid, $cicloId)
    {
        return $this->dbManagers['evaluacionsolicitud']->getEvaluacionesFaltante($solicitudid, $gradoid, $cicloId);
    }

    /*
     * Obtenemos eventos del mismo examen con cupo disponible para cambiar la cita
     */
    public function getEvaluacionesCupoValidacionDatos($datos)
    {
        return $this->dbManagers['evaluacionsolicitud']->getEvaluacionesCupoValidacionDatos($datos);
    }

    /*
     * Funcion para obtener el eventos por folio
     */
    public function getEventosbyFolio($folio, $cicloid, $gradoid)
    {
        return $this->dbManagers['evaluacionsolicitud']->getEventosbyFolio($folio, $cicloid, $gradoid);
    }

    /*
     * Funcion para obtener solicitudes de otros anos de la misma persona
     */
    public function getSolicitudesTodosCiclos($CURP, $cicloId)
    {
        return $this->dbManagers['otrosprocesos']->getSolicitudesTodosCiclos($CURP, $cicloId);
    }

    /*
     * Metodo para obtener entrevista con filtros
     */

    public function BuscarAplicacionEntrevista($filtros)
    {
        return $this->dbManagers['aplicacionentrevista']->BuscarAplicacionEntrevista($filtros);
    }

    /*
     * Metodo para obtener listaasistencia con filtros
     */

    public function BuscarListaAsistencia($filtros)
    {
        return $this->dbManagers['listaasistencia']->BuscarListaAsistencia($filtros);
    }

    /*
     * Metodo para obtener listaasistencia detalle
     */

    public function BuscarListaAsistenciaDetalle($filtros)
    {
        return $this->dbManagers['listaasistencia']->BuscarListaAsistenciaDetalle($filtros);
    }

    //Funcion para obtener las cartas que falta por solicitud de admision
    public function getCartasDictamen($gradoid)
    {
        return $this->dbManagers['dictamen']->getCartasDictamen($gradoid);
    }

    //Funcion para obtener las cartas agregar automatico
    public function getCartasDictamenTipo($gradoid, $tipo)
    {
        return $this->dbManagers['dictamen']->getCartasDictamenTipo($gradoid, $tipo);
    }

    //Obtiene la cita de la entrega de resultados (LUX)
    public function getCitaEntregaResultados($solicitudid, $tipoevaluacionid)
    {
        return $this->dbManagers['dictamen']->getCitaEntregaResultados($solicitudid, $tipoevaluacionid);
    }

    //Funcion para obtener las solicitudes aceptadas para validar una dictaminacion
    public function getAceptadosByCicloGrado($cicloid, $gradoid)
    {
        return $this->dbManagers['dictamen']->getAceptadosByCicloGrado($cicloid, $gradoid);
    }

    //Funcion para obtener datos por nivel de la vista (tablero general)
    public function getBIGralSolicitudadmision($solicitudid, $nivel, $portal)
    {
        return $this->dbManagers['dictamen']->getBIGralSolicitudadmision($solicitudid, $nivel, $portal);
    }

    //Funcion para obtener las solicitudes aceptadas para validar una dictaminacion
    public function getBIEntrSolicitudadmision($solicitudid, $nivel, $portal)
    {
        return $this->dbManagers['dictamen']->getBIEntrSolicitudadmision($solicitudid, $nivel, $portal);
    }

    //Funcion para obtener las solicitudes aceptadas para validar una dictaminacion
    public function getBIPsicoSolicitudadmision($solicitudid, $nivel, $portal)
    {
        return $this->dbManagers['dictamen']->getBIPsicoSolicitudadmision($solicitudid, $nivel, $portal);
    }

    /*
     * Metodo para copiar a otro ciclo evaluaciones
     */

    public function CopiarEvaluacionCicloEvaluaciones($tipoevaluacionoid, $Ciclo)
    {
        return $this->dbManagers['evaluacion']->CopiarEvaluacionCicloEvaluaciones($tipoevaluacionoid, $Ciclo);
    }

    /*
     * Metodo para buscar reportes de asignacion por parametros
     */
    public function getReporteAsignacionByFilter($filters)
    {
        return $this->dbManagers['reporteasignacion']->getReporteAsignacionByFilter($filters);
    }

    public function getMetodoAsignacionCita()
    {
        return $this->dbManagers['configuracionbloque']->getMetodoAsignacionCita();
    }

    public function getConfiguracionBloquesConsulta($filtros)
    {
        return $this->dbManagers['configuracionbloque']->getConfiguracionBloquesConsulta($filtros);
    }

    public function getGradosPorBloque($bloquegradoid)
    {
        return $this->dbManagers['configuracionbloque']->getGradosPorBloque($bloquegradoid);
    }

    public function getBloquePorGrado($id)
    {
        return $this->dbManagers['configuracionbloque']->getBloquePorGrado($id);
    }

    public function getBloquePorGradoDatosIniciales()
    {
        return $this->dbManagers['configuracionbloque']->getBloquePorGradoDatosIniciales();
    }

    public function getBloqueGradoDelete($id)
    {
        return $this->dbManagers['configuracionbloque']->getBloqueGradoDelete($id);
    }

    /*
     * Metodo para obtener resultado con filtros
     */

    public function BuscarResultado($filtros)
    {
        return $this->dbManagers['resultado']->BuscarResultado($filtros);
    }

    public function getTableroDatosIniciales()
    {
        return $this->dbManagers['tablero']->getTableroDatosIniciales();
    }

    public function vistaprevia($query, $solicitud = false)
    {
        return $this->dbManagers['tablero']->vistaprevia($query, $solicitud);
    }

    public function getBusquedaTableroPorFiltros($filtros)
    {
        return $this->dbManagers['tablero']->getBusquedaTableroPorFiltros($filtros);
    }

    public function getTablero($id)
    {
        return $this->dbManagers['tablero']->getTablero($id);
    }

}
