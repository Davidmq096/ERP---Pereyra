<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Reporte disciplina
 *
 * @author David
 */
class ReporteDisciplinaDB extends BaseDBManager{
	public function BuscarReportes($filtros){
		$qb=$this->em->createQueryBuilder();
		$result=$qb->select("rd.reportedisciplinaid,ac.alumnoporcicloid",
				"mpe.materiaporplanestudioid",
				"tr.tiporeporteid",
				"c.cicloid",
				"g.gradoid",
				"gr.grupoid",
				"c.nombre AS ciclo",
				"n.nombre AS nivel",
				"g.grado AS grado",
				"gr.nombre AS grupo",
				"m.nombre AS materia",
				"tr.nombre AS tiporeporte",
				"rd.observaciones",
				"a.matricula",
				"a.primernombre",
				"a.segundonombre",
				"a.apellidopaterno",
				"a.apellidomaterno",
				"ad.areadisciplinaid",
				"ad.nombre as area",
				"DATE_FORMAT(rd.fecha, '%d/%m/%Y') AS fecha",
				"CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre) AS nombrecompleto",
				"CONCAT_WS(' ', p.apellidopaterno, p.apellidomaterno, p.nombre) AS cuenta"
			)->from("AppBundle:CeReportedisciplina", 'rd')
			->leftJoin("AppBundle:CeTiporeporte", "tr", Expr\Join::WITH, "tr.tiporeporteid  = rd.tiporeporteid")
			->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoporcicloid = rd.alumnoporcicloid")
			->innerJoin('AppBundle:CeAlumno', 'a', Expr\Join::WITH, "a.alumnoid = ac.alumnoid")
			->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid = ac.cicloid")
			->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid = ac.gradoid")
			->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid = g.nivelid")
			->leftJoin("AppBundle:CeMateriaporplanestudios", "mpe", Expr\Join::WITH, "mpe.materiaporplanestudioid = rd.materiaporplanestudiosid")
			->leftJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid  = mpe.materiaid")
			->leftJoin('AppBundle:CeAlumnocicloporgrupo', 'acg', Expr\Join::WITH, "acg.alumnoporcicloid = rd.alumnoporcicloid")
			->leftJoin('AppBundle:CeGrupo', 'gr', Expr\Join::WITH, "gr.grupoid = acg.grupoid")
			->innerJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.usuarioid = rd.usuarioid")
			->leftJoin("AppBundle:CeAreadisciplina", "ad", Expr\Join::WITH, "ad.areadisciplinaid = rd.areadisciplinaid")
			->innerJoin("u.personaid", "p")
			->groupBy('rd.reportedisciplinaid')
		;

		if(isset($filtros['cicloid'])){
			$result->andWhere('c.cicloid IN (:cicloid)')
				->setParameter('cicloid', $filtros['cicloid']);
		}

		if(isset($filtros['nivelid'])){
			$result->andWhere('n.nivelid IN (:nivelid)')
				->setParameter('nivelid', $filtros['nivelid']);
		}

		if(isset($filtros['gradoid'])){
			$result->andWhere('g.gradoid IN (:gradoid)')
				->setParameter('gradoid', $filtros['gradoid']);
		}

		if(isset($filtros['materiaid'])){
			$result->andWhere('m.materiaid IN (:materiaid)')
				->setParameter('materiaid', $filtros['materiaid']);
		}

		if(isset($filtros['grupoid'])){
			$result->andWhere('gr.grupoid IN (:grupoid)')
				->setParameter('grupoid', $filtros['grupoid']);
		}

		if(isset($filtros['tiporeporteid'])){
			$result->andWhere('tr.tiporeporteid IN (:tiporeporteid)')
				->setParameter('tiporeporteid', $filtros['tiporeporteid']);
		}

		if(isset($filtros['matricula'])){
			$escape=array("_", "%");
			$escapados=array("\_", "\%");
			$filtros['matricula']=trim(str_replace($escape, $escapados, $filtros['matricula']));
			$result->andWhere('a.matricula like :matricula')
				->setParameter('matricula', '%'.$filtros['matricula'].'%');
		}



		if(isset($filtros['fechainicio'])){
			$dateinicio=new \DateTime($filtros['fechainicio']);
			$datefin=new \DateTime($filtros['fechafin']);
			$result->andWhere('rd.fecha between :fechainicio and :fechafin')
				->setParameter("fechainicio", $dateinicio)
				->setParameter("fechafin", $datefin);
		}

		if(isset($filtros['reportedisciplinaid'])){
			$result->andWhere('rd.reportedisciplinaid = :reportedisciplinaid')
				->setParameter('reportedisciplinaid', $filtros['reportedisciplinaid']);
		}

		return $result->getQuery()->getResult();
	}
}