<?php

namespace AppBundle\Entity;

/**
 * TpRutapreciofijo
 */
class TpRutapreciofijo
{
    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var float
     */
    private $precio;

    /**
     * @var integer
     */
    private $rutapreciofijoid;

    /**
     * @var \AppBundle\Entity\TpRuta
     */
    private $rutaid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return TpRutapreciofijo
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     *
     * @return TpRutapreciofijo
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return TpRutapreciofijo
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Get rutapreciofijoid
     *
     * @return integer
     */
    public function getRutapreciofijoid()
    {
        return $this->rutapreciofijoid;
    }

    /**
     * Set rutaid
     *
     * @param \AppBundle\Entity\TpRuta $rutaid
     *
     * @return TpRutapreciofijo
     */
    public function setRutaid(\AppBundle\Entity\TpRuta $rutaid = null)
    {
        $this->rutaid = $rutaid;

        return $this;
    }

    /**
     * Get rutaid
     *
     * @return \AppBundle\Entity\TpRuta
     */
    public function getRutaid()
    {
        return $this->rutaid;
    }
}

