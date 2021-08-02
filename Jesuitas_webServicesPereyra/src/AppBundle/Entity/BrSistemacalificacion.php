<?php

namespace AppBundle\Entity;

/**
 * BrSistemacalificacion
 */
class BrSistemacalificacion
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $inicio;

    /**
     * @var integer
     */
    private $fin;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $sistemacalificacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BrSistemacalificacion
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
     * Set inicio
     *
     * @param integer $inicio
     *
     * @return BrSistemacalificacion
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return integer
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set fin
     *
     * @param integer $fin
     *
     * @return BrSistemacalificacion
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return integer
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BrSistemacalificacion
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
     * Get sistemacalificacionid
     *
     * @return integer
     */
    public function getSistemacalificacionid()
    {
        return $this->sistemacalificacionid;
    }
}

