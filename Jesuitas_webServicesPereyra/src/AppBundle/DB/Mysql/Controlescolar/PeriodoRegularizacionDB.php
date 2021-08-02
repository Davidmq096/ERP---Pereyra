<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author Emmanuel Martinez
 */
class PeriodoRegularizacionDB extends BaseDBManager {
	public function getPeriodoregularizacionTouchingDates($cicloid,$fechainicio,$fechafin,$id=null){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cepr.periodoregularizacionid")
				->from("AppBundle:CePeriodoregularizacion","cepr")
				->andWhere("cepr.cicloid=:ciclo")
				->andWhere("("
					//Todo lo que inicie en este periodo
					. "(:fini<=cepr.fechainicio AND cepr.fechainicio<=:ffin)"
					//Todo lo que termine en este periodo
					. "OR (:fini<=cepr.fechafin AND cepr.fechafin<=:ffin)"
					//Todo lo que englobe este periodo
					. "OR (cepr.fechainicio<=:fini AND :ffin<=cepr.fechafin)"
				. ")")
				->setParameter("ciclo",$cicloid)
				->setParameter("fini",$fechainicio)
				->setParameter("ffin",$fechafin)
			;
			if($id){
				$qb->andWhere("cepr.periodoregularizacionid!=:periodoregularizacion")
					->setParameter("periodoregularizacion",$id);
			}
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
	public function getPeriodoregularizacionLikeNombre($cicloid,$nombre,$id=null){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cepr.periodoregularizacionid")
				->from("AppBundle:CePeriodoregularizacion","cepr")
				->andWhere("cepr.cicloid=:cicloid")
				->andWhere("cepr.nombre=:nombre")
				->setParameter("cicloid",$cicloid)
				->setParameter("nombre",$nombre)
			;
			if($id){
				$qb->andWhere("cepr.periodoregularizacionid!=:periodoregularizacion")
					->setParameter("periodoregularizacion",$id);
			}
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
}