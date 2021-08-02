<?php

namespace AppBundle\Entity;

/**
 * AdAdmisionseguimientocontrato
 */
class AdAdmisionseguimientocontrato
{
    /**
     * @var integer
     */
    private $solicitudadmisionid;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $formapago;

    /**
     * @var integer
     */
    private $admisioncontratosid;

    /**
     * @var \AppBundle\Entity\AdAdmisionestatuscontrato
     */
    private $estatusid;

    /**
     * @var \AppBundle\Entity\CjPlanpago
     */
    private $planpagoid;


    /**
     * Set solicitudadmisionid
     *
     * @param integer $solicitudadmisionid
     *
     * @return AdAdmisionseguimientocontrato
     */
    public function setSolicitudadmisionid($solicitudadmisionid)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return integer
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return AdAdmisionseguimientocontrato
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return AdAdmisionseguimientocontrato
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set formapago
     *
     * @param integer $formapago
     *
     * @return AdAdmisionseguimientocontrato
     */
    public function setFormapago($formapago)
    {
        $this->formapago = $formapago;

        return $this;
    }

    /**
     * Get formapago
     *
     * @return integer
     */
    public function getFormapago()
    {
        return $this->formapago;
    }

    /**
     * Get admisioncontratosid
     *
     * @return integer
     */
    public function getAdmisioncontratosid()
    {
        return $this->admisioncontratosid;
    }

    /**
     * Set estatusid
     *
     * @param \AppBundle\Entity\AdAdmisionestatuscontrato $estatusid
     *
     * @return AdAdmisionseguimientocontrato
     */
    public function setEstatusid(\AppBundle\Entity\AdAdmisionestatuscontrato $estatusid = null)
    {
        $this->estatusid = $estatusid;

        return $this;
    }

    /**
     * Get estatusid
     *
     * @return \AppBundle\Entity\AdAdmisionestatuscontrato
     */
    public function getEstatusid()
    {
        return $this->estatusid;
    }

    /**
     * Set planpagoid
     *
     * @param \AppBundle\Entity\CjPlanpago $planpagoid
     *
     * @return AdAdmisionseguimientocontrato
     */
    public function setPlanpagoid(\AppBundle\Entity\CjPlanpago $planpagoid = null)
    {
        $this->planpagoid = $planpagoid;

        return $this;
    }

    /**
     * Get planpagoid
     *
     * @return \AppBundle\Entity\CjPlanpago
     */
    public function getPlanpagoid()
    {
        return $this->planpagoid;
    }
}

