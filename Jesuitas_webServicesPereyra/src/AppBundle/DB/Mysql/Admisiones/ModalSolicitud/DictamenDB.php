<?php

namespace AppBundle\DB\Mysql\Admisiones\ModalSolicitud;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of Categoriaapoyo
 *
 * @author Javier
 */
class DictamenDB extends BaseDBManager
{

    //Obtiene los formatos (cartas) del nivel seleccionado
    public function getCartasPorNivel($nivelid)
    {
            $qb = $this->em->createQueryBuilder();
            $result = $qb->select("f.formatoid,f.nombre")
            ->from("AppBundle:Gradoporformato", 'gf')
            ->innerJoin('gf.gradoid', 'g')
            ->innerJoin('g.nivelid', 'n')
            ->innerJoin('gf.formatoid', 'f')
            ->innerJoin('f.tipoformatoid', 'tf')
            ->groupBy('tf.tipoformatoid, n.nivelid, f.formatoid');
            $result->andWhere('f.activo = 1 and f.tipoformatoid IN (2,7,8)');
            $result->andWhere('n.nivelid = :nivelid')
           ->setParameter('nivelid' , $nivelid);
        return $result->getQuery()->getResult();
    }

    //Funcion para obtener las solicitudes aceptadas para validar una dictaminacion
    public function getAceptadosByCicloGrado($cicloid, $gradoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('s')
            ->from("AppBundle:Solicitudadmision", 's')
            ->innerJoin('AppBundle:Solicitudadmisionporciclo', 'sc', \Doctrine\ORM\Query\Expr\Join::WITH, 's.solicitudadmisionid = sc.solicitudadmisionid')
            ->innerJoin('s.estatussolicitudid', 'e')
            ->andWhere('sc.cicloid =' . $cicloid)
            ->andWhere('s.gradoid =' . $gradoid)
            ->andWhere('e.aceptado =' . 1);
        return $result->getQuery()->getResult();
    }

    //Obtiene los formatos disponibles del un grado para dictaminar (cartas)
    public function getCartasDictamen($gradoid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('f')
            ->from("AppBundle:Formato", 'f')
            ->innerJoin('AppBundle:Gradoporformato', 'gf', \Doctrine\ORM\Query\Expr\Join::WITH, 'f.formatoid = gf.formatoid')
            ->andWhere('gf.gradoid =' . $gradoid)
            //->andWhere('f.tipoformatoid IN (2,7,8,9)');
            ->andWhere('f.activo = 1 and f.tipoformatoid IN (2,7,8)');
        return $result->getQuery()->getResult();
    }

