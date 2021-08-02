<?php

namespace AppBundle\Entity;

/**
 * BcSolicitudingresos
 */
class BcSolicitudingresos
{
    /**
     * @var float
     */
    private $ingresos;

    /**
     * @var float
     */
    private $egresos;

    /**
     * @var integer
     */
    private $solicitudingresosid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set ingresos
     *
     * @param float $ingresos
     *
     * @return BcSolicitudingresos
     */
    public function setIngresos($ingresos)
    {
        $this->ingresos = $ingresos;

        return $this;
    }

    /**
     * Get ingresos
     *
     * @return float
     */
    public function getIngresos()
    {
        return $this->ingresos;
    }

    /**
     * Set egresos
     *
     * @param float $egresos
     *
     * @return BcSolicitudingresos
     */
    public function setEgresos($egresos)
    {
        $this->egresos = $egresos;

        return $this;
    }

    /**
     * Get egresos
     *
     * @return float
     */
    public function getEgresos()
    {
        return $this->egresos;
    }

    /**
     * Get solicitudingresosid
     *
     * @return integer
     */
    public function getSolicitudingresosid()
    {
        return $this->solicitudingresosid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcSolicitudingresos
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

