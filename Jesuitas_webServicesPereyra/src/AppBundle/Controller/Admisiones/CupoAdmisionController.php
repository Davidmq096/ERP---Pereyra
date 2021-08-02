<?php

namespace AppBundle\Controller\Admisiones;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Cupoadmision;
use FOS\RestBundle\View\View;
use AppBundle\DB\DbmAdmisiones;

/**
 * Auto: Javier Manrique
 */
class CupoAdmisionController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cupoadmision", name="indexCupoAdmision")
     */
    public function indexCupoAdmision() {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            return new View(array("ciclo" => $ciclo, "nivel" => $nivel, "grado" => $grado), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de cupos de admision por los parametros enviados
     * @Rest\Get("/api/Cupoadmision/", name="BuscarCuposAdmision")
     */
    public function getCuposAdmision() {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarCupoAdmision($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Cupoadmision/{id}", name="EliminarCupoAdmision")
     */
    public function deleteCupoAdmision($id) {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $cupoadmision = $dbm->getRepositorioById('Cupoadmision', 'cupoadmisionid', $id);
            $dbm->removeRepositorio($cupoadmision);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
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
     * @Rest\Post("/api/Cupoadmision" , name="GuardarCupoAdmision")
     */
    public function saveCupoAdmision() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();            
            $entidades = $dbm->getRepositoriosById('Cupoadmision', 'gradoid', $data['gradoid']);
            $repetidos = array_filter(
                    $entidades, function ($e)  use ($data) {
                return $e->getCicloid()->getCicloid() == $data['cicloid'];
            }
            );
            if ($repetidos) {
                return new View("Ya existe un registro para el grado y ciclo seleccionados", Response::HTTP_PARTIAL_CONTENT);
            }

            $Cupoadmision = new Cupoadmision();
            $Cupoadmision->setCicloid(empty($data['cicloid']) ? null : $dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']));
            $Cupoadmision->setGradoid(empty($data['gradoid']) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']));
            $Cupoadmision->setCupo(empty($data['cupo']) ? null : $data['cupo']);
            $Cupoadmision->setcantidadfichas(empty($data['cantidadfichas']) ? null : $data['cantidadfichas']);
            $Cupoadmision->setTextocompleto(empty($data['textocompleto']) ? null : $data['textocompleto']);
            $Cupoadmision->setListaespera(empty($data['listaespera']) ? false : ($data['listaespera']));
            $Cupoadmision->setTextolistaespera(empty($data['textolistaespera']) ? null : $data['textolistaespera']);
            $Cupoadmision->setTextocapturaficha(empty($data['textocapturaficha']) ? null : $data['textocapturaficha']);
            $Cupoadmision->setIniciorecepcion(new \DateTime($data["iniciorecepcion"]));
            $Cupoadmision->setFinrecepcion(new \DateTime($data["finrecepcion"]));
            $Cupoadmision->setFechaedad(new \DateTime($data["fechaedad"]));

            $Cupoadmision->setFechaentregaresultados(empty($data['fechaentregaresultados']) ? null : new \DateTime($data["fechaentregaresultados"]));
            $Cupoadmision->setFechapagoadeudos(empty($data['fechapagoadeudos']) ? null : new \DateTime($data["fechapagoadeudos"]));
            $Cupoadmision->setFechaentregainscripcion(empty($data['fechaentregainscripcion']) ? null : new \DateTime($data["fechaentregainscripcion"]));

            $Cupoadmision->setActivo(empty($data['activo']) ? false : ($data['activo']));            
            
            $dbm->saveRepositorio($Cupoadmision);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Cupoadmision/{id}" , name="ActualizarCupoAdmision")
     */
    public function updateCupoAdmision($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $Cupoadmision = $dbm->getRepositorioById('Cupoadmision', 'cupoadmisionid', $id);
            $entidades = $dbm->getRepositoriosById('Cupoadmision', 'gradoid', $data['gradoid']);
            $repetidos = array_filter(
                    $entidades, function ($e) use ($data) {
                return $e->getCicloid()->getCicloid() == $data['cicloid'];
            }
            );
            if ($repetidos && reset($repetidos) != $Cupoadmision) {
                return new View("Ya existe un registro para el grado y ciclo seleccionados", Response::HTTP_PARTIAL_CONTENT);
            }

            $Cupoadmision->setCicloid(empty($data['cicloid']) ? null : $dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']));
            $Cupoadmision->setGradoid(empty($data['gradoid']) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']));
            $Cupoadmision->setCupo(empty($data['cupo']) ? null : $data['cupo']);
            $Cupoadmision->setcantidadfichas(empty($data['cantidadfichas']) ? null : $data['cantidadfichas']);
            $Cupoadmision->setTextocompleto(empty($data['textocompleto']) ? null : $data['textocompleto']);
            $Cupoadmision->setListaespera($data['listaespera']);
            $Cupoadmision->setTextolistaespera(empty($data['textolistaespera']) ? null : $data['textolistaespera']);
            $Cupoadmision->setTextocapturaficha(empty($data['textocapturaficha']) ? null : $data['textocapturaficha']);
            $Cupoadmision->setIniciorecepcion(new \DateTime($data["iniciorecepcion"]));
            $Cupoadmision->setFinrecepcion(new \DateTime($data["finrecepcion"]));
            $Cupoadmision->setFechaedad(new \DateTime($data["fechaedad"]));    

            $Cupoadmision->setFechaentregaresultados(empty($data['fechaentregaresultados']) ? null : new \DateTime($data["fechaentregaresultados"]));
            $Cupoadmision->setFechapagoadeudos(empty($data['fechapagoadeudos']) ? null : new \DateTime($data["fechapagoadeudos"]));
            $Cupoadmision->setFechaentregainscripcion(empty($data['fechaentregainscripcion']) ? null : new \DateTime($data["fechaentregainscripcion"]));

            $Cupoadmision->setActivo($data['activo']);
            
            $dbm->saveRepositorio($Cupoadmision);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
