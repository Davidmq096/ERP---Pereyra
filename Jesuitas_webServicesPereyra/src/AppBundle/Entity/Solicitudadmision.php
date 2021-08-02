<?php

namespace AppBundle\Entity;

/**
 * Solicitudadmision
 */
class Solicitudadmision
{
    /**
     * @var string
     */
    private $folio;

    /**
     * @var string
     */
    private $clavesolicitud;

    /**
     * @var string
     */
    private $clavefamiliar;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var boolean
     */
    private $aceptado;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var boolean
     */
    private $listaespera;

    /**
     * @var integer
     */
    private $pendiente;

    /**
     * @var string
     */
    private $nombrepersonacaptura;

    /**
     * @var boolean
     */
    private $entregada;

    /**
     * @var boolean
     */
    private $impresa;

    /**
     * @var boolean
     */
    private $correoenviado;

    /**
     * @var boolean
     */
    private $capturainternet;

    /**
     * @var \DateTime
     */
    private $fechacaptura;

    /**
     * @var \DateTime
     */
    private $fechavalidacion;

    /**
     * @var \DateTime
     */
    private $fechadictaminacion;

    /**
     * @var boolean
     */
    private $solicitudpagada;

    /**
     * @var boolean
     */
    private $documentosfirmados;

    /**
     * @var boolean
     */
    private $pagado = '0';

    /**
     * @var boolean
     */
    private $solicitudextemporanea;

    /**
     * @var integer
     */
    private $solicitudadmisionid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Contacto
     */
    private $contactoid;

    /**
     * @var \AppBundle\Entity\Datoaspirante
     */
    private $datoaspiranteid;

    /**
     * @var \AppBundle\Entity\Encuesta
     */
    private $encuestaid;

    /**
     * @var \AppBundle\Entity\Estatussolicitud
     */
    private $estatussolicitudid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\Infoadicional
     */
    private $infoadicionalid;

    /**
     * @var \AppBundle\Entity\Parentesco
     */
    private $parentescoidpersonacaptura;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $validadopor;


    /**
     * Set folio
     *
     * @param string $folio
     *
     * @return Solicitudadmision
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
     * Set clavesolicitud
     *
     * @param string $clavesolicitud
     *
     * @return Solicitudadmision
     */
    public function setClavesolicitud($clavesolicitud)
    {
        $this->clavesolicitud = $clavesolicitud;

        return $this;
    }

    /**
     * Get clavesolicitud
     *
     * @return string
     */
    public function getClavesolicitud()
    {
        return $this->clavesolicitud;
    }

    /**
     * Set clavefamiliar
     *
     * @param string $clavefamiliar
     *
     * @return Solicitudadmision
     */
    public function setClavefamiliar($clavefamiliar)
    {
        $this->clavefamiliar = $clavefamiliar;

        return $this;
    }

