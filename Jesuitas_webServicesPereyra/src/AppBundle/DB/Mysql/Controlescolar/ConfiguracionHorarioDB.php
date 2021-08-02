<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Horarios
 *
 * @author David
 */
class ConfiguracionHorarioDB extends BaseDBManager {

    public function BuscarHorarios($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ch.configuracionhorarioid, c.cicloid, g.gradoid, ch.orden,
        ch.nombre, DATE_FORMAT(ch.horainicio, '%H:%i') as horainicio, DATE_FORMAT(ch.horafin, '%H:%i') as horafin, ch.esclase")
        ->from("AppBundle:CeConfiguracionhorario", 'ch')
        ->innerJoin('ch.cicloid', 'c')
        ->innerJoin("ch.gradoid", 'g'); 
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid = :cicloid')
        	->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid = :gradoid')
        	->setParameter('gradoid', $filtros['gradoid']);
        }
        $result->groupBy("ch.orden");
        $result->orderBy("ch.orden");
        return $result->getQuery()->getResult();
    }

    public function loadMateriaHorario($filtros) {
        $conn = $this->em->getConnection();
		$filtro = " ";
		
        if ($filtros['grupoid']) {
            $filtro = $filtro . "cm.GrupoId = " . $filtros['grupoid'];
        }

        if ($filtros['dia']) {
            $filtro = $filtro .  " AND cm.Dia = ". $filtros['dia'];
		}

		if ($filtros['configuracionhorarioid']) {
            $filtro = $filtro .  " AND cm.ConfiguracionHorarioId = ". $filtros['configuracionhorarioid'];
		}

		$stmt = $conn->prepare("SELECT
        cm.materiaporhorarioid, 
        cm.configuracionhorarioid configuracionhorarioid, 
        cp.profesorpormateriaplanestudiosid,
        cm.dia, 
        cm.salon,
        CASE WHEN m.MateriaId IS NULL THEN mt.Nombre ELSE m.Nombre END AS materia,
        CASE WHEN mpe1.MateriaPorPlanEstudioId IS NOT NULL THEN mpe1.MateriaPorPlanEstudioId ELSE cm1.MateriaPorPlanEstudioId END AS materiaporplanestudioid,
        CONCAT_WS(' ', p.ApellidoPaterno, p.ApellidoMaterno, p.Nombre) AS profesor,
        CASE WHEN (mpe1.ConfigurarSubgrupos OR mpe1.ConfigurarTaller) = TRUE THEN 1 ELSE 0 END AS extended,
        CASE WHEN mpe1.ConfigurarSubgrupos = true THEN 'SUBGRUPO' WHEN mpe1.ConfigurarTaller = true THEN 'TALLER' END AS tipo
        FROM ce_materiaporhorario cm
        LEFT JOIN ce_profesorpormateriaplanestudios cp ON cp.ProfesorPorMateriaPlanEstudiosId = cm.ProfesorPorMateriaPlanEstudiosId
        LEFT JOIN ce_profesor p ON p.ProfesorId = cp.ProfesorId
        LEFT JOIN ce_materiaporplanestudios cm1 ON cm1.MateriaPorPlanEstudioId = cp.MateriaPorPlanEstudioId
        LEFT JOIN ce_materiahorarioporsubgrupotaller mtst ON mtst.MateriaPorHorarioId = cm.MateriaPorHorarioId
        LEFT JOIN ce_profesorpormateriaplanestudios pmpe ON pmpe.ProfesorPorMateriaPlanEstudiosId = mtst.ProfesorPorMateriaPlanEstudiosId
        LEFT JOIN ce_gradoportallercurricular cg ON cg.TallerCurricularId = pmpe.TallerId
        LEFT JOIN ce_materiaporplanestudios mpe1 ON mpe1.MateriaPorPlanEstudioId = cg.MateriaPorPlanEstudioId OR mpe1.MateriaPorPlanEstudioId = pmpe.MateriaPorPlanEstudioId
        LEFT JOIN materia m ON m.MateriaId = cm1.MateriaId
        LEFT JOIN materia mt ON mt.MateriaId = mpe1.MateriaId
        WHERE $filtro
        GROUP BY cm.MateriaPorHorarioId;");

        $stmt->execute();
        return $stmt->fetchAll();
    }
    

    public function loadSubgruposTalleresByMateriaHorario($id) {
        $conn = $this->em->getConnection();

		$stmt = $conn->prepare("SELECT  
        mtst.MateriaHorarioSubgrupoTallerId,
        mtst.MateriaPorHorarioId,
        CASE WHEN ct.Nombre IS NOT NULL THEN ct.Nombre ELSE cg.Nombre END AS nombre,
        CONCAT_WS(' ', p.ApellidoPaterno, p.ApellidoMaterno, p.Nombre) AS profesor,
        CONCAT_WS(' ', s.ApellidoPaterno, s.ApellidoMaterno, s.Nombre) AS cotitular,
        CONCAT_WS(' ', c.ApellidoPaterno, c.ApellidoMaterno, c.Nombre) AS suplente,
        mtst.Salon as salon,
        pmpe.ProfesorPorMateriaPlanEstudiosId as profesorpormateriaplanestudiosid
        FROM ce_materiahorarioporsubgrupotaller mtst
        INNER JOIN ce_profesorpormateriaplanestudios pmpe ON pmpe.ProfesorPorMateriaPlanEstudiosId = mtst.ProfesorPorMateriaPlanEstudiosId
        INNER JOIN ce_profesor p ON p.ProfesorId = pmpe.ProfesorId
        LEFT JOIN ce_profesor c ON c.ProfesorId = pmpe.CoTitularId
        LEFT JOIN ce_profesor s ON s.ProfesorId = pmpe.SuplenteId
        LEFT JOIN ce_grupo cg ON cg.GrupoId = pmpe.GrupoId
        LEFT JOIN ce_tallercurricular ct ON ct.TallerCurricularId = pmpe.TallerId
        WHERE mtst.MateriaPorHorarioId = $id");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFaltasByHorario($filtros) {
        /*$conn = $this->em->getConnection();

		$stmt = $conn->prepare("SELECT ca.* FROM ce_asistencia ca 
        WHERE ca.ProfesorPorMateriaPlanEstudioId = " . $filtros['profesorpormateriaplanestudioid'] ."
          AND ca.TipoAsistenciaId IN(3,2) 
          AND ca.Hora BETWEEN '" . $filtros['horainicio'] . "' AND '" . $filtros['horafin'] . "'
          AND DAYOFWEEK(ca.Fecha) = " . $filtros['dia']);

        $stmt->execute();
        return $stmt->fetchAll();*/

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a")
        ->from("AppBundle:CeAsistencia", 'a')
        ->Where('a.profesorpormateriaplanestudioid = :profesormat')
        ->andWhere('a.hora BETWEEN :horainicio and :horafin')
        ->andWhere('DAYOFWEEK(a.fecha) = :dia')
        ->setParameter('profesormat', $filtros['profesorpormateriaplanestudioid'])
        ->setParameter('horainicio', $filtros['horainicio'])
        ->setParameter('horafin', $filtros['horafin'])
        ->setParameter('dia', $filtros['dia']);

        return $result->getQuery()->getResult();
    }

}
