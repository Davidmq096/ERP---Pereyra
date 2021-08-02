<?php

namespace AppBundle\Controller\PortalFamiliar\Becas;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Controller\lib\Hydrator\ArrayHydrator;
use AppBundle\Controller\lib\Hydrator\JsonApiHydrator;
use AppBundle\DB\DbmBecas;

/**
 * Auto: Inceptio
 */
class BecaController extends FOSRestController
{
    /**
    * Obtiene si el se ha realizado el pago de la solicitud de beca por clave familiar
     * @Rest\Get("/api/portalfamiliar/becas/SolicitudBeca/Pagado/{ClaveFamiliarId}", name="PPBGetSolicitudBecaPagada")
     */ 
     public function PPBGetSolicitudBecaPagada($ClaveFamiliarId)
     {
        try 
        {
            $conn = $this->get("db_manager")->getConnection();
            $stmt = $conn->prepare('CALL  SolicitudBecaPagado(:clave);');
            $stmt->execute(array('clave' => $ClaveFamiliarId));
            $pago = $stmt->fetchAll(); 
            
            $return = array
            (
                'Pago' => $pago[0],
            );
            
            return new View($return, Response::HTTP_OK);
        }
        catch (\Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }                     

     }
    
    /**
    * Obtiene las familias de un padre o tutor y tambien un estatus si el padre o tutor ya solicitó una beca en el ciclo actual
     * @Rest\Get("/api/portalfamiliar/becas/SolicitudBeca/Familia/{PadreOTutorId}", name="PPBFamilia")
     */ 
     public function PPBGetBeca($PadreOTutorId)
     {
        try 
        {
            $dbm = $this->get("db_manager");
            $dbm = new DbmBecas($dbm->getEntityManager());
            
            $clavefamiliar = $dbm->GetClaveFamiliarPadreOTutorSolicitudBeca($PadreOTutorId);
            
            foreach ($clavefamiliar as &$clave) 
            {
                $clave["alumno"] = $dbm->GetAlumnoPorClaveFamiliar($clave["clavefamiliarid"]);
            }

            return new View($clavefamiliar, Response::HTTP_OK);
        }
        catch (\Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }                     

     }
    
    /**
    * Obtiene los parametros con los msn de la sección de becas
     * @Rest\Get("/api/portalfamiliar/becas/SolicitudBeca/Mensajes", name="PPBGetMensajesBecas")
     */ 
     public function PPBGetMensajesBecas()
     {
        try 
        {
            $datos = $_REQUEST;
            $dbm = $this->get("db_manager");
            $conn = $this->get("db_manager")->getConnection();
            
            $solicitudfamilia = $dbm->getRepositorioById('Parametros', 'nombre', 'Solicitud de becas por familia');
            $pagarbeca = $dbm->getRepositorioById('Parametros', 'nombre', 'Pagar solicitud beca');
            
            $respuesta = array(
                'solicitudfamilia' => $solicitudfamilia->getValor(),
                'pagobeca' => $pagarbeca->getValor()
            );
            
            
            
            return new View($respuesta, Response::HTTP_OK);
        }
        catch (\Exception $e) 
        {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }                     

     }
}

