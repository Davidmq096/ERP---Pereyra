<?php

namespace AppBundle\Entity;

/**
 * CePonderacion
 */
class CePonderacion
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
    private $ponderacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CePonderacion
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
     * @return CePonderacion
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
     * Get ponderacionid
     *
     * @return integer
     */
    public function getPonderacionid()
    {
        return $this->ponderacionid;
    }
}

