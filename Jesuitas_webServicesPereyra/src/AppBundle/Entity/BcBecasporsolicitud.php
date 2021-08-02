<?php

namespace AppBundle\Entity;

/**
 * BcBecasporsolicitud
 */
class BcBecasporsolicitud
{
    /**
     * @var integer
     */
    private $becaporsolicitudid;

    /**
     * @var \AppBundle\Entity\BcBecas
     */
    private $becaid;

    /**
     * @var \AppBundle\Entity\BcProvisionalbecas
     */
    private $provisionalbecaid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Get becaporsolicitudid
     *
     * @return integer
     */
    public function getBecaporsolicitudid()
    {
        return $this->becaporsolicitudid;
    }

    /**
     * Set becaid
     *
     * @param \AppBundle\Entity\BcBecas $becaid
     *
     * @return BcBecasporsolicitud
     */
    public function setBecaid(\AppBundle\Entity\BcBecas $becaid = null)
    {
        $this->becaid = $becaid;

        return $this;
    }

    /**
     * Get becaid
     *
     * @return \AppBundle\Entity\BcBecas
     */
    public function getBecaid()
    {
        return $this->becaid;
    }

    /**
     * Set provisionalbecaid
     *
     * @param \AppBundle\Entity\BcProvisionalbecas $provisionalbecaid
     *
     * @return BcBecasporsolicitud
     */
    public function setProvisionalbecaid(\AppBundle\Entity\BcProvisionalbecas $provisionalbecaid = null)
    {
        $this->provisionalbecaid = $provisionalbecaid;

        return $this;
    }

    /**
     * Get provisionalbecaid
     *
     * @return \AppBundle\Entity\BcProvisionalbecas
     */
    public function getProvisionalbecaid()
    {
        return $this->provisionalbecaid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcBecasporsolicitud
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

