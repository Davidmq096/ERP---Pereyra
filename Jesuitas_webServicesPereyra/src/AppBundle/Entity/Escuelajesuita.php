<?php

namespace AppBundle\Entity;

/**
 * Escuelajesuita
 */
class Escuelajesuita
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
     * @var integer
     */
    private $escuelajesuitaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Escuelajesuita
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
     * @return Escuelajesuita
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
     * Get escuelajesuitaid
     *
     * @return integer
     */
    public function getEscuelajesuitaid()
    {
        return $this->escuelajesuitaid;
    }
}

