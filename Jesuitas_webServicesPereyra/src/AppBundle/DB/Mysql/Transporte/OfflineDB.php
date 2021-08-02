<?php

namespace AppBundle\DB\Mysql\Transporte;

use Doctrine\ORM\Query\Expr;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Inscripcion
 *
 * @author Javier
 */
class OfflineDB extends BaseDBManager
{

    public function OfflineDescargar($filtros)
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
        $gradoactual = $this->em->createQueryBuilder()->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = (" . $ultimociclo . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid");

        $qb = $this->em->createQueryBuilder();
        $suspendido = $qb->select('CASE 
        WHEN acs.suspenderinicio is not null THEN 
            (CASE WHEN :fecha BETWEEN acs.suspenderinicio and acs.suspenderfin THEN 1 ELSE 0 END)
        ELSE 0 END')
            ->from("AppBundle:TpAlumnoporcontrato", "acs")
            ->where("act.alumnoporcontratoid = acs.alumnoporcontratoid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $cancelado = $qb->select('CASE 
        WHEN acs2.fechacancelacion is not null THEN 
            (CASE WHEN :fecha >= acs2.fechacancelacion THEN 1 ELSE 0 END)
        ELSE 0 END')
            ->from("AppBundle:TpAlumnoporcontrato", "acs2")
            ->where("act.alumnoporcontratoid = acs2.alumnoporcontratoid")
            ->getQuery()->getDQL();


        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("u.usuarioid,a.alumnoid, a.matricula, e.nombre estatusalumno,
        CONCAT_WS(' ',a.apellidopaterno,a.apellidomaterno, a.primernombre,a.segundonombre) alumno,  concat(pa.valor, '/api/Alumno/foto?alumnoid=', a.alumnoid) as foto,
        n.nombre nivel, g.grado, gr.nombre grupo, 
        GroupConcat(p.correo SEPARATOR ', ') correos, GroupConcat(p.celular SEPARATOR ', ') telefonos,
        'Contrato' tipo, c.contratoid, (:NULL) as escaneado, ec.contratoestatusid, ec.nombre estatus,
        GroupConcat(DISTINCT r.rutaid SEPARATOR ', ') AS rutaid, GroupConcat(DISTINCT r.nombre SEPARATOR ', ') AS ruta
        ")
            ->from('AppBundle:TpContrato', 'c')
            ->innerJoin('AppBundle:TpAlumnoruta', 'rc', Expr\Join::WITH, 'c.contratoid = rc.contratoid and :fecha BETWEEN c.vigenciainicio and c.vigenciafin')
            ->innerJoin('rc.rutaid', "r")
            ->innerJoin('AppBundle:TpAlumnoporcontrato', 'act', Expr\Join::WITH, 'act.alumnoid = rc.alumnoid and c.contratoid = act.contratoid and 0 = (' . $suspendido . ') and 0 = (' . $cancelado . ')')
            ->innerJoin('act.contratoestatusid', 'ec')
            ->innerJoin("act.alumnoid", "a")
            ->innerJoin('a.alumnoestatusid', 'e')
            ->leftJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and ac.gradoid = (" . $gradoactual . ") and ac.cicloid = (" . $ultimociclo2 . ")")
            ->leftJoin("AppBundle:Grado", "g", Expr\Join::WITH, "ac.gradoid = g.gradoid")
            ->leftJoin("g.nivelid", "n")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnoporcicloid = ac.alumnoporcicloid")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid AND gr.tipogrupoid = 1")
            ->leftJoin("AppBundle:Usuario", "u", Expr\Join::WITH, 'a.alumnoid = u.alumnoid')
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'pf', Expr\Join::WITH, 'c.clavefamiliarid = pf.clavefamiliarid')
            ->leftJoin("pf.padresotutoresid", 'p')
            ->andWhere("ec.contratoestatusid IN (1,2) and e.alumnoestatusid <> 2")
            ->setParameter("fecha", $filtros["fecha"]) 
            ->setParameter("NULL", null) 
            ->groupBy("act.alumnoporcontratoid")
            ->from('AppBundle:Parametros', 'pa')
            ->andWhere("pa.nombre = 'URLServicios' ");
        $contratos = $result->getQuery()->getResult();


        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("u.usuarioid, a.alumnoid, a.matricula, e.nombre estatusalumno,
        CONCAT_WS(' ',a.apellidopaterno,a.apellidomaterno, a.primernombre,a.segundonombre) alumno, concat(pa.valor, '/api/Alumno/foto?alumnoid=', a.alumnoid) as foto,
        n.nombre nivel, g.grado, gr.nombre grupo, 
        GroupConcat(distinct p.correo SEPARATOR ', ') correos, GroupConcat(distinct p.celular SEPARATOR ', ') telefonos,
        'Boleto' tipo, b.boletoid, b.escaneado, 0 contratoestatusid, '' estatus,
        r.rutaid, r.nombre AS ruta
        ")
            ->from('AppBundle:TpBoleto', 'b')
            ->innerJoin("b.rutaid", "r")
            ->innerJoin("b.alumnoid", "a")
            ->innerJoin('a.alumnoestatusid', 'e')
            ->leftJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and ac.gradoid = (" . $gradoactual . ") and ac.cicloid = (" . $ultimociclo2 . ")")
            ->leftJoin("AppBundle:Grado", "g", Expr\Join::WITH, "ac.gradoid = g.gradoid")
            ->leftJoin("g.nivelid", "n")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnoporcicloid = ac.alumnoporcicloid")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid AND gr.tipogrupoid = 1")
            ->leftJoin("AppBundle:Usuario", "u", Expr\Join::WITH, 'a.alumnoid = u.alumnoid')
            ->leftJoin("AppBundle:CeAlumnoporclavefamiliar", "af", Expr\Join::WITH, 'a.alumnoid = af.alumnoid')
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'pf', Expr\Join::WITH, 'af.clavefamiliarid = pf.clavefamiliarid')
            ->leftJoin("pf.padresotutoresid", 'p')
            ->andWhere("b.fecha = :fecha")
            ->setParameter("fecha", $filtros["fecha"])
            ->groupBy("b.boletoid")
            ->from('AppBundle:Parametros', 'pa')
            ->andWhere("pa.nombre = 'URLServicios' ");
        $boletos = $result->getQuery()->getResult();

        return array_merge($contratos, $boletos);
    }
}
