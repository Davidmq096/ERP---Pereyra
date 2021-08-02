<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\Rest\Api;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CePlantillaprofesor;
use AppBundle\Entity\CeProfesorpormateriaplanestudios;
use AppBundle\Dominio\RegistroActividad;

/**
 * Auto: Rubén
 */
class PlantillaProfesorController extends FOSRestController
{

    /**
     * Retorna select
     * @Rest\Get("/api/ControlEscolar/PlantillaProfesores/Combos", name="indexPlantillaProfesores")
     */
    public function indexPlantillaProfesores()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $tipomateriaplantillaprofesor = $dbm->getRepositoriosById('CeTipomateriaplantillaprofesor', 'activo', 1);
            $estatusplantillaprofesor = $dbm->getRepositoriosById('CeEstatusplantillaprofesor', 'activo', 1);
            $usuarioscaptura = $dbm->BuscarUsuarioFiltros(1);
            $usuariovalidan = $dbm->BuscarUsuarioFiltros(2);
            $planestudios = $dbm->getRepositoriosById("CePlanestudios", "vigente", 1);

            return new View(
                array(
                    "planestudios" => $planestudios,
                    "ciclo" => $ciclo,
                    "grado" => $grado,
                    "nivel" => $nivel,
                    "semestre" => $semestre,
                    "estatusplantillaprofesor" => $estatusplantillaprofesor,
                    "tipomateriaplantillaprofesor" => $tipomateriaplantillaprofesor,
                    "usuariocapturan" => $usuarioscaptura,
                    "usuariosvalidan" => $usuariovalidan
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de plantillas
     * @Rest\Post("/api/ControlEscolar/PlantillaProfesores/Filtrar", name="FiltrarPlantillaProfesores")
     */
    public function FiltrarPlantillaProfesores()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $plantillaprofesor = $dbm->FiltrarPlantillaProfesor($decoded);
            if (!$plantillaprofesor) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($plantillaprofesor, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda una plantilla de profesor
     * @Rest\Post("/api/ControlEscolar/PlantillaProfesores", name="guardarPlantillaProfesores")
     */
    public function guardarPlantillaProfesores()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            /*PROCESAMIENTO DE LA INFORMACIÓN */
            $dbm->getConnection()->beginTransaction();

            $planestudiosexiste = $dbm->getByParametersRepositorios('CePlantillaprofesor', array(
                "planestudioid" => $decoded["planestudioid"],
                "cicloid" => $decoded['cicloid'],
                "tipomateriaplantillaprofesorid" => $decoded['tipomateriaplantillaprofesorid']
            ));

            if (!empty($planestudiosexiste)) {
                return new View("Ya existe una plantilla creada con la información enviada del plan de estudios.", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $plantillaprofesor = $hydrator->hydrate(new CePlantillaprofesor(), $decoded);
            $plantillaprofesor->setEstatusplantillaprofesorid($dbm->getRepositorioById('CeEstatusplantillaprofesor', 'estatusplantillaprofesorid', 1));
            $dbm->saveRepositorio($plantillaprofesor);
            $dbm->getConnection()->commit();
            return new View('La plantilla se ha guardado con éxito.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Delete("/api/ControlEscolar/PlantillaProfesores/{id}", name="EliminarPlantillaProfesores")
     */
    public function EliminarPlantillaProfesores($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $plantillaprofesor = $dbm->getRepositorioById('CePlantillaprofesor', 'plantillaprofesorid', $id);

            if (empty($plantillaprofesor)) {
                return new View("La plantilla no se encontró.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            $dbm->removeRepositorio($plantillaprofesor);
            $dbm->getConnection()->commit();

            return new View("Se ha eliminado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Retorna listado de materias regulares de una plantilla de profesor
     * @Rest\Get("/api/ControlEscolar/PlantillaProfesores/Regular/{id}", name="regularPlantillaProfesores")
     */
    public function regularPlantillaProfesores($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm = new DbmControlescolar($dbm->getEntityManager());
            $plantillaprofesor = $dbm->getRepositorioById('CePlantillaprofesor', 'plantillaprofesorid', $id);
            if (empty($plantillaprofesor)) {
                return new View("La plantilla que desea consultar no existe.", Response::HTTP_PARTIAL_CONTENT);
            }

            $areaespecializacionid = $plantillaprofesor->getPlanestudioid()->getAreaespecializacionid() ? 
            $plantillaprofesor->getPlanestudioid()->getAreaespecializacionid()->getAreaespecializacionid() : null;
            $entidades = $dbm->FiltrarDetallePlantillaProfesorRegular( array(
                "planestudioid" => $plantillaprofesor->getPlanestudioid()->getPlanestudioid(),
                "cicloid" =>$plantillaprofesor->getCicloid()->getCicloid(),
                "areaespecializacionid" => $areaespecializacionid)
            );
            if (empty($entidades)) {
                return new View("No se han creado grupos para el grado seleccionado.", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach ($entidades as $key => $e) {
                $formaconfiguracionsubmateria = $dbm->getRepositoriosById("CeConfiguracionsubmaterias", "formaconfiguracionsubmateriaid", $e["formaconfiguracionsubmateriaid"]);
                $submateria = array();
                foreach($formaconfiguracionsubmateria as $s){
                    array_push($submateria, $s->getMateriaid());
                }
                $entidades[$key]["submaterias"] = $submateria;
            }


            return new View($entidades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna listado de materias especiales de una plantilla de profesor
     * @Rest\Get("/api/ControlEscolar/PlantillaProfesores/Especial/{id}", name="especialPlantillaProfesores")
     */
    public function especialPlantillaProfesores($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm = new DbmControlescolar($dbm->getEntityManager());
            $respuesta=[];
            $plantillaprofesor = $dbm->getRepositorioById('CePlantillaprofesor', 'plantillaprofesorid', $id);
            if (empty($plantillaprofesor)) {
                return new View("La plantilla que desea consultar no existe.", Response::HTTP_PARTIAL_CONTENT);
            }
            $entidades = $dbm->FiltrarDetallePlantillaProfesorEspecial(array(
                "planestudioid" => $plantillaprofesor->getPlanestudioid()->getPlanestudioid(),
                "cicloid" =>$plantillaprofesor->getCicloid()->getCicloid())
            );
            foreach ($entidades as $key => $e) {
                $entidades[$key]["submaterias"] = array();
            }
            foreach ($entidades as $key => $e) {
                $yaasignado = $dbm->getOneByParametersRepositorio("CeProfesorpormateriaplanestudios", ["plantillaprofesorid" => $id, "materiaporplanestudioid" => $e["materiaporplanestudioid"], "grupoid" => $e["grupoid"]]);
                if ($yaasignado && $e["profesor"] == "") {
                    //array_splice($entidades,$key,1);
                } else {
                    $gruposorigen = $dbm->getRepositoriosById("CeGrupoorigenporsubgrupo", "grupoid", $e["grupoid"]);
                    $gruposorigenarray = null;
                    foreach ($gruposorigen as $go) {
                        $gruposorigenarray[] = $go->getGrupoorigenid();
                    }
                    $e["gruposorigen"] = $gruposorigenarray;
                    $respuesta[] = $e;
                }
            }

            return new View($respuesta, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda las asignaciones de los profesores a los grupos y materias
     * @Rest\Post("/api/ControlEscolar/PlantillaProfesores/Detalle", name="guardarDetallePlantillaProfesores")
     */
    public function guardarDetallePlantillaProfesores()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            /*PROCESAMIENTO DE LA INFORMACIÓN */
            $dbm->getConnection()->beginTransaction();
            if (!isset($decoded['asignaciones'])) {
                return new View("No hay información en el conjunto de datos enviados.", Response::HTTP_PARTIAL_CONTENT);
            }

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            foreach ($decoded['asignaciones'] as $asignacion) {
                if (!empty($asignacion['profesorpormateriaplanestudiosid'])) {
                    $profesorpormateriaplanestudios = $hydrator->hydrate($dbm->getRepositorioById(
                        'CeProfesorpormateriaplanestudios',
                        'profesorpormateriaplanestudiosid',
                        $asignacion['profesorpormateriaplanestudiosid']
                    ), $asignacion);
                    if (!empty($asignacion['profesorid'])) {
                        if (empty($asignacion['suplenteid'])) {
                            $profesorpormateriaplanestudios->setSuplenteid(null);
                        }

                        if (empty($asignacion['cotitularid'])) {
                            $profesorpormateriaplanestudios->setCotitularid(null);
                        }

                        $dbm->saveRepositorio($profesorpormateriaplanestudios);
                    } else {
                        $dbm->removeRepositorio($profesorpormateriaplanestudios);
                    }
                } else {
                    if (!empty($asignacion['profesorid'])) {
                        $profesorpormateriaplanestudios = $hydrator->hydrate(new CeProfesorpormateriaplanestudios(), $asignacion);
                        $profesorpormateriaplanestudios->setEstatuscriterioevaluacionid($dbm->getRepositorioById('CeEstatuscriterioevaluacion', 'estatuscriterioevaluacionid', 1));
                        $dbm->saveRepositorio($profesorpormateriaplanestudios);
                    }
                }
            }

            $dbm->getConnection()->commit();
            return new View('Se ha completado el proceso de forma satisfactoria.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambia el estatus de las plantillas a pendientes (enviar a validar)
     * @Rest\Post("/api/ControlEscolar/PlantillaProfesores/Validar", name="validarPlantillaProfesores")
     */
    public function validarPlantillaProfesores()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if (!isset($decoded['validaciones'])) {
                return new View("No hay información en el conjunto de datos enviados.", Response::HTTP_PARTIAL_CONTENT);
            }

            /*PROCESAMIENTO DE LA INFORMACIÓN */
            $dbm->getConnection()->beginTransaction();

            foreach ($decoded['validaciones'] as $id) {
                $plantillaprofesor = $dbm->getRepositorioById('CePlantillaprofesor', 'plantillaprofesorid', $id);
                if (empty($plantillaprofesor)) {
                    return new View("Plantilla ID no encontrada.", Response::HTTP_PARTIAL_CONTENT);
                }
                $estatus = $plantillaprofesor->getEstatusplantillaprofesorid()->getEstatusplantillaprofesorid();
                if ($estatus == 1) {
                    $plantillaprofesor->setEstatusplantillaprofesorid($dbm->getRepositorioById('CeEstatusplantillaprofesor', 'estatusplantillaprofesorid', 2));
                } else {
                    return new View("La plantilla no se encuentra en el estatus 'En Captura'.", Response::HTTP_PARTIAL_CONTENT);
                }
                $dbm->saveRepositorio($plantillaprofesor);
            }

            $dbm->getConnection()->commit();

            $entidad=$plantillaprofesor;
            if ($entidad->getPlanestudioid()->getGradoid()->getNivelid()->getNivelid()==1){
                $usuariodestino=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionPlantillaProfesoresPreescolar")->getValor();
            }
            if ($entidad->getPlanestudioid()->getGradoid()->getNivelid()->getNivelid()==2){
                $usuariodestino=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionPlantillaProfesoresPrimaria")->getValor();
            }
            if ($entidad->getPlanestudioid()->getGradoid()->getNivelid()->getNivelid()==3){
                $usuariodestino=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionPlantillaProfesoresSecundaria")->getValor();
            }
            if ($entidad->getPlanestudioid()->getGradoid()->getNivelid()->getNivelid()==4){
                $usuariodestino=$dbm->getRepositorioById("Parametros","nombre","UsuarioNotificacionPlantillaProfesoresBachillerato")->getValor();
            }
            $actividad=[
                //"fecha"=>new \DateTime(),
                "tipoactividadid"=>1,
                "usuarioorigenid"=>$entidad->getUsuariocapturaid()->getUsuarioid(),
                "usuariodestinoid"=>$usuariodestino
            ];
            RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
            
            return new View('Se han enviado a validación los registros seleccionados.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de pruebas
     * @Rest\Post("/api/ControlEscolar/PlantillaProfesores/Copiar", name="copiarPlantillaprofesores")
     */
    public function copiarPlantillaprofesores()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if (empty($decoded['plantillasids'])) {
                return new View("Seleccione al menos una plantilla a copiar.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            foreach ($decoded['plantillasids'] as $plantillaid) {
                $plantillaprofesor = $dbm->getRepositorioById('CePlantillaprofesor', 'plantillaprofesorid', $plantillaid);
                $planestudios =  $plantillaprofesor->getPlanestudioid();
                //Validamos que el plan de estudio vigente no sea diferente de la plantilla que vamos a copiar
                if (!$planestudios->getVigente()) {
                    return new View("El plan de estudio de la plantilla que desea copiar ya no esta vigente.", Response::HTTP_PARTIAL_CONTENT);
                }

                //Validamos que no exista ya una plantilla de profesores en el ciclo destino
                if ($dbm->getOneByParametersRepositorio('CePlantillaprofesor', array(
                    'planestudioid' => $planestudios->getPlanestudioid(), 'cicloid' => $decoded['cicloid']
                ))) {
                    return new View("El ciclo destino ya cuenta con una plantilla de profesores.", Response::HTTP_PARTIAL_CONTENT);
                }

                $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $decoded['cicloid']);

                $plantillaprofesorcopia = new CePlantillaprofesor();
                $plantillaprofesorcopia = clone $plantillaprofesor;
                $plantillaprofesorcopia->setCicloid($ciclo);
                $dbm->saveRepositorio($plantillaprofesorcopia);

                //Se tiene que relacionar pero cambiando los grupos para el nuevo ciclo
                //$asignaciones = $dbm->getRepositoriosById('CeProfesorpormateriaplanestudios', 'plantillaprofesorid', $plantillaprofesor->getPlantillaprofesorid());
                //foreach ($asignaciones as $asignacion) {
                //    $nuevaasignacion = new CeProfesorpormateriaplanestudios();
                //    $nuevaasignacion = clone $asignacion;
                //    $nuevaasignacion->setPlantillaprofesorid($plantillaprofesorcopia);
                //    $dbm->saveRepositorio($nuevaasignacion);
                //}
            }

            $dbm->getConnection()->commit();

            return new View("Copia realizada de forma correcta.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Copia las plantillas de profesores de un semestre a otro (Bachillerato)
     * @Rest\Post("/api/ControlEscolar/PlantillaProfesores/Copiarsemestre", name="copiarPlantillaprofesoressemestre")
     */
    public function copiarPlantillaprofesoressemestre()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if (empty($decoded['plantillasids'])) {
                return new View("Seleccione al menos una plantilla a copiar.", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            foreach ($decoded['plantillasids'] as $plantillaid) {
                $plantillaprofesor = $dbm->getRepositorioById('CePlantillaprofesor', 'plantillaprofesorid', $plantillaid);
                $planestudiorigen = $plantillaprofesor->getPlanestudioid();

                $planestudiodestino = null;
                if ($decoded["gradoidorigen"] == 17 || $decoded["gradoidorigen"] == 18) {
                    $planestudiodestino = $dbm->getOneByParametersRepositorio('CePlanestudios', array("vigente" => 1, "gradoid" => $decoded["gradoiddestino"]));
                 } else {
                    $planestudiodestino = $dbm->getOneByParametersRepositorio('CePlanestudios', array("vigente" => 1, "gradoid" => $decoded["gradoiddestino"], "areaespecializacionid" => $planestudiorigen->getAreaespecializacionid()->getAreaespecializacionid()));
                }
                if(!$planestudiodestino){
                    return new View("No existe un plan de estudio vigente para el grado destino.", Response::HTTP_PARTIAL_CONTENT);
                }

                //Obtendriamos las materias del plan de estudio destino y origen y 
                //se verifica que cada materia del destino tenga su predecesora en el origen

                //$plantillaprofesorcopia = new CePlantillaprofesor();
                //$plantillaprofesorcopia = clone $plantillaprofesor;
                //$plantillaprofesorcopia->setPlanestudioid($planestudios);
                //$dbm->saveRepositorio($plantillaprofesorcopia);

                //$asignaciones = $dbm->getRepositoriosById('CeProfesorpormateriaplanestudios', 'plantillaprofesorid', $plantillaid);
                //foreach ($asignaciones as $asignacion) {
                //    $nuevaasignacion = new CeProfesorpormateriaplanestudios();
                //    $nuevaasignacion = clone $asignacion;
                //    $nuevaasignacion->setPlantillaprofesorid($plantillaprofesorcopia);
                //    $dbm->saveRepositorio($nuevaasignacion);
                //}
            }

            $dbm->getConnection()->commit();

            return new View("Copia realizada de forma correcta.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reactiva una plantilla depues de pasar el proceso y ser rechazada
     * @Rest\Post("/api/ControlEscolar/PlantillaProfesores/Capturar", name="capturarPlantillaProfesores")
     */
    public function capturarPlantillaProfesores()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if (!isset($decoded['validaciones'])) {
                return new View("No hay información en el conjunto de datos enviados.", Response::HTTP_PARTIAL_CONTENT);
            }

            /*PROCESAMIENTO DE LA INFORMACIÓN */
            $dbm->getConnection()->beginTransaction();

            foreach ($decoded['validaciones'] as $id) {
                $plantillaprofesor = $dbm->getRepositorioById('CePlantillaprofesor', 'plantillaprofesorid', $id);
                if (empty($plantillaprofesor)) {
                    return new View("Plantilla ID no encontrada.", Response::HTTP_PARTIAL_CONTENT);
                }
                $estatus = $plantillaprofesor->getEstatusplantillaprofesorid()->getEstatusplantillaprofesorid();
                if ($estatus == 4) {
                    $plantillaprofesor->setEstatusplantillaprofesorid($dbm->getRepositorioById('CeEstatusplantillaprofesor', 'estatusplantillaprofesorid', 1));
                } else {
                    return new View("La plantilla no se encuentra en el estatus 'Rechazado'.", Response::HTTP_PARTIAL_CONTENT);
                }
                $dbm->saveRepositorio($plantillaprofesor);
            }

            $dbm->getConnection()->commit();
            return new View('Se ha completado el proceso de forma satisfactoria.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Rechaza una plantilla
     * @Rest\Post("/api/ControlEscolar/PlantillaProfesores/Rechazar", name="rechazarPlantillaProfesores")
     */
    public function rechazarPlantillaProfesores()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if (!isset($decoded['plantillaprofesorid'])) {
                return new View("No hay información en el conjunto de datos enviados.", Response::HTTP_PARTIAL_CONTENT);
            }

            /*PROCESAMIENTO DE LA INFORMACIÓN */
            $dbm->getConnection()->beginTransaction();

            foreach ($decoded['plantillaprofesorid'] as $id) {
                $plantillaprofesor = $dbm->getRepositorioById('CePlantillaprofesor', 'plantillaprofesorid', $id);
                if (empty($plantillaprofesor)) {
                    return new View("Plantilla ID no encontrada.", Response::HTTP_PARTIAL_CONTENT);
                }
                $estatus = $plantillaprofesor->getEstatusplantillaprofesorid()->getEstatusplantillaprofesorid();
                if ($estatus == 2) {
                    $plantillaprofesor->setEstatusplantillaprofesorid($dbm->getRepositorioById('CeEstatusplantillaprofesor', 'estatusplantillaprofesorid', 4));
                    $plantillaprofesor->setUsuariovalidaid($dbm->getRepositorioById('Usuario', 'usuarioid', $decoded['usuariovalidaid']));
                    $plantillaprofesor->setComentarios($decoded['comentarios']);
                } else {
                    return new View("La plantilla no se encuentra en el estatus 'Pendiente'.", Response::HTTP_PARTIAL_CONTENT);
                }
                $dbm->saveRepositorio($plantillaprofesor);
            }

            $dbm->getConnection()->commit();

            $entidad=$plantillaprofesor;
            $actividad=[
                //"fecha"=>new \DateTime(),
                "tipoactividadid"=>2,
                "usuarioorigenid"=>$entidad->getUsuariovalidaid()->getUsuarioid(),
                "usuariodestinoid"=>$entidad->getUsuariocapturaid()->getUsuarioid()
            ];
            RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);

            return new View('Se ha completado el proceso de forma satisfactoria.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Autoriza una plantilla
     * @Rest\Post("/api/ControlEscolar/PlantillaProfesores/Autorizar", name="autorizarPlantillaProfesores")
     */
    public function autorizarPlantillaProfesores()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if (!isset($decoded['plantillaprofesorid'])) {
                return new View("No hay información en el conjunto de datos enviados.", Response::HTTP_PARTIAL_CONTENT);
            }

            /*PROCESAMIENTO DE LA INFORMACIÓN */
            $dbm->getConnection()->beginTransaction();

            foreach ($decoded['plantillaprofesorid'] as $id) {
                $plantillaprofesor = $dbm->getRepositorioById('CePlantillaprofesor', 'plantillaprofesorid', $id);
                if (empty($plantillaprofesor)) {
                    return new View("Plantilla ID no encontrada.", Response::HTTP_PARTIAL_CONTENT);
                }
                $estatus = $plantillaprofesor->getEstatusplantillaprofesorid()->getEstatusplantillaprofesorid();
                if ($estatus == 2) {
                    $plantillaprofesor->setEstatusplantillaprofesorid($dbm->getRepositorioById('CeEstatusplantillaprofesor', 'estatusplantillaprofesorid', 3));
                    $plantillaprofesor->setUsuariovalidaid($dbm->getRepositorioById('Usuario', 'usuarioid', $decoded['usuariovalidaid']));
                    $plantillaprofesor->setComentarios($decoded['comentarios']);
                } else {
                    return new View("La plantilla no se encuentra en el estatus 'Pendiente'.", Response::HTTP_PARTIAL_CONTENT);
                }
                $dbm->saveRepositorio($plantillaprofesor);
            }

            $dbm->getConnection()->commit();

        
			$entidad=$plantillaprofesor;
            $actividad=[
                //"fecha"=>new \DateTime(),
                "tipoactividadid"=>3,
                "usuarioorigenid"=>$entidad->getUsuariovalidaid()->getUsuarioid(),
                "usuariodestinoid"=>$entidad->getUsuariocapturaid()->getUsuarioid()
            ];
            RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
		

            return new View('Se ha completado el proceso de forma satisfactoria.', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna areporte de una plantilla de profesor
     * @Rest\Get("/api/ControlEscolar/PlantillaProfesores/Reporte/{id}", name="ReporteMaestrosMaterias")
     */
    public function ReporteMaestrosMaterias($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $resultado = $dbm->ReporteMaestrosMaterias($id);

            return new View($resultado, Response::HTTP_OK);
        } catch (\Exception $e) {
            return Api::Error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
