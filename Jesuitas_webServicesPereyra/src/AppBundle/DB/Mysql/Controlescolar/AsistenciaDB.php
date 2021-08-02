<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asistencia
 *
 * @author Mariano
 */
class AsistenciaDB extends BaseDBManager
{
    public function BuscarPermisoProfesor($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p.nombre")
            ->from("AppBundle:Permiso", 'p')
            ->innerJoin("AppBundle:Permisoporpantalla", "pp", Expr\Join::WITH, "pp.permisoid=p.permisoid")
            ->leftJoin("AppBundle:Permisoporusuario", "pu", Expr\Join::WITH, "pu.permisoporpantallaid=pp.permisoporpantallaid")
            ->leftJoin("AppBundle:Permisoporperfil", "ppp", Expr\Join::WITH, "ppp.permisoporpantallaid=pp.permisoporpantallaid")
            ->leftJoin("AppBundle:Usuarioporperfil", "upp", Expr\Join::WITH, "upp.perfilid = ppp.perfilid and upp.usuarioid=".$filtros["usuarioid"])
            ->leftJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.usuarioid=pu.usuarioid or u.usuarioid=upp.usuarioid")
            ;

            $result->andWhere('pp.pantallaid=:pantallaid and p.identificador=:identificador and u.usuarioid=:usuarioid')
                ->setParameter('pantallaid', 102)
                ->setParameter('identificador', 'profesor')
                ->setParameter('usuarioid', $filtros['usuarioid']);
        return $result->getQuery()->getResult();
    }
    
    public function getAsistenciaProfesor($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("case when mpe.materiaporplanestudioid is not null then mpe.materiaporplanestudioid else mpee.materiaporplanestudioid end as materiaporplanestudioid, case when mpe.materiaporplanestudioid is not null then mpe.horasporsemana else mpee.horasporsemana end as horasporsemana")
        ->from('AppBundle:CeProfesorpormateriaplanestudios', 'pmpe')
        ->leftJoin("pmpe.grupoid", "gru")
        ->leftJoin("pmpe.materiaporplanestudioid", 'mpe')
        ->leftJoin("mpe.materiaid", "m")
        ->leftJoin("pmpe.materiaid", "mm")
        ->leftJoin("pmpe.tallerid", "tc")
        ->leftJoin("AppBundle:CeGradoportallercurricular", "gpt", Expr\Join::WITH, "gpt.tallercurricularid=tc.tallercurricularid")
        ->leftJoin("gpt.materiaporplanestudioid", 'mpee')
        ->leftJoin("mpee.materiaid", "mtc")
        ->leftJoin("pmpe.profesorid", "p");
        $result->andWhere('pmpe.profesorpormateriaplanestudiosid = :profesorpormateriaplanestudiosid')
        ->setParameter('profesorpormateriaplanestudiosid', $filtros['profesorpormateriaplanestudiosid']);

        if($filtros['gradoid']){
            $result->andWhere('gpt.gradoid = :gradoid')
            ->setParameter('gradoid', $filtros['gradoid']);
        }
                     
        return $result->getQuery()->getResult();
    }



