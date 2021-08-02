<?php

namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use AppBundle\DB\Mysql\Controlescolar\AlumnoDB;
use AppBundle\DB\Mysql\Controlescolar\AreaAcademicaDB;
use AppBundle\DB\Mysql\Controlescolar\AsistenciaDB;
use AppBundle\DB\Mysql\Controlescolar\AvanceCalificacionesDB;
use AppBundle\DB\Mysql\Controlescolar\CapturaCalificacionesDB;
use AppBundle\DB\Mysql\Controlescolar\CapturaCalificacionReporteDB;
use AppBundle\DB\Mysql\Controlescolar\CicloDB;
use AppBundle\DB\Mysql\Controlescolar\CiudadesDB;
use AppBundle\DB\Mysql\Controlescolar\ColoniasDB;
use AppBundle\DB\Mysql\Controlescolar\ComponenteCurricularDB;
use AppBundle\DB\Mysql\Controlescolar\CronogramaDeTareasDB;
use AppBundle\DB\Mysql\Controlescolar\EdicionExtemporaneaCalificacionBD;
use AppBundle\DB\Mysql\Controlescolar\EstadosDB;
use AppBundle\DB\Mysql\Controlescolar\DirectorioEscolarDB;
use AppBundle\DB\Mysql\Controlescolar\CalendaroEscolarDB;
use AppBundle\DB\Mysql\Controlescolar\GruposDB;
use AppBundle\DB\Mysql\Controlescolar\SubGruposDB;
use AppBundle\DB\Mysql\Controlescolar\MateriaDB;
use AppBundle\DB\Mysql\Controlescolar\MotivoBajaDB;
use AppBundle\DB\Mysql\Controlescolar\PaisesDB;
use AppBundle\DB\Mysql\Controlescolar\PeriodoEvaluacionDB;
use AppBundle\DB\Mysql\Controlescolar\PlanEstudioDB;
use AppBundle\DB\Mysql\Controlescolar\PlantillaProfesorDB;
use AppBundle\DB\Mysql\Controlescolar\ProfesorDB;
use AppBundle\DB\Mysql\Controlescolar\ProfesorNivelDB;
use AppBundle\DB\Mysql\Controlescolar\RegistroIntencionReinscribirseDB;
use AppBundle\DB\Mysql\Controlescolar\EmailPadresDB;
use AppBundle\DB\Mysql\Controlescolar\TipoBajaDB;
use AppBundle\DB\Mysql\Controlescolar\BoletasDB;
use AppBundle\DB\Mysql\Controlescolar\ReporteDisciplinaDB;
use AppBundle\DB\Mysql\Controlescolar\ArmadoGruposSubgruposDB;
use AppBundle\DB\Mysql\Controlescolar\AgendaExamenDB;
use AppBundle\DB\Mysql\Controlescolar\FamiliasDB;
use AppBundle\DB\Mysql\Controlescolar\AlumnoModal\FamiliaDB;
use AppBundle\DB\Mysql\Controlescolar\AlumnoModal\ContactoEmergenciaDB;
use AppBundle\DB\Mysql\Controlescolar\AlumnoModal\DatosGeneralesDB;
use AppBundle\DB\Mysql\Controlescolar\ExtraordinarioDB;
use AppBundle\DB\Mysql\Controlescolar\AlumnoModal\AdmisionesDB;
use AppBundle\DB\Mysql\Controlescolar\AlumnoModal\SubgruposAlumnoDB;
use AppBundle\DB\Mysql\Controlescolar\AlumnoModal\AlumnoBecasDB;
use AppBundle\DB\Mysql\Controlescolar\MisClasesDB;
use AppBundle\DB\Mysql\Controlescolar\ConfTallerExtraCurricularDB;
use AppBundle\DB\Mysql\Controlescolar\TallerCurricularDB;
use AppBundle\DB\Mysql\Controlescolar\ArmadoTallerCurricularDB;
use AppBundle\DB\Mysql\Controlescolar\TallerExtracurricularDB;
use AppBundle\DB\Mysql\Controlescolar\ImportarHorariosDB;
use AppBundle\DB\Mysql\Controlescolar\ConsultaAlumnosDB;
use AppBundle\DB\Mysql\Controlescolar\ConductaDB;
use AppBundle\DB\Mysql\Controlescolar\CertificacionDB;
use AppBundle\DB\Mysql\Controlescolar\NotificacionDB;
use AppBundle\DB\Mysql\Controlescolar\IdiomaNivelDB;
use AppBundle\DB\Mysql\Controlescolar\AlumnoIdiomaNivelDB;
use AppBundle\DB\Mysql\Controlescolar\AlumnoIdiomaNivelImportarDB;
use AppBundle\DB\Mysql\Controlescolar\CalificacionExtraordinarioDB;
use AppBundle\DB\Mysql\Controlescolar\TallerBitacoraDB;
use AppBundle\DB\Mysql\Controlescolar\PeriodoRegularizacionDB;
use AppBundle\DB\Mysql\Controlescolar\ReinscripcionDB;
use AppBundle\DB\Mysql\Controlescolar\DocumentosReinscripcionDB;
use AppBundle\DB\Mysql\Controlescolar\AlumnoPerseveranciaDB;
use AppBundle\DB\Mysql\Controlescolar\ConfiguracionHorarioDB;
use AppBundle\DB\Mysql\Controlescolar\AsistenciaDiariaDB;
use AppBundle\DB\Mysql\Controlescolar\AvisoPlataformaDB;

class DbmControlescolar extends DatabaseManager{
	protected $em;
	protected $dbManagers;
	protected $objectManager;
	public function __construct(EM $em){
		parent::__construct($em);
		$this->em=$em;
		$this->dbManagers=array_merge($this->dbManagers, array(
			'avancecalificaciones'=>new AvanceCalificacionesDB($em),
			'paises'=>new PaisesDB($em),
			'estados'=>new EstadosDB($em),
			'directorioescolar'=>new DirectorioEscolarDB($em),
			'calendarioescolar'=>new CalendaroEscolarDB($em),
			'ciudades'=>new CiudadesDB($em),
			'colonias'=>new ColoniasDB($em),
			'ciclo'=>new CicloDB($em),
			'periodoevaluacion'=>new PeriodoEvaluacionDB($em),
			'asignacionmateria'=>new MisClasesDB($em),
			'capturacalificaciones'=>new CapturaCalificacionesDB($em),
			'capturacalificacionreporte'=>new CapturaCalificacionReporteDB($em),
			'alumno'=>new AlumnoDB($em),
			'alumnofamilia'=>new FamiliaDB($em),
			'alumnocontactoemergencia'=>new ContactoEmergenciaDB($em),
			'alumnodatosgenerales'=>new DatosGeneralesDB($em),
			'alumnoadmisiones'=>new AdmisionesDB($em),
			'alumnobecas'=>new AlumnoBecasDB($em),
			'planestudio'=>new PlanEstudioDB($em),
			'tipobaja'=>new TipoBajaDB($em),
			'motivobaja'=>new MotivoBajaDB($em),
			'materia'=>new MateriaDB($em),
			'profesor'=>new ProfesorDB($em),
			'profesornivel'=>new ProfesorNivelDB($em),
			'asistencia'=>new AsistenciaDB($em),
			"plantillaprofesor"=>new PlantillaProfesorDB($em),
			"cronogramadetareas"=>new CronogramaDeTareasDB($em),
			"edicionextemporanea"=>new EdicionExtemporaneaCalificacionBD($em),
			"areaacademica"=>new AreaAcademicaDB($em),
			"reportes"=>new EmailPadresDB($em),
			"componentecurricular"=>new ComponenteCurricularDB($em),
			"grupos"=>new GruposDB($em),
			"subgrupos"=>new SubGruposDB($em),
			"registrointencionreinscribirse"=>new RegistroIntencionReinscribirseDB($em),
			"armadogrupossubgrupos"=>new ArmadoGruposSubgruposDB($em),
			"extraordinario"=>new ExtraordinarioDB($em),
			"agendaexamen"=>new AgendaExamenDB($em),
			"familias"=>new FamiliasDB($em),
			"boletas"=>new BoletasDB($em),
			"reportedisciplina"=>new ReporteDisciplinaDB($em),
			"conftallerextracurricular"=>new ConfTallerExtraCurricularDB($em),
			"tallercurricular"=>new TallerCurricularDB($em),
			"tallerextracurricular"=>new TallerExtracurricularDB($em),
			"aramadotallercurricular"=>new ArmadoTallerCurricularDB($em),
			"importarhorarios"=>new ImportarHorariosDB($em),
			"consultaalumnos"=>new ConsultaAlumnosDB($em),
			"conducta"=>new ConductaDB($em),
			"certificacion"=>new CertificacionDB($em),
			"notificacion"=>new NotificacionDB($em),
			"idiomanivel"=>new IdiomaNivelDB($em),
			"alumnoidiomanivel"=>new AlumnoIdiomaNivelDB($em),
			"alumnoidiomanivelimportar"=>new AlumnoIdiomaNivelImportarDB($em),
			"calificacionextraordinario"=>new CalificacionExtraordinarioDB($em),
			"tallerbitacora"=>new TallerBitacoraDB($em),
			"periodoregularizacion"=>new PeriodoRegularizacionDB($em),
			"alumnosubgrupos"=>new SubgruposAlumnoDB($em),
			"reinscripcion"=>new ReinscripcionDB($em),
			"documentosreinscripcion"=>new DocumentosReinscripcionDB($em),
			"alumnoperseverancia"=>new AlumnoPerseveranciaDB($em),
			"configuracionhorario"=>new ConfiguracionHorarioDB($em),
			"asistenciadiaria"=>new AsistenciaDiariaDB($em),
			"avisoplataforma"=>new AvisoPlataformaDB($em)
		));
	}

