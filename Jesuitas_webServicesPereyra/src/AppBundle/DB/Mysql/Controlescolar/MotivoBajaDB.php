<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Filtrado de Tipos de Becas
 *
 * @author Rubén
 */
class MotivoBajaDB extends BaseDBManager
{
    public function BuscarMotivobaja($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("mb")
            ->from("AppBundle:CeMotivobaja", 'mb')
            ->groupby('mb.motivobajaid');

            if (isset($filtros['descripcion'])) {
                $escape=array("_","%");
                $escapados=array("\_","\%");
                $filtros['descripcion']=str_replace($escape,$escapados,$filtros['descripcion']);
                $result->andWhere('mb.nombre like :descripcion')
                    ->setParameter('descripcion', '%' . $filtros['descripcion'] . '%');
            }
            if (isset($filtros['tipobajaid'])) {
                $result->andWhere('mb.tipobajaid =' . $filtros['tipobajaid']);
            }
            if (isset($filtros['activo'])) {
                $result->andWhere('mb.activo =' . $filtros['activo']);
            }
            if (isset($filtros['clave'])) {
                $escape=array("_","%");
                $escapados=array("\_","\%");
                $filtros['clave']=str_replace($escape,$escapados,$filtros['clave']);
                $result->andWhere('mb.clavesegdgb like :clave')
                    ->setParameter('clave', '%' . $filtros['clave'] . '%');
            }

        return $result->getQuery()->getResult();
    }

  

}