<?php

namespace AppBundle\DB\Mysql\Becas;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Filtrado de Tipos de Becas
 *
 * @author Rubén
 */

class PeriodosBecasDB extends BaseDBManager
{

    public function BuscarPeriodos($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("b.periodobecaid, c.cicloid, c.nombre as ciclo,
        Concat(DATE_FORMAT(b.fechainipagoestudiose, '%d/%m/%Y'),' al ', DATE_FORMAT(b.fechafinpagoestudiose, '%d/%m/%Y')) fechapago,
        Concat(DATE_FORMAT(b.fechainicapturas, '%d/%m/%Y'),' al ', DATE_FORMAT(b.fechafincapturas, '%d/%m/%Y')) fechacaptura,
        Concat(DATE_FORMAT(b.fechainientregade, '%d/%m/%Y'),' al ', DATE_FORMAT(b.fechafinentregade, '%d/%m/%Y')) fechaentregade,
        GroupConcat(f.formatobecaid, '' Order by td.tipodocumentoid ) documentos")
            ->from("AppBundle:BcPeriodobecaporformato", 'bf')
            ->innerJoin("bf.formatobecaid", "f")
            ->innerJoin("f.tipodocumentoid", "td")
            ->innerJoin("bf.periodobecaid", "b")
            ->innerJoin("b.cicloid", "c")
            ->groupBy("b.periodobecaid");
        if (isset($filtros['CicloId'])) {
            $result->andWhere('c.cicloid IN (' . $filtros['CicloId'] . ')');
        }
        return $result->getQuery()->getResult();
    }

}
