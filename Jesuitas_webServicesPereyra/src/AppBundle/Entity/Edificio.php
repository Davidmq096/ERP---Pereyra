<?php

namespace AppBundle\Entity;

/**
 * Edificio
 */
class Edificio
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $edificioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Edificio
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
     * @return Edificio
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
     * Get edificioid
     *
     * @return integer
     */
    public function getEdificioid()
    {
        return $this->edificioid;
    }
}

