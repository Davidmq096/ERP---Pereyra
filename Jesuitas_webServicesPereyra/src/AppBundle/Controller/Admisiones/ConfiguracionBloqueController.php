<?php

namespace AppBundle\Controller\Admisiones;

use FOS\RestBundle\View\View;
use AppBundle\DB\DbmAdmisiones;
use AppBundle\Entity\AdBloquegrado;
use AppBundle\Entity\Eventoevaluacion;
use AppBundle\Entity\AdBloqueporgradoid;
use AppBundle\Entity\AdBloquegradoentrevista;
use AppBundle\Entity\AdBloquegradoevaluacion;
use AppBundle\Entity\Gradoporeventoevaluacion;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\AdBloquegradoentrevistaevaluador;
use AppBundle\Entity\AdBloquegradoevaluacionevaluador;
use AppBundle\Entity\AdBloquegradoentrevistaevaluadorgrado;
use AppBundle\Entity\AdBloquegradoevaluacionevaluadorgrado;
use AppBundle\Entity\AdBloquegradoevaluacionevaluacion;
use AppBundle\Entity\AdBloquegradoevaluaciontipoevaluacion;

/**
 * Description of ConfiguracionBloqueTestController
 *
 * @author inceptio
 */
class ConfiguracionBloqueController extends FOSRestController
{
    /**
     * Retorna una materia por id enviado
     * @Rest\Get("/api/ConfiguracionBloque", name="InicioConfiguracion")
     */
    public function indexConfiguracion()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $ciclos = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $niveles = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grados = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $bloqueporgrado = $dbm->getBloquePorGradoDatosIniciales();
            $metodos = $dbm->getMetodoAsignacionCita();
            $evaluadores = $dbm->BuscarEvaluador([]);
            $lugares = $dbm->getRepositoriosById('Lugar', 'activo', 1, "nombre");
            $result = [
                'metodoasignacioncita' => $metodos,
                'ciclo' => $ciclos,
                'nivel' => $niveles,
                'grado' => $grados,
                'evaluaciones' => $bloqueporgrado['evaluacionescatalogo'],
                'tipoevaluacion' => $bloqueporgrado['tipoevaluacioncatalogo'],
                'evaluadores' => $evaluadores,
                "lugares" => $lugares
            ];
            return new View($result, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Regresa la consulta de configuraciones de bloques por grado
     * @Rest\Get("/api/ConfiguracionBloqueConsulta", name="ConfiguracionConsulta")
     */
    public function consultaConfiguracion(){
        try{
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $entidad = $dbm->getConfiguracionBloquesConsulta($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            $datos = [];
            $g = null;
            if(isset($filtros['gradoid'])){
                $g = explode(',', $filtros['gradoid']);
            }
            foreach($entidad as $ent){
                $grados = $dbm->getGradosPorBloque($ent['bloquegradoid']);
                $ent['grados'] = $grados[0]['grado'];
                $ent['gradosid'] =explode(',', $grados[0]['gradoid']);
                if($g){
                    $inArray = false;
                    for($i = 0; $i < count($g); $i++){
                        for($j = 0; $j < count($ent['gradosid']); $j++){
                            if($g[$i] == $ent['gradosid'][$j]){
                                $inArray = true;
                            }
                        }
                    }
                    if($inArray){
                        $datos[] = $ent;
                    }
                }else{
                    $datos[] = $ent;
                }
            }

            if(count($datos) == 0){
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($datos, Response::HTTP_OK);
        } catch(\Exception $e){
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Regresa el bloque por grado
     * @Rest\Get("/api/BloquePorGrado/{id}", name="BloquePorGrado")
     */
    public function BloquePorGrado($id){
        try{
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $bloqueporgrado = $dbm->getBloquePorGrado($id);
            return new View($bloqueporgrado, Response::HTTP_OK);
        }catch(\Exception $e){
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Regresa los datos iniciales del bloque por grado
     * @Rest\Get("/api/BloquePorGrado", name="BloquePorGradoDatosIniciales")
     */
    public function BloquePorGradoDatosIniciales(){
        try{
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $bloqueporgrado = $dbm->getBloquePorGradoDatosIniciales($id);
            return new View($bloqueporgrado, Response::HTTP_OK);
        }catch(\Exception $e){
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Regresa los datos iniciales del bloque por grado
     * @Rest\Get("/api/BloquePorGradoReporte/{id}", name="BloquePorGradoReporte")
     */
    public function BloquePorGradoReporte($id){
        $html = '<h1 style="color: #ddd; font-size: 40px">Prueba</h1>';
        return new View($html, Response::HTTP_OK);
    }

    /**
     * Regresa los datos iniciales del bloque por grado
     * @Rest\Put("/api/EditarBloquePorGrado/{id}", name="EditarBloquePorGrado")
     */
    public function EditarBloquePorGrado($id){
        try{
            $datos = file_get_contents('php://input');
            $data = json_decode($datos, true)['datos'];
            $data = json_decode(json_encode($data),true);
            $pasoUno = (array) $data['PasoUno'];
            $pasoDos = (array) $data['PasoDos'];
            $pasoTres = (array) $data['PasoTres'];
    
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
    
            $bloquegrado = $dbm->getRepositorioById('AdBloquegrado', 'bloquegradoid', $pasoUno['bloquegradoid']);
            $bloquegrado->setNombre($pasoUno['nombre']);
            $bloquegrado->setMetodoasignacioncitaid($dbm->getRepositorioById('AdMetodoasignacioncita', 'metodoasignacioncitaid', $pasoUno['metodoasignacioncitaid']));
            $dbm->saveRepositorio($bloquegrado);

            foreach ($pasoDos['entrevistas'] as $entrevista) {
                if($entrevista['bloquegradoentrevistaid'] !== NULL){
                    $bloquegradoentrevista = $dbm->getRepositorioById('AdBloquegradoentrevista', 'bloquegradoentrevistaid', $entrevista['bloquegradoentrevistaid']);
                    $bloquegradoentrevista->setCasillasbloqueadas(implode(',', $entrevista['casillasbloqueadas']));
                    $f = $entrevista['fecha']['date']['day'] . '-' . $entrevista['fecha']['date']['month'] . '-' . $entrevista['fecha']['date']['year'];
                    $dbm->saveRepositorio($bloquegradoentrevista);

                    foreach($entrevista['evaluadores'] as $ev){
                        if($ev['bloquegradoentrevistaevaluadorid'] == NULL){
                            $cas = $ev['casillasbloqueadas'];
                            if(count($ev['casillasbloqueadas']) > 0){
                                if(is_array($ev['casillasbloqueadas'][0])){
                                    $cas = $ev['casillasbloqueadas'][0];
                                }
                            }
                            $evaluador = new AdBloquegradoentrevistaevaluador();
                            $evaluador->setBloquegradoentrevistaid($bloquegradoentrevista);
                            $evaluador->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                            $evaluador->setCasillasbloqueadas(implode(',', $cas));
                            $evaluador->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                            $dbm->saveRepositorio($evaluador);
            
                            foreach($ev['gradoid'] as $grado){
                                $grado = (array) $grado;
                                $bloquegradoentrevistaevaluadorgrado = new AdBloquegradoentrevistaevaluadorgrado();
                                $bloquegradoentrevistaevaluadorgrado->setBloquegradoentrevistaevaluadorid($evaluador);
                                $bloquegradoentrevistaevaluadorgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                $dbm->saveRepositorio($bloquegradoentrevistaevaluadorgrado);
                            }

                            for($i = 0; $i < count($entrevista['horas']); $i++){
                                if (!in_array($i, $cas)) {
                                    $horaInicio = $entrevista['horas'][$i]['display'];
                                    if($entrevista['horas'][$i + 1]){
                                        $horaFin = $entrevista['horas'][$i + 1]['display'];
                                    }else{
                                        $time = new \DateTime('2011-11-17 ' . $entrevista['horas'][$i]['display']);
                                        $time->add(new \DateInterval('PT' . $entrevista["duracion"] . 'M'));

                                        $horaFin = $time->format('H:i');
                                    }

                                    $eventoevaluacion = new Eventoevaluacion();
                                    $eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $pasoDos['evaluacionid']));
                                    $eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                                    $eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                                    $eventoevaluacion->setFechainicio(new \DateTime($f));
                                    $eventoevaluacion->setFechafin(new \DateTime($f));
                                    $eventoevaluacion->setHorainicio(new \DateTime($horaInicio));
                                    $eventoevaluacion->setHorafin(new \DateTime($horaFin));
                                    $eventoevaluacion->setCupo($entrevista['cupo']);
                                    $eventoevaluacion->setBloquegradoentrevistaid($bloquegradoentrevista);
                                    $dbm->saveRepositorio($eventoevaluacion);

                                    foreach($ev['gradoid'] as $grado){
                                        $grado = (array) $grado;
                                        $gradoporeventoevaluacion = new Gradoporeventoevaluacion();
                                        $gradoporeventoevaluacion->setEventoevaluacionid($eventoevaluacion);
                                        $gradoporeventoevaluacion->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                        $dbm->saveRepositorio($gradoporeventoevaluacion);
                                    }
                                }
                            }
                        }else{
                            if($ev['editable'] == true){
                                if($ev['editado'] == true){
                                    $evs = $dbm->getRepositorioById('AdBloquegradoentrevistaevaluador', 'bloquegradoentrevistaevaluadorid', $ev['bloquegradoentrevistaevaluadorid']);
    
                                    if($evs){
                                        foreach($ev['grados'] as $gr){
                                            $grr = $dbm->getRepositorioById('AdBloquegradoentrevistaevaluadorgrado', 'bloquegradoentrevistaevaluadorgradoid', $gr['bloquegradoentrevistaevaluadorgradoid']);
                                            if($grr){
                                                $dbm->removeRepositorio($grr);
                                            }
                                        }
                                        foreach($ev['eventos'] as $event){
                                            $evo = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $event['eventoevaluacionid']);
                                            foreach($event['grados'] as $grad){
                                                $grads = $dbm->getRepositorioById('Gradoporeventoevaluacion', 'gradoporeventoevaluacionid', $grad['gradoporeventoevaluacionid']);
                                                if($grads){
                                                    $dbm->removeRepositorio($grads);
                                                }
                                            }
                                            $dbm->removeRepositorio($evo);
                                        }
                                        $dbm->removeRepositorio($evs);
    
                                        $cas = $ev['casillasbloqueadas'];
                                        if(count($ev['casillasbloqueadas']) > 0){
                                            if(is_array($ev['casillasbloqueadas'][0])){
                                                $cas = $ev['casillasbloqueadas'][0];
                                            }
                                        }
                                        $evaluador = new AdBloquegradoentrevistaevaluador();
                                        $evaluador->setBloquegradoentrevistaid($bloquegradoentrevista);
                                        $evaluador->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                                        $evaluador->setCasillasbloqueadas(implode(',', $cas));
                                        $evaluador->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                                        $dbm->saveRepositorio($evaluador);
                        
                                        foreach($ev['gradoid'] as $grado){
                                            $grado = (array) $grado;
                                            $bloquegradoentrevistaevaluadorgrado = new AdBloquegradoentrevistaevaluadorgrado();
                                            $bloquegradoentrevistaevaluadorgrado->setBloquegradoentrevistaevaluadorid($evaluador);
                                            $bloquegradoentrevistaevaluadorgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                            $dbm->saveRepositorio($bloquegradoentrevistaevaluadorgrado);
                                        }
    
                                        for($i = 0; $i < count($entrevista['horas']); $i++){
                                            if (!in_array($i, $cas)) {
                                                $horaInicio = $entrevista['horas'][$i]['display'];
                                                if($entrevista['horas'][$i + 1]){
                                                    $horaFin = $entrevista['horas'][$i + 1]['display'];
                                                }else{
                                                    $time = new \DateTime('2011-11-17 ' . $entrevista['horas'][$i]['display']);
                                                    $time->add(new \DateInterval('PT' . $entrevista["duracion"] . 'M'));
    
                                                    $horaFin = $time->format('H:i');
                                                }
    
                                                $eventoevaluacion = new Eventoevaluacion();
                                                $eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $pasoDos['evaluacionid']));
                                                $eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                                                $eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                                                $eventoevaluacion->setFechainicio(new \DateTime($f));
                                                $eventoevaluacion->setFechafin(new \DateTime($f));
                                                $eventoevaluacion->setHorainicio(new \DateTime($horaInicio));
                                                $eventoevaluacion->setHorafin(new \DateTime($horaFin));
                                                $eventoevaluacion->setCupo($entrevista['cupo']);
                                                $eventoevaluacion->setBloquegradoentrevistaid($bloquegradoentrevista);
                                                $dbm->saveRepositorio($eventoevaluacion);
    
                                                foreach($ev['gradoid'] as $grado){
                                                    $grado = (array) $grado;
                                                    $gradoporeventoevaluacion = new Gradoporeventoevaluacion();
                                                    $gradoporeventoevaluacion->setEventoevaluacionid($eventoevaluacion);
                                                    $gradoporeventoevaluacion->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                                    $dbm->saveRepositorio($gradoporeventoevaluacion);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    foreach($entrevista['eliminados'] as $ev){
                        $evs = $dbm->getRepositorioById('AdBloquegradoentrevistaevaluador', 'bloquegradoentrevistaevaluadorid', $ev['bloquegradoentrevistaevaluadorid']);
    
                        if ($evs) {
                            foreach ($ev['grados'] as $gr) {
                                $grr = $dbm->getRepositorioById('AdBloquegradoentrevistaevaluadorgrado', 'bloquegradoentrevistaevaluadorgradoid', $gr['bloquegradoentrevistaevaluadorgradoid']);
                                if ($grr) {
                                    $dbm->removeRepositorio($grr);
                                }
                            }
                            foreach ($ev['eventos'] as $event) {
                                $evo = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $event['eventoevaluacionid']);
                                foreach ($event['grados'] as $grad) {
                                    $grads = $dbm->getRepositorioById('Gradoporeventoevaluacion', 'gradoporeventoevaluacionid', $grad['gradoporeventoevaluacionid']);
                                    if ($grads) {
                                        $dbm->removeRepositorio($grads);
                                    }
                                }
                                $dbm->removeRepositorio($evo);
                            }
                            $dbm->removeRepositorio($evs);
                        }
                    }

                }else{
                    $bloquegradoentrevista = new AdBloquegradoentrevista();
                    $bloquegradoentrevista->setTipoevaluacionid($dbm->getRepositorioById('Tipoevaluacion', 'tipoevaluacionid', $pasoDos['tipoevaluacionid']));
                    $bloquegradoentrevista->setBloquegradoid($bloquegrado);
                    $bloquegradoentrevista->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $pasoDos['evaluacionid']));
                    $f = $entrevista['fecha']['date']['day'] . '-' . $entrevista['fecha']['date']['month'] . '-' . $entrevista['fecha']['date']['year'];
                    $bloquegradoentrevista->setFecha(new \DateTime($f));
                    $bloquegradoentrevista->setHoraprimeracita(new \DateTime($entrevista['horaprimeracita']));
                    $bloquegradoentrevista->setHoraultimacita(new \DateTime($entrevista['horaultimacita']));
                    $bloquegradoentrevista->setCasillasbloqueadas(implode(',', $entrevista['casillasbloqueadas']));
                    $bloquegradoentrevista->setDuracion($entrevista['duracion']);
                    $bloquegradoentrevista->setCupo($entrevista['cupo']);
                    $dbm->saveRepositorio($bloquegradoentrevista);
        
                    foreach($entrevista['evaluadores'] as $ev){
                        $cas = $ev['casillasbloqueadas'];
                        if(count($ev['casillasbloqueadas']) > 0){
                            if(is_array($ev['casillasbloqueadas'][0])){
                                $cas = $ev['casillasbloqueadas'][0];
                            }
                        }
                        $evaluador = new AdBloquegradoentrevistaevaluador();
                        $evaluador->setBloquegradoentrevistaid($bloquegradoentrevista);
                        $evaluador->setCasillasbloqueadas(implode(',', $cas));
                        $evaluador->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                        $evaluador->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                        $dbm->saveRepositorio($evaluador);
        
                        foreach($ev['gradoid'] as $grado){
                            $grado = (array) $grado;
                            $bloquegradoentrevistaevaluadorgrado = new AdBloquegradoentrevistaevaluadorgrado();
                            $bloquegradoentrevistaevaluadorgrado->setBloquegradoentrevistaevaluadorid($evaluador);
                            $bloquegradoentrevistaevaluadorgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                            $dbm->saveRepositorio($bloquegradoentrevistaevaluadorgrado);
                        }
    
                        for($i = 0; $i < count($entrevista['horas']); $i++){
                            if (!in_array($i, $cas)) {
                                $horaInicio = $entrevista['horas'][$i]['display'];
                                if($entrevista['horas'][$i + 1]){
                                    $horaFin = $entrevista['horas'][$i + 1]['display'];
                                }else{
                                    $time = new \DateTime('2011-11-17 ' . $entrevista['horas'][$i]['display']);
                                    $time->add(new \DateInterval('PT' . $entrevista["duracion"] . 'M'));

                                    $horaFin = $time->format('H:i');
                                }
    
                                $eventoevaluacion = new Eventoevaluacion();
                                $eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $pasoDos['evaluacionid']));
                                $eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                                $eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                                $eventoevaluacion->setFechainicio(new \DateTime($f));
                                $eventoevaluacion->setFechafin(new \DateTime($f));
                                $eventoevaluacion->setHorainicio(new \DateTime($horaInicio));
                                $eventoevaluacion->setHorafin(new \DateTime($horaFin));
                                $eventoevaluacion->setCupo($entrevista['cupo']);
                                $eventoevaluacion->setBloquegradoentrevistaid($bloquegradoentrevista);
                                $dbm->saveRepositorio($eventoevaluacion);

                                foreach($ev['gradoid'] as $grado){
                                    $grado = (array) $grado;
                                    $gradoporeventoevaluacion = new Gradoporeventoevaluacion();
                                    $gradoporeventoevaluacion->setEventoevaluacionid($eventoevaluacion);
                                    $gradoporeventoevaluacion->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                    $dbm->saveRepositorio($gradoporeventoevaluacion);
                                }
                                
                            }
                        }
                    }
                }
            }

            foreach($pasoTres['examenes'] as $examen){
                foreach($examen['fechas'] as $fecha){
                    $f = $fecha['fecha']['date']['day'] . '-' . $fecha['fecha']['date']['month'] . '-' . $fecha['fecha']['date']['year'];
                    if($fecha['bloquegradoevaluacionid'] == NULL){
                        $bloquegradoevaluacion = new AdBloquegradoevaluacion();
                        $bloquegradoevaluacion->setBloquegradoid($bloquegrado);
                        $bloquegradoevaluacion->setFecha(new \DateTime($f));
                        $bloquegradoevaluacion->setHorainicio(new \DateTime($fecha['horainicio']));
                        $bloquegradoevaluacion->setHorafin(new \DateTime($fecha['horafin']));
                        $dbm->saveRepositorio($bloquegradoevaluacion);

                        foreach($examen['evaluacionid'] as $evaluacionid){
                            $evaid = new AdBloquegradoevaluacionevaluacion();
                            $evaid->setEvaluacionid($evaluacionid);
                            $evaid->setBloquegradoevaluacionid($bloquegradoevaluacion->getBloquegradoevaluacionid());
                            $dbm->saveRepositorio($evaid);
                        }

                        foreach($examen['tipoevaluacionid'] as $tipoevaluacionid){
                            $evaid = new AdBloquegradoevaluaciontipoevaluacion();
                            $evaid->setTipoevaluacionid($tipoevaluacionid);
                            $evaid->setBloquegradoevaluacionid($bloquegradoevaluacion->getBloquegradoevaluacionid());
                            $dbm->saveRepositorio($evaid);
                        }
        
                        foreach($fecha['evaluadores'] as $ev){
                            $evaluador = new AdBloquegradoevaluacionevaluador();
                            $evaluador->setBloquegradoevaluacionid($bloquegradoevaluacion);
                            $evaluador->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                            $evaluador->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                            $evaluador->setCupo($ev['cupo']);
                            $dbm->saveRepositorio($evaluador);
            
                            foreach($ev['gradoid'] as $grado){
                                $bloquegradoevaluacionevaluadorgrado = new AdBloquegradoevaluacionevaluadorgrado();
                                $bloquegradoevaluacionevaluadorgrado->setBloquegradoevaluacionevaluadorid($evaluador);
                                $bloquegradoevaluacionevaluadorgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                $dbm->saveRepositorio($bloquegradoevaluacionevaluadorgrado);
                            }
    
                            $horaInicio = $fecha['horainicio'];
                            $horaFin = $fecha['horafin'];
    
                            foreach($examen['evaluacionid'] as $evaluacionid){
                                $eventoevaluacion = new Eventoevaluacion();
                                $eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $evaluacionid));
                                $eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                                $eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                                $eventoevaluacion->setFechainicio(new \DateTime($f));
                                $eventoevaluacion->setFechafin(new \DateTime($f));
                                $eventoevaluacion->setHorainicio(new \DateTime($horaInicio));
                                $eventoevaluacion->setHorafin(new \DateTime($horaFin));
                                $eventoevaluacion->setCupo($ev['cupo']);
                                $eventoevaluacion->setBloquegradoevaluacionid($bloquegradoevaluacion);
                                $dbm->saveRepositorio($eventoevaluacion);

                                foreach($ev['gradoid'] as $grado){
                                    $grado = (array) $grado;
                                    $gradoporeventoevaluacion = new Gradoporeventoevaluacion();
                                    $gradoporeventoevaluacion->setEventoevaluacionid($eventoevaluacion);
                                    $gradoporeventoevaluacion->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                    $dbm->saveRepositorio($gradoporeventoevaluacion);
                                }
                            }
                        }
                    }else{
                        $bloquegradoevaluacion = $dbm->getRepositorioById('AdBloquegradoevaluacion', 'bloquegradoevaluacionid', $fecha['bloquegradoevaluacionid']);
                        foreach($fecha['eliminados'] as $ev){
                            $evs = $dbm->getRepositorioById('AdBloquegradoevaluacionevaluador', 'bloquegradoevaluacionevaluadorid', $ev['bloquegradoevaluacionevaluadorid']);
        
                            if ($evs) {
                                foreach ($ev['grados'] as $gr) {
                                    $grr = $dbm->getRepositorioById('AdBloquegradoevaluacionevaluadorgrado', 'bloquegradoevaluacionevaluadorgradoid', $gr['bloquegradoevaluacionevaluadorgradoid']);
                                    if ($grr) {
                                        $dbm->removeRepositorio($grr);
                                    }
                                }
                                foreach ($ev['eventos'] as $event) {
                                    $evo = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $event['eventoevaluacionid']);
                                    foreach ($event['grados'] as $grad) {
                                        $grads = $dbm->getRepositorioById('Gradoporeventoevaluacion', 'gradoporeventoevaluacionid', $grad['gradoporeventoevaluacionid']);
                                        if ($grads) {
                                            $dbm->removeRepositorio($grads);
                                        }
                                    }
                                    $dbm->removeRepositorio($evo);
                                }
                                $dbm->removeRepositorio($evs);
                            }
                        }
                        foreach($fecha['evaluadores'] as $ev){
                            if($ev['bloquegradoevaluacionevaluadorid'] == NULL){
                                $evaluador = new AdBloquegradoevaluacionevaluador();
                                $evaluador->setBloquegradoevaluacionid($bloquegradoevaluacion);
                                $evaluador->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                                $evaluador->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                                $evaluador->setCupo($ev['cupo']);
                                $dbm->saveRepositorio($evaluador);
                
                                foreach($ev['gradoid'] as $grado){
                                    $bloquegradoevaluacionevaluadorgrado = new AdBloquegradoevaluacionevaluadorgrado();
                                    $bloquegradoevaluacionevaluadorgrado->setBloquegradoevaluacionevaluadorid($evaluador);
                                    $bloquegradoevaluacionevaluadorgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                    $dbm->saveRepositorio($bloquegradoevaluacionevaluadorgrado);
                                }
        
                                $horaInicio = $fecha['horainicio'];
                                $horaFin = $fecha['horafin'];

                                foreach ($examen['evaluacionid'] as $evaluacionid) {
                                    $eventoevaluacion = new Eventoevaluacion();
                                    $eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $evaluacionid));
                                    $eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                                    $eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                                    $eventoevaluacion->setFechainicio(new \DateTime($f));
                                    $eventoevaluacion->setFechafin(new \DateTime($f));
                                    $eventoevaluacion->setHorainicio(new \DateTime($horaInicio));
                                    $eventoevaluacion->setHorafin(new \DateTime($horaFin));
                                    $eventoevaluacion->setCupo($ev['cupo']);
                                    $eventoevaluacion->setBloquegradoevaluacionid($bloquegradoevaluacion);
                                    $dbm->saveRepositorio($eventoevaluacion);

                                    foreach ($ev['gradoid'] as $grado) {
                                        $grado = (array) $grado;
                                        $gradoporeventoevaluacion = new Gradoporeventoevaluacion();
                                        $gradoporeventoevaluacion->setEventoevaluacionid($eventoevaluacion);
                                        $gradoporeventoevaluacion->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                        $dbm->saveRepositorio($gradoporeventoevaluacion);
                                    }
                                }
                            }else{
                                if($ev['editable'] == true){
                                    if($ev['editado'] == true){
                                        $evs = $dbm->getRepositorioById('AdBloquegradoevaluacionevaluador', 'bloquegradoevaluacionevaluadorid', $ev['bloquegradoevaluacionevaluadorid']);
        
                                        if($evs){
                                            foreach($ev['grados'] as $gr){
                                                $grr = $dbm->getRepositorioById('AdBloquegradoevaluacionevaluadorgrado', 'bloquegradoevaluacionevaluadorgradoid', $gr['bloquegradoevaluacionevaluadorgradoid']);
                                                if($grr){
                                                    $dbm->removeRepositorio($grr);
                                                }
                                            }
                                            foreach($ev['eventos'] as $event){
                                                $evo = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $event['eventoevaluacionid']);
                                                foreach($event['grados'] as $grad){
                                                    $grads = $dbm->getRepositorioById('Gradoporeventoevaluacion', 'gradoporeventoevaluacionid', $grad['gradoporeventoevaluacionid']);
                                                    if($grads){
                                                        $dbm->removeRepositorio($grads);
                                                    }
                                                }
                                                $dbm->removeRepositorio($evo);
                                            }
                                            $dbm->removeRepositorio($evs);
                                            $evaluador = new AdBloquegradoevaluacionevaluador();
                                            $evaluador->setBloquegradoevaluacionid($bloquegradoevaluacion);
                                            $evaluador->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                                            $evaluador->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                                            $evaluador->setCupo($ev['cupo']);
                                            $dbm->saveRepositorio($evaluador);
                            
                                            foreach($ev['gradoid'] as $grado){
                                                $bloquegradoevaluacionevaluadorgrado = new AdBloquegradoevaluacionevaluadorgrado();
                                                $bloquegradoevaluacionevaluadorgrado->setBloquegradoevaluacionevaluadorid($evaluador);
                                                $bloquegradoevaluacionevaluadorgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                                $dbm->saveRepositorio($bloquegradoevaluacionevaluadorgrado);
                                            }
                    
                                            $horaInicio = $fecha['horainicio'];
                                            $horaFin = $fecha['horafin'];

                                            foreach ($examen['evaluacionid'] as $evaluacionid) {
                                                $eventoevaluacion = new Eventoevaluacion();
                                                $eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $evaluacionid));
                                                $eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                                                $eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                                                $eventoevaluacion->setFechainicio(new \DateTime($f));
                                                $eventoevaluacion->setFechafin(new \DateTime($f));
                                                $eventoevaluacion->setHorainicio(new \DateTime($horaInicio));
                                                $eventoevaluacion->setHorafin(new \DateTime($horaFin));
                                                $eventoevaluacion->setCupo($ev['cupo']);
                                                $eventoevaluacion->setBloquegradoevaluacionid($bloquegradoevaluacion);
                                                $dbm->saveRepositorio($eventoevaluacion);

                                                foreach ($ev['gradoid'] as $grado) {
                                                    $grado = (array) $grado;
                                                    $gradoporeventoevaluacion = new Gradoporeventoevaluacion();
                                                    $gradoporeventoevaluacion->setEventoevaluacionid($eventoevaluacion);
                                                    $gradoporeventoevaluacion->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                                    $dbm->saveRepositorio($gradoporeventoevaluacion);
                                                }
                                            }
                                        }
                                    }
                                }
                                
                            }
                        }
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Regresa los datos iniciales del bloque por grado
     * @Rest\Post("/api/GuardarBloqueGrado", name="GuardarBloqueGrado")
     */
    public function GuardarBloqueGrado(){
        try{
            $datos = file_get_contents('php://input');
            $data = json_decode($datos, true)['datos'];
            $data = json_decode(json_encode($data),true);
            $pasoUno = (array) $data['PasoUno'];
            $pasoDos = (array) $data['PasoDos'];
            $pasoTres = (array) $data['PasoTres'];
    
            $dbm = $this->get("db_manager");

            $dbm->getConnection()->beginTransaction();
            $bloquegrado = new AdBloquegrado();
            $bloquegrado->setNombre($pasoUno['nombre']);
            $bloquegrado->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $pasoUno['cicloid']));
            $bloquegrado->setMetodoasignacioncitaid($dbm->getRepositorioById('AdMetodoasignacioncita', 'metodoasignacioncitaid',$pasoUno['metodoasignacioncitaid']));
            $bloquegrado->setNivelid($dbm->getRepositorioById('Nivel', 'nivelid', $pasoUno['nivelid']));
            $dbm->saveRepositorio($bloquegrado);
    
            foreach($pasoUno['gradoid'] as $grado){
                $bloquegrados = new AdBloqueporgradoid();
                $bloquegrados->setBloquegradoid($bloquegrado);
                $bloquegrados->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                $dbm->saveRepositorio($bloquegrados);
            }
    
            foreach($pasoDos['entrevistas'] as $entrevista){
                $bloquegradoentrevista = new AdBloquegradoentrevista();
                $bloquegradoentrevista->setTipoevaluacionid($dbm->getRepositorioById('Tipoevaluacion', 'tipoevaluacionid', $pasoDos['tipoevaluacionid']));
                $bloquegradoentrevista->setBloquegradoid($bloquegrado);
                $bloquegradoentrevista->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $pasoDos['evaluacionid']));
                $f = $entrevista['fecha']['date']['day'] . '-' . $entrevista['fecha']['date']['month'] . '-' . $entrevista['fecha']['date']['year'];
                $bloquegradoentrevista->setFecha(new \DateTime($f));
                $bloquegradoentrevista->setHoraprimeracita(new \DateTime($entrevista['horaprimeracita']));
                $bloquegradoentrevista->setHoraultimacita(new \DateTime($entrevista['horaultimacita']));
                $bloquegradoentrevista->setCasillasbloqueadas(implode(',', $entrevista['casillasbloqueadas']));
                $bloquegradoentrevista->setDuracion($entrevista['duracion']);
                $bloquegradoentrevista->setCupo($entrevista['cupo']);
                $dbm->saveRepositorio($bloquegradoentrevista);
    
                foreach($entrevista['evaluadores'] as $ev){
                    $cas = $ev['casillasbloqueadas'];
                    if(count($ev['casillasbloqueadas']) > 0){
                        if(is_array($ev['casillasbloqueadas'][0])){
                            $cas = $ev['casillasbloqueadas'][0];
                        }
                    }
                    $evaluador = new AdBloquegradoentrevistaevaluador();
                    $evaluador->setBloquegradoentrevistaid($bloquegradoentrevista);
                    $evaluador->setCasillasbloqueadas(implode(',', $cas));
                    $evaluador->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                    $evaluador->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                    $dbm->saveRepositorio($evaluador);
    
                    foreach($ev['gradoid'] as $grado){
                        $grado = (array) $grado;
                        $bloquegradoentrevistaevaluadorgrado = new AdBloquegradoentrevistaevaluadorgrado();
                        $bloquegradoentrevistaevaluadorgrado->setBloquegradoentrevistaevaluadorid($evaluador);
                        $bloquegradoentrevistaevaluadorgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                        $dbm->saveRepositorio($bloquegradoentrevistaevaluadorgrado);
                    }

                    for($i = 0; $i < count($entrevista['horas']); $i++){
                        if (!in_array($i, $cas)) {
                            $horaInicio = $entrevista['horas'][$i]['display'];
                            if($entrevista['horas'][$i + 1]){
                                $horaFin = $entrevista['horas'][$i + 1]['display'];
                            }else{
                                $time = new \DateTime('2011-11-17 ' . $entrevista['horas'][$i]['display']);
                                $time->add(new \DateInterval('PT' . $entrevista["duracion"] . 'M'));

                                $horaFin = $time->format('H:i');
                            }

                            $eventoevaluacion = new Eventoevaluacion();
                            $eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $pasoDos['evaluacionid']));
                            $eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                            $eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                            $eventoevaluacion->setFechainicio(new \DateTime($f));
                            $eventoevaluacion->setFechafin(new \DateTime($f));
                            $eventoevaluacion->setHorainicio(new \DateTime($horaInicio));
                            $eventoevaluacion->setHorafin(new \DateTime($horaFin));
                            $eventoevaluacion->setCupo($entrevista['cupo']);
                            $eventoevaluacion->setBloquegradoentrevistaid($bloquegradoentrevista);
                            $dbm->saveRepositorio($eventoevaluacion);

                            foreach($ev['gradoid'] as $grado){
                                $grado = (array) $grado;
                                $gradoporeventoevaluacion = new Gradoporeventoevaluacion();
                                $gradoporeventoevaluacion->setEventoevaluacionid($eventoevaluacion);
                                $gradoporeventoevaluacion->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                $dbm->saveRepositorio($gradoporeventoevaluacion);
                            }
                            
                        }
                    }
                }
    
            }
    
