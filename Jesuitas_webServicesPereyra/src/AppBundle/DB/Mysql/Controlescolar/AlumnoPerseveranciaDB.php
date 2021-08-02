<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of AlumnosPerseverancia
 *
 * @author David
 */
class AlumnoPerseveranciaDB extends BaseDBManager
{

    /*
     * Obtiene un array de alumnos
     */
    public function GetAlumnosPerseverancia($filtros)
    {
        $alumnociclo = $this->em->createQueryBuilder()->select("GROUPCONCAT(DISTINCT concat(b.alumnoporcicloid,'/',c2.nombre,'_',n2.nombre,'_',g2.grado))")
        ->from("AppBundle:CeAlumnoporciclo", "b")
        ->innerJoin("b.gradoid", "g2")
        ->innerJoin("g2.nivelid", "n2")
        ->innerJoin("b.cicloid", "c2")
        ->where("b.alumnoid = a.alumnoid");


        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, a.matricula, a.alumnoperseverancia, CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) as alumno,
             GROUPCONCAT(DISTINCT concat(c.cicloid,'/',concat_WS(' ', n.nombre, g.grado))) as info,
             groupconcat(DISTINCT ac.alumnoporcicloid) as alumnosporciclo")
            ->addSelect("(" . $alumnociclo . ") as alumnosporcicloid")
            ->from("AppBundle:CeAlumno", "a")
            ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid")
            ->innerJoin("ac.cicloid", "c")
            ->innerJoin("AppBundle:CeCiclopornivel", "cc2", Expr\Join::WITH, "cc2.cicloid = c.cicloid")
            ->innerJoin("ac.gradoid", "g")
            ->innerJoin("g.nivelid", "n")
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "ac.alumnoporcicloid = acg.alumnoporcicloid")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "gr.grupoid = acg.grupoid and gr.tipogrupoid = 1")
            ->groupBy('a.alumnoid')
            ->Join("AppBundle:Ciclo", "ci", Expr\Join::WITH, "ci.cicloid = " .$filtros['cicloinicialid'])
            ->innerJoin("AppBundle:CeCiclopornivel", "cin", Expr\Join::WITH, "cin.cicloid = ci.cicloid")
            ->Join("AppBundle:Ciclo", "cf", Expr\Join::WITH, "cf.cicloid = ".$filtros['ciclofinalid'])
            ->innerJoin("AppBundle:CeCiclopornivel", "cfn", Expr\Join::WITH, "cfn.cicloid = cf.cicloid")
            ->Where('cc2.fechainicio >= cin.fechainicio and cc2.fechafin <= cfn.fechafin');


        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid IN (:cicloid)')
                ->setParameter('cicloid', $filtros['cicloid']);
        } 
        
        if (isset($filtros['nivelid'])) {
            $result->andWhere('n.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }  

        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid IN (:gradoid)')
                ->setParameter('gradoid', $filtros['gradoid']);
        } 
        if (isset($filtros['matricula'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['matricula'] = str_replace($escape, $escapados, $filtros['matricula']);
            $result->andWhere('a.matricula like :matricula')
                ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }

        if (isset($filtros['activo'])) {
            if($filtros['activo'] == "1") {
                $result->andWhere('a.alumnoestatusid = 1');
            } else if ($filtros['activo'] == "2") {
                $result->andWhere('a.alumnoestatusid = 2');
            }
        } 

        $alumnos = $result->getQuery()->getResult();
        foreach ($alumnos as $key => $a) {
            $aluinfo = explode(",",$a['info']);
            foreach ($aluinfo as $f) {
                $info = explode("/", $f);
                $alumnos[$key]['grados'][] = ['cicloid' => $info[0], 'nivelgrado' => $info[1]];
            }
        }

        return $alumnos;
    }
}