    /**
     * Get clavefamiliar
     *
     * @return string
     */
    public function getClavefamiliar()
    {
        return $this->clavefamiliar;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Solicitudadmision
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
     * Set aceptado
     *
     * @param boolean $aceptado
     *
     * @return Solicitudadmision
     */
    public function setAceptado($aceptado)
    {
        $this->aceptado = $aceptado;

        return $this;
    }

    /**
     * Get aceptado
     *
     * @return boolean
     */
    public function getAceptado()
    {
        return $this->aceptado;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return Solicitudadmision
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set listaespera
     *
     * @param boolean $listaespera
     *
     * @return Solicitudadmision
     */
    public function setListaespera($listaespera)
    {
        $this->listaespera = $listaespera;

        return $this;
    }

    /**
     * Get listaespera
     *
     * @return boolean
     */
    public function getListaespera()
    {
        return $this->listaespera;
    }

    /**
     * Set pendiente
     *
     * @param integer $pendiente
     *
     * @return Solicitudadmision
     */
    public function setPendiente($pendiente)
    {
        $this->pendiente = $pendiente;

        return $this;
    }

    /**
     * Get pendiente
     *
     * @return integer
     */
    public function getPendiente()
    {
        return $this->pendiente;
    }

    /**
     * Set nombrepersonacaptura
     *
     * @param string $nombrepersonacaptura
     *
     * @return Solicitudadmision
     */
    public function setNombrepersonacaptura($nombrepersonacaptura)
    {
        $this->nombrepersonacaptura = $nombrepersonacaptura;

        return $this;
    }

    /**
     * Get nombrepersonacaptura
     *
     * @return string
     */
    public function getNombrepersonacaptura()
    {
        return $this->nombrepersonacaptura;
    }

    /**
     * Set entregada
     *
     * @param boolean $entregada
     *
     * @return Solicitudadmision
     */
    public function setEntregada($entregada)
    {
        $this->entregada = $entregada;

        return $this;
    }

    /**
     * Get entregada
     *
     * @return boolean
     */
    public function getEntregada()
    {
        return $this->entregada;
    }

    /**
     * Set impresa
     *
     * @param boolean $impresa
     *
     * @return Solicitudadmision
     */
    public function setImpresa($impresa)
    {
        $this->impresa = $impresa;

        return $this;
    }

    /**
     * Get impresa
     *
     * @return boolean
     */
    public function getImpresa()
    {
        return $this->impresa;
    }

    /**
     * Set correoenviado
     *
     * @param boolean $correoenviado
     *
     * @return Solicitudadmision
     */
    public function setCorreoenviado($correoenviado)
    {
        $this->correoenviado = $correoenviado;

        return $this;
    }

    /**
     * Get correoenviado
     *
     * @return boolean
     */
    public function getCorreoenviado()
    {
        return $this->correoenviado;
    }

    /**
     * Set capturainternet
     *
     * @param boolean $capturainternet
     *
     * @return Solicitudadmision
     */
    public function setCapturainternet($capturainternet)
    {
        $this->capturainternet = $capturainternet;

        return $this;
    }

    /**
     * Get capturainternet
     *
     * @return boolean
     */
    public function getCapturainternet()
    {
        return $this->capturainternet;
    }

    /**
     * Set fechacaptura
     *
     * @param \DateTime $fechacaptura
     *
     * @return Solicitudadmision
     */
    public function setFechacaptura($fechacaptura)
    {
        $this->fechacaptura = $fechacaptura;

        return $this;
    }

    /**
     * Get fechacaptura
     *
     * @return \DateTime
     */
    public function getFechacaptura()
    {
        return $this->fechacaptura;
    }

    /**
     * Set fechavalidacion
     *
     * @param \DateTime $fechavalidacion
     *
     * @return Solicitudadmision
     */
    public function setFechavalidacion($fechavalidacion)
    {
        $this->fechavalidacion = $fechavalidacion;

        return $this;
    }

    /**
     * Get fechavalidacion
     *
     * @return \DateTime
     */
    public function getFechavalidacion()
    {
        return $this->fechavalidacion;
    }

    /**
     * Set fechadictaminacion
     *
     * @param \DateTime $fechadictaminacion
     *
     * @return Solicitudadmision
     */
    public function setFechadictaminacion($fechadictaminacion)
    {
        $this->fechadictaminacion = $fechadictaminacion;

        return $this;
    }

    /**
     * Get fechadictaminacion
     *
     * @return \DateTime
     */
    public function getFechadictaminacion()
    {
        return $this->fechadictaminacion;
    }

    /**
     * Set solicitudpagada
     *
     * @param boolean $solicitudpagada
     *
     * @return Solicitudadmision
     */
    public function setSolicitudpagada($solicitudpagada)
    {
        $this->solicitudpagada = $solicitudpagada;

        return $this;
    }

    /**
     * Get solicitudpagada
     *
     * @return boolean
     */
    public function getSolicitudpagada()
    {
        return $this->solicitudpagada;
    }

    /**
     * Set documentosfirmados
     *
     * @param boolean $documentosfirmados
     *
     * @return Solicitudadmision
     */
    public function setDocumentosfirmados($documentosfirmados)
    {
        $this->documentosfirmados = $documentosfirmados;

        return $this;
    }

    /**
     * Get documentosfirmados
     *
     * @return boolean
     */
    public function getDocumentosfirmados()
    {
        return $this->documentosfirmados;
    }

    /**
     * Set pagado
     *
     * @param boolean $pagado
     *
     * @return Solicitudadmision
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;

        return $this;
    }

    /**
     * Get pagado
     *
     * @return boolean
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * Set solicitudextemporanea
     *
     * @param boolean $solicitudextemporanea
     *
     * @return Solicitudadmision
     */
    public function setSolicitudextemporanea($solicitudextemporanea)
    {
        $this->solicitudextemporanea = $solicitudextemporanea;

        return $this;
    }

    /**
     * Get solicitudextemporanea
     *
     * @return boolean
     */
    public function getSolicitudextemporanea()
    {
        return $this->solicitudextemporanea;
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
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return Solicitudadmision
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
     * Set contactoid
     *
     * @param \AppBundle\Entity\Contacto $contactoid
     *
     * @return Solicitudadmision
     */
    public function setContactoid(\AppBundle\Entity\Contacto $contactoid = null)
    {
        $this->contactoid = $contactoid;

        return $this;
    }

    /**
     * Get contactoid
     *
     * @return \AppBundle\Entity\Contacto
     */
    public function getContactoid()
    {
        return $this->contactoid;
    }

    /**
     * Set datoaspiranteid
     *
     * @param \AppBundle\Entity\Datoaspirante $datoaspiranteid
     *
     * @return Solicitudadmision
     */
    public function setDatoaspiranteid(\AppBundle\Entity\Datoaspirante $datoaspiranteid = null)
    {
        $this->datoaspiranteid = $datoaspiranteid;

        return $this;
    }

    /**
     * Get datoaspiranteid
     *
     * @return \AppBundle\Entity\Datoaspirante
     */
    public function getDatoaspiranteid()
    {
        return $this->datoaspiranteid;
    }

    /**
     * Set encuestaid
     *
     * @param \AppBundle\Entity\Encuesta $encuestaid
     *
     * @return Solicitudadmision
     */
    public function setEncuestaid(\AppBundle\Entity\Encuesta $encuestaid = null)
    {
        $this->encuestaid = $encuestaid;

        return $this;
    }

    /**
     * Get encuestaid
     *
     * @return \AppBundle\Entity\Encuesta
     */
    public function getEncuestaid()
    {
        return $this->encuestaid;
    }

    /**
     * Set estatussolicitudid
     *
     * @param \AppBundle\Entity\Estatussolicitud $estatussolicitudid
     *
     * @return Solicitudadmision
     */
    public function setEstatussolicitudid(\AppBundle\Entity\Estatussolicitud $estatussolicitudid = null)
    {
        $this->estatussolicitudid = $estatussolicitudid;

        return $this;
    }

    /**
     * Get estatussolicitudid
     *
     * @return \AppBundle\Entity\Estatussolicitud
     */
    public function getEstatussolicitudid()
    {
        return $this->estatussolicitudid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return Solicitudadmision
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
     * Set infoadicionalid
     *
     * @param \AppBundle\Entity\Infoadicional $infoadicionalid
     *
     * @return Solicitudadmision
     */
    public function setInfoadicionalid(\AppBundle\Entity\Infoadicional $infoadicionalid = null)
    {
        $this->infoadicionalid = $infoadicionalid;

        return $this;
    }

    /**
     * Get infoadicionalid
     *
     * @return \AppBundle\Entity\Infoadicional
     */
    public function getInfoadicionalid()
    {
        return $this->infoadicionalid;
    }

    /**
     * Set parentescoidpersonacaptura
     *
     * @param \AppBundle\Entity\Parentesco $parentescoidpersonacaptura
     *
     * @return Solicitudadmision
     */
    public function setParentescoidpersonacaptura(\AppBundle\Entity\Parentesco $parentescoidpersonacaptura = null)
    {
        $this->parentescoidpersonacaptura = $parentescoidpersonacaptura;

        return $this;
    }

    /**
     * Get parentescoidpersonacaptura
     *
     * @return \AppBundle\Entity\Parentesco
     */
    public function getParentescoidpersonacaptura()
    {
        return $this->parentescoidpersonacaptura;
    }

    /**
     * Set validadopor
     *
     * @param \AppBundle\Entity\Usuario $validadopor
     *
     * @return Solicitudadmision
     */
    public function setValidadopor(\AppBundle\Entity\Usuario $validadopor = null)
    {
        $this->validadopor = $validadopor;

        return $this;
    }

    /**
     * Get validadopor
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getValidadopor()
    {
        return $this->validadopor;
    }
}

