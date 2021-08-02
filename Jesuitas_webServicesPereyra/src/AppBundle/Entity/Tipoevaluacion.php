<?php

namespace AppBundle\Entity;

/**
 * Tipoevaluacion
 */
class Tipoevaluacion
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
     * @var string
     */
    private $color;

    /**
     * @var boolean
     */
    private $mostrar = '1';

    /**
     * @var integer
     */
    private $tipoevaluacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Tipoevaluacion
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
     * @return Tipoevaluacion
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
     * Set color
     *
     * @param string $color
     *
     * @return Tipoevaluacion
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set mostrar
     *
     * @param boolean $mostrar
     *
     * @return Tipoevaluacion
     */
    public function setMostrar($mostrar)
    {
        $this->mostrar = $mostrar;

        return $this;
    }

    /**
     * Get mostrar
     *
     * @return boolean
     */
    public function getMostrar()
    {
        return $this->mostrar;
    }

    /**
     * Get tipoevaluacionid
     *
     * @return integer
     */
    public function getTipoevaluacionid()
    {
        return $this->tipoevaluacionid;
    }
}

