<?php

namespace AppBundle\Entity;

/**
 * CeAreadisciplina
 */
class CeAreadisciplina
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
    private $areadisciplinaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeAreadisciplina
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
     * @return CeAreadisciplina
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
     * Get areadisciplinaid
     *
     * @return integer
     */
    public function getAreadisciplinaid()
    {
        return $this->areadisciplinaid;
    }
}

