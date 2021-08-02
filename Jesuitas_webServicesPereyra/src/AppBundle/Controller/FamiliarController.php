<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeClavefamiliar;
use AppBundle\Entity\CePadresotutoresclavefamiliar;
use AppBundle\Entity\CeAlumnoporclavefamiliar;


/**
 * Auto: javier
 */
class FamiliarController extends FOSRestController {

	/**
	 * Retorna arreglo de familias en base a los parametros enviados
	 * @Rest\Get("/api/Familia/", name="BuscarFamilia")
	 */
	public function getFamilia() {
		try {
			$datos = $_REQUEST;
			$filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarAlumnosPorFamilias($filtros);
			if (!$entidad) {
				return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
			}
			return new View($entidad, Response::HTTP_OK);
		} catch (Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

	/**
     * 
     * @Rest\Get("/api/Controlescolar/Famlia", name="indexFamilia")
     */
    public function indexFamilia()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $situacion = $dbm->getRepositoriosById('CeSituacionfamiliar', 'activo', 1);
			$parentesco = $dbm->getRepositorios('Tutor');
            return new View(
                array(
					"situacion" => $situacion,
					"parentesco" => $parentesco
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

		/**
	 * 
	 * @Rest\Get("/api/Controlescolar/Familia/Filtrar", name="BuscarClaves")
	 */
	public function getClaves() {
		try {
			$datos = $_REQUEST;
			$filtros = array_filter($datos);
			$dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$entidad = $dbm->BuscarClavesfamiliares($filtros);
			if (!$entidad) {
				return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
			}
			return new View($entidad, Response::HTTP_OK);
		} catch (Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}



	/**
	 * Retorna arreglo de padres o tutores en base a los parametros enviados
	 * @Rest\Get("/api/Controlescolar/Familia/Padres", name="BuscarPadres")
	 */
	public function getPadres() {
		try {
			$datos = $_REQUEST;
			$filtros = array_filter($datos);
			$dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$entidad = $dbm->BuscarPadresFamilia($filtros);
			if (!$entidad) {
				return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
			}
			return new View($entidad, Response::HTTP_OK);
		} catch (Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

	/**
	 * Retorna arreglo de padres o tutores en base a los parametros enviados
	 * @Rest\Get("/api/Controlescolar/Familia/Alumnofamilia", name="BuscarAlumnoFamilia")
	 */
	public function getAlumnoFamilia() {
		try {
			$datos = $_REQUEST;
			$alumnos = array();
			$filtros = array_filter($datos);
			$dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$clavefamilia = $dbm->getRepositorioById('CeClavefamiliar', 'clavefamiliarid', $filtros['clavefamiliarid']);
			$alumnosid = (array)  $dbm->BuscarAlumnoClaves(1,$filtros['clavefamiliarid']);
			foreach($alumnosid AS $j){
				array_push($alumnos, ($dbm->BuscarAlumnosA(array("alumnoid" => $j['alumnoid'])))[0]);
			}
			$listaalum = count($alumnos);

			for ($i=0; $i < $listaalum; $i++) { 
				(array)$alumnos[$i]['familias'] = $dbm->BuscarAlumnoPadreFamilia(1,$alumnos[$i]['alumnoid'],null);
			}

			$padres = (array)  $dbm->BuscarAlumnoClaves(2,$filtros['clavefamiliarid']);
			$listapadres = count($padres);

			for ($i=0; $i < $listapadres; $i++) { 
				(array)$padres[$i]['familias'] = $dbm->BuscarAlumnoPadreFamilia(2,$padres[$i]['padresotutoresid'],null);
			}


			return new View(array(
				"clavefamiliar" => $clavefamilia,
				"alumnos" => $alumnos,
				"padres" => $padres
			)
			, Response::HTTP_OK);
		} catch (Exception $e) {
			return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

	/**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Familia/{id}", name="EliminarFamilia")
     */
    public function deleteFamilia($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$dbm->getConnection()->beginTransaction();
			$dbm->removeManyRepositorio('CePadresotutoresclavefamiliar', 'clavefamiliarid', $id);
			$dbm->removeManyRepositorio('CeAlumnoporclavefamiliar', 'clavefamiliarid', $id);
            $clave = $dbm->getRepositorioById('CeClavefamiliar', 'clavefamiliarid', $id);
            $dbm->removeRepositorio($clave);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if ($e->getPrevious()->getCode() == "23000") {
                return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. ", Response::HTTP_PARTIAL_CONTENT);
            } else {
                return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Familia" , name="GuardarFamilia")
     */
    public function SaveFamilia()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            if ($dbm->getRepositorioById('CeClavefamiliar', 'clave', $data['datos']['clavefamilia'])) {
                return new View("Ya existe una clave con la misma información", Response::HTTP_PARTIAL_CONTENT);
            }

			$clave = new CeClavefamiliar();
			$clave->setClave(empty($data['datos']['clavefamilia']) ? null : $data['datos']['clavefamilia']);
			$clave->setApellidomaterno(empty($data['datos']['apellidomaterno']) ? null : $data['datos']['apellidomaterno']);
			$clave->setApellidopaterno(empty($data['datos']['apellidopaterno']) ? null : $data['datos']['apellidopaterno']);
			$clave->setSituacionfamiliarid(empty($data['datos']['situacionid']) ?
			null : $dbm->getRepositorioById('CeSituacionfamiliar', 'situacionfamiliarid', $data['datos']['situacionid'])); 
			$dbm->saveRepositorio($clave);

			

			$padres = count($data['padresid']);

			for ($i=0; $i < $padres; $i++) { 
				if ($data['padresid'][$i]) {
					$padre = new CePadresotutoresclavefamiliar();
					$padre->setClavefamiliarid($clave);
					$padre->setPadresotutoresid(($dbm->getRepositorioById('CePadresotutores', 'padresotutoresid',  $data['padresid'][$i]['padresotutoresid'])));
					$padre->setTutorid(($dbm->getRepositorioById('Tutor', 'tutorid',  $data['padresid'][$i]['tutorid'])));
					$dbm->saveRepositorio($padre);
				} else {
					break;
				}
			}

			$alumnos = count($data['alumnoid']);

			for ($k=0; $k < $alumnos; $k++) { 
				if ($data['alumnoid'][$k]) {
					$alumno = new CeAlumnoporclavefamiliar();
					$alumno->setClavefamiliarid($clave);
					$alumno->setAlumnoid(($dbm->getRepositorioById('CeAlumno', 'alumnoid',  $data['alumnoid'][$k])));
					$dbm->saveRepositorio($alumno);
				} else {
					break;
				}
			}

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Controlescolar/Familia/{id}" , name="ActualizarFamilia")
     */
    public function updateFamilia($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
			$dbm->getConnection()->beginTransaction();

			if ($data['datos']['claveinicio'] != $data['datos']['clavefamilia']) {
				if ($dbm->getRepositorioById('CeClavefamiliar', 'clave', $data['datos']['clavefamilia'])) {
					return new View("Ya existe una clave con la misma información", Response::HTTP_PARTIAL_CONTENT);
				}
			}


            $clave = $dbm->getRepositorioById('CeClavefamiliar', 'clavefamiliarid', $id);
            $clave->setClave(empty($data[datos]['clavefamilia']) ? null : $data[datos]['clavefamilia']);
            $clave->setApellidopaterno(empty($data[datos]['apellidopaterno']) ? null : $data[datos]['apellidopaterno']);
			$clave->setApellidomaterno(empty($data[datos]['apellidomaterno']) ? null : $data[datos]['apellidomaterno']);
			$clave->setSituacionfamiliarid($dbm->getRepositorioById('CeSituacionfamiliar', 'situacionfamiliarid', $data[datos]['situacionid']));
			$dbm->saveRepositorio($clave);
			
			$padres = $dbm->getRepositoriosById('CePadresotutoresclavefamiliar', 'clavefamiliarid', $id);
			$listapadres = count($padres);
			for ($i=0; $i < $listapadres; $i++) { 
				$dbm->removeRepositorio($padres[$i]);
			}

			$alumnos = $dbm->getRepositoriosById('CeAlumnoporclavefamiliar', 'clavefamiliarid', $id);
			$listaalumnos = count($alumnos);
			for ($i=0; $i < $listaalumnos; $i++) { 
				$dbm->removeRepositorio($alumnos[$i]);
			}

			$padres = count($data['padresid']);

			for ($i=0; $i < $padres; $i++) { 
				if ($data['padresid'][$i]) {
					$padre = new CePadresotutoresclavefamiliar();
					$padre->setClavefamiliarid($clave);
					$padre->setPadresotutoresid(($dbm->getRepositorioById('CePadresotutores', 'padresotutoresid',  $data['padresid'][$i]['padresotutoresid'])));
					$padre->setTutorid(($dbm->getRepositorioById('Tutor', 'tutorid',  $data['padresid'][$i]['tutorid'])));
					$dbm->saveRepositorio($padre);
				} else {
					break;
				}
			}

			$alumnos = count($data['alumnoid']);

			for ($k=0; $k < $alumnos; $k++) { 
				if ($data['alumnoid'][$k]) {
					$alumno = new CeAlumnoporclavefamiliar();
					$alumno->setClavefamiliarid($clave);
					$alumno->setAlumnoid(($dbm->getRepositorioById('CeAlumno', 'alumnoid',  $data['alumnoid'][$k])));
					$dbm->saveRepositorio($alumno);
				} else {
					break;
				}
			}

            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

}
