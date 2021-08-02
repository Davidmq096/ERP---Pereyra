<?php

namespace AppBundle\Entity;

/**
 * CeAvisosplataforma
 */
class CeAvisosplataforma
{
    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \DateTime
     */
    private $hora;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var integer
     */
    private $avisoplataformaid;

    /**
     * @var \AppBundle\Entity\CeAvisosporcaratulaestatus
     */
    private $avisoplataformaestatusid;


    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return CeAvisosplataforma
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeAvisosplataforma
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeAvisosplataforma
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
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return CeAvisosplataforma
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeAvisosplataforma
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
     * Set fechafin
     *
     * @param \DateTime $fechafin
     *
     * @return CeAvisosplataforma
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Get avisoplataformaid
     *
     * @return integer
     */
    public function getAvisoplataformaid()
    {
        return $this->avisoplataformaid;
    }

    /**
     * Set avisoplataformaestatusid
     *
     * @param \AppBundle\Entity\CeAvisosporcaratulaestatus $avisoplataformaestatusid
     *
     * @return CeAvisosplataforma
     */
    public function setAvisoplataformaestatusid(\AppBundle\Entity\CeAvisosporcaratulaestatus $avisoplataformaestatusid = null)
    {
        $this->avisoplataformaestatusid = $avisoplataformaestatusid;

        return $this;
    }

    /**
     * Get avisoplataformaestatusid
     *
     * @return \AppBundle\Entity\CeAvisosporcaratulaestatus
     */
    public function getAvisoplataformaestatusid()
    {
        return $this->avisoplataformaestatusid;
    }
}

