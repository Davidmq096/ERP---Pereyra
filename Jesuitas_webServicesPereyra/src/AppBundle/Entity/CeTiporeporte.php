<?php

namespace AppBundle\Entity;

/**
 * CeTiporeporte
 */
class CeTiporeporte
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $gravedad;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $tiporeporteid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTiporeporte
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
     * Set gravedad
     *
     * @param integer $gravedad
     *
     * @return CeTiporeporte
     */
    public function setGravedad($gravedad)
    {
        $this->gravedad = $gravedad;

        return $this;
    }

    /**
     * Get gravedad
     *
     * @return integer
     */
    public function getGravedad()
    {
        return $this->gravedad;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeTiporeporte
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
     * Get tiporeporteid
     *
     * @return integer
     */
    public function getTiporeporteid()
    {
        return $this->tiporeporteid;
    }
}

