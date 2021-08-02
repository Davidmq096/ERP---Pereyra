<?php

namespace AppBundle\Entity;

/**
 * CeTipoincripcion
 */
class CeTipoincripcion
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
    private $tipoinscripcionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipoincripcion
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
     * @return CeTipoincripcion
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
     * Get tipoinscripcionid
     *
     * @return integer
     */
    public function getTipoinscripcionid()
    {
        return $this->tipoinscripcionid;
    }
}

