<?php

namespace AppBundle\DB\Mysql\Controlescolar;
use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Ciudades
 *
 * @author Javier
 */
class ConfTallerExtraCurricularDB extends BaseDBManager
{

    public function obtenerAlumnoTallerExtracurricular($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid",
					"a.primernombre",
					"a.segundonombre",
					"a.apellidopaterno",
					"a.apellidomaterno",
					"c.nombre AS ciclo",
					"c.cicloid",
					"gru.nombre AS grupo",
					"gru.grupoid",
					"g.grado",
					"g.gradoid",
					"n.nivelid",
					"s.semestreid",
					"n.nombre nivel",
					"ac.alumnoporcicloid",
					"a.matricula",
					"a.sexo",
					"eac.estatusalumnoporcicloid"
				)->from('AppBundle:CeAlumnoporciclo', 'ac')
        ->innerJoin('ac.alumnoid', 'a')
        ->innerJoin('ac.cicloid', 'c')
        ->innerJoin('ac.gradoid','g')
        ->innerJoin('ac.estatusalumnocicloid','eac')
        ->innerJoin('g.nivelid','n')
        ->leftJoin('g.semestreid','s')
        ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid")
        ->leftJoin('acg.grupoid','gru')
        ->where('ac.alumnoid = ' . $filtros['alumnoid'])
        ->andWhere('c.cicloid = ' . $filtros['cicloid'])
        ->andWhere('g.gradoid = ' . $filtros['gradoid']);
        return $result->getQuery()->getResult();
    }
    
    
    public function getPagodetalle($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('p')
        ->from('AppBundle:CjPagodetalle', 'p')
        ->leftJoin("AppBundle:CjSubconceptoportaller", "sb", Expr\Join::WITH, "sb.subconceptoid = p.subconceptoid")
        ->leftJoin('sb.subconceptoid','s')
        ->leftJoin('p.pagoid','pp')
        //->leftJoin("AppBundle:CjPago", "pp", Expr\Join::WITH, "pp.pagoid = p.pagoid")
        ->leftJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = pp.alumnoid")
        ->leftJoin('ac.cicloid', 'c')
        ->groupBy('pp.pagoid,sb.subconceptoid');

        if($filtros['alumnoid']){
            $result->where('ac.alumnoid = :alumnoid')
            ->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if($filtros['cicloid']){
            $result->andWhere('c.cicloid = :cicloid')
            ->setParameter('cicloid', $filtros['cicloid']);
        }
        if($filtros['subconceptoid']){
            $result->andWhere('s.subconceptoid = :subconceptoid')
            ->setParameter('subconceptoid', $filtros['subconceptoid']);
        }
        $sql = $result->getQuery()->getSQL();
        return $result->getQuery()->getResult();
    }

    public function getTalleresExtracurricularesPorGrado($gradoid, $ciclo){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.nombre ciclo, c.cicloid,te.nombre taller, te.tallerextracurricularid, concat(p.nombre,' ',p.apellidopaterno,' ',p.apellidomaterno) profesornombre, p.profesorid,te.activo,te.descripcion,l.nombre lugar, case when sn.importe is not null then sn.importe else s.importe end costo, r.tallerextrareglamentoid, g.gradoid, s.subconceptoid, te.cupo, te.cupomaxmasculino, te.cupomaxfemenino")
        ->from('AppBundle:CeGradoportallerextracurricular', 'gpt')
        ->innerJoin('gpt.gradoid','g')
        ->innerJoin('g.nivelid','n')
        ->innerJoin('gpt.tallerextracurricularid','te')
        ->innerJoin('te.reglamentoid','r')
        ->innerJoin("AppBundle:CjSubconceptoportaller", "st", Expr\Join::WITH, "st.tallerextracurricularid = te.tallerextracurricularid")
        ->innerJoin('st.subconceptoid','s')
        ->leftJoin("AppBundle:CjSubconceptopornivel", "sn", Expr\Join::WITH, "sn.subconceptoid = s.subconceptoid and sn.nivelid = n.nivelid")
        ->leftJoin('te.profesorid','p')
        ->innerJoin('te.lugarid','l')
        ->innerJoin('te.cicloid','c')
        ->where('g.gradoid = ' . $gradoid)
        ->AndWhere('te.cicloid = ' . $ciclo)
        ->andWhere('te.activo = 1')
        ->groupBy('te.tallerextracurricularid');
        return $result->getQuery()->getResult();
    }

    public function BuscarCicloGradoAlumno($id) 
    {
        try 
        {
            $conn = $this->em->getConnection();
            $stmt = $conn->prepare("select ac.alumnoporcicloid, ac.cicloid, ac.gradoid, 
            concat_ws(' ', a.primernombre, a.apellidopaterno, a.apellidomaterno) as nombrecompleto
            from ce_alumnoporciclo ac 
            inner join ce_alumno a on a.alumnoid = ac.alumnoid
            where ac.alumnoid = :id and ac.estatusalumnocicloid != 3 order by ac.cicloid desc limit 1");
            $stmt->execute(array('id' => $id));
            $result = $stmt->fetchAll(); 
            return $result;          
        } 
        catch (Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
		
		public function deletePeriodosInscripcionExtra(){
			try{
				$qb=$this->em->createQueryBuilder();
				$qb->delete("AppBundle:CeTallerextraperiodoinscripcion")->getQuery()->execute();
				return true;
			}catch(Exception $e){ return false; }
		}

}
