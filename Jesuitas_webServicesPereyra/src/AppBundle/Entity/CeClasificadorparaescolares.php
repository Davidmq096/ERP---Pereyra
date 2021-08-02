<?php

namespace AppBundle\Entity;

/**
 * CeClasificadorparaescolares
 */
class CeClasificadorparaescolares
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
    private $clasificadorparaescolaresid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeClasificadorparaescolares
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
     * @return CeClasificadorparaescolares
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
     * Get clasificadorparaescolaresid
     *
     * @return integer
     */
    public function getClasificadorparaescolaresid()
    {
        return $this->clasificadorparaescolaresid;
    }
}

