<?php

namespace AppBundle\Entity;

/**
 * AdCategoriaapoyo
 */
class AdCategoriaapoyo
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
    private $descripcion;

    /**
     * @var integer
     */
    private $categoriaapoyoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdCategoriaapoyo
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
     * @return AdCategoriaapoyo
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return AdCategoriaapoyo
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
     * Get categoriaapoyoid
     *
     * @return integer
     */
    public function getCategoriaapoyoid()
    {
        return $this->categoriaapoyoid;
    }
}