    //Obtiene los formatos por grados y tipo
    public function getCartasDictamenTipo($gradoid, $tipo)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('f')
            ->from("AppBundle:Formato", 'f')
            ->innerJoin('AppBundle:Gradoporformato', 'gf', \Doctrine\ORM\Query\Expr\Join::WITH, 'f.formatoid = gf.formatoid')
            ->andWhere('gf.gradoid =' . $gradoid)
            ->andWhere('f.tipoformatoid IN ('.$tipo.')')
            ->andWhere('f.activo = true');
        return $result->getQuery()->getResult();
    }

    //Obtiene la cita de la entrega de resultados (LUX)
    public function getCitaEntregaResultados($solicitudid, $tipoevaluacionid)
    {
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("es.evaluacionporsolicitudadmisionid, ee.eventoevaluacionid, e.evaluacionid,
        FechaEspanol(ee.fechainicio) fechainicio, DATE_FORMAT(ee.horainicio, '%h:%i %p') horainicio,
        CONCAT_WS(' ',p.apellidopaterno,p.apellidomaterno,p.nombre) as evaluador")
            ->from("AppBundle:Evaluacionporsolicitudadmision", 'es')
            ->innerJoin('es.eventoevaluacionid', 'ee')
            ->innerJoin('ee.evaluacionid', 'e')
            ->innerJoin('ee.usuarioid', 'u')
            ->innerJoin('u.personaid', 'p')
            ->andWhere('es.solicitudadmisionid =' . $solicitudid)
            ->andWhere('e.tipoevaluacionid =' . $tipoevaluacionid);
        return $result->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }

    public function getBIGralSolicitudadmision($solicitudid, $nivel,$portal){
        $conn = $this->em->getConnection();
        if ($portal==1){
            if($nivel == 1){
                $sql = "SELECT * FROM lux_estgralprevista where SolicitudAdmisionId = :solicitudid;";
            }if($nivel == 2){
                $sql = "SELECT * FROM lux_estgralprimvista where SolicitudAdmisionId = :solicitudid;";
            }if($nivel == 3){
                $sql = "SELECT * FROM lux_estgralsecundariavista where SolicitudAdmisionId = :solicitudid;";
            }if($nivel == 4){
                $sql = "SELECT * FROM lux_estgralbachvista where SolicitudAdmisionId = :solicitudid;";
            }
        }
        if ($portal==2){
            if($nivel == 1){
                $sql = "SELECT * FROM idec_fichapreescolarvista where SolicitudAdmisionId = :solicitudid;";
            }if($nivel == 2){
                $sql = "SELECT * FROM idec_fichaprimariavista where SolicitudAdmisionId = :solicitudid;";
            }if($nivel == 3){
                $sql = "SELECT * FROM idec_fichasecundariavista where SolicitudAdmisionId = :solicitudid;";
            }if($nivel == 4){
                $sql = "SELECT * FROM idec_fichabachilleratovista where SolicitudAdmisionId = :solicitudid;";
            }
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('solicitudid' => $solicitudid));
        $result = $stmt->fetchAll();
        return  $result;
    }


    public function getBIEntrSolicitudadmision($folio, $nivel,$portal){
        $conn = $this->em->getConnection();
        if ($portal==1){
            if($nivel == 1){
                $sql = "SELECT * FROM lux_entrevistaprevista where Folio = :folio;";
            }if($nivel == 2){
                $sql = "SELECT * FROM lux_entrevistaprimvista where Folio = :folio;";
            }if($nivel == 3){
                $sql = "SELECT * FROM lux_entrevistasecvista where Folio = :folio;";
            }if($nivel == 4){
                $sql = "SELECT * FROM lux_entrevistabachvista where Folio = :folio;";
            }
        }
        if ($portal==2){
            if($nivel == 1){
                $sql = "SELECT * FROM idec_entrevistaprevista where Folio = :folio;";
            }if($nivel == 2){
                $sql = "SELECT * FROM idec_entrevistaprivista where Folio = :folio;";
            }if($nivel == 3){
                $sql = "SELECT * FROM idec_entrevistasecuvista where Folio = :folio;";
            }if($nivel == 4){
                $sql = "SELECT * FROM idec_entrevistabachvista where Folio = :folio;";
            }
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('folio' => $folio));
        $result = $stmt->fetchAll();
        return  $result;
    }


    public function getBIPsicoSolicitudadmision($folio, $nivel, $portal){
        $conn = $this->em->getConnection();
        if ($portal==1){
            if($nivel == 1){
                $sql = "SELECT * FROM lux_psicometricoprevista where Folio = :folio;";
            }if($nivel == 2){
                $sql = "SELECT * FROM lux_psicometricoprimvista where Folio = :folio;";
            }if($nivel == 3){
                $sql = "SELECT * FROM lux_psicometricosecvista where Folio = :folio;";
            }if($nivel == 4){
                $sql = "SELECT * FROM lux_psicometricobachvista where Folio = :folio;";
            }
        }
        if ($portal==2){
            if($nivel == 1){
                $sql = "SELECT * FROM idec_psicometricoprevista where Folio = :folio;";
            }if($nivel == 2){
                $sql = "SELECT * FROM idec_psicometricoprivista where Folio = :folio;";
            }if($nivel == 3){
                $sql = "SELECT * FROM idec_psicometricosecvista where Folio = :folio;";
            }if($nivel == 4){
                $sql = "SELECT * FROM idec_psicometricobachvista where Folio = :folio;";
            }
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('folio' => $folio));
        $result = $stmt->fetchAll();
        return  $result;
    }
}
