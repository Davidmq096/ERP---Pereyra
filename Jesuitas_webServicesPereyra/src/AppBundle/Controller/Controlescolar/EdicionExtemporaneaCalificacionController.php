<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Controller\lib\Vistas\PeriodoEvaluacionVista;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAlumnoporsolicitudedicionextemporanea;
use AppBundle\Entity\CeBitacorasolicitudextemporanea;
use AppBundle\Entity\CeSolicitudedicionextemporanea;
use AppBundle\Rest\Api;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Rubén
 */

class EdicionExtemporaneaCalificacionController extends FOSRestController
{

    /**
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/Controlescolar/EdicionExtemporaneaCalificacion/filtros", name="obtenerFiltrosEEC")
     */
    public function obtenerFiltrosEEC()
    {
        try {

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $estatusextemporanea = $dbm->getRepositoriosById('CeEstatusextemporanea', 'activo', 1);

            $periodoevaluacion = $dbm->getRepositorios('CePeriodoevaluacion');
            $gradoconjuntoperiodo = $dbm->getRepositorios('CeGradoporconjuntoperiodoescolar');
            $plantillaprofesor = $dbm->getRepositoriosById('CePlantillaprofesor', 'estatusplantillaprofesorid', 3);
            
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

            $periodoevaluacionvista = [];

            foreach ($periodoevaluacion as $item) {
                $periodo = new PeriodoEvaluacionVista();
                $periodo->setPeriodoevaluacion($item);
                $periodo->setPeriodofechas($item->getFechainicio()->format('Y/m/d') . ' - ' . $item->getFechafin()->format('Y/m/d'));
                $periodo->setPeriodoevaluacionid($item->getPeriodoevaluacionid());
                array_push($periodoevaluacionvista, $periodo);
            }

            return Api::Ok("Filtros",
                array(
                    "ciclo" => $ciclo,
                    "grado" => $grado,
                    "nivel" => $nivel,
                    "semestre" => $semestre,
                    "periodoevaluacionvista" => $periodoevaluacionvista,
                    "estatusextemporanea" => $estatusextemporanea,
                    "grupo" => $grupo,
                    "gradoconjuntoperiodo" => $gradoconjuntoperiodo,
                    "plantillaprofesor" => $plantillaprofesor,
                    "planestudios" => $planestudios,
                    "materiaporplanestudios" => $materias,
                ));
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/Controlescolar/EdicionExtemporaneaCalificacion/Alumnos", name="filtraralumnosextemporanea")
     */
    public function filtraralumnosextemporanea()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $decoded = array_filter($decoded);
            $correcto = false;
            $arraygradosvista = [];
            foreach ($decoded as $item) {
                if ($item != null) {
                    $correcto = true;
                }

            }

            if ($correcto) {
                $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
                $ppmpe = $dbm->getRepositorioById('CeProfesorpormateriaplanestudios','profesorpormateriaplanestudiosid', $decoded['profesorpormateriaplanestudiosid']);
                $arraygrado = [];
                if ($ppmpe->getTallerid()) {
                    $resultados = $dbm->AlumnoCicloGrupo($ppmpe->getTallerid()->getCicloid()->getCicloid(), $ppmpe->getTallerid()->getTallercurricularid(), $alumnoidr, true);
                    $gradoportaller =  $dbm->getRepositoriosById('CeGradoportallercurricular','tallercurricularid',$ppmpe->getTallerid());
                    foreach($gradoportaller as $g) {
                        array_push($arraygrado, $g->getGradoid()->getGrado());
                    }
                    if ($gradoportaller) {
                        $grado = implode(",", $arraygrado);
                        $encabezado = [
                            "nivel" => $gradoportaller[0]->getGradoid()->getNivelid()->getNombre(),
                            "grado" => $grado
                        ];
                    }

                } else {
                    $materiaplanestudio = $ppmpe->getMateriaporplanestudioid();
                    $periodo =  $dbm->getRepositorioById('CePeriodoevaluacion','periodoevaluacionid', $decoded['periodoevaluacionid']);
                    $decoded['cicloid'] = $periodo->getConjuntoperiodoevaluacionid()->getCicloid()->getCicloid();
                    $decoded['grupoid'] = $ppmpe->getGrupoid()->getGrupoid();
                    $decoded['gradoid'] = $ppmpe->getGrupoid()->getGradoid()->getGradoid();
                    $decoded['nivelid'] = $ppmpe->getGrupoid()->getGradoid()->getNivelid()->getNivelid();
                    $decoded['materiaid'] = $materiaplanestudio->getMateriaid()->getMateriaid();
                    $resultados = $dbm->ObtenerAlumnosEdicionExtemporanea($decoded);
                    $encabezado = [
                        "nivel" => $ppmpe->getGrupoid()->getGradoid()->getNivelid()->getNombre(),
                        "grado" => $ppmpe->getGrupoid()->getGradoid()->getGrado()
                    ];                    
                }
            } else {
                return Api::Error(Response::HTTP_BAD_REQUEST, "Parámetros de entrada incorrectos.");
            }

            return Api::Ok(array("resultados" => $resultados, "encabezado" => $encabezado));
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/Controlescolar/EdicionExtemporaneaCalificacion", name="guardarEdicionExtemporanea")
     */
    public function guardarEdicionExtemporanea()
    {
        try {
            $nusuarios = 0;
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $arraynivel = [];
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $estatus = $dbm->getRepositorioById('CeEstatusextemporanea', 'estatusextemporaneaid', 1);

            $alumnospermitidos = $dbm->ObtenerAlumnosPermitidos($decoded["data"]);

            if (!empty($alumnospermitidos)) {
                return Api::Error(Response::HTTP_PARTIAL_CONTENT, "Uno o más alumnos ya tienen un proceso activo ");
            }

            $dbm->getConnection()->beginTransaction();

            $solicitud = $hydrator->hydrate(new CeSolicitudedicionextemporanea(), $decoded["data"]);
            $solicitud->setEstatusextemporaneaid($estatus);
            $dbm->saveRepositorio($solicitud);
            foreach ($decoded["data"]["alumnosids"] as $item) {
                $nusuarios ++;
                $alumnoedicionextemporanea = new CeAlumnoporsolicitudedicionextemporanea();
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $item);

                if (empty($alumno)) {
                    return Api::Error(Response::HTTP_BAD_REQUEST, "Alumno no encontrado");
                }

                $alumnoedicionextemporanea->setAlumnoid($alumno);
                $alumnoedicionextemporanea->setSolicitudedicionextemporaneaid($solicitud);
                $dbm->saveRepositorio($alumnoedicionextemporanea);
            }

            //$usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $decoded["data"]['solicitanteid']);
            $solicitante = $dbm->ObtenerUsuario($decoded["data"]['solicitanteid']);
            /*
            $solicitante = null;

            if ($usuario->getPersonaid() != null) {
            $solicitante = $dbm->getRepositorioById('Persona', 'personaid', $usuario->getPersonaid());
            } else {
            if ($usuario->getProfesorid() != null) {
            $solicitante = $dbm->getRepositorioById('CeProfesor', 'profesorid', $usuario->getProfesorid());
            } else {
            //Errro en el usuario
            return Api::Error(Response::HTTP_BAD_REQUEST, "Solicitante no encontrado");
            }
            }
             */

            $bitacorasolicitudextemporanea = new CeBitacorasolicitudextemporanea();
            $bitacorasolicitudextemporanea->setSolicitudedicionExtemporaneaid($solicitud);
            $bitacorasolicitudextemporanea->setFecha(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
            $bitacorasolicitudextemporanea->setEstatus($estatus->getNombre());
            $bitacorasolicitudextemporanea->setUsuario($solicitante[0]["PersonaId"] ? $solicitante[0]['NombreCompletoPersona'] : ($solicitante[0]["ProfesorId"] ? $solicitante[0]['NombreCompletoProfesor'] : ""));
            $bitacorasolicitudextemporanea->setObservaciones($decoded["data"]["motivo"]);
            $dbm->saveRepositorio($bitacorasolicitudextemporanea);

            $dbm->getConnection()->commit();

            $ppme = $solicitud->getProfesorpormateriaplanestudiosid();
            if (!empty($ppme->getMateriaporplanestudioid())) {
                $nivel = $ppme->getMateriaporplanestudioid()->getMateriaid()->getNivelid()->getNivelid();
                $gradoid = $ppme->getGrupoid()->getGradoid()->getGradoid();
                $usuariodestino = $ppme->getMateriaporplanestudioid()->getMateriaid()->getAreaacademicaid()->getUsuarioid();
            } else if (!empty($ppme->getTallerid())) {
                $grados = $dbm->getRepositorioById('CeGradoportallercurricular', 'tallercurricularid', $ppme->getTallerid()->getTallercurricularid());
                $gradoid = $grados->getGradoid()->getGradoid();
                $nivel = $grados->getGradoid()->getNivelid()->getNivelid();
                $usuariodestino = $grados->getMateriaporplanestudioid()->getMateriaid()->getAreaacademicaid()->getUsuarioid();
            }

            if ($nivel) {
                $niveld = $dbm->getRepositorioById('Nivel', 'nivelid', $nivel);
                $gradod = $dbm->getRepositorioById('Grado', 'gradoid', $gradoid);
            }

            $entidad=$solicitud;

            /*Se dejan de usar los parametros para usar el usuario relacionado al area academica
            if ($nivel==1){
                $usuariodestino=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionEdicionExtemporaneaPreescolar")->getValor();
            }
            if ($nivel==2){
                $usuariodestino=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionEdicionExtemporaneaPrimaria")->getValor();
            }
            if ($nivel==3){
                $usuariodestino=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionEdicionExtemporaneaSecundaria")->getValor();
            }
            if ($nivel==4){
                $usuariodestino=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionEdicionExtemporaneaBachillerato")->getValor();
            }
            */


            if($usuariodestino){
                $parametros = [
                    "Grado" => $gradod->getGrado(),
                    "Nivel" => $niveld->getNombre(),
                    "UsuarioOrigen" => $solicitante[0]["PersonaId"] ? $solicitante[0]['NombreCompletoPersona'] : ($solicitante[0]["ProfesorId"] ? $solicitante[0]['NombreCompletoProfesor'] : ""),
                    "Registros" => $nusuarios
                ];

                $actividad=[
                    "tipoactividadid"=>4,
                    "usuarioorigenid"=>$entidad->getSolicitanteid()->getUsuarioid(),
                    "usuariodestinoid"=>$usuariodestino->getUsuarioid(),
                    "registros"=>count($decoded["data"]["alumnosids"])
                ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),$parametros);
            }

            return Api::Ok("Guardado #" . count($decoded["data"]["alumnosids"]), $solicitud);
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Put("/api/Controlescolar/EdicionExtemporaneaCalificacion", name="editarEdicionExtemporanea")
     */
    public function editarEdicionExtemporanea()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $estatus = $dbm->getRepositorioById('CeEstatusextemporanea', 'estatusextemporaneaid', 1);

            $alumnospermitidos = $dbm->ObtenerAlumnosPermitidos($decoded["data"]);

            if (!empty($alumnospermitidos)) {
                return Api::Error(Response::HTTP_BAD_REQUEST, "Uno o más alumnos ya tienen un proceso activo " . $alumnospermitidos);
            }

            $dbm->getConnection()->beginTransaction();
            $solicitud = $hydrator->hydrate($dbm->getRepositorioById('CeSolicitudedicionextemporanea', 'solicitudedicionextemporaneaid', $decoded["data"]["solicitudedicionextemporaneaid"]), $decoded["data"]);
            $solicitud->setEstatusextemporaneaid($estatus);
            $dbm->saveRepositorio($solicitud);
            $dbm->removeManyRepositorio('CeAlumnoporsolicitudedicionextemporanea', 'solicitudedicionextemporaneaid', $decoded["data"]['solicitudedicionextemporaneaid']);
            foreach ($decoded["data"]["alumnosids"] as $item) {
                $alumnoedicionextemporanea = new CeAlumnoporsolicitudedicionextemporanea();
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $item);

                if (empty($alumno)) {
                    return Api::Error(Response::HTTP_BAD_REQUEST, "Alumno no encontrado.");
                }

                $alumnoedicionextemporanea->setAlumnoid($alumno);
                $alumnoedicionextemporanea->setSolicitudedicionextemporaneaid($solicitud);
                $dbm->saveRepositorio($alumnoedicionextemporanea);
            }

            //$usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $decoded["data"]['solicitanteid']);
            $solicitante = $dbm->ObtenerUsuario($decoded["data"]['solicitanteid']);
            /*
            $solicitante = null;

            if ($usuario->getPersonaid() != null) {
            $solicitante = $dbm->getRepositorioById('Persona', 'personaid', $usuario->getPersonaid());
            } else {
            if ($usuario->getProfesorid() != null) {
            $solicitante = $dbm->getRepositorioById('CeProfesor', 'profesorid', $usuario->getProfesorid());
            } else {
            //Errro en el usuario
            return Api::Error(Response::HTTP_BAD_REQUEST, "Solicitante no encontrado");
            }
            }
             */

            $bitacorasolicitudextemporanea = new CeBitacorasolicitudextemporanea();
            $bitacorasolicitudextemporanea->setSolicitudedicionExtemporaneaid($solicitud);
            $bitacorasolicitudextemporanea->setFecha(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
            $bitacorasolicitudextemporanea->setEstatus($estatus->getNombre());
            $bitacorasolicitudextemporanea->setUsuario($solicitante[0]['NombreCompletoPersona']);
            $bitacorasolicitudextemporanea->setObservaciones($decoded["data"]["motivo"]);
            $dbm->saveRepositorio($bitacorasolicitudextemporanea);

            $dbm->getConnection()->commit();

            return Api::Ok("Guardado #" . count($decoded["data"]["alumnosids"]), $solicitud);
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/Controlescolar/EdicionExtemporaneaCalificacion/Filtrar", name="filtrarExtemporanea")
     */
    public function filtrarExtemporanea()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $decoded = array_filter($decoded);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $result = $dbm->ObtenerSolicitudesEdicionExtemporanea($decoded);

            return new View($result, Response::HTTP_OK);
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/Controlescolar/EdicionExtemporaneaCalificacion/{id}", name="DetalleAlumnosSolicitudEdicinExtemporanea")
     */
    public function DetalleAlumnosSolicitudEdicinExtemporanea($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());            
            $solicitud = $dbm->getRepositorioById('CeSolicitudedicionextemporanea', 'solicitudedicionextemporaneaid', $id);
            $alumnossolicitud = $dbm->ObtenerAlumnos($id);
            $bitacoras = $dbm->getRepositoriosById('CeBitacorasolicitudextemporanea', 'solicitudedicionextemporaneaid', $id);
            foreach ($bitacoras as $b){
                $barray=array("fecha"=>$b->getFecha()->format('d/m/Y H:i:s'),"estatus"=>$b->getEstatus(),"usuario"=>$b->getUsuario(),"observaciones"=>$b->getObservaciones(),"bitacorasolicitudextemporaneaid"=>$b->getBitacorasolicitudextemporaneaid(),"solicitudedicionextemporaneaid"=>$b->getSolicitudedicionextemporaneaid());
                $bitacora[]=$barray;
            }
            return new View(array(
                "solicitud" => $solicitud,
                "bitacora" => $bitacora,
                "alumnos" => $alumnossolicitud,
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/Controlescolar/EdicionExtemporaneaCalificacion/dictaminar", name="autorizarExtemporanea")
     */
    public function autorizarExtemporanea()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $decoded = array_filter($decoded);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $arrayusuarios = [];
            $solicitante = $dbm->ObtenerUsuario($decoded["data"]["usuarioid"]);
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $decoded["data"]['usuarioid']);
            $estatus = $dbm->getRepositorioById('CeEstatusextemporanea', 'estatusextemporaneaid', $decoded["data"]["estatusextemporaneaid"]);
            $solicitud = $dbm->getRepositorioById('CeSolicitudedicionextemporanea', 'solicitudedicionextemporaneaid', $decoded["data"]["solicitudedicionextemporaneaid"]);
            $materiaplanestudiio = null;
            $dbm->getConnection()->beginTransaction();
            switch ($estatus->getEstatusextemporaneaid()) {
                case 1:
                    return Api::Error(Response::HTTP_BAD_REQUEST, "Estatus no admitido para dictaminar");
                    break;
                case 2:
                    $solicitud->setEstatusextemporaneaid($estatus);
                    $solicitud->setFechaultimocambio(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
                    $solicitud->setUsuarioultimocambioid($usuario);
                    $dbm->saveRepositorio($solicitud);
                    break;
                case 3:
                    $solicitud->setEstatusextemporaneaid($estatus);
                    $solicitud->setObservaciones($decoded["data"]["observaciones"]);
                    $solicitud->setFechaultimocambio(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
                    $solicitud->setUsuarioultimocambioid($usuario);
                    $dbm->saveRepositorio($solicitud);
                    break;
                case 4:
                    $filtros = ["periodoevaluacionid" => $solicitud->getPeriodoevaluacionid()->getPeriodoevaluacionid(),
                    "profesorpormateriaplanestudiosid" => $solicitud->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid()];

                    $solicitud->setEstatusextemporaneaid($estatus);
                    $solicitud->setObservaciones($decoded["data"]["observaciones"]);
                    $solicitud->setFechainicio(new \DateTime($decoded["data"]["fechainicio"]));
                    $solicitud->setFechafin(new \DateTime($decoded["data"]["fechafin"]));
                    $solicitud->setHorafin(new \DateTime($decoded["data"]["horafin"]));
                    $solicitud->setFechaultimocambio(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
                    $solicitud->setUsuarioultimocambioid($usuario);
                    $dbm->saveRepositorio($solicitud);
                    break;
                default:
                    return Api::Error(Response::HTTP_BAD_REQUEST, "Estatus no encontrado");
                    break;
            }

            $bitacorasolicitudextemporanea = new CeBitacorasolicitudextemporanea();
            $bitacorasolicitudextemporanea->setSolicitudedicionExtemporaneaid($solicitud);
            $bitacorasolicitudextemporanea->setFecha(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
            $bitacorasolicitudextemporanea->setEstatus($estatus->getNombre());
            $bitacorasolicitudextemporanea->setUsuario($solicitante[0]['NombreCompletoPersona']? $solicitante[0]['NombreCompletoPersona'] : $solicitante[0]['NombreCompletoProfesor'] );
            $bitacorasolicitudextemporanea->setObservaciones(($decoded["data"]["observaciones"]) != null ? $decoded["data"]["observaciones"] : "-");
            $dbm->saveRepositorio($bitacorasolicitudextemporanea);

            $dbm->getConnection()->commit();

            $ppme = $solicitud->getProfesorpormateriaplanestudiosid();
            if (!empty($ppme->getMateriaporplanestudioid())) {
                $nivel = $ppme->getMateriaporplanestudioid()->getMateriaid()->getNivelid()->getNivelid();
                $gradod = $ppme->getGrupoid()->getGradoid();
                $materiaplanestudio = $ppme->getMateriaporplanestudioid()->getMateriaporplanestudioid();
            } else if (!empty($ppme->getTallerid())) {
                $id = $ppme->getTallerid()->getTallercurricularid();
                $grados = $dbm->getRepositorioById('CeGradoportallercurricular', 'tallercurricularid', $ppme->getTallerid()->getTallercurricularid());
                $nivel = $grados->getGradoid()->getNivelid()->getNivelid();
                $gradod = $dbm->getRepositorioById('Grado', 'gradoid', $grados? $grados->getGradoid()->getGradoid() : 0);
                $materiaplanestudio = $grados->getMateriaporplanestudioid()->getMateriaporplanestudioid();
            }

            if ($nivel) {
                $niveld = $dbm->getRepositorioById('Nivel', 'nivelid', $nivel);
                $gradod = $dbm->getRepositorioById('Grado', 'gradoid', $gradod->getGradoid());
            }

            $usuarios = $dbm->getRepositoriosById('CeAlumnoporsolicitudedicionextemporanea', 
            'solicitudedicionextemporaneaid', $solicitud->getSolicitudedicionextemporaneaid());

            $entidad=$solicitud;
            if($entidad->getUsuarioultimocambioid()->getPersonaid()) {
                $nombreusuarioorigen = $entidad->getUsuarioultimocambioid()->getPersonaid()->getApellidopaterno()
                . ' ' .  $entidad->getUsuarioultimocambioid()->getPersonaid()->getApellidomaterno().
           ' ' .  $entidad->getUsuarioultimocambioid()->getPersonaid()->getNombre();
            } else {
                $nombreusuarioorigen = $entidad->getUsuarioultimocambioid()->getProfesorid()->getApellidopaterno()
                . ' ' .  $entidad->getUsuarioultimocambioid()->getProfesorid()->getApellidomaterno().
           ' ' .  $entidad->getUsuarioultimocambioid()->getProfesorid()->getNombre();
            }
            $parametros = [
                "Grado" => $gradod->getGrado(),
                "Nivel" => $niveld->getNombre(),
                "UsuarioOrigen" => $nombreusuarioorigen,
                "Registros" => count($usuarios),
                "materiaplanestudioid" => $materiaplanestudio
            ];

            if ($decoded["data"]["estatusextemporaneaid"]==1){
                $actividad=[
                    "tipoactividadid"=>6,
                    "usuarioorigenid"=>$entidad->getUsuarioultimocambioid()->getUsuarioid(),
                    "usuariodestinoid"=>$entidad->getSolicitanteid()->getUsuarioid()
                ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),$parametros);

            }

            if ($decoded["data"]["estatusextemporaneaid"]==2){
                if ($niveld->getNivelid() == 1) {
                    $usuariodestinoid=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionEdicionExtemporaneaPreescolarSE")->getValor();
                } else if ($niveld->getNivelid() == 2) {
                    $usuariodestinoid=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionEdicionExtemporaneaPrimariaSE")->getValor();
                } else if ($niveld->getNivelid() == 3) {
                    $usuariodestinoid=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionEdicionExtemporaneaSecundariaSE")->getValor();
                } else if ($niveld->getNivelid() == 4) {
                    $usuariodestinoid=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionEdicionExtemporaneaBachilleratoSE")->getValor();

                }
                
                $actividad=[
                    "tipoactividadid"=>28,
                    "usuarioorigenid"=>$entidad->getUsuarioultimocambioid()->getUsuarioid(),
                    "usuariodestinoid"=>$usuariodestinoid
                ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),$parametros);

            }

            if ($decoded["data"]["estatusextemporaneaid"]==3){
                $actividad=[
                    "tipoactividadid"=>5,
                    "usuarioorigenid"=>$entidad->getUsuarioultimocambioid()->getUsuarioid(),
                    "usuariodestinoid"=>$entidad->getSolicitanteid()->getUsuarioid()
                ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),$parametros);

            }
            if ($decoded["data"]["estatusextemporaneaid"]==4){
                $usuarioprof = $dbm->getRepositorioById("Usuario","profesorid", $entidad->getProfesorpormateriaplanestudiosid() ? $entidad->getProfesorpormateriaplanestudiosid()->getProfesorid()->getProfesorid(): null);
                if($usuarioprof) {
                    $usuariosdestino = $entidad->getSolicitanteid()->getUsuarioid() . ','. $usuarioprof->getUsuarioid();                
                } else {
                    $usuariosdestino = $entidad->getSolicitanteid()->getUsuarioid();                
                }
                $actividad=[
                    "tipoactividadid"=>7,
                    "usuarioorigenid"=>$entidad->getUsuarioultimocambioid()->getUsuarioid(),
                    "usuariodestinoid"=>$usuariosdestino
                ];
                \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'),$parametros);
                
            }
            
            

            return new View(array(
                "solicitud" => $solicitud,
                "bitacora" => $bitacorasolicitudextemporanea,
            ), Response::HTTP_OK);

        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }

}
