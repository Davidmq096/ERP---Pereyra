<?php

namespace AppBundle\DB\Mysql\Controlescolar\AlumnoModal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asignacion materia
 *
 * @author Gabriel, Rubén
 */
class AlumnoBecasDB extends BaseDBManager 
{
    public function AlumnoBuscarBecas($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("b.becaid, c.nombre ciclo, tb.tipobecaid, tb.descripcion tipobeca, 
        pb.porcentajebecaid, pb.descripcion porcentaje, a.alumnoid, a.matricula, 
        CONCAT_WS(' ', a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) nombre,
        n.nivelid, n.nombre nivel, g.grado grado, g.gradoid, e.descripcion estatus,
        case when calculaAdeudo(a.alumnoid) > 0 then 1 else 0 end as cobranza")
            ->from("AppBundle:BcBecas", 'b')
            ->innerJoin('b.alumnoid', 'a')
            ->innerJoin('b.gradoid', 'g')
            ->innerJoin('g.nivelid', 'n')
            ->innerJoin('b.cicloid', 'c')
            ->innerJoin('b.estatusid', 'e')
            ->innerJoin('b.tipobecaid', 'tb')
            ->innerJoin('b.porcentajebecaid', 'pb');
        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid IN (:cicloid)')
                ->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid IN (:gradosid)')
                ->setParameter('gradosid', $filtros['gradoid']);
        }
        if (isset($filtros['nombre'])) {
            $result->andWhere('a.primernombre like :Nombre')
                ->setParameter('Nombre', '%' . $filtros['nombre'] . '%');
        }
        if (isset($filtros['apellidopaterno'])) {
            $result->andWhere('a.apellidopaterno like :ApellidoP')
                ->setParameter('ApellidoP', '%' . $filtros['apellidopaterno'] . '%');
        }
        if (isset($filtros['apellidomaterno'])) {
            $result->andWhere('a.apellidomaterno like :ApellidoM')
                ->setParameter('ApellidoM', '%' . $filtros['apellidomaterno'] . '%');
        }
        if (isset($filtros['matricula'])) {
            $result->andWhere('a.matricula like :matricula')
            ->setParameter('matricula', '%' . $filtros['matricula'] . '%');;
        }
        if (isset($filtros['estatusid'])) {
            $result->andWhere('b.estatusid =' . $filtros['estatusid']);
        }
        if (isset($filtros['tipobecaid'])) {
            $result->andWhere('tb.tipobecaid =' . $filtros['tipobecaid']);
        }
        return $result->getQuery()->getResult();
    }
}
