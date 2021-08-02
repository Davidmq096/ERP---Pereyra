<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of RegistroIntencionReinscribirseDB
 *
 * @author Javier
 */
class RegistroIntencionReinscribirseDB extends BaseDBManager{
	public function GetAlumnoporCiclo($filtros){
		$gradoid=$this->em->createQueryBuilder()->select("gdd.gradoid")
			->from("AppBundle:Grado", "gdd")
			->where("gdd.gradoid=(
				CASE
					WHEN n.nivelid=4 THEN CASE
						WHEN g.gradoid = 17 THEN 0
						WHEN g.gradoid = 18 THEN 0
						ELSE g.gradoid + 2
					END
				ELSE
					CASE WHEN g.gradoid = 19 THEN 1 ELSE g.gradoid+1 END
				END)"
			)->getQuery()
			->getDQL()
		;

		$result=$this->em->createQueryBuilder()->select("ac.alumnoporcicloid",
				"i.intencionreinscribirseid",
				"ac.alumnoporcicloid",
				"a.alumnoid",
				"g.gradoid",
				"gd.gradoid AS gradoiddestino",
				"a.matricula",
				"c.nombre AS cicloorigen",
				"n.nombre AS nivelorigen",
				"CASE WHEN n.nivelid=4 THEN GROUPCONCAT(DISTINCT g.grado ORDER BY g.grado ASC SEPARATOR ', ')  ELSE g.grado END AS gradoorigen",
				"GROUPCONCAT(DISTINCT grua.nombre SEPARATOR ', ') AS grupoorigen",
				"CASE WHEN ac.correoenviado=1 THEN 'Sí' ELSE 'No' END AS correoenviado",
				"CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) AS nombre",
				"CASE
					WHEN calculaAdeudo(a.alumnoid) > 0 THEN
						CASE
							WHEN cbacu.acuerdoid IS NOT NULL THEN 'Convenio vigente'
							ELSE 'Con adeudo'
						END
					ELSE 'Sin adeudo'
				END AS estatuscobranza",
				"0 AS promedio",
				"COUNT(DISTINCT e.extraordinarioid) AS extraordinarios",
				"COUNT(DISTINCT eapr.extraordinarioid) AS extraordinariosaprobados",
				"COUNT(DISTINCT erep.extraordinarioid) AS extraordinariosreprobados",
				"COUNT(DISTINCT rd.reportedisciplinaid) AS reportes",
				"i.nombre AS intencion",
				"gd.grado AS gradodestino",
				"nd.nombre AS niveldestino",
				"(SELECT CASE
						WHEN g.gradoid=17 THEN ''
						WHEN g.gradoid=18 THEN ''
						THEN cd.nombre
					END
					FROM AppBundle:Ciclo cd
					WHERE cd.siguiente=1
				) AS ciclodestino"
			)->from("AppBundle:CeAlumno", "a")
			->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "a.alumnoid = ac.alumnoid")
			->innerJoin("ac.cicloid", "c")
			->innerJoin("ac.gradoid", "g")
			->innerJoin("g.nivelid", "n")
			->leftJoin("ac.intencionreinscribirseid", "i")
			->leftJoin("AppBundle:CbAlumnoporacuerdo", "aa", Expr\Join::WITH, "a.alumnoid = aa.alumnoid")
			->leftJoin("AppBundle:CbAcuerdo", "cbacu", Expr\Join::WITH, "aa.acuerdoid = cbacu.acuerdoid AND cbacu.estatusacuerdoid = 1")
			->leftJoin("AppBundle:Grado", "gd", Expr\Join::WITH, "gd.gradoid=(".$gradoid.")")
			->leftJoin("gd.nivelid", "nd")
			->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acga", Expr\Join::WITH, "acga.alumnoporcicloid = ac.alumnoporcicloid")
			->leftJoin("AppBundle:CeGrupo", "grua", Expr\Join::WITH, "grua.grupoid = acga.grupoid AND grua.tipogrupoid = 1")
			->leftJoin("AppBundle:CeReportedisciplina", "rd", Expr\Join::WITH, "rd.alumnoporcicloid = ac.alumnoporcicloid")
			->leftJoin("AppBundle:CeExtraordinario", "e", Expr\Join::WITH, "e.alumnoid = a.alumnoid")
			->leftJoin("AppBundle:CeExtraordinario", "eapr", Expr\Join::WITH, "eapr.estatusextraordinarioid=4 AND eapr.alumnoid=a.alumnoid")
			->leftJoin("AppBundle:CeExtraordinario", "erep", Expr\Join::WITH, "erep.estatusextraordinarioid=5 AND erep.alumnoid=a.alumnoid")
			->leftJoin("AppBundle:CeAcuerdoextraordinario", "ae", Expr\Join::WITH, "ae.extraordinarioid=e.extraordinarioid")
			//->where("a.alumnoestatusid = 1")
			->groupBy("a.alumnoid, c.cicloid")
		;

		if(isset($filtros['cicloid'])){
			$result->andWhere('c.cicloid IN (:cicloid)')
				->setParameter('cicloid', $filtros['cicloid']);
		}

		if(isset($filtros['nivelid'])){
			$result->andWhere('n.nivelid IN (:nivelid)')
				->setParameter('nivelid', $filtros['nivelid']);
		}

		if(sizeof($filtros['gradoid']) > 0){
			$result->andWhere('g.gradoid In (:gradosid)')
				->setParameter('gradosid', $filtros['gradoid']);
		}

		if(isset($filtros['intencionreinscribirseid'])){
			$result->andWhere('i.intencionreinscribirseid in (:intencionreinscribirseid)')
				->setParameter('intencionreinscribirseid', $filtros['intencionreinscribirseid']);
		}

		if(isset($filtros['sinextraordinarios'])){
			switch($filtros['sinextraordinarios']){
				case 0:
					$result->andHaving('extraordinarios=0');
					break;
				case 1:
					$result->andWhere("e.extraordinarioid IS NOT NULL");
					$result->andHaving("extraordinarios>0");
					break;
			}
		}

		if(isset($filtros['conextraordinariosaprobados'])){
			switch($filtros['conextraordinariosaprobados']){
				case 0:
					$result->andHaving("extraordinariosaprobados=0");
					break;
				case 1:
					$result->andHaving("extraordinariosaprobados>0");
					break;
			}
			$result->andHaving('COUNT(DISTINCT e.extraordinarioid)>0');
		}

		if(isset($filtros['sinreportes'])){
			switch($filtros['sinreportes']){
				case 0:
					$result->andhaving('COUNT(DISTINCT rd.reportedisciplinaid)=0');
					break;
				case 1:
					$reportesNum=(int) $filtros['reporte'];
					$result->andhaving("COUNT(DISTINCT rd.reportedisciplinaid)".($reportesNum>0?"=":">").":reporte")
						->setParameter('reporte', $reportesNum);
			}
		}

		if(isset($filtros['estatuscobranza'])){
			switch($filtros['estatuscobranza']){
				case 1:
					$result->andWhere('calculaAdeudo(a.alumnoid) > 0');
					break;
				case 0:
					$result->andWhere('calculaAdeudo(a.alumnoid) = 0');
					break;
				case 2:
					$result->andWhere('cbacu.acuerdoid IS NOT NULL');
					break;
			}
		}

		if(isset($filtros['matricula'])){
			$escape=array("_", "%");
			$escapados=array("\_", "\%");
			$filtros['matricula']=trim(str_replace($escape, $escapados, $filtros['matricula']));
			$result->andWhere('a.matricula like :matricula')
				->setParameter('matricula', '%'.$filtros['matricula'].'%');
		}

		//Pantalla para agregar al siguiente ciclo (#2). NO deben salir si ya tienen registro en el siguiente ciclo
		if($filtros['alumnoreinscripcion']){
			$result->andWhere('(SELECT COUNT(acc.alumnoporcicloid) FROM AppBundle:CeAlumnoporciclo acc 
            where acc.alumnoid = a.alumnoid 
            AND acc.cicloid = (SELECT cs.cicloid FROM AppBundle:Ciclo cs where cs.siguiente = 1)
			) = 0')
			->andWhere("a.alumnoestatusid = 1");
			
		}
		return $result->getQuery()->getResult();
	}
}