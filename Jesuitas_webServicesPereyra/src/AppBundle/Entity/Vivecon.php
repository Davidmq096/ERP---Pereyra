<?php

namespace AppBundle\Entity;

/**
 * Vivecon
 */
class Vivecon
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
    private $viveconid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Vivecon
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
     * @return Vivecon
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
     * Get viveconid
     *
     * @return integer
     */
    public function getViveconid()
    {
        return $this->viveconid;
    }
}

