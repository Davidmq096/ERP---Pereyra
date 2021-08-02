<?php

namespace AppBundle\Entity;

/**
 * CeTipomovimientobitacora
 */
class CeTipomovimientobitacora
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
    private $tipomovimientobitacoraid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipomovimientobitacora
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
     * @return CeTipomovimientobitacora
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
     * Get tipomovimientobitacoraid
     *
     * @return integer
     */
    public function getTipomovimientobitacoraid()
    {
        return $this->tipomovimientobitacoraid;
    }
}

