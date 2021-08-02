<?php

namespace AppBundle\Controller\Becas;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David
 */
class AltaAlumnosController extends FOSRestController
{

        /**
     * Retorna filtros alumno
     * @Rest\Get("/api/Altaalumno/", name="IndexAlumnoTemporal")
     */
    public function IndexAlumnoTemporal()
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $niveles = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grados = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $ciclos = $dbm->getRepositoriosById('Ciclo', 'activo', 1);

            return new View(array(
                'ciclo' => $ciclos,
                'nivel' => $niveles,
                'grado' => $grados
            ));
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

 

    /**
     * Convierte una solicitud en un alumno temporal
     * @Rest\Post("/api/Becas/Altaalumno", name="GuardarAlumnoTemporal")
     */
    public function GuardarAlumnoTemporal()
    {
        
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            foreach ($decoded as $alumno) {
                $dbm->agregarAlumnos($alumno);
            }

            return new View("Se han guardado los registros", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina uno o varios alumnos temporales
     * @Rest\Post("/api/Becas/Altaalumno/Eliminar", name="deleteAlumnotemporal")
     */
    public function deleteAlumnotemporal()
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $arraypadres = [];


            $dbm->getConnection()->beginTransaction();
            foreach ($decoded as $alumno) {

                $alumnoclavefamiliar = $dbm->getRepositorioById('CeAlumnoporclavefamiliar', 'alumnoid', $alumno);

                if($alumnoclavefamiliar) { 
                $clavefamiliarid = $alumnoclavefamiliar->getClavefamiliarid()->getClavefamiliarid();
                $becas = $dbm->getRepositoriosById('BcSolicitudbeca', 'clavefamiliarid', $clavefamiliarid);
                foreach($becas as $beca) {
                    $alumnossolicitud = $dbm->getRepositoriosById('BcSolicitudporalumno', 'solicitudid', $beca->getSolicitudid());
                    if(count($alumnossolicitud) <= 1) {
                        if($alumnossolicitud) {
                            $dbm->removeManyRepositorio('BcBecarecomendadaporalumno', 'alumnosolicitudid', $alumnossolicitud[0]->getAlumnosolicitudid()); 
                        }
                        $dbm->removeManyRepositorio('BcCuentabanco', 'solicitudbecaid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcDependienteseconomicoshijos', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcDeudascreditos', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcDomicilioestudiosocioeconomico', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcEgresomensuales', 'solicitudbecaid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcIngresosfamiliares', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcObservacionesestudiose', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcOtrosdependienteseconomicos', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcPadresotutoressolicitud', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcPersonareferencia', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcPropiedadesfamiliares', 'solicitudid', $beca->getSolicitudid());  
                        $dbm->removeManyRepositorio('BcRecibirdocumentos', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcSituacionfamiliar', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcSolicitudbecadictamen', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcSolicitudfamilia', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcSolicitudingresos', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcVehiculos', 'solicitudid', $beca->getSolicitudid());   
                        $dbm->removeManyRepositorio('BcVisitaestudiosocioeconomico', 'solicitudid', $beca->getSolicitudid());    
                        $dbm->removeManyRepositorio('BcRecibirdocumentos', 'solicitudid', $beca->getSolicitudid());
                        $dbm->removeManyRepositorio('BcPadresotutores', 'solicitudid', $beca->getSolicitudid());
                        $solicitudalumno = $dbm->getOneByParametersRepositorio('BcSolicitudporalumno', 
                            ['solicitudid' => $beca->getSolicitudid()]);
                        if($solicitudalumno) { $dbm->removeRepositorio($solicitudalumno); }   

                        $becasalumno = $dbm->getRepositoriosById('BcBecasporsolicitud', 'solicitudid', $beca->getSolicitudid());
                        foreach($becasalumno as $becaalumno) {
                            $becaid = $becaalumno->getBecaid()->getBecaid();
                            $dbm->removeManyRepositorio('BcSolicitudbecadictamen', 'alumnoid', $alumno);
                            $dbm->removeManyRepositorio('BcReconsideracionbeca', 'becaid', $becaid);
                            $dbm->removeRepositorio($becaalumno);
                            $dbm->removeRepositorio($dbm->getRepositorioById('BcBecas', 'becaid', $becaid));
                        }
                        $dbm->removeManyRepositorio('BcProvisionalbecas', 'solicitudid', $beca->getSolicitudid()); 
                        $dbm->removeRepositorio($beca);
                    } else {
                        $solicitudalumno = $dbm->getOneByParametersRepositorio('BcSolicitudporalumno', 
                             ['solicitudid' => $beca->getSolicitudid(), 'alumnoid' => $alumno]);
                        if($solicitudalumno) {
                            $becasalumno = $dbm->BuscarSolicitudes(['solicitudid' => $solicitudalumno->getSolicitudid()->getSolicitudid(), 'alumnoid' => $alumno]);
                            if($becasalumno) {
                                foreach($becasalumno as $becaalumno) {
                                    $becaid = $becaalumno->getBecaid()->getBecaid();
                                    $solicitudalumno = $dbm->getOneByParametersRepositorio('BcSolicitudporalumno', 
                                    ['solicitudid' => $beca->getSolicitudid(), 'alumnoid' => $alumno]);
                                    if($solicitudalumno) { $dbm->removeRepositorio($solicitudalumno); }
    
                                    $dbm->removeManyRepositorio('BcSolicitudbecadictamen', 'alumnoid', $alumno);
                                    $dbm->removeManyRepositorio('BcReconsideracionbeca', 'becaid', $becaid);
                                    $dbm->removeRepositorio($becaalumno);
                                    $dbm->removeRepositorio($dbm->getRepositorioById('BcBecas', 'becaid', $becaid));
                                }
                            } else {
                                $solicitudalumno = $dbm->getOneByParametersRepositorio('BcSolicitudporalumno', 
                                ['solicitudid' => $beca->getSolicitudid(), 'alumnoid' => $alumno]);
                                if($solicitudalumno) { $dbm->removeRepositorio($solicitudalumno); }
                            }

                            $provisionbecas = $dbm->getByParametersRepositorios('BcProvisionalbecas', 
                            ['solicitudid' => $beca->getSolicitudid(), 'alumnoid' => $alumno]);
                            foreach($provisionbecas as $provision) {
                                $dbm->removeRepositorio($provision);
                            }
                        }     
                    }
                }

                $alumnos = $dbm->getRepositoriosById('CeAlumnoporclavefamiliar', 'clavefamiliarid', $clavefamiliarid);
                if(count($alumnos) == 1) {
                
                    $padresporclavefamiliar = $dbm->getRepositoriosById('CePadresotutoresclavefamiliar', 'clavefamiliarid', $clavefamiliarid);

                    foreach($padresporclavefamiliar as $padreporclave) {
                        $dbm->removeRepositorio($padreporclave);
                        $padreclavefamiliar = $dbm->getRepositoriosModelo("CePadresotutoresclavefamiliar", ["IDENTITY(d.padresotutoresid) AS padresotutoresid"], 
                            [["padresotutoresid", ['=', $padreporclave->getPadresotutoresid()],["clavefamiliarid", ['!=', $clavefamiliarid]]]], false,true);
                        if(count($padreclavefamiliar) == 0) {

                            $usuario = $dbm->getRepositorioById('Usuario', 'padreotutorid', $padreporclave->getPadresotutoresid()->getPadresotutoresid());
                            if($usuario) {
                                $dbm->removeManyRepositorio('Cicloporusuario', 'usuarioid', $usuario->getUsuarioid());
                                $dbm->removeManyRepositorio('Sesion', 'usuarioid', $usuario->getUsuarioid());
                                if($usuario->getTipousuarioid()->getTipousuarioid() == 4) {
                                    $dbm->removeRepositorio($usuario);
                                    $dbm->removeRepositorio($padreporclave->getPadresotutoresid());
                                } 
                            } else {
                                $dbm->removeRepositorio($padreporclave->getPadresotutoresid());
                            }
                        }
                    }
    
                    $dbm->removeRepositorio($alumnoclavefamiliar);
                    $dbm->removeRepositorio($alumnoclavefamiliar->getClavefamiliarid());
    
                    } else if (count($alumnos)> 1) {
                        $dbm->removeRepositorio($alumnoclavefamiliar);
                    }
                };
                
                $planpago = $dbm->getRepositorioById('CjPlanpagoporalumno', 'alumnoid', $alumno);
                if($planpago) {
                $planpago->setAlumnoid(null);
                $dbm->saveRepositorio($planpago);
                };

                $dbm->removeManyRepositorio('CeAlumnoporpersonal', 'alumnoid', $alumno);
                $dbm->removeManyRepositorio('CeAlumnotelefono', 'alumnoid', $alumno);
                $dbm->removeManyRepositorio('CeAlumnolugarnacimiento', 'alumnoid', $alumno);
                $dbm->removeManyRepositorio('CeAlumnodomicilio', 'alumnoid', $alumno);
                $dbm->removeManyRepositorio('CeAlumnodinamicafamiliar', 'alumnoid', $alumno);
                $dbm->removeManyRepositorio('CeContactoemergencia', 'alumnoid', $alumno);
                $dbm->removeManyRepositorio('CeAlumnocorreo', 'alumnoid', $alumno);
                $dbm->removeManyRepositorio('CeAlumnodatomedico', 'alumnoid', $alumno);
                $dbm->removeManyRepositorio('CmNotificacionesleidas', 'alumnoid', $alumno);
                $alumnociclo = $dbm->getRepositoriosById('CeAlumnoporciclo', 'alumnoid', $alumno);
                if($alumnociclo) { 
                    foreach($alumnociclo as $ac) {
                        $alumnofoto = $dbm->getRepositorioById('CeAlumnociclofoto', 'alumnoporcicloid', $ac);
                        $dbm->removeRepositorio($alumnofoto);
                        $dbm->removeRepositorio($ac);
                    }
                }

                $solicitud = $dbm->getRepositorioById('Solicitudadmision', 'alumnoid', $alumno);
                $solicitud->setAlumnoid(null);
                $dbm->saveRepositorio($solicitud);

                $dbm->removeManyRepositorio('CeAlumno', 'alumnoid', $alumno);


            
            
            }
            $dbm->getConnection()->commit();
            return new View("Se han eliminado los alumno(s)", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
