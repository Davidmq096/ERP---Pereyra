<?php

namespace AppBundle\Entity;

/**
 * CeEstatusplantillaprofesor
 */
class CeEstatusplantillaprofesor
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
    private $estatusplantillaprofesorid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeEstatusplantillaprofesor
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
     * @return CeEstatusplantillaprofesor
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
     * Get estatusplantillaprofesorid
     *
     * @return integer
     */
    public function getEstatusplantillaprofesorid()
    {
        return $this->estatusplantillaprofesorid;
    }
}

