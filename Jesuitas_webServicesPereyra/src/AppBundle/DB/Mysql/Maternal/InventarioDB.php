<?php

namespace AppBundle\DB\Mysql\Maternal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Inventario
 *
 * @author Mariano
 */
class InventarioDB extends BaseDBManager
{

    public function BuscarInventario($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("i")
            ->from("AppBundle:MaInventario", "i");
        if (isset($filtros['descripcion'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['descripcion'] = str_replace($escape, $escapados, $filtros['descripcion']);
            $result->andWhere('i.descripcion like :descripcion')
                ->setParameter('descripcion', '%' . $filtros['descripcion'] . '%');
        }

        return $result->getQuery()->getResult();
    }


    public function BuscarHijo($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a")
            ->from("AppBundle:CeClavefamiliar", "cf")
            ->innerJoin("AppBundle:CePadresotutoresclavefamiliar", 'ptcf', Expr\Join::WITH, "cf.clavefamiliarid = ptcf.clavefamiliarid")
            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", 'acf', Expr\Join::WITH, "cf.clavefamiliarid = acf.clavefamiliarid")
            ->innerJoin("AppBundle:CeAlumno", 'a', Expr\Join::WITH, "acf.alumnoid = a.alumnoid");
        if (isset($filtros['padresotutoresid'])) {
            $result->andWhere('ptcf.padresotutoresid = :padresotutoresid')
                ->setParameter('padresotutoresid', $filtros["padresotutoresid"]);
        }

        return $result->getQuery()->getResult();
    }
}
