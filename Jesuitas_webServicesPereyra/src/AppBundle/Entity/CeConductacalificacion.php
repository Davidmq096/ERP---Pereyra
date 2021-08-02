<?php

namespace AppBundle\Entity;

/**
 * CeConductacalificacion
 */
class CeConductacalificacion
{
    /**
     * @var float
     */
    private $calificacion;

    /**
     * @var boolean
     */
    private $titular;

    /**
     * @var integer
     */
    private $conductacalificacionid;

    /**
     * @var \AppBundle\Entity\CeAlumnocicloporgrupo
     */
    private $alumnocicloporgrupoid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;


    /**
     * Set calificacion
     *
     * @param float $calificacion
     *
     * @return CeConductacalificacion
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return float
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Set titular
     *
     * @param boolean $titular
     *
     * @return CeConductacalificacion
     */
    public function setTitular($titular)
    {
        $this->titular = $titular;

        return $this;
    }

    /**
     * Get titular
     *
     * @return boolean
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * Get conductacalificacionid
     *
     * @return integer
     */
    public function getConductacalificacionid()
    {
        return $this->conductacalificacionid;
    }

    /**
     * Set alumnocicloporgrupoid
     *
     * @param \AppBundle\Entity\CeAlumnocicloporgrupo $alumnocicloporgrupoid
     *
     * @return CeConductacalificacion
     */
    public function setAlumnocicloporgrupoid(\AppBundle\Entity\CeAlumnocicloporgrupo $alumnocicloporgrupoid = null)
    {
        $this->alumnocicloporgrupoid = $alumnocicloporgrupoid;

        return $this;
    }

    /**
     * Get alumnocicloporgrupoid
     *
     * @return \AppBundle\Entity\CeAlumnocicloporgrupo
     */
    public function getAlumnocicloporgrupoid()
    {
        return $this->alumnocicloporgrupoid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeConductacalificacion
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
}

