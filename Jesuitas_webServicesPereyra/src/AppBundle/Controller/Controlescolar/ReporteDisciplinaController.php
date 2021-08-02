<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\CeReportedisciplina;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\Reporteador\JasperPHP\JasperPHP;

/**
 * Auto: David
 */
class ReporteDisciplinaController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/Reportedisciplina", name="indexReportedisciplina")
     */
    public function indexReportedisciplina()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $grupo = $dbm->getRepositoriosById('CeGrupo', 'tipogrupoid', 1);
            $tipo = $dbm->getRepositoriosById('CeTiporeporte', 'activo', 1);
            $planestudio = $dbm->getRepositoriosById('CePlanestudios', 'vigente', 1);
            $areadis = $dbm->getRepositoriosById('CeAreadisciplina', 'activo', 1);
            $date = new \DateTime();
            $hoy = $date->format('Y/m/d');
            $materias = array();
            foreach ($planestudio as $p) {
                $materias = array_merge(
                    $materias,
                    $dbm->getByParametersRepositorios(
                        'CeMateriaporplanestudios',
                        ['planestudioid' => $p->getPlanestudioid()]
                    )
                );
            }


            return new View(array(
                "ciclo" => $ciclo,
                "nivel" => $nivel,
                "grado" => $grado,
                "semestre" => $semestre,
                "grupos" => $grupo,
                "planestudio" => $planestudio,
                "tipo" => $tipo,
                "materias" => $materias,
                "areadis" => $areadis,
                "fecha" => $hoy
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de estados en base a los parametros enviados
     * @Rest\Get("/api/Controlescolar/Reportedisciplina/Filtrar", name="getReportesdisciplina")
     */
    public function getReportesdisciplina()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $boletas = $dbm->BuscarReportes($filtros);

            if (!$boletas) {
                return new View("No se ha encontrado ningun registro", Response::HTTP_PARTIAL_CONTENT);
            }


            return new View($boletas, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Reportedisciplina" , name="SaveReportedisciplina")
     */
    public function SaveReportedisciplina()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $disciplina = new CeReportedisciplina();
            $disciplina->setObservaciones(empty($data['observaciones']) ? null : $data['observaciones']);
            $disciplina->setFecha(new \DateTime());
            $disciplina->setAlumnoporcicloid(empty($data['alumnoid']) ? null :
                $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $data['alumnoid']));
            $disciplina->setMateriaporplanestudiosid(empty($data['materiaid']) ? null :
                $dbm->getRepositorioById('CeMateriaporplanestudios', 'materiaporplanestudioid', $data['materiaid']));
            $disciplina->setTiporeporteid(empty($data['tiporeporteid']) ? null :
                $dbm->getRepositorioById('CeTiporeporte', 'tiporeporteid', $data['tiporeporteid']));
            $disciplina->setUsuarioid(empty($data['usuarioid']) ? null :
                $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']));
            $disciplina->setAreadisciplinaid(empty($data['areadisciplinaid']) ? null :
                $dbm->getRepositorioById('CeAreadisciplina', 'areadisciplinaid', $data['areadisciplinaid']));    
            $dbm->saveRepositorio($disciplina);
            $dbm->getConnection()->commit();



            $entidad = $disciplina;
            if ($entidad->getTiporeporteid()->getTiporeporteid() == 1) {
                $tipoactividadid = 8;
            }
            if ($entidad->getTiporeporteid()->getTiporeporteid() == 2) {
                $tipoactividadid = 9;
            }
            $usuariodestino = $dbm->getRepositorioById("Usuario", "alumnoid", $entidad->getAlumnoporcicloid()->getAlumnoid()->getAlumnoid());
            $params = [
                "materiaporplanestudioid" => $disciplina->getMateriaporplanestudiosid() ? $disciplina->getMateriaporplanestudiosid()->getMateriaporplanestudioid() : null
            ];
            if ($usuariodestino) {
                $arraypadres = [];
                $clavefamilia = $dbm->getRepositorioById('CeAlumnoporclavefamiliar', 'alumnoid', $usuariodestino->getAlumnoid());
                if ($clavefamilia) {
                    $padres = (array) $dbm->BuscarAlumnoClaves(2, $clavefamilia->getClavefamiliarid()->getClavefamiliarid());
                    foreach ($padres as $p) {
                        if ($p['usuarioid']) {
                            array_push($arraypadres, $p['usuarioid']);
                        }
                    }
                }
                if (count($arraypadres) > 0) {
                    $padresid = implode(",", $arraypadres);
                    $usuariodestino = $padresid . ',' . $usuariodestino->getUsuarioid();
                    $actividad = [
                        "tipoactividadid" => $tipoactividadid,
                        "usuarioorigenid" => $entidad->getUsuarioid()->getUsuarioid(),
                        "usuariodestinoid" => $usuariodestino
                    ];
                    \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad, $entidad, $dbm, $this->get('mailer'), $params);
                }
            }
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Controlescolar/Reportedisciplina/{id}" , name="updateReporteDisciplina")
     */
    public function updateReporteDisciplina($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $disciplina = $dbm->getRepositorioById('CeReportedisciplina', 'reportedisciplinaid', $data['reporteid']);
            $disciplina->setObservaciones(empty($data['observaciones']) ? null : $data['observaciones']);
            $disciplina->setFecha(empty($data['fecha']) ? null : new \DateTime($data['fecha']));
            $disciplina->setMateriaporplanestudiosid(empty($data['materiaid']) ? null :
                $dbm->getRepositorioById('CeMateriaporplanestudios', 'materiaporplanestudioid', $data['materiaid']));
            $disciplina->setTiporeporteid(empty($data['tiporeporteid']) ? null :
                $dbm->getRepositorioById('CeTiporeporte', 'tiporeporteid', $data['tiporeporteid']));
            $disciplina->setUsuarioid(empty($data['usuarioid']) ? null :
                $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']));
            $disciplina->setAreadisciplinaid(empty($data['areadisciplinaid']) ? null :
                $dbm->getRepositorioById('CeAreadisciplina', 'areadisciplinaid', $data['areadisciplinaid']));  
            $dbm->saveRepositorio($disciplina);
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Reportedisciplina/{id}", name="deleteReporteDisciplina")
     */
    public function deleteReporteDisciplina($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();


            $reportedisciplina = $dbm->getRepositorioById('CeReportedisciplina', 'reportedisciplinaid', $id);
            $dbm->removeRepositorio($reportedisciplina);

            $dbm->getConnection()->commit();

            $entidad = $reportedisciplina;
            // $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoporcicloid()->getAlumnoid()->getAlumnoid());
            // if ($usuariodestino){
            //     $usuariodestino=$usuariodestino->getUsuarioid();
            //     $actividad=[
            //         "tipoactividadid"=>10,
            //         "usuarioorigenid"=>$entidad->getUsuarioid(),
            //         "usuariodestinoid"=>$usuariodestino
            //     ];
            //     \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
            // }
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Reportedisciplina/", name="getReporteDisciplinaJasper")
     */
    public function getReporteDisciplinaJasper()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $id = $data["reportedisciplinaid"];
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $reporte = $dbm->getRepositorioById("CeReportedisciplina", "reportedisciplinaid", $id);
            $reportes = $dbm->getRepositoriosById("CeReportedisciplina", "alumnoporcicloid", $reporte->getAlumnoporcicloid()->getAlumnoporcicloid());

            $path = str_replace('app', '', $this->get('kernel')->getRootDir());
            $path = $path . "src/AppBundle/Dominio/Reporteador/Plantillas/";

            switch (ENTORNO) {
                case 1:
                    $logo = $path . "Lux/logonombre.png";
                    $plantilla = "\"" . $path . "Lux/ReporteDisciplina.jrxml\"";
                    break;
                case 2:
                    $logo = $path . "Ciencias/logonombre.png";
                    $plantilla = "\"" . $path . "Ciencias/ReporteDisciplina.jrxml\"";
                    break;
            }


            $jasper = new JasperPHP($this->container);
            $respuesta = $jasper->process(
                $plantilla,
                "\"" . $path . "ReporteDisciplina\"",
                array("pdf"),
                array("reportedisciplinaid" => $id, "noreporte" => count($reportes), "logo" => $logo),
                true
            )->execute();

            $reporte =  "../src/AppBundle/Dominio/Reporteador/Plantillas/ReporteDisciplina.pdf";
            if ($respuesta) {
                return new View($respuesta, Response::HTTP_PARTIAL_CONTENT);
            }
            $response = new \Symfony\Component\HttpFoundation\Response(
                file_get_contents($reporte),
                200,
                array(
                    'Content-Type' => 'application/pdf',
                    'Content-Length' => filesize($reporte)
                )
            );
            return $response;
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