	public function BuscarNotificaciones($filtros){
		return $this->dbManagers['notificacion']->BuscarNotificaciones($filtros);
	}
	public function getPagodetalle($filtros){
		return $this->dbManagers['conftallerextracurricular']->getPagodetalle($filtros);
	}
	public function BuscarCertificaciones($filtros){
		return $this->dbManagers['certificacion']->BuscarCertificaciones($filtros);
	}
	public function BuscarTablaHorario($filtros){
		return $this->dbManagers['importarhorarios']->BuscarTablaHorario($filtros);
	}
	public function getTalleres($filtros){
		return $this->dbManagers['importarhorarios']->getTalleres($filtros);
	}
	public function getHorarioFiltros($filtros, $all){
		return $this->dbManagers['importarhorarios']->getFiltros($filtros, $all);
	}
	public function getProfesorPorMateria($filtros){
		return $this->dbManagers['importarhorarios']->getProfesorPorMateria($filtros);
	}
	public function getProfesoresPorHorario($filtros){
		return $this->dbManagers['importarhorarios']->getProfesoresPorHorario($filtros);
	}
	public function getALumnosportallergrupo($filtros){
		return $this->dbManagers['importarhorarios']->getALumnosportallergrupo($filtros);
	}
	/*
	 * Método para buscar la info del alumno
	 */
	public function BuscarCicloGradoAlumno($id){
		return $this->dbManagers['conftallerextracurricular']->BuscarCicloGradoAlumno($id);
	}
	/*
	 * Método para buscar la info del alumno
	 */
	public function BuscarInfoAlumno($id){
		return $this->dbManagers['tallercurricular']->BuscarInfoAlumno($id);
	}
	/*
	 * Método para buscar los reportes de disciplina
	 */
	public function BuscarReportes($filtros){
		return $this->dbManagers['reportedisciplina']->BuscarReportes($filtros);
	}
	/*
	 * Método para buscar los extraordinarios por alumno
	 */
	public function BuscarBoletas($filtros){
		return $this->dbManagers['boletas']->BuscarBoletas($filtros);
	}
	/*
	 * Método para buscar los extraordinarios por alumno
	 */
	public function BuscarExtraordinarioAlumno($id,$alucicloid, $periodo){
		return $this->dbManagers['extraordinario']->BuscarExtraordinarioAlumno($id,$alucicloid, $periodo);
	}
	/*
	 * Método para buscar si el alumno es apto para agendar un curso
	 */
	public function CheckCursoAlumno($filtros){
		return $this->dbManagers['extraordinario']->CheckCursoAlumno($filtros);
	}
	public function UltimoAcuerdoPorAgenda($id, $nnull){
		return $this->dbManagers['extraordinario']->UltimoAcuerdoPorAgenda($id, $nnull);
	}
	/*
	 * Método para buscar los extraordinarios por alumno
	 */
	public function BuscarPeriodos(){
		return $this->dbManagers['extraordinario']->BuscarPeriodos();
	}
	/*
	 * Método para buscar los extraordinarios
	 */
	public function BuscarExtraordinario($filtros){
		return $this->dbManagers['extraordinario']->BuscarExtraordinario($filtros);
	}
	/*
	 * Método para buscar las fechas de las agendas de cada alumno
	 */
	public function BuscarAlumnoPadreFamilia($tipo, $clave, $clavefamilar){
		return $this->dbManagers['familias']->BuscarAlumnoPadreFamilia($tipo, $clave, $clavefamilar);
	}
	/*
	 * Método para buscar las fechas de las agendas de cada alumno
	 */
	public function BuscarAlumnoClaves($tipo, $clave){
		return $this->dbManagers['familias']->BuscarAlumnoClaves($tipo, $clave);
	}
	/*
	 * Método para buscar las fechas de las agendas de cada alumno
	 */
	public function BuscarClavesfamiliares($filtros){
		return $this->dbManagers['familias']->BuscarClavesfamiliares($filtros);
	}
	/*
	 * Método para buscar las fechas de las agendas de cada alumno
	 */
	public function BuscarPadresFamilia($filtros){
		return $this->dbManagers['familias']->BuscarPadresFamilia($filtros);
	}
	/*
	 * Método para buscar las agendas por acuerdo
	 */
	public function BuscarAgendaporAcuerdo($filtros, $periodo){
		return $this->dbManagers['agendaexamen']->BuscarAgendaporAcuerdo($filtros, $periodo);
	}
	/*
	 * Método para buscar las fechas de las agendas de cada alumno
	 */
	public function BuscarAcuerdosporAgenda($id){
		return $this->dbManagers['agendaexamen']->BuscarAcuerdosporAgenda($id);
	}
	/*
	 * Método para buscar las fechas de las agendas de cada alumno
	 */
	public function BuscarFechaextraordinario($id, $alumno){
		return $this->dbManagers['agendaexamen']->BuscarFechaextraordinario($id, $alumno);
	}
	/*
	 * Método para buscar los alumnos con extraordinario con su respectivo acuerdo extraordinario
	 */
	public function BuscarAcuerdoAlumno($id){
		return $this->dbManagers['agendaexamen']->BuscarAcuerdoAlumno($id);
	}
	/*
	 * Método para buscar los acuerdos de extraordinario con estatus "acordado"
	 */
	public function BuscarAcuerdosA($filtros){
		return $this->dbManagers['agendaexamen']->BuscarAcuerdosA($filtros);
	}
	/*
	 * Método para filtrar la informacion de agenda extraordinario
	 */
	public function FiltrarAgenda($filtros){
		return $this->dbManagers['agendaexamen']->FiltrarAgenda($filtros);
	}
	/*
	 * Método para obtener las materias que cuenten con extraordinario y con estatus de extraordinario distinto a aprovado
	 */
	public function BuscarMateriaporExtraordinario(){
		return $this->dbManagers['agendaexamen']->BuscarMateriaporExtraordinario();
	}
	/*
	 * Método para obtener los extraordinarios con estatus distinto a "Aprovado"
	 */
	public function FiltrarProfesores($filtros){
		return $this->dbManagers['agendaexamen']->FiltrarProfesores($filtros);
	}
	/*
	 * Método para obtener los datos de alumnos
	 */
	public function ObtenerAlumnosDatos($filtros){
		return $this->dbManagers['reportes']->ObtenerAlumnosDatos($filtros);
	}
	/*
	 * Metodo para obtener los calendarioescolar
	 */
	public function BuscarCalendarioescolar($filtros){
		return $this->dbManagers['calendarioescolar']->BuscarCalendarioescolar($filtros);
	}
	/*
	 * Metodo para obtener los directorios escolares
	 */
	public function BuscarDirectorios($filtros){
		return $this->dbManagers['directorioescolar']->BuscarDirectorios($filtros);
	}
	/*
	 * Metodo para obtener los grupos
	 */
	public function BuscarGrupos($filtros){
		return $this->dbManagers['grupos']->BuscarGrupos($filtros);
	}
	/*
	 * Metodo para obtener los subgrupos de tipo divisor
	 */
	public function BuscarSubgruposDivisor($filtros){
		return $this->dbManagers['subgrupos']->BuscarSubgruposDivisor($filtros);
	}
	/*
	 * Metodo para obtener las materias de un plan de estudio
	 */
	public function GetUltimoPeriodo($conjuntoperiodoevaluacionid){
		return $this->dbManagers['capturacalificaciones']->GetUltimoPeriodo($conjuntoperiodoevaluacionid);
	}
	/*
	 * Metodo para obtener las materias de un plan de estudio
	 */
	public function getMateriasPorPlanEstudio($filtros){
		return $this->dbManagers['planestudio']->getMateriasPorPlanEstudio($filtros);
	}
	/*
	 * Metodo para obtener ponderaciones
	 */
	public function BuscarPonderaciones($filtros){
		return $this->dbManagers['componentecurricular']->BuscarPonderaciones($filtros);
	}
	/*
	 * Metodo para obtener componentes curriculares
	 */
	public function BuscarComponentesCurriculares($filtros){
		return $this->dbManagers['componentecurricular']->BuscarComponentesCurriculares($filtros);
	}
	/*
	 * Metodo para obtener paises con filtros
	 */
	public function BuscarPaises($filtros){
		return $this->dbManagers['paises']->BuscarPaises($filtros);
	}
	/*
	 * Metodo para obtener estados con filtros
	 */
	public function BuscarEstados($filtros){
		return $this->dbManagers['estados']->BuscarEstados($filtros);
	}
	/*
	 * Metodo para obtener ciudades con filtros
	 */
	public function BuscarCiudades($filtros){
		return $this->dbManagers['ciudades']->BuscarCiudades($filtros);
	}
	/*
	 * Metodo para obtener colonias con filtros
	 */
	public function BuscarColonias($filtros){
		return $this->dbManagers['colonias']->BuscarColonias($filtros);
	}
	/*
	 * Metodo para obtener la calificacion del periodo del alumno
	 */
	public function CalculaCalificacionPeriodo($calificacionperiodoporalumnoid){
		return $this->dbManagers['capturacalificaciones']->CalculaCalificacionPeriodo($calificacionperiodoporalumnoid);
	}
	/*
	 * Metodo para obtener los datos del alumno
	 */
	public function BuscarDatosAlumno($alumnoid){
		return $this->dbManagers['cronogramadetareas']->BuscarDatosAlumno($alumnoid);
	}
	/*
	 * Metodo para obtener las tareas del alumno
	 */
	public function BuscarTareasAlumnoPortal($alumnoid, $alumnociclo, $pmpe){
		return $this->dbManagers['cronogramadetareas']->BuscarTareasAlumnoPortal($alumnoid, $alumnociclo, $pmpe);
	}
	/*
	 * Metodo para obtener areas con filtros
	 */
	public function BuscarAreas($filtros){
		return $this->dbManagers['areaacademica']->BuscarAreas($filtros);
	}
	/*
	 * Metodo para obtener las comentarios de una tarea
	 */
	public function BuscarComentarios($tareaid, $alumnoid){
		return $this->dbManagers['cronogramadetareas']->BuscarComentarios($tareaid, $alumnoid);
	}
	/*
	 * Metodo para obtener las comentarios de una tarea
	 */
	public function BuscarComentariosApp($tareaid, $alumnoid){
		return $this->dbManagers['cronogramadetareas']->BuscarComentariosApp($tareaid, $alumnoid);
	}

