<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\DB\DbmPortalAlumno;
use AppBundle\Controller\Controlescolar\CapturaCalificacionesController;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Dominio\ClasificadorAlumno;

/**
 * @author Mariano
 */
class PortalAlumnoController extends FOSRestController
{
    /**
     * Retorna los datos del alumno
     * @Rest\Get("/api/portalalumno/alumno/{alumnoid}", name="BuscarAlumno")
     */
    public function BuscarAlumno($alumnoid)
    {
        try {
            $dbm = new DbmPortalAlumno($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositorioById("Ciclo", "actual", 1);
            $ac = $dbm->getOneByParametersRepositorio("CeAlumnoporciclo", ["cicloid" => $ciclo->getCicloid(), "alumnoid" => $alumnoid]);
            $grupo = $dbm->getRepositorioById("CeAlumnocicloporgrupo", "alumnoporcicloid", $ac->getAlumnoporcicloid());
            if (!$grupo) {
                return new View('Aún no se ha asignado a un grupo', Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($grupo, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de tipos de evento
     * @Rest\Get("/api/portalalumno/tipoevento", name="BuscarTipoEvento")
     */
    public function getTipoEvento()
    {
        try {
            $dbm = new DbmPortalAlumno($this->get("db_manager")->getEntityManager());
            $tipoevento = $dbm->getRepositorios("CeTipoevento");
            if (!$tipoevento) {
                return [];
            }
            return new View($tipoevento, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna arreglo de calificaiones del alumno en un periodo
     * @Rest\Get("/api/portalalumno/calificaciones", name="BuscarCalificacionesAlumno")
     */
    public function getCalificacionesAlumno()
    {
        try {

            $datos = $_REQUEST;
            $dbm = new DbmPortalAlumno($this->get("db_manager")->getEntityManager());
            $cicloactual = $dbm->getRepositorioById('Ciclo', 'actual', 1);
            $cicloid = $cicloactual->getCicloId();
            foreach ($datos["alumnoid"] as $akey => $alumnoid) {
                $respuesta[] = array("alumnoid" => $alumnoid);
                $ac = $dbm->getOneByParametersRepositorio('CeAlumnoporciclo', ['alumnoid' => $alumnoid, 'cicloid' =>  $cicloid]);

                if ($ac) {
                    $nivelid = $ac->getGradoid()->getNivelid()->getNivelid();
                    $gradoid = $ac->getGradoid()->getGradoid();
                    $acid = $ac->getAlumnoporcicloid();
                    $acg = $dbm->getRepositorioById("CeAlumnocicloporgrupo", "alumnoporcicloid", $acid);
                    if ($acg) {
                        $grupoid = $acg->getGrupoid()->getGrupoid();
                    }
                }
                $periodosdeevaluacion = $dbm->BuscarPeriodosGradoCiclo(['gradoid' => $gradoid, 'cicloid' =>  $cicloid]);
                foreach ($periodosdeevaluacion as $pkey => $pe) {
                    $fechainicio = new \DateTime($pe["fechainicio"]);
                    $fechafin = new \DateTime($pe["fechafin"]);
                    $hoy = new \DateTime();
                    if ($hoy > $fechainicio && $hoy < $fechafin) {
                        $fechapublicacion = $pe["fechapublicaciondefinitiva"];
                        $fechapublicacionprevia = $pe["fechapublicacionprevia"];
                    }
                    $respuesta[$akey]["periodos"][] = $pe;

                    //$calificaciones = $dbm->BuscarCalificacionesAlumno(array("alumnoid" => $alumnoid, "periodoevaluacionid" => $pe["periodoevaluacionid"]));
                    $respuesta[$akey]["periodos"][$pkey]["calificaciones"] = $calificaciones;
                    $capturacontroller = new CapturaCalificacionesController();
                    $calif = [];
                    foreach ($calificaciones as $ckey => $calificacion) {
                        $serializer = $this->container->get('serializer');
                        $calificacion = ClasificadorAlumno::objetToArray(json_decode($serializer->serialize($calificacion, 'json')));
                        $periodo = $dbm->getRepositorioById('CeCalificacionperiodoporalumno', 'calificacionperiodoporalumnoid', $calificacion['id']);
                        $dbmC = new DbmControlescolar($this->get("db_manager")->getEntityManager());
                        $promedio = $capturacontroller->calculaCalificacionFinal([
                            'materiaid' => $calificacion["materiaid"],
                            'calificacionfinalperiodoporalumnoid' => $calificacion['calificacionfinalperiodoporalumnoid'],
                        ], $dbmC, $periodo, $hoy, $datos['tipo']);
                        $idec = $idec + $calificacion["calificacion"];
                        if ($calificacion["seimprimeenboleta"]) {
                            $sep = $sep + $calificacion["calificacion"];
                        }
                        $calificacion["calificacionfinalperiodoporalumno"]['calificacion'] = $promedio;
                        $capturas = $dbm->BuscarCapturasAlumno(array("calificacionperiodoporalumnoid" => $calificacion["id"]));

                        $faltas = $dbm->FaltasDetalle(["materiaid" => $calificacion["materiaid"], "alumnoid" => $alumnoid, "fechainicio" => $pe["fechainicio"], "fechafin" => $pe["fechafin"]]);
                        $respuesta[$akey]["periodos"][$pkey]["calificaciones"][$ckey] = $calificacion;
                        $respuesta[$akey]["periodos"][$pkey]["calificaciones"][$ckey]["detallefaltas"] = $faltas;
                        $respuesta[$akey]["periodos"][$pkey]["calificaciones"][$ckey]["capturas"] = $capturas;
                    }
                    $respuesta[$akey]["periodos"][$pkey]["idec"] = number_format($idec / count($calificaciones), 2);
                    $respuesta[$akey]["periodos"][$pkey]["sep"] = number_format($sep / count($calificaciones), 2);
                }
                $respuesta[$akey]["fechapublicacion"] = $fechapublicacion;
                $respuesta[$akey]["fechapublicacionprevia"] = $fechapublicacionprevia;
            }

            if (!$respuesta) {
                //return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
                return [];
            }
            return new View($respuesta, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
