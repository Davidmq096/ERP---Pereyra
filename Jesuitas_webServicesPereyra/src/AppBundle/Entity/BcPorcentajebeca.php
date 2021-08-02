<?php

namespace AppBundle\Entity;

/**
 * BcPorcentajebeca
 */
class BcPorcentajebeca
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
    private $porcentajebecaid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BcPorcentajebeca
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
     * @return BcPorcentajebeca
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
     * Get porcentajebecaid
     *
     * @return integer
     */
    public function getPorcentajebecaid()
    {
        return $this->porcentajebecaid;
    }
}

