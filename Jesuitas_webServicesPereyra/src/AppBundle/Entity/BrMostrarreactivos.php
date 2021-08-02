<?php

namespace AppBundle\Entity;

/**
 * BrMostrarreactivos
 */
class BrMostrarreactivos
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $cantidad;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $mostrarreactivosid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BrMostrarreactivos
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
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return BrMostrarreactivos
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BrMostrarreactivos
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
     * Get mostrarreactivosid
     *
     * @return integer
     */
    public function getMostrarreactivosid()
    {
        return $this->mostrarreactivosid;
    }
}

