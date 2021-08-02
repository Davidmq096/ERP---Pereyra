<?php

namespace AppBundle\DB\Mysql\Becas;
use AppBundle\DB\DbmControlescolar;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Filtrado de fondos de orfandad
 *
 * @author Judith
 */
class SolicitudBecaDB extends BaseDBManager
{

    public function SolicitudesPorPadreoTutor($id, $val)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("sb.solicitudid, cf.clavefamiliarid, cf.clave, cf.apellidopaterno,
        cf.apellidomaterno, esb.estatusid, esb.descripcion, c.nombre AS ciclo")
            ->from("AppBundle:CePadresotutoresclavefamiliar", 'ptcf')
            ->innerJoin('AppBundle:CeClavefamiliar', 'cf', Expr\Join::WITH, 'cf.clavefamiliarid = ptcf.clavefamiliarid')
            ->innerJoin('AppBundle:BcSolicitudbeca', 'sb', Expr\Join::WITH, 'sb.clavefamiliarid = cf.clavefamiliarid')
            ->leftJoin('AppBundle:BcSolicitudporalumno', 'spa', Expr\Join::WITH, 'spa.solicitudid = sb.solicitudid')
            ->innerJoin('AppBundle:Ciclo', 'c', Expr\Join::WITH, 'c.cicloid = sb.cicloid')
            ->leftJoin('AppBundle:BcEstatussolicitudbeca', 'esb', Expr\Join::WITH, 'esb.estatusid = sb.estatusid')
            ->innerJoin('AppBundle:BcPeriodobeca', 'pb', Expr\Join::WITH, 'c.cicloid = pb.cicloid')
            ->where('ptcf.padresotutoresid = :padresotutoresid')
            ->setParameter('padresotutoresid', $id)
            ->andWhere('CURRENT_DATE() BETWEEN pb.fechainicapturas and pb.fechafincapturas')
            ->groupby('sb.solicitudid')
            ->orderby('sb.solicitudid', 'desc');
        if ($val == 1) {
            $qb->andWhere('sb.estatusid in (2,3)');
        }
        return $result->getQuery()->getResult();
    }

