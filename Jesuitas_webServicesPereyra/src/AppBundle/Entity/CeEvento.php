<?php

namespace AppBundle\Entity;

/**
 * CeEvento
 */
class CeEvento
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var \DateTime
     */
    private $horainicio;

    /**
     * @var \DateTime
     */
    private $horafin;

    /**
     * @var boolean
     */
    private $enviopush;

    /**
     * @var \DateTime
     */
    private $fechaenvio;

    /**
     * @var \DateTime
     */
    private $horaenvio;

    /**
     * @var boolean
     */
    private $enviado;

    /**
     * @var integer
     */
    private $eventoid;

    /**
     * @var \AppBundle\Entity\CeTipoevento
     */
    private $tipoeventoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeEvento
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeEvento
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
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CeEvento
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     *
     * @return CeEvento
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
     * Set horainicio
     *
     * @param \DateTime $horainicio
     *
     * @return CeEvento
     */
    public function setHorainicio($horainicio)
    {
        $this->horainicio = $horainicio;

        return $this;
    }

    /**
     * Get horainicio
     *
     * @return \DateTime
     */
    public function getHorainicio()
    {
        return $this->horainicio;
    }

    /**
     * Set horafin
     *
     * @param \DateTime $horafin
     *
     * @return CeEvento
     */
    public function setHorafin($horafin)
    {
        $this->horafin = $horafin;

        return $this;
    }

    /**
     * Get horafin
     *
     * @return \DateTime
     */
    public function getHorafin()
    {
        return $this->horafin;
    }

    /**
     * Set enviopush
     *
     * @param boolean $enviopush
     *
     * @return CeEvento
     */
    public function setEnviopush($enviopush)
    {
        $this->enviopush = $enviopush;

        return $this;
    }

    /**
     * Get enviopush
     *
     * @return boolean
     */
    public function getEnviopush()
    {
        return $this->enviopush;
    }

    /**
     * Set fechaenvio
     *
     * @param \DateTime $fechaenvio
     *
     * @return CeEvento
     */
    public function setFechaenvio($fechaenvio)
    {
        $this->fechaenvio = $fechaenvio;

        return $this;
    }

    /**
     * Get fechaenvio
     *
     * @return \DateTime
     */
    public function getFechaenvio()
    {
        return $this->fechaenvio;
    }

    /**
     * Set horaenvio
     *
     * @param \DateTime $horaenvio
     *
     * @return CeEvento
     */
    public function setHoraenvio($horaenvio)
    {
        $this->horaenvio = $horaenvio;

        return $this;
    }

    /**
     * Get horaenvio
     *
     * @return \DateTime
     */
    public function getHoraenvio()
    {
        return $this->horaenvio;
    }

    /**
     * Set enviado
     *
     * @param boolean $enviado
     *
     * @return CeEvento
     */
    public function setEnviado($enviado)
    {
        $this->enviado = $enviado;

        return $this;
    }

    /**
     * Get enviado
     *
     * @return boolean
     */
    public function getEnviado()
    {
        return $this->enviado;
    }

    /**
     * Get eventoid
     *
     * @return integer
     */
    public function getEventoid()
    {
        return $this->eventoid;
    }

    /**
     * Set tipoeventoid
     *
     * @param \AppBundle\Entity\CeTipoevento $tipoeventoid
     *
     * @return CeEvento
     */
    public function setTipoeventoid(\AppBundle\Entity\CeTipoevento $tipoeventoid = null)
    {
        $this->tipoeventoid = $tipoeventoid;

        return $this;
    }

    /**
     * Get tipoeventoid
     *
     * @return \AppBundle\Entity\CeTipoevento
     */
    public function getTipoeventoid()
    {
        return $this->tipoeventoid;
    }
}

