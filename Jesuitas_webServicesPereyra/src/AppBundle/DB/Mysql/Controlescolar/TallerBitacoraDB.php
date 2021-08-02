<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author Emmanuel Martinez
 */
class TallerBitacoraDB extends BaseDBManager {
	public function getTallerBitacoraByCicloNivel($cicloid,$nivelid,$filter=[]){
		$semestreid=(int) $filter['semestreid'];
		$gradoid=(int) $filter['gradoid'];
		$tallerid=(int) $filter['tallerid'];
		$matricula=trim($filter['matricula']);
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cetb.tallerbitacoraid AS id",
					"cetb.tallerid AS tallerid",
					"IDENTITY(cetb.tipotallerid) AS tipotallerid",
					"IDENTITY(cetb.talleraccionid) AS talleraccionid",
					"IDENTITY(g.nivelid) AS nivelid",
					"g.gradoid",
					"DATE_FORMAT(cetb.fecha,'%d/%m/%Y') AS fecha",
					"cea.matricula",
					"cea.apellidopaterno AS alumnoAPaterno",
					"cea.apellidomaterno AS alumnoAMaterno",
					"cea.primernombre AS alumnoPNombre",
					"cea.segundonombre AS alumnoSNombre",
					"p.apellidopaterno AS usuarioAPaterno",
					"p.nombre AS usuarioNombre",
					"u.cuenta AS usuarioCuenta"
				)->from("AppBundle:CeTallerbitacora","cetb")
				->innerJoin("AppBundle:Usuario","u","WITH","u.usuarioid=cetb.usuarioid")
				->innerJoin("AppBundle:Persona","p","WITH","p.personaid=u.personaid")
				->innerJoin("AppBundle:CeAlumnoporciclo","ceac","WITH","ceac.alumnoporcicloid=cetb.alumnoporcicloid")
				->innerJoin("AppBundle:CeAlumno","cea","WITH","cea.alumnoid=ceac.alumnoid")
				->innerJoin("AppBundle:Grado","g","WITH","g.gradoid=ceac.gradoid")
				->andWhere("ceac.cicloid=:ciclo")
				->andWhere("g.nivelid=:nivel")
				->setParameter("ciclo",$cicloid)
				->setParameter("nivel",$nivelid)
			;
			if($tallerid>0){
				$qb->andWhere("cetb.tallerid=:taller")
					->setParameter("taller",$tallerid);
			}
			if($gradoid>0){
				$qb->andWhere("g.gradoid=:grado")
					->setParameter("grado",$gradoid);
			}
			if($semestreid>0){
				$qb->andWhere("g.semestreid=:semestre")
					->setParameter("semestre",$semestreid);
			}
			if(!empty($matricula)){
				$qb->andWhere("cea.matricula LIKE :matricula")
					->setParameter("matricula","%$matricula%");
			}
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}

	public function getBasicTallerCurricularBitacora(){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cetc.tallercurricularid AS id",
					"IDENTITY(cetc.cicloid) AS cicloid",
					"cetc.nombre",
					"IDENTITY(g.nivelid) AS nivelid",
					"g.gradoid AS gradoid",
					"1 AS tipo"
				)->from("AppBundle:CeTallercurricular","cetc")
				->innerJoin("AppBundle:CeGradoportallercurricular","cegtc","WITH","cegtc.tallercurricularid=cetc.tallercurricularid")
				->innerJoin("AppBundle:Grado","g","WITH","g.gradoid=cegtc.gradoid")
			;
			return $this->buildTallerNArray($qb->getQuery()->getResult());
		}catch(\Exception $e){}
		return false;
	}

	public function getBasicTallerExtracurricularBitacora(){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cetec.tallerextracurricularid AS id",
					"IDENTITY(cetec.cicloid) AS cicloid",
					"cetec.nombre",
					"IDENTITY(g.nivelid) AS nivelid",
					"g.gradoid AS gradoid",
					"2 AS tipo"
				)->from("AppBundle:CeTallerextracurricular","cetec")
				->innerJoin("AppBundle:CeGradoportallerextracurricular","cegtec","WITH","cegtec.tallerextracurricularid=cetec.tallerextracurricularid")
				->innerJoin("AppBundle:Grado","g","WITH","g.gradoid=cegtec.gradoid")
			;
			return $this->buildTallerNArray($qb->getQuery()->getResult());
		}catch(\Exception $e){}
		return false;
	}

	private function buildTallerNArray($data){
		$rel=array();
		$res=array();
		foreach($data AS $i){
			$id=$i['id'];
			if(!isset($rel[$id])){
				$ty=array(
						"id"=>$id,
						"cicloid"=>(int) $i['cicloid'],
						"nombre"=>$i['nombre'],
						"tipo"=>$i['tipo'],
						"nivel"=>array(),
						"grado"=>array());
				$res[]=$id;
				$rel[$id]=$ty;
			}
			$t=&$rel[$id];
			$t['nivel'][]=(int) $i['nivelid'];
			$t['grado'][]=(int) $i['gradoid'];
		}
		foreach($res AS $k=> $i){
			$res[$k]=$rel[$i];
		}
		return $res;
	}
}