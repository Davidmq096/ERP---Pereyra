<?php

namespace AppBundle\Entity;

/**
 * CeSubgrupo
 */
class CeSubgrupo
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
    private $subgrupoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeSubgrupo
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
     * @return CeSubgrupo
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
     * Get subgrupoid
     *
     * @return integer
     */
    public function getSubgrupoid()
    {
        return $this->subgrupoid;
    }
}

