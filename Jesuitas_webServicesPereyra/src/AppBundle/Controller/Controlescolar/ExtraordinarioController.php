<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAcuerdoextraordinario;
use AppBundle\Entity\CeExtraordinario;
use AppBundle\Entity\CjDocumentoporpagar;
use AppBundle\Entity\CeMotivoextraordinarioporextraordinario;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;

/**
 * @author Mariano
 */
class ExtraordinarioController extends FOSRestController{
	private $DBM=false;
    private static $MAX_SCORE=10;
    private static $MAX_ATTEMPT=3;
    private static $STATUSID_PE=1;
    private static $STATUSID_AG=3;
    private static $STATUSID_AP=4;
    private static $STATUSID_RP=5;

    /**
     * Retorna arreglo de filtros iniciales
     * @Rest\Get("/api/Controlescolar/Extraordinario", name="indexExtraordinario")
     */
    public function indexExtraordinario()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $planestudio = $dbm->getRepositorios('CePlanestudios');
            $semestre = $dbm->getRepositoriosById('CeSemestre','activo',1);
            $motivoextra = $dbm->getRepositoriosById('CeMotivoextraordinario','activo',1);
            $periodos = [];
            $hoy = new \DateTime();
            $today = $hoy->format('d-m-Y');
            $periodosregularizacion = $dbm->getRepositoriosById('CePeriodoregularizacion', 'activo', 1);
            $materia = array();
            foreach ($planestudio as $p) {
                $materia = array_merge(
                    $materia,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid()]
                    )
                );
            }
            $tipo = $dbm->getRepositoriosById('CeTipoextraordinario', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('CeEstatusextraordinario', 'activo', 1);

            $agendas = $dbm->getRepositoriosById('CeAgendaextraordinario','estatusagendaextraordinarioid',1);
            $arrayagenda = array();
            foreach ($agendas as $agenda){
                $fechaagenda = $agenda->getFechainicio()->format('d-m-Y');
                if(new \Datetime($fechaagenda) > new \Datetime($today)) {
                    $arrayagenda[]=[
                        "agendaextraordinarioid"=>$agenda->getAgendaextraordinarioid(),
                        "nombre"=>$agenda->getFechainicio()->format('d/m/Y') ." - ". $agenda->getHorainicio() ." - ". $agenda->getProfesorid()->getNombre()." ". $agenda->getProfesorid()->getApellidopaterno()." ".  $agenda->getProfesorid()->getApellidomaterno(),
                        "tipoextraordinarioid"=>$agenda->getTipoextraordinarioid()->getTipoextraordinarioid(),
                        "periodoregularizacionid"=>$agenda->getPeriodoregularizacionid()->getPeriodoregularizacionid(),
                        "materiaporplanestudioid"=>$agenda->getMateriaporplanestudioid()->getMateriaporplanestudioid(),
                        "fechainicio" => $agenda->getFechainicio()->format('d/m/Y')
                    ];
                }
            }
            
            foreach($periodosregularizacion as $key=>$periodo) {
                $disponible = false;
                $fechainicio = $periodo->getFechainicio()->format('d-m-Y');
                $fechaperiodo = $periodo->getFechafin()->format('d-m-Y');
                if(new \Datetime($fechaperiodo) >= new \Datetime($today)) {
                    array_push($periodos, $periodo);
                }
            }

            return new View([
                "hoy" => $hoy, 
                "semestre"=>$semestre,
                "ciclo"=>$ciclo,
                "nivel"=>$nivel,
                "grado"=>$grado,
                "planestudio"=>$planestudio,
                "materia"=>$materia,
                "periodo"=>$periodos,
                "tipo"=>$tipo,
                "estatus"=>$estatus,
                "agenda"=>$arrayagenda,
                "motivoextraordinario" => $motivoextra
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna un arreglo de alumnos que son candidatos a extraordinarios con los motivos de
     * Ultimo parcial, Faltas, Calificación reprobatoria
     * @Rest\Get("/api/Controlescolar/Extraordinario/Asignar", name="AsignarAlumnoExtraordinario")
     */
    public function AsignarAlumnoExtraordinario()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $fechaactual =  new \DateTime();
            $alumnosasignados = [];
            $materias = [];
            $asignadoid = 0;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            //Obtenemos los periodos de acuerdo al grado seleccionado
            $periodo = $dbm->BuscarPeriodoEvaluacion($filtros);
            $periodos = $dbm->getRepositoriosById('CePeriodoevaluacion', 'conjuntoperiodoevaluacionid', $periodo[0]['conjuntoperiodoevaluacionid']);
            //Obtenemos el ultimo periodo del conjunto de periodos
            $ultimoperiodo = end($periodos);
            if(!$ultimoperiodo){
                return new View("No se han creado los periodos de evaluación del grado seleccionado en el ciclo seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }
            //Verificamos que la fecha actual sea menor a la del ultimo periodo
            if($fechaactual < $ultimoperiodo->getFechapublicaciondefinitiva()){
                return new View("Este proceso solamente se puede realizar despues de la fecha de publicación definitiva del ultimo periodo ", Response::HTTP_PARTIAL_CONTENT);
            }
            //Obtenemos el plan de estudio, alumnos y materias por el grado seleccionado
            if($filtros['nivelid']  == '4') {
                $arrayplanestudio = $dbm->PlanEstudioPorCicloGrado($filtros);
                foreach($arrayplanestudio as $pe) {
                    $arraymaterias = $dbm->getRepositoriosById('CeMateriaporplanestudios', 'planestudioid', $pe->getPlanestudioid());
                    //FALTA PONER EL PUNTO DE PASE
                    foreach($arraymaterias as $m) {
                        if(!in_array($m, $materias)){
                            array_push($materias, $m);
                        }
                    }
                }
            } else {
                $planestudio = $dbm->PlanEstudioPorCicloGrado($filtros)[0];
                $materias = $dbm->getRepositoriosById('CeMateriaporplanestudios', 'planestudioid', $planestudio->getPlanestudioid());
            }
            foreach($materias as $materia) {
                $alumnos = $dbm->getReprobadosporPeriodoMateria($ultimoperiodo->getPeriodoevaluacionid(), $materia->getMateriaporplanestudioid());
                foreach($alumnos as $key=>$alumno) {
                    $motivosextraordinario = "";
                    $puntopase = $materia->getPlanestudioid()->getPuntopase();
                    $alumno['tallercurricularid']=9;
                    $alumno['motivos'] = [];
                    if(in_array("1", $filtros['motivoextraordinarioid'])) {
                        if($alumno['extraparcial'] == "1") {
                            $alumno['ultimoparcial'] = 1;
                            array_push($alumno['motivos'], ["motivoid" => 1, "motivoextraordinario" => "Último parcial"]);
                            $motivosextraordinario = $motivosextraordinario . "Último parcial";
                        }
                    }
                    if($alumno['extrafinal'] == "1") {
                        if(in_array("2", $filtros['motivoextraordinarioid'])) {
                            $alumno['promedio'] = 1;
                            array_push($alumno['motivos'], ["motivoid" => 2, "motivoextraordinario" => "Promedio"]);
                            $motivosextraordinario = $motivosextraordinario . ($motivosextraordinario !== "" ? ',' : '') . " Promedio";
                        }
                    }


                        $faltasalumno = intval($alumno['totalfaltas'] ? $alumno['totalfaltas'] : 0);
                        $faltaspermitidas=$materia->getHorasporsemana()*2;
                        $x = $materia->getHorasporsemana();
                        $paramformula = $dbm->getRepositorioById('Parametros', 'nombre', 'FormulaFaltasPermitidas');
                        $formula = $paramformula ? $paramformula->getValor() : null;
                        if(!$formula) {
                            return new view('No se ha encontrado la formula de faltas permitidas', Response::HTTP_PARTIAL_CONTENT);
                        }
                        eval('$total= '.$formula.';');
                        $faltaspermitidas = $total;
                        if ($faltasalumno > $faltaspermitidas){
                            if(in_array("3", $filtros['motivoextraordinarioid'])) {
                                $alumno['faltas'] = 1;
                                array_push($alumno['motivos'], ["motivoid" =>3, "motivoextraordinario" => "Faltas"]);
                                $motivosextraordinario = $motivosextraordinario .($motivosextraordinario !== "" ? ',' : '') . " Faltas";
                            }
                        }
                    
                    $extraordinario = $dbm->getOneByParametersRepositorio('CeExtraordinario', 
                    [
                        "profesorpormateriaplanestudiosid" => $alumno['profesorpormateriaplanestudiosid'], 
                        "alumnoid" => $alumno['alumnoid']
                    ]);

                    if($extraordinario) {
                        $alumno['extraordinario'] = 1;
                    }
                

                $alumno['motivosextraordinario'] = $motivosextraordinario;
                if(($alumno['faltas'] || $alumno['ultimoparcial'] || $alumno['promedio']) && !$alumno['extraordinario']) {
                    $asignadoid = $asignadoid + 1;
                    $alumno['asignadoid'] = $asignadoid;
                    array_push($alumnosasignados, $alumno);
                }
              }
            }
            if(!$alumnosasignados) {
                return new View("No se encontró ningun registro", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($alumnosasignados, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

        /**
     * Retorna un arreglo de periodos de regularización
     * @Rest\Get("/api/Controlescolar/Extraordinario/Periodos", name="GetPeriodos")
     */
    public function GetPeriodos()
    {
        try{
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $hoy = new \DateTime();
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if(!$filtros['cicloid']) {
                $periodos = $dbm->getByParametersRepositorios('CePeriodoregularizacion', 
                array("activo" => 1));
            } else {
                $periodos = $dbm->getByParametersRepositorios('CePeriodoregularizacion', 
                array("activo" => 1, "cicloid" => $filtros['cicloid']));
            }
            return new View(array("periodos"=> $periodos, "hoy"=> $hoy), Response::HTTP_OK);

        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna arreglo de Extraordinario en base a los parametros enviados
     * @Rest\Post("/api/Controlescolar/Extraordinario/Filtrar", name="getExtraordinario")
     */
    public function getExtraordinario()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            array_filter($filtros);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $extraordinarios = $dbm->BuscarExtraordinario($filtros);
            foreach ($extraordinarios as $key=>$extraordinario){
                $acuerdo=null;
                if (isset($extraordinario["acuerdoextraordinarioid"])){
                    $acuerdo=[
                        "acuerdoextraordinarioid"=>$extraordinario["acuerdoextraordinarioid"],
                        "intento"=>$extraordinario["intento"],
                        "estatusacuerdo"=>$extraordinario["estatusacuerdo"],
                        "tipoextraordinarioid"=>$extraordinario["tipoextraordinarioid"],
                        "tipo"=>$extraordinario["tipo"],
                        "periodoregularizacionid"=>$extraordinario["periodoregularizacionid"],
                        "periodo"=>$extraordinario["periodo"],
                        "acordadopor"=>$extraordinario["acordadopor"],
                        "agendaextraordinarioid"=>$extraordinario["agendaextraordinarioid"],
                        "calificacion"=>$extraordinario["calificacion"],
                        "calificacionfinal"=>$extraordinario["calificacionfinal"]
                    ];
                       
                }
                
                foreach ($extraordinarios as $name => $info) {
                    $extraordinariokey=false;
                    if ( $info["extraordinarioid"]==$extraordinario["id"]) {
                        $extraordinariokey=$name;
                        break;
                    }
                }
                //$extraordinariokey = array_search($extraordinario["id"], array_column($extraordinarios, 'extraordinarioid'));
                if ($extraordinariokey=== false){
                    unset($extraordinarios[$key]["id"]);
                    $extraordinarios[$key]["extraordinarioid"]=$extraordinario["id"];
                    $extraordinarios[$key]["acuerdos"]=[];
                    $llave=$key;
                }else{
                    $llave=$extraordinariokey;
                    unset($extraordinarios[$key]);
                }

                if ($extraordinario["acuerdoextraordinarioid"]) {
                    $acutempt = $dbm->UltimoAcuerdoPorAgenda($extraordinario["id"],true);
                    if ($acutempt) {
                        $extraordinarios[$llave]['ultimotipo'] = $acutempt[0]['tipoextraordinario'];
                        $extraordinarios[$llave]['ultimocalificacion'] = $acutempt[0]['calificacion'];
                        $extraordinarios[$llave]['ultimocalificacionfinal'] = $acutempt[0]['calificacionfinal'];
                    }
                }

                
                if (isset($extraordinario["acuerdoextraordinarioid"])){
                    $extraordinarios[$llave]["op".$extraordinario["intento"]."tipo"]=$extraordinario["tipo"];
                    $extraordinarios[$llave]["op".$extraordinario["intento"]."real"]=$extraordinario["calificacion"];
                    $extraordinarios[$llave]["op".$extraordinario["intento"]."definitiva"]=$extraordinario["calificacionfinal"];
                }
                $periodos = $dbm->getByParametersRepositorios('CeCalificacionperiodoporalumno', [
                    'materiaid' => $extraordinarios[$key]["materiaid"],
                    'alumnoid' => $extraordinarios[$key]["alumnoid"]
                ]);

                if(count($periodos) > 0){
                    $periodofinal = end($periodos);
                    $extraordinarios[$llave]["calificacionultimoparcial"] = $periodofinal->getCalificacion();
                    $promedio = 0;

    
                    foreach($periodos as $periodo){
                        $promedio = $promedio + $periodo->getCalificacion();
                    }
    
                    $extraordinarios[$llave]["promedio"] = $periodofinal->getCalificacionfinalporperiodoalumno()->getCalificacion();
                }

                $arrmotivos = $dbm->getByParametersRepositorios('CeMotivoextraordinarioporextraordinario', [
                    'extraordinarioid' => $extraordinarios[$key]["extraordinarioid"]
                ]);
                
                $motivosextra = "";
                foreach($arrmotivos as $keym=>$m) {
                    $motivosextra = $motivosextra . ($keym>0 ? ', ' : '') . $m->getMotivoextraordinarioid()->getNombre(); 
                }
                if($motivosextra) {
                    $extraordinarios[$llave]["motivo"] = $motivosextra;
                }

                array_push($extraordinarios[$llave]["acuerdos"],$acuerdo);

                unset($extraordinarios[$key]["acuerdoextraordinarioid"]);
                unset($extraordinarios[$key]["intento"]);
                unset($extraordinarios[$key]["estatusacuerdo"]);
                unset($extraordinarios[$key]["tipo"]);
                unset($extraordinarios[$key]["periodo"]);
                unset($extraordinarios[$key]["acordadopor"]);
                unset($extraordinarios[$key]["tipoextraordinarioid"]);
                unset($extraordinarios[$key]["periodoregularizacionid"]);
                unset($extraordinarios[$key]["agendaextraordinarioid"]);
                unset($extraordinarios[$key]["calificacion"]);
                unset($extraordinarios[$key]["calificacionfinal"]);




                
            }
            $extraordinarios = array_values($extraordinarios);


            if (!$extraordinarios) {
                return new View("No se encontro ningun registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($extraordinarios, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    
    /**
     * @Rest\Post("/api/Controlescolar/Extraordinario/Asignar", name="AsignarExtrarordinario")
     */
    public function AsignarExtrarordinario()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $arrayalumno = [];
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            foreach ($data['asignados'] as $alumno){
                $extraordinario=new CeExtraordinario();
                $extraordinario->setAlumnoid($alumno['alumnoid'] ?  
                    $dbm->getRepositorioById("CeAlumno","alumnoid",$alumno['alumnoid']) : null);
                $extraordinario->setProfesorpormateriaplanestudiosid($alumno['profesorpormateriaplanestudiosid'] ?
                    $dbm->getRepositorioById("CeProfesorpormateriaplanestudios","profesorpormateriaplanestudiosid",$alumno['profesorpormateriaplanestudiosid']) : null);
                $extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById("CeEstatusextraordinario","estatusextraordinarioid",1));
                $dbm->saveRepositorio($extraordinario);

                foreach ($alumno['motivos'] as $m){
                    $motivo=new CeMotivoextraordinarioporextraordinario();
                    $motivo->setExtraordinarioid($extraordinario);
                    $motivo->setMotivoextraordinarioid($dbm->getRepositorioById("CeMotivoextraordinario","motivoextraordinarioid",$m['motivoid']));
                    $dbm->saveRepositorio($motivo);
                }
                $params = [
                    "materiaporplanestudioid" => $alumno['materiaporplanestudioid']
                ];
                $actividad=[
                    "tipoactividadid"=>22,
                    "usuarioorigenid"=>$data['usuarioid'],
                    "usuariodestinoid"=>$alumno['usuarioid']
                ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), $params);
            }
            $dbm->getConnection()->commit();
            return new View("Se han asignado los extraordinarios a los alumnos seleccionados", Response::HTTP_OK);
        }catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Extraordinario/Acuerdo" , name="saveExtraordinario")
     */
    public function saveExtraordinario()
    {
        try {
            $permiteagendar = false;
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hoy = new \DateTime();
            $extraordinario=$dbm->getRepositorioById("CeExtraordinario","extraordinarioid",$data["extraordinarioid"]);
            $entorno = ENTORNO;
            $fechaHoy=new \DateTime();
            $dbm->getConnection()->beginTransaction();
            $acuerdos = $dbm->BuscarExtraordinarioporacuerdo(["cicloid"=>$data["cicloid"],"alumnoid"=>$extraordinario->getAlumnoid()->getAlumnoid(),"periodoregularizacionid"=>$data["periodoregularizacionid"]]);
            $extid=$data["extraordinarioid"];
            foreach ($acuerdos as $ac) {
                if ($ac['extraordinarioid'] == $data["extraordinarioid"]) {
                    $permiteagendar = true;
                    break;
                }
            }

            if ($entorno == 2) {
                $mpe = $dbm->getRepositorioById("CeMateriaporplanestudios","materiaporplanestudioid",$data["materiaporplanestudioid"]);

                $acuerdospermitidos=$dbm->getRepositorioById("Parametros","nombre","AcuerdosExtra")->getValor();
    
                if (!$permiteagendar && count($acuerdos)>=$acuerdospermitidos) {
                    return new View("Solamente se pueden hacer acuerdos de $acuerdospermitidos materia(s) para un periodo de regularización.", Response::HTTP_PARTIAL_CONTENT);
                }


                    if ($data["agendaextraordinarioid"]) {
                        $agenda=$dbm->getRepositoriosById("CeAgendaextraordinario","agendaextraordinarioid",$data["agendaextraordinarioid"]);
                        $extid=$data["extraordinarioid"];
                        $exttipid=$data["tipoextraordinarioid"];
                        list($statusA,$acuerdos)=$this->getAcuerdosByExtraordinarioId($extid);

                        try{                
                            $acuerdo=$this->getAcuerdoObject(array(
                                "agendaextraordinarioid"=>null,
                                "estatusextraordinarioid"=>self::$STATUSID_AG,
                                "usuarioid"=>$data["usuarioid"],
                                "extraordinarioid"=>$data["extraordinarioid"],
                                "tipoextraordinarioid"=>$data["tipoextraordinarioid"],
                                "periodoregularizacionid"=>$data["periodoregularizacionid"],
                                "intento"=>(sizeof($acuerdos) + 1),
                                "pagado"=>0
                            ));
                            $dbm=$this->getDM();
                            $extra=$acuerdo->getExtraordinarioid();
                                        $alumno=$extra->getAlumnoid();
                                        $extraid=$extra->getExtraordinarioid();
                                        $alumnoid=$alumno->getAlumnoid();
                            if(!$this->validLimit($acuerdos) && $entorno == 1){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"Excedio numero de intentos."); }
                
                            foreach ($agenda as $agendahorario) {
                                if ($hoy < $agendahorario->getFechainicio()) {
                                    $agendadisp = $agendahorario;
                                    break;
                                }
                            }
                
                            foreach ($agenda as $agendahorario) {
                                if ($hoy <  $agendahorario->getFechainicio()) {
                                    array_push($agendadisp,$agendahorario);
                                }
                            }
                
                            if(!$agendadisp){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No hay agendas disponibles."); }
                
                            if(sizeof($agendadisp)<1){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No hay agendas disponibles."); }
                            $tagid=$agendadisp;
                            if($exttipid==1){
                                $arrayagenda = array();
                                $agendatmp = array(
                                    "agendaextraordinarioid" => $agendadisp->getAgendaextraordinarioid(),
                                    "fechainicio" =>  $agendadisp->getFechainicio(),
                                    "horainicio" =>   $agendadisp->getHorainicio(),
                                    "horafin" => $agendadisp->getHorafin()
                                );
                                $arrayagenda[0] = $agendatmp;
                                $acuerdos=$dbm->getEAcuerdoextraordinarioByAlumno($alumnoid,$exttipid);
                                $tagid=$this->getValidAgendaWithDT($arrayagenda,$acuerdos);
                            }
                            if(!$tagid){ 
                                return new View("No hay cupo en las agendas disponibles o los horarios son incompatibles", Response::HTTP_PARTIAL_CONTENT);

                            }
                            if($exttipid==1){
                                $agenda=$dbm->getRepositorioById("CeAgendaextraordinario","agendaextraordinarioid",$tagid['agendaextraordinarioid']);
                            } else {
                                $agenda=$dbm->getRepositorioById("CeAgendaextraordinario","agendaextraordinarioid",$tagid->getAgendaextraordinarioid());
                                $cupodisp = ($this->getAgendaCDisponibleById($tagid->getAgendaextraordinarioid())>0);
                                if (!$cupodisp) {
                                    return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No hay cupo disponible en la agenda.");
                                }
                            }
                            $acuerdosagendas = $dbm->getRepositoriosById("CeAcuerdoextraordinario","agendaextraordinarioid",$agenda->getAgendaextraordinarioid());
                            $acuerdo->setAgendaextraordinarioid($agenda);

                            $subconceptonivel = $dbm->getOneByParametersRepositorio('CjExtraordinariosubconceptopormateria',
                            array('materiaid' => $mpe->getMateriaid()->getMateriaid()));
                            if (!$subconceptonivel) {
                                return new View("No se ha configurado un subconcepto para la materia del alumno.",Response::HTTP_PARTIAL_CONTENT);
                            }   
                            $hijopersonal = $dbm->getRepositorioById('CeAlumnoporpersonal', 'alumnoid', $data['alumnoid']);
                            if(!$hijopersonal){
                                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid']);
                                $nombre = $alumno->getPrimernombre() . ' ' . $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno();
                            if ($alumno->getHijopersonal()) {
                                    $hijopersonal = true;
                                }
                            }
                            $subconceptoentity=$subconcepto;
                            if($subconceptonivel){
                                $subconceptopornivel = $dbm->getOneByParametersRepositorio('CjSubconceptopornivel',
                                array('activo' => 1, 'subconceptoid' => $subconceptonivel->getSubconceptoid()->getSubconceptoid(), 'nivelid' => $data['nivelid']));
                                
                                $subconceptoentity=$subconceptonivel->getSubconceptoid();
                                $fechalimite=$subconceptonivel->getFechalimitepago();
                
                                if($subconceptopornivel) {
                                    $total=$subconceptopornivel->getImporte();
                                } else {
                                    $total=$subconceptonivel->getSubconceptoid()->getImporte();
                                }
                            }
                            $descuento=$hijopersonal ? ($porcentaje*$total/100) : 0;
                            $importe=$total-$descuento;
                            if(!$subconceptoentity){
                                return new View("No se ha configurado el subconcepto.",Response::HTTP_PARTIAL_CONTENT);
                            }
                
                            $fechaLimiteFinal=$fechalimite;//new \DateTime($fechaHoy->format("Y-m-{$fechalimitedia}"));
                            $documentoNombre=$fechaLimiteFinal->format("Ymd")."G";
                            $fechalimitepago = $fechaLimiteFinal;
                            $fechaprontopago = $fechaLimiteFinal;
                            $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                            $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
                            $documentoporpagar = new CjDocumentoporpagar();
                            $documentoporpagar->setDocumentoid($documento);
                            $documentoporpagar->setSubconceptoid($subconceptoentity);
                            $documentoporpagar->setPagoestatusid($dbm->getRepositorioById("CjPagoestatus","pagoestatusid",1));
                            $documentoporpagar->setAlumnoid($data['alumnoid'] ? $dbm->getRepositorioById("Cealumno","alumnoid",$data['alumnoid']) : null);
                            $documentoporpagar->setCicloid($data['cicloid']  ? $dbm->getRepositorioById("Ciclo","cicloid",$data['cicloid']) : null);
                            $documentoporpagar->setGradoid($dbm->getRepositorioById("Grado","gradoid",$data['gradoid']));
                            $documentoporpagar->setImporte($importe);
                            $documentoporpagar->setSaldo($importe);
                            $documentoporpagar->setConcepto("Extraordinario " . $mpe->getMateriaid()->getNombre());
                            $documentoporpagar->setFechalimitepago($fechalimitepago);
                            $documentoporpagar->setFechacreacion($fechaHoy);
                            $documentoporpagar->setFechaprontopago($fechaprontopago);
                            $documentoporpagar->setDocumento($documentoNombre);
                            $dbm->saveRepositorio($documentoporpagar);
                            $acuerdo->setDocumentoporpagarid($documentoporpagar);                            

                            $extraordinario=$dbm->getRepositorioById("CeExtraordinario","extraordinarioid",$data['extraordinarioid']);
                            $extraordinario->setEstatusextraordinarioid($acuerdo->getEstatusextraordinarioid());
                            $dbm->getConnection()->beginTransaction();
                            $dbm->saveRepositorio($extraordinario);
                            $dbm->saveRepositorio($acuerdo);
                            $dbm->getConnection()->commit();

                            $tmp = $agenda->getProfesorid()->getProfesorid();
                            $usuarioprofesor =  $dbm->getRepositorioById('Usuario', 'profesorid', $agenda->getProfesorid()->getProfesorid());
                            $dbm->getConnection()->commit();
                            $entidad=$extraordinario;
                            $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                            if ($usuariodestino){
                                $params = [
                                    "Matrícula" => $usuariodestino->getAlumnoid()->getMatricula(),
                                    "Alumno" => ($usuariodestino->getAlumnoid()->getApellidopaterno(). ' ' . 
                                    $usuariodestino->getAlumnoid()->getApellidomaterno(). ' ' .
                                    $usuariodestino->getAlumnoid()->getPrimernombre()),
                                    "Materia" => $agenda->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                                    "ExtraordinarioFecha" => $agenda->getFechainicio()->format("d-m-Y")
                                ];
                                $usuariodestino=$usuariodestino->getUsuarioid();
                                $actividad=[
                                    "tipoactividadid"=>24,
                                    "usuariodestinoid"=>$usuariodestino
                                ];
                                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), $params);
                            }
                            return new View("Se ha agendado el extraordinario seleccionado.", Response::HTTP_OK);
                        }catch(\Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST,$e->getMessage()); }
                    }
                    
            } else {
                $mpe = $dbm->getRepositorioById("CeMateriaporplanestudios","materiaporplanestudioid",$data["materiaporplanestudioid"]);
                $acuerdospermitidos=$dbm->getRepositorioById("Parametros","nombre","AcuerdosExtra")->getValor();
                $acuerdos = $dbm->BuscarExtraordinarioporacuerdo(["cicloid"=>$data["cicloid"],"alumnoid"=>$extraordinario->getAlumnoid()->getAlumnoid(),"periodoregularizacionid"=>$data["periodoregularizacionid"]]);
                if (count($acuerdos)>=$acuerdospermitidos) {
                    return new View("Solamente se pueden hacer acuerdos de $acuerdospermitidos materias  para un periodo de regularización.", Response::HTTP_PARTIAL_CONTENT);
                }

            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $data['pagado'] = ($data['pagado'] ? true: false);
            $acuerdo = $hydrator->hydrate(new CeAcuerdoextraordinario(), $data);
            if ($entorno == 2) {
                $acuerdo->setEstatusextraordinarioid($dbm->getRepositorioById("CeEstatusextraordinario","estatusextraordinarioid",3));
                $extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById("CeEstatusextraordinario","estatusextraordinarioid",3));
            } else {
                $acuerdosporextra = 0;
                list($statusA,$acuerdosporextra)=$this->getAcuerdosByExtraordinarioId($extid);
                $acuerdo->setIntento((count($acuerdosporextra) + 1));
                $acuerdo->setEstatusextraordinarioid($dbm->getRepositorioById("CeEstatusextraordinario","estatusextraordinarioid",2));
                $extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById("CeEstatusextraordinario","estatusextraordinarioid",2));
            }
            $mpe = $dbm->getRepositorioById("CeMateriaporplanestudios","materiaporplanestudioid",$data["materiaporplanestudioid"]);

            $subconceptonivel = $dbm->getOneByParametersRepositorio('CjExtraordinariosubconceptopormateria',
            array('materiaid' => $mpe->getMateriaid()->getMateriaid()));
            if (!$subconceptonivel) {
                return new View("No se ha configurado un subconcepto para la materia del alumno.",Response::HTTP_PARTIAL_CONTENT);
            } 
            $hijopersonal = $dbm->getRepositorioById('CeAlumnoporpersonal', 'alumnoid', $data['alumnoid']);
            if(!$hijopersonal){
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid']);
                $nombre = $alumno->getPrimernombre() . ' ' . $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno();
            if ($alumno->getHijopersonal()) {
                    $hijopersonal = true;
                }
            }
            $subconceptoentity=$subconcepto;
            if($subconceptonivel){
                $subconceptopornivel = $dbm->getOneByParametersRepositorio('CjSubconceptopornivel',
                array('activo' => 1, 'subconceptoid' => $subconceptonivel->getSubconceptoid()->getSubconceptoid(), 'nivelid' => $data['nivelid']));
                
                $subconceptoentity=$subconceptonivel->getSubconceptoid();
                $fechalimite=$subconceptonivel->getFechalimitepago();

                if($subconceptopornivel) {
                    $total=$subconceptopornivel->getImporte();
                } else {
                    $total=$subconceptonivel->getSubconceptoid()->getImporte();
                }
            }
            $descuento=$hijopersonal ? ($porcentaje*$total/100) : 0;
            $importe=$total-$descuento;
            if(!$subconceptoentity){
                return new View("No se ha configurado el subconcepto.",Response::HTTP_PARTIAL_CONTENT);
            }

            $fechaLimiteFinal=$fechalimite;//new \DateTime($fechaHoy->format("Y-m-{$fechalimitedia}"));
            $documentoNombre=$fechaLimiteFinal->format("Ymd")."G";
            $fechalimitepago = $fechaLimiteFinal;
            $fechaprontopago = $fechaLimiteFinal;
            $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
            $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
            $documentoporpagar = new CjDocumentoporpagar();
            $documentoporpagar->setDocumentoid($documento);
            $documentoporpagar->setSubconceptoid($subconceptoentity);
            $documentoporpagar->setPagoestatusid($dbm->getRepositorioById("CjPagoestatus","pagoestatusid",1));
            $documentoporpagar->setAlumnoid($data['alumnoid'] ? $dbm->getRepositorioById("Cealumno","alumnoid",$data['alumnoid']) : null);
            $documentoporpagar->setCicloid($data['cicloid']  ? $dbm->getRepositorioById("Ciclo","cicloid",$data['cicloid']) : null);
            $documentoporpagar->setGradoid($dbm->getRepositorioById("Grado","gradoid",$data['gradoid']));
            $documentoporpagar->setImporte($importe);
            $documentoporpagar->setSaldo($importe);
            $documentoporpagar->setConcepto("Extraordinario " . $mpe->getMateriaid()->getNombre());
            $documentoporpagar->setFechalimitepago($fechalimitepago);
            $documentoporpagar->setFechacreacion($fechaHoy);
            $documentoporpagar->setFechaprontopago($fechaprontopago);
            $documentoporpagar->setDocumento($documentoNombre);
            $dbm->saveRepositorio($documentoporpagar);
            $acuerdo->setDocumentoporpagarid($documentoporpagar);

            $dbm->saveRepositorio($extraordinario);
            $dbm->saveRepositorio($acuerdo);

            $dbm->getConnection()->commit();

            $entidad=$extraordinario;
            $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
            if ($usuariodestino && $agenda){
                $params = [
                    "Matrícula" => $usuariodestino->getAlumnoid()->getMatricula(),
                    "Alumno" => ($usuariodestino->getAlumnoid()->getApellidopaterno(). ' ' . 
                    $usuariodestino->getAlumnoid()->getApellidomaterno(). ' ' .
                    $usuariodestino->getAlumnoid()->getPrimernombre()),
                    "Materia" => $mpe->getMateriaid()->getNombre(),
                    "ExtraordinarioFecha" => $agenda->getFechainicio()->format("d-m-Y")
                ];
                $usuariodestino=$usuariodestino->getUsuarioid();
                $actividad=[
                    "tipoactividadid"=>23,
                    "usuariodestinoid"=>$usuariodestino
                ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), $params);
            }
            
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Controlescolar/Extraordinario/Acuerdo" , name="updateExtraordinario")
     */
    public function updateExtraordinario()
    {
        try {
            $hoy = new \DateTime();
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $extraordinario=$dbm->getRepositorioById("CeExtraordinario","extraordinarioid",$data["extraordinarioid"]);
            $acuerdos = $dbm->BuscarExtraordinarioporacuerdo(["cicloid"=>$data["cicloid"],"alumnoid"=>$extraordinario->getAlumnoid()->getAlumnoid(),"periodoregularizacionid"=>$data["periodoregularizacionid"]]);
            $entorno = ENTORNO;
            $acuerdoextraordinario=$dbm->getRepositorioById("CeAcuerdoextraordinario","acuerdoextraordinarioid",$data["acuerdoextraordinarioid"]);
            $mpe = $dbm->getRepositorioById("CeMateriaporplanestudios","materiaporplanestudioid",$data["materiaporplanestudioid"]);

            foreach ($acuerdos as $ac) {
                if ($ac['extraordinarioid'] == $data["extraordinarioid"]) {
                    $permiteagendar = true;
                    break;
                }
            }

            if ($entorno == 2) {
                    $acuerdospermitidos=$dbm->getRepositorioById("Parametros","nombre","AcuerdosExtra")->getValor();
    
                    if (!$permiteagendar && count($acuerdos)>=$acuerdospermitidos) {
                        return new View("Solamente se pueden hacer acuerdos de $acuerdospermitidos materia(s) para un periodo de regularización.", Response::HTTP_PARTIAL_CONTENT);
                    }
                

                    if ($data["agendaextraordinarioid"]) {
                        $agenda=$dbm->getRepositoriosById("CeAgendaextraordinario","agendaextraordinarioid",$data["agendaextraordinarioid"]);
                        $extid=$data["extraordinarioid"];
                        $exttipid=$data["tipoextraordinarioid"];
                        list($statusA,$acuerdos)=$this->getAcuerdosByExtraordinarioId($extid);

                        try{
                            $dbm=$this->getDM();
                            $alumno=$extraordinario->getAlumnoid();
                            $extraid=$extraordinario->getExtraordinarioid();
                            $alumnoid=$alumno->getAlumnoid();
                            if(!$this->validLimit($acuerdos) && $entorno == 1){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"Excedio numero de intentos."); }
                
                            foreach ($agenda as $agendahorario) {
                                if ($hoy < $agendahorario->getFechainicio()) {
                                    $agendadisp = $agendahorario;
                                    break;
                                }
                            }
                            
                            foreach ($agenda as $agendahorario) {
                                if ($hoy <  $agendahorario->getFechainicio()) {
                                    array_push($agendadisp,$agendahorario);
                                }
                            }
                            if($entorno == 1) {
                                if(!$agendadisp){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No hay agendas disponibles."); }
                            } else {
                                if(!$agendadisp){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,""); }
                            }
                
                            if(sizeof($agendadisp)<1){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No hay agendas disponibles."); }
                            $tagid=$agendadisp;
                            if($exttipid==1){
                                $arrayagenda = array();
                                $agendatmp = array(
                                    "agendaextraordinarioid" => $agendadisp->getAgendaextraordinarioid(),
                                    "fechainicio" =>  $agendadisp->getFechainicio(),
                                    "horainicio" =>   $agendadisp->getHorainicio(),
                                    "horafin" => $agendadisp->getHorafin()
                                );
                                $arrayagenda[0] = $agendatmp;
                                $acuerdos=$dbm->getEAcuerdoextraordinarioByAlumno($alumnoid,$exttipid);
                                $tagid=$this->getValidAgendaWithDT($arrayagenda,$acuerdos);
                            }
                            if(!$tagid){ 
                                return new View("No hay cupo en las agendas disponibles o los horarios son incompatibles", Response::HTTP_PARTIAL_CONTENT);

                            }
                            if($exttipid==1){
                                $agenda=$dbm->getRepositorioById("CeAgendaextraordinario","agendaextraordinarioid",$tagid['agendaextraordinarioid']);
                            } else {
                                $agenda=$dbm->getRepositorioById("CeAgendaextraordinario","agendaextraordinarioid",$tagid->getAgendaextraordinarioid());
                                $cupodisp = ($this->getAgendaCDisponibleById($tagid->getAgendaextraordinarioid())>0);
                                if (!$cupodisp) {
                                    return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No hay cupo disponible en la agenda.");
                                }
                            }                            
                            $acuerdosagendas = $dbm->getRepositoriosById("CeAcuerdoextraordinario","agendaextraordinarioid",$agenda->getAgendaextraordinarioid());
                            $acuerdo=$dbm->getRepositorioById("CeAcuerdoextraordinario","acuerdoextraordinarioid",$data['acuerdoextraordinarioid']);
                            $acuerdo->setAgendaextraordinarioid($agenda);
                            $extraordinario->setEstatusextraordinarioid($acuerdo->getEstatusextraordinarioid());
                            $dbm->getConnection()->beginTransaction();
                            $dbm->saveRepositorio($extraordinario);
                            $dbm->saveRepositorio($acuerdo);
                            $dbm->getConnection()->commit();

                            $tmp = $agenda->getProfesorid()->getProfesorid();
                            $usuarioprofesor =  $dbm->getRepositorioById('Usuario', 'profesorid', $agenda->getProfesorid()->getProfesorid());
                            $dbm->getConnection()->commit();
                            
                            $entidad=$extraordinario;
                            $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                            if ($usuariodestino){
                                $params = [
                                    "Matrícula" => $usuariodestino->getAlumnoid()->getMatricula(),
                                    "Alumno" => ($usuariodestino->getAlumnoid()->getApellidopaterno(). ' ' . 
                                    $usuariodestino->getAlumnoid()->getApellidomaterno(). ' ' .
                                    $usuariodestino->getAlumnoid()->getPrimernombre()),
                                    "Materia" => $agenda->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                                    "ExtraordinarioFecha" => $agenda->getFechainicio()->format("d-m-Y")
                                ];
                                $usuariodestino=$usuariodestino->getUsuarioid();
                                if ($entorno == 1) {
                                    $actividad=[
                                        "tipoactividadid"=>23,
                                        "usuariodestinoid"=>$usuariodestino
                                    ];
                                } else {
                                    $actividad=[
                                        "tipoactividadid"=>24,
                                        "usuariodestinoid"=>$usuariodestino
                                    ];
                                }

                                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$extraordinario,$dbm,$this->get('mailer'), $params);
                            }
                            return new View("Se ha agendado el extraordinario seleccionado.", Response::HTTP_OK);
                        }catch(\Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST,$e->getMessage()); }
                    }
            }            

            $acuerdo=$dbm->getRepositorioById("CeAcuerdoextraordinario","acuerdoextraordinarioid",$data["acuerdoextraordinarioid"]);
            $extras = $dbm->getRepositorioById("CeExtraordinario","extraordinarioid",$data["extraordinarioid"]);
            if($extras->getEstatusextraordinarioid()->getEstatusextraordinarioid() == 3) {
                return new View("No se puede editar el acuerdo cuando el estatus del extraordinario es AGENDADO.", Response::HTTP_PARTIAL_CONTENT);
            }
            $acuerdospermitidos=$dbm->getRepositorioById("Parametros","nombre","AcuerdosExtra")->getValor();
            $acuerdos = $dbm->BuscarExtraordinarioporacuerdo(["cicloid"=>$data["cicloid"],"alumnoid"=>$acuerdo->getExtraordinarioid()->getAlumnoid()->getAlumnoid()]);
            $acuerdoscount = count($acuerdos);
            if ($acuerdoscount>=$acuerdospermitidos) {
                return new View("Solamente se pueden hacer acuerdos de $acuerdospermitidos materia(s) para un periodo de regularización.", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $acuerdo = $hydrator->hydrate($acuerdo, $data);
            $dbm->saveRepositorio($acuerdo);

            $dbm->getConnection()->commit();
            
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Envia las notificaciones de extraordinario a los alumnos seleccionados
     * @Rest\Post("/api/Controlescolar/Extraordinario/Notificar", name="sendExtraordinario")
     */
    public function sendExtraordinario()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            foreach ($data as $alumno){
                //$email=$alumno->getCorreoinstitucional();
                $email=$alumno["email"];
                $parametros = array($alumno["alumno"],$alumno["materia"]);
                $correo = $dbm->getRepositorioById('Correo', 'correoid', 18);
                \AppBundle\Dominio\Correo::ServicioCorreo(array($email), $parametros, $correo, $this->get('mailer'));
            }

            return new View("Se han enviado las notificaciones.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Envia las notificaciones de extraordinario a los alumnos seleccionados
     * @Rest\Post("/api/Controlescolar/Extraordinario/Revalidado", name="setRevalidado")
     */
    public function sentRevalidado()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm->getConnection()->beginTransaction();
            foreach ($data as $id){
                $estatus = $dbm->getRepositorioById('CeExtraordinario', 'extraordinarioid', $id);
                $estatus->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 6));
                $ultimoacuerdo = $dbm->UltimoAcuerdoPorAgenda($id,false);
                if ($ultimoacuerdo) {
                    $acuerdo = $dbm->getRepositorioById('CeAcuerdoextraordinario', 'acuerdoextraordinarioid', $ultimoacuerdo[0]['acuerdoextraordinarioid']);
                    $acuerdo->setAgendaextraordinarioid(null);
                    $acuerdo->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 6));
                    $dbm->saveRepositorio($acuerdo);
                }
                $dbm->saveRepositorio($estatus);
            }

            $dbm->getConnection()->commit();
            return new View("Se asignado el estatus a los registros seleccionados.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    

    /**
     * Envia las notificaciones de extraordinario a los alumnos seleccionados
     * @Rest\Post("/api/Controlescolar/Extraordinario/Irregular", name="setIrregular")
     */
    public function setIrregular()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm->getConnection()->beginTransaction();
            foreach ($data as $id){
                $estatus = $dbm->getRepositorioById('CeExtraordinario', 'extraordinarioid', $id);
                $estatus->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 7));
                $dbm->saveRepositorio($estatus);
                $ultimoacuerdo = $dbm->UltimoAcuerdoPorAgenda($id,false);
                if ($ultimoacuerdo) {
                    $acuerdo = $dbm->getRepositorioById('CeAcuerdoextraordinario', 'acuerdoextraordinarioid', $ultimoacuerdo[0]['acuerdoextraordinarioid']);
                    $acuerdo->setAgendaextraordinarioid(null);
                    $acuerdo->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 7));
                    $dbm->saveRepositorio($acuerdo);
                }
                $dbm->saveRepositorio($estatus);
            }
            $dbm->getConnection()->commit();
            return new View("Se asignado el estatus a los registros seleccionados.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Controlescolar/Extraordinario/Alumno/{id}", name="getExtraorginariosAlumno")
     */
    public function getExtraorginariosAlumno($id)
    {
        try {
            $datos=$_REQUEST;
            $filtros=array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $alumno = $dbm->BuscarAlumnosA(array("alumnoid" => $id));
            if(!$alumno) {
                return new View("No se encontró información relacionada con el alumno");
            }
            $hoy = new \DateTime();
            $hoy->setTime(0,0,0);
            $extraordinarios = $dbm->BuscarExtraordinarioAlumno($id, $alumno[0]['alumnoporcicloid'], $filtros['periodoregularizacionid']);
            $tipo = $dbm->getRepositoriosById('CeTipoextraordinario', 'activo', 1);
            $limitemateria = $dbm->getRepositorioById('Parametros', 'parametrosid', 115);
            $permiteagendar = true;
            $numextraordinarios = count($extraordinarios);
            if ($numextraordinarios >= $limitemateria->getValor()) {
                $permiteagendar = false;
            } else {
                $permiteagendar = true;
            }

            $periodos = $dbm->getRepositoriosById('CePeriodoregularizacion', 'activo', 1,'fechalimiteasignacion');
            return new View([
                "hoy" => $hoy,
                "extraordinarios"=>$extraordinarios,
                "alumno" => $alumno,
                "permiteagendar" => $permiteagendar,
                "tipoextraordinario"=>$tipo, 
                "periodos"=>$periodos], 
                Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Controlescolar/Extraordinario/Disponibilidad/", name="CheckdispcursoAlumno")
     */
    public function CheckdispcursoAlumno()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$datos=$_REQUEST;
            $filtros=array_filter($datos);
            $disponible = false;
            $disponibilidad = $dbm->CheckCursoAlumno($filtros);

            if ($disponibilidad) {
                $disponible = true;
            } else {
                $disponible = false;
            }

            return new View($disponible, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Post("/api/Controlescolar/Extraordinario/Acordar", name="AgendarAcuerdo")
     */
    public function AgendarAcuerdo(){
        $hoy = new \DateTime();
        $agendasdisp = [];
        $requestRaw=trim(file_get_contents("php://input"));
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $request=json_decode($requestRaw,true);
        $fechaHoy=new \DateTime();
        try{
        $extid=$request["extraordinarioid"];
        $exttipid=$request["tipoextraordinarioid"];
        $extraordinariotmp =  $dbm->getRepositorioById("CeExtraordinario","extraordinarioid",$extid);
        $acuerdos = $dbm->BuscarExtraordinarioporacuerdo(["cicloid"=>$request["cicloid"],"alumnoid"=>$extraordinariotmp->getAlumnoid()->getAlumnoid(),"periodoregularizacionid"=>$request["periodoregularizacionid"]]);
        foreach ($acuerdos as $ac) {
            if ($ac['extraordinarioid'] == $request["extraordinarioid"]) {
                $permiteagendar = true;
                break;
            }
        }
        $mppe=$dbm->getRepositorioById("CeMateriaporplanestudios","materiaporplanestudioid",$request['materiaporplanestudioid']);

        $acuerdospermitidos=$dbm->getRepositorioById("Parametros","nombre","AcuerdosExtra")->getValor();

        if (!$permiteagendar && count($acuerdos)>=$acuerdospermitidos) {
            return new View("Solamente se pueden hacer acuerdos de $acuerdospermitidos materia(s) para un periodo de regularización.", Response::HTTP_PARTIAL_CONTENT);
        }
        

        list($statusA,$acuerdos)=$this->getAcuerdosByExtraordinarioId($extid);
            if ($request['tipoextraordinarioid'] && $request['tipoextraordinarioid'] == 2) {
                $disponibilidad = $dbm->CheckCursoAlumno($request);
                if (!$disponibilidad) {
                    return new View(" Para que puedas agendar la materia a un CURSO 
                    debes haber aplicado primero un examen extraordinario y tener una calificación reprobatoria.", 
                    Response::HTTP_PARTIAL_CONTENT);
                }
            }


            $acuerdo=$this->getAcuerdoObject(array(
                "agendaextraordinarioid"=>null,
                "estatusextraordinarioid"=>self::$STATUSID_AG,
                "usuarioid"=>$request["usuarioid"],
                "extraordinarioid"=>$request["extraordinarioid"],
                "tipoextraordinarioid"=>$request["tipoextraordinarioid"],
                "periodoregularizacionid"=>$request["periodoregularizacionid"],
                "intento"=>(sizeof($acuerdos) + 1),
                "pagado"=>0
            ));
            $dbm=$this->getDM();
            $extra=$acuerdo->getExtraordinarioid();
						$alumno=$extra->getAlumnoid();
						$extraid=$extra->getExtraordinarioid();
						$alumnoid=$alumno->getAlumnoid();
            if(!$this->validLimit($acuerdos)){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"Excedio numero de intentos."); }
            $agendas=$dbm->getEAgendasDisponiblesByExtraordinario($extraid,$exttipid,$request['periodoregularizacionid']);


            foreach ($agendas as $agendahorario) {
                $agendahorario['fechainicio'] = is_string($agendahorario['fechainicio']) ? 
                new \Datetime($agendahorario['fechainicio']) : $agendahorario['fechainicio'];

                if($exttipid==1) {
                $agendahorario['fechafin'] = is_string($agendahorario['fechafin']) ? 
                    new \Datetime($agendahorario['fechafin']) : $agendahorario['fechafin'];
                    
                $agendahorario['horainicio'] =  is_string($agendahorario['horainicio']) ?
                 new \Datetime($agendahorario['horainicio']) : $agendahorario['horainicio'];

                 $agendahorario['horafin'] = $agendahorario['horafin'] ? is_string($agendahorario['horafin']) ?
                     new \Datetime($agendahorario['horafin']) : $agendahorario['horafin'] : null;
                }

                if ($hoy < $agendahorario['fechainicio']) {
                    $agendadisp = $agendahorario;
                    break;
                }
            }

            foreach ($agendas as $agendahorario) {
                $agendahorario['fechainicio'] = is_string($agendahorario['fechainicio']) ? 
                new \Datetime($agendahorario['fechainicio']) : $agendahorario['fechainicio'];

                if($exttipid==1) {
                $agendahorario['fechafin'] = is_string($agendahorario['fechafin']) ? 
                    new \Datetime($agendahorario['fechafin']) : $agendahorario['fechafin'];
                    
                $agendahorario['horainicio'] =  is_string($agendahorario['horainicio']) ?
                 new \Datetime($agendahorario['horainicio']) : $agendahorario['horainicio'];

                 $agendahorario['horafin'] = $agendahorario['horafin'] ? is_string($agendahorario['horafin']) ?
                     new \Datetime($agendahorario['horafin']) : $agendahorario['horafin'] : null;
                }

                if ($hoy < $agendahorario['fechainicio']) {
                    array_push($agendasdisp,$agendahorario);
                }
            }

            if(!$agendadisp){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No hay agendas disponibles."); }

            if(sizeof($agendasdisp)<1){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No hay agendas disponibles."); }
            $tagid=$agendasdisp[0];
            if($exttipid==1){
                $acuerdos=$dbm->getEAcuerdoextraordinarioByAlumno($alumnoid,$exttipid);
                $tagid=$this->getValidAgendaWithDT($agendasdisp,$acuerdos);
            }
            if(!$tagid){ return Api::Error(Response::HTTP_PARTIAL_CONTENT,"No hay cupo en las agendas disponibles o los horarios son incompatibles"); }
            $agenda=$dbm->getRepositorioById("CeAgendaextraordinario","agendaextraordinarioid",$tagid['agendaextraordinarioid']);
            $acuerdosagendas = $dbm->getRepositoriosById("CeAcuerdoextraordinario","agendaextraordinarioid",$agenda->getAgendaextraordinarioid());
            
            $acuerdo->setAgendaextraordinarioid($agenda);

            $subconceptonivel = $dbm->getOneByParametersRepositorio('CjExtraordinariosubconceptopormateria',
            array('materiaid' => $mppe->getMateriaid()->getMateriaid()));
            if (!$subconceptonivel) {
                return new View("No se ha configurado un subconcepto para la materia del alumno.",Response::HTTP_PARTIAL_CONTENT);
            } 
            $hijopersonal = $dbm->getRepositorioById('CeAlumnoporpersonal', 'alumnoid', $request['alumnoid']);
            if(!$hijopersonal){
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $request['alumnoid']);
                $nombre = $alumno->getPrimernombre() . ' ' . $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno();
            if ($alumno->getHijopersonal()) {
                    $hijopersonal = true;
                }
            }
            $subconceptoentity=$subconcepto;
            if($subconceptonivel){
                $subconceptopornivel = $dbm->getOneByParametersRepositorio('CjSubconceptopornivel',
                array('activo' => 1, 'subconceptoid' => $subconceptonivel->getSubconceptoid()->getSubconceptoid(), 'nivelid' => $request['nivelid']));
                
                $subconceptoentity=$subconceptonivel->getSubconceptoid();
                $fechalimite=$subconceptonivel->getFechalimitepago();

                if($subconceptopornivel) {
                    $total=$subconceptopornivel->getImporte();
                } else {
                    $total=$subconceptonivel->getSubconceptoid()->getImporte();
                }
            }
            $descuento=$hijopersonal ? ($porcentaje*$total/100) : 0;
            $importe=$total-$descuento;
            if(!$subconceptoentity){
                return new View("No se ha configurado el subconcepto.",Response::HTTP_PARTIAL_CONTENT);
            }

            $fechaLimiteFinal=$fechalimite;//new \DateTime($fechaHoy->format("Y-m-{$fechalimitedia}"));
            $documentoNombre=$fechaLimiteFinal->format("Ymd")."G";
            $fechalimitepago = $fechaLimiteFinal;
            $fechaprontopago = $fechaLimiteFinal;
            $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
            $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
            $documentoporpagar = new CjDocumentoporpagar();
            $documentoporpagar->setDocumentoid($documento);
            $documentoporpagar->setSubconceptoid($subconceptoentity);
            $documentoporpagar->setPagoestatusid($dbm->getRepositorioById("CjPagoestatus","pagoestatusid",1));
            $documentoporpagar->setAlumnoid($request['alumnoid'] ? $dbm->getRepositorioById("Cealumno","alumnoid",$request['alumnoid']) : null);
            $documentoporpagar->setCicloid($request['cicloid']  ? $dbm->getRepositorioById("Ciclo","cicloid",$request['cicloid']) : null);
            $documentoporpagar->setGradoid($dbm->getRepositorioById("Grado","gradoid",$request['gradoid']));
            $documentoporpagar->setImporte($importe);
            $documentoporpagar->setSaldo($importe);
            $documentoporpagar->setConcepto("Extraordinario " . $mppe->getMateriaid()->getNombre());
            $documentoporpagar->setFechalimitepago($fechalimitepago);
            $documentoporpagar->setFechacreacion($fechaHoy);
            $documentoporpagar->setFechaprontopago($fechaprontopago);
            $documentoporpagar->setDocumento($documentoNombre);
            $dbm->saveRepositorio($documentoporpagar);
            $acuerdo->setDocumentoporpagarid($documentoporpagar);

            $extra->setEstatusextraordinarioid($acuerdo->getEstatusextraordinarioid());
            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($extra);
            $dbm->saveRepositorio($acuerdo);

            $correo = $dbm->getRepositorioById('Correo', 'correoid', 19);
            $parametros = array(
                "alumno" => ( ($request['apellidopaterno'] ? $request['apellidopaterno'] : "") . ' ' .
                ($request['apellidomaterno'] ? $request['apellidomaterno'] : "") . ' ' .
                ($request['primernombre'] ? $request['primernombre'] : "")),
                "tipoextraordinario" => $agenda->getTipoextraordinarioid()->getNombre(),
                "lugaraplicacion" => $agenda->getLugarid()->getNombre(),
                "fechaaplicacion" => $agenda->getFechainicio()->format("d-m-Y"),
                "horaincioaplicacion" => $agenda->getHorainicio(),
                "horafinaplicacion" => ($agenda->getHorafin() ? $agenda->getHorafin()->format("H:i:s") : null),
                "profesor" => $agenda->getProfesorid()->getApellidopaterno(). ' ' . $agenda->getProfesorid()->getNombre(),
                "fecharevision" => $agenda->getFecharevision()->format("d-m-Y") ,
                "lugarrevision" => $agenda->getLugarrevisionid()->getNombre(),
                "horainiciorevision" => $agenda->getHorainiciorevision()->format("H:i:s"),
                "horafinrevision" => $agenda->getHorafinrevision()->format("H:i:s"),
                "tipo" => "creación"
            );  
            /*
            if ($request['correo']) {
                \AppBundle\Dominio\Correo::ServicioCorreo($request['correo'], $parametros,  $correo, $this->get('mailer'), $attachment);    
            }
            */
            $tmp = $agenda->getProfesorid()->getProfesorid();
            $usuarioprofesor =  $dbm->getRepositorioById('Usuario', 'profesorid', $agenda->getProfesorid()->getProfesorid());
            $dbm->getConnection()->commit();
            
            $entidad=$extra;
            $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
            if ($usuariodestino){
                $params = [
                    "Matrícula" => $usuariodestino->getAlumnoid()->getMatricula(),
                    "Alumno" => ($usuariodestino->getAlumnoid()->getApellidopaterno(). ' ' . 
                    $usuariodestino->getAlumnoid()->getApellidomaterno(). ' ' .
                    $usuariodestino->getAlumnoid()->getPrimernombre()),
                    "Materia" => $agenda->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                    "ExtraordinarioFecha" => $agenda->getFechainicio()->format("d-m-Y")
                ];
                $usuariodestino=$usuariodestino->getUsuarioid();
                    $actividad=[
                        "tipoactividadid"=>24,
                        "usuariodestinoid"=>$usuariodestino
                    ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$extraordinario,$dbm,$this->get('mailer'), $params);
            }
            return new View("Se ha agendado el acuerdo seleccionado.", Response::HTTP_OK);
        }catch(\Exception $e){ return Api::Error(Response::HTTP_BAD_REQUEST,$e->getMessage()); }
    }

    private function getAcuerdoObject($data,$acuerdo=false){
        if(!$acuerdo){ $acuerdo=new CeAcuerdoextraordinario(); }
        return (new ArrayHydrator($this->getDM()->getEntityManager()))->hydrate($acuerdo, $data);
    }
    private function validLimit($acuerdos){
        return (sizeof($acuerdos)<self::$MAX_ATTEMPT);
    }
    private function getAcuerdosByExtraordinarioId($id){
        try{
            return array(true,$this->getDM()->getRepositoriosById("CeAcuerdoextraordinario","extraordinarioid",$id));
        }catch(\Exception $e){ return array(false,$e->getMessage()); }
    }
	private function getAgendaCDisponibleById($id){
		$dbm=$this->getDM();
		$acuerdoscount=$dbm->getEAcuerdoextraordinarioCountByAgendaextraordinario($id);
		$agenda=$dbm->getRepositorioById("CeAgendaextraordinario", "agendaextraordinarioid", $id);
		$used=(int)$acuerdoscount;
		$cupo=(int)$agenda->getCupo();
		$available=$cupo-$used;
		return $available;
	}
    
    private function getValidAgendaWithDT($ag,$ac){
        foreach($ag AS $k=>$i){ $ag[$k]=$this->getValidAgendaWithDTSSO($i); }
        foreach($ac AS $k=>$i){ $ac[$k]=$this->getValidAgendaWithDTSSO($i); }
        /* TEST ONLY
        $ag=array($ac[0],$ag[0]);
        $ac[0]=$ag[0];
        //*/
        usort($ag,array("AppBundle\Controller\Controlescolar\ExtraordinarioController","DTSSOCmp"));
        foreach($ag AS $i){
            $valid=true;
            $ii=$i['dtssoi'];
            $if=$i['dtssof'];
            foreach($ac AS $j){
                $ji=$j['dtssoi'];
                $jf=$j['dtssof'];
                if(($ii<=$ji && $ji<=$if)
                    || ($ii<=$jf && $jf<=$if)
                    || ($ji<=$ii && $if<=$jf)){
                    $valid=false;
                    
                }
            }
            if($valid && $this->getAgendaCDisponibleById($i['agendaextraordinarioid'])>0){ return $i; }
        }
        return false;
    }
    private function getValidAgendaWithDTSSO($item){
        $fi=$item['fechainicio'];
        $ff=$item['horafin'];
        list($hi,$mi)=explode(":",$item['horainicio']);
        list($yi,$moi,$di)=explode("-",$fi->format("Y-m-d"));
        $fi->setTime($hi,$mi,0);
        $ff->setDate($yi,$moi,$di);
        $item['dtssoi']=$fi->getTimestamp();
        $item['dtssof']=$ff->getTimestamp();
        unset($item['fechainicio']);
        unset($item['horainicio']);
        unset($item['horafin']);
        return $item;
    }
    public static function DTSSOCmp($x,$y){
        $k=($x['dtssoi']==$y['dtssoi']?'dtssof':'dtssoi');
        return ($x['dtssof']<$y['dtssof']?-1:1);
    }


    /**
     * Actualiza el estatus de un extraordinario de "AGENDADO" a "PENDIENTE"
     * @Rest\Post("/api/Controlescolar/Extraordinario/Pendiente", name="Extraordinariopendiente")
     */
    public function Extraordinariopendiente()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $extraordinario = $dbm->getRepositorioById('CeExtraordinario', 'extraordinarioid', $data['extraordinarioid']);
            $extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 1));
            $dbm->saveRepositorio($extraordinario);
            
            $acuerdo =  $dbm->getOneByParametersRepositorio('CeAcuerdoextraordinario', array('extraordinarioid' => $data['extraordinarioid'], 'estatusextraordinarioid' => 3));
            if (!$acuerdo) {
                return new View("No se ha encontrado un acuerdo", Response::HTTP_PARTIAL_CONTENT);
            }
            $agenda = $dbm->getRepositorioById('CeAgendaextraordinario', 'agendaextraordinarioid', $acuerdo->getAgendaextraordinarioid()->getAgendaextraordinarioid());
            $dp = $acuerdo->getDocumentoporpagarid() ? $acuerdo->getDocumentoporpagarid()->getDocumentoporpagarid() : null;
            if($acuerdo->getDocumentoporpagarid()) {
                if($acuerdo->getDocumentoporpagarid()->getPagoestatusid()->getPagoestatusid() == 2) {
                    return new View("No se puede eliminar la agenda debido a que ya se encuentra pagada.", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            $dbm->removeRepositorio($acuerdo);
            if($dp) {
                $dbm->removeManyRepositorio('CjDocumentoporpagar', 'documentoporpagarid', $dp);
            }

            $entidad=$extraordinario;
            $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
            if ($usuariodestino){
                $params = [
                    "Matrícula" => $usuariodestino->getAlumnoid()->getMatricula(),
                    "Alumno" => ($usuariodestino->getAlumnoid()->getApellidopaterno(). ' ' . 
                    $usuariodestino->getAlumnoid()->getApellidomaterno(). ' ' .
                    $usuariodestino->getAlumnoid()->getPrimernombre()),
                    "Materia" => $agenda->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                    "ExtraordinarioFecha" => $agenda->getFechainicio()->format("d-m-Y")
                ];
                $usuariodestino=$usuariodestino->getUsuarioid();
                    $actividad=[
                        "tipoactividadid"=>25,
                        "usuariodestinoid"=>$usuariodestino
                    ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$extraordinario,$dbm,$this->get('mailer'), $params);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Actualiza el estatus de un extraordinario de "AGENDADO" a "PENDIENTE" desde la consulta de extraordinarios
     * @Rest\Post("/api/Controlescolar/Extraordinario/Alumno/Pendiente", name="ExtraordinarioAlumnoPendiente")
     */
    public function ExtraordinarioAlumnoPendiente()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $acuerdo = $dbm->getRepositorioById('CeAcuerdoextraordinario', 'acuerdoextraordinarioid', $data['acuerdoextraordinarioid']);
            if (!$acuerdo) {
                return new View("No se ha encontrado un acuerdo", Response::HTTP_PARTIAL_CONTENT);
            }
            $agenda =  $acuerdo->getAgendaextraordinarioid();
            $extraordinario = $dbm->getRepositorioById('CeExtraordinario', 'extraordinarioid', $acuerdo->getExtraordinarioid()->getExtraordinarioid());
            $extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 1));
            $dbm->saveRepositorio($extraordinario);
            
            $dp = $acuerdo->getDocumentoporpagarid() ? $acuerdo->getDocumentoporpagarid()->getDocumentoporpagarid() : null;
            if($acuerdo->getDocumentoporpagarid()) {
                if($acuerdo->getDocumentoporpagarid()->getPagoestatusid()->getPagoestatusid() == 2) {
                    return new View("No se puede eliminar el acuerdo debido a que ya se encuentra pagada.", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            $dbm->removeRepositorio($acuerdo);
            if($dp) {
                $dbm->removeManyRepositorio('CjDocumentoporpagar', 'documentoporpagarid', $dp);
            }

            $entidad=$extraordinario;
            $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
            if ($usuariodestino && $agenda){
                $params = [
                    "Matrícula" => $usuariodestino->getAlumnoid()->getMatricula(),
                    "Alumno" => ($usuariodestino->getAlumnoid()->getApellidopaterno(). ' ' . 
                    $usuariodestino->getAlumnoid()->getApellidomaterno(). ' ' .
                    $usuariodestino->getAlumnoid()->getPrimernombre()),
                    "Materia" => $agenda->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                    "ExtraordinarioFecha" => $agenda->getFechainicio()->format("d-m-Y")
                ];
                $usuariodestino=$usuariodestino->getUsuarioid();
                    $actividad=[
                        "tipoactividadid"=>25,
                        "usuariodestinoid"=>$usuariodestino
                    ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$extraordinario,$dbm,$this->get('mailer'), $params);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }    

	private function getDM(){
		if($this->DBM){
			return $this->DBM;
		}
		$this->DBM=new DbmControlescolar($this->get("db_manager")->getEntityManager());
		return $this->DBM;
    }
    
    private function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['materiaplanestudioid'] === $id) {
                return $key;
            }
        }
        return null;
     }
}   