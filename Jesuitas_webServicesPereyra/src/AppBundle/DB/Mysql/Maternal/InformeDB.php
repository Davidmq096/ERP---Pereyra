<?php

namespace AppBundle\DB\Mysql\Maternal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Informe
 *
 * @author Mariano
 */
class InformeDB extends BaseDBManager {

    
    public function BuscarInformeApp($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("i")
        ->from("AppBundle:MaInforme","i");
        if (isset($filtros['estatus'])) {
        	$result->andWhere('i.estatus=:estatus')
        	->setParameter('estatus', $filtros['estatus']);
        }
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('i.alumnoid=:alumnoid')
        	->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['fecha'])) {
        	$result->andWhere("DATE_FORMAT(i.fecha,'%Y-%m-%d')=:fecha")
            ->setParameter('fecha', $filtros['fecha']);
        }
        $result->andWhere('i.estatus=1');
        return $result->getQuery()->getResult();
    }
    
    public function DatosAlumnoInforme($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid,a.matricula,a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre,a.fechanacimiento,acf.foto")
        ->from("AppBundle:CeAlumno","a")
        ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, " a.alumnoid = ac.alumnoid")
        ->leftJoin("AppBundle:CeAlumnociclofoto", "acf", Expr\Join::WITH, " ac.alumnoporcicloid = acf.alumnoporcicloid");
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('ac.cicloid=:cicloid')
        	->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('a.alumnoid = :alumnoid')
            ->setParameter('alumnoid', $filtros['alumnoid'])            ;
        }
        $result->andWhere('ac.gradoid=19');
        return $result->getQuery()->getResult();
    }

    public function BuscarPadreInforme($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("u")
        ->from("AppBundle:CeAlumno","a")
        ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid=a.alumnoid")
        ->innerJoin("AppBundle:CeAlumnoporclavefamiliar", "acf", Expr\Join::WITH, "acf.alumnoid=a.alumnoid")
        ->innerJoin("AppBundle:CePadresotutoresclavefamiliar", "ptcf", Expr\Join::WITH, "acf.clavefamiliarid=ptcf.clavefamiliarid")
        ->innerJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.padreotutorid=ptcf.padresotutoresid");
        $result->andWhere('ac.gradoid=19');
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('a.alumnoid = :alumnoid')
        	->setParameter('alumnoid', $filtros['alumnoid']);
        }
        $result->groupBy("u.usuarioid");
        return $result->getQuery()->getResult();
    }

    public function BuscarAlumnosInforme($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid,a.matricula,a.apellidopaterno,a.apellidomaterno,a.primernombre,a.segundonombre,a.fechanacimiento,acf.foto,i.estatus")
        ->from("AppBundle:CeAlumno","a")
        ->leftJoin("AppBundle:MaInforme", 'i', Expr\Join::WITH, "i.alumnoid = a.alumnoid")
        ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, " a.alumnoid = ac.alumnoid")
        ->leftJoin("AppBundle:CeAlumnociclofoto", "acf", Expr\Join::WITH, " ac.alumnoporcicloid = acf.alumnoporcicloid");
        if (isset($filtros['estatus'])) {
        	$result->andWhere('i.estatus=:estatus')
        	->setParameter('estatus', $filtros['estatus']);
        }
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('ac.cicloid=:cicloid')
        	->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['fecha'])) {
            $fecha = new \DateTime($filtros["fecha"]["date"]["year"] . "-" . $filtros["fecha"]["date"]["month"] . "-" . $filtros["fecha"]["date"]["day"]);
        	$result->andWhere('i.fecha = :fecha or i.fecha is null')
            ->setParameter('fecha', $fecha->format('Y-m-d'))            ;
        }
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('a.alumnoid = :alumnoid')
            ->setParameter('alumnoid', $filtros['alumnoid'])            ;
        }
        $result->andWhere('ac.gradoid=19');
        return $result->getQuery()->getResult();
    }
    

    public function BuscarInforme($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("i.informeid,DATE_FORMAT(i.fecha,'%d/%m/%Y') as fecha,a.alumnoid,i.estatus,i.animo,i.panal,i.bano,i.panal1,i.bano1,i.panal2,i.bano2,i.panaltipo,i.banotipo,i.accidente,i.accidenteaviso,i.comida,i.comidaobservaciones,i.sueno,i.suenohoras,i.observaciones")
        ->from("AppBundle:MaInforme","i")
        ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = i.alumnoid");
        if (isset($filtros['estatusid'])) {
        	$result->andWhere('i.estatus=:estatus')
        	->setParameter('estatus', $filtros['estatusid']);
        }
        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('i.alumnoid in (:alumnoid)')
        	->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['fecha'])) {
            if (isset($filtros['fecha']["date"])) {
                $fecha = new \DateTime($filtros["fecha"]["date"]["year"] . "-" . $filtros["fecha"]["date"]["month"] . "-" . $filtros["fecha"]["date"]["day"]);
                $result->andWhere('i.fecha = :fecha')
                ->setParameter('fecha', $fecha->format('Y-m-d'))            ;
            }else{
                if (isset($filtros["fecha"]["beginDate"]) && isset($filtros["fecha"]["endDate"])) {
                    $fechainicio = new \DateTime($filtros["fecha"]["beginDate"]["year"] . "-" . $filtros["fecha"]["beginDate"]["month"] . "-" . $filtros["fecha"]["beginDate"]["day"]);
                    $fechafin = new \DateTime($filtros["fecha"]["endDate"]["year"] . "-" . $filtros["fecha"]["endDate"]["month"] . "-" . $filtros["fecha"]["endDate"]["day"]);
                    $result->andWhere('i.fecha between :fechainicio and :fechafin')
                    ->setParameter('fechainicio', $fechainicio->format('Y-m-d'))
                    ->setParameter('fechafin', $fechafin->format('Y-m-d'));
                }else{
                    $result->andWhere("DATE_FORMAT(i.fecha,'%Y-%m-%d')=:fecha")
                    ->setParameter('fecha', $filtros['fecha']);
                }
            }
        }
        

        return $result->getQuery()->getResult();
    }

}
