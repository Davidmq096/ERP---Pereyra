<?php

namespace AppBundle\DB\Mysql\Cobranza;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of cobranza
 *
 * @author Inceptio
 */
class AgendaCitasDB extends BaseDBManager
{

    public function getAgendaCitasFilters($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.agendacitaid,
        DATE_FORMAT(c.fechainicio, '%d/%m/%Y') fechainicio,
        DATE_FORMAT(c.horainicio, '%H:%i') horainicio,
        DATE_FORMAT(c.horafin, '%H:%i') horafin, c.asistencia, c.enviocorreo, c.descripcion, c.asistio,
                            f.clavefamiliarid, GroupConcat(a.alumnoid) alumnoid")
            ->from("AppBundle:CbAgendacita", 'c')
            ->innerJoin("c.clavefamiliarid", "f")
            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "af", Expr\Join::WITH, "f.clavefamiliarid = af.clavefamiliarid")
            ->innerJoin("af.alumnoid","a")
            ->groupBy("f.clavefamiliarid, c.agendacitaid");

        if (isset($filtros['matricula'])) {
            $result->andWhere('a.matricula like :matricula')
                ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }
        if (isset($filtros['rangofecha'])) {
            $f = $filtros['rangofecha'];
            $dateinicio = new \DateTime($f["beginDate"]["day"] . '-' . $f["beginDate"]["month"] . '-' . $f["beginDate"]["year"]);
            $datefin = new \DateTime($f["endDate"]["day"] . '-' . $f["endDate"]["month"] . '-' . $f["endDate"]["year"]);
            $result->andWhere('c.fechainicio between :fechainicio and :fechafin')
                ->setParameter("fechainicio", $dateinicio)
                ->setParameter("fechafin", $datefin);
        }
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

}
