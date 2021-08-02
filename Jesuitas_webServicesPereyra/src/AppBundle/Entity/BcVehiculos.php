<?php

namespace AppBundle\Entity;

/**
 * BcVehiculos
 */
class BcVehiculos
{
    /**
     * @var string
     */
    private $marcamodelo;

    /**
     * @var integer
     */
    private $anio;

    /**
     * @var string
     */
    private $tarjetacirculacion;

    /**
     * @var integer
     */
    private $portal;

    /**
     * @var integer
     */
    private $vehiculosid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;

    /**
     * @var \AppBundle\Entity\BcEstatusvehiculos
     */
    private $estatus;


    /**
     * Set marcamodelo
     *
     * @param string $marcamodelo
     *
     * @return BcVehiculos
     */
    public function setMarcamodelo($marcamodelo)
    {
        $this->marcamodelo = $marcamodelo;

        return $this;
    }

    /**
     * Get marcamodelo
     *
     * @return string
     */
    public function getMarcamodelo()
    {
        return $this->marcamodelo;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     *
     * @return BcVehiculos
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set tarjetacirculacion
     *
     * @param string $tarjetacirculacion
     *
     * @return BcVehiculos
     */
    public function setTarjetacirculacion($tarjetacirculacion)
    {
        $this->tarjetacirculacion = $tarjetacirculacion;

        return $this;
    }

    /**
     * Get tarjetacirculacion
     *
     * @return string
     */
    public function getTarjetacirculacion()
    {
        return $this->tarjetacirculacion;
    }

    /**
     * Set portal
     *
     * @param integer $portal
     *
     * @return BcVehiculos
     */
    public function setPortal($portal)
    {
        $this->portal = $portal;

        return $this;
    }

    /**
     * Get portal
     *
     * @return integer
     */
    public function getPortal()
    {
        return $this->portal;
    }

    /**
     * Get vehiculosid
     *
     * @return integer
     */
    public function getVehiculosid()
    {
        return $this->vehiculosid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcVehiculos
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
     * Set estatus
     *
     * @param \AppBundle\Entity\BcEstatusvehiculos $estatus
     *
     * @return BcVehiculos
     */
    public function setEstatus(\AppBundle\Entity\BcEstatusvehiculos $estatus = null)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return \AppBundle\Entity\BcEstatusvehiculos
     */
    public function getEstatus()
    {
        return $this->estatus;
    }
}

