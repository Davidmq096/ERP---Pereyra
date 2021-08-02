<?php

namespace AppBundle\DB\Mysql\Controlescolar\AlumnoModal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asignacion materia
 *
 * @author Gabriel, Rubén
 */
class FamiliaDB extends BaseDBManager 
{
    
    /*
     * Método para obtener los datos generales del padre o tutor
     */
    public function GetPadreTutorAlumno($clavefamiliarid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p.padresotutoresid, p.ocupacion, p.nombre, p.apellidopaterno, p.apellidomaterno,
                               p.telefono, p.celular, p.tutor, p.vive, p.fechanacimiento, p.especificacionocupacion,
                                p.empresa,         (
                                    CASE 
                                        WHEN us.cuenta IS NULL
                                        THEN p.correo
                                        ELSE us.cuenta
                                    END
                                  ) as correo, p.telempresa, p.extensionempresa, p.horariotrabajo, p.exlux, p.ramo,
                                p.alumnoinstituto, p.especificaralumno, p.antiguedad, 
                                g.generacionid, g.nombre generacion, 
                                e.escolaridadid nivelestudioid, e.descripcion nivelestudio,
                                s.situacionconyugalid, s.descripcion situacionconyugal,
                                t.tutorid, t.descripcion parentesco")
        ->from("AppBundle:CePadresotutores","p")
        ->innerJoin("AppBundle:CePadresotutoresclavefamiliar", "pc", Expr\Join::WITH, "pc.padresotutoresid = p.padresotutoresid")
        ->innerJoin("AppBundle:Tutor", "t", Expr\Join::WITH, "t.tutorid = pc.tutorid")
        ->leftJoin("AppBundle:Escolaridad", "e", Expr\Join::WITH, "e.escolaridadid = p.nivelestudioid")   
        ->leftJoin("AppBundle:Situacionconyugal", "s", Expr\Join::WITH, "s.situacionconyugalid = p.situacionconyugalid")
        ->leftJoin("AppBundle:Generacion", "g", Expr\Join::WITH, "g.generacionid = p.generacionid")
        ->leftJoin("AppBundle:Usuario", "us", Expr\Join::WITH, "us.padreotutorid = p.padresotutoresid");
        $result->andWhere('pc.clavefamiliarid = '.$clavefamiliarid);
            
        return $result->getQuery()->getResult();
    }
        
    /*
     * Método para obtener las nacinalidades de un padre o tutor
     */
    public function GetNacionalidadPadreoTutor($id) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("n.nacionalidadid, n.nombre")
        ->from("AppBundle:Nacionalidad","n")
        ->innerJoin("AppBundle:CePadresotutoresnacionalidad", "pn", Expr\Join::WITH, "pn.nacionalidadid = n.nacionalidadid");
        
        $result->andWhere('pn.padresotutoresid = '.$id);
            
        return $result->getQuery()->getResult();
    }
    
}
