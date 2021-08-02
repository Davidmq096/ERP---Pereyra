<?php
namespace AppBundle\DB\Mysql\Admisiones;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of CupoAdmision
 *
 * @author Javier Manrique
 */
class FormatoDB extends BaseDBManager {
	
	public function BuscarFormato($filtros) {
	    $qb = $this->em->createQueryBuilder();
	    $result = $qb->select("gf, GroupConcat(g.grado, '° ' Order by g.grado ), GroupConcat(g.gradoid, '' Order by g.gradoid )")
	    ->from("AppBundle:Gradoporformato", 'gf')
	    ->innerJoin('gf.gradoid', 'g')
	    ->innerJoin('g.nivelid', 'n')
	    ->innerJoin('gf.formatoid', 'f')
	    ->innerJoin('f.tipoformatoid', 'tf')
	    ->groupBy('tf.tipoformatoid, n.nivelid, f.formatoid');
	    if (isset($filtros['activo'])) {
	        $result->andWhere('f.activo = true');
	    }
	    if (isset($filtros['nivelid'])) {
	    	$result->andWhere('n.nivelid IN (:nivelid)')
	    	->setParameter('nivelid' , $filtros['nivelid']);
	    }
	    if (isset($filtros['gradoid'])) {
	    	$result->andWhere('g.gradoid IN (:gradosid)')
	    	->setParameter('gradosid' , $filtros['gradoid']);
	    }
	    if (isset($filtros['tipoformatoid'])) {
	        $result->andWhere('tf.tipoformatoid IN (:tipoformatoid)')
	        ->setParameter('tipoformatoid', $filtros['tipoformatoid']);
	    }
	     
	    return $result->getQuery()->getResult();
	}

	public function ValidarRelacionFormato($tipoformatoid, $listgradosid) {
	    $qb = $this->em->createQueryBuilder();
	    $result = $qb->select("tf.nombre ,GroupConcat(g.grado, '' Order by g.grado ) grados, gf relaciones")
	    ->from("AppBundle:Gradoporformato", 'gf')
	    ->innerJoin('gf.gradoid', 'g')
	    ->innerJoin('gf.formatoid', 'f')
	    ->innerJoin('f.tipoformatoid', 'tf')
	    ->where('tf.tipoformatoid = '. $tipoformatoid)
	    ->andWhere('g.gradoid IN (:idsgrado)')
	    ->setParameter('idsgrado',  explode(',',$listgradosid));
	    
	    return $result->getQuery()->getResult();
	}
	
}