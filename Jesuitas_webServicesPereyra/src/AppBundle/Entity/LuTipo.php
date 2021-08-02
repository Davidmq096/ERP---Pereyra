<?php

namespace AppBundle\Entity;

/**
 * LuTipo
 */
class LuTipo
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $activo;

    /**
     * @var integer
     */
    private $tipoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return LuTipo
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
     * @param integer $activo
     *
     * @return LuTipo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get tipoid
     *
     * @return integer
     */
    public function getTipoid()
    {
        return $this->tipoid;
    }
}

