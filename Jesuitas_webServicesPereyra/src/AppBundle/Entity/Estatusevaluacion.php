<?php

namespace AppBundle\Entity;

/**
 * Estatusevaluacion
 */
class Estatusevaluacion
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
    private $estatusevaluacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Estatusevaluacion
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
     * @return Estatusevaluacion
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
     * Get estatusevaluacionid
     *
     * @return integer
     */
    public function getEstatusevaluacionid()
    {
        return $this->estatusevaluacionid;
    }
}

