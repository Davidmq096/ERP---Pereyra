<?php
namespace AppBundle\DB;

use Doctrine\ORM\EntityManager as EM;
use AppBundle\DB\Mysql\Reportes\CalificacionDB;
use AppBundle\DB\Mysql\Reportes\MetasInscripcionDB;
use AppBundle\DB\Mysql\Reportes\CalificacionesCualitativasDB;
class DbmReportes extends DatabaseManager{
	protected $em;
	protected $dbManagers;
	protected $objectManager;
	public function __construct(EM $em){
		parent::__construct($em);
		$this->em=$em;
		$this->dbManagers=array_merge($this->dbManagers, array(
			'calificacion'=>new CalificacionDB($this->em),
			'metasinscripcion'=>new MetasInscripcionDB($this->em),
			'calificacionescualitativas'=>new CalificacionesCualitativasDB($this->em)
		));
	}
	public function ConsultaCalificaciones($filtros){
		return $this->dbManagers['calificacion']->ConsultaCalificaciones($filtros);
	}

	public function buscarMetasInscripcionGrado($filtros){
		return $this->dbManagers['metasinscripcion']->buscarMetasInscripcionGrado($filtros);
	}

	public function buscarMetasInscripcionNivel($filtros){
		return $this->dbManagers['metasinscripcion']->buscarMetasInscripcionNivel($filtros);
	}

	public function buscarMetasInscripciosnGrado($filtros){
		return $this->dbManagers['calificacionescualitativas']->buscarMetasInscripcionGrado($filtros);
	}

	public function getCalificacionDesgloseByPeriodoevaluacionProfesormpe($kperiodoevaluacion,$kprofesormpe){
		try{			
			return $this->getRepositoriosModelo("CeCriterioevaluaciongrupo",[
					"d.criterioevaluaciongrupoid",
					"d.aspecto",
					"d.porcentajecalificacion",
					"d.configurartarea AS tarea",
					"d.capturas AS numerocapturas"
				],[
					"periodoevaluacionid"=>$kperiodoevaluacion,
					"profesorpormateriaplanestudiosid"=>$kprofesormpe
				]
			);
		}catch(\Exception $e){}
		return null;
	}
	public function getCalificacionDesgloseByCalificacionperiodoalumno($kcalificacionperiodoalumno){
		try{
			return $this->dbManagers['calificacion']->DesgloseCapturaAlumno($kcalificacionperiodoalumno);
		}catch(\Exception $e){}
		return null;
	}
}