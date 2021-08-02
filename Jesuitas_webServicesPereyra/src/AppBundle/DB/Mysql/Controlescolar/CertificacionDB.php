<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of certificacion
 *
 * @author Mariano
 */
class CertificacionDB extends BaseDBManager {

    public function BuscarCertificaciones($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.certificacionid,i.idiomaid,c.tipovigencia,i.nombre as idioma,c.nombre as certificacion,c.anovigencia,
        CASE
            WHEN c.tipovigencia=1  THEN 'Permanente'
            ELSE CONCAT_WS(' ',c.anovigencia,'años') 
        END
        as vigencia,GroupConcat(cc.nombre) as criterios")
        ->from("AppBundle:CeCertificacion","c")
        ->leftJoin("AppBundle:CeIdioma", "i", Expr\Join::WITH, "i.idiomaid=c.idiomaid")
        ->leftJoin("AppBundle:CeCriterioporcertificacion", "cc", Expr\Join::WITH, "cc.certificacionid=c.certificacionid")
        ->groupBy("c.certificacionid");
        return $result->getQuery()->getResult();
    }
}
