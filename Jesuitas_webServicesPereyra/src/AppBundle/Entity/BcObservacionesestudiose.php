<?php

namespace AppBundle\Entity;

/**
 * BcObservacionesestudiose
 */
class BcObservacionesestudiose
{
    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $observaionesestudioseid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return BcObservacionesestudiose
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
     * Get observaionesestudioseid
     *
     * @return integer
     */
    public function getObservaionesestudioseid()
    {
        return $this->observaionesestudioseid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcObservacionesestudiose
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

