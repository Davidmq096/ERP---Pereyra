<?php

namespace AppBundle\DB\Mysql\Cobranza;

use Doctrine\ORM\Query\Expr;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Bloqueos
 *
 * @author David
 */
class BloqueosDB extends BaseDBManager {

    public function BuscarColegiaturasVencida($filtros)
    {

        $qb = $this->em->createQueryBuilder();
        $grado = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid and ac2.cicloid = c.cicloid");

        $qb = $this->em->createQueryBuilder();
        $grupo = $qb->select('Case WHEN gr2.grupoid IS NOT NULL THEN ag2.alumnocicloporgrupo ELSE 0 END')
            ->from("AppBundle:CeAlumnocicloporgrupo", "ag2")
            ->innerJoin("AppBundle:CeGrupo", "gr2",  Expr\Join::WITH, "ag2.grupoid = gr2.grupoid and gr2.tipogrupoid = 1")
            ->where("ag2.alumnoporcicloid = ac.alumnoporcicloid and gr2.gradoid = g.gradoid")
            ->groupBy("ag2.alumnoporcicloid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $familia = $qb->select('pcf2.padresotutoresporclavefamiliar')
            ->from("AppBundle:CePadresotutoresclavefamiliar", "pcf2")
            ->innerJoin("pcf2.clavefamiliarid", "cf2")
            ->innerJoin("pcf2.padresotutoresid", "p2")
            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "acf2", Expr\Join::WITH, "pcf2.clavefamiliarid = acf2.clavefamiliarid")
            ->where("acf2.alumnoid = a.alumnoid")
            ->groupBy("acf2.alumnoid");
        if (isset($filtros['alumnoid'])) {
            $familia->andWhere('acf2.alumnoid in (:alumnoid)')
                ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['clavefamiliarid'])) {
            $familia->andWhere('cf2.clavefamiliarid = :clavefamiliarid')
                ->setParameter('clavefamiliarid', $filtros['clavefamiliarid']);
        }
        $familia->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $inscripciones = $qb->select('dpi2.documentoporpagarid')
            ->from("AppBundle:CjDocumentoporpagar", "dpi2")
            ->innerJoin("dpi2.documentoid ", "di")
            ->where("a.alumnoid = dpi2.alumnoid and di.tipodocumento = 1 and dpc.documento = dpi2.documento");

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("
        dpc.documentoporpagarid AS DocumentoPorPagarId,
        dpc.documento AS Documento,
        a.alumnoid AS AlumnoId,
        c.cicloid AS CicloId,
        dpc.importe AS Importe,
        dpc.saldo AS Saldo,
        dpc.concepto AS Concepto,
        DATE_FORMAT(dpc.fechalimitepago, '%Y-%m-%d') AS FechaLimite
        ")
            ->from("AppBundle:CeAlumnoporclavefamiliar", "acf")
            ->innerJoin("acf.alumnoid", "a")
            ->innerJoin("AppBundle:CePadresotutoresclavefamiliar", "pc", Expr\Join::WITH, "pc.padresotutoresporclavefamiliar = (" . $familia . ")")
            ->innerJoin("pc.padresotutoresid", "p")
            ->innerJoin("pc.clavefamiliarid", "cf")

            ->innerJoin("AppBundle:CjDocumentoporpagar", "dpc", Expr\Join::WITH, "a.alumnoid = dpc.alumnoid")
            ->innerJoin("AppBundle:CjDocumento", "d", Expr\Join::WITH, "dpc.documentoid = d.documentoid and d.tipodocumento = 2")
            ->innerJoin("dpc.pagoestatusid", "pe")
            ->innerJoin("d.tipodocumento", "td")
            ->innerJoin("dpc.cicloid", "c")

            ->innerJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and ac.gradoid = (" . $grado . ") and ac.cicloid = c.cicloid")
            ->innerJoin("ac.gradoid", "g")
            ->innerJoin("g.nivelid", "n")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnocicloporgrupo = (" . $grupo . ")")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid")

            ->leftJoin("AppBundle:CjDocumentoporpagar", "dpi", Expr\Join::WITH, "dpi.documentoporpagarid = (".$inscripciones.")")
            ->Where('CAST(dpc.fechalimitepago AS date) < CAST(CURRENT_DATE() AS date) and dpc.saldo > 0 and pe.pagoestatusid in (0,1,4)')
            ->orderBy("dpc.fechalimitepago", "ASC")
            ->groupBy("dpc.documentoporpagarid");

        if (isset($filtros['alumnoid'])) {
            $result->andWhere('a.alumnoid = :alumnoid')
                ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['clavefamiliarid'])) {
            $result->andWhere('cf.clavefamiliarid = :clavefamiliarid')
                ->setParameter('clavefamiliarid', $filtros['clavefamiliarid']);
        }
        return  $result->getQuery()->getResult();
    }

}
