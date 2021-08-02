<?php

namespace AppBundle\Entity;

/**
 * BcPadresotutoressolicitud
 */
class BcPadresotutoressolicitud
{
    /**
     * @var integer
     */
    private $vive;

    /**
     * @var string
     */
    private $puesto;

    /**
     * @var string
     */
    private $lugardetrabajo;

    /**
     * @var string
     */
    private $horariodetrabajo;

    /**
     * @var string
     */
    private $antiguedad;

    /**
     * @var string
     */
    private $celular;

    /**
     * @var string
     */
    private $telefonooficina;

    /**
     * @var string
     */
    private $ocupacion;

    /**
     * @var integer
     */
    private $padresotutoressolicitudid;

    /**
     * @var \AppBundle\Entity\Situacionconyugal
     */
    private $situacionconyugalid;

    /**
     * @var \AppBundle\Entity\BcEstatuspadresotutores
     */
    private $padresotutoresvivenid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;


    /**
     * Set vive
     *
     * @param integer $vive
     *
     * @return BcPadresotutoressolicitud
     */
    public function setVive($vive)
    {
        $this->vive = $vive;

        return $this;
    }

    /**
     * Get vive
     *
     * @return integer
     */
    public function getVive()
    {
        return $this->vive;
    }

    /**
     * Set puesto
     *
     * @param string $puesto
     *
     * @return BcPadresotutoressolicitud
     */
    public function setPuesto($puesto)
    {
        $this->puesto = $puesto;

        return $this;
    }

    /**
     * Get puesto
     *
     * @return string
     */
    public function getPuesto()
    {
        return $this->puesto;
    }

    /**
     * Set lugardetrabajo
     *
     * @param string $lugardetrabajo
     *
     * @return BcPadresotutoressolicitud
     */
    public function setLugardetrabajo($lugardetrabajo)
    {
        $this->lugardetrabajo = $lugardetrabajo;

        return $this;
    }

    /**
     * Get lugardetrabajo
     *
     * @return string
     */
    public function getLugardetrabajo()
    {
        return $this->lugardetrabajo;
    }

    /**
     * Set horariodetrabajo
     *
     * @param string $horariodetrabajo
     *
     * @return BcPadresotutoressolicitud
     */
    public function setHorariodetrabajo($horariodetrabajo)
    {
        $this->horariodetrabajo = $horariodetrabajo;

        return $this;
    }

    /**
     * Get horariodetrabajo
     *
     * @return string
     */
    public function getHorariodetrabajo()
    {
        return $this->horariodetrabajo;
    }

    /**
     * Set antiguedad
     *
     * @param string $antiguedad
     *
     * @return BcPadresotutoressolicitud
     */
    public function setAntiguedad($antiguedad)
    {
        $this->antiguedad = $antiguedad;

        return $this;
    }

    /**
     * Get antiguedad
     *
     * @return string
     */
    public function getAntiguedad()
    {
        return $this->antiguedad;
    }

    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return BcPadresotutoressolicitud
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set telefonooficina
     *
     * @param string $telefonooficina
     *
     * @return BcPadresotutoressolicitud
     */
    public function setTelefonooficina($telefonooficina)
    {
        $this->telefonooficina = $telefonooficina;

        return $this;
    }

    /**
     * Get telefonooficina
     *
     * @return string
     */
    public function getTelefonooficina()
    {
        return $this->telefonooficina;
    }

    /**
     * Set ocupacion
     *
     * @param string $ocupacion
     *
     * @return BcPadresotutoressolicitud
     */
    public function setOcupacion($ocupacion)
    {
        $this->ocupacion = $ocupacion;

        return $this;
    }

    /**
     * Get ocupacion
     *
     * @return string
     */
    public function getOcupacion()
    {
        return $this->ocupacion;
    }

    /**
     * Get padresotutoressolicitudid
     *
     * @return integer
     */
    public function getPadresotutoressolicitudid()
    {
        return $this->padresotutoressolicitudid;
    }

    /**
     * Set situacionconyugalid
     *
     * @param \AppBundle\Entity\Situacionconyugal $situacionconyugalid
     *
     * @return BcPadresotutoressolicitud
     */
    public function setSituacionconyugalid(\AppBundle\Entity\Situacionconyugal $situacionconyugalid = null)
    {
        $this->situacionconyugalid = $situacionconyugalid;

        return $this;
    }

    /**
     * Get situacionconyugalid
     *
     * @return \AppBundle\Entity\Situacionconyugal
     */
    public function getSituacionconyugalid()
    {
        return $this->situacionconyugalid;
    }

    /**
     * Set padresotutoresvivenid
     *
     * @param \AppBundle\Entity\BcEstatuspadresotutores $padresotutoresvivenid
     *
     * @return BcPadresotutoressolicitud
     */
    public function setPadresotutoresvivenid(\AppBundle\Entity\BcEstatuspadresotutores $padresotutoresvivenid = null)
    {
        $this->padresotutoresvivenid = $padresotutoresvivenid;

        return $this;
    }

    /**
     * Get padresotutoresvivenid
     *
     * @return \AppBundle\Entity\BcEstatuspadresotutores
     */
    public function getPadresotutoresvivenid()
    {
        return $this->padresotutoresvivenid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcPadresotutoressolicitud
     */
    public function setSolicitudid(\AppBundle\Entity\BcSolicitudbeca $solicitudid = null)
    {
        $this->solicitudid = $solicitudid;

        return $this;
    }

    /**
     * Get solicitudid
     *
     * @return \AppBundle\Entity\BcSolicitudbeca
     */
    public function getSolicitudid()
    {
        return $this->solicitudid;
    }

    /**
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return BcPadresotutoressolicitud
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = null)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }
}

