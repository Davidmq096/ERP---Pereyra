<?php

namespace AppBundle\Entity;

/**
 * CeTipobaja
 */
class CeTipobaja
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $tipobajaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipobaja
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeTipobaja
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
     * Get tipobajaid
     *
     * @return integer
     */
    public function getTipobajaid()
    {
        return $this->tipobajaid;
    }
}