    public function BuscarAsistencias($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("s.asistenciaid,ac.alumnoporcicloid, case when acg.grupoid is not null then acg.numerolista else act.numerolista end numerolista, a.matricula, Concat_WS(' ',  a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) nombrealumno, 
        CONCAT_WS(' ',DATE_FORMAT(s.fecha, '%d/%m/%Y'), DATE_FORMAT(s.hora,'%H:%i')) as fecha, ta.tipoasistenciaid,ei.estatusinasistenciaid, act.vigente,tc.tallercurricularid, acg.alumnocicloporgrupo, act.alumnocicloportallerid, nn.nivelid")
        ->from('AppBundle:CeAsistencia', 's')
        ->innerJoin('s.profesorpormateriaplanestudioid', 'pmpe')
		->innerJoin('s.alumnoporcicloid', 'ac')
		->innerJoin('ac.estatusalumnocicloid', 'eac')
        ->innerJoin('ac.gradoid', 'gra')
        ->innerJoin('gra.nivelid', 'nn')
		->innerJoin("ac.alumnoid", "a")
		->innerJoin('a.alumnoestatusid', 'ea')
        ->leftJoin("pmpe.grupoid", "gru")
        ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "ac.alumnoporcicloid = acg.alumnoporcicloid and gru.grupoid = acg.grupoid")
        ->leftJoin("pmpe.tallerid", "tc")
        ->leftJoin("AppBundle:CeAlumnocicloportaller", "act", Expr\Join::WITH, "ac.alumnoporcicloid = act.alumnoporcicloid and  act.tallercurricularid = tc.tallercurricularid")
        ->leftJoin("AppBundle:CeAlumnociclofoto", "acf", Expr\Join::WITH, "acf.alumnoporcicloid = ac.alumnoporcicloid")
        ->leftJoin("s.tipoasistenciaid", 'ta')
        ->leftJoin("s.estatusinasistenciaid", 'ei')
        ->orderBy("acg.numerolista,act.numerolista, a.apellidopaterno", "ASC")
        ->groupBy('a.alumnoid, s.fecha , s.hora');
        $result->andWhere("s.fecha between :f1 and :f2")
        ->setParameters([
            'f1' => $filtros['fechainicio'],
            'f2' => $filtros['fechafin'],
        ]);
        $result->andWhere('pmpe.profesorpormateriaplanestudiosid = :profesorpormateriaplanestudiosid')
		->setParameter('profesorpormateriaplanestudiosid', $filtros['profesorpormateriaplanestudiosid']);
		
		$result->andWhere("ea.alumnoestatusid = 1 and eac.estatusalumnoporcicloid in (1,2)");
        return $result->getQuery()->getResult();
	}
	
	public function getProfesoresplanestudiosByAlumno($alumnocicloid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pmpe.profesorpormateriaplanestudiosid, mpe.materiaporplanestudioid, m.nombre as materia")
			->from("AppBundle:CeMateriaporplanestudios", "mpe")
			->innerJoin("AppBundle:Materia", "m", Expr\Join::WITH, "m.materiaid = mpe.materiaid")
			->leftJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe", Expr\Join::WITH, "pmpe.materiaporplanestudioid = mpe.materiaporplanestudioid")
			->innerJoin("AppBundle:CeGrupo", "g", Expr\Join::WITH, "g.grupoid = pmpe.grupoid")
			->leftJoin("AppBundle:CeTallercurricular", "t", Expr\Join::WITH, "t.tallercurricularid = pmpe.tallerid")
			->leftJoin("AppBundle:CeAlumnocicloportaller", "act", Expr\Join::WITH, "act.tallercurricularid = t.tallercurricularid")
			->innerJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.grupoid = g.grupoid")
            ->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoporcicloid = acg.alumnoporcicloid or ac.alumnoporcicloid = act.alumnoporcicloid")
            ->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid = ac.cicloid")
            ->where('ac.alumnoporcicloid = ' . $alumnocicloid);
        return $result->getQuery()->getResult();
    }    

