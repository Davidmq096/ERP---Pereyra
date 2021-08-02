<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeProfesorpornivel;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;

/**
 * Auto: Rubén
 */
class ProfesoresNivelesController extends FOSRestController
{

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/ControlEscolar/ProfesorNivel/Filtrar", name="filtrarprofesornivel")
     */
    public function filtrarprofesornivel()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidades = $dbm->FiltrarProfesoresPorNivel($data);

            foreach($entidades as $entidad){
                $entidad->getProfesorid()->setfotografia(stream_get_contents($entidad->getProfesorid()->getFotografia()));                
            }

            return new View($entidades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/ControlEscolar/ProfesorNivel/ObtenerFaltantes", name="obtenerprofesornivel")
     */
    public function obtenerprofesornivel()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidades = $dbm->FiltrarProfesoresPorNivelFaltantes($data);

            foreach($entidades as $entidad){
                $entidad->setfotografia(stream_get_contents($entidad->getFotografia()));                
            }

            return new View($entidades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/ControlEscolar/ProfesorNivel/Copiar", name="copiarprofesornivel")
     */
    public function copiarprofesornivel()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $profesornivelbusqueda = $dbm->getByParametersRepositorios('CeProfesorpornivel', array(
                "cicloid" => $data['cicloid'],
                "nivelid" => $data['nivelid'],
            ));

            $ciclo = $dbm->getRepositorioById('ciclo', 'cicloid', $data['nuevocicloid']);

            if (empty($profesornivelbusqueda)) {
                return new View("No hay resultados que coincidan con la información enviada.", Response::HTTP_PARTIAL_CONTENT);
            }

            if (empty($ciclo)) {
                return new View("No se encontró el nuevo ciclo enviado.", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            foreach ($profesornivelbusqueda as $item) {
                $profesornivelexiste = $dbm->getByParametersRepositorios('CeProfesorpornivel', array(
                    "cicloid" => $ciclo->getCicloid(),
                    "nivelid" => $decoded['nivelid'],
                    "profesorid" => $item->getProfesorid()
                ));

                if (empty($profesornivelexiste)) {
                    $profesorpornivel = new CeProfesorpornivel();
                    $profesorpornivel = clone $item;
                    $profesorpornivel->setCicloid($ciclo);
                    $dbm->saveRepositorio($profesorpornivel);
                }else{
                    //AQUI VA LA ELIMINACIÓN DE LAS ASIGNACIONES
                }
            }

            $dbm->getConnection()->commit();
            return new View('Se ha completado el proceso de forma satisfactoria.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/ControlEscolar/ProfesorNivel", name="guardarProfesorNivel")
     */
    public function guardarProfesorNivel()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            /*PROCESAMIENTO DE LA INFORMACIÓN */
            $dbm->getConnection()->beginTransaction();
            foreach ($data['profesorespornivel'] as $profesornivel) {
                $profesornivelbusqueda = $dbm->getByParametersRepositorios('CeProfesorpornivel', array(
                    "cicloid" => $profesornivel['cicloid'],
                    "nivelid" => $profesornivel['nivelid'],
                    "profesorid" => $profesornivel['profesornivel']
                ));

                if (!empty($profesornivelbusqueda)) {
                    return new View("Ya existe un registro con la misma información enviada.", Response::HTTP_PARTIAL_CONTENT);
                }

                $hydrator = new ArrayHydrator($dbm->getEntityManager());
                $profesorpornivel = $hydrator->hydrate(new CeProfesorpornivel(), $profesornivel);
                $dbm->saveRepositorio($profesorpornivel);
            }
            $dbm->getConnection()->commit();
            return new View('Se ha completado el proceso de forma satisfactoria.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Delete("/api/ControlEscolar/ProfesorNivel/{id}", name="eliminarProfesorNivel")
     */
    public function eliminarProfesorNivel($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $profesorpornivel = $dbm->getRepositorioById('CeProfesorpornivel', 'profesorpornivelid', $id);

            if (empty($profesorpornivel)) {
                return new View("No se encontró el registro a eliminar.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            $dbm->removeRepositorio($profesorpornivel);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

        /**
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/ControlEscolar/ProfesorNivel/ReporteReprobacion/", name="ReporteReprobacion")
     */
    public function ReporteReprobacion()
    {
        try {
			$datos=$_REQUEST;
            $filtros=array_filter($datos);
            $identificador = 0;

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $filtros['cicloid']);
            $nivel = $dbm->getRepositorioById('Nivel', 'nivelid', $filtros['nivelid']);
            $entidades = $dbm->ObtenerReprobadorPorProfesor($filtros);
            $arraydatos = [];
            $profesorid = null;
            $reprobados=array_values(array_unique(array_column($entidades, 'periodo')));

            foreach($entidades as $entidad){
                if(!$profesorid) {
                    $profesorid = $entidad['profesorid'];
                    $identificador ++;
                }
                if($profesorid !== $entidad['profesorid']) {
                    $identificador ++;
                    $profesorid = $entidad['profesorid'];
                }

                foreach ($entidad as $key=>$a) {
                    if($key !== 'periodo' && $key !== 'profesorid' && $key !== 'reprobados') {
                        $arraydatos[]= ["x" => $identificador, "y"=> $entidad['periodo'], "y1"=> $key, "val" => $a];
                    }
                }            
            }
			$report="ReprobacionProfesor";
			$filebase="$report-".(rand()%10000);
            $pdf=new LDPDF($this->container, $report, $filebase, ['driver'=>'json', 'data_file'=>$filebase, 'json_query'=>'""'], [], ['xlsx']);
            $data = array("prof" => $arraydatos, "ciclo" => $ciclo->getNombre(), "nivel" => $nivel->getNombre(), "nivel2" => $nivel->getNombre(). " GENERALES");
			$this->fileWrite($pdf->fdb_r, json_encode($data));
            $result=$pdf->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/$filebase.xlsx";
            if (!$reporte) {
                return new View("No se ha podido procesar el reporte", Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte),
                200,
                array(
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
                    'Content-Length' => filesize($reporte)
                )
            );
			LDPDF::fileDelete($pdf->fdb_r);
			if(!$result){
				LDPDF::fileDelete($pdf->output_r);
            }
            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    private function fileWrite($path, $data){
		$file=LDPDF::fileRead($path);
		LDPDF::fileWrite($file, $data);
		LDPDF::fileRelease($file);
		return true;
    }

}
