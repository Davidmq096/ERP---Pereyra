<?php

namespace AppBundle\Entity;

/**
 * Antecedentefamiliarimportante
 */
class Antecedentefamiliarimportante
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $antecedentefamiliarimportanteid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Antecedentefamiliarimportante
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
     * Get antecedentefamiliarimportanteid
     *
     * @return integer
     */
    public function getAntecedentefamiliarimportanteid()
    {
        return $this->antecedentefamiliarimportanteid;
    }
}

