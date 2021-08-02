<?php

namespace AppBundle\DB\Mysql\Bancoreactivo;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 *
 * @author Javier
 */
class AplicacionExamenDB extends BaseDBManager {

    public function BuscarAplicacionexamenExterno($usuarioid) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ue usuario, ec, c, ep, e, sc, mr,
        ci.nombre ciclo, n.nombre nivel, g.grado, 
        case when (CURRENT_TIMESTAMP() BETWEEN c.horainicio and c.horafin) then false else true END bloqueo,
        DATE_FORMAT(c.fechaaplicacion,'%d/%m/%Y') fechaaplicacion,
        DATE_FORMAT(c.horainicio,'%H:%i %p') horainicio,
        DATE_FORMAT(c.horafin,'%H:%i %p') horafin
        ")      
        ->from("AppBundle:BrUsuarioporexamen", 'ue')
        ->innerJoin("ue.usuarioexternoid", "u")
        ->innerJoin('ue.examenporcalendarioid', 'ec')
        ->innerJoin('ec.calendarioexamenid', 'c')
        ->innerJoin('c.cicloid', "ci")
        ->innerJoin('c.gradoid', "g")
        ->innerJoin('g.nivelid', 'n')

        ->innerJoin("ec.examenid", "e")
        ->innerJoin("e.sistemacalificacionid", "sc")
        ->innerJoin("e.examenpresentacionid", 'ep')
        ->innerJoin("ep.mostrarreactivoid" , "mr")
        ->andWhere("u.usuarioexternoid =" . $usuarioid)
        ->andWhere("c.fechaaplicacion = CURRENT_DATE()")
        ->andWhere("c.medioaplicacionid = 1")
        ->orderBy("c.calendarioexamenid, ec.orden");

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
