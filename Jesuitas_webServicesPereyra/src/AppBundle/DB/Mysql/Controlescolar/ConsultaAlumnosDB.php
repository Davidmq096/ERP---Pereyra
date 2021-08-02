<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Consulta de alumnos
 *
 * @author David Medina
 */

class ConsultaAlumnosDB extends BaseDBManager {

    public function BuscarMatriculaAlumnoOyente()
    {
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare("select CAST(REGEXP_REPLACE(SUBSTRING(Matricula, LOCATE('-',Matricula)+1), '^0*','') as int) as matricula 
        from ce_alumno where matricula like '%-%' order by matricula desc limit 1 ;");
        $stmt->execute();
        $matricula = $stmt->fetchAll();
        return $matricula;
    } 

    public function BuscarAllAlumnos($filtros){
		$qb=$this->em->createQueryBuilder();
        $result=$qb->select('ac.alumnoporcicloid, a.alumnoid, a.matricula, a.primernombre,a.apellidopaterno,a.apellidomaterno, e.alumnoestatusid, e.nombre as estatus,
            n.nombre as nivel, n.nivelid, g.grado, gr.nombre as grupo, tb.nombre as tipobaja, m.nombre as motivobaja,
            a.intercambio, a.oyente, ea.estatusalumnoporcicloid, ea.nombre as estatusalumno, c.nombre as ciclo')
            ->from("AppBundle:CeAlumno", 'a')
            ->leftJoin("AppBundle:CeIntercambioporalumno", "ia", Expr\Join::WITH, "ia.alumnoid = a.alumnoid")
            ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid")
			->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid")
			->innerJoin("AppBundle:CeAlumnoestatus", "e", Expr\Join::WITH, "e.alumnoestatusid = a.alumnoestatusid")
            ->leftJoin("acg.grupoid", "gr")
            ->leftJoin("ac.motivobajaid", "m")
            ->leftJoin("m.tipobajaid", "tb")
            ->innerJoin("ac.gradoid", "g")
            ->leftJoin("ac.estatusalumnocicloid", "ea")
            ->innerJoin("g.nivelid", "n")
            ->innerJoin("ac.cicloid", "c")
            ->orderBy("ac.alumnoporcicloid","desc")
            ->groupBy("a.alumnoid");

        if(isset($filtros['matricula'])){
            $escape=array("_", "%");
            $escapados=array("\_", "\%");
            $filtros['matricula']=str_replace($escape, $escapados, $filtros['matricula']);
            $result->andWhere('a.matricula like :matricula')
            ->setParameter('matricula', '%'.$filtros['matricula'].'%');
        }                
		if(isset($filtros['nombre'])){
			$escape=array("_", "%");
			$escapados=array("\_", "\%");
			$filtros['nombre']=str_replace($escape, $escapados, $filtros['nombre']);
			$result->andWhere('a.primernombre like :nombre')
							->setParameter('nombre', '%'.$filtros['nombre'].'%');
        }
        if(isset($filtros['apellidopaterno'])){
			$escape=array("_", "%");
			$escapados=array("\_", "\%");
			$filtros['apellidopaterno']=str_replace($escape, $escapados, $filtros['apellidopaterno']);
			$result->andWhere('a.apellidopaterno like :apellidopaterno')
							->setParameter('apellidopaterno', '%'.$filtros['apellidopaterno'].'%');
        }
        if(isset($filtros['apellidomaterno'])){
			$escape=array("_", "%");
			$escapados=array("\_", "\%");
			$filtros['apellidomaterno']=str_replace($escape, $escapados, $filtros['apellidomaterno']);
			$result->andWhere('a.apellidomaterno like :apellidomaterno')
							->setParameter('apellidomaterno', '%'.$filtros['apellidomaterno'].'%');
		}
		if(isset($filtros['estatusalumnoid'])){
			$result->andWhere('e.alumnoestatusid IN (:estatusalumnoid)')
							->setParameter('estatusalumnoid', $filtros['estatusalumnoid']);
		}
        if (count($filtros['nivelid'])>0) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid', $filtros['nivelid']);
        }

        if (count($filtros['gradoid'])>0){
        	$result->andWhere('g.gradoid IN (:gradoid)')
        	->setParameter('gradoid', $filtros['gradoid']);
        }

		if(isset($filtros['grupoid'])){
			$result->andWhere('acg.grupoid IN (:grupoid)')
							->setParameter('grupoid', $filtros['grupoid']);
		}
		if(isset($filtros['intercambio'])) {

			$result->andWhere('a.intercambio IN (:intercambio)')
							->setParameter('intercambio', $filtros['intercambio']);
        }
        
        if(isset($filtros['oyente'])) {
			$result->andWhere('a.oyente IN (:oyente)')
							->setParameter('oyente', $filtros['oyente']);
        }
        
		return $result->getQuery()->getResult();
	}

	public function BuscarAlumnociclo($id) 
    {
        try 
        {
            $conn = $this->em->getConnection();
            $stmt = $conn->prepare("select ac.alumnoporcicloid, a.alumnoid, ac.cicloid, ac.gradoid, 
            concat_ws(' ', a.primernombre, a.apellidopaterno, a.apellidomaterno) as nombrecompleto
            from ce_alumnoporciclo ac 
            inner join ce_alumno a on a.alumnoid = ac.alumnoid
            where ac.alumnoid = :id order by ac.cicloid desc limit 1");
            $stmt->execute(array('id' => $id));
            $result = $stmt->fetchAll(); 
            return $result;          
        } 
        catch (Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function BuscarNolista($grupo)
    {
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare("select max(NumeroLista) as nolista from ce_alumnocicloporgrupo where GrupoId =" . $grupo);
        $stmt->execute();
        $nolista = $stmt->fetchAll();
        return $nolista;
    } 


}


