<?php

namespace AppBundle\Entity;

/**
 * CjBitacorapagoconbanco
 */
class CjBitacorapagoconbanco
{
    /**
     * @var string
     */
    private $referencia;

    /**
     * @var string
     */
    private $respuesta;

    /**
     * @var string
     */
    private $foliocpago;

    /**
     * @var string
     */
    private $auth;

    /**
     * @var string
     */
    private $cdrespuesta;

    /**
     * @var string
     */
    private $cderror;

    /**
     * @var string
     */
    private $nberror;

    /**
     * @var \DateTime
     */
    private $hora;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $empresa;

    /**
     * @var string
     */
    private $comerciante;

    /**
     * @var string
     */
    private $banco;

    /**
     * @var string
     */
    private $operacion;

    /**
     * @var string
     */
    private $ccnombre;

    /**
     * @var string
     */
    private $ccnumero;

    /**
     * @var string
     */
    private $importe;

    /**
     * @var string
     */
    private $idurl;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var string
     */
    private $xml;

    /**
     * @var string
     */
    private $bancoEmisor;

    /**
     * @var string
     */
    private $servicioBb;

    /**
     * @var string
     */
    private $monto;

    /**
     * @var string
     */
    private $formaPago;

    /**
     * @var string
     */
    private $json;

    /**
     * @var string
     */
    private $accion;

    /**
     * @var string
     */
    private $firma;

    /**
     * @var string
     */
    private $clFolio;

    /**
     * @var string
     */
    private $clReferencia;

    /**
     * @var string
     */
    private $dlMonto;

    /**
     * @var string
     */
    private $dtFechapago;

    /**
     * @var string
     */
    private $nlTipopago;

    /**
     * @var string
     */
    private $nlStatus;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var integer
     */
    private $bitacorapagoconbancoid;


    /**
     * Set referencia
     *
     * @param string $referencia
     *
     * @return CjBitacorapagoconbanco
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
     * Set respuesta
     *
     * @param string $respuesta
     *
     * @return CjBitacorapagoconbanco
     */
    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return string
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set foliocpago
     *
     * @param string $foliocpago
     *
     * @return CjBitacorapagoconbanco
     */
    public function setFoliocpago($foliocpago)
    {
        $this->foliocpago = $foliocpago;

        return $this;
    }

    /**
     * Get foliocpago
     *
     * @return string
     */
    public function getFoliocpago()
    {
        return $this->foliocpago;
    }

    /**
     * Set auth
     *
     * @param string $auth
     *
     * @return CjBitacorapagoconbanco
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Get auth
     *
     * @return string
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * Set cdrespuesta
     *
     * @param string $cdrespuesta
     *
     * @return CjBitacorapagoconbanco
     */
    public function setCdrespuesta($cdrespuesta)
    {
        $this->cdrespuesta = $cdrespuesta;

        return $this;
    }

    /**
     * Get cdrespuesta
     *
     * @return string
     */
    public function getCdrespuesta()
    {
        return $this->cdrespuesta;
    }

    /**
     * Set cderror
     *
     * @param string $cderror
     *
     * @return CjBitacorapagoconbanco
     */
    public function setCderror($cderror)
    {
        $this->cderror = $cderror;

        return $this;
    }

    /**
     * Get cderror
     *
     * @return string
     */
    public function getCderror()
    {
        return $this->cderror;
    }

    /**
     * Set nberror
     *
     * @param string $nberror
     *
     * @return CjBitacorapagoconbanco
     */
    public function setNberror($nberror)
    {
        $this->nberror = $nberror;

        return $this;
    }

