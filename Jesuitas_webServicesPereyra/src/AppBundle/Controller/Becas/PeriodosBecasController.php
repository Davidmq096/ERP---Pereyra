<?php

namespace AppBundle\Controller\Becas;

use AppBundle\DB\DbmBecas;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\BcPeriodobeca;
use AppBundle\Entity\BcPeriodobecaporformato;
use AppBundle\Entity\BcFormatobeca;
use AppBundle\Controller\lib\Enums\TipoDocumento;

/**
 * Auto: rubén
 */
class PeriodosBecasController extends FOSRestController
{

    /**
     * Método de pruebas
     * @Rest\Get("/api/Becas/Periodos", name="indexBecasPeriodos")
     */
    public function indexBecasPeriodos()
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());

            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $tokens = $dbm->getRepositorios('BcToken');
            $parametro = $dbm->getRepositorioById('Parametros', 'nombre', 'ModoPagoBecas');
            return new View(array("tokens" => $tokens, "ciclo" => $ciclo, 'parametro' => $parametro), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Almacenar periodo de becas
     * @Rest\Post("/api/Becas/PeriodosBecas/Filtrar", name="periodobecasfiltrar")
     */
    public function periodobecasfiltrar()
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (empty($content)) {
                $decoded = json_decode($datos, true);
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $entidades = $dbm->BuscarPeriodos($decoded);

            return new View($entidades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    
    /**
     * @Rest\Post("/api/Becas/PeriodoBeca" , name="GuardarPeriodoBeca")
     */
    public function GuardarPeriodoBeca() {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $parametro = $dbm->getRepositorioById('Parametros', 'nombre', 'ModoPagoBecas');
            $modopagobecas = $parametro && $parametro->getValor() == "2"  ? true : false; 

            if ($dbm->getRepositorioById('BcPeriodobeca', 'cicloid', $decoded["cicloid"])) {
            	return new View("Ya existe un periodo configurado para el ciclo", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $fechainipagoestudiose = new \DateTime($decoded["fechainipagoestudiose"]["beginDate"]["year"] . "-" . $decoded["fechainipagoestudiose"]["beginDate"]["month"] . "-" . $decoded["fechainipagoestudiose"]["beginDate"]["day"]);
            $fechafinpagoestudiose = new \DateTime($decoded["fechainipagoestudiose"]["endDate"]["year"] . "-" . $decoded["fechainipagoestudiose"]["endDate"]["month"] . "-" . $decoded["fechainipagoestudiose"]["endDate"]["day"]);
            $fechainicapturas = new \DateTime($decoded["fechainicapturas"]["beginDate"]["year"] . "-" . $decoded["fechainicapturas"]["beginDate"]["month"] . "-" . $decoded["fechainicapturas"]["beginDate"]["day"]);
            $fechafincapturas = new \DateTime($decoded["fechainicapturas"]["endDate"]["year"] . "-" . $decoded["fechainicapturas"]["endDate"]["month"] . "-" . $decoded["fechainicapturas"]["endDate"]["day"]);
            $fechainientregade = new \DateTime($decoded["fechainientregade"]["beginDate"]["year"] . "-" . $decoded["fechainientregade"]["beginDate"]["month"] . "-" . $decoded["fechainientregade"]["beginDate"]["day"]);
            $fechafinentregade = new \DateTime($decoded["fechainientregade"]["endDate"]["year"] . "-" . $decoded["fechainientregade"]["endDate"]["month"] . "-" . $decoded["fechainientregade"]["endDate"]["day"]);
            $decoded["fechainipagoestudiose"]=$fechainipagoestudiose;
            $decoded["fechafinpagoestudiose"]=$fechafinpagoestudiose;
            $decoded["fechainicapturas"]=$fechainicapturas;
            $decoded["fechafincapturas"]=$fechafincapturas;
            $decoded["fechainientregade"]=$fechainientregade;
            $decoded["fechafinentregade"]=$fechafinentregade;
            $decoded["fechainientregadp"]=$fechainientregadp;
            $decoded["activo"]=1;          
            $periodobeca = $hydrator->hydrate(new BcPeriodobeca(), $decoded);
            $dbm->saveRepositorio($periodobeca);

            $formato = new BcFormatobeca();
            $formato->setNombrearchivo($decoded['solicitud']['filename']);
            $formato->setArchivo(base64_decode($decoded['solicitud']['value']));
            $formato->setArchivosize($decoded['solicitud']['size']);
            $formato->setArchivotipo($decoded['solicitud']['filetype']);
            $formato->setActivo(1);
            $formato->setTipodocumentoid($dbm->getRepositorioById('BcTipodocumento', 'tipodocumentoid', 1));
            $dbm->saveRepositorio($formato);
            
            $periodoformato = new BcPeriodobecaporformato();
            $periodoformato->setFormatobecaid($formato);
            $periodoformato->setPeriodobecaid($periodobeca);
            $periodoformato->setActivo(1);
            $dbm->saveRepositorio($periodoformato);             

            $formato = new BcFormatobeca();
            $formato->setNombrearchivo($decoded['reglamento']['filename']);
            $formato->setArchivo(base64_decode($decoded['reglamento']['value']));
            $formato->setArchivosize($decoded['reglamento']['size']);
            $formato->setArchivotipo($decoded['reglamento']['filetype']);
            $formato->setActivo(1);
            $formato->setTipodocumentoid($dbm->getRepositorioById('BcTipodocumento', 'tipodocumentoid', 2));
            $dbm->saveRepositorio($formato);


            
            $periodoformato = new BcPeriodobecaporformato();
            $periodoformato->setFormatobecaid($formato);
            $periodoformato->setPeriodobecaid($periodobeca);
            $periodoformato->setActivo(1);
            $dbm->saveRepositorio($periodoformato);

            if($modopagobecas) {
                $formato = new BcFormatobeca();
                $formato->setNombrearchivo($decoded['reciboimpresion']['filename']);
                $formato->setArchivo(base64_decode($decoded['reciboimpresion']['value']));
                $formato->setArchivosize($decoded['reciboimpresion']['size']);
                $formato->setArchivotipo($decoded['reciboimpresion']['filetype']);
                $formato->setActivo(1);
                $formato->setTipodocumentoid($dbm->getRepositorioById('BcTipodocumento', 'tipodocumentoid', 4));
                $dbm->saveRepositorio($formato);
                
                $periodoformato = new BcPeriodobecaporformato();
                $periodoformato->setFormatobecaid($formato);
                $periodoformato->setPeriodobecaid($periodobeca);
                $periodoformato->setActivo(1);
                $dbm->saveRepositorio($periodoformato);
            }

            
            $dbm->getConnection()->commit();

           return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Becas/PeriodoBeca/{id}" , name="ActualizarPeriodoBeca")
     */
    public function ActualizarPeriodoBeca($id) {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $parametro = $dbm->getRepositorioById('Parametros', 'nombre', 'ModoPagoBecas');
            $modopagobecas = $parametro && $parametro->getValor() == "2"  ? true : false; 


            $validar = $dbm->getRepositorioById('BcPeriodobeca', 'cicloid', $decoded["cicloid"]);
            if ($validar && $validar->getPeriodobecaid() != $id) {
            	return new View("Ya existe un periodo configurado para el ciclo", Response::HTTP_PARTIAL_CONTENT);
            }
            $reciboimpresion = false;
            $dbm->getConnection()->beginTransaction();
            $fechainipagoestudiose = new \DateTime($decoded["fechainipagoestudiose"]["beginDate"]["year"] . "-" . $decoded["fechainipagoestudiose"]["beginDate"]["month"] . "-" . $decoded["fechainipagoestudiose"]["beginDate"]["day"]);
            $fechafinpagoestudiose = new \DateTime($decoded["fechainipagoestudiose"]["endDate"]["year"] . "-" . $decoded["fechainipagoestudiose"]["endDate"]["month"] . "-" . $decoded["fechainipagoestudiose"]["endDate"]["day"]);
            $fechainicapturas = new \DateTime($decoded["fechainicapturas"]["beginDate"]["year"] . "-" . $decoded["fechainicapturas"]["beginDate"]["month"] . "-" . $decoded["fechainicapturas"]["beginDate"]["day"]);
            $fechafincapturas = new \DateTime($decoded["fechainicapturas"]["endDate"]["year"] . "-" . $decoded["fechainicapturas"]["endDate"]["month"] . "-" . $decoded["fechainicapturas"]["endDate"]["day"]);
            $fechainientregade = new \DateTime($decoded["fechainientregade"]["beginDate"]["year"] . "-" . $decoded["fechainientregade"]["beginDate"]["month"] . "-" . $decoded["fechainientregade"]["beginDate"]["day"]);
            $fechafinentregade = new \DateTime($decoded["fechainientregade"]["endDate"]["year"] . "-" . $decoded["fechainientregade"]["endDate"]["month"] . "-" . $decoded["fechainientregade"]["endDate"]["day"]);
            $decoded["fechainipagoestudiose"]=$fechainipagoestudiose;
            $decoded["fechafinpagoestudiose"]=$fechafinpagoestudiose;
            $decoded["fechainicapturas"]=$fechainicapturas;
            $decoded["fechafincapturas"]=$fechafincapturas;
            $decoded["fechainientregade"]=$fechainientregade;
            $decoded["fechafinentregade"]=$fechafinentregade;
            $decoded["fechainientregadp"]=$fechainientregadp;
            $decoded["activo"]=1;
           
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $nperiodobeca = $hydrator->hydrate($dbm->getRepositorioById('BcPeriodobeca', 'periodobecaid', $id), $decoded);
            $dbm->saveRepositorio($nperiodobeca);

            $periodobecaformatos = $dbm->getRepositoriosById('BcPeriodobecaporformato', 'periodobecaid', $id);
            $fs =  $decoded['solicitud']; 
            if(!empty($fs)){    
                if(!empty($periodobecaformatos)){
                    foreach($periodobecaformatos as $item){
                        if($item->getFormatobecaid()->getTipodocumentoid()->getTipodocumentoid() == TipoDocumento::Solicitud){
                            $formatobeca = $dbm->getRepositorioById('BcFormatobeca', 'formatobecaid', $item->getFormatobecaid());                                
                                if(!empty($formatobeca)){
                                    $formatobeca->setNombrearchivo($fs['filename']);
                                    $formatobeca->setArchivo(base64_decode($fs['value']));
                                    $formatobeca->setArchivosize($fs['size']);
                                    $formatobeca->setArchivotipo($fs['filetype']); 
                                    $dbm->saveRepositorio($formatobeca);
                                }
                        }                           
                    }                                                
                }
            }

            $fs =  $decoded['reglamento']; 
            if(!empty($fs)){    
                if(!empty($periodobecaformatos)){
                    foreach($periodobecaformatos as $item){
                        if($item->getFormatobecaid()->getTipodocumentoid()->getTipodocumentoid() == TipoDocumento::Reglamento){
                            $formatobeca = $dbm->getRepositorioById('BcFormatobeca', 'formatobecaid', $item->getFormatobecaid());                                
                                if(!empty($formatobeca)){
                                    $formatobeca->setNombrearchivo($fs['filename']);
                                    $formatobeca->setArchivo(base64_decode($fs['value']));
                                    $formatobeca->setArchivosize($fs['size']);
                                    $formatobeca->setArchivotipo($fs['filetype']); 
                                    $dbm->saveRepositorio($formatobeca);
                                }
                        }                           
                    }                                                
               }
            }

            if($modopagobecas) {
                $fs =  $decoded['reciboimpresion']; 
                if(!empty($fs)){    
                    if(!empty($periodobecaformatos)){
                        foreach($periodobecaformatos as $item){
                            if($item->getFormatobecaid()->getTipodocumentoid()->getTipodocumentoid() == TipoDocumento::ReciboImpresion){
                                $formatobeca = $dbm->getRepositorioById('BcFormatobeca', 'formatobecaid', $item->getFormatobecaid());                                
                                    if(!empty($formatobeca)){
                                        $reciboimpresion = true;
                                        $formatobeca->setNombrearchivo($fs['filename']);
                                        $formatobeca->setArchivo(base64_decode($fs['value']));
                                        $formatobeca->setArchivosize($fs['size']);
                                        $formatobeca->setArchivotipo($fs['filetype']);
                                        $formatobeca->setTipodocumentoid($dbm->getRepositorioById('BcTipodocumento', 'tipodocumentoid', 4)); 
                                        $dbm->saveRepositorio($formatobeca);
                                }
                            }                           
                        }                                                
                    }
                    if(!$reciboimpresion) {
                        $formato = new BcFormatobeca();
                        $formato->setNombrearchivo($decoded['reciboimpresion']['filename']);
                        $formato->setArchivo(base64_decode($decoded['reciboimpresion']['value']));
                        $formato->setArchivosize($decoded['reciboimpresion']['size']);
                        $formato->setArchivotipo($decoded['reciboimpresion']['filetype']);
                        $formato->setActivo(1);
                        $formato->setTipodocumentoid($dbm->getRepositorioById('BcTipodocumento', 'tipodocumentoid', 4));
                        $dbm->saveRepositorio($formato);
    
                        $periodoformato = new BcPeriodobecaporformato();
                        $periodoformato->setFormatobecaid($formato);
                        $periodoformato->setPeriodobecaid($nperiodobeca);
                        $periodoformato->setActivo(1);
                        $dbm->saveRepositorio($periodoformato);
                   }
                }
            }


            $dbm->getConnection()->commit();
           return new View("Se ha guardado el registro", Response::HTTP_OK);
        }catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Delete("/api/Becas/PeriodoBeca/{id}" , name="EliminarPeriodoBeca")
     */
    public function EliminarPeriodoBeca($id) {
        try{
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            
            $dbm->getConnection()->beginTransaction();
            $formatos=$dbm->getRepositoriosById("BcPeriodobecaporformato",'periodobecaid', $id);
            foreach ($formatos as $formato){
                $dbm->removeRepositorio($formato->getFormatobecaid());
            }
            $dbm->removeManyRepositorio("BcPeriodobecaporformato", 'periodobecaid', $id);
            $dbm->removeRepositorio($dbm->getRepositorioById('BcPeriodobeca', 'periodobecaid', $id));
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro correctamente", Response::HTTP_OK);
        }catch(\Exception $e){
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo word del formato
     * @Rest\Get("/api/Becas/PeriodoBeca/formato/descargar/{id}", name="DescargarFormatoBeca")
     */
    public function DescargarFormatoBeca($id) {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $Formato = $dbm->getRepositorioById('BcFormatobeca', 'formatobecaid', $id);
            $response = new \Symfony\Component\HttpFoundation\Response(
                stream_get_contents($Formato->getArchivo()), 200, array(
                'Content-Type' => $Formato->getArchivotipo(),
                'Content-Length' => $Formato->getArchivosize()
                )
            );
            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    



}
