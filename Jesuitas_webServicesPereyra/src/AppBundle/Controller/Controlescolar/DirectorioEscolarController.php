<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeDirectorioescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class DirectorioEscolarController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Directorioescolar", name="indexDirectorio")
     */
    public function indexDirectorio()
    {
        try {
            $datos = $_REQUEST;
            $filtros = (array_filter($datos, function ($value) {
                return $value !== '';
            }));
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $Directorios = $dbm->BuscarDirectorios($filtros);
            if (!$Directorios) {
    			return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
    		}
            return new View($Directorios, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Directorioescolar" , name="SaveDirectorio")
     */
    public function SaveDirectorio()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            if ($dbm->getRepositorioById('CeDirectorioescolar', 'nombredepartamento', $data['departamento'])) {
                return new View("Ya existe un departamento con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            if ($dbm->getRepositorioById('CeDirectorioescolar', 'ordendirectorio', $data['ordendirectorio'])) {
                return new View("Ya existe un orden de directorio con la misma información", Response::HTTP_PARTIAL_CONTENT);
            }

            $directorio = new CeDirectorioescolar();
            $directorio->setNombredepartamento(empty($data['departamento']) ? null : $data['departamento']);
            $directorio->setCorreoelectronico(empty($data['correoelectronico']) ? null : $data['correoelectronico']);
            $directorio->setTelefono(empty($data['tel']) ? null : $data['tel']);
            $directorio->setExtension(empty($data['extension']) ? null : $data['extension']);
            $directorio->setNombreresponsable(empty($data['nombreresponsable']) ? null : $data['nombreresponsable']);
            $directorio->setOrdendirectorio(empty($data['ordendirectorio']) ? null : $data['ordendirectorio']);
            $directorio->setActivo(empty($data['activo']) ? null : $data['activo']);

            $dbm->saveRepositorio($directorio);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Directorioescolar/{id}" , name="ActualizarDirectorio")
     */
    public function updateDirectorio($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $validar = $dbm->getRepositorioById('CeDirectorioescolar', 'nombredepartamento', $data['departamento']);
            if ($validar && $validar->getDirectorioescolarid() != $id) {
                return new View("Ya existe un departamento con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            $validar = $dbm->getRepositorioById('CeDirectorioescolar', 'ordendirectorio', $data['ordendirectorio']);
            if ($validar && $validar->getDirectorioescolarid() != $id) {
                return new View("Ya existe un orden de directorio con la misma información", Response::HTTP_PARTIAL_CONTENT);
            }

            $directorio = $dbm->getRepositorioById('CeDirectorioescolar', 'directorioescolarid', $id);

            $directorio->setNombredepartamento(empty($data['departamento']) ? null : $data['departamento']);
            $directorio->setCorreoelectronico(empty($data['correoelectronico']) ? null : $data['correoelectronico']);
            $directorio->setTelefono(empty($data['tel']) ? null : $data['tel']);
            $directorio->setExtension(empty($data['extension']) ? null : $data['extension']);
            $directorio->setNombreresponsable(empty($data['nombreresponsable']) ? null : $data['nombreresponsable']);
            $directorio->setOrdendirectorio(empty($data['ordendirectorio']) ? null : $data['ordendirectorio']);
            $directorio->setActivo(empty($data['activo']) ? null : $data['activo'] == "true" ? true : false);

            $dbm->saveRepositorio($directorio);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Directorioescolar/{id}", name="EliminarDirectorio")
     */
    public function deleteDirectorio($id)
    {
        try {

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $directorio = $dbm->getRepositorioById('CeDirectorioescolar', 'directorioescolarid', $id);
            $dbm->removeRepositorio($directorio);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);

        } catch (\Exception $e) {

            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


}