    public function SolicitudesPorPadreoTutorAlumnos($solicitudid, $param)
    {
        $qb = $this->em->createQueryBuilder();
        $ultimociclo = $qb->select('max(acu.cicloid)')
            ->from("AppBundle:CeAlumnoporciclo", "acu")
            ->innerJoin("acu.cicloid", "ccc")
            ->where("acu.alumnoid = a.alumnoid")
            ->groupBy('acu.alumnoid')
            ->andWhere('ccc.actual = 1')
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $ultimociclo2 = $qb->select('max(acu2.cicloid)')
            ->from("AppBundle:CeAlumnoporciclo", "acu2")
            ->innerJoin("acu2.cicloid", "ccc2")
            ->where("acu2.alumnoid = a.alumnoid")
            ->groupBy('acu2.alumnoid')
            ->andWhere('ccc2.siguiente = 1')
            ->getQuery()->getDQL();    

        $qb = $this->em->createQueryBuilder();
        $gradoactual = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = (" . $ultimociclo . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $gradoactual2 = $qb->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn2.fechainicios2 THEN max(g3.gradoid)
        ELSE min(g3.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac3")
            ->innerJoin("ac3.gradoid", "g3")
            ->innerJoin("ac3.cicloid", "c3", Expr\Join::WITH, "ac3.cicloid = (" . $ultimociclo2 . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn2", Expr\Join::WITH, "g3.nivelid = cn2.nivelid and cn2.cicloid = c3.cicloid")
            ->where("a.alumnoid = ac3.alumnoid")
            ->getQuery()->getDQL();    

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, a.matricula,
        CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) nombre,
        CASE
            WHEN sb.estatusid = 6 THEN 'Rechazada'
            ELSE esb.descripcion
        END as estatus, 
        esbalumno.descripcion as estatusalumno,
         CASE WHEN ga.grado IS NOT NULL THEN CONCAT_WS(' de ', ga.grado, na.nombre) ELSE CONCAT_WS(' de ', g6.grado, n6.nombre) END  gradoactual,
         CONCAT_WS(' de ', gs.grado, ns.nombre) gradosiguiente
        ")
            ->from("AppBundle:CeAlumnoporclavefamiliar", 'acf')
            ->innerJoin('acf.alumnoid', 'a')
            ->innerJoin('AppBundle:BcSolicitudbeca', 'sb', Expr\Join::WITH, 'sb.clavefamiliarid = acf.clavefamiliarid')
            ->leftJoin('sb.estatusid', 'esb')

            ->leftJoin("AppBundle:CeAlumnoporciclo", 'apc', Expr\Join::WITH, "a.alumnoid = apc.alumnoid and apc.gradoid = (" . $gradoactual . ") and apc.estatusalumnocicloid <> 3")
            ->leftJoin("AppBundle:CeAlumnoporciclo", 'apc6', Expr\Join::WITH, "a.alumnoid = apc6.alumnoid and apc6.gradoid = (" . $gradoactual2 . ") and apc6.estatusalumnocicloid <> 3")
            ->leftJoin('apc6.gradoid', 'g6')
            ->leftJoin('apc.gradoid', 'ga')
            ->leftJoin('ga.nivelid', 'na')
            ->leftJoin('g6.nivelid', 'n6')
            ->leftJoin(
                'AppBundle:Grado',
                'gs',
                Expr\Join::WITH,
                '(CASE 
                    WHEN g6.gradoid is not null THEN g6.gradoid
                    WHEN apc.gradoid = 17 or apc.gradoid = 18 THEN :NULL
                    WHEN apc.gradoid = 13 or apc.gradoid = 15 THEN (apc.gradoid + 2)                    
                    WHEN apc.gradoid = 19 THEN 1 
                    ELSE apc.gradoid + 1 
                END) = gs.gradoid'
            )
            ->leftJoin('gs.nivelid', 'ns');
        if ($param == 1) {
            $qb->innerJoin('AppBundle:BcSolicitudporalumno', 'spa', Expr\Join::WITH, 'a.alumnoid = spa.alumnoid and spa.solicitudid = sb.solicitudid and spa.estatusid in (2,3)');
        } else {
            $qb->leftJoin('AppBundle:BcSolicitudporalumno', 'spa', Expr\Join::WITH, 'a.alumnoid = spa.alumnoid and spa.solicitudid = sb.solicitudid');
        }
        $qb->leftJoin('spa.estatusid', 'esbalumno')
            ->where('sb.solicitudid = :solicitudid')
            ->andWhere('a.alumnoestatusid != 2')
            ->setParameter('solicitudid', $solicitudid)
            ->setParameter('NULL', null)
            ->orderBy('na.nombre, ga.grado')
            ->groupBy('a.alumnoid');
        $sql = $result->getQuery()->getSQL();

        return $result->getQuery()->getResult();
    }



    public function BuscarSolicitudesAlumno($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("sa.alumnosolicitudid,sb.solicitudid,a.alumnoid,esb.estatusid,sa.calificacion ")
            ->from('AppBundle:BcSolicitudporalumno', 'sa')
            ->innerJoin('sa.alumnoid', 'a')
            ->innerJoin('sa.solicitudid', 'sb')
            ->innerJoin('sb.cicloid', 'c')
            ->innerJoin('sa.estatusid', 'esb')
            ->where('sa.alumnoid= :alumnoid')
            ->setParameter('alumnoid', $filtros['alumnoid']);
        if ($filtros['solicitudbecaid']) {
            $result->andwhere('sb.solicitudid= :solicitudbecaid')
                ->setParameter('solicitudbecaid', $filtros['solicitudbecaid']);
        } else {
            $result->andwhere('c.siguiente = 1');
        }

        return $result->getQuery()->getResult();
    }

    public function VistaSolicitudBeca($id)
    {
        $conn = $this->em->getConnection();
        if (ENTORNO == 1) {
            $stmt = $conn->prepare('CALL sp_solicitudbecatokensLux(:id)');
        } else {
            $stmt = $conn->prepare('CALL sp_solicitudbecatokens(:id)');
        }
        $stmt->execute(array('id' => $id));
        $result = $stmt->fetch();
        return $result;
    }



    public function BuscarSolicitudClaveFamiliar($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("cf.clavefamiliarid, cf.clave")
            ->from("AppBundle:CeClavefamiliar", 'cf')
            ->leftJoin('AppBundle:CeAlumnoporclavefamiliar', 'apcf', Expr\Join::WITH, 'cf.clavefamiliarid = apcf.clavefamiliarid')
            ->leftJoin('AppBundle:CeAlumno', 'a', Expr\Join::WITH, 'a.alumnoid = apcf.alumnoid')
            ->where('a.matricula =' . $filtros['Matricula']);
        return $result->getQuery()->getResult();
    }

    public function Buscaralumnoporfamlia($filtros, $param)
    {

        $qb = $this->em->createQueryBuilder();
        $ultimociclo = $qb->select('Case WHEN max(ccca.cicloid) IS NULL THEN max(ccc.cicloid) ELSE max(ccca.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu")
            ->innerJoin("acu.cicloid", "ccc")
            ->leftJoin("AppBundle:Ciclo", "ccca", Expr\Join::WITH, "acu.cicloid = ccca.cicloid and ccca.actual = 1")
            ->where("acu.alumnoid = a.alumnoid")
            ->groupBy('acu.alumnoid');

        $qb = $this->em->createQueryBuilder();
        $ultimociclo2 = $qb->select('Case WHEN max(ccca2.cicloid) IS NULL THEN max(ccc2.cicloid) ELSE max(ccca2.cicloid) END')
            ->from("AppBundle:CeAlumnoporciclo", "acu2")
            ->innerJoin("acu2.cicloid", "ccc2")
            ->leftJoin("AppBundle:Ciclo", "ccca2", Expr\Join::WITH, "acu2.cicloid = ccca2.cicloid and ccca2.actual = 1")
            ->where("acu2.alumnoid = a.alumnoid")
            ->groupBy('acu2.alumnoid');

        $qb = $this->em->createQueryBuilder();
        $gradoactual = $qb->select('CASE WHEN
            CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
            ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = (" . $ultimociclo . ")")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid");


        $qb = $this->em->createQueryBuilder();
        $ciclosiguiente = $qb->select('c2a.cicloid')
            ->from("AppBundle:Ciclo", "c2a")
            ->where("c2a.siguiente = 1")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $ciclobeca = $qb->select('c3.cicloid')
            ->from("AppBundle:Ciclo", "c3")
            ->where("c3.activo = 1 and c3.actual = 1");
        $ciclobeca->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $porcentaje = $qb->select("GROUPCONCAT(CONCAT(pb.descripcion, '%')
        SEPARATOR ', ')")
            ->from("AppBundle:BcBecas", "b2")
            ->leftJoin('b2.porcentajebecaid', 'pb')
            ->leftJoin('b2.tipobecaid', 'tb')
            ->leftJoin('b2.cicloid', 'cb')
            ->where("b2.alumnoid = a.alumnoid and cb.actual = 1 and b2.estatusid = 3");
        $porcentaje->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $tipodebeca = $qb->select(" GROUPCONCAT(tb2.descripcion
        SEPARATOR ', ')")
            ->from("AppBundle:BcBecas", "b3")
            ->leftJoin('b3.porcentajebecaid', 'pb2')
            ->leftJoin('b3.tipobecaid', 'tb2')
            ->leftJoin('b3.cicloid', 'cb2')
            ->where("b3.alumnoid = a.alumnoid and cb2.actual = 1  and b3.estatusid = 3");
        $tipodebeca->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ca.cicloid,
        cf.clavefamiliarid, v.viveconid, v.nombre vivecon, a.alumnoid, a.matricula, ac.alumnoporcicloid,
        a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno,
        a.curp, n.nivelid, n.nombre, g.gradoid, g.grado, spa.becarecomendadaporalumnoid, spa.becarecomendada,
        CASE
        WHEN calculaAdeudo(a.alumnoid) > 0 THEN 'Con adeudo'
        ELSE 'Sin adeudo'
        END AS cobranza,
        '' AS promedio,
        '' AS refrendo,
        eac.estatusalumnoporcicloid AS estatusalumnocicloid,
        sbae.estatusid as estatussolicitudalumno,
        sba.alumnosolicitudid AS alumnoSolicitudid")
            ->addSelect("(" . $porcentaje . ") as porcentaje")
            ->addSelect("(" . $tipodebeca . ") as tipodebeca")
            ->from('AppBundle:CeClavefamiliar', 'cf')
            ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'apcf', Expr\Join::WITH, 'apcf.clavefamiliarid=cf.clavefamiliarid')
            ->innerJoin('apcf.alumnoid', 'a')
            ->leftJoin('a.viveconid', 'v')
            ->leftJoin('AppBundle:CeAlumnoporciclo', 'ac', Expr\Join::WITH, 'ac.alumnoid = a.alumnoid and ac.gradoid = (' . $gradoactual . ") and ac.cicloid = (" . $ultimociclo2 . ")")
            ->leftJoin('AppBundle:Ciclo', 'ca', Expr\Join::WITH, 'ac.cicloid = ca.cicloid')
            ->leftJoin('ac.estatusalumnocicloid', 'eac')
            ->leftJoin('AppBundle:Grado', 'g', Expr\Join::WITH, 'ac.gradoid = g.gradoid')
            ->leftJoin('AppBundle:Nivel', 'n', Expr\Join::WITH, 'g.nivelid = n.nivelid')
            ->leftJoin('AppBundle:BcSolicitudbeca', 'bs', Expr\Join::WITH, 'bs.clavefamiliarid = cf.clavefamiliarid')
            ->leftJoin('AppBundle:BcSolicitudporalumno', 'sba', Expr\Join::WITH, 'sba.alumnoid = a.alumnoid and sba.solicitudid = bs.solicitudid')
            ->leftJoin('sba.estatusid', 'sbae')
            ->leftJoin('AppBundle:BcBecarecomendadaporalumno', 'spa', Expr\Join::WITH, 'spa.alumnosolicitudid = sba.alumnosolicitudid')
            ->where('ac.estatusalumnocicloid <> 3')
            ->andWhere('g.gradoid NOT IN (17,18)')
            ->andWhere('cf.clavefamiliarid = :clavefamiliarid')
            ->setParameter('clavefamiliarid', $filtros['clavefamiliarid'])
            ->groupby('a.alumnoid');

        if ($param == 1 && !$filtros["solicitudalumno"]) {
            $result->andWhere("sba.alumnosolicitudid IS NOT NULL");
        }
        if($filtros["solicitudbecaid"]){
            $result->andWhere('bs.solicitudid = :solicitudbecaid')
            ->setParameter('solicitudbecaid', $filtros['solicitudbecaid']);
        }

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }



    public function Buscardomicilioestudiosocioeconomicoalumno($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pcf, pot,
    c.municipioid, c.nombre as muncipio,e.estadoid, e.nombre as estado,p.paisid, p.nombre as pais, col.coloniaid, col.nombre as nombrecolonia")
            ->from('AppBundle:CeAlumnodomicilio', 'pot')
            ->leftJoin('AppBundle:Municipio', 'c', Expr\Join::WITH, 'c.municipioid=pot.ciudad')
            ->leftJoin('AppBundle:CePadresotutoresclavefamiliar', 'pcf', Expr\Join::WITH, 'pcf.clavefamiliarid=' . $filtros['clavefamiliarid'])
            ->leftJoin('AppBundle:Estado', 'e', Expr\Join::WITH, 'c.estadoid=e.estadoid')
            ->leftJoin('AppBundle:Pais', 'p', Expr\Join::WITH, 'e.paisid=p.paisid')
            ->leftJoin('AppBundle:Colonia', 'col', Expr\Join::WITH, 'c.municipioid=col.municipioid')
            ->where('pot.alumnoid=' . $filtros['alumnoid'])
            ->groupby('pcf.clavefamiliarid');

        return $result->getQuery()->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    //Busca el historial de becas de un alumno
    public function Buscarhistorialhijos($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.nombre as nombreciclo, a.alumnoid,
   n.nivelid, n.nombre, g.gradoid, g.grado, tb.tipobecaid,tb.descripcion, p.porcentajebecaid, p.descripcion as porcentaje")
            ->from('AppBundle:BcBecas', 'b')
            ->innerJoin('b.alumnoid', 'a')
            ->leftJoin('b.gradoid', 'g')
            ->leftJoin('b.cicloid', 'c')
            ->leftJoin('g.nivelid', 'n')
            ->leftJoin('b.tipobecaid', 'tb')
            ->leftJoin('b.porcentajebecaid', 'p')
            ->where('b.alumnoid=' . $filtros['alumnoid'])
            ->andWhere("b.estatusid = 3");

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function BuscarReferencias($filtros)
    {

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pr")
            ->from('AppBundle:BcPersonareferencia', 'pr')
            ->where('pr.solicitudid=' . $filtros['solicitudid']);

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function eliminarRefencia($filtros)
    {
        try {
            $qb = $this->em->getConnection();
            $sql = "DELETE FROM bc_personareferencia WHERE PersonaReferenciaId=?";
            $stmt = $qb->prepare($sql);
            $stmt->execute([$filtros['personareferenciaid']]);

            return true;
        } catch (\Exceptio $e) {
            return false;
        }
    }

    public function Buscarnuevasbecas($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("b,c.cicloid, c.nombre, tb.tipobecaid, tb.descripcion as tipobeca, p.porcentajebecaid, p.descripcion as porcentaje
    ")
            ->from('AppBundle:BcProvisionalbecas', 'b')
            ->innerJoin('b.cicloid', 'c')
            ->innerJoin('b.tipobecaid', 'tb')
            ->innerJoin('b.porcentajebecaid', 'p')
            ->where('b.alumnoid=' . $filtros['alumnoid'])
            ->andwhere('b.solicitudid=' . $filtros['solicitudid']);

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }



    public function BuscarBecaprovicional($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pb,a.alumnoid,n.nivelid,tb.tipobecaid,c.cicloid,pbs.porcentajebecaid, e.estatusid,s.solicitudid,g.gradoid")
            ->from('AppBundle:BcProvisionalbecas', 'pb')
            ->innerjoin('pb.alumnoid', 'a')
            ->innerjoin('pb.nivelid', 'n')
            ->innerjoin('pb.tipobecaid', 'tb')
            ->innerjoin('pb.cicloid', 'c')
            ->innerjoin('pb.porcentajebecaid', 'pbs')
            ->innerjoin('pb.estatusid', 'e')
            ->innerjoin('pb.solicitudid', 's')
            ->innerjoin('pb.gradoid', 'g')
            ->where('pb.provisionalbecaid=' . $filtros);

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function BuscarSolicitudesBecas($filtros)
    {

        $qb = $this->em->createQueryBuilder();
        $grupo = $qb->select('Case WHEN gr2.grupoid IS NOT NULL THEN ag2.alumnocicloporgrupo ELSE 0 END')
            ->from("AppBundle:CeAlumnocicloporgrupo", "ag2")
            ->innerJoin("AppBundle:CeGrupo", "gr2",  Expr\Join::WITH, "ag2.grupoid = gr2.grupoid and gr2.tipogrupoid = 1")
            ->where("ag2.alumnoporcicloid = ac.alumnoporcicloid and gr2.gradoid = go.gradoid")
            ->groupBy("ag2.alumnoporcicloid")
            ->getQuery()->getDQL();

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("s.solicitudid SolicitudId, b.becaid, s.solicitudid folio, a.alumnoid, cf.clavefamiliarid, c.nombre ciclo,
        e.estatusid, e.descripcion estatus, sae.estatusid estatusidalumno, sae.descripcion estatusalumno, a.curp, ea.nombre as ealumno, gr.nombre as grupo,
        GROUPCONCAT(DISTINCT t2.tipobecaid SEPARATOR ', ') AS tipobecaid,
        GroupConcat(DISTINCT t.descripcion, ' ', p.descripcion, '%' separator '<br><br>') tipobeca, DATE_FORMAT(cpn.fechainicio, '%d/%m/%Y') fechainicio,
        GroupConcat(p.descripcion) porcentaje, cf.clave, a.matricula, psep.descripcion as sep, pidec.descripcion as idc, pexec.descripcion as excelencia,
        CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) nombre, eac2.nombre as estatusalumnociclo,
        CONCAT_WS(' ', cf.apellidopaterno, cf.apellidomaterno) familia,
        CONCAT_WS(' de ', go.grado,no.nombre) gradoorigen,
        CONCAT_WS(' de ', gd.grado,nd.nombre) gradodestino,
        CASE WHEN calculaAdeudo(a.alumnoid) > 0 THEN 'Con adeudo' ELSE 'Sin adeudo' END cobranza,
        CASE WHEN s.hijodepersonal = 1 THEN 'SI' ELSE 'NO' END eshijopersonal, s.pagado")
            ->from('AppBundle:BcSolicitudbeca', 's')
            ->innerJoin('s.cicloid', 'c')
            ->innerJoin('s.estatusid', 'e')
            ->innerJoin('s.clavefamiliarid', 'cf')
            ->leftJoin('AppBundle:BcSolicitudporalumno', 'sa', Expr\Join::WITH, 's.solicitudid = sa.solicitudid')
            ->leftJoin('AppBundle:BcEstatussolicitudbeca', 'sae', Expr\Join::WITH, 'sa.estatusid = sae.estatusid')
            ->leftJoin('sa.alumnoid', 'a')
            ->leftJoin('a.alumnoestatusid', 'ea')
            ->leftJoin('sa.gradoidorigen', 'go')
            ->leftJoin('go.nivelid', 'no')
            ->leftJoin('sa.gradoiddestino', 'gd')
            ->leftJoin('gd.nivelid', 'nd')

            ->leftJoin('AppBundle:CeAlumnoporciclo', 'ac', Expr\Join::WITH, 'ac.alumnoid = a.alumnoid and ac.gradoid = go.gradoid')
            ->leftJoin('ac.estatusalumnocicloid', 'eac2')
            ->leftJoin("AppBundle:CeAlumnocicloporgrupo", "ag", Expr\Join::WITH, "ag.alumnocicloporgrupo = (" . $grupo . ")")
            ->leftJoin("AppBundle:CeGrupo", "gr", Expr\Join::WITH, "ag.grupoid = gr.grupoid")

            ->leftJoin('AppBundle:BcBecas', 'b', Expr\Join::WITH, 'a.alumnoid = b.alumnoid and b.cicloid = (Select ca.cicloid from AppBundle:Ciclo ca where ca.actual = 1) and b.estatusid = 3')
            ->leftJoin('b.estatusid', 'eb')
            ->leftJoin('b.porcentajebecaid', 'p')
            ->leftJoin('b.tipobecaid', 't')
            ->leftJoin('b.cicloid', 'bcid')
            ->leftJoin('AppBundle:CeCiclopornivel', 'cpn', Expr\Join::WITH, 'cpn.cicloid = c.cicloid and cpn.nivelid = nd')
            ->leftJoin('AppBundle:BcBecasporsolicitud', 'bs', Expr\Join::WITH, 'bs.solicitudid = s.solicitudid')

            ->leftJoin('AppBundle:BcBecas', 'b2', Expr\Join::WITH, 'a.alumnoid = b2.alumnoid')
            ->leftJoin('b2.cicloid', 'bcid2')
            ->leftJoin('b2.tipobecaid', 't2')

            ->leftJoin('AppBundle:BcBecas', 'bsep', Expr\Join::WITH, 'a.alumnoid = bsep.alumnoid and bsep.cicloid = c.cicloid and bsep.estatusid = 3 and bsep.tipobecaid = 3')
            ->leftJoin('bsep.porcentajebecaid', 'psep')

            ->leftJoin('AppBundle:BcBecas', 'bidec', Expr\Join::WITH, 'a.alumnoid = bidec.alumnoid and bidec.cicloid = c.cicloid and bidec.estatusid = 3 and bidec.tipobecaid = 1')
            ->leftJoin('bidec.porcentajebecaid', 'pidec')

            ->leftJoin('AppBundle:BcBecas', 'be', Expr\Join::WITH, 'a.alumnoid = be.alumnoid and be.cicloid = c.cicloid and be.estatusid = 3 and be.tipobecaid = 2')
            ->leftJoin('be.porcentajebecaid', 'pexec')
            ->groupBy('s.solicitudid', 'a.alumnoid');
        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid IN (:cicloid)')
                ->setParameter('cicloid', $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
            $result->andWhere('nd.nivelid IN (:nivelid) or no.nivelid IN (:nivelid) or (nd.nivelid is null or no.nivelid is null)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }

        if (isset($filtros['gradoid'])) {
            $result->andWhere('gd.gradoid IN (:gradoid) or go.gradoid IN (:gradoid)')
                ->setParameter('gradoid', $filtros['gradoid']);
        }

        if (isset($filtros['estatusid'])) {
            $result->andWhere('(sae.estatusid is not null and sae.estatusid in (:estatusid))
            or (sae.estatusid is null and e.estatusid in (:estatusid))')
                ->setParameter('estatusid', $filtros['estatusid']);
        }
        if (isset($filtros['cobranza'])) {
            if ($filtros['cobranza'] == "Con adeudo") {
                $result->andWhere('calculaAdeudo(a.alumnoid) > 0');
            } else {
                $result->andWhere('calculaAdeudo(a.alumnoid) = 0 or calculaAdeudo(a.alumnoid) is null');
            }
        }

        if (isset($filtros['tipobecaid'])) {
            $result->andWhere('t.tipobecaid = ' . $filtros['tipobecaid']);
        }

        if (isset($filtros['tipobecas'])) {
            $result->having('tipobecaid like :tipobeca')
                ->setParameter('tipobeca', '%' . $filtros['tipobecas'] . '%');
        }

        if (isset($filtros['nombre'])) {
            $result->andWhere('a.primernombre like :nombre or a.segundonombre like :nombre')
                ->setParameter('nombre', '%' . $filtros['nombre'] . '%');
        }

        if (isset($filtros['apellidopaterno'])) {
            $result->andWhere('a.apellidopaterno like :apellidopaterno or cf.apellidopaterno like :apellidopaterno')
                ->setParameter('apellidopaterno', '%' . $filtros['apellidopaterno'] . '%');
        }

        if (isset($filtros['apellidomaterno'])) {
            $result->andWhere('a.apellidomaterno like :apellidomaterno or cf.apellidomaterno like :apellidomaterno')
                ->setParameter('apellidomaterno', '%' . $filtros['apellidomaterno'] . '%');
        }

        if (isset($filtros['usuarioid'])) {
            $result->andWhere('s.usuarioid =  :usuarioid')
                ->setParameter('usuarioid', $filtros['usuarioid']);
        }

        if (isset($filtros['matricula'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['matricula'] = trim(str_replace($escape, $escapados, $filtros['matricula']));
            $result->andWhere('a.matricula like :matricula')
                ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }

        if (isset($filtros['clavefamiliar'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['clavefamiliar'] = trim(str_replace($escape, $escapados, $filtros['clavefamiliar']));
            $result->andWhere('cf.clave like :clavefamiliar')
                ->setParameter('clavefamiliar', '%' . $filtros['clavefamiliar'] . '%');
        }

        if (isset($filtros['sistema'])) {
            if ($filtros['sistema'] == 2) {
                if (isset($filtros['pagado'])) {

                    if ($filtros['pagado'] == 1) {
                        $result->andWhere('s.pagado = :pagado')
                            ->setParameter('pagado', $filtros['pagado']);
                    } else {
                        $result->andWhere('s.pagado = 0 or s.pagado is null');
                    }
                }
            }
        }

        return $result->getQuery()->getResult();
    }



    public function getdomicilio($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("d, m.municipioid, e.estadoid, c, p")
            ->from('AppBundle:BcDomicilioestudiosocioeconomico', 'd')
            ->innerjoin('d.municipioid', 'm')
            ->innerjoin('d.estadoid', 'e')
            ->innerjoin('d.coloniaid', 'c')
            ->innerjoin('d.paisid', 'p')
            ->where('d.solicitudid=' . $filtros['solicitudid']);
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function getdomicilio2($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("d, m.municipioid, e.estadoid,p")
            ->from('AppBundle:BcDomicilioestudiosocioeconomico', 'd')
            ->innerjoin('d.municipioid', 'm')
            ->innerjoin('d.estadoid', 'e')
            ->innerjoin('d.paisid', 'p')
            ->where('d.solicitudid=' . $filtros['solicitudid']);
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function buscarvisita($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("v")
            ->from('AppBundle:BcVisitaestudiosocioeconomico', 'v')
            ->where('v.solicitudid=' . $filtros['solicitudid']);

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function buscardocs($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("d.documentoid,d.nombre,sb.observaciones,sb.hijodepersonal,sb.pagado")
            ->from('AppBundle:BcRecibirdocumentos', 'rd')
            ->innerJoin("AppBundle:BcDocumentos", "d", Expr\Join::WITH, "d.documentoid = rd.documentoid")
            ->innerJoin("AppBundle:BcSolicitudbeca", "sb", Expr\Join::WITH, "sb.solicitudid = rd.solicitudid")
            ->where('rd.solicitudid=' . $filtros['solicitudid']);

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function GetClaveFamiliarPadreOTutorSolicitudBeca($PadreOTutorId)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("cf.clavefamiliarid, cf.clave, cf.apellidopaterno, cf.apellidomaterno, case when sb.solicitudid IS NULL then 0 else 1 end AS solicitado")
            ->from('AppBundle:CePadresotutoresclavefamiliar', 'pt')
            ->innerJoin("AppBundle:CeClavefamiliar", "cf", Expr\Join::WITH, "cf.clavefamiliarid = pt.clavefamiliarid")
            ->leftJoin("AppBundle:BcSolicitudbeca", "sb", Expr\Join::WITH, "sb.clavefamiliarid = cf.clavefamiliarid and sb.cicloid = (select c.cicloid from AppBundle:Ciclo c where c.siguiente = 1)")

            ->andWhere('pt.padresotutoresid =' . $PadreOTutorId)
            ->orderBy('cf.apellidopaterno, cf.apellidomaterno', 'asc')
            ->groupby('cf.clavefamiliarid');

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function GetAlumnoPorClaveFamiliar($ClaveFamiliarId)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, CONCAT_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) as nombre,
                                                  a.matricula")
            ->from('AppBundle:CeAlumnoporclavefamiliar', 'ca')
            ->innerJoin("AppBundle:CeAlumno", "a", Expr\Join::WITH, "a.alumnoid = ca.alumnoid")
            ->andWhere('ca.clavefamiliarid =' . $ClaveFamiliarId)
            ->andWhere('a.alumnoestatusid = 1');

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function buscarPadresBecas($datos)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pt.padresotutoresid,pt.nombre as nombre,p.descripcion as parentesco,pt.vive,pt.ocupacion,pt.especificacionocupacion,pt.ramo as puesto,pt.empresa,pt.horariotrabajo,pt.antiguedad,sc.situacionconyugalid,pt.celular,pt.telempresa,pt.extensionempresa,pt.nombrejefeinmediato,e.escolaridadid,pt.domicilioempresa,pt.fechanacimiento,t.tutorid,p.parentescoid,t.descripcion as tutor")
            ->from("AppBundle:BcPadresotutores", 'pt')
            ->leftJoin("AppBundle:Tutor", "t", Expr\Join::WITH, "t.tutorid=pt.tutorid")
            ->leftJoin("AppBundle:Parentesco", "p", Expr\Join::WITH, "p.parentescoid=pt.parentescoid")
            ->leftJoin("AppBundle:Situacionconyugal", "sc", Expr\Join::WITH, "sc.situacionconyugalid=pt.situacionconyugalid")
            ->leftJoin("AppBundle:Escolaridad", "e", Expr\Join::WITH, "e.escolaridadid=pt.escolaridadid")
            ->andWhere('pt.clavefamiliarid=:clavefamiliarid')
            ->setParameter('clavefamiliarid', $datos['clavefamiliarid'])
            ->andWhere('pt.solicitudid = :solicitudid')
            ->setParameter('solicitudid', $datos['solicitudid']);
        //$qb->setMaxResults(2);
        return $result->getQuery()->getResult();
    }

    public function buscarPadresBecasCe($ClaveFamiliarId)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("sf.situacionfamiliarid,pt.padresotutoresid,CONCAT_WS(' ',pt.apellidopaterno,pt.apellidomaterno,pt.nombre) as nombre,t.descripcion as parentesco,pt.vive,pt.ocupacion,pt.especificacionocupacion,pt.ramo as puesto,pt.empresa,pt.horariotrabajo,pt.antiguedad,sc.situacionconyugalid,pt.telefono as celular,pt.telempresa,pt.extensionempresa,pt.fechanacimiento,e.escolaridadid,t.tutorid")
            ->from("AppBundle:CeClavefamiliar", 'cf')
            ->innerJoin("AppBundle:CePadresotutoresclavefamiliar", "ptcf", Expr\Join::WITH, "ptcf.clavefamiliarid = cf.clavefamiliarid ")
            ->innerJoin("AppBundle:CePadresotutores", "pt", Expr\Join::WITH, "pt.padresotutoresid=ptcf.padresotutoresid")
            ->leftJoin("AppBundle:Tutor", "t", Expr\Join::WITH, "t.tutorid=ptcf.tutorid")
            ->leftJoin("AppBundle:Situacionconyugal", "sc", Expr\Join::WITH, "sc.situacionconyugalid=pt.situacionconyugalid")
            ->leftJoin("AppBundle:CeSituacionfamiliar", "sf", Expr\Join::WITH, "sf.situacionfamiliarid=cf.situacionfamiliarid")
            ->leftJoin("AppBundle:Escolaridad", "e", Expr\Join::WITH, "e.escolaridadid=pt.nivelestudioid");
        $result->andWhere('cf.clavefamiliarid=:clavefamiliarid')
            ->setParameter('clavefamiliarid', $ClaveFamiliarId);
        $qb->setMaxResults(2);
        return $result->getQuery()->getResult();
    }


    public function SolicitudBecasLayout($filtros)
    {

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("
        s.solicitudid solicitudid,
        c.cicloid,
        (CASE WHEN (sep2.descripcion IS NOT NULL) THEN CONCAT(pbsep.descripcion, '%') else '' END) AS becasep,
        (CASE WHEN (idc2.descripcion IS NOT NULL) THEN CONCAT(pbidc.descripcion, '%') else '' END) AS becaidc,
        (CASE WHEN sep2.descripcion IS NULL THEN 'NVA' ELSE 'REF' END) AS tipobecasep,
        (CASE WHEN idc2.descripcion IS NULL THEN 'NVA' ELSE 'REF' END) AS tipobecaidc,
        a.matricula AS matricula,
        CONCAT(COALESCE(p.nombre, ''), ' ', COALESCE(p.apellidopaterno, ''), ' ', COALESCE(p.apellidomaterno, '')) AS Personal,
        CONCAT(COALESCE(a.primernombre, ''), ' ', COALESCE(a.segundonombre, ''), ' ', COALESCE(a.apellidopaterno, ''), ' ', COALESCE(a.apellidomaterno, '')) AS alumno,
        n.nombre AS nivel,
        gn.grado as gradoproximo,
        spa.calificacion AS calificacion,
        sf.alumnosidec AS alumnosidec,
        sf.estudiantestotales AS estudiantestotales,
        sf.miembrosfamilia AS miembrosfamilia,
        ef.estatus AS vivefamilia,
        GROUPCONCAT(DISTINCT pf.tipopropiedad, ' - ', ep.descripcion SEPARATOR ' \n ') AS propiedades,                                                                                                                                                                                                                                                                                 
        GROUPCONCAT(DISTINCT v.marcamodelo, ' - ', v.anio SEPARATOR ' \n ') AS vehiculos,                                                                                                                                                                                                                                                                                   
        si.ingresos AS ingresos,
        si.egresos AS egresos,
        (si.ingresos - si.egresos) AS saldo,
        (si.ingresos / sf.miembrosfamilia) AS percapita,
        s.observaciones as observacionesdocumentos,
        oese.observaciones AS observaciones,
        (CASE WHEN sepnueva.descripcion IS NOT NULL THEN CONCAT_WS(' ', pbd.descripcion, '%')  else '' END) AS sep,
        (CASE WHEN idcnueva.descripcion IS NOT NULL THEN CONCAT_WS(' ', pbd.descripcion, '%')  else '' END) AS idc
        ")
            ->from("AppBundle:BcSolicitudporalumno", "spa")
            ->innerJoin("spa.solicitudid", "s")
            ->innerJoin("s.cicloid", "c")
            ->leftJoin("AppBundle:BcBecas", "bsep", Expr\Join::WITH, "bsep.alumnoid = spa.alumnoid and bsep.tipobecaid = 3 and bsep.cicloid = (Select ca1.cicloid from AppBundle:Ciclo ca1 where ca1.actual = 1) and bsep.estatusid = 3")
            ->leftJoin("bsep.porcentajebecaid", "pbsep")
            ->leftJoin("AppBundle:BcTipobeca", "sep2", Expr\Join::WITH, "bsep.tipobecaid = sep2.tipobecaid")
            ->leftJoin("AppBundle:BcBecas", "bidc", Expr\Join::WITH, "bidc.alumnoid = spa.alumnoid and bidc.tipobecaid = 1 and bidc.cicloid = (Select ca2.cicloid from AppBundle:Ciclo ca2 where ca2.actual = 1) and bidc.estatusid = 3")
            ->leftJoin("bidc.porcentajebecaid", "pbidc")
            ->leftJoin("AppBundle:BcTipobeca", "idc2", Expr\Join::WITH, "bidc.tipobecaid = idc2.tipobecaid")
            ->leftJoin("spa.alumnoid", "a")
            ->leftJoin("AppBundle:CeAlumnoporpersonal", "app", Expr\Join::WITH, "app.alumnoid = spa.alumnoid")
            ->leftJoin("AppBundle:Persona", "p", Expr\Join::WITH, "p.personaid = app.personaid")
            ->leftJoin("AppBundle:CeAlumnoporciclo", "ac", Expr\Join::WITH, "ac.alumnoid = a.alumnoid")
            ->leftJoin("AppBundle:Grado", 'gn', Expr\Join::WITH, "gn.gradoid = spa.gradoiddestino")
            ->leftJoin("gn.nivelid", "n")
            ->leftJoin("AppBundle:BcSolicitudfamilia", "sf", Expr\Join::WITH, "sf.solicitudid = spa.solicitudid")
            ->leftJoin("sf.vivefamilia", "ef")
            ->leftJoin("AppBundle:BcVehiculos", "v", Expr\Join::WITH, "v.solicitudid = spa.solicitudid and v.portal = 2")
            ->leftJoin("AppBundle:BcSolicitudingresos", "si", Expr\Join::WITH, "si.solicitudid = spa.solicitudid")
            ->leftJoin("AppBundle:BcObservacionesestudiose", "oese", Expr\Join::WITH, "oese.solicitudid = spa.solicitudid")
            ->leftJoin("AppBundle:BcPropiedadesfamiliares", "pf", Expr\Join::WITH, "pf.solicitudid = spa.solicitudid and pf.portal = 2")
            ->leftJoin("pf.estatusid", "ep")
            ->leftJoin("AppBundle:BcSolicitudbecadictamen", "sbd", Expr\Join::WITH, "sbd.solicitudid = spa.solicitudid")
            ->leftJoin("sbd.porcentajebecaid", "pbd")
            ->leftJoin("AppBundle:BcTipobeca", "sepnueva", Expr\Join::WITH, "sbd.tipobecaid = sepnueva.tipobecaid and sepnueva.tipobecaid = 3")
            ->leftJoin("AppBundle:BcTipobeca", "idcnueva", Expr\Join::WITH, "sbd.tipobecaid = idcnueva.tipobecaid and idcnueva.tipobecaid = 1")
            ->where("spa.estatusid in (1,4)")
            ->groupBy("spa.alumnoid");


        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid = ' . $filtros['cicloid']);
        }

        return $result->getQuery()->getResult();
    }
}
