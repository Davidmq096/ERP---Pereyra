<?php

namespace AppBundle\Entity;

/**
 * BrTipoaccionbitacorareactivo
 */
class BrTipoaccionbitacorareactivo
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
    private $tipoaccionbitacorareactivoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BrTipoaccionbitacorareactivo
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
     * @return BrTipoaccionbitacorareactivo
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
     * Get tipoaccionbitacorareactivoid
     *
     * @return integer
     */
    public function getTipoaccionbitacorareactivoid()
    {
        return $this->tipoaccionbitacorareactivoid;
    }
}

