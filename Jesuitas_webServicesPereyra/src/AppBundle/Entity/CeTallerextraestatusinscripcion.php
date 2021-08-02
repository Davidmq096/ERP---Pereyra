<?php

namespace AppBundle\Entity;

/**
 * CeTallerextraestatusinscripcion
 */
class CeTallerextraestatusinscripcion
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
    private $tallerextraestatusinscripcionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTallerextraestatusinscripcion
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
     * @return CeTallerextraestatusinscripcion
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
     * Get tallerextraestatusinscripcionid
     *
     * @return integer
     */
    public function getTallerextraestatusinscripcionid()
    {
        return $this->tallerextraestatusinscripcionid;
    }
}

