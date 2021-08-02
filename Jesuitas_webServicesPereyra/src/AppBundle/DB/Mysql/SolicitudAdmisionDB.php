<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql;

use Doctrine\ORM\Query\Expr;

/**
 * Description of SolicitudAdmisionDB
 *
 * @author inceptio
 */
class SolicitudAdmisionDB extends BaseDBManager
{
    /*
     * Metodo para obtener los estados (conbsulta obteniendo solo datos necesario)
     */

    public function getTodosEStados()
    {

        $repo = $this->em->getRepository('AppBundle:Estado');
        $qb = $repo->createQueryBuilder('es');
        $qb->select('es.estadoid', 'es.nombre', 'p.paisid');
        $qb->innerJoin('es.paisid', 'p');
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }

    /*
     * Metodo para obtener los municipios (conbsulta obteniendo solo datos necesario)
     */

    public function getTodosMunicipios()
    {

        $repo = $this->em->getRepository('AppBundle:Municipio');
        $qb = $repo->createQueryBuilder('mu');
        $qb->select('mu.municipioid', 'mu.nombre', 'es.estadoid');
        $qb->innerJoin('mu.estadoid', 'es');

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }

    /*
     * Medo para retornar todas las colonias por ese cp
     */

    public function getTodasColoniasByCp($cp)
    {

        $repo = $this->em->getRepository('AppBundle:Colonia');
        $qb = $repo->createQueryBuilder('co');
        $qb->select('co.coloniaid', 'co.nombre', 'co.cp', 'mu.municipioid');
        $qb->innerJoin('co.municipioid', 'mu');
        $qb->where('co.cp = :cp');
        $qb->setParameter('cp', $cp);

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }



    public function getClavePersonasByFilter($filters)
    {
        $repo = $this->em->getRepository('AppBundle:CeAlumnoporclavefamiliar');
        $qb = $repo->createQueryBuilder('ac');
        $qb->select();
        $qb->innerJoin('ac.alumnoid', 'a');
        $qb->innerJoin('ac.clavefamiliarid', 'c');

        if (isset($filters['clavefamiliar'])) {
            $qb->andWhere('c.clave like :clavefamiliar');
            $qb->setParameter('clavefamiliar', '%'.$filters['clavefamiliar'].'%');
        }if (isset($filters['matricula'])) {
            $qb->andWhere('a.matricula like :matricula');
            $qb->setParameter('matricula', '%' . $filters['matricula'] . '%');
        }if (isset($filters['curp'])) {
            $qb->andWhere('a.curp like :curp');
            $qb->setParameter('curp', '%'.$filters['curp'].'%');
        }if (isset($filters['nombre'])) {
            $qb->andWhere('a.primernombre like :nombre or a.segundonombre like :nombre');
            $qb->setParameter('nombre', '%' . $filters['nombre'] . '%');
        }if (isset($filters['apellidopaterno'])) {
            $qb->andWhere('a.apellidopaterno like :apellidopaterno');
            $qb->setParameter('apellidopaterno', '%' . $filters['apellidopaterno'] . '%');
        }if (isset($filters['apellidomaterno'])) {
            $qb->andWhere('a.apellidomaterno like :apellidomaterno');
            $qb->setParameter('apellidomaterno', '%' . $filters['apellidomaterno'] . '%');
        }

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }


}
