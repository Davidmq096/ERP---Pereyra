<?php 
namespace AppBundle\Security;
use Datetime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityManager;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function log($data){

        $log = "";
        $log .= "Request origin: " . $data['origin'] . PHP_EOL;
        $log .= "Request uri: ". $data['uri'] . PHP_EOL;
        $log .= "Date: " . $data['date'] . PHP_EOL;
        $log .= "Can pass: " . ($data['canPass'] ? 'True' : 'False') . PHP_EOL;
        $log .= "----------------------------------------------" . PHP_EOL;

        file_put_contents(dirname(dirname(dirname(dirname(__FILE__)))).'/log', $log, FILE_APPEND);
    }

    /**
     * Llamado en cada request. Devolverá las credenciales que quieras,
     * o null para parar la autenticación.
     */
    public function getCredentials(Request $request)
    {
        if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            $origin = $_SERVER['HTTP_REFERER'];
        } else {
            $origin = $_SERVER['REMOTE_ADDR'];
        }
        $route = $_SERVER['REQUEST_URI'];
        $cors = [
            "api/impresiondocumento/token",
            "api/Parametros",
            "api/notificacion/envio",
            "api/Loginexterno",
            "api/Solicitud/tokens/",
            "api/portalfamiliar/Pago",
            "api/prosa/Pago",
            "api/Controlescolar/CronogramaDeTareas/TareaArchivo",
            "api/pagolinea/hash",
            "api//pagolinea/RecibirPago",
            "api/pagoinstitutolux",
            "api/portalfamiliar/registro",
            "api/Parametros",
            "api/login/padres",
            "api/portalfamiliar",
                "api/portalfamiliar/daily-menu/",
                "api/portalfamiliar/report/",
                "api/portalfamiliar/report/",
                "api/portalfamiliar/report/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/parents/",
                "api/Comunicacion/Notificacion/Imagen/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/AlumnoPorPadreTutor",
                "/api/pagolinea/hash",
                "/api/portalfamiliar/datosfacturacion",
                "/api/portalalumno/calendario",
                "/api/portalalumno/tipoevento",
                "/api/portalfamiliar/daily-menu",
                "/api/portalfamiliar/report",
                "/api/portalfamiliar/report/",
                "/api/portalfamiliar/report/",
                "/api/Directorioescolar",
                "/api/Controlescolar/Boletaimpresion/alumno/",
                "/api/Controlescolar/CronogramaDeTareas/TareasAlumno",
                "/api/Controlescolar/CronogramaDeTareas/TareaArchivo/",
                "/api/Controlescolar/CronogramaDeTareas/TareaAlumno",
                "/api/Controlescolar/CronogramaDeTareas/Vinculos",
                "/api/portalalumno/notificaciones",
                "/api/Parametros/",
                "/api/Parametros/Appmovil/",
                "/api/portalfamiliar/parents/",
                "/api/portalfamiliar/parents/",
                "/api/portalfamiliar/pagoenlinea/bypadreotutor/",
                "/api/portalfamiliar/parents/",
                "/api/portalfamiliar/AlumnoPorPadreTutor/",
                "/api/portalfamiliar/Pago/SolicitudCobro",
                "/api/portalfamiliar/qrshare",
                "/api/portalfamiliar/Reportedisciplina",
                "/api/Transporte/Boleto",
                "/api/Alumno/",
                "/api/portalalumno/calificaciones",
                "/api/Transporte/Misboletos",
                "/api/Transporte/Boleto/pdf/",
                "/api/Transporte/Boleto/Vender",
                "/api/Controlescolar/conftallerextracurricular/alumno",
                "/api/Controlescolar/conftallerextracurricular/GuardarTallerAlumno",
            "api/portalfamiliar/RecuperarPassword",
            "api/portalfamiliar/CambiarPassword",
            "api/Loginexterno",
            "api/portalfamiliar/Pago",
            "api/pagolinea/RecibirPago",
            "api/pagoinstitutolux",
            "api/Comunicacion/Notificacion/Envio",
            "api/Comunicacion/Notificacion/Imagen",
            "api/Alumno/foto",
            "api/Solicitud/foto/",
            "api/Profesor/foto/",
            "api/Controlescolar/Evento/Imagen/"
        ];

        for($i = 0; $i < count($cors); $i++){
            $preg = $cors[$i];
            if (strpos($route, $preg) !== false) {
                $this->log([
                    'origin' => $origin,
                    'uri' => $route,
                    'date' => date('Y-m-d h:i:s'),
                    'canPass' => true
                ]);
                return [
                    'token' => 'generico'
                ];
            }
        }

        $source = file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))).'/env');
        $source = explode(PHP_EOL, $source);
        $env = [];
        

        foreach($source as $s){
            $ss = explode(':', $s);
            $v = trim($ss[1]);
            if($v == 'true'){
                $v = true;
            }else if($v == 'false'){
                $v = false;
            }
            $env[$ss[0]] = $v;
        }

				$pr='PortalAdmision';
				$origins=[];
				$envSource=(isset($env['Source']) ? $env['Source'] : "");
				switch($envSource){
					case "ciencias":
						$pr="portaladmision";
						$origins=[
								"https://www.idc.edu.mx/erp",
								"https://www.idc.edu.mx/PortalAdmision",
								"https://www.idc.edu.mx/portaladmision",
								"https://www.idc.edu.mx/PortalFamiliar",
								"https://www.idc.edu.mx/PortalAlumnos",
								"https://idc.edu.mx/erp",
								"https://idc.edu.mx/PortalAdmision",
								"https://idc.edu.mx/portaladmision",
								"https://idc.edu.mx/PortalFamiliar",
								"https://idc.edu.mx/PortalAlumnos",
								"https://www.idc.edu.mx/Jesuitas_webServicesMoviles",
								"https://idc.edu.mx/Jesuitas_webServicesMoviles",
                                "34.236.34.42",
                                "https://idc.edu.mx/",
                                "https://www.idc.edu.mx/"
							];
						break;
					case "cienciasQA":
						$pr="portaladmision";
						$origins=[
								"https://www.idc.edu.mx/QA/erp",
								"https://www.idc.edu.mx/QA/PortalAdmision",
								"https://www.idc.edu.mx/QA/portaladmision",
								"https://www.idc.edu.mx/QA/PortalFamiliar",
								"https://www.idc.edu.mx/QA/PortalAlumnos",
								"https://idc.edu.mx/QA/erp",
								"https://idc.edu.mx/QA/PortalAdmision",
								"https://idc.edu.mx/QA/portaladmision",
								"https://idc.edu.mx/QA/PortalFamiliar",
								"https://idc.edu.mx/QA/PortalAlumnos",
								"https://www.idc.edu.mx/QA/Jesuitas_webServicesMoviles",
								"https://idc.edu.mx/QA/Jesuitas_webServicesMoviles",
								"34.236.34.42",
                                "https://idc.edu.mx/",
                                "https://www.idc.edu.mx/"
							];
						break;
					case "lux":
						$origins=[
								"https://www.lux.org.mx/erp",
								"https://www.lux.org.mx/PortalAdmision",
								"https://www.lux.org.mx/portaladmision",
								"https://www.lux.org.mx/PortalFamiliar",
								"https://www.lux.org.mx/PortalAlumnos",
								"https://lux.org.mx/erp",
								"https://lux.org.mx/PortalAdmision",
								"https://lux.org.mx/portaladmision",
								"https://lux.org.mx/PortalFamiliar",
								"https://lux.org.mx/PortalAlumnos",
								"http://lux.org.mx/Jesuitas_webServicesMoviles",
								"http://www.lux.org.mx/Jesuitas_webServicesMoviles",
								"34.194.224.137",
                                "https://idc.edu.mx/",
                                "https://www.idc.edu.mx/"
							];
						break;
					case "luxQA":
						$origins=[
								"https://www.lux.org.mx/QA/erp/",
								"https://www.lux.org.mx/QA/PortalAdmision/",
								"https://www.lux.org.mx/QA/portaladmision/",
								"https://www.lux.org.mx/QA/PortalFamiliar/",
								"https://www.lux.org.mx/QA/PortalAlumnos/",
								"https://lux.org.mx/QA/erp/",
								"https://lux.org.mx/QA/PortalAdmision/",
								"https://lux.org.mx/QA/portaladmision/",
								"https://lux.org.mx/QA/PortalFamiliar/",
								"https://lux.org.mx/QA/PortalAlumnos/",
								"http://lux.org.mx/QA/Jesuitas_webServicesMoviles",
								"http://www.lux.org.mx/QA/Jesuitas_webServicesMoviles",
								"34.194.224.137",
                                "https://idc.edu.mx/",
                                "https://www.idc.edu.mx/"
							];
						break;
					case "inceptio":
						$pr="";
						$origins=[
								"18.216.81.32/inceptioQA/erp",
								"18.216.81.32/inceptioQA/PortalAdmisionCiencias",
								"18.216.81.32/inceptioQA/PortalAdmisionLux",
								"18.216.81.32/inceptioQA/PortalFamiliarCiencias",
								"18.216.81.32/inceptioQA/PortalFamiliarLux",
								"18.216.81.32/inceptioQA/PortalAlumnos"
							];
						break;
					case "development":
						$origins=[
								"localhost:3000",
								"192.168.0.117",
								"::1"
							];
						break;

				}
        $canPass=false;
				foreach($origins as $o){
					if(strpos($origin, $o)!== false){
						$canPass=true;
					}
				}


				$envEnabled=(isset($env['Enabled']) ? $env['Enabled'] : null);
				if(!$envEnabled){
            $this->log([
                'origin' => $origin,
                'uri' => $route,
                'date' => date('Y-m-d h:i:s'),
                'canPass' => true
            ]);
            return [
                'token' => 'generico'
            ];
        }

        if(!$canPass){
            $availableURLS = [
                "api/portalfamiliar",
                "api/portalfamiliar/daily-menu/",
                "api/portalfamiliar/report/",
                "api/portalfamiliar/report/",
                "api/portalfamiliar/report/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/parents/",
                "api/Comunicacion/Notificacion/Imagen/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/parents/",
                "api/portalfamiliar/AlumnoPorPadreTutor",
                "/api/pagolinea/hash",
                "/api/portalfamiliar/datosfacturacion",
                "/api/portalalumno/calendario",
                "/api/portalalumno/tipoevento",
                "/api/portalfamiliar/daily-menu",
                "/api/portalfamiliar/report",
                "/api/portalfamiliar/report/",
                "/api/portalfamiliar/report/",
                "/api/Directorioescolar",
                "/api/Controlescolar/Boletaimpresion/alumno/",
                "/api/Controlescolar/CronogramaDeTareas/TareasAlumno",
                "/api/Controlescolar/CronogramaDeTareas/TareaArchivo/",
                "/api/Controlescolar/CronogramaDeTareas/TareaAlumno",
                "/api/Controlescolar/CronogramaDeTareas/Vinculos",
                "/api/portalalumno/notificaciones",
                "/api/Parametros/",
                "/api/Parametros/Appmovil/",
                "/api/portalfamiliar/parents/",
                "/api/portalfamiliar/parents/",
                "/api/portalfamiliar/pagoenlinea/bypadreotutor/",
                "/api/portalfamiliar/parents/",
                "/api/portalfamiliar/AlumnoPorPadreTutor/",
                "/api/portalfamiliar/Pago/SolicitudCobro",
                "/api/portalfamiliar/qrshare",
                "/api/portalfamiliar/Reportedisciplina",
                "/api/Transporte/Boleto",
                "/api/Alumno/",
                "/api/portalalumno/calificaciones",
                "/api/Transporte/Misboletos",
                "/api/Transporte/Boleto/pdf/",
                "/api/Transporte/Boleto/Vender",
                "/api/Controlescolar/conftallerextracurricular/alumno",
                "/api/Controlescolar/conftallerextracurricular/GuardarTallerAlumno",
            ];
            $found = false;
            for($i = 0; $i < count($availableURLS); $i++){
                $preg = $availableURLS[$i];
                if (strpos($route, $preg) !== false) {
                    $found = true;
                }
            }
            if(!$found){
                $this->log([
                    'origin' => $origin,
                    'uri' => $route,
                    'date' => date('Y-m-d h:i:s'),
                    'canPass' => false
                ]);
                return false;
            }
        }
        
        if($request->headers->get('X-AUTH-TOKEN')){
            // Lo que se devuelva aquí se pasará a getUser() como $credentials
            $this->log([
                'origin' => $origin,
                'uri' => $route,
                'date' => date('Y-m-d h:i:s'),
                'canPass' => true
            ]);
            return array(
                'token' => $request->headers->get('X-AUTH-TOKEN'),
            );
        }else{

            if(strpos($origin, $pr) !== false){
                $availableURLS = [
                    'api/formato',
                    'api/descarga',
                    'api/formato/',
                    'api/listaasistencia',
                    'api/listaasistencia/',
                    'api/Familiar/infoComplementaria/',
                    'api/Solicitud/direccion/cp',
                    'api/Familiar/infoComplementaria/',
                    'api/Familiar/datosFamiliares/padres',
                    'api/Familiar/datosFamiliares/padres/',
                    'api/Solicitud/personaRecogen/',
                    'api/bachillerato',
                    'api/bachillerato/',
                    'api/ciudad',
                    'api/ciudad/',
                    'api/Colonia/',
                    'api/colonia',
                    'api/colonia/',
                    'api/departamento',
                    'api/departamento/',
                    'api/edificio',
                    'api/edificio/',
                    'api/estado',
                    'api/estado/',
                    'api/Motivobaja',
                    'api/Motivobaja/',
                    'api/nacionalidad',
                    'api/nacionalidad/',
                    'api/Ocupacion',
                    'api/Ocupacion/',
                    'api/pais',
                    'api/Familiar/datosAspirante',
                    'api/Familiar/datosAspirante',
                    'api/Solicitud/dinamicaFamiliar/',
                    'api/Solicitud/dinamicaFamiliar/',
                    'api/Familiar/documentacion',
                    'api/Solicitud/documentacion/validacion/',
                    'api/Solicitud/documentacion/',
                    'api/Solicitud/DownloadFormatoSolicitud',
                    'api/Familiar/domicilioActual',
                    'api/Solicitud/encuesta/',
                    'api/Familiar/expediente/',
                    'api/Familiar/expediente/gradorepetido/',
                    'api/Familiar/expediente/grados/',
                    'api/Familiar/datosFamiliares',
                    'api/Familiar/datosFamiliares/padres',
                    'api/Solicitud/personaRecogen/',
                    'api/Solicitud/personaRecogen/',
                    'api/Solicitud/datosFamiliares/padres/',
                    'api/Familiar/datosFamiliares/',
                    'api/Solicitud/direccion/cp',
                    'api/Solicitud/hermano',
                    'api/Familiar/datosFamiliares/Hermanos',
                    'api/Familiar/datosFamiliares/Hermano/',
                    'api/Familiar/datosFamiliares/',
                    'api/Solicitud/hermano/infoAdicional',
                    'api/Familiar/home',
                    'api/Familiar/',
                    'api/Familiar/EnvioCorreoSolicitud/',
                    'api/Solicitud',
                    'api/Solicitud/Login/',
                    'api/Solicitud/datoMedico',
                    'api/Solicitud/DownloadFormatoSolicitud',
                    'api/reciboinscripcion/getdatosimpresion/'
                ];
            }else if(strpos($origin, 'erp') !== false){
                $availableURLS = [
                    'Aplicacionexamen/Lista/',
                    'Aplicacionexamen/Tiempo/',
                    'Aplicacionexamen/Reactivos',
                    'Aplicacionexamen/Examen',
                    "api/Loginexterno",
                    "api/Parametros"
                ];
            }else if(strpos($origin, 'PortalFamiliar') !== false){
                $availableURLS = [
                    "api/Parametros"
                ];
            }else{
                $availableURLS = [];
            }

            

            for($i = 0; $i < count($availableURLS); $i++){
                $preg = $availableURLS[$i];
                if (strpos($route, $preg) !== false) {
                    $this->log([
                        'origin' => $origin,
                        'uri' => $route,    
                        'date' => date('Y-m-d h:i:s'),
                        'canPass' => true
                    ]);
                    return [
                        'token' => 'generico'
                    ];
                }
            }

            $this->log([
                'origin' => $origin,
                'uri' => $route,
                'date' => date('Y-m-d h:i:s'),
                'canPass' => false
            ]);

            return false;
        }
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $apiKey = $credentials['token'];

        if($apiKey == 'generico'){
            return new \AppBundle\Security\User;
        }
        $now = new DateTime();

        

        // si es null, la autenticación fallará
        // si es un objeto User se llama a checkCredentials()
        $qb =  $this->em->createQueryBuilder();
        $session = $qb->select('s')
            ->from('AppBundle:Sesion', 's')
            ->where('s.token = :token')
            ->andWhere('s.finaliza > :finaliza')
            ->setParameter('finaliza', $now->format('Y-m-d H:i:s'))
            ->setParameter('token', $apiKey);
        
        $res = $session->getQuery()->getResult();
        if(count($res) == 0){
            return null;
        }

        if(!$res[0]->getUsuarioid()){
            return null;
        }else{
            return new \AppBundle\Security\User;
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // comprueba las credenciales - e.g. asegurar que el password es válido
        // no se necesita comprobación de credenciales en este caso

        // devuelve true con autenticación exitosa
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // si es exitoso, dejar que el request continúe
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        
        $data = array(
            'version' => '0.0.1',
            'message' => 'No tienes permiso para realizar esta peticion',
            'status' => 403
        );
        return new JsonResponse($data, 403);
    }

    /**
     * Llamado cuando se necesita autenticación pero no se ha enviado
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            // puedes traducir este mensaje también
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, 401);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}