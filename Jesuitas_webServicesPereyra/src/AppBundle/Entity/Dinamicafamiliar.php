<?php

namespace AppBundle\Entity;

/**
 * Dinamicafamiliar
 */
class Dinamicafamiliar
{
    /**
     * @var boolean
     */
    private $ninguna;

    /**
     * @var boolean
     */
    private $divorcio;

    /**
     * @var boolean
     */
    private $separacion;

    /**
     * @var boolean
     */
    private $custodia;

    /**
     * @var boolean
     */
    private $enfermedadgrave;

    /**
     * @var string
     */
    private $miembroenfermedadgrave;

    /**
     * @var boolean
     */
    private $muerteperdida;

    /**
     * @var string
     */
    private $miembromuerteperdidad;

    /**
     * @var boolean
     */
    private $cambioresidencia;

    /**
     * @var boolean
     */
    private $medioshermano;

    /**
     * @var boolean
     */
    private $segundosmatrimonios;

    /**
     * @var boolean
     */
    private $madrepadresoltero;

    /**
     * @var boolean
     */
    private $otros;

    /**
     * @var string
     */
    private $descripcionotros;

    /**
     * @var integer
     */
    private $dinamicafamiliarid;

    /**
     * @var \AppBundle\Entity\Parentesco
     */
    private $parentescoid;


    /**
     * Set ninguna
     *
     * @param boolean $ninguna
     *
     * @return Dinamicafamiliar
     */
    public function setNinguna($ninguna)
    {
        $this->ninguna = $ninguna;

        return $this;
    }

    /**
     * Get ninguna
     *
     * @return boolean
     */
    public function getNinguna()
    {
        return $this->ninguna;
    }

    /**
     * Set divorcio
     *
     * @param boolean $divorcio
     *
     * @return Dinamicafamiliar
     */
    public function setDivorcio($divorcio)
    {
        $this->divorcio = $divorcio;

        return $this;
    }

    /**
     * Get divorcio
     *
     * @return boolean
     */
    public function getDivorcio()
    {
        return $this->divorcio;
    }

    /**
     * Set separacion
     *
     * @param boolean $separacion
     *
     * @return Dinamicafamiliar
     */
    public function setSeparacion($separacion)
    {
        $this->separacion = $separacion;

        return $this;
    }

    /**
     * Get separacion
     *
     * @return boolean
     */
    public function getSeparacion()
    {
        return $this->separacion;
    }

    /**
     * Set custodia
     *
     * @param boolean $custodia
     *
     * @return Dinamicafamiliar
     */
    public function setCustodia($custodia)
    {
        $this->custodia = $custodia;

        return $this;
    }

    /**
     * Get custodia
     *
     * @return boolean
     */
    public function getCustodia()
    {
        return $this->custodia;
    }

    /**
     * Set enfermedadgrave
     *
     * @param boolean $enfermedadgrave
     *
     * @return Dinamicafamiliar
     */
    public function setEnfermedadgrave($enfermedadgrave)
    {
        $this->enfermedadgrave = $enfermedadgrave;

        return $this;
    }

    /**
     * Get enfermedadgrave
     *
     * @return boolean
     */
    public function getEnfermedadgrave()
    {
        return $this->enfermedadgrave;
    }

    /**
     * Set miembroenfermedadgrave
     *
     * @param string $miembroenfermedadgrave
     *
     * @return Dinamicafamiliar
     */
    public function setMiembroenfermedadgrave($miembroenfermedadgrave)
    {
        $this->miembroenfermedadgrave = $miembroenfermedadgrave;

        return $this;
    }

    /**
     * Get miembroenfermedadgrave
     *
     * @return string
     */
    public function getMiembroenfermedadgrave()
    {
        return $this->miembroenfermedadgrave;
    }

    /**
     * Set muerteperdida
     *
     * @param boolean $muerteperdida
     *
     * @return Dinamicafamiliar
     */
    public function setMuerteperdida($muerteperdida)
    {
        $this->muerteperdida = $muerteperdida;

        return $this;
    }

