<?php

namespace AppBundle\Entity;

/**
 * CeTipomateriaplantillaprofesor
 */
class CeTipomateriaplantillaprofesor
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
    private $tipomateriaplantillaprofesorid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeTipomateriaplantillaprofesor
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
     * @return CeTipomateriaplantillaprofesor
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
     * Get tipomateriaplantillaprofesorid
     *
     * @return integer
     */
    public function getTipomateriaplantillaprofesorid()
    {
        return $this->tipomateriaplantillaprofesorid;
    }
}

