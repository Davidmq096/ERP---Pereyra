<?php

namespace AppBundle\Entity;

/**
 * CeTipoasistencia
 */
class CeTipoasistencia
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
    private $tipoasistenciaid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeTipoasistencia
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
     * @return CeTipoasistencia
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
     * Get tipoasistenciaid
     *
     * @return integer
     */
    public function getTipoasistenciaid()
    {
        return $this->tipoasistenciaid;
    }
}

