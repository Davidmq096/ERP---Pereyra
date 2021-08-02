<?php

namespace AppBundle\Entity;

/**
 * CjDevoluciondetalle
 */
class CjDevoluciondetalle
{
    /**
     * @var string
     */
    private $importe;

    /**
     * @var boolean
     */
    private $afectasaldo;

    /**
     * @var integer
     */
    private $devoluciondetalleid;

    /**
     * @var \AppBundle\Entity\CjDevolucion
     */
    private $devolucionid;

    /**
     * @var \AppBundle\Entity\CjFormapago
     */
    private $formapagoid;

    /**
     * @var \AppBundle\Entity\CjPagodetalle
     */
    private $pagodetalleid;


    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjDevoluciondetalle
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
     * Set afectasaldo
     *
     * @param boolean $afectasaldo
     *
     * @return CjDevoluciondetalle
     */
    public function setAfectasaldo($afectasaldo)
    {
        $this->afectasaldo = $afectasaldo;

        return $this;
    }

    /**
     * Get afectasaldo
     *
     * @return boolean
     */
    public function getAfectasaldo()
    {
        return $this->afectasaldo;
    }

    /**
     * Get devoluciondetalleid
     *
     * @return integer
     */
    public function getDevoluciondetalleid()
    {
        return $this->devoluciondetalleid;
    }

    /**
     * Set devolucionid
     *
     * @param \AppBundle\Entity\CjDevolucion $devolucionid
     *
     * @return CjDevoluciondetalle
     */
    public function setDevolucionid(\AppBundle\Entity\CjDevolucion $devolucionid = null)
    {
        $this->devolucionid = $devolucionid;

        return $this;
    }

    /**
     * Get devolucionid
     *
     * @return \AppBundle\Entity\CjDevolucion
     */
    public function getDevolucionid()
    {
        return $this->devolucionid;
    }

    /**
     * Set formapagoid
     *
     * @param \AppBundle\Entity\CjFormapago $formapagoid
     *
     * @return CjDevoluciondetalle
     */
    public function setFormapagoid(\AppBundle\Entity\CjFormapago $formapagoid = null)
    {
        $this->formapagoid = $formapagoid;

        return $this;
    }

    /**
     * Get formapagoid
     *
     * @return \AppBundle\Entity\CjFormapago
     */
    public function getFormapagoid()
    {
        return $this->formapagoid;
    }

    /**
     * Set pagodetalleid
     *
     * @param \AppBundle\Entity\CjPagodetalle $pagodetalleid
     *
     * @return CjDevoluciondetalle
     */
    public function setPagodetalleid(\AppBundle\Entity\CjPagodetalle $pagodetalleid = null)
    {
        $this->pagodetalleid = $pagodetalleid;

        return $this;
    }

    /**
     * Get pagodetalleid
     *
     * @return \AppBundle\Entity\CjPagodetalle
     */
    public function getPagodetalleid()
    {
        return $this->pagodetalleid;
    }
}

