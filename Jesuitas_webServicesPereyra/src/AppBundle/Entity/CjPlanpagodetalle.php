<?php

namespace AppBundle\Entity;

/**
 * CjPlanpagodetalle
 */
class CjPlanpagodetalle
{
    /**
     * @var integer
     */
    private $orden;

    /**
     * @var string
     */
    private $porcentajepago;

    /**
     * @var string
     */
    private $porcentajeinteresmensual;

    /**
     * @var \DateTime
     */
    private $fechavencimiento;

    /**
     * @var \DateTime
     */
    private $fechaprontopago;

    /**
     * @var integer
     */
    private $planpagodetalleid;

    /**
     * @var \AppBundle\Entity\CjPlanpago
     */
    private $planpagoid;


    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return CjPlanpagodetalle
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set porcentajepago
     *
     * @param string $porcentajepago
     *
     * @return CjPlanpagodetalle
     */
    public function setPorcentajepago($porcentajepago)
    {
        $this->porcentajepago = $porcentajepago;

        return $this;
    }

    /**
     * Get porcentajepago
     *
     * @return string
     */
    public function getPorcentajepago()
    {
        return $this->porcentajepago;
    }

    /**
     * Set porcentajeinteresmensual
     *
     * @param string $porcentajeinteresmensual
     *
     * @return CjPlanpagodetalle
     */
    public function setPorcentajeinteresmensual($porcentajeinteresmensual)
    {
        $this->porcentajeinteresmensual = $porcentajeinteresmensual;

        return $this;
    }

    /**
     * Get porcentajeinteresmensual
     *
     * @return string
     */
    public function getPorcentajeinteresmensual()
    {
        return $this->porcentajeinteresmensual;
    }

    /**
     * Set fechavencimiento
     *
     * @param \DateTime $fechavencimiento
     *
     * @return CjPlanpagodetalle
     */
    public function setFechavencimiento($fechavencimiento)
    {
        $this->fechavencimiento = $fechavencimiento;

        return $this;
    }

    /**
     * Get fechavencimiento
     *
     * @return \DateTime
     */
    public function getFechavencimiento()
    {
        return $this->fechavencimiento;
    }

    /**
     * Set fechaprontopago
     *
     * @param \DateTime $fechaprontopago
     *
     * @return CjPlanpagodetalle
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
     * Get planpagodetalleid
     *
     * @return integer
     */
    public function getPlanpagodetalleid()
    {
        return $this->planpagodetalleid;
    }

    /**
     * Set planpagoid
     *
     * @param \AppBundle\Entity\CjPlanpago $planpagoid
     *
     * @return CjPlanpagodetalle
     */
    public function setPlanpagoid(\AppBundle\Entity\CjPlanpago $planpagoid = null)
    {
        $this->planpagoid = $planpagoid;

        return $this;
    }

    /**
     * Get planpagoid
     *
     * @return \AppBundle\Entity\CjPlanpago
     */
    public function getPlanpagoid()
    {
        return $this->planpagoid;
    }
}

