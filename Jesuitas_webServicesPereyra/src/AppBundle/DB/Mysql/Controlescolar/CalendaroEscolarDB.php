<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of EventoDB
 *
 * @author inceptio
 */
class CalendaroEscolarDB extends BaseDBManager {
    /*
     * obtener los eventos por filtros de busqueda
     */

    public function BuscarCalendarioescolar($filtros) {

        $qb = $this->em->getConnection();
        if (isset($filtros['nivelid'])) {
        	$nivel="and nivelid like '%".$filtros['nivelid']."%'";
        }
        if (isset($filtros['gradoid'])) {
            $gradoid = implode(",", $filtros['gradoid']);
        	$grado="and gradoid in (".$gradoid.")";
        }
        if (isset($filtros['tipoeventoid'])) {
        	$tipoevento="and tipoeventoid =".$filtros['tipoeventoid'];
        }
        if (isset($filtros['nombreevento'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombreevento']=str_replace($escape,$escapados,$filtros['nombreevento']);
        	$nombreevento="and nombre like '%".$filtros['nombreevento']."%'";
        }
        if (isset($filtros['fecha'])) {
            $dateinicio = new \DateTime($filtros['fecha']);
            $fechainicio="and dateinicio = '".$dateinicio->format('Y-m-d')."'";
        }
        if (isset($filtros['fechainicio'])) {
            $dateinicio = new \DateTime($filtros['fechainicio']);
            $datefin = new \DateTime($filtros['fechafin']);
            $fechainicio="and (dateinicio between '".$dateinicio->format('Y-m-d')."' and '".$datefin->format('Y-m-d')."' or datefin between '".$dateinicio->format('Y-m-d')."' and '".$datefin->format('Y-m-d')."')";
        }
        if (isset($filtros['horainicio'])) {
        	$timeinicio = new \DateTime($filtros['horainicio']);
        	$timefin = new \DateTime($filtros['horafin']);
        	$horainicio="and (horainicio between '".$timeinicio->format('H:i:s')."' and '".$timefin->format('H:i:s')."' or horafin between '".$timeinicio->format('H:i:s')."' and '".$timefin->format('H:i:s')."')";
        }
        if (isset($filtros['alumnoporcicloid'])) {
            $alumnoporcicloid = implode(",", $filtros['alumnoporcicloid']);
        	$tareas ="UNION(
            select
            t.tareaid as eventoid,te.tipoeventoid,te.nombre as tipoevento, te.color,null as imagenporeventoid,null as imagen, '' as descripcion, null as enviopush, CONCAT_WS(' ','Tarea',t.nombre) as nombre,Group_Concat(n.nivelid) as nivelid,Group_Concat(n.nombre) as nivel,Group_Concat(DISTINCT g.gradoid)gradoid,
            t.fechainicio as dateinicio, t.fechafin as datefin,
            DATE_FORMAT(t.fechainicio, '%d/%m/%Y') fechainicio,
            null as horainicio,
            DATE_FORMAT(t.fechafin, '%d/%m/%Y') fechafin,
            t.horalimite as horafin,
            null as fechaenvioformatted,
            null as horaenvio,
            null as fechaenvio,
            0 as editable
            from ce_tareaalumno ta 
            inner join ce_tarea t on t.tareaid=ta.tareaid
            inner join ce_criterioevaluaciongrupo ceg on ceg.criterioevaluaciongrupoid = t.criterioevaluaciongrupoid
            inner join ce_periodoevaluacion pev on pev.periodoevaluacionid = ceg.periodoevaluacionid and CAST(CURRENT_DATE() AS date) <=  CAST(pev.fechapublicaciondefinitiva AS date)
            inner join ce_capturacalificacionporalumno cca on ceg.criterioevaluaciongrupoid = cca.criterioevaluaciongrupoid
            inner join ce_calificacionperiodoporalumno cpa on cpa.calificacionperiodoporalumnoid = cca.calificacionperiodoporalumnoid
            inner join ce_alumnoporciclo ac on cpa.alumnoporcicloid = ac.alumnoporcicloid
            inner join grado g on ac.gradoid = g.gradoid
            inner join nivel n on g.nivelid = n.nivelid
            inner join ce_tipoevento te on te.tipoeventoid=4
            where cpa.alumnoporcicloid in (".$alumnoporcicloid. ")
             order by t.fechainicio DESC
            )";            
        }
        $sql = "
        select * from (
            select 
            e.eventoid, t.tipoeventoid,t.nombre as tipoevento, t.color,ie.imagenporeventoid,concat(pa.valor, '/api/Controlescolar/Evento/Imagen/', ie.imagenporeventoid) as imagen, e.descripcion, e.enviopush, e.nombre, Group_Concat(DISTINCT n.nivelid ORDER BY n.nivelid) as nivelid,Group_Concat(DISTINCT n.nombre ORDER BY n.nivelid) as nivel,Group_Concat(DISTINCT g.gradoid)gradoid,
            e.fechainicio as dateinicio,e.fechafin as datefin,
            DATE_FORMAT(e.fechainicio, '%d/%m/%Y') fechainicio,
            DATE_FORMAT(e.horainicio, '%H:%i') horainicio,
            DATE_FORMAT(e.fechafin, '%d/%m/%Y')fechafin,
            DATE_FORMAT(e.horafin, '%H:%i') horafin,
            DATE_FORMAT(e.fechaenvio, '%d/%m/%Y')fechaenvioformatted,
            DATE_FORMAT(e.horaenvio, '%H:%i') horaenvio,
            e.fechaenvio,
            1 as editable
            from ce_evento e
            left join ce_imagenporevento ie on e.eventoid = ie.eventoid
            inner join ce_tipoevento t on t.tipoeventoid=e.tipoeventoid
            inner join ce_eventopornivel en on en.eventoid=e.eventoid
            inner join nivel n on n.nivelid=en.nivelid
            inner join grado g on g.nivelid = n.nivelid
            inner join parametros pa on pa.nombre = 'URLServicios'
            group by e.eventoid

            UNION 

            select 
            a.cupoadmisionid as eventoid, t.tipoeventoid, t.nombre as tipoevento, t.color,
            null as imagenporeventoid, null as imagen, '' as descripcion, null as enviopush, 
            CONCAT_WS(' ','Admisiones',g.grado,'de',n.nombre,'Ciclo',c.nombre) as nombre, 
            Group_Concat(n.nivelid) as nivelid, Group_Concat(n.nombre) as nivel, Group_Concat(DISTINCT g.gradoid)gradoid,
            a.iniciorecepcion as dateinicio,a.finrecepcion as datefin,
            DATE_FORMAT(a.iniciorecepcion, '%d/%m/%Y') fechainicio,
            null as horainicio,
            DATE_FORMAT(a.finrecepcion, '%d/%m/%Y') fechafin,
            null as horafin,
            null as fechaenvioformatted,
            null as horaenvio,
            null as fechaenvio,
            0 as editable
            from cupoadmision a
            inner join ciclo c on c.cicloid=a.cicloid
            inner join grado g on g.gradoid=a.gradoid
            inner join nivel n on n.nivelid=g.nivelid
            inner join ce_tipoevento t on t.tipoeventoid = 6
            group by a.cupoadmisionid

            UNION 

            select 
            pb.periodobecaid as eventoid,t.tipoeventoid, t.nombre as tipoevento, t.color,
            null as imagenporeventoid, null as imagen, '' as descripcion, null as enviopush, CONCAT_WS(' ','Becas Ciclo',c.nombre) as nombre,Group_Concat(DISTINCT n.nivelid ORDER BY n.nivelid) as nivelid,Group_Concat(DISTINCT n.nombre ORDER BY n.nivelid) as nivel,Group_Concat(DISTINCT g.gradoid)gradoid,
            pb.fechainicapturas as dateinicio,pb.fechafincapturas as datefin,
            DATE_FORMAT(pb.fechainicapturas, '%d/%m/%Y') fechainicio,
            null as horainicio,
            DATE_FORMAT(pb.fechafincapturas, '%d/%m/%Y') fechafin,
            null as horafin,
            null as fechaenvioformatted,
            null as horaenvio,
            null as fechaenvio,
            0 as editable
            from bc_periodobeca pb
            inner join ciclo c on c.cicloid=pb.cicloid
            inner join ce_tipoevento t on t.tipoeventoid=5
            JOIN grado g
            INNER JOIN nivel n ON g.NivelId = n.NivelId
            GROUP BY pb.PeriodoBecaId

            $tareas
        ) eventos
        where 1=1 $tipoevento $nombreevento $fechainicio $horainicio $nivel $grado";
        
        $stmt = $qb->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;

    }
    
    public function BuscarEventosPendientes()
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("n")
            ->from("AppBundle:CeEvento", "n")
            ->andWhere("strtodate(concat(n.fechaenvio,' ',n.horaenvio), '%Y-%m-%d %T') <= CURRENT_TIMESTAMP() and n.enviado = 0");
        return $result->getQuery()->getResult();
    }
}
