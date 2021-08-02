<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql\Admisiones;
use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;

/**
 * Descripción of TableroDB
 *
 * @author inceptio
 */
class TableroDB extends BaseDBManager
{
    public function getTableroDatosIniciales(){

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('me, c, t')->from("AppBundle:Evaluacion", 'me')->innerJoin('me.cicloid', 'c')->innerJoin('me.tipoevaluacionid', 't')->andWhere('me.activo =  1');
        $evaluaciones =  $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $evaluacionesData = [];

        foreach($evaluaciones as $evaluacion){
            $qb = $this->em->createQueryBuilder();
            $query = $qb->select('me, p')->from("AppBundle:Preguntaporevaluacion", 'me')->innerJoin('me.preguntaid', 'p')->andWhere('me.evaluacionid = ' . $evaluacion['evaluacionid']);
            $evaluacion['preguntas'] =  $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
            $qb = $this->em->createQueryBuilder();
            $query = $qb->select('g.gradoid')->from("AppBundle:Evaluacionporgrado", 'me')->innerJoin('me.gradoid', 'g')->andWhere('me.evaluacionid = ' . $evaluacion['evaluacionid']);
            $evaluacion['grados'] =  $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
            $evaluacionesData[] = $evaluacion;
        }

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('me, c, g')->from("AppBundle:BrExamen", 'me')->innerJoin('me.cicloid', 'c')->innerJoin('me.gradoid', 'g');
        $examenes =  $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $referencias = [
            [
                "tipo" => 1,
                "nombre" => "Texto"
            ],
            [
                "tipo" => 2,
                "nombre" => "Fecha DD/MM/AAAA"
            ],
            [
                "tipo" => 3,
                "nombre" => "Numérico entero"
            ],
            [
                "tipo" => 4,
                "nombre" => "Porcentaje"
            ],
            [
                "tipo" => 5,
                "nombre" => "Booleano"
            ],
            [
                "tipo" => 6,
                "nombre" => "Fecha DD/MM/AAAA hh:mm"
            ],
            [
                "tipo" => 7,
                "nombre" => "Hora hh:mm"
            ]
        ];

        $data = [
            [
                'origencampoid' => 1,
                'vistas' => [
                    [
                        'vista' => 'infogeneralvista',
                        'nombre' => 'Información general',
                        'parametros' => [
                            [
                                "columna" => "SolicitudAdmisionId",
                                "nombre" => "Solicitud de admisión",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "Folio",
                                "nombre" => "Folio",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "Ciclo",
                                "nombre" => "Ciclo",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "Nivel",
                                "nombre" => "Nivel",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "Grado",
                                "nombre" => "Grado",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "Nombre",
                                "nombre" => "Nombre",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "FechaNacimiento",
                                "nombre" => "Fecha de nacimiento",
                                "tipo" => 2
                            ],
                            [
                                "columna" => "Edad",
                                "nombre" => "Edad",
                                "tipo" => 3
                            ],
                            [
                                "columna" => "Sexo",
                                "nombre" => "Sexo",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "EscuelaProcedencia",
                                "nombre" => "Escuela de procedencia",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "Promedio",
                                "nombre" => "Promedio",
                                "tipo" => 4
                            ],
                            [
                                "columna" => "Estatus",
                                "nombre" => "Estatus",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "ExLux",
                                "nombre" => "Padre ex-alumno",
                                "tipo" => 5
                            ],
                            [
                                "columna" => "HijoPersonal",
                                "nombre" => "Hijo personal",
                                "tipo" => 5
                            ]
                        ]
                    ],
                    [
                        'vista' => 'eventoevaluacionvista',
                        'nombre' => 'Evento evaluación',
                        'parametros' => [
                            [
                                "columna" => "SolicitudAdmisionId",
                                "nombre" => "Solicitud de admisión",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "EventoEvaluadorAcademico",
                                "nombre" => "Evaluador por evento académico",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "EventoFechaAcademico",
                                "nombre" => "Fecha de evento académico",
                                "tipo" => 2
                            ],
                            [
                                "columna" => "EventoFechaLargaAcademico",
                                "nombre" => "Fecha larga de evento académico",
                                "tipo" => 6
                            ],
                            [
                                "columna" => "EventoHoraAcademico",
                                "nombre" => "Hora de evento académico",
                                "tipo" => 7
                            ],
                            [
                                "columna" => "EventoLugarAcademico",
                                "nombre" => "Lugar de evento académico",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "EventoEvaluadorPsicometrico",
                                "nombre" => "Evaluador por evento psicométrico",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "EventoFechaPsicometrico",
                                "nombre" => "Fecha de evento psicométrico",
                                "tipo" => 2
                            ],
                            [
                                "columna" => "EventoFechaLargaPsicometrico",
                                "nombre" => "Fecha larga de evento psicométrico",
                                "tipo" => 6
                            ],
                            [
                                "columna" => "EventoHoraPsicometrico",
                                "nombre" => "Hora de evento psicométrico",
                                "tipo" => 7
                            ],
                            [
                                "columna" => "EventoLugarPsicometrico",
                                "nombre" => "Lugar de evento psicométrico",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "EventoEvaluadorEntrevista",
                                "nombre" => "Evaluador por entrevista",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "EventoFechaEntrevista",
                                "nombre" => "Fecha de entrevista",
                                "tipo" => 2
                            ],
                            [
                                "columna" => "EventoFechaLargaEntrevista",
                                "nombre" => "Fecha larga de entrevista",
                                "tipo" => 6
                            ],
                            [
                                "columna" => "EventoHoraEntrevista",
                                "nombre" => "Hora de entrevista",
                                "tipo" => 7
                            ],
                            [
                                "columna" => "EventoLugarEntrevista",
                                "nombre" => "Lugar de entrevista",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "grado",
                                "nombre" => "Grado",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "nivel",
                                "nombre" => "Nivel",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "Nombre",
                                "nombre" => "Nombre",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "ApellidoPaterno",
                                "nombre" => "Apellido paterno",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "ApellidoMaterno",
                                "nombre" => "Apellido materno",
                                "tipo" => 1
                            ]
                        ]
                    ],
                    [
                        'vista' => 'hermanosvista',
                        'nombre' => 'Hermanos',
                        'parametros' => [
                            [
                                "columna" => "SolicitudAdmisionId",
                                "nombre" => "Solicitud de admisión",
                                "tipo" => 1
                            ],
                            [
                                "columna" => "HermanosIdec",
                                "nombre" => "Hermanos jesuitas",
                                "tipo" => 5
                            ],
                            [
                                "columna" => "HermanosExIdec",
                                "nombre" => "Hermanos ex jesuitas",
                                "tipo" => 5
                            ],
                            [
                                "columna" => "HermanosTramite",
                                "nombre" => "Hermanos en trámite",
                                "tipo" => 5
                            ]
                        ]
                    ]
                ]
            ],
            [
                'origencampoid' => 2,
                'evaluaciones' => $evaluacionesData
            ],
            [
                'origencampoid' => 3,
                'examenes' => $examenes
            ],
            [
                'origencampoid' => 4,
                'configuracion' => [
                    'bancoreactivos' => true,
                    'vistas' => false,
                    'evaluaciones' => true
                ]
            ]
        ];

        return $data;
    }


