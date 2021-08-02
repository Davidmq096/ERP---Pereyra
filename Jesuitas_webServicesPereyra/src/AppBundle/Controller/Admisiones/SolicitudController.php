<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\DB\DbmAdmisiones;
use AppBundle\DB\DbmCobranza;
use AppBundle\Dominio\GenerarClave;
use AppBundle\Dominio\Correo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Rest\Api;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
/**
 * Auto: javier
 */
class SolicitudController extends FOSRestController
{

    /**
     * Reotorna valores iniciales
     * @Rest\Get("/api/Solicitud", name="SolicitudAdmisionIndex")
     */
    public function indexAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $niveles = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grados = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $estatus = $dbm->getRepositoriosById('Estatussolicitud', 'activo', 1, 'estatus');
            $ciclos = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $ciclo = $dbm->getRepositorioById('Ciclo', 'siguiente', 1);

            $urlPrivacidad = $dbm->getRepositorioById('Parametros', 'nombre', "URLAvisoPrivacidad");
            $noAceptacion = $dbm->getRepositorioById('Parametros', 'nombre', "NoGarantizaAceptacion");
            $docObligatorio = $dbm->getRepositorioById('Parametros', 'nombre', "DocumentoObligatorio");
            $tablero = $dbm->getRepositorioById('Parametros', 'nombre', "URLTableros de BI");

            $return = array('niveles' => $niveles, "ciclo" => $ciclo, "ciclos" => $ciclos, "grados" => $grados, "estatus" => $estatus, "urlPrivacidad" => $urlPrivacidad, "noAceptacion" => $noAceptacion, "documentacionObligatorio" => $docObligatorio, "tablero" => $tablero);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Fltros
     * @Rest\Get("/api/Solicitud/Filters", name="SolicitudFilters")
     */
    public function solicitudFilterAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $filters = array_filter($datos, function ($value) {
                return $value !== '';
            });

            $Solicitud = $dbm->getSolicitudByFilter($filters);
            if (!$Solicitud) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            $return = array('solicitud' => $Solicitud);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Cambio de grado
     * @Rest\Put("/api/Solicitud/CambioGrado", name="CambioGrado")
     */
    public function cambioGradoBySolicitudAction()
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($data['solicitudid'] as $val) {
                $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $val);

                $gradoPorDocumentoSolicitud = $dbm->getRepositoriosById('Documentoporsolicitudadmision', 'solicitudadmision', $Solicitud->getSolicitudadmisionid());
                foreach ($gradoPorDocumentoSolicitud as $n) {
                    $dbm->removeRepositorio($n);
                }

                $gradoPorDocumento = $dbm->getRepositoriosById('Documentoporgrado', 'gradoid', $data['gradoid']);
                foreach ($gradoPorDocumento as $g) {
                    $docSolicitudAd = new \AppBundle\Entity\Documentoporsolicitudadmision();
                    $docSolicitudAd->setDocumentoporgradoid($g);
                    $docSolicitudAd->setSolicitudadmision($Solicitud);
                    $docSolicitudAd->setValidado(0);
                    $docSolicitudAd->setEntregado(0);
                    $dbm->saveRepositorio($docSolicitudAd);
                }

                $evaluaciones = $dbm->getRepositoriosById('Evaluacionporsolicitudadmision', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid());
                foreach ($evaluaciones as $e) {
                    $respuestas = $dbm->getRepositoriosById('Respuestaporaspirante', 'evaluacionporsolicitudadmisionid', $e->getEvaluacionporsolicitudadmisionid());
                    foreach ($respuestas as $r) {
                        $dbm->removeRepositorio($r);
                    }
                    $dbm->removeRepositorio($e);
                }

