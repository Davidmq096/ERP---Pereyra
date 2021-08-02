<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Ciclo
 *
 * @author Mariano
 */
class CicloDB extends BaseDBManager {

    public function BuscarCiclo($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.nombre,c.actual,c.activo,c.siguiente,DATE_FORMAT(cn.fechainicio,'%d/%m/%Y') fechainicio, 
        DATE_FORMAT(cn.fechafin,'%d/%m/%Y') fechafin, 
        cn.ciclopornivelid, 
        c.cicloid,
        n.nivelid,
        DATE_FORMAT(cn.fechainicios1,'%d/%m/%Y') fechainicios1,
        DATE_FORMAT(cn.fechafins1,'%d/%m/%Y') fechafins1,
        DATE_FORMAT(cn.fechainicios2,'%d/%m/%Y') fechainicios2,
        DATE_FORMAT(cn.fechafins2,'%d/%m/%Y') fechafins2
        ")
        ->from("AppBundle:Ciclo","c")
        ->innerJoin("AppBundle:CeCiclopornivel", 'cn', Expr\Join::WITH, "c.cicloid=cn.cicloid")
        ->innerJoin("cn.nivelid", 'n')
        ->groupBy("c.cicloid");  ;
        if (isset($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
        	$result->andWhere('c.nombre like :nombre')
        	->setParameter('nombre', '%'.$filtros['nombre'].'%');
        }
        if (isset($filtros['fecha'])) {
            $dateinicio=new \DateTime($filtros["fecha"]["beginDate"]["year"]."-".$filtros["fecha"]["beginDate"]["month"]."-".$filtros["fecha"]["beginDate"]["day"]);
            $datefin=new \DateTime($filtros["fecha"]["endDate"]["year"]."-".$filtros["fecha"]["endDate"]["month"]."-".$filtros["fecha"]["endDate"]["day"]);
            $result->andWhere('cn.fechainicio<=:fechainicio and cn.fechafin>=:fechafin')
                    ->setParameter("fechainicio", $dateinicio)
                    ->setParameter("fechafin", $datefin);
        }
        if (isset($filtros['actual'])) {
            if ($filtros['actual']==2){$filtros['actual']=false;}
            if ($filtros['actual']==1){$filtros['actual']=true;}
        	$result->andWhere('c.actual = :actual')
        	->setParameter('actual', $filtros['actual']);
        }if (isset($filtros['activo'])) {
            if ($filtros['activo']==2){$filtros['activo']=false;}
            if ($filtros['activo']==1){$filtros['activo']=true;}
        	$result->andWhere('c.activo = :activo')
        	->setParameter('activo', $filtros['activo']);
        }
        if (isset($filtros['siguiente'])) {
            if ($filtros['siguiente']==2){$filtros['siguiente']=false;}
            if ($filtros['siguiente']==1){$filtros['siguiente']=true;}
        	$result->andWhere('c.siguiente = :siguiente')
        	->setParameter('siguiente', $filtros['siguiente']);
        }
        $result->andWhere('cn.fechainicios1 is not null');

        return $result->getQuery()->getResult();
    }

}
