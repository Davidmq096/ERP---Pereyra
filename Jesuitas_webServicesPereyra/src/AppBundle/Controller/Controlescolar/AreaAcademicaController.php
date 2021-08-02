<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\CeAreaacademica;

/**
 * Auto: Mariano
 */
class AreaAcademicaController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/Areaacademica", name="indexArea")
     */
    public function indexArea() {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $user = $dbm->getRepositoriosById('Usuario', 'tipousuarioid', 1);
            $usuario = array();
            foreach($user as $u){
                $nombre = ($u->getPersonaid() ? $u->getPersonaid()->getApellidopaterno() : '')
                 ." ". ($u->getPersonaid() ? $u->getPersonaid()->getApellidomaterno() : '') ." ". 
                    ($u->getPersonaid() ? $u->getPersonaid()->getNombre() : '');
                array_push($usuario, ["usuarioid" => $u->getUsuarioid(), "nombre" => $nombre]);
            }
            return new View(array("nivel" => $nivel, "usuario" => $usuario), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo de ciudades en base a los parametros enviados
     * @Rest\Get("/api/Controlescolar/Areaacademica/", name="BuscarArea")
     */
    public function getArea() {
    	try {
    		$datos = $_REQUEST;
    		$filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
    		$entidad = $dbm->BuscarAreas($filtros);
    		if (!$entidad) {
    			return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
    		}
    		return new View($entidad, Response::HTTP_OK);
    	} catch (Exception $e) {
    		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
    	}
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Areaacademica/{id}", name="EliminarArea")
     */
    public function deleteArea($id) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $area = $dbm->getRepositorioById('CeAreaacademica', 'areaacademicaid', $id);
            $dbm->removeRepositorio($area);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
        	if($e->getPrevious()->getCode() == "23000"){
        		return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
        	}else{
        		return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        	}
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Areaacademica" , name="GuardarArea")
     */
    public function SaveArea() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->getByParametersRepositorios('CeAreaacademica', array('nombre' => $data['area'], 'nivelid' => $data['nivelid']));
            if ($dbm->getByParametersRepositorios('CeAreaacademica', array('nombre' => $data['area'], 'nivelid' => $data['nivelid']))) {
                return new View("Ya existe un área con el mismo nombre en el nivel seleccionado.", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $area = $hydrator->hydrate(new CeAreaacademica(), $data);
            $dbm->saveRepositorio($area);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Controlescolar/Areaacademica/{id}" , name="ActualizarArea")
     */
    public function updateArea($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = $dbm->getByParametersRepositorios('CeAreaacademica', array('nombre' => $data['area'], 'nivelid' => $data['nivelid']));
            if ($validar && $validar[0]->getAreaacademicaid() != $id) {
                return new View("Ya existe un área con el mismo nombre en el nivel seleccionado.", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $area = $hydrator->hydrate($dbm->getRepositorioById('CeAreaacademica', 'areaacademicaid', $id), $data);
            $dbm->saveRepositorio($area);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

}
