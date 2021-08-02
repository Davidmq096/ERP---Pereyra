<?php

namespace AppBundle\Entity;

/**
 * CeEstatusempleado
 */
class CeEstatusempleado
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
    private $estatusempleadoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeEstatusempleado
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
     * @return CeEstatusempleado
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
     * Get estatusempleadoid
     *
     * @return integer
     */
    public function getEstatusempleadoid()
    {
        return $this->estatusempleadoid;
    }
}