    /**
     * Get nberror
     *
     * @return string
     */
    public function getNberror()
    {
        return $this->nberror;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return CjBitacorapagoconbanco
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CjBitacorapagoconbanco
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
     * Set empresa
     *
     * @param string $empresa
     *
     * @return CjBitacorapagoconbanco
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set comerciante
     *
     * @param string $comerciante
     *
     * @return CjBitacorapagoconbanco
     */
    public function setComerciante($comerciante)
    {
        $this->comerciante = $comerciante;

        return $this;
    }

    /**
     * Get comerciante
     *
     * @return string
     */
    public function getComerciante()
    {
        return $this->comerciante;
    }

    /**
     * Set banco
     *
     * @param string $banco
     *
     * @return CjBitacorapagoconbanco
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return string
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Set operacion
     *
     * @param string $operacion
     *
     * @return CjBitacorapagoconbanco
     */
    public function setOperacion($operacion)
    {
        $this->operacion = $operacion;

        return $this;
    }

    /**
     * Get operacion
     *
     * @return string
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * Set ccnombre
     *
     * @param string $ccnombre
     *
     * @return CjBitacorapagoconbanco
     */
    public function setCcnombre($ccnombre)
    {
        $this->ccnombre = $ccnombre;

        return $this;
    }

    /**
     * Get ccnombre
     *
     * @return string
     */
    public function getCcnombre()
    {
        return $this->ccnombre;
    }

    /**
     * Set ccnumero
     *
     * @param string $ccnumero
     *
     * @return CjBitacorapagoconbanco
     */
    public function setCcnumero($ccnumero)
    {
        $this->ccnumero = $ccnumero;

        return $this;
    }

    /**
     * Get ccnumero
     *
     * @return string
     */
    public function getCcnumero()
    {
        return $this->ccnumero;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjBitacorapagoconbanco
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
     * Set idurl
     *
     * @param string $idurl
     *
     * @return CjBitacorapagoconbanco
     */
    public function setIdurl($idurl)
    {
        $this->idurl = $idurl;

        return $this;
    }

    /**
     * Get idurl
     *
     * @return string
     */
    public function getIdurl()
    {
        return $this->idurl;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return CjBitacorapagoconbanco
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
     * Set xml
     *
     * @param string $xml
     *
     * @return CjBitacorapagoconbanco
     */
    public function setXml($xml)
    {
        $this->xml = $xml;

        return $this;
    }

    /**
     * Get xml
     *
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * Set bancoEmisor
     *
     * @param string $bancoEmisor
     *
     * @return CjBitacorapagoconbanco
     */
    public function setBancoEmisor($bancoEmisor)
    {
        $this->bancoEmisor = $bancoEmisor;

        return $this;
    }

    /**
     * Get bancoEmisor
     *
     * @return string
     */
    public function getBancoEmisor()
    {
        return $this->bancoEmisor;
    }

    /**
     * Set servicioBb
     *
     * @param string $servicioBb
     *
     * @return CjBitacorapagoconbanco
     */
    public function setServicioBb($servicioBb)
    {
        $this->servicioBb = $servicioBb;

        return $this;
    }

    /**
     * Get servicioBb
     *
     * @return string
     */
    public function getServicioBb()
    {
        return $this->servicioBb;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return CjBitacorapagoconbanco
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set formaPago
     *
     * @param string $formaPago
     *
     * @return CjBitacorapagoconbanco
     */
    public function setFormaPago($formaPago)
    {
        $this->formaPago = $formaPago;

        return $this;
    }

    /**
     * Get formaPago
     *
     * @return string
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }

    /**
     * Set json
     *
     * @param string $json
     *
     * @return CjBitacorapagoconbanco
     */
    public function setJson($json)
    {
        $this->json = $json;

        return $this;
    }

    /**
     * Get json
     *
     * @return string
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * Set accion
     *
     * @param string $accion
     *
     * @return CjBitacorapagoconbanco
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get accion
     *
     * @return string
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Set firma
     *
     * @param string $firma
     *
     * @return CjBitacorapagoconbanco
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma
     *
     * @return string
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set clFolio
     *
     * @param string $clFolio
     *
     * @return CjBitacorapagoconbanco
     */
    public function setClFolio($clFolio)
    {
        $this->clFolio = $clFolio;

        return $this;
    }

    /**
     * Get clFolio
     *
     * @return string
     */
    public function getClFolio()
    {
        return $this->clFolio;
    }

    /**
     * Set clReferencia
     *
     * @param string $clReferencia
     *
     * @return CjBitacorapagoconbanco
     */
    public function setClReferencia($clReferencia)
    {
        $this->clReferencia = $clReferencia;

        return $this;
    }

    /**
     * Get clReferencia
     *
     * @return string
     */
    public function getClReferencia()
    {
        return $this->clReferencia;
    }

    /**
     * Set dlMonto
     *
     * @param string $dlMonto
     *
     * @return CjBitacorapagoconbanco
     */
    public function setDlMonto($dlMonto)
    {
        $this->dlMonto = $dlMonto;

        return $this;
    }

    /**
     * Get dlMonto
     *
     * @return string
     */
    public function getDlMonto()
    {
        return $this->dlMonto;
    }

    /**
     * Set dtFechapago
     *
     * @param string $dtFechapago
     *
     * @return CjBitacorapagoconbanco
     */
    public function setDtFechapago($dtFechapago)
    {
        $this->dtFechapago = $dtFechapago;

        return $this;
    }

    /**
     * Get dtFechapago
     *
     * @return string
     */
    public function getDtFechapago()
    {
        return $this->dtFechapago;
    }

    /**
     * Set nlTipopago
     *
     * @param string $nlTipopago
     *
     * @return CjBitacorapagoconbanco
     */
    public function setNlTipopago($nlTipopago)
    {
        $this->nlTipopago = $nlTipopago;

        return $this;
    }

    /**
     * Get nlTipopago
     *
     * @return string
     */
    public function getNlTipopago()
    {
        return $this->nlTipopago;
    }

    /**
     * Set nlStatus
     *
     * @param string $nlStatus
     *
     * @return CjBitacorapagoconbanco
     */
    public function setNlStatus($nlStatus)
    {
        $this->nlStatus = $nlStatus;

        return $this;
    }

    /**
     * Get nlStatus
     *
     * @return string
     */
    public function getNlStatus()
    {
        return $this->nlStatus;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return CjBitacorapagoconbanco
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get bitacorapagoconbancoid
     *
     * @return integer
     */
    public function getBitacorapagoconbancoid()
    {
        return $this->bitacorapagoconbancoid;
    }
}

