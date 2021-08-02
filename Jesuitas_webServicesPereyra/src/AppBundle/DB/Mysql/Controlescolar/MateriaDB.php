<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\Entity\Materia;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Materia
 *
 * @author Rubén
 */
class MateriaDB extends BaseDBManager {

    public function FiltrarMaterias($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("m")
            ->from("AppBundle:Materia", 'm')                        
            ->orderBy('m.materiaid', 'DESC');  
            
        if (isset($filtros['clave']) && !empty($filtros['clave'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['clave']=str_replace($escape,$escapados,$filtros['clave']);
            $result->andWhere('m.clave like :clave')
	        ->setParameter('clave', '%'.$filtros['clave'].'%');             
        }       

        if (isset($filtros['nombre']) && !empty($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
            $result->andWhere('m.nombre like :nombre')
	        ->setParameter('nombre', '%'.$filtros['nombre'].'%');             
        } 

        if (isset($filtros['alias']) && !empty($filtros['alias']) ) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['alias']=str_replace($escape,$escapados,$filtros['alias']);
            $result->andWhere('m.alias like :alias')
	        ->setParameter('alias', '%'.$filtros['alias'].'%');                
        } 

        if (isset($filtros['materiapadreid']) && !empty($filtros['materiapadreid'])) {
            $result->andWhere('m.materiapadreid =' . $filtros['materiapadreid']);
        } 

        if (count($filtros['nivelid'])>0) {
            $result->andWhere('m.nivelid in (:nivelid)')
            ->setParameter('nivelid', $filtros['nivelid']);
        }
        
        if (!isset($filtros['essubmateria']) && empty($filtros['essubmateria']) && $filtros['essubmateria'] == NULL) {
        }else{
            $result->andWhere('m.essubmateria =' . $filtros['essubmateria']);
        }

        if (isset($filtros['areaacademicaid']) ) {
            $result->andWhere('m.areaacademicaid =' . $filtros['areaacademicaid']);
        }

        if (isset($filtros['clasificadorparaescolaresid']) ) {
            $result->andWhere('m.clasificadorparaescolaresid =' . $filtros['clasificadorparaescolaresid']);
        }
        
        if (isset($filtros['activo'])) {
            $result->andWhere('m.activo = :activo')
            ->setParameter('activo', $filtros['activo']);
        }
       
        return $result->getQuery()->getResult();
    }

    public function FiltrarMateriasPorNivel($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("m.materiaid, CONCAT(m.clave, ' - ', m.nombre) as nombre")
            ->from("AppBundle:Materia", 'm')                        
            ->orderBy('m.nombre', 'ASC');  
       
        if (isset($filtros['nivelid']) && !empty($filtros['nivelid'])) {
            $result->andWhere('m.nivelid =' . $filtros['nivelid']);
        } 
        
        $result->andWhere('m.activo = 1');
       /*
        if (isset($filtros['activo']) && !empty($filtros['activo']) ) {
            $result->andWhere('m.activo =' . $filtros['activo']);
        }else{
            $result->andWhere('m.activo = 1');
        }
        */
       
        return $result->getQuery()->getResult();
    }

    public function obtenerReporteMaterias($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("(CASE WHEN ma.materiaid is not null THEN 'SI' ELSE 'NO' END) as tienesubs, mppe")
            ->from("AppBundle:Materia", 'm')
            ->join(
                'AppBundle:CeMateriaporplanestudios',
                'mppe',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'mppe.materiaid = m.materiaid')
            ->leftJoin(
                'AppBundle:Materia',
                'ma',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'm.materiaid = ma.materiapadreid')
            ->groupBy('m.materiaid')
            ->orderBy('m.nombre', 'DESC');

            if (!empty($filtros)) {
                $result->andWhere('mppe.planestudioid =' . $filtros);
            }
      

        return $result->getQuery()->getResult();
    }


}