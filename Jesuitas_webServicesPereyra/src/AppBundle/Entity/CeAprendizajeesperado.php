<?php

namespace AppBundle\Entity;

/**
 * CeAprendizajeesperado
 */
class CeAprendizajeesperado
{
    /**
     * @var boolean
     */
    private $configurarcomentarios = '1';

    /**
     * @var integer
     */
    private $aprendizajeesperadoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;

    /**
     * @var \AppBundle\Entity\CePlanestudios
     */
    private $planestudioid;


    /**
     * Set configurarcomentarios
     *
     * @param boolean $configurarcomentarios
     *
     * @return CeAprendizajeesperado
     */
    public function setConfigurarcomentarios($configurarcomentarios)
    {
        $this->configurarcomentarios = $configurarcomentarios;

        return $this;
    }

    /**
     * Get configurarcomentarios
     *
     * @return boolean
     */
    public function getConfigurarcomentarios()
    {
        return $this->configurarcomentarios;
    }

    /**
     * Get aprendizajeesperadoid
     *
     * @return integer
     */
    public function getAprendizajeesperadoid()
    {
        return $this->aprendizajeesperadoid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeAprendizajeesperado
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeAprendizajeesperado
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeAprendizajeesperado
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
     * Set planestudioid
     *
     * @param \AppBundle\Entity\CePlanestudios $planestudioid
     *
     * @return CeAprendizajeesperado
     */
    public function setPlanestudioid(\AppBundle\Entity\CePlanestudios $planestudioid = null)
    {
        $this->planestudioid = $planestudioid;

        return $this;
    }

    /**
     * Get planestudioid
     *
     * @return \AppBundle\Entity\CePlanestudios
     */
    public function getPlanestudioid()
    {
        return $this->planestudioid;
    }
}

