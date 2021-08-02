<?php

namespace AppBundle\Entity;

/**
 * Generacion
 */
class Generacion
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $generacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Generacion
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
     * Get generacionid
     *
     * @return integer
     */
    public function getGeneracionid()
    {
        return $this->generacionid;
    }
}

