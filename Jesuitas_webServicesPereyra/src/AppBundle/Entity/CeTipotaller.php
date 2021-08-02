<?php

namespace AppBundle\Entity;

/**
 * CeTipotaller
 */
class CeTipotaller
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
    private $tipotallerid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipotaller
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
     * @return CeTipotaller
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
     * Get tipotallerid
     *
     * @return integer
     */
    public function getTipotallerid()
    {
        return $this->tipotallerid;
    }
}

