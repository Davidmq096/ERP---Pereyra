<?php

namespace AppBundle\DB\Mysql\Pagos;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Inscripcion
 *
 * @author Javier
 */
class PagosDB extends BaseDBManager
{

    public function BuscarDcocumentosPagados($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p.pagoid AS PagoId, p.folio AS Folio, p.importe AS Importe,
        DATE_FORMAT(p.fecha, '%Y-%m-%d') AS FechaPago,
        DATE_FORMAT(p.fecha, '%H:%i') AS HoraPago,
        SUM( CASE WHEN sc.subconceptoid = interes.valor THEN pd.importe ELSE 0 END) AS Interes,
        GROUPCONCAT( DISTINCT 
            CASE WHEN sc.subconceptoid <> interes.valor and sc.subconceptoid <> descuento.valor THEN pd.leyenda ELSE :NULL END
            ORDER BY pd.documentoporpagarid SEPARATOR ', ' ) AS Concepto,
        CONCAT_WS(' ', a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) AS Alumno,
        a.matricula AS Matricula,
        a.alumnoid AS AlumnoId,
        cl.clavefamiliarid AS ClaveFamiliarId,
        pa.padresotutoresid AS PadresOTutoresId,
        e.empresaid AS EmpresaId")
            ->from('AppBundle:CjPago', 'p')
            ->innerJoin('p.alumnoid', 'a')
            ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'ac', Expr\Join::WITH, 'a.alumnoid = ac.alumnoid')
            ->innerJoin('ac.clavefamiliarid', 'cl')
            ->innerJoin('AppBundle:CePadresotutoresclavefamiliar', 'pc', Expr\Join::WITH, 'cl.clavefamiliarid = pc.clavefamiliarid')
            ->innerJoin('pc.padresotutoresid', 'pa')

            ->innerJoin('AppBundle:CjPagodetalle', 'pd', Expr\Join::WITH, 'p.pagoid = pd.pagoid')
            ->innerJoin('pd.subconceptoid', 'sc')
            ->innerJoin('sc.conceptoid', 'c')
            ->innerJoin('c.empresaid', 'e')

            ->leftJoin('pd.documentoporpagarid', 'dp')

            ->where("p.pagoestatusid in (0,2,4)")
            ->andWhere("pa.padresotutoresid = :padresotutoresid")
            ->setParameter("padresotutoresid", $filtros["padresotutoresid"])
            ->andWhere("c.empresaid = :empresaid")
            ->setParameter("empresaid", $filtros["empresaid"])
            ->groupBy('pd.pagoid, pc.padresotutoresid')
            ->orderBy("p.fecha", "DESC")

