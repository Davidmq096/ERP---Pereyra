<?php

namespace AppBundle\DB\Mysql\Admisiones;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of documento
 *
 * @author Javier
 */
class DocumentoDB extends BaseDBManager {

    public function BuscarDocumento($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('d')
        ->from("AppBundle:Documento", 'd')
        ->innerJoin('d.tipodocumentoid', 'td');
        if (isset($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
        	$result->andWhere('d.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['nombre'].'%');
        }
        if (isset($filtros['tipodocumentoid'])) {
        	$result->andWhere('td.tipodocumentoid =' . $filtros['tipodocumentoid']);
        }
        return $result->getQuery()->getResult();
    }

}
