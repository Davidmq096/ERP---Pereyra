<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql\Cobranza;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Descripción of PagoInscripcionDB
 *
 * @author inceptio
 */
class PagoInscripcionDB extends BaseDBManager
{
	public function BuscarPagoinscripcion($filtros)
	{
		$conn = $this->em->getConnection();
        $stmt = $conn->prepare("SELECT    SIG.gradoid,
                               COUNT(DISTINCT CASE WHEN AXC.EstatusAlumnoCicloId = 2 AND ALU.Sexo = 'M' THEN AXC.AlumnoId END) AS alumnosreingresohombres,
                               COUNT(DISTINCT CASE WHEN AXC.EstatusAlumnoCicloId = 2 AND ALU.Sexo = 'F' THEN AXC.AlumnoId END) AS alumnosreingresomujeres,
                               COUNT(DISTINCT CASE WHEN AXC.EstatusAlumnoCicloId = 1 AND ALU.Sexo = 'M' THEN AXC.AlumnoId END) AS alumnosnuevoingresohombres,
                               COUNT(DISTINCT CASE WHEN AXC.EstatusAlumnoCicloId = 1 AND ALU.Sexo = 'F' THEN AXC.AlumnoId END) AS alumnosnuevoingresomujeres,
                               COUNT(DISTINCT CASE WHEN ALU.Sexo = 'M' THEN ALU.AlumnoId END) AS alumnostotalhombresporgrado,
                               COUNT(DISTINCT CASE WHEN ALU.Sexo = 'F' THEN ALU.AlumnoId END) AS alumnostotalmujeresporgrado,
                               COUNT(DISTINCT AXC.AlumnoId) AS alumnostotalporgrado
                               FROM
                               (    SELECT         DXP.AlumnoId
                                FROM         cj_documentoporpagar    DXP
                                INNER JOIN     cj_documento             DOC on DXP.DocumentoId = DOC.DocumentoId
                                LEFT JOIN    cj_pagodetalle            PDE on DXP.DocumentoPorPagarId = PDE.DocumentoPorPagarId
                                LEFT JOIN    cj_pago                    PAG on PDE.PagoId = PAG.PagoId and PAG.PagoEstatusId <> 3
                                WHERE            DOC.TipoDocumento = 1
                                AND DXP.CicloId = :cicloid
                                AND DXP.Saldo <> DXP.Importe
                                AND    DATE(PAG.Fecha) >= :fechainicio
                                AND    DATE(PAG.Fecha) <= :fechafin
                                GROUP BY        DXP.AlumnoId
                                )                                DXP
								
                               INNER JOIN    ce_alumnociclogrado    SIG    ON    DXP.AlumnoId = SIG.AlumnoId and SIG.CicloId = :cicloid
                               INNER JOIN    ce_alumnoporciclo                AXC    ON    SIG.AlumnoId = AXC.AlumnoId AND SIG.CicloId = AXC.CicloId AND SIG.GradoId = AXC.GradoId
                               INNER JOIN    ce_alumno                        ALU    ON    SIG.AlumnoId = ALU.AlumnoId
                               INNER JOIN    grado                            GRA    ON    SIG.GradoId = GRA.GradoId
                               INNER JOIN    nivel                            NIV    ON    GRA.NivelId = NIV.NivelId
                               WHERE    AXC.CicloId = :cicloid AND		AXC.EstatusAlumnoCicloId IN (1, 2)
                               GROUP BY
                               SIG.GradoId");
		$stmt->execute(array('cicloid' => $filtros["cicloid"], 'fechainicio' => $filtros['fechainicio'], 'fechafin' => $filtros['fechafin']));
		$result = $stmt->fetchAll();
		return $result;
	}

	public function BuscarPagoinscripciondetalle($filtros)
	{
		$conn = $this->em->getConnection();
                               $sql = "SELECT NIV.Nombre Nivel, GRA.Grado,
                               DATE_FORMAT(DXP.FechaPago, '%d/%m/%Y') FechaPago,
                               ALU.Matricula,
                               CF.Clave ClaveFamiliar,
                               concat_ws(' ', ALU.ApellidoPaterno, ALU.ApellidoMaterno, ALU.PrimerNombre, ALU.SegundoNombre) Nombre,
                               DATE_FORMAT(ALU.FechaNacimiento, '%d/%m/%Y') FechaNacimiento,
                               CASE WHEN AXC.EstatusAlumnoCicloId = 1 THEN 'Nuevo ingreso' WHEN AXC.EstatusAlumnoCicloId = 2 THEN 'Reingreso' END TipoIngreso,
                               ALU.Sexo
                               FROM        (
                                            select         a.AlumnoId, MIN(d.Fecha) as FechaPago
                                            from         cj_documentoporpagar a
                                            inner join     cj_documento b on a.DocumentoId = b.DocumentoId
                                            left join    cj_pagodetalle c on a.DocumentoPorPagarId = c.DocumentoPorPagarId
                                            left join    cj_pago d on c.PagoId = d.PagoId and d.PagoEstatusId <> 3
                                            where        b.TipoDocumento = 1
                                            and a.CicloId = :cicloid
                                            and a.Saldo <> a.Importe
                                            and date(d.Fecha) between :fechainicio and :fechafin
                                            group by    a.AlumnoId
                                            )         DXP
                               LEFT JOIN    ce_alumno                    ALU    ON    DXP.AlumnoId = ALU.AlumnoId
                               LEFT JOIN   ce_alumnoporclavefamiliar    ACF ON  ALU.AlumnoId = ACF.AlumnoID
                               LEFT JOIN   ce_clavefamiliar            CF  ON  ACF.ClaveFamiliarId = CF.ClaveFamiliarId
							   LEFT JOIN	ce_alumnociclogrado 		ACG ON DXP.AlumnoId = ACG.AlumnoId and ACG.CicloId = :cicloid
                               LEFT JOIN    ce_alumnoporciclo            AXC    ON    ACG.AlumnoId = AXC.AlumnoId AND AXC.CicloId = ACG.CicloId And AXC.GradoId = ACG.GradoId
                               LEFT JOIN    grado                        GRA    ON    AXC.GradoId = GRA.GradoId
                               LEFT JOIN    nivel                        NIV    ON    GRA.NivelId = NIV.NivelId
                               LEFT JOIN    ce_estatusalumnoporciclo    EAC    ON    AXC.EstatusAlumnoCicloId = EAC.EstatusAlumnoPorCicloId
                               WHERE AXC.EstatusAlumnoCicloId IN (1, 2) ";

		if (isset($filtros['nivelid'])) {
			$nivelid = is_array($filtros['nivelid']) ? implode(",", $filtros['nivelid']) : $filtros['nivelid'];
			$sql = $sql . ' AND NIV.nivelid in  (' . $nivelid . ') ';
		}

		if (isset($filtros['gradoid'])) {
			$gradoid = is_array($filtros['gradoid']) ? implode(",", $filtros['gradoid']) : $filtros['gradoid'];
			$sql = $sql . ' AND GRA.gradoid in  (' . $gradoid . ') ';
		}
		if (isset($filtros['tipoingreso'])) {
			$sql = $sql . " AND AXC.EstatusAlumnoCicloId = " . $filtros["tipoingreso"]. " ";
		}

		if (isset($filtros['genero'])) {
			$sql = $sql . ' AND ALU.Sexo like \'%'  . $filtros["genero"]. '%\' ';
		}

		$sql = $sql . " GROUP BY ALU.AlumnoId
		ORDER BY CASE WHEN GRA.GradoId = 19 THEN 0 ELSE GRA.GradoId END,
		ALU.ApellidoPaterno, ALU.ApellidoMaterno, ALU.PrimerNombre, ALU.SegundoNombre";

		$stmt = $conn->prepare($sql);
		$stmt->execute(array('cicloid' => $filtros["cicloid"], 'fechainicio' => $filtros['fechainicio'], 'fechafin' => $filtros['fechafin']));
		$result = $stmt->fetchAll();
		return $result;
	}
}
