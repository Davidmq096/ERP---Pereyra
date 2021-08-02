<?php

namespace AppBundle\Entity;

/**
 * CePadresotutoresdomicilio
 */
class CePadresotutoresdomicilio
{
    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $numeroexterior = '';

    /**
     * @var string
     */
    private $numerointerior = '';

    /**
     * @var string
     */
    private $colonia;

    /**
     * @var integer
     */
    private $ciudad;

    /**
     * @var string
     */
    private $codigopostal;

    /**
     * @var string
     */
    private $observaciones = '';

    /**
     * @var integer
     */
    private $padresotutoresdomicilioid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;


    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return CePadresotutoresdomicilio
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
     * @return CePadresotutoresdomicilio
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
     * @return CePadresotutoresdomicilio
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
     * Set colonia
     *
     * @param string $colonia
     *
     * @return CePadresotutoresdomicilio
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get colonia
     *
     * @return string
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set ciudad
     *
     * @param integer $ciudad
     *
     * @return CePadresotutoresdomicilio
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return integer
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set codigopostal
     *
     * @param string $codigopostal
     *
     * @return CePadresotutoresdomicilio
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CePadresotutoresdomicilio
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Get padresotutoresdomicilioid
     *
     * @return integer
     */
    public function getPadresotutoresdomicilioid()
    {
        return $this->padresotutoresdomicilioid;
    }

    /**
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return CePadresotutoresdomicilio
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = null)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }
}

