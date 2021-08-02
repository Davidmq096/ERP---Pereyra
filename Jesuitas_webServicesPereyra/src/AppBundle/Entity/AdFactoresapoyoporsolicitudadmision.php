<?php

namespace AppBundle\Entity;

/**
 * AdFactoresapoyoporsolicitudadmision
 */
class AdFactoresapoyoporsolicitudadmision
{
    /**
     * @var integer
     */
    private $factoresapoyoporsolicitudadmisionid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;

    /**
     * @var \AppBundle\Entity\AdFactoresapoyo
     */
    private $factoresapoyoid;


    /**
     * Get factoresapoyoporsolicitudadmisionid
     *
     * @return integer
     */
    public function getFactoresapoyoporsolicitudadmisionid()
    {
        return $this->factoresapoyoporsolicitudadmisionid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return AdFactoresapoyoporsolicitudadmision
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = null)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }

    /**
     * Set factoresapoyoid
     *
     * @param \AppBundle\Entity\AdFactoresapoyo $factoresapoyoid
     *
     * @return AdFactoresapoyoporsolicitudadmision
     */
    public function setFactoresapoyoid(\AppBundle\Entity\AdFactoresapoyo $factoresapoyoid = null)
    {
        $this->factoresapoyoid = $factoresapoyoid;

        return $this;
    }

    /**
     * Get factoresapoyoid
     *
     * @return \AppBundle\Entity\AdFactoresapoyo
     */
    public function getFactoresapoyoid()
    {
        return $this->factoresapoyoid;
    }
}

