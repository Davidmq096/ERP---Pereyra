<?php

namespace AppBundle\DB\Mysql\Comunicacion;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Notificacion
 *
 * @author Mariano
 */
class NotificacionDB extends BaseDBManager
{

    public function BuscarNotificacion($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("n.notificacionid,n.enviarpadres,n.enviaralumnos,DATE_FORMAT(n.fecha,'%d/%m/%Y') as fecha,DATE_FORMAT(n.hora,'%H:%i') as hora,n.titulo,n.mensaje,n.vinculo,n.estatus,u.usuarioid,n.tipoimagen, 
        concat(p.valor,'/api/Comunicacion/Notificacion/Imagen/',n.notificacionid) formato")
            ->from("AppBundle:CmNotificacion", "n")
            ->innerJoin("n.usuarioid", 'u')
            ->from("AppBundle:Parametros", "p")
            ->where("p.nombre = 'URLServicios'");
        if (isset($filtros['fecha'])) {
            $dateinicio = new \DateTime($filtros["fechainicio"]);
            $datefin =  new \DateTime($filtros["fechafin"]);
            $result->andWhere('n.fecha BETWEEN :fechainicio and :fechafin')
                ->setParameter("fechainicio", $dateinicio)
                ->setParameter("fechafin", $datefin);
        }
        if (isset($filtros['estatus'])) {
            $result->andWhere('n.estatus=:estatus')
                ->setParameter('estatus', $filtros['estatus']);
        }
        if (isset($filtros['titulo'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['titulo'] = str_replace($escape, $escapados, $filtros['titulo']);
            $result->andWhere('n.titulo like :titulo')
                ->setParameter('titulo', '%' . $filtros['titulo'] . '%');
        }
        if (isset($filtros['vinculo'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['vinculo'] = str_replace($escape, $escapados, $filtros['vinculo']);
            $result->andWhere('n.vinculo like :vinculo')
                ->setParameter('vinculo', '%' . $filtros['vinculo'] . '%');
        }
        return $result->getQuery()->getResult();
    }

    public function BuscarNotificacionesPendientes()
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("n")
            ->from("AppBundle:CmNotificacion", "n")
            ->andWhere("strtodate(concat(n.fecha,' ',n.hora), '%Y-%m-%d %T') <= CURRENT_TIMESTAMP() and n.estatus = 0");
        return $result->getQuery()->getResult();
    }

    public function BuscarNotificacionesAPP($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("n.notificacionid idinterno, a.alumnoid student_id, n.notificacionid id, 1 news_type, n.titulo title, n.mensaje details, n.vinculo url,
        CASE
          when n.tipoimagen = 2 THEN 0
          when n.tipoimagen = 3 THEN 1 else :null
        END is_big_image,
        l.hecho,
        l.leido,
        strtodate(concat(n.fecha,' ',n.hora), '%Y-%m-%d %T') fecha")
            ->from("AppBundle:CmNotificacionesleidas", "l")
            ->innerJoin("l.notificacionid", "n")
            ->innerJoin("l.alumnoid", 'a')
            ->andWhere("strtodate(concat(n.fecha,' ',n.hora), '%Y-%m-%d %T') <= CURRENT_TIMESTAMP()")
            ->andWhere("l.id = :id")
            ->andWhere("l.tipo = :tipo")
            ->setParameters(["id" => $filtros["id"], "tipo" => $filtros["tipo"], "null" => null])
            ->andWhere("n.titulo like :texto or n.mensaje like :texto")
	        ->setParameter('texto', '%'.$filtros['q'].'%')
            ->groupBy("n.notificacionid");
        return $result->getQuery()->getResult();
    }
}
