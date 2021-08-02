<?php

namespace AppBundle\Entity;

/**
 * BcPeriodobecaporformato
 */
class BcPeriodobecaporformato
{
    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $periodobecaporformatosid;

    /**
     * @var \AppBundle\Entity\BcFormatobeca
     */
    private $formatobecaid;

    /**
     * @var \AppBundle\Entity\BcPeriodobeca
     */
    private $periodobecaid;


    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BcPeriodobecaporformato
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get periodobecaporformatosid
     *
     * @return integer
     */
    public function getPeriodobecaporformatosid()
    {
        return $this->periodobecaporformatosid;
    }

    /**
     * Set formatobecaid
     *
     * @param \AppBundle\Entity\BcFormatobeca $formatobecaid
     *
     * @return BcPeriodobecaporformato
     */
    public function setFormatobecaid(\AppBundle\Entity\BcFormatobeca $formatobecaid = null)
    {
        $this->formatobecaid = $formatobecaid;

        return $this;
    }

    /**
     * Get formatobecaid
     *
     * @return \AppBundle\Entity\BcFormatobeca
     */
    public function getFormatobecaid()
    {
        return $this->formatobecaid;
    }

    /**
     * Set periodobecaid
     *
     * @param \AppBundle\Entity\BcPeriodobeca $periodobecaid
     *
     * @return BcPeriodobecaporformato
     */
    public function setPeriodobecaid(\AppBundle\Entity\BcPeriodobeca $periodobecaid = null)
    {
        $this->periodobecaid = $periodobecaid;

        return $this;
    }

    /**
     * Get periodobecaid
     *
     * @return \AppBundle\Entity\BcPeriodobeca
     */
    public function getPeriodobecaid()
    {
        return $this->periodobecaid;
    }
}

