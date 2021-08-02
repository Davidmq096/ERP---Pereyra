<?php

namespace AppBundle\Entity;

/**
 * BcBecas
 */
class BcBecas
{
    /**
     * @var integer
     */
    private $becaid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoidorigen;

    /**
     * @var \AppBundle\Entity\BcPorcentajebeca
     */
    private $porcentajebecaid;

    /**
     * @var \AppBundle\Entity\BcTipobeca
     */
    private $tipobecaid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\BcEstatus
     */
    private $estatusid;


    /**
     * Get becaid
     *
     * @return integer
     */
    public function getBecaid()
    {
        return $this->becaid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return BcBecas
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set gradoidorigen
     *
     * @param \AppBundle\Entity\Grado $gradoidorigen
     *
     * @return BcBecas
     */
    public function setGradoidorigen(\AppBundle\Entity\Grado $gradoidorigen = null)
    {
        $this->gradoidorigen = $gradoidorigen;

        return $this;
    }

    /**
     * Get gradoidorigen
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoidorigen()
    {
        return $this->gradoidorigen;
    }

    /**
     * Set porcentajebecaid
     *
     * @param \AppBundle\Entity\BcPorcentajebeca $porcentajebecaid
     *
     * @return BcBecas
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
     * @return BcBecas
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

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return BcBecas
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

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return BcBecas
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set estatusid
     *
     * @param \AppBundle\Entity\BcEstatus $estatusid
     *
     * @return BcBecas
     */
    public function setEstatusid(\AppBundle\Entity\BcEstatus $estatusid = null)
    {
        $this->estatusid = $estatusid;

        return $this;
    }

    /**
     * Get estatusid
     *
     * @return \AppBundle\Entity\BcEstatus
     */
    public function getEstatusid()
    {
        return $this->estatusid;
    }
}

