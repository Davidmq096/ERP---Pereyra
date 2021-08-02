<?php

namespace AppBundle\Entity;

/**
 * Documentorecibido
 */
class Documentorecibido
{
    /**
     * @var \DateTime
     */
    private $fecharegistro;

    /**
     * @var integer
     */
    private $documentorecibidoid;

    /**
     * @var \AppBundle\Entity\Documento
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;


    /**
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     *
     * @return Documentorecibido
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
     * Get documentorecibidoid
     *
     * @return integer
     */
    public function getDocumentorecibidoid()
    {
        return $this->documentorecibidoid;
    }

    /**
     * Set documentoid
     *
     * @param \AppBundle\Entity\Documento $documentoid
     *
     * @return Documentorecibido
     */
    public function setDocumentoid(\AppBundle\Entity\Documento $documentoid = null)
    {
        $this->documentoid = $documentoid;

        return $this;
    }

    /**
     * Get documentoid
     *
     * @return \AppBundle\Entity\Documento
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return Documentorecibido
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