                $grado = $dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']);
                $Solicitud->setGradoid($grado);
                $dbm->saveRepositorio($Solicitud);
            }
            $dbm->getConnection()->commit();
            return new View('Se ha guardado el registro', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View("No se pudo actualizar el registro " . $e, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Funcion para guardar una nueva solicitud (ERP)
     * @Rest\Post("/api/Solicitudadmision/ValidacionDatos/", name="ValidacionDatosSaveSolicitud")
     */
    public function saveSolicitudValidacionDatos()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);
        $solicitudextemporanea = $data['solicitudextemporanea'];
        $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']);
        $grado = $dbm->getRepositorioById('Grado', 'gradoid', $data['grado']);
        $cupo = $dbm->getOneByParametersRepositorio("Cupoadmision", array("gradoid" => $grado->getGradoid(), "cicloid" => $ciclo->getCicloid()));
        if (!$cupo && !$solicitudextemporanea) {
            $sincupo = "No existe un perido activo de " . $grado->getGrado() . " de " . $grado->getNivelid()->getNombre() . " del " . $ciclo->getNombre();
            return new View(array("mensaje" => $sincupo), Response::HTTP_PARTIAL_CONTENT);
        }
        $totalCupo = $dbm->getNumeroDeSolicitudesValidades($grado->getGradoid(), $ciclo->getCicloid());
        if (($cupo->getCantidadfichas() <= (int) $totalCupo) && !$solicitudextemporanea) {
            $listaespera = "Se ha alcanzado el límite de fichas de " . $grado->getGrado()
                . " de " . $grado->getNivelid()->getNombre()
                . " configuradas para este periodo de admisión.";
            return new View(array("mensaje" => $listaespera), Response::HTTP_PARTIAL_CONTENT);
        }

        $Solicitud = $this->guardarSolicitud($data, 0, 0);
        $this->validateNacionalidad($Solicitud->getDatoaspiranteid(), $data['extranjero']);
        $return = array('mensaje' => 'Se ha guardado el registro', 'solicitud' => $Solicitud);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * Funcion para guardar una nueva solicitud (Portal admisiones)
     * @Rest\Post("/api/Solicitudadmision/", name="SolicitudSave")
     */
    public function saveSolicitud()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $datos = $_REQUEST;
        $data = array_filter($datos);

        $ciclo = $dbm->getRepositorioById('Ciclo', 'siguiente', 1);
        $cupo = $dbm->getOneByParametersRepositorio("Cupoadmision", array(
            "gradoid" => $data['grado'],
            "cicloid" => $ciclo->getCicloid(), "activo" => true
        ));
        $totalCupo = $dbm->getNumeroDeSolicitudesValidades($data['grado'], $ciclo->getCicloid());
        $grado = $dbm->getRepositorioById('Grado', 'gradoid', $data['grado']);

        if (empty($data['clave'])) {
            if (!$cupo) {
                return new View(
                    array("mensaje" => "No se ha configurado el cupo para " . $grado->getGrado() . " del nivel " . $grado->getNivelid()->getnombre()),
                    Response::HTTP_PARTIAL_CONTENT
                );
            }
            if ($cupo->getIniciorecepcion() > new \DateTime()) {
                $return = array("mensaje" => "No ha iniciado el periodo de admisión.");
                return new View($return, Response::HTTP_PARTIAL_CONTENT);
            }

            if ($cupo->getFinrecepcion() < new \DateTime()) {
                $return = array("mensaje" => "Se ha terminado el periodo de admisión.");
                return new View($return, Response::HTTP_PARTIAL_CONTENT);
            }
            $data["cicloid"] = $ciclo->getCicloid();
            if ($cupo->getCantidadfichas() > $totalCupo) {
                $Solicitud = $this->guardarSolicitud($data, 1, 0);
                $return = array("clave" => $Solicitud->getClavesolicitud(), "solicitudadmisionid" => $Solicitud->getSolicitudadmisionid(), "mensaje" => "Se ha guardado un registro", 'msjCupoAdmision' => $cupo->getTextocapturaficha());
                return new View($return, Response::HTTP_OK);
            } else {
                if ($cupo->getListaespera()) {
                    $Solicitud = $this->guardarSolicitud($data, 1, 1);
                    $return = array("clave" => $Solicitud->getClavesolicitud(), "solicitudadmisionid" => $Solicitud->getSolicitudadmisionid(), "mensaje" => $cupo->getTextolistaespera(), 'msjCupoAdmision' => $cupo->getTextocapturaficha());
                    return new View($return, Response::HTTP_ACCEPTED);
                } else {
                    $return = array("mensaje" => $cupo->getTextocompleto());
                    return new View($return, Response::HTTP_PARTIAL_CONTENT);
                }
            }
        } else {
            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
            $SolicitudEntity->setCorreo($data['correo']);
            if ($SolicitudEntity->getPendiente() == 1) {
                $SolicitudEntity->setPendiente(2);
            }
            $dbm->saveRepositorio($SolicitudEntity);
            $this->validateNacionalidad($SolicitudEntity->getDatoaspiranteid(), $data['extranjero'] == "true");
            $this->envioCorreoTemporal($data['solicitudadmisionid']);
            $return = array("clave" => $data['clave'], "solicitudadmisionid" => $SolicitudEntity->getSolicitudadmisionid(), "pendiente" => $SolicitudEntity->getPendiente());
            return new View($return, Response::HTTP_OK);
        }
    }

    /** Crea una ueva solicitud */
    public function guardarSolicitud($data, $internet, $listaEspera)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $dbm->getConnection()->beginTransaction();

        $Solicitud = new \AppBundle\Entity\Solicitudadmision();
        $Solicitud->setClavesolicitud(GenerarClave::Generarclave());
        $Solicitud->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $data['grado']));
        $Solicitud->setPendiente(1);
        $Solicitud->setCorreo((empty($data['correo'])) ? null : $data['correo']);
        $Solicitud->setCapturainternet($internet);
        $Solicitud->setFechacaptura(new \DateTime());
        $Solicitud->setListaespera($listaEspera);
        $Solicitud->setSolicitudextemporanea($data['solicitudextemporanea']);
        $Solicitud->setEstatussolicitudid($dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', 1));
        $dbm->saveRepositorio($Solicitud);
        $Solicitud->setFolio($Solicitud->getSolicitudadmisionid());

        //Creacion de item para dinamica familiar
        $Dinamica = new \AppBundle\Entity\Dinamicafamiliar();
        $dbm->saveRepositorio($Dinamica);
        //generamos un datos del aspirante
        $Aspirante = new \AppBundle\Entity\Datoaspirante();
        $Aspirante->setExtranjero((empty($data["extranjero"])) ? null : $data["extranjero"]);
        $dbm->saveRepositorio($Aspirante);
        $Aspirante->setDinamicafamiliarid($Dinamica);
        $Solicitud->setDatoaspiranteid($Aspirante);
        //Creacion de item para datos medicos
        $DatoMedico = new \AppBundle\Entity\Datomedico;
        $DatoMedico->setDatosaspiranteid($Aspirante);
        $dbm->saveRepositorio($DatoMedico);
        //generamos un contacto
        $contacto = new \AppBundle\Entity\Contacto();
        $contacto->setCorreo((empty($data['correo'])) ? null : $data['correo']);
        $dbm->saveRepositorio($contacto);
        $Solicitud->setContactoid($contacto);
        //guardamos informacion adicional
        $info = new \AppBundle\Entity\Infoadicional();
        $dbm->saveRepositorio($info);
        $Solicitud->setInfoadicionalid($info);
        //Generamos encuesta
        $encuesta = new \AppBundle\Entity\Encuesta();
        $dbm->saveRepositorio($encuesta);
        $Solicitud->setEncuestaid($encuesta);

        $dbm->saveRepositorio($Solicitud);
        //Creamos los documentos deacuerdo al grado
        $gradoPorDocumento = $dbm->getRepositoriosById('Documentoporgrado', 'gradoid', $data['grado']);
        foreach ($gradoPorDocumento as $g) {
            $docSolicitudAd = new \AppBundle\Entity\Documentoporsolicitudadmision();
            $docSolicitudAd->setDocumentoporgradoid($g);
            $docSolicitudAd->setSolicitudadmision($Solicitud);
            $docSolicitudAd->setValidado(0);
            $docSolicitudAd->setEntregado(0);
            $dbm->saveRepositorio($docSolicitudAd);
        }
        //Relacionamos la solicitud del ciclo siguiente
        $solicitudPorCiclo = new \AppBundle\Entity\Solicitudadmisionporciclo();
        $solicitudPorCiclo->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']));
        $solicitudPorCiclo->setSolicitudadmisionid($Solicitud);
        $dbm->saveRepositorio($solicitudPorCiclo);
        $dbm->getConnection()->commit();

        return $Solicitud;
    }

    /** Agrega o elimina la nacionalidad mexicana si indicas que eres mexicano o extranjero */
    public function validateNacionalidad($Aspirante, $extranjero)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $Aspirante->setExtranjero($extranjero);
        $dbm->saveRepositorio($Aspirante);

        $mexicano = $dbm->getOneByParametersRepositorio("Nacionalidadpordatoaspirante", array("nacionalidad" => 112, "datoaspiranteid" => $Aspirante->getDatoaspiranteid()));
        if ($extranjero && !$mexicano) {
            //Nacionalidad agregamos (Mexicano)
            $NxA = new \AppBundle\Entity\Nacionalidadpordatoaspirante();
            $NxA->setNacionalidad($dbm->getRepositorioById('Nacionalidad', 'nacionalidadid', 112));
            $NxA->setDatoaspiranteid($Aspirante);
            $dbm->saveRepositorio($NxA);
        } else {
            if ($mexicano) {
                $dbm->removeRepositorio($mexicano);
            }
        }
    }

    /**
     * Envia el correo para recuperar una solicitud de admision
     * @Rest\Get("/api/Familiar/EnvioCorreoSolicitud/{id}", name="EnvioCorreoSolicitud")
     */
    public function envioCorreoTemporal($id)
    {
        $dbm = $this->get("db_manager");

        $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);
        $parametros = $dbm->getRepositorioById('Parametros', 'parametrosid', 4);

        //Enviar correo se confirmacion a usuario logueado
        $correoPlatilla = $dbm->getRepositorioById('Correo', 'correoid', 3);
        $correo = array($Solicitud->getCorreo());
        $parametros = array(
            "0" => $Solicitud->getCorreo(),
            "1" => $Solicitud->getClavesolicitud(),
            "2" => $parametros->getValor(),
        );
        Correo::ServicioCorreo($correo, $parametros, $correoPlatilla, $this->get('mailer'));

        $return = array("Rest" => 'Se ha guardado');
        return new View($return, Response::HTTP_OK);
    }


    /**
     * Servicion para recuperar una solicitud
     * @Rest\Get("/api/Solicitud/Login/", name="SolicitudLogin")
     */
    public function LoginAction()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $datos = $_REQUEST;
        $data = array_filter($datos);
        $Solicitud = $dbm->getOneByParametersRepositorio("Solicitudadmision", array("clavesolicitud" => $data['clave'], "correo" => $data['correo']));
        if (empty($Solicitud)) {
            return new View('El correo electrónico o la clave de solicitud son incorrectos', Response::HTTP_PARTIAL_CONTENT);
        } else {
            $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid()))->getCicloid();
            $cupo = $dbm->getOneByParametersRepositorio("Cupoadmision", array(
                "gradoid" => $Solicitud->getGradoid()->getGradoid(),
                "cicloid" => $ciclo->getCicloid()
            ));
            if ($cupo) {
                $return = array('solicitud' => $Solicitud, 'msjCupoAdmision' => $cupo->getTextocapturaficha());
                return new View($return, Response::HTTP_OK);
            } else {
                return new View('El periodo de admisión no existe', Response::HTTP_PARTIAL_CONTENT);
            }
        }
    }

    /**
     * Peticion inicial al abrir la modal de la solicitud
     * @Rest\Get("/api/Solicitudadmision/{id}", name="Solicitudadmision")
     */
    public function getSolicitudadmision($id)
    {
        try {

            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $url = $dbm->getRepositorioById('Parametros', 'nombre', 'URLServicios');
            $entidad = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);
            $entidad->getDatoaspiranteid()->setFoto($url->getValor() . '/api/Solicitud/foto/?solicitudid=' . $id);
            $entidad->getDatoaspiranteid()->setFotofamiliar($url->getValor() . '/api/Solicitud/foto/?solicitudid=' . $id . '&familiar=true');


            $listaespera;
            $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $id))->getCicloid();
            $cupo = $dbm->getByParametersRepositorios("Cupoadmision", array("gradoid" => $entidad->getGradoid()->getGradoid(), "cicloid" => $ciclo->getCicloid()));
            if (!$cupo) {
                $sincupo = "No existe un perido activo de " . $entidad->getGradoId()->getGrado() . " de " . $entidad->getGradoId()->getNivelid()->getNombre() . " del " . $ciclo->getNombre();
                return new View($sincupo, Response::HTTP_PARTIAL_CONTENT);
            }
            $totalCupo = $dbm->getNumeroDeSolicitudesValidades($entidad->getGradoid()->getGradoid(), $ciclo->getCicloid());
            if ($cupo[0]->getCantidadfichas() <= (int) $totalCupo && $entidad->getEstatussolicitudid()->getEstatussolicitudid() < 3) {
                $listaespera = "Se ha alcanzado el límite de fichas de " . $entidad->getGradoid()->getGrado()
                    . " de " . $entidad->getGradoid()->getNivelid()->getNombre()
                    . " configuradas para este periodo de admisión, al terminar la validación de ésta solicitud será enviada a LISTA DE ESPERA.";
            }

            $return = array("entidad" => $entidad, "listaespera" => $listaespera, 'ciclo' => $ciclo);
            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

	/**
     * Descarga un formato solicitud con los tokens remplazados
     * @Rest\Get("/api/Solicitud/tokens/{solicitudId}", name="SolicitudTokens")
     */
    public function SolicitudTokens()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $data = $_REQUEST;

        $vista_solicitud = $dbm->BuscarVistasolicitud($data["solicitudid"]);
        return new View($vista_solicitud, Response::HTTP_OK);
    }

    /**
     * Descarga un formato solicitud con los tokens remplazados
     * @Rest\Get("/api/Solicitud/DownloadFormatoSolicitud/", name="SolicitudDownloadFormatoSolicitud")
     */
    public function solicitudDownloadFormatoSolicitud()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $data = $_REQUEST;

        $vista_solicitud = $dbm->BuscarVistasolicitud($data["solicitudid"]);

        $gradoid = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data["solicitudid"])->getGradoid();
        $formatoid = $dbm->getByParametersRepositorios('Formato', array('tipoformatoid' => $data["tipoformatoid"], 'activo' => 1));
        $Formato = $dbm->getOneByParametersRepositorio('Gradoporformato', array(
            'gradoid' => $gradoid,
            'formatoid' => $formatoid
        ));
        if (!$Formato) {
            return new View("No hay un formato activo para el grado de la solicitud.", Response::HTTP_PARTIAL_CONTENT);
        }
        $Formato = $Formato->getFormatoid();

        $temp = tmpfile();
        fwrite($temp, stream_get_contents($Formato->getFormatocontenido()));
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
    }

    /**
     * Validar Datos, Cambia el estatus de la solicitud a validado
     * @Rest\Post("/api/Solicitud/validacionDatos/validado" , name="validacionDatosvalidadoSave")
     */
    public function validacionDatoValidadosAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $Solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);

            if (empty($Solicitud)) {
                return new View("Error no se encontro la solicitud", Response::HTTP_NOT_FOUND);
            }

            if ($Solicitud->getEstatussolicitudid()->getEstatussolicitudid() < 3) {
                $dbm->getConnection()->beginTransaction();
                if ($data["listaespera"]) {
                    $Solicitud->setListaespera(1);
                    $msj = 'La solicitud fue enviada a lista de espera';
                } else {
                    $Solicitud->setFechavalidacion(new \DateTime());
                    $Solicitud->setEstatussolicitudid($dbm->getRepositorioById('Estatussolicitud', 'estatussolicitudid', 3));
                    $Solicitud->setValidadopor($dbm->getRepositorioById('Usuario', 'usuarioid', $data["usuariovalida"]));
                    $msj = 'Se ha actualizado el registro';
                }
                $dbm->saveRepositorio($Solicitud);
                $dbm->getConnection()->commit();
                return new View($msj, Response::HTTP_OK);
            } else {
                return new View('Se ha actualizado el registro', Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Funcion para cambiar solicitud de lista de espera a solicitud normal
     * @Rest\Post("/api/Solicitud/ListaEspera/", name="ListaEspera")
     */
    public function updateEstatusNotListaesperaAction()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            if (empty($data)) {
                return new View("Debes seleccionar mnimo un elemento para esta opción", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach ($data as $solicitudid) {
                $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $solicitudid);
                $SolicitudEntity->setListaespera(0);
                $dbm->saveRepositorio($SolicitudEntity);
            }
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

       /**
	 * @Rest\Get("/api/Solicitud/foto/", name="getAspiranteFoto")
	 */
	public function getAspiranteFoto()
	{
		try {
			$datos = $_REQUEST;
			$filtros = array_filter($datos);
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $foto = $dbm->getFotoBySolicitud($filtros);
            $foto = $foto ? stream_get_contents($foto[0]['foto']) : null;

            if($foto){
                return Api::download($foto, 'image/png');
            }else{
                return new View("No se ha encontrado una imagen", Response::HTTP_PARTIAL_CONTENT);
            }
            
		} catch (Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

    /**
     * Retorna la informacion para imprimir el recibo de inscripcion (LUX)
     * @Rest\Get("/api/reciboinscripcion/getdatosimpresion/{id}", name="BuscarDatosImpresionById")
     */
    public function BuscarDatosImpresionById($id)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);
            //$clavefamiliar = $dbm->getRepositorioById('CeClavefamiliar', 'clave', $SolicitudEntity->getClavefamiliar());
            //$ciclosolicitud = $dbm->getRepositorioById('solicitudadmisionporciclo', 'solicitudadmisionid', $id);

            if ($SolicitudEntity->getEstatussolicitudid()->getEstatussolicitudid() != 8) {
                return new View("Debe completar la solicitud para poder imprimir el recibo", Response::HTTP_PARTIAL_CONTENT);
            }

            $documentos = $dbm->getRepositoriosById('CjDocumentoporpagar', 'solicitudadmisionid', $SolicitudEntity);
            $documentosinscripcion = array_filter($documentos, function ($d) {
                return substr($d->getDocumento(), 4, 2) == "00";
            });

            if ($documentosinscripcion) {
                $d = reset($documentosinscripcion);
                $cicloinicio = $dbm->getRepositorioById('CeCiclopornivel', 'cicloid', $d->getCicloid());
                $referencia = \AppBundle\Dominio\PagoLinea::GenerarReferencia(
                    $SolicitudEntity->getFolio(),
                    1,
                    $cicloinicio->getFechainicio(),
                    $SolicitudEntity->getGradoid()->getNivelid()->getNivelid(),
                    $SolicitudEntity->getGradoid()->getGrado(),
                    $d->getDocumento(),
                    $d->getSubconceptoid()->getSubconceptoid()
                );
                foreach ($documentosinscripcion as $d) {
                    $d->setReferenciaBanco($referencia);
                    $dbm->saveRepositorio($d);
                }
            }

            //$dbmc = new DbmCobranza($this->get("db_manager")->getEntityManager());
            //$bloqueo = \AppBundle\Dominio\Bloqueos::BloqueoAlumno($dbmc,array(
            //    "solicitudadmisionid" => $SolicitudEntity->getSolicitudadmisionid(),
            //    "clavefamiliarid" => $clavefamiliar ? $clavefamiliar->getClavefamiliarid() : null,
            //    "fechalimite" => new \DateTime(),
            //    "cicloid" => $ciclosolicitud ? $ciclosolicitud->getCicloid()->getCicloid() : null
            //));

            $result = $dbm->reciboInscripcion($id);
            $result['cvhermanos'] = $bloqueo['colegiaturashermanosvencidas'];
            return new View($result, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/Solicitud/SolicitudReporte/{id}", name="solicitudReporte")
     */
    public function solicitudReporte($id)
    {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;
            $filtros = array_filter($datos, function ($value) {
                return $value !== '';
            });
            $cicloactual = $dbm->getRepositorioById('Ciclo','cicloid', $filtros['cicloid']);
    
    
            $env=[1=>"Lux/",2=>"Ciencias/"];
            try{
                $path = str_replace('app', '', $this->get('kernel')->getRootDir());
                $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";
    
                switch (ENTORNO) {
                    case 1:
                        $logo = $path . "Lux/logo.png";
                        $plantilla = "\"" . $path . "Lux/";
                        break;
                    case 2:
                        $logo = $path . "Ciencias/logo.png";
                        $plantilla = "\"" . $path . "Ciencias/";
                        break;
                }
                if($filtros['gradoId']) {
                    $grados = implode(",", $filtros['gradoId']);
                }
                if($filtros['estatus']) {
                    $estatus = implode(",", $filtros['estatus']);
                }
                $params=[
                    "cicloid"=>$filtros['cicloId'],
                    "nivelid"=>$filtros['nivelId'] ? $filtros['nivelId'] : 0,
                    "gradoid"=>$grados ? $grados: 0,
                    "inscrito"=>$filtros['inscrito'],
                    "nombre"=>$filtros['nombre'] ? $filtros['nombre'] : null,
                    "apellidopaterno"=>$filtros['apellidopaterno'] ? $filtros['apellidopaterno'] : '',
                    "apellidomaterno"=>$filtros['apellidomaterno'] ? $filtros['apellidomaterno'] : '',
                    "matricula"=>$filtros['matricula'] ? $filtros['matricula'] : '',
                    "folio"=>$filtros['folio'] ? $filtros['folio'] : '',
                    "clavesolicitud"=>$filtros['clave'] ? $filtros['clave'] : '',
                    "clavefamiliarid"=>$filtros['clavefamiliar'] ? $filtros['clavefamiliar'] : '',
                    "solicitudpagada"=>$filtros['solicitudpagada'],
                    "estatussolicitud"=>$estatus ? $estatus: 0,
                    "logo"=>$logo
                ];
                $plantilla = $plantilla . "AdmisionReporte.jrxml\"";
        
                $jasper = new JasperPHP($this->container);
                $respuesta = $jasper->process(
                    $plantilla,
                    "\"" . $path . "AdmisionReporte\"",
                    array('xlsx'),
                    $params,
                    true
                )->execute();
    
                $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/AdmisionReporte.xlsx";
                if ($respuesta) {
                    return new View($respuesta, Response::HTTP_PARTIAL_CONTENT);
                }
                $response = new \Symfony\Component\HttpFoundation\Response(
                    file_get_contents($reporte),
                    200,
                    array(
                        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
                        'Content-Length' => filesize($reporte)
                    )
                );
                unlink($reporte);
                return $response;
            
            
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
