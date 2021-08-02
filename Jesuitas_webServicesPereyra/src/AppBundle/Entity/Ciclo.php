<?php

namespace AppBundle\Entity;

/**
 * Ciclo
 */
class Ciclo
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $actual = '0';

    /**
     * @var boolean
     */
    private $activo = '0';

    /**
     * @var boolean
     */
    private $siguiente = '0';

    /**
     * @var integer
     */
    private $cicloid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Ciclo
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
     * Set actual
     *
     * @param boolean $actual
     *
     * @return Ciclo
     */
    public function setActual($actual)
    {
        $this->actual = $actual;

        return $this;
    }

    /**
     * Get actual
     *
     * @return boolean
     */
    public function getActual()
    {
        return $this->actual;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Ciclo
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
     * Set siguiente
     *
     * @param boolean $siguiente
     *
     * @return Ciclo
     */
    public function setSiguiente($siguiente)
    {
        $this->siguiente = $siguiente;

        return $this;
    }

    /**
     * Get siguiente
     *
     * @return boolean
     */
    public function getSiguiente()
    {
        return $this->siguiente;
    }

    /**
     * Get cicloid
     *
     * @return integer
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }
}

