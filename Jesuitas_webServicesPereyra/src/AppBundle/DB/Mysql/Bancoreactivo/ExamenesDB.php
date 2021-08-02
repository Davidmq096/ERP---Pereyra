<?php

namespace AppBundle\DB\Mysql\Bancoreactivo;

use AppBundle\DB\Mysql\BaseDBManager;
/**
 * Description of Paises
 *
 * @author Javier
 */
class ExamenesDB extends BaseDBManager {

    public function BuscarExamenes($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('e')
        ->from("AppBundle:BrExamen", 'e')
        ->innerJoin("e.cicloid", "c")
        ->innerJoin("e.materiaid", "m")
        ->innerJoin("e.areaid", "a")
        ->innerJoin("a.nivelid", "n")
        ->leftJoin("e.gradoid", "g")
        ->innerJoin("e.tipoexamenid", "te")
        ->innerJoin("e.sistemacalificacionid", "sc");
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid =' . $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid IN (:gradosid)')
        	->setParameter('gradosid' , $filtros['gradoid']);
        }
        if (isset($filtros['areaid'])) {
        	$result->andWhere('a.areaacademicaid =' . $filtros['areaid']);
        }
        if (isset($filtros['materiaid'])) {
        	$result->andWhere('m.materiaid =' . $filtros['materiaid']);
        }
        if (isset($filtros['tipoexamenesid'])) {
        	$result->andWhere('te.tipoexamenesid =' . $filtros['tipoexamenesid']);
        }
        if (isset($filtros['sistemacalificacionid'])) {
        	$result->andWhere('sc.sistemacalificacionid =' . $filtros['sistemacalificacionid']);
        }
        return $result->getQuery()->getResult();
    }
    
    public function BuscarExamenesEspecificaciones($id) {
    	$qb = $this->em->createQueryBuilder();
    	$result = $qb->select('r.ambitoseje, count(r) as items, SUM(CASE WHEN r.gradodificultadid = 1 then 1 ELSE 0 end) AS bajo,
  														SUM(CASE WHEN r.gradodificultadid = 2 then 1 ELSE 0 end) AS medio,
  														SUM(CASE WHEN r.gradodificultadid = 3 then 1 ELSE 0 end)AS alto,
   														SUM(r.valor) AS ponderaciones')
    	->from("AppBundle:BrReactivoporexamen", 'er')
    	->innerJoin("er.examenid", "e")
    	->innerJoin("er.reactivoid", "r")
    	->where("e.examenid =".$id)
    	->groupBy("r.ambitoseje");
    	return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

}
