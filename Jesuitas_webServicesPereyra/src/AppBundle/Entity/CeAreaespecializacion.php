<?php

namespace AppBundle\Entity;

/**
 * CeAreaespecializacion
 */
class CeAreaespecializacion
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
    private $areaespecializacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeAreaespecializacion
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
     * @return CeAreaespecializacion
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
     * Get areaespecializacionid
     *
     * @return integer
     */
    public function getAreaespecializacionid()
    {
        return $this->areaespecializacionid;
    }
}

