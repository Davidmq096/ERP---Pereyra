<?php

namespace AppBundle\Entity;

/**
 * BrGradodificultad
 */
class BrGradodificultad
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $gradodificultadid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrGradodificultad
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
     * Set alias
     *
     * @param string $alias
     *
     * @return BrGradodificultad
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BrGradodificultad
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
     * Get gradodificultadid
     *
     * @return integer
     */
    public function getGradodificultadid()
    {
        return $this->gradodificultadid;
    }
}

