<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CeAvisosplataforma;
use AppBundle\Entity\CeAvisosplataformapornivel;
use AppBundle\Entity\CeAvisosporplataformaarchivo;
use AppBundle\Entity\CeAvisosplataformaporperfil;

/**
 * Auto: David
 */
class AvisoPlataformaController extends FOSRestController
{

    /**
     *  Responde con los arreglos iniciales para las listas de los filtros
     * @Rest\Get("/api/Controlescolar/AvisoPlataforma", name="indexAvisoPlataforma")
     */
    public function indexAvisoPlataforma()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $estatus = $dbm->getRepositoriosById('CeAvisosporcaratulaestatus', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $perfiles = $dbm->getRepositoriosById('Perfil', 'activo', 1);


            return new View(
                array(
                    "estatus" => $estatus,
                    "nivel" => $nivel,
                    "perfiles" => $perfiles
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Get("/api/Controlescolar/AvisoPlataforma/Filtrar", name="BuscarAvisos")
     */
    public function getAvisos()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->getAvisosPlataforma($filtros);

            foreach ($entidad as $key => $e) {
                $entidad[$key]['archivos'] = $dbm->getRepositoriosModelo(
                    "CeAvisosporplataformaarchivo",
                    ["d.avisoplataformaarchivoid, d.nombre, d.size, d.tipo"],
                    [["avisoplataformaid = " . $e['avisoplataformaid']]],
                    false,
                    true,
                    []
                );
            }
            if (!$entidad) {
                return new View("No se encontró ningún registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Copia las tareas de un agrupo a otros grupos del mismo profesor
     * @Rest\Post("/api/Controlescolar/AvisoPlataforma/SaveAvisoPlataforma" , name="SaveAvisoPlataforma")
     */
    public function SaveAvisoPlataforma()
    {
        try {
            $content = file_get_contents("php://input");
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            foreach ($data['avisos'] as $a) {
                $avisosc = $dbm->getRepositorioById("CeAvisosplataforma", "avisoplataformaid", $a['avisoplataformaid']);
                $avisoplataforma = $avisosc ? $avisosc : new CeAvisosplataforma();
                $avisoplataforma->setTitulo($a['titulo'] ? $a['titulo'] : null);
                $avisoplataforma->setDescripcion($a['descripcion'] ? $a['descripcion'] : null);
                $avisoplataforma->setFecha($a['fechaformatted'] ?  new \DateTime($a['fechaformatted']) : new \DateTime());
                $avisoplataforma->setHora($a['hora'] ? new \DateTime($a['hora']) : new \DateTime());
                $avisoplataforma->setActivo($a['activo'] ? $a['activo'] : 0);
                $avisoplataforma->setAvisoplataformaestatusid($a['estatusid'] ?
                    $dbm->getRepositorioById("CeAvisosporcaratulaestatus", "avisocaratulaestatusid", $a['estatusid']) : null);
                    $avisoplataforma->setFechafin($a['fechafinformatted'] ?  new \DateTime($a['fechafinformatted']) : new \DateTime());
                $dbm->saveRepositorio($avisoplataforma);

                foreach ($data['eliminados'] as $ar) {
                    $archivo = $dbm->getRepositorioById("CeAvisosporplataformaarchivo", "avisoplataformaarchivoid", $ar['avisoplataformaarchivoid']);
                    $dbm->removeRepositorio($archivo);
                }

                foreach ($a['archivos'] as $ar) {
                    $archivo = $dbm->getRepositorioById("CeAvisosporplataformaarchivo", "avisoplataformaarchivoid", $ar['avisoplataformaarchivoid']);
                    $avisosarchivo = $archivo ? $archivo : new CeAvisosporplataformaarchivo();
                    $avisosarchivo->setAvisoplataformaid($avisoplataforma);
                    if ($ar['contenido']) {
                        $avisosarchivo->setContenido($ar['contenido']);
                    }
                    if ($ar['tipo']) {
                        $avisosarchivo->setTipo($ar['tipo']);
                    }
                    $avisosarchivo->setSize($ar['size']);
                    $avisosarchivo->setNombre($ar['nombre']);
                    $dbm->saveRepositorio($avisosarchivo);
                }

                $dbm->removeManyRepositorio('CeAvisosplataformaporperfil', 'avisoplataformaid', $a['avisoplataformaid']);
                foreach ($a['perfilid'] as $ar) {
                    $perfiles = new CeAvisosplataformaporperfil();
                    $perfiles->setAvisoplataformaid($avisoplataforma);
                    $perfiles->setPerfilid($dbm->getRepositorioById("Perfil", "perfilid", $ar));
                    $dbm->saveRepositorio($perfiles);
                }
                $dbm->removeManyRepositorio('CeAvisosplataformapornivel', 'avisoplataformaid', $a['avisoplataformaid']);
                foreach ($a['nivelid'] as $ar) {
                    $niveles = new CeAvisosplataformapornivel();
                    $niveles->setAvisoplataformaid($avisoplataforma);
                    $niveles->setNivelid($dbm->getRepositorioById("Nivel", "nivelid", $ar));
                    $dbm->saveRepositorio($niveles);
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Controlescolar/AvisoPlataforma/DescargarArchivo/{archivoid}", name="ObtenerAvisoArchivo")
     */
    public function ObtenerAvisoArchivo($archivoid)
    {
        try {
            $datos = $_REQUEST;
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $archivo = $dbm->getRepositorioById("CeAvisosporplataformaarchivo", "avisoplataformaarchivoid", $archivoid);
            $response = new \Symfony\Component\HttpFoundation\Response(
                base64_decode(stream_get_contents($archivo->getContenido())),
                200,
                array(
                    'Content-Type' => $archivo->getTipo(),
                    'Content-Length' => $archivo->getSize()
                )
            );
            $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($archivo->getNombre()) . '";');
            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/AvisoPlataforma/EliminarAviso/{id}", name="deleteAvisoPlataforma")
     */
    public function deleteAvisoPlataforma($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $aviso = $dbm->getRepositorioById('CeAvisosplataforma', 'avisoplataformaid', $id);
            $dbm->removeManyRepositorio('CeAvisosporplataformaarchivo', 'avisoplataformaid', $id);
            $dbm->removeManyRepositorio('CeAvisosplataformaporperfil', 'avisoplataformaid', $id);
            $dbm->removeManyRepositorio('CeAvisosplataformapornivel', 'avisoplataformaid', $id);

            $dbm->removeRepositorio($aviso);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
