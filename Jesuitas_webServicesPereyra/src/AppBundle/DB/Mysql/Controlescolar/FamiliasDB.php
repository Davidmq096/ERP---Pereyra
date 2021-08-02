<?php

namespace AppBundle\DB\Mysql\Controlescolar;
use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Familias
 *
 * @author David
 */
class FamiliasDB extends BaseDBManager {

    public function BuscarPadresFamilia($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('e.padresotutoresid, e.nombre, e.apellidopaterno, e.apellidomaterno, e.correo, e.vive, p.parentescoid, p.descripcion')
        ->from("AppBundle:CePadresotutores", 'e')
        //->innerJoin("AppBundle:Tutor", "t", Expr\Join::WITH, "t.tutorid = e.tutorid")
        ->leftJoin("AppBundle:Solicitudadmision", "sa", Expr\Join::WITH, "sa.solicitudadmisionid = e.solicitudadmisionid")
        ->leftJoin("AppBundle:Parentesco", "p", Expr\Join::WITH, "p.parentescoid =sa.parentescoidpersonacaptura")
        ->groupBy('e.padresotutoresid');

       if (isset($filtros['nombre'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
       	$result->andWhere('e.nombre like :nombre')
       	->setParameter('nombre', '%'.$filtros['nombre'].'%');
       }

       if (isset($filtros['apellidopaterno'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['apellidopaterno']=str_replace($escape,$escapados,$filtros['apellidopaterno']);
       	$result->andWhere('e.apellidopaterno like :apellidopaterno')
       	->setParameter('apellidopaterno', '%'.$filtros['apellidopaterno'].'%');
       }

       if (isset($filtros['apellidomaterno'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['apellidomaterno']=str_replace($escape,$escapados,$filtros['apellidomaterno']);
       	$result->andWhere('e.apellidomaterno like :apellidomaterno')
       	->setParameter('apellidomaterno', '%'.$filtros['apellidomaterno'].'%');
       }

       if (isset($filtros['correo'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['correo']=str_replace($escape,$escapados,$filtros['correo']);
       	$result->andWhere('e.correo like :correo')
       	->setParameter('correo', '%'.$filtros['correo'].'%');
       }

        return $result->getQuery()->getResult();
    }


    public function BuscarClavesfamiliares($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('cf.clavefamiliarid, cf.clave, cf.apellidopaterno, cf.apellidomaterno, st.situacionfamiliarid, a.alumnoid, pt.padresotutoresid, count(pf.padresotutoresfacturacionid) facturacion')
        ->from("AppBundle:CeClavefamiliar", 'cf')
        ->leftJoin("AppBundle:CeSituacionfamiliar", "st", Expr\Join::WITH, "st.situacionfamiliarid = cf.situacionfamiliarid")
        ->leftJoin("AppBundle:CeAlumnoporclavefamiliar", "af", Expr\Join::WITH, "af.clavefamiliarid = cf.clavefamiliarid")
        ->leftJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = af.alumnoid")
        ->leftJoin("AppBundle:CePadresotutoresclavefamiliar", "pc", Expr\Join::WITH, "pc.clavefamiliarid = cf.clavefamiliarid")
        ->leftJoin("AppBundle:CePadresotutores", "pt", Expr\Join::WITH, "pt.padresotutoresid = pc.padresotutoresid")
        ->leftJoin("AppBundle:CePadresotutoresfacturacion", "pf", Expr\Join::WITH, "pt.padresotutoresid = pf.padresotutoresid")
        ->groupBy('cf.clavefamiliarid');

       if (isset($filtros['clavefamilia'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['clavefamilia']=str_replace($escape,$escapados,$filtros['clavefamilia']);
       	$result->andWhere('cf.clave = :clavefamilia')
       	->setParameter('clavefamilia', $filtros['clavefamilia']);
       }

       if (isset($filtros['apellidopaterno'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['apellidopaterno']=str_replace($escape,$escapados,$filtros['apellidopaterno']);
       	$result->andWhere('pt.apellidopaterno like :apellidopaterno')
       	->setParameter('apellidopaterno', '%'.$filtros['apellidopaterno'].'%');
       }

       if (isset($filtros['apellidomaterno'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['apellidomaterno']=str_replace($escape,$escapados,$filtros['apellidomaterno']);
       	$result->andWhere('pt.apellidomaterno like :apellidomaterno')
       	->setParameter('apellidomaterno', '%'.$filtros['apellidomaterno'].'%');
       }

       if (isset($filtros['matricula'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['matricula']=trim(str_replace($escape,$escapados,$filtros['matricula']));
       	$result->andWhere('a.matricula = :matricula')
       	->setParameter('matricula', $filtros['matricula']);
       }

       if (isset($filtros['nombre'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
       	$result->andWhere('pt.nombre like :nombre')
       	->setParameter('nombre', '%'.$filtros['nombre'].'%');
       }

       
       if (isset($filtros['correo'])) {
        $escape=array("_","%");
        $escapados=array("\_","\%");
        $filtros['correo']=str_replace($escape,$escapados,$filtros['correo']);
       	$result->andWhere('pt.correo like :correo')
       	->setParameter('correo', '%'.$filtros['correo'].'%');
       }

        return $result->getQuery()->getResult();
    }

    public function BuscarAlumnoClaves($tipo,$clave) {
        $cadena = "";
        $qb = $this->em->createQueryBuilder();
        if ($tipo == 1) {
            $result = $qb->select('acf.alumnoporclavefamiliar, a.alumnoid, cf.clavefamiliarid','ae.nombre estatus',
            'a.matricula', 'a.primernombre nombre', 'a.apellidopaterno', 'a.apellidomaterno')
            ->from("AppBundle:CeAlumnoporclavefamiliar", 'acf')
            ->innerJoin("AppBundle:CeClavefamiliar", "cf", Expr\Join::WITH, "cf.clavefamiliarid = acf.clavefamiliarid")
            ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = acf.alumnoid")
            ->innerJoin("AppBundle:CeAlumnoestatus", "ae", Expr\Join::WITH, "ae.alumnoestatusid = a.alumnoestatusid");
            $result->andWhere("cf.clavefamiliarid = $clave");

        } else {
            $result = $qb->select('acf.padresotutoresporclavefamiliar, 
            pt.padresotutoresid, cf.clavefamiliarid',
            'pt.nombre', 'pt.apellidopaterno', 'pt.apellidomaterno', 't.descripcion parentesco','t.tutorid','u.cuenta usuario','u.usuarioid','pt.vive, count(pf.padresotutoresfacturacionid) facturacion')
            ->from("AppBundle:CePadresotutoresclavefamiliar", 'acf')
            ->innerJoin("AppBundle:CeClavefamiliar", "cf", Expr\Join::WITH, "cf.clavefamiliarid = acf.clavefamiliarid")
            ->innerJoin("AppBundle:CePadresotutores", "pt", Expr\Join::WITH, "pt.padresotutoresid = acf.padresotutoresid")
            ->innerJoin("AppBundle:Tutor", "t", Expr\Join::WITH, "t.tutorid = acf.tutorid")
            ->leftJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.padreotutorid = pt.padresotutoresid ")
            ->leftJoin("AppBundle:CePadresotutoresfacturacion", "pf", Expr\Join::WITH, "pt.padresotutoresid = pf.padresotutoresid")
            ->groupBy('pt.padresotutoresid');
            $result->andWhere("cf.clavefamiliarid = $clave");

        }

        return $result->getQuery()->getResult();
    }
    
    public function BuscarAlumnoPadreFamilia($tipo,$clave,$clavefamiliar) {
        $cadena = "";
        $qb = $this->em->createQueryBuilder();
        if ($tipo == 1) {
            $result = $qb->select('acf.alumnoporclavefamiliar, a.alumnoid, cf.clavefamiliarid',
            'a.matricula', 'cf.clave', 'cf.apellidopaterno', 'cf.apellidomaterno','sf.situacionfamiliarid','sf.descripcion as situacionfamiliar')
            ->from("AppBundle:CeClavefamiliar", 'cf')
            ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "acf", Expr\Join::WITH, "acf.clavefamiliarid = cf.clavefamiliarid")
            ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = acf.alumnoid")
            ->leftJoin("AppBundle:CeSituacionfamiliar", "sf", Expr\Join::WITH, "sf.situacionfamiliarid = cf.situacionfamiliarid");
            $result->andWhere("a.alumnoid = $clave");

            if ($clavefamiliar) {
                $result->andWhere("cf.clavefamiliarid = $clavefamiliar");
            }
            
        } else {
            $result = $qb->select('acf.padresotutoresporclavefamiliar, pt.padresotutoresid, cf.clavefamiliarid','cf.clave',
            'pt.nombre', 'pt.apellidopaterno', 'pt.apellidomaterno', 't.descripcion parentesco','t.tutorid as parentescoid','u.cuenta usuario')
            ->from("AppBundle:CeClavefamiliar", 'cf')
            ->innerJoin("AppBundle:CePadresotutoresclavefamiliar", "acf", Expr\Join::WITH, "acf.clavefamiliarid = cf.clavefamiliarid")
            ->innerJoin("AppBundle:CePadresotutores", "pt", Expr\Join::WITH, "pt.padresotutoresid = acf.padresotutoresid")
            ->innerJoin("AppBundle:Tutor", "t", Expr\Join::WITH, "t.tutorid = acf.tutorid")
            ->leftJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.padreotutorid = pt.padresotutoresid ");
            $result->andWhere("pt.padresotutoresid = $clave");

            if ($clavefamiliar) {
                $result->andWhere("cf.clavefamiliarid = $clavefamiliar");
            }

        }

        return $result->getQuery()->getResult();
    }

}
