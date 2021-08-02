<?php
namespace AppBundle\DB\Mysql\Admisiones;
use AppBundle\DB\Mysql\BaseDBManager;
/**
 * Description of CupoAdmision
 *
 * @author Javier Manrique
 */
class ListaAsistenciaDB extends BaseDBManager {
	
	public function BuscarListaAsistencia($filtros) {
	    $qb = $this->em->createQueryBuilder();
		$result = $qb->select("ee.eventoevaluacionid, t.nombre tipoevaluacion, n.nombre nivel, g.grado, g.gradoid, 
		concat_ws(' ', p.apellidopaterno,p.apellidomaterno,p.nombre) evaluador, l.nombre lugar,
		DATE_FORMAT(ee.fechainicio, '%d/%m/%Y') fechainicio,
		DATE_FORMAT(ee.horainicio, '%H:%i') horainicio,
		DATE_FORMAT(ee.fechafin, '%d/%m/%Y') fechafin,
		DATE_FORMAT(ee.horafin, '%H:%i') horafin,e.nombre as nombreevento,
		CASE 
			WHEN t.tipoevaluacionid = 4 THEN
			GROUPCONCAT(
				d.apellidopaterno separator '<br><br>'
			) ELSE '-' END apellidopaterno,
		CASE 
			WHEN t.tipoevaluacionid = 4 THEN
			GROUPCONCAT(
				d.apellidomaterno separator '<br><br>'
			) ELSE '-' END apellidomaterno,
		CASE 
			WHEN t.tipoevaluacionid = 4 THEN
			GROUPCONCAT(
				d.nombre separator '<br><br>'
			) ELSE '-' END nombre		
			")
	    ->from("AppBundle:Gradoporeventoevaluacion", 'ge')
	    ->innerJoin("ge.gradoid", "g")
	    ->innerJoin("g.nivelid", "n")
        ->innerJoin("ge.eventoevaluacionid", 'ee')                    
		->innerJoin("ee.evaluacionid", 'e')
		->innerJoin("e.cicloid", 'c')
	    ->innerJoin("AppBundle:Tipoevaluacion", "t",\Doctrine\ORM\Query\Expr\Join::WITH,"e.tipoevaluacionid = t.tipoevaluacionid and t.tipoevaluacionid ". ($filtros["entrevista"] ? "= 4" : "<> 4"))	    
	    ->innerJoin("ee.lugarid", "l")
	    ->innerJoin("ee.usuarioid", "u")
		->innerJoin("u.personaid", "p")
		->innerJoin("AppBundle:Evaluacionporsolicitudadmision", "es", \Doctrine\ORM\Query\Expr\Join::WITH,"ee.eventoevaluacionid = es.eventoevaluacionid")
		->innerJoin("AppBundle:Solicitudadmision", "s", \Doctrine\ORM\Query\Expr\Join::WITH,"es.solicitudadmisionid = s.solicitudadmisionid and s.gradoid = g.gradoid")
		->leftJoin("s.datoaspiranteid", "d")
		->groupBy("ee.eventoevaluacionid");
		if($filtros["entrevista"]){
			$result->groupBy("s.solicitudadmisionid");
		}
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
	    if (isset($filtros['tipoevaluacionid'])) {
	        $result->andWhere('t.tipoevaluacionid =' . $filtros['tipoevaluacionid']);
	    }
	    if (isset($filtros['evaluadorid'])) {
	        $result->andWhere('p.personaid IN (:personaid)')
	        ->setParameter('personaid' , $filtros['evaluadorid']);
	    }
	    if (isset($filtros['lugarid'])) {
	        $result->andWhere('l.lugarid =' . $filtros['lugarid']);
	    }
	    if (isset($filtros['fecha'])) {
	        $date =  new \DateTime($filtros['fecha']);
	        $result->andWhere('ee.fechainicio = :fecha')
	        ->setParameter("fecha",  $date);
	        
	    }
	    return $result->getQuery()->getResult();
	}

	public function BuscarListaAsistenciaDetalle($filtros) {
	    $qb = $this->em->createQueryBuilder();
		$result = $qb->select("es.evaluacionporsolicitudadmisionid, s.solicitudadmisionid, s.folio,
		d.nombre, d.apellidopaterno, d.apellidomaterno, s.solicitudpagada, es.asistio, d.foto as evidencia,
        DATE_FORMAT(ee.horainicio, '%H:%i') horainicio")
		->from("AppBundle:Evaluacionporsolicitudadmision", 'es')
		->innerJoin("es.solicitudadmisionid", "s")
		->innerJoin("s.gradoid", "g")
		->innerJoin("s.datoaspiranteid", "d")
		->innerJoin("es.eventoevaluacionid", "ee")
		->andWhere("ee.eventoevaluacionid =".$filtros["eventoevaluacionid"])
		->andWhere("g.gradoid =".$filtros["gradoid"]);
	    return $result->getQuery()->getResult();
	}
	
}