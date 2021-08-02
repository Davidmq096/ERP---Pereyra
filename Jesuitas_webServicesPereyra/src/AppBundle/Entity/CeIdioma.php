<?php

namespace AppBundle\Entity;

/**
 * CeIdioma
 */
class CeIdioma
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
    private $idiomaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeIdioma
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
     * @return CeIdioma
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
     * Get idiomaid
     *
     * @return integer
     */
    public function getIdiomaid()
    {
        return $this->idiomaid;
    }
}

