<?php

namespace AppBundle\Entity;

/**
 * Cupoadmision
 */
class Cupoadmision
{
    /**
     * @var \DateTime
     */
    private $iniciorecepcion;

    /**
     * @var \DateTime
     */
    private $finrecepcion;

    /**
     * @var integer
     */
    private $cupo;

    /**
     * @var integer
     */
    private $cantidadfichas;

    /**
     * @var string
     */
    private $textocompleto;

    /**
     * @var string
     */
    private $textocapturaficha;

    /**
     * @var boolean
     */
    private $listaespera;

    /**
     * @var string
     */
    private $textolistaespera;

    /**
     * @var \DateTime
     */
    private $fechaentregaresultados;

    /**
     * @var \DateTime
     */
    private $fechapagoadeudos;

    /**
     * @var \DateTime
     */
    private $fechaentregainscripcion;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var \DateTime
     */
    private $fechaedad;

    /**
     * @var integer
     */
    private $cupoadmisionid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set iniciorecepcion
     *
     * @param \DateTime $iniciorecepcion
     *
     * @return Cupoadmision
     */
    public function setIniciorecepcion($iniciorecepcion)
    {
        $this->iniciorecepcion = $iniciorecepcion;

        return $this;
    }

    /**
     * Get iniciorecepcion
     *
     * @return \DateTime
     */
    public function getIniciorecepcion()
    {
        return $this->iniciorecepcion;
    }

    /**
     * Set finrecepcion
     *
     * @param \DateTime $finrecepcion
     *
     * @return Cupoadmision
     */
    public function setFinrecepcion($finrecepcion)
    {
        $this->finrecepcion = $finrecepcion;

        return $this;
    }

    /**
     * Get finrecepcion
     *
     * @return \DateTime
     */
    public function getFinrecepcion()
    {
        return $this->finrecepcion;
    }

    /**
     * Set cupo
     *
     * @param integer $cupo
     *
     * @return Cupoadmision
     */
    public function setCupo($cupo)
    {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get cupo
     *
     * @return integer
     */
    public function getCupo()
    {
        return $this->cupo;
    }

    /**
     * Set cantidadfichas
     *
     * @param integer $cantidadfichas
     *
     * @return Cupoadmision
     */
    public function setCantidadfichas($cantidadfichas)
    {
        $this->cantidadfichas = $cantidadfichas;

        return $this;
    }

    /**
     * Get cantidadfichas
     *
     * @return integer
     */
    public function getCantidadfichas()
    {
        return $this->cantidadfichas;
    }

    /**
     * Set textocompleto
     *
     * @param string $textocompleto
     *
     * @return Cupoadmision
     */
    public function setTextocompleto($textocompleto)
    {
        $this->textocompleto = $textocompleto;

        return $this;
    }

    /**
     * Get textocompleto
     *
     * @return string
     */
    public function getTextocompleto()
    {
        return $this->textocompleto;
    }

    /**
     * Set textocapturaficha
     *
     * @param string $textocapturaficha
     *
     * @return Cupoadmision
     */
    public function setTextocapturaficha($textocapturaficha)
    {
        $this->textocapturaficha = $textocapturaficha;

        return $this;
    }

    /**
     * Get textocapturaficha
     *
     * @return string
     */
    public function getTextocapturaficha()
    {
        return $this->textocapturaficha;
    }

    /**
     * Set listaespera
     *
     * @param boolean $listaespera
     *
     * @return Cupoadmision
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
     * Set textolistaespera
     *
     * @param string $textolistaespera
     *
     * @return Cupoadmision
     */
    public function setTextolistaespera($textolistaespera)
    {
        $this->textolistaespera = $textolistaespera;

        return $this;
    }

    /**
     * Get textolistaespera
     *
     * @return string
     */
    public function getTextolistaespera()
    {
        return $this->textolistaespera;
    }

    /**
     * Set fechaentregaresultados
     *
     * @param \DateTime $fechaentregaresultados
     *
     * @return Cupoadmision
     */
    public function setFechaentregaresultados($fechaentregaresultados)
    {
        $this->fechaentregaresultados = $fechaentregaresultados;

        return $this;
    }

    /**
     * Get fechaentregaresultados
     *
     * @return \DateTime
     */
    public function getFechaentregaresultados()
    {
        return $this->fechaentregaresultados;
    }

    /**
     * Set fechapagoadeudos
     *
     * @param \DateTime $fechapagoadeudos
     *
     * @return Cupoadmision
     */
    public function setFechapagoadeudos($fechapagoadeudos)
    {
        $this->fechapagoadeudos = $fechapagoadeudos;

        return $this;
    }

    /**
     * Get fechapagoadeudos
     *
     * @return \DateTime
     */
    public function getFechapagoadeudos()
    {
        return $this->fechapagoadeudos;
    }

    /**
     * Set fechaentregainscripcion
     *
     * @param \DateTime $fechaentregainscripcion
     *
     * @return Cupoadmision
     */
    public function setFechaentregainscripcion($fechaentregainscripcion)
    {
        $this->fechaentregainscripcion = $fechaentregainscripcion;

        return $this;
    }

    /**
     * Get fechaentregainscripcion
     *
     * @return \DateTime
     */
    public function getFechaentregainscripcion()
    {
        return $this->fechaentregainscripcion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Cupoadmision
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
     * Set fechaedad
     *
     * @param \DateTime $fechaedad
     *
     * @return Cupoadmision
     */
    public function setFechaedad($fechaedad)
    {
        $this->fechaedad = $fechaedad;

        return $this;
    }

    /**
     * Get fechaedad
     *
     * @return \DateTime
     */
    public function getFechaedad()
    {
        return $this->fechaedad;
    }

    /**
     * Get cupoadmisionid
     *
     * @return integer
     */
    public function getCupoadmisionid()
    {
        return $this->cupoadmisionid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return Cupoadmision
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
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return Cupoadmision
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
}

