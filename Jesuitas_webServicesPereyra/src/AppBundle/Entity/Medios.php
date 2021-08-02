<?php

namespace AppBundle\Entity;

/**
 * Medios
 */
class Medios
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
    private $mediosid;

    /**
     * @var \AppBundle\Entity\Tipomedios
     */
    private $tipomedioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Medios
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
     * @return Medios
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
     * Get mediosid
     *
     * @return integer
     */
    public function getMediosid()
    {
        return $this->mediosid;
    }

    /**
     * Set tipomedioid
     *
     * @param \AppBundle\Entity\Tipomedios $tipomedioid
     *
     * @return Medios
     */
    public function setTipomedioid(\AppBundle\Entity\Tipomedios $tipomedioid = null)
    {
        $this->tipomedioid = $tipomedioid;

        return $this;
    }

    /**
     * Get tipomedioid
     *
     * @return \AppBundle\Entity\Tipomedios
     */
    public function getTipomedioid()
    {
        return $this->tipomedioid;
    }
}

