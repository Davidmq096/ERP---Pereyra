<?php

namespace AppBundle\Entity;

/**
 * CbTipogarantia
 */
class CbTipogarantia
{
    /**
     * @var string
     */
    private $nombre = 'NULL';

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $tipogarantiaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CbTipogarantia
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
     * @return CbTipogarantia
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
     * Get tipogarantiaid
     *
     * @return integer
     */
    public function getTipogarantiaid()
    {
        return $this->tipogarantiaid;
    }
}

