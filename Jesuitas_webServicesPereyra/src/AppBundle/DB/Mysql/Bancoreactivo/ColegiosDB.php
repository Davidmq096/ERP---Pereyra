<?php

namespace AppBundle\DB\Mysql\Bancoreactivo;

use AppBundle\DB\Mysql\BaseDBManager;
/**
 * Description of Paises
 *
 * @author Javier
 */
class ColegiosDB extends BaseDBManager {

    public function BuscarColegios($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('c')
        ->from("AppBundle:BrColegio", 'c');  
        if (isset($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
        	$result->andWhere('c.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['nombre'].'%');
        }
        if (isset($filtros['clave'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['clave']=str_replace($escape,$escapados,$filtros['clave']);
        	$result->andWhere('c.clave like :clave')
        	->setParameter('clave', '%'.$filtros['clave'].'%');
        }
        return $result->getQuery()->getResult();
    }

}
