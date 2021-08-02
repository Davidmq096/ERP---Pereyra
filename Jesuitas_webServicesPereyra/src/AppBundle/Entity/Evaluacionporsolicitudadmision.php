<?php

namespace AppBundle\Entity;

/**
 * Evaluacionporsolicitudadmision
 */
class Evaluacionporsolicitudadmision
{
    /**
     * @var boolean
     */
    private $aprobado;

    /**
     * @var string
     */
    private $resultado;

    /**
     * @var string
     */
    private $conclusion;

    /**
     * @var boolean
     */
    private $asistio;

    /**
     * @var string
     */
    private $evidencia;

    /**
     * @var integer
     */
    private $evaluacionporsolicitudadmisionid;

    /**
     * @var \AppBundle\Entity\Estatusevaluacion
     */
    private $estatusevaluacionid;

    /**
     * @var \AppBundle\Entity\Evaluacion
     */
    private $evaluacionid;

    /**
     * @var \AppBundle\Entity\Eventoevaluacion
     */
    private $eventoevaluacionid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;


    /**
     * Set aprobado
     *
     * @param boolean $aprobado
     *
     * @return Evaluacionporsolicitudadmision
     */
    public function setAprobado($aprobado)
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    /**
     * Get aprobado
     *
     * @return boolean
     */
    public function getAprobado()
    {
        return $this->aprobado;
    }

    /**
     * Set resultado
     *
     * @param string $resultado
     *
     * @return Evaluacionporsolicitudadmision
     */
    public function setResultado($resultado)
    {
        $this->resultado = $resultado;

        return $this;
    }

    /**
     * Get resultado
     *
     * @return string
     */
    public function getResultado()
    {
        return $this->resultado;
    }

    /**
     * Set conclusion
     *
     * @param string $conclusion
     *
     * @return Evaluacionporsolicitudadmision
     */
    public function setConclusion($conclusion)
    {
        $this->conclusion = $conclusion;

        return $this;
    }

    /**
     * Get conclusion
     *
     * @return string
     */
    public function getConclusion()
    {
        return $this->conclusion;
    }

    /**
     * Set asistio
     *
     * @param boolean $asistio
     *
     * @return Evaluacionporsolicitudadmision
     */
    public function setAsistio($asistio)
    {
        $this->asistio = $asistio;

        return $this;
    }

    /**
     * Get asistio
     *
     * @return boolean
     */
    public function getAsistio()
    {
        return $this->asistio;
    }

    /**
     * Set evidencia
     *
     * @param string $evidencia
     *
     * @return Evaluacionporsolicitudadmision
     */
    public function setEvidencia($evidencia)
    {
        $this->evidencia = $evidencia;

        return $this;
    }

    /**
     * Get evidencia
     *
     * @return string
     */
    public function getEvidencia()
    {
        return $this->evidencia;
    }

    /**
     * Get evaluacionporsolicitudadmisionid
     *
     * @return integer
     */
    public function getEvaluacionporsolicitudadmisionid()
    {
        return $this->evaluacionporsolicitudadmisionid;
    }

    /**
     * Set estatusevaluacionid
     *
     * @param \AppBundle\Entity\Estatusevaluacion $estatusevaluacionid
     *
     * @return Evaluacionporsolicitudadmision
     */
    public function setEstatusevaluacionid(\AppBundle\Entity\Estatusevaluacion $estatusevaluacionid = null)
    {
        $this->estatusevaluacionid = $estatusevaluacionid;

        return $this;
    }

    /**
     * Get estatusevaluacionid
     *
     * @return \AppBundle\Entity\Estatusevaluacion
     */
    public function getEstatusevaluacionid()
    {
        return $this->estatusevaluacionid;
    }

    /**
     * Set evaluacionid
     *
     * @param \AppBundle\Entity\Evaluacion $evaluacionid
     *
     * @return Evaluacionporsolicitudadmision
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
     * Set eventoevaluacionid
     *
     * @param \AppBundle\Entity\Eventoevaluacion $eventoevaluacionid
     *
     * @return Evaluacionporsolicitudadmision
     */
    public function setEventoevaluacionid(\AppBundle\Entity\Eventoevaluacion $eventoevaluacionid = null)
    {
        $this->eventoevaluacionid = $eventoevaluacionid;

        return $this;
    }

    /**
     * Get eventoevaluacionid
     *
     * @return \AppBundle\Entity\Eventoevaluacion
     */
    public function getEventoevaluacionid()
    {
        return $this->eventoevaluacionid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return Evaluacionporsolicitudadmision
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = null)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }
}

