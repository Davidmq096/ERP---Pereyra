<?php

namespace AppBundle\Controller\Admisiones\ModalSolicitud;

use AppBundle\DB\DbmAdmisiones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: javier
 */
class DatoAspiranteController extends FOSRestController
{
    /**
     * Reotorna valores iniciales de datos de aspirante (primera pestana ERP)
     * @Rest\Get("/api/Solicitud/datosAspirante/{id}", name="datosAspiranteModal")
     */
    public function getdatosAspiranteModal($id)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

        //----Info Aspirante
        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $id);
        $nacionalidades = $dbm->getRepositoriosById('Nacionalidadpordatoaspirante', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());

        //----Select
        $viveCon = $dbm->getRepositoriosById('Vivecon', 'activo', 1);
        $nacionalidad = $dbm->getRepositoriosById('Nacionalidad', 'activo', 1);
        if ($SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid()) {
            $vivienda = $SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid();
            $pais = $dbm->getRepositoriosById('Pais', 'paisid', $vivienda->getEstadoid()->getPaisid()->getPaisid());
            $estado = $dbm->getRepositoriosById('Estado', 'estadoid', $vivienda->getEstadoid()->getEstadoid());
            $municipio = $dbm->getRepositoriosById('Municipio', 'municipioid', $vivienda->getMunicipioid());
        }

        $ciclo = $dbm->getRepositorioById('Solicitudadmisionporciclo', 'solicitudadmisionid', $SolicitudEntity->getSolicitudadmisionid())->getCicloid();
        $cupo = $dbm->getByParametersRepositorios("Cupoadmision", array("gradoid" => $SolicitudEntity->getGradoid()->getGradoid(), "cicloid" => $ciclo->getCicloid()));

        $return = array("solicitud" => $SolicitudEntity,
            "nacionalidades" => $nacionalidades,
            "nacionalidad" => $nacionalidad,
            "pais" => $pais,
            "estados" => $estado,
            "municipios" => $municipio,
            "viveCon" => $viveCon,
            "fechanivel" => $cupo ? $cupo[0]->getFechaedad() : null);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * Funcion para guardar los datos de aspirante (primera pestana ERP)
     * @Rest\Post("/api/Solicitud/datosAspirante/validacionDatos", name="DatosAspiranteSaveValidacionDatos")
     */
    public function saveDatosAspiranteValidacion()
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);            

            $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
            if (empty($SolicitudEntity)) {
                return new View("Error no se encuntra ninguna solicitud con el id " . $data['solicitudadmisionid'], Response::HTTP_NOT_FOUND);
            }

            $Aspirante = $SolicitudEntity->getDatoaspiranteid();
            if ($Aspirante->getExtranjero()) {
                $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $SolicitudEntity->getSolicitudadmisionid()))->getCicloid();
                $Curp = $dbm->getSolicitudExistByCURP($data["datosgenerales"]['curp'], $ciclo->getCicloid(), $SolicitudEntity->getGradoid()->getGradoid(), $data['solicitudadmisionid']);
                if ($Curp) {                    
                    return new View("Error ya existe el CURP", Response::HTTP_PARTIAL_CONTENT);
                }
            }

            $dbm->getConnection()->beginTransaction();
            $SolicitudEntity->setCorreo($data["contacto"]["email"]);

            
            //Datos generales
            $datosgenerales = $data["datosgenerales"];
            $Aspirante->setNombre($datosgenerales["nombre"]);
            $Aspirante->setApellidopaterno($datosgenerales["apellidopaterno"]);
            $Aspirante->setApellidomaterno($datosgenerales["apellidomaterno"]);
            $Aspirante->setCurp($datosgenerales["curp"]);
            $Aspirante->setSexo($datosgenerales["sexo"]);
            //Lugar y fecha de nacimiento
            $nacimiento = $data["fechalugarnacimiento"];
            $Aspirante->setFechanacimiento(new \DateTime($nacimiento["fecha"]));
            $Aspirante->setEdadanos($nacimiento["anos"]);
            $Aspirante->setEdadmes($nacimiento["meses"]);
            $Aspirante->setPromedioactual($nacimiento["promedio"]);
            //Escuela procedencia (solo lux)
            $procedencia = $data["escuelaprocedencia"];
            $Aspirante->setNombreescuelaprocedencia($procedencia["nombre"]);
            $Aspirante->setCiudadescuelaprocedencia($procedencia["ciudad"]);
            $dbm->saveRepositorio($Aspirante);

            //Informacion del contacto
            $contacto = $data["contacto"];
            $Contacto = $SolicitudEntity->getContactoid();
            $Contacto->setNombre($contacto["nombre"]);
            $Contacto->setCorreo($contacto["email"]);
            $Contacto->setCelular($contacto["celular"]);
            $Contacto->setTelefono($contacto["telefono"]);
            $dbm->saveRepositorio($Contacto);

            //Nacionalidad eliminamos si ya tenia, y agregamos
            $dbm->removeManyRepositorio("Nacionalidadpordatoaspirante", "datoaspiranteid", $SolicitudEntity->getDatoaspiranteid());
            $SolicitudEntity->getDatoaspiranteid()->setExtranjero(0);
            foreach ($data['nacionalidad'] as $n) {
                if ($n == 112) {
                    $SolicitudEntity->getDatoaspiranteid()->setExtranjero(1);
                }
                $NxA = new \AppBundle\Entity\Nacionalidadpordatoaspirante();
                $NxA->setNacionalidad($dbm->getRepositorioById('Nacionalidad', 'nacionalidadid', $n));
                $NxA->setDatoaspiranteid($Aspirante);
                $dbm->saveRepositorio($NxA);
            }
            $dbm->saveRepositorio($SolicitudEntity);
            $dbm->getConnection()->commit();
            return new View("Se han guardado los datos.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View("No se pudo guardar el registro " . $e, Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * Reotorna valores iniciales de datos de aspirante (Portal admisiones)
     * @Rest\Get("/api/Familiar/datosAspirante", name="datosAspirante")
     */
    public function getdatosAspirante()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $datos = $_REQUEST;
        $data = array_filter($datos);
        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        $nacionalidades = null;
        if (!empty($SolicitudEntity->getPendiente())) {
            $nacionalidades = $dbm->getRepositoriosById('Nacionalidadpordatoaspirante', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());
        }

        if ($SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid()) {
            $pais = array(
                "id" => $SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid()->getEstadoid()->getPaisid()->getPaisid(),
                "nombre" => $SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid()->getEstadoid()->getPaisid()->getNombre(),
            );
            $estado = array(
                "id" => $SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid()->getEstadoid()->getEstadoid(),
                "nombre" => $SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid()->getEstadoid()->getNombre(),
            );
            $mun = array(
                "id" => $SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid()->getMunicipioid(),
                "nombre" => $SolicitudEntity->getDatoaspiranteid()->getMunicipioviviendaid()->getNombre(),
            );
        }
        $pais = $dbm->getRepositorios('Pais');
        $estado = $dbm->getTodosEStados();
        $mun = $dbm->getTodosMunicipios();
        $nacionalidad = $dbm->getRepositoriosById('Nacionalidad', 'activo', 1);

        $viveCon = $dbm->getRepositorios('Vivecon');

        $PxS = $dbm->getRepositorioById('Paisadmisionextranjero', 'solicitudadmisionid', $SolicitudEntity->getSolicitudadmisionid());

        $ciclo = $dbm->getRepositorioById('Solicitudadmisionporciclo', 'solicitudadmisionid', $SolicitudEntity->getSolicitudadmisionid())->getCicloid();
        $cupo = $dbm->getByParametersRepositorios("Cupoadmision", array("gradoid" => $SolicitudEntity->getGradoid()->getGradoid(), "cicloid" => $ciclo->getCicloid()));
        $totalCupo = $dbm->getNumeroDeSolicitudesValidades($SolicitudEntity->getGradoid()->getGradoid(), $ciclo->getCicloid());

        $msjCupoVal = false;
        $msjCupo = 'Ha superado el número de solicitudes validadas para ' . $SolicitudEntity->getGradoid()->getGrado() . ' de ' . $SolicitudEntity->getGradoid()->getNivelid()->getNombre() . '. La solicitud puede ser editada, pero al finalizar será enviada a la lista de espera.';

        if (empty($cupo)) {
            return new View("No se ha configurado el cupo.", Response::HTTP_PARTIAL_CONTENT);
        }

        if (empty($totalCupo)) {
            $totalCupo = 0;
        }

        if ($SolicitudEntity->getEstatussolicitudid()->getEstatussolicitudid() < 3) {
            if ($cupo[0]->getCantidadfichas() > (int) $totalCupo) {
                $msjCupoVal = false;
            } else {
                $msjCupoVal = true;
            }
        }

        $return = array("solicitud" => $SolicitudEntity,
            "nacionalidades" => $nacionalidades,
            "pais" => $pais,
            "nacionalidad" => $nacionalidad,
            "estados" => $estado,
            "municipios" => $mun,
            "viveCon" => $viveCon, 'PaisSolicitud' => $PxS, 'msjCupoVal' => $msjCupoVal, 'msjCupo' => $msjCupo);
        return new View($return, Response::HTTP_OK);
    }

    /**
     * Funcion para guardar los datos de aspirante (Portal admisiones)
     * @Rest\Post("/api/Familiar/datosAspirante", name="DatosAspiranteSave")
     */
    public function saveDatosAspirante()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $data = $_REQUEST;


        $SolicitudEntity = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $data['solicitudadmisionid']);
        if (empty($SolicitudEntity)) {
            return new View("Error no se encuntra ninguna solicitud con el id " . $data['solicitudadmisionid'], Response::HTTP_NOT_FOUND);
        }

        if ($data['nacional'] == '1') {
            $ciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $SolicitudEntity->getSolicitudadmisionid()))->getCicloid();
            $Curp = $dbm->getSolicitudExistByCURP(
                $data['curp'], 
                $ciclo->getCicloid(), 
                $SolicitudEntity->getGradoid()->getGradoid(),
                $data['solicitudadmisionid']
            );
            if ($Curp) {
                if($SolicitudEntity->getEstatussolicitudid()->getEstatussolicitudid() == 1){
                    $this->DeleteSolocitud($SolicitudEntity);
                }
                return new View("Error ya existe el CURP", Response::HTTP_PARTIAL_CONTENT);
            }
        }
        $dbm->getConnection()->beginTransaction();

        $Aspirante = $SolicitudEntity->getDatoaspiranteid();
        $Aspirante->setNombre((empty($data['nombre'])) ? null : $data['nombre']);
        $Aspirante->setApellidopaterno((empty($data['apellidopaterno'])) ? null : $data['apellidopaterno']);
        $Aspirante->setApellidomaterno((empty($data['apellidomaterno'])) ? null : $data['apellidomaterno']);
        $Aspirante->setCurp((empty($data['curp'])) ? null : $data['curp']);
        $Aspirante->setSexo((empty($data['sexo'])) ? null : $data['sexo']);

        //Lugar y fecha de nacimiento
        $MunicipioEntity = $dbm->getRepositorioById('Municipio', 'municipioid', (empty($data['municipio'])) ? null : $data['municipio']);
        $Aspirante->setMunicipionacimientoid($MunicipioEntity);
        $Aspirante->setFechanacimiento(new \DateTime((empty($data['fechaN'])) ? null : $data['fechaN']));
        $Aspirante->setEdadanos((empty($data['anos'])) ? 0 : $data['anos']);
        $Aspirante->setEdadmes((empty($data['meses'])) ? 0 : $data['meses']);

        $viveConEntity = $dbm->getRepositorioById('Vivecon', 'viveconid', (empty($data['viveCon'])) ? null : $data['viveCon']);
        $Aspirante->setViveconid($viveConEntity);
        $Aspirante->setCelular((empty($data['tel'])) ? null : $data['tel']);
        $Aspirante->setEmail((empty($data['email'])) ? null : $data['email']);

        $Aspirante->setGradosextrangero((empty($data['estudiadoExtr'])) ? 0 : $data['estudiadoExtr']);
        $Aspirante->setLugargradosextranger((empty($data['textEstudiadoExtr'])) ? null : $data['textEstudiadoExtr']);
        //Escuela de procedencia
        $Aspirante->setNombreescuelaprocedencia((empty($data['nombreEscuela'])) ? null : $data['nombreEscuela']);
        $Aspirante->setCiudadescuelaprocedencia((empty($data['ciudadEscuela'])) ? null : $data['ciudadEscuela']);
        //Datos Medicos (informacion adicional)
        //$dbm->saveRepositorio($Aspirante);
        //Datos de contacto
        $Contacto = $SolicitudEntity->getContactoid();

        $Contacto->setNombre((empty($data['nombreC'])) ? null : $data['nombreC']);
        $Contacto->setCorreo((empty($data['emailC'])) ? null : $data['emailC']);
        $Contacto->setCelular((empty($data['celC'])) ? null : $data['celC']);
        $Contacto->setTelefono((empty($data['telC'])) ? null : $data['telC']);

        $dbm->saveRepositorio($Contacto);

        //Nacionalidad agregamos
        $nacionalidades = $dbm->getRepositoriosById('Nacionalidadpordatoaspirante', 'datoaspiranteid', $SolicitudEntity->getDatoaspiranteid());
        foreach ($nacionalidades as $n) {
            $dbm->removeRepositorio($n);
        }

        $SolicitudEntity->getDatoaspiranteid()->setExtranjero(0);
        if (!empty($data['nacionalidad'])) {
            $arrayNacionalidad = ($data['nacionalidad']);
            foreach ($arrayNacionalidad as $val) {
                if ($val != "") {
                    if ($val == 112) {
                        $SolicitudEntity->getDatoaspiranteid()->setExtranjero(1);
                    }
                    $nacionalidad = $dbm->getRepositorioById('Nacionalidad', 'nacionalidadid', $val);
                    $NxA = new \AppBundle\Entity\Nacionalidadpordatoaspirante();
                    $NxA->setNacionalidad($nacionalidad);
                    $NxA->setDatoaspiranteid($Aspirante);
                    $dbm->saveRepositorio($NxA);
                }
            }
        }

        if (!$SolicitudEntity->getDatoaspiranteid()->getExtranjero()) {
            if (!empty($data['pais'])) {
                $PxS = $dbm->getRepositorioById('Paisadmisionextranjero', 'solicitudadmisionid', $SolicitudEntity->getSolicitudadmisionid());
                $P = $dbm->getRepositorioById('Pais', 'paisid', $data['pais']);
                if ($PxS) {
                    $PxS->setPaisid($P);
                    $PxS->setSolicitudadmisionid($SolicitudEntity);
                } else {
                    $PxS = new \AppBundle\Entity\Paisadmisionextranjero();
                    $PxS->setPaisid($P);
                    $PxS->setSolicitudadmisionid($SolicitudEntity);
                }

                $dbm->saveRepositorio($PxS);
            }
        }

        //Actualizamos paso
        if ($SolicitudEntity->getPendiente() <= 2) {
            $SolicitudEntity->setPendiente(3);
        }
        $dbm->saveRepositorio($SolicitudEntity);
        $dbm->getConnection()->commit();
        $return = array("solicitud" => $SolicitudEntity);
        return new View($return, Response::HTTP_OK);
    }

    public function DeleteSolocitud($Solicitud)
    {
        try {
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $dbm->removeManyRepositorio('Solicitudadmisionporciclo', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid());
            $dbm->removeManyRepositorio('Documentoporsolicitudadmision', 'solicitudadmision', $Solicitud->getSolicitudadmisionid());
            //$dbm->removeManyRepositorio('Evaluacionporsolicitudadmision', 'solicitudadmisionid', $Solicitud->getSolicitudadmisionid());
            $dbm->removeRepositorio($Solicitud);

            $DatoAspirante = $Solicitud->getDatoaspiranteid();
            if ($DatoAspirante) {
                $Dinamica = $DatoAspirante->getDinamicafamiliarid();
                $dbm->removeManyRepositorio('Datomedico', 'datosaspiranteid', $DatoAspirante->getDatoaspiranteid());
                $dbm->removeManyRepositorio('Nacionalidadpordatoaspirante', 'datoaspiranteid', $DatoAspirante->getDatoaspiranteid());
                $dbm->removeManyRepositorio('Datoaspirante', 'datoaspiranteid', $DatoAspirante->getDatoaspiranteid());
                $dbm->removeManyRepositorio('Dinamicafamiliar', 'dinamicafamiliarid', $Dinamica->getDinamicafamiliarid());
            }
            $dbm->removeManyRepositorio('Contacto', 'contactoid', $Solicitud->getContactoid()->getContactoid());
            $dbm->removeManyRepositorio('Infoadicional', 'infoadicionalid', $Solicitud->getInfoadicionalid()->getInfoadicionalid());
            $dbm->removeManyRepositorio('Encuesta', 'encuestaid', $Solicitud->getEncuestaid()->getEncuestaid());
            $Encuesta = $Solicitud->getEncuestaid();

            $dbm->getConnection()->commit();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}
