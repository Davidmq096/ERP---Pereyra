<?php

namespace AppBundle\Entity;

/**
 * BrEstatusreactivo
 */
class BrEstatusreactivo
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
    private $estatusreactivoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrEstatusreactivo
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
     * @return BrEstatusreactivo
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
     * Get estatusreactivoid
     *
     * @return integer
     */
    public function getEstatusreactivoid()
    {
        return $this->estatusreactivoid;
    }
}

