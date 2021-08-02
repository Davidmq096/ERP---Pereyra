<?php

namespace AppBundle\Entity;

/**
 * BrReactivo
 */
class BrReactivo
{
    /**
     * @var float
     */
    private $valor;

    /**
     * @var boolean
     */
    private $activo = '0';

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $bibliografia;

    /**
     * @var string
     */
    private $clave;

    /**
     * @var string
     */
    private $ambitoseje;

    /**
     * @var integer
     */
    private $reactivoid;

    /**
     * @var \AppBundle\Entity\BrBloqueunidad
     */
    private $bloqueunidadid;

    /**
     * @var \AppBundle\Entity\BrCampoformacion
     */
    private $campoformacionid;

    /**
     * @var \AppBundle\Entity\BrEstatusreactivo
     */
    private $estatusreactivoid;

    /**
     * @var \AppBundle\Entity\BrGradodificultad
     */
    private $gradodificultadid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\BrNiveltaxonomico
     */
    private $niveltaxonomicoid;

    /**
     * @var \AppBundle\Entity\BrSubtema
     */
    private $subtemaid;

    /**
     * @var \AppBundle\Entity\BrTipoexamen
     */
    private $tipoexamenid;

    /**
     * @var \AppBundle\Entity\BrTiporeactivo
     */
    private $tiporeactivoid;


    /**
     * Set valor
     *
     * @param float $valor
     *
     * @return BrReactivo
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BrReactivo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BrReactivo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set bibliografia
     *
     * @param string $bibliografia
     *
     * @return BrReactivo
     */
    public function setBibliografia($bibliografia)
    {
        $this->bibliografia = $bibliografia;

        return $this;
    }

    /**
     * Get bibliografia
     *
     * @return string
     */
    public function getBibliografia()
    {
        return $this->bibliografia;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return BrReactivo
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set ambitoseje
     *
     * @param string $ambitoseje
     *
     * @return BrReactivo
     */
    public function setAmbitoseje($ambitoseje)
    {
        $this->ambitoseje = $ambitoseje;

        return $this;
    }

    /**
     * Get ambitoseje
     *
     * @return string
     */
    public function getAmbitoseje()
    {
        return $this->ambitoseje;
    }

    /**
     * Get reactivoid
     *
     * @return integer
     */
    public function getReactivoid()
    {
        return $this->reactivoid;
    }

    /**
     * Set bloqueunidadid
     *
     * @param \AppBundle\Entity\BrBloqueunidad $bloqueunidadid
     *
     * @return BrReactivo
     */
    public function setBloqueunidadid(\AppBundle\Entity\BrBloqueunidad $bloqueunidadid = null)
    {
        $this->bloqueunidadid = $bloqueunidadid;

        return $this;
    }

    /**
     * Get bloqueunidadid
     *
     * @return \AppBundle\Entity\BrBloqueunidad
     */
    public function getBloqueunidadid()
    {
        return $this->bloqueunidadid;
    }

    /**
     * Set campoformacionid
     *
     * @param \AppBundle\Entity\BrCampoformacion $campoformacionid
     *
     * @return BrReactivo
     */
    public function setCampoformacionid(\AppBundle\Entity\BrCampoformacion $campoformacionid = null)
    {
        $this->campoformacionid = $campoformacionid;

        return $this;
    }

    /**
     * Get campoformacionid
     *
     * @return \AppBundle\Entity\BrCampoformacion
     */
    public function getCampoformacionid()
    {
        return $this->campoformacionid;
    }

    /**
     * Set estatusreactivoid
     *
     * @param \AppBundle\Entity\BrEstatusreactivo $estatusreactivoid
     *
     * @return BrReactivo
     */
    public function setEstatusreactivoid(\AppBundle\Entity\BrEstatusreactivo $estatusreactivoid = null)
    {
        $this->estatusreactivoid = $estatusreactivoid;

        return $this;
    }

    /**
     * Get estatusreactivoid
     *
     * @return \AppBundle\Entity\BrEstatusreactivo
     */
    public function getEstatusreactivoid()
    {
        return $this->estatusreactivoid;
    }

    /**
     * Set gradodificultadid
     *
     * @param \AppBundle\Entity\BrGradodificultad $gradodificultadid
     *
     * @return BrReactivo
     */
    public function setGradodificultadid(\AppBundle\Entity\BrGradodificultad $gradodificultadid = null)
    {
        $this->gradodificultadid = $gradodificultadid;

        return $this;
    }

    /**
     * Get gradodificultadid
     *
     * @return \AppBundle\Entity\BrGradodificultad
     */
    public function getGradodificultadid()
    {
        return $this->gradodificultadid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return BrReactivo
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
     * Set niveltaxonomicoid
     *
     * @param \AppBundle\Entity\BrNiveltaxonomico $niveltaxonomicoid
     *
     * @return BrReactivo
     */
    public function setNiveltaxonomicoid(\AppBundle\Entity\BrNiveltaxonomico $niveltaxonomicoid = null)
    {
        $this->niveltaxonomicoid = $niveltaxonomicoid;

        return $this;
    }

    /**
     * Get niveltaxonomicoid
     *
     * @return \AppBundle\Entity\BrNiveltaxonomico
     */
    public function getNiveltaxonomicoid()
    {
        return $this->niveltaxonomicoid;
    }

    /**
     * Set subtemaid
     *
     * @param \AppBundle\Entity\BrSubtema $subtemaid
     *
     * @return BrReactivo
     */
    public function setSubtemaid(\AppBundle\Entity\BrSubtema $subtemaid = null)
    {
        $this->subtemaid = $subtemaid;

        return $this;
    }

    /**
     * Get subtemaid
     *
     * @return \AppBundle\Entity\BrSubtema
     */
    public function getSubtemaid()
    {
        return $this->subtemaid;
    }

    /**
     * Set tipoexamenid
     *
     * @param \AppBundle\Entity\BrTipoexamen $tipoexamenid
     *
     * @return BrReactivo
     */
    public function setTipoexamenid(\AppBundle\Entity\BrTipoexamen $tipoexamenid = null)
    {
        $this->tipoexamenid = $tipoexamenid;

        return $this;
    }

    /**
     * Get tipoexamenid
     *
     * @return \AppBundle\Entity\BrTipoexamen
     */
    public function getTipoexamenid()
    {
        return $this->tipoexamenid;
    }

    /**
     * Set tiporeactivoid
     *
     * @param \AppBundle\Entity\BrTiporeactivo $tiporeactivoid
     *
     * @return BrReactivo
     */
    public function setTiporeactivoid(\AppBundle\Entity\BrTiporeactivo $tiporeactivoid = null)
    {
        $this->tiporeactivoid = $tiporeactivoid;

        return $this;
    }

    /**
     * Get tiporeactivoid
     *
     * @return \AppBundle\Entity\BrTiporeactivo
     */
    public function getTiporeactivoid()
    {
        return $this->tiporeactivoid;
    }
}

