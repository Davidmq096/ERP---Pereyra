<?php

namespace AppBundle\Entity;

/**
 * MaPlatillo
 */
class MaPlatillo
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $ingredientes;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $platilloid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return MaPlatillo
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
     * Set ingredientes
     *
     * @param string $ingredientes
     *
     * @return MaPlatillo
     */
    public function setIngredientes($ingredientes)
    {
        $this->ingredientes = $ingredientes;

        return $this;
    }

    /**
     * Get ingredientes
     *
     * @return string
     */
    public function getIngredientes()
    {
        return $this->ingredientes;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MaPlatillo
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
     * Get platilloid
     *
     * @return integer
     */
    public function getPlatilloid()
    {
        return $this->platilloid;
    }
}

