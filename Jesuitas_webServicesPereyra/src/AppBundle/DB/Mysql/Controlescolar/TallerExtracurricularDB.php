<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author Emmanuel Martinez
 */
class TallerExtracurricularDB extends BaseDBManager
{
	private static $PAGOESTATUS_PAGADO = 2;
	public function getBasicTallerExtracurricular()
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select("cetec.tallerextracurricularid AS id,"
				. "IDENTITY(cetec.cicloid) AS cicloid,"
				. "IDENTITY(g.nivelid) AS nivelid,"
				. "g.gradoid,"
				. "cetec.nombre,"
				. "2 AS tipo")->from("AppBundle:CeTallerextracurricular", "cetec")
				->innerJoin("AppBundle:CeGradoportallerextracurricular", "cegtec", "WITH", "cegtec.tallerextracurricularid=cetec.tallerextracurricularid")
				->innerJoin("AppBundle:Grado", "g", "WITH", "g.gradoid=cegtec.gradoid")
				->Where("cetec.activo = 1")
				->orderBy("cetec.nombre");
			return $this->buildTallerArray($qb->getQuery()->getResult());
		} catch (\Exception $e) {
		}
		return false;
	}
	public function getMaterialByTaller($tallerid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select("cemtec.materialportallerextracurricularid AS id,"
				. "cetm.nombre,"
				. "cetm.pedirtalla")->from("AppBundle:CeMaterialportallerextracurricular", "cemtec")
				->innerJoin("AppBundle:CeTallermaterial", "cetm", "WITH", "cetm.tallermaterialid=cemtec.tallermaterialid")
				->andWhere("cemtec.tallerextracurricularid=:taller")
				->andWhere("cetm.activo=1")
				->setParameter("taller", $tallerid);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
		}
		return false;
	}
	public function getPDFHeaderByTallerextracurricular($tallerextraid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select("c.nombre AS ciclo,"
				. "cete.nombre AS nombre")->from("AppBundle:CeTallerextracurricular", "cete")
				->innerJoin("AppBundle:Ciclo", "c", "WITH", "c.cicloid=cete.cicloid")
				->andWhere("cete.tallerextracurricularid=:taller")
				->setParameter("taller", $tallerextraid);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
		}
		return false;
	}
	public function getPDFAlumnoByTallerextracurricular($tallerextraid, $nivelid = null)
	{
		try {
			$param = array('taller' => $tallerextraid);
			$sql = "SELECT '' AS nolista,"
				. " cea.matricula AS matricula,"
				. " cea.apellidopaterno AS apaterno,"
				. " cea.apellidomaterno AS amaterno,"
				. " cea.primernombre AS nombre,"
				. " cea.sexo AS sexo,"
				. " cjdp.documentoporpagarid,"
				. " cjpe.pagoestatusid,"
				. " DATE_FORMAT(ceacte.fechapreregistro, '%d/%m/%Y') AS fechapreregistro,"
				. " CONVERT(SUBSTRING_INDEX(afcav.foto,';base64,',-1) USING utf8) AS photo"
				. " FROM ce_alumnocicloportallerextra ceacte"
				. " INNER JOIN ce_tallerextracurricular tex ON tex.tallerextracurricularid = ceacte.tallerextraid"
				. " INNER JOIN ce_alumnoporciclo ceac ON ceac.alumnoporcicloid=ceacte.alumnoporcicloid and ceac.cicloid = tex.cicloid"
				. " INNER JOIN ce_alumno cea ON cea.alumnoid=ceac.alumnoid and cea.alumnoestatusid = 1"
				. " INNER JOIN grado g ON g.gradoid=ceac.gradoid"
				. " LEFT JOIN ce_alumnofotocicloactualvista afcav ON afcav.alumnoid=ceac.alumnoid"
				. " LEFT JOIN cj_documentoporpagar cjdp ON cjdp.documentoporpagarid=ceacte.documentoporpagarid"
				. " LEFT JOIN cj_pagoestatus cjpe ON cjpe.pagoestatusid=cjdp.pagoestatusid"
				. " WHERE ceacte.tallerextraid=:taller"
				. "	ORDER BY cea.apellidopaterno, cea.apellidomaterno, cea.primernombre"
				//. " AND ceacte.tallerextraestatusinscripcionid=".self::$TESTATUSID_INSCRITO
				//. " AND ceacte.documentoporpagarid IS NOT NULL"
			;
			if ($nivelid && $nivelid > 0) {
				$sql .= " AND g.nivelid=:nivel";
				$param['nivel'] = $nivelid;
			}
			$stmt = $this->em->getConnection()->prepare($sql);
			$stmt->execute($param);
			$rs = $stmt->fetchAll();
			$data = [];
			foreach ($rs as $i) {
				$prefix = "";
				$suffix = "";
				$dateName = "Inscrito";
				if ($i['documentoporpagarid'] > 0 && $i['pagoestatusid'] != self::$PAGOESTATUS_PAGADO) {
					$prefix = '<span style="color: red">';
					$suffix = '</span>';
					$dateName = "Preinscrito";
				}
				$texto = $prefix
					. trim($i['matricula'])
					. "<br>Sexo: " . trim($i['sexo'])
					. "<br>$dateName: " . trim($i['fechapreregistro'])
					. "<br>" . trim($i['apaterno']) . " " . trim($i['amaterno']) . " " . trim($i['nombre'])
					. $suffix;
				$data[] = [
					"photo" => $i["photo"],
					"texto" => $texto
				];
			}
			return $data;
		} catch (\Exception $e) {
		}
		return false;
	}
	public function getPDFMaterialHeaderByAlumnociclotallerextra($alumnociclotallerextraid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select("c.nombre AS ciclo,"
				. "cete.tallerextracurricularid,"
				. "cete.nombre")->from("AppBundle:CeAlumnocicloportallerextra", "ceacte")
				->innerJoin("AppBundle:CeTallerextracurricular", "cete", "WITH", "cete.tallerextracurricularid=ceacte.tallerextraid")
				->innerJoin("AppBundle:Ciclo", "c", "WITH", "c.cicloid=cete.cicloid")
				->andWhere("ceacte.alumnocicloportallerextraid=:alumno")
				->setParameter("alumno", $alumnociclotallerextraid);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
		}
		return false;
	}
	public function getPDFMaterialByAlumnociclotallerextra($alumnociclotallerextraid)
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select("cemte.materialportallerextracurricularid,"
				. "ceacte.alumnocicloportallerextraid,"
				. "cetm.pedirtalla,"
				. "cetm.nombre AS material,"
				. "cemacte.talla")->from("AppBundle:CeAlumnocicloportallerextra", "ceacte")
				->innerJoin("AppBundle:CeTallerextracurricular", "cete", "WITH", "cete.tallerextracurricularid=ceacte.tallerextraid")
				->innerJoin("AppBundle:CeMaterialportallerextracurricular", "cemte", "WITH", "cemte.tallerextracurricularid=cete.tallerextracurricularid")
				->innerJoin("AppBundle:CeTallerMaterial", "cetm", "WITH", "cetm.tallermaterialid=cemte.tallermaterialid")
				->leftJoin("AppBundle:CeMaterialporalumnocicloportallerextracurricular", "cemacte", "WITH", "cemacte.alumnocicloportallerextraid=ceacte.alumnocicloportallerextraid AND cemacte.materialportallerextracurricularid=cemte.materialportallerextracurricularid")
				->andWhere("ceacte.alumnocicloportallerextraid=:alumno")
				->setParameter("alumno", $alumnociclotallerextraid);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
		}
		return false;
	}
	public function getAlumnocicloportallerextraByTaller($cicloid, $filter = [])
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select(
			"ceacte.alumnocicloportallerextraid AS id",
			"ceacte.alumnocicloportallerextraid",
			"ceac.alumnoporcicloid",
			"c.cicloid",
			"n.nivelid",
			"g.gradoid",
			"ceg.grupoid",
			"GroupConcat(DISTINCT concat_ws(' ',ppa.apellidopaterno,ppa.nombre)) as padres",
			"cete.tallerextracurricularid",
			"c.nombre AS ciclo",
			"n.nombre As nivel",
			"g.grado AS grado",
			"ceg.nombre AS grupo",
			"cete.nombre AS taller",
			"cjdp.documentoporpagarid",
			"cjpe.pagoestatusid",

			"DATE_FORMAT(ceacte.fechapreregistro, '%d/%m/%Y %H:%i') AS fechapreregistro",

			"cea.matricula",
			"cea.apellidopaterno AS apaterno",
			"cea.apellidomaterno AS amaterno",
			"cea.primernombre AS nombre",

			"ceacte.reglamento",
			"ceacte.materialentregado",
			"ceacte.personaautorizo",
			"ceacte.credencialentregada",

			"cjpe.nombre AS pagostatus",
			"(CASE
						WHEN tu.tipousuarioid = 3 THEN 
							concat_ws(' ',cea.apellidopaterno,cea.apellidomaterno,cea.segundonombre,cea.primernombre) 
						ELSE
							concat_ws(' ',pa.apellidopaterno,pa.apellidomaterno,pa.nombre) 
						END) AS usuarionombre"
		)->from("AppBundle:CeAlumnocicloportallerextra", "ceacte")
			->innerJoin("AppBundle:CeTallerextracurricular", "cete", "WITH", "cete.tallerextracurricularid=ceacte.tallerextraid")
			->innerJoin("AppBundle:CeAlumnoporciclo", "ceac", "WITH", "ceac.alumnoporcicloid=ceacte.alumnoporcicloid AND ceac.cicloid=cete.cicloid")
			->innerJoin("AppBundle:CeAlumno", "cea", "WITH", "cea.alumnoid=ceac.alumnoid and cea.alumnoestatusid = 1")
			->leftJoin("AppBundle:CeAlumnoporclavefamiliar", "aca", "WITH", "aca.alumnoid=cea.alumnoid")
			->leftJoin("AppBundle:CePadresotutoresclavefamiliar", "apca", "WITH", "apca.clavefamiliarid=aca.clavefamiliarid")
			->leftJoin("AppBundle:CePadresotutores", "ppa", "WITH", "apca.padresotutoresid=ppa.padresotutoresid")
			->innerJoin("AppBundle:Ciclo", "c", "WITH", "c.cicloid=ceac.cicloid")
			->innerJoin("AppBundle:Grado", "g", "WITH", "g.gradoid=ceac.gradoid")
			->innerJoin("AppBundle:Nivel", "n", "WITH", "n.nivelid=g.nivelid")
			->innerJoin("AppBundle:Usuario", "u", "WITH", "u.usuarioid=ceacte.usuarioid")
			->innerJoin("AppBundle:Tipousuario", "tu", "WITH", "tu.tipousuarioid=u.tipousuarioid")
			->leftJoin("AppBundle:CePadresotutores", "pa", "WITH", "pa.padresotutoresid=u.padreotutorid")

			->leftJoin("AppBundle:CjDocumentoporpagar", "cjdp", "WITH", "cjdp.documentoporpagarid=ceacte.documentoporpagarid")
			->leftJoin("AppBundle:CjPagoestatus", "cjpe", "WITH", "cjpe.pagoestatusid=cjdp.pagoestatusid")

			->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ceacg", "WITH", "ceacg.alumnoporcicloid=ceacte.alumnoporcicloid")
			->leftJoin("AppBundle:CeGrupo", "ceg", "WITH", "ceg.grupoid=ceacg.grupoid")
			->andWhere("cete.activo = 1 and (ceacg.grupoid IS NULL OR ceg.tipogrupoid=1)")
			//->andWhere("ceacte.tallerextraestatusinscripcionid=".self::$TESTATUSID_INSCRITO)
			->andWhere("ceac.cicloid=:ciclo")
			->setParameter("ciclo", $cicloid);
		$nivelid = $filter['nivelid'];
		$tallerid = $filter['tallerid'];
		$matricula = $filter['matricula'];
		if ($nivelid && $nivelid > 0) {
			$qb->andWhere("g.nivelid=:nivel")->setParameter("nivel", $nivelid);
		}
		if ($tallerid && $tallerid > 0) {
			$qb->andWhere("ceacte.tallerextraid=:taller")->setParameter("taller", $tallerid);
		}
		if ($matricula) {
			$qb->andWhere("cea.matricula=:matricula")->setParameter("matricula", $matricula);
		}
		$qb->groupBy('cea.alumnoid, cete.tallerextracurricularid');
		$rs = $qb->getQuery()->getResult();
		$this->getAlumnocicloportallerextraByTallerMaterial($rs);
		return $rs;
	}
	private function getAlumnocicloportallerextraByTallerMaterial(&$data)
	{
		$ids = [];
		$rel = [];
		foreach ($data as $k => &$i) {
			$iid = $i['alumnocicloportallerextraid'];
			$ids[] = $iid;
			$rel[$iid] = $k;
			$i['materiales'] = [];
		}
		foreach ($this->getMaterialporalumnocicloportallerextracurricularByAlumnocicloportallerextra($ids) as $j) {
			$irel = $rel[$j['alumnocicloportallerextraid']];
			$data[$irel]['materiales'][] = $j;
		}
	}
	private function getMaterialporalumnocicloportallerextracurricularByAlumnocicloportallerextra($alumnocicloportallerextra = [])
	{
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"cemacte.materialporalumnocicloportallerextracurricularid AS id",
				"IDENTITY(cemacte.alumnocicloportallerextraid) AS alumnocicloportallerextraid",
				"cemacte.materialporalumnocicloportallerextracurricularid",
				"cetm.nombre AS material",
				"cemacte.talla",
				"DATE_FORMAT(cemacte.fechaentrega, '%d/%m/%Y %H:%i') AS fechaentrega"
			)->from("AppBundle:CeMaterialporalumnocicloportallerextracurricular", "cemacte")
				->innerJoin("AppBundle:CeMaterialportallerextracurricular", "cemte", "WITH", "cemte.materialportallerextracurricularid=cemacte.materialportallerextracurricularid")
				->innerJoin("AppBundle:CeTallermaterial", "cetm", "WITH", "cetm.tallermaterialid=cemte.tallermaterialid")
				->andWhere("cemacte.alumnocicloportallerextraid IN (:alumnoscicloportallerextra)")
				->setParameter("alumnoscicloportallerextra", $alumnocicloportallerextra);
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
		}
		return false;
	}

	private function buildTallerArray($data)
	{
		$rel = array();
		$res = array();
		foreach ($data as $i) {
			$id = $i['id'];
			if (!isset($rel[$id])) {
				$ty = [
					"id" => $id,
					"cicloid" => (int) $i['cicloid'],
					"nombre" => $i['nombre'],
					"tipo" => $i['tipo'],
					"nivel" => array(),
					"grado" => array()
				];
				$res[] = $id;
				$rel[$id] = $ty;
			}
			$t = &$rel[$id];
			$t['nivel'][] = (int) $i['nivelid'];
			$t['grado'][] = (int) $i['gradoid'];
		}
		foreach ($res as $k => $i) {
			$res[$k] = $rel[$i];
		}
		return $res;
	}

	public function loadMaterialReport($filtros)
	{
		$conn = $this->em->getConnection();
		$filtro = " ";

		if ($filtros['nivelid']) {
			$filtro = $filtro . " AND n.NivelId =" . $filtros['nivelid'];
		}

		if ($filtros['tallerid']) {
			$filtro = $filtro .  " AND cete.TallerExtracurricularId = " . $filtros['tallerid'];
		}

		$stmt = $conn->prepare("SELECT 
				ceacte.alumnocicloportallerextraid,
				cea.matricula AS matricula,
				cea.primernombre AS Nombre,
				cea.apellidopaterno AS 'Apellido Paterno',
				cea.apellidomaterno AS 'Apellido Materno',
				n.Nombre AS Nivel,
				g.grado AS Grado,
				ceg.Nombre AS Grupo,
				DATE_FORMAT(ceacte.fechapreregistro, '%d/%m/%Y %H:%i') AS 'Fecha entrega',
				cete.Nombre AS 'Taller extracurricular',
				case when cjpe.nombre is not null then cjpe.nombre else '' end AS 'Estatus pago',
				case when ceacte.credencialentregada = 1 then 'SI' else 'NO' end as Credencial,
				case when ceacte.reglamento = 1 then 'SI' else 'NO' end as Reglamento,
				CONCAT_WS(' ', ppa.Nombre, ppa.ApellidoPaterno, ppa.ApellidoMaterno) AS 'Padre',
				ppa.Telefono AS 'Padre Telefono',
				(
				CASE 
					WHEN up1.usuarioid IS NULL
					THEN ppa.Correo
					ELSE up1.cuenta
				END
				) as 'Padre Correo',
				CONCAT_WS(' ', ppam.Nombre, ppam.ApellidoPaterno, ppam.ApellidoMaterno) AS 'Madre',
				ppam.Telefono AS 'Madre Telefono',
				(
				CASE 
					WHEN up2.usuarioid IS NULL
					THEN ppam.Correo
					ELSE up2.cuenta
				END
				) as 'Madre Correo'
		FROM ce_alumnocicloportallerextra ceacte
		INNER JOIN ce_tallerextracurricular cete ON cete.TallerExtracurricularId = ceacte.TallerExtraId
		INNER JOIN ce_alumnoporciclo ceac ON ceac.AlumnoPorCicloId = ceacte.AlumnoPorCicloId
		INNER JOIN ce_alumno cea ON cea.AlumnoId = ceac.AlumnoId
		LEFT JOIN ce_alumnoporclavefamiliar aca ON aca.AlumnoId = cea.AlumnoId

		LEFT JOIN ce_padresotutoresclavefamiliar apca ON apca.ClaveFamiliarId = aca.ClaveFamiliarId AND (apca.TutorId = 1 OR apca.TutorId = 3)
		LEFT JOIN ce_padresotutores ppa ON ppa.PadresOTutoresId = apca.PadresOTutoresId
		LEFT JOIN usuario up1 ON up1.PadreoTutorId = ppa.PadresOTutoresId

		LEFT JOIN ce_padresotutoresclavefamiliar apcam ON apcam.ClaveFamiliarId = aca.ClaveFamiliarId AND (apcam.TutorId = 2 OR apcam.TutorId = 4)
		LEFT JOIN ce_padresotutores ppam ON ppam.PadresOTutoresId = apcam.PadresOTutoresId
		LEFT JOIN usuario up2 ON up2.PadreoTutorId = ppam.PadresOTutoresId

		INNER JOIN ciclo c ON c.CicloId = ceac.CicloId
		INNER JOIN grado g ON g.GradoId = ceac.GradoId
		INNER JOIN nivel n ON n.NivelId = g.NivelId
		INNER JOIN usuario u ON u.UsuarioId = ceacte.UsuarioId
		INNER JOIN tipousuario tu ON tu.TipoUsuarioId = u.TipoUsuarioId
		LEFT JOIN ce_padresotutores pa ON pa.PadresOTutoresId = u.PadreoTutorId
		LEFT JOIN cj_documentoporpagar cjdp ON cjdp.DocumentoPorPagarId = ceacte.DocumentoPorPagarId
		LEFT JOIN cj_pagoestatus cjpe ON cjpe.PagoEstatusId = cjdp.PagoEstatusId

		LEFT JOIN ce_alumnocicloporgrupo ceacg ON ceacte.AlumnoPorCicloId = ceacg.AlumnoPorCicloId
		LEFT JOIN ce_grupo ceg ON ceg.GrupoId = ceacg.GrupoId
		WHERE cete.Activo = 1 AND (ceacg.grupoid IS NULL OR ceg.tipogrupoid=1)
		AND c.CicloId =" . $filtros['cicloid'] . " $filtro
		ORDER BY cea.matricula;");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function loadTalleresMateriales($filtros)
	{
		$conn = $this->em->getConnection();
		$filtro = " ";

		if ($filtros['nivelid']) {
			$filtro = $filtro . " AND n.NivelId =" . $filtros['nivelid'];
		}

		if ($filtros['tallerid']) {
			$filtro = $filtro .  " AND ct.TallerExtracurricularId = " . $filtros['tallerid'];
		}

		$stmt = $conn->prepare("SELECT cm.MaterialPorTallerExtraCurricularId, 
		ct1.TallerMaterialId, 
		ct1.Nombre as material FROM ce_materialportallerextracurricular cm
		INNER JOIN ce_tallermaterial ct1 ON ct1.TallerMaterialId = cm.TallerMaterialId
		INNER JOIN ce_tallerextracurricular ct ON ct.TallerExtracurricularId = cm.TallerExtraCurricularId
		INNER JOIN ce_gradoportallerextracurricular cg ON cg.TallerExtraCurricularId = cm.TallerExtraCurricularId
		INNER JOIN grado g ON g.GradoId = cg.GradoId
		INNER JOIN nivel n ON g.NivelId = n.NivelId
		WHERE ct.CicloId =" . $filtros['cicloid'] . " $filtro
		GROUP BY ct1.Nombre");

		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function loadMaterialesEntregados($filtros)
	{
		$conn = $this->em->getConnection();
		$filtro = " ";

		if ($filtros['cicloid']) {
			$filtro = $filtro . " AND ct.CicloId =" . $filtros['cicloid'];
		}

		if ($filtros['nivelid']) {
			$filtro = $filtro .  " AND n.NivelId = " . $filtros['nivelid'];
		}

		if ($filtros['tallerid']) {
			$filtro = $filtro .  " AND ct.TallerExtracurricularId = " . $filtros['tallerid'];
		}

		$stmt = $conn->prepare("SELECT 
		ct1.Nombre as material ,
    (SELECT COUNT(*) FROM ce_materialporalumnocicloportallerextracurricular ca WHERE FIND_IN_SET(ca.MaterialPorTallerExtracurricularId, GROUP_CONCAT(DISTINCT cm.MaterialPorTallerExtraCurricularId))) AS entregadas
    FROM ce_materialportallerextracurricular cm
		INNER JOIN ce_tallermaterial ct1 ON ct1.TallerMaterialId = cm.TallerMaterialId
		INNER JOIN ce_tallerextracurricular ct ON ct.TallerExtracurricularId = cm.TallerExtraCurricularId
		INNER JOIN ce_gradoportallerextracurricular cg ON cg.TallerExtraCurricularId = cm.TallerExtraCurricularId
		INNER JOIN grado g ON g.GradoId = cg.GradoId
		INNER JOIN nivel n ON g.NivelId = n.NivelId
		WHERE ct.Activo = 1" . $filtro . "
		GROUP BY ct1.Nombre;");

		$stmt->execute();
		return $stmt->fetchAll();
	}
}
