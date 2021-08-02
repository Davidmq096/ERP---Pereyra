<?php

namespace AppBundle\Entity;

/**
 * CeAvisosplataformapornivel
 */
class CeAvisosplataformapornivel
{
    /**
     * @var integer
     */
    private $avisoplataformaporperfilid;

    /**
     * @var \AppBundle\Entity\CeAvisosplataforma
     */
    private $avisoplataformaid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;


    /**
     * Get avisoplataformaporperfilid
     *
     * @return integer
     */
    public function getAvisoplataformaporperfilid()
    {
        return $this->avisoplataformaporperfilid;
    }

    /**
     * Set avisoplataformaid
     *
     * @param \AppBundle\Entity\CeAvisosplataforma $avisoplataformaid
     *
     * @return CeAvisosplataformapornivel
     */
    public function setAvisoplataformaid(\AppBundle\Entity\CeAvisosplataforma $avisoplataformaid = null)
    {
        $this->avisoplataformaid = $avisoplataformaid;

        return $this;
    }

    /**
     * Get avisoplataformaid
     *
     * @return \AppBundle\Entity\CeAvisosplataforma
     */
    public function getAvisoplataformaid()
    {
        return $this->avisoplataformaid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return CeAvisosplataformapornivel
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }
}

