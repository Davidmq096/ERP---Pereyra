<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DB\Mysql\Admisiones;

use AppBundle\DB\Mysql\BaseDBManager;

/**
 * Description of SolicitudAdmisionDB
 *
 * @author inceptio
 */
class ReporteAsignacionDB extends BaseDBManager
{

    /*
     * Busqueda de solicitud por filtros
     */
    public function getReporteAsignacionByFilter($filters)
    {
        $where = "";
        if (!empty($filters['cicloid'])) {
            $where = " where ev.CicloId = " . $filters['cicloid'];
        }if (!empty($filters['nivelid'])) {
            $where = $where . " and ev.NivelId IN (";
            $countTemp = 0;
            if (count($filters['nivelid']) > 1) {
                foreach ($filters['nivelid'] as $valor) {
                    $countTemp++;
                    if (count($filters['nivelid']) == $countTemp) {
                        $where = $where . $valor;
                    } else {
                        $where = $where . $valor . ', ';
                    }
                }
                $where = $where . ")";
            } else {
                $where = $where . $filters['nivelid'] . ")";
            }
        }if (!empty($filters['gradoid'])) {
            $where = $where . " and ev.GradoId IN (";
            $countTemp = 0;
            if (count($filters['gradoid']) > 1) {
            foreach ($filters['gradoid'] as $valor) {
                $countTemp++;
                if (count($filters['gradoid']) == $countTemp) {
                    $where = $where . $valor;
                } else {
                    $where = $where . $valor . ', ';
                }
            }
            $where = $where . ")";
        } else {
            $where = $where . $filters['gradoid'] . ")";
        }
        }if (!empty($filters['nombre'])) {
            $where = $where . " and ev.Nombre LIKE '%" . $filters['nombre'] . "%'";
        }if (!empty($filters['apellidopaterno'])) {
            $where = $where . " and ev.ApellidoPaterno LIKE '%" . $filters['apellidopaterno'] . "%'";
        }if (!empty($filters['apellidomaterno'])) {
            $where = $where . " and ev.ApellidoMaterno LIKE '%" . $filters['apellidomaterno'] . "%'";
        }if (!empty($filters['folio'])) {
            $where = $where . " and ev.Folio = '" . $filters['folio'] . "'";
        }if (!empty($filters['clavesolicitud'])) {
            $where = $where . " and ev.ClaveSolicitud = '" . $filters['clavesolicitud'] . "'";
        }if (!empty($filters['clavefamiliar'])) {
            $where = $where . " and ev.ClaveFamiliar = '" . $filters['clavefamiliar'] . "'";
        }if (!empty($filters['fechainicio'])) {
            $f1 = new \DateTime($filters['fechainicio']);
            $f2 = new \DateTime($filters['fechafin']);
            $where = $where . " and ev.fechavalidacion between '" . $f1->format('d/m/Y') . "' and '" . $f2->format('d/m/Y') . "'";
        }

        $conn = $this->em->getConnection();
        $sql = "SELECT * FROM eventoevaluacionvista ev" . $where;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
