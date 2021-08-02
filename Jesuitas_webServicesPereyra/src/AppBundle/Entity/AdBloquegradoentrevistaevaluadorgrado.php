<?php

namespace AppBundle\Entity;

/**
 * AdBloquegradoentrevistaevaluadorgrado
 */
class AdBloquegradoentrevistaevaluadorgrado
{
    /**
     * @var integer
     */
    private $bloquegradoentrevistaevaluadorgradoid;

    /**
     * @var \AppBundle\Entity\AdBloquegradoentrevistaevaluador
     */
    private $bloquegradoentrevistaevaluadorid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get bloquegradoentrevistaevaluadorgradoid
     *
     * @return integer
     */
    public function getBloquegradoentrevistaevaluadorgradoid()
    {
        return $this->bloquegradoentrevistaevaluadorgradoid;
    }

    /**
     * Set bloquegradoentrevistaevaluadorid
     *
     * @param \AppBundle\Entity\AdBloquegradoentrevistaevaluador $bloquegradoentrevistaevaluadorid
     *
     * @return AdBloquegradoentrevistaevaluadorgrado
     */
    public function setBloquegradoentrevistaevaluadorid(\AppBundle\Entity\AdBloquegradoentrevistaevaluador $bloquegradoentrevistaevaluadorid = null)
    {
        $this->bloquegradoentrevistaevaluadorid = $bloquegradoentrevistaevaluadorid;

        return $this;
    }

    /**
     * Get bloquegradoentrevistaevaluadorid
     *
     * @return \AppBundle\Entity\AdBloquegradoentrevistaevaluador
     */
    public function getBloquegradoentrevistaevaluadorid()
    {
        return $this->bloquegradoentrevistaevaluadorid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return AdBloquegradoentrevistaevaluadorgrado
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

