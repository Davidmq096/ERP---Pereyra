<?php

namespace AppBundle\Controller\Controlescolar;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Rest\Api;
use AppBundle\DB\DatabaseManager;
use AppBundle\DB\DbmTalleresExtracurriculares;
use AppBundle\Entity\CeTallerextracurricular;
use AppBundle\Entity\CeGradoportallerextracurricular;
use AppBundle\Entity\CeMaterialportallerextracurricular;
use AppBundle\Entity\CeHorarioportaller;
use AppBundle\Entity\CjDocumentoporpagar;
use AppBundle\Entity\CeAlumnocicloportallerextra;
use AppBundle\Entity\CeTallermaterial;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;

/**
 * @author Mariano
 */
class TallerExtracurricularController extends FOSRestController{

    /**
     * Retorna arreglo de datos iniciales de talleres extracuriculares
     * @Rest\Get("/api/Controlescolar/TallerExtracurricular", name="indexTallerExtracurricular")
     */
    public function indexTallerExtracurricular()
    {
        try {
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grados = $dbm->getRepositoriosById('Grado', 'activo', 1);
            
            foreach ($grados as $g){
                if ($g->getSemestreid()){
                    $arreglo=["gradonivel"=>$g->getGrado()." ".$g->getNivelid()->getNombre(),"grado"=>$g->getGrado(),"gradoid"=>$g->getGradoid(),"nivelid"=>["nivelid"=>$g->getNivelid()->getNivelid(),"nombre"=>$g->getNivelid()->getNombre()],"semestreid"=>["semestreid"=>$g->getSemestreid()->getSemestreid(),"nombre"=>$g->getSemestreid()->getNombre()]];
                }else{
                    $arreglo=["gradonivel"=>$g->getGrado()." ".$g->getNivelid()->getNombre(),"grado"=>$g->getGrado(),"gradoid"=>$g->getGradoid(),"nivelid"=>["nivelid"=>$g->getNivelid()->getNivelid(),"nombre"=>$g->getNivelid()->getNombre()]];
                }
                $grado[]= $arreglo;
            }
            
            $semestre = $dbm->getRepositoriosById('CeSemestre','activo',1);
            $lugar = $dbm->getRepositoriosById('Lugar','activo',1);
            $profesor=$dbm->getRepositoriosModelo('CeProfesor', "d.profesorid,CONCAT_WS(' ',d.apellidopaterno,d.apellidomaterno,d.nombre) as nombre", ['estatusempleadoid'=>1],["apellidopaterno"=>"asc","apellidomaterno"=>"asc","nombre"=>"asc"]);
            $tipoinscripcion=[["id"=>1,"nombre"=>"Reingreso"],["id"=>2,"nombre"=>"Nuevo ingreso"],["id"=>3,"nombre"=>"Todos"]];
            $reglamento=$dbm->getRepositorios('CeTallerextrareglamento');
            $material = $dbm->getRepositoriosById('CeTallermaterial','activo',1);
            return new View(["ciclo"=>$ciclo,"nivel"=>$nivel,"grado"=>$grado,"semestre"=>$semestre,"lugar"=>$lugar,"profesor"=>$profesor,"tipoinscripcion"=>$tipoinscripcion,"reglamento"=>$reglamento,"material"=>$material], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de talleres extracuriculares
     * @Rest\Post("/api/Controlescolar/TallerExtracurricular/Filtrar", name="getTallerExtracurricular")
     */
    public function getTallerExtracurricular()
    {
        try {
            $content = trim(file_get_contents("php://input")); 
            $filtros = json_decode($content, true); 
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $colores = [
                [ "value"=> "1", "datacolor"=> "#800000", "nombre"=> "Granate" ],
                [ "value"=> "2", "datacolor"=> "#B22222", "nombre"=> "Ladrillo" ],
                [ "value"=> "3", "datacolor"=> "#FF0000", "nombre"=> "Rojo" ],
                [ "value"=> "4", "datacolor"=> "#FF6347", "nombre"=> "Tomate" ],
                [ "value"=> "5", "datacolor"=> "#FF4500", "nombre"=> "Rojo Naranja" ],
                
                [ "value"=> "6", "datacolor"=> "#D2691E", "nombre"=> "Chocolate" ],
                [ "value"=> "7", "datacolor"=> "#FF8C00", "nombre"=> "Naraja Oscuro" ],
                [ "value"=> "8", "datacolor"=> "#FFA500", "nombre"=> "Naraja" ],
                [ "value"=> "9", "datacolor"=> "#DAA520", "nombre"=> "Dorado" ],
                [ "value"=> "10", "datacolor"=> "#FFFF00", "nombre"=> "Amarillo" ],

                [ "value"=> "11", "datacolor"=> "#ADFF2F", "nombre"=> "Verde Amarillo" ],
                [ "value"=> "12", "datacolor"=> "#7CFC00", "nombre"=> "Pasto" ],
                [ "value"=> "13", "datacolor"=> "#008000", "nombre"=> "Verde" ],
                [ "value"=> "14", "datacolor"=> "#32CD32", "nombre"=> "Limón" ],
                [ "value"=> "15", "datacolor"=> "#00FF7F", "nombre"=> "Primavera" ],

                [ "value"=> "16", "datacolor"=> "#40E0D0", "nombre"=> "Turquesa" ],
                [ "value"=> "17", "datacolor"=> "#00FFFF", "nombre"=> "Agua" ],
                [ "value"=> "18", "datacolor"=> "#00BFFF", "nombre"=> "Azul Cielo" ],
                [ "value"=> "19", "datacolor"=> "#000080", "nombre"=> "Azul" ],
                [ "value"=> "20", "datacolor"=> "#00008B", "nombre"=> "Azul Marino" ],

                [ "value"=> "21", "datacolor"=> "#8A2BE2", "nombre"=> "Violeta" ],
                [ "value"=> "22", "datacolor"=> "#800080", "nombre"=> "Púrpura" ],
                [ "value"=> "23", "datacolor"=> "#FF00FF", "nombre"=> "Magenta" ],
                [ "value"=> "24", "datacolor"=> "#FF1493", "nombre"=> "Rosa" ],
                [ "value"=> "25", "datacolor"=> "#A0522D", "nombre"=> "Café" ],

                [ "value"=> "26", "datacolor"=> "#000000", "nombre"=> "Negro" ],
                [ "value"=> "27", "datacolor"=> "#808080", "nombre"=> "Gris" ],
                [ "value"=> "28", "datacolor"=> "#C0C0C0", "nombre"=> "Plata" ],
                [ "value"=> "29", "datacolor"=> "#F5F5F5", "nombre"=> "Perla" ],
                [ "value"=> "30", "datacolor"=> "#FFFFFF", "nombre"=> "Blanco" ]
            
            ];
 
            $talleres = $dbm->BuscarTalleresExtracurriculares($filtros);
            foreach ($talleres as &$taller){
                $taller["disponible"]=$dbm->LugaresDisponibles($taller["tallerextracurricularid"]);
                $taller["color"]=array_search($taller["color"],array_column($colores,"datacolor"))===false ? null : $colores[array_search($taller["color"],array_column($colores,"datacolor"))];
                $horario=$dbm->getRepositoriosById("CeHorarioportaller","tallerextracurricularid",$taller["tallerextracurricularid"]);
                if ($horario){
                    foreach ($horario as $dia){
                        if ($dia->getDia()==1){
                            $taller["horarioportaller"]["linicio"]=$dia->getHorainicio()->format("H:i:s");
                            $taller["horarioportaller"]["lfin"]=$dia->getHorafin()->format("H:i:s");
                        }
                        if ($dia->getDia()==2){
                            $taller["horarioportaller"]["mainicio"]=$dia->getHorainicio()->format("H:i:s");
                            $taller["horarioportaller"]["mafin"]=$dia->getHorafin()->format("H:i:s");
                        }
                        if ($dia->getDia()==3){
                            $taller["horarioportaller"]["miinicio"]=$dia->getHorainicio()->format("H:i:s");
                            $taller["horarioportaller"]["mifin"]=$dia->getHorafin()->format("H:i:s");
                        }
                        if ($dia->getDia()==4){
                            $taller["horarioportaller"]["jinicio"]=$dia->getHorainicio()->format("H:i:s");
                            $taller["horarioportaller"]["jfin"]=$dia->getHorafin()->format("H:i:s");
                        }
                        if ($dia->getDia()==5){
                            $taller["horarioportaller"]["vinicio"]=$dia->getHorainicio()->format("H:i:s");
                            $taller["horarioportaller"]["vfin"]=$dia->getHorafin()->format("H:i:s");
                        }
                        if ($dia->getDia()==6){
                            $taller["horarioportaller"]["sinicio"]=$dia->getHorainicio()->format("H:i:s");
                            $taller["horarioportaller"]["sfin"]=$dia->getHorafin()->format("H:i:s");
                        }
                        if ($dia->getDia()==7){
                            $taller["horarioportaller"]["dinicio"]=$dia->getHorainicio()->format("H:i:s");
                            $taller["horarioportaller"]["dfin"]=$dia->getHorafin()->format("H:i:s");
                        }
                    }
                }
            }
            return new View($talleres, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un taller extracuricular
     * @Rest\Post("/api/Controlescolar/TallerExtracurricular", name="saveTallerExtracurricular")
     */
    public function saveTallerExtracurricular()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $data['formato'] = $data['formato'] ? json_encode($data['formato']) : null;
            $taller = $hydrator->hydrate(new CeTallerextracurricular(), $data);
            !$data['profesorid'] ? $taller->setProfesorId(null) : null;
            $dbm->saveRepositorio($taller);
            foreach ($data["gradoid"] as $gradoid){
                $gtec=new CeGradoportallerextracurricular();
                $gtec->setGradoid($dbm->getRepositorioById("Grado","gradoid",$gradoid));
                $gtec->setTallerextracurricularid($taller);
                $dbm->saveRepositorio($gtec);
            }
            foreach ($data["tallermaterialid"] as $tallermaterialid){
                $mte=new CeMaterialportallerextracurricular();
                $mte->setTallermaterialid($dbm->getRepositorioById("CeTallermaterial","tallermaterialid",$tallermaterialid));
                $mte->setTallerextracurricularid($taller);
                $dbm->saveRepositorio($mte);
            }

            if ($data["horarioportaller"]["linicio"] || $data["horarioportaller"]["lfin"]){
                if ($data["horarioportaller"]["linicio"] && $data["horarioportaller"]["lfin"]){
                    $dias[]=["dia"=>1,
                    "horainicio"=>$data["horarioportaller"]["linicio"] ? $data["horarioportaller"]["linicio"].":00" : null,
                    "horafin"=>$data["horarioportaller"]["lfin"] ? $data["horarioportaller"]["lfin"].":00" : null
                    ];
                }else{
                    return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            if ($data["horarioportaller"]["mainicio"] || $data["horarioportaller"]["mafin"]){
                if ($data["horarioportaller"]["mainicio"] && $data["horarioportaller"]["mafin"]){
                    $dias[]=["dia"=>2,
                    "horainicio"=>$data["horarioportaller"]["mainicio"] ? $data["horarioportaller"]["mainicio"].":00" : null,
                    "horafin"=>$data["horarioportaller"]["mafin"] ? $data["horarioportaller"]["mafin"].":00" : null
                    ];
                }else{
                    return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            if ($data["horarioportaller"]["miinicio"] || $data["horarioportaller"]["mifin"]){
                if ($data["horarioportaller"]["miinicio"] && $data["horarioportaller"]["mifin"]){
                    $dias[]=["dia"=>3,
                    "horainicio"=>$data["horarioportaller"]["miinicio"] ? $data["horarioportaller"]["miinicio"].":00" : null,
                    "horafin"=>$data["horarioportaller"]["mifin"] ? $data["horarioportaller"]["mifin"].":00" : null
                    ];
                }else{
                    return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
                }
            }   
            if ($data["horarioportaller"]["jinicio"] || $data["horarioportaller"]["jfin"]){
                if ($data["horarioportaller"]["jinicio"] && $data["horarioportaller"]["jfin"]){
                    $dias[]=["dia"=>4,
                    "horainicio"=>$data["horarioportaller"]["jinicio"] ? $data["horarioportaller"]["jinicio"].":00" : null,
                    "horafin"=>$data["horarioportaller"]["jfin"] ? $data["horarioportaller"]["jfin"].":00" : null
                    ];
                }else{
                    return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
                }
            } 
            if ($data["horarioportaller"]["vinicio"] || $data["horarioportaller"]["vfin"]){
                if ($data["horarioportaller"]["vinicio"] && $data["horarioportaller"]["vfin"]){
                    $dias[]=["dia"=>5,
                    "horainicio"=>$data["horarioportaller"]["vinicio"] ? $data["horarioportaller"]["vinicio"].":00" : null,
                    "horafin"=>$data["horarioportaller"]["vfin"] ? $data["horarioportaller"]["vfin"].":00" : null
                    ];
                }else{
                    return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            if ($data["horarioportaller"]["sinicio"] || $data["horarioportaller"]["sfin"]){
                if ($data["horarioportaller"]["sinicio"] && $data["horarioportaller"]["sfin"]){
                    $dias[]=["dia"=>6,
                    "horainicio"=>$data["horarioportaller"]["sinicio"] ? $data["horarioportaller"]["sinicio"].":00" : null,
                    "horafin"=>$data["horarioportaller"]["sfin"] ? $data["horarioportaller"]["sfin"].":00" : null
                    ];
                }else{
                    return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            if ($data["horarioportaller"]["dinicio"] || $data["horarioportaller"]["dfin"]){
                if ($data["horarioportaller"]["dinicio"] && $data["horarioportaller"]["dfin"]){
                    $dias[]=["dia"=>7,
                    "horainicio"=>$data["horarioportaller"]["dinicio"] ? $data["horarioportaller"]["dinicio"].":00" : null,
                    "horafin"=>$data["horarioportaller"]["dfin"] ? $data["horarioportaller"]["dfin"].":00" : null
                    ];
                }else{
                    return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            
            foreach ($dias as $horario){
                $ht = $hydrator->hydrate(new CeHorarioportaller(), $horario);
                $ht->setTallerextracurricularid($taller);
                $dbm->saveRepositorio($ht);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Edita un taller extracuricular
     * @Rest\Put("/api/Controlescolar/TallerExtracurricular/{tallerextracurricularid}", name="updateTallerExtracurricular")
     */
    public function updateTallerExtracurricular($tallerextracurricularid)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
						$alumnosbytaller=$this->getAlumnosByTallerExtra($tallerextracurricularid);
						$isEditable=!($alumnosbytaller && sizeof($alumnosbytaller)>0);
						if(!$isEditable){
							$data=[
									"cupo"=>$data["cupo"],
									"cupomaxmasculino"=>$data["cupomaxmasculino"],
									"cupomaxfemenino"=>$data["cupomaxfemenino"],
                                    "profesorid"=>$data["profesorid"],
                                    "formato"=>$data["formato"]
							];
						}
            $dbm->getConnection()->beginTransaction();
            $hydrator=new ArrayHydrator($dbm->getEntityManager());
            $data['formato'] = isset($data['formato']) && $data['formato'] !== "" ? json_encode($data['formato']) : null;
            $taller=$hydrator->hydrate($dbm->getRepositorioById("CeTallerextracurricular","tallerextracurricularid",$tallerextracurricularid), $data);
				if(!$data['profesorid']){ $taller->setProfesorId(null); }
				$dbm->saveRepositorio($taller);
						if($isEditable){
							$dbm->removeManyRepositorio("CeGradoportallerextracurricular","tallerextracurricularid",$tallerextracurricularid);
							foreach ($data["gradoid"] as $gradoid){
									$gtec=new CeGradoportallerextracurricular();
									$gtec->setGradoid($dbm->getRepositorioById("Grado","gradoid",$gradoid));
									$gtec->setTallerextracurricularid($taller);
									$dbm->saveRepositorio($gtec);
							}
							$dbm->removeManyRepositorio("CeMaterialportallerextracurricular","tallerextracurricularid",$tallerextracurricularid);
							foreach ($data["tallermaterialid"] as $tallermaterialid){
									$mte=new CeMaterialportallerextracurricular();
									$mte->setTallermaterialid($dbm->getRepositorioById("CeTallermaterial","tallermaterialid",$tallermaterialid));
									$mte->setTallerextracurricularid($taller);
									$dbm->saveRepositorio($mte);
							}

							if ($data["horarioportaller"]["linicio"] || $data["horarioportaller"]["lfin"]){
									if ($data["horarioportaller"]["linicio"] && $data["horarioportaller"]["lfin"]){
											if (strlen($data["horarioportaller"]["linicio"])==5){$cerosi=":00";}else{$cerosi="";}
											if (strlen($data["horarioportaller"]["lfin"])==5){$cerosf=":00";}else{$cerosf="";}
											$dias[]=["dia"=>1,
											"horainicio"=>$data["horarioportaller"]["linicio"] ? $data["horarioportaller"]["linicio"].$cerosi : null,
											"horafin"=>$data["horarioportaller"]["lfin"] ? $data["horarioportaller"]["lfin"].$cerosf : null
											];
									}else{
											return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
									}
							}
							if ($data["horarioportaller"]["mainicio"] || $data["horarioportaller"]["mafin"]){
									if ($data["horarioportaller"]["mainicio"] && $data["horarioportaller"]["mafin"]){
											if (strlen($data["horarioportaller"]["mainicio"])==5){$cerosi=":00";}else{$cerosi="";}
											if (strlen($data["horarioportaller"]["mafin"])==5){$cerosf=":00";}else{$cerosf="";}
											$dias[]=["dia"=>2,
											"horainicio"=>$data["horarioportaller"]["mainicio"] ? $data["horarioportaller"]["mainicio"].$cerosi : null,
											"horafin"=>$data["horarioportaller"]["mafin"] ? $data["horarioportaller"]["mafin"].$cerosf : null
											];
									}else{
											return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
									}
							}
							if ($data["horarioportaller"]["miinicio"] || $data["horarioportaller"]["mifin"]){
									if ($data["horarioportaller"]["miinicio"] && $data["horarioportaller"]["mifin"]){
											if (strlen($data["horarioportaller"]["miinicio"])==5){$cerosi=":00";}else{$cerosi="";}
											if (strlen($data["horarioportaller"]["mifin"])==5){$cerosf=":00";}else{$cerosf="";}
											$dias[]=["dia"=>3,
											"horainicio"=>$data["horarioportaller"]["miinicio"] ? $data["horarioportaller"]["miinicio"].$cerosi : null,
											"horafin"=>$data["horarioportaller"]["mifin"] ? $data["horarioportaller"]["mifin"].$cerosf : null
											];
									}else{
											return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
									}
							}   
							if ($data["horarioportaller"]["jinicio"] || $data["horarioportaller"]["jfin"]){
									if ($data["horarioportaller"]["jinicio"] && $data["horarioportaller"]["jfin"]){
											if (strlen($data["horarioportaller"]["jinicio"])==5){$cerosi=":00";}else{$cerosi="";}
											if (strlen($data["horarioportaller"]["jfin"])==5){$cerosf=":00";}else{$cerosf="";}
											$dias[]=["dia"=>4,
											"horainicio"=>$data["horarioportaller"]["jinicio"] ? $data["horarioportaller"]["jinicio"].$cerosi : null,
											"horafin"=>$data["horarioportaller"]["jfin"] ? $data["horarioportaller"]["jfin"].$cerosf : null
											];
									}else{
											return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
									}
							} 
							if ($data["horarioportaller"]["vinicio"] || $data["horarioportaller"]["vfin"]){
									if ($data["horarioportaller"]["vinicio"] && $data["horarioportaller"]["vfin"]){
											if (strlen($data["horarioportaller"]["vinicio"])==5){$cerosi=":00";}else{$cerosi="";}
											if (strlen($data["horarioportaller"]["vfin"])==5){$cerosf=":00";}else{$cerosf="";}
											$dias[]=["dia"=>5,
											"horainicio"=>$data["horarioportaller"]["vinicio"] ? $data["horarioportaller"]["vinicio"].$cerosi : null,
											"horafin"=>$data["horarioportaller"]["vfin"] ? $data["horarioportaller"]["vfin"].$cerosf : null
											];
									}else{
											return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
									}
							}
							if ($data["horarioportaller"]["sinicio"] || $data["horarioportaller"]["sfin"]){
									if ($data["horarioportaller"]["sinicio"] && $data["horarioportaller"]["sfin"]){
											if (strlen($data["horarioportaller"]["sinicio"])==5){$cerosi=":00";}else{$cerosi="";}
											if (strlen($data["horarioportaller"]["sfin"])==5){$cerosf=":00";}else{$cerosf="";}
											$dias[]=["dia"=>6,
											"horainicio"=>$data["horarioportaller"]["sinicio"] ? $data["horarioportaller"]["sinicio"].$cerosi : null,
											"horafin"=>$data["horarioportaller"]["sfin"] ? $data["horarioportaller"]["sfin"].$cerosf : null
											];
									}else{
											return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
									}
							}
							if ($data["horarioportaller"]["dinicio"] || $data["horarioportaller"]["dfin"]){
									if ($data["horarioportaller"]["dinicio"] && $data["horarioportaller"]["dfin"]){
											if (strlen($data["horarioportaller"]["dinicio"])==5){$cerosi=":00";}else{$cerosi="";}
											if (strlen($data["horarioportaller"]["dfin"])==5){$cerosf=":00";}else{$cerosf="";}
											$dias[]=["dia"=>7,
											"horainicio"=>$data["horarioportaller"]["dinicio"] ? $data["horarioportaller"]["dinicio"].$cerosi : null,
											"horafin"=>$data["horarioportaller"]["dfin"] ? $data["horarioportaller"]["dfin"].$cerosf : null
											];
									}else{
											return new View("No se capturo el horario completo.", Response::HTTP_PARTIAL_CONTENT);
									}
							}
							$dbm->removeManyRepositorio("CeHorarioportaller","tallerextracurricularid",$tallerextracurricularid);
							foreach ($dias as $horario){
									$ht = $hydrator->hydrate(new CeHorarioportaller(), $horario);
									$ht->setTallerextracurricularid($taller);
									$dbm->saveRepositorio($ht);
							}
						}
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        }catch(\Exception $e) {
					return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
		private function getAlumnosByTallerExtra($tallerextraid){
			$dbm=new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
			return $dbm->getRepositoriosModelo("CeAlumnocicloportallerextra",["IDENTITY(d.alumnoporcicloid) AS alumnoporcicloid"],["tallerextraid"=>$tallerextraid]);
		}
		
		

    /**
     * Elimina un taller extracuricular
     * @Rest\Delete("/api/Controlescolar/TallerExtracurricular/{tallerextracurricularid}", name="deleteTallerExtracurricular")
     */
    public function deleteTallerExtracurricular($tallerextracurricularid)
    {
        try {
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio("CeGradoportallerextracurricular","tallerextracurricularid",$tallerextracurricularid);
            $dbm->removeManyRepositorio("CeHorarioportaller","tallerextracurricularid",$tallerextracurricularid);
            $dbm->removeManyRepositorio("CeMaterialportallerextracurricular","tallerextracurricularid",$tallerextracurricularid);
            $taller = $dbm->getRepositorioById("CeTallerextracurricular","tallerextracurricularid",$tallerextracurricularid);
            $dbm->removeRepositorio($taller);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya tiene relación a unn subconcepto. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * Copia un taller extracuricular a otro ciclo
     * @Rest\Post("/api/Controlescolar/TallerExtracurricular/Copiar", name="copyTallerExtracurricular")
     */
    public function copyTallerExtracurricular()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $cicloid=$data["cicloid"];
            $dbm->getConnection()->beginTransaction();
            foreach ($data["tallerextracurricularid"] as $tallerextracurricularid){
                $taller = $dbm->getRepositorioById("CeTallerextracurricular","tallerextracurricularid",$tallerextracurricularid);
                $taller=clone $taller;
                $taller->setCicloid($dbm->getRepositorioById("Ciclo","cicloid",$cicloid));
                $dbm->saveRepositorio($taller);

                $grados=$dbm->getRepositoriosById("CeGradoportallerextracurricular","tallerextracurricularid",$tallerextracurricularid);
                foreach ($grados as $grado){
                    $gtec=clone $grado;
                    $gtec->setTallerextracurricularid($taller);
                    $dbm->saveRepositorio($gtec);
                }

                $materiales=$dbm->getRepositoriosById("CeMaterialportallerextracurricular","tallerextracurricularid",$tallerextracurricularid);
                foreach ($materiales as $material){
                    $mte=clone $material;
                    $mte->setTallerextracurricularid($taller);
                    $dbm->saveRepositorio($mte);
                }

                $horarios=$dbm->getRepositoriosById("CeHorarioportaller","tallerextracurricularid",$tallerextracurricularid);
                foreach ($horarios as $horario){
                    $ht = clone $horario;
                    $ht->setTallerextracurricularid($taller);
                    $dbm->saveRepositorio($ht);
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna la informacion de los alumnos
     * @Rest\Post("/api/Controlescolar/TallerExtracurricular/Alumnos", name="getAlumnos")
     */
    public function getAlumnos() {
        try {
            $content = trim(file_get_contents("php://input"));
            $filtros = json_decode($content, true);
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $alumnos = $dbm->ObtenerAlumnos($filtros);
            return new View($alumnos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Preregistra a los alumnos seleccionados
     * @Rest\Post("/api/Controlescolar/TallerExtracurricular/Preregistro", name="preregistroAlumnos")
     */
    public function preregistroAlumnos() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $taller=$dbm->getRepositorioById('CeTallerextracurricular', 'tallerextracurricularid',$data['tallerextracurricularid']);
            if (count($data["alumnoid"])>$taller->getCupo()){
                return new View("El número de alumnos excede el cupo del taller.", Response::HTTP_PARTIAL_CONTENT);
            }
            $subconcepto=$dbm->getRepositorioById('CjSubconceptoportaller', 'tallerextracurricularid',$data['tallerextracurricularid']);
            $dbm->getConnection()->beginTransaction();
            foreach ($data["alumnoid"] as $alumnoid){
                $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $alumnoid);
                $alumnoporciclo = $dbm->getOneByParametersRepositorio('CeAlumnoporciclo',['alumnoid'=>$alumnoid,"cicloid"=>$taller->getCicloid()->getCicloid()]);
                $hijopersonal = $dbm->getRepositorioById('CeAlumnoporpersonal', 'alumnoid', $alumnoid);
                $configuracion = $dbm->getRepositorios('CeConftalleresextracurriculares')[0];
                $talleresalumno = $dbm->getRepositoriosById('CeAlumnocicloportallerextra', 'alumnoporcicloid', $alumnoporciclo->getAlumnoporcicloid());
                foreach($talleresalumno as $talleralumno){
                    if($talleralumno->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNivelid() == 3 || $talleralumno->getAlumnoporcicloid()->getGradoid()->getNivelid()->getNivelid() == 4){
                        if($talleralumno->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 2){
                            if($talleralumno->getDocumentoporpagarid()){
                                $pordocumento = $dbm->getRepositoriosById('CeAlumnocicloportallerextra','documentoporpagarid', $talleralumno->getDocumentoporpagarid()->getDocumentoporpagarid());
                                if(count($pordocumento) == 1){
                                    //se elimina el documento por pagar
                                    $documentoporpagar = $dbm->getRepositorioById('CjDocumentoporpagar', 'documentoporpagarid', $talleralumno->getDocumentoporpagarid()->getDocumentoporpagarid());
                                    if($documentoporpagar->getPagoestatusid()->getPagoestatusid() == 2){
                                        return new View("El taller se encuentra pagado, por lo que no se pueden modificar los talleres.", Response::HTTP_PARTIAL_CONTENT);
                                    }
                                    $dbm->removeRepositorio($talleralumno);
                                    $dbm->removeRepositorio($documentoporpagar);
                                }else{
                                    $dbm->removeRepositorio($talleralumno);
                                }
                            }else{
                                // eliminamos el registro
                                $dbm->removeRepositorio($talleralumno);
                            }
                        }
                    }else{
                        if($talleralumno->getTallerextraestatusinscripcionid()->getTallerextraestatusinscripcionid() == 2){
                            // eliminamos el registro
                            $dbm->removeRepositorio($talleralumno);
                        }
                    }
                }

                $dt = new \DateTime();
                $dt->modify('+ '. $configuracion->getHorasreservacion() .' hour');
                if($alumnoporciclo->getGradoid()->getNivelid()->getNivelid() == 3 || $alumnoporciclo->getGradoid()->getNivelid()->getNivelid() == 4){
                    
                    $documentoporpagar = $dbm->getOneByParametersRepositorio('CjDocumentoporpagar',[
                        'cicloid' => $alumnoporciclo->getCicloid()->getCicloid(),
                        'gradoid' => $alumnoporciclo->getGradoid(),
                        'alumnoid' => $alumnoid,
                        'subconceptoid' => $subconcepto->getSubconceptoid()
                    ]);
                    if(!$documentoporpagar){
                        $subconcepto = $subconcepto;
                        $tipodocumento = $dbm->getRepositorioById('Parametros', 'nombre', 'TipoDocumentoId');
                        $documento = $dbm->getRepositorioById('CjDocumento','tipodocumento',$tipodocumento->getValor());
                        $pagoestatus = $dbm->getRepositorioById('CjPagoestatus', 'pagoestatusid', 0);
                        $ciclo = $alumnoporciclo->getCicloid();
                        $grado = $alumnoporciclo->getGradoid();
                        if($alumno->getHijopersonal()){
                            $importe = $subconcepto->getSubconceptoid()->getImporte() - ($subconcepto->getImporte() * ($configuracion->getDescuentoempleados() / 100));
                        }else{
                            $importe = $subconcepto->getSubconceptoid()->getImporte();
                        }
                        $documentoporpagar = new CjDocumentoporpagar();
                        $documentoporpagar->setSubconceptoid($subconcepto->getSubconceptoid());
                        $documentoporpagar->setDocumentoid($documento);
                        $documentoporpagar->setPagoestatusid($pagoestatus);
                        $documentoporpagar->setAlumnoid($alumnoporciclo->getAlumnoid());
                        $documentoporpagar->setCicloid($ciclo);
                        $documentoporpagar->setGradoid($grado);
                        $documentoporpagar->setImporte($importe);
                        $documentoporpagar->setSaldo($importe);
                        $documentoporpagar->setFechalimitepago($dt);
                        $documentoporpagar->setFechaprontopago($dt);
                        $documentoporpagar->setFechacreacion(new \DateTime());
                        $documentoporpagar->setConcepto($subconcepto->getSubconceptoid()->getNombre());
                        $dbm->saveRepositorio($documentoporpagar);
                    }

                    $tallerestatus = $dbm->getRepositorioById('CeTallerextraestatusinscripcion', 'tallerextraestatusinscripcionid', 2);

                    $alumnociclotallerextra = new CeAlumnocicloportallerextra();
                    $alumnociclotallerextra->setAlumnoporcicloid($alumnoporciclo);
                    $alumnociclotallerextra->setTallerextraid($taller);
                    $alumnociclotallerextra->setTallerextraestatusinscripcionid($tallerestatus);
                    $alumnociclotallerextra->setFechavencimiento($dt);
                    $alumnociclotallerextra->setReglamento(false);
                    $alumnociclotallerextra->setMaterialentregado(false);
                    $alumnociclotallerextra->setDocumentoporpagarid($documentoporpagar);
                    $dbm->saveRepositorio($alumnociclotallerextra);

                    $entidad=$taller;
                    $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoporcicloid()->getAlumnoid()->getAlumnoid());
                    if ($usuariodestino){
                        $usuariodestino=$usuariodestino->getUsuarioid();
                        $actividad=[
                            "tipoactividadid"=>26,
                            "usuariodestinoid"=>$usuariodestino
                        ];
                        \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
                    }


                    
                }

            }
            $dbm->getConnection()->commit();
            return new View("Se preregistraron alumnos.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un material para taller extracuricular
     * @Rest\Post("/api/Controlescolar/TallerExtracurricular/Material", name="saveMaterialTallerExtracurricular")
     */
    public function saveMaterialTallerExtracurricular()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $material = $hydrator->hydrate(new CeTallermaterial(), $data);
            $dbm->saveRepositorio($material);
            $dbm->getConnection()->commit();
            return new View(["mensaje"=>"Se ha guardado el registro","material"=>$material], Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
	 * @Rest\Get("/api/Controlescolar/Tallerextracurricular/Descargarcredencial/{id}", name="getCredencialJasper")
	 */
	public function getCredencialJasper($id){
        $dbm = new DbmTalleresExtracurriculares($this->get("db_manager")->getEntityManager());
		$rs=$dbm->getRepositorioById("CeTallerextracurricular", "tallerextracurricularid", $id);
		if($rs=== false){
			return Api::Error(Response::HTTP_BAD_REQUEST, false);
		}
		$data=$rs;
		if(!$data || !$data->getFormato()){
			return Api::Error(Response::HTTP_PARTIAL_CONTENT, "No existe formato.");
		}
		$fdata=json_decode(stream_get_contents($data->getFormato()), true);
		$size=$fdata['size'];
		$jasper=base64_decode($fdata['value']);
		return new Response($jasper, 200, [
				'Content-Disposition'=>'attachment; filename="Credencial.jrxml"',
				'Content-Length'=>$size
		]);
	}
}