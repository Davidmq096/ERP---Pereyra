<?php

namespace AppBundle\Entity;

/**
 * RiFormapagoinscripcionyfo
 */
class RiFormapagoinscripcionyfo
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
    private $formapagoinscripcionyfoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return RiFormapagoinscripcionyfo
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
     * @return RiFormapagoinscripcionyfo
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
     * @return RiFormapagoinscripcionyfo
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
     * Get formapagoinscripcionyfoid
     *
     * @return integer
     */
    public function getFormapagoinscripcionyfoid()
    {
        return $this->formapagoinscripcionyfoid;
    }
}

