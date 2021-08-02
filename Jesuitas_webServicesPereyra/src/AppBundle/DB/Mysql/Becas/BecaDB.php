<?php

namespace AppBundle\DB\Mysql\Becas;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Filtrado de fondos de orfandad
 *
 * @author Judith
 */
class BecaDB extends BaseDBManager
{

    public function BuscarBecas($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("GroupConcat(b.becaid) becaid, c.nombre ciclo, c.cicloid, a.alumnoid, a.matricula, 
        CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) nombre,
        n.nivelid, CONCAT_WS(' de ', g.grado,n.nombre) gradodestino, g.gradoid, n.nivelid, CONCAT_WS(' de ', go.grado,no.nombre) gradoorigen, 
        case when calculaAdeudo(a.alumnoid) > 0 then 1 else 0 end as cobranza,

        bsep.becaid sepid, psep.porcentajebecaid as sepporcentajeid,psep.descripcion as sep, esep.descripcion as sepestatus, tsep.tipobecaid as septipobecaid, ssep.solicitudid sepfolio,

        binstituto.becaid institutoid, pinstituto.porcentajebecaid as institutoporcentajeid, pinstituto.descripcion as instituto, einstituto.descripcion as institutoestatus,  tinstituto.tipobecaid as institutotipobecaid, sinstituto.solicitudid institutofolio,

        be.becaid exeid, pexec.porcentajebecaid as excelenciaporcentajeid, pexec.descripcion as excelencia, eexec.descripcion as excelenciaestatus, texec.tipobecaid as excelenciatipobecaid, sexec.solicitudid excelenciafolio")
            ->from("AppBundle:BcBecas", 'b')
            ->innerJoin('b.alumnoid', 'a')
            ->innerJoin('b.cicloid', 'c')
            ->innerJoin('b.gradoid', 'g')
            ->innerJoin('g.nivelid', 'n')
            ->leftJoin('b.gradoidorigen', 'go')
            ->leftJoin('go.nivelid', 'no')            

            ->leftJoin('AppBundle:BcBecas', 'bsep', Expr\Join::WITH, 'a.alumnoid = bsep.alumnoid and bsep.cicloid = c.cicloid and bsep.tipobecaid = 3')
            ->leftJoin('bsep.tipobecaid', 'tsep')
            ->leftJoin('bsep.estatusid', 'esep')
            ->leftJoin('bsep.porcentajebecaid', 'psep')
            ->leftJoin('AppBundle:BcBecasporsolicitud', 'bssep', Expr\Join::WITH, 'bssep.becaid = bsep.becaid')
            ->leftJoin('bssep.solicitudid','ssep')

            ->leftJoin('AppBundle:BcBecas', 'binstituto', Expr\Join::WITH, 'a.alumnoid = binstituto.alumnoid and binstituto.cicloid = c.cicloid and binstituto.tipobecaid = 1')
            ->leftJoin('binstituto.tipobecaid', 'tinstituto')
            ->leftJoin('binstituto.estatusid', 'einstituto')
            ->leftJoin('binstituto.porcentajebecaid', 'pinstituto')
            ->leftJoin('AppBundle:BcBecasporsolicitud', 'bsinstituto', Expr\Join::WITH, 'bsinstituto.becaid = binstituto.becaid')
            ->leftJoin('bsinstituto.solicitudid','sinstituto')

            ->leftJoin('AppBundle:BcBecas', 'be', Expr\Join::WITH, 'a.alumnoid = be.alumnoid and be.cicloid = c.cicloid  and be.tipobecaid = 2')
            ->leftJoin('be.tipobecaid', 'texec')
            ->leftJoin('be.estatusid', 'eexec')
            ->leftJoin('be.porcentajebecaid', 'pexec')
            ->leftJoin('AppBundle:BcBecasporsolicitud', 'bsexec', Expr\Join::WITH, 'bsexec.becaid = be.becaid')
            ->leftJoin('bsexec.solicitudid','sexec')

            ->groupBy('a.alumnoid');
        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid IN (:cicloid)')
                ->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid IN (:gradosid)')
                ->setParameter('gradosid', $filtros['gradoid']);
        }
        if (isset($filtros['nombre'])) {
            $result->andWhere('a.primernombre like :Nombre')
                ->setParameter('Nombre', '%' . $filtros['nombre'] . '%');
        }
        if (isset($filtros['apellidopaterno'])) {
            $result->andWhere('a.apellidopaterno like :ApellidoP')
                ->setParameter('ApellidoP', '%' . $filtros['apellidopaterno'] . '%');
        }
        if (isset($filtros['apellidomaterno'])) {
            $result->andWhere('a.apellidomaterno like :ApellidoM')
                ->setParameter('ApellidoM', '%' . $filtros['apellidomaterno'] . '%');
        }
        if (isset($filtros['matricula'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['matricula']=trim(str_replace($escape,$escapados,$filtros['matricula']));
            $result->andWhere('a.matricula like :matricula')
            ->setParameter('matricula', '%' . $filtros['matricula'] . '%');;
        }
        if (isset($filtros['estatusid'])) {
            $result->andWhere('b.estatusid =' . $filtros['estatusid']);
        }
        if (isset($filtros['tipobecaid'])) {
            $result->andWhere('tb.tipobecaid =' . $filtros['tipobecaid']);
        }
        return $result->getQuery()->getResult();
    }

}
