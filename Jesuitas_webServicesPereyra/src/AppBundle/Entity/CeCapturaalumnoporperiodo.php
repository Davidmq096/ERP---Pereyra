<?php

namespace AppBundle\Entity;

/**
 * CeCapturaalumnoporperiodo
 */
class CeCapturaalumnoporperiodo
{
    /**
     * @var string
     */
    private $asistencia;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var string
     */
    private $tareasolicitada;

    /**
     * @var string
     */
    private $tareaentregada;

    /**
     * @var integer
     */
    private $capturaalumnoporperiodoid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;


    /**
     * Set asistencia
     *
     * @param string $asistencia
     *
     * @return CeCapturaalumnoporperiodo
     */
    public function setAsistencia($asistencia)
    {
        $this->asistencia = $asistencia;

        return $this;
    }

    /**
     * Get asistencia
     *
     * @return string
     */
    public function getAsistencia()
    {
        return $this->asistencia;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CeCapturaalumnoporperiodo
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set tareasolicitada
     *
     * @param string $tareasolicitada
     *
     * @return CeCapturaalumnoporperiodo
     */
    public function setTareasolicitada($tareasolicitada)
    {
        $this->tareasolicitada = $tareasolicitada;

        return $this;
    }

    /**
     * Get tareasolicitada
     *
     * @return string
     */
    public function getTareasolicitada()
    {
        return $this->tareasolicitada;
    }

    /**
     * Set tareaentregada
     *
     * @param string $tareaentregada
     *
     * @return CeCapturaalumnoporperiodo
     */
    public function setTareaentregada($tareaentregada)
    {
        $this->tareaentregada = $tareaentregada;

        return $this;
    }

    /**
     * Get tareaentregada
     *
     * @return string
     */
    public function getTareaentregada()
    {
        return $this->tareaentregada;
    }

    /**
     * Get capturaalumnoporperiodoid
     *
     * @return integer
     */
    public function getCapturaalumnoporperiodoid()
    {
        return $this->capturaalumnoporperiodoid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeCapturaalumnoporperiodo
     */
    public function setPeriodoevaluacionid(\AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid = null)
    {
        $this->periodoevaluacionid = $periodoevaluacionid;

        return $this;
    }

    /**
     * Get periodoevaluacionid
     *
     * @return \AppBundle\Entity\CePeriodoevaluacion
     */
    public function getPeriodoevaluacionid()
    {
        return $this->periodoevaluacionid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeCapturaalumnoporperiodo
     */
    public function setAlumnoporcicloid(\AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid = null)
    {
        $this->alumnoporcicloid = $alumnoporcicloid;

        return $this;
    }

    /**
     * Get alumnoporcicloid
     *
     * @return \AppBundle\Entity\CeAlumnoporciclo
     */
    public function getAlumnoporcicloid()
    {
        return $this->alumnoporcicloid;
    }
}

