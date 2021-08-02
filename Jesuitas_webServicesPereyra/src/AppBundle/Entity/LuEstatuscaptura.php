<?php

namespace AppBundle\Entity;

/**
 * LuEstatuscaptura
 */
class LuEstatuscaptura
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $estatuscapturaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return LuEstatuscaptura
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
     * @return LuEstatuscaptura
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
     * Get estatuscapturaid
     *
     * @return integer
     */
    public function getEstatuscapturaid()
    {
        return $this->estatuscapturaid;
    }
}

