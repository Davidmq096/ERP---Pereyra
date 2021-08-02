<?php

namespace AppBundle\Entity;

/**
 * TpAlumnomesrutaprecio
 */
class TpAlumnomesrutaprecio
{
    /**
     * @var float
     */
    private $importe;

    /**
     * @var boolean
     */
    private $precioespecial;

    /**
     * @var integer
     */
    private $alumnomesrutaprecioid;

    /**
     * @var \AppBundle\Entity\TpAlumnomes
     */
    private $alumnomesid;

    /**
     * @var \AppBundle\Entity\TpAlumnoruta
     */
    private $alumnorutaid;

    /**
     * @var \AppBundle\Entity\CjDocumentoporpagar
     */
    private $documentoporpagarid;

    /**
     * @var \AppBundle\Entity\TpContrato
     */
    private $contratoid;


    /**
     * Set importe
     *
     * @param float $importe
     *
     * @return TpAlumnomesrutaprecio
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return float
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set precioespecial
     *
     * @param boolean $precioespecial
     *
     * @return TpAlumnomesrutaprecio
     */
    public function setPrecioespecial($precioespecial)
    {
        $this->precioespecial = $precioespecial;

        return $this;
    }

    /**
     * Get precioespecial
     *
     * @return boolean
     */
    public function getPrecioespecial()
    {
        return $this->precioespecial;
    }

    /**
     * Get alumnomesrutaprecioid
     *
     * @return integer
     */
    public function getAlumnomesrutaprecioid()
    {
        return $this->alumnomesrutaprecioid;
    }

    /**
     * Set alumnomesid
     *
     * @param \AppBundle\Entity\TpAlumnomes $alumnomesid
     *
     * @return TpAlumnomesrutaprecio
     */
    public function setAlumnomesid(\AppBundle\Entity\TpAlumnomes $alumnomesid = null)
    {
        $this->alumnomesid = $alumnomesid;

        return $this;
    }

    /**
     * Get alumnomesid
     *
     * @return \AppBundle\Entity\TpAlumnomes
     */
    public function getAlumnomesid()
    {
        return $this->alumnomesid;
    }

    /**
     * Set alumnorutaid
     *
     * @param \AppBundle\Entity\TpAlumnoruta $alumnorutaid
     *
     * @return TpAlumnomesrutaprecio
     */
    public function setAlumnorutaid(\AppBundle\Entity\TpAlumnoruta $alumnorutaid = null)
    {
        $this->alumnorutaid = $alumnorutaid;

        return $this;
    }

    /**
     * Get alumnorutaid
     *
     * @return \AppBundle\Entity\TpAlumnoruta
     */
    public function getAlumnorutaid()
    {
        return $this->alumnorutaid;
    }

    /**
     * Set documentoporpagarid
     *
     * @param \AppBundle\Entity\CjDocumentoporpagar $documentoporpagarid
     *
     * @return TpAlumnomesrutaprecio
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
     * Set contratoid
     *
     * @param \AppBundle\Entity\TpContrato $contratoid
     *
     * @return TpAlumnomesrutaprecio
     */
    public function setContratoid(\AppBundle\Entity\TpContrato $contratoid = null)
    {
        $this->contratoid = $contratoid;

        return $this;
    }

    /**
     * Get contratoid
     *
     * @return \AppBundle\Entity\TpContrato
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }
}

