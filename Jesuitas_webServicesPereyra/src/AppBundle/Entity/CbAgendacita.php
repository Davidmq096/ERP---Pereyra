<?php

namespace AppBundle\Entity;

/**
 * CbAgendacita
 */
class CbAgendacita
{
    /**
     * @var \DateTime
     */
    private $fechainicio;

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
    private $asistencia;

    /**
     * @var boolean
     */
    private $enviocorreo;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $asistio;

    /**
     * @var integer
     */
    private $agendacitaid;

    /**
     * @var \AppBundle\Entity\CeClavefamiliar
     */
    private $clavefamiliarid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CbAgendacita
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
     * Set horainicio
     *
     * @param \DateTime $horainicio
     *
     * @return CbAgendacita
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
     * @return CbAgendacita
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
     * Set asistencia
     *
     * @param boolean $asistencia
     *
     * @return CbAgendacita
     */
    public function setAsistencia($asistencia)
    {
        $this->asistencia = $asistencia;

        return $this;
    }

    /**
     * Get asistencia
     *
     * @return boolean
     */
    public function getAsistencia()
    {
        return $this->asistencia;
    }

    /**
     * Set enviocorreo
     *
     * @param boolean $enviocorreo
     *
     * @return CbAgendacita
     */
    public function setEnviocorreo($enviocorreo)
    {
        $this->enviocorreo = $enviocorreo;

        return $this;
    }

    /**
     * Get enviocorreo
     *
     * @return boolean
     */
    public function getEnviocorreo()
    {
        return $this->enviocorreo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CbAgendacita
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
     * Set asistio
     *
     * @param string $asistio
     *
     * @return CbAgendacita
     */
    public function setAsistio($asistio)
    {
        $this->asistio = $asistio;

        return $this;
    }

    /**
     * Get asistio
     *
     * @return string
     */
    public function getAsistio()
    {
        return $this->asistio;
    }

    /**
     * Get agendacitaid
     *
     * @return integer
     */
    public function getAgendacitaid()
    {
        return $this->agendacitaid;
    }

    /**
     * Set clavefamiliarid
     *
     * @param \AppBundle\Entity\CeClavefamiliar $clavefamiliarid
     *
     * @return CbAgendacita
     */
    public function setClavefamiliarid(\AppBundle\Entity\CeClavefamiliar $clavefamiliarid = null)
    {
        $this->clavefamiliarid = $clavefamiliarid;

        return $this;
    }

    /**
     * Get clavefamiliarid
     *
     * @return \AppBundle\Entity\CeClavefamiliar
     */
    public function getClavefamiliarid()
    {
        return $this->clavefamiliarid;
    }
}

