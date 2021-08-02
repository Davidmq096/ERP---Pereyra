<?php

namespace AppBundle\Entity;

/**
 * CeTallerfrecuenciapago
 */
class CeTallerfrecuenciapago
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
    private $tallerfrecuenciapagoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTallerfrecuenciapago
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
     * @return CeTallerfrecuenciapago
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
     * Get tallerfrecuenciapagoid
     *
     * @return integer
     */
    public function getTallerfrecuenciapagoid()
    {
        return $this->tallerfrecuenciapagoid;
    }
}

