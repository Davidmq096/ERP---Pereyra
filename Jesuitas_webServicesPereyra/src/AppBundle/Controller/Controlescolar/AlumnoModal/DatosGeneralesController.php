<?php

namespace AppBundle\Controller\Controlescolar\AlumnoModal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAlergiapordatomedico;
use AppBundle\Entity\CeAlumno;
use AppBundle\Entity\CeAlumnocorreo;
use AppBundle\Entity\CeAlumnodatomedico;
use AppBundle\Entity\CeAlumnolugarnacimiento;
use AppBundle\Entity\CeAlumnotelefono;
use AppBundle\Entity\CeAntecedentefamiliarpordatomedico;
use AppBundle\Entity\CeIntercambioporalumno;
use AppBundle\Entity\CeNacionalidadporalumno;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Gabriel
 */

class DatosGeneralesController extends FOSRestController
{
    /**
     * Obtiene los datos generales del alumno
     * @Rest\Get("/api/Controlescolar/Alumno/DatosGenerales/{id}", name="CEAAlumnoDatosGenerales")
     */
    public function CEAAlumnoDatosGenerales($id)
    {
        try
        {
            $datos = $_REQUEST;
            $filtros = array_filter($datos); //alumnoid
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            //datosgenerales
            $datosgenerales = $dbm->GetDatosGeneralesAlumno($id);
            $hoy = new \DateTime();
            $datetime2 = $datosgenerales["fechanacimiento"];
            $anios = $hoy->diff($datetime2)->y;
            $meses = $hoy->diff($datetime2)->m;
            $edad = $anios . " años " . $meses . " meses";
            $datosgenerales["edad"] = $edad;

            //nacionalidad
            $datosgenerales["nacionalidad"] = $dbm->GetNacionalidadAlumno($id);

            //contacto emergencia
            $contactomergencia = $dbm->GetContactoEmergenciaAlumno($id);

            //siatuacion actual
            $situacionactual = $dbm->GetSituacionActualAlumno($id);
            $situacionactual["fechaegreso"] = $situacionactual["fechabajaegreso"] ? $situacionactual["fechabajaegreso"] : $situacionactual["fechaegreso"];
            $situacionactual["fechaingreso"] = $dbm->GetFechaIngreso($id);

            $alumno = array
                (
                'datosgenerales' => $datosgenerales,
                'contactoemergencia' => $contactomergencia,
                'situacionactual' => $situacionactual,
            );

            return new View($alumno, Response::HTTP_OK);

        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * Guarda los datos generales del alumno
     * @Rest\Post("/api/Controlescolar/Alumno/DatosGenerales", name="GuardarAlumno")
     */
    public function GuardarAlumno()
    {
        try
        {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $decoded['matricula'] = null;
            $alumno = $hydrator->hydrate($decoded["alumnoid"] ? $dbm->getRepositorioById("CeAlumno", "alumnoid", $decoded["alumnoid"]) : new CeAlumno(), $decoded);
            if($decoded['reingresofuturo'] == "0") {
                $alumno->setReingresofuturo(0);
            } else if(!$decoded['reingresofuturo']){
                $alumno->setReingresofuturo(null);
            }
            if(!$decoded['hijopersonal']) {
                $alumno->setHijopersonal(0);
            }
            if(!$decoded['usuarioid']) {
                $alumno->setUsuarioid(null);
            }
            $dbm->saveRepositorio($alumno);
            $lugar = $hydrator->hydrate($dbm->getRepositorioById("CeAlumnolugarnacimiento", "alumnoid", $decoded["alumnoid"]) ? $dbm->getRepositorioById("CeAlumnolugarnacimiento", "alumnoid", $decoded["alumnoid"]) : new CeAlumnolugarnacimiento(), $decoded["lugarnacimiento"]);
            $lugar->setAlumnoid($alumno);
            !$decoded['lugarnacimiento']['paisid'] ? $lugar->setPaisid(null) : null;
            !$decoded['lugarnacimiento']['estadoid'] ? $lugar->setEstadoid(null) : null;
            !$decoded['lugarnacimiento']['municipioid'] ? $lugar->setMunicipioid(null) : null;
            $dbm->saveRepositorio($lugar);
            $cicloactual = $dbm->getRepositorioById("Ciclo", "actual", 1)->getCicloid();
            $alumnoporciclo = $dbm->getByParametersRepositorios("CeAlumnoporciclo", array("alumnoid" => $decoded["alumnoid"], "cicloid" => $decoded["cicloid"]));
            if(!$alumnoporciclo){
                return new View("No existe información relacionada con el alumno.", Response::HTTP_OK);
            }
            $alumnoporciclo = $hydrator->hydrate($alumnoporciclo[0], $decoded);
            $dbm->saveRepositorio($alumnoporciclo);
            $dbm->removeManyRepositorio('CeNacionalidadporalumno', 'alumnoid', $alumno->getAlumnoid());
            foreach ($decoded["nacionalidadid"] as $nacionalidadid) {
                $nacionalidad = new CeNacionalidadporalumno();
                $nacionalidad->setAlumnoid($alumno);
                $nacionalidad->setNacionalidadid($dbm->getRepositorioById("Nacionalidad", "nacionalidadid", $nacionalidadid));
                $dbm->saveRepositorio($nacionalidad);
            }
            $no = array("(", ")", "-");
            $telefono = $dbm->getRepositorioById('CeAlumnotelefono', 'alumnoid', $alumno->getAlumnoid()) ? $dbm->getRepositorioById('CeAlumnotelefono', 'alumnoid', $alumno->getAlumnoid()) : new CeAlumnotelefono();
            $telefono->setAlumnoid($alumno);
            $telefono->setTipotelefonoid(2);
            //$telefono->setTelefono(str_replace($no,"",$decoded["alumnotelefono"]['lada']).str_replace($no,"",$decoded["alumnotelefono"]['telefono']));
            $telefono->setTelefono($decoded["alumnotelefono"]['telefono']);
            $dbm->saveRepositorio($telefono);

            foreach ($decoded["alumnocorreo"] as $co) {
                $correo = $dbm->getRepositorioById('CeAlumnocorreo', 'alumnoid', $alumno->getAlumnoid()) ? $dbm->getRepositorioById('CeAlumnocorreo', 'alumnoid', $alumno->getAlumnoid()) : new CeAlumnocorreo();
                $correo->setAlumnoid($alumno);
                $correo->setCorreo($co['correo']);
                $dbm->saveRepositorio($correo);
            }
            $alumnodatomedico = $dbm->getRepositorioById('CeAlumnodatomedico', 'alumnoid', $alumno->getAlumnoid()) ? $hydrator->hydrate($dbm->getRepositorioById('CeAlumnodatomedico', 'alumnoid', $alumno->getAlumnoid()), $decoded["alumnodatomedico"]) : $hydrator->hydrate(new CeAlumnodatomedico(), $decoded["alumnodatomedico"]);
            $alumnodatomedico->setAlumnoid($alumno);
            //$alumnodatomedico->setContactoemergenciatelefono(str_replace($no,"",$decoded["alumnodatomedico"]["contactoemergenciatelefono"]));
            $alumnodatomedico->setContactoemergenciatelefono($decoded["alumnodatomedico"]["contactoemergenciatelefono"]);
            $dbm->saveRepositorio($alumnodatomedico);

            if ($decoded['intercambio']) {
                $intercambio = new CeIntercambioporalumno();
                $intercambio->setFechainicio(empty($decoded['fechainicio']) ? null :new \DateTime($decoded['fechainicio']));
                $intercambio->setFechafin(empty($decoded['fechafin']) ? null :new \DateTime($decoded['fechafin']));
                $intercambio->setObservaciones(empty($decoded['observaciones']) ? null :($decoded['observaciones']));
                $intercambio->setAlumnoid($alumno);
                $dbm->saveRepositorio($intercambio);
            }

            $dbm->getConnection()->commit();
            return new View("Se guardaron los datos del alumno.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
