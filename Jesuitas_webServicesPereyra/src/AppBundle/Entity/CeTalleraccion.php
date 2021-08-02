<?php

namespace AppBundle\Entity;

/**
 * CeTalleraccion
 */
class CeTalleraccion
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
    private $talleraccionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTalleraccion
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
     * @return CeTalleraccion
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
     * Get talleraccionid
     *
     * @return integer
     */
    public function getTalleraccionid()
    {
        return $this->talleraccionid;
    }
}

