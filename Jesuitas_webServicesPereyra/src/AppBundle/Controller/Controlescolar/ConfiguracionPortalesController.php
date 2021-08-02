<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CePeriodoactualizacion;
use FOS\RestBundle\View\View;

/**
 * Auto: David
 */
class ConfiguracionPortalesController extends FOSRestController {

    /**
     * Retorna arreglo de paises en base a los parametros enviados
     * @Rest\Get("/api/ConfiguracionPortal/menus", name="getMenusConfiguracionportal")
     */
    public function getMenusConfiguracionportal() {
        try {
            $arrmenuhijos = [];
            $arrmenupadres = [];
            $arrmenuappshijos = [];
            $arrmenuappspadres = [];
            $arrmenu = [];
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $menus = $dbm->getRepositoriosModelo("Menuconfiguracion", 
                    ["d.menuconfiguracionid AS id","IDENTITY(d.menuconfiguracionparentid) AS parentid","d.title","d.sistema","d.key","d.icon","d.color","d.action", "d.orden", "d.activo"], 
                    [], ["orden" => "ASC"]);

            $pantallacalificaciones = $dbm->getRepositoriosModelo("CeConfiguracionpantallacalificaciones", 
                    ["d.configuracionpantallacalificacionid", "g.gradoid", "g.grado", "n.nombre as nivel", "d.consultaportalpadres", "d.boletaportalpadres", "d.consultaapppadres", "d.boletaapppadres", "d.consultaportalalumnos", "d.boletaportalalumnos", "d.consultaappalumnos", "d.boletaappalumnos"], 
                    [["configuracionpantallacalificacionid is not null"]], false, true, [
                        ["entidad" => "Grado", "alias" => "g", "left" => false, "on" => "g.gradoid = d.gradoid"],
                        ["entidad" => "Nivel", "alias" => "n", "left" => false, "on" => "n.nivelid = g.nivelid"]
            ]);   

            $periodoactualizacion = $dbm->getRepositoriosModelo("CePeriodoactualizacion", 
                    ["d.periodoactualizacionid","c.cicloid","c.nombre  as ciclo", "d.activo", "DATE_FORMAT(d.fechainicio, '%d/%m/%Y') as fechainicio", "DATE_FORMAT(d.fechafin, '%d/%m/%Y') as fechafin", "DATE_FORMAT(d.fechainicio, '%Y-%m-%d') as fechainicioformat", "DATE_FORMAT(d.fechafin, '%Y-%m-%d') as fechafinformat"], 
                    [["periodoactualizacionid is not null"]], false, true, [
                        ["entidad" => "Ciclo", "alias" => "c", "left" => false, "on" => "c.cicloid = d.cicloid"],
            ]);

            $menuconfiguracionapps = $dbm->getRepositoriosModelo("Menuconfiguracionapps", 
            ["d.menuconfiguracionappid, d.menuconfiguracionparentid as parentid, d.sistema, d.title, d.orden, d.activo"], [], ["orden" => "ASC"], false, []);

            foreach($menuconfiguracionapps as $key=>$mca) {
                $niveles = $dbm->getRepositoriosModelo("Menuconfiguracionappsnivel", 
                ["d.menuconfiguracionappnivelid, n.nombre, n.nivelid, d.activo"], ["menuconfiguracionappid" => $mca['menuconfiguracionappid']], false, false, [
                    ["entidad" => "Nivel", "alias" => "n", "left" => false, "on" => "n.nivelid = d.nivelid"]
                ]);
                $menuconfiguracionapps[$key]['niveles'] = $niveles;
            }
        
            
            foreach($menus as $m) {
                if($m['parentid']) {
                    $arrmenuhijos[] = $m;
                } else {
                    $arrmenupadres[] = $m;
                }
            }

            foreach($arrmenupadres as $m) {
                $childrens = $this->searchForId($m['id'], $arrmenuhijos);
                $arrmenu[] = ["padre" => $m, "hijos" => $childrens];
            }

            foreach($menuconfiguracionapps as $m) {
                if($m['parentid']) {
                    $arrmenuappshijos[] = $m;
                } else {
                    $arrmenuappspadres[] = $m;
                }
            }

            foreach($arrmenuappspadres as $m) {
                $childrens = $this->searchForId($m['menuconfiguracionappid'], $arrmenuappshijos);
                $arrmenuapps[] = ["padre" => $m, "hijos" => $childrens];
            }

            return new View(array(
                "menus" => $arrmenu, 
                "menusapps" => $arrmenuapps,
                "periodoactualizacion" => $periodoactualizacion,
                "encabezado" => $encabezado,
                "ciclo" => $ciclo,
                "calificaciones" => $pantallacalificaciones
        ), Response::HTTP_OK);
        } catch (Exception $e) {
        	return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/ConfiguracionPortal/menus/setActivo" , name="setActivo")
     */
    public function setActivo() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hijoactivo = false;
            $dbm->getConnection()->beginTransaction();
            if($data['hijo']) {
                $pantalla = $dbm->getRepositorioById('Menuconfiguracion', 'menuconfiguracionid', $data['hijo']['menuconfiguracionid']);
                $pantalla->setActivo($data['hijo']['activo']);
                $dbm->saveRepositorio($pantalla);

                $p = $dbm->getRepositoriosById('Menuconfiguracion', 'menuconfiguracionparentid', $data['hijo']['parentid']);
                foreach($p as $ps) {
                    if($ps->getActivo()) {
                       $hijoactivo = true; 
                    }
                }
                $parent = $dbm->getRepositorioById('Menuconfiguracion', 'menuconfiguracionid', $data['hijo']['parentid']);
                $parent->setActivo($hijoactivo);
                $dbm->saveRepositorio($parent);


            } else {
                $pantalla = $dbm->getRepositorioById('Menuconfiguracion', 'menuconfiguracionid', $data['valor']['menuconfiguracionid']);
                $pantalla->setActivo($data['valor']['activo']);
                $dbm->saveRepositorio($pantalla);

                $p = $dbm->getRepositoriosById('Menuconfiguracion', 'menuconfiguracionparentid', $data['valor']['menuconfiguracionid']);
                foreach($p as $ps) {
                    $ps->setActivo($data['valor']['activo']);
                    $dbm->saveRepositorio($ps);
                }
            }
            $dbm->getConnection()->commit();
            $menus = $dbm->getRepositoriosModelo("Menuconfiguracion", 
            ["d.menuconfiguracionid AS id","IDENTITY(d.menuconfiguracionparentid) AS parentid","d.title","d.sistema","d.key","d.icon","d.color","d.action", "d.orden", "d.activo"], 
            [], ["orden" => "ASC"]);

            foreach($menus as $m) {
                if($m['parentid']) {
                    $arrmenuhijos[] = $m;
                } else {
                    $arrmenupadres[] = $m;
                }
            }

            foreach($arrmenupadres as $m) {
                $childrens = $this->searchForId($m['id'], $arrmenuhijos);
                $arrmenu[] = ["padre" => $m, "hijos" => $childrens];
            }

            return new View(array("mensaje"=>"Se ha guardado el registro", "menus"=> $arrmenu), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

        /**
     * @Rest\Post("/api/ConfiguracionPortal/menus/setActivoAppConfiguracion" , name="setActivoAppConfiguracion")
     */
    public function setActivoAppConfiguracion() {
        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);
        $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
        $dbm->getConnection()->beginTransaction();
        $hijoactivo = false;
        $nivelactivo = false;
        try {
            $pantalla = $dbm->getRepositorioById('Menuconfiguracionapps', 'menuconfiguracionappid', $data['id']);
            if($data['tipo']) {
                $pantalla = $dbm->getOneByParametersRepositorio("Menuconfiguracionappsnivel", [
                    "menuconfiguracionappid" => $data['id'],
                    "nivelid" => $data['tipo']
                ]);
                $pantalla->setActivo($data['valor']);
                $dbm->saveRepositorio($pantalla);
                if(!$data['hijo']) {
                    $parentniveles = $dbm->getRepositoriosById('Menuconfiguracionappsnivel', 'menuconfiguracionappid', $data['id']);
                    foreach ($parentniveles as $paxn) {
                        if($paxn->getActivo()) {
                            $nivelactivo = true;
                        }
                    }
    
                    $pantallasparent = $dbm->getRepositoriosById('Menuconfiguracionapps', 'menuconfiguracionparentid', $data['id']);
                    foreach($pantallasparent as $pp) {
                        $pp->setActivo($nivelactivo);
                        $dbm->saveRepositorio($pp);
                    }
    
                    $pantallaparent = $dbm->getRepositorioById('Menuconfiguracionapps', 'menuconfiguracionappid', $data['id']);
                    $pantallaparent->setActivo($nivelactivo);
                    $dbm->saveRepositorio($pantallaparent);
                }    

                
                if($data['hijo']) {
                    $pantallashijo = $dbm->getRepositoriosModelo("Menuconfiguracionappsnivel", 
                    ["d"], 
        
                        [["nivelid = " . $data['tipo'] . " and mca.menuconfiguracionparentid = " . $data['obj']['parentid']]], false, true, [
                        ["entidad" => "Menuconfiguracionapps", "alias" => "mca", "left" => false, "on" => "d.menuconfiguracionappid = mca.menuconfiguracionappid"]
                    ]);
                    foreach($pantallashijo as $ph) {
                        if($ph->getActivo()) {
                            $hijoactivo = true;
                        }
                    }
                    $parentpantalla = $dbm->getRepositoriosModelo("Menuconfiguracionappsnivel", 
                    ["d"], 
        
                        [["nivelid = " . $data['tipo'] . " and mca.menuconfiguracionappid = " . $data['obj']['parentid']]], false, true, [
                        ["entidad" => "Menuconfiguracionapps", "alias" => "mca", "left" => false, "on" => "d.menuconfiguracionappid = mca.menuconfiguracionappid"]
                    ])[0];
                    $parentpantalla->setActivo($hijoactivo);
                    $dbm->saveRepositorio($parentpantalla);

                    $parentchildpantallas = $dbm->getRepositoriosModelo("Menuconfiguracionappsnivel", 
                    ["d"], 
        
                        [["menuconfiguracionappid is not null and mca.menuconfiguracionappid = " . $data['obj']['menuconfiguracionid']]], false, true, [
                        ["entidad" => "Menuconfiguracionapps", "alias" => "mca", "left" => false, "on" => "d.menuconfiguracionappid = mca.menuconfiguracionappid"]
                    ]);
                
                    $parentchildactive = false;
                    foreach($parentchildpantallas as $prfc) {
                        if($prfc->getActivo()) {
                            $parentchildactive = true;
                        }
                    }

                    $pantallachildparent = $dbm->getRepositorioById('Menuconfiguracionapps', 'menuconfiguracionappid', $data['obj']['menuconfiguracionid']);
                    $pantallachildparent->setActivo($parentchildactive);
                    $dbm->saveRepositorio($pantallachildparent);

                    $parentpantallas = $dbm->getRepositoriosModelo("Menuconfiguracionapps", 
                    ["d"], [["menuconfiguracionparentid = " . $data['obj']['parentid']]], false, true, []);

                    $pactive = false;
                    foreach($parentpantallas as $pas) {
                        if($pas->getActivo()) {
                            $pactive = true;
                        }
                    }

                    $pantallaparent = $dbm->getRepositorioById('Menuconfiguracionapps', 'menuconfiguracionappid', $data['obj']['parentid']);
                    $pantallaparent->setActivo($pactive);
                    $dbm->saveRepositorio($pantallaparent);


                } else {
                    $pantallasparent = $dbm->getRepositoriosModelo("Menuconfiguracionappsnivel", 
                    ["d"], 
        
                        [["nivelid = " . $data['tipo'] . " and mca.menuconfiguracionparentid = " . $data['id']]], false, true, [
                        ["entidad" => "Menuconfiguracionapps", "alias" => "mca", "left" => false, "on" => "d.menuconfiguracionappid = mca.menuconfiguracionappid"]
                    ]);
                    foreach($pantallasparent as $pp) {
                        $pp->setActivo($data['valor']);
                        $dbm->saveRepositorio($pp);
                    }
                }
            } else {
                $pantalla->setActivo($data['valor']);
                $dbm->saveRepositorio($pantalla);
                if($data['hijo']) {
                    $pantallashijo = $dbm->getRepositoriosById('Menuconfiguracionapps', 'menuconfiguracionparentid', $data['obj']['parentid']);
                    foreach($pantallashijo as $ph) {
                        if($ph->getActivo()) {
                            $hijoactivo = true;
                        }
                    }
                    $parentpantalla = $dbm->getRepositorioById('Menuconfiguracionapps', 'menuconfiguracionappid', $data['obj']['parentid']);
                    $parentpantalla->setActivo($hijoactivo);
                    $dbm->saveRepositorio($parentpantalla);

                    $pantallaxnivel = $dbm->getRepositoriosById('Menuconfiguracionappsnivel', 'menuconfiguracionappid', $pantalla->getMenuconfiguracionappid());
                    foreach($pantallaxnivel as $pxn) {
                        $pxn->setActivo($data['valor']);
                        $dbm->saveRepositorio($pxn);
                    }

                } else {
                    $pantallasparent = $dbm->getRepositoriosById('Menuconfiguracionapps', 'menuconfiguracionparentid', $data['id']);
                    foreach($pantallasparent as $pp) {
                        $pp->setActivo($data['valor']);
                        $dbm->saveRepositorio($pp);
                        $pantallaxnivel = $dbm->getRepositoriosById('Menuconfiguracionappsnivel', 'menuconfiguracionappid', $pp->getMenuconfiguracionappid());
                        foreach($pantallaxnivel as $pxn) {
                            $pxn->setActivo($data['valor']);
                            $dbm->saveRepositorio($pxn);
                        }
                    }
                    $pantallaparentxnivel = $dbm->getRepositoriosById('Menuconfiguracionappsnivel', 'menuconfiguracionappid', $pantalla->getMenuconfiguracionappid());
                    foreach($pantallaparentxnivel as $pxn) {
                        $pxn->setActivo($data['valor']);
                        $dbm->saveRepositorio($pxn);
                    }
                }

            }
           
            $dbm->getConnection()->commit();

            $menuconfiguracionapps = $dbm->getRepositoriosModelo("Menuconfiguracionapps", 
            ["d.menuconfiguracionappid, d.menuconfiguracionparentid as parentid, d.sistema, d.title, d.orden, d.activo"], [], ["orden" => "ASC"], false, []);

            foreach($menuconfiguracionapps as $key=>$mca) {
                $niveles = $dbm->getRepositoriosModelo("Menuconfiguracionappsnivel", 
                ["d.menuconfiguracionappnivelid, n.nombre, n.nivelid, d.activo"], ["menuconfiguracionappid" => $mca['menuconfiguracionappid']], false, false, [
                    ["entidad" => "Nivel", "alias" => "n", "left" => false, "on" => "n.nivelid = d.nivelid"]
                ]);
                $menuconfiguracionapps[$key]['niveles'] = $niveles;
            }

            foreach($menuconfiguracionapps as $m) {
                if($m['parentid']) {
                    $arrmenuappshijos[] = $m;
                } else {
                    $arrmenuappspadres[] = $m;
                }
            }

            foreach($arrmenuappspadres as $m) {
                $childrens = $this->searchForId($m['menuconfiguracionappid'], $arrmenuappshijos);
                $arrmenuapps[] = ["padre" => $m, "hijos" => $childrens];
            }


            return new View(array("mensaje"=>"Se ha guardado el registro", "menus"=> $arrmenuapps), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }


    /**
     * @Rest\Post("/api/ConfiguracionPortal/menus/setPeriodoActivo" , name="setPeriodoActivo")
     */
    public function setPeriodoActivo() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $periodo = $dbm->getRepositorioById('CePeriodoactualizacion', 'periodoactualizacionid', $data['periodoactualizacionid']);
            $periodo->setActivo($data['activo']);
            $dbm->saveRepositorio($periodo);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Post("/api/ConfiguracionPortal/menus/setPortalCalificaciones" , name="setPortalCalificaciones")
     */
    public function setPortalCalificaciones() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $pcal = $dbm->getRepositorioById('CeConfiguracionpantallacalificaciones', 'configuracionpantallacalificacionid', $data['configuracionpantallacalificacionid']);
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $pantallacalificaciones = $hydrator->hydrate($pcal, $data);

            $dbm->saveRepositorio($pantallacalificaciones);
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    function searchForId($id, $array) {
        $arry = [];
        foreach ($array as $key => $val) {
            if ($val['parentid'] == $id) {
                $arry[] = $val;
            }
        }
        return $arry;
     }

    /**
     * @Rest\Post("/api/ConfiguracionPortal/menus/guardarPeriodo" , name="guardarPeriodo")
     */
    public function guardarPeriodo() {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $ignorevalidation = false;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $periodox = $dbm->getRepositorioById('CePeriodoactualizacion', 'periodoactualizacionid', $data['periodoactualizacionid']);
            $periodoc = $dbm->getRepositorioById('CePeriodoactualizacion', 'cicloid', $data['cicloid']);
            $periodoactive = $dbm->getRepositorioById('CePeriodoactualizacion', 'activo', 1);

            if(!$periodoactive && $data['activo']) {
                $ignorevalidation = true;
            }


            if($data['periodoactualizacionid']) {
                if ($periodoc && $periodoc->getPeriodoactualizacionid() != $data['periodoactualizacionid']) {
                    return new View("Ya existe un periodo en el mismo ciclo", Response::HTTP_PARTIAL_CONTENT);
                }
            } else {
                if ($periodoc) {
                    return new View("Ya existe un periodo en el mismo ciclo", Response::HTTP_PARTIAL_CONTENT);
                }
            }
            $periodo = $periodox ? $periodox : new CePeriodoactualizacion();
            $periodo->setCicloid($data['cicloid'] ? $dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']) : null);
            $periodo->setFechainicio($data['fechaini'] ? new \DateTime($data['fechaini']) : null);
            $periodo->setFechafin($data['fechaf'] ? new \DateTime($data['fechaf']) : null);
            $periodo->setActivo($data['activo']);
            $dbm->saveRepositorio($periodo);
            
            $periodos = $dbm->getRepositorios('CePeriodoactualizacion');
            if($data['activo']) {
                foreach($periodos as $p) {
                    if($p->getPeriodoactualizacionid() != $periodo->getPeriodoActualizacionid()) {
                        $p->setActivo(false);
                        $dbm->saveRepositorio($p);
                    }
                }
            }

            $periodoactivo = $dbm->getRepositorioById('CePeriodoactualizacion', 'activo',1);
            if(!$ignorevalidation) {
                if(!$periodoactivo) {
                    return new View("Debe haber por lo menos un periodo activo", Response::HTTP_PARTIAL_CONTENT);
                }
            }

            foreach($periodos as $p) {
                if($p->getPeriodoactualizacionid() != $periodoactivo->getPeriodoActualizacionid()) {
                    $p->setActivo(false);
                    $dbm->saveRepositorio($p);
                }
            }

            $dbm->getConnection()->commit();

            $periodoactualizacion = $dbm->getRepositoriosModelo("CePeriodoactualizacion", 
            ["d.periodoactualizacionid","c.cicloid","c.nombre  as ciclo", "d.activo", "DATE_FORMAT(d.fechainicio, '%d/%m/%Y') as fechainicio", "DATE_FORMAT(d.fechafin, '%d/%m/%Y') as fechafin", "DATE_FORMAT(d.fechainicio, '%Y-%m-%d') as fechainicioformat", "DATE_FORMAT(d.fechafin, '%Y-%m-%d') as fechafinformat"], 
            [["periodoactualizacionid is not null"]], false, true, [
                ["entidad" => "Ciclo", "alias" => "c", "left" => false, "on" => "c.cicloid = d.cicloid"],
            ]);

            return new View(array("mensaje" => "Se ha guardado el registro", "datos" => $periodoactualizacion), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/ConfiguracionPortal/menus/deletePeriodo/{id}", name="deletePeriodo")
     */
    public function deletePeriodo($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $periodo = $dbm->getRepositorioById('CePeriodoactualizacion', 'periodoactualizacionid', $id);
            $dbm->removeRepositorio($periodo);
            $dbm->getConnection()->commit();
            $periodoactualizacion = $dbm->getRepositoriosModelo("CePeriodoactualizacion", 
            ["d.periodoactualizacionid","c.cicloid","c.nombre  as ciclo", "d.activo", "DATE_FORMAT(d.fechainicio, '%d/%m/%Y') as fechainicio", "DATE_FORMAT(d.fechafin, '%d/%m/%Y') as fechafin", "DATE_FORMAT(d.fechainicio, '%Y-%m-%d') as fechainicioformat", "DATE_FORMAT(d.fechafin, '%Y-%m-%d') as fechafinformat"], 
            [["periodoactualizacionid is not null"]], false, true, [
                ["entidad" => "Ciclo", "alias" => "c", "left" => false, "on" => "c.cicloid = d.cicloid"],
            ]);

            return new View(array("mensaje" => "Se ha eliminado el registro", "datos" => $periodoactualizacion), Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
