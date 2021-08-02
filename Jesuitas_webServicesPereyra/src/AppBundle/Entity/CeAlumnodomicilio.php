<?php

namespace AppBundle\Entity;

/**
 * CeAlumnodomicilio
 */
class CeAlumnodomicilio
{
    /**
     * @var boolean
     */
    private $esfiscal;

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
    private $alumnodomicilioid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Set esfiscal
     *
     * @param boolean $esfiscal
     *
     * @return CeAlumnodomicilio
     */
    public function setEsfiscal($esfiscal)
    {
        $this->esfiscal = $esfiscal;

        return $this;
    }

    /**
     * Get esfiscal
     *
     * @return boolean
     */
    public function getEsfiscal()
    {
        return $this->esfiscal;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return CeAlumnodomicilio
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
     * @return CeAlumnodomicilio
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
     * @return CeAlumnodomicilio
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
     * @return CeAlumnodomicilio
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
     * @return CeAlumnodomicilio
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
     * @return CeAlumnodomicilio
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
     * @return CeAlumnodomicilio
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
     * Get alumnodomicilioid
     *
     * @return integer
     */
    public function getAlumnodomicilioid()
    {
        return $this->alumnodomicilioid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnodomicilio
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
}

