<?php

namespace AppBundle\Entity;

/**
 * BcRecibirdocumentos
 */
class BcRecibirdocumentos
{
    /**
     * @var integer
     */
    private $recibirdocumentosid;

    /**
     * @var \AppBundle\Entity\BcDocumentos
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Get recibirdocumentosid
     *
     * @return integer
     */
    public function getRecibirdocumentosid()
    {
        return $this->recibirdocumentosid;
    }

    /**
     * Set documentoid
     *
     * @param \AppBundle\Entity\BcDocumentos $documentoid
     *
     * @return BcRecibirdocumentos
     */
    public function setDocumentoid(\AppBundle\Entity\BcDocumentos $documentoid = null)
    {
        $this->documentoid = $documentoid;

        return $this;
    }

    /**
     * Get documentoid
     *
     * @return \AppBundle\Entity\BcDocumentos
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcRecibirdocumentos
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

