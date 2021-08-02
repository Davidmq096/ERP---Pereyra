<?php

namespace AppBundle\Controller\Transporte;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmTransporte;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\TpBoleto;
use AppBundle\Entity\TpBoletobitacora;
use AppBundle\Entity\CjDocumentoporpagar;
use FOS\RestBundle\View\View;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;

/**
 * Auto: Javier
 */
class BoletoController extends FOSRestController
{

    /**
     * Retorna los filtros para la busqueda de boletos
     * @Rest\Get("/api/Transporte/Boleto", name="indexBoleto")
     */
    public function indexBoleto()
    {
        try {
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $ruta = $dbm->BuscarRuta(array("activo" => true));
            foreach ($ruta as $key => $r) {
                $ruta[$key]["paradas"] = $dbm->getRepositoriosById('TpRutaprecioparada', 'rutaid', $r["rutaid"], 'orden');
                $ruta[$key]["preciosfijos"] = $dbm->getRepositoriosById('TpRutapreciofijo', 'rutaid', $r["rutaid"]);
            }

            $fecha = new \DateTime();
            $ayer = (new \DateTime())->modify('-1 day');

            return new View(array("ruta" => $ruta, "fecha" => $fecha, "ayer" => $ayer), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de rutas con su disponibilidad en un rango de fechas
     * @Rest\Get("/api/Transporte/Boleto/Disponibilidad", name="buscarDisponibilidad")
     */
    public function getDisponibilidad()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());

            $inicio = strtotime($filtros["fechainicio"]);
            $fin = strtotime($filtros["fechafin"]);

            $entidad = array();
            for ($i = $inicio; $i <= $fin; $i += 86400) {
                $sabado = date('w', strtotime(date("Y-m-d", $i))) == 6 ? true : false;
                $domingo = date('w', strtotime(date("Y-m-d", $i))) == 0 ? true : false;

                $fecha = $dbm->BuscarDisponibilidad(
                    array(
                        "rutaid" => $filtros["rutaid"],
                        "fecha" => date("Y-m-d", $i),
                        "sabado" => $sabado,
                        "domingo" => $domingo
                    )
                );
                $entidad = array_merge($entidad, $fecha);
            }

            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de alumnos que ocupan una ruta en una fecha especifica
     * @Rest\Get("/api/Transporte/Boleto/Disponibilidad/Alumnos", name="buscarDisponibilidadAlumnos")
     */
    public function getDisponibilidadAlumnos()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());

            $alumnos = $dbm->BuscarDisponibilidadAlumnos($filtros);
            $paradas = $dbm->getRepositoriosById('TpRutaprecioparada', 'rutaid', $filtros["rutaid"], 'orden');
            $preciosfijos = $dbm->getRepositoriosById('TpRutapreciofijo', 'rutaid', $filtros["rutaid"], 'fechafin');

            return new View(array("alumnos" => $alumnos, "paradas" => $paradas, "preciosfijos" => $preciosfijos), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /** Vender boletos
     * @Rest\Post("/api/Transporte/Boleto/Vender" , name="GuardarBoleto")
     */
    public function SaveBoleto()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm2 = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $cicloactual = $dbm->getRepositorioById('Ciclo', 'actual', 1);

            $boletosid = array();
            foreach ($data as $d) {
                $sabado = date('w', strtotime($d["fecha"])) == 6 ? true : false;
                $domingo = date('w', strtotime($d["fecha"])) == 0 ? true : false;
                $fecha = $dbm->BuscarDisponibilidad(
                    array(
                        "rutaid" => $d["rutaid"],
                        "fecha" => $d["fecha"],
                        "sabado" => $sabado,
                        "domingo" => $domingo
                    )
                );
                if (!$fecha) {
                    return new View("El transporte no esta disponible en la fecha seleccionada", Response::HTTP_PARTIAL_CONTENT);
                }
                $fecha = $fecha[0];
                if ($fecha["suspender"]) {
                    return new View("El transporte ha sido supendido en la fecha seleccionada", Response::HTTP_PARTIAL_CONTENT);
                }
                $numboletos = $fecha["contrato"] + $fecha["boleto"];

                if (($numboletos + $d["cantidad"]) > $fecha["capacidad"]  && !$d["vender"]) {
                    return new View("El numero de boletos excede la capacidad de la ruta " . $fecha["ruta"] . ". Disponibles: " . ($fecha['capacidad'] - $numboletos), Response::HTTP_PARTIAL_CONTENT);
                }

                $subconcepto = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', 28);
                $alumno = $dbm2->BuscarAlumnosA(array("alumnoid" => $d["alumnoid"]))[0];
                $documento =
                    [
                        "documentoid" => 17,
                        "subconceptoid" => $subconcepto->getSubconceptoid(),
                        "concepto" => $subconcepto->getNombre(),
                        "cicloid" => $cicloactual->getCicloid(),
                        "pagoestatusid" => 1,
                        "alumnoid" => $d["alumnoid"],
                        "gradoid" => $alumno["gradoid"],
                        "importe" => $d["precio"],
                        "saldo" => $d["precio"],
                        "fechalimitepago" => new \DateTime(date("Y-m-t")),
                        "fechacreacion" => (new \DateTime()),
                        "fechaprontopago" => $subconcepto->getIniciocobro()
                    ];

                for ($i = 0; $i < $d["cantidad"]; $i++) {
                    $documentoporpagar = $hydrator->hydrate(new CjDocumentoporpagar(), $documento);
                    $dbm->saveRepositorio($documentoporpagar);

                    $boleto = $hydrator->hydrate(new TpBoleto(), $d);
                    $boleto->setFechabitacora(new \DateTime());
                    $boleto->setDocumentoporpagarid($documentoporpagar);
                    $boleto->setEscaneado(0);
                    $boleto->setUsuariocompraid($dbm->getRepositorioById('Usuario', 'usuarioid', $d["usuarioid"]));
                    $dbm->saveRepositorio($boleto);
                    $boletosid[] = $boleto->getBoletoid();
                    $id = $boleto->getBoletoid();
                    $portal = $this->Portal($d['portal']);
                    $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $d["usuarioid"]);
                    $nombre = null;
                    switch ($usuario->getTipousuarioid()->getTipousuarioid()) {
                        case 1;
                            $persona = $usuario->getPersonaid();
                            $nombre = $persona ? $persona->getApellidopaterno() . ' ' . $persona->getApellidomaterno() . ' ' . $persona->getNombre() : null;
                            break;
                        case 2;
                            break;
                        case 3;
                            $alumno = $usuario->getAlumnoid();
                            $nombre = $alumno ? $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno() . ' ' . $alumno->getPrimernombre() : null;
                            break;
                        case 4;
                            $papa = $usuario->getPadreotutorid();
                            $nombre = $papa ?  $papa->getApellidopaterno() . ' ' . $papa->getApellidomaterno() . ' ' . $papa->getNombre() : null;
                    }
                    
                    $bitacora = $hydrator->hydrate(new TpBoletobitacora(), $d);
                    $bitacora->setBoletoid($id);
                    $bitacora->setPortal($portal);
                    $bitacora->setBoletoestatusid($dbm->getRepositorioById('TpBoletoestatus', 'boletoestatusid', 1));
                    $bitacora->setFechacompra(new \DateTime());
                    $bitacora->setFechaviaje(new \DateTime($d['fecha']));
                    $bitacora->setUsuario($nombre);
                    $dbm->saveRepositorio($bitacora);
                }
            }

            $dbm->getConnection()->commit();
            return new View(["msj" => "Se ha guardado el registro", "boletos" => $boletosid], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Regresa un arreglo de boletos
     * @Rest\Get("/api/Transporte/Misboletos", name="MisBoletos")
     */
    public function getMisBoletos()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());

            $entidad = $dbm->BuscarMisboletos($filtros);

            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Imprime los boletos
     * @Rest\Get("/api/Transporte/Boleto/pdf/", name="getBoleto")
     */
    public function getBoletos()
    {
        try {
            $datos = $_REQUEST;
            $data = array_filter($datos);

            $path = str_replace('app', '', $this->get('kernel')->getRootDir());
            $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";

            switch (ENTORNO) {
                case 1:
                    $logo = $path . "Lux/transporteboleto.png";
                    $plantilla = "'" . $path . "Lux/Transporte_Boleto_Lux.jrxml'";
                    break;
                case 2:
                    $logo = $path . "Ciencias/transporteboleto.png";
                    $plantilla = "'" . $path . "Ciencias/Transporte_Boleto_Ciencias.jrxml'";
                    break;
            }

            $jasper = new JasperPHP($this->container);
            $respuesta = $jasper->process(
                $plantilla,
                "'" . $path . "Boletos'",
                array("pdf"),
                array("boletoid" => implode(",", $data['boletos']), "logo" => $logo),
                true
            )->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/Boletos.pdf";
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
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /** Elimna los boletos boletos
     * @Rest\Post("/api/Transporte/Boleto/Cancelar" , name="EliminarBoleto")
     */
    public function DeleteBoleto()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            //
            $fechaHoy = new \DateTime();
            $fechaHoy->setTime(0, 0, 0);

            foreach ($data['ids'] as $b) {
                $boleto =  $dbm->getRepositorioById('TpBoleto', 'boletoid', $b);
                if ($fechaHoy <= $boleto->getFecha()) {
                    $dpp = $boleto->getDocumentoporpagarid();
                    if ($dpp) {
                        if ($dpp->getPagoestatusid()->getPagoestatusid() == 2) {
                            return new View("Algunos de los boletos seleccionados ya están pagados", Response::HTTP_PARTIAL_CONTENT);
                        }
                    } else {
                        return new View("No se encontró un documento por pagar asociado al boleto", Response::HTTP_PARTIAL_CONTENT);
                    }

                    $id = $boleto->getBoletoid();
                    $portal = $this->Portal($data['portal']);
                    $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data["usuarioid"]);
                    $nombre = null;
                    switch ($usuario->getTipousuarioid()->getTipousuarioid()) {
                        case 1;
                            $persona = $usuario->getPersonaid();
                            $nombre = $persona ? $persona->getApellidopaterno() . ' ' . $persona->getApellidomaterno() . ' ' . $persona->getNombre() : null;
                            break;
                        case 2;
                            break;
                        case 3;
                            $alumno = $usuario->getAlumnoid();
                            $nombre = $alumno ? $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno() . ' ' . $alumno->getPrimernombre() : null;
                            break;
                        case 4;
                            $papa = $usuario->getPadreotutorid();
                            $nombre = $papa ?  $papa->getApellidopaterno() . ' ' . $papa->getApellidomaterno() . ' ' . $papa->getNombre() : null;
                    }

                    $bitacora = new TpBoletobitacora();
                    $bitacora->setRutaid($boleto->getRutaid());
                    $bitacora->setAlumnoid($boleto->getAlumnoid());
                    $bitacora->setParadaid($boleto->getParadaid());
                    $bitacora->setPrecio($boleto->getPrecio());
                    $bitacora->setBoletoid($id);
                    $bitacora->setFechaviaje($boleto->getFecha());
                    $bitacora->setPortal($portal);
                    $bitacora->setBoletoestatusid($dbm->getRepositorioById('TpBoletoestatus', 'boletoestatusid', 1));
                    $bitacora->setFechacancelacion(new \DateTime());
                    $bitacora->setMediocancelacion($portal);
                    $bitacora->setUsuariocancelacion($nombre);
                    $bitacora->setUsuario($nombre);
                    $dbm->saveRepositorio($bitacora);

                    $dbm->removeRepositorio($boleto);
                    $dbm->removeRepositorio($dpp);
                } else {
                    return new View("No se pueden cancelar boletos con fecha anterior al día de hoy", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            $dbm->getConnection()->commit();
            return new View(array('msj' => "Se han cancelado los boletos seleccionados"), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /** Elimna los boletos desde el portal familiar
     * @Rest\Post("/api/Transporte/Boleto/Familiar/Cancelar" , name="DeleteBoletoFamiliar")
     */
    public function DeleteBoletoFamiliar()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            //
            $fechaHoy = new \DateTime();
            $fechaHoy->setTime(0, 0, 0);

            foreach ($data['ids'] as $b) {
                $boleto =  $dbm->getRepositorioById('TpBoleto', 'boletoid', $b);
                if ($fechaHoy < $boleto->getFecha()) {
                    $dpp = $boleto->getDocumentoporpagarid();
                    if ($dpp) {
                        if ($dpp->getPagoestatusid()->getPagoestatusid() == 2) {
                            return new View("Algunos de los boletos seleccionados ya están pagados", Response::HTTP_PARTIAL_CONTENT);
                        }
                    } else {
                        return new View("No se encontró un documento por pagar asociado al boleto", Response::HTTP_PARTIAL_CONTENT);
                    }
                    $id = $boleto->getBoletoid();
                    $portal = $this->Portal($data['portal']);
                    $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data["usuarioid"]);
                    $nombre = null;
                    switch ($usuario->getTipousuarioid()->getTipousuarioid()) {
                        case 1;
                            $persona = $usuario->getPersonaid();
                            $nombre = $persona ? $persona->getApellidopaterno() . ' ' . $persona->getApellidomaterno() . ' ' . $persona->getNombre() : null;
                            break;
                        case 2;
                            break;
                        case 3;
                            $alumno = $usuario->getAlumnoid();
                            $nombre = $alumno ? $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno() . ' ' . $alumno->getPrimernombre() : null;
                            break;
                        case 4;
                            $papa = $usuario->getPadreotutorid();
                            $nombre = $papa ?  $papa->getApellidopaterno() . ' ' . $papa->getApellidomaterno() . ' ' . $papa->getNombre() : null;
                    }

                    $bitacora = new TpBoletobitacora();
                    $bitacora->setRutaid($boleto->getRutaid());
                    $bitacora->setAlumnoid($boleto->getAlumnoid());
                    $bitacora->setParadaid($boleto->getParadaid());
                    $bitacora->setPrecio($boleto->getPrecio());
                    $bitacora->setBoletoid($id);
                    $bitacora->setPortal($portal);
                    $bitacora->setBoletoestatusid($dbm->getRepositorioById('TpBoletoestatus', 'boletoestatusid', 1));
                    $bitacora->setFechacancelacion(new \DateTime());
                    $bitacora->setMediocancelacion($portal);
                    $bitacora->setUsuariocancelacion($nombre);
                    $bitacora->setUsuario($nombre);
                    $bitacora->setFechaviaje($boleto->getFecha());
                    $dbm->saveRepositorio($bitacora);

                    $dbm->removeRepositorio($boleto);
                    $dbm->removeRepositorio($dpp);
                } else {
                    return new View("Solo se pueden cancelar boletos con fecha anterior al día de hoy", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            $dbm->getConnection()->commit();
            return new View(array('msj' => "Se han cancelado los boletos seleccionados"), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /** Actualiza un boleto
     * @Rest\Put("/api/Transporte/Boleto/Actualizar" , name="ActualizaBoleto")
     */
    public function updateBoleto()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $sabado = date('w', strtotime($data["fecha"])) == 6 ? true : false;
            $domingo = date('w', strtotime($data["fecha"])) == 0 ? true : false;
            $fecha = $dbm->BuscarDisponibilidad(
                array(
                    "boletoid" => $data["boletoid"],
                    "rutaid" => $data["rutaid"],
                    "fecha" => $data["fecha"],
                    "sabado" => $sabado,
                    "domingo" => $domingo
                )
            );

            if (!$fecha) {
                return new View("El transporte no esta disponible en la fecha seleccionada", Response::HTTP_PARTIAL_CONTENT);
            }
            $fecha = $fecha[0];
            if ($fecha["suspender"]) {
                return new View("El transporte ha sido supendido en la fecha seleccionada", Response::HTTP_PARTIAL_CONTENT);
            }
            $numboletos = $fecha["contrato"] + $fecha["boleto"] + 1;

            if ($numboletos > $fecha["capacidad"]) {
                return new View("No se cuenta con boletos disponibles para la ruta " . $fecha["ruta"], Response::HTTP_PARTIAL_CONTENT);
            }

            $boleto = $hydrator->hydrate($dbm->getRepositorioById('TpBoleto', 'boletoid', $data["boletoid"]), $data);
            $boleto->setFechabitacora(new \DateTime());
            $boleto->setUsuariocompraid($dbm->getRepositorioById('Usuario', 'usuarioid', $data["usuarioid"]));
            $dbm->saveRepositorio($boleto);
            $id = $boleto->getBoletoid();
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data["usuarioid"]);
            $persona = $usuario->getPersonaid();

            $portal = $this->Portal($data['portal']);

            $nombre = null;
            switch ($usuario->getTipousuarioid()->getTipousuarioid()) {
                case 1;
                    $persona = $usuario->getPersonaid();
                    $nombre = $persona ? $persona->getApellidopaterno() . ' ' . $persona->getApellidomaterno() . ' ' . $persona->getNombre() : null;
                    break;
                case 2;
                    break;
                case 3;
                    $alumno = $usuario->getAlumnoid();
                    $nombre = $alumno ? $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno() . ' ' . $alumno->getPrimernombre() : null;
                    break;
                case 4;
                    $papa = $usuario->getPadreotutorid();
                    $nombre = $papa ?  $papa->getApellidopaterno() . ' ' . $papa->getApellidomaterno() . ' ' . $papa->getNombre() : null;
            }

            $bitacora = new TpBoletobitacora();
            $bitacora->setRutaid($boleto->getRutaid());
            $bitacora->setAlumnoid($boleto->getAlumnoid());
            $bitacora->setParadaid($boleto->getParadaid());
            $bitacora->setPrecio($boleto->getPrecio());
            $bitacora->setBoletoid($id);
            $bitacora->setPortal($portal);
            $bitacora->setBoletoestatusid($dbm->getRepositorioById('TpBoletoestatus', 'boletoestatusid', 1));
            $bitacora->setFechaedicion(new \DateTime());
            $bitacora->setFechaviaje(new \DateTime($data['fecha']));
            $bitacora->setMedioedicion($portal);
            $bitacora->setUsuarioedicion($nombre);
            $bitacora->setUsuario($persona ? $persona->getApellidopaterno() . ' ' . $persona->getApellidomaterno() . ' ' . $persona->getNombre() : null);
            $bitacora->setFechaviaje($boleto->getFecha());
            $dbm->saveRepositorio($bitacora);

            $dbm->getConnection()->commit();

            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Regresa un arreglo de boletos
     * @Rest\Get("/api/Transporte/Misboletos/Bitacora", name="MisBoletosBitacora")
     */
    public function getBitacoraboletos()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());

            $entidad = $dbm->BuscarBoletoBitacora($filtros);

            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function Portal($valor)
    {
        switch ($valor) {
            case 1:
                $portal = "Venta a granel";
                break;
            case 2:
                $portal = "Portal Alumnos";
                break;
            case 3:
                $portal = "Portal familiar";
                break;
            case 4:
                $portal = "App de alumnos";
                break;
            case 5:
                $portal = "App de padres";
                break;
            case 6:
                $portal = "App de transporte";
                break;
        }
        return $portal;
    }
}
