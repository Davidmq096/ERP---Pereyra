<?php

namespace AppBundle\Controller\Transporte;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmTransporte;
use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\TpPlantillacontrato;
use AppBundle\Entity\TpNivelporplantillacontrato;
use AppBundle\Controller\lib\PDFMerger\PDFMerger;

/**
 * Auto: Javier
 */
class PlantillaContratoController extends FOSRestController
{

        /**
     * 
     * @Rest\Get("/api/Transporte/Plantillacontrato", name="indexPlantillaContrato")
     */
    public function indexPLantillaContrat()
    {
        try {
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $nivel = $dbm->getRepositoriosById('Nivel', 'activo', 1);
            $token = $dbm->getRepositorios('CeAlumnotokens');

            return new View(array("nivel" => $nivel, "token" => $token), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * 
     * @Rest\Get("/api/Transporte/Plantillacontrato/", name="BuscarPlantillaContrato")
     */
    public function buscarPLantillaContrat()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $plantillacontrato = $dbm->BuscarPlantilla($filtros);
            return new View($plantillacontrato, Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina un registro
     * @Rest\Delete("/api/Transporte/Plantillacontrato/{id}", name="EliminarPlantillacontrato")
     */
    public function deletePlantillacontrato($id)
    {
        try {
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();

            $dbm->removeManyRepositorio("TpNivelporplantillacontrato", "plantillacontratoid", $id);
            $Plantillacontrato = $dbm->getRepositorioById('TpPlantillacontrato', 'plantillacontratoid', $id);
            $dbm->removeRepositorio($Plantillacontrato);
            $dbm->getConnection()->commit();
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
     * @Rest\Post("/api/Transporte/Plantillacontrato" , name="GuardarPlantillacontrato")
     */
    public function SavePlantillacontrato()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $repetidos = $data["activo"] ? $dbm->BuscarPlantilla(array("nivelid" => $data["nivelid"], "activo" => true)) : null;
            if ($repetidos) {
                return new View("Ya existe una plantilla activa con el nivel seleccionado", Response::HTTP_PARTIAL_CONTENT);
            }

            $plantillacontrato = $hydrator->hydrate(new TpPlantillacontrato(), $data);
            $plantillacontrato->setContenido(base64_decode($data["formato"]["value"]));
            $plantillacontrato->setSize($data["formato"]["size"]);
            $plantillacontrato->setTipo($data["formato"]["filetype"]);
            $dbm->saveRepositorio($plantillacontrato);

            foreach ($data["nivelid"] as $n) {
                $nivelporplantilla = $hydrator->hydrate(new TpNivelporplantillacontrato(), array("nivelid" => $n));
                $nivelporplantilla->setPlantillacontratoid($plantillacontrato);
                $dbm->saveRepositorio($nivelporplantilla);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Rest\Put("/api/Transporte/Plantillacontrato/{id}" , name="ActualizarPlantillacontrato")
     */
    public function UpdatePlantillacontrato($id)
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $plantillacontrato = $dbm->getRepositorioById('TpPlantillacontrato', 'plantillacontratoid', $id);
            $repetidos = $data["activo"] ? $dbm->BuscarPlantilla(array("nivelid" => $data["nivelid"], "activo" => true)) : null;
            if ($repetidos) {
                foreach ($repetidos as $r) {
                    if ($r["plantillacontratoid"] != $id) {
                        return new View("Ya existe una plantilla activa con el nivel seleccionado", Response::HTTP_PARTIAL_CONTENT);
                    }
                }
            }

            $plantillacontrato = $hydrator->hydrate($plantillacontrato, $data);
            if ($data["formato"]) {
                $plantillacontrato->setContenido(base64_decode($data["formato"]["value"]));
                $plantillacontrato->setSize($data["formato"]["size"]);
                $plantillacontrato->setTipo($data["formato"]["filetype"]);
            }
            $dbm->saveRepositorio($plantillacontrato);

            $dbm->removeManyRepositorio("TpNivelporplantillacontrato", "plantillacontratoid", $id);
            foreach ($data["nivelid"] as $n) {
                $nivelporplantilla = $hydrator->hydrate(new TpNivelporplantillacontrato(), array("nivelid" => $n));
                $nivelporplantilla->setPlantillacontratoid($plantillacontrato);
                $dbm->saveRepositorio($nivelporplantilla);
            }

            $dbm->getConnection()->commit();
            return new View("Se ha guardado el registro", Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna el archivo word del formato
     * @Rest\Get("/api/Transporte/Plantillacontrato/descargar/{id}", name="DescargarPlantillaContrato")
     */
    public function downloadPlantilla($id)
    {
        try {
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $Formato = $dbm->getRepositorioById('TpPlantillacontrato', 'plantillacontratoid', $id);
            $response = new \Symfony\Component\HttpFoundation\Response(
                stream_get_contents($Formato->getContenido()),
                200,
                array(
                    'Content-Type' => $Formato->getTipo(),
                    'Content-Length' => $Formato->getSize()
                )
            );
            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Retorna el archivo word del formato
     * @Rest\Get("/api/Transporte/Plantillacontrato/Contrato/{id}", name="DescargarContrato")
     */
    public function downloadContrato($id)
    {
        try {
            $dbm = new DbmTransporte($this->get("db_manager")->getEntityManager());
            $dbm2 = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dm = new PDFMerger();

            $contratos = array();
            $rutas = array();
						$rutasPDF=array();
						$baseUrl="src/AppBundle/Dominio/DocxMerge/tmp/";
            $root = str_replace('app', '', $this->get('kernel')->getRootDir()) . $baseUrl;
            $alumnos = $dbm->getRepositoriosById('TpAlumnoporcontrato', 'contratoid', $id);
            $dbm2 = new DbmControlescolar($this->get("db_manager")->getEntityManager());
						if(count($alumnos)<1){
							return new View("El contrato no tiene alumnos.", Response::HTTP_BAD_REQUEST);
						}
            foreach ($alumnos as $a) {
                $alu = $dbm2->BuscarAlumnosA(array("alumnoid" => $a->getAlumnoid()->getAlumnoid()))[0];
                $Formato = $dbm->getRepositorioById('TpNivelporplantillacontrato', 'nivelid', $alu["nivelid"]);
                if (!$Formato) {
                    return new View("No se ha configurado una plantilla para el nivel del alumno", Response::HTTP_PARTIAL_CONTENT);
                }
                //$Formato = $Formato->getPlantillacontratoid();
                rewind($Formato->getPlantillacontratoid()->getContenido());

                $contenido = stream_get_contents($Formato->getPlantillacontratoid()->getContenido());
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 50; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }

                $mPath = $root . $randomString . '.docx';
                file_put_contents($mPath, $contenido);
                $parametros = $dbm->getRepositorioById("Parametros", "nombre", "UrlTokens");
                $urltokens = $parametros->getValor();
                $vista = $dbm2->BuscarTokens($a->getAlumnoid()->getAlumnoid());
                $pdf = \AppBundle\Dominio\Formato::remplazarToken($vista, $mPath, $urltokens);

                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 50; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }

                $mPathP = $root . $randomString . '.pdf';
                file_put_contents($mPathP, $pdf['formato']);


                $rutas[] = $mPath;
                $rutasPDF[] = $mPathP;
                $contratos[] = $Formato;
            }

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 50; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $finalPath = "../$baseUrl$randomString.pdf";

            foreach($rutasPDF as $key => $ruta){
                $dm->addPDF($ruta);
            }
            $dm->merge("file", $finalPath);

            $final = file_get_contents($finalPath);


            $response = new \Symfony\Component\HttpFoundation\Response(
                //$pdf["formato"],
                $final,
                200,
                array(
                    'Content-Type' => "application/pdf",
                    'Content-Length' => filesize($finalPath)
                    //'Content-Length' => $pdf["tamano"]
                )
            );

            unlink($finalPath);

            foreach ($rutas as $ruta) {
                unlink($ruta);
            }

            foreach ($rutasPDF as $ruta) {
                unlink($ruta);
            }

            return $response;
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
