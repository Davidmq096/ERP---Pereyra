<?php

namespace AppBundle\Entity;

/**
 * BcTipobecapornivel
 */
class BcTipobecapornivel
{
    /**
     * @var integer
     */
    private $afectainscripcion = '0';

    /**
     * @var integer
     */
    private $activo;

    /**
     * @var integer
     */
    private $tipobecapornivelid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\BcTipobeca
     */
    private $tipobecaid;


    /**
     * Set afectainscripcion
     *
     * @param integer $afectainscripcion
     *
     * @return BcTipobecapornivel
     */
    public function setAfectainscripcion($afectainscripcion)
    {
        $this->afectainscripcion = $afectainscripcion;

        return $this;
    }

    /**
     * Get afectainscripcion
     *
     * @return integer
     */
    public function getAfectainscripcion()
    {
        return $this->afectainscripcion;
    }

    /**
     * Set activo
     *
     * @param integer $activo
     *
     * @return BcTipobecapornivel
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
     * Get tipobecapornivelid
     *
     * @return integer
     */
    public function getTipobecapornivelid()
    {
        return $this->tipobecapornivelid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return BcTipobecapornivel
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
     * Set tipobecaid
     *
     * @param \AppBundle\Entity\BcTipobeca $tipobecaid
     *
     * @return BcTipobecapornivel
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

