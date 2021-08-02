<?php

namespace AppBundle\Entity;

/**
 * Perfil
 */
class Perfil
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $tiemposesion;

    /**
     * @var integer
     */
    private $tiempoinactividad;

    /**
     * @var boolean
     */
    private $sesionessimultaneas;

    /**
     * @var integer
     */
    private $perfilid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Perfil
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
     * @return Perfil
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
     * Set tiemposesion
     *
     * @param integer $tiemposesion
     *
     * @return Perfil
     */
    public function setTiemposesion($tiemposesion)
    {
        $this->tiemposesion = $tiemposesion;

        return $this;
    }

    /**
     * Get tiemposesion
     *
     * @return integer
     */
    public function getTiemposesion()
    {
        return $this->tiemposesion;
    }

    /**
     * Set tiempoinactividad
     *
     * @param integer $tiempoinactividad
     *
     * @return Perfil
     */
    public function setTiempoinactividad($tiempoinactividad)
    {
        $this->tiempoinactividad = $tiempoinactividad;

        return $this;
    }

    /**
     * Get tiempoinactividad
     *
     * @return integer
     */
    public function getTiempoinactividad()
    {
        return $this->tiempoinactividad;
    }

    /**
     * Set sesionessimultaneas
     *
     * @param boolean $sesionessimultaneas
     *
     * @return Perfil
     */
    public function setSesionessimultaneas($sesionessimultaneas)
    {
        $this->sesionessimultaneas = $sesionessimultaneas;

        return $this;
    }

    /**
     * Get sesionessimultaneas
     *
     * @return boolean
     */
    public function getSesionessimultaneas()
    {
        return $this->sesionessimultaneas;
    }

    /**
     * Get perfilid
     *
     * @return integer
     */
    public function getPerfilid()
    {
        return $this->perfilid;
    }
}

