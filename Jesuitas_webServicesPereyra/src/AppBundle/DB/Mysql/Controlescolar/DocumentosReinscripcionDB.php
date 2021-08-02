<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Directorio escolar
 *
 * @author david
 */
class DocumentosReinscripcionDB extends BaseDBManager {

    public function BuscarAlumnosDocumentos($filtros) {
        $qb = $this->em->createQueryBuilder();
        $ciclo = $qb->select('max(c2.cicloid)')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.cicloid", 'c2')
            ->where("a.alumnoid = ac2.alumnoid");

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("CONCAT_WS('', p.valor, '/api/Alumno/foto?alumnoid=', a.alumnoid) as foto,
        a.matricula, CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) as nombre,
        CONCAT_WS(' ', n.nombre,g.grado, gr.nombre) as nivelgrupo, CONCAT_WS(' ', cf.apellidopaterno, cf.apellidomaterno) as familia,
        a.matricula, a.primernombre, ac.alumnoporcicloid, ac3.documentosreinscripcion,
        CONCAT_WS(' ', n2.nombre, groupconcat(DISTINCT g2.grado)) as reingresaen,
        a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre, groupconcat(distinct ac3.alumnoporcicloid) as alumnoporcicloiddestino
        ")
        ->from("AppBundle:CeAlumnoporciclo", 'ac')
        ->innerJoin("ac.alumnoid", 'a')
        ->innerJoin("ac.gradoid", 'g')
        ->innerJoin("g.nivelid", 'n')
        ->innerJoin("ac.cicloid", 'c')
        ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid")
        ->leftJoin("acg.grupoid", 'gr')
        ->leftJoin("AppBundle:CeAlumnoporclavefamiliar", "acf", Expr\Join::WITH, "acf.alumnoid = a.alumnoid")
        ->leftJoin("acf.clavefamiliarid", 'cf')
        ->leftJoin("AppBundle:Parametros", "p", Expr\Join::WITH, "p.nombre = 'URLServicios'")
        ->Join("AppBundle:CeAlumnoporciclo", "ac3", Expr\Join::WITH, "ac3.alumnoid =a.alumnoid and ac3.cicloid = (" . $ciclo . ")")
        ->leftJoin("ac3.gradoid", 'g2')
        ->leftJoin("g2.nivelid", 'n2')
        ->groupBy('a.alumnoid');

        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid IN (:cicloid)')
        	->setParameter('cicloid', $filtros['cicloid']);
        }

        if (count($filtros['nivelid'])>0) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid', $filtros['nivelid']);
        }

        if (count($filtros['gradoid'])>0){
        	$result->andWhere('g.gradoid IN (:gradoid)')
        	->setParameter('gradoid', $filtros['gradoid']);
        }

        if (isset($filtros['grupoid'])) {
        	$result->andWhere('gr.grupoid = :grupoid')
        	->setParameter('grupoid', $filtros['grupoid']);
        }

        if (isset($filtros['matricula']) && !empty($filtros['matricula'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['matricula']=trim(str_replace($escape,$escapados,$filtros['matricula']));
            $result->andWhere('a.matricula like :matricula')
	        ->setParameter('matricula', '%'.$filtros['matricula'].'%');             
        }  

        if (isset($filtros['clavefamiliar']) && !empty($filtros['clavefamiliar'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['clavefamiliar']=trim(str_replace($escape,$escapados,$filtros['clavefamiliar']));
            $result->andWhere('cf.clave like :clavefamiliar')
	        ->setParameter('clavefamiliar', '%'.$filtros['clavefamiliar'].'%');             
        }  


        return $result->getQuery()->getResult();
    }

}
