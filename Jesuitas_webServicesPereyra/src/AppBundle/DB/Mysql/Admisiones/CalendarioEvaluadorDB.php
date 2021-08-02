<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql\Admisiones;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of CalendarioEvaluadorDB
 *
 * @author inceptio
 */
class CalendarioEvaluadorDB extends BaseDBManager {
    /*
     * obtener los eventos por filtros de busqueda
     */

    public function BuscarCalendario($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.cicloid, c.nombre ciclo, n.nivelid, n.nombre nivel, 
        GroupConcat(g.grado, '° ' Order by g.grado ) grado, GroupConcat(g.gradoid, '' Order by g.gradoid ) gradoid,
        Concat_ws(' ', per.apellidopaterno, per.apellidomaterno, per.nombre) evaluador,
        p.evaluacionid, p.nombre evaluacion, l.lugarid, l.nombre lugar, per.personaid,
        ep.eventoevaluacionid, ep.cupo, 
        DATE_FORMAT(ep.fechainicio, '%d/%m/%Y') fechainicio,
        DATE_FORMAT(ep.horainicio, '%H:%i') horainicio,
        DATE_FORMAT(ep.fechafin, '%d/%m/%Y')fechafin,
        DATE_FORMAT(ep.horafin, '%H:%i') horafin")
                ->from("AppBundle:Gradoporeventoevaluacion", 'ge')
                ->innerJoin("ge.gradoid", "g")
                ->innerJoin("g.nivelid", "n")
                ->innerJoin("ge.eventoevaluacionid", 'ep')
                ->innerJoin("ep.lugarid", "l")
                ->innerJoin("ep.usuarioid", "e")
                ->innerJoin("e.personaid", "per")
                ->innerJoin("ep.evaluacionid", 'p')
                ->innerJoin("p.cicloid", 'c')
                ->groupBy("ep.eventoevaluacionid");

        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid IN (:cicloid)')
        	->setParameter('cicloid' , $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid In (:gradosid)')
                    ->setParameter('gradosid', $filtros['gradoid']);
        }
        if (isset($filtros['evaluadorid'])) {
            $result->andWhere('e.personaid IN (:personaid)')
            ->setParameter('personaid' , $filtros['evaluadorid']);
        }
        if (isset($filtros['evaluacionid'])) {
            $result->andWhere('p.evaluacionid =' . $filtros['evaluacionid']);
        }
        if (isset($filtros['lugarid'])) {
            $result->andWhere('l.lugarid =' . $filtros['lugarid']);
        }
        if (isset($filtros['fechainicio'])) {
            $dateinicio = new \DateTime($filtros['fechainicio']);
            $datefin = new \DateTime($filtros['fechafin']);
            $result->andWhere('(ep.fechainicio between :fechainicio and :fechafin or ep.fechafin between :fechainicio and :fechafin)')
                    ->setParameter("fechainicio", $dateinicio)
                    ->setParameter("fechafin", $datefin);
        }
        if (isset($filtros['horainicio'])) {
        	$timeinicio = new \DateTime($filtros['horainicio']);
        	$timefin = new \DateTime($filtros['horafin']);
        	$result->andWhere('(ep.horainicio between :horainicio and :horafin or ep.horafin between :horainicio and :horafin)')
        	->setParameter("horainicio", $timeinicio->format('H:i:s'))
        	->setParameter("horafin", $timefin->format('H:i:s'));
        }
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }
    

}
