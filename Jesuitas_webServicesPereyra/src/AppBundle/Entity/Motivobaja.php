<?php

namespace AppBundle\Entity;

/**
 * Motivobaja
 */
class Motivobaja
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
    private $motivobajaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Motivobaja
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
     * @return Motivobaja
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
     * Get motivobajaid
     *
     * @return integer
     */
    public function getMotivobajaid()
    {
        return $this->motivobajaid;
    }
}

