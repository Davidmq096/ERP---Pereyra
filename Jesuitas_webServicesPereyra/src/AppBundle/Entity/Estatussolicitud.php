<?php

namespace AppBundle\Entity;

/**
 * Estatussolicitud
 */
class Estatussolicitud
{
    /**
     * @var string
     */
    private $estatus;

    /**
     * @var boolean
     */
    private $dictaminacion;

    /**
     * @var boolean
     */
    private $aceptado;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $estatussolicitudid;


    /**
     * Set estatus
     *
     * @param string $estatus
     *
     * @return Estatussolicitud
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return string
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set dictaminacion
     *
     * @param boolean $dictaminacion
     *
     * @return Estatussolicitud
     */
    public function setDictaminacion($dictaminacion)
    {
        $this->dictaminacion = $dictaminacion;

        return $this;
    }

    /**
     * Get dictaminacion
     *
     * @return boolean
     */
    public function getDictaminacion()
    {
        return $this->dictaminacion;
    }

    /**
     * Set aceptado
     *
     * @param boolean $aceptado
     *
     * @return Estatussolicitud
     */
    public function setAceptado($aceptado)
    {
        $this->aceptado = $aceptado;

        return $this;
    }

    /**
     * Get aceptado
     *
     * @return boolean
     */
    public function getAceptado()
    {
        return $this->aceptado;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Estatussolicitud
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
     * Get estatussolicitudid
     *
     * @return integer
     */
    public function getEstatussolicitudid()
    {
        return $this->estatussolicitudid;
    }
}

