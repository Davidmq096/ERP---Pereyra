<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author Emmanuel Martinez
 */
class ConductaDB extends BaseDBManager{
	public function getBasicPeriodoEvaluacion(){
		$pe=$this->getPeriodoEvaluacion();
		$peg=$this->getPeriodoEvaluacionGrado();
		if($pe!=false && $peg!=false){
			$per=[];
			foreach($peg AS $i){
				$k=$i['conjuntoperiodoevaluacionid'];
				if(!isset($per[$k])){ $per[$k]=[]; }
				$per[$k][]=(int) $i['gradoid'];
			}
			foreach($pe AS $k=>$i){
				$d=$per[$i['conjuntoperiodoevaluacionid']];
				$pe[$k]['gradoid']=($d?$d:[]);
				$pe[$k]['nombre']=$i['descripcion'];
			}
			return $pe;
		}
		return false;
	}
	public function getPeriodoEvaluacion(){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cepe.periodoevaluacionid AS id,"
					. "cepe.periodoevaluacionid,"
					. "cecpe.conjuntoperiodoevaluacionid,"
					. "IDENTITY(cecpe.cicloid) AS cicloid,"
					. "cepe.descripcion,"
					. "cepe.descripcioncorta"
				)->from("AppBundle:CePeriodoevaluacion", "cepe")
				->innerJoin("AppBundle:CeConjuntoperiodoevaluacion", "cecpe", "WITH", "cecpe.conjuntoperiodoevaluacionid=cepe.conjuntoperiodoevaluacionid")
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){ return false; }
	}
	public function getPeriodoEvaluacionGrado(){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cegcpe.gradoporconjuntoperiodoescolarid AS id,"
					. "cegcpe.gradoporconjuntoperiodoescolarid,"
					. "IDENTITY(cegcpe.conjuntoperiodoevaluacionid) AS conjuntoperiodoevaluacionid,"
					. "IDENTITY(cegcpe.gradoid) AS gradoid"
				)->from("AppBundle:CeGradoporconjuntoperiodoescolar", "cegcpe")
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){ return false; }
	}
	public function getAlumnocicloporgrupoById($alumnocicloporgrupoid){
		try{
			$qb=$this->getAlumnocicloporgrupoQB();
			$qb->andWhere("ceacg.alumnocicloporgrupo=:alumnocicloporgrupo")
				->setParameter("alumnocicloporgrupo",$alumnocicloporgrupoid)
			;
			return $qb->getQuery()->getResult()[0];
		}catch(\Exception $e){return false; }
	}
	public function getAlumnosByGrupo($grupoid){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("ceacg.alumnocicloporgrupo,ceac.alumnoporcicloid,cea.alumnoid,cea.primernombre,cea.apellidopaterno,cea.apellidomaterno,cea.matricula,ceacg.alumnocicloporgrupo as id,ceacg.numerolista"
				)->from("AppBundle:CeAlumnocicloporgrupo", "ceacg")
				->innerJoin("AppBundle:CeAlumnoporciclo", "ceac", "WITH", "ceac.alumnoporcicloid=ceacg.alumnoporcicloid")
				->innerJoin("AppBundle:CeAlumno", "cea", "WITH", "cea.alumnoid=ceac.alumnoid");

			$qb->andWhere("ceacg.grupoid=" . $grupoid);
			$qb->orderBy('ceacg.numerolista');
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){ 
			return false; 
		}
	}
	public function getAlumnocicloporgrupoByGrupo($grupoid){
		try{
			$qb=$this->getAlumnocicloporgrupoQB();
			$qb->andWhere("ceacg.grupoid=:grupo")
				->setParameter("grupo",$grupoid)
				->orderBy("ceacg.numerolista","ASC")
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){ return false; }
	}
	private function getAlumnocicloporgrupoQB(){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("ceacg.alumnocicloporgrupo AS id,"
					. "ceacg.alumnocicloporgrupo,"
					. "ceac.alumnoporcicloid,"
					. "cea.alumnoid,"
					. "ceacg.numerolista,"
					. "cea.primernombre,"
					. "cea.segundonombre,"
					. "cea.apellidopaterno,"
					. "cea.apellidomaterno,"
					. "cea.matricula"
				)->from("AppBundle:CeAlumnocicloporgrupo", "ceacg")
				->innerJoin("AppBundle:CeAlumnoporciclo", "ceac", "WITH", "ceac.alumnoporcicloid=ceacg.alumnoporcicloid")
				->innerJoin("AppBundle:CeAlumno", "cea", "WITH", "cea.alumnoid=ceac.alumnoid")
			;
			return $qb;
		}catch(\Exception $e){ return false; }
	}
	public function getMateriasById($materiaid){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("m.materiaid AS id,"
					. "m.materiaid,"
					. "m.nombre,"
					. "m.clave"
				)->from("AppBundle:Materia", "m")
				->andWhere("m.materiaid IN (:materia)")
				->setParameter("materia",$materiaid)
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){ return false; }
	}
	public function getMateriasplanestudioById($materiaplanestudioid){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cempe.materiaporplanestudioid AS id,"
					. "cempe.materiaporplanestudioid,"
					. "m.materiaid,"
					. "m.nombre,"
					. "cempe.materiaporplanestudioid,"
					. "cempe.requieremaestrotitular"
				)->from("AppBundle:CeMateriaporplanestudios", "cempe")
				->innerJoin("AppBundle:Materia", "m", "WITH", "m.materiaid=cempe.materiaid")
				->andWhere("cempe.materiaporplanestudioid IN (:materiape)")
				->setParameter("materiape",$materiaplanestudioid)
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){ return false; }
	}
	public function getCalificacionconductaByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cecc.conductacalificacionid AS id,"
					. "cecc.conductacalificacionid,"
					. "IDENTITY(cecc.alumnocicloporgrupoid) AS alumnocicloporgrupo,"
					. "IDENTITY(cecc.periodoevaluacionid) AS periodoevaluacionid,"
					. "m.materiaid AS materiaid,"
					. "cecc.calificacion,"
					. "cecc.titular"
				)->from("AppBundle:CeConductacalificacion", "cecc")
				->innerJoin("AppBundle:CeMateriaporconductacalificacion", "cemcc", "WITH", "cemcc.conductacalificacionid=cecc.conductacalificacionid")
				->innerJoin("AppBundle:Materia", "m", "WITH", "m.materiaid=cemcc.materiaid")
				->andWhere("cecc.alumnocicloporgrupoid=:alumnociclogrupo")
				->andWhere("cecc.periodoevaluacionid=:periodoevaluacion")
				->setParameter("alumnociclogrupo",$alumnocicloporgrupoid)
				->setParameter("periodoevaluacion",$periodoevaluacionid)
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){ return false; }			
	}
	public function getConductacalificacionescala(){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cecce.conductacalificacionescalaid AS id,"
					. "cecce.conductacalificacionescalaid,"
					. "cecce.minimo,"
					. "cecce.maximo,"
					. "cecce.resultado"
				)->from("AppBundle:CeConductacalificacionescala", "cecce")
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){ return false; }			
	}
	public function getPromedioByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid){
		$titular=false;
		$notitular=[];
		$promedioar=[];
		foreach($this->getCalificacionconductaByPeriodoevaluacionAlumnociclogrupo($periodoevaluacionid,$alumnocicloporgrupoid) AS $i){
			($i['titular']
				? $titular=$i['calificacion']
				: $notitular[]=$i['calificacion']
			);
		}
		if($titular!==false){ $promedioar[]=$titular; }
		$notitularsz=sizeof($notitular);
		if($notitularsz>0){
			$notitularsuma=0;
			foreach($notitular AS $i){ $notitularsuma+=$i; }
			$promedioar[]=($notitularsuma/$notitularsz);
		}
		$promedio=0;
		$promediosz=sizeof($promedioar);
		if($promediosz>0){
			$promediosuma=0;
			foreach($promedioar AS $i){
				$promediosuma+=($i);//only integers
			}
			$promedio=$promediosuma/$promediosz;
			$promedio=$promedio;//only integers
		}
		$escalas=$this->getConductacalificacionescala();
		$escala="";
		foreach($escalas AS $i){
			if($i['minimo']<=$promedio && $promedio<$i['maximo']){
				$escala=$i['resultado'];
			}
		}
		return [
			"calificacion"=>$promedio,
			"escala"=>$escala
		];
	}
}