	/*
	 * Metodo para obtener las tareas de los alumnos
	 */
	public function BuscarTareasAlumno($tareaid, $grupoid){
		return $this->dbManagers['cronogramadetareas']->BuscarTareasAlumno($tareaid, $grupoid);
	}
	/*
	 * Metodo para obtener los datos referenciados a las tareas
	 */
	public function BuscarTareas($profesorpormateriaplanestudiosid){
		return $this->dbManagers['cronogramadetareas']->BuscarTareas($profesorpormateriaplanestudiosid);
	}
	/*
	 * Metodo para obtener los datos referenciados a las tareas
	 */
	public function BuscarAsignacionProfesor($profesorpormateriaplanestudiosid){
		return $this->dbManagers['cronogramadetareas']->BuscarAsignacionProfesor($profesorpormateriaplanestudiosid);
	}

	/*
	 * Metodo para obtener las inasistencias del alumno [Nuevo]
	 */
	public function getFaltasAlumnoLD($alumnocicloid,$profesormateriaplanestudioid,$periodoevaluacionid=null){
		$where=[
				["tipoasistenciaid",["=",2]],
				["estatusinasistenciaid",["=","1"]],
				["alumnoporcicloid",["=",$alumnocicloid]],
				["profesorpormateriaplanestudioid",["=",$profesormateriaplanestudioid]]
			];
		//echo "$alumnocicloid,$profesormateriaplanestudioid\n\n";
		if($periodoevaluacionid){
			$periododata=$this->getRepositoriosModelo("CePeriodoevaluacion",["IDENTITY(d.conjuntoperiodoevaluacionid) AS conjuntoperiodoevaluacionid","d.fechainicio"],["periodoevaluacionid"=>$periodoevaluacionid]);
			if($periododata){
				$periododata=$periododata[0];
				$where[]=["fecha",[">=",$periododata['fechainicio']]];
				$periodondata=$this->getRepositoriosModelo("CePeriodoevaluacion",["d.fechainicio"],["periodoevaluacionid"=>$periodoevaluacionid+1,"conjuntoperiodoevaluacionid"=>$periododata['conjuntoperiodoevaluacionid']]);
				if($periodondata){
					$periodondata=$periodondata[0];
					$where[]=["fecha",["<",$periodondata['fechainicio']]];
				}
			}
		}
		$data=$this->getRepositoriosModelo("CeAsistencia", ["d"], $where, false, true);
		return $data;
	}


	/*
	 * Metodo para obtener el permiso especial de profesores
	 */
	public function BuscarPermisoProfesor($filtros){
		return $this->dbManagers['asistencia']->BuscarPermisoProfesor($filtros);
	}
	/*
	 * Metodo para obtener asistencias
	 */
	public function BuscarAsistencias($filtros){
		return $this->dbManagers['asistencia']->BuscarAsistencias($filtros);
	}
    
    public function getAsistenciaProfesor($filtros){
		return $this->dbManagers['asistencia']->getAsistenciaProfesor($filtros);
	}
	/*
	 * Metodo para obtener inasistencias
	 */
	public function BuscarInasistencias($filtros){
		return $this->dbManagers['asistencia']->BuscarInasistencias($filtros);
	}
	/*
	 * Metodo para obtener municipios con filtros
	 */
	public function BuscarCP($filtros){
		return $this->dbManagers['profesor']->BuscarCP($filtros);
	}
	/*
	 * Metodo para obtener la foto de un profesor
	 */
	public function BuscarFotoProfesor($filtros){
		return $this->dbManagers['profesor']->BuscarFotoProfesor($filtros);
	}
	/*
	 * Metodo para obtener profesores con filtros
	 */
	public function BuscarProfesorfiltro($filtros){
		return $this->dbManagers['profesor']->BuscarProfesorfiltro($filtros);
	}
	/*
	 * Metodo para obtener profesores con filtros
	 */
	public function BuscarProfesorfiltroNivel($filtros){
		return $this->dbManagers['profesor']->BuscarProfesorfiltroNivel($filtros);
	}
	/*
	 * Metodo para obtener ciclos escolares con filtros
	 */
	public function BuscarCiclo($filtros){
		return $this->dbManagers['ciclo']->BuscarCiclo($filtros);
	}
	/*
	 * Metodo para obtener periodos de evaluacion con filtros
	 */
	public function BuscarPeriodoEvaluacion($filtros){
		return $this->dbManagers['periodoevaluacion']->BuscarPeriodoEvaluacion($filtros);
	}
	//------------ Asignacion de Materias ---------

	/*
	 * Método para obtener los profesores por usuarioid
	 */
	public function BuscarProfesorPorUsuarioId($usuarioid){
		return $this->dbManagers['asignacionmateria']->BuscarProfesorPorUsuarioId($usuarioid);
	}
	/*
	 * Método para obtener las asignaciones de materias por filtros
	 */
	public function BuscarAsignacionmateria($filtros){
		return $this->dbManagers['asignacionmateria']->BuscarAsignacionmateria($filtros);
	}
	/*
	 * Método para obtener los periodos de evaluacion con ciclo y grado
	 */
	public function GetGradoporconjuntoperiodoescolar(){
		return $this->dbManagers['asignacionmateria']->GetGradoporconjuntoperiodoescolar();
	}

	//---------------- Captura calificaciones ------

