<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of PeriodoEvaluacion
 *
 * @author Mariano
 */
class PeriodoEvaluacionDB extends BaseDBManager
{

    public function BuscarPeriodoEvaluacion($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $grados = $qb->select("GroupConcat(gr.gradoid SEPARATOR ',')")
            ->from("AppBundle:CeGradoporconjuntoperiodoescolar", "gid")
            ->innerJoin("gid.gradoid", "gr")
            ->where("ce.conjuntoperiodoevaluacionid = gid.conjuntoperiodoevaluacionid")
            ->groupBy("gid.conjuntoperiodoevaluacionid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select(
            "c.cicloid",
            "c.nombre as ciclo",
            "n.nivelid",
            "n.nombre as nivel",
            "GroupConcat(g.grado Order by g.grado SEPARATOR ', ') as grado",
            "ce.conjuntoperiodoevaluacionid",
            "s.semestreid",
            "s.nombre as semestre",
            "ce.promediable"
        )
            ->addSelect("(" . $grados . ") gradoid")
            ->from("AppBundle:CeConjuntoperiodoevaluacion", "ce")
            ->innerJoin("AppBundle:CeGradoporconjuntoperiodoescolar", "gcpe", Expr\Join::WITH, "ce.conjuntoperiodoevaluacionid=gcpe.conjuntoperiodoevaluacionid")
            ->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "ce.cicloid=c.cicloid")
            ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "gcpe.gradoid=g.gradoid")
            ->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid=g.nivelid")
            ->leftJoin("g.semestreid", "s")
            ->groupBy("ce.conjuntoperiodoevaluacionid");
        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid = :cicloid')
                ->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid in (:nivelid)')
                ->setParameter('nivelid',  $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid in (:gradoid)')
                ->setParameter('gradoid', $filtros['gradoid']);
        }

        return $result->getQuery()->getResult();
    }
}
