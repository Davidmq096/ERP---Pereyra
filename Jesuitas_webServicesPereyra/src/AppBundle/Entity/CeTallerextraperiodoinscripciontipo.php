<?php

namespace AppBundle\Entity;

/**
 * CeTallerextraperiodoinscripciontipo
 */
class CeTallerextraperiodoinscripciontipo
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $activo;

    /**
     * @var integer
     */
    private $tallerextraperiodoinscripciontipoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTallerextraperiodoinscripciontipo
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
     * @param integer $activo
     *
     * @return CeTallerextraperiodoinscripciontipo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get tallerextraperiodoinscripciontipoid
     *
     * @return integer
     */
    public function getTallerextraperiodoinscripciontipoid()
    {
        return $this->tallerextraperiodoinscripciontipoid;
    }
}

