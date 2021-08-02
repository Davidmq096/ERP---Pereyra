<?php

namespace AppBundle\Entity;

/**
 * RiFormapagocolegiaturaanticipada
 */
class RiFormapagocolegiaturaanticipada
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
    private $formapagocolegiaturaanticipadaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return RiFormapagocolegiaturaanticipada
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
     * @return RiFormapagocolegiaturaanticipada
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
     * @return RiFormapagocolegiaturaanticipada
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
     * Get formapagocolegiaturaanticipadaid
     *
     * @return integer
     */
    public function getFormapagocolegiaturaanticipadaid()
    {
        return $this->formapagocolegiaturaanticipadaid;
    }
}

