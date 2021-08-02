<?php

namespace AppBundle\Entity;

/**
 * CeAcuerdoextraordinario
 */
class CeAcuerdoextraordinario
{
    /**
     * @var integer
     */
    private $intento;

    /**
     * @var string
     */
    private $calificacion;

    /**
     * @var string
     */
    private $calificacionfinal;

    /**
     * @var integer
     */
    private $acuerdoextraordinarioid;

    /**
     * @var \AppBundle\Entity\CeAgendaextraordinario
     */
    private $agendaextraordinarioid;

    /**
     * @var \AppBundle\Entity\CjDocumentoporpagar
     */
    private $documentoporpagarid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;

    /**
     * @var \AppBundle\Entity\CeEstatusextraordinario
     */
    private $estatusextraordinarioid;

    /**
     * @var \AppBundle\Entity\CeExtraordinario
     */
    private $extraordinarioid;

    /**
     * @var \AppBundle\Entity\CePeriodoregularizacion
     */
    private $periodoregularizacionid;

    /**
     * @var \AppBundle\Entity\CeTipoextraordinario
     */
    private $tipoextraordinarioid;


    /**
     * Set intento
     *
     * @param integer $intento
     *
     * @return CeAcuerdoextraordinario
     */
    public function setIntento($intento)
    {
        $this->intento = $intento;

        return $this;
    }

    /**
     * Get intento
     *
     * @return integer
     */
    public function getIntento()
    {
        return $this->intento;
    }

    /**
     * Set calificacion
     *
     * @param string $calificacion
     *
     * @return CeAcuerdoextraordinario
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return string
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Set calificacionfinal
     *
     * @param string $calificacionfinal
     *
     * @return CeAcuerdoextraordinario
     */
    public function setCalificacionfinal($calificacionfinal)
    {
        $this->calificacionfinal = $calificacionfinal;

        return $this;
    }

    /**
     * Get calificacionfinal
     *
     * @return string
     */
    public function getCalificacionfinal()
    {
        return $this->calificacionfinal;
    }

    /**
     * Get acuerdoextraordinarioid
     *
     * @return integer
     */
    public function getAcuerdoextraordinarioid()
    {
        return $this->acuerdoextraordinarioid;
    }

    /**
     * Set agendaextraordinarioid
     *
     * @param \AppBundle\Entity\CeAgendaextraordinario $agendaextraordinarioid
     *
     * @return CeAcuerdoextraordinario
     */
    public function setAgendaextraordinarioid(\AppBundle\Entity\CeAgendaextraordinario $agendaextraordinarioid = null)
    {
        $this->agendaextraordinarioid = $agendaextraordinarioid;

        return $this;
    }

    /**
     * Get agendaextraordinarioid
     *
     * @return \AppBundle\Entity\CeAgendaextraordinario
     */
    public function getAgendaextraordinarioid()
    {
        return $this->agendaextraordinarioid;
    }

    /**
     * Set documentoporpagarid
     *
     * @param \AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid
     *
     * @return CeAcuerdoextraordinario
     */
    public function setDocumentoporpagarid(\AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid = null)
    {
        $this->documentoporpagarid = $documentoporpagarid;

        return $this;
    }

    /**
     * Get documentoporpagarid
     *
     * @return \AppBundle\Entity\CjDocumentoporpagar
     */
    public function getDocumentoporpagarid()
    {
        return $this->documentoporpagarid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeAcuerdoextraordinario
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }

    /**
     * Set estatusextraordinarioid
     *
     * @param \AppBundle\Entity\CeEstatusextraordinario $estatusextraordinarioid
     *
     * @return CeAcuerdoextraordinario
     */
    public function setEstatusextraordinarioid(\AppBundle\Entity\CeEstatusextraordinario $estatusextraordinarioid = null)
    {
        $this->estatusextraordinarioid = $estatusextraordinarioid;

        return $this;
    }

    /**
     * Get estatusextraordinarioid
     *
     * @return \AppBundle\Entity\CeEstatusextraordinario
     */
    public function getEstatusextraordinarioid()
    {
        return $this->estatusextraordinarioid;
    }

    /**
     * Set extraordinarioid
     *
     * @param \AppBundle\Entity\CeExtraordinario $extraordinarioid
     *
     * @return CeAcuerdoextraordinario
     */
    public function setExtraordinarioid(\AppBundle\Entity\CeExtraordinario $extraordinarioid = null)
    {
        $this->extraordinarioid = $extraordinarioid;

        return $this;
    }

    /**
     * Get extraordinarioid
     *
     * @return \AppBundle\Entity\CeExtraordinario
     */
    public function getExtraordinarioid()
    {
        return $this->extraordinarioid;
    }

    /**
     * Set periodoregularizacionid
     *
     * @param \AppBundle\Entity\CePeriodoregularizacion $periodoregularizacionid
     *
     * @return CeAcuerdoextraordinario
     */
    public function setPeriodoregularizacionid(\AppBundle\Entity\CePeriodoregularizacion $periodoregularizacionid = null)
    {
        $this->periodoregularizacionid = $periodoregularizacionid;

        return $this;
    }

    /**
     * Get periodoregularizacionid
     *
     * @return \AppBundle\Entity\CePeriodoregularizacion
     */
    public function getPeriodoregularizacionid()
    {
        return $this->periodoregularizacionid;
    }

    /**
     * Set tipoextraordinarioid
     *
     * @param \AppBundle\Entity\CeTipoextraordinario $tipoextraordinarioid
     *
     * @return CeAcuerdoextraordinario
     */
    public function setTipoextraordinarioid(\AppBundle\Entity\CeTipoextraordinario $tipoextraordinarioid = null)
    {
        $this->tipoextraordinarioid = $tipoextraordinarioid;

        return $this;
    }

    /**
     * Get tipoextraordinarioid
     *
     * @return \AppBundle\Entity\CeTipoextraordinario
     */
    public function getTipoextraordinarioid()
    {
        return $this->tipoextraordinarioid;
    }
}

