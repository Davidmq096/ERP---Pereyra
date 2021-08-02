<?php

namespace AppBundle\Controller\Comunicacion;

use AppBundle\DB\DbmControlescolar;
use AppBundle\DB\DbmComunicacion;
use AppBundle\Entity\CmNotificacion;
use AppBundle\Entity\CmNotificaciondestinatarios;
use AppBundle\Entity\CmNotificacionesleidas;
use AppBundle\Dominio\FireBase;
use DateTime;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class NotificacionController extends FOSRestController
{
    /**
     * Retorna arreglo de Notificacion en base a los parametros enviados
     * @Rest\Post("/api/Comunicacion/Notificacion/", name="BuscarNotificacion")
     */
    public function getNotificacion()
    {
        try {
            $datos = trim(file_get_contents("php://input"));
            $filtros = json_decode($datos, true);
            $filtros = array_filter($filtros);
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $notificaciones = $dbm->BuscarNotificacion($filtros);

            if (!$notificaciones) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($notificaciones, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Comunicacion/Notificacion/{id}", name="EliminarNotificacion")
     */
    public function deleteNotificacion($id)
    {
        try {
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio("CmNotificacionesleidas", 'notificacionid', $id);
            $dbm->removeManyRepositorio("CmNotificaciondestinatarios", 'notificacionid', $id);
            $notificacion = $dbm->getRepositorioById('CmNotificacion', 'notificacionid', $id);
            $dbm->removeRepositorio($notificacion);

            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Comunicacion/Notificacion/Captura", name="indexNotificacionCaptura")
     */
    public function indexNotificacionCaptura()
    {
        try {
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $niveles = $dbm->getRepositoriosById("Nivel", "activo", 1);
            $grados = $dbm->getRepositoriosById("Grado", "activo", 1);
            $limitetitulo = $dbm->getRepositorioById('Parametros', 'nombre', 'ComunicacionLimiteCaracteresTitulo');
            $limitedesc = $dbm->getRepositorioById('Parametros', 'nombre', 'ComunicacionLimiteCaracteresDescripcion');

            $cicloactual = $dbm->getRepositorioById("Ciclo", "actual", 1);
            $grupos = $dbm->getByParametersRepositorios(
                "CeGrupo",
                array("cicloid" => $cicloactual->getCicloid(), "tipogrupoid" => 1)
            );

            return new View(array(
                "nivel" => $niveles,
                "grado" => $grados,
                "limitetitulo" => $limitetitulo ? $limitetitulo->getValor() : null,
                "limitedesc" => $limitedesc ? $limitedesc->getValor() : null,
                "grupo" => $grupos
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna los destinatarios de una notificacion al editar
     * @Rest\Get("/api/Comunicacion/Notificacion/Destinatarios/{notificacionid}", name="DestinatariosNotificacion")
     */
    public function DestinatariosNotificacion($notificacionid)
    {
        try {
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $destinatarios = $dbm->getRepositoriosById("CmNotificaciondestinatarios", "notificacionid", $notificacionid);
            foreach ($destinatarios as $d) {
                $destinatario = array("nivelid" => $d->getNivelid() ? $d->getNivelid() : 0, "gradoid" => $d->getGradoid() ? $d->getGradoid() : 0, "grupoid" => $d->getGrupoid() ? $d->getGrupoid() : 0, "alumnoid" => $d->getAlumnoid() ? $d->getAlumnoid() : 0);
                $arraydestinatarios[] = $destinatario;
            }
            if (!$arraydestinatarios) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($arraydestinatarios, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Post("/api/Comunicacion/Notificacion" , name="GuardarNotificacion")
     */
    public function SaveNotificacion()
    {
        try {
            $datos = trim(file_get_contents("php://input"));
            $data = json_decode($datos, true);
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $fecha = new \DateTime($data["fecha"]["date"]["year"] . "-" . $data["fecha"]["date"]["month"] . "-" . $data["fecha"]["date"]["day"]);

            $dbm->getConnection()->beginTransaction();
            $Notificacion = new CmNotificacion();
            $Notificacion->setEnviarpadres($data["enviarpadres"]);
            $Notificacion->setEnviaralumnos($data["enviaralumnos"]);

            $Notificacion->setFecha($fecha);
            $Notificacion->setHora(new \DateTime($data['hora']));

            $Notificacion->setTitulo($data["contenido"]["titulo"]);
            $Notificacion->setMensaje($data["contenido"]["contenido"]);
            $Notificacion->setVinculo($data["contenido"]["vinculo"]);
            $Notificacion->setFormato($data["contenido"]["imagen"]);
            $Notificacion->setUsuarioid($dbm->getRepositorioById("Usuario", "usuarioid", $data["usuarioid"]));
            $Notificacion->setTipoimagen($data["tipomsj"]);
            $Notificacion->setEstatus(0);
            $Notificacion->setFechamodificacion(new \DateTime());
            $dbm->saveRepositorio($Notificacion);

            //Guardamos notificaciones destinatarios
            foreach ($data["destinatarios"]["nivel"] as $n) {
                $Destinatario = new CmNotificaciondestinatarios();
                $Destinatario->setNotificacionid($Notificacion);
                $Destinatario->setNivelid($n["nivelid"]);
                $dbm->saveRepositorio($Destinatario);
            }
            foreach ($data["destinatarios"]["grado"] as $g) {
                $Destinatario = new CmNotificaciondestinatarios();
                $Destinatario->setNotificacionid($Notificacion);
                $Destinatario->setNivelid($g["nivelid"]);
                $Destinatario->setGradoid($g["gradoid"]);
                $dbm->saveRepositorio($Destinatario);
            }
            foreach ($data["destinatarios"]["grupo"] as $gru) {
                $Destinatario = new CmNotificaciondestinatarios();
                $Destinatario->setNotificacionid($Notificacion);
                $Destinatario->setNivelid($gru["nivelid"]);
                $Destinatario->setGradoid($gru["gradoid"]);
                $Destinatario->setGrupoid($gru["grupoid"]);
                $dbm->saveRepositorio($Destinatario);
            }
            foreach ($data["destinatarios"]["destinarios"] as $d) {
                $Destinatario = new CmNotificaciondestinatarios();
                $Destinatario->setNotificacionid($Notificacion);
                $Destinatario->setNivelid($d["nivelid"]);
                $Destinatario->setGradoid($d["gradoid"]);
                $Destinatario->setGrupoid($d["grupoid"]);
                $Destinatario->setAlumnoid($d["alumnoid"]);
                $dbm->saveRepositorio($Destinatario);
            }
            if ($data["matriculas"]) {
                $matriculas = explode(",", $data["matriculas"]);
                foreach ($matriculas as $matricula) {
                    $alumno = $dbma->BuscarAlumnosA(["matricula" => $matricula, "precision" => true])[0];
                    if ($alumno) {
                        $Destinatario = new CmNotificaciondestinatarios();
                        $Destinatario->setNotificacionid($Notificacion);
                        $Destinatario->setAlumnoid($alumno["alumnoid"]);
                        $Destinatario->setNivelid($alumno["nivelid"]);
                        $Destinatario->setGradoid($alumno["gradoid"]);
                        $Destinatario->setGrupoid($alumno["grupoid"]);
                        $dbm->saveRepositorio($Destinatario);
                    } else {
                        return new View("La matricula " . $matricula . " no existe", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }

            $dbm->getConnection()->commit();

            return new View(["msj" => "La notificación ha sido actualizada, dependiendo de la cantidad de usuarios, la consulta de notificaciones recibidas puede demorar en verse reflejada.", "notificacionid" => $Notificacion->getNotificacionid()], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Comunicacion/Notificacion/{id}" , name="ActualizarNotificacion")
     */
    public function updateNotificacion($id)
    {
        try {
            $datos = trim(file_get_contents("php://input"));
            $data = json_decode($datos, true);
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $fecha = new \DateTime($data["fecha"]["date"]["year"] . "-" . $data["fecha"]["date"]["month"] . "-" . $data["fecha"]["date"]["day"]);

            $dbm->getConnection()->beginTransaction();
            $Notificacion = $dbm->getRepositorioById('CmNotificacion', 'notificacionid', $id);
            $Notificacion->setEnviarpadres($data["enviarpadres"]);
            $Notificacion->setEnviaralumnos($data["enviaralumnos"]);
            $Notificacion->setFecha($fecha);
            $Notificacion->setHora(new \DateTime($data['hora']));
            $Notificacion->setTitulo($data["contenido"]["titulo"]);
            $Notificacion->setMensaje($data["contenido"]["contenido"]);
            $Notificacion->setVinculo($data["contenido"]["vinculo"]);
            $Notificacion->setTipoimagen($data["tipomsj"]);
            if ($data["tipomsj"] == 1) {
                $Notificacion->setFormato(null);
            } else {
                if ($data["contenido"]["imagen"]) {
                    $Notificacion->setFormato($data["contenido"]["imagen"]);
                }
            }
            $Notificacion->setUsuarioid($dbm->getRepositorioById("Usuario", "usuarioid", $data["usuarioid"]));
            $Notificacion->setTipoimagen($data["tipomsj"]);
            $Notificacion->setFechamodificacion(new \DateTime());
            $dbm->saveRepositorio($Notificacion);

            $dbm->removeManyRepositorio("CmNotificacionesleidas", 'notificacionid', $id);
            $dbm->removeManyRepositorio("CmNotificaciondestinatarios", 'notificacionid', $id);

            //Guardamos notificaciones destinatarios
            foreach ($data["destinatarios"]["nivel"] as $n) {
                $Destinatario = new CmNotificaciondestinatarios();
                $Destinatario->setNotificacionid($Notificacion);
                $Destinatario->setNivelid($n["nivelid"]);
                $dbm->saveRepositorio($Destinatario);
            }
            foreach ($data["destinatarios"]["grado"] as $g) {
                $Destinatario = new CmNotificaciondestinatarios();
                $Destinatario->setNotificacionid($Notificacion);
                $Destinatario->setNivelid($g["nivelid"]);
                $Destinatario->setGradoid($g["gradoid"]);
                $dbm->saveRepositorio($Destinatario);
            }
            foreach ($data["destinatarios"]["grupo"] as $gru) {
                $Destinatario = new CmNotificaciondestinatarios();
                $Destinatario->setNotificacionid($Notificacion);
                $Destinatario->setNivelid($gru["nivelid"]);
                $Destinatario->setGradoid($gru["gradoid"]);
                $Destinatario->setGrupoid($gru["grupoid"]);
                $dbm->saveRepositorio($Destinatario);
            }
            foreach ($data["destinatarios"]["destinarios"] as $d) {
                $Destinatario = new CmNotificaciondestinatarios();
                $Destinatario->setNotificacionid($Notificacion);
                $Destinatario->setNivelid($d["nivelid"]);
                $Destinatario->setGradoid($d["gradoid"]);
                $Destinatario->setGrupoid($d["grupoid"]);
                $Destinatario->setAlumnoid($d["alumnoid"]);
                $dbm->saveRepositorio($Destinatario);
            }
            if ($data["matriculas"]) {
                $matriculas = explode(",", $data["matriculas"]);
                foreach ($matriculas as $matricula) {
                    $alumno = $dbma->BuscarAlumnosA(["matricula" => $matricula, "precision" => true])[0];
                    if ($alumno) {
                        $Destinatario = new CmNotificaciondestinatarios();
                        $Destinatario->setNotificacionid($Notificacion);
                        $Destinatario->setAlumnoid($alumno["alumnoid"]);
                        $Destinatario->setNivelid($alumno["nivelid"]);
                        $Destinatario->setGradoid($alumno["gradoid"]);
                        $Destinatario->setGrupoid($alumno["grupoid"]);
                        $dbm->saveRepositorio($Destinatario);
                    } else {
                        return new View("La matricula " . $matricula . " no existe", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }

            $dbm->getConnection()->commit();
            return new View(["msj" => "La notificación ha sido actualizada, dependiendo de la cantidad de usuarios, la consulta de notificaciones recibidas puede demorar en verse reflejada.", "notificacionid" => $Notificacion->getNotificacionid()], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Clona una notificacion
     * @Rest\Post("/api/Comunicacion/Notificacion/Copiar/{notificacionid}", name="ClonarNotificacion")
     */
    public function ClonarNotificacion($notificacionid)
    {
        try {
            $datos = trim(file_get_contents("php://input"));
            $data = json_decode($datos, true);

            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());

            $notificacion = $dbm->getRepositorioById("CmNotificacion", "notificacionid", $notificacionid);

            $dbm->getConnection()->beginTransaction();
            $Notificacion = clone $notificacion;
            $fecha = new \DateTime($data["date"]);
            $Notificacion->setFecha($fecha);
            $Notificacion->setHora(new \DateTime($data['hora']));
            $Notificacion->setEstatus(0);
            $dbm->saveRepositorio($Notificacion);

            $destinatarios = $dbm->getRepositoriosById("CmNotificaciondestinatarios", "notificacionid", $notificacionid);
            foreach ($destinatarios as $destinatario) {
                $Destinatario = clone $destinatario;
                $Destinatario->setNotificacionid($Notificacion);
                $dbm->saveRepositorio($Destinatario);
            }

            $notificacionesleidas = $dbm->getRepositoriosById("CmNotificacionesleidas", "notificacionid", $notificacionid);
            foreach ($notificacionesleidas as $leidas) {
                $Leidas = clone $leidas;
                $Leidas->setLeido(0);
                $Leidas->setHecho(null);
                $Leidas->setNotificacionid($Notificacion);
                $dbm->saveRepositorio($Leidas);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /** Creamos todas las relaciones a los detinatarios
     * @Rest\Post("/api/Comunicacion/Notificacion/Destinatarios/{id}" , name="ActualizarNotificacionDestinatarios")
     */
    public function destinatarios($id)
    {
        try {
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $Notificacion = $dbm->getRepositorioById('CmNotificacion', 'notificacionid', $id);

            $destinatarios = $dbm->getRepositoriosById("CmNotificaciondestinatarios", "notificacionid", $Notificacion->getNotificacionid());

            $guardarnotificaciones = array();
            //Guardamos notificaciones leidas
            foreach ($destinatarios as $destinatario) {
                if ($destinatario->getAlumnoid()) {
                    $alumnos =  $dbma->BuscarAlumnosA(["alumnoid" => $destinatario->getAlumnoid(), "alumnoestatusid" => 1]);
                } elseif ($destinatario->getGrupoid()) {
                    $alumnos =   $dbma->BuscarAlumnosA(["grupoid" => $destinatario->getGrupoid(), "alumnoestatusid" => 1]);
                } elseif ($destinatario->getGradoid()) {
                    $alumnos =   $dbma->BuscarAlumnosA(["gradoid" => $destinatario->getGradoid(), "alumnoestatusid" => 1]);
                } elseif ($destinatario->getNivelid()) {
                    $alumnos =   $dbma->BuscarAlumnosA(["nivelid" => $destinatario->getNivelid(), "alumnoestatusid" => 1]);
                }

                foreach ($alumnos as $a) {
                    $alumno = $dbm->getRepositorioById("CeAlumno", "alumnoid", $a["alumnoid"]);
                    if ($alumno) {
                        if ($Notificacion->getEnviarpadres()) {
                            $padres = $dbm->getRepositoriosById("CePadresotutoresclavefamiliar", "clavefamiliarid", $a["clavefamiliarid"]);
                            foreach ($padres as $p) {
                                if ($p->getPadresotutoresid()) {
                                    $Notificacionleida = $dbm->getOneByParametersRepositorio("CmNotificacionesleidas", ["notificacionid" => $Notificacion->getNotificacionid(), "alumnoid" => $a["alumnoid"], "id" =>  $p->getPadresotutoresid()->getPadresotutoresid(), "tipo" => 4]);
                                    if (!$Notificacionleida) {
                                        $Notificacionleida = new CmNotificacionesleidas();
                                        $Notificacionleida->setNotificaciondestinatarioid($destinatario);
                                        $Notificacionleida->setNotificacionid($Notificacion);
                                        $Notificacionleida->setAlumnoid($alumno);
                                        $Notificacionleida->setLeido(0);
                                        $Notificacionleida->setId($p->getPadresotutoresid()->getPadresotutoresid());
                                        $Notificacionleida->setTipo(4);
                                        array_push($guardarnotificaciones, $Notificacionleida);
                                        //$dbm->saveRepositorio($Notificacionleida);
                                    }
                                }
                            }
                        }
                        if ($Notificacion->getEnviaralumnos()) {
                            $Notificacionleida = $dbm->getOneByParametersRepositorio("CmNotificacionesleidas", ["notificacionid" => $Notificacion->getNotificacionid(), "alumnoid" => $a["alumnoid"], "id" =>  $a["alumnoid"], "tipo" => 3]);
                            if (!$Notificacionleida) {
                                $Notificacionleida = new CmNotificacionesleidas();
                                $Notificacionleida->setNotificaciondestinatarioid($destinatario);
                                $Notificacionleida->setNotificacionid($Notificacion);
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
            }
            $dbm->saveBulkRepositorio($guardarnotificaciones);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * Retorna imagen para notificacion
     * @Rest\Get("/api/Comunicacion/Notificacion/Imagen/{news_id}", name="GeneradorImagenNotificacion")
     */
    public function GeneradorImagenNotificacion($news_id)
    {
        try {
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $noticia = $dbm->getRepositorioById("CmNotificacion", "notificacionid", $news_id);
            // Get content type
            $contentType = 'image/png';
            $stream = stream_get_contents($noticia->getFormato());
            $array = explode(';', $stream);

            if (strpos($array[0], 'data:') === 0) {
                $contentType = substr($array[0], 5);
            }

            // Get image
            $data = array_pop($array);
            if (strpos($data, 'base64,') === 0) {
                $data = substr($data, 7);
            }

            $response = new Response();
            $response->headers->set('Content-Type', $contentType);
            $response->setContent(base64_decode($data));

            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Metodo que envia las notificaciones
     * @Rest\Get("/api/Comunicacion/Notificacion/Envio", name="EnvioNotificacion")
     */
    public function EnvioNotificacion()
    {
        try {
            $router = $this->get('router')->getContext();
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());

            $googleApiKey = $dbm->getRepositorioById('Parametros', 'nombre', 'GoogleApiKey');
            $headers = array(
                'Authorization: key=' . $googleApiKey->getValor(),
                'Content-Type: application/json'
            );

            $notificaciones = $dbm->BuscarNotificacionesPendientes();
            $enviados = array();
            foreach ($notificaciones as $notificacion) {
                $imagen = $notificacion->getFormato() ? $router->getScheme() . "://" . $router->getHost() . $router->getBaseUrl() . "/api/Comunicacion/Notificacion/Imagen/" . $notificacion->getNotificacionid() . "?" . $notificacion->getFechamodificacion()->getTimestamp() : null;

                $destinatarios = $dbm->getRepositoriosModelo("CmNotificacionesleidas", ["d"], ["notificacionid" => $notificacion->getNotificacionid()], false, false, false, "d.id");
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
                                        'body'     => $notificacion->getTitulo(),
                                        'news_type'     => 1,
                                        'news_id'     => $notificacion->getNotificacionid(),
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
                                        'body'     => $notificacion->getTitulo(),
                                        'title'    => 'Noticias',
                                        'sound' => 'default',
                                        'big_picture' => $imagen
                                    ),
                                    'data' => array('news_type' => 1, 'news_id' => $notificacion->getNotificacionid())
                                );
                                FireBase::ServicioFireBase($headers, $fields);

                                $enviados[] = ["notificacionid" => $d->getNotificaciondestinatarioid(), "usuarioid" => $usuario->getUsuarioid()];
                            }
                        }
                    }
                    $notificacion->setEstatus(1);
                    $dbm->saveRepositorio($notificacion);
                }
            }
            return new View($enviados, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna arreglo de notificaciones a la app de padres he hijos
     * @Rest\Get("/api/portalalumno/notificaciones", name="BuscarNotificacionesAPP")
     */
    public function getNotificacionesAPP()
    {
        try {
            $datos = $_REQUEST;
            $router = $this->get('router')->getContext();
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());

            $notificaciones = $dbm->BuscarNotificacionesAPP($datos);
            foreach ($notificaciones as $key => $n) {
                if ($n["url"]) {
                    $url = $n["url"];
                    $notificaciones[$key]["url"] = !preg_match("~^(?:f|ht)tps?://~i", $url) ? "https://" . $url : $url;
                }
                if ($n['is_big_image'] != null) {
                    $notificaciones[$key]["image_src"] = $router->getScheme() . "://" .
                        $router->getHost() . $router->getBaseUrl() . "/api/Comunicacion/Notificacion/Imagen/" . $n["idinterno"] . "?" . (new \DateTime())->getTimestamp();
                } else {
                    $notificaciones[$key]["image_src"] = NULL;
                }
                $notificaciones[$key]['is_big_image'] = intval($n['is_big_image']);
            }
            return new View($notificaciones, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Put("/api/portalalumno/notificaciones/{notificacionid}" , name="ActualizarNotificacionAPP")
     */
    public function updateNotificacionAPP($notificacionid)
    {
        try {
            $datos = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmComunicacion($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $Notificacionleida = $dbm->getOneByParametersRepositorio('CmNotificacionesleidas', array("id" => $datos["id"], "notificacionid" => $notificacionid, "tipo" => $datos["tipo"]));
            $Notificacionleida->setLeido($datos["leido"] == 0 ? null : $datos["leido"]);
            $Notificacionleida->setHecho($datos["hecho"] == 0 ? null : $datos["hecho"]);
            $dbm->saveRepositorio($Notificacionleida);

            $dbm->getConnection()->commit();
            return new View(array("success" => true, "message" => "La noticia ha sido actualizada."), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
