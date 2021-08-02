<?php

namespace AppBundle\DB\Mysql\Maternal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Higiene
 *
 * @author Mariano
 */
class HigieneDB extends BaseDBManager {

    public function BuscarHigiene($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("h")
        ->from("AppBundle:MaHigiene","h");
        if (isset($filtros['descripcion'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['descripcion']=str_replace($escape,$escapados,$filtros['descripcion']);
        	$result->andWhere('h.descripcion like :descripcion')
        	->setParameter('descripcion', '%'.$filtros['descripcion'].'%');
        }

        return $result->getQuery()->getResult();
    }

}