            ->from('AppBundle:Parametros', 'interes')
            ->andWhere("interes.nombre = 'Subconcepto de pago de intereses'")
            ->from('AppBundle:Parametros', 'descuento')
            ->andWhere("descuento.nombre = 'SubConceptoDescuentoInscripcion'")
            ->setParameter("NULL", NULL);
        return $result->getQuery()->getResult();
    }

    public function BuscarDocumentosPorPagarColegiatura($filtros)
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
            ->innerJoin("pcf2.padresotutoresid", "p2")
            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "acf2", Expr\Join::WITH, "pcf2.clavefamiliarid = acf2.clavefamiliarid")
            ->where("acf2.alumnoid = a.alumnoid")
            ->groupBy("acf2.alumnoid");
        if (isset($filtros['alumnoid'])) {
            $familia->andWhere('acf2.alumnoid in (:alumnoid)')
                ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['padresotutoresid'])) {
            $familia->andWhere('p2.padresotutoresid = :padresotutoresid')
                ->setParameter('padresotutoresid', $filtros['padresotutoresid']);
        }
        $familia->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $inscripciones = $qb->select('dpi2.documentoporpagarid')
            ->from("AppBundle:CjDocumentoporpagar", "dpi2")
            ->innerJoin("dpi2.documentoid ", "di")
            ->where("a.alumnoid = dpi2.alumnoid and di.tipodocumento = 1 and dpc.documento = dpi2.documento")
            //->groupBy("dpi2.documento")
            ;

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("
        GROUPCONCAT(DISTINCT dpc.documentoporpagarid) AS DocumentoPorPagarId,
        CASE WHEN subc.iniciocobro is not null and subc.fincobrootrosmedios is not null THEN 
            CASE WHEN CURRENT_TIMESTAMP() BETWEEN subc.iniciocobro AND subc.fincobrootrosmedios  THEN 1 else 0 END else 1 end as visible,
        subc.subconceptoid,
        subc.iniciocobro,
        dpc.documento AS Documento,
        a.alumnoid AS AlumnoId,
        c.cicloid AS CicloId,
        dpc.referencia AS Referencia,
        dpc.referenciabanco AS ReferenciaBanco,
        pe.pagoestatusid AS PagoEstatusId,
        d.documentoid AS DocumentoId,
        dpc.saldo AS Saldo,
        dpc.importe AS Importe,
        dpc.concepto AS Concepto,
        dpc.descuento as descuentodoc,
        (CASE WHEN (CAST(dpc.fechalimitepago AS date) < CAST(CURRENT_DATE() AS date)) THEN calculaInteres(dpc.documentoporpagarid) ELSE 0 END) AS Interes,
        DATE_FORMAT(dpc.fechalimitepago, '%Y-%m-%d') AS FechaLimite,
        DATE_FORMAT(dpc.fechalimitepago, '%d/%m/%Y') AS FechaLimiteFormato,
        DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d') AS Hoy,
        CONCAT_WS(' ', a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) AS Alumno,
        a.matricula AS Matricula,
        cf.clavefamiliarid AS ClaveFamiliarId,
        p.padresotutoresid AS PadresOTutoresId,
        c.nombre AS Ciclo,
        g.grado AS Grado,
        g.gradoid,
        n.nombre AS Nivel,
        n.nivelid,
        gr.nombre AS Grupo,
        td.tipodocumentoid AS TipoDocumento,
        dpc.importe - dpc.descuento  + CASE WHEN dpi.documentoporpagarid IS NULL THEN 0 ELSE sum(dpi.importe) END AS ImporteTotal,
        dpc.saldo - dpc.descuento + CASE WHEN dpi.documentoporpagarid IS NULL THEN 0 ELSE sum(dpi.saldo) - sum(dpi.descuento) END AS SaldoTotal,
        (CASE WHEN (CAST(dpc.fechalimitepago AS date) < CAST(CURRENT_DATE() AS date)) THEN calculaInteres(dpc.documentoporpagarid) ELSE 0 END) AS InteresTotal,
        0 AS DescuentoProntoPago,
        0 AS RecargoPorVencimiento,
        CASE WHEN dpc.descuento > 0 THEN 1 ELSE 0 END AS Descuento,
        0 AS Recargo,
        0 AS Prorroga,
        Case WHEN dpi.documentoporpagarid IS NULL THEN 0 ELSE sum(dpi.importe) END AS ImporteInscripcion,
        Case WHEN dpi.documentoporpagarid IS NULL THEN 0 ELSE sum(dpi.saldo) END AS SaldoInscripcion,
        0 AS SaldoFondoOrfandad
        ")
            ->from("AppBundle:CeAlumno", "a")
            ->innerJoin("AppBundle:CePadresotutoresclavefamiliar", "pc", Expr\Join::WITH, "pc.padresotutoresporclavefamiliar = (" . $familia . ")")
            ->innerJoin("pc.padresotutoresid", "p")
            ->innerJoin("pc.clavefamiliarid", "cf")

            ->innerJoin("AppBundle:CjDocumentoporpagar", "dpc", Expr\Join::WITH, "a.alumnoid = dpc.alumnoid")
            ->innerJoin("AppBundle:CjDocumento", "d", Expr\Join::WITH, "dpc.documentoid = d.documentoid and d.tipodocumento = 2")
            ->innerJoin("dpc.pagoestatusid", "pe")
            ->innerJoin("d.tipodocumento", "td")
            ->innerJoin("dpc.cicloid", "c")
            ->innerJoin("dpc.subconceptoid", "subc")

            ->innerJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and ac.gradoid = (" . $grado . ") and ac.cicloid = c.cicloid")
            ->innerJoin("ac.gradoid", "g")
            ->innerJoin("g.nivelid", "n")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnocicloporgrupo = (" . $grupo . ")")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid")

            ->leftJoin("AppBundle:CjDocumentoporpagar", "dpi", Expr\Join::WITH, "dpi.documentoporpagarid IN (" . $inscripciones . ")")
            ->groupBy("a.alumnoid, dpc.documento")
            ->orderBy("dpc.fechalimitepago", "ASC")
            ->having("visible = 1");

        if (isset($filtros['documentoporpagarid'])) {
            $result->andWhere('dpc.documentoporpagarid IN (:documentoporpagarid)')
                ->setParameter('documentoporpagarid', $filtros['documentoporpagarid']);
        }
        if (isset($filtros['referencia'])) {
            $result->andWhere('dpc.referencia = :referencia')
                ->setParameter('referencia', $filtros['referencia']);
        }
        if (isset($filtros['referenciabanco'])) {
            $result->andWhere('dpc.referenciabanco = :referenciabanco')
                ->setParameter('referenciabanco', $filtros['referenciabanco']);
        }
        if (isset($filtros['alumnoid'])) {
            $result->andWhere('a.alumnoid = :alumnoid')
                ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['pagoestatusid'])) {
            $result->andWhere('pe.pagoestatusid = :pagoestatusid')
                ->setParameter('pagoestatusid', $filtros['pagoestatusid']);
        }
        if (isset($filtros['fechalimite'])) {
            $result->andWhere('dpc.fechalimitepago < :fechalimite')
                ->setParameter('fechalimite', $filtros['fechalimite']);
        }
        if (isset($filtros['saldo'])) {
            $result->andWhere('dpc.saldo > 0 or dpi.saldo >0');
        }
        if (isset($filtros['padresotutoresid'])) {
            $result->andWhere('p.padresotutoresid = :padresotutoresid')
                ->setParameter('padresotutoresid', $filtros['padresotutoresid']);
        }
        return  $result->getQuery()->getResult();
    }

    public function BuscarDcocumentosInscripcion($filtros)
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
            ->innerJoin("pcf2.padresotutoresid", "p2")
            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "acf2", Expr\Join::WITH, "pcf2.clavefamiliarid = acf2.clavefamiliarid")
            ->where("acf2.alumnoid = a.alumnoid")
            ->groupBy("acf2.alumnoid");
        if (isset($filtros['alumnoid'])) {
            $familia->andWhere('acf2.alumnoid in (:alumnoid)')
                ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['padresotutoresid'])) {
            $familia->andWhere('p2.padresotutoresid = :padresotutoresid')
                ->setParameter('padresotutoresid', $filtros['padresotutoresid']);
        }
        $familia->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("
        dp.documentoporpagarid AS DocumentoPorPagarId,
        dp.documento AS Documento,
        CASE WHEN sc.iniciocobro is not null and sc.fincobrootrosmedios is not null THEN 
        CASE WHEN CURRENT_TIMESTAMP() BETWEEN sc.iniciocobro AND sc.fincobrootrosmedios  THEN 1 else 0 END else 1 end as visible,
        sc.subconceptoid,
        0 as descuentodoc,
        a.alumnoid AS AlumnoId,
        c.cicloid AS CicloId,
        n.nivelid,
        dp.referencia AS Referencia,
        dp.referenciabanco AS ReferenciaBanco,
        pe.pagoestatusid AS PagoEstatusId,
        d.documentoid AS DocumentoId,
        SUM(dp.saldo) AS Saldo,
        SUM(dp.importe) AS Importe,
        1 AS IsInscripcion,
        GROUPCONCAT( CASE WHEN sc.subconceptoid = par.valor THEN dp.concepto ELSE :NULL END SEPARATOR ',') AS Concepto,
        0 AS Interes,
        DATE_FORMAT(dp.fechalimitepago, '%Y-%m-%d') AS FechaLimite,
        DATE_FORMAT(dp.fechalimitepago, '%d/%m/%Y') AS FechaLimiteFormato,
        DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d') AS Hoy,
        CASE WHEN a.alumnoid IS NULL 
            THEN CONCAT_WS(' ', d1.nombre, d1.apellidopaterno, d1.apellidomaterno)
            ELSE CONCAT_WS(' ', a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) 
        END AS Alumno,
        a.matricula AS Matricula,
        cf.clavefamiliarid AS ClaveFamiliarId,
        p.padresotutoresid AS PadresOTutoresId,
        c.nombre AS Ciclo,
        CASE WHEN a.alumnoid IS NULL THEN gs.grado ELSE g.grado END AS Grado,
        g.gradoid,
        CASE WHEN a.alumnoid IS NULL THEN ns.nombre ELSE n.nombre END AS Nivel,
        gr.nombre AS Grupo,
        td.tipodocumentoid AS TipoDocumento,
        SUM(dp.importe) AS ImporteTotal,
        SUM(dp.saldo) AS SaldoTotal,
        0 AS InteresTotal,
        pp.descuentoprontopago AS DescuentoProntoPago,
        pp.recargoporvencimiento AS RecargoPorVencimiento,
        CASE WHEN DATE_FORMAT(pp.fechaprontopago, '%Y-%m-%d') >= CURRENT_DATE() THEN 1 ELSE 0 END AS Descuento,
        CASE WHEN DATE_FORMAT(pp.fechaprorroga, '%Y-%m-%d') < CURRENT_DATE() THEN 1 ELSE 0 END AS Recargo,
        0 AS Prorroga,
        0 AS ImporteInscripcion,
        0 AS SaldoInscripcion,
        SUM( CASE WHEN LOWER(sc.nombre) LIKE '%orfandad%' THEN (dp.saldo) ELSE 0 END) AS SaldoFondoOrfandad,
        CASE WHEN c.siguiente = 1 THEN par2.valor WHEN c.actual = 1 THEN par.valor ELSE 0 END AS subconceptoinscripcionid
        ")
            ->from("AppBundle:CjDocumentoporpagar", "dp")
            ->innerJoin("dp.pagoestatusid", "pe")
            ->innerJoin("dp.documentoid", "d")
            ->innerJoin("d.tipodocumento", "td")
            ->innerJoin("dp.subconceptoid", "sc")
            ->innerJoin("dp.cicloid", "c")

            ->leftJoin("dp.alumnoid", "a")

            ->leftJoin("AppBundle:CePadresotutoresclavefamiliar", "pc", Expr\Join::WITH, "pc.padresotutoresporclavefamiliar = (" . $familia . ")")
            ->leftJoin("pc.padresotutoresid", "p")
            ->leftJoin("pc.clavefamiliarid", "cf")

            ->leftJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and ac.gradoid = (" . $grado . ") and ac.cicloid = c.cicloid")
            ->leftJoin("ac.gradoid", "g")
            ->leftJoin("g.nivelid", "n")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnocicloporgrupo = (" . $grupo . ")")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid")

            ->leftJoin("dp.solicitudadmisionid", "s")
            ->leftJoin("s.datoaspiranteid", "d1")
            ->leftJoin("s.gradoid", "gs")
            ->leftJoin("g.nivelid", "ns")

            ->leftJoin("AppBundle:CjPlanpagoporalumno", "ppa", Expr\Join::WITH, "(a.alumnoid = ppa.alumnoid or s.solicitudadmisionid = ppa.solicitudadmisionid) AND ppa.cicloid = c.cicloid")
            ->leftJoin("ppa.planpagoid", "pp")
            ->andWhere('d.tipodocumento = 1')
            ->andWhere("REGEXP(dp.documento, :regexp) = true")
            ->from("AppBundle:Parametros", "par")
            ->andWhere("par.nombre = 'SubConceptoInscripcionCicloActual'")
            ->from("AppBundle:Parametros", "par2")
            ->andWhere("par2.nombre = 'SubConceptoInscripcionCicloSiguiente'")
            ->groupBy("a.alumnoid, s.solicitudadmisionid, c.cicloid, dp.documento, dp.fechalimitepago")
            ->orderBy("dp.fechalimitepago", "ASC")
            ->having("visible = 1")
            ->setParameter('NULL', NULL)
            ->setParameter('regexp', '....00.*');
        if (isset($filtros['documentoporpagarid'])) {
            $result->andWhere('dp.documentoporpagarid IN (:documentoporpagarid)')
                ->setParameter('documentoporpagarid', $filtros['documentoporpagarid']);
        }
        if (isset($filtros['referencia'])) {
            $result->andWhere('dp.referencia = :referencia')
                ->setParameter('referencia', $filtros['referencia']);
        }
        if (isset($filtros['referenciabanco'])) {
            $result->andWhere('dp.referenciabanco = :referenciabanco')
                ->setParameter('referenciabanco', $filtros['referenciabanco']);
        }
        if (isset($filtros['alumnoid'])) {
            $result->andWhere('a.alumnoid = :alumnoid')
                ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['pagoestatusid'])) {
            $result->andWhere('pe.pagoestatusid = :pagoestatusid')
                ->setParameter('pagoestatusid', $filtros['pagoestatusid']);
        }
        if (isset($filtros['fechalimite'])) {
            $result->andWhere('dp.fechalimitepago < :fechalimite')
                ->setParameter('fechalimite', $filtros['fechalimite']);
        }
        if (isset($filtros['saldo'])) {
            $result->andWhere('dp.saldo > 0');
        }
        if (isset($filtros['padresotutoresid'])) {
            $result->andWhere('p.padresotutoresid = :padresotutoresid')
                ->setParameter('padresotutoresid', $filtros['padresotutoresid']);
        }
        return  $result->getQuery()->getResult();
    }

    public function BuscarDcocumentosOtros($filtros)
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
            ->innerJoin("pcf2.padresotutoresid", "p2")
            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "acf2", Expr\Join::WITH, "pcf2.clavefamiliarid = acf2.clavefamiliarid")
            ->where("acf2.alumnoid = a.alumnoid")
            ->groupBy("acf2.alumnoid");
        if (isset($filtros['alumnoid'])) {
            $familia->andWhere('acf2.alumnoid in (:alumnoid)')
                ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['padresotutoresid'])) {
            $familia->andWhere('p2.padresotutoresid = :padresotutoresid')
                ->setParameter('padresotutoresid', $filtros['padresotutoresid']);
        }
        $familia->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("
        dp.documentoporpagarid AS DocumentoPorPagarId,
        dp.documento AS Documento,
        sc.subconceptoid AS SubConceptoId,
        pe.pagoestatusid AS PagoEstatusId,
        CASE WHEN sc.iniciocobro is not null and sc.fincobrootrosmedios is not null THEN 
        CASE WHEN CURRENT_TIMESTAMP() BETWEEN sc.iniciocobro AND sc.fincobrootrosmedios  THEN 1 else 0 END else 1 end as visible,
        a.alumnoid AS AlumnoId,
        s.solicitudadmisionid AS SolicitudAdmisionId,
        c.cicloid AS CicloId,
        c.nombre AS Ciclo,
        n.nivelid,
        CASE WHEN a.alumnoid IS NULL THEN gs.grado ELSE g.grado END AS Grado,
        g.gradoid,
        CASE WHEN a.alumnoid IS NULL THEN ns.nombre ELSE n.nombre END AS Nivel,
        gr.nombre AS Grupo,
        mp.mediopagoid AS MedioPagoId,
        dp.saldo  AS Saldo,
        0 as descuentodoc,
        dp.saldo AS Importe,
        0 AS ImporteInscripcion,
        0 AS SaldoInscripcion,
        dp.fechalimitepago AS FechaLimitePago,
        DATE_FORMAT(dp.fechalimitepago, '%Y-%m-%d') AS FechaLimite,
        DATE_FORMAT(dp.fechalimitepago, '%d/%m/%Y') AS FechaLimiteFormato,
        dp.fechacreacion AS FechaCreacion,
        dp.fechaprontopago AS FechaProntoPago,
        dp.referencia AS Referencia,
        dp.referenciabanco AS ReferenciaBanco,
        d.documentoid AS DocumentoId,
        dp.idnomina AS IdNomina,
        dp.hermanos AS Hermanos,
        dp.reingreso AS Reingreso,
        dp.padreexalumno AS PadreExAlumno,
        dp.concepto AS Concepto,
        co.escurricular,
        acu.acuerdoid AS AcuerdoId,
        tacu.tipoacuerdoid AS TipoAcuerdoId,
        dp.porcentaje AS Porcentaje,
        dp.iva AS IVA,
        0 AS Interes,
        
        DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d') AS Hoy,
        CASE WHEN a.alumnoid IS NULL 
            THEN CONCAT_WS(' ', d1.nombre, d1.apellidopaterno, d1.apellidomaterno)
            ELSE CONCAT_WS(' ', a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) 
        END AS Alumno,
        a.matricula AS Matricula,
        cf.clavefamiliarid AS ClaveFamiliarId,
        p.padresotutoresid AS PadresOTutoresId,
        td.tipodocumentoid AS TipoDocumento,
        em.empresaid AS EmpresaId
        ")
            ->from("AppBundle:CjDocumentoporpagar", "dp")
            ->innerJoin("dp.documentoid", "d")
            ->innerJoin("d.tipodocumento", "td")
            ->innerJoin("dp.subconceptoid", "sc")
            ->innerJoin("sc.conceptoid", "co")
            ->innerJoin("co.empresaid", "em")
            ->innerJoin("dp.pagoestatusid", "pe")
            ->leftJoin("dp.mediopagoid", "mp")

            ->leftJoin("dp.acuerdoid", "acu")
            ->leftJoin("dp.tipoacuerdoid", "tacu")

            ->innerJoin("dp.cicloid", "c")
            ->leftJoin("dp.alumnoid", "a")

            ->leftJoin("AppBundle:CePadresotutoresclavefamiliar", "pc", Expr\Join::WITH, "pc.padresotutoresporclavefamiliar = (" . $familia . ")")
            ->leftJoin("pc.padresotutoresid", "p")
            ->leftJoin("pc.clavefamiliarid", "cf")

            ->leftJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and ac.gradoid = (" . $grado . ") and ac.cicloid = c.cicloid")
            ->leftJoin("ac.gradoid", "g")
            ->leftJoin("g.nivelid", "n")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnocicloporgrupo = (" . $grupo . ")")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid")

            ->leftJoin("dp.solicitudadmisionid", "s")
            ->leftJoin("s.datoaspiranteid", "d1")
            ->leftJoin("s.gradoid", "gs")
            ->leftJoin("g.nivelid", "ns")

            ->andWhere('d.tipodocumento NOT IN (1,2)')
            ->groupBy("dp.documentoporpagarid")
            ->orderBy("dp.fechalimitepago", "ASC")
            ->having("visible = 1");

        if (isset($filtros['documentoporpagarid'])) {
            $result->andWhere('dp.documentoporpagarid IN (:documentoporpagarid)')
                ->setParameter('documentoporpagarid', $filtros['documentoporpagarid']);
        }
        if (isset($filtros['referencia'])) {
            $result->andWhere('dp.referencia = :referencia')
                ->setParameter('referencia', $filtros['referencia']);
        }
        if (isset($filtros['referenciabanco'])) {
            $result->andWhere('dp.referenciabanco = :referenciabanco')
                ->setParameter('referenciabanco', $filtros['referenciabanco']);
        }
        if (isset($filtros['alumnoid'])) {
            $result->andWhere('a.alumnoid = :alumnoid')
                ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['pagoestatusid'])) {
            $result->andWhere('pe.pagoestatusid = :pagoestatusid')
                ->setParameter('pagoestatusid', $filtros['pagoestatusid']);
        }
        if (isset($filtros['fechalimite'])) {
            $result->andWhere('dp.fechalimitepago < :fechalimite')
                ->setParameter('fechalimite', $filtros['fechalimite']);
        }
        if (isset($filtros['saldo'])) {
            $result->andWhere('dp.saldo > 0');
        }
        if (isset($filtros['padresotutoresid'])) {
            $result->andWhere('p.padresotutoresid = :padresotutoresid')
                ->setParameter('padresotutoresid', $filtros['padresotutoresid']);
        }
        if (isset($filtros['empresaid'])) {
            $result->andWhere('em.empresaid = :empresaid')
                ->setParameter('empresaid', $filtros['empresaid']);
        }
        return  $result->getQuery()->getResult();
    }
}