	public function BuscarInasistencias($filtros){
		$qb = $this->em->createQueryBuilder();
		$result = $qb->select("s.asistenciaid",
				"a.matricula",
				"a.primernombre",
				"a.segundonombre",
				"a.apellidopaterno",
				"a.apellidomaterno",
				"g.grado",
				"tcempe.materiaporplanestudioid",
				"CASE
					WHEN cetc.tallercurricularid IS NOT NULL THEN cetc.nombre
					ELSE gru.nombre
				END AS grupo",
				"gru.grupoid",
				"DATE_FORMAT(s.fecha, '%Y-%m-%d') AS date",
				"DATE_FORMAT(s.fecha, '%d/%m/%Y') AS fecha",
				"DATE_FORMAT(s.hora,'%H:%i') AS hora",
				"CASE
					WHEN tm.materiaid IS NOT NULL THEN tm.nombre
					ELSE CASE
						WHEN sm.materiaid IS NOT NULL THEN sm.nombre
						ELSE m.nombre
					END
				END AS materia",
				"p.nombre AS nombreprofesor",
				"p.apellidopaterno AS apellidoprofesor",
				"ta.descripcion AS tipoinasitencia",
				"ei.descripcion AS estatusinasitencia",
				"per.nombre AS nombremodifico",
				"per.apellidopaterno AS apellidomodifico",
				"s.motivocancelacioninasistencia",
				"u.usuarioid",
				"DATE_FORMAT(s.fechamodificacion, '%d/%m/%Y %H:%i') AS fechamodificacion",
				"ei.estatusinasistenciaid"
			)->from("AppBundle:CeAsistencia", 's')
			->innerJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoporcicloid=s.alumnoporcicloid")
			->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid=ac.alumnoid")
			->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid = ac.gradoid")
			->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid=g.nivelid")
			->innerJoin("AppBundle:CeTipoasistencia", "ta", Expr\Join::WITH, "ta.tipoasistenciaid=s.tipoasistenciaid")
			->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe", Expr\Join::WITH, "pmpe.profesorpormateriaplanestudiosid=s.profesorpormateriaplanestudioid")
			->leftJoin("AppBundle:CeProfesor", "p", Expr\Join::WITH, "p.profesorid=pmpe.profesorid")

			->leftJoin("AppBundle:CeEstatusinasistencia", "ei", Expr\Join::WITH, "ei.estatusinasistenciaid=s.estatusinasistenciaid")
			->leftJoin("AppBundle:Usuario", "u", Expr\Join::WITH, "u.usuarioid=s.usuarioid")
			->leftJoin("AppBundle:Persona", "per", Expr\Join::WITH, "per.personaid=u.personaid")

			->leftJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid")
			->leftJoin("AppBundle:CeGrupo", "gru", Expr\Join::WITH, "gru.grupoid=acg.grupoid")
			->leftJoin("AppBundle:CeSemestre", "se", Expr\Join::WITH, "se.semestreid=g.semestreid")

			->leftJoin("AppBundle:CeTallercurricular", "cetc", Expr\Join::WITH, "cetc.tallercurricularid=pmpe.tallerid")
			->leftJoin("AppBundle:CeGradoportallercurricular", "cegtc", Expr\Join::WITH, "cegtc.tallercurricularid=cetc.tallercurricularid AND cegtc.gradoid=g.gradoid")
			->leftJoin("AppBundle:CeMateriaporplanestudios", "tcempe", Expr\Join::WITH, "tcempe.materiaporplanestudioid=cegtc.materiaporplanestudioid")
			->leftJoin("AppBundle:Materia", "tm", Expr\Join::WITH, "tm.materiaid=tcempe.materiaid")//Materia taller

			->leftJoin("AppBundle:CeMateriaporplanestudios", "scempe", Expr\Join::WITH, "pmpe.tallerid IS NULL AND scempe.materiaporplanestudioid=pmpe.materiaporplanestudioid")
			->leftJoin("AppBundle:Materia", "sm", Expr\Join::WITH, "sm.materiaid=scempe.materiaid")//Materia submateria

			->leftJoin("pmpe.materiaid", "m")//Materia normal
		;
		if(isset($filtros['materiaporplanestudioid'])){
			$result->andWhere('mpe.materiaporplanestudioid = :materiaporplanestudioid')
				->setParameter('materiaporplanestudioid', $filtros['materiaporplanestudioid']);
		}
		if(isset($filtros['alumnoid'])){
			$result->andWhere('a.alumnoid in (:alumnoid)')
				->setParameter('alumnoid', $filtros['alumnoid']);
		}
		if(isset($filtros['matricula'])){
			$result->andWhere('a.matricula = :matricula')
				->setParameter('matricula', $filtros['matricula']);
		}
		if(isset($filtros['apellidopaterno'])){
			$result->andWhere('a.apellidopaterno like :apellidopaterno')
				->setParameter('apellidopaterno', '%'.$filtros['apellidopaterno'].'%');
		}
		if(isset($filtros['apellidomaterno'])){
			$result->andWhere('a.apellidomaterno like :apellidomaterno')
				->setParameter('apellidomaterno', '%'.$filtros['apellidomaterno'].'%');
		}
		if(isset($filtros['nombre'])){
			$result->andWhere('a.primernombre like :nombre')
				->setParameter('nombre', '%'.$filtros['nombre'].'%');
		}
		if(isset($filtros['cicloid'])){
			$result->andWhere('ac.cicloid = :cicloid')
				->setParameter('cicloid', $filtros['cicloid']);
		}
		if(count($filtros['nivelid']) > 0){
			$result->andWhere('n.nivelid in (:nivelid)')
				->setParameter('nivelid', $filtros['nivelid']);
		}
		if(count($filtros['gradoid']) > 0){
			$result->andWhere('g.gradoid in (:gradoid)')
				->setParameter('gradoid', $filtros['gradoid']);
		}
		if(isset($filtros['semestreid'])){
			$result->andWhere('se.semestreid = :semestreid')
				->setParameter('semestreid', $filtros['semestreid']);
		}
		if($filtros['alumnoporcicloid']){
			$result->andWhere('ac.alumnoporcicloid = :alumnoporcicloid')
				->setParameter('alumnoporcicloid', $filtros['alumnoporcicloid']);
		}
		if(isset($filtros['grupoid'])){
			$result->andWhere('gru.grupoid = :grupoid')
				->setParameter('grupoid', $filtros['grupoid']);
		}
		if(isset($filtros['fecha'])){
            $fecha = new \Datetime($filtros['date']);
			$result->andWhere('s.fecha = :fecha')
				->setParameter('fecha', $fecha);
		}
		if(isset($filtros['fechainicio'])){
			$result->andWhere("s.fecha between :f1 and :f2")
			->setParameter('f1', $filtros['fechainicio'])
			->setParameter('f2', $filtros['fechafin']);
		}
		if(isset($filtros['materiaid'])){
			$result->andWhere('m.materiaid=:materia OR tm.materiaid=:materia OR sm.materiaid=:materia')
				->setParameter('materia', $filtros['materiaid']);
		}
		if(isset($filtros['estatusinasistenciaid'])){
			$result->andWhere('s.estatusinasistenciaid = :estatusinasistenciaid')
				->setParameter('estatusinasistenciaid', $filtros['estatusinasistenciaid']);
		}else{
			//$result->andWhere('s.estatusinasistenciaid <>2 or s.estatusinasistenciaid is null');
		}
		$result->andWhere('s.tipoasistenciaid IN (:tiposasistenciaid)')
			->setParameter("tiposasistenciaid",(isset($filtros['tipoasistenciaid'])
				? $filtros['tipoasistenciaid']
				: [2,3, 4])
			)
		;

		$result->groupBy('a.alumnoid, s.fecha , s.hora');
		$result->orderBy("gru.nombre");

		return $result->getQuery()->getResult();
	}

