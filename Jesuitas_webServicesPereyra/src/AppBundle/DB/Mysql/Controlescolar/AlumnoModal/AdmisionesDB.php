<?php

namespace AppBundle\DB\Mysql\Controlescolar\AlumnoModal;

use Doctrine\ORM\Query\Expr;
use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Asignacion materia
 *
 * @author Gabriel, Rubén
 */
class AdmisionesDB extends BaseDBManager 
{
    public function getAlumnoSolicitudByFilter($filters)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("s.solicitudadmisionid,s.clavesolicitud,c.nombre as ciclo,n.nombre as nivel,g.grado as grado,es.estatus,s.folio,d.nombre,d.apellidopaterno,d.apellidomaterno,
        CASE
            WHEN a.matricula is null THEN ''
            ELSE a.matricula
        END as matricula,
        CASE
            WHEN d.celular is null THEN '-'
            ELSE d.celular
        END as telefonodecontacto,
        CASE
            WHEN s.solicitudpagada is null THEN '0'
            ELSE s.solicitudpagada
        END as solicitudpagada,s.pendiente,
        CASE
            WHEN s.clavefamiliar is null THEN ''
            ELSE s.clavefamiliar
        END as clavefamiliar,
        CONCAT_WS(' ',per.nombre,per.apellidopaterno, per.apellidomaterno) as validadopor")
            ->from("AppBundle:Solicitudadmision", 's')
            ->innerJoin('s.datoaspiranteid', 'd')
            ->innerJoin('s.gradoid', 'g')
            ->innerJoin('g.nivelid', 'n')
            ->innerJoin('s.estatussolicitudid', 'es')
            ->leftJoin('AppBundle:Solicitudadmisionporciclo', 'sc', Expr\Join::WITH, 's.solicitudadmisionid=sc.solicitudadmisionid')
            ->leftJoin('sc.cicloid', 'c')
            ->leftJoin('AppBundle:CeAlumno', 'a', Expr\Join::WITH, 'a.alumnoid=s.alumnoid')
            ->leftJoin('AppBundle:CeAlumnoporclavefamiliar', 'ac', Expr\Join::WITH, 'ac.alumnoid=a.alumnoid')
            ->leftJoin('ac.clavefamiliarid', 'cf')
            ->leftJoin('AppBundle:Usuario', 'u', Expr\Join::WITH, 'u.usuarioid=s.validadopor')
            ->leftJoin('u.personaid', 'per');

        if (isset($filters['clavefamiliar'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filters['clavefamiliar']=str_replace($escape,$escapados,$filters['clavefamiliar']);
            $result->andWhere('cf.clave like :clavefamiliar')
                ->setParameter('clavefamiliar', '%' . $filters['clavefamiliar'] . '%');
        }
        if (isset($filters['solicitudpagada'])) {

            if ($filters['solicitudpagada'] == 0) {
                $result->andWhere('s.solicitudpagada = :solicitudpagada or s.solicitudpagada is null')
                    ->setParameter('solicitudpagada', $filters['solicitudpagada']);
            } else {
                $result->andWhere('s.solicitudpagada = :solicitudpagada')
                    ->setParameter('solicitudpagada', $filters['solicitudpagada']);
            }
        }
        if (isset($filters['matricula'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filters['matricula']=str_replace($escape,$escapados,$filters['matricula']);
            $result->andWhere('a.matricula like :matricula')
                ->setParameter('matricula', '%' . $filters['matricula'] . '%');
        }
        if (isset($filters['cicloId'])) {
            $result->andWhere('sc.cicloid = :cicloid')
                ->setParameter('cicloid', $filters['cicloId']);
        }
        if (isset($filters['curp'])) {
            $result->andWhere('d.curp = :curp')
                ->setParameter('curp', $filters['curp']);
        }
        if (isset($filters['nombre'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filters['nombre'] = str_replace($escape, $escapados, $filters['nombre']);
            $result->andWhere('d.nombre like :nombre')
                ->setParameter('nombre', '%' . $filters['nombre'] . '%');
        }
        if (isset($filters['apellidopaterno'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filters['apellidopaterno'] = str_replace($escape, $escapados, $filters['apellidopaterno']);
            $result->andWhere('d.apellidopaterno LIKE :apellidopaterno')
                ->setParameter('apellidopaterno', '%' . $filters['apellidopaterno'] . '%');
        }
        if (isset($filters['apellidomaterno'])) {
            $escape = array("_", "%");
            $escapados = array("\_", "\%");
            $filters['apellidomaterno'] = str_replace($escape, $escapados, $filters['apellidomaterno']);
            $result->andWhere('d.apellidomaterno LIKE :apellidomaterno')
                ->setParameter('apellidomaterno', '%' . $filters['apellidomaterno'] . '%');
        }
        if (isset($filters['folio'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filters['folio']=str_replace($escape,$escapados,$filters['folio']);
            $result->andWhere('s.folio like :folio')
                ->setParameter('folio', '%' . $filters['folio'] . '%');
        }
        if (isset($filters['clave'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filters['clave']=str_replace($escape,$escapados,$filters['clave']);
            $result->andWhere('s.clavesolicitud like :clave')
                ->setParameter('clave', '%' . $filters['clave'] . '%');
        }
        if (isset($filters['gradoId'])) {
            $result->andWhere('s.gradoid IN (:gradoId)')
                ->setParameter('gradoId', $filters['gradoId']);
        }
        if (isset($filters['estatusTipo'])) {
            if ($filters['estatusTipo'] == 'v') {
                if (isset($filters['estatus'])) {
                    $result->andWhere('s.estatussolicitudid = :estatus')
                        ->setParameter('estatus', $filters['estatus']);
                } else {
                    //$qb->andWhere('s.estatussolicitudid IN (1,2,3,4,5,6,7,8,9, 10,11,12,13)');
                    $result->andWhere('es.dictaminacion = 0');
                    $result->andWhere('es.aceptado = 0');
                }
            } else if ($filters['estatusTipo'] == 'd') {
                $result->andWhere('s.estatussolicitudid in (:estatus)')
                    ->setParameter('estatus', $filters['estatus']);
            } else {
                if ($filters['estatus'] != null || $filters['estatus'] != '') {
                    $result->andWhere('s.estatussolicitudid = :estatus')
                        ->setParameter('estatus', $filters['estatus']);
                }
            }
        } else {
            if (isset($filters['estatus'])) {
                $result->andWhere('s.estatussolicitudid in  (:estatus)')
                    ->setParameter('estatus', $filters['estatus']);
            } else {
                //$qb->andWhere('s.estatussolicitudid IN (1,2,3,4,5,6,7,9,8,10)');
                $result->andWhere('es.dictaminacion IN (0,1)');
            }
        }
        if (isset($filters['nivelId'])) {
            $result->andWhere('n.nivelid IN (:nivelid)')
                ->setParameter('nivelid', $filters['nivelId']);
        }
        if (isset($filters['listaEspera'])) {
            $result->andWhere('s.listaespera = :listaEspera')
                ->setParameter('listaEspera', $filters['listaEspera']);
        }
        if(isset($filters['inscrito'])){
            if($filters['inscrito'] == 1){
                $result->andWhere('a.alumnoid is not null');
            }else{
                $result->andWhere('a.alumnoid is null');
            }
        }
        $result->groupBy('s.solicitudadmisionid');
        return $result->getQuery()->getResult();
    }
}
