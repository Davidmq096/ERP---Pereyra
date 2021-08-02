<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asignacion materia
 *
 * @author Gabriel, Rubén
 */
class AlumnoDB extends BaseDBManager
{

    public function getFotosAlumnos($alumnoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.nombre ciclo,n.nombre nivel,g.grado, concat(pa.valor, '/api/Alumno/foto?alumnoid=', a.alumnoid, '&alumnoporcicloid=', ac.alumnoporcicloid) as foto")
            ->from("AppBundle:CeAlumnoporciclo", "ac")
            ->innerJoin('ac.alumnoid', 'a')
            ->innerJoin("AppBundle:CeAlumnociclofoto", "af", Expr\Join::WITH, "ac.alumnoporcicloid = af.alumnoporcicloid")
            ->innerJoin('ac.gradoid', 'g')
            ->innerJoin('g.nivelid', 'n')
            ->innerJoin('ac.cicloid', 'c')
            ->where('ac.alumnoid = ' . $alumnoid)

            ->from('AppBundle:Parametros', 'pa')
            ->andWhere("pa.nombre = 'URLServicios' ");
        return $result->getQuery()->getResult();
    }


    public function GetAlumno($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, CONCAT_WS(' ', a.primernombre, a.segundonombre)  nombre, a.apellidopaterno, a.apellidomaterno, 
                               a.matricula, a.intercambio,
                               ae.alumnoestatusid, ae.nombre as alumnoestatus,
                               c.cicloid, 
                               gra.grado, gra.gradoid,
                               n.nivelid, n.nombre nivel,
                               gru.grupoid, gru.nombre grupo,
                               mb.motivobajaid, mb.nombre motivobaja,
                               tb.tipobajaid, tb.nombre tipobaja")

            ->from("AppBundle:CeAlumno", "a")
            ->innerJoin("AppBundle:CeAlumnoestatus", "ae", Expr\Join::WITH, "ae.alumnoestatusid = a.alumnoestatusid")
            ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid")
            ->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid = ac.cicloid")
            ->innerJoin("AppBundle:CeAlumnocicloporgrupo", "cg", Expr\Join::WITH, "cg.alumnoporcicloid = ac.alumnoporcicloid")
            ->innerJoin("AppBundle:CeGrupo", "gru", Expr\Join::WITH, "gru.grupoid = cg.grupoid")
            ->innerJoin("AppBundle:Grado", "gra", Expr\Join::WITH, "gra.gradoid = ac.gradoid")
            ->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid = gra.nivelid")
            ->leftJoin("AppBundle:CeMotivobaja", "mb", Expr\Join::WITH, "mb.motivobajaid = ac.motivobajaid")
            ->leftJoin("AppBundle:CeTipobaja", "tb", Expr\Join::WITH, "tb.tipobajaid = mb.tipobajaid");

        $result->andWhere('c.actual = 1');
        $result->andWhere('gru.tipogrupoid = 1')
            ->groupBy("a.alumnoid");

        if ($filtros) {
            if ($filtros["matricula"]) {
                $result->andWhere('a.matricula = ' . $filtros["matricula"]);
            }
            if ($filtros["nombre"]) {
                $result->andWhere('LOWER(CONCAT(coalesce(a.primernombre,\'\'), \'\', coalesce(a.segundonombre,\'\'))) LIKE :nombre')
                    ->setParameter('nombre', $filtros['nombre'] . '%');
            }
            if ($filtros["apellidopaterno"]) {
                $result->andWhere('LOWER(a.apellidopaterno) LIKE :apellidopaterno')
                    ->setParameter('apellidopaterno', $filtros['apellidopaterno'] . '%');
            }
            if ($filtros["apellidomaterno"]) {
                $result->andWhere('LOWER(a.apellidomaterno) LIKE :apellidomaterno')
                    ->setParameter('apellidomaterno', $filtros['apellidomaterno'] . '%');
            }
            if ($filtros["alumnoestatusid"]) {
                $result->andWhere('ae.alumnoestatusid = ' . $filtros["alumnoestatusid"]);
            }
            if ($filtros["tipobajaid"]) {
                $result->andWhere('tb.tipobajaid = ' . $filtros["tipobajaid"]);
            }
            if ($filtros["motivobajaid"]) {
                $result->andWhere('mb.motivobajaid = ' . $filtros["motivobajaid"]);
            }
            if ($filtros["nivelid"]) {
                $result->andWhere('n.nivelid = ' . $filtros["nivelid"]);
            }
            if ($filtros["gradoid"]) {
                $result->andWhere('gra.gradoid = ' . $filtros["gradoid"]);
            }
            if ($filtros["grupoid"]) {
                $result->andWhere('gru.grupoid = ' . $filtros["grupoid"]);
            }
            if ($filtros["intercambio"]) {
                $result->andWhere('a.intercambio = ' . $filtros["intercambio"]);
            }
        }

        return $result->getQuery()->getResult();
    }