	public function GetAsistenciasDetail($ids) {
        $qb = $this->em->createQueryBuilder();
		$result = $qb->select("
		SUM(CASE WHEN ta.tipoasistenciaid = 1 then 1 else 0 end) as tas,
		SUM(CASE WHEN ta.tipoasistenciaid = 2 then 1 else 0 end) as tis,
		SUM(CASE WHEN ta.tipoasistenciaid = 3 then 1 else 0 end) as trs,
  		SUM(CASE WHEN ta.tipoasistenciaid IN(1,2,3) AND ta.estatusinasistenciaid = 3 then 1 else 0 end) as tjs,
  		SUM(CASE WHEN ta.tipoasistenciaid IN(1,2,3) AND ta.estatusinasistenciaid = 2 then 1 else 0 end) as tcs
		")
        ->from("AppBundle:CeAsistencia","ta")
        ->andWhere('ta.asistenciaid IN (:ids)')
        ->setParameter('ids', $ids);
       
        return $result->getQuery()->getResult();
	}
	
	public function GetAsistenciasDiariaDetail($ids) {
        $qb = $this->em->createQueryBuilder();
		$result = $qb->select("
		SUM(CASE WHEN ta.tipoasistenciaid = 1 then 1 else 0 end) as tas,
		SUM(CASE WHEN ta.tipoasistenciaid = 2 then 1 else 0 end) as tis,
		SUM(CASE WHEN ta.tipoasistenciaid = 3 then 1 else 0 end) as trs,
  		SUM(CASE WHEN ta.tipoasistenciaid IN(1,2,3) AND ta.estatusinasistenciaid = 3 then 1 else 0 end) as tjs,
		SUM(CASE WHEN ta.tipoasistenciaid IN(1,2,3) AND ta.estatusinasistenciaid = 2 then 1 else 0 end) as tcs,
		SUM(CASE WHEN ta.tipoasistenciaid = 4 then 1 else 0 end) as ts
		")
        ->from("AppBundle:CeAsistenciapordia","ta")
        ->andWhere('ta.asistenciapordiaid IN (:ids)')
        ->setParameter('ids', $ids);
       
        return $result->getQuery()->getResult();
    }
}