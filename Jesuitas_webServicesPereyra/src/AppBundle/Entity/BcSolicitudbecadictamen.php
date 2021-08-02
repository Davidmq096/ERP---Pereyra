<?php

namespace AppBundle\Entity;

/**
 * BcSolicitudbecadictamen
 */
class BcSolicitudbecadictamen
{
    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $dictamenid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\BcPorcentajebeca
     */
    private $porcentajebecaid;

    /**
     * @var \AppBundle\Entity\BcTipobeca
     */
    private $tipobecaid;

    /**
     * @var \AppBundle\Entity\BcEstatus
     */
    private $estatusid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return BcSolicitudbecadictamen
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Get dictamenid
     *
     * @return integer
     */
    public function getDictamenid()
    {
        return $this->dictamenid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return BcSolicitudbecadictamen
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
     * Set porcentajebecaid
     *
     * @param \AppBundle\Entity\BcPorcentajebeca $porcentajebecaid
     *
     * @return BcSolicitudbecadictamen
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
     * @return BcSolicitudbecadictamen
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
     * Set estatusid
     *
     * @param \AppBundle\Entity\BcEstatus $estatusid
     *
     * @return BcSolicitudbecadictamen
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
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcSolicitudbecadictamen
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
}

