<?php

namespace AppBundle\Entity;

/**
 * RiTipopagocolegiatura
 */
class RiTipopagocolegiatura
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $tipopagocolegiaturaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return RiTipopagocolegiatura
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return RiTipopagocolegiatura
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return RiTipopagocolegiatura
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
     * Get tipopagocolegiaturaid
     *
     * @return integer
     */
    public function getTipopagocolegiaturaid()
    {
        return $this->tipopagocolegiaturaid;
    }
}