	/*
	 * Método para obtener los periodos por ciclo y grado
	 */
	public function BuscarPeriodoPorCicloGrado($cicloid, $gradoid){
		return $this->dbManagers['capturacalificaciones']->BuscarPeriodoPorCicloGrado($cicloid, $gradoid);
	}


	/*
	 * Método para obtener los periodos por ciclo y grado
	 */
	public function CriteriosEvaluacionGrupo($periodoid, $profesorpormateriaplanestudiosid){
		return $this->dbManagers['capturacalificaciones']->CriteriosEvaluacionGrupo($periodoid, $profesorpormateriaplanestudiosid);
	}

	/*
	 * Método para obtener los alumnos de un grupo en un ciclo determinado
	 */
	public function AlumnoCicloGrupo($cicloid, $grupoid, $alumnoid, $taller = false, $activeOverride=false){
		return $this->dbManagers['capturacalificaciones']->AlumnoCicloGrupo($cicloid, $grupoid, $alumnoid, $taller, $activeOverride);
	}

	/*
	 * Método para obtener los datos de la tabla capturacalificacionporalumno
	 */
	public function CapturaCalificacionDatos($id){
		return $this->dbManagers['capturacalificaciones']->CapturaCalificacionDatos($id);
	}


	/*
	 * Método para obtener los datos del gurpo en calificaciones
	 */
	public function GetDatoGrupoCalificacion($periodoevaluacionid, $profesorpormateriaplanestudiosid){
		return $this->dbManagers['capturacalificaciones']->GetDatoGrupoCalificacion( $periodoevaluacionid, $profesorpormateriaplanestudiosid);
	}

	//---------------- Datos del alumno ------
	/*
	 * Método para obtener los datos de la tabla capturacalificacionporalumno
	 */
	public function GetAlumno($filtros){
		return $this->dbManagers['alumno']->GetAlumno($filtros);
	}
	/*
	 * Método para obtener los datos de la tabla capturacalificacionporalumno
	 */
	public function GetDomicilioAlumno($alumnoid){
		return $this->dbManagers['alumnodatosgenerales']->GetDomicilioAlumno($alumnoid);
	}
	/*
	 * Método para obtener los datos generales del padre o tutor
	 */
	public function GetPadreTutorAlumno($clavefamiliarid){
		return $this->dbManagers['alumnofamilia']->GetPadreTutorAlumno($clavefamiliarid);
	}
	/*
	 * Método para regresar la nacionalidad del padre o tutor
	 */
	public function GetNacionalidadPadreoTutor($id){
		return $this->dbManagers['alumnofamilia']->GetNacionalidadPadreoTutor($id);
	}
	/*
	 * Método para regresar la nacionalidad del alumno
	 */
	public function GetNacionalidadAlumno($alumnoid){
		return $this->dbManagers['alumno']->GetNacionalidadAlumno($alumnoid);
	}
	/*
	 * Método para regresar el contacto de emergencia de un alumno
	 */
	public function GetContactoEmergenciaAlumno($alumnoid){
		return $this->dbManagers['alumnocontactoemergencia']->GetContactoEmergenciaAlumno($alumnoid);
	}
	/*
	 * Método para regresar los datos generales alumno
	 */
	public function GetDatosGeneralesAlumno($alumnoid){
		return $this->dbManagers['alumnodatosgenerales']->GetDatosGeneralesAlumno($alumnoid);
	}
	//Funcion para buscar alumnos con filtros de busqueda
	public function BuscarAlumnosA($filtros){
		return $this->dbManagers['alumno']->BuscarAlumnos($filtros);
	}
	public function getAlumnoSolicitudByFilter($filtros){
		return $this->dbManagers['alumnoadmisiones']->getAlumnoSolicitudByFilter($filtros);
	}
	public function AlumnoBuscarBecas($filtros){
		return $this->dbManagers['alumnobecas']->AlumnoBuscarBecas($filtros);
	}
	//Funcion para buscar el adeudo total de un alumno
	public function BuscarAdeudoTotalAlumno($filtros){
		return $this->dbManagers['alumno']->BuscarAdeudoTotalAlumno($filtros);
	}
	//Funcion para buscar loas edeudos de un alumno
	public function BuscarAdeudoAlumno($filtros){
		return $this->dbManagers['alumno']->BuscarAdeudoAlumno($filtros);
	}
	//Funcion para buscar el recibo de inscripcion del alumno
	public function BuscarReciboInscripcionAlumno($filtros){
		return $this->dbManagers['alumno']->BuscarReciboInscripcionAlumno($filtros);
	}
	//Funcion para buscar el estado de cuenta del alumno
	public function BuscarEstadocuenta($filtros){
		return $this->dbManagers['alumno']->BuscarEstadocuenta($filtros);
	}
	//Funcion para buscar el estado de cuenta del alumno
	public function GetExamenesAlumno($filtros){
		return $this->dbManagers['alumno']->GetExamenesAlumno($filtros);
	}
	//Funcion para buscar el estado de cuenta del alumno
	public function GetPeriodosevaluacionbyAlumno($filtros){
		return $this->dbManagers['alumno']->GetPeriodosevaluacionbyAlumno($filtros);
	}	
	/*
	 * Método para regresar la situacion actual del alumno
	 */
	public function GetSituacionActualAlumno($alumnoid){
		return $this->dbManagers['alumno']->GetSituacionActualAlumno($alumnoid);
	}
	/*
	 * Método para obtener la fecha de egreso del alumno
	 */
	public function GetFechaIngreso($alumnoid){
		return $this->dbManagers['alumno']->GetFechaIngreso($alumnoid);
	}
	/*
	 * Metodo para obtener planes de estudio con filtros
	 */
	public function BuscarPlanestudio($filtros){
		return $this->dbManagers['planestudio']->BuscarPlanestudio($filtros);
	}
	/*
	 * Metodo para obtener las materias por grado
	 */
	public function FiltrarMateriasPorGrado($filtros){
		return $this->dbManagers['planestudio']->FiltrarMateriasPorGrado($filtros);
	}
	/*
	 * Metodo para obtener las materias por plan de estudios
	 */
	public function FiltrarMateriasPorPlanEstudio($filtros){
		return $this->dbManagers['planestudio']->FiltrarMateriasPorPlanEstudio($filtros);
	}
	/*
	 * Metodo para obtener las Criterios de evaluacion
	 */
	public function ObtenerCriteriosEvaluacion($filtros){
		return $this->dbManagers['planestudio']->ObtenerCriteriosEvaluacion($filtros);
	}

	/*
	 * Metodo para obtener las Alumnos que están en un plan de estudios
	 */
	public function getFotosAlumnos($alumnoid){
		return $this->dbManagers['alumno']->getFotosAlumnos($alumnoid);
	}

