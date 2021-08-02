<?php

namespace AppBundle\Entity;

/**
 * IdecTiporubro
 */
class IdecTiporubro
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
    private $tiporubroid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return IdecTiporubro
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
     * @return IdecTiporubro
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
     * Get tiporubroid
     *
     * @return integer
     */
    public function getTiporubroid()
    {
        return $this->tiporubroid;
    }
}

