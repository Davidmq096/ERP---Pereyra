<?php

namespace AppBundle\DB\Mysql;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of documento
 *
 * @author Inceptio
 */

class PortalAlumnoDB extends BaseDBManager 
{
    public function FaltasDetalle($filtros) {
        $fecha=new \DateTime();
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.asistenciaid as id,ta.tipoasistenciaid,ta.descripcion as tipo,DATE_FORMAT(a.fecha, '%Y-%m-%d') as fecha,DATE_FORMAT(a.hora, '%H:%i:%s') as hora,ei.estatusinasistenciaid,ei.descripcion as estatus")
        ->from("AppBundle:CeAsistencia","a")
        ->leftJoin("AppBundle:CeTipoasistencia", 'ta', Expr\Join::WITH, "ta.tipoasistenciaid=a.tipoasistenciaid")
        ->leftJoin("AppBundle:CeEstatusinasistencia", 'ei', Expr\Join::WITH, "ei.estatusinasistenciaid=a.estatusinasistenciaid");
        $result->andWhere('a.materiaid=:materiaid and  a.alumnoid=:alumnoid and (a.tipoasistenciaid=2 or a.tipoasistenciaid=3) and  a.fecha>=:fechainicio and a.fecha<=:fechafin')
        ->setParameter('materiaid', $filtros['materiaid'])
        ->setParameter('alumnoid', $filtros['alumnoid'])
        ->setParameter('fechainicio', $filtros['fechainicio'])
        ->setParameter('fechafin', $filtros['fechafin']);
       
        return $result->getQuery()->getResult();
    }

    public function BuscarCapturasAlumno($filtros) {
        $fecha=new \DateTime();
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ccpa.capturacalificacionporalumnoid as id,m.materiaid,m.nombre as materianombre,ceg.aspecto as criterioevaluaciongruponombre,ccpa.numerocaptura,ccpa.calificacion")
        ->from("AppBundle:CeCapturacalificacionporalumno","ccpa")
        ->innerJoin("AppBundle:CeCalificacionperiodoporalumno", 'cpa', Expr\Join::WITH, "cpa.calificacionperiodoporalumnoid=ccpa.calificacionperiodoporalumnoid")
        ->innerJoin("AppBundle:Materia", 'm', Expr\Join::WITH, "m.materiaid=cpa.materiaid")
        ->innerJoin("AppBundle:CeCriterioevaluaciongrupo", 'ceg', Expr\Join::WITH, "ceg.criterioevaluaciongrupoid=ccpa.criterioevaluaciongrupoid");
        $result->andWhere('ccpa.calificacionperiodoporalumnoid=:calificacionperiodoporalumnoid')
        ->setParameter('calificacionperiodoporalumnoid', $filtros['calificacionperiodoporalumnoid']);
       
        return $result->getQuery()->getResult();
    }

    public function BuscarPeriodosGradoCiclo($filtros) {
        $fecha=new \DateTime();
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pe.periodoevaluacionid,pe.descripcion,pe.descripcioncorta,DATE_FORMAT(pe.fechainicio, '%Y-%m-%d') as fechainicio, DATE_FORMAT(pe.fechafin, '%Y-%m-%d') as fechafin,DATE_FORMAT(pe.fechapublicaciondefinitiva, '%Y-%m-%d') as fechapublicaciondefinitiva,DATE_FORMAT(pe.fechapublicacionprevia, '%Y-%m-%d') as fechapublicacionprevia")
        ->from("AppBundle:CeGradoporconjuntoperiodoescolar","gcpe")
        ->innerJoin("AppBundle:CeConjuntoperiodoevaluacion", 'cpe', Expr\Join::WITH, "cpe.conjuntoperiodoevaluacionid=gcpe.conjuntoperiodoevaluacionid")
        ->innerJoin("AppBundle:CePeriodoevaluacion", 'pe', Expr\Join::WITH, "pe.conjuntoperiodoevaluacionid=cpe.conjuntoperiodoevaluacionid");
        $result->andWhere('gcpe.gradoid=:gradoid and cpe.cicloid=:cicloid')
            ->setParameter('gradoid', $filtros['gradoid'])
            ->setParameter('cicloid', $filtros['cicloid']);
       
        return $result->getQuery()->getResult();
    }
    

