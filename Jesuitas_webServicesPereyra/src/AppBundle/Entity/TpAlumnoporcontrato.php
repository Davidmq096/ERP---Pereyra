<?php

namespace AppBundle\Entity;

/**
 * TpAlumnoporcontrato
 */
class TpAlumnoporcontrato
{
    /**
     * @var string
     */
    private $motivo;

    /**
     * @var \DateTime
     */
    private $suspenderinicio;

    /**
     * @var \DateTime
     */
    private $suspenderfin;

    /**
     * @var \DateTime
     */
    private $fechacancelacion;

    /**
     * @var integer
     */
    private $alumnoporcontratoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\TpContrato
     */
    private $contratoid;

    /**
     * @var \AppBundle\Entity\TpContratoestatus
     */
    private $contratoestatusid;


    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return TpAlumnoporcontrato
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
     * Set suspenderinicio
     *
     * @param \DateTime $suspenderinicio
     *
     * @return TpAlumnoporcontrato
     */
    public function setSuspenderinicio($suspenderinicio)
    {
        $this->suspenderinicio = $suspenderinicio;

        return $this;
    }

    /**
     * Get suspenderinicio
     *
     * @return \DateTime
     */
    public function getSuspenderinicio()
    {
        return $this->suspenderinicio;
    }

    /**
     * Set suspenderfin
     *
     * @param \DateTime $suspenderfin
     *
     * @return TpAlumnoporcontrato
     */
    public function setSuspenderfin($suspenderfin)
    {
        $this->suspenderfin = $suspenderfin;

        return $this;
    }

    /**
     * Get suspenderfin
     *
     * @return \DateTime
     */
    public function getSuspenderfin()
    {
        return $this->suspenderfin;
    }

    /**
     * Set fechacancelacion
     *
     * @param \DateTime $fechacancelacion
     *
     * @return TpAlumnoporcontrato
     */
    public function setFechacancelacion($fechacancelacion)
    {
        $this->fechacancelacion = $fechacancelacion;

        return $this;
    }

    /**
     * Get fechacancelacion
     *
     * @return \DateTime
     */
    public function getFechacancelacion()
    {
        return $this->fechacancelacion;
    }

    /**
     * Get alumnoporcontratoid
     *
     * @return integer
     */
    public function getAlumnoporcontratoid()
    {
        return $this->alumnoporcontratoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return TpAlumnoporcontrato
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set contratoid
     *
     * @param \AppBundle\Entity\TpContrato $contratoid
     *
     * @return TpAlumnoporcontrato
     */
    public function setContratoid(\AppBundle\Entity\TpContrato $contratoid = null)
    {
        $this->contratoid = $contratoid;

        return $this;
    }

    /**
     * Get contratoid
     *
     * @return \AppBundle\Entity\TpContrato
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }

    /**
     * Set contratoestatusid
     *
     * @param \AppBundle\Entity\TpContratoestatus $contratoestatusid
     *
     * @return TpAlumnoporcontrato
     */
    public function setContratoestatusid(\AppBundle\Entity\TpContratoestatus $contratoestatusid = null)
    {
        $this->contratoestatusid = $contratoestatusid;

        return $this;
    }

    /**
     * Get contratoestatusid
     *
     * @return \AppBundle\Entity\TpContratoestatus
     */
    public function getContratoestatusid()
    {
        return $this->contratoestatusid;
    }
}

