<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Filtrado de Tipos de Becas
 *
 * @author Rubén
 */
class ProfesorNivelDB extends BaseDBManager
{
    public function FiltrarProfesoresPorNivel($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ppn")
            ->from("AppBundle:CeProfesorpornivel", 'ppn')
            ->groupBy('ppn.profesorid');

        if (count($filtros['nivelid'])>0) {
            $result->andWhere('ppn.nivelid in  (:nivelid)')
            ->setParameter('nivelid', $filtros['nivelid']);
        }

        if (isset($filtros['cicloid'])) {
            $result->andWhere('ppn.cicloid =' . $filtros['cicloid']);
        }

        return $result->getQuery()->getResult();
    }

    public function FiltrarProfesoresPorNivelFaltantes($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $qb2 = $this->em->createQueryBuilder();
        $nivelid = is_array($filtros['nivelid']) ? implode (", ", $filtros['nivelid']) : $filtros['nivelid'];
        $result = $qb->select("p")
            ->from("AppBundle:CeProfesor", 'p')
            ->leftJoin('AppBundle:CeProfesorpornivel','ppn',\Doctrine\ORM\Query\Expr\Join::WITH,'ppn.profesorid = p.profesorid'
            )->Where('ppn.profesorpornivelid is null')
            ->orWhere(
                $qb->expr()->notIn(
                    'ppn.profesorid',
                    $qb2->select('IDENTITY(ppnn.profesorid)')
                        ->from('AppBundle:CeProfesorpornivel', 'ppnn')
                        ->Where('ppnn.nivelid in (' . $nivelid . ') AND ppnn.cicloid = ' . $filtros['cicloid'])
                        ->getDQL()
                )
            )
            ->groupBy('p.profesorid')
            ->orderBy('p.apellidopaterno', 'DESC');

        return $result->getQuery()->getResult();
    }

    public function ObtenerReprobadorPorProfesor($filtros)
    {
        $conn = $this->em->getConnection();
		$filtro = " ";
		
        if ($filtros['cicloid']) {
            $filtro = $filtro . " c.CicloId =" . $filtros['cicloid'];
        }

        if ($filtros['nivelid']) {
            $filtro = $filtro .  " AND g.NivelId = ". $filtros['nivelid'];
		}

		$stmt = $conn->prepare("SELECT 
        cp1.profesorid,
        cp.Descripcion AS 'periodo',
        m.Nombre AS 'Materia',
       CONCAT_WS(' ', cp1.ApellidoPaterno, cp1.ApellidoMaterno, cp1.Nombre) AS 'NOMBRE DEL PROFESOR',
       g.Grado,
       (
         SELECT SUM(CASE WHEN cc1.Calificacion < cp3.PuntoPase THEN 1 ELSE 0 end) FROM ce_calificacionperiodoporalumno cc1
           INNER JOIN ce_alumno a ON a.AlumnoId = cc1.AlumnoId
           INNER JOIN ce_materiaporplanestudios cm2 ON cc1.MateriaPorPlanEstudioId = cm2.MateriaPorPlanEstudioId
           INNER JOIN ce_planestudios cp3 ON cm2.PlanEstudioId = cp3.PlanEstudioId
           WHERE FIND_IN_SET(cc1.ProfesorPorMateriaPlanEstudioId, GROUP_CONCAT(DISTINCT cc.ProfesorPorMateriaPlanEstudioId)) AND cc1.PeriodoEvaluacionId = cp.PeriodoEvaluacionId AND a.AlumnoEstatusId = 1
       ) AS 'No. ALS. REP.',
         (
         SELECT SUM(CASE WHEN cc1.Calificacion < cp3.PuntoPase THEN 1 ELSE 0 end) FROM ce_calificacionperiodoporalumno cc1
           INNER JOIN ce_alumno a ON a.AlumnoId = cc1.AlumnoId
           INNER JOIN ce_materiaporplanestudios cm2 ON cc1.MateriaPorPlanEstudioId = cm2.MateriaPorPlanEstudioId
           INNER JOIN ce_planestudios cp3 ON cm2.PlanEstudioId = cp3.PlanEstudioId
           WHERE FIND_IN_SET(cc1.ProfesorPorMateriaPlanEstudioId, GROUP_CONCAT(DISTINCT cc.ProfesorPorMateriaPlanEstudioId)) AND cc1.PeriodoEvaluacionId = cp.PeriodoEvaluacionId AND a.AlumnoEstatusId = 1
       ) AS reprobados,
       '' AS 'AUSENCIAS DEL MTRO.',
       '' AS 'ENTREGA PLANEACIONES SI O NO'
       FROM ce_profesorpormateriaplanestudios pmpe
       INNER JOIN ce_calificacionperiodoporalumno cc ON cc.ProfesorPorMateriaPlanEstudioId = pmpe.ProfesorPorMateriaPlanEstudiosId
       INNER JOIN ce_materiaporplanestudios cmpe ON cc.MateriaPorPlanEstudioId = cmpe.MateriaPorPlanEstudioId
        INNER JOIN ce_planestudios ccp3 ON cmpe.PlanEstudioId = ccp3.PlanEstudioId
       INNER JOIN ce_periodoevaluacion cp ON cp.PeriodoEvaluacionId = cc.PeriodoEvaluacionId
       INNER JOIN ce_profesor cp1 ON cp1.ProfesorId = pmpe.ProfesorId
       INNER JOIN ce_alumnoporciclo ac ON ac.AlumnoPorCicloId = cc.AlumnoPorCicloId
       INNER JOIN ce_alumno a ON a.AlumnoId = ac.AlumnoId
       LEFT JOIN ce_materiaporplanestudios mpe ON mpe.MateriaPorPlanEstudioId = cc.MateriaPorPlanEstudioId
       LEFT JOIN materia m ON m.MateriaId = mpe.MateriaId
       LEFT JOIN ce_grupo cg ON cg.GrupoId = pmpe.GrupoId
       LEFT JOIN ce_tallercurricular ct ON ct.TallerCurricularId = pmpe.TallerId
       LEFT JOIN ce_gradoportallercurricular cg1 ON cg1.TallerCurricularId = ct.TallerCurricularId
       LEFT JOIN ciclo c ON c.CicloId = cg.CicloId OR c.CicloId = ct.CicloId
       LEFT JOIN grado g ON g.GradoId = cg.GradoId OR g.GradoId = cg1.GradoId
       LEFT JOIN ce_planestudios cp2  ON cp2.PlanEstudioId = mpe.PlanEstudioId AND cp2.GradoId = g.GradoId
       WHERE  $filtro
       GROUP BY cp.PeriodoEvaluacionId, cp1.ProfesorId, m.MateriaId
        HAVING reprobados > 0
       ORDER BY g.GradoId, m.Nombre, CONCAT_WS(' ', cp1.ApellidoPaterno, cp1.ApellidoMaterno, cp1.Nombre) " );

        $stmt->execute();
        return $stmt->fetchAll();
    }

}
