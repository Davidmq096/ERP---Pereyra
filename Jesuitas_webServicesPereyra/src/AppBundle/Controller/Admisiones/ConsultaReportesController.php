<?php

namespace AppBundle\Controller\Admisiones;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\DB\DbmAdmisiones;

/**
 * Auto: Javier
 */
class ConsultaReportesController extends FOSRestController {

    /**
     * Retorna arreglo que los datos para cargar de innicio la pagina 
     * @Rest\Get("/api/Admisiones/Consultareportes", name="InicioConsultaReportes")
     */
    public function indexDocumento() {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $tablero = $dbm->getRepositorioById('Parametros', 'nombre', "URLTableros de BI");
       
            return new View(array("nivel" => $nivel,"tablero" => $tablero), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
