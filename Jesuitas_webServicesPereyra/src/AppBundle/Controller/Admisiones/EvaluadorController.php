<?php

namespace AppBundle\Controller\Admisiones;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use JMS\Serializer\Exception\Exception;
use AppBundle\Entity\Disponibilidad;
use AppBundle\Entity\Ciclopordisponibilidad;
use AppBundle\Entity\Usuarioevaluadorporgrado;
use AppBundle\DB\DbmAdmisiones;

/**
 * Description of EvaluadorController
 *
 * @author inceptio
 */
class EvaluadorController extends FOSRestController {

    /**
     * Reotorna arreglo de materias     
     * @Rest\Get("/api/Evaluador", name="indexEvaluadores")
     */
    public function indexAction(Request $request) {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            return new View(array('grado' => $grado), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reotorna arreglo de evaluadores     
     * @Rest\Get("/api/Evaluador/", name="BuscarEvaluador")
     */
    public function getEvaluador(Request $request) {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);

            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarEvaluador($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Evaluador/{id}", name="ActualizarEvaluador")
     */
    public function updateEvaluador($id) {
        try {
            parse_str(file_get_contents("php://input"), $data);

            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $dbm->removeManyRepositorio('Usuarioevaluadorporgrado', 'usuarioid', $id);
            if(!empty($data["grado"]))
            foreach ($data["grado"] as $g) {
                $usuarioevaluadorporgrado = new Usuarioevaluadorporgrado();
                $usuarioevaluadorporgrado->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $id));
                $usuarioevaluadorporgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $g));
                $dbm->saveRepositorio($usuarioevaluadorporgrado);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
       
}
