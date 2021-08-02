<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Rest\Api;
use FOS\RestBundle\View\View;
use AppBundle\DB\DbmControlescolar;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;

/**
 * @author Rubén
 */

class EmailPadresController extends FOSRestController 
{
    
    /**
     * Retorna arreglo de filtros para pantalla
     * @Rest\Get("/api/Controlescolar/Reportes/ConsultaCorreosPadres/filtros", name="filtrosConsultaCorreosPadres")
     */
    public function filtrosConsultaCorreosPadres() 
    {
        try {            
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true); 

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());              
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);     
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
           
            return Api::Ok("Filtros",
            array(
                "ciclo" => $ciclo,
                "grado" => $grado,
                "nivel" => $nivel,
                "semestre" => $semestre,
                "grupo" => $grupo               
            ));
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());      
        }
    }   

    /**
     * Retorna arreglo de filtros para pantalla
     * @Rest\Post("/api/Controlescolar/Reportes/ConsultaCorreosPadres/filtrar", name="filtrarConsultaCorreosPadres")
     */
    public function filtrarConsultaCorreosPadres() 
    {
        try {            
            $content = trim(file_get_contents("php://input")); 
            $decoded = json_decode($content, true); 
            $decoded = array_filter($decoded);  

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());   
            if($decoded['agruparfamilia']) {
                $result = $dbm->ObtenerCorreosPadresFamilia($decoded);
            } else {
                $result = $dbm->ObtenerCorreosPadresAlumnos($decoded);
            }  

            return Api::Ok("Correos #" . count($result), $result);
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());      
        }
    }  
    
    /**
     * Retorna arreglo de alumnos
     * @Rest\Get("/api/Controlescolar/Reportes/Alumnos", name="BuscarAlumnosDatos")
     */
    public function BuscarAlumnosDatos() 
    {
        try {            
            $filtros = $_REQUEST;
            $filtros = array_filter($filtros);  
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());    
            $url = $dbm->getRepositorioById('Parametros', 'nombre', 'URLServicios');   
            $conn = $dbm->getConnection();       
            $alumnos = $dbm->ObtenerAlumnosDatos($filtros);
            foreach ($alumnos as &$alumno){
                $alumno["foto"]=$url->getValor() . '/api/Alumno/foto?alumnoid=' . $alumno['alumnoid'];
                $sql = "select DATE_FORMAT(min(dp.fechacreacion), '%d/%m/%Y')  fechaingreso
                from cj_documentoporpagar dp
                inner join cj_documento d on d.documentoid = dp.documentoid
                where dp.alumnoid=".$alumno["alumnoid"]." and d.tipodocumento = 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $fecha = $stmt->fetchAll();
                $alumno["fechaingreso"]=$fecha[0]["fechaingreso"];
                
            }


            return new View($alumnos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());      
        }
    }   
            
}
