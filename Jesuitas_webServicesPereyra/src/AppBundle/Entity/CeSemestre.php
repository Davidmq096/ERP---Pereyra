<?php

namespace AppBundle\Entity;

/**
 * CeSemestre
 */
class CeSemestre
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
    private $semestreid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeSemestre
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
     * @return CeSemestre
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
     * Get semestreid
     *
     * @return integer
     */
    public function getSemestreid()
    {
        return $this->semestreid;
    }
}

