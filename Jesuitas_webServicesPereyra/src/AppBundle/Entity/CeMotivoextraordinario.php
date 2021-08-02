<?php

namespace AppBundle\Entity;

/**
 * CeMotivoextraordinario
 */
class CeMotivoextraordinario
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
    private $motivoextraordinarioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeMotivoextraordinario
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
     * @return CeMotivoextraordinario
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
     * Get motivoextraordinarioid
     *
     * @return integer
     */
    public function getMotivoextraordinarioid()
    {
        return $this->motivoextraordinarioid;
    }
}