	/*
	 * Metodo para obtener las Materias que están en un plan de estudios
	 */
	public function FiltrarPlanesEstudios($filtros){
		return $this->dbManagers['planestudio']->FiltrarPlanesEstudios($filtros);
	}
	/*
	 * Metodo para obtener las Materias
	 */
	public function FiltrarMaterias($filtros){
		return $this->dbManagers['materia']->FiltrarMaterias($filtros);
	}
	/*
	 * Metodo para obtener las Materias por Nivel
	 */
	public function FiltrarMateriasPorNivel($filtros){
		return $this->dbManagers['materia']->FiltrarMateriasPorNivel($filtros);
	}
	/*
	 * Metodo para obtener los tipos de bajas
	 */
	public function Buscartiposbaja($filtros){
		return $this->dbManagers['tipobaja']->Buscartiposbaja($filtros);
	}
	/*
	 * Metodo para eliminar tipo de bajas
	 */
	public function eliminartipodebaja($filtros){
		return $this->dbManagers['tipobaja']->eliminartipodebaja($filtros);
	}
	/*
	 * Metodo para filtro motivo de baja
	 */
	public function BuscarMotivobaja($filtros){
		return $this->dbManagers['motivobaja']->BuscarMotivobaja($filtros);
	}
	/*
	 * Metodo para filtro profesores por nivel
	 */
	public function FiltrarProfesoresPorNivel($filtros){
		return $this->dbManagers['profesornivel']->FiltrarProfesoresPorNivel($filtros);
	}
	/*
	 * Metodo para filtro profesores por nivel que no estén
	 */
	public function FiltrarProfesoresPorNivelFaltantes($filtros){
		return $this->dbManagers['profesornivel']->FiltrarProfesoresPorNivelFaltantes($filtros);
	}
	/*
	 * Metodo para filtro Usuarios
	 */
	public function BuscarUsuarioFiltros($filtros){
		return $this->dbManagers['plantillaprofesor']->BuscarUsuarioFiltros($filtros);
	}
	/*
	 * Metodo para filtro Plantilla profesor
	 */
	public function FiltrarPlantillaProfesor($filtros){
		return $this->dbManagers['plantillaprofesor']->FiltrarPlantillaProfesor($filtros);
	}
	/*
	 * Metodo para filtro Plantilla profesor regular
	 */
	public function FiltrarDetallePlantillaProfesorRegular($filtros){
		return $this->dbManagers['plantillaprofesor']->FiltrarDetallePlantillaProfesorRegular($filtros);
	}
	/*
	 * Metodo para filtro Plantilla profesor regular
	 */
	public function FiltrarDetallePlantillaProfesorEspecial($filtros){
		return $this->dbManagers['plantillaprofesor']->FiltrarDetallePlantillaProfesorEspecial($filtros);
	}
	/*
	 * Metodo para filtro Plantilla profesor regular
	 */
	public function FiltrarMateriasPorPlanEstudioTest($filtros){
		return $this->dbManagers['planestudio']->FiltrarMateriasPorPlanEstudioTest($filtros);
	}
	/*
	 * Método para obtener los alumnos de las solicitudes de edición extemporanea
	 */
	public function ObtenerAlumnosEdicionExtemporanea($filtros){
		return $this->dbManagers['edicionextemporanea']->ObtenerAlumnosEdicionExtemporanea($filtros);
	}
	/*
	 * Método para obtener filtrar las solicitudes de edción extemporanea
	 */
	public function ObtenerSolicitudesEdicionExtemporanea($filtros){
		return $this->dbManagers['edicionextemporanea']->ObtenerSolicitudesEdicionExtemporanea($filtros);
	}
	/*
	 * Metodo para Obtener el Periodo con Fechas inicio y fin juntas
	 */
	public function obtenerReporteMaterias($filtros){
		return $this->dbManagers['materia']->obtenerReporteMaterias($filtros);
	}
	/*
	 * Método para obtener los correos de los padres de los alumnos por ciclo y otros filtros
	 */
	public function ObtenerCorreosPadresAlumnos($filtros){
		return $this->dbManagers['reportes']->ObtenerCorreosPadresAlumnos($filtros);
	}

	public function ObtenerCorreosPadresFamilia($filtros){
		return $this->dbManagers['reportes']->ObtenerCorreosPadresFamilia($filtros);
	}
	/*
	 * Método para obtener datos del usuario
	 */
	public function ObtenerUsuario($filtros){
		return $this->dbManagers['edicionextemporanea']->ObtenerUsuario($filtros);
	}
	/*
	 * Metodo para filtro Reporte Maestros Materias
	 */
	public function ReporteMaestrosMaterias($filtros){
		return $this->dbManagers['plantillaprofesor']->ReporteMaestrosMaterias($filtros);
	}
	/*
	 * Método para obtener datos del alumnos
	 */
	public function ObtenerAlumnos($filtros){
		return $this->dbManagers['edicionextemporanea']->ObtenerAlumnos($filtros);
	}
	/*
	 * Método para obtener datos del alumnos
	 */
	public function ObtenerAlumnosPermitidos($filtros){
		return $this->dbManagers['edicionextemporanea']->ObtenerAlumnosPermitidos($filtros);
	}
	/*
	 * Metodo para obtener las intenciones de reinscripcion
	 */
	private function GetAlumnoPromedioFinal(&$data){
		foreach($data AS &$idata){
			$promedios=\AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController::getPromedioFinalByAlumnociclo($this, $idata["alumnoporcicloid"]);
			if($promedios && !empty($promedios)){
				$idata["promedio"]=(double)$promedios[0];
			}
			unset($idata);
		}
	}
	public function GetAlumnoporCiclo($filtros, $calcPromedio=false){
		$data=$this->dbManagers['registrointencionreinscribirse']->GetAlumnoporCiclo($filtros);
		if($calcPromedio){
			$this->GetAlumnoPromedioFinal($data);
			$newData=[];
			$promedioEval=(empty($filtros["cuentaconpromedio"]) || !isset($filtros["promedio"]) ? null : (double) $filtros["promedio"]);
			foreach($data AS $idata){
				if($promedioEval===null || $promedioEval<=$idata["promedio"]){
					$newData[]=$idata;
				}
			}
			$data=$newData;
		}
		return $data;
	}
	/**
	 * Metodo para obtener los alumnos por ciclo y grado para filtrar por grupo
	 */
	public function getAlumnosCicloPorGrupo($ciclo, $grado, $grupo=NULL, $calcPromedio=false){
		$data=$this->dbManagers['armadogrupossubgrupos']->getAlumnosCicloPorGrupo($ciclo, $grado, $grupo);
		if($calcPromedio){
			$this->GetAlumnoPromedioFinal($data);
		}
		return $data;
	}
	public function getAlumnosCicloPorGrupoOrigen($gruposorigen, $subgrupos, $cicloid, $calcPromedio=false){
		$data=$this->dbManagers['armadogrupossubgrupos']->getAlumnosCicloPorGrupoOrigen($gruposorigen, $subgrupos, $cicloid);
		if($calcPromedio){
			$this->GetAlumnoPromedioFinal($data);
		}
		return $data;
	}
	public function getSubgrupos($subgrupos){
		return $this->dbManagers['armadogrupossubgrupos']->getSubgrupos($subgrupos);
	}

