<?php

namespace AppBundle\Entity;

/**
 * Documentoporsolicitudadmision
 */
class Documentoporsolicitudadmision
{
    /**
     * @var boolean
     */
    private $entregado;

    /**
     * @var \DateTime
     */
    private $fechaentrega;

    /**
     * @var boolean
     */
    private $validado;

    /**
     * @var integer
     */
    private $documentoporsolicitudadmisionid;

    /**
     * @var \AppBundle\Entity\Documentoporgrado
     */
    private $documentoporgradoid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmision;


    /**
     * Set entregado
     *
     * @param boolean $entregado
     *
     * @return Documentoporsolicitudadmision
     */
    public function setEntregado($entregado)
    {
        $this->entregado = $entregado;

        return $this;
    }

    /**
     * Get entregado
     *
     * @return boolean
     */
    public function getEntregado()
    {
        return $this->entregado;
    }

    /**
     * Set fechaentrega
     *
     * @param \DateTime $fechaentrega
     *
     * @return Documentoporsolicitudadmision
     */
    public function setFechaentrega($fechaentrega)
    {
        $this->fechaentrega = $fechaentrega;

        return $this;
    }

    /**
     * Get fechaentrega
     *
     * @return \DateTime
     */
    public function getFechaentrega()
    {
        return $this->fechaentrega;
    }

    /**
     * Set validado
     *
     * @param boolean $validado
     *
     * @return Documentoporsolicitudadmision
     */
    public function setValidado($validado)
    {
        $this->validado = $validado;

        return $this;
    }

    /**
     * Get validado
     *
     * @return boolean
     */
    public function getValidado()
    {
        return $this->validado;
    }

    /**
     * Get documentoporsolicitudadmisionid
     *
     * @return integer
     */
    public function getDocumentoporsolicitudadmisionid()
    {
        return $this->documentoporsolicitudadmisionid;
    }

    /**
     * Set documentoporgradoid
     *
     * @param \AppBundle\Entity\Documentoporgrado $documentoporgradoid
     *
     * @return Documentoporsolicitudadmision
     */
    public function setDocumentoporgradoid(\AppBundle\Entity\Documentoporgrado $documentoporgradoid = null)
    {
        $this->documentoporgradoid = $documentoporgradoid;

        return $this;
    }

    /**
     * Get documentoporgradoid
     *
     * @return \AppBundle\Entity\Documentoporgrado
     */
    public function getDocumentoporgradoid()
    {
        return $this->documentoporgradoid;
    }

    /**
     * Set solicitudadmision
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmision
     *
     * @return Documentoporsolicitudadmision
     */
    public function setSolicitudadmision(\AppBundle\Entity\Solicitudadmision $solicitudadmision = null)
    {
        $this->solicitudadmision = $solicitudadmision;

        return $this;
    }

    /**
     * Get solicitudadmision
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmision()
    {
        return $this->solicitudadmision;
    }
}

