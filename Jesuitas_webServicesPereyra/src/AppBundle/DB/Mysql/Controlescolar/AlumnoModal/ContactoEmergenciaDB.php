<?php

namespace AppBundle\DB\Mysql\Controlescolar\AlumnoModal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asignacion materia
 *
 * @author Gabriel, Rubén
 */
class ContactoEmergenciaDB extends BaseDBManager 
{
    /*
     * Obtiene el contacto de emergencia de un alumno
     */
    public function GetContactoEmergenciaAlumno($alumnoid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ce.nombre contactoemergencianombre,  ce.telefono contactoemergenciatelefono, p.parentescoid, p.descripcion parentesco ")
        ->from("AppBundle:CeContactoemergencia","ce")
        ->leftJoin("AppBundle:Parentesco", "p", Expr\Join::WITH, "p.parentescoid = ce.parentescoid");
        
        $result->andWhere('ce.alumnoid = '.$alumnoid);
            
        return $result->getQuery()->getResult();
    }
}
