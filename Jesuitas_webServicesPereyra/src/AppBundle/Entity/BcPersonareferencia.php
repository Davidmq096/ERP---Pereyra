<?php

namespace AppBundle\Entity;

/**
 * BcPersonareferencia
 */
class BcPersonareferencia
{
    /**
     * @var string
     */
    private $nombrecompleto;

    /**
     * @var string
     */
    private $telefonocelular;

    /**
     * @var string
     */
    private $telefonofijo;

    /**
     * @var string
     */
    private $ocupacion;

    /**
     * @var integer
     */
    private $personareferenciaid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set nombrecompleto
     *
     * @param string $nombrecompleto
     *
     * @return BcPersonareferencia
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
     * Set telefonocelular
     *
     * @param string $telefonocelular
     *
     * @return BcPersonareferencia
     */
    public function setTelefonocelular($telefonocelular)
    {
        $this->telefonocelular = $telefonocelular;

        return $this;
    }

    /**
     * Get telefonocelular
     *
     * @return string
     */
    public function getTelefonocelular()
    {
        return $this->telefonocelular;
    }

    /**
     * Set telefonofijo
     *
     * @param string $telefonofijo
     *
     * @return BcPersonareferencia
     */
    public function setTelefonofijo($telefonofijo)
    {
        $this->telefonofijo = $telefonofijo;

        return $this;
    }

    /**
     * Get telefonofijo
     *
     * @return string
     */
    public function getTelefonofijo()
    {
        return $this->telefonofijo;
    }

    /**
     * Set ocupacion
     *
     * @param string $ocupacion
     *
     * @return BcPersonareferencia
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
     * Get personareferenciaid
     *
     * @return integer
     */
    public function getPersonareferenciaid()
    {
        return $this->personareferenciaid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcPersonareferencia
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

