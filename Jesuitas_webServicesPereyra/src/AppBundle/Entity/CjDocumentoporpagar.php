<?php

namespace AppBundle\Entity;

/**
 * CjDocumentoporpagar
 */
class CjDocumentoporpagar
{
    /**
     * @var string
     */
    private $importe;

    /**
     * @var string
     */
    private $saldo;

    /**
     * @var string
     */
    private $descuento = '0.00';

    /**
     * @var \DateTime
     */
    private $fechalimitepago;

    /**
     * @var \DateTime
     */
    private $fechacreacion;

    /**
     * @var \DateTime
     */
    private $fechaprontopago;

    /**
     * @var string
     */
    private $referencia;

    /**
     * @var \DateTime
     */
    private $fechareferencia;

    /**
     * @var string
     */
    private $referenciabanco;

    /**
     * @var string
     */
    private $documento;

    /**
     * @var string
     */
    private $idnomina;

    /**
     * @var boolean
     */
    private $hermanos;

    /**
     * @var boolean
     */
    private $reingreso;

    /**
     * @var boolean
     */
    private $padreexalumno;

    /**
     * @var string
     */
    private $concepto;

    /**
     * @var integer
     */
    private $porcentaje;

    /**
     * @var \DateTime
     */
    private $vigenciaacuerdo;

    /**
     * @var string
     */
    private $iva = '0.00';

    /**
     * @var integer
     */
    private $documentoporpagarid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\CjDocumento
     */
    private $documentoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\CjMediopago
     */
    private $mediopagoid;

    /**
     * @var \AppBundle\Entity\CjPagoestatus
     */
    private $pagoestatusid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoid;

    /**
     * @var \AppBundle\Entity\CbAcuerdo
     */
    private $acuerdoid;

    /**
     * @var \AppBundle\Entity\CbTipoacuerdo
     */
    private $tipoacuerdoid;

    /**
     * @var \AppBundle\Entity\CjPagosdiversos
     */
    private $pagodiversoid;


    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjDocumentoporpagar
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
     * Set saldo
     *
     * @param string $saldo
     *
     * @return CjDocumentoporpagar
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return string
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * Set descuento
     *
     * @param string $descuento
     *
     * @return CjDocumentoporpagar
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return string
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set fechalimitepago
     *
     * @param \DateTime $fechalimitepago
     *
     * @return CjDocumentoporpagar
     */
    public function setFechalimitepago($fechalimitepago)
    {
        $this->fechalimitepago = $fechalimitepago;

        return $this;
    }

    /**
     * Get fechalimitepago
     *
     * @return \DateTime
     */
    public function getFechalimitepago()
    {
        return $this->fechalimitepago;
    }

    /**
     * Set fechacreacion
     *
     * @param \DateTime $fechacreacion
     *
     * @return CjDocumentoporpagar
     */
    public function setFechacreacion($fechacreacion)
    {
        $this->fechacreacion = $fechacreacion;

        return $this;
    }

    /**
     * Get fechacreacion
     *
     * @return \DateTime
     */
    public function getFechacreacion()
    {
        return $this->fechacreacion;
    }

    /**
     * Set fechaprontopago
     *
     * @param \DateTime $fechaprontopago
     *
     * @return CjDocumentoporpagar
     */
    public function setFechaprontopago($fechaprontopago)
    {
        $this->fechaprontopago = $fechaprontopago;

        return $this;
    }

