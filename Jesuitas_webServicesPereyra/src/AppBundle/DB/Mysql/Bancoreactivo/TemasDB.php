<?php

namespace AppBundle\DB\Mysql\Bancoreactivo;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Paises
 *
 * @author Javier
 */
class TemasDB extends BaseDBManager {

    public function BuscarTemas($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('t')
        ->from("AppBundle:BrTema", 't')
        ->innerJoin("t.areaid", 'a')
        ->innerJoin('a.nivelid', 'n')
        ->innerJoin("t.materiaid", 'm');
        if (isset($filtros['tema'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['tema']=str_replace($escape,$escapados,$filtros['tema']);
        	$result->andWhere('t.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['tema'].'%');
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
