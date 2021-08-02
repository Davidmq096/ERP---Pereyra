<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;


/**
 * Description of Bitacora calificaciones
 *
 * @author David Medina
 *  23/07/2019
 */
class BitacoraCalificacionesDB extends BaseDBManager
{
    public function BuscarAspectos($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('cg.aspecto, cg.capturas')
            ->from("AppBundle:CeCriterioevaluaciongrupo", 'cg')
            ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "ppe", Expr\Join::WITH, "ppe.profesorpormateriaplanestudiosid = cg.profesorpormateriaplanestudiosid")
            ->innerJoin("AppBundle:CeMateriaporplanestudios", "mp", Expr\Join::WITH, "mp.materiaporplanestudioid = ppe.materiaporplanestudioid")
            ->innerJoin("cg.periodoevaluacionid", "p")
            ->andWhere('p.periodoevaluacionid =' . $filtros['periodoid'])
            ->andWhere('mp.materiaporplanestudioid =' . $filtros['materiaid'])
            ->andWhere('ppe.grupoid =' . $filtros['grupoid'])
            ->groupBy('cg.criterioevaluaciongrupoid');

        return $result->getQuery()->getResult();
    }
}
