<?php

namespace AppBundle\Entity;

/**
 * BrSubtema
 */
class BrSubtema
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
    private $subtemaid;

    /**
     * @var \AppBundle\Entity\BrTema
     */
    private $temaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrSubtema
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
     * @return BrSubtema
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
     * Get subtemaid
     *
     * @return integer
     */
    public function getSubtemaid()
    {
        return $this->subtemaid;
    }

    /**
     * Set temaid
     *
     * @param \AppBundle\Entity\BrTema $temaid
     *
     * @return BrSubtema
     */
    public function setTemaid(\AppBundle\Entity\BrTema $temaid = null)
    {
        $this->temaid = $temaid;

        return $this;
    }

    /**
     * Get temaid
     *
     * @return \AppBundle\Entity\BrTema
     */
    public function getTemaid()
    {
        return $this->temaid;
    }
}

