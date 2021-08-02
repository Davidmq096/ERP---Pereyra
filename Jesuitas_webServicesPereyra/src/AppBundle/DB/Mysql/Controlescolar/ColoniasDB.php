<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Colonias
 *
 * @author David
 */
class ColoniasDB extends BaseDBManager {

    public function BuscarColonias($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('c.coloniaid, c.cp, c.nombre, m.municipioid, m.nombre municipio,
        e.estadoid, e.nombre estado, p.paisid, p.nombre pais')
        ->from("AppBundle:Colonia", 'c')
        ->innerJoin('c.municipioid', 'm')
        ->innerJoin("m.estadoid", 'e')
       ->innerJoin("e.paisid", "p");  
       if (isset($filtros['paisid'])) {
       	$result->andWhere('p.paisid =' . $filtros['paisid']);
       }
        if (isset($filtros['estadoid'])) {
            $result->andWhere('e.estadoid =' . $filtros['estadoid']);
        }
        if (isset($filtros['municipioid'])) {
            $result->andWhere('m.municipioid =' . $filtros['municipioid']);
        }
        if (isset($filtros['activo'])) {
        	$result->andWhere('c.activo = :activo')
        	->setParameter('activo', $filtros['activo']);
        }
        $result->orderBy("c.nombre");
        return $result->getQuery()->getResult();
    }

}
