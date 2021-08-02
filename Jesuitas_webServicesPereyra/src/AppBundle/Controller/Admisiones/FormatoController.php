<?php

namespace AppBundle\Controller\Admisiones;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Formato;
use AppBundle\Entity\Gradoporformato;

use AppBundle\DB\DbmAdmisiones;

/**
 * Auto: Javier Manrique
 */
class FormatoController extends FOSRestController {

    /**
     * Retorna arreglo que contiene Tipo de formato y nivel para cargar de innicio la pagina formato
     * @Rest\Get("/api/Formato", name="InicioFormato")
     */
    public function indexFormato() {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $tipoformato = $dbm->getRepositoriosById('Tipoformato', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $token = $dbm->getRepositorios('Token');

            $array = array("tipoformato" => $tipoformato, "nivel" => $nivel, "grado" => $grado, "token" => $token);
            return new View($array, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de formato por los parametros enviados
     * @Rest\Get("/api/Formato/", name="BuscarFormato")
     */
    public function buscarFormato() {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarFormato($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda los formatos y sus relaciones con grados
     * @Rest\Post("/api/Formato" , name="GuardarFormato")
     */
    public function saveFormato() {
        try {
            if ($_FILES['formato']['error'] == 1) {
                return new View("El archivo excede el peso permitido "
                        , Response::HTTP_PARTIAL_CONTENT);
            }
            $data = $_REQUEST;
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            //Validamos si los grados seleccionados ya estan asociados al tipo de formato
            /* $relaciones = $dbm->ValidarRelacionFormato($data['tipoformatoid'], $data['gradoid']);
              if($relaciones[0]['grados'] != null){
              return new View("El tipo de formato '". $relaciones[0]['nombre'] ."' ya esta asignado a ".$relaciones[0]['grados']
              , Response::HTTP_NOT_ACCEPTABLE);
              } */

            $Formato = new Formato();
            $Formato->setTipoformatoid(
                    $dbm->getRepositorioById('Tipoformato', 'tipoformatoid', $data['tipoformatoid']));
            $Formato->setNombre($data["nombre"]);
            $Formato->setActivo((isset($data['activo']) ? true : false));
            $Formato->setObligatorio((isset($data['obligatorio']) ? true : false));

            //Obtenemos los token por nivel y validamos que vengan en el archivo
            //$Nivel = $dbm->getRepositorioById('Nivel', 'nivelid', $data['nivelid']);
            //$Token = $dbm->getRepositoriosById('Token', strtolower($Nivel->getNombre()), 1);
            //$toks = array_map(create_function('$e', 'return $e->getToken();'), $Token);
            //list($noencontrado, $validate) = \AppBundle\Dominio\Formato::tokens($_FILES['formato'], $toks);
            //if (!$validate) {
            //    return new View($noencontrado, Response::HTTP_PARTIAL_CONTENT);
            //}
            
            $Formato->setFormatocontenido(file_get_contents($_FILES['formato']['tmp_name']));
            $Formato->setFormatosize($_FILES['formato']['size']);
            $Formato->setFormatotipo($_FILES['formato']['type']);

            $dbm->getConnection()->beginTransaction();

            $dbm->saveRepositorio($Formato);
            foreach (explode(',', $data['gradoid']) as $gradoid) {
                $Gradoporformato = new Gradoporformato();
                $Gradoporformato->setGradoid(($dbm->getRepositorioById('Grado', 'gradoid', $gradoid)));
                $Gradoporformato->setFormatoid($Formato);
                $dbm->saveRepositorio($Gradoporformato);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo word del formato
     * @Rest\Get("/api/Formato/descargar/{id}", name="DescargarFormato")
     */
    public function downloadFormato($id) {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $Formato = $dbm->getRepositorioById('Formato', 'formatoid', $id);
            $response = new \Symfony\Component\HttpFoundation\Response(
                    stream_get_contents($Formato->getFormatocontenido()), 200, array(
                'Content-Type' => $Formato->getFormatotipo(),
                'Content-Length' => $Formato->getFormatosize())
            );
            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza los formatos y sus relaciones con grados
     * @Rest\Post("/api/Formato/{id}" , name="ActualizarFormato")
     */
    public function actualizarFormato($id) {
        try {
            if ($_FILES['formato']['error'] == 1) {
                return new View("El archivo excede el peso permitido "
                        , Response::HTTP_PARTIAL_CONTENT);
            }
            $data = $_REQUEST;
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $Formato = $dbm->getRepositorioById('Formato', 'formatoid', $id);

            $Formato->setTipoformatoid(
                    $dbm->getRepositorioById('Tipoformato', 'tipoformatoid', $data['tipoformatoid']));
            $Formato->setNombre($data["nombre"]);
            $Formato->setActivo($data['activo'] == "true" ? true : false);
            $Formato->setObligatorio($data['obligatorio'] == "true" ? true : false);

            if ($_FILES['formato']['size'] > 0) {
                //Obtenemos los token por nivel y validamos que vengan el el archivo
                //$Nivel = $dbm->getRepositorioById('Nivel', 'nivelid', $data['nivelid']);
                //$Token = $dbm->getRepositoriosById('Token', strtolower($Nivel->getNombre()), 1);
                //$toks = array_map(create_function('$e', 'return $e->getToken();'), $Token);
                //list($noencontrado, $validate) = \AppBundle\Dominio\Formato::tokens($_FILES['formato'], $toks);
                //if (!$validate) {
                //    return new View($noencontrado, Response::HTTP_PARTIAL_CONTENT);
                //}
                $Formato->setFormatocontenido(file_get_contents($_FILES['formato']['tmp_name']));
                $Formato->setFormatosize($_FILES['formato']['size']);
                $Formato->setFormatotipo($_FILES['formato']['type']);
            }

            $dbm->getConnection()->beginTransaction();

            $dbm->saveRepositorio($Formato);
            $dbm->removeManyRepositorio('Gradoporformato', 'formatoid', $id);

            /* $relaciones = $dbm->ValidarRelacionFormato($data['tipoformatoid'], $data['gradoid']);
              if($relaciones[0]['grados'] != null){
              return new View("El tipo de formato '". $relaciones[0]['nombre'] ."' ya esta asignado a ".$relaciones[0]['grados']
              , Response::HTTP_NOT_ACCEPTABLE);
              } */

            foreach (explode(',', $data['gradoid']) as $gradoid) {
                $Gradoporformato = new Gradoporformato();
                $Gradoporformato->setGradoid(($dbm->getRepositorioById('Grado', 'gradoid', $gradoid)));
                $Gradoporformato->setFormatoid($Formato);
                $dbm->saveRepositorio($Gradoporformato);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
