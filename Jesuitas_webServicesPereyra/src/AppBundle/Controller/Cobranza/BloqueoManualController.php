<?php

namespace AppBundle\Controller\Cobranza;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\CbBloqueomanual;
use AppBundle\Entity\CbTipobloqueoporbloqueomanual;

use AppBundle\DB\DbmCobranza;
use AppBundle\DB\DbmControlescolar;

/**
 * Auto: Javier
 */
class BloqueoManualController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cobranza/Bloqueomanual", name="indexBloquemanual")
     */
    public function indexBloqueomanual() {
        try {
        	$dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
        	$ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
        	$tipobloqueo = $dbm->getRepositoriosById('CbTipobloqueo', 'activo', 1);
        	$estatus = $dbm->getRepositoriosById('CbEstatusbloqueo', 'activo', 1);
        	
        	$nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
        	$grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
        	$grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
        	
        	return new View(array("ciclo" => $ciclo,
        			"nivel" => $nivel,
        			"grado" => $grado,
        			"grupo" => $grupo,
        			"tipobloqueo" => $tipobloqueo,
        			"estatus" => $estatus
        	), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    
    /**
     * Retorna arreglo de bloqueos en base a los parametros enviados
     * @Rest\Get("/api/Cobranza/Bloqueomanual/", name="BuscarBloquemanual")
     */
    public function getBloqueomanual() {
    	try {
    		$datos = $_REQUEST;
    		$filtros = array_filter($datos);
    		$dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarBloqueoManual($filtros);
            $bloqueo = array();
            foreach ($entidad as $a) {
                $filtro = array_merge($filtros, array("alumnoporcicloid" => $a['alumnoporcicloid'], "alumnoid" => array($a["alumnoid"])));
                $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
                $alumno = $dbma->BuscarAlumnosA($filtro);
                if ($alumno) {
                    array_push($bloqueo, array("bloqueo" => $a, "alumno" => $alumno[0]));
                }
            }
    		if (!$bloqueo) {
    			return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
    		}
    		return new View($bloqueo, Response::HTTP_OK);
    	} catch (Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }    
    
   /**
     * Retorna arreglo de bloqueos en base a los parametros enviados
     * @Rest\Get("/api/Cobranza/Bloqueomanual/Alumno/", name="getBloqueomanualByAlumno")
     */
    public function getBloqueomanualByAlumno() {
    	try {
            $datos = $_REQUEST;
            $alumnobloqueado = null;
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbmce= new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $tipobloqueos = [];
            foreach($datos['alumnoid'] as $alumno) {
                $infoalumno = $dbmce->BuscarAlumnosA(['alumnoid' => $alumno]);
                $bloqueoalumno = $dbm->getByParametersRepositorios('CbBloqueomanual', [
                    'alumnoporcicloid' => $infoalumno[0]["alumnoporcicloid"],
                    'estatusbloqueoid' =>  1
                ]);
                if(!$bloqueoalumno){
                    continue;
                }
                foreach($bloqueoalumno as $ba) {
                    if($ba->getFechainicio() < new \DateTime()) {
                        continue;
                    }
                    $arraybloqueos =  $dbm->getRepositoriosById('CbTipobloqueoporbloqueomanual', 'bloqueomanualid', $ba->getBloqueomanualid());
                    
                    foreach($arraybloqueos as $b) {
                        if ($datos['tipo'] == 1) {
                            if($b->getTipobloqueoid()->getTipobloqueoid() == 1) {
                                array_push($tipobloqueos, $b->getTipobloqueoid()); 
                                if(!$alumnobloqueado) {
                                    $alumnobloqueado = [
                                        'bloqueoactivo' => true,
                                        'matricula' => $infoalumno[0]['matricula'],
                                        'nombrecompleto' => $infoalumno[0]['nombrecompleto'],
                                        'motivosbloqueo' => $tipobloqueos,
                                        'observaciones' => $ba->getObservaciones()
                                    ];
                                }
                            }
                        } else {
                            if($b->getTipobloqueoid()->getTipobloqueoid() == 2 || $b->getTipobloqueoid()->getTipobloqueoid() == 3) {
                                array_push($tipobloqueos, $b['tipobloqueoid']); 
                                if(!$alumnobloqueado) {
                                    $alumnobloqueado = [
                                        'bloqueoactivo' => true,
                                        'matricula' => $infoalumno[0]['matricula'],
                                        'nombrecompleto' => $infoalumno[0]['nombrecompleto'],
                                        'motivosbloqueo' => $tipobloqueos,
                                        'observaciones' => $ba->getObservaciones()
                                    ];
                                }
                            }
                        }
                    }   
                }
            }
            if (!$alumnobloqueado) {
    			return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
    		}
    		return new View($alumnobloqueado, Response::HTTP_OK);
    	} catch (Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }  

    /**
     * Cancela un acuerdo
     * @Rest\Put("/api/Cobranza/Bloqueomanual/Cancelar", name="CancelarBloquemanual")
     */
    public function cancelBloquemanual() {
        try {
        	parse_str(file_get_contents("php://input"), $data);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            
            foreach ($data["bloqueos"] as $id){            	
            	$bloqueo = $dbm->getRepositorioById('CbBloqueomanual', 'bloqueomanualid', $id);
            	$bloqueo->setEstatusbloqueoid($dbm->getRepositorioById('CbEstatusbloqueo', 'estatusbloqueoid', 2));
            	$bloqueo->setFechafin(new \DateTime());
            	$dbm->saveRepositorio($bloqueo);            	
            }
            
            $dbm->getConnection()->commit();
            return new View("Se ha cancelado el bloqueo", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Cobranza/Bloqueomanual" , name="GuardarBloquemanual")
     */
    public function SaveBloquemanual() {
        try {
            $data = $_REQUEST;
            $data = json_decode($data["datos"], true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            
            $alumnociclo = $dbm->getByParametersRepositorios('CeAlumnoporciclo', [ 
                'alumnoid' =>$data["alumnoid"],
                'cicloid' => $data["cicloid"]
            ]);
            if(!$alumnociclo){
            	return new View("El alumno no ha sido inscrito en el ciclo seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach ($alumnociclo as $ac) {
                $datos = [];
                $bloqueovigente = $dbm->getByParametersRepositorios('CbBloqueomanual', [ 
                    'alumnoporcicloid' => $ac->getAlumnoporcicloid(),
                    'estatusbloqueoid'  => 1
                    ]
                );
                foreach($bloqueovigente as $bloqueo) {
                    $motivosbloqueo = $dbm->getRepositoriosById('CbTipobloqueoporbloqueomanual', 'bloqueomanualid', $bloqueo->getBloqueomanualid());
                    foreach($motivosbloqueo as $motivo) {
                        foreach($data['tipobloqueoid'] as $tipo) {
                            if(!$motivo->getTipobloqueoid()) {
                                continue;
                            }
                            if($motivo->getTipobloqueoid()->getTipobloqueoid() == $tipo) {
                                return new view("Ya existe un bloqueo vigente con el mismo tipo de bloqueo", Response::HTTP_PARTIAL_CONTENT);
                            }
                        }
                    }
                }

                $datos["bloqueoid"] = $data["bloqueoid"];
                $datos["alumnoid"] = $data["alumnoid"];
                $datos["cicloid"] = $data["cicloid"];
                $datos["tipobloqueoid"] = $data["tipobloqueoid"];
                $datos["fechainicio"] = new \DateTime($data["fechainicio"]["date"]["day"] . "-" . $data["fechainicio"]["date"]["month"] . "-" . $data["fechainicio"]["date"]["year"]);
                $datos["observaciones"] = $data["observaciones"];
                $datos["alumnoporcicloid"] = $ac->getAlumnoporcicloid();
                $datos["estatusbloqueoid"] = 1;

                $hydrator = new ArrayHydrator($dbm->getEntityManager());
                $bloqueo = $hydrator->hydrate(new CbBloqueomanual(), $datos);
                $dbm->saveRepositorio($bloqueo);

                foreach($data["tipobloqueoid"] as $tb){
                    $tipobloqueo = new CbTipobloqueoporbloqueomanual();
                    $tipobloqueo->setBloqueomanualid($bloqueo);
                    $tipobloqueo->setTipobloqueoid($dbm->getRepositorioById('CbTipobloqueo', 'tipobloqueoid', $tb));
                    $dbm->saveRepositorio($tipobloqueo);
                }  
            }
          
            
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Cobranza/Bloqueomanual/{id}" , name="ActualizarBloquemanual")
     */
    public function updateBloquemanual($id) {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $data = json_decode($data["datos"], true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $actualizado = false;

            $cicloa = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $data['alumnoporcicloid']);
            if(!$cicloa){
            	return new View("No se el encontró el registro del alumno en el ciclo", Response::HTTP_PARTIAL_CONTENT);
            }
            if($cicloa->getCicloid()->getCicloid() == $data['cicloid']) {
                $alumnociclo = [$cicloa];
            } else {
                $alumnociclo = $dbm->getByParametersRepositorios('CeAlumnoporciclo', [ 
                    'alumnoid' =>$data["alumnoid"],
                    'cicloid' => $data["cicloid"]
                ]);
            }
            if(!$alumnociclo){
            	return new View("No se encontró ninguna relación del alumno con el ciclo", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach ($alumnociclo as $ac) {
                $datos = [];
                $bloqueovigente = $dbm->getByParametersRepositorios('CbBloqueomanual', [ 
                        'alumnoporcicloid' => $ac->getAlumnoporcicloid(),
                        'estatusbloqueoid'  => 1
                    ]
                );
                foreach($bloqueovigente as $bloqueo) {
                    if($bloqueo->getBloqueomanualid() == $id) {
                        continue;
                    }
                    $motivosbloqueo = $dbm->getRepositoriosById('CbTipobloqueoporbloqueomanual', 'bloqueomanualid', $bloqueo->getBloqueomanualid());
                    foreach($motivosbloqueo as $motivo) {
                        foreach($data['tipobloqueoid'] as $tipo) {
                            if(!$motivo->getTipobloqueoid()) {
                                continue;
                            }
                            if($motivo->getTipobloqueoid()->getTipobloqueoid() == $tipo) {
                                return new view("Ya existe un bloqueo vigente con el mismo tipo de bloqueo", Response::HTTP_PARTIAL_CONTENT);
                            }
                        }
                    }
                }
    
                $datos["bloqueoid"] = $data["bloqueoid"];
                $datos["alumnoid"] = $data["alumnoid"];
                $datos["cicloid"] = $data["cicloid"];
                $datos["tipobloqueoid"] = $data["tipobloqueoid"];
                $datos["fechainicio"] = new \DateTime($data["fechainicio"]["date"]["day"] . "-" . $data["fechainicio"]["date"]["month"] . "-" . $data["fechainicio"]["date"]["year"]);
                $datos["observaciones"] = $data["observaciones"];
                $datos["alumnoporcicloid"] = $ac->getAlumnoporcicloid();
                $datos["estatusbloqueoid"] = 1;
                
                $hydrator = new ArrayHydrator($dbm->getEntityManager());
                if(!$actualizado) {
                    $bloqueo = $hydrator->hydrate($dbm->getRepositorioById('CbBloqueomanual', 'bloqueomanualid', $id), $datos);
                    $dbm->saveRepositorio($bloqueo);
        
                    $dbm->removeManyRepositorio("CbTipobloqueoporbloqueomanual", "bloqueomanualid", $id);
                    foreach($data["tipobloqueoid"] as $tb){
                        $tipobloqueo = new CbTipobloqueoporbloqueomanual();
                        $tipobloqueo->setBloqueomanualid($bloqueo);
                        $tipobloqueo->setTipobloqueoid($dbm->getRepositorioById('CbTipobloqueo', 'tipobloqueoid', $tb));
                        $dbm->saveRepositorio($tipobloqueo);
                    } 
                    $actualizado = true;
                } else {
                    $hydrator = new ArrayHydrator($dbm->getEntityManager());
                    $bloqueo = $hydrator->hydrate(new CbBloqueomanual(), $datos);
                    $dbm->saveRepositorio($bloqueo);
    
                    foreach($data["tipobloqueoid"] as $tb){
                        $tipobloqueo = new CbTipobloqueoporbloqueomanual();
                        $tipobloqueo->setBloqueomanualid($bloqueo);
                        $tipobloqueo->setTipobloqueoid($dbm->getRepositorioById('CbTipobloqueo', 'tipobloqueoid', $tb));
                        $dbm->saveRepositorio($tipobloqueo);
                    } 
                }

            }

            
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
 

}
