<?php

namespace AppBundle\Entity;

/**
 * CjDocumentosubconceptos
 */
class CjDocumentosubconceptos
{
    /**
     * @var boolean
     */
    private $prioridad;

    /**
     * @var boolean
     */
    private $aplicainteres;

    /**
     * @var boolean
     */
    private $aplicanivel;

    /**
     * @var boolean
     */
    private $nuevoingreso;

    /**
     * @var boolean
     */
    private $unsolopago;

    /**
     * @var boolean
     */
    private $descuentobeca = '0';

    /**
     * @var integer
     */
    private $documentosubconceptosid;

    /**
     * @var \AppBundle\Entity\CjDocumento
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoid;


    /**
     * Set prioridad
     *
     * @param boolean $prioridad
     *
     * @return CjDocumentosubconceptos
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return boolean
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set aplicainteres
     *
     * @param boolean $aplicainteres
     *
     * @return CjDocumentosubconceptos
     */
    public function setAplicainteres($aplicainteres)
    {
        $this->aplicainteres = $aplicainteres;

        return $this;
    }

    /**
     * Get aplicainteres
     *
     * @return boolean
     */
    public function getAplicainteres()
    {
        return $this->aplicainteres;
    }

    /**
     * Set aplicanivel
     *
     * @param boolean $aplicanivel
     *
     * @return CjDocumentosubconceptos
     */
    public function setAplicanivel($aplicanivel)
    {
        $this->aplicanivel = $aplicanivel;

        return $this;
    }

    /**
     * Get aplicanivel
     *
     * @return boolean
     */
    public function getAplicanivel()
    {
        return $this->aplicanivel;
    }

    /**
     * Set nuevoingreso
     *
     * @param boolean $nuevoingreso
     *
     * @return CjDocumentosubconceptos
     */
    public function setNuevoingreso($nuevoingreso)
    {
        $this->nuevoingreso = $nuevoingreso;

        return $this;
    }

    /**
     * Get nuevoingreso
     *
     * @return boolean
     */
    public function getNuevoingreso()
    {
        return $this->nuevoingreso;
    }

    /**
     * Set unsolopago
     *
     * @param boolean $unsolopago
     *
     * @return CjDocumentosubconceptos
     */
    public function setUnsolopago($unsolopago)
    {
        $this->unsolopago = $unsolopago;

        return $this;
    }

    /**
     * Get unsolopago
     *
     * @return boolean
     */
    public function getUnsolopago()
    {
        return $this->unsolopago;
    }

    /**
     * Set descuentobeca
     *
     * @param boolean $descuentobeca
     *
     * @return CjDocumentosubconceptos
     */
    public function setDescuentobeca($descuentobeca)
    {
        $this->descuentobeca = $descuentobeca;

        return $this;
    }

    /**
     * Get descuentobeca
     *
     * @return boolean
     */
    public function getDescuentobeca()
    {
        return $this->descuentobeca;
    }

    /**
     * Get documentosubconceptosid
     *
     * @return integer
     */
    public function getDocumentosubconceptosid()
    {
        return $this->documentosubconceptosid;
    }

    /**
     * Set documentoid
     *
     * @param \AppBundle\Entity\CjDocumento $documentoid
     *
     * @return CjDocumentosubconceptos
     */
    public function setDocumentoid(\AppBundle\Entity\CjDocumento $documentoid = null)
    {
        $this->documentoid = $documentoid;

        return $this;
    }

    /**
     * Get documentoid
     *
     * @return \AppBundle\Entity\CjDocumento
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set subconceptoid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoid
     *
     * @return CjDocumentosubconceptos
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

