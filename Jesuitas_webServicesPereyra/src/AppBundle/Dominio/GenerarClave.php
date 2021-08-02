<?php

namespace AppBundle\Dominio;


/**
 * Description of GenerarClave
 *
 * @author inceptio
 */
class GenerarClave {

	public static function Generarclave($longitudPass = 8) {
    	//Se define una cadena de caractares. Te recomiendo que uses esta.
    	$cadena = "1234567890QWERTYUIOPASDFGHJKLZXCVBNM";
    	//Obtenemos la longitud de la cadena de caracteres
    	$longitudCadena=strlen($cadena);
    	
    	//Se define la variable que va a contener la contrase�a
    	$pass = "";
    	
    	//Creamos la contrase�a
    	for($i=1 ; $i<=$longitudPass ; $i++){
    		//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
    		$pos=rand(0,$longitudCadena);
    		
    		//Vamos formando la contrase�a en cada iteraccion del bucle, a�adiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
    		$pass .= substr($cadena,$pos,1);
    	}
    	return $pass;
    }

}
