<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\ClasificadorAlumno;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
use AppBundle\Entity\CeAlumnocorreo;
use AppBundle\Entity\CeAlumnotelefono;
use AppBundle\Entity\CeAlumnolugarnacimiento;
use AppBundle\Entity\CeAlumnodomicilio;
use AppBundle\Entity\CeAlumnodinamicafamiliar;
use AppBundle\Entity\CeAlumnodatomedico;
use AppBundle\Entity\CeAlergiapordatomedico;
use AppBundle\Entity\CeAntecedentefamiliarpordatomedico;
use AppBundle\Entity\CeContactoemergencia;
use AppBundle\Entity\CeActividad;
use AppBundle\Rest\Api;
use AppBundle\Entity\CePersonaautorizadarecogerporalumno;

/**
 * @author Gabriel
 */

class AlumnoController extends FOSRestController
{

    /**
     * Metodo para guardar y notificar el registro de actividad de un alumno
     * @Rest\Post("/api/Alumno/Actividad", name="ActividadAlumno")
     */
    public function ActividadAlumno()
    {
        /*
		$actividad=[
			"fecha"=>new \DateTime(),
			"tipoactividadid"=>2,
			"usuarioid"=>1,
			"alumnoporcicloid"=>227,
			"materiaporplanestudioid"=>51,
			"descripcion"=>"descripcion argumento"
		];
		\AppBundle\Controller\Controlescolar\AlumnoController::ActividadAlumno($actividad);
		*/
        try {
            $args = func_get_args();
            if (count(func_get_args()) == 1) {
                $decoded = $args[0];
            } else {
                $content = trim(file_get_contents("php://input"));
                $decoded = json_decode($content, true);
            }

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $actividad = $hydrator->hydrate(new CeActividad(), $decoded);
            $dbm->saveRepositorio($actividad);
            return new View("Se registro la actividad", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Obtiene los catalogos para buscar alumnos en la modal
     * @Rest\Get("/api/Alumno", name="InicioAlumno")
     */
    public function indexAlumno()
    {
        $actividad = [
            "fecha" => new \DateTime(),
            "tipoactividadid" => 1,
            "usuarioid" => 1
        ];
        \AppBundle\Controller\Controlescolar\AlumnoController::ActividadAlumno($actividad);
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $cicloactual = $dbm->getRepositorioById("Ciclo", "actual", 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $grupo = $dbm->getRepositoriosModelo("CeGrupo", ["d.grupoid AS id", "d.grupoid", "IDENTITY(d.cicloid) AS cicloid", "IDENTITY(d.gradoid) AS gradoid", "d.nombre"], ["tipogrupoid" => 1, "cicloid" => $cicloactual->getCicloid()]);
            $estatus = $dbm->getRepositoriosById('CeAlumnoestatus', 'activo', 1);

            $array = array("nivel" => $nivel, "grado" => $grado, "grupo" => $grupo, "estatus" => $estatus);
            return new View($array, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de alumnos en base a los parametros enviados en la modal
     * @Rest\Get("/api/Alumno/", name="BuscarAlumnoExpediente")
     */
    public function getAlumno()
    {
        try {
            $datos = $_REQUEST;
            $datos["precision"] = array_key_exists("precision", $datos);
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarAlumnosA($filtros);

            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de alumnos en base a los parametros enviados en la modal
     * @Rest\Get("/api/Alumno/foto", name="getalumnoFoto")
     */
    public function getalumnoFoto()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if ($filtros['alumnoporcicloid']) {
                $foto = $dbm->getRepositorioById('CeAlumnociclofoto', 'alumnoporcicloid', $filtros['alumnoporcicloid']);
                $foto = $foto ? stream_get_contents($foto->getFoto()) : null;
            } else {
                $stmt = $dbm->getConnection()->prepare('SELECT foto FROM ce_alumnofotocicloactualvista WHERE alumnoid = :alumnoid');
                $stmt->execute(array('alumnoid' => $filtros['alumnoid']));
                $foto = $stmt->fetch()['foto'];
            }

            if ($foto) {
                return Api::download($foto, 'image/png');
            } else {
                $root = str_replace('app', '', $this->get('kernel')->getRootDir()) . "web/avatar.png";
                return Api::download(base64_encode(file_get_contents($root)), 'image/png');
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de alumnos en base a los parametros enviados en la modal con sus padres
     * @Rest\Get("/api/AlumnoPadre/", name="BuscarAlumnoPadres")
     */
    public function getAlumnoPadre()
    {
        try {
            $datos = $_REQUEST;
            $datos["precision"] = array_key_exists("precision", $datos);
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $conn = $dbm->getConnection();
            $entidad = $dbm->BuscarAlumnosA($filtros);

            foreach ($entidad as $key => $alumno) {
                $clave = $dbm->getRepositorioById("CeAlumnoporclavefamiliar", "alumnoid", $alumno["alumnoid"])->getClavefamiliarid()->getClave();
                $stmt = $conn->prepare('SELECT * FROM ce_pppadretutoralumnovista WHERE Clave = :clave');
                $stmt->execute(array('clave' => $clave));
                $result = $stmt->fetchAll();
                $entidad[$key]["padres"] = $result;
            }
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el recibo de inscripcion de un alumno
     * @Rest\Get("/api/Alumno/Reciboinscripcion/{id}", name="BuscarAlumnoReciboInscipcion")
     */
    public function getAlumnoReciboInscripcion($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarReciboInscripcionAlumno($id);
            if (!$entidad) {
                return new View("No se ha generado el registro de inscripción", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna la lista de asistencia de un alumno
     * @Rest\Get("/api/Alumno/Listadeasistencia/{profesorpormateriaplanestudioid}", name="BuscarAlumnoListadeasistencia")
     */
    public function getAlumnoListadeasistencia($profesorpormateriaplanestudioid)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $path = str_replace('app', '', $this->get('kernel')->getRootDir());
            $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";

            switch (ENTORNO) {
                case 1:
                    $logo = $path . "Lux/logonombre.png";
                    $plantilla = "\"" . $path . "Lux/";
                    break;
                case 2:
                    $logo = $path . "Ciencias/logonombre.png";
                    $plantilla = "\"" . $path . "Ciencias/";
                    break;
            }

            $plantilla = $plantilla . "Lista_Asistencia_" . (ENTORNO == 1 ? "Lux" : "Ciencias") . ".jrxml\"";

            $jasper = new JasperPHP($this->container);
            $respuesta = $jasper->process(
                $plantilla,
                "\"" . $path . "Lista_Asistencia\"",
                array("pdf"),
                array("profesorpormateriaplanestudioid" => $profesorpormateriaplanestudioid, 'logo' => $logo),
                true
            )->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/Lista_Asistencia.pdf";
            if ($respuesta) {
                return new View($respuesta, Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte),
                200,
                array(
                    'Content-Type' => 'application/pdf',
                    'Content-Length' => filesize($reporte)
                )
            );
            return $response;
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el estado de cuenta de un alumno o de todos los alumnos de la familia en base al alumno solicitada
     * @Rest\Get("/api/Alumno/Estadocuenta/{id}", name="BuscarAlumnoEstadoCuenta")
     */
    public function getAlumnoEstadoCuenta($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $path = str_replace('app', '', $this->get('kernel')->getRootDir());
            $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";

            switch (ENTORNO) {
                case 1:
                    $logo = $path . "Lux/logonombre.png";
                    $plantilla = "'" . $path . "Lux/";
                    break;
                case 2:
                    $logo = $path . "Ciencias/logonombre.png";
                    $plantilla = "'" . $path . "Ciencias/";
                    break;
            }

            if ($datos["familia"] == "true") {
                $plantilla = $plantilla . "Estado_de_cuenta_familiar_" . (ENTORNO == 1 ? "Lux" : "Ciencias") . ".jrxml'";
                $familia = $dbm->getRepositorioById("CeAlumnoporclavefamiliar", "alumnoid", $id)->getClavefamiliarid();
                $alumnos = $dbm->getRepositoriosById("CeAlumnoporclavefamiliar", "clavefamiliarid", $familia);
                $alumno = array();
                foreach ($alumnos as $a) {
                    array_push($alumno, $a->getAlumnoid()->getAlumnoid());
                }
                $alumno = implode(",", $alumno);
            } else {
                $plantilla = $plantilla . "Estado_de_cuenta_" . (ENTORNO == 1 ? "Lux" : "Ciencias") . ".jrxml'";
                $alumno = intval($id);
            }
            switch ($datos["tipoestadocuenta"]) {
                case 1: //Saldo total del ciclo
                    $where = "and d.saldo > 0 and d.pagoestatusid IN (1,2) and c.actual = 1 ";
                    break;
                case 2:  //Solo el saldo vencido
                    $where = "and d.saldo > 0 and d.pagoestatusid IN (1,2) and d.fechalimitepago < now() ";
                    break;
                case 3: // Todo el historial de pagos
                    $where = "and d.saldo > 0 and d.pagoestatusid IN (1,2) ";
                    break;
                case 4: // Todo el historial de pagos
                    $where = "and d.saldo > 0 and d.pagoestatusid IN (1,2) and (d.fechalimitepago BETWEEN '" . $datos["fechainicio"] . "' and '" . $datos["fechafin"] .
                        "' or p.fecha BETWEEN '" . $datos["fechainicio"] . "' and '" . $datos["fechafin"] . "') ";
                    break;
            }

            $jasper = new JasperPHP($this->container);
            $respuesta = $jasper->process(
                $plantilla,
                "'" . $path . "Estado_de_cuenta'",
                array("pdf"),
                array("alumnoid" => $alumno, 'where' => $where, 'logo' => $logo),
                true
            )->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/Estado_de_cuenta.pdf";
            if ($respuesta) {
                return new View($respuesta, Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte),
                200,
                array(
                    'Content-Type' => 'application/pdf',
                    'Content-Length' => filesize($reporte)
                )
            );
            return $response;
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Obtiene los catalogos de la pantalla de datos generales del alumno
     * @Rest\Get("/api/Controlescolar/Alumno", name="CEAAlumnoCatalogos")
     */
    public function CEAAlumnoCatalogosDatos()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $estatus = $dbm->getRepositoriosById('CeAlumnoestatus', 'activo', 1);
            $estatusalumnociclo = $dbm->getRepositoriosById('CeEstatusalumnoporciclo', 'activo', 1);
            $tipobaja = $dbm->getRepositoriosById('CeTipobaja', 'activo', 1);
            $motivobaja = $dbm->getRepositoriosById('CeMotivobaja', 'activo', 1);
            $nacionalidad = $dbm->getRepositoriosById('Nacionalidad', 'activo', 1);
            $parentesco = $dbm->getRepositorios('Parentesco');
            $pais = $dbm->getRepositoriosById('Pais', 'activo', 1);
            $estado = $dbm->getRepositoriosById('Estado', 'activo', 1);
            $ciudad = $dbm->getRepositoriosById('Municipio', 'activo', 1);
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $idiomanivel = $dbm->getRepositoriosById('CeIdiomanivel', 'activo', 1);
            $intencionreinscribirse = $dbm->getRepositorios('CeIntencionreinscribirse');
            $idiomacertificacion = $dbm->getRepositorios('CeCertificacion');
            $idioma = $dbm->getRepositorios('CeIdioma');
            $cicloactual = $dbm->getRepositorioById('Ciclo', 'actual', 1);
            $grupo = $dbm->getByParametersRepositorios('CeGrupo', array('tipogrupoid' => 1, 'cicloid' => $cicloactual));
            $grupofull = $dbm->getByParametersRepositorios('CeGrupo', array('tipogrupoid' => 1));

            $filtro = array(
                'estatus' => $estatus,
                'tipobaja' => $tipobaja,
                'motivobaja' => $motivobaja,
                'estatusalumnociclo' => $estatusalumnociclo,
                'nacionalidad' => $nacionalidad,
                'parentesco' => $parentesco,
                'grupo' => $grupo,
                'gruposfull' => $grupofull,
                'pais' => $pais,
                'estado' => $estado,
                'ciudad' => $ciudad,
                'ciclo' => $ciclo,
                'nivel' => $nivel,
                'grado' => $grado,
                'parentesco' => $parentesco,
                'semestre' => $semestre,
                'idiomanivel' => $idiomanivel,
                'idiomacertificacion' => $idiomacertificacion,
                "idioma" => $idioma,
                "intencion" => $intencionreinscribirse
            );

            return new View($filtro, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de los alumnos
     * @Rest\Put("/api/portalfamiliar/{sistema}/Alumno" , name="PPEditarDatosAlumno")
     */
    public function EditarDatosAlumno($sistema)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);

            //datos
            $nalumno = $data['datos'];
            $actualizar = $data['actualizardatos'];
            $claveFamiliar = $data['clavefamiliar'];
            $datoMedico = $data['datomedico'];
            $dinamicaFamiliar = $data['dinamicafamiliar'];
            $alergia = $data['alergia'];
            $antecedenteImportante = $data['antecedente'];
            $recoger = $data['recoger'];
            $contactoseliminados = $data['contactoseliminados'];
            $contactosemergencia = $data['contactosemergencia'];

            // coneccion
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            //borrar datos existentes            
            $dbm->removeManyRepositorio('CeAlumnocorreo', 'alumnoid', $nalumno['AlumnoId']);
            $dbm->removeManyRepositorio('CeAlumnodomicilio', 'alumnoid', $nalumno['AlumnoId']);
            $dbm->removeManyRepositorio('CeAlumnolugarnacimiento', 'alumnoid', $nalumno['AlumnoId']);
            $dbm->removeManyRepositorio('CeAlumnotelefono', 'alumnoid', $nalumno['AlumnoId']);

            $dbm->removeManyRepositorio('CeAlergiapordatomedico', 'alumnodatomedicoid', $datoMedico['AlumnoDatoMedicoId']);
            $dbm->removeManyRepositorio('CeAntecedentefamiliarpordatomedico', 'alumnodatomedicoid', $datoMedico['AlumnoDatoMedicoId']);
            $dbm->removeManyRepositorio('CeAlumnodatomedico', 'alumnoid', $nalumno['AlumnoId']);

            if ($sistema == "LUX") {
                $dbm->removeManyRepositorio('CeAlumnodinamicafamiliar', 'alumnoid', $nalumno['AlumnoId']);
            }


            //datos del alumno
            $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $nalumno['AlumnoId']);

            $alumno->setFechaactualizacion(new \DateTime());

            if ($nalumno['Correo']) {
                $correo = new CeAlumnocorreo();
                $correo->setCorreo(mb_strtolower($nalumno['Correo'], 'utf-8'));
                $correo->setAlumnoid($alumno);
                $dbm->saveRepositorio($correo);
            }

            if ($nalumno['Telefono']) {
                $tel = new CeAlumnotelefono();
                $tel->setTelefono($nalumno['Telefono']);
                $tel->setAlumnoid($alumno);
                $tel->setTipotelefonoid(2);

                $dbm->saveRepositorio($tel);
            }

            if (!empty($nalumno['ViveConId'])) {
                $vivecon = $dbm->getRepositorioById('Vivecon', 'viveconid', $nalumno['ViveConId']);
                $alumno->setViveconid($vivecon);
            }

            //lugar de nacimiento
            if ($nalumno['PaisNacimiento']) {
                $lugarnacimiento = new CeAlumnolugarnacimiento();

                $pais = $dbm->getRepositorioById('Pais', 'paisid', $nalumno['PaisNacimiento']);
                $lugarnacimiento->setPaisid($pais);
                $lugarnacimiento->setAlumnoid($alumno);

                if ($nalumno['EstadoNacimiento']) {
                    $estado = $dbm->getRepositorioById('Estado', 'estadoid', $nalumno['EstadoNacimiento']);
                    $lugarnacimiento->setEstadoid($estado);
                }

                if ($nalumno['CiudadNacimiento']) {
                    $municipio = $dbm->getRepositorioById('Municipio', 'municipioid', $nalumno['CiudadNacimiento']);
                    $lugarnacimiento->setMunicipioid($municipio);
                }

                $dbm->saveRepositorio($lugarnacimiento);
            }

            //domicilio
            $domicilio = new CeAlumnodomicilio();

            $domicilio->setAlumnoid($alumno);
            $domicilio->setEsfiscal(0);
            $domicilio->setCalle(mb_strtoupper($nalumno["Calle"], 'utf-8'));
            $domicilio->setNumeroexterior(mb_strtoupper($nalumno["NumeroExterior"], 'utf-8'));
            $domicilio->setNumerointerior(mb_strtoupper($nalumno["NumeroInterior"], 'utf-8'));
            $domicilio->setColonia(mb_strtoupper($nalumno["Colonia"], 'utf-8'));
            $domicilio->setCodigoPostal(mb_strtoupper($nalumno["CodigoPostal"], 'utf-8'));
            $domicilio->setCiudad(strval($nalumno['CiudadId']));

            $dbm->saveRepositorio($domicilio);


            if ($actualizar['docilio'] == "true") {
                $claveid = $dbm->getRepositorioById('CeClavefamiliar', 'clave', $claveFamiliar);
                $hermano = $dbm->getRepositoriosById('CeAlumnoporclavefamiliar', 'clavefamiliarid', $claveid->getClavefamiliarid());


                foreach ($hermano as &$bro) {

                    if ($bro->getAlumnoid()->getAlumnoid() != $nalumno['AlumnoId']) {
                        $alumnoaux = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $bro->getAlumnoid()->getAlumnoid());
                        $dbm->removeManyRepositorio('CeAlumnodomicilio', 'alumnoid', $bro->getAlumnoid()->getAlumnoid());

                        $domicilio = new CeAlumnodomicilio();

                        $domicilio->setAlumnoid($alumnoaux);
                        $domicilio->setEsfiscal(0);
                        $domicilio->setCalle(mb_strtoupper($nalumno["Calle"], 'utf-8'));
                        $domicilio->setNumeroexterior(mb_strtoupper($nalumno["NumeroExterior"], 'utf-8'));
                        $domicilio->setNumerointerior(mb_strtoupper($nalumno["NumeroInterior"], 'utf-8'));
                        $domicilio->setColonia(mb_strtoupper($nalumno["Colonia"], 'utf-8'));
                        $domicilio->setCodigoPostal(mb_strtoupper($nalumno["CodigoPostal"], 'utf-8'));
                        $domicilio->setCiudad(strval($nalumno['CiudadId']));

                        $dbm->saveRepositorio($domicilio);
                    }
                }
            }

            if ($contactoseliminados) {
                foreach ($contactoseliminados as $eliminado) {
                    $contacto = $dbm->getRepositorioByid('CeContactoemergencia', 'contactoemergenciaid', $eliminado);
                    if ($contacto) {
                        $dbm->removeRepositorio($contacto);
                    }
                }
            }

            foreach ($contactosemergencia as $contacto) {
                if ($contacto['ContactoEmergenciaId']) {
                    $contactoModel = $dbm->getRepositorioByid('CeContactoemergencia', 'contactoemergenciaid', $contacto['ContactoEmergenciaId']);
                } else {
                    $contactoModel = new CeContactoemergencia();
                    $contactoModel->setAlumnoid($alumno);
                }
                $contactoModel->setNombre(mb_strtoupper($contacto['ContactoEmergenciaNombre'], 'utf-8'));
                if ($contacto['ContactoEmergenciaEmail'] || $contacto['ContactoEmergenciaEmail'] !== '') {
                    $contactoModel->setEmail($contacto['ContactoEmergenciaEmail']);
                } else {
                    $contactoModel->setEmail(null);
                }
                if ($contacto['ContactoEmergenciaParentesco']) {
                    $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $contacto['ContactoEmergenciaParentesco']);
                    $contactoModel->setParentescoId($parentesco);
                }
                $contactoModel->setTelefono(str_replace(')', '', str_replace('(', '', $contacto['ContactoEmergenciaLada'])) . '-' . str_replace('-', '', $contacto['ContactoEmergenciaTelefono']));
                $dbm->saveRepositorio($contactoModel);
            }

            if ($sistema == "LUX") {
                //dinamica familiar
                $dinamica = new CeAlumnodinamicafamiliar();

                $dinamica->setAlumnoid($alumno);
                $dinamica->setNinguna($dinamicaFamiliar['Ninguna']);
                $dinamica->setDivorcio($dinamicaFamiliar['Divorcio']);
                $dinamica->setSeparacion($dinamicaFamiliar['Separacion']);
                $dinamica->setCustodia($dinamicaFamiliar['Custodia']);
                $dinamica->setEnfermedadgrave($dinamicaFamiliar['EnfermedadGrave']);
                $dinamica->setMuertePerdida($dinamicaFamiliar['Muerte']);
                $dinamica->setCambioresidencia($dinamicaFamiliar['CambioResidencia']);
                $dinamica->setMedioshermanos($dinamicaFamiliar['MedioHermano']);
                $dinamica->setMadrepadresoltero($dinamicaFamiliar['MadrePadreSoltero']);
                $dinamica->setSegundosmatrimonios($dinamicaFamiliar['SegundoMatrimonio']);
                $dinamica->setOtros($dinamicaFamiliar['Otro']);

                if ($dinamicaFamiliar['ParentescoId'] && $dinamicaFamiliar['Custodia'] == 1) {
                    $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $dinamicaFamiliar['ParentescoId']);
                    $dinamica->setParentescoid($parentesco);
                }

                if ($dinamicaFamiliar['Otro'] == 1) {
                    $dinamica->setDescripcionOtros(mb_strtoupper($dinamicaFamiliar['EspecificacionOtro'], 'utf-8'));
                }

                if ($dinamicaFamiliar['Muerte'] == 1) {
                    $dinamica->setMiembromuerteperdida(mb_strtoupper($dinamicaFamiliar['EspecificacionMuertes'], 'utf-8'));
                }

                if ($dinamicaFamiliar['EnfermedadGrave'] == 1) {
                    $dinamica->setMiembroenfermedadgrave(mb_strtoupper($dinamicaFamiliar['EspecificacionEnfermedadGrave'], 'utf-8'));
                }

                $dbm->saveRepositorio($dinamica);

                //área médica
                $medico = new CeAlumnodatomedico();

                $medico->setAlumnoid($alumno);
                // $medico->setContactoemergencianombre(mb_strtoupper($datoMedico['ContactoEmergenciaNombre'], 'utf-8'));
                // $medico->setContactoemergenciatelefono($datoMedico['ContactoEmergenciaTelefono']);

                // if($datoMedico['ContactoEmergenciaParentesco'] )
                // {
                //     $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', $datoMedico['ContactoEmergenciaParentesco']);
                //     $medico->setContactoemergenciaparentesco($parentesco); 
                // }

                $medico->setEnfermedadcronica($datoMedico['EnfermedadCronica']);

                if ($datoMedico['EnfermedadCronica'] == "SI") {
                    $medico->setPadeceenfermedadcuidanombre(mb_strtoupper($datoMedico['PadeceEnfermedadCuidaNombre'], 'utf-8'));
                    $medico->setPadeceenfermedadcuidatelefono($datoMedico['PadeceEnfermedadTelefono']);
                    $medico->setPadeceenfermedadcuidadescripcion(mb_strtoupper($datoMedico['PadeceEnfermedadDescripcion'], 'utf-8'));
                }

                $medico->setExamenauditivo($datoMedico['ExamenAuditivo']);
                $medico->setAparatoauditivo($datoMedico['AparatoAuditivo']);
                $medico->setExamenortopedicos($datoMedico['ExamenOrtopedico']);
                $medico->setAditamentoortopedico($datoMedico['AditamentoOrtopedico']);
                $medico->setExamenvista($datoMedico['ExamenVista']);
                $medico->setLentes($datoMedico['Lentes']);
                $medico->setPeso($datoMedico['Peso']);
                $medico->setTalla($datoMedico['Talla']);
                $medico->setAutorizoantihistaminico($datoMedico['AutorizoAntihistaminico']);
                $medico->setNombreautoriza(mb_strtoupper($datoMedico['NombreAutoriza'], 'utf-8'));

                $medico->setOtraalergia(mb_strtoupper($datoMedico['AlergicoDescripcion'], 'utf-8'));
                $medico->setDescripcionantecedenteimportante(mb_strtoupper($datoMedico['AntecedenteFamiliarDescripcion'], 'utf-8'));

                if ($datoMedico['TipoSangineo']) {
                    $tiposanguineo = $dbm->getRepositorioById('Tiposanguineo', 'tiposanguineoid', $datoMedico['TipoSangineo']);
                    $medico->setTiposangineo($tiposanguineo);
                }

                $dbm->saveRepositorio($medico);

                foreach ($alergia as &$ale) {
                    if ($ale['Seleccionado'] == 'true') {
                        $alergiadato = new CeAlergiapordatomedico();
                        $alergiadato->setAlumnodatomedicoid($medico);

                        $alergiaaux = $dbm->getRepositorioById('Alergia', 'alergiaid', $ale['alergiaid']);
                        $alergiadato->setAlergiaid($alergiaaux);

                        $dbm->saveRepositorio($alergiadato);
                    }
                }

                foreach ($antecedenteImportante as &$ant) {
                    if ($ant['Seleccionado'] == 'true') {
                        $antecedente = new CeAntecedentefamiliarpordatomedico();
                        $antecedente->setAlumnodatomedicoid($medico);

                        $antecedenteaux = $dbm->getRepositorioById('Antecedentefamiliarimportante', 'antecedentefamiliarimportanteid', $ant['antecedentefamiliarimportanteid']);
                        $antecedente->setAntecedentefamiliarimportanteid($antecedenteaux);

                        $dbm->saveRepositorio($antecedente);
                    }
                }
            } else if ($sistema == "Ciencias") {
                //área médica
                $medico = new CeAlumnodatomedico();

                $medico->setAlumnoid($alumno);
                // $medico->setContactoemergencianombre(mb_strtoupper($datoMedico['ContactoEmergenciaNombre'], 'utf-8'));
                // $medico->setContactoemergenciatelefono($datoMedico['ContactoEmergenciaTelefono']);

                if ($datoMedico['Padece'] == "SI") {
                    $medico->setPadece(mb_strtoupper($datoMedico['PadeceEnfermedadDescripcion'], 'utf-8'));
                } else {
                    $medico->setPadece(null);
                }

                if ($datoMedico['Alergico'] == "SI") {
                    $medico->setAlergico(mb_strtoupper($datoMedico['AlergicoDescripcion'], 'utf-8'));
                } else {
                    $medico->setAlergico(null);
                }

                if ($datoMedico['TomaMedicamento'] == "SI") {
                    $medico->setAntecedenteFamiliar(mb_strtoupper($datoMedico['TomaMedicamentoDescripcion'], 'utf-8'));
                } else {
                    $medico->setAntecedenteFamiliar(null);
                }

                $medico->setPeso($datoMedico['Peso']);
                $medico->setTalla($datoMedico['Talla']);


                $dbm->saveRepositorio($medico);
            }

            //personas autorizadas para recoger
            if ($actualizar['recoger'] == "true") {
                $claveid = $dbm->getRepositorioById('CeClavefamiliar', 'clave', $claveFamiliar);
                $hermano = $dbm->getRepositoriosById('CeAlumnoporclavefamiliar', 'clavefamiliarid', $claveid->getClavefamiliarid());


                foreach ($hermano as &$bro) {

                    if ($bro->getAlumnoid()->getAlumnoid() != $nalumno['AlumnoId']) {
                        $alumnoaux = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $bro->getAlumnoid()->getAlumnoid());
                        $dbm->removeManyRepositorio('CePersonaautorizadarecogerporalumno', 'alumnoid', $bro->getAlumnoid()->getAlumnoid());

                        foreach ($recoger as &$rec) {
                            $recogeraux = $dbm->getRepositorioById('CePersonaautorizadarecoger', 'personaautorizadarecogerid', $rec['PersonaAutorizadaRecogerId']);

                            $personaRecogerAlumno = new CePersonaautorizadarecogerporalumno();
                            $personaRecogerAlumno->setAlumnoid($alumnoaux);
                            $personaRecogerAlumno->setPersonaautorizadarecogerid($recogeraux);

                            $dbm->saveRepositorio($personaRecogerAlumno);
                        }
                    }
                }
            }


            //fin
            $dbm->saveRepositorio($alumno);
            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha actualizado el registro."), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reotorna los catálogos utilizados en la actulización de datos del alumno
     * @Rest\Get("/api/portalfamiliar/LUX/CatalogosDatosAlumno/{id}", name="PPGetCatalogosDatosAlumnoLUX")
     */
    public function GetCatalogosDatosAlumno($id)
    {
        try {
            $dbm = $this->get("db_manager");

            //datos del alumno
            $viveCon = $dbm->getRepositorios('Vivecon');

            //lugar de nacimiento     
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT Nombre AS nombre, PaisId AS paisid, Activo FROM pais ORDER BY Nombre ASC');
            $stmt->execute();
            $pais = $stmt->fetchAll();

            //$pais = $dbm->getRepositorios('Pais');

            //domicilio
            $estado = $dbm->getRepositoriosById('Estado', 'paisid', 484, 'nombre');

            //padres o tutores
            $tutor = $dbm->getRepositorios('Tutor');
            $SituacionConyugal = $dbm->getRepositorios('Situacionconyugal');
            $escolaridad = $dbm->getRepositorios('Escolaridad');
            $generacion = $dbm->getRepositorios('Generacion');
            $nacionalidad = $dbm->getRepositoriosById('Nacionalidad', 'activo', 1, 'nombre');

            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT Nombre AS nombre, GeneracionId AS generacionid FROM generacion ORDER BY Nombre DESC');
            $stmt->execute();
            $generacion = $stmt->fetchAll();

            //personas autorizadas para recoger
            $parentesco = $dbm->getRepositorios('Parentesco');

            //Datos Médicos
            $tipoSanguineo = $dbm->getRepositorios('Tiposanguineo');
            $alergia = $dbm->getRepositorios('Alergia');
            $antecedente = $dbm->getRepositorios('Antecedentefamiliarimportante');

            //-------------------- datos del alumno ------------
            $dbm = $this->get("db_manager");

            $conn = $this->get("db_manager")->getConnection();
            $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $stmt = $conn->prepare('SELECT av.*,cpn.fechainicios2 FROM ce_ppdatosalumnovista av
            left join ciclo c on c.actual = 1
            left join ce_ciclopornivel cpn on cpn.nivelid = av.nivelid and cpn.cicloid = c.cicloid
            where av.AlumnoId = :id;');
            $stmt->execute(array('id' => $id));
            $alumnodatos = $stmt->fetchAll();
            $alumno = $dbmce->BuscarAlumnosA(array('alumnoid' => $id));

            $dinamicaFamiliar = $dbm->getRepositoriosById('CeAlumnodinamicafamiliar', 'alumnoid', $id);
            $datoMedico = $dbm->getRepositoriosById('CeAlumnodatomedico', 'alumnoid', $id);
            $contactoEmergencias =  $dbm->getRepositoriosById('CeContactoemergencia', 'alumnoid', $id);

            if ($datoMedico) {
                $alergiaDatoMedico = $dbm->getRepositoriosById('CeAlergiapordatomedico', 'alumnodatomedicoid', $datoMedico[0]->getAlumnodatomedicoid());
                $antecedenteDatoMedico = $dbm->getRepositoriosById('CeAntecedentefamiliarpordatomedico', 'alumnodatomedicoid', $datoMedico[0]->getAlumnodatomedicoid());
            }


            $return = array(
                'vivecon' => $viveCon,

                'pais' => $pais,

                'estado' => $estado,

                "parentesco" => $parentesco,

                "nacionalidad" => $nacionalidad,
                'tutor' => $tutor,
                "situacionConyugal" => $SituacionConyugal,
                "escolaridad" => $escolaridad,
                'generacion' => $generacion,

                'tipoSanguineo' => $tipoSanguineo,
                'alergia' => $alergia,
                'antecedenteMedico' => $antecedente,
                'contactoemergencia' =>  $contactoEmergencias,

                'alumno' => $alumno,
                'alumnodatos' => $alumnodatos,
                'dinamicaFamiliar' => $dinamicaFamiliar,
                'datoMedico' => $datoMedico,
                'alergiaDatoMedico' => $alergiaDatoMedico,
                'antecedenteDatoMedico' => $antecedenteDatoMedico
            );

            return new View($return, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reotorna los catálogos utilizados en la actulización de datos del alumno
     * @Rest\Get("/api/portalfamiliar/Ciencias/CatalogosDatosAlumno/{id}", name="PPGetCatalogosDatosAlumnoCiencias")
     */
    public function GetCatalogosDatosAlumnoCiencias($id)
    {
        try {
            $dbm = $this->get("db_manager");

            //datos del alumno
            $viveCon = $dbm->getRepositorios('Vivecon');

            //lugar de nacimiento     
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT Nombre AS nombre, PaisId AS paisid, Activo FROM pais ORDER BY Nombre ASC');
            $stmt->execute();
            $pais = $stmt->fetchAll();


            //domicilio
            $estado = $dbm->getRepositoriosById('Estado', 'paisid', 484, 'nombre');

            //padres o tutores
            $tutor = $dbm->getRepositorios('Tutor');
            $SituacionConyugal = $dbm->getRepositorios('Situacionconyugal');
            $escolaridad = $dbm->getRepositorios('Escolaridad');
            $generacion = $dbm->getRepositorios('Generacion');
            $nacionalidad = $dbm->getRepositoriosById('Nacionalidad', 'activo', 1, 'nombre');

            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT Nombre AS nombre, GeneracionId AS generacionid FROM generacion ORDER BY Nombre DESC');
            $stmt->execute();
            $generacion = $stmt->fetchAll();

            //personas autorizadas para recoger
            $parentesco = $dbm->getRepositorios('Parentesco');


            //-------------------- datos del alumno ------------
            $dbm = $this->get("db_manager");

            $conn = $this->get("db_manager")->getConnection();
            $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $stmt = $conn->prepare("SELECT av.*,cpn.fechainicios2 FROM ce_ppdatosalumnovista av
            left join ciclo c on c.actual = 1
            left join ce_ciclopornivel cpn on cpn.nivelid = av.nivelid and cpn.cicloid = c.cicloid
            where av.AlumnoId = :id;");
            $stmt->execute(array('id' => $id));
            $alumnodatos = $stmt->fetchAll();
            $alumno = $dbmce->BuscarAlumnosA(array('alumnoid' => $id));

            $datoMedico = $dbm->getRepositoriosById('CeAlumnodatomedico', 'alumnoid', $id);
            $contactoEmergencias =  $dbm->getRepositoriosById('CeContactoemergencia', 'alumnoid', $id);

            $return = array(
                'vivecon' => $viveCon,

                'pais' => $pais,

                'estado' => $estado,

                "parentesco" => $parentesco,

                "nacionalidad" => $nacionalidad,
                'tutor' => $tutor,
                "situacionConyugal" => $SituacionConyugal,
                "escolaridad" => $escolaridad,
                'generacion' => $generacion,
                'alumnodatos' => $alumnodatos,
                'alumno' => $alumno,
                'datoMedico' => $datoMedico,
                'contactoemergencia' => $contactoEmergencias
            );

            return new View($return, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/portalfamiliar/PersonasAutorizadasRecogerAlumno/{id}", name="PPGetPersonasAutorizadasRecogerAlumno")
     */
    public function GetPersonasAutorizadasRecogerAlumno($id)
    {
        try {
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT * FROM ce_pppersonasrecogeralumnovista WHERE AlumnoId = :id');
            $stmt->execute(array('id' => $id));
            $result = $stmt->fetchAll();
            return new View($result, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/portalfamiliar/Hermano/{id}", name="PPGetHermanoAlumno")
     */
    public function GetHermanoAlumno($id)
    {
        try {
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT * FROM ce_pphermanoalumnovista WHERE AlumnoId = :id');
            $stmt->execute(array('id' => $id));
            $result = $stmt->fetchAll();
            return new View($result, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/portalfamiliar/PadresOTutoresAlumno/{clave}", name="PPGetPadresOTutoresAlumno")
     */
    public function GetPadresOTutoresAlumno($clave)
    {
        try {
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT * FROM ce_pppadretutoralumnovista WHERE Clave = :clave');
            $stmt->execute(array('clave' => $clave));
            $result = $stmt->fetchAll();

            foreach ($result as &$tutor) {
                $tutor['TutorId'] = intval($tutor['TutorId']);
                $tutor['SituacionConyugalId'] = intval($tutor['SituacionConyugalId']);
                $tutor['NivelEstudioId'] = intval($tutor['NivelEstudioId']);

                $stmt = $conn->prepare('SELECT PadresOTutoresId, NacionalidadId FROM ce_padresotutoresnacionalidad WHERE PadresOTutoresId = :id');
                $stmt->execute(array('id' => $tutor['PadresOTutoresId']));
                $tutor['Nacionalidad'] = $stmt->fetchAll();

                foreach ($tutor['Nacionalidad']  as &$nac) {
                    $nac = intval($nac['NacionalidadId']);
                }
            }


            return new View($result, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene la foto del alumno
     * @Rest\Get("/api/Controlescolar/Alumno/Fotos/{id}", name="CEAAlumnoFotos")
     */
    public function CEAAlumnoFotos($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $fotos = $dbm->getFotosAlumnos($id);
            return new View($fotos, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     *  Guarda los datos de custodia del alumno
     * @Rest\Post("/api/Controlescolar/Alumno/Custodia/{alumnoid}", name="GuardarCustodia")
     */
    public function GuardarCustodia($alumnoid)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumno = $dbm->getRepositorioById("CeAlumno", "alumnoid", $alumnoid);
            $alumno->setCustodiapersona($decoded["custodia"] == 1 ? $decoded["custodiapersona"] : null);
            $alumno->setCustodiaoficio($decoded["custodia"] == 1 ? $decoded["custodiaoficio"] : null);
            $dbm->saveRepositorio($alumno);

            return new View("Se guardo la custodia.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene los alumnos de acuerdo a los filtros
     * @Rest\Get("/api/Controlescolar/Alumno/", name="CEAAlumno")
     */
    public function CEAlumno()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos); //matricula, nombre, apellidopaterno, apellidomaterno, alumnoestatusid, tipobajaid, motivobajaid, nivelid, gradoid, grupoid, intercambio
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $alumno = $dbm->GetAlumno($filtros);

            return new View($alumno, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna los examenes de banco de reactivos por alumno
     * @Rest\Get("/api/Alumno/Examenes/{id}", name="getAlumnoExamenBancoReactivos")
     */
    public function getAlumnoExamenBancoReactivos($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->GetExamenesAlumno($id);
            if (!$entidad) {
                return new View("No se han encontrado exámenes relacionados al alumno", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna los periodos de evaluacion por alumno
     * @Rest\Get("/api/Alumno/Periodosevaluacion/", name="getPeriodosevaluacionbyalumno")
     */
    public function getPeriodosevaluacionbyalumno()
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->GetPeriodosevaluacionbyAlumno($datos);
            $criterios = $dbm->getByParametersRepositorios(
                'CeCriterioevaluaciongrupo',
                ['configurarexamen' => 1]
            );
            if (!$entidad) {
                return new View("No se han encontrado periodos de evaluación relacionados al ciclo y grado", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View(["periodos" => $entidad, "criterios" => $criterios], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
