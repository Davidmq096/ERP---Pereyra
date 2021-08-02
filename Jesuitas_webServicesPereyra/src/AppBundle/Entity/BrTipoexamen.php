<?php

namespace AppBundle\Entity;

/**
 * BrTipoexamen
 */
class BrTipoexamen
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
    private $tipoexamenid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrTipoexamen
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
     * @return BrTipoexamen
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
     * Get tipoexamenid
     *
     * @return integer
     */
    public function getTipoexamenid()
    {
        return $this->tipoexamenid;
    }
}

