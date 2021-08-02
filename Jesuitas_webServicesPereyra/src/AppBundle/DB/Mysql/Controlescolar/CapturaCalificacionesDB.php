<?php

namespace AppBundle\DB\Mysql\Controlescolar;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asignacion materia
 *
 * @author Gabriel
 */
class CapturaCalificacionesDB extends BaseDBManager
{

		public function getRoundedValueByFunctionName($fnName, $value){
			if(is_nan($value) || is_infinite($value)){
				trigger_error("CapturaCalificacionesDB->getRoundedValueByFunctionName: Can't process NaN nor Infinite values.", E_USER_WARNING);
				return 0;
			}
			if($fnName== "[valor]"){
				return $value;
			}
			$sql="SELECT $fnName($value) AS result";
			try{
				$stmt=$this->em->getConnection()->prepare($sql);
				$stmt->execute();
				$data=$stmt->fetchColumn();
				return $data;
			}catch(\Exception $e){
				echo ">> CapturaCalificacionesDB->getRoundedValueByFunctionName: ".$e->getMessage()."\n";
			}
		}
		//Obtiene los alumnos ya sea del grupo/subgrupo/taller
    public function AlumnoCicloGrupo($cicloid, $grupoid, $alumnoid, $taller = false, $activeOverride = false)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, a.alumnoid as IDAlumno, a.matricula as Matricula, c.alumnoporcicloid, a.matricula,
         CONCAT_WS(' ', a.apellidopaterno,a.apellidomaterno,a.primernombre, a.segundonombre ) NombreAlumno,
         CONCAT_WS(' ', a.apellidopaterno,a.apellidomaterno,a.primernombre, a.segundonombre ) nombre, g.numerolista,
         IDENTITY(c.estatusalumnocicloid) estatusalumnocicloid
         ")
            ->from("AppBundle:CeAlumno", "a")
            ->innerJoin("AppBundle:CeAlumnoporciclo", "c", Expr\Join::WITH, "c.alumnoid = a.alumnoid");

        if ($taller) {
            $result->innerJoin("AppBundle:CeAlumnocicloportaller", "g", Expr\Join::WITH, "g.alumnoporcicloid = c.alumnoporcicloid")
                ->andWhere('g.tallercurricularid = :grupoid')
                ->andWhere('g.vigente=1');
        } else {
            $result->innerJoin("AppBundle:CeAlumnocicloporgrupo", "g", Expr\Join::WITH, "g.alumnoporcicloid = c.alumnoporcicloid")
                ->andWhere('g.grupoid = :grupoid');
        }

