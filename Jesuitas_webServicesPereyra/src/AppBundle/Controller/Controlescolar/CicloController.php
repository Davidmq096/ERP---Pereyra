<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\Ciclo;
use AppBundle\Entity\CeCiclopornivel;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mariano
 */
class CicloController extends FOSRestController
{
    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/Ciclo", name="indexCiclo")
     */
    public function indexCiclo()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $ciclos = $dbm->getRepositoriosById('Ciclo', 'activo', 1);
            usleep(2000000);
            $niveles = $dbm->getRepositoriosById('Nivel', 'requieresemestre', 1);
            foreach ($niveles as $nivel) {
                $requieresemestre[]=$nivel->getNombre();
            }
            return new View(array("ciclos"=>$ciclos,"grado"=>$grados,"tiporedondeo"=>$tiporedondeo,"requieresemestre"=>$requieresemestre), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna arreglo de Ciclos en base a los parametros enviados
     * @Rest\Get("/api/Controlescolar/Ciclo/", name="BuscarCiclo")
     */
    public function getCiclo()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $entidad = $dbm->BuscarCiclo($filtros);
            if (!$entidad) {
                return new View("No se encontró ningún registro.", Response::HTTP_PARTIAL_CONTENT);
            }
            return new View($entidad, Response::HTTP_OK);
        } catch (Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

   
    /**
     * @Rest\Post("/api/Controlescolar/Ciclo" , name="GuardarCiclo")
     */
    public function SaveCiclo()
    {
        try {
            $datos = $_REQUEST;
            $data = json_decode($datos["datos"], true);
            $dateinicio=new \DateTime($data["fechaciclo"]["beginDate"]["year"]."-".$data["fechaciclo"]["beginDate"]["month"]."-".$data["fechaciclo"]["beginDate"]["day"]);
            $datefin=new \DateTime($data["fechaciclo"]["endDate"]["year"]."-".$data["fechaciclo"]["endDate"]["month"]."-".$data["fechaciclo"]["endDate"]["day"]);
            $dateinicios1=new \DateTime($data["fechasemestre1"]["beginDate"]["year"]."-".$data["fechasemestre1"]["beginDate"]["month"]."-".$data["fechasemestre1"]["beginDate"]["day"]);
            $datefins1=new \DateTime($data["fechasemestre1"]["endDate"]["year"]."-".$data["fechasemestre1"]["endDate"]["month"]."-".$data["fechasemestre1"]["endDate"]["day"]);
            $dateinicios2=new \DateTime($data["fechasemestre2"]["beginDate"]["year"]."-".$data["fechasemestre2"]["beginDate"]["month"]."-".$data["fechasemestre2"]["beginDate"]["day"]);
            $datefins2=new \DateTime($data["fechasemestre2"]["endDate"]["year"]."-".$data["fechasemestre2"]["endDate"]["month"]."-".$data["fechasemestre2"]["endDate"]["day"]);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if (!($dateinicios1 >= $dateinicio && $dateinicios1 < $datefin) || !($datefins1 > $dateinicio && $datefins1 <= $datefin)) {
                return new View("El primer periodo semestral no está dentro del periodo del ciclo escolar.", Response::HTTP_PARTIAL_CONTENT);
            }

            if (!($dateinicios2 >= $dateinicio && $dateinicios2 < $datefin) || !($datefins2 > $dateinicio && $datefins2 <= $datefin)) {
                return new View("El segundo periodo semestral no está dentro del periodo del ciclo escolar.", Response::HTTP_PARTIAL_CONTENT);
            }

            if (!($dateinicios2 > $datefins1 && $dateinicios2 > $dateinicios1) || !($datefins2 > $datefins1 && $datefins2 > $dateinicios1)) {
                return new View("Los periodos semestrales se empalman.", Response::HTTP_PARTIAL_CONTENT);
            }

            
            $ciclo = $dbm->getRepositorioById('Ciclo', 'nombre', $data['nombre']);
            if ($ciclo) {
                return new View("Ya existe un registro con la misma descripción.", Response::HTTP_PARTIAL_CONTENT);
            }

            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Ciclo = $hydrator->hydrate(new Ciclo(), $data);
            $dbm->saveRepositorio($Ciclo);

            $niveles=$dbm->getRepositorios("Nivel");
            foreach ($niveles as $nivel){
                $ciclopornivel = new CeCiclopornivel();
                $ciclopornivel->setCicloid($Ciclo);
                $ciclopornivel->setFechainicio($dateinicio);
                $ciclopornivel->setFechafin($datefin);
                if ($nivel->getRequieresemestre()) {
                    $ciclopornivel->setFechainicios1($dateinicios1);
                    $ciclopornivel->setFechafins1($datefins1);
                    $ciclopornivel->setFechainicios2($dateinicios2);
                    $ciclopornivel->setFechafins2($datefins2);
                }
                $ciclopornivel->setNivelid($nivel);
                $dbm->saveRepositorio($ciclopornivel);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Controlescolar/Ciclo/{id}" , name="ActualizaCiclo")
     */
    public function updateCiclo($id)
    {
        try {
            parse_str(file_get_contents("php://input"), $datos);
            $data = json_decode($datos["datos"], true);
            $dateinicio=new \DateTime($data["fechaciclo"]["beginDate"]["year"]."-".$data["fechaciclo"]["beginDate"]["month"]."-".$data["fechaciclo"]["beginDate"]["day"]);
            $datefin=new \DateTime($data["fechaciclo"]["endDate"]["year"]."-".$data["fechaciclo"]["endDate"]["month"]."-".$data["fechaciclo"]["endDate"]["day"]);
            $dateinicios1=new \DateTime($data["fechasemestre1"]["beginDate"]["year"]."-".$data["fechasemestre1"]["beginDate"]["month"]."-".$data["fechasemestre1"]["beginDate"]["day"]);
            $datefins1=new \DateTime($data["fechasemestre1"]["endDate"]["year"]."-".$data["fechasemestre1"]["endDate"]["month"]."-".$data["fechasemestre1"]["endDate"]["day"]);
            $dateinicios2=new \DateTime($data["fechasemestre2"]["beginDate"]["year"]."-".$data["fechasemestre2"]["beginDate"]["month"]."-".$data["fechasemestre2"]["beginDate"]["day"]);
            $datefins2=new \DateTime($data["fechasemestre2"]["endDate"]["year"]."-".$data["fechasemestre2"]["endDate"]["month"]."-".$data["fechasemestre2"]["endDate"]["day"]);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if (!($dateinicios1 >= $dateinicio && $dateinicios1 < $datefin) || !($datefins1 > $dateinicio && $datefins1 <= $datefin)) {
                return new View("El primer periodo semestral no está dentro del periodo del ciclo escolar.", Response::HTTP_PARTIAL_CONTENT);
            }

            if (!($dateinicios2 >= $dateinicio && $dateinicios2 < $datefin) || !($datefins2 > $dateinicio && $datefins2 <= $datefin)) {
                return new View("El segundo periodo semestral no está dentro del periodo del ciclo escolar.", Response::HTTP_PARTIAL_CONTENT);
            }

            if (!($dateinicios2 > $datefins1 && $dateinicios2 > $dateinicios1) || !($datefins2 > $datefins1 && $datefins2 > $dateinicios1)) {
                return new View("Los periodos semestrales se empalman.", Response::HTTP_PARTIAL_CONTENT);
            }

            $ciclo = $dbm->getRepositorioById('Ciclo', 'nombre', $data['nombre']);
            if ($ciclo && $ciclo->getCicloid() != $id) {
                return new View("Ya existe un registro con el mismo nombre.", Response::HTTP_PARTIAL_CONTENT);
            }
            $Ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $id);
            if ($Ciclo->getActual()==true && $data["activo"]==false) {
                return new View("No se puede desactivar el ciclo actual.", Response::HTTP_PARTIAL_CONTENT);
            }
            if ($Ciclo->getSiguiente()==true && $data["activo"]==false) {
                return new View("No se puede desactivar el ciclo siguiente.", Response::HTTP_PARTIAL_CONTENT);
            }
            
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());
            $Ciclo->setNombre($data["nombre"]);
            $Ciclo->setActivo($data["activo"]);
            $dbm->saveRepositorio($Ciclo);
            $niveles=$dbm->getRepositorios("Nivel");
            foreach ($niveles as $nivel){
                $ciclopornivel = $dbm->getByParametersRepositorios('CeCiclopornivel', array("cicloid"=>$id,"nivelid"=>$nivel));
                $ciclopornivel[0]->setFechainicio($dateinicio);
                $ciclopornivel[0]->setFechafin($datefin);
                if ($nivel->getRequieresemestre()) {
                    $ciclopornivel[0]->setFechainicios1($dateinicios1);
                    $ciclopornivel[0]->setFechafins1($datefins1);
                    $ciclopornivel[0]->setFechainicios2($dateinicios2);
                    $ciclopornivel[0]->setFechafins2($datefins2);
                }
                $dbm->saveRepositorio($ciclopornivel[0]);
            }
            
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * @Rest\Post("/api/Controlescolar/Ciclo/Cambio" , name="CambioCiclo")
     */
    public function changeCiclo()
    {
        try {
            //parse_str(file_get_contents("php://input"), $datos);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if ($_REQUEST['cicloactual']==$_REQUEST['ciclosiguiente']) {
                return new View("El ciclo actual y siguiente no pueden ser el mismo ciclo.", Response::HTTP_PARTIAL_CONTENT);
            }
            $excicloactual = $dbm->getRepositorioById('Ciclo', 'actual', 1);
            $exciclosiguiente = $dbm->getRepositorioById('Ciclo', 'siguiente', 1);
            
            $cicloactual = $dbm->getRepositorioById('Ciclo', 'cicloid', $_REQUEST['cicloactual']);
            $cicloactual->setActual(1);
            
            $ciclosiguiente = $dbm->getRepositorioById('Ciclo', 'cicloid', $_REQUEST['ciclosiguiente']);
            $ciclosiguiente->setSiguiente(1);

            $dbm->getConnection()->beginTransaction();
            if ($excicloactual!=$cicloactual) {
                $excicloactual->setActual(0);
                $dbm->saveRepositorio($excicloactual);
            }
            if ($exciclosiguiente!=$ciclosiguiente){
                $exciclosiguiente->setSiguiente(0);
                $dbm->saveRepositorio($exciclosiguiente);
            }
            
            $dbm->saveRepositorio($cicloactual);
            $dbm->saveRepositorio($ciclosiguiente);

            //Buscamos a todos los alumnos con intencion de reinscribirse como baja y los ponemos el estatus de baja al alumno
            $alumnos = $dbm->getRepositoriosModelo(
                "CeAlumnoporciclo",
                ["a"],
                ['cicloid' => $cicloactual->getCicloid(), 'intencionreinscribirseid' => 2],
                false,
                false,
                [
                    ["entidad" => "CeAlumno", "alias" => "a", "on" => "d.alumnoid = a.alumnoid and a.alumnoestatusid <> 2"]
                ]
            );
            foreach($alumnos as $a){
                $a->setAlumnoestatusid($dbm->getRepositorioById('CeAlumnoestatus', 'alumnoestatusid', 2));
            }
            $dbm->saveBulkRepositorio($alumnos);
            
            $dbm->getConnection()->commit();
            return new View("Se ha actualizado el registro.", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new $e;
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Controlescolar/Ciclo/{id}", name="EliminarCiclo")
     */
    public function deleteCiclo($id)
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $ciclo = $dbm->getRepositorioById('Ciclo', 'cicloid', $id);
            if ($ciclo && $ciclo->getActual()==true) {
                return new View("No se puede eliminar el ciclo actual", Response::HTTP_PARTIAL_CONTENT);
            }
            if ($ciclo && $ciclo->getSiguiente()==true) {
                return new View("No se puede eliminar el ciclo siguiente", Response::HTTP_PARTIAL_CONTENT);
            }
            $dbm->removeManyRepositorio("CeCiclopornivel", 'cicloid', $id);
            $dbm->removeRepositorio($ciclo);
            $dbm->getConnection()->commit();
            return new View("Se ha eliminado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            if($e->getPrevious()->getCode() == "23000"){
        		return new View("No se puede eliminar el registro debido a que ya se encuentra relacionado. <br>
									Como alternativa puede editar el campo activo del mismo.", Response::HTTP_PARTIAL_CONTENT);
        	}else{
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        	}
        }
    }



}
