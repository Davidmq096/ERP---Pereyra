<?php

namespace AppBundle\Controller\Controlescolar;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CeIdiomanivel;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\View\View;

/**
 * Auto: David
 */
class NivelIdiomaController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Nivelidioma", name="indexNivelidioma")
     */
    public function indexNivelidioma() {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $idiomas = $dbm->getRepositorios('CeIdioma');
            $idiomanivel = $dbm->getRepositorios('CeIdiomanivel');

            return new View(array("idiomas" => $idiomas, "idiomanivel" => $idiomanivel), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Nivelidioma/{id}", name="deleteNivelidioma")
     */
    public function deleteNivelidioma($id) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $idiomanivel = $dbm->getRepositorioById('CeIdiomanivel', 'idiomanivelid', $id);

            $dbm->removeRepositorio($idiomanivel);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Rest\Post("/api/Nivelidioma" , name="SaveNivelidioma")
     */
    public function SaveNivelidioma() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            if ($dbm->getByParametersRepositorios('CeIdiomanivel', array('idiomaid' => $data['idiomaid'], 'orden' => $data['orden']))) {
                return new View("Ya existe el mismo orden en el mismo idíoma.", Response::HTTP_PARTIAL_CONTENT);
            }

            if ($dbm->getRepositorioById('CeIdiomanivel', 'nombre', $data['nombre'])) {
                return new View("Ya existe un nivel de idioma con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            if ($dbm->getRepositorioById('CeIdiomanivel', 'clave', $data['clave'])) {
                return new View("Ya existe un nivel de idioma con la misma clave.", Response::HTTP_PARTIAL_CONTENT);
            }


            $idiomanivel = new CeIdiomanivel();
            $idiomanivel->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $idiomanivel->setClave(empty($data['clave']) ? null : $data['clave']);
            $idiomanivel->setOrden(empty($data['orden']) ? null : $data['orden']);
            $idiomanivel->setActivo($data['activo'] == "true" ? true : false);
            $idiomanivel->setIdiomaid(empty($data['idiomaid']) ? null : $dbm->getRepositorioById('CeIdioma', 'idiomaid', $data['idiomaid']));

            $dbm->saveRepositorio($idiomanivel);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Nivelidioma/{id}" , name="updateNivelidioma")
     */
    public function updateNivelidioma($id) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $validarnombre = $dbm->getRepositorioById('CeIdiomanivel', 'nombre', $data['nombre']);
            if ($validarnombre && $validarnombre->getIdiomanivelid() != $id) {
                return new View("Ya existe un nivel de idioma con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }
            $validarorden = $dbm->getOneByParametersRepositorio('CeIdiomanivel', array('idiomaid' => $data['idiomaid'], 'orden' => $data['orden']));
            if ($validarorden && $validarorden->getIdiomanivelid() != $id) {
                return new View("Ya existe el mismo orden en el mismo idíoma.", Response::HTTP_PARTIAL_CONTENT);
            }

            $validarclave = $dbm->getRepositorioById('CeIdiomanivel', 'clave', $data['clave']);
            if ($validarclave && $validarclave->getIdiomanivelid() != $id) {
                return new View("Ya existe un nivel de idioma con la misma clave.", Response::HTTP_PARTIAL_CONTENT);
            }

            
            $idiomanivel = $dbm->getRepositorioById('CeIdiomanivel', 'idiomanivelid', $id);
            $idiomanivel->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $idiomanivel->setClave(empty($data['clave']) ? null : $data['clave']);
            $idiomanivel->setOrden(empty($data['orden']) ? null : $data['orden']);
            $idiomanivel->setActivo($data['activo'] == "true" ? true : false);
            $idiomanivel->setIdiomaid(empty($data['idiomaid']) ? null : $dbm->getRepositorioById('CeIdioma', 'idiomaid', $data['idiomaid']));

            $dbm->saveRepositorio($idiomanivel);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
