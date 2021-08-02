<?php

namespace AppBundle\Rest;
use \FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class Api{

    public static $version = "0.0.1";

    public static function Input(){
        $datos = file_get_contents('php://input');
        return json_decode($datos, true);
    }

    public static function Ok($message, $body = null){
        $data = [
            'version' => self::$version,
            'status' => "success",
            'message' => $message
        ];

        if($body !== null){
            $data['data'] = $body;
        }

        header("X-AUTH-VERSION: " . self::$version);
        header("Access-Control-Expose-Headers: X-AUTH-VERSION");
        header("Content-Type: application/json; charset=utf-8");

        return new View($data, Response::HTTP_OK);
    }
    
    public static function download($file, $contentType){
        $array = explode(';', $file);
        
        if (strpos($array[0], 'data:') === 0) {
            $contentType = substr($array[0], 5);
        }
        
        // Get image
        $data = array_pop($array);
        if (strpos($data, 'base64,') === 0) {
            $data = substr($data, 7);
        }
        
        //echo '<p>' . $contentType . '</p><p>' . $data . '</p>';
        
        // Print image
        
        $response = new Response();
        $response->headers->set('Content-Type', $contentType);
        $response->setContent(base64_decode($data));
        return $response;
    }

    public static function Error($code, $message){
        $data = [
            'version' => self::$version,
            'status' => "error",
            'error' => [
                'code' => $code,
                'message' => $message
            ]
        ];

        header("X-AUTH-VERSION: " . self::$version);
        header("Access-Control-Expose-Headers: X-AUTH-VERSION");
        header("Content-Type: application/json; charset=utf-8");

        return new View($data, $code);
    }
}