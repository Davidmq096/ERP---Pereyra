<?php

namespace AppBundle\DB\Mysql;

/**
 * Description of documento
 *
 * @author Javier
 */
class DocumentoDB extends BaseDBManager {
    
    public function getDocumentosParaFacturacionByPadreOTutorId($id, $empresaid)
    {
        $qb = $this->em->createQueryBuilder();
        
        $recargo = $qb->select("p.valor")
            ->from("AppBundle:Parametros", 'p');

            $qb->andWhere("p.nombre = 'Subconcepto de pago de intereses'");
        
        $recargoid = $recargo->getQuery()->getResult()[0];
        
        $qb = $this->em->createQueryBuilder();
        $descuento = $qb->select("p.valor")
            ->from("AppBundle:Parametros", 'p');

            $qb->andWhere("p.nombre = 'SubConceptoDescuentoInscripcion'");
        
        $descuentoid = $descuento->getQuery()->getResult()[0];
    
        $sql = "SELECT p.pagoid, p.importe, a.alumnoid, a.matricula, DATE_FORMAT(p.fecha, '%Y-%m-%d') fecha, CONCAT_WS(' ', a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) alumno, 
                                sum(pd.iva) iva, f.facturaid, fe.facturaestatusid, fe.nombre facturaestatus,
                                n.nivelid,
                                pt.padresotutoresid,
                                SUM((CASE WHEN pd.subconceptoid = ".$descuentoid['valor']." THEN pd.importe ELSE 0 END)) AS descuento, 
                                SUM(CASE WHEN pd.subconceptoid = ".$recargoid['valor']." THEN pd.importe ELSE 0 END) AS intereses, SUM(CASE WHEN pd.subconceptoid != 8 AND pd.subconceptoid != 9 THEN pd.importe ELSE 0 END) AS subtotal,
                                CASE WHEN fin.PagoId IS NULL THEN true ELSE false END AS facturahabilitada
                  FROM cj_pago p
                  INNER JOIN ce_alumno a ON a.alumnoid = p.alumnoid
                  INNER JOIN ce_alumnoporclavefamiliar ca ON ca.alumnoid = a.alumnoid
                  INNER JOIN ce_padresotutoresclavefamiliar cp ON cp.clavefamiliarid = ca.clavefamiliarid
                  INNER JOIN ce_padresotutores pt ON pt.padresotutoresid = cp.padresotutoresid
                  INNER JOIN cj_pagodetalle pd ON pd.pagoid = p.pagoid
                  INNER JOIN cj_subconcepto sc ON sc.subconceptoid = pd.subconceptoid
                  INNER JOIN cj_concepto c ON c.conceptoid = sc.conceptoid
                  INNER JOIN cj_pagoformapago pfp ON p.pagoid = pfp.pagoid AND pfp.formapagoid <> 7
                  INNER JOIN cj_documentoporpagar dp ON dp.documentoporpagarid = pd.documentoporpagarid
                  LEFT JOIN cj_factura f ON f.pagoid = p.pagoid
                  LEFT JOIN cj_facturaestatus fe ON fe.facturaestatusid = f.facturaestatusid
                  LEFT JOIN fo_fondoorfandad fo ON fo.alumnoid = a.alumnoid
                  LEFT JOIN ce_alumnoporciclo ac ON ac.alumnoid = p.alumnoid AND ac.cicloid = p.cicloid AND ac.gradoid = dp.gradoid
                  LEFT JOIN grado g ON g.gradoid = ac.gradoid
                  LEFT JOIN nivel n ON n.nivelid = g.nivelid
                  LEFT JOIN cj_pagofacturainhabilitada fin ON fin.pagoid = p.pagoid
                  WHERE sc.facturable = 1 and (p.pagoestatusid = 2 OR p.pagoestatusid = 4 OR p.pagoestatusid = 0) AND pt.padresotutoresid=".$id." AND (fo.alumnoid IS NULL OR fe.facturaestatusid IS NOT NULL OR fo.estatusid = 2
                  OR (p.fecha <= fo.fechainicio)) AND c.empresaid = ".$empresaid." AND p.pagoid NOT IN (SELECT pagoid FROM cj_factura WHERE facturaestatusid = 4 )
                  GROUP BY p.folio, pd.pagoid, fe.facturaestatusid";
        
        
        $qb = $this->em->getConnection();
        $stmt = $qb->prepare($sql);
        $stmt->execute();
        $pagos = $stmt->fetchAll();

        return $pagos;
    }
    
    ///BORRARA
    public function GetConceptoPago($id)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("td.tipodocumentoid as tipodocumento")
            ->from("AppBundle:CjPago", 'p')                
            ->innerJoin('AppBundle:CjPagodetalle', 'pd', \Doctrine\ORM\Query\Expr\Join::WITH, 'pd.pagoid = p.pagoid')
            ->innerJoin('AppBundle:CjDocumentoporpagar', 'dp', \Doctrine\ORM\Query\Expr\Join::WITH, 'dp.documentoporpagarid = pd.documentoporpagarid')
            ->leftJoin('AppBundle:CjDocumento', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'd.documentoid = dp.documentoid')
            ->leftJoin('d.tipodocumento', 'td');

