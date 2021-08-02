<?php

namespace AppBundle\Dominio;

use AppBundle\Controller\lib\MIT\MIT;
use AppBundle\Dominio\lib\AES\AESCrypto;

require_once "lib/nusoap/nusoap.php";
require_once "lib/AES/AES.php";
//require_once("./Controller/lib/MIT/ConfiguracionMIT.php");

/**
 * Description of Evaluacion
 *
 * @author inceptio
 */

class PagoLinea
{

    public static function SolicitudPago($xml, $empresaid)
    {
        $aes = new AESCrypto();
        $mit = new MIT($empresaid);
        $xml = $aes->encriptar($xml, $mit->getSemillaae());
        $xml = "<pgs><data0>" . $mit->getDatacero() . "</data0><data>" . $xml . "</data></pgs>";
        $xml = urlencode($xml);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $mit->getUrl());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('cache-control: no-cache', 'Content-Type: application/x-www-form-urlencoded')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_POSTFIELDS, "xml=" . $xml);

        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_TRANSFER_ENCODING, "utf-8");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        } else {
            $result = $aes->desencriptar($result, $mit->getSemillaae());

            if (!$result) {
                return "Error: Ocurrio un error en la solucitud de pago.";
            } else {
                $succes = strpos($result, "<cd_response>success</cd_response>");
                if ($succes !== false) {
                    $inicio = strpos($result, "<nb_url>");
                    $fin = strpos($result, "</nb_url>");
                    $url = substr($result, ($inicio + 8), ($fin - $inicio - 8));
                    return $url;
                } else {
                    return "Error: " . $result;
                }
            }
        }

        curl_close($ch);
    }

    public static function RecibirPago($respuesta, $empresaid)
    {
        $mit = new MIT($empresaid);
        $aes = new AESCrypto();
        $xml = $aes->desencriptar($respuesta, $mit->getSemillaae());

        return $xml;
    }

    public static function XML2JSON($xml)
    {
        $xml = str_replace(array("\n", "\r", "\t"), '', $xml);
        $xml = trim(str_replace('"', "'", $xml));
        $xml = simplexml_load_string($xml);

        $json = json_encode($xml);
        $json = json_decode($json, true);

        return $json;
    }

    public static function FechaEsp2Gen($fecha)
    {
        $dia = substr($fecha, 0, 2);
        $mes = substr($fecha, 3, 2);
        $year = substr($fecha, 6);

        return $year . "-" . $mes . "-" . $dia;
    }

    /*
     identificador: Matricula del alumno o folio de solicitud de admision, llenandolo a 6 numeros
     tipo: 0 = matricula, 1 = folio de admision
     ciclo: los primero 4 digitos para tomar el primer año 
     nivelid: el id del nivel
     grado: el numero de grado
     documento: los primero 6 digitos 
     subconceptoid: el id del subconcepto, llenandolo a 3 numeros
    */
    public function GenerarReferencia($identificador, $tipo, $ciclo, $nivelid, $grado, $documento, $subconceptoid)
    {
        $identificador = str_pad($identificador, 6, "0", STR_PAD_LEFT);
        $ciclo = $ciclo->format('Y');//substr($ciclo, 0, 4);
        $grado = substr($grado, 0, 1);
        $documento = substr($documento, 0, 6);
        $subconceptoid = str_pad($subconceptoid, 3, "0", STR_PAD_LEFT);
        $referencia = $identificador . $tipo . $ciclo . $nivelid . $grado . $documento . $subconceptoid;

        return $referencia;
    }


    public static function GetRespuesta($xml, $empresaid)
    {
        $aes = new AESCrypto();
        $mit = new MIT($empresaid);
        $xml = $aes->encriptar($xml, $mit->getSemillaae());
        return $xml;
    }
}
