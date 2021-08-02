<?php

namespace AppBundle\Entity;

/**
 * AdBloqueporgradoid
 */
class AdBloqueporgradoid
{
    /**
     * @var integer
     */
    private $bloqueporgradoid;

    /**
     * @var \AppBundle\Entity\AdBloquegrado
     */
    private $bloquegradoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get bloqueporgradoid
     *
     * @return integer
     */
    public function getBloqueporgradoid()
    {
        return $this->bloqueporgradoid;
    }

    /**
     * Set bloquegradoid
     *
     * @param \AppBundle\Entity\AdBloquegrado $bloquegradoid
     *
     * @return AdBloqueporgradoid
     */
    public function setBloquegradoid(\AppBundle\Entity\AdBloquegrado $bloquegradoid = null)
    {
        $this->bloquegradoid = $bloquegradoid;

        return $this;
    }

    /**
     * Get bloquegradoid
     *
     * @return \AppBundle\Entity\AdBloquegrado
     */
    public function getBloquegradoid()
    {
        return $this->bloquegradoid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return AdBloqueporgradoid
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

