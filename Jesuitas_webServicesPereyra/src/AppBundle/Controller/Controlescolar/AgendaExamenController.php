<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAgendaextraordinario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class AgendaExamenController extends FOSRestController
{

    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Get("/api/Controlescolar/Agendaexamen", name="indexAgendaexamen")
     */
    public function indexAgendaexamen()
    {
        try {
            $hoy = new \DateTime();
            $today = $hoy->format('d-m-Y');
            $periodos = [];
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $tipoextraordinario = $dbm->getRepositoriosById('CeTipoextraordinario', 'activo', 1);
            $planestudios = $dbm->getRepositorios('CePlanestudios');
            $periodosregularizacion = $dbm->getRepositoriosById('CePeriodoregularizacion','activo',1);
            $lugar = $dbm->getRepositoriosById('Lugar', 'activo', 1);
            $materia = array();
            foreach ($planestudios as $p) {
                $materia = array_merge(
                    $materia,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid()]
                    )
                );
            }

            foreach($periodosregularizacion as $periodo) {
                $disponible = false;
                $fechaperiodo = $periodo->getFechafin()->format('d-m-Y');
                if(new \Datetime($fechaperiodo) >= new \Datetime($today)) {
                    array_push($periodos, $periodo);
                }
            }

            return new View(
                array("ciclo" => $ciclo,
                    "hoy" => $hoy,
                    "nivel" => $nivel,
                    "grado" => $grado,
                    "semestre" => $semestre,
                    "tipoextraordinario" => $tipoextraordinario,
                    "materias" => $materia,
                    "planestudios" => $planestudios,
                    "periodoregularizacion" => $periodos,
                    "extraordinario" => $extraordinario,
                    "lugar" => $lugar,
                ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna arreglo de profesores
     * @Rest\Get("/api/Controlescolar/Agendaexamen/FiltrarProfesor/", name="filtrarprofesoragenda")
     */
    public function filtrarprofesornivel()
    {
        try {
            $data = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidades = $dbm->FiltrarProfesores($data);

            return new View($entidades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }    

    /**
     *
     * @Rest\Get("/api/Controlescolar/Agendaexamen/Filtrar/", name="filtraragenda")
     */
    public function filtraragenda()
    {
        try {
            $data = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $agenda = $dbm->FiltrarAgenda($data);
            if (!$agenda) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($agenda, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Agendaexamen" , name="SaveAgendaexamen")
     */
    public function SaveAgendaexamen()
    {

        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $cupo = 0;


            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $periodo = $dbm->getRepositorioById('CePeriodoregularizacion', 
            'periodoregularizacionid', $data['filtros']['periodoregularizacionid']);

            if ($periodo && !$periodo->getPermitecursos() && $data['filtros']['tipoid'] && $data['filtros']['tipoid'] == 2) {
                return new View("El periodo regularización seleccionado no permite cursos.",
                Response::HTTP_PARTIAL_CONTENT);
            }

            
            $agenda = new CeAgendaextraordinario();
            $agenda->setFechainicio(empty($data['datos']['fechasaplicacion']) ? null :new \DateTime($data['datos']['fechasaplicacion']));
            $agenda->setFechafin(empty($data['datos']['fechasfinaplicacion']) ? null :new \DateTime($data['datos']['fechasfinaplicacion']));
            if ($data['filtros']['tipoid'] == 1) {
                $agenda->setHorainicio(empty($data['datos']['horainicioaplicacion']) ? null : ($data['datos']['horainicioaplicacion']));
            } else {
                $agenda->setHorainicio(empty($data['datos']['comentarios']) ? null : ($data['datos']['comentarios']));
            }
            
            $agenda->setHorafin(empty($data['datos']['horafinaplicacion']) ? null :new \DateTime($data['datos']['horafinaplicacion']));
            $agenda->setCupo(empty($data['datos']['cupoapliacion']) ? null : $data['datos']['cupoapliacion']);
            $agenda->setFecharevision(empty($data['datos']['fechasrevision']) ? null :new \DateTime($data['datos']['fechasrevision']));
            $agenda->setHorainiciorevision(empty($data['datos']['horainiciorevision']) ? null :new \DateTime($data['datos']['horainiciorevision']));
            $agenda->setHorafinrevision(empty($data['datos']['horafinrevision']) ? null :new \DateTime($data['datos']['horafinrevision']));
            $agenda->setComentarios(empty($data['datos']['comentarios']) ? null : $data['datos']['comentarios']);

            $agenda->setEstatusagendaextraordinarioid($dbm->getRepositorioById('CeEstatusagendaextraordinario', 'estatusagendaextraordinarioid', 1));

            $agenda->setTipoextraordinarioid(empty($data['filtros']['tipoid']) ?
            null : $dbm->getRepositorioById('CeTipoextraordinario', 'tipoextraordinarioid', $data['filtros']['tipoid']));     
            
            $agenda->setProfesorid(empty($data['filtros']['profesorid']) ?
            null : $dbm->getRepositorioById('CeProfesor', 'profesorid', $data['filtros']['profesorid'])); 

            $agenda->setLugarid(empty($data['datos']['lugaraplicacionid']) ?
            null : $dbm->getRepositorioById('Lugar', 'lugarid', $data['datos']['lugaraplicacionid']));  
            
            $agenda->setLugarrevisionid(empty($data['datos']['lugarrevisionid']) ?
            null : $dbm->getRepositorioById('Lugar', 'lugarid', $data['datos']['lugarrevisionid']));    
            
            $agenda->setMateriaporplanestudioid(empty($data['filtros']['materiaid']) ?
            null : $dbm->getRepositorioById('CeMateriaporplanestudios', 'materiaporplanestudioid', $data['filtros']['materiaid']));  

            $agenda->setPeriodoregularizacionid(empty($data['filtros']['periodoregularizacionid']) ?
            null : $dbm->getRepositorioById('CePeriodoregularizacion', 'periodoregularizacionid', $data['filtros']['periodoregularizacionid']));              

            $dbm->saveRepositorio($agenda);

            $instituto = ENTORNO;
            if ($instituto == 1){

            $acuerdosextraordinarios = $dbm->BuscarAcuerdosA($data);
            $acuerdoe = count($acuerdosextraordinarios);

            if ($acuerdoe == 0) {
                return new View("No se han encontrado acuerdos de alumnos con los filtros seleccionados",
                 Response::HTTP_PARTIAL_CONTENT);
            }

            $cupo = intval($data['datos']['cupoapliacion'] ? $data['datos']['cupoapliacion'] : null);


                for ($i = 0; $i < $cupo; ++$i){
                    if ($acuerdosextraordinarios[$i] ) {
                    
                        if ($data['filtros']['tipoid'] == 1) {
                            $fechas = $dbm->BuscarFechaextraordinario(null, $acuerdosextraordinarios[$i]['alumnoid']);
                            $listafecha = count($fechas);
                            for($k = 0; $k < $listafecha; $k++) {
                                if ($fechas[$k]) {
            
                                    $fechainiciotemp = ($fechas ? $fechas[$k]['FechaInicio'] : null);
                                    $horainiciotemp = ($fechas ? $fechas[$k]['HoraInicio'] : null);
                                    $horafintemp = ($fechas ? $fechas[$k]['HoraFin'] : null);
            
                                    
                                    if (new \DateTime($fechainiciotemp) == new \DateTime($data['datos']['fechasaplicacion'])) {
            
                                        if (new \DateTime($data['datos']['horainicioaplicacion']) >= new \DateTime($horainiciotemp)  &&
                                            new \DateTime($data['datos']['horainicioaplicacion']) <=  new \DateTime($horafintemp) || 
                                            new \DateTime($data['datos']['horafinaplicacion']) >= new \DateTime($horainiciotemp)  &&
                                            new \DateTime($data['datos']['horafinaplicacion']) <=  new \DateTime($horafintemp))  {
                                            return new View("No se pudo guardar el registro debido a que existen alumnos en la que las fechas y horas de las agendas se empalman",
                                            Response::HTTP_PARTIAL_CONTENT);
                                        }
                                    }
            
                                } else {
                                    break;  
                                }
                            }                        
                        }

                    $acuerdo = $dbm->getRepositorioById('CeAcuerdoextraordinario', 'acuerdoextraordinarioid', $acuerdosextraordinarios[$i]['acuerdoextraordinarioid']);
                    $acuerdo->setAgendaextraordinarioid($agenda);
                    $acuerdo->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 3));
                    $dbm->saveRepositorio($acuerdo);


                    $extraordinario = $dbm->getRepositorioById('CeExtraordinario', 'extraordinarioid', $acuerdosextraordinarios[$i]['extraordinarioid']);
                    $extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 3));
                    $dbm->saveRepositorio($extraordinario);    
    
                    } else {
                        break;
                    }
                }

                for ($j=0; $j < $cupo; $j++) { 
                    if ($acuerdosextraordinarios[$j] ) {
                        $usuariodestino = $dbm->getRepositorioById('Usuario', 'alumnoid', $acuerdosextraordinarios[$j]['alumnoid']);
                        if ($usuariodestino){
                            $params = [
                                "Materia" => $agenda->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                                "Matrícula" => $acuerdo->getExtraordinarioid()->getAlumnoid()->getMatricula(),
                                "Alumno" => ($acuerdo->getExtraordinarioid()->getAlumnoid()->getApellidopaterno() . ' ' .
                                $acuerdo->getExtraordinarioid()->getAlumnoid()->getApellidomaterno() . ' ' . 
                                $acuerdo->getExtraordinarioid()->getAlumnoid()->getPrimernombre()),
                                "ExtraordinarioFecha" => $agenda->getFechainicio()->format("d-m-Y")
                            ];
                            $usuariodestino=$usuariodestino->getUsuarioid();
                            $actividad=[
                                "tipoactividadid"=>24,
                                "usuariodestinoid"=>$usuariodestino
                            ];
                            \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), $params);
                        }
                
                    } else {
                        break;
                    }
                }
            }

            $dbm->getConnection()->commit();  
            return new View("se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View("No se pudo guardar el registro ", Response::HTTP_BAD_REQUEST);
        }
    }


        /**
     * @Rest\Post("/api/Controlescolar/CancelarAgendaexamen" , name="CancelarAgendaexamen")
     */
    public function CancelarAgendaexamen()
    {
        try {
            $hoy = new \DateTime();
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $listaagenda = $data['listaagenda'];
            $lista = count($listaagenda);

            for ($i = 0; i < $lista; $i++){
                if($listaagenda[$i]) {
                    $agenda =  $dbm->getRepositorioById('CeAgendaextraordinario', 'agendaextraordinarioid', $listaagenda[$i]);
                    $acuerdosporagenda = $dbm->getRepositoriosById('CeAcuerdoextraordinario', 'agendaextraordinarioid', $agenda->getAgendaextraordinarioid());
                    foreach($acuerdosporagenda AS $ag){
                        if ($ag->getCalificacion() > 0 || $ag->getCalificacionfinal() > 0) {
                            return new View("No se puede cancelar la agenda debido a que uno o mas alumnos ya han sido calificados", Response::HTTP_PARTIAL_CONTENT);
                        }
                    }
                    if ($agenda && $agenda->getFechainicio() <= $hoy) {
                        return new View("La fecha de inicio de alguna de las agendas es igual o menor a hoy", Response::HTTP_PARTIAL_CONTENT);
                    }
                    $agenda->setEstatusagendaextraordinarioid($dbm->getRepositorioById('CeEstatusagendaextraordinario', 'estatusagendaextraordinarioid',  2));
                    $dbm->saveRepositorio($agenda); 
                    $acuerdoalumno = $dbm->BuscarAcuerdoAlumno($listaagenda[$i]);
                    $listacuerdoalumno = count($acuerdoalumno);

                    for ($j = 0; j < $listacuerdoalumno; $j++){
                        if($acuerdoalumno[$j]) {
                            $acuerdo = $dbm->getRepositorioById('CeAcuerdoextraordinario', 'acuerdoextraordinarioid', intval($acuerdoalumno[$j]['acuerdoextraordinarioid']));
                            $instituto = ENTORNO;
                            if ($instituto == 2){
                                if($acuerdo->getDocumentoporpagarid()) {
                                    if($acuerdo->getDocumentoporpagarid()->getPagoestatusid()->getPagoestatusid() == 2) {
                                        return new View("No se puede cancelar la agenda debido a que uno o mas alumnos ya han pagado el extraordinario", Response::HTTP_PARTIAL_CONTENT);
                                    }
                                }
                                $dp = $acuerdo->getDocumentoporpagarid() ? $acuerdo->getDocumentoporpagarid()->getDocumentoporpagarid() : null;
                                $acuerdo->setDocumentoporpagarid(null);
                                $dbm->removeRepositorio($acuerdo);
                                if($dp) {
                                    $dbm->removeManyRepositorio('CjDocumentoporpagar', 'documentoporpagarid', $dp);
                                }
                            } else {
                                $acuerdo->setAgendaextraordinarioid(null);
                                $acuerdo->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 1));
                                $dbm->saveRepositorio($acuerdo);
                            }
                            
                            $extraordinario = $dbm->getRepositorioById('CeExtraordinario', 'extraordinarioid', intval($acuerdoalumno[$j]['extraordinarioid']));
                            $extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 1));
                            $dbm->saveRepositorio($extraordinario);

                            $entidad=$extraordinario;
                            $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                            $params = [
                                "Materia" => $agenda->getMateriaporplanestudioid()->getMateriaid()->getNombre(),
                                "Matrícula" => $acuerdo->getExtraordinarioid()->getAlumnoid()->getMatricula(),
                                "Alumno" => ($acuerdo->getExtraordinarioid()->getAlumnoid()->getApellidopaterno() . ' ' .
                                $acuerdo->getExtraordinarioid()->getAlumnoid()->getApellidomaterno() . ' ' . 
                                $acuerdo->getExtraordinarioid()->getAlumnoid()->getPrimernombre()),
                                "ExtraordinarioFecha" => $agenda->getFechainicio()->format("d-m-y")
                            ];
                            if ($usuariodestino){
                                $usuariodestino=$usuariodestino->getUsuarioid();
                                $actividad=[
                                    "tipoactividadid"=>25,
                                    "usuariodestinoid"=>$usuariodestino
                                ];
                                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), $params);
                            }
                        } else {
                            break;
                        }
                    }

                } else {
                    break;
                }


            }

            $dbm->getConnection()->commit();  
            return new View("Se han cancelado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View("No se pudo guardar el registro ", Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Controlescolar/Agendaexamen/{id}" , name="ActualizarAgendaexamen")
     */
    public function updateAgenda($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();


            $cupo = intval($data['datos']['cupoapliacion'] ? $data['datos']['cupoapliacion'] : null);

            $acuerdosextraordinarios = $dbm->BuscarAcuerdosporAgenda($id);
            $acuerdoe = count($acuerdosextraordinarios);

            $periodo = $dbm->getRepositorioById('CePeriodoregularizacion', 
            'periodoregularizacionid', $data['filtros']['periodoregularizacionid']);

            if ($periodo && !$periodo->getPermitecursos() && $data['filtros']['tipoid'] && $data['filtros']['tipoid'] == 2) {
                return new View("El periodo regularización seleccionado no permite cursos.",
                Response::HTTP_PARTIAL_CONTENT);
            }

            $instituto = ENTORNO;
            if ($instituto == 1) {

            if ($acuerdoe == 0) {
                return new View("No se han encontrado acuerdos de alumnos con los filtros seleccionados",
                 Response::HTTP_PARTIAL_CONTENT);
            }


            for ($i = 0; $i < $cupo; ++$i){
                if ($acuerdosextraordinarios[$i] ) {
                
                    if ($data['filtros']['tipoid'] == 1) {
                        $fechas = $dbm->BuscarFechaextraordinario(intval($id), $acuerdosextraordinarios[$i]['alumnoid']);
                        $listafecha = count($fechas);
        
                        for($k = 0; $k < $listafecha; $k++) {
                            if ($fechas[$k]) {
        
                                $fechainiciotemp = ($fechas ? $fechas[$k]['FechaInicio'] : null);
                                $horainiciotemp = ($fechas ? $fechas[$k]['HoraInicio'] : null);
                                $horafintemp = ($fechas ? $fechas[$k]['HoraFin'] : null);
        
                                
                                if (new \DateTime($fechainiciotemp) == new \DateTime($data['datos']['fechasaplicacion'])) {
        
                                    if (new \DateTime($data['datos']['horainicioaplicacion']) >= new \DateTime($horainiciotemp)  &&
                                        new \DateTime($data['datos']['horainicioaplicacion']) <=  new \DateTime($horafintemp) || 
                                        new \DateTime($data['datos']['horafinaplicacion']) >= new \DateTime($horainiciotemp)  &&
                                        new \DateTime($data['datos']['horafinaplicacion']) <=  new \DateTime($horafintemp))  {
                                        return new View("No se pudo guardar el registro debido a que existen alumnos en la que las fechas y horas de las agendas se empalman",
                                        Response::HTTP_PARTIAL_CONTENT);
                                    }
                                }
                            
                            } else {
                                break;  
                            }
                        }  
                    }                      
                    } else {
                        break;  
                    }
                }
            }

            $entidad = $dbm->getRepositorioById('CeAgendaextraordinario', 'agendaextraordinarioid', $id);
            $entidad->setFechainicio(empty($data['datos']['fechasaplicacion']) ? null :new \DateTime($data['datos']['fechasaplicacion']));
            $entidad->setFechafin(empty($data['datos']['fechasfinaplicacion']) ? null :new \DateTime($data['datos']['fechasfinaplicacion']));
            if ($data['filtros']['tipoid'] == 1) {
                $entidad->setHorainicio(empty($data['datos']['horainicioaplicacion']) ? null : ($data['datos']['horainicioaplicacion']));
            } else {
                $entidad->setHorainicio(empty($data['datos']['comentarios']) ? null : ($data['datos']['comentarios']));
            }

            $entidad->setHorafin(empty($data['datos']['horafinaplicacion']) ? null :new \DateTime($data['datos']['horafinaplicacion']));
            $entidad->setFecharevision(empty($data['datos']['fechasrevision']) ? null :new \DateTime($data['datos']['fechasrevision']));
            $entidad->setHorainiciorevision(empty($data['datos']['horainiciorevision']) ? null :new \DateTime($data['datos']['horainiciorevision']));
            $entidad->setHorafinrevision(empty($data['datos']['horafinrevision']) ? null :new \DateTime($data['datos']['horafinrevision']));
            $entidad->setComentarios(empty($data['datos']['comentarios']) ? null : $data['datos']['comentarios']);

            $entidad->setProfesorid(empty($data['filtros']['profesorid']) ?
            null : $dbm->getRepositorioById('CeProfesor', 'profesorid', $data['filtros']['profesorid'])); 

            $entidad->setLugarid(empty($data['datos']['lugaraplicacionid']) ?
            null : $dbm->getRepositorioById('Lugar', 'lugarid', $data['datos']['lugaraplicacionid']));  
            
            $entidad->setLugarrevisionid(empty($data['datos']['lugarrevisionid']) ?
            null : $dbm->getRepositorioById('Lugar', 'lugarid', $data['datos']['lugarrevisionid'])); 

            $entidad->setCupo(empty($data['datos']['cupoapliacion']) ? null : $data['datos']['cupoapliacion']);

            
            $dbm->saveRepositorio($entidad);

            $acuerdosext = $dbm->BuscarAcuerdosA($data);
            $listaext = count($acuerdosext);

            for ($o = 0; $o < $cupo; ++$o){
                if ($acuerdosext[$o] ) {

                $acuerdo = $dbm->getRepositorioById('CeAcuerdoextraordinario', 'acuerdoextraordinarioid', $acuerdosext[$o]['acuerdoextraordinarioid']);
                $acuerdo->setAgendaextraordinarioid($entidad);
                $acuerdo->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 3));
                $dbm->saveRepositorio($acuerdo);


                $extraordinario = $dbm->getRepositorioById('CeExtraordinario', 'extraordinarioid', $acuerdosext[$o]['extraordinarioid']);
                $extraordinario->setEstatusextraordinarioid($dbm->getRepositorioById('CeEstatusextraordinario', 'estatusextraordinarioid', 3));
                $dbm->saveRepositorio($extraordinario);

                $correo = $dbm->getRepositorioById('Correo', 'correoid', 19);
                $parametros = array(
                    "alumno" => ( ($acuerdosext[$o]['apellidopaterno'] ? $acuerdosext[$o]['apellidopaterno'] : "") . ' ' .
                    ($acuerdosext[$o]['apellidomaterno'] ? $acuerdosext[$o]['apellidomaterno'] : "") . ' ' .
                    ($acuerdosext[$o]['primernombre'] ? $acuerdosext[$o]['primernombre'] : "")),
                    "tipoextraordinario" => $entidad->getTipoextraordinarioid()->getNombre(),
                    "lugaraplicacion" => $entidad->getLugarid()->getNombre(),
                    "fechaaplicacion" => date("d-m-Y", strtotime( $data['datos']['fechasaplicacion'])),
                    "horaincioaplicacion" => $data['datos']['horainicioaplicacion'],
                    "horafinaplicacion" => $data['datos']['horafinrevision'],
                    "profesor" => $entidad->getProfesorid()->getApellidopaterno(). ' ' . $entidad->getProfesorid()->getNombre(),
                    "fecharevision" => date("d-m-Y", strtotime( $data['datos']['fechasrevision'])) ,
                    "lugarrevision" => $entidad->getLugarrevisionid()->getNombre(),
                    "horainiciorevision" => $data['datos']['horainiciorevision'],
                    "horafinrevision" => $data['datos']['horafinrevision'],
                    "tipo" => "creación"
                );  

                if ($acuerdosext[$o]['correo']) {
                    \AppBundle\Dominio\Correo::ServicioCorreo($acuerdosext[$o]['correo'], $parametros,  $correo, $this->get('mailer'), $attachment);    
                }
                
  
                } else {
                    break;
                }
            }
            


            for ($k=0; $k < $acuerdoe; $k++) { 
                if ($acuerdosextraordinarios[$k]) {

                    $parametros = array (
                        "alumno" => ( ($acuerdosextraordinarios[$k]['apellidopaterno'] ? $acuerdosextraordinarios[$k]['apellidopaterno'] : "") . ' ' .
                        ($acuerdosextraordinarios[$k]['apellidomaterno'] ? $acuerdosextraordinarios[$k]['apellidomaterno'] : "") . ' ' .
                        ($acuerdosextraordinarios[$k]['primernombre'] ? $acuerdosextraordinarios[$k]['primernombre'] : "")),
                        "materia"=> $acuerdosextraordinarios[$k]['materia'],
                        "tipoextraordinario" => $entidad->getTipoextraordinarioid()->getNombre(),
                        "lugaraplicacion" => $entidad->getLugarid()->getNombre(),
                        "fechaaplicacion" => date("d-m-Y", strtotime( $data['datos']['fechasaplicacion'])),
                        "horaincioaplicacion" => $data['datos']['horainicioaplicacion'],
                        "horafinaplicacion" => $data['datos']['horafinrevision'],
                        "profesor" => $entidad->getProfesorid()->getApellidopaterno(). ' ' . $entidad->getProfesorid()->getNombre(),
                        "tipo" => "modificación"
                    );

                    $correo = $dbm->getRepositorioById('Correo', 'correoid', 19);

                    if ($acuerdosextraordinarios[$k]['correo']) {
                        \AppBundle\Dominio\Correo::ServicioCorreo($acuerdosextraordinarios[$k]['correo'], $parametros,  $correo, $this->get('mailer'), $attachment);
                    }

                } else {
                    break;
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
            

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Agendaexamen/{id}", name="EliminarAgendaexamen")
     */
    public function deleteAgendaexamen($id)
    {
        try {
            $hoy = new \DateTime();
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $agenda = $dbm->getRepositorioById('CeAgendaextraordinario', 'agendaextraordinarioid', $id);
            $acuerdosporagenda = $dbm->getRepositoriosById('CeAcuerdoextraordinario', 'agendaextraordinarioid', $agenda->getAgendaextraordinarioid());
            foreach($acuerdosporagenda AS $ag){
                if ($ag->getCalificacion() > 0 || $ag->getCalificacionfinal() > 0) {
                    return new View("No se puede eliminar la agenda debido a que uno o mas alumnos ya han sido calificados", Response::HTTP_PARTIAL_CONTENT);
                }
                if($ag->getDocumentoporpagarid()) {
                    if($ag->getDocumentoporpagarid()->getPagoestatusid()->getPagoestatusid() == 2) {
                        return new View("No se puede eliminar la agenda debido a que uno o mas alumnos ya han pagado el extraordinario", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }
            if ($agenda && $agenda->getFechainicio() <= $hoy) {
                return new View("No se puede eliminar la agenda debido a que la fecha de inicio de la agenda es menor a hoy", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->removeRepositorio($agenda);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);

        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que
                la agenda ya tiene acuerdos relacionados.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
            
        }
    }

}