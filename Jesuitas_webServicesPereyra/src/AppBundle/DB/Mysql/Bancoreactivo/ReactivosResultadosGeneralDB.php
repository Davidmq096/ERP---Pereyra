<?php
namespace AppBundle\DB\Mysql\Bancoreactivo;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of CupoAdmision
 *
 * @author Javier Manrique
 */
class ReactivosResultadosGeneralDB extends BaseDBManager
{

    public function BuscarReactivosResultados($filtros)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("CASE WHEN a.alumnoid IS NULL THEN tu.nombre ELSE 'Interno' END as tipousuario, 
        CASE WHEN a.alumnoid IS NULL THEN u.usuario ELSE a.matricula END as usuario, c.nombre as colegio, e.nombre as examen,count(r.reactivoid) reactivos, sum(r.valor) as puntajemaximo, ue.puntaje, ue.calificacion, DATE_FORMAT(ue.fecha,'%d/%m/%Y') fecha, ue.usuarioporexamenid,
            case when tu.tipousuarioexternoid = 1 then d.nombre 
            when tu.tipousuarioexternoid = 2 then u.nombre 
            else a.primernombre end nombre,
            case when tu.tipousuarioexternoid = 1 then d.apellidopaterno 
            when tu.tipousuarioexternoid = 2 then u.apellidopaterno 
            else a.apellidopaterno end apellidopaterno,
            case when tu.tipousuarioexternoid = 1 then d.apellidomaterno 
            when tu.tipousuarioexternoid = 2 then u.apellidomaterno
            else a.apellidomaterno end apellidomaterno")
            ->from("AppBundle:BrUsuarioporexamen", 'ue')
            ->innerJoin("ue.examenporcalendarioid", "ec")
            ->innerJoin("ec.calendarioexamenid", "ce")
            ->innerJoin('ec.examenid', 'e')
            ->leftJoin('AppBundle:BrReactivoporexamen', 're', Expr\Join::WITH, 'e.examenid = re.examenid')
            ->innerJoin('re.reactivoid', 'r')
            ->leftJoin("e.gradoid", "g")

            ->leftJoin('ue.alumnoid', 'a')

            ->leftJoin('ue.usuarioexternoid', 'u')
            ->leftJoin('u.tipousuarioexternoid', 'tu')
            ->leftJoin('u.colegioid', 'c')
            ->leftJoin('u.solicitudadmisionid', 's')
            ->leftJoin('s.datoaspiranteid', 'd')

            //->leftJoin('AppBundle:BrRespuestaporusuario', 'ru', Expr\Join::WITH, 'ue.usuarioporexamenid = ru.usuarioexamenid')
            //->leftJoin('AppBundle:BrRespuestaporreactivo', 'rr', Expr\Join::WITH, 'ru.respuestaid = rr.respuestaporreactivoid')

            ->groupBy('ec.examenporcalendarioid, ue.usuarioporexamenid');
        if (isset($filtros['examenporcalendarioid'])) {
            $result->andWhere('ec.examenporcalendarioid =' . $filtros['examenporcalendarioid']);
        }else{
            $result->andWhere('ue.aplicado = true');
        }
        if (isset($filtros['cicloid'])) {
            $result->andWhere('ce.cicloid =' . $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
            $result->andWhere('g.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
            $result->andWhere('g.gradoid IN (:gradosid)')
                ->setParameter('gradosid', $filtros['gradoid']);
        }
        if (isset($filtros['colegioid'])) {
            $result->andWhere('u.colegioid =' . $filtros['colegioid']);
        }
        if (isset($filtros['areaid'])) {
            $result->andWhere('e.areaid =' . $filtros['areaid']);
        }
        if (isset($filtros['materiaid'])) {
            $result->andWhere('e.materiaid =' . $filtros['materiaid']);
        }
        if (isset($filtros['tipoexamenid'])) {
            $result->andWhere('e.tipoexamenid =' . $filtros['tipoexamenid']);
        }
        if (isset($filtros['examenid'])) {
            $result->andWhere('e.examenid IN (:examenid)')
                ->setParameter('examenid', $filtros['examenid']);
        }
        $result = $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);

        return $result;
    }

    public function BuscarReactivosResultadosDetalle($id)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('r.descripcion as pregunta, 
        rr.descripcion as correcta, rrx.descripcion as seleccionada, rrx.correcta as cal,
        ru.respuestaporusuarioid, ru.respuestatext, r.valor, ru.puntaje,    
        tr.tiporeactivoid')
            ->from("AppBundle:BrUsuarioporexamen", 'ue')
            ->innerJoin("ue.examenporcalendarioid", "ec")
            ->innerJoin('ec.examenid', 'e')
            ->leftJoin('AppBundle:BrReactivoporexamen', 're', Expr\Join::WITH, 'e.examenid = re.examenid')
            ->innerJoin('re.reactivoid', 'r')
            ->innerJoin('r.tiporeactivoid', 'tr')

            ->leftJoin('AppBundle:BrRespuestaporreactivo', 'rr', Expr\Join::WITH, 'r.reactivoid = rr.reactivoid and rr.correcta = true')
            ->leftJoin('AppBundle:BrRespuestaporusuario', 'ru', Expr\Join::WITH, 'r.reactivoid = ru.reactivoid and ue.usuarioporexamenid = ru.usuarioexamenid')
            ->leftJoin('AppBundle:BrRespuestaporreactivo', 'rrx', Expr\Join::WITH, 'ru.respuestaid = rrx.respuestaporreactivoid ')

            ->where('ue.usuarioporexamenid =' . $id)
            ->groupBy('ue.usuarioporexamenid, e.examenid, r.reactivoid')
            ->orderBy('re.reactivoporexamenid');
        $result = $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);

        return $result;

    }
}
