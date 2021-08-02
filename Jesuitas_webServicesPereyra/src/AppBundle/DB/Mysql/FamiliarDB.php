<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Descripción of FamiliarDB
 *
 * @author inceptio
 */
class FamiliarDB extends BaseDBManager 
{
    public function BuscarPadrePorApellido($filtros) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('pt')
        ->from("AppBundle:CePadresotutores", 'pt')
        ->innerJoin('AppBundle:CePadresotutoresclavefamiliar', 'ptcf', \Doctrine\ORM\Query\Expr\Join::WITH, 'ptcf.padresotutoresid=pt.padresotutoresid');
        $qb->andWhere('ptcf.clavefamiliarid = (:clavefamiliarid)')
        ->setParameter('clavefamiliarid' , $filtros['clavefamiliarid']);
        if ($filtros["padremadreotutor"]==1){
            $qb->andWhere('ptcf.tutorid = 1');
            $qb->andWhere('pt.apellidopaterno = COLLATE( :apellidopaterno , utf8_spanish_ci ) ')
            ->setParameter('apellidopaterno' , $filtros['apellidopaterno']);
        }
        if ($filtros["padremadreotutor"]==2){
            $qb->andWhere('ptcf.tutorid = 2');
            $qb->andWhere('pt.apellidopaterno = COLLATE( :apellidopaterno , utf8_spanish_ci )')
            ->setParameter('apellidopaterno' , $filtros['apellidopaterno']);
        }
        if ($filtros["padremadreotutor"]==3){
            $qb->andWhere('ptcf.tutorid not in  (1,2)');
           $qb->andWhere('(pt.apellidopaterno = COLLATE( :apellidopaterno , utf8_spanish_ci ) or pt.apellidomaterno = COLLATE( :apellidopaterno , utf8_spanish_ci )) or (pt.apellidopaterno = COLLATE( :apellidomaterno , utf8_spanish_ci ) or pt.apellidomaterno = COLLATE( :apellidomaterno , utf8_spanish_ci ))')
            ->setParameter('apellidopaterno' , $filtros['apellidopaterno'])
            ->setParameter('apellidomaterno' , $filtros['apellidopaterno']);
        }
        return $result->getQuery()->getResult();
    }

    public function BuscarAlumnosMismaFamilia($filtros) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('cf.clavefamiliarid,cf.apellidopaterno,cf.apellidomaterno')
        ->from("AppBundle:CeAlumno", 'a')
        ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'acf', \Doctrine\ORM\Query\Expr\Join::WITH, 'acf.alumnoid=a.alumnoid')
        ->innerJoin('AppBundle:CeClavefamiliar', 'cf', \Doctrine\ORM\Query\Expr\Join::WITH, 'cf.clavefamiliarid=acf.clavefamiliarid');
        $qb->andWhere('a.matricula in (:matricula)')
        ->setParameter('matricula' , $filtros['matricula']);
        $qb->groupBy('cf.clavefamiliarid');
        return $result->getQuery()->getResult();
    }
    
    public function getDatosFacturacion($id) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('p.padresotutoresid, f.tipopersonaid, f.rfc, f.razonsocial, f.correo, f.padresotutoresfacturacionid,
                               f.esautomaticacolegiatura, f.esautomaticaotros, f.padresotutoresfacturacionid, 
                               d.calle,d.numeroexterior,d.numerointerior,d.colonia,d.ciudad,d.codigopostal,d.observaciones,
                               d.padresotutoresdomicilioid,e.estadoid as estado')
                ->from("AppBundle:CePadresotutoresfacturacion", 'f')
                ->leftJoin('AppBundle:CePadresotutoresdomicilio', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'f.padresotutoresdomicilioid = d.padresotutoresdomicilioid')
                ->leftJoin('AppBundle:Municipio', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'd.ciudad=c.municipioid')
                ->leftJoin('AppBundle:Estado', 'e', \Doctrine\ORM\Query\Expr\Join::WITH, 'e.estadoid=c.estadoid')
                ->leftJoin('AppBundle:CePadresotutores', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p.padresotutoresid = d.padresotutoresid');
        $qb->andWhere('f.activo = 1');
        $qb->andWhere('f.padresotutoresid = :padresotutoresid');
        $qb->setParameter('padresotutoresid', $id);
        
        $qb->orderBy('f.rfc','asc');
        
        return $result->getQuery()->getResult();
    }

    public function getAlumnosByPadreOTutorId($id, $filtros) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('d')
                ->from("AppBundle:CePadresotutoresclavefamiliar", 'a')
                ->innerJoin('AppBundle:CeClavefamiliar', 'b', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.clavefamiliarid = b.clavefamiliarid')
                ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'b.clavefamiliarid= c.clavefamiliarid')
                ->innerJoin('AppBundle:CeAlumno', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.alumnoid=d.alumnoid');
        $qb->andWhere('a.padresotutoresid = :padresotutoresid');
        $qb->setParameter('padresotutoresid', $id);
        if(!$filtros['consultainactivos']) {
            $qb->andWhere('d.alumnoestatusid != 2');
        }
        return $result->getQuery()->getResult();
    }    

    public function getReporteByAlumno($id) {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('r')
        ->from("AppBundle:CeReportedisciplina", 'r')
        ->innerJoin('AppBundle:CeAlumnoporciclo', 'ac', \Doctrine\ORM\Query\Expr\Join::WITH, 'ac.alumnoporcicloid = r.alumnoporcicloid')
        ->orderBy('r.reportedisciplinaid');
        $qb->andWhere('ac.alumnoporcicloid = :alumnoid');
        $qb->setParameter('alumnoid', $id);
        return $result->getQuery()->getResult();
    }  
    
    public function BuscarAlumnosPorFamilias($filtros) {    	
        $qb = $this->em->createQueryBuilder();        
        $result = $qb->select('ac, a, f')
        ->addSelect("(SELECT COUNT(b) FROM AppBundle:CeAlumnoporclavefamiliar b WHERE b.clavefamiliarid = ac.clavefamiliarid group by b.clavefamiliarid) as numalum")
        ->from("AppBundle:CeAlumnoporclavefamiliar", 'ac')
        ->innerJoin('ac.alumnoid', 'a')
        ->innerJoin("ac.clavefamiliarid", "f");           
        if (isset($filtros['matricula'])) {
            $result->andWhere('a.matricula like :matricula')
                    ->setParameter('matricula', '%' . $filtros['matricula'] . '%');
        }
        if (isset($filtros['apellidopaterno'])) {
            $result->andWhere('f.apellidopaterno like :apellidopaterno')
                    ->setParameter('apellidopaterno', '%' . $filtros['apellidopaterno'] . '%');
        }
        if (isset($filtros['apellidomaterno'])) {
            $result->andWhere('f.apellidomaterno like :apellidomaterno')
                    ->setParameter('apellidomaterno', '%' . $filtros['apellidomaterno'] . '%');
        };
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }
    
    public function getAlumnosPEG($id) 
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("a.alumnoid, Date_Format(fo.fechainicio, '%Y-%m-%d') fechainicio, CONCAT_WS(' ', a.primernombre, a.segundonombre, a.apellidopaterno, a.apellidomaterno) nombre")
                ->from("AppBundle:CeAlumno", 'a')
                ->innerJoin('AppBundle:CeAlumnoporclavefamiliar', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.alumnoid = c.alumnoid')
                ->innerJoin('AppBundle:CePadresotutoresclavefamiliar', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p.clavefamiliarid = c.clavefamiliarid')
                ->innerJoin('AppBundle:FoFondoorfandad', 'fo', \Doctrine\ORM\Query\Expr\Join::WITH, 'fo.alumnoid = a.alumnoid');
        $qb->andWhere('fo.estatusid = 1');
        $qb->andWhere('p.padresotutoresid = :padresotutoresid');
        $qb->setParameter('padresotutoresid', $id);
        $qb->orderBy('nombre','asc');

        return $result->getQuery()->getResult();
    }    

}
