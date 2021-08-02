<?php

namespace AppBundle\Controller\Becas\Modal;

use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\DB\DbmBecas;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: Mariano
 */
class PadresController extends FOSRestController
{
    /**
     * Retorna select de la pestana de padres
     * @Rest\Get("/api/SolicitudBeca/estadocivil", name="BecaPadresoTutoresIndex")
     */
    public function indexBecaPadresOTutores()
    {
        try {
            $dbm = $this->get("db_manager");
            $situacionc = $dbm->getRepositorios('Situacionconyugal');
            $escolaridad = $dbm->getRepositorios('Escolaridad');
            return new View(array("SituacionConyugal" => $situacionc, "escolaridad" => $escolaridad), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    
    /**
     * Retorna la informacion de los padres en la solicitud, de no encontrar trae la guardada en control escolar
     * @Rest\Get("/api/Becas/PadresOTutoresAlumno/{solicitudid}", name="getBecaPadresoTutores")
     */
    public function getBecaPadresoTutores($solicitudid)
    {
        try {
            $dbm = new DbmBecas($this->get("db_manager")->getEntityManager());
            $solicitud = $dbm->getRepositorioById("BcSolicitudbeca", "solicitudid", $solicitudid);
            $clavefamiliarid = $solicitud->getClavefamiliarid()->getClavefamiliarid();

            $padresotutores = $dbm->buscarPadresBecas(array("solicitudid" => $solicitudid, "clavefamiliarid" => $clavefamiliarid));
            $parentesco = $dbm->getRepositorios('Parentesco');
            if (!$padresotutores) {
                $padresotutores = $dbm->buscarPadresBecasCe($clavefamiliarid);
                if (!$padresotutores) {
                    return new View("No se encontro ningun registro ", Response::HTTP_PARTIAL_CONTENT);
                } else {
                    $origen = "ce";
                    $situacionfamiliarid = $padresotutores[0]["situacionfamiliarid"];
                }
            } else {
                $origen = "bc";
                $situacionfamiliarid = $dbm->getRepositorioById("CeClavefamiliar", "clavefamiliarid", $clavefamiliarid)->getSituacionfamiliarid();
            }

            return new View(array("situacionfamiliarid" => $situacionfamiliarid, "padres" => $padresotutores,"parentesco" => $parentesco, "origen" => $origen), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * guarda pestaña padres o tutores
     * @Rest\Post("/api/SolicitudBeca/GuardarPadrestutores", name="BecaPadresoTutoresGuardar")
     */
    public function saveBecaPadresoTutores()
    {

        try {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            //$decoded = $_REQUEST;
            $dbm = $this->get("db_manager");
            $hydrator = new ArrayHydrator($dbm->getEntityManager());

            $dbm->getConnection()->beginTransaction();
            $clavefamiliar = $dbm->getRepositorioById("CeClavefamiliar", "clavefamiliarid", $decoded["clavefamiliarid"]);
            $clavefamiliar->setSituacionfamiliarid($dbm->getRepositorioById("CeSituacionfamiliar", "situacionfamiliarid", $decoded["situacionfamiliarid"]));
            $dbm->saveRepositorio($clavefamiliar);
            foreach ($decoded["padres"] as $padre) {
                if ($decoded["origen"] == "ce") {
                    $padresolicitud = $hydrator->hydrate('AppBundle\Entity\BcPadresotutores', $padre);
                    $padresolicitud->setClavefamiliarid($decoded["clavefamiliarid"]);
                } else {
                    $padresolicitud = $dbm->getRepositorioById('BcPadresotutores', 'padresotutoresid', $padre['padresotutoresid']);

                    if (!$padresolicitud) {
                        $padresolicitud = $hydrator->hydrate('AppBundle\Entity\BcPadresotutores', $padre);
                    } else {
                        $padresolicitud = $hydrator->hydrate($padresolicitud, $padre);
                    }
                    $padresolicitud->setClavefamiliarid($decoded["clavefamiliarid"]);
                    if (!$padre["telempresa"]) {$padresolicitud->setTelempresa(null);}
                    if (!$padre["celular"]) {$padresolicitud->setCelular(null);}
                }
                $dbm->saveRepositorio($padresolicitud);
                $padresotutores[] = $padresolicitud;

            }
            $dbm->getConnection()->commit();

            return new View(array("situacionfamiliarid" => $clavefamiliar->getSituacionfamiliarid() ? $clavefamiliar->getSituacionfamiliarid()->getSituacionfamiliarid() : null, "padres" => $padresotutores), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

}
