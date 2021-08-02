<?php

namespace AppBundle\Entity;

/**
 * CeSituacionfamiliar
 */
class CeSituacionfamiliar
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
    private $situacionfamiliarid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeSituacionfamiliar
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
     * @return CeSituacionfamiliar
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
     * Get situacionfamiliarid
     *
     * @return integer
     */
    public function getSituacionfamiliarid()
    {
        return $this->situacionfamiliarid;
    }
}

