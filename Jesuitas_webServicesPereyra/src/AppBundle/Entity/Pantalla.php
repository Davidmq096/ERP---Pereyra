<?php

namespace AppBundle\Entity;

/**
 * Pantalla
 */
class Pantalla
{
    /**
     * @var string
     */
    private $identificador;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $orden;

    /**
     * @var integer
     */
    private $pantallaid;

    /**
     * @var \AppBundle\Entity\Submodulo
     */
    private $submoduloid;


    /**
     * Set identificador
     *
     * @param string $identificador
     *
     * @return Pantalla
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get identificador
     *
     * @return string
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Pantalla
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
     * @return Pantalla
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
     * Set url
     *
     * @param string $url
     *
     * @return Pantalla
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return Pantalla
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
     * Get pantallaid
     *
     * @return integer
     */
    public function getPantallaid()
    {
        return $this->pantallaid;
    }

    /**
     * Set submoduloid
     *
     * @param \AppBundle\Entity\Submodulo $submoduloid
     *
     * @return Pantalla
     */
    public function setSubmoduloid(\AppBundle\Entity\Submodulo $submoduloid = null)
    {
        $this->submoduloid = $submoduloid;

        return $this;
    }

    /**
     * Get submoduloid
     *
     * @return \AppBundle\Entity\Submodulo
     */
    public function getSubmoduloid()
    {
        return $this->submoduloid;
    }
}

