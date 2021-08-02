<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Rest\Api;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmControlescolar;
use AppBundle\DB\DbmCobranza;
use AppBundle\Controller\lib\PDFMerger\PDFMerger;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
use AppBundle\Entity\CeCalificacionperiodoporalumno;
use AppBundle\Entity\CeCapturaCalificacionporalumno;
use AppBundle\Entity\CeCalificacionfinalperiodoporalumno;
use AppBundle\Entity\CeCapturaalumnoporperiodo;
use AppBundle\Entity\CeCapturaasistenciaalumno;
use AppBundle\Entity\CeBitacoracalificacion;
use AppBundle\Entity\CeBitacoracalificacionglobal;
use AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController;

/**
 * @author Gabriel, Rubén
 */

class CapturaCalificacionesController extends FOSRestController
{
    private static $dbm = null;
    private $DBM = false;
    private static $BITACORA = NULL;

    /**
     * Obtiene los datos del criteria de evaluacion del grupo y los datos generales del alumno y las calificaciones de este (Carga inicial de captura de calificaciones)"
     * @Rest\Get("/api/Controlescolar/CapturaCalificacion/Grupo", name="CCCapturaCalificacionGrupo")
     */
    public function CCCapturaCalificacionGrupo()
    {
        list($status, $code, $data) = self::CCCapturaCalificacionGrupoProcess($this->get("db_manager"), $_REQUEST);
        return new View($data, $code);
    }
    public static function CCCapturaCalificacionGrupoProcess($dbManager, $datos, $alumnoidr = null, $activeOverride = false)
    {
        try {
            $filtros = array_filter($datos);
            $opciones = null;
            if (!isset($filtros["configsubmateria"])) {
                $filtros["configsubmateria"] = null;
            }

            $dbm = new DbmControlescolar($dbManager->getEntityManager());

            //Obtenemos los datos principales; el profesorpormateriaplanestudio y  el periodo de evaluacion
            $pme = $dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'profesorpormateriaplanestudiosid', $filtros['profesorpormateriaplanestudiosid']);
            $periodoevaluacion = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $filtros['periodoevaluacionid']);
            if (!$pme || !$periodoevaluacion) {
                return [false, Response::HTTP_PARTIAL_CONTENT, "Faltan datos en la petición"];
            }
            $totalperiodos = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $periodoevaluacion->getConjuntoperiodoevaluacionid());
            $ultimoperiodo = end($totalperiodos);

            //Encabezado de la captura
            $datogeneral = $dbm->GetDatoGrupoCalificacion($filtros['periodoevaluacionid'], $filtros['profesorpormateriaplanestudiosid']);

            //Solo validamos si la peticion viene desde la captura de calificaciones.
            //Si la peticion viene desde calificar un examen o una tarea, omitimos la validacion de la fechas.
            if (!$filtros["novalidar"]) {
                if (!$datogeneral[0]['fechacapturacalfin']) {
                    return [false, Response::HTTP_PARTIAL_CONTENT, "El periodo no ha iniciado aun"];
                }
            }
            $filtros["fechavalidacion"] = $datogeneral[0]["fechavalidacion"];

            $materiaporplanestudio =  $dbm->getOneByParametersRepositorio(
                'CeMateriaporplanestudios',
                ["planestudioid" => explode(",", $datogeneral[0]["planestudioid"]), 'materiaid' => explode(",", $datogeneral[0]["materiaid"])]
            );
            $filtros["materiaporplanestudioid"] = $materiaporplanestudio;

            //Verificas si el nivel a consultar permite las vista de alumno en captura de calificaciones
            $datogeneral[0]["vistaalumno"] = $materiaporplanestudio->getMateriaid()->getNivelid()->getConfiguracionnivelid()->getCapturacalificacionvistaalumnos();


            //Se obtienen la ponderaciones para llenar el select en base a como se le configuro a la materia  en caso de tener select de ponderaciones
            if ($materiaporplanestudio->getComponentecurricularid()->getPonderacionid()) {
                $opciones = $dbm->getRepositoriosById("CePonderacionopcion", "ponderacionid", $materiaporplanestudio->getComponentecurricularid()->getPonderacionid()->getPonderacionid());
            }

            //Verificamos como esta configurada la materia para obtener los alumnos
            if ($materiaporplanestudio->getConfigurartaller()) {
                $filtros["taller"] = true;
                $filtros["cicloid"] = $pme->getTallerid()->getCicloid()->getCicloid();
                $filtros["grupoid"] = $pme->getTallerid()->getTallercurricularid();
                $alumno = $dbm->AlumnoCicloGrupo($filtros["cicloid"], $filtros["grupoid"], $alumnoidr, true, $activeOverride);
            } else {
                $filtros["taller"] = false;
                //Validamos si la materia esta configurada para solo calificar el ultmo parcial (solo grupos y subgrupos)
                //Entonces verificamos que el perido seleccionado sea el ultimo.
                if ($pme->getMateriaporplanestudioid()->getMateriafrecuenciacapturaid()->getMateriafrecuenciacapturaid() == 2) {
                    if ($ultimoperiodo->getPeriodoevaluacionid() != $periodoevaluacion->getPeriodoevaluacionid()) {
                        return [false, Response::HTTP_PARTIAL_CONTENT, "Solo se puede capturar en el último periodo de evaluación."];
                    }
                }
                $filtros["cicloid"] = $pme->getGrupoid()->getCicloid()->getCicloid();
                $filtros["grupoid"] = $pme->getGrupoid()->getGrupoid();
                $alumno = $dbm->AlumnoCicloGrupo($filtros["cicloid"], $filtros["grupoid"], $alumnoidr, false, $activeOverride);

                if ($materiaporplanestudio->getConfigurarsubgrupos()) {
                } else if ($materiaporplanestudio->getConfigurarsubmaterias()) {
                    //Verificamos como se hace la captura de submaterias
                    $configsubmateria = $dbm->getRepositorioById('CeFormaconfiguracionsubmateria', 'materiaporplanestudioid', $materiaporplanestudio);
                    $filtros["formaconfiguracionsubmteriaid"] = $configsubmateria->getFormaconfiguracionsubmateriaid();
                    switch ($configsubmateria->getFormacaptura()) {
                        case 1: // Como una sola materia
                            $filtros["configsubmateria"] = 1;
                            break;
                        case 2: //Por separado
                            $filtros["configsubmateria"] = 2;
                            $datogeneral[0]["materia"] = $datogeneral[0]["materia"] . ($pme->getMateriaid() ? (" - " . $pme->getMateriaid()->getNombre()) : '');
                            break;
                    }
                }
            }

            if (!$alumno) {
                return [false, Response::HTTP_PARTIAL_CONTENT, "No hay alumnos asignados a este grupo"];
            }
            //Si el perido se encuntra cerrado, validamos si hay solicitudes de ediciones extemporaneas
            $kmateria = (isset($datogeneral[0]["materiaid"]) ? $datogeneral[0]["materiaid"] : null);
            $alumnospermitidos = $dbm->ObtenerAlumnosPermitidos(array(
                "cicloid" => $filtros["cicloid"], "grupoid" => $filtros["grupoid"], "materiaid" => $kmateria, "periodoevaluacionid" => $filtros['periodoevaluacionid'],
                "profesorpormateriaplanestudiosid" => $filtros['profesorpormateriaplanestudiosid']
            ));
            $datogeneral[0]["alumnospermitidos"] = $alumnospermitidos;

            //Obtenemos los criterios 
            $criterioevaluacion = $dbm->CriteriosEvaluacionGrupo($filtros['periodoevaluacionid'], $filtros['profesorpormateriaplanestudiosid']);

            //Obtenemos la url de los servicios para cargar las fotos de los alumnos
            $url = $dbm->getRepositorioById('Parametros', 'nombre', 'URLServicios');
            $dbm->getConnection()->beginTransaction();
            foreach ($alumno as &$alum) {

                $respuesta = self::CapturaCalificacionAlumno($dbm, $pme, $periodoevaluacion, $criterioevaluacion, $alum, $filtros, $alumnospermitidos, $datogeneral[0]);

                if (!$respuesta) {
                    return [false, Response::HTTP_PARTIAL_CONTENT, "La configuración del taller no permite calificar al alumno " . $alum["nombre"] . " con matricula " . $alum["matricula"] . " "];
                }
                $alum = $respuesta;
                $alum["foto"] = $url->getValor() . '/api/Alumno/foto?alumnoid=' . $alum['alumnoid'];
            }
            $dbm->getConnection()->commit();

            $longitud = $dbm->getRepositorioById("Parametros", "nombre", "LongitudObservacion");
            $longitudAlumno = $dbm->getRepositorioById("Parametros", "nombre", "LongitudObservacionAlumno");

            return [true, Response::HTTP_OK, array(
                'arrayentidad' => $criterioevaluacion,
                'arrayalumno' => $alumno,
                'arraydato' => $datogeneral,
                'arraymateria' => $materiaporplanestudio,
                'ultimoperiodo' => $ultimoperiodo,
                'opciones' => $opciones,
                "longitud" => $longitud->getValor(),
                "longitudAlumno" => $longitudAlumno->getValor()
            )];
        } catch (\Exception $e) {
            return [false, Response::HTTP_BAD_REQUEST, $e->getMessage()];
        }
    }


    public static function CapturaCalificacionAlumno($dbm, $pme, $periodoevaluacion, $criterioevaluacion, $alum, $filtros, $alumnospermitidos = null, $datogeneral = null)
    {
        $f = 0;
        $alum["criterios"] = $criterioevaluacion;
        $alumnoporciclo = $dbm->getRepositorioById("CeAlumnoporciclo", "alumnoporcicloid", $alum['alumnoporcicloid']);
        //en caso de ser un taller se obtiene la materia correspondiente
        if ($filtros["taller"]) {
            //Los grado 5 y 6 tienen area de especializacion (areaacademica ERROR nombre en BD), para obtener el plan de estudio
            if ($alumnoporciclo->getGradoid()->getAreaacademica()) {
                $areaespecializacion = $dbm->getRepositoriosModelo(
                    "CeAlumnocicloporgrupo",
                    ["a.areaespecializacionid as id"],
                    ["alumnoporcicloid" => $alum['alumnoporcicloid']],
                    false,
                    false,
                    [
                        ["entidad" => "CeGrupo", "alias" => "g", "on" => "g.grupoid = d.grupoid and g.tipogrupoid = 1"],
                        ["entidad" => "CeAreaespecializacion", "alias" => "a", "on" => "g.areaespecializacionid = a.areaespecializacionid"],
                    ]
                )[0];
                $planestudio = $dbm->PlanEstudioAlumno(["alumnoporcicloid" => $alum['alumnoporcicloid'] ,  "areaespecializacionid" => $areaespecializacion["id"]]);
                //$planestudio = $dbm->getOneByParametersRepositorio("CePlanestudios", ["gradoid" =>  $alumnoporciclo->getGradoid(), "vigente" => 1, "areaespecializacionid" => $areaespecializacion["id"]]);
            } else {
                $planestudio = $dbm->PlanEstudioAlumno(["alumnoporcicloid" => $alum['alumnoporcicloid']]);
                //$planestudio = $dbm->getOneByParametersRepositorio("CePlanestudios", ["gradoid" =>  $alumnoporciclo->getGradoid(), "vigente" => 1]);
            }
            if (!$planestudio) {
                return false;
            }
            $mp =  $dbm->getRepositoriosModelo(
                'CeGradoportallercurricular',
                ["m.materiaporplanestudioid as materiaporplanestudioid"],
                ["tallercurricularid" => $filtros["grupoid"], 'gradoid' => $alumnoporciclo->getGradoid()],
                false,
                false,
                [
                    ["entidad" => "CeMateriaporplanestudios", "alias" => "m", "on" => "d.materiaporplanestudioid = m.materiaporplanestudioid and m.planestudioid =" . $planestudio->getPlanestudioid()]
                ]
            )[0];
            $materiaporplanestudio = $dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $mp["materiaporplanestudioid"]);
            if(!$materiaporplanestudio){
                print_r(["Alumnoporciclo:"=>$alum['alumnoporcicloid'], "Taller:"=>$filtros["grupoid"], "Planestudio:"=>$planestudio->getPlanestudioid()]);
            }
            $materia = $materiaporplanestudio->getMateriaid();
        } else {
            $materiaporplanestudio = $filtros["materiaporplanestudioid"];
            $materia = $materiaporplanestudio->getMateriaid();
        }

        $pe = $materiaporplanestudio->getPlanestudioid();
        //Obtenemos las calificaciones del periodo que se esta consultando
        $calperiodo = $dbm->getOneByParametersRepositorio("CeCalificacionperiodoporalumno", ["periodoevaluacionid" => $filtros['periodoevaluacionid'], "alumnoporcicloid" => $alum["alumnoporcicloid"], 'materiaporplanestudioid' => $materiaporplanestudio]);

        //Si existe verificamos que tenga el mismo profesorpormateriaplanestudio, si no para cambiarselo (cambio de grupo)
        if ($calperiodo) {
            if ($filtros["configsubmateria"] != 2 && $calperiodo->getProfesorpormateriaplanestudioid()->getProfesorpormateriaplanestudiosid() != $filtros['profesorpormateriaplanestudiosid']) {
                $calperiodo->setProfesorpormateriaplanestudioid($pme);
                $dbm->saveRepositorio($calperiodo);
            }

            //verificamos si existen alumnos en edición extemporanea
            if(count($alumnospermitidos) > 0) {
                //verificamos si el alumno actual existe entre los alumnos con edición extemporanea
                foreach($alumnospermitidos as $aluextem) {
                    if($aluextem['alumnoid'] == $alum['alumnoid'] ) {
                        $recalcularalumno = true;
                    }
                }
                //Si existe recalculamos sus calificaciones
                if($recalcularalumno && $alum['estatusalumnocicloid'] != "3" ) {
                    self::re_calcularCalificacionesAlumno($dbm, $alum, $pme, $periodoevaluacion->getPeriodoevaluacionid());
                }
            } else {
                //Si no existen alumnos recalculamos las calificaciones del alumno
                if($alum['estatusalumnocicloid'] != "3" && ($datogeneral && $datogeneral['fechavalidacion'] != "0")) {
                    self::re_calcularCalificacionesAlumno($dbm, $alum, $pme, $periodoevaluacion->getPeriodoevaluacionid());
                }
            }
    

        } else { //Si no existe una calificacion del periodo se crea
            //Buscamos si ya existen otros periodos para obtener el registro de calificacion final
            $calificacionesperiodos = $dbm->getOneByParametersRepositorio("CeCalificacionperiodoporalumno", ["alumnoporcicloid" => $alum["alumnoporcicloid"], 'materiaporplanestudioid' => $materiaporplanestudio]);
            //Calificacion del promedio de todos los periods, se crea en el primer periodo, en los siguiente se usa el mismo
            if ($calificacionesperiodos) {
                $cfpa = $calificacionesperiodos->getCalificacionfinalporperiodoalumno();
            } else {
                $cfpa = new CeCalificacionfinalperiodoporalumno();
                $dbm->saveRepositorio($cfpa);
            }

            $calperiodo = new CeCalificacionperiodoporalumno();
            $calperiodo->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $alum["alumnoid"]));
            $calperiodo->setAlumnoporcicloid($alumnoporciclo);
            $calperiodo->setProfesorpormateriaplanestudioid($filtros["configsubmateria"] == 2 ? null : $pme);
            $calperiodo->setPeriodoevaluacionid($periodoevaluacion);
            $calperiodo->setCalificacionfinalporperiodoalumno($cfpa);
            $calperiodo->setMateriaporplanestudioid($materiaporplanestudio);
            $calperiodo->setMateriaid($materia);
            $dbm->saveRepositorio($calperiodo);
        }
        //omitimos la creacion de criterios si es submateria
        if (!isset($filtros["formaconfiguracionsubmteriaid"])) {
            //Con los criterios verificamos si ya existe un registros por alumno y criterio, de lo contario se crea
            for ($i = 0; $i < count($criterioevaluacion); $i++) {
                $criterioevaluacionaux = $dbm->getRepositorioById("CeCriterioevaluaciongrupo", "criterioevaluaciongrupoid", $alum["criterios"][$i]["criterioevaluaciongrupoid"]);
                $alum["criterios"][$i]["calificacioncaptura"] = array();
                for ($k = 0; $k < $alum["criterios"][$i]["capturas"]; $k++) {
                    $calificacioncaptura = $dbm->getOneByParametersRepositorio("CeCapturacalificacionporalumno", array("criterioevaluaciongrupoid" => $alum["criterios"][$i]["criterioevaluaciongrupoid"], "numerocaptura" => ($k + 1), "calificacionperiodoporalumnoid" => $calperiodo->getCalificacionperiodoporalumnoid()));
                    if (!$calificacioncaptura) {
                        $calificacioncaptura = new CeCapturaCalificacionporalumno();
                        $calificacioncaptura->setNumerocaptura($k + 1);
                        $calificacioncaptura->setCalificacionperiodoporalumnoid($calperiodo);
                        $calificacioncaptura->setCriterioevaluaciongrupoid($criterioevaluacionaux);
                        $dbm->saveRepositorio($calificacioncaptura);
                    }
                    $calificacioncaptura = $dbm->CapturaCalificacionDatos($calificacioncaptura->getCapturacalificacionporalumnoid());
                    array_push($alum["criterios"][$i]["calificacioncaptura"], $calificacioncaptura[0]);
                }
            }
        }



        $alum["submaterias"] = array();
        //Si se configuro como submateria obtenemos todas las materia relacionadas a la padre configuradas en el plan de estudios
        if (isset($filtros["formaconfiguracionsubmteriaid"])) {
            switch ($filtros["configsubmateria"]) {
                case 1: // Como una sola materia
                    $configuracionsubmaterias = $dbm->getRepositoriosById("CeConfiguracionsubmaterias", "formaconfiguracionsubmateriaid", $filtros["formaconfiguracionsubmteriaid"]);
                    break;
                case 2: //Por separado
                    $configuracionsubmaterias = $dbm->getByParametersRepositorios("CeConfiguracionsubmaterias", ["formaconfiguracionsubmateriaid" => $filtros["formaconfiguracionsubmteriaid"], "materiaid" => $pme->getMateriaid()]);
                    break;
            }
            $obj = [
                "cicloid" => $filtros['cicloid'],
                "gradoid" => $filtros['gradoid'] ? $filtros['gradoid'] : $alum['gradoid'],
                "periodoevaluacionid" => $filtros['periodoevaluacionid'],
                "planestudioid" => $pe->getPlanestudioid(),
                "materiaporplanestudioid" => $materiaporplanestudio->getMateriaporplanestudioid()
            ];

            $resp = $dbm->ComentarioPonderacionMateria($obj);
            if($resp) {
                
                foreach ($configuracionsubmaterias as $key => $cs) {
                    $subid = $cs->getMateriaid();
                    $obj = [
                        "cicloid" => $filtros['cicloid'],
                        "gradoid" => $filtros['gradoid'] ? $filtros['gradoid'] : $alum['gradoid'],
                        "periodoevaluacionid" => $filtros['periodoevaluacionid'],
                        "planestudioid" => $pe->getPlanestudioid(),
                        "materiaporplanestudioid" => $materiaporplanestudio->getMateriaporplanestudioid(),
                        "materiaid" => $subid->getMateriaid()
                    ];
                    $findsubmateria = $dbm->ComentarioPonderacionMateria($obj);
                    if($findsubmateria) {
                        $arrtemp[] = $cs;
                    }
                }
                $configuracionsubmaterias = $arrtemp;
            }
            foreach ($configuracionsubmaterias as $key => $configsub) {
                $sub = $configsub->getMateriaid();
                //Buscamos el registro de la calificacion a la submateria
                $calperiodosub = $dbm->getOneByParametersRepositorio("CeCalificacionperiodoporalumno", array("periodoevaluacionid" => $filtros['periodoevaluacionid'], "alumnoid" => $alum["alumnoid"], "materiaid" => $sub->getMateriaid()));

                //Si no existe el registro de calificacion, lo creamos
                if (!$calperiodosub) {
                    $calperiodosub = new CeCalificacionperiodoporalumno();
                    $calperiodosub->setPeriodoevaluacionid($periodoevaluacion);
                    $calperiodosub->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $alum["alumnoid"]));
                    $calperiodosub->setMateriaporplanestudioid($materiaporplanestudio);
                    $calperiodosub->setAlumnoporcicloid($alumnoporciclo);
                    $calperiodosub->setProfesorpormateriaplanestudioid($pme);
                    $calperiodosub->setMateriaid($sub);
                    $calperiodosub->setMateriapadrecalificacionperiodoporalumnoid($calperiodo);
                    $dbm->saveRepositorio($calperiodosub);
                }

                $criteriossub = $criterioevaluacion;
                foreach ($criterioevaluacion as $q => $criterio) {
                    for ($k = 0; $k < $criterio["capturas"]; $k++) {
                        $calificacioncapturasub = $dbm->getOneByParametersRepositorio("CeCapturacalificacionporalumno", array("criterioevaluaciongrupoid" => $criterio["criterioevaluaciongrupoid"], "numerocaptura" => ($k + 1), "calificacionperiodoporalumnoid" => $calperiodosub->getCalificacionperiodoporalumnoid()));
                        if (!$calificacioncapturasub) {
                            $calificacioncapturasub = new CeCapturaCalificacionporalumno();
                            $calificacioncapturasub->setNumerocaptura($k + 1);
                            $calificacioncapturasub->setCalificacionperiodoporalumnoid($calperiodosub);
                            $calificacioncapturasub->setCriterioevaluaciongrupoid($dbm->getRepositorioById("CeCriterioevaluaciongrupo", "criterioevaluaciongrupoid", $criterio["criterioevaluaciongrupoid"]));
                            $dbm->saveRepositorio($calificacioncapturasub);
                        }
                        $calificacioncapturasub = $dbm->CapturaCalificacionDatos($calificacioncapturasub->getCapturacalificacionporalumnoid());
                        $criteriossub[$q]["calificacioncaptura"][] = $calificacioncapturasub[0];
                        $alum["criterios"][$q]["calificacioncaptura"][] = $calificacioncapturasub[0];
                    }
                }

                
                $arreglo["criterios"] = $criteriossub;

                $arreglo["materiaid"] = $sub->getMateriaid();
                $arreglo["nombre"] = $sub->getNombre();
                $arreglo["calificacionperiodo"] = $dbm->getRepositoriosModelo(
                    "CeCalificacionperiodoporalumno",
                    ["d.calificacionperiodoporalumnoid", "d.calificacion as calificacionperiodo, IDENTITY(d.profesorpormateriaplanestudioid), d.calificacionantesredondeo, d.observacion, po.ponderacionopcionid as opcionperiodo,cfa.calificacion as calificacionfinal, pon.ponderacionopcionid as opcionfinal"],
                    ["periodoevaluacionid" => $filtros['periodoevaluacionid'], "alumnoporcicloid" => $alum["alumnoporcicloid"], 'materiaid' => $sub->getMateriaid()],
                    false,
                    false,
                    [
                        ["entidad" => "CePonderacionopcion", "alias" => "po", "on" => "po.ponderacionopcionid = d.ponderacionopcionid", "left" => true], ["entidad" => "CeCalificacionfinalperiodoporalumno", "alias" => "cfa", "on" => "cfa.calificacionfinalperiodoporalumnoid = d.calificacionfinalporperiodoalumno", "left" => true],
                        ["entidad" => "CePonderacionopcion", "alias" => "pon", "on" => "pon.ponderacionopcionid = cfa.ponderacionopcionid", "left" => true]
                    ]
                );

                if ($filtros["configsubmateria"] == 1) {
                    $alum["submaterias"][$key] = $arreglo;
                } else {
                    $calificacionperiodo = $arreglo["calificacionperiodo"][0];
                }
            }
        }



        //Obtenemos la calificacion del periodo y le seteamos el valor del promedio de todos los periodos y lo colocamos en el array de alumnos
        if(!$configuracionsubmaterias || $filtros["configsubmateria"] == 1) {
            $calificacionperiodo = $dbm->getRepositoriosModelo(
                "CeCalificacionperiodoporalumno",
                ["d.calificacionperiodoporalumnoid", "d.calificacion as calificacionperiodo, d.calificacionantesredondeo, d.observacion, po.ponderacionopcionid as opcionperiodo, pof.ponderacionopcionid as opcionfinal,cfp.calificacionfinalperiodoporalumnoid,cfp.calificacion as calificacionfinal"],
                ["periodoevaluacionid" => $filtros['periodoevaluacionid'], "alumnoporcicloid" => $alum["alumnoporcicloid"], 'materiaporplanestudioid' => $materiaporplanestudio->getMateriaporplanestudioid()],
                false,
                false,
                [
                    ["entidad" => "CePonderacionopcion", "alias" => "po", "on" => "po.ponderacionopcionid = d.ponderacionopcionid", "left" => true],
                    ["entidad" => "CeCalificacionfinalperiodoporalumno", "alias" => "cfp", "on" => "cfp.calificacionfinalperiodoporalumnoid = d.calificacionfinalporperiodoalumno", "left" => true],
                    ["entidad" => "CePonderacionopcion", "alias" => "pof", "on" => "pof.ponderacionopcionid = cfp.ponderacionopcionid", "left" => true]
                ]
            )[0];
        }

        $alum["calificacionperiodo"][] = $calificacionperiodo;
        $filtrosfaltas = array(
            "profesorpormateriaplanestudiosid" => $pme->getProfesorpormateriaplanestudiosid(),
            "alumnoporcicloid" => $alum['alumnoporcicloid'],
            "fechainicio" => $periodoevaluacion->getFechainicio(),
            "fechafin" => $periodoevaluacion->getFechafin()
        );

            $periodo = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $filtros['periodoevaluacionid']);
            $fechai = $periodo->getFechainicio()->format("Y-m-d");
            $fechaf = $periodo->getFechafin()->format("Y-m-d");


            $totalf = $dbm->getRepositoriosModelo("CeAsistenciapordia", 
            ["d.asistenciapordiaid "], 
            [["tipoasistenciaid = 2 and d.estatusinasistenciaid = 1 and ac.alumnoporcicloid = " . $filtrosfaltas['alumnoporcicloid'] . " AND d.fecha between '" . $fechai ."' AND '" . $fechaf . "'"]], false, true, [
                ["entidad" => "CeAlumnoporciclo", "alias" => "ac", "left" => false, "on" => "ac.alumnoporcicloid = d.alumnoporcicloid"],

            ]);

            $totalret = $dbm->getRepositoriosModelo("CeAsistenciapordia", 
            ["d.asistenciapordiaid "], 
            [["tipoasistenciaid = 3 and d.estatusinasistenciaid = 1 and ac.alumnoporcicloid = " . $filtrosfaltas['alumnoporcicloid'] . " AND d.fecha between '" . $fechai ."' AND '" . $fechaf . "'"]], false, true, [
                ["entidad" => "CeAlumnoporciclo", "alias" => "ac", "left" => false, "on" => "ac.alumnoporcicloid = d.alumnoporcicloid"],

            ]);

            $totalsus = $dbm->getRepositoriosModelo("CeAsistenciapordia", 
            ["d.asistenciapordiaid "], 
            [["tipoasistenciaid = 4 and d.estatusinasistenciaid = 1 and ac.alumnoporcicloid = " . $filtrosfaltas['alumnoporcicloid'] . " AND d.fecha between '" . $fechai ."' AND '" . $fechaf . "'"]], false, true, [
                ["entidad" => "CeAlumnoporciclo", "alias" => "ac", "left" => false, "on" => "ac.alumnoporcicloid = d.alumnoporcicloid"],

            ]);

            $totalfdiaria = $dbm->getRepositoriosModelo("CeCapturaalumnoporperiodo", 
            ["SUM(d.asistencia) as totalasis"], 
            [["capturaalumnoporperiodoid is not null and d.alumnoporcicloid = " . $filtrosfaltas['alumnoporcicloid']. " and d.periodoevaluacionid = " . $filtros['periodoevaluacionid']]], false, true, [

            ])[0];

            $datafaltas = $dbm->FaltasRetardosAlumno($filtrosfaltas);
            $fasis = $datafaltas[0]['totalfaltas'] ? $datafaltas[0]['totalfaltas'] : '0';
            $fret = $datafaltas[0]['totalretardos'] ? $datafaltas[0]['totalretardos'] : '0';
            
            $ret = count($totalret);
            $ret = $ret + intval($fret);

            $sus = count($totalsus);

            $f = count($totalf);
            $f = $f + intval($totalfdiaria['totalasis']);
            $f = $f + intval($fasis);

            $alum['totalfaltas'] = $f;
            $str = $str . $f . ' FALTAS VIGENTES <br>';
            if($ret > 0) {
                $str = $str . $ret . ' RETARDOS VIGENTES <br>';
            }
            if($sus > 0) {
                $str = $str . $sus . ' SUSPENSIONES VIGENTES <br>';
            }
            $alum['detallefaltas'] = $str . $datafaltas['detalle']; 
            $alum['totalfaltas'] = $f; 
        


        return $alum;
    }

    /**
     * Obtiene las calificaciones de un alumno para la vista de alumno en captura de calificaciones
     * @Rest\Get("/api/Controlescolar/CapturaCalificacion/Alumno", name="CCCapturaCalificacionAlumno")
     */
    public function CCCapturaCalificacionAlumno()
    {
        $filtros = $_REQUEST;
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $entidad = CapturaCalificacionesController::CCCapturaCalificacionAlumnoProcess($filtros, $dbm);
        if (!$entidad) {
            return new View("Error interno", Response::HTTP_BAD_REQUEST);
        } else {
            return new View($entidad, Response::HTTP_OK);
        }
    }

    public static function CCCapturaCalificacionAlumnoProcess($filtros, $dbm)
    {
        try {
            $permiso = $filtros["permiso"] == "true";
            $titular = false;
            if (!$permiso) {
                $usuario = $dbm->getRepositorioById("Usuario", "usuarioid", $filtros['permiso']);
                if (!$usuario->getProfesorid()) {
                    return [false, Response::HTTP_PARTIAL_CONTENT, "El usuario no tiene el permiso y no es un profesor"];
                }
                $profesorid = $usuario->getProfesorid()->getProfesorid();
            } else {
                $titular = true;
            }

            $periodoevaluacion = $dbm->getRepositorioById("CePeriodoevaluacion", "periodoevaluacionid", $filtros['periodoevaluacionid']);
            $totalperiodos = $dbm->getRepositoriosById("CePeriodoevaluacion", "conjuntoperiodoevaluacionid", $periodoevaluacion->getConjuntoperiodoevaluacionid());
            $ultimoperiodo = end($totalperiodos);

            $alumno = $dbm->BuscarAlumnosA(['alumnoid' => $filtros["alumnoid"], 'cicloid' => $periodoevaluacion->getConjuntoperiodoevaluacionid()->getCicloid()->getCicloid()])[0];

            $datogeneral = $dbm->GetDatoGrupoCalificacion($filtros['periodoevaluacionid'], $filtros['profesorpormateriaplanestudiosid']);

            $planestudio = $dbm->getOneByParametersRepositorio("CePlanestudios", array("gradoid" => $alumno["gradoid"], "planestudioid" => explode(",", $datogeneral[0]["planestudioid"])));
            $materiasproplanestudio = $dbm->getRepositoriosById("CeMateriaporplanestudios", "planestudioid", $planestudio, 'ordeninterno');

            $dbm->getConnection()->beginTransaction();
            //Buscamos la captura de observaciones y asistencia general del periodo
            $capturaperiodo = $dbm->getOneByParametersRepositorio("CeCapturaalumnoporperiodo", array("alumnoporcicloid" => $alumno["alumnoporcicloid"], "periodoevaluacionid" => $filtros['periodoevaluacionid']));
            $capturaperiododetalle = null;
            if (!$capturaperiodo) {
                $capturaperiodo = new CeCapturaalumnoporperiodo();
                $capturaperiodo->setAlumnoporcicloid($dbm->getRepositorioById("CeAlumnoporciclo", "alumnoporcicloid", $alumno["alumnoporcicloid"]));
                $capturaperiodo->setPeriodoevaluacionid($periodoevaluacion);
                $dbm->saveRepositorio($capturaperiodo);
            } else {
                $asistenciadetalle = $dbm->getRepositoriosModelo("CeCapturaasistenciaalumno", ["d.asistencia"], ["capturaalumnoporperiodoid" => $capturaperiodo->getCapturaalumnoporperiodoid()], ["capturaasistenciaalumnoid" => "ASC"]);
                $capturaperiododetalle = ($asistenciadetalle && !empty($asistenciadetalle) ? $asistenciadetalle : null);
            }
            foreach ($materiasproplanestudio as $mp) {
                $filtros["materiaporplanestudioid"] = $mp;
                $filtros["formaconfiguracionsubmteriaid"] = null;
                $filtros["configsubmateria"] = null;
                $filtros["profesorpormateriaplanestudiosid"] = null;

                if ($mp->getConfigurartaller()) {
                    $filtros["taller"] = true;
                    $taller = $dbm->getRepositoriosModelo(
                        "CeGradoportallercurricular",
                        ["t.tallercurricularid"],
                        [["materiaporplanestudioid = " . $mp->getMateriaporplanestudioid() . " and a.vigente = 1 and a.alumnoporcicloid = " . $alumno["alumnoporcicloid"]]],
                        false,
                        true,
                        [
                            ["entidad" => "CeAlumnocicloportaller", "alias" => "a", "on" => "a.tallercurricularid = d.tallercurricularid", "left" => false], ["entidad" => "CeTallercurricular", "alias" => "t", "on" => "t.tallercurricularid = d.tallercurricularid", "left" => false]
                        ]
                    )[0];
                    if (!$taller) {
                        //El alumno no se a asignado a ningun taller
                        continue;
                    }
                    $pme = $dbm->getRepositoriosById('CeProfesorpormateriaplanestudios', 'tallerid', $taller["tallercurricularid"]);
                    if (!$pme) {
                        //No se ha relacionado ningun profesor a la materia
                        continue;
                    }
                } else {
                    $filtros["taller"] = false;
                    if ($mp->getConfigurarsubgrupos()) {
                        $subgrupos = $dbm->getRepositoriosModelo(
                            "CeAlumnocicloporgrupo",
                            ["GroupConcat(g.grupoid) as gradoid"],
                            ["alumnoporcicloid" => $alumno['alumnoporcicloid']],
                            false,
                            false,
                            [
                                ["entidad" => "CeGrupo", "alias" => "g", "on" => "g.grupoid = d.grupoid", "left" => false]
                            ]
                        )[0];
                        $pme = $dbm->getByParametersRepositorios('CeProfesorpormateriaplanestudios', [
                            'grupoid' => explode(",", $subgrupos["gradoid"]),
                            "materiaporplanestudioid" => $mp->getMateriaporplanestudioid()
                        ]);
                    } else {
                        if ($mp->getConfigurarsubmaterias()) {
                            //Verificamos como se hace la captura de submaterias
                            $configsubmateria = $dbm->getRepositorioById('CeFormaconfiguracionsubmateria', 'materiaporplanestudioid', $mp);
                            $filtros["formaconfiguracionsubmteriaid"] = $configsubmateria->getFormaconfiguracionsubmateriaid();
                            switch ($configsubmateria->getFormacaptura()) {
                                case 1: // Como una sola materia
                                    $filtros["configsubmateria"] = 1;
                                    break;
                                case 2: //Por separado
                                    $filtros["configsubmateria"] = 2;
                                    //$mp->getMateriaid()->setNombre($mp->getMateriaid()->getNombre() . ($pme->getMateriaid() ? (" - " . $pme->getMateriaid()->getNombre()) : ''));
                                    break;
                            }
                        }
                        $pme = $dbm->getByParametersRepositorios('CeProfesorpormateriaplanestudios', [
                            'grupoid' => $alumno["grupoid"],
                            "materiaporplanestudioid" => $mp->getMateriaporplanestudioid()
                        ]);
                    }

                    if (!$pme) {
                        //No se ha relacionado ningun profesor a la materia
                        continue;
                    }


                    //Validamos si la materia esta configurada para solo calificar el ultmo parcial (solo grupos y subgrupos)
                    //Entonces verificamos que el perido seleccionado sea el ultimo.
                    if ($mp->getMateriafrecuenciacapturaid()->getMateriafrecuenciacapturaid() == 2) {
                        if ($ultimoperiodo->getPeriodoevaluacionid() != $periodoevaluacion->getPeriodoevaluacionid()) {
                            continue;
                            //return [false, Response::HTTP_PARTIAL_CONTENT, "Solo se puede capturar en el último periodo de evaluación."];
                        }
                    }
                }

                foreach ($pme as $p) {
                    $nombre = null;
                    if ($filtros["configsubmateria"] == 2) {
                        $nombre = $mp->getMateriaid()->getNombre() . ($p->getMateriaid() ? (" - " . $p->getMateriaid()->getNombre()) : '');
                    } else {
                        $nombre = $mp->getMateriaid()->getNombre();
                    }
                    if ($filtros["taller"]) {
                        $filtros["cicloid"] = $p->getTallerid()->getCicloid()->getCicloid();
                        $filtros["grupoid"] = $p->getTallerid()->getTallercurricularid();
                    } else {
                        $filtros["cicloid"] = $p->getGrupoid()->getCicloid()->getCicloid();
                        $filtros["grupoid"] = $p->getGrupoid()->getGrupoid();
                    }
                    $filtros["profesorpormateriaplanestudiosid"] = $p->getProfesorpormateriaplanestudiosid();

                    //verificamos que el usuario tenga acceso a la materia
                    if (!$permiso) {
                        $acceso = false;
                        if ($p->getProfesorid()) {
                            $acceso = $p->getProfesorid()->getProfesorid() == $profesorid ? true : $acceso;
                            $titular = $p->getProfesorid()->getProfesorid() == $profesorid ? true : $titular;
                        }
                        if ($p->getCotitularid()) {
                            $acceso = $p->getCotitularid()->getProfesorid() == $profesorid ? true : $acceso;
                        }
                        if ($p->getSuplenteid()) {
                            $acceso = $p->getSuplenteid()->getProfesorid() == $profesorid ? true : $acceso;
                            $titular = $p->getSuplenteid()->getProfesorid() == $profesorid ? true : $titular;
                        }
                        if (!$acceso) {
                            continue;
                        }
                    }

                    //Obtenemos los criterios 
                    $criterioevaluacion = $dbm->CriteriosEvaluacionGrupo($filtros['periodoevaluacionid'], $filtros['profesorpormateriaplanestudiosid']);
                    $c = self::CapturaCalificacionAlumno($dbm, $p, $periodoevaluacion, $criterioevaluacion, $alumno, $filtros, null, $datogeneral[0]);
                    if ($mp->getComponentecurricularid()->getPonderacionid()) {
                        $opciones = $dbm->getRepositoriosById("CePonderacionopcion", "ponderacionid", $mp->getComponentecurricularid()->getPonderacionid()->getPonderacionid());
                    }

                    $filtrosfaltas = array(
                        "profesorpormateriaplanestudiosid" => $p->getProfesorpormateriaplanestudiosid(),
                        "alumnoporcicloid" => $alumno['alumnoporcicloid'],
                        "fechainicio" => $periodoevaluacion->getFechainicio(),
                        "fechafin" => $periodoevaluacion->getFechafin()
                    );
                    $datafaltas = $dbm->FaltasRetardosAlumno($filtrosfaltas);
                    $alum['detallefaltas'] = $datafaltas[0]['detalle'];
                    $alum['totalfaltas'] = $datafaltas[0]['totalfaltas'] ? $datafaltas[0]['totalfaltas'] : '0';
            

                    $materias[] = ["detallefaltas" => $alum['detallefaltas'], "totalfaltas" => $alum['totalfaltas'], "materiaplanestudio" =>  $mp, "nombremateria" => $nombre, "opciones" => $opciones, "criterios" => $c["criterios"], "calificacionperiodo" => $c["calificacionperiodo"][0], "submaterias" => $c["submaterias"]];
                }
            }
            $dbm->getConnection()->commit();

            $entidad = array('arraymateria' => $materias, "titular" => $titular, 'capturaperiodo' => $capturaperiodo, 'capturaperiododetalle' => $capturaperiododetalle);
            return $entidad;
        } catch (\Exception $e) {
        }
        return null;
    }


    /**
     * Obtiene los datos del criteria de evaluacion del grupo y los datos generales del alumno y las calificaciones de este (Carga inicial de captura de calificaciones)"
     * @Rest\Post("/api/Controlescolar/CapturaCalificacion/Descargar", name="CapturaCalificacionDescargar")
     */
    public function CapturaCalificacionDescargar()
    {
        $dbmi = $this->get("db_manager");
        $dbm = new DbmControlescolar($dbmi->getEntityManager());
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        //$dataRaw=json_decode('',true);
        //*
        $decoded["showAsistencias"] = ($decoded["showAsistencias"] == true ? "true" : "false");
        $dataRaw = self::CCCapturaCalificacionGrupoProcess($dbmi, $decoded);
        $dataarray = &$dataRaw[2];
        $dataarray["arraydato"] = $dataarray["arraydato"][0];

        $ultimoperiodo = $dataarray["ultimoperiodo"];
        $conjuntope = $ultimoperiodo->getConjuntoperiodoevaluacionid();
        $ciclo = $conjuntope->getCicloid();

        $arraymateria = $dataarray["arraymateria"];
        $planestudio = $arraymateria->getPlanestudioid();
        $grado = $planestudio->getGradoid();
        $nivel = $grado->getNivelid();

        $omateria = $arraymateria->getMateriaid();
        $omateriaid = $omateria->getMateriaid();
        $omaterianame = $omateria->getNombre();

        $arraydato = &$dataarray["arraydato"];
        $arraydato["ciclo"] = $ciclo->getNombre();
        $arraydato["nivel"] = $nivel->getNombre();
        $arraydato["grado"] = $grado->getGrado();
        $arraydato["planestudio"] = $planestudio->getNombre();
        unset($dataarray["arraymateria"]);
        unset($dataarray["ultimoperiodo"]);
        //echo json_encode($dataRaw);exit;
        //*/
        list($status, $code, $data) = $dataRaw;
        $header = $data["arraydato"];
        $alumnos = $data["arrayalumno"];
        $jtable = [];

        foreach ($alumnos as $ialumno) {
            $ialumnonum = "" . $ialumno['numerolista'];
            $ialumnoname = $ialumno['nombre'];
            $irowname = $ialumnonum . " - " . $ialumnoname;
            $iacalperiodo = $ialumno['calificacionperiodo'][0];
            $iscoreperiodo = $iacalperiodo['calificacionperiodo'];
            $iscoreaperiodo = $iacalperiodo['calificacionantesredondeo'];
            $iscoreperiodof = $iacalperiodo['calificacionfinal'];
            $iponderacionraw = $iacalperiodo['opcionperiodo']; //Ponderacion periodo
            $iponderacionfraw = $iacalperiodo['opcionfinal']; //Ponderacion final

            $iaponderacionraw = (!$iponderacionraw || is_array($iponderacionraw) || empty($iponderacionraw)
                ? null : $dbm->getPonderacionopcionById($iponderacionraw));
            $iaponderacionfraw = (!$iponderacionfraw || is_array($iponderacionfraw) || empty($iponderacionfraw)
                ? null : $dbm->getPonderacionopcionById($iponderacionfraw));

            $iaponderacion = ($iaponderacionraw ? $iaponderacionraw['opcion'] : null);
            $iaponderacionf = ($iaponderacionfraw ? $iaponderacionfraw['opcion'] : null);

            $isubmaterias = (isset($ialumno['submaterias']) && !empty($ialumno['submaterias'])
                ? $ialumno['submaterias'] : null);
            $imaterias = $isubmaterias;
            if (!$isubmaterias) {
                $ialumno['materiaid'] = $omateriaid;
                $ialumno['nombre'] = $omaterianame;
                $imaterias = [$ialumno];
            }
            $imi = 0;
            foreach ($imaterias as $imateria) {
                $imaterianame = $imateria["nombre"];
                $irow1name = $imaterianame; //($isubmaterias ? $imaterianame : "");
                $jtable[] = $this->buildJTableCell("Matrícula", $irowname, $irow1name, $ialumno['matricula']);
                $icriterios = $imateria['criterios'];
                $imcalperiodo = $imateria['calificacionperiodo'][0];
                foreach ($icriterios as $icriterio) {
                    $icapturas = $icriterio['calificacioncaptura'];
                    $icriterioname = $icriterio['aspecto'];
                    $icriteriodata = $icriterio['porcentajecalificacion'] . "% 0 a " . $icriterio['puntajemaximo'];
                    $totalCapturas = 0;
                    foreach ($icapturas as $icaptura) {
                        $totalCapturas = $totalCapturas + $icaptura['calificacion'];
                        $jtable[] = $this->buildJTableCell($icriterioname, $irowname, $irow1name, $icaptura['calificacion'], $icriteriodata, "" . $icaptura['numerocaptura']);
                    }

                    $jtable[] = $this->buildJTableCell("Promedio " . $icriterioname, $irowname, $irow1name, ($totalCapturas/count($icapturas)), "", "");
                    $jtable[] = $this->buildJTableCell("Porcentaje " . $icriterioname, $irowname, $irow1name, ((($totalCapturas/count($icapturas))*$icriterio['porcentajecalificacion'])/$icriterio['puntajemaximo']), "", "");
                }
                $imponderacionraw = $imcalperiodo['opcionperiodo'];
                $imaponderacionraw = (!$imponderacionraw || is_array($imponderacionraw) || empty($imponderacionraw)
                    ? null : $dbm->getPonderacionopcionById($imponderacionraw));
                $imaponderacion = ($imaponderacionraw ? $imaponderacionraw['opcion'] : null);
                $iobservacion = (!isset($imcalperiodo['observacion']) || empty(trim($imcalperiodo['observacion']))
                    ? null : trim($imcalperiodo['observacion']));
                if ($iobservacion) {
                    $jtable[] = $this->buildJTableCell("Observaciones", $irowname, $irow1name, $iobservacion);
                }
                if ($imaponderacion && $isubmaterias) {
                    $jtable[] = $this->buildJTableCell("Evaluacion", $irowname, $irow1name, $imaponderacion);
                }
                if($iscoreaperiodo){
                    $jtable[] = $this->buildJTableCell("Calificación antes de redondeo", $irowname, $irow1name, $iscoreaperiodo);
                }
                if ($iscoreperiodo) {
                    $jtable[] = $this->buildJTableCell("Calificación periodo", $irowname, $irow1name, $iscoreperiodo);
                }
                if ($iaponderacion) {
                    $jtable[] = $this->buildJTableCell("Ponderacion periodo", $irowname, $irow1name, $iaponderacion);
                }
                if ($iscoreperiodof && ENTORNO == 1) {
                    $jtable[] = $this->buildJTableCell("Calificación final", $irowname, $irow1name, $iscoreperiodof);
                }
                if ($iaponderacionf) {
                    $jtable[] = $this->buildJTableCell("Ponderacion final", $irowname, $irow1name, $iaponderacionf);
                }
                
                if($imateria["totalfaltas"]){
                    $jtable[] = $this->buildJTableCell("Faltas", $irowname, $irow1name, $imateria["totalfaltas"]);
                }else{
                    if($imi == 0){
                        $jtable[] = $this->buildJTableCell("Faltas", $irowname, $irow1name, $ialumno["totalfaltas"]);
                    }
                    
                }
                $imi++;
            }

        }
        $result = [
            "header" => $header,
            "score" => $jtable
        ];
        //echo json_encode($result);exit;


        $done = false;
        $name = "R" . rand();
        $report = "ReporteCalificacionesDetalle";
        $input = $output = "ReporteCalificacionesDetalle_$name";

        $pdf = new LDPDF($this->container, $report, $output, array('driver' => 'jsonql', 'jsonql_query' => '""', 'data_file' => $input), [], ['xlsx']);
        $inputPath = $pdf->fdb_r;
        $outputPath = $pdf->output_r;

        $resultenc = json_encode($result);
        $file = LDPDF::fileRead($inputPath);
        LDPDF::fileWrite($file, $resultenc);
        LDPDF::fileClose($file);
        $toremove = [$inputPath];

        if (!$pdf->execute()) {
            $toremove[] = $outputPath;
            $done = true;
        }

        $reporteSize = filesize($outputPath);
        $reporte = file_get_contents($outputPath);
        foreach ($toremove as $i) {
            LDPDF::fileDelete($i);
        }
        return ($done ? new Response($reporte, 200, array(
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
            'Content-Length' => $reporteSize
        )) : Api::Error(Response::HTTP_PARTIAL_CONTENT, "La impresion no esta disponible."));
    }
    private function buildJTableCell($col, $row, $row1, $val, $col1 = "", $col2 = "")
    {
        return [
            "row" => $row,
            "row1" => $row1,
            "col" => $col,
            "col1" => $col1,
            "col2" => $col2,
            "val" => $val
        ];
    }
    /**
     * Guarda la calificacion de la captura del criterio de evaluacion y la calificacion final del periodo
     * @Rest\Put("/api/Controlescolar/CapturaCalificacion", name="CCGuardarCalificacion")
     */
    public function GuardarCalificacion()
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $result = self::Calificar($datos, $dbm);
            $dbm->getConnection()->commit();
            return Api::Ok("Calificación actualizada.", $result);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            $dbm->getConnection()->commit();
        }
    }

    public static function Calificar($datos, $dbm)
    {
        //Registro del periodo a guardar
        $periodo = $dbm->getRepositorioById('CeCalificacionperiodoporalumno', 'calificacionperiodoporalumnoid', $datos['calificacionperiodoporalumnoid']);
        $pmepe = $periodo->getMateriaporplanestudioid();
        $pe = $pmepe->getPlanestudioid();

        //Iniciamos el proceso de guardar en la bitacora
        self::saveBitacoraCapturaCalificacion($dbm, 1, $datos["usuarioid"], $periodo, $datos['capturacalificacionporalumnoid']);

        //Funcion para redondear el perido
        $funcionredondeoperiodo = $pmepe->getPlanestudioid()->getTiporedondeoperiodoid()->getFuncionredondeo();
        //Funcion para redondear la calificacion final de los periodos
        $funcionredondeofinal = $pmepe->getPlanestudioid()->getTiporedondeofinalid()->getFuncionredondeo();
        //Calificacion minima a mostrar
        $calificacionminima = $pmepe->getPlanestudioid()->getCalificacionminima();
        //Indica si se muestran los select de opciones
        $mostrarcapturaopciones = $pmepe->getComponentecurricularid()->getMostrarcapturaopciones();
        if ($mostrarcapturaopciones) {
            //Indica si se debe realizar el calculo para seleccionar el select de
            $realizarpromedioponderacion = $pmepe->getComponentecurricularid()->getRealizarpromedioponderacion();
        }

        //Validamos si las calificaciones son cualitativas para no guardar la captura ya que no usan criterios
        if ($periodo->getMateriaporplanestudioid()->getComponentecurricularid()->getTipocalificacionid()->getTipocalificacionid()  == 1) {
            if ($mostrarcapturaopciones) {
                $opcionperiodo = $dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", $datos["ponderacionopcionid"]);
                $periodo->SetPonderacionopcionid($opcionperiodo);
            }

            if($periodo->getMateriaid() && $datos['isSelect'] == "true") {
                $objeto = [
                    "cicloid" => $datos['datos']['cicloid'],
                    "gradoid" => $datos['datos']['gradoid'],
                    "periodoevaluacionid" => $periodo->getPeriodoevaluacionid()->getPeriodoevaluacionid(),
                    "planestudioid" => $pe->getPlanestudioid(),
                    "materiaid" => $periodo->getMateriaid()->getMateriaid(),
                    "materiaporplanestudioid" => $pmepe->getMateriaporplanestudioid(),
                    "ponderacionopcionid" => $datos['ponderacionopcionid'],
                    "configurarcomentarios" => true
                ];
                $comentario = $dbm->ComentarioPonderacionMateria($objeto)[0];

            }
            $periodo->setObservacion($comentario && !empty($comentario['comentario']) ? $comentario['comentario'] : $datos["observacion"] );
            $dbm->saveRepositorio($periodo);
        } else {
            //Guardar captura del criterio
            $captura = $dbm->getRepositorioById('CeCapturacalificacionporalumno', 'capturacalificacionporalumnoid', $datos['capturacalificacionporalumnoid']);
            $periodo->setObservacion($datos["observacion"] ? $datos["observacion"] : null);
            $captura->setCalificacion($datos["calificacioncaptura"]);
            $dbm->saveRepositorio($captura);

            //Verificamos si la captura se refiere a una tarea para colocarle la calificacion tambien
            $tarea = $dbm->getOneByParametersRepositorio('CeTarea', [
                'criterioevaluaciongrupoid' => $captura->getCriterioevaluaciongrupoid()->getCriterioevaluaciongrupoid()
            ]);
            if ($tarea) {
                $tarealumno = $dbm->getOneByParametersRepositorio('CeTareaalumno', [
                    'alumnoid' => $periodo->getAlumnoid()->getAlumnoid(),
                    'tareaid' => $tarea->getTareaid()
                ]);
                if ($tarealumno) {
                    $tarealumno->setCalificacion($datos["calificacioncaptura"]);
                    $estatustarea = $tarea->getTipoentregaid()->getTipoentregaid();
                    if ($tarea->getTipoentregaid()->getTipoentregaid() == 2) {
                        if (!$tarealumno->getFecha()) {
                            $tarealumno->setFecha(new \DateTime());
                        }
                        $tarealumno->setEntiempo(1);
                    }
                    $dbm->saveRepositorio($tarealumno);
                }
            }

            //Obtenemos las calificaciones de los criterios del periodo
            $calificaciones = $dbm->CalculaCalificacionPeriodo($periodo);
            $calificacionperiodo = 0;
            foreach ($calificaciones as $calificacion) {
                $calificacionperiodo = $calificacionperiodo + $calificacion["calificacion"];
            }
            $periodo->setCalificacionantesredondeo($calificacionperiodo);
            //Aplicamos el redondeo y la calificacion minima, solo si no es una sub materia
            if (!$periodo->getMateriapadrecalificacionperiodoporalumnoid()) {
                //Aplicamo el redondeo a la calificacion
                $calificacionperiodooriginal = $dbm->getRoundedValueByFunctionName($funcionredondeoperiodo, $calificacionperiodo);
                //Si la calificacion obtenida es menor a la minima configurada, colocamos la minima
                if ($calificacionperiodooriginal < $calificacionminima) {
                    $calificacionperiodo = $calificacionminima;
                } else {
                    $calificacionperiodo = $calificacionperiodooriginal;
                }
            }
            //Se guarda la calificacion del periodo
            $periodo->SetCalificacion($calificacionperiodo);

            //Si se muestran los select, se realiza el calculo para asignar, d elo contrario se coloca null
            $opcionperiodo = null;
            if ($mostrarcapturaopciones) {
                $ponderacionid = $pmepe->getComponentecurricularid()->getPonderacionid()->getPonderacionid();
                if ($realizarpromedioponderacion) {
                    //obtenemos las opcion de la ponderacion
                    $opciones = $dbm->getRepositoriosById("CePonderacionopcion", "ponderacionid", $ponderacionid);
                    //Obtenemos la ponderacion que coninside con la calificacion del periodo
                    foreach ($opciones as $opcion) {
                        if ($opcion->getCalificacionminima() <= $calificacionperiodo && $opcion->getCalificacionmaxima() >= $calificacionperiodo) {
                            $opcionperiodo = $opcion;
                        }
                    }
                } else {
                    $opcionperiodo = $dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", $datos["ponderacionopcionid"]);
                }
            }
            $periodo->setPonderacionopcionid($opcionperiodo);
            $dbm->saveRepositorio($periodo);

            //Calificacion FINAL de la materia
            $calificacionfinalalumno = $periodo->getCalificacionfinalporperiodoalumno();

            //Si no tiene relacion a la calificacion final, entonces es una submateria y se debe calcular la suma de las submateria primero
            if (!$calificacionfinalalumno) {
                //Forma de calificar las submateria 
                $formaconfiguracion = $dbm->getRepositorioById("CeFormaconfiguracionsubmateria", "materiaporplanestudioid", $periodo->getMateriaporplanestudioid());

                $configuracionsubmateria = $dbm->getRepositoriosById("CeConfiguracionsubmaterias", "formaconfiguracionsubmateriaid", $formaconfiguracion);

                // 1 = Cada una tiene su porcentaje  1 != Se promedian
                $calificacionperiodo = 0;
                if ($formaconfiguracion->getFormaCalificar() == 1) {
                    foreach ($configuracionsubmateria as $s) {
                        $calsub = $dbm->getOneByParametersRepositorio('CeCalificacionperiodoporalumno', ['alumnoporcicloid' => $periodo->getAlumnoporcicloid(), "periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "materiaporplanestudioid" => $periodo->getMateriaporplanestudioid(), "materiaid" => $s->getMateriaid()]);
                        $calificacionperiodo += ($calsub->getCalificacion() * ($s->getPorcentajecalificacion() / 100));
                    }
                } else {
                    foreach ($configuracionsubmateria as $s) {
                        $calsub = $dbm->getOneByParametersRepositorio('CeCalificacionperiodoporalumno', ['alumnoporcicloid' => $periodo->getAlumnoporcicloid(), "periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "materiaporplanestudioid" => $periodo->getMateriaporplanestudioid(), "materiaid" => $s->getMateriaid()]);
                        $calificacionperiodo += $calsub->getCalificacion();
                    }
                    $calificacionperiodo = $calificacionperiodo / count($configuracionsubmateria);
                }

                //Aplicamo el redondeo a la calificacion
                $calificacionperiodooriginal = $dbm->getRoundedValueByFunctionName($funcionredondeoperiodo, $calificacionperiodo);
                //Si la calificacion obtenida es menor a la minima configurada, colocamos la minima
                if ($calificacionperiodooriginal < $calificacionminima) {
                    $calificacionperiodo = $calificacionminima;
                } else {
                    $calificacionperiodo = $calificacionperiodooriginal;
                }

                $periodo = $periodo->getMateriapadrecalificacionperiodoporalumnoid();
                $periodo->setCalificacion($calificacionperiodo);
                //Si se muestran los select
                if ($mostrarcapturaopciones) {
                    $ponderacionid = $pmepe->getComponentecurricularid()->getPonderacionid()->getPonderacionid();
                    if ($realizarpromedioponderacion) {
                        //obtenemos las opcion de la ponderacion
                        $opciones = $dbm->getRepositoriosById("CePonderacionopcion", "ponderacionid", $ponderacionid);
                        $opcionperiodo = null;
                        //Obtenemos la ponderacion que coninside con la calificacion del periodo
                        foreach ($opciones as $opcion) {
                            if ($opcion->getCalificacionminima() <= $calificacionperiodo && $opcion->getCalificacionmaxima() >= $calificacionperiodo) {
                                $opcionperiodo = $opcion;
                            }
                        }
                    } else {
                        $opcionperiodo = $dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", $datos["ponderacionopcionid"]);
                    }
                    $periodo->setPonderacionopcionid($opcionperiodo);
                }
                $dbm->saveRepositorio($periodo);
                $calificacionfinalalumno = $periodo->getCalificacionfinalporperiodoalumno();
            }
            $calificacionfpa = self::processCalificacionFinalAlumno($dbm, $periodo, $datos["ponderacionopcionid"]);
            $calificacionfinal = $calificacionfpa->getCalificacion();
            $opcionfinal = $calificacionfpa->getPonderacionopcionid();
        }
				self::updateAvancePorcentaje($dbm, $periodo);
        //Terminamos el proceso de guardar en la bitacora
        self::saveBitacoraCapturaCalificacion($dbm, 2, $datos["usuarioid"], $periodo, $datos['capturacalificacionporalumnoid']);

        return array(
            "calificacionperiodo" => $calificacionperiodo,
            "calificacionfinal" => $calificacionfinal,
            "opcionperiodo" => $opcionperiodo,
            "opcionfinal" => $opcionfinal,
            "observacion" => $periodo->getObservacion()
        );
    }

		private static function updateAvancePorcentaje($dbm, $calificacionperiodoporalumno){
			$cpalumno=$calificacionperiodoporalumno;
			$kcpalumno=$cpalumno->getCalificacionperiodoporalumnoid();
			$porcentaje=0.0;
			$capturas=$dbm->getRepositoriosModelo("CeCapturacalificacionporalumno",
				["d.calificacion"],
				["calificacionperiodoporalumnoid"=>$kcpalumno],
				false,
				false,
				[
					["entidad"=>"CeCriterioevaluaciongrupo", "alias"=>"ceceg",
						"on"=>"ceceg.criterioevaluaciongrupoid=d.criterioevaluaciongrupoid AND d.numerocaptura<=ceceg.capturas"],
					["entidad"=>"CeCalificacionperiodoporalumno", "alias"=>"cecpa",
						"on"=>"cecpa.calificacionperiodoporalumnoid=d.calificacionperiodoporalumnoid"],
					["entidad"=>"CeAlumno", "alias"=>"cea",
						"on"=>"cea.alumnoid=cecpa.alumnoid AND cea.alumnoestatusid=1"]
				]
			);
			if($capturas){
				$capsN=count($capturas);
				$capsC=0;
				foreach($capturas AS $icaptura){
					if(isset($icaptura['calificacion'])){
						$icalificacion=trim($icaptura['calificacion']);
						if($icalificacion!==""){
							$capsC++;
						}
					}
					$porcentaje=$capsC*100/$capsN;
				}
			}
			$calificacionperiodoporalumno->setAvance($porcentaje);
			try{
				$dbm->saveRepositorio($cpalumno);
			}catch(\Exception $e){
				$ttt=false;
			}
		}

    public static function processCalificacionFinalAlumno($dbm, $calificacionpa, $ponderacionopcioncapturada = null)
    {
        if ($calificacionpa) {
            $calificacionfpa = $calificacionpa->getCalificacionfinalporperiodoalumno();
            $alumnociclo = $calificacionpa->getAlumnoporcicloid();
            $periodoe = $calificacionpa->getPeriodoevaluacionid();
            $conjuntope = $periodoe->getConjuntoperiodoevaluacionid();
            $materiape = $calificacionpa->getMateriaporplanestudioid();
            $planestudio = $materiape->getPlanestudioid();
            $componentec = $materiape->getComponentecurricularid();

            $periodosr = [];
            $opcionfinal = null;
            $calificacionfinalraw = 0;
            $periodos = $dbm->getRepositoriosById('CePeriodoevaluacion', 'conjuntoperiodoevaluacionid', $conjuntope);
            $fnredondeof = $planestudio->getTiporedondeofinalid()->getFuncionredondeo();
            $calificacionmin = $planestudio->getCalificacionMinima();
            $promediable = $conjuntope->getPromediable();
            $capturaxperiodo = ($materiape->getMateriafrecuenciacapturaid()->getMateriafrecuenciacapturaid() == 1);
            $ponderacionshow = ($capturaxperiodo && $componentec->getMostrarcapturaopciones());
            $ponderacioncalc = ($ponderacionshow ? $componentec->getRealizarpromedioponderacion() : false);
            $calificacion = $calificacionpa->getCalificacion();
            foreach ($periodos as &$iperiodo) {
                $periodosr[$iperiodo->getPeriodoevaluacionid()] = &$iperiodo;
                unset($iperiodo);
            }

            if ($capturaxperiodo) { //Captura calificacion por periodo
                $calificaciones = $dbm->getRepositoriosModelo("CeCalificacionperiodoporalumno", [
                    "IDENTITY(d.profesorpormateriaplanestudioid) AS profesorpormateriaplanestudioid",
                    "IDENTITY(d.periodoevaluacionid) AS periodoevaluacionid",
                    "d.calificacion"
                ], [
                    "materiaporplanestudioid" => $materiape,
                    "alumnoporcicloid" => $alumnociclo,
                    "materiapadrecalificacionperiodoporalumnoid" => null
                ]);
                $calificacionesfill = [];
                foreach ($calificaciones as $icalificacion) {
                    $kperiodo = $icalificacion["periodoevaluacionid"];
                    $kprofesormpe = $icalificacion["profesorpormateriaplanestudioid"];
                    $iperiodo = $periodosr[$kperiodo];
                    if ($iperiodo) {
                        $icalificacionraw = $icalificacion["calificacion"];
                        $recuperaciones = $dbm->getRepositoriosModelo("CeRecuperacionperiodo", ["d.calificacion"], [
                            "alumnoporcicloid" => $alumnociclo,
                            "profesorpormateriaplanestudioid" => $kprofesormpe,
                            "periodoevaluacionid" => $kperiodo
                        ], ["intento" => "DESC"]);
                        if (!empty($recuperaciones)) {
                            $icalificacionraw = $recuperaciones[0]["calificacion"];
                        }
                        $calificacionesfill[] = [$iperiodo, $icalificacionraw];
                    }
                }
                if ($promediable) { //Si es promediable
                    foreach ($calificacionesfill as $icalificacionfill) {
                        list($iperiodo, $icalificacion) = $icalificacionfill;
                        $calificacionfinalraw += $icalificacion;
                    }
                    $calificacionfinalraw = ($calificacionfinalraw > 0 ? ($calificacionfinalraw / count($periodos)) : 0);
                } else { //Si no, entonces es por porcentaje
                    foreach ($calificacionesfill as $icalificacionfill) {
                        list($iperiodo, $icalificacion) = $icalificacionfill;
                        $calificacionfinalraw += ($icalificacion * ($iperiodo->getPorcentajeCalificacionfinal() / 100));
                    }
                }
            } else { //Captura solo calificacion final
                $calificacionfinalraw = $calificacionpa->getCalificacion();
                $opcionfinal = $calificacionpa->getPonderacionopcionid();
            }
            //Aplicamos el redondeo a la calificacion
            $calificacionfinal = $dbm->getRoundedValueByFunctionName($fnredondeof, $calificacionfinalraw);
            if ($calificacionfinal < $calificacionmin) {
                $calificacionfinal = $calificacionmin;
            }
            if ($ponderacionshow) { //Calculamos la ponderacion si esta habilitada
                if ($ponderacioncalc) {
                    $ponderacionopciones = $dbm->getRepositoriosById("CePonderacionopcion", "ponderacionid", $componentec->getPonderacionid());
                    //Obtenemos la ponderacion que coincide con la calificacion del periodo
                    foreach ($ponderacionopciones as $iponderacionopcion) {
                        if ($iponderacionopcion->getCalificacionminima() <= $calificacionfinal && $calificacionfinal <= $iponderacionopcion->getCalificacionmaxima()) {
                            $opcionfinal = $iponderacionopcion;
                        }
                    }
                } else if ($ponderacionopcioncapturada !== null) {
                    $opcionfinal = $dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", $ponderacionopcioncapturada);
                } else {
                    $opcionfinal = $calificacionfpa->getPonderacionopcionid();
                }
            }
            if ($planestudio->getGradoid()->getNivelid()->getNivelid() == 4) {
                if ($periodoe->getPeriodoevaluacionid() == end($periodos)->getPeriodoevaluacionid()) {
                    $caleval = (ENTORNO == 1 ? $planestudio->getPuntopase() : $calificacionmin + 0.001);
                    if ($calificacion < $caleval) {
                        $calificacionfinal = 5;
                    }
                }
            }
            $calificacionfpa->setCalificacion($calificacionfinal);
            $calificacionfpa->setPonderacionopcionid($opcionfinal);
            $dbm->saveRepositorio($calificacionfpa);
            return $calificacionfpa;
        }
        return null;
    }

    /**
     * Guarda opcion de ponderacion para calificacion cuando es editable
     * @Rest\Post("/api/Controlescolar/CapturaCalificacion/ActualizarOpcion", name="ActualizarOpcion")
     */
    public function ActualizarOpcion()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmControlescolar($dbm->getEntityManager());

            $Calificacionporperiodo = $dbm->getRepositorioById("CeCalificacionperiodoporalumno", "calificacionperiodoporalumnoid", $decoded["calificacionperiodoporalumnoid"]);

            //Iniciamos el proceso de guardar en la bitacora
            self::saveBitacoraCapturaCalificacion($dbm, 1, $decoded["usuarioid"], $Calificacionporperiodo);

            //Si viene el id de la calificacion final, la opcion que se actualizara es la de la opcion final
            if ($decoded["calificacionfinalperiodoporalumnoid"]) {
                $Calificacionfinal = $dbm->getRepositorioById("CeCalificacionfinalperiodoporalumno", "calificacionfinalperiodoporalumnoid", $decoded["calificacionfinalperiodoporalumnoid"]);
                $Calificacionfinal->setPonderacionOpcionId($dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", $decoded["ponderacionopcionid"]));
                $dbm->saveRepositorio($Calificacionfinal);
            } else { // Caso contrario, es la del periodo
                $Calificacionporperiodo->setPonderacionOpcionId($dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", $decoded["ponderacionopcionid"]));
                $dbm->saveRepositorio($Calificacionporperiodo);
            }

            //Terminamos el proceso de guardar en la bitacora (enviar desde el front la calificacionporperiodo cuando se califica la final)
            self::saveBitacoraCapturaCalificacion($dbm, 2, $decoded["usuarioid"], $Calificacionporperiodo);
            return new View("Se ha actualizado la opción ", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Guarda la observacion y las tareas en la vista por alumno
     * @Rest\Post("/api/Controlescolar/CapturaCalificacion/CapturaGeneral", name="ActualizarCapturaGeneral")
     */
    public function ActualizarCapturaGeneral()
    {
        try {
            $em = $this->get("db_manager")->getEntityManager();
            $dbm = new DbmControlescolar($em);
            $hydrator = new ArrayHydrator($em);
            $decoded = json_decode(trim(file_get_contents("php://input")), true);
            $kcapturaalumnoperiodo = $decoded["capturaalumnoporperiodoid"];
            $entity = $dbm->getRepositorioById("CeCapturaalumnoporperiodo", "capturaalumnoporperiodoid", $kcapturaalumnoperiodo);
            $detalleraw = $decoded["asistenciaDetail"];
            $asistencia = (int) $decoded["asistencia"];
            $dbm->getConnection()->beginTransaction();


            //Iniciamos el proceso de guardar en la bitacora
            self::saveBitacoraCapturaCalificacionGlobal($dbm, 1, $decoded["usuarioid"], $entity);

            $detalleold = $dbm->getRepositoriosById("CeCapturaasistenciaalumno", "capturaalumnoporperiodoid", $kcapturaalumnoperiodo);
            if ($detalleold) {
                foreach ($detalleold as $idetalleold) {
                    $dbm->removeRepositorio($idetalleold);
                }
            }
            if ($detalleraw && !empty($detalleraw)) {
                $asistencia = 0;
                foreach ($detalleraw as $idetalleraw) {
                    $idetalle = (int) $idetalleraw["asistencia"];
                    if ($idetalle !== $idetalle) {
                        $idetalle = 0;
                    }
                    $asistencia += $idetalle;
                    $eidetalle = new CeCapturaasistenciaalumno();
                    $eidetalle->setAsistencia($idetalle);
                    $eidetalle->setCapturaalumnoporperiodoid($entity);
                    $dbm->saveRepositorio($eidetalle);
                }
            }
            $decoded["asistencia"] = "$asistencia";
            $capturaperiodo = $hydrator->hydrate($entity, $decoded);
            $dbm->saveRepositorio($capturaperiodo);

            //Iniciamos el proceso de guardar en la bitacora
            self::saveBitacoraCapturaCalificacionGlobal($dbm, 2, $decoded["usuarioid"], $capturaperiodo);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado la opción ", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
		
		/**
		 * @Rest\Get("/api/Controlescolar/CapturaCalificacion/kardex/", name="getCCCalificacionesByAlumnoKardex")
		 */
		public function getCCCalificacionesByAlumnoKardex(){
			$dataRaw=$_REQUEST;
			$alumnosporciclo=[];
			if(empty($dataRaw['ac'])){
				return Api::Error(Response::HTTP_BAD_REQUEST, "Peticion incorrecta.");
			}
			foreach($dataRaw['ac'] AS $ialumnoporciclo){
				$ialumnoporciclo=(int)$ialumnoporciclo;
				if($ialumnoporciclo<1){
					return Api::Error(Response::HTTP_BAD_REQUEST, "Peticion incorrecta.");
				}
				$alumnosporciclo[]=$ialumnoporciclo;
			}
			$done=false;
            $tomerge=[];
            $conteo = 0;
			$toremove=[];
			$report="HistorialAcademicoKardex";
			foreach($alumnosporciclo AS $kalumnoporciclo){
                $dataRaw=CapturaCalificacionReporteController::getUltimasCalificacionesByAlumno($this->getDM(), null, ["alumnoporcicloid"=>(int) $kalumnoporciclo]);

				if($dataRaw!==false){
					$rows=[];

					foreach($dataRaw["row"] AS $irow){
						$krow=(int)$irow["id"];
						if($krow>0){
							$rows[$krow]=$irow;
						}
					}
					foreach($dataRaw["inte"] AS $idata){
						$krow=(int)$idata["row"];
						if($krow>0 && $idata["col"]=="_prma_"){
							$irow=$rows[$krow];
							$score[]=$this->getCCCalificacionesByAlumnoKardexData($rows, 1, $krow, $irow["nombre"]);
							$score[]=$this->getCCCalificacionesByAlumnoKardexData($rows, 2, $krow, $idata["data"]);
                            $score[]=$this->getCCCalificacionesByAlumnoKardexData($rows, 3, $krow, $idata["extra"] ? "Extraordinario" : "Ordinario");
                            $score[]=$this->getCCCalificacionesByAlumnoKardexData($rows, 4, $krow, $dataRaw['alumno']['ciclo']);
						}
                    }
                }
            }
            $calificaciones = array_filter($score, function ($var) {
                return ($var['colf'] == "Calificacion");
            });

            foreach ($calificaciones as $c) {
                $conteo += floatval($c['val']);
            }

            $promfinal = $conteo / count($calificaciones);
            $promfinal = number_format((float)$promfinal, 2, '.', '');  // Outputs -> 105.00

            //usort($score, "AppBundle\Controller\Controlescolar\CapturaCalificacionesController::fnOrdCCCalificacionesByAlumnoKardexData");
            $name="R".rand().rand();
            $input=$output="{$report}_$name";

            $pdf=new LDPDF($this->container, $report, $output, array('driver'=>'jsonql', 'jsonql_query'=>'""', 'data_file'=>$input));
            $inputPath=$pdf->fdb_r;
            $outputPath=$pdf->output_r;

            $resultenc=json_encode([
                    "info"=>$dataRaw["alumno"],
                    "scores"=>$score,
                    "prom" => $promfinal
                ]);
            $file=LDPDF::fileRead($inputPath);
            LDPDF::fileWrite($file, $resultenc);
            LDPDF::fileClose($file);
            unset($file);
            $toremove[]=$inputPath;
			$result=$pdf->execute();
			LDPDF::fileDelete($pdf->fdb_r);
			if(!$result){
				$content=file_get_contents($pdf->output_r);
				$size=filesize($pdf->output_r);
				LDPDF::fileDelete($pdf->output_r);
				return new Response($content, 200, array(
					'Content-Type'=>'application/pdf',
					'Content-Length'=>$size
				));
			}
		}
		private function getCCCalificacionesByAlumnoKardexData($rows, $kcol, $krow, $val){
			$cols=[
				["orden"=>0,"kind"=>"C","nombre"=>"Clave","corto"=>"Clave"],
				["orden"=>1,"kind"=>"A","nombre"=>"Asignatura","corto"=>"Asign."],
				["orden"=>2,"kind"=>"S","nombre"=>"Calificacion","corto"=>"Cal."],
                ["orden"=>3,"kind"=>"T","nombre"=>"Tipo de Evaluación","corto"=>"T.Eval."],
                ["orden"=>4,"kind"=>"CI","nombre"=>"Ciclo","corto"=>"ciclo"]
			];
			$icol=$cols[$kcol];
			$irow=$rows[$krow];
			return [
				"krow"=>$krow,
				"kcol"=>$kcol,
				"kind"=>$icol["kind"],
				"ordx"=>$irow["orden"],
				"ordy"=>$icol["orden"],
				"row"=>$irow["clave"],
				"rowf"=>$irow["clave"],
				"col"=>$icol["corto"],
				"colf"=>$icol["nombre"],
				"val"=>$val
			];
		}
		public static function fnOrdCCCalificacionesByAlumnoKardexData($a,$b){
		$result=$a['ordx']<=>$b['ordx'];
		if($result==0){
			$result=$a['ordy']<=>$b['ordy'];
		}
		return $result;
	}
		
		
    /**
     * @Rest\Get("/api/Controlescolar/CapturaCalificacion/alumno", name="getCCCalificacionesByAlumnos")
     */
    public function getCCCalificacionesByAlumnos()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if (!empty($_REQUEST['alumnoid'])) {
                $data = [];
                $bloqueo = false;
                $observaciones;
                $dbmc = new DbmCobranza($this->get("db_manager")->getEntityManager());
                foreach ($_REQUEST['alumnoid'] as $i) {
                    $alumno = $dbm->BuscarAlumnosA(['alumnoid' => $i])[0];
                    $permisos = $dbm->getRepositorioById("CeConfiguracionpantallacalificaciones", "gradoid", ($_REQUEST['gradoid'] ?$_REQUEST['gradoid'] : $alumno['gradoid'] ));
                    $bloqueo = \AppBundle\Dominio\Bloqueos::BloqueoAlumno($dbmc,array(
                        "alumnoporcicloid" => $_REQUEST['alumnoporcicloid'] ? $_REQUEST['alumnoporcicloid'] :  $alumno["alumnoporcicloid"],
                        "tipo" => 2,
                        "cicloid" => $alumno['cicloid']
                    ));

                    $bloqueos = $bloqueo['bloqueocalificacion'];
                    $observaciones = $bloqueo['observacionescalificacion'];

                    $idata = CapturaCalificacionReporteController::getUltimasCalificacionesByAlumno($this->getDM(), (int) $i, $_REQUEST);
                    if ($idata !== false) {
                        $idata['bloqueo'] = $bloqueos;
                        $idata['bloqueoadeudo'] = $bloqueo['bloqueoadeudo'];
                        $idata['observacionesadeudo'] = $bloqueo['bloqueoadeudo'] ? $bloqueo['observacionesadeudo'] : null;
                        $idata['observacionesbloqueo'] = $observaciones;
                        $idata['bloqueojunta'] = $bloqueo['bloqueojunta'];
                        $idata['observacionesjunta'] = $bloqueo['bloqueojunta'] ? $bloqueo['observacionesjunta'] : null;
                        $idata['permisos'] = $permisos;
                        $data[] = $idata;
                    }
                }
            }
            return Api::Ok(Response::HTTP_OK, $data);
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
    /**
     * @Rest\Get("/api/Controlescolar/CapturaCalificacion/alumno/{alumnoid}", name="getCCCalificacionesByAlumno")
     */
    public function getCCCalificacionesByAlumno($alumnoid)
    {
        $data = CapturaCalificacionReporteController::getUltimasCalificacionesByAlumno($this->getDM(), (int) $alumnoid, null);
        if ($data !== false) {
            return Api::Ok(Response::HTTP_OK, $data);
        }
        return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No hay datos de calificaciones de este alumno.");
    }
    /**
		* @Rest\Get("/api/Controlescolar/CapturaCalificacion/final/{alumnoporcicloid}", name="getCCCalificacionFinalByAlumnociclo")
		*/
		public function getCCCalificacionFinalByAlumnociclo($alumnoporcicloid){
		 $data=CapturaCalificacionReporteController::getPromedioFinalByAlumnociclo($this->getDM(), (int)$alumnoporcicloid);
		 if($data!==false){
			 return Api::Ok(Response::HTTP_OK, $data);
		 }
		 return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No hay datos de calificaciones de este alumno.");
		}
		public function calculaCalificacionFinal($datos, $dbm, $periodo, $hoy, $tipo)
    {
        $calificaciones = $dbm->CalculaCalificacionPeriodo($periodo);
        $calificacionperiodo = 0;

        foreach ($calificaciones as $calificacion) {
            $calificacionperiodo = $calificacionperiodo + $calificacion["calificacion"];
            $criterio = $dbm->getRepositorioById("CeCriterioevaluaciongrupo", "criterioevaluaciongrupoid", $calificacion["criterioevaluaciongrupoid"]);
            $redondeoperiodo = $criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getPlanestudioid()->getTiporedondeoperiodoid()->getTiporedondeoid();
            $funcionredondeoperiodo = $criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getPlanestudioid()->getTiporedondeoperiodoid()->getFuncionredondeo();
            $redondeofinal = $criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getPlanestudioid()->getTiporedondeofinalid()->getTiporedondeoid();
            $funcionredondeofinal = $criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getPlanestudioid()->getTiporedondeofinalid()->getFuncionredondeo();
            $calificacionminima = $criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getPlanestudioid()->getCalificacionminima();
            $mostrarcapturaopciones = $criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getComponentecurricularid()->getMostrarcapturaopciones();
            $realizarpromedioponderacion = $criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getComponentecurricularid()->getRealizarpromedioponderacion();
            if ($criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getComponentecurricularid()->getPonderacionid()) {
                $ponderacionid = $criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getComponentecurricularid()->getPonderacionid()->getPonderacionid();
            }
            $habilitarcapturaopciones = $criterio->getProfesorpormateriaplanestudiosid()->getMateriaporplanestudioid()->getComponentecurricularid()->getHabilitarcapturaopciones();
            $conjuntoperiodoevaluacionid = $periodo->getPeriodoevaluacionid()->getConjuntoperiodoevaluacionid()->getConjuntoperiodoevaluacionid();
        }
        $calificacionesperiodo = null;
        if ($datos["materiaid"]) {
            $calificacionesperiodo = $dbm->getByParametersRepositorios("CeCalificacionperiodoporalumno", array("materiaid" => $datos["materiaid"], "alumnoid" => $periodo->getAlumnoid()));
        } else {
            $calificacionesperiodo = $dbm->getByParametersRepositorios("CeCalificacionperiodoporalumno", array("materiaporplanestudioid" => $periodo->getMateriaporplanestudioid(), "alumnoid" => $periodo->getAlumnoid()));
        }
        $periodos = null;
        $calificacionfinalcalculo = 0;
        foreach ($calificacionesperiodo as $cp) {
            $ca = $cp->getCalificacion();
            $fechapublicacion = $cp->getPeriodoevaluacionid()->getFechapublicaciondefinitiva();
            $fechapublicacionprevia = $cp->getPeriodoevaluacionid()->getFechapublicacionprevia();
            if ($tipo == 4) {
                if ($hoy >= $fechapublicacion) {
                    $calificacionfinalcalculo = $calificacionfinalcalculo + $cp->getCalificacion();
                    if (!in_array($cp->getPeriodoevaluacionid(), $periodos)) {
                        $periodos[] = $cp->getPeriodoevaluacionid();
                    }
                } else {
                    $calificacionfinalcalculo = 0;
                }
            } else {
                if ($hoy > $fechapublicacionprevia || $hoy > $fechapublicacion) {
                    $calificacionfinalcalculo = $calificacionfinalcalculo + $cp->getCalificacion();
                    if (!in_array($cp->getPeriodoevaluacionid(), $periodos)) {
                        $periodos[] = $cp->getPeriodoevaluacionid();
                    }
                } else {
                    $calificacionfinalcalculo = 0;
                }
            }
        }
        if ($tipo == 4 && $calificacionfinalcalculo == 0) {
            return null;
        }
        if ($periodo->getMateriaporplanestudioid()->getMateriafrecuenciacapturaid()->getMateriafrecuenciacapturaid() == 1) {
            if ($calificacionfinalcalculo != 0 && count($periodos) != 0) {
                $calificacionfinalcalculo = $calificacionfinalcalculo / count($periodos);
            }

            $conn = $dbm->getConnection();
            $stmt = $conn->prepare("select $funcionredondeofinal($calificacionfinalcalculo) as resultado");
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            $calificacionfinalcalculo = $resultado[0]["resultado"];

            if ($calificacionfinalcalculo < $calificacionminima) {
                $calificacionfinalcalculo = $calificacionminima;
            }
        } else {
            $calificacionfinalcalculo = $calificacionfinalcalculo;
        }
        $opcionfinal = "";
        if (($mostrarcapturaopciones && !$habilitarcapturaopciones) || ($realizarpromedioponderacion && !$habilitarcapturaopciones)) {
            $opciones = $dbm->getRepositoriosById("CePonderacionopcion", "ponderacionid", $ponderacionid);
            $opcionfinal = "";
            foreach ($opciones as $opcion) {
                if ($opcion->getCalificacionminima() <= $calificacionfinalcalculo && $opcion->getCalificacionmaxima() >= $calificacionfinalcalculo) {
                    $opcionfinal = $opcion;
                }
            }
        }
        if ($opcion) {

            if ($opcion->getPonderacionid()->getPonderacionid() == 1 && $periodo->getMateriaporplanestudioid()->getComponentecurricularid()->getRealizarpromedioponderacion()) {
                $calificacionesperiodo = $dbm->getByParametersRepositorios("CeCalificacionperiodoporalumno", array("materiaid" => $periodo->getMateriaid()->getMateriaid(), "alumnoid" => $periodo->getAlumnoid()->getAlumnoid()));
                $calificacionfinalcalculo = 0;
                $periodos = null;
                foreach ($calificacionesperiodo as $cp) {
                    $calificacionfinalcalculonumerico = $calificacionfinalcalculonumerico + $cp->getCalificacion();
                    $calificacionfinalcalculo = $calificacionfinalcalculo + $cp->getPonderacionopcionid() ? $cp->getPonderacionopcionid()->getValornumericoparapromedio() : 0;
                    $conjuntoperiodoevaluacionid = $cp->getPeriodoevaluacionid()->getConjuntoperiodoevaluacionid()->getConjuntoperiodoevaluacionid();
                    if (!in_array($cp->getPeriodoevaluacionid(), $periodos)) {
                        $periodos[] = $cp->getPeriodoevaluacionid();
                    }
                }
                $ultimoperiodo = $dbm->GetUltimoPeriodo($conjuntoperiodoevaluacionid);
                if ($periodo->getMateriaporplanestudioid()->getMateriafrecuenciacapturaid()->getMateriafrecuenciacapturaid() == 1) {
                    $calificacionfinalcalculo = round($calificacionfinalcalculo / count($periodos), 0);
                    $calificacionfinalcalculonumerico = round($calificacionfinalcalculonumerico / count($periodos), 0);
                }
                $opcionfinal = $dbm->getOneByParametersRepositorio("CePonderacionopcion", array("ponderacionid" => 1, "valornumericoparapromedio" => $calificacionfinalcalculo));
                return $calificacionfinalcalculonumerico;
            }

            return $calificacionfinalcalculo;
        } else {
            return $calificacionfinalcalculo;
        }
    }

    /**
     * @Rest\Get("/api/Controlescolar/CapturaCalificacion/bitacora/", name="getBitacoraCalificaciones")
     */
    public function getBitacoraCapturaCalificacion()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $bitacoracalificaciones = $dbm->getBitacoracalificacionesbyProfesor($filtros);
            if ($filtros['bitacoraalumno'] == 'true') {
                $bitacoracalificacionesAlumno = $dbm->getBitacoracalificacionesbyAlumno($filtros);
            }
            if (!$bitacoracalificaciones && !$bitacoracalificacionesAlumno) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View(['global' => $bitacoracalificaciones, 'alumno' => $bitacoracalificacionesAlumno], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public static function saveBitacoraCapturaCalificacion($dbm, $paso, $usuarioid, $calificacionperiodoporalumno, $capturacalificacionid = null)
    {
        $calificacionfinal = $calificacionperiodoporalumno->getMateriapadrecalificacionperiodoporalumnoid() ? $calificacionperiodoporalumno->getMateriapadrecalificacionperiodoporalumnoid()->getCalificacionfinalporperiodoalumno() : $calificacionperiodoporalumno->getCalificacionfinalporperiodoalumno();

        switch ($paso) {
            case 1: //Paso 1 de la bitacora donde se crea el registro y se obtienen los valores previos
                $alumnociclo = $calificacionperiodoporalumno->getAlumnoporcicloid();
                $alumno = $calificacionperiodoporalumno->getAlumnoid();
                $pmpe = $calificacionperiodoporalumno->getProfesorpormateriaplanestudioid();
                $materia = $calificacionperiodoporalumno->getMateriaid();
                $matariaplanestudio = $calificacionperiodoporalumno->getMateriaporplanestudioid();

                $bitacora["profesorpormateriaplanestudiosid"] = $pmpe->getProfesorpormateriaplanestudiosid();
                $bitacora["ciclo"] = $alumnociclo->getCicloid()->getNombre();
                $bitacora["nivel"] = $alumnociclo->getGradoid()->getNivelid()->getNombre();
                $bitacora["grado"] = $alumnociclo->getGradoid()->getGrado();
                $bitacora["clase"] = ($pmpe->getGrupoid() ? $pmpe->getGrupoid()->getNombre() : $pmpe->getTallerid()->getNombre());
                $bitacora["periodoevaluacionid"] = $calificacionperiodoporalumno->getPeriodoevaluacionid()->getPeriodoevaluacionid();

                $nombremateria = $matariaplanestudio->getMateriaid()->getNombre() . ($materia->getMateriaid() != $matariaplanestudio->getMateriaid()->getMateriaid() ? " - " .  $materia->getNombre() : "");
                $bitacora["materia"] = $nombremateria;

                $nombrealumno = $alumno->getMatricula() . " - " . $alumno->getApellidopaterno() . " " . $alumno->getApellidomaterno() . " " . $alumno->getPrimernombre() . ($alumno->getSegundonombre() ? " " . $alumno->getSegundonombre() : "");
                $bitacora["alumno"] = $nombrealumno;

                //Si existe una captura, es un registro cuantitativo y registramos el valor previo capturado
                $captura = $dbm->getRepositorioById('CeCapturacalificacionporalumno', 'capturacalificacionporalumnoid', $capturacalificacionid);
                if ($captura) {
                    $bitacora["criterioevaluacion"] = $captura->getCriterioevaluaciongrupoid()->getAspecto();
                    $bitacora["numerocaptura"] = $captura->getNumerocaptura();
                    $bitacora["capturaanterior"] = $captura->getCalificacion();
                }

                $bitacora["usuarioid"] = $usuarioid;
                $bitacora["fecha"] = new \DateTime();
                $edicionextemporanea = $dbm->getRepositoriosModelo(
                    'CeAlumnoporsolicitudedicionextemporanea',
                    ['s.solicitudedicionextemporaneaid'],
                    ['alumnoid' =>  $alumno->getAlumnoid()],
                    false,
                    false,
                    [
                        ['entidad' => 'CeSolicitudedicionextemporanea', 'alias' => 's', 'on' => 'd.solicitudedicionextemporaneaid = s.solicitudedicionextemporaneaid and s.profesorpormateriaplanestudiosid = '
                            . $bitacora["profesorpormateriaplanestudiosid"] . 'and s.periodoevaluacionid =' . $bitacora["periodoevaluacionid"]]
                    ]
                );
                $bitacora["folioedicionextemporanea"] = $edicionextemporanea ? $edicionextemporanea[0]['solicitudedicionextemporaneaid'] : NULL;

                //Registros previos
                $bitacora["calperiodoanterior"] = $calificacionperiodoporalumno->getCalificacion();
                $bitacora["opcperiodoanterior"] = $calificacionperiodoporalumno->getPonderacionopcionid() ? $calificacionperiodoporalumno->getPonderacionopcionid()->getOpcion() : null;
                $bitacora["comperiodoanterior"] = $calificacionperiodoporalumno->getObservacion();

                $bitacora["calfinalanterior"] = $calificacionfinal->getCalificacion();
                $bitacora["opcfinalanterior"] = $calificacionfinal->getPonderacionopcionid() ? $calificacionfinal->getPonderacionopcionid()->getOpcion() : null;

                self::$BITACORA = $bitacora;
                break;
            case 2:
                $bitacora = self::$BITACORA;

                //Registros nuevos

                //Si existe una captura, es un registro cuantitativo y registramos el valor previo capturado
                $captura = $dbm->getRepositorioById('CeCapturacalificacionporalumno', 'capturacalificacionporalumnoid', $capturacalificacionid);
                if ($captura) {
                    $bitacora["capturanuevo"] = $captura->getCalificacion();
                }

                $bitacora["calperiodonuevo"] = $calificacionperiodoporalumno->getCalificacion();
                $bitacora["opcperiodonuevo"] = $calificacionperiodoporalumno->getPonderacionopcionid() ? $calificacionperiodoporalumno->getPonderacionopcionid()->getOpcion() : null;
                $bitacora["comperiodonuevo"] = $calificacionperiodoporalumno->getObservacion();

                $bitacora["calfinalnuevo"] = $calificacionfinal->getCalificacion();
                $bitacora["opcfinalnuevo"] = $calificacionfinal->getPonderacionopcionid() ? $calificacionfinal->getPonderacionopcionid()->getOpcion() : null;

                //Validar si hubo un cambio
                if (
                    $bitacora["capturaanterior"] != $bitacora["capturanuevo"] ||
                    $bitacora["calperiodoanterior"] != $bitacora["calperiodonuevo"] ||
                    $bitacora["opcperiodoanterior"] != $bitacora["opcperiodonuevo"] ||
                    $bitacora["comperiodoanterior"] != $bitacora["comperiodonuevo"] ||
                    $bitacora["calfinalanterior"] != $bitacora["calfinalnuevo"] ||
                    $bitacora["opcfinalanterior"] != $bitacora["opcfinalnuevo"]
                ) {
                    $hydrator = new ArrayHydrator($dbm->getEntityManager());
                    $Bitacora = $hydrator->hydrate(new  CeBitacoracalificacion(), $bitacora);
                    $dbm->saveRepositorio($Bitacora);
                }
                break;
        }
    }

    public static function saveBitacoraCapturaCalificacionGlobal($dbm, $paso, $usuarioid, $capturaalumnoperiodo)
    {

        switch ($paso) {
            case 1: //Paso 1 de la bitacora donde se crea el registro y se obtienen los valores previos
                $alumnociclo = $capturaalumnoperiodo->getAlumnoporcicloid();
                $alumno = $alumnociclo->getAlumnoid();

                $bitacora["capturaalumnoporperiodoid"] = $capturaalumnoperiodo->getCapturaalumnoporperiodoid();
                $bitacora["ciclo"] = $alumnociclo->getCicloid()->getNombre();
                $bitacora["nivel"] = $alumnociclo->getGradoid()->getNivelid()->getNombre();
                $bitacora["grado"] = $alumnociclo->getGradoid()->getGrado();
                $bitacora["periodoevaluacionid"] = $capturaalumnoperiodo->getPeriodoevaluacionid()->getPeriodoevaluacionid();

                $nombrealumno = $alumno->getMatricula() . " - " . $alumno->getApellidopaterno() . " " . $alumno->getApellidomaterno() . " " . $alumno->getPrimernombre() . ($alumno->getSegundonombre() ? " " . $alumno->getSegundonombre() : "");
                $bitacora["alumno"] = $nombrealumno;

                $bitacora["usuarioid"] = $usuarioid;
                $bitacora["fecha"] = new \DateTime();

                //Registros previos
                $bitacora["asistenciaanterior"] = $capturaalumnoperiodo->getAsistencia();
                $bitacora["comanterior"] = $capturaalumnoperiodo->getObservaciones();
                $bitacora["tareasolicitadaanterior"] = $capturaalumnoperiodo->getTareasolicitada();
                $bitacora["tareaentregadaanterior"] = $capturaalumnoperiodo->getTareaentregada();

                self::$BITACORA = $bitacora;
                break;
            case 2:
                $bitacora = self::$BITACORA;

                //Registros nuevos
                $bitacora["asistencianuevo"] = $capturaalumnoperiodo->getAsistencia();
                $bitacora["comnuevo"] = $capturaalumnoperiodo->getObservaciones();
                $bitacora["tareasolicitadanuevo"] = $capturaalumnoperiodo->getTareasolicitada();
                $bitacora["tareaentregadanuevo"] = $capturaalumnoperiodo->getTareaentregada();

                //Validar si hubo un cambio
                if (
                    $bitacora["asistenciaanterior"] != $bitacora["asistencianuevo"] ||
                    $bitacora["comanterior"] != $bitacora["comnuevo"] ||
                    $bitacora["tareasolicitadaanterior"] != $bitacora["tareasolicitadanuevo"] ||
                    $bitacora["tareaentregadaanterior"] != $bitacora["tareaentregadanuevo"]
                ) {
                    $hydrator = new ArrayHydrator($dbm->getEntityManager());
                    $Bitacora = $hydrator->hydrate(new  CeBitacoracalificacionglobal(), $bitacora);
                    $dbm->saveRepositorio($Bitacora);
                }
                break;
        }
    }

    private function getDM()
    {
        if ($this->DBM) {
            return $this->DBM;
        }
        $this->DBM = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        return $this->DBM;
    }


    /**
     * 
     * @Rest\Get("/api/Controlescolar/CapturaCalificacion/ReCalcularCalificaciones", name="getRecalcularCalificaciones")
     */
    public function re_calcularCalificaciones()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            self::re_calcularCalificacionesGrupo(2543, 33, $dbm);
            $dbm->getConnection()->commit();
            return Api::Ok(Response::HTTP_OK, "Se han actualizado las calificaciones");
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    public function re_calcularCalificacionesGrupo($dbm, $profesorpormateriaplanestudiosid, $periodoevaluacionid)
    {
        //$dbm = $this->getDM(); //new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $pme = $dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'profesorpormateriaplanestudiosid', $profesorpormateriaplanestudiosid);
        //Indica si es un grupo o un taller
        $tipoclase = null; //1 Grupo, 2 Taller

        //Obtenemos a los alumnos
        if ($pme->getGrupoid()) {
            $tipoclase = 1;
            $grupo = $pme->getGrupoid();
            $alumnos = $dbm->AlumnoCicloGrupo($grupo->getCicloid()->getCicloid(), $grupo->getGrupoid(), null);
        }
        if ($pme->getTallerid()) {
            $tipoclase = 2;
            $taller = $pme->getTallerid();
            $alumnos = $dbm->AlumnoCicloGrupo($taller->getCicloid()->getCicloid(), $taller->getTallercurricularid(), null, true);
        }

        foreach ($alumnos as $a) {
            self::re_calcularCalificacionesAlumno($dbm, $a, $pme, $periodoevaluacionid);
        }
    }


    public function re_calcularCalificacionesAlumno($dbm, $alumno, $pme, $periodoevaluacionid) {
        //Indica si es un grupo o un taller
        $tipoclase = null; //1 Grupo, 2 Taller

        //Obtenemos a los alumnos
        if ($pme->getGrupoid()) {
            $tipoclase = 1;
            $grupo = $pme->getGrupoid();
        }
        if ($pme->getTallerid()) {
            $tipoclase = 2;
            $taller = $pme->getTallerid();
        }

        $alumnoporciclo = $dbm->getRepositorioById("CeAlumnoporciclo", "alumnoporcicloid", $alumno['alumnoporcicloid']);
        switch ($tipoclase) {
            case 1:
                $materiaporplanestudio = $pme->getMateriaporplanestudioid();
                break;
            case 2:
                //Los grado 5 y 6 tienen area de especializacion (areaacademica ERROR nombre en BD), para obtener el plan de estudio
                if ($alumnoporciclo->getGradoid()->getAreaacademica()) {
                    $areaespecializacion = $dbm->getRepositoriosModelo(
                        "CeAlumnocicloporgrupo",
                        ["a.areaespecializacionid as id"],
                        ["alumnoporcicloid" => $a['alumnoporcicloid']],
                        false,
                        false,
                        [
                            ["entidad" => "CeGrupo", "alias" => "g", "on" => "g.grupoid = d.grupoid and g.tipogrupoid = 1"],
                            ["entidad" => "CeAreaespecializacion", "alias" => "a", "on" => "g.areaespecializacionid = a.areaespecializacionid"],
                        ]
                    )[0];
                    $planestudio = $dbm->getOneByParametersRepositorio("CePlanestudios", ["gradoid" =>  $alumnoporciclo->getGradoid(), "vigente" => 1, "areaespecializacionid" => $areaespecializacion["id"]]);
                } else {
                    $planestudio = $dbm->getOneByParametersRepositorio("CePlanestudios", ["gradoid" =>  $alumnoporciclo->getGradoid(), "vigente" => 1]);
                }
                if (!$planestudio) {
                    return false;
                }
                $mp =  $dbm->getRepositoriosModelo(
                    'CeGradoportallercurricular',
                    ["m.materiaporplanestudioid as materiaporplanestudioid"],
                    ["tallercurricularid" => $taller->getTallercurricularid(), 'gradoid' => $alumnoporciclo->getGradoid()],
                    false,
                    false,
                    [
                        ["entidad" => "CeMateriaporplanestudios", "alias" => "m", "on" => "d.materiaporplanestudioid = m.materiaporplanestudioid and m.planestudioid =" . $planestudio->getPlanestudioid()]
                    ]
                )[0];
                $materiaporplanestudio = $dbm->getRepositorioById("CeMateriaporplanestudios", "materiaporplanestudioid", $mp["materiaporplanestudioid"]);
                break;
        }

        //Funcion para redondear el perido
        $funcionredondeoperiodo = $materiaporplanestudio->getPlanestudioid()->getTiporedondeoperiodoid()->getFuncionredondeo();
        //Calificacion minima a mostrar
        $calificacionminima = $materiaporplanestudio->getPlanestudioid()->getCalificacionminima();
        //Indica si se muestran los select de opciones
        $mostrarcapturaopciones = $materiaporplanestudio->getComponentecurricularid()->getMostrarcapturaopciones();
        if ($mostrarcapturaopciones) {
            //Indica si se debe realizar el calculo para seleccionar el select de
            $realizarpromedioponderacion = $materiaporplanestudio->getComponentecurricularid()->getRealizarpromedioponderacion();
        }

        if($materiaporplanestudio->getConfigurarsubmaterias()) {
            $periodo = $dbm->getRepositoriosModelo(
                "CeCalificacionperiodoporalumno",
                ["d"],
                [
                    ["periodoevaluacionid", ["=",$periodoevaluacionid]],
                    ["alumnoporcicloid", ["=",$alumno["alumnoporcicloid"]]],
                    ['materiaporplanestudioid', ["=",$materiaporplanestudio->getMateriaporplanestudioid()]] ,
                    ['materiapadrecalificacionperiodoporalumnoid', ["IS NOT NULL", NULL]],
                ],
                false,
                true
            )[0];
        } else {
            $periodo = $dbm->getRepositoriosModelo(
                "CeCalificacionperiodoporalumno",
                ["d"],
                ["periodoevaluacionid" => $periodoevaluacionid, "alumnoporcicloid" => $alumno["alumnoporcicloid"], 'materiaporplanestudioid' => $materiaporplanestudio->getMateriaporplanestudioid()],
                false,
                false,
                [
                    ["entidad" => "CePonderacionopcion", "alias" => "po", "on" => "po.ponderacionopcionid = d.ponderacionopcionid", "left" => true],
                    ["entidad" => "CeCalificacionfinalperiodoporalumno", "alias" => "cfp", "on" => "cfp.calificacionfinalperiodoporalumnoid = d.calificacionfinalporperiodoalumno", "left" => true],
                    ["entidad" => "CePonderacionopcion", "alias" => "pof", "on" => "pof.ponderacionopcionid = cfp.ponderacionopcionid", "left" => true],
    
                ]
            )[0];
        }


        //El resgistro no existe, no es necesario actualizar
        if (!$periodo) {
            return false;
        }
        //Obtenemos las calificaciones de los criterios del periodo
        $calificaciones = $dbm->CalculaCalificacionPeriodo($periodo);
        $calificacionperiodo = 0;
        foreach ($calificaciones as $calificacion) {
            $calificacionperiodo = $calificacionperiodo + $calificacion["calificacion"];
        }
        $periodo->setCalificacionantesredondeo($calificacionperiodo);
        //Aplicamos el redondeo y la calificacion minima, solo si no es una sub materia
        if (!$periodo->getMateriapadrecalificacionperiodoporalumnoid()) {
            //Aplicamo el redondeo a la calificacion
            $calificacionperiodooriginal = $dbm->getRoundedValueByFunctionName($funcionredondeoperiodo, $calificacionperiodo);
            //Si la calificacion obtenida es menor a la minima configurada, colocamos la minima
            if ($calificacionperiodooriginal < $calificacionminima) {
                $calificacionperiodo = $calificacionminima;
            } else {
                $calificacionperiodo = $calificacionperiodooriginal;
            }
        }
        //Se guarda la calificacion del periodo
        $periodo->SetCalificacion($calificacionperiodo);

        //Si se muestran los select, se realiza el calculo para asignar, d elo contrario se coloca null
        $opcionperiodo = null;
        if ($periodo->getMateriaporplanestudioid()->getComponentecurricularid()->getTipocalificacionid()->getTipocalificacionid()  == 1) {
            if ($mostrarcapturaopciones) {
                $opcionperiodo = $dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", $periodo->getPonderacionopcionid() ? $periodo->getPonderacionopcionid()->getPonderacionopcionid() : null);
            }
        } else if ($mostrarcapturaopciones) {
            $ponderacionid = $materiaporplanestudio->getComponentecurricularid()->getPonderacionid()->getPonderacionid();
            if ($realizarpromedioponderacion) {
                //obtenemos las opcion de la ponderacion
                $opciones = $dbm->getRepositoriosById("CePonderacionopcion", "ponderacionid", $ponderacionid);
                //Obtenemos la ponderacion que coninside con la calificacion del periodo
                foreach ($opciones as $opcion) {
                    if ($opcion->getCalificacionminima() <= $calificacionperiodo && $opcion->getCalificacionmaxima() >= $calificacionperiodo) {
                        $opcionperiodo = $opcion;
                    }
                }
            }
        }
        $periodo->setPonderacionopcionid($opcionperiodo);
        $dbm->saveRepositorio($periodo);


        //Calificacion FINAL de la materia
        $calificacionfinalalumno = $periodo->getCalificacionfinalporperiodoalumno();

        //Si no tiene relacion a la calificacion final, entonces es una submateria y se debe calcular la suma de las submateria primero
        if (!$calificacionfinalalumno) {
            //Forma de calificar las submateria 
            $formaconfiguracion = $dbm->getRepositorioById("CeFormaconfiguracionsubmateria", "materiaporplanestudioid", $periodo->getMateriaporplanestudioid());

            $configuracionsubmateria = $dbm->getRepositoriosById("CeConfiguracionsubmaterias", "formaconfiguracionsubmateriaid", $formaconfiguracion);

            // 1 = Cada una tiene su porcentaje  1 != Se promedian
            $calificacionperiodo = 0;
            if ($formaconfiguracion->getFormaCalificar() == 1) {
                foreach ($configuracionsubmateria as $s) {
                    $calsub = $dbm->getOneByParametersRepositorio('CeCalificacionperiodoporalumno', ['alumnoporcicloid' => $periodo->getAlumnoporcicloid(), "periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "materiaporplanestudioid" => $periodo->getMateriaporplanestudioid(), "materiaid" => $s->getMateriaid()]);
                    $calificacionperiodo += ($calsub->getCalificacion() * ($s->getPorcentajecalificacion() / 100));
                }
            } else {
                foreach ($configuracionsubmateria as $s) {
                    $calsub = $dbm->getOneByParametersRepositorio('CeCalificacionperiodoporalumno', ['alumnoporcicloid' => $periodo->getAlumnoporcicloid(), "periodoevaluacionid" => $periodo->getPeriodoevaluacionid(), "materiaporplanestudioid" => $periodo->getMateriaporplanestudioid(), "materiaid" => $s->getMateriaid()]);
                    if(!$calsub) {
                        continue;
                    }
                    $calificacionperiodo += $calsub ? $calsub->getCalificacion() : null;
                }
                $calificacionperiodo = $calificacionperiodo / count($configuracionsubmateria);
            }

            //Aplicamo el redondeo a la calificacion
            $calificacionperiodooriginal = $dbm->getRoundedValueByFunctionName($funcionredondeoperiodo, $calificacionperiodo);
            //Si la calificacion obtenida es menor a la minima configurada, colocamos la minima
            if ($calificacionperiodooriginal < $calificacionminima) {
                $calificacionperiodo = $calificacionminima;
            } else {
                $calificacionperiodo = $calificacionperiodooriginal;
            }

            $periodo = $periodo->getMateriapadrecalificacionperiodoporalumnoid();
            $periodo->setCalificacion($calificacionperiodo);
            //Si se muestran los select
            if ($mostrarcapturaopciones) {
                $ponderacionid = $materiaporplanestudio->getComponentecurricularid()->getPonderacionid() ? $materiaporplanestudio->getComponentecurricularid()->getPonderacionid()->getPonderacionid() : null;
                if ($realizarpromedioponderacion) {
                    //obtenemos las opcion de la ponderacion
                    $opciones = $dbm->getRepositoriosById("CePonderacionopcion", "ponderacionid", $ponderacionid);
                    $opcionperiodo = null;
                    //Obtenemos la ponderacion que coninside con la calificacion del periodo
                    foreach ($opciones as $opcion) {
                        if ($opcion->getCalificacionminima() <= $calificacionperiodo && $opcion->getCalificacionmaxima() >= $calificacionperiodo) {
                            $opcionperiodo = $opcion;
                        }
                    }
                }
                $periodo->setPonderacionopcionid($opcionperiodo);
            }
            $dbm->saveRepositorio($periodo);
            $calificacionfinalalumno = $periodo->getCalificacionfinalporperiodoalumno();
        }
        self::processCalificacionFinalAlumno($dbm, $periodo);
    }

    /**
     * 
     * @Rest\Post("/api/Controlescolar/CapturaCalificacion/UpCalificacionFinalAlumno", name="ActualizarCalFinalAlumno")
     */
    public function ActualizarCalFinalAlumno()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
    
            $cal = $dbm->getRepositorioById('CeCalificacionfinalperiodoporalumno', 'calificacionfinalperiodoporalumnoid', $data['calificacionfinalperiodoporalumnoid']);
            $p = end($dbm->getRepositoriosById('CeCalificacionperiodoporalumno', 'calificacionfinalporperiodoalumno', $data['calificacionfinalperiodoporalumnoid']));
            $calp = $dbm->getRepositorioById('CeCalificacionperiodoporalumno', 'calificacionperiodoporalumnoid', $data['id']);
            if($cal) {
                if($data['isponderacion']) {
                    $cal->setPonderacionopcionid($data['calificacion'] ? 
                        $dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", $data['calificacion']) : null);
                } else {
                    $cal->setCalificacion($data['calificacion']);
                }
                $dbm->saveRepositorio($cal);
            } else if($calp) {
                if($data['isponderacion']) {
                    $calp->setPonderacionopcionid($data['calificacion'] ? 
                        $dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", $data['calificacion']) : null);
                } else {
                    $calp->setCalificacion($data['calificacion']);
                }
                $dbm->saveRepositorio($calp);
            }
    
            $dbm->getConnection()->commit();
            if(!$cal) {
                if($data['isponderacion']) {
                    self::processCalificacionFinalAlumno($dbm, $calp, $data['calificacion']);
                } else {
                    self::processCalificacionFinalAlumno($dbm, $calp);
                }
            }

            if($cal) {
               $bitacora = self::saveBitacoraCalificacionPeriodo($dbm, 1, $data["usuarioid"], $p, $data);
            } else if($calp) {
                $bitacora =  self::saveBitacoraCalificacionPeriodo($dbm, 0, $data["usuarioid"], $calp, $data);
            }
        
            if($bitacora['error']) {
                return new View($bitacora['mensaje'], Response::HTTP_BAD_REQUEST);
            }

            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        
    }

    public static function saveBitacoraCalificacionPeriodo($dbm, $isFinal, $usuarioid, $periodo, $data) {

        try {
            $alumnociclo = $periodo->getAlumnoporcicloid();
            $alumno = $periodo->getAlumnoid();
            $pmpe = $periodo->getProfesorpormateriaplanestudioid();
            $materia = $periodo->getMateriaid();
            $matariaplanestudio = $periodo->getMateriaporplanestudioid();
    
            
            $bitacora = [
                "profesorpormateriaplanestudiosid" => $periodo->getProfesorpormateriaplanestudioid()->getProfesorpormateriaplanestudiosid(),
                "ciclo" => $alumnociclo->getCicloid()->getNombre(),
                "nivel" => $alumnociclo->getGradoid()->getNivelid()->getNombre(),
                "grado" => $alumnociclo->getGradoid()->getGrado(),
                "clase" => '32',
                "periodoevaluacionid" => $periodo->getPeriodoevaluacionid()->getPeriodoevaluacionid(),
                "usuarioid" => $data['usuarioid']
            ];
    
            $nombremateria = $matariaplanestudio->getMateriaid()->getNombre() . ($materia->getMateriaid() != $matariaplanestudio->getMateriaid()->getMateriaid() ? " - " .  $materia->getNombre() : "");
            $bitacora["materia"] = $nombremateria;
    
            $nombrealumno = $alumno->getMatricula() . " - " . $alumno->getApellidopaterno() . " " . $alumno->getApellidomaterno() . " " . $alumno->getPrimernombre() . ($alumno->getSegundonombre() ? " " . $alumno->getSegundonombre() : "");
            $bitacora["alumno"] = $nombrealumno;
            $bitacora["fecha"] = new \DateTime();
            $bitacora["clase"] = ($pmpe->getGrupoid() ? $pmpe->getGrupoid()->getNombre() : $pmpe->getTallerid()->getNombre());
            if($data['isponderacion']) {
               $opcnuevo = $dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", intval($data['calificacion']));
               $opcold = $dbm->getRepositorioById("CePonderacionopcion", "ponderacionopcionid", intval($data['oldcalificacion']));
            }
    
            if($isFinal) {
                if($data['isponderacion']) {
                    
                    $bitacora["opcfinalnuevo"] = $opcnuevo ? $opcnuevo->getOpcion() : null;
                    $bitacora["opcfinalanterior"] = $opcold ? $opcold->getOpcion() : null;
                } else {
                    $bitacora["calfinalanterior"] = $data['oldcalificacion'];
                    $bitacora["calfinalnuevo"] = $data['calificacion'];
                }
            } else {
                if($data['isponderacion']) {
                    $bitacora["opcperiodoanterior"] = $opcold ? $opcold->getOpcion() : null;
                    $bitacora["opcperiodonuevo"] = $opcnuevo ? $opcnuevo->getOpcion() : null;
                } else {
                    $bitacora["calperiodoanterior"] = $data['oldcalificacion'];
                    $bitacora["calperiodonuevo"] = $data['calificacion'];
                }
            }
            $dbm->getConnection()->beginTransaction();
    
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Bitacora = $hydrator->hydrate(new  CeBitacoracalificacion(), $bitacora);
            $dbm->saveRepositorio($Bitacora);
            $dbm->getConnection()->commit();


            return true;
        } catch (\Exception $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }



    /**
     * 
     * @Rest\Post("/api/Controlescolar/CapturaCalificacion/GetCriteriosAlumnoDetail", name="GetCriteriosAlumnoDetail")
     */
    public function GetCriteriosAlumnoDetail()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
    
            $criterios = $dbm->getRepositoriosModelo("CeCapturacalificacionporalumno", 
                ["d.capturacalificacionporalumnoid, h.calificacionperiodoporalumnoid,  CONCAT_WS(' ', cc.aspecto, d.numerocaptura) as aspecto, d.calificacion, cc.porcentajecalificacion, d.numerocaptura, cc.puntajemaximo"], 
    
                    [["capturacalificacionporalumnoid is not null and d.calificacionperiodoporalumnoid = " . $data . 'and h.profesorpormateriaplanestudioid = cc.profesorpormateriaplanestudiosid and d.numerocaptura <= cc.capturas']], "aspecto", true, [
                    ["entidad" => "CeCriterioevaluaciongrupo", "alias" => "cc", "left" => false, "on" => "cc.criterioevaluaciongrupoid = d.criterioevaluaciongrupoid"],
                    ["entidad" => "CeCalificacionperiodoporalumno", "alias" => "h", "left" => false, "on" => "d.calificacionperiodoporalumnoid = h.calificacionperiodoporalumnoid"],
                    ]);
            
            if(!$criterios) {
                return new View("No se han asignado criterios al periodo seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($criterios, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }


    }
}
