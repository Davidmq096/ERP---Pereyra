<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * @author Emmanuel Martinez
 * Created: 2020-08-17
 * Last Modified: 2020-08-17
 */
class AvanceCalificacionesDB extends BaseDBManager{
	public function getCalificaciones($filter){
		$query=$this->em->createQueryBuilder()
				->select("cecpa.calificacionperiodoporalumnoid",
					"n.nombre AS nivel",
					"g.grado AS grado",
					"ceg.nombre AS grupo",
					"m.nombre AS materia",
					"CONCAT_WS(' ', cep.apellidopaterno, cep.apellidomaterno, cep.nombre) AS profesor",
					"cepe.descripcion AS pevaluacion",
					"AVG(cecpa.avance) AS avance"
				)->from("AppBundle:CeCalificacionperiodoporalumno", "cecpa")
				->innerJoin("cecpa.alumnoporcicloid", "ac")
				->innerJoin("ac.alumnoid", "a")
				->innerJoin("cecpa.materiaid", "m")
				->innerJoin("cecpa.periodoevaluacionid", "cepe")
				->innerJoin("cecpa.materiaporplanestudioid", "cempe")
				->innerJoin("cecpa.profesorpormateriaplanestudioid", "cepmpe")
				->innerJoin("cepmpe.profesorid", "cep")
				->innerJoin("cepmpe.grupoid", "ceg")
				->innerJoin("ceg.gradoid", "g")
				->innerJoin("g.nivelid", "n")

				->andWhere("ceg.cicloid=:kciclo")
				->setParameter("kciclo", $filter["cicloid"])

				->andWhere("g.nivelid=:knivel")
				->setParameter("knivel", $filter["nivelid"])
						
				->andWhere("a.alumnoestatusid=1")

				->groupBy("cepmpe.profesorpormateriaplanestudiosid","cecpa.periodoevaluacionid")
			;

		if(!empty($filter["semestreid"])){
			$query->andWhere("g.gradoid=:ksemestre")
				->setParameter("ksemestre", $filter["semestreid"]);
		}

		if(!empty($filter["gradoid"])){
			$query->andWhere("ceg.gradoid=:kgrado")
				->setParameter("kgrado", $filter["gradoid"]);
		}

		if(!empty($filter["grupoid"])){
			$query->andWhere("cepmpe.grupoid=:kgrupo")
				->setParameter("kgrupo", $filter["grupoid"]);
		}

		if(!empty($filter["pevaluacionid"])){
			$query->andWhere("cecpa.periodoevaluacionid=:kpevaluacion")
				->setParameter("kpevaluacion", $filter["pevaluacionid"]);
		}

		if(!empty($filter["materiaid"])){
			$query->andWhere("cecpa.materiaid=:kmateria")
				->setParameter("kmateria", $filter["materiaid"]);
		}

		if(!empty($filter["profesorid"])){
			$query->andWhere("cepmpe.profesorid=:kprofesor")
				->setParameter("kprofesor", $filter["profesorid"]);
		}

		if(!empty($filter["pestudioid"])){
			$query->andWhere("cempe.planestudioid=:kpestudio")
				->setParameter("kpestudio", $filter["pestudioid"]);
		}

		return $query->getQuery()->getResult();
	}
}