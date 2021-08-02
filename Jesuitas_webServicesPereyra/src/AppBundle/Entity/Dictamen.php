<?php

namespace AppBundle\Entity;

/**
 * Dictamen
 */
class Dictamen
{
    /**
     * @var string
     */
    private $dictamen;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var \DateTime
     */
    private $fecharegistro;

    /**
     * @var integer
     */
    private $dictamenid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set dictamen
     *
     * @param string $dictamen
     *
     * @return Dictamen
     */
    public function setDictamen($dictamen)
    {
        $this->dictamen = $dictamen;

        return $this;
    }

    /**
     * Get dictamen
     *
     * @return string
     */
    public function getDictamen()
    {
        return $this->dictamen;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return Dictamen
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     *
     * @return Dictamen
     */
    public function setFecharegistro($fecharegistro)
    {
        $this->fecharegistro = $fecharegistro;

        return $this;
    }

    /**
     * Get fecharegistro
     *
     * @return \DateTime
     */
    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }

    /**
     * Get dictamenid
     *
     * @return integer
     */
    public function getDictamenid()
    {
        return $this->dictamenid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return Dictamen
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
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return Dictamen
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

