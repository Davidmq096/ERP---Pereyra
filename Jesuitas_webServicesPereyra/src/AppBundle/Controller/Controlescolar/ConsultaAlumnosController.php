<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeAlumno;
use AppBundle\Entity\CeAlumnoporciclo;
use AppBundle\Entity\CeAlumnocicloporgrupo;
use AppBundle\Entity\CeIntercambioporalumno;
use AppBundle\Entity\CeNacionalidadporalumno;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\CePersonaautorizadarecogerporalumno;
use AppBundle\Entity\CePersonaautorizadarecoger;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Dominio\Reporteador\JasperPHP\LDPDF;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;

/**
 * Auto: David
 */
class ConsultaAlumnosController extends FOSRestController
{

    /**
     * Retorna la siguiente matricula disponible para un alumno oyente
     * @Rest\Get("/api/Controlescolar/ConsultaAlumnos/matriculas", name="indexMatriculas")
     */
    public function indexMatriculas()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos, function ($value) {
                return $value !== '';
            });
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            if($filtros['valor'] == "true") {
                $prefijo = $dbm->getRepositorioById('Parametros', 'parametrosid', 106);
                if (!$prefijo) {
                    return new View("No se ha configurado un prefijo para las matriculas de alumnos oyentes", Response::HTTP_PARTIAL_CONTENT);
                }
                $matriculadisponible = $dbm->BuscarMatriculaAlumnoOyente();
                if (!$matriculadisponible) {
                    $matricula =  $prefijo->getValor() . '-' . (self::zero_fill(1, 4));
                } else {
                    $matlen = strlen($matriculadisponible[0]['matricula']);
                    $matricula = $prefijo->getValor() . '-' . (self::zero_fill((intval($matriculadisponible[0]['matricula']) + 1), 4));
                }
            } else {
                $data = $dbm->UltimaMatriculaAlumno();
                if (!$data) {
                    return new View("No se ha encontrado una matricula de alumno disponible", Response::HTTP_PARTIAL_CONTENT);
                }
                $matricula = intval($data['matricula']) + 1;
            }

            return new View($matricula, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna la siguiente matricula disponible para un alumno oyente
     * @Rest\Get("/api/Controlescolar/ConsultaAlumnos", name="consultaAlumnos")
     */
    public function consultaAlumnos()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos, function ($value) {
                return $value !== '';
            });
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $alumnos = $dbm->BuscarAlumnosA($filtros);
            return new View($alumnos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/ConsultaAlumnos" , name="SaveAlumno")
     */
    public function SaveAlumno()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $matricula = $dbm->getRepositorioById("CeAlumno", "matricula", $data["matricula"]);
            if ($matricula) {
                $data = $dbm->UltimaMatriculaAlumno();
                if (!$data) {
                    return new View(array("msj"=>"Ya existe un alumno con la misma matricula."), Response::HTTP_PARTIAL_CONTENT); 
                }
                $matricula = intval($data['matricula']) + 1;
                return new View(array("msj"=>"Ya existe un alumno con la misma matricula, se ha calculado la nueva matricula: $matricula. Intente guardar nuevamente.", "mat" => $matricula), Response::HTTP_PARTIAL_CONTENT); 

            }

            $alumno = $hydrator->hydrate(new CeAlumno(), $data);
            $dbm->saveRepositorio($alumno);

            $alumnociclo = new CeAlumnoporciclo();
            $alumnociclo->setAlumnoid($alumno);
            $alumnociclo->setCicloid(empty($data['cicloid']) ?
                null : $dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid']));
            $alumnociclo->setGradoid(empty($data['gradoid']) ?
                null : $dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']));
            $alumnociclo->setEstatusalumnocicloid($dbm->getRepositorioById('CeEstatusalumnoporciclo', 'estatusalumnoporcicloid', 1));
            $alumnociclo->setIntencionreinscribirseid($dbm->getRepositorioById('CeIntencionreinscribirse', 'intencionreinscribirseid', 3));
            $dbm->saveRepositorio($alumnociclo);

            foreach ($data['nacionalidadid'] as $c) {
                $nacionalidad = new CeNacionalidadporalumno();
                $nacionalidad->setNacionalidadid(empty($c) ?
                    null : $dbm->getRepositorioById('Nacionalidad', 'nacionalidadid', $c));
                $nacionalidad->setAlumnoid($alumno);
                $dbm->saveRepositorio($nacionalidad);
            }

            if ($data['intercambio'] == 1) {
                $intercambio = new CeIntercambioporalumno();
                $intercambio->setFechainicio(empty($data['fechainicio']) ?
                    null : new \DateTime($data['fechainicio']));
                $intercambio->setFechafin(empty($data['fechafin']) ?
                    null : new \DateTime($data['fechafin']));
                $intercambio->setObservaciones(empty($data['observaciones']) ?
                    null : $data['observaciones']);
                $intercambio->setAlumnoid($alumno);
                $dbm->saveRepositorio($intercambio);
            }


            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/ConsultaAlumnos/Egreso" , name="egresoAlumno")
     */
    public function egresoAlumno()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($data as $a) { 
                $alumno = $dbm->getRepositorioById("CeAlumno", "alumnoid", $a);
                $alumno->setAlumnoestatusid($dbm->getRepositorioById("CeAlumnoestatus", 
                "alumnoestatusid", 3));
                $dbm->saveRepositorio($alumno); 
            }
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza el estatus a baja en uno o varios alumnos
     * @Rest\Post("/api/Controlescolar/ConsultaAlumnos/Baja", name="bajaAlumno")
     */
    public function bajaAlumno()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            foreach ($data['alumnosid'] as $a) {
                $alumno =  $dbm->BuscarAlumnosA(["alumnoid" =>$a]);
                $alumnosciclo =  $dbm->getByParametersRepositorios('CeAlumnoporciclo',  array('cicloid' => $alumno[0]['cicloid'], 'alumnoid' => $alumno[0]['alumnoid']));

                foreach ($alumnosciclo as $ac) {
                    $cealumno =  $dbm->getRepositorioById('CeAlumno', 'alumnoid', $ac->getAlumnoid()->getAlumnoid());
                    $cealumno->setAlumnoestatusid($dbm->getRepositorioById('CeAlumnoestatus', 'alumnoestatusid', 2));
                    $cealumno->setReingresofuturo($data['reingresofuturo'] === 1 ? true : false);
                    $dbm->saveRepositorio($cealumno);

                    $alumnociclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $ac->getAlumnoporcicloid());
                    $alumnociclo->setEstatusalumnocicloid($dbm->getRepositorioById('CeEstatusalumnoporciclo', 'estatusalumnoporcicloid', 3));
                    $alumnociclo->setIntencionreinscribirseid($dbm->getRepositorioById('CeIntencionreinscribirse', 'intencionreinscribirseid', 2));
                    $alumnociclo->setMotivobajaid(empty($data['motivobajaid']) ?
                        null : $dbm->getRepositorioById('CeMotivobaja', 'motivobajaid', $data['motivobajaid']));
                    $alumnociclo->setFechabaja(empty($data['fechabaja']) ?
                        null : new \DateTime($data['fechabaja']));
                    $alumnociclo->setObservacionesbaja(empty($data['observaciones']) ?
                        null : $data['observaciones']);
                    $dbm->saveRepositorio($alumnociclo);
                }
            }

            $dbm->getConnection()->commit();
            return new View("Se ha dado de baja el alumno", Response::HTTP_OK);
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
     * Actualiza el estatus a activo de un alumno
     * @Rest\Post("/api/Controlescolar/ConsultaAlumnos/Reactivar", name="reactivarAlumno")
     */
    public function reactivarAlumno()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $alumno =  $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid']);
            $alumno->setAlumnoestatusid($dbm->getRepositorioById('CeAlumnoestatus', 'alumnoestatusid', 1));
            $alumno->setReingresofuturo(null);
            $dbm->saveRepositorio($alumno);

            $isAlumno = $dbm->getOneByParametersRepositorio(
                'CeAlumnoporciclo',
                array('cicloid' => $data['cicloid'], 'alumnoid' => $data['alumnoid'])
            );

            $gradoactual = $data['gradoid'];

            switch ($gradoactual) {
                case 14:
                case 16:
                    $numeroregistro = 2;
                    $gradosiguiente = $gradoactual;
                    break;
                case 13:
                case 15:
                    $numeroregistro = 2;
                    $gradosiguiente = $gradoactual;
                    break;
                case 19:
                    $numeroregistro = 1;
                    $gradosiguiente = 1;
                    break;
                default:
                    $numeroregistro = 1;
                    $gradosiguiente = $gradoactual;
            }

            for ($i = 0; $i < $numeroregistro; $i++) {
                $alumnociclo = (!$isAlumno ? new CeAlumnoporciclo() : $isAlumno);
                $alumnociclo->setAlumnoid((empty($data['alumnoid']) ?
                    null : $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid'])));
                $alumnociclo->setCicloid((empty($data['cicloid']) ?
                    null : $dbm->getRepositorioById('Ciclo', 'cicloid', $data['cicloid'])));
                $alumnociclo->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $gradosiguiente + $i));
                $alumnociclo->setEstatusalumnocicloid(null);
                $alumnociclo->setIntencionreinscribirseid( $data['intencionreinscribirseid'] ? 
                    $dbm->getRepositorioById('CeIntencionreinscribirse', 'intencionreinscribirseid', $data['intencionreinscribirseid']) : null
                );
                $dbm->saveRepositorio($alumnociclo);
                $isAlumno = null;
            }

            $cicloalumno = $dbm->getOneByParametersRepositorio(
                'CeAlumnoporciclo',
                array('cicloid' => $data['cicloid'], 'alumnoid' => $data['alumnoid'], 'gradoid' => $data['gradoid'])
            );


            $isAlumnogrupo = $dbm->getOneByParametersRepositorio(
                'CeAlumnocicloporgrupo',
                array('alumnoporcicloid' => $cicloalumno->getAlumnoporcicloid())
            );

            $nolista = $dbm->BuscarNolista($data['grupoid']);

            $alumnogrupo = (!$isAlumnogrupo ? new CeAlumnocicloporgrupo() : $isAlumnogrupo);
            $alumnogrupo->setAlumnoporcicloid(empty($cicloalumno->getAlumnoporcicloid()) ?
                null : $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $cicloalumno->getAlumnoporcicloid()));
            $alumnogrupo->setGrupoid((empty($data['grupoid']) ?
                null : $dbm->getRepositorioById('CeGrupo', 'grupoid', $data['grupoid'])));
            $alumnogrupo->setNumerolista($nolista ? $nolista[0]['nolista'] + 1 : 1);
            $dbm->saveRepositorio($alumnogrupo);

            $dbm->getConnection()->commit();

            $usuario = $dbm->getRepositorioById('Usuario', 'alumnoid', $data['alumnoid']);
            if (!$usuario) {
                $urlusuario = $dbm->getRepositorioById('Parametros', 'nombre', 'ServicioUsuario');
                $usuarioAutenticado = $dbm->getRepositorioById('Usuario', 'usuarioid', $data['usuarioid']);
                $newusuario = [
                    "Usuario" => [
                        "UsuarioId" => 0,
                        "PersonaId" => null,
                        "AlumnoId" => $data['alumnoid'],
                        "ProfesorId" => null,
                        "PadreoTutorid" => null,
                        "TipoUsuarioId" => 3,
                        "Cuenta" => ENTORNO == 1 ? ('a' . $alumno->getMatricula() . '@lux.org.mx') : ('a' . $alumno->getMatricula() . '@idec.edu.mx'),
                        "Contrasena" => $alumno->getMatricula(),
                        "ID" => $alumno->getMatricula(),
                        "ReiniciarContrasena" => 0,
                        "Activo" => 1,
                        "UsuarioEnmascarado" => null
                    ],
                    "UsuarioAutenticado" => [
                        "Cuenta" => $usuarioAutenticado->getCuenta()
                    ],
                    "Perfiles" => [],
                    "Permisos" => [],
                    "Grados" => [],
                    "Ciclos" => []
                ];

                $datosusuario = json_encode($newusuario);
                $headers = array('Content-Type:application/json', 'Content-Length:' . strlen($datosusuario));
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $urlusuario->getValor());
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datosusuario);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $response  = curl_exec($ch);
                $err = curl_errno($ch);
                curl_close($ch);
                if ($err == 1) {
                    return new View("Ocurrio un error en la generación del usuario: ". $response, Response::HTTP_PARTIAL_CONTENT);
                    echo "cURL Error #:" ;
                }                
            }

            
            return new View("Se ha reactivado el alumno", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza el estatus a activo de un alumno
     * @Rest\Post("/api/Controlescolar/ConsultaAlumnos/CambiarGrado", name="cambiarGradoAlumno")
     */
    public function cambiarGradoAlumno()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $alumno = $dbm->BuscarAlumnosA(["alumnoid" => $data['alumnoid']]);
            $alumnociclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumno[0]['alumnoporcicloid']);
            $alumnociclo->setAlumnoid((empty($data['alumnoid']) ?
                null : $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid'])));
            $alumnociclo->setGradoid($dbm->getRepositorioById('Grado', 'gradoid', $data['gradoid']));
            $alumnociclo->setMotivobajaid(
                $dbm->getRepositorioById('CeMotivobaja', 'motivobajaid', $data['motivobajaid'])
            );
            $dbm->saveRepositorio($alumnociclo);
            $dbm->removeManyRepositorio('CeAlumnocicloporgrupo', 'alumnoporcicloid', $alumno[0]['alumnoporcicloid']);
            $dbm->removeManyRepositorio('CeAlumnocicloportaller', 'alumnoporcicloid', $alumno[0]['alumnoporcicloid']);

            $dbm->getConnection()->commit();
            return new View("Se ha cambiado de grado al alumno", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Guarda una persona autorizada a recoger por alumno
     * @Rest\Post("/api/Controlescolar/ConsultaAlumnos/Personarecoge", name="savePersonaautorizadarecoger")
     */
    public function savePersonaautorizadarecoger()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $persona = new CePersonaautorizadarecoger();
            $persona->setNombre((empty($data['nombre']) ?  null : $data['nombre']));
            $persona->setParentescoid((empty($data['parentescoid']) ?
                null : $dbm->getRepositorioById('Parentesco', 'parentescoid', $data['parentescoid'])));
            $dbm->saveRepositorio($persona);

            $perporalumno = new CePersonaautorizadarecogerporalumno();
            $perporalumno->setAlumnoid((empty($data['alumnoid']) ?
                null : $dbm->getRepositorioById('CeAlumno', 'alumnoid', $data['alumnoid'])));
            $perporalumno->setPersonaautorizadarecogerid($persona);
            $dbm->saveRepositorio($perporalumno);


            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna las persona autorizadas a recoger por alumno
     * @Rest\Get("/api/Controlescolar/ConsultaAlumnos/Personarecoge/{id}", name="getPersonaautorizadarecoger")
     */
    public function getPersonaautorizadarecoger($id)
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos, function ($value) {
                return $value !== '';
            });

            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $personasrecoge = $dbm->getRepositoriosById('CePersonaautorizadarecogerporalumno', 'alumnoid', $id);
            return new View($personasrecoge, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }
}
