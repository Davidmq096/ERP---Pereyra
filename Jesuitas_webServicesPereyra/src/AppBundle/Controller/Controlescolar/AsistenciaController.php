<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Entity\CeAsistencia;
use AppBundle\Entity\CeExtraordinario;
use AppBundle\Entity\CeMotivoextraordinarioporextraordinario;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
/**
 * @author Mariano
 */
class AsistenciaController extends FOSRestController
{

    /**
     * Retorna arreglo de asistencias en base a los parametros enviados
     * @Rest\Get("/api/ControlEscolar/Asistencia/", name="BuscarAsistencias")
     */
    public function getAsistencias()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $respuesta = $this->asistencias($filtros, $dbm);
            if($respuesta['error']) {
                return new View($respuesta['mensaje'], Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($respuesta, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public static function asistencias($filtros, $dbm) {
        $dbm->getConnection()->beginTransaction();

        if($filtros['ismobile']) {
            $startDate =  $filtros["fecha"]['date']["year"] . "-" . $filtros["fecha"]['date']["month"] . "-" . $filtros["fecha"]['date']["day"];
            $endDate = $filtros["fecha"]['date']["year"] . "-" . $filtros["fecha"]['date']["month"] . "-" . $filtros["fecha"]['date']["day"];
        } else {
            $startDate =  $filtros["fecha"]["beginDate"]["year"] . "-" . $filtros["fecha"]["beginDate"]["month"] . "-" . $filtros["fecha"]["beginDate"]["day"];
            $endDate = $filtros["fecha"]["endDate"]["year"] . "-" . $filtros["fecha"]["endDate"]["month"] . "-" . $filtros["fecha"]["endDate"]["day"];
        }

        if ($filtros["fecha"]){
            $filtros["fechainicio"] = new \DateTime($startDate);
            $filtros["fechafin"] = new \DateTime($endDate);
        }

        if(!$filtros['periodosevaluacion']) {
            return array("mensaje" => "No se han encontrado periodos asignados", "error" => true);  
        }

        $periodoinicio = $filtros['periodosevaluacion'][0];
        $periodofin = end($filtros['periodosevaluacion']);
        $fechaperiodoinicio = new \DateTime($periodoinicio['fechainicio']);
        $fechaperiodofin = new \DateTime($periodofin['fechafin']);

        if($filtros['fechainicio'] < $fechaperiodoinicio || $filtros['fechafin'] > $fechaperiodofin) {
            return array("mensaje" => "El rango de fechas debe ser mayor a la fecha inicio del primer periodo y menor a la fecha fin del ultimo periodo", "error" => true);
        }

        $filtros['f1'] = $startDate;
        $filtros['f2'] = $endDate;
        $dias=date_diff($filtros["fechainicio"],$filtros["fechafin"])->d+1;
        if ($dias>60) {
            return array("mensaje" => "Seleccione un rango de fechas menor a 60 días.", "error" => true);
        }
        $nivel = null;

        $profess = $dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'profesorpormateriaplanestudiosid', $filtros['profesorpormateriaplanestudiosid']);
        if(!$profess){
            return array("mensaje" => "No se le ha asignado un profesor al grupo seleccionado.", "error" => true);  
        }


        $alumnoss = $dbm->getALumnosportallergrupo(['profesorpormateriaplanestudiosid' => $filtros['profesorpormateriaplanestudiosid']]);
        if(!$alumnoss){
            if($profess->getTallerid()){
                return array("mensaje" =>  "No se han asignado alumnos a este taller", "error" => true);  
            }else{
                return array("mensaje" =>  "No se han asignado alumnos a este grupo", "error" => true);  
            }
        }
         /**
          * @annotation En esta parte se definen los dias que se muestran por semana
          */
        $fechass = [
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
        ];

        for ($i = strtotime($startDate); $i <= strtotime($endDate); $i = strtotime('+1 day', $i)) {
            $tmp = date('N', $i);
            if (date('N', $i) == 1){
                $fechass[1][] = date('Y-m-d', $i);
            }else if (date('N', $i) == 2){
                $fechass[2][] = date('Y-m-d', $i);
            }else if (date('N', $i) == 3){
                $fechass[3][] = date('Y-m-d', $i);
            }else if (date('N', $i) == 4){
                $fechass[4][] = date('Y-m-d', $i);
            }else if (date('N', $i) == 5){
                $fechass[5][] = date('Y-m-d', $i);
            }
        }

        $diass = [];
        $fechas2 = [];

        foreach($fechass as $key => $fecha){
            if(count($fecha) > 0){
                $diass[] = $key;
                $fechas2[] = $fecha[0];
            } 
        }

        $horarioss = $dbm->getByParametersRepositorios('CeHorario', ['profesorpormateriaplanestudiosid' => $filtros['profesorpormateriaplanestudiosid'], 'dia' => $diass]);

        if(!$horarioss){
            return array("mensaje" =>  "No se ha asignado el horario a la clase", "error" => true);  
        }

        $ciclo = null;

        if($profess->getTallerid()){
            $ciclo = $profess->getTallerid()->getCicloid()->getCicloid();
        }else{
            $ciclo = $profess->getGrupoid()->getCicloid()->getCicloid();
        }


        foreach($alumnoss as $al){
            $al = $dbm->BuscarAlumnosA(['alumnoid' => $al['alumnoid'], 'cicloid' => $ciclo])[0];
            $alc = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $al['alumnoporcicloid']);
            if(!$alc) {
                continue;
            }
            $nivel = $al['nivelid'];
            foreach($horarioss as $horario){
                foreach($fechass[$horario->getDia()] as $fecha){
                    $diasfestivos = $dbm->getByParametersRepositorios('CeEvento', [
                        'tipoeventoid' => 2,
                        'fechainicio' => new \Datetime($fecha)
                    ]);
                    $diafestivo = false;
                    foreach($diasfestivos as $d){
                        $nivel = $dbm->getOneByParametersRepositorio('CeEventopornivel', [
                            'nivelid' => $al['nivelid'],
                            'eventoid' => $d->getEventoid()
                        ]);
                        if($nivel){
                            $diafestivo = true;
                        }
                    }
                    if(!$diafestivo){
                        $asis = $dbm->getOneByParametersRepositorio('CeAsistencia', [
                            'profesorpormateriaplanestudioid' => $filtros['profesorpormateriaplanestudiosid'],
                            'alumnoporcicloid' => $al['alumnoporcicloid'],
                            'hora' => $horario->getHorainicio(),
                            'fecha' => new \Datetime($fecha)
                        ]);
                        if(!$asis){
                            $tipo = $dbm->getRepositorioById('CeTipoasistencia', 'tipoasistenciaid', 1);
                            $estatus = $dbm->getRepositorioById('CeEstatusinasistencia', 'estatusinasistenciaid', 1);
                            $asis = new CeAsistencia();
                            $asis->setAlumnoporcicloid($alc);
                            $asis->setProfesorpormateriaplanestudioid($profess);
                            $asis->setFecha(new \Datetime($fecha));
                            $asis->setHora($horario->getHorainicio());
                            $asis->setTipoasistenciaid($tipo);
                            $asis->setEstatusinasistenciaid($estatus);
                            $dbm->saveRepositorio($asis);
                        }
                    }
                }
            }   
        }

        $asis = $dbm->BuscarAsistencias($filtros);
        $fechas2 = [];

        foreach($asis as $a){
            $d = explode(' ', $a['fecha']);
            $d1 = explode('/', $d[0]);
            $fe = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
            $find = false;
            foreach($fechas2 as $f){
                if($f == $fe){
                    $find = true;
                }
            }
            if(!$find){
                $fechas2[] = $fe;
            }
        }
        $asistencias = [];
        foreach($asis as $a){
            if($a['numerolista']){
                $asistencias[] = $a;
            }
        }
        if(count($asistencias) == 0){
            $asistencias = $asis;
        }
        $fechas=array_unique (array_column($asistencias,"fecha"));
        sort($fechas);
        if (!$asistencias) {
            return array("mensaje" => "No se encontró ningún registro ", "error" => true);
        }
        if($asistencias[0]['tallercurricularid']){
            $ast = [];
            foreach($asistencias as $a){
                if($a['vigente'] == 1){
                    $ast[] = $a;
                }
            }
            $asistencias = $ast;
        } 
        foreach ($asistencias as $key=>$asistencia){
            $matricula=$asistencia["matricula"];
            foreach($fechas as $f){
                $find = false;
                foreach($alumnos[$matricula] as $m){
                    if($m == $f){
                        $find = true;
                    }
                }
                if(!$find){
                    $alumnos[$matricula][] = $f;
                }
            }
        }
        foreach ($asistencias as $key=>&$asistencia){
            $matricula=$asistencia["matricula"];
            foreach($alumnos[$matricula] as &$m){
                if($m == $asistencia["fecha"]){
                    $m=$asistencia;
                }
            }
        }
        foreach ($alumnos as $key=>$alumno){
            
            
            foreach($alumno as $als){
                if(!is_string($als)){
                    $al = $als;
                }
            }
            
            $numerolista=$al["numerolista"];
            $matricula=$al["matricula"];
            $nombrealumno=$al["nombrealumno"];
            foreach ($alumno as $key2=>$asistencia){
                if(!is_string($asistencia)){
                    unset($alumno[$key2]["numerolista"]);
                    unset($alumno[$key2]["matricula"]);
                    unset($alumno[$key2]["nombrealumno"]);
                }
            }
            
            $asis=null;
            foreach ($alumno as $aa){
                $a=[
                    "asistenciaid"=>$aa["asistenciaid"],
                    "fecha"=>$aa["fecha"],
                    "tipoasistenciaid"=>$aa["tipoasistenciaid"],
                    "estatusinasistenciaid"=>$aa["estatusinasistenciaid"],
                ];
                foreach($fechas2 as $fecha){
                    $d = explode(' ', $aa["fecha"]);
                    $d1 = explode('/', $d[0]);
                    $d3 = $d1[2] . '/' . $d1[1] . '/' . $d1[0];
                    $date = new \Datetime();
                    if(count($d1) == 0){
                        $date = new \Datetime($d3);
                    }
                    $dd = explode('-', $fecha);
                    $d2 = $dd[2] . '/' . $dd[1] . '/' . $dd[0];
                    $diasfestivos = $dbm->getByParametersRepositorios('CeEvento', [
                        'tipoeventoid' => 2,
                        'fechainicio' => $date
                    ]);
                    $diafestivo = false;
                    foreach($diasfestivos as $d){
                        $nivel = $dbm->getOneByParametersRepositorio('CeEventopornivel', [
                            'nivelid' => $aa['nivelid'],
                            'eventoid' => $d->getEventoid()
                        ]);
                        if($nivel){
                            $diafestivo = true;
                        }
                    }
                    if(!$diafestivo){
                        if($d[0] == $d2){
                            $asis[]=$aa;
                        }
                    }
                }
                
            }
            if($asis){
                $respuesta[]=[
                    "matricula"=>$matricula,
                    "nombrealumno"=>$nombrealumno,
                    "numerolista"=>$numerolista,
                    "asistencias"=>$asis
                ];
            }
        }
        $fechasfinal = [];

        foreach($fechas2 as $fecha){
            foreach($fechas as $f){
                $d = explode(' ', $f);
                $d1 = explode('/', $d[0]);
                $d3 = $d1[2] . '/' . $d1[1] . '/' . $d1[0];
                $dd = explode('-', $fecha);
                $date = new \Datetime();
                if(count($d1) == 0){
                    $date = new \Datetime($d3);
                }
                $d2 = $dd[2] . '/' . $dd[1] . '/' . $dd[0];
                $diasfestivos = $dbm->getByParametersRepositorios('CeEvento', [
                    'tipoeventoid' => 2,
                    'fechainicio' =>  $date
                ]);
                $diafestivo = false;
                foreach($diasfestivos as $d){
                    $nivels = $dbm->getOneByParametersRepositorio('CeEventopornivel', [
                        'nivelid' => $nivel,
                        'eventoid' => $d->getEventoid()
                    ]);
                    if($nivels){
                        $diafestivo = true;
                    }
                }
                if(!$diafestivo){
                    if($d[0] == $d2){
                        $fechasfinal[] = $f;
                    }
                }
            }
        }


        foreach($respuesta as &$al){
            usort($al['asistencias'],function($a, $b) {
                $d = explode(' ', $a['fecha']);
                $dd = explode(' ', $b['fecha']);
                $d1 = explode('/', $d[0]);
                $dd1 = explode('/', $dd[0]);
                $d2 = $d1[2] . '/' . $d1[1] . '/' . $d1[0];
                $d3 = $dd1[2] . '/' . $dd1[1] . '/' . $dd1[0];
                return strtotime($d2) - strtotime($d3);
            });
        }
        
        usort($fechasfinal,function($a, $b) {
            $d = explode(' ', $a);
            $dd = explode(' ', $b);
            $d1 = explode('/', $d[0]);
            $dd1 = explode('/', $dd[0]);
            $d2 = $d1[2] . '/' . $d1[1] . '/' . $d1[0];
            $d3 = $dd1[2] . '/' . $dd1[1] . '/' . $dd1[0];
            return strtotime($d2) - strtotime($d3);
        } );

        foreach($fechasfinal as $key => $f){
            $d = explode(' ', $f);
            $d1 = explode('/', $d[0]);
            $d2 = $d1[2] . '/' . $d1[1] . '/' . $d1[0];
            $dia = date('N', strtotime($d2));

            if($dia == 1){
                $dia = 'Lunes';
            } else if($dia == 2){
                $dia = 'Martes';
            }else if($dia == 3){
                $dia = 'Miércoles';
            }else if($dia == 4){
                $dia = 'Jueves';
            }else if($dia == 5){
                $dia = 'Viernes';
            }else if($dia == 6){
                $dia = 'Sábado';
            }else if($dia == 7){
                $dia = 'Domingo';
            }
            if($filtros['ismobile']) {
                $fechasfinal[$key] = $d[1] . ' '. $dia .'';
            } else {
                $fechasfinal[$key] = $f . ' '. $dia .'';
            }
            
        }
        $dbm->getConnection()->commit();
        return array("alumnos"=>$respuesta,"fechas"=>$fechasfinal);
    }

    /**
     * @Rest\Put("/api/ControlEscolar/Asistencia/Estatus" , name="ActualizarAsistencias")
     */
    public function updateAsistencias()
    {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            //Actualizamos el estatus
            $dbm->getConnection()->beginTransaction();
            $Asistencia = $dbm->getRepositorioById('CeAsistencia', 'asistenciaid', $data["asistenciaid"]);
            $nivelid = $Asistencia->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNivelid();
            $tiposasistencias =  $dbm->getRepositoriosById('CeTipoasistenciapornivel', 'nivelid', $nivelid);

            $tiposasistenciaactual = $Asistencia->getTipoasistenciaid();
            $tiposasistencia = $Asistencia->getTipoasistenciaid();


            foreach($tiposasistencias as $key => $tp){
                if($tiposasistenciaactual->getTipoasistenciaid() == $tp->getTipoasistenciaid()){
                    $next = $key+1;
                    $total = count($tiposasistencias) - 1;
                    if($next > $total || $next > 3){
                        $next = 0;
                    }
                    $tiposasistencia = $tiposasistencias[$next];
                }
            }


            $Asistencia->setTipoasistenciaid($dbm->getRepositorioById("CeTipoasistencia","tipoasistenciaid",$tiposasistencia->getTipoasistenciaid()));
            $dbm->saveRepositorio($Asistencia);

            $asistenciadatos = $dbm->getAsistenciaProfesor(['profesorpormateriaplanestudiosid' => $Asistencia->getProfesorpormateriaplanestudioid()->getProfesorpormateriaplanestudiosid()]);

            if(count($asistenciadatos) == 0){

            }

            //Verificamos el numero de faltas permitidas para la materia
            $faltaspermitidas=$asistenciadatos[0]['horasporsemana']*2;
            if (ENTORNO==1){
                $faltaspermitidas=$faltaspermitidas+1;
            }
            $faltas=$dbm->BuscarInasistencias(['profesorpormateriaplanestudiosid' => $Asistencia->getProfesorpormateriaplanestudioid()->getProfesorpormateriaplanestudiosid(), 'alumnoporcicloid' => $Asistencia->getAlumnoporcicloid()->getAlumnoporcicloid()]);

            $pmpe = $Asistencia->getProfesorpormateriaplanestudioid();
            $alumno = $Asistencia->getAlumnoporcicloid()->getAlumnoid();
            
            //if (count($faltas)>$faltaspermitidas){
                //$extraordinario=$dbm->getOneByParametersRepositorio("CeExtraordinario",["alumnoid"=>$alumno->getAlumnoid(),"profesorpormateriaplanestudiosid"=>$pmpe->getProfesorpormateriaplanestudiosid()]);
                //if (!$extraordinario){
                    //$extraordinario=new CeExtraordinario;
                    //$extraordinario->setAlumnoid($alumno);
                    //$extraordinario->setProfesorpormateriaplanestudiosid($pmpe);
                    //$extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById("CeEstatusextraordinario","estatusextraordinarioid",1));
                    //$dbm->saveRepositorio($extraordinario);

                    //$entidad=$extraordinario;
                    //$usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                    //if ($usuariodestino){
                    //    $usuariodestino=$usuariodestino->getUsuarioid();
                    //    $actividad=[
                    //        "tipoactividadid"=>22,
                    //        "usuariodestinoid"=>$usuariodestino
                    //    ];
                    //    \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),null);
                    //}

                    //$motivo=new CeMotivoextraordinarioporextraordinario;
                    //$motivo->setExtraordinarioid($extraordinario);
                    //$motivo->setMotivoextraordinarioid($dbm->getRepositorioById("CeMotivoextraordinario","motivoextraordinarioid",3));
                    //$dbm->saveRepositorio($motivo);
             //   }else{
                    //$motivofalta=$dbm->getOneByParametersRepositorio("CeMotivoextraordinarioporextraordinario",["extraordinarioid"=>$extraordinario->getExtraordinarioid(),"motivoextraordinarioid"=>3]);
                    //if (!$motivofalta){
                    //    $motivo=new CeMotivoextraordinarioporextraordinario;
                    //    $motivo->setExtraordinarioid($extraordinario);
                    //    $motivo->setMotivoextraordinarioid($dbm->getRepositorioById("CeMotivoextraordinario","motivoextraordinarioid",3));
                    //    $dbm->saveRepositorio($motivo);    
                    //}
              //  }
            //}else{
                //$extraordinario=$dbm->getOneByParametersRepositorio("CeExtraordinario",["alumnoid"=>$alumno->getAlumnoid(),"profesorpormateriaplanestudiosid"=>$pmpe->getProfesorpormateriaplanestudiosid()]);
                //if ($extraordinario){
                //    $motivofalta=$dbm->getOneByParametersRepositorio("CeMotivoextraordinarioporextraordinario",["extraordinarioid"=>$extraordinario->getExtraordinarioid(),"motivoextraordinarioid"=>3]);
                //    if ($motivofalta){
                //        $dbm->removeRepositorio($motivofalta);
                //    }
                //    $motivos=$dbm->getRepositorioById("CeMotivoextraordinarioporextraordinario","extraordinarioid",$extraordinario->getExtraordinarioid());
                //    if (!$motivos){
                //        $dbm->removeRepositorio($extraordinario);
                //    }
                //}
            //}

            $dbm->getConnection()->commit();

            // if ($data["tipoasistenciaid"]==2){
            //     $entidad=$Asistencia;
            //     if($usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid())){
            //         $actividad=[
            //             "tipoactividadid"=>17,
            //             "usuarioorigenid"=>$entidad->getUsuarioid(),
            //             "usuariodestinoid"=>$usuariodestino->getUsuarioid()
            //         ];
            //         \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),null);
            //     }
            // }

            return new View(['tipoasistencia' =>  $tiposasistencia->getTipoasistenciaid()], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Asistencia/Cancelacion", name="indexCancelacionInasistencias")
     */
    public function indexCancelacionInasistencias()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('CeEstatusinasistencia', 'activo', 1);
            $tipoasistencia = $dbm->getRepositoriosById('CeTipoasistencia', 'activo', 1);
            $planestudios = $dbm->getRepositoriosById('CePlanestudios','vigente',1);
            $materias = array();
            foreach ($planestudios as $p) {
                $materias = array_merge(
                    $materias,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid()]
                    )
                );
            }

            $filtro = array
                (
                'ciclo' => $ciclo,
                'nivel' => $nivel,
                'grupo' => $grupo,
                'semestre' => $semestre,
                'planestudios' => $planestudios,
                'materia' => $materias,
                'grado' => $grado,
                'estatus' => $estatus,
                'tipoasistencia' => $tipoasistencia
            );

            return new View($filtro, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Cancelacion de inasistencias en base a los parametros enviados
     * @Rest\Get("/api/Asistencia/Cancelacion/", name="BuscarCancelacionInasistencias")
     */
    public function getCancelacionInasistencias()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $cicloactual=$dbm->getRepositorioById("Ciclo","actual",1);
            $filtros['cicloid'] = $filtros['cicloid'] ? $filtros['cicloid'] : $cicloactual->getCicloid();

            $entidad = $dbm->BuscarInasistencias($filtros);

            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Put("/api/Asistencia/Cancelacion" , name="ActualizarCancelacionInasistencias")
     */
    public function updateCancelacionInasistencias()
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = $datos;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            foreach ($data["asistenciaid"] as $asis){
                $dbm->getConnection()->beginTransaction();
                $Asistencia = $dbm->getRepositorioById('CeAsistencia', 'asistenciaid', $asis['asistenciaid']);
                $Asistencia->setEstatusinasistenciaid($dbm->getRepositorioById("CeEstatusinasistencia","estatusinasistenciaid",$data["estatusinasistenciaid"]));
                $Asistencia->setMotivocancelacioninasistencia($data["motivocancelacioninasistencia"]);
                $Asistencia->setUsuarioid($dbm->getRepositorioById("Usuario","usuarioid",$data["usuarioid"]));
                $Asistencia->setFechamodificacion(new \DateTime());
                $dbm->saveRepositorio($Asistencia);
                
                $asistenciadatos = $dbm->getAsistenciaProfesor(['profesorpormateriaplanestudiosid' => $Asistencia->getProfesorpormateriaplanestudioid()->getProfesorpormateriaplanestudiosid()]);

                if(count($asistenciadatos) == 0){

                }

                //Verificamos el numero de faltas permitidas para la materia
                $faltaspermitidas=$asistenciadatos[0]['horasporsemana']*2;
                if (ENTORNO==1){
                    $faltaspermitidas=$faltaspermitidas+1;
                }
                $faltas=$dbm->BuscarInasistencias(['profesorpormateriaplanestudiosid' => $Asistencia->getProfesorpormateriaplanestudioid()->getProfesorpormateriaplanestudiosid(), 'alumnoporcicloid' => $Asistencia->getAlumnoporcicloid()->getAlumnoporcicloid()]);

                $pmpe = $Asistencia->getProfesorpormateriaplanestudioid();
                $alumno = $Asistencia->getAlumnoporcicloid()->getAlumnoid();
                //if (count($faltas)>$faltaspermitidas){
                //    if($pmpe){
                //        $extraordinario=$dbm->getOneByParametersRepositorio("CeExtraordinario",["alumnoid"=>$alumno->getAlumnoid(),"profesorpormateriaplanestudiosid"=>$pmpe->getProfesorpormateriaplanestudiosid()]);
                //        if (!$extraordinario){
                //            $extraordinario=new CeExtraordinario;
                //            $extraordinario->setAlumnoid($alumno);
                //            $extraordinario->setProfesorpormateriaplanestudiosid($pmpe);
                //            $extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById("CeEstatusextraordinario","estatusextraordinarioid",1));
                            //$dbm->saveRepositorio($extraordinario);

                //            $entidad=$extraordinario;
                //            $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                            //if ($usuariodestino){
                            //    $usuariodestino=$usuariodestino->getUsuarioid();
                            //    $actividad=[
                            //        "tipoactividadid"=>22,
                            //        "usuariodestinoid"=>$usuariodestino
                            //    ];
                            //    \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),null);
                            //}
                            
                //            $motivo=new CeMotivoextraordinarioporextraordinario;
                //            $motivo->setExtraordinarioid($extraordinario);
                //            $motivo->setMotivoextraordinarioid($dbm->getRepositorioById("CeMotivoextraordinario","motivoextraordinarioid",3));
                //            $dbm->saveRepositorio($motivo);
                //        }else{
                //            $motivofalta=$dbm->getOneByParametersRepositorio("CeMotivoextraordinarioporextraordinario",["extraordinarioid"=>$extraordinario->getExtraordinarioid(),"motivoextraordinarioid"=>3]);
                //            if (!$motivofalta){
                //                $motivo=new CeMotivoextraordinarioporextraordinario;
                //                $motivo->setExtraordinarioid($extraordinario);
                //                $motivo->setMotivoextraordinarioid($dbm->getRepositorioById("CeMotivoextraordinario","motivoextraordinarioid",3));
                //                $dbm->saveRepositorio($motivo);    
                //            }
                //        }
                //    }
                //}else{
                //    if($pmpe){
                //        $extraordinario=$dbm->getOneByParametersRepositorio("CeExtraordinario",["alumnoid"=>$alumno->getAlumnoid(),"profesorpormateriaplanestudiosid"=>$pmpe->getProfesorpormateriaplanestudiosid()]);
                //        if ($extraordinario){
                //            $motivofalta=$dbm->getOneByParametersRepositorio("CeMotivoextraordinarioporextraordinario",["extraordinarioid"=>$extraordinario->getExtraordinarioid(),"motivoextraordinarioid"=>3]);
                //            if ($motivofalta){
                //                $dbm->removeRepositorio($motivofalta);
                //            }
                //            $motivos=$dbm->getRepositorioById("CeMotivoextraordinarioporextraordinario","extraordinarioid",$extraordinario->getExtraordinarioid());
                //            if (!$motivos){
                //                $dbm->removeRepositorio($extraordinario);
                //            }
                //        }
                //    }
                //}



                $dbm->getConnection()->commit();
                if ($data["estatusinasistenciaid"]==1){
                    $tipoactividadid=21;
                }else{
                    $tipoactividadid=20;
                }
                $entidad=$Asistencia;
                $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$alumno->getAlumnoid());
                // if ($usuariodestino){
                //     $usuariodestino=$usuariodestino->getUsuarioid();
                //     $actividad=[
                //         "tipoactividadid"=>$tipoactividadid,
                //         "usuarioorigenid"=>$entidad->getUsuarioid(),
                //         "usuariodestinoid"=>$usuariodestino
                //     ];
                //     \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),null);
                // }
                
            }
            return new View("Se ha actualizado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    	/**
	 * @Rest\Post("/api/Asistencia/Justificacion" , name="justificarFaltasbyalumno")
	 */
	public function justificarFaltasbyalumno(){
		try{
			$content=trim(file_get_contents("php://input"));
			$data=json_decode($content, true);
            $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumnos = $data['alumnos'];
            $dbm->getConnection()->beginTransaction();
            foreach($alumnos as $alumno) {
                $profesoresmateriaplanestudiobyalumno = $dbm->getBIMateriasDataRawByAOG($alumno['alumnoporcicloid']);
                foreach($profesoresmateriaplanestudiobyalumno as $p){
                    $startDate =  $data["fecha"]["beginDate"]["year"] . "-" . $data["fecha"]["beginDate"]["month"] . "-" . $data["fecha"]["beginDate"]["day"];
                    $endDate = $data["fecha"]["endDate"]["year"] . "-" . $data["fecha"]["endDate"]["month"] . "-" . $data["fecha"]["endDate"]["day"];
                    
        
                    $fechass = [
                        1 => [],
                        2 => [],
                        3 => [],
                        4 => [],
                        5 => [],
                    ];
        
                    for ($i = strtotime($startDate); $i <= strtotime($endDate); $i = strtotime('+1 day', $i)) {
                        $tmp = date('N', $i);
                        if (date('N', $i) == 1){
                            $fechass[1][] = date('Y-m-d', $i);
                        }else if (date('N', $i) == 2){
                            $fechass[2][] = date('Y-m-d', $i);
                        }else if (date('N', $i) == 3){
                            $fechass[3][] = date('Y-m-d', $i);
                        }else if (date('N', $i) == 4){
                            $fechass[4][] = date('Y-m-d', $i);
                        }else if (date('N', $i) == 5){
                            $fechass[5][] = date('Y-m-d', $i);
                        }
                    }
        
                    foreach($fechass as $key => $fecha){
                        if(count($fecha) > 0){
                            $diass[] = $key;
                            $fechas2[] = $fecha[0];
                        } 
                    }
        
                    $horarioss = $dbm->getByParametersRepositorios('CeHorario', ['profesorpormateriaplanestudiosid' => $p['profesorpormateriaplanestudiosid'], 'dia' => $diass]);
        
                    foreach($horarioss as $horario){
                        foreach($fechass[$horario->getDia()] as $fecha){
                            $diasfestivos = $dbm->getByParametersRepositorios('CeEvento', [
                                'tipoeventoid' => 2,
                                'fechainicio' => new \Datetime($fecha)
                            ]);
                            $diafestivo = false;
                            foreach($diasfestivos as $d){
                                $nivel = $dbm->getOneByParametersRepositorio('CeEventopornivel', [
                                    'nivelid' => $alumno['nivelid'],
                                    'eventoid' => $d->getEventoid()
                                ]);
                                if($nivel){
                                    $diafestivo = true;
                                }
                            }
                            if(!$diafestivo){
                                $asis = $dbm->getOneByParametersRepositorio('CeAsistencia', [
                                    'profesorpormateriaplanestudioid' => $p['profesorpormateriaplanestudiosid'],
                                    'alumnoporcicloid' => $alumno['alumnoporcicloid'],
                                    'hora' => $horario->getHorainicio(),
                                    'fecha' => new \Datetime($fecha)
                                ]);
                                $tipo = $dbm->getRepositorioById('CeTipoasistencia', 'tipoasistenciaid', $data['tipoasistenciaid']);
                                $estatus = $dbm->getRepositorioById('CeEstatusinasistencia', 'estatusinasistenciaid', $data['estatusinasistenciaid'] ? $data['estatusinasistenciaid'] : 1);
                                if(!$asis){
                                    $asis = new CeAsistencia();
                                    $asis->setAlumnoporcicloid($dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno['alumnoporcicloid']));
                                    $asis->setProfesorpormateriaplanestudioid($dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'profesorpormateriaplanestudiosid', $p['profesorpormateriaplanestudiosid']));
                                    $asis->setMotivocancelacioninasistencia($data['motivo']);
                                    $asis->setFecha(new \Datetime($fecha));
                                    $asis->setFechamodificacion(new \Datetime());
                                    $asis->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']));
                                    $asis->setHora($horario->getHorainicio());
                                    $asis->setTipoasistenciaid($tipo);
                                    $asis->setEstatusinasistenciaid($estatus);
                                    $dbm->saveRepositorio($asis);
                                } else {
                                    $asis->setTipoasistenciaid($tipo);
                                    $asis->setEstatusinasistenciaid($estatus);
                                    $asis->setMotivocancelacioninasistencia($data['motivo']);
                                    $asis->setFechamodificacion(new \Datetime());
                                    $asis->setUsuarioid($dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']));
                                    $dbm->saveRepositorio($asis);
                                }
                            }
                        }
                    }                     
                }
            }

			$dbm->getConnection()->commit();
			return new View("Se ha guardado el registro", Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
    }
    
    /**
	 * @Rest\Get("/api/Asistencia/ReporteAsistencia/" , name="getReporteAsistencia")
	 */
    public function descargarReporteAsistencia() {
        $datos=$_REQUEST;
        $filtros=array_filter($datos);
        $encabezado = $filtros['encabezado'];
        $dbm=new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $arraytotals = [];
        
        $asistencias = $dbm->GetAsistenciasDetail(["1457451","1457453","1457459","1457455","1457457"]);

        $respuesta = $this->asistencias($filtros['datos'], $dbm);
        $path = str_replace('app', '', $this->get('kernel')->getRootDir());
        $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";
        $arrestatus = [['title'=>'Total de asistencias','key'=> 'tas'],
        ['title'=>'Total de inasistencias','key'=> 'tis'],
        ['title'=>'Total de retardos','key'=> 'trs'],
        ['title'=>'Total de justificadas','key'=> 'tjs'],
        ['title'=>'Total de canceladas','key'=> 'tcs']];

        if($respuesta['error']) {
            return new View($respuesta['mensaje'], Response::HTTP_PARTIAL_CONTENT);
        }

        foreach($respuesta['alumnos'] as $f) {
            $asistenciaids=array_values(array_unique(array_column($f['asistencias'], 'asistenciaid')));
            $asistencias = $dbm->GetAsistenciasDetail($asistenciaids)[0];

            foreach($arrestatus as $e) {
                $valor = $asistencias[$e['key']];
                $arraytotals[] = [
                    "x" => $f['matricula'] . ' - ' . $f['nombrealumno'],
                    "y" => $e['title'],
                    "val" => $valor
                ];
            }

            foreach($f['asistencias'] as $key=>$a) {
                $obj = array(
                    "x" => $f['matricula'] . ' - ' . $f['nombrealumno'],
                    "y" => $respuesta['fechas'][$key],
                    "val" => $path . $this->imagen($a['tipoasistenciaid'], $a['estatusinasistenciaid'])
                );
                $arraydatos[] = $obj;
            }
        }
        $report="ReporteAsistencias";
        $filebase="$report-".(rand()%10000);
        $pdf=new LDPDF($this->container, $report, $filebase, ['driver'=>'json', 'data_file'=>$filebase, 'json_query'=>'""'], [], ['xlsx']);
        $data = array("prof" => $arraydatos, "nivel" => $encabezado['nivel'], "grado" => $encabezado['grado'], "estatus" => $arraytotals,
            "grupo" => $encabezado['grupo'], "materia" => $encabezado['materia'], "maestro" => $encabezado['maestro'], "titular" => "SI");
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
    }

    private function fileWrite($path, $data){
		$file=LDPDF::fileRead($path);
		LDPDF::fileWrite($file, $data);
		LDPDF::fileRelease($file);
		return true;
    }

    public function dia ($val) {
        switch (intval($val)) {
            case 1:
                $dia = "Lunes";
                break;
            case 2:    
                $dia = "Martes";
            break;
            case 3:
                $dia = "Miercoles";
            break;
            case 4:
                $dia = "Jueves";
            break;
            case 5:
                $dia = "Viernes";
            break;
        }
        return $dia;
    }
    
    public function imagen ($val, $estatus) {
        if ($estatus == 2 || $estatus == 3) {
            switch (intval($estatus)) {
                case 2:    
                    $img = "cancelada.png";
                break;
                case 3:
                    $img = "justificada.png";
                break;
            }
        } else {
            switch (intval($val)) {
                case 1:
                    $img = "success.png";
                    break;
                case 2:    
                    $img = "fail.png";
                break;
                case 3:
                    $img = "clock.png";
                break;
            }
        }
        return $img;
    }
}
