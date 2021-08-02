<?php

namespace AppBundle\Entity;

/**
 * Situacionconyugal
 */
class Situacionconyugal
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $situacionconyugalid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Situacionconyugal
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
     * Get situacionconyugalid
     *
     * @return integer
     */
    public function getSituacionconyugalid()
    {
        return $this->situacionconyugalid;
    }
}

