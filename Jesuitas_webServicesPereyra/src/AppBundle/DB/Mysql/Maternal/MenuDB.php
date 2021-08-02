<?php

namespace AppBundle\DB\Mysql\Maternal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Menu
 *
 * @author Mariano
 */
class MenuDB extends BaseDBManager {

    public function BuscarMenu($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("m")
        ->from("AppBundle:MaMenu","m");
        if (isset($filtros['descripcion'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['descripcion']=str_replace($escape,$escapados,$filtros['descripcion']);
        	$result->andWhere('m.descripcion like :descripcion')
            ->setParameter('descripcion', '%'.$filtros['descripcion'].'%');
        }
        if (isset($filtros['menuid'])) {
        	$result->andWhere('m.menuid = :menuid')
            ->setParameter('menuid', $filtros['menuid']);
        }
        return $result->getQuery()->getResult();
    }

    public function BuscarAsignaciones($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("am")
        ->from("AppBundle:MaAsignacionmenu","am")
        ->innerJoin("am.menuid", "m");
        if (isset($filtros['fecha'])) {
            $fechainicio = new \DateTime($filtros["fecha"]["beginDate"]["year"] . "-" . $filtros["fecha"]["beginDate"]["month"] . "-" . $filtros["fecha"]["beginDate"]["day"]);
            $fechafin = new \DateTime($filtros["fecha"]["endDate"]["year"] . "-" . $filtros["fecha"]["endDate"]["month"] . "-" . $filtros["fecha"]["endDate"]["day"]);
        	$result->andWhere('am.fecha between :fechainicio and :fechafin')
            ->setParameter('fechainicio', $fechainicio->format('Y-m-d'))
            ->setParameter('fechafin', $fechafin->format('Y-m-d'));
        }

        return $result->getQuery()->getResult();
    }

    public function BuscarAlumnosMaternal() {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid,a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre,a.matricula")
        ->from("AppBundle:CeAlumno","a")
        ->innerJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "ac.alumnoid=a.alumnoid")
        ->innerJoin("ac.cicloid", "c")
        ->innerJoin("AppBundle:CeAlumnocicloporgrupo", 'acg', Expr\Join::WITH, "acg.alumnoporcicloid=ac.alumnoporcicloid");
        $result->andWhere('ac.gradoid = 19');
        $result->andWhere('c.actual = 1');
        $result->orderBy("acg.numerolista");
        
        
        return $result->getQuery()->getResult();
    }

    public function BuscarAsignacion($filtros) {
        $fechainicio = new \DateTime($filtros['fechainicio']);
        $fechafin = new \DateTime($filtros['fechafin']);
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("am")
        ->from("AppBundle:MaAsignacionmenu","am");
        if (isset($filtros['menuid'])) {
        	$result->andWhere('am.menuid = :menuid')
            ->setParameter('menuid', $filtros['menuid']);
        }
        if (isset($filtros['fechainicio']) && isset($filtros['fechafin'])) {
        	$result->andWhere('am.fecha between :fechainicio and :fechafin')
            ->setParameter('fechainicio', $fechainicio->format('Y-m-d'))
            ->setParameter('fechafin', $fechafin->format('Y-m-d'));
        }
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('am.alumnoid = :alumnoid')
            ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['fecha'])) {
        	$result->andWhere('am.fecha = :fecha')
            ->setParameter('fecha', $filtros['fecha']);
        }
        if (isset($filtros['semana'])) {
            if(isset($filtros['year'])) {
                $result->andWhere("DATE_FORMAT(am.fecha,'%u') = :semana and DATE_FORMAT(am.fecha,'%Y') = :year")
                ->setParameter('semana', $filtros['semana'])
                ->setParameter('year', $filtros['year']);
            } else {
                $result->andWhere("DATE_FORMAT(am.fecha,'%u') = :semana")
                ->setParameter('semana', $filtros['semana']);
            }
        }
        
        return $result->getQuery()->getResult();
    }

    public function BuscarAsignacionPadre($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("am")
        ->from("AppBundle:MaAsignacionmenu","am");
        if (isset($filtros['year']) && !isset($filtros['month'])) {
        	$result->andWhere("DATE_FORMAT(am.fecha,'%Y')=:year")
            ->setParameter('year', $filtros['year']);
        }
        if (isset($filtros['year']) && isset($filtros['month'])) {
        	$result->andWhere("DATE_FORMAT(am.fecha,'%Y')=:year and DATE_FORMAT(am.fecha,'%c')=:month")
            ->setParameter('year', $filtros['year'])
            ->setParameter('month', $filtros['month']);
        }
        
        return $result->getQuery()->getResult();
    }

    public function BuscarPadre($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pt")
        ->from("AppBundle:CeClavefamiliar","cf")
        ->innerJoin("AppBundle:CePadresotutoresclavefamiliar", 'ptcf', Expr\Join::WITH, "cf.clavefamiliarid = ptcf.clavefamiliarid")
        ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", 'acf', Expr\Join::WITH, "cf.clavefamiliarid = acf.clavefamiliarid")
        ->innerJoin("AppBundle:CeAlumno", 'a', Expr\Join::WITH, "acf.alumnoid = a.alumnoid")
        ->innerJoin("AppBundle:CePadresotutores", 'pt', Expr\Join::WITH, "pt.padresotutoresid=ptcf.padresotutoresid");
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('a.alumnoid = :alumnoid')
            ->setParameter('alumnoid', $filtros["alumnoid"]);
        }
        if (isset($filtros['padresotutoresid'])) {
        	$result->andWhere('pt.padresotutoresid = :padresotutoresid')
            ->setParameter('padresotutoresid', $filtros["padresotutoresid"]);
        }
       
        return $result->getQuery()->getResult();
    }

    public function BuscarPadreUsuario($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("u")
        ->from("AppBundle:CeClavefamiliar","cf")
        ->innerJoin("AppBundle:CePadresotutoresclavefamiliar", 'ptcf', Expr\Join::WITH, "cf.clavefamiliarid = ptcf.clavefamiliarid")
        ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", 'acf', Expr\Join::WITH, "cf.clavefamiliarid = acf.clavefamiliarid")
        ->innerJoin("AppBundle:CeAlumno", 'a', Expr\Join::WITH, "acf.alumnoid = a.alumnoid")
        ->innerJoin("AppBundle:CePadresotutores", 'pt', Expr\Join::WITH, "pt.padresotutoresid=ptcf.padresotutoresid")
        ->innerJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.padreotutorid=ptcf.padresotutoresid")
        ->groupBy('pt.padresotutoresid');
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('a.alumnoid = :alumnoid')
            ->setParameter('alumnoid', $filtros["alumnoid"]);
        }
        if (isset($filtros['padresotutoresid'])) {
        	$result->andWhere('pt.padresotutoresid = :padresotutoresid')
            ->setParameter('padresotutoresid', $filtros["padresotutoresid"]);
        }
       
        return $result->getQuery()->getResult();
    }

    


    public function BuscarMenuanterior($alumnoid) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("am.asignacionmenuid,m.menuid,am.fecha")
        ->from("AppBundle:MaAsignacionmenu","am")
        ->innerJoin("am.menuid", "m");
        $result->andWhere('am.alumnoid = :alumnoid')
        ->setParameter('alumnoid', $alumnoid);
        $result->orderBy("am.fecha","DESC");
        return $result->getQuery()->getResult();
    }

}
