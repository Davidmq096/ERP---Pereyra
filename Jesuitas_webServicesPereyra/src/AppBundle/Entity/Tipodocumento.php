<?php

namespace AppBundle\Entity;

/**
 * Tipodocumento
 */
class Tipodocumento
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
    private $tipodocumentoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Tipodocumento
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
     * @return Tipodocumento
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
     * Get tipodocumentoid
     *
     * @return integer
     */
    public function getTipodocumentoid()
    {
        return $this->tipodocumentoid;
    }
}

