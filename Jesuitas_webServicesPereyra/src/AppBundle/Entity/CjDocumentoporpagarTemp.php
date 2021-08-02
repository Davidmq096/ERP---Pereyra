<?php

namespace AppBundle\Entity;

/**
 * CjDocumentoporpagarTemp
 */
class CjDocumentoporpagarTemp
{
    /**
     * @var integer
     */
    private $documentoid;

    /**
     * @var integer
     */
    private $subconceptoid;

    /**
     * @var integer
     */
    private $pagoestatusid;

    /**
     * @var integer
     */
    private $alumnoid;

    /**
     * @var integer
     */
    private $solicitudadmisionid;

    /**
     * @var integer
     */
    private $cicloid;

    /**
     * @var integer
     */
    private $gradoid;

    /**
     * @var integer
     */
    private $mediopagoid;

    /**
     * @var string
     */
    private $importe;

    /**
     * @var string
     */
    private $saldo;

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
    private $acuerdoid;

    /**
     * @var integer
     */
    private $tipoacuerdoid;

    /**
     * @var integer
     */
    private $porcentaje;

    /**
     * @var string
     */
    private $iva = '0.00';

    /**
     * @var integer
     */
    private $documentoporpagarid;


    /**
     * Set documentoid
     *
     * @param integer $documentoid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setDocumentoid($documentoid)
    {
        $this->documentoid = $documentoid;

        return $this;
    }

    /**
     * Get documentoid
     *
     * @return integer
     */
    public function getDocumentoid()
    {
        return $this->documentoid;
    }

    /**
     * Set subconceptoid
     *
     * @param integer $subconceptoid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setSubconceptoid($subconceptoid)
    {
        $this->subconceptoid = $subconceptoid;

        return $this;
    }

    /**
     * Get subconceptoid
     *
     * @return integer
     */
    public function getSubconceptoid()
    {
        return $this->subconceptoid;
    }

    /**
     * Set pagoestatusid
     *
     * @param integer $pagoestatusid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setPagoestatusid($pagoestatusid)
    {
        $this->pagoestatusid = $pagoestatusid;

        return $this;
    }

    /**
     * Get pagoestatusid
     *
     * @return integer
     */
    public function getPagoestatusid()
    {
        return $this->pagoestatusid;
    }

    /**
     * Set alumnoid
     *
     * @param integer $alumnoid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setAlumnoid($alumnoid)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return integer
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param integer $solicitudadmisionid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setSolicitudadmisionid($solicitudadmisionid)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return integer
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }

    /**
     * Set cicloid
     *
     * @param integer $cicloid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setCicloid($cicloid)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return integer
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set gradoid
     *
     * @param integer $gradoid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setGradoid($gradoid)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return integer
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set mediopagoid
     *
     * @param integer $mediopagoid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setMediopagoid($mediopagoid)
    {
        $this->mediopagoid = $mediopagoid;

        return $this;
    }

    /**
     * Get mediopagoid
     *
     * @return integer
     */
    public function getMediopagoid()
    {
        return $this->mediopagoid;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjDocumentoporpagarTemp
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
     * @return CjDocumentoporpagarTemp
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
     * Set fechalimitepago
     *
     * @param \DateTime $fechalimitepago
     *
     * @return CjDocumentoporpagarTemp
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
     * @return CjDocumentoporpagarTemp
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
     * @return CjDocumentoporpagarTemp
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
     * @return CjDocumentoporpagarTemp
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
     * Set documento
     *
     * @param string $documento
     *
     * @return CjDocumentoporpagarTemp
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
     * @return CjDocumentoporpagarTemp
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
     * @return CjDocumentoporpagarTemp
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
     * @return CjDocumentoporpagarTemp
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
     * @return CjDocumentoporpagarTemp
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
     * @return CjDocumentoporpagarTemp
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
     * Set acuerdoid
     *
     * @param integer $acuerdoid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setAcuerdoid($acuerdoid)
    {
        $this->acuerdoid = $acuerdoid;

        return $this;
    }

    /**
     * Get acuerdoid
     *
     * @return integer
     */
    public function getAcuerdoid()
    {
        return $this->acuerdoid;
    }

    /**
     * Set tipoacuerdoid
     *
     * @param integer $tipoacuerdoid
     *
     * @return CjDocumentoporpagarTemp
     */
    public function setTipoacuerdoid($tipoacuerdoid)
    {
        $this->tipoacuerdoid = $tipoacuerdoid;

        return $this;
    }

    /**
     * Get tipoacuerdoid
     *
     * @return integer
     */
    public function getTipoacuerdoid()
    {
        return $this->tipoacuerdoid;
    }

    /**
     * Set porcentaje
     *
     * @param integer $porcentaje
     *
     * @return CjDocumentoporpagarTemp
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
     * Set iva
     *
     * @param string $iva
     *
     * @return CjDocumentoporpagarTemp
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
}

