<?php

namespace AppBundle\Dominio;

/**
 * Description of GenerarClave
 *
 * @author inceptio
 */
class ClasificadorAlumno {

    public static function clasificaciondeAlumnos($alumnos, $search, $date){
        $alumnosFinal = [];
        $fecha = new \DateTime();
        foreach($alumnos as $alumno){
            $fechaInicio = $alumno[$date];
            if ($fechaInicio instanceof \DateTime) {
                // true
            }else{
                $fechaInicio = new \DateTime(date("Y-m-d", strtotime($fechaInicio)));
            }

            if(count($alumnosFinal) == 0){
                $alumnosFinal[] = $alumno;
            }else{
                $find = false;
                if($alumno['nivelid'] == 4 || $alumno['NivelId'] == 4){
                    foreach($alumnosFinal as $i => $al){
                        if($al[$search] ==  $alumno[$search]){
                            if($fechaInicio){
                                if($fecha > $fechaInicio){
                                    $find = false;
                                    array_splice($alumnosFinal, $i, 1);
                                }else{
                                    $find = true;
                                }
                            }else{
                                $find = true;
                            }
                        }
                    }
                }
                if(!$find){
                    $alumnosFinal[] = $alumno;
                }
            }
        }
        return $alumnosFinal;
    }

    public static function objetToArray($object, $assoc=TRUE, $empty=''){
        $res_arr = array(); 

        if (!empty($object)) { 

            $arrObj = is_object($object) ? get_object_vars($object) : $object;

            $i=0; 
            foreach ($arrObj as $key => $val) { 
                $akey = ($assoc !== FALSE) ? $key : $i; 
                if (is_array($val) || is_object($val)) { 
                    $res_arr[$akey] = (empty($val)) ? $empty : ClasificadorAlumno::objetToArray($val); 
                } 
                else { 
                    $res_arr[$akey] = (empty($val)) ? $empty : (string)$val; 
                } 

            $i++; 
            }

        } 

        return $res_arr;
    }


}
