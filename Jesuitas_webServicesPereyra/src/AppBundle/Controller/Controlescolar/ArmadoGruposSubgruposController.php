<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Rest\Api;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;
use AppBundle\Entity\CeAlumnocicloporgrupo;
use AppBundle\Entity\CeAlumnoporciclo;
use AppBundle\Entity\CeBitacoraarmadogrupo;

/**
 * @author Abraham Huerta
 */
class ArmadoGruposSubgruposController extends FOSRestController{

    /**
     * 
     * @Rest\Get("/api/Controlescolar/Armadogrupos", name="ArmadoGruposGet")
     */
    public function ArmadoGruposGet(){
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            return new View([
                'ciclo' => $ciclo,
                'nivel' => $nivel,
                'grado' => $grado,
                'semestre' => $semestre
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Controlescolar/Armadosubgrupos", name="ArmadoSubGruposGet")
     */
    public function ArmadoSubGruposGet(){
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $planestudio = $dbm->getRepositorios('CePlanestudios');
            return new View([
                'ciclo' => $ciclo,
                'nivel' => $nivel,
                'grado' => $grado,
                'semestre' => $semestre,
                'planestudio' => $planestudio
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    /**
     * 
     * @Rest\Get("/api/Controlescolar/Armadosubgrupos/Materias", name="Armadosubgruposmaterias")
     */
    public function Armadosubgruposmaterias(){
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $materiaporplanestudio = $dbm->getByParametersRepositorios('CeMateriaporplanestudios', ['planestudioid' => $_REQUEST['planestudioid'], 'configurarsubgrupos' => 1]);
            $materias = [];
            foreach($materiaporplanestudio as $m){
                $materias[] = [
                    'nombre' => $m->getMateriaId()->getNombre(),
                    'materiaid' => $m->getMateriaporplanestudioid()
                ];
            }
            return new View(['materias' => $materias], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
    
    /**
     * 
     * @Rest\Get("/api/Controlescolar/Armadogrupos/CambiarBloqueo/{id}", name="CambiarBloqueo")
     */
    public function CambiarBloqueo($id){
        try {
            $data = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $grupo = $dbm->getRepositorioById('CeGrupo', 'grupoid', $id);
            if($grupo){
                $grupo->setBloqueolista(($data['bloqueolista'] == 'false' ? false : true));
                $dbm->saveRepositorio($grupo);
            }else{
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View('ok', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Controlescolar/Armadogrupos/Consulta", name="ArmadoGruposConsulta")
     */
    public function ArmadoGruposConsulta(){
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $data = $_REQUEST;
            $conn = $this->get("db_manager")->getConnection();

            if($data){

                $gruposEntity = $dbm->getByParametersRepositorios('CeGrupo', ['cicloid' => $data['cicloid'], 'gradoid' => $data['gradoid'], 'tipogrupoid' => 1]);
                $grupos = [];

                if(count($gruposEntity) == 0){
                    return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
                }

                foreach($gruposEntity as $grupo){
                    $g = [
                        'nombre' => $grupo->getNombre(),
                        'grupoid' => $grupo->getGrupoid(),
                        'tipogrupoid' => $grupo->getTipogrupoid()->getTipogrupoid(),
                        'tipogrupo' => $grupo->getTipogrupoid()->getNombre(),
                        'cupo' => $grupo->getCupo(),
                        'bloqueolista' => $grupo->getBloqueolista(),
                        'alumnos' => []
                    ];
                    $grupos[] = $g;
                }
                

                $alumnos = $dbm->getAlumnosCicloPorGrupo($data['cicloid'],$data['gradoid'], null, true);
                $alumnosPorAsignar = [];
                $al = [];
                $bitacora = $dbm->getByParametersRepositorios('CeBitacoraarmadogrupo', ['cicloid' => $data['cicloid'], 'gradoid' => $data['gradoid'], 'alumnoid' => null]);

                $url = $dbm->getRepositorioById('Parametros', 'nombre', 'URLServicios');
                foreach($alumnos as $alumno){
                    if(empty($alumno['promedio'])){
                        $alumno['promedio'] = 0;
                    }
                    $alumno['foto'] = $url->getValor() . '/api/Alumno/foto?alumnoid=' . $alumno['alumnoid'];
                    // $imagen = $dbm->getRepositorioById('CeAlumnociclofoto', 'alumnoporcicloid', $alumno['alumnoporcicloid']);
                    
                    // if($imagen){
                    //     $alumno['foto'] = stream_get_contents($imagen->getFoto());
                    // }
                    
                    
                    $gr = $dbm->getByParametersRepositorios('CeAlumnocicloporgrupo', ['alumnoporcicloid' => $alumno['alumnoporcicloid']]);
                    $alumno['subgrupos'] = 0;
                    if(empty($alumno['adeudo'])){
                        $alumno['adeudo'] = 'Sin adeudo';
                    }
                    if(count($gr) > 0){
                        foreach($gr as $gg){
                            if($gg->getGrupoid()->getTipogrupoid()->getTipogrupoid() !== 1){
                                $alumno['subgrupos'] = $alumno['subgrupos'] + 1;
                            }
                        }
                    }
                    $al[] = $alumno;
                    if(empty($alumno['grupoid'])){
                        if(
                            ($alumno['estatusalumnoporcicloid'] == 1 || $alumno['estatusalumnoporcicloid'] == 2) &&
                            ($alumno['intencionreinscribirseid'] == 1 || $alumno['intencionreinscribirseid'] == 3)
                            ){
                            $alumnosPorAsignar[] = $alumno;
                        }
                    }else{
                        foreach($grupos as $key => $grupo){
                            if($grupo['grupoid'] == $alumno['grupoid']){
                                $b = $dbm->getByParametersRepositorios('CeBitacoraarmadogrupo',  ['grupoorigenid' => $alumno['grupoid'], 'alumnoid' => $alumno['alumnoid'] ]);
                                if($b){
                                    $bitacora[] = $b[0];
                                }else{
                                    $b = $dbm->getByParametersRepositorios('CeBitacoraarmadogrupo',  ['grupodestinoid' => $alumno['grupoid'], 'alumnoid' => $alumno['alumnoid'] ]);

                                    if($b){
                                        $bitacora[] = $b[0]; 
                                    }
                                }
                                if($alumno['estatusalumnoporcicloid'] == 1 || $alumno['estatusalumnoporcicloid'] == 2){
                                    $grupo['alumnos'][] = $alumno;
                                }
                            }
                            $grupos[$key] = $grupo;
                        }
                    }
                }

                $result = [
                    'grupos' => $grupos,
                    'bitacora' => $bitacora,
                    'alumnosporasignar' => $alumnosPorAsignar,
                    'alumnos' => $al
                ];

                return new View($result, Response::HTTP_OK);
            }else{
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Post("/api/Controlescolar/Armadosubgrupos/Consulta", name="ArmadoGruposSubConsulta")
     */
    public function ArmadoGruposSubConsulta(){
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $conn = $this->get("db_manager")->getConnection();

            if($data){

                $gruposEntity = $dbm->getSubgrupos($data['subgrupos']);
                $grupos = [];

                if(count($gruposEntity) == 0){
                    return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
                }

                foreach($gruposEntity as $grupo){
                    $g = [
                        'nombre' => $grupo->getNombre(),
                        'grupoid' => $grupo->getGrupoid(),
                        'tipogrupoid' => $grupo->getTipogrupoid()->getTipogrupoid(),
                        'tipogrupo' => $grupo->getTipogrupoid()->getNombre(),
                        'cupo' => $grupo->getCupo(),
                        'alumnos' => []
                    ];
                    $grupos[] = $g;
                }

                $alumnos = $dbm->getAlumnosCicloPorGrupoOrigen($data['gruposorigen'], $data['subgrupos'], $data['cicloid'], true);
                $alumnosPorAsignar = [];
                $alumnosPorAsignarFinal = [];
                $al = [];
                $used = [];
                $bitacora = [];

                foreach($alumnos as $alumno){
                    $alumno['subgrupos'] = 0;
                    if(empty($alumno['promedio'])){
                        $alumno['promedio'] = 0;
                    }
                    if(empty($alumno['adeudo'])){
                        $alumno['adeudo'] = 0;
                    }
                    $stmt = $conn->prepare('SELECT foto FROM ce_alumnofotocicloactualvista WHERE alumnoid = :alumnoid');
                    $stmt->execute(array('alumnoid' => $alumno['alumnoid']));
                    $alumno['foto'] = $stmt->fetch()['foto'];
                    // $imagen = $dbm->getRepositorioById('CeAlumnociclofoto', 'alumnoporcicloid', $alumno['alumnoporcicloid']);
                    // if($imagen){
                    //     $alumno['foto'] = stream_get_contents($imagen->getFoto());
                    // }
                    if(empty($alumno['grupoid'])){
                        $alumnosPorAsignar[] = $alumno;
                    }else{
                        $g = $dbm->getRepositorioById('CeGrupo', 'grupoid', $alumno['grupoid']);
                        if($g->getTipogrupoid()->getTipogrupoid() !== 1){
                            foreach($grupos as $key => $grupo){
                                if($grupo['grupoid'] == $alumno['grupoid']){
                                    $b = $dbm->getByParametersRepositorios('CeBitacoraarmadogrupo',  ['grupoorigenid' => $alumno['grupoid'], 'alumnoid' => $alumno['alumnoid'] ]);
                                    if($b){
                                        $bitacora[] = $b[0];
                                    }else{
                                        $b = $dbm->getByParametersRepositorios('CeBitacoraarmadogrupo',  ['grupodestinoid' => $alumno['grupoid'], 'alumnoid' => $alumno['alumnoid'] ]);

                                        if($b){
                                            $bitacora[] = $b[0]; 
                                        }
                                    }
                                    $grupo['alumnos'][] = $alumno;
                                    $used[] = $alumno;
                                    $al[] = $alumno;
                                }
                                $grupos[$key] = $grupo;
                            }
                        }else{
                            $alumnosPorAsignar[] = $alumno;
                        }
                    }
                }

                foreach($alumnosPorAsignar as $alu){
                    $find = false;
                    foreach($used as $a){
                        if($a['alumnoid'] == $alu['alumnoid']){
                            $find = true;
                        }
                    }
                    if(!$find){
                        $al[] = $alu;
                        $alumnosPorAsignarFinal[] = $alu;
                    }
                }

                $result = [
                    'grupos' => $grupos,
                    'bitacora' => $bitacora,
                    'alumnosporasignar' => $alumnosPorAsignarFinal,
                    'alumnos' => $al
                ];
                
                return new View($result, Response::HTTP_OK);
            }else{
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * 
     * @Rest\Post("/api/Controlescolar/Armadogrupos/Guardar", name="ArmadoGruposGuardar")
     */
    public function ArmadoGruposGuardar(){
        try {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']);
            $grado = $dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']);
            $auto = false;
            $tipomovimiento = $dbm->getRepositorioById('CeTipomovimientobitacora', 'tipomovimientobitacoraid', $data['tipomovimientobitacoraid']);
            if($data['tipomovimientobitacoraid'] == 1){
                $bitacora = new CeBitacoraarmadogrupo();
                $bitacora->setAlumno('Todos');
                $bitacora->setFecha(new \DateTime());
                $bitacora->setUsuario($data['usuario']);
                $bitacora->setTipobitacoramovimientoid($tipomovimiento);
                $bitacora->setCicloid($ciclo);
                $bitacora->setGradoid($grado);
                $dbm->saveRepositorio($bitacora);
            }
            foreach($data['alumnos'] as $elemento){
                $alumn = $dbm->getRepositorioById('CeAlumno','alumnoid', $elemento['alumnoid']);
                if(!empty($elemento['alumnoid'])){
                    if($elemento['eliminado'] == true){
                        $alumnocicloporgrupo = $dbm->getRepositorioById('CeAlumnocicloporgrupo','alumnocicloporgrupo', $elemento['alumnocicloporgrupo']);
                        if($alumnocicloporgrupo){
                            $tipomovimiento = $dbm->getRepositorioById('CeTipomovimientobitacora', 'tipomovimientobitacoraid', 3);
                            
                            $bitacora = new CeBitacoraarmadogrupo();
                            $bitacora->setAlumno($elemento['alumno']);
                            $bitacora->setFecha(new \DateTime());
                            $bitacora->setGrupoanterior($alumnocicloporgrupo->getGrupoid()->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                            $bitacora->setGruponuevo('Ninguno');
                            $bitacora->setUsuario($data['usuario']);
                            $bitacora->setTipobitacoramovimientoid($tipomovimiento);
                            $bitacora->setCicloid($ciclo);
                            $bitacora->setGradoid($grado);
                            $bitacora->setGrupoorigenid($alumnocicloporgrupo->getGrupoid());
                            $bitacora->setAlumnoid($alumn);
                            $dbm->saveRepositorio($bitacora);
                            $dbm->removeRepositorio($alumnocicloporgrupo);
                        }
                    }else{
                        $tipomovimiento = $dbm->getRepositorioById('CeTipomovimientobitacora', 'tipomovimientobitacoraid', $data['tipomovimientobitacoraid']);
                        if(empty($elemento['alumnocicloporgrupo'])){
                            $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $elemento['alumnoporcicloid']);
                            $grupo = $dbm->getRepositorioById('CeGrupo','grupoid', $elemento['grupoid']);
                            $alumnocicloporgrupo = new CeAlumnocicloporgrupo();
                            $alumnocicloporgrupo->setAlumnoporcicloid($alumnoporciclo);
                            $alumnocicloporgrupo->setGrupoid($grupo);
                            $alumnocicloporgrupo->setNumerolista($elemento['numerolista']);
                            $bitacora = new CeBitacoraarmadogrupo();
                            $bitacora->setAlumno($elemento['alumno']);
                            $bitacora->setFecha(new \DateTime());
                            $bitacora->setGrupoanterior('Ninguno');
                            $bitacora->setGruponuevo($grupo->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                            $bitacora->setGrupodestinoid($grupo);
                            $bitacora->setAlumnoid($alumn);
                            $bitacora->setUsuario($data['usuario']);
                            $bitacora->setTipobitacoramovimientoid($tipomovimiento);
                            $bitacora->setCicloid($ciclo);
                            $bitacora->setGradoid($grado);
                            $dbm->saveRepositorio($bitacora);
                        
                            $dbm->saveRepositorio($alumnocicloporgrupo);
                        }else{
                            $grupo = $dbm->getRepositorioById('CeGrupo','grupoid', $elemento['grupoid']);
                            $alumnocicloporgrupo = $dbm->getRepositorioById('CeAlumnocicloporgrupo','alumnocicloporgrupo', $elemento['alumnocicloporgrupo']);
                            if($data['tiposalva'] == 2) {
                                $alumnocicloporgrupo->setNumerolista($elemento['numerolista']);
                                $dbm->saveRepositorio($alumnocicloporgrupo); 
                            }

                            if($data['tiposalva'] == 1){
                                if($alumnocicloporgrupo->getGrupoid()->getGrupoid() !== $grupo->getGrupoid()){
                                    if($data['tipomovimientobitacoraid'] == 1){
                                    }else{
                                        $bitacora = new CeBitacoraarmadogrupo();
                                        $bitacora->setAlumno($elemento['alumno']);
                                        $bitacora->setFecha(new \DateTime());
                                        $bitacora->setGrupoanterior($alumnocicloporgrupo->getGrupoid()->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                                        $bitacora->setGruponuevo($grupo->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                                        $bitacora->setGrupodestinoid($grupo);
                                        $bitacora->setGrupoorigenid($alumnocicloporgrupo->getGrupoid());
                                        $bitacora->setAlumnoid($alumn);
                                        $bitacora->setUsuario($data['usuario']);
                                        $bitacora->setTipobitacoramovimientoid($tipomovimiento);
                                        $bitacora->setCicloid($ciclo);
                                        $bitacora->setGradoid($grado);
                                        $dbm->saveRepositorio($bitacora);
                                    }
                                    $alumnocicloporgrupo->setGrupoid($grupo);
                                    $alumnocicloporgrupo->setNumerolista($elemento['numerolista']);
                                    $dbm->saveRepositorio($alumnocicloporgrupo); 
                                }else{
                                    $alumnocicloporgrupo->setNumerolista($elemento['numerolista']);
                                    $dbm->saveRepositorio($alumnocicloporgrupo);
                                }
                            }else{
                                if($alumnocicloporgrupo->getGrupoid()->getTipogrupoid()->getTipogrupoid() == 1){
                                    $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $elemento['alumnoporcicloid']);
                                    $grupo = $dbm->getRepositorioById('CeGrupo','grupoid', $elemento['grupoid']);
                                    $alumnocicloporgrupo = new CeAlumnocicloporgrupo();
                                    $alumnocicloporgrupo->setAlumnoporcicloid($alumnoporciclo);
                                    $alumnocicloporgrupo->setGrupoid($grupo);
                                    $alumnocicloporgrupo->setNumerolista($elemento['numerolista']);
                                    if($data['tipomovimientobitacoraid'] == 1){
                                    }else{
                                        $bitacora = new CeBitacoraarmadogrupo();
                                        $bitacora->setAlumno($elemento['alumno']);
                                        $bitacora->setFecha(new \DateTime());
                                        $bitacora->setGrupoanterior('Ninguno');
                                        $bitacora->setGruponuevo($grupo->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                                        $bitacora->setGrupodestinoid($grupo);
                                        $bitacora->setAlumnoid($alumn);
                                        $bitacora->setUsuario($data['usuario']);
                                        $bitacora->setTipobitacoramovimientoid($tipomovimiento);
                                        $bitacora->setCicloid($ciclo);
                                        $bitacora->setGradoid($grado);
                                        $dbm->saveRepositorio($bitacora);
                                    }
                                
                                    $dbm->saveRepositorio($alumnocicloporgrupo);
                                }else{
                                    if($alumnocicloporgrupo->getGrupoid()->getGrupoid() !== $grupo->getGrupoid()){
                                        if($data['tipomovimientobitacoraid'] == 1){
                                        }else{
                                            $bitacora = new CeBitacoraarmadogrupo();
                                            $bitacora->setAlumno($elemento['alumno']);
                                            $bitacora->setFecha(new \DateTime());
                                            $bitacora->setGrupoanterior($alumnocicloporgrupo->getGrupoid()->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                                            $bitacora->setGruponuevo($grupo->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                                            $bitacora->setGrupodestinoid($grupo);
                                            $bitacora->setGrupoorigenid($alumnocicloporgrupo->getGrupoid());
                                            $bitacora->setAlumnoid($alumn);
                                            $bitacora->setUsuario($data['usuario']);
                                            $bitacora->setTipobitacoramovimientoid($tipomovimiento);
                                            $bitacora->setCicloid($ciclo);
                                            $bitacora->setGradoid($grado);
                                            $dbm->saveRepositorio($bitacora);
                                        }
                                        $alumnocicloporgrupo->setGrupoid($grupo);
                                        $alumnocicloporgrupo->setNumerolista($elemento['numerolista']);
                                        $dbm->saveRepositorio($alumnocicloporgrupo);
                                        
                                    }
                                }
                            }
                            
                            
                        }
                    }
                    if(!empty($elemento['cambiolista'])){
                        $tipomovimiento = $dbm->getRepositorioById('CeTipomovimientobitacora', 'tipomovimientobitacoraid', 4);
                        $bitacora = new CeBitacoraarmadogrupo();
                        $bitacora->setAlumno($elemento['alumno']);
                        $bitacora->setFecha(new \DateTime());
                        $bitacora->setGrupoanterior($alumnocicloporgrupo->getGrupoid()->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                        $bitacora->setGruponuevo($grupo->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                        $bitacora->setGrupodestinoid($grupo);
                        $bitacora->setGrupoorigenid($alumnocicloporgrupo->getGrupoid());
                        $bitacora->setAlumnoid($alumn);
                        $bitacora->setUsuario($data['usuario']);
                        $bitacora->setTipobitacoramovimientoid($tipomovimiento);
                        $bitacora->setCicloid($ciclo);
                        $bitacora->setGradoid($grado);
                        $dbm->saveRepositorio($bitacora);
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Post("/api/Controlescolar/Armadogrupos/Copiar", name="ArmadoGruposCopiar")
     */
    public function ArmadoGruposCopiar(){
        try {
            $data = json_decode(file_get_contents('php://input'), TRUE);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $data['ciclodestinoid']);
            $grado = $dbm->getRepositorioById('Grado', 'gradoid', $data['gradodestinoid']);
            $tipomovimiento = $dbm->getRepositorioById('CeTipomovimientobitacora', 'tipomovimientobitacoraid',2);
            foreach($data['grupos'] as $grupo){
                if(!empty($grupo['destinoid']) && !empty($grupo['origenid'])){
                    $alumnos = $dbm->getAlumnosCicloPorGrupo($data['cicloorigenid'],$data['gradoorigenid'], $grupo['origenid']);
                    $grupo = $dbm->getRepositorioById('CeGrupo','grupoid', $grupo['destinoid']);
                    foreach($alumnos as $alumno){
                        $alumnoporciclo = $dbm->getByParametersRepositorios('CeAlumnoporciclo', ['alumnoid' => $alumno['alumnoid'], 'cicloid' => $ciclo, 'gradoid' => $grado]);
                        $alum = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $alumno['alumnoid']);
                        $est = $dbm->getRepositorioById('CeEstatusalumnoporciclo', 'estatusalumnoporcicloid', 1);
                        $ins = $dbm->getRepositorioById('CeIntencionreinscribirse', 'intencionreinscribirseid', 1);
                        if(!empty($data['subgrupos']) && $data['subgrupos'] == true){
                            $alumnoporciclo = $dbm->getByParametersRepositorios('CeAlumnoporciclo', ['alumnoid' => $alumno['alumnoid'], 'cicloid' => $ciclo, 'gradoid' => $grado]);
                            if(count($alumnoporciclo) > 0){
                                $alumnoporciclo = $alumnoporciclo[0];

                                foreach($data['gruposorigen'] as $gr){
                                    $alc = $dbm->getByParametersRepositorios('CeAlumnocicloporgrupo', ['alumnoporcicloid' => $alumnoporciclo, 'grupoid' => $gr]);

                                    if(count($alc) > 0){
                                        $alumnocicloporgrupo = new CeAlumnocicloporgrupo();
                                        $alumnocicloporgrupo->setAlumnoporcicloid($alumnoporciclo);
                                        $alumnocicloporgrupo->setGrupoid($grupo);
                                        $alumnocicloporgrupo->setNumerolista($alumno['numerolista']);
                                        $bitacora = new CeBitacoraarmadogrupo();
                                        $nombre = $alumno['primernombre'] . ' ' . ($alumno['segundonombre'] ? $alumno['segundonombre'] : '') . ' ' . $alumno['apellidopaterno'] . ' ' . $alumno['apellidomaterno'];
                                        $al = $alumno['matricula'] . ' - ' . $nombre;
                                        $bitacora->setAlumno($al);
                                        $bitacora->setFecha(new \DateTime());
                                        $bitacora->setGrupoanterior('Ninguno');
                                        $bitacora->setGruponuevo($grupo->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                                        $bitacora->setGrupodestinoid($grupo);
                                        $bitacora->setAlumnoid($alum);
                                        $bitacora->setUsuario($data['usuario']);
                                        $bitacora->setTipobitacoramovimientoid($tipomovimiento);
                                        $bitacora->setCicloid($ciclo);
                                        $bitacora->setGradoid($grado);
                                        $dbm->saveRepositorio($bitacora);
                                    
                                        $dbm->saveRepositorio($alumnocicloporgrupo);
                                    }
                                }
                                
                            }
                        }else{
                            if(count($alumnoporciclo) > 0){
                                $alumnoporciclo = $alumnoporciclo[0];
                            }else{
                                $alumnoporciclo = new CeAlumnoporciclo();
                                $alumnoporciclo->setAlumnoid($alum);
                                $alumnoporciclo->setCicloid($ciclo);
                                $alumnoporciclo->setGradoid($grado);
                                $alumnoporciclo->setEstatusalumnocicloid($est);
                                $alumnoporciclo->setIntencionreinscribirseid($ins);
                                $dbm->saveRepositorio($alumnoporciclo);
                            }
                            $alumnocicloporgrupo = new CeAlumnocicloporgrupo();
                            $alumnocicloporgrupo->setAlumnoporcicloid($alumnoporciclo);
                            $alumnocicloporgrupo->setGrupoid($grupo);
                            $alumnocicloporgrupo->setNumerolista($alumno['numerolista']);
                            $bitacora = new CeBitacoraarmadogrupo();
                            $nombre = $alumno['primernombre'] . ' ' . ($alumno['segundonombre'] ? $alumno['segundonombre'] : '') . ' ' . $alumno['apellidopaterno'] . ' ' . $alumno['apellidomaterno'];
                            $al = $alumno['matricula'] . ' - ' . $nombre;
                            $bitacora->setAlumno($al);
                            $bitacora->setFecha(new \DateTime());
                            $bitacora->setGrupoanterior('Ninguno');
                            $bitacora->setGruponuevo($grupo->getNombre() . '-' . $grado->getNivelid()->getNombre() . '-' . $grado->getGrado());
                            $bitacora->setGrupodestinoid($grupo);
                            $bitacora->setAlumnoid($alum);
                            $bitacora->setUsuario($data['usuario']);
                            $bitacora->setTipobitacoramovimientoid($tipomovimiento);
                            $bitacora->setCicloid($ciclo);
                            $bitacora->setGradoid($grado);
                            $dbm->saveRepositorio($bitacora);
                        
                            $dbm->saveRepositorio($alumnocicloporgrupo);
                        }
                    }
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    /**
    * @Rest\Get("/api/Controlescolar/Armadogrupos/listaAlumnosGrupo/{grupoid}", name="getListaAlumnosGrupos")
    */
   public function getListaAlumnosGrupos($grupoid) {
        $env=[1=>"Lux/",2=>"Ciencias/"];
        try{
            $root=str_replace('app', '', $this->get('kernel')->getRootDir());
            $envPath=$env[ENTORNO];
            $mPath="src/AppBundle/Dominio/Reporteador/Plantillas/";
            $bPath="{$mPath}{$envPath}";
            $path=$root.$bPath;
            $pathLogo="{$path}logo.png";
            $pathRep="{$path}ListaAlumnosGrupo.jrxml";
            $pathOutput="{$mPath}ListaAlumnos";
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
                "grupoid"=>$grupoid,
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
}