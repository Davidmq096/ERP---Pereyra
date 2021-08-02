<?php

namespace AppBundle\Controller\Controlescolar;

use AppBundle\DB\DbmControlescolar;
use AppBundle\Entity\CeConftallercurricular;
use AppBundle\Entity\CeTallerperiodoinscripcion;
use AppBundle\Entity\CeTalleropcionregistro;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto: David Medina
 */
class ConfTallerCurricularController extends FOSRestController
{

    /**
     * Retorna arreglo iniciales
     * @Rest\Get("/api/Controlescolar/conftallercurricular", name="indexConfTaller")
     */
    public function indexConfTaller()
    {
        try {
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $clasificador = $dbm->getRepositoriosById('CeClasificadorparaescolares', 'activo', 1);

            $opcionesregistro = $dbm->getRepositorios('CeTalleropcionregistro');
            $periodoinscripcion = $dbm->getRepositorios('CeTallerperiodoinscripcion');
            $conftaller = $dbm->getRepositorios('CeConftallercurricular');


            return new View(array(
                "clasificador" => $clasificador,
                "opcionesregistro" => $opcionesregistro,
                "periodoinscripcion" => $periodoinscripcion,
                "conftaller" => $conftaller
        ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Rest\Post("/api/Controlescolar/conftallercurricular" , name="SaveConfcurricular")
     */
    public function SaveConfcurricular()
    {
        try {
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content, true);
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());
            $dbm->getConnection()->beginTransaction();
            $data['conftallercurricularid'] ? $tallercurricular = $dbm->getRepositorioById('CeConftallercurricular', 'conftallercurricularid', $data['conftallercurricularid'])
            : $tallercurricular = new CeConftallercurricular();
            $tallercurricular->setFechaarmadogrupoinicio(empty($data['fechaarmadoinicio']) ? null : new \DateTime($data['fechaarmadoinicio']));
            $tallercurricular->setFechaarmadogrupofin(empty($data['fechaarmadofin']) ? null : new \DateTime($data['fechaarmadofin']));
            $tallercurricular->setFechapreregistroinicio(empty($data['fechapreregistroinicio']) ? null : new \DateTime($data['fechapreregistroinicio']));
            $tallercurricular->setFechapreregistrofin(empty($data['fechapreregistrofin']) ? null : new \DateTime($data['fechapreregistrofin']));
            $dbm->saveRepositorio($tallercurricular);

            foreach($data['periodoseliminados'] as $c){
                $dbm->removeRepositorio( $dbm->getRepositorioById('CeTallerperiodoinscripcion', 'tallerperiodoinscripcionid', $c));
            }

            foreach($data['periodosinscripcion'] as $c){
                $c['periodoinscripcionid'] ? $tallerperiodo = $dbm->getRepositorioById('CeTallerperiodoinscripcion', 'tallerperiodoinscripcionid', $c['periodoinscripcionid']) 
                : $tallerperiodo = new CeTallerperiodoinscripcion();
                $tallerperiodo->setFechanuevoingresoinicio(empty($c['fechaingresoinicio']) ?
                null : new \DateTime($c['fechaingresoinicio']));
                $tallerperiodo->setFechanuevoingresofin(empty($c['fechaingresofin']) ?
                null : new \DateTime( $c['fechaingresofin']));
                $tallerperiodo->setFechareingresoinicio(empty($c['fechareingresoinicio']) ?
                null : new \DateTime($c['fechareingresoinicio']));
                $tallerperiodo->setFechareingresofin(empty($c['fechareingresofin']) ?
                null : new \DateTime( $c['fechareingresofin']));
                $tallerperiodo->setClasificadorparaescolaresid(empty($c['clasificadorid']) ?
                null : $dbm->getRepositorioById('CeClasificadorparaescolares', 'clasificadorparaescolaresid', $c['clasificadorid']));
                $dbm->saveRepositorio($tallerperiodo);

            }


            foreach($data['preregistrosgrado'] as $g){
                $g['talleropcionid'] ? $preregistro = $dbm->getRepositorioById('CeTalleropcionregistro', 'talleropcionregistroid', $g['talleropcionid'])
                 : $preregistro = new CeTalleropcionregistro();
                $preregistro->setGradoid(empty($g['gradoid']) ? null : $dbm->getRepositorioById('Grado', 'gradoid', $g['gradoid']));
                $preregistro->setNotalleres(empty($g['opcion']) ?
                null : $g['opcion']);
                $preregistro->setPrioridad((empty($g['prioridad']) ?
                0 : $g['prioridad']));
                $dbm->saveRepositorio($preregistro);
            }            

            $periodoinscripcion = $dbm->getRepositorios('CeTallerperiodoinscripcion');

            $dbm->getConnection()->commit();
            return new View(array("mensaje" => "Se ha guardado el registro", "periodoinscripcion"=> $periodoinscripcion), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


}
