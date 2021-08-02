<?php

namespace AppBundle\DB\Mysql\Admisiones\ModalSolicitud;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 *
 * @author Javier
 */
class SolicitudEvaluacionDB extends BaseDBManager
{

    //Metodo para obtener los eventos asignados
    public function getEvaluacionesAsignadas($solicitudid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("es.evaluacionporsolicitudadmisionid, e.evaluacionid, t.tipoevaluacionid, ev.eventoevaluacionid,
        e.nombre evaluacion, u.usuarioid, p.personaid, CONCAT_WS(' ', p.nombre, p.apellidopaterno) nombre, ev.cupo,
        DATE_FORMAT(ev.fechainicio, '%d/%m/%Y') fechainicio, DATE_FORMAT(ev.horainicio, '%H:%i') horainicio, DATE_FORMAT(ev.horafin, '%H:%i') horafin,
        (SELECT count(ess.evaluacionporsolicitudadmisionid) from AppBundle:Evaluacionporsolicitudadmision ess where ess.eventoevaluacionid = ev.eventoevaluacionid) solicitudes")
            ->from("AppBundle:Evaluacionporsolicitudadmision", 'es')
            ->innerJoin("es.eventoevaluacionid", "ev")
            ->innerJoin("es.evaluacionid", "e")
            ->innerJoin("e.tipoevaluacionid", "t")
            ->innerJoin("ev.usuarioid", "u")
            ->innerJoin("u.personaid", "p")
        ->where("t.mostrar = true")
            ->andWhere("es.solicitudadmisionid = :solicitudadmisionid")
            ->setParameter("solicitudadmisionid", $solicitudid)
            ->getQuery()->getResult();
        return $result;
    }

    //Metodo para obtener las evaluaciones que no se han asignado a una solicitud
    public function getEvaluacionesFaltante($solicitudid, $gradoid, $cicloid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("e.evaluacionid, e.nombre evaluacion")
            ->from("AppBundle:Evaluacionporgrado", 'eg')
            ->innerJoin("eg.evaluacionid", "e")
            ->innerJoin("e.tipoevaluacionid", "t")
            ->Where($qb->expr()->notIn("e.evaluacionid",
                $this->em->createQueryBuilder()
                    ->select("eva.evaluacionid")
                    ->from("AppBundle:Evaluacionporsolicitudadmision", "es")
                    ->innerJoin("es.evaluacionid", "eva")
                    ->Where("es.solicitudadmisionid = :solicitudid")
                    ->getDQL()
            )
            )
            ->andWhere("e.cicloid = :cicloid")
            ->andWhere("eg.gradoid = :gradoid")
            ->andWhere("e.activo = true")
            ->andWhere("t.mostrar = true")
            ->groupBy("e.evaluacionid")
            ->setParameters(array('gradoid' => $gradoid, 'cicloid' => $cicloid, "solicitudid" => $solicitudid))
            ->getQuery()->getResult();
        return $result;
    }

    //Funcion para obtener las entrevistas para la solicitud (CIENCIAS)
    public function getEntrevistaBloque($bloque, $gradoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("e.eventoevaluacionid, eva.evaluacionid, u.usuarioid")
            ->from("AppBundle:AdBloquegrado", 'b')
            ->innerJoin("AppBundle:AdBloquegradoentrevista", "be", Expr\Join::WITH, "b.bloquegradoid = be.bloquegradoid")
            ->innerJoin("AppBundle:AdBloquegradoentrevistaevaluador", "bee", Expr\Join::WITH, "be.bloquegradoentrevistaid = bee.bloquegradoentrevistaid")
            ->innerJoin("AppBundle:Eventoevaluacion", "e", Expr\Join::WITH, "be.bloquegradoentrevistaid = e.bloquegradoentrevistaid AND
                 (SELECT COUNT(es.eventoevaluacionid) FROM AppBundle:Evaluacionporsolicitudadmision es
                     WHERE es.eventoevaluacionid = e.eventoevaluacionid) < e.cupo ")
            ->innerJoin("AppBundle:Gradoporeventoevaluacion", "ge", Expr\Join::WITH, "ge.eventoevaluacionid = e.eventoevaluacionid")
            ->innerJoin("e.usuarioid", "u")
            ->innerJoin("e.evaluacionid", "eva")
            ->where("b.bloquegradoid =" . $bloque["bloquegradoid"])
            ->andWhere("e.fechainicio > CURRENT_TIMESTAMP()")
            ->andWhere("ge.gradoid =" . $gradoid)
            ->groupBy("e.eventoevaluacionid")
            ->setMaxResults(1);
        if ($bloque["metodoasignacioncitaid"] == "2") {
            $result = $result->orderBy("e.fechainicio, e.horainicio");
        }
        return $result->getQuery()->getOneOrNullResult();
    }

    //Funcion para obtener las evaluaciones para la solicitud (CIENCIAS)
    public function getEvaluacionBloque($bloqueid, $evaluadorid, $gradoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("e.eventoevaluacionid, eva.evaluacionid")
            ->from("AppBundle:AdBloquegradoevaluacion", 'be')
            ->innerJoin("AppBundle:Eventoevaluacion", "e", Expr\Join::WITH, "be.bloquegradoevaluacionid = e.bloquegradoevaluacionid AND
                (SELECT COUNT(es.eventoevaluacionid) FROM AppBundle:Evaluacionporsolicitudadmision es
                    WHERE es.eventoevaluacionid = e.eventoevaluacionid) < e.cupo ")
            ->innerJoin("e.evaluacionid", "eva")
            ->innerJoin("AppBundle:Gradoporeventoevaluacion", "ge", Expr\Join::WITH, "ge.eventoevaluacionid = e.eventoevaluacionid")
            ->where("be.bloqueogradoid =" . $bloqueid)
            ->where("e.usuarioid =" . $evaluadorid)
            ->andWhere("ge.gradoid =" . $gradoid)
            ->andWhere("e.fechainicio > CURRENT_TIMESTAMP()")
            ->groupBy("e.evaluacionid")
            ->getQuery()->getResult();
        return $result;
    }

    //(LUX) (Query)
    //Funcion para obtener las solicitudes por grado y ciclo
    public function getEvaluacionesByGradoandCiclo($gradoid, $cicloid)
    {
        $conn = $this->em->getConnection();
        $sql = "select e.TipoEvaluacionId, ee.EvaluacionId, ee.EventoEvaluacionId, counT(ee.EventoEvaluacionId) as 'numGrados',
            ee.Cupo as 'cupoEvento', l.Cupo as 'cupoLugar', ee.FechaInicio, ee.FechaFin, l.Nombre as 'Lugar'
            from eventoevaluacion ee
            inner join evaluacion e on e.EvaluacionId = ee.EvaluacionId
            inner join  gradoporeventoevaluacion gee on gee.EventoEvaluacionId = ee.EventoEvaluacionId
            inner join lugar l on l.LugarId = ee.LugarId
            where ee.FechaInicio > NOW() and gee.GradoId =  :gradoid and e.CicloId = :cicloid and e.TipoEvaluacionId != 4
            Group BY ee.EventoEvaluacionId Desc
            Order By counT(ee.EventoEvaluacionId) asc, ee.FechaInicio asc, ee.HoraInicio asc, l.Nombre asc;";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('gradoid' => $gradoid, 'cicloid' => $cicloid));
        $result = $stmt->fetchAll();
        return $result;
    }

    //(LUX) (Query)
    //Funcion para obtener al evento tomando en cuenta un evaluador con menos entrevistas y tomando en cuenta el orden del apellido y nombre
    public function getEntrevistaSolicitud($cicloid, $gradoid)
    {
        $conn = $this->em->getConnection();
        $sql = "SELECT u.UsuarioId FROM eventoevaluacion ee
        left JOIN evaluacionporsolicitudadmision e1 ON ee.EventoEvaluacionId = e1.EventoEvaluacionId
        INNER JOIN evaluacion e ON e.EvaluacionId = ee.EvaluacionId
        INNER JOIN usuario u ON ee.UsuarioId  = u.UsuarioId
        INNER JOIN vw_usuarios p on p.PersonaId = u.PersonaId
        INNER JOIN gradoporeventoevaluacion gee ON gee.EventoEvaluacionId = ee.EventoEvaluacionId
        WHERE gee.GradoId = :gradoid AND e.CicloId = :cicloid AND e.TipoEvaluacionId = 4 AND ee.FechaInicio > NOW()
        GROUP BY u.UsuarioId DESC
        ORDER BY COUNT(e1.EvaluacionPorSolicitudAdmisionId), p.ApellidoPaternoPersona ASC, p.ApellidoPaternoProfesor ASC, p.ApellidoMaternoPersona ASC, p.ApellidoMaternoProfesor ASC, p.NombrePersona ASC, p.NombreProfesor ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('gradoid' => $gradoid, 'cicloid' => $cicloid));
        $result = $stmt->fetchAll();
        return $result;
    }

    //(LUX) (Query)
    //Funcion para obtener al evento de entevista ha asignar a la solicitud (Query)
    public function getAltaEntrevistaByEvaluador($cicloid, $gradoid, $usuarioid)
    {
        $conn = $this->em->getConnection();
        $sql = "SELECT ee.EvaluacionId, ee.EventoEvaluacionId, ee.FechaInicio, ee.FechaFin, ee.HoraInicio, ee.HoraFin
                FROM eventoevaluacion ee
                INNER JOIN evaluacion e ON e.EvaluacionId = ee.EvaluacionId
                INNER JOIN usuario u ON ee.UsuarioId  = u.UsuarioId
                INNER JOIN vw_usuarios p on p.PersonaId = u.PersonaId
                INNER JOIN gradoporeventoevaluacion gee ON gee.EventoEvaluacionId = ee.EventoEvaluacionId
                WHERE gee.GradoId = :gradoid AND e.CicloId = :cicloid AND u.UsuarioId = :usuarioid AND e.TipoEvaluacionId = 4
                AND ee.FechaInicio > NOW() AND
                (SELECT COUNT(es.eventoevaluacionid) FROM evaluacionporsolicitudadmision es
                WHERE es.eventoevaluacionid = ee.EventoEvaluacionId) < ee.Cupo
                order By ee.FechaInicio, ee.HoraInicio   limit 1;";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('gradoid' => $gradoid, 'cicloid' => $cicloid, 'usuarioid' => $usuarioid));
        $result = $stmt->fetch();
        return $result;
    }

    /*
     * Obtenemos eventos del mismo examen con cupo disponible para cambiar la cita
     */
    public function getEvaluacionesCupoValidacionDatos($data)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("Concat_WS(' ', p.nombre, p.apellidopaterno) evaluador, ev.eventoevaluacionid,
        FECHAESPANOL(ev.fechainicio) as fechainicio,
        DATE_FORMAT(ev.horainicio, '%H:%i') horainicio,
        DATE_FORMAT(ev.horafin, '%H:%i') horafin")
            ->from("AppBundle:Eventoevaluacion", 'ev')
            ->leftJoin("ev.usuarioid", "u")
            ->leftJoin("u.personaid", "p")
            ->leftJoin("AppBundle:Gradoporeventoevaluacion", "ge", Expr\Join::WITH, "ev.eventoevaluacionid = ge.eventoevaluacionid")
            ->Where("(" .
                $this->em->createQueryBuilder()
                    ->select("COUNT(es.eventoevaluacionid)")
                    ->from("AppBundle:Evaluacionporsolicitudadmision", "es")
                    ->Where("es.eventoevaluacionid = ev.eventoevaluacionid")
                    ->getDQL() . ") < ev.cupo"
            )
            ->andWhere("ev.eventoevaluacionid != :eventoevaluacionid")
            ->andWhere("ev.evaluacionid = :evaluacionid")
            ->andWhere("ge.gradoid = :gradoid")
            ->andWhere("ev.fechainicio > CURRENT_TIMESTAMP()")
            ->setParameters(array('evaluacionid' => $data["evaluacionid"], 'eventoevaluacionid' => $data['eventoevaluacionid'] ? $data['eventoevaluacionid'] : 0,
                'gradoid' => $data["gradoid"]));
        if ($data["usuarioid"] != 0) {
            $result->andWhere("u.usuarioid =" . $data["usuarioid"]);
        }
        return $result->getQuery()->getResult();
    }

    /* (Query) (Lux)
     * Funcion para obtener el eventos por folio 
     */
    public function getEventosbyFolio($folio, $cicloid, $gradoid)
    {
        $conn = $this->em->getConnection();
        $sql = "SELECT distinct(ee.EventoEvaluacionId),
        e.Nombre AS 'evaluacion', CONCAT_WS(' ', p.Nombre, p.ApellidoPaterno) AS 'evaluador',
        FECHAESPANOL(ee.FechaInicio) fechainicio,
        TIME_FORMAT(ee.HoraInicio, '%H:%i') horainicio, TIME_FORMAT(ee.HoraFin, '%H:%i') horafin,
        g.grado, n.Nombre as 'nivel', s.Folio folio, CONCAT_WS(' ', d.Nombre, d.ApellidoPaterno) nombre,
        (CASE WHEN ee.FechaInicio > NOW() and g.GradoId = :gradoid THEN TRUE ELSE FALSE END) AS 'valida'
        FROM evaluacionporsolicitudadmision es
        INNER JOIN eventoevaluacion ee ON es.EventoEvaluacionId = ee.EventoEvaluacionId
        INNER JOIN solicitudadmision s ON s.SolicitudAdmisionId = es.SolicitudAdmisionId
        INNER JOIN evaluacion e ON e.EvaluacionId = ee.EvaluacionId
        INNER JOIN gradoporeventoevaluacion gee ON gee.EventoEvaluacionId = ee.EventoEvaluacionId
        INNER JOIN grado g ON g.GradoId = gee.GradoId
        INNER JOIN nivel n ON n.NivelId = g.NivelId
        INNER JOIN datoaspirante d ON d.DatoAspiranteId = s.DatoAspiranteId
        INNER JOIN usuario u ON ee.UsuarioId = u.UsuarioId
        INNER JOIN persona p ON p.PersonaId = u.PersonaId
        WHERE s.Folio = :folio AND e.TipoEvaluacionId = 4 AND e.CicloId = :cicloid";

        $stmt = $conn->prepare($sql);
        $stmt->execute(array('folio' => $folio, 'cicloid' => $cicloid, 'gradoid' => $gradoid));
        $result = $stmt->fetchAll();
        return $result;
    }

}
