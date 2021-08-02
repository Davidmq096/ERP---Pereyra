<?php

namespace AppBundle\Entity;

/**
 * CeTipotelefono
 */
class CeTipotelefono
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
    private $tipotelefonoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipotelefono
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
     * @return CeTipotelefono
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
     * Get tipotelefonoid
     *
     * @return integer
     */
    public function getTipotelefonoid()
    {
        return $this->tipotelefonoid;
    }
}

