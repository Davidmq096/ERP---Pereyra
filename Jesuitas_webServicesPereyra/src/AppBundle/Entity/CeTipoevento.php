<?php

namespace AppBundle\Entity;

/**
 * CeTipoevento
 */
class CeTipoevento
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
     * @var string
     */
    private $color;

    /**
     * @var integer
     */
    private $tipoeventoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipoevento
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
     * @return CeTipoevento
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
     * Set color
     *
     * @param string $color
     *
     * @return CeTipoevento
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get tipoeventoid
     *
     * @return integer
     */
    public function getTipoeventoid()
    {
        return $this->tipoeventoid;
    }
}

