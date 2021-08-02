<?php

namespace AppBundle\DB\Mysql\Reportes;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Metas
 *
 * @author David
 */
class MetasInscripcionDB extends BaseDBManager
{

    public function buscarMetasInscripcionGrado($filtros)
    {
        $conn = $this->em->getConnection();
        $stmt=$conn->prepare(
            "SELECT
            concat_ws(' ', n.nombre, g.grado) as nivelgrado,
            cmi.meta,
            (SELECT COUNT(*) FROM ce_alumnoporciclo ac2 
              INNER JOIN ce_alumno a2 ON a2.AlumnoId = ac2.AlumnoId
              WHERE ac2.CicloId = actu.CicloId AND ac2.GradoId = CASE WHEN cmi.GradoId = 19 THEN 0 when cmi.gradoid = 1 then 19 else cmi.gradoid - 1 end AND ac2.EstatusAlumnoCicloId in (1,2)
            ) AS alumnosactuales,
          
            (cmi.meta - (SELECT COUNT(*) FROM ce_alumnoporciclo ac2 
              INNER JOIN ce_alumno a2 ON a2.AlumnoId = ac2.AlumnoId
              WHERE ac2.CicloId = actu.CicloId AND ac2.GradoId =  CASE WHEN cmi.GradoId = 19 THEN 0 when cmi.gradoid = 1 then 19 else cmi.gradoid - 1 end AND ac2.EstatusAlumnoCicloId in (1,2)
            )) AS lugaresfaltantes,
            
            (SELECT SUM(CASE WHEN s2.EstatusSolicitudId IN(3,4,5,6,8) THEN 1 ELSE 0 end)
              FROM solicitudadmision s2 
              INNER JOIN solicitudadmisionporciclo s3 ON s3.SolicitudAdmisionId = s2.SolicitudAdmisionId AND s3.CicloId = :ciclodestinoid
              INNER JOIN grado g4 ON g4.GradoId = s2.GradoId
              WHERE g4.GradoId = cmi.gradoid
              GROUP BY g4.GradoId
            ) AS inscritosexamen,

            (SELECT SUM(CASE WHEN s2.EstatusSolicitudId IN(5,6,8) THEN 1 ELSE 0 end)
              FROM solicitudadmision s2 
              INNER JOIN solicitudadmisionporciclo s3 ON s3.SolicitudAdmisionId = s2.SolicitudAdmisionId AND s3.CicloId = :ciclodestinoid
              INNER JOIN grado g4 ON g4.GradoId = s2.GradoId
              WHERE g4.GradoId = cmi.GradoId
              GROUP BY g4.GradoId
            ) AS aceptados,

            (SELECT SUM(CASE WHEN s2.EstatusSolicitudId = 8 THEN 1 ELSE 0 end)
              FROM solicitudadmision s2 
              INNER JOIN solicitudadmisionporciclo s3 ON s3.SolicitudAdmisionId = s2.SolicitudAdmisionId AND s3.CicloId = :ciclodestinoid
              INNER JOIN grado g4 ON g4.GradoId = s2.GradoId
              WHERE g4.GradoId = cmi.GradoId
              GROUP BY g4.GradoId
            ) AS completadas,
          
            (SELECT COUNT(*) FROM 
            (
              SELECT cd.DocumentoPorPagarId,cd.CicloId, cd.GradoId FROM cj_documentoporpagar cd 
                INNER JOIN cj_documento doc ON doc.DocumentoId = cd.DocumentoId
                INNER JOIN grado g ON g.GradoId = cd.GradoId
                INNER JOIN ce_alumnoporciclo ac 
                   ON ac.AlumnoId = cd.AlumnoId and ac.EstatusAlumnoCicloId in (1) and ac.CicloId = cd.CicloId
                WHERE  cd.Documento REGEXP '....00.*' AND doc.TipoDocumento = 1
                AND cd.AlumnoId IS NOT null
                GROUP BY cd.alumnoid, cd.solicitudadmisionid, cd.cicloid, cd.documento
                HAVING SUM(cd.Importe) <> SUM(cd.Saldo)
            ) z WHERE z.CicloId = next.CicloId AND z.GradoId = cmi.gradoid) AS nuevoingreso,
          
            (SELECT COUNT(*) FROM ce_alumnoporciclo ac2 
              INNER JOIN ce_alumno a2 ON a2.AlumnoId = ac2.AlumnoId
              WHERE ac2.CicloId = next.cicloid AND ac2.GradoId = cmi.GradoId
              AND ac2.IntencionReinscribirseId = 1
            ) AS intencionreinscribirse,
            
            (SELECT COUNT(z.AlumnoId) FROM 
            (
            SELECT aa.AlumnoId, dp2.CicloId, dp2.GradoId FROM ce_alumno aa
            INNER JOIN (SELECT COUNT(dp.alumnoid) AS numero_colegiaturas,
                dp.alumnoid, SUM(dp.Saldo) AS adeudo_vencido_colegiaturas,
              dp.CicloId, dp.GradoId
              FROM cj_documentoporpagar dp
                INNER JOIN cj_documento d
                  ON d.documentoid = dp.documentoid
                INNER JOIN cj_tipodocumento td
                  ON td.tipodocumentoid = d.tipodocumento
                  AND td.tipodocumentoid = 2
              WHERE dp.FechaLimitePago < NOW()
              AND dp.saldo > 0
              AND dp.alumnoid IS NOT NULL
              GROUP BY dp.alumnoid) AS dp2
              ON dp2.alumnoid = aa.alumnoid
              AND dp2.numero_colegiaturas >= (SELECT p.Valor FROM parametros p WHERE p.Nombre = 'NumeroAdeudoColegiatura')
            )z WHERE z.CicloId = actu.CicloId AND z.GradoId =  CASE WHEN cmi.GradoId = 19 THEN 0 when cmi.gradoid = 1 then 19 else cmi.gradoid - 1 end) AS colegiaturasvencidas,
          
              (SELECT COUNT(*) FROM 
            (
              SELECT cd.DocumentoPorPagarId,cd.CicloId, cd.GradoId FROM cj_documentoporpagar cd 
                INNER JOIN cj_documento doc ON doc.DocumentoId = cd.DocumentoId
                INNER JOIN grado g ON g.GradoId = cd.GradoId
                INNER JOIN ( SELECT * FROM ce_alumnoporciclo WHERE EstatusAlumnoCicloId = 2 AND cicloid = :ciclodestinoid Group by AlumnoId ) AS ac ON ac.AlumnoId = cd.AlumnoId
                WHERE  cd.Documento REGEXP '....00.*' AND doc.TipoDocumento = 1 AND cd.AlumnoId IS NOT NULL
                GROUP BY cd.alumnoid, cd.solicitudadmisionid, cd.cicloid, cd.documento
                HAVING SUM(cd.Importe) <> SUM(cd.Saldo)
            ) z WHERE z.CicloId = next.CicloId AND z.GradoId =  cmi.GradoId ) AS reinscripciones
          
          
            FROM ce_configuracionmetasinscripcion cmi
            LEFT JOIN grado g ON g.GradoId = cmi.GradoId
            LEFT JOIN nivel n ON n.NivelId = g.NivelId
            LEFT JOIN solicitudadmision s ON s.GradoId = cmi.GradoId
            LEFT JOIN solicitudadmisionporciclo s1 ON s1.SolicitudAdmisionId = s.SolicitudAdmisionId AND s1.CicloId = :ciclodestinoid
            JOIN ciclo next ON next.CicloId = :ciclodestinoid
            JOIN ciclo actu ON actu.CicloId = :cicloactualid
            WHERE g.NivelId = :nivelid AND  cmi.CicloId = :ciclodestinoid AND IF(:gradoid > 0, g.GradoId = :gradoid, true)
            GROUP BY g.GradoId;");
        $stmt->execute(array(':nivelid' => $filtros['nivelid'], ':gradoid' => $filtros['gradoid'], 'cicloactualid' => $filtros['cicloactualid'], 'ciclodestinoid' => $filtros['ciclodestinoid']));
        return $stmt->fetchAll();
    }

    public function buscarMetasInscripcionNivel($filtros)
    {
        $conn = $this->em->getConnection();
        $stmt=$conn->prepare(
            "SELECT
            n.nombre AS nivelgrado,
            (SELECT SUM(cmi2.meta) FROM ce_configuracionmetasinscripcion cmi2
              LEFT JOIN grado g2 ON g2.GradoId = cmi2.GradoId
              LEFT JOIN nivel n2 ON n2.NivelId = g2.NivelId
              WHERE cmi2.CicloId = cmi.CicloId AND g2.NivelId = g.NivelId
              GROUP BY g2.NivelId) AS meta,
          
             (SELECT COUNT(DISTINCT a2.AlumnoId) FROM ce_alumnoporciclo ac2 
              INNER JOIN ce_alumno a2 ON a2.AlumnoId = ac2.AlumnoId
               INNER JOIN grado g ON ac2.GradoId = g.GradoId

              INNER JOIN grado g2 ON g2.GradoId = (CASE WHEN ac2.GradoId = 19 THEN 1 when ac2.gradoid = 18 then 0 else ac2.gradoid + 1 END)
              WHERE ac2.CicloId = actu.Cicloid AND g2.Nivelid = n.nivelid AND ac2.EstatusAlumnoCicloId in (1,2) AND if(g2.NivelId = 4, g2.gradoid in (13,14,15,16), true)  AND a2.AlumnoEstatusId = 1
              GROUP BY g2.NivelId
              ) AS alumnosactuales,
          
              (  (SELECT SUM(cmi2.meta) FROM ce_configuracionmetasinscripcion cmi2
              LEFT JOIN grado g2 ON g2.GradoId = cmi2.GradoId
              LEFT JOIN nivel n2 ON n2.NivelId = g2.NivelId
              WHERE cmi2.CicloId = cmi.CicloId AND g2.NivelId = g.NivelId
              GROUP BY g2.NivelId) - (SELECT COUNT(DISTINCT a2.AlumnoId) FROM ce_alumnoporciclo ac2 
              INNER JOIN ce_alumno a2 ON a2.AlumnoId = ac2.AlumnoId
               INNER JOIN grado g ON ac2.GradoId = g.GradoId

              INNER JOIN grado g2 ON g2.GradoId = (CASE WHEN ac2.GradoId = 19 THEN 1 when ac2.gradoid = 18 then 0 else ac2.gradoid + 1 END)
              WHERE ac2.CicloId = actu.Cicloid AND g2.Nivelid = n.nivelid AND ac2.EstatusAlumnoCicloId in (1,2) AND if(g2.NivelId = 4, g2.gradoid in (13,14,15,16), true)  AND a2.AlumnoEstatusId = 1
              GROUP BY g2.NivelId
              )) AS lugaresfaltantes,
          
            (SELECT SUM(CASE WHEN s2.EstatusSolicitudId IN(3,4,5,6,8) THEN 1 ELSE 0 end) 
              FROM solicitudadmision s2 
              INNER JOIN solicitudadmisionporciclo s3 ON s3.SolicitudAdmisionId = s2.SolicitudAdmisionId AND s3.CicloId = :ciclodestinoid
              INNER JOIN grado g4 ON g4.GradoId = s2.GradoId
              WHERE g4.NivelId = n.NivelId
              GROUP BY g4.NivelId) AS inscritosexamen,
          
              (SELECT SUM(CASE WHEN s2.EstatusSolicitudId IN(5,6,8) THEN 1 ELSE 0 end) 
              FROM solicitudadmision s2 
              INNER JOIN solicitudadmisionporciclo s3 ON s3.SolicitudAdmisionId = s2.SolicitudAdmisionId AND s3.CicloId = :ciclodestinoid
              INNER JOIN grado g4 ON g4.GradoId = s2.GradoId
              WHERE g4.NivelId = n.NivelId
              GROUP BY g4.NivelId) AS aceptados,
          
              (SELECT SUM(CASE WHEN s2.EstatusSolicitudId = 8 THEN 1 ELSE 0 end) 
              FROM solicitudadmision s2 
              INNER JOIN solicitudadmisionporciclo s3 ON s3.SolicitudAdmisionId = s2.SolicitudAdmisionId AND s3.CicloId = :ciclodestinoid
              INNER JOIN grado g4 ON g4.GradoId = s2.GradoId
              WHERE g4.NivelId = n.NivelId
              GROUP BY g4.NivelId) AS completadas,
          
              (SELECT COUNT(*) FROM 
              (
                 SELECT cd.DocumentoPorPagarId,cd.CicloId, g.NivelId FROM cj_documentoporpagar cd 
                  INNER JOIN cj_documento doc ON doc.DocumentoId = cd.DocumentoId
                  INNER JOIN grado g ON g.GradoId = cd.GradoId
                  INNER JOIN ce_alumnoporciclo ac 
                      ON ac.AlumnoId = cd.AlumnoId and ac.EstatusAlumnoCicloId in (1) and ac.CicloId = cd.CicloId
                  WHERE  cd.Documento REGEXP '....00.*' AND doc.TipoDocumento = 1 AND cd.AlumnoId IS NOT null
                  GROUP BY cd.alumnoid, cd.solicitudadmisionid, cd.cicloid, cd.documento
                  HAVING SUM(cd.Importe) <> SUM(cd.Saldo)
              ) z WHERE z.CicloId = next.CicloId AND z.NivelId = n.NivelId) AS nuevoingreso,
          
              (SELECT COUNT(*) FROM ce_alumnoporciclo ac2 
                INNER JOIN ce_alumno a2 ON a2.AlumnoId = ac2.AlumnoId
                INNER JOIN grado g2 ON g2.GradoId = ac2.GradoId
                WHERE ac2.CicloId = next.cicloid AND g2.NivelId = n.NivelId AND ac2.IntencionReinscribirseId = 1
              ) AS intencionreinscribirse,
          
              (SELECT COUNT(z.AlumnoId) FROM 
              (
                SELECT aa.AlumnoId, dp2.CicloId, dp2.NivelId FROM ce_alumno aa
                INNER JOIN (SELECT COUNT(dp.alumnoid) AS numero_colegiaturas,
                    dp.alumnoid, SUM(dp.Saldo) AS adeudo_vencido_colegiaturas,
                  dp.CicloId, g2.NivelId
                  FROM cj_documentoporpagar dp
                    INNER JOIN cj_documento d
                      ON d.documentoid = dp.documentoid
                    INNER JOIN cj_tipodocumento td
                      ON td.tipodocumentoid = d.tipodocumento
                    INNER JOIN grado g2
                      ON g2.GradoId = (CASE WHEN dp.GradoId = 19 THEN 1 when dp.gradoid = 18 then 0 else dp.gradoid + 1 END)
                      AND td.tipodocumentoid = 2
                  WHERE dp.FechaLimitePago < NOW()
                  AND dp.saldo > 0
                  AND dp.alumnoid IS NOT NULL
                  GROUP BY dp.alumnoid) AS dp2
                  ON dp2.alumnoid = aa.alumnoid
                  AND dp2.numero_colegiaturas >= (SELECT p.Valor FROM parametros p WHERE p.Nombre = 'NumeroAdeudoColegiatura')
              )z WHERE z.CicloId = actu.CicloId AND z.NivelId = n.NivelId) AS colegiaturasvencidas,
          
                (SELECT COUNT(*) FROM 
                  (
                    SELECT cd.DocumentoPorPagarId,cd.CicloId, g.NivelId FROM cj_documentoporpagar cd 
                      INNER JOIN cj_documento doc ON doc.DocumentoId = cd.DocumentoId                      
                      /*INNER JOIN grado g2 ON g2.GradoId = (CASE WHEN cd.GradoId = 19 THEN 1 when cd.gradoid = 18 then 0 else cd.gradoid + 1 END) */
                      INNER JOIN ( SELECT * FROM ce_alumnoporciclo WHERE EstatusAlumnoCicloId = 2 AND cicloid = :ciclodestinoid GROUP BY  AlumnoId ) AS ac ON ac.AlumnoId = cd.AlumnoId
                      INNER JOIN grado g ON g.GradoId = ac.GradoId
                      WHERE  cd.Documento REGEXP '....00.*' AND doc.TipoDocumento = 1 AND cd.AlumnoId IS NOT NULL
                      GROUP BY cd.alumnoid, cd.solicitudadmisionid, cd.cicloid, cd.documento
                      HAVING SUM(cd.Importe) <> SUM(cd.Saldo)
                  ) z WHERE z.CicloId = next.CicloId AND z.NivelId = n.NivelId) AS reinscripciones,
          
                (SELECT COUNT(*) FROM 
            (
              SELECT cd.DocumentoPorPagarId,cd.CicloId, g2.NivelId FROM cj_documentoporpagar cd 
                INNER JOIN cj_documento doc ON doc.DocumentoId = cd.DocumentoId
                INNER JOIN grado g ON g.GradoId = cd.GradoId
                 INNER JOIN grado g2 ON g2.GradoId = (CASE WHEN cd.GradoId = 19 THEN 1 when cd.gradoid = 18 then 0 else cd.gradoid + 1 END)
                left JOIN nivel n3 ON n3.NivelId = g.GradoId
                WHERE  cd.Documento REGEXP '....00.*' AND doc.TipoDocumento = 1 
                GROUP BY cd.alumnoid, cd.solicitudadmisionid, cd.cicloid, cd.documento
                HAVING SUM(cd.Importe) <> SUM(cd.Saldo)
            ) z WHERE z.CicloId = next.CicloId AND z.NivelId = n.NivelId) AS totalinscrito,
          
              (  (SELECT SUM(cmi2.meta) FROM ce_configuracionmetasinscripcion cmi2
              LEFT JOIN grado g2 ON g2.GradoId = cmi2.GradoId
              LEFT JOIN nivel n2 ON n2.NivelId = g2.NivelId
              WHERE cmi2.CicloId = cmi.CicloId AND g2.NivelId = g.NivelId
              GROUP BY g2.NivelId) - (SELECT COUNT(*) FROM 
            (
              SELECT cd.DocumentoPorPagarId,cd.CicloId, cd.GradoId, n2.NivelId FROM cj_documentoporpagar cd 
                INNER JOIN cj_documento doc ON doc.DocumentoId = cd.DocumentoId
                INNER JOIN grado g ON g.GradoId = cd.GradoId
                INNER JOIN grado g2 ON g2.GradoId = (CASE WHEN cd.GradoId = 19 THEN 1 when cd.gradoid = 18 then 0 else cd.gradoid + 1 END)
                INNER JOIN nivel n2 ON n2.NivelId = g2.NivelId
                WHERE  cd.Documento REGEXP '....00.*' AND doc.TipoDocumento = 1 
                GROUP BY cd.alumnoid, cd.solicitudadmisionid, cd.cicloid, cd.documento
                HAVING SUM(cd.Importe) <> SUM(cd.Saldo)
            ) z WHERE z.CicloId = next.CicloId AND z.NivelId = n.NivelId)) AS alumnosrestantes
          
            FROM ce_configuracionmetasinscripcion cmi
            LEFT JOIN grado g ON g.GradoId = cmi.GradoId
            LEFT JOIN nivel n ON n.NivelId = g.NivelId
            LEFT JOIN solicitudadmisionporciclo s1 ON s1.CicloId = :ciclodestinoid
            LEFT JOIN solicitudadmision s ON s.SolicitudAdmisionId = s1.SolicitudAdmisionId
            LEFT JOIN grado gs ON gs.GradoId = s.GradoId AND gs.NivelId = n.NivelId
            JOIN ciclo next ON next.CicloId = :ciclodestinoid
            JOIN ciclo actu ON actu.CicloId = :cicloactualid
            WHERE cmi.CicloId = :ciclodestinoid
            GROUP BY n.NivelId
            ORDER BY n.NivelId;
          ");
        $stmt->execute(array('cicloactualid' => $filtros['cicloactualid'], 'ciclodestinoid' => $filtros['ciclodestinoid']));
        return $stmt->fetchAll();
    }
}
