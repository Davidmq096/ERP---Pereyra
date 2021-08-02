<?php

namespace AppBundle\Controller\Controlescolar;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Ocupacion;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\View\View;

/**
 * Auto: Javier Manrique
 */
class OcupacionController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Ocupacion", name="indexOcupacion")
     */
    public function indexOcupaciones() {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ocupacion = $dbm->getRepositorios('Ocupacion');
            return new View($ocupacion, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Post("/api/Ocupacion" , name="GuardarOcupacion")
     */
    public function SaveOcupacion() {
        try {
        	if ($_FILES['layout']['error'] == 1) {
        		return new View("El archivo excede el peso permitido "
        				, Response::HTTP_PARTIAL_CONTENT);
        	}
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            
            $ocupacion = $dbm->getRepositorios('Ocupacion');
            foreach ($ocupacion as $o) {
            	$o->setActivo(false);
            	$dbm->saveRepositorio($o);
            }
            
            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($_FILES['layout']['tmp_name']);
            $sheet = $phpExcelObject->getActiveSheet();
            $phpExcelObject->getProperties();
            
            $data = $sheet->rangeToArray('A1:C'.$sheet->getHighestDataRow(), NULL, True, True);
            foreach ($data as $d) {
            	if((int)$d[0] >= 1 && (int)$d[0] <= 9999){
            	$ocupacion = $dbm->getRepositorioById('Ocupacion', 'clave', $d[0]);
            	$ocupacion = $ocupacion ? $ocupacion : new Ocupacion();
            	$ocupacion->setClave($d[0]);
            	$ocupacion->setClasificacion($d[1]);
            	$ocupacion->setDescripcion($d[2]);
            	$ocupacion->setActivo(true);
            	$dbm->saveRepositorio($ocupacion);
            	}
            }
            $dbm->getConnection()->commit();
            return new View("Se ha importado el contenido del archivo", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
