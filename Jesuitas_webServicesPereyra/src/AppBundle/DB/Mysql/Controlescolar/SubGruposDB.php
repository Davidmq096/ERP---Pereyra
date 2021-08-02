<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Gruposs
 *
 * @author Mariano
 */
class SubGruposDB extends BaseDBManager {

    public function BuscarSubgruposDivisor($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.nombre ciclo, c.cicloid, a.nombre areaespecializacion, a.areaespecializacionid,
        n.nombre nivel, n.nivelid, g.grado, g.gradoid, s.semestreid,
        pe.planestudioid, pe.nombre planestudio, 
        cpe.clasificadorparaescolaresid, cpe.nombre clasificadorparaescolares,
        mpe.materiaporplanestudioid as materiaid, m.nombre materia,
        GroupConcat(distinct gr.grupoid) subgrupos,
        gr.cupo, gro.grupoid grupoorigenid, gro.nombre grupoorigen")
        ->from('AppBundle:CeGrupo', 'gr')
        ->innerJoin('gr.cicloid', 'c')
        ->innerJoin('gr.gradoid', 'g')
        ->innerJoin('g.nivelid', 'n')
        ->leftJoin('g.semestreid', 's')
        ->leftJoin('gr.nivelparaescolaresid', 'npe')

        ->innerJoin('AppBundle:CeGrupoorigenporsubgrupo', 'gos', Expr\Join::WITH, "gos.grupoid = gr.grupoid")
        ->innerJoin('gos.grupoorigenid', 'gro')
        ->leftJoin('gro.areaespecializacionid', 'a')
       

        ->innerJoin('AppBundle:CeMateriaporplanestudios', 'mpe', Expr\Join::WITH, "mpe.materiaporplanestudioid = gos.materiaporplanestudioid")
        ->innerJoin('mpe.planestudioid', 'pe')
        ->innerJoin('mpe.materiaid', 'm')
        ->innerJoin('m.clasificadorparaescolaresid', 'cpe')
        
        
        
        ->andWhere("gr.tipogrupoid = 2");

        if(empty($filtros['group'])){
            $result->groupBy("gos.grupoorigenid, mpe.materiaporplanestudioid");
        }else{
            $result->groupBy("gr.grupoid,mpe.materiaporplanestudioid");
        }


        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid = :cicloid')
        	->setParameter('cicloid', $filtros['cicloid']);
        }
        if (count($filtros['nivelid'])>0) {
        	$result->andWhere('n.nivelid in (:nivelid)')
        	->setParameter('nivelid', $filtros['nivelid']);
        }
        if (count($filtros['gradoid'])>0) {
        	$result->andWhere('g.gradoid in (:gradoid)')
        	->setParameter('gradoid', $filtros['gradoid']);
        }
        if (isset($filtros['semestreid'])) {
        	$result->andWhere('s.semestreid = :semestreid')
        	->setParameter('semestreid', $filtros['semestreid']);
        }
        if (isset($filtros['planestudioid'])) {
        	$result->andWhere('pe.planestudioid = :planestudioid')
        	->setParameter('planestudioid', $filtros['planestudioid']);
        }
        if (isset($filtros['materiaid'])) {
        	$result->andWhere('mpe.materiaporplanestudioid = :materiaid')
        	->setParameter('materiaid', $filtros['materiaid']);
        }
        if (isset($filtros['grupoorigenid'])) {
        	$result->andWhere('gro.grupoid = :grupoorigenid')
        	->setParameter('grupoorigenid', $filtros['grupoorigenid']);
        }
        if (isset($filtros['areaespecializacionid'])) {
        	$result->andWhere('a.areaespecializacionid = :areaespecializacionid')
        	->setParameter('areaespecializacionid', $filtros['areaespecializacionid']);
        }
        return $result->getQuery()->getResult();
    }

}
