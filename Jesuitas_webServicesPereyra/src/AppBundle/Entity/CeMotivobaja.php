<?php

namespace AppBundle\Entity;

/**
 * CeMotivobaja
 */
class CeMotivobaja
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $clavesegdgb;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var boolean
     */
    private $permitereingreso = '1';

    /**
     * @var integer
     */
    private $motivobajaid;

    /**
     * @var \AppBundle\Entity\CeTipobaja
     */
    private $tipobajaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeMotivobaja
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set clavesegdgb
     *
     * @param string $clavesegdgb
     *
     * @return CeMotivobaja
     */
    public function setClavesegdgb($clavesegdgb)
    {
        $this->clavesegdgb = $clavesegdgb;

        return $this;
    }

    /**
     * Get clavesegdgb
     *
     * @return string
     */
    public function getClavesegdgb()
    {
        return $this->clavesegdgb;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeMotivobaja
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set permitereingreso
     *
     * @param boolean $permitereingreso
     *
     * @return CeMotivobaja
     */
    public function setPermitereingreso($permitereingreso)
    {
        $this->permitereingreso = $permitereingreso;

        return $this;
    }

    /**
     * Get permitereingreso
     *
     * @return boolean
     */
    public function getPermitereingreso()
    {
        return $this->permitereingreso;
    }

    /**
     * Get motivobajaid
     *
     * @return integer
     */
    public function getMotivobajaid()
    {
        return $this->motivobajaid;
    }

    /**
     * Set tipobajaid
     *
     * @param \AppBundle\Entity\CeTipobaja $tipobajaid
     *
     * @return CeMotivobaja
     */
    public function setTipobajaid(\AppBundle\Entity\CeTipobaja $tipobajaid = null)
    {
        $this->tipobajaid = $tipobajaid;

        return $this;
    }

    /**
     * Get tipobajaid
     *
     * @return \AppBundle\Entity\CeTipobaja
     */
    public function getTipobajaid()
    {
        return $this->tipobajaid;
    }
}

