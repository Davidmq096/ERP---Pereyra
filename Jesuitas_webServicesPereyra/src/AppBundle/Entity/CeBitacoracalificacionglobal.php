<?php

namespace AppBundle\Entity;

/**
 * CeBitacoracalificacionglobal
 */
class CeBitacoracalificacionglobal
{
    /**
     * @var string
     */
    private $ciclo;

    /**
     * @var string
     */
    private $nivel;

    /**
     * @var string
     */
    private $grado;

    /**
     * @var string
     */
    private $alumno;

    /**
     * @var string
     */
    private $asistenciaanterior;

    /**
     * @var string
     */
    private $asistencianuevo;

    /**
     * @var string
     */
    private $comanterior;

    /**
     * @var string
     */
    private $comnuevo;

    /**
     * @var string
     */
    private $tareasolicitadaanterior;

    /**
     * @var string
     */
    private $tareasolicitadanuevo;

    /**
     * @var string
     */
    private $tareaentregadaanterior;

    /**
     * @var string
     */
    private $tareaentregadanuevo;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $bitacoracalificacionglobalid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;

    /**
     * @var \AppBundle\Entity\CeCapturaalumnoporperiodo
     */
    private $capturaalumnoporperiodoid;


    /**
     * Set ciclo
     *
     * @param string $ciclo
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setCiclo($ciclo)
    {
        $this->ciclo = $ciclo;

        return $this;
    }

    /**
     * Get ciclo
     *
     * @return string
     */
    public function getCiclo()
    {
        return $this->ciclo;
    }

    /**
     * Set nivel
     *
     * @param string $nivel
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return string
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set grado
     *
     * @param string $grado
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;

        return $this;
    }

    /**
     * Get grado
     *
     * @return string
     */
    public function getGrado()
    {
        return $this->grado;
    }

    /**
     * Set alumno
     *
     * @param string $alumno
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setAlumno($alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return string
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set asistenciaanterior
     *
     * @param string $asistenciaanterior
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setAsistenciaanterior($asistenciaanterior)
    {
        $this->asistenciaanterior = $asistenciaanterior;

        return $this;
    }

    /**
     * Get asistenciaanterior
     *
     * @return string
     */
    public function getAsistenciaanterior()
    {
        return $this->asistenciaanterior;
    }

    /**
     * Set asistencianuevo
     *
     * @param string $asistencianuevo
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setAsistencianuevo($asistencianuevo)
    {
        $this->asistencianuevo = $asistencianuevo;

        return $this;
    }

    /**
     * Get asistencianuevo
     *
     * @return string
     */
    public function getAsistencianuevo()
    {
        return $this->asistencianuevo;
    }

    /**
     * Set comanterior
     *
     * @param string $comanterior
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setComanterior($comanterior)
    {
        $this->comanterior = $comanterior;

        return $this;
    }

    /**
     * Get comanterior
     *
     * @return string
     */
    public function getComanterior()
    {
        return $this->comanterior;
    }

    /**
     * Set comnuevo
     *
     * @param string $comnuevo
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setComnuevo($comnuevo)
    {
        $this->comnuevo = $comnuevo;

        return $this;
    }

    /**
     * Get comnuevo
     *
     * @return string
     */
    public function getComnuevo()
    {
        return $this->comnuevo;
    }

    /**
     * Set tareasolicitadaanterior
     *
     * @param string $tareasolicitadaanterior
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setTareasolicitadaanterior($tareasolicitadaanterior)
    {
        $this->tareasolicitadaanterior = $tareasolicitadaanterior;

        return $this;
    }

    /**
     * Get tareasolicitadaanterior
     *
     * @return string
     */
    public function getTareasolicitadaanterior()
    {
        return $this->tareasolicitadaanterior;
    }

    /**
     * Set tareasolicitadanuevo
     *
     * @param string $tareasolicitadanuevo
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setTareasolicitadanuevo($tareasolicitadanuevo)
    {
        $this->tareasolicitadanuevo = $tareasolicitadanuevo;

        return $this;
    }

    /**
     * Get tareasolicitadanuevo
     *
     * @return string
     */
    public function getTareasolicitadanuevo()
    {
        return $this->tareasolicitadanuevo;
    }

    /**
     * Set tareaentregadaanterior
     *
     * @param string $tareaentregadaanterior
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setTareaentregadaanterior($tareaentregadaanterior)
    {
        $this->tareaentregadaanterior = $tareaentregadaanterior;

        return $this;
    }

    /**
     * Get tareaentregadaanterior
     *
     * @return string
     */
    public function getTareaentregadaanterior()
    {
        return $this->tareaentregadaanterior;
    }

    /**
     * Set tareaentregadanuevo
     *
     * @param string $tareaentregadanuevo
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setTareaentregadanuevo($tareaentregadanuevo)
    {
        $this->tareaentregadanuevo = $tareaentregadanuevo;

        return $this;
    }

    /**
     * Get tareaentregadanuevo
     *
     * @return string
     */
    public function getTareaentregadanuevo()
    {
        return $this->tareaentregadanuevo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeBitacoracalificacionglobal
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
     * Get bitacoracalificacionglobalid
     *
     * @return integer
     */
    public function getBitacoracalificacionglobalid()
    {
        return $this->bitacoracalificacionglobalid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeBitacoracalificacionglobal
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

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeBitacoracalificacionglobal
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
     * Set capturaalumnoporperiodoid
     *
     * @param \AppBundle\Entity\CeCapturaalumnoporperiodo $capturaalumnoporperiodoid
     *
     * @return CeBitacoracalificacionglobal
     */
    public function setCapturaalumnoporperiodoid(\AppBundle\Entity\CeCapturaalumnoporperiodo $capturaalumnoporperiodoid = null)
    {
        $this->capturaalumnoporperiodoid = $capturaalumnoporperiodoid;

        return $this;
    }

    /**
     * Get capturaalumnoporperiodoid
     *
     * @return \AppBundle\Entity\CeCapturaalumnoporperiodo
     */
    public function getCapturaalumnoporperiodoid()
    {
        return $this->capturaalumnoporperiodoid;
    }
}

