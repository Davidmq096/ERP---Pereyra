<?php

namespace AppBundle\DB\Mysql\Reportes;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Calificacion
 *
 * @author Mariano
 */
class CalificacionDB extends BaseDBManager {

    public function ConsultaCalificaciones($filtros) {
        $qb=$this->em->createQueryBuilder();
        $result=$qb->select("cpa.calificacionperiodoporalumnoid AS id",
						"pmpe.profesorpormateriaplanestudiosid",
						"mpe.materiaporplanestudioid",
						"cetc.tipocalificacionid",
						"pe.periodoevaluacionid",
						"ac.alumnoporcicloid",
						"m.materiaid",
						"pon.ponderacionid",
						"g.gradoid",
						"IDENTITY(g.nivelid) as nivelid",
						"a.alumnoid",
						"CASE WHEN gru.grupoid IS NOT NULL THEN gru.grupoid ELSE ta.tallercurricularid END AS grupoid",
						"CASE WHEN gru.grupoid IS NOT NULL THEN gru.nombre ELSE ta.nombre END AS gruponombre",
						"CASE WHEN cpa.calificacion < pe2.puntopase THEN a.alumnoid else '' end as reprobados",
						"g.grado AS gradonombre",
						"a.matricula",
						"CONCAT_WS(' ', a.matricula, a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) AS nombre",
						"CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) AS nombrecompleto",

						"pe.porcentajecalificacionfinal AS porcentajecf",
						"pe.descripcion",
						"pe.descripcioncorta",
						"pe.fechainicio",
						"pe.fechafin",
						"cc.ponderacionparacapturaopciones",
						"m.nombre AS materianombre",
						"m.clave AS materiaclave",
						"m.alias AS nombrecorto",
						"mpe.escurricular",
						"ponopc.opcion",
						"acg.numerolista",
						"cpa.calificacion AS calificacionperiodo",
						"cfpa.calificacionfinalperiodoporalumnoid",
						"cfpa.calificacion AS calificacionfinal",
						"cpa.observacion AS observacion",
						"pe2.calificacionminima",

						"pe2.planestudioid"
					)->from("AppBundle:CeCalificacionperiodoporalumno","cpa")
					->leftJoin("AppBundle:CeCalificacionfinalperiodoporalumno", "cfpa", Expr\Join::WITH, "cfpa.calificacionfinalperiodoporalumnoid=cpa.calificacionfinalporperiodoalumno")
					->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe", Expr\Join::WITH, "pmpe.profesorpormateriaplanestudiosid=cpa.profesorpormateriaplanestudioid")
					->innerJoin("AppBundle:CeMateriaporplanestudios", "mpe", Expr\Join::WITH, "mpe.materiaporplanestudioid=cpa.materiaporplanestudioid")
					->innerJoin("AppBundle:CeComponentecurricular", "cc", Expr\Join::WITH, "cc.componentecurricularid=mpe.componentecurricularid")
					->innerJoin("AppBundle:CeTipocalificacion", "cetc", "WITH", "cetc.tipocalificacionid=cc.tipocalificacionid")
					->leftJoin("AppBundle:CePonderacion", "pon", Expr\Join::WITH, "pon.ponderacionid=cc.ponderacionid")
					->leftJoin("AppBundle:CePonderacionopcion", "ponopc", Expr\Join::WITH, "ponopc.ponderacionopcionid=cpa.ponderacionopcionid")
					->innerJoin("AppBundle:CePeriodoevaluacion", "pe", Expr\Join::WITH, "pe.periodoevaluacionid=cpa.periodoevaluacionid")
					->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoporcicloid=cpa.alumnoporcicloid")
					->innerJoin("AppBundle:CeAlumnocicloporgrupo", "ceacg", Expr\Join::WITH, "ceacg.alumnoporcicloid=ac.alumnoporcicloid")
					->innerJoin("AppBundle:CeGrupo", "ceg", Expr\Join::WITH, "ceg.grupoid=ceacg.grupoid AND ceg.tipogrupoid=1")
					->innerJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid=cpa.materiaid")
					->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid=ac.alumnoid")
					->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid=ac.gradoid")
					->innerJoin("AppBundle:CePlanestudios", "pe2", Expr\Join::WITH, "mpe.planestudioid = pe2.planestudioid and pe2.gradoid = g.gradoid")
					->leftJoin("AppBundle:CeGrupo", "gru", Expr\Join::WITH, "gru.grupoid=pmpe.grupoid")
					->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid=ac.alumnoporcicloid AND (pmpe.grupoid IS NULL OR acg.grupoid=pmpe.grupoid)")
					->leftJoin("AppBundle:CeAlumnocicloportaller", "acgt", Expr\Join::WITH, "acgt.alumnoporcicloid=ac.alumnoporcicloid")
					->leftJoin("AppBundle:CeTallercurricular", "ta", Expr\Join::WITH, "ta.tallercurricularid=acgt.tallercurricularid")
					->andWhere('a.alumnoestatusid=:alumnoestatus')
					//->andWhere('gru.tipogrupoid=:tipogrupo')
        	->setParameter('alumnoestatus', 1)
        	//->setParameter('tipogrupo', 1)
				;
        if (isset($filtros['cicloid'])) {
            $result->andWhere('ac.cicloid = :cicloid')
        	->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
            $result->andWhere('g.nivelid = :nivelid')
        	->setParameter('nivelid', $filtros['nivelid']);
        }
		if (isset($filtros['gradoid'])) {
			
			if(is_array($filtros['gradoid'])){
				$result->andWhere('g.gradoid in(:gradoid)')->setParameter('gradoid', $filtros['gradoid']);
			}else{
				$result->andWhere('g.gradoid = :gradoid')->setParameter('gradoid', $filtros['gradoid']);
			}
		}
        if (isset($filtros['alumnoid'])) {
            $result->andWhere('cpa.alumnoid IN (:alumnoid)')
        	->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['grupoid'])) {
            $result->andWhere('ceg.grupoid = :grupoid')
        	->setParameter('grupoid', $filtros['grupoid']);
		}
		if (isset($filtros['matricula'])) {
			$escape=array("_","%");
			$escapados=array("\_","\%");
			$filtros['matricula']=trim(str_replace($escape,$escapados,$filtros['matricula']));
			   $result->andWhere('a.matricula = :matricula')
			   ->setParameter('matricula', $filtros['matricula']);
		   }
		if (isset($filtros['periodoevaluacionid'])) {
            $result->andWhere('pe.periodoevaluacionid IN (:periodoevaluacionid)')
        	->setParameter('periodoevaluacionid', $filtros['periodoevaluacionid']);
		}
		if (isset($filtros['materiaid'])) {
            $result->andWhere('m.materiaid = :materiaid')
        	->setParameter('materiaid', $filtros['materiaid']);
		}

