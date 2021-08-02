<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Paises
 *
 * @author Javier
 */
class PaisesDB extends BaseDBManager {

    public function BuscarPaises($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('p')
        ->from("AppBundle:Pais", 'p');  
        if (isset($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
        	$result->andWhere('p.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['nombre'].'%');
        }
        if (isset($filtros['sigla2'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['sigla2']=str_replace($escape,$escapados,$filtros['sigla2']);
        	$result->andWhere('p.sigla2 like :sigla2')
        	->setParameter('sigla2', '%'.$filtros['sigla2'].'%');
        }
        if (isset($filtros['sigla3'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['sigla3']=str_replace($escape,$escapados,$filtros['sigla3']);
        	$result->andWhere('p.sigla3 like :sigla3')
        	->setParameter('sigla3', '%'.$filtros['sigla3'].'%');
        }
        if (isset($filtros['activo'])) {
        	$result->andWhere('p.activo = :activo')
        	->setParameter('activo', $filtros['activo']);
        }
        $result->orderBy("p.nombre");
        return $result->getQuery()->getResult();
    }

}
