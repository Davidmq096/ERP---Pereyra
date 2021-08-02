<?php

namespace AppBundle\DB\Mysql\Ludoteca;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author Mariano
 */
class InscripcionDB extends BaseDBManager
{
	public function BuscarContratos($filtros)
	{

		$qb = $this->em->createQueryBuilder();
		$ultimociclo = $qb->select('Case WHEN max(ccca.cicloid) IS NULL THEN max(ccc.cicloid) ELSE max(ccca.cicloid) END')
			->from("AppBundle:CeAlumnoporciclo", "acu")
			->innerJoin("acu.cicloid", "ccc")
			->leftJoin("AppBundle:Ciclo", "ccca", Expr\Join::WITH, "acu.cicloid = ccca.cicloid and ccca.actual = 1")
			->where("acu.alumnoid = a.alumnoid")
			->groupBy('acu.alumnoid');
		$ultimociclo->getQuery()->getDQL();

		$qb = $this->em->createQueryBuilder();
		$gradoactual = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
			->from("AppBundle:CeAlumnoporciclo", "ac2")
			->innerJoin("ac2.gradoid", "g2")
			->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = (" . $ultimociclo . ")")
			->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
			->where("a.alumnoid = ac2.alumnoid")
			->getQuery()->getDQL();

		$qb = $this->em->createQueryBuilder();
		$grupo = $qb->select('Case WHEN gr2.grupoid IS NOT NULL THEN ag2.alumnocicloporgrupo ELSE 0 END')
			->from("AppBundle:CeAlumnocicloporgrupo", "ag2")
			->innerJoin("AppBundle:CeGrupo", "gr2",  Expr\Join::WITH, "ag2.grupoid = gr2.grupoid and gr2.tipogrupoid = 1")
			->where("ag2.alumnoporcicloid = ac.alumnoporcicloid and gr2.gradoid = g.gradoid")
			->groupBy("ag2.alumnoporcicloid");

		$qb = $this->em->createQueryBuilder();
		$result = $qb->select(
			"c.contratoid AS id",
			"t.tipoid",
			"t.nombre AS tipo",
			"a.matricula",
			"a.apellidopaterno",
			"a.apellidomaterno",
			"a.primernombre",
			"a.segundonombre",
			"concat_ws(' ',a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) AS nombrealumno",
			"n.nombre AS nivel",
			"g.grado",
			"gru.nombre AS grupo",
			"DATE_FORMAT(c.fechaalta, '%d/%m/%Y') AS fechaalta",
			"DATE_FORMAT(c.fechabaja, '%d/%m/%Y') AS fechabaja",
			"ce.contratoestatusid",
			"ce.nombre AS estatus",
			"cm.fecha",
			"groupconcat(DISTINCT dp.documentoporpagarid)",
			"SUM(CASE WHEN CURRENT_DATE() > dp.fechalimitepago and dp.saldo > 0 THEN (dp.saldo - dp.descuento) ELSE 0 END) AS adeudo",
			"DATE_DIFF(CURRENT_DATE(),MIN(CASE WHEN CURRENT_DATE() > dp.fechalimitepago and dp.saldo > 0 THEN dp.fechalimitepago ELSE CURRENT_DATE() END)) AS diasadeudo",
			"pe.pagoestatusid",
			"pe.nombre AS pagoestatus",
			"c.motivocancelacion",
			"n.nivelid",
			"dp.fechalimitepago"
		)->from("AppBundle:LuContrato", "c")
			->innerJoin("AppBundle:LuTipo", "t", Expr\Join::WITH, "t.tipoid=c.tipoid")
			->innerJoin("c.contratoestatusid", "ce")
			->innerJoin("AppBundle:LuContratopormes", "cm", Expr\Join::WITH, "cm.contratoid=c.contratoid")
			->innerJoin("AppBundle:CjDocumentoporpagar", "dp", Expr\Join::WITH, "dp.documentoporpagarid=cm.documentoporpagarid")
			->leftJoin("AppBundle:CjPagoestatus", "pe", Expr\Join::WITH, "pe.pagoestatusid=dp.pagoestatusid")

			->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid=c.alumnoid")
			->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid=a.alumnoid and ac.gradoid = (" . $gradoactual . ")")
			->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid=ac.gradoid")
			->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid=g.nivelid")
			
			->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnocicloporgrupo = (" . $grupo . ")")
			->leftJoin("AppBundle:CeGrupo", "gru", Expr\Join::WITH, "gru.grupoid=acg.grupoid")
			
			->groupBy('c.contratoid');
		if (isset($filtros['nivelid'])) {
			$result->andWhere('n.nivelid IN (:nivelid)')
				->setParameter('nivelid', $filtros['nivelid']);
		}
		if (isset($filtros['gradoid'])) {
			$result->andWhere('g.gradoid IN (:gradoid)')
				->setParameter('gradoid', $filtros['gradoid']);
		}
		if (isset($filtros['grupoid'])) {
			$result->andWhere('gru.grupoid = :grupoid')
				->setParameter('grupoid', $filtros['grupoid']);
		}
		if (isset($filtros['contratoestatusid'])) {
			$result->andWhere('ce.contratoestatusid = :contratoestatusid')
				->setParameter('contratoestatusid', $filtros['contratoestatusid']);
		}
		if (!empty($filtros['matricula'])) {
			$result->andWhere('a.matricula = :matricula')
				->setParameter('matricula', $filtros['matricula']);
		}
		if (isset($filtros['contratoid'])) {
			$result->andWhere('c.contratoid = :contratoid')
				->setParameter('contratoid', $filtros['contratoid']);
		}
		if (isset($filtros['pagoestatusid'])) {
			$result->andWhere('pe.pagoestatusid in (:pagoestatusid)')
				->setParameter('pagoestatusid', $filtros['pagoestatusid']);
		}
		if (isset($filtros['fecha'])) {
			$result->andWhere('cm.fecha = :fecha')
				->setParameter('fecha', $filtros['fecha']);
		}
		if (isset($filtros['tipoid'])) {
			$result->andWhere('t.tipoid = :tipoid')
				->setParameter('tipoid', $filtros['tipoid']);
		}
		return $result->getQuery()->getResult();
	}
}
