<?php

namespace AppBundle\Entity;

/**
 * RiReinscripciondocumento
 */
class RiReinscripciondocumento
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var integer
     */
    private $reinscripciondocumentoid;

    /**
     * @var \AppBundle\Entity\RiDocumento
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\RiReinscripcion
     */
    private $reinscripcionid;


    /**
     * Set url
     *
     * @param string $url
     *
     * @return RiReinscripciondocumento
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return RiReinscripciondocumento
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
     * Set extension
     *
     * @param string $extension
     *
     * @return RiReinscripciondocumento
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Get reinscripciondocumentoid
     *
     * @return integer
     */
    public function getReinscripciondocumentoid()
    {
        return $this->reinscripciondocumentoid;
    }

    /**
     * Set documentoid
     *
     * @param \AppBundle\Entity\RiDocumento $documentoid
     *
     * @return RiReinscripciondocumento
     */
    public function setDocumentoid(\AppBundle\Entity\RiDocumento $documentoid = null)
    {
        $this->documentoid = $documentoid;

        return $this;
    }

    /**
     * Get documentoid
     *
     * @return \AppBundle\Entity\RiDocumento
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set reinscripcionid
     *
     * @param \AppBundle\Entity\RiReinscripcion $reinscripcionid
     *
     * @return RiReinscripciondocumento
     */
    public function setReinscripcionid(\AppBundle\Entity\RiReinscripcion $reinscripcionid = null)
    {
        $this->reinscripcionid = $reinscripcionid;

        return $this;
    }

    /**
     * Get reinscripcionid
     *
     * @return \AppBundle\Entity\RiReinscripcion
     */
    public function getReinscripcionid()
    {
        return $this->reinscripcionid;
    }
}

