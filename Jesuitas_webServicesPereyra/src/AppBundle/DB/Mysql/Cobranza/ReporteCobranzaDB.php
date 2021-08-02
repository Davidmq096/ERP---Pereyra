<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql\Cobranza;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Descripción of ReportecobranzaDB
 *
 * @author inceptio
 */
class ReporteCobranzaDB extends BaseDBManager
{
    public function BuscarReportecobranza($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $estatusacuerdo = $qb->select('apora.alumnoporacuerdoid')
            ->from("AppBundle:CbAlumnoporacuerdo", "apora")
            ->innerJoin("apora.acuerdoid", "acuer")
            ->where("apora.alumnoid = a.alumnoid and acuer.cicloid = c.cicloid")
            ->andWhere('acuer.estatusacuerdoid = 1')
            ->orderBy("acuer.fechacreacion", "DESC")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $documentos = $qb->select('CASE 
        WHEN DATE_DIFF(CURRENT_DATE(), min(d.fechalimitepago)) between 30 AND 59 THEN 30
        WHEN DATE_DIFF(CURRENT_DATE(), min(d.fechalimitepago)) between 60 AND 89 THEN 60
        WHEN DATE_DIFF(CURRENT_DATE(), min(d.fechalimitepago)) >= 90 THEN 90
        ELSE 0 END
        ')->from("AppBundle:CjDocumentoporpagar", "d")
            ->where("d.alumnoid = a.alumnoid and d.pagoestatusid = 1 and d.saldo > 0")
            ->groupBy("d.alumnoid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $ultimociclo = $qb->select('Case WHEN max(ccca.cicloid) IS NULL THEN max(ccc.cicloid) ELSE max(ccca.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu2")
            ->innerJoin("acu2.cicloid", "ccc")
            ->leftJoin("AppBundle:Ciclo", "ccca", Expr\Join::WITH, "acu2.cicloid = ccca.cicloid and ccca.actual = 1")
            ->where("acu2.alumnoid = a.alumnoid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $gradoactual = $qb->select('CASE WHEN
            CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
            ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = (" . $ultimociclo . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $grupo = $qb->select('Case WHEN gr2.grupoid IS NOT NULL THEN ag2.alumnocicloporgrupo ELSE 0 END')
            ->from("AppBundle:CeAlumnocicloporgrupo", "ag2")
            ->innerJoin("AppBundle:CeGrupo", "gr2",  Expr\Join::WITH, "ag2.grupoid = gr2.grupoid and gr2.tipogrupoid = 1")
            ->where("ag2.alumnoporcicloid = ac.alumnoporcicloid and gr2.gradoid = g.gradoid")
            ->groupBy("ag2.alumnoporcicloid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $padres = $qb->select("GROUPCONCAT(
                DISTINCT CONCAT_WS(' ', p.apellidopaterno, p.apellidomaterno, p.nombre, '&nbsp;', p.correo, '&nbsp;', p.celular) 
                SEPARATOR '<br>')")
            ->from("AppBundle:CePadresotutoresclavefamiliar", "pcf")
            ->innerJoin("pcf.padresotutoresid", "p")
            ->where("pcf.clavefamiliarid = f.clavefamiliarid")
            ->groupBy("pcf.clavefamiliarid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $familia = $qb->select("cf.clavefamiliarid")
            ->from("AppBundle:CeAlumnoporclavefamiliar", "cfa")
            ->innerJoin("cfa.clavefamiliarid", "cf")
            ->where("cfa.alumnoid = a.alumnoid")
            ->groupBy("cfa.alumnoid");
        if (isset($filtros['clavefamiliar'])) {
            $familia->andWhere('cf.clave = :clavefamiliar')
                ->setParameter('clavefamiliar', $filtros['clavefamiliar']);
        }
        $familia->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $becaactual = $qb->select("GROUPCONCAT(CONCAT(tb.descripcion, ' ', pb.descripcion, '%') SEPARATOR ', ')")
            ->from("AppBundle:BcBecas", "b")
            ->innerJoin('b.porcentajebecaid', 'pb')
            ->innerJoin('b.tipobecaid', 'tb')
            ->innerJoin('AppBundle:Ciclo', 'cba', Expr\Join::WITH, 'b.cicloid = cba.cicloid and cba.actual = 1')
            ->where("b.alumnoid = a.alumnoid and b.estatusid = 3")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("DISTINCT a.alumnoid, a.matricula, f.clave, f.clavefamiliarid,
        CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno,a.primernombre, a.segundonombre) nombre,
        gr.nombre grupo, g.grado, n.nombre nivel, e.nombre alumnoestatus,
        case when acu.acuerdoid is null then 'No' else 'Si' end acuerdo, 
        CASE
			WHEN esacu.estatusacuerdoid = 1 AND (CURRENT_DATE() > acu.vigenciafin) THEN 'Vencido' ELSE esacu.nombre
        END estatusacuerdo,
        acu.acuerdoid,
        DATE_DIFF(CURRENT_DATE(), min(dp.fechalimitepago)) atraso,
        sum((dp.saldo - dp.descuento)) saldo,
        sum(calculaInteres(dp.documentoporpagarid)) interes,
        DATE_FORMAT(rc.fecha, '%d/%m/%Y') fechacorreoenviado")
            ->addSelect("(" . $padres . ") padres")
            ->addSelect("(" . $becaactual . ") becaactual")
            ->addSelect("(Select case when count(alumclave.alumnoporclavefamiliar) > 1 then 'Si' else 'No' end from AppBundle:CeAlumnoporclavefamiliar alumclave where alumclave.clavefamiliarid = acf.clavefamiliarid) hermanos")
            ->from("AppBundle:CeAlumno", 'a')
            ->innerJoin('a.alumnoestatusid', 'e')
            ->leftJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and ac.gradoid = (" . $gradoactual . ")")

            ->innerJoin("AppBundle:Ciclo", 'cactual', Expr\Join::WITH, "ac.cicloid = cactual.cicloid")
            ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "ac.gradoid = g.gradoid")
            ->innerJoin("g.nivelid", "n")

            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnocicloporgrupo = (" . $grupo . ")")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid")

            ->innerJoin("AppBundle:CjDocumentoporpagar", "dp", Expr\Join::WITH, "dp.alumnoid = a.alumnoid")
            ->innerJoin("dp.cicloid", "c")

            ->leftJoin("AppBundle:CbAlumnoporacuerdo", "aa", Expr\Join::WITH, "aa.alumnoid = a.alumnoid and aa.alumnoporacuerdoid = FIRST(" . $estatusacuerdo . ")")
            ->leftJoin("aa.acuerdoid", "acu")
            ->leftJoin("acu.estatusacuerdoid", "esacu")

            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "acf", Expr\Join::WITH, "acf.alumnoid = a.alumnoid and acf.clavefamiliarid = (" . $familia . ")")
            ->innerJoin("acf.clavefamiliarid", "f")
            ->leftJoin("AppBundle:CbRegistroenviocorreo", "rc", Expr\Join::WITH, "rc.alumnoid = a.alumnoid")
            ->andWhere('dp.pagoestatusid = 1 and dp.saldo > 0')
            ->andWhere('dp.fechalimitepago < CURRENT_TIMESTAMP()')
            ->groupBy("a.alumnoid");
        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid <=' . $filtros["cicloid"]);
        }
        if (isset($filtros['matricula'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['matricula'] = trim(str_replace($escape, $escapados, $filtros['matricula']));
            $result->andWhere('a.matricula like :matricula')
                ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }
        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid IN (:gradosid)')
                ->setParameter('gradosid', $filtros['gradoid']);
        }
        if (isset($filtros['grupoid'])) {
            $result->andWhere('gr.grupoid IN (:grupoid)')
                ->setParameter('grupoid', $filtros['grupoid']);
        }
        if (isset($filtros['clavefamiliar'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['clavefamiliar'] = trim(str_replace($escape, $escapados, $filtros['clavefamiliar']));
            $result->andWhere('f.clave = :clavefamiliar')
                ->setParameter('clavefamiliar', $filtros['clavefamiliar']);
        }
        if (isset($filtros['alumnoestatusid'])) {
            $result->andWhere('e.alumnoestatusid =' . $filtros["alumnoestatusid"]);
        }
        if (isset($filtros['acuerdo'])) {
            $result->andWhere('aa.alumnoporacuerdoid is ' . ($filtros["acuerdo"] == "1" ? "not" : "") . ' null');
        }
        if (isset($filtros['estatusacuerdoid'])) {
            $result->andWhere('esacu.estatusacuerdoid = ' . $filtros["estatusacuerdoid"]);
        }
        if (isset($filtros['atraso'])) {
            switch ($filtros['atraso']) {
                case "1":
                    $result->andWhere('(' . $documentos . ') = 0');
                    break;
                case "2":
                    $result->andWhere('(' . $documentos . ') = 30');
                    break;
                case "3":
                    $result->andWhere('(' . $documentos . ') = 60');
                    break;
                case "4":
                    $result->andWhere('(' . $documentos . ') = 90');
                    break;
            }
        } else {
            $result->andWhere('(' . $documentos . ') >= 0');
        }
        if (isset($filtros['pagodiverso'])) {
        }
        $sql =  $result->getQuery()->getResult();
        return $sql;
    }
}
