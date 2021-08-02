<?php

namespace AppBundle\Entity;

/**
 * Impresiondocumento
 */
class Impresiondocumento
{
    /**
     * @var \DateTime
     */
    private $fecharegistro = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     */
    private $impresiondocumentoid;

    /**
     * @var \AppBundle\Entity\Formato
     */
    private $formatoid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     *
     * @return Impresiondocumento
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
     * Get impresiondocumentoid
     *
     * @return integer
     */
    public function getImpresiondocumentoid()
    {
        return $this->impresiondocumentoid;
    }

    /**
     * Set formatoid
     *
     * @param \AppBundle\Entity\Formato $formatoid
     *
     * @return Impresiondocumento
     */
    public function setFormatoid(\AppBundle\Entity\Formato $formatoid = null)
    {
        $this->formatoid = $formatoid;

        return $this;
    }

    /**
     * Get formatoid
     *
     * @return \AppBundle\Entity\Formato
     */
    public function getFormatoid()
    {
        return $this->formatoid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return Impresiondocumento
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
     * @return Impresiondocumento
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

