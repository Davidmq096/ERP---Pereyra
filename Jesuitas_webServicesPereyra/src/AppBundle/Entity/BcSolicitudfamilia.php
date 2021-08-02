<?php

namespace AppBundle\Entity;

/**
 * BcSolicitudfamilia
 */
class BcSolicitudfamilia
{
    /**
     * @var integer
     */
    private $alumnosidec;

    /**
     * @var integer
     */
    private $estudiantestotales;

    /**
     * @var integer
     */
    private $miembrosfamilia;

    /**
     * @var integer
     */
    private $solicitudfamiliaid;

    /**
     * @var \AppBundle\Entity\BcEstatusfamilia
     */
    private $vivefamilia;

    /**
     * @var \AppBundle\Entity\BcEstatuspropiedad
     */
    private $estatuspropiedadid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set alumnosidec
     *
     * @param integer $alumnosidec
     *
     * @return BcSolicitudfamilia
     */
    public function setAlumnosidec($alumnosidec)
    {
        $this->alumnosidec = $alumnosidec;

        return $this;
    }

    /**
     * Get alumnosidec
     *
     * @return integer
     */
    public function getAlumnosidec()
    {
        return $this->alumnosidec;
    }

    /**
     * Set estudiantestotales
     *
     * @param integer $estudiantestotales
     *
     * @return BcSolicitudfamilia
     */
    public function setEstudiantestotales($estudiantestotales)
    {
        $this->estudiantestotales = $estudiantestotales;

        return $this;
    }

    /**
     * Get estudiantestotales
     *
     * @return integer
     */
    public function getEstudiantestotales()
    {
        return $this->estudiantestotales;
    }

    /**
     * Set miembrosfamilia
     *
     * @param integer $miembrosfamilia
     *
     * @return BcSolicitudfamilia
     */
    public function setMiembrosfamilia($miembrosfamilia)
    {
        $this->miembrosfamilia = $miembrosfamilia;

        return $this;
    }

    /**
     * Get miembrosfamilia
     *
     * @return integer
     */
    public function getMiembrosfamilia()
    {
        return $this->miembrosfamilia;
    }

    /**
     * Get solicitudfamiliaid
     *
     * @return integer
     */
    public function getSolicitudfamiliaid()
    {
        return $this->solicitudfamiliaid;
    }

    /**
     * Set vivefamilia
     *
     * @param \AppBundle\Entity\BcEstatusfamilia $vivefamilia
     *
     * @return BcSolicitudfamilia
     */
    public function setVivefamilia(\AppBundle\Entity\BcEstatusfamilia $vivefamilia = null)
    {
        $this->vivefamilia = $vivefamilia;

        return $this;
    }

    /**
     * Get vivefamilia
     *
     * @return \AppBundle\Entity\BcEstatusfamilia
     */
    public function getVivefamilia()
    {
        return $this->vivefamilia;
    }

    /**
     * Set estatuspropiedadid
     *
     * @param \AppBundle\Entity\BcEstatuspropiedad $estatuspropiedadid
     *
     * @return BcSolicitudfamilia
     */
    public function setEstatuspropiedadid(\AppBundle\Entity\BcEstatuspropiedad $estatuspropiedadid = null)
    {
        $this->estatuspropiedadid = $estatuspropiedadid;

        return $this;
    }

    /**
     * Get estatuspropiedadid
     *
     * @return \AppBundle\Entity\BcEstatuspropiedad
     */
    public function getEstatuspropiedadid()
    {
        return $this->estatuspropiedadid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcSolicitudfamilia
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

