<?php

namespace AppBundle\Controller\Bancoreactivo;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBancoreactivo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/**
 * Auto: Javier
 */
class ReactivosResultadosGeneralController extends FOSRestController {
	/**
	 * Retorna arreglo iniciales
	 * @Rest\Get("/api/Bancoreactivos/Generalresultados", name="indexGeneralresultados")
	 */
	public function indexGeneralresultados() {
		try {
			$dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
			$ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
			$nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
			$grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
			$area = $dbm->getRepositoriosById('CeAreaacademica', 'activo', 1, 'nombre');
			$materia = $dbm->getRepositoriosById('Materia', 'activo', 1, 'nombre');
			$tipoexamen = $dbm->getRepositoriosById('BrTipoexamen', 'activo', 1, 'nombre');
			$examen = $dbm->getRepositoriosById('BrExamen', 'activo', 1, 'nombre');
			$colegio = $dbm->getRepositoriosById('BrColegio', 'activo', 1, 'nombre');
			
			return new View(array(
					"ciclo" => $ciclo,
					"nivel" => $nivel, 
					"grado" => $grado,
					"area" => $area,
					"materia" => $materia,
					"tipoexamen" => $tipoexamen,
					"examen" => $examen,
					"colegio" => $colegio
			), Response::HTTP_OK);
		} catch (\Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
	
    /**
     * @Rest\Get("/api/Bancoreactivos/Generalresultados/", name="BuscarGeneralresultados")
     */
	public function getGeneralresultados() {
        try {
        	$datos = $_REQUEST;
        	$filtros = array_filter($datos);
            $dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarReactivosResultados($filtros);
            if (!$entidad) {
            	return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
        	return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * @Rest\Get("/api/Bancoreactivos/Generalresultados/Detalle/{id}", name="BuscarGeneralresultadosdetalle")
     */
    public function getGeneralresultadosDetalle($id) {
    	try {
    		$dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
    		$entidad = $dbm->BuscarReactivosResultadosDetalle($id);
    		if (!$entidad) {
    			return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
    		}
    		return new View($entidad, Response::HTTP_OK);
    	} catch (Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }

    /**
	 * Retorna arreglo iniciales
	 * @Rest\Get("/api/Bancoreactivos/Resultadosporrectivo", name="indexResultadosporrectivoTest")
	*/
	public function indexResultadosPorRectivo() {
		try {
			$dbm = new DbmBancoreactivo($this->get("db_manager")->getEntityManager());
			$ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
			$nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
			$grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
			$tipoexamen = $dbm->getRepositoriosById('BrTipoexamen', 'activo', 1, 'nombre');
			$examen = $dbm->getRepositoriosById('BrExamen', 'activo', 1, 'nombre');		

			$tablero = $dbm->getRepositorioById('Parametros', 'nombre', "URLTableros de BI");
			
			return new View(array(
					"ciclo" => $ciclo,
					"nivel" => $nivel, 
					"grado" => $grado,
					"tipoexamen" => $tipoexamen,
					"examen" => $examen,
					"tablero" => $tablero,
			), Response::HTTP_OK);
		} catch (\Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

}
