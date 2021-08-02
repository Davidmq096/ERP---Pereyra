<?php

namespace AppBundle\Entity;

/**
 * CjFactura
 */
class CjFactura
{
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
     * @var \AppBundle\Entity\CjCaja
     */
    private $cajaid;

    /**
     * @var \AppBundle\Entity\CjFacturaestatus
     */
    private $facturaestatusid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;

    /**
     * @var \AppBundle\Entity\CjPago
     */
    private $pagoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;

    /**
     * @var \AppBundle\Entity\CjUsocfdi
     */
    private $usocfdiid;


    /**
     * Set serie
     *
     * @param string $serie
     *
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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
     * @return CjFactura
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

    /**
     * Set cajaid
     *
     * @param \AppBundle\Entity\CjCaja $cajaid
     *
     * @return CjFactura
     */
    public function setCajaid(\AppBundle\Entity\CjCaja $cajaid = null)
    {
        $this->cajaid = $cajaid;

        return $this;
    }

    /**
     * Get cajaid
     *
     * @return \AppBundle\Entity\CjCaja
     */
    public function getCajaid()
    {
        return $this->cajaid;
    }

    /**
     * Set facturaestatusid
     *
     * @param \AppBundle\Entity\CjFacturaestatus $facturaestatusid
     *
     * @return CjFactura
     */
    public function setFacturaestatusid(\AppBundle\Entity\CjFacturaestatus $facturaestatusid = null)
    {
        $this->facturaestatusid = $facturaestatusid;

        return $this;
    }

    /**
     * Get facturaestatusid
     *
     * @return \AppBundle\Entity\CjFacturaestatus
     */
    public function getFacturaestatusid()
    {
        return $this->facturaestatusid;
    }

    /**
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return CjFactura
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

    /**
     * Set pagoid
     *
     * @param \AppBundle\Entity\CjPago $pagoid
     *
     * @return CjFactura
     */
    public function setPagoid(\AppBundle\Entity\CjPago $pagoid = null)
    {
        $this->pagoid = $pagoid;

        return $this;
    }

    /**
     * Get pagoid
     *
     * @return \AppBundle\Entity\CjPago
     */
    public function getPagoid()
    {
        return $this->pagoid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CjFactura
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

    /**
     * Set usocfdiid
     *
     * @param \AppBundle\Entity\CjUsocfdi $usocfdiid
     *
     * @return CjFactura
     */
    public function setUsocfdiid(\AppBundle\Entity\CjUsocfdi $usocfdiid = null)
    {
        $this->usocfdiid = $usocfdiid;

        return $this;
    }

    /**
     * Get usocfdiid
     *
     * @return \AppBundle\Entity\CjUsocfdi
     */
    public function getUsocfdiid()
    {
        return $this->usocfdiid;
    }
}

