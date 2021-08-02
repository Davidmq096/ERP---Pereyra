<?php

namespace AppBundle\Controller\Maternal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmMaternal;
use AppBundle\Entity\MaMenu;
use AppBundle\Entity\MaPlatillopormenu;
use AppBundle\Entity\MaAsignacionmenu;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class MenuController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Maternal/Menu", name="indexMenu")
     */
    public function indexMenu()
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $platillos = $dbm->getRepositoriosById('MaPlatillo', 'activo', 1);
            return new View($platillos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Menus en base a los parametros enviados
     * @Rest\Get("/api/Maternal/Menu/", name="BuscarMenu")
     */
    public function getMenu()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarMenu($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            $menus = array();
            foreach ($entidad as $e) {
                $platillos = $dbm->getRepositoriosById('MaPlatillopormenu', 'menuid', $e->getMenuid(), "orden");
                array_push($menus, array("menu" => $e, "platillos" => $platillos));
            }
            return new View($menus, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de menus activos
     * @Rest\Get("/api/Maternal/Menu/Asignacion", name="ListaMenusActivos")
     */
    public function getMenusActivos()
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->getRepositoriosById('MaMenu','activo',1);
            $menus = array();
            foreach ($entidad as $e) {
                $platillos = $dbm->getRepositoriosById('MaPlatillopormenu', 'menuid', $e->getMenuid(), "orden");
                $platos = [];
                foreach($platillos as $p){
                    if($p->getPlatilloid()){
                        $platos[] = $p;
                    }
                }
                array_push($menus, array("menu" => $e, "platillos" => $platos));
            }
            $alumnos=$dbm->BuscarAlumnosMaternal();
            
            return new View(array("menus"=>$menus,"alumnos"=>count($alumnos)), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Menus en base a los parametros enviados
     * @Rest\Get("/api/Maternal/Menu/Asignacion/", name="BuscarAsignaciones")
     */
    public function getAsignaciones()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarAsignaciones($filtros);
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            $menus = array();
            foreach ($entidad as $e) {
                setlocale(LC_ALL,"es_ES");
                $mesesespanol=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                $mesesingles=array("January","February","March","April","May","June","July","August","September","Octuber","November","December");
                $diasespanol=array("Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
                $diasingles=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
                //$fecha=$e->getFecha()->format("d")."/".str_replace($mesesingles,$mesesespanol,$e->getFecha()->format("F"));
                $fechacompleta=$e->getFecha()->format("d/m/Y");
                $fechaformateada=$e->getFecha()->format("Y-m-d");
                $diasemana=str_replace($diasingles,$diasespanol,$e->getFecha()->format("l"));
                $alumno=$e->getAlumnoid()->getMatricula()." - ".$e->getAlumnoid()->getPrimernombre()." ".$e->getAlumnoid()->getSegundonombre()." ".$e->getAlumnoid()->getApellidopaterno()." ".$e->getAlumnoid()->getApellidomaterno();
                $alumnocompleto=$e->getAlumnoid();
                unset($menuasignado);
                unset($menuanterior);
                $platillos=$dbm->getRepositoriosById('MaPlatillopormenu', 'menuid', $e->getMenuid());
                $arrayplatillos=array();
                foreach ($platillos as $platillo){
                    if($platillo->getPlatilloid()){
                        $arrayplatillos[]=$platillo->getPlatilloid()->getDescripcion();
                    }
                }
                $menuasignado=array("menuid"=>$e->getMenuid()->getMenuid(),"descripcion"=>$e->getMenuid()->getDescripcion(),"platillos"=>$arrayplatillos);
                if ($e->getMenuanteriorid()) {
                    $platillos=$dbm->getRepositoriosById('MaPlatillopormenu', 'menuid', $e->getMenuanteriorid()->getMenuid());
                    $arrayplatillos=array();
                    foreach ($platillos as $platillo){
                        $arrayplatillos[]=$platillo->getPlatilloid()->getDescripcion();
                    }
                    $menuanterior=array("menuid"=>$e->getMenuanteriorid()->getMenuid(),"descripcion"=>$e->getMenuanteriorid()->getDescripcion(),"platillos"=>$arrayplatillos);
                }
                
                list($dia,$mes,$anio)=explode("/",$fechacompleta);
                $datetime1 = new \DateTime();
                $datetime1->add(new \DateInterval('P4D'));
                $datetime2 = new \DateTime($dia . '-' . $mes . '-' . $anio);
                $interval = (int)$datetime1->diff($datetime2)->format("%r%a");
                $editable=1;
                if ($interval<-2 && $datetime2->format("Y-m-d")<$datetime1->format("Y-m-d")){
                    $editable=0;
                }

                $menus[]=array("asignacionmenuid"=>$e->getAsignacionmenuid(),"fechaformateada"=>$fechaformateada,"fechacompleta"=>$fechacompleta,"diasemana"=>$diasemana,"alumno"=>$alumno,"alumnocompleto"=>$alumnocompleto,"menuasignado"=>$menuasignado,"menuanterior"=>$menuanterior,"editable"=>$editable);
            }

            return new View($menus, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Menus asignadosen base a los parametros enviados
     * @Rest\Get("/api/Maternal/Menu/Automatico", name="AsignacionMenu")
     */
    public function getAsignacion()
    {
        try {

            function diaespanol($dia)
            {
                $ingles = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
                $espanol = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
                return str_replace($ingles, $espanol, $dia);
            }
            function buscaAsignado($semana,$alumnoid,$valor,$array) {
                foreach ($array as $val) {
                    if (($semana==$val['menuasig']["semana"] && $val['menuasig']["menuid"] == $valor) ||  ($semana==$val['menuasig']["semana"] && $alumnoid==$val['menuasig']["alumnoid"])) {
                        return true;
                    }
                }
                return null;
             }
            $datos = $_REQUEST;
            $fecha=new \DateTime($datos["fecha"]["date"]["year"]."-".$datos["fecha"]["date"]["month"]."-".$datos["fecha"]["date"]["day"]);
            foreach ($datos["menuid"] as $menu){
                $menus[]=$menu["menuid"];
            }
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            
            
            
            
            $alumnos = $dbm->BuscarAlumnosMaternal();

            $asignaciones = array();
            foreach ($alumnos as $i => $a) {
                
                shuffle($menus);
                $menuasig = null;
                

                // No asignar en dias festivos (Verifica el proximo dia habil)
                while ($diasfestivos = $dbm->BuscarDiaFestivo(array("tipoeventoid"=>2,"nivelid" => 1, "fecha" => $fecha->format('Y-m-d')))) {
                    foreach ($diasfestivos as $diafestivo) {
                        if ($fecha!=date_create(str_replace("/","-",$diafestivo["fechafin"]))){
                            $fecha = date_create(str_replace("/","-",$diafestivo["fechafin"]));
                        }
                        $fecha->add(new \DateInterval('P1D'));
                        if ($fecha->format('N') == 6) {
                            $fecha->add(new \DateInterval('P2D'));
                        }
                        if ($fecha->format('N') == 7) {
                            $fecha->add(new \DateInterval('P1D'));
                        }
                    }
                }
                if ($fecha->format('N') == 6) {
                    $fecha->add(new \DateInterval('P2D'));
                }
                if ($fecha->format('N') == 7) {
                    $fecha->add(new \DateInterval('P1D'));
                }

                while ($diaasignado=$dbm->BuscarAsignacion(array("fecha"=>$fecha->format('Y-m-d')))){
                    $fecha->add(new \DateInterval('P1D'));
                    // No asignar en dias festivos (Verifica el proximo dia habil)
                    while ($diasfestivos = $dbm->BuscarDiaFestivo(array("tipoeventoid"=>2,"nivelid" => 1, "fecha" => $fecha->format('Y-m-d')))) {
                        foreach ($diasfestivos as $diafestivo) {
                            if ($fecha!=date_create(str_replace("/","-",$diafestivo["fechafin"]))){
                                $fecha = date_create(str_replace("/","-",$diafestivo["fechafin"]));
                            }
                            $fecha->add(new \DateInterval('P1D'));
                            if ($fecha->format('N') == 6) {
                                $fecha->add(new \DateInterval('P2D'));
                            }
                            if ($fecha->format('N') == 7) {
                                $fecha->add(new \DateInterval('P1D'));
                            }
                        }
                    }
                    if ($fecha->format('N') == 6) {
                        $fecha->add(new \DateInterval('P2D'));
                    }
                    if ($fecha->format('N') == 7) {
                        $fecha->add(new \DateInterval('P1D'));
                    }
                }

                // Un menú no se puede repetir en 10 dias habiles (calcula la fecha que antecede a 10 dias habiles)
                $fechainicio=new \DateTime($fecha->format('Y-m-d'));
                $diasrestados=0;
                while ($diasrestados<10) {
                    $habil=1;
                    $diasfestivos = $dbm->BuscarDiaFestivo(array("tipoeventoid"=>2,"nivelid" => 1, "fecha" => $fechainicio->format('Y-m-d')));
                    foreach ($diasfestivos as $diafestivo) {
                        $fechainicio=date_create(str_replace("/","-",$diafestivo["fechainicio"]));
                        $fechainicio->sub(new \DateInterval('P1D'));
                        $habil=0;
                    }
                    if ($fechainicio->format('N') == 6) {
                        $fechainicio->sub(new \DateInterval('P1D'));
                        $habil=0;
                    }
                    if ($fechainicio->format('N') == 7) {
                        $fechainicio->sub(new \DateInterval('P2D'));
                        $habil=0;
                    }
                    if ($habil==1){
                        $fechainicio->sub(new \DateInterval('P1D'));
                        $diasrestados++;
                    }
                }

                $menuanteriorid=$dbm->BuscarMenuanterior($a["alumnoid"]);
                // No se puede repetir el menú si le toco la vez anterior ($menuanteriorid != $menu)
                foreach ($menus as $menu) {
                    //$asignado=$dbm->BuscarAsignacion(array("menuid"=>$menu,"fechainicio"=>$fechainicio->format('Y-m-d'),"fechafin"=>$fecha->format('Y-m-d')));
                    $asignado=$dbm->BuscarAsignacion(array("year"=> $fecha->format('Y'), "menuid"=>$menu,"semana"=>$fecha->format('W')));
                    if(!$asignado && $menuanteriorid[0]["menuid"] != $menu && !buscaAsignado($fecha->format('W'),$a["alumnoid"],$menu,$asignaciones)){
                        $menuasig = $menu;
                    }
                }
                $menures=null;
                $menures2=null;
                $menutemp=$dbm->getRepositorioById("MaMenu","menuid",$menuanteriorid[0]["menuid"]);
                if ($menutemp){
                    $menures["menuid"]=$menutemp->getMenuid();
                    $menures["descripcion"]=$menutemp->getDescripcion();
                    $menures["activo"]=$menutemp->getActivo();
                }
                $platillos = $dbm->getRepositoriosById('MaPlatillopormenu', 'menuid', $menuanteriorid[0]["menuid"]);
                //$menures["asignacionmenuid"]=$menuanteriorid[0]["asignacionmenuid"];
                $menures["platillos"]=$platillos;
                $asignaciones[$i]["fecha"] = $fecha->format('d/m/Y');
                $asignaciones[$i]["dia"] = diaespanol($fecha->format('l'));
                $asignaciones[$i]["alumno"] = $a["matricula"] . " - " . $a["primernombre"] . " " . $a["segundonombre"]. " ".$a["apellidopaterno"] . " " . $a["apellidomaterno"];
                $asignaciones[$i]["alumnoid"] = $a["alumnoid"];
                $asignaciones[$i]["alumnoid"] = $a["alumnoid"];
                $asignaciones[$i]["numerolista"] = $a["numerolista"];
                $asignaciones[$i]["menuant"] = $menures;
                $menutemp=$dbm->getRepositorioById("MaMenu","menuid",$menuasig);
                if ($menutemp){
                    $menures2["menuid"]=$menutemp->getMenuid();
                    $menures2["descripcion"]=$menutemp->getDescripcion();
                    $menures2["activo"]=$menutemp->getActivo();
                    $menures2["semana"]=$fecha->format('W');
                    $menures2["alumnoid"]=$a["alumnoid"];
                    
                }
                $platillos = $dbm->getRepositoriosById('MaPlatillopormenu', 'menuid', $menuasig);
                $menures2["platillos"]=$platillos;
                $asignaciones[$i]["menuasig"] = $menures2;
                
                $fechac = $fecha->add(new \DateInterval('P1D'));
            }
            if (!$asignaciones) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($asignaciones, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de objetos de Menus asignados en base a los parametros enviados
     * @Rest\Post("/api/Maternal/Menu/Automatico", name="GuardaAsignacionAutomatica")
     */
    public function SaveAutomatico()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            foreach ($data["guardar"] as $asignacion) {
                $alumno=$dbm->getRepositorioById("CeAlumno","alumnoid",$asignacion["alumnoid"]);
                $dbm->getConnection()->beginTransaction();
                $Asignacionmenu = new MaAsignacionmenu();
                $Asignacionmenu->setMenuid($dbm->getRepositorioById("MaMenu","menuid",$asignacion["menuasig"]["menuid"]));
                if ($asignacion["menuant"]["menuid"]){
                    $Asignacionmenu->setMenuanteriorid($dbm->getRepositorioById("MaMenu","menuid",$asignacion["menuant"]["menuid"]));
                }
                $Asignacionmenu->setAlumnoid($alumno);
                list($dia,$mes,$anio)=explode("/",$asignacion["fecha"]);
                $fecha=new \DateTime($dia . '-' . $mes . '-' . $anio);
                $Asignacionmenu->setFecha($fecha);
                $dbm->saveRepositorio($Asignacionmenu);
                $dbm->getConnection()->commit();
                self::enviarNotificacion($alumno, $fecha);
            }
            
            
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Maternal/Menu/Manual" , name="GuardarAsignacion")
     */
    public function SaveAsignacion()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $fecha=new \DateTime($data["fecha"]["date"]["year"]."-".$data["fecha"]["date"]["month"]."-".$data["fecha"]["date"]["day"]);
            $data["fecha"]=$fecha->format('Y-m-d');
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            
            $asignado=$dbm->BuscarAsignacion(array("fecha"=>$fecha->format('Y-m-d')));
            if ($asignado) {
                return new View("Ya existe un registro en la misma fecha", Response::HTTP_PARTIAL_CONTENT);
            }
            $diasfestivos = $dbm->BuscarDiaFestivo(array("tipoeventoid"=>2,"nivelid" => 1, "fecha" => $fecha->format('Y-m-d')));
            if ($diasfestivos) {
                return new View("La fecha no es dia habil", Response::HTTP_PARTIAL_CONTENT);
            }
            if ($fecha->format('N') == 6) {
                return new View("La fecha no es dia habil", Response::HTTP_PARTIAL_CONTENT);
            }
            if ($fecha->format('N') == 7) {
                return new View("La fecha no es dia habil", Response::HTTP_PARTIAL_CONTENT);
            }
            
            //$asignado=$dbm->BuscarAsignacion(array("fechainicio"=>$fechainicio->format('Y-m-d'),"fechafin"=>$fecha->format('Y-m-d'),"alumnoid"=>$data["alumnoid"]));
            $asignado=$dbm->BuscarAsignacion(array("year"=> $fecha->format('Y'), "semana"=>$fecha->format('W'),"alumnoid"=>$data["alumnoid"]));
            if ($asignado) {
                return new View("El alumno ya tiene una asignación en la misma semana", Response::HTTP_PARTIAL_CONTENT);
            }

            //$asignado=$dbm->BuscarAsignacion(array("fechainicio"=>$fechainicio->format('Y-m-d'),"fechafin"=>$fecha->format('Y-m-d'),"menuid"=>$data["menuasignadoid"]));
            $asignado=$dbm->BuscarAsignacion(array("year"=> $fecha->format('Y'), "semana"=>$fecha->format('W'),"menuid"=>$data["menuasignadoid"]));
            if ($asignado) {
                return new View("Ya se ha asignado el menú en la misma semana", Response::HTTP_PARTIAL_CONTENT);
            }
            
            
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Asignacion = $hydrator->hydrate(new MaAsignacionmenu(), $data);
            $alumno=$dbm->getRepositorioById("CeAlumno","alumnoid",$data["alumnoid"]);
            //$Asignacion->setAlumnoid($alumno);
            $Asignacion->setMenuid($dbm->getRepositorioById("MaMenu","menuid",$data["menuasignadoid"]));
            $dbm->saveRepositorio($Asignacion);

            $dbm->getConnection()->commit();
            self::enviarNotificacion($alumno, $fecha);

            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Maternal/Menu/Manual/{id}" , name="ActualizarAsignacion")
     */
    public function UpdateAsignacion($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $fecha=new \DateTime($data["fecha"]["date"]["year"]."-".$data["fecha"]["date"]["month"]."-".$data["fecha"]["date"]["day"]);
            $data["fecha"]=$fecha->format('Y-m-d');
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $asignacion = $dbm->getRepositorioById('MaAsignacionmenu', 'fecha', $fecha);
            if ($asignacion && $asignacion->getAsignacionmenuid() != $id) {
                return new View("Ya existe un registro en la misma fecha", Response::HTTP_PARTIAL_CONTENT);
            }
            $diasfestivos = $dbm->BuscarDiaFestivo(array("tipoeventoid"=>2,"nivelid" => 1, "fecha" => $fecha->format('Y-m-d')));
            if ($diasfestivos) {
                return new View("La fecha no es dia habil", Response::HTTP_PARTIAL_CONTENT);
            }
            if ($fecha->format('N') == 6) {
                return new View("La fecha no es dia habil", Response::HTTP_PARTIAL_CONTENT);
            }
            if ($fecha->format('N') == 7) {
                return new View("La fecha no es dia habil", Response::HTTP_PARTIAL_CONTENT);
            }
            
            //$asignado=$dbm->BuscarAsignacion(array("fechainicio"=>$fechainicio->format('Y-m-d'),"fechafin"=>$fecha->format('Y-m-d'),"menuid"=>$data["menuasignadoid"]));
            $asignado=$dbm->BuscarAsignacion(array("year"=> $fecha->format('Y'), "semana"=>$fecha->format('W'),"menuid"=>$data["menuasignadoid"]));
            if ($asignado) {
                return new View("Ya se ha asignado el menú en la misma semana", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Asignacion = $hydrator->hydrate($dbm->getRepositorioById('MaAsignacionmenu', 'asignacionmenuid', $id), $data);
            $Asignacion->setMenuid($dbm->getRepositorioById("MaMenu","menuid",$data["menuasignadoid"]));
            $dbm->saveRepositorio($Asignacion);
            self::enviarNotificacion($Asignacion->getAlumnoid(), $fecha);

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function enviarNotificacion($alumno, $fecha){
        $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
        $padres=$dbm->BuscarPadreUsuario(array("alumnoid"=>$alumno->getAlumnoid()));
                if ($padres) {
                    foreach ($padres as $padre){
                        $googleApiKey = $dbm->getRepositorioById('Parametros', 'nombre', 'GoogleApiKey');
                        $headers = array
                            (
                                'Authorization: key=' . $googleApiKey->getValor(),
                                'Content-Type: application/json'
                            );
                        //ANDROID
                        //$registrationIds = "/topics/android-user".$padre->getUsuarioid();
                        $msg = array
                            (
                                'body' 	=> 'Se ha asignado menú para la fecha '.$fecha->format('d/m/Y'),
                                'news_type' 	=> 4,
                                'date' 	=> $fecha->format('Y-m-d'),
                                'student_id' 	=> $alumno->getAlumnoid(),
                                'title'	=> 'Asignación de menú de '.$alumno->getPrimernombre()
                            );
                        $fields = array
                            (
                                'condition'		=> "'user".$padre->getUsuarioid()."' in topics && 'android' in topics",
                                'data'	=> $msg
                            );
                        
                        
                        
                        #Send Reponse To FireBase Server	
                        $ch = curl_init();
                        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                        curl_setopt( $ch,CURLOPT_POST, true );
                        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                        $result = curl_exec($ch );
                        curl_close( $ch );
                        //echo $result;
                        //IOS
                        //$registrationIds = "/topics/ios-user".$padre->getUsuarioid();
                        $msg = array
                            (
                            'body' 	=> 'Se ha asignado menú para la fecha '.$fecha->format('d/m/Y'),
                            'title'	=> 'Asignación de menú de '.$alumno->getPrimernombre(),
                            'sound' => 'default'
                            );
                        $datadata=array('news_type' => 4,'date' => $fecha->format('Y-m-d'),'student_id' => $alumno->getAlumnoid());	  
                        $fields = array
                            (
                                'condition'		=> "'user".$padre->getUsuarioid()."' in topics && !('android' in topics)",
                                'notification'	=> $msg,
                                'data' => $datadata
                            );
                            
                            
                        #Send Reponse To FireBase Server	
                        $ch = curl_init();
                        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                        curl_setopt( $ch,CURLOPT_POST, true );
                        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                        $result = curl_exec($ch );
                        curl_close( $ch );
                        //echo $result;
                    }
                }
    }
    

    /**
     * Elimina una asignacion de menu
     * @Rest\Delete("/api/Maternal/Menu/Manual/{id}", name="EliminarAsignacionMenu")
     */
    public function deleteAsignacionMenu($id)
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $asignacion = $dbm->getRepositorioById('MaAsignacionmenu', 'asignacionmenuid', $id);
            $dbm->removeRepositorio($asignacion);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Maternal/Menu" , name="GuardarMenu")
     */
    public function SaveMenu()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $menu = $dbm->getRepositorioById('MaMenu', 'descripcion', $data['descripcion']);
            if ($menu) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Menu = $hydrator->hydrate(new MaMenu(), $data);
            $dbm->saveRepositorio($Menu);
            foreach ($data["platilloid"] as $p) {
                $platillopormenu = new MaPlatillopormenu();
                $platillopormenu->setMenuid($Menu);
                $platillopormenu->setPlatilloid($dbm->getRepositorioById('MaPlatillo', 'platilloid', $p["platilloid"]));
                $platillopormenu->setOrden($p["orden"]);
                $dbm->saveRepositorio($platillopormenu);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Maternal/Menu/{id}" , name="ActualizarMenu")
     */
    public function updateMenu($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $menu = $dbm->getRepositorioById('MaMenu', 'descripcion', $data['descripcion']);
            if ($menu && $menu->getMenuid() != $id) {
                return new View("Ya existe una registro con la misma descripción", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Menu = $hydrator->hydrate($dbm->getRepositorioById('MaMenu', 'menuid', $id), $data);
            $dbm->saveRepositorio($Menu);
            $dbm->removeManyRepositorio("MaPlatillopormenu", 'menuid', $id);
            foreach ($data["platilloid"] as $p) {
                $platillopormenu = new MaPlatillopormenu();
                $platillopormenu->setMenuid($Menu);
                $platillopormenu->setPlatilloid($dbm->getRepositorioById('MaPlatillo', 'platilloid', $p["platilloid"]));
                $platillopormenu->setOrden($p["orden"]);
                $dbm->saveRepositorio($platillopormenu);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Maternal/Menu/{id}", name="EliminarMenu")
     */
    public function deleteMenu($id)
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio("MaPlatillopormenu", 'menuid', $id);
            $menu = $dbm->getRepositorioById('MaMenu', 'menuid', $id);
            $dbm->removeRepositorio($menu);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