    public function BuscarCalificacionesAlumno($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("cpa.calificacionperiodoporalumnoid as id,a.alumnoid as alumnoid,m.materiaid,m.nombre as materianombre,m.alias as nombrecorto,cpa.calificacion,po.opcion as ponderacion,cpa.observacion,cfpa.calificacionfinalperiodoporalumnoid,cfpa as calificacionfinalperiodoporalumno,mpe.seimprimeenboleta")
        ->from("AppBundle:CeCalificacionperiodoporalumno","cpa")
        ->innerJoin("AppBundle:CeAlumno", 'a', Expr\Join::WITH, "a.alumnoid=cpa.alumnoid")
        ->innerJoin("AppBundle:CePeriodoevaluacion", 'pe', Expr\Join::WITH, "pe.periodoevaluacionid=cpa.periodoevaluacionid")
        ->innerJoin("AppBundle:CeMateriaporplanestudios", 'mpe', Expr\Join::WITH, "mpe.materiaporplanestudioid=cpa.materiaporplanestudioid")
        ->innerJoin("AppBundle:Materia", 'm', Expr\Join::WITH, "m.materiaid=mpe.materiaid")
        ->leftJoin("AppBundle:CePonderacionopcion", 'po', Expr\Join::WITH, "po.ponderacionopcionid=cpa.ponderacionopcionid")
        ->leftJoin("AppBundle:CeCalificacionfinalperiodoporalumno", 'cfpa', Expr\Join::WITH, "cfpa.calificacionfinalperiodoporalumnoid = cpa.calificacionfinalporperiodoalumno")
        ->groupBy("pe.periodoevaluacionid,a.alumnoid,m.materiaid");
      
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('cpa.alumnoid in (:alumnoid)')
            ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['periodoevaluacionid'])) {
        	$result->andWhere('pe.periodoevaluacionid=:periodoevaluacionid')
            ->setParameter('periodoevaluacionid', $filtros['periodoevaluacionid']);
        }
        
        return $result->getQuery()->getResult();
    }  

    public function BuscarFaltasAlumno($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("cpa.calificacionperiodoporalumnoid as id,a.alumnoid as alumnoid,m.materiaid,m.nombre as materianombre,cpa.calificacion,po.opcion as ponderacion,cpa.observacion,cfpa.calificacionfinalperiodoporalumnoid,cfpa as calificacionfinalperiodoporalumno,asis as falta")
        ->from("AppBundle:CeCalificacionperiodoporalumno","cpa")
        ->innerJoin("AppBundle:CeAlumno", 'a', Expr\Join::WITH, "a.alumnoid=cpa.alumnoid")
        ->innerJoin("AppBundle:CePeriodoevaluacion", 'pe', Expr\Join::WITH, "pe.periodoevaluacionid=cpa.periodoevaluacionid")
        ->innerJoin("AppBundle:Materia", 'm', Expr\Join::WITH, "m.materiaid=cpa.materiaid")
        ->leftJoin("AppBundle:CeAsistencia", 'asis', Expr\Join::WITH, "asis.alumnoid=cpa.alumnoid and asis.materiaid=cpa.materiaid and asis.tipoasistenciaid=2 and asis.fecha>=pe.fechainicio and asis.fecha<=pe.fechafin")
        ->leftJoin("AppBundle:CePonderacionopcion", 'po', Expr\Join::WITH, "po.ponderacionopcionid=cpa.ponderacionopcionid")
        ->leftJoin("AppBundle:CeCalificacionfinalperiodoporalumno", 'cfpa', Expr\Join::WITH, "cfpa.calificacionfinalperiodoporalumnoid = cpa.calificacionfinalporperiodoalumno");

      
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('cpa.alumnoid in (:alumnoid)')
            ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['periodoevaluacionid'])) {
        	$result->andWhere('pe.periodoevaluacionid=:periodoevaluacionid')
            ->setParameter('periodoevaluacionid', $filtros['periodoevaluacionid']);
        }
        
        return $result->getQuery()->getResult();
    } 
    
}
