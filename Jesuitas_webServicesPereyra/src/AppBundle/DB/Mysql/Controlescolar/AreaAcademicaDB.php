<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Areas
 *
 * @author Mariano
 */
class AreaAcademicaDB extends BaseDBManager {

    public function BuscarAreas($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.areaacademicaid, a.nombre, a.clave, a.activo, n.nivelid, n.nombre nivel, u.usuarioid, concat_ws(' ', p.apellidopaterno, p.apellidomaterno, p.nombre) usuario")
        ->from("AppBundle:CeAreaacademica", 'a')
        ->innerJoin("a.nivelid", "n")
        ->leftJoin("a.usuarioid", 'u')
        ->leftJoin("u.personaid", 'p');  
        if (isset($filtros['area'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
        	$result->andWhere('a.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['area'].'%');
        }
        if (isset($filtros['clave'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['clave']=str_replace($escape,$escapados,$filtros['clave']);
        	$result->andWhere('a.clave like :clave')
        	->setParameter('clave', '%'.$filtros['clave'].'%');
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['usuarioid'])) {
        	$result->andWhere('u.usuarioid = :usuarioid')
        	->setParameter('usuarioid' , $filtros['usuarioid']);
        }
        return $result->getQuery()->getResult();
    }

}
