<?php

namespace AppBundle\Entity;

/**
 * CeTipoextraordinario
 */
class CeTipoextraordinario
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
    private $tipoextraordinarioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipoextraordinario
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
     * @return CeTipoextraordinario
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
     * Get tipoextraordinarioid
     *
     * @return integer
     */
    public function getTipoextraordinarioid()
    {
        return $this->tipoextraordinarioid;
    }
}

