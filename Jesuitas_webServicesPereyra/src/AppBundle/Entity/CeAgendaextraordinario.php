<?php

namespace AppBundle\Entity;

/**
 * CeAgendaextraordinario
 */
class CeAgendaextraordinario
{
    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var string
     */
    private $horainicio;

    /**
     * @var \DateTime
     */
    private $horafin;

    /**
     * @var integer
     */
    private $cupo;

    /**
     * @var \DateTime
     */
    private $fecharevision;

    /**
     * @var \DateTime
     */
    private $horainiciorevision;

    /**
     * @var \DateTime
     */
    private $horafinrevision;

    /**
     * @var string
     */
    private $comentarios;

    /**
     * @var integer
     */
    private $agendaextraordinarioid;

    /**
     * @var \AppBundle\Entity\CeEstatusagendaextraordinario
     */
    private $estatusagendaextraordinarioid;

    /**
     * @var \AppBundle\Entity\CeTipoextraordinario
     */
    private $tipoextraordinarioid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $profesorid;

    /**
     * @var \AppBundle\Entity\Lugar
     */
    private $lugarid;

    /**
     * @var \AppBundle\Entity\Lugar
     */
    private $lugarrevisionid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;

    /**
     * @var \AppBundle\Entity\CePeriodoregularizacion
     */
    private $periodoregularizacionid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CeAgendaextraordinario
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
     * @return CeAgendaextraordinario
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
     * @param string $horainicio
     *
     * @return CeAgendaextraordinario
     */
    public function setHorainicio($horainicio)
    {
        $this->horainicio = $horainicio;

        return $this;
    }

    /**
     * Get horainicio
     *
     * @return string
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
     * @return CeAgendaextraordinario
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
     * Set cupo
     *
     * @param integer $cupo
     *
     * @return CeAgendaextraordinario
     */
    public function setCupo($cupo)
    {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get cupo
     *
     * @return integer
     */
    public function getCupo()
    {
        return $this->cupo;
    }

    /**
     * Set fecharevision
     *
     * @param \DateTime $fecharevision
     *
     * @return CeAgendaextraordinario
     */
    public function setFecharevision($fecharevision)
    {
        $this->fecharevision = $fecharevision;

        return $this;
    }

    /**
     * Get fecharevision
     *
     * @return \DateTime
     */
    public function getFecharevision()
    {
        return $this->fecharevision;
    }

    /**
     * Set horainiciorevision
     *
     * @param \DateTime $horainiciorevision
     *
     * @return CeAgendaextraordinario
     */
    public function setHorainiciorevision($horainiciorevision)
    {
        $this->horainiciorevision = $horainiciorevision;

        return $this;
    }

    /**
     * Get horainiciorevision
     *
     * @return \DateTime
     */
    public function getHorainiciorevision()
    {
        return $this->horainiciorevision;
    }

    /**
     * Set horafinrevision
     *
     * @param \DateTime $horafinrevision
     *
     * @return CeAgendaextraordinario
     */
    public function setHorafinrevision($horafinrevision)
    {
        $this->horafinrevision = $horafinrevision;

        return $this;
    }

    /**
     * Get horafinrevision
     *
     * @return \DateTime
     */
    public function getHorafinrevision()
    {
        return $this->horafinrevision;
    }

    /**
     * Set comentarios
     *
     * @param string $comentarios
     *
     * @return CeAgendaextraordinario
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios
     *
     * @return string
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Get agendaextraordinarioid
     *
     * @return integer
     */
    public function getAgendaextraordinarioid()
    {
        return $this->agendaextraordinarioid;
    }

    /**
     * Set estatusagendaextraordinarioid
     *
     * @param \AppBundle\Entity\CeEstatusagendaextraordinario $estatusagendaextraordinarioid
     *
     * @return CeAgendaextraordinario
     */
    public function setEstatusagendaextraordinarioid(\AppBundle\Entity\CeEstatusagendaextraordinario $estatusagendaextraordinarioid = null)
    {
        $this->estatusagendaextraordinarioid = $estatusagendaextraordinarioid;

        return $this;
    }

    /**
     * Get estatusagendaextraordinarioid
     *
     * @return \AppBundle\Entity\CeEstatusagendaextraordinario
     */
    public function getEstatusagendaextraordinarioid()
    {
        return $this->estatusagendaextraordinarioid;
    }

    /**
     * Set tipoextraordinarioid
     *
     * @param \AppBundle\Entity\CeTipoextraordinario $tipoextraordinarioid
     *
     * @return CeAgendaextraordinario
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

    /**
     * Set profesorid
     *
     * @param \AppBundle\Entity\CeProfesor $profesorid
     *
     * @return CeAgendaextraordinario
     */
    public function setProfesorid(\AppBundle\Entity\CeProfesor $profesorid = null)
    {
        $this->profesorid = $profesorid;

        return $this;
    }

    /**
     * Get profesorid
     *
     * @return \AppBundle\Entity\CeProfesor
     */
    public function getProfesorid()
    {
        return $this->profesorid;
    }

    /**
     * Set lugarid
     *
     * @param \AppBundle\Entity\Lugar $lugarid
     *
     * @return CeAgendaextraordinario
     */
    public function setLugarid(\AppBundle\Entity\Lugar $lugarid = null)
    {
        $this->lugarid = $lugarid;

        return $this;
    }

    /**
     * Get lugarid
     *
     * @return \AppBundle\Entity\Lugar
     */
    public function getLugarid()
    {
        return $this->lugarid;
    }

    /**
     * Set lugarrevisionid
     *
     * @param \AppBundle\Entity\Lugar $lugarrevisionid
     *
     * @return CeAgendaextraordinario
     */
    public function setLugarrevisionid(\AppBundle\Entity\Lugar $lugarrevisionid = null)
    {
        $this->lugarrevisionid = $lugarrevisionid;

        return $this;
    }

    /**
     * Get lugarrevisionid
     *
     * @return \AppBundle\Entity\Lugar
     */
    public function getLugarrevisionid()
    {
        return $this->lugarrevisionid;
    }

    /**
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeAgendaextraordinario
     */
    public function setMateriaporplanestudioid(\AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid = null)
    {
        $this->materiaporplanestudioid = $materiaporplanestudioid;

        return $this;
    }

    /**
     * Get materiaporplanestudioid
     *
     * @return \AppBundle\Entity\CeMateriaporplanestudios
     */
    public function getMateriaporplanestudioid()
    {
        return $this->materiaporplanestudioid;
    }

    /**
     * Set periodoregularizacionid
     *
     * @param \AppBundle\Entity\CePeriodoregularizacion $periodoregularizacionid
     *
     * @return CeAgendaextraordinario
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
}

