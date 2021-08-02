<?php

namespace AppBundle\Entity;

/**
 * Documento
 */
class Documento
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\Formato
     */
    private $formatoid;

    /**
     * @var \AppBundle\Entity\Tipodocumento
     */
    private $tipodocumentoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Documento
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Documento
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get documentoid
     *
     * @return integer
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set formatoid
     *
     * @param \AppBundle\Entity\Formato $formatoid
     *
     * @return Documento
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
     * Set tipodocumentoid
     *
     * @param \AppBundle\Entity\Tipodocumento $tipodocumentoid
     *
     * @return Documento
     */
    public function setTipodocumentoid(\AppBundle\Entity\Tipodocumento $tipodocumentoid = null)
    {
        $this->tipodocumentoid = $tipodocumentoid;

        return $this;
    }

    /**
     * Get tipodocumentoid
     *
     * @return \AppBundle\Entity\Tipodocumento
     */
    public function getTipodocumentoid()
    {
        return $this->tipodocumentoid;
    }
}

