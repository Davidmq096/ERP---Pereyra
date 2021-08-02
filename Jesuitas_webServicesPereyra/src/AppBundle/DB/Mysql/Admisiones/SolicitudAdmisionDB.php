<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql\Admisiones;

use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of SolicitudAdmisionDB
 *
 * @author inceptio
 */
class SolicitudAdmisionDB extends BaseDBManager
{

    /*
     * Busqueda de solicitud por filtros
     */
    public function getSolicitudByFilter($filters)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("s.solicitudadmisionid,s.clavesolicitud,c.nombre as ciclo,n.nombre as nivel,g.grado as grado,es.estatus,s.folio,d.nombre,d.apellidopaterno,d.apellidomaterno,
        CASE
            WHEN a.alumnoid is null THEN ''
            ELSE a.alumnoid
        END as alumnoid,
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
            WHEN cf.clavefamiliarid is null THEN s.clavefamiliar
            ELSE cf.clave
        END as clavefamiliar,
        CONCAT_WS(' ',per.apellidopaterno,per.apellidomaterno,per.nombre) as validadopor")
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
            $filters['clavefamiliar']=trim(str_replace($escape,$escapados,$filters['clavefamiliar']));
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
            $filters['matricula']=trim(str_replace($escape,$escapados,$filters['matricula']));
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
            $filters['folio']=trim(str_replace($escape,$escapados,$filters['folio']));
            $result->andWhere('s.folio like :folio')
                ->setParameter('folio', '%' . $filters['folio'] . '%');
        }
        if (isset($filters['clave'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filters['clave']=trim(str_replace($escape,$escapados,$filters['clave']));
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

    /*
     * Obtiene el numero de solicitudes validadas de un ciclo para un grado
     */
    public function getNumeroDeSolicitudesValidades($gradoid, $cicloid)
    {
        $qb = $this->em->getRepository('AppBundle:Solicitudadmisionporciclo')->createQueryBuilder('sc');
        $qb->select('count(sc)');
        $qb->innerJoin('sc.solicitudadmisionid', 's');
        $qb->where('s.estatussolicitudid >= :estatussolicitudid');
        $qb->setParameter('estatussolicitudid', 3);
        $qb->andWhere('s.gradoid = :gradoid');
        $qb->setParameter('gradoid', $gradoid);
        $qb->andWhere('sc.cicloid = :cicloid');
        $qb->setParameter('cicloid', $cicloid);

        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }

    /*
     * Busqueda de solicitud por filtros
     */
    public function reciboInscripcion($id)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("s.folio as matricula, c.nombre as ciclo, n.nombre as nivel, concat(g.grado,'') as gradoygrupo,
        Concat_WS(' ',d.apellidopaterno,d.apellidomaterno,d.nombre) as nombre,
        'INSCRIPCION' as concepto, dp.documento, DATE_FORMAT(dp.fechalimitepago, '%d/%m/%Y') as fechavencimiento, sum(dp.importe) as importe,
        CASE WHEN pp.fechaprorroga >= CURRENT_TIMESTAMP()
            THEN concat_ws(' ', 'Banco del Bajío:', dp.referencia, p.valor)
            ELSE 'Este recibo podrá ser pagado solamente en Caja Lux de Lunes a Viernes en horario de 8:00 a.m a 7:00.p.m, previa autorización del director de nivel.<br>Se cobrarán recargos del 4% sobre el total posterior a la fecha de vencimiento.<br>Puede pagar con tarjeta de crédito o débito en la caja del colegio, excepto American Express.<br>De no pagarse la inscripción en la fecha de vencimiento podremos disponer del lugar.'
        END referencia, s.documentosfirmados")
            ->from("AppBundle:Solicitudadmisionporciclo", 'sc')
            ->innerJoin("sc.cicloid", "c")
            ->innerJoin("sc.solicitudadmisionid", "s")
            ->innerJoin("s.datoaspiranteid", "d")
            ->innerJoin("s.gradoid", "g")
            ->innerJoin("g.nivelid", "n")
            ->leftJoin("AppBundle:CjDocumentoporpagar", "dp", Expr\Join::WITH, "s.solicitudadmisionid = dp.solicitudadmisionid and substring(dp.documento, 5, 2) = '00'")
            ->leftJoin("AppBundle:CjPlanpagoporalumno", "ppa", Expr\Join::WITH, 's.solicitudadmisionid = ppa.solicitudadmisionid')
            ->leftJoin("ppa.planpagoid", "pp")
            ->where("s.solicitudadmisionid =" . $id)
            ->from("AppBundle:Parametros", 'p')
            ->andWhere("p.nombre = 'ServicioReferenciaBancaria'");
        //$result->groupBy('s.solicitudadmisionid');
        return $result->getQuery()->getOneOrNullResult();
    }

    public function BuscarVistasolicitud($id)
    {
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare('CALL sp_solicitudtokens(:id)');
        $stmt->execute(array('id' => $id));
        $result = $stmt->fetch();
        return $result;
    }

    public function getFotoBySolicitud($filtros)
    {
        $result;
        $qb = $this->em->createQueryBuilder();
        if($filtros['familiar']){
            $result = $qb->select('d.fotofamiliar as foto');
        } else {
            $result = $qb->select('d.foto');
        }
        $result->from("AppBundle:Solicitudadmision", 's')
            ->innerJoin('s.datoaspiranteid', 'd')
            ->where('s.solicitudadmisionid = :solicitudadmisionid')
            ->setParameter('solicitudadmisionid', $filtros['solicitudid']);
        $query = $qb->getQuery()->getResult();
        return $query;
    }

}
