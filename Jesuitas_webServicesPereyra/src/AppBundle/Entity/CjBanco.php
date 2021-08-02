<?php

namespace AppBundle\Entity;

/**
 * CjBanco
 */
class CjBanco
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $cuenta = '';

    /**
     * @var string
     */
    private $clave = '';

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $bancoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjBanco
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
     * Set cuenta
     *
     * @param string $cuenta
     *
     * @return CjBanco
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return string
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return CjBanco
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
     * @return CjBanco
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
     * Get bancoid
     *
     * @return integer
     */
    public function getBancoid()
    {
        return $this->bancoid;
    }
}

