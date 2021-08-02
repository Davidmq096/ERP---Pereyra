<?php

namespace AppBundle\DB\Mysql\Bancoreactivo;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Areas
 *
 * @author Javier
 */
class AreasDB extends BaseDBManager {

    public function BuscarAreas($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('a')
        ->from("AppBundle:BrArea", 'a');  
        if (isset($filtros['area'])) {
        	$result->andWhere('a.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['area'].'%');
        }
        if (isset($filtros['clave'])) {
        	$result->andWhere('a.clave like :clave')
        	->setParameter('clave', '%'.$filtros['clave'].'%');
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('a.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        return $result->getQuery()->getResult();
    }

}
