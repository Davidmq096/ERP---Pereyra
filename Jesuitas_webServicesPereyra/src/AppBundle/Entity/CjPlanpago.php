<?php

namespace AppBundle\Entity;

/**
 * CjPlanpago
 */
class CjPlanpago
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $cantidadpagos;

    /**
     * @var boolean
     */
    private $aplicadescuentoprontopago;

    /**
     * @var string
     */
    private $descuentoprontopago;

    /**
     * @var string
     */
    private $recargoporvencimiento;

    /**
     * @var boolean
     */
    private $nuevoingreso;

    /**
     * @var boolean
     */
    private $reingreso;

    /**
     * @var \DateTime
     */
    private $fechaprorroga;

    /**
     * @var \DateTime
     */
    private $fechaprontopago;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $planpagoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjPlanpago
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set cantidadpagos
     *
     * @param integer $cantidadpagos
     *
     * @return CjPlanpago
     */
    public function setCantidadpagos($cantidadpagos)
    {
        $this->cantidadpagos = $cantidadpagos;

        return $this;
    }

    /**
     * Get cantidadpagos
     *
     * @return integer
     */
    public function getCantidadpagos()
    {
        return $this->cantidadpagos;
    }

    /**
     * Set aplicadescuentoprontopago
     *
     * @param boolean $aplicadescuentoprontopago
     *
     * @return CjPlanpago
     */
    public function setAplicadescuentoprontopago($aplicadescuentoprontopago)
    {
        $this->aplicadescuentoprontopago = $aplicadescuentoprontopago;

        return $this;
    }

    /**
     * Get aplicadescuentoprontopago
     *
     * @return boolean
     */
    public function getAplicadescuentoprontopago()
    {
        return $this->aplicadescuentoprontopago;
    }

    /**
     * Set descuentoprontopago
     *
     * @param string $descuentoprontopago
     *
     * @return CjPlanpago
     */
    public function setDescuentoprontopago($descuentoprontopago)
    {
        $this->descuentoprontopago = $descuentoprontopago;

        return $this;
    }

    /**
     * Get descuentoprontopago
     *
     * @return string
     */
    public function getDescuentoprontopago()
    {
        return $this->descuentoprontopago;
    }

    /**
     * Set recargoporvencimiento
     *
     * @param string $recargoporvencimiento
     *
     * @return CjPlanpago
     */
    public function setRecargoporvencimiento($recargoporvencimiento)
    {
        $this->recargoporvencimiento = $recargoporvencimiento;

        return $this;
    }

    /**
     * Get recargoporvencimiento
     *
     * @return string
     */
    public function getRecargoporvencimiento()
    {
        return $this->recargoporvencimiento;
    }

    /**
     * Set nuevoingreso
     *
     * @param boolean $nuevoingreso
     *
     * @return CjPlanpago
     */
    public function setNuevoingreso($nuevoingreso)
    {
        $this->nuevoingreso = $nuevoingreso;

        return $this;
    }

    /**
     * Get nuevoingreso
     *
     * @return boolean
     */
    public function getNuevoingreso()
    {
        return $this->nuevoingreso;
    }

    /**
     * Set reingreso
     *
     * @param boolean $reingreso
     *
     * @return CjPlanpago
     */
    public function setReingreso($reingreso)
    {
        $this->reingreso = $reingreso;

        return $this;
    }

    /**
     * Get reingreso
     *
     * @return boolean
     */
    public function getReingreso()
    {
        return $this->reingreso;
    }

    /**
     * Set fechaprorroga
     *
     * @param \DateTime $fechaprorroga
     *
     * @return CjPlanpago
     */
    public function setFechaprorroga($fechaprorroga)
    {
        $this->fechaprorroga = $fechaprorroga;

        return $this;
    }

    /**
     * Get fechaprorroga
     *
     * @return \DateTime
     */
    public function getFechaprorroga()
    {
        return $this->fechaprorroga;
    }

    /**
     * Set fechaprontopago
     *
     * @param \DateTime $fechaprontopago
     *
     * @return CjPlanpago
     */
    public function setFechaprontopago($fechaprontopago)
    {
        $this->fechaprontopago = $fechaprontopago;

        return $this;
    }

    /**
     * Get fechaprontopago
     *
     * @return \DateTime
     */
    public function getFechaprontopago()
    {
        return $this->fechaprontopago;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjPlanpago
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get planpagoid
     *
     * @return integer
     */
    public function getPlanpagoid()
    {
        return $this->planpagoid;
    }
}

