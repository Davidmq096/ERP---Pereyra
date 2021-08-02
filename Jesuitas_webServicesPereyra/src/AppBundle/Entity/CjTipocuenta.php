<?php

namespace AppBundle\Entity;

/**
 * CjTipocuenta
 */
class CjTipocuenta
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
    private $tipocuentaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjTipocuenta
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
     * @return CjTipocuenta
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
     * Get tipocuentaid
     *
     * @return integer
     */
    public function getTipocuentaid()
    {
        return $this->tipocuentaid;
    }
}

