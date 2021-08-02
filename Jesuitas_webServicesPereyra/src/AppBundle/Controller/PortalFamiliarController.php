<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\DB\DbmMaternal;
use AppBundle\DB\DbmPortalFamiliar;
use AppBundle\DB\DbmCobranza;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\MaHigienemarcado;
use AppBundle\Entity\MaInventariomarcado;
use AppBundle\Entity\CePadresotutoresdomicilio;
use AppBundle\Entity\CePadresotutoresfacturacion;
use AppBundle\Entity\CeHermano;
use AppBundle\Entity\CePersonaautorizadarecogerporalumno;
use AppBundle\Entity\CePersonaautorizadarecoger;
use AppBundle\Entity\CePadresotutoresnacionalidad;
use AppBundle\Entity\Sesion;
use AppBundle\Entity\CjBitacorapagoconbanco;
use AppBundle\Entity\CjDatoadicionalporbitacorapagoconbanco;
use AppBundle\Entity\CjPago;
use AppBundle\Entity\CjPagodetalle;
use AppBundle\Entity\CjPagoformapago;
use AppBundle\Entity\CjFacturacorreo;
use AppBundle\Entity\CjFactura;
use AppBundle\Dominio\ClasificadorAlumno;
use AppBundle\DB\DbmPagoLinea;
use AppBundle\DB\DbmPagos;


use AppBundle\Entity\CjReldocumentoporpagardatofacturacion;
use AppBundle\Controller\lib\ReCaptcha\ReCaptcha;

use AppBundle\Controller\lib\MIT\MIT;


/**
 * @author Inceptio
 */
class PortalFamiliarController extends FOSRestController
{
    /**
     * @Rest\Post("/api/portalfamiliar/registro" , name="Registro")
     */
    public function Registro()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");

            $apellidos = $dbm->BuscarAlumnosMismaFamilia($decoded);
            if (!$apellidos) {
                return new View("Los datos capturados no coinciden con la matrícula(s) capturada(s)", Response::HTTP_PARTIAL_CONTENT);
            } else {
                if (count($apellidos) > 1) {
                    return new View("Las matrículas son de familias diferentes.", Response::HTTP_PARTIAL_CONTENT);
                }
            }

            function removeAccents($string)
            {
                return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'))), ' '));
            }

