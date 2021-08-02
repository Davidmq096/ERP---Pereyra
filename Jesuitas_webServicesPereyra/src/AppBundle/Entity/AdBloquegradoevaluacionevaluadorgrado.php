<?php

namespace AppBundle\Entity;

/**
 * AdBloquegradoevaluacionevaluadorgrado
 */
class AdBloquegradoevaluacionevaluadorgrado
{
    /**
     * @var integer
     */
    private $bloquegradoevaluacionevaluadorgradoid;

    /**
     * @var \AppBundle\Entity\AdBloquegradoevaluacionevaluador
     */
    private $bloquegradoevaluacionevaluadorid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get bloquegradoevaluacionevaluadorgradoid
     *
     * @return integer
     */
    public function getBloquegradoevaluacionevaluadorgradoid()
    {
        return $this->bloquegradoevaluacionevaluadorgradoid;
    }

    /**
     * Set bloquegradoevaluacionevaluadorid
     *
     * @param \AppBundle\Entity\AdBloquegradoevaluacionevaluador $bloquegradoevaluacionevaluadorid
     *
     * @return AdBloquegradoevaluacionevaluadorgrado
     */
    public function setBloquegradoevaluacionevaluadorid(\AppBundle\Entity\AdBloquegradoevaluacionevaluador $bloquegradoevaluacionevaluadorid = null)
    {
        $this->bloquegradoevaluacionevaluadorid = $bloquegradoevaluacionevaluadorid;

        return $this;
    }

    /**
     * Get bloquegradoevaluacionevaluadorid
     *
     * @return \AppBundle\Entity\AdBloquegradoevaluacionevaluador
     */
    public function getBloquegradoevaluacionevaluadorid()
    {
        return $this->bloquegradoevaluacionevaluadorid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return AdBloquegradoevaluacionevaluadorgrado
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

