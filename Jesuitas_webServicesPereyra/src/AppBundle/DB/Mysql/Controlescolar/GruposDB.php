<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Gruposs
 *
 * @author Mariano
 */
class GruposDB extends BaseDBManager {

    public function BuscarGrupos($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('gru.grupoid,gru.nombre,c.nombre as ciclo,c.cicloid,n.nombre as nivel,n.nivelid,g.gradoid,a.nombre as areaespecializacion,a.areaespecializacionid,t.tipogrupoid,
        CASE WHEN gru.cupo is null THEN \'\' ELSE gru.cupo END as cupo, gru.bloqueolista')
        ->from("AppBundle:CeGrupo", 'gru')
        ->innerJoin('AppBundle:Grado', 'g', Expr\Join::WITH, "g.gradoid=gru.gradoid")
        ->innerJoin("g.nivelid", "n")
        ->innerJoin("gru.cicloid", "c")
        ->leftJoin("gru.areaespecializacionid", "a")
        ->innerJoin("gru.tipogrupoid", "t");
        $result->Where('t.tipogrupoid = 1');
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('gru.cicloid = :cicloid')
        	->setParameter('cicloid', $filtros['cicloid']);
        }
        if (count($filtros['nivelid'])>0) {
        	$result->andWhere('g.nivelid in  (:nivelid)')
        	->setParameter('nivelid', $filtros['nivelid']);
        }
        if (count($filtros['gradoid'])>0) {
        	$result->andWhere('g.gradoid in (:gradoid)')
        	->setParameter('gradoid', $filtros['gradoid']);
        }
        if (isset($filtros['nombre'])) {
        	$result->andWhere('gru.nombre = :nombre')
        	->setParameter('nombre', $filtros['nombre']);
        }
        if (isset($filtros['areaespecializacionid'])) {
        	$result->andWhere('a.areaespecializacionid = :areaespecializacionid')
        	->setParameter('areaespecializacionid', $filtros['areaespecializacionid']);
        }
        return $result->getQuery()->getResult();
    }

}
