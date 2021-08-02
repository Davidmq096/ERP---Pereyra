<?php

namespace AppBundle\DB\Mysql\Cobranza;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Ciclo
 *
 * @author Mariano
 */
class PagosDiversosDB extends BaseDBManager {

    public function getUsuarioporsubconcepto(){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("GroupConcat(s.nombre) subconceptos,GroupConcat(s.subconceptoid) subconceptosid,p.nombre,p.apellidopaterno,p.apellidomaterno,concat(p.nombre,' ',p.apellidopaterno,' ',p.apellidomaterno) nombrecompleto,u.usuarioid")
        ->from('AppBundle:CjUsuarioporsubconcepto','us')
        ->innerJoin('us.subconceptoid','s')
        ->innerJoin('us.usuarioid','u')
        ->innerJoin('u.personaid','p')
        ->innerJoin('u.tipousuarioid','t');

        //$result->where('t.tipousuarioid = 2');
        $result->groupBy('u.usuarioid');
        $usuarios = $result->getQuery()->getResult();
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("s.nombre,s.subconceptoid,s.importe,s.unsolocargo,s.capturarcantidad,s.fincobro,s.inicioasignacion,s.finasignacion")
        ->from('AppBundle:CjUsuarioporsubconcepto','us')
        ->innerJoin('us.subconceptoid','s')
        ->innerJoin('us.usuarioid','u')
        ->innerJoin('u.personaid','p')
        ->innerJoin('u.tipousuarioid','t');

        //$result->where('t.tipousuarioid = 2');
        $result->groupBy('s.subconceptoid');
        $subconeptos = $result->getQuery()->getResult();

        return [$usuarios, $subconeptos];
    }
    
    public function getSubconceptoPorNivel($subconceptoid){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("n.nivelid,sn.importe,sn.descuentobeca,sn.descuentoprontopago,sn.importeminimo,sn.importedescuentoprontopago,sn.fechalimitepago")
        ->from('AppBundle:CjSubconceptopornivel','sn')
        ->innerJoin('sn.subconceptoid','s')
        ->innerJoin('sn.nivelid','n');

        $result->where('s.subconceptoid = :subconceptoid')
        ->setParameter('subconceptoid',$subconceptoid);
        return $result->getQuery()->getResult();
    }

    public function getAlumnosPorSubconcepto($filtros){
        $conn = $this->em->getConnection();
        $subconcepto = '';
        if($filtros['subconceptoid']){
            $subconcepto = ',dp.importe, (dp.saldo - dp.descuento) as saldo,pa.nombre estatuspago,dp.documentoporpagarid,pa.pagoestatusid';
        }
        $sql = "SELECT concat(a.apellidopaterno,' ',a.apellidomaterno,' ',a.primernombre,' ',IFNULL(a.segundonombre,'')) alumno,a.matricula,a.alumnoid,g.grupoid,g.nombre grupo,gr.gradoid,gr.grado,n.nivelid,n.nombre nivel ". $subconcepto ."
        FROM ce_alumnociclogradovigente av
        inner join ce_alumno a on a.alumnoid = av.alumnoid
        inner join ce_alumnoporciclo ac on ac.cicloid = av.cicloid and ac.alumnoid = av.alumnoid
        inner join ce_alumnocicloporgrupo acg on acg.alumnoporcicloid = ac.alumnoporcicloid
        inner join ce_grupo g on acg.grupoid = g.grupoid and g.tipogrupoid = 1
        inner join grado gr on gr.gradoid = ac.gradoid
        inner join nivel n on n.nivelid = gr.nivelid";

        if($filtros['subconceptoid']){
            if($filtros['inner']){
                $sql .= " inner join cj_documentoporpagar dp on dp.alumnoid = a.alumnoid and dp.subconceptoid = " . $filtros['subconceptoid'] . " ";
                $sql .= " inner join cj_pagoestatus pa on pa.pagoestatusid = dp.pagoestatusid";
            }else{
                $sql .= " left join cj_documentoporpagar dp on dp.alumnoid = a.alumnoid and dp.subconceptoid = " . $filtros['subconceptoid']  . " ";
                $sql .= " left join cj_pagoestatus pa on pa.pagoestatusid = dp.pagoestatusid";
            }
        }

        $sql .= " where 1=1";

        $parameters = [];
        
        if($filtros['alumnos']){
            $sql .= " and a.alumnoid in(". $filtros['alumnos'] .")";
        }

        if($filtros['matriculas']){
            $sql .= " and a.matricula in(". $filtros['matriculas'] .")";
        }

        if($filtros['grupoid']){
            $sql .= " and g.grupoid = :grupoid";
            $parameters['grupoid'] = $filtros['grupoid'];
        }
        if($filtros['cicloid']){
            $sql .= " and ac.cicloid = :cicloid";
            $parameters['cicloid'] = $filtros['cicloid'];
        }

       
        $sql .= " group by a.alumnoid";
        $stmt = $conn->prepare($sql);
		$stmt->execute($parameters);
		$result = $stmt->fetchAll();
		return $result;
    }
    
    public function getDocumentosPorPagar($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("pa.descripcion,s.nombre subconcepto,s.subconceptoid,GroupConcat(a.alumnoid) alumnos, s.permiteeditarimporte, s.importe,pa.pagodiversoid")
        ->from('AppBundle:CjPagosdiversos','pa')
        ->innerJoin('AppBundle:CjDocumentoporpagar','dp',Expr\Join::WITH,'dp.pagodiversoid = pa.pagodiversoid')
        ->innerJoin('dp.subconceptoid','s')
        ->innerJoin('dp.alumnoid','a')
        ->leftJoin('AppBundle:CjUsuarioporsubconcepto','us',Expr\Join::WITH,'us.subconceptoid = s.subconceptoid')
        ->leftJoin('us.usuarioid','u')
        ->groupBy('s.subconceptoid ');

        if(!empty($filtros['usuarioid'])){
            $result->andWhere('u.usuarioid = :usuarioid')
            ->setParameter('usuarioid', $filtros['usuarioid']);
        }
        if($filtros['subconceptos']){
            $result->andWhere('s.subconceptoid in(:subconceptos)')
            ->setParameter('subconceptos', $filtros['subconceptos']);
        }      
        return $result->getQuery()->getResult();
    }
}
