<?php

namespace AppBundle\Dominio;

/**
 * Description of Evaluacion
 *
 * @author inceptio
 */
class Correo{
	/**
	 * $destinatarios: array("correo1@test.com","correo1@test.com")
	 * $parametros: array("campo1" => $valor1, "campo2" => $valor2)
	 * $correo: AppBundle\Dominio\Entity\Correo.php
	 */
	public static function ServicioCorreo($destinatarios, $parametros, $correo, \Swift_Mailer $mail, $attachment=null){
		$body=$correo->getCuerpo();
		foreach($parametros as $key=> $value){
			$body=str_replace('{'.$key.'}', $value, $body);
		}

		$mensaje=\Swift_Message::newInstance()
			->setSubject($correo->getMotivo())
			->setTo($destinatarios)
			->setBody($body, 'text/html');
		if($attachment){
			if(is_array($attachment)){
				$mensaje->attach(\Swift_Attachment::fromPath($attachment["ruta"])->setFilename($attachment["nombre"]));
			}else{
				$mensaje->addPart($attachment, 'text/calendar');
			}
		}
		return $mail->send($mensaje);
	}
}