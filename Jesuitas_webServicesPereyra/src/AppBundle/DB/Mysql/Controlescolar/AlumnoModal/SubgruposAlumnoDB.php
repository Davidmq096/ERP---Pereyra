<?php

namespace AppBundle\DB\Mysql\Controlescolar\AlumnoModal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asignacion materia
 *
 * @author Gabriel, Rubén
 */
class SubgruposAlumnoDB extends BaseDBManager 
{
    public function GetDatosAlumno($id) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.nombre as ciclo, c.cicloid, n.nivelid, n.nombre as nivel, CASE WHEN g.gradoid = 19 then 0 else g.gradoid as ordengrado, g.gradoid, g.grado, ac.alumnoporcicloid, gr.grupoid, gr.nombre as grupo, eac.nombre as estatusalumnociclo, 
        CASE WHEN ac.estatusalumnocicloid <> 3 THEN '' ELSE mb.nombre END as motivobaja, 
        CASE WHEN ac.estatusalumnocicloid <> 3 THEN '' ELSE tb.nombre END as tipobaja")
        ->from("AppBundle:CeAlumnoporciclo","ac")
        ->leftJoin("AppBundle:CeEstatusalumnoporciclo", "eac", Expr\Join::WITH, "eac.estatusalumnoporcicloid = ac.estatusalumnocicloid")
        ->leftJoin("AppBundle:CeMotivobaja", "mb", Expr\Join::WITH, "mb.motivobajaid = ac.motivobajaid")
        ->leftJoin("AppBundle:CeTipobaja", "tb", Expr\Join::WITH, "tb.tipobajaid = mb.tipobajaid")
        ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = ac.alumnoid")
        ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid")
        ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "gr.grupoid = acg.grupoid")
        ->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid = ac.cicloid")
        ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid = ac.gradoid")
        ->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid = g.nivelid");
        $result->andWhere('a.alumnoid = '.$id);
        $result->andWhere('c.siguiente = 0');
        $result->groupBy('ac.alumnoporcicloid');
        $result->orderBy('ordengrado','asc');
        return $result->getQuery()->getResult();
    }

    public function GetSubgruposByAlumno($id) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("
            gr.nombre as grupo,
            concat_ws(' ', cep.apellidopaterno, cep.apellidomaterno, cep.nombre) as profesor,
            acg.numerolista,
            m.nombre as materia"
        )
        ->from("AppBundle:CeAlumnoporciclo","ac")
        ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = ac.alumnoid")
        ->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid = ac.cicloid")
        ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid = ac.gradoid")
        ->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid = g.nivelid")
        ->innerJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid")
        ->innerJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "gr.grupoid = acg.grupoid and gr.tipogrupoid = 2")
        ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe", Expr\Join::WITH, "pmpe.grupoid = gr.grupoid")
        ->innerJoin("AppBundle:CeProfesor", "cep", "WITH", "cep.profesorid=pmpe.profesorid")
        ->innerJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid = pmpe.materiaid");
        $result->andWhere('ac.alumnoporcicloid = '.$id);
        return $result->getQuery()->getResult();
    }



	public function getMateriaTalleresByAlumnociclo($entidadid){
		try{			
			$qbTaller=$this->em->createQueryBuilder();
			$qbTaller->select(
					"tc.tallercurricularid",
					"tc.nombre as taller",
                    "ceact.numerolista",
                    "concat_ws(' ', cep.apellidopaterno, cep.apellidomaterno, cep.nombre) as profesor",
                    "m.nombre as materia",
                    "ing.nombre as idiomanivel"
				)->from("AppBundle:CeAlumnoporciclo", "ceac")
				->innerJoin("AppBundle:CeAlumnocicloporgrupo", "ceacgu", "WITH", "ceacgu.alumnoporcicloid=ceac.alumnoporcicloid")
				->innerJoin("AppBundle:CeGrupo", "cegu", "WITH", "cegu.grupoid=ceacgu.grupoid")
				->innerJoin("AppBundle:Grado", "ga", "WITH", "ga.gradoid=cegu.gradoid")
				->innerJoin("AppBundle:CeAlumnocicloportaller", "ceact", "WITH", "ceact.alumnoporcicloid=ceac.alumnoporcicloid AND ceact.vigente=1")
                ->innerJoin("AppBundle:CeTallercurricular", "tc", "WITH", "tc.tallercurricularid =ceact.tallercurricularid")
                ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "cepmpe", "WITH", "cepmpe.tallerid=ceact.tallercurricularid")
				->innerJoin("AppBundle:CeProfesor", "cep", "WITH", "cep.profesorid=cepmpe.profesorid")
                ->innerJoin("AppBundle:CeGradoportallercurricular", "cegtc", "WITH", "cegtc.tallercurricularid=cepmpe.tallerid AND cegtc.gradoid=ga.gradoid")
                ->leftJoin("AppBundle:CeIdiomanivel", "ing", "WITH", "ing.idiomanivelid=cegtc.idiomanivelid")
				->innerJoin("AppBundle:CeMateriaporplanestudios", "cempe", "WITH", "cempe.materiaporplanestudioid=cegtc.materiaporplanestudioid")
                ->innerJoin("AppBundle:Materia", "m", "WITH", "m.materiaid=cempe.materiaid")
                ->innerJoin("AppBundle:CePlanestudios", "cepe", "WITH", "cepe.planestudioid=cempe.planestudioid AND ((cegu.areaespecializacionid IS NULL AND cepe.areaespecializacionid IS NULL) OR (cepe.areaespecializacionid=cegu.areaespecializacionid))")
				->innerJoin("AppBundle:CeComponentecurricular", "cecc", "WITH", "cecc.componentecurricularid=cempe.componentecurricularid")
				->innerJoin("AppBundle:CeTipocalificacion", "cetc", "WITH", "cetc.tipocalificacionid=cecc.tipocalificacionid")
				->groupBy("cempe.materiaporplanestudioid")
			;

			$qbTaller->andWhere("ceac.alumnoporcicloid=:alumnociclo")->setParameter("alumnociclo", $entidadid);

			$dataTaller=$qbTaller->getQuery()->getResult();
			return $dataTaller;
		}catch(\Exception $e){
			return false; 
		}
	}
}
