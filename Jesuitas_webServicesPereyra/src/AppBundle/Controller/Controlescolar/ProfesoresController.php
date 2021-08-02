<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeEstudiosprofesor;
use AppBundle\Entity\CeProfesor;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Rest\Api;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
/**
 * Auto: Judith
 */
class ProfesoresController extends FOSRestController
{

    /**
     * Retorna estatus del empleado (profesor)
     * @Rest\Get("/api/Profesor", name="indexProfesores")
     */
    public function indexProfesor()
    {
        try {
            $dbm = $this->get("db_manager");
            $estatus = $dbm->getRepositoriosById('CeEstatusempleado', 'activo', 1);
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            return new View(array(
                'estatusprofesor' => $estatus,
                'ciclo' => $ciclo
            ), Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
	 * @Rest\Get("/api/Profesor/foto/", name="getProfesorFoto")
	 */
	public function getProfesorFoto()
	{
		try {
			$datos = $_REQUEST;
			$filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $foto = $dbm->BuscarFotoProfesor($filtros);
            $foto = $foto ? stream_get_contents($foto[0]['fotografia']) : null;

            if($foto){
                return Api::download($foto, 'image/png');
            }else{
                $root = str_replace('app', '', $this->get('kernel')->getRootDir()) . "web/avatar.png";
                return Api::download(base64_encode(file_get_contents($root)), 'image/png');
            }
            
		} catch (Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

    /**
     * Retorna filtros profesores
     * @Rest\Post("/api/Profesor/Filtrar", name="Profesorfiltro")
     */
    public function Profesorfiltro()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = $this->get("db_manager");
            $dbm = new DbmControlescolar($dbm->getEntityManager());
            $entidad = $dbm->BuscarProfesorfiltro($decoded);
            $url = $dbm->getRepositorioById('Parametros', 'nombre', 'URLServicios');
            if (!$entidad) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach ($entidad as $ent) {
                $ent->setFotografia($url->getValor() . '/api/Profesor/foto/?profesorid=' . $ent->getProfesorid());
                //$ent->setNombre($ent->getNombre()." ".$ent->getApellidopaterno()." ".$ent->getApellidomaterno());
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Profesor/{id}", name="EliminarProfesor")
     */
    public function deleteProfesor($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $profesor = $dbm->getRepositorioById('CeProfesor', 'profesorid', $id);
            $dbm->removeRepositorio($profesor);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Profesor/Combos", name="ProfesorCombos")
     */
    public function ProfesorCombos()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $pais = $dbm->getRepositoriosById('Pais', 'activo', 1);
            $estado = $dbm->getRepositoriosById('Estado', 'activo', 1);
            $ciudad = $dbm->getRepositorios('Municipio');
            $situacionc = $dbm->getRepositorios('Situacionconyugal');
            $maestro = $dbm->getRepositoriosById('CeEstatusempleado', 'activo', 1);
            $parentesco = $dbm->getRepositorios('Parentesco');
            $estudio = $dbm->getRepositoriosById('CeEstatusestudio', 'activo', 1);
            $escolaridad = $dbm->getRepositorios('Escolaridad');
            return new View(array("Pais" => $pais, "Estado" => $estado, "Ciudad" => $ciudad, "SituacionConyugal" => $situacionc, 'profesor' => $maestro, 'parentesco' => $parentesco, 'estatusestudio' => $estudio, 'escolaridad' => $escolaridad), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Profesor" , name="GuardarProfesor")
     */
    public function SaveProfesor()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if ($data["curp"]) {
                $profesor = $dbm->getRepositorioById("CeProfesor", "curp", $data["curp"]);
            }
            if ($profesor) {
                return new View(array("estatus" => "curp", "mensaje" => "El CURP capturado ya está asignado al profesor " . $profesor->getNombre() . " " . $profesor->getApellidoPaterno()), Response::HTTP_PARTIAL_CONTENT);
            }
            $profesor = $dbm->getRepositorioById("CeProfesor", "numeronomina", $data["numeronomina"]);
            if ($profesor) {
                return new View(array("estatus" => "nomina", "mensaje" => "El número de nomina ya está asignado al profesor " . $profesor->getNombre() . " " . $profesor->getApellidoPaterno()), Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Profesor = $hydrator->hydrate(new CeProfesor(), $data);
            if (is_numeric($data['colonia'])) {
                $Profesor->setColoniaid($dbm->getRepositorioById("Colonia", "coloniaid", $data["colonia"]));
            } else {
                $Profesor->setOtraColonia($data["otracolonia"]);
            }
            $Profesor->setExperienciainstituto($dateinstituto);
            $dbm->saveRepositorio($Profesor);

            $dbm->getConnection()->commit();
            return new View($Profesor, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Profesor/{id}" , name="ActualizarProfesor")
     */
    public function updateProfesor($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if($data["curp"]){
                $profesor = $dbm->getRepositorioById("CeProfesor", "curp", $data["curp"]);
            }
            if ($profesor && $profesor->getProfesorid() != $id) {
                return new View(array("estatus" => "curp", "mensaje" => "El CURP capturado ya está asignado al profesor " . $profesor->getNombre() . " " . $profesor->getApellidoPaterno()), Response::HTTP_PARTIAL_CONTENT);
            }
            $profesor = $dbm->getRepositorioById("CeProfesor", "numeronomina", $data["numeronomina"]);
            if ($profesor && $profesor->getProfesorid() != $id) {
                return new View(array("estatus" => "nomina", "mensaje" => "El número de nomina ya está asignado al profesor " . $profesor->getNombre() . " " . $profesor->getApellidoPaterno()), Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Profesor = $hydrator->hydrate($dbm->getRepositorioById('CeProfesor', 'profesorid', $id), $data);
            if(!$data['curp']){
                $Profesor->setCurp(null);
            }
            if(!$data['rfc']){
                $Profesor->setRfc(null);
            }
            if(!$data['nacionalidad']){
                $Profesor->setNacionalidad(null);
            }
            if(!$data['celular']){
                $Profesor->setCelular(null);
            }
            if(!$data['celular2']){
                $Profesor->setCelular2(null);
            }
            if(!$data['correopersonal']){
                $Profesor->setCorreopersonal(null);
            }
            if(!$data['correoinstitucional']){
                $Profesor->setCorreoinstitucional(null);
            }
            if(!$data['estadocivil']){
                $Profesor->setEstadocivil(null);
            }
            if(!$data['estadoid']){
                $Profesor->setEstadoid(null);
            }
            if(!$data['experienciasep']){
                $Profesor->setExperienciasep(null);
            }
            if(!$data['parentescoid']){
                $Profesor->setParentescoid(null);
            }
            if(!$data['telefonofijo']){
                $Profesor->setTelefonofijo(null);
            }
            if(!$data['ciudadid']){
                $Profesor->setCiudadid(null);
            }
            if (is_numeric($data['colonia'])) {
                $Profesor->setColoniaid($dbm->getRepositorioById("Colonia", "coloniaid", $data["colonia"]));
            } else {
                $Profesor->setOtraColonia($data["otracolonia"]);
            }
            $Profesor->setExperienciainstituto($dateinstituto);
            $dbm->saveRepositorio($Profesor);

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Retorna arreglo de estudios de Profesores en base a los parametros enviados
     * @Rest\Get("/api/Profesor/{id}/Estudios", name="BuscarEstudiosProfesor")
     */
    public function getEstudiosProfesor($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->getRepositoriosById("CeEstudiosprofesor", "profesorid", $id);
            $fechainiciolaboral = $dbm->BuscarFechainiciolaboralprofesor($id)[0]['fecha'];
            if (!$entidad) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }

            return new View(["data"=>$entidad,"fechalaboral"=>$fechainiciolaboral], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Profesor/{id}/Estudios" , name="GuardarEstudioProfesor")
     */
    public function SaveEstudiosProfesor($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Estudio = $hydrator->hydrate(new CeEstudiosprofesor(), $data);
            $dbm->saveRepositorio($Estudio);

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Profesor/Estudios/{id}" , name="ActualizarEstudioProfesor")
     */
    public function updateEstudiosProfesor($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Estudio = $hydrator->hydrate($dbm->getRepositorioById('CeEstudiosprofesor', 'estudioprofesorid', $id), $data);
            $dbm->saveRepositorio($Estudio);

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Profesor/Estudios/{id}", name="EliminarEstudioProfesor")
     */
    public function deleteEstudioProfesor($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $estudio = $dbm->getRepositorioById('CeEstudiosprofesor', 'estudioprofesorid', $id);
            $dbm->removeRepositorio($estudio);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Profesores en base a los parametros enviados
     * @Rest\Get("/api/Profesor/Directorio", name="BuscarProfesores")
     */
    public function getProfesores()
    {
        try {
            $filtros = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarProfesorfiltroNivel($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

        /**
    * @Rest\Get("/api/Profesor/listaMateriasProfesor/", name="getMateriasprofesorreport")
    */
    public function getMateriasprofesorreport() {
        $datos = $_REQUEST;
        $filtros = array_filter($datos);

        $env=[1=>"Lux/",2=>"Ciencias/"];
        try{
            $root=str_replace('app', '', $this->get('kernel')->getRootDir());
            $envPath=$env[ENTORNO];
            $mPath="src/AppBundle/Dominio/Reporteador/Plantillas/";
            $bPath="{$mPath}{$envPath}";
            $path=$root.$bPath;
            $pathLogo="{$path}logo.png";
            if($filtros['tipo'] == "1") {
                $pathRep="{$path}Profesormaterias.jrxml";
                $pathOutput="{$mPath}Profesormaterias";
            } else {
                $pathRep="{$path}Profesorhorario.jrxml";
                $pathOutput="{$mPath}Profesorhorario";
            }
            $pathFile="../{$pathOutput}.pdf";
            $jpReport=$this->getCMDPath($pathRep);
            $jpOutput=$this->getCMDPath($root.$pathOutput);
            $jpLogo=$this->getCMDPath($pathLogo);
            $profesores = implode(",", $filtros['profesorid']);
            $params=[
                "cicloid"=>$filtros['cicloid'],
                "profesorid"=>$profesores,
                "logo"=>$pathLogo
            ];
            $jasper=new JasperPHP($this->container);
            $response=$jasper->process(
                $jpReport,
                $jpOutput,
                array("pdf"),
                $params,
                true
            )->output();/*->output();
            echo($response."\n");
            return '';
            //*/
            return ($response
                ? new View("Error procesando reporte", Response::HTTP_PARTIAL_CONTENT)
                : new \Symfony\Component\HttpFoundation\Response(
                    file_get_contents($pathFile), 200, array(
                        'Content-Type'=>'application/pdf',
                        'Content-Length'=>filesize($pathFile)
                    )
                )
            );
        }catch(Exception $e){ return new View($e->getMessage(), Response::HTTP_BAD_REQUEST); }
    }

            /**
    * @Rest\Get("/api/Profesor/ReporteProfesores/{profesorid}", name="getProfesoresReport")
    */
    public function getProfesoresReport() {
        $datos = $_REQUEST;
        $filtros = array_filter($datos);
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $env=[1=>"Lux/",2=>"Ciencias/"];
        try{
            $datos = $dbm->ProfesorReportInfo();
            foreach ($datos as $key=>$d) {
                $exp = null;
                $fechas = $dbm->loadHorarioMateria($d['profesorid']);
                $fechas = array_values(array_column($fechas, 'FechaInicio'));
                $fechas = implode("\n", $fechas);
                $datos[$key]['fechaasignatura'] = $fechas;
                if($d['fechainiciolaboral']) {
                    $edad = $this->calcular_edad($d['fechainiciolaboral']);
                    $exp = $edad->format('%y') . ' años y ' . $edad->format('%m') . ' meses';
                }                
                $datos[$key]['experienciaplantel'] = $exp ? $exp : '';
            }

			$report="ProfesoresReport";
			$filebase="$report-".(rand()%10000);
            $pdf=new LDPDF($this->container, $report, $filebase, ['driver'=>'json', 'data_file'=>$filebase, 'json_query'=>'""'], [], ['xlsx']);
            $data = array("prof" => $datos, "prueba" => "simon");
			$this->fileWrite($pdf->fdb_r, json_encode($data));
            $result=$pdf->execute();
            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/$filebase.xlsx";
            if (!$reporte) {
                return new View("No se ha podido procesar el reporte", Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte),
                200,
                array(
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
                    'Content-Length' => filesize($reporte)
                )
            );
			LDPDF::fileDelete($pdf->fdb_r);
			if(!$result){
				LDPDF::fileDelete($pdf->output_r);
            }
            return $response;
        }catch(Exception $e){ return new View($e->getMessage(), Response::HTTP_BAD_REQUEST); }
    }

    private function getCMDPath($x){
        return "\"$x\"";
    }

    private function fileWrite($path, $data){
		$file=LDPDF::fileRead($path);
		LDPDF::fileWrite($file, $data);
		LDPDF::fileRelease($file);
		return true;
    }
    
    function calcular_edad($fecha){
        $fecha_nac = new \DateTime(date('Y/m/d',strtotime($fecha))); // Creo un objeto DateTime de la fecha ingresada
        $fecha_hoy =  new \DateTime(date('Y/m/d',time())); // Creo un objeto DateTime de la fecha de hoy
        $edad = date_diff($fecha_hoy,$fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto
        return $edad;
    }
}
