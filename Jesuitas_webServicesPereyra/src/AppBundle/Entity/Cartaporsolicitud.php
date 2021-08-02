<?php

namespace AppBundle\Entity;

/**
 * Cartaporsolicitud
 */
class Cartaporsolicitud
{
    /**
     * @var integer
     */
    private $cartaporsolicitudid;

    /**
     * @var \AppBundle\Entity\Formato
     */
    private $cartaid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;


    /**
     * Get cartaporsolicitudid
     *
     * @return integer
     */
    public function getCartaporsolicitudid()
    {
        return $this->cartaporsolicitudid;
    }

    /**
     * Set cartaid
     *
     * @param \AppBundle\Entity\Formato $cartaid
     *
     * @return Cartaporsolicitud
     */
    public function setCartaid(\AppBundle\Entity\Formato $cartaid = null)
    {
        $this->cartaid = $cartaid;

        return $this;
    }

    /**
     * Get cartaid
     *
     * @return \AppBundle\Entity\Formato
     */
    public function getCartaid()
    {
        return $this->cartaid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return Cartaporsolicitud
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
}

