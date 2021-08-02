<?php

namespace AppBundle\Entity;

/**
 * FoTipocobertura
 */
class FoTipocobertura
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
    private $tipocoberturaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return FoTipocobertura
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
     * @return FoTipocobertura
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
     * Get tipocoberturaid
     *
     * @return integer
     */
    public function getTipocoberturaid()
    {
        return $this->tipocoberturaid;
    }
}