	public function getDatosCalificarTarea($tareaalumnoid, $materiaid){
		return $this->dbManagers['capturacalificaciones']->getDatosCalificarTarea($tareaalumnoid, $materiaid);
	}
	public function getRoundedValueByFunctionName($tareaalumnoid, $materiaid){
		return $this->dbManagers['capturacalificaciones']->getRoundedValueByFunctionName($tareaalumnoid, $materiaid);
	}
	public function getRoundFunctionNameByMateriaplanestudio($materiaplanestudioid){
		return $this->dbManagers['capturacalificaciones']->getRoundFunctionNameByMateriaplanestudio($materiaplanestudioid);
	}
	public function getOpcionesByMateriaporplanestudio($materiaplanestudioid){
		return $this->dbManagers['capturacalificaciones']->getOpcionesByMateriaporplanestudio($materiaplanestudioid);
	}
	public function deletePeriodosInscripcionExtra(){
		return $this->dbManagers['conftallerextracurricular']->deletePeriodosInscripcionExtra();
	}
	public function obtenerAlumnoTallerExtracurricular($id){
		return $this->dbManagers['conftallerextracurricular']->obtenerAlumnoTallerExtracurricular($id);
	}
	public function getTalleresExtracurricularesPorGrado($gradoid, $cicloid){
		return $this->dbManagers['conftallerextracurricular']->getTalleresExtracurricularesPorGrado($gradoid, $cicloid);
	}
	public function getTalleresCurriculares($filtros){
		return $this->dbManagers['aramadotallercurricular']->getTalleresCurriculares($filtros);
	}
	public function BuscarTallerescursadosporalumno($id){
		return $this->dbManagers['aramadotallercurricular']->BuscarTallerescursadosporalumno($id);
	}
	public function getMateriasporalumno($gradoid, $cicloid){
		return $this->dbManagers['aramadotallercurricular']->getMateriasporalumno($gradoid, $cicloid);
	}
	public function getTalleresPorMateriaplanestudio($materiaid, $cicloid){
		return $this->dbManagers['aramadotallercurricular']->getTalleresPorMateriaplanestudio($materiaid, $cicloid);
	}
	public function BuscarPreregistrotalleres($id){
		return $this->dbManagers['aramadotallercurricular']->BuscarPreregistrotalleres($id);
	}
	public function getAlumnosPorTallerCurricular($filtros){
		return $this->dbManagers['aramadotallercurricular']->getAlumnosPorTallerCurricular($filtros);
	}
	public function getAlumnosPorTallerCurricularRotacion($filtros){
		return $this->dbManagers['aramadotallercurricular']->getAlumnosPorTallerCurricularRotacion($filtros);
	}
	public function BuscarTokens($alumnoid){
		return $this->dbManagers['alumno']->BuscarTokens($alumnoid);
	}
	public function getBasicCiclo(){
		return $this->getRepositoriosModelo("Ciclo", ["d.cicloid AS id", "d.cicloid", "d.nombre", "d.actual", "d.siguiente"], ["activo"=>1]);
	}
	public function getBasicNivel(){
		return $this->getRepositoriosModelo("Nivel", ["d.nivelid AS id", "d.nivelid", "d.nombre", "d.requieresemestre"], ["activo"=>1]);
	}
	public function getBasicSemestre(){
		return $this->getRepositoriosModelo("CeSemestre", ["d.semestreid AS id", "d.semestreid", "d.nombre"], ["activo"=>1]);
	}
	public function getBasicGrado(){
		return $this->getRepositoriosModelo("Grado", ["d.gradoid AS id", "d.gradoid", "IDENTITY(d.nivelid) AS nivelid", "IDENTITY(d.semestreid) AS semestreid", "d.grado AS nombre", "d.grado"], ["activo"=>1]);
	}
	public function getBasicGrupoCurricular(){
		return $this->getRepositoriosModelo("CeGrupo", ["d.grupoid AS id", "d.grupoid", "IDENTITY(d.cicloid) AS cicloid", "IDENTITY(d.gradoid) AS gradoid", "d.nombre"], ["tipogrupoid"=>1]);
	}
	public function getBasicMateria(){
		return $this->getRepositoriosModelo("Materia", ["d.materiaid AS id", "d.materiaid", "d.nombre"], ["activo"=>1]);
	}
	public function getBasicPlanEstudio(){
		return $this->getRepositoriosModelo("CePlanestudios", ["d.planestudioid AS id", "d.planestudioid", "IDENTITY(d.gradoid) AS gradoid", "IDENTITY(d.cicloinicialid) AS cicloinicialid", "IDENTITY(d.ciclofinalid) AS ciclofinalid", "d.nombre"]);
	}
	public function getBasicPeriodoRegularizacion(){
		return $this->getRepositoriosModelo("CePeriodoregularizacion", ["d.periodoregularizacionid AS id", "d.periodoregularizacionid", "IDENTITY(d.cicloid) AS cicloid", "d.nombre"], ["activo"=>1]);
	}
	public function getBasicClasificadorParaescolar(){
		return $this->getRepositoriosModelo("CeClasificadorparaescolares", ["d.clasificadorparaescolaresid AS id", "d.clasificadorparaescolaresid", "d.nombre"], ["activo"=>1]);
	}
	public function getBasicProfesor(){
		return $this->getRepositoriosModelo("CeProfesor", ["d.profesorid AS id", "d.profesorid", "CONCAT_WS(' ',d.apellidopaterno,d.apellidomaterno,d.nombre) AS nombre"], ["estatusempleadoid"=>1], ['nombre'=>'ASC']);
	}
	public function getBasicIdioma(){
		return $this->getRepositoriosModelo("CeIdioma", ["d.idiomaid AS id", "d.idiomaid", "d.nombre"], ["activo"=>1], ["idiomaid"=>"ASC"]);
	}
	public function getBasicIdiomaNivel(){
		return $this->getRepositoriosModelo("CeIdiomanivel", ["d.idiomanivelid AS id", "d.idiomanivelid", "IDENTITY(d.idiomaid) AS idiomaid", "d.nombre"], ["activo"=>1], ["idiomaid"=>"ASC", "orden"=>"ASC"]);
	}
	public function getBasicMateriaPlanEstudioRel(){
		return $this->dbManagers['calificacionextraordinario']->getBasicMateriaPlanEstudioRel();
	}
	public function getBasicAgendaExtraordinario(){
		return $this->dbManagers['calificacionextraordinario']->getBasicAgendaExtraordinario();
	}
	public function getBasicPeriodoEvaluacion(){
		return $this->dbManagers['conducta']->getBasicPeriodoEvaluacion();
	}
	public function getBasicTallerCurricular(){
		return $this->dbManagers['tallercurricular']->getBasicTallerCurricular();
	}
	public function getBasicMateriaPlanEstudio(){
		return $this->dbManagers['tallercurricular']->getBasicMateriaPlanEstudio();
	}
	public function getBasicTallerExtracurricular(){
		return $this->dbManagers['tallerextracurricular']->getBasicTallerExtracurricular();
	}
	public function getTCGradoTallerCurricularByCicloMateria($cicloid, $materiaid){
		return $this->dbManagers['tallercurricular']->getTCGradoTallerCurricularByCicloMateria($cicloid, $materiaid);
	}
	public function getTCTallercurricularDataByFilter($cicloid, $nivelid=null, $gradoid=null, $planestudioid=null, $materiaid=null,$cpescolar=null){
		return $this->dbManagers['tallercurricular']->getTallercurricularDataByFilter($cicloid, $nivelid, $gradoid, $planestudioid, $materiaid, $cpescolar);
	}
	public function getTCTallerCurricularById($tallercurricularid){
		return $this->dbManagers['tallercurricular']->getTCTallerCurricularById($tallercurricularid);
	}
	public function getTCTallerCurricularUsedById($tallercurricularid){
		return $this->dbManagers['tallercurricular']->getTCTallerCurricularUsedById($tallercurricularid);
	}
	public function getTCTallerCurricularTargetByTallerId($tallercurricularid){
		return $this->dbManagers['tallercurricular']->getTCTallerCurricularTargetByTallerId($tallercurricularid);
	}

	public function getBasicTallerCurricularBitacora(){
		return $this->dbManagers['tallerbitacora']->getBasicTallerCurricularBitacora();
	}
	public function getBasicTallerExtracurricularBitacora(){
		return $this->dbManagers['tallerbitacora']->getBasicTallerExtracurricularBitacora();
	}
	public function getTBTallerBitacoraByCicloNivel($cicloid,$nivelid,$filtros=[]){
		return $this->dbManagers['tallerbitacora']->getTallerBitacoraByCicloNivel($cicloid,$nivelid,$filtros);
	}

	public function getACCalificaciones($filter){
		return $this->dbManagers['avancecalificaciones']->getCalificaciones($filter);
	}

