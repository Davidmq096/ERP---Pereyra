<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Directorio escolar
 *
 * @author david
 */
class DirectorioEscolarDB extends BaseDBManager {

    public function BuscarDirectorios($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('e.directorioescolarid, e.nombredepartamento, e.correoelectronico, e.telefono,
         e.extension, e.nombreresponsable, e.ordendirectorio, e.activo')
        ->from("AppBundle:CeDirectorioescolar", 'e');
        if (isset($filtros['departamento'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['departamento']=str_replace($escape,$escapados,$filtros['departamento']);
        	$result->andWhere('e.nombredepartamento like :departamento')
        	->setParameter('departamento', '%'.$filtros['departamento'].'%');
        }
        if (isset($filtros['activo'])) {
            $result->andWhere('e.activo = :activo')
            ->setParameter('activo', $filtros['activo']);
        }
       $result->orderBy("e.ordendirectorio");
        return $result->getQuery()->getResult();
    }

}
