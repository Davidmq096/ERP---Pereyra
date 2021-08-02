<?php

namespace AppBundle\Entity;

/**
 * Tipomedios
 */
class Tipomedios
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
    private $tipomediosid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Tipomedios
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
     * @return Tipomedios
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
     * Get tipomediosid
     *
     * @return integer
     */
    public function getTipomediosid()
    {
        return $this->tipomediosid;
    }
}

