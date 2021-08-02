<?php

namespace AppBundle\Entity;

/**
 * AdFactoresapoyo
 */
class AdFactoresapoyo
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $factoresapoyoid;

    /**
     * @var \AppBundle\Entity\AdCategoriaapoyo
     */
    private $categoriaapoyoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdFactoresapoyo
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return AdFactoresapoyo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return AdFactoresapoyo
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
     * Get factoresapoyoid
     *
     * @return integer
     */
    public function getFactoresapoyoid()
    {
        return $this->factoresapoyoid;
    }

    /**
     * Set categoriaapoyoid
     *
     * @param \AppBundle\Entity\AdCategoriaapoyo $categoriaapoyoid
     *
     * @return AdFactoresapoyo
     */
    public function setCategoriaapoyoid(\AppBundle\Entity\AdCategoriaapoyo $categoriaapoyoid = null)
    {
        $this->categoriaapoyoid = $categoriaapoyoid;

        return $this;
    }

    /**
     * Get categoriaapoyoid
     *
     * @return \AppBundle\Entity\AdCategoriaapoyo
     */
    public function getCategoriaapoyoid()
    {
        return $this->categoriaapoyoid;
    }
}

