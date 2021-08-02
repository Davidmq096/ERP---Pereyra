<?php

namespace AppBundle\DB\Mysql\Controlescolar\AlumnoModal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asignacion materia
 *
 * @author Gabriel, Rubén
 */
class DatosGeneralesDB extends BaseDBManager 
{
    /*
     * Método para obtener el detalle del domicilio actual del alumno
     */
    public function GetDomicilioAlumno($alumnoid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("d.alumnodomicilioid, d.esfiscal, d.calle, d.numeroexterior, d.numerointerior, 
                                d.colonia, d.codigopostal, d.observaciones, c.coloniaid,
                                e.estadoid, e.nombre estado, m.nombre ciudad, m.municipioid ciudadid")
        ->from("AppBundle:CeAlumnodomicilio","d")
        ->innerJoin("AppBundle:Municipio", "m", Expr\Join::WITH, "m.municipioid = d.ciudad")
        ->innerJoin("AppBundle:Estado", "e", Expr\Join::WITH, "e.estadoid = m.estadoid")
        ->leftJoin("AppBundle:Colonia", "c", Expr\Join::WITH, "c.nombre = d.colonia")
        ->groupBy('d.alumnoid');
        $result->andWhere('d.alumnoid = '.$alumnoid);
            
        return $result->getQuery()->getResult();
    }

     /*
     * Obtiene los datos generales del alumno
     */
    public function GetDatosGeneralesAlumno($alumnoid) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, a.fechanacimiento, a.sexo, a.curp, a.correoinstitucional, u.usuarioid, u.id as numeronomina,
        a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno, a.reingresofuturo as reingresofuturo, a.hijopersonal,
        p.paisid, p.nombre as paisnacimiento, m.municipioid as ciudadid, m.nombre as ciudadnacimiento, e.estadoid, e.nombre as estadonacimiento,
        t.telefono, c.correo,a.intercambio, ia.fechainicio, ia.fechafin, ia.observaciones, 
        CASE WHEN pr.profesorid is not null then concat_ws(' ', pr.apellidopaterno, pr.apellidomaterno, pr.nombre) ELSE 
        concat_ws(' ', ps.apellidopaterno, ps.apellidomaterno, ps.nombre) END as nombreprofesor")
        ->from("AppBundle:CeAlumno","a")
        ->leftJoin("AppBundle:CeAlumnolugarnacimiento", "l", Expr\Join::WITH, "l.alumnoid = a.alumnoid")
        ->leftJoin("AppBundle:Pais", "p", Expr\Join::WITH, "p.paisid = l.paisid")
        ->leftJoin("AppBundle:Estado", "e", Expr\Join::WITH, "e.estadoid = l.estadoid")
        ->leftJoin("AppBundle:Municipio", "m", Expr\Join::WITH, "m.municipioid = l.municipioid")
        ->leftJoin("AppBundle:CeAlumnotelefono", "t", Expr\Join::WITH, "t.alumnoid = a.alumnoid")
        ->leftJoin("AppBundle:CeAlumnocorreo", "c", Expr\Join::WITH, "c.alumnoid = a.alumnoid")
        ->leftJoin("AppBundle:CeIntercambioporalumno", "ia", Expr\Join::WITH, "ia.alumnoid = a.alumnoid")
        ->leftJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.usuarioid = a.usuarioid")
        ->leftJoin("AppBundle:CeProfesor", "pr", Expr\Join::WITH, "pr.profesorid = u.profesorid")
        ->leftJoin("AppBundle:Persona", "ps", Expr\Join::WITH, "ps.personaid = u.personaid")
        ->setMaxResults(1);
        $result->andWhere('a.alumnoid = '.$alumnoid);
            
        return $result->getQuery()->getOneOrNullResult();
    }
}