	public function getBBoletaById($boletaid){
		return $this->dbManagers['boletas']->getBoletaById($boletaid);
	}
	public function getBIExtraordinarios($kalumno, $kprofesorpormateriaplanestudios){
		return $this->dbManagers['boletas']->getExtraordinarios($kalumno, $kprofesorpormateriaplanestudios);
	}
	public function getBIAlumnoByCicloGradoMatricula($cicloid,$gradoid,$matricula){
		return $this->dbManagers['boletas']->getAlumnoByCicloGradoMatricula($cicloid,$gradoid,$matricula);
	}
	public function getBIPDFReportByGrupo($grupoid, $oficial){
		return $this->dbManagers['boletas']->getPDFReportByGrupo($grupoid, $oficial);
	}
	public function getBIPDFConfigByGrupo($grupoid){
		return $this->dbManagers['boletas']->getBIPDFConfigByGrupo($grupoid);
	}
	public function getBIPDFStudentByGrupo($grupoid){
		return $this->dbManagers['boletas']->getBIPDFStudentByGrupo($grupoid);
	}
	public function getBIPDFStudentByGrupoAlumnociclo($grupoid, $alumnocicloid){
		return $this->dbManagers['boletas']->getBIPDFStudentByGrupoAlumnociclo($grupoid, $alumnocicloid);
	}
	public function getBIMateriaporplanestudioIdByGrupo($grupoid,$getFullData=false){
		return $this->dbManagers['boletas']->getMateriaporplanestudioIdByGrupo($grupoid,$getFullData);
	}
	public function getBIMateriasDataRawByAOG($entidadid,$options=[]){
		return $this->dbManagers['boletas']->getMateriasDataRawByAOG($entidadid,$options);
	}
	public function getBIAlumnoCicloByCicloAlumno($cicloid,$alumnoid){
		return $this->dbManagers['boletas']->getBIAlumnoCicloByCicloAlumno($cicloid,$alumnoid);
	}
	public function getBIAlumnoCicloByGrupo($grupoid,$alumnoid=null){
		return $this->dbManagers['boletas']->getBIAlumnoCicloByGrupo($grupoid,$alumnoid);
	}
	public function getBIPeriodoEvaluacionByConjuntoPeriodoEvaluacion($conjuntoperiodoevaluacionid){
		return $this->dbManagers['boletas']->getPeriodoEvaluacionByConjuntoPeriodoEvaluacion($conjuntoperiodoevaluacionid);
	}
	public function getBIPeriodoEvaluacionById($periodoevaluacionid){
		return $this->dbManagers['boletas']->getBIPeriodoEvaluacionById($periodoevaluacionid);
	}
	public function getBIPeriodoEvaluacionByCicloGrado($cicloid,$gradoid){
		foreach($this->BuscarPeriodoEvaluacion(["cicloid"=>$cicloid,"gradoid"=>$gradoid]) AS $i){
			return [$i['promediable'],$this->getBIPeriodoEvaluacionByConjuntoPeriodoEvaluacion($i['conjuntoperiodoevaluacionid'])];
		}
		return null;
	}
	public function getBISubgruposByGrupo($kgrupo){
		return $this->getRepositoriosModelo("CeGrupoorigenporsubgrupo",["IDENTITY(d.grupoid) AS grupoid"],["grupoorigenid"=>$kgrupo]);
	}
	public function getBIMateriaById($id){
		$data=$this->getRepositoriosModelo("Materia", ["d.materiaid","d.clave","d.alias","d.nombre"], ["materiaid"=>$id]);
		return ($data ? $data[0] : null);
	}
	public function validBISubmateriaConfig($kciclo, $kgrado, $kplanestudio, $kperiodo, $kmateriapepadre, $kmateria){
		$exist=$this->dbManagers['boletas']->existSubmateriaConfig($kciclo, $kgrado, $kplanestudio, $kperiodo, $kmateriapepadre);
		if($exist && !empty($exist)){
			$kaprendizajeesperadopormateria=$exist[0]["aprendizajeesperadopormateriaid"];
			$valid=$this->dbManagers['boletas']->validSubmateriaConfig($kaprendizajeesperadopormateria, $kmateria);
			return ($valid && !empty($valid));
		}
		return true;
	}
	public function getCapturaAlumnoPeriodo($kalumnociclo,$kperiodo){
		$data=null;
		$dataraw=$this->getRepositoriosModelo("CeCapturaalumnoporperiodo", ["d.capturaalumnoporperiodoid","d.asistencia","d.observaciones","d.tareasolicitada","d.tareaentregada"], ["alumnoporcicloid"=>$kalumnociclo,"periodoevaluacionid"=>$kperiodo]);
		if($dataraw){
			$data=$dataraw[0];
			$kdata=$data["capturaalumnoporperiodoid"];
			$detail=$this->getRepositoriosModelo("CeCapturaasistenciaalumno", ["d.asistencia"], ["capturaalumnoporperiodoid"=>$kdata], ["capturaasistenciaalumnoid"=>"ASC"]);
			$data["detalle"]=(!$detail || empty($detail) ? null : $detail);
		}
		if(empty($data)){
			$data=["detalle"=>[]];
		}
		if(empty($data["detalle"])){
			$data["detalle"][]=["asistencia"=>0];
		}

		$apdRaw=$this->getRepositoriosModelo("CeAsistenciapordia", ["d.fecha"], ["alumnoporcicloid"=>$kalumnociclo,"periodoevaluacionid"=>$kperiodo,"estatusinasistenciaid"=>1,"tipoasistenciaid"=>2]);
		if(!empty($apdRaw)){
			$apdProc=[];
			$ipevaluacion=$this->getRepositoriosModelo("CePeriodoevaluacion", ["d.fechainicio","d.fechafin"], ["periodoevaluacionid"=>$kperiodo])[0];
			$ipeiRaw=$ipevaluacion["fechainicio"]->format("n");
			$ipefRaw=$ipevaluacion["fechafin"]->format("n");
			$ipei=(int)$ipeiRaw;
			$ipef=(int)$ipefRaw;
			if($ipef<$ipei){ $ipef+=12; }
			$k=0;
			for($i=$ipei; $i<=$ipef; $i++,$k++){
				$j=$i;
				if($j>12){ $j-=12; }
				$apdProc[$j]=$k;
			}
			for($i=0;$i<$k;$i++){
				if(!isset($data["detalle"][$i])){
					$data["detalle"][$i]=["asistencia"=>0];
				}else{
					$data["detalle"][$i]["asistencia"]=(int)$data["detalle"][$i]["asistencia"];
				}
			}
			foreach($apdRaw AS $iapd){
				$imRaw=$iapd["fecha"]->format("n");
				$im=(int)$imRaw[1];
				$ik=$apdProc[$im];
				$data["detalle"][$ik]["asistencia"]++;
			}
		}
		return $data;
	}
	public function getPonderacionopcionById($id){
		$data=$this->getRepositoriosModelo("CePonderacionopcion", ["d.ponderacionopcionid","d.opcion","d.descripcion","d.descripcioncorta"], ["ponderacionopcionid"=>$id]);
		return ($data ? $data[0] : null);
	}
	public function getProfesorPorMateriaPlanEstudiosById($idppmpe){
		$data=$this->getRepositoriosModelo("CeProfesorpormateriaplanestudios",
			["CONCAT_WS(' ',p.apellidopaterno,p.apellidomaterno,p.nombre) AS nombre"],
			["profesorpormateriaplanestudiosid"=>$idppmpe],
			false,false,[[
				"entidad"=>"CeProfesor",
				"alias"=>"p",
				"on"=>"d.profesorid=p.profesorid"
			]]);
		return ($data ? $data[0] : null);
	}

	public function getTEAMaterialByTaller($periodoevaluacionid){
		return $this->dbManagers['tallerextracurricular']->getMaterialByTaller($periodoevaluacionid);
	}
	public function getTEAPDFHeaderByTallerextracurricular($tallerid){
		return $this->dbManagers['tallerextracurricular']->getPDFHeaderByTallerextracurricular($tallerid);
	}
	public function getTEAPDFAlumnoByTallerextracurricular($tallerid, $nivelid=null){
		return $this->dbManagers['tallerextracurricular']->getPDFAlumnoByTallerextracurricular($tallerid, $nivelid);
	}
	public function getTEAPDFMaterialHeaderByAlumnociclotallerextra($alumnociclotallerextraid){
		return $this->dbManagers['tallerextracurricular']->getPDFMaterialHeaderByAlumnociclotallerextra($alumnociclotallerextraid);
	}
	public function getTEAPDFMaterialByAlumnociclotallerextra($alumnociclotallerextraid){
		return $this->dbManagers['tallerextracurricular']->getPDFMaterialByAlumnociclotallerextra($alumnociclotallerextraid);
	}
	public function getTEAAlumnocicloportallerextraByTaller($cicloid, $filtros=[]){
		return $this->dbManagers['tallerextracurricular']->getAlumnocicloportallerextraByTaller($cicloid, $filtros);
	}

	public function getCCAlumnoByAlumnocicloporgrupo($alumnocicloporgrupoid){
		return $this->dbManagers['conducta']->getAlumnocicloporgrupoById($alumnocicloporgrupoid);
	}

