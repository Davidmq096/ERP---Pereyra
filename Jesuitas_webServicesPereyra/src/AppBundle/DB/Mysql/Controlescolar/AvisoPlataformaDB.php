<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 */
class AvisoPlataformaDB extends BaseDBManager
{
    public function getAvisosPlataforma($filtros)
    {

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ap.avisoplataformaid, ap.titulo, ap.descripcion, DATE_FORMAT(ap.hora , '%H:%i') as hora, 
            ap.activo, DATE_FORMAT(ap.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(ap.fechafin, '%d/%m/%Y') as fechafin, ape.avisocaratulaestatusid, ape.nombre as estatus, GROUPCONCAT(DISTINCT pr.perfilid) as perfilesid,
            GROUPCONCAT(DISTINCT n.nivelid) as nivelid, GROUPCONCAT(DISTINCT pr.nombre separator ',<br>') as destinatarios, GROUPCONCAT(DISTINCT n.nombre separator ',<br>') as niveles")
            ->from("AppBundle:CeAvisosplataforma", "ap")
            ->innerJoin('ap.avisoplataformaestatusid', 'ape')
            ->leftJoin("AppBundle:CeAvisosplataformaporperfil", "app", Expr\Join::WITH, "app.avisoplataformaid = ap.avisoplataformaid")
            ->leftJoin('app.perfilid', 'pr')
            ->leftJoin("AppBundle:Usuarioporperfil", "up", Expr\Join::WITH, "up.perfilid = pr.perfilid")
            ->leftJoin("AppBundle:CeAvisosplataformapornivel", "apn", Expr\Join::WITH, "apn.avisoplataformaid = ap.avisoplataformaid")
            ->leftJoin('apn.nivelid', 'n')
            ->leftJoin("AppBundle:CeProfesorpornivel", "ppn", Expr\Join::WITH, "ppn.nivelid = n.nivelid")
            ->leftJoin('ppn.profesorid', 'p')
            ->leftJoin("AppBundle:Usuario", "u",Expr\Join::WITH, 'u.usuarioid = up.usuarioid or u.profesorid = p.profesorid')            
            ->addOrderBy("ap.fecha", 'desc')
            ->addOrderBy("ap.hora", 'desc')
            ->groupBy("ap.avisoplataformaid");

            if(isset($filtros['borrador'])) {
                $result->andWhere('ap.activo = 1 and ap.avisoplataformaestatusid <> 1');
                $result->andWhere("CURRENT_TIMESTAMP() Between strtodate(concat(ap.fecha,' ',ap.hora), '%Y-%m-%d %T') and strtodate(concat(ap.fechafin,' 23:59:59'), '%Y-%m-%d %T')");
            }

            if (isset($filtros['nivelid'])) {
                $result->andWhere('n.nivelid = :nivelid')
                    ->setParameter('nivelid', $filtros['nivelid']);
            }

            if (isset($filtros['perfilid'])) {
                $result->andWhere('pr.perfilid IN (:perfilid)')
                    ->setParameter('perfilid', $filtros['perfilid']);
            }

            if (isset($filtros['usuarioid'])) {
                $result->andWhere('u.usuarioid = :usuarioid')
                    ->setParameter('usuarioid', $filtros['usuarioid']);
            }

            if (isset($filtros['activo'])) {
                $result->andWhere('ap.activo = 1');
            }


        return $result->getQuery()->getResult();
    }
}