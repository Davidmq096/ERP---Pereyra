<?php

namespace AppBundle\Entity;

/**
 * CeTipogrupo
 */
class CeTipogrupo
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
    private $tipogrupoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipogrupo
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
     * @return CeTipogrupo
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
     * Get tipogrupoid
     *
     * @return integer
     */
    public function getTipogrupoid()
    {
        return $this->tipogrupoid;
    }
}