            //if (($decoded["padremadreotutor"]==1 && removeAccents($apellidos[0]["apellidopaterno"])!=removeAccents($decoded["apellidopaterno"])) || ($decoded["padremadreotutor"]==2 && removeAccents($apellidos[0]["apellidomaterno"])!=removeAccents($decoded["apellidopaterno"]))){
            if (
                removeAccents($apellidos[0]["apellidopaterno"]) == removeAccents($decoded["apellidopaterno"]) ||
                removeAccents($apellidos[0]["apellidomaterno"]) == removeAccents($decoded["apellidomaterno"]) ||
                removeAccents($apellidos[0]["apellidopaterno"]) == removeAccents($decoded["apellidomaterno"]) ||
                removeAccents($apellidos[0]["apellidomaterno"]) == removeAccents($decoded["apellidopaterno"])
            ) {
            } else {
                return new View("Los apellidos no coinciden con la familia del alumno.", Response::HTTP_PARTIAL_CONTENT);
            }
            $decoded["clavefamiliarid"] = $apellidos[0]["clavefamiliarid"];
            $padremadreotutor = $dbm->BuscarPadrePorApellido($decoded);
            if ($padremadreotutor) {
                $padremadreotutor = $padremadreotutor[0];
            } else {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            $padremadreotutor->setCorreo($decoded["correo"]);
            $dbm->saveRepositorio($padremadreotutor);

            $parametros = $dbm->getRepositorioById("Parametros", "nombre", "ServicioUsuario");
            $serviciousuario = $parametros->getValor();
            //$serviciousuario="http://192.168.0.13:8015/api/usuario";

            $campos = '{
                "Usuario": {
                  "Seleccionar": false,
                  "PersonaNombreCompleto": "",
                  "PersonaNombre": null,
                  "TipoUsuario": null,
                  "UsuarioId": 0,
                  "PersonaId": null,
                  "AlumnoId": null,
                  "ProfesorId": null,
                  "PadreoTutorId": ' . $padremadreotutor->getPadresotutoresid() . ',
                  "TipoUsuarioId": 4,
                  "Cuenta": "' . $padremadreotutor->getCorreo() . '",
                  "Contrasena": "",
                  "ID": "",
                  "ReiniciarContrasena": 1,
                  "Activo": true,
                  "UsuarioEnmascarado": null
                },
                "UsuarioAutenticado": 
                {
                  "Cuenta": "rmedrano"
                },
                "DireccionIP": "::1",
                "Perfiles": [
                  
                ],
                "Permisos": [
                  
                ],
                "Grados": [
                  
                ],
                "Ciclos": [
                  
                ]
              }';
            $fields = json_decode($campos);
            $headers = array('Content-Type: application/json');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $serviciousuario);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            if ($result) {
                $mensaje = $result;
                if (strpos($mensaje, "}")) {
                    $mensaje = "El usuario ha sido registrado, se ha enviado un mensaje al correo electrónico capturado con las instrucciones para acceder al portal de padres de familia.";
                }
                return new View(array("mensaje" => $mensaje), Response::HTTP_OK);
            } else {
                return new View("No se actualizo el registro.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/portalfamiliar/daily-menu/{menuId}" , name="ActualizarMenuVisto")
     */
    public function updateMenuVisto($menuId)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $datos = json_decode($content, true);
            if (!$datos) {
                parse_str(file_get_contents("php://input"), $datos);
            }

            //$data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($datos["visto"] == 0) {
                $visto = null;
            } else {
                $visto = $datos["visto"];
            }

            $menu = $dbm->getRepositorioById('MaAsignacionmenu', "asignacionmenuid", $menuId);
            if ($menu) {
                $menu->setVisto($visto);
                $menu->setFechavisto(new \DateTime());
                $dbm->saveRepositorio($menu);
            } else {
                return new View(array("success" => false, "message" => "No se encontro ningun registro."), Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->commit();
            return new View(array("success" => true, "message" => "El menú ha sido actualizado."), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * @Rest\Put("/api/portalfamiliar/report/{reportId}" , name="ActualizarInformeVisto")
     */
    public function updateInformeVisto($reportId)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $datos = json_decode($content, true);
            if (!$datos) {
                parse_str(file_get_contents("php://input"), $datos);
            }

            //$data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($datos["visto"] == 0) {
                $visto = null;
            } else {
                $visto = $datos["visto"];
            }

            $informe = $dbm->getRepositorioById('MaInforme', "informeid", $reportId);
            if ($informe) {
                $informe->setVisto($visto);
                $informe->setFechavisto(new \DateTime());
                $dbm->saveRepositorio($informe);
            } else {
                return new View(array("success" => false, "message" => "No se encontro ningun registro."), Response::HTTP_PARTIAL_CONTENT);
            }



            $dbm->getConnection()->commit();
            return new View(array("success" => true, "message" => "El informe ha sido actualizado."), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * @Rest\Put("/api/portalfamiliar/report/{reportId}/hygiene/{hygieneId}" , name="ActualizarHygieneHecho")
     */
    public function updateHigieneHecho($reportId, $hygieneId)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $datos = json_decode($content, true);
            if (!$datos) {
                parse_str(file_get_contents("php://input"), $datos);
            }

            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($datos["hecho"] == 0) {
                $hecho = 0;
            } else {
                $hecho = 1;
            }
            if ($datos["archivado"] == 0) {
                $archivado = 0;
            } else {
                $archivado = 1;
            }
            /*
            foreach ($hijos as $hijo){
                $informes = $dbm->BuscarInforme(array("alumnoid"=>$hijo->getAlumnoid()));
                foreach ($informes as $informe){*/
            $higienearchivado = $dbm->getByParametersRepositorios('MaHigienemarcado', array("informeid" => $reportId, "higieneid" => $hygieneId));
            if ($higienearchivado) {
                $Higienearchivado = $higienearchivado[0];
                $Higienearchivado->setHecho($hecho);
                $Higienearchivado->setArchivado($archivado);
            } else {
                $Higienearchivado = new MaHigienemarcado();
                $Higienearchivado->setHigieneid($dbm->getRepositorioById("MaHigiene", "higieneid", $hygieneId));
                $Higienearchivado->setInformeid($dbm->getRepositorioById("MaInforme", "informeid", $reportId));
                $Higienearchivado->setHecho($hecho);
                $Higienearchivado->setArchivado($archivado);
            }
            //}
            //}
            $dbm->saveRepositorio($Higienearchivado);

            $dbm->getConnection()->commit();
            return new View(array("success" => true, "message" => "La notificación de higiene ha sido actualizada."), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * @Rest\Put("/api/portalfamiliar/report/{reportId}/stock/{stockId}" , name="ActualizarInventarioHecho")
     */
    public function updateInventarioHecho($reportId, $stockId)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $datos = json_decode($content, true);
            if (!$datos) {
                parse_str(file_get_contents("php://input"), $datos);
            }

            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($datos["hecho"] == 0) {
                $hecho = 0;
            } else {
                $hecho = 1;
            }
            if ($datos["archivado"] == 0) {
                $archivado = 0;
            } else {
                $archivado = 1;
            }
            /*
            foreach ($hijos as $hijo){
                $informes = $dbm->BuscarInforme(array("alumnoid"=>$hijo->getAlumnoid()));
                foreach ($informes as $informe){*/
            $inventarioarchivado = $dbm->getByParametersRepositorios('MaInventariomarcado', array("informeid" => $reportId, "inventarioid" => $stockId));
            if ($inventarioarchivado) {
                $Inventarioarchivado = $inventarioarchivado[0];
                $Inventarioarchivado->setHecho($hecho);
                $Inventarioarchivado->setArchivado($archivado);
            } else {
                $Inventarioarchivado = new MaInventariomarcado();
                $Inventarioarchivado->setInventarioid($dbm->getRepositorioById("MaInventario", "inventarioid", $stockId));
                $Inventarioarchivado->setInformeid($dbm->getRepositorioById("MaInforme", "informeid", $reportId));
                $Inventarioarchivado->setHecho($hecho);
                $Inventarioarchivado->setArchivado($archivado);
            }
            // }
            //}
            $dbm->saveRepositorio($Inventarioarchivado);

            $dbm->getConnection()->commit();
            return new View(array("success" => true, "message" => "La notificación de inventario ha sido actualizado."), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }


    /**
     * Retorna arreglo de inventario del padre
     * @Rest\Get("/api/portalfamiliar/parents/{parentId}/stock", name="BuscarInventarioPadre")
     */
    public function getInventarioPadre($parentId)
    {
        try {
            //$fecha=new \DateTime();
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $hijos = $dbm->BuscarHijo(array("padresotutoresid" => $parentId));
            $response = array();
            foreach ($hijos as $hijo) {
                $informes = $dbm->BuscarInformeApp(array("alumnoid" => $hijo->getAlumnoid()));
                foreach ($informes as $informe) {
                    $respuesta["id"] = $informe->getInformeid();
                    $respuesta["date"] = $informe->getFecha()->format('Y-m-d');
                    $respuesta["student_id"] = $informe->getAlumnoid()->getAlumnoid();
                    $inventarios = $dbm->getRepositoriosById("MaInventarioporinforme", "informeid", $informe->getInformeid());
                    $i = 0;
                    unset($items);
                    foreach ($inventarios as $inventario) {
                        $inv = $inventario->getInventarioid();
                        $marcados = $dbm->getByParametersRepositorios("MaInventariomarcado", array("inventarioid" => $inv->getInventarioid(), "informeid" => $informe->getInformeid()));
                        unset($hecho);
                        unset($archivado);
                        if ($marcados) {
                            $hecho = $marcados[0]->getHecho();
                            $archivado = $marcados[0]->getArchivado();
                        }
                        if (!$archivado) {
                            $i++;
                            //$item["id"]=$i;
                            $item["stock_id"] = $inv->getInventarioid();
                            $item["stock_type"] = 1;
                            $item["name"] = $inv->getDescripcion() . " (" . $inventario->getCantidad() . ")";
                            $item["hecho"] = $hecho;
                            $item["archivado"] = $archivado;
                            $items[] = $item;
                        }
                    }
                    $higienes = $dbm->getRepositoriosById("MaHigieneporinforme", "informeid", $informe->getInformeid());

                    foreach ($higienes as $higiene) {
                        $hig = $higiene->getHigieneid();
                        $marcados = $dbm->getByParametersRepositorios("MaHigienemarcado", array("higieneid" => $hig->getHigieneid(), "informeid" => $informe->getInformeid()));
                        unset($hecho);
                        unset($archivado);
                        if ($marcados) {
                            $hecho = $marcados[0]->getHecho();
                            $archivado = $marcados[0]->getArchivado();
                        }
                        if (!$archivado) {
                            $i++;
                            //$item["id"]=$i;
                            $item["stock_id"] = $hig->getHigieneid();
                            $item["stock_type"] = 2;
                            $item["name"] = $hig->getDescripcion();
                            $item["hecho"] = $hecho;
                            $item["archivado"] = $archivado;
                            $items[] = $item;
                        }
                    }
                    $respuesta["items"] = $items;
                    $response[] = $respuesta;
                }
            }
            foreach ($response as $key => $respuesta) {
                if (!isset($respuesta["items"])) {
                    $sinitems[] = $key;
                }
            }
            foreach ($sinitems as $borrar) {
                unset($response[$borrar]);
            }
            foreach ($response as $respuesta) {
                $response2[] = $respuesta;
            }
            if (!$response2) {
                //return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
                return [];
            }
            return new View($response2, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de informes del padre
     * @Rest\Get("/api/portalfamiliar/parents/{parentId}/report", name="BuscarInformePadre")
     */
    public function getInformePadre($parentId)
    {
        try {
            $year = $_REQUEST["year"];
            $month = $_REQUEST["month"];
            $day = $_REQUEST["day"];
            $fecha = new \DateTime($year . "-" . $month . "-" . $day);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $hijos = $dbm->BuscarHijo(array("padresotutoresid" => $parentId));
            foreach ($hijos as $hijo) {
                $informes = $dbm->BuscarInformeApp(array("alumnoid" => $hijo->getAlumnoid(), "fecha" => $fecha->format('Y-m-d')));
                unset($items);
                foreach ($informes as $informe) {
                    $respuesta["id"] = $informe->getInformeid();
                    $respuesta["date"] = $fecha->format('Y-m-d');
                    $respuesta["student_id"] = $informe->getAlumnoid()->getAlumnoid();
                    $respuesta["mood_type"] = $informe->getAnimo();
                    $respuesta["total_diapers"] = $informe->getPanal();
                    $respuesta["pee_diapers"] = $informe->getPanal1();
                    $respuesta["poo_diapers"] = $informe->getPanal2();
                    $respuesta["poo_type_diapers"] = $informe->getPanaltipo();
                    $respuesta["total_toilet"] = $informe->getBano();
                    $respuesta["pee_toilet"] = $informe->getBano1();
                    $respuesta["poo_toilet"] = $informe->getBano2();
                    $respuesta["poo_type_toilet"] = $informe->getBanotipo();
                    $respuesta["accidents"] = $informe->getAccidente();
                    $respuesta["accidents_warned"] = $informe->getAccidenteaviso();
                    $respuesta["eat_type"] = $informe->getComida();
                    $respuesta["eat_observations"] = $informe->getComidaobservaciones();
                    $respuesta["did_sleep"] = $informe->getSueno();
                    $respuesta["sleep_hours"] = $informe->getSuenohoras();
                    $actividades = $dbm->getRepositoriosById("MaActividadporinforme", "informeid", $informe->getInformeid());
                    foreach ($actividades as $actividad) {
                        $item = $actividad->getActividadid()->getDescripcion();
                        $items[] = $item;
                    }
                    $respuesta["activities"] = $items;
                    $respuesta["daily_report"] = $informe->getObservaciones();
                    $respuesta["visto"] = $informe->getVisto();
                    $response[] = $respuesta;
                }
            }
            if (!$response) {
                //return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
                return [];
            }
            return new View($response, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna un arreglo con los menus del mes asociados al padre
     * @Rest\Get("/api/portalfamiliar/parents/{parentId}/daily-menu", name="BuscarAsignacionMenuPadre")
     */
    public function getAsignacionMenuPadre($parentId)
    {
        try {
            $datos = $_REQUEST;

            $year = $_REQUEST["year"];
            $month = $_REQUEST["month"];

            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $asignaciones = $dbm->BuscarAsignacionPadre(array("year" => $year, "month" => $month));
            $cicloactual = $dbm->getRepositorioById('Ciclo', 'actual', 1);
            foreach ($asignaciones as $asignacion) {
                $respuesta["id"] = $asignacion->getAsignacionmenuid();
                $respuesta["date"] = $asignacion->getFecha()->format('Y-m-d');
                $alumno = $asignacion->getAlumnoid();
                $respuesta["student_id"] = $alumno->getAlumnoid();
                $respuesta["student_name"] = $alumno->getPrimernombre() . " " . $alumno->getSegundonombre() . " " . $alumno->getApellidopaterno() . " " . $alumno->getApellidomaterno();
                $alumnoporciclo = $dbm->getOneByParametersRepositorio('CeAlumnoporciclo', ['alumnoid' => $alumno->getAlumnoid(), 'cicloid' =>  $cicloactual->getCicloId()]);
                $grupo = $dbm->getRepositorioById("CeAlumnocicloporgrupo", "alumnoporcicloid", $alumnoporciclo->getAlumnoporcicloid());
                $alumnosgrupo = $dbm->getRepositoriosById("CeAlumnocicloporgrupo", "grupoid", $grupo->getGrupoid());
                $respuesta["students_in_group"] = count($alumnosgrupo);
                $platillos = $dbm->getRepositoriosById("MaPlatillopormenu", "menuid", $asignacion->getMenuid()->getMenuid());
                unset($items);
                foreach ($platillos as $platillo) {
                    $plato = $platillo->getPlatilloid();
                    $item["id"] = $plato->getPlatilloid();
                    $item["daily_menu_id"] = $asignacion->getMenuid()->getMenuid();
                    $item["title"] = $plato->getDescripcion();
                    $item["details"] = $plato->getIngredientes();
                    $items[] = $item;
                }

                $respuesta["items"] = $items;
                $padre = $dbm->BuscarPadre(array("alumnoid" => $alumno->getAlumnoid(), "padresotutoresid" => $parentId));
                if ($padre) {
                    $respuesta["padre"] = $padre[0]->getNombre() . " " . $padre[0]->getApellidopaterno() . " " . $padre[0]->getApellidomaterno();
                } else {
                    $respuesta["padre"] = "Padres de " . $alumno->getPrimernombre() . " " . $alumno->getSegundonombre() . " " . $alumno->getApellidopaterno() . " " . $alumno->getApellidomaterno();
                }
                $respuesta["visto"] = $asignacion->getVisto();
                $response[] = $respuesta;
            }

            if (!$response) {
                //return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
                return [];
            }
            return new View($response, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    //------------------- Login Foto -----------------------
    /**
     * Login del padre
     * @Rest\Get("/api/portalfamiliar/login/fotografia/{id}", name="generarFotografiaLoginPortalFamiliar")
     */
    public function generarFotografiaLoginPortalFamiliar($id)
    {
        // Se genera este metodo para mostrar la foto del usuario
        // Se genera la conexion a la BD
        $conn = $this->get("db_manager")->getConnection();
        // Preparamos nuestro query SQL llamando a la tabla pp_fotousuario
        $stmt = $conn->prepare('SELECT * FROM pp_fotousuario WHERE usuarioid = :id');
        // Ejecutamos nuestro query
        $stmt->execute(array('id' => $id));
        // Obtenemos la lista de fotografias del query
        $foto = $stmt->fetchAll();
        // Generamos un arreglo separado por ; de la fotografia en base 64
        $array = explode(';', $foto[0]['fotografia']);
        // Verificamos si existe en el index 0 del arreglo el formato de data:
        if (strpos($array[0], 'data:') === 0) {
            // si existe lo asignamos como el contentType
            $contentType = substr($array[0], 5);
        }

        // Extraemos el ultimo elemento del arreglo 
        $data = array_pop($array);
        // Verificamos que sea base4
        if (strpos($data, 'base64,') === 0) {
            $data = substr($data, 7);
        }

        // Generamos una respuesta con el header del ContentType del base 64
        $response = new Response();
        $response->headers->set('Content-Type', $contentType);
        $response->setContent(base64_decode($data));
        // Mostramos la imagen
        return $response;
    }

    //------------------- Login -----------------------
    /**
     * Login del padre
     * @Rest\Post("/api/portalfamiliar/login", name="loginportalfamiliar")
     */
    public function loginPortalFamiliarAction()
    {
        try {

            $router = $this->get('router')->getContext();

            $data = $_REQUEST;
            //Portal web = 1,  App móvil = 2


            if ($data["origen"] != 2) {
                $recaptcha = new  ReCaptcha();
                $captcha = $recaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $data["captcha"]);

                if ($captcha->success != true) {
                    $response = new Response(
                        '{"mensaje":"Vuelva a seleccionar "No soy un robot""}',
                        Response::HTTP_PARTIAL_CONTENT,
                        array('content-type' => 'text/html')
                    );
                    return $response;
                }
            }


            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            //-- token ---
            $caracter = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            $numero = strlen($caracter) - 1;

            $token =
                substr($caracter, rand(0, $numero), 1) .
                substr($caracter, rand(0, $numero), 1) .
                substr($caracter, rand(0, $numero), 1) .
                substr($caracter, rand(0, $numero), 1) .
                substr($caracter, rand(0, $numero), 1) .
                substr($caracter, rand(0, $numero), 1) .
                substr($caracter, rand(0, $numero), 1) .
                substr($caracter, rand(0, $numero), 1) .
                substr($caracter, rand(0, $numero), 1) .
                substr($caracter, rand(0, $numero), 1);

            //-- servicio --
            $entidad = $dbm->getByParametersRepositorios("Usuario", array("cuenta" => $data["correo"], "contrasena" => $data["password2"]));


            if (!$entidad) {
                $response = new Response(
                    '{"mensaje":"Verifique que su correo y su contraseña sean correctos."}',
                    Response::HTTP_PARTIAL_CONTENT,
                    array('content-type' => 'text/html')
                );
                return $response;
                //return new View("Verifique que su correo y su contraseña sean correctos.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                $entidad = $entidad[0];
            }

            //enmascarado
            if ($entidad->getUsuarioEnmascarado()) {
                $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $entidad->getUsuarioenmascarado());
                if (!$usuario) {
                    return new View("No se han encontrado los datos del usuario.", Response::HTTP_PARTIAL_CONTENT);
                }
            } else if ($entidad->getPadreotutorid()) {
                $usuario = $entidad;
            }

            if (!$usuario) {
                return new View("No se han encontrado los datos del usuario.", Response::HTTP_PARTIAL_CONTENT);
            }

            $perfil = $dbm->getRepositorioById('Usuarioporperfil', 'usuarioid', $usuario->getUsuarioId());
            if (!$perfil) {
                return new View("No se ha configurado un perfil para el usuario.", Response::HTTP_PARTIAL_CONTENT);
            }
            $perfil = $perfil->getPerfilid();

            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT * FROM ce_pploginpadretutorvista WHERE padresotutoresid = :id');
            $stmt->execute(array('id' => strval($usuario->getPadreotutorid()->getPadresotutoresid())));
            $padre = $stmt->fetchAll();

            if ($padre) {
                $conn = $this->get("db_manager")->getConnection();
                $stmt = $conn->prepare('SELECT * FROM pp_fotousuario WHERE usuarioid = :id');
                $stmt->execute(array('id' => $usuario->getUsuarioId()));
                $foto = $stmt->fetchAll();

                if ($foto) {
                    //Se realiza cambio para mostrar una URL y no un base 64, se realiza la llamada al metodo generarFotografiaLoginPortalFamiliar y se le pasa el id del usuario 
                    //$padre[0]['Fotografia'] = $foto[0]['fotografia'];
                    $padre[0]['Fotografia'] = $router->getScheme() . "://" . $router->getHost() . ":" . $router->getHttpPort() . $router->getBaseUrl() . "/api/portalfamiliar/login/fotografia/" . $usuario->getUsuarioId();
                }

                $padre[0]['UsuarioId'] = $usuario->getUsuarioid();
                $padre[0]['ReiniciarContrasena'] = $usuario->getReiniciarcontrasena();
                $padre[0]['TipoUsuarioId'] = $usuario->getTipousuarioid();
                $padre[0]['Cuenta'] = $usuario->getCuenta();


                $return = array("login" => $datos, "padre" => $padre[0], "perfil" => $perfil, "token" => $token);
            } else {
                return new View("No se han encontrado los datos del usuario.", Response::HTTP_PARTIAL_CONTENT);
            }

            //---- Sesion
            $pantalla = !$usuario->getReiniciarcontrasena() ? "Inicio" : "Cambio de contraseña";
            $tiempo = $perfil->getTiempoSesion();

            $fin = new \DateTime();
            $fin->add(new \DateInterval('PT' . $tiempo . 'M'));

            $sesion = new Sesion();

            $sesion->setUsuarioId($usuario);
            $sesion->setToken($token);
            $sesion->setInicia(new \DateTime());
            $sesion->setFinaliza($fin);
            $sesion->setPantalla($pantalla);

            $dbm->saveRepositorio($sesion);

            $dbm->getConnection()->commit();

            $usuario->setActivo(null);
            $usuario->setContrasena(null);

            return new View($return, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Login del padre
     * @Rest\Get("/api/portalfamiliar/DatosUsuario", name="PPGetDatosUsuario")
     */
    public function GetDatosUsuario($id)
    {
        try {
            $data = $_REQUEST;
            $dbm = $this->get("db_manager");

            $usuario = $dbm->getByParametersRepositorios("CePadresotutores", array("usuarioid" => $id));

            $usuario = $usuario[0];

            return new View($usuario, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * Actualiza la contraseña del usuario
     * @Rest\Put("/api/portalfamiliar/CambiarPassword" , name="PPCambiarPassword")
     */
    public function CambiarPassword()
    {
        try {
            parse_str(file_get_contents("php://input"), $data);

            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) AS Count FROM usuario WHERE UsuarioId = " . $data['UsuarioId'] . " AND Contrasena = '" . $data['Password'] . "' AND Cuenta = '" . $data['Correo'] . "'");
            $stmt->execute();
            $numUsuario = $stmt->fetchAll();


            if ($numUsuario[0]['Count']  == "1") {
                $dbm = $this->get("db_manager");
                $dbm->getConnection()->beginTransaction();

                $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['UsuarioId']);
                $usuario->setContrasena($data['NuevoPassword']);
                $usuario->setReiniciarContrasena(0);

                $dbm->saveRepositorio($usuario);
                $dbm->getConnection()->commit();
                return new View(array("msj" => "Se ha actualizado el registro."), Response::HTTP_OK);
            } else {
                return new View("Datos no válidos", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * @Rest\Post("/api/portalfamiliar/RecuperarPassword", name="PPRecuperarPassword")
     */
    public function RecuperarPassword()
    {
        try {
            $data = $_REQUEST;

            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare("SELECT COUNT(*) AS Count, UsuarioId, PadreOTutorId FROM usuario WHERE  PadreOTutorId IS NOT NULL AND Cuenta = '" . $data['Correo'] . "'");
            $stmt->execute();
            $numUsuario = $stmt->fetchAll();


            if ($numUsuario[0]['Count']  == "1") {
                //generar nueva contraseña
                $caracter = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $numero = strlen($caracter) - 1;
                $codigo =
                    substr($caracter, rand(0, $numero), 1) .
                    substr($caracter, rand(0, $numero), 1) .
                    substr($caracter, rand(0, $numero), 1) .
                    substr($caracter, rand(0, $numero), 1) .
                    substr($caracter, rand(0, $numero), 1) .
                    substr($caracter, rand(0, $numero), 1) .
                    substr($caracter, rand(0, $numero), 1) .
                    substr($caracter, rand(0, $numero), 1) .
                    substr($caracter, rand(0, $numero), 1) .
                    substr($caracter, rand(0, $numero), 1);



                //---- Guardar contraseña
                $dbm = $this->get("db_manager");
                $dbm->getConnection()->beginTransaction();

                $usuario = $dbm->getRepositorioById('Usuario', 'cuenta', $data['Correo']);
                $usuario->setContrasena(md5($codigo));
                $usuario->setReiniciarContrasena(1);

                $dbm->saveRepositorio($usuario);
                $dbm->getConnection()->commit();


                //--- enviar correo 
                $dbm = $this->get("db_manager");
                $padretutor = $dbm->getRepositorioById('CePadresotutores', 'padresotutoresid', $numUsuario[0]['PadreOTutorId']);
                $correo = $dbm->getRepositorioById('Correo', 'correoid', 8);
                $destinatarios = array();
                $enlace = $dbm->getRepositorioById('Parametros', 'nombre', 'URLPortalPadres')->getValor();

                array_push($destinatarios, $padretutor->getCorreo());

                $instituto = $data["Instituto"] == 1 ? "LUX" : "de Ciencias";
                $parametros = array(
                    "instituto" => $instituto,
                    "nombre" => $padretutor->getNombre() . ' ' . $padretutor->getApellidopaterno() . ' ' . $padretutor->getApellidomaterno(),
                    "correo" => $padretutor->getCorreo(),
                    "password" => $codigo,
                    "enlace" => $enlace
                );

                \AppBundle\Dominio\Correo::ServicioCorreo($destinatarios, $parametros, $correo, $this->get('mailer'));
                //-- termina correo

                return new View(array("msj" => "Tu contraseña se te ha enviado a tu correo electrónico. "), Response::HTTP_OK);
            } else {
                return new View("Verifica que tu correo sea correcto.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    //------------------ Catálogos datos familiares -------------------------------

    /**
     * Reotorna si esta vigente el periodo de actualizacion
     * @Rest\Get("/api/portalfamiliar/PeriodoActualizacion", name="PPPeriodoActualizacion")
     */
    public function GetPeriodoActualizacionVigente()
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm = new DbmPortalFamiliar($this->get("db_manager")->getEntityManager());

            $vigente = $dbm->GetVigenciaPeriodoActualizacion();


            $return = array(
                'periodoactualizacion' => $vigente ? $vigente[0]["vigente"] ?  true : false : false,
            );


            return new View($return, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /** Peticion para la actualizacion de datos en portal familiar, y la info de los alumnos en app padres
     * @Rest\Get("/api/portalfamiliar/AlumnoPorPadreTutor/{id}", name="PPAlumnoPorPadreTutor")
     */
    public function GetAlumnoPorPadreTutor($id)
    {
        try {
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT  av.*,cpn.fechainicios2,
            case when (select pa.fechainicio from ce_periodoactualizacion pa where pa.activo = 1) > av.FechaActualizacion then 1 else 0 end as Actualizar
            FROM ce_ppalumnoclavefamiliavista av
            left join ciclo c on c.actual = 1
            left join ce_ciclopornivel cpn on cpn.nivelid = av.nivelid and cpn.cicloid = c.cicloid
            where av.PadresOtutoresId = :id and av.AlumnoEstatusId = 1 group by av.Matricula;');
            $stmt->execute(array('id' => $id));
            $result = $stmt->fetchAll();
            $result = ClasificadorAlumno::clasificaciondeAlumnos($result, 'AlumnoId', 'fechainicios2');
            return new View($result, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/portalfamiliar/DatosAlumno/{id}", name="PPGetDatosAlumno")
     */
    public function GetDatosAlumno($id)
    {
        try {
            $dbm = $this->get("db_manager");

            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('SELECT av.*,cpn.fechainicios2 FROM ce_ppdatosalumnovista av
            left join ciclo c on c.actual = 1
            left join ce_ciclopornivel cpn on cpn.nivelid = av.nivelid and cpn.cicloid = c.cicloid
            where av.AlumnoId = :id;');
            $stmt->execute(array('id' => $id));
            $alumno = $stmt->fetchAll();
            $alumno = ClasificadorAlumno::clasificaciondeAlumnos($alumno, 'AlumnoId', 'fechainicios2');

            $dinamicaFamiliar = $dbm->getRepositoriosById('CeAlumnodinamicafamiliar', 'alumnoid', $id);
            $datoMedico = $dbm->getRepositoriosById('CeAlumnodatomedico', 'alumnoid', $id);

            if ($datoMedico) {
                $alergia = $dbm->getRepositoriosById('CeAlergiapordatomedico', 'alumnodatomedicoid', $datoMedico->getAlumnodatomedicoid);
                $antecedente = $dbm->getRepositoriosById('CeAntecedentefamiliarpordatomedico', 'alumnodatomedicoid', $datoMedico->getAlumnodatomedicoid);
            }


            return new View($alumno, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de un padre o tutor
     * @Rest\Put("/api/portalfamiliar/{sistema}/PadresOTutoresAlumno" , name="PPEditarPadresOTutores")
     */
    public function EditarPadresOTutores($sistema)
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            //return $data;
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $padretutor = $dbm->getRepositorioById('CePadresotutores', 'padresotutoresid', $data['PadresOTutoresId']);

            //información básica
            $padretutor->setNombre(mb_strtoupper($data["Nombre"], 'utf-8'));
            $padretutor->setApellidopaterno(mb_strtoupper($data["ApellidoPaterno"], 'utf-8'));
            $padretutor->setApellidomaterno(mb_strtoupper($data["ApellidoMaterno"], 'utf-8'));
            $padretutor->setTelefono($data["Telefono"]);
            $padretutor->setCorreo(mb_strtolower($data["Correo"], 'utf-8'));
            $padretutor->setTutor(mb_strtolower($data["Tutor"], 'utf-8'));
            $padretutor->setVive(mb_strtolower($data["Vive"], 'utf-8'));

            if (!empty($data['TutorId'])) {
                $parentescoTutor = $dbm->getRepositorioById('CePadresotutoresclavefamiliar', 'padresotutoresid', $data['PadresOTutoresId']);

                $tutor = $dbm->getRepositorioById('Tutor', 'tutorid', intval($data['TutorId']));
                $parentescoTutor->setTutorid($tutor);
            }

            $padretutor->setAlumnoinstituto($data["AlumnoInstituto"] ? $data["AlumnoInstituto"] : null);

            if ($data["AlumnoInstituto"] == 1) {
                $padretutor->setEspecificaralumno($data["EspecificarAlumno"]);
            } else {
                $padretutor->setEspecificaralumno(null);
            }

            //información adicional
            $padretutor->setFechaNacimiento($data["FechaNacimiento"] ? new \DateTime($data["FechaNacimiento"]) : null);
            $padretutor->setVive($data["Vive"]);
            $dbm->removeManyRepositorio('CePadresotutoresnacionalidad', 'padresotutoresid', $data['PadresOTutoresId']);

            if (!empty($data['Nacionalidad'])) {
                foreach ($data['Nacionalidad']  as &$nac) {
                    $nuevaNacionalidad = new CePadresotutoresnacionalidad();
                    $nacionalidad = $dbm->getRepositorioById('Nacionalidad', 'nacionalidadid', $nac);


                    $nuevaNacionalidad->setNacionalidadid($nacionalidad);
                    $nuevaNacionalidad->setPadresotutoresid($padretutor);

                    $dbm->saveRepositorio($nuevaNacionalidad);
                }
            }

            if (!empty($data['SituacionConyugalId'])) {
                $situacionconyugal = $dbm->getRepositorioById('SituacionConyugal', 'situacionconyugalid', intval($data['SituacionConyugalId']));
                $padretutor->setSituacionconyugalid($situacionconyugal);
            } else {
                $padretutor->setSituacionconyugalid(null);
            }

            if (!empty($data['NivelEstudioId'])) {
                $nivelestudio = $dbm->getRepositorioById('Escolaridad', 'escolaridadid', intval($data['NivelEstudioId']));
                $padretutor->setNivelestudioid($nivelestudio);
            } else {
                $padretutor->setNivelestudioid(null);
            }

            $padretutor->setOcupacion($data["Ocupacion"]);

            if ($data["Ocupacion"] == "Económicamente activo" || $sistema == 'Ciencias') {
                $padretutor->setEspecificacionocupacion(mb_strtoupper($data["EspecificacionOcupacion"], 'utf-8'));
                $padretutor->setRamo(mb_strtoupper($data["Ramo"], 'utf-8'));
                $padretutor->setEmpresa(mb_strtoupper($data["Empresa"], 'utf-8'));
                $padretutor->setTelempresa(mb_strtoupper($data["TelefonoEmpresa"], 'utf-8'));
                $padretutor->setExtensionempresa($data["ExtensionEmpresa"]);
                $padretutor->setHorariotrabajo(mb_strtoupper($data["HorarioTrabajo"], 'utf-8'));
                $padretutor->setAntiguedad($data["Antiguedad"]);
            } else {
                $padretutor->setEspecificacionocupacion(null);
                $padretutor->setRamo(null);
                $padretutor->setEmpresa(null);
                $padretutor->setTelempresa(null);
                $padretutor->setExtensionempresa(null);
                $padretutor->setHorariotrabajo(null);
                $padretutor->setAntiguedad(null);
            }

            $padretutor->setExlux($data["ExLux"] ? $data["ExLux"] : null);

            if ($data["ExLux"] == 1) {
                if (!empty($data['GeneracionId'])) {
                    $generacion = $dbm->getRepositorioById('Generacion', 'generacionid', intval($data['GeneracionId']));
                    $padretutor->setGeneracionid($generacion);
                }
            } else {
                $padretutor->setGeneracionid(null);
            }

            $usuario=$dbm->getRepositorioById("Usuario", "padreotutorid", $padretutor->getPadresotutoresid());
            if($usuario) {
                $usuario->setCuenta($padretutor->getCorreo());
                $dbm->saveRepositorio($usuario);
            }
            
            $dbm->saveRepositorio($padretutor);
            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha actualizado el registro."), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Actualiza la informacion de una persona autorizada para recoger
     * @Rest\Put("/api/portalfamiliar/PersonaAutorizadaRecoger" , name="PPEditarPersonaAutorizadaRecoger")
     */
    public function EditarPersonaAutorizadaRecoger()
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            //return $data;
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $recoger = $dbm->getRepositorioById('CePersonaautorizadarecoger', 'personaautorizadarecogerid', $data['PersonaAutorizadaRecogerId']);
            $recoger->setNombre(mb_strtoupper($data["Nombre"], 'utf-8'));

            if (!empty($data['ParentescoId'])) {
                $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', intval($data['ParentescoId']));
                $recoger->setParentescoid($parentesco);
            }

            $dbm->saveRepositorio($recoger);
            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha actualizado el registro."), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/portalfamiliar/PersonaAutorizadaRecoger", name="PPAgregarPersonaAutorizadaRecoger")
     */
    public function AgregarPersonaAutorizadaRecoger()
    {
        try {
            $data = $_REQUEST;
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $personaRecogerAlumno = new CePersonaautorizadarecogerporalumno();
            $personaRecoger = new CePersonaautorizadarecoger();

            $personaRecoger->setNombre(mb_strtoupper($data['Nombre'], 'utf-8'));

            if (!empty($data['ParentescoId'])) {
                $parentesco = $dbm->getRepositorioById('Parentesco', 'parentescoid', intval($data['ParentescoId']));
                $personaRecoger->setParentescoid($parentesco);
            }

            if (!empty($data['AlumnoId'])) {
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', intval($data['AlumnoId']));
                $personaRecogerAlumno->setAlumnoid($alumno);
            }

            $dbm->saveRepositorio($personaRecoger);

            $personaRecogerAlumno->setPersonaautorizadarecogerid($personaRecoger);

            $dbm->saveRepositorio($personaRecogerAlumno);


            $dbm->getConnection()->commit();
            return new View("Se ha guardado el nuevo dato de facturación", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/portalfamiliar/PersonaAutorizadaRecoger/{id}", name="PPBorrarPersonaAutorizadaRecoger")
     */
    public function BorrarPersonaAutorizadaRecoger($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $dbm->removeManyRepositorio('CePersonaautorizadarecogerporalumno', 'personaautorizadarecogerporalumnoid', $id);
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


    /**
     * @Rest\Get("/api/portalfamiliar/vivecon", name="PPGetViveCon")
     */
    public function GetViveCon()
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $vivecon = $dbm->getRepositorios('Vivecon');
            return new View($vivecon, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/portalfamiliar/parentesco", name="PPGetParentesco")
     */
    public function GetParentesco()
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $parentesco = $dbm->getRepositorios('Parentesco');
            return new View($parentesco, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/portalfamiliar/tutor", name="PPGetTutor")
     */
    public function GetTutor()
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $tutor = $dbm->getRepositorios('Tutor');
            return new View($tutor, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    /**
     * @Rest\Put("/api/portalfamiliar/Hermano" , name="PPEditarHermanoAlumno")
     */
    public function EditarHermanoAlumno()
    {
        try {
            parse_str(file_get_contents("php://input"), $data);
            //return $data;
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $hermano = $dbm->getRepositorioById('CeHermano', 'hermanoid', $data['HermanoId']);
            $hermano->setNombre(mb_strtoupper($data["Nombre"], 'utf-8'));
            $hermano->setApellidopaterno(mb_strtoupper($data["ApellidoPaterno"], 'utf-8'));
            $hermano->setApellidomaterno(mb_strtoupper($data["ApellidoMaterno"], 'utf-8'));
            $hermano->setEdad($data["Edad"]);

            if ($data["CURP"]) {
                $hermano->setCurp(mb_strtoupper($data["CURP"], 'utf-8'));
            } else {
                $hermano->setCurp(null);
            }


            $dbm->saveRepositorio($hermano);
            $dbm->getConnection()->commit();
            return new View(array("msj" => "Se ha actualizado el registro."), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/portalfamiliar/Hermano", name="PPAgregarHermanoAlumno")
     */
    public function PPAgregarHermanoAlumno()
    {
        try {
            $data = $_REQUEST;
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $hermano = new CeHermano();

            $hermano->setNombre(mb_strtoupper($data["Nombre"], 'utf-8'));
            $hermano->setApellidopaterno(mb_strtoupper($data["ApellidoPaterno"], 'utf-8'));
            $hermano->setApellidomaterno(mb_strtoupper($data["ApellidoMaterno"], 'utf-8'));
            $hermano->setEdad($data["Edad"]);

            if ($data["CURP"]) {
                $hermano->setCurp(mb_strtoupper($data["CURP"], 'utf-8'));
            }


            if (!empty($data['AlumnoId'])) {
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', intval($data['AlumnoId']));
                $hermano->setAlumnoid($alumno);
            }

            $dbm->saveRepositorio($hermano);

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el nuevo dato de facturación", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/portalfamiliar/Hermano/{id}", name="PPBorrarHermanoAlumno")
     */
    public function BorrarHermanoAlumno($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $dbm->removeManyRepositorio('CeHermano', 'hermanoid', $id);
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

    /** DATOS DE FACTURACION **/

    /**
     * @Rest\Get("/api/portalfamiliar/facturacion/datos", name="PPDatosFacturas")
     */
    public function GetDatosFacturas()
    {
        try {
            //alumnos con peg, uso cfdi, datos de facturacion, días para facturar

            $datos = $_REQUEST;
            $filtros = array_filter($datos);   //padresotutoresid  

            $dbm = $this->get("db_manager");

            //Días para facturar
            $diasfacturar = $dbm->getRepositorioById('Parametros', 'nombre', 'Días para facturar');
            $diasfacturar = $diasfacturar ? $diasfacturar->getValor() : "0";

            //Datos de facturación
            $DatosFacturacion = $dbm->getDatosFacturacion($filtros["padresotutoresid"]);

            //Uso CFDI
            $usocfdi = $dbm->getRepositoriosById('CjUsocfdi', 'activo', 1, 'descripcion');

            //Alumnos con PEG
            $peg = $dbm->getAlumnosPEG($filtros["padresotutoresid"]);

            $datos = array(
                "DiasFacturar" => $diasfacturar,
                "DatosFacturacion" => $DatosFacturacion,
                "UsoCfdi" => $usocfdi,
                "PEG" => $peg

            );

            return new View($datos, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene la lista de los datos de facturación colocados por el padre o Tutor
     * @Rest\Get("/api/portalfamiliar/datosfacturacion/{id}", name="PPgetDatosFacturacion")
     */
    public function getDatosFacturacion($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $DatosFacturacion = $dbm->getDatosFacturacion($id);
            return new View($DatosFacturacion, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza la informacion de un dato de facturacion
     * @Rest\Put("/api/portalfamiliar/datosfacturacion" , name="PPupdateDatoFacturacion")
     */
    public function updateDatoFacturacion()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            if (!$data) {
                parse_str(file_get_contents("php://input"), $data);
            }

            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            //domicilio de la factura
            $DatoDomicilio = $dbm->getRepositorioById('CePadresotutoresdomicilio', 'padresotutoresdomicilioid', $data['padresotutoresdomicilioid']);
            $DatoDomicilio->setCodigopostal($data['codigopostal']);

            if ($data['sistema'] == 1) {
                $DatoDomicilio->setCalle(mb_strtoupper($data['calle']));
                $DatoDomicilio->setNumeroexterior(mb_strtoupper($data['numeroexterior']));
                $DatoDomicilio->setNumerointerior(mb_strtoupper($data['numerointerior']));
                $DatoDomicilio->setCiudad($data['ciudad']);

                if ($data['colonia'] == 'OTRA') {
                    $DatoDomicilio->setColonia(mb_strtoupper($data['otracolonia']));
                } else {
                    $DatoDomicilio->setColonia(mb_strtoupper($data['colonia']));
                }
            } else if ($data['sistema'] == 2) {
                $DatoDomicilio->setCalle('');
                $DatoDomicilio->setNumeroexterior('');
                $DatoDomicilio->setNumerointerior('');
                $DatoDomicilio->setColonia('');
                $DatoDomicilio->setCiudad('');
            }

            $dbm->saveRepositorio($DatoDomicilio);

            //datos de facturación
            //$usocfdi = $dbm->getRepositorioById('CjUsocfdi', 'usocfdiid', $data['usocfdiid']);

            $DatoFacturacion = $dbm->getRepositorioById('CePadresotutoresfacturacion', 'padresotutoresfacturacionid', $data['padresotutoresfacturacionid']);
            $DatoFacturacion->setTipopersonaid($data["tipopersonaid"]);
            $DatoFacturacion->setRfc(mb_strtoupper($data['rfc']));
            $DatoFacturacion->setRazonsocial(mb_strtoupper($data['razonsocial']));
            $DatoFacturacion->setCorreo(mb_strtolower($data['correo']));
            $DatoFacturacion->setEsautomaticacolegiatura($data['esautomaticacolegiatura']);
            $DatoFacturacion->setEsautomaticaotros($data['esautomaticaotros']);
            $dbm->saveRepositorio($DatoFacturacion);

            $dbm->getConnection()->commit();
            return new View("La actualización se realizó correctamente.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/portalfamiliar/datosfacturacion/{id}", name="PPdeleteDatoFacturacion")
     */
    public function deleteDatoFacturacion($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();
            $DatoFacturacion = $dbm->getRepositorioById('CePadresotutoresfacturacion', 'padresotutoresfacturacionid', $id);

            if ($DatoFacturacion->getEsautomaticacolegiatura() > 0 || $DatoFacturacion->getEsautomaticaotros() > 0) {
                return new View("No se puede eliminar el registro porque está configurado en la sección de facturación automática.<br/> Modifique la configuración de facturación automática para poder eliminar el registro.", Response::HTTP_PARTIAL_CONTENT);
            }

            $DatoFacturacion->setActivo(0);
            $dbm->saveRepositorio($DatoFacturacion);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funcion para gurdar un nuevo Dato de Facturacion
     * @Rest\Post("/api/portalfamiliar/datosfacturacion", name="PPaddDatoFacturacion")
     */
    public function addDatoFacturacion()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            if (!$data) {
                $data = $_REQUEST;
            }
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            //datos
            $tutor = $dbm->getRepositorioById('CePadresotutores', 'padresotutoresid', $data['padresotutoresid']);
            //$usocfdi = $dbm->getRepositorioById('CjUsocfdi', 'usocfdiid', $data['usocfdiid']);

            //domicilio
            $DatoDomicilio = new CePadresotutoresdomicilio();
            $DatoDomicilio->setPadresotutoresid($tutor);
            $DatoDomicilio->setCodigopostal($data['codigopostal']);

            if ($data['sistema'] == 1) {
                $DatoDomicilio->setCalle(mb_strtoupper($data['calle']));
                $DatoDomicilio->setNumeroexterior(mb_strtoupper($data['numeroexterior']));
                $DatoDomicilio->setNumerointerior(mb_strtoupper($data['numerointerior']));
                $DatoDomicilio->setCiudad($data['ciudad']);

                if ($data['colonia'] == "OTRA") {
                    $DatoDomicilio->setColonia(mb_strtoupper($data['otracolonia']));
                } else {
                    $DatoDomicilio->setColonia(mb_strtoupper($data['colonia']));
                }
            } else if ($data['sistema'] == 2) {
                $DatoDomicilio->setCalle('');
                $DatoDomicilio->setNumeroexterior('');
                $DatoDomicilio->setNumerointerior('');
                $DatoDomicilio->setColonia('');
                $DatoDomicilio->setCiudad('');
            }

            $dbm->saveRepositorio($DatoDomicilio);

            //datos de factura
            $newdato = new CePadresotutoresfacturacion();
            $newdato->setPadresotutoresdomicilioid($DatoDomicilio);
            $newdato->setPadresotutoresid($tutor);
            $newdato->setTipopersonaid($data['tipopersonaid']);
            $newdato->setRfc(mb_strtoupper($data['rfc']));
            $newdato->setRazonsocial(mb_strtoupper($data['razonsocial']));
            $newdato->setCorreo(mb_strtolower($data['correo']));
            $newdato->setEsautomaticacolegiatura($data['esautomaticacolegiatura']);
            $newdato->setEsautomaticaotros($data['esautomaticaotros']);
            $newdato->setActivo(1);
            $dbm->saveRepositorio($newdato);

            $dbm->getConnection()->commit();
            return new View($newdato->getPadresotutoresfacturacionid(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Actualiza la informacion de un dato de facturacion
     * @Rest\Put("/api/portalfamiliar/datosfacturacion/RFC/Automatico" , name="PPupdateRFCAutomatico")
     */
    public function updateRFCAutomatico()
    {
        try {

            parse_str(file_get_contents("php://input"), $data);
            //return $data;
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $DatosFacturacionGenerales = $dbm->getRepositoriosById('CePadresotutoresfacturacion', 'padresotutoresid', $data["padreotutorid"]);

            $padretutorclave = $dbm->getRepositorioById('CePadresotutoresclavefamiliar', 'padresotutoresid', $data["padreotutorid"]);
            $familia = $dbm->getRepositoriosById('CePadresotutoresclavefamiliar', 'clavefamiliarid', $padretutorclave->getClavefamiliarid()->getClavefamiliarid());

            foreach($familia as $f) {
                $padre = $f->getPadresotutoresid();
                if($padre->getPadresotutoresid() !== intval($data["padreotutorid"])) {
                    $padrefacturacion = $dbm->getRepositorioById('CePadresotutoresfacturacion', 'padresotutoresid', $padre->getPadresotutoresid());
                    
                    if($data['esautomaticacolegiatura'] == "1" && $padrefacturacion && $padrefacturacion->getEsautomaticacolegiatura()) {
                        return new View("Solamente un miembro por familia puede tener la opción de 'Facturación automatica' activada.", Response::HTTP_OK);

                    }
                }
            }

            foreach ($DatosFacturacionGenerales as $datogeneral) {
                $datogeneral->setEsautomaticacolegiatura(0);
                $datogeneral->setEsautomaticaotros(0);
                $dbm->saveRepositorio($datogeneral);
            }

            if ($data["id"] > 0) {
                $DatoFacturacion = $dbm->getRepositorioById('CePadresotutoresfacturacion', 'padresotutoresfacturacionid', $data["id"]);
                $DatoFacturacion->setEsautomaticacolegiatura($data['esautomaticacolegiatura']);
                $DatoFacturacion->setEsautomaticaotros($data['esautomaticaotros']);
                $dbm->saveRepositorio($DatoFacturacion);
            }

            //self::saveBitacora($DatoFacturacion, $data["padresotutoresid"], 2, null);
            $dbm->getConnection()->commit();
            return new View("La actualización se realizó correctamente.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /** -- **/
    /** FACTURAS **/
    /**
     * Obtiene la lista de los documentos por pagar relacionados al alumno
     * @Rest\Get("/api/portalfamiliar/facturacion/{id}/{empresaid}", name="PPgetDocumentosParaFacturacionByPadreOTutorId")
     */
    public function getDocumentosParaFacturacionByPadreOTutorId($id, $empresaid)
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $pagos = $dbm->getDocumentosParaFacturacionByPadreOTutorId($id, $empresaid);

            $pagovalido = array();


            //días de toleracia para realizar factura
            $diasparafacturar = $dbm->getRepositorioById('Parametros', 'nombre', 'Días para facturar');
            $diasparafacturar = $diasparafacturar ? intval($diasparafacturar->getValor()) - 1 : 0;

            //pago válidos para facturar o ya facturados
            foreach ($pagos as &$pago) {
                // fecha límite para facturar -- mes de facturación
                $mesfecha = date("m", strtotime($pago['fecha']));
                $yearfecha = date("Y", strtotime($pago['fecha']));

                $pago['mesfacturacion'] = intval($mesfecha);
                $pago['yearfacturacion'] = $yearfecha;

                $mesFacturacion = $yearfecha . '-' . $mesfecha;


                $fechaFacturacion = date('Y-m', strtotime($mesFacturacion . ' +1 months'));
                $fechaFacturacion = date('Y-m-d', strtotime($pago['fecha'] . ' + ' . $diasparafacturar . ' days'));

                if (!$pago['facturaid'] || $pago['facturaestatusid'] == 3 || $pago['facturaestatusid'] == 4) {
                    //fecha de hoy
                    $meslimite = date("Y-m-d");

                    if ($fechaFacturacion >= $meslimite) {
                        if ($pago['facturaestatusid'] == 3 || $pago['facturaestatusid'] == 4) {
                            $refacturado = false;
                            foreach ($pagos as &$pagoaux) {
                                if ($pago['pagoid'] == $pagoaux['pagoid'] && $pagoaux['facturaestatusid'] != 3 && $pagoaux['facturaestatusid'] != 4 && $pago['facturaid'] != $pagoaux['facturaid']) {

                                    $refacturado = true;
                                    break;
                                }
                            }

                            if (!$refacturado) {
                                $ingresado = false;

                                if ($pago['facturaestatusid'] == 3 || $pago['facturaestatusid'] == 4) {
                                    foreach ($pagovalido as &$pagoaux) {
                                        if ($pagoaux['pagoid'] == $pago['pagoid']) {
                                            $ingresado = true;
                                            break;
                                        }
                                    }
                                }

                                if (!$ingresado) {
                                    array_push($pagovalido, $pago);
                                }
                            }
                        } else {
                            array_push($pagovalido, $pago);
                        }
                    }
                } else {
                    array_push($pagovalido, $pago);
                }
            }

            //concepto
            foreach ($pagovalido as &$pago) {
                $pago["concepto"] = $dbm->GetConceptoPago($pago['pagoid']);
            }

            return new View($pagovalido, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Almacena la relación entre el dato de facturación y el documento a facturar
     * @Rest\Post("/api/portalfamiliar/facturacion", name="PPpostaddRelDatoFacturacionDocumento")
     */
    public function addRelDatoFacturacionDocumento()
    {
        try {
            $data = $_REQUEST;
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            //catálogos
            $factura = new CjFactura();

            $pago = $dbm->getRepositorioById('CjPago', 'pagoid', $data['pagoid']);
            $tutor = $dbm->getRepositorioById('CePadresotutores', 'padresotutoresid', $data['padresotutoresid']);
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']);
            $estatus = $dbm->getRepositorioById('CjFacturaestatus', 'facturaestatusid', 1);
            $usocfdi = $dbm->getRepositorioById('CjUsocfdi', 'usocfdiid', $data['usocfdiid']);

            $cajaid = $dbm->getRepositorioById('Parametros', 'nombre', 'Caja Id Portal Web');
            $caja = $dbm->getRepositorioById('CjCaja', 'cajaid', intval($cajaid->getValor()));

            //datos
            $factura->setPagoid($pago);
            $factura->setPadresotutoresid($tutor);
            $factura->setUsuarioid($usuario);
            $factura->setFacturaestatusid($estatus);
            $factura->setCajaid($caja);
            $factura->setUsocfdiid($usocfdi);

            $factura->setRazonsocial(mb_strtoupper($data['razonsocial']));
            $factura->setRfc(mb_strtoupper($data['rfc']));
            $factura->setImporte($data['importe']);
            $factura->setFechaemision(new \DateTime());
            $factura->setCorreo(mb_strtolower($data['correo']));
            $factura->setCalle(mb_strtoupper($data['calle']));
            $factura->setNumeroexterior(mb_strtoupper($data['numeroexterior']));
            $factura->setNumerointerior(mb_strtoupper($data['numerointerior']));
            $factura->setColonia(mb_strtoupper($data['colonia']));
            $factura->setCiudad(mb_strtoupper($data['ciudad']));
            $factura->setCodigopostal($data['codigopostal']);
            $factura->setTipofactura($data['tipofactura']);
            $factura->setFolio('');
            $factura->setSerie('');

            $dbm->saveRepositorio($factura);

            //correos a donde se enviará la factura
            foreach ($data['correoenvio'] as &$corre) {
                $correofactura = new CjFacturacorreo();

                $correofactura->setFacturaid($factura);
                $correofactura->setCorreo(strtolower($corre));

                $dbm->saveRepositorio($correofactura);
            }


            $dbm->getConnection()->commit();
            return new View("Se está realizando la factura seleccionada, misma que le entregaremos vía correo electrónico.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza el estatus de la factura para que después se reenvie
     * @Rest\Put("/api/portalfamiliar/factura/reenviar" , name="PPReenviarFatura")
     */
    public function PPReenviarFatura()
    {
        try {

            parse_str(file_get_contents("php://input"), $data);
            $dbm = $this->get("db_manager");
            $dbm->getConnection()->beginTransaction();

            $factura = $dbm->getRepositorioById('CjFactura', 'facturaid', $data["facturaid"]);

            if ($factura) {
                $estatus = $dbm->getRepositorioById('CjFacturaestatus', 'facturaestatusid', 5);
                $factura->setFacturaestatusid($estatus);
                $dbm->saveRepositorio($factura);
                $dbm->getConnection()->commit();
                return new View("La actualización se realizó correctamente.", Response::HTTP_OK);
            } else {
                return new View('No se encontró la factura', Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /** -- **/
    /** PAGOS EN LINEA **/
    /**
     * Obtiene la lista de los alumnos relacionados al padre o tutor.
     * @Rest\Get("/api/portalfamiliar/infoalumno/{id}", name="PPgetAlumnosByPadreOTutorId")
     */
    public function getAlumnosByPadreOTutorId($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $DatosAlumno = $dbm->getAlumnosByPadreOTutorId($id, $datos);
            return new View($DatosAlumno, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /** -- **/
    /** Reportes alumno **/
    /**
     * Obtiene la lista de los alumnos relacionados al padre o tutor.
     * @Rest\Get("/api/portalfamiliar/Reportedisciplina/{id}", name="getReportedisciplinaByAlumno")
     */
    public function getReportedisciplinaByAlumno($id)
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $dbmce = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if ($datos['cicloid']) {
                $alumno = $dbm->getOneByParametersRepositorio('CeAlumnoporciclo', array("alumnoid" => $id, "cicloid" => $datos['cicloid']));
                $DatosAlumno = $dbm->getReporteByAlumno($datos['alumnoporcicloid']);
            } else {
                $alumno = $dbmce->BuscarAlumnosA(array("alumnoid" => $id));
                $DatosAlumno = $dbm->getReporteByAlumno(($alumno ? $alumno[0]['alumnoporcicloid'] : 0));
            }
            return new View($DatosAlumno, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }




    /**
     * Obtiene los uso cfdi
     * @Rest\Get("/api/portalfamiliar/usocfdi", name="GetUsoCfdi")
     */
    public function GetUsoCfdi()
    {
        try {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");

            $usocfdi = $dbm->getRepositoriosById('CjUsocfdi', 'activo', 1, 'descripcion');

            return new View($usocfdi, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Obtiene los hijos por padreotutorid
     * @Rest\Get("/api/portalfamiliar/hijos/{padreotutorid}", name="getHijos")
     */
    public function getHijos($padreotutorid)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hijos = $dbm->BuscarAlumnosA(['padresotutoresid' => $padreotutorid]);
            return new View($hijos, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
