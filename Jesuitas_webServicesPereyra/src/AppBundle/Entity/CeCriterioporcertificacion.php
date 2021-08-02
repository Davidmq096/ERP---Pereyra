<?php

namespace AppBundle\Entity;

/**
 * CeCriterioporcertificacion
 */
class CeCriterioporcertificacion
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $criterioporcertificacionid;

    /**
     * @var \AppBundle\Entity\CeCertificacion
     */
    private $certificacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeCriterioporcertificacion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get criterioporcertificacionid
     *
     * @return integer
     */
    public function getCriterioporcertificacionid()
    {
        return $this->criterioporcertificacionid;
    }

    /**
     * Set certificacionid
     *
     * @param \AppBundle\Entity\CeCertificacion $certificacionid
     *
     * @return CeCriterioporcertificacion
     */
    public function setCertificacionid(\AppBundle\Entity\CeCertificacion $certificacionid = null)
    {
        $this->certificacionid = $certificacionid;

        return $this;
    }

    /**
     * Get certificacionid
     *
     * @return \AppBundle\Entity\CeCertificacion
     */
    public function getCertificacionid()
    {
        return $this->certificacionid;
    }
}