            foreach($pasoTres['examenes'] as $examen){
                foreach($examen['fechas'] as $fecha){
                    $bloquegradoevaluacion = new AdBloquegradoevaluacion();
                    $bloquegradoevaluacion->setBloquegradoid($bloquegrado);
                    $f = $fecha['fecha']['date']['day'] . '-' . $fecha['fecha']['date']['month'] . '-' . $fecha['fecha']['date']['year'];
                    $bloquegradoevaluacion->setFecha(new \DateTime($f));
                    $bloquegradoevaluacion->setHorainicio(new \DateTime($fecha['horainicio']));
                    $bloquegradoevaluacion->setHorafin(new \DateTime($fecha['horafin']));
                    $dbm->saveRepositorio($bloquegradoevaluacion);

                    foreach($examen['evaluacionid'] as $evaluacionid){
                        $evaid = new AdBloquegradoevaluacionevaluacion();
                        $evaid->setEvaluacionid($evaluacionid);
                        $evaid->setBloquegradoevaluacionid($bloquegradoevaluacion->getBloquegradoevaluacionid());
                        $dbm->saveRepositorio($evaid);
                    }

                    foreach($examen['tipoevaluacionid'] as $tipoevaluacionid){
                        $evaid = new AdBloquegradoevaluaciontipoevaluacion();
                        $evaid->setTipoevaluacionid($tipoevaluacionid);
                        $evaid->setBloquegradoevaluacionid($bloquegradoevaluacion->getBloquegradoevaluacionid());
                        $dbm->saveRepositorio($evaid);
                    }
    
                    foreach($fecha['evaluadores'] as $ev){
                        $evaluador = new AdBloquegradoevaluacionevaluador();
                        $evaluador->setBloquegradoevaluacionid($bloquegradoevaluacion);
                        $evaluador->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                        $evaluador->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                        $evaluador->setCupo($ev['cupo']);
                        $dbm->saveRepositorio($evaluador);
        
                        foreach($ev['gradoid'] as $grado){
                            $bloquegradoevaluacionevaluadorgrado = new AdBloquegradoevaluacionevaluadorgrado();
                            $bloquegradoevaluacionevaluadorgrado->setBloquegradoevaluacionevaluadorid($evaluador);
                            $bloquegradoevaluacionevaluadorgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                            $dbm->saveRepositorio($bloquegradoevaluacionevaluadorgrado);
                        }

                        $horaInicio = $fecha['horainicio'];
                        $horaFin = $fecha['horafin'];

                        foreach ($examen['evaluacionid'] as $evaluacionid) {
                            $eventoevaluacion = new Eventoevaluacion();
                            $eventoevaluacion->setEvaluacionid($dbm->getRepositorioById('Evaluacion', 'evaluacionid', $evaluacionid));
                            $eventoevaluacion->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $ev['usuarioid']));
                            $eventoevaluacion->setLugarid($dbm->getRepositorioById('Lugar', 'lugarid', $ev['lugarid']));
                            $eventoevaluacion->setFechainicio(new \DateTime($f));
                            $eventoevaluacion->setFechafin(new \DateTime($f));
                            $eventoevaluacion->setHorainicio(new \DateTime($horaInicio));
                            $eventoevaluacion->setHorafin(new \DateTime($horaFin));
                            $eventoevaluacion->setCupo($ev['cupo']);
                            $eventoevaluacion->setBloquegradoevaluacionid($bloquegradoevaluacion);
                            $dbm->saveRepositorio($eventoevaluacion);

                            foreach ($ev['gradoid'] as $grado) {
                                $grado = (array) $grado;
                                $gradoporeventoevaluacion = new Gradoporeventoevaluacion();
                                $gradoporeventoevaluacion->setEventoevaluacionid($eventoevaluacion);
                                $gradoporeventoevaluacion->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                                $dbm->saveRepositorio($gradoporeventoevaluacion);
                            }
                        }
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Regresa el bloque por grado
     * @Rest\Delete("/api/BloquePorGrado/{id}", name="BloquePorGradoEliminar")
     */
    public function EliminarBloquePorGrado($id){
        try{
            $dbm = $this->get("db_manager");
            $db = new DbmAdmisiones($dbm->getEntityManager());
            $bloquegrado = $db->getBloqueGradoDelete($id);
            if($bloquegrado){
                if($bloquegrado['eliminable']){
                    $bg = $dbm->getRepositorioById('AdBloquegrado', 'bloquegradoid', $bloquegrado['bloquegradoid']);
                    if($bg){
                        foreach($bloquegrado['evaluaciones'] as $evaluacion){
                            $evalua = $dbm->getRepositorioById('AdBloquegradoevaluacion', 'bloquegradoevaluacionid', $evaluacion['bloquegradoevaluacionid']);
                            if($evalua){
                                foreach($evaluacion['evaluacionid'] as $evaluacionid){
                                    $evaluacionids = $dbm->getRepositorioById('AdBloquegradoevaluacionevaluacion', 'bloquegradoevaluacionevaluacionid', $evaluacionid);
                                    if($evaluacionids){
                                        $dbm->removeRepositorio($evaluacionids);
                                    }
                                }
                                foreach($evaluacion['tipoevaluacionid'] as $tipoevaluacionid){
                                    $tipoevaluacionids = $dbm->getRepositorioById('AdBloquegradoevaluaciontipoevaluacion', 'bloquegradoevaluaciontipoevaluacionid', $tipoevaluacionid);
                                    if($tipoevaluacionids){
                                        $dbm->removeRepositorio($tipoevaluacionids);
                                    }
                                }
                                foreach($evaluacion['evaluadores'] as $evaluador){
                                    $eval = $dbm->getRepositorioById('AdBloquegradoevaluacionevaluador', 'bloquegradoevaluacionevaluadorid', $evaluador['bloquegradoevaluacionevaluadorid']);
                                    if($eval){
                                        foreach($evaluador['eventos'] as $evento){
                                            $ev = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $evento['eventoevaluacionid']);
                                            if($ev){
                                                foreach($evento['gradoporeventoevaluacion'] as $gradoporeventoevaluacion){
                                                    $gpee = $dbm->getRepositorioById('Gradoporeventoevaluacion', 'gradoporeventoevaluacionid', $gradoporeventoevaluacion['gradoporeventoevaluacionid']);
                                                    if($gpee){
                                                        $dbm->removeRepositorio($gpee);
                                                    }
                                                }
                                                $dbm->removeRepositorio($ev);
                                            }
                                        }
                                        foreach($evaluador['bloquegradoevaluacionevaluadorgrado'] as $bloquegradoevaluacionevaluadorgrado){
                                            $bgeeg = $dbm->getRepositorioById('AdBloquegradoevaluacionevaluadorgrado', 'bloquegradoevaluacionevaluadorgradoid', $bloquegradoevaluacionevaluadorgrado['bloquegradoevaluacionevaluadorgradoid']);
                                            if($bgeeg){
                                                $dbm->removeRepositorio($bgeeg);
                                            }
                                        }
                                        $dbm->removeRepositorio($eval);
                                    }
                                }   
                                $dbm->removeRepositorio($evalua);
                            }
                        }
                        foreach($bloquegrado['entrevistas'] as $entrevista){
                            $evalua = $dbm->getRepositorioById('AdBloquegradoentrevista', 'bloquegradoentrevistaid', $entrevista['bloquegradoentrevistaid']);
                            if($evalua){
                                foreach($entrevista['evaluadores'] as $evaluador){
                                    $eval = $dbm->getRepositorioById('AdBloquegradoentrevistaevaluador', 'bloquegradoentrevistaevaluadorid', $evaluador['bloquegradoentrevistaevaluadorid']);
                                    if($eval){
                                        foreach($evaluador['eventos'] as $evento){
                                            $ev = $dbm->getRepositorioById('Eventoevaluacion', 'eventoevaluacionid', $evento['eventoevaluacionid']);
                                            if($ev){
                                                foreach($evento['gradoporeventoevaluacion'] as $gradoporeventoevaluacion){
                                                    $gpee = $dbm->getRepositorioById('Gradoporeventoevaluacion', 'gradoporeventoevaluacionid', $gradoporeventoevaluacion['gradoporeventoevaluacionid']);
                                                    if($gpee){
                                                        $dbm->removeRepositorio($gpee);
                                                    }
                                                }
                                                $dbm->removeRepositorio($ev);
                                            }
                                        }
                                        foreach($evaluador['bloquegradoentrevistaevaluadorgrado'] as $bloquegradoentrevistaevaluadorgrado){
                                            $bgeeg = $dbm->getRepositorioById('AdBloquegradoentrevistaevaluadorgrado', 'bloquegradoentrevistaevaluadorgradoid', $bloquegradoentrevistaevaluadorgrado['bloquegradoentrevistaevaluadorgradoid']);
                                            if($bgeeg){
                                                $dbm->removeRepositorio($bgeeg);
                                            }
                                        }
                                        $dbm->removeRepositorio($eval);
                                    }
                                }   
                                $dbm->removeRepositorio($evalua);
                            }
                        }
                        foreach($bloquegrado['bloqueporgrado'] as $bloqueporgrado){
                            $gr = $dbm->getRepositorioById('AdBloqueporgradoid', 'bloqueporgradoid', $bloqueporgrado['bloqueporgradoid']);
                            if($gr){
                                $dbm->removeRepositorio($gr);
                            }
                        }
                        $dbm->removeRepositorio($bg);
                        return new View('Se ha eliminado el registro', Response::HTTP_OK);
                    }else{
                        return new View('No se puede eliminar este bloque por que ya tiene solicitudes asignadas', Response::HTTP_PARTIAL_CONTENT);
                    }
                }else{
                    return new View('No se puede eliminar este bloque por que ya tiene solicitudes asignadas', Response::HTTP_PARTIAL_CONTENT);
                }

            }else{
                return new View('Registro no econtrado', Response::HTTP_PARTIAL_CONTENT);
            }
        }catch(\Exception $e){
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}