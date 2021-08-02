<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * @author David Medina
 * @author Emmanuel Martinez
 */
class BoletasDB extends BaseDBManager
{
	public function BuscarBoletas($filtros)
	{
		$qb = $this->em->createQueryBuilder();
		$result = $qb->select("b.boletaid, b2.boletaid as boletaoficialid, b.nombre, n.nombre as nivel, n.nivelid, CONCAT_wS(',',b.boletaid,b2.boletaid) as boletasids")
			->from("AppBundle:CeBoletas", 'b')
			->innerJoin("AppBundle:CeBoletaporciclo", "bc", Expr\Join::WITH, "bc.boletaid = b.boletaid")
			->innerJoin("AppBundle:CeBoletaporgrado", "bg", Expr\Join::WITH, "bg.boletaid = b.boletaid and (bg.oficial = 0 or bg.oficial is null) ")
			->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid = bg.gradoid")
			->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid = g.nivelid")
			->leftJoin("AppBundle:CeBoletaporgrado", "bg2", Expr\Join::WITH, "bg2.gradoid = g.gradoid and bg2.oficial = 1")
			->leftJoin("AppBundle:CeBoletas", "b2", Expr\Join::WITH, "b2.boletaid = bg2.boletaid")
			->leftJoin("AppBundle:Grado", "g2", Expr\Join::WITH, "g.gradoid = bg.gradoid")
			->leftJoin("AppBundle:Nivel", "n2", Expr\Join::WITH, "n.nivelid = g.nivelid");
		if (isset($filtros['nombre'])) {
			$escape = array("_", "%");
			$escapados = array("\_", "\%");
			$filtros['nombre'] = str_replace($escape, $escapados, $filtros['nombre']);
			$result->andWhere('b.nombre like :nombre')
				->setParameter('nombre', '%' . $filtros['nombre'] . '%');
		}
		if (isset($filtros['cicloid'])) {
			$result->andWhere('bc.cicloid IN (:cicloid)')
				->setParameter('cicloid', $filtros['cicloid']);
		}
		if (!empty($filtros['nivelid'])) {
			$result->andWhere('n.nivelid IN (:nivelid)')
				->setParameter('nivelid', $filtros['nivelid']);
		}
		if (!empty($filtros['gradoid'])) {
			$result->andWhere('bg.gradoid IN (:gradoid)')
				->setParameter('gradoid', $filtros['gradoid']);
		}
		$result->groupBy("b.boletaid");
		return $result->getQuery()->getResult();
	}


