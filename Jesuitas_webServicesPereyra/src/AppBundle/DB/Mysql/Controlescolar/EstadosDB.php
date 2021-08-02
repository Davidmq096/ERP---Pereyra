<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Estados
 *
 * @author javier
 */
class EstadosDB extends BaseDBManager {

    public function BuscarEstados($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('e.estadoid, e.nombre, e.abreviatura, e.activo, p.paisid, p.nombre pais')
        ->from("AppBundle:Estado", 'e')
        ->innerJoin('e.paisid', 'p');  
       if (isset($filtros['paisid'])) {
       	$result->andWhere('p.paisid =' . $filtros['paisid']);
       }
       if (isset($filtros['nombre'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
       	$result->andWhere('e.nombre like :nombre')
       	->setParameter('nombre', '%'.$filtros['nombre'].'%');
       }
       if (isset($filtros['abreviatura'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['abreviatura']=str_replace($escape,$escapados,$filtros['abreviatura']);
       	$result->andWhere('e.abreviatura like :abreviatura')
       	->setParameter('abreviatura', '%'.$filtros['abreviatura'].'%');
       }
       if (isset($filtros['activo'])) {
        $result->andWhere('e.activo = :activo')
        ->setParameter('activo', $filtros['activo']);
    }
       $result->orderBy("e.nombre");
        return $result->getQuery()->getResult();
    }

}
