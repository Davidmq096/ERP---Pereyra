<?php

namespace AppBundle\DB\Mysql\Admisiones;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Categoriaapoyo
 *
 * @author Javier
 */
class CategoriaApoyoDB extends BaseDBManager {

    public function BuscarCategoriaapoyo($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.nombre, c.descripcion, c.categoriaapoyoid, c.activo,  
        GroupConcat(g.grado, '° ' Order by g.grado ) grado, GroupConcat(g.gradoid, '' Order by g.gradoid ) gradoid,
        n.nivelid, n.nombre as nivel")
        ->from("AppBundle:AdCategoriaapoyo", 'c')
        ->innerJoin("AppBundle:AdCategoriaapoyoporgrado", "cg", Expr\Join::WITH, "c.categoriaapoyoid = cg.categoriaapoyoid")
        ->innerJoin("cg.gradoid", 'g')
        ->innerJoin("g.nivelid", 'n')
        ->groupBy("c.categoriaapoyoid");  
        if (isset($filtros['nombre'])) {
        	$result->andWhere('c.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['nombre'].'%');
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
        	$result->andWhere('c.activo = :activo')
        	->setParameter('activo' , $filtros['activo']);
        }
        return $result->getQuery()->getResult();
    }

}
