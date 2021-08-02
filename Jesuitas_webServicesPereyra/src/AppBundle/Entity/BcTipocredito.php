<?php

namespace AppBundle\Entity;

/**
 * BcTipocredito
 */
class BcTipocredito
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $activo;

    /**
     * @var integer
     */
    private $tipocreditoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BcTipocredito
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
     * @param integer $activo
     *
     * @return BcTipocredito
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get tipocreditoid
     *
     * @return integer
     */
    public function getTipocreditoid()
    {
        return $this->tipocreditoid;
    }
}

