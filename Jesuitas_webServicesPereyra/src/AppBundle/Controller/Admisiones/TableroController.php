<?php

namespace AppBundle\Controller\Admisiones;

use AppBundle\DB\DbmAdmisiones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use AppBundle\Entity\AdConfiguracion;
use AppBundle\Entity\AdConfiguracionporgrado;
use AppBundle\Entity\AdSeccion;

/**
 * Auto: Javier
 */
class TableroController extends FOSRestController
{
    /**
     * Reotorna valores iniciales
     * @Rest\Get("/api/Tablero", name="tablero")
     */
    public function indexAction(Request $request)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $ciclos = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
        $tableros = $dbm->getRepositoriosById('AdTablero', 'activo', 1);
        $origen = $dbm->getRepositoriosById('AdOrigencampo', 'activo', 1);
        $grados = $dbm->getRepositoriosById('Grado', 'activo', 1);
        $preguntaporevaluacion = $dbm->getRepositorios('Preguntaporevaluacion');
        $niveles = $dbm->getRepositoriosById('Nivel', 'activo', 1);
        $datosIniciales = $dbm->getTableroDatosIniciales();
        $data = [
            'ciclo' => $ciclos,
            'tablero' => $tableros,
            'grado' => $grados,
            'nivel' => $niveles,
            'origen' => $origen,
            'preguntas' => $preguntaporevaluacion,
            'datos_iniciales' => $datosIniciales
        ];
        return new View($data, Response::HTTP_OK);
    }

    /**
     * Reotorna valores iniciales
     * @Rest\Get("/api/Tablero/Configuraciones", name="Configuraciones")
     */
    public function Configuraciones(Request $request)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $datos = $_REQUEST;
        $filtros = array_filter($datos);
        $configuraciones = $dbm->getBusquedaTableroPorFiltros($filtros);
        if (count($configuraciones) == 0) {
            return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
        }
        return new View($configuraciones, Response::HTTP_OK);
    }

    /**
     * Reotorna valores iniciales
     * @Rest\Get("/api/Tablero/SolicitudAmision", name="SolicitudAmision")
     */
    public function SolicitudAmision(Request $request)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $datos = $_REQUEST;
        $filtros = array_filter($datos);
        $solicitudporciclo = end($dbm->getRepositoriosById('Solicitudadmisionporciclo', 'solicitudadmisionid', $datos['solicitudadmisionid']));
        $solicitud = $dbm->getRepositorioById('Solicitudadmision', 'solicitudadmisionid', $datos['solicitudadmisionid']);
        $filtros['cicloid'] = $solicitudporciclo->getCicloid()->getCicloId();
        $filtros['gradoid'] = [$solicitud->getGradoId()->getGradoId()];
        $configuraciones = $dbm->getBusquedaTableroPorFiltros($filtros);
        if(count($configuraciones) == 0){
            return new View("No se han configurado los tableros para el ciclo y el grado de la solicitud ", Response::HTTP_PARTIAL_CONTENT);
        }
        $configuracion = $dbm->getTablero($configuraciones[0]['configuracionid']);
        $data = [];
        foreach($configuracion['secciones'] as $seccion){
            $preview = $dbm->vistaprevia($seccion['query'], $filtros['solicitudadmisionid']);
            $data[] = [
                'nombre' => $seccion['nombre'],
                'data' => $preview['data'],
                'keys' => $preview['keys'],
                'tipos' => $seccion['parametros']
            ];
        }
        return new View($data, Response::HTTP_OK);
    }

    

    /**
     * Reotorna valores iniciales
     * @Rest\Get("/api/Tablero/Configuracion/{id}", name="Configuracion")
     */
    public function Configuracion($id)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $configuracion = $dbm->getTablero($id);
        if(!$configuracion){
            return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
        }
        return new View($configuracion, Response::HTTP_OK);
    }

    /**
     * Reotorna valores iniciales
     * @Rest\Post("/api/Tablero/vistaprevia", name="vistaprevia")
     */
    public function vistaprevia(Request $request)
    {
        $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
        $datos = file_get_contents('php://input');
        $data = json_decode($datos, true);
        $preview = $dbm->vistaprevia($data['query']);
        return new View($preview, Response::HTTP_OK);
    }

    /**
     * Reotorna valores iniciales
     * @Rest\Post("/api/Tablero/copiar", name="copiar")
     */
    public function copiar(Request $request)
    {
        try{
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = file_get_contents('php://input');
            $data = json_decode($datos, true);
            foreach($data['tableros'] as $tablero){
                $tab = $dbm->getTablero($tablero);
                $tab['configuracionid'] = NULL;
                $tab['cicloid'] = $data['cicloid'];
                $configuracion = new AdConfiguracion();
                $configuracion->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $tab['cicloid']));
                $configuracion->setNivelid($dbm->getRepositorioById('Nivel', 'nivelid', $tab['nivelid']));
                $configuracion->setTableroid($dbm->getRepositorioById('AdTablero', 'tableroid', $tab['tableroid']));
                $dbm->saveRepositorio($configuracion);

                foreach($tab['gradoid'] as $grado){
                    $configuracionporgrado = new AdConfiguracionporgrado();
                    $configuracionporgrado->setConfiguracionid($configuracion);
                    $configuracionporgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                    $dbm->saveRepositorio($configuracionporgrado);
                }
                foreach($tab['secciones'] as $grupo){
                    $grupo['seccionid'] = NULL;
                    $seccion = new AdSeccion();
                    $seccion->setConfiguracionid($configuracion);
                    $seccion->setConfiguracion($grupo['configuracion']);
                    $seccion->setQuery($grupo['query']);
                    $seccion->setNombre($grupo['nombre']);
                    $seccion->setPropiedades($grupo['parametros']);
                    $dbm->saveRepositorio($seccion);
                }

            }
            return new View("Se han clonado los tableros al ciclo seleccionado", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reotorna valores iniciales
     * @Rest\Delete("/api/Tablero/eliminarConfiguracion/{id}", name="eliminarConfiguracion")
     */
    public function eliminarConfiguracion($id)
    {
        try{
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $configuracion = $dbm->getRepositorioById('AdConfiguracion', 'configuracionid', $id);
            if($configuracion){
                $grados = $dbm->getByParametersRepositorios('AdConfiguracionporgrado', [
                    'configuracionid' => $id
                ]);

                if($grados){
                    foreach($grados as $grado){
                        $dbm->removeRepositorio($grado);
                    }
                }

                $secciones = $dbm->getByParametersRepositorios('AdSeccion', [
                    'configuracionid' => $id
                ]);

                if($secciones){
                    foreach($secciones as $seccion){
                        $dbm->removeRepositorio($seccion);
                    }
                }

                $dbm->removeRepositorio($configuracion);
            }
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reotorna valores iniciales
     * @Rest\Post("/api/Tablero/CrearConfiguracion", name="CrearConfiguracion")
     */
    public function CrearConfiguracion(Request $request)
    {
        try{
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = file_get_contents('php://input');
            $data = json_decode($datos, true);

            $filtros = [
                'cicloid' => $data['cicloid'],
                'gradoid' => $data['gradoid'],
                'tableroid' => [$data['tableroid']]
            ];

            $configuraciones = $dbm->getBusquedaTableroPorFiltros($filtros);
            /*if(count($configuraciones) > 0){
                return new View("Ya existe una configuracion de tableros para el ciclo y grado seleccionados", Response::HTTP_PARTIAL_CONTENT);
            }*/


            $configuracion = new AdConfiguracion();
            $configuracion->setCicloid($dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']));
            $configuracion->setNivelid($dbm->getRepositorioById('Nivel', 'nivelid', $data['nivelid']));
            $configuracion->setTableroid($dbm->getRepositorioById('AdTablero', 'tableroid', $data['tableroid']));
            $dbm->saveRepositorio($configuracion);

            foreach($data['gradoid'] as $grado){
                $configuracionporgrado = new AdConfiguracionporgrado();
                $configuracionporgrado->setConfiguracionid($configuracion);
                $configuracionporgrado->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $grado));
                $dbm->saveRepositorio($configuracionporgrado);
            }

            foreach($data['grupos'] as $grupo){
                $seccion = new AdSeccion();
                $seccion->setConfiguracionid($configuracion);
                $seccion->setConfiguracion(json_encode($grupo['configuracion']));
                $seccion->setQuery($grupo['query']);
                $seccion->setNombre($grupo['nombre']);
                $seccion->setPropiedades(json_encode($grupo['parametros']));
                $dbm->saveRepositorio($seccion);
            }
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reotorna valores iniciales
     * @Rest\Put("/api/Tablero/EditarConfiguracion", name="EditarConfiguracion")
     */
    public function EditarConfiguracion(Request $request)
    {
        try{
            $dbm = new DbmAdmisiones($this->get("db_manager")->getEntityManager());
            $datos = file_get_contents('php://input');
            $data = json_decode($datos, true);
            $configuracion = $dbm->getRepositorioById('AdConfiguracion', 'configuracionid', $data['configuracionid']);

            if(!$configuracion){
                return new View("No he ha encontrado el registro", Response::HTTP_PARTIAL_CONTENT);
            }

            foreach($data['eliminados'] as $eliminado){
                $el = $dbm->getRepositorioById('AdSeccion', 'seccionid', $eliminado);
                if($el){
                    $dbm->removeRepositorio($el);
                }
            }
            foreach($data['grupos'] as $grupo){
                if($grupo['seccionid']){
                    $seccion = $dbm->getRepositorioById('AdSeccion', 'seccionid', $grupo['seccionid']);
                    $seccion->setConfiguracion(json_encode($grupo['configuracion']));
                    $seccion->setQuery($grupo['query']);
                    $seccion->setNombre($grupo['nombre']);
                    $seccion->setPropiedades(json_encode($grupo['parametros']));
                    $dbm->saveRepositorio($seccion);
                }else{
                    $seccion = new AdSeccion();
                    $seccion->setConfiguracionid($configuracion);
                    $seccion->setConfiguracion(json_encode($grupo['configuracion']));
                    $seccion->setQuery($grupo['query']);
                    $seccion->setNombre($grupo['nombre']);
                    $seccion->setPropiedades(json_encode($grupo['parametros']));
                    $dbm->saveRepositorio($seccion);
                }
            }
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}