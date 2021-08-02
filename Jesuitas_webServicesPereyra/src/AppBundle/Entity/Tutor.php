<?php

namespace AppBundle\Entity;

/**
 * Tutor
 */
class Tutor
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $tutorid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Tutor
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
     * Get tutorid
     *
     * @return integer
     */
    public function getTutorid()
    {
        return $this->tutorid;
    }
}

