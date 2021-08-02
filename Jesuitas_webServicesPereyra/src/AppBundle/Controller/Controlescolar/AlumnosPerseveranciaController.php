<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\Rest\Api;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class AlumnosPerseveranciaController extends FOSRestController
{

    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Get("/api/Controlescolar/AlumnosPerseverancia", name="indexAlumnosperseverancia")
     */
    public function indexAlumnosperseverancia()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);

            return new View(
                array("ciclo" => $ciclo,
                    "nivel" => $nivel,
                    "grado" => $grado,
                ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

        /**
     *  Responde un array de alumnos
     * @Rest\Get("/api/Controlescolar/AlumnosPerseverancia/", name="getAlumnosperseverancia")
     */
    public function getAlumnosperseverancia()
    {
        try {
            $data = $_REQUEST;
            $filters = array_filter($data, function ($value) {
                return $value !== '';
            });
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumnos = $dbm->GetAlumnosPerseverancia($filters);
            if(!$alumnos) {
                return new View("No se encontró ningun registro", Response::HTTP_PARTIAL_CONTENT);
            }
            
            return new View($alumnos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/AlumnosPerseverancia/MarcarAlumnos", name="setAlumnoPerseverancia")
     */
    public function setAlumnoPerseverancia(){
        $requestRaw=trim(file_get_contents("php://input"));
        $alumnos=json_decode($requestRaw,true);
        $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $dbm->getConnection()->beginTransaction();

        foreach($alumnos['alumnos'] AS $alu) {
            $alumno = $dbm->getRepositorioById("CeAlumno", "alumnoid", $alu);
            if($alumnos['valor'] == "1") {
                $alumno->setAlumnoPerseverancia(1);
            } else {
                $alumno->setAlumnoPerseverancia(0);
            }

            $dbm->saveRepositorio($alumno);
        }
        $dbm->getConnection()->commit();
        return new View("Se ha guardado el registro", Response::HTTP_OK);
    }

        /**
     * 
     * @Rest\Get("/api/Controlescolar/AlumnosPerseverancia/DescargarFotos/{alumnosciclo}", name="getAlumnoPerseveranciaFotos")
     */
    public function getAlumnoPerseveranciaFotos($alumnosciclo){
        $requestRaw=trim(file_get_contents("php://input"));
        $alumnos=json_decode($requestRaw,true);
        $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());

        $alumnofoto = $dbm->getRepositorioById("CeAlumnociclofoto", "alumnoporcicloid", $alumnosciclo);
        $foto = $alumnofoto ? stream_get_contents($alumnofoto->getFoto()) : null;
        if(!$foto) {
            return new View("No se ha encontrado una foto con el alumno seleccionado", Response::HTTP_PARTIAL_CONTENT);
        }
        return Api::download($foto, 'image/png');
    }
}