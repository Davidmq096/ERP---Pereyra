<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Cronograma de tareas
 *
 * @author Mariano
 */
class CronogramaDeTareasDB extends BaseDBManager 
{
    public function BuscarDatosAlumno($alumnoid) 
    {
        $qb = $this->em->createQueryBuilder();
        $ultimociclo = $qb->select('Case WHEN max(ccca.cicloid) IS NULL THEN max(ccc.cicloid) ELSE max(ccca.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu")
            ->innerJoin("acu.cicloid", "ccc")
            ->leftJoin("AppBundle:Ciclo", "ccca", Expr\Join::WITH, "acu.cicloid = ccca.cicloid and ccca.actual = 1")
            ->where("acu.alumnoid = a.alumnoid")
            ->groupBy('acu.alumnoid');
        if (isset($filtros['cicloactual'])) {
            $ultimociclo->andWhere('ccc.actual = 1');
        }
        if (isset($filtros['cicloid'])) {
            $ultimociclo->andWhere('ccc.cicloid = :cicloid');
        }

        $qb = $this->em->createQueryBuilder();
        $ultimociclo2 = $qb->select('Case WHEN max(ccca2.cicloid) IS NULL THEN max(ccc2.cicloid) ELSE max(ccca2.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu2")
            ->innerJoin("acu2.cicloid", "ccc2")
            ->leftJoin("AppBundle:Ciclo", "ccca2", Expr\Join::WITH, "acu2.cicloid = ccca2.cicloid and ccca2.actual = 1")
            ->where("acu2.alumnoid = a.alumnoid")
            ->groupBy('acu2.alumnoid');
        if (isset($filtros['cicloactual'])) {
            $ultimociclo2->andWhere('ccc2.actual = 1');
        }
        if (isset($filtros['cicloid'])) {
            $ultimociclo2->andWhere('ccc2.cicloid = :cicloid');
        }

        $qb = $this->em->createQueryBuilder();
        $gradoactual = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = (" . $ultimociclo . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid");
        if (isset($filtros['alumnoporcicloid'])) {
            $gradoactual->andWhere('ac2.alumnoporcicloid =' . $filtros['alumnoporcicloid']);
        }

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("g.grado,n.nombre as nivel,gru.nombre as grupo,acf.foto")
        ->from("AppBundle:CeAlumno","a")
        ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid and ac.gradoid = (" . $gradoactual . ") and ac.cicloid = (" . $ultimociclo2 . ")")
        ->innerJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid")
        ->leftJoin("AppBundle:CeAlumnociclofoto", "acf", Expr\Join::WITH, "acf.alumnoporcicloid = ac.alumnoporcicloid")
        ->innerJoin("AppBundle:CeGrupo", "gru", Expr\Join::WITH, "gru.grupoid = acg.grupoid")
        ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid = ac.gradoid")
        ->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "g.nivelid = n.nivelid");
        $result->andWhere('a.alumnoid = :alumnoid')
        ->setParameter('alumnoid', $alumnoid);
        return $result->getQuery()->getResult();
    }

    public function BuscarTareasAlumnoPortal($alumnoid, $alumnociclo, $profesorpormateriaplanestudiosid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("case when m.materiaid is not null then m.nombre else mm.nombre end as MateriaNombre,
        case when m.materiaid is not null then m.materiaid else mm.materiaid end as MateriaId,
        CONCAT_WS(' ',p.nombre, p.apellidopaterno, p.apellidomaterno) as ProfesorNombre, g.grado as GradoNombre,
        case when gru.grupoid is not null then gru.nombre else tas.nombre end as GrupoNombre,
        pev.descripcion as  PeriodoEvaluacionNombre,pev.descripcioncorta as  PeriodoEvaluacionNombreCorto,
        pev.periodoevaluacionid,t.nombre as TareaNombre,t.tareaid as TareaID,
        DATE_FORMAT(t.fechainicio,'%Y-%m-%d') as fechainicio,
        DATE_FORMAT(t.fechafin,'%Y-%m-%d') as fechafin,
        DATE_FORMAT(t.fechainicio,'%Y/%m/%d') as fechai,
        DATE_FORMAT(t.fechainicio,'%d/%m/%Y') as fechaini,
        DATE_FORMAT(t.fechafin,'%d/%m/%Y') as fechaf,
        t.descripcion as Descripcion,ta.tareaalumnoid,ta.entiempo as Entregado,ta.calificacion as Calificacion,
        ti.nombre as tipoentrega,ti.tipoentregaid,DATE_FORMAT(t.horalimite,'%H:%i') as HoraLimite,ceg.puntajemaximo,
        t.entregaextemporanea,a.alumnoid as IDAlumno,t.captura,ceg.criterioevaluaciongrupoid, acgt.gradoportallercurricularid")
        ->from("AppBundle:CeTarea","t")
        ->innerJoin("t.tipoentregaid", "ti")
        ->innerJoin("t.criterioevaluaciongrupoid", "ceg")
        ->innerJoin("ceg.periodoevaluacionid", "pev")
        ->innerJoin("pev.conjuntoperiodoevaluacionid", "c")
        ->innerJoin("ceg.profesorpormateriaplanestudiosid", "pmpe", Expr\Join::WITH)
        ->innerJoin("pmpe.profesorid", "p")
        
        ->leftJoin("AppBundle:CeTareaalumno", "ta", Expr\Join::WITH, "ta.tareaid = t.tareaid")
        ->leftJoin("ta.alumnoid", "a")
        ->leftJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid and c.cicloid = ac.cicloid and ac.alumnoporcicloid = :alumnociclo")
        ->leftJoin("ac.gradoid", "g")

        ->leftJoin("pmpe.grupoid", "gru")
        ->leftJoin("AppBundle:CeMateriaporplanestudios", "mpe", Expr\Join::WITH, "mpe.materiaporplanestudioid = pmpe.materiaporplanestudioid")
        ->leftJoin("AppBundle:CePlanestudios", "pe", Expr\Join::WITH, "pe.planestudioid = mpe.planestudioid")
        ->leftJoin("mpe.materiaid", "m")

        ->leftJoin("pmpe.tallerid", "tas")
        ->leftJoin("AppBundle:CeAlumnocicloportaller", "act", Expr\Join::WITH, "act.alumnoporcicloid = ac.alumnoporcicloid and act.vigente = 1")
        ->leftJoin("AppBundle:CeGradoportallercurricular", "acgt", Expr\Join::WITH, "tas.tallercurricularid = acgt.tallercurricularid and ac.gradoid = acgt.gradoid")
        ->leftJoin("acgt.materiaporplanestudioid", "mpee")
        ->leftJoin("mpee.planestudioid", "peet")
        ->leftJoin("mpee.materiaid", "mm")
        
        ->groupBy('t.tareaid')
        ->orderBy("t.tareaid", "DESC");
        $result->andWhere('a.alumnoid = :alumnoid')
        ->andWhere('pe.gradoid = g.gradoid or peet.gradoid = g.gradoid')
        ->andWhere('(pe.areaespecializacionid is null or pe.areaespecializacionid = gru.areaespecializacionid)
         or (peet.areaespecializacionid is null or peet.areaespecializacionid = gru.areaespecializacionid)')
         ->andWhere('CAST(CURRENT_DATE() AS date) <=  CAST(pev.fechapublicaciondefinitiva AS date)')
        ->setParameter('alumnoid', $alumnoid)
        ->setParameter('alumnociclo', $alumnociclo);

        if ($profesorpormateriaplanestudiosid){
            $result->andWhere('pmpe.profesorpormateriaplanestudiosid = :profesorpormateriaplanestudiosid')
            ->setParameter('profesorpormateriaplanestudiosid', $profesorpormateriaplanestudiosid);
        }
        return $result->getQuery()->getResult();
    }


    public function BuscarComentarios($tareaid,$alumnoid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("t.tareaid as TareaID,c.comentario as Comentario,u.usuarioid as UsuarioID,DATE_FORMAT(c.fecha,'%d/%m/%Y %H:%i') as Fecha,
        CASE
            WHEN u.alumnoid is not null THEN CONCAT_WS(' ',a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno)
            WHEN u.profesorid is not null THEN CONCAT_WS(' ',pro.nombre, pro.apellidopaterno, pro.apellidomaterno)
            ELSE CONCAT_WS(' ',per.nombre, per.apellidopaterno, per.apellidomaterno)
        END as Usuario, c.leido, c.tareacomentarioid, t.tareaid, tu.tipousuarioid")
        ->from("AppBundle:CeTareacomentario","c")
        ->innerJoin("c.tareaid", "t")
        ->leftJoin("c.usuarioid", "u")
        ->leftJoin("u.tipousuarioid", "tu")
        ->leftJoin("AppBundle:Persona", "per", Expr\Join::WITH, "per.personaid=u.personaid")
        ->leftJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid=u.alumnoid")
        ->leftJoin("AppBundle:CeProfesor", "pro", Expr\Join::WITH, "pro.profesorid=u.profesorid");
        $result->andWhere('c.tareaid = :tareaid')
        ->setParameter('tareaid', $tareaid);
        $result->andWhere('c.alumnoid = :alumnoid')
        ->setParameter('alumnoid', $alumnoid)
        ->groupBy('c.tareacomentarioid');
        return $result->getQuery()->getResult();
    }

    public function BuscarComentariosApp($tareaid,$alumnoid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("t.tareaid as TareaID,c.comentario as Comentario,u.usuarioid as UsuarioID,DATE_FORMAT(c.fecha,'%Y-%m-%d') as Fecha,
        CASE
            WHEN u.alumnoid is not null THEN CONCAT_WS(' ',a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno)
            WHEN u.profesorid is not null THEN CONCAT_WS(' ',pro.nombre, pro.apellidopaterno, pro.apellidomaterno)
            ELSE CONCAT_WS(' ',per.nombre, per.apellidopaterno, per.apellidomaterno)
        END as Usuario")
        ->from("AppBundle:CeTareacomentario","c")
        ->innerJoin("c.tareaid", "t")
        ->leftJoin("c.usuarioid", "u")
        ->leftJoin("AppBundle:Persona", "per", Expr\Join::WITH, "per.personaid=u.personaid")
        ->leftJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid=u.alumnoid")
        ->leftJoin("AppBundle:CeProfesor", "pro", Expr\Join::WITH, "pro.profesorid=u.profesorid");
        $result->andWhere('c.tareaid = :tareaid')
        ->setParameter('tareaid', $tareaid);
        $result->andWhere('c.alumnoid = :alumnoid')
        ->setParameter('alumnoid', $alumnoid);
        return $result->getQuery()->getResult();
    }


    public function BuscarAsignacionProfesor($profesorpormateriaplanestudiosid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("case when n.nivelid is not null then n.nombre else nn.nombre end nivel,case when n.nivelid is not null then n.nivelid else nn.nivelid end nivelid,case when g.gradoid is not null then g.grado else GroupConcat(' ', gg.grado) end grado,case when g.gradoid is not null then g.gradoid else GroupConcat(' ', gg.gradoid) end gradoid,case when gru.grupoid is not null then gru.nombre else GroupConcat(' ', ta.nombre) end as grupo,case when gru.grupoid is not null then gru.grupoid else GroupConcat(' ', ta.tallercurricularid) end as grupoid,case when m.materiaid is not null then m.nombre else GroupConcat(' ', mm.nombre) end as materia,case when m.materiaid is not null then m.materiaid else GroupConcat(' ', mm.materiaid) end as materiaid, concat(p.nombre,' ',p.apellidopaterno) as profesor")
        ->from("AppBundle:CeProfesorpormateriaplanestudios","pmpe")
        ->innerJoin("AppBundle:CeProfesor", "p", Expr\Join::WITH, "p.profesorid = pmpe.profesorid")
        ->leftJoin("pmpe.materiaporplanestudioid", "mpe")
        ->leftJoin("mpe.materiaid", "m")
        ->leftJoin("pmpe.grupoid", "gru")
        ->leftJoin("gru.gradoid", "g")
        ->leftJoin("g.nivelid", "n")
        ->leftJoin("pmpe.tallerid", "ta")
        ->leftJoin("AppBundle:CeGradoportallercurricular", "cgta", Expr\Join::WITH, "cgta.tallercurricularid = ta.tallercurricularid")
        ->leftJoin("cgta.materiaporplanestudioid", "mpee")
        ->leftJoin("mpee.materiaid", "mm")
        ->leftJoin("cgta.gradoid", "gg")
        ->leftJoin("gg.nivelid", "nn")
        ->groupBy("pmpe.profesorpormateriaplanestudiosid");
        $result->andWhere('pmpe.profesorpormateriaplanestudiosid = :profesorpormateriaplanestudiosid')
        ->setParameter('profesorpormateriaplanestudiosid', $profesorpormateriaplanestudiosid);
        return $result->getQuery()->getResult();
    }

    public function BuscarTareas($profesorpormateriaplanestudiosid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("t.tareaid as ID,pe.descripcion as PeriodoEvaluacionNombre,
        pe.periodoevaluacionid as PeriodoEvaluacionID,t.captura as NumeroCapturaTarea,t.nombre as Nombre,
        DATE_FORMAT(t.fechainicio,'%d/%m/%Y') as fechainicio,DATE_FORMAT(t.fechafin,'%d/%m/%Y') as fechafin,
        DATE_FORMAT(t.horalimite,'%H:%i') as HoraLimite,te.nombre as TipoEntregaNombre,te.tipoentregaid as TipoEntregaID,
        t.entregaextemporanea as PermitirEntregaTarde,t.descripcion as Descripcion,ceg.criterioevaluaciongrupoid,
        ceg.puntajemaximo, ceg.aspecto,
        CASE WHEN tr.tallercurricularid is not null then tr.nombre else g.nombre as grupo,
        CASE WHEN m.materiaid is not null then m.nombre else mt.nombre as materia,
        CASE WHEN gr.gradoid is not null then gr.grado else grt.grado as grado
        ")
        ->from("AppBundle:CeTarea","t")
        ->innerJoin("t.criterioevaluaciongrupoid", "ceg")
        ->innerJoin("AppBundle:CePeriodoevaluacion", "pe", Expr\Join::WITH, "pe.periodoevaluacionid = ceg.periodoevaluacionid")
        ->innerJoin("ceg.profesorpormateriaplanestudiosid", "pmpe")
        ->leftJoin("pmpe.grupoid", "g")
        ->leftJoin("pmpe.materiaporplanestudioid", "mpe")
        ->leftJoin("mpe.materiaid", "m")
        ->leftJoin("g.gradoid", "gr")


        ->leftJoin("pmpe.tallerid", "tr")
        ->leftJoin("AppBundle:CeGradoportallercurricular", "gtc", Expr\Join::WITH, "gtc.tallercurricularid = tr.tallercurricularid")
        ->leftJoin("gtc.materiaporplanestudioid", "mpet")
        ->leftJoin("mpet.materiaid", "mt")
        ->leftJoin("gtc.gradoid", "grt")




        ->innerJoin("t.tipoentregaid", "te");
        
        if ($profesorpormateriaplanestudiosid){
            $result->andWhere('pmpe.profesorpormateriaplanestudiosid = :profesorpormateriaplanestudiosid')
            ->setParameter('profesorpormateriaplanestudiosid', $profesorpormateriaplanestudiosid);
        }
        $result->andWhere('ceg.configurartarea = 1');
        return $result->getQuery()->getResult();
    }

    public function BuscarTareasAlumno($tareaid,$grupoid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ta.tareaalumnoid,t.tareaid as TareaID,a.matricula as Matricula,t.nombre as NombreTarea,CONCAT_WS(' ',a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) as NombreAlumno,a.alumnoid as IDAlumno,DATE_FORMAT(ta.fecha,'%d/%m/%Y') as FechaEntrega,ta.entiempo as EnTiempo,ta.calificacion as Calificacion,acg.numerolista")
        ->from("AppBundle:CeAlumno","a")
        ->leftJoin("AppBundle:CeTareaalumno", "ta", Expr\Join::WITH, "a.alumnoid = ta.alumnoid")
        ->leftJoin("AppBundle:CeTarea", "t", Expr\Join::WITH, "t.tareaid = ta.tareaid")
        ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid")
        ->innerJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid")
        ->orderBy("acg.numerolista");;
        
        $result->andWhere('t.tareaid = :tareaid or t.tareaid is null')
        ->setParameter('tareaid', $tareaid);
        $result->andWhere('acg.grupoid = :grupoid')
        ->setParameter('grupoid', $grupoid);
        return $result->getQuery()->getResult();
    }
    
}
