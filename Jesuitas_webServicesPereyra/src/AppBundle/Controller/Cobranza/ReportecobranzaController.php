<?php

namespace AppBundle\Controller\Cobranza;

use AppBundle\Controller\lib\PDFMerger\PDFMerger;
use AppBundle\DB\DbmCobranza;
use AppBundle\DB\DbmMaternal;
use AppBundle\Dominio\Correo;
use AppBundle\Entity\CbRegistroenviocorreo;
use Dompdf\Dompdf;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;

/**
 * Auto: Javier
 */
class ReportecobranzaController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cobranza/Reportecobranza", name="indexReportecobranza")
     */
    public function indexReportecobranza()
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $alumnoestatus = $dbm->getRepositoriosById('CeAlumnoestatus', 'activo', 1);
            $estatusacuerdo = $dbm->getRepositoriosById('CbEstatusacuerdo', 'activo', 1);

            return new View(array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                "grupo" => $grupo,
                "alumnoestatus" => $alumnoestatus,
                "estatusacuerdo" => $estatusacuerdo,
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/Cobranza/Reportecobranza/", name="BuscarReportecobranza")
     */
    public function getReportecobranza()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarReportecobranza($filtros);

            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de filtros iniciales
     * @Rest\Post("/api/Cobranza/Reportecobranza/FamiliaSaldosPendientes", name="FamiliaSaldosPendientes")
     */
    public function FamiliaSaldosPendientes()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $clavefamiliarid = implode(",", $data["clavefamiliarid"]);
            $path = str_replace('app', '', $this->get('kernel')->getRootDir());
            $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";

            switch (ENTORNO) {
                case 1:
                    $logo = $path . "Lux/logo.png";
                    $plantilla = "'" . $path . "Lux/Saldos_pendientes_por_familia_Lux.jrxml'";
                    break;
                case 2:
                    $logo = $path . "Ciencias/logo.png";
                    $plantilla = "'" . $path . "Ciencias/Saldos_pendientes_por_familia_Ciencias.jrxml'";
                    break;
            }

            $jasper = new JasperPHP($this->container);
            $respuesta = $jasper->process(
                $plantilla,
                "'" . $path . "Saldos_pendientes_por_familia'",
                array("pdf"),
                array("clavefamiliarids" => $clavefamiliarid, "logo" => $logo),
                true
            )->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/Saldos_pendientes_por_familia.pdf";
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
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Cobranza/Reportecobranza", name="EmailReportecobranza")
     */
    public function emailReportecobranza()
    {
        try {

            $datos = $_REQUEST;
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());

            //Creamos un nuevo objeto de email especifico para cobranza, (No usar el correo generico)
            self::Mailer($dbm);
            $correoPlatilla = $dbm->getRepositorioById('Correo', 'correoid', 9);

            $acuerdo = 0;
            $aviso = 0;
            $suspension = 0;
            foreach ($datos["reporte"] as $a) {
                $correoid;
                switch ($a["tipo"]) {
                    case "acuerdo":
                        $correoid = 11;
                        $acuerdo += 1;
                        break;
                    case "aviso":
                        $correoid = 12;
                        $aviso += 1;
                        break;
                    case "suspension":
                        $correoid = 13;
                        $suspension += 1;
                        break;
                }
                $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
                $alumno = $dbma->BuscarAlumnosA(array("alumnoid" => $a["alumnoid"]))[0];
                self::PDF($dbma, $correoid, $alumno);
                self::email($dbm, $alumno, $correoPlatilla);
                $alumnopush = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $a["alumnoid"]);
                if($alumnopush) {
                    self::enviarNotificacion($alumnopush, new \Datetime());
                }
            }

            //Enviar correo se confirmacion a usuario logueado
            $correoPlatilla = $dbm->getRepositorioById('Correo', 'correoid', 10);
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $datos["usuarioid"]);
            $correo = array($usuario->getPersonaid()->getEmail());
            $parametros = array(
                "carta30" => $acuerdo,
                "carta60" => $aviso,
                "carta90" => $suspension,
            );
            Correo::ServicioCorreo($correo, $parametros, $correoPlatilla, $this->_mailer);

            return new View("Los correos se han enviado correctamente", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Get("/api/Cobranza/Reportecobranza/Imprimir/", name="DownloadReportecobranza")
     */
    public function downloadReportecobranza()
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());

            $pdf = new PDFMerger;
            foreach ($datos["reporte"] as $a) {
                $correoid;
                switch ($a["tipo"]) {
                    case "acuerdo":
                        $correoid = 11;
                        break;
                    case "aviso":
                        $correoid = 12;
                        break;
                    case "suspension":
                        $correoid = 13;
                        break;
                }
                $dbma = new DbmControlescolar($this->get("db_manager")->getEntityManager());
                $alumno = $dbma->BuscarAlumnosA(array("alumnoid" => $a["alumnoid"]))[0];
                self::PDF($dbma, $correoid, $alumno);
                $pdf->addPDF('carta' . $alumno["alumnoid"] . '.pdf');
            }

            $pdf->merge('file');
            $file = file_get_contents('newfile.pdf');
            $size = filesize('newfile.pdf');

            $response = new \Symfony\Component\HttpFoundation\Response(
                $file,
                200,
                array(
                    'Content-Type' => "application/pdf",
                    'Content-Length' => $size
                )
            );

            $files = glob('*.pdf'); //get all file names
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

            return $response;
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function PDF($dbm, $carta, $alumno)
    {
        try {
            $documentos = $dbm->BuscarEstadocuenta(array("alumnoid" => $alumno["alumnoid"], "tipoestadocuenta" => 2));
            $alumno["familia"] = "{$alumno['apellidopaterno']} {$alumno['apellidomaterno']}";
            $alumno["hoy"] = (new \DateTime())->format('d/m/Y');
            $alumno["fechanacimiento"] = $alumno["fechanacimiento"] ? $alumno["fechanacimiento"]->format('d/m/Y') : null;
            $alumno["alumno"] = "{$alumno['primernombre']} {$alumno['segundonombre']} {$alumno['familia']}";
            $contenido = $dbm->getRepositorioById('Correo', 'correoid', $carta)->getCuerpo();

            $saldo = 0;
            $recargo = 0;
            $total = 0;
            foreach ($documentos as $d) {
                $alumno["documentos"] .= "<tr>";
                $alumno["documentos"] .= "<td class='tg-0lax'>" . $d["documento"] . "</td>";
                $alumno["documentos"] .= "<td class='tg-0lax'>" . $d["concepto"] . "</td>";
                $alumno["documentos"] .= "<td class='tg-0lax'>" . $d["fechalimitepago"] . "</td>";
                $alumno["documentos"] .= "<td class='tg-0lax'>" . $d["diasretraso"] . "</td>";
                $alumno["documentos"] .= "<td class='tg-0lax'>" . '$' . number_format($d["saldo"], 2) . "</td>";
                $alumno["documentos"] .= "<td class='tg-0lax'>" . '$' . number_format($d["recargo"], 2)  . "</td>";
                $alumno["documentos"] .= "<td class='tg-0lax'>" . '$' . number_format($d["total"], 2) . "</td>";
                $alumno["documentos"] .= "</tr>";
                $saldo += $d["saldo"];
                $recargo += $d["recargo"];
                $total += $d["total"];
            }

            $alumno["documentos"] .= "<tr>";
            $alumno["documentos"] .= "<td colspan='4' class='total'>Total: </td>";
            $alumno["documentos"] .= "<td class='bordenegro'>" . '$' . number_format($saldo, 2)   . "</td>";
            $alumno["documentos"] .= "<td class='bordenegro'>" . '$' . number_format($recargo, 2)  . "</td>";
            $alumno["documentos"] .= "<td class='bordenegro'>" . '$' . number_format($total, 2)  . "</td>";
            $alumno["documentos"] .= "</tr>";

            foreach ($alumno as $key => $value) {
                $contenido = str_replace('${' . $key . '}', $value, $contenido);
            }

            $dompdf = new Dompdf();
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->load_html($contenido);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('carta' . $alumno["alumnoid"] . '.pdf', $output);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    private $_mailer;
    public function Mailer($dbm)
    {
        $parametros = $dbm->getRepositorioById('Parametros', 'nombre', "Correo de cobranza");
        list($user, $pass) = explode(",", $parametros->getValor());
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
            ->setUsername($user)
            ->setPassword($pass);
        $transport->registerPlugin(new \Swift_Plugins_ImpersonatePlugin($user));
        $this->_mailer = new \Swift_Mailer($transport);
    }

    public function email($dbm, $alumno, $correoPlatilla)
    {
        $path = $this->container->getParameter('kernel.root_dir');
        $pathTemp = realpath($path . '/../web');
        $correosenviados = [];

        $clavefamiliar = $dbm->getRepositoriosById('CeAlumnoporclavefamiliar', 'alumnoid', $alumno["alumnoid"]);
        foreach ($clavefamiliar as $cf) {
            $correosporenviar = [];
            $papas = $dbm->getRepositoriosById('CePadresotutoresclavefamiliar', 'clavefamiliarid', $cf->getClavefamiliarid());        
            $correos = array($dbm->getRepositorioById('CeAlumno', 'alumnoid', $alumno["alumnoid"])->getCorreoinstitucional());
            if($correos[0] && !in_array($correos[0], $correosenviados)) {
                array_push($correosenviados, $correos[0]);
                array_push($correosporenviar,$correos[0]);
            }
            foreach ($papas as $p) {
                if(!in_array($p->getPadresotutoresid()->getCorreo(), $correosenviados)) {
                    array_push($correosenviados, $p->getPadresotutoresid()->getCorreo());
                    array_push($correosporenviar, $p->getPadresotutoresid()->getCorreo());
                }
            }
            $parametros = array("familia" => $cf->getClavefamiliarid()->getApellidopaterno() . " " . $cf->getClavefamiliarid()->getApellidomaterno());
    
            //test .... borrar
            //$correos = array("javiermanrique509@gmail.com");
    
            $correos = array_filter($correosporenviar);
            Correo::ServicioCorreo(
                $correos,
                $parametros,
                $correoPlatilla,
                $this->_mailer,
                array("ruta" => $pathTemp . '/carta' . $alumno["alumnoid"] . '.pdf', "nombre" => "Carta.pdf")
            );
        }

        $registroenviocorreo = $dbm->getRepositorioById('CbRegistroenviocorreo', 'alumnoid', $alumno["alumnoid"]);
        $registroenviocorreo = $registroenviocorreo ? $registroenviocorreo : new CbRegistroenviocorreo();
        $registroenviocorreo->setAlumnoid($dbm->getRepositorioById('CeAlumno', 'alumnoid', $alumno["alumnoid"]));
        $registroenviocorreo->setFecha(new \DateTime());
        $dbm->saveRepositorio($registroenviocorreo);

        //Forza ha enviar el correo de inmediato
        //$transport = $this->_mailer->getTransport();
        //$transport->getSpool()->flushQueue($this->container->get('swiftmailer.transport.real'));

        //Eliminamos el archivo adjunto
        unlink('carta' . $alumno["alumnoid"] . '.pdf');
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
                                'body' 	=> "Ha recibido en su correo electrónico un aviso de cobranza. Para más detalles revise su correo electrónico o comuníquese al departamento de cobranza del Instituto",
                                'news_type' 	=> 4,
                                'date' 	=> $fecha->format('Y-m-d'),
                                'student_id' 	=> $alumno->getAlumnoid(),
                                'title'	=> 'Aviso de cobranza'
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
}
