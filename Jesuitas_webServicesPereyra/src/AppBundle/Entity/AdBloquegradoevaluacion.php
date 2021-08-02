<?php

namespace AppBundle\Entity;

/**
 * AdBloquegradoevaluacion
 */
class AdBloquegradoevaluacion
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \DateTime
     */
    private $horainicio;

    /**
     * @var \DateTime
     */
    private $horafin;

    /**
     * @var integer
     */
    private $bloquegradoevaluacionid;

    /**
     * @var \AppBundle\Entity\AdBloquegrado
     */
    private $bloquegradoid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return AdBloquegradoevaluacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set horainicio
     *
     * @param \DateTime $horainicio
     *
     * @return AdBloquegradoevaluacion
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
     * @return AdBloquegradoevaluacion
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
     * Get bloquegradoevaluacionid
     *
     * @return integer
     */
    public function getBloquegradoevaluacionid()
    {
        return $this->bloquegradoevaluacionid;
    }

    /**
     * Set bloquegradoid
     *
     * @param \AppBundle\Entity\AdBloquegrado $bloquegradoid
     *
     * @return AdBloquegradoevaluacion
     */
    public function setBloquegradoid(\AppBundle\Entity\AdBloquegrado $bloquegradoid = null)
    {
        $this->bloquegradoid = $bloquegradoid;

        return $this;
    }

    /**
     * Get bloquegradoid
     *
     * @return \AppBundle\Entity\AdBloquegrado
     */
    public function getBloquegradoid()
    {
        return $this->bloquegradoid;
    }
}

