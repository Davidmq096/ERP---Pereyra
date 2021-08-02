<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAprendizajeesperado;
use AppBundle\Entity\CeAprendizajeesperadopormateria;
use AppBundle\Entity\CeAprendizajepormateriaporsubmateria;
use AppBundle\Entity\CeComentarioaprendizajepormateria;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class AprendizajesEsperadosController extends FOSRestController
{
    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Get("/api/Controlescolar/AprendizajesEsperados", name="indexAprendizajes")
     */
    public function indexAprendizajes()
    {
        try {
            $hoy = new \DateTime();
            $today = $hoy->format('d-m-Y');
            $periodos = [];
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $planestudios = $dbm->getRepositorios('CePlanestudios');
            $parametro = $dbm->getRepositorioById('Parametros', 'nombre', 'LongitudObservacion');
            

            return new View(
                array("ciclo" => $ciclo,
                    "nivel" => $nivel,
                    "grado" => $grado,
                    "semestre" => $semestre,
                    "planestudios" => $planestudios,
                    "parametro" => $parametro? $parametro->getValor() : null
                ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Controlescolar/AprendizajesEsperados/GetAprendizajesEsperados", name="getAprendizajesEsperados")
     */
    public function getAprendizajesEsperados()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $materiasa = $dbm->getByParametersRepositorios('CeMateriaporplanestudios', 
                array(
                    "planestudioid" => $filtros['planestudioid'], 
                    "configurarsubmaterias" => true
                )
            );
            if(!$materiasa) {
                return new View("No se han encontrado submaterias con los filtros consultados", Response::HTTP_PARTIAL_CONTENT);
            }


            $periodoeval = $dbm->getRepositoriosModelo("CePeriodoevaluacion", 
            ["d.periodoevaluacionid, d.descripcion, IDENTITY(c.cicloid) as cicloid, GROUPCONCAT(DISTINCT IDENTITY(g.gradoid)) as gradoid"], 
            [["periodoevaluacionid is not null and c.cicloid = " .$filtros['cicloid'] . " and g.gradoid = " .$filtros['gradoid']]], false, true, [
              
                ["entidad" => "CeConjuntoperiodoevaluacion", "alias" => "c", "left" => false, "on" => "c.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"],
                ["entidad" => "CeGradoporconjuntoperiodoescolar", "alias" => "g", "left" => false, "on" => "g.conjuntoperiodoevaluacionid = d.conjuntoperiodoevaluacionid"]
            ], "d.periodoevaluacionid");
            
            if(!$periodoeval) {
                return new View("No se han encontrado periodos de evaluación con los filtros consultados", Response::HTTP_PARTIAL_CONTENT);
            }

            $aprendizajeesperado = $dbm->getOneByParametersRepositorio('CeAprendizajeesperado', 
                array(
                    "cicloid" => $filtros['cicloid'], 
                    "gradoid" => $filtros['gradoid'],
                    "planestudioid" => $filtros['planestudioid'],
                )
            );
            $dbm->getConnection()->beginTransaction();
            if(!$aprendizajeesperado) {
                foreach($periodoeval as $p) {
                    $apesp = new CeAprendizajeesperado();
                    $apesp->setPeriodoevaluacionid($p['periodoevaluacionid'] ?
                        $dbm->getRepositorioById('CePeriodoevaluacion', 'periodoevaluacionid', $p['periodoevaluacionid']) : null);
                    $apesp->setConfigurarcomentarios(true);
                    $apesp->setGradoid($filtros['gradoid'] ?
                        $dbm->getRepositorioById('Grado', 'gradoid', $filtros['gradoid']) : null);    
                    $apesp->setCicloid($filtros['cicloid'] ?
                        $dbm->getRepositorioById('Ciclo', 'cicloid', $filtros['cicloid']) : null);     
                    $apesp->setPlanestudioid($filtros['planestudioid'] ?
                        $dbm->getRepositorioById('CePlanestudios', 'planestudioid', $filtros['planestudioid']) : null);   
                    
                    $dbm->saveRepositorio($apesp);    

                    
                    foreach($materiasa as $m) {
                        $aexmat = new CeAprendizajeesperadopormateria();
                        $aexmat->setAprendizajesesperadoid($apesp);
                        $aexmat->setMateriaporplanestudioid($m);
                        $dbm->saveRepositorio($aexmat);
                    }
                }

                $dbm->getConnection()->commit();

                $datas = $this->loadAprendizajes($filtros, $dbm);

            } else {
                $datas =$this->loadAprendizajes($filtros, $dbm);
            }
            
            if($datas['error']) {
                return new View($datas['mensaje'], Response::HTTP_PARTIAL_CONTENT);

            }
            return new View(array("data" => $datas, "materias" => $materiasa), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public static function loadAprendizajes($filtros, $dbm) {

        try {
            $recorrer = false;
            $aprendizajeesperado = $dbm->getRepositoriosModelo("CeAprendizajeesperado", 
            ["d.aprendizajeesperadoid, d.configurarcomentarios, IDENTITY(d.periodoevaluacionid) as periodoevaluacionid, c.descripcion as periodoevaluacion, IDENTITY(d.cicloid) as cicloid, IDENTITY(d.gradoid) as gradoid"], 
            [["aprendizajeesperadoid is not null and d.cicloid = " .$filtros['cicloid'] . " and d.gradoid = " .$filtros['gradoid'] . "and d.planestudioid =" .$filtros['planestudioid']]], false, true, [
              
                ["entidad" => "CePeriodoevaluacion", "alias" => "c", "left" => false, "on" => "c.periodoevaluacionid = d.periodoevaluacionid"],
            ]);
            
            foreach($aprendizajeesperado as $key=>$ap) {
                $materias = $dbm->getRepositoriosModelo("CeAprendizajeesperadopormateria", 
                ["d.aprendizajeesperadopormateriaid, c.materiaporplanestudioid, m.nombre, m.materiaid, IDENTITY(cc.ponderacionid) as ponderacionid"], 
                    [["aprendizajeesperadopormateriaid is not null and d.aprendizajesesperadoid = " .$ap['aprendizajeesperadoid']]], false, true, [

                    ["entidad" => "CeMateriaporplanestudios", "alias" => "c", "left" => false, "on" => "c.materiaporplanestudioid = d.materiaporplanestudioid"],
                    ["entidad" => "CeComponentecurricular", "alias" => "cc", "left" => false, "on" => "cc.componentecurricularid = c.componentecurricularid"],

                    ["entidad" => "Materia", "alias" => "m", "left" => false, "on" => "m.materiaid = c.materiaid"],
                ]);

                $aprendizajeesperado[$key]['materias'] = $materias;

                foreach($materias as $kyz=>$apm) {
                    $submaterias = $dbm->getRepositoriosModelo("CeAprendizajepormateriaporsubmateria", 
                    ["d.aprendizajeesperadopormaterisubmateriaid,m.nombre, m.materiaid"], 
                        [["aprendizajeesperadopormaterisubmateriaid is not null and d.aprendizajepormateriaid = " .$apm['aprendizajeesperadopormateriaid']]], false, true, [
    
                        ["entidad" => "Materia", "alias" => "m", "left" => false, "on" => "m.materiaid = d.materiaid"],
                    ]);

                    $aprendizajeesperado[$key]['materias'][$kyz]['submaterias'] = $submaterias ? $submaterias : [];

                    foreach($submaterias as $kyp=>$sub) {
                        $comentarios = $dbm->getRepositoriosModelo("CeComentarioaprendizajepormateria", 
                        ["d.comentarioaprendizajepormateriaid, p.opcion, d.comentario, IDENTITY(d.ponderacionid) ponderacionid, p.opcion"], 
                            [["comentarioaprendizajepormateriaid is not null and d.aprendizajeesperadopormaterisubmateriaid = ". $sub['aprendizajeesperadopormaterisubmateriaid'] ]], false, true, [
        
                            ["entidad" => "CePonderacionopcion", "alias" => "p", "left" => true, "on" => "p.ponderacionopcionid = d.ponderacionid"],
                        ]);

                        $aprendizajeesperado[$key]['materias'][$kyz]['submaterias'][$kyp]['comentarios'] = $comentarios;
                    }
                }
            }
            
            return $aprendizajeesperado;
        }catch (\Exception $e) {
            return ["mensaje" => "No se pudo comunicar con el servido", "error" => true];
        }

    }

        /**
     * 
     * @Rest\Post("/api/Controlescolar/AprendizajesEsperados/GuardarSubmateriasAprendizaje", name="GuardarSubmateriasAprendizaje")
     */
    public function GuardarSubmateriasAprendizaje()
    {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $dbm->getConnection()->beginTransaction();

        try {
            $aprendizajeesperado = $dbm->getOneByParametersRepositorio('CeAprendizajeesperadopormateria', 
                array(
                    "aprendizajesesperadoid" => $data['objeto']['aprendizajeesperadoid'], 
                    "materiaporplanestudioid" => $data['form']['materiaporplanestudioid']
                )
            );
            if(!$aprendizajeesperado) {
                return new View("No se ha encontrado un aprendizaje con la materia seleccionada", Response::HTTP_PARTIAL_CONTENT);
            }


            $materiadetail = $dbm->getRepositoriosModelo("CeAprendizajeesperadopormateria", 
            ["d.aprendizajeesperadopormateriaid, c.materiaporplanestudioid, m.nombre, m.materiaid, IDENTITY(cc.ponderacionid) as ponderacionid"], 
                [["aprendizajeesperadopormateriaid = " .$aprendizajeesperado->getAprendizajeesperadopormateriaid()]], false, true, [

                ["entidad" => "CeMateriaporplanestudios", "alias" => "c", "left" => false, "on" => "c.materiaporplanestudioid = d.materiaporplanestudioid"],
                ["entidad" => "CeComponentecurricular", "alias" => "cc", "left" => false, "on" => "cc.componentecurricularid = c.componentecurricularid"],

                ["entidad" => "Materia", "alias" => "m", "left" => false, "on" => "m.materiaid = c.materiaid"],
            ])[0];

            foreach($data['listamaterias'] as $list) {
                $submateria = $dbm->getOneByParametersRepositorio('CeAprendizajepormateriaporsubmateria', 
                    array(
                        "materiaid" => $list
                    )
                );


                $submateria = $dbm->getRepositoriosModelo("CeAprendizajepormateriaporsubmateria", 
                ["d.aprendizajeesperadopormaterisubmateriaid"], 
                    [["aprendizajeesperadopormaterisubmateriaid is not null and d.materiaid = " . $list . " and a.aprendizajeesperadoid = " . $data['objeto']['aprendizajeesperadoid'] ]], false, true, [
                    ["entidad" => "CeAprendizajeesperadopormateria", "alias" => "aem", "left" => false, "on" => "aem.aprendizajeesperadopormateriaid = d.aprendizajepormateriaid"],
                    ["entidad" => "CeAprendizajeesperado", "alias" => "a", "left" => false, "on" => "a.aprendizajeesperadoid = aem.aprendizajesesperadoid"]

                ])[0];

                if($submateria) {
                    return new View("Ya se existen una o mas submaterias en la materia consultada", Response::HTTP_PARTIAL_CONTENT);
                }
                $materia = new CeAprendizajepormateriaporsubmateria();
                $materia->setAprendizajepormateriaid($aprendizajeesperado);
                $materia->setMateriaid($dbm->getRepositorioById('Materia', 'materiaid',$list));
                $dbm->saveRepositorio($materia);

                $ponderaciones = $dbm->getRepositoriosById('CePonderacionopcion', 'ponderacionid', $materiadetail['ponderacionid']);
                foreach($ponderaciones as $p) {
                    $comentario = new CeComentarioaprendizajepormateria();
                    $comentario->setPonderacionid($p);
                    $comentario->setAprendizajeesperadopormaterisubmateriaid($materia);
                    $dbm->saveRepositorio($comentario);
                    $recorrer = true;
                
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        }catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Elimina un registro
     * @Rest\Post("/api/Controlescolar/AprendizajesEsperados/EliminarSubmateriaAprendizaje/", name="EliminarSubmateriaAprendizaje")
     */
    public function EliminarSubmateriaAprendizaje()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio('CeComentarioaprendizajepormateria', 'aprendizajeesperadopormaterisubmateriaid', $data['aprendizajeesperadopormaterisubmateriaid']);           
            $dbm->removeManyRepositorio('CeAprendizajepormateriaporsubmateria', 'aprendizajeesperadopormaterisubmateriaid', $data['aprendizajeesperadopormaterisubmateriaid']);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * 
     * @Rest\Post("/api/Controlescolar/AprendizajesEsperados/GuardarComentarioAprendizaje/", name="GuardarComentarioAprendizaje")
     */
    public function GuardarComentarioAprendizaje()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $comentario = $dbm->getRepositorioById('CeComentarioaprendizajepormateria', 'comentarioaprendizajepormateriaid',$data['comentarioaprendizajepormateriaid']);
            $comentario->setComentario($data['comentario'] ? $data['comentario'] : '');
            $dbm->saveRepositorio($comentario);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            
        }
    }

        /**
     * 
     * @Rest\Post("/api/Controlescolar/AprendizajesEsperados/GuardarAprendizajeComentario/", name="GuardarAprendizajeComentario")
     */
    public function GuardarAprendizajeComentario()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $comentario = $dbm->getRepositorioById('CeAprendizajeesperado', 'aprendizajeesperadoid',$data['aprendizajeesperadoid']);
            $comentario->setConfigurarcomentarios($data['configurarcomentarios']);
            $dbm->saveRepositorio($comentario);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            
        }
    }

            /**
     * 
     * @Rest\Post("/api/Controlescolar/AprendizajesEsperados/CopiarAprendizajeInfo/", name="CopiarAprendizajeInfo")
     */
    public function CopiarAprendizajeInfo()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $aprendizajedestino = $dbm->getRepositorioById('CeAprendizajeesperado', 'aprendizajeesperadoid',$data['aprendizajeesperadoid']);
            $aprendizajecopia = $dbm->getOneByParametersRepositorio('CeAprendizajeesperado', 
                array(
                    "cicloid" => $aprendizajedestino->getCicloid()->getCicloid(),
                    "gradoid" => $aprendizajedestino->getGradoid()->getGradoid(),
                    "planestudioid" => $aprendizajedestino->getPlanestudioid()->getPlanestudioid(),
                    "periodoevaluacionid" => $aprendizajedestino->getPeriodoevaluacionid()->getPeriodoevaluacionid() - 1
                )
            );

            $materiasdestino = $dbm->getRepositoriosById('CeAprendizajeesperadopormateria', 'aprendizajesesperadoid',$aprendizajedestino->getAprendizajeesperadoid());
            $materiascopia = $dbm->getRepositoriosById('CeAprendizajeesperadopormateria', 'aprendizajesesperadoid',$aprendizajecopia->getAprendizajeesperadoid());
            foreach($materiasdestino as $mc) {
                $sub = $dbm->getRepositoriosById('CeAprendizajepormateriaporsubmateria', 'aprendizajepormateriaid',$mc->getAprendizajeesperadopormateriaid());
                if(count($sub) > 0){
                    return new View("El periodo seleccionado ya tiene submaterias asignadas", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            
            
            foreach($materiascopia as $key=>$md) {
                $submaterias = $dbm->getRepositoriosById('CeAprendizajepormateriaporsubmateria', 'aprendizajepormateriaid',$md->getAprendizajeesperadopormateriaid());
                
                foreach($submaterias as $s) {
                    $submateria = new CeAprendizajepormateriaporsubmateria();
                    $submateria->setMateriaid($s->getMateriaid());
                    $submateria->setAprendizajepormateriaid($materiasdestino[$key]);
                    $dbm->saveRepositorio($submateria);

                    $comentarios = $dbm->getRepositoriosById('CeComentarioaprendizajepormateria', 'aprendizajeesperadopormaterisubmateriaid',$s->getAprendizajeesperadopormaterisubmateriaid());
                    foreach($comentarios as $c) {
                        $com = new CeComentarioaprendizajepormateria();
                        $com->setAprendizajeesperadopormaterisubmateriaid($submateria);
                        $com->setPonderacionid($c->getPonderacionid());
                        $com->setComentario($c->getComentario());
                        $dbm->saveRepositorio($com);
                    }
                }
                
            }

            $dbm->getConnection()->commit();
            return new View("Se han copiado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            
        }
    }


}