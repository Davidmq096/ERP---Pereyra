<?php

namespace AppBundle\Controller\Becas\Modal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use AppBundle\Entity\BcEgresomensuales;
use AppBundle\Entity\BcCuentabanco;
use AppBundle\Entity\BcIngresoslux;
use AppBundle\Entity\BcSituacionfamiliar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Mariano
 */
class SituacionEconomicaController extends FOSRestController
{

    /** (Solo lux) Obtiene los ingresos por cada padre agregado
     * @Rest\Get("/api/Becas/SolicitudBeca/SituacionEconomica/EgresosMensuales/{id}" , name="obtenerEgresonMensuales")
     */
    public function obtenerEgresonMensuales($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $egresomensual = $dbm->getRepositoriosById('BcEgresomensuales', 'solicitudbecaid', $id);
            $resultado = [];
            foreach ($egresomensual as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudbecaid(null);
                }

                array_push($resultado, $valor);
            }
            return new View(array("egresomensual" => $resultado), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el resultado que coincida con el ID enviado de Ingresos Familiares
     * @Rest\Get("/api/Becas/SolicitudBeca/SituacionEconomica/ObtenerSituacionEconomica/{id}", name="ObtenerSituacionEconomica")
     */
    public function ObtenerSituacionEconomica($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $portal = $_REQUEST["portal"];
            $escuela = $_REQUEST["escuela"];
            $solicitudbeca = $dbm->getRepositorioById('BcSolicitudbeca', 'solicitudid', $id);

            $vehiculos = $dbm->getByParametersRepositorios('BcVehiculos', array('solicitudid' => $id, 'portal' => $portal));
            $deudascreditos = $dbm->getByParametersRepositorios('BcDeudascreditos', array('solicitudid' => $id, 'portal' => $portal));
            $situacionfamiliar = $dbm->getRepositoriosById('BcSituacionfamiliar', 'solicitudid', $id);
            $propiedadesfamiliares = $dbm->getByParametersRepositorios('BcPropiedadesfamiliares', array('solicitudid' => $id, 'portal' => $portal));
            $cuentabanco = $dbm->getByParametersRepositorios('BcCuentabanco', array('solicitudbecaid' => $id, 'portal' => $portal));
            $egresomensual = $dbm->getRepositoriosById('BcEgresomensuales', 'solicitudbecaid', $id);
            $estatuspropiedad = $dbm->getRepositorios('BcEstatuspropiedad');
            $tipocredito = $dbm->getRepositorios('BcTipocredito');
            $estatusvehiculo = $dbm->getRepositorios('BcEstatusvehiculos');
            $tipocuentabanco = $dbm->getRepositorios('BcTipocuentabanco');
            $estatusfamilia = $dbm->getRepositorios('BcEstatusfamilia');

            if ($escuela == 1) {
                $ingresofamiliar = $dbm->getRepositoriosById("BcPadresotutores", "solicitudid", $id);
                foreach ($ingresofamiliar as $familiar) {
                    $familiar->setSolicitudid(null);
                    $familiar->setSituacionconyugalid(null);
                }
            } else {
                $ingresofamiliar = $dbm->getRepositorioById('BcIngresosfamiliares', 'solicitudid', $id);
                if (!empty($ingresofamiliar)) {
                    $ingresofamiliar->setSolicitudid(null);
                }
            }

            $resultadovehiculos = [];
            foreach ($vehiculos as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudid(null);
                }

                array_push($resultadovehiculos, $valor);
            }

            $resultadodeudascreditos = [];
            foreach ($deudascreditos as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudid(null);
                }

                array_push($resultadodeudascreditos, $valor);
            }

            $resultadosituacionfamiliar = [];
            foreach ($situacionfamiliar as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudid(null);
                }

