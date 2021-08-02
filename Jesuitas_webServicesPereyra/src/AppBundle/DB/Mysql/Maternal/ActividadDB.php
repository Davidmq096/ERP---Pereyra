<?php

namespace AppBundle\DB\Mysql\Maternal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Actividad
 *
 * @author Mariano
 */
class ActividadDB extends BaseDBManager {

    public function BuscarActividad($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a")
        ->from("AppBundle:MaActividad","a");
        if (isset($filtros['descripcion'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['descripcion']=str_replace($escape,$escapados,$filtros['descripcion']);
        	$result->andWhere('a.descripcion like :descripcion')
        	->setParameter('descripcion', '%'.$filtros['descripcion'].'%');
        }

        return $result->getQuery()->getResult();
    }

}
