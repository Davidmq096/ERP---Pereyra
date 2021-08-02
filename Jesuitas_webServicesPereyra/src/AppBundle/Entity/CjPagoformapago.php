<?php

namespace AppBundle\Entity;

/**
 * CjPagoformapago
 */
class CjPagoformapago
{
    /**
     * @var string
     */
    private $importe;

    /**
     * @var string
     */
    private $referencia = '';

    /**
     * @var string
     */
    private $tarjeta;

    /**
     * @var integer
     */
    private $pagoformapagoid;

    /**
     * @var \AppBundle\Entity\CjFormapago
     */
    private $formapagoid;

    /**
     * @var \AppBundle\Entity\CjPago
     */
    private $pagoid;

    /**
     * @var \AppBundle\Entity\CjPagoestatus
     */
    private $pagoestatusid;


    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjPagoformapago
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
     * Set referencia
     *
     * @param string $referencia
     *
     * @return CjPagoformapago
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
     * Set tarjeta
     *
     * @param string $tarjeta
     *
     * @return CjPagoformapago
     */
    public function setTarjeta($tarjeta)
    {
        $this->tarjeta = $tarjeta;

        return $this;
    }

    /**
     * Get tarjeta
     *
     * @return string
     */
    public function getTarjeta()
    {
        return $this->tarjeta;
    }

    /**
     * Get pagoformapagoid
     *
     * @return integer
     */
    public function getPagoformapagoid()
    {
        return $this->pagoformapagoid;
    }

    /**
     * Set formapagoid
     *
     * @param \AppBundle\Entity\CjFormapago $formapagoid
     *
     * @return CjPagoformapago
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
     * Set pagoid
     *
     * @param \AppBundle\Entity\CjPago $pagoid
     *
     * @return CjPagoformapago
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
     * Set pagoestatusid
     *
     * @param \AppBundle\Entity\CjPagoestatus $pagoestatusid
     *
     * @return CjPagoformapago
     */
    public function setPagoestatusid(\AppBundle\Entity\CjPagoestatus $pagoestatusid = null)
    {
        $this->pagoestatusid = $pagoestatusid;

        return $this;
    }

    /**
     * Get pagoestatusid
     *
     * @return \AppBundle\Entity\CjPagoestatus
     */
    public function getPagoestatusid()
    {
        return $this->pagoestatusid;
    }
}

