<?php

namespace AppBundle\Entity;

/**
 * CbAgendacitapadresotutores
 */
class CbAgendacitapadresotutores
{
    /**
     * @var string
     */
    private $otros;

    /**
     * @var integer
     */
    private $agendacitapadresotutoresid;

    /**
     * @var \AppBundle\Entity\CbAgendacita
     */
    private $agendacitaid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;


    /**
     * Set otros
     *
     * @param string $otros
     *
     * @return CbAgendacitapadresotutores
     */
    public function setOtros($otros)
    {
        $this->otros = $otros;

        return $this;
    }

    /**
     * Get otros
     *
     * @return string
     */
    public function getOtros()
    {
        return $this->otros;
    }

    /**
     * Get agendacitapadresotutoresid
     *
     * @return integer
     */
    public function getAgendacitapadresotutoresid()
    {
        return $this->agendacitapadresotutoresid;
    }

    /**
     * Set agendacitaid
     *
     * @param \AppBundle\Entity\CbAgendacita $agendacitaid
     *
     * @return CbAgendacitapadresotutores
     */
    public function setAgendacitaid(\AppBundle\Entity\CbAgendacita $agendacitaid = null)
    {
        $this->agendacitaid = $agendacitaid;

        return $this;
    }

    /**
     * Get agendacitaid
     *
     * @return \AppBundle\Entity\CbAgendacita
     */
    public function getAgendacitaid()
    {
        return $this->agendacitaid;
    }

    /**
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return CbAgendacitapadresotutores
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = null)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }
}

