<?php

namespace AppBundle\Dominio;

/**
 * Description of Evaluacion
 *
 * @author inceptio
 */
class FireBase
{

    /**
     * $destinatarios: array("correo1@test.com","correo1@test.com")
     * $parametros: array("campo1" => $valor1, "campo2" => $valor2)
     * $correo: AppBundle\Dominio\Entity\Correo.php
     */
    public static function ServicioFireBase($headers,$fields)
    {
        #Send Reponse To FireBase Server	
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
