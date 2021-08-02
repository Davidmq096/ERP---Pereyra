<?php

namespace AppBundle\DB\Mysql\Cobranza;

use Doctrine\ORM\Query\Expr;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Acuerdos
 *
 * @author Javier
 */
class AcuerdosDB extends BaseDBManager
{

    public function BuscarAcuerdos($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a,ac.acuerdoid acuerdoid, DATE_FORMAT(ac.fechacreacion, '%d/%m/%Y') fechacreacion,
        CASE
			WHEN e.estatusacuerdoid = 1 AND (CURRENT_DATE() > ac.vigenciafin) THEN 'Vencido' ELSE e.nombre
        END estatusacuerdo, 
        ci.nombre ciclo, GroupConcat(DISTINCT al.alumnoid) alumnoid, c.clavefamiliarid, c.clave,
        CONCAT_WS(' ', c.apellidopaterno, c.apellidomaterno) familia,
        GROUPCONCAT(
                    DISTINCT CONCAT_WS(' ', p.apellidopaterno, p.apellidomaterno, p.nombre, '&nbsp;', p.correo, '&nbsp;', p.celular) 
                    SEPARATOR '<br>') padres")
            ->from("AppBundle:CbAlumnoporacuerdo", 'a')
            ->innerJoin("a.acuerdoid", "ac")
            ->innerJoin("ac.cicloid", "ci")
            ->innerJoin("ac.estatusacuerdoid", "e")
            ->innerJoin("a.alumnoid", "al")
            ->leftJoin("AppBundle:CeAlumnoporclavefamiliar", "alcl", Expr\Join::WITH, "alcl.alumnoid = al.alumnoid")
            ->leftJoin("alcl.clavefamiliarid", "c")
            ->leftJoin("AppBundle:CePadresotutoresclavefamiliar", "pcf", Expr\Join::WITH, "pcf.clavefamiliarid = c.clavefamiliarid")
            ->leftJoin("pcf.padresotutoresid", "p")
            ->groupBy("ac.acuerdoid");
        if (isset($filtros['cicloid'])) {
            $result->andWhere('ci.cicloid =' . $filtros["cicloid"]);
        }
        //if (isset($filtros['tipoacuerdoid'])) {
        //$result->andWhere('ac.tipoacuerdoid =' . $filtros["tipoacuerdoid"]);
        //}
        if (isset($filtros['estatusid'])) {
            switch ($filtros['estatusid']) {
                case "1":
                    $result->andWhere('e.estatusacuerdoid = 1 
                    AND (CURRENT_DATE() <= ac.vigenciafin)');
                    break;
                case "2":
                case "3":
                case "4":
                    $result->andWhere('e.estatusacuerdoid =' . $filtros["estatusid"]);
                    break;
                case "5":
                    $result->andWhere('e.estatusacuerdoid = 1 
                    AND (CURRENT_DATE() > ac.vigenciafin)');
                    break;
            }
        }
        if (isset($filtros['matricula'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['matricula'] = str_replace($escape, $escapados, $filtros['matricula']);
            $result->andWhere('al.matricula like :matricula ')
                ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }
        if (isset($filtros['nombre'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['nombre'] = str_replace($escape, $escapados, $filtros['nombre']);
            $result->andWhere('al.primernombre like :nombre')
                ->setParameter('nombre', '%' . $filtros['nombre'] . '%');
        }
        if (isset($filtros['apellidopaterno'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['apellidopaterno'] = str_replace($escape, $escapados, $filtros['apellidopaterno']);
            $result->andWhere('al.apellidopaterno like :apellidopaterno')
                ->setParameter('apellidopaterno', '%' . $filtros['apellidopaterno'] . '%');
        }
        if (isset($filtros['apellidomaterno'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['apellidomaterno'] = str_replace($escape, $escapados, $filtros['apellidomaterno']);
            $result->andWhere('al.apellidomaterno like :apellidomaterno')
                ->setParameter('apellidomaterno', '%' . $filtros['apellidomaterno'] . '%');
        }

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }
}
