<?php

namespace AppBundle\DB\Mysql\Admisiones\ModalSolicitud;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of DatosAspiranteDB
 *
 * @author Javier
 */
class DatoAspiranteDB extends BaseDBManager
{
    //Funcion para obtener solicitudes con el mismo curp por ciclo
    public function getSolicitudExistByCURP($CURP, $cicloId, $grado, $solicitudid)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('sc')
        ->from("AppBundle:Solicitudadmisionporciclo", 'sc')
            ->innerJoin('sc.solicitudadmisionid', 's')
            ->innerJoin('s.datoaspiranteid', 'd')
            ->where('d.curp = :curp')
            ->andWhere('sc.cicloid = :cicloid')
            ->andWhere('s.gradoid = :gradoid')
            ->andWhere('s.solicitudadmisionid <> :solicitudadmisionid')
            ->setParameter('curp', $CURP)
            ->setParameter('gradoid', $grado)
            ->setParameter('cicloid', $cicloId)
            ->setParameter('solicitudadmisionid', $solicitudid);
        $query = $qb->getQuery()->getResult();
        return $query;
    }
}
