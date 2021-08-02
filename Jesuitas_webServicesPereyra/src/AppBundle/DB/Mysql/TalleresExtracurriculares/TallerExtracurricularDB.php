<?php

namespace AppBundle\DB\Mysql\TalleresExtracurriculares;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Talleres Extracurriculares
 *
 * @author Mariano
 */
class TallerExtracurricularDB extends BaseDBManager {

    public function BuscarTalleresExtracurriculares($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("tc.tallerextracurricularid,tc.nombre as taller,GROUPCONCAT(distinct n.nombre SEPARATOR '\n') as nivel,GROUPCONCAT(distinct CONCAT_WS('',n.nombrecorto,' - ',g.grado) SEPARATOR '\n') as grado,CONCAT_WS(' ',p.apellidopaterno,p.apellidomaterno,p.nombre) as profesor,tc.cupo,
        CASE
            WHEN s.importe is null THEN 'PENDIENTE'
            ELSE s.importe
        END as costo,l.nombre as lugar,tc.colorplayera as color,GROUPCONCAT(distinct n.nivelid) as nivelid,tc.descripcion,p.profesorid,c.cicloid,GROUPCONCAT(distinct g.gradoid) as gradoid,tc.tipoinscripcion,tc.anonacimientomin,tc.anonacimientomax,l.lugarid,tr.tallerextrareglamentoid as reglamentoid,tc.activo,GROUPCONCAT(distinct tm.tallermaterialid) as tallermaterialid,
        tc.cupomaxmasculino,tc.cupomaxfemenino")
        ->from("AppBundle:CeTallerextracurricular","tc")
        ->innerJoin("AppBundle:Ciclo", "c", Expr\Join::WITH, "c.cicloid=tc.cicloid")
        ->leftJoin("AppBundle:CeTallerextrareglamento", "tr", Expr\Join::WITH, "tr.tallerextrareglamentoid=tc.reglamentoid")
        ->leftJoin("AppBundle:CeMaterialportallerextracurricular", "mte", Expr\Join::WITH, "mte.tallerextracurricularid=tc.tallerextracurricularid")
        ->leftJoin("AppBundle:CeTallermaterial", "tm", Expr\Join::WITH, "tm.tallermaterialid=mte.tallermaterialid")
        ->innerJoin("AppBundle:CeGradoportallerextracurricular", "gtc", Expr\Join::WITH, "gtc.tallerextracurricularid=tc.tallerextracurricularid")
        ->innerJoin("AppBundle:Grado", "g", Expr\Join::WITH, "g.gradoid=gtc.gradoid")
        ->leftJoin("AppBundle:CeSemestre", "sem", Expr\Join::WITH, "sem.semestreid=g.semestreid")
        ->innerJoin("AppBundle:Nivel", "n", Expr\Join::WITH, "n.nivelid=g.nivelid")
        ->leftJoin("AppBundle:CeProfesor", "p", Expr\Join::WITH, "p.profesorid=tc.profesorid")
        ->innerJoin("AppBundle:Lugar", "l", Expr\Join::WITH, "l.lugarid=tc.lugarid")
        ->leftJoin("AppBundle:CjSubconceptoportaller", "st", Expr\Join::WITH, "st.tallerextracurricularid=tc.tallerextracurricularid")
        ->leftJoin("AppBundle:CjSubconcepto", "s", Expr\Join::WITH, "s.subconceptoid=st.subconceptoid")
        ->groupBy("tc.tallerextracurricularid");
        if (isset($filtros['cicloid'])) {
        	$result->andWhere('tc.cicloid = :cicloid')
        	->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid = :nivelid')
        	->setParameter('nivelid', $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid = :gradoid')
        	->setParameter('gradoid', $filtros['gradoid']);
        }
        if (isset($filtros['semestreid'])) {
        	$result->andWhere('sem.semestreid = :semestreid')
        	->setParameter('semestreid', $filtros['semestreid']);
        }
        
        return $result->getQuery()->getResult();
    }

    public function LugaresDisponibles($tallerextracurricularid) {
        $conn = $this->em->getConnection();
        $sql="select  cupo-count(alumnoporcicloid) as disponible from ce_alumnocicloportallerextra   acte
        inner join ce_tallerextracurricular tc on tc.tallerextracurricularid=acte.tallerextraid
        where tc.tallerextracurricularid=".$tallerextracurricularid;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        return (int)$resultado[0]["disponible"];
    }

    public function obtenerAlumnos($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.matricula,a.alumnoid, CONCAT_WS(' ',a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) as nombre, c.nombre ciclo, c.cicloid, gru.nombre grupo, gru.grupoid, g.grado, g.gradoid, n.nivelid, n.nombre nivel, ac.alumnoporcicloid")
        ->from('AppBundle:CeAlumnoporciclo', 'ac')
        ->innerJoin('ac.alumnoid', 'a')
        ->innerJoin('ac.cicloid', 'c')
        ->innerJoin('ac.gradoid','g')
        ->innerJoin('g.nivelid','n')
        ->innerJoin("AppBundle:CeAlumnocicloporgrupo", "acg", Expr\Join::WITH, "acg.alumnoporcicloid = ac.alumnoporcicloid")
        ->innerJoin('acg.grupoid','gru')
        ->andWhere('c.cicloid = ' . $filtros['cicloid']);
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid in (:gradoid)')
        	->setParameter('gradoid', $filtros['gradoid']);
        }
        return $result->getQuery()->getResult();
    }

}
