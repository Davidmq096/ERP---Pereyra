<?php

namespace AppBundle\Entity;

/**
 * Complementoporpregunta
 */
class Complementoporpregunta
{
    /**
     * @var integer
     */
    private $orden;

    /**
     * @var integer
     */
    private $complementoporpreguntaid;

    /**
     * @var \AppBundle\Entity\Complemento
     */
    private $complementoid;

    /**
     * @var \AppBundle\Entity\Pregunta
     */
    private $preguntaid;


    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Complementoporpregunta
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Get complementoporpreguntaid
     *
     * @return integer
     */
    public function getComplementoporpreguntaid()
    {
        return $this->complementoporpreguntaid;
    }

    /**
     * Set complementoid
     *
     * @param \AppBundle\Entity\Complemento $complementoid
     *
     * @return Complementoporpregunta
     */
    public function setComplementoid(\AppBundle\Entity\Complemento $complementoid = null)
    {
        $this->complementoid = $complementoid;

        return $this;
    }

    /**
     * Get complementoid
     *
     * @return \AppBundle\Entity\Complemento
     */
    public function getComplementoid()
    {
        return $this->complementoid;
    }

    /**
     * Set preguntaid
     *
     * @param \AppBundle\Entity\Pregunta $preguntaid
     *
     * @return Complementoporpregunta
     */
    public function setPreguntaid(\AppBundle\Entity\Pregunta $preguntaid = null)
    {
        $this->preguntaid = $preguntaid;

        return $this;
    }

    /**
     * Get preguntaid
     *
     * @return \AppBundle\Entity\Pregunta
     */
    public function getPreguntaid()
    {
        return $this->preguntaid;
    }
}

