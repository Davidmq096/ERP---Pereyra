<?php

namespace AppBundle\Entity;

/**
 * CmTiponotificacion
 */
class CmTiponotificacion
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
    private $tiponotificacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CmTiponotificacion
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
     * @return CmTiponotificacion
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
     * Get tiponotificacionid
     *
     * @return integer
     */
    public function getTiponotificacionid()
    {
        return $this->tiponotificacionid;
    }
}

