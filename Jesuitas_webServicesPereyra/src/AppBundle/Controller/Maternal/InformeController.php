<?php

namespace AppBundle\Controller\Maternal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmMaternal;
use AppBundle\Entity\MaInforme;
use AppBundle\Entity\MaActividadporinforme;
use AppBundle\Entity\MaInventarioporinforme;
use AppBundle\Entity\MaHigieneporinforme;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class InformeController extends FOSRestController
{

    /**
     * Retorna correo formateado con los valores del informe del alumno y fecha seleccionados
     * @Rest\Get("/api/Maternal/Informe/Imprimir", name="ImprimirInforme")
     */
    public function ImprimirInforme()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $correo=$dbm->getRepositorioById("Correo","correoid",14);
            $html="";
            $i=0;
            foreach ($filtros["informeid"] as $informeid){
                $informe=$dbm->getRepositorioById("MaInforme","informeid",$informeid);
                $foto=null;
                if ($informe){
                    
                    $actividades=$dbm->getRepositoriosById("MaActividadporinforme","informeid",$informe->getInformeid());
                    foreach ($actividades as $actividad){
                        $actividadtexto.=$actividad->getActividadid()->getDescripcion().". ";
                    }
                    $inventarios=$dbm->getRepositoriosById("MaInventarioporinforme","informeid",$informe->getInformeid());
                    foreach ($inventarios as $inventario){
                        $inventariotexto.=$inventario->getInventarioid()->getDescripcion().". ";
                    }
                    $higienes=$dbm->getRepositoriosById("MaHigieneporinforme","informeid",$informe->getInformeid());
                    foreach ($higienes as $higiene){
                        $higienetexto.=$higiene->getHigieneid()->getDescripcion().". ";
                    }
                    $alumno=$informe->getAlumnoid();
                    $hoy = new \DateTime();
                    $datetime2 = $alumno->getFechanacimiento();
                    $anios = $hoy->diff($datetime2)->y;
                    $meses = $hoy->diff($datetime2)->m;
                    $edad=$anios;
                    $nombrecompleto=$alumno->getPrimernombre()." ".$alumno->getSegundonombre()." ".$alumno->getApellidopaterno()." ".$alumno->getApellidomaterno();
                    $estatusnumero=array(0,1);
                    $estatusletra=array("Incompleto","Completo");
                    $estatus=str_replace($estatusnumero,$estatusletra,$informe->getEstatus());
                    $animonumero=array(1,2,3);
                    $animoletra=array("Contento","Triste","Enojado");
                    $animo=str_replace($animonumero,$animoletra,$informe->getAnimo());
                    $suenonumero=array(1,0);
                    $suenoletra=array("Durmio","No Durmio");
                    $sueno=str_replace($suenonumero,$suenoletra,$informe->getSueno());
                    $cicloactual=$dbm->getRepositorioById("Ciclo","actual",1);
                    $ac=$dbm->getByParametersRepositorios("CeAlumnoporciclo",array("cicloid"=>$cicloactual->getCicloid(),"alumnoid"=>$alumno));
                    if (!$fotos[$ac[0]->getAlumnoporcicloid()]){
                        $alumnofoto=$dbm->getRepositorioById("CeAlumnociclofoto","alumnoporcicloid",$ac[0]->getAlumnoporcicloid());
                        if ($alumnofoto){
                            $fotos[$ac[0]->getAlumnoporcicloid()]=stream_get_contents($alumnofoto->getFoto());
                        }
                    }
                    
                    if ($alumnofoto){
                        $foto=$fotos[$ac[0]->getAlumnoporcicloid()];
                    }else{
                        $foto="data:image/png;base64,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";
                    }
                    $tokens=array("[fecha]","[matricula]","[nombrecompleto]","[nivel]","[estatus]","[edad]","[meses]","[animo]","[panal]","[panal1]","[panal2]","[panaltipo]","[bano]","[bano1]","[bano2]","[banotipo]","[accidente]","[accidenteaviso]","[comida]","[comidaobservaciones]","[sueno]","[suenohoras]","[observaciones]","[actividad]","[inventario]","[higiene]","[foto]");
                    $valores=array($informe->getFecha()->format('d/m/Y'),$alumno->getMatricula(),$nombrecompleto,"Maternal",$estatus,$edad,$meses,$animo,$informe->getPanal(),$informe->getPanal1(),$informe->getPanal2(),$informe->getPanaltipo(),$informe->getBano(),$informe->getBano1(),$informe->getBano2(),$informe->getBanotipo(),$informe->getAccidente(),$informe->getAccidenteaviso(),$informe->getComida(),$informe->getComidaobservaciones(),$sueno,$informe->getSuenohoras(),$informe->getObservaciones(),$actividadtexto,$inventariotexto,$higienetexto,$foto);
                    $contenido=str_replace($tokens,$valores,$correo->getCuerpo());
                    //if ($i>0){
                        $brinco='<div style="page-break-after:always;"></div>';
                    //}
                    $i++;
                    $html.=$contenido.$brinco;
                    
                }
            }
            return new View($html, Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Maternal/Informe", name="indexInforme")
     */
    public function indexInforme()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());            

            $informes = $dbm->BuscarInforme(array("fecha"=>$filtros["fecha"]));
            $cicloactual=$dbm->getRepositorioById("Ciclo","actual",1);
            
            if (!$informes){
                $alumnos=$dbm->BuscarAlumnosMaternal();
                foreach ($alumnos as $alumno){
                    $dbm->getConnection()->beginTransaction();
                    $Informe = new MaInforme();
                    $Informe->setAlumnoid($dbm->getRepositorioById("CeAlumno","alumnoid",$alumno["alumnoid"]));
                    $fecha = new \DateTime($filtros["fecha"]["date"]["year"] . "-" . $filtros["fecha"]["date"]["month"] . "-" . $filtros["fecha"]["date"]["day"]);
                    $Informe->setFecha($fecha);
                    $dbm->saveRepositorio($Informe);
                    $dbm->getConnection()->commit();
                }
            }
            $alumnos=$dbm->BuscarAlumnosInforme(array("cicloid"=>$cicloactual->getCicloid(),"fecha"=>$filtros["fecha"],"estatus"=>0));
            $informes = $dbm->BuscarInforme(array("fecha"=>$filtros["fecha"]));

            $informespendientes = $dbm->BuscarInforme(array("fecha"=>$filtros["fecha"],"estatusid"=>0));
            $informesterminados = $dbm->BuscarInforme(array("fecha"=>$filtros["fecha"],"estatusid"=>1));

            $actividad=$dbm->getRepositoriosById("MaActividad","activo",1);
            $higiene=$dbm->getRepositoriosById("MaHigiene","activo",1);
            $inventario=$dbm->getRepositoriosById("MaInventario","activo",1);

            foreach ($alumnos as $alumno){
                $hoy = new \DateTime();
                $datetime2 = $alumno["fechanacimiento"];
                $anios = $hoy->diff($datetime2)->y;
                $meses = $hoy->diff($datetime2)->m;
                $arrayalumnos[]=array(
                "alumnoid"=>$alumno["alumnoid"],
                "completo"=>$alumno["matricula"]." - ".$alumno["primernombre"]." ".$alumno["segundonombre"]." ".$alumno["apellidopaterno"]." ".$alumno["apellidomaterno"],
                "edad"=>$anios,
                "matricula"=>$alumno["matricula"],
                "meses"=>$meses,
                "nivel"=>"Maternal",
                "nombre"=>$alumno["primernombre"]." ".$alumno["segundonombre"]." ".$alumno["apellidopaterno"]." ".$alumno["apellidomaterno"],
                "foto"=>stream_get_contents($alumno["foto"]),
                "estatus"=>$alumno["estatus"]
                );
            }

            return new View(array("informespendientes"=>count($informespendientes),"informes"=>count($informes),"informesterminados"=>count($informesterminados),"alumnos"=>$arrayalumnos,"higiene"=>$higiene,"actividad"=>$actividad,"inventario"=>$inventario), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Maternal/Informe/Consulta", name="indexConsultaInforme")
     */
    public function indexConsultaInforme()
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());

            $alumnos=$dbm->BuscarAlumnosMaternal();
            foreach ($alumnos as $alumno){
                $arrayalumnos[]=array(
                "alumnoid"=>$alumno["alumnoid"],
                "completo"=>$alumno["matricula"]." - ".$alumno["primernombre"]." ".$alumno["segundonombre"]." ".$alumno["apellidopaterno"]." ".$alumno["apellidomaterno"]
                );
            }

            return new View(array("alumnos"=>$arrayalumnos), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Informes en base a los parametros enviados
     * @Rest\Get("/api/Maternal/Informe/", name="BuscarInforme")
     */
    public function getInforme()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            if ($filtros["estatusid"]=="true"){$filtros["estatusid"]=1;}else{$filtros["estatusid"]=$filtros["estatusid"] ? $filtros["estatusid"] : null;}
            $informes = $dbm->BuscarInforme($filtros);
            if (!$informes) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            $cicloactual=$dbm->getRepositorioById("Ciclo","actual",1);
            foreach ($informes as $key=>$informe){
                
                $alumno=$dbm->DatosAlumnoInforme(array("cicloid"=>$cicloactual->getCicloid(),"alumnoid"=>$informe["alumnoid"]));
                $alumno=$alumno[0];
                $hoy = new \DateTime();
                $datetime2 = $alumno["fechanacimiento"];
                $anios = $hoy->diff($datetime2)->y;
                $meses = $hoy->diff($datetime2)->m;
                $arrayalumno=array(
                    "alumnoid"=>$alumno["alumnoid"],
                    "completo"=>$alumno["matricula"]." - ".$alumno["primernombre"]." ".$alumno["segundonombre"]." ".$alumno["apellidopaterno"]." ".$alumno["apellidomaterno"],
                    "edad"=>$anios,
                    "matricula"=>$alumno["matricula"],
                    "meses"=>$meses,
                    "nivel"=>"Maternal",
                    "nombre"=>$alumno["primernombre"]." ".$alumno["segundonombre"]." ".$alumno["apellidopaterno"]." ".$alumno["apellidomaterno"],
                    "foto"=>stream_get_contents($alumno["foto"]),
                    "estatus"=>$alumno["estatus"]
                );
                $informes[$key]["alumno"]=$arrayalumno;
                $informes[$key]["actividad"]=$dbm->getRepositoriosById("MaActividadporinforme","informeid",$informe["informeid"]);
                $informes[$key]["inventario"]=$dbm->getRepositoriosById("MaInventarioporinforme","informeid",$informe["informeid"]);
                $informes[$key]["higiene"]=$dbm->getRepositoriosById("MaHigieneporinforme","informeid",$informe["informeid"]);

            }
            return new View($informes, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Maternal/Informe" , name="GuardarInforme")
     */
    public function SaveInforme()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $fecha=new \DateTime($data["fecha"]["date"]["year"]."-".$data["fecha"]["date"]["month"]."-".$data["fecha"]["date"]["day"]);
            $data["fecha"]=$fecha->format('Y-m-d');
            $informe = $dbm->getByParametersRepositorios('MaInforme', array("fecha"=>$fecha,"alumnoid"=>$data['alumnoid']));
            /*
            if ($informe) {
                return new View("Ya existe una informe para este alumno en la misma fecha", Response::HTTP_PARTIAL_CONTENT);
            }
            */

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Informe = $hydrator->hydrate($informe[0], $data);
            $Informe->setPanal($data["panal"]["cantidad"]);
            $Informe->setPanal1($data["panal"]["pipicantidad"]);
            $Informe->setPanal2($data["panal"]["popo"]);
            $Informe->setPanaltipo($data["panal"]["tipo"]);
            $Informe->setBano($data["bano"]["cantidad"]);
            $Informe->setBano1($data["bano"]["pipicantidad"]);
            $Informe->setBano2($data["bano"]["popo"]);
            $Informe->setBanotipo($data["bano"]["tipo"]);
            $Informe->setAccidente($data["accidente"]["cantidad"]);
            $Informe->setAccidenteaviso($data["accidente"]["aviso"]);
            $Informe->setComida($data["comida"]["cuanto"]);
            $Informe->setComidaobservaciones($data["comida"]["observaciones"]);
            $Informe->setSueno($data["sueno"]["durmio"]);
            $Informe->setSuenohoras($data["sueno"]["horas"]);
            $Informe->setObservaciones($data["actividadesdia"]);
            
            $padres=$dbm->BuscarPadreInforme(array("alumnoid"=>$Informe->getAlumnoid()));

            if ($Informe->getAnimo() && ($Informe->getPanal() || $Informe->getBano()) && $Informe->getComida() && ($Informe->getSueno()==true || $Informe->getSueno()==false) && $Informe->getObservaciones()){
                $Informe->setEstatus(1);
                
                if ($padres) {
                    foreach ($padres as $padre){
                        #API access key from Google API's Console
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
                                'body' 	=> 'Se ha capturado el informe del dia '.$fecha->format('d/m/Y'),
                                'news_type' 	=> 2,
                                'date' 	=> $fecha->format('Y-m-d'),
                                'student_id' 	=> $Informe->getAlumnoid()->getAlumnoid(),
                                'title'	=> 'Informe diario de '.$Informe->getAlumnoid()->getPrimernombre()
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
                            'body' 	=> 'Se ha capturado el informe del dia '.$fecha->format('d/m/Y'),
                            'title'	=> 'Informe diario de '.$Informe->getAlumnoid()->getPrimernombre(),
                            'sound' => 'default'
                            );
                        $datadata=array('news_type' => 2,'date' => $fecha->format('Y-m-d'),'student_id' => $Informe->getAlumnoid()->getAlumnoid());	  
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
            }else{
                $Informe->setEstatus(0);
            }

            $dbm->saveRepositorio($Informe);

            $dbm->removeManyRepositorio("MaActividadporinforme", 'informeid', $Informe->getInformeid());
            foreach ($data["actividadessemana"] as $a) {
                $actividadporinforme = new MaActividadporinforme();
                $actividadporinforme->setInformeid($Informe);
                $actividadporinforme->setActividadid($dbm->getRepositorioById('MaActividad', 'actividadid', $a));
                $dbm->saveRepositorio($actividadporinforme);
            }
            $dbm->removeManyRepositorio("MaInventarioporinforme", 'informeid', $Informe->getInformeid());
            foreach ($data["inventario"] as $i) {
                $item=$dbm->getRepositorioById('MaInventario', 'inventarioid', $i["articulo"]);
                $inventarioporinforme = new MaInventarioporinforme();
                $inventarioporinforme->setInformeid($Informe);
                $inventarioporinforme->setInventarioid($item);
                $inventarioporinforme->setCantidad($i["cantidad"]);
                $dbm->saveRepositorio($inventarioporinforme);
                $items.=$item->getDescripcion()." (".$i["cantidad"]."). ";
            }

 
            $dbm->removeManyRepositorio("MaHigieneporinforme", 'informeid', $Informe->getInformeid());
            foreach ($data["habitos"] as $h) {
                $habito=$dbm->getRepositorioById('MaHigiene', 'higieneid', $h);
                $higieneporinforme = new MaHigieneporinforme();
                $higieneporinforme->setInformeid($Informe);
                $higieneporinforme->setHigieneid($habito);
                $dbm->saveRepositorio($higieneporinforme);
                $habitos.="Por favor ".$habito->getDescripcion().". ";
            }

            if ($Informe->getEstatus() && $padres && ($habitos || $items)) {
                foreach ($padres as $padre){
                    #API access key from Google API's Console
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
                            'body' 	=> $items . chr(10).$habitos,
                            'news_type' 	=> 3,
                            'student_id' 	=> $Informe->getAlumnoid()->getAlumnoid(),
                            'title'	=> 'Inventario y habitos de higiene de '.$Informe->getAlumnoid()->getPrimernombre()
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
                        'body' 	=> $items . chr(10).$habitos,
                        'title'	=> 'Inventario y habitos de higiene de '.$Informe->getAlumnoid()->getPrimernombre(),
                        'sound' => 'default'
                        );
                    $datadata=array('news_type' => 3,'student_id' => $Informe->getAlumnoid()->getAlumnoid());	  
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


            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Maternal/Informe/{id}" , name="ActualizarInforme")
     */
    public function updateInforme($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $fecha=new \DateTime($data["fecha"]["date"]["year"]."-".$data["fecha"]["date"]["month"]."-".$data["fecha"]["date"]["day"]);
            $data["fecha"]=$fecha->format('Y-m-d');

            $informe = $dbm->getRepositorioById('MaInforme', 'informeid', $id);
            if ($informe && $informe->getInformeid() != $id) {
                return new View("Ya existe una informe para este alumno en la misma fecha", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Informe = $hydrator->hydrate($dbm->getRepositorioById('MaInforme', 'informeid', $id), $data);
            $dbm->removeManyRepositorio("MaActividadporinforme", 'informeid', $id);
            foreach ($data["actividadid"] as $a) {
                $actividadporinforme = new MaActividadporinforme();
                $actividadporinforme->setInformeid($Informe);
                $actividadporinforme->setActividadid($dbm->getRepositorioById('MaActividad', 'actividadid', $a));
                $dbm->saveRepositorio($actividadporinforme);
            }
            $dbm->removeManyRepositorio("MaInventarioporinforme", 'informeid', $id);
            foreach ($data["inventarioid"] as $i) {
                $inventarioporinforme = new MaInventarioporinforme();
                $inventarioporinforme->setInformeid($Informe);
                $inventarioporinforme->setInventarioid($dbm->getRepositorioById('MaInventario', 'inventarioid', $i));
                $dbm->saveRepositorio($inventarioporinforme);
            }
            $dbm->removeManyRepositorio("MaHigieneporinforme", 'informeid', $id);
            foreach ($data["higieneid"] as $h) {
                $higieneporinforme = new MaHigieneporinforme();
                $higieneporinforme->setInformeid($Informe);
                $higieneporinforme->setHigieneid($dbm->getRepositorioById('MaHigiene', 'higieneid', $h));
                $dbm->saveRepositorio($higieneporinforme);
            }
            $dbm->saveRepositorio($Informe);
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Maternal/Informe/{id}", name="EliminarInforme")
     */
    public function deleteInforme($id)
    {
        try {
            $dbm = new DbmMaternal($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio("MaActividadporinforme", 'informeid', $id);
            $dbm->removeManyRepositorio("MaInventarioporinforme", 'informeid', $id);
            $dbm->removeManyRepositorio("MaHigieneporinforme", 'informeid', $id);
            $informe = $dbm->getRepositorioById('MaInforme', 'informeid', $id);
            $dbm->removeRepositorio($informe);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
