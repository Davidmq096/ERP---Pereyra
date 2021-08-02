<?php

namespace AppBundle\Entity;

/**
 * AdBloquegradoentrevista
 */
class AdBloquegradoentrevista
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \DateTime
     */
    private $horaprimeracita;

    /**
     * @var \DateTime
     */
    private $horaultimacita;

    /**
     * @var float
     */
    private $duracion;

    /**
     * @var integer
     */
    private $cupo;

    /**
     * @var string
     */
    private $casillasbloqueadas;

    /**
     * @var integer
     */
    private $bloquegradoentrevistaid;

    /**
     * @var \AppBundle\Entity\AdBloquegrado
     */
    private $bloquegradoid;

    /**
     * @var \AppBundle\Entity\Evaluacion
     */
    private $evaluacionid;

    /**
     * @var \AppBundle\Entity\Tipoevaluacion
     */
    private $tipoevaluacionid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return AdBloquegradoentrevista
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
     * Set horaprimeracita
     *
     * @param \DateTime $horaprimeracita
     *
     * @return AdBloquegradoentrevista
     */
    public function setHoraprimeracita($horaprimeracita)
    {
        $this->horaprimeracita = $horaprimeracita;

        return $this;
    }

    /**
     * Get horaprimeracita
     *
     * @return \DateTime
     */
    public function getHoraprimeracita()
    {
        return $this->horaprimeracita;
    }

    /**
     * Set horaultimacita
     *
     * @param \DateTime $horaultimacita
     *
     * @return AdBloquegradoentrevista
     */
    public function setHoraultimacita($horaultimacita)
    {
        $this->horaultimacita = $horaultimacita;

        return $this;
    }

    /**
     * Get horaultimacita
     *
     * @return \DateTime
     */
    public function getHoraultimacita()
    {
        return $this->horaultimacita;
    }

    /**
     * Set duracion
     *
     * @param float $duracion
     *
     * @return AdBloquegradoentrevista
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;

        return $this;
    }

    /**
     * Get duracion
     *
     * @return float
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * Set cupo
     *
     * @param integer $cupo
     *
     * @return AdBloquegradoentrevista
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
     * Set casillasbloqueadas
     *
     * @param string $casillasbloqueadas
     *
     * @return AdBloquegradoentrevista
     */
    public function setCasillasbloqueadas($casillasbloqueadas)
    {
        $this->casillasbloqueadas = $casillasbloqueadas;

        return $this;
    }

    /**
     * Get casillasbloqueadas
     *
     * @return string
     */
    public function getCasillasbloqueadas()
    {
        return $this->casillasbloqueadas;
    }

    /**
     * Get bloquegradoentrevistaid
     *
     * @return integer
     */
    public function getBloquegradoentrevistaid()
    {
        return $this->bloquegradoentrevistaid;
    }

    /**
     * Set bloquegradoid
     *
     * @param \AppBundle\Entity\AdBloquegrado $bloquegradoid
     *
     * @return AdBloquegradoentrevista
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

    /**
     * Set evaluacionid
     *
     * @param \AppBundle\Entity\Evaluacion $evaluacionid
     *
     * @return AdBloquegradoentrevista
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
     * Set tipoevaluacionid
     *
     * @param \AppBundle\Entity\Tipoevaluacion $tipoevaluacionid
     *
     * @return AdBloquegradoentrevista
     */
    public function setTipoevaluacionid(\AppBundle\Entity\Tipoevaluacion $tipoevaluacionid = null)
    {
        $this->tipoevaluacionid = $tipoevaluacionid;

        return $this;
    }

    /**
     * Get tipoevaluacionid
     *
     * @return \AppBundle\Entity\Tipoevaluacion
     */
    public function getTipoevaluacionid()
    {
        return $this->tipoevaluacionid;
    }
}

