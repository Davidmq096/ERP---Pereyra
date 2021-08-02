<?php

namespace AppBundle\Entity;

/**
 * BcSituacionfamiliar
 */
class BcSituacionfamiliar
{
    /**
     * @var string
     */
    private $descripcionsituacionfamiliar;

    /**
     * @var integer
     */
    private $situacionfamiliarid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set descripcionsituacionfamiliar
     *
     * @param string $descripcionsituacionfamiliar
     *
     * @return BcSituacionfamiliar
     */
    public function setDescripcionsituacionfamiliar($descripcionsituacionfamiliar)
    {
        $this->descripcionsituacionfamiliar = $descripcionsituacionfamiliar;

        return $this;
    }

    /**
     * Get descripcionsituacionfamiliar
     *
     * @return string
     */
    public function getDescripcionsituacionfamiliar()
    {
        return $this->descripcionsituacionfamiliar;
    }

    /**
     * Get situacionfamiliarid
     *
     * @return integer
     */
    public function getSituacionfamiliarid()
    {
        return $this->situacionfamiliarid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcSituacionfamiliar
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

