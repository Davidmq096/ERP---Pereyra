<?php

namespace AppBundle\Entity;

/**
 * AdOrigencampo
 */
class AdOrigencampo
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $activo;

    /**
     * @var integer
     */
    private $origencampoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdOrigencampo
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
     * @return AdOrigencampo
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
     * Get origencampoid
     *
     * @return integer
     */
    public function getOrigencampoid()
    {
        return $this->origencampoid;
    }
}

