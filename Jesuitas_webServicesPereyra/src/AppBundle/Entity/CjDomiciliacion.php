<?php

namespace AppBundle\Entity;

/**
 * CjDomiciliacion
 */
class CjDomiciliacion
{
    /**
     * @var boolean
     */
    private $tiporegistro;

    /**
     * @var string
     */
    private $nombretitularcuenta;

    /**
     * @var integer
     */
    private $tipocuenta;

    /**
     * @var string
     */
    private $cuenta;

    /**
     * @var string
     */
    private $referencia;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $domiciliacionid;

    /**
     * @var \AppBundle\Entity\CjBanco
     */
    private $bancoid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;


    /**
     * Set tiporegistro
     *
     * @param boolean $tiporegistro
     *
     * @return CjDomiciliacion
     */
    public function setTiporegistro($tiporegistro)
    {
        $this->tiporegistro = $tiporegistro;

        return $this;
    }

    /**
     * Get tiporegistro
     *
     * @return boolean
     */
    public function getTiporegistro()
    {
        return $this->tiporegistro;
    }

    /**
     * Set nombretitularcuenta
     *
     * @param string $nombretitularcuenta
     *
     * @return CjDomiciliacion
     */
    public function setNombretitularcuenta($nombretitularcuenta)
    {
        $this->nombretitularcuenta = $nombretitularcuenta;

        return $this;
    }

    /**
     * Get nombretitularcuenta
     *
     * @return string
     */
    public function getNombretitularcuenta()
    {
        return $this->nombretitularcuenta;
    }

    /**
     * Set tipocuenta
     *
     * @param integer $tipocuenta
     *
     * @return CjDomiciliacion
     */
    public function setTipocuenta($tipocuenta)
    {
        $this->tipocuenta = $tipocuenta;

        return $this;
    }

    /**
     * Get tipocuenta
     *
     * @return integer
     */
    public function getTipocuenta()
    {
        return $this->tipocuenta;
    }

    /**
     * Set cuenta
     *
     * @param string $cuenta
     *
     * @return CjDomiciliacion
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return string
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     *
     * @return CjDomiciliacion
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjDomiciliacion
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
     * Get domiciliacionid
     *
     * @return integer
     */
    public function getDomiciliacionid()
    {
        return $this->domiciliacionid;
    }

    /**
     * Set bancoid
     *
     * @param \AppBundle\Entity\CjBanco $bancoid
     *
     * @return CjDomiciliacion
     */
    public function setBancoid(\AppBundle\Entity\CjBanco $bancoid = null)
    {
        $this->bancoid = $bancoid;

        return $this;
    }

    /**
     * Get bancoid
     *
     * @return \AppBundle\Entity\CjBanco
     */
    public function getBancoid()
    {
        return $this->bancoid;
    }

    /**
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return CjDomiciliacion
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

