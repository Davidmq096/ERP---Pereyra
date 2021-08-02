<?php

namespace AppBundle\Entity;

/**
 * Parentesco
 */
class Parentesco
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var boolean
     */
    private $clasificardor;

    /**
     * @var integer
     */
    private $parentescoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Parentesco
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
     * Set clasificardor
     *
     * @param boolean $clasificardor
     *
     * @return Parentesco
     */
    public function setClasificardor($clasificardor)
    {
        $this->clasificardor = $clasificardor;

        return $this;
    }

    /**
     * Get clasificardor
     *
     * @return boolean
     */
    public function getClasificardor()
    {
        return $this->clasificardor;
    }

    /**
     * Get parentescoid
     *
     * @return integer
     */
    public function getParentescoid()
    {
        return $this->parentescoid;
    }
}

