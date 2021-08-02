<?php

namespace AppBundle\DB\Mysql\Becas;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Filtrado de becas
 *
 * @author David
 */
class TrabajadoraSocialDB extends BaseDBManager
{


    public function BuscarSolicitudesTrabjadoraSocialBecas($filtros)
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
        GroupConcat(p.descripcion) porcentaje, cf.clave, 
        psep.descripcion as sep, pidec.descripcion as idc, pexec.descripcion as excelencia,
        GroupConcat(DISTINCT CONCAT_WS(' ',a.matricula,'-', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) separator '<br>') nombre, 
        eac2.nombre as estatusalumnociclo,
        CASE WHEN sae.estatusid is not null then sae.descripcion else e.descripcion as estatussbeca,
        CONCAT_WS(' ', cf.apellidopaterno, cf.apellidomaterno) familia,
        us.usuarioid,
        CONCAT_WS(' de ', go.grado,no.nombre) gradoorigen,
        CONCAT_WS(' de ', gd.grado,nd.nombre) gradodestino,
        CONCAT_WS(' ', per.apellidopaterno, per.apellidomaterno, per.nombre) persona,
        CASE WHEN calculaAdeudo(a.alumnoid) > 0 THEN 'Con adeudo' ELSE 'Sin adeudo' END cobranza,
        CASE WHEN s.hijodepersonal = 1 THEN 'SI' ELSE 'NO' END eshijopersonal, s.pagado")
            ->from('AppBundle:BcSolicitudbeca', 's')
            ->innerJoin('s.cicloid', 'c')
            ->innerJoin('s.estatusid', 'e')
            ->leftJoin('s.usuarioid', 'us')
            ->leftJoin('us.personaid', 'per')
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
            /* Se comenta porque es necesario visualizar todas las solicitudes */
            /*->andWhere('(sae.estatusid is not null and sae.estatusid in (3,4))
                     or (sae.estatusid is null and e.estatusid in (3,4))')*/

            ->groupBy('s.solicitudid');
        if (isset($filtros['cicloid'])) {
            $result->andWhere('c.cicloid IN (:cicloid)')
                ->setParameter('cicloid', $filtros['cicloid']);
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
}