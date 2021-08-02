<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\CeReportedisciplina;
use AppBundle\Entity\CeAlumnociclopreregistroportaller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Proxies\__CG__\AppBundle\Entity\CeAlumnocicloportaller;
use Proxies\__CG__\AppBundle\Entity\CeTallerbitacora;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;

class ArmadoTallerCurricularController extends FOSRestController
{
    /**
     * @Rest\Get("/api/Controlescolar/preregistrocurricular/{id}", name="indexpreregistroTaller")
     */
    public function indexpreregistroTaller($id) {
        try{
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $conn = $this->get("db_manager")->getConnection();
            $alumno = $dbm->BuscarAlumnosA(["alumnoid" =>$id]);
            $stmt = $conn->prepare('SELECT foto FROM ce_alumnofotocicloactualvista WHERE alumnoid = :alumnoid');
            $stmt->execute(array('alumnoid' => $id));
            $alumno[0]['foto'] = $stmt->fetch()['foto'];
            $periodoinscripcion = $dbm->getRepositorios('CeTallerperiodoinscripcion');
            $configuracion = $dbm->getRepositorios('CeConftallercurricular');
            $configuracionopcion = $dbm->getRepositoriosById('CeTalleropcionregistro', 'gradoid', intval($alumno[0]['gradoid']));
            $preregistrotaller = $dbm->BuscarPreregistrotalleres(intval($alumno[0]['alumnoporcicloid']));
            $materiasalumno = $dbm->getMateriasporalumno(intval($alumno[0]['gradoid']), intval($alumno[0]['cicloid']));

            $listaalumno = count($materiasalumno);

            for ($i=0; $i < $listaalumno; $i++) { 
                $materiasalumno[$i]['talleres'] = $dbm->getTalleresPorMateriaplanestudio($materiasalumno[$i]['materiaporplanestudioid'], intval($alumno[0]['cicloid']));
            }

            for ($j=0; $j <$listaalumno; $j++) { 
                $listataller = count($materiasalumno[$j]['talleres']);
                for ($k=0; $k < $listataller; $k++) { 
                    $talleractual = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $materiasalumno[$j]['talleres'][$k]['tallercurricularid']);
                   if($talleractual->getTalleranteriorid()){
                        $alumnotaller =  $dbm->getOneByParametersRepositorio("CeAlumnoporciclo", array('cicloid' => $talleractual->getTalleranteriorid()->getCicloid(), 'alumnoid' => $id));
                        if ($alumnotaller) {
                            $talleranterior = $dbm->getOneByParametersRepositorio("CeAlumnocicloportaller", 
                            array('alumnoporcicloid' => $alumnotaller->getAlumnoporcicloid(),
                                  'tallercurricularid' => $talleractual->getTalleranteriorid()->getTallercurricularid()
                                ));
                        }

                        if ($talleranterior) {
                            \array_splice($materiasalumno[$j]['talleres'], $k, 1);
                            $listataller = $listataller -1;
                        }
                   }


                }

            }

            return new View(array(
                "periodoinscripcion" => $periodoinscripcion,
                "alumno" => $alumno,
                "configuracion" => $configuracion,
                "configuracionopcion" => $configuracionopcion,
                "preregistrotaller" => $preregistrotaller,
                "materias" => $materiasalumno
            ), Response::HTTP_OK);
        }catch(\Exception $e){ return new View($e->getMessage(), Response::HTTP_BAD_REQUEST); }
    }

    /**
     * @Rest\Post("/api/Controlescolar/preregistrocurricular" , name="SavePreregistroTallerCurricular")
     */
    public function SavePreregistroTallerCurricular() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $dbm->removeManyRepositorio('CeAlumnociclopreregistroportaller', 'alumnoporcicloid', intval($data[0]['alumnoporcicloid']));
            foreach ($data as $c) {
                $preregistro = new CeAlumnociclopreregistroportaller();
                $preregistro->setFechapreregistro(new \DateTime());
                $preregistro->setPrioridad(empty($c['prioridad']) ? null : ($c['prioridad']));
                $preregistro->setAlumnoporcicloid(empty($c['alumnoporcicloid']) ? null :
                $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $c['alumnoporcicloid']));
                $preregistro->setClasificadorparaescolaresid(null);
                $preregistro->setTallercurricularid($dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $c['tallercurricularid']));
                $dbm->saveRepositorio($preregistro);
            }

            foreach ($data as $c) {
                $bitacora = new CeTallerbitacora();
                $bitacora->setFecha(new \DateTime());
                $bitacora->setTallerid(empty($c['tallercurricularid']) ? null : ($c['tallercurricularid']));
                $bitacora->setMotivo(null);
                $bitacora->setAlumnoporcicloid(empty($c['alumnoporcicloid']) ? null :
                $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $c['alumnoporcicloid']));
                $bitacora->setTalleraccionid($dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 9));
                $bitacora->setTipotallerid($dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1));
                $bitacora->setUsuarioid(empty($c['usuarioid']) ? null :
                $dbm->getRepositorioById('Usuario', 'usuarioid', $c['usuarioid']));
                $dbm->saveRepositorio($bitacora);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        }catch(\Exception $e){ return new View($e->getMessage(), Response::HTTP_BAD_REQUEST); }
    }
    /**
     * @Rest\Delete("/api/Controlescolar/TallerCurricular/Armado/EliminarAlumno/{alumnocicloportallerid}" , name="setEliminarAlumno")
     */
    public function setEliminarAlumno($alumnocicloportallerid) {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $alumnocicloportaller = $dbm->getRepositorioById('CeAlumnocicloportaller', 'alumnocicloportallerid', $alumnocicloportallerid);
            $tallerid = $alumnocicloportaller->getTallercurricularid()->getTallercurricularid();
            if($alumnocicloportaller){
                $dbm->removeRepositorio($alumnocicloportaller);
            }
            $this->GenerarNumeroLista($tallerid);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        }catch(\Exception $e){ return new View($e->getMessage(), Response::HTTP_BAD_REQUEST); }
    }
    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/TallerCurricular/Armado/Filtro", name="getFiltro")
     */
    public function getFiltro()
    {
        try {
            $filtros = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $clasificadorparaescolares = $dbm->getRepositoriosById('CeClasificadorparaescolares', 'activo', 1);
            $profesorid = null;
            if($filtros['uid']){
                $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $filtros['uid']);
                if($usuario){
                    if($usuario->getProfesorid()){
                        $profesorid = $usuario->getProfesorid()->getProfesorid();
                    }
                }
            }
            $talleres = [];
            $tallerestmp = $dbm->getTalleresCurriculares([
                'orden' => true,
                'profesorid' => $profesorid
            ]);

            if($filtros['permiso'] == true){
                $talleres = $tallerestmp;
            }else{
                foreach($tallerestmp as $taller){
                    $pme = $dbm->getRepositorioById('CeProfesorpormateriaplanestudios', 'tallerid', $taller['tallercurricularid']);
                    if($pme){
                        $us = $dbm->getRepositorioById('Usuario', 'profesorid', $pme->getProfesorid()->getProfesorid());
                        if($us){
                            if($us->getUsuarioid() == $filtros['uid']){
                                $talleres[] = $taller;
                            }
                        }
                    }
                }
            }



            return new View(array("ciclo" => $ciclo,"talleres" => $talleres, 'grado' => $grado, 'grupo' => $grupo, 'nivel' => $nivel, 'clasificadorparaescolares' => $clasificadorparaescolares), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/TallerCurricular/ArmadoRotacion/Filtro", name="getFiltroRotacion")
     */
    public function getFiltroRotacion()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $planestudios = $dbm->getRepositorios('CePlanestudios');
            $materias = array();
            foreach ($planestudios as $p) {
                $materias = array_merge(
                    $materias,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid(), 'configurartaller' => 1]
                    )
                );
            }

            $filtro = array
                (
                'ciclo' => $ciclo,
                'planestudios' => $planestudios,
                'nivel' => $nivel,
                'grupo' => $grupo,
                'semestre' => $semestre,
                'materia' => $materias,
                'grado' => $grado
            );

            return new View($filtro, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
     /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/TallerCurricular/Armado/Consulta", name="getConsulta")
     */
    public function getConsulta()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumnos = $dbm->getAlumnosPorTallerCurricular($filtros);
            
            return new View($alumnos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Controlescolar/TallerCurricular/Armado/VerificarAlumnoMatricula", name="VerificarAlumnoMatricula")
     */
    public function VerificarAlumnoMatricula()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $filtros = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
						$cicloid=$filtros['cicloid'];
						$materiaid=$filtros['materiaid'];
                        $tallerid=$filtros['tallercurricularid'];
                        $clasificadorid =$filtros['clasificadorid'];
						$matricula=$filtros['matricula'];
            $taller = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $tallerid);
            if(is_array($matricula)){
                $als = [];
                foreach($matricula as $m){
                    $m = trim($m);
                    if(empty($m)){
                        continue;
                    }

                    $alumno = $dbm->getRepositorioById('CeAlumno', 'matricula', $m);
                    if(!$alumno){
                        return new View('La matrícula no existe', Response::HTTP_PARTIAL_CONTENT);
                    }
                    $alumnos = $dbm->BuscarAlumnosA(["alumnoid" => $alumno->getAlumnoid()])[0];
                    $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumnos['alumnoporcicloid']);

                    if(!$alumnoporciclo){
                        return new View('El alumno no esta activo', Response::HTTP_PARTIAL_CONTENT);
                    }

                    // $alumnocicloporgrupo = $dbm->getRepositorioById('CeAlumnocicloporgrupo', 'alumnoporcicloid', $alumnoporciclo->getAlumnoporcicloid());

                    // if(!$alumnocicloporgrupo){
                    //     return new View('El alumno no se ha asignado a un grupo', Response::HTTP_PARTIAL_CONTENT);
                    // }
                    
                    $tallerespormateria = $dbm->getByParametersRepositorios('CeGradoportallercurricular', [
                        'tallercurricularid' => $tallerid,
                        'gradoid' => $alumnoporciclo->getGradoid()->getGradoid()
                    ]);

                    $tallergrado = $dbm->getOneByParametersRepositorio('CeGradoportallercurricular', [
                        'tallercurricularid' => $tallerid
                    ]);

                    $anivel = $dbm->getOneByParametersRepositorio('CeAlumnocicloporidiomanivel', [
                        'idiomanivelid' => $tallergrado->getIdiomanivelid(),
                        'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid()
                    ]);

                    if(count($tallerespormateria) == 0){
                        if(!$anivel){
                            return new View('El alumno con matrícula '. $m .' no es compatible con la configuracion de grado y materia del taller.', Response::HTTP_PARTIAL_CONTENT);
                        }
                    }

                    $talleres = $dbm->getByParametersRepositorios('CeAlumnocicloportaller', [
                        'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid(),
                        'tallercurricularid' => $tallerid
                    ]);
        
                    if(count($talleres) > 0){
                        return new View('El alumno con matrícula '. $m .' ya esta inscrito a este taller', Response::HTTP_PARTIAL_CONTENT);
                    }

                    $warning = false;

                    $talleres = $dbm->getByParametersRepositorios('CeAlumnocicloportaller', [
                        'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid(),
                        'clasificadorparaescolarid' => $clasificadorid
                    ] );

                    if(count($talleres) > 0){
                        $warning = true;
                    }

                    $als[] = [
                        'alumnoid' => $alumno->getAlumnoid(),
                        'primernombre' =>  $alumno->getPrimernombre(),
                        'segundonombre' =>  $alumno->getSegundonombre(),
                        'apellidopaterno' =>  $alumno->getApellidopaterno(),
                        'apellidomaterno' =>  $alumno->getApellidomaterno(),
                        'sexo' =>  $alumno->getSexo(),
                        'matricula' => $alumno->getMatricula(),
                        'clasificadorparaescolaresid' => $taller->getClasificadorparaescolaresid()->getClasificadorparaescolaresid(),
                        'nivel' => $alumnoporciclo->getGradoid()->getNivelid()->getNombre(),
                        'grado' => $alumnoporciclo->getGradoid()->getGrado(),
                        'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid(),
                        'externo' => true,
                        'warning' => $warning
                    ];
                }
                return new View($als, Response::HTTP_OK);
            }else{
                $alumno = $dbm->getRepositorioById('CeAlumno', 'matricula', $matricula);
                if(!$alumno){
                    return new View('La matrícula no existe', Response::HTTP_PARTIAL_CONTENT);
                }
                $alumnoporciclo = $dbm->getOneByParametersRepositorio('CeAlumnoporciclo',[
                    'alumnoid' => $alumno->getAlumnoid(),
                    'cicloid' => $cicloid
                ]);

                if(!$alumnoporciclo){
                    return new View('El alumno no esta activo', Response::HTTP_PARTIAL_CONTENT);
                }

                // $alumnocicloporgrupo = $dbm->getRepositorioById('CeAlumnocicloporgrupo', 'alumnoporcicloid', $alumnoporciclo->getAlumnoporcicloid());

                // if(!$alumnocicloporgrupo){
                //     return new View('El alumno no se ha asignado a un grupo', Response::HTTP_PARTIAL_CONTENT);
                // }
                
                $tallerespormateria = $dbm->getByParametersRepositorios('CeGradoportallercurricular', [
                    'tallercurricularid' => $tallerid,
                    'gradoid' => $alumnoporciclo->getGradoid()->getGradoid()
                ]);

                $tallergrado = $dbm->getOneByParametersRepositorio('CeGradoportallercurricular', [
                    'tallercurricularid' => $tallerid
                ]);

                $anivel = $dbm->getOneByParametersRepositorio('CeAlumnocicloporidiomanivel', [
                    'idiomanivelid' => $tallergrado->getIdiomanivelid(),
                    'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid()
                ]);

                if(count($tallerespormateria) == 0){
                    if(!$anivel){
                        return new View('El alumno no es compatible con la configuracion de grado y materia del taller.', Response::HTTP_PARTIAL_CONTENT);
                    }
                }

                foreach($tallerespormateria as $tallerm){
                    $talleres = $dbm->getByParametersRepositorios('CeAlumnocicloportaller', [
                        'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid(),
                        'tallercurricularid' => $tallerm->getTallercurricularid()
                    ] );
        
                    if(count($talleres) > 0){
                        return new View('El alumno ya esta inscrito a un taller', Response::HTTP_PARTIAL_CONTENT);
                    }
                }

                $al = [
                    'alumnoid' => $alumno->getAlumnoid(),
                    'primernombre' =>  $alumno->getPrimernombre(),
                    'segundonombre' =>  $alumno->getSegundonombre(),
                    'apellidopaterno' =>  $alumno->getApellidopaterno(),
                    'apellidomaterno' =>  $alumno->getApellidomaterno(),
                    'sexo' =>  $alumno->getSexo(),
                    'matricula' => $alumno->getMatricula(),
                    'clasificadorparaescolaresid' => $taller->getClasificadorparaescolaresid()->getClasificadorparaescolaresid(),
                    'nivel' => $alumnoporciclo->getGradoid()->getNivelid()->getNombre(),
                    'grado' => $alumnoporciclo->getGradoid()->getGrado(),
                    'alumnoporcicloid' => $alumnoporciclo->getAlumnoporcicloid(),
                    'externo' => true
                ];

                return new View($al, Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/TallerCurricular/ArmadoRotacion/Consultar", name="getConsultaRotacion")
     */
    public function getConsultaRotacion()
    {
        try {
            $filtros = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $tallerestmp = [];
            $tallerestmps = $dbm->getTalleresCurriculares($filtros);
            foreach($tallerestmps as $tmp){
                if($tmp['cicloid'] == $filtros['cicloid']){
                   $tallerestmp[] = $tmp; 
                }
            }
            $porasignar = [];
            $asignados = [];
            $edicion = true;
            $busqueda = false;

            $talleresmatrix = array_fill(0, count($tallerestmp), null);
            $countDown = count($tallerestmp);
            $countUp = 2;

            foreach($talleresmatrix as $key => &$value){
                if($key == 0){
                    $value = 1;
                }else{
                    if(($key + 1) % 2 !== 0){
                        $value = $countDown;
                        $countDown--;
                    }else{
                        $value = $countUp;
                        $countUp++;
                    }
                }
            }

            
            for($i = 0; $i < count($tallerestmp); $i++){
                $next = $i+1;
                for($j = 0; $j < count($talleresmatrix); $j++){
                    if($next == $talleresmatrix[$j]){
                        $talleresmatrix[$j] = $tallerestmp[$i];
                    }
                }
            }
            
            $talleres = $tallerestmp;

            foreach($talleres as &$taller){
                $alumnos = $dbm->getAlumnosPorTallerCurricularRotacion([
                    'tallercurricularid' => $taller['tallercurricularid'],
                    'cicloid' => $filtros['cicloid'],
                    'gradoid' => $filtros['gradoid'],
                    'grupoid' => $filtros['grupoid'],
                ]);

                foreach($alumnos['asignados'] as $alumno){
                    $asignados[] = $alumno;
                }
            }

            foreach($talleres as &$taller){
                $alumnos = $dbm->getAlumnosPorTallerCurricularRotacion([
                    'tallercurricularid' => $taller['tallercurricularid'],
                    'cicloid' => $filtros['cicloid'],
                    'gradoid' => $filtros['gradoid'],
                    'grupoid' => $filtros['grupoid'],
                ]);

                if(!$busqueda){
                    if(count($alumnos['asignados']) > 0){
                        $al = $alumnos['asignados'][0];
                        if($al){
                            $alumnocicloportalleres = $dbm->getByParametersRepositorios('CeAlumnocicloportaller', [
                                'alumnoporcicloid' => $al['alumnoporcicloid']
                            ]);

                            if(count($alumnocicloportalleres) > 1){
                                $edicion = false;
                                $busqueda = true;
                            }
                        }
                    }       
                }

                foreach($alumnos['porasignar'] as $p){
                    $find = false;
                    foreach($porasignar as $pp){
                        if($pp['alumnoporcicloid'] == $p['alumnoporcicloid']){
                            $find = true;
                        }
                    }
                    foreach($asignados as $asi){
                        if($asi['alumnoporcicloid'] == $p['alumnoporcicloid']){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $porasignar[] = $p;
                    }
                }

                $taller['alumnos'] = $alumnos['asignados'];
            }

            if(count($talleres) == 0){
                return new View('No se encontraron resultados', Response::HTTP_PARTIAL_CONTENT);
            }

            return new View(['talleres' => $talleres, 'porasignar' => $porasignar, 'edicion' => $edicion], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function partition(Array $list, $p) {
        $listlen = count($list);
        $partlen = floor($listlen / $p);
        $partrem = $listlen % $p;
        $partition = array();
        $mark = 0;
        for($px = 0; $px < $p; $px ++) {
            $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice($list, $mark, $incr);
            $mark += $incr;
        }
        return $partition;
    }


     /**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Controlescolar/TallerCurricular/ArmadoRotacion/AsignacionAutomatica", name="AsignacionAutomaticaRotacion")
     */
    public function AsignacionAutomaticaRotacion()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $tallerestemp = $dbm->getTalleresCurriculares($filtros);
            $talleres = [];
            foreach($tallerestemp as $tmp){
                if($tmp['cicloid'] == $filtros['cicloid']){
                   $talleres[] = $tmp; 
                }
            }
            $porasignar = [];
            $asignados = [];
            $edicion = true;
            $porGenero = $filtros['genero'];
            $busqueda = false;
            $talleresa = $talleres;
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $filtros['usuarioid']);
            $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
            $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 6);
            
            foreach($talleres as &$taller){
                $alumnos = $dbm->getAlumnosPorTallerCurricularRotacion([
                    'tallercurricularid' => $taller['tallercurricularid'],
                    'cicloid' => $filtros['cicloid'],
                    'gradoid' => $filtros['gradoid']
                ]);
                $tallercur = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $taller['tallercurricularid']);

                $dbm->removeManyRepositorio('CeAlumnocicloportaller', 'tallercurricularid', $taller['tallercurricularid']);

                // foreach($alumnos['asignados'] as $alumno){
                //     $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno['alumnoporcicloid']);
                //     $anterior = $dbm->getRepositorioById('CeAlumnocicloportaller', 'alumnocicloportallerid', $alumno['alumnocicloportallerid']);
                //     $accionD = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 10);
                //     $bitacora =  new CeTallerbitacora();
                //     $bitacora->setAlumnoporcicloid($alumnoporciclo);
                //     $bitacora->setFecha(new \Datetime());
                //     $bitacora->setUsuarioid($usuario);
                //     $bitacora->setTallerid($tallercur->getTallercurricularid());
                //     $bitacora->setTipotallerid($tipotaller);
                //     $bitacora->setTalleraccionid($accionD);
                //     $dbm->saveRepositorio($bitacora);
                //     $dbm->removeRepositorio($anterior);
                // }
            }

            foreach($talleres as &$taller){
                $alumnos = $dbm->getAlumnosPorTallerCurricularRotacion([
                    'tallercurricularid' => $taller['tallercurricularid'],
                    'cicloid' => $filtros['cicloid'],
                    'gradoid' => $filtros['gradoid']
                ]);

                foreach($alumnos['asignados'] as $alumno){
                    $asignados[] = $alumno;
                }
            }

            foreach($talleres as &$taller){
                $alumnos = $dbm->getAlumnosPorTallerCurricularRotacion([
                    'tallercurricularid' => $taller['tallercurricularid'],
                    'cicloid' => $filtros['cicloid'],
                    'gradoid' => $filtros['gradoid']
                ]);

                if(!$busqueda){
                    if(count($alumnos['asignados']) > 0){
                        $al = $alumnos['asignados'][0];
                        if($al){
                            $alumnocicloportalleres = $dbm->getByParametersRepositorios('CeAlumnocicloportaller', [
                                'alumnoporcicloid' => $al['alumnoporcicloid'],
                                'tallercurricularid' => $taller['tallercurricularid']
                            ]);

                            if(count($alumnocicloportalleres) > 1){
                                $edicion = false;
                                $busqueda = true;
                            }
                        }
                    }       
                }

                foreach($alumnos['porasignar'] as $p){
                    $find = false;
                    foreach($porasignar as $pp){
                        if($pp['alumnoporcicloid'] == $p['alumnoporcicloid']){
                            $find = true;
                        }
                    }
                    foreach($asignados as $asi){
                        if($asi['alumnoporcicloid'] == $p['alumnoporcicloid']){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $porasignar[] = $p;
                    }
                }

                $taller['alumnos'] = $alumnos['asignados'];
            }

            if(count($talleres) == 0){
                return new View('No se encontraron resultados', Response::HTTP_PARTIAL_CONTENT);
            }

            $alumnos = [];
            
            if($porGenero){
                $masculino = [];
                $femenino = [];

                foreach($porasignar as $alumno){
                    if($alumno['sexo'] == 'M'){
                        $masculino[] = $alumno;
                    }else{
                        $femenino[] = $alumno;
                    }
                }
                
                $iterator = new \MultipleIterator;
                $iterator->attachIterator(new \ArrayIterator($masculino));
                $iterator->attachIterator(new \ArrayIterator($femenino));

                foreach ($iterator as $values) {
                    $alumnos[] = $values[0];
                    $alumnos[] = $values[1];
                }

                $notfound = [];

                foreach($porasignar as $alumno){
                    $found = false;
                    foreach($alumnos as $al){
                        if($al['alumnoid'] == $alumno['alumnoid']){
                            $found = true;
                        }
                    }
                    if(!$found){
                        $notfound[] = $alumno;
                    }
                }

                $alumnos = array_merge($alumnos, $notfound);

            }else{
                $alumnos = $porasignar;
            }

            $alumnostemp = $this->partition($alumnos, count($talleres));

            foreach($alumnostemp as $key => &$val){
                if(count($val) > $talleres[$key]['cupo']){
                    $count = (count($val) - $talleres[$key]['cupo']);
                    for($i = 0; $i < $count; $i++){
                        $deleted = false;
                        foreach($alumnostemp as $keys => $vals){
                            if(count($vals) < $talleres[$keys]['cupo']){
                                if(!$deleted){
                                    $alumnostemp[$keys][] = $val[$i];
                                    unset($alumnostemp[$key][$i]);
                                    $deleted = true;
                                }
                            }
                        }
                        if(!$deleted){
                            unset($alumnostemp[$key][$i]);
                        }
                    }
                }
            }

            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $filtros['usuarioid']);
            $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
            $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 6);
            
            foreach($alumnostemp as $key => $chunk){
                $tall = $talleres[$key];
                $tallercur = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $tall['tallercurricularid']);
                
                foreach($chunk as $alumno){
                    $alumnoporciclotalleranterior = $dbm->getOneByParametersRepositorio('CeAlumnocicloportaller', [
                        'alumnoporcicloid' => $alumno['alumnoporcicloid'],
                        'tallercurricularid' => $tallercur->getTallercurricularid(),
                    ]);
                    $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno['alumnoporcicloid']);
                    // foreach($alumnoporciclotalleranterior as $anterior){
                    //     $accionD = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 10);
                    //     $bitacora =  new CeTallerbitacora();
                    //     $bitacora->setAlumnoporcicloid($alumnoporciclo);
                    //     $bitacora->setFecha(new \Datetime());
                    //     $bitacora->setUsuarioid($usuario);
                    //     $bitacora->setTallerid($anterior->getTallercurricularid()->getTallercurricularid());
                    //     $bitacora->setTipotallerid($tipotaller);
                    //     $bitacora->setTalleraccionid($accionD);
                    //     $dbm->saveRepositorio($bitacora);
                    //     $dbm->removeRepositorio($anterior);
                    // }
                    
                    $alumnocicloportaller = new CeAlumnocicloportaller();
                    $alumnocicloportaller->setTallercurricularid($tallercur);
                    $alumnocicloportaller->setClasificadorparaescolarid($tallercur->getClasificadorparaescolaresid());
                    $alumnocicloportaller->setAlumnoporcicloid($alumnoporciclo);
                    $alumnocicloportaller->setVigente(1);
                    $dbm->saveRepositorio($alumnocicloportaller);
                }
                if(count($chunk)>0){
                    $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $chunk[0]['alumnoporcicloid']);
                    $bitacora =  new CeTallerbitacora();
                    $bitacora->setFecha(new \Datetime());
                    $bitacora->setAlumnoporcicloid($alumnoporciclo);
                    $bitacora->setUsuarioid($usuario);
                    $bitacora->setTallerid($tallercur->getTallercurricularid());
                    $bitacora->setTipotallerid($tipotaller);
                    $bitacora->setTalleraccionid($accion);
                    $dbm->saveRepositorio($bitacora);
                }
            }

            foreach($talleresa as $taller){
                $this->GenerarNumeroLista($taller['tallercurricularid']);
            }


            $dbm->getConnection()->commit();

            return new View('Se ha generado la asignación automática', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function GenerarNumeroLista($tallerid){
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $alumnos = $dbm->getByParametersRepositorios('CeAlumnocicloportaller',[
            'tallercurricularid' => $tallerid,
            'vigente' => 1
        ]);

        try{
            usort($alumnos, function($a, $b)
            {
                return strtr(strtolower($a->getAlumnoporcicloid()->getAlumnoid()->getApellidopaterno() . ' ' . $a->getAlumnoporcicloid()->getAlumnoid()->getApellidomaterno()) > strtolower($b->getAlumnoporcicloid()->getAlumnoid()->getApellidopaterno() . ' ' . $b->getAlumnoporcicloid()->getAlumnoid()->getApellidomaterno()), array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' ));
            }); 
        }catch(\Exception $e){

        }


        foreach($alumnos as $key => $alumno){
            $alumno->setNumerolista($key+1);
            $dbm->saveRepositorio($alumno);
        }
    }
     
    /**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Controlescolar/TallerCurricular/ArmadoRotacion/RotarTalleres", name="RotarTalleres")
     */
    public function RotarTalleres()
    {
        try {
            $filtros = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $tallerestemp = $dbm->getTalleresCurriculares($filtros);
            $talleres = [];
            foreach($tallerestemp as $tmp){
                if($tmp['cicloid'] == $filtros['cicloid']){
                   $talleres[] = $tmp; 
                }
            }
            $talleresa = $talleres;
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $filtros['usuarioid']);
            $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
            $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 7);

            // $talleresmatrix = array_fill(0, count($tallerestmp), null);
            // $countDown = count($tallerestmp);
            // $countUp = 2;

            // foreach($talleresmatrix as $key => &$value){
            //     if($key == 0){
            //         $value = 1;
            //     }else{
            //         if(($key + 1) % 2 !== 0){
            //             $value = $countDown;
            //             $countDown--;
            //         }else{
            //             $value = $countUp;
            //             $countUp++;
            //         }
            //     }
            // }

            
            // for($i = 0; $i < count($tallerestmp); $i++){
            //     $next = $i+1;
            //     for($j = 0; $j < count($talleresmatrix); $j++){
            //         if($next == $talleresmatrix[$j]){
            //             $talleresmatrix[$j] = $tallerestmp[$i];
            //         }
            //     }
            // }
            
            // $talleres = $talleresmatrix;

            $alumnosportaller = [];
            $matrix = [];
            $orden = [];
            $pass = true;

            foreach($talleres as $key => &$taller){
                $alumnosportaller[$key] = [];
                $matrix[$key] = [];
                $orden[$key] = $taller['orden'];
                $alumnos = $dbm->getAlumnosPorTallerCurricularRotacion([
                    'tallercurricularid' => $taller['tallercurricularid'],
                    'cicloid' => $filtros['cicloid'],
                    'gradoid' => $filtros['gradoid']
                ]);
                $alumnosportaller[$key] = $alumnos['asignados'];
            }

            $values = array_count_values($orden);
            arsort($values);
            $popularKeys = array_slice(array_keys($values), 0, 5, true);
            $popular = array_slice($values, 0, 5, true);

            $tot = $popular[$popularKeys[0]];
            foreach($popular as $pop){
                if($pop !== $tot){
                    return new View("Se encontraron diferencias en la rotación de talleres, debe tener la misma cantidad de talleres por número de orden.", Response::HTTP_PARTIAL_CONTENT);
                }
            }

            foreach($alumnosportaller as $key => $chunks){
                $next = ($key == (count($alumnosportaller) - 1)) ? 0 : ($key + 1);
                $prev = ($key == (count($alumnosportaller) - 1)) ? 0 : ($key - 1);
                if($tot > 1){
                    if($next > (count($alumnosportaller) - 2)){
                        $next = 0;
                    }
                    if($key == (count($alumnosportaller) -1)){
                        $prev = (count($alumnosportaller) - 1);
                    }
                    if($orden[$next] == $orden[$key]){
                        $next = $next + 1;
                    }else if($orden[$prev] == $orden[$key]){
                        $next = $next + 1;
                    }
                }
                if(count($matrix[$next]) > 0){
                    break;
                }
                $matrix[$next] = $chunks;
            }

            foreach($matrix as $key => &$val){
                if(count($val) > $talleres[$key]['cupo']){
                    $count = (count($val) - $talleres[$key]['cupo']);
                    for($i = 0; $i < $count; $i++){
                        $deleted = false;
                        unset($matrix[$key][$i]);
                    }
                }
            }

            foreach($matrix as $key => $chunk){
                $tallercurrent = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $talleres[$key]['tallercurricularid']);
                $alumnos = $dbm->getAlumnosPorTallerCurricularRotacion([
                    'tallercurricularid' => $tallercurrent->getTallercurricularid(),
                    'cicloid' => $filtros['cicloid'],
                    'gradoid' => $filtros['gradoid']
                ]);
                foreach($alumnos['asignados'] as $al){
                    $alumnocicloportaller = $dbm->getRepositorioById('CeAlumnocicloportaller', 'alumnocicloportallerid', $al['alumnocicloportallerid']);
                    $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $al['alumnoporcicloid']);
                    $alumnocicloportaller->setVigente(0);
                    $dbm->saveRepositorio($alumnocicloportaller);
                }
                foreach($chunk as $al){
                    $alumnoporciclotalleranterior = $dbm->getOneByParametersRepositorio('CeAlumnocicloportaller', [
                        'alumnoporcicloid' => $al['alumnoporcicloid'],
                        'tallercurricularid' => $tallercurrent->getTallercurricularid(),
                    ]);
                    if(!$alumnoporciclotalleranterior){
                        $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $al['alumnoporcicloid']);
                        $alumnocicloportaller = new CeAlumnocicloportaller();
                        $alumnocicloportaller->setTallercurricularid($tallercurrent);
                        $alumnocicloportaller->setClasificadorparaescolarid($tallercurrent->getClasificadorparaescolaresid());
                        $alumnocicloportaller->setAlumnoporcicloid($alumnoporciclo);
                        $alumnocicloportaller->setVigente(1);
                        $dbm->saveRepositorio($alumnocicloportaller);
                    }else{
                        $alumnoporciclotalleranterior->setVigente(1);
                        $dbm->saveRepositorio($alumnoporciclotalleranterior);
                    }
                    $bitacora =  new CeTallerbitacora();
                    $bitacora->setAlumnoporcicloid($alumnoporciclo);
                    $bitacora->setFecha(new \Datetime());
                    $bitacora->setUsuarioid($usuario);
                    $bitacora->setTallerid($tallercurrent->getTallercurricularid());
                    $bitacora->setTipotallerid($tipotaller);
                    $bitacora->setTalleraccionid($accion);
                    $dbm->saveRepositorio($bitacora);
                }
            }

            foreach($talleresa as $taller){
                $this->GenerarNumeroLista($taller['tallercurricularid']);
            }

            $dbm->getConnection()->commit();

            return new View('Se ha generado la rotación de talleres', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo iniciales
     * @Rest\Delete("/api/Controlescolar/TallerCurricular/ArmadoRotacion/Eliminar/{id}", name="eliminarInscripcionRotacion")
     */
    public function eliminarInscripcionRotacion($id)
    {
        try {
            $data = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']);
            $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
            $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 8);
            $alumnocicloportaller = $dbm->getRepositorioById('CeAlumnocicloportaller', 'alumnocicloportallerid', $id);
            $tallerid = $alumnocicloportaller->getTallercurricularid()->getTallercurricularid();
            if(!$alumnocicloportaller){
                return new View('No se encontro el registro', Response::HTTP_PARTIAL_CONTENT);
            }

            $bitacora =  new CeTallerbitacora();
            $bitacora->setAlumnoporcicloid($alumnocicloportaller->getAlumnoporcicloid());
            $bitacora->setFecha(new \Datetime());
            $bitacora->setUsuarioid($usuario);
            $bitacora->setTallerid($alumnocicloportaller->getTallercurricularid()->getTallercurricularid());
            $bitacora->setTipotallerid($tipotaller);
            $bitacora->setTalleraccionid($accion);
            $dbm->saveRepositorio($bitacora);
            $dbm->removeRepositorio($alumnocicloportaller);
            $this->GenerarNumeroLista($tallerid);
            $dbm->getConnection()->commit();
            return new View('Se elimino el registro', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Put("/api/Controlescolar/TallerCurricular/ArmadoRotacion/Editar", name="editarInscripcionRotacion")
     */
    public function editarInscripcionRotacion()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']);
            $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
            $taller = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $data['tallercurricularid']);
            $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 5);
            $alumnocicloportaller = $dbm->getRepositorioById('CeAlumnocicloportaller', 'alumnocicloportallerid', $data['alumnocicloportallerid']);

            if(!$alumnocicloportaller){
                return new View('No se encontro el registro', Response::HTTP_PARTIAL_CONTENT);
            }

            $alumnocicloportaller->setVigente(1);
            $alumnocicloportaller->setTallercurricularid($taller);
            $alumnocicloportaller->setClasificadorparaescolarid($taller->getClasificadorparaescolaresid());
            $dbm->saveRepositorio($alumnocicloportaller);


            $bitacora =  new CeTallerbitacora();
            $bitacora->setAlumnoporcicloid($alumnocicloportaller->getAlumnoporcicloid());
            $bitacora->setFecha(new \Datetime());
            $bitacora->setUsuarioid($usuario);
            $bitacora->setTallerid($alumnocicloportaller->getTallercurricularid()->getTallercurricularid());
            $bitacora->setTipotallerid($tipotaller);
            $bitacora->setTalleraccionid($accion);
            $bitacora->setMotivo($data['motivo']);
            $dbm->saveRepositorio($bitacora);
            $dbm->saveRepositorio($alumnocicloportaller);
            $dbm->getConnection()->commit();
            return new View('Se guardo el registro', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Controlescolar/TallerCurricular/ArmadoRotacion/AsignacionManual", name="AsignacionManualRotacion")
     */
    public function AsignacionManualRotacion()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']);
            $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
            $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 5);
            $taller = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $data['tallercurricularid']);
            foreach($data['alumnos'] as $alumno){
                $alumnoporciclotalleranterior = $dbm->getRepositoriosById('CeAlumnocicloportaller', 'alumnoporcicloid', $alumno);
                foreach($alumnoporciclotalleranterior as $anterior){
									$anteriortaller=$anterior->getTallercurricularid();
									$iatallerorden=$anteriortaller->getOrden();
									if($iatallerorden){
										$anterior->setVigente(0);
										$dbm->saveRepositorio($anterior);
									}
                }
                $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno);
                $alumnocicloportaller = new CeAlumnocicloportaller();
                $alumnocicloportaller->setTallercurricularid($taller);
                $alumnocicloportaller->setClasificadorparaescolarid($taller->getClasificadorparaescolaresid());
                $alumnocicloportaller->setAlumnoporcicloid($alumnoporciclo);
                $alumnocicloportaller->setVigente(1);
                $dbm->saveRepositorio($alumnocicloportaller);
                $bitacora =  new CeTallerbitacora();
                $bitacora->setAlumnoporcicloid($alumnoporciclo);
                $bitacora->setFecha(new \Datetime());
                $bitacora->setUsuarioid($usuario);
                $bitacora->setTallerid($data['tallercurricularid']);
                $bitacora->setTipotallerid($tipotaller);
                $bitacora->setTalleraccionid($accion);
                $dbm->saveRepositorio($bitacora);
            }
            $this->GenerarNumeroLista($data['tallercurricularid']);
            $dbm->getConnection()->commit();
            return new View('Se ha generado la asignación manual', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    public function ValidarCupos($dbm, $alumnos, $talleresPoralumnos, $tallerPrincipal, $talleralumnos, $talleralumnosM, $talleralumnosF, $prioridad, $actuales, $porGenero, $hermanos, $clavesFamiliares){
        $cupoD = (int)($tallerPrincipal->getCupo()/2);
        foreach($alumnos as $alumno){
            $total = count($talleralumnos) + $actuales;
            $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno);
            $alumnoporclavefamiliar = $dbm->getRepositorioById('CeAlumnoporclavefamiliar', 'alumnoid', $alumnoporciclo->getAlumnoid()->getAlumnoid());
            $gradoopcion = $dbm->getRepositorioById('CeTalleropcionregistro', 'gradoid', $alumnoporciclo->getGradoid()->getGradoid());
            $talleresPoralumno = $dbm->getRepositoriosById('CeAlumnociclopreregistroportaller','alumnoporcicloid', $alumno);
            if($tallerPrincipal->getClasificadorparaescolaresid()->getClasificadorparaescolaresid() == 3){
                $talleresPoralumno = $dbm->getRepositoriosById('CeAlumnociclopreregistroportaller','alumnoporcicloid', $alumno);
                if(!$talleresPoralumno){
                    $preregistro = new CeAlumnociclopreregistroportaller();
                    $preregistro->setFechapreregistro(new \DateTime());
                    $preregistro->setPrioridad(1);
                    $preregistro->setAlumnoporcicloid($alumnoporciclo);
                    $preregistro->setClasificadorparaescolaresid(null);
                    $preregistro->setTallercurricularid($tallerPrincipal);
                    $dbm->saveRepositorio($preregistro);
                    $talleresPoralumno = $dbm->getRepositoriosById('CeAlumnociclopreregistroportaller','alumnoporcicloid', $alumno);
                }
            }
            if($prioridad <= $gradoopcion->getNotalleres()){
                $set = false;
                if(count($talleresPoralumno) > 0){
                    foreach($talleresPoralumno as $key => $tallerporalumno){
                        if($tallerporalumno->getTallercurricularid()->getTallercurricularid() == $tallerPrincipal->getTallercurricularid()){
                            if($tallerporalumno->getPrioridad() == $prioridad){
                                $genero = $tallerporalumno->getAlumnoporcicloid()->getAlumnoid()->getSexo();
                                if($total < $tallerPrincipal->getCupo()){

                                    if($hermanos){
                                        if(in_array($alumnoporclavefamiliar->getClavefamiliarid()->getClave(), $clavesFamiliares)){
    
                                        }else{
                                            if(!empty($tallerPrincipal->getCupomaxmasculino()) && !empty($tallerPrincipal->getCupomaxmasculino())){
                                                if($genero == 'M'){
                                                    if($talleralumnosM < $tallerPrincipal->getCupomaxmasculino()){
                                                        $talleralumnos[] = $tallerporalumno;
                                                        $talleralumnosM++;
                                                        $set = true;
                                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                    }
                                                }else{
                                                    if($talleralumnosF < $tallerPrincipal->getCupomaxfemenino()){
                                                        $talleralumnos[] = $tallerporalumno;
                                                        $talleralumnosF++;
                                                        $set = true;
                                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                    }
                                                } 
                                            }else{
                                                if($porGenero){
                                                    if($genero == 'M'){
                                                        if($talleralumnosM < $cupoD){
                                                            $talleralumnos[] = $tallerporalumno;
                                                            $talleralumnosM++;
                                                            $set = true;
                                                            $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                        }
                                                    }else{
                                                        if($talleralumnosF < $cupoD){
                                                            $talleralumnos[] = $tallerporalumno;
                                                            $talleralumnosF++;
                                                            $set = true;
                                                            $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                        }
                                                    } 
                                                }else{
                                                    if($genero == 'M'){
                                                        $talleralumnos[] = $tallerporalumno;
                                                        $talleralumnosM++;
                                                        $set = true;
                                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                    }else{
                                                        $talleralumnos[] = $tallerporalumno;
                                                        $talleralumnosF++;
                                                        $set = true;
                                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                    } 
                                                }
                                            }
                                        }
                                    }else{
                                        if(!empty($tallerPrincipal->getCupomaxmasculino()) && !empty($tallerPrincipal->getCupomaxmasculino())){
                                            if($genero == 'M'){
                                                if($talleralumnosM < $tallerPrincipal->getCupomaxmasculino()){
                                                    $talleralumnos[] = $tallerporalumno;
                                                    $talleralumnosM++;
                                                    $set = true;
                                                    $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                }
                                            }else{
                                                if($talleralumnosF < $tallerPrincipal->getCupomaxfemenino()){
                                                    $talleralumnos[] = $tallerporalumno;
                                                    $talleralumnosF++;
                                                    $set = true;
                                                    $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                }
                                            } 
                                        }else{
                                            if($porGenero){
                                                if($genero == 'M'){
                                                    if($talleralumnosM < $cupoD){
                                                        $talleralumnos[] = $tallerporalumno;
                                                        $talleralumnosM++;
                                                        $set = true;
                                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                    }
                                                }else{
                                                    if($talleralumnosF < $cupoD){
                                                        $talleralumnos[] = $tallerporalumno;
                                                        $talleralumnosF++;
                                                        $set = true;
                                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                    }
                                                } 
                                            }else{
                                                if($genero == 'M'){
                                                    $talleralumnos[] = $tallerporalumno;
                                                    $talleralumnosM++;
                                                    $set = true;
                                                    $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                }else{
                                                    $talleralumnos[] = $tallerporalumno;
                                                    $talleralumnosF++;
                                                    $set = true;
                                                    $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                                } 
                                            }
                                        }
                                    }
                                }   
                            }
                        }
                    }
                }else{
                    $genero = $alumnoporciclo->getAlumnoid()->getSexo();
                    if($total < $tallerPrincipal->getCupo()){
                        if($hermanos){
                            if(in_array($alumnoporclavefamiliar->getClavefamiliarid()->getClave(), $clavesFamiliares)){

                            }else{
                                if(!empty($tallerPrincipal->getCupomaxmasculino()) && !empty($tallerPrincipal->getCupomaxmasculino())){
                                    if($genero == 'M'){
                                        if($talleralumnosM < $tallerPrincipal->getCupomaxmasculino()){
                                            $talleralumnos[] = $alumnoporciclo;
                                            $talleralumnosM++;
                                            $set = true;
                                            $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                        }
                                    }else{
                                        if($talleralumnosF < $tallerPrincipal->getCupomaxfemenino()){
                                            $talleralumnos[] = $alumnoporciclo;
                                            $talleralumnosF++;
                                            $set = true;
                                            $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                        }
                                    } 
                                }else{
                                    if($porGenero){
                                        if($genero == 'M'){
                                            if($talleralumnosM < $cupoD){
                                                $talleralumnos[] = $alumnoporciclo;
                                                $talleralumnosM++;
                                                $set = true;
                                                $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                            }
                                        }else{
                                            if($talleralumnosF < $cupoD){
                                                $talleralumnos[] = $alumnoporciclo;
                                                $talleralumnosF++;
                                                $set = true;
                                                $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                            }
                                        } 
                                    }else{
                                        if($genero == 'M'){
                                            $talleralumnos[] = $alumnoporciclo;
                                            $talleralumnosM++;
                                            $set = true;
                                            $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                        }else{
                                            $talleralumnos[] = $alumnoporciclo;
                                            $talleralumnosF++;
                                            $set = true;
                                            $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                        } 
                                    }
                                }
                            }
                        }else{
                            if(!empty($tallerPrincipal->getCupomaxmasculino()) && !empty($tallerPrincipal->getCupomaxmasculino())){
                                if($genero == 'M'){
                                    if($talleralumnosM < $tallerPrincipal->getCupomaxmasculino()){
                                        $talleralumnos[] = $alumnoporciclo;
                                        $talleralumnosM++;
                                        $set = true;
                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                    }
                                }else{
                                    if($talleralumnosF < $tallerPrincipal->getCupomaxfemenino()){
                                        $talleralumnos[] = $alumnoporciclo;
                                        $talleralumnosF++;
                                        $set = true;
                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                    }
                                } 
                            }else{
                                if($porGenero){
                                    if($genero == 'M'){
                                        if($talleralumnosM < $cupoD){
                                            $talleralumnos[] = $alumnoporciclo;
                                            $talleralumnosM++;
                                            $set = true;
                                            $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                        }
                                    }else{
                                        if($talleralumnosF < $cupoD){
                                            $talleralumnos[] = $alumnoporciclo;
                                            $talleralumnosF++;
                                            $set = true;
                                            $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                        }
                                    } 
                                }else{
                                    if($genero == 'M'){
                                        $talleralumnos[] = $alumnoporciclo;
                                        $talleralumnosM++;
                                        $set = true;
                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                    }else{
                                        $talleralumnos[] = $alumnoporciclo;
                                        $talleralumnosF++;
                                        $set = true;
                                        $clavesFamiliares[] = $alumnoporclavefamiliar->getClavefamiliarid()->getClave();
                                    } 
                                }
                            }
                        }
                    }   
                }
                if(!$set){
                    $talleresPoralumnos[] = $alumno;
                }
            }
        }
        return [$talleresPoralumnos, $talleralumnos, $talleralumnosM, $talleralumnosF, $clavesFamiliares];
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Controlescolar/TallerCurricular/Armado/AsignacionAutomatica", name="AsignacionAutomatica")
     */
    public function AsignacionAutomatica()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $tallerPrincipal = $dbm->getRepositorioById('CeTallercurricular','tallercurricularid', $data['tallercurricularid']);
            $talleresactuales = $dbm->getRepositoriosById('CeAlumnocicloportaller','tallercurricularid',$data['tallercurricularid']);
            $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
            $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 6);
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']);
            $actuales = count($talleresactuales);
            $talleralumnos = [];
            $talleralumnosM = 0;
            $porGenero = $data['genero'];
            $hermanos = $data['hermanos'];
            $promedio = $data['promedio'];
            $talleralumnosF = 0;
            $talleresPoralumnos = [];
            $clavesFamiliares = [];
            $count = 0;
            if(empty($data['alumnos'])){
                return new View('No hay alumnos para asignar', Response::HTTP_PARTIAL_CONTENT);
            }
            $prioridad = 1;
            foreach($talleresactuales as $act){
                if($act->getAlumnoporcicloid()->getAlumnoid()->getSexo() == 'M'){
                    $talleralumnosM++;
                }
                if($act->getAlumnoporcicloid()->getAlumnoid()->getSexo() == 'F'){
                    $talleralumnosF++;
                }
            }
            while(true){
                if($count == 0){
                    $alumnos = $data['alumnos'];
                }else{
                    $alumnos = $talleresPoralumnos;
                }
                $talleresPoralumnos = [];
                
                $respuesta = $this->ValidarCuposLD($dbm, $alumnos, $talleresPoralumnos, $tallerPrincipal, $talleralumnos, $talleralumnosM, $talleralumnosF, $prioridad, $actuales, $porGenero, $hermanos, $clavesFamiliares, $promedio);
                $talleresPoralumnos = $respuesta[0];
                $talleralumnos = $respuesta[1];
                $talleralumnosM = $respuesta[2];
                $talleralumnosF = $respuesta[3];
                $clavesFamiliares = $respuesta[4];
                if((count($talleralumnos) + $actuales) == $tallerPrincipal->getCupo()){
                    break;
                }else if(count($talleresPoralumnos) == 0){
                    break;
                }else if($prioridad > 20){
                    break;
                }
                $count++;
                $prioridad++;
            }
            foreach($talleralumnos as $alumno){
                $tallerporalumno = new CeAlumnocicloportaller();
                $tallerporalumno->setTallercurricularid($tallerPrincipal);
                if(is_object($alumno->getAlumnoporcicloid())){
                    $tallerporalumno->setAlumnoporcicloid($alumno->getAlumnoporcicloid());
                }else{
                    $tallerporalumno->setAlumnoporcicloid($alumno);
                }
                $tallerporalumno->setClasificadorparaescolarid($tallerPrincipal->getClasificadorparaescolaresid());
                $tallerporalumno->setVigente(1);
                $dbm->saveRepositorio($tallerporalumno);
            }
            if(count($talleralumnos)>0){
                $bitacora =  new CeTallerbitacora();
                $bitacora->setFecha(new \Datetime());
                if(is_object($talleralumnos[0]->getAlumnoporcicloid())){
                    $bitacora->setAlumnoporcicloid($talleralumnos[0]->getAlumnoporcicloid());
                }else{
                    $bitacora->setAlumnoporcicloid($talleralumnos[0]);
                }
                $bitacora->setUsuarioid($usuario);
                $bitacora->setTallerid($tallerPrincipal->getTallercurricularid());
                $bitacora->setTipotallerid($tipotaller);
                $bitacora->setTalleraccionid($accion);
                $dbm->saveRepositorio($bitacora);
            }
            $this->GenerarNumeroLista($data['tallercurricularid']);
            $dbm->getConnection()->commit();
            return new View('Asignación automática realizada correctamente', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
		
		
	public static function fnAlumnoCalificacion($a,$b){
		$aprom=$a[1];
		$bprom=$b[1];
		return $aprom<=>$bprom;
	}
  public function ValidarCuposLD($dbm, $alumnos, $talleresPoralumnos, $tallerPrincipal, $talleralumnos, $talleralumnosM, $talleralumnosF, $prioridad, $actuales, $porGenero, $hermanos, $clavesFamiliares, $promedio=false){
		$cupoD=(int) ($tallerPrincipal->getCupo() / 2);
		if($promedio){
			$alumnosRaw=[];
			foreach($alumnos AS $ikalumnoporciclo){
				$ipromedio=0;
				$ipromedios=\AppBundle\Controller\Controlescolar\CapturaCalificacionReporteController::getPromedioFinalByAlumnociclo($dbm, $ikalumnoporciclo);
				if($ipromedios && !empty($ipromedios)){
					$ipromedio=(double)$ipromedios[0];
				}
				$alumnosRaw[]=[$ikalumnoporciclo, $ipromedio];
			}
			usort($alumnosRaw, "AppBundle\Controller\Controlescolar\ArmadoTallerCurricularController::fnAlumnoCalificacion");
			$alumnosOrd=[];
			$nAlumno=count($alumnosRaw);
			$ntAlumno=(int) ceil($alumnosRaw/2);
			for($i=0,$j=$nAlumno-1; $i<$ntAlumno; $i++,$j--){
				$ialumno=$alumnosRaw[$i];
				$jalumno=$alumnosRaw[$j];
				$alumnosOrd[]=$ialumno;
				if($jalumno!=$ialumno){
					$alumnosOrd[]=$jalumno;
				}
			}
			$alumnos=$alumnosOrd;
			unset($alumnosOrd, $alumnosRaw);
		}
		foreach($alumnos as $alumno){
			$total=count($talleralumnos) + $actuales;
			$alumnoporciclo=$dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno);
			$alumnoporclavefamiliar=$dbm->getRepositorioById('CeAlumnoporclavefamiliar', 'alumnoid', $alumnoporciclo->getAlumnoid()->getAlumnoid());
			$gradoopcion=$dbm->getRepositorioById('CeTalleropcionregistro', 'gradoid', $alumnoporciclo->getGradoid()->getGradoid());
			$talleresPoralumno=$dbm->getRepositoriosById('CeAlumnociclopreregistroportaller', 'alumnoporcicloid', $alumno);
			$iClaveFamiliar=$alumnoporclavefamiliar->getClavefamiliarid()->getClave();
			if($tallerPrincipal->getClasificadorparaescolaresid()->getClasificadorparaescolaresid()== 3){
				$talleresPoralumno=$dbm->getRepositoriosById('CeAlumnociclopreregistroportaller', 'alumnoporcicloid', $alumno);
				if(!$talleresPoralumno){
					$preregistro=new CeAlumnociclopreregistroportaller();
					$preregistro->setFechapreregistro(new \DateTime());
					$preregistro->setPrioridad(1);
					$preregistro->setAlumnoporcicloid($alumnoporciclo);
					$preregistro->setClasificadorparaescolaresid(null);
					$preregistro->setTallercurricularid($tallerPrincipal);
					$dbm->saveRepositorio($preregistro);
					$talleresPoralumno=$dbm->getRepositoriosById('CeAlumnociclopreregistroportaller', 'alumnoporcicloid', $alumno);
				}
			}
			if($prioridad<= $gradoopcion->getNotalleres()){
				$set=false;
				if(count($talleresPoralumno) > 0){
					foreach($talleresPoralumno AS $tallerporalumno){
						if($tallerporalumno->getTallercurricularid()->getTallercurricularid()== $tallerPrincipal->getTallercurricularid()){
							if($tallerporalumno->getPrioridad()== $prioridad){
								$genero=$tallerporalumno->getAlumnoporcicloid()->getAlumnoid()->getSexo();
								if($total < $tallerPrincipal->getCupo()){
									if($hermanos && in_array($iClaveFamiliar, $clavesFamiliares)){
										continue;
									}
									if(!empty($tallerPrincipal->getCupomaxmasculino()) && !empty($tallerPrincipal->getCupomaxmasculino())){
										if($genero== 'M'){
											if($talleralumnosM < $tallerPrincipal->getCupomaxmasculino()){
												$talleralumnos[]=$tallerporalumno;
												$talleralumnosM++;
												$set=true;
												$clavesFamiliares[]=$iClaveFamiliar;
											}
										}else{
											if($talleralumnosF < $tallerPrincipal->getCupomaxfemenino()){
												$talleralumnos[]=$tallerporalumno;
												$talleralumnosF++;
												$set=true;
												$clavesFamiliares[]=$iClaveFamiliar;
											}
										}
									}else{
										if($porGenero){
											if($genero== 'M'){
												if($talleralumnosM < $cupoD){
													$talleralumnos[]=$tallerporalumno;
													$talleralumnosM++;
													$set=true;
													$clavesFamiliares[]=$iClaveFamiliar;
												}
											}else{
												if($talleralumnosF < $cupoD){
													$talleralumnos[]=$tallerporalumno;
													$talleralumnosF++;
													$set=true;
													$clavesFamiliares[]=$iClaveFamiliar;
												}
											}
										}else{
											if($genero== 'M'){
												$talleralumnos[]=$tallerporalumno;
												$talleralumnosM++;
												$set=true;
												$clavesFamiliares[]=$iClaveFamiliar;
											}else{
												$talleralumnos[]=$tallerporalumno;
												$talleralumnosF++;
												$set=true;
												$clavesFamiliares[]=$iClaveFamiliar;
											}
										}
									}
								}
							}
						}
					}
				}else{
					$genero=$alumnoporciclo->getAlumnoid()->getSexo();
					if($total < $tallerPrincipal->getCupo()){
						if($hermanos && in_array($iClaveFamiliar, $clavesFamiliares)){
							continue;
						}
						if(!empty($tallerPrincipal->getCupomaxmasculino()) && !empty($tallerPrincipal->getCupomaxmasculino())){
							if($genero== 'M'){
								if($talleralumnosM < $tallerPrincipal->getCupomaxmasculino()){
									$talleralumnos[]=$alumnoporciclo;
									$talleralumnosM++;
									$set=true;
									$clavesFamiliares[]=$iClaveFamiliar;
								}
							}else{
								if($talleralumnosF < $tallerPrincipal->getCupomaxfemenino()){
									$talleralumnos[]=$alumnoporciclo;
									$talleralumnosF++;
									$set=true;
									$clavesFamiliares[]=$iClaveFamiliar;
								}
							}
						}else{
							if($porGenero){
								if($genero== 'M'){
									if($talleralumnosM < $cupoD){
										$talleralumnos[]=$alumnoporciclo;
										$talleralumnosM++;
										$set=true;
										$clavesFamiliares[]=$iClaveFamiliar;
									}
								}else{
									if($talleralumnosF < $cupoD){
										$talleralumnos[]=$alumnoporciclo;
										$talleralumnosF++;
										$set=true;
										$clavesFamiliares[]=$iClaveFamiliar;
									}
								}
							}else{
								if($genero== 'M'){
									$talleralumnos[]=$alumnoporciclo;
									$talleralumnosM++;
									$set=true;
									$clavesFamiliares[]=$iClaveFamiliar;
								}else{
									$talleralumnos[]=$alumnoporciclo;
									$talleralumnosF++;
									$set=true;
									$clavesFamiliares[]=$iClaveFamiliar;
								}
							}
						}
					}
				}
				if(!$set){
					$talleresPoralumnos[]=$alumno;
				}
			}
		}
		return [$talleresPoralumnos, $talleralumnos, $talleralumnosM, $talleralumnosF, $clavesFamiliares];
	}
	/**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Controlescolar/TallerCurricular/Armado/CambiarAlumno", name="CambiarAlumno")
     */
    public function CambiarAlumno()
    {
        try {
            $alumno = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno['alumnoporcicloid']);
            $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $alumno['usuarioid']);
            $taller = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $alumno['tallercurricularid']);
            $clasificador = $dbm->getRepositorioById('CeClasificadorparaescolares', 'clasificadorparaescolaresid', $alumno['clasificadorparaescolaresid']);
            $alumnocicloportaller = $dbm->getRepositorioById('CeAlumnocicloportaller','alumnocicloportallerid', $alumno['alumnocicloportallerid']);
            $tallerold = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid',$alumnocicloportaller->getTallercurricularid()->getTallercurricularid());
            $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
            $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 8);
            $bitacora =  new CeTallerbitacora();
            $bitacora->setAlumnoporcicloid($alumnoporciclo);
            $bitacora->setFecha(new \Datetime());
            $bitacora->setUsuarioid($usuario);
            $bitacora->setTallerid($alumnocicloportaller->getTallercurricularid()->getTallercurricularid());
            $bitacora->setTipotallerid($tipotaller);
            $bitacora->setTalleraccionid($accion);
            $bitacora->setMotivo($alumno['motivo']);
            $dbm->saveRepositorio($bitacora);
            $alumnocicloportaller->setTallercurricularid($taller);
            $alumnocicloportaller->setClasificadorparaescolarid($clasificador);
            $alumnocicloportaller->setVigente(1);
            $dbm->saveRepositorio($alumnocicloportaller);
            $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
            $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 5);
            $bitacora =  new CeTallerbitacora();
            $bitacora->setAlumnoporcicloid($alumnoporciclo);
            $bitacora->setFecha(new \Datetime());
            $bitacora->setUsuarioid($usuario);
            $bitacora->setTallerid($alumno['tallercurricularid']);
            $bitacora->setTipotallerid($tipotaller);
            $bitacora->setTalleraccionid($accion);
            $bitacora->setMotivo($alumno['motivo']);
            $dbm->saveRepositorio($bitacora);
            $this->GenerarNumeroLista($tallerold->getTallercurricularid());
            $this->GenerarNumeroLista($taller->getTallercurricularid());
            $dbm->getConnection()->commit();
            return new View('Se guardaron los registros correctamente', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo iniciales
     * @Rest\Post("/api/Controlescolar/TallerCurricular/Armado/AsignacionManual", name="AsignacionManual")
     */
    public function AsignacionManual()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $tallercurricularid = null;
            foreach($data as $alumno){
                $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno['alumnoporcicloid']);
                $tallercurricularid = $alumno['tallercurricularid'];
                $usuario = $dbm->getRepositorioById('Usuario', 'usuarioid', $alumno['usuarioid']);
                $tipotaller = $dbm->getRepositorioById('CeTipotaller', 'tipotallerid', 1);
                $accion = $dbm->getRepositorioById('CeTalleraccion', 'talleraccionid', 5);
                $taller = $dbm->getRepositorioById('CeTallercurricular', 'tallercurricularid', $alumno['tallercurricularid']);
                $clasificador = $dbm->getRepositorioById('CeClasificadorparaescolares', 'clasificadorparaescolaresid', $alumno['clasificadorparaescolaresid']);
                $altaller = $dbm->getOneByParametersRepositorio('CeAlumnocicloportaller', [
                    'alumnoporcicloid' => $alumno['alumnoporcicloid'],
                    'tallercurricularid' => $alumno['tallercurricularid']
                ]);
                if(!$altaller){
                    $alumnocicloportaller = new CeAlumnocicloportaller();
                    $alumnocicloportaller->setAlumnoporcicloid($alumnoporciclo);
                    $alumnocicloportaller->setTallercurricularid($taller);
                    $alumnocicloportaller->setClasificadorparaescolarid($clasificador);
                    $alumnocicloportaller->setVigente(1);
                    $dbm->saveRepositorio($alumnocicloportaller);
                    $bitacora =  new CeTallerbitacora();
                    $bitacora->setAlumnoporcicloid($alumnoporciclo);
                    $bitacora->setFecha(new \Datetime());
                    $bitacora->setUsuarioid($usuario);
                    $bitacora->setTallerid($alumno['tallercurricularid']);
                    $bitacora->setTipotallerid($tipotaller);
                    $bitacora->setTalleraccionid($accion);
                    $dbm->saveRepositorio($bitacora);
                }
            }
            if($tallercurricularid){
                $this->GenerarNumeroLista($tallercurricularid);
            }
            $dbm->getConnection()->commit();
            return new View('Se guardaron los registros correctamente', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * @Rest\Get("/api/Controlescolar/TallerCurricular/listaAlumnos/{tallerid}", name="getListaAlumnosTaller")
    */
    public function getListaAlumnosTaller($tallerid) {
        $env=[1=>"Lux/",2=>"Ciencias/"];
        try{
            $root=str_replace('app', '', $this->get('kernel')->getRootDir());
            $envPath=$env[ENTORNO];
            $mPath="src/AppBundle/Dominio/Reporteador/Plantillas/";
            $bPath="{$mPath}{$envPath}";
            $path=$root.$bPath;
            $pathLogo="{$path}logo.png";
            $pathRep="{$path}ListaAlumnosTaller.jrxml";
            $pathOutput="{$mPath}ListaAlumnosTaller";
            $pathFile="../{$pathOutput}.pdf";
            $jpReport=$this->getCMDPath($pathRep);
            $jpOutput=$this->getCMDPath($root.$pathOutput);
            $jpLogo=$this->getCMDPath($pathLogo);
            /*
            echo $pathLogo."\n";
            echo $jpReport."\n";
            echo $jpOutput."\n";
            //*/
            $params=[
                "tallerid"=>$tallerid,
                "logo"=>$pathLogo
            ];
            $jasper=new JasperPHP($this->container);
            $response=$jasper->process(
                $jpReport,
                $jpOutput,
                array("pdf"),
                $params,
                true
            )->execute();/*->output();
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
    * @Rest\Get("/api/Controlescolar/TallerCurricular/HorarioRotacion/", name="getHorarioRotacion")
    */
    public function getHorarioRotacion() {
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
            $pathRep="{$path}RotaciongrupoHorario.jrxml";
            $pathOutput="{$mPath}RotaciongrupoHorario";
            $pathFile="../{$pathOutput}.pdf";
            $jpReport=$this->getCMDPath($pathRep);
            $jpOutput=$this->getCMDPath($root.$pathOutput);
            $jpLogo=$this->getCMDPath($pathLogo);
            /*
            echo $pathLogo."\n";
            echo $jpReport."\n";
            echo $jpOutput."\n";
            //*/
            $params=[
                "cicloid"=>$filtros['cicloid'],
                "gradoid"=>$filtros['gradoid'],
                "materiaporplanestudioid"=>$filtros['materiaid'],
                "logo"=>$pathLogo
            ];
            $jasper=new JasperPHP($this->container);
            $response=$jasper->process(
                $jpReport,
                $jpOutput,
                array("pdf"),
                $params,
                true
            )->execute();/*->output();
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
    private function getCMDPath($x){
        return "\"$x\"";
    }

        /**
     * 
     * @Rest\Post("/api/Controlescolar/TallerCurricular/Armado/seteoNumerolista", name="seteoNumerolista")
     */
    public function seteoNumerolista()
    {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $alumnoporciclo = $dbm->getRepositorioById('CeAlumnocicloportaller', 'alumnocicloportallerid', $data['alumnocicloportallerid']);
            $alumnoporciclo->setNumerolista($data['nolista']);
            $dbm->saveRepositorio($alumnoporciclo);
            $dbm->getConnection()->commit();
            return new View('Se ha guardado el registro', Response::HTTP_OK);
        } catch(Exception $e){ 
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST); 
        }
    }

         /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/TallerCurricular/Armado/RecalcularNoLista", name="RecalcularNoLista")
     */
    public function RecalcularNoLista()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumnos = $dbm->getAlumnosPorTallerCurricular($filtros);
            $nolista = 1;

            if(!$alumnos['asignados']) {
                return new View("No se encontraron alumnos asignados a este taller", Response::HTTP_PARTIAL_CONTENT);
            }

            foreach($alumnos['asignados'] as $a) {
                $alu = $dbm->getRepositorioById('CeAlumnocicloportaller', 'alumnocicloportallerid', $a['alumnocicloportallerid']);
                $alu->setNumerolista($nolista++);
                $dbm->saveRepositorio($alu);
            }

            
            return new View("Se han guardado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
