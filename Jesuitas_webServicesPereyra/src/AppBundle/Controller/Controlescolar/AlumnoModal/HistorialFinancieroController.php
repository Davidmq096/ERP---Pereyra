<?php

namespace AppBundle\Controller\Controlescolar\AlumnoModal;

use AppBundle\DB\DbmControlescolar;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DB\DbmPagos;
use AppBundle\DB\DbmPagoLinea;

/**
 * @author Gabriel
 */

class HistorialFinancieroController extends FOSRestController
{
    /**
     * Obtiene los padres y tutotes del alumno y el domicilio actual del alumno
     * @Rest\Get("/api/Controlescolar/Alumno/HistorialAcademico", name="HistorialAcademico")
     */
    public function getHistorialAcademico()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos); //alumnoid
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if ($filtros["alumnoid"]) {
                $historial = $dbm->getRepositoriosById('CeAlumnoporciclo', 'alumnoid', $filtros['alumnoid']);

                return new View($historial, Response::HTTP_OK);
            } else {
                return new View("Falta el id del alumno.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene los padres y tutotes del alumno y el domicilio actual del alumno
     * @Rest\Get("/api/Controlescolar/Alumno/HistorialSubgrupos", name="getHistorialSubgrupos")
     */
    public function getHistorialSubgrupos()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos); //alumnoid
            $dbm = new DbmControlescolar($this->get("db_manager")->getEntityManager());

            if ($filtros["alumnoid"]) {
                $historial = $dbm->getRepositoriosById('CeAlumnoporciclo', 'alumnoid', $filtros['alumnoid']);

                $subgruposh = [];

                foreach ($historial as $h) {
                    $subgrupos = $dbm->getRepositoriosById('CeAlumnocicloporgrupo', 'alumnoporcicloid', $h->getAlumnoporcicloid());

                    foreach ($subgrupos as $subgrupo) {
                        $subgruposh[] = [
                            'ciclo' => $h->getCicloid()->getNombre(),
                            'nivel' => $h->getGradoid()->getNivelid()->getNombre(),
                            'grado' => $h->getGradoid()->getGrado(),
                            'subgrupo' => $subgrupo->getGrupoid()->getNombre(),
                            'nolista' => $subgrupo->getNumerolista(),
                        ];
                    }
                }

                return new View($subgruposh, Response::HTTP_OK);
            } else {
                return new View("Falta el id del alumno.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Obtiene los padres y tutotes del alumno y el domicilio actual del alumno
     * @Rest\Get("/api/Controlescolar/Alumno/HistorialFinanciero", name="HistorialFinanciero")
     */
    public function getHistorialFinanciero()
    {
        try {
            $datos = $_REQUEST;
            $filtros = array_filter($datos); //alumnoid
            $dbm = new DbmPagos($this->get("db_manager")->getEntityManager());
            $dbmPL = new DbmPagoLinea($this->get("db_manager")->getEntityManager());
            $parametrorecargo = $dbm->getRepositorioById('Parametros', 'nombre', "RecargoVentanillaBancaria");
            $parametrorecargo = $parametrorecargo ? $parametrorecargo->getValor() : 1;


            $alumnoid = $filtros['alumnoid'];
            if ($alumnoid) {
                $documentosColegiaturas = $dbm->BuscarDocumentosPorPagarColegiatura(["alumnoid" => $alumnoid]);
                $documentosInscripciones = $dbm->BuscarDcocumentosInscripcion(["alumnoid" => $alumnoid]);
                $colegiaturas = array_merge($documentosColegiaturas, $documentosInscripciones);

                $otros = $dbm->BuscarDcocumentosOtros(["alumnoid" => $alumnoid]);

                $data = [];
                foreach ($colegiaturas as $colegiatura) {
                    $now = time(); // or your date as well
                    $your_date = strtotime($colegiatura['FechaLimite']);
                    $datediff = $now - $your_date;
                    $atraso = round($datediff / (60 * 60 * 24));
                    $atraso = $atraso < 0 ? 0 : $atraso;
                    if ($colegiatura['PagoEstatusId'] !== 1) {
                        $atraso = 0;
                    }
                    if ($colegiatura['Recargo'] && $colegiatura['RecargoPorVencimiento'] && $parametrorecargo == 1) {
                        $colegiatura['InteresTotal'] =  round(floatval($pago['SaldoTotal']) * floatval($pago['RecargoPorVencimiento']) / 100.0, 2);
                    }
        
                    $data[] = [
                        'concepto' => $colegiatura['Concepto'],
                        'fechavencimiento' => $colegiatura['FechaLimiteFormato'],
                        'fechalimite' => $colegiatura['FechaLimite'],
                        'diasatraso' => $atraso,
                        'interes' => $colegiatura['Interes'],
                        'interesT' => $colegiatura['InteresTotal'],
                        'saldo' => $colegiatura['Saldo'],
                        'recargo' => intval($colegiatura['InteresTotal']) > 0 ? $colegiatura['InteresTotal'] : $colegiatura['Interes'],
                        'total' => $colegiatura['Saldo'] + $colegiatura['Recargo']
                    ];
                }
                foreach ($otros as $otro) {
                    $now = time(); // or your date as well
                    $your_date = strtotime($otro['FechaLimitePago']);
                    $datediff = $now - $your_date;
                    $atraso = round($datediff / (60 * 60 * 24));
                    $atraso = $atraso < 0 ? 0 : $atraso;
                    if ($otro['PagoEstatusId'] !== 1) {
                        $atraso = 0;
                    }
                    $data[] = [
                        'concepto' => $otro['Concepto'],
                        'fechavencimiento' => $otro['FechaLimiteFormato'],
                        'fechalimite' => $otro['FechaLimite'],
                        'diasatraso' => $atraso,
                        'saldo' => $otro['Saldo'],
                        'recargo' => 0,
                        'total' => $otro['Saldo'] + 0
                    ];
                }
                $historial = $dbmPL->OrdenarArreglo($data, 'fechalimite', SORT_ASC);

                return new View($historial, Response::HTTP_OK);
            } else {
                return new View("Falta el id del alumno.", Response::HTTP_PARTIAL_CONTENT);
            }
        } catch (\Exception $e) {
            return new View($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
