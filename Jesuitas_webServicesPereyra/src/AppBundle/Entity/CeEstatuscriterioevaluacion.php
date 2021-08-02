<?php

namespace AppBundle\Entity;

/**
 * CeEstatuscriterioevaluacion
 */
class CeEstatuscriterioevaluacion
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
    private $estatuscriterioevaluacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeEstatuscriterioevaluacion
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
     * @return CeEstatuscriterioevaluacion
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
     * Get estatuscriterioevaluacionid
     *
     * @return integer
     */
    public function getEstatuscriterioevaluacionid()
    {
        return $this->estatuscriterioevaluacionid;
    }
}

