<?php

namespace AppBundle\DB\Mysql\Bancoreactivo;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 *
 * @author Javier
 */
class CalendarizacionExamenDB extends BaseDBManager {

    public function BuscarCalendarizacionexamen($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.calendarioexamenid, c.descripcion, ci.cicloid, ci.nombre ciclo, n.nivelid, n.nombre nivel, g.gradoid, g.grado,
        ma.medioaplicacionid, c.resumenresultados, c.revision,
        DATE_FORMAT(c.fechaaplicacion,'%d/%m/%Y') fechaaplicacion, DATE_FORMAT(c.horainicio,'%H:%i') horainicio, DATE_FORMAT(c.horafin,'%H:%i') horafin,
        a.tipoaplicacionid, a.nombre tipoaplicacion, e.tipoexamenid, e.nombre tipoexamen, GroupConcat(exa.nombre, ' ') examen")
        ->from("AppBundle:BrCalendarioexamen", 'c')
        ->innerJoin("c.cicloid", "ci")
        ->innerJoin("c.gradoid", "g")
        ->innerJoin("g.nivelid", "n")
        ->innerJoin("c.tipoaplicacionid", "a")
        ->innerJoin("c.medioaplicacionid", "ma")
        ->innerJoin('c.tipoexamenid', 'e')
        ->innerJoin("AppBundle:BrExamenporcalendario", "ec", Expr\Join::WITH, "ec.calendarioexamenid = c.calendarioexamenid")
        ->innerJoin("ec.examenid", "exa")
        ->groupBy("c.calendarioexamenid"); 
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid =' . $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid IN (:gradosid)')
        	->setParameter('gradosid' , $filtros['gradoid']);
        }
        if (isset($filtros['descripcion'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['descripcion']=str_replace($escape,$escapados,$filtros['descripcion']);
        	$result->andWhere('c.descripcion like :descripcion')
        	->setParameter('descripcion', '%'.$filtros['descripcion'].'%');
        }
        if (isset($filtros['fechaaplicacion'])) {
            $fecha = new \DateTime($filtros["fechaaplicacion"]["date"]["year"] . "-" . $filtros["fechaaplicacion"]["date"]["month"] . "-" . $filtros["fechaaplicacion"]["date"]["day"]);
            $result->andWhere('c.fechaaplicacion = :fecha')
            ->setParameter('fecha', $fecha);
        }
        if (isset($filtros['tipoexamenid'])) {
        	$result->andWhere('e.tipoexamenid ='. $filtros['tipoexamenid']);
        }
        if (isset($filtros['examenid'])) {
        	$result->andWhere('exa.examenid IN (:examenid)')
        	->setParameter('examenid' , $filtros['examenid']);
        }
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function BuscarExamenesAplicadosByAlumno($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.matricula, concat_ws(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre) as nombrecompleto, a.alumnoid")
        ->from("AppBundle:BrUsuarioporexamen", 'ue')
        ->innerJoin('AppBundle:BrExamenporcalendario', 'ec', Expr\Join::WITH, "ec.examenporcalendarioid= ue.examenporcalendarioid")
        ->innerJoin('AppBundle:CeCriterioevaluaciongrupo', 'ceg', Expr\Join::WITH, "ceg.criterioevaluaciongrupoid= ec.criterioevaluaciongrupoid")
        ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = ue.alumnoid")
        ->groupBy("a.alumnoid"); 
        $result->andWhere('ue.aplicado = 1 and ceg.configurarexamen = 1');
        if (isset($filtros['alumnos'])) {
        	$result->andWhere('a.alumnoid IN (:alumnosid)')
        	->setParameter('alumnosid' , $filtros['alumnos']);
        }
        if (isset($filtros['aspectoid'])) {
        	$result->andWhere('ceg.criterioevaluaciongrupoid IN (:aspectoid)')
        	->setParameter('aspectoid' , $filtros['aspectoid']);
        }
        if (isset($filtros['numcaptura'])) {
        	$result->andWhere('ec.numerocaptura = (:numcaptura)')
        	->setParameter('numcaptura' , $filtros['numcaptura']);
        }
        return $result->getQuery()->getResult();
    }


    public function BuscarGruposPorMateria($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("g.grupoid, g.nombre as grupo, t.tallercurricularid, t.nombre as taller, CASE WHEN c.cicloid is not null then c.cicloid else ct.cicloid end as cicloid")
        ->from("AppBundle:CeGrupo", 'g')
        ->innerJoin('g.tipogrupoid', 'tg')
        ->innerJoin('g.gradoid', 'gr')
        ->innerJoin('g.cicloid', 'c')
        ->leftJoin('AppBundle:CeGradoportallercurricular', 'ceg', Expr\Join::WITH, "ceg.gradoid=" . $filtros['gradoid'])
        ->leftJoin('AppBundle:CeTallercurricular', 't', Expr\Join::WITH, "t.tallercurricularid= ceg.tallercurricularid")
        ->leftJoin('AppBundle:CeMateriaporplanestudios', 'mppe', Expr\Join::WITH, "mppe.materiaporplanestudioid= ceg.materiaporplanestudioid")
        ->leftJoin('AppBundle:CeGrupoorigenporsubgrupo', 'gos', Expr\Join::WITH, "gos.grupoid = g.grupoid")
        ->leftJoin('AppBundle:CeMateriaporplanestudios', 'mppes', Expr\Join::WITH, "mppes.materiaporplanestudioid= gos.materiaporplanestudioid")
        ->leftJoin('t.cicloid', 'ct')
        ->andWhere('c.cicloid = (:cicloid) or ct.cicloid = (:cicloid)')
        ->setParameter('cicloid' , $filtros['cicloid']);
        if ($filtros['configurarsubgrupos'] && $filtros['materiaporplanestudioid']) {
            $result->andWhere('tg.tipogrupoid = 2 and gr.gradoid = (:gradoid) and mppes.materiaporplanestudioid = (:materiaporplanestudioid)');
            $result->setParameter('gradoid' , $filtros['gradoid']);
            $result->setParameter('materiaporplanestudioid' , $filtros['materiaporplanestudioid']);
            $result->groupBy('g.grupoid');
        } 
        if ($filtros['configurartaller'] && $filtros['materiaporplanestudioid']) {
            $result->andWhere('t.tallercurricularid is not null and mppe.materiaporplanestudioid =' . $filtros['materiaporplanestudioid']);
            $result->groupBy('t.tallercurricularid');

        }
        if (!($filtros['configurarsubgrupos']) && !($filtros['configurartaller'])) {
            $result->andWhere('tg.tipogrupoid = 1 and gr.gradoid = ' . $filtros['gradoid']);
            $result->groupBy('g.grupoid');
        }
        return $result->getQuery()->getResult();
    }


    public function BuscarAspectospormateria($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ceg.criterioevaluaciongrupoid, ceg.aspecto, pe.periodoevaluacionid, g.grupoid, t.tallercurricularid, ceg.capturas,
        CASE WHEN mpe.materiaporplanestudioid IS NOT NULL THEN mpe.materiaporplanestudioid ELSE mpet.materiaporplanestudioid as materiaporplanestudioid
        ")
        ->from("AppBundle:CeCriterioevaluaciongrupo", 'ceg')
        ->innerJoin('ceg.periodoevaluacionid', 'pe')
        ->innerJoin('ceg.profesorpormateriaplanestudiosid', 'pmpe')
        ->leftJoin('AppBundle:CeMateriaporplanestudios', 'mpe', Expr\Join::WITH, "mpe.materiaporplanestudioid = pmpe.materiaporplanestudioid")
        ->leftJoin('AppBundle:CeGradoportallercurricular', 'cegt', Expr\Join::WITH, 'cegt.tallercurricularid = pmpe.tallerid')
        ->leftJoin('AppBundle:CeMateriaporplanestudios', 'mpet', Expr\Join::WITH, "mpet.materiaporplanestudioid = cegt.materiaporplanestudioid")
        ->leftJoin('AppBundle:CeGrupo', 'g', Expr\Join::WITH, "g.grupoid = pmpe.grupoid")
        ->leftJoin('AppBundle:CeTallercurricular', 't', Expr\Join::WITH, "t.tallercurricularid = pmpe.tallerid")
        ->andWhere('ceg.configurarexamen = 1')
        ->groupBy('ceg.criterioevaluaciongrupoid');
        if ($filtros['materiaporplanestudioid']) {
            $result->andWhere('ceg.configurarexamen = 1 and mpe.materiaporplanestudioid =' . $filtros['materiaporplanestudioid'] . 'or mpet.materiaporplanestudioid =' . $filtros['materiaporplanestudioid']);
        }
        return $result->getQuery()->getResult();
    }
}