            $qb->andWhere('p.pagoid='.$id);
         
        
        $respuesta = $result->getQuery()->getResult();
        
        
        foreach($respuesta as &$concepto)
        {
            if($concepto['tipodocumento'] == 2)
            {
                return "COLEGIATURA";
            }
        }
        
        foreach($respuesta as &$concepto)
        {
            if($concepto['tipodocumento'] == 1)
            {
                return "INSCRIPCIÓN";
            }
        }
        
        //return $respuesta;
        
        return "PAGOS DIVERSOS";
        
    }
    
    public function getAlumnosDocumentosPorPagarByAlumnoId($id,$IsInsCol)
    {
           $qb = $this->em->createQueryBuilder();
           $result = $qb->select('a')
                ->from("AppBundle:CjDocumentoporpagar", 'a')
                ->innerJoin('AppBundle:CjDocumento', 'b', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.documentoid=b.documentoid');
                $qb->andWhere('a.pagoestatusid=1');
                if($IsInsCol)
                    $qb->andWhere('b.tipodocumento in (1,2)');
                else
                    $qb->andWhere('b.tipodocumento not in (1,2)');
            $qb->andWhere('a.alumnoid = :alumnoid');
            $qb->orderBy('a.fechalimitepago','asc');
            $qb->setParameter('alumnoid', $id);
            return $result->getQuery()->getResult();            
    }    
    
    public function getAlumnosDocumentosPorPagarByPadreOTutorId($id,$IsInsCol)
    {
           $qb = $this->em->createQueryBuilder();
           $result = $qb->select('a')
                ->from("AppBundle:CjDocumentoporpagar", 'a')
                ->innerJoin('AppBundle:CjDocumento', 'b', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.documentoid=b.documentoid')
                ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.alumnoid=a.alumnoid')
                ->innerJoin('AppBundle:CePadresotutoresclavefamiliar', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.clavefamiliarid=d.clavefamiliarid');
                $qb->andWhere('a.pagoestatusid=1');
                if($IsInsCol)
                    $qb->andWhere('b.tipodocumento in (1,2)');
                else
                    $qb->andWhere('b.tipodocumento not in (1,2)');
            $qb->andWhere('d.padresotutoresid = :padresotutoresid');
            $qb->orderBy('a.fechalimitepago','asc');
            $qb->setParameter('padresotutoresid', $id);
            return $result->getQuery()->getResult();            
    }
    
    public function getDocumentosPagadosByAlumnoId($id)
    {
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("a")
                ->from("AppBundle:CjDocumentoporpagar", 'a')
                ->leftJoin('AppBundle:CjReldocumentoporpagardatofacturacion', 'e', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.documentoporpagarid=e.documentoporpagarid');
                $qb->andWhere('a.pagoestatusid=2');
                $qb->andWhere('a.alumnoid = :alumnoid');
                $qb->orderBy('a.fechalimitepago','asc');
                $qb->setParameter('alumnoid', $id);
            return $result->getQuery()->getResult();
    }
    
    public function getDocumentosPagadosByPadreOTutorId($id)
    {
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("a")
                ->from("AppBundle:CjDocumentoporpagar", 'a')
                ->innerJoin('AppBundle:CeAlumno', 'g', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.alumnoid=g.alumnoid')
                ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'b', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.alumnoid=b.alumnoid')
                ->innerJoin('AppBundle:CeClavefamiliar', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'b.clavefamiliarid = c.clavefamiliarid')
                ->innerJoin('AppBundle:CePadresotutoresclavefamiliar', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.clavefamiliarid=d.clavefamiliarid')
                ->leftJoin('AppBundle:CjReldocumentoporpagardatofacturacion', 'e', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.documentoporpagarid=e.documentoporpagarid');
                $qb->andWhere('a.pagoestatusid=2');
                $qb->andWhere('d.padresotutoresid= :padresotutoresid');
                $qb->orderBy('a.fechalimitepago','asc');
                $qb->setParameter('padresotutoresid', $id);
            return $result->getQuery()->getResult();
    }     
    
    public function getDocumentosPorPagarPorDocumento($documento, $alumnoid, $cicloid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("dp")
            ->from("AppBundle:CjDocumentoporpagar", 'dp');
            $qb->andWhere('dp.documento = :documento');
            $qb->andWhere('dp.alumnoid = :alumnoid');
            $qb->andWhere('dp.cicloid = :cicloid');
            $qb->setParameter('documento', $documento);
            $qb->setParameter('alumnoid', $alumnoid);
            $qb->setParameter('cicloid', $cicloid);
        return $result->getQuery()->getResult();
    }     
}
