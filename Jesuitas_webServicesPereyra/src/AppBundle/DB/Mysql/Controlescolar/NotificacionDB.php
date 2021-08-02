<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of notificacion
 *
 * @author Mariano
 */
class NotificacionDB extends BaseDBManager
{

	public function BuscarNotificaciones($filtros)
	{
		//$filtros["cicloid"]=4;//test
		$nivelsql = "''";
		$gradosql = "''";
		$gruposql = "''";
		$cicloid = trim($filtros["cicloid"]);
		if (!empty($cicloid)) {
			$nivelsql = "n.nombre";
			$gradosql = "g.grado";
			$gruposql = "gru.nombre";
		}
		try {
			$qb = $this->em->createQueryBuilder();
			$qb->select(
				"DATE_FORMAT(a.fecha, '%d/%m/%Y') as fecha,DATE_FORMAT(a.fecha, '%H:%i:%s')  as hora,ta.nombre as tipoactividad,uo.cuenta as usuarioorigen,ud.cuenta as usuariodestino,
				CONCAT_WS(' ',porigen.apellidopaterno,porigen.apellidomaterno,porigen.nombre) as uorigen,
				CONCAT_WS(' ',profeorigen.apellidopaterno,profeorigen.apellidomaterno,profeorigen.nombre) as profeo,
				CONCAT_WS(' ',alumnoorigen.apellidopaterno,alumnoorigen.apellidomaterno,alumnoorigen.primernombre,alumnoorigen.segundonombre) as ao,
				CONCAT_WS(' ',pdestino.apellidopaterno,pdestino.apellidomaterno,pdestino.nombre) as udestino,
				CONCAT_WS(' ',profedestino.apellidopaterno,profedestino.apellidomaterno,profedestino.nombre) as ppdestino,
				CONCAT_WS(' ',alumnodestino.apellidopaterno,alumnodestino.apellidomaterno,alumnodestino.primernombre,alumnodestino.segundonombre) as ad,
				$nivelsql AS nivel,
				$gradosql AS grado,
				$gruposql AS grupo,
				m.nombre as materia"
			)->from("AppBundle:CeActividad", "a")
				->innerJoin("AppBundle:CeTipoactividad", "ta", Expr\Join::WITH, "ta.tipoactividadid=a.tipoactividadid")

				->leftJoin("AppBundle:Usuario", "uo", Expr\Join::WITH, "uo.usuarioid=a.usuarioorigenid")
				->leftJoin("AppBundle:Usuario", "ud", Expr\Join::WITH, "ud.usuarioid=a.usuariodestinoid")

				->leftJoin("AppBundle:Persona", "porigen", Expr\Join::WITH, "porigen.personaid=uo.personaid")
				->leftJoin("AppBundle:CeProfesor", "profeorigen", Expr\Join::WITH, "profeorigen.profesorid=uo.profesorid")
				->leftJoin("AppBundle:CeAlumno", "alumnoorigen", Expr\Join::WITH, "alumnoorigen.alumnoid=uo.alumnoid")

				->leftJoin("AppBundle:Persona", "pdestino", Expr\Join::WITH, "pdestino.personaid=ud.personaid")
				->leftJoin("AppBundle:CeProfesor", "profedestino", Expr\Join::WITH, "profedestino.profesorid=ud.profesorid")
				->leftJoin("AppBundle:CeAlumno", "alumnodestino", Expr\Join::WITH, "alumnodestino.alumnoid=ud.alumnoid")
				->leftJoin("AppBundle:CeMateriaporplanestudios", "mpe", Expr\Join::WITH, "mpe.materiaporplanestudioid=a.materiaporplanestudioid")
				->leftJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid=mpe.materiaid");
			if (!empty($cicloid)) {
				$qb->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid=alumnodestino.alumnoid AND ac.cicloid=:ciclo")
					->leftJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid=ac.gradoid")
					->leftJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid=g.nivelid")
					->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid=ac.alumnoporcicloid")
					->leftJoin("AppBundle:CeGrupo", "gru", Expr\Join::WITH, "gru.grupoid=acg.grupoid")
					->setParameter("ciclo", $cicloid);
			}
			if (isset($filtros["tipoactividadid"])) {
				$qb->andWhere('ta.tipoactividadid = (:tipoactividadid)')
					->setParameter('tipoactividadid', $filtros['tipoactividadid']);
			}
			if (isset($filtros["fecha"])) {
				$filtros["fechainicio"] = new \DateTime($filtros["fecha"]["beginDate"]["year"] . "-" . $filtros["fecha"]["beginDate"]["month"] . "-" . $filtros["fecha"]["beginDate"]["day"]);
				$filtros["fechafin"] = new \DateTime($filtros["fecha"]["endDate"]["year"] . "-" . $filtros["fecha"]["endDate"]["month"] . "-" . $filtros["fecha"]["endDate"]["day"]);
				$qb->andWhere("DATE_FORMAT(a.fecha, '%Y-%m-%d') >= :fechainicio and DATE_FORMAT(a.fecha, '%Y-%m-%d') <= :fechafin")
					->setParameter('fechainicio', $filtros['fechainicio']->format('Y-m-d'))
					->setParameter('fechafin', $filtros['fechafin']->format('Y-m-d'));
			}else{
				$filtros["fechainicio"] = $filtros["fechaactual"]->getFechainicio();
				$filtros["fechafin"] = $filtros["fechaactual"]->getFechafin();
				$qb->andWhere("DATE_FORMAT(a.fecha, '%Y-%m-%d') >= :fechainicio and DATE_FORMAT(a.fecha, '%Y-%m-%d') <= :fechafin")
				->setParameter('fechainicio', $filtros['fechainicio']->format('Y-m-d'))
				->setParameter('fechafin', $filtros['fechafin']->format('Y-m-d'));
			}

			if (isset($filtros["alumnoid"])) {
				$qb->andWhere('alumnoorigen.alumnoid=:alumnoid or alumnodestino.alumnoid=:alumnoid')
					->setParameter('alumnoid', $filtros['alumnoid']);
			}
			if (isset($filtros["usuarioid"])) {
				$qb->andWhere('uo.usuarioid=:usuarioid or ud.usuarioid=:usuarioid')
					->setParameter('usuarioid', $filtros['usuarioid']);
			}

			switch ($filtros["sistema"]) {
				case 1:
				default:
					$qb->andWhere('ta.descripcionadmin is not null');
					break;
				case 3:
					$qb->andWhere('ta.descripcionalumno is not null');
					break;
				case 4:
					$qb->andWhere('ta.descripcionpadre is not null');
					break;
			}
			$qb->groupBy('a.fecha, a.tipoactividadid, a.usuarioorigenid');
			$qb->orderBy('a.fecha', 'desc');
			return $qb->getQuery()->getResult();
		} catch (\Exception $e) {
			var_dump($e->getMessage());
		}
	}
}
