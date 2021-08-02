<?php

namespace AppBundle\Entity;

/**
 * CbTipobloqueo
 */
class CbTipobloqueo
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
    private $tipobloqueoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CbTipobloqueo
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
     * @return CbTipobloqueo
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
     * Get tipobloqueoid
     *
     * @return integer
     */
    public function getTipobloqueoid()
    {
        return $this->tipobloqueoid;
    }
}

