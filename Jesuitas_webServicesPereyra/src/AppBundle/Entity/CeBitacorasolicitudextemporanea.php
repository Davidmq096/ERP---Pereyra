<?php

namespace AppBundle\Entity;

/**
 * CeBitacorasolicitudextemporanea
 */
class CeBitacorasolicitudextemporanea
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $estatus;

    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $bitacorasolicitudextemporaneaid;

    /**
     * @var \AppBundle\Entity\CeSolicitudedicionextemporanea
     */
    private $solicitudedicionextemporaneaid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeBitacorasolicitudextemporanea
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set estatus
     *
     * @param string $estatus
     *
     * @return CeBitacorasolicitudextemporanea
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
     * Set usuario
     *
     * @param string $usuario
     *
     * @return CeBitacorasolicitudextemporanea
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CeBitacorasolicitudextemporanea
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Get bitacorasolicitudextemporaneaid
     *
     * @return integer
     */
    public function getBitacorasolicitudextemporaneaid()
    {
        return $this->bitacorasolicitudextemporaneaid;
    }

    /**
     * Set solicitudedicionextemporaneaid
     *
     * @param \AppBundle\Entity\CeSolicitudedicionextemporanea $solicitudedicionextemporaneaid
     *
     * @return CeBitacorasolicitudextemporanea
     */
    public function setSolicitudedicionextemporaneaid(\AppBundle\Entity\CeSolicitudedicionextemporanea $solicitudedicionextemporaneaid = null)
    {
        $this->solicitudedicionextemporaneaid = $solicitudedicionextemporaneaid;

        return $this;
    }

    /**
     * Get solicitudedicionextemporaneaid
     *
     * @return \AppBundle\Entity\CeSolicitudedicionextemporanea
     */
    public function getSolicitudedicionextemporaneaid()
    {
        return $this->solicitudedicionextemporaneaid;
    }
}

