<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql\Admisiones;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of EvaluadoresDB
 *
 * @author Alejandro Nachez
 */
class EvaluadorDB extends BaseDBManager {

    public function BuscarEvaluador($filtros) {
    	$qb = $this->em->createQueryBuilder();
		$result = $qb->select("u.usuarioid, u.cuenta,CONCAT_WS(' ',p.nombre, p.apellidopaterno) nombrecompleto,
		p.personaid, p.nombre, p.apellidopaterno, p.apellidomaterno,
		GroupConcat(DISTINCT n.nombre SEPARATOR ', ') nivel, GroupConcat(DISTINCT g.gradoid) gradoid")
    	->from("AppBundle:Usuarioporperfil", 'up')
    	->innerJoin('up.usuarioid', 'u')
		->innerJoin('u.personaid', 'p')
		->leftJoin('AppBundle:Usuarioevaluadorporgrado', 'ug', Expr\Join::WITH, "u.usuarioid = ug.usuarioid")
		->leftJoin('ug.gradoid', 'g')
		->leftJoin('g.nivelid', 'n')
    	->where("up.perfilid = 1")
    	->orWhere("up.perfilid = 2")
		->groupBy('u.usuarioid')
		->orderBy("p.nombre");
    	if (isset($filtros['usuario'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['usuario']=str_replace($escape,$escapados,$filtros['usuario']);
    		$result->andWhere('u.cuenta like :user')
    		->setParameter('user', '%' . $filtros['usuario']. '%');
    	}
    	if (isset($filtros['nombre'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
    		$result->andWhere('p.nombre like :nombre')
    		->setParameter('nombre', '%' . $filtros['nombre']. '%');
    	}
    	if (isset($filtros['apellidopaterno'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidopaterno']=str_replace($escape,$escapados,$filtros['apellidopaterno']);
    		$result->andWhere('p.apellidopaterno like :app')
    		->setParameter('app', '%' . $filtros['apellidopaterno']. '%');
    	}
    	if (isset($filtros['apellidomaterno'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidomaterno']=str_replace($escape,$escapados,$filtros['apellidomaterno']);
    		$result->andWhere('p.apellidomaterno like :apm')
    		->setParameter('apm', '%' . $filtros['apellidomaterno']. '%');
    	}
    	if (isset($filtros['usuarioid'])) {
    		$result->andWhere('u.usuarioid ='.$filtros['usuarioid']);
		}
		if (isset($filtros['gradoid'])) {
    		$result->andWhere('g.gradoid ='.$filtros['gradoid']);
    	}
    	return $result->getQuery()->getResult();  
    }

}
