<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Ciudades
 *
 * @author Javier
 */
class CiudadesDB extends BaseDBManager
{

    public function BuscarCiudades($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('m.municipioid, m.nombre, m.activo, e.estadoid, e.nombre estado, p.paisid, p.nombre pais')
            ->from("AppBundle:Municipio", 'm')
            ->innerJoin('m.estadoid', 'e')
            ->innerJoin('e.paisid', 'p');
        if (isset($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
            $result->andWhere('m.nombre like :nombre')
                ->setParameter('nombre', '%' . $filtros['nombre'] . '%');
        }
        if (isset($filtros['estadoid'])) {
            $result->andWhere('e.estadoid =' . $filtros['estadoid']);
        }
        if (isset($filtros['paisid'])) {
            $result->andWhere('p.paisid =' . $filtros['paisid']);
        }
        if (isset($filtros['activo'])) {
            $result->andWhere('m.activo = :activo')
                ->setParameter('activo', $filtros['activo']);
        }
        $result->orderBy("m.nombre");
        return $result->getQuery()->getResult();
    }

}
