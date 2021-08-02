<?php

namespace AppBundle\Controller\Becas\Modal;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Controller\lib\Hydrator\JsonApiHydrator;
use FOS\RestBundle\View\View;
use AppBundle\Entity\BcDependienteseconomicoshijos;
use AppBundle\Entity\BcOtrosdependienteseconomicos;

/**
 * Auto: rubén
 */
class DependientesEconomicosController extends FOSRestController {

    /**
     * Retorna el resultado que coincida con el ID enviado de Ingresos Familiares
     * @Rest\Get("/api/Becas/SolicitudBeca/DependientesEconomicos/{id}", name="ObtenerDependientesEconomicos")
     */
    public function ObtenerDependientesEconomicos($id) {
        try {
            $dbm = $this->get("db_manager"); 

            $solicitudbeca = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $id);                         
            $dependienteseconomicoshijos = $dbm->getRepositoriosById('BcDependienteseconomicoshijos', 'solicitudid', $id);    
            $otrosdependienteseconomicos = $dbm->getRepositoriosById('BcOtrosdependienteseconomicos', 'solicitudid', $id);
            
            if(!empty($ingresofamiliar)){
                $ingresofamiliar->setSolicitudid(null);
            }           

            $resultadodependienteseconomicoshijos = [];
            foreach($dependienteseconomicoshijos as $valor){
                if(!empty($valor))
                    $valor->setSolicitudid(null);
                    array_push($resultadodependienteseconomicoshijos, $valor);
            } 
            
            $resultadootrosdependienteseconomicos = [];
            foreach($otrosdependienteseconomicos as $valor){
                if(!empty($valor))
                    $valor->setSolicitudid(null);
                    array_push($resultadootrosdependienteseconomicos, $valor);
            } 
            
            $situacionconyugal=$dbm->getRepositorios("Situacionconyugal");
            $dependienteseconomicos = array(
                "solicitud"=> $solicitudbeca,
                "dependienteseconomicoshijos"=> $resultadodependienteseconomicoshijos,
                "otrosdependienteseconomicos"=> $resultadootrosdependienteseconomicos,
                "situacionconyugal"=>$situacionconyugal             
            );

            return new View($dependienteseconomicos, Response::HTTP_OK);            
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el resultado que coincida con el ID enviado de Ingresos Familiares
     * @Rest\Get("/api/Becas/SolicitudBeca/DependientesEconomicos/ObtenerHijos/{id}", name="ObtenerHijos")
     */
    public function ObtenerHijos($id) {
        try {
            $dbm = $this->get("db_manager");            
            $dependienteseconomicoshijos = $dbm->getRepositoriosById('BcDependienteseconomicoshijos', 'solicitudid', $id); 
            $resultado = [];
            foreach($dependienteseconomicoshijos as $valor){
                if(!empty($valor))
                    $valor->setSolicitudid(null);
                    array_push($resultado, $valor);
            }           
            return new View(array("dependienteseconomicoshijos" => $resultado), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Método para Guardar o Editar los Ingresos Familiares en la Solicitud de Becas
     * @Rest\Post("/api/Becas/SolicitudBeca/DependientesEconomicos/Hijos", name="GuardaoEditaHijos")
     */
    public function GuardaoEditaHijos() {
        try {
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true); 

            $dbm = $this->get("db_manager");        
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $dependienteseconomicoshijosentidad   = $hydrator->hydrate('AppBundle\Entity\BcDependienteseconomicoshijos', $decoded);

            $dependienteseconomicoshijos = $dbm->getRepositorioById('BcDependienteseconomicoshijos', 'dependienteseconomicosid', $decoded['dependienteseconomicosid']);

            if(empty($dependienteseconomicoshijos)){                
                if(is_a($dependienteseconomicoshijosentidad, 'AppBundle\Entity\BcDependienteseconomicoshijos')){
                    $dbm->getConnection()->beginTransaction();
                    $dbm->saveRepositorio($dependienteseconomicoshijosentidad);
                    $dbm->getConnection()->commit();
                }else{
                    return new View("Parámetros de entrada no coinciden con la entidad", Response::HTTP_BAD_REQUEST);
                }
            }else{
                $dbm->getConnection()->beginTransaction();                
                $dependienteseconomicoshijos->setNombrecompleto($decoded['nombrecompleto']);
                $dependienteseconomicoshijos->setNombreescuela($decoded['nombreescuela']);
                $dependienteseconomicoshijos->setNivel($decoded['nivel']);
                $dependienteseconomicoshijos->setGrado($decoded['grado']);
                $dependienteseconomicoshijos->setCostoanual($decoded['costoanual']);                
                $dbm->saveRepositorio($dependienteseconomicoshijos);
                $dbm->getConnection()->commit();
            }
            return new View("Registro guardado/actualizado de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el resultado que coincida con el ID enviado de Vehículos
     * @Rest\Delete("/api/Becas/SolicitudBeca/DependientesEconomicos/Hijos/{id}", name="EliminarHijos")
     */
    public function EliminarHijos($id) {
        try {
            $dbm = $this->get("db_manager");            
            $dependienteseconomicoshijos = $dbm->getRepositorioById('BcDependienteseconomicoshijos', 'dependienteseconomicosid', $id);   
            if(empty($dependienteseconomicoshijos)){
                return new View("Dependiente económico hijo no encontrado", Response::HTTP_BAD_REQUEST);                
            }else{
                $dbm->getConnection()->beginTransaction();
                $dbm->removeRepositorio($dependienteseconomicoshijos);
                $dbm->getConnection()->commit();
            }      
            return new View("Eliminado de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el resultado que coincida con el ID enviado de Ingresos Familiares
     * @Rest\Get("/api/Becas/SolicitudBeca/DependientesEconomicos/ObtenerOtrosDependientes/{id}", name="ObtenerOtrosDependientes")
     */
    public function ObtenerOtrosDependientes($id) {
        try {
            $dbm = $this->get("db_manager");                        
            $otrosdependienteseconomicos = $dbm->getRepositoriosById('BcOtrosdependienteseconomicos', 'solicitudid', $id);
            $resultado = [];
            foreach($otrosdependienteseconomicos as $valor){
                if(!empty($valor))
                    $valor->setSolicitudid(null);
                    array_push($resultado, $valor);
            }            
            return new View(array("otrosdependienteseconomicos" => $resultado), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Método para Guardar o Editar los Ingresos Familiares en la Solicitud de Becas
     * @Rest\Post("/api/Becas/SolicitudBeca/DependientesEconomicos/OtrosDependientes", name="OtrosDependientes")
     */
    public function OtrosDependientes() {
        try {
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true); 

            $dbm = $this->get("db_manager");        
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $otrosdependienteseconomicosentidad   = $hydrator->hydrate('AppBundle\Entity\BcOtrosdependienteseconomicos', $decoded);

            $otrosdependienteseconomicos = $dbm->getRepositorioById('BcOtrosdependienteseconomicos', 'otrosdependientesid', $decoded['otrosdependientesid']);

            if(empty($otrosdependienteseconomicos)){                
                if(is_a($otrosdependienteseconomicosentidad, 'AppBundle\Entity\BcOtrosdependienteseconomicos')){
                    $dbm->getConnection()->beginTransaction();
                    $dbm->saveRepositorio($otrosdependienteseconomicosentidad);
                    $dbm->getConnection()->commit();
                }else{
                    return new View("Parámetros de entrada no coinciden con la entidad", Response::HTTP_BAD_REQUEST);
                }
            }else{
                $dbm->getConnection()->beginTransaction();                
                $otrosdependienteseconomicos->setNombrecompleto($decoded['nombrecompleto']);
                $otrosdependienteseconomicos->setRelacion($decoded['relacion']);
                $otrosdependienteseconomicos->setOcupacion($decoded['ocupacion']);
                $dbm->saveRepositorio($otrosdependienteseconomicos);
                $dbm->getConnection()->commit();
            }
            return new View("Registro guardado/actualizado de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el resultado que coincida con el ID enviado de Vehículos
     * @Rest\Delete("/api/Becas/SolicitudBeca/DependientesEconomicos/Otrosdependienteseconomicos/{id}", name="EliminarOtrosdependienteseconomicos")
     */
    public function EliminarOtrosdependienteseconomicos($id) {
        try {
            $dbm = $this->get("db_manager");            
            $otrosdependienteseconomicos = $dbm->getRepositorioById('BcOtrosdependienteseconomicos', 'otrosdependientesid', $id);   
            if(empty($otrosdependienteseconomicos)){
                return new View("Otro dependiente económico no encontrado", Response::HTTP_BAD_REQUEST);                
            }else{
                $dbm->getConnection()->beginTransaction();
                $dbm->removeRepositorio($otrosdependienteseconomicos);
                $dbm->getConnection()->commit();
            }      
            return new View("Eliminado de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}