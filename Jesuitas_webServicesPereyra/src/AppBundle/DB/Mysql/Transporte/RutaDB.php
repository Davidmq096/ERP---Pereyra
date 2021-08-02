<?php

namespace AppBundle\DB\Mysql\Transporte;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Inscripcion
 *
 * @author Javier
 */
class RutaDB extends BaseDBManager {

    public function BuscarRuta($filtros) {
        $qb = $this->em->createQueryBuilder();
        
        $result = $qb->select("r.rutaid,  
        r.nombre, r.capacidad, 
        r.tipoviaje tipoviajeid,
        CASE WHEN r.tipoviaje = 1 THEN 'Ida' ELSE 'Regreso' END tipoviaje,
        r.tipoprecio tipoprecioid,
        CASE WHEN r.tipoprecio = 1 THEN 'Fijo' ELSE 'Por parada' END tipoprecio,
        CONCAT(DATE_FORMAT(r.horainicio, '%H:%i') ,' - ', DATE_FORMAT(r.horafin, '%H:%i')  ) horario,
        CONCAT(DATE_FORMAT(r.vigenciainicio, '%d/%m/%Y') ,' - ', DATE_FORMAT(r.vigenciafin, '%d/%m/%Y')) vigencia, r.preciocontrato,
        s.nombre subconcepto")
        ->from("AppBundle:TpRuta","r")
        ->innerJoin("r.subconceptoid", "s");
        if (isset($filtros['activo'])) {
            $result->andWhere('r.activo = 1');
        }
        return $result->getQuery()->getResult();
    }

    public function PrecioFijo($filtros) {
        $qb = $this->em->createQueryBuilder();
        
        $result = $qb->select("")
        ->from("AppBundle:TpRutaprecioparada","rp")
        ->where('rp.rutaid');
        return $result->getQuery()->getResult();
    }

}
