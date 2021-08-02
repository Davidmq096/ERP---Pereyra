<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author Emmanuel Martinez
 */
class AlumnoIdiomaNivelDB extends BaseDBManager {
	public function getAlumnoByCicloNivelGrado($cicloid,$nivelid,$gradoid,$filter=[]){
		$statusid=(int) $filter['statusid'];
		$idiomaid=(int) $filter['idiomaid'];
		$idiomanivelid=(int) $filter['idiomanivelid'];
		$matricula=trim($filter['matricula']);
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("ceacin.alumnocicloporidiomanivelid,"
					."ceac.alumnoporcicloid AS id,"
					."c.cicloid,"
					."n.nivelid,"
					."g.gradoid,"
					."ceg.grupoid,"
					."cei.idiomaid,"
					."cein.idiomanivelid,"
					."c.nombre AS ciclo,"
					."n.nombre As nivel,"
					."g.grado AS grado,"
					."ceg.nombre AS grupo,"
					."cei.nombre AS idioma,"
					."cein.nombre AS idiomanivel,"
					."cein.clave AS idiomanivelclave,"
					."cea.matricula,"
					."cea.apellidopaterno AS apaterno,"
					."cea.apellidomaterno AS amaterno,"
					."cea.primernombre AS nombre"
				)->from("AppBundle:CeAlumnoporciclo", "ceac")
				->innerJoin("AppBundle:CeAlumno", "cea", "WITH", "cea.alumnoid=ceac.alumnoid")
				->innerJoin("AppBundle:Ciclo", "c", "WITH", "c.cicloid=ceac.cicloid")
				->innerJoin("AppBundle:Grado", "g", "WITH", "g.gradoid=ceac.gradoid")
				->innerJoin("AppBundle:Nivel", "n", "WITH", "n.nivelid=g.nivelid")
				->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ceacg", "WITH", "ceacg.alumnoporcicloid=ceac.alumnoporcicloid")
				->leftJoin("AppBundle:CeGrupo", "ceg", "WITH", "ceg.grupoid=ceacg.grupoid")
				->leftJoin("AppBundle:CeAlumnocicloporidiomanivel", "ceacin", "WITH", "ceacin.alumnoporcicloid=ceac.alumnoporcicloid")
				->leftJoin("AppBundle:CeIdiomanivel", "cein", "WITH", "cein.idiomanivelid=ceacin.idiomanivelid")
				->leftJoin("AppBundle:CeIdioma", "cei", "WITH", "cei.idiomaid=cein.idiomaid")
				->andWhere("(ceacg.grupoid IS NULL OR ceg.tipogrupoid=1)")
				->andWhere("ceac.cicloid=:ciclo")
				->andWhere("g.nivelid=:nivel")
				->andWhere("g.gradoid=:grado")
				->andWhere("cea.alumnoestatusid = 1")
				->setParameter("ciclo", $cicloid)
				->setParameter("nivel", $nivelid)
				->setParameter("grado", $gradoid)
			;
			if($idiomaid && $idiomaid > 0){
				$qb->andWhere("cei.idiomaid=:idioma")
					->setParameter("idioma", $idiomaid);
			}
			if($idiomanivelid && $idiomanivelid > 0){
				$qb->andWhere("cein.idiomanivelid=:idiomanivel")
					->setParameter("idiomanivel", $idiomanivelid);
			}
			if(strlen($matricula) > 0){
				$qb->andWhere("cea.matricula=:matricula")
					->setParameter("matricula", $matricula);
			}
			if($statusid > 0){
				if($statusid==1){
					$qb->andWhere("cein.idiomanivelid IS NOT NULL");
				}else if($statusid==2){
					$qb->andWhere("cein.idiomanivelid IS NULL");
				}
			}
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
}