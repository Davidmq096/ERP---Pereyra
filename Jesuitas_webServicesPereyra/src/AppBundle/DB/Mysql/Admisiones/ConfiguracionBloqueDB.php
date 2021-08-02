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
 * Description of ConfiguracionBloqueDB
 *
 * @author inceptio
 */
class ConfiguracionBloqueDB extends BaseDBManager {
    public function getMetodoAsignacionCita(){
        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('me')->from("AppBundle:AdMetodoasignacioncita", 'me');
        return $query->getQuery()->getResult();
    }

    public function getConfiguracionBloquesConsulta($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.cicloid, c.nombre ciclo, n.nivelid, n.nombre nivel, ge.nombre, m.metodoasignacioncitaid, m.nombre as metodoasignacioncitanombre, ge.bloquegradoid")
                ->from("AppBundle:AdBloquegrado", 'ge')
                ->innerJoin("ge.nivelid", "n")
                ->innerJoin("AppBundle:AdBloqueporgradoid", "g", Expr\Join::WITH, "g.bloquegradoid = ge.bloquegradoid")
                ->innerJoin("ge.metodoasignacioncitaid", "m")
                ->innerJoin("ge.cicloid", 'c')
                ->groupBy("ge.bloquegradoid");

        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid IN (:cicloid)')
        	->setParameter('cicloid' , $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid IN (:gradoid)')
        	->setParameter('gradoid' , $filtros['gradoid']);
        }
        if (isset($filtros['metodoasignacioncitaid'])) {
            $result->andWhere('ge.metodoasignacioncitaid IN (:metodoasignacioncitaid)')
        	->setParameter('metodoasignacioncitaid' , $filtros['metodoasignacioncitaid']);
        }
        if (isset($filtros['nombre'])) {
            $escape=array("_","%");
            $escapados=array("\_","\%");
            $filtros['nombre']=str_replace($escape,$escapados,$filtros['nombre']);
        	$result->andWhere('ge.nombre like :nombre')
        	->setParameter('nombre' , "%".$filtros['nombre']."%");
        }
        return $result->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function getGradosPorBloque($bloquegradoid){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ge.bloqueporgradoid, GroupConcat(g.grado, '°' Order by g.grado ) grado, GroupConcat(g.gradoid, '' Order by g.gradoid ) gradoid")->from("AppBundle:AdBloqueporgradoid", 'ge')->innerJoin("ge.gradoid", "g")->andWhere("ge.bloquegradoid = " . $bloquegradoid);
        return $result->getQuery()->getResult();
    }

    public function getBloquePorGrado($id){
        
        $qb = $this->em->createQueryBuilder();
        $entrevistas = $qb->select("e.casillasbloqueadas, e.bloquegradoentrevistaid, ee.nombre tipoevaluacionnombre, ee.tipoevaluacionid, eee.nombre evaluacionnombre, eee.evaluacionid, DATE_FORMAT(e.fecha, '%d-%m-%Y') fecha, DATE_FORMAT(e.horaprimeracita,'%H:%i') as horaprimeracita, DATE_FORMAT(e.horaultimacita,'%H:%i') as horaultimacita, e.duracion, e.cupo")
                        ->from("AppBundle:AdBloquegradoentrevista", 'e')
                        ->innerJoin("e.tipoevaluacionid", "ee")
                        ->innerJoin("e.evaluacionid", "eee")
                        ->andWhere("e.bloquegradoid = " . $id);

        $entrevistas = $entrevistas->getQuery()->getResult();

        $entrevistasData = [];

        foreach($entrevistas as $entrevista){
            $qb = $this->em->createQueryBuilder();
            $evaluadores = $qb->select("CONCAT_WS(' ',p.apellidopaterno,p.apellidomaterno,p.nombre) nombrecompleto, u.usuarioid, e.bloquegradoentrevistaevaluadorid, e.casillasbloqueadas, l.nombre lugarnombre, l.lugarid")
                            ->from("AppBundle:AdBloquegradoentrevistaevaluador", 'e')
                            ->innerJoin("e.usuarioid", "u")
                            ->innerJoin("u.personaid", "p")
                            ->innerJoin("e.lugarid", "l")
                            ->andWhere("e.bloquegradoentrevistaid = " . $entrevista['bloquegradoentrevistaid']);
            $evaluadores = $evaluadores->getQuery()->getResult();
            $entrevista['evaluadores'] = [];
            foreach($evaluadores as $evaluador){
                $qb = $this->em->createQueryBuilder();
                $evaluador['editable'] = false;
                $grados = $qb->select("CONCAT(g.grado, '°') grado, CONCAT(g.gradoid, '') gradoid, e.bloquegradoentrevistaevaluadorgradoid")
                            ->from("AppBundle:AdBloquegradoentrevistaevaluadorgrado", 'e')
                            ->innerJoin("e.gradoid", "g")
                            ->andWhere("e.bloquegradoentrevistaevaluadorid = " . $evaluador['bloquegradoentrevistaevaluadorid']);
                $evaluador['grados'] = $grados->getQuery()->getResult();
                $qb = $this->em->createQueryBuilder();
                $eventos = $qb->select('e.eventoevaluacionid')
                            ->from('AppBundle:Eventoevaluacion', 'e')
                            ->andWhere('e.evaluacionid = ' . $entrevista['evaluacionid'])
                            ->andWhere('e.usuarioid = ' . $evaluador['usuarioid'])
                            ->andWhere('e.bloquegradoentrevistaid = ' . $entrevista['bloquegradoentrevistaid']);
                $eventos = $eventos->getQuery()->getResult();
                $eventosData = [];
                foreach($eventos as $evento){
                    $qb = $this->em->createQueryBuilder();
                    $evaluacionsolicitud = $qb->select('e.evaluacionporsolicitudadmisionid')
                                                ->from('AppBundle:Evaluacionporsolicitudadmision', 'e')
                                                ->andWhere('e.eventoevaluacionid = ' . $evento['eventoevaluacionid']);
                    $evaluacionsolicitud = $evaluacionsolicitud->getQuery()->getResult();
                    $qb = $this->em->createQueryBuilder();
                    $gradoporeventoevaluacion = $qb->select('e.gradoporeventoevaluacionid')
                                                ->from('AppBundle:Gradoporeventoevaluacion', 'e')
                                                ->andWhere('e.eventoevaluacionid = ' . $evento['eventoevaluacionid']);
                    $gradoporeventoevaluacion = $gradoporeventoevaluacion->getQuery()->getResult();
                    $evento['grados'] = $gradoporeventoevaluacion;
                    if(count($evaluacionsolicitud) > 0){
                        $evaluador['editable'] = false;
                    }
                    $eventosData[] = $evento;
                }
                $evaluador['eventos'] = $eventosData;
                $entrevista['evaluadores'][] = $evaluador;
            }
            $entrevistasData[] = $entrevista;
        }

        $qb = $this->em->createQueryBuilder();
        $evaluaciones = $qb->select("e.bloquegradoevaluacionid, DATE_FORMAT(e.fecha, '%d-%m-%Y') fecha, DATE_FORMAT(e.horainicio,'%H:%i') as horainicio, DATE_FORMAT(e.horafin,'%H:%i') as horafin")
                        ->from("AppBundle:AdBloquegradoevaluacion", 'e')
                        ->andWhere("e.bloquegradoid = " . $id);

        $evaluaciones = $evaluaciones->getQuery()->getResult();

        $evaluacionesData = [];

        foreach($evaluaciones as $evaluacion){
            $qb = $this->em->createQueryBuilder();
            $evaluadores = $qb->select("e.cupo, CONCAT_WS(' ',p.apellidopaterno,p.apellidomaterno,p.nombre) nombrecompleto, u.usuarioid, e.bloquegradoevaluacionevaluadorid, l.nombre lugarnombre, l.lugarid")
                            ->from("AppBundle:AdBloquegradoevaluacionevaluador", 'e')
                            ->innerJoin("e.usuarioid", "u")
                            ->innerJoin("u.personaid", "p")
                            ->innerJoin("e.lugarid", "l")
                            ->andWhere("e.bloquegradoevaluacionid = " . $evaluacion['bloquegradoevaluacionid']);
            $evaluadores = $evaluadores->getQuery()->getResult();
            $qb = $this->em->createQueryBuilder();
            $evaluacionesPorBloque = $qb->select("e.evaluacionid")
                            ->from("AppBundle:AdBloquegradoevaluacionevaluacion", 'e')
                            ->andWhere("e.bloquegradoevaluacionid = " . $evaluacion['bloquegradoevaluacionid']);
            $evaluacionesPorBloque = $evaluacionesPorBloque->getQuery()->getResult();
            $evaluacionid = [];

            foreach($evaluacionesPorBloque as $evv){
                $evaluacionid[] = $evv['evaluacionid'];
            }

            $qb = $this->em->createQueryBuilder();
            $tipoevaluacionesPorBloque = $qb->select("e.tipoevaluacionid")
                            ->from("AppBundle:AdBloquegradoevaluaciontipoevaluacion", 'e')
                            ->andWhere("e.bloquegradoevaluacionid = " . $evaluacion['bloquegradoevaluacionid']);
            $tipoevaluacionesPorBloque = $tipoevaluacionesPorBloque->getQuery()->getResult();
            $tipoevaluacionid = [];

            foreach($tipoevaluacionesPorBloque as $evv){
                $tipoevaluacionid[] = $evv['tipoevaluacionid'];
            }

            $evaluacion['evaluacionid'] = $evaluacionid;
            $evaluacion['tipoevaluacionid'] = $tipoevaluacionid;
            $evaluacion['evaluadores'] = [];
            foreach($evaluadores as $evaluador){
                $evaluador['editable'] = true;
                $qb = $this->em->createQueryBuilder();
                $grados = $qb->select("CONCAT(g.grado, '°') grado, CONCAT(g.gradoid, '') gradoid, e.bloquegradoevaluacionevaluadorgradoid")
                            ->from("AppBundle:AdBloquegradoevaluacionevaluadorgrado", 'e')
                            ->innerJoin("e.gradoid", "g")
                            ->andWhere("e.bloquegradoevaluacionevaluadorid = " . $evaluador['bloquegradoevaluacionevaluadorid']);
                $evaluador['grados'] = $grados->getQuery()->getResult();
                $qb = $this->em->createQueryBuilder();
                $eventos = $qb->select('e.eventoevaluacionid, es.bloquegradoevaluacionid')
                            ->from('AppBundle:Eventoevaluacion', 'e')
                            ->innerJoin('e.bloquegradoevaluacionid', 'es')
                            ->andWhere('e.usuarioid = ' . $evaluador['usuarioid'])
                            ->andWhere('es.bloquegradoevaluacionid = ' . $evaluacion['bloquegradoevaluacionid']);
                $eventos = $eventos->getQuery()->getResult();
                $eventosData = [];
                foreach($eventos as $evento){
                    if($evento['bloquegradoevaluacionid'] !== NULL || $evento['bloquegradoevaluacionid'] !== ''){
                        $qb = $this->em->createQueryBuilder();
                        $evaluacionsolicitud = $qb->select('e.evaluacionporsolicitudadmisionid')
                                                    ->from('AppBundle:Evaluacionporsolicitudadmision', 'e')
                                                    ->andWhere('e.eventoevaluacionid = ' . $evento['eventoevaluacionid']);
                        $evaluacionsolicitud = $evaluacionsolicitud->getQuery()->getResult();
                        $qb = $this->em->createQueryBuilder();
                        $gradoporeventoevaluacion = $qb->select('e.gradoporeventoevaluacionid')
                                                    ->from('AppBundle:Gradoporeventoevaluacion', 'e')
                                                    ->andWhere('e.eventoevaluacionid = ' . $evento['eventoevaluacionid']);
                        $gradoporeventoevaluacion = $gradoporeventoevaluacion->getQuery()->getResult();
                        $evento['grados'] = $gradoporeventoevaluacion;
                        if(count($evaluacionsolicitud) > 0){
                            $evaluador['editable'] = false;
                        }
                        $eventosData[] = $evento;
                    }
                }
                $evaluador['eventos'] = $eventosData;
                $evaluacion['evaluadores'][] = $evaluador;
            }
            $evaluacionesData[] = $evaluacion;
        }

        $qb = $this->em->createQueryBuilder();
        $grados = $qb->select("CONCAT(g.grado, '°') grado, CONCAT(g.gradoid, '') gradoid")
                    ->from("AppBundle:AdBloqueporgradoid", 'e')
                    ->innerJoin("e.gradoid", "g")
                    ->andWhere("e.bloquegradoid = " . $id);
        $grados = $grados->getQuery()->getResult();

        return [
            'entrevistas' => $entrevistasData,
            'evaluaciones' => $evaluacionesData,
            'grados' => $grados
        ];
    }

    public function getBloquePorGradoDatosIniciales(){
        $qb = $this->em->createQueryBuilder();
        $tiposevaluacion = $qb->select("t.nombre, t.tipoevaluacionid, t.mostrar")
                            ->from("AppBundle:Tipoevaluacion", "t")
                            ->andWhere("t.activo = 1");
        $tiposevaluacion = $tiposevaluacion->getQuery()->getResult();

        $qb = $this->em->createQueryBuilder();
        $evaluaciones = $qb->select("t.nombre, t.evaluacionid, tt.tipoevaluacionid, c.cicloid")
                            ->from("AppBundle:Evaluacion", "t")
                            ->innerJoin('t.cicloid', 'c')
                            ->innerJoin('t.tipoevaluacionid', 'tt')
                            ->andWhere("t.activo = 1");
        $evaluaciones = $evaluaciones->getQuery()->getResult();
        $ev = [];

        foreach($evaluaciones as $evaluacion){
            $qb = $this->em->createQueryBuilder();
            $grados = $qb->select("g.gradoid, g.grado")
                        ->from("AppBundle:Evaluacionporgrado", "t")
                        ->innerJoin('t.gradoid', 'g')
                        ->andWhere('t.evaluacionid = ' . $evaluacion['evaluacionid']);
            $grados = $grados->getQuery()->getResult();
            $evaluacion['grados'] = $grados;
            $ev[] = $evaluacion;
        }

        return [
            'evaluacionescatalogo' => $ev,
            'tipoevaluacioncatalogo' => $tiposevaluacion
        ];
    }

    public function getBloqueGradoDelete($id){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("ge.bloquegradoid")->from("AppBundle:AdBloquegrado", 'ge')->andWhere("ge.bloquegradoid = " . $id);
        $bloquegrado = $result->getQuery()->getResult()[0];
        if($bloquegrado){
            $qb = $this->em->createQueryBuilder();
            $bloquegrado['eliminable'] = true;
            $entrevistas = $qb->select("e.bloquegradoentrevistaid")
                    ->from("AppBundle:AdBloquegradoentrevista", 'e')
                    ->andWhere("e.bloquegradoid = " . $id);

            $entrevistas = $entrevistas->getQuery()->getResult();
            $qb = $this->em->createQueryBuilder();
            $bloqueporgradoid = $qb->select("e.bloqueporgradoid")
                    ->from("AppBundle:AdBloqueporgradoid", 'e')
                    ->andWhere("e.bloquegradoid = " . $id);

            $bloquegrado['bloqueporgrado'] = $bloqueporgradoid->getQuery()->getResult();
            $entrevistasData = [];

            foreach($entrevistas as $entrevista){
                $qb = $this->em->createQueryBuilder();
                $evaluadores = $qb->select("ee.bloquegradoentrevistaevaluadorid, u.usuarioid")
                ->from("AppBundle:AdBloquegradoentrevistaevaluador", 'ee')
                ->innerJoin('ee.usuarioid', 'u')
                ->andWhere("ee.bloquegradoentrevistaid = " . $entrevista['bloquegradoentrevistaid']);
                $evaluadores = $evaluadores->getQuery()->getResult();
                $evaluadoresData = [];
                foreach($evaluadores as $evaluador){
                    $qb = $this->em->createQueryBuilder();
                    $eventos = $qb->select("eee.eventoevaluacionid")
                    ->from("AppBundle:Eventoevaluacion", 'eee')
                    ->andWhere('eee.bloquegradoentrevistaid = ' . $entrevista['bloquegradoentrevistaid'])
                    ->andWhere("eee.usuarioid = " . $evaluador['usuarioid']);
                    $eventos = $eventos->getQuery()->getResult();
                    $qb = $this->em->createQueryBuilder();
                    $bloquegradoentrevistaevaluadorgrado = $qb->select("e.bloquegradoentrevistaevaluadorgradoid")
                            ->from("AppBundle:AdBloquegradoentrevistaevaluadorgrado", 'e')
                            ->andWhere("e.bloquegradoentrevistaevaluadorid = " . $evaluador['bloquegradoentrevistaevaluadorid']);

                    $evaluador['bloquegradoentrevistaevaluadorgrado'] = $bloquegradoentrevistaevaluadorgrado->getQuery()->getResult();
                    $eventosData = [];
                    foreach($eventos as $evento){
                        $evento['eliminable'] = true;
                        $qb = $this->em->createQueryBuilder();
                        $gradoporeventoevaluacion = $qb->select("e.gradoporeventoevaluacionid")
                                ->from("AppBundle:Gradoporeventoevaluacion", 'e')
                                ->andWhere("e.eventoevaluacionid = " . $evento['eventoevaluacionid']);

                        $evento['gradoporeventoevaluacion'] = $gradoporeventoevaluacion->getQuery()->getResult();
                        $qb = $this->em->createQueryBuilder();
                        $evaluacionsolicitdud = $qb->select("eeee.evaluacionporsolicitudadmisionid")
                        ->from("AppBundle:Evaluacionporsolicitudadmision", 'eeee')
                        ->andWhere("eeee.eventoevaluacionid = " . $evento['eventoevaluacionid']);
                        $evaluacionsolicitdud = $evaluacionsolicitdud->getQuery()->getResult();
                        $evento['solicitudes'] = $evaluacionsolicitdud;
                        if(count($evento['solicitudes']) > 0){
                            $bloquegrado['eliminable'] = false;
                            $evento['eliminable'] = false;
                        }
                        $eventosData[] =  $evento;
                    }
                    $evaluador['eventos'] = $eventosData;
                    $evaluadoresData[] = $evaluador;
                }
                $entrevista['evaluadores'] = $evaluadoresData;
                $entrevistasData[] = $entrevista;
            }
            $bloquegrado['entrevistas'] = $entrevistasData;
            $qb = $this->em->createQueryBuilder();
            $evaluaciones = $qb->select("e.bloquegradoevaluacionid")
                    ->from("AppBundle:AdBloquegradoevaluacion", 'e')
                    ->andWhere("e.bloquegradoid = " . $id);

            $evaluaciones = $evaluaciones->getQuery()->getResult();
            $evaluacionesData = [];
            foreach($evaluaciones as $evaluacion){
                $qb = $this->em->createQueryBuilder();
                $evaluadores = $qb->select("ee.bloquegradoevaluacionevaluadorid, u.usuarioid")
                ->from("AppBundle:AdBloquegradoevaluacionevaluador", 'ee')
                ->innerJoin('ee.usuarioid', 'u')
                ->andWhere("ee.bloquegradoevaluacionid = " . $evaluacion['bloquegradoevaluacionid']);
                $evaluadores = $evaluadores->getQuery()->getResult();
                $qb = $this->em->createQueryBuilder();
                $evaluacionesPorBloque = $qb->select("e.evaluacionid, e.bloquegradoevaluacionevaluacionid")
                                ->from("AppBundle:AdBloquegradoevaluacionevaluacion", 'e')
                                ->andWhere("e.bloquegradoevaluacionid = " . $evaluacion['bloquegradoevaluacionid']);
                $evaluacionesPorBloque = $evaluacionesPorBloque->getQuery()->getResult();
                $evaluacionid = [];

                foreach($evaluacionesPorBloque as $evv){
                    $evaluacionid[] = $evv['bloquegradoevaluacionevaluacionid'];
                }

                $qb = $this->em->createQueryBuilder();
                $tipoevaluacionesPorBloque = $qb->select("e.tipoevaluacionid, e.bloquegradoevaluaciontipoevaluacionid")
                                ->from("AppBundle:AdBloquegradoevaluaciontipoevaluacion", 'e')
                                ->andWhere("e.bloquegradoevaluacionid = " . $evaluacion['bloquegradoevaluacionid']);
                $tipoevaluacionesPorBloque = $tipoevaluacionesPorBloque->getQuery()->getResult();
                $tipoevaluacionid = [];

                foreach($tipoevaluacionesPorBloque as $evv){
                    $tipoevaluacionid[] = $evv['bloquegradoevaluaciontipoevaluacionid'];
                }

                $evaluacion['evaluacionid'] = $evaluacionid;
                $evaluacion['tipoevaluacionid'] = $tipoevaluacionid;
                $evaluadoresData = [];
                foreach($evaluadores as $evaluador){
                    $qb = $this->em->createQueryBuilder();
                    $eventos = $qb->select("eee.eventoevaluacionid")
                    ->from("AppBundle:Eventoevaluacion", 'eee')
                    ->andWhere('eee.bloquegradoevaluacionid = ' . $evaluacion['bloquegradoevaluacionid'])
                    ->andWhere("eee.usuarioid = " . $evaluador['usuarioid']);
                    $eventos = $eventos->getQuery()->getResult();
                    $qb = $this->em->createQueryBuilder();
                    $bloquegradoevaluacionevaluadorgrado = $qb->select("e.bloquegradoevaluacionevaluadorgradoid")
                            ->from("AppBundle:AdBloquegradoevaluacionevaluadorgrado", 'e')
                            ->andWhere("e.bloquegradoevaluacionevaluadorid = " . $evaluador['bloquegradoevaluacionevaluadorid']);

                    $evaluador['bloquegradoevaluacionevaluadorgrado'] = $bloquegradoevaluacionevaluadorgrado->getQuery()->getResult();
                    $eventosData = [];
                    foreach($eventos as $evento){
                        $evento['eliminable'] = true;
                        $qb = $this->em->createQueryBuilder();
                        $gradoporeventoevaluacion = $qb->select("e.gradoporeventoevaluacionid")
                                ->from("AppBundle:Gradoporeventoevaluacion", 'e')
                                ->andWhere("e.eventoevaluacionid = " . $evento['eventoevaluacionid']);

                        $evento['gradoporeventoevaluacion'] = $gradoporeventoevaluacion->getQuery()->getResult();
                        $qb = $this->em->createQueryBuilder();
                        $evaluacionsolicitdud = $qb->select("eeee.evaluacionporsolicitudadmisionid")
                        ->from("AppBundle:Evaluacionporsolicitudadmision", 'eeee')
                        ->andWhere("eeee.eventoevaluacionid = " . $evento['eventoevaluacionid']);
                        $evaluacionsolicitdud = $evaluacionsolicitdud->getQuery()->getResult();
                        $evento['solicitudes'] = $evaluacionsolicitdud;
                        if(count($evento['solicitudes']) > 0){
                            $bloquegrado['eliminable'] = false;
                            $evento['eliminable'] = false;
                        }
                        $eventosData[] =  $evento;
                    }
                    $evaluador['eventos'] = $eventosData;
                    $evaluadoresData[] = $evaluador;
                }
                $evaluacion['evaluadores'] = $evaluadoresData;
                $evaluacionesData[] = $evaluacion; 
            }
            $bloquegrado['evaluaciones'] = $evaluacionesData;
            return $bloquegrado;
        }
        return null;
    }
}