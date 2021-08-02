<?php

namespace AppBundle\Entity;

/**
 * Gradoporeventoevaluacion
 */
class Gradoporeventoevaluacion
{
    /**
     * @var integer
     */
    private $gradoporeventoevaluacionid;

    /**
     * @var \AppBundle\Entity\Eventoevaluacion
     */
    private $eventoevaluacionid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get gradoporeventoevaluacionid
     *
     * @return integer
     */
    public function getGradoporeventoevaluacionid()
    {
        return $this->gradoporeventoevaluacionid;
    }

    /**
     * Set eventoevaluacionid
     *
     * @param \AppBundle\Entity\Eventoevaluacion $eventoevaluacionid
     *
     * @return Gradoporeventoevaluacion
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
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return Gradoporeventoevaluacion
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

