<?php
namespace AppBundle\DB\Mysql\Admisiones;
use AppBundle\DB\Mysql\BaseDBManager;
/**
 * Description of CupoAdmision
 *
 * @author Javier Manrique
 */
class AplicacionEntrevistaDB extends BaseDBManager {
	
    public function BuscarAplicacionEntrevista($filtros) {
	    $qb = $this->em->createQueryBuilder();
		$result = $qb->select("sa.solicitudadmisionid, sa.folio, CONCAT_WS(' ',da.apellidopaterno,da.apellidomaterno,da.nombre)nombre,
		da.apellidopaterno, da.apellidomaterno, da.nombre nombreaspirante,
		c.nombre ciclo, n.nombre nivel, g.grado, p.nombre evaluacion, te.nombre tipoevaluacion, 
		CONCAT_WS(' ',DATE_FORMAT(ep.fechainicio, '%d/%m/%Y'), DATE_FORMAT(ep.horainicio, '%H:%i')) fecha,
		CONCAT_WS(' ',per.apellidopaterno,per.apellidomaterno,per.nombre) evaluador, l.nombre lugar, ee.nombre estatus, psa.evaluacionporsolicitudadmisionid")
	    ->from("AppBundle:Evaluacionporsolicitudadmision", 'psa')
	    ->innerJoin("psa.estatusevaluacionid", "ee")
	    ->innerJoin("psa.eventoevaluacionid", "ep")
	    ->innerJoin("ep.lugarid", "l")
	    ->innerJoin("psa.evaluacionid", 'p')
	    ->innerJoin("p.cicloid", 'c')
	    ->innerJoin("p.tipoevaluacionid", "te")
		->innerJoin("ep.usuarioid", "u")
		->innerJoin("u.personaid", "per")
	    ->innerJoin("psa.solicitudadmisionid", "sa")
	    ->innerJoin("sa.gradoid", "g")
	    ->innerJoin("g.nivelid", "n")
	    ->innerJoin("sa.datoaspiranteid", "da")
	    ->where('te.tipoevaluacionid IN (:tipoevaluacionid)')
	    ->setParameter('tipoevaluacionid', $filtros['tipoevaluacionid']);
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
	    if (isset($filtros['evaluadorid'])) {
	    	$result->andWhere('u.personaid IN (:personaid)')
	    	->setParameter('personaid' , $filtros['evaluadorid']);
	    }
	    if (isset($filtros['lugarid'])) {
	        $result->andWhere('l.lugarid =' . $filtros['lugarid']);
	    }
	    if (isset($filtros['folio'])) {
			$escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['folio']=str_replace($escape,$escapados,$filtros['folio']);
	        $result->andWhere('sa.folio like :folio')
	        ->setParameter('folio', '%'.$filtros['folio'].'%');
	    }
	    if (isset($filtros['fecha'])) {
	        $date =  new \DateTime($filtros['fecha']);
	        $result->andWhere('ep.fechainicio = :date')
	        ->setParameter('date', $date);
	    }
	    if (isset($filtros['estatusid'])) {
	        $result->andWhere('psa.estatusevaluacionid ='. $filtros['estatusid']);
	    }
	    if (isset($filtros['aprobado'])) {
	        $result->andWhere('psa.aprobado ='.$filtros['aprobado']);
	    }
	    return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
	}
	
}