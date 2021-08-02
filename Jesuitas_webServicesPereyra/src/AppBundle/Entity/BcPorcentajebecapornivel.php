<?php

namespace AppBundle\Entity;

/**
 * BcPorcentajebecapornivel
 */
class BcPorcentajebecapornivel
{
    /**
     * @var integer
     */
    private $activo;

    /**
     * @var integer
     */
    private $porcenjatebecapornivelid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\BcPorcentajebeca
     */
    private $porcentajebecaid;

    /**
     * @var \AppBundle\Entity\BcTipobeca
     */
    private $tipobecaid;


    /**
     * Set activo
     *
     * @param integer $activo
     *
     * @return BcPorcentajebecapornivel
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get porcenjatebecapornivelid
     *
     * @return integer
     */
    public function getPorcenjatebecapornivelid()
    {
        return $this->porcenjatebecapornivelid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return BcPorcentajebecapornivel
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

    /**
     * Set porcentajebecaid
     *
     * @param \AppBundle\Entity\BcPorcentajebeca $porcentajebecaid
     *
     * @return BcPorcentajebecapornivel
     */
    public function setPorcentajebecaid(\AppBundle\Entity\BcPorcentajebeca $porcentajebecaid = null)
    {
        $this->porcentajebecaid = $porcentajebecaid;

        return $this;
    }

    /**
     * Get porcentajebecaid
     *
     * @return \AppBundle\Entity\BcPorcentajebeca
     */
    public function getPorcentajebecaid()
    {
        return $this->porcentajebecaid;
    }

    /**
     * Set tipobecaid
     *
     * @param \AppBundle\Entity\BcTipobeca $tipobecaid
     *
     * @return BcPorcentajebecapornivel
     */
    public function setTipobecaid(\AppBundle\Entity\BcTipobeca $tipobecaid = null)
    {
        $this->tipobecaid = $tipobecaid;

        return $this;
    }

    /**
     * Get tipobecaid
     *
     * @return \AppBundle\Entity\BcTipobeca
     */
    public function getTipobecaid()
    {
        return $this->tipobecaid;
    }
}

