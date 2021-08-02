<?php

namespace AppBundle\DB\Mysql\Maternal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Platillo
 *
 * @author Mariano
 */
class PlatilloDB extends BaseDBManager {

    public function BuscarPlatillo($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p")
        ->from("AppBundle:MaPlatillo","p");
        if (isset($filtros['descripcion'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['descripcion']=str_replace($escape,$escapados,$filtros['descripcion']);
        	$result->andWhere('p.descripcion like :descripcion')
        	->setParameter('descripcion', '%'.$filtros['descripcion'].'%');
        }
        /*
        if (isset($filtros['ingredientes'])) {
        	$result->andWhere('ingredientes like  :ingredientes')
        	->setParameter('ingredientes' , '%'.$filtros['ingredientes'].'%');
        }
        */
        return $result->getQuery()->getResult();
    }

}
