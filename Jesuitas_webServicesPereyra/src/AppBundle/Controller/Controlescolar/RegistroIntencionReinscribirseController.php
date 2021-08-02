<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAlumnoporciclo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Javier
 */
class RegistroIntencionReinscribirseController extends FOSRestController
{

    /**
     * Retorna parametros iniciales
     * @Rest\Get("/api/ControlEscolar/IntencionReinscribirse", name="indexIntencionReinscribirse")
     */
    public function indexIntencionReinscribirse()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $ciclo = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $grado = $dbm->getRepositoriosById('Grado', 'activo', 1);
            $semestre = $dbm->getRepositoriosById('CeSemestre', 'activo', 1);
            $intencionreinscribirse = $dbm->getRepositoriosById('CeIntencionreinscribirse', 'activo', 1);

            $filtro = array(
                'ciclo' => $ciclo,
                'nivel' => $nivel,
                'grado' => $grado,
                'semestre' => $semestre,
                'intencionreinscribirse' => $intencionreinscribirse,
            );

            return new View($filtro, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna busqueda de registros
     * @Rest\Post("/api/ControlEscolar/IntencionReinscribirse", name="buscarIntencionReinscribirse")
     */
    public function buscarIntencionReinscribirse()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $entidad = $dbm->GetAlumnoporCiclo($data, true);
            foreach ($entidad as $key => $e) {
                switch ($e["gradoiddestino"]) {
                    case 13:
                    case 14:
                        $semestre1 = $dbm->getRepositorioById('Grado', 'gradoid', 13);
                        $semestre2 = $dbm->getRepositorioById('Grado', 'gradoid', 14);
                        $entidad[$key]["gradodestino"] = $semestre1->getGrado() . ", " . $semestre2->getGrado();
                        break;
                    case 15:
                    case 16:
                        $semestre1 = $dbm->getRepositorioById('Grado', 'gradoid', 15);
                        $semestre2 = $dbm->getRepositorioById('Grado', 'gradoid', 16);
                        $entidad[$key]["gradodestino"] = $semestre1->getGrado() . ", " . $semestre2->getGrado();
                        break;
                    case 17:
                    case 18:
                        $semestre1 = $dbm->getRepositorioById('Grado', 'gradoid', 17);
                        $semestre2 = $dbm->getRepositorioById('Grado', 'gradoid', 18);
                        $entidad[$key]["gradodestino"] = $semestre1->getGrado() . ", " . $semestre2->getGrado();
                        break;
                }
            }
            if (!$entidad) {
                return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna crea registros
     * @Rest\Post("/api/ControlEscolar/IntencionReinscribirse/", name="insertarIntencionReinscribirse")
     */
    public function insertarIntencionReinscribirse()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $ciclosiguiente = $dbm->getRepositorioById('Ciclo', 'siguiente', 1);
            if (!$ciclosiguiente) {
                return new View("No se ha configurado el ciclo siguiente", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->getConnection()->beginTransaction();
            foreach ($data["alumnoporcicloid"] as $ac) {
                $alumnoporcicloactual = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $ac);

                $gradoactual = $alumnoporcicloactual->getGradoid()->getGradoid();
                if ($gradoactual == 17 || $gradoactual == 18) {
                    return new View("La matricula " . $alumnoporcicloactual->getAlumnoid()->getMatricula() .
                        " se encuentra actualmente en el ultimo grado disponible.", Response::HTTP_PARTIAL_CONTENT);
                }

                $alumnoporciclosiguiente = $dbm->getOneByParametersRepositorio('CeAlumnoporciclo', array("cicloid" => $ciclosiguiente, "alumnoid" => $alumnoporcicloactual->getAlumnoid()));
                if ($alumnoporciclosiguiente) {
                    return new View("Ya existe un registro de la matricula " . $alumnoporciclosiguiente->getAlumnoid()->getMatricula .
                        " para el ciclo " . $ciclosiguiente->getNombre(), Response::HTTP_PARTIAL_CONTENT);
                }

                switch ($gradoactual) {
                    case 12:
                    case 14:
                    case 16:
                        $numeroregistro = 2;
                        $gradosiguiente = $gradoactual + 1;
                        break;
                    case 13:
                    case 15:
                        $numeroregistro = 2;
                        $gradosiguiente = $gradoactual + 2;
                        break;
                    case 19:
                        $numeroregistro = 1;
                        $gradosiguiente = 1;
                        break;
                    default:
                        $numeroregistro = 1;
                        $gradosiguiente = $gradoactual + 1;
                }

                for ($i = 0; $i < $numeroregistro; $i++) {
                    $alumnoporciclo = new CeAlumnoporciclo();
                    $alumnoporciclo->setAlumnoid($alumnoporcicloactual->getAlumnoid());
                    $alumnoporciclo->setCicloid($ciclosiguiente);
                    $alumnoporciclo->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $gradosiguiente + $i));
                    $alumnoporciclo->setIntencionreinscribirseid($dbm->getRepositorioById('CeIntencionreinscribirse', 'intencionreinscribirseid', $data["intencionreinscribirseid"]));
                    $dbm->saveRepositorio($alumnoporciclo);
                    $entidad=$dbm->getRepositorioById("CeAlumnoporciclo","alumnoporcicloid",$alumnoporciclo->getAlumnoporcicloid());
                    $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                    if ($usuariodestino){
                        $usuariodestino=$usuariodestino->getUsuarioid();
                        $actividad=[
                            "tipoactividadid"=>27,
                            "usuariodestinoid"=>$usuariodestino
                        ];
                        \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
                    }
                    $alumnoporciclo->setCorreoenviado(1);
                    $dbm->saveRepositorio($alumnoporciclo);
                    
                    
                }
            }
            $dbm->getConnection()->commit();

            

            return new View("Se han guardado los registros.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Reenvia las notificaciones de reinscripcion
     * @Rest\Post("/api/ControlEscolar/ReenviarNotificaciones", name="ReenviarNotificaciones")
     */
    public function ReenviarNotificaciones()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $dbm->getConnection()->beginTransaction();
            foreach ($data["alumnoporcicloid"] as $ac) {
                    $entidad=$dbm->getRepositorioById("CeAlumnoporciclo","alumnoporcicloid",$ac);
                    $usuariodestino=$dbm->getRepositorioById("Usuario","alumnoid",$entidad->getAlumnoid()->getAlumnoid());
                    if (!$usuariodestino){
                        return new View("Uno de los alumnos no tienen un usuario asignado", Response::HTTP_PARTIAL_CONTENT);
                    }
                    $actividad=[
                        "tipoactividadid"=>27,
                        "usuariodestinoid"=>$usuariodestino->getUsuarioid()
                    ];
                    \AppBundle\Dominio\RegistroActividad::ActividadAlumno($actividad,$entidad,$dbm,$this->get('mailer'), null);
                    $entidad->setCorreoenviado(1);
                    $dbm->saveRepositorio($entidad);


            }
            $dbm->getConnection()->commit();

            

            return new View("Se reenviaron las .", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna edita registros
     * @Rest\Put("/api/ControlEscolar/IntencionReinscribirse/", name="editarIntencionReinscribirse")
     */
    public function editarIntencionReinscribirse()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);

            $dbm->getConnection()->beginTransaction();
            $alumnoporciclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $data["alumnoporcicloid"]);
            if ($alumnoporciclo->getGradoid()->getNivelid()->getNivelid() == 4) {
                $registros = $dbm->getByParametersRepositorios(
                    'CeAlumnoporciclo',
                    array("alumnoid" => $alumnoporciclo->getAlumnoid(), "cicloid" => $alumnoporciclo->getCicloid())
                );
                foreach ($registros as $alumnoporciclo) {
                    $alumnoporciclo->setIntencionreinscribirseid($dbm->getRepositorioById('CeIntencionreinscribirse', 'intencionreinscribirseid', $data["intencionreinscribirseid"]));
                    $dbm->saveRepositorio($alumnoporciclo);
                }
            } else {
                $alumnoporciclo->setIntencionreinscribirseid($dbm->getRepositorioById('CeIntencionreinscribirse', 'intencionreinscribirseid', $data["intencionreinscribirseid"]));
                $dbm->saveRepositorio($alumnoporciclo);
            }
            $dbm->getConnection()->commit();

            return new View("Se ha editado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Crea todos los registros del ciclo actual al ciclo siguiente
     * @Rest\Post("/api/ControlEscolar/IntencionReinscribirse/Copia", name="copiarIntencionReinscribirse")
     */
    public function copiarIntencionReinscribirse()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            $ciclosiguiente = $dbm->getRepositorioById('Ciclo', 'siguiente', 1);
            if (!$ciclosiguiente) {
                return new View("No se ha configurado el ciclo siguiente", Response::HTTP_PARTIAL_CONTENT);
            }
            $cicloactual = $dbm->getRepositorioById('Ciclo', 'actual', 1);
            if (!$cicloactual) {
                return new View("No se ha configurado el ciclo actual", Response::HTTP_PARTIAL_CONTENT);
            }
            $alumnoporcicloactual = $dbm->GetAlumnoporCiclo(array('cicloid' => $cicloactual->getCicloid(), "alumnoreinscripcion" => true));
            if (sizeof($alumnoporcicloactual) == 0) {
                return new View("Todos los alumnos del ciclo actual ya han sido agregados al ciclo siguiente", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            foreach ($alumnoporcicloactual as $ac) {
                $alumnoporciclosiguiente = $dbm->getOneByParametersRepositorio('CeAlumnoporciclo', array("cicloid" => $ciclosiguiente, "alumnoid" => $ac["alumnoid"]));
                if (!$alumnoporciclosiguiente) {
                    $gradoactual = $ac["gradoid"];
                    if ($gradoactual != 17 && $gradoactual != 18) {
                        switch ($gradoactual) {
                            case 12:
                            case 14:
                            case 16:
                                $numeroregistro = 2;
                                $gradosiguiente = $gradoactual + 1;
                                break;
                            case 13:
                            case 15:
                                $numeroregistro = 2;
                                $gradosiguiente = $gradoactual + 2;
                                break;
                            case 19:
                                $numeroregistro = 1;
                                $gradosiguiente = 1;
                                break;
                            default:
                                $numeroregistro = 1;
                                $gradosiguiente = $gradoactual + 1;
                                break;
                        }
                        for ($i = 0; $i < $numeroregistro; $i++) {
                            $alumnoporciclo = new CeAlumnoporciclo();
                            $alumnoporciclo->setAlumnoid($dbm->getRepositorioById("CeAlumno", "alumnoid", $ac["alumnoid"]));
                            $alumnoporciclo->setCicloid($ciclosiguiente);
                            $alumnoporciclo->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $gradosiguiente + $i));
                            $alumnoporciclo->setEstatusalumnocicloid(null);
                            $alumnoporciclo->setIntencionreinscribirseid($dbm->getRepositorioById('CeIntencionreinscribirse', 'intencionreinscribirseid', 1));
                            $dbm->saveRepositorio($alumnoporciclo);
                        }
                    }
                }
            }
            $dbm->getConnection()->commit();
            return new View("Se han guardado los registros.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
