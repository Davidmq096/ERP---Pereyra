<?php

namespace AppBundle\Entity;

/**
 * LuContrato
 */
class LuContrato
{
    /**
     * @var string
     */
    private $motivocancelacion;

    /**
     * @var \DateTime
     */
    private $fechaalta;

    /**
     * @var \DateTime
     */
    private $fechabaja;

    /**
     * @var integer
     */
    private $contratoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\LuTipo
     */
    private $tipoid;

    /**
     * @var \AppBundle\Entity\LuContratoestatus
     */
    private $contratoestatusid;


    /**
     * Set motivocancelacion
     *
     * @param string $motivocancelacion
     *
     * @return LuContrato
     */
    public function setMotivocancelacion($motivocancelacion)
    {
        $this->motivocancelacion = $motivocancelacion;

        return $this;
    }

    /**
     * Get motivocancelacion
     *
     * @return string
     */
    public function getMotivocancelacion()
    {
        return $this->motivocancelacion;
    }

    /**
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     *
     * @return LuContrato
     */
    public function setFechaalta($fechaalta)
    {
        $this->fechaalta = $fechaalta;

        return $this;
    }

    /**
     * Get fechaalta
     *
     * @return \DateTime
     */
    public function getFechaalta()
    {
        return $this->fechaalta;
    }

    /**
     * Set fechabaja
     *
     * @param \DateTime $fechabaja
     *
     * @return LuContrato
     */
    public function setFechabaja($fechabaja)
    {
        $this->fechabaja = $fechabaja;

        return $this;
    }

    /**
     * Get fechabaja
     *
     * @return \DateTime
     */
    public function getFechabaja()
    {
        return $this->fechabaja;
    }

    /**
     * Get contratoid
     *
     * @return integer
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return LuContrato
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
     * Set tipoid
     *
     * @param \AppBundle\Entity\LuTipo $tipoid
     *
     * @return LuContrato
     */
    public function setTipoid(\AppBundle\Entity\LuTipo $tipoid = null)
    {
        $this->tipoid = $tipoid;

        return $this;
    }

    /**
     * Get tipoid
     *
     * @return \AppBundle\Entity\LuTipo
     */
    public function getTipoid()
    {
        return $this->tipoid;
    }

    /**
     * Set contratoestatusid
     *
     * @param \AppBundle\Entity\LuContratoestatus $contratoestatusid
     *
     * @return LuContrato
     */
    public function setContratoestatusid(\AppBundle\Entity\LuContratoestatus $contratoestatusid = null)
    {
        $this->contratoestatusid = $contratoestatusid;

        return $this;
    }

    /**
     * Get contratoestatusid
     *
     * @return \AppBundle\Entity\LuContratoestatus
     */
    public function getContratoestatusid()
    {
        return $this->contratoestatusid;
    }
}

