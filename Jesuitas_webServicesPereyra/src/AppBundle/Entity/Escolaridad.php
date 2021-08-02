<?php

namespace AppBundle\Entity;

/**
 * Escolaridad
 */
class Escolaridad
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $escolaridadid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Escolaridad
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
     * Get escolaridadid
     *
     * @return integer
     */
    public function getEscolaridadid()
    {
        return $this->escolaridadid;
    }
}

