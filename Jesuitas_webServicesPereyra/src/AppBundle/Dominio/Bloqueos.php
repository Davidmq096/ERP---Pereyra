<?php

namespace AppBundle\Dominio;

use AppBundle\DB\DbmCobranza;
use AppBundle\DB\Mysql\BaseDBManager;
use Doctrine\ORM\Query\Expr;

/**
 * Description of Bloqueos
 *
 * @author inceptio
 */
class Bloqueos
{

    public static function BloqueoManualVigenteByAlumno($dbm, $alumnoporcicloid, $tipobloqueoid)
    {
        $objeto = [];
        $bloqueovigente = $dbm->getByParametersRepositorios(
            'CbBloqueomanual',
            [
                'alumnoporcicloid' => $alumnoporcicloid,
                'estatusbloqueoid'  => 1
            ]
        );
        foreach ($bloqueovigente as $bloqueo) {
            if (new \DateTime() < $bloqueo->getFechainicio()) {
                continue;
            }
            foreach ($tipobloqueoid as $t) {
                $motivo = $dbm->getOneByParametersRepositorio('CbTipobloqueoporbloqueomanual', array(
                    'bloqueomanualid' => $bloqueo->getBloqueomanualid(),
                    'tipobloqueoid' => $t
                ));
                if (!$motivo) {
                    continue;
                }
                switch ($t) {
                    case 1:
                        $objeto['bloqueocalificacion'] = true;
                        $objeto['observacionescalificacion'] = $bloqueo->getObservaciones();
                        break;
                    case 2:
                        $objeto['bloqueoimpresion'] = true;
                        $objeto['observacionesimpresion'] = $bloqueo->getObservaciones();
                        break;
                    case 3:
                        $objeto['bloqueopago'] = true;
                        $objeto['observacionespago'] = $bloqueo->getObservaciones();
                        break;
                }
            }
        }
        return $objeto;
    }

    public function BuscarColegiaturasVencida($dbm, $filtros)
    {
        $cv = ['bloqueoadeudo' => null, "observacionesadeudo" => null];
        $numcolegiaturas = $dbm->getRepositorioById('Parametros', 'nombre', 'Numerocolegiaturabloqueopagodiverso');
        $msjReinscripcion = $dbm->getRepositorioById('Parametros', 'nombre', 'MensajeBloqueoReinscripcion');


        if ($filtros['alumnoid'] || $filtros['clavefamiliarid']) {
            $colegiaturas = $dbm->BuscarColegiaturasVencida($filtros);
        }
        if ($colegiaturas && count($colegiaturas) >= ($numcolegiaturas ? $numcolegiaturas->getValor() : 1)) {
            $cv['bloqueoadeudo'] = true;
            $cv['observacionesadeudo'] = $msjReinscripcion ? $msjReinscripcion->getValor() : '';
            $cv['numcolegiaturas'] = count($colegiaturas);
        }
        return $cv;
    }

