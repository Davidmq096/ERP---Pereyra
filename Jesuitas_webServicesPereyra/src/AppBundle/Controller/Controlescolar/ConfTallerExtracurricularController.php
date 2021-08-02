<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeConftalleresextracurriculares;
use AppBundle\Entity\CeTallerextraperiodoinscripcion;
use AppBundle\Entity\CeTallerextrareglamento;
use AppBundle\Entity\CeTallerextraopcionregistro;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CjDocumentoporpagar;
use AppBundle\Entity\CeAlumnocicloportallerextra;
use AppBundle\Entity\CeTallerbitacora;

/**
 * Auto: David Medina
 */
class ConfTallerExtracurricularController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/conftallerextracurricular", name="indexConfTallerExtra")
     */
    public function indexConfTallerExtra()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $periodostipo = $dbm->getRepositorios('CeTallerextraperiodoinscripciontipo');
            $frecuenciapago = $dbm->getRepositoriosById('CeTallerfrecuenciapago', 'activo', 1);
            $opcionesregistro = $dbm->getRepositorios('CeTallerextraopcionregistro');
            $tallerreglamento = $dbm->getRepositorios('CeTallerextrareglamento');
            $periodoinscripcion = $dbm->getRepositorios('CeTallerextraperiodoinscripcion');
            $conftaller = $dbm->getRepositorios('CeConftalleresextracurriculares');
            $clasificador = $dbm->getRepositoriosById('CeClasificadorparaescolares', 'activo', 1);

            return new View(array(
                "clasificador" => $clasificador,
                "nivel" => $nivel,
								"semestre" => $semestre,
								"tallerextraperiodoinscripciontipo" => $periodostipo,
                "frecuenciapago" => $frecuenciapago,
                "opcionesregistro" => $opcionesregistro,
                "tallerreglamento" => $tallerreglamento,
                "periodoinscripcion" => $periodoinscripcion,
                "conftaller" => $conftaller
        ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Post("/api/Controlescolar/conftallerextracurricular" , name="SaveConfExtracurricular")
     */
    public function SaveConfExtracurricular()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $data['conftallerextracurricularid'] ? $tallerextracurricular = $dbm->getRepositorioById('CeConftalleresextracurriculares', 'conftallerextracurricularid', $data['conftallerextracurricularid'])
            : $tallerextracurricular = new CeConftalleresextracurriculares();
            $tallerextracurricular->setHorasreservacion(empty($data['horasreservacion']) ? null : $data['horasreservacion']);
            $tallerextracurricular->setDescuentoempleados(empty($data['pagodescuento']) ? null : $data['pagodescuento']);
            $tallerextracurricular->setFechatallersem1inicio(empty($data['fechasem1inicio']) ? null : new \DateTime($data['fechasem1inicio']));
            $tallerextracurricular->setFechatallersem1fin(empty($data['fechasem1fin']) ? null : new \DateTime($data['fechasem1fin']));
            $tallerextracurricular->setFechatallersem2inicio(empty($data['fechasem2inicio']) ? null : new \DateTime($data['fechasem2inicio']));
            $tallerextracurricular->setFechatallersem2fin(empty($data['fechasem2fin']) ? null : new \DateTime($data['fechasem2fin']));
            $dbm->saveRepositorio($tallerextracurricular);

            
						$dbm->deletePeriodosInscripcionExtra();
						$niveles=$dbm->getRepositorios("Nivel");
						$semestres=$dbm->getRepositorios("CeSemestre");
						$pitipos=$dbm->getRepositorios("CeTallerextraperiodoinscripciontipo");
						$nivelesr=[];
						$semestresr=[];
						$pitiposr=[];
						foreach($niveles AS $i){ $nivelesr[$i->getNivelid()]=$i; }
						foreach($semestres AS $i){ $semestresr[$i->getSemestreid()]=$i; }
						foreach($pitipos AS $i){ $pitiposr[$i->getTallerextraperiodoinscripciontipoid()]=$i; }
            foreach($data['periodosinscripcion'] AS $i){
							if(empty($i['nivelid']) || empty($i['tallerextraperiodoinscripciontipoid']) || empty($i['fechainicio']) || empty($i['fechafin'])){
								$dbm->getConnection()->rollBack();
								return false;
							}
							$periodo=new CeTallerextraperiodoinscripcion();
							$nivel=$nivelesr[$i['nivelid']];
							$tipo=$pitiposr[$i['tallerextraperiodoinscripciontipoid']];
							$periodo->setNivelid($nivel);
							$periodo->setTallerextraperiodoinscripciontipoid($tipo);
							$periodo->setFechainicio(new \DateTime($i['fechainicio']));
							$periodo->setFechafin(new \DateTime($i['fechafin']));
							if($nivel->getRequieresemestre()){
								if(!empty($i['semestreid'])){
									$periodo->setSemestreid($semestresr[$i['semestreid']]);
								}else{
									$dbm->getConnection()->rollBack();
									return false;
								}
							}
							$dbm->saveRepositorio($periodo);
            }


            foreach($data['preregistrosgrado'] as $g){
                $g['talleropcionid'] ? $preregistro = $dbm->getRepositorioById('CeTallerextraopcionregistro', 'tallerextraopcionregistroid', $g['talleropcionid'])
                 : $preregistro = new CeTallerextraopcionregistro();
                $grado = $dbm->getRepositorioById('Grado', 'gradoid', $g['gradoid']);
                $preregistro->setGradoid(empty($g['gradoid']) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $g['gradoid']));
                $preregistro->setTipopago(empty($g) ?
                null : $g['tipopago']);
                $preregistro->setNotalleres(empty($g) ?
                null : $g['opcion']);
                $preregistro->setFrecuenciapagoid(empty($g['pago']) ?
                null : $dbm->getRepositorioById('CeTallerfrecuenciapago', 'tallerfrecuenciapagoid', $g['pago']));
                $dbm->saveRepositorio($preregistro);
            }            
    

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el archivo word del formato
     * @Rest\Get("/api/Controlescolar/conftallerextracurricular/{id}", name="DescargarReglamento")
     */
    public function DescargarReglamento($id) {
        try {
            $data = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $Formato = $dbm->getRepositorioById('CeTallerextrareglamento', 'tallerextrareglamentoid', $id);
            if($data['portal'] == 2){
            $vista_solicitud = array("dummy" => 1);

            $extension = $Formato->getTipo() == 'application/msword' ? '.doc' : '.docx';

            $temp = tmpfile();
            fwrite($temp, stream_get_contents($Formato->getContenido()));
            $path = stream_get_meta_data($temp)['uri'];

            $parametros = $dbm->getRepositorioById("Parametros", "nombre", "UrlTokens");
            $urltokens = $parametros->getValor();
            //$urltokens="http://192.168.0.13:8015/api/archivotokens";
            $documento = \AppBundle\Dominio\Formato::remplazarToken($vista_solicitud, $path, $urltokens);
            fclose($temp);

            if (empty($documento["formato"])) {
                return new View("Hay un error con el archivo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                $response = new \Symfony\Component\HttpFoundation\Response(
                    $documento["formato"], 200, array(
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline')
                        //'Content-Length' => $documento["tamano"])
                );
                return $response;
            }
        } else {
            $response = new \Symfony\Component\HttpFoundation\Response(
                stream_get_contents($Formato->getContenido()), 200, array(
                'Content-Type' => $Formato->getTipo(),
                'Content-Length' => $Formato->getSize()
                )
            );
        }
        return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/conftallerextracurricular/Archivo" , name="SaveArchivoreglamento")
     */
    public function SaveArchivoreglamento()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $g = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $tallerreglamento = new CeTallerextrareglamento();
            $tallerreglamento->setNombre(empty($g) ? null : $g['nombre']);
            $tallerreglamento->setContenido(empty($g) ?
            null :  base64_decode($g['contenido']['value']));
            $tallerreglamento->setSize(empty($g) ?
            null : $g['contenido']['size']);
            $tallerreglamento->setTipo(empty($g) ?
            null : $g['contenido']['filetype']);

            $dbm->saveRepositorio($tallerreglamento);
            $dbm->getConnection()->commit();
            $reglamentos = $dbm->getRepositorios('CeTallerextrareglamento');
            foreach ($reglamentos as $r) {
                $r->setContenido(null);
            }
            return new View(array("mensaje" => "Se ha guardado el registro", "reglamento" => $reglamentos), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

        /**
     * @Rest\Put("/api/Controlescolar/conftallerextracurricular/Archivo/{id}" , name="putArchivoreglamento")
     */
    public function putArchivoreglamento($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $g = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $tallerreglamento = $dbm->getRepositorioById('CeTallerextrareglamento', 'tallerextrareglamentoid', $id);
            $tallerreglamento->setNombre(empty($g) ? null : $g['nombre']);
            if ($g['contenido'] && $g['contenido'] != "0") {
                $tallerreglamento->setContenido(empty($g) ?
                null :  base64_decode($g['contenido']['value']) );
                $tallerreglamento->setSize(empty($g) ?
                null : $g['contenido']['size']);
                $tallerreglamento->setTipo(empty($g) ?
                null : $g['contenido']['filetype']);
            }
            $dbm->saveRepositorio($tallerreglamento);
            $dbm->getConnection()->commit();
            $reglamentos = $dbm->getRepositorios('CeTallerextrareglamento');
            foreach ($reglamentos as $r) {
                $r->setContenido(null);
            }
            return new View(array("mensaje" => "Se ha actualizado el registro", "reglamento" => $reglamentos), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un archivo
     * @Rest\Delete("/api/Controlescolar/conftallerextracurricular/Archivo/{id}", name="deleteArchivoreglamento")
     */
    public function deleteArchivoreglamento($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $reglamento = $dbm->getRepositorioById('CeTallerextrareglamento', 'tallerextrareglamentoid', $id);
            $dbm->removeRepositorio($reglamento);
            $dbm->getConnection()->commit();
            $reglamentos = $dbm->getRepositorios('CeTallerextrareglamento');

            return new View(array("mensaje" => "Se ha eliminado el registro", "reglamento" => $reglamentos), Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Retorna la informacion del alumno
     * @Rest\Post("/api/Controlescolar/conftallerextracurricular/alumno/", name="ObtenerDatosALumno")
     */
    public function ObtenerDatosALumno() {
        try {

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $datos = json_decode($content, true);
            $conn = $this->get("db_manager")->getConnection();

            $alumnos = [];
            $docmentosporpagar = [];
            $documentosSaldo = [];
            $dpagados = [];

            foreach($datos as $filtro){
                $filtros = $dbm->BuscarAlumnosA(['alumnoid' => $filtro])[0];

                if(empty($filtros)){
                    return new View("No se encontró información relacionada con el alumno", Response::HTTP_PARTIAL_CONTENT);
                }
                if(!$filtros['alumnoporcicloid']){
                    return new View("No se encontró información relacionada con el alumno", Response::HTTP_PARTIAL_CONTENT);
                }
                $alumno = $dbm->obtenerAlumnoTallerExtracurricular([
                    'alumnoid' => $filtros['alumnoid'],
                    'gradoid' => $filtros['gradoid'],
                    'cicloid' => $filtros['cicloid']
                ])[0];
                if(empty($alumno)){
                    return new View("No se encontró información relacionada con el alumno", Response::HTTP_PARTIAL_CONTENT);
                }
                $stmt = $conn->prepare('SELECT foto FROM ce_alumnofotocicloactualvista WHERE alumnoid = :alumnoid');
                $stmt->execute(array('alumnoid' => $filtros['alumnoid']));
                $alumno['foto'] = $stmt->fetch()['foto'];

                
                $configuracion = $dbm->getRepositorios('CeConftalleresextracurriculares');
                $talleres = $dbm->getTalleresExtracurricularesPorGrado($alumno['gradoid'], $alumno['cicloid']);
                $talls = [];
                foreach($talleres as &$taller){
                    $total = $dbm->getRepositoriosById('CeAlumnocicloportallerextra', 'tallerextraid', $taller['tallerextracurricularid']);
                    $existe = $dbm->getOneByParametersRepositorio('CeAlumnocicloportallerextra', [
                        'alumnoporcicloid' => $alumno['alumnoporcicloid'],
                        'tallerextraid' => $taller['tallerextracurricularid']
                    ]); 
										$taller['documentoporpagarestatusid']=0;
                    if(!$existe){
                        if(count($total) < $taller['cupo']){
                            $femenino = 0;
                            $masculino = 0;
                            foreach($total as $t){
                                if($t->getAlumnoporcicloid()->getAlumnoid()->getAlumnoid() !== $filtros['alumnoid']){
                                    if($t->getAlumnoporcicloid()->getAlumnoid()->getSexo() == 'M'){
                                        $masculino++;
                                    }else if($t->getAlumnoporcicloid()->getAlumnoid()->getSexo() == 'F'){
                                        $femenino++;
                                    }
                                }
                            }
                            $pass = false;
                            if($taller['cupomaxfemenino'] == null && $taller['cupomaxmasculino'] == null){
                                $pass = true;
                            }else{
                                if($alumno['sexo'] == 'F'){
                                    if($femenino < $taller['cupomaxfemenino']){
                                        $pass = true;
                                    }
                                }else if($alumno['sexo'] == 'M'){
                                    if($masculino < $taller['cupomaxmasculino']){
                                        $pass = true;
                                    }
                                }
                            }
    
                            if($pass){
                                $horarioportaller = $dbm->getRepositoriosById('CeHorarioportaller','tallerextracurricularid', $taller['tallerextracurricularid']);
                                $existe = $dbm->getOneByParametersRepositorio('CeAlumnocicloportallerextra', [
                                    'alumnoporcicloid' => $alumno['alumnoporcicloid'],
                                    'tallerextraid' => $taller['tallerextracurricularid']
                                ]); 
                                $alumno['importe'] = $taller['costo'];
                                if($existe){
																	$docp=$existe->getDocumentoporpagarid();
                                    $taller['alumnoportaller'] = [
                                        'fechavencimiento' => $existe->getFechavencimiento()->format('d/m/Y H:i'),
                                        'reglamento' => $existe->getReglamento(),
                                        'materialentregado' => $existe->getMaterialentregado(),
                                        'alumnocicloportallerextraid' => $existe->getAlumnocicloportallerextraid(),
                                        'estatusinscripcionid' => $existe->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid(),
                                        'estatusinscripcion' => $existe->getTallerextraestatusinscripcionid()->getNombre(),
                                        'documentoporpagarid' => $docp->getDocumentoporpagarid()
                                    ];
                                    $alumno['importe'] = $taller['costo'];
                                    $taller['saldo'] = ($docp->getSaldo() - $docp->getDescuento());
                                    $taller['costo'] = $docp->getImporte();
																		$taller['documentoporpagarestatusid']=$docp->getPagoestatusid()->getPagoestatusid();
                                    $alumno['documentoporpagarid'] = $docp->getDocumentoporpagarid();
                                    if(!in_array($docp->getDocumentoporpagarid(), $docmentosporpagar)){
                                        $docmentosporpagar[] = $docp->getDocumentoporpagarid();
                                    }
                                    $alumno['saldo'] = ($docp->getSaldo() - $docp->getDescuento());
                                    if(count($documentosSaldo) == 0){
                                        $documentosSaldo[] = [
                                            'dp' => $docp->getDocumentoporpagarid(),
                                            'saldo' => ($docp->getSaldo() - $docp->getDescuento())
                                        ];
                                    }else{
                                        $find = false;
                                        foreach($documentosSaldo as $key => $val){
                                            if($val['dp'] == $docp->getDocumentoporpagarid()){
                                                $find = true;
                                            }
                                        }
                                        if(!$find){
                                            $documentosSaldo[] = [
                                                'dp' => $docp->getDocumentoporpagarid(),
                                                'saldo' => ($docp->getSaldo() - $docp->getDescuento())
                                            ];
                                        }
                                    }
                                    $alumno['concepto'] = $docp->getConcepto();
                                    $alumno['documento'] = ($docp->getDocumento() ? $docp->getDocumento() : '');
                                    if(ENTORNO == 1){
                                        $alumno['tipodocumento'] = $docp->getDocumentoid()->getTipodocumento() > 3 ? 3 : $docp->getDocumentoid()->getTipodocumento();
                                    }else{
                                        $alumno['tipodocumento'] = $docp->getDocumentoid()->getTipodocumento();
                                    }
                                    
                                    $alumno['documentonombre'] = $docp->getDocumentoid()->getNombre();
        
                                    $alumno['referencia'] = ($docp->getReferencia() ? $docp->getReferencia() : '');
                                    if($existe->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 3){
                                        if($docp->getPagoestatusid()->getPagoestatusid() == 2){
                                            $taller['pagado'] =  true;
                                            $dpagados[] = $docp->getDocumentoporpagarid();
                                        }else{
                                            $taller['pagado'] =  false;
                                        }
                                    }else{
                                        $taller['pagado'] =  false;
                                    }
                                }
                                $horario = [
                                    [
                                        'nombre' => 'Lunes',
                                    ],
                                    [
                                        'nombre' => 'Martes',
                                    ],
                                    [
                                        'nombre' => 'Miércoles',
                                    ],
                                    [
                                        'nombre' => 'Jueves',
                                    ],
                                    [
                                        'nombre' => 'Viernes',
                                    ],
                                    [
                                        'nombre' => 'Sábado',
                                    ],
                                    [
                                        'nombre' => 'Domingo',
                                    ]
                                ];
        
                                foreach($horarioportaller as $h){
                                    $horario[(int) $h->getDia() - 1]['dia'] = $h->getDia(); 
                                    $horario[(int) $h->getDia() - 1]['horainicio'] = $h->getHorainicio()->format('H:i A'); 
                                    $horario[(int) $h->getDia() - 1]['horafin'] = $h->getHorafin()->format('H:i A'); 
                                }
                                $taller['horario'] = $horario;
                                $talls[] = $taller;
                            }
                        }
                    }else{
                        $horarioportaller = $dbm->getRepositoriosById('CeHorarioportaller','tallerextracurricularid', $taller['tallerextracurricularid']);
                        $existe = $dbm->getOneByParametersRepositorio('CeAlumnocicloportallerextra', [
                            'alumnoporcicloid' => $alumno['alumnoporcicloid'],
                            'tallerextraid' => $taller['tallerextracurricularid']
                        ]); 
                        $alumno['importe'] = $taller['costo'];
                        if($existe){
														$docp=$existe->getDocumentoporpagarid();
                            $taller['alumnoportaller'] = [
                                'fechavencimiento' => $existe->getFechavencimiento()->format('d/m/Y H:i'),
                                'reglamento' => $existe->getReglamento(),
                                'materialentregado' => $existe->getMaterialentregado(),
                                'alumnocicloportallerextraid' => $existe->getAlumnocicloportallerextraid(),
                                'estatusinscripcionid' => $existe->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid(),
                                'estatusinscripcion' => $existe->getTallerextraestatusinscripcionid()->getNombre(),
                                'documentoporpagarid' => null//($existe->getDocumentoporpagarid() ? $existe->getDocumentoporpagarid()->() : null)
                            ];
                            $alumno['importe'] = $taller['costo'];
                            if($docp){
															$taller['documentoporpagarestatusid']=$docp->getPagoestatusid()->getPagoestatusid();
															$taller['alumnoportaller']['documentoporpagarid']=$docp->getDocumentoporpagarid();
                                $taller['saldo'] = ($docp->getSaldo() - $docp->getDescuento());
                                $taller['costo'] = $docp->getImporte();
                                $alumno['documentoporpagarid'] = $docp->getDocumentoporpagarid();
                                if(!in_array($docp->getDocumentoporpagarid(), $docmentosporpagar)){
                                    $docmentosporpagar[] = $docp->getDocumentoporpagarid();
                                }
                                $alumno['saldo'] = ($docp->getSaldo() - $docp->getDescuento());
                                if(count($documentosSaldo) == 0){
                                    $documentosSaldo[] = [
                                        'dp' => $docp->getDocumentoporpagarid(),
                                        'saldo' => ($docp->getSaldo() - $docp->getDescuento())
                                    ];
                                }else{
                                    $find = false;
                                    foreach($documentosSaldo as $key => $val){
                                        if($val['dp'] == $docp->getDocumentoporpagarid()){
                                            $find = true;
                                        }
                                    }
                                    if(!$find){
                                        $documentosSaldo[] = [
                                            'dp' => $docp->getDocumentoporpagarid(),
                                            'saldo' => ($docp->getSaldo() - $docp->getDescuento())
                                        ];
                                    }
                                }
                                $alumno['concepto'] = $docp->getConcepto();
                                $alumno['documento'] = ($docp->getDocumento() ? $docp->getDocumento() : '');
                                $alumno['tipodocumento'] = $docp->getDocumentoid()->getTipodocumento();
                                $alumno['documentonombre'] = $docp->getDocumentoid()->getNombre();

                                $alumno['referencia'] = ($docp->getReferencia() ? $docp->getReferencia() : '');
                                if($existe->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 3){
                                    if($docp->getPagoestatusid()->getPagoestatusid() == 2){
                                        $taller['pagado'] =  true;
                                        $dpagados[] = $docp->getDocumentoporpagarid();
                                    }else{
                                        $taller['pagado'] =  false;
                                    }
                                }else{
                                    $taller['pagado'] =  false;
                                }
                            }else{
                                $subconcepto = $dbm->getRepositorioById('CjSubconceptoportaller', 'tallerextracurricularid', $taller['tallerextracurricularid']);
                                if($subconcepto){
                                    $pagodetalle = $dbm->getPagodetalle([
                                        'alumnoid' => $alumno['alumnoid'],
                                        'subconceptoid' => $subconcepto->getSubconceptoid()->getSubconceptoid(),
                                        'cicloid' =>  $filtros['cicloid']
                                    ]);
                                    $tot = 0;
                                    foreach($pagodetalle as $pa){
                                        if($pa->getPagoid()->getPagoestatusid()->getPagoestatusid() == 2 || $pa->getPagoid()->getPagoestatusid()->getPagoestatusid() == 0){
                                            $tot = $tot + 1;
                                        }
                                    }
                                    $alumno['totalpagos'] = $tot;
                                    if(count($pagodetalle) > 0){
                                        $taller['pagado'] =  true;
                                    }
                                }else{
                                    $taller['pagado'] =  false;
                                }
                            }
                        }
                        $horario = [
                            [
                                'nombre' => 'Lunes',
                            ],
                            [
                                'nombre' => 'Martes',
                            ],
                            [
                                'nombre' => 'Miércoles',
                            ],
                            [
                                'nombre' => 'Jueves',
                            ],
                            [
                                'nombre' => 'Viernes',
                            ],
                            [
                                'nombre' => 'Sábado',
                            ],
                            [
                                'nombre' => 'Domingo',
                            ]
                        ];

                        foreach($horarioportaller as $h){
                            $horario[(int) $h->getDia() - 1]['dia'] = $h->getDia(); 
                            $horario[(int) $h->getDia() - 1]['horainicio'] = $h->getHorainicio()->format('H:i A'); 
                            $horario[(int) $h->getDia() - 1]['horafin'] = $h->getHorafin()->format('H:i A'); 
                        }
                        $taller['horario'] = $horario;
                        $talls[] = $taller;
                    }
                }
                $opcionregistro = $dbm->getRepositorioById('CeTallerextraopcionregistro','gradoid', $alumno['gradoid']);
                $periodoinscripcion = $dbm->getRepositoriosById('CeTallerextraperiodoinscripcion','nivelid', $alumno['nivelid']);
                $fechaactual = new \DateTime();
                $leyendacaja = $dbm->getRepositorioById('Parametros','parametrosid', 104);
                $leyendapreregistro = $dbm->getRepositorioById('Parametros','parametrosid', 105);


                $saldo = 0;


                foreach($documentosSaldo as $dp){
                    $find = false;
                    foreach($dpagados as $d){
                        if($dp['dp'] == $d){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $saldo += $dp['saldo'];
                    }
                }
                $docmentosporpagarf = [];
                foreach($docmentosporpagar as $dp){
                    $find = false;
                    foreach($dpagados as $d){
                        if($dp == $d){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $docmentosporpagarf[] = $dp;
                    }
                }

                $opcion = [
                    'tipopago' => $opcionregistro->getTipopago(),
                    'notalleres' => $opcionregistro->getNotalleres(),
                    'frecuenciapagoid' => $opcionregistro->getFrecuenciapagoid(),
                    'periodoinscripcion' => $periodoinscripcion
                ];
                $alumnos[] = ['alumno' => $alumno, 'talleresextracurriculares' => $talls, 'opcionregistro' => $opcion,
                'configuracion' => $configuracion[0], 'periodoinscripcion' => $periodoinscripcion, 'fechaactual' => $fechaactual,
                'leyendacaja' => $leyendacaja, 'leyendapreregistro' => $leyendapreregistro, 'documentosporpagar' => implode('/',$docmentosporpagarf), 'importe' => $saldo];
            }
            return new View($alumnos, Response::HTTP_OK);
        } catch (\Exception $e) {
					return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Delete("/api/Controlescolar/conftallerextracurricular/eliminarinscripcion/{alumnocicloportallerextraid}" , name="eliminarInscripcionAlumnoTaller")
     */
    public function eliminarInscripcionAlumnoTaller($alumnocicloportallerextraid)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $datos = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $taller = $dbm->getRepositorioById('CeAlumnocicloportallerextra', 'alumnocicloportallerextraid', $alumnocicloportallerextraid);
            if($taller){
                $opcionregistro = $dbm->getRepositorioById('CeTallerextraopcionregistro', 'gradoid', $taller->getAlumnoporcicloid()->getGradoid()->getGradoid());
                if(!$opcionregistro) {
                    return new View("No se ha configurado el tipo de pago para el grado del alumno seleccionado", Response::HTTP_PARTIAL_CONTENT);
                }
                if($opcionregistro->getTipopago() == 2){
                    if($taller->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 2){
                        if($taller->getDocumentoporpagarid()){
                            if($taller->getDocumentoporpagarid()->getPagoestatusid()->getPagoestatusid() == 2) {
                                return new View("No se puede eliminar la inscripción del taller debido a que ya se encuentra pagado", Response::HTTP_PARTIAL_CONTENT);
                            }
                            $pordocumento = $dbm->getRepositoriosById('CeAlumnocicloportallerextra','documentoporpagarid', $taller->getDocumentoporpagarid()->getDocumentoporpagarid());
                            if(count($pordocumento) == 1){
                                //se elimina el documento por pagar
                                $documentoporpagar = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $taller->getDocumentoporpagarid()->getDocumentoporpagarid());
                                $dbm->removeRepositorio($taller);
                                $dbm->removeRepositorio($documentoporpagar);
                            }else{
                                $dbm->removeRepositorio($taller);
                            }
                        }else{
                            // eliminamos el registro
                            $dbm->removeRepositorio($taller);
                        }
                    }else{
                        return new View("No se puede eliminar la inscripción del taller", Response::HTTP_PARTIAL_CONTENT);
                    }
                }else{
                    $dbm->removeRepositorio($taller);
                    // if($taller->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 2){
                    //     // eliminamos el registro
                    // }else{
                    //     return new View("No se puede eliminar la inscripción del taller", Response::HTTP_PARTIAL_CONTENT);
                    // }
                }
                $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 2);
                if($datos['portal'] == 1){
                    $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 3);
                }else{
                    $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 4);
                }
                $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid',$taller->getAlumnoporcicloid()->getAlumnoporcicloid());
                $bitacora =  new CeTallerbitacora();
                $bitacora->setAlumnoporcicloid($alumnoporciclo);
                $bitacora->setFecha(new \Datetime());
                $bitacora->setTallerid($taller->getTallerextraid()->getTallerextracurricularid());
                $bitacora->setTipotallerid($tipotaller);
                $bitacora->setTalleraccionid($accion);
                $dbm->saveRepositorio($bitacora);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Post("/api/Controlescolar/conftallerextracurricular/GuardarTallerAlumno" , name="guardarInscripcionAlumnoPorTaller")
     */
    public function guardarInscripcionAlumnoPorTaller()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $datos = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid',$datos['alumnoporcicloid']);
            $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid',$alumnoporciclo->getAlumnoid()->getAlumnoid());
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid',$datos['usuarioid']);
            $hijopersonal = $dbm->getRepositorioById('CeAlumnoporpersonal', 'alumnoid', $alumno->getAlumnoid());
            if(!$hijopersonal){
                $nombre = $alumno->getPrimernombre() . ' ' . $alumno->getApellidopaterno() . ' ' . $alumno->getApellidomaterno();
                if ($alumno->getHijopersonal()) {
                    $hijopersonal = true;
                }
            }
            $configuracion = $dbm->getRepositorios('CeConftalleresextracurriculares')[0];

            $talleres = $dbm->getRepositoriosModelo(
                "CeAlumnocicloportallerextra",
                ["d"],
                ["alumnoporcicloid" => $datos['alumnoporcicloid']],
                false,
                false,
                [
                    ["entidad" => "CeTallerextracurricular", "alias" => "t", "on" => "t.tallerextracurricularid = d.tallerextraid and t.activo = 1"]
                ]
            );

            $pagados = [];
            $dias = [];
            $talls = $datos['talleres'];
            foreach($talleres  as $taller){
                $horarioportaller = $dbm->getRepositoriosById('CeHorarioportaller','tallerextracurricularid', $taller->getTallerextraid()->getTallerextracurricularid());
                $ta = [];
                $horario = [
                    [
                        'nombre' => 'Lunes',
                    ],
                    [
                        'nombre' => 'Martes',
                    ],
                    [
                        'nombre' => 'Miércoles',
                    ],
                    [
                        'nombre' => 'Jueves',
                    ],
                    [
                        'nombre' => 'Viernes',
                    ],
                    [
                        'nombre' => 'Sábado',
                    ],
                    [
                        'nombre' => 'Domingo',
                    ]
                ];

                foreach($horarioportaller as $h){
                    $horario[(int) $h->getDia() - 1]['dia'] = $h->getDia(); 
                    $horario[(int) $h->getDia() - 1]['horainicio'] = $h->getHorainicio()->format('H:i A'); 
                    $horario[(int) $h->getDia() - 1]['horafin'] = $h->getHorafin()->format('H:i A'); 
                }
                $ta['horario'] = $horario;
                $ta['tallerextracurricularid'] = $taller->getTallerextraid()->getTallerextracurricularid();
                $find = false;
                foreach($talls as $t){
                    if($t['tallerextracurricularid'] == $ta['tallerextracurricularid']){
                        $find = true;
                    }
                }
                if(!$find){
                    $talls[] = $ta;
                }
            }
            foreach($talls  as $taller){
                foreach($taller['horario'] as $key =>$horario){
                    if($horario['horainicio']){
                        $dias[$key][] = [
                            'horainicio' => $horario['horainicio'],
                            'horafin' => $horario['horafin']
                        ];
                    }
                }
            }
            foreach($dias as $dia){
                foreach($dia as $key => $hora){
                    foreach($dia as $keys => $horas){
                        if($key !== $keys){
                            $current_time = $horas['horainicio'];
                            $current_time2 = $horas['horafin'];
                            $sunrise = $hora['horainicio'];
                            $sunset = $hora['horafin'];
                            $date1 = \DateTime::createFromFormat('H:i a', $current_time);
                            $date2 = \DateTime::createFromFormat('H:i a', $sunrise);
                            $date3 = \DateTime::createFromFormat('H:i a', $sunset);
                            if ($current_time == $sunrise && $current_time2 == $sunset)
                            {
                                return new View("No se puede inscribir a los talleres debido a que los horarios se empalman.", Response::HTTP_PARTIAL_CONTENT);
                            }
                        }
                    }
                }
            }
            
            if(empty($datos['keep'])){
                foreach($talleres as $taller){
                    if($taller->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNivelid() == 3 || $taller->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNivelid() == 4){
                        if($taller->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 2){
                            if($taller->getDocumentoporpagarid()){
                                $pordocumento = $dbm->getRepositoriosById('CeAlumnocicloportallerextra','documentoporpagarid', $taller->getDocumentoporpagarid()->getDocumentoporpagarid());
                                if(count($pordocumento) == 1){
                                    //se elimina el documento por pagar
                                    $documentoporpagar = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $taller->getDocumentoporpagarid()->getDocumentoporpagarid());
                                    if($documentoporpagar->getPagoestatusid()->getPagoestatusid() == 2){
                                        $pagados[] = $documentoporpagar;
                                    }else{
                                        $dbm->removeRepositorio($taller);
                                        $dbm->removeRepositorio($documentoporpagar);
                                    }
                                }else{
                                    $dbm->removeRepositorio($taller);
                                }
                            }else{
                                // eliminamos el registro
                                $dbm->removeRepositorio($taller);
                            }
                        }else{
                            $dbm->removeManyRepositorio('CeAlumnocicloportallerextra', 'alumnoporcicloid', $datos['alumnoporcicloid']);
                        }
                    }else{
                        if($taller->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 2){
                            // eliminamos el registro
                            $dbm->removeRepositorio($taller);
                        }
                    }
                }
            }
            foreach($datos['talleres']  as $taller){
                $total = $dbm->getRepositoriosById('CeAlumnocicloportallerextra', 'tallerextraid', $taller['tallerextracurricularid']);
                $tallerExtra = $dbm->getRepositorioById('CeTallerextracurricular', 'tallerextracurricularid', $taller['tallerextracurricularid']);
                if(count($total) < $tallerExtra->getCupo()){
                    $femenino = 0;
                    $masculino = 0;
                    foreach($total as $t){
                        if($t->getAlumnoporcicloid()->getAlumnoid()->getAlumnoid() !== $alumno->getAlumnoid()){
                            if($t->getAlumnoporcicloid()->getAlumnoid()->getSexo() == 'M'){
                                $masculino++;
                            }else if($t->getAlumnoporcicloid()->getAlumnoid()->getSexo() == 'F'){
                                $femenino++;
                            }
                        }
                    }
                    $pass = false;
                    if($tallerExtra->getCupomaxmasculino() == null && $tallerExtra->getCupomaxmasculino() == null){
                        $pass = true;
                    }else{
                        if($alumno->getSexo() == 'F'){
                            if($femenino < $tallerExtra->getCupomaxfemenino()){
                                $pass = true;
                            }
                        }else if($alumno->getSexo() == 'M'){
                            if($masculino < $tallerExtra->getCupomaxmasculino()){
                                $pass = true;
                            }
                        }
                    }

                    if(!$pass){
                        return new View("El taller " . $tallerExtra->getNombre() . " ya alcanzó su cupo máximo.", Response::HTTP_PARTIAL_CONTENT);
                    }
                }else{
                    return new View("El taller " . $tallerExtra->getNombre() . " ya alcanzó su cupo máximo.", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            $documentos = [];
            $ct = 1;
            foreach($datos['talleres']  as $taller){

                $dt = new \DateTime();
                $dt->modify('+ '. $taller['horasreservacion'] .' day');
                if($dt->format('H') < 23){
                    $dt->setTime(23,59);
                }
                $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $taller['cicloid']);
                $grado = $dbm->getRepositorioById('Grado', 'gradoid', $taller['gradoid']);
                $tallerExtra = $dbm->getRepositorioById('CeTallerextracurricular', 'tallerextracurricularid', $taller['tallerextracurricularid']);
                if($taller['nivelid'] == 3 || $taller['nivelid'] == 4){
                    if($taller['estatusincripcionid'] == 2){
                        if(count($documentos) == 0){
                            $subconcepto = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $taller['subconceptoid']);

                            $subconceptonivel = $dbm->getOneByParametersRepositorio('CjSubconceptopornivel', [
                                'subconceptoid' => $taller['subconceptoid'],
                                'nivelid' => $grado->getNivelid()
                            ]);
                            if($subconceptonivel){
                                $taller['costo'] = $subconceptonivel->getImporte(); 
                            }else{
                                $taller['costo'] = $subconcepto->getImporte();
                            }
                            $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                            $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
                            $pagoestatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 1);
                            
                            if($hijopersonal){
                                $importe = $taller['costo'] - ($taller['costo'] * ($configuracion->getDescuentoempleados() / 100));
                            }else{
                                $importe = $taller['costo'];
                            }
                            $documentoporpagar = new CjDocumentoporpagar();
                            $documentoporpagar->setSubconceptoid($subconcepto);
                            $documentoporpagar->setDocumentoid($documento);
                            $documentoporpagar->setPagoestatusid($pagoestatus);
                            $documentoporpagar->setAlumnoid($alumno);
                            $documentoporpagar->setCicloid($ciclo);
                            $documentoporpagar->setGradoid($grado);
                            $documentoporpagar->setImporte($importe);
                            $documentoporpagar->setSaldo($importe);
                            $documentoporpagar->setFechalimitepago($dt);
                            $documentoporpagar->setFechaprontopago($dt);
                            $documentoporpagar->setFechacreacion(new \DateTime());
                            $documentoporpagar->setConcepto($tallerExtra->getNombre());
                            $dbm->saveRepositorio($documentoporpagar);
                            $documentos[] = $documentoporpagar;
                        }else{
                            $documentoporpagar = null;
                            foreach($documentos as $documento){
                                $opcion = $dbm->getRepositorioById('CeTallerextraopcionregistro', 'gradoid', $taller['gradoid']);
                                $talleresregistro = $dbm->getRepositoriosById('CeAlumnocicloportallerextra', 'documentoporpagarid', $documento->getDocumentoporpagarid());
                                if(count($talleresregistro) < $opcion->getNotalleres()){
                                    $documentoporpagar = $documento;
                                }
                            }
                            if(!$documentoporpagar){
                                $subconcepto = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $taller['subconceptoid']);
                                $subconceptonivel = $dbm->getOneByParametersRepositorio('CjSubconceptopornivel', [
                                    'subconceptoid' => $taller['subconceptoid'],
                                    'nivelid' => $grado->getNivelid()
                                ]);
                                if($subconceptonivel){
                                    $taller['costo'] = $subconceptonivel->getImporte(); 
                                }else{
                                    $taller['costo'] = $subconcepto->getImporte();
                                }
                                $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                                $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
                                $pagoestatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 1);
                                
                                if($hijopersonal){
                                    $importe = $taller['costo'] - ($taller['costo'] * ($configuracion->getDescuentoempleados() / 100));
                                }else{
                                    $importe = $taller['costo'];
                                }
                                $documentoporpagar = new CjDocumentoporpagar();
                                $documentoporpagar->setSubconceptoid($subconcepto);
                                $documentoporpagar->setDocumentoid($documento);
                                $documentoporpagar->setPagoestatusid($pagoestatus);
                                $documentoporpagar->setAlumnoid($alumno);
                                $documentoporpagar->setCicloid($ciclo);
                                $documentoporpagar->setGradoid($grado);
                                $documentoporpagar->setImporte($importe);
                                $documentoporpagar->setSaldo($importe);
                                $documentoporpagar->setFechalimitepago($dt);
                                $documentoporpagar->setFechaprontopago($dt);
                                $documentoporpagar->setFechacreacion(new \DateTime());
                                $documentoporpagar->setConcepto($tallerExtra->getNombre());
                                $dbm->saveRepositorio($documentoporpagar);
                                $documentos[] = $documentoporpagar;
                            }else{
                                $documentoporpagar->setConcepto('Pago de talleres ('. (count($talleresregistro) + 1) .')');
                                $dbm->saveRepositorio($documentoporpagar);
                            }
                        }

                        
                        $tallerestatus = $dbm->getRepositorioById('CeTallerextraestatusinscripcion', 'tallerextraestatusinscripcionid', $taller['estatusincripcionid']);

                        $alumnociclotallerextra = new CeAlumnocicloportallerextra();
                        $alumnociclotallerextra->setAlumnoporcicloid($alumnoporciclo);
                        $alumnociclotallerextra->setTallerextraid($tallerExtra);
                        $alumnociclotallerextra->setTallerextraestatusinscripcionid($tallerestatus);
                        $alumnociclotallerextra->setFechavencimiento($dt);
                        $alumnociclotallerextra->setReglamento(false);
                        $alumnociclotallerextra->setUsuarioid($usuario);
                        $alumnociclotallerextra->setPersonaautorizo($datos['personaautorizo']);
                        $alumnociclotallerextra->setMaterialentregado(false);
                        $alumnociclotallerextra->setDocumentoporpagarid($documentoporpagar);
						$alumnociclotallerextra->setFechapreregistro(new \DateTime());
                        $dbm->saveRepositorio($alumnociclotallerextra);
                    }else{
                        $pagodetalle = $dbm->getPagodetalle([
                            'alumnoid' => $alumno->getAlumnoid(),
                            'subconceptoid' => $taller['subconceptoid'],
                            'cicloid' =>  $taller['cicloid']
                        ]);
                        // $documentoporpagartemp = $dbm->getOneByParametersRepositorio('CjDocumentoporpagar',[
                        //     'cicloid' => $taller['cicloid'],
                        //     'gradoid' => $taller['gradoid'],
                        //     'alumnoid' => $alumno->getAlumnoid(),
                        //     'subconceptoid' => $taller['subconceptoid']
                        // ]);
                        if(count($pagodetalle) > 0){
                            $total = 0;
                            $tot = 0;
                            $opcion = $dbm->getRepositorioById('CeTallerextraopcionregistro', 'gradoid', $taller['gradoid']);
                            foreach($pagodetalle as $pa){
                                if($pa->getPagoid()->getPagoestatusid()->getPagoestatusid() == 2 || $pa->getPagoid()->getPagoestatusid()->getPagoestatusid() == 0){
                                    $tot = $tot + 1;
                                }
                            }
                            $total = ($tot * $opcion->getNotalleres()) - $ct;
                            if($total >= 0){
                                $documentoporpagar = false;
                                $talleresregistro = $dbm->getRepositoriosById('CeAlumnocicloportallerextra', 'alumnoporcicloid', $datos['alumnoporcicloid']);

                                $tallereregistro = $dbm->getOneByParametersRepositorio('CeAlumnocicloportallerextra', ['alumnoporcicloid' => $datos['alumnoporcicloid'], 'tallerextraid' => $taller['tallerextracurricularid']]);                            

                                $cupofull = true;
                                
                                if($total >= 0){
                                    $documentoporpagar = true;
                                }    
                                if($documentoporpagar){
                                    if(!$tallereregistro){
                                        $tallerestatus = $dbm->getRepositorioById('CeTallerextraestatusinscripcion', 'tallerextraestatusinscripcionid', $taller['estatusincripcionid']);
            
                                        $alumnociclotallerextra = new CeAlumnocicloportallerextra();
                                        $alumnociclotallerextra->setAlumnoporcicloid($alumnoporciclo);
                                        $alumnociclotallerextra->setTallerextraid($tallerExtra);
                                        $alumnociclotallerextra->setTallerextraestatusinscripcionid($tallerestatus);
                                        $alumnociclotallerextra->setFechavencimiento($dt);
                                        $alumnociclotallerextra->setReglamento(false);
                                        $alumnociclotallerextra->setUsuarioid($usuario);
                                        $alumnociclotallerextra->setPersonaautorizo($datos['personaautorizo']);
                                        $alumnociclotallerextra->setMaterialentregado(false);
                                        $alumnociclotallerextra->setFechapreregistro(new \DateTime());
                                        $dbm->saveRepositorio($alumnociclotallerextra);
                                    }
                                }else{
                                    return new View("Solo te puedes inscribir a ". $opcion->getNotalleres() ." taller(es) .", Response::HTTP_PARTIAL_CONTENT);
                                }
                                $ct++;
                            }else{
                                return new View("No se ha realizado el pago, favor de realizarlo en caja.", Response::HTTP_PARTIAL_CONTENT);
                            }
                        }else{
                            return new View("No se ha realizado el pago, favor de realizarlo en caja.", Response::HTTP_PARTIAL_CONTENT);
                        }
                    }
                }else{
                    if($taller['estatusincripcionid'] == 3){
                        $pagodetalle = $dbm->getPagodetalle([
                            'alumnoid' => $alumno->getAlumnoid(),
                            'subconceptoid' => $taller['subconceptoid'],
                            'cicloid' =>  $taller['cicloid']
                        ]);
                        // $documentoporpagartemp = $dbm->getOneByParametersRepositorio('CjDocumentoporpagar',[
                        //     'cicloid' => $taller['cicloid'],
                        //     'gradoid' => $taller['gradoid'],
                        //     'alumnoid' => $alumno->getAlumnoid(),
                        //     'subconceptoid' => $taller['subconceptoid']
                        // ]);
                        if(count($pagodetalle) > 0){
                            $total = 0;
                            $tot = 0;
                            $opcion = $dbm->getRepositorioById('CeTallerextraopcionregistro', 'gradoid', $taller['gradoid']);
                            foreach($pagodetalle as $pa){
                                if($pa->getPagoid()->getPagoestatusid()->getPagoestatusid() == 2 || $pa->getPagoid()->getPagoestatusid()->getPagoestatusid() == 0){
                                    $tot = $tot + 1;
                                }
                            }
                            $total = ($tot * $opcion->getNotalleres()) - $ct;
                            if($total >= 0){
                                $documentoporpagar = false;
                                $talleresregistro = $dbm->getRepositoriosById('CeAlumnocicloportallerextra', 'alumnoporcicloid', $datos['alumnoporcicloid']);

                                $tallereregistro = $dbm->getOneByParametersRepositorio('CeAlumnocicloportallerextra', ['alumnoporcicloid' => $datos['alumnoporcicloid'], 'tallerextraid' => $taller['tallerextracurricularid']]);                            

                                $cupofull = true;
                                $total = (count($pagodetalle) * $opcion->getNotalleres()) - $ct;
                                if($total >= 0){
                                    $documentoporpagar = true;
                                }    
                                if($documentoporpagar){
                                    if(!$tallereregistro){
                                        $tallerestatus = $dbm->getRepositorioById('CeTallerextraestatusinscripcion', 'tallerextraestatusinscripcionid', $taller['estatusincripcionid']);
            
                                        $alumnociclotallerextra = new CeAlumnocicloportallerextra();
                                        $alumnociclotallerextra->setAlumnoporcicloid($alumnoporciclo);
                                        $alumnociclotallerextra->setTallerextraid($tallerExtra);
                                        $alumnociclotallerextra->setTallerextraestatusinscripcionid($tallerestatus);
                                        $alumnociclotallerextra->setFechavencimiento($dt);
                                        $alumnociclotallerextra->setReglamento(false);
                                        $alumnociclotallerextra->setUsuarioid($usuario);
                                        $alumnociclotallerextra->setPersonaautorizo($datos['personaautorizo']);
                                        $alumnociclotallerextra->setMaterialentregado(false);
                                        $alumnociclotallerextra->setFechapreregistro(new \DateTime());
                                        $dbm->saveRepositorio($alumnociclotallerextra);
                                    }
                                }else{
                                    return new View("Solo te puedes inscribir a ". $opcion->getNotalleres() ." taller(es) .", Response::HTTP_PARTIAL_CONTENT);
                                }
                                $ct++;
                            }else{
                                return new View("No se ha realizado el pago, favor de realizarlo en caja.", Response::HTTP_PARTIAL_CONTENT);
                            }
                        }else{
                            return new View("No se ha realizado el pago, favor de realizarlo en caja.", Response::HTTP_PARTIAL_CONTENT);
                        }
                    }else{
                        if(count($documentos) == 0){
                            $subconcepto = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $taller['subconceptoid']);
                            $subconceptonivel = $dbm->getOneByParametersRepositorio('CjSubconceptopornivel', [
                                'subconceptoid' => $taller['subconceptoid'],
                                'nivelid' => $grado->getNivelid()
                            ]);
                            if($subconceptonivel){
                                $taller['costo'] = $subconceptonivel->getImporte(); 
                            }else{
                                $taller['costo'] = $subconcepto->getImporte();
                            }
                            $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                            $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
                            $pagoestatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 1);
                            
                            if($hijopersonal){
                                $importe = $taller['costo'] - ($taller['costo'] * ($configuracion->getDescuentoempleados() / 100));
                            }else{
                                $importe = $taller['costo'];
                            }
                            $documentoporpagar = new CjDocumentoporpagar();
                            $documentoporpagar->setSubconceptoid($subconcepto);
                            $documentoporpagar->setDocumentoid($documento);
                            $documentoporpagar->setPagoestatusid($pagoestatus);
                            $documentoporpagar->setAlumnoid($alumno);
                            $documentoporpagar->setCicloid($ciclo);
                            $documentoporpagar->setGradoid($grado);
                            $documentoporpagar->setImporte($importe);
                            $documentoporpagar->setSaldo($importe);
                            $documentoporpagar->setFechalimitepago($dt);
                            $documentoporpagar->setFechaprontopago($dt);
                            $documentoporpagar->setFechacreacion(new \DateTime());
                            $documentoporpagar->setConcepto($tallerExtra->getNombre());
                            $dbm->saveRepositorio($documentoporpagar);
                            $documentos[] = $documentoporpagar;
                        }else{
                            $documentoporpagar = null;
                            foreach($documentos as $documento){
                                $opcion = $dbm->getRepositorioById('CeTallerextraopcionregistro', 'gradoid', $taller['gradoid']);
                                $talleresregistro = $dbm->getRepositoriosById('CeAlumnocicloportallerextra', 'documentoporpagarid', $documento->getDocumentoporpagarid());
                                if(count($talleresregistro) < $opcion->getNotalleres()){
                                    $documentoporpagar = $documento;
                                }
                            }
                            if(!$documentoporpagar){
                                $subconcepto = $dbm->getRepositorioById('CjSubconcepto', 'subconceptoid', $taller['subconceptoid']);
                                $subconceptonivel = $dbm->getOneByParametersRepositorio('CjSubconceptopornivel', [
                                    'subconceptoid' => $taller['subconceptoid'],
                                    'nivelid' => $grado->getNivelid()
                                ]);
                                if($subconceptonivel){
                                    $taller['costo'] = $subconceptonivel->getImporte(); 
                                }else{
                                    $taller['costo'] = $subconcepto->getImporte();
                                }
                                $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                                $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
                                $pagoestatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 1);
                                
                                if($hijopersonal){
                                    $importe = $taller['costo'] - ($taller['costo'] * ($configuracion->getDescuentoempleados() / 100));
                                }else{
                                    $importe = $taller['costo'];
                                }
                                $documentoporpagar = new CjDocumentoporpagar();
                                $documentoporpagar->setSubconceptoid($subconcepto);
                                $documentoporpagar->setDocumentoid($documento);
                                $documentoporpagar->setPagoestatusid($pagoestatus);
                                $documentoporpagar->setAlumnoid($alumno);
                                $documentoporpagar->setCicloid($ciclo);
                                $documentoporpagar->setGradoid($grado);
                                $documentoporpagar->setImporte($importe);
                                $documentoporpagar->setSaldo($importe);
                                $documentoporpagar->setFechalimitepago($dt);
                                $documentoporpagar->setFechaprontopago($dt);
                                $documentoporpagar->setFechacreacion(new \DateTime());
                                $documentoporpagar->setConcepto($tallerExtra->getNombre());
                                $dbm->saveRepositorio($documentoporpagar);
                                $documentos[] = $documentoporpagar;
                            }else{
                                $documentoporpagar->setConcepto('Pago de talleres ('. (count($talleresregistro) + 1) .')');
                                $dbm->saveRepositorio($documentoporpagar);
                            }
                        }
                        $tallerestatus = $dbm->getRepositorioById('CeTallerextraestatusinscripcion', 'tallerextraestatusinscripcionid', $taller['estatusincripcionid']);

                        $alumnociclotallerextra = new CeAlumnocicloportallerextra();
                        $alumnociclotallerextra->setAlumnoporcicloid($alumnoporciclo);
                        $alumnociclotallerextra->setTallerextraid($tallerExtra);
                        $alumnociclotallerextra->setTallerextraestatusinscripcionid($tallerestatus);
                        $alumnociclotallerextra->setFechavencimiento($dt);
                        $alumnociclotallerextra->setReglamento(false);
                        $alumnociclotallerextra->setUsuarioid($usuario);
                        $alumnociclotallerextra->setPersonaautorizo($datos['personaautorizo']);
                        $alumnociclotallerextra->setMaterialentregado(false);
                        $alumnociclotallerextra->setDocumentoporpagarid($documentoporpagar);
						$alumnociclotallerextra->setFechapreregistro(new \DateTime());
                        $dbm->saveRepositorio($alumnociclotallerextra);
                    }
                }
                $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 2);
                if($datos['portal'] == 1){
                    $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 1);
                }else if($datos['portal'] == 3){
                    $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 9);
                }else{
                    $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 2);
                }
                $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $taller['usuarioid']);
                $bitacora =  new CeTallerbitacora();
                $bitacora->setAlumnoporcicloid($alumnoporciclo);
                $bitacora->setFecha(new \Datetime());
                $bitacora->setTallerid($taller['tallerextracurricularid']);
                $bitacora->setTipotallerid($tipotaller);
                $bitacora->setTalleraccionid($accion);
                $bitacora->setUsuarioid($usuario);
                $dbm->saveRepositorio($bitacora);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna el grado y ciclo del alumno
     * @Rest\Get("/api/Controlescolar/tallerextracurricular/alumno/{id}", name="TallerCicloGradoAlumno")
     */
    public function TallerCicloGradoAlumno($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $conn = $this->get("db_manager")->getConnection();
            $alumno = $dbm->BuscarCicloGradoAlumno($id);

            return new View($alumno, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
