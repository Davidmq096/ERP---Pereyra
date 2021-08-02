<?php
namespace AppBundle\DB\Mysql\Admisiones;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of CupoAdmision
 *
 * @author Javier Manrique
 */
class CupoAdmisionDB extends BaseDBManager {
	
	public function BuscarCupoAdmision($filtros) {
	    $qb = $this->em->createQueryBuilder();
		$result = $qb->select("c.cicloid, c.nombre ciclo, n.nivelid, n.nombre nivel, g.gradoid, g.grado,
		DATE_FORMAT(cu.iniciorecepcion, '%d/%m/%Y') as iniciorecepcion, DATE_FORMAT(cu.finrecepcion, '%d/%m/%Y') as finrecepcion, 
		cu.cupo, cu.cantidadfichas, cu.listaespera, cu.activo, cu.cupoadmisionid,
		cu.textolistaespera, cu.textocompleto, cu.textocapturaficha,
		DATE_FORMAT(cu.fechaentregaresultados, '%d/%m/%Y') as fechaentregaresultados,
		DATE_FORMAT(cu.fechapagoadeudos, '%d/%m/%Y') as fechapagoadeudos,
		DATE_FORMAT(cu.fechaentregainscripcion, '%d/%m/%Y') as fechaentregainscripcion,
		DATE_FORMAT(cu.fechaedad, '%d/%m/%Y') as fechaedad")
	    ->from("AppBundle:Cupoadmision", 'cu')
	    ->innerJoin('cu.cicloid', 'c')
	    ->innerJoin('cu.gradoid', 'g')
	    ->innerJoin('g.nivelid', 'n');
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
	    return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
	}
}