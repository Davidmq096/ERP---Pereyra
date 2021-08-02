<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asignacion materia
 *
 * @author Gabriel
 */
class MisClasesDB extends BaseDBManager 
{
    

    public function BuscarProfesorPorUsuarioId($usuarioid) 
    {   
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("u.usuarioid UsuarioId, pr.profesorid ProfesorId,
        concat_ws(' ', pr.apellidopaterno, pr.apellidomaterno, pr.nombre) NombreCompletoProfesor, n.nivelid,pn.profesorpornivelid ProfesorPorNivelId,n.nivelid NivelId,c.cicloid CicloId,pn.activo Activo")
        ->from("AppBundle:CeProfesor","pr")
        ->leftJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.profesorid = pr.profesorid")
        ->leftJoin("AppBundle:CeProfesorpornivel", "pn", Expr\Join::WITH, "pr.profesorid = pn.profesorid")
        ->leftJoin("pn.nivelid","n")
        ->leftJoin("pn.cicloid","c")
        ->orderBy('pr.apellidopaterno, pr.apellidomaterno, pr.nombre');
        return $result->getQuery()->getResult();
        
    }

    public function BuscarAsignacionmateria($filtros) 
    {
        //Grupos o subgrupos
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.cicloid,g.gradoid,m.materiaid,mpe.materiaporplanestudioid,n.nombre as nivel,n.nombrecorto as nivelcorto, n.nivelid,g.grado,gru.nombre as grupo, CASE WHEN mpe.configurarsubmaterias = 1 THEN concat_ws(' - ', m.nombre, ms.nombre) else m.nombre END as materia, concat_ws(' ',p.apellidopaterno,p.apellidomaterno,p.nombre) as maestro,pmpe.profesorpormateriaplanestudiosid,concat_ws(' ',co.apellidopaterno,co.apellidomaterno,co.nombre) as cotitular,gru.grupoid, concat_ws(' ',s.apellidopaterno,s.apellidomaterno,s.nombre) as suplente")
        ->from("AppBundle:CeProfesorpormateriaplanestudios","pmpe")
        ->innerJoin("pmpe.profesorid", "p")
        ->leftJoin("pmpe.cotitularid", "co")
        ->leftJoin("pmpe.suplenteid", "s")
        ->innerJoin("pmpe.materiaporplanestudioid", "mpe")
        ->innerJoin("mpe.materiaid", "m")
        ->leftJoin("m.areaacademicaid", "aa")
        ->leftJoin("pmpe.materiaid", "ms")
        ->leftJoin("mpe.planestudioid", "pe")
        ->innerJoin("pmpe.grupoid", "gru")
        ->innerJoin("gru.gradoid", "g")
        ->innerJoin("gru.cicloid", "c")
        ->innerJoin("g.nivelid", "n")
        ->leftJoin("AppBundle:CeGrupoorigenporsubgrupo", "gpc", Expr\Join::WITH, "gpc.grupoid=gru.grupoid")
        ->leftJoin("gpc.grupoorigenid", "gpcgru")
        ->leftJoin("gpc.materiaporplanestudioid", "mpppe")
        ->leftJoin("mpppe.planestudioid", "pee")
        ->leftJoin("AppBundle:CeCriterioevaluaciongrupo", "ceg", Expr\Join::WITH, "ceg.profesorpormateriaplanestudiosid=pmpe.profesorpormateriaplanestudiosid")
        ->andWhere('mpe.configurartaller = 0')
        ->groupBy("pmpe.profesorpormateriaplanestudiosid");
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid = :cicloid')
        	->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid in (:nivelid)')
        	->setParameter('nivelid', $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid in (:gradoid)')
        	->setParameter('gradoid', $filtros['gradoid']);
        }
        if (isset($filtros['grupoid'])) {
        	$result->andWhere('gru.grupoid = :grupoid or gpcgru.grupoid = :grupoid')
        	->setParameter('grupoid', $filtros['grupoid']);
        }
        if (isset($filtros['planestudioid'])) {
        	$result->andWhere('pe.planestudioid = :planestudioid or pee.planestudioid = :planestudioid')
        	->setParameter('planestudioid', $filtros['planestudioid']);
        }
        if (isset($filtros['semestreid'])) {
        	$result->andWhere('g.semestreid = :semestreid')
        	->setParameter('semestreid', $filtros['semestreid']);
        }
        if (isset($filtros['periodoevaluacionid'])) {
        	$result->andWhere('ceg.periodoevaluacionid = :periodoevaluacionid')
        	->setParameter('periodoevaluacionid', $filtros['periodoevaluacionid']);
        }
        if (isset($filtros['materiaid'])) {
        	$result->andWhere('m.materiaid = :materiaid')
        	->setParameter('materiaid', $filtros['materiaid']);
        }
        if (isset($filtros['profesorid'])) {
        	$result->andWhere('p.profesorid in (:profesorid) or co.profesorid in (:profesorid) or s.profesorid in (:profesorid)')
        	->setParameter('profesorid', $filtros['profesorid']);
        }
        if (isset($filtros['isjefeacademico'])) {
        	$result->andWhere('aa.areaacademicaid IN (:areas)')
        	->setParameter('areas', $filtros['areasacademicasid']);
        }

        $query=$qb->getQuery()->getSQL();

        $asignaciones =  $result->getQuery()->getResult();

        //Talleres
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.cicloid,g.gradoid,m.materiaid,mpe.materiaporplanestudioid,n.nombre as nivel,n.nivelid,GroupConcat(DISTINCT g.grado SEPARATOR ', ') as grado,ta.nombre as grupo,GroupConcat(DISTINCT m.nombre SEPARATOR ', ') as materia, concat_ws(' ',p.apellidopaterno,p.apellidomaterno,p.nombre) as maestro,pmpe.profesorpormateriaplanestudiosid,concat_ws(' ',co.apellidopaterno,co.apellidomaterno,co.nombre) as cotitular,ta.tallercurricularid, concat_ws(' ',s.apellidopaterno,s.apellidomaterno,s.nombre) as suplente")
        ->from("AppBundle:CeProfesorpormateriaplanestudios","pmpe")
        ->leftJoin("pmpe.profesorid", "p")
        ->leftJoin("pmpe.cotitularid", "co")
        ->leftJoin("pmpe.suplenteid", "s")
        ->innerJoin("pmpe.tallerid", "ta")
        ->innerJoin("AppBundle:CeGradoportallercurricular", "cga", Expr\Join::WITH, "cga.tallercurricularid=ta.tallercurricularid")
        ->innerJoin("cga.materiaporplanestudioid", "mpe")
        ->innerJoin("mpe.materiaid", "m")
        ->leftJoin("m.areaacademicaid", "aa")
        ->innerJoin("mpe.planestudioid", "pe")
        ->innerJoin("cga.gradoid", "g")
        ->innerJoin("g.nivelid", "n")
        ->innerJoin("ta.cicloid", "c")
        ->leftJoin("AppBundle:CeCriterioevaluaciongrupo", "ceg", Expr\Join::WITH, "ceg.profesorpormateriaplanestudiosid=pmpe.profesorpormateriaplanestudiosid")
        ->andWhere('mpe.configurartaller = 1')
        ->groupBy("pmpe.profesorpormateriaplanestudiosid");
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid = :cicloid')
        	->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid in (:nivelid)')
        	->setParameter('nivelid', $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid in (:gradoid)')
        	->setParameter('gradoid', $filtros['gradoid']);
        }
        if (isset($filtros['planestudioid'])) {
            $result->andWhere('pe.planestudioid = :planestudioid')
        	->setParameter('planestudioid', $filtros['planestudioid']);
        }
        if (isset($filtros['semestreid'])) {
        	$result->andWhere('g.semestreid = :semestreid')
        	->setParameter('semestreid', $filtros['semestreid']);
        }
        if (isset($filtros['periodoevaluacionid'])) {
        	$result->andWhere('ceg.periodoevaluacionid = :periodoevaluacionid')
        	->setParameter('periodoevaluacionid', $filtros['periodoevaluacionid']);
        }
        if (isset($filtros['materiaid'])) {
        	$result->andWhere('m.materiaid = :materiaid')
        	->setParameter('materiaid', $filtros['materiaid']);
        }
        if (isset($filtros['profesorid'])) {
        	$result->andWhere('p.profesorid in (:profesorid) or co.profesorid in (:profesorid) or s.profesorid in (:profesorid)')
        	->setParameter('profesorid', $filtros['profesorid']);
        }
        if (isset($filtros['isjefeacademico'])) {
        	$result->andWhere('aa.areaacademicaid IN (:areas)')
        	->setParameter('areas', $filtros['areasacademicasid']);
        }

        $query=$qb->getQuery();
        //print_r($query);
        
        
        $asignaciones2 =  $result->getQuery()->getResult();

        foreach($asignaciones2 as $a){
            $asignaciones[] = $a;
        }
        foreach($asignaciones as &$asignacion){
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("cp.periodoevaluacionid, cp.descripcioncorta, cp.descripcion, cp.fechainicio, cp.fechafin")
            ->from("AppBundle:CeConjuntoperiodoevaluacion","cem")
            ->innerJoin("AppBundle:CeGradoporconjuntoperiodoescolar", "gc", Expr\Join::WITH, "gc.conjuntoperiodoevaluacionid = cem.conjuntoperiodoevaluacionid")
            ->innerJoin("AppBundle:CePeriodoevaluacion", "cp", Expr\Join::WITH, "cp.conjuntoperiodoevaluacionid = cem.conjuntoperiodoevaluacionid")
            ->where('gc.gradoid in (:gradoid)')
            ->setParameter('gradoid', $asignacion['gradoid'])
            ->andWhere('cem.cicloid in (:cicloid)')
            ->setParameter('cicloid', $asignacion['cicloid']);
            $asignacion['periodosevaluacion'] = $result->getQuery()->getResult();
        }
        return $asignaciones;
    }

    public function getMateriasAlumno ($filtros) {
        try 
        {
            $conn = $this->em->getConnection();
            $stmt = $conn->prepare("SELECT cp.profesorpormateriaplanestudiosid, case when mpe.MateriaPorPlanEstudioId is not null then mpe.MateriaPorPlanEstudioId else cm.MateriaPorPlanEstudioId end  as materiaporplanestudioid, CONCAT_WS(' ',  p.ApellidoPaterno, p.ApellidoMaterno, p.Nombre) AS profesor, m.Nombre AS materia FROM ce_profesorpormateriaplanestudios cp
            INNER JOIN ce_profesor p ON p.ProfesorId = cp.ProfesorId
            LEFT JOIN ce_materiaporplanestudios cm  ON cm.MateriaPorPlanEstudioId = cp.MateriaPorPlanEstudioId
            LEFT JOIN ce_alumnocicloporgrupo acg ON acg.GrupoId = cp.GrupoId
            LEFT JOIN ce_grupo cg ON cg.grupoid = cp.GrupoId
            LEFT JOIN ce_alumnocicloportaller act ON act.TallerCurricularId = cp.TallerId AND act.Vigente = 1
            LEFT JOIN ce_alumnoporciclo ac ON ac.AlumnoPorCicloId = act.AlumnoPorCicloId OR ac.AlumnoPorCicloId = acg.AlumnoPorCicloId
            LEFT JOIN ce_gradoportallercurricular gtc ON gtc.TallerCurricularId = cp.TallerId AND gtc.GradoId = ac.GradoId
            LEFT JOIN ce_materiaporplanestudios mpe ON mpe.MateriaPorPlanEstudioId = cm.MateriaPorPlanEstudioId OR mpe.MateriaPorPlanEstudioId = gtc.MateriaPorPlanEstudioId
            LEFT JOIN ce_planestudios pe ON pe.PlanEstudioId = mpe.PlanEstudioId AND pe.AreaespecializacionId = cg.AreaespecializacionId
            LEFT JOIN materia m ON m.MateriaId = mpe.MateriaId
            WHERE ac.AlumnoPorCicloId = :alumnoporcicloid
            GROUP BY cp.ProfesorPorMateriaPlanEstudiosId
            ORDER BY m.Nombre");
            $stmt->execute(array('alumnoporcicloid' => $filtros['alumnoporcicloid']));
            $result = $stmt->fetchAll(); 
            return $result;          
        } 
        catch (Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
