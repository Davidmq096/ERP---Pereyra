<?php

namespace AppBundle\Controller;

//use AppBundle\Controller\lib\data;
use AppBundle\DB\DbmAdmisiones;
use AppBundle\Dominio\Correo;
use AppBundle\Entity\Cartaporsolicitud;
use AppBundle\Entity\Datomedico;
use AppBundle\Entity\AdContactoemergencia;
use AppBundle\Entity\Dictamen;
use AppBundle\Entity\AdAdmisionseguimientocontrato;
use AppBundle\Entity\AdAdmisioncontratoresponsable;
use AppBundle\Entity\AdAdmisioncontrato;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Description of SolicitudController
 *
 * @author inceptio
 */
class SolicitudController extends FOSRestController
{
    /**
     * Reotorna valores iniciales
     * @Rest\Get("/api/Familiar/home", name="FamiliarHome")
     */
    public function homeAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);
        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $return = array('solicitud' => $SolicitudEntity);
        return new View($return, Response::HTTP_OK);
    }


    /**
     * Retorna el archivo layout
     * @Rest\Get("/api/Solicitud/ImportacionSolicitud/", name="downloadt")
     */
    public function downloadLayout()
    {
        try {
            $dbm = $this->get("db_manager");
            $datos = $_REQUEST;
            $Excel = $this->get('phpexcel')->createPHPExcelObject();
            $layout = \AppBundle\Dominio\ImportacionSolicitud::layout($dbm, $datos, $Excel);
            $writer = $this->get('phpexcel')->createWriter($layout, 'Excel5');
            $response = $this->get('phpexcel')->createStreamedResponse($writer);
            $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'stream-file.xls');
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
     * Reotorna valores iniciales de datos de aspirante
     * @Rest\Get("/api/Familiar/expediente/", name="expediente")
     */
    public function expedienteAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        $nivel = $dbm->getRepositorios('Nivel');
        $grados = $dbm->getRepositorios('Grado');

        $pais = $dbm->getRepositorios('Pais');
        $estado = $dbm->getTodosEStados();
        $mun = $dbm->getTodosMunicipios();

        $escuelaJesuitas = $dbm->getRepositorios('Escuelajesuita');
        $escuelaProcedencia = $dbm->getRepositorioById('Escuelaprocedencia', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());

        $escuelas = $dbm->getRepositoriosById('Escuelaprocedencia', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());
        $gradosRepetidos = $dbm->getRepositoriosById('Gradorepetido', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());

        $return = array("solicitud" => $SolicitudEntity, "escuelas" => $escuelas, "gradosRepetidos" => $gradosRepetidos, "pais" => $pais,
            "estado" => $estado, "municipio" => $mun, "nivel" => $nivel, "grado" => $grados, "escuelaJesuitas" => $escuelaJesuitas, "escuelaProcedencia" => $escuelaProcedencia);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * Reotorna valores iniciales de datos de aspirante
     * @Rest\Get("/api/Familiar/expediente/gradosRepetidos/", name="GradosRepetidos")
     */
    public function gradosRepetidosAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $grados = $dbm->getRepositoriosById('Gradorepetido', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());

        $return = array("grados" => $grados);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * Funcion para guardar datos del expediente del aspirante
     * @Rest\Post("/api/Familiar/expediente/gradorepetido/", name="gradorepetidoSave")
     */
    public function saveGradoAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($SolicitudEntity)) {
            $return = array("mensaje" => "Error no se encontro ninguna solicitud de admision " . $data['solicitudadmisionid']);
            return new View($return, Response::HTTP_NOT_FOUND);
        } else {
            //$SolicitudEntity->setPendiente(5);
            //$SolicitudEntity->setPendiente(5);
            if (empty($data['idgrado'])) {
                $Escuela = new \AppBundle\Entity\Gradorepetido();
            } else {
                $Escuela = $dbm->getRepositorioById('Gradorepetido', 'gradorepetidoid', $data['idgrado']);
            }

            $Escuela->setDatoaspiranteid($SolicitudEntity->getDatoaspiranteid());
            if ($data['seccion'] == '1') {
                $valueSeccion = 'Preescolar';
            }if ($data['seccion'] == '2') {
                $valueSeccion = 'Primaria';
            }if ($data['seccion'] == '3') {
                $valueSeccion = 'Secundaria';
            }if ($data['seccion'] == '4') {
                $valueSeccion = 'Bachillerato';
            }
            //$Escuela->setSeccion((empty($data['seccion'])) ? null : $valueSeccion);
            $Escuela->setGradoid($dbm->getRepositorioById("Grado", "gradoid", $data['grado']));
            $Escuela->setCausa((empty($data['causa'])) ? null : $data['causa']);

            $dbm->saveRepositorio($Escuela);
            $grados = $dbm->getRepositoriosById("Gradorepetido", "datoaspiranteid", $SolicitudEntity->getDatoaspiranteid()->getDatoaspiranteid());
            $return = array("grados" => $grados);
            return new View($return, Response::HTTP_OK);
        }
    }

    /**
     * Funcion para eliminar grados
     * @Rest\Delete("/api/Familiar/expediente/grados/", name="GradosRemove1")
     */
    public function removeGradosAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($SolicitudEntity)) {
            $return = array("mensaje" => "Error no se encontro la solicitud admision" . $data['solicitudadmisionid']);
            return new View($return, Response::HTTP_NOT_FOUND);
        } else {
            if (empty($data['gradoid'])) {
                $return = array("mensaje" => 'no se encontro ningun grado');
                return new View($return, Response::HTTP_NOT_FOUND);
            } else {
                //Se agregar relacion con nivel
                $grado = $dbm->getRepositorioById('Gradorepetido', 'gradorepetidoid', $data['gradoid']);
                $dbm->removeRepositorio($grado);
                $grados = $dbm->getRepositoriosById("Gradorepetido", "datoaspiranteid", $SolicitudEntity->getDatoaspiranteid()->getDatoaspiranteid());
                $return = array("mensaje" => "Se ha eliminado un grado.", "grados" => $grados);
                return new View($return, Response::HTTP_OK);
            }
        }
    }

    /**
     * Funcion para guardar datos del expediente del aspirante
     * @Rest\Post("/api/Familiar/expediente/", name="expedienteSave")
     */
    public function saveExpedienteAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($SolicitudEntity)) {
            $return = array("mensaje" => "Error no se encontro la solicitud de admision " . $data['solicitudadmisionid']);
            return new View($return, Response::HTTP_NOT_FOUND);
        } else {
            //$SolicitudEntity->setPendiente(5);
            if ($SolicitudEntity->getPendiente() <= 3) {
                $SolicitudEntity->setPendiente(4);
            }

            //Datos Medicos (informacion adicional)
            //eliminamos la nacionalidad mexicana
            $Escuelas = $dbm->getRepositoriosById('Escuelaprocedencia', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());
            foreach ($Escuelas as $n) {
                $dbm->removeRepositorio($n);
            }

            $EscuelaProcedencia = new \AppBundle\Entity\Escuelaprocedencia();
            $EscuelaProcedencia->setDatoaspiranteid($SolicitudEntity->getDatoaspiranteid());
            $EscuelaProcedencia->setNombre((empty($data['nombreEscuela'])) ? null : $data['nombreEscuela']);
            $EscuelaProcedencia->setMunicipio((empty($data['ciudadEscuela'])) ? null : $data['ciudadEscuela']);
            $EscuelaProcedencia->setCausaseparacion((empty($data['motivoCambio'])) ? null : $data['motivoCambio']);

            if (!empty($data['escuelaJesuita'])) {
                $EscuelaJesuita = $dbm->getRepositorioById('Escuelajesuita', 'escuelajesuitaid', $data['escuelaJesuita']);
                $EscuelaProcedencia->setEscuelajesuitaid($EscuelaJesuita);
            }

            $dbm->saveRepositorio($EscuelaProcedencia);

            $Info = $SolicitudEntity->getInfoadicionalid();
            //$Info = new \AppBundle\Entity\Infoadicional();
            $Info->setEstadosalud((empty($data['salud'])) ? null : $data['salud']);
            $Info->setNecesidadespecial((empty($data['necesidadeducativa'])) ? 0 : $data['necesidadeducativa']);
            $Info->setDescripcionnecesidad((empty($data['especificarNecesidad'])) ? null : $data['especificarNecesidad']);
            $Info->setAlumnoinstituto((empty($data['alumnoCiencias'])) ? 0 : $data['alumnoCiencias']);
            $Info->setHijopersonal((empty($data['hijoPersonal'])) ? 0 : $data['hijoPersonal']);

            $dbm->saveRepositorio($Info);

            /* $Aspirante = $SolicitudEntity->getDatoaspiranteid();
            $Aspirante->setNombreescuelaprocedencia((empty($data['nombreEscuelaP'])) ? NULL : $data['nombreEscuelaP']);
            $Aspirante->setCiudadescuelaprocedencia((empty($data['ciudadEscuelaP'])) ? NULL : $data['ciudadEscuelaP']);
            $dbm->saveRepositorio($Aspirante); */
            $return = array("solicitud" => $SolicitudEntity, "escuelaProcedencia" => $EscuelaProcedencia);
            return new View($return, Response::HTTP_OK);
        }
    }

    /**
     * Reotorna valores iniciales de datos de aspirante
     * @Rest\Get("/api/Familiar/datosFamiliares", name="datosFamiliares")
     */
    public function datosFamiliaresAction()
    {        
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $ocupacion = $dbm->getRepositorios('Ocupacion');
        $parentesco = $dbm->getRepositorios('Parentesco');
        $parentescoTutor = $dbm->getRepositorios('Tutor');
        $nacionalidad = $dbm->getRepositorios('Nacionalidad');
        $SituacionConyugal = $dbm->getRepositorios('Situacionconyugal');
        $escolaridad = $dbm->getRepositorios('Escolaridad');

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $Tutores = $dbm->getRepositoriosById('Padresotutores', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $personaAutoriza = $dbm->getRepositoriosById('Personaautorizadarecoger', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());

        $estado = [];
        $mun = [];
        $conn = $this->get("db_manager")->getConnection();
        $stmt = $conn->prepare('SELECT Nombre AS nombre, GeneracionId AS generacionid FROM generacion ORDER BY Nombre DESC');
        $stmt->execute();
        $generacion = $stmt->fetchAll();

        $ApellidoP = '';
        $ApellidoM = '';
        if ($SolicitudEntity->getClavefamiliar()) {
            $ClaveFamiliarEntity = $dbm->getRepositorioById('CeClavefamiliar', 'clave', $SolicitudEntity->getClavefamiliar());
            $ApellidoP = $ClaveFamiliarEntity->getApellidopaterno();
            $ApellidoM = $ClaveFamiliarEntity->getApellidomaterno();
        } else {
            $ApellidoP = '';
            $ApellidoM = '';
        }

        if ($SolicitudEntity->getEstatussolicitudid()->getEstatussolicitudid() > 4) {
            $estado = $dbm->getTodosEStados();
            $mun = $dbm->getTodosMunicipios();
        }

        $return = array("solicitud" => $SolicitudEntity, "ocupacion" => $ocupacion, "Tutores" => $Tutores, "parentesco" => $parentesco, "nacionalidad" => $nacionalidad,
            "situacion" => $SituacionConyugal, "escolaridad" => $escolaridad, 'personaAutoriza' => $personaAutoriza, 'estado' => $estado,
            'municipios' => $mun, 'generacion' => $generacion, 'parentescoTutor' => $parentescoTutor, 'apellidoPClaveFamiliar' => $ApellidoP, 'apellidoMClaveFamiliar' => $ApellidoM);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * Reotorna direccion por cp
     * @Rest\Get("/api/Solicitud/direccion/cp", name="DireccionByCp")
     */
    public function direccionByCpAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($SolicitudEntity)) {
            $return = array("mensaje" => "Error no se encontro ninguna solicitud con la clave " . $data['solicitudadmisionid']);
            return new View($return, Response::HTTP_PARTIAL_CONTENT);
        } else {
            $Direccion = $dbm->getTodasColoniasByCp($data['cp']);

            foreach ($Direccion as $n) {
                $municipio = $n;
            }

            $return = array("direccion" => $Direccion, 'municipio' => $municipio['municipioid']);
            return new View($return, Response::HTTP_OK);
        }
    }

    /**
     * Reotorna valores iniciales de hermano
     * @Rest\Get("/api/Solicitud/hermano", name="hermano")
     */
    public function hermanoAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $Hermanos1 = $dbm->getByParametersRepositorios("Hermano", array("datosaspiranteid" => $SolicitudEntity->getDatoaspiranteid(), "tipohermano" => 1));
        $Hermanos2 = $dbm->getByParametersRepositorios("Hermano", array("datosaspiranteid" => $SolicitudEntity->getDatoaspiranteid(), "tipohermano" => 2));
        $Hermanos3 = $dbm->getByParametersRepositorios("Hermano", array("datosaspiranteid" => $SolicitudEntity->getDatoaspiranteid(), "tipohermano" => 3));
        $niveles = $dbm->getRepositorios('Nivel');
        $grados = $dbm->getRepositorios('Grado');
        $conn = $this->get("db_manager")->getConnection();
        $stmt = $conn->prepare('SELECT Nombre AS nombre, GeneracionId AS generacionid FROM generacion ORDER BY Nombre DESC');
        $stmt->execute();
        $generacion = $stmt->fetchAll();

        $return = array("solicitud" => $SolicitudEntity, "Hermanos1" => $Hermanos1, "Hermanos2" => $Hermanos2, "Hermanos3" => $Hermanos3, "niveles" => $niveles, "grados" => $grados, "generacion" => $generacion);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * Reotorna valores iniciales de hermano
     * @Rest\Get("/api/Solicitud/hermano/Validacion/", name="hermanoValidacion")
     */
    public function hermanoValidacionAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);

        if (empty($Solicitud)) {
            $return = array("mensaje" => "Error no se encontro ninguna solicitud con el id " . $data['solicitudid']);
        } else {

            if (!empty($Solicitud->getClavefamiliar())) {
                $allHermanos = $dbm->getRepositoriosById('Hermano', 'datosaspiranteid', $Solicitud->getDatoaspiranteid());
                if (empty($allHermanos)) {
                    $filters = array('clavefamiliar' => $Solicitud->getClavefamiliar());
                    $AlemunosHermanos = $dbm->getClavePersonasByFilter($filters);

                    foreach ($AlemunosHermanos as $ah) {
                        $Hermano = new \AppBundle\Entity\Hermano();
                        $Hermano->setDatosaspiranteid($Solicitud->getDatoaspiranteid());
                        $Hermano->setCurp((empty($ah->getAlumnoid()->getCurp())) ? null : $ah->getAlumnoid()->getCurp());
                        $Hermano->setNombre((empty($ah->getAlumnoid()->getPrimernombre())) ? null : $ah->getAlumnoid()->getPrimernombre());
                        $Hermano->setApellidopaterno((empty($ah->getAlumnoid()->getApellidopaterno())) ? null : $ah->getAlumnoid()->getApellidopaterno());
                        $Hermano->setApellidomaterno((empty($ah->getAlumnoid()->getApellidomaterno())) ? null : $ah->getAlumnoid()->getApellidomaterno());
                        $Hermano->setTipohermano(1);
                        $dbm->saveRepositorio($Hermano);
                    }
                }
            }
            $Hermanos1 = $dbm->getByParametersRepositorios("Hermano", array("datosaspiranteid" => $Solicitud->getDatoaspiranteid(), "tipohermano" => 1));
            $Hermanos2 = $dbm->getByParametersRepositorios("Hermano", array("datosaspiranteid" => $Solicitud->getDatoaspiranteid(), "tipohermano" => 2));
            $Hermanos3 = $dbm->getByParametersRepositorios("Hermano", array("datosaspiranteid" => $Solicitud->getDatoaspiranteid(), "tipohermano" => 3));

            $niveles = $dbm->getRepositorios('Nivel');
            $grados = $dbm->getRepositorios('Grado');
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT Nombre AS nombre, GeneracionId AS generacionid FROM generacion ORDER BY Nombre DESC');
            $stmt->execute();
            $generacion = $stmt->fetchAll();

            $return = array("solicitud" => $Solicitud, "Hermanos1" => $Hermanos1, "Hermanos2" => $Hermanos2, "Hermanos3" => $Hermanos3, "niveles" => $niveles, "grados" => $grados, "generacion" => $generacion);
            return new View($return, Response::HTTP_OK);
        }
    }

    /**
     * Reotorna valores iniciales de datos de aspirante
     * @Rest\Get("/api/Familiar/datosFamiliares/padres", name="datosFamiliarespadres")
     */
    public function datosFamiliaresPadresAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $Tutores = $dbm->getRepositoriosById('Padresotutores', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $return = array("Tutores" => $Tutores);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * Reotorna nacionalidades del padre de familia
     * @Rest\Get("/api/Familiar/datosFamiliares/padres/nacionalidades", name="datosFamiliarespadresNacionalidades")
     */
    public function datosFamiliaresPadresnacioNalidadesAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Familiar = $dbm->getRepositorioById('Padresotutores', 'padresotutoresid', $data['idtutor']);
        if (empty($Familiar)) {
            $return = array("mensaje" => "Error no se encontro ninguna padre con el if" . $data['idtutor']);
        } else {
            $nacionalidades = $dbm->getRepositoriosById('Nacionalidadporpadresotutores', 'padresotutoresid', $data['idtutor']);
            foreach ($nacionalidades as $nacion) {
                $nacionalidad[] = $nacion->getNacionalidadid();
            }
            $situacionconyugal[] = $Familiar->getSituacionconyugal();
            $escolaridad[] = $Familiar->getNivelestudioid();
            $return = array("nacionalidadesPadres" => $nacionalidades, "nacionalidad" => $nacionalidad, "situacionconyugal" => $situacionconyugal, "escolaridad" => $escolaridad);
        }

        return new View($return, Response::HTTP_OK);
    }

    /**
     * Reotorna valores iniciales de datos de aspirante
     * @Rest\Get("/api/Familiar/datosFamiliares/Hermanos", name="datosFamiliaresHermanos")
     */
    public function datosFamiliaresHermanosAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $Hermanos1 = $dbm->getByParametersRepositorios("Hermano", array("datosaspiranteid" => $SolicitudEntity->getDatoaspiranteid(), "tipohermano" => 1));
        $Hermanos2 = $dbm->getByParametersRepositorios("Hermano", array("datosaspiranteid" => $SolicitudEntity->getDatoaspiranteid(), "tipohermano" => 2));
        $Hermanos3 = $dbm->getByParametersRepositorios("Hermano", array("datosaspiranteid" => $SolicitudEntity->getDatoaspiranteid(), "tipohermano" => 3));

        $return = array("Hermanos1" => $Hermanos1, "Hermanos2" => $Hermanos2, "Hermanos3" => $Hermanos3);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * Funcion para guardar datos familiares
     * @Rest\Post("/api/Familiar/datosFamiliares/padres", name="datosFamiliaresPadresSave")
     */
    public function savePadresAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($SolicitudEntity)) {
            $return = array("mensaje" => "Error no se encontro ninguna solicitud admision " . $data['solicitudadmisionid']);
        } else {
            //$SolicitudEntity->setPendiente(5);
            if (empty($data['idtutor'])) {
                //$Escuela = new \AppBundle\Entity\Gradorepetido();
                $Familiar = new \AppBundle\Entity\Padresotutores();
            } else {
                $Familiar = $dbm->getRepositorioById('Padresotutores', 'padresotutoresid', $data['idtutor']);
            }
            //$Familiar = new \AppBundle\Entity\Padresotutores();
            $Familiar->setSolicitudadmisionid($SolicitudEntity);
            $Familiar->setNombre((empty($data['nombre'])) ? null : $data['nombre']);
            $Familiar->setApellidopaterno((empty($data['apellidopaterno'])) ? null : $data['apellidopaterno']);
            $Familiar->setApellidomaterno((empty($data['apellidomaterno'])) ? null : $data['apellidomaterno']);
            $Familiar->setCelular((empty($data['celular'])) ? null : $data['celular']);
            $Familiar->setCorreo((empty($data['correo'])) ? null : $data['correo']);

            //+++++++++++++++++++++++++++++++++
            $tutor = $dbm->getRepositorioById('Tutor', 'tutorid', $data['parentesco']);
            $Familiar->setTutorid($tutor);

            $Familiar->setCurp((empty($data['curp'])) ? null : $data['curp']);
            if (!empty($data['finado'])) {
                if ($data['finado'] == true) {
                    $finadoTemp = 1;
                } else {
                    $finadoTemp = $data['finado'];
                }
            } else {
                $finadoTemp = null;
            }

            if (!empty($data['tutor'])) {
                if ($data['tutor'] == true) {
                    $tutorTemp = 1;
                } else {
                    $tutorTemp = $data['tutor'];
                }
            } else {
                $tutorTemp = null;
            }

            $Familiar->setFinado($finadoTemp);

            $Familiar->setTutor($tutorTemp);
            $Familiar->setTipoocupacion((empty($data['tipoOcupacion'])) ? null : $data['tipoOcupacion']);
            $Familiar->setFechanacimiento((empty($data['fechaNac'])) ? null : new \DateTime($data['fechaNac']));

            if (!empty($data['nacionalidadid'])) {
                //if ($data['version'] == '1') {
                //Eliminamos Nacionalidad
                $nacionalidades = $dbm->getRepositoriosById('Nacionalidadporpadresotutores', 'padresotutoresid', $data['idtutor']);
                foreach ($nacionalidades as $n) {
                    $dbm->removeRepositorio($n);
                }
                //Agregamos las nacionalidades
                $arrayNacionalidad = $data['nacionalidadid'];
                foreach ($arrayNacionalidad as $val) {
                    $nacionalidad = $dbm->getRepositorioById('Nacionalidad', 'nacionalidadid', $val);
                    $NxP = new \AppBundle\Entity\Nacionalidadporpadresotutores();
                    $NxP->setNacionalidadid($nacionalidad);
                    $NxP->setPadresotutoresid($Familiar);
                    $dbm->saveRepositorio($NxP);
                }
                //}
                /*
            if ($data['version'] == '2') {
            $Nacionalidad = $dbm->getRepositorioById('Nacionalidad', 'nacionalidadid', $data['nacionalidadid']);
            $Familiar->setNacionalidadid($Nacionalidad);
            }
             */
            }

            if (!empty($data['situacionC'])) {
                $SituacionConyugar = $dbm->getRepositorioById('Situacionconyugal', 'situacionconyugalid', $data['situacionC']);
                $Familiar->setSituacionconyugal($SituacionConyugar);
            }
            if (!empty($data['escolaridad'])) {
                $Escolaridad = $dbm->getRepositorioById('Escolaridad', 'escolaridadid', $data['escolaridad']);
                $Familiar->setNivelestudioid($Escolaridad);
            }
            $Familiar->setOcupacion((empty($data['ocupacion'])) ? null : $data['ocupacion']);
            $Familiar->setRamo((empty($data['ramo'])) ? null : $data['ramo']);
            $Familiar->setEmpresa((empty($data['empresa'])) ? null : $data['empresa']);
            $Familiar->setTelempresa((empty($data['telEmpresa'])) ? null : $data['telEmpresa']);
            $Familiar->setExtencionempresa((empty($data['extencionEmpresa'])) ? null : $data['extencionEmpresa']);
            $Familiar->setHorariotrabajo((empty($data['horarioEmpresa'])) ? null : $data['horarioEmpresa']);
            $Familiar->setExlux((empty($data['exLux'])) ? null : $data['exLux']);
            if (!empty($data['generacion'])) {
                $Generacion = $dbm->getRepositorioById('Generacion', 'generacionid', $data['generacion']);
                $Familiar->setGeneracionid($Generacion);
            }
            $Familiar->setAlumnoinstituto($data['alumnoInstituto'] == "1");
            $Familiar->setEspecificaralumno((empty($data['especificarAlumnoInstituto'])) ? null : $data['especificarAlumnoInstituto']);

            $dbm->saveRepositorio($Familiar);
            $Tutores = $dbm->getRepositoriosById('Padresotutores', 'solicitudadmisionid', $data['solicitudadmisionid']);
            $return = array("solicitud" => $SolicitudEntity, "Tutores" => $Tutores);
        }

        return new View($return, Response::HTTP_OK);
    }

    /**
     * Funcion para guardar datos familiares
     * @Rest\Post("/api/Familiar/datosFamiliares/Hermano/", name="datosFamiliaresHermanoSave")
     */
    public function saveHermanoAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($SolicitudEntity)) {
            $return = array("mensaje" => "Error no se encontro ninguna solicitud con la clave " . $data['solicitudadmisionid']);
            return new View("No se ha encontrado la entidad", Response::HTTP_NOT_FOUND);
        } else {
            //$SolicitudEntity->setPendiente(5);
            if (empty($data['hermanoid'])) {
                //$Escuela = new \AppBundle\Entity\Gradorepetido();
                $Hermano = new \AppBundle\Entity\Hermano();
            } else {
                $Hermano = $dbm->getRepositorioById('Hermano', 'hermanoid', $data['hermanoid']);
            }
            $Hermano->setDatosaspiranteid($SolicitudEntity->getDatoaspiranteid());
            $Hermano->setNombre((empty($data['nombre'])) ? null : $data['nombre']);
            $Hermano->setApellidopaterno((empty($data['apellidopaterno'])) ? null : $data['apellidopaterno']);
            $Hermano->setApellidomaterno((empty($data['apellidomaterno'])) ? null : $data['apellidomaterno']);
            $Hermano->setEdad((empty($data['edad'])) ? null : $data['edad']);
            $Hermano->setCurp((empty($data['curp'])) ? null : $data['curp']);
            $Hermano->setTipohermano((empty($data['tipo'])) ? null : $data['tipo']);
            if (!empty($data['generacion'])) {
                $Generacion = $dbm->getRepositorioById('Generacion', 'generacionid', $data['generacion']);
                $Hermano->setGeneracionid($Generacion);
            }
            $Hermano->setNombreescuela((empty($data['escuela'])) ? null : $data['escuela']);
            $Hermano->setFechanacimiento((empty($data['nacimiento'])) ? null : new \DateTime($data['nacimiento']));

            if (!empty($data['grado'])) {
                $Grado = $dbm->getRepositorioById('Grado', 'gradoid', $data['grado']);
                $Hermano->setGradoid($Grado);
            }

            $dbm->saveRepositorio($Hermano);
            $return = array("hermano" => $Hermano);
            return new View("Se ha insertado correctamente", Response::HTTP_OK);
        }
    }

    /**
     * Funcion para eliminar datos familiares
     * @Rest\Delete("/api/Familiar/datosFamiliares/Hermano/", name="datosFamiliaresHermanoRemove")
     */
    public function removeHermanoAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($SolicitudEntity)) {
            $return = array("mensaje" => "Error no se encontro ninguna solicitud con la clave " . $data['solicitudadmisionid']);
            return new View($return, Response::HTTP_NOT_FOUND);
        } else {
            if (empty($data['hermanoid'])) {
                $return = array("mensaje" => 'no se encontro ningun hermano');
                return new View($return, Response::HTTP_OK);
            } else {
                //Se agregar relacion con nivel

                $tutor = $dbm->getRepositorioById('Hermano', 'hermanoid', $data['hermanoid']);
                $dbm->removeRepositorio($tutor);

                $return = array("mensaje" => 'Se ha eliminado un hermano correctamente');
                return new View($return, Response::HTTP_OK);
            }
        }
    }

    /**
     * Funcion para guardar datos familiares
     * @Rest\Post("/api/Familiar/datosFamiliares/", name="datosFamiliaresSave")
     */
    public function saveDatosFamiliaresAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($SolicitudEntity)) {
            $return = array("mensaje" => "Error no se encontro ninguna solicitud con la clave " . $data['solicitudadmisionid']);
            return new View("No se ha encontrado la entidad", Response::HTTP_NOT_FOUND);
        } else {
            if ($data['version'] == '1') {
                if ($SolicitudEntity->getPendiente() <= 3) {
                    $SolicitudEntity->setPendiente(4);
                }
            }if ($data['version'] == '2') {
                if ($SolicitudEntity->getPendiente() <= 4) {
                    $SolicitudEntity->setPendiente(5);
                }
            }

            if ($SolicitudEntity->getEstatussolicitudid()->getEstatussolicitudid() > 2) {
                $Aspirante = $SolicitudEntity->getDatoaspiranteid();

                $MunicipioEntity = $dbm->getRepositorioById('Municipio', 'municipioid', (empty($data['municipio'])) ? null : $data['municipio']);
                $Aspirante->setMunicipioviviendaid($MunicipioEntity);
                $Aspirante->setColonia((empty($data['colonia'])) ? null : $data['colonia']);
                $Aspirante->setOtracolonia((empty($data['otraColonia'])) ? null : $data['otraColonia']);
                $Aspirante->setCalle((empty($data['calle'])) ? null : $data['calle']);
                $Aspirante->setNumeroexterior((empty($data['numex'])) ? null : $data['numex']);
                $Aspirante->setNumerointeriror((empty($data['numint'])) ? null : $data['numint']);
                $Aspirante->setCp((empty($data['cp'])) ? null : $data['cp']);
            }

            $dbm->saveRepositorio($SolicitudEntity);
            $return = array("solicitud" => $SolicitudEntity);
            return new View($return, Response::HTTP_OK);
        }
    }

    /**
     * Reotorna valores iniciales de domicilio actual
     * @Rest\Get("/api/Familiar/documentacion", name="documentacion")
     */
    public function documentacionAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $DocumentoDeSolicitud = $dbm->getRepositoriosById('Documentoporgrado', 'gradoid', $SolicitudEntity->getGradoid());
        $niveles = $dbm->getRepositorios('Nivel');
        $return = array("documento" => $DocumentoDeSolicitud, "niveles" => $niveles, "solicitud" => $SolicitudEntity);
        return new View($return, Response::HTTP_OK);
    }


    /**
     * Validacion de datos
     */

    /**
     * vlores inicioales para validacion de datos
     * @Rest\Get("/api/ValidacionDatos/", name="ValidacionDatos")
     */
    public function ValidacionDatosAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $nivel = $dbm->getRepositorios('Nivel');
        $grados = $dbm->getRepositorios('Grado');

        $pais = $dbm->getRepositorios('Pais');
        $estado = $dbm->getRepositorios('Estado');
        $mun = $dbm->getRepositorios('Municipio');
        $nacionalidad = $dbm->getRepositorios('Nacionalidad');
        $Solicitudes = $dbm->getRepositorios('Solicitudadmision');
        $ciclo = $dbm->getRepositorioById('Ciclo', 'siguiente', 1);

        $return = array('solicitud' => $Solicitudes, 'niveles' => $nivel,
            'grados' => $grados, 'pais' => $pais, 'estado' => $estado, 'minicipios' => $mun, 'nacionalidad' => $nacionalidad, "ciclo" => $ciclo);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * consulta de nacionalidades por aspirante
     * @Rest\Get("/api/ValidacionDatos/Nacionalidad/{idSolicitud}/", name="ValidacionDatosNacionalidadesAspirante")
     */
    public function nacionalidadDatosAction($idSolicitud)
    {
        $dbm = $this->get("db_manager");
        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $idSolicitud);

        if (empty($SolicitudEntity)) {
            return new View("No se encontra ninguna solicitud con el id " . $idSolicitud, Response::HTTP_NOT_FOUND);
        } else {
            $nacionalidades = null;
            if (!empty($SolicitudEntity->getPendiente())) {
                $nacionalidades = $dbm->getRepositoriosById('Nacionalidadpordatoaspirante', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());
            }
            $return = array('nacionalidades' => $nacionalidades);
            return new View($return, Response::HTTP_OK);
        }
    }

    /**
     * Funcion para eliminar datos familiares
     * @Rest\Delete("/api/ValidacionDatos/datosFamiliares/padres/", name="ValidacionDatosPadresRemove")
     */
    public function removePadresActionValidacionDatos(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($SolicitudEntity)) {
            $return = array("mensaje" => "Error no se encontro la solicitud admision " . $data['solicitudadmisionid']);
            return new View($return, Response::HTTP_NOT_FOUND);
        } else {
            $tutorArray = json_decode($data['obj']);
            if (empty($tutorArray)) {
                $return = array("mensaje" => 'no se encontro ningun tutor');
                return new View($return, Response::HTTP_OK);
            } else {
                /* Se agregar relacion con nivel
                foreach ($data['tutorid'] as $tutorid) {
                $tutor = $dbm->getRepositorioById('Padresotutores', 'padresotutoresid', $tutorid);
                $dbm->removeRepositorio($tutor);
                } */

                foreach ($tutorArray as $values) {
                    $tutor = $dbm->getRepositorioById('Padresotutores', 'padresotutoresid', $values);
                    $dbm->removeRepositorio($tutor);
                }

                $return = array("mensaje" => 'Se ha eliminado un tutor correctamente');
                return new View($return, Response::HTTP_OK);
            }
        }
    }



    /**
     * Hace el Dictamena varias solicitudes cambiando el estatus, asignandoles cartas y crenado un dictamen
     * @Rest\Put("/api/Solicitud/Dictamen", name="SolicitudDictamen")
     */
    public function solicitudDictamenAction()
    {
        parse_str(file_get_contents("php://input"), $data);
        $dbm = $this->get("db_manager");
        $dbm->getConnection()->beginTransaction();
        try {

            if (!empty($data['solicitudid'])) {
                if (!empty($data['estatusid'])) {
                    foreach ($data['solicitudid'] as $val) {
                        $estatussolicitud = $dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', $data["estatusid"]);

                        $Solicitudadmision = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $val);
                        $Solicitudadmision->setEstatussolicitudid($estatussolicitud);
                        $dbm->saveRepositorio($Solicitudadmision);

                        $Dictamen = new Dictamen();
                        $Dictamen->setSolicitudadmisionid($Solicitudadmision);
                        $Dictamen->setDictamen($estatussolicitud->getEstatus());
                        $Dictamen->setMotivo('Dictamen grupal');

                        $Usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']);
                        $Dictamen->setUsuarioid($Usuario);
                        $Dictamen->setFecharegistro(new \DateTime());
                        $dbm->saveRepositorio($Dictamen);

                        $cartasSolicitud = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $Solicitudadmision->getSolicitudadmisionid());
                        foreach ($cartasSolicitud as $n) {
                            $dbm->removeRepositorio($n);
                        }

                        foreach ($data['cartaid'] as $c) {
                            $Cartaporsolicitud = new Cartaporsolicitud();
                            $Cartaporsolicitud->setSolicitudadmisionid($Solicitudadmision);
                            $Carta = $dbm->getRepositorioById('Formato', 'formatoid', $c);
                            $Cartaporsolicitud->setCartaid($Carta);
                            $dbm->saveRepositorio($Cartaporsolicitud);
                        }
                    }
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado correctamente el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View("No se pudo actualizar el registro ", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Descarga las cartas
     * @Rest\Get("/api/Solicitud/Carta/", name="SolicitudCarta")
     */
    public function solicitudCartas()
    {
        $dbm = $this->get("db_manager");
        $data = $_REQUEST;

        $zip = new \ZipArchive();
        $zip->open('Cartas.zip', \ZipArchive::CREATE);

        foreach (explode(',', $data['solicitudes']) as $id) {
            $cartas = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $id);
            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);
            $Usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioId']);
            if ($cartas) {
                foreach ($cartas as $c) {
                    $impresioncarta = new \AppBundle\Entity\Impresiondocumento();

                    $cartaEntitiy = $dbm->getRepositorioById('Formato', 'formatoid', $c->getCartaid()->getFormatoid());
                    $impresioncarta->setFormatoid($cartaEntitiy);
                    $impresioncarta->setSolicitudadmisionid($Solicitud);
                    $impresioncarta->setUsuarioid($Usuario);
                    $hoy = (new \DateTime())->format('Y-m-d H:i:s');
                    $impresioncarta->setFecharegistro($hoy);

                    try {
                        $dbm->saveRepositorio($impresioncarta);
                    } catch (\Exception $e) {
                        return new View("Error al agregar la imprecion", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            } else {
                $zip->close();
                return new \Symfony\Component\HttpFoundation\Response("La solicitud con folio " .
                    $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id)->getFolio() .
                    " no tiene cartas", Response::HTTP_PARTIAL_CONTENT, array(
                        'Content-Type' => 'text/plain'));
            }
        }
        return new View("Se ha guardado la foto", Response::HTTP_OK);
    }

    /**
     * Regresa los formatos disponibles a descargar
     * @Rest\Get("/api/Solicitud/FormatoSolicitud/", name="SolicitudFormatoSolicitud")
     */
    public function solicitudFormatoSolicitud()
    {
        $dbm = $this->get("db_manager");
        $data = $_REQUEST;

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);

        $FormatoSolicitud = $dbm->getRepositoriosById('Gradoporformato', 'gradoid', $Solicitud->getGradoid()->getGradoid());
        $Formatos = array_filter(
            $FormatoSolicitud, function ($e) {
                return $e->getFormatoid()->getTipoformatoid()->getTipoformatoid() == $_REQUEST["tipoformatoid"] && $e->getFormatoid()->getActivo() == true;
            }
        );
        if ($Formatos) {
            return new View($Formatos, Response::HTTP_OK);
        }
        return new View("No hay formatos para esta accion, para el grado " .
            $Solicitud->getGradoid()->getGrado() . ' de ' . $Solicitud->getGradoid()->getNivelid()->getNombre(), Response::HTTP_PARTIAL_CONTENT);
    }

    /**
     * Funcion para guardar una nueva solicitud
     * @Rest\Post("/api/Solicitud/hermano/infoAdicional", name="infoadicionalHermano")
     */
    public function hermanoNextAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (!empty($Solicitud)) {

            if ($Solicitud->getPendiente() <= 6) {
                $Solicitud->setPendiente(7);
            }
            $dbm->saveRepositorio($Solicitud);

            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } else {
            return new View("Error", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Funcion para guardar las personas que pueden recoger al niño
     * @Rest\Post("/api/Solicitud/personaRecogen/" , name="personaRecogensave")
     */
    public function personasRecogenAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (!empty($Solicitud)) {

            if (empty($data['idPersonaR'])) {
                $persona = new \AppBundle\Entity\Personaautorizadarecoger();
            } else {
                $persona = $dbm->getRepositorioById('Personaautorizadarecoger', 'personaautorizadarecoger', $data['idPersonaR']);
            }

            $persona->setDatoaspiranteid($Solicitud->getDatoaspiranteid());
            $persona->setNombre($data['nombrePr']);
            $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $data['parentescoPr']);
            $persona->setParentescoid($parentesco);

            try {
                $dbm->saveRepositorio($persona);
                return new View("se ha Guardado el registro", Response::HTTP_OK);
            } catch (\Exception $e) {
                return new View("No se pudo guardar el registro ", Response::HTTP_NOT_FOUND);
            }
        } else {
            return new View("Error no se encontro la solicitud", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Funcion para eliminar una personarecoje
     * @Rest\Delete("/api/Solicitud/personaRecogen/", name="DeletePersonaRecoge")
     */
    public function deletePersonaRecogeAction(Request $request)
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (!empty($Solicitud)) {
            $persona = $dbm->getRepositorioById('Personaautorizadarecoger', 'personaautorizadarecoger', $data['idPersonaR']);
            if (!empty($persona)) {
                $dbm->removeRepositorio($persona);
                return new View("Se ha eliminado un registro", Response::HTTP_OK);
            } else {
                return new View("Error no se encontro un registro con el id " . $data['idPersonaR'], Response::HTTP_NOT_FOUND);
            }
        } else {
            return new View("Error", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Funcion para guardar documentois a imprimir
     * @Rest\Post("/api/Solicitud/imprecioDocumentacion/" , name="imprecinDocumentacion")
     */
    public function imprecionDocumentacionAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);

        if (!empty($Solicitud)) {

            $cartas = $dbm->getRepositoriosById('Cartaporsolicitud', 'solicitudadmisionid', $data['solicitudid']);
            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);
            $Usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']);

            try {
                foreach ($cartas as $c) {
                    $impresioncarta = new \AppBundle\Entity\Impresiondocumento();

                    $cartaEntitiy = $dbm->getRepositorioById('Formato', 'formatoid', $c->getCartaid()->getFormatoid());
                    $impresioncarta->setFormatoid($cartaEntitiy);
                    $impresioncarta->setSolicitudadmisionid($Solicitud);
                    $impresioncarta->setUsuarioid($Usuario);
                    $hoy = (new \DateTime())->format('Y-m-d');
                    $impresioncarta->setFecharegistro(new \DateTime($hoy));

                    $dbm->saveRepositorio($impresioncarta);
                }

                return new View("Se han agregados documentos a imprimir", Response::HTTP_OK);
            } catch (\Exception $e) {
                return new View("No se pudo guardar el registro ", Response::HTTP_NOT_FOUND);
            }
        } else {
            return new View("Error no se encontro la solicitud", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Reotorna valores iniciales de datos de aspirante
     * @Rest\Get("/api/Familiar/infoComplementaria/", name="infoComplementaria")
     */
    public function informacionComplementariaAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        //$Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);
        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (!empty($Solicitud)) {
            $pais = $dbm->getRepositorios('Pais');
            $nacionalidad = $dbm->getRepositoriosById('Nacionalidad', 'activo', 1);
            $viveCon = $dbm->getRepositorios('Vivecon');
            $estados = $dbm->getTodosEStados();
            $mun = $dbm->getTodosMunicipios();

            $ocupacion = $dbm->getRepositorios('Ocupacion');
            $parentesco = $dbm->getRepositorios('Parentesco');
            $parentescoTutor = $dbm->getRepositorios('Tutor');
            $planpago = $dbm->getRepositorios('CjPlanpago');
            $SituacionConyugal = $dbm->getRepositorios('Situacionconyugal');
            $escolaridad = $dbm->getRepositorios('Escolaridad');
            $tutoresarray = [];

            if (ENTORNO == 2){
                /* Información para llenar contratos */
                $ResponsablesContratos = 0;
                $Admisioncontratoseguimiento =  $dbm->getRepositorioById('AdAdmisionseguimientocontrato', 'solicitudadmisionid', $data['solicitudadmisionid']);
                if (!empty($Admisioncontratoseguimiento)){
                    $ResponsablesContratos = $dbm->getRepositoriosById('AdAdmisioncontratoresponsable', 'admisioncontratoid', $Admisioncontratoseguimiento->getAdmisioncontratosid());                
                }else{
                    $Admisioncontratoseguimiento = 0;
                }

                $documento=$dbm->getRepositoriosModelo("AdAdmisioncontrato",[
                    "d.contratoid AS id",
                    "d.contratoid",
                    "d.nombre",
                    "d.extension",
                    "d.orden"
                ],["activo"=>1]);
                
                foreach($documento AS &$idocumento){
                    $grados=[];
                    $gradosraw=$dbm->getRepositoriosModelo("AdAdmisiongradoporcontrato",["IDENTITY(d.gradoid) AS gradoid"],["contratoid"=>$idocumento["contratoid"]]);
                    foreach($gradosraw AS $igrado){ $grados[]=(int) $igrado["gradoid"];}
                    $idocumento["grados"]=$grados;
                    unset($idocumento);
                }
                $maxsize=$dbm->getRepositorioById("Parametros", "parametrosid", 61)->getValor();                
            }
            
            $Tutores = $dbm->getRepositoriosById('Padresotutores', 'solicitudadmisionid', $data['solicitudadmisionid']);            
            foreach ($Tutores as $tutor) {
                $nacionalidadestutor = $dbm->getRepositoriosById("Nacionalidadporpadresotutores", "padresotutoresid", $tutor->getPadresotutoresid());
                $t = array(
                    "ocupacion" => $tutor->getOcupacion(),
                    "nombre" => $tutor->getNombre(),
                    "apellidopaterno" => $tutor->getApellidopaterno(),
                    "apellidomaterno" => $tutor->getApellidomaterno(),
                    "telefono" => $tutor->getTelefono(),
                    "celular" => $tutor->getCelular(),
                    "fechanacimiento" => $tutor->getFechanacimiento(),
                    "empresa" => $tutor->getEmpresa(),
                    "lugartrabajo" => $tutor->getLugartrabajo(),
                    "correo" => $tutor->getCorreo(),
                    "telempresa" => $tutor->getTelempresa(),
                    "extencionempresa" => $tutor->getExtencionempresa(),
                    "horariotrabajo" => $tutor->getHorariotrabajo(),
                    "exlux" => $tutor->getExlux(),
                    "ramo" => $tutor->getRamo(),
                    "alumnoinstituto" => $tutor->getAlumnoinstituto(),
                    "especificaralumno" => $tutor->getEspecificaralumno(),
                    "finado" => $tutor->getFinado(),
                    "capturadordatos" => $tutor->getCapturadordatos(),
                    "tutor" => $tutor->getTutor(),
                    "foto" => $tutor->getFoto(),
                    "curp" => $tutor->getCurp(),
                    "autoriza" => $tutor->getAutoriza(),
                    "especificacionocupacion" => $tutor->getEspecificacionocupacion(),
                    "tipoocupacion" => $tutor->getTipoocupacion(),
                    "padresotutoresid" => $tutor->getPadresotutoresid(),
                    "tutorid" => $tutor->getTutorid(),
                    "situacionconyugal" => $tutor->getSituacionconyugal(),
                    "nivelestudioid" => $tutor->getNivelestudioid(),
                    "generacionid" => $tutor->getGeneracionid(),
                    "tiposanguineoid" => $tutor->getTiposanguineoid(),
                    "nacionalidades" => $nacionalidadestutor,
                );
                $tutoresarray[] = $t;
            }
            $personaAutoriza = $dbm->getRepositoriosById('Personaautorizadarecoger', 'datoaspiranteid', $Solicitud->getDatoaspiranteid());
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT Nombre AS nombre, GeneracionId AS generacionid FROM generacion ORDER BY Nombre DESC');
            $stmt->execute();
            $generacion = $stmt->fetchAll();

            //Datos medicos
            $datomedico = $dbm->getRepositorioById('Datomedico', 'datosaspiranteid', $Solicitud->getDatoaspiranteid()->getDatoaspiranteid());
            $Sanguineo = $dbm->getRepositorios('Tiposanguineo');

            $antigripales = $dbm->getRepositoriosById('Medicamento', 'antigripal', 1);
            $analgesicos = $dbm->getRepositoriosById('Medicamento', 'analgesico', 1);
            $antispasmodicos = $dbm->getRepositoriosById('Medicamento', 'antispasmodico', 1);
            $materiales = $dbm->getRepositoriosById('Medicamento', 'materialcuracion', 1);
            $unguentos = $dbm->getRepositoriosById('Medicamento', 'unguento', 1);
            $remedios = $dbm->getRepositoriosById('Medicamento', 'remediosalternativo', 1);
            $antiacidos = $dbm->getRepositoriosById('Medicamento', 'antiacidos', 1);

            $return = '';
            if (ENTORNO == 2){
                    $return = array("solicitud" => $Solicitud,
                    'pais' => $pais,
                    "nacionalidad" => $nacionalidad,
                    'estados' => $estados,
                    'municipios' => $mun,
                    'vivecon' => $viveCon,
                    "ocupacion" => $ocupacion,
                    "parentesco" => $parentesco,
                    'parentescoTutor' => $parentescoTutor,
                    "situacion" => $SituacionConyugal,
                    "escolaridad" => $escolaridad,
                    "Tutores" => $tutoresarray,
                    "situacion" => $SituacionConyugal,
                    'personaAutoriza' => $personaAutoriza,
                    'generacion' => $generacion,
                    'datomedico' => $datomedico,
                    'sanguineo' => $Sanguineo,
                    'antigripales' => $antigripales,
                    'analgesicos' => $analgesicos,
                    'antispasmodicos' => $antispasmodicos,
                    'materiales' => $materiales,
                    'unguentos' => $unguentos,
                    'remedios' => $remedios,
                    'antiacidos' => $antiacidos,
                    "planpago" => $planpago,
                    "seguimientoContrato" =>  $Admisioncontratoseguimiento,
                    "responsablesContrato" => $ResponsablesContratos,
                    "documentos" => $documento,
                    "maxsize" => $maxsize,
                );
            }else{
                    $return = array("solicitud" => $Solicitud,
                    'pais' => $pais,
                    "nacionalidad" => $nacionalidad,
                    'estados' => $estados,
                    'municipios' => $mun,
                    'vivecon' => $viveCon,
                    "ocupacion" => $ocupacion,
                    "parentesco" => $parentesco,
                    'parentescoTutor' => $parentescoTutor,
                    "situacion" => $SituacionConyugal,
                    "escolaridad" => $escolaridad,
                    "Tutores" => $tutoresarray,
                    "situacion" => $SituacionConyugal,
                    'personaAutoriza' => $personaAutoriza,
                    'generacion' => $generacion,
                    'datomedico' => $datomedico,
                    'sanguineo' => $Sanguineo,
                    'antigripales' => $antigripales,
                    'analgesicos' => $analgesicos,
                    'antispasmodicos' => $antispasmodicos,
                    'materiales' => $materiales,
                    'unguentos' => $unguentos,
                    'remedios' => $remedios,
                    'antiacidos' => $antiacidos,
                    "planpago" => $planpago,
                );                
            }

            return new View($return, Response::HTTP_OK);
        } else {
            return new View("Error", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Guardar Informacion complementaria
     * @Rest\Post("/api/Familiar/infoComplementaria/", name="saveInfoComplementaria")
     */
    public function addInformacionComplementariaAction()
    {
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);

        //$Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudid']);
        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

        if (empty($Solicitud)) {
            $return = array("mensaje" => "Error no se encontro ninguna solicitud con la clave " . $data['solicitudid']);
            return new View($return, Response::HTTP_NOT_FOUND);
        } else {
            if (!empty($data['viveCon'])) {
                $viveConEntity = $dbm->getRepositorioById('Vivecon', 'viveconid', (empty($data['viveCon'])) ? null : $data['viveCon']);
                $Solicitud->getDatoaspiranteid()->setViveconid($viveConEntity);
            }
            $Solicitud->getDatoaspiranteid()->setCelular((empty($data['celular'])) ? null : $data['celular']);
            $Solicitud->getDatoaspiranteid()->setEmail((empty($data['email'])) ? null : $data['email']);
            if (!empty($data['municipio'])) {
                $MunicipioEntity = $dbm->getRepositorioById('Municipio', 'municipioid', (empty($data['municipio'])) ? null : $data['municipio']);
                $Solicitud->getDatoaspiranteid()->setMunicipionacimientoid($MunicipioEntity);
            }
            $Solicitud->getDatoaspiranteid()->setGradosextrangero((empty($data['estudiadoExtr'])) ? 0 : $data['estudiadoExtr']);
            $Solicitud->getDatoaspiranteid()->setLugargradosextranger((empty($data['textEstudiadoExtr'])) ? null : $data['textEstudiadoExtr']);

            if (!empty($data['municipioCp'])) {
                $MunicipioEntityCP = $dbm->getRepositorioById('Municipio', 'municipioid', (empty($data['municipioCp'])) ? null : $data['municipioCp']);
                $Solicitud->getDatoaspiranteid()->setMunicipioviviendaid($MunicipioEntityCP);
            }
            $Solicitud->getDatoaspiranteid()->setColonia((empty($data['colonia'])) ? null : $data['colonia']);
            $Solicitud->getDatoaspiranteid()->setOtracolonia((empty($data['otraColonia'])) ? null : $data['otraColonia']);
            $Solicitud->getDatoaspiranteid()->setCalle((empty($data['calle'])) ? null : $data['calle']);
            $Solicitud->getDatoaspiranteid()->setNumeroexterior((empty($data['numex'])) ? null : $data['numex']);
            $Solicitud->getDatoaspiranteid()->setNumerointeriror((empty($data['numint'])) ? null : $data['numint']);
            $Solicitud->getDatoaspiranteid()->setCp((empty($data['cp'])) ? null : $data['cp']);

            //Dato Medico
            //$Datoaspirante = $dbm->getRepositorioById('Datoaspirante', 'datoaspiranteid', $data['datoaspiranteid']);
            $Datomedico = $dbm->getRepositorioById('Datomedico', 'datosaspiranteid', $Solicitud->getDatoaspiranteid()->getDatoaspiranteid());
            //$Datomedico = new Datomedico();
            $Datomedico->setPadece(empty($data['enfermedad']) ? null : $data['enfermedad']);
            $Datomedico->setAlergico(empty($data['alergia1']) ? null : $data['alergia1']);
            $Datomedico->setAntecedentefamiliar(empty($data['antecedente']) ? null : $data['antecedente']);
            $Datomedico->setExamenauditivo(empty($data['auditivo']) ? null : $data['auditivo']);
            $Datomedico->setExamenortopedicos(empty($data['ortopedico']) ? null : $data['ortopedico']);
            $Datomedico->setEnfermedadcronica(empty($data['cronica']) ? null : $data['cronica']);
            $Datomedico->setTalla(empty($data['talla']) ? null : $data['talla']);
            $Datomedico->setAlergicosustancias(empty($data['sustancia']) ? null : $data['sustancia']);
            $Datomedico->setMaterialcuracion(empty($data['curacion']) ? null : $data['curacion']);
            $Datomedico->setUnguentos(empty($data['unguento']) ? null : $data['unguento']);
            $Datomedico->setNombreautoriza(empty($data['autoriza']) ? null : $data['autoriza']);
            $Datomedico->setFirma(empty($data['autorizacion']) ? null : $data['autorizacion']);
            $Datomedico->setAutorizoantihistaminico(empty($data['autorizo']) ? null : $data['autorizo']);
            $Datomedico->setExamenvista(empty($data['vista']) ? null : $data['vista']);
            $Datomedico->setLentes(empty($data['lentes']) ? null : $data['lentes']);
            $Datomedico->setAditamentosortopedico(empty($data['ortopedico1']) ? null : $data['ortopedico1']);
            //$Datomedico->setTiposanguinio(empty($data['sanguineo']) ? null : $data['sanguineo']);
            if (!empty($data['sanguineo'])) {
                $sanguineo = $dbm->getRepositorioById('Tiposanguineo', 'tiposanguineoid', $data['sanguineo']);
                $Datomedico->setTiposanguinio($sanguineo);
            }
            $Datomedico->setPeso(empty($data['peso']) ? null : $data['peso']);
            $Datomedico->setMedicamentoregularidad(empty($data['medicamento']) ? null : $data['medicamento']);
            $Datomedico->setMedicamentoadministrar(empty($data['medicamento1']) ? null : $data['medicamento1']);
            $Datomedico->setAnalgesicosantinflamatorios(empty($data['analgesicos']) ? null : $data['analgesicos']);
            $Datomedico->setAntigripalesantihistaminicos(empty($data['antigripales']) ? null : $data['antigripales']);
            $Datomedico->setAntiacidos(empty($data['Antiacidos']) ? null : $data['Antiacidos']);

            $Datomedico->setRemediosalternativos(empty($data['remediosAlternos']) ? null : $data['remediosAlternos']);
            $Datomedico->setAntiespasmodicos(empty($data['atispasmodico']) ? null : $data['atispasmodico']);

            // $Datomedico->setContactoemergencianombre(empty($data['nombreCE']) ? null : $data['nombreCE']);
            // $Datomedico->setContactoemergenciatelefono(empty($data['telCE']) ? null : $data['telCE']);
            // $Datomedico->setContactoemergenciaemail(empty($data['emailCE']) ? null : $data['emailCE']);
            //$Datomedico->setDatosaspiranteid($Datoaspirante);
            $dbm->saveRepositorio($Datomedico);


            if($data['contactoemergencia']){
                foreach($data['contactoemergencia'] as $contacto){
                    $c = new AdContactoemergencia();
                    $c->setSolicitudadmisionid($Solicitud);
                    $c->setNombre(empty($contacto['nombre']) ? null : $contacto['nombre']);
                    $c->setEmail(empty($contacto['email']) ? null : $contacto['email']);
                    //$c->setTelefono(empty($contacto['lada']) ? null : str_replace('(','',str_replace(')','',$contacto['lada'])) . '-' . str_replace('-','',$contacto['telefono']));
                    $c->setTelefono($contacto['telefono']);
                    $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $contacto['parentescoid']);
                    if($parentesco){
                        $c->setParentescoid($parentesco);
                    }
                    $dbm->saveRepositorio($c);
                }
            }

            if (!$Solicitud->getDatoaspiranteid()->getExtranjero()) {
                if (!empty($data['pais'])) {
                    $PxS = $dbm->getRepositorioById('Paisadmisionextranjero', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid());
                    $P = $dbm->getRepositorioById('Pais', 'paisid', $data['pais']);
                    if ($PxS) {
                        $PxS->setPaisid($P);
                        $PxS->setSolicitudadmisionid($Solicitud);
                    } else {
                        $PxS = new \AppBundle\Entity\Paisadmisionextranjero();
                        $PxS->setPaisid($P);
                        $PxS->setSolicitudadmisionid($Solicitud);
                    }

                    $dbm->saveRepositorio($PxS);
                }
            }

            $EstatusS = $dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', 8);
            $Solicitud->setEstatussolicitudid($EstatusS);

            $dbm->saveRepositorio($Solicitud);
            return new View($Solicitud, Response::HTTP_OK);
        }
    }


    /**
     * Guardar Informacion Admisión contratos
     * @Rest\Post("/api/Familiar/Admision/Contratos", name="saveAdmisionContratos")
     * Author: David Medina davidmq.skip@gmail.com
     */
    public function addInfoContratos()
    {        
        $dbm = $this->get("db_manager");
        $datos = $_REQUEST;
        $data = array_filter($datos);
        $Solicitud = $dbm->getRepositoriosById('AdAdmisionseguimientocontrato', 'solicitudadmisionid', $data['solicitudadmisionid']);        
        if (empty($Solicitud)){
                $Adadmisionprocesocontrato = new AdAdmisionseguimientocontrato();
                $EstatusContrato = $dbm->getRepositorioById('AdAdmisionestatuscontrato', 'estatuscontratoid', 1);                
                $PlanPago = $dbm->getRepositorioById('CjPlanPago','planpagoid', $data['formapagocontrato']);
                $Adadmisionprocesocontrato->setSolicitudadmisionid($data['solicitudadmisionid']);
                $Adadmisionprocesocontrato->setEstatusid($EstatusContrato);
                $Adadmisionprocesocontrato->setPlanpagoid($PlanPago);
                $Adadmisionprocesocontrato->setFormapago($data['pago']);
                $Adadmisionprocesocontrato->setFecha(new \DateTime());
                $dbm->saveRepositorio($Adadmisionprocesocontrato);                
                $Adadmisioncontratoresponsable = new AdAdmisioncontratoresponsable();
                $Tutor = $dbm->getRepositorioById('Tutor', 'tutorid', $data['firmanteparentesco']);
                $Adadmisioncontratoresponsable->setTutorid($Tutor);
                $Adadmisioncontratoresponsable->setNombre($data['firmantenombre']);
                $Adadmisioncontratoresponsable->setApellidopaterno($data['firmanteap']);
                $Adadmisioncontratoresponsable->setApellidomaterno($data['firmanteam']);
                $Adadmisioncontratoresponsable->setAdmisioncontratoid($Adadmisionprocesocontrato);
                $Contrato = $dbm->getRepositorioById('AdAdmisioncontrato', 'contratoid', $data['contratoid']);
                $Adadmisioncontratoresponsable->setContratoid($Contrato);
                $dbm->saveRepositorio($Adadmisioncontratoresponsable);
        }else{
            if ($data['contratoid'] == 1 ){
                $AdAdmisionseguimientocontrato = $dbm->getRepositorioById('AdAdmisionseguimientocontrato', 'solicitudadmisionid', $data['solicitudadmisionid']);
                $PlanPago = $dbm->getRepositorioById('CjPlanPago','planpagoid', $data['formapagocontrato']);
                $AdAdmisionseguimientocontrato->setPlanpagoid($PlanPago);
                $AdAdmisionseguimientocontrato->setFormapago($data['pago']);
                $dbm->saveRepositorio($AdAdmisionseguimientocontrato);
                
                $Adadmisioncontratoresponsable = $dbm->getRepositorioById('AdAdmisioncontratoresponsable', 'responsablecontratoid', $data['responsableid']);
                $Tutor = $dbm->getRepositorioById('Tutor', 'tutorid', $data['firmanteparentesco']);                
                $Adadmisioncontratoresponsable->setTutorid($Tutor);
                $Adadmisioncontratoresponsable->setNombre($data['firmantenombre']);
                $Adadmisioncontratoresponsable->setApellidopaterno($data['firmanteap']);
                $Adadmisioncontratoresponsable->setApellidomaterno($data['firmanteam']);  
                $dbm->saveRepositorio($Adadmisioncontratoresponsable);
            }
            if ($data['contratoid'] == 2 ){                                
                $Adadmisioncontratoresponsable_otro = '';
                $Adadmisioncontratoresponsable_otro2 = '';
                $AdAdmisionseguimientocontrato = $dbm->getRepositorioById('AdAdmisionseguimientocontrato', 'solicitudadmisionid', $data['solicitudadmisionid']);
                if ($data['responsablefof1'] !== '0' && $data['responsablefof1'] !== null){
                    $Adadmisioncontratoresponsable_otro = $dbm->getRepositorioById('AdAdmisioncontratoresponsable', 'responsablecontratoid', $data['responsablefof1']);
                }else{
                    $Adadmisioncontratoresponsable_otro = new Adadmisioncontratoresponsable();
                }
                if ($data['responsablefof2'] !== '0' && $data['responsablefof2'] !== null){
                    $Adadmisioncontratoresponsable_otro2 = $dbm->getRepositorioById('AdAdmisioncontratoresponsable', 'responsablecontratoid', $data['responsablefof2']);
                }else{
                    $Adadmisioncontratoresponsable_otro2 = new Adadmisioncontratoresponsable();                    
                }

                if($data['nombre']){
                    $Adadmisioncontratoresponsable_otro->setAdmisioncontratoid($AdAdmisionseguimientocontrato);
                    $Tutor = $dbm->getRepositorioById('Tutor', 'tutorid', $data['parentesco1']);                        
                    $Adadmisioncontratoresponsable_otro->setTutorid($Tutor);
                    $Adadmisioncontratoresponsable_otro->setNombre($data['nombre']);
                    $Adadmisioncontratoresponsable_otro->setApellidopaterno($data['apellidoPaterno']);
                    $Adadmisioncontratoresponsable_otro->setApellidomaterno($data['apellidoMaterno']);                                   
                    $Adadmisioncontratoresponsable_otro->setCp($data['cp']);
                    $Municipio = $dbm->getRepositorioById('Municipio', 'municipioid', $data['municipioCp']);
                    $Adadmisioncontratoresponsable_otro->setMunicipioid($Municipio);
                    $Estado = $dbm->getRepositorioById('Estado', 'estadoid', $data['estadoTempCP']);
                    $Adadmisioncontratoresponsable_otro->setEstadoid($Estado);                    
                    if($data['colonia'] !== 'Otra'){
                        $Colonia = $dbm->getRepositorioById('Colonia', 'coloniaid', $data['colonia']);
                        $Adadmisioncontratoresponsable_otro->setColonia($Colonia->getNombre());
                    }else{                        
                        $Adadmisioncontratoresponsable_otro->setColonia($data['otraColonia']);
                    }
                    $Adadmisioncontratoresponsable_otro->setCalle($data['calle']);                    
                    $Adadmisioncontratoresponsable_otro->setNumeroext($data['numex']);
                    $Adadmisioncontratoresponsable_otro->setNumeroint($data['numint']);     
                    $Adadmisioncontratoresponsable_otro->setTelefono($data['tel']);
                    $Adadmisioncontratoresponsable_otro->setCelular($data['cel']);
                    $Adadmisioncontratoresponsable_otro->setOcupacion($data['ocupacion']);
                    $Contrato = $dbm->getRepositorioById('AdAdmisioncontrato', 'contratoid', $data['contratoid']);
                    $Adadmisioncontratoresponsable_otro->setContratoid($Contrato);
                    $Adadmisioncontratoresponsable_otro->setEdad($data['edad']);

                    $dbm->saveRepositorio($Adadmisioncontratoresponsable_otro);                    
                }

                if($data['nombre2']){
                    $Adadmisioncontratoresponsable_otro2->setAdmisioncontratoid($AdAdmisionseguimientocontrato);
                    $Tutor = $dbm->getRepositorioById('Tutor', 'tutorid', $data['parentesco2']);                        
                    $Adadmisioncontratoresponsable_otro2->setTutorid($Tutor);                    
                    $Adadmisioncontratoresponsable_otro2->setNombre($data['nombre2']);
                    $Adadmisioncontratoresponsable_otro2->setApellidopaterno($data['apellidoPaterno2']);
                    $Adadmisioncontratoresponsable_otro2->setApellidomaterno($data['apellidoMaterno2']);                                   
                    $Adadmisioncontratoresponsable_otro2->setCp($data['cp2']);
                    $Municipio = $dbm->getRepositorioById('Municipio', 'municipioid', $data['municipioCp2']);
                    $Adadmisioncontratoresponsable_otro2->setMunicipioid($Municipio);
                    $Estado = $dbm->getRepositorioById('Estado', 'estadoid', $data['estadoTempCP2']);
                    $Adadmisioncontratoresponsable_otro2->setEstadoid($Estado);
                    if($data['colonia2'] !== 'Otra'){
                        $Colonia = $dbm->getRepositorioById('Colonia', 'coloniaid', $data['colonia2']);
                        $Adadmisioncontratoresponsable_otro2->setColonia($Colonia->getNombre());
                    }else{                        
                        $Adadmisioncontratoresponsable_otro2->setColonia($data['otraColonia2']);
                    }
                    $Adadmisioncontratoresponsable_otro2->setCalle($data['calle2']);                    
                    $Adadmisioncontratoresponsable_otro2->setNumeroext($data['numex2']);
                    $Adadmisioncontratoresponsable_otro2->setNumeroint($data['numint2']);
                    $Adadmisioncontratoresponsable_otro2->setTelefono($data['tel2']);
                    $Adadmisioncontratoresponsable_otro2->setCelular($data['cel2']);
                    $Adadmisioncontratoresponsable_otro2->setOcupacion($data['ocupacion2']);
                    $Contrato = $dbm->getRepositorioById('AdAdmisioncontrato', 'contratoid', $data['contratoid']);
                    $Adadmisioncontratoresponsable_otro2->setContratoid($Contrato);
                    $Adadmisioncontratoresponsable_otro2->setEdad($data['edad2']);                    
                    $dbm->saveRepositorio($Adadmisioncontratoresponsable_otro2);   
                }



            }            
        }

        return new View($Solicitud, Response::HTTP_OK);
    }

    /**
     * Descargar contratos admisión
     * @Rest\Get("/api/Contratos/Admision/descargar/{id}", name="DescargarContratoAdmision")
     * Author: David Medina davidmq.skip@gmail.com
     */
    public function descargarContratosAdmision ($id){
		try{            
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;            
            $vista_solicitud = $dbm->BuscarVistasolicitud($data["solicitudadmisionid"]);
            $Formato=$dbm->getRepositorioById('AdAdmisioncontrato', 'contratoid', $id);
            $temp = tmpfile();            
            fwrite($temp, stream_get_contents($Formato->getDocumento()));
            $path = stream_get_meta_data($temp)['uri'];            
            $parametros = $dbm->getRepositorioById("Parametros", "nombre", "UrlTokens");
            $urltokens = $parametros->getValor();                                 
            $documento = \AppBundle\Dominio\Formato::remplazarToken($vista_solicitud, $path, $urltokens);            
            fclose($temp);            
            if (empty($documento["formato"])) {
                return new View("Hay un error con el archivo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
				$response = new \Symfony\Component\HttpFoundation\Response(
					$documento["formato"],
					200,
					array(
						'Content-Type' => 'application/pdf',
						'Content-Length' => $documento["tamano"]
					)
				);
                return $response;
            }
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}        
    }

}
