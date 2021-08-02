<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Entity\Ciclo;
use AppBundle\Entity\Materia;
use FOS\RestBundle\View\View;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAreaacademica;
use AppBundle\Entity\CePlanestudios;
use AppBundle\Entity\CeMateriaporplanestudios;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CeConfiguracionsubmaterias;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Entity\CeFormaconfiguracionsubmateria;

/**
 * @author Rubén
 */
class PlanEstudioController extends FOSRestController
{

    /**
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/ControlEscolar/PlanEstudio/Materias", name="obtenermateriasplanestudios")
     */
    public function obtenermateriasplanestudios()
    {
        try {
            $decoded = $_REQUEST;
            $materiaid = $decoded['materiaid'];
            $materiaplanestudioid = $decoded['materiaporplanestudioid'];

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $materias = $dbm->getRepositoriosById('Materia', 'materiapadreid', $materiaid);
            $materiasplanestudio = $dbm->getRepositoriosById('CeMateriaporplanestudios', 'materiaporplanestudioid', $materiaplanestudioid);
            $materiasasignadas = [];
            $materiasporasignar = [];
            $mensaje = null;

            if(!empty($materiaplanestudio)) {
                $profesores = $dbm->getRepositoriosModelo("CeMateriaporplanestudios", 
                ["SUM(CASE WHEN pmpe.materiaporplanestudioid is not null or h.gradoportallercurricularid is not null then 1 else 0 end) as id"], 
    
                    [["materiaporplanestudioid = " . $materiaplanestudioid]], false, true, [
                    ["entidad" => "CeProfesorpormateriaplanestudios", "alias" => "pmpe", "left" => true, "on" => "pmpe.materiaporplanestudioid = d.materiaporplanestudioid"],
                    ["entidad" => "CeGradoportallercurricular", "alias" => "h", "left" => true, "on" => "d.materiaporplanestudioid = h.materiaporplanestudioid"],
                ])[0];
    
                
                if($profesores && intval($profesores['id']) > 0) {
                    $mensaje = "No es posible editar esta materia por que ya esta relacionada a un profesor.";
                }
    
                $criterios = $dbm->getRepositoriosModelo("CeMateriaporplanestudios", 
                ["cce.conjuntocriterioevaluacionid"], 
    
                    [["materiaporplanestudioid = " . $materiaplanestudioid]], false, true, [
                    ["entidad" => "CeConjuntocriterioevaluacion", "alias" => "cce", "left" => false, "on" => "cce.materiaporplanestudioid = d.materiaporplanestudioid"],
                ])[0];
            }

            if($criterios) {
                $mensajecriterio = "No es posible editar esta materia por que ya esta relacionada a una plantilla de criterios.";
            } 

            if (!empty($materias)) {
                foreach ($materias as $materia) {
                    $materia->setMateriapadreid(null);
                    $materia->setNivelid(null);
                    array_push($materiasporasignar, $materia);

                }
            }

            if (!empty($materiasplanestudio)) {
                $formaconfiguracion = $dbm->getRepositorioById('CeFormaconfiguracionsubmateria', 'materiaporplanestudioid', $materiaplanestudioid);
            }

            if(!empty($formaconfiguracion)){
                $configuracionsubmaterias = $dbm->getRepositoriosById('CeConfiguracionsubmaterias', 'formaconfiguracionsubmateriaid', 
                $formaconfiguracion->getFormaconfiguracionsubmateriaid());
                foreach ($configuracionsubmaterias as $configuracion) {
                    $materia = $dbm->getRepositorioById('Materia', 'materiaid', $configuracion->getMateriaid()->getMateriaid());
                    array_push($materiasasignadas, $materia);
                }
            }            

            return new View(array(
                "materias" => $materiasporasignar,
                "materiasplanestudio" => $configuracionsubmaterias,
                "mensaje" => $mensaje,
                "mensajecriterio" => $mensajecriterio,
                "formaconfiguracion" => $formaconfiguracion),
                Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Javier
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/ControlEscolar/PlanEstudio", name="indexPlanestudio")
     */
    public function indexPlanestudio()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $areaespecializacion = $dbm->getRepositoriosById('CeAreaespecializacion', 'activo', 1, 'nombre');
            $tiporedondeo = $dbm->getRepositoriosById('CeTiporedondeo', 'activo', 1);

            return new View(array("ciclo" => $ciclo,
                "grado" => $grado,
                "nivel" => $nivel,
                "semestre" => $semestre,
                "areaespecializacion" => $areaespecializacion,
                "tiporedondeo" => $tiporedondeo), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Javier
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/ControlEscolar/PlanEstudio/Materia", name="indexPlanestudioMateria")
     */
    public function indexPlanestudioMateria()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $materiafrecuenciacaptura = $dbm->getRepositoriosById('CeMateriafrecuenciacaptura', 'activo', 1);
            $tipo = $dbm->getRepositoriosById('CeTipocalificacion', 'activo', 1);
            $ponderacion = $dbm->getRepositoriosById('CePonderacion', 'activo', 1);
            $curricular = $dbm->getRepositoriosById('CeComponentecurricular', 'activo', 1);
            if ($filtros["planestudioid"]){
                $materias = $dbm->getMateriasPorPlanEstudio($filtros);
            }

            return new View(array("materiafrecuenciacaptura" => $materiafrecuenciacaptura,
                "tipocalificacion" => $tipo,
                "ponderacion" => $ponderacion,
                "curricular" => $curricular,
                "materias" => $materias), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Javier
     * Retorna arreglo de Ciclos en base a los parametros enviados
     * @Rest\Get("/api/ControlEscolar/PlanEstudio/", name="BuscarPlanestudio")
     */
    public function getPlanestudio()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarPlanestudio($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/ControlEscolar/PlanEstudio", name="planestudiosguardar")
     */
    public function planestudiosguardar()
    {
        try {
            $datos = $_REQUEST;
            $decoded = json_decode($datos["datos"], true);
            $dbm = $this->get("db_manager");

            $validar = $dbm->getOneByParametersRepositorio("CePlanestudios", [
                "nombre" => $decoded['nombre']
            ]);
            if ($validar) {
                return new View("Ya existe un plan de estudio con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            if ($decoded['vigente']){
                if($decoded['gradoid'] == 17 || $decoded['gradoid'] == 18){
                    $planestudiosbusqueda = $dbm->getByParametersRepositorios('CePlanestudios', array(
                        "gradoid" => $decoded['gradoid'],
                        "areaespecializacionid" => $decoded['areaespecializacionid'],
                        "vigente" => "1",
                    ));
                }else{
                    $planestudiosbusqueda = $dbm->getByParametersRepositorios('CePlanestudios', array(
                        "gradoid" => $decoded['gradoid'],
                        "vigente" => "1",
                    ));
                }



                if (!empty($planestudiosbusqueda)) {
                    return new View("Ya existe un plan de estudios vigente.", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            

            $planestudios = $hydrator->hydrate('AppBundle\Entity\CePlanestudios', $decoded);
            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($planestudios);
            $dbm->getConnection()->commit();

            return new View(array("mensaje" => "Registro agregado de forma correcta",
                "planestudios" => $planestudios), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Put("/api/ControlEscolar/PlanEstudio", name="planestudioseditar")
     */
    public function planestudioseditar()
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $decoded = json_decode($datos["datos"], true);
            $dbm = $this->get("db_manager");

            $validar = $dbm->getOneByParametersRepositorio("CePlanestudios", [
                "nombre" => $decoded['nombre']
            ]);
            if ($validar && $validar->getPlanestudioid() != $decoded['planestudioid']) {
                return new View("Ya existe un plan de estudio con el mismo nombre", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            if ($decoded['vigente']){
                if($decoded['gradoid'] == 17 || $decoded['gradoid'] == 18){
                    $planestudiosbusqueda = $dbm->getByParametersRepositorios('CePlanestudios', array(
                        "gradoid" => $decoded['gradoid'],
                        "areaespecializacionid" => $decoded['areaespecializacionid'],
                        "vigente" => "1",
                    ));
                }else{
                    $planestudiosbusqueda = $dbm->getByParametersRepositorios('CePlanestudios', array(
                        "gradoid" => $decoded['gradoid'],
                        "vigente" => "1",
                    ));
                }


                if (!empty($planestudiosbusqueda)) {
                    if (($planestudiosbusqueda[0]->getPlanestudioid() != $decoded['planestudioid'])) {
                        return new View("Ya existe un plan de estudios vigente.", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }

            $planestudios = $hydrator->hydrate($dbm->getRepositorioById('CePlanestudios', 'planestudioid', $decoded['planestudioid']), $decoded);
            if($planestudios->getVigente() == true || $planestudios->getVigente()== 1){
                $planestudios->setCiclofinalid(null);
            }
            if(!$decoded['areaespecializacionid']){
                $planestudios->setAreaespecializacionid(null);
            }
            $dbm->getConnection()->beginTransaction();
            $dbm->saveRepositorio($planestudios);
            $dbm->getConnection()->commit();

            return new View(array("mensaje" => "Registro actualizado de forma correcta",
                "planestudios" => $planestudios), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Delete("/api/ControlEscolar/PlanEstudio/{id}", name="planestudioseliminar")
     */
    public function planestudioseliminar($id)
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            $planestudios = $dbm->getRepositorioById('CePlanestudios', 'planestudioid', $id);

            if (empty($planestudios)) {
                return new View("El plan de estudios no existe.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            $dbm->removeRepositorio($planestudios);
            $dbm->getConnection()->commit();

            return new View("Registro eliminado de forma correcta.", Response::HTTP_OK);
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
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/ControlEscolar/PlanEstudio/Copia", name="planestudicopia")
     */
    public function planestudicopia()
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            if (empty($decoded['planestudioid']) || empty($decoded['nuevocicloid']) || empty($decoded['nombre'])) {
                return new View("Información enviada incompleta.", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm = $this->get("db_manager");
            $planestudio = new CePlanestudios();
            
            $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $decoded['nuevocicloid']);

            if (empty($ciclo)) {
                return new View("No se encontró el nuevo ciclo, favor de revisar la información enviada.", Response::HTTP_PARTIAL_CONTENT);
            }            
               
            $dbm->getConnection()->beginTransaction();
            if(empty($decoded['areasacademicasids'])){

                    $planestudiobusqueda = $dbm->getRepositorioById('CePlanestudios', 
                    "planestudioid", $decoded['planestudioid']                
                    );

                    if (empty($planestudiobusqueda)) {
                        return new View("Plan de estudios no encontrado con la información enviada.", Response::HTTP_PARTIAL_CONTENT);
                    }
                    
                    $planestudiobusqueda = $dbm->getRepositorioById('CePlanestudios', 
                    "planestudioid", $decoded['planestudioid']                
                    );
/*
                    $planestudioexiste = $dbm->getByParametersRepositorios('CePlanestudios', array(                        
                        "cicloinicialid" => $decoded['nuevocicloid'],
                        "vigente" => "1"                        
                    ));

                    if(!empty($planestudioexiste)){
                        return new View("Plan de estudios con la información enviada, ya existe y está vigente.", Response::HTTP_PARTIAL_CONTENT);
                    }
*/
                    $nuevoplanestudio = new CePlanestudios(); 
                    $nuevoplanestudio->setNombre($decoded['nombre']);
                    $nuevoplanestudio->setVigente(false);
                    $nuevoplanestudio->setPuntopase($planestudiobusqueda->getPuntopase());
                    $nuevoplanestudio->setCalificacionminima($planestudiobusqueda->getCalificacionminima());
                    $nuevoplanestudio->setAreaespecializacionid($planestudiobusqueda->getAreaespecializacionid());
                    $nuevoplanestudio->setCiclofinalid(null);
                    $nuevoplanestudio->setCicloinicialid($ciclo);
                    $nuevoplanestudio->setGradoid($planestudiobusqueda->getGradoid());
                    $nuevoplanestudio->setTiporedondeofinalid($planestudiobusqueda->getTiporedondeofinalid());
                    $nuevoplanestudio->setTiporedondeoperiodoid($planestudiobusqueda->getTiporedondeoperiodoid()); 
                    $nuevoplanestudio->setTiporedondeoperiodoid($planestudiobusqueda->getTiporedondeoperiodoid()); 
                    $nuevoplanestudio->setDecimalescapturanumerica($planestudiobusqueda->getDecimalescapturanumerica()); 
                    $dbm->saveRepositorio($nuevoplanestudio);    
    
                    $materiasplanestudios = $dbm->getByParametersRepositorios('CeMateriaporplanestudios', array(
                        "planestudioid" => $planestudiobusqueda->getPlanestudioid(),
                    ));
    
                    if(empty($materiasplanestudios)){
                        return new View("No se creó la copia, ya que no cuenta con materias ligadas.", Response::HTTP_PARTIAL_CONTENT);
                    }else{
                        foreach($materiasplanestudios as $materiaplanestudio){
                            $materiaporplanestudios = new CeMateriaporplanestudios();
    
                            $materiaporplanestudios->setOrdenoficial($materiaplanestudio->getOrdenoficial());
                            $materiaporplanestudios->setOrdeninterno($materiaplanestudio->getOrdeninterno());
                            $materiaporplanestudios->setEscurricular($materiaplanestudio->getEscurricular());
                            $materiaporplanestudios->setSeimprimeenboleta($materiaplanestudio->getSeimprimeenboleta());
                            $materiaporplanestudios->setImprimirsubmateriaymateria($materiaplanestudio->getImprimirsubmateriaymateria());
                            $materiaporplanestudios->setPromediointerno($materiaplanestudio->getPromediointerno());
                            $materiaporplanestudios->setRequieremaestrotitular($materiaplanestudio->getRequieremaestrotitular());
                            $materiaporplanestudios->setRequieremaestrocotitular($materiaplanestudio->getRequieremaestrocotitular());
                            $materiaporplanestudios->setRequierecapturadecomentarios($materiaplanestudio->getRequierecapturadecomentarios());
                            $materiaporplanestudios->setConfigurarsubmaterias($materiaplanestudio->getConfigurarsubmaterias());
                            $materiaporplanestudios->setConfigurarsubgrupos($materiaplanestudio->getConfigurarsubgrupos());
                            $materiaporplanestudios->setRequiereconfigurarherramientas($materiaplanestudio->getRequiereconfigurarherramientas());
                            $materiaporplanestudios->setRequiereconfigurarapoyos($materiaplanestudio->getRequiereconfigurarapoyos());
                            $materiaporplanestudios->setPlanestudioid($nuevoplanestudio);
                            $materiaporplanestudios->setMateriaid($materiaplanestudio->getMateriaid());
                            $materiaporplanestudios->setComponentecurricularid($materiaplanestudio->getComponentecurricularid());
                            $materiaporplanestudios->setMateriafrecuenciacapturaid($materiaplanestudio->getMateriafrecuenciacapturaid());
                            $materiaporplanestudios->setHorasporsemana($materiaplanestudio->getHorasporsemana());
    
                            $dbm->saveRepositorio($materiaporplanestudios);    
    
                            $nuevaformaconfiguracionsubmateria = new CeFormaconfiguracionsubmateria();
                            $formaconfiguracionsubmateria = $dbm->getRepositorioById('CeFormaconfiguracionsubmateria', 
                            'materiaporplanestudioid', $materiaplanestudio->getMateriaporplanestudioid());
                            if(!empty($formaconfiguracionsubmateria)){
                                $nuevaformaconfiguracionsubmateria->setFormacalificar($formaconfiguracionsubmateria->getFormacalificar());
                                $nuevaformaconfiguracionsubmateria->setFormacaptura($formaconfiguracionsubmateria->getFormacaptura());
                                $nuevaformaconfiguracionsubmateria->setMateriaporplanestudioid($materiaporplanestudios);  
                                
                                $dbm->saveRepositorio($nuevaformaconfiguracionsubmateria);  
                                
                                $submaterias = $dbm->getByParametersRepositorios('CeConfiguracionsubmaterias', array(
                                    "formaconfiguracionsubmateriaid" => $formaconfiguracionsubmateria->getFormaconfiguracionsubmateriaid(),
                                ));
    
                                foreach($submaterias as $submateria){
                                    $nuevaconfiguracionsubmateria = new CeConfiguracionsubmaterias();
                                    $nuevaconfiguracionsubmateria->setPorcentajecalificacion($submateria->getPorcentajecalificacion());
                                    $nuevaconfiguracionsubmateria->setFormaconfiguracionsubmateriaid($nuevaformaconfiguracionsubmateria);
                                    $nuevaconfiguracionsubmateria->setMateriaid($submateria->getMateriaid());
    
                                    $dbm->saveRepositorio($nuevaconfiguracionsubmateria);
                                }                            
                            }                                                
                        }
                    }
            }else{
                foreach($decoded['areasacademicasids'] as $id){
                    $areaacademica = $dbm->getRepositorioById('CeAreaespecializacion', 'areaacademicaid', $id);
    
                    if(empty($areaacademica)){
                        return new View("Área académica no encontrada.".  $id, Response::HTTP_PARTIAL_CONTENT);
                    }

                    $planestudiobusqueda = $dbm->getRepositorioById('CePlanestudios', 
                    "planestudioid", $decoded['planestudioid']                
                    );

                    if (empty($planestudiobusqueda)) {
                        return new View("Plan de estudios no encontrado con la información enviada.", Response::HTTP_PARTIAL_CONTENT);
                    }
                    
                    $planestudiobusqueda = $dbm->getRepositorioById('CePlanestudios', 
                    "planestudioid", $decoded['planestudioid']                
                    );
/*
                    $planestudioexiste = $dbm->getByParametersRepositorios('CePlanestudios', array(                        
                        "cicloinicialid" => $decoded['nuevocicloid'],
                        "vigente" => "1",
                        "areaacademicaid" => $id
                    ));

                    if(!empty($planestudioexiste)){
                        $dbm->getConnection()->rollBack();
                        return new View("Plan de estudios con la información enviada, ya existe y está vigente.", Response::HTTP_PARTIAL_CONTENT);
                    }
*/
                    $nuevoplanestudio = new CePlanestudios();    
                    $nuevoplanestudio->setNombre($decoded['nombre']);
                    $nuevoplanestudio->setVigente(true);
                    $nuevoplanestudio->setPuntopase($planestudiobusqueda->getPuntopase());
                    $nuevoplanestudio->setCalificacionminima($planestudiobusqueda->getCalificacionminima());
                    $nuevoplanestudio->setAreaespecializacionid($areaacademica);
                    $nuevoplanestudio->setCiclofinalid(null);
                    $nuevoplanestudio->setCicloinicialid($ciclo);
                    $nuevoplanestudio->setGradoid($planestudiobusqueda->getGradoid());
                    $nuevoplanestudio->setTiporedondeofinalid($planestudiobusqueda->getTiporedondeofinalid());
                    $nuevoplanestudio->setTiporedondeoperiodoid($planestudiobusqueda->getTiporedondeoperiodoid()); 
                    $dbm->saveRepositorio($nuevoplanestudio);    
    
                    $materiasplanestudios = $dbm->getByParametersRepositorios('CeMateriaporplanestudios', array(
                        "planestudioid" => $planestudiobusqueda->getPlanestudioid(),
                    ));
    
                    if(empty($materiasplanestudios)){
                        return new View("No se creó la copia, ya que no cuenta con materias ligadas.", Response::HTTP_PARTIAL_CONTENT);
                    }else{
                        foreach($materiasplanestudios as $materiaplanestudio){
                            $materiaporplanestudios = new CeMateriaporplanestudios();
    
                            $materiaporplanestudios->setOrdenoficial($materiaplanestudio->getOrdenoficial());
                            $materiaporplanestudios->setOrdeninterno($materiaplanestudio->getOrdeninterno());
                            $materiaporplanestudios->setEscurricular($materiaplanestudio->getEscurricular());
                            $materiaporplanestudios->setSeimprimeenboleta($materiaplanestudio->getSeimprimeenboleta());
                            $materiaporplanestudios->setImprimirsubmateriaymateria($materiaplanestudio->getImprimirsubmateriaymateria());
                            $materiaporplanestudios->setPromediointerno($materiaplanestudio->getPromediointerno());
                            $materiaporplanestudios->setRequieremaestrotitular($materiaplanestudio->getRequieremaestrotitular());
                            $materiaporplanestudios->setRequieremaestrocotitular($materiaplanestudio->getRequieremaestrocotitular());
                            $materiaporplanestudios->setRequierecapturadecomentarios($materiaplanestudio->getRequierecapturadecomentarios());
                            $materiaporplanestudios->setConfigurarsubmaterias($materiaplanestudio->getConfigurarsubmaterias());
                            $materiaporplanestudios->setConfigurarsubgrupos($materiaplanestudio->getConfigurarsubgrupos());
                            $materiaporplanestudios->setRequiereconfigurarherramientas($materiaplanestudio->getRequiereconfigurarherramientas());
                            $materiaporplanestudios->setRequiereconfigurarapoyos($materiaplanestudio->getRequiereconfigurarapoyos());
                            $materiaporplanestudios->setPlanestudioid($nuevoplanestudio);
                            $materiaporplanestudios->setMateriaid($materiaplanestudio->getMateriaid());
                            $materiaporplanestudios->setPonderacionid($materiaplanestudio->getPonderacionid());
                            $materiaporplanestudios->setMateriafrecuenciacapturaid($materiaplanestudio->getMateriafrecuenciacapturaid());
    
                            $dbm->saveRepositorio($materiaporplanestudios);    
    
                            $nuevaformaconfiguracionsubmateria = new CeFormaconfiguracionsubmateria();
                            $formaconfiguracionsubmateria = $dbm->getRepositorioById('CeFormaconfiguracionsubmateria', 
                            'materiaporplanestudioid', $materiaplanestudio->getMateriaporplanestudioid());
                            if(!empty($formaconfiguracionsubmateria)){
                                $nuevaformaconfiguracionsubmateria->setFormacalificar($formaconfiguracionsubmateria->getFormacalificar());
                                $nuevaformaconfiguracionsubmateria->setFormacaptura($formaconfiguracionsubmateria->getFormacaptura());
                                $nuevaformaconfiguracionsubmateria->setMateriaporplanestudioid($materiaporplanestudios); 
                                
                                $dbm->saveRepositorio($nuevaformaconfiguracionsubmateria);  
                                
                                $submaterias = $dbm->getByParametersRepositorios('CeConfiguracionsubmaterias', array(
                                    "formaconfiguracionsubmateriaid" => $formaconfiguracionsubmateria->getFormaconfiguracionsubmateriaid(),
                                ));
    
                                foreach($submaterias as $submateria){
                                    $nuevaconfiguracionsubmateria = new CeConfiguracionsubmaterias();
                                    $nuevaconfiguracionsubmateria->setPorcentajecalificacion($submateria->getPorcentajecalificacion());
                                    $nuevaconfiguracionsubmateria->setFormaconfiguracionsubmateriaid($nuevaformaconfiguracionsubmateria);
                                    $nuevaconfiguracionsubmateria->setMateriaid($submateria->getMateriaid());
    
                                    $dbm->saveRepositorio($nuevaconfiguracionsubmateria);
                                }                            
                            }                                                
                        }
                    } 
                }     
            }                 

            $dbm->getConnection()->commit();
            return new View("Proceso terminado de forma correcta.", Response::HTTP_OK);            
        } catch (\Exception $e) {
            $dbm->getConnection()->rollBack();
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Delete("/api/ControlEscolar/PlanEstudio/Materia/Eliminar/{id}", name="eliminarmateriaplanestudio")
     */
    public function eliminarmateriaplanestudio($id)
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $dbm = $this->get("db_manager");
            $materiaplanestudio = $dbm->getRepositorioById('CeMateriaporplanestudios', 'materiaporplanestudioid', $id);

            if (empty($materiaplanestudio)) {
                return new View("No existe la materia en el plan de estudio.", Response::HTTP_PARTIAL_CONTENT);
            }

            $reportarmateria=$dbm->getOneByParametersRepositorio("CeMateriaporplanestudios",array("reportarmateriaid"=>$id,"planestudioid"=>$materiaplanestudio ->getPlanestudioid()->getPlanestudioid()));

            $dbm->getConnection()->beginTransaction();
            if ($reportarmateria) {
                return new View("Exiten materias que reportan a esta materia.", Response::HTTP_PARTIAL_CONTENT);
            }

            $calificacion = $dbm->getByParametersRepositorios('CeCalificacionperiodoporalumno', array(
                "materiaporplanestudioid" => $materiaplanestudio->getMateriaporplanestudioid(),
            ));

            if (empty($calificacion)) {
                $dbm->removeRepositorio($materiaplanestudio);
            } else {
                return new View("Ya hay calificaciones ligadas a esa materia.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->commit();
            return new View("Registro eliminado de forma correcta.", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro, ya que se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            }

        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/ControlEscolar/PlanEstudio/Materias/Filtrar/{id}", name="materiasporgrupo")
     */
    public function materiasporgrupo($id)
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }

            $decoded['planestudioid'] = $id;
            if (empty($decoded['planestudioid'])) {
                return new View("El plan de estudios ID no se envió.", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm = $this->get("db_manager");
            $planestudios = $dbm->getRepositorioById('CePlanestudios', 'planestudioid', $decoded['planestudioid']);
            $decoded['nivelid'] = $planestudios->getGradoid()->getNivelid()->getNivelid();

            $dbmce = new DbmControlescolar($dbm->getEntityManager());
            $result = $dbmce->FiltrarMateriasPorGrado($decoded);

            $materias = [];
            foreach ($result as $materia) {
                $materia[0]->setNivelid(null);
                array_push($materias, $materia);
            }

            return new View($materias, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Get("/api/ControlEscolar/PlanEstudio/Filtrar/{id}", name="planestudiofiltrar")
     */
    public function planestudiofiltrar($id)
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
                $decoded = $datos;
            } else {
                $decoded = json_decode($content, true);
            }
            $dbm = $this->get("db_manager");
            $dbmce = new DbmControlescolar($dbm->getEntityManager());

            $decoded['planestudioid'] = $id;
            if (empty($decoded['planestudioid'])) {
                return new View("El plan de estudios ID no se envió.", Response::HTTP_PARTIAL_CONTENT);
            }

            $parametros = array(
                "planestudioid" => $id,
            );

            $planestudio = $dbm->getByParametersRepositorios('CePlanestudios', $parametros);

            if (empty($planestudio)) {
                return new View("No se encontró un plan de estudio con los parámetros enviados.", Response::HTTP_PARTIAL_CONTENT);
            }

            $parametros = array(
                "planestudioid" => $planestudio[0]->getPlanestudioid(),
            );

            $result = $dbmce->FiltrarMateriasPorPlanEstudio($parametros);

            $materias = [];
            foreach ($result as $materia) {
                //$materia->setPlanestudioid(null);
                $materia[0]->getmateriaid()->setNivelid(null);
                //$materia->getmateriaid()->setmateriafrecuenciacapturaid(null);
                if ($materia[0]->getReportarcalificacion()){
                    $reportarmateria=$materiareportar=$dbm->getOneByParametersRepositorio("CeMateriaporplanestudios",array("reportarmateriaid"=>$materia[0]->getMateriaid()->getmateriaid(),"planestudioid"=>$materia[0]->getPlanestudioid()->getPlanestudioid()));
                    if ($repotarmateria){
                        $materia[0]->setReportarmateriaid($reportarmateria->getMateriaid());
                    }
                }
                
                array_push($materias, $materia[0]);
            }
            /*
            $respuesta = array(
            "planestudio" => $planestudio[0],
            "materias" => $materias
            );
             */
            return new View($materias, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/ControlEscolar/PlanEstudio/Materias", name="agregarmateriasplanestudio")
     */
    public function agregarmateriasplanestudio()
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            /*
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
            $decoded = $datos;
            } else {
            $decoded = json_decode($content, true);
            }
             */
            $datos = $_REQUEST;
            $decoded = json_decode($datos["datos"], true);
            $dbm = $this->get("db_manager");
            $dbmce = new DbmControlescolar($dbm->getEntityManager());

            if (empty($decoded['materiaporplanestudio'])) {
                return new View("La materia no se envió.", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $materiaplanestudio = $hydrator->hydrate(new CeMateriaporplanestudios(), $decoded['materiaporplanestudio']);
            $materiaplanestudio->setReportarmateriaid(null);
            if ($decoded['materiaporplanestudio']["reportarmateriaid"]){
                $materiareportar=$dbm->getOneByParametersRepositorio("CeMateriaporplanestudios",array("materiaid"=>$decoded['materiaporplanestudio']["reportarmateriaid"],"planestudioid"=>$decoded['materiaporplanestudio']["planestudioid"]));
                $materiareportar->setReportarmateriaid($materiaplanestudio->getMateriaid());
                $dbm->saveRepositorio($materiareportar);
            }
            $parametros = array(
                "planestudioid" => $materiaplanestudio->getPlanestudioid()->getPlanestudioid(),
            );
            $planestudio = $dbm->getByParametersRepositorios('CePlanestudios', $parametros);

            if (empty($planestudio)) {
                return new View("Plan de estudio no encontrado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                $planestudio = $planestudio[0];
            }

            $dbm->getConnection()->beginTransaction();

            $materia = $dbm->getRepositorioById('Materia', 'materiaid', $materiaplanestudio->getMateriaid());
            if (empty($materia)) {
                return new View("Materia no enontrada, ID: " . $id, Response::HTTP_PARTIAL_CONTENT);
            } else {
                $inputs = array(
                    "planestudioid" => $planestudio->getPlanestudioid(),
                    "materiaid" => $materiaplanestudio->getMateriaid()->getMateriaid(),
                );
                $materiaplanestudiobusqueda = $dbm->getByParametersRepositorios('CeMateriaporplanestudios', $inputs);
                if (empty($materiaplanestudiobusqueda)) {
                    $dbm->saveRepositorio($materiaplanestudio);
                } else {
                    return new View("Ya existe la materia en el plan de estudio." . $id, Response::HTTP_PARTIAL_CONTENT);
                }
            }

            $crearsubmateria = $decoded['materiaporplanestudio']['configurarsubmaterias'];
            if ($crearsubmateria == null || $crearsubmateria == 0 || $crearsubmateria == false) {
            } else {                
                $formaconfiguracionsubmateria = new CeFormaconfiguracionsubmateria();
                $formaconfiguracionsubmateria->setFormacaptura($decoded['configuracionsubmaterias']['formacaptura']);
                $formaconfiguracionsubmateria->setFormacalificar($decoded['configuracionsubmaterias']['formacalificar']);
                $formaconfiguracionsubmateria->setMateriaporplanestudioid($materiaplanestudio);
                $dbm->saveRepositorio($formaconfiguracionsubmateria);

                foreach ($decoded['configuracionsubmaterias']['submaterias'] as $entidad) {
                    $submateria = new CeConfiguracionsubmaterias();
                    $submateria->setPorcentajecalificacion($entidad['porcentajecalificacion']);
                    $submateria->setMateriaid($dbm->getRepositorioById('Materia', 'materiaid', $entidad['materiaid']));
                    $submateria->setFormaconfiguracionsubmateriaid($formaconfiguracionsubmateria);
                    $dbm->saveRepositorio($submateria);
                }
            }

            $dbm->getConnection()->commit();
            return new View("Proceso realizado de forma satisfactoria.", Response::HTTP_OK);
        } catch (\Exception $e) {
            $dbm->getConnection()->rollBack();
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Put("/api/ControlEscolar/PlanEstudio/Materias", name="editarmateriasplanestudio")
     */
    public function editarmateriasplanestudio()
    {
        try {
            //COMPATIBILIDAD ENTRE FORMULARIOS Y JSON FORMAT
            /*
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            if (is_array($datos) && !empty($datos)) {
            $decoded = $datos;
            } else {
            $decoded = json_decode($content, true);
            }
             */
            parse_str(file_get_contents("php://input"), $datos);
            $decoded = json_decode($datos["datos"], true);
            $dbm = $this->get("db_manager");
            $dbmce = new DbmControlescolar($dbm->getEntityManager());

            if (empty($decoded['materiaporplanestudio'])) {
                return new View("La materia no se envió.", Response::HTTP_PARTIAL_CONTENT);
            }

            $id = $decoded['materiaporplanestudio']['materiaporplanestudioid'];
            $materiaporplanestudio = $dbm->getRepositorioById('CeMateriaporplanestudios', 'materiaporplanestudioid', $id);

            if (empty($materiaporplanestudio)) {
                return new View("El registro no se encuentra en la base de datos para editar.", Response::HTTP_PARTIAL_CONTENT);
            }

            if(!$decoded['materiaporplanestudio']['configurarsubmaterias']){
                $decoded['materiaporplanestudio']['configurarsubmaterias'] = 0;
            }
            if(!$decoded['materiaporplanestudio']['configurarsubgrupos']){
                $decoded['materiaporplanestudio']['configurarsubgrupos'] = 0;
            }
            if(!$decoded['materiaporplanestudio']['configurartaller']){
                $decoded['materiaporplanestudio']['configurartaller'] = 0;
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $materiaplanestudio = $hydrator->hydrate(
                $materiaporplanestudio,
                $decoded['materiaporplanestudio']
            );
            if ($decoded['materiaporplanestudio']["reportarmateriaid"]){
                $materiareportar=$dbm->getOneByParametersRepositorio("CeMateriaporplanestudios",array("materiaid"=>$decoded['materiaporplanestudio']["reportarmateriaid"],"planestudioid"=>$decoded['materiaporplanestudio']["planestudioid"]));
                $materiareportar->setReportarmateriaid($materiaplanestudio->getMateriaid());
                $dbm->saveRepositorio($materiareportar);
            }

            /*
            if (!$decoded['materiaporplanestudio']["reportarmateriaid"]){
                $materiaplanestudio->setReportarmateriaid(null);
            }
            */
            $parametros = array(
                "planestudioid" => $materiaplanestudio->getPlanestudioid()->getPlanestudioid(),
            );
            $planestudio = $dbm->getByParametersRepositorios('CePlanestudios', $parametros);

            if (empty($planestudio)) {
                return new View("Plan de estudio no encontrado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                $planestudio = $planestudio[0];
            }

            $dbm->getConnection()->beginTransaction();

            $materia = $dbm->getRepositorioById('Materia', 'materiaid', $materiaplanestudio->getMateriaid());
            if (empty($materia)) {
                $dbm->getConnection()->rollBack();
                return new View("Materia no encontrada, ID: " . $id, Response::HTTP_PARTIAL_CONTENT);
            } else {
                $dbm->saveRepositorio($materiaplanestudio);
            }

            $crearsubmateria = $decoded['materiaporplanestudio']['configurarsubmaterias'];
            if ($crearsubmateria == null || $crearsubmateria == 0 || $crearsubmateria == false) {
                $formaconfiguracionsubmateria = new CeFormaconfiguracionsubmateria();
                $formaconfiguracionsubmateria = $dbm->getRepositorioById('CeFormaconfiguracionsubmateria',
                    'formaconfiguracionsubmateriaid', $decoded['configuracionsubmaterias']['formaconfiguracionsubmateriaid']);
                    if(!empty($formaconfiguracionsubmateria)){
                        $dbm->removeManyRepositorio('CeFormaconfiguracionsubmateria',
                    'formaconfiguracionsubmateriaid', $formaconfiguracionsubmateria->getFormaconfiguracionsubmateriaid());
                    }                
            } else {
                $formaconfiguracionsubmateria = new CeFormaconfiguracionsubmateria();                
                if(isset($decoded['configuracionsubmaterias']['formaconfiguracionsubmateriaid'])){
                    $formaconfiguracionsubmateria = $dbm->getRepositorioById('CeFormaconfiguracionsubmateria',
                    'formaconfiguracionsubmateriaid', $decoded['configuracionsubmaterias']['formaconfiguracionsubmateriaid']);                    
                }
                /*
                $formaconfiguracionsubmateria = $dbm->getRepositorioById('CeFormaconfiguracionsubmateria',
                    'formaconfiguracionsubmateriaid', $decoded['configuracionsubmaterias']['formaconfiguracionsubmateriaid']);
                */
                $formaconfiguracionsubmateria->setMateriaporplanestudioid($materiaporplanestudio);
                $formaconfiguracionsubmateria->setFormacaptura($decoded['configuracionsubmaterias']['formacaptura']);
                $formaconfiguracionsubmateria->setFormacalificar($decoded['configuracionsubmaterias']['formacalificar']);
                $dbm->saveRepositorio($formaconfiguracionsubmateria);

                $dbm->removeManyRepositorio('CeConfiguracionsubmaterias',
                    'formaconfiguracionsubmateriaid', $decoded['configuracionsubmaterias']['formaconfiguracionsubmateriaid']);

                foreach ($decoded['configuracionsubmaterias']['submaterias'] as $entidad) {
                    $submateria = new CeConfiguracionsubmaterias();
                    $submateria->setPorcentajecalificacion($entidad['porcentajecalificacion']);
                    $submateria->setMateriaid($dbm->getRepositorioById('Materia', 'materiaid', $entidad['materiaid']));
                    $submateria->setFormaconfiguracionsubmateriaid($formaconfiguracionsubmateria);
                    $dbm->saveRepositorio($submateria);
                }
            }

            $dbm->getConnection()->commit();
            return new View("Proceso realizado de forma satisfactoria.", Response::HTTP_OK);
        } catch (\Exception $e) {
            $dbm->getConnection()->rollBack();
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
