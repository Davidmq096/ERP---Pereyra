<?php

namespace AppBundle\Entity;

/**
 * BcCuentabanco
 */
class BcCuentabanco
{
    /**
     * @var string
     */
    private $bancoinstitucion;

    /**
     * @var string
     */
    private $numerocuenta;

    /**
     * @var float
     */
    private $saldoactual;

    /**
     * @var integer
     */
    private $portal;

    /**
     * @var integer
     */
    private $cuentabancoid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudbecaid;

    /**
     * @var \AppBundle\Entity\BcTipocuentabanco
     */
    private $tipocuentabancoid;


    /**
     * Set bancoinstitucion
     *
     * @param string $bancoinstitucion
     *
     * @return BcCuentabanco
     */
    public function setBancoinstitucion($bancoinstitucion)
    {
        $this->bancoinstitucion = $bancoinstitucion;

        return $this;
    }

    /**
     * Get bancoinstitucion
     *
     * @return string
     */
    public function getBancoinstitucion()
    {
        return $this->bancoinstitucion;
    }

    /**
     * Set numerocuenta
     *
     * @param string $numerocuenta
     *
     * @return BcCuentabanco
     */
    public function setNumerocuenta($numerocuenta)
    {
        $this->numerocuenta = $numerocuenta;

        return $this;
    }

    /**
     * Get numerocuenta
     *
     * @return string
     */
    public function getNumerocuenta()
    {
        return $this->numerocuenta;
    }

    /**
     * Set saldoactual
     *
     * @param float $saldoactual
     *
     * @return BcCuentabanco
     */
    public function setSaldoactual($saldoactual)
    {
        $this->saldoactual = $saldoactual;

        return $this;
    }

    /**
     * Get saldoactual
     *
     * @return float
     */
    public function getSaldoactual()
    {
        return $this->saldoactual;
    }

    /**
     * Set portal
     *
     * @param integer $portal
     *
     * @return BcCuentabanco
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
     * Get cuentabancoid
     *
     * @return integer
     */
    public function getCuentabancoid()
    {
        return $this->cuentabancoid;
    }

    /**
     * Set solicitudbecaid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudbecaid
     *
     * @return BcCuentabanco
     */
    public function setSolicitudbecaid(\AppBundle\Entity\BcSolicitudbeca $solicitudbecaid = null)
    {
        $this->solicitudbecaid = $solicitudbecaid;

        return $this;
    }

    /**
     * Get solicitudbecaid
     *
     * @return \AppBundle\Entity\BcSolicitudbeca
     */
    public function getSolicitudbecaid()
    {
        return $this->solicitudbecaid;
    }

    /**
     * Set tipocuentabancoid
     *
     * @param \AppBundle\Entity\BcTipocuentabanco $tipocuentabancoid
     *
     * @return BcCuentabanco
     */
    public function setTipocuentabancoid(\AppBundle\Entity\BcTipocuentabanco $tipocuentabancoid = null)
    {
        $this->tipocuentabancoid = $tipocuentabancoid;

        return $this;
    }

    /**
     * Get tipocuentabancoid
     *
     * @return \AppBundle\Entity\BcTipocuentabanco
     */
    public function getTipocuentabancoid()
    {
        return $this->tipocuentabancoid;
    }
}

