<?php

namespace AppBundle\Entity;

/**
 * CeSolicitudedicionextemporanea
 */
class CeSolicitudedicionextemporanea
{
    /**
     * @var string
     */
    private $motivo;

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
    private $horafin;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var \DateTime
     */
    private $fechaultimocambio;

    /**
     * @var integer
     */
    private $solicitudedicionextemporaneaid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudiosid;

    /**
     * @var \AppBundle\Entity\CeEstatusextemporanea
     */
    private $estatusextemporaneaid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $solicitanteid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioultimocambioid;


    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return CeSolicitudedicionextemporanea
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CeSolicitudedicionextemporanea
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
     * @return CeSolicitudedicionextemporanea
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
     * Set horafin
     *
     * @param \DateTime $horafin
     *
     * @return CeSolicitudedicionextemporanea
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CeSolicitudedicionextemporanea
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
     * Set fechaultimocambio
     *
     * @param \DateTime $fechaultimocambio
     *
     * @return CeSolicitudedicionextemporanea
     */
    public function setFechaultimocambio($fechaultimocambio)
    {
        $this->fechaultimocambio = $fechaultimocambio;

        return $this;
    }

    /**
     * Get fechaultimocambio
     *
     * @return \DateTime
     */
    public function getFechaultimocambio()
    {
        return $this->fechaultimocambio;
    }

    /**
     * Get solicitudedicionextemporaneaid
     *
     * @return integer
     */
    public function getSolicitudedicionextemporaneaid()
    {
        return $this->solicitudedicionextemporaneaid;
    }

    /**
     * Set profesorpormateriaplanestudiosid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid
     *
     * @return CeSolicitudedicionextemporanea
     */
    public function setProfesorpormateriaplanestudiosid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid = null)
    {
        $this->profesorpormateriaplanestudiosid = $profesorpormateriaplanestudiosid;

        return $this;
    }

    /**
     * Get profesorpormateriaplanestudiosid
     *
     * @return \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    public function getProfesorpormateriaplanestudiosid()
    {
        return $this->profesorpormateriaplanestudiosid;
    }

    /**
     * Set estatusextemporaneaid
     *
     * @param \AppBundle\Entity\CeEstatusextemporanea $estatusextemporaneaid
     *
     * @return CeSolicitudedicionextemporanea
     */
    public function setEstatusextemporaneaid(\AppBundle\Entity\CeEstatusextemporanea $estatusextemporaneaid = null)
    {
        $this->estatusextemporaneaid = $estatusextemporaneaid;

        return $this;
    }

    /**
     * Get estatusextemporaneaid
     *
     * @return \AppBundle\Entity\CeEstatusextemporanea
     */
    public function getEstatusextemporaneaid()
    {
        return $this->estatusextemporaneaid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeSolicitudedicionextemporanea
     */
    public function setPeriodoevaluacionid(\AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid = null)
    {
        $this->periodoevaluacionid = $periodoevaluacionid;

        return $this;
    }

    /**
     * Get periodoevaluacionid
     *
     * @return \AppBundle\Entity\CePeriodoevaluacion
     */
    public function getPeriodoevaluacionid()
    {
        return $this->periodoevaluacionid;
    }

    /**
     * Set solicitanteid
     *
     * @param \AppBundle\Entity\Usuario $solicitanteid
     *
     * @return CeSolicitudedicionextemporanea
     */
    public function setSolicitanteid(\AppBundle\Entity\Usuario $solicitanteid = null)
    {
        $this->solicitanteid = $solicitanteid;

        return $this;
    }

    /**
     * Get solicitanteid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getSolicitanteid()
    {
        return $this->solicitanteid;
    }

    /**
     * Set usuarioultimocambioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioultimocambioid
     *
     * @return CeSolicitudedicionextemporanea
     */
    public function setUsuarioultimocambioid(\AppBundle\Entity\Usuario $usuarioultimocambioid = null)
    {
        $this->usuarioultimocambioid = $usuarioultimocambioid;

        return $this;
    }

    /**
     * Get usuarioultimocambioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioultimocambioid()
    {
        return $this->usuarioultimocambioid;
    }
}

