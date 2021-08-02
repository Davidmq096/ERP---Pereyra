<?php

namespace AppBundle\Entity;

/**
 * BrMedioaplicacion
 */
class BrMedioaplicacion
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
    private $medioaplicacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrMedioaplicacion
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
     * @return BrMedioaplicacion
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
     * Get medioaplicacionid
     *
     * @return integer
     */
    public function getMedioaplicacionid()
    {
        return $this->medioaplicacionid;
    }
}

