<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Reinscripcion
 *
 * @author David
 */
class ReinscripcionDB extends BaseDBManager {

    public function BuscarAlumnosReinscripcion($id) {
        $qb = $this->em->createQueryBuilder();
        $ultimociclo = $qb->select('Case WHEN max(ccca.cicloid) IS NULL THEN max(ccc.cicloid) ELSE max(ccca.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu")
            ->innerJoin("acu.cicloid", "ccc")
            ->leftJoin("AppBundle:Ciclo", "ccca", Expr\Join::WITH, "acu.cicloid = ccca.cicloid and ccca.siguiente = 1")
            ->where("acu.alumnoid = d.alumnoid")
            ->groupBy('acu.alumnoid');
        if (isset($filtros['cicloactual'])) {
            $ultimociclo->andWhere('ccc.actual = 1');
        }
        if (isset($filtros['cicloid'])) {
            $ultimociclo->andWhere('ccc.cicloid = :cicloid');
        }

        $qb = $this->em->createQueryBuilder();
        $gradoactual2 = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g3.gradoid+1)
        ELSE min(g3.gradoid+1) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac3")
            ->innerJoin("ac3.gradoid", "g3")
            ->innerJoin("ac3.cicloid", "c3", Expr\Join::WITH, "ac3.cicloid = (" . $ultimociclo . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn3", Expr\Join::WITH, "g3.nivelid = cn3.nivelid and cn3.cicloid = c3.cicloid")
            ->where("d.alumnoid = ac3.alumnoid");
        

        $qb = $this->em->createQueryBuilder();
        $ultimociclo2 = $qb->select('Case WHEN max(ccca2.cicloid) IS NULL THEN max(ccc2.cicloid) ELSE max(ccca2.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu2")
            ->innerJoin("acu2.cicloid", "ccc2")
            ->innerJoin("acu2.gradoid", "gcc2")
            ->leftJoin("AppBundle:Ciclo", "ccca2", Expr\Join::WITH, "acu2.cicloid = ccca2.cicloid and ccca2.siguiente = 1")
            ->where("acu2.alumnoid = d.alumnoid ")
            ->groupBy('acu2.alumnoid');
        if (isset($filtros['cicloactual'])) {
            $ultimociclo2->andWhere('ccc2.actual = 1');
        }
        if (isset($filtros['cicloid'])) {
            $ultimociclo2->andWhere('ccc2.cicloid = :cicloid');
        }

        $qb = $this->em->createQueryBuilder();
        $gradoactual = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("AppBundle:Ciclo", "cn2", Expr\Join::WITH, "cn2.siguiente = 1")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = cn2.cicloid")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("d.alumnoid = ac2.alumnoid");
        if (isset($filtros['alumnoporcicloid'])) {
            $gradoactual->andWhere('ac2.alumnoporcicloid =' . $filtros['alumnoporcicloid']);
        }

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("d.alumnoid, d.matricula, Concat_WS(' ', d.apellidopaterno, d.apellidomaterno, d.primernombre, d.segundonombre) nombrecompleto,
        n.nivelid, n.nombre nivel, (g.gradoid) gradoid, g.grado, case when rr.reinscripcionid is null then '1' else '2' end as estatusreinscripcion,
        re.reinscripcionestatusid, re.nombre reinscripcionestatus,rr.telefono, rr.correo, rr.tramitobeca  tramitobeca, rr.reinscripcionid,
        IDENTITY(rr.formapagocolegiaturaid) formapagocolegiaturaid, IDENTITY(rr.formapagocolegiaturaanticipadaid) formapagocolegiaturaanticipadaid,
        IDENTITY(rr.formapagoinscripcionyfoid) formapagoinscripcionyfoid, ce.cicloid, ce.nombre as ciclo, rr.pagocolegiaturas, IDENTITY(rr.tipopagocolegiaturaid) as tipopagocolegiaturas")
            ->from("AppBundle:CePadresotutoresclavefamiliar", 'a')
            ->innerJoin('AppBundle:CeClavefamiliar', 'b', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.clavefamiliarid = b.clavefamiliarid')
            ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'b.clavefamiliarid= c.clavefamiliarid')
            ->innerJoin('AppBundle:CeAlumno', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.alumnoid=d.alumnoid')
            ->leftJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "d.alumnoid = ac.alumnoid and ac.gradoid = (" . $gradoactual . ") and ac.cicloid = (" . $ultimociclo2 . ")")
            ->leftJoin("AppBundle:Grado", "g", Expr\Join::WITH, "ac.gradoid = g.gradoid")
            ->leftJoin("g.nivelid", "n")
            ->leftJoin('d.alumnoestatusid', 'ae')
            ->innerJoin("AppBundle:Ciclo", "cn3", Expr\Join::WITH, "cn3.siguiente = 1")
            ->leftJoin("AppBundle:RiReinscripcion", "rr", Expr\Join::WITH, "rr.alumnoid = d.alumnoid and rr.cicloid = cn3.cicloid")
            ->leftJoin("AppBundle:RiReinscripciondocumento", "rd", Expr\Join::WITH, "rr.reinscripcionid = rd.reinscripcionid")
            ->leftJoin("rr.cicloid", "ce")
            ->leftJoin("rr.reinscripcionestatusid", "re")
            ->andWhere('a.padresotutoresid = :padresotutoresid and ae.alumnoestatusid != 2 and g.gradoid <> 18 and ac.intencionreinscribirseid = 1')
            ->groupBy("d.alumnoid")
            ->setParameter('padresotutoresid', $id); 
        
        return $result->getQuery()->getResult();
    }

    public function BuscarDocumentosAlumnoReinscripcion($id) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("rd.nombre documento, rd.reinscripciondocumentoid,
        concat(rd.url,c.nombre,'_',a.matricula,'_',rd.nombre) urldocumento, d.documentoid")
            ->from("AppBundle:RiReinscripciondocumento", 'rd')
            ->innerJoin("rd.documentoid", "d")
            ->innerJoin("rd.reinscripcionid", "r")
            ->innerJoin("r.cicloid", "c")
            ->innerJoin("r.alumnoid", "a")
            ->from("AppBundle:Parametros", "p")
            ->where("p.nombre = 'URLServicios'")
            ->andWhere('r.reinscripcionid = :reinscripcionid')
            ->setParameter('reinscripcionid', $id); 
        
        return $result->getQuery()->getResult();
    }

    public function BuscarNominaByUsuario($id) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("us.usuarioid, 
        Case 
        WHEN us.personaid > 0 THEN concat_ws(' ', p.apellidopaterno, p.apellidomaterno, p.nombre)
        WHEN us.profesorid > 0 THEN concat_ws(' ', pr.apellidopaterno, pr.apellidomaterno, pr.nombre)
        ELSE ''
        END as nombreprofesor")
            ->from("AppBundle:Usuario", 'us')
            ->leftJoin("us.personaid", "p")
            ->leftJoin("us.profesorid", "pr")
            ->where("us.tipousuarioid in (1,2) ")
            ->andWhere("us.id = :nomina")
            ->setParameter('nomina', $id); 
        
        return $result->getQuery()->getResult();
    }
		
		//----------------- Emmanuel -----------------

		public function getReinscripcionLista($filter){
			$qb=$this->em->createQueryBuilder();
            $qb->select("rr.reinscripcionid",
                    "c.nombre as ciclo",
					"g.gradoid",
					"n.nivelid",
					"rre.reinscripcionestatusid",
					"rfpc.formapagocolegiaturaid",
					"rfpi.formapagoinscripcionyfoid",
					"rfpca.formapagocolegiaturaanticipadaid",
					"n.nombre AS nivel",
					"g.grado",
                    "cea.matricula",
                    "IDENTITY(cea.usuarioid) as profusuarioid",
					"rr.telefono",
					"rr.correo",
					"concat_ws(' ', cea.apellidopaterno, cea.apellidomaterno, cea.primernombre) AS alumno",
					'GroupConcat(distinct cecf.clave) AS clavefamiliar',
					"rre.nombre AS estatus",
					"rr.tramitobeca",
					"rr.observaciones",
					"rfpc.nombre AS formapagocolegiatura",
					"rfpi.nombre AS formapagoinscripcionyfo",
                    "rfpca.nombre AS formapagocolegiaturaanticipada",
                    "rr.renunciafo",
                    "rr.pagocolegiaturas",
                    "tpc.tipopagocolegiaturaid",
                    "tpc.nombre as tipopagocolegiatura",
                    "rr.hijopersonal",
                    "rr.nonomina",
                    "DATE_FORMAT(rr.fecha,'%d/%m/%Y') fecha",
                    "DATE_FORMAT(rr.fecha, '%H:%i') as hora",
                    "rr.documentacionoriginal",
                    "concat_ws(' ', p.apellidopaterno, p.apellidomaterno, p.nombre) as nombreprofesor"
				)
				->from("AppBundle:RiReinscripcion", "rr")
				->innerJoin("AppBundle:CeAlumnoporciclo", "ceac", "WITH", "ceac.cicloid=rr.cicloid AND ceac.alumnoid=rr.alumnoid")
				->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "ceacf", "WITH", "ceacf.alumnoid=ceac.alumnoid")
				->innerJoin("rr.reinscripcionestatusid", "rre")
				->innerJoin("ceacf.clavefamiliarid", "cecf")
				->innerJoin("ceac.alumnoid", "cea")
				->innerJoin("rr.cicloid", "c")
				->innerJoin("ceac.gradoid", "g")
				->innerJoin("g.nivelid", "n")
				->leftJoin("rr.formapagocolegiaturaid", "rfpc")
				->leftJoin("rr.formapagoinscripcionyfoid", "rfpi")
                ->leftJoin("rr.formapagocolegiaturaanticipadaid", "rfpca")
                ->leftJoin("rr.tipopagocolegiaturaid", "tpc")
                ->leftJoin("AppBundle:Usuario", "us", Expr\Join::WITH, "us.id = rr.nonomina and us.tipousuarioid in (1,2)")
                ->leftJoin("us.personaid", "p")
				->groupBy("cea.alumnoid")
            ;
            if(!empty($filter['cicloid'])){
				$qb->andWhere("c.cicloid=:cicloid")
					->setParameter("cicloid",$filter['cicloid']);
			}
			if(!empty($filter['nivelid'])){
				$qb->andWhere("n.nivelid=:nivelid")
					->setParameter("nivelid",$filter['nivelid']);
			}
			if(!empty($filter['semestreid'])){
				$qb->andWhere("g.semestreid=:semestreid")
					->setParameter("semestreid",$filter['semestreid']);
			}
			if(!empty($filter['gradoid'])){
				$qb->andWhere("g.gradoid=:gradoid")
					->setParameter("gradoid",$filter['gradoid']);
			}
			if(!empty($filter['estatusid'])){
				$qb->andWhere("rre.reinscripcionestatusid=:estatusid")
					->setParameter("estatusid",$filter['estatusid']);
			}
			if(!empty($filter['cfamiliar'])){
				$qb->andWhere("cecf.clave=:cfamiliar")
					->setParameter("cfamiliar",$filter['cfamiliar']);
			}
			if(!empty($filter['matricula'])){
				$qb->andWhere("cea.matricula=:matricula")
					->setParameter("matricula",$filter['matricula']);
			}
			return $qb->getQuery()->getResult();
	}
}
