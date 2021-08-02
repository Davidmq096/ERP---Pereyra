<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Extraordinario
 *
 * @author Mariano
 */
class ExtraordinarioDB extends BaseDBManager 
{
    public function BuscarExtraordinario($filtros) 
    {

		$qb = $this->em->createQueryBuilder();
        $grupoarea = $qb->select('IDENTITY(gt.areaespecializacionid)')
			->from("AppBundle:CeAlumnocicloporgrupo", "acgt")
			->innerJoin("AppBundle:CeGrupo", "gt", Expr\Join::WITH, "gt.grupoid = acgt.grupoid and gt.tipogrupoid = 1")
			->where("acgt.alumnoporcicloid = apct.alumnoporcicloid");
		
		$qb = $this->em->createQueryBuilder();
		$acuerdomax = $qb->select('MAX(ac3.acuerdoextraordinarioid)')
			->from("AppBundle:CeAcuerdoextraordinario", "ac3")
			->innerJoin("AppBundle:CeExtraordinario", "e2", Expr\Join::WITH, "e2.extraordinarioid = ac3.extraordinarioid")
			->where("e2.extraordinarioid = e.extraordinarioid");
		
		$qb = $this->em->createQueryBuilder();
		$lastcal = $qb->select("MAX(CASE WHEN ac5.calificacionfinal IS NOT NULL THEN ac5.calificacionfinal ELSE '' END)")
			->from("AppBundle:CeAcuerdoextraordinario", "ac5")
			->innerJoin("AppBundle:CeExtraordinario", "e4", Expr\Join::WITH, "e4.extraordinarioid = ac5.extraordinarioid")
			->where("e4.extraordinarioid = e.extraordinarioid");	

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("e.extraordinarioid as id,a.matricula,concat_ws(' ',a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre) as alumno,
		CASE WHEN c.cicloid IS NOT NULL THEN c.cicloid  ELSE ct.cicloid as cicloid,count(DISTINCT(asi.asistenciaid)) faltas, 
		CASE WHEN c.cicloid IS NOT NULL THEN c.nombre  ELSE ct.nombre END as ciclo, 
		CASE WHEN n.nombre IS NOT NULL THEN n.nombre ELSE npet.nombre END as nivel,
		CASE WHEN n.nivelid IS NOT NULL THEN n.nivelid ELSE npet.nivelid END as nivelid,
		CASE WHEN gpe.grado IS NOT NULL THEN gpe.grado ELSE gpet.grado END as grado,
		CASE WHEN gpe.gradoid IS NOT NULL THEN gpe.gradoid ELSE gpet.gradoid END as gradoid,
		CASE WHEN pe.planestudioid IS NOT NULL THEN pe.nombre ELSE pet.nombre END as planestudio,
		CASE WHEN m.nombre IS NOT NULL THEN m.nombre ELSE mt.nombre END as materia, 
		CASE WHEN m.materiaid IS NOT NULL THEN m.materiaid ELSE mt.materiaid END as materiaid,
		CASE WHEN ae4.acuerdoextraordinarioid is not null then eae2.nombre else ee.nombre as estatus,
		me.nombre as motivo,ae.acuerdoextraordinarioid,ae.intento,eae.nombre as estatusacuerdo,
		t.tipoextraordinarioid,t.nombre as tipo,p.periodoregularizacionid,p.nombre as periodo,u.cuenta as acordadopor,
		age.agendaextraordinarioid,
		CASE WHEN mpe.materiaporplanestudioid IS NOT NULL THEN mpe.materiaporplanestudioid ELSE mpet.materiaporplanestudioid END as materiaporplanestudioid,
		ae.calificacion,ae.calificacionfinal,a.alumnoid")
		->addSelect("(" . $lastcal . ") as calificaciondefinitiva")
        ->from("AppBundle:CeExtraordinario","e")
        ->innerJoin("AppBundle:CeEstatusextraordinario", "ee", Expr\Join::WITH, "ee.estatusextraordinarioid=e.estatusextraordinarioid")
        ->leftJoin("AppBundle:CeMotivoextraordinarioporextraordinario", "mee", Expr\Join::WITH, "mee.extraordinarioid=e.extraordinarioid")
        ->leftJoin("AppBundle:CeMotivoextraordinario", "me", Expr\Join::WITH, "me.motivoextraordinarioid=mee.motivoextraordinarioid")
        ->leftJoin("AppBundle:CeAcuerdoextraordinario", "ae", Expr\Join::WITH, "ae.extraordinarioid=e.extraordinarioid")
        ->leftJoin("AppBundle:CeEstatusextraordinario", "eae", Expr\Join::WITH, "eae.estatusextraordinarioid=ae.estatusextraordinarioid")
        ->leftJoin("AppBundle:CeTipoextraordinario", "t", Expr\Join::WITH, "t.tipoextraordinarioid=ae.tipoextraordinarioid")
        ->leftJoin("AppBundle:CePeriodoregularizacion", "p", Expr\Join::WITH, "p.periodoregularizacionid=ae.periodoregularizacionid")
        ->leftJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.usuarioid=ae.usuarioid")
        ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid=e.alumnoid")
        ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe", Expr\Join::WITH, "pmpe.profesorpormateriaplanestudiosid=e.profesorpormateriaplanestudiosid")
        ->leftJoin("AppBundle:CeMateriaporplanestudios", "mpe", Expr\Join::WITH, "mpe.materiaporplanestudioid=pmpe.materiaporplanestudioid")
		->leftJoin("AppBundle:CePlanestudios", "pe", Expr\Join::WITH, "pe.planestudioid=mpe.planestudioid")
		->leftJoin("AppBundle:Grado", "gpe", Expr\Join::WITH, "gpe.gradoid=pe.gradoid")
		->leftJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid=gpe.nivelid")
		->leftJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid=mpe.materiaid")
        ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "gr.grupoid = pmpe.grupoid")
		->leftJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid=gr.cicloid")
		
        ->leftJoin("AppBundle:CeTallercurricular", "tc", Expr\Join::WITH, "tc.tallercurricularid = pmpe.tallerid")
        ->leftJoin("AppBundle:CeGradoportallercurricular", "gtc", Expr\Join::WITH, "gtc.tallercurricularid = tc.tallercurricularid")
		->leftJoin("AppBundle:CeAlumnoporciclo", "apct", Expr\Join::WITH, "apct.alumnoid = e.alumnoid and apct.cicloid = tc.cicloid and apct.gradoid = gtc.gradoid")

		->leftJoin("AppBundle:CeMateriaporplanestudios", "mpet", Expr\Join::WITH, "mpet.materiaporplanestudioid = gtc.materiaporplanestudioid")
		->leftJoin("AppBundle:CePlanestudios", "pet", Expr\Join::WITH, "pet.planestudioid=mpet.planestudioid and (pet.areaespecializacionid = (" . $grupoarea . ") or pet.areaespecializacionid is null)")
		->leftJoin("AppBundle:Grado", "gpet", Expr\Join::WITH, "gpet.gradoid=pet.gradoid")
		->leftJoin("AppBundle:Nivel", "npet", Expr\Join::WITH, "npet.nivelid=gpet.nivelid")
		->leftJoin("AppBundle:Ciclo", "ct", Expr\Join::WITH, "ct.cicloid=tc.cicloid")
        ->leftJoin("AppBundle:Materia", "mt", Expr\Join::WITH, "mt.materiaid=mpet.materiaid")
		
		->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid=a.alumnoid and (ac.cicloid =c.cicloid or ac.cicloid = ct.cicloid )")
        ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid=ac.gradoid")

		->leftJoin("AppBundle:CeAsistencia","asi","WITH","asi.alumnoporcicloid = ac.alumnoporcicloid and asi.profesorpormateriaplanestudioid = pmpe.profesorpormateriaplanestudiosid and asi.tipoasistenciaid = 2 and asi.estatusinasistenciaid = 1 ")

		->leftJoin("AppBundle:CeAcuerdoextraordinario", "ae4", Expr\Join::WITH, "ae4.acuerdoextraordinarioid = (" . $acuerdomax . ")")
		->leftJoin("ae4.periodoregularizacionid", "pr2")
		->leftJoin("AppBundle:CeEstatusextraordinario", "eae2", Expr\Join::WITH, "eae2.estatusextraordinarioid=ae4.estatusextraordinarioid")


        ->leftJoin("AppBundle:CeAgendaextraordinario", "age", Expr\Join::WITH, "age.agendaextraordinarioid=ae.agendaextraordinarioid")
        ->groupBy('ae.acuerdoextraordinarioid, a.alumnoid, e.extraordinarioid');
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid = :cicloid or ct.cicloid = :cicloid')
        	->setParameter('cicloid' , $filtros['cicloid']);
        }
        if (isset($filtros['extraordinarioid'])) {
        	$result->andWhere('e.extraordinarioid = :extraordinarioid')
        	->setParameter('extraordinarioid' , $filtros['extraordinarioid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid) or npet.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('gpe.gradoid = :gradoid or gpet.gradoid = :gradoid')
        	->setParameter('gradoid' , $filtros['gradoid']);
        }
        if (isset($filtros['periodoregularizacionid'])) {
        	$result->andWhere('ae4.periodoregularizacionid = :periodoregularizacionid')
        	->setParameter('periodoregularizacionid' , $filtros['periodoregularizacionid']);
        }
        if (isset($filtros['materiaporplanestudioid'])) {
        	$result->andWhere('mpe.materiaporplanestudioid = :materiaporplanestudioid or mpet.materiaporplanestudioid = :materiaporplanestudioid')
        	->setParameter('materiaporplanestudioid' , $filtros['materiaporplanestudioid']);
        }
        if (isset($filtros['matricula']) && !empty($filtros['matricula'])) {
        	$result->andWhere('a.matricula = :matricula')
        	->setParameter('matricula' , $filtros['matricula']);
        }
        if (isset($filtros['tipoextraordinarioid'])) {
        	$result->andWhere('ae.tipoextraordinarioid = :tipoextraordinarioid')
        	->setParameter('tipoextraordinarioid' , $filtros['tipoextraordinarioid']);
        }
        if (isset($filtros['estatusextraordinarioid'])) {
        	$result->andWhere('e.estatusextraordinarioid = :estatusextraordinarioid')
        	->setParameter('estatusextraordinarioid' , $filtros['estatusextraordinarioid']);
        }
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('a.alumnoid = :alumnoid')
        	->setParameter('alumnoid' , $filtros['alumnoid']);
        }
        if (isset($filtros['escurricular'])) {
        	$result->andWhere('mpe.escurricular = :escurricular')
        	->setParameter('escurricular' , $filtros['escurricular']);
        }
        $result->orderBy("e.extraordinarioid,ae.acuerdoextraordinarioid,ae.intento");
        
        return $result->getQuery()->getResult();
    }

