<?php

namespace AppBundle\Entity;

/**
 * Alergia
 */
class Alergia
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $alergiaid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Alergia
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
     * Get alergiaid
     *
     * @return integer
     */
    public function getAlergiaid()
    {
        return $this->alergiaid;
    }
}

