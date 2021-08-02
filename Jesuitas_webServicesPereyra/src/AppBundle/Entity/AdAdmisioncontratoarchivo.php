<?php

namespace AppBundle\Entity;

/**
 * AdAdmisioncontratoarchivo
 */
class AdAdmisioncontratoarchivo
{
    /**
     * @var integer
     */
    private $admisioncontratoid;

    /**
     * @var integer
     */
    private $contratoid;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $admisioncontratoarchivoid;


    /**
     * Set admisioncontratoid
     *
     * @param integer $admisioncontratoid
     *
     * @return AdAdmisioncontratoarchivo
     */
    public function setAdmisioncontratoid($admisioncontratoid)
    {
        $this->admisioncontratoid = $admisioncontratoid;

        return $this;
    }

    /**
     * Get admisioncontratoid
     *
     * @return integer
     */
    public function getAdmisioncontratoid()
    {
        return $this->admisioncontratoid;
    }

    /**
     * Set contratoid
     *
     * @param integer $contratoid
     *
     * @return AdAdmisioncontratoarchivo
     */
    public function setContratoid($contratoid)
    {
        $this->contratoid = $contratoid;

        return $this;
    }

    /**
     * Get contratoid
     *
     * @return integer
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return AdAdmisioncontratoarchivo
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
     * Set extension
     *
     * @param string $extension
     *
     * @return AdAdmisioncontratoarchivo
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdAdmisioncontratoarchivo
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
     * Get admisioncontratoarchivoid
     *
     * @return integer
     */
    public function getAdmisioncontratoarchivoid()
    {
        return $this->admisioncontratoarchivoid;
    }
}

