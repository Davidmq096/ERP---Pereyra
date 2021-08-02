<?php

namespace AppBundle\DB\Mysql\Bancoreactivo;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Paises
 *
 * @author Javier
 */
class SubtemasDB extends BaseDBManager {

    public function BuscarSubtemas($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('s')
        ->from("AppBundle:BrSubtema", 's')
        ->innerJoin("s.temaid", 't')
        ->innerJoin("t.materiaid", 'm')
        ->innerJoin("t.areaid", 'a')
        ->innerJoin("a.nivelid", 'n');  
        if (isset($filtros['subtema'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['subtema']=str_replace($escape,$escapados,$filtros['subtema']);
        	$result->andWhere('s.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['subtema'].'%');
        }
        if (isset($filtros['temaid'])) {
        	$result->andWhere('t.temaid ='. $filtros['temaid']);
        }
        if (isset($filtros['areaid'])) {
        	$result->andWhere('a.areaacademicaid ='. $filtros['areaid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['materiaid'])) {
        	$result->andWhere('m.materiaid ='.$filtros['materiaid']);
        }
        return $result->getQuery()->getResult();
    }

}
