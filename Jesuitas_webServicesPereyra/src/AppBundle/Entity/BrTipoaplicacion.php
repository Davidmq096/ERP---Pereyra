<?php

namespace AppBundle\Entity;

/**
 * BrTipoaplicacion
 */
class BrTipoaplicacion
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
    private $tipoaplicacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrTipoaplicacion
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
     * @return BrTipoaplicacion
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
     * Get tipoaplicacionid
     *
     * @return integer
     */
    public function getTipoaplicacionid()
    {
        return $this->tipoaplicacionid;
    }
}

