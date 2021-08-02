<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Entity\CeTallercurricular;
use AppBundle\Entity\CeGradoportallercurricular;
use AppBundle\Entity\CeProfesorpormateriaplanestudios;

/**
 * @author: Emmanuel Martinez
 */
class TallerCurricularController extends FOSRestController
{
	private $DBM = false;
	/**
	 * @Annotations\Get("/api/Controlescolar/Tallercurricular/filter", name="getTCFilter")
	 */
	public function getTCFilter()
	{
		$dbm = $this->getDM();
		$ciclo = $dbm->getBasicCiclo();
		$nivel = $dbm->getBasicNivel();
		$semestre = $dbm->getBasicSemestre();
		$grado = $dbm->getBasicGrado();
		$pestudio = $dbm->getBasicPlanEstudio();
		$cpescolar = $dbm->getBasicClasificadorParaescolar();
		$profesor = $dbm->getBasicProfesor();
		$profesorninguno = [[
			"id" => -1,
			"nombre" => "NINGUNO"
		]];
		array_splice($profesor, 0, 0, $profesorninguno);
		$idiomanivel = $dbm->getBasicIdiomaNivel();
		$rtaller = $dbm->getBasicTallerCurricular();
		$materiape = $dbm->getBasicMateriaPlanEstudio();
		if (
			$ciclo !== false && $nivel !== false && $grado !== false && $semestre !== false && $pestudio !== false
			&& $cpescolar !== false && $materiape !== false && $profesor !== false && $idiomanivel !== false && $rtaller !== false
		) {
			return Api::Ok("", array(
				"ciclo" => $ciclo,
				"nivel" => $nivel,
				"grado" => $grado,
				"semestre" => $semestre,
				"pestudio" => $pestudio,
				"cpescolar" => $cpescolar,
				"materiape" => $materiape,
				"profesor" => $profesor,
				"idiomanivel" => $idiomanivel,
				"rtaller" => $rtaller
			));
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}

	/**
	 * @Annotations\Get("/api/Controlescolar/Tallercurricular", name="getTCTalleres")
	 */
	public function getTCTalleres()
	{
		$data = $_REQUEST;
		$cicloid = $this->getTCTalleresEval((int) $data['cicloid']);
		$nivelid = $this->getTCTalleresEval((int) $data['nivelid']);
		$gradoid = $this->getTCTalleresEval((int) $data['gradoid']);
		$pestudioid = $this->getTCTalleresEval((int) $data['pestudioid']);
		$materiapeid = $this->getTCTalleresEval((int) $data['materiapeid']);
		$cpescolarid = $this->getTCTalleresEval((int) $data['cpescolarid']);
		if (!$cicloid) {
			return Api::Error(Response::HTTP_BAD_REQUEST, false);
		}
		$dbm = $this->getDM();
		$taller = $dbm->getTCTallercurricularDataByFilter($cicloid, $nivelid, $gradoid, $pestudioid, $materiapeid, $cpescolarid);
		$tallerd = array();
		$tallerid = array();
		foreach ($taller as $i) {
			$tallerid[] = $i['tallercurricularid'];
		}
		foreach ($dbm->getTCTallerCurricularUsedById($tallerid) as $i) {
			$tallerd[$i['id']] = (int) $i['inscrito'];
		}
		foreach ($taller as $k => $i) {
			$id = $i['tallercurricularid'];
			$inscrito = 0;
			$disponible = (int) $i['cupo'];
			if (isset($tallerd[$id])) {
				$inscrito = $tallerd[$id];
				$disponible -= $inscrito;
			}
			$taller[$k]['inscrito'] = $inscrito;
			$taller[$k]['disponible'] = $disponible;
		}
		return Api::Ok("", $taller);
	}
	/**
	 * @Annotations\Get("/api/Controlescolar/Tallercurricular/{tallerid}", name="getTCTallerById")
	 */
	public function getTCTallerById($tallerid)
	{
		$tallercurricularid = (int) $tallerid;
		if ($tallercurricularid < 1) {
			return Api::Error(Response::HTTP_BAD_REQUEST, false);
		}
		$dbm = $this->getDM();
		$talleres = $dbm->getTCTallerCurricularById($tallercurricularid);
		if (sizeof($talleres) == 1) {
			list($taller) = $talleres;
			$taller['target'] = $dbm->getTCTallerCurricularTargetByTallerId($tallercurricularid);
			return Api::Ok("", $taller);
		}
		return Api::Error(Response::HTTP_PARTIAL_CONTENT, false);
	}
	/**
	 * @Annotations\Post("/api/Controlescolar/Tallercurricular", name="createTCTallerCurricularById")
	 */
	public function createTCTallerCurricularById()
	{
		$requestRaw = trim(file_get_contents("php://input"));
		$data = json_decode($requestRaw, true);
		return $this->saveTallerCurricularData(null, $data, new CeTallercurricular(), true);
	}
	/**
	 * @Annotations\Put("/api/Controlescolar/Tallercurricular/{tallerid}", name="updateTCTallerCurricularById")
	 */
	public function updateTCTallerCurricularById($tallerid)
	{
		$requestRaw = trim(file_get_contents("php://input"));
		$data = json_decode($requestRaw, true);
		$alumnos = $this->getDM()->getTCTallerCurricularUsedById([$tallerid]);
		$isEditable = (!$alumnos || sizeof($alumnos) < 1);
		/*if(!$isEditable){
			return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No es posible modificar el taller debido a que ya tiene alumnos asignados.");
		}
		 */
		return $this->saveTallerCurricularData($tallerid, $data, $this->getDM()->getRepositorioById("CeTallercurricular", "tallercurricularid", $tallerid), $isEditable);
	}
	/**
	 * @Annotations\Delete("/api/Controlescolar/Tallercurricular/{tallerid}", name="deleteTCTallerCurricularById")
	 */
	public function deleteTCTallerCurricularById($tallerid)
	{
		$dbm = $this->getDM();
		try {
			$taller = $dbm->getRepositorioById("CeTallercurricular", "tallercurricularid", $tallerid);
			$profesor = $dbm->getRepositoriosById("CeProfesorpormateriaplanestudios", "tallerid", $tallerid);
			$target = $dbm->getRepositoriosById("CeGradoportallercurricular", "tallercurricularid", $tallerid);
			$dbm->getConnection()->beginTransaction();
			foreach ($profesor as $prof) {
				$criterios = $dbm->getRepositorioById("CeCriterioevaluaciongrupo", "profesorpormateriaplanestudiosid", $prof->getProfesorpormateriaplanestudiosid());
				if (count($criterios) > 0) {
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Este taller ya tiene criterios de evaluación");
				}
				$dbm->removeRepositorio($prof);
			}
			foreach ($target as $i) {
				$dbm->removeRepositorio($i);
			}
			$dbm->removeRepositorio($taller);
			$dbm->getConnection()->commit();
			return Api::Ok("", true);
		} catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
			return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Ya hay alumnos pre-registrados a este taller");
		} catch (\Exception $e) {
			$dbm->getConnection()->rollBack();
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}

	/**
	 * @Annotations\Post("/api/Controlescolar/Tallercurricular/copiar/{cicloid}", name="createTCTallerCurricularCopy")
	 */
	public function createTCTallerCurricularCopy($cicloid)
	{
		$requestRaw = trim(file_get_contents("php://input"));
		$data = json_decode($requestRaw, true);
		if (sizeof($data) > 0) {
			$allow_current = (int) $_REQUEST['current'];
			$dbm = $this->getDM();
			$dem = $dbm->getEntityManager();
			$ciclo = $dbm->getRepositorioById("Ciclo", "cicloid", $cicloid);
			$tallerOld = $dbm->getRepositoriosById("CeTallercurricular", "tallercurricularid", $data);
			$targetOld = $dbm->getRepositoriosById("CeGradoportallercurricular", "tallercurricularid", $data);
			$targetOldK = array();
			$taller = array();
			if (sizeof($tallerOld) != sizeof($data)) {
				return Api::Error(Response::HTTP_BAD_REQUEST, "Peticion invalida.");
			}
			foreach ($targetOld as $i) {
				$vigente = $i->getMateriaporplanestudioid()->getPlanestudioid()->getVigente();
				if ($vigente) {
					$id = $i->getTallercurricularid()->getTallercurricularid();
					if (!isset($targetOldK[$id])) {
						$targetOldK[$id] = array();
					}
					$targetOldK[$id][] = $i;
				} else {
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No se pudo completar el copiado debido a que el plan de estudios ya no es vigente.");
				}
			}
			foreach ($tallerOld as $i) {
				$icicloid = (int) $i->getCicloid()->getCicloid();
				if ($allow_current === 0 && $icicloid == $cicloid) {
					return Api::Error(Response::HTTP_PARTIAL_CONTENT, "El ciclo destino no puede ser el mismo de origen.");
				}
			}
			try {
				$dbm->getConnection()->beginTransaction();
				foreach ($tallerOld as $i) {
					$id = $i->getTallercurricularid();
					$itarget = array();
					$italler = clone $i;
					foreach ($targetOldK[$id] as $j) {
						$jtarget = clone $j;
						$itarget[] = $jtarget;
						$dem->persist($jtarget);
					}
					$taller[] = array($italler, $itarget);
					$dem->persist($italler);
				}
				$dem->flush();
				foreach ($taller as $i) {
					list($italler, $itarget) = $i;
					foreach ($itarget as $jtarget) {
						$jtarget->setTallercurricularid($italler);
					}
					$italler->setCicloid($ciclo);
				}
				$dem->flush();
				$dbm->getConnection()->commit();
				return Api::Ok("", true);
			} catch (Exception $e) {
				$dbm->getConnection->rollBack();
			}
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	private function saveTallerCurricularData($tallerid, $req, $taller, $isEditable)
	{
		$dbm = $this->getDM();
		$dem = $dbm->getEntityManager();
		$target = array();
		$target_rm = array();
		$data = $this->getTallerCurricularValidData($req, $isEditable);
		$dataTarget = $this->getTallerCurricularValidTargetData($req['target']);
		$profesor = null;
		$cotitular = null;
		$suplente = null;
		$profesorid = (int) $data['profesorid'];
		$suplenteid = (int) $data['suplenteid'];
		$cotitularid = (int) $data['cotitularid'];
		if ($profesorid < 1) {
			$profesorid = null;
		} else {
			$profesor = $dbm->getRepositorioById('CeProfesor', 'profesorid', $profesorid);
		}
		$cotitularid = (int) $data['cotitularid'];
		if ($cotitularid < 1) {
			$cotitularid = null;
		} else {
			$cotitular = $dbm->getRepositorioById('CeProfesor', 'profesorid', $cotitularid);
		}
		$suplenteid = (int) $data['suplenteid'];
		if ($suplenteid < 1) {
			$suplenteid = null;
		} else {
			$suplente = $dbm->getRepositorioById('CeProfesor', 'profesorid', $suplenteid);
		}
		unset($data['profesorid']);
		$hydrator = new ArrayHydrator($dem);
		$hydrator->hydrate($taller, $data);
		$taller->setProfesorid($profesor);
		$taller->setSuplenteid($suplente);
		$taller->setCotitularid($cotitular);
		if ($isEditable) {
			if ($data['orden'] == null) {
				$taller->setOrden(null);
			}
			if ($data['talleranteriorid'] == null) {
				$taller->setTalleranteriorid(null);
			}
			if ($tallerid) {
				$target_rm = $dbm->getRepositoriosById("CeGradoportallercurricular", "tallercurricularid", $tallerid);
			}
			foreach ($dataTarget as $i) {
				$di = new CeGradoportallercurricular();
				$hydrator->hydrate($di, $i);
				$target[] = $di;
			}
		}
		if (sizeof($target) > 0 || !$isEditable) {
			try {
				$dbm->getConnection()->beginTransaction();
				$dbm->saveRepositorio($taller);
				$pmet = $dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'tallerid', $taller->getTallercurricularid());
				if (!$pmet) {
					$estatus = $dbm->getRepositorioById('CeEstatuscriterioevaluacion', 'estatuscriterioevaluacionid', 2);
					$pmet = new CeProfesorpormateriaplanestudios();
					$pmet->setProfesorid($profesor);
					$pmet->setSuplenteid($suplente);
					$pmet->setCotitularid($cotitular);
					$pmet->setTallerid($taller);
					$pmet->setEstatuscriterioevaluacionid($estatus);
					$pmet->setActivo(true);
					$dbm->saveRepositorio($pmet);
				} else {
					$pmet->setProfesorid($profesor);
					$pmet->setSuplenteid($suplente);
					$pmet->setCotitularid($cotitular);
					$dbm->saveRepositorio($pmet);
				}
				foreach ($target as $i) {
					$i->setTallercurricularid($taller);
					$dbm->saveRepositorio($i);
				}
				foreach ($target_rm as $i) {
					$dbm->removeRepositorio($i);
				}
				$dbm->getConnection()->commit();
				return Api::Ok("", true);
			} catch (\Exception $e) {
				$dbm->getConnection()->rollBack();
				return Api::Error(Response::HTTP_BAD_REQUEST, false);
			}
		}
		return Api::Error(Response::HTTP_BAD_REQUEST, false);
	}
	private function getTallerCurricularValidData($req, $isEditable)
	{
		$def = [
			"cicloid" => null,
			"profesorid" => null,
			"suplenteid" => null,
			"cotitularid" => null,
			"talleranteriorid" => null,
			"clasificadorparaescolaresid" => null,
			"nombre" => null,
			"descripcion" => null,
			"cupo" => 0,
			"cupomaxmasculino" => 0,
			"cupomaxfemenino" => 0,
			"orden" => null,
			"inscripcionweb" => false
		];
		if (!$isEditable) {
			$valids = ["cupo" => true, "cupomaxmasculino" => true, "cupomaxfemenino" => true, "profesorid" => true, "cotitularid" => true, "suplenteid" => true];
			foreach ($def as $k => $i) {
				if (!isset($valids[$k])) {
					unset($def[$k]);
				}
			}
		}
		foreach ($def as $k => $i) {
			if (isset($req[$k]) && $req[$k]) {
				$def[$k] = $req[$k];
			}
		}
		return $def;
	}
	private function getTallerCurricularValidTargetData($req)
	{
		$data = array();
		foreach ($req as $i) {
			$def = array(
				"gradoid" => null,
				"materiaporplanestudioid" => null,
				"idiomanivelid" => null
			);
			foreach ($def as $k => $j) {
				if (isset($i[$k]) && $i[$k] && $i[$k] != 'undefined') {
					$def[$k] = $i[$k];
				}
			}
			$data[] = $def;
		}
		return $data;
	}
	private function getTCTalleresEval($x)
	{
		return ($x && $x > 0 ? $x : null);
	}
	private function getDM()
	{
		if ($this->DBM) {
			return $this->DBM;
		}
		$this->DBM = new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
	}
}
