<?php

namespace AppBundle\Entity;

/**
 * CeEstatusinasistencia
 */
class CeEstatusinasistencia
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
    private $estatusinasistenciaid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeEstatusinasistencia
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
     * @return CeEstatusinasistencia
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
     * Get estatusinasistenciaid
     *
     * @return integer
     */
    public function getEstatusinasistenciaid()
    {
        return $this->estatusinasistenciaid;
    }
}