    public function BuscarExtraordinarioAlumno($id, $alumnocicloid, $periodo) {

		$qb = $this->em->createQueryBuilder();
        $grupoarea = $qb->select('IDENTITY(gt.areaespecializacionid)')
			->from("AppBundle:CeAlumnocicloporgrupo", "acgt1")
			->innerJoin("AppBundle:CeGrupo", "gt", Expr\Join::WITH, "gt.grupoid = acgt1.grupoid and gt.tipogrupoid = 1")
            ->where("acgt1.alumnoporcicloid = apct.alumnoporcicloid");

        $qb1=$this->em->createQueryBuilder();
        $acuerdo = $qb1->select("MAX(ae.acuerdoextraordinarioid)")
            ->from("AppBundle:CeExtraordinario", 'ex')
            ->innerJoin("AppBundle:CeEstatusextraordinario", "ee", Expr\Join::WITH, "ee.estatusextraordinarioid = ex.estatusextraordinarioid")
            ->innerJoin("AppBundle:CeAcuerdoextraordinario", "ae", Expr\Join::WITH, "ae.extraordinarioid = ex.extraordinarioid ")
            ->innerJoin("AppBundle:CeAlumnoporciclo", "apci", Expr\Join::WITH, "apci.alumnoid = ex.alumnoid")
            ->andWhere("apci.alumnoporcicloid=:alumnociclo")
            ->andWhere("ee.estatusextraordinarioid IN (1,2,3,4,5)")
            ->setParameter("alumnociclo",$alumnocicloid)
            ->groupBy("ex.extraordinarioid");

		$acdq=$acuerdo->getQuery()->getResult();
		
				
		$qb = $this->em->createQueryBuilder();
		$lastcal = $qb->select("MAX(CASE WHEN ac5.calificacionfinal IS NOT NULL THEN ac5.calificacionfinal ELSE '' END)")
			->from("AppBundle:CeAcuerdoextraordinario", "ac5")
			->innerJoin("AppBundle:CeExtraordinario", "e4", Expr\Join::WITH, "e4.extraordinarioid = ac5.extraordinarioid")
			->where("e4.extraordinarioid = e.extraordinarioid");	
        
        $qb = $this->em->createQueryBuilder();
		$result = $qb->select('e.extraordinarioid','ae.acuerdoextraordinarioid','g.gradoid as gg','pet1.planestudioid ffa',
		'case when  m.nombre is not null then m.nombre else mt.nombre end as materia, 
		case when c.cicloid IS NOT NULL THEN c.cicloid  ELSE ct.cicloid END as cicloid, 
		case when m.materiaid is not null then m.materiaid else mt.materiaid end materiaid, 
		case when neg.nombre is not null then neg.nombre else npet.nombre end as nivel, 
		case when neg.nivelid is not null then neg.nivelid else npet.nivelid end as nivelid,
		case when peg.grado is not null then peg.grado else gpet.grado end as grado,  
		case when peg.gradoid is not null then peg.gradoid else gpet.gradoid end as gradoid,  
		case when mp.escurricular is not null then mp.escurricular else mpet.escurricular as curricular, 
		case when mp.materiaporplanestudioid is not null then mp.materiaporplanestudioid else mpet1.materiaporplanestudioid as materiaporplanestudioid,
		ee.estatusextraordinarioid,
		case when ae.acuerdoextraordinarioid is not null then eae2.nombre else ee.nombre as estatus', 
		'meo.nombre as motivo', 'pr.periodoregularizacionid', 'te.tipoextraordinarioid', "DATE_FORMAT(ag.fechainicio, '%d/%m/%Y') as fechainicio", "DATE_FORMAT(ag.fechafin, '%d/%m/%Y') as fechafin", 'ag.horainicio',"DATE_FORMAT(ag.horafin,'%H:%i:%s') as horafin",
        'l.lugarid','l.nombre as lugaraplicacion', "DATE_FORMAT(ag.fecharevision, '%d/%m/%Y') as fecharevision", "DATE_FORMAT(ag.horainiciorevision, '%H:%i:%s') as horainiciorevision",
         "DATE_FORMAT(ag.horafinrevision, '%H:%i:%s') as horafinrevision", 'lu.nombre as lugarrevision', 'ag.comentarios', "concat_ws(' ',a.apellidopaterno,a.apellidomaterno,a.primernombre) as nombrecompleto", 'a.apellidopaterno','a.apellidomaterno','a.primernombre',
		 'a.matricula', 'te.nombre as tipoextraordinario', 'aco.correo', 'a.alumnoid', 'up.usuarioid as usuarioprofesorid')
		->addSelect("(" . $lastcal . ") as calificaciondefinitiva")
        ->from("AppBundle:CeExtraordinario", 'e')
        ->leftJoin("AppBundle:CeAcuerdoextraordinario", "ae", Expr\Join::WITH, "ae.extraordinarioid = e.extraordinarioid ")
		->leftJoin("AppBundle:CeEstatusextraordinario", "eae2", Expr\Join::WITH, "eae2.estatusextraordinarioid = ae.estatusextraordinarioid")
		->leftJoin("AppBundle:CeAgendaextraordinario", "ag", Expr\Join::WITH, "ag.agendaextraordinarioid = ae.agendaextraordinarioid ")
        ->leftJoin("AppBundle:CePeriodoregularizacion", "pr", Expr\Join::WITH, "pr.periodoregularizacionid = ae.periodoregularizacionid ")
        ->leftJoin('AppBundle:CeTipoextraordinario', 'te', Expr\Join::WITH, "te.tipoextraordinarioid = ae.tipoextraordinarioid")
        ->innerJoin("AppBundle:CeMotivoextraordinarioporextraordinario", "me", Expr\Join::WITH, "me.extraordinarioid = e.extraordinarioid ")
        ->innerJoin("AppBundle:CeMotivoextraordinario", "meo", Expr\Join::WITH, "meo.motivoextraordinarioid = me.motivoextraordinarioid ")
        ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmp", Expr\Join::WITH, "pmp.profesorpormateriaplanestudiosid = e.profesorpormateriaplanestudiosid ")
        ->leftJoin("AppBundle:CeProfesor", "prof", Expr\Join::WITH, "prof.profesorid = pmp.profesorid ")
        ->leftJoin("AppBundle:Usuario", "up", Expr\Join::WITH, "up.profesorid = prof.profesorid ")
        ->leftJoin("AppBundle:CeMateriaporplanestudios", "mp", Expr\Join::WITH, "mp.materiaporplanestudioid = pmp.materiaporplanestudioid")
        ->leftJoin("AppBundle:CePlanestudios", "pe", Expr\Join::WITH, "pe.planestudioid = mp.planestudioid")
		->leftJoin("AppBundle:Grado", "peg", Expr\Join::WITH, "peg.gradoid = pe.gradoid")
		->leftJoin("AppBundle:Nivel", "neg", Expr\Join::WITH, "neg.nivelid = peg.nivelid")
		->innerJoin("AppBundle:CeEstatusextraordinario", "ee", Expr\Join::WITH, "ee.estatusextraordinarioid = e.estatusextraordinarioid")
        ->leftJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid = mp.materiaid")
        ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = e.alumnoid")
        ->innerJoin("AppBundle:CeAlumnoporciclo", "apc", Expr\Join::WITH, "apc.alumnoid = e.alumnoid and apc.alumnoporcicloid = ".$alumnocicloid)
        ->leftJoin("AppBundle:CeAlumnocorreo", "aco", Expr\Join::WITH, "aco.alumnoid = apc.alumnoid")
		->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid = apc.gradoid")
		->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "gr.grupoid = pmp.grupoid")
		->leftJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid=gr.cicloid")

