<?php

namespace AppBundle\Entity;

/**
 * BcVisitaestudiosocioeconomico
 */
class BcVisitaestudiosocioeconomico
{
    /**
     * @var string
     */
    private $visitaestudiosocioeconomico;

    /**
     * @var integer
     */
    private $visitaestudiosocioeconomicoid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set visitaestudiosocioeconomico
     *
     * @param string $visitaestudiosocioeconomico
     *
     * @return BcVisitaestudiosocioeconomico
     */
    public function setVisitaestudiosocioeconomico($visitaestudiosocioeconomico)
    {
        $this->visitaestudiosocioeconomico = $visitaestudiosocioeconomico;

        return $this;
    }

    /**
     * Get visitaestudiosocioeconomico
     *
     * @return string
     */
    public function getVisitaestudiosocioeconomico()
    {
        return $this->visitaestudiosocioeconomico;
    }

    /**
     * Get visitaestudiosocioeconomicoid
     *
     * @return integer
     */
    public function getVisitaestudiosocioeconomicoid()
    {
        return $this->visitaestudiosocioeconomicoid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcVisitaestudiosocioeconomico
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

