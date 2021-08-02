<?php

namespace AppBundle\DB\Mysql\Admisiones;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Factoresapoyo
 *
 * @author Javier
 */
class FactoresApoyoDB extends BaseDBManager {

    public function BuscarFactoresapoyo($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("f factores,
        GroupConcat(g.grado, '° ' Order by g.grado ) grado, GroupConcat(g.gradoid, '' Order by g.gradoid ) gradoid, 
        n.nivelid, n.nombre nivel")
        ->from("AppBundle:AdFactoresapoyo", 'f')
        ->innerJoin("f.categoriaapoyoid", 'c')
        ->innerJoin("AppBundle:AdCategoriaapoyoporgrado", "cg", Expr\Join::WITH, "c.categoriaapoyoid = cg.categoriaapoyoid")
        ->innerJoin("cg.gradoid", 'g')
        ->innerJoin("g.nivelid", 'n')
        ->groupBy("f.factoresapoyoid");  
        if (isset($filtros['nombre'])) {
        	$result->andWhere('f.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['nombre'].'%');
        }
        if (isset($filtros['categoriaapoyoid'])) {
        	$result->andWhere('c.categoriaapoyoid = '. $filtros["categoriaapoyoid"]);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid IN (:gradoid)')
        	->setParameter('gradoid' , $filtros['gradoid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['activo'])) {
        	$result->andWhere('f.activo = true');
        }
        return $result->getQuery()->getResult();
    }

}
