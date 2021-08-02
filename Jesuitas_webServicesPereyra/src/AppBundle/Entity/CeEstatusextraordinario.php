<?php

namespace AppBundle\Entity;

/**
 * CeEstatusextraordinario
 */
class CeEstatusextraordinario
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
    private $estatusextraordinarioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeEstatusextraordinario
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
     * @return CeEstatusextraordinario
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
     * Get estatusextraordinarioid
     *
     * @return integer
     */
    public function getEstatusextraordinarioid()
    {
        return $this->estatusextraordinarioid;
    }
}

