<?php

namespace AppBundle\Entity;

/**
 * Tiposanguineo
 */
class Tiposanguineo
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $tiposanguineoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Tiposanguineo
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
     * Get tiposanguineoid
     *
     * @return integer
     */
    public function getTiposanguineoid()
    {
        return $this->tiposanguineoid;
    }
}

