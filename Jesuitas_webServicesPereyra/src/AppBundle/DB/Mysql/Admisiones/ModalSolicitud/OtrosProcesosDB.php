<?php

namespace AppBundle\DB\Mysql\Admisiones\ModalSolicitud;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Categoriaapoyo
 *
 * @author Javier
 */
class OtrosProcesosDB extends BaseDBManager
{

    //get solicitudes en diferentes ciclos
    //Funcion para obtener el cupo de admicion por grado y ciclo
    public function getSolicitudesTodosCiclos($CURP, $cicloId)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('sc')
        ->from("AppBundle:Solicitudadmisionporciclo", 'sc')
        ->innerJoin('sc.cicloid', 'c')
        ->innerJoin('sc.solicitudadmisionid', 's')
        ->innerJoin('s.datoaspiranteid', 'd')
        ->where('d.curp = :curp')
        ->andWhere('c.cicloid != :ciclo')
        ->setParameter('curp', $CURP)
        ->setParameter('ciclo', $cicloId);

        return $qb->getQuery()->getResult();
    }

}
