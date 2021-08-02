<?php

namespace AppBundle\DB\Mysql\Transporte;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Inscripcion
 *
 * @author Javier
 */
class BoletoDB extends BaseDBManager
{

    public function BuscarDisponibilidad($filtros)
    {
       // print_r($filtros["fecha"]);
//print_r(date("n",$filtros["fecha"]));
        $qb = $this->em->createQueryBuilder();
        $suspendido = $qb->select('CASE 
        WHEN acs.suspenderinicio is not null THEN 
            (CASE WHEN :fecha BETWEEN acs.suspenderinicio and acs.suspenderfin THEN 1 ELSE 0 END)
        ELSE 0 END')
            ->from("AppBundle:TpAlumnoporcontrato", "acs")
            ->where("ac.alumnoporcontratoid = acs.alumnoporcontratoid")
            ->getQuery()->getDQL();
        
        $qb = $this->em->createQueryBuilder();
        $cancelado = $qb->select('CASE 
        WHEN acs2.fechacancelacion is not null THEN 
            (CASE WHEN :fecha >= acs2.fechacancelacion THEN 1 ELSE 0 END)
        ELSE 0 END')
            ->from("AppBundle:TpAlumnoporcontrato", "acs2")
            ->where("ac.alumnoporcontratoid = acs2.alumnoporcontratoid")
            ->getQuery()->getDQL();    

        $qb = $this->em->createQueryBuilder();
        $contrato = $qb->select('count(distinct ac.alumnoporcontratoid)')
            ->from('AppBundle:TpAlumnoruta', 'rc')
            ->innerJoin('rc.contratoid', 'c',  Expr\Join::WITH, 'c.contratoid = rc.contratoid and :fecha BETWEEN c.vigenciainicio and c.vigenciafin')
            ->innerJoin('AppBundle:CeAlumno', 'a2', Expr\Join::WITH, 'rc.alumnoid = a2.alumnoid and a2.alumnoestatusid <> 2')
            ->innerJoin('AppBundle:TpAlumnoporcontrato', 'ac', Expr\Join::WITH, 'ac.alumnoid = rc.alumnoid and c.contratoid = ac.contratoid and ac.contratoestatusid IN (1,2) and 0 = (' . $cancelado . ') and 0 = (' . $suspendido . ')')
            ->where('r.rutaid = rc.rutaid')
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $boleto = $qb->select('count(distinct b.boletoid)')
            ->from('AppBundle:TpBoleto', 'b')
            ->where('r.rutaid = b.rutaid and b.fecha = :fecha');
            if (isset($filtros['boletoid'])){
                $boleto->andWhere("b.boletoid <> :boletoid");
            }
            $boleto->getQuery()->getDQL();


        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("r.rutaid,r.nombre ruta, r.capacidad, r.tipoviaje tipoviajeid, CASE WHEN r.tipoviaje = 1 THEN 'Ida' ELSE 'Regreso' END tipoviaje, r.tipoprecio,
        CASE WHEN re.horainicio is null THEN
            DATE_FORMAT(r.horainicio , '%H:%i') 
            ELSE DATE_FORMAT(re.horainicio , '%H:%i') END hora, re.suspender, s.subconceptoid,
        '" . $filtros["fecha"] . "' date,  DATE_FORMAT('" . $filtros["fecha"] . "', '%d/%m/%Y') fecha")
            ->addSelect('(' . $contrato . ') contrato')
            ->addSelect('(' . $boleto . ') boleto')
            ->from('AppBundle:TpRuta', 'r')
            ->innerJoin('r.subconceptoid', 's')
            ->leftJoin('AppBundle:TpRutaexcepcion', 're', Expr\Join::WITH, 'r.rutaid = re.rutaid  and :fecha BETWEEN re.fechainicio and re.fechafin')
            ->where(":fecha BETWEEN r.vigenciainicio and r.vigenciafin and r.activo = 1")
            ->setParameter("fecha", $filtros["fecha"]) 
            ->groupBy('r.rutaid');
        if (isset($filtros['rutaid'])) {
            $result->andWhere('r.rutaid = :rutaid')
                ->setParameter('rutaid', $filtros['rutaid']);
        }
        if ($filtros['sabado']) {
            $result->andWhere('r.sabado = 1');
        }
        if ($filtros['domingo']) {
            $result->andWhere('r.domingo = 1');
        }
        if (isset($filtros['boletoid'])){
            $result->setParameter("boletoid", $filtros['boletoid']);
        }
        
        return $result->getQuery()->getResult();
    }

    public function BuscarDisponibilidadAlumnos($filtros)
    {

        $qb = $this->em->createQueryBuilder();
        $suspendido = $qb->select('CASE 
        WHEN acs.suspenderinicio is not null THEN 
            (CASE WHEN :fecha BETWEEN acs.suspenderinicio and acs.suspenderfin THEN 1 ELSE 0 END)
        ELSE 0 END')
            ->from("AppBundle:TpAlumnoporcontrato", "acs")
            ->where("ac.alumnoporcontratoid = acs.alumnoporcontratoid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $cancelado = $qb->select('CASE 
        WHEN acs2.fechacancelacion is not null THEN 
            (CASE WHEN :fecha >= acs2.fechacancelacion THEN 1 ELSE 0 END)
        ELSE 0 END')
            ->from("AppBundle:TpAlumnoporcontrato", "acs2")
            ->where("ac.alumnoporcontratoid = acs2.alumnoporcontratoid")
            ->getQuery()->getDQL();       

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, a.matricula, CONCAT_WS(' ',a.apellidopaterno,a.apellidomaterno, a.primernombre,a.segundonombre) alumno,
        GroupConcat(p.correo SEPARATOR ', ') correos, GroupConcat(p.celular SEPARATOR ', ') telefonos,
        'Contrato' tipoboleto, 1 cantidad, c.contratoid
        ")
            ->from('AppBundle:TpContrato', 'c')
            ->innerJoin('AppBundle:TpAlumnoruta', 'rc', Expr\Join::WITH, 'c.contratoid = rc.contratoid and :fecha BETWEEN c.vigenciainicio and c.vigenciafin')
            ->innerJoin('AppBundle:TpAlumnoporcontrato', 'ac', Expr\Join::WITH, 'ac.alumnoid = rc.alumnoid and c.contratoid = ac.contratoid and 0 = (' . $suspendido . ') and 0 = (' . $cancelado . ')')
            ->innerJoin("ac.alumnoid", "a")
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'pf', Expr\Join::WITH, 'c.clavefamiliarid = pf.clavefamiliarid')
            ->leftJoin("pf.padresotutoresid", 'p')
            ->where("rc.rutaid = " . $filtros["rutaid"])
            ->andWhere("ac.contratoestatusid IN (1,2) and a.alumnoestatusid <> 2")
            ->setParameter("fecha", $filtros["fecha"])
            ->groupBy("ac.alumnoporcontratoid");
        $contratos = $result->getQuery()->getResult();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, a.matricula, CONCAT_WS(' ',a.apellidopaterno,a.apellidomaterno, a.primernombre,a.segundonombre) alumno, 
        GroupConcat(distinct p.correo SEPARATOR ', ') correos, GroupConcat(distinct p.celular SEPARATOR ', ') telefonos,
        'Granel' tipoboleto, count(distinct b.boletoid) cantidad, GroupConcat(distinct b.boletoid) boletoid
        ")
            ->from('AppBundle:TpBoleto', 'b')
            ->innerJoin("b.alumnoid", "a")
            ->leftJoin("AppBundle:CeAlumnoporclavefamiliar", "af", Expr\Join::WITH, 'a.alumnoid = af.alumnoid')
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'pf', Expr\Join::WITH, 'af.clavefamiliarid = pf.clavefamiliarid')
            ->leftJoin("pf.padresotutoresid", 'p')
            ->where("b.rutaid = " . $filtros["rutaid"])
            ->andWhere("b.fecha = :fecha")
            ->setParameter("fecha", $filtros["fecha"])
            ->groupBy("a.alumnoid");
        $boletos = $result->getQuery()->getResult();

        return array_merge($contratos, $boletos);
    }

    public function BuscarMisboletos($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("b.boletoid, a.alumnoid, a.matricula, CONCAT_WS(' ',a.apellidopaterno,a.apellidomaterno, a.primernombre,a.segundonombre) alumno, DATE_FORMAT(b.fecha, '%d/%m/%Y') fecha,
        DATE_FORMAT(b.fecha, '%Y-%m-%d') date, r.rutaid, r.nombre ruta, r.tipoviaje, p.rutaprecioparadaid paradaid, b.precio, CONCAT_WS(' ', c.clave, ' - ', c.apellidopaterno, c.apellidomaterno) familia, b.escaneado, e.nombre estatus, CASE WHEN b.fecha >= CURRENT_DATE() THEN true ELSE false END editable")
            ->from('AppBundle:TpBoleto', 'b')
            ->innerJoin('b.rutaid', 'r')
            ->innerJoin('b.paradaid', 'p')
            ->innerJoin("b.alumnoid", "a")
            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "af", Expr\Join::WITH, 'a.alumnoid = af.alumnoid')
            ->innerJoin("af.clavefamiliarid", 'c')
            ->innerJoin('AppBundle:CePadresotutoresclavefamiliar', 'pf', Expr\Join::WITH, 'af.clavefamiliarid = pf.clavefamiliarid')
            ->innerJoin('b.documentoporpagarid', 'd')
            ->innerJoin('d.pagoestatusid', 'e')
            ->groupBy('b.boletoid');
        if (isset($filtros['rutaid'])) {
            $result->andWhere('r.rutaid = ' . $filtros["rutaid"]);
        }
        if (isset($filtros['clavefamiliar'])) {
            $result->andWhere('c.clave like :clavefamiliar')
                ->setParameter('clavefamiliar', '%' . $filtros['clavefamiliar'] . '%');
        }
        if (isset($filtros['matricula'])) {
            $result->andWhere('a.matricula like :matricula')
                ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }
        if (isset($filtros['fecha'])) {
            $dateinicio = new \DateTime($filtros['fechainicio']);
            $datefin = new \DateTime($filtros['fechafin']);
            $result->andWHere('b.fecha BETWEEN :fechainicio and :fechafin')
            ->setParameter('fechainicio', $dateinicio)
            ->setParameter('fechafin', $datefin);
        }
        if (isset($filtros['padreotutorid'])) {
            $result->andWhere('pf.padresotutoresid = ' . $filtros["padreotutorid"])
                ->andWhere('b.fecha >= CURRENT_DATE()');
        }
        if (isset($filtros['alumnoid'])) {
            $result->andWhere('a.alumnoid = ' . $filtros["alumnoid"])
                ->andWhere('b.fecha >= CURRENT_DATE()');
        }
        if (isset($filtros['boletoid'])) {
            $result->andWhere('b.boletoid = ' . $filtros["boletoid"]);
        }
        return $result->getQuery()->getResult();
    }

    public function BuscarBoletoBitacora($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $fechaviaje = $qb->select("GROUPCONCAT(DISTINCT DATE_FORMAT(b2.fechaviaje, '%d/%m/%Y') separator '<br>')")
            ->from("AppBundle:TpBoletobitacora", "b2")
            ->where("b2.boletoid = b.boletoid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $fechacompra = $qb->select("GROUPCONCAT(DISTINCT CONCAT(DATE_FORMAT(b3.fechacompra, '%d/%m/%Y'), ' ', DATE_FORMAT(b3.fechacompra , '%H:%i')) separator '<br>')")
        ->from("AppBundle:TpBoletobitacora", "b3")
        ->where("b3.boletoid = b.boletoid")
        ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $fechaedicion = $qb->select("GROUPCONCAT(DISTINCT CONCAT(DATE_FORMAT(b4.fechaedicion, '%d/%m/%Y'), ' ', DATE_FORMAT(b4.fechaedicion , '%H:%i')) separator '<br>')")
        ->from("AppBundle:TpBoletobitacora", "b4")
        ->where("b4.boletoid = b.boletoid")
        ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $medioedicion = $qb->select("GROUPCONCAT(DISTINCT b5.medioedicion separator '<br>')")
        ->from("AppBundle:TpBoletobitacora", "b5")
        ->where("b5.boletoid = b.boletoid")
        ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $usuarioedicion = $qb->select("GROUPCONCAT(DISTINCT b6.usuarioedicion separator '<br>')")
        ->from("AppBundle:TpBoletobitacora", "b6")
        ->where("b6.boletoid = b.boletoid")
        ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $fechacancelcacion = $qb->select("GROUPCONCAT(CONCAT(DATE_FORMAT(b7.fechacancelacion, '%d/%m/%Y'), ' ', DATE_FORMAT(b7.fechacancelacion , '%H:%i')) separator '<br>')")
        ->from("AppBundle:TpBoletobitacora", "b7")
        ->where("b7.boletoid = b.boletoid")
        ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $usuariocancelacion = $qb->select("GROUPCONCAT(DISTINCT b8.usuariocancelacion separator '<br>')")
        ->from("AppBundle:TpBoletobitacora", "b8")
        ->where("b8.boletoid = b.boletoid")
        ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $mediocancelacion = $qb->select("GROUPCONCAT(DISTINCT b9.mediocancelacion separator '<br>')")
        ->from("AppBundle:TpBoletobitacora", "b9")
        ->where("b9.boletoid = b.boletoid")
        ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("b.boletoid, r.nombre as ruta, concat_ws(' ', a.matricula,'-',a.apellidopaterno,a.apellidomaterno,a.primernombre) as alumno,
            b.usuario as comprador, b.portal as mediocompra, b.precio,
            CONCAT_WS(' ', c.clave, ' - ', c.apellidopaterno, c.apellidomaterno) familia
             
            ")
            ->addSelect("(" . $fechaviaje . ") as fechaviaje")
            ->addSelect("(" . $fechacompra . ") as fechacompra")
            ->addSelect("(" . $fechaedicion . ") as fechaedicion")
            ->addSelect("(" . $medioedicion . ") as medioedicion")
            ->addSelect("(" . $usuarioedicion . ") as usuarioedicion")
            ->addSelect("(" . $fechacancelcacion . ") as fechacancelacion")
            ->addSelect("(" . $usuariocancelacion . ") as usuariocancelacion")
            ->addSelect("(" . $mediocancelacion . ") as mediocancelacion")
            ->from('AppBundle:TpBoletobitacora', 'b')
            ->innerJoin('b.rutaid', 'r')
            ->innerJoin("b.alumnoid", "a")
            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "af", Expr\Join::WITH, 'a.alumnoid = af.alumnoid')
            ->innerJoin("af.clavefamiliarid", 'c')
            ->groupBy('b.boletoid');
        if (isset($filtros['rutaid'])) {
            $result->andWhere('r.rutaid = ' . $filtros["rutaid"]);
        }
        if (isset($filtros['clavefamiliar'])) {
            $result->andWhere('c.clave like :clavefamiliar')
                ->setParameter('clavefamiliar', '%' . $filtros['clavefamiliar'] . '%');
        }
        if (isset($filtros['matricula'])) {
            $result->andWhere('a.matricula like :matricula')
                ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }
        if (isset($filtros['fechaviaje'])) {
            $result->andWhere('b.fechaviaje = :fechaviaje')
                ->setParameter('fechaviaje', $filtros['fechaviaje']);
        }
        if (isset($filtros['fecha'])) {
            $dateinicio = new \DateTime($filtros['fechainicio']);
            $datefin = new \DateTime($filtros['fechafin']);
            $result->andWHere('(CAST(b.fechacompra as date) BETWEEN :fechainicio and :fechafin) OR (CAST(b.fechaedicion as date) BETWEEN :fechainicio and :fechafin) OR (CAST(b.fechacancelacion as date) BETWEEN :fechainicio and :fechafin)')
            ->setParameter('fechainicio', $dateinicio)
            ->setParameter('fechafin', $datefin);
        }
        return $result->getQuery()->getResult();
    }
}
