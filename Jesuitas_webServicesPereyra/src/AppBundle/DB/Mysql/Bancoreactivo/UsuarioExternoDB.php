<?php

namespace AppBundle\DB\Mysql\Bancoreactivo;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Usuario externo
 *
 * @author Javier
 */
class UsuarioExternoDB extends BaseDBManager {

    public function BuscarUsuarioexterno($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('u')
        ->from("AppBundle:BrUsuarioexterno", 'u')
        ->where("u.tipousuarioexternoid = 2");  
        if (isset($filtros['grupoexterno'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['grupoexterno']=str_replace($escape,$escapados,$filtros['grupoexterno']);
        	$result->andWhere('u.grupo like :grupo')
        	->setParameter('grupo', '%'.$filtros['grupoexterno'].'%');
        }
        if (isset($filtros['usuario'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['usuario']=str_replace($escape,$escapados,$filtros['usuario']);
        	$result->andWhere('u.usuario like :usuario')
        	->setParameter('usuario', '%'.$filtros['usuario'].'%');
        }
        if (isset($filtros['colegioid'])) {
        	$result->andWhere('u.colegioid ='.$filtros['colegioid']);
        }
        if (isset($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
        	$result->andWhere('u.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['nombre'].'%');
        }
        if (isset($filtros['apellidopaterno'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidopaterno']=str_replace($escape,$escapados,$filtros['apellidopaterno']);
        	$result->andWhere('u.apellidopaterno like :apellidopaterno')
        	->setParameter('apellidopaterno', '%'.$filtros['apellidopaterno'].'%');
        }
        if (isset($filtros['apellidomaterno'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidomaterno']=str_replace($escape,$escapados,$filtros['apellidomaterno']);
        	$result->andWhere('u.apellidomaterno like :apellidomaterno')
        	->setParameter('apellidomaterno', '%'.$filtros['apellidomaterno'].'%');
        }
        return $result->getQuery()->getResult();
    }

}
