<?php

namespace AppBundle\DB\Mysql;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of documento
 *
 * @author Inceptio
 */

class PortalFamiliarDB extends BaseDBManager 
{
    //Método para obtener vigencia de actualización de datos de los alumnos en el portal familiar
    public function GetVigenciaPeriodoActualizacion()
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("  case when  (p.fechainicio <= CURRENT_DATE()  AND p.fechafin >= CURRENT_DATE())  then true else false end as vigente")
            ->from("AppBundle:CePeriodoactualizacion", 'p')
            ->innerJoin('AppBundle:Ciclo', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.cicloid = p.cicloid');
            $qb->andWhere('p.activo = 1');
            $qb->groupBy('c.cicloid');

        return $result->getQuery()->getResult();
    }        

}
