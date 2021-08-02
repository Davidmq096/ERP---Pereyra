<?php

namespace AppBundle\Entity;

/**
 * Submodulo
 */
class Submodulo
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
     * @var integer
     */
    private $orden;

    /**
     * @var integer
     */
    private $submoduloid;

    /**
     * @var \AppBundle\Entity\Modulo
     */
    private $moduloid;


    /**
     * Set identificador
     *
     * @param string $identificador
     *
     * @return Submodulo
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
     * @return Submodulo
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
     * @return Submodulo
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return Submodulo
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
     * Get submoduloid
     *
     * @return integer
     */
    public function getSubmoduloid()
    {
        return $this->submoduloid;
    }

    /**
     * Set moduloid
     *
     * @param \AppBundle\Entity\Modulo $moduloid
     *
     * @return Submodulo
     */
    public function setModuloid(\AppBundle\Entity\Modulo $moduloid = null)
    {
        $this->moduloid = $moduloid;

        return $this;
    }

    /**
     * Get moduloid
     *
     * @return \AppBundle\Entity\Modulo
     */
    public function getModuloid()
    {
        return $this->moduloid;
    }
}

