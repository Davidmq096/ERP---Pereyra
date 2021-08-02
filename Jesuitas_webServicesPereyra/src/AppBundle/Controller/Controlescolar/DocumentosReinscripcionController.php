<?php

namespace AppBundle\Controller\Controlescolar;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Departamento;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\View\View;

/**
 * Auto: David
 */
class DocumentosReinscripcionController extends FOSRestController {

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/ControlEscolar/DocumentosReinscripcion", name="indexDocumentosR")
     */
    public function indexDocumentosR() {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            return new View(array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                "semestre" => $semestre,
                "grupos" => $grupo
        ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/ControlEscolar/DocumentosReinscripcion/Filtrar" , name="BuscarAlumnosDocumentos")
     */
    public function BuscarAlumnosDocumentos()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumnos = $dbm->BuscarAlumnosDocumentos($data);
            if(!$alumnos){
                return new View("No se encontró ningun registro", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($alumnos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/ControlEscolar/DocumentosReinscripcion/ActualizarDocumentos" , name="ActualizarAlumnosDocumentos")
     */
    public function ActualizarAlumnosDocumentos()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumnociclos = explode(",",$data['alumnoporcicloiddestino']);
            $dbm->getConnection()->beginTransaction();
            foreach($alumnociclos as $ac) {
                $alumno = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $ac);
                $alumno->setDocumentosreinscripcion($data['documentos'] ? 1 : 0);
                $dbm->saveRepositorio($alumno);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
