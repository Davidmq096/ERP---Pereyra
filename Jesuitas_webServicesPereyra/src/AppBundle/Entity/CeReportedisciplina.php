<?php

namespace AppBundle\Entity;

/**
 * CeReportedisciplina
 */
class CeReportedisciplina
{
    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $reportedisciplinaid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudiosid;

    /**
     * @var \AppBundle\Entity\CeTiporeporte
     */
    private $tiporeporteid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;

    /**
     * @var \AppBundle\Entity\CeAreadisciplina
     */
    private $areadisciplinaid;


    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CeReportedisciplina
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeReportedisciplina
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
     * Get reportedisciplinaid
     *
     * @return integer
     */
    public function getReportedisciplinaid()
    {
        return $this->reportedisciplinaid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeReportedisciplina
     */
    public function setAlumnoporcicloid(\AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid = null)
    {
        $this->alumnoporcicloid = $alumnoporcicloid;

        return $this;
    }

    /**
     * Get alumnoporcicloid
     *
     * @return \AppBundle\Entity\CeAlumnoporciclo
     */
    public function getAlumnoporcicloid()
    {
        return $this->alumnoporcicloid;
    }

    /**
     * Set materiaporplanestudiosid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudiosid
     *
     * @return CeReportedisciplina
     */
    public function setMateriaporplanestudiosid(\AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudiosid = null)
    {
        $this->materiaporplanestudiosid = $materiaporplanestudiosid;

        return $this;
    }

    /**
     * Get materiaporplanestudiosid
     *
     * @return \AppBundle\Entity\CeMateriaporplanestudios
     */
    public function getMateriaporplanestudiosid()
    {
        return $this->materiaporplanestudiosid;
    }

    /**
     * Set tiporeporteid
     *
     * @param \AppBundle\Entity\CeTiporeporte $tiporeporteid
     *
     * @return CeReportedisciplina
     */
    public function setTiporeporteid(\AppBundle\Entity\CeTiporeporte $tiporeporteid = null)
    {
        $this->tiporeporteid = $tiporeporteid;

        return $this;
    }

    /**
     * Get tiporeporteid
     *
     * @return \AppBundle\Entity\CeTiporeporte
     */
    public function getTiporeporteid()
    {
        return $this->tiporeporteid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeReportedisciplina
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
     * Set areadisciplinaid
     *
     * @param \AppBundle\Entity\CeAreadisciplina $areadisciplinaid
     *
     * @return CeReportedisciplina
     */
    public function setAreadisciplinaid(\AppBundle\Entity\CeAreadisciplina $areadisciplinaid = null)
    {
        $this->areadisciplinaid = $areadisciplinaid;

        return $this;
    }

    /**
     * Get areadisciplinaid
     *
     * @return \AppBundle\Entity\CeAreadisciplina
     */
    public function getAreadisciplinaid()
    {
        return $this->areadisciplinaid;
    }
}

