<?php

namespace AppBundle\Controller\Cobranza;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmCobranza;
use AppBundle\Entity\CbAgendacita;
use AppBundle\Entity\CbAgendacitapadresotutores;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmControlescolar;

/**
 * @author Inceptio
 */
class AgendaCitasController extends FOSRestController
{

    /**
     * Reotorna valores iniciales
     * @Rest\Get("/api/Cobranza/Agendacita", name="indexAgendacita")
     */
    public function indexAction()
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());

            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);

            $cicloactual = $dbm->getRepositorioById('Ciclo', 'actual', 1);
            $grupo = $dbm->getByParametersRepositorios('CeGrupo',array('tipogrupoid' => 1, 'cicloid' => $cicloactual));

            return new View(
                array("nivel" => $nivel,
                    "grado" => $grado,
                    "grupo" => $grupo), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reotorna una busqueda
     * @Rest\Get("/api/Cobranza/Agendacita/", name="BuscarAgendacita")
     */
    public function getAgendacita()
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;
            $filtros = array_filter($data);

            $agendacita = array();
            $citas = $dbm->getAgendaCitasFilters($filtros);
            foreach ($citas as $c) {
                $filtro = array_merge($filtros, array("alumnoid" => explode(",", $c["alumnoid"])));
                $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
                $alumnos = $dbma->BuscarAlumnosA($filtro);
                if ($alumnos) {
                    array_push($agendacita, array("agendacita" => $c, "alumnos" => $alumnos));
                }
            }

            if (!$agendacita) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($agendacita, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de tutores que perteneces a una familiar
     * @Rest\Get("/api/Cobranza/Agendacita/Tutores", name="BuscarPadresAgendaCita")
     */
    public function getAgendacitaPadres()
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $datos = $_REQUEST;

            $padresdefamilia = $dbm->getRepositoriosById('CePadresotutoresclavefamiliar', 'clavefamiliarid', $datos["clavefamiliarid"]);
            $padresagendacita = $dbm->getRepositoriosById('CbAgendacitapadresotutores', 'agendacitaid', $datos["agendacitaid"]);
            $hijos = $dbm->getRepositoriosById('CeAlumnoporclavefamiliar', 'clavefamiliarid', $datos["clavefamiliarid"]);
            $func = function ($hijo) {
                return $hijo->getAlumnoid()->getAlumnoid();
            };
            $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumnos = $dbma->BuscarAlumnosA(array("alumnoid" => array_map($func, $hijos)));
            if (!$alumnos) {
                return new View("Los alumno que pertenecen a la familia, no han sido configurados al ciclo actual", Response::HTTP_PARTIAL_CONTENT);
            }
            $organizador = $dbm->getRepositorioById('Usuario', 'usuarioid', $datos["usuarioid"])->getPersonaid();
            $asistente = $dbm->getRepositorioById('Parametros', 'nombre', "Asistentecobranza");

            $invitados = array(
                array("parentesco" => "Organizador",
                    "nombre" => $organizador->getNombre() . ' ' . $organizador->getApellidopaterno() . ' ' . $organizador->getApellidomaterno(),
                    "correo" => $organizador->getEmail(),
                ),
                array("parentesco" => "Asistente",
                    "nombre" => "Asistente de cobranza",
                    "correo" => $asistente->getValor(),
                ),
            );

            return new View(array("padresfamilia" => $padresdefamilia, "padrescita" => $padresagendacita, "alumnos" => $alumnos, "invitados" => $invitados), Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para gurdar
     * @Rest\Post("/api/Cobranza/Agendacita", name="saveAgendacita")
     */
    public function saveAgendacita()
    {
        try {
            $datos = $_REQUEST;
            $datos = json_decode($datos["datos"], true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $fecha = $datos['fechainicio']['date'];
            $datos['fechainicio'] = (new \DateTime($fecha['day'] . '-' . $fecha['month'] . '-' . $fecha['year']));
            $datos['horainicio'] .= ':00';
            $datos['horafin'] .= ':00';

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $agenda = $hydrator->hydrate(new CbAgendacita(), $datos);
            $dbm->saveRepositorio($agenda);

            foreach ($datos["tutores"] as $t) {
                if ($t["check"] && $t["tipoinvitado"] != 2) {
                    $agendapadres = new CbAgendacitapadresotutores();
                    $agendapadres->setAgendacitaid($agenda);
                    if ($t["padreotutorid"]) {
                        $agendapadres->setPadresotutoresid($dbm->getRepositorioById('CePadresotutores', 'padresotutoresid', $t['padreotutorid']));
                    } else {
                        $agendapadres->setOtros($t['correo']);
                    }
                    $dbm->saveRepositorio($agendapadres);
                }
            }
            $dbm->getConnection()->commit();

            //Enviar correo de aviso
            $correo = $dbm->getRepositorioById('Correo', 'correoid', 6);
            self::correoAgendacita($agenda, $correo, $datos['usuarioid']);

            return new View('Se ha guardado el registro y se ha enviado la invitación a los destinatarios.', Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para actualizar
     * @Rest\Put("/api/Cobranza/Agendacita/{id}", name="updateAgendacita")
     */
    public function updateAgendacita($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $datos = json_decode($datos["datos"], true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $fecha = $datos['fechainicio']['date'];
            $datos['fechainicio'] = (new \DateTime($fecha['day'] . '-' . $fecha['month'] . '-' . $fecha['year']));
            $datos['horainicio'] .= ':00';
            $datos['horafin'] .= ':00';

            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $agenda = $hydrator->hydrate($dbm->getRepositorioById('CbAgendacita', 'agendacitaid', $id), $datos);
            $agenda->setAsistencia($datos["asistencia"]);
            $agenda->setAsistio($datos["asistio"]);
            $dbm->saveRepositorio($agenda);

            $dbm->removeManyRepositorio('CbAgendacitapadresotutores', 'agendacitaid', $id);
            foreach ($datos["tutores"] as $t) {
                if ($t["check"] && $t["tipoinvitado"] != 2) {
                    $agendapadres = new CbAgendacitapadresotutores();
                    $agendapadres->setAgendacitaid($agenda);
                    if ($t["padreotutorid"]) {
                        $agendapadres->setPadresotutoresid($dbm->getRepositorioById('CePadresotutores', 'padresotutoresid', $t['padreotutorid']));
                    } else {
                        $agendapadres->setOtros($t['correo']);
                    }
                    $dbm->saveRepositorio($agendapadres);
                }
            }
            $dbm->getConnection()->commit();

            if ($datos['reenviocorreo'] || $datos['enviocorreo']) {
                $destinatarios = $dbm->getRepositorioById('CbAgendacitapadresotutores', 'agendacitaid', $id);
                if ($datos['enviocorreo']) {
                    $correo = $dbm->getRepositorioById('Correo', 'correoid', 7);
                    self::correoAgendacita($agenda, $correo, $datos['usuarioid']);
                    return new View('Se ha guardado el registro y se ha enviado la invitación a los destinatarios.', Response::HTTP_OK);
                }
                if ($datos['reenviocorreo']) {
                    $correo = $dbm->getRepositorioById('Correo', 'correoid', 6);
                    $correo = $correo->setMotivo($correo->getMotivo() . " (Cambio)");
                    self::correoAgendacita($agenda, $correo, $datos['usuarioid']);
                    return new View('Se ha guardado el registro y se ha enviado la invitación a los destinatarios.', Response::HTTP_OK);
                }
            }
            return new View('Se ha actualizado el registro', Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function correoAgendacita($agendacita, $correo, $usuarioid)
    {
        $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
        $agendapapa = $dbm->getRepositoriosById('CbAgendacitapadresotutores', 'agendacitaid', $agendacita->getAgendacitaid());
        $destinatarios = array();
        foreach ($agendapapa as $p) {
            if ($p->getPadresotutoresid()) {
                array_push($destinatarios, $p->getPadresotutoresid()->getCorreo());
            } else {
                $lista = explode(',', $p->getOtros());
                foreach ($lista as $l) {
                    array_push($destinatarios, $l);
                }
            }
        }

        $organizador = $dbm->getRepositorioById('Usuario', 'usuarioid', $usuarioid);
        array_push($destinatarios, $organizador->getPersonaid()->getEmail());
        $asistente = $dbm->getRepositorioById('Parametros', 'nombre', "Asistentecobranza");
        array_push($destinatarios, $asistente->getValor());

        $parametros = array(
            "familia" => $agendacita->getClavefamiliarid()->getApellidopaterno() . ' ' . $agendacita->getClavefamiliarid()->getApellidomaterno(),
            "fecha" => $agendacita->getFechainicio()->format('d/m/Y'),
            "horainicio" => $agendacita->getHorainicio()->format('H:i'),
            "horafin" => $agendacita->getHorafin()->format('H:i'),
        );

        if ($correo->getCorreoid() == 6) {
            $organizador = $organizador->getPersonaid()->getEmail();
            $inicio = (new \DateTime(
                $agendacita->getFechainicio()->format('d-m-Y') . ' ' . $parametros["horainicio"]))->getTimestamp();
            $inicio = date('Ymd\THis', $inicio);
            $fin = (
                new \DateTime($agendacita->getFechainicio()->format('d-m-Y') . ' ' . $parametros["horafin"]))->getTimestamp();
                $fin = date('Ymd\THis', $fin);
            $attachment[] = "BEGIN:VCALENDAR";
            $attachment[] = "PRODID:-//Some organization//some application//EN";
            $attachment[] = "VERSION:2.0";
            $attachment[] = "METHOD:REQUEST";
            $attachment[] = "BEGIN:VEVENT";
            $attachment[] = "UID:20120925T072912Z-140@http://localhost/www/";
            $attachment[] = "CREATED:" . $inicio;
            $attachment[] = "DTSTAMP:" . $inicio;
            $attachment[] = "DTSTART:" . $inicio;
            $attachment[] = "DTEND:" . $fin;
            $attachment[] = "SUMMARY:Cita en el área de cobranza";
            $attachment[] = "LOCATION:Escuela";
            $attachment[] = "ORGANIZER;CN=" . $organizador . ":mailto:" . $organizador;
            $attachment[] = "LAST-MODIFIED:" . $inicio;
            $attachment[] = "PRIORITY:5";
            $attachment[] = "SEQUENCE:0";
            $attachment[] = "STATUS:CONFIRMED";
            $attachment[] = "TRANSP:TRANSPARENT";
            $attachment[] = "END:VEVENT";
            $attachment[] = "END:VCALENDAR";
            $attachment = implode("\r\n", $attachment);
        }

        \AppBundle\Dominio\Correo::ServicioCorreo($destinatarios, $parametros, $correo, $this->get('mailer'), $attachment);
    }

    /**
     * Eliminar registro
     * @Rest\Delete("/api/Cobranza/Agendacita/{id}", name="AgendacitaDelete")
     */
    public function deleteAgendacita($id)
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $dbm->removeManyRepositorio('CbAgendacitapadresotutores', 'agendacitaid', $id);
            $cita = $dbm->getRepositorioById('CbAgendacita', 'agendacitaid', $id);
            $dbm->removeRepositorio($cita);

            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

}
