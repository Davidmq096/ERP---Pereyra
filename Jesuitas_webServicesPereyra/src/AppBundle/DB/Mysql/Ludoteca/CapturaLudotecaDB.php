<?php

namespace AppBundle\DB\Mysql\Ludoteca;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Captura ludoteca
 *
 * @author David Medina
 */
class CapturaLudotecaDB extends BaseDBManager {


    public function FiltrarLudoteca($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("lc.capturaid,ac.alumnoporcicloid, DATE_FORMAT(lc.fecha, '%d/%m/%Y') as fecha,  
        DATE_FORMAT(lc.hora, '%H:%i') as hora, a.matricula,a.primernombre,a.apellidopaterno,
        a.apellidomaterno, n.nombre as nivel,g.grado, gr.nombre as grupo,lc.tienecontrato, coe.contratoestatusid, 
        coe.nombre as contratoestatus, lc.adeudo,lc.diasvencidos,lc.personarecoge, luec.nombre as estatuscaptura, luec.estatuscapturaid,
        t.nombre as tipoludoteca, concat_ws(' ', p.apellidopaterno, p.apellidomaterno, p.nombre) as cuenta,
        lc.motivocancelacion, concat_ws(' ', pc.apellidopaterno, pc.apellidomaterno, pc.nombre) as usuariocancelacion")
        ->from("AppBundle:LuCaptura", 'lc')
        ->innerJoin('AppBundle:CeAlumnoporciclo', 'ac', Expr\Join::WITH, "ac.alumnoporcicloid = lc.alumnoporcicloid")
        ->leftJoin('AppBundle:LuContrato', 'co', Expr\Join::WITH, "co.alumnoid = ac.alumnoid")
        ->leftJoin('AppBundle:LuContratoestatus', 'coe', Expr\Join::WITH, "coe.contratoestatusid = co.contratoestatusid")
        ->leftJoin('AppBundle:LuEstatuscaptura', 'luec', Expr\Join::WITH, "luec.estatuscapturaid = lc.estatuscapturaid")
        ->innerJoin('AppBundle:CeAlumno', 'a', Expr\Join::WITH, "a.alumnoid = ac.alumnoid")
        ->innerJoin('AppBundle:Ciclo', 'c', Expr\Join::WITH, "c.cicloid = ac.cicloid")
        ->innerJoin('AppBundle:Grado', 'g', Expr\Join::WITH, "g.gradoid = ac.gradoid")
        ->innerJoin('AppBundle:Nivel', 'n', Expr\Join::WITH, "n.nivelid = g.nivelid")
        ->leftJoin('AppBundle:CeAlumnocicloporgrupo', 'acg', Expr\Join::WITH, "acg.alumnoporcicloid = lc.alumnoporcicloid")
        ->leftJoin('AppBundle:Usuario', 'u', Expr\Join::WITH, "u.usuarioid = lc.usuarioid")
        ->leftJoin('AppBundle:Usuario', 'uc', Expr\Join::WITH, "uc.usuarioid = lc.usuarioidcancelacion")
        ->leftJoin('AppBundle:Persona', 'p', Expr\Join::WITH, "p.personaid = u.personaid")
        ->leftJoin('AppBundle:Persona', 'pc', Expr\Join::WITH, "pc.personaid = uc.personaid")
        ->leftJoin('AppBundle:CeGrupo', 'gr', Expr\Join::WITH, "gr.grupoid = acg.grupoid")
        ->innerJoin('AppBundle:LuTipo', 't', Expr\Join::WITH, "t.tipoid = lc.tipoid")
        ->groupBy('lc.capturaid');

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

        if (isset($filtros['fechainicio'])) {
            $dateinicio = new \DateTime($filtros['fechainicio']);
            $datefin = new \DateTime($filtros['fechafin']);
            $result->andWhere('lc.fecha between :fechainicio and :fechafin')
                    ->setParameter("fechainicio", $dateinicio)
                    ->setParameter("fechafin", $datefin);
        }


        if (isset($filtros['matricula']) && !empty($filtros['matricula'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['matricula']=trim(str_replace($escape,$escapados,$filtros['matricula']));
            $result->andWhere('a.matricula like :matricula')
	        ->setParameter('matricula', '%'.$filtros['matricula'].'%');             
        }      

        if (isset($filtros['usuarioid'])) {
        	$result->andWhere('u.usuarioid = :usuarioid')
        	->setParameter('usuarioid', $filtros['usuarioid']);
        }

        if (isset($filtros['tipoludotecaid'])) {
        	$result->andWhere('t.tipoid = :tipoludotecaid')
        	->setParameter('tipoludotecaid', $filtros['tipoludotecaid']);
        }

        if (isset($filtros['estatusid'])) {
        	$result->andWhere('luec.estatuscapturaid = :estatusid')
        	->setParameter('estatusid', $filtros['estatusid']);
        }

        return $result->getQuery()->getResult();
    }

    public function BuscarCapturaAlumno($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('c.capturaid, ac.alumnoporcicloid')
        ->from("AppBundle:LuCaptura", 'c')
        ->innerJoin('AppBundle:CeAlumnoporciclo', 'ac', Expr\Join::WITH, "ac.alumnoporcicloid = c.alumnoporcicloid")
        ->innerJoin('AppBundle:LuTipo', 't', Expr\Join::WITH, "t.tipoid = c.tipoid");

        if (isset($filtros['alumnopocicloid'])) {
        	$result->andWhere('ac.alumnoporcicloid = :alumnoporcicloid')
        	->setParameter('alumnoporcicloid', $filtros['alumnopocicloid']);
        }
        if (isset($filtros['tipoid'])) {
        	$result->andWhere('t.tipoid = :tipoid')
        	->setParameter('tipoid', $filtros['tipoid']);
        }
        if(isset($filtros['fecha'])){
			$result->andWhere('c.fecha = :fecha')
				->setParameter('fecha', $filtros['fecha']);
        }
        if(isset($filtros['estatus'])){
			$result->andWhere('c.estatuscapturaid = :estatuscapturaid')
				->setParameter('estatuscapturaid', $filtros['estatus']);
		}
        return $result->getQuery()->getResult();
    }

    public function BuscarLudoteca($filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('lc.contratoid, lce.contratoestatusid, dp.fechalimitepago, dp.importe,t.tipoid')
        ->from("AppBundle:LuContrato", 'lc')
        ->innerJoin('AppBundle:LuTipo', 't', Expr\Join::WITH, "t.tipoid = lc.tipoid")
        ->innerJoin('AppBundle:LuContratopormes', 'lcm', Expr\Join::WITH, "lcm.contratoid = lc.contratoid")
        ->innerJoin('AppBundle:LuContratoestatus', 'lce', Expr\Join::WITH, "lce.contratoestatusid = lc.contratoestatusid")
        ->innerJoin('AppBundle:LuContratoestatuspago', 'lcep', Expr\Join::WITH, "lcep.contratoestatuspagoid = lcm.contratoestatuspagoid")
        ->innerJoin('AppBundle:CjDocumentoporpagar', 'dp', Expr\Join::WITH, "dp.documentoporpagarid = lcm.documentoporpagarid")
        ->orderBy('dp.fechalimitepago');
        $result->Where('lce.contratoestatusid = 1');

        if (isset($filtros['alumnoid'])) {
        	$result->andWhere('lc.alumnoid = :alumnoid')
        	->setParameter('alumnoid', $filtros['alumnoid']);
        }
        if (isset($filtros['tipoid'])) {
        	$result->andWhere('t.tipoid = :tipoid')
        	->setParameter('tipoid', $filtros['tipoid']);
        }
        return $result->getQuery()->getResult();
    }

    public function BuscarPersonarecoge() {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select(' DISTINCT lc.personarecoge')
        ->from("AppBundle:LuCaptura", 'lc');
        return $result->getQuery()->getResult();
    }

    public function BuscarUsuarios() {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("u.usuarioid, concat_ws(' ',p.apellidopaterno, p.apellidomaterno, p.nombre) as nombrecompleto")
        ->from("AppBundle:Usuario", 'u')
        ->innerJoin('AppBundle:Persona', 'p', Expr\Join::WITH, "p.personaid = u.personaid");
        $result->Where('u.activo = 1');
        $result->andWhere('u.tipousuarioid = 1');

        return $result->getQuery()->getResult();
    }

    public function BuscarPersonarecogeporalumno($id) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('pa.personaautorizadarecogerid, pa.nombre')
        ->from("AppBundle:CePersonaautorizadarecogerporalumno", 'pr')
        ->innerJoin('pr.personaautorizadarecogerid', 'pa');

        if (isset($id)) {
        	$result->andWhere('pr.alumnoid = :alumnoid')
        	->setParameter('alumnoid', $id);
        }

        return $result->getQuery()->getResult();
    }

    public function BuscarPadretutorporalumno($id) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("p.padresotutoresid, concat_ws(' ', p.apellidopaterno,p.apellidomaterno,p.nombre) as nombre")
        ->from("AppBundle:CeAlumnoporclavefamiliar", 'ac')
        ->innerJoin('AppBundle:CePadresotutoresclavefamiliar', 'pc', Expr\Join::WITH, "pc.clavefamiliarid = ac.clavefamiliarid")
        ->innerJoin('AppBundle:CePadresotutores', 'p', Expr\Join::WITH, "p.padresotutoresid = pc.padresotutoresid");

        if (isset($id)) {
        	$result->andWhere('ac.alumnoid = :alumnoid')
        	->setParameter('alumnoid', $id);
        }

        return $result->getQuery()->getResult();
    }

    public function ObtenerDatosLudotecaAlumno($alumnoid, $fecha, $tipo) {
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare("select count(*) as dias,
        case when a.PrimerNombre like '%*%' or a.ApellidoPaterno like '%*%' or a.ApellidoMaterno like '%*%' then 40 * Count(*)  else  55 * Count(*) end as importe,
        CONCAT('Ludoteca ', case when t.TipoId = 1 then 'Matutina ' when t.TipoId = 2 then 'Vespertina ' when t.TipoId = 3 then 'Deportes ' END, dateamesespanol('" . $fecha . "'), ' (',  cast(Count(*) as int), ') dia(s)') as concepto
        from lu_captura cm
        inner join ce_alumnoporciclo ac on ac.AlumnoPorCicloId = cm.AlumnoPorCicloId
        inner join ce_alumno a on ac.AlumnoId = a.AlumnoId
        inner join lu_tipo t on t.TipoId = cm.Tipoid
        left join cj_documentoporpagar dp on dp.DocumentoPorPagarId = cm.DocumentoPorPagarId
       where Fecha between DATE_FORMAT('" . $fecha . "', '%Y-%m-01') and LAST_DAY('" . $fecha . "') and a.AlumnoId = " . $alumnoid . " and cm.EstatusCapturaId <> 3 and cm.TipoId = " . $tipo . ";");

        $stmt->execute();
        $filtro = $stmt->fetchAll();
        return $filtro;
    }

}
