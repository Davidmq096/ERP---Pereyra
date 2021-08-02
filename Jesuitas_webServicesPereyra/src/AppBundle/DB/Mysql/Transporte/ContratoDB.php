<?php

namespace AppBundle\DB\Mysql\Transporte;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Inscripcion
 *
 * @author Javier
 */
class ContratoDB extends BaseDBManager{
	public function BuscarContrato($filtros){
		$qb=$this->em->createQueryBuilder();
		$subconceptos=$qb->select("s.subconceptoid")
				->from("AppBundle:TpRuta", "r")
				->innerJoin("r.subconceptoid", 's')
				->groupBy('s.subconceptoid')
				->getQuery()->getResult();

		$qb=$this->em->createQueryBuilder();
		$result=$qb->select("c.contratoid",
				"f.clavefamiliarid",
				"a.alumnoid",
				"g.gradoid",
				"CONCAT_WS(' ', f.clave, ' - ', f.apellidopaterno, f.apellidomaterno) AS familia",
				"CONCAT_WS(' ', a.matricula, ' - ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) AS alumno",
				"GroupConcat(DISTINCT r.nombre SEPARATOR ', ') AS rutas",
				"ci.nombre AS ciclo",
				"CASE
				WHEN CURRENT_DATE() <= c.vigenciafin THEN 
					CASE 
						WHEN e.contratoestatusid <> 2  AND CURRENT_DATE() BETWEEN apc.suspenderinicio and apc.suspenderfin THEN 'Suspendido' 
						ELSE e.nombre 
					END
				ELSE
					CASE 
						WHEN e.contratoestatusid <> 2  THEN 'Finalizado' 
						ELSE e.nombre 
					END
					END contratoestatus,
					CASE
						WHEN CURRENT_DATE() <= c.vigenciafin THEN 
							CASE 
								WHEN e.contratoestatusid <> 2  AND CURRENT_DATE() BETWEEN apc.suspenderinicio and apc.suspenderfin THEN 3 
								ELSE e.contratoestatusid
							END
						ELSE
							CASE 
								WHEN e.contratoestatusid <> 2  THEN 4
								ELSE e.contratoestatusid 
							END
					END contratoestatusid",
					"apc.alumnoporcontratoid"
			)
			->addSelect("(SELECT SUM((s1_cjdp.saldo - s1_cjdp.descuento))"
				." FROM AppBundle:TpAlumnoruta s1_tpar"
				." INNER JOIN AppBundle:TpAlumnomesrutaprecio s1_tpamrp WITH s1_tpamrp.alumnorutaid=s1_tpar.alumnorutaid"
				." INNER JOIN AppBundle:CjDocumentoporpagar s1_cjdp WITH s1_cjdp.documentoporpagarid=s1_tpamrp.documentoporpagarid"
				." WHERE s1_tpar.contratoid=c.contratoid AND s1_tpar.alumnoid=a.alumnoid"
				." AND s1_cjdp.saldo>0"
				." AND s1_cjdp.fechalimitepago<CURRENT_TIMESTAMP()"
				.") AS saldovencido"
			)
			->addSelect("(SELECT MesEspanol(max(s2_cjdp.fechalimitepago))"
				." FROM AppBundle:TpAlumnoruta s2_tpar"
				." INNER JOIN AppBundle:TpAlumnomesrutaprecio s2_tpamrp WITH s2_tpamrp.alumnorutaid=s2_tpar.alumnorutaid"
				." INNER JOIN AppBundle:CjDocumentoporpagar s2_cjdp WITH s2_cjdp.documentoporpagarid=s2_tpamrp.documentoporpagarid"
				." WHERE s2_tpar.contratoid=c.contratoid AND s2_tpar.alumnoid=a.alumnoid"
				." AND s2_cjdp.saldo=0"
				.") AS ultimomespago"
			)
			->from("AppBundle:TpContrato", "c")
			->innerJoin("c.clavefamiliarid", "f")
			->innerJoin("AppBundle:TpAlumnoruta", "tpar", "WITH", "c.contratoid=tpar.contratoid")
			->innerJoin("AppBundle:CePadresotutoresclavefamiliar", "pc", "WITH", "f.clavefamiliarid=pc.clavefamiliarid")
			->innerJoin("pc.padresotutoresid", "p")
			->innerJoin("c.cicloid", "ci")
			->innerJoin('tpar.rutaid', "r")
			->innerJoin('tpar.alumnoid', "a")
			->leftJoin("AppBundle:CeAlumnoporciclo", "aci", "WITH", "a.alumnoid=aci.alumnoid AND aci.cicloid=ci.cicloid")
			->leftJoin("aci.gradoid", "g")
			->leftJoin("g.nivelid", "n")
			->leftJoin("AppBundle:Usuario", "u", "WITH", "u.alumnoid=a.alumnoid")
			->leftJoin("AppBundle:TpAlumnoporcontrato", "apc", "WITH", "apc.alumnoid = a.alumnoid and apc.contratoid = c.contratoid")
			->leftJoin("apc.contratoestatusid", "e")
			->groupBy("a.alumnoid, c.contratoid, ci.cicloid")
		;
		if(isset($filtros['cicloid'])){
			$result->andWhere('ci.cicloid = :cicloid')
				->setParameter('cicloid', $filtros['cicloid']);
		}
		if(isset($filtros['nivelid'])){
			$result->andWhere('n.nivelid IN (:nivelid)')
				->setParameter('nivelid', $filtros['nivelid']);
		}
		if(isset($filtros['clavefamiliar'])){
			$escape=array("_","%");
			$escapados=array("\_","\%");
			$filtros['clavefamiliar']=trim(str_replace($escape,$escapados,$filtros['clavefamiliar']));
			$result->andWhere('f.clave like :clavefamiliar')
			   ->setParameter('clavefamiliar', '%'.$filtros['clavefamiliar'].'%');

		}
		if(isset($filtros['matricula'])){
			$escape=array("_","%");
			$escapados=array("\_","\%");
			$filtros['matricula']=trim(str_replace($escape,$escapados,$filtros['matricula']));
			   $result->andWhere('a.matricula like :matricula')
			   ->setParameter('matricula', '%'.$filtros['matricula'].'%');
		}
		if(isset($filtros['usuarioid'])){
			$result->andWhere('u.usuarioid = :usuarioid')
				->setParameter('usuarioid', $filtros['usuarioid']);
		}
		if(isset($filtros['rutaid'])){
			$result->andWhere('r.rutaid = :rutaid')
				->setParameter('rutaid', $filtros['rutaid']);
		}
		if(isset($filtros['alumnoid'])){
			$result->andWhere('a.alumnoid = :alumnoid')
				->setParameter('alumnoid', $filtros['alumnoid']);
		}
		if(isset($filtros['padresotutoresid'])){
			$result->andWhere('p.padresotutoresid = :padresotutoresid')
				->setParameter('padresotutoresid', $filtros['padresotutoresid']);
		}
        if (isset($filtros['contratoestatusid'])) {
            switch ($filtros['contratoestatusid']) {
                case "1":
                    $result->andWhere('e.contratoestatusid <> 2 
                    AND (NOT CURRENT_DATE() BETWEEN apc.suspenderinicio and apc.suspenderfin OR apc.suspenderinicio IS NULL)
                    AND (CURRENT_DATE() <= c.vigenciafin)');
                    break;
                case "2":
                    $result->andWhere('e.contratoestatusid = 2');
                    break;
                case "3":
                    $result->andWhere('e.contratoestatusid <> 2  
                    AND CURRENT_DATE() BETWEEN apc.suspenderinicio and apc.suspenderfin
                    AND (CURRENT_DATE() <= c.vigenciafin)');
                    break;
                case "4":
                $result->andWhere('e.contratoestatusid <> 2 AND (CURRENT_DATE() > c.vigenciafin)');
                    break;
            }
        }
		return $result->getQuery()->getResult();
	}
	public function BuscarDeudaTransporte($familiaid)
    {
        $qb = $this->em->createQueryBuilder();
        $subconceptos = $qb->select("s.subconceptoid")
            ->from("AppBundle:TpRuta", "r")
            ->innerJoin("r.subconceptoid", 's')
            ->groupBy('s.subconceptoid')
            ->getQuery()->getResult();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("sum((d.saldo - d.descuento)) saldo, 
        sum(CASE WHEN d.fechalimitepago < CURRENT_TIMESTAMP() THEN (d.saldo - d.descuento) ELSE 0 END) vencido, MesEspanol(max(d.fechalimitepago)) ultimomespago")
            ->from("AppBundle:CeAlumnoporclavefamiliar", "af")
            ->innerJoin('AppBundle:CjDocumentoporpagar', 'd', Expr\Join::WITH, 'af.alumnoid = d.alumnoid')
            ->where('d.subconceptoid in (:subconceptos) and af.clavefamiliarid =' . $familiaid)
            ->setParameter('subconceptos', $subconceptos)
            ->groupBy("af.clavefamiliarid");
        return $result->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }
	public function getAlumnoMRPEntity($kcontrato, $kalumno, $kruta, $year, $month){
		$qb=$this->em->createQueryBuilder();
		$result=$qb->select("tpamrp")
			->from("AppBundle:TpAlumnomesrutaprecio", "tpamrp")
			->innerJoin("tpamrp.alumnorutaid", "tpar")
			->innerJoin("tpamrp.alumnomesid", "tpam")
			->andWhere("tpar.contratoid=tpam.contratoid")
			->andWhere("tpar.alumnoid=tpam.alumnoid")
			->andWhere("tpar.contratoid=:kcontrato")
			->andWhere("tpar.alumnoid=:kalumno")
			->andWhere("tpar.rutaid=:kruta")
			->andWhere("tpam.year=:year")
			->andWhere("tpam.month=:month")
			->setParameter('kcontrato', $kcontrato)
			->setParameter('kalumno', $kalumno)
			->setParameter('kruta', $kruta)
			->setParameter('year', $year)
			->setParameter('month', $month)
			->getQuery()
			->getResult()
		;
		return ($result && !empty($result) ? $result[0] : false);
	}
	public function getAlumnoMRPSEntityByContrato($kcontrato){
		$qb=$this->em->createQueryBuilder();
		$result=$qb->select("tpamrp")
			->from("AppBundle:TpAlumnomesrutaprecio", "tpamrp")
			->innerJoin("tpamrp.alumnorutaid", "tpar")
			->innerJoin("tpamrp.alumnomesid", "tpam")
			->andWhere("tpar.contratoid=tpam.contratoid")
			->andWhere("tpar.contratoid=:kcontrato")
			->setParameter('kcontrato', $kcontrato)
			->getQuery()
			->getResult()
		;
		return ($result && !empty($result) ? $result[0] : false);
	}
}