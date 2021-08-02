<?php

namespace AppBundle\Entity;

/**
 * CeGradoporconjuntoperiodoescolar
 */
class CeGradoporconjuntoperiodoescolar
{
    /**
     * @var integer
     */
    private $gradoporconjuntoperiodoescolarid;

    /**
     * @var \AppBundle\Entity\CeConjuntoperiodoevaluacion
     */
    private $conjuntoperiodoevaluacionid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get gradoporconjuntoperiodoescolarid
     *
     * @return integer
     */
    public function getGradoporconjuntoperiodoescolarid()
    {
        return $this->gradoporconjuntoperiodoescolarid;
    }

    /**
     * Set conjuntoperiodoevaluacionid
     *
     * @param \AppBundle\Entity\CeConjuntoperiodoevaluacion $conjuntoperiodoevaluacionid
     *
     * @return CeGradoporconjuntoperiodoescolar
     */
    public function setConjuntoperiodoevaluacionid(\AppBundle\Entity\CeConjuntoperiodoevaluacion $conjuntoperiodoevaluacionid = null)
    {
        $this->conjuntoperiodoevaluacionid = $conjuntoperiodoevaluacionid;

        return $this;
    }

    /**
     * Get conjuntoperiodoevaluacionid
     *
     * @return \AppBundle\Entity\CeConjuntoperiodoevaluacion
     */
    public function getConjuntoperiodoevaluacionid()
    {
        return $this->conjuntoperiodoevaluacionid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeGradoporconjuntoperiodoescolar
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