        ->leftJoin("AppBundle:CeTallercurricular", "tc", Expr\Join::WITH, "tc.tallercurricularid = pmp.tallerid")
        ->leftJoin("AppBundle:CeGradoportallercurricular", "gtc", Expr\Join::WITH, "gtc.tallercurricularid = tc.tallercurricularid")
		->leftJoin("AppBundle:CeAlumnoporciclo", "apct", Expr\Join::WITH, "apct.alumnoid = e.alumnoid and apct.cicloid = tc.cicloid and apct.gradoid = gtc.gradoid")

		->leftJoin("AppBundle:CeMateriaporplanestudios", "mpet", Expr\Join::WITH, "mpet.materiaporplanestudioid = gtc.materiaporplanestudioid")
		->leftJoin("AppBundle:CePlanestudios", "pet", Expr\Join::WITH, "pet.planestudioid=mpet.planestudioid and (pet.areaespecializacionid = (" . $grupoarea . ") or pet.areaespecializacionid is null)")
		->leftJoin("AppBundle:CeMateriaporplanestudios", "mpet1", Expr\Join::WITH, "mpet1.materiaporplanestudioid = gtc.materiaporplanestudioid and mpet1.planestudioid = pet.planestudioid")
		->leftJoin("AppBundle:CePlanestudios", "pet1", Expr\Join::WITH, "pet1.planestudioid=mpet1.planestudioid")
		->leftJoin("AppBundle:Grado", "gpet", Expr\Join::WITH, "gpet.gradoid=pet1.gradoid")
		->leftJoin("AppBundle:Nivel", "npet", Expr\Join::WITH, "npet.nivelid=gpet.nivelid")
		->leftJoin("AppBundle:Ciclo", "ct", Expr\Join::WITH, "ct.cicloid=tc.cicloid")
        ->leftJoin("AppBundle:Materia", "mt", Expr\Join::WITH, "mt.materiaid=mpet.materiaid")

