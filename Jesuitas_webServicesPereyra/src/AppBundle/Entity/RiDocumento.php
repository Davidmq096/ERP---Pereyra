<?php

namespace AppBundle\Entity;

/**
 * RiDocumento
 */
class RiDocumento
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $orden;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var integer
     */
    private $tamano;

    /**
     * @var string
     */
    private $documento;

    /**
     * @var string
     */
    private $url;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $documentoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return RiDocumento
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return RiDocumento
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return RiDocumento
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
     * Set tamano
     *
     * @param integer $tamano
     *
     * @return RiDocumento
     */
    public function setTamano($tamano)
    {
        $this->tamano = $tamano;

        return $this;
    }

    /**
     * Get tamano
     *
     * @return integer
     */
    public function getTamano()
    {
        return $this->tamano;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return RiDocumento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return RiDocumento
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return RiDocumento
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
}

