<?php

namespace AppBundle\Entity;

/**
 * BcTipobeca
 */
class BcTipobeca
{
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
    private $tipobecaid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BcTipobeca
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
     * @return BcTipobeca
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
     * Get tipobecaid
     *
     * @return integer
     */
    public function getTipobecaid()
    {
        return $this->tipobecaid;
    }
}

