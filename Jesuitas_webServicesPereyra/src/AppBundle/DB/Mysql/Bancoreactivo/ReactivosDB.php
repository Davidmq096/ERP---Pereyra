<?php

namespace AppBundle\DB\Mysql\Bancoreactivo;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Reacivos
 *
 * @author Javier
 */
class ReactivosDB extends BaseDBManager {

    public function BuscarReactivos($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('r')
        ->from("AppBundle:BrReactivo", 'r')
        ->innerJoin("r.subtemaid", "st")
        ->innerJoin("st.temaid", "t")
        ->innerJoin("t.materiaid", "m")
        ->innerJoin("t.areaid", "a")
        ->innerJoin("a.nivelid", "an")
        ->innerJoin("r.gradoid", "g")
        ->innerJoin("g.nivelid", "gn")
        ->innerJoin("r.estatusreactivoid", "e")
        ->leftJoin("r.tiporeactivoid", "tr")
        ->leftJoin("r.gradodificultadid", "gd");
        if (isset($filtros['campoformacionid'])) {
        	$result->andWhere('r.campoformacionid =' . $filtros['campoformacionid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('an.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        	$result->andWhere('gn.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid IN (:gradosid)')
        	->setParameter('gradosid' , $filtros['gradoid']);
        }
        if (isset($filtros['areaid'])) {
        	$result->andWhere('a.areaacademicaid =' . $filtros['areaid']);
        }
        if (isset($filtros['materiaid'])) {
        	$result->andWhere('m.materiaid =' . $filtros['materiaid']);
        }
        if (isset($filtros['temaid'])) {
        	$result->andWhere('t.temaid =' . $filtros['temaid']);
        }
        if (isset($filtros['subtemaid'])) {
        	$result->andWhere('st.subtemaid =' . $filtros['subtemaid']);
        }
        if (isset($filtros['tiporeactivoid'])) {
        	$result->andWhere('tr.tiporeactivoid =' . $filtros['tiporeactivoid']);
        }
        if (isset($filtros['ambitoseje'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['ambitoseje']=str_replace($escape,$escapados,$filtros['ambitoseje']);
        	$result->andWhere('r.ambitoseje like :ambitoseje')
        	->setParameter('ambitoseje', '%'.$filtros['ambitoseje'].'%');
        }
        if (isset($filtros['dificultadid'])) {
        	$result->andWhere('gd.gradodificultadid =' . $filtros['dificultadid']);
        }
        if (isset($filtros['estatusid'])) {
        	$result->andWhere('e.estatusreactivoid IN (:estatusreactivoid)')
        	->setParameter('estatusreactivoid' , $filtros['estatusid']);
        }
        return $result->getQuery()->getResult();
    }

    public function BitacoraReactivos($id) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("DATE_FORMAT(b.fecha,'%d/%m/%Y') fecha,
        DATE_FORMAT(b.hora,'%H:%i %p') hora, 
        u.cuenta, ta.descripcion accion, mr.descripcion motivo, b.comentariorechazo")
        ->from("AppBundle:BrBitacorareactivo", 'b')
        ->innerJoin("b.usuarioid", "u")
        ->innerJoin("b.tipoaccionbitacorareactivoid", "ta")
        ->innerJoin("b.reactivoid", "r")
        ->leftJoin("b.motivorechazoid", "mr")
        ->Where("b.reactivoid = ".$id);
        return $result->getQuery()->getResult();
    }

}
