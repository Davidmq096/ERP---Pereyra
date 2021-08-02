<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeEvento;
use AppBundle\Entity\CeEventopornivel;
use AppBundle\Entity\CeImagenporevento;
use AppBundle\Entity\CmEventoleido;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class CalendaroEscolarController extends FOSRestController
{

    /**
     * 
     * @Rest\Get("/api/Evento", name="InicioEvento")
     */
    public function indexEvento()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $eventos = $dbm->getRepositorios('CeTipoevento');
            $nivel = $dbm->getRepositorios('Nivel');
            $return = array("tipoeventos" => $eventos, "nivel" => $nivel);

            return new View($return, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Evento/", name="buscarEvento")
     */
    public function buscarEvento()
    {
        try {
            $datos = $_REQUEST;
            $filtros = (array_filter($datos, function ($value) {
                return $value !== '';
            }));
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $eventos = $dbm->BuscarCalendarioescolar($filtros);
            if (!$eventos) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($eventos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

        /**
     * Retorna arreglo de fechas del calendario del alumno
     * @Rest\Get("/api/portalalumno/calendario", name="BuscarCalendarioAlumno")
     */
    public function getCalendarioAlumno()
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $cicloactual = $dbm->getRepositorioById('Ciclo', 'actual', 1);
            $cicloid = $cicloactual->getCicloId();
            $ciclonivel = $dbm->getRepositorioById("CeCiclopornivel", "cicloid", $cicloid);
            if($ciclonivel) {
                $fechainicio = $ciclonivel->getFechainicio()->format('Y-m-d');
                $fechafin = $ciclonivel->getFechafin()->format('Y-m-d');
            }

            foreach ($datos["alumnoid"] as $alumnoid) {
                $ac = $dbm->getOneByParametersRepositorio('CeAlumnoporciclo', ['alumnoid' => $alumnoid, 'cicloid' =>  $cicloid]);
                if ($ac) {
                    $alumnoporcicloid[] = $ac->getAlumnoporcicloid();
                    $gradoid[] =  $ac->getGradoid()->getGradoid();
                }
            }
            $respuesta = $dbm->BuscarCalendarioescolar(array("alumnoporcicloid" => $alumnoporcicloid, "gradoid" => $gradoid, "fechainicio" => $fechainicio, "fechafin" => $fechafin));

            return new View($respuesta, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * 
     * @Rest\Get("/api/Controlescolar/Evento/Imagen/{id}", name="DescargarImagenEvento")
     */
    public function ImagenEvento($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $i = $dbm->getRepositorioById("CeImagenporevento", "imagenporeventoid", $id);
            $imagen = stream_get_contents($i->getArchivo());
            $respuesta =  Api::download($imagen, $i->getArchivoTipo());

            return $respuesta;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Post("/api/Evento" , name="SaveEvento")
     */
    public function SaveEvento()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $imagen = base64_encode($data['imagen']['value']);

            $evento = new CeEvento();
            $evento->setTipoeventoid(empty($data['tipoeventoid']) ? null : $dbm->getRepositorioById('CeTipoevento', 'tipoeventoid', $data['tipoeventoid']));
            $evento->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $evento->setDescripcion(empty($data['descripcion']) ? null : $data['descripcion']);
            $evento->setFechainicio(empty($data['fechainicio']) ? null : new \DateTime($data['fechainicio']));
            $evento->setFechafin(empty($data['fechafin']) ? null : new \DateTime($data['fechafin']));
            $evento->setHorainicio(empty($data['horainicio']) ? null : new \DateTime($data['horainicio']));
            $evento->setHorafin(empty($data['horafin']) ? null : new \DateTime($data['horafin']));
            $evento->setEnviopush(empty($data['enviopush']) ? 0 : $data['enviopush']);
            $evento->setFechaenvio(empty($data['fechaenvio2']) ? null : new \DateTime($data['fechaenvio2']));
            $evento->setHoraenvio(empty($data['horaenvio2']) ? null : new \DateTime($data['horaenvio2']));
            $evento->setEnviado(0);
            $dbm->saveRepositorio($evento);

            if ($data['imagen']) {
                $imagen = new CeImagenporevento();
                $imagen->setEventoid($evento);
                $imagen->setNombrearchivo($data['imagen']['filename']);
                $imagen->setArchivo($data['imagen']['value']);
                $imagen->setArchivosize($data['imagen']['size']);
                $imagen->setArchivotipo($data['imagen']['filetype']);
                $dbm->saveRepositorio($imagen);
            }

            foreach ($data['nivelid'] as $nivelid) {
                $en = new CeEventopornivel();
                $en->setEventoid($evento);
                $en->setNivelid($dbm->getRepositorioById("Nivel", "nivelid", $nivelid));
                $dbm->saveRepositorio($en);
            }
            $dbm->getConnection()->commit();
            return new View(array("mensaje" => "Se ha guardado el registro", "id" => $evento->getEventoid(), "push" => $evento->getEnviopush()), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Evento/{id}" , name="ActualizarEvento")
     */
    public function updateEvento($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $evento = $dbm->getRepositorioById('CeEvento', 'eventoid', $id);

            $evento->setTipoeventoid(empty($data['tipoeventoid']) ? null : $dbm->getRepositorioById('CeTipoevento', 'tipoeventoid', $data['tipoeventoid']));
            $evento->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $evento->setFechainicio(empty($data['fechainicio']) ? null : new \DateTime($data['fechainicio']));
            $evento->setFechafin(empty($data['fechafin']) ? null : new \DateTime($data['fechafin']));
            $evento->setHorainicio(empty($data['horainicio']) ? null : new \DateTime($data['horainicio']));
            $evento->setHorafin(empty($data['horafin']) ? null : new \DateTime($data['horafin']));
            $evento->setEnviopush(empty($data['enviopush']) ? null : $data['enviopush']);
            $evento->setFechaenvio(empty($data['fechaenvio2']) ? null : new \DateTime($data['fechaenvio2']));
            $evento->setHoraenvio(empty($data['horaenvio2']) ? null : new \DateTime($data['horaenvio2']));

            $dbm->removeManyRepositorio("CmEventoleido", 'eventoid', $evento->getEventoid());


            if ($data['imagen']) {
                $eventoimg = $dbm->getRepositorioById('CeImagenporevento', 'imagenporeventoid', $data['imagenporeventoid']);
                $imagen = $eventoimg ? $eventoimg : new CeImagenporevento();
                $imagen->setEventoid($evento);
                $imagen->setNombrearchivo($data['imagen']['filename']);
                $imagen->setArchivo($data['imagen']['value']);
                $imagen->setArchivosize($data['imagen']['size']);
                $imagen->setArchivotipo($data['imagen']['filetype']);
                $dbm->saveRepositorio($imagen);
            } else {
                $dbm->removeManyRepositorio("CeImagenporevento", "eventoid", $id);
            }

            $dbm->saveRepositorio($evento);
            $dbm->removeManyRepositorio("CeEventopornivel", "eventoid", $id);
            foreach ($data['nivelid'] as $nivelid) {
                $en = new CeEventopornivel();
                $en->setEventoid($evento);
                $en->setNivelid($dbm->getRepositorioById("Nivel", "nivelid", $nivelid));
                $dbm->saveRepositorio($en);
            }
            $dbm->getConnection()->commit();
            return new View(array("mensaje" => "Se ha actualizado el registro", "id" => $evento->getEventoid(), "push" => $evento->getEnviopush()), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Evento/{id}", name="EliminarEvento")
     */
    public function deleteEvento($id)
    {
        try {

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $evento = $dbm->getRepositorioById('CeEvento', 'eventoid', $id);
            $dbm->removeManyRepositorio("CeEventopornivel", "eventoid", $id);
            $dbm->removeManyRepositorio("CeImagenporevento", "eventoid", $id);
            $dbm->removeManyRepositorio("CmEventoleido", "eventoid", $id);
            $dbm->removeRepositorio($evento);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. ", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /** Creamos todas las relaciones a los detinatarios
     * @Rest\Get("/api/Evento/Destinatarios/{id}" , name="destinatariosEvento")
     */
    public function destinatariosEvento($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $this->destinatariosProcess($dbm, $id);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public static function destinatariosProcess($dbm, $id)
    {
        $Notificacion = $dbm->getRepositorioById('CeEvento', 'eventoid', $id);
        $alumnos = [];

        $destinatarios = $dbm->getRepositoriosById("CeEventopornivel", "eventoid", $id);
        try {
            $guardarnotificaciones = array();
            //Guardamos notificaciones leidas
            foreach ($destinatarios as $destinatario) {
                if ($destinatario->getNivelid()) {
                    $alumnos =  $dbm->BuscarAlumnosA(["nivelid" => $destinatario->getNivelid(), "alumnoestatusid" => 1]);
                }

                foreach ($alumnos as $a) {
                    $alumno = $dbm->getRepositorioById("CeAlumno", "alumnoid", $a["alumnoid"]);
                    if ($alumno) {

                        $padres = $dbm->getRepositoriosById("CePadresotutoresclavefamiliar", "clavefamiliarid", $a["clavefamiliarid"]);
                        foreach ($padres as $p) {
                            if ($p->getPadresotutoresid()) {
                                $Notificacionleida = $dbm->getOneByParametersRepositorio("CmEventoleido", ["eventoid" => $Notificacion->getEventoid(), "alumnoid" => $a["alumnoid"], "id" =>  $p->getPadresotutoresid()->getPadresotutoresid(), "tipo" => 4]);
                                if (!$Notificacionleida) {
                                    $Notificacionleida = new CmEventoleido();
                                    $Notificacionleida->setEventopornivelid($destinatario);
                                    $Notificacionleida->setEventoid($Notificacion);
                                    $Notificacionleida->setAlumnoid($alumno);
                                    $Notificacionleida->setLeido(0);
                                    $Notificacionleida->setId($p->getPadresotutoresid()->getPadresotutoresid());
                                    $Notificacionleida->setTipo(4);
                                    array_push($guardarnotificaciones, $Notificacionleida);
                                    //$dbm->saveRepositorio($Notificacionleida);
                                }
                            }
                        }


                        $Notificacionleida = $dbm->getOneByParametersRepositorio("CmEventoleido", ["eventoid" => $Notificacion->getEventoid(), "alumnoid" => $a["alumnoid"], "id" =>  $a["alumnoid"], "tipo" => 3]);
                        if (!$Notificacionleida) {
                            $Notificacionleida = new CmEventoleido();
                            $Notificacionleida->setEventopornivelid($destinatario);
                            $Notificacionleida->setEventoid($Notificacion);
                            $Notificacionleida->setAlumnoid($alumno);
                            $Notificacionleida->setLeido(0);
                            $Notificacionleida->setId($a["alumnoid"]);
                            $Notificacionleida->setTipo(3);
                            array_push($guardarnotificaciones, $Notificacionleida);
                            //$dbm->saveRepositorio($Notificacionleida);
                        }
                    }
                }
            }

            $dbm->saveBulkRepositorio($guardarnotificaciones);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Metodo que envia las notificaciones
     * @Rest\Get("/api/Evento/Notificacion/Envio", name="EnvioEventoNotificacion")
     */
    public function EnvioEventoNotificacion()
    {
        try {
            $router = $this->get('router')->getContext();
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $googleApiKey = $dbm->getRepositorioById('Parametros', 'nombre', 'GoogleApiKey');
            $headers = array(
                'Authorization: key=' . $googleApiKey->getValor(),
                'Content-Type: application/json'
            );

            $eventos = $dbm->BuscarEventosPendientes();
            $enviados = array();
            foreach ($eventos as $evento) {
                $imagen = $evento->getEventoid() ? $router->getScheme() . "://" . $router->getHost() . $router->getBaseUrl() . "/api/Controlescolar/Evento/Descargar/" . $evento->getEventoid() : null;

                $destinatarios = $dbm->getRepositoriosModelo("CmEventoleido", ["d"], ["eventoid" => $evento->getEventoid()], false, false, false, "d.id");
                if ($destinatarios) {
                    foreach ($destinatarios as $d) {
                        //Verificamos si la noticia ya ha sido leida para no enviar la push
                        if ($d->getLeido() != 1) {
                            //Obtenemos el usuarioid
                            $usuario = null;
                            switch ($d->getTipo()) {
                                case 1: //Administrativo
                                case 2: //Profesor
                                    break;
                                case 3: //Alumno
                                    $usuario = $dbm->getRepositorioById("Usuario", "alumnoid", $d->getId());
                                    break;
                                case 4: //Padre
                                    $usuario = $dbm->getRepositorioById("Usuario", "padreotutorid", $d->getId());
                                    break;
                            }
                            if ($usuario) {
                                //ANDROID
                                $fields = array(
                                    'condition'        => "'user" . $usuario->getUsuarioid() . "' in topics && 'android' in topics",
                                    'data'    => array(
                                        'body'     => $evento->getNombre(),
                                        'news_type'     => 1,
                                        'news_id'     => $evento->getEventoid(),
                                        'title'    => 'Noticias',
                                        'big_picture' => $imagen
                                    )
                                );
                                FireBase::ServicioFireBase($headers, $fields);

                                //IOS
                                $fields = array(
                                    'condition'        => "'user" . $usuario->getUsuarioid() . "' in topics && !('android' in topics)",
                                    //'condition'        => "'user1" .  "' in topics && !('android' in topics)",
                                    'notification'    => array(
                                        'body'     => $evento->getNombre(),
                                        'title'    => 'Noticias',
                                        'sound' => 'default',
                                        'big_picture' => $imagen
                                    ),
                                    'data' => array('news_type' => 1, 'news_id' => $evento->getEventoid())
                                );
                                FireBase::ServicioFireBase($headers, $fields);

                                $enviados[] = ["notificacionid" => $d->getEventoleidoid(), "usuarioid" => $usuario->getUsuarioid()];
                            }
                        }
                    }
                    $evento->setEnviado(1);
                    $dbm->saveRepositorio($notificacion);
                }
            }
            return new View($enviados, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