                array_push($resultadosituacionfamiliar, $valor);
            }

            $resultadopropiedadesfamiliares = [];
            foreach ($propiedadesfamiliares as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudid(null);
                }

                array_push($resultadopropiedadesfamiliares, $valor);
            }

            $resultadocuentabanco = [];
            foreach ($cuentabanco as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudbecaid(null);
                }

                array_push($resultadocuentabanco, $valor);
            }

            $resultadoegresomensual = [];
            foreach ($egresomensual as $valor) {
                if (!empty($valor)) {
                    $valor->setSolicitudbecaid(null);
                }

                array_push($resultadoegresomensual, $valor);
            }

            $situacioneconomica = array(
                "solicitud" => $solicitudbeca,
                "ingresofamiliar" => $ingresofamiliar,
                "vehiculos" => $resultadovehiculos,
                "deudascreditos" => $resultadodeudascreditos,
                "situacionfamiliar" => $resultadosituacionfamiliar,
                "propiedadesfamiliares" => $resultadopropiedadesfamiliares,
                "cuentabanco" => $resultadocuentabanco,
                "estatuspropiedad" => $estatuspropiedad,
                "tipocredito" => $tipocredito,
                "estatusvehiculo" => $estatusvehiculo,
                "tipocuentabanco" => $tipocuentabanco,
                "egresomensual" => $resultadoegresomensual,
                "estatusfamilia" => $estatusfamilia,
            );

            return new View($situacioneconomica, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Método para Guardar Creditos
     * @Rest\Post("/api/Becas/SolicitudBeca/SituacionEconomica/DeudasCreditos", name="GuardarDeudasCreditos")
     */
    public function GuardarDeudasCreditos()
    {
        try {
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $deudascreditosentidad = $hydrator->hydrate('AppBundle\Entity\BcDeudascreditos', $decoded);

            $deudascreditos = $dbm->getRepositorioById('BcDeudascreditos', 'deudascreditosid', $decoded['deudascreditosid']);

            if (empty($deudascreditos)) {
                if (is_a($deudascreditosentidad, 'AppBundle\Entity\BcDeudascreditos')) {
                    $dbm->getConnection()->beginTransaction();
                    $dbm->saveRepositorio($deudascreditosentidad);
                    $dbm->getConnection()->commit();
                } else {
                    return new View("Parámetros de entrada no coinciden con la entidad", Response::HTTP_BAD_REQUEST);
                }
            } else {
                $dbm->getConnection()->beginTransaction();
                $deudascreditos->setConcepto($decoded['concepto']);
                $deudascreditos->setImportetotal($decoded['importetotal']);
                $deudascreditos->setPagomensual($decoded['pagomensual']);
                $deudascreditos->setBancoinstitucion($decoded['bancoinstitucion']);
                $deudascreditos->setLimitecredito($decoded['limitecredito']);
                $dbm->getConnection()->beginTransaction();
                $dbm->saveRepositorio($deudascreditos);
                $dbm->getConnection()->commit();
            }
            $deudas = $dbm->getByParametersRepositorios('BcDeudascreditos', array('solicitudid' => $decoded['solicitudid'], 'portal' => $decoded['portal']));

            $this->ValidacionEstatusSolicitud($decoded['solicitudid'], $dbm);
            return new View($deudas, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el resultado que coincida con el ID enviado de Creditos
     * @Rest\Delete("/api/Becas/SolicitudBeca/SituacionEconomica/DeudasCreditos/{id}", name="EliminarDeudasCreditos")
     */
    public function EliminarDeudasCreditos($id)
    {
        try {
            $dbm = $this->get("db_manager");

            $deudascreditos = $dbm->getRepositorioById('BcDeudascreditos', 'deudascreditosid', $id);
            if (empty($deudascreditos)) {
                return new View("Deuda o Crédito no encontrado", Response::HTTP_BAD_REQUEST);
            } else {
                $dbm->getConnection()->beginTransaction();
                $dbm->removeRepositorio($deudascreditos);
                $dbm->getConnection()->commit();
            }

            $deudas = $dbm->getRepositoriosById('BcDeudascreditos', 'solicitudid', $deudascreditos->getSolicitudid());
            return new View($deudas, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Método para Guardar Propiedades
     * @Rest\Post("/api/Becas/SolicitudBeca/SituacionEconomica/Propiedadesfamiliares", name="GuardarPropiedadesfamiliares")
     */
    public function GuardarPropiedadesfamiliares()
    {
        try {
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $propiedadesfamiliaresentidad = $hydrator->hydrate('AppBundle\Entity\BcPropiedadesfamiliares', $decoded);

            $propiedadesfamiliares = $dbm->getRepositorioById('BcPropiedadesfamiliares', 'propiedadfamiliaid', $decoded['propiedadfamiliaid']);

            if (empty($propiedadesfamiliares)) {
                if (is_a($propiedadesfamiliaresentidad, 'AppBundle\Entity\BcPropiedadesfamiliares')) {
                    $dbm->getConnection()->beginTransaction();
                    if ($decoded['domicilioactual'] == 1 || $decoded['domicilioactual'] == true) {
                        $propiedadesfamiliareslistado = $dbm->getRepositoriosById('BcPropiedadesfamiliares', 'solicitudid', $decoded['solicitudid']);
                        foreach ($propiedadesfamiliareslistado as $valor) {
                            $valor->setDomicilioactual(false);
                            $dbm->saveRepositorio($valor);
                        }
                    } else {
                        $propiedadesfamiliaresentidad->setDomicilioactual(0);
                    }
                    $dbm->saveRepositorio($propiedadesfamiliaresentidad);
                    $dbm->getConnection()->commit();
                } else {
                    return new View("Parámetros de entrada no coinciden con la entidad", Response::HTTP_BAD_REQUEST);
                }
            } else {
                $estatuspropiedad = $dbm->getRepositorioById('BcEstatuspropiedad', 'estatusid', $decoded['estatusid']);
                $propiedadesfamiliares->setTipopropiedad($decoded['tipopropiedad']);
                $propiedadesfamiliares->setEstatusid($estatuspropiedad);
                $propiedadesfamiliares->setValoraproximado($decoded['valoraproximado']);
                $propiedadesfamiliares->setCreditoanombrede($decoded['creditoanombrede']);
                $propiedadesfamiliares->setPropiedadanombrede($decoded['propiedadanombrede']);
                $propiedadesfamiliares->setDomicilioactual($decoded['domicilioactual']);
                $propiedadesfamiliares->setMtsterreno($decoded['mtsterreno']);
                $propiedadesfamiliares->setMtsconstruccion($decoded['mtsconstruccion']);
                $propiedadesfamiliares->setUbicacion($decoded['ubicacion']);
                $dbm->getConnection()->beginTransaction();
                if ($decoded['domicilioactual'] == 1 || $decoded['domicilioactual'] == true) {
                    $propiedadesfamiliareslistado = $dbm->getRepositosrioById('BcPropiedadesfamiliares', 'solicitudid', $decoded['solicitudid']);
                    foreach ($propiedadesfamiliareslistado as $valor) {
                        $valor->setDomicilioactual(false);
                        $dbm->saveRepositorio($valor);
                    }
                }
                $dbm->saveRepositorio($propiedadesfamiliares);
                $dbm->getConnection()->commit();
            }
            $propiedades = $dbm->getByParametersRepositorios('BcPropiedadesfamiliares', array('solicitudid' => $decoded['solicitudid'], 'portal' => $decoded['portal']));

            $this->ValidacionEstatusSolicitud($decoded['solicitudid'], $dbm);
            return new View($propiedades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el resultado que coincida con el ID enviado de Propiedades
     * @Rest\Delete("/api/Becas/SolicitudBeca/SituacionEconomica/Propiedadesfamiliares/{id}", name="EliminarPropiedadesfamiliares")
     */
    public function EliminarPropiedadesfamiliares($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $propiedadesfamiliares = $dbm->getRepositorioById('BcPropiedadesfamiliares', 'propiedadfamiliaid', $id);
            if (empty($propiedadesfamiliares)) {
                return new View("Situación familiar no encontrada", Response::HTTP_BAD_REQUEST);
            } else {
                $dbm->getConnection()->beginTransaction();
                $dbm->removeRepositorio($propiedadesfamiliares);
                $dbm->getConnection()->commit();
            }
            $propiedades = $dbm->getRepositoriosById('BcPropiedadesfamiliares', 'solicitudid', $propiedadesfamiliares->getSolicitudid());
            return new View($propiedades, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Método para GuardarVehículos
     * @Rest\Post("/api/Becas/SolicitudBeca/SituacionEconomica/Vehiculos", name="GuardarVehiculos")
     */
    public function GuardarVehiculos()
    {
        try {
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $vehiculoentidad = $hydrator->hydrate('AppBundle\Entity\BcVehiculos', $decoded);

            $vehiculo = $dbm->getRepositorioById('BcVehiculos', 'vehiculosid', $decoded['vehiculosid']);

            if (empty($vehiculo)) {
                if (is_a($vehiculoentidad, 'AppBundle\Entity\BcVehiculos')) {
                    $dbm->getConnection()->beginTransaction();
                    $dbm->saveRepositorio($vehiculoentidad);
                    $dbm->getConnection()->commit();
                } else {
                    return new View("Parámetros de entrada no coinciden con la entidad", Response::HTTP_BAD_REQUEST);
                }
            } else {
                $vehiculo->setMarcamodelo($decoded['marcamodelo']);
                $vehiculo->setAnio($decoded['anio']);
                $vehiculo->setEstatus($decoded['estatus']);
                $vehiculo->setTarjetacirculacion($decoded['tarjetacirculacion']);
                $dbm->getConnection()->beginTransaction();
                $dbm->saveRepositorio($vehiculo);
                $dbm->getConnection()->commit();
            }
            $vehiculos = $dbm->getByParametersRepositorios('BcVehiculos', array('solicitudid' => $decoded['solicitudid'], 'portal' => $decoded['portal']));
            $this->ValidacionEstatusSolicitud($decoded['solicitudid'], $dbm);
            return new View($vehiculos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el resultado que coincida con el ID enviado de Vehículos
     * @Rest\Delete("/api/Becas/SolicitudBeca/SituacionEconomica/Vehiculo/{id}", name="EliminarVehiculo")
     */
    public function EliminarVehiculo($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $vehiculo = $dbm->getRepositorioById('BcVehiculos', 'vehiculosid', $id);
            if (empty($vehiculo)) {
                return new View("Vehículo no encontrado", Response::HTTP_BAD_REQUEST);
            } else {
                $dbm->getConnection()->beginTransaction();
                $dbm->removeRepositorio($vehiculo);
                $dbm->getConnection()->commit();
            }
            $vehiculos = $dbm->getRepositoriosById('BcVehiculos', 'solicitudid', $vehiculo->getSolicitudid());
            return new View($vehiculos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Becas/SolicitudBeca/SituacionEconomica/CuentaBanco" , name="guardarCuentaBanco")
     */
    public function guardarCuentaBanco()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $cuentabanco = $hydrator->hydrate(new BcCuentabanco(), $data);
            $dbm->saveRepositorio($cuentabanco);

            $dbm->getConnection()->commit();
            $cuentasbanco = $dbm->getByParametersRepositorios('BcCuentabanco', array('solicitudbecaid' => $data['solicitudbecaid'], 'portal' => $data['portal']));

            $this->ValidacionEstatusSolicitud($decoded['solicitudbecaid'], $dbm);
            return new View($cuentasbanco, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Becas/SolicitudBeca/SituacionEconomica/CuentaBanco/{id}", name="eliminarCuentaBanco")
     */
    public function eliminarCuentaBanco($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
            $cuentabanco = $dbm->getRepositorioById('BcCuentabanco', 'cuentabancoid', $id);
            $dbm->removeRepositorio($cuentabanco);
            $dbm->getConnection()->commit();
            $cuentasbanco = $dbm->getRepositoriosById('BcCuentabanco', 'solicitudbecaid', $cuentabanco->getSolicitudbecaid());
            return new View($cuentasbanco, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Método para Guardar o Editar los Ingresos, Egresos y Situacion Familiar en la Solicitud de Becas
     * @Rest\Post("/api/Becas/SolicitudBeca/SituacionEconomica", name="GuardaoEditaSituacionEconomica")
     */
    public function GuardaoEditaSituacionEconomica()
    {
        try {
            $datos = $_REQUEST;
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            //INGRESOS
            if ($decoded["escuela"] == 1) {
                foreach ($decoded["ingresos"] as $ingreso) {
                    if (!$ingreso["ingresosluxid"]) {
                        $ingresolux = $hydrator->hydrate(new BcIngresoslux(), $ingreso);
                        $padre = $dbm->getRepositorioById("BcPadresotutores", "padresotutoresid", $ingreso["padresotutoresid"]);
                        $padre->setIngresosluxid($ingresolux);
                    } else {
                        $ingresolux = $hydrator->hydrate($dbm->getRepositorioById("BcIngresoslux", "ingresosluxid", $ingreso["ingresosluxid"]), $ingreso);
                    }
                    $dbm->saveRepositorio($ingresolux);
                }
            } else {
                $ingresofamiliarentidad = $hydrator->hydrate('AppBundle\Entity\BcIngresosfamiliares', $decoded["ingresos"]);
                $ingresofamiliar = $dbm->getRepositorioById('BcIngresosfamiliares', 'solicitudid', $decoded['solicitudid']);
                if (empty($ingresofamiliar)) {
                    if (is_a($ingresofamiliarentidad, 'AppBundle\Entity\BcIngresosfamiliares')) {
                        if ($decoded["escuela"] == 2) {
                            $ingresofamiliarentidad->setEgresosfamiliares($decoded["egresos"]['egresosfamiliares']);
                        }
                        $ingresofamiliarentidad->setSolicitudid($dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']));
                        $dbm->saveRepositorio($ingresofamiliarentidad);
                    } else {
                        return new View("Parámetros de entrada no coinciden con la entidad", Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    $ingresofamiliar->setIngresospadre($decoded["ingresos"]['ingresospadre']);
                    $ingresofamiliar->setIngresosmadre($decoded["ingresos"]['ingresosmadre']);
                    $ingresofamiliar->setOtrosfamiliares($decoded["ingresos"]['otrosfamiliares']);
                    $ingresofamiliar->setOtrosingresos($decoded["ingresos"]['otrosingresos']);
                    if ($decoded["escuela"] == 2) {
                        $ingresofamiliar->setEgresosfamiliares($decoded["egresos"]['egresosfamiliares']);
                    }
                    $dbm->saveRepositorio($ingresofamiliar);
                }
            }

            //EGRESOS
            if ($decoded["escuela"] == 1) {
                $egresomensual = $dbm->getRepositorioById('BcEgresomensuales', 'solicitudbecaid', $decoded['solicitudid']);
                if (!$egresomensual) {
                    $egresomensual = $hydrator->hydrate(new BcEgresomensuales(), $decoded["egresos"]);
                    $egresomensual->setSolicitudbecaid($dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']));
                } else {
                    $egresomensual = $hydrator->hydrate($egresomensual, $decoded["egresos"]);
                }

                $dbm->saveRepositorio($egresomensual);
            }

            //SITUACION

            $id = $dbm->getRepositorioById('BcSituacionfamiliar', 'solicitudid', $decoded['solicitudid']);
            if (empty($id)) {
                $entity = new BcSituacionfamiliar();
                $entity->setSolicitudid($dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']));
                $entity->setDescripcionsituacionfamiliar($decoded["situacion"]["descripcionsituacionfamiliar"]);
                $dbm->saveRepositorio($entity);
            } else {
                $observaciones = $id->getSituacionfamiliarid();
                $obs = $dbm->getRepositorioById('BcSituacionfamiliar', 'situacionfamiliarid', $observaciones);
                $obs->setDescripcionsituacionfamiliar($decoded["situacion"]["descripcionsituacionfamiliar"]);
                $dbm->saveRepositorio($obs);
            }

            $dbm->getConnection()->commit();
            if ($decoded["escuela"] == 1) {
                $this->ValidacionEstatusSolicitud($decoded['solicitudid'], $dbm);
            }

            return new View("Registro guardado/actualizado de forma correcta", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna todas las referencias de una solicitud
     * @Rest\Post("/api/SolicitudBeca/Getreferencias", name="getReferenciasBecas")
     */
    public function getReferencias()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $entidad = $dbm->BuscarReferencias($decoded);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * pestaña referencias
     * @Rest\Post("/api/SolicitudBeca/GuardarReferencias", name="referenciassolicitudbeca")
     */
    public function referenciassolicitudbeca()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $entity = $hydrator->hydrate('AppBundle\Entity\BcPersonareferencia', $decoded);
            $dbm->getConnection()->beginTransaction();
            $no = array("(", ")", "-");
            $ladatelefonocelular = str_replace($no, "", $decoded["ladatelefonocelular"]);
            $telefonocelular = str_replace($no, "", $decoded["telefonocelular"]);
            $entity->setTelefonocelular($ladatelefonocelular . "-" . $telefonocelular);
            $ladatelefonofijo = str_replace($no, "", $decoded["ladatelefonofijo"]);
            $telefonofijo = str_replace($no, "", $decoded["telefonofijo"]);
            $entity->setTelefonofijo($ladatelefonofijo . "-" . $telefonofijo);
            $dbm->saveRepositorio($entity);
            $dbm->getConnection()->commit();

            return new View("Se ha guardado la referencia", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Delete("/api/SolicitudBeca/eliminarRef/{id}" , name="deleteReferencia")
     */
    public function deleteReferencia($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            $encoded = json_encode($data);
            $decoded = json_decode($encoded, true);
            $dbm = $this->get("db_manager");
            $object = new DbmBecas($dbm->getEntityManager());

            $filtros = array(
                "personareferenciaid" => $id,
            );
            $object->eliminarRefencia($filtros);

            return new View("Se ha eliminado el registro correctamente", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * obtener días y fechas en que puede ser visitado para el estudio socioeconómico en referencias
     * @Rest\Post("/api/SolicitudBeca/getvisita", name="getVisitaBecas")
     */
    public function getVisita()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            $entidad = $dbm->buscarvisita($decoded);
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo word del formato
     * @Rest\Get("/api/Becas/PeriodoBeca/formato/descargar/reglamento/{id}", name="DescargarFormatoBecaReglamento")
     */
    public function DescargarFormatoBecaReglamento($id)
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $id);
            $periodobeca = $dbm->getRepositorioById("BcPeriodobeca", "cicloid", $solicitud->getCicloid()->getCicloid());
            if(!$periodobeca) {
                return new View("No hay un formato disponible.", Response::HTTP_PARTIAL_CONTENT);
            }
            $pfs = $dbm->getRepositoriosById("BcPeriodobecaporformato", "periodobecaid", $periodobeca->getPeriodobecaid());
            foreach ($pfs as $pf) {
                if ($pf->getFormatobecaid()->getTipoDocumentoid()->getTipoDocumentoid() == 2) {
                    $id = $pf->getFormatobecaid()->getFormatobecaid();
                }
            }
            //$vista_solicitud = $dbm->VistaSolicitudBeca(3);
            $vista_solicitud = array("dummy" => 1);
            $Formato = $dbm->getRepositorioById('BcFormatobeca', 'formatobecaid', $id);

            $extension = $Formato->getArchivotipo() == 'application/msword' ? '.doc' : '.docx';

            $temp = tmpfile();
            fwrite($temp, stream_get_contents($Formato->getArchivo()));
            $path = stream_get_meta_data($temp)['uri'];

            $parametros = $dbm->getRepositorioById("Parametros", "nombre", "UrlTokens");
            $urltokens = $parametros->getValor();
            //$urltokens="http://192.168.0.13:8015/api/archivotokens";
            $documento = \AppBundle\Dominio\Formato::remplazarToken($vista_solicitud, $path, $urltokens);
            fclose($temp);

            if (empty($documento["formato"])) {
                return new View("Hay un error con el archivo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                $response = new \Symfony\Component\HttpFoundation\Response(
                    $documento["formato"], 200, array(
                        'Content-Type' => 'application/pdf',
                        'Content-Length' => $documento["tamano"])
                );
                return $response;
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Descarga un formato solicitud de beca con los tokens remplazados
     * @Rest\Get("/api/Solicitud/DownloadFormatoSolicitudBeca/", name="SolicitudDownloadFormatoSolicitudBeca")
     */
    public function solicitudDownloadFormatoSolicitudBeca()
    {
        $dbm = $this->get("db_manager");
        $dbm = new DbmBecas($dbm->getEntityManager());

        $data = $_REQUEST;
        $vista_solicitud = $dbm->VistaSolicitudBeca($data["solicitudid"]);

        $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $data["solicitudid"]);
        $periodo = $dbm->getRepositorioById("BcPeriodobeca", "cicloid", $solicitud->getCicloid()->getCicloid());
        if(!$periodo) {
            return new View("No hay un formato disponible.", Response::HTTP_PARTIAL_CONTENT);
        }
        $periodoporformato = $dbm->getRepositoriosById("BcPeriodobecaporformato", "periodobecaid", $periodo->getPeriodobecaid());
        foreach ($periodoporformato as $pf) {
			$kTipoDocumento=$pf->getFormatobecaid()->getTipodocumentoid()->getTipodocumentoid();
            if ($kTipoDocumento == 1) {
                $formatoid = $pf->getFormatobecaid();
            }
        }

        $Formato = $formatoid;

        $temp = tmpfile();
        fwrite($temp, stream_get_contents($Formato->getArchivo()));
        $path = stream_get_meta_data($temp)['uri'];

        $parametros = $dbm->getRepositorioById("Parametros", "nombre", "UrlTokens");
        $urltokens = $parametros->getValor();
        $documento = \AppBundle\Dominio\Formato::remplazarToken($vista_solicitud, $path, $urltokens);
        fclose($temp);

        if (empty($documento["formato"])) {
            return new View("No hay un formato disponible.", Response::HTTP_PARTIAL_CONTENT);
        } else {
            $response = new \Symfony\Component\HttpFoundation\Response(
                $documento["formato"], 200, array(
                    'Content-Type' => 'application/pdf',
                    'Content-Length' => $documento["tamano"])
            );
            return $response;
        }

    }

    /**
     * dias en que puede ser visitado para estudio socioeconomico
     * @Rest\Post("/api/SolicitudBeca/visitaestudios", name="visitasocioeconomico")
     */
    public function visitasocioeconomico()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $entity = $hydrator->hydrate('AppBundle\Entity\BcVisitaestudiosocioeconomico', $decoded);

            $dbm->getConnection()->beginTransaction();
            $id = $dbm->getRepositorioById('BcVisitaestudiosocioeconomico', 'solicitudid', $decoded['solicitudid']);
            if (empty($id)) {
                $dbm->saveRepositorio($entity);
                $dbm->getConnection()->commit();
            } else {
                $observaciones = $id->getVisitaestudiosocioeconomicoid();
                $obs = $dbm->getRepositorioById('BcVisitaestudiosocioeconomico', 'visitaestudiosocioeconomicoid', $observaciones);
                $obs->setSolicitudid($entity->getSolicitudid());
                $obs->setVisitaestudiosocioeconomico($entity->getVisitaestudiosocioeconomico());
                $dbm->saveRepositorio($obs);
                $dbm->getConnection()->commit();
            }

            $ingresos = $dbm->getRepositorioById("BcIngresosfamiliares", "solicitudid", $decoded['solicitudid']);
            if ($ingresos) {
                if ($ingresos->getIngresospadre() > 0 || $ingresos->getIngresosmadre() > 0 || $ingresos->getOtrosfamiliares() > 0 || $ingresos->getOtrosingresos() > 0) {
                    $ingresosvalidacion = true;
                }
            }

            $domicilio = $dbm->getRepositorioById("BcDomicilioestudiosocioeconomico", "solicitudid", $decoded['solicitudid']);
            if ($domicilio) {
                if ($domicilio->getCodigopostal()) {
                    $domiciliovalidacion = true;
                }
            }

            $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $decoded['solicitudid']);
            if ($ingresosvalidacion && $domiciliovalidacion && $solicitud->getEstatusid()->getEstatusid() == 2) {
                $solicitud->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 3));
                $dbm->saveRepositorio($solicitud);
                $solicitudesalumno = $dbm->getRepositoriosById("BcSolicitudporalumno", "solicitudid", $decoded['solicitudid']);
                foreach ($solicitudesalumno as $spa) {
                    if ($spa->getEstatusid()->getEstatusid() != 7) {
                        $spa->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 3));
                        $dbm->saveRepositorio($spa);
                    }
                }

            }

            return new View("Se ha guardado vsita estudio socioeconomico", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function ValidacionEstatusSolicitud($solicitudid, $dbm)
    {
        $padresotutores = $dbm->getRepositoriosById("BcPadresotutores", "solicitudid", $solicitudid);
        foreach ($padresotutores as $padre) {
            $ingresos = $dbm->getRepositorioById("BcIngresoslux", "ingresosluxid", $padre->getIngresosluxid());
            if ($ingresos) {
                $ingresosvalidacion = true;
            }
        }

        $domicilio = $dbm->getRepositorioById("BcDomicilioestudiosocioeconomico", "solicitudid", $solicitudid);
        if ($domicilio) {
            if ($domicilio->getCodigopostal()) {
                $domiciliovalidacion = true;
            }
        }
        $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $solicitudid);
        if ($ingresosvalidacion && $domiciliovalidacion && $solicitud->getEstatusid()->getEstatusid() == 2) {
            $solicitud->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 3));
            $dbm->saveRepositorio($solicitud);
            $solicitudesalumno = $dbm->getRepositoriosById("BcSolicitudporalumno", "solicitudid", $solicitudid);
            foreach ($solicitudesalumno as $spa) {
                if ($spa->getEstatusid()->getEstatusid() == 2) {
                    $spa->setEstatusid($dbm->getRepositorioById("BcEstatussolicitudbeca", "estatusid", 3));
                    $dbm->saveRepositorio($spa);
                }
            }

        }
    }

}
