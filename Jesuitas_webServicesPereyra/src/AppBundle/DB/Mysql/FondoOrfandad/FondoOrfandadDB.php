<?php

namespace AppBundle\DB\Mysql\FondoOrfandad;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Filtrado de fondos de orfandad
 *
 * @author Rubén
 */
class FondoOrfandadDB extends BaseDBManager {

    public function BuscarFondoOrfandad($filtros) {

        $qb = $this->em->createQueryBuilder();
        $semestre = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN 2
        ELSE 1 END')
            ->from("AppBundle:CeCiclopornivel", "cn")
            ->where("c.cicloid = cn.cicloid and g.nivelid = cn.nivelid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("f.fondoorfandadid,DATE_FORMAT(f.fechainicio, '%d/%m/%Y') as fechainicio,
        f.comentarios, f.porcentajeapoyo,e.estatusid,e.nombre as estatus,c.nombre as ciclo,c.cicloid, n.nombre as nivel,
        g.grado as grado, a.alumnoid,a.matricula, Concat_WS(' ',a.primernombre,a.segundonombre)nombre,
        a.apellidopaterno,a.apellidomaterno, 
        case when calculaAdeudo(a.alumnoid) > 0 then 1 else 0 end as adeudo, tp.nombre tipocobertura")
        ->from("AppBundle:FoFondoorfandad", 'f')
        ->innerJoin('f.cicloid', 'c')
        ->innerJoin('f.estatusid', 'e')

        ->innerJoin('f.alumnoid', 'a')
        ->leftJoin('a.tipocoberturaid', 'tp')
        ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid and ac.cicloid = c.cicloid")
         ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "ac.gradoid = g.gradoid and (g.semestreid is null or g.semestreid = (".$semestre.") )")
        ->innerJoin("g.nivelid", "n")
        ->groupBy("f.fondoorfandadid");
        
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('f.cicloid =' . $filtros['cicloid']);        	
        } 
        if (isset($filtros['estatusid'])) {
           $result->andWhere('f.estatusid =' . $filtros['estatusid']);          	
        } 
        if (isset($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
            $result->andWhere('a.primernombre like :Nombre')
	        ->setParameter('Nombre', '%'.$filtros['nombre'].'%');       	
        }
        if (isset($filtros['apellidopaterno'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidopaterno']=str_replace($escape,$escapados,$filtros['apellidopaterno']);
            $result->andWhere('a.apellidopaterno like :apellidoP')
	        ->setParameter('apellidoP', '%'.$filtros['apellidopaterno'].'%');       	
        }
        if (isset($filtros['apellidomaterno'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['apellidomaterno']=str_replace($escape,$escapados,$filtros['apellidomaterno']);
            $result->andWhere('a.apellidomaterno like :ApellidoM')
	        ->setParameter('ApellidoM', '%'.$filtros['apellidomaterno'].'%');       	
        }
        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid IN (:gradosid)')
                ->setParameter('gradosid', $filtros['gradoid']);
        }
        if (isset($filtros['matricula'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['matricula']=trim(str_replace($escape,$escapados,$filtros['matricula']));
            $result->andWhere('a.matricula like :matricula')
            ->setParameter(':matricula', '%'. $filtros['matricula'].'%');        	
        } 
        return $result->getQuery()->getResult();
    }
  
}