<?php

namespace AppBundle\Entity;

/**
 * TpRutaexcepcion
 */
class TpRutaexcepcion
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
     * @var \DateTime
     */
    private $horainicio;

    /**
     * @var \DateTime
     */
    private $horafin;

    /**
     * @var boolean
     */
    private $suspender;

    /**
     * @var integer
     */
    private $rutaexcepcionid;

    /**
     * @var \AppBundle\Entity\TpRuta
     */
    private $rutaid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return TpRutaexcepcion
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
     * @return TpRutaexcepcion
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
     * Set horainicio
     *
     * @param \DateTime $horainicio
     *
     * @return TpRutaexcepcion
     */
    public function setHorainicio($horainicio)
    {
        $this->horainicio = $horainicio;

        return $this;
    }

    /**
     * Get horainicio
     *
     * @return \DateTime
     */
    public function getHorainicio()
    {
        return $this->horainicio;
    }

    /**
     * Set horafin
     *
     * @param \DateTime $horafin
     *
     * @return TpRutaexcepcion
     */
    public function setHorafin($horafin)
    {
        $this->horafin = $horafin;

        return $this;
    }

    /**
     * Get horafin
     *
     * @return \DateTime
     */
    public function getHorafin()
    {
        return $this->horafin;
    }

    /**
     * Set suspender
     *
     * @param boolean $suspender
     *
     * @return TpRutaexcepcion
     */
    public function setSuspender($suspender)
    {
        $this->suspender = $suspender;

        return $this;
    }

    /**
     * Get suspender
     *
     * @return boolean
     */
    public function getSuspender()
    {
        return $this->suspender;
    }

    /**
     * Get rutaexcepcionid
     *
     * @return integer
     */
    public function getRutaexcepcionid()
    {
        return $this->rutaexcepcionid;
    }

    /**
     * Set rutaid
     *
     * @param \AppBundle\Entity\TpRuta $rutaid
     *
     * @return TpRutaexcepcion
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

