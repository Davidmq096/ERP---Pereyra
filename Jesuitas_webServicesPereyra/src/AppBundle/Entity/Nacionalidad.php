<?php

namespace AppBundle\Entity;

/**
 * Nacionalidad
 */
class Nacionalidad
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $nacionalidadid;

    /**
     * @var \AppBundle\Entity\Pais
     */
    private $paisid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Nacionalidad
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
     * @return Nacionalidad
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
     * Get nacionalidadid
     *
     * @return integer
     */
    public function getNacionalidadid()
    {
        return $this->nacionalidadid;
    }

    /**
     * Set paisid
     *
     * @param \AppBundle\Entity\Pais $paisid
     *
     * @return Nacionalidad
     */
    public function setPaisid(\AppBundle\Entity\Pais $paisid = null)
    {
        $this->paisid = $paisid;

        return $this;
    }

    /**
     * Get paisid
     *
     * @return \AppBundle\Entity\Pais
     */
    public function getPaisid()
    {
        return $this->paisid;
    }
}

