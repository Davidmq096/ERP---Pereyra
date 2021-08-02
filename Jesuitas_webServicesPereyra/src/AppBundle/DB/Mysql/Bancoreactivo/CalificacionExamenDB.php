<?php
namespace AppBundle\DB\Mysql\Bancoreactivo;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * 
 *
 * @author Javier Manrique
 */
class CalificacionExamenDB extends BaseDBManager
{

    public function BuscarCalificacionexamen($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ce.descripcion, e.nombre examen, ec.examenporcalendarioid,
        DATE_FORMAT(ce.fechaaplicacion,'%d/%m/%Y') fechaaplicacion, DATE_FORMAT(ce.horainicio,'%H:%i') hora,
        ta.nombre tipoaplicacion, ma.medioaplicacionid, ma.nombre medioaplicacion")
            ->from("AppBundle:BrExamenporcalendario", 'ec')
            ->innerJoin("ec.calendarioexamenid", "ce")
            ->innerJoin("ce.medioaplicacionid", "ma")
            ->innerJoin("ce.tipoaplicacionid", "ta")
            ->innerJoin("ce.gradoid", "g")
            ->innerJoin('ec.examenid', 'e')
            ->addSelect('(SELECT sum(case 
                when ue.aplicado = true then
                case when ue.calificacion is null then 1 else 0 end 
                else 1 end
            ) from AppBundle:BrUsuarioporexamen ue where ec.examenporcalendarioid = ue.examenporcalendarioid) calificacion');
        if (isset($filtros['cicloid'])) {
            $result->andWhere('ce.cicloid =' . $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
            $result->andWhere('g.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid IN (:gradosid)')
                ->setParameter('gradosid', $filtros['gradoid']);
        }
        if (isset($filtros['tipoaplicacionid'])) {
            $result->andWhere('ta.tipoaplicacionid =' . $filtros['tipoaplicacionid']);
        }
        if (isset($filtros['descripcion'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['descripcion']=str_replace($escape,$escapados,$filtros['descripcion']);
        	$result->andWhere('ce.descripcion like :descripcion')
        	->setParameter('descripcion', '%'.$filtros['descripcion'].'%');
        }
        if (isset($filtros['fechaaplicacion'])) {
            $fecha = new \DateTime($filtros["fechaaplicacion"]["date"]["year"] . "-" . $filtros["fechaaplicacion"]["date"]["month"] . "-" . $filtros["fechaaplicacion"]["date"]["day"]);
            $result->andWhere('ce.fechaaplicacion = :fecha')
            ->setParameter('fecha', $fecha);
        }
        $result = $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);

        return $result;
    }

}
