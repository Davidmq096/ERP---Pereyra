<?php

namespace AppBundle\Entity;

/**
 * AdConfiguracionporgrado
 */
class AdConfiguracionporgrado
{
    /**
     * @var integer
     */
    private $configuracionporgradoid;

    /**
     * @var \AppBundle\Entity\AdConfiguracion
     */
    private $configuracionid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get configuracionporgradoid
     *
     * @return integer
     */
    public function getConfiguracionporgradoid()
    {
        return $this->configuracionporgradoid;
    }

    /**
     * Set configuracionid
     *
     * @param \AppBundle\Entity\AdConfiguracion $configuracionid
     *
     * @return AdConfiguracionporgrado
     */
    public function setConfiguracionid(\AppBundle\Entity\AdConfiguracion $configuracionid = null)
    {
        $this->configuracionid = $configuracionid;

        return $this;
    }

    /**
     * Get configuracionid
     *
     * @return \AppBundle\Entity\AdConfiguracion
     */
    public function getConfiguracionid()
    {
        return $this->configuracionid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return AdConfiguracionporgrado
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

