<?php

namespace AppBundle\DB\Mysql\Cobranza;

use Doctrine\ORM\Query\Expr;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Pagos admisión
 *
 * @author David
 */
class PagosAdmisionDB extends BaseDBManager {

    public function BuscarPagosAdmision($filtros) {

        
        $qb = $this->em->createQueryBuilder();
        $pagos = $qb->select("sum(pd2.importe)")
        ->from("AppBundle:CjPagodetalle", "pd2")
        ->innerJoin("AppBundle:CjPago", "p2", Expr\Join::WITH, "pd2.pagoid = p2.pagoid and p2.pagoestatusid <> 3")
        ->innerJoin("AppBundle:Parametros", "par2", Expr\Join::WITH, "par2.nombre = 'SubConceptoInscripcionCicloActual'")
        ->innerJoin("AppBundle:CjDocumentoporpagar", "dp2", Expr\Join::WITH, "dp2.documentoporpagarid = pd2.documentoporpagarid and REGEXP(dp2.documento, '....00.*') = true")
        ->innerJoin("dp2.alumnoid", "a2")
        ->innerJoin("dp2.cicloid", "c2")   
        ->Where("a2.alumnoid = a.alumnoid and c2.cicloid = c.cicloid");
        $pagos->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $clavefamilia = $qb->select("min(cf.clave)")
        ->from("AppBundle:CeAlumnoporclavefamiliar", "acf")
        ->innerJoin("acf.clavefamiliarid", "cf")  
        ->Where("acf.alumnoid = a.alumnoid");
        $clavefamilia->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("groupconcat(dp.documentoporpagarid), c.nombre ciclo, n.nombre nivel, g.grado, s.folio as foliosolicitud, sum(dp.importe) importeinscripcion,
        d.nombre, d.apellidopaterno, d.apellidomaterno, a.matricula,
        es.estatus estatussolicitud, s.impresa documentosimpresos, es.estatussolicitudid, s.pagado examenpagado,
        s.entregada documentosentregados, s.documentosfirmados as documentosrecibidos, 
        sum((dp.saldo - dp.descuento)) saldoinscripcion,
        CASE WHEN sum(dp.importe) = sum(dp.saldo) THEN 'PENDIENTE' WHEN (sum(dp.saldo) < sum(dp.importe)) and (sum(dp.saldo) > 0) THEN 'PAGO PARCIAL' WHEN sum(dp.saldo) = 0 THEN 'PAGADO' ELSE '' END as pagoinscripcion")
        ->addSelect("(SELECT min(dm.dictamen) from AppBundle:Dictamen dm where dm.solicitudadmisionid = s.solicitudadmisionid) dictamen") 
        ->addSelect("(" . $pagos . ") as pagosincripcion")
        ->addSelect("(" . $clavefamilia . ") as clavefamiliar")
        ->from("AppBundle:Solicitudadmision", 's')
        ->innerJoin("AppBundle:Solicitudadmisionporciclo", "sc", Expr\Join::WITH, "s.solicitudadmisionid = sc.solicitudadmisionid")
        ->leftJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = s.alumnoid")
        ->innerJoin("s.datoaspiranteid", "d")
        ->innerJoin("sc.cicloid", "c")
        ->innerJoin("s.gradoid", "g")
        ->innerJoin("g.nivelid", "n")
        ->innerJoin("s.estatussolicitudid", "es")
        ->innerJoin("AppBundle:Parametros", "paro", Expr\Join::WITH, "paro.nombre = 'SubConceptoInscripcionCicloActual'")
        ->leftJoin("AppBundle:CjDocumentoporpagar", "dp", Expr\Join::WITH, "dp.alumnoid = a.alumnoid and dp.cicloid = c.cicloid and REGEXP(dp.documento, '....00.*') = true ")
        ->leftJoin("AppBundle:CjDocumento", "dpd", Expr\Join::WITH, "dpd.documentoid = dp.documentoid and dpd.tipodocumento = 1")
        ->where("es.estatussolicitudid in (5,6,8)")
        ->groupBy("s.solicitudadmisionid");  
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid = '.$filtros['cicloid']);
        }

        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid ='.$filtros['nivelid']);
        }

        if (count($filtros['gradoid']) > 0) {
            $result->andWhere('g.gradoid IN (:gradosid)')
                ->setParameter('gradosid', $filtros['gradoid']);
        }

        if (isset($filtros['foliosolicitud'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['foliosolicitud']=trim(str_replace($escape,$escapados,$filtros['foliosolicitud']));
            $result->andWhere('s.folio like :foliosolicitud')
                ->setParameter('foliosolicitud', '%' . $filtros['foliosolicitud'] . '%');
        }

        if (isset($filtros['matricula'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['matricula']=trim(str_replace($escape,$escapados,$filtros['matricula']));
            $result->andWhere('a.matricula like :matricula')
                ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }

        if (isset($filtros['clavefamiliar'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['clavefamiliar']=trim(str_replace($escape,$escapados,$filtros['clavefamiliar']));
            $result->having('clavefamiliar =' . $filtros['clavefamiliar']);
        }

        if (isset($filtros['inscripcionpagada'])) {
            if ($filtros['inscripcionpagada'] == 1) {
                $result->andHaving("pagoinscripcion = 'PAGADO' ");
            } else {
                $result->andHaving("pagoinscripcion <> 'PAGADO' ");
            }
        }

        if (isset($filtros['pagoinscripcionid'])) {
            if ($filtros['pagoinscripcionid'] == 1) {
                $result->andHaving("pagoinscripcion = 'PENDIENTE' ");
            } else if ($filtros['pagoinscripcionid'] == 2) {
                $result->andHaving("pagoinscripcion = 'PAGO PARCIAL' ");
            } else if ($filtros['pagoinscripcionid'] == 3) {
                $result->andHaving("pagoinscripcion = 'PAGADO' ");
            }
        }

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

}
