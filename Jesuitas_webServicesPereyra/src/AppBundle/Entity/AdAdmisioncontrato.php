<?php

namespace AppBundle\Entity;

/**
 * AdAdmisioncontrato
 */
class AdAdmisioncontrato
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
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $contratoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdAdmisioncontrato
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
     * @return AdAdmisioncontrato
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
     * @return AdAdmisioncontrato
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
     * @return AdAdmisioncontrato
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
     * @return AdAdmisioncontrato
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return AdAdmisioncontrato
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
     * Get contratoid
     *
     * @return integer
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }
}

