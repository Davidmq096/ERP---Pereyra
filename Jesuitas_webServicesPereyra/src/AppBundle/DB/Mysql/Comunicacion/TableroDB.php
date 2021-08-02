<?php

namespace AppBundle\DB\Mysql\Comunicacion;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Actividad
 *
 * @author Mariano
 */
class TableroDB extends BaseDBManager {

    public function TotalesNotificaciones($filtros) {
        
        $qb = $this->em->getConnection();
        $sql = "SELECT tiponotificacion,id,tiponotificaciontexto,titulo, fechaformato,
        CASE WHEN fechaformato < NOW() THEN count(id) ELSE 0 END as enviados,
        count(case visto when 1 then 1 else null end) as leidos FROM cm_notificacionvista where 1=1 ";
        if (isset($filtros["fecha"])){
            $dateinicio=new \DateTime($filtros["fechainicio"]);
            $datefin=new \DateTime($filtros["fechafin"]);
            $sql.="and (DATE_FORMAT(fechaformato, '%Y-%m-%d') between '".$dateinicio->format("Y-m-d")."' and '".$datefin->format("Y-m-d")."')";
        }
        if (isset($filtros["tiponotificacion"])){
            $sql.=" and tiponotificacion=".$filtros["tiponotificacion"];
        }
        if (!empty($filtros["nivelid"])){
            if (is_array($filtros["nivelid"])){
                $nivelid=implode (", ", $filtros["nivelid"]);
            }else{
                $nivelid=$filtros["nivelid"];
            }
            $sql.=" and nivelid in (".$nivelid.")";
        }
        if (isset($filtros["titulo"])){
            $sql.=" and titulo like '%".$filtros["titulo"]."%'";
        }
        if (isset($filtros["vinculo"])){
            $sql.=" and vinculo like '%".$filtros["vinculo"]."%'";
        }
        $sql.=" group by (titulo) order by fechaformato desc";
        $stmt = $qb->prepare($sql);
        $stmt->execute();
        $notificaciones = $stmt->fetchAll();

        return $notificaciones;
    }

    public function Detalle($idtiponotificacion,$titulo) {
        
        $qb = $this->em->getConnection();
        $sql = "SELECT * FROM cm_notificacionvista where fechaformato <= NOW() ";
        if (isset($idtiponotificacion)){
            $sql.=" and tiponotificacion=".$idtiponotificacion;
        }
        if (isset($titulo)){
            $sql.=" and titulo='".$titulo."'";
        }
        $sql.=" Order By Matricula";
        $stmt = $qb->prepare($sql);
        $stmt->execute();
        $notificaciones = $stmt->fetchAll();

        return $notificaciones;
    }

}
