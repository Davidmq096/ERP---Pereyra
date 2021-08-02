<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\DB\DbmAdmisiones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Auto: Javier Manrique
 */
class ListaAsistenciaController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Listaasistencia", name="indexListaAsistencia")
     */
    public function indexListaAsistencia(Request $request)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $tipoevaluacion = $dbm->getRepositoriosById('Tipoevaluacion', 'activo', 1, "nombre");
            $evaluador = $dbm->BuscarEvaluador(array());
            $lugar = $dbm->getRepositoriosById('Lugar', 'activo', 1, "nombre");

            return new View(
                array(
                    "ciclo" => $ciclo,
                    "nivel" => $nivel,
                    "grado" => $grado,
                    "tipoevaluacion" => $tipoevaluacion,
                    "evaluador" => $evaluador,
                    "lugar" => $lugar,
                ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna listas de asistencia en base a los parametros enviados
     * @Rest\Get("/api/Listaasistencia/", name="buscarListaAsistencia")
     */
    public function buscarListaAsistencia()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

            $filtros["entrevista"] = true;
            $entrevista = $dbm->BuscarListaAsistencia($filtros);
            $filtros["entrevista"] = false;
            $noentrevista = $dbm->BuscarListaAsistencia($filtros);

            $entidad = array_merge($entrevista, $noentrevista);

            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo excel
     * @Rest\Post("/api/Listaasistencia/Lista/", name="DescargarLista")
     */
    public function downloadLista()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $evento = json_decode($content, true);
            $evento = implode(",", $evento);

            $path = str_replace('app', '', $this->get('kernel')->getRootDir());
            $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";
            
            switch (ENTORNO) {
                case 1:
                    $logo = $path . "Lux/logonombre.png";
                    $plantilla = "\"" . $path . "Lux/Admision_Lista_de_asistencia\"";
                    break;
                case 2:
                    $logo = $path . "Ciencias/logonombre.png";
                    $plantilla = "\"" . $path . "Ciencias/Admision_Lista_de_asistencia\"";
                    break;
            }
            
            $jasper = new JasperPHP($this->container);
			$jasper->process(
				$plantilla,
				"'" . $path . "Admision_Lista_de_asistencia'",
				array("pdf"),
				array("eventosid" => $evento, 'logo' => $logo),
				true
            );
            $output = $jasper->output();
            $respuesta =$jasper->execute();

			$reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/Admision_Lista_de_asistencia.pdf";
			if ($respuesta) {
				return new View($respuesta, Response::HTTP_PARTIAL_CONTENT);
			}
			$response = new \Symfony\Component\HttpFoundation\Response(
				file_get_contents($reporte),
				200,
				array(
					'Content-Type' => 'application/pdf',
					'Content-Length' => filesize($reporte)
				)
			);
			return $response;



            //$layout = \AppBundle\Dominio\ListaAsistencia::lista($Lista, $Excel);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna listas de asistencia en base a los parametros enviados
     * @Rest\Get("/api/Listaasistencia/Alumnos", name="buscarAlumnos")
     */
    public function buscarAlumnos()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarListaAsistenciaDetalle($filtros);

            foreach ($entidad as $key => $solicitud) {
                if ($solicitud["evidencia"] != null) {
                    $entidad[$key]["evidencia"] = stream_get_contents($solicitud["evidencia"]);
                }
            }
            if (!$entidad) {
                return new View("El evento  no tiene solicitudes asignadas", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Listaasistencia/" , name="ActualizarListaAsistencia")
     */
    public function updateListaAsistencia()
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
            try {
                foreach ($data['evaluacionporsolicitudadmisionid'] as $key => $id) {
                    $Evaluacionporsolicitudadmision = $dbm->getRepositorioById(
                        'Evaluacionporsolicitudadmision', 'evaluacionporsolicitudadmisionid', $id);
                    $Evaluacionporsolicitudadmision->setAsistio($data['asistio'][$key] == 'true' ? true : false);
                    $dbm->saveRepositorio($Evaluacionporsolicitudadmision);

                    $solicitudadmision = $Evaluacionporsolicitudadmision->getSolicitudadmisionid();
                    $evaluaciones = $dbm->getRepositoriosById('Evaluacionporsolicitudadmision', 'solicitudadmisionid', $solicitudadmision->getSolicitudadmisionid());
                    $completos = array_filter(
                        $evaluaciones, function ($e) {
                            return $e->getEstatusEvaluacionid()->getEstatusEvaluacionid() == 2;
                        });
                    if (sizeof($evaluaciones) == sizeof($completos) && $solicitudadmision->getEstatussolicitudid()->getEstatussolicitudid() < 4) {
                        $solicitudadmision->setEstatussolicitudid($dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', 4));
                        $dbm->saveRepositorio($solicitudadmision);
                    }
                }
                $dbm->getConnection()->commit();
                return new View("Se ha actualizo el registro", Response::HTTP_OK);
            } catch (\Exception $e) {
                return new View("No se pudo actualizar el registro ", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Listaasistencia/" , name="SaveFoto")
     */
    public function saveFoto()
    {
        try {
            $data = $_REQUEST;
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
            $Evaluacionporsolicitudadmision = $dbm->getRepositorioById('Evaluacionporsolicitudadmision', 'evaluacionporsolicitudadmisionid', $data["evaluacionporsolicitudadmisionid"]);
            //$Evaluacionporsolicitudadmision->setEvidencia($data["foto"]);
            $Evaluacionporsolicitudadmision->setAsistio(true);
            $dbm->saveRepositorio($Evaluacionporsolicitudadmision);

            $solicitudadmision = $Evaluacionporsolicitudadmision->getSolicitudadmisionid();
            $datoaspiranteid=$solicitudadmision->getDatoaspiranteid()->getDatoaspiranteid();
            $datoaspirante=$dbm->getRepositorioById("Datoaspirante","datoaspiranteid",$datoaspiranteid);
            $datoaspirante->setFoto($data["foto"]);
            $dbm->saveRepositorio($datoaspirante);
            $evaluaciones = $dbm->getRepositoriosById('Evaluacionporsolicitudadmision', 'solicitudadmisionid', $solicitudadmision->getSolicitudadmisionid());
            $completos = array_filter(
                $evaluaciones, function ($e) {
                    return $e->getEstatusEvaluacionid()->getEstatusEvaluacionid() == 2;
                });
            if (sizeof($evaluaciones) == sizeof($completos) && $solicitudadmision->getEstatussolicitudid()->getEstatussolicitudid() < 4) {
                $solicitudadmision->setEstatussolicitudid($dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', 4));
                $dbm->saveRepositorio($solicitudadmision);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha actualizo el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