        $result->orderBy('m.materiaid,pe.periodoevaluacionid,ac.gradoid,acg.grupoid,a.apellidopaterno, a.apellidomaterno,a.primernombre,a.segundonombre');
        $result->groupBy('cpa.calificacionperiodoporalumnoid');
		$data=$result->getQuery()->getResult();
		if($filtros['soloreprobados'] == "1") {
			$reprobados=array_values(array_unique(array_column($data, 'reprobados')));
			$reprobados = array_filter($reprobados, function ($value) {
				return $value !== '';
			});
			$alumnos = [];
			foreach ($data as $r) {
				$rt = in_array($r['alumnoid'], $reprobados);
				if($rt == true) {
					$alumnos[]= $r;
				}
			}
			$data = $alumnos;
		}


				
				//GetExtras
				$kalumnosraw=[];
				$kppmpesraw=[];
				foreach($data AS $icalificacion){
					$kalumnosraw[]=$icalificacion['alumnoid'];
					$kppmpesraw[]=$icalificacion['profesorpormateriaplanestudiosid'];
				}
				$extraordinarios=$this->getExtraordinariosByAlumnosPpmpes($kalumnosraw, $kppmpesraw);
				foreach($extraordinarios AS $iextraordinario){
					foreach($data AS &$icalificacion){
						if($icalificacion['alumnoid']==$iextraordinario['alumnoid']
							&& $icalificacion['profesorpormateriaplanestudiosid']==$iextraordinario['profesorpormateriaplanestudiosid']){
							$icalificacion['calificacionfinal']=$iextraordinario['calificacion'];
							$icalificacion['extraordinario']=$iextraordinario['calificacion'];
						}
						unset($icalificacion);
					}
				}
        return $data;
    }
		private function getExtraordinariosByAlumnosPpmpes($kalumnosraw, $kppmpesraw){
				$kalumnos=array_unique($kalumnosraw);
				$kppmpes=array_unique($kppmpesraw);
				$qb=$this->em->createQueryBuilder();
        return $qb->select("IDENTITY(cee.alumnoid) AS alumnoid",
						"IDENTITY(cee.profesorpormateriaplanestudiosid) AS profesorpormateriaplanestudiosid",
						"ceae.calificacionfinal AS calificacion"
					)->from("AppBundle:CeExtraordinario","cee")
					->innerJoin("AppBundle:CeAcuerdoextraordinario", "ceae", Expr\Join::WITH, "ceae.extraordinarioid=cee.extraordinarioid")
					->andWhere('cee.alumnoid IN (:alumnos)')
					->andWhere('cee.profesorpormateriaplanestudiosid IN (:ppmpes)')
					->andWhere('ceae.estatusextraordinarioid = 4')
					->setParameter('alumnos',$kalumnos)
					->setParameter('ppmpes',$kppmpes)
					->getQuery()
					->getResult()
				;
		}

	    public function DesgloseCapturaAlumno($id) {
			$qb = $this->em->createQueryBuilder();
			$calificadas = $qb->select("SUM(case when d2.calificacion is null or d2.calificacion = 'NP' then 0 else 1 end)")
				->from("AppBundle:CeCapturacalificacionporalumno", "d2")
				->innerJoin("AppBundle:CeCriterioevaluaciongrupo", "ceg2", Expr\Join::WITH, "ceg2.criterioevaluaciongrupoid=d2.criterioevaluaciongrupoid")
				->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe2", Expr\Join::WITH, "pmpe2.profesorpormateriaplanestudiosid = ceg2.profesorpormateriaplanestudiosid ")
				->where("d2.calificacionperiodoporalumnoid = cpa.calificacionperiodoporalumnoid ")
				->andWhere("ceg2.criterioevaluaciongrupoid = ceg.criterioevaluaciongrupoid ");
			$calificadas->getQuery()->getDQL();

			$qb = $this->em->createQueryBuilder();
			$noentregadas = $qb->select("SUM(case when d3.calificacion = 'NP' then 1 else 0 end)")
			->from("AppBundle:CeCapturacalificacionporalumno", "d3")
			->innerJoin("AppBundle:CeCriterioevaluaciongrupo", "ceg3", Expr\Join::WITH, "ceg3.criterioevaluaciongrupoid=d3.criterioevaluaciongrupoid")
			->where("d3.calificacionperiodoporalumnoid = cpa.calificacionperiodoporalumnoid ")
			->andWhere("ceg3.criterioevaluaciongrupoid = ceg.criterioevaluaciongrupoid ");
			$noentregadas->getQuery()->getDQL();

			$qb = $this->em->createQueryBuilder();
			$puntos = $qb->select("ROUND((SUM(d4.calificacion/ceg4.capturas)*ceg4.capturas),1)")
			->from("AppBundle:CeCapturacalificacionporalumno", "d4")
			->innerJoin("AppBundle:CeCriterioevaluaciongrupo", "ceg4", Expr\Join::WITH, "ceg4.criterioevaluaciongrupoid=d4.criterioevaluaciongrupoid")
			->where("d4.calificacionperiodoporalumnoid = cpa.calificacionperiodoporalumnoid ")
			->andWhere("ceg4.criterioevaluaciongrupoid = ceg.criterioevaluaciongrupoid ");
			$puntos->getQuery()->getDQL();



			$qb=$this->em->createQueryBuilder();
			$result=$qb->select(					
			"ceg.criterioevaluaciongrupoid",
			"ceg.aspecto",
			"ceg.porcentajecalificacion",
			"ceg.configurartarea AS tarea",
			"ceg.capturas AS numerocapturas",
			"ceg.capturas*ceg.puntajemaximo AS puntajemaximo")
			
			->addSelect("(" . $calificadas . ") as calificadas")
			->addSelect("(" . $noentregadas . ") as noentregadas")
			->addSelect("(" . $puntos . ") as puntos")
			->from("AppBundle:CeCapturacalificacionporalumno","d")
			->innerJoin("AppBundle:CeCriterioevaluaciongrupo", "ceg", Expr\Join::WITH, "ceg.criterioevaluaciongrupoid=d.criterioevaluaciongrupoid")
			->innerJoin("AppBundle:CeCalificacionperiodoporalumno", "cpa", Expr\Join::WITH, "cpa.calificacionperiodoporalumnoid=d.calificacionperiodoporalumnoid")
			->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid=cpa.alumnoporcicloid")
			->leftJoin("AppBundle:CeAlumnocicloportaller", "act", Expr\Join::WITH, "act.alumnoporcicloid=cpa.alumnoporcicloid")
			->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe", Expr\Join::WITH, "pmpe.profesorpormateriaplanestudiosid = ceg.profesorpormateriaplanestudiosid and (pmpe.grupoid = acg.grupoid or pmpe.tallerid = act.tallercurricularid)")
			->andWhere("cpa.calificacionperiodoporalumnoid = " . $id)
			->groupBy("ceg.criterioevaluaciongrupoid");

			return $result->getQuery()->getResult();
		}
}
