<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Componente Curricular
 *
 * @author Mariano
 */
class ComponenteCurricularDB extends BaseDBManager {

    public function BuscarPonderaciones($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('p')
        ->from("AppBundle:CePonderacion", 'p');  
        if (isset($filtros['nombre'])) {
        	$result->andWhere('p.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['nombre'].'%');
        }
        if (isset($filtros['activo'])) {
        	$result->andWhere('p.activo = :activo')
        	->setParameter('activo', $filtros['activo']);
        }
        if (isset($filtros['ponderacionid'])) {
        	$result->andWhere('p.ponderacionid = :ponderacionid')
        	->setParameter('ponderacionid', $filtros['ponderacionid']);
        }
        return $result->getQuery()->getResult();
    }
    public function BuscarComponentesCurriculares($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('c')
        ->from("AppBundle:CeComponentecurricular", 'c');  
        if (isset($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
        	$result->andWhere('c.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['nombre'].'%');
        }
        if (isset($filtros['activo'])) {
        	$result->andWhere('c.activo = :activo')
        	->setParameter('activo', $filtros['activo']);
        }
        return $result->getQuery()->getResult();
    }

}