    /**
     * Get fechaprontopago
     *
     * @return \DateTime
     */
    public function getFechaprontopago()
    {
        return $this->fechaprontopago;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     *
     * @return CjDocumentoporpagar
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
     * Set fechareferencia
     *
     * @param \DateTime $fechareferencia
     *
     * @return CjDocumentoporpagar
     */
    public function setFechareferencia($fechareferencia)
    {
        $this->fechareferencia = $fechareferencia;

        return $this;
    }

    /**
     * Get fechareferencia
     *
     * @return \DateTime
     */
    public function getFechareferencia()
    {
        return $this->fechareferencia;
    }

    /**
     * Set referenciabanco
     *
     * @param string $referenciabanco
     *
     * @return CjDocumentoporpagar
     */
    public function setReferenciabanco($referenciabanco)
    {
        $this->referenciabanco = $referenciabanco;

        return $this;
    }

    /**
     * Get referenciabanco
     *
     * @return string
     */
    public function getReferenciabanco()
    {
        return $this->referenciabanco;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return CjDocumentoporpagar
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set idnomina
     *
     * @param string $idnomina
     *
     * @return CjDocumentoporpagar
     */
    public function setIdnomina($idnomina)
    {
        $this->idnomina = $idnomina;

        return $this;
    }

    /**
     * Get idnomina
     *
     * @return string
     */
    public function getIdnomina()
    {
        return $this->idnomina;
    }

    /**
     * Set hermanos
     *
     * @param boolean $hermanos
     *
     * @return CjDocumentoporpagar
     */
    public function setHermanos($hermanos)
    {
        $this->hermanos = $hermanos;

        return $this;
    }

    /**
     * Get hermanos
     *
     * @return boolean
     */
    public function getHermanos()
    {
        return $this->hermanos;
    }

    /**
     * Set reingreso
     *
     * @param boolean $reingreso
     *
     * @return CjDocumentoporpagar
     */
    public function setReingreso($reingreso)
    {
        $this->reingreso = $reingreso;

        return $this;
    }

    /**
     * Get reingreso
     *
     * @return boolean
     */
    public function getReingreso()
    {
        return $this->reingreso;
    }

    /**
     * Set padreexalumno
     *
     * @param boolean $padreexalumno
     *
     * @return CjDocumentoporpagar
     */
    public function setPadreexalumno($padreexalumno)
    {
        $this->padreexalumno = $padreexalumno;

        return $this;
    }

    /**
     * Get padreexalumno
     *
     * @return boolean
     */
    public function getPadreexalumno()
    {
        return $this->padreexalumno;
    }

    /**
     * Set concepto
     *
     * @param string $concepto
     *
     * @return CjDocumentoporpagar
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set porcentaje
     *
     * @param integer $porcentaje
     *
     * @return CjDocumentoporpagar
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return integer
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set vigenciaacuerdo
     *
     * @param \DateTime $vigenciaacuerdo
     *
     * @return CjDocumentoporpagar
     */
    public function setVigenciaacuerdo($vigenciaacuerdo)
    {
        $this->vigenciaacuerdo = $vigenciaacuerdo;

        return $this;
    }

    /**
     * Get vigenciaacuerdo
     *
     * @return \DateTime
     */
    public function getVigenciaacuerdo()
    {
        return $this->vigenciaacuerdo;
    }

    /**
     * Set iva
     *
     * @param string $iva
     *
     * @return CjDocumentoporpagar
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
     * Get documentoporpagarid
     *
     * @return integer
     */
    public function getDocumentoporpagarid()
    {
        return $this->documentoporpagarid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CjDocumentoporpagar
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
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CjDocumentoporpagar
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set documentoid
     *
     * @param \AppBundle\Entity\CjDocumento $documentoid
     *
     * @return CjDocumentoporpagar
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
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CjDocumentoporpagar
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set mediopagoid
     *
     * @param \AppBundle\Entity\CjMediopago $mediopagoid
     *
     * @return CjDocumentoporpagar
     */
    public function setMediopagoid(\AppBundle\Entity\CjMediopago $mediopagoid = null)
    {
        $this->mediopagoid = $mediopagoid;

        return $this;
    }

    /**
     * Get mediopagoid
     *
     * @return \AppBundle\Entity\CjMediopago
     */
    public function getMediopagoid()
    {
        return $this->mediopagoid;
    }

    /**
     * Set pagoestatusid
     *
     * @param \AppBundle\Entity\CjPagoestatus $pagoestatusid
     *
     * @return CjDocumentoporpagar
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

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return CjDocumentoporpagar
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

    /**
     * Set subconceptoid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoid
     *
     * @return CjDocumentoporpagar
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

    /**
     * Set acuerdoid
     *
     * @param \AppBundle\Entity\CbAcuerdo $acuerdoid
     *
     * @return CjDocumentoporpagar
     */
    public function setAcuerdoid(\AppBundle\Entity\CbAcuerdo $acuerdoid = null)
    {
        $this->acuerdoid = $acuerdoid;

        return $this;
    }

    /**
     * Get acuerdoid
     *
     * @return \AppBundle\Entity\CbAcuerdo
     */
    public function getAcuerdoid()
    {
        return $this->acuerdoid;
    }

    /**
     * Set tipoacuerdoid
     *
     * @param \AppBundle\Entity\CbTipoacuerdo $tipoacuerdoid
     *
     * @return CjDocumentoporpagar
     */
    public function setTipoacuerdoid(\AppBundle\Entity\CbTipoacuerdo $tipoacuerdoid = null)
    {
        $this->tipoacuerdoid = $tipoacuerdoid;

        return $this;
    }

    /**
     * Get tipoacuerdoid
     *
     * @return \AppBundle\Entity\CbTipoacuerdo
     */
    public function getTipoacuerdoid()
    {
        return $this->tipoacuerdoid;
    }

    /**
     * Set pagodiversoid
     *
     * @param \AppBundle\Entity\CjPagosdiversos $pagodiversoid
     *
     * @return CjDocumentoporpagar
     */
    public function setPagodiversoid(\AppBundle\Entity\CjPagosdiversos $pagodiversoid = null)
    {
        $this->pagodiversoid = $pagodiversoid;

        return $this;
    }

    /**
     * Get pagodiversoid
     *
     * @return \AppBundle\Entity\CjPagosdiversos
     */
    public function getPagodiversoid()
    {
        return $this->pagodiversoid;
    }
}

