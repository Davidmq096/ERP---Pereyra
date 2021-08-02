<?php

namespace AppBundle\Entity;

/**
 * Eventoevaluacion
 */
class Eventoevaluacion
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
     * @var integer
     */
    private $cupo;

    /**
     * @var integer
     */
    private $eventoevaluacionid;

    /**
     * @var \AppBundle\Entity\AdBloquegradoentrevista
     */
    private $bloquegradoentrevistaid;

    /**
     * @var \AppBundle\Entity\Evaluacion
     */
    private $evaluacionid;

    /**
     * @var \AppBundle\Entity\AdBloquegradoevaluacion
     */
    private $bloquegradoevaluacionid;

    /**
     * @var \AppBundle\Entity\Lugar
     */
    private $lugarid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return Eventoevaluacion
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
     * @return Eventoevaluacion
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
     * @return Eventoevaluacion
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
     * @return Eventoevaluacion
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
     * Set cupo
     *
     * @param integer $cupo
     *
     * @return Eventoevaluacion
     */
    public function setCupo($cupo)
    {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get cupo
     *
     * @return integer
     */
    public function getCupo()
    {
        return $this->cupo;
    }

    /**
     * Get eventoevaluacionid
     *
     * @return integer
     */
    public function getEventoevaluacionid()
    {
        return $this->eventoevaluacionid;
    }

    /**
     * Set bloquegradoentrevistaid
     *
     * @param \AppBundle\Entity\AdBloquegradoentrevista $bloquegradoentrevistaid
     *
     * @return Eventoevaluacion
     */
    public function setBloquegradoentrevistaid(\AppBundle\Entity\AdBloquegradoentrevista $bloquegradoentrevistaid = null)
    {
        $this->bloquegradoentrevistaid = $bloquegradoentrevistaid;

        return $this;
    }

    /**
     * Get bloquegradoentrevistaid
     *
     * @return \AppBundle\Entity\AdBloquegradoentrevista
     */
    public function getBloquegradoentrevistaid()
    {
        return $this->bloquegradoentrevistaid;
    }

    /**
     * Set evaluacionid
     *
     * @param \AppBundle\Entity\Evaluacion $evaluacionid
     *
     * @return Eventoevaluacion
     */
    public function setEvaluacionid(\AppBundle\Entity\Evaluacion $evaluacionid = null)
    {
        $this->evaluacionid = $evaluacionid;

        return $this;
    }

    /**
     * Get evaluacionid
     *
     * @return \AppBundle\Entity\Evaluacion
     */
    public function getEvaluacionid()
    {
        return $this->evaluacionid;
    }

    /**
     * Set bloquegradoevaluacionid
     *
     * @param \AppBundle\Entity\AdBloquegradoevaluacion $bloquegradoevaluacionid
     *
     * @return Eventoevaluacion
     */
    public function setBloquegradoevaluacionid(\AppBundle\Entity\AdBloquegradoevaluacion $bloquegradoevaluacionid = null)
    {
        $this->bloquegradoevaluacionid = $bloquegradoevaluacionid;

        return $this;
    }

    /**
     * Get bloquegradoevaluacionid
     *
     * @return \AppBundle\Entity\AdBloquegradoevaluacion
     */
    public function getBloquegradoevaluacionid()
    {
        return $this->bloquegradoevaluacionid;
    }

    /**
     * Set lugarid
     *
     * @param \AppBundle\Entity\Lugar $lugarid
     *
     * @return Eventoevaluacion
     */
    public function setLugarid(\AppBundle\Entity\Lugar $lugarid = null)
    {
        $this->lugarid = $lugarid;

        return $this;
    }

    /**
     * Get lugarid
     *
     * @return \AppBundle\Entity\Lugar
     */
    public function getLugarid()
    {
        return $this->lugarid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return Eventoevaluacion
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

