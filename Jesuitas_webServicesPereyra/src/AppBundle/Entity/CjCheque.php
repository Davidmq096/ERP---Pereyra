<?php

namespace AppBundle\Entity;

/**
 * CjCheque
 */
class CjCheque
{
    /**
     * @var string
     */
    private $folio;

    /**
     * @var string
     */
    private $cuenta;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $importe;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $chequeid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CjBanco
     */
    private $bancoid;

    /**
     * @var \AppBundle\Entity\CjPagoformapago
     */
    private $pagoformapagoid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;


    /**
     * Set folio
     *
     * @param string $folio
     *
     * @return CjCheque
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
     * Set cuenta
     *
     * @param string $cuenta
     *
     * @return CjCheque
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CjCheque
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
     * Set importe
     *
     * @param string $importe
     *
     * @return CjCheque
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CjCheque
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
     * Get chequeid
     *
     * @return integer
     */
    public function getChequeid()
    {
        return $this->chequeid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CjCheque
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set bancoid
     *
     * @param \AppBundle\Entity\CjBanco $bancoid
     *
     * @return CjCheque
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
     * Set pagoformapagoid
     *
     * @param \AppBundle\Entity\CjPagoformapago $pagoformapagoid
     *
     * @return CjCheque
     */
    public function setPagoformapagoid(\AppBundle\Entity\CjPagoformapago $pagoformapagoid = null)
    {
        $this->pagoformapagoid = $pagoformapagoid;

        return $this;
    }

    /**
     * Get pagoformapagoid
     *
     * @return \AppBundle\Entity\CjPagoformapago
     */
    public function getPagoformapagoid()
    {
        return $this->pagoformapagoid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return CjCheque
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = null)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }
}