        $result->andWhere('c.cicloid = :cicloid')
            ->setParameter("cicloid", $cicloid)
            ->setParameter("grupoid", $grupoid)
            ->orderBy('g.numerolista');
				if(!$activeOverride){
					$result->andWhere('a.alumnoestatusid = 1');
				}
        if ($alumnoid) {
            $result->andWhere('a.alumnoid = :alumnoid')
                ->setParameter("alumnoid", $alumnoid);
        }
        return $result->getQuery()->getResult();
    }

    /*
     * Obtiene el encabezado de la captura de calificaciones
     */
    public function GetDatoGrupoCalificacion($periodoevaluacionid, $profesorpormateriaplanestudiosid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p.profesorpormateriaplanestudiosid, gra.grado, ni.nombre as nivel,
        CASE WHEN mg.materiaid IS NOT NULL THEN mg.nombre ELSE GROUPCONCAT(DISTINCT mt.nombre SEPARATOR ', ') END materia, 
        CASE WHEN mg.materiaid IS NOT NULL THEN mg.materiaid ELSE GROUPCONCAT(DISTINCT mt.materiaid SEPARATOR ',') END materiaid,
        GROUPCONCAT(DISTINCT pl.planestudioid SEPARATOR ', ') planestudioid,
        CONCAT_WS(' ', pe.nombre, pe.apellidopaterno, pe.apellidomaterno)  maestro,
        CASE WHEN g.grupoid IS NOT NULL THEN g.nombre ELSE t.nombre END grupo,

        CASE  
        WHEN CURRENT_DATE() >= pev.fechacapturacalinicio and CURRENT_DATE() < pev.fechaperiodorevisioninicio then DATE_FORMAT(pev.fechacapturacalfin, '%d/%m/%Y')
        WHEN CURRENT_DATE() >= pev.fechaperiodorevisioninicio  then DATE_FORMAT(pev.fechaperiodorevisionfin, '%d/%m/%Y')
        else :NULL
        END as fechacapturacalfin, 
        case  when CURRENT_DATE() between pev.fechacapturacalinicio and pev.fechacapturacalfin then '1'
        when CURRENT_DATE() between pev.fechaperiodorevisioninicio and pev.fechaperiodorevisionfin then '1'
        else '0'
        end as fechavalidacion, 

        DATE_FORMAT(CURRENT_DATE(), '%d/%m/%Y') as fechahoy,
        pev.descripcion periodo, DATE_FORMAT(pev.fechacapturacalinicio, '%d/%m/%Y') as fechacapturacalinicio
        ");
        $result->from("AppBundle:CeProfesorpormateriaplanestudios", "p")


            ->innerJoin("p.profesorid", "pe")
            ->leftJoin("p.grupoid", "g")
            ->leftJoin("g.gradoid", "gra")
            ->leftJoin("gra.nivelid", "ni")
            ->leftJoin("p.materiaporplanestudioid", "mpg")
            ->leftJoin("mpg.materiaid", "mg")

            ->leftJoin("p.tallerid", "t")
            ->leftJoin("AppBundle:CeGradoportallercurricular", "tc", Expr\Join::WITH, "t.tallercurricularid = tc.tallercurricularid")
            ->leftJoin("AppBundle:CeMateriaporplanestudios", "mpt", Expr\Join::WITH, "mpt.materiaporplanestudioid = tc.materiaporplanestudioid")
            ->leftJoin("mpt.materiaid", "mt")

            ->leftJoin("AppBundle:CePlanestudios", "pl", Expr\Join::WITH, "mpg.planestudioid = pl.planestudioid or mpt.planestudioid = pl.planestudioid")

            ->from("AppBundle:CePeriodoevaluacion", "pev")
            ->andWhere('p.profesorpormateriaplanestudiosid = :profesorpormateriaplanestudiosid')
            ->setParameter("profesorpormateriaplanestudiosid", $profesorpormateriaplanestudiosid)
            ->andWhere('pev.periodoevaluacionid = :periodoevaluacionid')
            ->setParameter("periodoevaluacionid", $periodoevaluacionid)
            ->setParameter("NULL", null)
            ->groupBy("p.profesorpormateriaplanestudiosid");


        return $result->getQuery()->getResult();
    }

    /*
     * Obtiene los criterios a evaluar
     */
    public function CriteriosEvaluacionGrupo($periodoid, $profesorpormateriaplanestudiosid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ceg.criterioevaluaciongrupoid",
							"ceg.aspecto",
							"ceg.descripcion",
							"ceg.porcentajecalificacion",
							"ceg.capturas",
							"ceg.puntajemaximo",
							"ceg.configurartarea"
						)->from("AppBundle:CeCriterioevaluaciongrupo", "ceg")
            ->innerJoin("ceg.profesorpormateriaplanestudiosid", "pmpe")
            ->andWhere('pmpe.profesorpormateriaplanestudiosid = :profesorpormateriaplanestudiosid')
            ->setParameter("profesorpormateriaplanestudiosid",  $profesorpormateriaplanestudiosid)
            ->andWhere('ceg.periodoevaluacionid = :periodoevaluacionid')
            ->setParameter("periodoevaluacionid", $periodoid)
            ->andWhere('ceg.capturas > 0');
        return $result->getQuery()->getResult();
    }


    /*
     * Obtiene la calificacion del periodo
     */
    public function CalculaCalificacionPeriodo($calificacionperiodoporalumno)
    {
        $qb = $this->em->getConnection();
        $sql = "SELECT ceg.criterioevaluaciongrupoid,ceg.aspecto,ceg.porcentajecalificacion,ceg.capturas,ceg.puntajemaximo,((((((sum(calificacion/capturas)*capturas))/(capturas*puntajemaximo))*100)*(porcentajecalificacion/100))/10)  as calificacion
        FROM ce_capturacalificacionporalumno cca
        inner join ce_criterioevaluaciongrupo ceg on ceg.criterioevaluaciongrupoid= cca.criterioevaluaciongrupoid
        where  NumeroCaptura <= capturas AND cca.calificacionperiodoporalumnoid = :calificacionperiodoporalumnoid AND ceg.profesorpormateriaplanestudiosid = :profesorpormateriaplanestudiosid
        group by ceg.criterioevaluaciongrupoid";

        $stmt = $qb->prepare($sql);
        $stmt->execute(array(
            'calificacionperiodoporalumnoid' => $calificacionperiodoporalumno->getCalificacionperiodoporalumnoid(),
            'profesorpormateriaplanestudiosid' => $calificacionperiodoporalumno->getProfesorpormateriaplanestudioid()->getProfesorpormateriaplanestudiosid() 
        ));
        $criterios = $stmt->fetchAll();

        return $criterios;
    }














    /*
     * Obtiene el ultimo periodo de un conjunto de periodos de evaluacion
     */
    public function GetUltimoPeriodo($conjuntoperiodoevaluacionid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pe")
            ->from("AppBundle:CePeriodoevaluacion", "pe")
            ->andWhere('pe.conjuntoperiodoevaluacionid = :conjuntoperiodoevaluacionid')
            ->setParameter("conjuntoperiodoevaluacionid", $conjuntoperiodoevaluacionid)
            ->orderBy("pe.fechafin", "desc");
        return $result->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }





    public function BuscarPeriodoPorCicloGrado($cicloid, $gradoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p")
            ->from("AppBundle:CePeriodoevaluacion", "p")
            ->innerJoin("AppBundle:CeConjuntoperiodoevaluacion", "c", Expr\Join::WITH, "c.conjuntoperiodoevaluacionid = p.conjuntoperiodoevaluacionid")
            ->innerJoin("AppBundle:CeGradoporconjuntoperiodoescolar", "g", Expr\Join::WITH, "g.conjuntoperiodoevaluacionid = c.conjuntoperiodoevaluacionid");
        $result->andWhere('c.cicloid = ' . $cicloid);
        $result->andWhere('g.gradoid = ' . $gradoid);

        return $result->getQuery()->getResult();
    }




    public function CapturaCalificacionDatos($id)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("cca.capturacalificacionporalumnoid, cca.numerocaptura, cca.calificacion, cp.calificacionperiodoporalumnoid, ce.criterioevaluaciongrupoid")
            ->from("AppBundle:CeCapturacalificacionporalumno", "cca")
            ->innerJoin("AppBundle:CeCalificacionperiodoporalumno", "cp", Expr\Join::WITH, "cp.calificacionperiodoporalumnoid = cca.calificacionperiodoporalumnoid")
            ->innerJoin("AppBundle:CeCriterioevaluaciongrupo", "ce", Expr\Join::WITH, "ce.criterioevaluaciongrupoid = cca.criterioevaluaciongrupoid");

        $result->andWhere('cca.capturacalificacionporalumnoid = ' . $id);

        return $result->getQuery()->getResult();
    }

    public function getDatosCalificarTarea($tarealumnoid, $materiaid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ca.capturacalificacionporalumnoid,cp.calificacionperiodoporalumnoid,cpf.calificacionfinalperiodoporalumnoid")

            ->from("AppBundle:CeTareaalumno", "ta")
            ->innerJoin("ta.tareaid", "t")

            ->innerJoin("AppBundle:CeCapturacalificacionporalumno", "ca", Expr\Join::WITH, "ca.numerocaptura = t.captura and ca.criterioevaluaciongrupoid = t.criterioevaluaciongrupoid")
            ->innerJoin("AppBundle:CeCalificacionperiodoporalumno", "cp", Expr\Join::WITH, "cp.calificacionperiodoporalumnoid = ca.calificacionperiodoporalumnoid")
            ->innerJoin("AppBundle:CeCalificacionfinalperiodoporalumno", "cpf", Expr\Join::WITH, "cpf.calificacionfinalperiodoporalumnoid = cp.calificacionfinalporperiodoalumno");

        $result->andWhere('ta.tareaalumnoid = ' . $tarealumnoid);
        $result->andWhere('cp.alumnoid = ta.alumnoid');

        if ($materiaid) {
            $result->andWhere('cp.materiaid = ' . $materiaid);
        }

        return $result->getQuery()->getResult();
    }



    public function getRoundFunctionNameByMateriaplanestudio($materiaplanestudioid)
    {
        try {
            $qb = $this->em->createQueryBuilder();
            $qb->select(
                "cetr_p.funcionredondeo AS criterio",
                "cetr_f.funcionredondeo AS materia",
                "cetr_t.funcionredondeo AS final"
            )->from("AppBundle:CeMateriaporplanestudios", "cempe")
                ->innerJoin("AppBundle:CePlanestudios", "cepe", Expr\Join::WITH, "cepe.planestudioid=cempe.planestudioid")
                ->leftJoin("AppBundle:CeTiporedondeo", "cetr_p", Expr\Join::WITH, "cetr_p.tiporedondeoid=cepe.tiporedondeoperiodoid")
                ->leftJoin("AppBundle:CeTiporedondeo", "cetr_f", Expr\Join::WITH, "cetr_f.tiporedondeoid=cepe.tiporedondeofinalid")
                ->leftJoin("AppBundle:CeTiporedondeo", "cetr_t", Expr\Join::WITH, "cetr_t.tiporedondeoid=cepe.tiporedondeocalfinalid")
                ->andWhere("cempe.materiaporplanestudioid=:materiaplanestudio")
                ->setParameter("materiaplanestudio", $materiaplanestudioid);
            $data = $qb->getQuery()->getResult();
            return ($data ? $data[0] : []);
        } catch (\Exception $e) { }
        return false;
    }
    public function getOpcionesByMateriaporplanestudio($materiaplanestudioid)
    {
        try {
            $qb = $this->em->createQueryBuilder();
            $qb->select(
                "cepo.opcion",
                "cepo.descripcioncorta",
                "cepo.calificacionminima",
                "cepo.calificacionmaxima"
            )->from("AppBundle:CeMateriaporplanestudios", "cempe")
                ->innerJoin("AppBundle:CeComponentecurricular", "cecc", Expr\Join::WITH, "cecc.componentecurricularid=cempe.componentecurricularid")
                ->innerJoin("AppBundle:CePonderacionopcion", "cepo", Expr\Join::WITH, "cepo.ponderacionid=cecc.ponderacionid")
                ->andWhere("cempe.materiaporplanestudioid=:materiaplanestudio")
                //->andWhere("cecc.tipocalificacionid IN (1,2,3)")
                ->setParameter("materiaplanestudio", $materiaplanestudioid);
            $data = $qb->getQuery()->getResult();
            return $data;
        } catch (\Exception $e) { }
        return false;
    }

    public function getBitacoracalificacionesbyProfesor($filtros)
    {
        try {
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("bc.ciclo, bc.nivel, bc.grado, pmpe.profesorpormateriaplanestudiosid, bc.materia, 
                CASE WHEN g.grupoid is not null then g.nombre ELSE t.nombre as grupo,
                CASE 
                    WHEN us.personaid is not null then concat_ws(' ', per.apellidopaterno, per.apellidomaterno, per.nombre) 
                    WHEN us.profesorid is not null then concat_ws(' ', prof.apellidopaterno, prof.apellidomaterno, prof.nombre) 
                    WHEN us.alumnoid is not null then concat_ws(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre)
                ELSE '' as nombreusuario, 
                DATE_FORMAT(bc.fecha, '%d/%m/%Y') as fechaformatted,
                DATE_FORMAT(bc.fecha,'%H:%i') as hora,
                bc.criterioevaluacion, bc.numerocaptura, bc.capturaanterior, bc.capturanuevo, bc.calperiodoanterior, bc.calfinalanterior, 
                bc.calperiodonuevo, bc.calfinalnuevo, bc.opcperiodoanterior, bc.opcperiodonuevo, bc.opcfinalanterior, bc.opcfinalnuevo, 
                bc.comperiodoanterior, bc.comperiodonuevo, bc.folioedicionextemporanea, bc.alumno")
            ->from("AppBundle:CeBitacoracalificacion", "bc")
            ->leftJoin("AppBundle:CeProfesorpormateriaplanestudios", "pmpe", Expr\Join::WITH, "pmpe.profesorpormateriaplanestudiosid=bc.profesorpormateriaplanestudiosid")
            ->leftJoin("AppBundle:CeGrupo", "g", Expr\Join::WITH, "g.grupoid=pmpe.grupoid")
            ->leftJoin("AppBundle:CeTallercurricular", "t", Expr\Join::WITH, "t.tallercurricularid=pmpe.tallerid")
            ->innerJoin("bc.periodoevaluacionid", "pe")
            ->innerJoin("bc.usuarioid", "us")
            ->leftJoin("AppBundle:CeProfesor", "prof", Expr\Join::WITH, "prof.profesorid=us.profesorid")
            ->leftJoin("AppBundle:Persona", "per", Expr\Join::WITH, "per.personaid = us.personaid")
            ->leftJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = us.alumnoid")
            ->andWhere("pmpe.profesorpormateriaplanestudiosid=:profmateriaplanestudio")
            ->setParameter("profmateriaplanestudio", $filtros['profesorpormateriaplanestudiosid']);

            if( $filtros['periodoevaluacionid']) {
                $result->andWhere("pe.periodoevaluacionid=:periodoevaluacionid")
                ->setParameter("periodoevaluacionid", $filtros['periodoevaluacionid']);
            }

            if(isset($filtros['nombrealumno'])){
                $result->andWhere('bc.alumno like :nombrealumno')
                    ->setParameter('nombrealumno', '%'.$filtros['nombrealumno'].'%');
            }

            $result->groupBy('bc.bitacoracalificacionid');
            $data = $result->getQuery()->getResult();
            return $data;
        } catch (\Exception $e) { }
        return false;
    }


    public function getBitacoracalificacionesbyAlumno($filtros)
    {
        try {
            $qb = $this->em->createQueryBuilder();
            $qb->select("bcg.ciclo, bcg.nivel, bcg.grado, bcg.alumno, bcg.asistenciaanterior, bcg.asistencianuevo, bcg.comanterior, bcg.comnuevo, 
            bcg.tareasolicitadaanterior, bcg.tareasolicitadanuevo, bcg.tareaentregadaanterior, bcg.tareaentregadanuevo,
            CASE 
                WHEN us.personaid is not null then concat_ws(' ', per.apellidopaterno, per.apellidomaterno, per.nombre) 
                WHEN us.profesorid is not null then concat_ws(' ', prof.apellidopaterno, prof.apellidomaterno, prof.nombre) 
                WHEN us.alumnoid is not null then concat_ws(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre)

            ELSE '' as nombreusuario, 
            DATE_FORMAT(bcg.fecha, '%d/%m/%Y') as fechaformatted,
            DATE_FORMAT(bcg.fecha,'%H:%i') as hora
            ")
            ->from("AppBundle:CeBitacoracalificacionglobal", "bcg")
            ->leftJoin("AppBundle:CeCapturaalumnoporperiodo", "ap", Expr\Join::WITH, "ap.capturaalumnoporperiodoid = bcg.capturaalumnoporperiodoid")
            ->innerJoin("bcg.usuarioid", "us")
            ->innerJoin("bcg.periodoevaluacionid", "pe")
            ->leftJoin("AppBundle:CeProfesor", "prof", Expr\Join::WITH, "prof.profesorid=us.profesorid")
            ->leftJoin("AppBundle:Persona", "per", Expr\Join::WITH, "per.personaid = us.personaid")
            ->leftJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = us.alumnoid")
            ->andWhere("ap.capturaalumnoporperiodoid=:capturaalumnoporperiodoid")
            ->setParameter("capturaalumnoporperiodoid", $filtros['capturaalumnoporperiodoid'])
            ->andWhere("pe.periodoevaluacionid=:periodoevaluacionid")
            ->setParameter("periodoevaluacionid", $filtros['periodoevaluacionid'])
            ->groupBy('bcg.bitacoracalificacionglobalid');
            $data = $qb->getQuery()->getResult();
            return $data;
        } catch (\Exception $e) { }
        return false;
    }

    public function FaltasRetardosAlumno($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("
           CONCAT(
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 2 and ei.estatusinasistenciaid = 2 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 2 and ei.estatusinasistenciaid = 2 then 1 else 0 end)), ' FALTAS CANCELADAS', '<br>') ELSE '' END, 
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 2 and ei.estatusinasistenciaid = 3 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 2 and ei.estatusinasistenciaid = 3 then 1 else 0 end)), ' FALTAS JUSTIFICADAS', '<br>') ELSE '' END, 
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 2 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 2 then 1 else 0 end)), ' RETARDOS CANCELADOS', '<br>') ELSE '' END, 
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 3 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 3 then 1 else 0 end)), ' RETARDOS JUSTIFICADOS', '<br>') ELSE '' END
            ) AS detalle,
                SUM((CASE WHEN ta.tipoasistenciaid = 2 and ei.estatusinasistenciaid = 1 then 1 else 0 end)) as totalfaltas,
                SUM((CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 1 then 1 else 0 end)) as totalretardos
        ")
        ->from("AppBundle:CeAsistencia","a")
        ->innerJoin("AppBundle:CeTipoasistencia", 'ta', Expr\Join::WITH, "ta.tipoasistenciaid=a.tipoasistenciaid")
        ->innerJoin("AppBundle:CeEstatusinasistencia", 'ei', Expr\Join::WITH, "ei.estatusinasistenciaid=a.estatusinasistenciaid")
        ->innerJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "ac.alumnoporcicloid = a.alumnoporcicloid")
        ->innerJoin("AppBundle:CeProfesorpormateriaplanestudios", 'mpe', Expr\Join::WITH, "mpe.profesorpormateriaplanestudiosid = a.profesorpormateriaplanestudioid")

        ->andWhere('mpe.profesorpormateriaplanestudiosid=:profesorpormateriaplanestudiosid and  ac.alumnoporcicloid=:alumnoporcicloid and (a.tipoasistenciaid=2 or a.tipoasistenciaid=3) and  a.fecha>=:fechainicio and a.fecha<=:fechafin')
        ->setParameter('profesorpormateriaplanestudiosid', $filtros['profesorpormateriaplanestudiosid'])
        ->setParameter('alumnoporcicloid', $filtros['alumnoporcicloid'])
        ->setParameter('fechainicio', $filtros['fechainicio'])
        ->setParameter('fechafin', $filtros['fechafin']);
       
        return $result->getQuery()->getResult();
    }

    public function FaltasRetardosAlumnoDia($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("
           CONCAT(
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 2 and ei.estatusinasistenciaid = 2 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 2 and ei.estatusinasistenciaid = 2 then 1 else 0 end)), ' FALTAS CANCELADAS', '<br>') ELSE '' END, 
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 2 and ei.estatusinasistenciaid = 3 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 2 and ei.estatusinasistenciaid = 3 then 1 else 0 end)), ' FALTAS JUSTIFICADAS', '<br>') ELSE '' END, 
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 1 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 1 then 1 else 0 end)), ' RETARDOS VIGENTES', '<br>') ELSE '' END, 
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 2 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 2 then 1 else 0 end)), ' RETARDOS CANCELADOS', '<br>') ELSE '' END, 
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 3 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 3 and ei.estatusinasistenciaid = 3 then 1 else 0 end)), ' RETARDOS JUSTIFICADOS', '<br>') ELSE '' END,
                CASE WHEN (SUM(CASE WHEN ta.tipoasistenciaid = 4 and ei.estatusinasistenciaid = 1 THEN 1 ELSE 0 END)) > 0 THEN CONCAT(SUM((CASE WHEN ta.tipoasistenciaid = 4 and ei.estatusinasistenciaid = 1 then 1 else 0 end)), ' SUSPENSIONES VIGENTES', '<br>') ELSE '' END
            ) AS detalle
        ")
        ->from("AppBundle:CeAsistenciapordia","a")
        ->Join("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "ac.alumnoporcicloid = a.alumnoporcicloid")
        ->innerJoin("AppBundle:CeTipoasistencia", 'ta', Expr\Join::WITH, "ta.tipoasistenciaid=a.tipoasistenciaid")
        ->innerJoin("AppBundle:CeEstatusinasistencia", 'ei', Expr\Join::WITH, "ei.estatusinasistenciaid=a.estatusinasistenciaid")
        ->andWhere('ac.alumnoporcicloid =:alumnoporcicloid and (a.tipoasistenciaid=2 or a.tipoasistenciaid=3 or a.tipoasistenciaid = 4) and  a.fecha>=:fechainicio and a.fecha<=:fechafin')
        ->setParameter('alumnoporcicloid', $filtros['alumnoporcicloid'])
        ->setParameter('fechainicio', $filtros['fechainicio'])
        ->setParameter('fechafin', $filtros['fechafin']);
       
        return $result->getQuery()->getResult();
    }

    public function ComentarioPonderacionMateria($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("cam.comentario, a.aprendizajeesperadoid, IDENTITY(ams.materiaid)")
        ->from("AppBundle:CeAprendizajeesperado","a")
        ->innerJoin("AppBundle:CeAprendizajeesperadopormateria", 'am', Expr\Join::WITH, "a.aprendizajeesperadoid=am.aprendizajesesperadoid")
        ->leftJoin("AppBundle:CeAprendizajepormateriaporsubmateria", 'ams', Expr\Join::WITH, "ams.aprendizajepormateriaid = am.aprendizajeesperadopormateriaid")
        ->leftJoin("AppBundle:CeComentarioaprendizajepormateria", 'cam', Expr\Join::WITH, "cam.aprendizajeesperadopormaterisubmateriaid = ams.aprendizajeesperadopormaterisubmateriaid")
        ->andWhere("am.materiaporplanestudioid = :materiaporplanestudioid and a.cicloid = :cicloid and a.gradoid = :gradoid and a.periodoevaluacionid = :periodoevaluacionid and a.planestudioid = :planestudioid")
        ->setParameter('cicloid', $filtros['cicloid'])
        ->setParameter('gradoid', $filtros['gradoid'])
        ->setParameter('periodoevaluacionid', $filtros['periodoevaluacionid'])
        ->setParameter('materiaporplanestudioid', $filtros['materiaporplanestudioid'])
        ->setParameter('planestudioid', $filtros['planestudioid'])
        ->groupBy("a.aprendizajeesperadoid");

        if(!empty($filtros['materiaid'])){
			$result->andWhere('ams.materiaid = :materiaid ')
				->setParameter('materiaid', $filtros['materiaid']);
        }
        
        if(!empty($filtros['ponderacionopcionid'])){
			$result->andWhere('cam.ponderacionid = :ponderacionid  ')
				->setParameter('ponderacionid', $filtros['ponderacionopcionid']);
        }
        
        if(!empty($filtros['configurarcomentarios'])){
			$result->andWhere('a.configurarcomentarios = 1');
        }
        
        
        return $result->getQuery()->getResult();
    }

}