    public function BuscarDocumentosAlumnos($dbm, $alumnoporcicloid)
    {

        if ($alumnoporcicloid) {
            $alumnociclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $alumnoporcicloid);
        }
        return $alumnociclo && $alumnociclo->getDocumentosreinscripcion() ? false : true;
    }

    public function BuscarDatosactualizadosAlumno($dbm, $alumnoid)
    {

        $ciclo = $dbm->getOneByParametersRepositorio('CePeriodoactualizacion', array(
            "activo" => 1
        ));
        $alumno = $dbm->getRepositorioById('CeAlumno', 'alumnoid', $alumnoid);

        if (!$ciclo) {
            return false;
        }

        if ($alumno->getFechaactualizacion() >= $ciclo->getFechainicio()) {
            return false;
        } else {
            return true;
        }

        return false;
    }

    public function BloqueoJuntaAlumno ($dbm, $alumnoporcicloid) {
        $bloqueo = $dbm->getRepositoriosModelo("CeAsistenciaporpadreotutor", ["d"],
            [["tipoasistenciaid = 2 and d.estatusinasistenciaid = 1 and h.bloqueocalificacion = 1 and d.alumnoporcicloid =" . $alumnoporcicloid]], false, true, [
                ["entidad" => "CeJuntapadretutor", "alias" => "h", "left" => false, "on" => "h.juntapadreotutorid = d.juntapadreotutorid"],
            ])[0];

        if($bloqueo) {
            return true;
        } else {
            return false;
        }
    }

    public function BloqueoAlumno($dbm, $filtros)
    {
        /*
        filtro = {
        (obligatorio) tipo: 1 - Pago diversos
                            2 - Consulta calificaciones
                            3 - Re-inscripcion
                            4 - Inscripcion
        (opcional) alumnoporcicloid
        (opcional) solicitudadmisionid
        }
        */
        $objeto = array(
            'bloqueopago' => null,
            'observacionespago' => null,
            'bloqueoimpresion' => null,
            'observacionesimpresion' => null,
            'bloqueocalificacion' => null,
            'observacionescalificacion' => null,
            'bloqueoadeudo' => null,
            'bloqueopagosdiversos' => null,
            'bloqueocalificaciones' => null,
            'bloqueoreinscripcion' => null,
            'bloqueojunta' => null,
            'observacionesjunta' => null
        );

        $parampagosdiversos = $dbm->getRepositorioById('Parametros', 'nombre', 'BloqueoPagosConceptosDiversos');
        $paramcalificaciones = $dbm->getRepositorioById('Parametros', 'nombre', 'BloqueoConsultaCalificaciones');
        $paramreinscripciones = $dbm->getRepositorioById('Parametros', 'nombre', 'BloqueoReinscripcion');
        $alumnociclo = $dbm->getRepositorioById('CeAlumnoporciclo', 'alumnoporcicloid', $filtros['alumnoporcicloid']);
        $mensajeprincipal = $dbm->getRepositorioById('Parametros', 'nombre', 'MensajePrincipalBloqueos');
        $msjActualizacionDatos = $dbm->getRepositorioById('Parametros', 'nombre', 'MensajeBloqueoActualizacionDatos');
        $msjEntregaDocumentos = $dbm->getRepositorioById('Parametros', 'nombre', 'MensajeBloqueoEntregaDocumentos');
        $msjJunta = $dbm->getRepositorioById('Parametros', 'nombre', 'MensajeBloqueoJunta');

        switch ($filtros["tipo"]) {
            case 1: //Pago diversos
                if ($parampagosdiversos->getValor() != "1") {
                    return false;
                }
                $tipobloqueoid = [3];
                $filtros['alumnoid'] = $alumnociclo->getAlumnoid()->getAlumnoid();
                $bv = self::BloqueoManualVigenteByAlumno($dbm, $filtros['alumnoporcicloid'], $tipobloqueoid);
                $colegiaturas = self::BuscarColegiaturasVencida($dbm, $filtros);
                $objeto['bloqueoadeudo'] = $colegiaturas['bloqueoadeudo'];
                $objeto['observacionesadeudo'] = $colegiaturas['observacionesadeudo'];
                $objeto['numcolegiaturas'] = $colegiaturas['numcolegiaturas'];
                $objeto['bloqueopago'] = $bv['bloqueopago'];
                $objeto['observacionespago'] = $bv['observacionespago'];
                $objeto['mensajeprincipal'] = $mensajeprincipal ? $mensajeprincipal->getValor() : null;
                break;
            case 2: //Consulta calificaciones
                if ($paramcalificaciones->getValor() != "1") {
                    $junta = self::BloqueoJuntaAlumno($dbm, $filtros['alumnoporcicloid']);
                    if($junta) {
                        $objeto['bloqueojunta'] = $junta;
                        $objeto['observacionesjunta'] = $msjJunta ? $msjJunta->getValor() : null; 
                        return $objeto;
                    } else {
                        return false;
                    }
                }
                $tipobloqueoid = [1];
                $filtros['alumnoid'] = $alumnociclo->getAlumnoid()->getAlumnoid();
                $bv = self::BloqueoManualVigenteByAlumno($dbm, $filtros['alumnoporcicloid'], $tipobloqueoid);
                $colegiaturas = self::BuscarColegiaturasVencida($dbm, $filtros);
                $objeto['bloqueoadeudo'] = $colegiaturas['bloqueoadeudo'];
                $objeto['observacionesadeudo'] = $colegiaturas['observacionesadeudo'];
                $objeto['bloqueocalificacion'] = $bv['bloqueocalificacion'];
                $objeto['observacionescalificacion'] = $bv['observacionescalificacion'];
                $junta = self::BloqueoJuntaAlumno($dbm, $filtros['alumnoporcicloid']);
                $objeto['bloqueojunta'] = $junta;
                $objeto['observacionesjunta'] = $msjJunta ? $msjJunta->getValor() : null; 

                break;
            case 3: //Re-inscripcion
                if ($paramreinscripciones->getValor() != "1") {
                    return false;
                }
                $tipobloqueoid = [2];
                $filtros['alumnoid'] = $alumnociclo->getAlumnoid()->getAlumnoid();

                $bv = self::BloqueoManualVigenteByAlumno($dbm, $filtros['alumnoporcicloid'], $tipobloqueoid);
                $objeto['bloqueoimpresion'] = $bv['bloqueoimpresion'];
                $objeto['observacionesimpresion'] = $bv['observacionesimpresion'];

                $colegiaturas = self::BuscarColegiaturasVencida($dbm, $filtros);
                $objeto['bloqueoadeudo'] = $colegiaturas['bloqueoadeudo'];
                $objeto['observacionesadeudo'] = $colegiaturas['observacionesadeudo'];
                
                $objeto['documentosentregados'] = self::BuscarDocumentosAlumnos($dbm, $filtros['alumnoporcicloid']);
                $objeto['observacionesdocumentos'] = $objeto['documentosentregados'] ?
                    $msjEntregaDocumentos ? $msjEntregaDocumentos->getValor() : '' : null;

                $objeto['datosactualizados'] = self::BuscarDatosactualizadosAlumno($dbm, $filtros['alumnoid']);
                $objeto['observacionesdatos'] = $objeto['datosactualizados'] ?
                    $msjActualizacionDatos ? $msjActualizacionDatos->getValor() : '' : null;    
                $objeto['mensajeprincipal'] = $mensajeprincipal ? $mensajeprincipal->getValor() : null;
                break;
            case 4: //Inscripcion (Pendoiente desarrollo)
            //if Parametro de inscripcion !=1 return false
                //Metodo adeudoscolegiaturashermanos
                //Metodo entregadocuemntosadmision
                break;
        }

        return $objeto;
    }
}
