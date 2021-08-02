<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeConftallercurricular;
use AppBundle\Entity\CeTallerperiodoinscripcion;
use AppBundle\Entity\CeConfiguracionhorario;
use AppBundle\Entity\CeMateriaporhorario;
use AppBundle\Entity\CeHorario;
use AppBundle\Entity\CeMateriahorarioporsubgrupotaller;
use AppBundle\Entity\CeMateriahorarioporhorario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;

/**
 * Auto: David Medina
 */
class ConfiguracionHorarioController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/ConfiguracionHorario/getHorarios", name="getHorarios")
     */
    public function getHorarios()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $horarios = $dbm->BuscarHorarios($filtros);
            if(!$horarios) {
                return new View("No se encontró ningun registro", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($horarios, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/ConfiguracionHorario/CopiarHorario" , name="CopiarHorario")
     */
    public function CopiarHorario()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $checkhorario = $dbm->getByParametersRepositorios('CeConfiguracionhorario', array("cicloid" => $data['ciclocopia'], "gradoid" => $data['gradocopia']));
            if($checkhorario) {
                return new View("Para hacer la copia de configuración de horarios de clase de otro grado o ciclo la tabla del 
                    grado que se está configurando debe estar vacía", Response::HTTP_PARTIAL_CONTENT);
            }


            $registros = $dbm->getByParametersRepositorios('CeConfiguracionhorario', array("cicloid" => $data['cicloid'], "gradoid" => $data['gradoid']));
            if(!$registros) {
                return new View("No se han encontrado registros con los filtros seleccionados", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach($registros as $r) {
                $horario = new CeConfiguracionhorario();
                $horario->setOrden($r->getOrden());
                $horario->setCicloid(empty($data['ciclocopia']) ? null : $dbm->getRepositorioById("Ciclo", "cicloid", $data['ciclocopia']));
                $horario->setGradoid(empty($data['gradocopia']) ? null : $dbm->getRepositorioById("Grado", "gradoid", $data['gradocopia']));
                $horario->setNombre($r->getNombre());
                $horario->setHorainicio($r->getHorainicio());
                $horario->setHorafin($r->getHorafin());
                $horario->setEsclase($r->getEsclase());
                $dbm->saveRepositorio($horario);
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

        /**
     * @Rest\Post("/api/Controlescolar/ConfiguracionHorario/GuardarHorario" , name="GuardarHorario")
     */
    public function GuardarHorario()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $registro = $dbm->getRepositorioById("CeConfiguracionhorario", "configuracionhorarioid", $data['configuracionhorarioid']);
            $checkorden = $dbm->getOneByParametersRepositorio('CeConfiguracionhorario', array(
                "cicloid" => $data['cicloid'], 
                "gradoid" => $data['gradoid'],
                "orden" => $data['orden'],
            ));

            if($checkorden) {
                if($registro) {
                    if($checkorden->getConfiguracionhorarioid() != $data['configuracionhorarioid']) {
                        return new View("Ya existe un horario con el mismo orden", Response::HTTP_PARTIAL_CONTENT);
                    }
                } else {
                    return new View("Ya existe un horario con el mismo orden", Response::HTTP_PARTIAL_CONTENT);
                } 
            }
            $confhorario =  $registro ? $registro : new CeConfiguracionhorario();
            $confhorario->setOrden(empty($data['orden']) ? null : $data['orden']);
            $confhorario->setCicloid(empty($data['cicloid']) ? null : $dbm->getRepositorioById("Ciclo", "cicloid", $data['cicloid']));
            $confhorario->setGradoid(empty($data['gradoid']) ? null : $dbm->getRepositorioById("Grado", "gradoid", $data['gradoid']));
            $confhorario->setNombre(empty($data['nombre']) ? null : $data['nombre']);
            $confhorario->setHorainicio(empty($data['horainicio']) ? null : new \DateTime($data['horainicio']));
            $confhorario->setHorafin(empty($data['horafin']) ? null : new \DateTime($data['horafin']));
            $confhorario->setEsclase(empty($data['esclase']) ? null : intval($data['esclase']));
            $dbm->saveRepositorio($confhorario);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    
    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/ConfiguracionHorario/DeleteHorario/{id}", name="deletehorarioconf")
     */
    public function deletehorarioconf($id) {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            
            $horario = $dbm->getRepositorioById('CeConfiguracionhorario', 'configuracionhorarioid', $id);
            $dbm->removeRepositorio($horario);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
        	if($e->getPrevious()->getCode() == "23000"){
        		return new View("No se puede eliminar el registro por que ya hay materias asignadas a este horario de clase", Response::HTTP_PARTIAL_CONTENT);
        	}else{
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        	}
        }
    }

    /**
     * 
     * @Rest\Get("/api/Controlescolar/ConfiguracionHorario/getHorarioGrupoMaterias", name="getHorarioGrupoMaterias")
     */
    public function getHorarioGrupoMaterias()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $respuesta = $this->getGruposHorario($filtros, $dbm);
            if($respuesta['error']) {
                return new View($respuesta['mensaje'], Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($respuesta, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

            /**
     * @Rest\Post("/api/Controlescolar/ConfiguracionHorario/GuardarMateriaHorario" , name="GuardarMateriaHorario")
     */
    public function GuardarMateriaHorario()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $validar = strtolower($data['validar']) == 'true' ? true : false;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $registro = $dbm->getRepositorioById("CeMateriaporhorario", "materiaporhorarioid", $data['materiaporhorarioid']);
            $checkorden = $dbm->getOneByParametersRepositorio('CeMateriaporhorario', array("configuracionhorarioid" => $data['configuracionhorarioid'], "dia" => $data['diaid'], "grupoid" => $data['grupoid']));
            $confh = $dbm->getRepositorioById("CeConfiguracionhorario", "configuracionhorarioid", $data['configuracionhorarioid']);

            if($data['matplanestudioidold'] && $data['matplanestudioidold'] != $data['materiaporplanestudioid']) {
                foreach($data['arraypmpe'] as $pmpe) {
                    $filtros = array(
                        "profesorpormateriaplanestudioid" => $pmpe,
                        "horainicio" => ($confh->getHorainicio())->format("H:i:s"),
                        "horafin" => ($confh->getHorafin())->format("H:i:s"),
                        "dia" => $data['diaid'] + 1
                    );
                    $faltas = $dbm->getFaltasByHorario($filtros);
                    foreach($faltas as $f) {
                        if($f->getTipoasistenciaid()->getTipoasistenciaid() == 2 || $f->getTipoasistenciaid()->getTipoasistenciaid() == 3) {
                            $encontrado = true;
                            break;
                        }
                    }
                    if($validar) {
                        if($encontrado) {
                            return new View(array("faltas"=> true), Response::HTTP_PARTIAL_CONTENT);
                        }
                    }
                    $dbm->removeBulkRepositorio($faltas);
                }
                $dbm->removeManyRepositorio("CeMateriahorarioporsubgrupotaller", "materiaporhorarioid", $data['materiaporhorarioid']);
            }

            if($checkorden) {
                if($registro) {
                    if($checkorden->getMateriaporhorarioid() != $data['materiaporhorarioid']) {
                        return new View("No se puede cambiar la clase al día y horario seleccionados pues ya existe otra clase asignada.", Response::HTTP_PARTIAL_CONTENT);
                    }
                } else {
                    return new View("No se puede cambiar la clase al día y horario seleccionados pues ya existe otra clase asignada.", Response::HTTP_PARTIAL_CONTENT);
                } 
            }


            $confhorario =  $registro ? $registro : new CeMateriaporhorario();
            $confhorario->setConfiguracionhorarioid(empty($data['configuracionhorarioid']) ? null :  
                $dbm->getRepositorioById("CeConfiguracionhorario", "configuracionhorarioid", $data['configuracionhorarioid']));

            $confhorario->setProfesorpormateriaplanestudiosid(empty($data['profesorpormateriaplanestudioid']) ? null : 
                $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $data['profesorpormateriaplanestudioid']));

            $confhorario->setDia(empty($data['diaid']) ? null : $data['diaid']);
            $confhorario->setSalon(empty($data['salon']) ? null : $data['salon']);
            $confhorario->setGrupoid(empty($data['grupoid']) ? null : 
                $dbm->getRepositorioById("CeGrupo", "grupoid", $data['grupoid']));

            $dbm->saveRepositorio($confhorario);

            foreach($data['datasubtaller'] as $st) {
                $subtaller = $dbm->getRepositorioById("CeMateriahorarioporsubgrupotaller", "materiahorariosubgrupotallerid", $st['MateriaHorarioSubgrupoTallerId']);
                if($subtaller) {
                    $subtaller->setSalon(empty($st['salon']) ? null : $st['salon']);
                    $dbm->saveRepositorio($subtaller);
                } else {
                    $matsubtaller = new CeMateriahorarioporsubgrupotaller();
                    $matsubtaller->setMateriaporhorarioid($confhorario);
                    $matsubtaller->setProfesorpormateriaplanestudiosid(empty($st['profesorpormateriaplanestudiosid']) ? null : 
                    $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $st['profesorpormateriaplanestudiosid']));
                    $matsubtaller->setSalon(empty($st['salon']) ? null : $st['salon']);
                    $dbm->saveRepositorio($matsubtaller);
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Get("/api/Controlescolar/ConfiguracionHorario/DeleteMateriaHorario/{id}", name="deletemateriahorario")
     */
    public function deletemateriahorario($id) {
        try {
            $encontrado = false;
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = strtolower($filtros['validar']) == 'true' ? true : false;
            $horario = $dbm->getRepositorioById('CeMateriaporhorario', 'materiaporhorarioid', $id);
            if($horario->getProfesorpormateriaplanestudiosid()) {
                $filtros = array(
                    "profesorpormateriaplanestudioid" => $horario->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                    "horainicio" => ($horario->getConfiguracionhorarioid()->getHorainicio())->format("H:i:s"),
                    "horafin" => ($horario->getConfiguracionhorarioid()->getHorafin())->format("H:i:s"),
                    "dia" => $horario->getDia() + 1
                );
                $faltas = $dbm->getFaltasByHorario($filtros);
                foreach($faltas as $f) {
                    if($f->getTipoasistenciaid()->getTipoasistenciaid() == 2 || $f->getTipoasistenciaid()->getTipoasistenciaid() == 3) {
                        $encontrado = true;
                        break;
                    }
                }
                if($validar) {
                    if($encontrado) {
                        return new View(array("faltas"=> true), Response::HTTP_PARTIAL_CONTENT);
                    }
                }
                $dbm->removeBulkRepositorio($faltas);
                $r = 1;
            } else {
                $mathorariosubtaller = $dbm->getRepositoriosById('CeMateriahorarioporsubgrupotaller', 'materiaporhorarioid', $id);
                foreach($mathorariosubtaller as $mts) {
                    $h = $mts->getMateriaporhorarioid();
                    $filtros = array(
                        "profesorpormateriaplanestudioid" => $mts->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                        "horainicio" => ($h->getConfiguracionhorarioid()->getHorainicio())->format("H:i:s"),
                        "horafin" => ($h->getConfiguracionhorarioid()->getHorafin())->format("H:i:s"),
                        "dia" => $h->getDia() + 1
                    );
                    $faltas = $dbm->getFaltasByHorario($filtros);
                    foreach($faltas as $f) {
                        if($f->getTipoasistenciaid()->getTipoasistenciaid() == 2 || $f->getTipoasistenciaid()->getTipoasistenciaid() == 3) {
                            $encontrado = true;
                            break;
                        }
                    }
                    if($validar) {
                        if($encontrado) {
                            return new View(array("faltas"=> true), Response::HTTP_PARTIAL_CONTENT);
                        }
                    }
                    $dbm->removeBulkRepositorio($faltas);
                }
                $dbm->removeManyRepositorio('CeMateriahorarioporsubgrupotaller', 'materiaporhorarioid', $id);
            }

            $hmxh = $dbm->getRepositoriosById('CeMateriahorarioporhorario', 'materiahorarioid', $id);
            if($hmxh) {
                foreach($hmxh as $xc) {
                    $dbm->removeRepositorio($xc);
                    $dbm->removeManyRepositorio('CeHorario', 'horarioid', $xc->getHorarioid()->getHorarioid());
                }
            }

            $dbm->removeRepositorio($horario);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
        	if($e->getPrevious()->getCode() == "23000"){
        		return new View("No se puede eliminar el registro por que ya hay materias asignadas a este horario de clase", Response::HTTP_PARTIAL_CONTENT);
        	}else{
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        	}
        }
    }


        /**
     * Elimina un registro
     * @Rest\Get("/api/Controlescolar/ConfiguracionHorario/DeleteMateriaHorarioSubgrupoTaller/{id}", name="DeleteMateriaHorarioSubgrupoTaller")
     */
    public function DeleteMateriaHorarioSubgrupoTaller($id) 
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $validar = strtolower($data['validar']) == 'true' ? true : false;
            $matsubtaller = $dbm->getRepositorioById('CeMateriahorarioporsubgrupotaller', 'materiahorariosubgrupotallerid', $id);
            $matxhorario = $matsubtaller->getMateriaporhorarioid();
            $horario = $matsubtaller->getMateriaporhorarioid();
            $filtros = array(
                "profesorpormateriaplanestudioid" => $matsubtaller->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid(),
                "horainicio" => ($horario->getConfiguracionhorarioid()->getHorainicio())->format("H:i:s"),
                "horafin" => ($horario->getConfiguracionhorarioid()->getHorafin())->format("H:i:s"),
                "dia" => $horario->getDia() + 1
            );
            $faltas = $dbm->getFaltasByHorario($filtros);
            foreach($faltas as $f) {
                if($f->getTipoasistenciaid()->getTipoasistenciaid() == 2 || $f->getTipoasistenciaid()->getTipoasistenciaid() == 3) {
                    $encontrado = true;
                    break;
                }
            }
            if($validar) {
                if($encontrado) {
                    return new View(array("faltas"=> true), Response::HTTP_PARTIAL_CONTENT);
                }
            }

            $dbm->removeBulkRepositorio($faltas);
    
            $dbm->removeManyRepositorio('CeMateriahorarioporsubgrupotaller', 'materiahorariosubgrupotallerid', $id);

            $rh = $dbm->getRepositoriosModelo("CeMateriahorarioporhorario", 
            ["d.materiahorarioporhorarioid, h.horarioid"], 

                [["materiahorarioporhorarioid is not null and pmpe.profesorpormateriaplanestudiosid = " . $matsubtaller->getProfesorpormateriaplanestudiosid()->getProfesorpormateriaplanestudiosid()
                    . " and mh.materiaporhorarioid =" . $matsubtaller->getMateriaporhorarioid()->getMateriaporhorarioid()]], false, true, [
                ["entidad" => "CeMateriaporhorario", "alias" => "mh", "left" => false, "on" => "mh.materiaporhorarioid = d.materiahorarioid"],
                ["entidad" => "CeHorario", "alias" => "h", "left" => false, "on" => "h.horarioid = d.horarioid"],
                ["entidad" => "CeProfesorpormateriaplanestudios", "alias" => "pmpe", "left" => false, "on" => "pmpe.profesorpormateriaplanestudiosid = h.profesorpormateriaplanestudiosid"]
            ])[0];
            if($rh) {
                $dbm->removeManyRepositorio('CeMateriahorarioporhorario', 'materiahorarioporhorarioid', $rh['materiahorarioporhorarioid']);
                $dbm->removeManyRepositorio('CeHorario', 'horarioid', $rh['horarioid']);
            }


            $matsub = $dbm->getRepositoriosById('CeMateriahorarioporsubgrupotaller', 'materiaporhorarioid', $matxhorario->getMateriaporhorarioid());
            if(!$matsub) {
                $matxh = $dbm->getRepositorioById('CeMateriahorarioporhorario', 'materiahorarioid', $matxhorario->getMateriaporhorarioid());
                if($matxh) {
                    $dbm->removeManyRepositorio('CeMateriahorarioporhorario', 'materiahorarioid', $matxhorario->getMateriaporhorarioid());
                    $dbm->removeManyRepositorio('CeHorario', 'horarioid', $matxh->getHorarioid()->getHorarioid());
                }
                $dbm->removeManyRepositorio('CeMateriaporhorario', 'materiaporhorarioid', $matxhorario->getMateriaporhorarioid());
            }

            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }   


        /**
     * Elimina un registro
     * @Rest\Get("/api/Controlescolar/ConfiguracionHorario/CheckMateria/{id}", name="checkMateria")
     */
    public function checkMateria($id) {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $extended = [];
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $materia = $dbm->getRepositorioById('CeMateriaporplanestudios', 'materiaporplanestudioid', $id);
            if($materia->getConfigurarsubgrupos()) {
                $grupos = $dbm->getRepositoriosModelo("CeProfesorpormateriaplanestudios", 
                    ["d.profesorpormateriaplanestudiosid, pp.nombre,
                      concat_Ws(' ', pr.apellidopaterno, pr.apellidomaterno, pr.nombre) as profesor,
                      concat_Ws(' ', pr1.apellidopaterno, pr1.apellidomaterno, pr1.nombre) as cotitular,
                      concat_Ws(' ', pr2.apellidopaterno, pr2.apellidomaterno, pr2.nombre) as suplente
                      "], 

                    [["materiaporplanestudioid = " .$id. " and p.grupoid = " . $filtros['grupoid']]], false, true, [
                    ["entidad" => "CeGrupoorigenporsubgrupo", "alias" => "gs", "left" => false, "on" => "gs.grupoid = d.grupoid"],
                    ["entidad" => "CeGrupo", "alias" => "pp", "left" => false, "on" => "pp.grupoid = gs.grupoid"],
                    ["entidad" => "CeProfesor", "alias" => "pr", "left" => false, "on" => "pr.profesorid = d.profesorid"],
                    ["entidad" => "CeProfesor", "alias" => "pr1", "left" => true, "on" => "pr1.profesorid = d.cotitularid"],
                    ["entidad" => "CeProfesor", "alias" => "pr2", "left" => true, "on" => "pr2.profesorid = d.suplenteid"],
                    ["entidad" => "CeGrupo", "alias" => "p", "left" => false, "on" => "p.grupoid = gs.grupoorigenid"]
                    ], "pp.nombre");
                if(!$grupos) {
                    return new View("No se han encontrado subgrupos en la materia seleccionada", Response::HTTP_PARTIAL_CONTENT);
                }
                $extended = ["configurarsubgrupos"=> true, "tipogrupo" => "SUBGRUPO"];
                return new View(array("grupos"=>$grupos, "extended"=>$extended), Response::HTTP_OK);
            
            } else if($materia->getConfigurartaller()) {
                $grupos = $dbm->getRepositoriosModelo("CeProfesorpormateriaplanestudios", 
                ["d.profesorpormateriaplanestudiosid, t.nombre,
                  concat_Ws(' ', pr.apellidopaterno, pr.apellidomaterno, pr.nombre) as profesor,
                  concat_Ws(' ', pr1.apellidopaterno, pr1.apellidomaterno, pr1.nombre) as cotitular,
                  concat_Ws(' ', pr2.apellidopaterno, pr2.apellidomaterno, pr2.nombre) as suplente
                  "], 

                    [["profesorpormateriaplanestudiosid is not null and mpe.materiaporplanestudioid = " . $id. " and t.cicloid =" . $filtros['cicloid'] . "and gt.gradoid =" . $filtros['gradoid']]], false, true, [
                    ["entidad" => "CeTallercurricular", "alias" => "t", "left" => false, "on" => "t.tallercurricularid = d.tallerid"],
                    ["entidad" => "CeGradoportallercurricular", "alias" => "gt", "left" => false, "on" => "gt.tallercurricularid = t.tallercurricularid"],
                    ["entidad" => "CeMateriaporplanestudios", "alias" => "mpe", "left" => false, "on" => "mpe.materiaporplanestudioid = gt.materiaporplanestudioid"],
                    ["entidad" => "CeProfesor", "alias" => "pr", "left" => true, "on" => "pr.profesorid = d.profesorid"],
                    ["entidad" => "CeProfesor", "alias" => "pr1", "left" => true, "on" => "pr1.profesorid = d.cotitularid"],
                    ["entidad" => "CeProfesor", "alias" => "pr2", "left" => true, "on" => "pr2.profesorid = d.suplenteid"],
                    ], "t.nombre");
                if(!$grupos) {
                    return new View("No se han encontrado subgrupos en la materia seleccionada", Response::HTTP_PARTIAL_CONTENT);
                }
                $extended = ["configurartaller"=> true, "tipogrupo" => "TALLER"];
                return new View(array("grupos"=>$grupos, "extended"=>$extended), Response::HTTP_OK);
            } else {
                $grupos = $dbm->getRepositoriosModelo("CeProfesorpormateriaplanestudios", 
                ["d.profesorpormateriaplanestudiosid, t.nombre,
                    concat_Ws(' ', pr.apellidopaterno, pr.apellidomaterno, pr.nombre) as profesor
                "], 

                    [["profesorpormateriaplanestudiosid is not null and mpe.materiaporplanestudioid = " . $id. " and d.grupoid =" . $filtros['grupoid']]], false, true, [
                    ["entidad" => "CeGrupo", "alias" => "t", "left" => false, "on" => "t.grupoid = d.grupoid"],
                    ["entidad" => "CeProfesor", "alias" => "pr", "left" => true, "on" => "pr.profesorid = d.profesorid"],
                    ["entidad" => "CeMateriaporplanestudios", "alias" => "mpe", "left" => false, "on" => "mpe.materiaporplanestudioid = d.materiaporplanestudioid"]
                ])[0];
                if(!$grupos) {
                    return new View("No se han encontrado grupos en la materia seleccionada", Response::HTTP_PARTIAL_CONTENT);
                }
                return new View(array("grupos"=>$grupos), Response::HTTP_OK);
            }

            return new View([], Response::HTTP_OK);
        } catch (\Exception $e) {
        	if($e->getPrevious()->getCode() == "23000"){
        		return new View("No se puede eliminar el registro por que ya hay materias asignadas a este horario de clase", Response::HTTP_PARTIAL_CONTENT);
        	}else{
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        	}
        }
    }

    public static function getGruposHorario($filtros, $dbm) {
        $dias = [1,2,3,4,5];
        $arraygrupos = [];
        $materias = $dbm->getRepositoriosModelo("CeMateriaporplanestudios", 
        ["d.materiaporplanestudioid, concat(m.nombre , ' - ' , m.alias) as nombre, IDENTITY(p.areaespecializacionid) as areaespecializacionid "], 
        [["materiaporplanestudioid is not null and p.gradoid = " . $filtros['gradoid'] . " and p.vigente = 1"]], false, true, [
        ["entidad" => "CePlanestudios", "alias" => "p", "left" => false, "on" => "p.planestudioid = d.planestudioid"],
        ["entidad" => "Materia", "alias" => "m", "left" => false, "on" => "m.materiaid = d.materiaid"]
        ], "m.nombre");



        $grupos = $dbm->getByParametersRepositorios("CeGrupo", [
            "cicloid"=>$filtros['cicloid'],
            "gradoid"=>$filtros['gradoid'],
            "tipogrupoid" => 1
        ]);
        $configuracionhorario = $dbm->getRepositoriosModelo("CeConfiguracionhorario", 
        ["d"], 
        [["cicloid = " . $filtros['cicloid'] . ' and d.gradoid = ' . $filtros['gradoid']]], false, true, [], "d.orden");
        
        
        if(!$configuracionhorario) {  
            return array("mensaje"=> "No se ha asignado una configuración de horario en el ciclo y grado seleccionado", "error"=> true);
        }
        if(!$grupos) {  
            return array("mensaje"=> "No se han encontrado grupos en el ciclo y grado seleccionado", "error"=> true);
        }

        foreach($grupos as $key=>$g) {
                $arraygrupos[] = [
                    "grupoid" => $g->getGrupoid(),
                    "nombre" => $g->getNombre(),
                    "areaespecializacionid" => $g->getAreaespecializacionid() ? $g->getAreaespecializacionid()->getAreaespecializacionid() : null
                ];
            foreach ($configuracionhorario as $kt=>$ch) {
                    $arraygrupos[$key]["datos"][] = array(
                        "grupoid" => $g->getGrupoid(),
                        "grupo" => $g->getNombre(),
                        "configuracionhorarioid" => $ch->getConfiguracionhorarioid(),
                        "esclase" => $ch->getEsclase(),
                        "nombre" => $ch->getNombre(),
                        "horainicio" => $ch->getHorainicio() ? $ch->getHorainicio()->format('H:i') : null,
                        "horafin" => $ch->getHorafin() ? $ch->getHorafin()->format('H:i') : null
                    );
                foreach ($dias as $d) {
                    $filtros = ["grupoid" => $g->getGrupoid(), "dia" => $d, "configuracionhorarioid" => $ch->getConfiguracionhorarioid()];
                    $r = $dbm->loadMateriaHorario($filtros)[0];
                    $subtalleres = $r ? $dbm->loadSubgruposTalleresByMateriaHorario($r['materiaporhorarioid']) : null;

                    $arraygrupos[$key]["datos"][$kt]['horarios'][] = array(
                        "profesorpormateriaplanestudiosid" => $r ? $r['profesorpormateriaplanestudiosid'] : null,
                        "profesor" => $r ? $r['profesor'] : null,
                        "materiaporplanestudioid"  => $r ? $r['materiaporplanestudioid'] : null,
                        "nombre"  => $r ? $r['materia'] : null,
                        "configuracionhorarioid"  => $r ? $r['configuracionhorarioid'] : $ch->getConfiguracionhorarioid(),
                        "salon"  => $r ? $r['salon'] : null,
                        "materiaporhorarioid"  => $r ? $r['materiaporhorarioid'] : null,
                        "dia" => $d,
                        "extended" => $r ? $r['extended'] : null,
                        "tipo" => $r ? $r['tipo'] : null,
                        "subtalleres" => $subtalleres
                    );
                }
            }
        }
        $arraygrupos = array($arraygrupos);
        return array("grupos" => $arraygrupos, "materias" => $materias, "allgrupos" => $grupos);
    }

        /**
     * 
     * @Rest\Get("/api/Controlescolar/ConfiguracionHorario/GuardarHorariogrupos", name="GuardarHorariogrupos")
     */
    public function GuardarHorariogrupos()
    {
        $datos = $_REQUEST;
        $filtros = array_filter($datos);
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        try {
            $dbm->getConnection()->beginTransaction();
            $respuesta = $this->getGruposHorario($filtros, $dbm);
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $arrayhorario = [];
            $arrayentity = [];
            if($respuesta['error']) {
                return new View($respuesta['mensaje'], Response::HTTP_PARTIAL_CONTENT);
            }
            $r = 1;
            if(!$respuesta['grupos']) {
                return new View("No se han encontrado grupos para asignar un horario", Response::HTTP_PARTIAL_CONTENT);
            }
            foreach($respuesta['grupos'][0] as $grupo) {
                foreach($grupo['datos'] as $d) {
                    foreach($d['horarios'] as $h) {
                        if($h['profesorpormateriaplanestudiosid'] || count($h['subtalleres']) > 0) {
                            if($h['profesorpormateriaplanestudiosid']) {
                                $arrayhorario[] = array(
                                    "profesorpormateriaplanestudiosid" => $h['profesorpormateriaplanestudiosid'],
                                    "dia" =>$h['dia'],
                                    "salon" => $h['salon'],
                                    "horainicio" => new \Datetime($d['horainicio']),
                                    "horafin"=> new \Datetime($d['horafin']),
                                    "materiaporhorarioid" => $h['materiaporhorarioid']
                                );
                            } else {
                                foreach($h['subtalleres'] as $sub) {
                                    $arrayhorario[] = array(
                                        "profesorpormateriaplanestudiosid" => $sub['profesorpormateriaplanestudiosid'],
                                        "dia" =>$h['dia'],
                                        "salon" => $sub['salon'],
                                        "horainicio" => new \Datetime($d['horainicio']),
                                        "horafin"=> new \Datetime($d['horafin']),
                                        "materiaporhorarioid" => $h['materiaporhorarioid']
                                    );
                                }
                            }
                        }
                    }
                }
            }

            if(count($arrayhorario) == 0) {
                return new View("No se han encontrado horarios para asignar", Response::HTTP_PARTIAL_CONTENT);
            }

            foreach($arrayhorario as $horario) {
                $mathorario = $dbm->getRepositorioById("CeMateriahorarioporhorario", "materiahorarioid", $horario['materiaporhorarioid']);
                if($mathorario) {
                    $pmpehor = $dbm->getRepositorioById("CeHorario", "horarioid", $mathorario->getHorarioid()->getHorarioid());
                    $pmpehor->setHorainicio($horario['horainicio'] ? $horario['horainicio'] : null);
                    $pmpehor->setHorafin($horario['horafin'] ? $horario['horafin'] : null);
                    $pmpehor->setDia($horario['dia'] ? $horario['dia'] : null);
                    $pmpehor->setSalon($horario['salon'] ? $horario['salon'] : null);
                    $pmpehor->setProfesorpormateriaplanestudiosid($horario['profesorpormateriaplanestudiosid'] ? 
                        $dbm->getRepositorioById("CeProfesorpormateriaplanestudios", "profesorpormateriaplanestudiosid", $horario['profesorpormateriaplanestudiosid']) : null);
                } else {
                    $pmpehor = $hydrator->hydrate(new CeHorario(), $horario);
                    $mathorario = new CeMateriahorarioporhorario();
                    $mathorario->setMateriahorarioid($horario['materiaporhorarioid'] ? 
                        $dbm->getRepositorioById("CeMateriaporhorario", "materiaporhorarioid", $horario['materiaporhorarioid']) : null);
                    $mathorario->setHorarioid($pmpehor);  

                }
                $arrayentity[] =  $pmpehor;
                $arrayentity[] =  $mathorario;
            }
            $dbm->saveBulkRepositorio($arrayentity);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

            /**
     * Elimina un registro
     * @Rest\Get("/api/Controlescolar/ConfiguracionHorario/checksubgrupoTallerHorario", name="checksubgrupoTallerHorario")
     */
    public function checksubgrupoTallerHorario() {
        $datos = $_REQUEST;
        $filtros = array_filter($datos);
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        try {
                $registros = $dbm->getRepositoriosModelo("CeMateriahorarioporsubgrupotaller", 
                ["pmpe.profesorpormateriaplanestudiosid, case when t.nombre is not null then t.nombre else g.nombre as nombre, d.salon,
                concat_Ws(' ', pr.apellidopaterno, pr.apellidomaterno, pr.nombre) as profesor,
                concat_Ws(' ', pr1.apellidopaterno, pr1.apellidomaterno, pr1.nombre) as cotitular,
                concat_Ws(' ', pr2.apellidopaterno, pr2.apellidomaterno, pr2.nombre) as suplente "], 

                [["materiahorariosubgrupotallerid is not null and m.dia = ". $filtros['diaid'] . "and mpe.materiaporplanestudioid = ". $filtros['materiaporplanestudioid'] . "and m.configuracionhorarioid = " . $filtros['configuracionhorarioid'] . " and m.grupoid = " . $filtros['grupoid']]], false, true, [
                ["entidad" => "CeProfesorpormateriaplanestudios", "alias" => "pmpe", "left" => false, "on" => "pmpe.profesorpormateriaplanestudiosid = d.profesorpormateriaplanestudiosid"],
                ["entidad" => "CeProfesor", "alias" => "pr", "left" => false, "on" => "pr.profesorid = pmpe.profesorid"],
                ["entidad" => "CeProfesor", "alias" => "pr1", "left" => true, "on" => "pr1.profesorid = pmpe.cotitularid"],
                ["entidad" => "CeProfesor", "alias" => "pr2", "left" => true, "on" => "pr2.profesorid = pmpe.suplenteid"],
                ["entidad" => "CeGrupo", "alias" => "g", "left" => true, "on" => "g.grupoid = pmpe.grupoid"],
                ["entidad" => "CeTallercurricular", "alias" => "t", "left" => true, "on" => "t.tallercurricularid = pmpe.tallerid"],
                ["entidad" => "CeGradoportallercurricular", "alias" => "gtc", "left" => true, "on" => "t.tallercurricularid = gtc.tallercurricularid"],
                ["entidad" => "CeMateriaporplanestudios", "alias" => "mpe", "left" => true, "on" => "mpe.materiaporplanestudioid = gtc.materiaporplanestudioid or mpe.materiaporplanestudioid  = pmpe.materiaporplanestudioid"],

                ["entidad" => "CeMateriaporhorario", "alias" => "m", "left" => false, "on" => "m.materiaporhorarioid = d.materiaporhorarioid"]
            ]);
            if(!$registros) {
                return new View("No se ha encontrado ningun registro", Response::HTTP_PARTIAL_CONTENT);
            }   
            return new View($registros, Response::HTTP_OK);

        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }
}
