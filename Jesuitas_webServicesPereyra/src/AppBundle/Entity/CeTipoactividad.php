<?php

namespace AppBundle\Entity;

/**
 * CeTipoactividad
 */
class CeTipoactividad
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
     * @var string
     */
    private $descripcionadmin;

    /**
     * @var string
     */
    private $descripcionalumno;

    /**
     * @var string
     */
    private $descripcionpadre;

    /**
     * @var boolean
     */
    private $email;

    /**
     * @var boolean
     */
    private $movil;

    /**
     * @var integer
     */
    private $tipoactividadid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTipoactividad
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
     * @return CeTipoactividad
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
     * Set descripcionadmin
     *
     * @param string $descripcionadmin
     *
     * @return CeTipoactividad
     */
    public function setDescripcionadmin($descripcionadmin)
    {
        $this->descripcionadmin = $descripcionadmin;

        return $this;
    }

    /**
     * Get descripcionadmin
     *
     * @return string
     */
    public function getDescripcionadmin()
    {
        return $this->descripcionadmin;
    }

    /**
     * Set descripcionalumno
     *
     * @param string $descripcionalumno
     *
     * @return CeTipoactividad
     */
    public function setDescripcionalumno($descripcionalumno)
    {
        $this->descripcionalumno = $descripcionalumno;

        return $this;
    }

    /**
     * Get descripcionalumno
     *
     * @return string
     */
    public function getDescripcionalumno()
    {
        return $this->descripcionalumno;
    }

    /**
     * Set descripcionpadre
     *
     * @param string $descripcionpadre
     *
     * @return CeTipoactividad
     */
    public function setDescripcionpadre($descripcionpadre)
    {
        $this->descripcionpadre = $descripcionpadre;

        return $this;
    }

    /**
     * Get descripcionpadre
     *
     * @return string
     */
    public function getDescripcionpadre()
    {
        return $this->descripcionpadre;
    }

    /**
     * Set email
     *
     * @param boolean $email
     *
     * @return CeTipoactividad
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return boolean
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set movil
     *
     * @param boolean $movil
     *
     * @return CeTipoactividad
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return boolean
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Get tipoactividadid
     *
     * @return integer
     */
    public function getTipoactividadid()
    {
        return $this->tipoactividadid;
    }
}

