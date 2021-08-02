<?php

namespace AppBundle\Entity;

/**
 * CeEstatusagendaextraordinario
 */
class CeEstatusagendaextraordinario
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
    private $estatusagendaextraordinarioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeEstatusagendaextraordinario
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
     * @return CeEstatusagendaextraordinario
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
     * Get estatusagendaextraordinarioid
     *
     * @return integer
     */
    public function getEstatusagendaextraordinarioid()
    {
        return $this->estatusagendaextraordinarioid;
    }
}

