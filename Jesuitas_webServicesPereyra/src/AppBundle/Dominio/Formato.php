<?php

namespace AppBundle\Dominio;

use PhpOffice\PhpWord\TemplateProcessor;
use AppBundle\DB\DbmControlescolar;

/**
 * Description of Lugar
 *
 * @author Javier
 */
class Formato {

    function tokens($file, $tokens) {
        $path = $file['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $contenido = $ext == "docx" ? self::read_docx($file['tmp_name']) : self::read_doc($file['tmp_name']);
        preg_match_all('/\$\{(.*?)}/i', $contenido, $matches);

        if (count($matches[1]) == 0) {
            return array("El archivo no contiene ningun token", true);
        } else {
            $noEncontrados = array();
            foreach ($matches[1] as $toks) {
                if (!in_array($toks, $tokens)) {
                    array_push($noEncontrados, $toks);
                }
            }
            return array(implode(" <LI> ", $noEncontrados), empty($noEncontrados));
        }
    }

    function remplazarToken($vista, $ruta, $urltokens) {
        foreach($vista as $token=>$valor){
            if ($token=="Foto" || $token=="FotoFamiliar") {
                $valor=str_replace("data:image/png;base64,","",$valor);
                $valor=str_replace("data:image/jpeg;base64,","",$valor);
                $t=array("token"=>$token,"valor"=>$valor?$valor:"","esimagen"=>$valor?1:0);
            }else{
                $t=array("token"=>$token,"valor"=>$valor?$valor:"");
            }
						$tokens[]=$t;
        }
        $byteArr = str_split(file_get_contents($ruta));
        foreach ($byteArr as $key=>$val) { $byteArr[$key] = ord($val); }
        foreach ($byteArr as $byte){
            $bytes[]=$byte;
        }
        
        $fields=array("nombrearchivo"=>"archivo","contenido"=>$bytes,"tokens"=>$tokens,"tipo" => ENTORNO);

        $headers = array('Content-Type: application/json');
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $urltokens );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        $result=json_decode($result);
        
        $archivo = get_object_vars($result);
        $bytes=$archivo["contenido"];  

        $packed = "";
        
        foreach ( $bytes as $byte ) {
            $packed .= chr( $byte );
        }
        file_put_contents ($ruta,$packed);
       
        $formato = file_get_contents($ruta);
        $tamano = filesize($ruta);

        return array("formato" => $formato, "tamano" => $tamano);
    }

    function read_doc($file) {
        $fileHandle = fopen($file, "r");
        $line = @fread($fileHandle, filesize($file));
        $lines = explode(chr(0x0D), $line);
        $outtext = "";
        foreach ($lines as $thisline) {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE) || (strlen($thisline) == 0)) {
                
            } else {
                $outtext .= $thisline . " ";
            }
        }
        return $outtext;
    }

    function read_docx($file) {
        $striped_content = '';
        $content = '';
        $zip = zip_open($file);
        if (!$zip || is_numeric($zip))
            return false;

        while ($zip_entry = zip_read($zip)) {
            if (zip_entry_open($zip, $zip_entry) == FALSE)
                continue;
            if (zip_entry_name($zip_entry) != "word/document.xml")
                continue;
            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
            zip_entry_close($zip_entry);
        }// end while
        zip_close($zip);
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);
        return $striped_content;
    }

    function addFoto($blob, $m) {
    	preg_match_all("/([a-zA-Z0-9_]*);/", $blob, $matches);
    	$a = str_replace(' ', '+', $blob);
    	$a = substr($a,strpos($a,",")+1);
    	$a =  base64_decode($a);
    	$file = fopen($m.".".$matches[1][0],"w");
    	fwrite($file, $a);
    	fclose($file);    	
    	return array('src' => $m.'.'.$matches[1][0], "swh"=>"200");   	
    }

}
