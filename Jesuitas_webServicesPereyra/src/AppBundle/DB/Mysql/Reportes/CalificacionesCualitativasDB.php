<?php

namespace AppBundle\DB\Mysql\Reportes;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Calificaciones Cualitativas
 *
 * @author David
 */
class CalificacionesCualitativasDB extends BaseDBManager
{

    public function buscarMetasInscripcionGrado($filtros)
    {
        $conn = $this->em->getConnection();
        $stmt=$conn->prepare("SELECT 	ca.Matricula AS Matricula, 
		CONCAT_WS(' ', ca.ApellidoPaterno, ca.ApellidoMaterno, ca.PrimerNombre, ca.SegundoNombre) AS Nombre, 
        g.Grado AS Grado, 
        cg.Nombre AS Grupo, 
        pe.descripcion as periodoevaluacion,
        pe.periodoevaluacionid,
        ca1.alumnoporcicloid,
        cc.profesorpormateriaplanestudioid,
        ca2.NumeroLista AS 'Num', 
		IF(m.MateriaPadreId IS NULL, m.Nombre, CONCAT(mp.Nombre, ' - ', m.Nombre)) AS 'Asig', 
        IF(cp.Opcion IS NULL, '', cp.Opcion) AS 'Cal', 
        IF(cc.Observacion IS NULL, '', cc.Observacion) AS Observaciones
        FROM
                        ce_calificacionperiodoporalumno	cc
        INNER JOIN	ce_alumnoporciclo 				ca1 ON cc.AlumnoPorCicloId = ca1.AlumnoPorCicloId
        INNER JOIN	ce_alumnocicloporgrupo 			ca2 ON ca1.AlumnoPorCicloId = ca2.AlumnoPorCicloId
        INNER JOIN	ce_grupo 						cg ON ca2.GrupoId = cg.GrupoId AND cg.TipoGrupoId = 1
        INNER JOIN	ce_alumno 						ca ON ca1.AlumnoId = ca.AlumnoId
        INNER JOIN	ce_materiaporplanestudios		mpe ON mpe.materiaporplanestudioid = cc.materiaporplanestudioid
        INNER JOIN	ce_planestudios		pm ON mpe.planestudioid = pm.planestudioid
        INNER JOIN  ce_periodoevaluacion  pe ON pe.PeriodoEvaluacionId = cc.PeriodoEvaluacionId
        INNER JOIN	grado 							g ON ca1.GradoId = g.GradoId
        INNER JOIN	nivel 							n ON g.NivelId = n.NivelId
        LEFT JOIN		ce_ponderacionopcion 			cp ON cc.PonderacionOpcionId = cp.PonderacionOpcionId
        INNER JOIN 	materia 						m 	ON cc.MateriaId = m.MateriaId
        LEFT JOIN 	materia 						mp 	ON m.MateriaPadreId = mp.MateriaId
        WHERE 
            ca1.CicloId = :cicloid  
        AND	g.NivelId = :nivelid 
        AND IF(:gradoid > 0, g.GradoId = :gradoid, true)
        AND IF(:grupoid > 0, cg.GrupoId = :grupoid, true)
        AND IF(:matricula > 0, ca.Matricula = :matricula, true)
        AND IF(:periodoevaluacionid > 0, pe.periodoevaluacionid = :periodoevaluacionid, true)
        AND IF(:materiaporplanestudioid > 0, mpe.materiaporplanestudioid = :materiaporplanestudioid, true)
        AND IF(:matricula > 0, ca.matricula = :matricula, true)
        AND IF(:planestudioid > 0, pm.planestudioid = :planestudioid, true)

ORDER BY
		g.Grado, 
        Grupo, 
        ca2.NumeroLista, 
        pe.periodoevaluacionid,
        ca.Matricula, 
        IF(m.MateriaPadreId IS NULL, 
        m.Nombre, 
        CONCAT(mp.Nombre, ' - ', m.Nombre));");
        $stmt->execute(array('planestudioid' => $filtros['planestudioid'], 'matricula' => $filtros['matricula'], 'materiaporplanestudioid' => $filtros['materiaporplanestudioid'], 'periodoevaluacionid' => $filtros['periodoevaluacionid'], ':cicloid' => $filtros['cicloid'], ':nivelid' => $filtros['nivelid'], ':gradoid' => $filtros['gradoid'], "grupoid" => $filtros['grupoid'], "matricula" => $filtros['matricula'] ));
        return $stmt->fetchAll();
    }
}