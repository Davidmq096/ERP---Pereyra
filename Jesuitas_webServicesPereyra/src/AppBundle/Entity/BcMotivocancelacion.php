<?php

namespace AppBundle\Entity;

/**
 * BcMotivocancelacion
 */
class BcMotivocancelacion
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $activo;

    /**
     * @var integer
     */
    private $motivocancelacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BcMotivocancelacion
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
     * @param string $activo
     *
     * @return BcMotivocancelacion
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return string
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get motivocancelacionid
     *
     * @return integer
     */
    public function getMotivocancelacionid()
    {
        return $this->motivocancelacionid;
    }
}

