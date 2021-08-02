<?php

namespace AppBundle\Entity;

/**
 * CeCapturaasistenciaalumno
 */
class CeCapturaasistenciaalumno
{
    /**
     * @var integer
     */
    private $asistencia;

    /**
     * @var integer
     */
    private $capturaasistenciaalumnoid;

    /**
     * @var \AppBundle\Entity\CeCapturaalumnoporperiodo
     */
    private $capturaalumnoporperiodoid;


    /**
     * Set asistencia
     *
     * @param integer $asistencia
     *
     * @return CeCapturaasistenciaalumno
     */
    public function setAsistencia($asistencia)
    {
        $this->asistencia = $asistencia;

        return $this;
    }

    /**
     * Get asistencia
     *
     * @return integer
     */
    public function getAsistencia()
    {
        return $this->asistencia;
    }

    /**
     * Get capturaasistenciaalumnoid
     *
     * @return integer
     */
    public function getCapturaasistenciaalumnoid()
    {
        return $this->capturaasistenciaalumnoid;
    }

    /**
     * Set capturaalumnoporperiodoid
     *
     * @param \AppBundle\Entity\CeCapturaalumnoporperiodo $capturaalumnoporperiodoid
     *
     * @return CeCapturaasistenciaalumno
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

