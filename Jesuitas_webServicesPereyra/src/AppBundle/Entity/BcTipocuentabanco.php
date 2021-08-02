<?php

namespace AppBundle\Entity;

/**
 * BcTipocuentabanco
 */
class BcTipocuentabanco
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
    private $tipocuentabancoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BcTipocuentabanco
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
     * @return BcTipocuentabanco
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
     * Get tipocuentabancoid
     *
     * @return integer
     */
    public function getTipocuentabancoid()
    {
        return $this->tipocuentabancoid;
    }
}

