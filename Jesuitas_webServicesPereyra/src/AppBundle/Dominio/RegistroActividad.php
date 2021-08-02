<?php

namespace AppBundle\Dominio;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Entity\CeActividad;

/**
 * Description of Registro de actividad
 *
 * @author Mariano
 */
class RegistroActividad
{

    public static function ActividadAlumno($actividad, $entidad, $dbm, \Swift_Mailer $mailer, $paramsMail)
    {
        $hydrator = new ArrayHydrator($dbm->getEntityManager());
        $tipoactividad = $dbm->getRepositorioById("CeTipoactividad", "tipoactividadid", $actividad["tipoactividadid"]);
        $actividad["fecha"] = new \DateTime();
        $arraydestino = [];
        $registros = $actividad["registros"];
        $usuarioorigen = $dbm->getRepositorioById("Usuario", "usuarioid", $actividad["usuarioorigenid"]);
        $usuariodestino = $dbm->getRepositorioById("Usuario", "usuarioid", $actividad["usuariodestinoid"]);

        if ($usuarioorigen) {
            $cuentausuarioorigen = $usuarioorigen->getCuenta();
        }

        $clase = substr(get_class($entidad), 17, strlen(get_class($entidad)) - 17);
        if ($clase == "CePlantillaprofesor") {
            $grado = $entidad->getPlanestudioid()->getGradoid()->getGrado();
            $nivel = $entidad->getPlanestudioid()->getGradoid()->getNivelid()->getNombre();
        }
        if ($clase == "CeReportedisciplina") {
            $grado = $entidad->getAlumnoporcicloid()->getGradoid()->getGrado();
            $nivel = $entidad->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNombre();
            $tiporeporte = $entidad->getTiporeporteid()->getNombre();
            $matricula = $entidad->getAlumnoporcicloid()->getAlumnoid()->getMatricula();
            $alumno = $entidad->getAlumnoporcicloid()->getAlumnoid()->getApellidopaterno() . " " . $entidad->getAlumnoporcicloid()->getAlumnoid()->getApellidomaterno() . " " . $entidad->getAlumnoporcicloid()->getAlumnoid()->getPrimernombre() . " " . $entidad->getAlumnoporcicloid()->getAlumnoid()->getSegundonombre();
            $mpe = $entidad->getMateriaporplanestudiosid() ? $entidad->getMateriaporplanestudiosid()->getMateriaporplanestudioid() : '';
            $actividad["materiaporplanestudioid"] = $mpe;
        }
        if ($clase == "CeTareaalumno") {
            $tareanombre = $entidad->getTareaid()->getNombre();
            $tareanumero = $entidad->getTareaid()->getCaptura();
            $matricula = $entidad->getAlumnoid()->getMatricula();
            $alumno = $entidad->getAlumnoid()->getApellidopaterno() . " " . $entidad->getAlumnoid()->getApellidomaterno() . " " . $entidad->getAlumnoid()->getPrimernombre() . " " . $entidad->getAlumnoid()->getSegundonombre();
        }
        if ($clase == "CeAlumnocicloportallerextra") {
            $tallernombre = $entidad->getTallerextraid()->getNombre();
            $matricula = $entidad->getAlumnoporcicloid()->getAlumnoid()->getMatricula();
            $alumno = $entidad->getAlumnoporcicloid()->getAlumnoid()->getApellidopaterno() . " " . $entidad->getAlumnoporcicloid()->getAlumnoid()->getApellidomaterno() . " " . $entidad->getAlumnoporcicloid()->getAlumnoid()->getPrimernombre() . " " . $entidad->getAlumnoporcicloid()->getAlumnoid()->getSegundonombre();
        }



        $parametros = array("UsuarioOrigen" => $cuentausuarioorigen, "Grado" => $grado, "Nivel" => $nivel, "Registros" => $registros, "TipoDeReporte" => $tiporeporte, "Matrícula" => $matricula, "Alumno" => $alumno, "TareaNombre" => $tareanombre, "TareaNumero" => $tareanumero, "TallerNombre" => $tallernombre);
        if ($tipoactividad->getDescripcionalumno()) {
            $descripcion = $tipoactividad->getDescripcionalumno();
        } else {
            $descripcion = $tipoactividad->getDescripcionadmin();
        }
        if (!$descripcion) {
            $descripcion = $tipoactividad->getNombre();
        }

        //Se genera el registro de notificacion
        $actividad["usuariodestinoid"] = (string) $actividad["usuariodestinoid"];
        $arraydestino = explode(",", $actividad["usuariodestinoid"]);
        foreach ($arraydestino as $us) {
            $actividades = $actividad;
            $usdestino = $dbm->getRepositorioById("Usuario", "usuarioid", $us);
            $actividades["descripcion"] = $descripcion;
            $actividades["materiaporplanestudioid"] = $paramsMail["materiaporplanestudioid"];
            $actividades["usuariodestinoid"] = $us;
            $Actividad = $hydrator->hydrate(new CeActividad(), $actividades);
            $dbm->saveRepositorio($Actividad);
        }

        //Envio de email
        if ($tipoactividad->getEmail()) {
            //Email a personal
            if ($tipoactividad->getDescripcionadmin()) {
                if ($usuarioorigen) {
                    if ($usuarioorigen && $usuarioorigen->getProfesorid()) {
                        $emailadmin = $usuarioorigen->getProfesorid()->getCorreoinstitucional();
                    } else if ($usuarioorigen->getPersonaid()) {
                        $emailadmin = $usuarioorigen->getPersonaid()->getEmail();
                    } else if ($usuarioorigen && $usuarioorigen->getPadreotutorid()) {
                        $emailadmin = $usuarioorigen->getPadreotutorid()->getCorreo();
                    } else if ($usuarioorigen && $usuarioorigen->getAlumnoid()) {
                        $emailadmin = $usuarioorigen->getAlumnoid()->getCorreoinstitucional();
                    }
                    $email = $emailadmin;
                    if ($email) {
                        $cuerpo = $tipoactividad->getDescripcionadmin();
                        $correo = new \AppBundle\Entity\Correo();
                        $correo->setMotivo($tipoactividad->getNombre());
                        $correo->setCuerpo($cuerpo);
                        $respuesta = \AppBundle\Dominio\Correo::ServicioCorreo(array($email), $paramsMail ? $paramsMail : $parametros, $correo, $mailer);
                    }
                }
                $actividad["usuariodestinoid"] = (string) $actividad["usuariodestinoid"];
                $arraydestino = explode(",", $actividad["usuariodestinoid"]);
                foreach ($arraydestino as $us) {
                    $usdestino = $dbm->getRepositorioById("Usuario", "usuarioid", $us);
                    if ($usdestino && $usdestino->getProfesorid()) {
                        $emaildestino = $usdestino->getProfesorid()->getCorreoinstitucional();
                    } elseif ($usdestino->getPersonaid()) {
                        $emaildestino = $usdestino->getPersonaid()->getEmail();
                    } else if ($usdestino && $usdestino->getPadreotutorid()) {
                        $emaildestino = $usdestino->getPadreotutorid()->getCorreo();
                    } else if ($usdestino && $usdestino->getAlumnoid()) {
                        $emaildestino = $usdestino->getAlumnoid()->getCorreoinstitucional();
                    }
                    $email = $emaildestino;
                    if ($email) {
                        $cuerpo = $tipoactividad->getDescripcionadmin();
                        $correo = new \AppBundle\Entity\Correo();
                        $correo->setMotivo($tipoactividad->getNombre());
                        $correo->setCuerpo($cuerpo);
                        $respuesta = \AppBundle\Dominio\Correo::ServicioCorreo(array($email), $paramsMail ? $paramsMail : $parametros, $correo, $mailer);
                    }
                }
            }

            //Email a alumno
            if ($tipoactividad->getDescripcionalumno()) {
                if ($usuariodestino) {
                    if ($usuariodestino->getAlumnoid()) {
                        $emailalumno = $usuariodestino->getAlumnoid()->getCorreoinstitucional();
                        if ($emailalumno) {
                            $email = $emailalumno;
                            $cuerpo = $tipoactividad->getDescripcionalumno();
                            $correo = new \AppBundle\Entity\Correo();
                            $correo->setMotivo($tipoactividad->getNombre());
                            $correo->setCuerpo($cuerpo);
                            \AppBundle\Dominio\Correo::ServicioCorreo(array($email),  $paramsMail ? $paramsMail : $parametros, $correo, $mailer);
                        }
                    }
                }
            }

            //Email a padre
            if ($tipoactividad->getDescripcionpadre()) {
                if ($usuariodestino) {
                    if ($usuariodestino->getAlumnoid()) {
                        $clavefamiliar = $dbm->getRepositorioById("CeAlumnoporclavefamiliar", "alumnoid", $usuariodestino->getAlumnoid());
                        $padres = $dbm->getRepositoriosById("CePadresotutoresclavefamiliar", "clavefamiliarid", $clavefamiliar->getClavefamiliarid());
                        foreach ($padres as $padre) {
                            $emailpadres[] = $padre->getPadresotutoresid()->getCorreo();
                        }
                        if ($emailpadres) {
                            $cuerpo = $tipoactividad->getDescripcionpadre();
                            $correo = new \AppBundle\Entity\Correo();
                            $correo->setMotivo($tipoactividad->getNombre());
                            $correo->setCuerpo($cuerpo);
                            \AppBundle\Dominio\Correo::ServicioCorreo($emailpadres, $parametros, $correo, $mailer);
                        }
                    }
                }
            }
        }

        //Notificacion movil
        if ($tipoactividad->getMovil()) {
            //APP alumnos
            if ($tipoactividad->getDescripcionalumno()) {
                if ($usuariodestino) {
                    if ($usuariodestino->getAlumnoid()) {
                        $cuerpo = $tipoactividad->getDescripcionalumno();
                        foreach ($parametros as $key => $value) {
                            $cuerpo = str_replace('{' . $key . '}', $value, $cuerpo);
                        }
                        #API access key from Google API's Console
                        $googleApiKey = $dbm->getRepositorioById('Parametros', 'nombre', 'GoogleApiKey');
                        $headers = array(
                            'Authorization: key=' . $googleApiKey->getValor(),
                            'Content-Type: application/json'
                        );

                        //ANDROID
                        $msg = array(
                            'body'     => $cuerpo,
                            'news_type'     => 2,
                            'date'     => $actividad["fecha"]->format('Y-m-d'),
                            'student_id'     => $usuariodestino->getAlumnoid()->getAlumnoid(),
                            'title'    => $tipoactividad->getNombre()
                        );
                        $fields = array(
                            'condition'        => "'user" . $usuariodestino->getUsuarioid() . "' in topics && 'android' in topics && 'alumnos' in topics",
                            'data'    => $msg
                        );



                        #Send Reponse To FireBase Server	
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                        $result = curl_exec($ch);
                        curl_close($ch);

                        //IOS
                        $msg = array(
                            'body'     => $cuerpo,
                            'title'    => $tipoactividad->getNombre(),
                            'sound' => 'default'
                        );
                        $datadata = array('news_type' => 2, 'date' => $actividad["fecha"]->format('Y-m-d'), 'student_id' => $usuariodestino->getAlumnoid()->getAlumnoid());
                        $fields = array(
                            'condition'        => "'user" . $usuariodestino->getUsuarioid() . "' in topics && !('android' in topics) && 'alumnos' in topics",
                            'notification'    => $msg,
                            'data' => $datadata
                        );


                        #Send Reponse To FireBase Server	
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                        $result = curl_exec($ch);
                        curl_close($ch);
                    }
                }
            }
            //APP padres
            if ($tipoactividad->getDescripcionpadre()) {
                if ($usuariodestino) {
                    if ($usuariodestino->getAlumnoid()) {

                        $cuerpo = $tipoactividad->getDescripcionpadre();
                        foreach ($parametros as $key => $value) {
                            $cuerpo = str_replace('{' . $key . '}', $value, $cuerpo);
                        }
                        $clavefamiliar = $dbm->getRepositorioById("CeAlumnoporclavefamiliar", "alumnoid", $usuariodestino->getAlumnoid());
                        $padres = $dbm->getRepositoriosById("CePadresotutoresclavefamiliar", "clavefamiliarid", $clavefamiliar->getClavefamiliarid());
                        foreach ($padres as $padre) {
                            $usuariopadre = $dbm->getRepositorioById("Usuario", "padreotutorid", $padre->getPadresotutoresid())->getUsuarioid();
                            if ($usuariopadre) {
                                #API access key from Google API's Console
                                $googleApiKey = $dbm->getRepositorioById('Parametros', 'nombre', 'GoogleApiKey');
                                $headers = array(
                                    'Authorization: key=' . $googleApiKey->getValor(),
                                    'Content-Type: application/json'
                                );

                                //ANDROID
                                $msg = array(
                                    'body'     => $cuerpo,
                                    'news_type'     => 2,
                                    'date'     => $actividad["fecha"]->format('Y-m-d'),
                                    'student_id'     => $usuariodestino->getAlumnoid()->getAlumnoid(),
                                    'title'    => $tipoactividad->getNombre()
                                );
                                $fields = array(
                                    'condition'        => "'user" . $usuariopadre . "' in topics && 'android' in topics && 'padres' in topics",
                                    'data'    => $msg
                                );



                                #Send Reponse To FireBase Server	
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                                $result = curl_exec($ch);
                                curl_close($ch);

                                //IOS
                                $msg = array(
                                    'body'     => $cuerpo,
                                    'title'    => $tipoactividad->getNombre(),
                                    'sound' => 'default'
                                );
                                $datadata = array('news_type' => 2, 'date' => $actividad["fecha"]->format('Y-m-d'), 'student_id' => $usuariodestino->getAlumnoid()->getAlumnoid());
                                $fields = array(
                                    'condition'        => "'user" . $usuariopadre . "' in topics && !('android' in topics) && 'padres' in topics",
                                    'notification'    => $msg,
                                    'data' => $datadata
                                );


                                #Send Reponse To FireBase Server	
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                                $result = curl_exec($ch);
                                curl_close($ch);
                            }
                        }
                    }
                }
            }
        }
    }
}
