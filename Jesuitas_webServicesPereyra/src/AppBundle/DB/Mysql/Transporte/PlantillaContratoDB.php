<?php

namespace AppBundle\DB\Mysql\Transporte;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Inscripcion
 *
 * @author Javier
 */
class PlantillaContratoDB extends BaseDBManager {

    public function BuscarPlantilla($filtros) {
        $qb = $this->em->createQueryBuilder();
        
        $result = $qb->select("p.plantillacontratoid, p.nombre, p.activo,
        GroupConcat(n.nombre Order by n.nivelid SEPARATOR ', ') nivel, GroupConcat(n.nivelid, '' Order by n.nivelid) nivelid")
        ->from("AppBundle:TpNivelporplantillacontrato","np")
        ->innerJoin("np.nivelid", "n")
        ->innerJoin("np.plantillacontratoid", "p")
        ->groupBy("p.plantillacontratoid");
        if (isset($filtros['activo'])) {
            $result->andWhere('p.activo = 1');
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        return $result->getQuery()->getResult();
    }

}
