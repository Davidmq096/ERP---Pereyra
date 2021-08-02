<?php

namespace AppBundle\Entity;

/**
 * BrMotivorechazo
 */
class BrMotivorechazo
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
    private $motivorechazoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BrMotivorechazo
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
     * @return BrMotivorechazo
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
     * Get motivorechazoid
     *
     * @return integer
     */
    public function getMotivorechazoid()
    {
        return $this->motivorechazoid;
    }
}

