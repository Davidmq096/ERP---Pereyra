<?php

namespace AppBundle\Entity;

/**
 * BcDomicilioestudiosocioeconomico
 */
class BcDomicilioestudiosocioeconomico
{
    /**
     * @var string
     */
    private $codigopostal;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $numeroexterior;

    /**
     * @var string
     */
    private $numerointerior;

    /**
     * @var string
     */
    private $otracolonia;

    /**
     * @var string
     */
    private $entrecalles;

    /**
     * @var string
     */
    private $telefonocasa;

    /**
     * @var integer
     */
    private $domicilioestudiosocioeconomicoid;

    /**
     * @var \AppBundle\Entity\Estado
     */
    private $estadoid;

    /**
     * @var \AppBundle\Entity\Municipio
     */
    private $municipioid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;

    /**
     * @var \AppBundle\Entity\Colonia
     */
    private $coloniaid;

    /**
     * @var \AppBundle\Entity\Pais
     */
    private $paisid;


    /**
     * Set codigopostal
     *
     * @param string $codigopostal
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setCodigopostal($codigopostal)
    {
        $this->codigopostal = $codigopostal;

        return $this;
    }

    /**
     * Get codigopostal
     *
     * @return string
     */
    public function getCodigopostal()
    {
        return $this->codigopostal;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numeroexterior
     *
     * @param string $numeroexterior
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setNumeroexterior($numeroexterior)
    {
        $this->numeroexterior = $numeroexterior;

        return $this;
    }

    /**
     * Get numeroexterior
     *
     * @return string
     */
    public function getNumeroexterior()
    {
        return $this->numeroexterior;
    }

    /**
     * Set numerointerior
     *
     * @param string $numerointerior
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setNumerointerior($numerointerior)
    {
        $this->numerointerior = $numerointerior;

        return $this;
    }

    /**
     * Get numerointerior
     *
     * @return string
     */
    public function getNumerointerior()
    {
        return $this->numerointerior;
    }

    /**
     * Set otracolonia
     *
     * @param string $otracolonia
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setOtracolonia($otracolonia)
    {
        $this->otracolonia = $otracolonia;

        return $this;
    }

    /**
     * Get otracolonia
     *
     * @return string
     */
    public function getOtracolonia()
    {
        return $this->otracolonia;
    }

    /**
     * Set entrecalles
     *
     * @param string $entrecalles
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setEntrecalles($entrecalles)
    {
        $this->entrecalles = $entrecalles;

        return $this;
    }

    /**
     * Get entrecalles
     *
     * @return string
     */
    public function getEntrecalles()
    {
        return $this->entrecalles;
    }

    /**
     * Set telefonocasa
     *
     * @param string $telefonocasa
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setTelefonocasa($telefonocasa)
    {
        $this->telefonocasa = $telefonocasa;

        return $this;
    }

    /**
     * Get telefonocasa
     *
     * @return string
     */
    public function getTelefonocasa()
    {
        return $this->telefonocasa;
    }

    /**
     * Get domicilioestudiosocioeconomicoid
     *
     * @return integer
     */
    public function getDomicilioestudiosocioeconomicoid()
    {
        return $this->domicilioestudiosocioeconomicoid;
    }

    /**
     * Set estadoid
     *
     * @param \AppBundle\Entity\Estado $estadoid
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setEstadoid(\AppBundle\Entity\Estado $estadoid = null)
    {
        $this->estadoid = $estadoid;

        return $this;
    }

    /**
     * Get estadoid
     *
     * @return \AppBundle\Entity\Estado
     */
    public function getEstadoid()
    {
        return $this->estadoid;
    }

    /**
     * Set municipioid
     *
     * @param \AppBundle\Entity\Municipio $municipioid
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setMunicipioid(\AppBundle\Entity\Municipio $municipioid = null)
    {
        $this->municipioid = $municipioid;

        return $this;
    }

    /**
     * Get municipioid
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioid()
    {
        return $this->municipioid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setSolicitudid(\AppBundle\Entity\BcSolicitudbeca $solicitudid = null)
    {
        $this->solicitudid = $solicitudid;

        return $this;
    }

    /**
     * Get solicitudid
     *
     * @return \AppBundle\Entity\BcSolicitudbeca
     */
    public function getSolicitudid()
    {
        return $this->solicitudid;
    }

    /**
     * Set coloniaid
     *
     * @param \AppBundle\Entity\Colonia $coloniaid
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setColoniaid(\AppBundle\Entity\Colonia $coloniaid = null)
    {
        $this->coloniaid = $coloniaid;

        return $this;
    }

    /**
     * Get coloniaid
     *
     * @return \AppBundle\Entity\Colonia
     */
    public function getColoniaid()
    {
        return $this->coloniaid;
    }

    /**
     * Set paisid
     *
     * @param \AppBundle\Entity\Pais $paisid
     *
     * @return BcDomicilioestudiosocioeconomico
     */
    public function setPaisid(\AppBundle\Entity\Pais $paisid = null)
    {
        $this->paisid = $paisid;

        return $this;
    }

    /**
     * Get paisid
     *
     * @return \AppBundle\Entity\Pais
     */
    public function getPaisid()
    {
        return $this->paisid;
    }
}

