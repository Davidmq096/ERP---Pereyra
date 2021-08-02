<?php
namespace AppBundle\DB\Mysql\Admisiones;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of CupoAdmision
 *
 * @author Javier Manrique
 */
class ResultadoDB extends BaseDBManager {
	
	public function BuscarResultado($filtros) {
	    $qb = $this->em->createQueryBuilder();
	    $result = $qb->select('sac')
	    ->from("AppBundle:Solicitudadmisionporciclo", 'sac')
	    ->innerJoin('sac.cicloid', 'c')
	    ->innerJoin("sac.solicitudadmisionid", "sa")
	    ->innerJoin('sa.estatussolicitudid', 'e')
	    ->innerJoin("sa.gradoid", "g")
	    ->innerJoin("g.nivelid", "n")
	    ->innerJoin("sa.datoaspiranteid", "da");
	    if (isset($filtros['cicloid'])) {
	    	$result->andWhere('c.cicloid IN (:cicloid)')
	    	->setParameter('cicloid' , $filtros['cicloid']);
	    }
	    if (isset($filtros['nivelid'])) {
	    	$result->andWhere('n.nivelid IN (:nivelid)')
	    	->setParameter('nivelid' , $filtros['nivelid']);
	    }
	    if (isset($filtros['gradoid'])) {
	        $result->andWhere('g.gradoid IN (:gradosid)')
	        ->setParameter('gradosid' , $filtros['gradoid']);
	    }
	    if (isset($filtros['folio'])) {
	        $result->andWhere('sa.folio like :folio')
	        ->setParameter('folio', '%'.$filtros['folio'].'%');
	    }
	    if (isset($filtros['estatussolicitudid'])) {
	    	$result->andWhere('e.estatussolicitudid =' .$filtros['estatussolicitudid']);
	    }
	    if (isset($filtros['nombre'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
	        $result->andWhere('da.nombre like :nombre')
	        ->setParameter('nombre', '%'.$filtros['nombre'].'%');
	    }
	    if (isset($filtros['apellidopaterno'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidopaterno']=str_replace($escape,$escapados,$filtros['apellidopaterno']);
	        $result->andWhere('da.apellidopaterno like :apellidopaterno')
	        ->setParameter('apellidopaterno', '%'.$filtros['apellidopaterno'].'%');
	    }
	    if (isset($filtros['apellidomaterno'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidomaterno']=str_replace($escape,$escapados,$filtros['apellidomaterno']);
	        $result->andWhere('da.apellidomaterno like :apellidomaterno')
	        ->setParameter('apellidomaterno', '%'.$filtros['apellidomaterno'].'%');
	    }
	    return $result->getQuery()->getResult();
	}
	
}