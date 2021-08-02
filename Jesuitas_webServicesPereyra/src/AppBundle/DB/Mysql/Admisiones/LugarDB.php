<?php

namespace AppBundle\DB\Mysql\Admisiones;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of LugarDB
 *
 * @author Alejandro
 */
class LugarDB extends BaseDBManager {
    /*
     * Metodo para obtener Lugares por filtros de busqueda
     */

    public function BuscarLugar($filtros) {
    	$qb = $this->em->createQueryBuilder();
    	$result = $qb->select("le , GroupConcat(te.nombre SEPARATOR ', ' ), GroupConcat(te.tipoevaluacionid, '')")
    	->from("AppBundle:Lugarportipoevaluacion", 'le')
    	->innerJoin('le.lugarid', 'l')
    	->innerJoin('l.edificioid', 'e')
    	->innerJoin('le.tipoevaluacionid', 'te')
    	->groupBy('l.lugarid');
    	if (isset($filtros['tipoevaluacionid'])) {
    		$result->andWhere('te.tipoevaluacionid =' . $filtros['tipoevaluacionid']);
    	}
    	if (isset($filtros['edificioid'])) {
    		$result->andWhere('e.edificioid =' . $filtros['edificioid']);
    	}
    	if (isset($filtros['lugar'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['lugar']=str_replace($escape,$escapados,$filtros['lugar']);
    		$result->andWhere('l.nombre like :nombre')
    		->setParameter('nombre', '%' . $filtros['lugar']. '%');
    	}
    	if (isset($filtros['capacidad'])) {
    		$result->andWhere('l.cupo =' . $filtros['capacidad']);
    	}
    	if (isset($filtros['proyector'])) {
    		$result->andWhere('l.proyector =' . $filtros['proyector']);
    	}
    	if (isset($filtros['equipocomputo'])) {
    		$result->andWhere('l.equipocomputo =' . $filtros['equipocomputo']);
    	}
    	if (isset($filtros['internet'])) {
    		$result->andWhere('l.internet =' . $filtros['internet']);
    	}
    	return $result->getQuery()->getResult();    	
    }

}
