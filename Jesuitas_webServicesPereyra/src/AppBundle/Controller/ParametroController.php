<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\DB\DbmAdmisiones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Notificacion;
/**
 * Auto: Javier
 */

class ParametroController extends FOSRestController
{
    /**
     * Retorna los parametros al iniciar la aplicacion
     * @Rest\Get("/api/Parametros", name="inicioParametros")
     */
    public function indexParametro()
    {
        try {
            $dbm = $this->get("db_manager");
            $entidad = $dbm->getRepositoriosById('Parametros', 'nombre', array(
                "HoraInicioLaboral", "HoraFinLaboral", "BloqueoLogin", "ValidaSesion","VideoInicioPortalFamiliar"));
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de ciudades en base a los parametros enviados
     * @Rest\Put("/api/VersionSistema/{id}", name="VersionSistemas")
     */
    public function VersionSistemas($id)
    {
        try {
            $path = str_replace('app', '', $this->get('kernel')->getRootDir());
            $sistema = $path . "web/sistema.txt";
            file_put_contents($sistema, $id);
            return new View(Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna los parametros al iniciar la aplicacion
     * @Rest\Get("/api/Parametros/{id}", name="inicioExpresionregular")
     */
    public function indexRegExr($id)
    {
        try {
            $dbm = $this->get("db_manager");
            $entidad = $dbm->getRepositorioById('Usuario', 'usuarioid', $id);
            return new View(array("regexr" => $entidad->getTipousuarioid()->getExpresion(), "leyenda" => $entidad->getTipousuarioid()->getComentarioexpresion()), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna los parametros al iniciar la aplicacion movil
     * @Rest\Get("/api/Parametros/Appmovil/", name="inicioParametrosAppMovil")
     */
    public function indexappMovil()
    {
        try {
            $dbm = $this->get("db_manager");
            $entidad = $dbm->getRepositoriosById('Parametros', 'nombre', array(
                "HoraNotificacionMatutina", "HoraNotificacionVespertina", "HoraNotificacionNocturna","VersionMaternalAndroid","VersionAlumnosAndroid","VersionPadresAndroid","VersionMaternaliOs","VersionAlumnosiOs","VersionPadresiOs","VersionTransporteAndroid", "ComunicacionLimiteRenglonTitulo", "ComunicacionLimiteRenglonTituloImg"));
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Descarga un formato solicitud con los tokens remplazados
     * @Rest\Get("/api/Solicitud/tokens/{solicitudId}", name="SolicitudTokens")
     */
    public function SolicitudTokens($solicitudId)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

        $vista_solicitud = $dbm->BuscarVistasolicitud($solicitudId);
        return new View($vista_solicitud, Response::HTTP_OK);
    }
    /**
     * Descarga un formato solicitud con los tokens remplazados
     * @Rest\Get("/api/impresiondocumento/token", name="SolicitudTokensVista")
     */
    public function SolicitudTokensVista()
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());

        $vista_solicitud = $dbm->BuscarVistasolicitud($_GET['solicitudId']);
        $vista_solicitud["Foto"] = NULL;
        $vista_solicitud["FotoFamiliar"] = NULL;
        return new View($vista_solicitud, Response::HTTP_OK);
    }
	/**
	 * Retorna los parametros al iniciar la aplicacion movil
	 * @Rest\Get("/api/Parametros/Menu/{sistemaid}", name="getMenuBySistema")
	 */
	public function getMenuBySistema($sistemaid){
		try{
			$dbm=$this->get("db_manager");
			$data=$dbm->getRepositoriosModelo("Menuconfiguracion",["d.menuconfiguracionid AS id","IDENTITY(d.menuconfiguracionparentid) AS parentid","d.title","d.key","d.icon","d.color","d.action"],["sistema"=>$sistemaid,"activo"=>1],["orden"=>"ASC"]);
			return new View($data, Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
    }
    
    /**
	 * Retorna los parametros al iniciar la aplicacion movil
	 * @Rest\Post("/api/nnotificacion/usuario", name="NotificacionUsuario")
	 */
	public function NotificacionUsuario(){
		try{
			$dbm=$this->get("db_manager");
			$content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['UsuarioId']);

            if($usuario){
                $notificacion = new Notificacion();
                $notificacion->setLeido(0);
                $notificacion->setTiponotificacionid(3);
                $notificacion->setFechacreacion(new \DateTime());
                $notificacion->setUsuarioid();
                $dbm->saveRepositorio($notificacion);
            }

			return new View($notificacion, Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
    }

    /**
	 * Retorna los parametros al iniciar la aplicacion movil
	 * @Rest\Get("/api/notificacion/envio", name="NotificacionEnvio")
	 */
	public function NotificacionEnvio(){
		try{
			$dbm=$this->get("db_manager");
			$content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            

            $notificaciones = $dbm->getRepositoriosById('Notificacion', 'fechaenvio', null);
            $usuarios = [];
            foreach($notificaciones as $notificacion){
                $notificacion->setLeido(1);
                $notificacion->setFechaenvio(new \DateTime());
                $dbm->saveRepositorio($notificacion);
                $usuarios[] = [
                    'UsuarioId' =>  $notificacion->getUsuarioid()->getUsuarioid()
                ];
            }

            $urlServicios = $dbm->getRepositorioById('Parametros', 'nombre', "URLSeguridad");

            $url = $urlServicios->getValor().'notificacion/envio';
            
            $ch = curl_init($url);                                                                      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

            
            $datastring = json_encode($usuarios);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);   
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
            $result = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            

			return new View($usuarios, Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
    }

    /**
	 * Retorna los parametros al iniciar la aplicacion movil
	 * @Rest\Get("/api/menuerp", name="MenuERP")
	 */
	public function MenuERP(){
		try{
			$dbm=$this->get("db_manager");
            $modulos = $dbm->getRepositoriosModelo("Modulo", 
            ["d.moduloid, d.identificador, d.nombre, d.activo, concat_ws('','#sidebar-',d.identificador) as id"], ["activo" => true, "sistema" => 1], ["orden" => 'ASC']);

            foreach($modulos as $key=>$m) {
                $submodulos = $dbm->getRepositoriosModelo("Submodulo", 
                ["d.submoduloid, IDENTITY(d.moduloid) moduloid, d.identificador, d.nombre, d.activo"], 
                    [["activo = 1 and d.moduloid = " . $m['moduloid']]], ["orden" => 'ASC'], true, []);

                foreach($submodulos as $kyz=>$s) {
                    $pantalla = $dbm->getRepositoriosModelo("Pantalla", 
                    ["d.pantallaid, IDENTITY(d.submoduloid) submoduloid, d.identificador, d.nombre, d.activo, d.orden, d.url"], 
                        [["activo = 1 and d.submoduloid = " . $s['submoduloid']]], ["orden" => 'ASC'], true, []);
                    
                    $submodulos[$kyz]['pantallas'] = $pantalla;
                }
                $modulos[$key]['submodulos'] = $submodulos;
            }

			return new View($modulos, Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
    }
}