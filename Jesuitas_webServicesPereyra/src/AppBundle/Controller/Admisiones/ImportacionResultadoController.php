<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\Entity\Respuestaporaspirante;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Icicle\Awaitable;
use Icicle\Coroutine\Coroutine;
use Icicle\Loop;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Autor: Javier
 */
class ImportacionResultadoController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Importacionresultado", name="indexImportacionResultado")
     */
    public function indexImportacionResultado()
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $evaluacion = $dbm->getRepositoriosModelo("Evaluacionporgrado", ["d"], [], false, false, [[
				"entidad"=>"Evaluacion",
				"alias"=>"e",
				"left"=>false,
				"on"=>"e.evaluacionid=d.evaluacionid and e.activo = 1"
			]]);

            return new View(array(
                "ciclo" => $ciclo, "nivel" => $nivel, "grado" => $grado, "evaluacion" => $evaluacion), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo layout
     * @Rest\Get("/api/Importacionresultado/", name="downloadLayout")
     */
    public function downloadLayout()
    {
        try {
            $dbm = $this->get("db_manager");
            $datos = $_REQUEST;

            $Excel = $this->get('phpexcel')->createPHPExcelObject();
            $layout = \AppBundle\Dominio\ImportacionResultado::layout($dbm, $datos, $Excel);
            if(!$layout) {
                return new View("No se han configurado preguntas", Response::HTTP_PARTIAL_CONTENT);
            }
            $writer = $this->get('phpexcel')->createWriter($layout, 'Excel5');
            $response = $this->get('phpexcel')->createStreamedResponse($writer);

            $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'stream-file.xlsx');
            $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Cache-Control', 'maxage=1');
            $response->headers->set('Content-Disposition', $dispositionHeader);

            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo layout
     * @Rest\Post("/api/Importacionresultado", name="importarLayoutAdmisiones")
     */
    public function importarLayout()
    {
        try {
            if ($_FILES['layout']['error'] == 1) {
                return new View("El archivo excede el peso permitido "
                    , Response::HTTP_PARTIAL_CONTENT);
            }
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $iniPrecision = ini_get('precision');
            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($_FILES['layout']['tmp_name']);
            ini_set('precision', $iniPrecision);
            $sheet = $phpExcelObject->getActiveSheet();
            $phpExcelObject->getProperties();

            $Solicitudid = $sheet->rangeToArray('A3:A' . $sheet->getHighestDataRow(), null, true, true, true);
            $Preguntasid = $sheet->rangeToArray('G1:' . $sheet->getHighestDataColumn() . '1', null, true, true, true);

            $guardar = function () use ($Solicitudid, $Preguntasid, $sheet, $datos) {
                $dbm = $this->get("db_manager");
                $dbm->getConnection()->beginTransaction();
                yield Awaitable\resolve(self::insertarLayout($Solicitudid, $Preguntasid, $sheet));
                $dbm->getConnection()->commit();

                $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $datos["usuarioid"]);
                $parametros = array("La importación del archivo se ha realiazo exitosamente. ". sizeof($Solicitudid) . " registros fueron importados.");
                $correo = $dbm->getRepositorioById('Correo', 'correoid', 5);
                \AppBundle\Dominio\Correo::ServicioCorreo(array($usuario->getPersonaid()->getEmail()), $parametros, $correo, $this->get('mailer'));
            };

            $routine = new Coroutine($guardar());
            Loop\Run();

            return new View("Se proceso correctamente el archivo. " . sizeof($Solicitudid) . " registros fueron importados.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function insertarLayout($Solicitudid, $Preguntasid, $sheet)
    {
        $dbm = $this->get("db_manager");

        foreach ($Solicitudid as $row => $s) {
            $Evaluacionporsolicitud = $dbm->getRepositorioById('Evaluacionporsolicitudadmision', 'evaluacionporsolicitudadmisionid', $s['A']);
            foreach ($Preguntasid[1] as $colum => $p) {
                $Pregunta = $dbm->getRepositorioById('Pregunta', 'preguntaid', $p);
                if (!$s || !$p) {
                    return new View("El contenido del archivo no es el correcto", Response::HTTP_PARTIAL_CONTENT);
                }
                $Respuesta = $dbm->getByParametersRepositorios('Respuestaporaspirante', array("preguntaid" => $p, "evaluacionporsolicitudadmisionid" => $Evaluacionporsolicitud));
                if ($sheet->getCell($colum . $row)->getValue()) {
                    $Respuesta = $Respuesta ? $Respuesta[0] : new Respuestaporaspirante();
                    $Respuesta->setPreguntaid($Pregunta);
                    $Respuesta->setEvaluacionporsolicitudadmisionid($Evaluacionporsolicitud);
                    $Respuesta->setRespuestaabierta($sheet->getCell($colum . $row)->getValue());
                    $dbm->saveRepositorio($Respuesta);
                }
            }
        }

    }

}
