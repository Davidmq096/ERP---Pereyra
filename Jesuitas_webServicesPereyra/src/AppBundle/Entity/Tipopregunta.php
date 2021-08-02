<?php

namespace AppBundle\Entity;

/**
 * Tipopregunta
 */
class Tipopregunta
{
    /**
     * @var string
     */
    private $tipopregunta;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $tipopreguntaid;


    /**
     * Set tipopregunta
     *
     * @param string $tipopregunta
     *
     * @return Tipopregunta
     */
    public function setTipopregunta($tipopregunta)
    {
        $this->tipopregunta = $tipopregunta;

        return $this;
    }

    /**
     * Get tipopregunta
     *
     * @return string
     */
    public function getTipopregunta()
    {
        return $this->tipopregunta;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Tipopregunta
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
     * Get tipopreguntaid
     *
     * @return integer
     */
    public function getTipopreguntaid()
    {
        return $this->tipopreguntaid;
    }
}

