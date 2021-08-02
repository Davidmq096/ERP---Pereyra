<?php

namespace AppBundle\DB\Mysql\Cobranza;

use Doctrine\ORM\Query\Expr;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Adeudos
 *
 * @author David
 */
class AdeudovencidoDB extends BaseDBManager {

    public function BuscarAdeudosvencidos($filtros) {

        $qb = $this->em->createQueryBuilder();
        $ultimociclo = $qb->select('Case WHEN max(ccca.cicloid) IS NULL THEN max(ccc.cicloid) ELSE max(ccca.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu")
            ->innerJoin("acu.cicloid", "ccc")
            ->leftJoin("AppBundle:Ciclo", "ccca", Expr\Join::WITH, "acu.cicloid = ccca.cicloid and ccca.actual = 1")
            ->where("acu.alumnoid = a.alumnoid")
            ->groupBy('acu.alumnoid');
        if (isset($filtros['cicloactual'])) {
            $ultimociclo->andWhere('ccc.actual = 1');
        }

        $qb = $this->em->createQueryBuilder();
        $ultimociclo2 = $qb->select('Case WHEN max(ccca2.cicloid) IS NULL THEN max(ccc2.cicloid) ELSE max(ccca2.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu2")
            ->innerJoin("acu2.cicloid", "ccc2")
            ->leftJoin("AppBundle:Ciclo", "ccca2", Expr\Join::WITH, "acu2.cicloid = ccca2.cicloid and ccca2.actual = 1")
            ->where("acu2.alumnoid = a.alumnoid")
            ->groupBy('acu2.alumnoid');
        if (isset($filtros['cicloactual'])) {
            $ultimociclo2->andWhere('ccc2.actual = 1');
        }
        if (isset($filtros['cicloid'])) {
            $ultimociclo2->andWhere('ccc2.cicloid = :cicloid');
        }

        $qb = $this->em->createQueryBuilder();
        $paramincripcion = $qb->select("parins.valor")
        ->from("AppBundle:Parametros", "parins")
        ->Where("parins.nombre = 'SubConceptoInscripcionCicloActual'");
        $paramincripcion->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $gradoactual = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = (" . $ultimociclo . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid");
        if (isset($filtros['alumnoporcicloid'])) {
            $gradoactual->andWhere('ac2.alumnoporcicloid =' . $filtros['alumnoporcicloid']);
        }

        $qb = $this->em->createQueryBuilder();
        $alumno = $qb->select('a4.alumnoid')
            ->from("AppBundle:CeAlumno", "a4")
            ->where("a4.alumnoid = a.alumnoid")
            ->groupBy('a4.alumnoid');


        $qb = $this->em->createQueryBuilder();
        $importefacturas = $qb->select("SUM(f.importe)")
            ->from("AppBundle:CjFactura ", "f")
            ->innerJoin("AppBundle:CjPagodetalle", "pd7", Expr\Join::WITH, "f.pagoid = pd7.pagoid")
            ->innerJoin("f.pagoid", "p7")
            ->innerJoin("AppBundle:CjDocumentoporpagar", "dp7", Expr\Join::WITH, "dp7.documentoporpagarid = pd7.documentoporpagarid")
            ->innerJoin("AppBundle:CjDocumento", "d7", Expr\Join::WITH, "d7.documentoid = dp7.documentoid")
            ->innerJoin('dp7.subconceptoid', 'sc7')
            ->where("CAST(p7.fecha as date) <= CAST('" . $filtros['fechacorte'] . "'as date) and p7.pagoestatusid in (0, 1, 2, 4) and dp7.alumnoid = a.alumnoid")
            ->from("AppBundle:Parametros", "par8")
            ->andWhere("par8.nombre = 'SubConceptoInscripcionCicloActual'");
            if (isset($filtros['fechainicial']) && isset($filtros['fechafinal'])) {
                $importefacturas->andWhere('CAST(dp7.fechalimitepago as date) >= CAST(:fechainicial as date) and CAST(dp7.fechalimitepago as date) <= CAST(LAST_DAY(:fechafinal) as date)')
                ->setParameter('fechainicial', $filtros['fechainicial'])
                ->setParameter('fechafinal', $filtros['fechafinal']);
            }
            if (isset($filtros['subconceptoid'])) {
                $importefacturas->andWhere('sc7.subconceptoid IN ('. implode(',',$filtros['subconceptoid']) .')');
            }
            if (isset($filtros['conceptoid'])) {
                $importefacturas->andWhere('sc7.conceptoid IN ('. implode(',',$filtros['conceptoid']) .')');
            }
            if (isset($filtros['tipodocumentoid'])) {
                $importefacturas->andWhere('d7.tipodocumento IN ('. implode(',',$filtros['tipodocumentoid']) .')');
            }
        $importefacturas->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $cantidadfacturas = $qb->select("count(f2.facturaid)")
            ->from("AppBundle:CjFactura ", "f2")
            ->innerJoin("AppBundle:CjPago", "p8", Expr\Join::WITH, "p8.pagoid = f2.pagoid")
            ->innerJoin("AppBundle:CjPagodetalle", "pd8", Expr\Join::WITH, "pd8.pagoid = p8.pagoid")
            ->innerJoin("AppBundle:CjDocumentoporpagar", "dp8", Expr\Join::WITH, "dp8.documentoporpagarid = pd8.documentoporpagarid")
            ->innerJoin("AppBundle:CjDocumento", "d8", Expr\Join::WITH, "d8.documentoid = dp8.documentoid")
            ->innerJoin('dp8.subconceptoid', 'sc8')
            ->where("CAST(p8.fecha as date) <= CAST('" . $filtros['fechacorte'] . "'as date) and p8.pagoestatusid in (0, 1, 2, 4) and dp8.alumnoid = a.alumnoid")
            ->from("AppBundle:Parametros", "par9")
            ->andWhere("par9.nombre = 'SubConceptoInscripcionCicloActual'"); 
            if (isset($filtros['fechainicial']) && isset($filtros['fechafinal'])) {
                $cantidadfacturas->andWhere('CAST(dp8.fechalimitepago as date) >= CAST(:fechainicial as date) and CAST(dp8.fechalimitepago as date) <= CAST(LAST_DAY(:fechafinal) as date)')
                ->setParameter('fechainicial', $filtros['fechainicial'])
                ->setParameter('fechafinal', $filtros['fechafinal']);
            }
            if (isset($filtros['subconceptoid'])) {
                $cantidadfacturas->andWhere('sc8.subconceptoid IN ('. implode(',',$filtros['subconceptoid']) .')');
            }
            if (isset($filtros['conceptoid'])) {
                $cantidadfacturas->andWhere('sc8.conceptoid IN ('. implode(',',$filtros['conceptoid']) .')');
            }
            if (isset($filtros['tipodocumentoid'])) {
                $cantidadfacturas->andWhere('d8.tipodocumento IN ('. implode(',',$filtros['tipodocumentoid']) .')');
            }
        $cantidadfacturas->getQuery()->getDQL();


        $qb = $this->em->createQueryBuilder();
        $pagosrealizados = $qb->select("SUM(pd.importe)")
            ->from("AppBundle:CjPagodetalle ", "pd")
            ->innerJoin('pd.pagoid', 'pg')
            ->innerJoin("AppBundle:CjDocumentoporpagar", "dp2", Expr\Join::WITH, "dp2.documentoporpagarid = pd.documentoporpagarid")
            ->innerJoin("AppBundle:CjDocumento", "d2", Expr\Join::WITH, "d2.documentoid = dp2.documentoid")
            ->innerJoin('dp2.subconceptoid', 'sc4')
            ->where("CAST(pg.fecha as date) <= CAST('" . $filtros['fechacorte'] . "'as date) and pg.pagoestatusid in (0, 1, 2, 4)  and dp2.alumnoid = a.alumnoid")
            ->from("AppBundle:Parametros", "par")
            ->andWhere("par.nombre = 'SubConceptoInscripcionCicloActual'"); 
            if (isset($filtros['fechainicial']) && isset($filtros['fechafinal'])) {
                $pagosrealizados->andWhere('CAST(dp2.fechalimitepago as date) >= CAST(:fechainicial as date) and CAST(dp2.fechalimitepago as date) <= CAST(LAST_DAY(:fechafinal) as date)')
                ->setParameter('fechainicial', $filtros['fechainicial'])
                ->setParameter('fechafinal', $filtros['fechafinal']);
            }
            if (isset($filtros['subconceptoid'])) {
                $pagosrealizados->andWhere('sc4.subconceptoid IN ('. implode(',',$filtros['subconceptoid']) .')');
            }
            if (isset($filtros['conceptoid'])) {
                $pagosrealizados->andWhere('sc4.conceptoid IN ('. implode(',',$filtros['conceptoid']) .')');
            }
            if (isset($filtros['tipodocumentoid'])) {
                $pagosrealizados->andWhere('d2.tipodocumento IN ('. implode(',',$filtros['tipodocumentoid']) .')');
            }
        $pagosrealizados->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $importetotal = $qb->select("SUM(dp3.importe)")
            ->from("AppBundle:CjDocumentoporpagar ", "dp3")
            ->innerJoin("AppBundle:CjDocumento", "d3", Expr\Join::WITH, "d3.documentoid = dp3.documentoid")
            ->innerJoin('dp3.subconceptoid', 'sc3')
            ->innerJoin('dp3.alumnoid', 'a3')
            ->where("dp3.alumnoid = a.alumnoid")
            ->from("AppBundle:Parametros", "par2")
            ->andWhere("par2.nombre = 'SubConceptoInscripcionCicloActual'"); 
            if (isset($filtros['fechainicial']) && isset($filtros['fechafinal'])) {
                $importetotal->andWhere('CAST(dp3.fechalimitepago as date) >= CAST(:fechainicial as date)  and CAST(dp3.fechalimitepago as date) <= CAST(LAST_DAY(:fechafinal) as date)')
                ->setParameter('fechainicial', $filtros['fechainicial'])
                ->setParameter('fechafinal', $filtros['fechafinal']);
            }
            if (isset($filtros['subconceptoid'])) {
                $importetotal->andWhere('sc3.subconceptoid IN ('. implode(',',$filtros['subconceptoid']) .')');
            }
            if (isset($filtros['conceptoid'])) {
                $importetotal->andWhere('sc3.conceptoid IN ('. implode(',',$filtros['conceptoid']) .')');
            }
            if (isset($filtros['tipodocumentoid'])) {
                $importetotal->andWhere('d3.tipodocumento IN ('. implode(',',$filtros['tipodocumentoid']) .')');
            }
        $importetotal->getQuery()->getDQL();

        

        $qb = $this->em->createQueryBuilder();
        $recargostotales = $qb->select("SUM(calculaInteresfecha(dp4.documentoporpagarid, '" . $filtros['fechacorte'] . "'))")
            ->from("AppBundle:CjDocumentoporpagar ", "dp4")
            ->innerJoin("AppBundle:CjDocumento", "d4", Expr\Join::WITH, "d4.documentoid = dp4.documentoid")
            ->innerJoin('dp4.subconceptoid', 'sc2')
            ->innerJoin('dp4.alumnoid', 'a2')
            ->where("dp4.alumnoid = a.alumnoid")
            ->from("AppBundle:Parametros", "par4")
            ->andWhere("par4.nombre = 'SubConceptoInscripcionCicloActual'"); 
            if (isset($filtros['fechainicial']) && isset($filtros['fechafinal'])) {
                $recargostotales->andWhere('CAST(dp4.fechalimitepago as date) >= CAST(:fechainicial as date) and CAST(dp4.fechalimitepago as date) <= CAST(LAST_DAY(:fechafinal) as date)')
                ->setParameter('fechainicial', $filtros['fechainicial'])
                ->setParameter('fechafinal', $filtros['fechafinal']);
            }
            if (isset($filtros['subconceptoid'])) {
                $recargostotales->andWhere('sc2.subconceptoid IN (:subconceptoid)')
                    ->setParameter('subconceptoid', $filtros['subconceptoid']);
            }
            if (isset($filtros['conceptoid'])) {
                $recargostotales->andWhere('sc2.conceptoid IN (:conceptoid)')
                    ->setParameter('conceptoid', $filtros['conceptoid']);
            }

        $recargostotales->getQuery()->getDQL();


        $qb = $this->em->createQueryBuilder();
        $saldofamiliar = $qb->select("(SUM(dp6.importe ) + 
            sum(calculaInteresfecha(dp6.documentoporpagarid , '" . $filtros['fechacorte'] . "')) - 
            sum(case when  CAST(p6.fecha as date) <= CAST('" . $filtros['fechacorte'] . "'as date)
             then pd6.importe else 0 end))")
            ->from("AppBundle:CeAlumnoporclavefamiliar ", "acf6")
            ->innerJoin("AppBundle:CeClavefamiliar", "cf6", Expr\Join::WITH, "cf6.clavefamiliarid = acf6.clavefamiliarid")
            ->innerJoin('acf6.alumnoid', 'a6')
            ->innerJoin("AppBundle:CjDocumentoporpagar", "dp6", Expr\Join::WITH, "dp6.alumnoid = a6.alumnoid")
            ->innerJoin('dp6.subconceptoid', 'sc6')
            ->leftJoin("AppBundle:CJPagodetalle", "pd6", Expr\Join::WITH, "pd6.documentoporpagarid = dp6.documentoporpagarid")
            ->leftJoin("AppBundle:CJPago", "p6", Expr\Join::WITH, "p6.pagoid = pd6.pagoid")
            ->where("cf6.clave = cf.clave")
            ->from("AppBundle:Parametros", "par3")
            ->andWhere("par3.nombre = 'SubConceptoInscripcionCicloActual'"); 
            if (isset($filtros['fechainicial']) && isset($filtros['fechafinal'])) {
                $saldofamiliar->andWhere('dp6.fechalimitepago >= :fechainicial and CAST(dp6.fechalimitepago as date) <= CAST( LAST_DAY(:fechafinal) as date)')
                ->setParameter('fechainicial', $filtros['fechainicial'])
                ->setParameter('fechafinal', $filtros['fechafinal']);
            }
            if (isset($filtros['subconceptoid'])) {
                $saldofamiliar->andWhere('sc6.subconceptoid IN (:subconceptoid)')
                    ->setParameter('subconceptoid', $filtros['subconceptoid']);
            }
            if (isset($filtros['conceptoid'])) {
                $saldofamiliar->andWhere('sc6.conceptoid IN (:conceptoid)')
                    ->setParameter('conceptoid', $filtros['conceptoid']);
            }

        $saldofamiliar->getQuery()->getDQL();      

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("groupconcat(distinct dp.documentoporpagarid), a.alumnoid, a.matricula, Concat_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) nombrecompleto,
        n.nombre as nivel, g.grado, gr.nombre as grupo, at.telefono, e.nombre as alumnoestatusid, cf.clave as clavefamiliar,
        Concat_WS(' ', potp.apellidopaterno, potp.apellidomaterno, potp.nombre) nombrepadre, tp.descripcion as ppadre,
        potp.telefono as telpadre, potp.telempresa as telempresapadre,
        (
            CASE 
                WHEN up.usuarioid IS NULL
                THEN potp.correo
                ELSE up.cuenta
            END
          ) as correopadre,
        Concat_WS(' ', potm.apellidopaterno, potm.apellidomaterno, potm.nombre) nombremadre, tm.descripcion as pmadre,
        potm.telefono as telmadre, potm.telempresa as telempresamadre,
        concat_ws(' ', potm.nombre, potm.apellidopaterno, potm.apellidomaterno) as madrenombre,
        (
            CASE 
                WHEN um.usuarioid IS NULL
                THEN potm.correo
                ELSE um.cuenta
            END
          ) as correomadre, DATE_FORMAT(ac.fechabaja, '%d/%m/%Y') as fechabaja")
        ->addSelect("(" . $pagosrealizados . ") as pagosrealizados")
        ->addSelect("(" . $importetotal . ") as importe")
        ->addSelect("(" . $recargostotales . ") as recargos")
        ->addSelect("(" . $saldofamiliar . ") as saldofamilia")
        ->addSelect("(" . $importefacturas . ") as importefacturas")
        ->addSelect("(" . $cantidadfacturas . ") as cantidadfacturas")
        ->from("AppBundle:CjDocumentoporpagar", 'dp')
        ->innerJoin("AppBundle:CjDocumento", "d", Expr\Join::WITH, "d.documentoid = dp.documentoid")
        ->innerJoin("dp.subconceptoid", "sc")
        ->innerJoin("dp.alumnoid", "a")
        ->innerJoin('a.alumnoestatusid', 'e')   
        ->leftJoin('AppBundle:CeAlumnoporclavefamiliar', 'cl', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.alumnoid = cl.alumnoid')
        ->leftJoin('cl.clavefamiliarid', 'cf')
        ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid and ac.gradoid = (" . $gradoactual . ") and ac.cicloid = (" . $ultimociclo2 . ") ")
        ->innerJoin('ac.gradoid', 'g')
        ->innerJoin('g.nivelid', 'n')
        ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnoporcicloid = ac.alumnoporcicloid")
        ->leftJoin('ag.grupoid', 'gr')
        ->leftJoin("AppBundle:CeAlumnotelefono", "at", Expr\Join::WITH, "at.alumnoid = a.alumnoid")

        ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'potcf', Expr\Join::WITH, 'potcf.clavefamiliarid = cf.clavefamiliarid  and potcf.tutorid = 1')
        ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'potcff', Expr\Join::WITH, 'potcff.clavefamiliarid = cf.clavefamiliarid  and potcff.tutorid = 2')
        ->leftJoin('AppBundle:CePadresotutores', 'potp', Expr\Join::WITH, 'potcf.padresotutoresid = potp.padresotutoresid')
        ->leftJoin('potcf.tutorid', 'tp')
        ->leftJoin('AppBundle:Usuario', 'up', Expr\Join::WITH, 'potp.padresotutoresid = up.padreotutorid')

        ->leftJoin('AppBundle:CePadresotutores', 'potm', Expr\Join::WITH, 'potcff.padresotutoresid = potm.padresotutoresid')
        ->leftJoin('potcff.tutorid', 'tm')
        ->leftJoin('AppBundle:Usuario', 'um', Expr\Join::WITH, 'potm.padresotutoresid = um.padreotutorid')
        ->groupBy("a.alumnoid");

        if (isset($filtros['matricula'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['matricula'] = str_replace($escape, $escapados, $filtros['matricula']);
            $result->andWhere('a.matricula like :matricula')
            ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }
        if (isset($filtros['clavefamiliar'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['clavefamiliar'] = str_replace($escape, $escapados, $filtros['clavefamiliar']);
            $result->andWhere('cf.clave like :clavefamiliar')
            ->setParameter('clavefamiliar', '%' . $filtros['clavefamiliar'] . '%');
        }
        if (isset($filtros['fechainicial']) && isset($filtros['fechafinal'])) {
            $result->andWhere('CAST(dp.fechalimitepago as date) >= CAST(:fechainicial as date) and CAST(dp.fechalimitepago as date) <= LAST_DAY(:fechafinal)')
            ->setParameter('fechainicial', $filtros['fechainicial'])
            ->setParameter('fechafinal', $filtros['fechafinal']);
        }
        if (count($filtros['nivelid']) > 0) {
            $result->andWhere('n.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (count($filtros['gradoid']) > 0) {
            $result->andWhere('g.gradoid IN (:gradosid)')
                ->setParameter('gradosid', $filtros['gradoid']);
        }
        if (isset($filtros['estatusalumnoid'])) {
            $result->andWhere('e.alumnoestatusid IN (:alumnoestatusid)')
                ->setParameter('alumnoestatusid', $filtros['estatusalumnoid']);
        }
        if (isset($filtros['tipodocumentoid'])) {
            $result->andWhere('d.tipodocumento IN (:tipodocumentoid)')
                ->setParameter('tipodocumentoid', $filtros['tipodocumentoid']);
        }
        if (isset($filtros['subconceptoid'])) {
            $result->andWhere('sc.subconceptoid IN (:subconceptoid)')
                ->setParameter('subconceptoid', $filtros['subconceptoid']);
        }
        if (isset($filtros['conceptoid'])) {
            $result->andWhere('sc.conceptoid IN (:conceptoid)')
                ->setParameter('conceptoid', $filtros['conceptoid']);
        }
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

	public function BuscarAdeudosVencidosDetalle($filtros){
		$fechacorte=$filtros['fechacorte'];
		$qb=$this->em->createQueryBuilder();
		$result=$qb->select("dp.documentoporpagarid",
				"a.alumnoid",
				"n.nombre AS nivel",
				"g.grado",
				"gr.nombre AS grupo",
				"CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) nombrecompleto",
				"a.matricula",
				"dp.concepto",
				"dp.importe",
				"dp.saldo-dp.descuento as saldo",
				"(dp.importe-dp.saldo) AS pagos",
				"calculaInteresfecha(dp.documentoporpagarid, '$fechacorte') AS recargos"
			)
			->from("AppBundle:CjDocumentoporpagar", 'dp')
			->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid=dp.alumnoid AND ac.cicloid=dp.cicloid AND ac.gradoid=dp.gradoid")
			->innerJoin("dp.documentoid", "doc")			
			->innerJoin("dp.subconceptoid", "sc")
			->innerJoin("dp.alumnoid", "a")
			->innerJoin("dp.cicloid", "c")
			->innerJoin("dp.gradoid", "g")
			->innerJoin("g.nivelid", "n")   
			->innerJoin("a.alumnoestatusid", "e")
			->leftJoin("AppBundle:CeAlumnoporclavefamiliar", "cl", \Doctrine\ORM\Query\Expr\Join::WITH, "a.alumnoid=cl.alumnoid")
			->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnoporcicloid=ac.alumnoporcicloid")
			->leftJoin("cl.clavefamiliarid", "cf")
			->leftJoin("ag.grupoid", "gr")
			->groupBy("dp.documentoporpagarid")
			->orderBy("g.grado, gr.nombre")
		;

		if(isset($filtros['matricula'])){
			$escape=array("_", "%");
			$escapados=array("\_", "\%");
			$filtros['matricula']=str_replace($escape, $escapados, $filtros['matricula']);
			$result->andWhere('a.matricula LIKE :matricula')
					->setParameter('matricula', '%'.$filtros['matricula'].'%');
		}
		if(isset($filtros['clavefamiliar'])){
			$escape=array("_", "%");
			$escapados=array("\_", "\%");
			$filtros['clavefamiliar']=str_replace($escape, $escapados, $filtros['clavefamiliar']);
			$result->andWhere('cf.clave LIKE :clavefamiliar')
					->setParameter('clavefamiliar', '%'.$filtros['clavefamiliar'].'%');
		}
		if(isset($filtros['fechainicial']) && isset($filtros['fechafinal'])){
			$result->andWhere('dp.fechalimitepago>=:fechainicial AND dp.fechalimitepago<=CAST(LAST_DAY(:fechafinal) as date)')
					->setParameter('fechainicial', $filtros['fechainicial'])
					->setParameter('fechafinal', $filtros['fechafinal']);
		}
		if(!empty($filtros['nivelid'])){
			$result->andWhere('n.nivelid IN (:nivelid)')
					->setParameter('nivelid', $filtros['nivelid']);
		}
		if(!empty($filtros['gradoid'])){
			$result->andWhere('g.gradoid IN (:gradosid)')
					->setParameter('gradosid', $filtros['gradoid']);
		}
		if(isset($filtros['estatusalumnoid'])){
			$result->andWhere('e.alumnoestatusid IN (:alumnoestatusid)')
					->setParameter('alumnoestatusid', $filtros['estatusalumnoid']);
		}
		if(isset($filtros['tipodocumentoid'])){
			$result->andWhere('doc.tipodocumento IN (:tipodocumentoid)')
					->setParameter('tipodocumentoid', $filtros['tipodocumentoid']);
		}
		if(isset($filtros['subconceptoid'])){
			$result->andWhere('sc.subconceptoid IN (:subconceptoid)')
					->setParameter('subconceptoid', $filtros['subconceptoid']);
		}
		if(isset($filtros['conceptoid'])){
			$result->andWhere('sc.conceptoid IN (:conceptoid)')
					->setParameter('conceptoid', $filtros['conceptoid']);
		}
		$data=$result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
		return $data;
	}
}