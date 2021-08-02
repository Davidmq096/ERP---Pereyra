<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Directorio escolar
 *
 * @author david
 */
class AgendaExamenDB extends BaseDBManager {

    public function BuscarMateriaporExtraordinario() {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('
        CASE WHEN pe.planestudioid IS NOT NULL THEN pe.planestudioid ELSE pet.planestudioid END as planestudioid,
        CASE WHEN m.nombre IS NOT NULL THEN m.nombre ELSE mt.nombre END as nombre,
        CASE WHEN m.materiaid IS NOT NULL THEN m.materiaid ELSE mt.materiaid END as materiaid,
        CASE WHEN mp.materiaporplanestudioid IS NOT NULL THEN mp.materiaporplanestudioid ELSE mpt.materiaporplanestudioid END as materiaporplanestudioid ')
        ->from("AppBundle:CeExtraordinario", 'e')
        ->innerJoin('AppBundle:CeProfesorpormateriaplanestudios', 'p', Expr\Join::WITH, "p.profesorpormateriaplanestudiosid= e.profesorpormateriaplanestudiosid")
        ->leftJoin('AppBundle:CeMateriaporplanestudios', 'mp', Expr\Join::WITH, "mp.materiaporplanestudioid = p.materiaporplanestudioid")
        ->leftJoin('AppBundle:CePlanestudios', 'pe', Expr\Join::WITH, "pe.planestudioid = mp.planestudioid")
        ->leftJoin('AppBundle:Materia', 'm', Expr\Join::WITH, "m.materiaid= mp.materiaid")
        ->leftJoin('AppBundle:CeTallercurricular', 't', Expr\Join::WITH, "t.tallercurricularid = p.tallerid")
        ->leftJoin('AppBundle:CeGradoportallercurricular', 'gt', Expr\Join::WITH, "gt.tallercurricularid = t.tallercurricularid")
        ->leftJoin('AppBundle:CeMateriaporplanestudios', 'mpt', Expr\Join::WITH, "mpt.materiaporplanestudioid = gt.materiaporplanestudioid")
        ->leftJoin('AppBundle:CePlanestudios', 'pet', Expr\Join::WITH, "pet.planestudioid = mpt.planestudioid")
        ->leftJoin('AppBundle:Materia', 'mt', Expr\Join::WITH, "mt.materiaid= mpt.materiaid")      
        ->andWhere('e.estatusextraordinarioid != 4')
        ->andWhere('m.activo = 1 or mt.activo = 1')
        ->groupBy('m.materiaid, mt.materiaid, pe.planestudioid, pet.planestudioid');
        return $result->getQuery()->getResult();
    }

    public function FiltrarProfesores($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p")
            ->from("AppBundle:CeProfesorpornivel", 'ppn')
            ->innerJoin('AppBundle:CeProfesor', 'p', Expr\Join::WITH, "p.profesorid = ppn.profesorid")
            ->andWhere('p.estatusempleadoid = 1')
            ->groupBy('p.profesorid');
        if (count($filtros['nivelid'])>0) {
            $result->andWhere('ppn.nivelid in  (:nivelid)')
            ->setParameter('nivelid', $filtros['nivelid']);
        }

        if (isset($filtros['cicloid'])) {
            $result->andWhere('ppn.cicloid =' . $filtros['cicloid']);
        }
        
        return $result->getQuery()->getResult();
    }

    public function BuscarAcuerdosA($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ae.acuerdoextraordinarioid,ce.extraordinarioid, a.alumnoid, 
            a.primernombre, a.apellidopaterno, a.apellidomaterno, ac.correo, eex.estatusextraordinarioid, 
            case when mpe.materiaporplanestudioid is not null then mpe.materiaporplanestudioid else mpet.materiaporplanestudioid as materiaporplanestudioid, 
            te.tipoextraordinarioid")
            ->from("AppBundle:CeAcuerdoextraordinario", 'ae')
            ->innerJoin('AppBundle:CePeriodoregularizacion', 'pr', Expr\Join::WITH, "pr.periodoregularizacionid = ae.periodoregularizacionid")
            ->innerJoin('AppBundle:CeTipoextraordinario', 'te', Expr\Join::WITH, "te.tipoextraordinarioid = ae.tipoextraordinarioid")
            ->innerJoin('AppBundle:CeEstatusextraordinario', 'eex', Expr\Join::WITH, "eex.estatusextraordinarioid = ae.estatusextraordinarioid")
            ->innerJoin('AppBundle:CeExtraordinario', 'ce', Expr\Join::WITH, "ce.extraordinarioid = ae.extraordinarioid")
            ->innerJoin('AppBundle:CeAlumno', 'a', Expr\Join::WITH, "a.alumnoid = ce.alumnoid")
            ->leftJoin('AppBundle:CeAlumnocorreo', 'ac', Expr\Join::WITH, "ac.alumnoid = a.alumnoid")
            ->innerJoin('AppBundle:CeProfesorpormateriaplanestudios', 'pmp', Expr\Join::WITH, "pmp.profesorpormateriaplanestudiosid = ce.profesorpormateriaplanestudiosid")
            ->leftJoin('AppBundle:CeMateriaporplanestudios', 'mpe', Expr\Join::WITH, "mpe.materiaporplanestudioid = pmp.materiaporplanestudioid")
            ->leftJoin('AppBundle:CeGradoportallercurricular', 'gtc', Expr\Join::WITH, "gtc.tallercurricularid = pmp.tallerid")
            ->leftJoin('AppBundle:CeMateriaporplanestudios', 'mpet', Expr\Join::WITH, "mpet.materiaporplanestudioid = gtc.materiaporplanestudioid")

            ->andWhere('ae.estatusextraordinarioid = 2');
            
            if (isset($filtros['filtros']['materiaid'])) {
                $result->andWhere('mpe.materiaporplanestudioid =' . $filtros['filtros']['materiaid'] . 'or mpet.materiaporplanestudioid =' . $filtros['filtros']['materiaid']);
            }

            if (isset($filtros['filtros']['tipoid'])) {
                $result->andWhere('te.tipoextraordinarioid =' . $filtros['filtros']['tipoid']);
            }

            if (isset($filtros['filtros']['periodoregularizacionid'])) {
                $result->andWhere('pr.periodoregularizacionid =' . $filtros['filtros']['periodoregularizacionid']);
            }

        return $result->getQuery()->getResult();
    } 

    public function BuscarAcuerdosporAgenda($id)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ae.acuerdoextraordinarioid, a.alumnoid, a.primernombre, a.apellidopaterno, te.tipoextraordinarioid, a.apellidomaterno, ac.correo, eex.estatusextraordinarioid, m.nombre materia")
            ->from("AppBundle:CeAcuerdoextraordinario", 'ae')
            ->innerJoin('AppBundle:CeTipoextraordinario', 'te', Expr\Join::WITH, "te.tipoextraordinarioid = ae.tipoextraordinarioid")
            ->innerJoin('AppBundle:CeEstatusextraordinario', 'eex', Expr\Join::WITH, "eex.estatusextraordinarioid = ae.estatusextraordinarioid")
            ->innerJoin('AppBundle:CeExtraordinario', 'ce', Expr\Join::WITH, "ce.extraordinarioid = ae.extraordinarioid")
            ->innerJoin('AppBundle:CeAlumno', 'a', Expr\Join::WITH, "a.alumnoid = ce.alumnoid")
            ->leftJoin('AppBundle:CeAlumnocorreo', 'ac', Expr\Join::WITH, "ac.alumnoid = a.alumnoid")
            ->innerJoin('AppBundle:CeProfesorpormateriaplanestudios', 'pmp', Expr\Join::WITH, "pmp.profesorpormateriaplanestudiosid = ce.profesorpormateriaplanestudiosid")
            ->innerJoin('AppBundle:CeMateriaporplanestudios', 'mpe', Expr\Join::WITH, "mpe.materiaporplanestudioid = pmp.materiaporplanestudioid")
            ->innerJoin('AppBundle:Materia', 'm', Expr\Join::WITH, "m.materiaid = mpe.materiaid")
            ->groupBy('a.alumnoid');    
            
            if ($id) {
                $result->andWhere('ae.agendaextraordinarioid =' . $id);
            }

        return $result->getQuery()->getResult();
    } 

