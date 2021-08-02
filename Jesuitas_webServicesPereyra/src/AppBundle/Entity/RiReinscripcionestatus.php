<?php

namespace AppBundle\Entity;

/**
 * RiReinscripcionestatus
 */
class RiReinscripcionestatus
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $reinscripcionestatusid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return RiReinscripcionestatus
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
     * @return RiReinscripcionestatus
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
     * Get reinscripcionestatusid
     *
     * @return integer
     */
    public function getReinscripcionestatusid()
    {
        return $this->reinscripcionestatusid;
    }
}