    /**
     * Get muerteperdida
     *
     * @return boolean
     */
    public function getMuerteperdida()
    {
        return $this->muerteperdida;
    }

    /**
     * Set miembromuerteperdidad
     *
     * @param string $miembromuerteperdidad
     *
     * @return Dinamicafamiliar
     */
    public function setMiembromuerteperdidad($miembromuerteperdidad)
    {
        $this->miembromuerteperdidad = $miembromuerteperdidad;

        return $this;
    }

    /**
     * Get miembromuerteperdidad
     *
     * @return string
     */
    public function getMiembromuerteperdidad()
    {
        return $this->miembromuerteperdidad;
    }

    /**
     * Set cambioresidencia
     *
     * @param boolean $cambioresidencia
     *
     * @return Dinamicafamiliar
     */
    public function setCambioresidencia($cambioresidencia)
    {
        $this->cambioresidencia = $cambioresidencia;

        return $this;
    }

    /**
     * Get cambioresidencia
     *
     * @return boolean
     */
    public function getCambioresidencia()
    {
        return $this->cambioresidencia;
    }

    /**
     * Set medioshermano
     *
     * @param boolean $medioshermano
     *
     * @return Dinamicafamiliar
     */
    public function setMedioshermano($medioshermano)
    {
        $this->medioshermano = $medioshermano;

        return $this;
    }

    /**
     * Get medioshermano
     *
     * @return boolean
     */
    public function getMedioshermano()
    {
        return $this->medioshermano;
    }

    /**
     * Set segundosmatrimonios
     *
     * @param boolean $segundosmatrimonios
     *
     * @return Dinamicafamiliar
     */
    public function setSegundosmatrimonios($segundosmatrimonios)
    {
        $this->segundosmatrimonios = $segundosmatrimonios;

        return $this;
    }

    /**
     * Get segundosmatrimonios
     *
     * @return boolean
     */
    public function getSegundosmatrimonios()
    {
        return $this->segundosmatrimonios;
    }

    /**
     * Set madrepadresoltero
     *
     * @param boolean $madrepadresoltero
     *
     * @return Dinamicafamiliar
     */
    public function setMadrepadresoltero($madrepadresoltero)
    {
        $this->madrepadresoltero = $madrepadresoltero;

        return $this;
    }

    /**
     * Get madrepadresoltero
     *
     * @return boolean
     */
    public function getMadrepadresoltero()
    {
        return $this->madrepadresoltero;
    }

    /**
     * Set otros
     *
     * @param boolean $otros
     *
     * @return Dinamicafamiliar
     */
    public function setOtros($otros)
    {
        $this->otros = $otros;

        return $this;
    }

    /**
     * Get otros
     *
     * @return boolean
     */
    public function getOtros()
    {
        return $this->otros;
    }

    /**
     * Set descripcionotros
     *
     * @param string $descripcionotros
     *
     * @return Dinamicafamiliar
     */
    public function setDescripcionotros($descripcionotros)
    {
        $this->descripcionotros = $descripcionotros;

        return $this;
    }

    /**
     * Get descripcionotros
     *
     * @return string
     */
    public function getDescripcionotros()
    {
        return $this->descripcionotros;
    }

    /**
     * Get dinamicafamiliarid
     *
     * @return integer
     */
    public function getDinamicafamiliarid()
    {
        return $this->dinamicafamiliarid;
    }

    /**
     * Set parentescoid
     *
     * @param \AppBundle\Entity\Parentesco $parentescoid
     *
     * @return Dinamicafamiliar
     */
    public function setParentescoid(\AppBundle\Entity\Parentesco $parentescoid = null)
    {
        $this->parentescoid = $parentescoid;

        return $this;
    }

    /**
     * Get parentescoid
     *
     * @return \AppBundle\Entity\Parentesco
     */
    public function getParentescoid()
    {
        return $this->parentescoid;
    }
}

