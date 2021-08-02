<?php

namespace AppBundle\Entity;

/**
 * IdecTipodetallerubro
 */
class IdecTipodetallerubro
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
    private $tipodetallerubro;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return IdecTipodetallerubro
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
     * @return IdecTipodetallerubro
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
     * Get tipodetallerubro
     *
     * @return integer
     */
    public function getTipodetallerubro()
    {
        return $this->tipodetallerubro;
    }
}

