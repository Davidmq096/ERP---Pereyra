<?php

namespace AppBundle\Controller\FondoOrfandad;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\FoFondoorfandad;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Icicle\Coroutine\Coroutine;
use Icicle\Loop;
use Icicle\Awaitable;
/**
 * Auto: Judith
 */
class FondoOrfandadController extends FOSRestController {

    /**
     * Retorna estatus
     * @Rest\Get("/api/FondoOrfandad/Index", name="indexfondoorfandad")
     */
    public function indexfondoorfandad() {
        try {
            $dbm = $this->get("db_manager");
            $ciclo = $dbm->getRepositoriosById('Ciclo','activo',1);
            $grado = $dbm->getRepositoriosById('Grado','activo',1);
            $nivel = $dbm->getRepositoriosById('Nivel','activo',1);
            $estatus = $dbm->getRepositorios('FoEstatus');
            return new View(array("ciclo" => $ciclo,"grado"=>$grado,"nivel"=>$nivel,"estatus"=>$estatus), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * Retorna filtros
     * @Rest\Post("/api/FondoOrfandad/Filtrar", name="fondoOrfandadfiltro")
     */
    public function fondoOrfandadfiltro() {
        try {
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true);  
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $entidad = $dbm->BuscarFondoOrfandad($decoded);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * @Rest\Post("/api/FondoOrfandad/GuardarFo" , name="GuardarFondoOrfandad")
     */
    public function GuardarFondoOrfandad() {
        try {
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true);  
            $dbm = $this->get("db_manager");

            if ($dbm->getByParametersRepositorios('FoFondoorfandad', array('alumnoid'=> $decoded['alumnoid'], 'estatusid'=> 1, 'cicloid' => $decoded['cicloid']))) {
                return new View("Ya existe Fondo de orfandad activo para el alumno seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }

            $decoded["fechainicio"] = $decoded["fechainicio"]["date"]["year"]."-".$decoded["fechainicio"]["date"]["month"]."-".$decoded["fechainicio"]["date"]["day"];
            $decoded["estatusid"] = 1;
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $entity = $hydrator->hydrate(new FoFondoorfandad(), $decoded);

            $dbm->getConnection()->beginTransaction();
           $dbm->saveRepositorio($entity);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el Fondo de orfandad", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
	}


/**
     * @Rest\Post("/api/FondoOrfandad/ActualizarFo/{id}" , name="ActualizarFondoOrfandad")
     */
    public function ActualizarFondoOrfandad($id) {
        try {
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true);  
            $dbm = $this->get("db_manager");

            $decoded["fechainicio"] = $decoded["fechainicio"]["date"]["year"]."-".$decoded["fechainicio"]["date"]["month"]."-".$decoded["fechainicio"]["date"]["day"];
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $entity = $hydrator->hydrate( $dbm->getRepositorioById('FoFondoorfandad', 'fondoorfandadid', $id), $decoded);            

            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($entity);
            $dbm->getConnection()->commit();
            return new View("Se ha Actualizado el fondo de orfandad", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
	}


     /**
     * Retorna el archivo layout
     * @Rest\Get("/api/FondoOrfandad/ImportacionOrfandad/", name="archivodownloadt")
     */
    public function downloadLayout() {
        try {
            $dbm = $this->get("db_manager");
            $datos = $_REQUEST;

            $Excel = $this->get('phpexcel')->createPHPExcelObject();
            $layout = \AppBundle\Dominio\ImportacionOrfandad::layout($dbm, $datos, $Excel);
            $writer = $this->get('phpexcel')->createWriter($layout, 'Excel5');
            $response = $this->get('phpexcel')->createStreamedResponse($writer);
            $dispositionHeader = $response->headers->makeDisposition(
                    ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'stream-file.xls');
            $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Cache-Control', 'maxage=1');
            $response->headers->set('Content-Disposition', $dispositionHeader);

            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * Retorna el archivo layout
     *  @Rest\POST("/api/FondoOrfandad/ImportacionOrfandad" , name="archivoimportacion")
     */
    public function importarLayout() {
        try {
            if ($_FILES['layout']['error'] == 1) {
                return new View("El archivo excede el peso permitido "
                        , Response::HTTP_PARTIAL_CONTENT);
            }
            $iniPrecision = ini_get('precision');
            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($_FILES['layout']['tmp_name']);
            ini_set('precision', $iniPrecision);
            $sheet = $phpExcelObject->getActiveSheet();
            $phpExcelObject->getProperties();

            $pagemax = $sheet->getHighestDataRow();

            $Solicitudid = $sheet->rangeToArray('A2:' . $sheet->getHighestDataColumn() . $sheet->getHighestDataRow(), null, true, true, true);
            $Preguntasid = $sheet->rangeToArray('A1:' . $sheet->getHighestDataColumn() . '1', null, true, true, true);            
            
            $guardar = function () use ($Solicitudid, $Preguntasid, $sheet){   
                $dbm = $this->get("db_manager");
                $dbm->getConnection()->beginTransaction(); 
                yield Awaitable\resolve(self::insertarLayout($Solicitudid, $Preguntasid, $sheet));
                $dbm->getConnection()->commit();
            };            
            
            $routine = new Coroutine($guardar());
            Loop\Run();
            
            return new View("Se proceso correctamente el archivo. ".sizeof($Solicitudid)." registros fueron importados.", Response::HTTP_OK); 
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function insertarLayout($Solicitudid, $Preguntasid, $sheet) {
        $dbm = $this->get("db_manager");
        
        foreach ($Solicitudid as $row => $s) {
            if(empty($s['A'])){
                return new View("El contenido del archivo no es el correcto", Response::HTTP_PARTIAL_CONTENT);
            }else{
                
                $Alumno = $dbm->getRepositorioById('CeAlumno', 'matricula', $s['A']);
                $Ciclo = $dbm->getRepositorioById('Ciclo', 'siguiente', 1);        

                if($Ciclo){                    
                    $Estatus = $dbm->getRepositorioById('FoEstatus', 'estatusid', '1');
                    $FondoOrfandad = $dbm->getRepositorioById('FoFondoorfandad', 'alumnoid', $Alumno->getAlumnoid());
                    $FondoOrfandad = $FondoOrfandad ? $FondoOrfandad : new FoFondoorfandad();
                    
                    $FondoOrfandad->setAlumnoid($Alumno);
                    $FondoOrfandad->setCicloid($Ciclo);
                    $FondoOrfandad->setFechainicio(\DateTime::createFromFormat('m-d-y', $s['B']));
                    $FondoOrfandad->setComentarios($s['D'] ? $s['D'] : "");
                    $FondoOrfandad->setPorcentajeapoyo($s['C']);
                    $FondoOrfandad->setEstatusid($Estatus);
                    $dbm->saveRepositorio($FondoOrfandad);
                }else{                    
                    return new View("El contenido del archivo no es el correcto", Response::HTTP_PARTIAL_CONTENT);
                }                
            }                       
        }        
    }            


/**
     * @Rest\Post("/api/FondoOrfandad/Cancelar" , name="cancelarfondo")
     */
    public function cancelarfondo() {
        try {
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true);  
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
            foreach($decoded['listaFondoOrfandad'] as $f){
                $fondodeorfandad2 = $dbm->getRepositorioById('FoFondoorfandad', 'fondoorfandadid',$f);
                $fondodeorfandad2->setEstatusid($dbm->getRepositorioById('FoEstatus', 'estatusid',2));
                $dbm->saveRepositorio($fondodeorfandad2);
            }
            $dbm->getConnection()->commit();
            return new View("Cancelacion realizada", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}