	public function getCCAlumnosByGrupo($grupoid){
		return $this->dbManagers['conducta']->getAlumnosByGrupo($grupoid);
	}
	public function getCCAlumncicloporgrupoByGrupo($grupoid){
		return $this->dbManagers['conducta']->getAlumnocicloporgrupoByGrupo($grupoid);
	}
	public function getCCMateriasById($materiaids){
		return $this->dbManagers['conducta']->getMateriasById($materiaids);
	}
	public function getCCMateriasplanestudioById($materiaplanestudioid){
		return $this->dbManagers['conducta']->getMateriasplanestudioById($materiaplanestudioid);
	}
	public function getCCCalificacionconductaByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid){
		return $this->dbManagers['conducta']->getCalificacionconductaByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid);
	}
	public function getCCConductacalificacionescala(){
		return $this->dbManagers['conducta']->getConductacalificacionescala();
	}
	public function getCCPromedioByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid){
		return $this->dbManagers['conducta']->getPromedioByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid);
	}

	public function getAINAlumnoByCicloNivelGrado($ciclo,$nivel,$grado,$filtros=[]){
		return $this->dbManagers['alumnoidiomanivel']->getAlumnoByCicloNivelGrado($ciclo,$nivel,$grado,$filtros);
	}

	public function getAINIImportadosByAlumnociclo($alumnocicloids){
		return $this->dbManagers['alumnoidiomanivelimportar']->getImportadosByAlumnociclo($alumnocicloids);
	}
	public function getAINIIdiomanivelByClave($claves){
		return $this->dbManagers['alumnoidiomanivelimportar']->getIdiomanivelByClave($claves);
	}

	public function getCEAcuerdoextraordinarioByAgendaextraordinario($agendaextraordinarioid,$estatusid=[3, 4, 5]){
		return $this->dbManagers['calificacionextraordinario']->getAcuerdoextraordinarioByAgendaextraordinario($agendaextraordinarioid,$estatusid);
	}

	public function getPRPeriodoregularizacionTouchingDates($cicloid,$fechainicio,$fechafin,$periodoregularizacion=null){
		return $this->dbManagers['periodoregularizacion']->getPeriodoregularizacionTouchingDates($cicloid,$fechainicio,$fechafin,$periodoregularizacion);
	}
	public function getPRPeriodoregularizacionLikeNombre($cicloid,$nombre,$periodoregularizacion=null){
		return $this->dbManagers['periodoregularizacion']->getPeriodoregularizacionLikeNombre($cicloid,$nombre,$periodoregularizacion);
	}
	public function getPRFechasValidas($cicloid,$fechainicio,$fechafin,$periodoregularizacion=null){
		$data=$this->getPRPeriodoregularizacionTouchingDates($cicloid,$fechainicio,$fechafin,$periodoregularizacion);
		return (is_array($data) && sizeof($data)<1);
	}
	public function getPRNombreValido($cicloid,$nombre,$periodoregularizacion=null){
		$data=$this->getPRPeriodoregularizacionLikeNombre($cicloid,$nombre,$periodoregularizacion);
		return (is_array($data) && sizeof($data)<1);
	}

	public function getEAcuerdoextraordinarioByAlumno($alumnoid, $tipoextraordinarioid){
		return $this->dbManagers['extraordinario']->getAcuerdoextraordinarioByAlumno($alumnoid, $tipoextraordinarioid);
	}
	public function getEAgendasDisponiblesByExtraordinario($extraordinarioid, $tipoextraordinarioid, $periodoregularizacionid){
		return $this->dbManagers['extraordinario']->getAgendasDisponiblesByExtraordinario($extraordinarioid, $tipoextraordinarioid, $periodoregularizacionid);
	}
	public function getEAcuerdoextraordinarioCountByAgendaextraordinario($agendaextraordinarioid){
		return $this->dbManagers['extraordinario']->getAcuerdoextraordinarioCountByAgendaextraordinario($agendaextraordinarioid);
	}
	public function BuscarExtraordinarioporacuerdo($filtros){
		return $this->dbManagers['extraordinario']->BuscarExtraordinarioporacuerdo($filtros);
	}

	public function BuscarMatriculaAlumnoOyente(){
		return $this->dbManagers['consultaalumnos']->BuscarMatriculaAlumnoOyente();
	}

	public function BuscarAllAlumnos($filtros){
		return $this->dbManagers['consultaalumnos']->BuscarAllAlumnos($filtros);
	}

	public function BuscarAlumnociclo($id){
		return $this->dbManagers['consultaalumnos']->BuscarAlumnociclo($id);
	}

	public function BuscarNolista($grupo){
		return $this->dbManagers['consultaalumnos']->BuscarNolista($grupo);
	}

	public function BuscarDatosalumnociclo($id){
		return $this->dbManagers['alumnosubgrupos']->GetDatosAlumno($id);
	}

	public function GetTalleresByAlumno($id){
		return $this->dbManagers['alumnosubgrupos']->getMateriaTalleresByAlumnociclo($id);
	}
	public function GetSubgruposByAlumno($id){
		return $this->dbManagers['alumnosubgrupos']->GetSubgruposByAlumno($id);
	}
	public function getTallerCurricularByAlumno($gradoid, $materiaporplanestudiosid, $alumnoporcicloid) {
		return $this->dbManagers['extraordinario']->getTallerCurricularByAlumno($gradoid, $materiaporplanestudiosid, $alumnoporcicloid);
	}
	public function getReprobadosporPeriodoMateria($periodoid, $materiaporplanestudiosid, $options=[]) {
		return $this->dbManagers['extraordinario']->getReprobadosporPeriodoMateria($periodoid, $materiaporplanestudiosid, $options);
	}
	public function getProfesoresplanestudiosByAlumno($alumnocicloid) {
		return $this->dbManagers['asistencia']->getProfesoresplanestudiosByAlumno($alumnocicloid);
	}
	public function getBitacoracalificacionesbyProfesor($filtros) {
		return $this->dbManagers['capturacalificaciones']->getBitacoracalificacionesbyProfesor($filtros);
	}
	public function getBitacoracalificacionesbyAlumno($filtros) {
		return $this->dbManagers['capturacalificaciones']->getBitacoracalificacionesbyAlumno($filtros);
	}
	public function BuscarAlumnosReinscripcion($id) {
		return $this->dbManagers['reinscripcion']->BuscarAlumnosReinscripcion($id);
	}
	public function BuscarDocumentosAlumnoReinscripcion($id) {
		return $this->dbManagers['reinscripcion']->BuscarDocumentosAlumnoReinscripcion($id);
	}
	public function GetReinscripcionLista($filter) {
		return $this->dbManagers['reinscripcion']->getReinscripcionLista($filter);
	}
	public function BuscarNominaByUsuario($id) {
		return $this->dbManagers['reinscripcion']->BuscarNominaByUsuario($id);
	}
	public function BuscarAlumnosDocumentos($filtros) {
		return $this->dbManagers['documentosreinscripcion']->BuscarAlumnosDocumentos($filtros);
	}
	public function FaltasRetardosAlumno($filtros) {
		return $this->dbManagers['capturacalificaciones']->FaltasRetardosAlumno($filtros);
	}
	public function FaltasRetardosAlumnoDia($filtros) {
		return $this->dbManagers['capturacalificaciones']->FaltasRetardosAlumnoDia($filtros);
	}

	public function PlanEstudioAlumno($filtros) {
		return $this->dbManagers['alumno']->PlanEstudioAlumno($filtros);
	}

	public function PlanEstudioPorCicloGrado($filtros) {
		return $this->dbManagers['planestudio']->PlanEstudioPorCicloGrado($filtros);
	}

	public function UltimaMatriculaAlumno() {
		return $this->dbManagers['alumno']->UltimaMatriculaAlumno();
	}

	public function BuscarFechainiciolaboralprofesor($id) {
		return $this->dbManagers['profesor']->BuscarFechainiciolaboralprofesor($id);
	}

	public function GetAlumnosPerseverancia($filtros) {
		return $this->dbManagers['alumnoperseverancia']->GetAlumnosPerseverancia($filtros);
	}

	public function ProfesorReportInfo() {
		return $this->dbManagers['profesor']->ProfesorReportInfo();
	}

	public function loadHorarioMateria($profesorid) {
		return $this->dbManagers['profesor']->loadHorarioMateria($profesorid);
	}

	public function loadMaterialReport($filtros) {
		return $this->dbManagers['tallerextracurricular']->loadMaterialReport($filtros);
	}

	public function loadTalleresMateriales($filtros) {
		return $this->dbManagers['tallerextracurricular']->loadTalleresMateriales($filtros);
	}

	public function loadMaterialesEntregados($filtros) {
		return $this->dbManagers['tallerextracurricular']->loadMaterialesEntregados($filtros);
	}

	public function BuscarHorarios($filtros) {
		return $this->dbManagers['configuracionhorario']->BuscarHorarios($filtros);
	}

	public function loadMateriaHorario($filtros) {
		return $this->dbManagers['configuracionhorario']->loadMateriaHorario($filtros);
	}

	public function loadSubgruposTalleresByMateriaHorario($id) {
		return $this->dbManagers['configuracionhorario']->loadSubgruposTalleresByMateriaHorario($id);
	}

	public function getFaltasByHorario($filtros) {
		return $this->dbManagers['configuracionhorario']->getFaltasByHorario($filtros);
	}

	public function ObtenerReprobadorPorProfesor($filtros){
		return $this->dbManagers['profesornivel']->ObtenerReprobadorPorProfesor($filtros);
	}

	public function getMateriasAlumno($filtros){
		return $this->dbManagers['asignacionmateria']->getMateriasAlumno($filtros);
	}

	public function GetAsistenciasDetail($alumnocicloid) {
		return $this->dbManagers['asistencia']->GetAsistenciasDetail($alumnocicloid);
	}

	public function GetAsistenciasDiariaDetail($alumnocicloid) {
		return $this->dbManagers['asistenciadiaria']->GetAsistenciasDiariaDetail($alumnocicloid);
	}

	public function BuscarIProfesorTitular($id) {
		return $this->dbManagers['asistenciadiaria']->BuscarIProfesorTitular($id);
	}

	public function ComentarioPonderacionMateria($filtros) {
		return $this->dbManagers['capturacalificaciones']->ComentarioPonderacionMateria($filtros);
	}

	public function BuscarEventosPendientes() {
		return $this->dbManagers['calendarioescolar']->BuscarEventosPendientes();
	}

	public function getAvisosPlataforma($filtros) {
		return $this->dbManagers['avisoplataforma']->getAvisosPlataforma($filtros);
	}
}