<?php

namespace AppBundle\DB\Mysql\Cobranza;

use Doctrine\ORM\Query\Expr;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Acuerdos
 *
 * @author Javier
 */
class BloqueoManualDB extends BaseDBManager {

    public function BuscarBloqueoManual($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("b.bloqueomanualid, 
        DATE_FORMAT(b.fechainicio, '%d/%m/%Y') 
        fechainicio, DATE_FORMAT(b.fechafin, '%d/%m/%Y') fechafin, b.observaciones, 
        c.cicloid, c.nombre ciclo, 
        GroupConcat(tb.nombre SEPARATOR ', ') tipobloqueo, GroupConcat(tb.tipobloqueoid) tipobloqueoid,
        e.estatusbloqueoid, e.nombre estatusbloqueo, ac.alumnoporcicloid,
        a.alumnoid")
        ->from("AppBundle:CbBloqueomanual", 'b')
        ->innerJoin("b.estatusbloqueoid", "e")
        ->innerJoin("b.alumnoporcicloid", "ac")
        ->innerJoin("ac.cicloid", "c")
        ->innerJoin('ac.alumnoid', 'a')    
        ->innerJoin("AppBundle:CbTipobloqueoporbloqueomanual", "tbbm", Expr\Join::WITH, "b.bloqueomanualid = tbbm.bloqueomanualid")
        ->innerJoin("tbbm.tipobloqueoid", "tb")
        ->groupBy("b.bloqueomanualid");
        if (isset($filtros['tipobloqueoid'])) {
            $ids = implode(",",$filtros['tipobloqueoid']);
        	$result->andWhere('tb.tipobloqueoid in ('.$ids.')');
        }
        if (isset($filtros['estatusid'])) {
        	$result->andWhere('b.estatusbloqueoid ='.$filtros['estatusid']);
        }
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid ='.$filtros['cicloid']);
        }
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

}
