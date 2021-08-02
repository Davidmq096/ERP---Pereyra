<?php

namespace AppBundle\Entity;

/**
 * MaHigiene
 */
class MaHigiene
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
    private $higieneid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return MaHigiene
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
     * @return MaHigiene
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
     * Get higieneid
     *
     * @return integer
     */
    public function getHigieneid()
    {
        return $this->higieneid;
    }
}

