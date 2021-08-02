<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class DefaultController extends FOSRestController {

    /**
     * @Rest\Get("/")
     */
    public function indexAction(Request $request) {
        return new View("Services of module", Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/")
     */
    public function indexPostAction(Request $request) {
        return new View("Services of module", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/")
     */
    public function indexPutAction(Request $request) {
        return new View("Services of module", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/")
     */
    public function indexDeleteAction(Request $request) {
        return new View("Services of module", Response::HTTP_OK);
    }

    /**
     * Reotorna parametros de la conexion (host)    
     * @Rest\Get("/api/connectionQa/", name="coneccionQa")
     */
    public function QaAction(Request $request) {
        $connParams = array();
        $host = $this->container->getParameter('database_host');
        $dbName = $this->container->getParameter('database_name');
        $dbUser = $this->container->getParameter('database_user');
        $pass = $this->container->getParameter('database_password');

        $connParams['user'] = $dbUser;
        $connParams['password'] = $pass;
        $connParams['dbname'] = $dbName;
        $connParams['host'] = $host;

        $return = array('conection' => $connParams);
        return new View($return, Response::HTTP_OK);        
    }

}
