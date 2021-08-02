<?php

namespace AppBundle\Entity;

/**
 * CjFacturaRes
 */
class CjFacturaRes
{
    /**
     * @var integer
     */
    private $pagoid;

    /**
     * @var integer
     */
    private $padresotutoresid;

    /**
     * @var integer
     */
    private $usuarioid;

    /**
     * @var integer
     */
    private $cajaid;

    /**
     * @var integer
     */
    private $facturaestatusid;

    /**
     * @var integer
     */
    private $usocfdiid;

    /**
     * @var string
     */
    private $serie;

    /**
     * @var string
     */
    private $folio;

    /**
     * @var string
     */
    private $rfc;

    /**
     * @var string
     */
    private $razonsocial;

    /**
     * @var string
     */
    private $importe;

    /**
     * @var \DateTime
     */
    private $fechaemision;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $numeroexterior;

    /**
     * @var string
     */
    private $numerointerior;

    /**
     * @var string
     */
    private $colonia;

    /**
     * @var string
     */
    private $ciudad;

    /**
     * @var string
     */
    private $codigopostal;

    /**
     * @var integer
     */
    private $tipofactura;

    /**
     * @var integer
     */
    private $facturaid;


    /**
     * Set pagoid
     *
     * @param integer $pagoid
     *
     * @return CjFacturaRes
     */
    public function setPagoid($pagoid)
    {
        $this->pagoid = $pagoid;

        return $this;
    }

    /**
     * Get pagoid
     *
     * @return integer
     */
    public function getPagoid()
    {
        return $this->pagoid;
    }

    /**
     * Set padresotutoresid
     *
     * @param integer $padresotutoresid
     *
     * @return CjFacturaRes
     */
    public function setPadresotutoresid($padresotutoresid)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return integer
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }

    /**
     * Set usuarioid
     *
     * @param integer $usuarioid
     *
     * @return CjFacturaRes
     */
    public function setUsuarioid($usuarioid)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return integer
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }

    /**
     * Set cajaid
     *
     * @param integer $cajaid
     *
     * @return CjFacturaRes
     */
    public function setCajaid($cajaid)
    {
        $this->cajaid = $cajaid;

        return $this;
    }

    /**
     * Get cajaid
     *
     * @return integer
     */
    public function getCajaid()
    {
        return $this->cajaid;
    }

    /**
     * Set facturaestatusid
     *
     * @param integer $facturaestatusid
     *
     * @return CjFacturaRes
     */
    public function setFacturaestatusid($facturaestatusid)
    {
        $this->facturaestatusid = $facturaestatusid;

        return $this;
    }

    /**
     * Get facturaestatusid
     *
     * @return integer
     */
    public function getFacturaestatusid()
    {
        return $this->facturaestatusid;
    }

    /**
     * Set usocfdiid
     *
     * @param integer $usocfdiid
     *
     * @return CjFacturaRes
     */
    public function setUsocfdiid($usocfdiid)
    {
        $this->usocfdiid = $usocfdiid;

        return $this;
    }

    /**
     * Get usocfdiid
     *
     * @return integer
     */
    public function getUsocfdiid()
    {
        return $this->usocfdiid;
    }

    /**
     * Set serie
     *
     * @param string $serie
     *
     * @return CjFacturaRes
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set folio
     *
     * @param string $folio
     *
     * @return CjFacturaRes
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio
     *
     * @return string
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return CjFacturaRes
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get rfc
     *
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set razonsocial
     *
     * @param string $razonsocial
     *
     * @return CjFacturaRes
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;

        return $this;
    }

    /**
     * Get razonsocial
     *
     * @return string
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjFacturaRes
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set fechaemision
     *
     * @param \DateTime $fechaemision
     *
     * @return CjFacturaRes
     */
    public function setFechaemision($fechaemision)
    {
        $this->fechaemision = $fechaemision;

        return $this;
    }

    /**
     * Get fechaemision
     *
     * @return \DateTime
     */
    public function getFechaemision()
    {
        return $this->fechaemision;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return CjFacturaRes
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return CjFacturaRes
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numeroexterior
     *
     * @param string $numeroexterior
     *
     * @return CjFacturaRes
     */
    public function setNumeroexterior($numeroexterior)
    {
        $this->numeroexterior = $numeroexterior;

        return $this;
    }

    /**
     * Get numeroexterior
     *
     * @return string
     */
    public function getNumeroexterior()
    {
        return $this->numeroexterior;
    }

    /**
     * Set numerointerior
     *
     * @param string $numerointerior
     *
     * @return CjFacturaRes
     */
    public function setNumerointerior($numerointerior)
    {
        $this->numerointerior = $numerointerior;

        return $this;
    }

    /**
     * Get numerointerior
     *
     * @return string
     */
    public function getNumerointerior()
    {
        return $this->numerointerior;
    }

    /**
     * Set colonia
     *
     * @param string $colonia
     *
     * @return CjFacturaRes
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get colonia
     *
     * @return string
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     *
     * @return CjFacturaRes
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set codigopostal
     *
     * @param string $codigopostal
     *
     * @return CjFacturaRes
     */
    public function setCodigopostal($codigopostal)
    {
        $this->codigopostal = $codigopostal;

        return $this;
    }

    /**
     * Get codigopostal
     *
     * @return string
     */
    public function getCodigopostal()
    {
        return $this->codigopostal;
    }

    /**
     * Set tipofactura
     *
     * @param integer $tipofactura
     *
     * @return CjFacturaRes
     */
    public function setTipofactura($tipofactura)
    {
        $this->tipofactura = $tipofactura;

        return $this;
    }

    /**
     * Get tipofactura
     *
     * @return integer
     */
    public function getTipofactura()
    {
        return $this->tipofactura;
    }

    /**
     * Get facturaid
     *
     * @return integer
     */
    public function getFacturaid()
    {
        return $this->facturaid;
    }
}

