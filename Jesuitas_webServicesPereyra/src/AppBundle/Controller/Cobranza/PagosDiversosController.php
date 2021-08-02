<?php

namespace AppBundle\Controller\Cobranza;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\Ciclo;
use AppBundle\Entity\CeCiclopornivel;
use AppBundle\Entity\CjPagosdiversos;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmCobranza;
use AppBundle\Entity\CjDocumento;
use AppBundle\Entity\CjDocumentoporpagar;

/**
 * @author Mariano
 */
class PagosDiversosController extends FOSRestController
{
    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cobranza/PagosDiversos/DatosIniciales", name="DatosIniciales")
     */
    public function DatosIniciales()
    {
        try {
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $data = $dbm->getUsuarioporsubconcepto();
            $usuarios = $data[0];
            $subconceptos = $data[1];
            $niveles = $dbm->getRepositoriosById("Nivel", "activo", 1);
            $grados = $dbm->getRepositoriosById("Grado", "activo", 1);

            $cicloactual = $dbm->getRepositorioById("Ciclo", "actual", 1);
            $grupos = $dbm->getByParametersRepositorios("CeGrupo",
                array("cicloid"=> $cicloactual->getCicloid(), "tipogrupoid" => 1)
            );

            foreach($subconceptos as &$subconcepto){
                $subconcepto['importepornivel'] = $dbm->getSubconceptoPorNivel($subconcepto['subconceptoid']);
            }

            return new View([
                'usuarios' => $usuarios,
                'subconceptos' => $subconceptos,
                'nivel' => $niveles,
                'grado' => $grados,
                'grupo' => $grupos
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Cobranza/PagosDiversos/Filtrar", name="Filtrar")
     */
    public function Filtrar()
    {
        try {
        	$filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $subconceptos = $dbm->getDocumentosPorPagar($filtros);
            foreach($subconceptos as $key => $subconcepto){
                $alumnos = $dbm->getAlumnosPorSubconcepto([
                    'alumnos' => $subconcepto['alumnos'],
                    'subconceptoid' => $subconcepto['subconceptoid'],
                    'inner' => true
                ]);
                $subconceptos[$key]['alumnos'] = $alumnos;
            }
            return new View($subconceptos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Cobranza/PagosDiversos/Alumnos", name="obtenerAlumnos")
     */
    public function AlumnosPorGrupo()
    {
        try {
        	$datos = $_REQUEST;
    		$filtros = array_filter($datos);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $alumnos = $dbm->getAlumnosPorSubconcepto([
                'grupoid' => $filtros['grupoid'],
                'subconceptoid' => $filtros['subconceptoid']
            ]);  
            return new View($alumnos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Cobranza/PagosDiversos/Guardar", name="guardarDocumentos")
     */
    public function GuardarDocumentosPorPagar()
    {
        try {
        	$filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmCobranza($this->get("db_manager")->getEntityManager());
            $alumnos = (empty($filtros['Alumnos']) ? $filtros['AlumnosTemp'] :  $filtros['Alumnos']);
            $eliminados = $filtros['AlumnosEliminados'];
            $dbm->getConnection()->beginTransaction();
            $subconcepto = $dbm->getRepositorioById('CjSubconcepto','subconceptoid',$filtros['subconceptoid']);

            if(!$subconcepto->getFincobro()){
                return new View("No se ha configurado la fecha limite de pago", Response::HTTP_PARTIAL_CONTENT);
            }
            $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
            $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
            $pagoestatus = $dbm->getRepositorioById('CjPagoestatus','pagoestatusid',1);
            $usuario = $dbm->getRepositorioById('Usuario','usuarioid',$filtros['usuarioid']);

            if(empty($filtros['pagodiversoid'])){
                $pagodiverso = new CjPagosdiversos();
                $pagodiverso->setSubconceptoid($subconcepto);
                $pagodiverso->setUsuarioid($usuario);
                $pagodiverso->setDescripcion($filtros['Concepto']);
                $pagodiverso->setFechahora(new \Datetime());
                $dbm->saveRepositorio($pagodiverso);
            }else{
                $pagodiverso = $dbm->getRepositorioById('CjPagosdiversos','pagodiversoid',$filtros['pagodiversoid']);
            }

            foreach($eliminados as $eliminado){
                $documentoporpagar = $dbm->getRepositorioById('CjDocumentoporpagar','documentoporpagarid', $eliminado['documentoporpagarid']);
                if($documentoporpagar){
                    $dbm->removeRepositorio($documentoporpagar);
                }
            }

            foreach($alumnos as $alumno){
                $al = $dbm->getRepositorioById('CeAlumno','alumnoid',$alumno['alumnoid']);
                if($al){
                    $grado = $dbm->getRepositorioById('Grado','gradoid',$alumno['gradoid']);
                    if($alumno['nuevo']){
                        $documentoporpagar = new CjDocumentoporpagar();
                        $documentoporpagar->setDocumentoid($documento);
                        $documentoporpagar->setSubconceptoid($subconcepto);
                        $documentoporpagar->setPagoestatusid($pagoestatus);
                        $documentoporpagar->setAlumnoid($al);
                        $documentoporpagar->setCicloid($subconcepto->getCicloid());
                        $documentoporpagar->setGradoid($grado);
                        $documentoporpagar->setImporte($alumno['importe']);
                        $documentoporpagar->setSaldo($alumno['saldo']);
                        $documentoporpagar->setFechacreacion(new \Datetime());
                        // if($alumno['fechalimite']){
                        //     $documentoporpagar->setFechalimitepago(new \Datetime($alumno['fechalimite']));
                        //     $documentoporpagar->setFechaprontopago(new \Datetime($alumno['fechalimite']));
                        // }else{
                        // }
                        $documentoporpagar->setFechalimitepago($subconcepto->getFincobro());
                        $documentoporpagar->setFechaprontopago($subconcepto->getFincobro());
                        $documentoporpagar->setConcepto($filtros['Concepto']);
                        $documentoporpagar->setPagodiversoid($pagodiverso);
                        $dbm->saveRepositorio($documentoporpagar);
                    }else{
                        if($alumno['candEdit']){
                            $documentoporpagar = $dbm->getRepositorioById('CjDocumentoporpagar','documentoporpagarid', $alumno['documentoporpagarid']);
                            $documentoporpagar->setImporte($alumno['importe']);
                            $documentoporpagar->setSaldo($alumno['saldo']);
                            $documentoporpagar->setConcepto($filtros['Concepto']);
                            $dbm->saveRepositorio($documentoporpagar);
                        }
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View('Se guardo el registro correctamente', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Cobranza/PagosDiversos/VerificarMatriculas", name="VerificarMatriculas")
     */
	public function VerificarMatriculas(){
			try{
			$filtros=json_decode(file_get_contents("php://input"), true);
			$dbm=new DbmCobranza($this->get("db_manager")->getEntityManager());
			$matriculas=[];
			$matriculasraw=$filtros['matriculas'];
			$matriculasrawe=explode(',',$matriculasraw);
			foreach($matriculasrawe AS $imatricularaw){
				$imatricula=preg_replace(["/\n*\t*\r* */"],"",$imatricularaw);
				$matriculas[]=$imatricula;
			}
			$matriculasu=array_unique($matriculas);
			foreach($matriculasu AS $imatricula){
				$alumno=$dbm->getRepositorioById('CeAlumno', 'matricula', $imatricula);
				if(!$alumno){
					return new View("La matrícula $imatricula no existe", Response::HTTP_PARTIAL_CONTENT);
				}
			}
			$alumnos=$dbm->getAlumnosPorSubconcepto([
                    'matriculas'=>implode(",",$matriculasu),
                    'subconceptoid' => $filtros['subconceptoid']
				]);
			$alumnosSz=count($alumnos);
			$matriculasuSz=count($matriculasu);
			if($alumnosSz==0 || $alumnosSz!==$matriculasuSz){
				return new View("Verifíca que los alumnos esten asignados a un grupo", Response::HTTP_PARTIAL_CONTENT);
			}
			return new View($alumnos, Response::HTTP_OK);
		}catch(\Exception $e){
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}
}