    public function vistaprevia($query, $solicitud = false){
        $qb = $this->em->getConnection();
        if(!$solicitud){
            $sql = $query . ' LIMIT 10';
        }else{
            $sql = str_replace('{id}', $solicitud, $query);
        }
        $stmt = $qb->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return ['data' => $data, 'keys' => array_keys($data[0])];
    }

    public function getBusquedaTableroPorFiltros($filtros){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.cicloid, c.nombre ciclo, n.nivelid, n.nombre nivel, ta.configuracionid, tb.tableroid, tb.nombre")
                ->from("AppBundle:AdConfiguracion", 'ta')
                ->innerJoin("ta.nivelid", "n")
                ->innerJoin("AppBundle:AdConfiguracionporgrado", "g", Expr\Join::WITH, "g.configuracionid = ta.configuracionid")
                ->innerJoin("ta.tableroid", "tb")
                ->groupBy('ta.configuracionid')
                ->innerJoin("ta.cicloid", 'c');

        if (isset($filtros['cicloid'])) {
        	$result->andWhere('c.cicloid IN (:cicloid)')
        	->setParameter('cicloid' , $filtros['cicloid']);
        }
        if (isset($filtros['nivelid'])) {
        	$result->andWhere('n.nivelid IN (:nivelid)')
        	->setParameter('nivelid' , $filtros['nivelid']);
        }
        if (isset($filtros['gradoid'])) {
        	$result->andWhere('g.gradoid IN (:gradoid)')
        	->setParameter('gradoid' , $filtros['gradoid']);
        }
        if (isset($filtros['tableroid'])) {
            $result->andWhere('tb.tableroid IN (:tableroid)')
        	->setParameter('tableroid' , $filtros['tableroid']);
        }
        $configuraciones = $result->getQuery()->getResult();
        $data = [];
        foreach($configuraciones as $configuracion){
            $qb = $this->em->createQueryBuilder();
            $grados = $qb->select("g.gradoid, g.grado")
                        ->from("AppBundle:AdConfiguracionporgrado", "tg")
                        ->innerJoin("tg.gradoid", "g")
                        ->andWhere("tg.configuracionid = " . $configuracion['configuracionid']);
            $gradosRes = $grados->getQuery()->getResult();
            $gradosid = [];
            $grados = [];
            foreach($gradosRes as $grado){
                $gradosid[] = $grado['gradoid'];
                $grados[] = $grado['grado'];
            }
            $configuracion['gradoid'] = $gradosid;
            $configuracion['grados'] = $grados;
            $data[] = $configuracion;
        }
        return $data;
    }

    public function getTablero($id){
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("c.cicloid, c.nombre ciclo, n.nivelid, n.nombre nivel, ta.configuracionid, tb.tableroid, tb.nombre")
                ->from("AppBundle:AdConfiguracion", 'ta')
                ->innerJoin("ta.nivelid", "n")
                ->innerJoin("ta.tableroid", "tb")
                ->innerJoin("ta.cicloid", 'c')
                ->andWhere('ta.configuracionid = ' . $id);
        $configuracion = $result->getQuery()->getResult()[0];
        $qb = $this->em->createQueryBuilder();
        $grados = $qb->select("g.gradoid, g.grado")
                    ->from("AppBundle:AdConfiguracionporgrado", "tg")
                    ->innerJoin("tg.gradoid", "g")
                    ->andWhere("tg.configuracionid = " . $id);
        $gradosRes = $grados->getQuery()->getResult();
        $gradosid = [];
        $grados = [];
        foreach($gradosRes as $grado){
            $gradosid[] = $grado['gradoid'];
            $grados[] = $grado['grado'];
        }
        $configuracion['gradoid'] = $gradosid;
        $configuracion['grados'] = $grados;
        $qb = $this->em->createQueryBuilder();
        $secciones = $qb->select("ts.configuracion, ts.query, ts.nombre, ts.seccionid, ts.propiedades as parametros")
                    ->from("AppBundle:AdSeccion", "ts")
                    ->andWhere("ts.configuracionid = " . $id);
        $configuracion['secciones'] = $secciones->getQuery()->getResult();

        return $configuracion;
    }

}