    public function BuscarAcuerdoAlumno($id)
    {
        $conn = $this->em->getConnection();
        $filtro = " ";

        if ($id) {
            $filtro =  "and ac.AgendaExtraordinarioId  =" . $id;
        }


        $stmt = $conn->prepare("select  ac.acuerdoextraordinarioid, ac.EstatusExtraordinarioId, e.extraordinarioid, a.alumnoid, a.apellidopaterno, a.apellidomaterno, a.primernombre, c.correo, te.nombre tipoextraordinario from ce_agendaextraordinario ae
        inner join ce_acuerdoextraordinario ac on ac.AgendaExtraordinarioId = ae.AgendaExtraordinarioId
        inner join ce_extraordinario e on e.ExtraordinarioId = ac.ExtraordinarioId
        inner join ce_tipoextraordinario te on te.TipoExtraordinarioId = ae.TipoExtraordinarioId
        inner join ce_profesorpormateriaplanestudios pmp on pmp.ProfesorPorMateriaPlanEstudiosId = e.ProfesorPorMateriaPlanEstudiosId
        inner join ce_alumno a on a.AlumnoId = e.AlumnoId
        left join ce_alumnocorreo c on c.AlumnoId = a.AlumnoId
         where 1=1 $filtro
         group by a.alumnoid");

        $stmt->execute();
        $filtro = $stmt->fetchAll();

        return $filtro;
    } 


    public function BuscarFechaextraordinario($id, $alumno)
    {
        $conn = $this->em->getConnection();
        $filtro = " ";

        if ($id) {
            $filtro = $filtro . " and ae.AgendaExtraordinarioId not in($id)";
        }

        if ($alumno) {
            $filtro = $filtro .  " and a.AlumnoId = $alumno";
        }


        $stmt = $conn->prepare("select ae.AgendaExtraordinarioId, ac.AcuerdoExtraordinarioId, e.ExtraordinarioId, a.AlumnoId, a.ApellidoPaterno, a.ApellidoMaterno, a.PrimerNombre,ae.FechaInicio, ae.HoraInicio, ae.HoraFin, c.Correo from ce_agendaextraordinario ae
        inner join ce_acuerdoextraordinario ac on ac.AgendaExtraordinarioId = ae.AgendaExtraordinarioId
        inner join ce_extraordinario e on e.ExtraordinarioId = ac.ExtraordinarioId
        inner join ce_tipoextraordinario te on te.TipoExtraordinarioId = ae.TipoExtraordinarioId
        inner join ce_alumno a on a.AlumnoId = e.AlumnoId
        left join ce_alumnocorreo c on c.AlumnoId = a.AlumnoId
        where 1=1 and ae.EstatusAgendaExtraordinarioId = 1 and ac.EstatusExtraordinarioId = 3 and ac.TipoExtraordinarioId = 1 $filtro");

        $stmt->execute();
        $filtro = $stmt->fetchAll();

        return $filtro;
    } 

    public function FiltrarAgenda($filtros)
    {   
        $conn = $this->em->getConnection();
        $filtro = " ";
        
        if ($filtros['cicloid']) {
            $filtro =  "and c.CicloId =" . $filtros['cicloid'];
        }

        if (is_array($filtros['nivelid'])) {
            $filtro = $filtro . " " . "and n.NivelId in(" . implode(",", $filtros['nivelid'])  . ")";

        } else if ($filtros['nivelid']) {
            $filtro = $filtro . " " . "and n.NivelId =" . $filtros['nivelid'];
        }

        if (is_array($filtros['gradoid'])) {
            $filtro = $filtro . " " . "and g.GradoId in(" . implode(",", $filtros['gradoid'])  . ")";

        } else if ($filtros['gradoid']) {
            $filtro = $filtro . " " . "and g.GradoId =" . $filtros['gradoid'];
        }

        if ($filtros['planestudioid']) {
            $filtro = $filtro . " " . "and p.PlanEstudioId =" . $filtros['planestudioid'];
        }

        if ($filtros['materiaid']) {
            $filtro = $filtro . " " . "and m.MateriaId =" . $filtros['materiaid'];
        }        

        if ($filtros['tipoexamenid']) {
            $filtro = $filtro . " " . "and ae.TipoExtraordinarioId =" . $filtros['tipoexamenid'];
        }   

        if ($filtros['periodoid']) {
            $filtro = $filtro . " " . "and pr.PeriodoRegularizacionId =" . $filtros['periodoid'];
        }   

        if ($filtros['estatusid']) {
            $filtro = $filtro . " " . "and eae.EstatusAgendaExtraordinarioId =" . $filtros['estatusid'];
        } 

        $stmt = $conn->prepare("select ae.AgendaExtraordinarioId, c.CicloId, c.Nombre ciclo, n.NivelId,  n.Nombre nivel, g.GradoId, g.Grado, 
        m.MateriaId, m.Nombre materia, ae.TipoExtraordinarioId,te.Nombre tipoextraordinario, eae.EstatusAgendaExtraordinarioId, 
        eae.Nombre estatusagendaextraordinario, DATE_FORMAT(ae.FechaInicio,'%d/%m/%Y') FechaInicioFormatted,ae.FechaInicio, 
        ae.FechaRevision, ae.LugarId, ae.LugarRevisionId, ae.Cupo, DATE_FORMAT(ae.HoraInicioRevision,'%H:%i') HoraInicioRevision, 
        DATE_FORMAT(ae.HoraFinRevision,'%H:%i') HoraFinRevision, ae.FechaFin, DATE_FORMAT(ae.FechaFin,'%d/%m/%Y') FechaFinFormatted,
        ae.HoraInicio, p.PlanEstudioId, mp.MateriaPorPlanEstudioId, DATE_FORMAT(ae.HoraFin,'%H:%i') HoraFin, ae.Comentarios, 
        pr.PeriodoRegularizacionId, pr.Nombre periodoregularizacion,
        prof.ProfesorId, prof.Nombre nombreprofesor, prof.ApellidoPaterno, prof.ApellidoMaterno,  
          (select count(subacu.AcuerdoExtraordinarioId) from ce_agendaextraordinario subae inner join ce_acuerdoextraordinario subacu
         on subacu.AgendaExtraordinarioId = subae.AgendaExtraordinarioId where subae.AgendaExtraordinarioId = ae.AgendaExtraordinarioId) alumnosasignados,
        (select count(subacu.AcuerdoExtraordinarioId) from ce_agendaextraordinario subae 
         inner join ce_acuerdoextraordinario subacu on subacu.AgendaExtraordinarioId = subae.AgendaExtraordinarioId
         inner join cj_documentoporpagar subdp on subdp.documentoporpagarid = subacu.documentoporpagarid 
         where subdp.Pagoestatusid = 2 and subae.AgendaExtraordinarioId = ae.AgendaExtraordinarioId)
        alumnospagados
        from ce_agendaextraordinario ae
        inner join ce_tipoextraordinario te on te.TipoExtraordinarioId = ae.TipoExtraordinarioId
        inner join ce_estatusagendaextraordinario eae on eae.EstatusAgendaExtraordinarioId = ae.EstatusAgendaExtraordinarioId
        inner join ce_periodoregularizacion pr on pr.PeriodoRegularizacionId = ae.PeriodoRegularizacionId
        inner join ciclo c on c.CicloId = pr.CicloId
        inner join ce_materiaporplanestudios mp on mp.MateriaPorPlanEstudioId = ae.MateriaPorPlanEstudioId
        inner join ce_planestudios p on p.PlanEstudioId = mp.PlanEstudioId
        inner join grado g on g.GradoId = p.GradoId
        inner join materia m on m.MateriaId = mp.MateriaId
        inner join nivel n on n.NivelId = m.NivelId
        inner join ce_profesor prof on prof.ProfesorId = ae.ProfesorId
        left join ce_acuerdoextraordinario acu on acu.AgendaExtraordinarioId = ae.AgendaExtraordinarioId
        where 1 = 1  $filtro
        group by ae.AgendaExtraordinarioId");

        $stmt->execute();
        $filtro = $stmt->fetchAll();

        return $filtro;
    }

    public function BuscarAgendaporAcuerdo($filtros,$periodo) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('e.agendaextraordinarioid,pr.periodoregularizacionid,
        te.tipoextraordinarioid,e.fechainicio,e.fechafin,e.horainicio,e.horafin,e.cupo')
        ->from("AppBundle:CeAgendaextraordinario", 'e')
        ->leftJoin("AppBundle:CePeriodoregularizacion", "pr", Expr\Join::WITH, "pr.periodoregularizacionid = e.periodoregularizacionid ")
        ->leftJoin('AppBundle:CeTipoextraordinario', 'te', Expr\Join::WITH, "te.tipoextraordinarioid = e.tipoextraordinarioid")
        ->innerJoin("AppBundle:CeMateriaporplanestudios", "mp", Expr\Join::WITH, "mp.materiaporplanestudioid = e.materiaporplanestudioid")
        ->groupBy('e.agendaextraordinarioid')
        ->orderBy("e.fechainicio");

        
        if (isset($filtros['tipoextraordinarioid'])) {
            $result->andWhere('te.tipoextraordinarioid =' . $filtros['tipoextraordinarioid']);
        }

        if ($periodo) {
            $result->andWhere('pr.periodoregularizacionid =' . $periodo->getPeriodoregularizacionid());

        } else if (isset($filtros['periodoregularizacionid'])) {
            $result->andWhere('pr.periodoregularizacionid =' . $filtros['periodoregularizacionid']);
        }
        
        if (isset($filtros['materiaporplanestudioid'])) {
            $result->andWhere('mp.materiaporplanestudioid=' . $filtros['materiaporplanestudioid']);
        }

        return $result->getQuery()->getResult();
    }

    public function BuscarAgenda($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('e.agendaextraordinarioid')
        ->from("AppBundle:CeAgendaextraordinario", 'e')
        ->innerJoin("AppBundle:CeAcuerdoextraordinario", "ae", Expr\Join::WITH, "ae.acuerdoextraordinarioid = e.acuerdoextraordinarioid")
        ->leftJoin("AppBundle:CePeriodoregularizacion", "pr", Expr\Join::WITH, "pr.periodoregularizacionid = e.periodoregularizacionid ")
        ->leftJoin('AppBundle:CeTipoextraordinario', 'te', Expr\Join::WITH, "te.tipoextraordinarioid = e.tipoextraordinarioid")
        ->innerJoin("AppBundle:CeMateriaporplanestudios", "mp", Expr\Join::WITH, "mp.materiaporplanestudioid = e.materiaporplanestudioid")
        ->innerJoin('AppBundle:CeAlumno', 'a', Expr\Join::WITH, "a.alumnoid = ce.alumnoid")
        ->innerJoin('AppBundle:Materia', 'm', Expr\Join::WITH, "m.materiaid = mpe.materiaid");
        
        if (isset($filtros['alumnoid'])) {
            $result->andWhere('a.alumnoid =' . $filtros['alumnoid']);
        }

        if (isset($filtros['materiaid'])) {
            $result->andWhere('m.materiaid=' . $filtros['materiaid']);
        }

        return $result->getQuery()->getResult();
    }

}