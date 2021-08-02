<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Rest\Api;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeTarea;
use AppBundle\Entity\CeTareaarchivo;
use AppBundle\Entity\CeTareacomentario;
use AppBundle\Entity\CeTareaalumnovinculo;
use AppBundle\Entity\CeTareaalumnoarchivo;
use AppBundle\Entity\CeTareaalumno;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @author Mariano
 */

class CronogramaTareasController extends FOSRestController
{
    /**
     * Retorna las tareas del alumno para las apps moviles
     * @Rest\Get("/api/Controlescolar/CronogramaDeTareas/TareasAlumno", name="BuscarTareasAlumnoApp")
     */
    public function BuscarTareasAlumnoApp()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $alumnos = $datos["alumnoid"];
            $tareasresponse = [];
            foreach ($alumnos as $akey => $alumnoid) {
                $alumnociclo = $dbm->BuscarAlumnosA(['alumnoid' => $alumnoid])[0];
                $tareas = $dbm->BuscarTareasAlumnoPortal($alumnoid, $alumnociclo['alumnoporcicloid'], null);
                $alumnoporciclo = $dbm->getRepositorioById("CeAlumnoporciclo", "alumnoporcicloid", $alumnociclo['alumnoporcicloid']);
                foreach ($tareas as $key => $tarea) {
                    $ta = $dbm->getRepositorioById("CeTarea", "tareaid", $tarea["TareaID"]);
                    $periodo = $ta->getCriterioevaluaciongrupoid()->getPeriodoevaluacionid()->getPeriodoevaluacionid();

                    $calificacionperiodo = $dbm->getByParametersRepositorios("CeCalificacionperiodoporalumno", [
                        'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid(),
                        'profesorpormateriaplanestudioid' => $ta->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                        'periodoevaluacionid' => $periodo
                    ]);

                    if (count($calificacionperiodo) > 0) {
                        $calificacionperiodo = end($calificacionperiodo);
                        $capturas = $dbm->getByParametersRepositorios("CeCapturacalificacionporalumno", [
                            'calificacionperiodoporalumnoid' => $calificacionperiodo->getCalificacionperiodoporalumnoid(),
                            'numerocaptura' => $ta->getCaptura(),
                            'criterioevaluaciongrupoid' => $ta->getCriterioevaluaciongrupoid()->getCriterioevaluaciongrupoid()
                        ]);

                        foreach ($capturas as $ca) {
                            if ($ca->getCriterioevaluaciongrupoid()->getConfigurartarea() == 1) {
                                $captura = $ca;
                            }
                        }
                        $tarea["Calificacion"] = $ca ? $ca->getCalificacion() : null;
                    }

                    $archivos = $dbm->getRepositoriosById("CeTareaalumnoarchivo", "tareaalumnoid", $tarea["tareaalumnoid"]);
                    $archivosarray = [];
                    foreach ($archivos as $archivo) {
                        $archivosarray[] = array("tareaalumnoarchivoid" => $archivo->getTareaalumnoarchivoid(), "size" => $archivo->getSize(), "nombre" => $archivo->getNombre(), "tipo" => $archivo->getTipo());
                        $tarea["Entregado"] = true;
                    }

                    $vinculos = $dbm->getRepositoriosById("CeTareaalumnovinculo", "tareaalumnoid", $tarea["tareaalumnoid"]);
                    $vinculosarray = [];
                    foreach ($vinculos as $vinculo) {
                        $vinculosarray[] = array("tareaalumnovinculoid" => $vinculo->getTareaalumnovinculoid(), "vinculo" => $vinculo->getVinculo(), "descripcion" => $vinculo->getDescripcion());
                        $tarea["Entregado"] = true;
                    }

                    $archivos = $dbm->getRepositoriosById("CeTareaarchivo", "tareaid", $tarea["TareaID"]);
                    $archivosarray2 = [];
                    foreach ($archivos as $archivo) {
                        $archivosarray2[] = array("tareaarchivoid" => $archivo->getTareaarchivoid(), "size" => $archivo->getSize(), "nombre" => $archivo->getNombre(), "tipo" => $archivo->getTipo());
                    }

                    if ($tarea["Calificacion"] > 0) {
                        if ($tarea["tipoentregaid"] == 2) {
                            $tarea["Entregado"] = true;
                        }
                    }

                    $tareas = [
                        "MateriaNombre" => $tarea["MateriaNombre"],
                        "ProfesorNombre" => $tarea["ProfesorNombre"],
                        "GradoNombre" => $tarea["GradoNombre"],
                        "GrupoNombre" => $tarea["GrupoNombre"],
                        "PeriodoEvaluacionNombre" => $tarea["PeriodoEvaluacionNombre"],
                        "PeriodoEvaluacionNombreCorto" => $tarea["PeriodoEvaluacionNombreCorto"],
                        "TareaNombre" => $tarea["TareaNombre"],
                        "TareaID" => $tarea["TareaID"],
                        "fechainicio" => $tarea["fechainicio"],
                        "fechafin" => $tarea["fechafin"],
                        "Descripcion" => $tarea["Descripcion"],
                        "tareaalumnoid" => $tarea["tareaalumnoid"],
                        "Entregado" => $tarea["Entregado"],
                        "tipoentrega" => $tarea["tipoentrega"],
                        "tipoentregaid" => $tarea["tipoentregaid"],
                        "HoraLimite" => $tarea["HoraLimite"],
                        "puntajemaximo" => $tarea["puntajemaximo"],
                        "calificacion" => $tarea["Calificacion"],
                        "entregaextemporanea" => $tarea["entregaextemporanea"],
                        "IDAlumno" => $tarea["IDAlumno"],
                        "ArchivosAdjuntosAlumno" => $archivosarray,
                        "Vinculos" => $vinculosarray,
                        "ArchivosAdjuntosMaestro" => $archivosarray2,
                        "Comentarios" => $dbm->BuscarComentariosApp($tarea["TareaID"], $tarea["IDAlumno"]),
                    ];

                    $tareasresponse[] = $tareas;
                }

                //tareasresponse=array_merge($tareasresponse,$tareas);
            }
            return new View($tareasresponse, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo de reporte de tareas
     * @Rest\Get("/api/Controlescolar/CronogramaDeTareas/Reporte/", name="DescargaReporteTareas")
     */
    public function DescargaReporteTareas()
    {
        try {
            $dbm = $this->get("db_manager");
            $datos = $_REQUEST;
            $Excel = $this->get('phpexcel')->createPHPExcelObject();
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $registros = $dbm->BuscarTareas(null);
            $layout = \AppBundle\Dominio\ReporteTareas::layout($dbm, $datos, $Excel, $registros);
            $writer = $this->get('phpexcel')->createWriter($layout, 'Excel5');
            $response = $this->get('phpexcel')->createStreamedResponse($writer);
            $dispositionHeader = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'ReporteTareas.xls');
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
     * Guarda tareas del alumno
     * @Rest\Post("/api/Controlescolar/CronogramaDeTareas/TareaAlumno", name="AgregarTareasAlumno")
     */
    public function AgregarTareasAlumno()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $tarea = $dbm->getRepositorioById('CeTarea', 'tareaid', $decoded['tareaid']);
            $fechaactual =  new \DateTime();
            $fechainicio = $tarea->getFechainicio();
            $fechavalida = $tarea->getFechafin();
            $fechavalida->setTime($tarea->getHoralimite()->format("H"), $tarea->getHoralimite()->format("i"), $tarea->getHoralimite()->format("s"));

            if ($fechaactual <= $fechainicio) {
                return new View("El periodo de entrega de esta tarea no ha iniciado.", Response::HTTP_PARTIAL_CONTENT);
            }

            if ($fechavalida <= $fechaactual && !$tarea->getEntregaextemporanea()) {
                return new View("El periodo de entrega de esta tarea está cerrado desde el día " . $fechavalida->format("d/m/Y") . ' a las ' . $fechavalida->format("H:i"), Response::HTTP_PARTIAL_CONTENT);
            }

            function formatSizeUnits($bytes)
            {
                if ($bytes >= 1073741824) {
                    $bytes = number_format($bytes / 1073741824, 2) . ' GB';
                } elseif ($bytes >= 1048576) {
                    $bytes = number_format($bytes / 1048576, 2) . ' MB';
                } elseif ($bytes >= 1024) {
                    $bytes = number_format($bytes / 1024, 2) . ' KB';
                } elseif ($bytes > 1) {
                    $bytes = $bytes . ' bytes';
                } elseif ($bytes == 1) {
                    $bytes = $bytes . ' byte';
                } else {
                    $bytes = '0 bytes';
                }

                return $bytes;
            }

            $size = $dbm->getRepositorioById('Parametros', 'nombre', 'Tamano archivo maximo');

            foreach ($decoded["archivosadjuntos"] as $a) {
                if (strpos($size->getValor(), 'MB') !== false) {
                    if (strpos(formatSizeUnits($a['size']), 'MB') !== false) {
                        $val = explode(' ', formatSizeUnits($a['size']));
                        $val2 = explode(' ', $size->getValor());
                        if ($val[0] > $val2[0]) {
                            return new View("El archivo " . $a['nombre'] . " excede el tamaño máximo permitido de " . $size->getValor(), Response::HTTP_PARTIAL_CONTENT);
                        }
                    } else if (strpos(formatSizeUnits($a['size']), 'GB') !== false) {
                        return new View("El archivo " . $a['nombre'] . " excede el tamaño máximo permitido de " . $size->getValor(), Response::HTTP_PARTIAL_CONTENT);
                    }
                } else if (strpos($size->getValor(), 'GB') !== false) {
                    if (strpos(formatSizeUnits($a['size']), 'GB') !== false) {
                        $val = explode(' ', formatSizeUnits($a['size']));
                        $val2 = explode(' ', $size->getValor());
                        if ($val[0] > $val2[0]) {
                            return new View("El archivo " . $a['nombre'] . " excede el tamaño máximo permitido de " . $size->getValor(), Response::HTTP_PARTIAL_CONTENT);
                        }
                    }
                } else if (strpos($size->getValor(), 'KB') !== false) {
                    if (strpos(formatSizeUnits($a['size']), 'KB') !== false) {
                        $val = explode(' ', formatSizeUnits($a['size']));
                        $val2 = explode(' ', $size->getValor());
                        if ($val[0] > $val2[0]) {
                            return new View("El archivo " . $a['nombre'] . " excede el tamaño máximo permitido de " . $size->getValor(), Response::HTTP_PARTIAL_CONTENT);
                        }
                    } else if (strpos(formatSizeUnits($a['size']), 'MB') !== false) {
                        return new View("El archivo " . $a['nombre'] . " excede el tamaño máximo permitido de " . $size->getValor(), Response::HTTP_PARTIAL_CONTENT);
                    } else if (strpos(formatSizeUnits($a['size']), 'GB') !== false) {
                        return new View("El archivo " . $a['nombre'] . " excede el tamaño máximo permitido de " . $size->getValor(), Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }
            $tareaalumno = $dbm->getByParametersRepositorios("CeTareaalumno", array("tareaid" => $decoded["tareaid"], "alumnoid" => $decoded["alumnoid"]));
            $tareaalumno = $tareaalumno[0];
            $fechafin = new \DateTime($tareaalumno->getTareaid()->getFechafin()->format('Y-m-d') . " " . $tareaalumno->getTareaid()->getHoralimite()->format('H:i:s'));
            $hoy = new \DateTime();
            if ($fechainicio <= $fechaactual && $fechaactual <= $fechavalida) {
                $tareaalumno->setEntiempo(1);
            } else {
                $tareaalumno->setEntiempo(0);
            }
            $tareaalumno->setFecha($hoy);
            $dbm->saveRepositorio($tareaalumno);

            foreach ($decoded["archivosadjuntos"] as $a) {
                $tareaarchivo = $hydrator->hydrate(new CeTareaalumnoarchivo(), $a);
                $tareaarchivo->setTareaalumnoid($tareaalumno->getTareaalumnoid());
                $dbm->saveRepositorio($tareaarchivo);
            }
            $dbm->getConnection()->commit();
            return new View("Se guardo la tarea.", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina vinculos de la tarea del alumno
     * @Rest\Delete("/api/Controlescolar/CronogramaDeTareas/Vinculos/{tareaalumnovinculoid}", name="EliminarTareasAlumnoVinculo")
     */
    public function EliminarTareasAlumnoVinculo($tareaalumnovinculoid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $vinculo = $dbm->getRepositorioById("CeTareaalumnovinculo", "tareaalumnovinculoid", $tareaalumnovinculoid);
            $dbm->removeRepositorio($vinculo);
            return new View("Se elimino el vínculo.", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda los vinculos de la tarea del alumno
     * @Rest\Post("/api/Controlescolar/CronogramaDeTareas/Vinculos", name="GuardarVinculos")
     */
    public function GuardarVinculos()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $vinculo = $hydrator->hydrate(new CeTareaalumnovinculo(), $decoded);
            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($vinculo);
            $tareaalumno = $dbm->getRepositorioById("CeTareaalumno", "tareaalumnoid", $decoded["tareaalumnoid"]);
            $fechafin = new \DateTime($tareaalumno->getTareaid()->getFechafin()->format('Y-m-d') . " " . $tareaalumno->getTareaid()->getHoralimite()->format('H:i:s'));
            $hoy = new \DateTime();
            if ($hoy > $fechafin) {
                $tareaalumno->setEntiempo(0);
            } else {
                $tareaalumno->setEntiempo(1);
            }
            $tareaalumno->setFecha($hoy);
            $dbm->saveRepositorio($tareaalumno);
            $dbm->getConnection()->commit();
            return new View("Se guardo el vínculo.", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna los datos del alumno en base al usuario
     * @Rest\Get("/api/Controlescolar/CronogramaDeTareas/DatosAlumno/{alumnoid}", name="DatosAlumno")
     */
    public function DatosAlumno($alumnoid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $datos = $dbm->BuscarDatosAlumno($alumnoid);
            $datos[0]["foto"] = stream_get_contents($datos[0]["foto"]);
            return new View($datos[0], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna las tareas del alumno en los portales
     * ELIMINAR, utilizar el mismo servicio de las apps 
     * @Rest\Get("/api/Controlescolar/CronogramaDeTareas/AlumnoGrid/{alumnoid}", name="TareasAlumno")
     */
    public function TareasAlumno($alumnoid)
    {

        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $tamanoMaximo = $dbm->getRepositorioById("Parametros", "nombre", 'Tamano archivo maximo');
            $alumnociclo = $dbm->BuscarAlumnosA(['alumnoid' => $alumnoid])[0];
            $tareas = $dbm->BuscarTareasAlumnoPortal($alumnoid, $alumnociclo['alumnoporcicloid'], $datos['profesorpormateriaplanestudiosid']);
            $alumnoporciclo = $dbm->getRepositorioById("CeAlumnoporciclo", "alumnoporcicloid", $alumnociclo['alumnoporcicloid']);
            foreach ($tareas as $key => $tarea) {
                $valido = 0;
                $periodoinicio = 0;
                $periodofin = 0;
                $entregaextemporanea = 0;
                $ta = $dbm->getRepositorioById("CeTarea", "tareaid", $tarea["TareaID"]);
                $periodo = $ta->getCriterioevaluaciongrupoid()->getPeriodoevaluacionid()->getPeriodoevaluacionid();
                $fechafin = $ta->getfechafin()->format('Y/m/d');
                $horafin = $ta->getHoralimite()->format('h:i:s');
                $fechaactual =  new \DateTime();
                $fechainicio = $ta->getFechainicio();
                $fechavalida = new \DateTime($fechafin);
                $fechavalida->setTime($ta->getHoralimite()->format("H"), $ta->getHoralimite()->format("i"), $ta->getHoralimite()->format("s"));
                $calificacionperiodo = $dbm->getByParametersRepositorios("CeCalificacionperiodoporalumno", [
                    'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid(),
                    'profesorpormateriaplanestudioid' => $ta->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                    'periodoevaluacionid' => $periodo
                ]);

                if ($fechainicio <= $fechaactual && ($fechaactual <= $fechavalida || $ta->getEntregaextemporanea())) {
                    $valido = 1;
                } else {
                    $valido = 0;
                }

                if ($fechaactual <= $fechainicio) {
                    $periodoinicio = 1;
                } else {
                    $periodoinicio = 0;
                }

                if ($fechavalida <= $fechaactual) {
                    $periodofin = 1;
                    if ($ta->getEntregaextemporanea()) {
                        $entregaextemporanea = 1;
                    } else {
                        $entregaextemporanea = 0;
                    }
                } else {
                    $periodofin = 0;
                }

                $tareas[$key]["valido"] = $valido;
                $tareas[$key]["periodoinicio"] = $periodoinicio;
                $tareas[$key]["periodofin"] = $periodofin;
                $tareas[$key]["tamanoMaximo"] = $tamanoMaximo ? $tamanoMaximo->getValor() : null;
                $tareas[$key]["entregaextemporanea"] = $entregaextemporanea;
                if (count($calificacionperiodo) > 0) {
                    $calificacionperiodo = end($calificacionperiodo);
                    $capturas = $dbm->getByParametersRepositorios("CeCapturacalificacionporalumno", [
                        'calificacionperiodoporalumnoid' => $calificacionperiodo->getCalificacionperiodoporalumnoid(),
                        'numerocaptura' => $ta->getCaptura(),
                        'criterioevaluaciongrupoid' => $ta->getCriterioevaluaciongrupoid()->getCriterioevaluaciongrupoid()
                    ]);

                    foreach ($capturas as $ca) {
                        if ($ca->getCriterioevaluaciongrupoid()->getConfigurartarea() == 1) {
                            $captura = $ca;
                        }
                    }
                    $tareas[$key]["Calificacion"] = $ca ? $ca->getCalificacion() : null;
                }

                $archivos = $dbm->getRepositoriosById("CeTareaalumnoarchivo", "tareaalumnoid", $tarea["tareaalumnoid"]);
                $archivosarray = [];
                foreach ($archivos as $archivo) {
                    $archivosarray[] = array(
                        "tareaalumnoarchivoid" => $archivo->getTareaalumnoarchivoid(), "size" => $archivo->getSize(), "nombre" => $archivo->getNombre(), "tipo" => $archivo->getTipo(),
                        "contenido" => null //stream_get_contents($archivo->getContenido())
                    );
                    $tareas[$key]["Entregado"] = true;
                }

                $vinculos = $dbm->getRepositoriosById("CeTareaalumnovinculo", "tareaalumnoid", $tarea["tareaalumnoid"]);
                $vinculosarray = [];
                foreach ($vinculos as $vinculo) {
                    $vinculosarray[] = array("tareaalumnovinculoid" => $vinculo->getTareaalumnovinculoid(), "vinculo" => $vinculo->getVinculo(), "descripcion" => $vinculo->getDescripcion());
                    $tareas[$key]["Entregado"] = true;
                }

                $archivos = $dbm->getRepositoriosById("CeTareaarchivo", "tareaid", $tarea["TareaID"]);
                $archivosarray2 = [];
                foreach ($archivos as $archivo) {
                    $archivosarray2[] = array(
                        "tareaarchivoid" => $archivo->getTareaarchivoid(), "size" => $archivo->getSize(), "nombre" => $archivo->getNombre(), "tipo" => $archivo->getTipo(),
                        "contenido" => null //stream_get_contents($archivo->getContenido())
                    );
                }


                if ($tareas[$key]["Calificacion"] > 0) {
                    if ($ta->getTipoentregaid()->getTipoentregaid() == 2) {
                        $tareas[$key]["Entregado"] = true;
                    }
                }
                $tareas[$key]["ArchivosAdjuntosAlumno"] = $archivosarray;
                $tareas[$key]["Vinculos"] = $vinculosarray;
                $tareas[$key]["ArchivosAdjuntosMaestro"] = $archivosarray2;
                $comentarios = $dbm->BuscarComentarios($tarea["TareaID"], $tarea["IDAlumno"]);
                $tareas[$key]["Comentarios"] = $comentarios;
            }
            return new View($tareas, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * @Rest\Get("/api/Controlescolar/CronogramaDeTareas/AlumnoMaterias/{alumnoid}", name="AlumnoMaterias")
    */
    public function AlumnoMaterias($alumnoid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumno = $dbm->BuscarAlumnosA(["alumnoid" => $alumnoid])[0];
            $planestudio = $dbm->getOneByParametersRepositorio("CePlanestudios", 
                ["gradoid"=> $alumno['gradoid'], "vigente"=> 1]);
            $mpe = $dbm->getRepositoriosById('CeMateriaporplanestudios', 'planestudioid', $planestudio->getPlanestudioid());
    
            return new View($mpe, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Guarda los comentarios del usuario
     * @Rest\Put("/api/Controlescolar/CronogramaDeTareas/Calificacion/{tareaalumnoid}", name="ActualizaCalificacion")
     */
    public function ActualizaCalificacion($tareaalumnoid)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $tarea = $dbm->getRepositorioById("CeTareaalumno", "tareaalumnoid", $tareaalumnoid);
            $controller = new CapturaCalificacionesController();
            $materiaid = ($tarea->getTareaid()->getMateriaid() ? $tarea->getTareaid()->getMateriaid()->getMateriaid() : null);
            $datos = $dbm->getDatosCalificarTarea($tareaalumnoid, $materiaid)[0];
            if (!$datos) {
                return new View("La captura de calificaciones aún no esta disponible", Response::HTTP_PARTIAL_CONTENT);
            }
            $datos['calificacioncaptura'] = $decoded["calificacion"];
            $controller->Calificar($datos, $dbm);
            $tarea->setCalificacion($decoded["calificacion"]);
            $dbm->saveRepositorio($tarea);

            /*
            $entidad=$tarea;
            $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
            if ($usuariodestino){
                $actividad=[
                    "tipoactividadid"=>8,
                    "usuariodestinoid"=>$usuariodestino
                ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),null);
            }
            */

            return new View("Se guardo la calificación.", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda los comentarios del usuario
     * @Rest\Post("/api/Controlescolar/CronogramaDeTareas/Comentarios", name="GuardarComentarios")
     */
    public function GuardarComentarios()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            //$decoded["fecha"] = new \DateTime($decoded["fecha"]["date"]["year"] . "-" . $decoded["fecha"]["date"]["month"] . "-" . $decoded["fecha"]["date"]["day"]);
            $decoded["fecha"] = new \DateTime();
            $comentario = $hydrator->hydrate(new CeTareacomentario(), $decoded);
            $dbm->saveRepositorio($comentario);
            $entidad = $comentario;
            $usuariodestino = $dbm->getRepositorioById("Usuario", "alumnoid", $entidad->getAlumnoid());
            if ($usuariodestino) {
                if ($entidad) {
                    $proftmp = $entidad->getTareaid()->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getProfesorid();

                    $params = [
                        "Materia" => $entidad->getTareaid()->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()
                            ->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                        "Profesor" => $proftmp->getApellidopaterno() . ' ' . $proftmp->getApellidomaterno() . ' ' .
                            $proftmp->getNombre(),
                        "TareaNombre" => $entidad->getTareaid()->getNombre(),
                        "TareaNumero" => $entidad->getTareaid()->getCaptura()
                    ];
                }
                $usuariodestino = $usuariodestino->getUsuarioid();
                $actividad = [
                    "tipoactividadid" => 15,
                    "usuarioorigenid" => $entidad->getUsuarioid()->getUsuarioid(),
                    "usuariodestinoid" => $usuariodestino
                ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad, $entidad, $dbm, $this->get('mailer'), $params);
            }
            return new View("Se guardo el comentario.", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna las tareas asociadas al alumno
     * @Rest\Get("/api/Controlescolar/CronogramaDeTareas/DetalleTareaAlumnoGrid/{tareaid}", name="BuscarTareasAlumno")
     */
    public function BuscarTareasAlumno($tareaid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $tarea = $dbm->getRepositorioById("CeTarea", "tareaid", $tareaid);
            $calificacionCTRL = new CapturaCalificacionesController($dbm);
            $materiaid = null;
            $materiaporplan = null;
            $periodo = null;
            $dbm->getConnection()->beginTransaction();
            if ($tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getGrupoid()) {
                $grupoid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getGrupoid()->getGrupoid();
                $cicloid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getGrupoid()->getCicloid()->getCicloid();
                $alumnos = $dbm->AlumnoCicloGrupo($cicloid, $grupoid, null);
                $grupox =  $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getGrupoid()->getNombre();
                if (!$alumnos) {
                    return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
                }
                $materiaid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getMateriaporplanestudioid();
                $materiaporplan = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getMateriaid()->getMateriaid();
                if ($tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getMateriaid()) {
                    $submateriaid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getMateriaid()->getMateriaid();
                }
                $calificacionCTRL::CCCapturaCalificacionGrupoProcess($dbm, [
                    'profesorpormateriaplanestudiosid' => $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                    'cicloid' => $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getGrupoid()->getCicloid()->getCicloid(),
                    'gradoid' => $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getGrupoid()->getGradoid()->getGradoid(),
                    'grupoid' => $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getGrupoid()->getGrupoid(),
                    'materiaid' => $materiaid,
                    'submateriaid' => $submateriaid,
                    'periodoevaluacionid' => $tarea->getCriterioevaluaciongrupoid()->getPeriodoevaluacionid()->getPeriodoevaluacionid(),
                    'novalidar' => true
                ]);
                $periodo = $tarea->getCriterioevaluaciongrupoid()->getPeriodoevaluacionid()->getPeriodoevaluacionid();
            } else {
                $grupoid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getTallerid()->getTallercurricularid();
                $cicloid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getTallerid()->getCicloid()->getCicloid();
                $alumnos = $dbm->AlumnoCicloGrupo($cicloid, $grupoid, null, true);
                $grupox = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getTallerid()->getNombre();
                if (!$alumnos) {
                    return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
                }
                $alumnociclo = $dbm->BuscarAlumnosA(['alumnoid' => $alumnos[0]["IDAlumno"], "cicloid" => $cicloid])[0];
                if($alumnociclo['gradoid'] == 10) {
                    $r = 9;
                }
                $gradoportaller = $dbm->getOneByParametersRepositorio("CeGradoportallercurricular", [
                    'gradoid' => $alumnociclo['gradoid'],
                    'tallercurricularid' => $grupoid
                ]);
                $materiaid = $gradoportaller->getMateriaporplanestudioid()->getMateriaporplanestudioid();
                $materiaporplan = $gradoportaller->getMateriaporplanestudioid()->getMateriaid()->getMateriaid();
                $calificacionCTRL::CCCapturaCalificacionGrupoProcess($dbm, [
                    'profesorpormateriaplanestudiosid' => $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                    'cicloid' => $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getTallerid()->getCicloid()->getCicloid(),
                    'gradoid' => $gradoportaller->getGradoid()->getGradoid(),
                    'materiaid' => $materiaid,
                    'periodoevaluacionid' => $tarea->getCriterioevaluaciongrupoid()->getPeriodoevaluacionid()->getPeriodoevaluacionid(),
                    'novalidar' => true
                ]);
                $periodo = $tarea->getCriterioevaluaciongrupoid()->getPeriodoevaluacionid()->getPeriodoevaluacionid();
            }
            if (!$alumnos) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach ($alumnos as $key => $alumno) {
                //$alumnociclo = $dbm->BuscarAlumnosA(['alumnoid' => $alumno["IDAlumno"], 'cicloid' => $cicloid]);
                $alumnoporciclo = $dbm->getRepositorioById("CeAlumnoporciclo", "alumnoporcicloid", $alumno['alumnoporcicloid']);
                $tareaalumno = $dbm->getByParametersRepositorios("CeTareaalumno", array("tareaid" => $tareaid, "alumnoid" => $alumno["alumnoid"]));

                $calificacionperiodo = end($dbm->getByParametersRepositorios("CeCalificacionperiodoporalumno", [
                    'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid(),
                    'profesorpormateriaplanestudioid' => $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                    'periodoevaluacionid' => $periodo
                ]));
                $capturas = $dbm->getByParametersRepositorios("CeCapturacalificacionporalumno", [
                    'calificacionperiodoporalumnoid' => $calificacionperiodo->getCalificacionperiodoporalumnoid(),
                    'numerocaptura' => $tarea->getCaptura(),
                    'criterioevaluaciongrupoid' => $tarea->getCriterioevaluaciongrupoid()->getCriterioevaluaciongrupoid()
                ]);

                foreach ($capturas as $ca) {
                    if ($ca->getCriterioevaluaciongrupoid()->getConfigurartarea() == 1) {
                        $captura = $ca;
                    }
                }

                if (!$tareaalumno) {
                    $tareaalumno = new CeTareaalumno();
                    $tareaalumno->setTareaid($dbm->getRepositorioById("CeTarea", "tareaid", $tareaid));
                    $tareaalumno->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $alumno["alumnoid"]));
                    $dbm->saveRepositorio($tareaalumno);
                } else {
                    $tareaalumno = $tareaalumno[0];
                }
                $vinculos = $dbm->getRepositoriosById("CeTareaalumnovinculo", "tareaalumnoid", $tareaalumno->getTareaalumnoid());
                $vinculosarray = [];
                foreach ($vinculos as $vinculo) {
                    $vinculosarray[] = array("tareaalumnovinculoid" => $vinculo->getTareaalumnovinculoid(), "vinculo" => $vinculo->getVinculo(), "descripcion" => $vinculo->getDescripcion(), 'leido' => $vinculo->getLeido());
                }

                $archivos = $dbm->getRepositoriosById("CeTareaalumnoarchivo", "tareaalumnoid", $tareaalumno->getTareaalumnoid());
                $archivosarray = [];
                foreach ($archivos as $archivo) {
                    $archivosarray[] = array(
                        "tareaalumnoarchivoid" => $archivo->getTareaalumnoarchivoid(), 
                        "nombre" => $archivo->getNombre()
                    );
                }
                $tareas[$key] = $alumno;
                $tareas[$key]["ArchivosAdjuntos"] = $archivosarray;
                $tareas[$key]["Comentarios"] = $dbm->BuscarComentarios($tareaid, $alumno["alumnoid"]);
                if ($captura) {
                    $tareas[$key]["Calificacion"] = $captura->getCalificacion();
                    $tareas[$key]["gradoid"] = $alumnoporciclo->getGradoid()->getGradoid();
                    $tareas[$key]["grado"] = $alumnoporciclo->getGradoid()->getGrado();
                    $tareas[$key]["grupo"] = $grupox;
                    $tareas[$key]["capturacalificacionporalumnoid"] = $captura->getCapturacalificacionporalumnoid();
                    $tareas[$key]["calificacionperiodoporalumnoid"] = $calificacionperiodo->getCalificacionperiodoporalumnoid();
                    $tareas[$key]["calificacionfinalperiodoporalumnoid"] = $calificacionperiodo->getCalificacionfinalporperiodoalumno()->getCalificacionfinalperiodoporalumnoid();
                }
                $tareas[$key]["Vinculos"] = $vinculosarray;
                $tareas[$key]["EnTiempo"] = $tareaalumno->getEntiempo();
                $tareas[$key]["FechaEntrega"] = $tareaalumno->getFecha() ? $tareaalumno->getFecha()->format('d/m/Y') : null;
                $tareas[$key]["tareaalumnoid"] = $tareaalumno->getTareaalumnoid();
            }
            $dbm->getConnection()->commit();
            return new View($tareas, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna las tareas asociadas al alumno
     * @Rest\Post("/api/Controlescolar/CronogramaDeTareas/ComentariosLeido", name="ComentariosLeido")
     */
    public function ComentariosLeido()
    {
        try {
            $content = file_get_contents("php://input");
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($decoded['comentarios'] as $comentario) {
                $tareacomentario = $dbm->getRepositorioById('CeTareacomentario', 'tareacomentarioid', $comentario);
                if ($tareacomentario) {
                    $tareacomentario->setLeido(true);
                    $dbm->saveRepositorio($tareacomentario);
                }
            }

            $comentarios = $dbm->BuscarComentarios($decoded["tareaid"], $decoded["IDAlumno"]);

            $dbm->getConnection()->commit();

            return new View($comentarios, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna las tareas asociadas al alumno
     * @Rest\Post("/api/Controlescolar/CronogramaDeTareas/VinculosLeido", name="VinculosLeido")
     */
    public function VinculosLeido()
    {
        try {
            $content = file_get_contents("php://input");
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($decoded['vinculos'] as $vinculo) {
                $tareavinculo = $dbm->getRepositorioById('CeTareaalumnovinculo', 'tareaalumnovinculoid', $vinculo);
                if ($tareavinculo) {
                    $tareavinculo->setLeido(true);
                    $dbm->saveRepositorio($tareavinculo);
                }
            }

            $vinculos = $dbm->getRepositoriosById("CeTareaalumnovinculo", "tareaalumnoid", $decoded['tareaalumnoid']);
            $vinculosarray = [];
            foreach ($vinculos as $vinculo) {
                $vinculosarray[] = array("tareaalumnovinculoid" => $vinculo->getTareaalumnovinculoid(), "vinculo" => $vinculo->getVinculo(), "descripcion" => $vinculo->getDescripcion(), 'leido' => $vinculo->getLeido());
            }

            $dbm->getConnection()->commit();

            return new View($vinculosarray, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna las tareas asociadas al alumno
     * @Rest\Get("/api/Controlescolar/CronogramaDeTareas/TareaArchivo/{tareaarchivoid}", name="ObtenerTareaArchivo")
     */
    public function ObtenerTareaArchivo($tareaarchivoid)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if ($datos["tipo"] == "profesor") {
                $archivo = $dbm->getRepositorioById("CeTareaarchivo", "tareaarchivoid", $tareaarchivoid);
            } else {
                $archivo = $dbm->getRepositorioById("CeTareaalumnoarchivo", "tareaalumnoarchivoid", $tareaarchivoid);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                base64_decode(stream_get_contents($archivo->getContenido())),
                200,
                array(
                    'Content-Type' => $archivo->getTipo(),
                    'Content-Length' => $archivo->getSize()
                )
            );
            $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($archivo->getNombre()) . '";');
            return $response;
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina tareas y sus relaciones
     * @Rest\Delete("/api/Controlescolar/CronogramaDeTareas/{tareaid}", name="EliminarTareas")
     */
    public function EliminarTareas($tareaid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $tarea = $dbm->getRepositorioById("CeTarea", "tareaid", $tareaid);
            $tareaalumno = $dbm->getRepositorioById("CeTareaalumno", "tareaid", $tareaid);
            if ($tareaalumno) {
                $archivos = $dbm->getRepositorioById("CeTareaalumnoarchivo", "tareaalumnoid", $tareaalumno->getTareaalumnoid());
                $vinculos = $dbm->getRepositorioById("CeTareaalumnovinculo", "tareaalumnoid", $tareaalumno->getTareaalumnoid());
            }
            if (!$archivos || !$vinculos) {
                // $fecha = $tarea->getFechainicio();
                // $time1 = strtotime($fecha->format('d-m-Y'));
                // $date_now = strtotime(date('d-m-Y'));
                // if ($date_now>=$time1){
                //     return new View("No se puede eliminar esta tarea ya que el periodo de entrega ya inicio.", Response::HTTP_OK);
                // }else{
                // }
                $dbm->getConnection()->beginTransaction();
                $dbm->removeManyRepositorio('CeTareaalumno', 'tareaid', $tareaid);
                $dbm->removeRepositorio($tarea);
                $dbm->getConnection()->commit();
                return new View("Se elimino la tarea.", Response::HTTP_OK);
            } else {
                return new View("Existen tareas de alumno asociadas a esta tarea.", Response::HTTP_OK);
            }
        } catch (Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Guarda tareas
     * @Rest\Post("/api/Controlescolar/CronogramaDeTareas/DetalleTareaAgregar", name="AgregarTareas")
     */
    public function AgregarTareas()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());


            if ($decoded["captura"] > $decoded['capturaTotal']) {
                $criterio = $dbm->getRepositorioById("CeCriterioevaluaciongrupo", "criterioevaluaciongrupoid", $decoded["criterioevaluaciongrupoid"]);
                $criterio->setCapturas($decoded['capturaTotal'] + 1);
                $dbm->saveRepositorio($criterio);

                \AppBundle\Controller\Controlescolar\CapturaCalificacionesController::re_calcularCalificacionesGrupo(
                    $dbm,
                    $criterio->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(), 
                    $criterio->getPeriodoevaluacionid()->getPeriodoevaluacionid() 
                );
            }

            $fechainicio = new \DateTime($decoded["periodoentrega"]["beginDate"]["year"] . "-" . $decoded["periodoentrega"]["beginDate"]["month"] . "-" . $decoded["periodoentrega"]["beginDate"]["day"]);
            $fechafin = new \DateTime($decoded["periodoentrega"]["endDate"]["year"] . "-" . $decoded["periodoentrega"]["endDate"]["month"] . "-" . $decoded["periodoentrega"]["endDate"]["day"]);
            $horalimite = new \DateTime($decoded["horalimite"]);
            $decoded["fechainicio"] = $fechainicio;
            $decoded["fechafin"] = $fechafin;
            $decoded["horalimite"] = $horalimite;
            $decoded["entregaextemporanea"] = $decoded["entregaextemporanea"] ? 1 : 0;
            $tarea = $hydrator->hydrate($decoded["tareaid"] ? $dbm->getRepositorioById("CeTarea", "tareaid", $decoded["tareaid"]) : new CeTarea(), $decoded);
            /*if ($dbm->getRepositorioById("CeTareaalumno", "tareaid", $decoded["tareaid"])){
                return new View("Existen archivos asociados a esta tarea.", Response::HTTP_OK);
            }*/
            $tarea->setCriterioevaluaciongrupoid($dbm->getRepositorioById("CeCriterioevaluaciongrupo", "criterioevaluaciongrupoid", $decoded["criterioevaluaciongrupoid"]));

            $dbm->saveRepositorio($tarea);



            if ($tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getTallerid()) {
                $grupoid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getTallerid()->getTallercurricularid();
                $taller =  $dbm->getRepositorioById("CeTallercurricular", "tallercurricularid", $grupoid);
                $alumnos = $dbm->AlumnoCicloGrupo($taller->getCicloid()->getCicloid(), $grupoid, null, true);
            } else {
                $grupoid = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getGrupoid()->getGrupoid();
                $grupo =  $dbm->getRepositorioById("CeGrupo", "grupoid", $grupoid);
                $alumnos = $dbm->AlumnoCicloGrupo($grupo->getCicloid()->getCicloid(), $grupoid, null, false);
            }

            if ($alumnos) {
                if ($tarea) {
                    $proftmp = $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getProfesorid();
                    $params = [
                        "Profesor" => $proftmp->getApellidopaterno() . ' ' . $proftmp->getApellidomaterno() . ' ' .
                            $proftmp->getNombre(),
                        //"Materia" => $tarea->getCriterioevaluaciongrupoid()->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                        "TareaNombre" => $tarea->getNombre(),
                        "TareaNumero" => $tarea->getCaptura()

                    ];
                }
                foreach ($alumnos as $key => $alumno) {
                    $tareaalumno = $dbm->getByParametersRepositorios("CeTareaalumno", array("tareaid" => $tarea->getTareaid(), "alumnoid" => $alumno["IDAlumno"]));
                    if (!$tareaalumno) {
                        $tareaalumno = new CeTareaalumno();
                        $tareaalumno->setTareaid($dbm->getRepositorioById("CeTarea", "tareaid", $tarea->getTareaid()));
                        $tareaalumno->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $alumno["alumnoid"]));
                        $dbm->saveRepositorio($tareaalumno);
                        $tipoactividadid = 13;
                    } else {
                        $tareaalumno = $tareaalumno[0];
                        $tipoactividadid = 12;
                    }

                    $archivos = $dbm->getRepositoriosById("CeTareaalumnoarchivo", "tareaalumnoid", $tareaalumno->getTareaalumnoid());
                    $archivosarray = [];
                    foreach ($archivos as $archivo) {
                        $archivosarray[] = array("tareaalumnoarchivoid" => $archivo->getTareaalumnoarchivoid(), "size" => $archivo->getSize(), "nombre" => $archivo->getNombre(), "tipo" => $archivo->getTipo(), "contenido" => stream_get_contents($archivo->getContenido()));
                    }
                    $tareas[$key] = $alumno;
                    $tareas[$key]["ArchivosAdjuntos"] = $archivosarray;
                    $tareas[$key]["Comentarios"] = $dbm->BuscarComentarios($tarea->getTareaid(), $alumno["alumnoid"]);
                    $tareas[$key]["Calificacion"] = $tareaalumno->getCalificacion();
                    $tareas[$key]["tareaalumnoid"] = $tareaalumno->getTareaalumnoid();


                    $entidad = $tareaalumno;
                    $usuariodestino = $dbm->getRepositorioById("Usuario", "alumnoid", $entidad->getAlumnoid()->getAlumnoid());
                    if ($usuariodestino) {
                        $actividad = [
                            "tipoactividadid" => $tipoactividadid,
                            "usuariodestinoid" => $usuariodestino->getUsuarioid()
                        ];
                        //\AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad, $entidad, $dbm, $this->get('mailer'), $params);
                    }
                }
            }


            $dbm->removeManyRepositorio("CeTareaarchivo", 'tareaid', $tarea->getTareaid());
            foreach ($decoded["archivosadjuntos"] as $a) {
                if (!empty($a['contenido'])) {
                    $tareaarchivo = $hydrator->hydrate(new CeTareaArchivo(), $a);
                    $tareaarchivo->setTareaid($tarea);
                    $dbm->saveRepositorio($tareaarchivo);
                }
            }
            $dbm->getConnection()->commit();


            return Api::Ok("Se guardo la tarea.", $tarea);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna las tareas asociadas al profesor y materia
     * @Rest\Get("/api/Controlescolar/CronogramaDeTareas/DetalleTareaGrid/{profesorpormateriaplanestudioid}", name="BuscarTareas")
     */
    public function BuscarTareas($profesorpormateriaplanestudioid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $tareas = $dbm->BuscarTareas($profesorpormateriaplanestudioid);
            if (!$tareas) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach ($tareas as $key => $tarea) {
                $tareasperiodo = count($dbm->getRepositoriosById("CeTarea", "criterioevaluaciongrupoid", $tarea["criterioevaluaciongrupoid"]));
                $tareas[$key]["TareasPeriodo"] = $tareasperiodo;
                $archivos = $dbm->getRepositoriosById("CeTareaarchivo", "tareaid", $tarea["ID"]);
                $archivosarray = [];
                foreach ($archivos as $archivo) {
                    $archivosarray[] = array("tareaarchivoid" => $archivo->getTareaarchivoid(), "size" => $archivo->getSize(), "nombre" => $archivo->getNombre(), "tipo" => $archivo->getTipo(), "contenido" => stream_get_contents($archivo->getContenido()));
                }
                $tareas[$key]["archivostareas"] = $archivosarray;
                $time1 = strtotime(str_replace('/', '-', $tarea["fechainicio"]));
                $date_now = strtotime(date('d-m-Y'));
                if ($date_now >= $time1) {
                    $tareas[$key]["editable"] = false;
                } else { }
                $tareas[$key]["editable"] = true;
            }
            return new View($tareas, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/CronogramaDeTareas/{profesorpormateriaplanestudioid}", name="indexConogramaDeTareas")
     */
    public function ConogramaDeTareas($profesorpormateriaplanestudioid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarAsignacionProfesor($profesorpormateriaplanestudioid);
            $tamanoMaximo = $dbm->getRepositoriosById("Parametros", "nombre", 'Tamano archivo maximo');
            if (!$entidad) {
                return new View("No hay un aspecto de evaluación para tareas.", Response::HTTP_PARTIAL_CONTENT);
            }
            $periodosdeevaluacion = $dbm->getRepositorios("CePeriodoevaluacion");
            $criterios = [];
            foreach ($periodosdeevaluacion as $pe) {
                $criterio = $dbm->getByParametersRepositorios("CeCriterioevaluaciongrupo", array("periodoevaluacionid" => $pe->getPeriodoevaluacionid(), "profesorpormateriaplanestudiosid" => $profesorpormateriaplanestudioid, "configurartarea" => 1));
                $criteriosData = [];
                foreach ($criterio as $c) {
                    $criterios[] = $c;
                    $tareasperiodo = count($dbm->getRepositoriosById("CeTarea", "criterioevaluaciongrupoid", $c->getCriterioevaluaciongrupoid()));
                    $tareasperiodo = $c->getCapturas();
                    $criteriosData[] = array("descripcion" => $pe->getDescripcion(), "periodoevaluacionid" => $pe->getPeriodoevaluacionid(), "tareasperiodo" => $tareasperiodo, "criterioevaluaciongrupoid" => $c->getCriterioevaluaciongrupoid());
                }
                $criterio = $criterio[0];
                if ($criterio) {
                    $tareasperiodo = count($dbm->getRepositoriosById("CeTarea", "criterioevaluaciongrupoid", $criterio->getCriterioevaluaciongrupoid()));
                    $tareasperiodo = $criterio->getCapturas();
                    $p = array("descripcion" => $pe->getDescripcion(), "periodoevaluacionid" => $pe->getPeriodoevaluacionid(), "tareasperiodo" => $tareasperiodo, "criterioevaluaciongrupoid" => $criterio->getCriterioevaluaciongrupoid(), 'criterios' => $criteriosData);
                    $periodosarray[] = $p;
                }
            }

            $tipodeentrega = $dbm->getRepositorios("CeTipoentrega");



            return new View(array("datos" => $entidad[0], "periodosdeevaluacion" => $periodosarray, "tipodeentrega" => $tipodeentrega, "tamanoMaximo" => $tamanoMaximo, 'criterios' => $criterios), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
