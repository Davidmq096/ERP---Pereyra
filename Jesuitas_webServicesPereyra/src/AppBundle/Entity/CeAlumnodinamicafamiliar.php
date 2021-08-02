<?php

namespace AppBundle\Entity;

/**
 * CeAlumnodinamicafamiliar
 */
class CeAlumnodinamicafamiliar
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
    private $miembromuerteperdida;

    /**
     * @var boolean
     */
    private $cambioresidencia;

    /**
     * @var boolean
     */
    private $medioshermanos;

    /**
     * @var boolean
     */
    private $madrepadresoltero;

    /**
     * @var boolean
     */
    private $segundosmatrimonios;

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
    private $alumnodinamicafamiliarid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Parentesco
     */
    private $parentescoid;


    /**
     * Set ninguna
     *
     * @param boolean $ninguna
     *
     * @return CeAlumnodinamicafamiliar
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
     * @return CeAlumnodinamicafamiliar
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
     * @return CeAlumnodinamicafamiliar
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
     * @return CeAlumnodinamicafamiliar
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
     * @return CeAlumnodinamicafamiliar
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
     * @return CeAlumnodinamicafamiliar
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
     * @return CeAlumnodinamicafamiliar
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
     * Set miembromuerteperdida
     *
     * @param string $miembromuerteperdida
     *
     * @return CeAlumnodinamicafamiliar
     */
    public function setMiembromuerteperdida($miembromuerteperdida)
    {
        $this->miembromuerteperdida = $miembromuerteperdida;

        return $this;
    }

    /**
     * Get miembromuerteperdida
     *
     * @return string
     */
    public function getMiembromuerteperdida()
    {
        return $this->miembromuerteperdida;
    }

    /**
     * Set cambioresidencia
     *
     * @param boolean $cambioresidencia
     *
     * @return CeAlumnodinamicafamiliar
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
     * Set medioshermanos
     *
     * @param boolean $medioshermanos
     *
     * @return CeAlumnodinamicafamiliar
     */
    public function setMedioshermanos($medioshermanos)
    {
        $this->medioshermanos = $medioshermanos;

        return $this;
    }

    /**
     * Get medioshermanos
     *
     * @return boolean
     */
    public function getMedioshermanos()
    {
        return $this->medioshermanos;
    }

    /**
     * Set madrepadresoltero
     *
     * @param boolean $madrepadresoltero
     *
     * @return CeAlumnodinamicafamiliar
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
     * Set segundosmatrimonios
     *
     * @param boolean $segundosmatrimonios
     *
     * @return CeAlumnodinamicafamiliar
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
     * Set otros
     *
     * @param boolean $otros
     *
     * @return CeAlumnodinamicafamiliar
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
     * @return CeAlumnodinamicafamiliar
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
     * Get alumnodinamicafamiliarid
     *
     * @return integer
     */
    public function getAlumnodinamicafamiliarid()
    {
        return $this->alumnodinamicafamiliarid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnodinamicafamiliar
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set parentescoid
     *
     * @param \AppBundle\Entity\Parentesco $parentescoid
     *
     * @return CeAlumnodinamicafamiliar
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

