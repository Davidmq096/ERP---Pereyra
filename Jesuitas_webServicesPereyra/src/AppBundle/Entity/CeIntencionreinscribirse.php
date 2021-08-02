<?php

namespace AppBundle\Entity;

/**
 * CeIntencionreinscribirse
 */
class CeIntencionreinscribirse
{
    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $intencionreinscribirseid;


    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeIntencionreinscribirse
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeIntencionreinscribirse
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
     * Get intencionreinscribirseid
     *
     * @return integer
     */
    public function getIntencionreinscribirseid()
    {
        return $this->intencionreinscribirseid;
    }
}

