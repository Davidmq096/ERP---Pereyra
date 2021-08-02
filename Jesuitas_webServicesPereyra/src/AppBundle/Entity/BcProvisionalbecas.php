<?php

namespace AppBundle\Entity;

/**
 * BcProvisionalbecas
 */
class BcProvisionalbecas
{
    /**
     * @var integer
     */
    private $provisionalbecaid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\BcEstatus
     */
    private $estatusid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\BcPorcentajebeca
     */
    private $porcentajebecaid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;

    /**
     * @var \AppBundle\Entity\BcTipobeca
     */
    private $tipobecaid;


    /**
     * Get provisionalbecaid
     *
     * @return integer
     */
    public function getProvisionalbecaid()
    {
        return $this->provisionalbecaid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return BcProvisionalbecas
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
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return BcProvisionalbecas
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
     * @return BcProvisionalbecas
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

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return BcProvisionalbecas
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
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return BcProvisionalbecas
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
     * @return BcProvisionalbecas
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
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcProvisionalbecas
     */
    public function setSolicitudid(\AppBundle\Entity\BcSolicitudbeca $solicitudid = null)
    {
        $this->solicitudid = $solicitudid;

        return $this;
    }

    /**
     * Get solicitudid
     *
     * @return \AppBundle\Entity\BcSolicitudbeca
     */
    public function getSolicitudid()
    {
        return $this->solicitudid;
    }

    /**
     * Set tipobecaid
     *
     * @param \AppBundle\Entity\BcTipobeca $tipobecaid
     *
     * @return BcProvisionalbecas
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

