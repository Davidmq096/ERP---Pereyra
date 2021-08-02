<?php

namespace AppBundle\DB\Mysql\Cobranza;

use Doctrine\ORM\Query\Expr;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Acuerdoss
 *
 * @author David
 */
class AlumnoAcuerdoDB extends BaseDBManager
{

    public function BuscarConveniosAlumno($filtros)
    {
        $gradoactual = $this->em->createQueryBuilder()->select('CASE WHEN
        CURRENT_TIMESTAMP() >= cn.fechainicios2 THEN max(g2.gradoid)
        ELSE min(g2.gradoid) END')
            ->from("AppBundle:CeAlumnoporciclo", "ac2")
            ->innerJoin("ac2.gradoid", "g2")
            ->innerJoin("ac2.cicloid", "c2", Expr\Join::WITH, "ac2.cicloid = :cicloid")
            ->innerJoin("AppBundle:CeCiclopornivel", "cn", Expr\Join::WITH, "g2.nivelid = cn.nivelid and cn.cicloid = c2.cicloid")
            ->where("a.alumnoid = ac2.alumnoid");

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.nombre as ciclo, n.nombre as nivel, g.grado as grado, 
        a.alumnoid,a.matricula, concat_WS(' ', a.apellidopaterno, a.apellidomaterno, a.primernombre, a.segundonombre) as alumno,
        CASE WHEN ae1.estatusalumnoporcicloid is null then 'NO INSCRITO' ELSE 'INSCRITO' END as estatusalumno,
        CASE WHEN sum(cd.saldo) = sum(cd.importe)  THEN 'PENDIENTE' 
        WHEN sum(cd.saldo) = 0 ELSE 'PAGADO' ELSE 'PAGO PARCIAL' END as pagado,
        CASE WHEN count(acu.acuerdoid) > 0 THEN 'SI' ELSE 'NO' END as acuerdo,
        GROUPCONCAT(DISTINCT dptd.nombre ORDER BY dptd.tipodocumentoid separator ', ') as tipodocumento
            ")
            ->from("AppBundle:CeAlumno", 'a')
            ->innerJoin("AppBundle:CeAlumnoporciclo", 'ac', Expr\Join::WITH, "a.alumnoid = ac.alumnoid and ac.gradoid = (" . $gradoactual . ") and ac.cicloid = :cicloid")
            ->leftJoin("ac.estatusalumnocicloid", "ae1")
            ->innerJoin("ac.cicloid", "c")
            ->innerJoin("ac.gradoid", "g")
            ->innerJoin("g.nivelid", "n")
            ->innerJoin("AppBundle:CjDocumentoporpagar", "cd", Expr\Join::WITH, "cd.alumnoid = a.alumnoid and ac.cicloid = cd.cicloid")
            ->innerJoin("cd.documentoid", "doc")
            ->innerJoin("cd.pagoestatusid", "pe")
            ->innerJoin("doc.tipodocumento", "td")

            ->leftJoin("AppBundle:CbAcuerdo", "acu", Expr\Join::WITH, "cd.acuerdoid = acu.acuerdoid and acu.estatusacuerdoid = 1 and CAST(acu.vigenciainicio AS date) <= CAST(CURRENT_DATE() AS date) and CAST(acu.vigenciafin AS date) >= CAST(CURRENT_DATE() AS date)")
            ->leftJoin('AppBundle:CjDocumentoporpagar','dp', Expr\Join::WITH, 'acu.acuerdoid = dp.acuerdoid')
            ->leftJoin("dp.documentoid", "dpdoc")
            ->leftJoin("dpdoc.tipodocumento", "dptd")

            ->where("a.alumnoestatusid = 1")
            ->andWhere('td.tipodocumentoid = 1')
            ->andWhere("REGEXP(cd.documento, :regexp) = true")
            ->setParameter('regexp', '....00.*')
            ->setParameter('cicloid', $filtros['cicloid'])
            ->groupBy("a.alumnoid, c.cicloid, cd.documento");
        if (count($filtros['nivelid']) > 0) {
            $result->andWhere('n.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filtros['nivelid']);
        }
        if (count($filtros['gradoid']) > 0) {
            $result->andWhere('g.gradoid = :gradoid')
                ->setParameter('gradoid', $filtros['gradoid']);
        }
        if ($filtros['estatusalumno'] == 1) {
            $result->andWhere("ae1.estatusalumnoporcicloid is not null ");
        } else if ($filtros['estatusalumno'] == 2) {
            $result->andWhere("ae1.estatusalumnoporcicloid is null");
        }

        if ($filtros['convenio'] == 1) {
            $result->having("count(acu.acuerdoid) > 0");
        } else if ($filtros['convenio'] == 2) {
            $result->having("count(acu.acuerdoid) = 0");
        }

        if (isset($filtros['matricula'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filtros['matricula'] = str_replace($escape, $escapados, $filtros['matricula']);
            if ($filtros["precision"]) {
                $result->andWhere('a.matricula in (:matricula)')
                    ->setParameter('matricula', $filtros['matricula']);
            } else {
                $result->andWhere('a.matricula like :matricula')
                    ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
            }
        }

        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }
}
