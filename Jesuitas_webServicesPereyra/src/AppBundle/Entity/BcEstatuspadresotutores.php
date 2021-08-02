<?php

namespace AppBundle\Entity;

/**
 * BcEstatuspadresotutores
 */
class BcEstatuspadresotutores
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $padresotutoresvivenid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BcEstatuspadresotutores
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
     * Get padresotutoresvivenid
     *
     * @return integer
     */
    public function getPadresotutoresvivenid()
    {
        return $this->padresotutoresvivenid;
    }
}

