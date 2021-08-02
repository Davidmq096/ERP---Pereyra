<?php

namespace AppBundle\Entity;

/**
 * AdMetodoasignacioncita
 */
class AdMetodoasignacioncita
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $activo = '0';

    /**
     * @var integer
     */
    private $metodoasignacioncitaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdMetodoasignacioncita
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
     * @return AdMetodoasignacioncita
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
     * Get metodoasignacioncitaid
     *
     * @return integer
     */
    public function getMetodoasignacioncitaid()
    {
        return $this->metodoasignacioncitaid;
    }
}