	public function getBIPDFConfigByGrupo($grupoid)
	{
		$data = ["periodoeval" => ""];
		$qb = $this->em->createQueryBuilder();
		$qb->select('b.nombre, b.valor')
			->from("AppBundle:Parametros", 'b')
			->andWhere("b.nombre IN (:nombre)")
			->setParameter('nombre', ["NombreDirectorPreescolar", "NombreDirectorPrimaria", "NombreDirectorSecundaria", "NombreDirectorBachillerato"]);
		$qbr = $qb->getQuery()->getResult();
		foreach ($qbr as $i) {
			$data[$i['nombre']] = $i['valor'];
		}
		return $data;
	}
	public function getBIPDFStudentByGrupo($grupoid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select("IDENTITY(ceacg.alumnoporcicloid) AS alumnoporcicloid")
				->from("AppBundle:CeAlumnocicloporgrupo", "ceacg")
				->andWhere("ceacg.grupoid=:grupo")
				->setParameter("grupo", $grupoid);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
			return false;
		}
	}
	public function getBIPDFStudentByGrupoAlumnociclo($grupoid, $alumnocicloid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"c.nombre AS cyclename,"
					. "ces.nombre AS semestre,"
					. "g.grado AS grado,"
					. "ceg.nombre AS grupo,"
					. "n.nombre AS nivel,"
					. "ceae.nombre AS areaespecializacion,"
					. "ceag.numerolista,"
					. "cea.curp,"
					. "cea.matricula,"
					. "cea.primernombre,"
					. "cea.segundonombre,"
					. "cea.apellidopaterno AS apaterno,"
					. "cea.apellidomaterno AS amaterno"
			)->from("AppBundle:CeAlumnocicloporgrupo", "ceag")
				->innerJoin("AppBundle:CeGrupo", "ceg", "WITH", "ceg.grupoid=ceag.grupoid")
				->innerJoin("AppBundle:CeAlumnoporciclo", "ceac", "WITH", "ceac.alumnoporcicloid=ceag.alumnoporcicloid")
				->innerJoin("AppBundle:Ciclo", "c", "WITH", "c.cicloid=ceac.cicloid")
				->innerJoin("AppBundle:Grado", "g", "WITH", "g.gradoid=ceac.gradoid")
				->innerJoin("AppBundle:Nivel", "n", "WITH", "n.nivelid=g.nivelid")
				->innerJoin("AppBundle:CeAlumno", "cea", "WITH", "cea.alumnoid=ceac.alumnoid")
				->leftJoin("AppBundle:CeSemestre", "ces", "WITH", "ces.semestreid=g.semestreid")
				->leftJoin("AppBundle:CeAreaespecializacion", "ceae", "WITH", "ceae.areaespecializacionid=ceg.areaespecializacionid")
				->andWhere("ceag.grupoid=:grupo")
				->andWhere("ceag.alumnoporcicloid=:alumnociclo")
				->setParameter("grupo", $grupoid)
				->setParameter("alumnociclo", $alumnocicloid);
			$alumnodata = $qb->getQuery()->getResult();

			$param = array('alumnoporciclo' => $alumnocicloid);
			$sql = "SELECT CONVERT(SUBSTRING_INDEX(afcav.foto,';base64,',-1) USING utf8) AS photo"
				. " FROM ce_alumnoporciclo ceac"
				. " LEFT JOIN ce_alumnofotocicloactualvista afcav ON afcav.alumnoid=ceac.alumnoid"
				. " WHERE ceac.alumnoporcicloid=:alumnoporciclo";
			$stmt = $this->em->getConnection()->prepare($sql);
			$stmt->execute($param);
			$rs = $stmt->fetchColumn();
			$alumnodata[0]["photo"] = $rs;
			return $alumnodata;
		} catch (\Exception $e) {
			return false;
		}
	}
	public function getMateriaporplanestudioIdByGrupo($grupoid, $getFullData = false)
	{
		$data = [];
		$materias = $this->getMateriasDataByGrupo($grupoid);
		foreach ($materias as $i) {
			list($materiaplanestudioid, $materiaid, $isSubmateria, $name, $profesorid, $profesorpormateriaplanestudioid) = $i;
			$data[] = ($getFullData ? [$materiaplanestudioid, $profesorpormateriaplanestudioid, $materiaid, $isSubmateria, $name, $profesorid]
				: $materiaplanestudioid);
		}
		return $data;
	}
	private function getMateriasDataByGrupo($grupoid)
	{
		$data = array();
		$materias = $this->getMateriasDataRawByGrupo($grupoid);
		foreach ($materias as $i) {
			$isSub = false;
			$id = $i["id"];
			$materiaid = $i['parent_materiaid'];
			$parent_mpeid = $i['parent_materiaporplanestudioid'];
			if (!empty($i['taller_materiaid'])) { //Taller
				$materiaid = $i['taller_materiaid'];
				$parent_mpeid = $i['taller_materiaporplanestudioid'];
			} else if (!empty($i['sub_materiaid']) && $i['sub_materiaid'] != $materiaid) { //Submateria
				$isSub = true;
				$materiaid = $i['sub_materiaid'];
			}
			$name = trim(
				""
					. ($i['papaterno'] ? $i['papaterno'] . " " : "")
					. ($i['pamaterno'] ? $i['pamaterno'] . " " : "")
					. ($i['pnombre'] ? $i['pnombre'] . " " : "")
			);
			$data[] = [
				$parent_mpeid,
				(int)$materiaid,
				$isSub,
				$name,
				$i['profesorid'],
				$id
			];
		}
		return $data;
	}
	private function getMateriasDataRawByGrupo($grupoid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"cepmpe.profesorpormateriaplanestudiosid AS id,"
					. "IDENTITY(cegtccempe.materiaid) AS taller_materiaid,"
					. "IDENTITY(cepmpe.materiaid) AS sub_materiaid,"
					. "IDENTITY(cempe.materiaid) AS parent_materiaid,"
					. "cep.profesorid,"

					. "cegtccempe.materiaporplanestudioid AS taller_materiaporplanestudioid,"
					. "cempe.materiaporplanestudioid AS parent_materiaporplanestudioid,"
					. "cep.nombre AS pnombre,"
					. "cep.apellidopaterno AS papaterno,"
					. "cep.apellidomaterno AS pamaterno"
			)->from("AppBundle:CeProfesorpormateriaplanestudios", "cepmpe")
				->innerJoin("AppBundle:CeProfesor", "cep", "WITH", "cep.profesorid=cepmpe.profesorid")
				->innerJoin("AppBundle:CeGrupo", "ceg", "WITH", "ceg.grupoid=cepmpe.grupoid")
				->leftJoin("AppBundle:CeTallercurricular", "cetc", "WITH", "cetc.tallercurricularid=cepmpe.tallerid")
				->leftJoin("AppBundle:CeGradoportallercurricular", "cegtc", "WITH", "cegtc.tallercurricularid=cetc.tallercurricularid AND cegtc.gradoid=ceg.gradoid")
				->leftJoin("AppBundle:CeMateriaporplanestudios", "cegtccempe", "WITH", "cegtccempe.materiaporplanestudioid=cegtc.materiaporplanestudioid")
				->leftJoin("AppBundle:CeMateriaporplanestudios", "cempe", "WITH", "cempe.materiaporplanestudioid=cepmpe.materiaporplanestudioid")
				->andWhere("cepmpe.grupoid=:grupo")
				->setParameter("grupo", $grupoid);
			$data = $qb->getQuery()->getResult();
			return $data;
		} catch (\Exception $e) {
			return false;
		}
	}
	public function getMateriasDataRawByAOG($entidadid, $options = [])
	{
		try {
			$showName = false;
			$isGrupo = false;
			$optional = "";
			if (isset($options["isgrupo"]) && $options["isgrupo"]) {
				$isGrupo = true;
			}
			if (isset($options["showname"]) && $options["showname"]) {
				$showName = true;
			}
			if (isset($options["fieldext"])) {
				$fext = $options["fieldext"];
				if (!empty($fext) && is_array($fext)) {
					$optional = "," . implode(",", $fext);
				}
			}
			$qbGrupo = $this->em->createQueryBuilder();
			$qbGrupo->select(
				"cepmpe.profesorpormateriaplanestudiosid",
				"cempe.materiaporplanestudioid",
				"IDENTITY(cempe.planestudioid) AS planestudioid",
				"cecc.componentecurricularid",
				"cecc.mostrarcapturaopciones",
				"cecc.ponderacionparacapturaopciones",
				"cep.profesorid",
				"cetc.tipocalificacionid",
				"CASE WHEN cepmpe.materiaid IS NOT NULL"
					. " THEN cepmpem.materiaid"
					. " ELSE cempem.materiaid"
					. " END AS materiaid",
				"cempe.escurricular",
				"cempe.ordeninterno",
				"f.materiafrecuenciacapturaid",
				"f.nombre as frecuencia_captura",
				"CONCAT_WS(' ',cep.apellidopaterno,cep.apellidomaterno,cep.nombre) AS profesor",
				"cecc.nombre AS componentecurricular",
				"cegu.grupoid$optional"
			)->from("AppBundle:CeAlumnoporciclo", "ceac")
				->innerJoin("AppBundle:CeAlumnocicloporgrupo", "ceacgu", "WITH", "ceacgu.alumnoporcicloid=ceac.alumnoporcicloid")
				->innerJoin("AppBundle:CeGrupo", "cegu", "WITH", "cegu.grupoid=ceacgu.grupoid")
				->innerJoin("AppBundle:Grado", "ga", "WITH", "ga.gradoid=cegu.gradoid")
				->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "cepmpe", "WITH", "cepmpe.grupoid=cegu.grupoid")
				->innerJoin("AppBundle:CeProfesor", "cep", "WITH", "cep.profesorid=cepmpe.profesorid")
				->innerJoin("AppBundle:CeMateriaporplanestudios", "cempe", "WITH", "cempe.materiaporplanestudioid=cepmpe.materiaporplanestudioid")
				->innerJoin('cempe.materiafrecuenciacapturaid', 'f')
				->innerJoin("AppBundle:CeComponentecurricular", "cecc", "WITH", "cecc.componentecurricularid=cempe.componentecurricularid")
				->innerJoin("AppBundle:CeTipocalificacion", "cetc", "WITH", "cetc.tipocalificacionid=cecc.tipocalificacionid")
				->leftJoin("AppBundle:Materia", "cepmpem", "WITH", "cepmpem.materiaid=cepmpe.materiaid")
				->leftJoin("AppBundle:Materia", "cempem", "WITH", "cempem.materiaid=cempe.materiaid")
				//->innerJoin("AppBundle:CeProfesor", "cep", "WITH", "cep.profesorid=cepmpe.profesorid")
			;

			$qbTaller = $this->em->createQueryBuilder();
			$qbTaller->select(
				"cepmpe.profesorpormateriaplanestudiosid",
				"cempe.materiaporplanestudioid",
				"cecc.componentecurricularid",
				"cecc.mostrarcapturaopciones",
				"cecc.ponderacionparacapturaopciones",
				"cep.profesorid",
				"cetc.tipocalificacionid",
				"IDENTITY(cempe.materiaid) AS materiaid",
				"IDENTITY(ceact.tallercurricularid) AS tallercurricularid",
				"cempe.escurricular",
				"cempe.ordeninterno",
				"CONCAT_WS(' ',cep.apellidopaterno,cep.apellidomaterno,cep.nombre) AS profesor",
				"cecc.nombre AS componentecurricular$optional"
			)->from("AppBundle:CeAlumnoporciclo", "ceac")
				->innerJoin("AppBundle:CeAlumnocicloporgrupo", "ceacgu", "WITH", "ceacgu.alumnoporcicloid=ceac.alumnoporcicloid")
				->innerJoin("AppBundle:CeGrupo", "cegu", "WITH", "cegu.grupoid=ceacgu.grupoid")
				->innerJoin("AppBundle:Grado", "ga", "WITH", "ga.gradoid=cegu.gradoid")
				->innerJoin("AppBundle:CeAlumnocicloportaller", "ceact", "WITH", "ceact.alumnoporcicloid=ceac.alumnoporcicloid AND ceact.vigente=1")
				->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "cepmpe", "WITH", "cepmpe.tallerid=ceact.tallercurricularid")
				->innerJoin("AppBundle:CeProfesor", "cep", "WITH", "cep.profesorid=cepmpe.profesorid")
				->innerJoin("AppBundle:CeGradoportallercurricular", "cegtc", "WITH", "cegtc.tallercurricularid=cepmpe.tallerid AND cegtc.gradoid=ga.gradoid")
				->innerJoin("AppBundle:CeMateriaporplanestudios", "cempe", "WITH", "cempe.materiaporplanestudioid=cegtc.materiaporplanestudioid")
				->innerJoin("AppBundle:Materia", "m", "WITH", "m.materiaid=cempe.materiaid")
				->innerJoin("AppBundle:CePlanestudios", "cepe", "WITH", "cepe.planestudioid=cempe.planestudioid AND ((cegu.areaespecializacionid IS NULL AND cepe.areaespecializacionid IS NULL) OR (cepe.areaespecializacionid=cegu.areaespecializacionid))")
				->innerJoin("AppBundle:CeComponentecurricular", "cecc", "WITH", "cecc.componentecurricularid=cempe.componentecurricularid")
				->innerJoin("AppBundle:CeTipocalificacion", "cetc", "WITH", "cetc.tipocalificacionid=cecc.tipocalificacionid")
				->groupBy("cempe.materiaporplanestudioid");
			//$qbGrupo->select("m.nombre");
			if ($isGrupo) {
				$qbGrupo->andWhere("cegu.grupoid IN (:grupo)")->setParameter("grupo", $entidadid)->groupBy("cepmpe.profesorpormateriaplanestudiosid");
				/* 
   Autor: David Medina davidmq.skip@gmail.com
   Función: Se corrige para que el filtro considere bien el grupo y no el taller ya que no coincide el grupo con el tallerid 
   Fecha: 18/03/2021
*/
				if (ENTORNO == 2) {
					$qbTaller->andWhere("cegu.grupoid IN (:grupo)")->setParameter("grupo", $entidadid)->groupBy("cepmpe.profesorpormateriaplanestudiosid");
				} else {
					$qbTaller->andWhere("ceact.tallercurricularid IN (:grupo)")->setParameter("grupo", $entidadid)->groupBy("cepmpe.profesorpormateriaplanestudiosid");
				}
			} else {
				$qbGrupo->andWhere("ceac.alumnoporcicloid=:alumnociclo")->setParameter("alumnociclo", $entidadid);
				$qbTaller->andWhere("ceac.alumnoporcicloid=:alumnociclo")->setParameter("alumnociclo", $entidadid);
			}
			if (isset($options["ppmpeid"])) {
				$kppmpe = $options["ppmpeid"];
				$qbGrupo->andWhere("cepmpe.profesorpormateriaplanestudiosid=:ppmpe")->setParameter("ppmpe", $kppmpe);
				$qbTaller->andWhere("cepmpe.profesorpormateriaplanestudiosid=:ppmpe")->setParameter("ppmpe", $kppmpe);
			}
			if ($showName) {
				$qbTaller->addSelect("m.nombre AS materia");
				$qbGrupo->addSelect("CASE WHEN cepmpe.materiaid IS NOT NULL"
					. " THEN cepmpem.nombre"
					. " ELSE cempem.nombre"
					. " END AS materia");
			}
			$dataGrupo = $qbGrupo->getQuery()->getResult();
			$dataTaller = $qbTaller->getQuery()->getResult();
			if (!$dataGrupo) {
				$dataGrupo = [];
			}
			if (!$dataTaller) {
				$dataTaller = [];
			}
			foreach ($dataTaller as $i) {
				$dataGrupo[] = $i;
			}
			usort($dataGrupo, ['AppBundle\DB\Mysql\Controlescolar\BoletasDB', 'fnMateriasOrden']);
			return $dataGrupo;
		} catch (\Exception $e) {
			return false;
		}
	}
	public static function fnMateriasOrden($a, $b)
	{
		$aa = (int)$a['ordeninterno'];
		$bb = (int)$b['ordeninterno'];
		return ($aa < $bb ? -1 : 1);
	}
	public function getPDFReportByGrupo($grupoid, $oficial)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"ceb.boletaid AS id,"
					. "ceb.boletaid,"
					. "ceb.nombre,"
					. "ceb.formato"
			)->from("AppBundle:CeGrupo", "ceg")
				->innerJoin("AppBundle:Grado", "g", "WITH", "g.gradoid=ceg.gradoid")
				->innerJoin("AppBundle:CeBoletaporgrado", "cebg", "WITH", "cebg.gradoid=g.gradoid")
				->innerJoin("AppBundle:CeBoletas", "ceb", "WITH", "ceb.boletaid=cebg.boletaid")
				->innerJoin("AppBundle:CeBoletaporciclo", "cebc", "WITH", "cebc.boletaid=cebg.boletaid AND cebc.cicloid=ceg.cicloid")
				->andWhere("ceg.grupoid=:grupo")
				->andWhere($oficial ? "cebg.oficial = 1" : "cebg.oficial is null or cebg.oficial = 0")
				->setParameter("grupo", $grupoid);;
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
			var_dump($e->getMessage());
			return false;
		}
	}
	public function getBoletaById($boletaid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"ceb.boletaid AS id,"
					. "ceb.boletaid,"
					. "ceb.nombre,"
					. "ceb.formato"
			)->from("AppBundle:CeBoletas", "ceb")
				->andWhere("ceb.boletaid=:boleta")
				->setParameter("boleta", $boletaid);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
			var_dump($e->getMessage());
			return false;
		}
	}
	public function getPeriodoEvaluacionByConjuntoPeriodoEvaluacion($conjuntoperiodoevaluacionid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"cepe.periodoevaluacionid AS id",
				"cepe.descripcion",
				"cepe.descripcioncorta",
				"cepe.fechapublicacionprevia",
				"cepe.fechapublicaciondefinitiva",
				"cepe.fechainicio",
				"cepe.fechaperiodorevisionfin",
				"cepe.fechafin",
				"cepe.porcentajecalificacionfinal"
			)->from("AppBundle:CePeriodoevaluacion", "cepe")
				->andWhere("cepe.conjuntoperiodoevaluacionid=:conjunto")
				->setParameter("conjunto", $conjuntoperiodoevaluacionid);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
			return false;
		}
	}
	public function getBIAlumnoCicloByCicloAlumno($cicloid, $alumnoid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"ceac.alumnoporcicloid AS id,"
					. "IDENTITY(ceac.alumnoid) AS alumnoid"
			)->from("AppBundle:CeAlumnoporciclo", "ceac")
				->andWhere("ceac.cicloid=:ciclo")
				->andWhere("ceac.alumnoid IN (:alumnos)")
				->setParameter("ciclo", $cicloid)
				->setParameter("alumnos", $alumnoid);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
			return false;
		}
	}
	public function getBIAlumnoCicloByGrupo($grupoid, $alumnoid = null)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"ceacg.alumnocicloporgrupo AS alumnocicloporgrupoid",
				"ceac.alumnoporcicloid",
				"cea.alumnoid"
			)->from("AppBundle:CeAlumnocicloporgrupo", "ceacg")
				->innerJoin("AppBundle:CeAlumnoporciclo", "ceac", "WITH", "ceac.alumnoporcicloid=ceacg.alumnoporcicloid")
				->innerJoin("AppBundle:CeAlumno", "cea", "WITH", "cea.alumnoid=ceac.alumnoid")
				->andWhere("ceacg.grupoid=:grupo")
				->orderBy("ceacg.numerolista")
				->setParameter("grupo", $grupoid);
			if ($alumnoid) {
				$qb->andWhere("cea.alumnoid=:alumno")
					->setParameter("alumno", $alumnoid);
			}
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
			return false;
		}
	}
	public function getBIPeriodoEvaluacionById($periodoevaluacionid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"cepe.periodoevaluacionid AS id,"
					. "cepe.descripcion,"
					. "cepe.descripcioncorta"
			)->from("AppBundle:CePeriodoevaluacion", "cepe")
				->andWhere("cepe.periodoevaluacionid IN (:periodo)")
				->setParameter("periodo", $periodoevaluacionid);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
			return false;
		}
	}
	public function getAlumnoByCicloGradoMatricula($cicloid, $gradoid, $matricula)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"ceacg.alumnocicloporgrupo AS id",
				"ceacg.alumnocicloporgrupo",
				"ceac.alumnoporcicloid",
				"ceg.grupoid",
				"cea.alumnoid"
			)->from("AppBundle:CeAlumnocicloporgrupo", "ceacg")
				->innerJoin("AppBundle:CeAlumnoporciclo", "ceac", "WITH", "ceac.alumnoporcicloid=ceacg.alumnoporcicloid")
				->innerJoin("AppBundle:CeAlumno", "cea", "WITH", "cea.alumnoid=ceac.alumnoid")
				->innerJoin("AppBundle:CeGrupo", "ceg", "WITH", "ceg.grupoid=ceacg.grupoid")
				->andWhere("ceac.cicloid=:ciclo")
				->andWhere("ceac.gradoid=:grado")
				->andWhere("cea.matricula=:matricula")
				->andWhere("ceg.tipogrupoid=1")
				->setParameter("ciclo", $cicloid)
				->setParameter("grado", $gradoid)
				->setParameter("matricula", $matricula);
			$data = $qb->getQuery()->getResult();
			return $data;
		} catch (\Exception $e) {
			return false;
		}
	}
	public function getExtraordinarios($kalumno, $kprofesorpormateriaplanestudios)
	{
		try {
			return $this->em->createQueryBuilder()
				->select("ceae.calificacionfinal AS cali")
				->from("AppBundle:CeExtraordinario", "cee")
				->innerJoin("AppBundle:CeAcuerdoextraordinario", "ceae", "WITH", "ceae.extraordinarioid=cee.extraordinarioid")
				->andWhere("cee.profesorpormateriaplanestudiosid=:kpmpe")
				->andWhere("ceae.estatusextraordinarioid IN (:estatus)")
				->andWhere("cee.alumnoid=:kalumno")
				->setParameter("kalumno", $kalumno)
				->setParameter("kpmpe", $kprofesorpormateriaplanestudios)
				->setParameter("estatus", [4, 5])
				->addOrderBy("ceae.intento", "ASC")
				->getQuery()->getResult();
		} catch (\Exception $e) {
			return false;
		}
	}
	public function existSubmateriaConfig($kciclo, $kgrado, $kplanestudio, $kperiodo, $kmateriapepadre)
	{
		try {
			return $this->em->createQueryBuilder()
				->select("ceaem.aprendizajeesperadopormateriaid")
				->from("AppBundle:CeAprendizajeesperado", "ceae")
				->innerJoin("AppBundle:CeAprendizajeesperadopormateria", "ceaem", "WITH", "ceaem.aprendizajesesperadoid=ceae.aprendizajeesperadoid")
				->andWhere("ceae.cicloid=:kciclo")
				->andWhere("ceae.gradoid=:kgrado")
				->andWhere("ceae.planestudioid=:kplanestudio")
				->andWhere("ceae.periodoevaluacionid=:kperiodo")
				->andWhere("ceaem.materiaporplanestudioid=:kmateriapepadre")
				->setParameter("kciclo", $kciclo)
				->setParameter("kgrado", $kgrado)
				->setParameter("kplanestudio", $kplanestudio)
				->setParameter("kperiodo", $kperiodo)
				->setParameter("kmateriapepadre", $kmateriapepadre)
				->getQuery()->getResult();
		} catch (\Exception $e) {
			return false;
		}
	}
	public function validSubmateriaConfig($kaprendizajepormateria, $kmateria)
	{
		try {
			return $this->em->createQueryBuilder()
				->select("ceams.aprendizajeesperadopormaterisubmateriaid")
				->from("AppBundle:CeAprendizajepormateriaporsubmateria", "ceams")
				->andWhere("ceams.aprendizajepormateriaid=:aprendizajepormateriaid")
				->andWhere("ceams.materiaid=:kmateria")
				->setParameter("aprendizajepormateriaid", $kaprendizajepormateria)
				->setParameter("kmateria", $kmateria)
				->getQuery()->getResult();
		} catch (\Exception $e) {
			return false;
		}
	}
}
