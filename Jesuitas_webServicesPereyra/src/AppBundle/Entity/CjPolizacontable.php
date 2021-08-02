<?php

namespace AppBundle\Entity;

/**
 * CjPolizacontable
 */
class CjPolizacontable
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $contpaqid;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var boolean
     */
    private $tipopoliza;

    /**
     * @var integer
     */
    private $polizacontableid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CjPolizacontable
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
     * Set contpaqid
     *
     * @param integer $contpaqid
     *
     * @return CjPolizacontable
     */
    public function setContpaqid($contpaqid)
    {
        $this->contpaqid = $contpaqid;

        return $this;
    }

    /**
     * Get contpaqid
     *
     * @return integer
     */
    public function getContpaqid()
    {
        return $this->contpaqid;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CjPolizacontable
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
     * Set tipopoliza
     *
     * @param boolean $tipopoliza
     *
     * @return CjPolizacontable
     */
    public function setTipopoliza($tipopoliza)
    {
        $this->tipopoliza = $tipopoliza;

        return $this;
    }

    /**
     * Get tipopoliza
     *
     * @return boolean
     */
    public function getTipopoliza()
    {
        return $this->tipopoliza;
    }

    /**
     * Get polizacontableid
     *
     * @return integer
     */
    public function getPolizacontableid()
    {
        return $this->polizacontableid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CjPolizacontable
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
}