        ->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid = g.nivelid")
        ->leftJoin("AppBundle:Lugar", "l", Expr\Join::WITH, "l.lugarid = ag.lugarid")
        ->leftJoin("AppBundle:Lugar", "lu", Expr\Join::WITH, "lu.lugarid = ag.lugarrevisionid")
        ->andWhere("e.alumnoid = $id")
        //->andWhere("apc.alumnoporcicloid = :alumnociclo")
        ->andWhere("ee.estatusextraordinarioid IN (1,2,3,4,5)")
        ->andWhere("ae.acuerdoextraordinarioid IN (:acuerdosids) or ae.acuerdoextraordinarioid IS NULL")
        //->setParameter("alumnociclo",$alumnocicloid)
		->setParameter("acuerdosids",$acdq)
		->having("materiaporplanestudioid is not null")
		->groupBy("e.extraordinarioid, mpet1.materiaporplanestudioid");
		
		if (isset($periodo)) {
        	$result->andWhere('pr.periodoregularizacionid = :periodoregularizacionid')
        	->setParameter('periodoregularizacionid' , $periodo);
        }

        return $result->getQuery()->getResult();
    }

    public function CheckCursoAlumno($filtros) {

		$qb = $this->em->createQueryBuilder();
        $grupoarea = $qb->select('IDENTITY(gt.areaespecializacionid)')
			->from("AppBundle:CeAlumnocicloporgrupo", "acgt1")
			->innerJoin("AppBundle:CeGrupo", "gt", Expr\Join::WITH, "gt.grupoid = acgt1.grupoid and gt.tipogrupoid = 1")
			->where("acgt1.alumnoporcicloid = apct.alumnoporcicloid");
			

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('e.extraordinarioid','ae.acuerdoextraordinarioid')
        ->from("AppBundle:CeAcuerdoextraordinario", 'ae')
        ->innerJoin("AppBundle:CeExtraordinario", "e", Expr\Join::WITH, "e.extraordinarioid = ae.extraordinarioid ")
        ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmp", Expr\Join::WITH, "pmp.profesorpormateriaplanestudiosid = e.profesorpormateriaplanestudiosid ")
		
		->leftJoin("AppBundle:CeTallercurricular", "tc", Expr\Join::WITH, "tc.tallercurricularid = pmp.tallerid")
		->leftJoin("AppBundle:CeGradoportallercurricular", "gtc", Expr\Join::WITH, "gtc.tallercurricularid = tc.tallercurricularid")
		->leftJoin("AppBundle:CeAlumnoporciclo", "apct", Expr\Join::WITH, "apct.alumnoid = e.alumnoid and apct.cicloid = tc.cicloid and apct.gradoid = gtc.gradoid")

		->leftJoin("AppBundle:CeMateriaporplanestudios", "mpet", Expr\Join::WITH, "mpet.materiaporplanestudioid = gtc.materiaporplanestudioid")
		->leftJoin("AppBundle:CePlanestudios", "pet", Expr\Join::WITH, "pet.planestudioid=mpet.planestudioid and (pet.areaespecializacionid = (" . $grupoarea . ") or pet.areaespecializacionid is null)")

		->leftJoin("AppBundle:CeProfesor", "prof", Expr\Join::WITH, "prof.profesorid = pmp.profesorid ")
        ->leftJoin("AppBundle:CeMateriaporplanestudios", "mp", Expr\Join::WITH, "mp.materiaporplanestudioid = pmp.materiaporplanestudioid")
        ->leftJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid = mp.materiaid")
        ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = e.alumnoid")
        ->groupBy('e.extraordinarioid');
        $result->andWhere("e.alumnoid =" .  $filtros['alumnoid']);
        $result->andWhere("mp.materiaporplanestudioid =" . $filtros['materiaporplanestudioid'] . " or mpet.materiaporplanestudioid =" . $filtros['materiaporplanestudioid']);
        $result->andWhere("ae.tipoextraordinarioid = 1");
        $result->andWhere("ae.estatusextraordinarioid = 5");
        return $result->getQuery()->getResult();
    }

    public function UltimoAcuerdoPorAgenda ($id, $nnull) {
        $cadena = "";
        if ($nnull) {
            $cadena = "and ac.calificacion IS NOT NULL and ac.calificacionfinal IS NOT NULL";
        }
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare("select ac.acuerdoextraordinarioid, ac.calificacion, ac.calificacionfinal, te.nombre as tipoextraordinario
        from ce_acuerdoextraordinario ac
        inner join ce_tipoextraordinario te on te.tipoextraordinarioid = ac.tipoextraordinarioid
        where ac.extraordinarioid = :id $cadena order by ac.acuerdoextraordinarioid desc limit 1");

        $stmt->execute(array('id' => $id));
        $result = $stmt->fetchAll(); 
        return $result;  
    }

    public function BuscarExtraordinarioporacuerdo($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('e.extraordinarioid','ae.acuerdoextraordinarioid')
        ->from("AppBundle:CeAcuerdoextraordinario", 'ae')
        ->innerJoin("AppBundle:CePeriodoregularizacion", "pr", Expr\Join::WITH, "pr.periodoregularizacionid = ae.periodoregularizacionid ")
        ->innerJoin("AppBundle:CeExtraordinario", "e", Expr\Join::WITH, "e.extraordinarioid = ae.extraordinarioid ")
        ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmp", Expr\Join::WITH, "pmp.profesorpormateriaplanestudiosid = e.profesorpormateriaplanestudiosid ")
		->leftJoin("AppBundle:CeProfesor", "prof", Expr\Join::WITH, "prof.profesorid = pmp.profesorid ")
		
        ->innerJoin("AppBundle:CeMateriaporplanestudios", "mp", Expr\Join::WITH, "mp.materiaporplanestudioid = pmp.materiaporplanestudioid")
        ->innerJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid = mp.materiaid")
        ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = e.alumnoid")
        ->groupBy('e.extraordinarioid');
        if (isset($filtros['escurricular'])) {
        	$result->andWhere('mp.escurricular = :escurricular')
        	->setParameter('escurricular' , $filtros['escurricular']);
        }
        $result->andWhere("e.alumnoid =" .  $filtros['alumnoid']);

        if (isset($filtros['periodoregularizacionid'])) {
        	$result->andWhere('pr.periodoregularizacionid = :periodoregularizacionid')
        	->setParameter('periodoregularizacionid' , $filtros['periodoregularizacionid']);
        }

        return $result->getQuery()->getResult();
    }


    public function BuscarPeriodos () {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('p.periodoregularizacionid', 'p.nombre', 'p.fechainicio',
        'p.fechalimiteasignacion')
        ->from("AppBundle:CePeriodoregularizacion", 'p')
        ->orderBy('p.fechainicio');

        return $result->getQuery()->getResult();
    }

	public function getAcuerdoextraordinarioByAlumno($alumnoid, $tipoextraordinarioid){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("cae.acuerdoextraordinarioid",
					"cage.agendaextraordinarioid",
					"cage.fechainicio",
					"cage.horainicio",
					"cage.horafin"
				)->from("AppBundle:CeExtraordinario","ce")
				->innerJoin("AppBundle:CeAcuerdoExtraordinario","cae","WITH","cae.extraordinarioid=ce.extraordinarioid")
				->innerJoin("AppBundle:CeAgendaExtraordinario","cage","WITH","cage.agendaextraordinarioid=cae.agendaextraordinarioid")
				->andWhere("ce.alumnoid=:alumno")
				->andWhere("cage.tipoextraordinarioid=:tipoextraordinario")
				->setParameter("alumno",$alumnoid)
                ->setParameter("tipoextraordinario",$tipoextraordinarioid)
                ->orderBy('cae.acuerdoextraordinarioid', 'desc');
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
	public function getAgendasDisponiblesByExtraordinario($extraordinarioid, $tipoextraordinarioid, $periodoregularizacionid){
		try{
			$qb = $this->em->createQueryBuilder();
			$grupoarea = $qb->select('IDENTITY(gt.areaespecializacionid)')
				->from("AppBundle:CeAlumnocicloporgrupo", "acgt1")
				->innerJoin("AppBundle:CeGrupo", "gt", Expr\Join::WITH, "gt.grupoid = acgt1.grupoid and gt.tipogrupoid = 1")
				->where("acgt1.alumnoporcicloid = apct.alumnoporcicloid");


			$qb=$this->em->createQueryBuilder();
			$qb->select("case when cage.agendaextraordinarioid is not null then cage.agendaextraordinarioid else caget.agendaextraordinarioid end as agendaextraordinarioid",
				"case when cage.fechainicio is not null then cage.fechainicio else caget.fechainicio end as fechainicio",
				"case when cage.horainicio is not null then cage.horainicio else caget.horainicio end as horainicio",
				"case when cage.horafin is not null then cage.horafin else caget.horafin end as horafin"

				)->from("AppBundle:CeExtraordinario","ce")
				->innerJoin("AppBundle:CeProfesorpormateriaplanestudios","cpmpe","WITH","cpmpe.profesorpormateriaplanestudiosid=ce.profesorpormateriaplanestudiosid")
				->leftJoin("AppBundle:CeTallercurricular", "tc", Expr\Join::WITH, "tc.tallercurricularid = cpmpe.tallerid")
				->leftJoin("AppBundle:CeGradoportallercurricular", "gtc", Expr\Join::WITH, "gtc.tallercurricularid = tc.tallercurricularid")
				->leftJoin("AppBundle:CeAlumnoporciclo", "apct", Expr\Join::WITH, "apct.alumnoid = ce.alumnoid and apct.cicloid = tc.cicloid and apct.gradoid = gtc.gradoid")
		
				->leftJoin("AppBundle:CeMateriaporplanestudios", "mpet", Expr\Join::WITH, "mpet.materiaporplanestudioid = gtc.materiaporplanestudioid")
				->leftJoin("AppBundle:CePlanestudios", "pet", Expr\Join::WITH, "pet.planestudioid=mpet.planestudioid and (pet.areaespecializacionid = (" . $grupoarea . ") or pet.areaespecializacionid is null)")

				->leftJoin("AppBundle:CeAgendaextraordinario","cage","WITH","cage.materiaporplanestudioid=cpmpe.materiaporplanestudioid ")
				->leftJoin("AppBundle:CePeriodoregularizacion","p","WITH","p.periodoregularizacionid = cage.periodoregularizacionid")
				
				->leftJoin("AppBundle:CeAgendaextraordinario","caget","WITH","caget.materiaporplanestudioid=mpet.materiaporplanestudioid ")
				->leftJoin("AppBundle:CePeriodoregularizacion","pt","WITH","pt.periodoregularizacionid = caget.periodoregularizacionid")
				
					
				->andWhere("cage.estatusagendaextraordinarioid <> 2 or caget.estatusagendaextraordinarioid <> 2")
				->andWhere("ce.extraordinarioid=:extraordinario")
				->andWhere("cage.tipoextraordinarioid=:tipoextraordinario or caget.tipoextraordinarioid=:tipoextraordinario")
				->andWhere("p.periodoregularizacionid=:periodoregularizacion or pt.periodoregularizacionid=:periodoregularizacion")
				->setParameter("extraordinario",$extraordinarioid)
				->setParameter("tipoextraordinario",$tipoextraordinarioid)
				->setParameter("periodoregularizacion",$periodoregularizacionid)
			;
			return $qb->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}
	public function getAcuerdoextraordinarioCountByAgendaextraordinario($agendaextraordinarioid){
		try{
			$qb=$this->em->createQueryBuilder();
			$qb->select("COUNT(cae.acuerdoextraordinarioid) AS cantidad")
				->from("AppBundle:CeAcuerdoextraordinario","cae")
				->andWhere("cae.agendaextraordinarioid=:agendaextraordinario")
				->setParameter("agendaextraordinario",$agendaextraordinarioid)
			;
			return $qb->getQuery()->getResult()[0]['cantidad'];
		}catch(\Exception $e){}
		return false;
    }
    public function getTallerCurricularByAlumno($gradoid, $materiaplanestudiosid, $alumnoporcicloid){
			try{
				$qb=$this->em->createQueryBuilder();
				$result = $qb->select(
						"tc.tallercurricularid ",
						"ac.alumnoporcicloid"
					)->from("AppBundle:CeAlumnocicloportaller","act")
				->innerJoin("AppBundle:CeGradoportallercurricular","gtc","WITH","gtc.tallercurricularid = act.tallercurricularid")
							->innerJoin("AppBundle:CeTallercurricular","tc","WITH","tc.tallercurricularid = gtc.tallercurricularid")
							->innerJoin("AppBundle:CeMateriaporplanestudios","mpe","WITH","mpe.materiaporplanestudioid = gtc.materiaporplanestudioid")
							->innerJoin("AppBundle:CeAlumnoporciclo","ac","WITH","ac.alumnoporcicloid = act.alumnoporcicloid");
							if (isset($gradoid)) {
									$result->andWhere('gtc.gradoid = :gradoid')
									->setParameter('gradoid' , $gradoid);
							}
							if (isset($materiaplanestudiosid)) {
									$result->andWhere('mpe.materiaporplanestudioid = :materiaplanestudiosid')
									->setParameter('materiaplanestudiosid' , $materiaplanestudiosid);
							}
							if (isset($alumnoporcicloid)) {
									$result->andWhere('ac.alumnoporcicloid = :alumnoporcicloid')
									->setParameter('alumnoporcicloid' , $alumnoporcicloid);
							}
				return $result->getQuery()->getResult();
			}catch(\Exception $e){}
			return false;
		}
	public function getReprobadosporPeriodoMateria($periodoid, $materiaplanestudiosid, $options=[]){
		try{
			$extraxCalificacionPeriodo=1;
			$extraxPromedioFinal=1;
			$extraxFaltas=1;
			if(isset($options["letperiodo"]) && !$options["letperiodo"]){
				$extraxCalificacionPeriodo=0;
			}
			if(isset($options["letfinal"]) && !$options["letfinal"]){
				$extraxPromedioFinal=0;
			}
			if(isset($options["letfaltas"]) && !$options["letfaltas"]){
				$extraxFaltas=0;
			}
			$qb=$this->em->createQueryBuilder();
			$result=$qb->select("cpa.calificacionperiodoporalumnoid",
					"pmpe.profesorpormateriaplanestudiosid",
					"mpe.materiaporplanestudioid",
					"ac.alumnoporcicloid",
					"a.alumnoid",
					"u.usuarioid",
					"g.grupoid",
					"IDENTITY(g.tipogrupoid) AS tipogrupoid",
					"c.nombre AS ciclo",
					"n.nombre AS nivel",
					"gr.grado",
					"m.nombre AS materia",
					"a.matricula",
					"CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre) AS nombrecompleto ",
					"pe.puntopase AS puntopase",
					"pe.calificacionminima",
					"COUNT(DISTINCT(asi.asistenciaid)) AS totalfaltas",
					"cpa.calificacion AS calificacion",
					"cpaf.calificacion AS calificacionfinal",
					"CASE WHEN g.nombre IS NOT NULL THEN g.nombre ELSE t.nombre AS grupo",
					"CASE WHEN (cpa.calificacion IS NOT NULL AND :instituto = 1 AND cpa.calificacion < pe.puntopase) OR
							(cpa.calificacion IS NOT NULL AND :instituto = 2 AND cpa.calificacion <= pe.calificacionminima) THEN 1 ELSE 0 
					END AS extraparcial",
					"CASE WHEN cpa.calificacion IS NOT NULL AND cpaf.calificacion<pe.puntopase THEN 1 ELSE 0 END AS extrafinal",
					"CASE WHEN(count(DISTINCT(asi.asistenciaid))>(mpe.horasporsemana*2)) THEN 1 ELSE 0 END AS extrafaltas"
				)->from("AppBundle:CeCalificacionperiodoporalumno","cpa")
				->innerJoin("AppBundle:CeProfesorpormateriaplanestudios","pmpe","WITH","pmpe.profesorpormateriaplanestudiosid = cpa.profesorpormateriaplanestudioid")
				->innerJoin("AppBundle:CePeriodoevaluacion","p","WITH","p.periodoevaluacionid = cpa.periodoevaluacionid")
				->innerJoin("AppBundle:CeCalificacionfinalperiodoporalumno","cpaf","WITH","cpaf.calificacionfinalperiodoporalumnoid = cpa.calificacionfinalporperiodoalumno")
				->innerJoin("AppBundle:CeMateriaporplanestudios","mpe","WITH","mpe.materiaporplanestudioid = cpa.materiaporplanestudioid")
				->innerJoin("AppBundle:Materia","m","WITH","m.materiaid = mpe.materiaid")
				->innerJoin("AppBundle:CePlanestudios","pe","WITH","pe.planestudioid = mpe.planestudioid")
				->innerJoin("AppBundle:CeAlumnoporciclo","ac","WITH","ac.alumnoporcicloid = cpa.alumnoporcicloid")
				->innerJoin("AppBundle:CeAlumno","a","WITH","a.alumnoid = ac.alumnoid")
				->innerJoin("AppBundle:Ciclo","c","WITH","c.cicloid = ac.cicloid")
				->innerJoin("AppBundle:Grado","gr","WITH","gr.gradoid = ac.gradoid")
				->innerJoin("AppBundle:Nivel","n","WITH","n.nivelid = gr.nivelid")
				//->leftJoin("AppBundle:CeAlumnocicloporgrupo","acg","WITH","acg.alumnoporcicloid=ac.alumnoporcicloid")
				->leftJoin("AppBundle:CeGrupo","g","WITH","g.grupoid = pmpe.grupoid")
				->leftJoin("AppBundle:CeTallercurricular","t","WITH","t.tallercurricularid = pmpe.tallerid")
				->leftJoin("AppBundle:CeAsistencia","asi","WITH","asi.alumnoporcicloid = ac.alumnoporcicloid and asi.profesorpormateriaplanestudioid = cpa.profesorpormateriaplanestudioid and asi.tipoasistenciaid = 2 and asi.estatusinasistenciaid = 1 ")
				->leftJoin("AppBundle:Usuario","u","WITH","u.alumnoid = a.alumnoid")
				->andWhere("cpa.materiapadrecalificacionperiodoporalumnoid IS NULL","a.alumnoestatusid=1")
				->groupBy("ac.alumnoporcicloid","mpe.materiaporplanestudioid")
				->having("($extraxCalificacionPeriodo=1 AND extraparcial=1) OR ($extraxPromedioFinal=1 AND extrafinal=1) OR ($extraxFaltas=1 AND extrafaltas=1)")
				->setParameter("instituto", ENTORNO)
				;
			if(isset($options['cicloid']) && !empty($options['cicloid'])){
				$result->andWhere('ac.cicloid=:ciclo')
					->setParameter('ciclo', $options['cicloid']);
			}
			if(isset($periodoid)){
				$result->andWhere('p.periodoevaluacionid=:periodoevaluacionid')
					->setParameter('periodoevaluacionid', $periodoid);
			}
			if(isset($materiaplanestudiosid)){
				$result->andWhere('mpe.materiaporplanestudioid IN (:materiaplanestudiosid)')
					->setParameter('materiaplanestudiosid', $materiaplanestudiosid);
			}
			/*
			if (isset($alumnoporcicloid)) {
					$result->andWhere('ac.alumnoporcicloid = :alumnoporcicloid')
					->setParameter('alumnoporcicloid' , $alumnoporcicloid);
			}
			*/
			return $result->getQuery()->getResult();
		}catch(\Exception $e){}
		return false;
	}    
}