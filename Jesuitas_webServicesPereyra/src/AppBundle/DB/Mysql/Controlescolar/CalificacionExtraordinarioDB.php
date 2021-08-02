<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * @author Emmanuel Martinez
 */
class CalificacionExtraordinarioDB extends BaseDBManager{
	public function getBasicAgendaExtraordinario(){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("a.agendaextraordinarioid AS id",
					"a.agendaextraordinarioid",
					"IDENTITY(a.periodoregularizacionid) AS periodoregularizacionid",
					"IDENTITY(mpe.planestudioid) AS planestudioid",
					"IDENTITY(mpe.materiaid) AS materiaid",
					"CONCAT(m.nombre,' (',a.fechainicio,' ',a.horainicio,')') AS nombre"
				)->from("AppBundle:CeAgendaextraordinario", "a")
				->innerJoin("AppBundle:CeMateriaporplanestudios", "mpe", "WITH", "mpe.materiaporplanestudioid=a.materiaporplanestudioid")
				->innerJoin("AppBundle:Materia", "m", "WITH", "m.materiaid=mpe.materiaid")
				->andWhere("a.estatusagendaextraordinarioid=1")
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
	public function getBasicMateriaPlanEstudioRel(){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cem.materiaid AS m,"
					.	"cepe.planestudioid AS p"
				)->from("AppBundle:CeMateriaporplanestudios", "cempe")
				->innerJoin("AppBundle:CePlanestudios", "cepe", "WITH", "cepe.planestudioid=cempe.planestudioid")
				->innerJoin("AppBundle:Materia", "cem", "WITH", "cem.materiaid=cempe.materiaid")
				//->andWhere("cepe.vigente=1")
				->andWhere("cem.activo=1")
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
	public function getAcuerdoextraordinarioByAgendaextraordinario($agendaextraordinarioid,$estatusid){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("ceae.acuerdoextraordinarioid",
					//Relation data
					"ceage.agendaextraordinarioid",
					"IDENTITY(cempe.materiaid) AS materiaid",
					"IDENTITY(cempe.planestudioid) AS planestudioid",
					"IDENTITY(ceage.profesorid) AS profesorid",
					"IDENTITY(ceae.periodoregularizacionid) AS periodoregularizacionid",
					//Score data
					"ceae.calificacion",
					"ceae.calificacionfinal",
					//Student data
					"cea.matricula",
					"cea.primernombre",
					"cea.segundonombre",
					"cea.apellidopaterno",
					"cea.apellidomaterno",
					"dp.documentoporpagarid",
					"dppe.pagoestatusid"
				)->from("AppBundle:CeAcuerdoextraordinario", "ceae")
				->leftJoin("AppBundle:CjDocumentoporpagar", "dp", "WITH", "dp.documentoporpagarid=ceae.documentoporpagarid")
				->leftJoin("dp.pagoestatusid", "dppe", "WITH", "dp.pagoestatusid=dppe.pagoestatusid")
				->innerJoin("AppBundle:CeExtraordinario", "cee", "WITH", "cee.extraordinarioid=ceae.extraordinarioid")
				->innerJoin("AppBundle:CeAlumno", "cea", "WITH", "cea.alumnoid=cee.alumnoid")
				->innerJoin("AppBundle:CeAgendaextraordinario", "ceage", "WITH", "ceage.agendaextraordinarioid=ceae.agendaextraordinarioid")
				->innerJoin("AppBundle:CeMateriaporplanestudios", "cempe", "WITH", "cempe.materiaporplanestudioid=ceage.materiaporplanestudioid")
				//->innerJoin("ce_periodoregularizacion","cepr","WITH","cepr.periodoregularizacionid=ceae.periodoregularizacionid")
				->andWhere("ceae.estatusextraordinarioid IN (:estatusid)")
				->andWhere("ceage.agendaextraordinarioid=:agendaextraordinarioid")
				->setParameter("agendaextraordinarioid", $agendaextraordinarioid)
				->setParameter("estatusid", $estatusid)
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
}