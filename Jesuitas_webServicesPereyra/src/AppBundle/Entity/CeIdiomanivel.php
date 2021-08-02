<?php

namespace AppBundle\Entity;

/**
 * CeIdiomanivel
 */
class CeIdiomanivel
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
    private $clave;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $idiomanivelid;

    /**
     * @var \AppBundle\Entity\CeIdioma
     */
    private $idiomaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeIdiomanivel
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
     * @return CeIdiomanivel
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
     * Set clave
     *
     * @param string $clave
     *
     * @return CeIdiomanivel
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeIdiomanivel
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
     * Get idiomanivelid
     *
     * @return integer
     */
    public function getIdiomanivelid()
    {
        return $this->idiomanivelid;
    }

    /**
     * Set idiomaid
     *
     * @param \AppBundle\Entity\CeIdioma $idiomaid
     *
     * @return CeIdiomanivel
     */
    public function setIdiomaid(\AppBundle\Entity\CeIdioma $idiomaid = null)
    {
        $this->idiomaid = $idiomaid;

        return $this;
    }

    /**
     * Get idiomaid
     *
     * @return \AppBundle\Entity\CeIdioma
     */
    public function getIdiomaid()
    {
        return $this->idiomaid;
    }
}

