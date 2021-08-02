<?php

namespace AppBundle\Entity;

/**
 * Mediosporencuesta
 */
class Mediosporencuesta
{
    /**
     * @var integer
     */
    private $idmediosporencuesta;

    /**
     * @var \AppBundle\Entity\Encuesta
     */
    private $encuestaid;

    /**
     * @var \AppBundle\Entity\Medios
     */
    private $mediosid;


    /**
     * Get idmediosporencuesta
     *
     * @return integer
     */
    public function getIdmediosporencuesta()
    {
        return $this->idmediosporencuesta;
    }

    /**
     * Set encuestaid
     *
     * @param \AppBundle\Entity\Encuesta $encuestaid
     *
     * @return Mediosporencuesta
     */
    public function setEncuestaid(\AppBundle\Entity\Encuesta $encuestaid = null)
    {
        $this->encuestaid = $encuestaid;

        return $this;
    }

    /**
     * Get encuestaid
     *
     * @return \AppBundle\Entity\Encuesta
     */
    public function getEncuestaid()
    {
        return $this->encuestaid;
    }

    /**
     * Set mediosid
     *
     * @param \AppBundle\Entity\Medios $mediosid
     *
     * @return Mediosporencuesta
     */
    public function setMediosid(\AppBundle\Entity\Medios $mediosid = null)
    {
        $this->mediosid = $mediosid;

        return $this;
    }

    /**
     * Get mediosid
     *
     * @return \AppBundle\Entity\Medios
     */
    public function getMediosid()
    {
        return $this->mediosid;
    }
}

