<?php

namespace AppBundle\DB\Mysql\Admisiones;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Colonias
 *
 * @author Javier
 */
class DocumentoGradoDB extends BaseDBManager {

    public function BuscarDocumentoGrado($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("dg, GroupConcat(g.grado, '° ' Order by g.grado ), GroupConcat(g.gradoid, '' Order by g.gradoid )")
        ->from("AppBundle:Documentoporgrado", 'dg')
        ->innerJoin('dg.documentoid', 'd')
        ->innerJoin('d.tipodocumentoid', 'td')
        ->innerJoin("dg.gradoid", 'g')
        ->innerJoin('g.nivelid', 'n')
        ->groupBy('d.documentoid, g.gradoid');
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid IN (:gradosid)')
        	->setParameter('gradosid' , $filtros['gradoid']);
        }
        if (isset($filtros['documentoid'])) {
        	$result->andWhere('d.documentoid =' . $filtros['documentoid']);
        }
        if (isset($filtros['original'])) {
        	$result->andWhere('dg.original =' . $filtros['original']);
        }
        if (isset($filtros['copia'])) {
        	$result->andWhere('dg.copia =' . $filtros['copia']);
        }
        if (isset($filtros['tipoformato'])) {
            $result->andWhere('d.tipodocumentoid =' . $filtros['tipoformato']);
        }
        return $result->getQuery()->getResult();
    }

}
