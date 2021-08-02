<?php

namespace AppBundle\Entity;

/**
 * Preguntaporevaluacion
 */
class Preguntaporevaluacion
{
    /**
     * @var integer
     */
    private $orden;

    /**
     * @var integer
     */
    private $preguntaporevaluacionid;

    /**
     * @var \AppBundle\Entity\Evaluacion
     */
    private $evaluacionid;

    /**
     * @var \AppBundle\Entity\Pregunta
     */
    private $preguntaid;


    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Preguntaporevaluacion
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Get preguntaporevaluacionid
     *
     * @return integer
     */
    public function getPreguntaporevaluacionid()
    {
        return $this->preguntaporevaluacionid;
    }

    /**
     * Set evaluacionid
     *
     * @param \AppBundle\Entity\Evaluacion $evaluacionid
     *
     * @return Preguntaporevaluacion
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
     * Set preguntaid
     *
     * @param \AppBundle\Entity\Pregunta $preguntaid
     *
     * @return Preguntaporevaluacion
     */
    public function setPreguntaid(\AppBundle\Entity\Pregunta $preguntaid = null)
    {
        $this->preguntaid = $preguntaid;

        return $this;
    }

    /**
     * Get preguntaid
     *
     * @return \AppBundle\Entity\Pregunta
     */
    public function getPreguntaid()
    {
        return $this->preguntaid;
    }
}

