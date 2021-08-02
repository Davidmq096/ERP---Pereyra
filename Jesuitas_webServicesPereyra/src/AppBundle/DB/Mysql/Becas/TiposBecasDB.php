<?php

namespace AppBundle\DB\Mysql\Becas;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Filtrado de Tipos de Becas
 *
 * @author Rubén
 */
class TiposBecasDB extends BaseDBManager
{

    public function BuscarTiposBecas($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("tb, GroupConcat(DISTINCT n.letra, '' Order by n.letra ) niveles")
            ->from("AppBundle:BcTipobeca", 'tb')
            ->leftJoin('AppBundle:BcTipobecapornivel', 'tbn', Expr\Join::WITH, 'tbn.tipobecaid = tb.tipobecaid')
            ->leftJoin('tbn.nivelid', 'n')
            ->leftJoin('AppBundle:BcPorcentajebecapornivel', 'pbn', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.nivelid = pbn.nivelid and pbn.tipobecaid = tb.tipobecaid')
            ->leftJoin('pbn.porcentajebecaid', 'pb');
        $result->groupBy('tb.tipobecaid');
        return $result->getQuery()->getResult();
    }

    public function BuscarPorcentajesPorNivel($id)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pbn, tbn.afectainscripcion, IDENTITY (pbn.tipobecaid) tipobecaid")
            ->from("AppBundle:BcPorcentajebecapornivel", 'pbn')
            ->innerJoin('pbn.nivelid', 'n')
            ->innerJoin('AppBundle:BcTipobecapornivel', 'tbn', Expr\Join::WITH, 'tbn.nivelid = n.nivelid and tbn.tipobecaid = pbn.tipobecaid')
            ->andWhere('pbn.tipobecaid =' . $id);
        
        return $result->getQuery()->getResult();
    }

    public function EliminarTipoBecaPorNivel($filtros)
    {
        try {
            $qb = $this->em->getConnection();
            //AGREGAR TIPO DE BECA
            $sql = "DELETE FROM bc_porcentajebecapornivel WHERE PorcentajeBecaId=? and NivelId=? and TipoBecaId=?";
            $stmt = $qb->prepare($sql);
            $stmt->execute([$filtros['porcentajebecaid'], $filtros['nivelid'], $filtros['tipobecaid']]);

            //$qbn = $this->em->createQueryBuilder();
            $qbcount = $this->em->createQueryBuilder();
            $result = $qbcount->select("COUNT(pbpn)")
                ->from("AppBundle:BcPorcentajebecapornivel", 'pbpn')
                ->andWhere('pbpn.nivelid =' . $filtros['nivelid'])
                ->andWhere('pbpn.tipobecaid =' . $filtros['tipobecaid'])
                ->getQuery()
                ->getResult();

            if ($result[0]['1'] == "0") {
                $sqldelete = "DELETE FROM bc_tipobecapornivel WHERE NivelId=? and TipoBecaId=?";
                $stmtdelete = $qb->prepare($sqldelete);
                $stmtdelete->execute([$filtros['nivelid'], $filtros['tipobecaid']]);
            }
            return true;
        } catch (Exceptio $e) {
            return false;
        }
    }

}
