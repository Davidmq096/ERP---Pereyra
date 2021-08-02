<?php

namespace AppBundle\Entity;

/**
 * CjCuentaporconcepto
 */
class CjCuentaporconcepto
{
    /**
     * @var integer
     */
    private $cuentaporconceptoid;

    /**
     * @var \AppBundle\Entity\CjBanco
     */
    private $bancoid;

    /**
     * @var \AppBundle\Entity\CjConcepto
     */
    private $conceptoid;

    /**
     * @var \AppBundle\Entity\CjCuentacontable
     */
    private $cuentacontableid;

    /**
     * @var \AppBundle\Entity\CjTipocuenta
     */
    private $tipocuentaid;


    /**
     * Get cuentaporconceptoid
     *
     * @return integer
     */
    public function getCuentaporconceptoid()
    {
        return $this->cuentaporconceptoid;
    }

    /**
     * Set bancoid
     *
     * @param \AppBundle\Entity\CjBanco $bancoid
     *
     * @return CjCuentaporconcepto
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
     * Set conceptoid
     *
     * @param \AppBundle\Entity\CjConcepto $conceptoid
     *
     * @return CjCuentaporconcepto
     */
    public function setConceptoid(\AppBundle\Entity\CjConcepto $conceptoid = null)
    {
        $this->conceptoid = $conceptoid;

        return $this;
    }

    /**
     * Get conceptoid
     *
     * @return \AppBundle\Entity\CjConcepto
     */
    public function getConceptoid()
    {
        return $this->conceptoid;
    }

    /**
     * Set cuentacontableid
     *
     * @param \AppBundle\Entity\CjCuentacontable $cuentacontableid
     *
     * @return CjCuentaporconcepto
     */
    public function setCuentacontableid(\AppBundle\Entity\CjCuentacontable $cuentacontableid = null)
    {
        $this->cuentacontableid = $cuentacontableid;

        return $this;
    }

    /**
     * Get cuentacontableid
     *
     * @return \AppBundle\Entity\CjCuentacontable
     */
    public function getCuentacontableid()
    {
        return $this->cuentacontableid;
    }

    /**
     * Set tipocuentaid
     *
     * @param \AppBundle\Entity\CjTipocuenta $tipocuentaid
     *
     * @return CjCuentaporconcepto
     */
    public function setTipocuentaid(\AppBundle\Entity\CjTipocuenta $tipocuentaid = null)
    {
        $this->tipocuentaid = $tipocuentaid;

        return $this;
    }

    /**
     * Get tipocuentaid
     *
     * @return \AppBundle\Entity\CjTipocuenta
     */
    public function getTipocuentaid()
    {
        return $this->tipocuentaid;
    }
}

