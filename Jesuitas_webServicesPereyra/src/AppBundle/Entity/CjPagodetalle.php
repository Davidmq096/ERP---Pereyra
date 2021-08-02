<?php

namespace AppBundle\Entity;

/**
 * CjPagodetalle
 */
class CjPagodetalle
{
    /**
     * @var string
     */
    private $importe;

    /**
     * @var string
     */
    private $iva = '0.00';

    /**
     * @var string
     */
    private $leyenda = '';

    /**
     * @var integer
     */
    private $pagodetalleid;

    /**
     * @var \AppBundle\Entity\CjDocumentoporpagar
     */
    private $documentoporpagarid;

    /**
     * @var \AppBundle\Entity\CjPago
     */
    private $pagoid;

    /**
     * @var \AppBundle\Entity\CjPagoformapago
     */
    private $pagoformapagoid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoid;


    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjPagodetalle
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
     * Set iva
     *
     * @param string $iva
     *
     * @return CjPagodetalle
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return string
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * Set leyenda
     *
     * @param string $leyenda
     *
     * @return CjPagodetalle
     */
    public function setLeyenda($leyenda)
    {
        $this->leyenda = $leyenda;

        return $this;
    }

    /**
     * Get leyenda
     *
     * @return string
     */
    public function getLeyenda()
    {
        return $this->leyenda;
    }

    /**
     * Get pagodetalleid
     *
     * @return integer
     */
    public function getPagodetalleid()
    {
        return $this->pagodetalleid;
    }

    /**
     * Set documentoporpagarid
     *
     * @param \AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid
     *
     * @return CjPagodetalle
     */
    public function setDocumentoporpagarid(\AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid = null)
    {
        $this->documentoporpagarid = $documentoporpagarid;

        return $this;
    }

    /**
     * Get documentoporpagarid
     *
     * @return \AppBundle\Entity\CjDocumentoporpagar
     */
    public function getDocumentoporpagarid()
    {
        return $this->documentoporpagarid;
    }

    /**
     * Set pagoid
     *
     * @param \AppBundle\Entity\CjPago $pagoid
     *
     * @return CjPagodetalle
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
     * Set pagoformapagoid
     *
     * @param \AppBundle\Entity\CjPagoformapago $pagoformapagoid
     *
     * @return CjPagodetalle
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
     * Set subconceptoid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoid
     *
     * @return CjPagodetalle
     */
    public function setSubconceptoid(\AppBundle\Entity\CjSubconcepto $subconceptoid = null)
    {
        $this->subconceptoid = $subconceptoid;

        return $this;
    }

    /**
     * Get subconceptoid
     *
     * @return \AppBundle\Entity\CjSubconcepto
     */
    public function getSubconceptoid()
    {
        return $this->subconceptoid;
    }
}

