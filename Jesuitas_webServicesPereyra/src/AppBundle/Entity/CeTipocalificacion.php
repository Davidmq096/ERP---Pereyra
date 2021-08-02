<?php

namespace AppBundle\Entity;

/**
 * CeTipocalificacion
 */
class CeTipocalificacion
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
    private $tipocalificacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipocalificacion
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
     * @return CeTipocalificacion
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
     * Get tipocalificacionid
     *
     * @return integer
     */
    public function getTipocalificacionid()
    {
        return $this->tipocalificacionid;
    }
}

