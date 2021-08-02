<?php
namespace AppBundle\DB\Mysql\Admisiones;

use AppBundle\DB\Mysql\BaseDBManager;
/**
 * Description of Evaluacion
 *
 * @author Javier Manrique
 */
class EvaluacionDB extends BaseDBManager {
	
	public function BuscarEvaluacion($filtros) {
	    $qb = $this->em->createQueryBuilder();
		$result = $qb->select("p.evaluacionid, p.nombre evaluacion, p.activo, t.tipoevaluacionid, t.nombre tipoevaluacion, 
		c.cicloid, c.nombre ciclo, n.nombre nivel, n.nivelid, 
		GroupConcat(g.grado Order by g.grado SEPARATOR '°, ') as grado, 
		GroupConcat(g.gradoid, '' Order by g.gradoid ) as gradoid")
	    ->from("AppBundle:Evaluacionporgrado", 'e')
		->innerJoin('e.evaluacionid', 'p')
		->innerJoin('p.tipoevaluacionid', 't')
		->innerJoin('p.cicloid', 'c')
	    ->innerJoin('e.gradoid', 'g')
	    ->innerJoin('g.nivelid', 'n')
		->groupBy('p.evaluacionid')
		->orderBy("p.nombre");
            if (isset($filtros['evaluacionid'])) {
	        $result->andWhere('p.evaluacionid = '.$filtros['evaluacionid']);
	    }
	    if (isset($filtros['nombre'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
	        $result->andWhere('p.nombre like :nombre')
	        ->setParameter('nombre', '%'.$filtros['nombre'].'%');
	    }
	    if (isset($filtros['tipoevaluacionid'])) {
	        $result->andWhere('p.tipoevaluacionid =' . $filtros['tipoevaluacionid']);
	    }
	    if (isset($filtros['tipoponderacionid'])) {
	        $result->andWhere('a.tipoponderacionid =' . $filtros['tipoponderacionid']);
	    }
	    if (isset($filtros['ponderacionid'])) {
	        $result->andWhere('p.ponderacionid =' . $filtros['ponderacionid']);
	    }
	    if (isset($filtros['cicloid'])) {
	    	$result->andWhere('p.cicloid IN (:cicloid)')
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
	    return $result->getQuery()->getResult();
	}
	
	public function ValidarRelacionEvaluacion($TipoEvaluacion, $Grados, $Ciclo) {
	    $qb = $this->em->createQueryBuilder();
	    $result = $qb->select("eg relaciones,GroupConcat(g.grado, '' Order by g.grado ) grados, te.nombre")
	    ->from("AppBundle:Evaluacionporgrado", 'eg')
	    ->innerJoin('eg.evaluacionid', 'e')
	    ->innerJoin('e.tipoevaluacionid', 'te')
	    ->innerJoin('eg.gradoid', 'g')
	    ->andWhere('te.tipoevaluacionid = '. $TipoEvaluacion)
	    ->andWhere('e.activo = '. true)
	    ->andWhere('e.cicloid ='. $Ciclo)
	    ->andWhere('g.gradoid IN (:idsgrado)')
	    ->setParameter('idsgrado',  explode(',',$Grados));
	    
	    return $result->getQuery()->getResult();
	}
	

	public function CopiarEvaluacionCicloEvaluaciones($Evaluaciones, $Ciclo){
		try {
			$qb = $this->em->getConnection();
			$response = "";
            $sql = "call spCopiarOtroCicloEvaluacion('". $Evaluaciones ."', ". $Ciclo .", @response);";
            $stmt = $qb->prepare($sql);
            $stmt->execute();
            return true;
        } catch (Exceptio $e) {
            return false;
        }
		

	}
	
}