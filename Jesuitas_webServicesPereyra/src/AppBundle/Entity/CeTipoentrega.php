<?php

namespace AppBundle\Entity;

/**
 * CeTipoentrega
 */
class CeTipoentrega
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
    private $tipoentregaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipoentrega
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
     * @return CeTipoentrega
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
     * Get tipoentregaid
     *
     * @return integer
     */
    public function getTipoentregaid()
    {
        return $this->tipoentregaid;
    }
}

