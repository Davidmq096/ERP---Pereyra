<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\DB\DbmTransporte;
use AppBundle\DB\DbmControlescolar;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier
 */
class UsuarioController extends FOSRestController
{

    /**
     * Login para los usurios externo
     * @Rest\Post("/api/Loginexterno", name="BuscarLoginExterno")
     */
    public function getBuscarLoginexterno()
    {
        try {
            $data = $_REQUEST;
            $dbm = $this->get("db_manager");
            $entidad = $dbm->getOneByParametersRepositorio("BrUsuarioexterno", array("usuario" => $data["cuenta"], "contrasena" => $data["clave"]));
            if (!$entidad) {
                return new View("Los datos son incorrectos. Intenta de nuevo por favor", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene la foto del usuario logeado
     * @Rest\Get("/api/Usuario/Foto/{id}", name="UsuarioBuscarFoto")
     */
    public function getUsuarioFoto($id)
    {
        $dbm = $this->get("db_manager");
        $imagen = $dbm->getRepositorioById('Imagenporusurio', 'usuarioid', $id);
        if (!$imagen) {
            return new View("No se pudo guardar la imagen", Response::HTTP_PARTIAL_CONTENT);
        }
        $imagen = stream_get_contents($imagen->getFotografia());
        return new View($imagen, Response::HTTP_OK);
    }

    /**
     * Guarda la foto tomada de perfil del usuario
     * @Rest\Post("/api/Usuario/Foto", name="UsuarioGuardarFoto")
     */
    public function usuarioGuardarFoto()
    {
        $dbm = $this->get("db_manager");
        $data = $_REQUEST;

        try {
            $entidad = $dbm->getRepositorioById('Usuario', 'usuarioid', $data["id"]);
            if (empty($entidad)) {
                $return = array("mensaje" => "Error no se encontró ningún usuario con el id " . $data['id']);
                return new View($return, Response::HTTP_NOT_FOUND);
            } else {
                //Eliminamos Nacionalidad
                $imagenes = $dbm->getRepositoriosById('Imagenporusurio', 'usuarioid', $data['id']);
                foreach ($imagenes as $n) {
                    $dbm->removeRepositorio($n);
                }

                $dbm->getConnection()->beginTransaction();
                $IxU = new \AppBundle\Entity\Imagenporusurio();
                $IxU->setUsuarioid($entidad);
                $IxU->setFotografia($data['foto']);

                $dbm->saveRepositorio($IxU);
                $dbm->getConnection()->commit();

                $return = array('msj' => "Se ha guardado la imagen");
                return new View($return, Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View("No se pudo guardar la imagen" . $e, Response::HTTP_PARTIAL_CONTENT);
        }
    }

    /**
     * Funcion para eliminar la foto de perfil del usuario
     * @Rest\Delete("/api/Usuario/Foto/{id}", name="UsuarioRomoveFoto")
     */
    public function usuarioEliminarFoto($id)
    {
        $dbm = $this->get("db_manager");
        $data = $_REQUEST;

        try {
            $entidad = $dbm->getRepositorioById('Usuario', 'usuarioid', $id);
            if (empty($entidad)) {
                $return = array("mensaje" => "Error no se encontró ningún usuario con el id " . $id);
                return new View($return, Response::HTTP_NOT_FOUND);
            } else {
                //Eliminamos Nacionalidad
                $imagenes = $dbm->getRepositoriosById('Imagenporusurio', 'usuarioid', $id);
                foreach ($imagenes as $n) {
                    $dbm->removeRepositorio($n);
                }

                return new View("Se ha eliminado la imagen", Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View("No se pudo guardar la imagen" . $e, Response::HTTP_PARTIAL_CONTENT);
        }
    }

    /**
     * Funcion para eliminar la foto de perfil del usuario
     * @Rest\Get("/api/Usuario/Escaner", name="UsuarioEscaner")
     */
    public function usuarioEscaner()
    {
        try {
            $data = $_REQUEST;

            switch ($data["tipo"]) {
                case "b": //Boleto transporte
                    $dbmT = new DbmTransporte($this->get("db_manager")->getEntityManager());
                    $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());

                    $infoboleto = $dbmT->BuscarMisboletos(["boletoid" => $data["id"]])[0];
                    $alumno = $dbma->BuscarAlumnosA(["alumnoid" => $infoboleto["alumnoid"]])[0];
                    $alumno["foto"] = $alumno["foto"] ? stream_get_contents($alumno["foto"]) : null;
                    $respuesta = array_merge($infoboleto, $alumno);

                    $ruta = $dbmT->getRepositorioById('TpRuta', 'rutaid', $data["rutaid"]);
                    if ($ruta) {
                        if ($data["rutaid"] != $infoboleto["rutaid"]) {
                            return new View(["msj" => "El boleto no corresponde a la ruta", "informacion" => $respuesta], Response::HTTP_PARTIAL_CONTENT);
                        }
                    }

                    $hoy = (new \DateTime())->settime(0, 0);
                    $fechaboleto = new \DateTime($infoboleto['date']);
                    if ($hoy != $fechaboleto) {
                        return new View(["msj" => "El boleto no aplica al día de hoy", "informacion" => $respuesta], Response::HTTP_PARTIAL_CONTENT);
                    }

                    if ($infoboleto["escaneado"]) {
                        return new View(["msj" => "El boleto ya ha sido escaneado", "informacion" => $respuesta], Response::HTTP_PARTIAL_CONTENT);
                    }
                    $boleto = $dbmT->getRepositorioById('TpBoleto', 'boletoid', $infoboleto["boletoid"]);
                    $boleto->setEscaneado(true);
                    $dbmT->saveRepositorio($boleto);
                    break;
                case "c": //Credencial transporte
                    $dbmT = new DbmTransporte($this->get("db_manager")->getEntityManager());
                    $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());

                    $usuario = $dbmT->getRepositorioById('Usuario', 'usuarioid', $data["id"]);
                    if (!$usuario) {
                        return new View(["msj" => "QR invalido"], Response::HTTP_PARTIAL_CONTENT);
                    }
                    if (!$usuario->getAlumnoid()) {
                        return new View(["msj" => "El usuario no es un alumno"], Response::HTTP_PARTIAL_CONTENT);
                    }
                    $alumno = $dbma->BuscarAlumnosA(["alumnoid" => $usuario->getAlumnoid()])[0];
                    $ciclo = $dbmT->getRepositorioById('Ciclo', 'actual', 1);
                    $ruta = $dbmT->getRepositorioById('TpRuta', 'rutaid', $data["rutaid"]);
                    $data["rutaid"] = $ruta  ? $data["rutaid"] : null;
                    $contrato = $dbmT->BuscarContrato(["matricula" => $alumno["matricula"], "rutaid" => $data["rutaid"], "cicloid" => $ciclo->getCicloid()])[0];
                    if (!$contrato) {
                        $msj = "No se cuenta con un contrato en el ciclo actual" . ($ruta ? " para la ruta indicada" : "");
                        return new View(["msj" => $msj, "informacion" => $alumno], Response::HTTP_PARTIAL_CONTENT);
                    }
                    $respuesta = array_merge($contrato, $alumno);
                    switch ($contrato["contratoestatusid"]) {
                        case 2:
                            return new View(["msj" => "El contrato se encuentra cancelado", "informacion" => $respuesta], Response::HTTP_PARTIAL_CONTENT);
                            break;
                        case 3:
                            return new View(["msj" => "El contrato se encuentra suspendido", "informacion" => $respuesta], Response::HTTP_PARTIAL_CONTENT);
                            break;
                        case 4:
                            return new View(["msj" => "El contrato ha finalizado", "informacion" => $respuesta], Response::HTTP_PARTIAL_CONTENT);
                            break;
                    }
                    break;
                default:
                    return new View(["msj" => "QR invalido"], Response::HTTP_PARTIAL_CONTENT);
                    break;
            }
            return new View(["msj" => "OK", "informacion" => $respuesta], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e, Response::HTTP_PARTIAL_CONTENT);
        }
    }
}
