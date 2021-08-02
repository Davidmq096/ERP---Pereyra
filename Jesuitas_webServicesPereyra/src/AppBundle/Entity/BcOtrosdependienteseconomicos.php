<?php

namespace AppBundle\Entity;

/**
 * BcOtrosdependienteseconomicos
 */
class BcOtrosdependienteseconomicos
{
    /**
     * @var string
     */
    private $nombrecompleto;

    /**
     * @var string
     */
    private $relacion;

    /**
     * @var string
     */
    private $ocupacion;

    /**
     * @var integer
     */
    private $edad;

    /**
     * @var integer
     */
    private $otrosdependientesid;

    /**
     * @var \AppBundle\Entity\Situacionconyugal
     */
    private $situacionconyugalid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set nombrecompleto
     *
     * @param string $nombrecompleto
     *
     * @return BcOtrosdependienteseconomicos
     */
    public function setNombrecompleto($nombrecompleto)
    {
        $this->nombrecompleto = $nombrecompleto;

        return $this;
    }

    /**
     * Get nombrecompleto
     *
     * @return string
     */
    public function getNombrecompleto()
    {
        return $this->nombrecompleto;
    }

    /**
     * Set relacion
     *
     * @param string $relacion
     *
     * @return BcOtrosdependienteseconomicos
     */
    public function setRelacion($relacion)
    {
        $this->relacion = $relacion;

        return $this;
    }

    /**
     * Get relacion
     *
     * @return string
     */
    public function getRelacion()
    {
        return $this->relacion;
    }

    /**
     * Set ocupacion
     *
     * @param string $ocupacion
     *
     * @return BcOtrosdependienteseconomicos
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
     * Set edad
     *
     * @param integer $edad
     *
     * @return BcOtrosdependienteseconomicos
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Get otrosdependientesid
     *
     * @return integer
     */
    public function getOtrosdependientesid()
    {
        return $this->otrosdependientesid;
    }

    /**
     * Set situacionconyugalid
     *
     * @param \AppBundle\Entity\Situacionconyugal $situacionconyugalid
     *
     * @return BcOtrosdependienteseconomicos
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
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcOtrosdependienteseconomicos
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
}

