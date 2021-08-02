<?php

namespace AppBundle\Entity;

/**
 * BrCampoformacion
 */
class BrCampoformacion
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
    private $campoformacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrCampoformacion
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
     * @return BrCampoformacion
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
     * Get campoformacionid
     *
     * @return integer
     */
    public function getCampoformacionid()
    {
        return $this->campoformacionid;
    }
}

