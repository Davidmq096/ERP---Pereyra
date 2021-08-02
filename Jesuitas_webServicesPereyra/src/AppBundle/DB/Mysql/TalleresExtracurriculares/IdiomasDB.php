<?php

namespace AppBundle\DB\Mysql\TalleresExtracurriculares;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of idiomas
 *
 * @author Mariano
 */
class IdiomasDB extends BaseDBManager {

    public function BuscarCertificacionesIdiomas($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ic.idiomacertificacionid,i.idiomaid,ic.tipovigencia,i.nombre as idioma,ic.nombre as certificacion,ic.anovigencia,
        CASE
            WHEN ic.tipovigencia=1  THEN 'Permanente'
            ELSE CONCAT_WS(' ',ic.anovigencia,'años') 
        END
        as vigencia,GroupConcat(cic.nombre) as criterios")
        ->from("AppBundle:CeCertificacion","ic")
        ->innerJoin("AppBundle:CeIdioma", "i", Expr\Join::WITH, "i.idiomaid=ic.idiomaid")
        ->leftJoin("AppBundle:CeCriterioporidiomacertificacion", "cic", Expr\Join::WITH, "cic.idiomacertificacionid=ic.idiomacertificacionid")
        ->groupBy("ic.idiomacertificacionid");
        return $result->getQuery()->getResult();
    }
}
