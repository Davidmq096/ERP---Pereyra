<?php

namespace AppBundle\Entity;

/**
 * BrTiporeactivo
 */
class BrTiporeactivo
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $maxrespuesta;

    /**
     * @var integer
     */
    private $minrespuesta;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $tiporeactivoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrTiporeactivo
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
     * Set maxrespuesta
     *
     * @param integer $maxrespuesta
     *
     * @return BrTiporeactivo
     */
    public function setMaxrespuesta($maxrespuesta)
    {
        $this->maxrespuesta = $maxrespuesta;

        return $this;
    }

    /**
     * Get maxrespuesta
     *
     * @return integer
     */
    public function getMaxrespuesta()
    {
        return $this->maxrespuesta;
    }

    /**
     * Set minrespuesta
     *
     * @param integer $minrespuesta
     *
     * @return BrTiporeactivo
     */
    public function setMinrespuesta($minrespuesta)
    {
        $this->minrespuesta = $minrespuesta;

        return $this;
    }

    /**
     * Get minrespuesta
     *
     * @return integer
     */
    public function getMinrespuesta()
    {
        return $this->minrespuesta;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BrTiporeactivo
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
     * Get tiporeactivoid
     *
     * @return integer
     */
    public function getTiporeactivoid()
    {
        return $this->tiporeactivoid;
    }
}

