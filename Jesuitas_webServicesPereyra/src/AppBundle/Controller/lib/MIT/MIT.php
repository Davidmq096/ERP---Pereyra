<?php

namespace AppBundle\Controller\lib\MIT;

/**
 *Parametros de MIT (WebPay Plus)
 *
 * @author inceptio
 */
class MIT
{
    private $semillaae;
    private $datacero;
    private $url;
    private $user;
    private $password;
    private $idbranch;
    private $idcompany;
    
    
    function __construct($empresaid)
    {
        switch($empresaid)
        {
            case "1": //ciencias
                $this->semillaae = "E3B5AB90F52CC637D1AC842385EC6EA0";
                $this->datacero = "9265654881";
                $this->url = "https://bc.mitec.com.mx/p/gen";
                $this->user = "3I7AISUS0";
                $this->password = "XQSH6OSW19";
                $this->idbranch = "0001";
                $this->idcompany = "3I7A";
                break;
                
            case "2": //prosa
                $this->semillaae = "CBA60209B33DE001EF327B77B562DFAE";
                $this->datacero = "9265655102";
                $this->url = "https://bc.mitec.com.mx/p/gen";
                $this->user = "NW9ASIUS0";
                $this->password = "U5U2HH5KWC";
                $this->idbranch = "0002";
                $this->idcompany = "NW9A";
                break;
                
            default:
                break;
        }
    }
    
    //Funciones
    function getSemillaae() 
    {
        return $this->semillaae;
    }
    
    function getDatacero() 
    {
        return $this->datacero;
    }
    
    function getUrl() 
    {
        return $this->url;
    }
    
    function getUser() 
    {
        return $this->user;
    }
    
    function getPassword() 
    {
        return $this->password;
    }
    
    function getIdbranch() 
    {
        return $this->idbranch;
    }
    
    function getIdCompany() 
    {
        return $this->idcompany;
    }
}