    /*
     * Obtiene la nacionalidad de un alumno
     */
    public function GetNacionalidadAlumno($alumnoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("n.nacionalidadid, n.nombre ")
            ->from("AppBundle:Nacionalidad", "n")
            ->innerJoin("AppBundle:CeNacionalidadporalumno", "na", Expr\Join::WITH, "na.nacionalidadid = n.nacionalidadid");

        $result->andWhere('na.alumnoid = ' . $alumnoid);

        return $result->getQuery()->getResult();
    }


    /*
     * Obtiene los examenes de un alumno
     */
    public function GetExamenesAlumno($alumnoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ue usuario, ec, c, ep, e, sc, mr, ceg, pme.profesorpormateriaplanestudiosid, pe.periodoevaluacionid, pe.descripcion,
        ceg.criterioevaluaciongrupoid, ec.numerocaptura,  a.matricula, concat_ws(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre) as nombrecompleto,
        CASE WHEN mpe.materiaporplanestudioid IS NOT NULL THEN mpe.materiaporplanestudioid ELSE mpet.materiaporplanestudioid as materiaporplanestudioid,
        CASE WHEN m.materiaid IS NOT NULL THEN m.materiaid ELSE mt.materiaid as materiaid,
        CASE WHEN m.nombre IS NOT NULL THEN m.nombre ELSE mt.nombre as materia,
        ci.nombre ciclo, n.nombre nivel, g.grado, 
        case when (CURRENT_TIMESTAMP() BETWEEN c.horainicio and c.horafin) then false else true END bloqueo,
        DATE_FORMAT(c.fechaaplicacion,'%d/%m/%Y') fechaaplicacion,
        DATE_FORMAT(c.horainicio,'%H:%i %p') horainicio,
        DATE_FORMAT(c.horafin,'%H:%i %p') horafin
        ")
            ->from("AppBundle:BrUsuarioporexamen", 'ue')
            ->innerJoin("ue.alumnoid", "a")
            ->innerJoin('ue.examenporcalendarioid', 'ec')
            ->leftJoin('ec.criterioevaluaciongrupoid', 'ceg')
            ->leftJoin('ceg.periodoevaluacionid', 'pe')
            ->innerJoin('ec.calendarioexamenid', 'c')
            ->innerJoin('c.cicloid', "ci")
            ->innerJoin('c.gradoid', "g")
            ->innerJoin('g.nivelid', 'n')
            ->leftJoin("AppBundle:CeProfesorpormateriaplanestudios", "pme", Expr\Join::WITH, "pme.profesorpormateriaplanestudiosid = ceg.profesorpormateriaplanestudiosid")
            ->leftJoin("AppBundle:CeMateriaporplanestudios", "mpe", Expr\Join::WITH, "mpe.materiaporplanestudioid = pme.materiaporplanestudioid")
            ->leftJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid = mpe.materiaid")
            ->leftJoin("AppBundle:CeGradoportallercurricular", "gtc", Expr\Join::WITH, "gtc.tallercurricularid = pme.tallerid and gtc.gradoid = g.gradoid")
            ->leftJoin("AppBundle:CeMateriaporplanestudios", "mpet", Expr\Join::WITH, "mpet.materiaporplanestudioid = gtc.materiaporplanestudioid")
            ->leftJoin("AppBundle:Materia", "mt", Expr\Join::WITH, "mt.materiaid = mpet.materiaid")
            ->innerJoin("ec.examenid", "e")
            ->innerJoin("e.sistemacalificacionid", "sc")
            ->innerJoin("e.examenpresentacionid", 'ep')
            ->innerJoin("ep.mostrarreactivoid", "mr")
            ->andWhere("a.alumnoid =" . $alumnoid)
            ->andWhere("c.medioaplicacionid = 1")
            ->orderBy("fechaaplicacion desc, c.calendarioexamenid, ec.orden");

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    /*
     * Obtiene los periodos de evaluacion de un alumno
     */
    public function GetPeriodosevaluacionbyAlumno($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pe.periodoevaluacionid, pe.descripcion, g.gradoid, c.cicloid")
            ->from("AppBundle:CeGradoporconjuntoperiodoescolar", "gpe")
            ->innerJoin("AppBundle:CeConjuntoperiodoevaluacion", "cpe", Expr\Join::WITH, "cpe.conjuntoperiodoevaluacionid = gpe.conjuntoperiodoevaluacionid")
            ->innerJoin("AppBundle:CePeriodoevaluacion", "pe", Expr\Join::WITH, "pe.conjuntoperiodoevaluacionid = cpe.conjuntoperiodoevaluacionid")
            ->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid = cpe.cicloid")
            ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid = gpe.gradoid");
        return $result->getQuery()->getResult();
    }


    /*
     * Obtiene la situacion actual del alumno
     */
    public function GetSituacionActualAlumno($alumnoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ae.alumnoestatusid, ae.nombre as alumnoestatus,
        gru.grupoid, gru.nombre grupo, cg.numerolista,
        mb.motivobajaid, mb.nombre motivobaja, tb.tipobajaid, tb.nombre tipobaja,
        DATE_FORMAT(ac.fechabaja, '%Y-%m-%d') fechabajaegreso,
        DATE_FORMAT(cn.fechafin, '%Y-%m-%d') fechaegreso")
            ->from("AppBundle:CeAlumno", "a")
            ->innerJoin("a.alumnoestatusid", "ae")
            ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid")
            ->innerJoin("AppBundle:Grado", "gra", Expr\Join::WITH, "ac.gradoid = gra.gradoid")
            ->leftJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid = ac.cicloid AND c.actual = 1")
            ->leftJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "c.cicloid = cn.cicloid AND gra.nivelid = cn.nivelid")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "cg", Expr\Join::WITH, "cg.alumnoporcicloid = ac.alumnoporcicloid")
            ->leftJoin("AppBundle:CeGrupo", "gru", Expr\Join::WITH, "gru.grupoid = cg.grupoid AND gru.tipogrupoid = 1")
            ->leftJoin("AppBundle:CeMotivobaja", "mb", Expr\Join::WITH, "mb.motivobajaid = ac.motivobajaid")
            ->leftJoin("AppBundle:CeTipobaja", "tb", Expr\Join::WITH, "tb.tipobajaid = mb.tipobajaid");
        $result->andWhere('a.alumnoid = :alumnoid')
            ->setParameters(array("alumnoid" => $alumnoid))
            ->groupBy("a.alumnoid")
            ->setMaxResults(1);
        return $result->getQuery()->getOneOrNullResult();
    }

    /*
     * Obtiene la fecha de ingreso del alumno
     */
    public function GetFechaIngreso($alumnoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("DATE_FORMAT(min(dp.fechacreacion), '%Y-%m-%d')  fechaingreso, dp.documentoporpagarid")
            ->from("AppBundle:CjDocumentoporpagar", "dp")
            ->innerJoin("AppBundle:CjDocumento", "d", Expr\Join::WITH, "d.documentoid = dp.documentoid");
        $result->andWhere('dp.alumnoid = ' . $alumnoid);
        $result->andWhere('d.tipodocumento = 1');
        $datos = $result->getQuery()->getResult();
        return $datos[0]["fechaingreso"];
    }

    public function BuscarAlumnos($filtros)
    {
        $ultimociclo = $this->em->createQueryBuilder()->select('Case WHEN max(cccauc.cicloid) IS NULL THEN max(cccuc.cicloid) ELSE max(cccauc.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acuc")
            ->innerJoin("acuc.cicloid", "cccuc")
            ->leftJoin("AppBundle:Ciclo", "cccauc", Expr\Join::WITH, "acuc.cicloid = cccauc.cicloid and cccauc.actual = 1")
            ->where("acuc.alumnoid = a.alumnoid")
            ->groupBy('acuc.alumnoid');
        $ultimociclo2 = $this->em->createQueryBuilder()->select('Case WHEN max(cccauc2.cicloid) IS NULL THEN max(cccuc2.cicloid) ELSE max(cccauc2.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acuc2")
            ->innerJoin("acuc2.cicloid", "cccuc2")
            ->leftJoin("AppBundle:Ciclo", "cccauc2", Expr\Join::WITH, "acuc2.cicloid = cccauc2.cicloid and cccauc2.actual = 1")
            ->where("acuc2.alumnoid = a.alumnoid")
            ->groupBy('acuc2.alumnoid');
        if (isset($filtros['alumnoporcicloid'])) {
            $ultimociclo->andWhere('acuc.alumnoporcicloid =' . $filtros['alumnoporcicloid']);
            $ultimociclo2->andWhere('acuc2.alumnoporcicloid =' . $filtros['alumnoporcicloid']);
        }
        if (isset($filtros['cicloactual'])) {
            $ultimociclo->andWhere('cccuc.actual = 1');
            $ultimociclo2->andWhere('cccuc2.actual = 1');
        }
        if (isset($filtros['cicloid'])) {
            $ultimociclo->andWhere('cccuc.cicloid = :cicloid');
            $ultimociclo2->andWhere('cccuc2.cicloid = :cicloid');
        }

        $gradoactual = $this->em->createQueryBuilder()->select('CASE WHEN
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

        $result = $this->em->createQueryBuilder()->select("a.reingresofuturo as reingresofuturo, c.cicloid, a.alumnoid, a.fechanacimiento, ac.alumnoporcicloid, DATE_FORMAT(ac.fechabaja, '%d/%m/%Y') as fechabaja, eac.nombre as estatusalumnocicloid, a.curp, c.nombre as ciclo, a.matricula, a.matriculadgb, a.intercambio, a.oyente, a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno,
        Concat_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) nombrecompleto, a.hijopersonal,
        gr.grupoid, gr.nombre grupo, g.gradoid, g.grado, n.nivelid, n.nombre nivel, mb.permitereingreso, mb.nombre motivobaja, mb.motivobajaid, tb.nombre tipobaja,
        e.alumnoestatusid, e.nombre estatus, case when calculaAdeudo(a.alumnoid) > 0 then true else false end adeudo, tc.nombre tipocobertura,
        a.custodiapersona, a.custodiaoficio, cf.clavefamiliarid, cf.clave, concat(pa.valor, '/api/Alumno/foto?alumnoid=', a.alumnoid) as foto")
            ->from("AppBundle:CeAlumno", 'a')
            ->innerJoin('a.alumnoestatusid', 'e')
            ->leftJoin('AppBundle:CeAlumnoporclavefamiliar', 'cl', Expr\Join::WITH, 'a.alumnoid = cl.alumnoid')
            ->leftJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and ac.gradoid = (" . $gradoactual . ") and ac.cicloid = (" . $ultimociclo2 . ")")
            ->leftJoin("AppBundle:CeAlumnociclofoto", "af", Expr\Join::WITH, "ac.alumnoporcicloid = af.alumnoporcicloid")
            ->leftJoin("ac.motivobajaid", "mb")
            ->leftJoin("mb.tipobajaid", "tb")
            ->leftJoin("ac.cicloid", "c")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnoporcicloid = ac.alumnoporcicloid")
            ->leftJoin("AppBundle:CeEstatusalumnoporciclo", "eac", Expr\Join::WITH, "eac.estatusalumnoporcicloid = ac.estatusalumnocicloid")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid AND gr.tipogrupoid = 1")
            ->leftJoin("AppBundle:Grado", "g", Expr\Join::WITH, "ac.gradoid = g.gradoid")
            ->leftJoin("g.nivelid", "n")
            ->leftJoin('a.tipocoberturaid', 'tc')
            ->leftJoin('cl.clavefamiliarid', 'cf')
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'p', Expr\Join::WITH, 'p.clavefamiliarid = cl.clavefamiliarid')
            ->groupBy('a.alumnoid')
            ->orderBy("a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre")

            ->from('AppBundle:Parametros', 'pa')
            ->andWhere("pa.nombre = 'URLServicios' ");
        if (isset($filtros['cicloactual'])) {
            $result->andWhere('ac.alumnoporcicloid IS NOT NULL');
        }
        if (isset($filtros['alumnoporcicloid'])) {
            $result->andWhere('ac.alumnoporcicloid =' . $filtros['alumnoporcicloid']);
        }
        if (isset($filtros['cicloid'])) {
            $result->andWhere('ac.cicloid = :cicloid')
                ->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['alumnoestatusid'])) {
            $result->andWhere('e.alumnoestatusid IN (:alumnoestatusid)')
                ->setParameter('alumnoestatusid', $filtros['alumnoestatusid']);
        }
        if (isset($filtros['estatusalumnocicloid'])) {
            $result->andWhere('eac.estatusalumnoporcicloid IN (:estatusalumnocicloid)')
                ->setParameter('estatusalumnocicloid', $filtros['estatusalumnocicloid']);
        }
        if (isset($filtros['alumnoid'])) {
            $result->andWhere('a.alumnoid IN (:alumnoid)')
                ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['matricula'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['matricula'] = str_replace($escape, $escapados, $filtros['matricula']);
            if ($filtros["precision"]) {
                $result->andWhere('a.matricula in (:matricula)')
                    ->setParameter('matricula', $filtros['matricula']);
            } else {
                $result->andWhere('a.matricula like :matricula')
                    ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
            }
        }
        if (isset($filtros['nombre'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['nombre'] = str_replace($escape, $escapados, $filtros['nombre']);
            $result->andWhere('a.primernombre like :nombre or a.segundonombre like :nombre')
                ->setParameter('nombre', '%' . $filtros['nombre'] . '%');
        }
        if (isset($filtros['apellidopaterno'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['apellidopaterno'] = str_replace($escape, $escapados, $filtros['apellidopaterno']);
            $result->andWhere('a.apellidopaterno like :apellidopaterno')
                ->setParameter('apellidopaterno', '%' . $filtros['apellidopaterno'] . '%');
        }
        if (isset($filtros['apellidomaterno'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['apellidomaterno'] = str_replace($escape, $escapados, $filtros['apellidomaterno']);
            $result->andWhere('a.apellidomaterno like :apellidomaterno')
                ->setParameter('apellidomaterno', '%' . $filtros['apellidomaterno'] . '%');
        }
        if (count($filtros['nivelid']) > 0) {
            $result->andWhere('n.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (count($filtros['gradoid']) > 0) {
            $result->andWhere('g.gradoid IN (:gradosid)')
                ->setParameter('gradosid', $filtros['gradoid']);
        }
        if (isset($filtros['grupoid'])) {
            $result->andWhere('gr.grupoid IN (:grupoid)')
                ->setParameter('grupoid', $filtros['grupoid']);
        }
        if (isset($filtros['ingrupo'])) {
            $result->andWhere('gr.grupoid IS NOT NULL');
        }
        if (isset($filtros['intercambio'])) {
            $result->andWhere('a.intercambio IN (:intercambio)')
                ->setParameter('intercambio', $filtros['intercambio']);
        }

        if (isset($filtros['oyente'])) {
            $result->andWhere('a.oyente IN (:oyente)')
                ->setParameter('oyente', $filtros['oyente']);
        }

        if (isset($filtros['reingresofuturo'])) {
            $result->andWhere('a.reingresofuturo IN (:reingresofuturo)')
                ->setParameter('reingresofuturo', $filtros['reingresofuturo']);
        }

        if (isset($filtros['padresotutoresid'])) {
            $result->andWhere('p.padresotutoresid = :padresotutoresid')
                ->setParameter('padresotutoresid', $filtros['padresotutoresid']);
        }
        if (isset($filtros['clavefamiliarid'])) {
            $result->andWhere('cf.clavefamiliarid = :clavefamiliarid')
                ->setParameter('clavefamiliarid', $filtros['clavefamiliarid']);
        }

        return $result->getQuery()->getResult();
    }

    public function BuscarAdeudoAlumno($alumnoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, a.matricula, acu.acuerdoid, t.tipoacuerdoid, d.porcentaje,
        CONCAT_WS(' ',a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) nombre,
        Case WHEN CONCAT_WS(' ',a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) like '%*%' THEN true ELSE false END hijopersonal,
                                c.nombre ciclo, s.nombre subconcepto, d.vigenciaacuerdo,
                                d.documentoporpagarid, d.concepto, (d.importe - d.descuento) importe, (d.saldo - d.descuento) as saldo,
                                DATE_FORMAT(d.fechalimitepago, '%d/%m/%Y' ) fechalimitepago, td.tipodocumentoid as tipodocumento,
                                calculaInteres(d.documentoporpagarid) interes,(calculaInteres(d.documentoporpagarid) + (d.saldo - d.descuento)) total, s.generainteres ")
            ->from("AppBundle:CjDocumentoporpagar", 'd')
            ->innerJoin("d.alumnoid", "a")
            ->innerJoin("d.cicloid", "c")
            ->leftJoin("d.acuerdoid", "acu")
            ->leftJoin("d.tipoacuerdoid", "t")
            ->leftJoin("d.subconceptoid", "s")
            ->leftJoin("d.documentoid", "do")
            ->leftJoin("do.tipodocumento", "td")
            ->where("a.alumnoid =" . $alumnoid)
            ->andWhere("d.saldo > 0")
            ->orderBy("d.fechalimitepago, td.tipodocumentoid");
        return $result->getQuery()->getResult();
    }

    public function BuscarAdeudoTotalAlumno($alumnoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('sum((d.saldo - d.descuento)) adeudo, groupconcat(DISTINCT d.documentoporpagarid), sum(calculaInteres(d.documentoporpagarid)) recargo,
                             sum((d.saldo - d.descuento) + calculaInteres(d.documentoporpagarid)) total')
            ->addSelect("(SELECT MAX(DATE_FORMAT(p.fecha, '%d/%m/%Y' )) from AppBundle:CjPago p where p.alumnoid =" . $alumnoid . ") ultimo_pago")
            ->from("AppBundle:CjDocumentoporpagar", 'd')
            ->where("d.alumnoid =" . $alumnoid)
            ->andWhere("d.saldo > 0")
            ->andWhere("d.fechalimitepago < CURRENT_DATE()")
            ->groupBy("d.alumnoid");
        return $result->getQuery()->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function BuscarReciboInscripcionAlumno($alumnoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.primernombre, a.segundonombre, a.apellidomaterno, a.apellidomaterno, a.matricula,
        d.concepto, d.documento, DATE_FORMAT(d.fechalimitepago, '%d/%m/%Y' ) fechalimitepago, d.importe, d.referencia")
            ->from("AppBundle:CjDocumentoporpagar", 'd')
            ->innerJoin("d.cicloid", "c")
            ->innerJoin("d.documentoid", "doc")
            ->innerJoin("d.alumnoid", "a")
            ->where("a.alumnoid =" . $alumnoid)
            ->andWhere("doc.tipodocumento = 1")
            ->andWhere("c.actual = 1");
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function BuscarEstadocuenta($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("d.documentoporpagarid, d.documento, d.concepto, DATE_FORMAT(d.fechalimitepago, '%d/%m/%Y' ) fechalimitepago,
        DATE_DIFF(CURRENT_DATE() , d.fechalimitepago) diasretraso, (d.saldo - d.descuento) as saldo, calculaInteres(d.documentoporpagarid) as recargo, 
        (d.saldo - d.descuento+calculaInteres(d.documentoporpagarid)) total")
            ->from("AppBundle:CjDocumentoporpagar", 'd')
            ->leftJoin("AppBundle:CjPagodetalle", 'pd', Expr\Join::WITH, "d.documentoporpagarid = pd.documentoporpagarid")
            ->leftJoin("pd.pagoid", 'p')
            ->where("d.alumnoid =" . $filtros["alumnoid"])
            ->orderBy("d.fechalimitepago")
            ->groupBy("d.documentoporpagarid");
        switch ($filtros["tipoestadocuenta"]) {
            case 1: //Saldo total del ciclo
                $result->innerJoin("d.cicloid", "c")
                    ->andWhere("c.actual = 1");
                break;
            case 2:  //Solo el saldo vencido
                $result->andWhere("d.saldo > 0")
                    ->andWhere("d.pagoestatusid = 1")
                    ->andWhere("d.fechalimitepago < :hoy")
                    ->setParameter('hoy', new \DateTime());
                break;
            case 3: // Todo el historial de pagos
                break;
            case 4: // Todo el historial de pagos
                $dateinicio = new \DateTime($filtros["fechainicio"]);
                $datefin =  new \DateTime($filtros["fechafin"]);
                $result->andWhere("d.fechalimitepago BETWEEN :fechainicio and :fechafin or p.fecha BETWEEN :fechainicio and :fechafin")
                    ->setParameter("fechainicio", $dateinicio)
                    ->setParameter("fechafin", $datefin);
                break;
        }
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function BuscarTokens($id)
    {
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare('CALL sp_AlumnoTokens(:id)');

        $stmt->execute(array('id' => $id));
        $result = $stmt->fetch();
        return $result;
    }

    public function PlanEstudioAlumno($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p")
            ->from("AppBundle:CeAlumnoporciclo", 'ac')
            ->innerJoin("ac.gradoid", "g")
            ->innerJoin("g.nivelid", "n")
            ->innerJoin('ac.cicloid', 'c')
            ->innerJoin('AppBundle:CeCiclopornivel', 'cn', Expr\Join::WITH, 'c.cicloid = cn.cicloid and n.nivelid = cn.nivelid')

            ->innerJoin("AppBundle:CePlanestudios", 'p', Expr\Join::WITH, 'p.gradoid = g.gradoid')
            ->innerJoin("p.gradoid", "gp")
            ->innerJoin('AppBundle:CeCiclopornivel', 'cnp', Expr\Join::WITH, 'gp.nivelid = cnp.nivelid and (p.cicloinicialid = cnp.cicloid or p.ciclofinalid = cnp.cicloid) and (cnp.fechainicio BETWEEN cn.fechainicio and cn.fechafin OR cnp.fechafin BETWEEN cn.fechainicio and cn.fechafin)')
            //->innerJoin('AppBundle:CeCiclopornivel', 'cnp', Expr\Join::WITH, 'gp.nivelid = cnp.nivelid and (cnp.fechainicio BETWEEN cn.fechainicio and cn.fechafin OR cnp.fechafin BETWEEN cn.fechainicio and cn.fechafin)')
            ->andWhere("ac.alumnoporcicloid = :alumnoporcicloid")
            ->setParameter('alumnoporcicloid', $filtros['alumnoporcicloid'])
            ->setMaxResults(1);
        if (isset($filtros['areaespecializacionid'])) {
            $result->andWhere('p.areaespecializacionid  = :areaespecializacionid')
                ->setParameter('areaespecializacionid', $filtros['areaespecializacionid']);
        }
        return $result->getQuery()->getOneOrNullResult();
    }

    public function UltimaMatriculaAlumno () {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("MAX(CAST(a.matricula as int)) as matricula")
            ->from("AppBundle:CeAlumno", 'a')
            ->andWhere("a.matricula NOT LIKE '9%' ");
        
        return $result->getQuery()->getOneOrNullResult();
    }
}
