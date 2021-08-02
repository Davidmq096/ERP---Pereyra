<?php

namespace AppBundle\Entity;

/**
 * Ocupacion
 */
class Ocupacion
{
    /**
     * @var string
     */
    private $clave;

    /**
     * @var string
     */
    private $clasificacion;

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
    private $ocupacionid;


    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return Ocupacion
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set clasificacion
     *
     * @param string $clasificacion
     *
     * @return Ocupacion
     */
    public function setClasificacion($clasificacion)
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    /**
     * Get clasificacion
     *
     * @return string
     */
    public function getClasificacion()
    {
        return $this->clasificacion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Ocupacion
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
     * @return Ocupacion
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
     * Get ocupacionid
     *
     * @return integer
     */
    public function getOcupacionid()
    {
        return $this->ocupacionid;
    }
}

