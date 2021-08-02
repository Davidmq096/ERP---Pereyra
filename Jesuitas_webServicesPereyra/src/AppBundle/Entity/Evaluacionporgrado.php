<?php

namespace AppBundle\Entity;

/**
 * Evaluacionporgrado
 */
class Evaluacionporgrado
{
    /**
     * @var integer
     */
    private $evaluacionporgradoid;

    /**
     * @var \AppBundle\Entity\Evaluacion
     */
    private $evaluacionid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get evaluacionporgradoid
     *
     * @return integer
     */
    public function getEvaluacionporgradoid()
    {
        return $this->evaluacionporgradoid;
    }

    /**
     * Set evaluacionid
     *
     * @param \AppBundle\Entity\Evaluacion $evaluacionid
     *
     * @return Evaluacionporgrado
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
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return Evaluacionporgrado
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
}

