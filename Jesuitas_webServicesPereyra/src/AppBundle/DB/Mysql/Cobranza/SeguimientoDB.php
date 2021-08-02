<?php

namespace AppBundle\DB\Mysql\Cobranza;

use Doctrine\ORM\Query\Expr;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Acuerdos
 *
 * @author Javier
 */
class SeguimientoDB extends BaseDBManager {

    public function BuscarSeguimiento($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("GroupConcat(DISTINCT a.matricula) matricula, c.clavefamiliarid, c.clave,
                         CONCAT_WS(' ', c.apellidopaterno, c.apellidomaterno) familia")
                ->from("AppBundle:CbSeguimiento", 's')
                ->innerJoin("s.clavefamiliarid", "c")
                ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "alcl", Expr\Join::WITH, "alcl.clavefamiliarid = c.clavefamiliarid")
                ->innerJoin("alcl.alumnoid", "a")
                ->groupBy("c.clavefamiliarid");
        if (isset($filtros['matricula'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['matricula']=str_replace($escape,$escapados,$filtros['matricula']);
            $result->andWhere('a.matricula like :matricula')
                    ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }
        if (isset($filtros['clavefamiliar'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['clavefamiliar']=str_replace($escape,$escapados,$filtros['clavefamiliar']);
            $result->andWhere('c.clave like :clave')
                    ->setParameter('clave', '%' . $filtros['clavefamiliar'] . '%');
        }
        if (isset($filtros['apellidopaterno'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidopaterno']=str_replace($escape,$escapados,$filtros['apellidopaterno']);
            $result->andWhere('c.apellidopaterno like :apellidopaterno')
                    ->setParameter('apellidopaterno', '%' . $filtros['apellidopaterno'] . '%');
        }
        if (isset($filtros['apellidomaterno'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidomaterno']=str_replace($escape,$escapados,$filtros['apellidomaterno']);
            $result->andWhere('c.apellidomaterno like :apellidomaterno')
                    ->setParameter('apellidomaterno', '%' . $filtros['apellidomaterno'] . '%');
        }

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

}
