<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Ciclo
 *
 * @author Rubén
 */
class PlanEstudioDB extends BaseDBManager
{
    public function getMateriasPorPlanEstudio($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("m.materiaid,m.nombre as materia")
            ->from("AppBundle:Materia", 'm')
            ->join('AppBundle:CeMateriaporplanestudios','mpe',\Doctrine\ORM\Query\Expr\Join::WITH,'mpe.materiaid = m.materiaid');
        $result->andWhere('mpe.planestudioid =' . $filtros['planestudioid']);
        return $result->getQuery()->getResult();
    }

    public function FiltrarMateriasPorPlanEstudioTest($filtros)
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

        if (isset($filtros['planestudioid'])) {
            $result->andWhere('mppe.planestudioid =' . $filtros['planestudioid']);
        }

        return $result->getQuery()->getResult();
    }

    public function BuscarPlanestudio($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p")
            ->from("AppBundle:CePlanestudios", 'p')
            ->innerJoin("p.cicloinicialid", "c")
            ->innerJoin("p.gradoid", "g")
            ->innerJoin("g.nivelid", "n")
            ->leftJoin("p.areaespecializacionid", "a");
        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid =' . $filtros["cicloid"]);
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
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
            $result->andWhere('p.nombre like ' . '\'%' . $filtros["nombre"] . '%\'');
        }
        if (isset($filtros['vigente'])) {
            $result->andWhere('p.vigente = :vigente')
                ->setParameter("vigente", ($filtros["vigente"] == "1"));
        }
        if (isset($filtros['areaespecializacionid'])) {
            $result->andWhere('a.areaespecializacionid =' . $filtros["areaespecializacionid"]);
        }
        return $result->getQuery()->getResult();
    }

    public function FiltrarPlanesEstudios($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("m")
            ->from("AppBundle:CePlanestudios", 'm');

        if (isset($filtros['gradoid'])) {
            $result->andWhere('m.gradoid =' . $filtros['gradoid']);
        }

        return $result->getQuery()->getResult();
    }

    public function FiltrarMateriasPorGrado($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("(CASE WHEN ma.materiaid is not null THEN 'SI' ELSE 'NO' END) as tienesubs, m")
            ->from("AppBundle:Materia", 'm')
            ->leftJoin(
                'AppBundle:CeMateriaporplanestudios',
                'mppe',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                ' mppe.materiaid = m.materiaid and mppe.planestudioid = ' . $filtros['planestudioid']
            )->leftJoin(
            'AppBundle:Materia',
            'ma',
            \Doctrine\ORM\Query\Expr\Join::WITH,
            'm.materiaid = ma.materiapadreid')
            ->andWhere(
                'mppe.materiaporplanestudioid is null'
            )->groupBy('m.materiaid')
            ->orderBy('m.nombre', 'DESC');

        if (isset($filtros['nivelid'])) {
            $result->andWhere('m.nivelid =' . $filtros['nivelid']);
        }

        if (isset($filtros['activo'])) {
            $result->andWhere('m.activo =' . $filtros['activo']);
        } else {
            $result->andWhere('m.activo = 1');
        }

        return $result->getQuery()->getResult();
    }

    public function FiltrarMateriasPorPlanEstudio($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("(CASE WHEN ma.materiaid is not null THEN 'SI' ELSE 'NO' END) as tienesubs, mppe,tc.tipocalificacionid,tc.nombre as tipocalificacion")
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
            ->leftJoin('AppBundle:CeComponentecurricular','cc',\Doctrine\ORM\Query\Expr\Join::WITH,'cc.componentecurricularid = mppe.componentecurricularid')  
            ->leftJoin('AppBundle:CeTipocalificacion','tc',\Doctrine\ORM\Query\Expr\Join::WITH,'tc.tipocalificacionid = cc.tipocalificacionid')    
            ->groupBy('m.materiaid')
            ->orderBy('m.nombre', 'DESC');

        if (isset($filtros['planestudioid'])) {
            $result->andWhere('mppe.planestudioid =' . $filtros['planestudioid']);
        }

        return $result->getQuery()->getResult();
    }

    public function ObtenerCriteriosEvaluacion($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("m")
            ->from("AppBundle:Materia", 'm');

        if (isset($filtros['planestudioid'])) {
            $result->andWhere('mppe.planestudioid =' . $filtros['planestudioid']);
        }

        if (isset($filtros['activo'])) {
            $result->andWhere('m.activo =' . $filtros['activo']);
        } else {
            $result->andWhere('m.activo = 1');
        }

        return $result->getQuery()->getResult();
    }

    public function PlanEstudioPorCicloGrado($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p")
            ->from('AppBundle:CeCiclopornivel', 'cc')
            ->innerJoin('cc.cicloid', 'c')
            ->innerJoin("AppBundle:Grado", 'g', Expr\Join::WITH, 'cc.nivelid = g.nivelid')
            ->innerJoin("AppBundle:CePlanestudios", 'p', Expr\Join::WITH, 'p.gradoid = g.gradoid')

            ->innerJoin("p.cicloinicialid","ci")
            ->innerJoin('AppBundle:CeCiclopornivel', 'ccpi', Expr\Join::WITH, 'cc.nivelid = ccpi.nivelid and ccpi.cicloid = ci.cicloid')

            ->leftJoin("p.ciclofinalid","cf")
            ->leftJoin('AppBundle:CeCiclopornivel', 'ccpf', Expr\Join::WITH, ' cc.nivelid = ccpf.nivelid and ccpf.cicloid = cf.cicloid')
            ->where("cc.fechainicio BETWEEN ccpi.fechainicio and (CASE WHEN cf.cicloid is NULL THEN CURRENT_DATE() ELSE ccpf.fechafin END)")
            ->andWhere("c.cicloid = :cicloid")
            ->setParameter('cicloid', $filtros['cicloid'])
            ->andWhere("g.gradoid = :gradoid")
            ->setParameter('gradoid', $filtros['gradoid']);
        if (isset($filtros['areaespecializacionid'])) {
            $result->andWhere('p.areaespecializacionid  = :areaespecializacionid')
                ->setParameter('areaespecializacionid', $filtros['areaespecializacionid']);
        }
        return $result->getQuery()->getResult();
    }

}
